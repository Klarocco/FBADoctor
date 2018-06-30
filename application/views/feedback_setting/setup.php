<div class="white-area-content" id="setup">
   <ul id="wizard-header" class="stepy-header" style="display: table">
        <li id="wizard-head-1"><div class="col-md-4">Step 1<p style="font-size:15px"><?php echo lang("ctn_515")?></p></div>
        <li id="wizard-head-3"><div class="col-md-4 desable" style="margin-left:200px;">Step 3<p style="font-size:15px"><?php echo lang("ctn_516")?></p></div>
    </ul>
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="glyphicon glyphicon-cog"></span> <?php echo lang("ctn_513") ?></div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open_multipart(site_url("feedback_setting/add_basic_settings"), array("class" => "form-horizontal", "id" => "feedback_setting_form")) ?>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_345") ?></label>
                <div class="col-sm-10">
                    <input type="text" name="amazonstorename" value="<?php echo $feedback_settings['amazonstorename']; ?>" class="form-control" id="amazonstorename" />
                </div>
            </div>

            <div class="form-group">
                <label for="email-in" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_346") ?></label>
                <div class="col-sm-10">
                    <input type="email" name="feedbackfromemailaddress" value="<?php if(isset($feedback_settings['feedbackfromemailaddress']))echo $feedback_settings['feedbackfromemailaddress'] ?>" class="form-control" id="feedbackfromemailaddress" />
                    <p>Must be an approved email address in Amazon's seller central!</p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label asterisk"><?php echo lang("ctn_348") ?></label>
                <div class="col-sm-10">
                    <?php $sel = $feedback_settings['mws_marketplaceid']; ?>
                    <select name="mws_marketplaceid" class="form-control" >
                        <?php
                        foreach ($marketplace_id as $row) {
                            $sel_option = '';
                            if ($row['id'] == $sel)
                                $sel_option = 'selected';
                            ?>
                            <option value="<?php echo $row['id'] ?>"  <?php echo $sel_option; ?> ><?php echo $row['marketplace_name'] ?></option>
                        <?php } ?>                        
                    </select>
                </div>
            </div>

            <?php
            $sel = $feedback_settings['set_feedsendstartdate'];
            $sel_date = ($sel == 0 ? date('m/d/y') : date("m/d/Y", $sel));
            ?>
            <input type="submit" name="save" value="<?php echo lang("ctn_506") ?>" class="btn btn-success " />
            <a href="<?php echo site_url('login/logout/' . $this->security->get_csrf_hash()) ?>" class="btn btn-success" id="cancel"><?php echo lang("ctn_514") ?></a>
            <?php //echo form_close() ?>
        </div>
    </div>
</div>
<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
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
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal("Done!", "Your sign up cancel!", "success");
                    window.location.replace(url);
                } else {
                    swal("Cancel", "Cancel! :)", "error");
                }
            });
    });
</script>
<script>

    $(function () {
        $("#datepicker").datepicker();
    });

</script>