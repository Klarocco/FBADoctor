<?php
error_reporting(0);

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends My_controller {

    public function __construct() {
        parent::__construct();
         $this->template->loadData("activeLink", array("home" => array("general" => 1)));
        $this->load->model("user_model");
        $this->load->model("home_model");
        $this->load->library('pagination');
        $this->load->model('subscription_model');
        $paymentinfo = $this->subscription_model->get_payment_info_by_accountid($this->user->info->ID_ACCOUNT);

        if (($this->user->info->feedbackfromemailaddress=='' || $this->user->info->mws_sellerid=='' ||  $this->user->info->mws_authtoken=='' || empty($paymentinfo['ID_PAYMENT'])) && !$this->user->info->admin){
            redirect(site_url("feedback_setting/setup"));
        }
    }

    public function index() {

        if ($this->user->info->admin) {
            $months = array();
            // Graph Data
            $current_month = date("n");
            $current_year = date("Y");
            // First month
            for ($i = 6; $i >= 0; $i--) {
                // Get month in the past
                $new_month = $current_month - $i;
                // If month less than 1 we need to get last years months
                if ($new_month < 1) {
                    $new_month = 12 + $new_month;
                    $new_year = $current_year - 1;
                } else {
                    $new_year = $current_year;
                }
                // Get month name using mktime
                $timestamp = mktime(0, 0, 0, $new_month, 1, $new_year);
                $count = $this->user_model
                        ->get_registered_users_date($new_month, $new_year);
                $months[] = array(
                    "date" => date("F", $timestamp),
                    "count" => $count
                );
            }
            $javascript = 'var data_graph = {
					    labels: [';
            foreach ($months as $d) {
                $javascript .= '"' . $d['date'] . '",';
            }
            $javascript.='],
		    datasets: [
		        {
		            label: "My First dataset",
		            fillColor: "rgba(220,220,220,0.2)",
		            strokeColor: "rgba(220,220,220,1)",
		            pointColor: "rgba(220,220,220,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(220,220,220,1)",
		            data: [';
            foreach ($months as $d) {
                $javascript .= $d['count'] . ',';
            }
            $javascript.=']
		        }
		    ]
		};';


            $total_reimbussement = $this->user_model->getTotalDashboardReimbursement();
            if(empty($total_reimbussement))
               $total_reimbussement = 0 ;

            $total_user_count = $this->user_model->all_user_total_display();
            if(empty($total_user_count))
                $total_user_count = 0 ;

            $total_pending_cases_oreder_reimbursement = $this->user_model->total_pending_cases_order_reimbursement();
            if(empty($total_pending_cases_oreder_reimbursement))
                $total_pending_cases_oreder_reimbursement = 0 ;

            $total_user_order_reimbursement = $this->user_model->total_user_order_reimbursement();
            if(empty($total_user_order_reimbursement))
                $total_user_order_reimbursement = 0 ;

            $total_user_inventory_pending_reimbursement = $this->user_model->total_user_inventory_pending_reimbursement();
            if(empty($total_user_inventory_pending_reimbursement))
                $total_user_inventory_pending_reimbursement = 0 ;

            $total_user_inventory_reimbursement = $this->user_model->total_user_inventory_reimbursement();
            if(empty($total_user_inventory_reimbursement))
                $total_user_inventory_reimbursement = 0 ;

            $this->template->loadContent("home/index.php",array(
                                          'total_reimbursement' => $total_reimbussement,
                                          'total_user' => $total_user_count,
                                          'total_pending_order_reimbursement' => $total_pending_cases_oreder_reimbursement,
                                          'total_user_order_reimbursement' => $total_user_order_reimbursement,
                                          'total_user_inventory_pending_reimbursement' => $total_user_inventory_pending_reimbursement,
                                          'total_user_inventory_reimbursement' => $total_user_inventory_reimbursement
                                         ));
        }
        else
        {
            $case_detail = $this->user_model->UserCaseDetail($this->user->info->ID_ACCOUNT);
            foreach($case_detail as $value)
                $case_detail_id = $value['order_id'];

            $case_detail_amount = $this->user_model->UserCaseDetailAmount($this->user->info->ID_ACCOUNT);
            foreach($case_detail_amount as $value)
                $case_detail_amount = $value['amount_total'];

            $aftermonthcase = $this->user_model->UserCaseDetailLastMonthReimbursement($this->user->info->ID_ACCOUNT);
            foreach($aftermonthcase as $value)
                    $casedetaillastmonthamount = $value['amount_total'];

            $inventory_case_detail = $this->user_model->UserInventoryCaseDetail($this->user->info->ID_ACCOUNT);
            foreach($inventory_case_detail as $value)
                $inventory_case_id = $value['inventoryItemId'];

            $inventory_case_detail_amount = $this->user_model->UserInventoryCaseDetailAmount($this->user->info->ID_ACCOUNT);
            foreach($inventory_case_detail_amount as $value)
                $inventory_case_amount = $value['amount_total'];

            $aftermonthcaseInventory = $this->user_model->UserCaseDetailInventoryLastMonthReimbursement($this->user->info->ID_ACCOUNT);
            foreach($aftermonthcaseInventory as $value)
                $casedetailinventorylastmonthamount = $value['amount_total'];

            $custom_case = $this->user_model->UserCustomCase($this->user->info->ID_ACCOUNT);
            foreach($custom_case as $value)
                $custom_case_id = $value['custom_case_id'];

            $custom_case_amount = $this->user_model->UserCustomCaseAmount($this->user->info->ID_ACCOUNT);
            foreach($custom_case_amount as $value)
                $custom_case_amount = $value['amount_total'];

            $aftermonthcaseInventory = $this->user_model->UserCustomCaseLastMonthReimbursement($this->user->info->ID_ACCOUNT);
            foreach($aftermonthcaseInventory as $value)
                $customcaselastmonthamount = $value['amount_total'];

            $data['totalUserCase'] = $case_detail_id + $inventory_case_id + $custom_case_id;
            $data['totalAmount'] = $case_detail_amount + $inventory_case_amount + $custom_case_amount;
            $data['totallastmonthamount'] = $casedetaillastmonthamount + $casedetailinventorylastmonthamount + $customcaselastmonthamount;

            $feedbacktotal = $this->user_model->userFeedbackcount($this->user->info->ID_ACCOUNT);
            foreach($feedbacktotal as $value)
                $data['totalUserFeedback'] = $value['ID_ACCOUNT'];

            $data['reimbursement'] = $this->user_model->totalReimbursement($this->user->info->ID_ACCOUNT);
            $data['thirtyDaYTotal'] = $this->user_model->totalThirtyDaySales($this->user->info->ID_ACCOUNT);
            $data['amazon_fee'] = $this->user_model->totalamazonfee($this->user->info->ID_ACCOUNT);
            $this->template->loadContent("home/user_dashboard.php",$data);
        }
    }

    public function change_language() {
        $languages = $this->config->item("available_languages");
        if (!isset($_COOKIE['language'])) {
            $lang = "";
        } else {
            $lang = $_COOKIE["language"];
        }
        $this->template->loadContent("home/change_language.php", array(
            "languages" => $languages,
            "user_lang" => $lang
                )
        );
    }

    public function change_language_pro() {
        $lang = $this->common->nohtml($this->input->post("language"));
        $languages = $this->config->item("available_languages");
        if (!in_array($lang, $languages, TRUE)) {
            $this->template->error(lang("error_25"));
        }

        setcookie("language", $lang, time() + 3600 * 7, "/");
        $this->session->set_flashdata("globalmsg", lang("success_14"));
        redirect(site_url());
    }
}
?>