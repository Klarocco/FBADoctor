<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        if (!$this->user->loggedin) {
            redirect(site_url("login"));
        }
        $this->load->model('subscription_model');
        $paymentinfo = $this->subscription_model->get_payment_info_by_accountid($this->info->ID_ACCOUNT);
        if (($this->user->info->feedbackfromemailaddress=='' || $this->user->info->mws_sellerid=='' ||  $this->user->info->mws_authtoken=='' || empty($paymentinfo['ID_PAYMENT'])) && !$this->user->info->admin)
            redirect(site_url("feedback_setting/setup"));
    }

    public function index($username = "") {

        if (empty($username))
            $this->template->error(lang("error_51"));

        $user = $this->user_model->get_user_by_username($username);
        if ($user->num_rows() == 0)
            $this->template->error(lang("error_52"));
        $user = $user->row();

        if ($user->user_role == -1)
            $this->template->error(lang("error_53"));

        $groups = $this->user_model->get_user_groups($user->ID);

        $this->template->loadContent("profile/index.php", array(
            "user" => $user,
            "groups" => $groups
                )
        );
    }

}

?>