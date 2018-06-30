<?php if ($this->user->info->admin) : ?>

    <table class="display responsive" width="100%" id="pend_table">
    <thead class="table-header">
    <tr>
        <?php if ($this->user->info->admin) : ?>
            <td>Username</td>
        <?php endif; ?>
        <td>OrderID</td>
        <td>Tracking No</td>
        <td>Shipment Date</td>
        <td>Shipping Carrier</td>
        <td>Shipment Address</td>
    </tr>
    </thead>
    <tbody>
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
    </div>
    <input type="hidden" name="startdate" id="startdate" value="<?php echo $start_date; ?>">
    <input type="hidden" name="enddate" id="enddate" value="<?php echo $end_date; ?>">
<?php endif; ?>




<script>
       $(document).ready(function ()
       {
            $('#pend_table').DataTable();
       });
</script>

<script>
    $(document).ready(function()
    {
        setTimeout(function()
        {
            loadajax();
        },10);

    });

    function loadajax()
    {

        var start_Date = $('#startdate').val();
        var end_Date = $('#enddate').val();

        var baseURL = '<?php echo site_url() . 'Amazon_case/UserTrackingInfoAjax/' ?>'+ start_Date + '/' + end_Date;

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
