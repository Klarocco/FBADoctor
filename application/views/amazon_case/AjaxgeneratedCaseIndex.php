<table class="table table-bordered dt-responsive" width="100%" id="pend_table">
    <thead class="table-header">
        <tr>
            <?php if ($this->user->info->admin) : ?>
                <td><?php echo lang("ctn_209") ?></td>
            <?php endif; ?>
            <td>Reimbursement Claim Details</td>
            <td><?php echo lang("ctn_550") ?></td>
            <td>Date</td>
            <td><?php echo lang("ctn_588") ?></td>
            <td>Potential</td>
            <td>Actual</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
    <?php if ($this->user->info->admin) : ?>
        <?php foreach ($caseRecord as $flag => $record) : ?>
            <?php foreach ($record['caseDetails'] as $key=>$case ) :?>
                <tr>
                    <td><?php echo $record['userInfo']['username']; ?></td>
                    <td style="width:400px;">
                        <div class="col-md-12">
                            <p class="col-md-12"><strong>Product Name :</strong><?php echo $case['productname']; ?></p>
                            <div class="col-md-8" style="padding: 0px;">
                                <p class="col-md-12"><strong>Case Type :</strong> <?php echo $case['case_type']; ?></p>
                                <p class="col-md-12"><strong>OrderId :</strong> <?php echo $case['order_id']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $case['case_id'] ?>"><?php echo $case['case_id']; ?></a></td>
                    <td><?php echo date('m/d/Y', strtotime($case['date'])); ?></td>
                    <td id="change_status<?php echo $case['id'];?>"><?php if(isset($case['status']) && $case['status'] == 0) echo '<p style="color:#3c8dbc;">TO DO</p>'; ?><?php if(isset($case['status']) && $case['status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($case['status']) && $case['status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($case['status']) && $case['status'] == 3) echo '<p style="color:#3c8dbc;">Denied</p>'; ?><?php if(isset($case['status']) && $case['status'] == 5) echo '<p style="color:#3c8dbc;">Verification</p>'; ?><?php if(isset($case['status']) && $case['status'] == 6) echo '<p style="color:#3c8dbc;">Case Closed</p>'; ?></td>
                    <td><?php if (!empty($case['amount'])) {echo "$". abs($case['amount']);} ?></td>
                    <td><?php if (!empty($case['amount_total'])) {echo "$". $case['amount_total'];} ?></td>
                    <td><?php if(isset($case['status']) && $case['status'] != 6): ?>
                        <a href="#" class="case" data-toggle="modal"id="<?php echo $case['id']; ?>" data-target="#myModal">Edit</a> | <?php endif; ?> <a href="<?php echo site_url('Amazon_case/remove_user/' . $case['id']); ?>" class="delete" id="delete<?php echo $case['id']; ?>">Delete</a> | <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $case['id'];?>" data-target="#myModal_detail">Case Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php else:?>
        <?php foreach ($caseRecord['caseDetails'] as $key=>$case ) : ?>
            <tr>
                <td>
                    <div class="col-md-12">
                        <p class="col-md-12"><strong>Product Name :</strong> <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $case['id'];?>" data-target="#myModal_detail"> <?php echo $case['productname']; ?></a></p>

                        <div class="col-md-8" style="padding: 0px;">
                            <p class="col-md-12" style="align-content: right"><strong>Case Type :</strong> <?php echo $case['case_type']; ?></p>
                            <p class="col-md-12" style="margin-right:120px; align-content: right"><strong>OrderId :</strong> <?php echo $case['order_id']; ?></p>
                        </div>
                    </div>
                </td>
                <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $case['case_id'] ?>"><?php echo $case['case_id']; ?></a></td>
                <td><?php echo date('m/d/y', strtotime($case['date'])); ?></td>
                <td id="change_status<?php echo $case['id'];?>"><?php if(isset($case['status']) && $case['status'] == 0) echo '<p style="color:#3c8dbc;">TO DO</p>'; ?><?php if(isset($case['status']) && $case['status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($case['status']) && $case['status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($case['status']) && $case['status'] == 3) echo '<p style="color:#3c8dbc;">Denied</p>'; ?><?php if(isset($case['status']) && $case['status'] == 5) echo '<p style="color:#3c8dbc;">Verification</p>'; ?><?php if(isset($case['status']) && $case['status'] == 6) echo '<p style="color:#3c8dbc;">Case Closed</p>'; ?></td>
                <td><?php if (!empty($case['amount'])) {echo "$". abs($case['amount']);} ?></td>
                <td><?php if (!empty($case['amount_total'])) {echo "$". $case['amount_total'];} ?></td>
                <td><a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $case['id'];?>" data-target="#myModal_detail">Case Detail</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<script language="javascript">
    $("document").ready(function () {
        $('#pend_table').DataTable({"searching": true, "responsive": true});
    });

    $('.user_detail').on('click',function(e){
        var id = $(this).attr('id');
        var baseURL = '<?php echo site_url() . 'Amazon_case/user_display_data/' ?>'+id;
        $.ajax({
            type:"GET",
            url:baseURL,
            success: function(result)
            {
                var detail = jQuery.parseJSON(result);
                var date = detail.date.split(' ')[0];
                $('#date').text(date);
                $('#date1').text(date);
                $('#case_id').text(detail.case_id);
                $('#case_id1').text(detail.case_id);
                $('#case_type').text(detail.Case_Type);
                $('#case_type_head').text(detail.Case_Type);


                var product_name = detail.productname;
                if(product_name == null)
                {
                    $('#product_name').text('');
                }
                else
                {
                    $('#product_name').text(product_name);
                }


                var case_type_detail = detail.case_type;
                var case_type_detail_heading = detail.case_type;
                if(case_type_detail == 'ONR' || case_type_detail_heading == 'ONR')
                {
                    $('#case_type_detail').text('Customer Never Returned Item');
                    $('#case_type_detail_heading').text('Customer Never Returned Item');
                }
                if(case_type_detail == 'RDA' || case_type_detail_heading == 'RDA')
                {
                    $('#case_type_detail').text('Reimbursed damaged by amazon');
                    $('#case_type_detail_heading').text('Reimbursed damaged by amazon');
                }
                if(case_type_detail == 'RWF' || case_type_detail_heading == 'RWF')
                {
                    $('#case_type_detail').text('Return with diffrent FNSKU');
                    $('#case_type_detail_heading').text('Return with diffrent FNSKU');
                }
                if(case_type_detail == 'COR' || case_type_detail_heading == 'COR')
                {
                    $('#case_type_detail').text('Customer over refund');
                    $('#case_type_detail_heading').text('Customer over refund');
                }
                var status = detail.status;
                if(status == '0') {
                    $('#status').text('To Do');
                    $('#status1').text('To Do');
                    $('#amz_status').text('To Do');
                }
                if(status == '1') {
                    $('#status').text('Pending');
                    $('#status1').text('Pending');
                    $('#amz_status').text('Pending');
                }
                if(status == '2'){
                    $('#status').text('Reimbursed');
                    $('#status1').text('Reimbursed');
                    $('#amz_status').text('Reimbursed');
                }
                if(status == '3'){
                    $('#status').text('Denied');
                    $('#status1').text('Denied');
                    $('#amz_status').text('Denied');
                }
                if(status == '4'){
                    $('#status').text('Approved');
                    $('#status1').text('Approved');
                    $('#amz_status').text('Approved');
                }
                if(status == '5'){
                    $('#status').text('Verification');
                    $('#status1').text('Verification');
                    $('#amz_status').text('Verification');
                }
                if(status == '6'){
                    $('#status').text('Case Closed');
                    $('#status1').text('Case Closed');
                    $('#amz_status').text('Case Closed');
                }

                var potential_value = detail.amount;
                var potential = Math.abs(potential_value);
                var dollar_potential = ('$');
                if(potential_value == null)
                {
                    $('#potential_value').text('');
                    $('#potential_value_header').text('');
                }
                else
                {
                    $('#potential_value').text(dollar_potential + potential);
                    $('#potential_value_header').text(dollar_potential + potential);
                }

                var actual_value = detail.amount_total;
                var actual = Math.abs(actual_value);
                var dollar_actual = ('$');
                if(actual_value == null)
                {
                    $('#actual_value').text('');
                }
                else
                {
                    $('#actual_value').text(dollar_actual+actual);
                }

                $('.addReason').text(detail.Reason);

                if(detail.status == 3)
                {
                    $('#amazonDeniedstatus').show();
                }
                else
                {
                    $('#amazonDeniedstatus').hide();
                }

                return false;

                /*var images = detail.small_img_url;
                 $('#img_detail').html('<img src="' + images + '" height="50px" width="50px">');*/
                return false;
            }
        });
    });

    $('.case').on('click', function (e) {
        var id = $(this).attr('id');
        var baseURL = '<?php echo site_url() . 'Amazon_case/edit_case_account/' ?>' + id;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result) {
                var data = $.parseJSON(result);
                $('#logId').val(data.id);
                $('#case__Id').val(data.case_id);
                var date = data.date.split(' ')[0];
                $('#caseDate').val(date);
                return false;
            }
        });
    });
    $('#update').click(function () {
        if (jQuery("#update_case_form").valid()) {
            var baseURL = '<?php echo site_url() . 'Amazon_case/updateCaseId' ?>';
            $.ajax({
                type: "POST",
                url: baseURL,
                data: $('#update_case_form').serialize(),
                success: function (result) {
                    console.log(result);
                    return false;
                }
            });
        }
    });
    $('.delete').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
                title: "Confirm",
                text: "Are you sure you want to perform this action?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'YES',
                cancelButtonText: "NO",
                confirmButtonClass: "btn-danger",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
//                    swal("Done!", "Case deleted successfully!", "success");
                    window.location.replace(url);
                }
            });
    });
    $(document).on("click", ".caseclosed", function(e){
        var id = $(this).val();

        var flag = '';
        if($(this).prop("checked") == true){
            flag = 3;
        }
        else if($(this).prop("checked") == false){
            flag = 1;
        }
        var baseURL = '<?php echo site_url() . 'amazon_case/casestatus/' ?>'+id+"/"+flag;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result) {
                if (result==1) {
                    if(flag==3)
                        $("#change_status"+id).html('<p style="color:#3c8dbc;">Closed</p>');
                    if(flag==1)
                        $("#change_status"+id).html('<p style="color:red">Pending</p>');
                    return false;
                }
            }
        });
    });
</script>