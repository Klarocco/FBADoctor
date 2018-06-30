<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_416") ?></div>
        <div class="db-header-extra"> 
        </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_416") ?></li>
    </ol>
    <hr>
    <div class="align-center">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <table class="table table-bordered">
        <tr class="table-header"><td><?php echo lang("ctn_400") ?>
                <?php if ($col === 1) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/1/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td><?php echo lang("ctn_417") ?>
                <?php if ($col === 2) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/2/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td class="col-sm-2"><?php echo lang("ctn_409") ?>
                <?php if ($col === 3) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/3/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td><td><?php echo lang("ctn_410") ?>
                <?php if ($col === 4) : ?>
                    <?php if ($sort == 1) : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/4/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
                    <?php else : ?>
                        <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/4/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
                    <?php endif; ?>
                <?php else : ?>
                    <a href="<?php echo site_url("get_amazon_feedback_report/display_positive_feedback/4/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
                <?php endif; ?>
            </td>
            <td><?php echo lang("ctn_402") ?></td>
            <td><?php echo lang("ctn_411") ?></td>
            <td><?php echo lang("ctn_412") ?></td>
            <td><?php echo lang("ctn_413") ?></td>
            <td><?php echo lang("ctn_414") ?></td>
            <td><?php echo lang("ctn_405") ?></td>
            <td><?php echo lang("ctn_415") ?></td>
            <td><?php echo lang("ctn_406") ?></td>
        </tr>
        <?php foreach ($positive_feedback as $row) : ?>
            <tr><td><?php echo '<a href="https://sellercentral.amazon.com/gp/orders-v2/details?ie=UTF8&orderID=' . $row['orderid'] . '"><b>' . $row['orderid'] . '</b></a>' ?></a></td>
                <td><?php echo date("j F Y h:i:s A", $row['feedbackdate']) ?></td>
                <td><?php echo $row['rating'] ?></td>
                <td><?php
                    if (strlen($row['comments']) > 30) {
                        $r['comments'] = trim(substr($row['comments'], 0, 30)) . '...';
                    }
                    echo '<a href="" data-target="#positive_commnetmodel" data-id="' . $row['ID_ORDER'] . '"  data-toggle="modal" class="open_comment_modal">' . $r['comments'] . '</a>';
                    ?></td>
                <td><?php echo $row['buyername'] ?></td>
                <td><?php echo $row['sku'] ?></td>
                <td><?php echo $this->common->FormatYesNoNA($row['arrivedontime']); ?></td>
                <td><?php echo $this->common->FormatYesNoNA($row['itemasdescribed']); ?></td>
                <td><?php echo $this->common->FormatYesNoNA($row['customerservice']); ?></td>
                <td><?php echo ($row['fba'] == 1 ? '<img src="' . base_url() . 'images/amzsmalllogo.png" alt="FBA" />' : '') ?></td>
                <td><?php echo $row['hasremoved'] = ($row['hasremoved'] == 1 ? 'Yes' : 'No'); ?></td>
                <td><?php if (!empty($row['ID_ORDER'])) echo '<a href="" data-target="#viewnotemodel" data-id="' . $row['ID_ORDER'] . '"  data-toggle="modal" class="open_view_note_modal">View Notes</a>'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="align-center">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <!-- start Comment Modal-->
    <div class="modal fade" data-backdrop="" id="positive_commnetmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body commentmodel">
                    <table class="table table-striped">
                        <tbody>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Comment Modal-->

    <!--start View Notes modal-->
    <div class="modal fade" id="viewnotemodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tbody>

                        </tbody>
                    </table>
                    <hr/>
                    <br/>
                    <table class="view_note_table" cellspacing="10">
                        <tbody>

                        </tbody>
                    </table>
                    <table class="">
                        <tbody>
                            <tr>
                                <td align="center"><h1>Add Note</h1></td>
                            </tr>
                            <tr>
                                <td align="center"><textarea cols="50" rows="7" id="note" name="note" required=""></textarea></td>
                            </tr>

                            <tr>
                                <td align="center" >
                                    <a  data-id="" href="#" id="add_note_btn"><span name="oButton1" class="btn btn-success">Add Note</span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--End View Notes modal-->
</div>
<script>
    //display commnet info
    $(document).on("click", ".open_comment_modal", function () {
        var order_id = $(this).data('id');
        var infoModal = $('#positive_commnetmodel');
        loadurl = '<?php echo site_url() ?>get_amazon_feedback_report/get_orderinfo_by_order_id';
        $.ajax({
            url: loadurl,
            type: 'POST',
            data: {
                order_id: order_id
            },
            dataType: "json",
            success: function (data) {

                htmlData = '<tr><td>Order ID:</td> <td>' + data.orderid + '<td></tr>\n\\n\
                                    <tr><td>Buyer Name:</td> <td>' + data.buyername + '<td></tr><tr><td>Comment:</td> <td>' + data.comments + '<td></tr>';
                infoModal.find('.table').html(htmlData);
                $("#positive_commnetmodel").modal('show');
            }
        });
    });
    //add notes ajax call
    $('#add_note_btn').click(function (e) {

        order_id = $(this).data('id');
        note = document.getElementById('note').value;
        if(note == ''){
            alert("Please enter note Message");
        return false;
        }
        loadurl = '<?php echo site_url() ?>get_amazon_feedback_report/add_feedback_notes';
        $.ajax({
            url: loadurl,
            type: 'POST',
            data: {
                order_id: order_id,
                note: note
            },
            dataType: "html",
            success: function (data) {
                $("#viewnotemodel").modal('hide');
                $('.modal-backdrop').remove();
                alert(data);
            }
        });
    });

    //view note info
    $(document).on("click", ".open_view_note_modal", function () {
        var order_id = $(this).data('id');
        var add_note = document.getElementById("add_note_btn");
        var infoModal = $('#viewnotemodel');
        loadurl = '<?php echo site_url() ?>get_amazon_feedback_report/get_orderinfo_by_order_id';
        $.ajax({
            url: loadurl,
            type: 'POST',
            data: {
                order_id: order_id
            },
            dataType: "json",
            success: function (data) {

                myDate = new Date(1000 * data.purchasedate);

                htmlData = '<tr><td colspan="2"><h1>Order information</h1></td></tr><tr><td>Order ID:</td> <td>' + data.orderid + '<td></tr><tr><td>Purchase Date:</td> <td>' + myDate + '<td></tr>\n\\n\
                                    <tr><td>Item Ordered:</td> <td>' + data.productname + '<td></tr><tr><td>Buyer Name:</td> <td>' + data.buyername + '<td></tr>';
                infoModal.find('.table').html(htmlData);
                add_note.setAttribute('data-id', data.ID_ORDER);
                $("#viewnotemodel").modal('show');
            }
        });
        //view notes by order id
        $.ajax({
            url: '<?php echo site_url() ?>get_amazon_feedback_report/get_notes_by_order_id',
            type: 'POST',
            data: {
                order_id: order_id
            },
            dataType: "json",
            success: function (data) {
                var monthNames = [
                    "January", "February", "March",
                    "April", "May", "June", "July",
                    "August", "September", "October",
                    "November", "December"
                ];
                var row = "<tr><td><h1>Notes</h1></td></tr>";

                $.each(data, function (index, item) {
                    myDate = new Date(1000 * item.datecreated);

                    var day = myDate.getDate();
                    var monthIndex = myDate.getMonth();
                    var year = myDate.getFullYear();

                    row += "<tr><td colspan='4' style='padding-right: 40px'>" + day + " " + monthNames[monthIndex] + " " + year + "</td><td></td><td></td><td>" + item.note + "</td></tr>";
                });
                $(".view_note_table").html(row);
            }
        });

    });
</script>