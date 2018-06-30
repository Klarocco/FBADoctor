<?php

class User_Model extends CI_Model{

    public function checkAccountById($id){
        return $this->db->select('*')->where('ID_ACCOUNT', $id)->get("accounts")->row_array();
    }

    public function checkAmzDateIterationIsExistsByAccount($accountId){
        return $this->db->select('*')->where('accountId', $accountId)->get("amzdateiteration")->result_array();
    }

    public function addAmzDateIteration($data){
        $this->db->insert("amzdateiteration", $data);
    }

    public function getAllActiveUsers(){
        $this->db->select("accounts.*,users.*");
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=users.ID_ACCOUNT', 'left');
        $this->db->where('users.active', '1');
        $this->db->where('users.stripe_charge', '0');
        $this->db->where('accounts.deleted', '0');
        return $this->db->get("users")->result_array();
    }

    public function getUser($email, $pass){
        return $this->db->select("ID")->where("email", $email)->where("password", $pass)->get("users");
    }

    public function getAllUsers(){
        return $this->db->select("*")->where('users.active', '1')->where('users.deleted', '0')->get("users")->result_array();
    }

    public function gethistoricalrecordcheck($accountID){
        $this->db->select('setinventoryhistorical');
        $this->db->where('ID_ACCOUNT', $accountID);
        return $this->db->get('feedback_settings')->row_array();
    }

    public function sethistoricalrecord($setHistoricalrecord, $accountID){
        $this->db->where("ID_ACCOUNT", $accountID)->update("feedback_settings", $setHistoricalrecord);
    }

    public function getUserDetailsById($userId){
        return $this->db->where('ID', $userId)->get("users")->row_array();
    }

    /*
     * for upload files
     */
    public function uploadFile($Files, $DestPath, $extra = ''){
        $Lastpos = strrpos($Files['name'], '.');
        $FileExtension = strtolower(substr($Files['name'], $Lastpos, strlen($Files['name'])));
        $ValidExtensionArr = array(".jpg", ".jpeg", ".png", ".gif", ".pdf", ".doc", ".csv");
        if (in_array(strtolower($FileExtension), $ValidExtensionArr)) {
            $FileName = '';
            if (!empty($extra)) {
                $FileName = $extra . $FileExtension;
            } else {
                $FileName = 'Logo' . $FileExtension;
            }
            if (move_uploaded_file($Files['tmp_name'], $DestPath . $FileName)) {
                return $FileName;
            } else
                return false;
        } else {
            return false;
        }
    }

    public function get_user_by_id($userid){
        return $this->db->where("ID", $userid)->get("users");
    }


    public function get_user_by_Account_id($ID_ACCOUNT){
        return $this->db->get_where('users', array('ID_ACCOUNT' => $ID_ACCOUNT))->row_array();
    }

    public function get_user_by_username($username){
        return $this->db->where("username", $username)->get("users");
    }

    public function delete_user($id){
        $this->db->where("ID", $id)->delete("users");
    }

    public function getAllActiveUsersorderbydesc(){
        return $this->db->select("*")->where('active', 1)->where('users.deleted', '0')->order_by('ID', 'desc')->get("users")->result_array();
    }

    public function get_new_members($limit){
        return $this->db->select("email, username, joined, oauth_provider")
            ->order_by("ID", "DESC")->limit($limit)->get("users");
    }

    public function get_registered_users_date($month, $year){
        $s = $this->db->where("joined_date", $month . "-" . $year)->where('users.deleted', '0')->select("COUNT(*) as num")->get("users");
        $r = $s->row();
        if (isset($r->num)) return $r->num;
        return 0;
    }

    public function get_oauth_count($provider){
        $s = $this->db->where("oauth_provider", $provider)->select("COUNT(*) as num")->get("users");
        $r = $s->row();
        if (isset($r->num)) return $r->num;
        return 0;
    }

    public function get_total_members_count(){
        $s = $this->db->select("COUNT(*) as num")->where('user_role', 2)->where('deleted', '0')->get("users");
        $r = $s->row();
        if (isset($r->num)) return $r->num;
        return 0;
    }

    public function get_active_today_count(){
        $s = $this->db->where("online_timestamp >", time() - 3600 * 24)->select("COUNT(*) as num")->get("users");
        $r = $s->row();
        if (isset($r->num)) return $r->num;
        return 0;
    }

    public function get_new_today_count(){
        $s = $this->db->where("joined >", time() - 3600 * 24)->select("COUNT(*) as num")->get("users");
        $r = $s->row();
        if (isset($r->num)) return $r->num;
        return 0;
    }

    public function get_online_count(){
        $s = $this->db->where("online_timestamp >", time() - 60 * 15)->select("COUNT(*) as num")->get("users");
        $r = $s->row();
        if (isset($r->num)) return $r->num;
        return 0;
    }

    public function get_members($page, $col, $sort){
        if ($col !== 0) {
            $this->db->order_by($col, $sort);
        } else {
            $this->db->order_by("users.ID", "DESC");
        }

        return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
            ->join("user_roles", "user_roles.ID = users.user_role",
                "left outer")
            ->where('users.deleted', '0')
            ->limit(20, $page)
            ->get("users");
    }

    public function get_members_by_search($search){
        return $this->db->select("users.username, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
            ->join("user_roles", "user_roles.ID = users.user_role",
                "left outer")
            ->where('users.deleted', '0')
            ->limit(20)
            ->like("users.username", $search)
            ->get("users");
    }

    public function search_by_username($search){
        return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
            ->join("user_roles", "user_roles.ID = users.user_role",
                "left outer")
            ->where('users.deleted', '0')
            ->limit(20)
            ->like("users.username", $search)
            ->get("users");
    }

    public function search_by_email($search){
        return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
            ->join("user_roles", "user_roles.ID = users.user_role",
                "left outer")
            ->where('users.deleted', '0')
            ->limit(20)
            ->like("users.email", $search)
            ->get("users");
    }

    public function search_by_first_name($search){
        return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
            ->join("user_roles", "user_roles.ID = users.user_role",
                "left outer")
            ->where('users.deleted', '0')
            ->limit(20)
            ->like("users.first_name", $search)
            ->get("users");
    }

    public function search_by_last_name($search){
        return $this->db->select("users.username, users.email, users.first_name, 
			users.last_name, users.ID, users.joined, users.oauth_provider,
			users.user_role, user_roles.name as user_role_name")
            ->join("user_roles", "user_roles.ID = users.user_role",
                "left outer")
            ->where('users.deleted', '0')
            ->limit(20)
            ->like("users.last_name", $search)
            ->get("users");
    }

    public function update_user($userid, $data){
        $this->db->where("ID", $userid)->update("users", $data);
    }

    public function check_block_ip(){
        $s = $this->db->where("IP", $_SERVER['REMOTE_ADDR'])->get("ip_block");
        if ($s->num_rows() == 0) return false;
        return true;
    }

    public function get_user_groups($userid){
        return $this->db->where("user_group_users.userid", $userid)
            ->select("user_groups.name,user_groups.ID as groupid")
            ->join("user_groups", "user_groups.ID = user_group_users.groupid")
            ->get("user_group_users");
    }

    public function check_user_in_group($userid, $groupid){
        $s = $this->db->where("userid", $userid)->where("groupid", $groupid)
            ->get("user_group_users");
        if ($s->num_rows() == 0) return 0;
        return 1;
    }

    public function get_default_groups(){
        return $this->db->where("default", 1)->get("user_groups");
    }

    public function add_user_to_group($userid, $groupid){
        $this->db->insert("user_group_users", array(
                "userid" => $userid,
                "groupid" => $groupid
            )
        );
    }

    public function add_points($userid, $points){
        $this->db->where("ID", $userid)
            ->set("points", "points+$points", FALSE)->update("users");
    }

    public function get_verify_user($code, $username){
        return $this->db
            ->where("activate_code", $code)
            ->where("username", $username)
            ->get("users");
    }

    public function get_user_event($request){
        return $this->db->where("IP", $_SERVER['REMOTE_ADDR'])
            ->where("event", $request)
            ->order_by("ID", "DESC")
            ->get("user_events");
    }

    public function add_user_event($data){
        $this->db->insert("user_events", $data);
    }

    # Display total reimbursement in order reimbursement and inventory reimbursement
    public function getTotalDashboardReimbursement($accountid = ''){
        // Order reimbursement count
        $this->db->select('sum(reimburse_details.amount_total) as total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id', 'left');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('case_detail.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_detail.ID_ACCOUNT');
        $result = $this->db->get()->row_array();

        // Inventory reimbursement Count
        $this->db->select('sum(reimburse_details.amount_total) as totalinventoryreimburse');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.caseId=reimburse_details.case_id', 'right');
        $this->db->join('accounts', 'accounts.ID_ACCOUNT=reimburse_details.ID_ACCOUNT', 'right');
        $this->db->where('case_details_inventory.status', '2');

        if (!empty($accountid)) {
            $this->db->where('reimburse_details.ID_ACCOUNT', $accountid);
            $this->db->group_by('reimburse_details.ID_ACCOUNT');
        }
        $this->db->where('accounts.deleted', '0');
        $this->db->where('accounts.ID_ACCOUNT = case_details_inventory.accountId');
        $this->db->group_by('case_details_inventory.id');
        $resultinventoryamount = $this->db->get()->row_array();
        return $totalReimburseAmount = $result['total'] + $resultinventoryamount['totalinventoryreimburse'];
    }


    #  This function use to get all total user display in admin dashboard
    public function all_user_total_display(){
        $this->db->select('count(accounts.ID_ACCOUNT) as ID_ACCOUNT');
        $this->db->from('accounts');
        $this->db->join('users', 'users.ID_ACCOUNT=accounts.ID_ACCOUNT', 'left');
        $this->db->join('user_roles', 'user_roles.ID=users.user_role', 'left');
        $this->db->where('accounts.deleted', '0');
        $this->db->where('user_roles.ID', 2);
        $this->db->where('users.active', '1');
        return $this->db->get()->result_array();
    }

    # This function use to get all pending reimbursement in admin dashboard
    public function total_pending_cases_order_reimbursement($accountid = ''){
        $this->db->select('count(case_detail.order_id) as order_id');
        $this->db->from('case_detail');
        $this->db->join('payment_details', 'payment_details.order_id=case_detail.order_id', 'right');
        $this->db->join('reimburse_details', 'reimburse_details.order_id = case_detail.order_id', 'left');

        if (!empty($accountid)) {
            $this->db->where('case_detail.ID_ACCOUNT', $accountid);
        }
        $this->db->where('case_detail.status', '1');
        $this->db->where('case_detail.deleted', '0');
        $this->db->where('payment_details.status', '2');
        return $this->db->get()->result_array();
    }


    public function total_user_order_reimbursement($accountid = ''){
        $this->db->select('count(case_detail.order_id) as order_id');
        $this->db->from('case_detail');
        $this->db->join('payment_details', 'payment_details.order_id=case_detail.order_id', 'right');
        $this->db->join('reimburse_details', 'reimburse_details.order_id = case_detail.order_id', 'left');

        if (!empty($accountid)) {
            $this->db->where('case_detail.ID_ACCOUNT', $accountid);
        }
        $this->db->where('case_detail.status', '2');
        $this->db->where('case_detail.deleted', '0');
        $this->db->where('payment_details.status', '2');
        return $this->db->get()->result_array();
    }

    public function total_user_inventory_pending_reimbursement($accountid = ''){
        $this->db->select('count(case_details_inventory.inventoryItemId) as inventoryItemId');
        $this->db->from('case_details_inventory');
        $this->db->join('inventory_detail', 'inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId', 'right');
        $this->db->join('reimburse_details', 'reimburse_details.order_id = case_details_inventory.inventoryItemId', 'left');

        if (!empty($accountid)) {
            $this->db->where('case_details_inventory.accountId', $accountid);
        }

        $this->db->where('case_details_inventory.status', '1');
        $this->db->where('case_details_inventory.deleted', '0');
        $this->db->where('inventory_detail.status', '1');
        return $this->db->get()->result_array();
    }

    public function total_user_inventory_reimbursement($accountid = ''){
        $this->db->select('count(case_details_inventory.inventoryItemId) as inventoryItemId');
        $this->db->from('case_details_inventory');
        $this->db->join('inventory_detail', 'inventory_detail.transaction_item_id=case_details_inventory.inventoryItemId', 'right');
        $this->db->join('reimburse_details', 'reimburse_details.reimburse_id = case_details_inventory.inventoryItemId', 'left');

        if (!empty($accountid)) {
            $this->db->where('case_details_inventory.accountId', $accountid);
        }
        $this->db->where('case_details_inventory.status', '2');
        $this->db->where('case_details_inventory.deleted', '0');
        $this->db->where('inventory_detail.status', '2');
        return $this->db->get()->result_array();
    }

    # This function use to total user and total reimbursement in user dashboard
    public function UserCaseDetail($account_id){
        $this->db->select('count(case_detail.order_id) as order_id');
        $this->db->from('case_detail');
        $this->db->where('case_detail.ID_ACCOUNT', $account_id);
        $this->db->where('case_detail.status', '1');
        $result = $this->db->get();
        return $result->result_array();
    }

    public function UserCaseDetailAmount($account_id){
        $this->db->select('sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id AND reimburse_details.ID_ACCOUNT=case_detail.ID_ACCOUNT AND reimburse_details.case_id=case_detail.case_id');
        $this->db->where('reimburse_details.ID_ACCOUNT', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    # This function use to last month reimbursement in user in dashboard
    public function UserCaseDetailLastMonthReimbursement($account_id){
        $this->db->select('sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_detail', 'case_detail.order_id=reimburse_details.order_id AND reimburse_details.ID_ACCOUNT=case_detail.ID_ACCOUNT AND reimburse_details.case_id=case_detail.case_id');
        $startDate = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), 1, date("Y", strtotime("-1 month"))));
        $endDate = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), date("t", strtotime("-1 month")), date("Y", strtotime("-1 month"))));
        $this->db->where('case_detail.date >=', $startDate);
        $this->db->where('case_detail.date <=', $endDate);
        $this->db->where('reimburse_details.ID_ACCOUNT', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    # This function use to total user and total reimbursement in user dashboard
    public function UserInventoryCaseDetail($account_id){
        $this->db->select('count(case_details_inventory.inventoryItemId) as inventoryItemId');
        $this->db->where('case_details_inventory.accountId ', $account_id);
        $this->db->where('case_details_inventory.status', '1');
        $result = $this->db->get('case_details_inventory');
        return $result->result_array();
    }

    # This function use to total user and total reimbursement in user dashboard
    public function UserInventoryCaseDetailAmount($account_id){
        $this->db->select('sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.inventoryItemId=reimburse_details.order_id AND case_details_inventory.accountId=reimburse_details.ID_ACCOUNT AND case_details_inventory.caseId=reimburse_details.case_id');
        $this->db->where('reimburse_details.ID_ACCOUNT', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    # This function use to last month reimbursement in user in dashboard
    public function UserCaseDetailInventoryLastMonthReimbursement($account_id){
        $this->db->select('sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('case_details_inventory', 'case_details_inventory.inventoryItemId=reimburse_details.order_id AND case_details_inventory.accountId=reimburse_details.ID_ACCOUNT AND case_details_inventory.caseId=reimburse_details.case_id');
        $startDate = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), 1, date("Y", strtotime("-1 month"))));
        $endDate = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), date("t", strtotime("-1 month")), date("Y", strtotime("-1 month"))));
        $this->db->where('case_details_inventory.date >=', $startDate);
        $this->db->where('case_details_inventory.date <=', $endDate);
        $this->db->where('reimburse_details.ID_ACCOUNT', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    # This function use to total user and total reimbursement in user dashboard
    public function UserCustomCase($account_id){
        $this->db->select('count(custom_case.caseId) as caseId');
        $this->db->from('custom_case');
        $this->db->where('custom_case.accountId', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    # This function use to total user and total reimbursement in user dashboard
    public function UserCustomCaseAmount($account_id){
        $this->db->select('sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('custom_case', 'custom_case.accountId=reimburse_details.ID_ACCOUNT AND custom_case.caseId=reimburse_details.case_id');
        $this->db->where('reimburse_details.ID_ACCOUNT', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    # This function use to last month reimbursement in user in dashboard
    public function UserCustomCaseLastMonthReimbursement($account_id){
        $this->db->select('sum(reimburse_details.amount_total) as amount_total');
        $this->db->from('reimburse_details');
        $this->db->join('custom_case', 'custom_case.accountId=reimburse_details.ID_ACCOUNT AND custom_case.caseId=reimburse_details.case_id');
        $startDate = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), 1, date("Y", strtotime("-1 month"))));
        $endDate = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), date("t", strtotime("-1 month")), date("Y", strtotime("-1 month"))));
        $this->db->where('custom_case.createdAt >=', $startDate);
        $this->db->where('custom_case.createdAt <=', $endDate);
        $this->db->where('reimburse_details.ID_ACCOUNT', $account_id);
        $result = $this->db->get();
        return $result->result_array();
    }

    public function userFeedbackcount($accountId){
        $this->db->select('count(feedback_history.ID_ACCOUNT) as ID_ACCOUNT');
        $this->db->where('feedback_history.ID_ACCOUNT', $accountId);
        $this->db->where('feedback_history.removed', '0');
        $result = $this->db->get('feedback_history');
        return $result->result_array();
    }

    function all($id){
        $this->db->select('*');
        $this->db->where('ID_ACCOUNT', $id);
        $result = $this->db->get('feedback_orders');
        return $result->result_array();
    }


    public function totalThirtyDaySales($account_id){
        $result = $this->db->query("
	    SELECT  FROM_UNIXTIME(feedback_orders.purchasedate,'%Y-%m') AS formatted_date, SUM(feedback_orders.itemprice) AS itemprice
        FROM feedback_orders
        WHERE feedback_orders.ID_ACCOUNT = $account_id 
        GROUP BY FROM_UNIXTIME(feedback_orders.purchasedate,'%Y-%m')
        ");
        return $result->result_array();
    }

    public function totalReimbursement($account_id){
        $this->db->select('DATE_FORMAT(reimburse_details.approval_date, "%Y-%m") as approval_date, sum(reimburse_details.amount_total) as amount_total');
        $this->db->where('ID_ACCOUNT', $account_id);
        $this->db->group_by('DATE_FORMAT(reimburse_details.approval_date, "%Y-%m")');
        $result = $this->db->get('reimburse_details');
        return $result->result_array();
    }

    public function totalamazonfee($account_id){
        $result = $this->db->query("
	    SELECT  FROM_UNIXTIME(feedback_orders.purchasedate,'%Y-%m') AS formatted_date, SUM(feedback_orders.shippingprice) AS shippingprice
        FROM feedback_orders
        WHERE feedback_orders.ID_ACCOUNT = $account_id 
        GROUP BY FROM_UNIXTIME(feedback_orders.purchasedate,'%Y-%m')
        ");
        return $result->result_array();
    }
}
?>