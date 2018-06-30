<?php

use Dompdf\Dompdf;

class Generate_stripe_charge extends CI_controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            show_404();
        }
        $this->load->library('rat');
        $this->logging = new Rat();
        $this->common->stripe_setting();
        $this->load->model("Ipn_model");
        $this->load->model('user_model');
        $this->load->model("Reimbursement_model");
        $this->load->model("Feedback_setting_model");
        $this->load->model("Affiliate_model");
        $this->load->model("Inventory_salvager_model");
    }

    public function index()
    {
        $cronName = "Generate stripe charges";
        $content = date("d-m-Y H:i:s") . " " . "Generate stripe charges cron Start";
        $this->logging->write_log($cronName, $content, 1, 0);
        $this->generatestripecharge();
    }

    public function generatestripecharge()
    {
        $cronName = "Generate stripe charges";
        $result = $this->user_model->getAllActiveUsersorderbydesc();
        foreach ($result as $new_result)
        {
            $customerCardFour = '';
            $customer = $this->Reimbursement_model->getcustomer($new_result['ID_ACCOUNT']);

            if (!empty( $customer ) )
            {
                $cu = json_decode( json_encode( \Stripe\Customer::Retrieve(
                    array( "id" => $customer[0]['customerid'], "expand" => array( "default_source" ) )
                ) ) );
                $customerCardFour = $cu->default_source->last4;
            }

            if (!empty($customer))
            {
                $affuserID     = $this->Reimbursement_model->getaffuseridbyaccountid( $new_result['ID_ACCOUNT'] );
                $arrCaseID = array();
                $date = date('Y-m-d H:i:s');
                $chargedetail = $this->Reimbursement_model->getchargedetails($new_result['ID_ACCOUNT']);
                $totalUsercase = $this->Reimbursement_model->Useramountcount($new_result['ID_ACCOUNT']);

                $charge_amount = 0;
                $currency = '';
                $payment_id = array();
                if (!empty($chargedetail))
                {
                     foreach ($chargedetail as $chargedetails)
                     {
                        $charge_amount += $chargedetails['amount'];
                        $currency = $chargedetails['currency_unit'];
                        $payment_id[] = $chargedetails['id'];
                     }

                     if($affuserID['ID_REFERRED_BY']>0)
                     {
                         $userCommision = $this->Reimbursement_model->getaffiliateusercommissions($affuserID['ID_REFERRED_BY']);
                         $affcommission  = $charge_amount * $userCommision['affiliate_commission'] / 100;
                         echo "<pre />";
                         print_r( $charge_amount );
                         echo "<pre />";
                         print_r( $affcommission );
                         $AffiliateUser = $this->Reimbursement_model->fetchaffiliatecommissionbyaccountid($affuserID['ID_REFERRED_BY']);
                         $commissionAffuser = $AffiliateUser['commission_total'] + $affcommission;
                         $updatedata        = array(
                             'status'      => '1',
                             'update_date' => date( "Y-m-d H:i:s" )
                         );
                         $this->Affiliate_model->updateaffliateusercurrentrecord( $AffiliateUser['id'],$updatedata );
                         $newCommissionRecord = array(
                             'commission_total' => $commissionAffuser,
                             'ID_ACCOUNT'       => $affuserID['ID_REFERRED_BY'],
                             'user_ref_id'      => $new_result['ID_ACCOUNT'],
                             'status'           => '0',
                             'update_date'      => date("Y-m-d H:i:s")
                         );
                         $this->Affiliate_model->insertnewrecordofaffuser( $newCommissionRecord );
                     }

                    $affiliatecommisioncurrentuser = $this->Affiliate_model->fetchaffiliatecommissionbyaccountid($new_result['ID_ACCOUNT']);
                    $charge_amount_update = $charge_amount - $affiliatecommisioncurrentuser['commission_total'];

                    if ($charge_amount_update < 0 )
                    {
                        $updatedata = array(
                            'used_commission' => $charge_amount,
                            'status'          => '1',
                            'update_date'     => date( "Y-m-d H:i:s" )
                        );
                        $this->Affiliate_model->updateaffliateusercurrentrecord( $affiliatecommisioncurrentuser['id'], $updatedata );
                        $newCommissionRecord = array(
                            'commission_total' => abs( $charge_amount_update ),
                            'ID_ACCOUNT'       => $new_result['ID_ACCOUNT'],
                            'status'           => '0',
                            'user_ref_id'      => '0',
                            'update_date'      => date("Y-m-d H:i:s" )
                        );
                        $this->Affiliate_model->insertnewrecordofaffuser( $newCommissionRecord );
                        $invoiceDetail = array(
                            'first_name'  => $new_result['first_name'],
                            'last_name'   => $new_result['last_name'],
                            'billaddress' => $customer[0]['bill_address'],
                            'phone'       => $customer[0]['bill_phone'],
                            'email'       => $customer[0]['bill_email'],
                            'date'        => $date,
                        );
                        $invoiceID     = $this->Affiliate_model->insertinvoice($invoiceDetail);
                        $detail        = array(
                            'first_name'  => $new_result['first_name'],
                            'last_name'   => $new_result['last_name'],
                            'billaddress' => $customer[0]['bill_address'],
                            'phone'       => $customer[0]['bill_phone'],
                            'email'       => $customer[0]['bill_email'],
                            'date'        => $date,
                            'invoice_id'  => $invoiceID
                        );
                        $title         = "Invoice From FBADoctor";
                        $pdftemplate   = $this->load->view( 'email_template/pdf_template_email.php', array(
                            'detail'        => $detail,
                            'charge_detail' => $chargedetail,
                            'commission'    => $charge_amount,
                        ), true );

                        $pdfPath = realpath($_SERVER['DOCUMENT_ROOT']).'/Downloads/';
                        if (!file_exists( $pdfPath ) )
                        {
                            mkdir( $pdfPath, 777, true );
                        }

                        file_put_contents($pdfPath.'pdfhtmltemplate.html',$pdftemplate );
                        $getFile = base_url() . 'Downloads/pdfhtmltemplate.html';
                        $dompdf = new DOMPDF();
                        $dompdf->loadHtmlFile( $getFile );
                        $dompdf->setPaper('A4','potrait');
                        $dompdf->render();
                        $output = $dompdf->output();
                        $filename = realpath($_SERVER['DOCUMENT_ROOT']).'/Downloads/'.$new_result['first_name']."-". $new_result['ID_ACCOUNT']. "-". $date .".pdf";
                        file_put_contents( $filename, $output );
                        $message = $this->load->view( 'email_template/invoice_email.php', array(
                            'detail'        => $detail,
                            'charge_detail' => $chargedetail,
                            'commission'    => $charge_amount,
                            'customercard'  => $customerCardFour,
                            'totalusercase' => $totalUsercase
                        ), true );
                        $this->common->send_email( $title, $message, $customer[0]['bill_email'], '', $filename );
                        $status = array( 'status' => '1' );
                        $this->Reimbursement_model->updatepaymenthistory( $status, $payment_id );
                    }
                    else
                    {
                        $updatedata = array(
                            'used_commission' => $affiliatecommisioncurrentuser['commission_total'],
                            'status'          => '1',
                            'update_date'     => date( "Y-m-d H:i:s" )
                        );
                        $this->Affiliate_model->updateaffliateusercurrentrecord( $affiliatecommisioncurrentuser['id'], $updatedata );
                        $newCommissionRecord = array(
                            'commission_total' => '0',
                            'ID_ACCOUNT'       => $new_result['ID_ACCOUNT'],
                            'status'           => '0',
                            'user_ref_id'      => '0',
                            'update_date'      => date( "Y-m-d H:i:s" )
                        );
                        $this->Affiliate_model->insertnewrecordofaffuser( $newCommissionRecord );

                        try
                        {
                            $parameter = array(
                                'amount'               => round( $charge_amount_update, 2 ) * 100,
                                'customer'             => $customer[0]['customerid'],
                                'currency'             => $currency,
                                'statement_descriptor' => 'FBADoctor',
                            );
                            $obj = \Stripe\Charge::create($parameter);
                            $amount = ($obj->amount / 100);
                            $stripe_data = array(
                                'ID_ACCOUNT' => $new_result['ID_ACCOUNT'],
                                'striperesponseid' => '123',
                                'amount' => $amount,
                                'date' => $date
                            );
                            $this->Reimbursement_model->addstripecharge($stripe_data);

                            $invoiceDetail = array(
                                'first_name'  => $new_result['first_name'],
                                'last_name'   => $new_result['last_name'],
                                'billaddress' => $customer[0]['bill_address'],
                                'phone'       => $customer[0]['bill_phone'],
                                'email'       => $customer[0]['bill_email'],
                                'date'        => $date,
                            );
                            $invoiceID     = $this->Affiliate_model->insertinvoice( $invoiceDetail );
                            $detail        = array(
                                'first_name'  => $new_result['first_name'],
                                'last_name'   => $new_result['last_name'],
                                'billaddress' => $customer[0]['bill_address'],
                                'phone'       => $customer[0]['bill_phone'],
                                'email'       => $customer[0]['bill_email'],
                                'date'        => $date,
                                'invoice_id'  => $invoiceID
                            );
                            $title         = "Invoice From FBADoctor";
                            $pdftemplate   = $this->load->view( 'email_template/pdf_template_email.php', array(
                                'detail'        => $detail,
                                'charge_detail' => $chargedetail,
                                'commission'    => $affiliatecommisioncurrentuser['commission_total'],
                            ), true );

                            $pdfPath = realpath($_SERVER['DOCUMENT_ROOT']).'/Downloads/';
                            if(!file_exists($pdfPath))
                            {
                                mkdir($pdfPath,0777,TRUE);
                            }

                            file_put_contents($pdfPath.'pdfhtmltemplate.html',$pdftemplate);
                            $getFile = base_url().'Downloads/pdfhtmltemplate.html';
                            $dompdf = new DOMPDF();
                            $dompdf->loadHtmlFile($getFile);
                            $dompdf->setPaper( 'A4', 'potrait' );
                            $dompdf->render();
                            $output = $dompdf->output();
                            $filename = realpath($_SERVER['DOCUMENT_ROOT']).'/Downloads/'.$new_result['first_name'].".pdf";
                            file_put_contents($filename,$output);
                            $message = $this->load->view('email_template/invoice_email.php',array(
                                'detail'        => $detail,
                                'charge_detail' => $chargedetail,
                                'commission'    => $affiliatecommisioncurrentuser['commission_total'],
                                'customercard'  => $customerCardFour,
                                'totalusercase' => $totalUsercase
                            ), true );

                            $this->common->send_email( $title, $message, $customer[0]['bill_email'], '', $filename);
                            $status = array( 'status' => '1' );
                            $this->Reimbursement_model->updatepaymenthistory( $status, $payment_id );
                            $t           = time();
                            $payment_log = array(
                                'userid'    => $new_result['ID_ACCOUNT'],
                                'amount'    => $amount,
                                'timestamp' => $t
                            );
                            $arrCaseID[] = $this->Ipn_model->add_payment( $payment_log );
                        }
                        catch(Exception $e)
                        {
                            $content = "Stripe payment Fail : ".$e;
                            $stripechargefail = array('stripe_charge' => '1');
                            $this->Reimbursement_model->updateStripePaymentFailUser($new_result['ID_ACCOUNT'],$stripechargefail);
                            $this->logging->write_log($cronName, $content, 4, $new_result['ID_ACCOUNT']);
                        }
                     }
                }
                if (!empty($arrCaseID)) {
                    $strCases = implode(",", $arrCaseID);
                    $content = "Generated stripe payment :" . $strCases;
                    $this->logging->write_log($cronName, $content, 2, $new_result['ID_ACCOUNT']);
                }
            }
        }
        $content = date("Y-m-d H:i:s") . " " . "Generate stripe charges cron End";
        $this->logging->write_log($cronName, $content, 3, 0);
    }

}
?>

