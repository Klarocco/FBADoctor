<!--CREATED DATE: 02/06/2017-->
<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <i class="fa fa-history" aria-hidden="true"></i> Affiliate List</div>
        <?php if(empty($this->user->info->admin)) :?>
            <div class="db-header-extra"> <a href="<?php echo base_url().'affiliate/AffiliateInviteFriend' ?>" class="btn btn-success btn-sm">Invite User</a></div>
        <?php endif; ?>
         </div>
    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span></div>
        <?php } unset($_SESSION['errors']); ?>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active">Affiliate List</li>
    </ol>
    <hr>
    <div id="first">
        <table class="display responsive" width="100%" id="pend_table">
            <thead class="table-header">
            <tr>
                <td>User Name</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email Address</td>
                <td>Commission</td>
            </tr>
            </thead>
            <?php foreach($userwisedata as $record) :?>
                <tr>
                    <td><?php echo $record['username']?></td>
                    <td><?php echo $record['first_name']?></td>
                    <td><?php echo $record['last_name']?></td>
                    <td><?php echo $record['email']?></td>
                    <td><?php echo "$ ".$record['commission_total']?></td>
                </tr>
            <?php endforeach;?>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.noConflict();
        $('#pend_table').DataTable({
            "searching": true,
            "responsive": true
        });
    });
</script>