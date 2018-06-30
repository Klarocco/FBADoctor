<?php

class Feedback_setting_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_order_removal_feedback_settings_historical()
    {
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstreturnorder, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and s.apiactive = 1 and a.deleted='0' AND a.removed = 0 AND a.enabled = 1   ");
        return $result;
    }

    function get_order_removal_feedback_settings()
    {
        $t = time();
        $last4hours = $t - (1 * 4 * 60 * 60);
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstreturnorder, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and s.apiactive = 1 and a.deleted='0' AND a.removed = 0 AND a.enabled = 1 AND s.hourlimit_removalorder < 6 AND (s.api_removalorder  = 0 OR s.api_removalorder < $last4hours)
        ");
        return $result;
    }

    /* Get feedback_setting by ID_ACCOUNT */
    public function get_feedback_setting($ID_ACCOUNT)
    {
            $this->db->select('feedback_settings.*, users.username');
            $this->db->from('feedback_settings');
            $this->db->join('users','users.ID_ACCOUNT=feedback_settings.ID_ACCOUNT');
            $this->db->where('feedback_settings.ID_ACCOUNT',$ID_ACCOUNT);
            return $this->db->get()->row_array();
    }

    /* get all feedback_setting */
    function get_all_feedback_settings()
    {
        return $this->db->where('deleted','0')->get('feedback_settings')->result_array();
    }

    /* function to add new feedback_setting */
    function add_feedback_setting($params)
    {
        $this->db->insert('feedback_settings', $params);
        return $this->db->insert_id();
    }

    /* function to add new feedback_setting */
    function add_historical_cron_settings($params)
    {
        $this->db->insert('history_cron_status', $params);
        return $this->db->insert_id();
    }

    /* function to update feedback_setting */
    function update_feedback_setting($ID_ACCOUNT,$params)
    {
        $this->db->where('ID_ACCOUNT',$ID_ACCOUNT);
        $this->db->update('feedback_settings', $params);
    }


    //get user details for return order cron
    function get_return_order_feedback_setting()
    {
        $t = time();
        $last4hours = $t - (1 * 4 * 60 * 60);
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstreturnorder, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and s.apiactive = 1 and a.deleted='0' AND a.removed = 0 AND a.enabled = 1 AND s.hourlimit_returnorder < 6 AND (s.api_returnorderdate  = 0 OR s.api_returnorderdate < $last4hours)
        ");
        return $result;
    }
    function get_return_order_feedback_setting_historical()
    {
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstreturnorder, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and s.apiactive = 1 and a.deleted='0' AND a.removed = 0 AND a.enabled = 1   ");
        return $result;
    }
    //get user details for adjustment inventory cron
    function get_invetory_feedback_setting()
    {
        $t = time();
        $last4hours = $t - (1 * 4 * 60 * 60);
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstinventory, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and s.apiactive = 1 and a.deleted='0' AND a.removed = 0 AND a.enabled = 1 AND s.hourlimit_inventory < 6 AND (s.api_inventorydate  = 0 OR s.api_inventorydate < $last4hours)
        ");
        return $result;
    }
    //get user details for adjustment inventory cron
    function get_invetory_feedback_setting_historical()
    {
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstinventory, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and s.apiactive = 1 and a.deleted='0' AND a.removed = 0 AND a.enabled = 1 ");
        return $result;
    }

    //get user detail for reimbursement cron
    function get_reimburse_feedback_setting()
    {
        $t = time();
        $last4hours = $t - (1 * 4 * 60 * 60);
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstreimburse, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and a.deleted='0' and s.apiactive = 1 AND a.removed = 0 AND a.enabled = 1 AND s.hourlimit_reimburse < 6 AND (s.api_reimbursedate  = 0 OR s.api_reimbursedate < $last4hours)
        ");
        return $result;
    }
    //get user detail for reimbursement cron
    function get_reimburse_feedback_setting_historical()
    {
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_authtoken, s.loadfirstreimburse, s.amazonstorename,s.importorderdays,
        d.marketplace_id, d.access_key, d.secret_key, m.marketplace_id, m.host, m.id
        FROM accounts AS a, feedback_settings AS s, dev_accounts AS d, marketplaces AS m
	WHERE m.id= d.marketplace_id AND s.mws_marketplaceid = m.id AND s.ID_ACCOUNT = a.ID_ACCOUNT  and a.deleted='0' and s.apiactive = 1 AND a.removed = 0 AND a.enabled = 1 ");
        return $result;
    }
    public function check_linkamazonemail_is_free($newusername)
    {
        $s = $this->db->where("link_amazon_email", $newusername)->get("feedback_settings");
        if ($s->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkmswsellerid($mws_sellerid, $accountID)
    {
        $this->db->select('feedback_settings.mws_sellerid,feedback_settings.ID_ACCOUNT,accounts.ID_ACCOUNT,accounts.deleted');
        $this->db->join('accounts','accounts.ID_ACCOUNT=feedback_settings.ID_ACCOUNT');
        $this->db->where("feedback_settings.mws_sellerid",$mws_sellerid);
        $this->db->where('feedback_settings.ID_ACCOUNT <>', $accountID);
        $this->db->where('accounts.deleted','0');
        $mws = $this->db->get("feedback_settings");
        if ($mws->num_rows() > 0)
        {
            return false;
        } else {
            return true;
        }
    }
    function get_fba_inventory_setting() {
        $t = time();
        $last4hours = $t - (1 * 4 * 60 * 60);
        $result = $this->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, s.mws_marketplaceid, s.mws_authtoken, s.loadfirstfbainventory, s.amazonstorename,
	s.importorderdays, m.host,m.marketplace_id,d.access_key,d.secret_key 
	FROM (accounts as a, feedback_settings as s)
        LEFT JOIN marketplaces as m ON (m.id = s.mws_marketplaceid)
        LEFT JOIN dev_accounts as d ON (d.marketplace_id = m.id)
        WHERE s.ID_ACCOUNT = a.ID_ACCOUNT and s.apiactive = 1 AND a.removed = 0 AND a.enabled = 1  and a.deleted='0' AND(s.api_fbainventorydate=0 OR s.api_fbainventorydate<$last4hours)
        ");
        return $result;
    }
}
