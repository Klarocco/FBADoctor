<style>
    @media screen and (max-width: 400px)
    {
        table tr
        {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
        table td
        {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .9em;
            text-align: left;
        }
    }
</style>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title">
            <i class="fa fa-user" aria-hidden="true"></i> <?php echo lang("ctn_621") ?>
        </div>
    </div>

    <div class="row">
        <h3 align="center">Inventory Reimbursement User Detail</h3>
    </div><br>

    <div class="row" style="margin:15px;">
        <?php echo form_open('Inventory_salvager/generateCasesByIdAndType', array("class" => "form-horizontal", "id" => "addCase_Id")); ?>
        <div class="col-md-10">
            <div class="form-group">
                <label for="case__Id" class="col-md-2 label-heading">Case Id</label>
                <div class="col-md-10">
                    <input type="text" class="form-control textbox" id="case__Id" name="case__Id" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label for="date" class="col-md-2 label-heading">Submission Date</label>
                <div class="col-md-10">
                    <input type="date" class="form-control textbox" id="caseDate" name="caseDate" value="" required>
                </div>
            </div>
         </div>

         <div class="form-group hidden">
            <div class="hiddenOrder">
                <input type="hidden" value="" id="totalOrders" name="totalOrders"/>
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">
                <div class="col-md-2">
                    <strong><?php echo lang("ctn_603") ?></strong>
                </div>
                <div class="col-md-10"><?php echo $emailAddress; ?></div>
                <div class="col-md-2">
                    <strong><?php echo lang("ctn_604") ?></strong>
                </div>
                <div class="col-md-10"><?php echo $pass; ?></div>
            </div>
         </div>
    </div>

    <hr>
    <div>
        <p align="left" style="margin:30px;"><b>
            Please Select Orders From Following #
                <table id="example" class="display responsive" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>No Of Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($caseDetails as $key => $value)
                        {
                             $UrlDetails = $value['startDate'] . '/' . $value['endDate'] . '/' . $value['accountId'] . '/' . $value['type'];
                    ?>
                        <tr>
                            <td>
                                <div class="material-switch" style="margin-left:30px; margin:15px; margin-bottom: 30px;">
                                    <input id="<?php echo $UrlDetails; ?>" type="checkbox"
                                           value="<?php echo $UrlDetails; ?>" class="checkbox" name="checkbox">&nbsp;
                                    <label for="<?php echo $UrlDetails; ?>" class="label-success"></label>
                                    <div style="margin-top:-20px; margin-left:70px;"></div>
                                </div>
                            </td>
                            <td><?php echo $value['startDate']; ?></td>
                            <td><?php echo $value['endDate']; ?></td>
                            <td><?php echo $value['quantity']; ?></td>
                            <td></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table><br>
            <hr>
            <div id="msg" align="left" style="margin:30px;"> <label>Good Day.</label><br><br>
                <label id="msg_top"><?php echo $msg_top; ?></label><br><br>
                <div>
                    <div class='col-md-12'>
                        <div class="col-md-2">
                            <label value="Select Id" class="col-md-2 label-heading">&nbsp</label>
                        </div>
                        <div class='col-md-10' id="0">
                            <label value="Start Date" class="col-md-2 label-heading">&nbsp;Start Date</label>
                            <label value="End Date" class="col-md-2 label-heading">&nbsp;End Date</label>
                            <label value="Fnsku" class="col-md-2 label-heading">&nbsp;Fnsku</label>
                            <label value="Quantity" class="col-md-2 label-heading">&nbsp;Quant'</label>
                            <label value="Reason" class="col-md-2 label-heading">&nbsp;Reason</label>
                        </div>
                    </div>
                    <div id="selected_items""></div>
                    <div id="selectedValues"></div>
                 </div><br><br>
                 <label>Thanks you.</label></b>
            </div>
       </p>
    </div>

    <div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
    <div class="modal-footer">
        <input type="hidden" value="" name="subTotal" id="subTotal">
        <input type="hidden" value="<?php echo $accountId; ?>" name="account_ID" id="account_ID">
        <input type="hidden" value="" name="type_case" id="type_case">
        <a href="#" class="button btn btn-success" id="copy-button" data-clipboard-target="#msg" style="margin:10px;">Copy Message</a>
        <a href="<?php echo site_url() . 'inventory_salvager/index' ?>" class="btn btn-success"><?php echo lang('ctn_135') ?></a>
        <input type="button" class="btn btn-success" value="<?php echo lang("ctn_61") ?>" id="addCaseId" />
        <?php echo form_close() ?>
    </div>

<link rel="stylesheet" href="<?php echo base_url() . "styles/datepicker.css"; ?>">
<script type="text/javascript" src="<?php echo base_url() . "scripts/datePicker.js"; ?>"></script>
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    $("document").ready(function()
    {
        $("#addCase_Id").validate(
            {
                rules :
                    {
                        case__Id : "required",
                        caseDate : "required"
                    },
                messages :
                    {
                        case__Id : "Please Enter Case Id.",
                        caseDate : "Please Select Case Date"
                    }
            });
    });

    (function()
    {
        new Clipboard('#copy-button');
    })();

    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    $('#caseDate').datepicker({
        endDate: new Date(),
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    $(document).ready(function()
    {
            var myCheckboxes = new Array();
            $("input:checked").each(function() {
                myCheckboxes.push($(this).val());
            });
            if(myCheckboxes.length==0){
                $('#noSelect').append("<li><div class='col-md-12'>No Data Selected.</div></li>");
            }
            $('#subTotal').val(0);
            $('[data-dismiss=modal]').on('click', function (e) {
                $("#selected_items").html('');
            });
    });


    $(document).on("click", ".checkbox", function()
    {
        var data = $(this).attr('id');

        if ($(this).is(':checked'))
        {
            var baseURL = "<?php echo site_url() . "Inventory_salvager/getFnskU/" ?>" +data;
            $.ajax
            ({
                type: "GET",
                url: baseURL,
                success: function (result) {
                    console.log(result);
                    var subTotal = parseInt($('#subTotal').val());
                    if(result){
                        $('#noSelect').remove();
                        var data = $.parseJSON(result);
                        var count=0;
                        var temp ='';
                        var selectedValue = '';
                        subTotal +=1;
                        for(count; count<data.length;count++)
                        {
                            temp += "<div class='col-md-2'><label value='Select Id' class='col-md-2 label-heading'><input type='checkbox' name='select' id='select"+subTotal+"'>"+ '' +"</label></div><div class='col-md-10'><label value='Start Date' class='col-md-2 label-heading'>&nbsp;"+data[count]['report_start_date']+"</label><label value='End Date' class='col-md-2 label-heading'>&nbsp;"+data[count]['report_end_date']+"</label><label value='Fnsku' class='col-md-2 label-heading'>&nbsp;"+data[count]['fnsku']+"</label><label value='Quantity' class='col-md-2 label-heading'>&nbsp;&nbsp;&nbsp;&nbsp;"+data[count]['quantity_fnsku']+"</label><label value='Reason' class='col-md-2 label-heading'>&nbsp;"+((data[count]['case_type']=='UDW')?'DAMAGE':'DISPOSE')+"</label></div><br><div class='col-md-2'></div><div class='col-md-10'><label value='Insert LOST' class='col-md-10 label-heading'>&nbsp;INSERT LOST REPORT HERE</label></div><br><div class='col-md-2'></div><div class='col-md-10'><label value='Insert FOUND REPORT' class='col-md-10 label-heading'>&nbsp;INSERT FOUND REPORT HERE</label></div><br><div class='col-md-2'></div><div class='col-md-10'><label value='Insert REIMBURSEMENT REPORT HERE' class='col-md-10 label-heading'>&nbsp;INSERT REIMBURSEMENT REPORT HERE</label></div><br><br>";
                            selectedValue += "<input type='hidden' name='getData"+subTotal+"' class='"+subTotal+"' value ='"+data[count]['report_start_date']+'_'+data[count]['report_end_date']+'_'+data[count]['fnsku']+'_'+data[count]['accountId']+'_'+data[count]['case_type']+"'>";
                            subTotal +=1
                        }

                        $('#selected_items').append("<div class='col-md-12' id='userDetail' style='padding-bottom:10px;'>" + temp + "</div>");
                        $('#selectedValues').append("<div class='col-md-12' id='userSelectValue'>"+selectedValue+"</div>");
                        $('#subTotal').val(subTotal);
                    }
                }
            });
        }
        else
        {
            var subTotal = parseInt($('#subTotal').val());
            $('#userDetail').remove();
            $('#userSelectValue').remove();

            if(subTotal>0){
                subTotal-=1;
                $('#subTotal').val(subTotal);
            }

            var myCheckboxes = new Array();
            $("input:checked").each(function() {
                myCheckboxes.push($(this).val());
            });
            if(myCheckboxes.length==0)
            {
                $('#noSelect').append("<li><div class='col-md-12'>No Data Selected.</div></li>");
                $('#subTotal').val(0);
            }
        }
    });

    $('#addCaseId').click(function ()
    {
        if (jQuery("#addCase_Id").valid())
        {
            $("#loadingContent").css("display", "block");
            var accountId = $('#account_ID').val();
            var caseId = $('#case__Id').val();
            var date = $('#caseDate').val();

            var myCheckboxes = new Array();
            $("input:checked").each(function() {
                myCheckboxes.push($(this).val());
            });

            if(myCheckboxes.length==0){
                $("#loadingContent").css("display", "none");
                $('#message').remove();
                $('.generateCaseMessage').append("<div class='alert alert-danger' style='margin-top:25px;margin-bottom:0px;' id='message'>Please Select At least One Transaction Item Id.</div>");
                setTimeout(function () {$("#message").hide();}, 4000);return false;
            }
            var subTotal = parseInt($('#subTotal').val());
            var dataValue = new Array();
            var flag =1;

            for(count=0;count<=subTotal;count++)
            {
                if ($('#select'+flag).is(':checked'))
                {
                    dataValue[count] = $('.' + flag).val();
                }
                flag++;
            }

            var baseURL = '<?php echo site_url() . 'Inventory_salvager/createInventoryCaseId/' ?>';

             $.ajax({
                type: "POST",
                url: baseURL,
                data: {myCheckboxes:myCheckboxes,accountId:accountId,caseId:caseId,date:date,dataValue:dataValue},
                success: function (result) {
                    if (result) {
                        setTimeout(function(){
                           $("#loadingContent").css("display", "none");
                           window.location.href = "<?php echo site_url() . 'inventory_salvager/index' ?>";
                        }, 1000);
                    }
                }
            });
        }
    });

</script>
