<style>

    .link {
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -o-pre-wrap;
        word-wrap: break-word;
        width: 30px;
    }

</style>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-cog"></span> <?php echo lang("ctn_344") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_224") ?></li>
        <li class="active"><?php echo lang("ctn_344") ?></li>
    </ol>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open_multipart(site_url("feedback_setting/update_feedback_setting"), array("class" => "form-horizontal", "id" => "feedback_setting_form")) ?>
                <div class="panel-body">
                    <ol>
                        <h2 align="center">2 simple steps and you're done;</h2><br>
                        <div class="row">
                            <div class="col-sm-4" style="margin-top: 12px;">
                                <li> click On <a class="link"  href="https://sellercentral.amazon.com/gp/mws/registration/register.html"  target="_blank" class="wp">https://sellercentral.amazon.com/gp/mws/registration/register.html</a>
                                    for the MWS registration page, click on the button labeled <strong>I want to authorize a
                                        developer to access my Amazon seller account with Amazon MWS</strong>.
                                    <br>In the <strong>Developer's Name</strong> text box, type in <em>FBADoctor</em>.
                                    <br>In the Developer Account Number text box, enter our MWS developer account identifier:
                                    <strong>1164-2894-7953</strong>
                                    <br>Click the <strong>Next</strong> button.
                                </li>
                            </div>
                            <div class="col-sm-8" align="center"><br>
                                <img src="<?php echo base_url() . 'images/amazon_account_images/image-1.png'; ?>" class="img-responsive" height="85%" width="85%" style="margin-left: 10px;">
                            </div>
                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-sm-4" style="margin-top: 12px;">
                                <li>Copy your account identifiers (Seller ID, MWS Authorization Token, and Marketplace ID) as we
                                    need them in order to programmatically access your Amazon seller account.
                                </li>
                            </div>
                            <div class="col-sm-8" align="center"><br>
                                <img src="<?php echo base_url() . 'images/amazon_account_images/image-2.png'; ?>" class="img-responsive" height="85%" width="85%" style="margin-left: 10px;">
                            </div>
                        </div>
                    </ol>
                </div>

            <div>
                <h2 align="center">Enter the information step 2:</h2>
            </div> <br>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_347") ?></label>
                <div class="col-sm-10">
                    <input type="text" name="mws_sellerid" value="<?php echo $feedback_settings['mws_sellerid']; ?>" class="form-control" id="mws_sellerid" />
                </div>
            </div>
           <div class="form-group" style="display: none;">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_348") ?></label>
                <div class="col-sm-10">
                    <?php $sel = $feedback_settings['mws_marketplaceid']; ?>
                    <select name="mws_marketplaceid" class="form-control" >
                        <?php
                        foreach ($marketplace_id as $row) {
                            $sel_option = '';
                            if ($row['id'] == $sel)
                                $sel_option = 'selected';
                            ?>
                            <option value="<?php echo $row['id'] ?>"  <?php echo $sel_option; ?> ><?php echo $row['marketplace_name'] ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_393") ?></label>
                <div class="col-sm-10">
                    <input type="text"  name="mws_authtoken" value="<?php echo $feedback_settings['mws_authtoken']; ?>" class="form-control" id="mws_authtoken" />
                </div>
            </div>
            <input type="submit" name="s" value="<?php echo lang("ctn_236") ?>" class="btn btn-success form-control" />
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<div class="modal fade" id="amazoninstruction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Amazon account integration instructions</h4>
            </div>
            <div class="modal-body">
                <p class="view-result">
                    <div class="alert alert-success">
                        <ol>
                            <li>Go to <a href="http://developer.amazonservices.com" target="_blank">http://developer.amazonservices.com</a></li>
                            <li>Click the <strong>Sign up for MWS</strong> button.</li>
                            <li>Log in to your Amazon seller account.</li>
                            <li>On the MWS registration page, click on the button labeled <strong>I want to give a developer access to my Amazon seller account with MWS</strong>.</li>
                            <li>In the <strong>Developer's Name</strong> text box, type in <em>FBADoctor</em>.</li>
                            <li>In the Developer Account Number text box, enter our MWS developer account identifier: <strong>1164-2894-7953</strong></li>
                            <li>Click the <strong>Next</strong> button.</li>
                            <li>Accept the Amazon MWS License Agreements and click the <strong>Next</strong> button.</li>
                            <li>Copy your account identifiers (Seller ID, MWS Authorization Token, and Marketplace ID) as we need them in order to programmatically access your Amazon seller account.</li>
                            <li>Paste your account identifiers into the Amazon Seller ID, Amazon Auth Token and Amazon Marketplace ID fields at the top of this page and click TEST AMAZON CONNECTION.</li>
                            <li>Follow the instractions just below the TEST AMAZON CONNECTION button and fill in the remaining fields on this page.</li>
                        </ol>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {
        $("#datepicker").datepicker();
    });
</script>