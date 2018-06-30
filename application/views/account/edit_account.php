<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_386") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_386") ?></li>
    </ol>
    <?php echo form_open_multipart(site_url("account/update_account/" . $account['ID_ACCOUNT']), array("class" => "form-horizontal", "id" => "edit_account_form")) ?>
    <div class="form-group">
        <label for="company" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_368") ?></label>
        <div class="col-sm-8">
            <input type="text" name="company" value="<?php echo $account['company']; ?>" class="form-control" id="company" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-sm-2 control-label"><?php echo lang("ctn_371") ?></label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $account['address'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="city" class="col-sm-2 control-label"><?php echo lang("ctn_372") ?></label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="address" name="city" value="<?php echo $account['city'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="state" class="col-sm-2 control-label"><?php echo lang("ctn_373") ?></label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="address" name="state" value="<?php echo $account['region'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="zip" class="col-sm-2 control-label"><?php echo lang("ctn_374") ?></label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="address" name="zip" value="<?php echo $account['zip'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="country" class="col-sm-2 control-label"><?php echo lang("ctn_375") ?></label>
        <div class="col-md-8">
            <input type="text" class="form-control" name="country" value="<?php echo $account['country'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="col-sm-2 control-label"><?php echo lang("ctn_376") ?></label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="address" name="phone" value="<?php echo $account['phone']; ?>">
        </div>
    </div>

    <a href="<?php echo site_url() ?>/account/index" class="btn btn-default"><?php echo lang("ctn_60") ?></a>
    <input type="submit" class="btn btn-primary " value="<?php echo lang("ctn_61") ?>" name="update" />
    <?php echo form_close(); ?>
</div>
<script>
    $(function () {
        $("#nextbilldate").datepicker();
    });
</script>