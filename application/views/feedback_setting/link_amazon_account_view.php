
<div class="white-area-content">
    <?php
        if($set==1)
        {
    ?>
        <ul id="wizard-header" class="stepy-header" style="display: table">
            <li id="wizard-head-1"><div class="col-md-4 desable">Step 1<p style="font-size:15px"><?php echo lang("ctn_515") ?></p></div>
            <li id="wizard-head-3"><div class="col-md-4 desable">Step 3<p style="font-size:15px"><?php echo lang("ctn_516") ?></p></div>
        </ul>
    <?php
        }
    ?>

    <div class="db-header clearfix">
        <div class="page-header-title"><span class="fa fa-cog"></span> Link your Amazon Account</div>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_224") ?></li>
        <li class="active">Link Amazon Account</li>
    </ol>
    <p>Link your Amazon Account with FBADoctor</p>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="panel-subheading">Link your Amazon Account</p>
            <p> To start using FBADoctor, we ask that you create a Limited Access User in Amazon Seller Central that FBADoctor
               will use to download and reconcile your feedback, refunds, returns and damaged inventory.</p>
            <p>The Step-By-Step instructions below will walk you through the process of creating an Amazon Limited
                Access User. </p>
            <p><strong>IMPORTANT</strong>: Do not use your primary Amazon Seller Central eMail/Password as we do not to
                be logged into Amazon at the same time.</p>
            <p>Once you’ve added the eMail and Password for the Limited Access User below, FBADoctor will start
                processing your data from Amazon. Depending on the amount of data it can take a few hours to reconcile.
                You should see your first cases starting to open with 24 hours.</p>
            <?php if($set==1)
            {
                echo form_open_multipart(site_url("feedback_setting/add_paymentinfo_view"), array("class" => "form-horizontal", "id" => "feedback_alert_from"));
            }
            else
            {
                echo form_open_multipart(site_url("feedback_setting/update_amazon_link_account"), array("class" => "form-horizontal", "id" => "feedback_alert_from"));
            }
            ?>
            <?php $checked = $feedback_settings['set_negative_fb_emailalerts']; ?>
            <div class="form-group">
                <label for="set_negative_fb_emailalerts" class="col-sm-4 control-label">Amazon Limited Access User eMail
                    Address :</label>
                <div class="col-sm-6" style="margin-top:7px;">
                    <?php echo $feedback_settings['link_amazon_email']; ?>
                </div>
            </div>
            <hr>
            <h3 align="center">How to Create a new Limited Access User in Amazon Seller Central</h3>
            <div class="row">
                   <h4 style="margin: 10px;">Step 1</h4>
                   <div class="col-md-6">
                       <ol style="text-align: left;" start="1">
                            <li>Log into Amazon Seller Central Account.<br><img src="<?php echo base_url(). 'images/amazon_link_images/lau-step1.png'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;"></li>
                            <li>Click <strong>Settings</strong>, and then click <strong>User Permissions</strong>. The User Permissions page appears.<br><img src="<?php echo base_url(). 'images/amazon_link_images/lau-step2.png'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;"></li>
                       </ol>
                   </div>
                   <div class="col-md-6" >
                       <ol style="text-align: left;" start="3">
                            <li>Under <strong>Add a New Seller Central User</strong>, enter <!-- <?php echo $feedback_settings['link_amazon_email']; ?> --> email, and hit "Send invitation".<br><img src="<?php echo base_url(). 'images/amazon_link_images/lau-step3.png'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;"></li><br>
                            <li>Click <strong>Send Invitation</strong>. The email invitation is sent to the email address youspecified. A confirmation appears.<br><img src="<?php echo base_url(). 'images/amazon_link_images/lau-step4.png'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;"></li><br>
                            <li>Click <strong>Continue</strong>.</li>
                       </ol>
                   </div>
            </div>
            <hr>
            <div class="row">
                <h4 style="margin: 10px;">Step 2</h4>
                <div class="col-md-6">
                    <ol style="text-align: left;" start="1">
                        <li>Log into main Amazon Seller Account and navigate to the user permissions page from the settings menu then click "Confirm" for the new user you have created.<br><img src="<?php echo base_url(). 'images/amazon_link_images/lau-step7.png'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;"></li>
                    </ol>
                </div>
                <div class="col-md-6" >
                    <ol style="text-align: left;" start="2">
                        <li>After the new user is confirmed a confirmation message will be shown. Please click <strong>Add user permissions</strong><br><img src="<?php echo base_url(). 'images/amazon_link_images/lau-step8.png'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;"></li>
                    </ol>
                </div>
            </div>
            <hr>
            <div>
                <h4>Step 3</h4>
                <p>
                    Set the User Permissions as follows:<br>
                    <i>(Please Note: You may Enable/Disable Modules within the FBADoctor Dashboard. <strong>Please Set Permissions Correctly</strong>.)</i>
                </p>
                <ul>
                    <li><strong>1-</strong> In the Inventory section, select View and Edit "Manage FBADoctor Inventory/Shipments"</li>
                    <li><strong>2-</strong> In the Orders section, select View and Edit for the entire column</li>
                    <li><strong>3-</strong> In the Reports sections, select View and Edit "Feedback"</li>
                    <li><strong>4-</strong> In the Reports sections, select View "Fulfillment Reports" AND also View and Edit "Payments" option</li>
                    <li><strong>5-</strong> In the Settings section, select View and Edit "Manage Your Cases"</li>
                </ul>
            </div>
        </div>
    </div>
    <?php
    if($set==1)
    {
    ?>
        <a href="<?php echo site_url('feedback_setting/add_amazon_info') ?>" class="btn btn-success"><?php echo lang("ctn_135") ?></a>
        <input type="submit" name="save" value="Next" class="btn btn-success "
               id="savedata"/>
        <a href="<?php echo site_url('login/logout/' . $this->security->get_csrf_hash()) ?>" class="btn btn-success" id="cancel"><?php echo lang("ctn_514") ?></a>

        <?php
    }
?>
    <?php echo form_close() ?>
</div>