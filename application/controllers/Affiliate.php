<?php

class Affiliate extends My_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('affiliate_model');
    }

    public function index()
    {
        $this->template->loadData("activeLink", array("affiliate" => array("affiliate" => 1)));
        if ($this->user->info->admin)
        {
            $userwisedetail = $this->affiliate_model->getAffiliateUserscommission();
        }
        else
        {
           $userwisedetail = $this->affiliate_model->getAffiliateUserscommission($this->user->info->ID_ACCOUNT);
        }
        $this->template->loadContent('affiliate/index.php', array('userwisedata' => $userwisedetail));

    }

    function AffiliateInviteFriend()
    {
        $data['userDetails'] = $this->user->info;
        $data['htmlContent'] = "There’s an amazing service that has recovered lots of money for me from Amazon!<br><br>
                        The company is <a href ='". base_url() ."'>FBADoctor</a> and they audit your FBA account for discrepancies or mistakes made by Amazon, then submits cases to claim your money back from them. They only get paid if you make money! They charge 25% of the money you get back through their service. Get no money back, and you won’t owe them a dime.<br><br>
                        Here are the types of cases <b>FBADoctor</b> opens:<br><br>
                        <ul>
                            <li>Unit lost report - They track all transactions per item, amount received, orders, returns, reimbursements, and removals found, and reconcile with the actual stock to make sure they match. Plus they check for items destroyed by Amazon without your request.</li>
                            <li>For orders returned after 30 days, they make sure you got 20% restocking fee.</li>
                            <li>Orders where customers were credited more than they were charged.</li>
                            <li>Orders debited but never actually returned.</li>
                            <li>Items damaged by shipper inbound or mis received, and older than 30 days.</li>
                            <li>Orders in which weight fee or dimensional fee was overcharged.</li>
                        </ul><br>
                        <h2>You’ve got zero to lose.</h2><br>
                    If you are interested the signup process takes under ten minutes, and you will start getting reimbursed within 72 hours!<br><br>
                    Join over 1,200 plus happy customers who have gotten money back from Amazon that rightfully belongs to them!<br></p>";
       $this->template->loadContent('affiliate/AffiliateInvite.php',$data);
    }

    public function sendAffiliate($accountId)
    {
        $flag = 0;
        if(!empty($_POST['userDetails']))
        {
            foreach ($_POST['userDetails'] as $user){
                $message = "<br>Hi ".$user['userName'].",<br>";
                $message .= $_POST['affiliateMessage'];
                $message .= "<br>Go to <a href='".$_POST['affiliateUrl']. "' target='_blank'>Registration Link</a> today and sign up.<br>";
                $result = $this->common->send_email($_POST['subject'], $message,$user['userEmail']);
                if($result==1){
                    $flag = 1;
                }
            }
        }
        if($flag==1){
            echo json_encode('1');exit;
        }else{
            echo json_encode('0');exit;
        }
    }

}

?>