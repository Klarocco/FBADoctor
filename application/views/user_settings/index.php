<?php
$this->load->helper('cookie');
$config = $this->config->item("cookieprefix");
?>
<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-cog"></span> <?php echo lang("ctn_224") ?></div>
        <?php
        if($this->user->info->admin):
            echo "";
            elseif (!$this->input->cookie($config . "old_user")) ://if($this->user->info->admin && (isset($this->user->info->switchUserId) || empty($this->user->info->switchUserId))): ?>
            <?php /*echo "<pre/>";print_r($this->user);exit;*/?>
            <div class="db-header-extra"> <a href="<?php echo site_url("Subscription/index") ?>" class="btn btn-success btn-sm"><?php echo lang("ctn587") ?></a> </div>
        <?php endif;?>
       <div class="db-header-extra"> <a href="<?php echo site_url("user_settings/change_password") ?>" class="btn btn-success btn-sm"><?php echo lang("ctn_225") ?></a></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_224") ?></li>
        <li class="active"><?php echo lang("ctn_479") ?></li>
    </ol>
    <p><?php echo lang("ctn_226") ?></p><hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="panel-subheading"><?php echo lang("ctn_227") ?></p>
            <?php echo form_open_multipart(site_url("user_settings/pro"), array("class" => "form-horizontal","id" =>"user_settings_form")) ?>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_228") ?></label>
                <div class="col-sm-10">
                   <input type="username" class="form-control" name="username" value="<?php echo $this->user->info->username; ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label "><?php echo lang("ctn_230") ?></label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" value="<?php echo $this->user->info->email ?>" >
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_231") ?></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $this->user->info->first_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_232") ?></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="last_name" value="<?php echo $this->user->info->last_name ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_233") ?></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="aboutme" rows="8"><?php echo nl2br($this->user->info->aboutme) ?></textarea>
                </div>
            </div>

            <input type="submit" name="s" value="<?php echo lang("ctn_236") ?>" class="btn btn-success form-control" />
            <?php echo form_close() ?>
        </div>
    </div>
</div>