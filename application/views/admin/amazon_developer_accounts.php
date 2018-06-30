<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_392") ?></div>
        <div class="db-header-extra"><input type="button" class="btn btn-primary btn-sm" value="<?php echo lang("ctn_462") ?>" data-toggle="modal" data-target="#memberModal" />
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li><?php echo lang("ctn_1") ?></li>
         <li><?php echo lang("ctn_390") ?></li>
        <li class="active"><?php echo lang("ctn_392") ?></li>
    </ol>
    <hr>
    <div class="align-center">
        <?php echo $this->pagination->create_links(); ?>
    </div>

    <table class="table table-bordered">
        <tr class="table-header"><td><?php echo lang("ctn_348") ?>
                <?php if ($col === 1) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("admin/amazon_developer_account/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("admin/amazon_developer_account/1/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("admin/amazon_developer_account/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td><?php echo lang("ctn_349") ?>
                <?php if ($col === 2) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("admin/amazon_developer_account/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("admin/amazon_developer_account/2/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("admin/amazon_developer_account/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td><?php echo lang("ctn_350") ?>
                <?php if ($col === 3) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("admin/amazon_developer_account/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("admin/amazon_developer_account/3/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("admin/amazon_developer_account/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td>Options</td></tr>

        <?php foreach ($developer_account as $r) : ?>
            <tr>
                <?php
                foreach ($marketplace_id as $data) {
                    if ($data['id'] == $r['marketplace_id'])
                        $market_id = $data['marketplace_name'];
                    ?>
    <?php } ?>
                <td><?php echo $market_id ?></td>
                <td><?php echo $r['access_key'] ?></td>
                <td><?php echo $r['secret_key'] ?></td>
                <td><a href="<?php echo site_url("admin/edit_dev_account/" . $r['id']) ?>" class="btn btn-warning btn-xs"><?php echo lang("ctn_55") ?></a> 
                </td></tr>
<?php endforeach; ?>
    </table>
    <div class="align-center">
<?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo lang("ctn_367") ?></h4>
                </div>
                <div class="modal-body">
<?php echo form_open_multipart(site_url("admin/add_dev_account"), array("class" => "form-horizontal", "id" => "dev_add_account_form")) ?>
                    <div class="form-group">
                        <label for="marketplace_id" class="col-md-3 control-label"><?php echo lang("ctn_348") ?></label>
                        <div class="col-md-9" >
                            <select name="marketplace_id" class="form-control" required="">
                                <?php foreach ($marketplace_id as $row) { ?>
                                    <option value="<?php echo $row['id'] ?>"  ><?php echo $row['marketplace_name'] ?></option>
<?php } ?>                        
                            </select>
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="access_key" class="col-md-3 control-label asterisk"><?php echo lang("ctn_349") ?></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="marketplace_name" name="access_key" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="secret_key" class="col-md-3 control-label asterisk"><?php echo lang("ctn_350") ?></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="host" name="secret_key" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
                    <input type="submit" class="btn btn-primary" value="<?php echo lang("ctn_61") ?>" name="save" />
<?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>