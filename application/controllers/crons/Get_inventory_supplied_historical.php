<?php


class Get_inventory_supplied_historical extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->input->is_cli_request())
        {
            show_404();
        }
        $this->load->library( 'amazon' );
        $this->load->library('AmazonInventoryConfig');
        $this->load->model( 'feedback_fba_order_model' );
        $this->load->model( 'feedback_setting_model' );
        $this->load->model( 'amazon_report_request_log_model' );
        $this->load->model( 'amazon_api_log_model' );
        $this->load->model( 'account_model' );
        $this->load->model( "custom_case_model" );
        $this->load->model( 'feedback_asin_model' );
        $this->load->model( 'Refund_rescuer_model' );
        $this->load->model( 'Customer_shipment_sales_model' );
        $this->load->model( 'Inventory_shipment_model' );
        $this->load->library( 'rat' );
        $this->logging  = new Rat();
        $this->cronName = "Get Inventory Supplied Historical";
    }

    public function index()
    {
        $content = date( "d-m-Y H:i:s" ) . " " . "Get Inventory Supplied Historical cron Start";
        $this->logging->write_log( $this->cronName, $content, 1, 0 );
        $result = $this->Inventory_shipment_model->get_inventory_shipment_feedback_setting_historical();
        $this->getinventoryshipment( $result );
    }

    public function getinventoryshipment( $result )
    {
        global $store, $AMAZON_SERVICE_URL;
        foreach ( $result->result_array() as $userAccountDetailArray )
        {
            $t = time();
            $amzdateiteration = $this->feedback_fba_order_model->getamzdateiterationdata( 'InventoryshipmentStatus', $userAccountDetailArray['ID_ACCOUNT'] );
            if(!empty( $amzdateiteration ) )
            {
                echo $amzdateiteration['accountId'];
                $addReportRequestLogParams = array(
                    'ID_ACCOUNT' => $userAccountDetailArray['ID_ACCOUNT'],
                    'logdate'    => $t,
                    'reporttype' => 'Inventory Shipment Supplied Data',
                    'requestid'  => '',
                    'status'     => ''
                );
                $this->amazon_report_request_log_model->add_amazon_report_request_log( $addReportRequestLogParams );
                $store              = '';
                $AMAZON_SERVICE_URL = $userAccountDetailArray['host'] . '/FulfillmentInboundShipment/2010-10-01';

                $config = array(
                    'ServiceURL'    => $AMAZON_SERVICE_URL,
                    'ProxyHost'     => null,
                    'ProxyPort'     => - 1,
                    'ProxyUsername' => null,
                    'ProxyPassword' => null,
                    'MaxErrorRetry' => 3,
                );

                $service               = new FBAInboundServiceMWS_Client(
                    $userAccountDetailArray['access_key'],
                    $userAccountDetailArray['secret_key'],
                    $userAccountDetailArray['amazonstorename'],
                    'V1',
                    $config );


                $inboundShipmentObject = new FBAInboundServiceMWS_Model_ListInboundShipmentsRequest();
                $inboundShipmentObject->setSellerId( $userAccountDetailArray['mws_sellerid'] );
                $inboundShipmentObject->setMWSAuthToken( $userAccountDetailArray['mws_authtoken'] );
                $shipmentStatusList = new FBAInboundServiceMWS_Model_ShipmentStatusList();
                $shipmentStatusList->setmember( array( 'closed' ) );
                $inboundShipmentObject->setShipmentStatusList( $shipmentStatusList );
                $inboundShipmentObject->setLastUpdatedBefore( str_replace( ' ', 'T', $amzdateiteration['endDate'] . 'Z' ) );
                $inboundShipmentObject->setLastUpdatedAfter( str_replace( ' ', 'T', $amzdateiteration['startDate'] . 'Z' ) );
                $responseValue = $this->invokeListInboundShipments( $service, $inboundShipmentObject );
                if ( isset( $responseValue->ListInboundShipmentsResult->ShipmentData->member ) )
                {
                    $ConvertedValue = $responseValue->ListInboundShipmentsResult->ShipmentData->member;
                    if ( is_array( $ConvertedValue ) ) {
                        foreach ( $ConvertedValue as $finalShipmentValue ) {
                            $data                 = array(
                                'ID_ACCOUNT'               => $userAccountDetailArray['ID_ACCOUNT'],
                                'shipment_id'              => $finalShipmentValue->ShipmentId,
                                'shipment_name'            => $finalShipmentValue->ShipmentName,
                                'shipment_address_name'    => $finalShipmentValue->ShipFromAddress->Name,
                                'shipment_city'            => $finalShipmentValue->ShipFromAddress->City,
                                'shipment_postalcode'      => $finalShipmentValue->ShipFromAddress->PostalCode,
                                'shipment_status'          => $finalShipmentValue->ShipmentStatus,
                                'desti_fulfillment_center' => $finalShipmentValue->DestinationFulfillmentCenterId,
                                'shipment_from_date'       => $amzdateiteration['startDate'],
                                'shipment_to_date'         => $amzdateiteration['endDate'],
                            );
                            $insertedID           = $this->Inventory_shipment_model->insert_inventory_shipment_data( $data );
                            $shipmentDetailObject = new FBAInboundServiceMWS_Model_ListInboundShipmentItemsRequest();
                            $shipmentDetailObject->setSellerId( $userAccountDetailArray['mws_sellerid'] );
                            $shipmentDetailObject->setMWSAuthToken( $userAccountDetailArray['mws_authtoken'] );
                            $shipmentDetailObject->setShipmentId( $finalShipmentValue->ShipmentId );
                            $shipmentDetailResponse = $this->invokeListInboundShipmentItems( $service, $shipmentDetailObject );
                            $ConvertedValueDetails  = $shipmentDetailResponse->ListInboundShipmentItemsResult->ItemData->member;
                            echo "<pre/ >";
                            print_r( $ConvertedValueDetails );
                            if ( is_array( $ConvertedValueDetails ) ) {
                                foreach ( $ConvertedValueDetails as $finalShipmentValueDetails ) {
                                    $shipmentDetailValue     = array(
                                        'ID_ACCOUNT'              => $userAccountDetailArray['ID_ACCOUNT'],
                                        'inv_shipment_id'         => $insertedID,
                                        'qty_shipped'             => $finalShipmentValueDetails->QuantityShipped,
                                        'shipment_id'             => $finalShipmentValueDetails->ShipmentId,
                                        'prep_owner'              => (isset($finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepOwner) ? $finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepOwner : '' ),
                                        'prep_instruction'        => (isset($finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepInstruction) ? $finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepInstruction : '' ),
                                        'fulfillment_network_sku' => $finalShipmentValueDetails->FulfillmentNetworkSKU,
                                        'seller_sku'              => $finalShipmentValueDetails->SellerSKU,
                                        'qty_received'            => $finalShipmentValueDetails->QuantityReceived,
                                        'qty_incase'              => $finalShipmentValueDetails->QuantityInCase,
                                        'shipment_from_date'      => $amzdateiteration['startDate'],
                                    );
                                    $inboundShipmentDetail[] = $this->Inventory_shipment_model->insert_inventory_shipment_detail( $shipmentDetailValue );
                                }
                            }
                            else
                            {
                                $shipmentDetailValue     = array(
                                    'ID_ACCOUNT'              => $userAccountDetailArray['ID_ACCOUNT'],
                                    'inv_shipment_id'         => $insertedID,
                                    'qty_shipped'             => $ConvertedValueDetails->QuantityShipped,
                                    'shipment_id'             => $ConvertedValueDetails->ShipmentId,
                                    'prep_owner'              => (isset($ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepOwner) ? $ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepOwner : '' ),
                                    'prep_instruction'        => (isset($ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepInstruction) ? $ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepInstruction : '' ),
                                    'fulfillment_network_sku' => $ConvertedValueDetails->FulfillmentNetworkSKU,
                                    'seller_sku'              => $ConvertedValueDetails->SellerSKU,
                                    'qty_received'            => $ConvertedValueDetails->QuantityReceived,
                                    'qty_incase'              => $ConvertedValueDetails->QuantityInCase,
                                    'shipment_from_date'      => $amzdateiteration['startDate'],
                                );
                                $inboundShipmentDetail[] = $this->Inventory_shipment_model->insert_inventory_shipment_detail( $shipmentDetailValue );
                            }
                        }
                    }
                    else
                    {
                        $data                 = array(
                            'ID_ACCOUNT'               => $userAccountDetailArray['ID_ACCOUNT'],
                            'shipment_id'              => $ConvertedValue->ShipmentId,
                            'shipment_name'            => $ConvertedValue->ShipmentName,
                            'shipment_address_name'    => $ConvertedValue->ShipFromAddress->Name,
                            'shipment_city'            => $ConvertedValue->ShipFromAddress->City,
                            'shipment_postalcode'      => $ConvertedValue->ShipFromAddress->PostalCode,
                            'shipment_status'          => $ConvertedValue->ShipmentStatus,
                            'desti_fulfillment_center' => $ConvertedValue->DestinationFulfillmentCenterId,
                            'shipment_from_date'       => $amzdateiteration['startDate'],
                            'shipment_to_date'         => $amzdateiteration['endDate'],
                        );
                        $insertedID           = $this->Inventory_shipment_model->insert_inventory_shipment_data( $data );
                        $shipmentDetailObject = new FBAInboundServiceMWS_Model_ListInboundShipmentItemsRequest();
                        $shipmentDetailObject->setSellerId( $userAccountDetailArray['mws_sellerid'] );
                        $shipmentDetailObject->setMWSAuthToken( $userAccountDetailArray['mws_authtoken'] );
                        $shipmentDetailObject->setShipmentId( $ConvertedValue->ShipmentId );
                        $shipmentDetailResponse = $this->invokeListInboundShipmentItems( $service, $shipmentDetailObject );
                        $ConvertedValueDetails  = $shipmentDetailResponse->ListInboundShipmentItemsResult->ItemData->member;
                        echo "<pre/ >";
                        print_r( $ConvertedValueDetails );
                        if ( is_array( $ConvertedValueDetails ) ) {
                            foreach ( $ConvertedValueDetails as $finalShipmentValueDetails ) {
                                $shipmentDetailValue     = array(
                                    'ID_ACCOUNT'              => $userAccountDetailArray['ID_ACCOUNT'],
                                    'inv_shipment_id'         => $insertedID,
                                    'qty_shipped'             => $finalShipmentValueDetails->QuantityShipped,
                                    'shipment_id'             => $finalShipmentValueDetails->ShipmentId,
                                    'prep_owner'              => (isset($finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepOwner) ? $finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepOwner : '' ),
                                    'prep_instruction'        => (isset($finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepInstruction) ? $finalShipmentValueDetails->PrepDetailsList->PrepDetails->PrepInstruction : '' ),
                                    'fulfillment_network_sku' => $finalShipmentValueDetails->FulfillmentNetworkSKU,
                                    'seller_sku'              => $finalShipmentValueDetails->SellerSKU,
                                    'qty_received'            => $finalShipmentValueDetails->QuantityReceived,
                                    'qty_incase'              => $finalShipmentValueDetails->QuantityInCase,
                                    'shipment_from_date'      => $amzdateiteration['startDate'],
                                );
                                $inboundShipmentDetail[] = $this->Inventory_shipment_model->insert_inventory_shipment_detail( $shipmentDetailValue );
                            }
                        }
                        else
                        {
                            $shipmentDetailValue     = array(
                                'ID_ACCOUNT'              => $userAccountDetailArray['ID_ACCOUNT'],
                                'inv_shipment_id'         => $insertedID,
                                'qty_shipped'             => $ConvertedValueDetails->QuantityShipped,
                                'shipment_id'             => $ConvertedValueDetails->ShipmentId,
                                'prep_owner'              => (isset($ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepOwner) ? $ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepOwner : '' ),
                                'prep_instruction'        => (isset($ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepInstruction) ? $ConvertedValueDetails->PrepDetailsList->PrepDetails->PrepInstruction : '' ),
                                'fulfillment_network_sku' => $ConvertedValueDetails->FulfillmentNetworkSKU,
                                'seller_sku'              => $ConvertedValueDetails->SellerSKU,
                                'qty_received'            => $ConvertedValueDetails->QuantityReceived,
                                'qty_incase'              => $ConvertedValueDetails->QuantityInCase,
                                'shipment_from_date'      => $amzdateiteration['startDate'],
                            );
                            $inboundShipmentDetail[] = $this->Inventory_shipment_model->insert_inventory_shipment_detail( $shipmentDetailValue );
                        }
                    }
                }
                if ( ! empty( $inboundShipmentDetail ) )
                {
                    $strCases = implode( ",", $inboundShipmentDetail );
                    $content  = "Inbound Shipment Detail Id's Added :" . $strCases;
                    $this->logging->write_log( $this->cronName, $content, 2, $userAccountDetailArray['ID_ACCOUNT'] );
                }
                $amzstatus = array( 'InventoryshipmentStatus' => '1' );
                $this->feedback_fba_order_model->updateamzdateiteration( $amzstatus, $amzdateiteration['logId'] );
            }
            else
            {
                $data = array( 'InboundShipmentStatus' => '1' );
                $this->Customer_shipment_sales_model->historycronstatusupdate( $data, $userAccountDetailArray['ID_ACCOUNT'] );
            }

        }
        $content = date( "d-m-Y H:i:s" ) . " " . "Get Inventory Supplied Historical cron End";
        $this->logging->write_log( $this->cronName, $content, 3, 0 );
    }


    function invokeListInboundShipments( FBAInboundServiceMWS_Interface $service, $request )
    {
        try
        {
            $response = $service->ListInboundShipments( $request );
            $dom      = new DOMDocument();
            $dom->loadXML( $response->toXML() );
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput       = true;
            $responseValue           = json_decode( json_encode( simplexml_load_string( $dom->saveXML() ) ) );

            return $responseValue;
        }
        catch ( FBAInboundServiceMWS_Exception $ex )
        {
            echo( "Caught Exception: " . $ex->getMessage() . "\n" );
            echo( "Response Status Code: " . $ex->getStatusCode() . "\n" );
            echo( "Error Code: " . $ex->getErrorCode() . "\n" );
            echo( "Error Type: " . $ex->getErrorType() . "\n" );
            echo( "Request ID: " . $ex->getRequestId() . "\n" );
            echo( "XML: " . $ex->getXML() . "\n" );
            echo( "ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n" );
        }
    }

    function invokeListInboundShipmentItems( FBAInboundServiceMWS_Interface $service, $request )
    {
        try
        {
            $response = $service->ListInboundShipmentItems( $request );
            $domItem  = new DOMDocument();
            $domItem->loadXML( $response->toXML() );
            $domItem->preserveWhiteSpace = false;
            $domItem->formatOutput       = true;
            $responseValue               = json_decode( json_encode( simplexml_load_string( $domItem->saveXML() ) ) );

            return $responseValue;
        }
        catch ( FBAInboundServiceMWS_Exception $ex )
        {
            echo( "Caught Exception: " . $ex->getMessage() . "\n" );
            echo( "Response Status Code: " . $ex->getStatusCode() . "\n" );
            echo( "Error Code: " . $ex->getErrorCode() . "\n" );
            echo( "Error Type: " . $ex->getErrorType() . "\n" );
            echo( "Request ID: " . $ex->getRequestId() . "\n" );
            echo( "XML: " . $ex->getXML() . "\n" );
            echo( "ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n" );
        }
    }
}