<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-cog"></span> <?php echo lang("ctn_359") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_224") ?></li>
        <li class="active"><?php echo lang("ctn_359") ?></li>
    </ol>
    <p><?php echo lang("ctn_226") ?></p>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="panel-subheading"><?php echo lang("ctn_227") ?></p>
            <?php echo form_open_multipart(site_url("feedback_setting/update_emailsetting"), array("class" => "form-horizontal", "id" => "email_setting_form")) ?>
            <?php $selected = $feedback_settings['set_sendemails_fbaorders']; ?> 
            <div class="form-group">
                <label for="set_sendemails_fbaorders" class="col-sm-2 control-label"><?php echo lang("ctn_360") ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" name="set_sendemails_fbaorders" value="1" value="<?php echo $feedback_settings['set_sendemails_fbaorders']; ?>" <?php if ($selected == 1) echo 'checked'; ?> id="set_sendemails_fbaorders" />
                </div>
            </div>
            <div class="form-group">
                <label for="set_sendemails_fbafeedbackdays" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_361") ?></label>
                <div class="col-sm-10">
                    <input type="text" name="set_sendemails_fbafeedbackdays" value="<?php echo $feedback_settings['set_sendemails_fbafeedbackdays']; ?>" class="form-control" id="set_sendemails_fbafeedbackdays" />
                </div>
            </div>
            <?php $selected = $feedback_settings['set_secondfollowupemail']; ?> 
            <div class="form-group">
                <label for="set_secondfollowupemail" class="col-sm-2 control-label"><?php echo lang("ctn_365") ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" name="set_secondfollowupemail" value="1" value="<?php echo $feedback_settings['set_secondfollowupemail']; ?>" <?php if ($selected == 1) echo 'checked'; ?> id="set_secondfollowupemail" />
                </div>
            </div>
            <div class="form-group">
                <label for="set_secondfollowupemail_days" class="col-sm-2 control-label"><?php echo lang("ctn_366") ?></label>
                <div class="col-sm-10">
                    <input type="text" name="set_secondfollowupemail_days" value="<?php echo $feedback_settings['set_secondfollowupemail_days']; ?>" class="form-control" id="set_secondfollowupemail_days" />
                </div>
            </div>
            <?php $selected = $feedback_settings['set_thirdfollowupemail']; ?> 
            <div class="form-group">
                <label for="set_thirdfollowupemail" class="col-sm-2 control-label"><?php echo lang("ctn_457") ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" name="set_thirdfollowupemail" value="1" value="<?php echo $feedback_settings['set_thirdfollowupemail']; ?>" <?php if ($selected == 1) echo 'checked'; ?> id="set_thirdfollowupemail" />
                </div>
            </div>
            <div class="form-group">
                <label for="set_thirdfollowupemail_days" class="col-sm-2 control-label "><?php echo lang("ctn_458") ?> </label>
                <div class="col-sm-10">
                    <input type="text" name="set_thirdfollowupemail_days" value="<?php echo $feedback_settings['set_thirdfollowupemail_days']; ?>" class="form-control" id="set_thirdfollowupemail_days" />
                </div>
            </div>
            <?php $selected = $feedback_settings['set_fourthfollowupemail']; ?> 
            <div class="form-group">
                <label for="set_fourthfollowupemail" class="col-sm-2 control-label"><?php echo lang("ctn_459") ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" name="set_fourthfollowupemail" value="1" value="<?php echo $feedback_settings['set_fourthfollowupemail']; ?>" <?php if ($selected == 1) echo 'checked'; ?> id="set_fourthfollowupemail" />
                </div>
            </div>
            <div class="form-group">
                <label for="set_fourthfollowupemail_days" class="col-sm-2 control-label "><?php echo lang("ctn_460") ?> </label>
                <div class="col-sm-10">
                    <input type="text" name="set_fourthfollowupemail_days" value="<?php echo $feedback_settings['set_fourthfollowupemail_days']; ?>" class="form-control" id="set_fourthfollowupemail_days" />
                </div>
            </div>
            <div class="form-group">
                <label for="set_sendemails_time" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_364") ?> </label>
                <div class="col-sm-10">
                    <input type="text" id="sendemails_time" name="set_sendemails_time" value="<?php echo $feedback_settings['set_sendemails_time']; ?>" > 
                </div>
            </div>
            <input type="submit" name="s" value="<?php echo lang("ctn_236") ?>" class="btn btn-primary form-control" />
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        $.noConflict();
        $('#sendemails_time').timepicker({});
        //First email enable or disable
        document.getElementById('set_sendemails_fbaorders').onchange = function() {
        document.getElementById('set_sendemails_fbafeedbackdays').disabled = !this.checked;
        };
        
        //second email enable or disable
        document.getElementById('set_secondfollowupemail').onchange = function() {
        document.getElementById('set_secondfollowupemail_days').disabled = !this.checked;
        };
        
        //Third email enable or disable
        document.getElementById('set_thirdfollowupemail').onchange = function() {
        document.getElementById('set_thirdfollowupemail_days').disabled = !this.checked;
        };
        
        //Fourth email enable or disable
        document.getElementById('set_fourthfollowupemail').onchange = function() {
        document.getElementById('set_fourthfollowupemail_days').disabled = !this.checked;
        };
    });
  
</script>    