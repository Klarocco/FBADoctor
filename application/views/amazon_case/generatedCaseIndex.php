<style>
    .textbox
    {
        color: #ccc;
        width: 200px;
        padding: 6px 15px 6px 35px;
        border-radius: 20px;
        box-shadow: 0 1px 0 #ccc inset;
        transition:500ms all ease;
    }
    .textbox:hover
    {
        width:220px;
    }



    @media only screen and (max-width:450px){
        .textbox{color: black; width: 150px; padding: 6px 15px 6px 35px; border-radius: 20px; box-shadow: 0 1px 0 #ccc inset; transition:500ms all ease; }

        .textbox:hover {
            width:150px; }



</style>

<div class="form-group">
    <?php if($this->session->flashdata('success')){?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success')?><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php }?>
    <?php if($this->session->flashdata('danger')) { ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('danger')?><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php } ?>
    <label id="msg" name="msg" class="msg"></label>
</div>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"><span class="fa fa-dollar"></span> <?php echo lang("ctn_559") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active">Order Reimbursement</a></li>
        <li class="active"><?php echo lang("ctn_559") ?></li>
    </ol><hr>
    <?php if ($this->user->info->admin) : ?>
        <div class="row" id="basicExample">
            <div class="col-md-4">
                <div class="col-md-9">
                    <select class="form-control" name="case_status" id="case_status">
                        <option>Case status change</option>
                        <?php foreach($caseStatus as $casestatus) :  ?>
                            <option value="<?php echo $casestatus->Case_Status_Id; ?>"><?php echo $casestatus->Case_Name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="button" class="btn btn-success" name="add" value="Apply" id="casestatus">
                </div>
                <input type="hidden" value="" id="txtBox" class="text">
             </div>

            <div class="col-md-8" align="center">
                <div class="col-md-3">
                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date">
                </div>

                <div class="col-md-3">
                    <select class="form-control" id="accountId" name="accountId">
                        <option value="">Select Users</option>
                        <?php foreach ($caseRecord as $key=>$record) :?>
                            <option value="<?php echo $record['userInfo']['ID_ACCOUNT'] ?>"><?php echo $record['userInfo']['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="col-md-7">
                        <input type="button" class="btn btn-success" name="add" value="Filter" id="add" onclick="getfilter()">
                    </div>
                </div>
            </div>
        </div>
        <br>
    <?php else: ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" onchange="getfilter()" id="days" name="days">
                        <option value="">Select Days</option>
                        <option value="1">5 Days</option>
                        <option value="2">10 Days</option>
                        <option value="3">15 Days</option>
                        <option value="4">20 Days</option>
                        <option value="5">25 Days</option>
                        <option value="6">30 Days</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    <?php endif; ?><br>
    <iframe id="my_iframe" style="display:none;"></iframe>
   <br>
    <div id="first">
        <table class="display responsive" width="100%" id="pend_table">
            <thead class="table-header">
                <tr>
                    <?php if ($this->user->info->admin) : ?>
                        <td><input name="select_all" value="1" id="selectall" type="checkbox"></td>
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
                            <?php if(isset($case['status']) && $case['status'] != 6): ?>
                                <td><div id="checkboxes"><input id="caseStatusChange" type="checkbox" value="<?php echo $case['order_id'];?>" class="caseStatusChange" name="<?php echo $case['Case_Type'];?>"></div></td>
                            <?php else : ?>
                                <td></td>
                            <?php endif; ?>

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
                            <td> <?php if(isset($case['status']) && $case['status'] != 6): ?>
                                <a href="#" class="case" data-toggle="modal"id="<?php echo $case['id']; ?>" data-target="#myModal">Edit</a> | <?php endif; ?> <a href="<?php echo site_url('Amazon_case/remove_user/' . $case['id']); ?>" class="delete" id="delete<?php echo $case['id']; ?>">Delete</a> | <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $case['id'];?>" data-target="#myModal_detail">Case Detail</a><br>
                             </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <?php foreach ($caseRecord['caseDetails'] as $key=>$case ) :?>
                    <tr>
                        <td>
                            <div class="col-md-12">
                                <p class="col-md-12"><strong>Product Name :</strong><!-- <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $case['id'];?>" data-target="#myModal_detail"> </a> --><?php echo $case['productname']; ?></p>
                                <div class="col-md-12">
                                    <p class="col-md-6" style="align-content: right"><strong>Case Type :</strong> <?php echo $case['case_type']; ?></p><br>
                                    <p class="col-md-6" style="margin-right:120px; align-content: right"><strong>OrderId :</strong> <?php echo $case['order_id']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $case['case_id'] ?>"><?php echo $case['case_id']; ?></a></td>
                        <td><?php echo date('m/d/Y', strtotime($case['date'])); ?></td>
                        <td id="change_status<?php echo $case['id'];?>"><?php if(isset($case['status']) && $case['status'] == 0) echo '<p style="color:#3c8dbc;">TO DO</p>'; ?><?php if(isset($case['status']) && $case['status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($case['status']) && $case['status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($case['status']) && $case['status'] == 3) echo '<p style="color:#3c8dbc;">Denied</p>'; ?><?php if(isset($case['status']) && $case['status'] == 5) echo '<p style="color:#3c8dbc;">Verification</p>'; ?><?php if(isset($case['status']) && $case['status'] == 6) echo '<p style="color:#3c8dbc;">Case Closed</p>'; ?></td>
                        <td><?php if (!empty($case['amount'])) {echo "$". abs($case['amount']);} ?></td>
                        <td><?php if (!empty($case['amount_total'])) {echo "$". $case['amount_total'];} ?></td>
                        <td><a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $case['id'];?>" data-target="#myModal_detail">Case Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
    </div>
</div>
<!-- Start use to open popup in edit record -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style=" background:  #e1fce8;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b><?php echo lang("ctn_613") ?></b></h4>
            </div>
            <div class="modal-body">
                <?php echo form_open(site_url("Amazon_case/updateCaseId"), array("class" => "form-horizontal", "id" => "update_case_form")) ?>
                <input type="hidden" name="logId" id="logId" value="">
                <div class="form-group">
                    <label for="case__Id" class="col-md-3 label-heading">Case Id</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control textbox" id="case__Id" name="case__Id" value="" required style="color: #0F192A">
                    </div>
                </div>
                <div class="form-group">
                    <label for="date" class="col-md-3 label-heading">Submission Date</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control textbox" id="caseDate" name="caseDate" value="" required style="color: #0F192A">
                    </div>
                </div>

               <div class="form-group">
                    <label for="date" class="col-md-3 label-heading">Case Status</label>
                    <div class="col-md-5">
                        <select class="form-control" name="case_status_detail" id="case_status_detail">
                            <option value="">Case status change</option>
                            <?php foreach($caseStatus as $casestatus) :  ?>
                                <option id="<?php echo $casestatus->Case_Status_Id; ?>" value="<?php echo $casestatus->Case_Status_Id; ?>"><?php echo $casestatus->Case_Name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div id="amazonDeniedReason">
                    <label for="date" class="col-md-3 label-heading">Add Note</label>
                    <div class="col-md-5">
                        <textarea class="form-control textbox" id="amazon" name="amazon" value="" required style="color: #0F192A"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer text-center" style="margin-top: 60px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:350px"><?php echo lang("ctn_60") ?></button>
                <div class="col-md-3"><input type="submit" name="update" id="update" class="btn btn-success form-control" value="Update"/></div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- End popup open block -->

<!-- user detail -->
<div class="modal fade" id="myModal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-right: 15px; margin-top:20px;">&times;</button>
                        <h3 align="center">Generated order reimbursement</h3><br>

                        <h4><b><div class="col-sm-3">Case Type :</div></b><b><div class="col-sm-3" id="case_type_head" ></div></b></h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><b><div class="col-sm-3">Product name :</div></b><div class="col-sm-9" id="product_name"></div></h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <hr>

            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12" >

                        <table class="table table-responsive">
                            <tr class="success">
                                <th style="width:200px;">FILED ON  </th>
                                <th style="width:200px;">POTENTIAL VALUE </th>
                                <th style="width:200px;">ACTUAL VALUE  </th>
                            </tr>
                            <tr>
                                <td><div id="date1"></div></td>
                                <td><div id="potential_value"></div></td>
                                <td><div id="actual_value"></div></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr><td>&nbsp;&nbsp;</td></tr>
                            <tr class="success">
                                <th>CLAIM TYPE  </th>
                                <th>QUANTITY CLAIMED  </th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><div id="case_type"></div></td>
                                <td>1</td>
                                <td></td>
                            </tr>
                            <tr><td>&nbsp;&nbsp;</td></tr>
                            <tr class="success">
                                <th>AMAZON CASE ID </th>
                                <th>AMAZON STATUS  </th>
                                <th>STATUS </th>
                            </tr>
                            <tr>
                                <td><div id="case_id1"></div></td>
                                <td><div id="amz_status"></div></td>
                                <td><div id="status1"></div></td>
                            </tr>
                            <tr><td>&nbsp;&nbsp;</td></tr>

                        </table>

                        <div id="amazonDeniedstatus">
                            <label>Amazon Denied Case Reason</label>
                            <div class="addReason">
                             </div>
                        </div>

                    </div> &nbsp; &nbsp;
                    <div class="row" align="right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:50px; margin-bottom: 20px;"><?php echo lang("ctn_60") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url() . "styles/datepicker.css"; ?>">
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . "scripts/datePicker.js"; ?>"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>

    $("document").ready(function()
    {
        $("#update_case_form").validate(
        {
            rules :
            {
                case__Id : "required",
                caseDate : "required",
                amazonDeniedReason : "required",
                case_status_detail : "required"

            },
            messages :
            {
                case__Id : "Please Enter Case Id.",
                caseDate : "Please Select Case Date",
                amazonDeniedReason : "Please Enter Note",
                case_status_detail : "PLease select user status"
            }
        });
    });

    $('#exportCsv').on('click',function(){
        var baseURL = '<?php echo site_url() . 'Amazon_case/exportCsv' ?>';
        $.ajax({
            type:"GET",
            url:baseURL,
            success: function(result) {
                Download(result);
            }
        });
    });
    function Download(result) {
        document.getElementById('my_iframe').src = result;
    };

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

                var reason = detail.Reason;
                if(reason == null)
                {
                    $('.addReason').text('');
                }
                else
                {
                    $('.addReason').text(reason);
                }

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
                //return false;
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
                $('#logId').val(data.order_id);
                $('#case__Id').val(data.case_id);
                var date = data.date.split(' ')[0];
                $('#caseDate').val(date);
                $('#amazon').val(data.Reason);

                $('#case_status_detail').val(data.status);

                if(data.status == 3)
                {
                    $('#amazonDeniedReason').show();
                }
                else
                {
                    $('#amazonDeniedReason').hide();
                }

                return false;
            }
        });
    });
    $('#update').click(function (e)
    {
        if (jQuery("#update_case_form").valid())
        {
            var caseStatusUpdate = $('#case_status_detail').val();

            if(caseStatusUpdate == 0)
            {
                e.preventDefault();
                swal({
                        title: "Confirm",
                        text: "Are you sure you want to remove all case details?",
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
                            window.location.reload(true);
                        }
                    });

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
            else
            {
                var form = $('#update_case_form').serialize();

                var baseURL = '<?php echo site_url() . 'Amazon_case/updateCaseId' ?>';
                $.ajax({
                    type: "POST",
                    url: baseURL,
                    data: {'form': form},
                    success: function (result) {
                        console.log(result);
                        return false;
                    }
                });
            }

        }
    });

    $('.delete').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
                title: "Confirm",
                text: "Are you sure you want to delete this record?",
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
                   swal("Done!", "Case deleted successfully!", "success");
                    window.location.replace(url);
                }
            });
    });

    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    $('#caseDate').datepicker({
        endDate: new Date(),
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });
    $('#start_date').datepicker({
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });
    $('#end_date').datepicker({
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });
    $(document).ready(function () {
        $("#myBtn").click(function () {
            $('#myModal').modal('show')
        });
        $.noConflict();
        $('#pend_table').DataTable({
            "searching": true,
            "responsive": true
        });
    });
    function getfilter()
    {
        $("#loadingContent").css("display", "block");
        var days = $("#days").val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var accountId = $("#accountId").val();
        var baseURL = '<?php echo site_url() . 'Amazon_case/AjaxgeneratedCase' ?>';

        $.ajax
        ({
            type: "POST",
            url: baseURL,
            data: {'days': days,'start_date': start_date,'end_date': end_date,'accountId': accountId},
            success: function (result) {
                $("#loadingContent").css("display", "none");
                $("#first").html(result);
            }
        });
    }

    $("#case_status").change(function () {
        var selectedValue = $(this).val();
        $("#txtBox").val($(this).find("option:selected").attr("value"))
    });

    $(document).ready(function ()
    {
        $('body').on('click', '#selectall', function ()
        {
            if ($(this).hasClass('allChecked'))
            {
                $('input[type="checkbox"]', '#pend_table').prop('checked', false);
            }
            else
            {
                $('input[type="checkbox"]', '#pend_table').prop('checked', true);
            }
            $(this).toggleClass('allChecked');
        })
    });

    $(document).ready(function ()
    {
        $("#casestatus").click(function()
        {
            caseStatusChange();
        });
    });

    function caseStatusChange()
    {
        var chkArray = [];
        $(".caseStatusChange:checked").each(function () {
            chkArray.push($(this).val());
        });
        var selected = chkArray.join(',');
        var txtBox = $('#txtBox').val();
        if (selected.length == 0)
        {
            $('#msg').html("<div class='alert alert-danger' style='margin-left: 20px; width:1200px'>Please Select At least One checkbox.</div>");
        }
        else if(txtBox.length == 0)
        {
            $('#msg').html("<div class='alert alert-danger' style='margin-left: 20px; width:1200px'>Please Select case status.</div>");
        }

        else if(txtBox == 0)
        {
            var baseURL = '<?php echo site_url() . 'Amazon_case/updateCaseStatusUpdate' ?>';
            $.ajax
            ({
                type: "POST",
                url: baseURL,
                data: {'selected': selected, 'txtbox': txtBox},
                success: function (result) {
                    return true;
                }
            });

            swal({
                    title: "Confirm",
                    text: "Are you sure you want to remove all case details?",
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
                        window.location.reload(true);
                    }
                });
        }
        else
        {
            var baseURL = '<?php echo site_url() . 'Amazon_case/updateCaseStatusUpdate' ?>';
            $.ajax
            ({
                type: "POST",
                url: baseURL,
                data: {'selected': selected, 'txtbox': txtBox},
                success: function (result) {
                    setTimeout(function () {
                        window.location.reload();
                        return true;
                    }, 1000);
                }
            });
        }
    }

    $(function ()
    {
        $('#case_status_detail').change(function ()
        {
            $('#amazonDeniedReason').hide();
            if (this.options[this.selectedIndex].value == '3')
            {
                $('#amazonDeniedReason').show();
            }
        });
    });

</script>
