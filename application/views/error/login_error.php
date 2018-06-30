<div class="container">
    <div class="row">
        <div class="col-md-5 center-block-e">
            <div class="login-page-header">
                <img src="<?php echo base_url();?>images/logo.png" class="user-image " alt="User Image"><br><br>
                <?php echo lang("ctn_133") ?>
            </div>
            <div class="login-page" style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #000000;">
                <b><?php echo lang("ctn_134") ?>:</b> <?php echo $message ?>
                <p><input type="button" value="<?php echo lang("ctn_135") ?>" onclick="window.history.back()" class="btn btn-default btn-sm"/></p>
            </div>
        </div>
    </div>
</div>