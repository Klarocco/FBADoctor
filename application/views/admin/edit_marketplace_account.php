<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_424") ?></div>
        <div class="db-header-extra">
        </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li><?php echo lang("ctn_1") ?></li>
        <li><a href="<?php echo site_url("admin/marketplace_account") ?>"><?php echo lang("ctn_424") ?></a></li>
        
    </ol>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
<?php echo form_open_multipart(site_url("admin/update_marketplace_account/" . $marketplace_account_data['id']), array("class" => "form-horizontal", "id" => "edit_marketplace_account")) ?>
            <div class="form-group">
                <label for="marketplace_id" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_348") ?></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="marketplaceid" name="marketplace_id" value="<?php echo $marketplace_account_data['marketplace_id'] ?>" >
                </div>
            </div>
            <div class="form-group">
                <label for="marketplace_name" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_388") ?></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="marketplace_name" name="marketplace_name" value="<?php echo $marketplace_account_data['marketplace_name'] ?>" >
                </div>
            </div>
            <div class="form-group">
                <label for="host" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_389") ?></label>
                <div class="col-md-8">
                    <input type="url" class="form-control" id="host" name="host" value="<?php echo $marketplace_account_data['host'] ?>" >
                </div>
            </div>
            <a href="<?php echo site_url() ?>/admin/marketplace_account" class="btn btn-default"><?php echo lang("ctn_60") ?></a>   
            <input type="submit" class="btn btn-primary " value="<?php echo lang("ctn_13") ?>" name="save" />
 <?php echo form_close() ?>
        </div>
    </div>
</div>