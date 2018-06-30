<?php

class My_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->user->loggedin)
            redirect(site_url("login"));
        if (!$this->user->info->admin)
        {
            if (empty($this->user->info->mwssettingsdone))
                redirect(site_url("feedback_setting/setup"));

            $joined=$this->user->info->joined;
            $date = new DateTime("@$joined");
            $joined_date= $date->format('Y-m-d H:i:s');
            $new_joined_date= date('Y-m-d H:i:s', strtotime($joined_date . ' +1 day'));
            $current_date = date('Y-m-d H:i:s');
            if($current_date < $new_joined_date)
            {
                redirect(site_url('Inprogress'));
            }

            if (empty($this->user->info->LinkAmazonEnabledisable))
              redirect(site_url("feedback_setting/link_amazon_account"));
        }
    }

}

?>
