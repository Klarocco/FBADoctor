<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-home"></span> <?php echo lang("ctn_526") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_526") ?></li>
    </ol>
    <hr>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo abs($total_reimbursement); ?></h3>
                    <p>Total Reimbursement</p>
                </div>
                <div class="icon" style="margin-top: 25px;">
                    <i class="ion icon ion-social-usd"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php foreach($total_user as $key => $value) {  foreach( $value as $key => $value) { echo $value; }  } ?></h3>
                    <p>Total Active User</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>

    </div>
    <hr>

    <div class="row">
        <div class="col-md-2"></div>
         <div class="col-md-4">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php foreach($total_pending_order_reimbursement as $key => $value) {  foreach( $value as $key => $value) { echo $value; }  } ?></h3>
                    <p>Total Pending Cases Order Reimbursement</p>
                </div>
                <div class="icon" style="margin-top: 10px;">
                    <i class="icon ion-ios-drag"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php foreach($total_user_order_reimbursement as $key => $value) {  foreach( $value as $key => $value) { echo $value; }  } ?></h3>
                    <p>Total Cases Order Reimbursement</p>
                </div>
                <div class="icon" style="margin-top: 10px;">
                    <i class="icon ion-ios-drag"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>

       <!-- <div class="col-md-4">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php foreach($total_user_inventory_pending_reimbursement as $key => $value) {  foreach( $value as $key => $value) { echo $value; }  } ?></h3>
                    <p>Total Pending Cases Inventory Reimbursement</p>
                </div>
                <div class="icon" style="margin-top: 10px;">
                    <i class="icon ion-android-menu"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php foreach($total_user_inventory_reimbursement as $key => $value) {  foreach( $value as $key => $value) { echo $value; }  } ?></h3>
                    <p>Total Cases Inventory Reimbursement</p>
                </div>
                <div class="icon" style="margin-top: 10px;">
                    <i class="icon ion-android-menu"></i>
                </div>
                <a href="#" class="small-box-footer"></a>
            </div>
        </div> -->
    </div>

</div>
<script>
    $(document).ready(function(){
        $('#caseSummeryToggle').click(function(){
            if($(this).find('i').hasClass("fa-plus")){
                $('#caseSummeryTableBody').show();
            }
            else{
                $('#caseSummeryTableBody').hide();
            }
            $(this).find('i').toggleClass('fa-plus fa-minus')
        });
        $('#caseRefundGuardianToggle').click(function(){
            if($(this).find('i').hasClass("fa-plus")){
                $('#caseRefundGuardianTableBody').show();
            }
            else{
                $('#caseRefundGuardianTableBody').hide();
            }
            $(this).find('i').toggleClass('fa-plus fa-minus')
        });
        $('#caseInventoryProtectorToggle').click(function(){
            if($(this).find('i').hasClass("fa-plus")){
                $('#caseInventoryProtectorTableBody').show();
            }
            else{
                $('#caseInventoryProtectorTableBody').hide();
            }
            $(this).find('i').toggleClass('fa-plus fa-minus')
        });
    });
</script>