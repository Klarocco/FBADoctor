<div id="first">
    <table class="table table-bordered dt-responsive" width="100%" id="pend_table">
        <thead class="table-header">
            <tr>
                <?php if ($this->user->info->admin) : ?>
                    <td><?php echo lang("ctn_25") ?></td>
                <?php endif; ?>
                <td>Reimbursement Claim Details</td>
                <td>Date</td>
                <td>Status</td>
                <td>Case ID</td>
                <td style="word-wrap: break-word"><?php echo lang("ctn_590") ?></td>
                <td><?php echo lang("ctn_592") ?></td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
             <?php if ($this->user->info->admin) : ?>
                <?php foreach ($caseRecord as $record):?>
                    <?php foreach ($record['case'] as $caseDetials):  ?>
                         <tr>
                            <td><?php echo $record['user']['username'];?></td>
                            <td>
                                <div class="col-md-12">
                                    <p class="col-md-12"><strong>Product Name :</strong><a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $caseDetials['id'];?>" data-target="#myModal_detail"> <?php echo $caseDetials['productname']; ?></a></p>
                                    <div class="col-md-12" style="padding: 0px;">
                                        <p class="col-md-12"><strong>Reimbursement ID : </strong><?php echo $caseDetials['reimburse_id'] ?></p>
                                        <p class="col-md-12"><strong>FNSKU : </strong><?php echo $caseDetials['fnsku'] ?></p>
                                        <p class="col-md-12"><strong>Transaction Item Id : </strong> <?php echo $caseDetials['transaction_item_id'] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo date('m/d/Y', strtotime($caseDetials['date'])); ?></td>
                            <td id="change_status<?php echo $caseDetials['id'];?>" ><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 0) echo '<p style="color:#3c8dbc;">To Do</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 3) echo '<p style="color:#3c8dbc;">Denied</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 5) echo '<p style="color:green;">Verification</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 6) echo '<p style="color:green;">Case Closed</p>'; ?></td>
                            <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $caseDetials['caseId'] ?>"><?php echo $caseDetials['caseId'] ?></a></td>
                            <td><?php echo $caseDetials['quantity'] ?></td>
                            <td><?php echo (!empty($caseDetials['amount_total']))? "$".$caseDetials['amount_total'] : '' ; ?></td>
                            <td>
                                <?php if(isset($caseDetials['status']) && $caseDetials['status'] != 6): ?>
                             <a href="#" class="case" data-toggle="modal" id="<?php echo $caseDetials['id']; ?>" data-target="#myModal">Edit </a> | <?php endif; ?> <a href="<?php echo site_url('Inventory_salvager/remove_user/' . $caseDetials['id']); ?>" class="delete" id="delete<?php echo $caseDetials['id']; ?>">Delete</a> | <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $caseDetials['id'];?>" data-target="#myModal_detail">Case Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>

             <?php foreach ($caseRecord['case'] as $key=>$caseDetials):?>
                <tr>
                    <td><?php echo $caseRecord['user']['username']; ?></td>
                    <td style="width:400px;">
                        <div class="col-md-12">
                            <p class="col-md-12"><strong>Product Name :</strong><a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $caseDetials['id'];?>" data-target="#myModal_detail"> <?php echo $caseDetials['productname']; ?></a></p>
                            <div class="col-md-12" style="padding: 0px;">
                                <p class="col-md-12"><strong>Reimbursement ID : </strong><?php echo $caseDetials['reimburse_id'] ?></p>
                                <p class="col-md-12"><strong>FNSKU : </strong><?php echo $caseDetials['fnsku'] ?></p>
                                <p class="col-md-12"><strong>Transaction Item Id : </strong> <?php echo $caseDetials['transaction_item_id'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td><?php echo date('m/d/Y', strtotime($caseDetials['date'])); ?></td>
                    <td><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 0) echo '<p style="color:#3c8dbc;">To Do</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 3) echo '<p style="color:#3c8dbc;">Denied</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 5) echo '<p style="color:green;">Verification</p>'; ?><?php if(isset($caseDetials['status']) && $caseDetials['status'] == 6) echo '<p style="color:green;">Case Closed</p>'; ?></td>
                    <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $caseDetials['caseId'] ?>"><?php echo $caseDetials['caseId'] ?></a></td>
                    <td><?php echo $caseDetials['quantity'] ?></td>
                    <td><?php echo (!empty($caseDetials['amount_total']))? "$".$caseDetials['amount_total'] : '' ; ?></td>
                    <td>
                        <?php if(isset($caseDetials['status']) && $caseDetials['status'] != 6): ?>
                            <a href="#" class="case" data-toggle="modal" id="<?php echo $caseDetials['id']; ?>" data-target="#myModal">Edit </a> | <?php endif; ?> <a href="<?php echo site_url('Inventory_salvager/remove_user/' . $caseDetials['id']); ?>" class="delete" id="delete<?php echo $caseDetials['id']; ?>">Delete</a> | <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $caseDetials['id'];?>" data-target="#myModal_detail">Case Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script language="javascript">
   $("document").ready(function () {
       $('#pend_table').DataTable({
           "searching": true,
           "responsive": true
       });
   });

   $('.user_detail').on('click',function(e){
       var id = $(this).attr('id');
       var baseURL = '<?php echo site_url() . 'Inventory_salvager/user_display_data/' ?>'+id;
       $.ajax({
           type:"GET",
           url:baseURL,
           success: function(result)
           {
               var detail = jQuery.parseJSON(result);
               var date = detail.date.split(' ')[0];
               $('#date').text(date);
               $('#date1').text(date);
               $('#case_id').text(detail.caseId);
               $('#case_id1').text(detail.caseId);
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
               if(case_type_detail == 'ULW' || case_type_detail_heading == 'ULW')
               {
                   $('#case_type_detail').text('Inventory Item Lost');
                   $('#case_type_detail_heading').text('Inventory Item Lost');
               }
               if(case_type_detail == 'UDW' || case_type_detail_heading == 'UDW')
               {
                   $('#case_type_detail').text('warehouse damaged by FBA');
                   $('#case_type_detail_heading').text('warehouse damaged by FBA');
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
               if(status == '4') {
                   $('#status').text('Approved');
                   $('#status1').text('Approved');
                   $('#amz_status').text('Approved');
               }
               if(status == '5') {
                   $('#status').text('Verification');
                   $('#status1').text('Verification');
                   $('#amz_status').text('Verification');
               }
               if(status == '6') {
                   $('#status').text('Case Closed');
                   $('#status1').text('Case Closed');
                   $('#amz_status').text('Case Closed');
               }

               var  potential_value = detail.amount;
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
           }
       });
   });

   $('.case').on('click', function (e) {
       var id = $(this).attr('id');
       var baseURL = '<?php echo site_url() . 'Inventory_salvager/edit_case_account/' ?>' + id;
       $.ajax({
           type: "GET",
           url: baseURL,
           success: function (result) {
               var data = $.parseJSON(result);
               $('#logId').val(data.id);
               $('#case__Id').val(data.caseId);
               var date = data.date.split(' ')[0];
               $('#caseDate').val(date);
               return false;
           }
       });
   });
   $('#update').click(function () {
       if (jQuery("#update_case_form").valid()) {
           var baseURL = '<?php echo site_url() . 'Inventory_salvager/updateCaseId' ?>';
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
</script>
