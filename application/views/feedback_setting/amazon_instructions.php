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
<div class="white-area-content">
        <div class="db-header clearfix">
        <div class="page-header-title"><span class="fa fa-cogs"></span> Amazon account integration instructions</div>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_224") ?></li>
        <li class="active"><?php echo lang("ctn_344") ?></li>
        <li class="active">Amazon account integration instructions</li>
    </ol>
    <p>Amazon account integration instructions</p>
    <hr>
    <div class="panel panel-default">
        <div class="panel-body">
            <ol>

                <li> click On  <a href="https://sellercentral.amazon.com/gp/mws/registration/register.html" target="_blank" class="wp">https://sellercentral.amazon.com/gp/mws/registration/register.html</a> for the MWS registration page, click on the button labeled <strong>I want to authorize a developer to access my Amazon seller account with Amazon MWS</strong>.
                    <br>In the <strong>Developer's Name</strong> text box, type in <em>FBADoctor</em>.
                    <br>In the Developer Account Number text box, enter our MWS developer account identifier: <strong>1164-2894-7953</strong>
                    <br>Click the <strong>Next</strong> button.
                    <br><img src="<?php echo base_url(). 'images/amazon_account_images/step-3.PNG'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;">
                </li>
                <li>Accept the Amazon MWS License Agreements and click the <strong>Next</strong> button.
                    <br><img src="<?php echo base_url(). 'images/amazon_account_images/step-4.PNG'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;">
                </li>
                <li>Copy your account identifiers (Seller ID, MWS Authorization Token, and Marketplace ID) as we need them in order to programmatically access your Amazon seller account.
                    <br><img src="<?php echo base_url(). 'images/amazon_account_images/step-5.PNG'; ?>" style="margin: 20px 0; max-width: 100%; height: auto;">
                </li>
                <li>Paste your account identifiers into the Amazon Seller ID, Amazon Auth Token and Amazon Marketplace ID fields at the top of Amazon Store Settings and click TEST AMAZON CONNECTION.</li>
                <li>Follow the instractions just below the TEST AMAZON CONNECTION button and fill in the remaining fields on this page.</li>
            </ol>

        </div>
    </div>
</div>
