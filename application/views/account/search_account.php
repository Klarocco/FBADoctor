<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
        <div class="db-header-extra">
        </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_1") ?></a></li>
        <li><a href="<?php echo site_url("account/index") ?>"><?php echo lang("ctn_341") ?></a></li>
        <li class="active">Search Account</li>
    </ol>
    <p>Searching for accounts ...</p>
    <hr>
    <table class="table table-bordered">
        <tr class="table-header"><td><?php echo lang("ctn_368") ?>

            </td><td><?php echo lang("ctn_396") ?>
            </td><td><?php echo lang("ctn_397") ?>
            </td><td><?php echo lang("ctn_398") ?>
            </td><td><?php echo lang("ctn_52") ?>
            </td></tr>
        <?php foreach ($members as $r) : ?>

            <tr><td><?php echo $r['company']; ?>&nbsp;&nbsp;<a href="<?php echo site_url('Login/pro/'.$r['ID_ACCOUNT'].'/'.$r['mwssettingsdone']);?>">(Switch User)</a></td>


                <?php $sel = $r['datecreated'];
                $created_date = date("m/d/Y", $sel); ?>
                <td><?php echo $created_date; ?></td>
                <td><?php echo $r['enabled']; ?></td>
                <td><?php echo $r['mwssettingsdone']; ?></td>
                <td><a href="<?php echo site_url("account/edit_account/" . $r['ID_ACCOUNT']) ?>" class="btn btn-warning btn-xs"><?php echo lang("ctn_55") ?></a> <a href="<?php //echo site_url("admin/delete_member/" . $r->ID . "/" . $this->security->get_csrf_hash())  ?>" onclick="return confirm('<?php echo lang("ctn_86") ?>')" class="btn btn-danger btn-xs"><?php echo lang("ctn_57") ?></a></td>
            </tr>
<?php endforeach; ?>

    </table>
</div>