<?php

class Inventory_salvager_model_historical extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    public function getInventoryDetails($accountID){
        $where =  ('(reason="5" OR reason="6" OR reason="D" OR reason="E" OR reason="H" OR reason="K" OR reason="U")');
        $this->db->where('status IS NULL')->where('ID_ACCOUNT', $accountID)->where($where);
        $this->db->order_by('adjusted_date','asc');
        $this->db->limit(1);
        return  $this->db->get("inventory_detail")->row_array();
    }

    public function getInventoryDetailsgroupbysku($accountID){
        $this->db->select('sku, sum(quantity) as TotalQty ');
        $where =  ('(reason="5" OR reason="6" OR reason="D" OR reason="E" OR reason="H" OR reason="K" OR reason="U")');
        $this->db->where('status IS NULL')->where('ID_ACCOUNT', $accountID)->where($where);
        $this->db->order_by('adjusted_date','asc');
        $this->db->group_by('sku');
        return $this->db->get("inventory_detail")->result_array();
    }

    public function getallInventoryDetails($accountID, $sku){

        $where =  ('(reason="5" OR reason="6" OR reason="D" OR reason="E" OR reason="H" OR reason="K" OR reason="U")');
        $this->db->select('*');
        $this->db->where('ID_ACCOUNT', $accountID)->where('sku', $sku)->where($where)->where('status IS NULL');
        $result =  $this->db->get("inventory_detail")->result_array();
        return $result;
    }

    public function getReimbursementDetailsgroupbysku($accountID,$sku){
        $where =  ('(reason="Damaged_Warehouse" OR reason="Lost_Warehouse")');
        $this->db->select('sum(quantity_reimbursed_total) as TotalreimbursementQty');
        $this->db->where('ID_ACCOUNT', $accountID)->where('sku',$sku)->where($where)->where('status', '0');
        $this->db->group_by("sku");
        $result =  $this->db->get("reimburse_details")->row_array();
        return $result;
    }

    public function getallReimbursementDetails($accountID, $sku)
    {
        $where =  ('(reason="Damaged_Warehouse" OR reason="Lost_Warehouse")');
        $this->db->select('*');
        $this->db->where('ID_ACCOUNT', $accountID)->where('sku',$sku)->where($where)->where('status', '0');
        $result =  $this->db->get("reimburse_details")->result_array();
        return $result;
    }

    public function getInventory(){
        $where =  ('disposition="DAMAGE" OR disposition="LOSS"');
        return $this->db->where('status','1')->where($where)->get("inventory_detail")->result_array();
    }
    public function getReimburseDetailsByUserId($accountId,$fnsku,$sku){
        return $this->db->where('fnsku',$fnsku)->where('order_id','')->where('sku',$sku)->where('ID_ACCOUNT',$accountId)->where('status','0')->get("reimburse_details")->result_array();
    }
    public function updateReimburseDetailsById($ID){
        $param = array('status'=>'1');
        $this->db->where('id',$ID);
        return $this->db->update("reimburse_details", $param);
    }
    public function updateInventoryDetailsData($data,$itemId,$accountId){
        $this->db->where('transaction_item_id',$itemId);
        $this->db->where('ID_ACCOUNT',$accountId);
        $this->db->update('inventory_detail', $data);
        return $this->db->affected_rows();
    }
    public function updateInventoryCaseDetails($data,$inventoryId,$accountId){
        $this->db->where('inventoryItemId',$inventoryId);
        $this->db->where('accountId',$accountId);
        $this->db->update('case_details_inventory', $data);
        return $this->db->affected_rows();
    }
    public function insertCaseId($data){
        $this->db->insert("case_details_inventory", $data);
        return $this->db->insert_id();
    }
    public function getInventoryCaseByAccountId($accountId ='',$days =''){
        $this->db->select('case_details_inventory.*, inventory_detail.transaction_item_id, inventory_detail.fnsku, inventory_detail.quantity, reimburse_details.quantity_reimbursed_inventory, reimburse_details.amount_total');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId');
        $this->db->join('reimburse_details','reimburse_details.case_id=case_details_inventory.caseId','left');
        $this->db->where('case_details_inventory.status >=', '1');
        if($accountId==''){

        }else{
            $this->db->where('case_details_inventory.accountId', $accountId);
        }
        if ($days != 0) {
            $this->db->where('case_details_inventory.date >=', $days);
            $this->db->where('case_details_inventory.date <=', date('Y-m-d h:i:s'));
        }
        $this->db->distinct('case_details_inventory.id');
        $this->db->from('case_details_inventory');
        return $this->db->get()->result_array();
    }
    //get  damage inventory detail of particular user
    public function getInventoryUserwise($userId=''){
        if($userId==''){
            $where =  ('(disposition="DAMAGE" OR disposition="LOSS")');
            return $this->db->where('status','1')->where($where)->get("inventory_detail")->result_array();
        }else{
            $where =  ('(disposition="DAMAGE" OR disposition="LOSS")');
            return $this->db->where('ID_ACCOUNT',$userId)->where('status','1')->where($where)->get("inventory_detail")->result_array();

        }
    }
    //get details which need payment from stripe for inventory cases
    public function getInventoryPaymentCases($userAccountId=''){
        $this->db->select('case_details_inventory.id, case_details_inventory.inventoryItemId, case_details_inventory.caseId, reimburse_details.amount_total, reimburse_details.currency_unit, reimburse_details.reimburse_id');
        $this->db->join('reimburse_details','reimburse_details.case_id=case_details_inventory.caseId');
        $this->db->from('case_details_inventory');
        if($userAccountId==''){

        }else{
            $this->db->where('case_details_inventory.accountId',$userAccountId);
        }
        $this->db->where('case_details_inventory.status','1');
        return $this->db->get()->result_array();
    }
    public function getInventoryCaseByfilter($user,$start_date,$end_date)
    {
        $this->db->select('case_details_inventory.*, inventory_detail.* '); $this->db->select('case_details_inventory.*, inventory_detail.transaction_item_id, inventory_detail.fnsku, inventory_detail.quantity, reimburse_details.quantity_reimbursed_inventory, reimburse_details.amount_total');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId');
        $this->db->join('reimburse_details','reimburse_details.case_id=case_details_inventory.caseId','left');
        $this->db->where('case_details_inventory.status >=', '1');
        $this->db->where('case_detail.deleted =', '0');
        if(!empty($user))
            $this->db->where('case_details_inventory.accountId', $user);
        if(!empty($start_date))
            $this->db->where('case_details_inventory.date >=', $start_date);
        if(!empty($end_date))
            $this->db->where('case_details_inventory.date <=', $end_date);
        $this->db->distinct('case_details_inventory.id');
        $this->db->from('case_details_inventory');
        return $this->db->get()->result_array();
    }
    public function getlast_inventory_cases($accountid='')
    {
        $this->db->order_by('id', 'desc');
        if(!empty($accountid))
            $this->db->where('accountId',$accountid);
        $this->db->where('status','1');
        $this->db->limit(5);
        return  $this->db->get('case_details_inventory')->result_array();
    }

    function edit_case_by_account_id($id)
    {
        return $this->db->select('*')->where('id',$id)->get('case_detail')->row_array();
    }

    public function updateCaseBYId($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('case_detail',$data);
        return $this->db->affected_rows();
    }

    function delete_case_by_account_id($ID_ACCOUNT)
    {
        $array = array('deleted'=>'1');
        $this->db->where('id',$ID_ACCOUNT)->update('case_detail',$array);
    }

    public function getalllostInventoryCount($accountID)
    {
        $where = ('(reason="M")');
        $this->db->select('*, SUM(quantity) AS TotalQty');
        $this->db->where('status IS NULL');
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where($where);
        $this->db->group_by('fnsku');
        $result = $this->db->get("inventory_detail")->result_array();
        return $result;
    }

    public function getallfoundInventoryCount($accountID, $fnsku){
        $where = ('(reason="F" OR reason="N")');
        $this->db->select('*, SUM(quantity) AS TotalFoundQty');
        $this->db->where('status IS NULL');
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('fnsku', $fnsku);
        $this->db->where($where);
        $this->db->group_by('fnsku');
        $result = $this->db->get("inventory_detail")->row_array();
        return $result;
    }

    public function getalllostInventoryDetails($accountID, $fnsku)
    {
        $where = ('(reason="M")');
        $this->db->select('*');
        $this->db->where('status IS NULL');
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('fnsku', $fnsku);
        $this->db->where($where);
        $result = $this->db->get("inventory_detail")->result_array();
        return $result;
    }

    public function getallfoundInventoryDetail($accountID, $fnsku){
        $where = ('(reason="F" OR reason="N")');
        $this->db->select('*');
        $this->db->where('status IS NULL');
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('fnsku', $fnsku);
        $this->db->where($where);
        $result = $this->db->get("inventory_detail")->result_array();
        return $result;
    }

    public function getallReimbursementCount($accountID, $fnsku){
        $where = ('(reason="Lost_Warehouse")');
        $this->db->select('*, SUM(quantity_reimbursed_cash) AS TotalReimbursementQty');
        $this->db->where('case_id','');
        $this->db->where('status','0');
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('fnsku', $fnsku);
        $this->db->where($where);
        $this->db->group_by('fnsku');
        $result = $this->db->get("reimburse_details")->row_array();
        return $result;
    }

    public function getallReimbursementDetail($accountID, $fnsku){
        $where = ('(reason="Lost_Warehouse")');
        $this->db->select('*');
        $this->db->where('case_id','');
        $this->db->where('status','0');
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('fnsku', $fnsku);
        $this->db->where($where);
        $result = $this->db->get("reimburse_details")->result_array();
        return $result;
    }

    public function updatefoundDetailsById($ID)
    {
        $param = array('status'=>'1');
        $this->db->where('id',$ID);
        return $this->db->update("inventory_detail", $param);
    }


}