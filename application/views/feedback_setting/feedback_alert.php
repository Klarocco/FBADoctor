<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-cog"></span> <?php echo lang("ctn_354") ?></div>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_224") ?></li>
        <li class="active"><?php echo lang("ctn_354") ?></li>
    </ol>
    <p><?php echo lang("ctn_226") ?></p>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="panel-subheading"><?php echo lang("ctn_227") ?></p>
            <?php echo form_open_multipart(site_url("feedback_setting/update_alert_setting"), array("class" => "form-horizontal", "id" => "feedback_alert_from")) ?>
            <?php $checked = $feedback_settings['set_negative_fb_emailalerts']; ?>
            <div class="form-group">
                <label for="set_negative_fb_emailalerts" class="col-sm-2 control-label"><?php echo lang("ctn_355") ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" name="set_negative_fb_emailalerts" value="1" value="<?php echo $feedback_settings['set_negative_fb_emailalerts']; ?>"  <?php if ($checked == 1) echo 'checked'; ?> id="set_negative_fb_emailalerts" />
                </div>
            </div>
            <?php $checked = $feedback_settings['set_netural_fb_emailalerts']; ?>	
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_356") ?></label>
                <div class="col-sm-10">
                    <input type="checkbox" name="set_netural_fb_emailalerts" value="1" value="<?php echo $feedback_settings['set_netural_fb_emailalerts']; ?>" <?php if ($checked == 1) echo 'checked'; ?> id="set_netural_fb_emailalerts" />
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_358") ?></label>
                <div class="col-sm-10">
                    <input type="email" name="set_notification_fbalerts_email" value="<?php echo $feedback_settings['set_notification_fbalerts_email']; ?>" class="form-control" id="set_notification_fbalerts_email" />
                </div>
            </div>
            <input type="submit" name="s" value="<?php echo lang("ctn_236") ?>" class="btn btn-success form-control" />
            <?php echo form_close() ?>
        </div>
    </div>
</div>