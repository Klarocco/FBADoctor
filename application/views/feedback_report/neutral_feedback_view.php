<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-trash-o"></span> <?php echo lang("ctn_517") ?></div>
        <div class="db-header-extra"> 
        </div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_426") ?></li>
        <li class="active"><?php echo lang("ctn_517") ?></li>
    </ol>
    <hr>
    <div class="align-center">
        <?php echo $this->pagination->create_links(); ?>
    </div>
    <div id="first">
        <table class="table table-bordered dt-responsive" width="100%" id="pend_table">
            <thead class="table-header">
                <?php if(!empty($this->user->info->admin)): ?>
                    <td>User Name</td>
                <?php endif;?>
                <td><?php echo lang("ctn_400") ?></td>
                <td>Filed</td>
                <td><?php echo lang("ctn_409") ?></td>
                <td><?php echo lang("ctn_410") ?></td>
                <td><?php echo lang("ctn_402") ?></td>
                <td><?php echo lang("ctn_411") ?></td>
                <td><?php echo lang("ctn_412") ?></td>
                <td><?php echo lang("ctn_413") ?></td>
                <td><?php echo lang("ctn_414") ?></td>
                <td><?php echo lang("ctn_405") ?></td>
                <td><?php echo lang("ctn_415") ?></td>
                <!--<td><?php echo lang("ctn_406") ?></td>-->
            </thead>
            <tbody>
                <?php if(!empty($this->user->info->admin)): ?>
                <?php foreach($feedback as $key=>$record): ?>
                    <?php foreach ($record['feedBack'] as $flag=>$feedBackDetails): ?>
                        <tr>
                            <td><?php echo $record['userInfo']['username'];?></td>
                            <td><?php echo '<a target="_blank" href="https://sellercentral.amazon.com/gp/orders-v2/details?ie=UTF8&orderID=' . $feedBackDetails['orderid'] . '"><b>' . $feedBackDetails['orderid'] . '</b></a>' ?></a></td>
                            <td><?php echo date("m/d/Y", $feedBackDetails['feedbackdate']) ?></td>
                            <td><?php echo $feedBackDetails['rating'] ?></td>
                            <td>
                                <?php if (strlen($feedBackDetails['comments']) > 30):?>
                                    <?php $r['comments'] = trim(substr($feedBackDetails['comments'], 0, 30)) . '...'; ?>
                                <?php endif;?>
                                <a href="" data-target="#commnetmodel" data-id="<?php echo $feedBackDetails['ID_ACCOUNT']."_".$feedBackDetails['orderid']; ?>" data-toggle="modal" class="open_comment_modal">
                                    <?php echo $feedBackDetails['comments']; ?>
                                </a>
                            </td>
                            <td><?php echo $feedBackDetails['buyername'] ?></td>
                            <td><?php echo $feedBackDetails['sku'] ?></td>
                            <td><?php echo $this->common->FormatYesNoNA($feedBackDetails['arrivedontime']); ?></td>
                            <td><?php echo $this->common->FormatYesNoNA($feedBackDetails['itemasdescribed']); ?></td>
                            <td><?php echo $this->common->FormatYesNoNA($feedBackDetails['customerservice']); ?></td>
                            <td><?php echo ($feedBackDetails['fba'] == 1 ? '<img src="' . base_url() . 'images/amzsmalllogo.png" alt="FBA" />' : '') ?></td>
                            <td><?php echo $feedBackDetails['hasremoved'] = ($feedBackDetails['hasremoved'] == 1 ? 'Yes' : 'No'); ?></td>
                            <!--<td><?php if (!empty($feedBackDetails['ID_ORDER'])) echo '<a href="" data-target="#viewnotemodel" data-id="' . $feedBackDetails['ID_ORDER'] . '" data-toggle="modal" class="open_view_note_modal">View Notes</a>'; ?></td>-->
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach;?>
                <?php else :?>
                    <?php foreach ($feedback as $record) : ?>
                        <tr>
                            <td><?php echo '<a href="https://sellercentral.amazon.com/gp/orders-v2/details?ie=UTF8&orderID=' . $record['orderid'] . '"><b>' . $record['orderid'] . '</b></a>' ?></a></td>
                            <td><?php echo date("m/d/Y", $record['feedbackdate']) ?></td>
                            <td><?php echo $record['rating'] ?></td>
                            <td>
                                <?php if (strlen($record['comments']) > 30):?>
                                    <?php $r['comments'] = trim(substr($record['comments'], 0, 30)) . '...'; ?>
                                <?php endif;?>
                                <a href="" data-target="#commnetmodel" data-id="<?php echo $record['ID_ACCOUNT']."_".$record['orderid']; ?>" data-toggle="modal" class="open_comment_modal">
                                    <?php echo $record['comments']; ?>
                                </a>
                            </td>
                            <td><?php echo $record['buyername'] ?></td>
                            <td><?php echo $record['sku'] ?></td>
                            <td><?php echo $this->common->FormatYesNoNA($record['arrivedontime']); ?></td>
                            <td><?php echo $this->common->FormatYesNoNA($record['itemasdescribed']); ?></td>
                            <td><?php echo $this->common->FormatYesNoNA($record['customerservice']); ?></td>
                            <td><?php echo ($record['fba'] == 1 ? '<img src="' . base_url() . 'images/amzsmalllogo.png" alt="FBA" />' : '') ?></td>
                            <td><?php echo $record['hasremoved'] = ($record['hasremoved'] == 1 ? 'Yes' : 'No'); ?></td>
                            <!--<td><?php if (!empty($record['ID_ORDER'])) echo '<a href="" data-target="#viewnotemodel" data-id="' . $record['ID_ORDER'] . '" data-toggle="modal" class="open_view_note_modal">View Notes</a>'; ?></td>-->
                        </tr>
                    <?php endforeach; ?>
                <?php endif;?>
            </tbody>
        </table>
    </div>
    <!-- start Comment Modal-->
    <div class="modal fade"  id="commnetmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body commentmodel" style="background: #e1fce8;">
                    <table class="table table-striped">
                        <tbody>
                        </tbody></table>
                    <div class="modal-footer">
                        <a class="respondfeedbacklink2" data-id="" href="#" id="send_msg" data-toggle="modal" data-target="#feedbackrespond"><span name="oButton1" class="btn btn-success">Message Customer</span></a>
                        <button type="button" id="commnetmodelclose" class="btn btn-default" data-dismiss="modal" ><?php echo lang("ctn_60") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Comment Modal-->
    <!--start feedback respond model-->
    <div class="modal fade" id="feedbackrespond" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow-x: hidden;overflow-y: auto;">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header feedBackRespondMessage">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="feedbackrespondbody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
                </div>
            </div>
        </div>
    </div>
    <!--End feedback respond model-->
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

                        </tbody></table>
                    <hr/>
                    <br/>
                    <table class="view_note_table">
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
<div id="ajaxData">

</div>
<script language="javascript">
    $("document").ready(function () {
        $.noConflict();
        $('#pend_table').DataTable({
            "searching": true,
            "responsive": true
        });
    });
    //display commnet info
    $(document).on("click", ".open_comment_modal", function () {
        var data = $(this).data('id').split('_');
        var send_msg = document.getElementById("send_msg");
        var infoModal = $('#commnetmodel');
        var loadurl = '<?php echo site_url() ?>manage_feedback/get_orderinfo_by_order_id/'+data[0] +'/'+data[1];
        $.ajax({
            url: loadurl,
            type: 'GET',
            success: function (result) {
                var data = $.parseJSON(result);
                console.log(data);
                htmlData = '<tr><td>Order ID:</td> <td>' + data.orderid + '<td></tr>\n\\n\
                            <tr><td>Buyer Name:</td> <td>' + data.buyername + '<td></tr><tr><td>Comment:</td> <td>' + data.comments + '<td></tr>';
                infoModal.find('.table').html(htmlData);
                send_msg.setAttribute('data-id', data.ID_ACCOUNT+'_'+data.orderid);
                $("#commnetmodel").show();
            }
        });
    });
    $(document).on("click", ".respondfeedbacklink2", function () {
        $("#commnetmodel").hide();
        var data = $(this).data('id').split('_');
        var loadurl = '<?php echo site_url() ?>manage_feedback/getRespondFeedback/'+data[0] +'/'+data[1];
        $.ajax({url: loadurl,
            type: 'GET',
            success: function (data) {
                console.log(data);
                if(data==0){
                    $("#message").remove();
                    $('.feedBackRespondMessage').append("<div class='alert alert-danger' style='margin-top:25px;margin-bottom:0px;' id='message'>Amazon allows responding up to 60 days after the feedback date.</div>");
                    setTimeout(function () {$("#message").hide();}, 10000);return false;
                }
                else {
                    $("#feedbackrespondbody").empty();
                    $("#feedbackrespondbody").html(data);
                    $("#feedbackrespond").show();
                    /*console.log(data);*/
                }
            }
        });
    });
    //view note info
    $(document).on("click", ".open_view_note_modal", function () {
        var order_id = $(this).data('id');
        var add_note = document.getElementById("add_note_btn");
        var infoModal = $('#viewnotemodel');
        loadurl = '<?php echo site_url() ?>manage_feedback/get_orderinfo_by_order_id';
        $.ajax({
            url: loadurl,
            type: 'POST',
            data: {
                order_id: order_id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
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
            url: '<?php echo site_url() ?>manage_feedback/get_notes_by_order_id',
            type: 'POST',
            data: {
                order_id: order_id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
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
    //add notes ajax call
    $('#add_note_btn').click(function (e) {

        order_id = $(this).data('id');
        note = document.getElementById('note').value;
        if (note == '') {
            alert("Please enter note Message");
            return false;
        }
        loadurl = '<?php echo site_url() ?>manage_feedback/add_feedback_notes';
        $.ajax({
            url: loadurl,
            type: 'POST',
            data: {
                order_id: order_id,
                note: note,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
            },
            dataType: "html",
            success: function (data) {
                $("#viewnotemodel").modal('hide');
                $('.modal-backdrop').remove();
                alert(data);
            }
        });
    });
</script>