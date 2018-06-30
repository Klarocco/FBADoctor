<?php

class Get_amazon_fba_inventory extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            show_404();
        }
        $this->load->library('amazon');
        $this->load->model('amazon_feedback_report_model');
        $this->load->model('feedback_setting_model');
        $this->load->model('amazon_report_request_log_model');
        $this->load->model('amazon_api_log_model');
        $this->load->model('account_model');
        $this->load->model('feedback_asin_model');
        $this->load->model('feedback_history_model');
        $this->load->model('feedback_order_model');
        $this->load->model('feedback_setting_model');
        $this->load->model('fba_inventory_model');
        $this->load->helper('email');
        $this->load->model('User_model');
        $this->load->model("home_model");
        $this->load->library('rat');
        $this->logging = new Rat();
        $this->cronName = "Get Amazon FBA Inventory Cron";
        $this->template->loadData("activeLink", array("get_amazon_fba_inventory" => array("general" => 1)));
    }

    function index() {
        ini_set('memory_limit', '-1');
        $content = date("d-m-Y H:i:s") . " " . "Get Amazon FBA Inventory Cron Start";
        $this->logging->write_log($this->cronName, $content, 1, 0);
        $result = $this->feedback_setting_model->get_fba_inventory_setting();
        $this->getorderfromamazon($result);
    }
    function getorderfromamazon($result) {
        global $store, $AMAZON_SERVICE_URL;
        foreach ($result->result() as $row) {
            $feedStatus = 1;
            $ReportRequestId = "";
            $GeneratedReportId = '';
            $customer = $this->User_model->get_user_by_Account_id($row->ID_ACCOUNT);
            $store[$row->amazonstorename]['ID_ACCOUNT'] = $row->ID_ACCOUNT;
            $store[$row->amazonstorename]['merchantId'] = $row->mws_sellerid; //Merchant ID for this store
            $store[$row->amazonstorename]['marketplaceId'] = $row->marketplace_id; //Marketplace ID for this store
            $store[$row->amazonstorename]['keyId'] = $row->access_key; //Access Key ID
            $store[$row->amazonstorename]['secretKey'] = $row->secret_key; //Secret Access Key for this store
            $store[$row->amazonstorename]['MWSAuthToken'] = $row->mws_authtoken; //Secret Access Key for this store
            $AMAZON_SERVICE_URL = $row->host;
            $searchArrayLogRow = array('status !=' => 2, 'reporttype =' => '_GET_FBA_MYI_UNSUPPRESSED_INVENTORY_DATA_', 'ID_ACCOUNT =' => $row->ID_ACCOUNT);
            $logRow = $this->amazon_report_request_log_model->get_log_result($searchArrayLogRow);
            if (!empty($logRow->requestid))
                $ReportRequestId = $logRow->requestid;
            if (empty($ReportRequestId)) {
                try {
                    echo 'Getting fba inventory data.....';
                    // Request the seller fba inventory report
                    $objAmazonFeedbackReportRequest = new AmazonReportRequest($row->amazonstorename);
                    $date= date('Y-m-d H:i:s');
                    $previousDate = date('Y-m-d', strtotime($date .' -1 day'));
                    $startDate = $previousDate." 00:00:01";
                    $endDate = $previousDate." 23:59:59";
                    $objAmazonFeedbackReportRequest->setTimeLimits($startDate,$endDate);
                    $objAmazonFeedbackReportRequest->setReportType("_GET_FBA_MYI_UNSUPPRESSED_INVENTORY_DATA_");
                    $objAmazonFeedbackReportRequest->requestReport();
                    $response = $objAmazonFeedbackReportRequest->getResponse();
                    $feedStatus = 0;
                    $fulldataload=0;
                    if (!empty($response['ReportRequestId'])) {
                        $ReportRequestId = $response['ReportRequestId'];
                        $feedStatus = 1;
                        if ($response['ReportProcessingStatus'] == '_DONE_NO_DATA_' || $response['ReportProcessingStatus'] == '_CANCELLED_') {
                            echo 'No Data!!!!!!';
                            $feedStatus = 2;
                        }
                        if ($response['ReportProcessingStatus'] == '_DONE_NO_DATA_' || $response['ReportProcessingStatus'] == '_DONE_' && $row->loadfirstfbainventory = 0) {
                            $fulldataload = 1;
                            $feedStatus = 2;
                            $t = time();
                            $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                                'api_fbainventorydate' => $t
                            ));
                        }

                        $t = time();
                        // Insert the report
                        $addReportRequestLogParams = array(
                            'ID_ACCOUNT' => $row->ID_ACCOUNT,
                            'logdate' => $t,
                            'reporttype' => '_GET_FBA_MYI_UNSUPPRESSED_INVENTORY_DATA_',
                            'requestid' => $ReportRequestId,
                            'fulldataload' => $fulldataload,
                            'status' => $feedStatus
                        );
                        $this->amazon_report_request_log_model->add_amazon_report_request_log($addReportRequestLogParams);
                        if ($fulldataload == 1) {
                            $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                                'loadfirstfbainventory' => 1,
                                'hourlimit_fbainventory' => 'hourlimit_fbainventory+1'
                            ));
                        }
                    }
                    $this->amazon_api_log_model->add_amazon_api_log($row->ID_ACCOUNT, 'getfbainventory2');
                } catch (Exception $ex) {
                    $feedStatus = 0;
                    $content = date("d-m-Y H:i:s") . " " . "Get FBA Inventory Cron Start". ":RequestReportList " . $ex->getMessage();
                    $this->logging->write_log($this->cronName, $content, 1, 0);
                }
            }
            // Get
            if ($feedStatus == 1 && !empty($ReportRequestId) && empty($GeneratedReportId)) {
//                sleep(2);
                // Get GeneratedReportId
                try {
                    echo 'Getting generated report id';
                    $objAmazonFeedbackReport = new AmazonReportRequestList($row->amazonstorename);
                    $objAmazonFeedbackReport->setRequestIds($ReportRequestId);
                    $works = $objAmazonFeedbackReport->fetchRequestList();
                    $response = $objAmazonFeedbackReport->getList();
                    $feedStatus = 0;
                    if (!empty($response[0]['GeneratedReportId'])) {
                        $GeneratedReportId = $response[0]['GeneratedReportId'];
                        $feedStatus = 1;
                    }
                    if ($response[0]['ReportProcessingStatus'] == '_DONE_NO_DATA_' || $response[0]['ReportProcessingStatus'] == '_CANCELLED_') {
                        echo 'No Data!!!!!!';
                        $feedStatus = 2;
                        if (!empty($logRow->ID_LOG)) {
                            $this->amazon_report_request_log_model->custom_where_update_amazon_report_request_log(array('ID_LOG =' => $logRow->ID_LOG), array(
                                'status' => '2'
                            ));
                            // Mark Completed
                            $t = time();
                            $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                                'api_fbainventorydate' => $t
                            ));
                        }
                    }

                    $this->amazon_api_log_model->add_amazon_api_log($row->ID_ACCOUNT, 'getfbainventory3');
                    $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array('hourlimit_fbainventory' => "hourlimit_fbainventory + 1"));
                } catch (Exception $ex) {
                    $feedStatus = 0;
                    $content = date("d-m-Y H:i:s") . " " . "Get FBA Inventory Cron Start". ":RequestReportList " . $ex->getMessage();
                    $this->logging->write_log($this->cronName, $content, 1, 0);
                }
            }
            // Last Step Get the Report
            if ($feedStatus == 1 && !empty($GeneratedReportId)) {
                sleep(2);
                try {
                    echo 'Getting report';
                    $this->amazon_api_log_model->add_amazon_api_log($row->ID_ACCOUNT, 'getfbainventory4');
                    $objAmazonFeedbackReport = new AmazonReport($row->amazonstorename);
                    $objAmazonFeedbackReport->setReportId($GeneratedReportId);
                    $objAmazonFeedbackReport->fetchReport();
                    $data = $objAmazonFeedbackReport->returnReport();
                    if (!empty($data)) {
                        $dateLogFull = time();
                        //	print_r($data);
                        $lineCount = 0;
                        $arrfeedId = array();
                        $tmp = explode("\n", $data);
                        foreach ($tmp as $line) {
                            if ($lineCount > 0) {
                                $fieldData = explode("\t", $line);
                                if (empty($fieldData[0]))
                                    continue;
                                $sku = $fieldData[0];
                                $fnsku = $fieldData[1];
                                $asin = $fieldData[2];
                                $product_name = $fieldData[3];
                                $condition = $fieldData[4];
                                $your_price = $fieldData[5];
                                $mfn_listing_exists = $fieldData[6];
                                $mfn_fulfillable_quantity = $fieldData[7];
                                $afn_listing_exists = $fieldData[8];
                                $afn_warehouse_quantity = $fieldData[9];
                                $afn_fulfillable_quantity = $fieldData[10];
                                $afn_unsellable_quantity = $fieldData[11];
                                $afn_reserved_quantity = $fieldData[12];
                                $afn_total_quantity = $fieldData[13];
                                $per_unit_volume = $fieldData[14];
                                $afn_inbound_working_quantity = $fieldData[15];
                                $afn_inbound_shipped_quantity = $fieldData[16];
                                $afn_inbound_receiving_quantity = $fieldData[17];
                                $queryArray['ID_ACCOUNT'] = $row->ID_ACCOUNT;
                                $queryArray['fnsku'] = $fnsku;
                                $totalRow = $this->fba_inventory_model->custom_count_fba_inventory($queryArray);
                                if ($totalRow == 0 && !empty($fnsku)) {
                                    $t = time();
                                    // Insert into database if it is unique
                                    $fbaParam = array(
                                        'ID_ACCOUNT' => $row->ID_ACCOUNT,
                                        'sku' => $sku,
                                        'fnsku' => $fnsku,
                                        'asin' => $asin,
                                        'product_name' => $product_name,
                                        'product_condition' => $condition,
                                        'your_price' => $your_price,
                                        'mfn_listing_exists' => $mfn_listing_exists,
                                        'mfn_fulfillable_quantity' => $mfn_fulfillable_quantity,
                                        'afn_listing_exists' => $afn_listing_exists,
                                        'afn_warehouse_quantity' => $afn_warehouse_quantity,
                                        'afn_fulfillable_quantity' => $afn_fulfillable_quantity,
                                        'afn_unsellable_quantity' => $afn_unsellable_quantity,
                                        'afn_reserved_quantity' => $afn_reserved_quantity,
                                        'afn_total_quantity' => $afn_total_quantity,
                                        'per_unit_volume' => $per_unit_volume,
                                        'afn_inbound_working_quantity' => $afn_inbound_working_quantity,
                                        'afn_inbound_shipped_quantity' => $afn_inbound_shipped_quantity,
                                        'afn_inbound_receiving_quantity' => $afn_inbound_receiving_quantity,
                                    );
                                    // Update order as having bad feedback
                                    $arrinventoryId[] = $this->fba_inventory_model->insert_fba_inventory($fbaParam);

                                }
                            } // end iflinecount
                            $lineCount++;
                        } // end foreach
                        // Send Digest
                        // Send each one
                        if (!empty($arrinventoryId)) {
                            $strCases = implode(",", $arrinventoryId);
                            $content = "Inventory Id's Added :" . $strCases;
                            $this->logging->write_log($this->cronName, $content, 2, $row->ID_ACCOUNT);
                        }
                    }
                    // Feedback settings date
                    $t = time();
                    $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                        'api_fbainventorydate' => $t,
                        'hourlimit_fbainventory ' => "5"
                    ));
                    // Update the request id
                    $this->amazon_report_request_log_model->custom_where_update_amazon_report_request_log(array('ID_ACCOUNT =' => $row->ID_ACCOUNT, 'requestid =' => $ReportRequestId), array(
                        'status' => '2'
                    ));

                } catch (Exception $ex) {
                    $feedStatus = 0;
                    $content = date("d-m-Y H:i:s") . " " . "Get FBA Inventory Start". ":RequestReportList " . $ex->getMessage();
                    $this->logging->write_log($this->cronName, $content, 1, 0);
                }
            }
        }
        $content = date("d-m-Y H:i:s") . " " . "Get FBA Inventory Cron End.";
        $this->logging->write_log($this->cronName, $content, 3, 0);
    }

}
