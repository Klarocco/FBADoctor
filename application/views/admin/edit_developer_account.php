<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-cog"></span> <?php echo lang("ctn_387") ?></div>

    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_387") ?></li>
    </ol>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
<?php echo form_open_multipart(site_url("admin/update_dev_account/" . $dev_account_data['id']), array("class" => "form-horizontal", "id" => "edit_dev_account_form")) ?>
            <div class="form-group">
                <label for="marketplace_id" class="col-sm-2 control-label"><?php echo lang("ctn_348") ?></label>
                <div class="col-md-8" >
                    <select name="marketplace_id" class="form-control" required="">
                        <?php
                        foreach ($marketplace_id as $row) {
                            $sel = '';
                            if ($dev_account_data['marketplace_id'] == $row['id'])
                                $sel = "selected";
                            ?>
                            <option value="<?php echo $row['id'] ?>"  <?php if (isset($sel)) echo $sel; ?>><?php echo $row['marketplace_name'] ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="access_key" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_349") ?></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="marketplace_name" name="access_key" required="" value="<?php echo $dev_account_data['access_key'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="secret_key" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_350") ?></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="host" name="secret_key" required="" value="<?php echo $dev_account_data['access_key'] ?>">
                </div>
            </div>
            <a href="<?php echo site_url() ?>/admin/amazon_developer_account" class="btn btn-default"><?php echo lang("ctn_60") ?></a>
            <input type="submit" class="btn btn-primary " value="<?php echo lang("ctn_61") ?>" name="save" />
            <?php echo form_close() ?>
        </div>
    </div>
</div>