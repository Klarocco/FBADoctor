<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-cog"></span><?php echo lang("ctn_608") ?></div>
        <div class="db-header-extra"> <a href="<?php echo site_url("user_settings/index") ?>" class="btn btn-success btn-sm"><?php echo lang("ctn_609") ?></a> </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><a href="<?php echo site_url("user_settings/index") ?>"><?php echo lang("ctn_224") ?></a></li>
        <li class="active"><?php echo lang("ctn587");?></li>
    </ol>

    <h4>Credit Card Details </h4>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <?php echo form_open('Subscription/update_creditcard/'.$billRow['ID_ACCOUNT'], array("class" => "form-horizontal", "id" => "paymentmethodadd")); ?>

                <div>
                    <span id="siteseal" style="margin-left:2%;"><script async="" type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=97UtzFR9OhHcmKsCdMRtKcF8qGgxA8zJhuoTeZdGzvBaO5K00ZCXDcwqQIEU"></script></span>
                </div>

                <span><font color="#FF0000" size="4px"><div class="payment-errors" align="center"></div></font></span><br>
                <div class="top-level-wrapper blue-theme-wrapper">
                    <section class="creditly-wrapper blue-theme">
                        <div class="credit-card-wrapper">
                            <div class="form-group">
                                <label for="Credit_Card_Number" class="col-sm-3 control-label label-heading asterisk"><?php echo lang("ctn_499") ?></label>
                                <div class="col-sm-9">
                                    <input id="cart_update" class="credit-card-number form-control" type="text"  name="Credit_Card_Number" data-stripe="number" pattern="(\d*\s){3}\d*" inputmode="numeric" autocomplete="cc-number" autocompletetype="cc-number" x-autocompletetype="cc-number" placeholder="&#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149;" onchange="changenumber()">
                                    <input id="cart" type="hidden"  name="Credit_Card_Number1" value="<?php echo $this->encrypt->decode($billRow['cardnumber']); ?>"/>
                                    <input id="cart_update1" type="hidden"  name="Credit_Card_Number2" data-stripe="number"  inputmode="numeric" autocomplete="cc-number" autocompletetype="cc-number" x-autocompletetype="cc-number"  value="<?php echo $this->encrypt->decode($billRow['cardnumber']); ?>"/>
                                </div>
                                <h3><div class="card-type" name="Payment" style="margin-right:390px;"></div></h3>
                            </div>

                            <div class="form-group">
                                <label for="cardsecuritycode" class="col-sm-3 control-label label-heading asterisk"><?php echo lang("ctn_500") ?></label>
                                <div class="col-sm-9">
                                    <input id="cvv_update" class="security-code form-control" inputmode="numeric" pattern="\d*" data-stripe="cvc" type="text" name="cardsecuritycode" placeholder="&#149;&#149;&#149;" value="<?php echo $this->encrypt->decode($billRow['cardsecuritycode']); ?>">
                                    <input id="cvv" type="hidden" name="cardsecuritycode1" value="<?php echo $this->encrypt->decode($billRow['cardsecuritycode']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cardholdername" class="col-sm-3 control-label label-heading asterisk"><?php echo lang("ctn_507") ?></label>
                                <div class="col-sm-9">
                                    <input class="billing-address-name form-control" type="text" name="cardholdername" placeholder="Name on Card" value="<?php echo $this->encrypt->decode($billRow['bill_firstname']).' '.$this->encrypt->decode($billRow['bill_lastname']) ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="expiremonth" class="col-sm-3 control-label label-heading asterisk"><?php echo lang("ctn_610") ?></label>
                                <div class="col-sm-4">
                                    <input id="month_update" class="expiration-month-and-year form-control" type="text" name="expiremonth" data-stripe="exp_month" maxlength="2" placeholder="MM" value="<?php echo $this->encrypt->decode($billRow['cardexpiremonth']) ?>">
                                    <input id="month" type="hidden" name="expiremonth1" value="<?php echo $this->encrypt->decode($billRow['cardexpiremonth']) ?>">
                                </div>
                                <div class="col-sm-5">
                                    <input id="year_update" class="expiration-month-and-year form-control" type="text" name="expireyear" data-stripe="exp_year" maxlength="4" placeholder="YYYY" value="<?php echo $this->encrypt->decode($billRow['cardexpireyear']) ?>">
                                    <input id="year"type="hidden" name="expireyear1" value="<?php echo $this->encrypt->decode($billRow['cardexpireyear']) ?>">
                                </div>
                            </div>

                        </div>
                    </section>
                </div>
                <input type="submit" class="submit form-control btn btn-success" value="<?php echo lang("ctn_13") ?>" id="add" name="add"/>
                <?php echo form_close() ?>

            </div>
        </div>

    </div>
</div>
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


    // This javascript use to credit card number display only four
    var cart = document.getElementById('cart');
    var cart_update = document.getElementById('cart_update');
    cart_update.value = new Array(cart.value.length-3).join('X') + cart.value.substr(cart.value.length-4,4);

    // This javascript use to credit card cvv number display *
    var cvv = document.getElementById('cvv');
    var cvv_update = document.getElementById('cvv_update');
    cvv_update.value = new Array(cvv.value.length+1).join('X');

    // This javascript use to credit card month display *
    var month = document.getElementById('month');
    var month_update = document.getElementById('month_update');
    month_update.value = new Array(month.value.length+1).join('X');

    // This javascript use to credit card year display *
    var year = document.getElementById('year');
    var yer_update = document.getElementById('year_update');
    year_update.value = new Array(year.value.length+1).join('X');


    // This function use to change card number and all filed in empty
    function changenumber()
    {
        value= $('#cart_update').val();
        $('#cart_update1').val(value);
        $('#cvv_update').val('');
        $('#month_update').val('');
        $('#year_update').val('');

    }
</script>