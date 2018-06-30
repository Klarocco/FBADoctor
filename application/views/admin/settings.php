<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="fa fa-user"></span> <?php echo lang("ctn_89") ?></div>
    <div class="db-header-extra"> 
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li class="active"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo lang("ctn_89") ?></li>
</ol>

<p><?php echo lang("ctn_90") ?></p>

<hr>

<div class="panel panel-default">
<div class="panel-body">
<?php echo form_open_multipart(site_url("admin/settings_pro"), array("class" => "form-horizontal","id"=>"global_setting_form")) ?>

<div class="form-group">
    <label for="name-in" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_91") ?></label>
    <div class="col-sm-10">
    	<input type="text" class="form-control" id="name-in" name="site_name" placeholder="" value="<?php echo $this->settings->info->site_name ?>">
    	<span class="help-block"><?php echo lang("ctn_92") ?></span>
    </div>
</div>
  
<div class="form-group">
            <label for="desc-in" class="col-sm-2 control-label"><?php echo lang("ctn_93") ?></label>
            <div class="col-sm-10">
	            <input type="text" class="form-control" id="desc-in" name="site_desc" placeholder="" value="<?php echo $this->settings->info->site_desc ?>">
	            <span class="help-block"><?php echo lang("ctn_94") ?></span>
	        </div>
</div>
<div class="form-group">
    <label for="se-in" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_95") ?></label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="se-in" name="site_email" placeholder="" value="<?php echo $this->settings->info->site_email ?>">
        <span class="help-block"><?php echo lang("ctn_96") ?></span>
    </div>
</div>
<div class="form-group">
    <label for="image-in" class="col-sm-2 control-label"><?php echo lang("ctn_97") ?></label>
    <div class="col-sm-10">
        <?php if(!empty($this->settings->info->site_logo)) : ?>
            <p><img src='<?php echo base_url(). "images/" . $this->settings->info->site_logo ?>' style="background: #F5F5F5;" width="200" height="100" onerror="this.src='<?php echo base_url().'images/logo.png'?>'"></p>
        <?php endif; ?>
        <input type="file" name="userfile" size="20" />
        <span class="help-block"><?php echo lang("ctn_98") ?></span>
    </div>
</div>


<div class="form-group">
    <label for="dpname-in" class="col-sm-2 control-label"><?php echo lang("ctn_109") ?></label>
    <div class="col-sm-10">
        <input type="checkbox" name="register" value="1" <?php if($this->settings->info->register) echo "checked" ?> />
        <span class="help-block"><?php echo lang("ctn_110") ?></span>
    </div>
</div>
<div class="form-group">
    <label for="dpname-in" class="col-sm-2 control-label"><?php echo lang("ctn_111") ?></label>
    <div class="col-sm-10">
        <input type="checkbox" name="disable_captcha" value="1" <?php if($this->settings->info->disable_captcha) echo "checked" ?> />
        <span class="help-block"><?php echo lang("ctn_112") ?></span>
    </div>
</div>

<div class="form-group">
    <label for="dpname-in" class="col-sm-2 control-label"><?php echo lang("ctn_327") ?></label>
    <div class="col-sm-10">
        <input type="checkbox" name="login_protect" value="1" <?php if($this->settings->info->login_protect) echo "checked" ?> />
        <span class="help-block"><?php echo lang("ctn_328") ?></span>
    </div>
</div>
<div class="form-group">
    <label for="dpname-in" class="col-sm-2 control-label"><?php echo lang("ctn_329") ?></label>
    <div class="col-sm-10">
        <input type="checkbox" name="activate_account" value="1" <?php if($this->settings->info->activate_account) echo "checked" ?> />
        <span class="help-block"><?php echo lang("ctn_330") ?></span>
    </div>
</div>

<input type="submit" class="btn btn-success form-control" value="<?php echo lang("ctn_13") ?>" />
<?php echo form_close() ?>
</div>
</div>
</div>