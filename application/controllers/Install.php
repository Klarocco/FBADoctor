<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller 
{

	public function __construct() 
	{
		 parent::__construct();
		 $this->load->model("install_model");
         $this->load->model('Account_model');
         $this->load->model("feedback_setting_model");
	}

	public function index()
	{
		$this->template->set_error_view("error/login_error.php");
		$this->template->set_layout("layout/login_layout.php");
		$this->template->loadContent("install/index.php", array());
	}

	public function install_pro() 
	{
        $datecreated = time();
		$this->template->set_error_view("error/login_error.php");
		$this->template->set_layout("layout/login_layout.php");
		$email = $this->common->nohtml($this->input->post("email"));
		$username = $this->common->nohtml($this->input->post("username"));
		if (strlen($username) < 3) {
			$this->template->error("Username must be 3 characters at least!");
		}

		if (!preg_match("/^[a-z0-9_]+$/i", $username)) {
			$this->template->error("Username must only contain numbers, letters and underscores");
		}

		$password = $this->common->nohtml(
			$this->input->post("password"));
		$password2 = $this->common->nohtml(
			$this->input->post("password2"));
		$site_name = $this->common->nohtml(
			$this->input->post("site_name"));
		$site_desc = $this->common->nohtml(
			$this->input->post("site_desc"));

		if (empty($email)) {
			$this->template->error("You cannot leave your email empty!");
		}
		if (empty($password)) {
			$this->template->error("You cannot leave your password empty!");
		}

		if(empty($site_name)) $this->template->error("Site name cannot be empty!");

		if ($password != $password2) {
			$this->template->error("Passwords do not match.");
		}

		if ($this->install_model->checkAdmin()) {
			$this->template->error(
				"The install file cannot be used as an admin account 
				has already been created."
			);
		}
		$params = array(
            'company' => $this->settings->info->site_name,
            'address' => '',
            'city' => '',
            'region' => '',
            'zip' => '',
            'country' => '',
            'phone' => '',
            'loginsent' => 0,
            'paybytype' => '',
            'perm_feedback' => 0,
            'perm_support' => 0,
            'allowoverage' => 1,
            'nocreditcardallowed' => 0,
            "datecreated" => $datecreated
        );
        $account_id = $this->Account_model->add_account($params);
        if($account_id){
            $this->install_model->createAdmin($username, $email,
                $this->common->encrypt($password));
            $this->feedback_setting_model->add_feedback_setting(array(
                    "ID_ACCOUNT" => 1,
                    "amazonstorename" => $this->settings->info->site_name,
                    "set_secondfollowupemail" => 1
                )
            );
            $dir = dirname(__FILE__);
            $dir = substr($dir, 0, strlen($dir) - 23);
            $this->install_model->updateSite($site_name, $site_desc, $dir);
            $msg = "You have successfully created your Admin account. ";
            $msg.= "You can now login to the system. ";
            $msg.= "Please delete the application/controllers/install.php file.";
            $this->session->set_flashdata("globalmsg", $msg);
            redirect(site_url("login"));
        }
	}

}

?>