<?php

/**
 * Created by PhpStorm.
 * User: Webdimensions 2
 * Date: 7/17/2017
 * Time: 6:41 PM
 */
class Generate_order_removal_case extends CI_controller {
    function __construct() {
        parent::__construct();
        if ( ! $this->input->is_cli_request() ) {
            show_404();
        }
        $this->load->library( 'amazon' );
        $this->load->model( "user_model" );
        $this->load->model( "reimbursement_model" );
        $this->load->model( "Order_removal_model" );
        $this->load->model( "Case_log_model" );
        $this->load->library( 'rat' );
        $this->logging = new Rat();
    }

    public function index() {
        ini_set('memory_limit', '-1');
        $cronName = "Amazon Order Removal Case";
        $content = date( "d-m-Y H:i:s" ) . " " . "Amazon Order Removal Case cron Start";
        $this->logging->write_log( $cronName, $content, 1, 0 );
        $allUsers = $this->user_model->getAllActiveUsers();
        foreach ( $allUsers as $user ) {
            $arrCaseID         = array();
            $allRecordsFetched = $this->Order_removal_model->get_removal_order_by_accountID( $user['ID_ACCOUNT'] );
            if ( ! empty( $allRecordsFetched ) ) {
                foreach ( $allRecordsFetched as $removalOrderArr ) {
                    if ( $removalOrderArr['carrier'] == 'UPS' || $removalOrderArr['carrier'] == 'USPS' || $removalOrderArr['carrier'] == 'ups freight' ) {
                        $trackingValue = $this->trackingUPS( $removalOrderArr['tracking_number'] );
                        if ( ! empty( $trackingValue['TRACKRESPONSE'] ) ) {
                            if ( ! empty( $trackingValue['TRACKRESPONSE']['SHIPMENT']['PACKAGE']['ACTIVITY']['STATUS']['STATUSTYPE']['DESCRIPTION'] ) ) {
                                $trackingStatus = $trackingValue['TRACKRESPONSE']['SHIPMENT']['PACKAGE']['ACTIVITY']['STATUS']['STATUSTYPE'];
                                if ( strtoupper($trackingStatus['DESCRIPTION']) == 'DELIVERED' || strtoupper($trackingStatus['DESCRIPTION']) == strtoupper('Delivered by Local Post Office')) {
                                    $status = array( 'status' => '1' );
                                    $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                                } else if ( strtoupper($trackingStatus['DESCRIPTION']) != 'DELIVERED' || strtoupper($trackingStatus['DESCRIPTION']) != strtoupper('Delivered by Local Post Office')) {
                                    $date         = date( 'Y-m-d H:i:s' );
                                    $expectedDate = date( 'Y-m-d', strtotime( $removalOrderArr['shipment_date'] . ' +1 month' ) );
                                    if ( strtotime( $expectedDate ) < strtotime( $date ) ) {
                                        $reimburseAROcase = $this->Order_removal_model->getReimbursementAORCase( $user['ID_ACCOUNT'], $removalOrderArr['order_id'], $removalOrderArr['fnsku'] );
                                        if ( empty( $reimburseAROcase ) ) {
                                            $t                  = time();
                                            $generateOrderArray = array(
                                                'ID_ACCOUNT' => $user['ID_ACCOUNT'],
                                                'order_id'   => $removalOrderArr['id'],
                                                'date'       => date( 'Y-m-d H:i:s' ),
                                                'status'     => '0',
                                                'case_type'  => 'AOR'
                                            );
                                            $this->Order_removal_model->generate_order_removal_case( $generateOrderArray );
                                            $status = array( 'status' => '1', 'case_type' => 'AOR' );
                                            $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                                            $log_data    = array(
                                                'ID_ACCOUNT'         => $user['ID_ACCOUNT'],
                                                'case_type'          => 'AOR',
                                                'inventory_order_id' => $removalOrderArr['id'],
                                                'timestamp'          => $t
                                            );
                                            $arrCaseID[] = $this->Case_log_model->addcaselog( $log_data );
                                        } else {
                                            $status = array( 'status' => '1' );
                                            $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                                        }
                                    }
                                }
                            } else if ( ! empty( $trackingValue['TRACKRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION'] ) ) {
                                if ( strtoupper($trackingValue['TRACKRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION']) == strtoupper('Invalid tracking number') ) {
                                    $status = array( 'status' => '2' );
                                    $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                                } else if ( strtoupper($trackingValue['TRACKRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION']) == strtoupper('No tracking information available') ) {
                                    $date         = date( 'Y-m-d H:i:s' );
                                    $expectedDate = date( 'Y-m-d', strtotime( $removalOrderArr['shipment_date'] . ' +1 month' ) );
                                    if ( strtotime( $expectedDate ) < strtotime( $date ) ) {
                                        $reimburseAROcase = $this->Order_removal_model->getReimbursementAORCase( $user['ID_ACCOUNT'], $removalOrderArr['order_id'], $removalOrderArr['fnsku'] );
                                        if ( empty( $reimburseAROcase ) ) {
                                            $t                  = time();
                                            $generateOrderArray = array(
                                                'ID_ACCOUNT' => $user['ID_ACCOUNT'],
                                                'order_id'   => $removalOrderArr['id'],
                                                'date'       => date( 'Y-m-d H:i:s' ),
                                                'status'     => '0',
                                                'case_type'  => 'AOR'
                                            );
                                            $this->Order_removal_model->generate_order_removal_case( $generateOrderArray );
                                            $status = array( 'status' => '1', 'case_type' => 'AOR' );
                                            $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                                            $log_data    = array(
                                                'ID_ACCOUNT'         => $user['ID_ACCOUNT'],
                                                'case_type'          => 'AOR',
                                                'inventory_order_id' => $removalOrderArr['id'],
                                                'timestamp'          => $t
                                            );
                                            $arrCaseID[] = $this->Case_log_model->addcaselog( $log_data );
                                        } else {
                                            $status = array( 'status' => '1' );
                                            $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                                        }
                                    }
                                }
                            }
                            if ( ! empty( $arrCaseID ) ) {
                                $strCases = implode( ",", $arrCaseID );
                                $content  = "Generated Cases :" . $strCases;
                                $this->logging->write_log( $cronName, $content, 2, $user['ID_ACCOUNT'] );
                            }
                        }
                    } else {
                        $status = array( 'status' => '1' );
                        $this->Order_removal_model->update_removal_order_by_id( $removalOrderArr['id'], $status );
                    }
                }
            }
        }
        // Logging in Database.
        $content = date( "d-m-Y H:i:s" ) . " " . "Amazon Order Removal Case cron End";
        $this->logging->write_log( $cronName, $content, 3, 0 );
    }


    public function trackingUPS( $trackingNumber ) {
        $data = "<?xml version=\"1.0\"?>
        <AccessRequest xml:lang='en-US'>
                <AccessLicenseNumber>" . UPSACCESSLICENCENUMBER . "</AccessLicenseNumber>
                <UserId>" . UPSUSERID . "</UserId>
                <Password>" . UPSUSERPASSWORD . "</Password>
        </AccessRequest>
        <?xml version=\"1.0\"?>
        <TrackRequest>
                <Request>
                        <TransactionReference>
                                <CustomerContext>
                                        <InternalKey>blah</InternalKey>
                                </CustomerContext>
                                <XpciVersion>1.0</XpciVersion>
                        </TransactionReference>
                        <RequestAction>Track</RequestAction>
                </Request>
        <TrackingNumber>$trackingNumber</TrackingNumber>
        </TrackRequest>";
        $ch   = curl_init( "https://www.ups.com/ups.app/xml/Track" );
        curl_setopt( $ch, CURLOPT_HEADER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        $result = curl_exec( $ch );
// echo '<!-- '. $result. ' -->';
        $data       = strstr( $result, '<?' );
        $xml_parser = xml_parser_create();
        xml_parse_into_struct( $xml_parser, $data, $vals, $index );
        xml_parser_free( $xml_parser );
        $params = array();
        $level  = array();
        foreach ( $vals as $xml_elem ) {
            if ( $xml_elem['type'] == 'open' ) {
                if ( array_key_exists( 'attributes', $xml_elem ) ) {
                    list( $level[ $xml_elem['level'] ], $extra ) = array_values( $xml_elem['attributes'] );
                } else {
                    $level[ $xml_elem['level'] ] = $xml_elem['tag'];
                }
            }
            if ( $xml_elem['type'] == 'complete' ) {
                $start_level = 1;
                $php_stmt    = '$params';
                while ( $start_level < $xml_elem['level'] ) {
                    $php_stmt .= '[$level[' . $start_level . ']]';
                    $start_level ++;
                }
                $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
                eval( $php_stmt );
            }
        }
        curl_close( $ch );

        return $params;
    }

}