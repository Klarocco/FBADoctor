<style>
    .wp
    {
        white-space: pre-wrap; /* css-3 */
        white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
        white-space: -pre-wrap; /* Opera 4-6 */
        white-space: -o-pre-wrap; /* Opera 7 */
        word-wrap: break-word; /* Internet Explorer 5.5+ */
    }
</style>
<div class="white-area-content" id="amazon_connect_info">
    <ul id="wizard-header" class="stepy-header" style="display: table">
        <li id="wizard-head-1">
            <div class="col-md-6">Step 1<p style="font-size:15px"><?php echo lang("ctn_515") ?></p></div>
        <li id="wizard-head-2">
            <div class="col-md-6 desable" >Step 2<p style="font-size:15px"><?php echo lang("ctn_516") ?></p></div>
    </ul>
    <div class="db-header clearfix">
        <div class="page-header-title"><span class="glyphicon glyphicon-cog"></span> <?php echo lang("ctn_515") ?></div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">

                <?php echo form_open_multipart(site_url("feedback_setting/add_amazon_info"), array("class" => "form-horizontal", "id" => "amazon_setting_form")) ?>
                <ol>

                    <h2 align="center">2 simple steps and you're done;</h2><br>
                    <div class="row">
                        <div class="col-sm-4" style="margin-top: 10px;">
                            <li> click On <a href="https://sellercentral.amazon.com/gp/mws/registration/register.html"  target="_blank" class="wp">https://sellercentral.amazon.com/gp/mws/registration/register.html</a>
                                for the MWS registration page, click on the button labeled <strong>I want to authorize a
                                    developer to access my Amazon seller account with Amazon MWS</strong>.
                                <br>In the <strong>Developer's Name</strong> text box, type in <em>FBADoctor</em>.
                                <br>In the Developer Account Number text box, enter our MWS developer account identifier:
                                <strong>1164-2894-7953</strong>
                                <br>Click the <strong>Next</strong> button.
                            </li>
                        </div>
                        <div class="col-sm-8">
                             <img src="<?php echo base_url() . 'images/amazon_account_images/image-1.png'; ?>" class="img-responsive" height="85%" width="85%" style="margin-left: 50px;">
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-sm-4" style="margin-top: 10px;">
                            <li>Copy your account identifiers (Seller ID, MWS Authorization Token, and Marketplace ID) as we
                                need them in order to programmatically access your Amazon seller account.
                            </li>
                        </div>
                        <div class="col-sm-8">
                            <img src="<?php echo base_url() . 'images/amazon_account_images/image-2.png'; ?>" class="img-responsive" height="85%" width="85%" style="margin-left: 50px;">
                        </div>
                    </div>
                </ol>

                <div>
                    <h2 align="center">Enter the information step 2:</h2>
                </div>
                <br>

                <div class="form-group">
                    <label for="inputEmail3"
                           class="col-sm-2 control-label asterisk"><?php echo lang("ctn_347") ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="mws_sellerid"
                               value="<?php if (isset($mws_sellerid)) echo $mws_sellerid ?>"
                               class="form-control" id="mws_sellerid"/>
                        <label id="msg"></label>
                    </div>
                </div>

                <div class="form-group" style="display: none;">
                    <label for="inputEmail3"
                           class="col-sm-2 control-label asterisk"><?php echo lang("ctn_508") ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="mws_marketplaceid"
                               value="<?php if (isset($mws_marketplaceid)) echo $mws_marketplaceid ?>"
                               class="form-control"
                               id="mws_marketplaceid" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3"
                           class="col-sm-2 control-label asterisk"><?php echo lang("ctn_393") ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="mws_authtoken"
                               value="<?php if (isset($mws_authtoken)) echo $mws_authtoken ?>" class="form-control"
                               id="mws_authtoken"/>
                    </div>
                </div>
                <br>
                <input type="submit" name="testconnection" value="Test Amazon Credential" class="btn btn-success"  id="testconnection"/>
                <input type="submit" name="save" value="Save & Continue" class="btn btn-success "   id="savedata"/>
                <a href="<?php echo site_url('login/logout/' . $this->security->get_csrf_hash()) ?>"  class="btn btn-success" id="cancel"><?php echo lang("ctn_514") ?></a>
            </form>
            <?php //echo form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="amazoninstruction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Amazon account integration instructions</h4>
            </div>
            <div class="modal-body">
                <p class="view-result">
                <div class="alert alert-success">
                    <ol>
                        <li>Go to <a href="#">http://developer.amazonservices.com</a>
                        </li>
                        <li>Click the <strong>Sign up for MWS</strong> button.</li>
                        <li>Log in to your Amazon seller account.</li>
                        <li>On the MWS registration page, click on the button labeled <strong>I want to give a developer
                                access to my Amazon seller account with MWS</strong>.
                        </li>
                        <li>In the <strong>Developer's Name</strong> text box, type in <em>FBADoctor</em>.</li>
                        <li>In the Developer Account Number text box, enter our MWS developer account identifier:
                            <strong>1164-2894-7953</strong></li>
                        <li>Click the <strong>Next</strong> button.</li>
                        <li>Accept the Amazon MWS License Agreements and click the <strong>Next</strong> button.</li>
                        <li>Copy your account identifiers (Seller ID, MWS Authorization Token, and Marketplace ID) as we
                            need them in order to programmatically access your Amazon seller account.
                        </li>
                        <li>Paste your account identifiers into the Amazon Seller ID, Amazon Auth Token and Amazon
                            Marketplace ID fields at the top of this page and click TEST AMAZON CREDENTIAL.
                        </li>
                        <li>Follow the instractions just below the TEST AMAZON CREDENTIAL button and fill in the
                            remaining fields on this page.
                        </li>
                    </ol>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>
<div id="loadingContent"
     style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;">
    <img src='<?php echo base_url() . "images/loading.gif" ?>' width="64" height="64"/><br>Loading..
</div>
<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<script>
    $('#testconnection').click(function (e) {

        var sellerId = $('#mws_sellerid').val();
        if(sellerId == '')
        {
            $('#msg').html();
        }
        else {
            $("#loadingContent").css("display", "block");
            $.ajax({
                url: '<?php echo site_url() ?>feedback_setting/test_amazon_amazonconnection',
                type: 'POST',
                data: $("form").serialize(),
                dataType: "html",
                success: function (data) {
                    $("#loadingContent").css("display", "none");
                    if (data == 1) {
                        swal("", "Amazon credential is valid", "success");
                        $("#savedata").show();
                    }
                    else {
                        swal("", data, "error");
                    }
                }
            });
            return false;
        }
    });
    $('#cancel').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
                title: "Confirm",
                text: "Are you sure you want to cancel signup?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Done!',
                cancelButtonText: "Cancel!",
                confirmButtonClass: "btn-danger",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    swal("Done!", "Your sign up cancelled!", "success");
                    window.location.replace(url);
                } else {
                    swal("Cancel", "Cancelled! :)", "error");
                }
            });
    });


</script>
