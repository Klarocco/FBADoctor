<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-envelope"></span> <?php echo lang("ctn_422") ?></div>
        <div class="db-header-extra"> 
        </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_425") ?></li>
        <li class="active"><?php echo lang("ctn_422") ?></li>
    </ol>
    <hr>
    <table class="table table-bordered">
        <tr class="table-header"><td><?php echo lang("ctn_419") ?>
                <?php if ($col === 1) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/1/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("manage_feedback/display_pending_email_info/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td><?php echo lang("ctn_420") ?>
                <?php if ($col === 2) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/2/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("manage_feedback/display_pending_email_info/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td class="col-sm-2"><?php echo lang("ctn_400") ?>
                <?php if ($col === 3) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/3/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("manage_feedback/display_pending_email_info/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td><?php echo lang("ctn_402") ?>
                <?php if ($col === 4) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/4/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("manage_feedback/display_pending_email_info/4/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("manage_feedback/display_pending_email_info/4/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td>
            <td><?php echo lang("ctn_404") ?></td>
            <td><?php echo lang("ctn_421") ?></td>
        </tr>
        <?php foreach ($pending_email_data as $row) : ?>
            <tr>
                <td><?php echo date("j F Y h:i:s A", $row['datetosend']) ?></td>
                <td><?php echo $this->common->ReturnEmailType($row['emailtype']) ?></td>
                <td><?php echo '<a href="https://sellercentral.amazon.com/gp/orders-v2/details?ie=UTF8&orderID=' . $row['orderid'] . '"><b>' . $row['orderid'] . '</b></a>' ?></a></td>
                <td><?php echo $row['buyername'] ?></td>
                <td><?php echo $row['productname'] ?></td>
                <td><a href="" data-target="#viewmessage" data-id="<?php echo $row['ID_EMAIL'] ?> " data-toggle="modal" class="open_message_modal"><img src="<?php echo base_url() ?>/images/magnifier.png"></a><!--<a href="<?php echo site_url("Email_builder/view_sentemail/" . $row['ID_EMAIL']) ?>"><img src="<?php echo base_url() ?>/images/magnifier.png"></a>--></td>
            </tr>
        <?php endforeach; ?>
    </table> 
    <div class="align-center">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div class="modal fade" id="viewmessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="modal_id">
                    <table class="table">
                        <tbody>

                        </tbody>
                    </table>
                    <br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script>
    $(document).on("click", ".open_message_modal", function () {
        var email_id = $(this).data('id');
        loadurl = '<?php echo site_url() ?>Email_builder/view_sentemail';

        $.ajax({
            url: loadurl,
            data: {
                email_id: email_id,
                '<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',
            },
            success: function (data) {
                $("#modal_id").html(data);
            }
        });
    });  
</script>
