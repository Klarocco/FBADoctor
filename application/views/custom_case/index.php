<div class="form-group">
    <?php if($this->session->flashdata('danger')) { ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('danger')?><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
    <?php } ?>
</div>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title">
            <i class="fa fa-gavel" aria-hidden="true"></i> <?php echo lang("ctn_623") ?>
        </div>
    </div>

    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span></div>
        <?php } unset($_SESSION['errors']); ?>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_623") ?></a></li>
        <li class="active"><?php echo lang("ctn_624") ?></li>
    </ol>
    <hr>

    <div class="row" style="margin:15px;">
        <?php echo form_open('custom_case/Customcasegeneration', array("class" => "form-horizontal", "id" => "addCase_Id")); ?>
        <div class="col-md-10">
            <div class="form-group">
                <label for="case_Id" class="col-md-2 label-heading">Case Id</label>
                <div class="col-md-10">
                    <input type="text" class="form-control textbox" id="case_Id" name="case_Id" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label for="date" class="col-md-2 label-heading">Case Date</label>
                <div class="col-md-10">
                    <input type="date" class="form-control textbox" id="caseDate" name="caseDate" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label for="amount" class="col-md-2 label-heading">Amount</label>
                <div class="col-md-10">
                    <input type="text" class="form-control textbox" id="amount" name="amount" value="" required placeholder="$99.99">
                </div>
            </div>
            <div class="form-group">
                <label for="date" class="col-md-2 label-heading">Select user</label>
                <div class="col-md-4">
                    <select class="form-control" name="select_user" id="select_user">
                        <option value="">Please select user</option>
                        <?php foreach($alluser as $result) : ?>
                            <option id="<?php echo $result['ID_ACCOUNT'] ?>" value="<?php echo $result['ID_ACCOUNT'] ?>"><?php echo $result['username']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="subject" class="col-md-2 label-heading">Subject</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="subject" id="subject" value="">
                </div>
            </div>
            <div class="from-group">
                <div id="amazonDeniedReason">
                    <label for="date" class="col-md-2 label-heading" style="margin-left: -15px;">Custome Case</label>
                    <div class="col-md-10">
                        <textarea class="form-control" id="custom_case" name="custom_case" value="" required style="color: #0F192A"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer generateData">
        <input type="submit" class="btn btn-success" value="Generate Case" id="addCaseId" name="addCaseId" style="margin-right: 100px;">
        <?php echo form_close() ?>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url() . "styles/datepicker.css"; ?>">
<script type="text/javascript" src="<?php echo base_url() . "scripts/datePicker.js"; ?>"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $("document").ready(function()
    {
        $("#addCase_Id").validate(
            {
                rules :
                    {
                        case_Id : "required",
                        caseDate : "required",
                        custom_case : "required",
                        select_user : "required"
                    },
                messages :
                    {
                        case_Id : "Please Enter Case Id.",
                        caseDate : "Please Select Case Date",
                        custom_case : "Please Enter Text",
                        select_user : "Please select User Name"
                    }
            });
    });


    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    $('#caseDate').datepicker({
        endDate: new Date(),
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

</script>

<script src="<?php echo base_url() ?>scripts/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('custom_case');
    });
</script>