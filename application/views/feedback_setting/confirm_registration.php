<div class="white-area-content col-md-12">
    <ul id="wizard-header" class="stepy-header" style="display: table">
        <li id="wizard-head-1"><div class="col-md-6 desable">Step 1<p style="font-size:15px"><?php echo lang("ctn_515")?></p></div>
        <li id="wizard-head-3"><div class="col-md-6">Step 2<p style="font-size:15px"><?php echo lang("ctn_516")?></p></div>
    </ul>

    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span>
            </div>
        <?php } unset($_SESSION['errors']); ?>
    </div>

    <div class="form-group">
        <?php if (isset($_SESSION['errormsg'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errormsg']; ?></font></span>
            </div>
        <?php } unset($_SESSION['errormsg']); ?>
    </div>

    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-cog"></span> <?php echo lang("ctn_516") ?></div>
    </div>

        <?php echo form_open('Subscription/add_paymentinfo', array("class" => "form-horizontal", "id" => "paymentmethodadd")); ?>

    <div class="row">
        <div class="col-md-12 hidden-xs">
                <h4>Why Must I Provide a Credit Card?:</h4>
                <p>We ask for a credit card, so we can provide the most convenient process possible for customers. Most people using FBADoctor are on paid charges, so collecting the billing information upfront expedites the process for them.</p>
                <img src="<?php echo base_url(); ?>/images/ccLogos.png" width="250">

        </div>
    </div><hr>

    <div class="row">
        <div class="col-md-6">
            <h4>User Details </h4>
            <hr>
            <div class="form-group">
                <label  class="col-md-2 control-label asterisk"><?php echo lang("ctn_78") ?></label>
                <div class="col-md-5"><input name="email"   id="email" value="<?php if(isset($user_detail['email'])) echo $user_detail['email'] ?>" class="form-control" readonly/></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo lang("ctn_376") ?></label>
                <div class="col-md-5"><input name="phone"  id="phone" value="<?php if(isset($billRow['bill_phone'])) echo $billRow['bill_phone'] ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label asterisk"><?php echo lang("ctn_371") ?></label>
                <div class="col-md-5"><input name="address"  id="address" value="<?php if(isset($billRow['bill_address'])) echo $billRow['bill_address'] ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label asterisk"><?php echo lang("ctn_372") ?></label>
                <div class="col-md-5"><input type="text" name="city"  id="city" value="<?php if(isset($billRow['bill_city'])) echo $billRow['bill_city'] ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label asterisk"><?php echo lang("ctn_373") ?></label>
                <div class="col-md-5"><input type="text" name="state" value="<?php if(isset($billRow['bill_region'])) echo $billRow['bill_region'] ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label asterisk"><?php echo lang("ctn_374") ?></label>
                <div class="col-md-5"><input maxlength="15" name="zip" value="<?php if(isset($billRow['bill_zip'])) echo $billRow['bill_zip'] ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label"><?php echo lang("ctn_375") ?></label>
                <div class="col-md-5"><input type="text" name="country" value="<?php if(isset($billRow['bill_country'])) echo $billRow['bill_country'] ?>" class="form-control"/></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
            <h4>Credit Card Details </h4>
            <hr>
            <div class="top-level-wrapper blue-theme-wrapper">
                <section class="creditly-wrapper blue-theme">
                    <div class="credit-card-wrapper">
                        <span><font color="#FF0000"><h4><div class="payment-errors" align="center"></div></h4></font></span><br>
                        <div class="first-row form-group">
                            <label for="Credit_Card_Number" class="col-sm-6 control-label label-heading asterisk"><?php echo lang("ctn_499") ?></label>
                            <div class="col-sm-6">
                                <input class="credit-card-number form-control" type="text" name="Credit_Card_Number" data-stripe="number" pattern="(\d*\s){3}\d*" inputmode="numeric" autocomplete="cc-number" autocompletetype="cc-number" x-autocompletetype="cc-number" placeholder="&#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149;" >
                            </div>
                        </div>
                        <h3 align="center"><div class="card-type" name="Payment" style="margin-top:-10px; margin-bottom: 10px; margin-right: 30px;"></div></h3>
                        <div class="form-group">
                            <label for="cardsecuritycode" class="col-sm-6 control-label label-heading asterisk"><?php echo lang("ctn_500") ?></label>
                            <div class="col-sm-6">
                                <input class="security-code form-control" inputmode="numeric" pattern="\d*" data-stripe="cvc" type="text" name="cardsecuritycode" placeholder="&#149;&#149;&#149;" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cardholdername" class="col-sm-6 control-label label-heading asterisk"><?php echo lang("ctn_507") ?></label>
                            <div class="col-sm-6">
                                <input class="billing-address-name form-control" type="text" name="cardholdername" placeholder="Name on Card" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="expiremonth" class="col-sm-6 control-label label-heading asterisk"><?php echo lang("ctn_610") ?></label>
                            <div class="col-sm-6">
                                <input class="expiration-month-and-year form-control" type="text" name="expiremonth" data-stripe="exp_month" maxlength="2" placeholder="MM" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="expireyear" class="col-sm-6 control-label label-heading asterisk"><?php echo lang("ctn_619") ?></label>
                            <div class="col-sm-6">
                                <input class="expiration-month-and-year form-control" type="text" name="expireyear" data-stripe="exp_year" maxlength="4" placeholder="YYYY" >
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            </div>
            <span id="siteseal" style="margin-left:150px;"><script async="" type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=97UtzFR9OhHcmKsCdMRtKcF8qGgxA8zJhuoTeZdGzvBaO5K00ZCXDcwqQIEU"></script></span>
        </div>
    </div>

    <div class="row" align="center">
        <a href="<?php echo site_url('feedback_setting/add_amazon_info') ?>" class="btn btn-success"><?php echo lang("ctn_135") ?></a>
        <input type="submit" class="submit btn btn-success" value="<?php echo lang("ctn_61") ?>" id="add" name="add" onclick="cardFormValidate()"/>
        <a href="<?php echo site_url('login/logout/' . $this->security->get_csrf_hash()) ?>" class="btn btn-success" id="cancel"><?php echo lang("ctn_514") ?></a>
    </div>
    <?php echo form_close() ?>
</div>
<script>
    $('#cancel').on('click', function(e) {
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
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal("Done!", "Your sign up cancel!", "success");
                    window.location.replace(url);
                } else {
                    swal("Cancel", "Cancelled! :)", "error");
                }
            });
    });

</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    var publickey='<?php echo publishable_key ?>';
    Stripe.setPublishableKey(publickey);

    $(function () {
        var $form = $('#paymentmethodadd');
        $form.submit(function (event) {
// Disable the submit button to prevent repeated clicks:
            $form.find('.submit').prop('disabled', true);

// Request a token from Stripe:
            Stripe.card.createToken($form, stripeResponseHandler);

// Prevent the form from being submitted:
            return false;
        });
    });

    function stripeResponseHandler(status, response) {
        var $form = $('#paymentmethodadd');
        if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message);

            $form.find('.submit').prop('disabled', false);
        } else {
            // response contains id and card, which contains additional card details
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            // and submit
            $form.get(0).submit();
        }
    }
</script>
<script>
    $("document").ready(function () {
    });

</script>

<script type="text/javascript">
    $(function() {
        // For the blue theme
        var blueThemeCreditly = Creditly.initialize(
            '.creditly-wrapper.blue-theme .expiration-month-and-year',
            '.creditly-wrapper.blue-theme .credit-card-number',
            '.creditly-wrapper.blue-theme .security-code',
            '.creditly-wrapper.blue-theme .card-type');

        $(".creditly-blue-theme-submit").click(function(e) {
            e.preventDefault();
            var output = blueThemeCreditly.validate();
            if (output) {
                // Your validated credit card output
                console.log(output);
            }
        });
    });
</script>