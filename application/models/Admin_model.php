<?php

class Admin_Model extends CI_Model {

    public function updateSettings($data) {
        $this->db->where("ID", 1)->update("site_settings", $data);
    }

    public function add_ipblock($ip, $reason) {
        $this->db->insert("ip_block", array(
            "IP" => $ip,
            "reason" => $reason,
            "timestamp" => time()
                )
        );
    }

    public function get_ip_blocks() {
        return $this->db->get("ip_block");
    }

    public function get_ip_block($id) {
        return $this->db->where("ID", $id)->get("ip_block");
    }

    public function delete_ipblock($id) {
        $this->db->where("ID", $id)->delete("ip_block");
    }

    public function get_email_templates() {
        return $this->db->get("email_templates");
    }

    public function get_email_template($id) {
        return $this->db->where("ID", $id)->get("email_templates");
    }

    public function update_email_template($id, $title, $message) {
        $this->db->where("ID", $id)->update("email_templates", array(
            "title" => $title,
            "message" => $message
                )
        );
    }

    public function get_user_groups() {
        return $this->db->get("user_groups");
    }

    public function add_group($data) {
        $this->db->insert("user_groups", $data);
    }

    public function get_user_group($id) {
        return $this->db->where("ID", $id)->get("user_groups");
    }

    public function delete_group($id) {
        $this->db->where("ID", $id)->delete("user_groups");
    }

    public function delete_users_from_group($id) {
        $this->db->where("groupid", $id)->delete("user_group_users");
    }

    public function update_group($id, $data) {
        $this->db->where("ID", $id)->update("user_groups", $data);
    }

    public function get_users_from_groups($id, $page) {
        return $this->db->where("user_group_users.groupid", $id)
                        ->select("users.ID as userid, users.username, user_groups.name, 
				user_groups.ID as groupid, user_groups.default")
                        ->join("users", "users.ID = user_group_users.userid")
                        ->join("user_groups", "user_groups.ID = user_group_users.groupid")
                        ->limit(20, $page)
                        ->get("user_group_users");
    }

    public function get_all_group_users($id) {
        return $this->db->where("user_group_users.groupid", $id)
                        ->select("users.ID as userid, users.email, users.username, 
				user_groups.name, user_groups.ID as groupid, 
				user_groups.default")
                        ->join("users", "users.ID = user_group_users.userid")
                        ->join("user_groups", "user_groups.ID = user_group_users.groupid")
                        ->get("user_group_users");
    }

    public function get_total_user_group_members_count($groupid) {
        $s = $this->db->where("groupid", $groupid)
                        ->select("COUNT(*) as num")->get("user_group_users");
        $r = $s->row();
        if (isset($r->num))
            return $r->num;
        return 0;
    }

    public function get_user_from_group($userid, $id) {
        return $this->db->where("userid", $userid)
                        ->where("groupid", $id)->get("user_group_users");
    }

    public function delete_user_from_group($userid, $id) {
        $this->db->where("userid", $userid)
                ->where("groupid", $id)->delete("user_group_users");
    }

    public function add_user_to_group($userid, $id) {
        $this->db->insert("user_group_users", array(
            "userid" => $userid,
            "groupid" => $id
                )
        );
    }

    public function get_all_users() {
        return $this->db->select("users.email, users.ID as userid")
                        ->get("users");
    }



    public function get_payment_logs($page) {
        return $this->db->select("users.ID as userid, users.username, users.email,
			payment_logs.email, payment_logs.amount, payment_logs.timestamp, 
			payment_logs.ID")
                        ->join("users", "users.ID = payment_logs.userid")
                        ->limit(20, $page)
                        ->order_by("payment_logs.ID", "DESC")
                        ->get("payment_logs");
    }

    public function get_total_payment_logs_count() {
        $s = $this->db
                        ->select("COUNT(*) as num")->get("payment_logs");
        $r = $s->row();
        if (isset($r->num))
            return $r->num;
        return 0;
    }

    public function get_user_roles() {
        return $this->db->get("user_roles");
    }

    public function add_user_role($data) {
        $this->db->insert("user_roles", $data);
    }

    public function get_user_role($id) {
        return $this->db->where("ID", $id)->get("user_roles");
    }

    public function update_user_role($id, $data) {
        $this->db->where("ID", $id)->update("user_roles", $data);
    }

    public function delete_user_role($id) {
        $this->db->where("ID", $id)->delete("user_roles");
    }

    public function get_all_marketplace_id()
    {
        return $this->db->get('marketplaces')->result_array();
    }

    /*
     * get all marketplace account
     */

    public function get_all_marketplace_account($page, $col, $sort) {
        if ($col !== 0) {
            $this->db->order_by($col, $sort);
        } else {
            $this->db->order_by("marketplaces.id", "DESC");
        }

        $this->db->limit(20, $page);
        return $this->db->get("marketplaces")->result_array();
        ;
    }

    /*
     * get marketplace account by account id
     */

    public function get_marketplace_account_by_id($id) {
        return $this->db->get_where('marketplaces', array('id' => $id))->row_array();
    }

    /*
     * add marketplace account
     */

    public function add_marketplace_account($params) {
        $this->db->insert("marketplaces", $params);
    }

    /*
     * update marketplace account
     */

    function update_marketplace_account($id, $params) {
        $this->db->where('id', $id);
        $this->db->update('marketplaces', $params);
    }

    /*
     * count total marketplace account
     */

    public function get_total_maketplaces_count() {
        $s = $this->db->select("COUNT(*) as num")->get("marketplaces");
        $r = $s->row();
        if (isset($r->num))
            return $r->num;
        return 0;
    }

    /*
     * add developer account 
     */

    public function add_dev_account($params) {
        $this->db->insert("dev_accounts", $params);
    }

    /*
     * get all developer account 
     */

    public function get_all_developer_account($page, $col, $sort) {
        if ($col !== 0) {
            $this->db->order_by($col, $sort);
        } else {
            $this->db->order_by("id", "DESC");
        }

        $this->db->limit(20, $page);
        return $this->db->get("dev_accounts")->result_array();
        ;
    }

    /*
     * get developer account by account_id
     */

    public function get_developer_account_by_id($id) {
        return $this->db->get_where('dev_accounts', array('id' => $id))->row_array();
    }

    /*
     * update developer account 
     */

    function update_dev_account($id, $params) {
        $this->db->where('id', $id);
        $this->db->update('dev_accounts', $params);
    }

    /*
     * get total developer account count
     */

    public function get_total_devaccount_count() {

        $s = $this->db->select("COUNT(*) as num")->get("dev_accounts");
        $r = $s->row();
        if (isset($r->num))
            return $r->num;
        return 0;
    }
}

?>