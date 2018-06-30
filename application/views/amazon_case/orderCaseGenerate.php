<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title">
            <i class="fa fa-user" aria-hidden="true"></i> <?php echo lang("ctn_620") ?>
        </div>
    </div>

    <div class="row">
        <h3 align="center">Order Reimbursement User Detail</h3>
    </div><br>

    <div class="row" style="margin:15px;">
        <?php echo form_open('amazon_case/orderCasesGeneration', array("class" => "form-horizontal", "id" => "addCase_Id")); ?>
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
                <div class="col-md-10"><?php echo $email; ?></div>
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
            Please Select Orders From Following # <br><br>
            <table id="myTable" class="display" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th></th>
                    <th>Order Id</th>
                    <th>In Eligible</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($orderId as $orderId)
                        {
                    ?>
                 <tr>
                    <td >
                        <div class="material-switch"  style="margin-left:30px; margin:15px; margin-bottom: 10px;">
                            <input id="someSwitchOptionDanger<?php echo $orderId['order_id']; ?>" type="checkbox" value="<?php echo $orderId['order_id'];?>" class="checkbox" name="checkbox" >&nbsp;
                            <label for="someSwitchOptionDanger<?php echo $orderId['order_id'];?>" class="label-success"></label>
                        </div>
                    </td>
                    <td><?php echo $orderId['order_id']; ?></td>
                    <td><a href="<?php echo site_url('Amazon_case/remove_user/' . $orderId['id']); ?>" class="delete" id="delete<?php echo $orderId['id']; ?>"><input type="checkbox" value="<?php echo $orderId['id']; ?>" class="delete"></a></td>
                 </tr>
                    <?php } ?>
                </tbody>
            </table><br>

            <div id="msg" align="left" style="margin:30px;"> <label>Good Day.</label><br><br>
                <label id="msg_top"><?php echo $msg_top; ?></label><br><br>
                <div id="selected_items"></div><br><br>
                <label>Thank you.</label><br><br>
            </div>
        </p>
    </div>
    <div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
    <div class="modal-footer generateData">
        <input type="hidden" value="<?php echo $accountId; ?>" name="account_ID" id="account_ID" >
        <input type="hidden" value="" name="type_case" id="type_case">
        <a href="#" class="button btn btn-success" id="copy-button" data-clipboard-target="#msg" style="margin:10px;">Copy Message</a>
        <a href="<?php echo site_url("amazon_case") ?>" class="btn btn-success"><?php echo lang('ctn_135') ?></a>
        <input type="button" class="btn btn-success" value="<?php echo lang("ctn_61") ?>" id="addCaseId" />
        <?php echo form_close()  ?>
    </div>
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
                        caseDate : "required",
                    },
                messages :
                    {
                        case__Id : "Please Enter Case Id.",
                        caseDate : "Please Select Case Date",
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


    $('#addCaseId').click(function () {
        if (jQuery("#addCase_Id").valid()) {
            $("#loadingContent").css("display", "block");
            var accountId = $('#account_ID').val();
            var caseId = $('#case__Id').val();
            var date = $('#caseDate').val();

            $("#loadingContent").css("display", "block");
            var myCheckboxes = new Array();
            $("input:checked").each(function () {
                myCheckboxes.push($(this).val());
            });

            if (myCheckboxes.length == 0) {
                $("#loadingContent").css("display", "none");
                $('#message').remove();
                $('.generateCaseMessage').append("<div class='alert alert-danger' style='margin-top:25px;margin-bottom:0px;' id='message'>Please Select At least On Check box.</div>");
                setTimeout(function () {
                    $("#message").hide();
                }, 4000);
                return false;
            }
            var baseURL = '<?php echo site_url() . 'Amazon_case/createCaseId/' ?>';

            $.ajax({
                type: "POST",
                url: baseURL,
                data: {myCheckboxes: myCheckboxes, accountId: accountId, caseId: caseId, date: date},
                success: function (result) {
                    if (result) {
                        $("#loadingContent").css("display", "none");
                        console.log(result);
                        setTimeout(function ()
                        {
                            $("#loadingContent").css("display", "none");
                            window.location.href = "<?php echo site_url() . 'Amazon_case/index' ?>";
                        }, 1000);
                    }
                }
            });
        }
    });

    $(".checkbox").change(function()
    {
       var value = $(this).val(),
            $list = $("#selected_items");
        if (this.checked)
        {
            $list.append("<li data-value='" + value + "'>" + value + "</li>");
        }
        else
        {
            $list.find('li[data-value="' + value + '"]').slideUp("fast", function()
            {
                $(this).remove();
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