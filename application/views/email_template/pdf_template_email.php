<html>
<head></head>
<body>

<table width='100%'>
    <tr>
        <td width='30%'>Bill To,<br><?php echo $detail['first_name']." ".$detail['last_name']."<br>".$detail['billaddress']."<br>Phone: ".$detail['phone']."<br>Email: ".$detail['email']?>
        Invoice <?php echo $detail['invoice_id']; ?><br> <br> Payment Date <?php echo $detail['date'] ?></td>
    </tr>
</table>
<br>
<br>
<table width='80%' border="1">
    <tr>
        <th width='70%'>Description</th>
        <th width='30%'>Amount</th>
    </tr>
    <?php
    $total_amount=0;
    foreach ($charge_detail as $charge_details) : ?>
    <tr>
        <td width='70%'>This is charge of reimburse which  case id <?php echo $charge_details['caseid']; ?></td>
        <td width='30%' align="right"><?php echo "$ ".$charge_details['amount']; ?></td>
        <?php $total_amount+=$charge_details['amount']; ?>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td width="70%">Commission</td>
        <td width="30%" align="right"><?php if($commission > 0 ) { echo "0 $ ".$commission; } else { echo "0"; }?></td>
    </tr>
    <?php $total_amount=$total_amount-$commission;?>
    <tr>
        <th>Total Amount</th>
        <th><?php echo "$ ". $total_amount;?></th>
    </tr>
</table>
<br>
<br>
<table width='100%'>
    <br>
    <br>
    <tr>
        <td width='100%'>Thank you for your business - we appreciate it very much.</td>
    </tr>
</table>
<br>
<br>
<table width='100%'>
    <tr>
        <td><img src="<?php echo base_url().'images/logo.png' ?>"></td>
    </tr>
</table>
FBADoctor.<br>
<a href="www.FBADoctor.com"; ?>www.FBADoctor.com</a><br>
</body>
</html>