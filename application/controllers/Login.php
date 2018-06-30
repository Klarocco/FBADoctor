<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("user_model");
        $this->load->model("home_model");
        $this->load->model("register_model");
        $this->load->helper('cookie');
        $this->template->loadData("activeLink", array("login" => 1));
    }

    public function index()
    {
        $this->template->set_page_title("Login");
        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        if ($this->user_model->check_block_ip()) {
            $this->template->error(lang("error_26"));
        }
        if ($this->user->loggedin) {
            redirect(site_url("feedback_setting"));
        }

        $this->template->loadContent("login/index.php", array());
    }

    public function pro($id = NULL, $setting = NULL,$active= NULL) {
        if ($id == 0) {
            $this->template->set_error_view("error/login_error.php");
            $this->template->set_layout("layout/login_layout.php");

            if ($this->user_model->check_block_ip()) {
                $this->template->error(lang("error_26"));
            }

            $config = $this->config->item("cookieprefix");
            if ($this->user->loggedin) {
                $this->template->error(lang("error_27"));
            }

            $email = $this->input->post("email", true);
            $pass = $this->common->nohtml($this->input->post("pass", true));
            $remember = $this->input->post("remember", true);

            if ($this->settings->info->login_protect) {
                // Check user for 5 login attempts
                $s = $this->login_model->get_login_attempts($_SERVER['REMOTE_ADDR'], $email, (15 * 60));
                if ($s->num_rows() > 0) {
                    $s = $s->row();
                    if ($s->count >= 5) {
                        $this->template->error(lang("error_68"));
                    }
                }
            }

            if (empty($email) || empty($pass)) {
                $this->template->error(lang("error_28"));
            }

            $login = $this->login_model->getUserByEmail($email);
            if ($login->num_rows() == 0) {
                $login = $this->login_model->getUserByUsername($email);
                if ($login->num_rows() == 0) {
                    $this->login_protect($email);
                    $this->template->error(lang("error_29"));
                }
            }
            $r = $login->row();
            $userid = $r->ID;
            $email = $r->email;
            $phpass = new PasswordHash(12, false);
            if (!$phpass->CheckPassword($pass, $r->password)) {
                $this->login_protect($email);
                $this->template->error(lang("error_29"));
            }
            $userDetails = $this->login_model->getUserDetails($userid);
            if($userDetails['active']==0 && $userDetails['activate_code']==NULL){
                $this->template->error(lang("error_93"));
                exit;
            }
            if ($this->settings->info->activate_account) {
                if (!$r->active) {
                    $this->template->error(lang("error_72") . "<a href='" .
                            site_url("register/send_activation_code/" . $r->ID . "/" .
                                    urlencode($r->email)) .
                            "'>" . lang("error_73") . "</a> " . lang("error_74"));
                }
            }
            if($userDetails['deleted']=='1') {
                $this->template->error(lang("error_94"));
                exit;
            }

            // Store it
            if($userid==2){
                $userToken = $this->login_model->getUserToken($userid);
                $token =$userToken['token'];

            }else{
                // Generate a token
                $token = rand(1, 100000) . $email;
                $token = md5(sha1($token));
                $this->login_model->updateUserToken($userid, $token);
            }

            // Create Cookies
            if ($remember == 1) {
                $ttl = 3600 * 24 * 31;
            } else {
                $ttl = 3600 * 24 * 31;
            }

            setcookie($config . "un", $email, time() + $ttl, "/");
            setcookie($config . "tkn", $token, time() + $ttl, "/");

            redirect(site_url("home"));
        } else {
            $this->template->set_error_view("error/login_error.php");
            $this->template->set_layout("layout/login_layout.php");
            $config = $this->config->item("cookieprefix");
            $user = $this->login_model->get_user($id);
            $user_role = $user[0]->user_role;
            $email = $user[0]->email;
            $old_un = $this->input->cookie($config . "un");
            $old = $this->login_model->getUserByEmail($old_un);
            $old_usr = $old->row();
            $old_user = $old_usr->ID_ACCOUNT;
            $ttl = 3600 * 24 * 31;
            delete_cookie($config . "un");
            delete_cookie($config . "tkn");
            if ($user_role == 1) {
                delete_cookie($config . "old_user");
            } else {
                setcookie($config . "old_user", $old_user, time() + $ttl, "/");
            }
            if ($this->user_model->check_block_ip()) {
                $this->template->error(lang("error_26"));
            }
            if (empty($email)) {
                $this->template->error(lang("error_28"));
            }
            $login = $this->login_model->getUserByEmail($email);
            if ($login->num_rows() == 0) {
                $login = $this->login_model->getUserByUsername($email);
                if ($login->num_rows() == 0) {
                    $this->login_protect($email);
                    $this->template->error(lang("error_29"));
                }
            }
            $r = $login->row();
            $userid = $r->ID;
            $email = $r->email;
            $this->user->info->switchUserId = $id;
            $token = rand(1, 100000) . $email;
            $token = md5(sha1($token));
            // Store it
            $this->login_model->updateUserToken($userid, $token);
            // Create Cookies
            setcookie($config . "un", $email, time() + $ttl, "/");
            setcookie($config . "tkn", $token, time() + $ttl, "/");
            if($id==2 && $setting==1){
                redirect(site_url("home"));
            }
            else{
                if (($setting == 0 && $active == 1) || ($setting==0&& $active ==0)) {
                    redirect(site_url("feedback_setting/setup"));
                } else if(($setting==1 && $active ==1) || ($setting == 1 && $active == 0)){
                    redirect(site_url("home"));
                }
            }
        }
    }

    private function login_protect($email) {
        if ($this->settings->info->login_protect) {
            // Add Count
            $s = $this->login_model
                    ->get_login_attempts($_SERVER['REMOTE_ADDR'], $email, (15 * 60));
            if ($s->num_rows() > 0) {
                $s = $s->row();
                $this->login_model->update_login_attempt($s->ID, array(
                    "count" => $s->count + 1
                        )
                );
            } else {
                $this->login_model->add_login_attempt(array(
                    "IP" => $_SERVER['REMOTE_ADDR'],
                    "username" => $email,
                    "count" => 1,
                    "timestamp" => time()
                        )
                );
            }
        }
    }

    public function logout() {
        $this->template->set_error_view("error/login_error.php");
        $config = $this->config->item("cookieprefix");
        $this->load->helper("cookie");
        delete_cookie($config . "un");
        delete_cookie($config . "tkn");
        delete_cookie($config . "provider");
        delete_cookie($config . "oauthid");
        delete_cookie($config . "oauthtoken");
        delete_cookie($config . "oauthsecret");
        delete_cookie($config . "old_user");
        $this->session->sess_destroy();
        redirect(site_url());
    }

    public function resetpw($token, $userid) {
        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        $userid = intval($userid);
        // Check
        $user = $this->login_model->getResetUser($token, $userid);
        if ($user->num_rows() == 0) {
            $this->template->error(lang("error_42"));
        }

        $r = $user->row();
        if ($r->timestamp + 3600 * 24 * 7 < time()) {
            $this->template->error(lang("error_43"));
        }

        $this->template->loadContent("login/resetpw.php", array(
            "token" => $token,
            "userid" => $userid
                )
        );
    }

    public function resetpw_pro($token, $userid) {
        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        $userid = intval($userid);
        // Check
        $user = $this->login_model->getResetUser($token, $userid);
        if ($user->num_rows() == 0) {
            $this->template->error(lang("error_42"));
        }
        $r = $user->row();
        if ($r->timestamp + 3600 * 24 * 7 < time()) {
            $this->template->error(lang("error_43"));
        }

        $npassword = $this->common->nohtml(
                $this->input->post("npassword", true)
        );
        $npassword2 = $this->common->nohtml(
                $this->input->post("npassword2", true)
        );

        if ($npassword != $npassword2) {
            $this->template->error(lang("error_44"));
        }

        if (empty($npassword)) {
            $this->template->error(lang("error_45"));
        }

        $password = $this->common->encrypt($npassword);

        $this->login_model->updatePassword($userid, $password);
        $this->login_model->deleteReset($token);
        $this->session->set_flashdata("globalmsg", lang("success_18"));
        redirect(site_url("login"));
    }

    public function forgotpw() {
        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        $this->template->loadContent("login/forgotpw.php", array());
    }

    public function forgotpw_pro() {
        $this->template->set_layout("layout/login_layout.php");
        $this->template->set_error_view("error/login_error.php");
        $email = $this->input->post("email", true);
        $log = $this->login_model->getResetLog($_SERVER['REMOTE_ADDR']);
        if ($log->num_rows() > 0) {
            $log = $log->row();
            if ($log->timestamp + 60 * 15 > time()) {
                $this->template->error(
                        lang("error_46")
                );
            }
        }
        $this->login_model->addToResetLog($_SERVER['REMOTE_ADDR']);
        // Check for email
        $user = $this->login_model->getUserEmail($email);
        if ($user->num_rows() == 0) {
            $this->template->error(
                    lang("error_47")
            );
        }
        $user = $user->row();
        $token = rand(10000000, 100000000000000000)
                . "HUFI9e9dvcwjecw8392klle@O(*388*&&£^^$$$";
        $token = sha1(md5($token));
        $this->login_model->resetPW($user->ID, $token);
        // Send Email
        $subject = "FBADoctor Password Assistance";
        $message = "<html>
                        <body>
                            <p>Forgot your password?</p><br>
                            <p>We’ve received a request to reset the password for this email address.</p><br>
                            <p>To reset your password please click on the this link or cut and paste this URL into your browser (link expires in 24 hours):</p><br>
                            <a href=".site_url('login/resetpw/'.$token.'/'.$user->ID).">".site_url('login/resetpw/'.$token.'/'.$user->ID)."</a><br />
                            <p>This link takes you to a secure page where you can change your password.</p>
                            <p>If you don’t want to reset your password , please ignore this message. Your password will not be reset.</p>
                            <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                            <p>For general inquiries or to request support with your account, please email</p> 
                        </body>
                    </html>";
        $this->common->send_email($subject, $message, $email);
        $this->session->set_flashdata("globalmsg", lang("success_19"));
        redirect(site_url("login/forgotpw"));
    }

    public function banned() {
        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        $this->template->loadContent("login/banned.php", array());
    }

}

?>