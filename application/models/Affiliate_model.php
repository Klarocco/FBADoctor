<?php

class Affiliate_model extends CI_Model
{

    public function getAffiliateUserscommission(){

        $this->db->select('accounts.*,users.*,users.ID_ACCOUNT as accountId, affliate_commission.*');
        $this->db->from('accounts');
        $this->db->join('users','users.ID_ACCOUNT=accounts.ID_ACCOUNT','left');
        $this->db->join('affliate_commission','affliate_commission.ID_ACCOUNT=accounts.ID_ACCOUNT');
        $this->db->where("users.deleted",'0');
        $this->db->where("users.active",1);
        $this->db->where("affliate_commission.status",'0');
        return $this->db->get()->result_array();
    }

    public function fetchaffiliatecommissionbyaccountid($accountID)
    {
        $this->db->where('ID_ACCOUNT', $accountID);
        $this->db->where('status', '0');
        return $this->db->get('affliate_commission')->row_array();
    }

    public function updateaffliateusercurrentrecord($affcommid, $updatedata)
    {
        $this->db->where('id', $affcommid);
        return $this->db->update('affliate_commission', $updatedata);
    }

    public function insertnewrecordofaffuser($newrecord)
    {
        return $this->db->insert('affliate_commission', $newrecord);
    }

    public function insertinvoice($data)
    {
        $this->db->insert('stripe_invoice', $data);
        return $this->db->insert_id();
    }

    public function getaffiliateusercommissions($accountID)
    {
        echo $accountID;

        $this->db->where('ID_ACCOUNT', $accountID);
        return $this->db->get('accounts')->row_array();
    }
}
