<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-home"></span> <?php echo lang("ctn_526") ?></div>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_526") ?></li>
    </ol>

   <br>
    <div class="material-switch">
        <input id="someSwitchOptionSuccess" type="checkbox" value="1" class="checkboxSuccess" name="checkboxSuccess" id="checkboxSuccess">&nbsp;
        <label for="someSwitchOptionSuccess" class="label-success"></label>&nbsp; &nbsp;
        <lable class="feedbackEnableDisable">Case Details</lable>&nbsp;<br><br>
     </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div id="chart-container"></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div id="second">
        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <a href="<?php echo site_url('feedback_setting') ?>" class="btn btn-success">Setting</a>
            <a href="<?php echo site_url('affiliate/AffiliateInviteFriend') ?>" class="btn btn-success">Tell A Friend</a>
            <a href="#" class="btn btn-success">Contact us</a>
        </div>
    </div>
</div>

<?php $reimbursement = array_reverse($reimbursement); ?>
<?php  $data = array_reverse($thirtyDaYTotal);  ?>


<?php

$yms = array();
$now = date('Y-M');
for($x=11; $x>=0; $x--)
{
    $ym = date('Y-M', strtotime($now . " -$x month"));
    $yms['month'][] = $ym;
}
?>

<script type="text/javascript">
    $(".checkboxSuccess").change(function()
    {
        if(this.checked)
        {
            $("#second").append('<div class="col-md-12" id="casedetailenable"><div class="box box-primary"><div class="box-body box-profile"><ul class="list-group list-group-unbordered"><li class="list-group-item"><b>Cases We OPened </b> <a class="pull-right"><?php echo $totalUserCase; ?></a></li><li class="list-group-item"><b>Recovered Funds Last Month</b> <a class="pull-right"><?php echo $totallastmonthamount; ?></a></li><li class="list-group-item"><b>Total Recovered</b> <a class="pull-right"><?php echo $totalAmount; ?></a></li></ul></div></div>');
        }
        else
        {
            $("#casedetailenable").remove();
        }
    });

    $('.checkboxInfo').change(function()
    {
        if(this.checked)
        {
            $("#second").append('<div class="col-md-6" id="feedbackenabledisable"><div class="small-box bg-yellow"><div class="inner"><h3><?php echo $totalUserFeedback;  ?></h3><p>List Of Removed Feedback</p></div><div class="icon"><i class="ion ion-person-add"></i></div><a href="<?php echo site_url('manage_feedback/display_neutral_feedback') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a></div></div>');
        }
        else
        {
            $("#feedbackenabledisable").remove();
        }
    });
</script>

<script src="<?php echo base_url() ?>scripts/fusioncharts.js"></script>
<script src="<?php echo base_url() ?>scripts/fusioncharts.charts.js"></script>
<script>

    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'stackedcolumn2dline',
            renderAt: 'chart-container',
            width: "100%",
            height: "700",
            dataSource: {
                "chart": {
                    "caption": "Total sale and reimburse in 2017",
                    "xAxisname": "Month",
                    "yAxisName": "(In USD)",
                    "numberPrefix": "$",
                    "paletteColors": "#1aaf5d,#0075c2,#f2c500,#1aaf5d",
                    "bgColor": "#ffffff",
                    "borderAlpha": "20",
                    "showCanvasBorder": "0",
                    "usePlotGradientColor": "0",
                    "plotBorderAlpha": "10",
                    "legendBorderAlpha": "0",
                    "legendShadow": "0",
                    "legendBgAlpha": "0",
                    "valueFontColor": "#ffffff",
                    "showXAxisLine": "1",
                    "xAxisLineColor": "#999999",
                    "divlineColor": "#999999",
                    "divLineIsDashed": "1",
                    "showAlternateHGridColor": "0",
                    "subcaptionFontBold": "0",
                    "subcaptionFontSize": "14",
                    "showHoverEffect":"1"
                },
                "categories": [
                    {
                        "category": [
                            {
                                "label": "<?php print_r($yms['month'][0]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][1]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][2]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][3]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][4]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][5]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][6]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][7]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][8]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][9]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][10]); ?>"
                            },
                            {
                                "label": "<?php print_r($yms['month'][11]); ?>"
                            }
                        ]
                    }
                ],
                "dataset": [
                    {
                        "seriesname": "Total Recovered",
                        "data": [
                            {
                                "value": "<?php print_r($reimbursement[0]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[1]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[2]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[3]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[4]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[5]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[6]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[7]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[8]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[9]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[10]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[11]['amount_total']); ?>"
                            }
                        ]
                    },
                    {
                        "seriesname": "30 Day sales",
                        "data": [
                            {
                                "value":    "<?php print_r($data[0]['itemprice']); ?>"
                            },
                            {
                                "value":    "<?php print_r($data[1]['itemprice']); ?>"
                            },
                            {
                                "value":    "<?php print_r($data[2]['itemprice']); ?>"
                            },
                            {
                                "value":    "<?php print_r($data[3]['itemprice']); ?>"
                            },
                            {
                                "value":    "<?php print_r($data[4]['itemprice']); ?>"

                            },
                            {
                                "value":    "<?php print_r($data[5]['itemprice']); ?>"

                            },
                            {
                                "value":    "<?php print_r($data[6]['itemprice']); ?>"

                            },
                            {
                                "value":    "<?php print_r($data[7]['itemprice']); ?>"

                            },
                            {
                                "value":    "<?php print_r($data[8]['itemprice']); ?>"

                            },
                            {
                                "value":    "<?php print_r($data[9]['itemprice']); ?>"

                            },
                            {
                                "value":    "<?php print_r($data[10]['itemprice']); ?>"
                            },
                            {
                                "value":    "<?php print_r($data[11]['itemprice']); ?>"
                            }
                        ]
                    },
                    {
                        "seriesname": "Good Stuff",
                        "renderAs": "line",
                        "showValues": "0",
                        "valuePosition":"BELOW",
                        "data": [
                            {
                                "value": "<?php print_r($reimbursement[0]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[1]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[2]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[3]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[4]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[5]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[6]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[7]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[8]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[9]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[10]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($reimbursement[11]['amount_total']); ?>"
                            }
                        ]
                    },
                    {
                        "seriesname": "Better Stuff",
                        "renderAs": "line",
                        "showValues": "0",
                        "valuePosition":"BELOW",
                        "data": [
                            {
                                "value": "<?php print_r($data[0]['itemprice'] + $reimbursement[0]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[1]['itemprice'] + $reimbursement[1]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[2]['itemprice'] + $reimbursement[2]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[3]['itemprice'] + $reimbursement[3]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[4]['itemprice'] + $reimbursement[4]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[5]['itemprice'] + $reimbursement[5]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[6]['itemprice'] + $reimbursement[6]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[7]['itemprice'] + $reimbursement[7]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[8]['itemprice'] + $reimbursement[8]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[9]['itemprice'] + $reimbursement[9]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[10]['itemprice'] + $reimbursement[10]['amount_total']); ?>"
                            },
                            {
                                "value": "<?php print_r($data[11]['itemprice'] + $reimbursement[11]['amount_total']); ?>"
                            }
                        ]
                    },
                    {
                        "seriesname": "Amazon Fee",
                        "renderAs": "line",
                        "showValues": "0",
                        "color": "#CC0000",
                        "valuePosition":"BELOW",
                        "data": [
                            {
                                "value": "<?php print_r($amazon_fee[0]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[1]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[2]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[3]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[4]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[5]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[6]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[7]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[8]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[9]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[10]['shippingprice']); ?>"
                            },
                            {
                                "value": "<?php print_r($amazon_fee[11]['shippingprice']); ?>"
                            }
                        ]
                    }
                ]
            }
        }).render();
    });

</script>

