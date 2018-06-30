<?php

class Reimbursement_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    public function getUserDetailsByAccountId($accountId){
        return $this->db->select("*")->where('users.ID_ACCOUNT', $accountId)->where('users.active', '1')->where('users.deleted', '0')->get("users")->row_array();
    }
    public function getCasesByAcountIdAndCaseType($accountId, $type){
        $this->db->select('case_detail.*, payment_details.amount,payment_details.case_type, payment_details.charge_type');
        $this->db->join('case_detail', 'case_detail.order_id=payment_details.order_id', 'left');
        $this->db->group_by('case_detail.order_id');
        $this->db->order_by('case_detail.order_id', 'desc');
        $this->db->where('case_detail.status', '0');
        $this->db->where('case_detail.deleted', '0');
        $this->db->where('payment_details.status','1');
        $this->db->where('payment_details.ID_ACCOUNT', $accountId);
        $this->db->where('payment_details.case_type', $type);
        if($type=="COR")
        $this->db->where('payment_details.charge_type', 'Goodwill');
        $result = $this->db->get("payment_details")->result_array();
        return $result;
    }
    public function getAmzDateIterationByAccountId($id){
        return $this->db->where("accountId", $id)->get("amzdateiteration")->result_array();
    }
    public function checkorderId($orderId, $accountID){
        return $this->db->where("orderid", $orderId)->where("ID_ACCOUNT", $accountID)->get("feedback_orders")->row_array();
    }
    /*
     * Fatching Reimbursement Data
     */
    public function getReimbursementData()
    {
        return $this->db->get("reimburse_details")->result_array();
    }

    /*
     * Amazon Case Queries
     */
    public function getPaymentDetails($accountID)
    {
        return $this->db->order_by('order_id', 'desc')->where('ID_ACCOUNT',$accountID)->where('charge_type','Principal')->where('status IS NULL')->get("payment_details")->result_array();
    }

    public function getPaymentDetailsByDate($accountID, $startDate, $endDate)
    {
        $this->db->order_by('order_id', 'desc');
        $this->db->where('ID_ACCOUNT',$accountID);
        $this->db->where('charge_type','Principal');
        $this->db->where('status IS NULL');
        $this->db->where('date >=', $startDate);
        $this->db->where('date <=', $endDate);
        $result =  $this->db->get("payment_details")->result_array();
        echo "<pre/ >"; print_r($this->db->last_query());
        return $result;
    }

    public function getPaymentDetailsGoodwill($accountID)
    {
        return $this->db->order_by('order_id', 'desc')->where('ID_ACCOUNT',$accountID)->where('charge_type','Goodwill')->where('status IS NULL')->get("payment_details")->result_array();
    }


    public function getAllPaymentDetails()
    {
        return $this->db->order_by('order_id', 'desc')->where('status', '1')->where('case_type IS NOT NULL')->get("payment_details")->result_array();
    }

    public function getCaseIdStatusByUserId( $userAccountId, $days ) {
        $this->db->select( 'case_detail.*, payment_details.case_type as casetype, payment_details.amount, reimburse_details.amount_total,feedback_orders.small_img_url,feedback_orders.productname' );
        $this->db->join( 'payment_details', 'payment_details.order_id=case_detail.order_id', 'left' );
        $this->db->join( 'feedback_orders', 'feedback_orders.orderid=case_detail.order_id', 'left' );
        $this->db->join( 'reimburse_details', 'reimburse_details.order_id=case_detail.order_id', 'left' );
        $this->db->group_by( 'case_detail.order_id' );
        $this->db->order_by( 'case_detail.order_id', 'desc' );
        $this->db->where( 'case_detail.status >=', '1' );
        $this->db->where( 'case_detail.case_id IS NOT NULL' );
        $this->db->where( 'case_detail.deleted =', '0' );
        $this->db->where( "case_detail.ID_ACCOUNT", $userAccountId );
        if ( $days != 0 ) {
            $this->db->where( 'case_detail.date >=', $days );
            $this->db->where( 'case_detail.date <=', date( 'Y-m-d h:i:s' ) );
        }
        $caseDetailsValues = $this->db->get( "case_detail" )->result_array();
        $final_result = array();
        foreach ( $caseDetailsValues as $case_details ) {
            if ( $case_details['Case_Type'] == 'AOR' ) {
                $this->db->select( 'order_removal_shipment.case_type as casetype, order_removal_shipment.sku, feedback_orders.productname' );
                $this->db->join( 'feedback_orders', 'feedback_orders.sku=order_removal_shipment.sku', 'left' );
                $this->db->where( 'order_removal_shipment.case_type', $case_details['Case_Type'] );
                $this->db->where( 'order_removal_shipment.id', $case_details['order_id'] );
                $this->db->where( 'order_removal_shipment.ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query = $this->db->get( 'order_removal_shipment' )->row_array();
                $this->db->select( 'amount_total' );
                $this->db->where( 'case_id', $case_details['case_id'] );
                $this->db->where( 'sku', $query['sku'] );
                $this->db->where( 'ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query1                  = $this->db->get( 'reimburse_details' )->row_array();
                $result['id']            = $case_details['id'];
                $result['ID_ACCOUNT']    = $case_details['ID_ACCOUNT'];
                $result['case_id']       = $case_details['case_id'];
                $result['order_id']      = $case_details['order_id'];
                $result['case_type']     = $query['casetype'];
                $result['amount']        = ( isset( $query['amount'] ) ? $query['amount'] : '' );
                $result['status']        = $case_details['status'];
                $result['date']          = $case_details['date'];
                $result['deleted']       = $case_details['deleted'];
                $result['amount_total']  = $query1['amount_total'];
                $result['small_img_url'] = $case_details['small_img_url'];
                $result['productname']   = $query['productname'];
                $final_result[]          = $result;
            } else {
                $this->db->select( 'case_type as casetype, amount' );
                $this->db->where( 'case_type', $case_details['Case_Type'] );
                $this->db->where( 'order_id', $case_details['order_id'] );
                $this->db->where( 'ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query = $this->db->get( 'payment_details' )->row_array();
                $this->db->select( 'amount_total' );
                $this->db->where( 'case_id', $case_details['case_id'] );
                $this->db->where( 'order_id', $case_details['order_id'] );
                $this->db->where( 'ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query1               = $this->db->get( 'reimburse_details' )->row_array();
                $result['id']         = $case_details['id'];
                $result['ID_ACCOUNT'] = $case_details['ID_ACCOUNT'];
                $result['case_id']    = $case_details['case_id'];
                $result['order_id']   = $case_details['order_id'];
                $result['case_type']  = $query['casetype'];
                $result['amount']     = $query['amount'];
                $result['status']     = $case_details['status'];
                $result['date']       = $case_details['date'];
                $result['deleted']    = $case_details['deleted'];
                if ( ! empty( $query1 ) ) {
                    $result['amount_total'] = $query1['amount_total'];
                } else {
                    $result['amount_total'] = '';
                }
                $result['small_img_url'] = $case_details['small_img_url'];
                $result['productname']   = $case_details['productname'];
                $final_result[]          = $result;
            }
        }
        return $final_result;
    }

    public function getReimbursementDetailsByOrderId($orderId,$accountID)
    {
        return $this->db->order_by('order_id', 'desc')->where("order_id", $orderId)->where('ID_ACCOUNT', $accountID)->where('fnsku',$fnsku)->get("reimburse_details")->row_array();
    }

    public function getReimbursementDetailsByOrderIdforGoodWill($orderId, $accountID,$amount)
    {
        return $this->db->where("order_id", $orderId)->where('ID_ACCOUNT', $accountID)->where( 'amount_total <=', $amount )->get("reimburse_details")->result_array();
    }

    public function getFeedbackOrderByOrderId($orderId){
        return $this->db->where("orderid", $orderId)->get("feedback_orders")->row_array();
    }

    public function updatePaymentwithONRtype($data, $orderId, $accountId)
    {
        $this->db->where('order_id', $orderId);
        $this->db->where('ID_ACCOUNT', $accountId);
        $this->db->update('payment_details', $data);
        return $this->db->affected_rows();
    }

    public function updatePaymentwithCORtype($data , $id)
    {
        $this->db->where('id', $id);
        $this->db->update('payment_details', $data);
        return $this->db->affected_rows();
    }

    public function getInventoryDetails($orderid,$accoundId)
    {
        $this->db->select('fnsku');
        $this->db->where('amazon-order-id', $orderid);
        $this->db->where('ID_ACCOUNT', $accoundId);
        return $this->db->get('customer_shipment_data')->row_array();
    }

    public function updateAmazonCase($data, $orderId, $accountId)
    {
        $this->db->where('order_id', $orderId);
        $this->db->where('ID_ACCOUNT', $accountId);
        $this->db->update('case_detail', $data);
        return $this->db->affected_rows();
    }

    public function getAllgeneratedCases($start_date = null, $end_date = null, $user = null)
    {
        $this->db->select('case_detail.*, payment_details.amount, reimburse_details.amount_total');
        $this->db->join('payment_details', 'payment_details.order_id=case_detail.order_id', 'left');
        $this->db->join('feedback_orders', 'feedback_orders.orderid=case_detail.order_id', 'left');
        $this->db->join('reimburse_details', 'reimburse_details.order_id=case_detail.order_id', 'left');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->group_by('case_detail.order_id');
        $this->db->order_by('case_detail.order_id', 'desc');
        $this->db->where('case_detail.status >=', '1');
        $this->db->where('case_detail.deleted =', '0');
        if (!empty($start_date))
            $this->db->where('case_detail.date >=', $start_date);
        if (!empty($end_date))
            $this->db->where('case_detail.date <=', $end_date);
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        return $this->db->get("case_detail")->result_array();
    }

    public function getAllgeneratedCasesByUserId( $accountId = null, $start_date = null, $end_date = null ) {
        $this->db->select( 'case_detail.*, payment_details.case_type as casetype, payment_details.amount, reimburse_details.amount_total,feedback_orders.small_img_url,feedback_orders.productname' );
        $this->db->join( 'payment_details', 'payment_details.order_id=case_detail.order_id', 'left' );
        $this->db->join( 'feedback_orders', 'feedback_orders.orderid=case_detail.order_id', 'left' );
        $this->db->join( 'reimburse_details', 'reimburse_details.order_id=case_detail.order_id', 'left' );
        $this->db->group_by( 'case_detail.order_id' );
        $this->db->order_by( 'case_detail.order_id', 'desc' );
        $this->db->where( 'case_detail.status >=', '1' );
        $this->db->where( 'case_detail.case_id IS NOT NULL' );
        $this->db->where( 'case_detail.deleted =', '0' );
        if ( ! empty( $accountId ) ) {
            $this->db->where( 'case_detail.ID_ACCOUNT', $accountId );
        }
        if ( ! empty( $start_date ) ) {
            $this->db->where( 'case_detail.date >=', $start_date );
        }
        if ( ! empty( $end_date ) ) {
            $this->db->where( 'case_detail.date <=', $end_date );
        }
        $case_detail = $this->db->get( "case_detail" )->result_array();

        $final_result = array();
        foreach ( $case_detail as $case_details ) {
            if ( $case_details['Case_Type'] == 'AOR' ) {
                $this->db->select( 'order_removal_shipment.case_type as casetype, order_removal_shipment.sku, feedback_orders.productname' );
                $this->db->join( 'feedback_orders', 'feedback_orders.sku=order_removal_shipment.sku', 'left' );
                $this->db->where( 'order_removal_shipment.case_type', $case_details['Case_Type'] );
                $this->db->where( 'order_removal_shipment.id', $case_details['order_id'] );
                $this->db->where( 'order_removal_shipment.ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query = $this->db->get( 'order_removal_shipment' )->row_array();
                $this->db->select( 'amount_total' );
                $this->db->where( 'case_id', $case_details['case_id'] );
                $this->db->where( 'sku', $query['sku'] );
                $this->db->where( 'ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query1                  = $this->db->get( 'reimburse_details' )->row_array();
                $result['id']            = $case_details['id'];
                $result['ID_ACCOUNT']    = $case_details['ID_ACCOUNT'];
                $result['case_id']       = $case_details['case_id'];
                $result['order_id']      = $case_details['order_id'];
                $result['case_type']     = $query['casetype'];
                $result['amount']        = ( isset( $query['amount'] ) ? $query['amount'] : '' );
                $result['status']        = $case_details['status'];
                $result['date']          = $case_details['date'];
                $result['deleted']       = $case_details['deleted'];
                $result['amount_total']  = $query1['amount_total'];
                $result['small_img_url'] = $case_details['small_img_url'];
                $result['productname']   = $query['productname'];
                $final_result[]          = $result;
            } else {
                $this->db->select( 'case_type as casetype, amount' );
                $this->db->where( 'case_type', $case_details['Case_Type'] );
                $this->db->where( 'order_id', $case_details['order_id'] );
                $this->db->where( 'ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query = $this->db->get( 'payment_details' )->row_array();
                $this->db->select( 'amount_total' );
                $this->db->where( 'case_id', $case_details['case_id'] );
                $this->db->where( 'order_id', $case_details['order_id'] );
                $this->db->where( 'ID_ACCOUNT', $case_details['ID_ACCOUNT'] );
                $query1 = $this->db->get( 'reimburse_details' )->row_array();
                $result['id']            = $case_details['id'];
                $result['ID_ACCOUNT']    = $case_details['ID_ACCOUNT'];
                $result['case_id']       = $case_details['case_id'];
                $result['order_id']      = $case_details['order_id'];
                $result['case_type']     = $query['casetype'];
                $result['amount']        = $query['amount'];
                $result['status']        = $case_details['status'];
                $result['date']          = $case_details['date'];
                $result['deleted']       = $case_details['deleted'];
                $result['amount_total']  = $query1['amount_total'];
                $result['small_img_url'] = $case_details['small_img_url'];
                $result['productname']   = $case_details['productname'];
                $final_result[]          = $result;
            }
        }

        return $final_result;
    }

    public function getReturnCustomerOrderDetails($orderId)
    {
        $this->db->select('payment_details.order_id,payment_details.charge_type,return_customer_order.product-name,return_customer_order.quantity,payment_details.amount,return_customer_order.reason,return_customer_order.status, return_customer_order.detailed_disposition, return_customer_order.sku, feedback_orders.productname');
        $this->db->from('payment_details');
        $this->db->join('return_customer_order', 'return_customer_order.ID_ACCOUNT=payment_details.ID_ACCOUNT', 'left');
        $this->db->join('feedback_orders', 'feedback_orders.orderid=payment_details.order_id', 'left');
        $this->db->where("return_customer_order.order_id", $orderId);
        $this->db->where("return_customer_order.status IS NOT NULL");
        return $this->db->get()->result_array();
    }

    public function getReturnCustomerOrderDetailsNew($orderId){
        $this->db->where('order_id', $orderId);
        return $this->db->get('return_customer_order')->row_array();
    }

    public function updatePaymentDetailsData($data, $orderId, $accountId)
    {
        $this->db->where('order_id', $orderId);
        $this->db->where('ID_ACCOUNT', $accountId);
        $this->db->update('payment_details', $data);
        return $this->db->affected_rows();
    }

    public function insertCaseId($data)
    {
        $this->db->insert("case_detail", $data);
        return $this->db->insert_id();
    }

    //get details which need payment from stripe for orders cases
    /*public function getOrderPaymentCases($userAccountId)
    {
        $this->db->select('case_detail.id, case_detail.order_id, case_detail.case_id, reimburse_details.amount_total, reimburse_details.currency_unit, reimburse_details.reimburse_id');
        $this->db->join('reimburse_details', 'reimburse_details.order_id=case_detail.order_id');
        $this->db->from('case_detail');
        if ($userAccountId == '') {

        } else {
            $this->db->where('case_detail.ID_ACCOUNT', $userAccountId);
        }
        $this->db->where('case_detail.status', '1');
        return $this->db->get()->result_array();
    }*/
    public function getOrderPaymentCases( $userAccountId ) {
        $this->db->select( 'case_detail.ID_ACCOUNT, case_detail.id, case_detail.order_id, case_detail.case_id, case_detail.case_type' );
        $this->db->from( 'case_detail' );
        if ( ! empty( $userAccountId ) ) {
            $this->db->where( 'case_detail.ID_ACCOUNT', $userAccountId );
        }
        $this->db->where( 'case_detail.status <>', '3' );
        $this->db->where( 'case_detail.status <>', '0' );
        $result                 = $this->db->get()->result_array();
        $reimbursementDetailArr = array();
        foreach ( $result as $key => $caseDetailArr ) {
            if ( $caseDetailArr['case_type'] == 'AOR' ) {
                $this->db->select( '*' );
                $this->db->where( 'id', $caseDetailArr['order_id'] );
                $this->db->where( 'status', '1' );
                $this->db->where( 'case_type', 'AOR' );
                $orderRemovalDetail = $this->db->get( 'order_removal_shipment' )->row_array();
                if ( ! empty( $orderRemovalDetail ) ) {
                    $this->db->select( 'id, reimburse_id, amount_total,currency_unit, actual_reimbursed, approval_date, status,fnsku' );
                    $this->db->where( 'case_id', $caseDetailArr['case_id'] );
                    $this->db->where( 'fnsku', $orderRemovalDetail['fnsku'] );
                    $this->db->where( 'status', '0' );
                    $reimbursementDetail = $this->db->get( 'reimburse_details' )->row_array();
                    if ( ! empty( $reimbursementDetail ) ) {
                        $this->db->select( 'id' );
                        $this->db->where( 'reimburseid', $reimbursementDetail['reimburse_id'] );
                        $this->db->where( 'fnsku', $reimbursementDetail['fnsku'] );
                        $this->db->where( 'ID_ACCOUNT', $userAccountId );
                        $paymentHistory = $this->db->get( 'payment_history' )->row_array();
                        if ( ! empty( $paymentHistory ) ) {
                            $status = array( 'status' => '1' );
                            $this->db->where( 'id', $reimbursementDetail['id'] );
                            $this->db->where( 'ID_ACCOUNT', $userAccountId );
                            $this->db->update( 'reimburse_details', $status );
                        } else {
                            $reimbursementDetailArr[ $key ]['amount_total']      = $reimbursementDetail['amount_total'];
                            $reimbursementDetailArr[ $key ]['actual_reimbursed'] = $reimbursementDetail['actual_reimbursed'];
                            $reimbursementDetailArr[ $key ]['reimburse_id']      = $reimbursementDetail['reimburse_id'];
                            $reimbursementDetailArr[ $key ]['currency_unit']     = $reimbursementDetail['currency_unit'];
                            $reimbursementDetailArr[ $key ]['fnsku']             = $reimbursementDetail['fnsku'];
                            $reimbursementDetailArr[ $key ]['case_id']           = $caseDetailArr['case_id'];
                            $reimbursementDetailArr[ $key ]['id']                = $caseDetailArr['id'];
                            $reimbursementDetailArr[ $key ]['approval_date']     = $reimbursementDetail['approval_date'];
                        }
                    }
                }
            } else {
                $this->db->select( 'reimburse_id, amount_total,currency_unit, actual_reimbursed, approval_date,fnsku ' );
                $this->db->where( 'case_id', $caseDetailArr['case_id'] );
                $this->db->where( 'order_id', $caseDetailArr['order_id'] );
                $this->db->where( 'status', '0' );
                $reimbursementDetail = $this->db->get( 'reimburse_details' )->row_array();
                if ( ! empty( $reimbursementDetail ) ) {
                    $this->db->select( 'id' );
                    $this->db->where( 'reimburseid', $reimbursementDetail['reimburse_id'] );
                    $this->db->where( 'fnsku', $reimbursementDetail['fnsku'] );
                    $this->db->where( 'ID_ACCOUNT', $userAccountId );
                    $paymentHistory = $this->db->get( 'payment_history' )->row_array();
                    if ( ! empty( $paymentHistory ) ) {
                        $status = array( 'status' => '1' );
                        $this->db->where( 'reimburse_id', $reimbursementDetail['reimburse_id'] );
                        $this->db->where( 'ID_ACCOUNT', $userAccountId );
                        $this->db->update( 'reimburse_details', $status );
                    } else {
                        $reimbursementDetailArr[ $key ]['amount_total']      = $reimbursementDetail['amount_total'];
                        $reimbursementDetailArr[ $key ]['actual_reimbursed'] = $reimbursementDetail['actual_reimbursed'];
                        $reimbursementDetailArr[ $key ]['reimburse_id']      = $reimbursementDetail['reimburse_id'];
                        $reimbursementDetailArr[ $key ]['currency_unit']     = $reimbursementDetail['currency_unit'];
                        $reimbursementDetailArr[ $key ]['fnsku']             = $reimbursementDetail['fnsku'];
                        $reimbursementDetailArr[ $key ]['case_id']           = $caseDetailArr['case_id'];
                        $reimbursementDetailArr[ $key ]['id']                = $caseDetailArr['id'];
                        $reimbursementDetailArr[ $key ]['approval_date']     = $reimbursementDetail['approval_date'];
                    }
                }
            }
        }

        return $reimbursementDetailArr;
    }

    // get customer paymdent detail
    public function getcustomer($userAccountId)
    {
        return $this->db->where('ID_ACCOUNT',$userAccountId)->get('payment_method')->result_array();
    }

    public function getaffuseridbyaccountid($accountID){
        return $this->db->where('ID_ACCOUNT', $accountID)->get('accounts')->row_array();
    }

    // update order case detail after payment complete
    public function updatecasedetail($status, $id)
    {
        $this->db->where('id', $id)->update("case_detail", $status);
    }

    // update inventory case detail after payment complete
    public function updateinventorycasedetail($status, $id)
    {
        $this->db->where('id', $id)->update("case_details_inventory", $status);
    }

    //add details of stripe payment in payment history
    public function addpaymenthistory($data)
    {
        $this->db->insert("payment_history", $data);
        return $this->db->insert_id();
    }

    //get particular details of order wise
    public function getReturnOrderDetails($order_id,$sku,$user_id)
    {
        return $this->db->order_by('order_id', 'desc')->where('order_id', $order_id)->where('sku',$sku)->where('ID_ACCOUNT', $user_id)->get("return_customer_order")->row_array();
    }

    //get payment details of particular user
    public function getUserwisePaymentDetails($user_id = '')
    {
        if ($user_id == '') {
            return $this->db->order_by('order_id', 'desc')->where('status IS NULL')->get("payment_details")->result_array();
        } else {
            return $this->db->order_by('order_id', 'desc')->where('ID_ACCOUNT', $user_id)->where('status IS NULL')->get("payment_details")->result_array();
        }
    }

    public function getUserwisegeneratePaymentDetails($user_id)
    {
        $this->db->select('case_detail.*, payment_details.amount,payment_details.case_type');
        $this->db->join('payment_details', 'payment_details.order_id=case_detail.order_id', 'left');
        $this->db->group_by('case_detail.order_id');
        $this->db->order_by('case_detail.order_id', 'desc');
        $this->db->where('case_detail.status', '0');
        $this->db->where_not_in('payment_details.case_type','RDA');
        $this->db->where('case_detail.deleted', '0');
        $this->db->where('payment_details.status','1');
        $this->db->where('payment_details.ID_ACCOUNT', $user_id);
        $result = $this->db->get("case_detail")->result_array();
        return $result;
    }

    public function getUserwisegeneratePaymentDetailsOrderByCaseType($accountId)
    {
        return $this->db->order_by('order_id', 'desc')->where('ID_ACCOUNT', $accountId)->where('status', '1')->where('case_type IS NOT NULL')->get("payment_details")->result_array();
    }

    public function getUserwiseAllCases($user_id, $days)
    {
        if ($user_id == '') {
            return $this->db->order_by('order_id', 'desc')->where('status >=', '1')->get("case_detail")->result_array();
        } else {
            if ($days != 0) {
                return $this->db->order_by('order_id', 'desc')->where('status >=', '1')->where('ID_ACCOUNT', $user_id)->where('date >=', $days)->where('date <=', date('Y-m-d h:i:s'))->get("case_detail")->result_array();
            } else
                return $this->db->order_by('order_id', 'desc')->where('status >=', '1')->where('ID_ACCOUNT', $user_id)->get("case_detail")->result_array();
        }
    }

    public function getlast_refund_cases($accountid = '')
    {
        $this->db->select('*');
        $this->db->from('case_detail');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=case_detail.ID_ACCOUNT', 'left');
        $this->db->order_by('id', 'desc');
        if (!empty($accountid)) {
            $this->db->where('case_detail.ID_ACCOUNT', $accountid);
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        $this->db->where('case_detail.status <>', '0');
        $this->db->where('case_detail.deleted', '0');
        $this->db->group_by('case_detail.case_id');
        $this->db->limit(5);
        return $this->db->get('')->result_array();
    }

    public function get_today_case($accountid = '')
    {
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('reimburse_details.approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');
        $this->db->where('case_detail.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        $result = $this->db->get()->row_array();
        // Inventory Reimbursement Total
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.caseId = reimburse_details.case_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('reimburse_details.approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');
        $this->db->where('case_details_inventory.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_details_inventory.accountId');
        $this->db->group_by('case_details_inventory.id');
        $resultinventoryamount = $this->db->get()->row_array();

        $totalResultToDay = array();
        $totalResultToDay['case_id'] = $result['case_id'] + $resultinventoryamount['case_id'];
        $totalResultToDay['amount_total'] = $result['amount_total'] + $resultinventoryamount['amount_total'];
        return $totalResultToDay;
    }

    public function get_sevenday_case($accountid = '')
    {

        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('reimburse_details.approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
        $this->db->where('case_detail.status', '2');


        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        $result = $this->db->get()->row_array();
        // Inventory Reimbursement Total
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.caseId = reimburse_details.case_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('reimburse_details.approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
        $this->db->where('case_details_inventory.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_details_inventory.accountId');
        $this->db->group_by('case_details_inventory.id');
        $resultinventoryamount = $this->db->get()->row_array();

        $totalResultSevenDay = array();
        $totalResultSevenDay['case_id'] = $result['case_id'] + $resultinventoryamount['case_id'];
        $totalResultSevenDay['amount_total'] = $result['amount_total'] + $resultinventoryamount['amount_total'];
        return $totalResultSevenDay;
    }

    public function get_fifteenday_case($accountid = '')
    {
        // Refund Guardian Reimbursement Total
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('reimburse_details.approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
        $this->db->where('case_detail.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        $result = $this->db->get()->row_array();
        // Inventory Reimbursement Total
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.caseId = reimburse_details.case_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('reimburse_details.approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
        $this->db->where('case_details_inventory.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_details_inventory.accountId');
        $this->db->group_by('case_details_inventory.id');
        $resultinventoryamount = $this->db->get()->row_array();

        $totalResultFifteenDay = array();
        $totalResultFifteenDay['case_id'] = $result['case_id'] + $resultinventoryamount['case_id'];
        $totalResultFifteenDay['amount_total'] = $result['amount_total'] + $resultinventoryamount['amount_total'];
        return $totalResultFifteenDay;
    }

    public function get_thirtyday_case($accountid = '')
    {
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
        $this->db->where('case_detail.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        $result = $this->db->get()->row_array();


        // Inventory Reimbursement Total
        $this->db->select('count(reimburse_details.case_id) as case_id, sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.caseId = reimburse_details.case_id');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('approval_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
        $this->db->where('case_details_inventory.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_details_inventory.accountId');
        $this->db->group_by('case_details_inventory.id');
        $resultinventoryamount = $this->db->get()->row_array();
        $totalResultThirtyDay = array();
        $totalResultThirtyDay['case_id'] = $result['case_id'] + $resultinventoryamount['case_id'];
        $totalResultThirtyDay['amount_total'] = $result['amount_total'] + $resultinventoryamount['amount_total'];
        return $totalResultThirtyDay;
    }

    public function getchargedetails($accountid)
    {
        $startDate = date('y-m-d H:i:s', strtotime("-30 days"));
        $endDate = date('y-m-d H:i:s', strtotime("now"));
        $this->db->where('ID_ACCOUNT', $accountid);
        $this->db->where('status', '0');
        $this->db->where('date >=', $startDate);
        $this->db->where('date <=', $endDate);
        return $this->db->get('payment_history')->result_array();
    }

    public function addstripecharge($data)
    {
        $this->db->insert('stripe_payment_history', $data);
        return $this->db->insert_id();
    }

    public function updatepaymenthistory($status, $ids)
    {
        $this->db->where_In('id', $ids);
        $this->db->update('payment_history', $status);
    }

    public function gettotalreimburse($user_account_id = '')
    {
        $this->db->select('sum(amount) as total');
        if (!empty($user_account_id)) {
            $this->db->where('ID_ACCOUNT', $user_account_id);
        }
        $this->db->from('stripe_payment_history');
        return $this->db->get()->result_array();
    }

    function delete_case_by_account_id($ID_ACCOUNT)
    {
        $array = array('deleted' => '1');
        $this->db->where('id', $ID_ACCOUNT)->update('case_detail', $array);
    }

    function edit_case_by_account_id($id)
    {
        return $this->db->select('*')->where('id', $id)->get('case_detail')->row_array();
    }

    public function updateCaseBYId($id, $data)
    {

        $this->db->where('order_id',$id);
        $this->db->update('case_detail', $data);
        return $this->db->affected_rows();
    }

    public function getAllgeneratedCasesByUserId_Detail($id)
    {
        $this->db->select('case_detail.*, payment_details.amount,payment_details.case_type, reimburse_details.amount_total,feedback_orders.small_img_url,feedback_orders.productname');
        $this->db->join('payment_details', 'payment_details.order_id=case_detail.order_id', 'left');
        $this->db->join('feedback_orders', 'feedback_orders.orderid=case_detail.order_id', 'left');
        $this->db->join('reimburse_details', 'reimburse_details.order_id=case_detail.order_id', 'left');
        $this->db->where('case_detail.id', $id);
        return $result = $this->db->get("case_detail")->row_array();
    }

    public function gethistorycronstatusbyaccountid($accountID){
        $this->db->where('ID_ACCOUNT', $accountID);
        return $this->db->get('history_cron_status')->row_array();
    }

    # This function use to get all case change status in case_change_status table
    public function get_case_change_status()
    {
        $this->db->select('*');
        $case_status = $this->db->get('case_change_status');
        $case_status_change = $case_status->result();
        return $case_status_change;
    }

    # This functionuse to change status in case_detail database
    public function updateCaseStatus($id,$CaseStatus)
    {
        $this->db->where_in('order_id',$id);
        $this->db->update('case_detail',$CaseStatus);
        return $this->db->affected_rows();
    }

    # This functionuse to change status in case_detail database
    public function updateCaseStatusToDO($id,$data)
    {
        $this->db->where_in('order_id',$id);
        $this->db->update('payment_details',$data);
        return $this->db->affected_rows();
    }

    public function allRecordDisplay($id)
    {
        $this->db->select('*');
        $this->db->where_in('order_id',$id);
        $caseRecord= $this->db->get('case_detail');
        $case_data = $caseRecord->result();
        return $case_data;
    }

    function add_case_data($insert_data)
    {
        $this->db->insert('case_status_log', $insert_data);
        return $this->db->insert_id();
    }

    function orderTrackingInfouser($account_id,$start_date = NULL,$end_date = NULL)
    {
        $this->db->select('users.*,case_detail.*,feedback_orders.*,reimburse_details.*');
        $this->db->join('feedback_orders','feedback_orders.orderid=case_detail.order_id AND feedback_orders.ID_ACCOUNT=case_detail.ID_ACCOUNT');
        $this->db->join('reimburse_details','reimburse_details.order_id=case_detail.order_id AND reimburse_details.ID_ACCOUNT=case_detail.ID_ACCOUNT AND reimburse_details.case_id=case_detail.case_id');
        $this->db->join('users','users.ID_ACCOUNT=case_detail.ID_ACCOUNT');
        $this->db->where('users.id',$account_id);
        $this->db->where('case_detail.status','6');
        $this->db->where('case_detail.deleted','0');
        $this->db->order_by('case_detail.date','desc');
        $this->db->where('case_detail.date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
        if (!empty($start_date))
        {
            $this->db->where('case_detail.date >=',$start_date);
        }
        if (!empty($end_date))
        {
            $this->db->where('case_detail.date <=',$end_date);
        }
        $orderTrackingInfo = $this->db->get('case_detail');
        return $orderTrackingInfo->result_array();
    }

    function orderTrackingInfoadmin($start_date = NULL,$end_date = NULL)
    {
        $this->db->select('users.*,case_detail.*,feedback_orders.*,reimburse_details.*');
        $this->db->join('feedback_orders','feedback_orders.orderid=case_detail.order_id AND feedback_orders.ID_ACCOUNT=case_detail.ID_ACCOUNT');
        $this->db->join('reimburse_details','reimburse_details.order_id=case_detail.order_id AND reimburse_details.ID_ACCOUNT=case_detail.ID_ACCOUNT AND reimburse_details.case_id=case_detail.case_id');
        $this->db->join('users','users.ID_ACCOUNT=case_detail.ID_ACCOUNT');
        $this->db->where('case_detail.status','6');
        $this->db->where('case_detail.deleted','0');
        $this->db->order_by('case_detail.date','desc');
        $this->db->where('case_detail.date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
        if (!empty($start_date))
        {
            $this->db->where('feedback_orders.shipmentdate >=',$start_date);
        }
        if (!empty($end_date))
        {
            $this->db->where('feedback_orders.shipmentdate <=',$end_date);
        }
        $orderTrackingInfo = $this->db->get('case_detail');
        return $orderTrackingInfo->result_array();
    }

    function orderTrackingInfo($account_id,$start_date = NULL,$end_date = NULL)
    {
        $this->db->select('users.*,case_detail.*,feedback_orders.*,reimburse_details.*');
        $this->db->join('feedback_orders','feedback_orders.orderid=case_detail.order_id AND feedback_orders.ID_ACCOUNT=case_detail.ID_ACCOUNT');
        $this->db->join('reimburse_details','reimburse_details.order_id=case_detail.order_id AND reimburse_details.ID_ACCOUNT=case_detail.ID_ACCOUNT AND reimburse_details.case_id=case_detail.case_id');
        $this->db->join('users','users.ID_ACCOUNT=case_detail.ID_ACCOUNT');
        $this->db->where('case_detail.ID_ACCOUNT',$account_id);
        $this->db->where('case_detail.status','6');
        $this->db->where('case_detail.deleted','0');
        $this->db->order_by('case_detail.date','desc');
        $this->db->where('case_detail.date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
        if (!empty($start_date))
        {
            $this->db->where('feedback_orders.shipmentdate >=',$start_date);
        }
        if (!empty($end_date))
        {
            $this->db->where('feedback_orders.shipmentdate <=',$end_date);
        }
        $orderTrackingInfo = $this->db->get('case_detail');
        return $orderTrackingInfo->result_array();
    }

    public function getaffiliateusercommissions($accountID)
    {
        echo $accountID;

        $this->db->where('ID_ACCOUNT', $accountID);
        return $this->db->get('accounts')->row_array();
    }

    public function fetchaffiliatecommissionbyaccountid($accountID)
    {
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('status', '0');
        return $this->db->get('affliate_commission')->row_array();
    }

    public function Useramountcount($accountID)
    {
        $this->db->select('count(payment_history.ID_ACCOUNT) CountAccountID , sum(payment_history.total_amount) as UserTotalAmount');
        $this->db->from('payment_history');
        $this->db->where('ID_ACCOUNT', $accountID);
        $payment_history = $this->db->get();
        return $payment_history->result_array();
    }

    public function AorCaseGeneration($accountId,$type)
    {
        $this->db->select('order_removal_shipment.status,order_removal_shipment.ID_ACCOUNT,order_removal_shipment.case_type,order_removal_shipment.order_id,order_removal_shipment.sku,case_detail.order_id,case_detail.id');
        $this->db->from('order_removal_shipment');
        $this->db->join('case_detail', 'case_detail.order_id=order_removal_shipment.id', 'left' );
        $this->db->where("order_removal_shipment.status",'1');
        $this->db->where("order_removal_shipment.ID_ACCOUNT",$accountId);
        $this->db->where("order_removal_shipment.case_type",$type);
        $this->db->where("case_detail.deleted",'0');
        return $result=  $this->db->get()->result_array();
    }

    public function getAorDetailsIdType($order_id,$account_id,$type)
    {
        $this->db->select('case_detail.*,order_removal_shipment.id,order_removal_shipment.ID_ACCOUNT,order_removal_shipment.case_type,order_removal_shipment.sku,order_removal_shipment.order_id,order_removal_shipment.fnsku,order_removal_shipment.carrier,order_removal_shipment.ID_ACCOUNT');
        $this->db->join('case_detail','case_detail.order_id = order_removal_shipment.id');
        $this->db->where('order_removal_shipment.id',$order_id);
        $this->db->where('order_removal_shipment.ID_ACCOUNT',$account_id);
        $this->db->where('order_removal_shipment.case_type',$type);
        $result = $this->db->get('order_removal_shipment');
        return $result->result_array();
    }

    public function getInventoryAor($id,$account_id,$type,$sku)
    {
        $this->db->select("*");
        $this->db->from("order_removal_shipment");
        $this->db->where('id',$id);
        $this->db->where("ID_ACCOUNT",$account_id);
        $this->db->where("case_type",$type);
        $this->db->where("sku",$sku);
        $this->db->where('status IS NOT NULL');
        return $this->db->get()->result_array();
    }

    public function updateAORorderDetailsData($sku,$data)
    {
        $this->db->where('sku',$sku);
        $this->db->update('order_removal_shipment',$data);
        return $this->db->affected_rows();
    }
    public function updateAORDetails($id,$accountId,$type,$data)
    {
        $this->db->where('order_id',$id);
        $this->db->where('ID_ACCOUNT',$accountId);
        $this->db->where('Case_Type',$type);
        $this->db->update('case_detail', $data);
        return $this->db->affected_rows();
    }

    # This functionuse to change status in case_detail database
    public function updateCaseStatusToDoAOR($id,$data)
    {
        $this->db->where_in('id',$id);
        $this->db->update('order_removal_shipment',$data);
        return $this->db->affected_rows();
    }

    public function updateStripePaymentFailUser($account_id,$stripechargefail)
    {
        $this->db->where('ID_ACCOUNT',$account_id);
        $this->db->update('users',$stripechargefail);
        return $this->db->affected_rows();
    }
    // update reimbursement case detail after payment complete
    public function updateReimbursementStatus( $id, $status ) {
        $this->db->where( 'id', $id )->update( "reimburse_details", $status );
    }

}