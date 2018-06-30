<style>
    @media screen and (max-width: 600px) {

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
        table td {
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
        <?php echo form_open('Inventory_salvager/AsidGeneratecase', array("class" => "form-horizontal", "id" => "addCase_Id")); ?>
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
                <table id="myTable" class="display responsive" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Qty Shipped</th>
                        <th>Qty Received</th>
                        <th>Qty Desc'</th>
                        <th>Shipment ID</th>
                        <th>Fullfilment Network Sku</th>
                        <th>SKU</th>
                        <th>In Eligible</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($ASIDcaseDetails as $key => $record) {
                        $desc = $record['qty_shipped']-$record['qty_received'];
                        $ASIDcaseDetails = $record['inventoryItemId'] . '/' . $record['ID_ACCOUNT'] . '/' . $record['case_type'] . '/' .$record['seller_sku'] ;
                    ?>
                            <tr>
                                <td >
                                    <div class="material-switch" style="margin-left:30px; margin:15px; margin-bottom: 30px;">
                                        <input id="<?php echo $ASIDcaseDetails; ?>" value="<?php echo $ASIDcaseDetails; ?>" type="checkbox"  class="checkbox" name="checkbox">&nbsp;
                                        <label for="<?php echo $ASIDcaseDetails; ?>" class="label-success"></label>
                                        <div style="margin-top:-20px; margin-left:70px;"></div>
                                    </div>
                                </td>
                                <td><?php echo $record['qty_shipped']; ?></td>
                                <td><?php echo $record['qty_received']; ?></td>
                                <td><?php echo $desc; ?></td>
                                <td><?php echo $record['shipment_id']; ?></td>
                                <td><?php echo $record['fulfillment_network_sku']; ?></td>
                                <td><?php echo $record['seller_sku']; ?></td>
                                <td><a href="<?php echo site_url('Inventory_salvager/remove_user/' . $record['id']); ?>" class="delete" id="delete<?php echo $record['id']; ?>"><input type="checkbox" value="<?php echo $record['id']; ?>" class="delete"></a></td>
                            </tr>
                    <?php } ?>
                    </tbody>
                </table><br>

                <hr>
                <div id="msg" align="left" style="margin:30px;"> <label>Good Day.</label><br><br>
                    <label id="msg_top"></label><br><br>
                    <div>
                        <div class='col-md-12'>
                            <div class='col-md-12' id="0">
                                <label value="Start Date" class="col-md-3 label-heading">&nbsp;SKU</label>
                                <label value="End Date" class="col-md-3 label-heading">Quantity Shipped</label>
                                <label value="Fnsku" class="col-md-2 label-heading">Quantity Received</label>
                                <label value="Quantity" class="col-md-2 label-heading">Full Net Sku</label>
                            </div>
                        </div>
                        <div id="selected_items""></div>
                </div><br><br>
                <label>Thanks you.</label></b>
    </div>
    <a href="#" class="button btn btn-success" id="copy-button" data-clipboard-target="#msg">Copy Message</a>
    </p>
    <div class="col-md-12" id="selectedValues">

    </div>
</div>
<div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
<div class="modal-footer">
    <a href="<?php echo site_url() . 'inventory_salvager/index' ?>" class="btn btn-success"><?php echo lang('ctn_135') ?></a>
    <input type="button" class="btn btn-success" value="<?php echo lang("ctn_61") ?>" id="addCase_IdASID" />
    <?php echo form_close() ?>
</div>

<link rel="stylesheet" href="<?php echo base_url() . "styles/datepicker.css"; ?>">
<script type="text/javascript" src="<?php echo base_url() . "scripts/datePicker.js"; ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>

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
            var baseURL = "<?php echo site_url() . "Inventory_salvager/GetASIDCaseDetail/" ?>" +data;
            $.ajax
            ({
                type: "GET",
                url: baseURL,
                success: function (result) {
                    if(result){
                        $('#noSelect').remove();
                        var data = $.parseJSON(result);
                        var temp ='';
                        var selectedValue = '';
                        temp += "<div class='col-md-12'><label value='Seller SKU' class='col-md-3 label-heading'>&nbsp;"+data['seller_sku']+"</label><label value='Quantity Shipped' class='col-md-3 label-heading'>&nbsp;"+data['qty_shipped']+"</label><label value='Quantity Receive' class='col-md-2 label-heading'>&nbsp;"+data['qty_received']+"</label><label value='Quantity' class='col-md-2 label-heading'>&nbsp;&nbsp;&nbsp;&nbsp;"+data['fulfillment_network_sku']+"</label></div><br>";
                        $('#selected_items').append("<div class='col-md-12' id='userDetail' style='padding-bottom:10px;'>" + temp + "</div>");
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
            if(myCheckboxes.length==0){
                $('#noSelect').append("<li><div class='col-md-12'>No Data Selected.</div></li>");
                $('#subTotal').val(0);
            }
        }
    });

    $(document).on("click", "#addCase_IdASID", function (e)
    {
        if (jQuery("#addCase_Id").valid())
        {
            $("#loadingContent").css("display", "block");
            var case_id = $('#case__Id').val();
            var sub_date = $('#caseDate').val();
            var myCheckboxes = new Array();
            $("input:checked").each(function () {
                myCheckboxes.push($(this).val());
            });

            var baseURL = '<?php echo site_url() . 'inventory_salvager/generateASIDCase/' ?>';
            $.ajax({
                type: "POST",
                url: baseURL,
                data: {myCheckboxes:myCheckboxes,case_id:case_id,sub_date:sub_date},
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

    $('.delete').on('click', function (e)
    {
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


</script>
