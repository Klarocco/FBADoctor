<div class="form-group">
    <?php if($this->session->flashdata('success')){?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success')?> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php }?>

    <?php if($this->session->flashdata('danger')) { ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('danger')?> <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php } ?>
    <label id="msg" name="msg" class="msg"></label>
</div>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-tasks"></span> <?php echo lang("ctn_579") ?></div>
    </div>
    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span></div>
        <?php } unset($_SESSION['errors']); ?>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_571") ?></a></li>
        <li class="active"><?php echo lang("ctn_579") ?></li>
    </ol>
    <hr>
    <div id="first">
        <table id="userDetails" class="display" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo lang("ctn_25") ?></th>
                    <th><?php echo lang("ctn_346") ?></th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal fade"  id="show_type_case" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ShowCASEType">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Case Type Available.</h4>
            </div>
            <div class="modal-body show_type_case">
                <div id="first">
                    <table id="caseDetails" class="display" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Case Type</th>
                            <th>#. Of Quantity's</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="" name="account_Id" id="account_Id">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
            </div>
        </div>
    </div>
    <div id="loading_Content" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
<script>

    (function()
    {
        new Clipboard('#copy-button');
    })();

</script>

<script language="javascript">

    $(document).ready(function()
    {
        var myCheckboxes = new Array();
        $("input:checked").each(function() {
            myCheckboxes.push($(this).val());
        });
        if(myCheckboxes.length==0){
            $('#noSelect').append("<li><div class='col-md-12'>No Data Selected.</div></li>");
        }
        $('#subTotal').val(0);
        $('[data-dismiss=modal]').on('click', function (e) {
            $("#selected_items").html('');
        });
    });

</script>
<script>

    $(document).ready(function()
    {
        setTimeout(function()
        {
            loadajax();
        },10);

    });

    function loadajax()
    {
        var baseURL = '<?php echo site_url() . 'Inventory_salvager/show_detail' ?>';
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result)
            {
                var detail = jQuery.parseJSON(result);
                var userdetail = detail.data;
                $(document).ready(function(){
                    $.noConflict();
                    var table = $('#userDetails').DataTable(
                        {
                            responsive:
                            {
                                details: false
                            },
                            data : userdetail,
                            'columns': [{
                                'targets': 0,
                                'title': '',
                                'sortable': false,
                                "paginate": false,
                                'class': 'details-control',
                                'data': function () {
                                    return '';
                                }
                            },{
                                'targets': 1,
                                'title': "Username",
                                'render': function (data, type, row) {
                                    return '<input type="hidden" id="uid" name="uid" value="'+row.ID_ACCOUNT+'"><span class="status status-' + (row.username).toLowerCase() + '">' + row.username + '</span>';
                                }

                            },{

                                'targets': 2,
                                'title': "Email Address",
                                'render': function (data, type, row) {
                                    return '<span class="status status-' + (row.email).toLowerCase() + '">' + row.email + '</span>';
                                }
                            },{

                                'targets': 3,
                                'title': "Total Quantity",
                                'render': function (data, type, row) {
                                    return '<span class="status status-' + row.quantity + '">' + row.quantity + '</span>';
                                }
                            }],

                            "order": [[2, 'asc']]
                        } );


                    $('#userDetails tbody').on('click', 'td.details-control', function ()
                    {
                        var tr = $(this).closest('tr');
                        var id = $(this).closest('tr').find('input[name="uid"]').val();
                        var row = table.row( tr );

                        if(row.child.isShown())
                        {
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else
                        {
                            row.child(format(row.data(),id)).show();
                            tr.addClass('shown');
                        }
                    });
                });
            }
        });
    }

    function format(d,id)
    {
        var  table = '<table class="display innerTable" id="'+id+'" cellpadding="5" cellspacing="0" border="0" style="float: right;" width="100%">' +
            '<thead>'+
            '<tr>'+
            '<th>Case type</th>' +
            '<th>No of Quantity</th>' +
            '<th>Action</th>' +
            '</tr>'+
            '</thead>'+
            '<tbody>';

            for(var records in d.caseDetails)
            {
                var totCount = d.caseDetails[records].totCount ;
                var case_type = id+"/"+d.caseDetails[records].case_type ;
                var asidTotal = d.caseDetails[records].case_type;
                var url = '<?php echo site_url() . 'Inventory_salvager/generateCasesByIdAndType/'?>' + case_type;
                var AsidUrl = '<?php echo site_url() . 'Inventory_salvager/AsidGeneratecase/'?>' + case_type;
                if(totCount > 0)
                {
                     if (asidTotal == 'ASID')
                     {
                         table += '<tr><td>' + d.caseDetails[records].case_type + '</td><td>' + d.caseDetails[records].totCount + '</td><td><a href="' + AsidUrl + '" class="btn btn-success btn-md">Generate Case</a></td></tr>';
                     }
                     else
                     {
                         table += '<tr><td>' + d.caseDetails[records].case_type + '</td><td>' + d.caseDetails[records].totCount + '</td><td><a href="' + url + '" class="btn btn-success btn-md">Generate Case</a></td></tr>';
                     }
                }
                else
                {
                    table += '<tr><td>' + d.caseDetails[records].case_type + '</td><td>' + d.caseDetails[records].totCount + '</td><td>No cases generated</td></tr>';
                }
            }
            table+='</tbody>'+'</table>';
            return table;
    }


    $('#addCaseId').click(function ()
    {
        if (jQuery("#addCase_Id").valid())
        {
            $("#loadingContent").css("display","block");
            var accountId = $('#account_ID').val();
            var caseId = $('#caseId').val();
            var date = $('#date').val();
            var myCheckboxes = new Array();
                $("input:checked").each(function()
                {
                    myCheckboxes.push($(this).val());
                });
                if(myCheckboxes.length==0)
                {
                    $("#loadingContent").css("display", "none");
                    $('#message').remove();
                    $('.generateCaseMessage').append("<div class='alert alert-danger' style='margin-top:25px;margin-bottom:0px;' id='message'>Please Select At least One Transaction Item Id.</div>");
                    setTimeout(function () {$("#message").hide();}, 4000);return false;
                }

            var subTotal = parseInt($('#subTotal').val());
            var dataValue = new Array();
            var flag =1;
                for(count=0;count<=subTotal;count++)
                {
                    dataValue[count] = $('.'+flag).val();
                    flag++;
                }

            var baseURL = '<?php echo site_url(). 'inventory_salvager/createInventoryCaseId/' ?>';
            $.ajax
            ({
                type: "POST",
                url: baseURL,
                data: {myCheckboxes:myCheckboxes,accountId:accountId,caseId:caseId,date:date,dataValue:dataValue},
                success: function (result)
                {
                    if (result)
                    {
                        setTimeout(function()
                        {
                            $("#loadingContent").css("display", "none");
                            window.location.reload();
                        }, 1000);
                    }
                }
            });
        }
    });
</script>

<link rel="stylesheet" href="<?php echo base_url() . "styles/datepicker.css"; ?>">
<script type="text/javascript" src="<?php echo base_url() . "scripts/datePicker.js"; ?>"></script>
<script>
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    $('#date').datepicker({
        endDate: new Date(),
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    function removeoldexist()
    {
        $('#selected_items > li').remove();
    }



</script>
