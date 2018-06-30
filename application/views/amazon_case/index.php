<div class="form-group">
    <?php if($this->session->flashdata('success')){?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success')?><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php }?>
    <?php if($this->session->flashdata('danger')) { ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('danger')?><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php } ?>
    <label id="msg" name="msg" class="msg"></label>
</div>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-dollar"></span> <?php echo lang("ctn_549") ?></div>
    </div>
    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span></div>
        <?php } unset($_SESSION['errors']); ?>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_560") ?></a></li>
        <li class="active"><?php echo lang("ctn_549") ?></li>
    </ol>
    <hr>
    <div id="first">
        <table id="example" class="display" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th></th>
                <th><?php echo lang("ctn_25") ?></th>
                <th><?php echo lang("ctn_346") ?></th>
                <th>Total Cases</th>
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
                <div id="first" class="table-responsive">
                    <table id="caseDetails" class="display responsive" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Case Type</th>
                            <th>#. Of Case's</th>
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
        var baseURL = '<?php echo site_url() . 'Amazon_case/show_detail' ?>';
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result)
            {
                var detail = jQuery.parseJSON(result);
                var userdetail = detail.data;

                $(document).ready(function(){
                    $.noConflict();
                    var table = $('#example').DataTable(
                    {
                            responsive :
                            {
                              details : false
                            },
                            data : userdetail,
                            'columns':
                            [{
                               'targets': 0,
                               'title': '',
                               'sortable': false,
                               "paginate": false,
                               'class': 'details-control',
                               'data': function ()
                               {
                                   return '';
                               }
                           },{
                               'targets': 1,
                               'title': "Username",
                               'render': function (data, type, row) {
                                   return '<input type="hidden" id="id" name="id" value="'+row.ID_ACCOUNT+'"><span class="status status-' + (row.username).toLowerCase() + '">' + row.username + '</span>';
                               }

                           },{

                               'targets': 2,
                               'title': "Email Address",
                               'render': function (data, type, row) {
                                   return '<span class="status status-' + (row.email).toLowerCase() + '">' + row.email + '</span>';
                               }
                           },{

                               'targets': 3,
                               'title': "Total Cases",
                               'render': function (data, type, row) {
                                   return '   <span class="status status-' + row.totalCases + '">' + row.totalCases + '</span>';
                               }
                           }],

                        "order": [[2, 'asc']]
                    } );

                    $('#example tbody').on('click', 'td.details-control', function () {
                        var tr = $(this).closest('tr');
                        var id = $(this).closest('tr').find('input[name="id"]').val();
                        var row = table.row( tr );

                        if(row.child.isShown() ) {
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else {
                            row.child( format(row.data(),id)).show();
                            tr.addClass('shown');
                        }
                    } );

                });
            }
        });
    }

    function format (d,id)
    {
        var table = '<table class="display innerTable " id="'+id+'" cellpadding="5" cellspacing="0" border="0" style="float: right;" width="100%">' +
            '<thead>'+
            '<tr>' +
            '<th>Case type</th>' +
            '<th>No of Cases</th>' +
            '<th>Action</th>' +
            '</tr>'+
            '</thead>'+
            '<tbody>';

        for(var records in d.caseDetails)
        {
            var totCount = d.caseDetails[records].totCount;
            var case_type = id+"/"+d.caseDetails[records].case_type;
            var AorTotal = d.caseDetails[records].case_type;
            var url = '<?php echo site_url() . 'Amazon_case/generateCasesByIdAndType/'?>'+case_type;
            var AorUrl = '<?php echo site_url() . 'Amazon_case/AorGeneratecase/'?>'+case_type;

            if(totCount>0)
            {
                if (AorTotal == 'AOR')
                {
                    table += '<tr><td>' + d.caseDetails[records].case_type + '</td><td>' + d.caseDetails[records].totCount + '</td><td><a href="' + AorUrl + '" class="btn btn-success btn-md">Generate Case</a></td></tr>';
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

</script>


