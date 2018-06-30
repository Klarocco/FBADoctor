<?php

class Custom_case_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function Getalluser()
    {
        $this->db->select('users.*,accounts.*');
        $this->db->join('accounts','accounts.ID_ACCOUNT=users.ID_ACCOUNT','left');
        $this->db->where('users.user_role','2');
        $this->db->where('accounts.deleted','0');
        $alluserdisplay = $this->db->get('users');
        return $alluserdisplay->result_array();
    }

    public function allusername()
    {
        $this->db->select('custom_case.*,users.*');
        $this->db->join('users','users.ID_ACCOUNT=custom_case.accountId');
        $this->db->group_by('custom_case.accountId');
        $this->db->where('custom_case.deleted','0');
        $alluser = $this->db->get('custom_case');
        return $alluser->result_array();
    }

    public function add_custom_case($custome_case)
    {
        $this->db->insert('custom_case',$custome_case);
        return $this->db->insert_id();
    }

    public function customcaselist()
    {
        $this->db->select('custom_case.*');
        $this->db->where('custom_case.deleted','0');
        $customcase = $this->db->get('custom_case');
        return $customcase->result_array();
    }

    public function Getallusername()
    {
        $this->db->select('users.*,custom_case.*, custom_case.status as case_status, custom_case.id as custom_id, reimburse_details.*');
        $this->db->join('custom_case','custom_case.accountId =users.ID_ACCOUNT','left');
        $this->db->join('reimburse_details','reimburse_details.ID_ACCOUNT = users.ID_ACCOUNT AND reimburse_details.case_id=custom_case.caseId AND custom_case.accountId=users.ID_ACCOUNT','left');
        $this->db->where('users.user_role','2');
        $this->db->where('custom_case.deleted','0');
        $alluserdisplay = $this->db->get('users');
        return $alluserdisplay->result_array();
    }

    function edit_custome_case($id)
    {
        return $this->db->select('*')->where('id',$id)->get('custom_case')->row_array();
    }

    public function updateCustomcase($id, $data)
    {
        $this->db->where('id',$id);
        $this->db->update('custom_case', $data);
        return $this->db->affected_rows();
    }

    function custom_case_delete($id)
    {
        $array = array('deleted' => '1');
        $this->db->where('id',$id)->update('custom_case', $array);
    }

    public function getallcutomcase_detail($id)
    {
        $this->db->select('custom_case.*,custom_case.id as custom_id, custom_case.status as case_status,reimburse_details.amount_total');
        $this->db->join('reimburse_details','reimburse_details.ID_ACCOUNT=custom_case.accountId AND reimburse_details.case_id=custom_case.caseId','left');
        $this->db->where('custom_case.id',$id);
        return $result = $this->db->get("custom_case")->row_array();
    }

    public function AjaxUserDataFilter($account_id=null,$start_date=null,$end_date=null)
    {

        $this->db->select('custom_case.*,custom_case.id as custom_id, custom_case.status as case_status, reimburse_details.amount_total,users.username');
        $this->db->join('reimburse_details','reimburse_details.ID_ACCOUNT=custom_case.accountId AND reimburse_details.case_id=custom_case.caseId','left');
        $this->db->join('users','users.ID_ACCOUNT=custom_case.accountId');
        $this->db->where('custom_case.deleted','0');
        if ( ! empty( $accountId ) ) {
            $this->db->where( 'custom_case.accountId', $account_id );
        }
        if ( ! empty( $start_date ) ) {
            $this->db->where( 'custom_case.custom_date >=', $start_date );
        }
        if ( ! empty( $end_date ) ) {
            $this->db->where( 'custom_case.custom_date <=', $end_date );
        }
        return $result = $this->db->get("custom_case")->result_array();
    }

    public function Getalluserwise($account_id)
    {
        $this->db->select('users.*,custom_case.*, custom_case.status as case_status, custom_case.id as custom_id, reimburse_details.*');
        $this->db->join('custom_case','custom_case.accountId=users.ID_ACCOUNT','left');
        $this->db->join('reimburse_details','reimburse_details.ID_ACCOUNT = users.ID_ACCOUNT AND reimburse_details.case_id=custom_case.caseId AND custom_case.accountId=users.ID_ACCOUNT','left');
        $this->db->where('users.user_role','2');
        $this->db->where('custom_case.deleted','0');
        $this->db->where('custom_case.accountId',$account_id);
        $alluserdisplay = $this->db->get('users');
        return $alluserdisplay->result_array();
    }

    public function Customcasecharges($accountid)
    {
        $this->db->select('custom_case.id,custom_case.accountId,custom_case.caseId,reimburse_details.ID_ACCOUNT,reimburse_details.case_id,reimburse_details.reimburse_id,reimburse_details.currency_unit,reimburse_details.amount_total');
        $this->db->join('reimburse_details','reimburse_details.ID_ACCOUNT=custom_case.accountId AND reimburse_details.case_id=custom_case.caseId');
        $this->db->where('custom_case.accountId',$accountid);
        $this->db->where('custom_case.status','1');
        $customcasecharge = $this->db->get('custom_case');
        return $customcasecharge->result_array();
    }

    public function updatecustomcasedetail($status, $id)
    {
        $this->db->where('id',$id)->update("custom_case", $status);
    }

    public function allRecordDisplay($id)
    {
        $this->db->select('*');
        $this->db->where_in('id',$id);
        $caseRecord= $this->db->get('custom_case');
        $case_data = $caseRecord->result();
        return $case_data;
    }

    function add_case_data($insert_data)
    {
        $this->db->insert('custom_case_log', $insert_data);
        return $this->db->insert_id();
    }

    public function updateCaseStatus($id,$CaseStatus)
    {
        $this->db->where_in('id',$id);
        $this->db->update('custom_case',$CaseStatus);
        return $this->db->affected_rows();
    }

    public function allupdatestatus()
    {
        $this->db->select('*');
        $statusupdate = $this->db->get('case_change_status');
        return $statusupdate->result_array();
    }

    public function checkcaseid($caseid)
    {
        $s = $this->db->where("caseId", $caseid)->where("deleted",'0')->get("custom_case");
        if ($s->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /* Checking in Custom Case Details by Case CaseId*/
    public function checkCustomCaseIdExist($caseId){
        return $this->db->select('*')->where('caseId',$caseId)->get("custom_case")->row_array();
    }

    /*Updating Custom Case Detials By CaseId*/
    public function updateCaseByCaseId($caseId,$data){
        $this->db->where('id', $caseId);
        $this->db->update('custom_case', $data);
        return $this->db->affected_rows();
    }

    public function getCustomCaseGenerated($userAccountId = ''){
        $this->db->select( 'custom_case.id, custom_case.reimbursedId, custom_case.caseId' );
        $this->db->from( 'custom_case' );
        $this->db->where( 'custom_case.accountId', $userAccountId );
        $this->db->where( 'custom_case.status <>', '0' );
        $this->db->where( 'custom_case.status <>', '3' );
        $result = $this->db->get()->result_array();
        return $result;
    }
    public function getCustomCaseReimbursementDetail($userAccountId, $caseID){
        $this->db->where('ID_ACCOUNT', $userAccountId);
        $this->db->where('case_id', $caseID);
        $this->db->where('status', '0');
        return $this->db->get('reimburse_details')->result_array();
    }
    public function updateCustomCaseCaseDetail($status, $customCaseID){
        $this->db->where('id', $customCaseID);
        $this->db->update('custom_case', $status);
        return;
    }
}
?>