<?php
class Get_amazon_order_removal_shipment_historical extends CI_Controller
{
    function __construct() {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            show_404();
        }
        $this->load->library('amazon');
        $this->load->model('feedback_fba_order_model');
        $this->load->model('feedback_setting_model');
        $this->load->model('amazon_report_request_log_model');
        $this->load->model('amazon_api_log_model');
        $this->load->model('account_model');
        $this->load->model('feedback_asin_model');
        $this->load->model('Order_removal_model');
        $this->load->model('Customer_shipment_sales_model');
        $this->load->library('rat');
        $this->logging = new Rat();
        $this->cronName = "Historical Order Removal Shipment Cron";
    }
    function index()
    {
        $content = date("d-m-Y H:i:s") . " " . "Historical Order Removal Shipment Cron Start";
        $this->logging->write_log($this->cronName, $content, 1, 0);
        $result = $this->feedback_setting_model->get_order_removal_feedback_settings_historical();
        $this->getfbaorderfromamazon($result);
    }
    function getfbaorderfromamazon($result) {
        global $store, $AMAZON_SERVICE_URL;
        foreach ($result->result() as $row) {
            $amzdateiteration= $this->feedback_fba_order_model->getamzdateiterationdata('ShipmentOrderRemovalStatus',$row->ID_ACCOUNT);
            if($amzdateiteration['accountId']==$row->ID_ACCOUNT) {
                echo $amzdateiteration['accountId'];
                $feedStatus = 1;
                $ReportRequestId = "";
                $GeneratedReportId = '';
                $store[$row->amazonstorename]['ID_ACCOUNT'] = $row->ID_ACCOUNT;
                $store[$row->amazonstorename]['merchantId'] = $row->mws_sellerid;
                $store[$row->amazonstorename]['marketplaceId'] = $row->marketplace_id;
                $store[$row->amazonstorename]['keyId'] = $row->access_key;
                $store[$row->amazonstorename]['secretKey'] = $row->secret_key;
                $store[$row->amazonstorename]['MWSAuthToken'] = $row->mws_authtoken;
                $AMAZON_SERVICE_URL = $row->host;
                $searchArrayLogRow = array('status !=' => 2, 'reporttype =' => '_GET_FBA_FULFILLMENT_REMOVAL_SHIPMENT_DETAIL_DATA_', 'ID_ACCOUNT =' => $row->ID_ACCOUNT);
                $logRow = $this->amazon_report_request_log_model->get_log_result($searchArrayLogRow);
                if (!empty($logRow->requestid))
                    $ReportRequestId = $logRow->requestid;
                if (empty($ReportRequestId)) {
                    try {
                        echo 'Getting Historical Order Removal Shipment data';
                        $this->amazon_api_log_model->add_amazon_api_log($row->ID_ACCOUNT, 'getorderdata1');
                        $objAmazonReportRequest = new AmazonReportRequest($row->amazonstorename);
                        print_r($objAmazonReportRequest);
                        $objAmazonReportRequest->setTimeLimits($amzdateiteration['startDate'], $amzdateiteration['endDate']);
                        $objAmazonReportRequest->setReportType("_GET_FBA_FULFILLMENT_REMOVAL_SHIPMENT_DETAIL_DATA_");
                        $objAmazonReportRequest->requestReport();
                        $response = $objAmazonReportRequest->getResponse();
                        $feedStatus = 0;
                        $fulldataload = 0;
                        if (!empty($response['ReportRequestId'])) {
                            $ReportRequestId = $response['ReportRequestId'];
                            $feedStatus = 1;
                            if ($response['ReportProcessingStatus'] == '_DONE_NO_DATA_' || $response['ReportProcessingStatus'] == '_CANCELLED_') {
                                echo 'No Data!!!!!!';
                                $feedStatus = 2;
                            }
	                            if ($response['ReportProcessingStatus'] == '_DONE_NO_DATA_' || $response['ReportProcessingStatus'] == '_DONE_' && $row->loadedfirstorderfba = 0) {
                                $fulldataload = 1;
                                $feedStatus = 2;
                                $amzstatus = array('ShipmentOrderRemovalStatus' => '1');
                                $this->feedback_fba_order_model->updateamzdateiteration($amzstatus, $amzdateiteration['logId']);
                            }
                            print_r($response);
                            $t = time();
                             $addReportRequestLogParams = array(
                                'ID_ACCOUNT' => $row->ID_ACCOUNT,
                                'logdate' => $t,
                                'reporttype' => '_GET_FBA_FULFILLMENT_REMOVAL_SHIPMENT_DETAIL_DATA_',
                                'requestid' => $ReportRequestId,
                                'status' => $feedStatus,
                                'fulldataload' => $fulldataload
                            );
                            $this->amazon_report_request_log_model->add_amazon_report_request_log($addReportRequestLogParams);
                            if ($fulldataload == 1) {
                                $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                                    'hourlimit_removalorder' => "hourlimit_removalorder+1",
                                ));
                            }
                        }
                    } catch (Exception $ex) {
                        $feedStatus = 0;
                        $content = date("d-m-Y H:i:s") . " " . "Historical Order Removal Shipment Cron Start" . " :RequestReportList " . $ex->getMessage();
                        $this->logging->write_log($this->cronName, $content, 1, 0);
                    }
                }


                if ($feedStatus == 1 && !empty($ReportRequestId) && empty($GeneratedReportId)) {
                    try {
                        echo 'Getting generated report id';
                        $this->amazon_api_log_model->add_amazon_api_log($row->ID_ACCOUNT, 'getorderdata2');
                        $objAmazonReportRequestList = new AmazonReportRequestList($row->amazonstorename);
                        $objAmazonReportRequestList->setRequestIds($ReportRequestId);
                        $works = $objAmazonReportRequestList->fetchRequestList();
                        $response = $objAmazonReportRequestList->getList();
                        echo "<pre />";
                        print_R($response);
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
                            }
                        }
                        if ($response[0]['ReportProcessingStatus'] == '_DONE_' || $response[0]['ReportProcessingStatus'] == '_DONE_NO_DATA_')
                        {
                            $date=date('Y-m-d', strtotime('-1 day', strtotime($amzdateiteration['startDate'])));
                            if ($date == date('Y-m-d',strtotime($response[0]['StartDate']))) {
                                $amzstatus = array('ShipmentOrderRemovalStatus' => '1');
                                $this->feedback_fba_order_model->updateamzdateiteration($amzstatus, $amzdateiteration['logId']);
                            }
                        }
                        $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                            'hourlimit_removalorder' => "hourlimit_removalorder + 1",
                        ));
                    } catch (Exception $ex) {
                        $feedStatus = 0;
                        $content = date("d-m-Y H:i:s") . " " . "Historical Order Removal Shipment Cron Start" . " :RequestReportList " . $ex->getMessage();
                        $this->logging->write_log($this->cronName, $content, 1, 0);
                    }
                }

                if ($feedStatus == 1 && !empty($GeneratedReportId)) {
                   try {
                        echo 'Getting report';
                        $this->amazon_api_log_model->add_amazon_api_log($row->ID_ACCOUNT, 'getorderdata3');
                        $objAmazonReportRequestList = new AmazonReport($row->amazonstorename);
                        $objAmazonReportRequestList->setReportId($GeneratedReportId);
                        $objAmazonReportRequestList->fetchReport();
                        $data = $objAmazonReportRequestList->returnReport();
                        if (!empty($data)) {
                            $lineCount = 0;
                            $arrorderId = array();
                            $tmp = explode("\n", $data);
                            print_r($tmp);
                            foreach ($tmp as $line) {
                                if ($lineCount > 0) {
                                    $saleschannel = '';
                                    $fieldData = explode("\t", $line);
                                    $request_date = addslashes($fieldData[0]);
                                    $orderID = addslashes($fieldData[1]); // new
                                    $shipment_date = addslashes($fieldData[2]); // new
                                    $sku = addslashes($fieldData[3]); // new
                                    $fnsku = addslashes($fieldData[4]);
                                    $disposition = addslashes($fieldData[5]); // new
                                    $shipped_qty = addslashes($fieldData[6]);
                                    $carrier = addslashes($fieldData[7]);
                                    $tracking_number = addslashes($fieldData[8]);
                                    if (empty($marketplaceidforSalesChannel))
                                        $marketplaceidforSalesChannel = $row->marketplace_id;
                                    $queryArray['ID_ACCOUNT'] = $row->ID_ACCOUNT;
                                    $queryArray['order_id'] = $orderID;
	                                $queryArray['sku'] = $sku;
	                                $queryArray['tracking_number'] = $tracking_number;
	                                $totalRow = $this->Order_removal_model->custom_count_order_removal($queryArray);
                                    if ($totalRow == 0 && !empty($orderID)) {
                                        $orderParam = array(
                                            'ID_ACCOUNT' => $row->ID_ACCOUNT,
                                            'order_id' => $orderID,
                                            'sku' => $sku,
                                            'fnsku' => $fnsku,
                                            'disposition' => $disposition,
                                            'shipped_qty' => $shipped_qty,
                                            'carrier' => $carrier,
                                            'tracking_number' => $tracking_number,
                                            'request_date' => $request_date,
                                            'shipment_date' => $shipment_date
                                        );
                                        echo "<pre/ >";
                                        print_r($orderParam);
                                        $arrorderId[] = $this->Order_removal_model->add_order_removal($orderParam);
                                    }
                                }
                                $lineCount++;
                            }
                            if (!empty($arrorderId)) {
                                $strCases = implode(",", $arrorderId);
                                $content = "Order Removal Id's Added :" . $strCases;
                                $this->logging->write_log($this->cronName, $content, 2, $row->ID_ACCOUNT);
                            }
                        }
                        // Feedback settings date
                        $t = time();
                        $this->feedback_setting_model->update_feedback_setting($row->ID_ACCOUNT, array(
                            'api_removalorder' => $t,
                            'hourlimit_removalorder' => "5"
                        ));
                        // Update the request id
                        $this->amazon_report_request_log_model->custom_where_update_amazon_report_request_log(array('ID_ACCOUNT =' => $row->ID_ACCOUNT, 'requestid =' => $ReportRequestId), array(
                            'status' => '2'
                        ));
                    } catch (Exception $ex) {
                        $feedStatus = 0;
                        $content = date("d-m-Y H:i:s") . " " . "Historical Order Removal Shipment Cron Start" . " :RequestReportList " . $ex->getMessage();
                        $this->logging->write_log($this->cronName, $content, 1, 0);
                    }
                }
            } else{
                $data = array('OrderRemovalStatus' => '1');
                $this->Customer_shipment_sales_model->historycronstatusupdate($data, $row->ID_ACCOUNT);
            }
        }
        $content = date("d-m-Y H:i:s") . " " . "Historical Order Removal Shipment Cron End.";
        $this->logging->write_log($this->cronName, $content, 3, 0);
    }
}
