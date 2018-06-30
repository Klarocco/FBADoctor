<?php

class Inventory_salvager_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getInventoryDetailsData($startDate,$endDate,$fnsku,$accountId,$caseType)
    {
        $this->db->select("*");
        $this->db->from("inventory_detail");
        $this->db->where("adjusted_date >=",$startDate);
        $this->db->where("adjusted_date <=",$endDate);
        $this->db->where("fnsku",$fnsku);
        $this->db->where("ID_ACCOUNT",$accountId);
        $this->db->where('case_type',$caseType);
        $this->db->where('status IS NOT NULL');
        return $this->db->get()->result_array();
    }
    public function getTotalQuantityFnskUDetailsByAccountId($accountId,$type)
    {
        $this->db->select('count(`inventory_detail`.`quantity`) as totalqty');
        $this->db->from('case_details_inventory');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId','left');
        $this->db->where('case_details_inventory.accountId',$accountId);
        $this->db->where('inventory_detail.ID_ACCOUNT',$accountId);
        if(!empty($type))
        {
            $this->db->where('inventory_detail.case_type',$type);
        }
        $this->db->where('case_details_inventory.deleted','0');
        $this->db->where('case_details_inventory.status','0');
        $this->db->group_by('inventory_detail.fnsku');
        return  $result = $this->db->get()->result_array();
    }
    public function getInventoryCasesByAcountIdAndCaseType($accountId,$type){
        $this->db->select('inventory_detail.id,inventory_detail.case_type,inventory_detail.quantity,inventory_detail.transaction_item_id,inventory_detail.ID_ACCOUNT,
        case_details_inventory.report_start_date,case_details_inventory.report_end_date,case_details_inventory.id,inventory_detail.fnsku');
        $this->db->from('inventory_detail');
        $this->db->join('case_details_inventory', 'case_details_inventory.inventoryItemId=inventory_detail.transaction_item_id', 'left' );
        $this->db->where("inventory_detail.status",'1');
        $this->db->where("inventory_detail.ID_ACCOUNT",$accountId);
        $this->db->where("inventory_detail.case_type",$type);
        $this->db->where("case_details_inventory.report_start_date IS NOT NULL" );
        $this->db->where("case_details_inventory.report_end_date IS NOT NULL" );
        $this->db->group_by('inventory_detail.transaction_item_id');
        $this->db->order_by('case_details_inventory.report_start_date','asc');
        return $result=  $this->db->get()->result_array();
    }
    public function getFnskUDetailsByStartEndDateAccountIdType($startDate,$endDate,$accountId,$type)
    {
        $this->db->select('*, sum(`inventory_detail`.`quantity`) as totalqty');
        $this->db->from('case_details_inventory');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId','left');
        $this->db->where('case_details_inventory.report_start_date',$startDate);
        $this->db->where('case_details_inventory.report_end_date',$endDate);
        $this->db->where('case_details_inventory.accountId',$accountId);
        $this->db->where('case_details_inventory.caseId', '');
        $this->db->where('case_details_inventory.deleted','0');
        $this->db->where('inventory_detail.ID_ACCOUNT',$accountId);
        $this->db->where('inventory_detail.case_type',$type);
        $this->db->group_by('inventory_detail.fnsku');
        return $result = $this->db->get()->result_array();
    }

    public function getAsidDetailsIdType($inventoryItemId,$account_id,$type)
    {
        $this->db->select('case_details_inventory.*,inventory_shipment_detail.*');
        $this->db->join('inventory_shipment_detail','case_details_inventory.inventoryItemId = inventory_shipment_detail.id');
        $this->db->where('case_details_inventory.inventoryItemId',$inventoryItemId);
        $this->db->where('case_details_inventory.accountId',$account_id);
        $this->db->where('case_details_inventory.Case_Type',$type);
        $this->db->where('case_details_inventory.caseId', '');
        $result = $this->db->get('case_details_inventory');
        return $result->result_array();
    }

    public function getInventoryDetails(){
        $where =  ('(disposition="DAMAGE" OR disposition="LOSS")');
        return $this->db->where('status IS NULL')->where($where)->get("inventory_detail")->result_array();
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
    public function updateInventoryDetailsData($accountId,$itemId,$data){
        $this->db->where('transaction_item_id',$itemId);
        $this->db->where('ID_ACCOUNT',$accountId);
        $this->db->update('inventory_detail', $data);
        return $this->db->affected_rows();
    }
    public function updateInventoryCaseDetails($accountId,$itemId,$data){
        $this->db->where('inventoryItemId',$itemId);
        $this->db->where('accountId',$accountId);
        $this->db->update('case_details_inventory', $data);
        return $this->db->affected_rows();
    }

    public function insertCaseId($data)
    {
        $this->db->insert("case_details_inventory", $data);
        return $this->db->insert_id();
    }

    public function getInventoryCaseByAccountId($accountId = null,$days = null,$start_date = null,$end_date = null)
    {
        $this->db->select('case_details_inventory.*, inventory_detail.transaction_item_id, inventory_detail.fnsku,inventory_detail.sku, inventory_detail.quantity, feedback_orders.small_img_url,feedback_orders.productname');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId');
        $this->db->join('feedback_orders','feedback_orders.sku=inventory_detail.sku','left');
        $this->db->where('case_details_inventory.status >=','1');
        $this->db->where('case_details_inventory.deleted','0');
        if(!empty($accountId))
        {
            $this->db->where('case_details_inventory.accountId', $accountId);
            $this->db->where('inventory_detail.ID_ACCOUNT', $accountId);
        }
        if(!empty($days))
        {
            $this->db->where('case_details_inventory.date >=', $days);
            $this->db->where('case_details_inventory.date <=', date('Y-m-d 23:59:59'));
        }
        if(!empty($start_date))
        {
            $this->db->where('case_details_inventory.date >=', $start_date);
        }
        if(!empty($end_date))
        {
            $this->db->where('case_details_inventory.date <=', $end_date);
        }
        $this->db->group_by('case_details_inventory.id');
        $this->db->from('case_details_inventory');
        $result =  $this->db->get()->result_array();

        $this->db->select( 'case_details_inventory.*, inventory_shipment_detail.id as transaction_item_id, inventory_shipment_detail.seller_sku as sku,inventory_shipment_detail.fulfillment_network_sku as fnsku, (inventory_shipment_detail.qty_shipped - inventory_shipment_detail.qty_received) as quantity,feedback_orders.small_img_url,feedback_orders.productname');
        $this->db->join( 'inventory_shipment_detail', 'inventory_shipment_detail.id=case_details_inventory.inventoryItemId' );
        $this->db->join( 'feedback_orders', 'feedback_orders.sku=inventory_shipment_detail.seller_sku', 'left' );
        $this->db->where( 'case_details_inventory.status >=', '1' );
        $this->db->where( 'case_details_inventory.deleted', '0' );
        if ( ! empty( $accountId ) ) {
            $this->db->where( 'case_details_inventory.accountId', $accountId );
            $this->db->where( 'inventory_shipment_detail.ID_ACCOUNT', $accountId );
        }
        if ( ! empty( $days ) ) {
            $this->db->where( 'case_details_inventory.date >=', $days );
            $this->db->where( 'case_details_inventory.date <=', date( 'Y-m-d 23:59:59' ) );
        }
        if ( ! empty( $start_date ) ) {
            $this->db->where( 'case_details_inventory.date >=', $start_date );
        }
        if ( ! empty( $end_date ) ) {
            $this->db->where( 'case_details_inventory.date <=', $end_date );
        }
        $this->db->group_by( 'case_details_inventory.id' );
        $this->db->from( 'case_details_inventory' );
        $resultInventoryShipment = $this->db->get()->result_array();
        return array_merge($result, $resultInventoryShipment);
    }

    public function fetchreimbursementamount($case_id,$account_id,$sku)
    {
        $this->db->select('*');
        $this->db->where('case_id',$case_id);
        $this->db->where('ID_ACCOUNT',$account_id);
        $this->db->where('sku',$sku);
        return $this->db->get( 'reimburse_details' )->row_array();
    }

    public function getInventoryUserwise($userId='')
    {
        if($userId=='')
        {
            $where = ('(case_type="UDW" OR case_type="ULW")');
            return $this->db->where('status','1')->where($where)->get("inventory_detail")->result_array();
        }
        else
        {
            $where = ('(case_type="UDW" OR case_type="ULW")');
            return $this->db->where('ID_ACCOUNT',$userId)->where('status','1')->where($where)->get("inventory_detail")->result_array();

        }
    }
    //get details which need payment from stripe for inventory cases
    /*public function getInventoryPaymentCases($userAccountId=''){
        $this->db->select('case_details_inventory.id, case_details_inventory.inventoryItemId, case_details_inventory.caseId, reimburse_details.amount_total, reimburse_details.currency_unit, reimburse_details.reimburse_id');
        $this->db->join('reimburse_details','reimburse_details.case_id=case_details_inventory.caseId');
        $this->db->from('case_details_inventory');
        if($userAccountId==''){

        }else{
            $this->db->where('case_details_inventory.accountId',$userAccountId);
        }
        $this->db->where('case_details_inventory.status','1');
        return $this->db->get()->result_array();
    }*/
    public function getInventoryPaymentCases( $userAccountId = '' ) {
        $this->db->select( 'case_details_inventory.id, case_details_inventory.inventoryItemId, case_details_inventory.caseId, 
		reimburse_details.fnsku,reimburse_details.amount_total, reimburse_details.actual_reimbursed,reimburse_details.currency_unit, reimburse_details.reimburse_id,
		reimburse_details.approval_date');
        $this->db->join( 'reimburse_details', 'reimburse_details.case_id=case_details_inventory.caseId' );
        $this->db->join( 'inventory_detail', 'case_details_inventory.inventoryItemId=inventory_detail.transaction_item_id' );
        $this->db->from( 'case_details_inventory' );
        if ( $userAccountId == '' ) {
        } else {
            $this->db->where( 'case_details_inventory.accountId', $userAccountId );
        }
        $this->db->where( 'case_details_inventory.status <>', '0' );
        $this->db->where( 'case_details_inventory.status <>', '3' );
        $this->db->where( 'reimburse_details.status', '0' );
        $this->db->where('reimburse_details.fnsku = inventory_detail.fnsku');
        $this->db->group_by('case_details_inventory.inventoryItemId');
        $result = $this->db->get()->result_array();

        // Query for Inventory ASID Cases
        $this->db->select( 'case_details_inventory.id, case_details_inventory.inventoryItemId, case_details_inventory.caseId, 
		reimburse_details.fnsku,reimburse_details.amount_total, reimburse_details.actual_reimbursed,reimburse_details.currency_unit, reimburse_details.reimburse_id,
		reimburse_details.approval_date');
        $this->db->join( 'reimburse_details', 'reimburse_details.case_id=case_details_inventory.caseId' );
        $this->db->join( 'inventory_shipment_detail', 'case_details_inventory.inventoryItemId=inventory_shipment_detail.id' );
        $this->db->from( 'case_details_inventory' );
        if ( $userAccountId == '' ) {
        } else {
            $this->db->where( 'case_details_inventory.accountId', $userAccountId );
        }
        $this->db->where( 'case_details_inventory.status <>', '0' );
        $this->db->where( 'case_details_inventory.status <>', '3' );
        $this->db->where( 'reimburse_details.status', '0' );
        $this->db->where('reimburse_details.fnsku = inventory_shipment_detail.fulfillment_network_sku');
        $this->db->group_by('case_details_inventory.inventoryItemId');
        $resultASID = $this->db->get()->result_array();
        return array_merge($result, $resultASID);
    }
    public function getInventoryCaseByfilter($user,$start_date,$end_date)
    {
        $this->db->select('case_details_inventory.*, inventory_detail.transaction_item_id, inventory_detail.fnsku,inventory_detail.sku, inventory_detail.quantity, reimburse_details.quantity_reimbursed_inventory, reimburse_details.amount_total,feedback_orders.small_img_url,feedback_orders.productname');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId');
        $this->db->join('reimburse_details','reimburse_details.case_id=case_details_inventory.caseId','left');
        $this->db->join('feedback_orders','feedback_orders.sku=inventory_detail.sku','left');
        $this->db->where('case_details_inventory.status >=', '1');
        $this->db->where('case_details_inventory.deleted','0');

        if(!empty($user))
        $this->db->where('case_details_inventory.accountId', $user);
        if(!empty($start_date))
        $this->db->where('case_details_inventory.date >=', $start_date);
        if(!empty($end_date))
        $this->db->where('case_details_inventory.date <=', $end_date);
        $this->db->group_by('case_details_inventory.id');
        $this->db->from('case_details_inventory');
        return $this->db->get()->result_array();
    }
    public function getlast_inventory_cases($accountid='')
    {
         $this->db->order_by('id', 'desc');
         if(!empty($accountid))
         $this->db->where('accountId',$accountid);
         $this->db->where('status <>','0');
         $this->db->where('deleted','0');
         $this->db->group_by('caseid');
         $this->db->limit(5);
         return  $this->db->get('case_details_inventory')->result_array();
    }

    function edit_case_by_account_id($id)
    {
        return $this->db->select('*')->where('id',$id)->get('case_details_inventory')->row_array();
    }

    public function updateCaseBYId($id,$data)
    {
        $this->db->where('inventoryItemId',$id);
        $this->db->update('case_details_inventory',$data);
        return $this->db->affected_rows();
    }

    function delete_case_by_account_id($ID_ACCOUNT)
    {
        $data = array('deleted'=>'1');
        $this->db->where('id',$ID_ACCOUNT)->update('case_details_inventory',$data);
    }

    function delete_case_by_account_id_inventory($inventoryId)
    {
        $data = array('deleted'=>'1');
        $this->db->where('inventoryItemId',$inventoryId)->update('case_details_inventory',$data);
    }

    function getAllgeneratedCasesByUserId_Detail($id)
    {
        $this->db->select('case_details_inventory.*, inventory_detail.transaction_item_id, inventory_detail.fnsku,inventory_detail.sku, inventory_detail.quantity,inventory_detail.case_type, reimburse_details.quantity_reimbursed_inventory, reimburse_details.amount_total,feedback_orders.small_img_url,feedback_orders.productname');
        $this->db->join('inventory_detail','inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId');
        $this->db->join('reimburse_details','reimburse_details.case_id=case_details_inventory.caseId','left');
        $this->db->join('feedback_orders','feedback_orders.sku=inventory_detail.sku','left');
        $this->db->where('case_details_inventory.id',$id);
        $this->db->from( 'case_details_inventory' );
        $result = $this->db->get()->result_array();

        $this->db->select( 'case_details_inventory.*, inventory_shipment_detail.id as transaction_item_id, inventory_shipment_detail.seller_sku as sku,inventory_shipment_detail.fulfillment_network_sku as fnsku, (inventory_shipment_detail.qty_shipped - inventory_shipment_detail.qty_received) as quantity,feedback_orders.small_img_url,feedback_orders.productname');
        $this->db->join( 'inventory_shipment_detail', 'inventory_shipment_detail.id=case_details_inventory.inventoryItemId' );
        $this->db->join( 'feedback_orders', 'feedback_orders.sku=inventory_shipment_detail.seller_sku', 'left' );
        $this->db->where('case_details_inventory.id',$id);
        $this->db->from( 'case_details_inventory' );
        $resultInventoryShipment = $this->db->get()->result_array();
        return array_merge($result, $resultInventoryShipment);

    }

    public function getallInventoryDetails($accountID, $startDate,$endDate){
        $this->db->select('*, sum(quantity) as TotalQty ');
        $where =  ('(reason="5" OR reason="6" OR reason="D" OR reason="E" OR reason="H" OR reason="K" OR reason="U")');
        $this->db->where('status IS NULL')->where('ID_ACCOUNT', $accountID)->where($where)->where( 'adjusted_date >=', $startDate )->where( 'adjusted_date <=', $endDate );
        $result =  $this->db->get("inventory_detail")->result_array();
        return $result;
    }

    # This function use to get all case change status in case_change_status table
    public function get_case_change_status()
    {
        $this->db->select('*');
        $case_status = $this->db->get('case_change_status');
        $case_status_change = $case_status->result();
        return $case_status_change;
    }

    # this function use to get all all status change in case_detail inventory
    public function updateCaseStatusDetail($id,$data)
    {
        $this->db->where_in('inventoryItemId',$id);
        $this->db->update('case_details_inventory',$data);
        return $this->db->affected_rows();
    }

    # This functionuse to change status in case_detail database
    public function updateCaseStatusToDOInvnetory($id,$data)
    {
        $this->db->where_in('transaction_item_id',$id);
        $this->db->update('inventory_detail',$data);
        return $this->db->affected_rows();
    }

    public function updateASIDCaseStatusToDOInvnetory($id,$data)
    {
        $this->db->where_in('id',$id);
        $this->db->update('inventory_shipment_detail',$data);
        return $this->db->affected_rows();
    }

     # This function use to get all record
    public function allRecordDisplayInventory($id)
    {
        $this->db->select('*');
        $this->db->where_in('inventoryItemId',$id);
        $caseRecord= $this->db->get('case_details_inventory');
        $case_data = $caseRecord->result();
        return $case_data;
    }

    # This fucntion use to get all record
    public function insertCaseLogDetailInventory($insert_data)
    {
        $this->db->insert('inventory_case_status_log', $insert_data);
        return $this->db->insert_id();
    }

    public function getReimbursementDetailsgroupbysku($accountID,$startDate ,$endDate, $sku){
        $where =  ('(reason="Damaged_Warehouse" OR reason="Lost_Warehouse")');
        $this->db->select('sum(quantity_reimbursed_total) as TotalreimbursementQty');
        $this->db->where('ID_ACCOUNT', $accountID)->where($where)->where('status', '0')->where('sku',$sku);
        $this->db->where( 'approval_date >=', $startDate );
        $this->db->where( 'approval_date <=', $endDate );
        $this->db->group_by("sku");
        $result =  $this->db->get("reimburse_details")->row_array();
        return $result;
    }

    public function getallInventoryDetailsStartEndDate( $accountID, $startDate ,$endDate) {
        $where = ( '(reason="5" OR reason="6" OR reason="D" OR reason="E" OR reason="H" OR reason="K" OR reason="U")' );
        $this->db->select( '*' );
        $this->db->where( 'status IS NULL' )->where( 'ID_ACCOUNT', $accountID )->where( $where )->where( 'adjusted_date >=', $startDate )->where( 'adjusted_date <=', $endDate );
        $result = $this->db->get( "inventory_detail" )->result_array();
        return $result;
    }

    public function getallReimbursementDetails( $accountID, $startDate, $endDate, $fnsku ) {
        $where = ( '(reason="Lost_Warehouse")' );
        $this->db->select( '*' );
        $this->db->where( 'case_id', '' );
        $this->db->where( 'status', '0' );
        $this->db->where( 'ID_ACCOUNT', $accountID );
        $this->db->where( 'approval_date >=', $startDate );
        $this->db->where( 'approval_date <=', $endDate );
        $this->db->where( 'fnsku', $fnsku );
        $this->db->where( $where );
        $result = $this->db->get( "reimburse_details" )->result_array();
        return $result;
    }

    public function getalllostInventoryCount( $accountID, $startDate, $endDate ) {
        $where = ( '(reason="M")' );
        $this->db->select( '*, SUM(quantity) AS TotalQty' );
        $this->db->where( 'status IS NULL' );
        $this->db->where( 'ID_ACCOUNT', $accountID );
        $this->db->where( 'adjusted_date >=', $startDate );
        $this->db->where( 'adjusted_date <=', $endDate );
        $this->db->where( $where );
        $this->db->group_by( 'fnsku' );
        $result = $this->db->get( "inventory_detail" )->result_array();
        return $result;
    }

    public function getallfoundInventoryCount( $accountID, $startDate, $endDate, $fnsku ) {
        $where = ( '(reason="F" OR reason="N")' );
        $this->db->select( '*, SUM(quantity) AS TotalFoundQty' );
        $this->db->where( 'status IS NULL' );
        $this->db->where( 'ID_ACCOUNT', $accountID );
        $this->db->where( 'adjusted_date >=', $startDate );
        $this->db->where( 'adjusted_date <=', $endDate );
        $this->db->where( 'fnsku', $fnsku );
        $this->db->where( $where );
        $this->db->group_by( 'fnsku' );
        $result = $this->db->get( "inventory_detail" )->row_array();
        return $result;
    }

    public function getalllostInventoryDetails( $accountID, $startDate, $endDate, $fnsku ) {
        $where = ( '(reason="M")' );
        $this->db->select( '*' );
        $this->db->where( 'status IS NULL');
        $this->db->where( 'ID_ACCOUNT', $accountID );
        $this->db->where( 'adjusted_date >=', $startDate );
        $this->db->where( 'adjusted_date <=', $endDate );
        $this->db->where( 'fnsku', $fnsku );
        $this->db->where( $where );
        $result = $this->db->get( "inventory_detail" )->result_array();
        return $result;
    }

    public function getallfoundInventoryDetail( $accountID, $startDate, $endDate, $fnsku ) {
        $where = ( '(reason="F" OR reason="N")' );
        $this->db->select( '*' );
        $this->db->where( 'status IS NULL' );
        $this->db->where( 'ID_ACCOUNT', $accountID );
        $this->db->where( 'adjusted_date >=', $startDate );
        $this->db->where( 'adjusted_date <=', $endDate );
        $this->db->where( 'fnsku', $fnsku );
        $this->db->where( $where );
        $result = $this->db->get( "inventory_detail" )->result_array();
        return $result;
    }

    public function getallReimbursementCount( $accountID, $startDate, $endDate, $fnsku ) {
        $where = ( '(reason="Lost_Warehouse")' );
        $this->db->select( '*, SUM(quantity_reimbursed_cash) AS TotalReimbursementQty' );
        $this->db->where( 'case_id', '' );
        $this->db->where( 'status', '0' );
        $this->db->where( 'ID_ACCOUNT', $accountID );
        $this->db->where( 'approval_date >=', $startDate );
        $this->db->where( 'approval_date <=', $endDate );
        $this->db->where( 'fnsku', $fnsku );
        $this->db->where( $where );
        $this->db->group_by( 'fnsku' );
        $result = $this->db->get( "reimburse_details" )->row_array();
        return $result;
    }

    public function getTotalinventorysuppliedcase( $accountId )
    {
        $this->db->select('sum(qty_shipped-qty_received) as Totalasid');
        $this->db->from('inventory_shipment_detail');
        $this->db->join('case_details_inventory', 'case_details_inventory.inventoryItemId = inventory_shipment_detail.id');
        $this->db->where('inventory_shipment_detail.ID_ACCOUNT', $accountId);
        $this->db->where('inventory_shipment_detail.case_type', 'ASID');
        $this->db->where('inventory_shipment_detail.status','1');
        $this->db->where('case_details_inventory.deleted','0');
        $result = $this->db->get()->row_array();
        return $result['Totalasid'];
    }

    public function ASIDCaseGeneration($accountId,$type)
    {
        $this->db->select('*');
        $this->db->from('inventory_shipment_detail');
        $this->db->join('case_details_inventory', 'case_details_inventory.inventoryItemId=inventory_shipment_detail.id', 'left' );
        $this->db->where("inventory_shipment_detail.status",'1');
        $this->db->where("inventory_shipment_detail.ID_ACCOUNT",$accountId);
        $this->db->where("inventory_shipment_detail.qty_shipped > inventory_shipment_detail.qty_received");
        $this->db->where("inventory_shipment_detail.case_type",$type);
        $this->db->where("case_details_inventory.deleted",'0');
        $this->db->where("case_details_inventory.report_start_date IS NOT NULL" );
        $this->db->where("case_details_inventory.report_end_date IS NOT NULL" );
        return $result=  $this->db->get()->result_array();
    }

    public function getInventoryASID($id,$account_id,$type,$sku)
    {
        $this->db->select("*");
        $this->db->from("inventory_shipment_detail");
        $this->db->where('id',$id);
        $this->db->where("ID_ACCOUNT",$account_id);
        $this->db->where("case_type",$type);
        $this->db->where("seller_sku",$sku);
        $this->db->where('status IS NOT NULL');
        return $this->db->get()->result_array();
    }

    public function updateInventoryShipmentDetailsData($sku,$data)
    {
        $this->db->where('seller_sku',$sku);
        $this->db->update('inventory_shipment_detail',$data);
        return $this->db->affected_rows();
    }
    public function updateInventoryShipmentDetails($id,$accountId,$type,$data)
    {
        $this->db->where('inventoryItemId',$id);
        $this->db->where('accountId',$accountId);
        $this->db->where('case_type',$type);
        $this->db->update('case_details_inventory', $data);
        return $this->db->affected_rows();
    }

    public function paymenthistorycheck($accountId, $reimbID, $caseid, $fnsku){
        $this->db->where('ID_ACCOUNT', $accountId);
        $this->db->where('reimburseid', $reimbID);
        $this->db->where('fnsku', $fnsku);
        $this->db->where('caseid', $caseid);
        return $this->db->get('payment_history')->row_array();
    }
    public function updatereimbursementdata($accountId, $reimbID, $caseid, $status){
        $this->db->where('ID_ACCOUNT', $accountId);
        $this->db->where('reimburse_id', $reimbID);
        $this->db->where('case_id', $caseid);
        return $this->db->update('reimburse_details', $status);
    }
    public function reimbursementRecordFetch($fnsku, $caseid){
        $this->db->where('fnsku',$fnsku);
        $this->db->where('case_id',$caseid);
        $this->db->where('status', '0');
        return $this->db->get('reimburse_details')->row_array();
    }

}