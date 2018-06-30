<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("register_model");
        $this->load->model("account_model");
        $this->load->model("feedback_setting_model");
        $this->load->model("user_model");
        $this->load->model("subscription_model");
        $this->load->library('encrypt');
    }

    public function index($affiliateId = '')
    {

        if ($this->user_model->check_block_ip()) {
            $this->template->error(lang("error_26"));
        }
        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        if ($this->settings->info->register) {
            $this->template->error(lang("error_54"));
        }
        $this->template->loadExternal(
            '<script type="text/javascript" src="'
            . base_url() . 'scripts/custom/check_username.js" /></script>'
        );
        if ($this->user->loggedin) {
            $this->template->error(
                lang("error_27")
            );
        }
        $this->load->helper('email');

        $email = "";
        $name = "";
        $username = "";
        $fail = "";
        $first_name = "";
        $last_name = "";
        if (isset($_POST['s'])) {
            $storename = $this->common->nohtml(
                $this->input->post("storename", true));
            $email = $this->input->post("email", true);
            $first_name = $this->common->nohtml(
                $this->input->post("first_name", true));
            $last_name = $this->common->nohtml(
                $this->input->post("last_name", true));
            $pass = $this->common->nohtml(
                $this->input->post("password", true));
            $pass2 = $this->common->nohtml(
                $this->input->post("password2", true));
            $captcha = $this->input->post("captcha", true);
            $username = $this->common->nohtml(
                $this->input->post("username", true));
            if (strlen($username) < 3)
                $fail = "error_31";
            if (!preg_match("/^[a-z0-9_]+$/i", $username)) {
               $fail = lang("error_15");
            }
            if (!$this->register_model->check_username_is_free($username)) {
                $fail = lang("error_16");
            }
            if (!$this->settings->info->disable_captcha) {
                if ($captcha != $_SESSION['sc']) {
                    $fail = lang("error_55");
                }
            }
            if ($pass != $pass2)
                $fail = lang("error_22");
            if (strlen($pass) <= 5) {
                $fail = lang("error_17");
            }
            if (strlen($first_name) > 25) {
                $fail = lang("error_56");
            }
            if (strlen($last_name) > 30) {
                $fail = lang("error_57");
            }
            if (empty($first_name) || empty($last_name)) {
                $fail = lang("error_58");
            }
            if (empty($email)) {
                $fail = lang("error_18");
            }
            if (!valid_email($email)) {
                $fail = lang("error_19");
            }

            if (!$this->register_model->checkEmailIsFree($email)) 
            {
                $fail = lang("error_20");
            }
            if (empty($fail)) {
                $password = $pass;
                $pass = $this->common->encrypt($pass);
                $active = 1;
                $activate_code = "";
                $success = lang("success_20");
                if ($this->settings->info->activate_account) {
                    $active = 0;
                    $activate_code = md5(rand(1, 10000000000) . "fhsf" . rand(1, 100000));
                    // Send email
                    $this->load->model("home_model");

                    $subject = "Activation Email";

                    $message = '<!DOCTYPE HTML>
                        <html>
                            <head> 
                                <style>
                                     .btn-primary
                                     {
                                            background-color:  #3498db ;
                                            border: none;
                                            color: white;
                                            padding: 15px 32px;
                                            text-align: center;
                                            text-decoration: none;
                                            display: inline-block;
                                            font-size: 20px;
                                            margin: 4px 2px;
                                            cursor: pointer;
                                            border-radius: 5px;
                                     }                               
                                </style>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
                               <!-- <link href="' .base_url().'images/favicon.png" rel="icon" type="image/x-icon"/> -->
                                <title>FBADoctor</title>
                            </head>
                            <body bgcolor=" #d5d8dc">
                                <table width="600" border="0" bgcolor="white" cellspacing="0" cellpadding="0" align="center" style="font-family:Arial, Helvetica, sans-serif;">
                                    <tr>
                                        <td align="center"><br><br>
                                            <h3>FBADoctor</h3><br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <p style="color:#000000; padding-left: 25px; margin-top:70px;">Hello <strong>'.$first_name .' '.$last_name.'</strong>, Your almost finished!</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <p style="color:#000000; padding-left: 25px; margin-top:20px;">We just need to verfiy your email address to complete your FBADoctor Signup.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <a href="'.site_url("register/activate_account/" . $activate_code ."/" . $username).'" class="btn btn-primary" style="margin-top:50px;">Verify Your Email</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <p style="color:#000000; padding-left: 25px;padding-top: 20px; margin-top:70px;">Please note that link will expire in 5 days.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <p style="color:#000000; padding-left: 25px; margin-top:10px;">If you have not signed up for FBADoctor, Please ignore this email.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff">
                                            <p style="color:#000000; padding-left: 25px; margin-top:25px;">-FBADoctor Team</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"><p style="font-size:12px; color:#000000; line-height:20px; margin-top:50px;"><a style="color:#000000;" href="#">FBADoctor</a> | <a style="color:#000000;" href="#">FBADoctor</a> <br>
                                            Copyright 2017 FBADoctor - All Rights Reserved.</p>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                        </html>';
                    $result = $this->common->send_email($subject,$message,$email);
                    if ($result == 1)
                        $success = lang("success_33");
                    if($result!=1){
                        $this->template->error("Error in Sending Email, So Registration can not be Done. Please contact to Admin.");exit;
                    }
                }

                $autorenew = 1;
                $perm_support = 1;
                $perm_api = 0;
                $perm_feedback = 1;
                $signup = 0;
                $billingaccountid = 0;
                $parent = 0;
                $group = 0;
                $affID = ($_POST['affiliateId'])?$_POST['affiliateId']:'';
                $datecreated = time();
                $accounid = $this->account_model->add_account(array(
                        "company" => $storename,
                        "autorenew" => $autorenew,
                        "ID_PARENT" => $parent,
                        "billingaccountid" => $billingaccountid,
                        "ID_GROUP" => $group,
                        "datecreated" => $datecreated,
                            "address" => '',
                        "city" => '',
                        "region" => '',
                        "zip" => '',
                        "country" => '',
                        "phone" => '',
                        "pending_email" => 0,
                        "signupid" => $signup,
                        "perm_support" => $perm_support,
                        "perm_api" => $perm_api,
                        "perm_feedback" => $perm_feedback,
                        "loginsent" => 1,
                        "ID_REFERRED_BY" => $affID,
                    )
                );
                $userid = $this->register_model->add_user(array(
                        "ID_ACCOUNT" => $accounid,
                        "username" => $username,
                        "email" => $email,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "password" => $pass,
                        "user_role" => 2,
                        "IP" => $_SERVER['REMOTE_ADDR'],
                        "joined" => time(),
                        "joined_date" => date("n-Y"),
                        "active" => $active,
                        "activate_code" => $activate_code
                    )
                );
                $this->feedback_setting_model->add_feedback_setting(array(
                        "ID_ACCOUNT" => $accounid,
                        "amazonstorename" => $storename,
                        "set_secondfollowupemail" => 1,
                        "mws_marketplaceid" => 1,
                        "feedbackfromemailaddress" => $email,
                        'apiactive' => 1
                    )
                );
                $this->feedback_setting_model->add_historical_cron_settings(array(
                    "ID_ACCOUNT" => $accounid
                ));
                // Check for any default user groups
                $default_groups = $this->user_model->get_default_groups();
                foreach ($default_groups->result() as $r) {
                    $this->user_model->add_user_to_group($userid, $r->ID);
                }
                $this->session->set_flashdata("globalmsg", $success);
                redirect(site_url("login"));
            }
        }
        $this->load->helper("captcha");
        $rand = rand(4000, 100000);
        $_SESSION['sc'] = $rand;
        $vals = array(
            'word' => $rand,
            'img_path' => './images/captcha/',
            'img_url' => base_url() . 'images/captcha/',
            'img_width' => 150,
            'img_height' => 30,
            'expiration' => 7200
        );
        $cap = create_captcha($vals);
        $this->template->loadContent("register/index.php", array(
            "cap" => $cap,
            "email" => $email,
            "first_name" => $first_name,
            "last_name" => $last_name,
            'fail' => $fail,
            "username" => $username,
            "affiliate"=>$affiliateId));
    }

    public function add_username()
    {
        $this->template->loadExternal(
            '<script type="text/javascript" src="'
            . base_url() . 'scripts/custom/check_username.js" /></script>'
        );
        if (!$this->user->loggedin) {
            $this->template->error(
                lang("error_1")
            );
        }
        $this->template->loadContent("register/add_username.php", array());
    }

    public function add_username_pro()
    {
        $this->load->helper('email');
        $email = $this->input->post("email", true);
        $username = $this->common->nohtml(
            $this->input->post("username", true));
        if (strlen($username) < 3)
            $fail = lang("error_14");

        if (!preg_match("/^[a-z0-9_]+$/i", $username)) {
            $fail = lang("error_15");
        }

        if (!$this->register_model->check_username_is_free($username)) {
            $fail = lang("error_16");
        }
        if (empty($email)) {
            $fail = lang("error_18");
        }

        if (!valid_email($email)) {
            $fail = lang("error_19");
        }

        if (!$this->register_model->checkEmailIsFree($email)) {
            $fail = lang("error_20");
        }

        if (!empty($fail))
            $this->template->error($fail);

        $this->register_model
            ->update_username($this->user->info->ID, $username, $email);
        $this->session->set_flashdata("globalmsg", lang("success_21"));
        redirect(site_url());
    }

    public function check_username()
    {
        $username = $this->common->nohtml(
            $this->input->get("username", true));
        if (strlen($username) < 3)
            $fail = lang("error_14");

        if (!preg_match("/^[a-z0-9_]+$/i", $username))
            $fail = lang("error_15");

        if (!$this->register_model->check_username_is_free($username)) {
            $fail = "$username " . lang("ctn_243");
        }
        if (empty($fail)) {
            echo "<span style='color:#4ea117'>" . lang("ctn_244") . "</span>";
        } else {
            echo $fail;
        }
        exit();
    }

    public function activate_account($code, $username)
    {
        $code = $this->common->nohtml($code);
        $username = $this->common->nohtml($username);

        $code = $this->user_model->get_verify_user($code, $username);
        if ($code->num_rows() == 0) {
            $this->template->set_error_view("error/login_error.php");
            $this->template->set_layout("layout/login_layout.php");
            $this->template->error(lang("error_69"));
        }
        $code = $code->row();
        if ($code->active) {
            $this->template->error(lang("error_69"));
        }

        $this->user_model->update_user($code->ID, array(
                "active" => 1,
                "activate_code" => ""
            )
        );

        // Send email
        $this->load->model("home_model");
        $this->session->set_flashdata("globalmsg", lang("success_34"));
        redirect(site_url("login"));
    }
    public function send_activation_code($userid, $email)
    {
        $userid = intval($userid);
        $email = $this->common->nohtml(urldecode($email));

        $request = $this->user_model->get_user_event("email_activation_request");

        if ($request->num_rows() > 0) {
            $request = $request->row();
            if ($request->timestamp + (15 * 60) > time()) {
                $this->template->error(lang("error_70"));
            }
        }

        $this->user_model->add_user_event(array(
                "event" => "email_activation_request",
                "IP" => $_SERVER['REMOTE_ADDR'],
                "timestamp" => time()
            )
        );

        $user = $this->user_model->get_user_by_id($userid);

        if ($user->num_rows() == 0) {
            $this->template->error(lang("error_71"));
        }
        $user = $user->row();

        if ($user->email != $email) {
            $this->template->error(lang("error_71"));
        }
        if ($user->active) {
            $this->template->error(lang("error_71"));
        }

        $this->load->model("home_model");
        $title= "User Activation";

        $message ="Dear ".$user->username.",<br /><br />Activation code send successfully<br />Please activate the account by following this link: <a href=".site_url('register/activate_account/'.$user->activate_code.'/'.$user->username).">".site_url('register/activate_account/'.$user->activate_code.'/'.$user->username)."</a><br /><br />If you did not register an account, please kindly ignore  this email.<br /><br />Yours, <br />FBADoctor";
        $result = $this->common->send_email($title, $message, $user->email);
        if ($result == 1)
            $this->session->set_flashdata("globalmsg", lang("success_35"));
        redirect(site_url("login"));
    }
}

?>