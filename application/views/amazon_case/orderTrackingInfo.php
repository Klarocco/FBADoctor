<div class="form-group">
    <label id="msg" name="msg" class="msg"></label>
</div>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"><span class="fa fa-dollar"></span> <?php echo lang("ctn_622") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active">Order Reimbursement</a></li>
        <li class="active"><?php echo lang("ctn_622") ?></li>
    </ol><hr>
    <?php if ($this->user->info->admin) : ?>
        <div class="row" id="basicExample">
            <div class="col-md-12" align="center">
                <div class="col-md-3">
                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date">
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="accountId" name="accountId">
                        <option value="">Select Users</option>
                        <?php foreach ($userInfo as $key=>$record) :?>
                            <option value="<?php echo $record['ID'] ?>"><?php echo $record['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="col-md-7">
                        <input type="button" class="btn btn-success filter" name="add" value="Filter" id="add">
                    </div>
                </div>
            </div>
        </div>
        <br>
    <?php else: ?>
        <div class="row" id="basicExample">
            <div class="col-md-12" align="center">
                <div class="col-md-3">
                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date">
                </div>
                <div class="col-md-2">
                    <div class="col-md-7">
                        <input type="button" class="btn btn-success" name="add" value="Filter" id="add">
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><br>
    <iframe id="my_iframe" style="display:none;"></iframe>
    <br>
    <?php if ($this->user->info->admin) : ?>
        <div id="first">
            <table class="display responsive" width="100%" id="pend_table">
                <thead class="table-header">
                   <tr>
                        <td>Username</td>
                        <td>OrderID</td>
                        <td>Tracking No</td>
                        <td>Shipment Date</td>
                        <td>Shipping Carrier</td>
                        <td>Shipment Address</td>
                    </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                <?php if ($this->user->info->admin) : ?>
                    <?php foreach ($orderTrackingInfo as $record) :  ?>
                        <tr>
                            <td><?php echo $record['username']; ?></td>
                            <td><?php echo $record['order_id']; ?></td>
                            <td><?php echo $record['trackingnumber']; ?></td>
                            <td>
                                <?php
                                    $new_date =  $record['shipmentdate'];
                                    $date = new DateTime("@$new_date");
                                    $shipment_date= $date->format('Y-m-d');
                                    echo $shipment_date;
                                ?>
                            </td>
                            <td><?php echo $record['shippingcarrier']; ?></td>
                            <td><?php echo $record['shipaddress1']; ?><br><?php echo $record['shipcity'],' - ',$record['shipzip']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
        </div>
    <?php else : ?>

    <div id="first">
        <table id="example" class="display" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th></th>
                <th>Case Id</th>
                <th>Total Amount</th>
                <th>Case generation date</th>
            </tr>
            </thead>
        </table>
        <div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>

    </div>

    <?php endif; ?>

</div>


<link rel="stylesheet" href="<?php echo base_url() . "styles/datepicker.css"; ?>">
<script type="text/javascript" src="<?php echo base_url() . "scripts/datePicker.js"; ?>"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>

    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
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
    $(document).ready(function () {

        $.noConflict();
        $('#pend_table').DataTable({
            "searching": true,
            "responsive": true
        });
    });

    $('#add').on('click',function()
    {
        $("#loadingContent").css("display", "block");
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var account_id = $("#accountId").val();

        if(start_date > end_date)
        {
            $('#msg').html("<div class='alert alert-danger' style='margin-left: 20px; width:1200px'>Date cannot be less than start date.</div>");
        }
        else
        {
            var baseURL = '<?php echo site_url() . 'Amazon_case/AjaxTrackingInfo' ?>';
            $.ajax
            ({
                type: "POST",
                url: baseURL,
                data: {'start_date': start_date, 'end_date': end_date, 'account_id': account_id},
                success: function (result)
                {
                    $("#loadingContent").css("display", "none");
                    $("#first").html(result);
                }

            });
        }
    });

    $(document).ready(function()
    {
        setTimeout(function()
        {
            loadajax();
        },10);

    });

    function loadajax()
    {
        var baseURL = '<?php echo site_url() . 'Amazon_case/UserTrackingInfo' ?>';

        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result)
            {
                var detail = jQuery.parseJSON(result);
                $(document).ready(function () {
                    var table = $('#example').DataTable(
                        {
                            data: detail,
                            'columns': [{
                                'targets': 0,
                                'title': '',
                                'sortable': false,
                                "paginate": false,
                                'class': 'details-control',
                                'data': function () {
                                    return '';
                                }
                            }, {
                                'targets': 1,
                                'title': "Case Id",
                                'render': function (data, type, row) {
                                    return '<input type="hidden" id="id" name="id" value="' + row.ID_ACCOUNT + '"><span class="status status-' + (row.case_id).toLowerCase() + '">' + row.case_id + '</span>';
                                }

                            }, {

                                'targets': 2,
                                'title': "Total Amount",
                                'render': function (data, type, row) {
                                    return '<span>' + '$' + '</span> <span class="status status-' + (row.amount_total).toLowerCase() + '">' + row.amount_total + '</span>';
                                }
                            }, {

                                'targets': 3,
                                'title': "Case Generation Date",
                                'render': function (data, type, row) {
                                    var date = row.date.split(' ')[0];
                                    return '   <span class="status status-' + date + '">' + date + '</span>';
                                }
                            }],

                            "order": [[2, 'asc']]
                        });

                    $('#example tbody').on('click', 'td.details-control', function () {
                        var tr = $(this).closest('tr');
                        var id = $(this).closest('tr').find('input[name="id"]').val();
                        var row = table.row(tr);

                        if (row.child.isShown()) {
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else
                            {
                            row.child(format(row.data())).show();
                            tr.addClass('shown');
                        }
                    });
                });
            }
        });
    }

    function format(d)
    {
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width:100%">'+
                    '<thead>'+
                            '<tr>'+
                            '<th>Order ID</th>'+
                            '<th>SKU </th>'+
                            '<th>Asin </th>'+
                            '<th>Shipment Id </th>'+
                            '<th>Tracking Info </th>'+
                            '<th>Shipment Carrier </th>'+
                            '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                            '<tr>'+
                            '<td>'+d.orderid+'</td>'+
                            '<td>'+d.sku+'</td>'+
                            '<td>'+d.asin+'</td>'+
                            '<td>'+d.shipmentid+'</td>'+
                            '<td>'+d.trackingnumber+'</td>'+
                            '<td>'+d.shippingcarrier+'</td>'+
                            '</tr>'+
                    '</tbody>'+
                '</table>';
    }

</script>
