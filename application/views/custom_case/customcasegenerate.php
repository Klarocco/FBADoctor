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
        <div class="page-header-title"><span class="fa fa-dollar"></span> <?php echo lang("ctn_625") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_623") ?></li>
        <li class="active"><?php echo lang("ctn_625") ?></li>
    </ol><hr>
    <?php if ($this->user->info->admin) : ?>
        <div class="row" id="basicExample">
            <div class="col-md-4">
                <div class="col-md-9">
                    <select class="form-control" name="case_status" id="case_status">
                        <option>Case status change</option>
                        <option value="1" >Pending</option>
                        <option value="3">Denied</option>
                        <option value="4">Approved</option>
                        <option value="5">Verification</option>
                        <option value="6">Case CLosed</option>
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
                        <?php foreach ($username as $key=>$record) :?>
                            <option value="<?php echo $record['ID_ACCOUNT'] ?>"><?php echo $record['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="col-md-7">
                        <input type="button" class="btn btn-success" name="add" value="Filter" id="add">
                    </div>
                </div>
            </div>
        </div>
        <br>
     <?php else: ?>
        <div class="row">
            <div class="col-md-12" align="center">
                <div class="col-md-3">
                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date">
                </div>
                <div class="col-md-3">
                    <input type="button" class="btn btn-success" name="add" value="Filter" id="add">
                </div>
            </div>
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
                <td>Case Id</td>
                <td>Case Description</td>
                <td>Date</td>
                <td>Status</td>
                <!--<td>Case Type</td> -->
                <td>Actual Amount</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>

            <?php if ($this->user->info->admin) : ?>
                <?php if(!empty($customcaselist)) : ?>
                <?php foreach($customcaselist as $record) : ?>
                    <tr>
                        <?php if(isset($record['case_status']) && $record['case_status'] != 6): ?>
                            <td><div id="checkboxes"><input id="caseStatusChange" type="checkbox" value="<?php echo $record['id'];?>" class="caseStatusChange" name="caseStatusChange"></div></td>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>
                        <td><?php echo $record['username']; ?></td>
                        <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $record['caseId'] ?>"><?php echo $record['caseId']; ?></a></td>
                        <td><?php echo $record['message']; ?></td>
                        <td><?php echo date('Y-m-d',strtotime($record['custom_date'])); ?></td>
                        <td><?php if(isset($record['case_status']) && $record['case_status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($record['custom_status']) && $record['case_status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 3) echo '<p style="color:deepskyblue;">Denied</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 4) echo '<p style="color:deepskyblue;">Approved</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 5) echo '<p style="color:deepskyblue;">Verification</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 6) echo '<p style="color:deepskyblue;">Case close</p>'; ?></td>
                        <!--<td><?php //echo $record['custom_case_type']; ?></td> -->
                        <td><?php if($record['amount'] == '') { echo ''; } else { echo "$".$record['amount']; }  ?></td>
                        <td><?php if(isset($record['case_status']) && $record['case_status'] != 6): ?>
                            <a href="#" class="case" data-toggle="modal"id="<?php echo $record['custom_id']; ?>" data-target="#myModal">Edit</a> | <?php endif; ?> <a href="<?php echo site_url('Custom_case/remove_custom_case/' . $record['custom_id']); ?>" class="delete" id="delete<?php echo $record['custom_id']; ?>">Delete</a> |  <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $record['custom_id'];?>" data-target="#myModal_detail">Case Detail</a><br>
                         </td>
                    </tr>
                <?php endforeach; ?>
                    <?php endif; ?>
            <?php else : ?>
            <?php if(!empty($customcaselist)) : ?>
                <?php foreach($customcaselist as $record) : ?>
                    <tr>
                        <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $record['caseId'] ?>"><?php echo $record['caseId']; ?></a></td>
                        <td><?php echo $record['message']; ?></td>
                        <td><?php echo date('Y-m-d',strtotime($record['createdAt'])); ?></td>
                        <td><?php if(isset($record['status']) && $record['status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($record['status']) && $record['status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($record['status']) && $record['status'] == 3) echo '<p style="color:deepskyblue;">Denied</p>'; ?><?php if(isset($record['status']) && $record['status'] == 4) echo '<p style="color:deepskyblue;">Approved</p>'; ?><?php if(isset($record['status']) && $record['status'] == 5) echo '<p style="color:deepskyblue;">Verification</p>'; ?><?php if(isset($record['status']) && $record['status'] == 6) echo '<p style="color:deepskyblue;">Case close</p>'; ?></td>
                        <td><?php echo $record['custom_case_type']; ?></td>
                        <td><?php if($record['amount_total'] == '') { echo ''; } else { echo "$". $record['amount_total']; }  ?></td>
                        <td><a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $record['id'];?>" data-target="#myModal_detail">Case Detail</a></td>
                    </tr>
                <?php endforeach; ?>
                <?php endif;?>
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
                <?php echo form_open(site_url("custom_case/updateCustomCase"), array("class" => "form-horizontal", "id" => "update_case_form")) ?>
                <input type="hidden" name="id" id="id" value="">
                <div class="form-group">
                    <label for="case_Id" class="col-md-3 label-heading">Case Id</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control textbox" id="case_Id" name="case_Id" value="" required style="color: #0F192A">
                    </div>
                </div>
                <div class="form-group">
                    <label for="date" class="col-md-3 label-heading">Submission Date</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control textbox" id="caseDate" name="caseDate" value="" required style="color: #0F192A">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="col-md-3 label-heading">Custom case Status</label>
                    <div class="col-md-5">
                        <select class="form-control" name="case_status_detail" id="case_status_detail">
                                <option value="">Case status change</option>
                                <option value="1" >Pending</option>
                                <option value="3" >Denied</option>
                                <option value="4" >Approved</option>
                                <option value="5" >Verification</option>
                                <option value="6" >Case CLosed</option>
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
            <div class="modal-footer text-center" style="margin-top: 50px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:350px"><?php echo lang("ctn_60") ?></button>
                <div class="col-md-3"><input type="submit" name="update" id="update" class="btn btn-success form-control" value="Update"/></div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<!-- End popup open block -->

<!-- case detail display -->
<div class="modal fade" id="myModal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-sm-12">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-right: 15px; margin-top:20px;">&times;</button>
                        <h3 align="center">Custom case detail</h3><br>
                       <!-- <h4><b><div class="col-sm-3">Case Type :</div></b><b><div class="col-sm-3" id="case_type_head" ></div></b></h4> -->
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
                                <th style="width:200px;">AMAZON CASE ID </th>
                                <th style="width:200px;">ACTUAL VALUE  </th>
                            </tr>
                            <tr>
                                <td><div id="date"></div></td>
                                <td><div id="case_id"></div></td>
                                <td><div id="actual_value"></div></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr><td>&nbsp;&nbsp;</td></tr>
                            <tr class="success">
                                <th>AMAZON STATUS </th>
                                <th>&nbsp;  </th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><div id="amz_status"></div></td>
                                <td><div id="case_type"></div></td>
                                <td></td>
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
<!-- end case detail popup -->

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
                        case_Id : "required",
                        caseDate : "required",
                        amazonDeniedReason : "required",
                        case_status_detail : "required"

                    },
                messages :
                    {
                        case_Id : "Please Enter Case Id.",
                        caseDate : "Please Select Case Date",
                        amazonDeniedReason : "Please enter note",
                        case_status_detail : "Please select case status"
                    }
            });
    });

    $('.case').on('click', function (e) {
        var id = $(this).attr('id');
        var baseURL = '<?php echo site_url() . 'Custom_case/editCustomCaseDetail/' ?>' + id;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result)
            {
                var data = $.parseJSON(result);
                $('#id').val(data.id);
                $('#case_Id').val(data.caseId);
                var date = data.createdAt.split(' ')[0];
                $('#caseDate').val(date);
                $('#case_status_detail').val(data.status);
                //$('#amazon').val(data.custom_reason);

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
            var form = $('#update_case_form').serialize();
            var baseURL = '<?php echo site_url() . 'custom_case/updateCustomCase' ?>';
            $.ajax
            ({
                type: "POST",
                url: baseURL,
                data: {'form': form},
                success: function (result)
                {
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
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });
    $('#end_date').datepicker({
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    $(document).ready(function ()
    {
        $("#myBtn").click(function ()
        {
            $('#myModal').modal('show')
        });
        $.noConflict();
        $('#pend_table').DataTable({
            "searching": true,
            "responsive": true
        });
    });

    $('.user_detail').on('click',function(e){
        var id = $(this).attr('id');
        var baseURL = '<?php echo site_url() . 'custom_case/customecasedetail/' ?>'+id;
        $.ajax({
            type:"GET",
            url:baseURL,
            success: function(result)
            {
                var detail = jQuery.parseJSON(result);
                var date = detail.custom_date.split(' ')[0];

                $('#date').text(date);
                //$('#case_type').text(detail.custom_case_type);
                //$('#case_type_head').text(detail.custom_case_type);
                $('#case_id').text(detail.caseId);

                var actual_value = detail.amount;
                var actual_amount = Math.abs(actual_value);
                var dollar_potential = ('$');
                if(actual_value == null)
                {
                    $('#actual_value').text(' - ');
                }
                else
                {
                    $('#actual_value').text(dollar_potential + actual_amount);
                }

                var amz_status = detail.case_status;
                if(amz_status == 1)
                    $('#amz_status').text('Pending');
                if(amz_status == 2)
                    $('#amz_status').text('success');
                if(amz_status == 3)
                    $('#amz_status').text('denied');
                if(amz_status == 4)
                    $('#amz_status').text('Approved');
                if(amz_status == 5)
                    $('#amz_status').text('Verification');
                if(amz_status == 6)
                    $('#amz_status').text('Case Closed');


                var reason = detail.reason;
                if(reason == null)
                {
                    $('.addReason').text('');
                }
                else
                {
                    $('.addReason').text(reason);
                }

                if(detail.case_status == 3)
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


    $('#add').on('click',function()
    {
        $("#loadingContent").css("display", "block");
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var account_id = $("#accountId").val();

        var baseURL = '<?php echo site_url() . 'Custom_case/AjaxUserData' ?>';

        $.ajax
        ({
            type: "POST",
            url: baseURL,
            data: {'start_date': start_date, 'end_date': end_date, 'account_id': account_id},
            success: function (result) {
                $("#loadingContent").css("display", "none");
                $("#first").html(result);
            }
        });

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

    $("#case_status").change(function () {
        var selectedValue = $(this).val();
        $("#txtBox").val($(this).find("option:selected").attr("value"))
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
        else if (txtBox.length == 0)
        {
            $('#msg').html("<div class='alert alert-danger' style='margin-left: 20px; width:1200px'>Please Select case status.</div>");
        }
        else
        {
            var baseURL = '<?php echo site_url() . 'custom_case/CustomCaseStatusUpdate' ?>';

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