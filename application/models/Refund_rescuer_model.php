<?php

class Refund_rescuer_Model extends CI_Model {

    public function add_customer_return_order($data) {
        $this->db->insert('return_customer_order', $data);
        return $this->db->insert_id();
    }

    public function add_reimbursement_detail($data) {
        $this->db->insert('reimburse_details', $data);
        return $this->db->insert_id();
    }

    public function add_adjustment_inventory($data) {
        $this->db->insert('inventory_detail', $data);
        return $this->db->insert_id();
    }

    function custom_count_feedback_order($params) {
        $countTotal = $this->db->get_where('return_customer_order', $params);
        return $countTotal->num_rows();
    }

    function custom_count_reimbursement_case($params) {
        $countTotal = $this->db->get_where('reimburse_details',$params);
        return $countTotal->num_rows();
    }

    function custom_count_adjustment_inventory($params) {
        $countTotal = $this->db->get_where('inventory_detail', $params);
        return $countTotal->num_rows();
    }

    function update_reimbursement_detail($id,$orderParam)
    {
        $this->db->where('id',$id);
        return $this->db->update('reimburse_details',$orderParam);
    }

    function updateCaseDetailbyOrderIdandAccountID($orderID, $accountID){
        $this->db->where('order_id', $orderID);
        $this->db->where('ID_ACCOUNT', $accountID);
        $result = $this->db->get('case_detail')->row_array();
        if($result){
            $data = array('status' => 3, 'deleted' => 1);
            $this->db->where('id', $result['id']);
            return $this->db->update('case_detail', $data);
        } else{
            return;
        }
    }
    public function updateCaseInventoryDetail($caseId, $accoundID, $fnsku){
        $this->db->where('caseId',$caseId);
        $this->db->where('accountId',$accoundID);
        $caseDetails = $this->db->get('case_details_inventory')->result_array();

        if(!empty($caseDetails[0])){
            foreach($caseDetails as $case_detail){
                $this->db->where('transaction_item_id',$case_detail['inventoryItemId']);
                $this->db->where('ID_ACCOUNT',$accoundID);
                $inventoryTransactionDetail = $this->db->get('inventory_detail')->row_array();
                if($inventoryTransactionDetail){
                    if($inventoryTransactionDetail['fnsku'] == $fnsku && $case_detail['status']=='0'){
                        $updateArray = array(
                            'status' => '3'
                        );
                        $this->db->where('id', $case_detail['id']);
                        $this->db->update('case_details_inventory',$updateArray);
                    }
                }
            }
        }
        return;
    }

}
