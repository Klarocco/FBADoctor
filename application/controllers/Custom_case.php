<?php


class Custom_case extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('custom_case_model');
        $this->load->model('Reimbursement_model');
    }

    public function index()
    {
        $this->template->loadData("activeLink", array("custome_case" => array("custom_case" => 1)));
        $data['alluser'] = $this->custom_case_model->Getalluser();
        $this->template->loadContent("custom_case/index.php", $data);
    }

    public function Customcasegeneration()
    {
        if (isset($_POST['addCaseId']))
        {
            $case_id = $this->input->post('case_Id');
            $case_date = $this->input->post('caseDate');
            $user = $this->input->post('select_user');
            $customcase = $this->input->post('custom_case');
            $subject = $this->input->post('subject');
            $amount = $this->input->post('amount');

            if (!$this->custom_case_model->checkcaseid($case_id))
            {
                $this->session->set_flashdata("danger", "Custom case id already exits.");
                redirect('custom_case/index');
            }
            else
            {
                $custome_case = array(
                    "caseId" => $case_id,
                    "custom_date" => date('Y-m-d',strtotime($case_date)),
                    "accountId" => $user,
                    "message" => $customcase,
                    "subject"   => $subject,
                    "amount"    => $amount,
                    "status" => "1",
                    "deleted" => "0",
                    "createdAt" => date('Y-m-d')
                );
                $insert_custom_case = $this->custom_case_model->add_custom_case($custome_case);
                if ($insert_custom_case > 0)
                {
                    $this->session->set_flashdata("success", "Custom case successfully insert.");
                    redirect('custom_case/Customcaselist');
                }
            }
        }
    }

    public function Customcaselist()
    {
        $this->template->loadData("activeLink", array("custome_case" => array("generate_custom_case" => 1)));
        if (isset($this->user->info->admin) && !empty($this->user->info->admin)) {
            $all_user = $this->custom_case_model->customcaselist();
            foreach ($all_user as $key => $value)
            {
                $data['customcaselist'] = $this->custom_case_model->Getallusername($value['accountId']);
            }
            $data['username'] = $this->custom_case_model->allusername();
            }
            else
            {
                $data['customcaselist'] = $this->custom_case_model->Getalluserwise($this->user->info->ID_ACCOUNT);
            }
        $this->template->loadContent('custom_case/customcasegenerate.php', $data);
    }

    public function editCustomCaseDetail($id)
    {
        $result = $this->custom_case_model->edit_custome_case($id);
        echo json_encode($result);
        exit;
    }

    public function updateCustomCase()
    {
        $detail = $_POST['case_status_detail'];

        if($detail == 3)
        {
            $id = $_POST['id'];

            $case_id = $this->custom_case_model->allRecordDisplay($id);
            foreach ($case_id as $key => $value)
            {
                $insert_data = array(
                    'accountId'=>$value->accountId,
                    'caseId'=>$value->caseId,
                    'subject' =>$value->subject,
                    'message'=>$value->message,
                    'amount'=>$value->amount,
                    'custom_date'=>$value->custom_date,
                    'status'=>$value->status,
                    'deleted'=>$value->deleted,
                    'createdAt'=>date('Y-m-d')
                );
                $this->custom_case_model->add_case_data($insert_data);
            }

            $data = array('caseId' => $_POST['case_Id'], 'custom_date' => $_POST['caseDate'],'status' => $_POST['case_status_detail'],'updatedAt'=>date('Y-m-d'));
            $affected_row = $this->custom_case_model->updateCustomcase($_POST['id'], $data);
            if ($affected_row > 0) {
                $this->session->set_flashdata("success", "Custom case detail succsssfully update.");
                redirect('custom_case/customcaselist');
            } else {
                redirect('custom_case/customcaselist');
            }
        }
        else
        {
            $id = $_POST['id'];

            $case_id = $this->custom_case_model->allRecordDisplay($id);
            foreach ($case_id as $key => $value)
            {
                $insert_data = array(
                    'accounId'=>$value->accountId,
                    'caseId'=>$value->caseId,
                    'amount'=>$value->amount,
                    'message'=>$value->message,
                    'subject'=>$value->subject,
                    'custom_date'=>$value->custom_date,
                    'status'=>$value->status,
                    'deleted'=>$value->deleted,
                    'createdAt'=>date('Y-m-d')
                );
                $this->custom_case_model->add_case_data($insert_data);
            }

            $data = array('caseId' => $_POST['case_Id'], 'custom_date' => $_POST['caseDate'],'status' => $_POST['case_status_detail'],'updatedAt' => date('Y-m-d'));
            $affected_row = $this->custom_case_model->updateCustomcase($_POST['id'], $data);
            if ($affected_row > 0) {
                $this->session->set_flashdata("success", "Custom case detail succsssfully update.");
                redirect('custom_case/customcaselist');
            } else {
                redirect('custom_case/customcaselist');
            }
        }
    }

    public function remove_custom_case($id)
    {
        $this->custom_case_model->custom_case_delete($id);
        $this->session->set_flashdata("danger", "Custom case detail succsssfully deleted.");
        redirect('custom_case/customcaselist');
    }

    public function customecasedetail($id)
    {
        $result = $this->custom_case_model->getallcutomcase_detail($id);
        echo json_encode($result);
        exit;
    }

    public function AjaxUserData()
    {
        error_reporting(0);
        if (isset($this->user->info->admin) && !empty($this->user->info->admin))
        {
            $start_date = date('Y-m-d 00:00:01', strtotime($_POST['start_date']));
            $end_date = date('Y-m-d h:i:s', strtotime($_POST['end_date']));
            $account_id = $_POST['account_id'];
            $data['customcaselist'] = $this->custom_case_model->AjaxUserDataFilter($account_id, $start_date, $end_date);
        }
        else
        {
            $start_date = date('Y-m-d h:i:s', strtotime($_POST['start_date']));
            $end_date = date('Y-m-d h:i:s', strtotime($_POST['end_date']));
            $data['customcase'] = $this->custom_case_model->AjaxUserDataFilter($this->user->info->ID_ACCOUNT,$start_date,$end_date);
        }
        $this->load->view("custom_case/AjaxUserData.php", $data);
    }

    public function CustomCaseStatusUpdate()
    {
        $casestatus = $_POST['txtbox'];

        if($casestatus == 3)
        {
            $caseDetailId = $_POST['selected'];
            $id = explode(',', $caseDetailId);

            $case_id = $this->custom_case_model->allRecordDisplay($id);

            foreach($case_id as $key=>$value)
            {
                $insert_data = array(
                    'accountId'=>$value->accountId,
                    'caseId'=>$value->caseId,
                    'message'=>$value->message,
                    'subject'=>$value->subject,
                    'amount'=>$value->amount,
                    'custom_date'=>$value->custom_date,
                    'status'=>$value->status,
                    'deleted'=>$value->deleted,
                    'createdAt'=>date('Y-m-d')
                );

                $this->custom_case_model->add_case_data($insert_data);
            }
            $CaseStatus = array('status' => $_POST['txtbox'],'updatedAt'=>date('Y-m-d'));
            $this->custom_case_model->updateCaseStatus($id,$CaseStatus);
        }
        else
        {
            $caseDetailId = $_POST['selected'];
            $id = explode(',', $caseDetailId);

            $case_id = $this->custom_case_model->allRecordDisplay($id);

            foreach($case_id as $key=>$value)
            {
                $insert_data = array(
                    'accountId'=>$value->accountId,
                    'caseId'=>$value->caseId,
                    'message'=>$value->message,
                    'subject'=>$value->subject,
                    'amount'=>$value->amount,
                    'custom_date'=>$value->custom_date,
                    'status'=>$value->status,
                    'deleted'=>$value->deleted,
                    'createdAt'=>date('Y-m-d')
                );

                $this->custom_case_model->add_case_data($insert_data);
            }
            $CaseStatus = array('status' => $_POST['txtbox'],'updatedAt'=>date('Y-m-d'));
            $this->custom_case_model->updateCaseStatus($id,$CaseStatus);
        }

        return true;
    }
}
?>
