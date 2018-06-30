<div class="container">
    <div class="row">
        <div class="col-md-5 center-block-e">
            <div class="login-page-header">
                <img src="<?php echo base_url();?>images/logo.png" class="user-image " alt="User Image"><br><br>
                <?php echo lang("ctn_174") ?>
            </div>
            <div class="login-page" style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #000000;">
                <p> <?php echo lang("ctn_175") ?></p>
                <?php echo form_open(site_url("login/forgotpw_pro/"),array("class" => "form-horizontal","id" => "forgot_form")) ?>
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="text" name="email" id="email" class="form-control" required>
                </div><br />
                <input type="submit" class="btn btn-primary form-control" value=" <?php echo lang("ctn_176") ?>" >
                <?php echo form_close() ?>
                <p class="decent-margin align-center"><a href="<?php echo site_url("login") ?>"> <?php echo lang("ctn_177") ?></a></p>

            </div>
        </div>
    </div>
</div>
