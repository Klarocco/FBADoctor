<div class="row" id="mailRequest">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Request">Request Removal of Negative Feedback</a></li>
        <li><a data-toggle="tab" href="#SendMessage">Send Message</a></li>
    </ul>
    <div class="tab-content">
        <div id="Request" class="tab-pane fade in active">
            <form name="frmadd2" method="post" >
                <table>
                    <tr><td colspan="2"><h1>Request Removal of Negative Feedback</h1></td></tr>
                    <tr>
                        <td width="55%">
                            <table class="table table-striped">
                                <tr>
                                    <td>From:</td>
                                    <td><?php echo $order['feedbackfromemailaddress']; ?></td>
                                </tr>
                                <tr>
                                    <td>To:</td>
                                    <td><?php echo $order['buyeremail']; ?></td>
                                </tr>
                                <tr>
                                    <td>Subject:</td>
                                    <td><input type="text" name="subject" size="35" id="subjectline" value="<?php echo $subject; ?>" style="width: 95%" /></td>
                                </tr>
                                <tr>
                                    <td>Issue:</td>
                                    <td><?php echo $order['comments']; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="45%" bgcolor="#FFE0D1">
                            <h4 style="margin-left: 20px;margin-top: 5px">Submit a feedback removal request directly to Amazon</h4>
                            <ol>
                                <li>Visit <a href="https://sellercentral.amazon.com/hz/contact-us" target="_blank">Contact Us</a> on sellercentral.amazon.com</li>
                                <li>Next select "<strong>Selling on Amazon</strong>" then "<strong>Customers and orders</strong>" and then last click on "<strong>Customer feedback</strong>"</li>
                                <li>Then in the search box that asks for "<strong>Order ID with negative feedback</strong>" enter the following: {$order.orderid} and click search</li>
                            </ol>
                        </td>
                    </tr>
                </table>
                <br>
                <table class="table table-striped">
                    <tr>
                        <td align="center"><textarea name="message" id="body_message" rows="7" cols="75"><?php echo $message; ?></textarea></td>
                    </tr>
                    <tr>
                        <td align="center" >
                            <input type="submit" value="Send Remove Feedback Request" id="respond_feedback" class="btn btn-success" /><!--data-toggle="modal" data-target="#success"-->
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="SendMessage" class="tab-pane fade">
            <form name="frmadd2" method="post" onSubmit="return false;">
                <table>
                    <tr>
                        <td colspan="2"><h1>Send Message</h1></td>
                    </tr>
                    <tr>
                        <td width="55%">
                            <table class="table table-striped">
                                <tr>
                                    <td>From:</td>
                                    <td><?php echo $order['feedbackfromemailaddress']; ?></td>
                                </tr>
                                <tr>
                                    <td>To:</td>
                                    <td><?php echo $order['buyeremail']; ?></td>
                                </tr>
                                <tr>
                                    <td>Subject:</td>
                                    <td><input type="text" name="subject" size="35" id="subjectline" value="<?php echo $subject; ?>" style="width: 95%" /></td>
                                </tr>
                                <tr>
                                    <td>Issue:</td>
                                    <td><?php echo $order['comments']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <table class="table table-striped">
                    <tr>
                        <td align="center"><textarea name="message" id="body_message1" rows="7" cols="75"><?php echo $message; ?></textarea></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="submit" value="Send Message" id="respond_message" class="btn btn-success" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="col-md-12" id="responseofmessage" >
    <img src="<?php echo base_url().'/images/load.gif';?>" id="loadImage" hidden>
    <h3><span class="" style="width: 100%; height:35px;" id="value"></span></h3>
</div>
<script>
    CKEDITOR.replace('body_message');
    CKEDITOR.replace('body_message1');
</script>
<script language="javascript">
      $(document).ready(function(){
         $('#respond_feedback').on("click", function (event) {
             $("#mailRequest").hide();
             $("#loadImage").removeAttr("hidden");
             event.preventDefault();
             toemailadd='<?php echo $order['buyeremail'] ?>';
             fromadd='<?php echo $order['feedbackfromemailaddress'] ?>';
             subject='<?php echo $subject; ?>';
             msg= CKEDITOR.instances.body_message.getData();
             loadurl='<?php echo site_url() ?>manage_feedback/send_nagative_feedback_remove_mail';
             $.ajax({ url: loadurl, type: 'POST',
                    data: { toemailadd: toemailadd, fromadd:fromadd, subject:subject, msg:msg,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
                    success: function (data) {
                        $("#loadImage").hide();
                        /*$("$loadImage").addClass("hidden");*/
                        var mailValue = JSON.parse(data);
                        if(mailValue.intValue>0){

                            $("#value").addClass("col-md-12 alert-success");
                            $("#value").html(mailValue.stringValue);
                            $('mailRequest').replaceWith('#responseofmessage');
                        }
                        else {
                            $("#value").addClass("col-md-12 alert-danger");
                            $("#value").html(mailValue.stringValue);
                            $('mailRequest').replaceWith('#responseofmessage');
                        }
                    }
             });
         });
      });
</script>
