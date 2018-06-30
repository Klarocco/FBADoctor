<?php

/**
 * Created by PhpStorm.
 * User: Webdimensions 2
 * Date: 7/17/2017
 * Time: 4:09 PM
 */
class Order_removal_model extends CI_Model{

	public function custom_count_order_removal($params) {
		$countTotal = $this->db->get_where('order_removal_shipment', $params);
		return $countTotal->num_rows();
	}

	public function add_order_removal($data){
		$this->db->insert('order_removal_shipment', $data);
		return $this->db->insert_id();
	}

	public function get_removal_order_by_accountID($accoundID){
		$this->db->where('ID_ACCOUNT',$accoundID);
		$this->db->where('status','0');
		return $this->db->get('order_removal_shipment')->result_array();
	}

	public function update_removal_order_by_id($id, $status){
		$this->db->where('id',$id);
		$this->db->update('order_removal_shipment', $status);
		return;
	}

	public function generate_order_removal_case($data){
		$this->db->insert('case_detail', $data);
		return $this->db->insert_id();
	}

	public function getTotalOrderRemovalCaseCount($accountId){
		$this->db->select('count(*) AS TotalOrderRemovalCount');
		$this->db->from('order_removal_shipment');
		$this->db->join('case_detail', 'case_detail.order_id = order_removal_shipment.id' );
		$this->db->where('case_detail.ID_ACCOUNT', $accountId );
		$this->db->where('case_detail.status', '0' );
		$this->db->where('case_detail.deleted','0');
		$this->db->where( 'case_detail.case_type', 'AOR' );
		$result = $this->db->get()->row_array();
		return $result['TotalOrderRemovalCount'];
	}

	public function getReimbursementAORCase( $accountID, $orderID, $fnsku ) {
		$this->db->where('ID_ACCOUNT',$accountID);
		$this->db->where('order_id',$orderID);
		$this->db->where('fnsku',$fnsku);
		return $this->db->get('reimburse_details')->row_array();
	}

}