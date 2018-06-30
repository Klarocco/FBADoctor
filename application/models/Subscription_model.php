<?php

class Subscription_Model extends CI_Model
{
    /*
     * Get pyament information by account id
     */
    public function get_payment_info_by_accountid($accountid)
    {
          $this->db->SELECT(" ID_PAYMENT,ID_ACCOUNT,datecreated, bill_firstname,bill_lastname,bill_address,bill_city,bill_region,bill_zip,
		              bill_country,bill_email,bill_phone,paymethod,cardtype,cardnumber,cardexpiremonth,cardexpireyear,cardsecuritycode,
                              signature, customerid, payment_token");
          $this->db->WHERE("removed = 0 AND ID_ACCOUNT = $accountid");
          return $this->db->get("payment_method")->row_array();
    }
    /*
     * insert payment method information
     */

    public function insert_payment_info($params)
    {
        $this->db->insert('payment_method',$params);
        return $this->db->insert_id();
    }

    /*
     * update payment method info
     */

    public function update_payment_method_info($id_accoutnt,$params)
    {
         $this->db->where("ID_ACCOUNT", $id_accoutnt)->update("payment_method", $params);
    } 

    /*
     * get all accout payment information
     */

     public function get_all_account_payment_information()
    {
          $this->db->SELECT(" ID_PAYMENT,ID_ACCOUNT,datecreated, bill_firstname,bill_lastname,bill_address,bill_city,bill_region,bill_zip,
		              bill_country,bill_email,bill_phone,paymethod,cardtype,cardnumber,cardexpiremonth,cardexpireyear,cardsecuritycode,
                              signature, braintree_customerid, braintree_token");
          $this->db->WHERE(" removed = 0 ");
         return $this->db->get("payment_method")->result_array();
				
    }

    //get subscription charge by userid

    function get_charge_by_userid($userId)
    {
        return $this->db->get_where('payment_logs',array('userid' => $userId ))->row_array();
    }
}