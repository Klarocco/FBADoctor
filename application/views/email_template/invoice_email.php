<html>
<head></head>
<body>
<?php
$total_amount = 0;
foreach ( $charge_detail as $charge_details ) : ?>
	<?php $total_amount += $charge_details['amount']; ?>
<?php endforeach; ?>

<?php
$total = 0;
foreach ( $charge_detail as $details ) : ?>
    <?php $total += $details['total_amount']; ?>
<?php endforeach; ?>

<?php $final_amount = $total_amount - $commission; ?>
<table width='100%'>
    <tr>
        <td width='100%'>Dear <?php echo $detail['first_name'] . " " . $detail['last_name'] ?></td>
    </tr>
</table>
<br>
<br>
<table width='100%'>
    <tr>
        <td width='100%'>We are happy we were able to recover you $ <?php echo $total ?> from Amazon.
        </td>
    </tr>
</table>
<table width='100%'>
    <br>
    <tr>
        <td width='100%'>Please see the attached Invoice for FBADoctor. All payments to date were deducted from final
            amount due. Your
            card ending in <?php echo 'XXXX-XXXX-XXXX-' . $customercard; ?> will be charged $<?php echo $final_amount ?>
            and
            will show on your Credit card statement as a charge from RobinHoodRetruns.
        </td>
    </tr>
    <br>
</table>
<table width='100%'>
    <tr>
        <td width='100%'>To see the details of all the cases we have created and got reimbursements, please login to
            your account and
            click on the generated cases tab. You can click on each case number to see the exact details per case.
        </td>
    </tr>
</table>
<br>
<table width='80%' border="1">
   <tr>
        <td width='70%'>Total case </td>
        <td width='30%' align="right"><?php print_r($totalusercase[0]['CountAccountID']); ?></td>
    </tr>
    <tr>
        <td width="70%">Amount</td>
        <td width="30%" align="right"><?php print_r('$'.$totalusercase[0]['UserTotalAmount']); ?></td>
    </tr>
</table>
<br>
<table width='100%'>
    <br>
    <br>
    <tr>
        <td width='100%'><a href="<?php echo site_url() . 'amazon_case/orderTrackingInfo' ?>">Visit your account to see your cases</a></td>
    </tr>
</table>
<br>
<table width='100%'>
    <br>
    <br>
    <tr>
        <td width='100%'>Thank you for your business - we appreciate it very much.</td>
    </tr>
</table>
<br>
<table width='100%'>
    <tr>
        <td><img src="http://robinhoodreturns.amzsellersengine.com/images/logo.png" class="user-image " alt="User Image"></td>
    </tr>
</table>
FBADoctor.<br>
<a href="www.FBADoctor.com"; ?>www.FBADoctor.com</a><br>
</body>
</html>