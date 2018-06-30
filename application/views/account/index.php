<script type="text/javascript" src="<?php echo base_url().'scripts/custom/check_username.js'?>"></script>

<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-user"></span> <?php echo lang("ctn_341") ?></div>
       <div class="db-header-extra"> <input type="button" class="btn btn-success btn-sm" value="<?php echo lang("ctn_367") ?>" data-toggle="modal" data-target="#memberModal"/></div>
    </div>
    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span>
            </div>    
        <?php } unset($_SESSION['errors']); ?>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><?php echo lang("ctn_1") ?></a></li>
        <li class="active"><?php echo lang("ctn_341") ?></li>
    </ol><hr>
    <div id="first">
        <table id="myTable" class="display responsive" width="100%" cellspacing="0">
        <thead class="table-header">
                <tr class="table-header">
                    <td><?php echo lang("ctn_25") ?></td>
                    <td>Email</td>
                    <td><?php echo lang("ctn_397") ?></td>
                    <td><?php echo lang("ctn_398") ?></td>
                    <td><?php echo lang("ctn_617") ?></td>
                    <td>Stripe charge</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($accounts as $account): ?>
                <?php $sel = $account['datecreated']; $created_date = date("m/d/Y", $sel); ?>
                <tr>
                    <td><?php echo $account['username']; ?>&nbsp;
                       <?php if($account['mwssettingsdone']==1) :?>
                            <a href="<?php echo site_url('Login/pro/' . $account['ID_ACCOUNT'] . '/' . $account['mwssettingsdone']); ?>">(Switch User)</a>
                        <?php else :?>
                            <a href="<?php echo site_url('Login/pro/' . $account['ID_ACCOUNT'] . '/' . $account['mwssettingsdone']); ?>">(Switch User)</a>
                        <?php endif;?>
                    </td>
                    <td><a target="blank" href="mailto:<?php echo $account['email']; ?>"><?php echo $account['email']; ?></a></td>
                    <td>
                        <div class="material-switch">
                            <lable class="msgAccountEnableDisable<?php echo $account['ID_ACCOUNT'];?>" value="<?php echo ($account['active']==1)?1:0; ?>"><?php echo (($account['active']==1)? "Enable" : "Disable" );?></lable>
                            <input id="someSwitchOptionDanger<?php echo $account['ID_ACCOUNT'];?>" type="checkbox" value="<?php echo $account['ID_ACCOUNT'];?>" class="accountEnableDisable" <?php echo (($account['active']==1)? "checked" : "unchecked")?> />&nbsp;
                            <label for="someSwitchOptionDanger<?php echo $account['ID_ACCOUNT'];?>" class="label-success"></label>
                        </div>
                    </td>

                    <td><?php echo ($account['mwssettingsdone']==1)? 'Enable':'Disable'; ?></td>

                    <td>
                        <div class="material-switch">
                            <lable class="msgsettingEnableDisable<?php echo $account['ID_ACCOUNT'];?>" value="<?php echo ($account['LinkAmazonEnabledisable']==1)?1:0; ?>"><?php echo (($account['LinkAmazonEnabledisable']==1)? "Enable" : "Disable" );?></lable>
                            <input id="settings<?php echo $account['ID_ACCOUNT'];?>" type="checkbox" value="<?php echo $account['ID_ACCOUNT'];?>" class="settingenabledisable" <?php echo (($account['LinkAmazonEnabledisable']==1)? "checked" : "unchecked")?> />&nbsp;
                            <label for="settings<?php echo $account['ID_ACCOUNT'];?>" class="label-success"></label>
                        </div>
                    </td>

                    <td>
                        <div class="material-switch">
                            <lable class="stripeChargedEnableDisable<?php echo $account['ID_ACCOUNT'];?>" value="<?php echo ($account['stripe_charge']==1)?1:0; ?>"><?php echo (($account['stripe_charge']==0)? "Enable" : "Disable" );?></lable>
                            <input id="stripeChargedEnableDisable<?php echo $account['ID_ACCOUNT'];?>" type="checkbox" value="<?php echo $account['ID_ACCOUNT'];?>" class="stripeChargedEnableDisable" <?php echo (($account['stripe_charge']==0)? "checked" : "unchecked")?> />&nbsp;
                            <label for="stripeChargedEnableDisable<?php echo $account['ID_ACCOUNT'];?>" class="label-success"></label>
                        </div>
                    </td>


                    <td>
                        <a href="<?php echo site_url('account/remove_account/' . $account['ID_ACCOUNT']); ?>" class="btn btn-danger delete" id="delete<?php echo $account['ID_ACCOUNT'];?>">Delete</a>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang("ctn_367") ?></h4>
            </div>
            <div class="modal-body" id="form_validation">
                <?php echo form_open(site_url("account/addAccountByAdmin"), array("class" => "form-horizontal","id" => "add_account_form")) ?>
                <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_343") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="store-in" name="storename" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_214") ?></label>
                    <div class="col-md-9">
                        <input type="email" class="form-control" id="email-in" name="email" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_215") ?></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="username" name="username" value="" required>
                        <div id="username_check"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_216") ?></label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" id="password-in" name="password" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cpassword-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_217") ?></label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" id="cpassword-in" name="password2" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_218") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="fname-in" name="first_name" value="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name-in" class="col-md-3 label-heading asterisk"><?php echo lang("ctn_219") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="lname-in" name="last_name" value="" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" >
                <div class="col-md-6"></div>
                <div class="col-md-3"><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button></div>
                <div class="col-md-3"><input type="button" name="save" id="save_new_account" class="btn btn-success form-control" value="<?php echo lang("ctn_61") ?>" /></div>
                <?php echo form_close() ?>
            </div>
        </div>
        <div id="loadingContent" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='<?php echo base_url()."images/loading.gif" ?>' width="64" height="64" /><br>Loading..</div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang("ctn_614") ?></h4>
            </div>
            <div class="modal-body" id="staticParent">
                <?php echo form_open(site_url("Account/updatePenalty"), array("class" => "form-horizontal","id" => "update_account_form")) ?>
                <input type="hidden" name="account_Id" id="account_Id" value="">
                <div class="form-group">
                    <label for="case__Id" class="col-md-3 label-heading">Charge(%)</label>
                    <div class="col-md-9">
                        <input type="textarea" maxlength="5" class="form-control" id="penalty" name="penalty" value="" required >
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <div class="col-md-6"></div>
                <div class="col-md-3"><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button></div>
                <div class="col-md-3"><input type="submit" name="update" id="update" class="btn btn-primary form-control" value="Update" /></div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">

<script type="text/javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>

<script language="javascript">

    $(function()
    {
        $('#staticParent').on('keydown', '#penalty', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    })

    $('.delete').on('click', function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
                title: "Confirm",
                text: "Are you sure you want to delete this user account ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes',
                cancelButtonText: "No",
                confirmButtonClass: "btn-danger",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal("Done!", "User account successfully deleted!", "success");
                    window.location.replace(url);
                } 
            });
    });

    $(document).on("click", ".accountEnableDisable", function(e){
        var chkValue = $(this).val();
        var id = $(this).attr("id");
        var flag = '';
        if($(this).prop("checked") == true){
            flag = 1;
            $('.msgAccountEnableDisable'+chkValue).html("Enable");
        }
        else if($(this).prop("checked") == false){
            flag = 0;
            $('.msgAccountEnableDisable'+chkValue).html("Disable");
        }
        var baseURL = '<?php echo site_url() . 'Account/accountEnableDisable/' ?>'+chkValue+"/"+flag;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result) {
                if (result==1) {
                    $('#message').remove();
                    $('.breadcrumb').append("<div class='alert alert-success' style='margin-top:25px;margin-bottom:0px;' id='message'>User Account is set to"+ ((flag==1) ? ' Enable' : ' Disable')+" Successfully.</div>");
                    setTimeout(function () {
                        $("#message").hide();
                    }, 5000);
                    return false;
                } else if(result == 0) {
                    $('.msgAccountEnableDisable'+chkValue).html("Disable");
                    $(this).prop("checked",true);
                    $(this).toggleClass('changed');
                    $('#message').remove();
                    $('.breadcrumb').append("<div class='alert alert-success' style='margin-top:25px;margin-bottom:0px;' id='message'>User Account is set to"+ ((flag==0) ? ' Disable' : ' Enable')+" Successfully.</div>");
                    setTimeout(function () {
                        $("#message").hide();
                    }, 5000);
                    return false;
                }
                return false;
            }
        });
    });

    $('#save_new_account').click(function ()
    {
        if (jQuery("#add_account_form").valid()) {
            $("#loadingContent").css("display", "block");

            var baseURL = '<?php echo site_url() . 'Account/addAccountByAdmin' ?>';
            $.ajax({
                type: "POST",
                url: baseURL,
                data: $('#add_account_form').serialize(),
                success: function (result) {
                    $("#loadingContent").css("display", "none");
                    if(isNaN(result)){
                        $('#message').remove();
                        $('.modal-header').append("<div class='alert alert-danger' id='message'>"+ result+"</div>");
                        setTimeout(function () {$("#message").hide();}, 4000);return false;
                    }
                    else{
                        if(result>0) {
                            window.location.reload();
                        }
                    }
                }
            });
        }
    });


    $(document).on("click", ".settingenabledisable", function(e){
        var id = $(this).val();
        var flag = '';
        if($(this).prop("checked") == true){
            flag = 1;
            $('.msgsettingEnableDisable'+id).html("Enable");
        }
        else if($(this).prop("checked") == false){
            flag = 0;
            $('.msgsettingEnableDisable'+id).html("Disable");
        }
        var baseURL = '<?php echo site_url() . 'Account/linkAmaoznUserEnableDisable/' ?>'+id+"/"+flag;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result) {
                if (result==1) {
                    $('#message').remove();
                    $('.breadcrumb').append("<div class='alert alert-info' style='margin-top:25px;margin-bottom:0px;' id='message'>Link Amazon Settings "+ ((flag==1) ? ' Enable' : ' Disable')+" Successfully.</div>");
                    setTimeout(function () {
                        $("#message").hide();
                    }, 5000);
                    return false;
                } else if(result == 0) {
                    $('.msgsettingEnableDisable'+chkValue).html("Disable");
                    $(this).prop("checked",true);
                    $(this).toggleClass('changed');
                    $('#message').remove();
                    $('.breadcrumb').append("<div class='alert alert-info' style='margin-top:25px;margin-bottom:0px;' id='message'>Link Amazon Settings "+ ((flag==0) ? ' Disable' : ' Enable')+" Successfully.</div>");
                    setTimeout(function () {
                        $("#message").hide();
                    }, 5000);
                    return false;
                }
                return false;
            }
        });
    });

    $(document).on("click", ".stripeChargedEnableDisable", function(e){
        var chkValue = $(this).val();
        var id = $(this).attr("id");
        var flag = '';
        if($(this).prop("checked") == true){
            flag = 0;
            $('.stripeChargedEnableDisable'+chkValue).html("Enable");
        }
        else if($(this).prop("checked") == false){
            flag = 1;
            $('.stripeChargedEnableDisable'+chkValue).html("Disable");
        }
        var baseURL = '<?php echo site_url() . 'Account/stripeChargedEnableDisable/' ?>'+chkValue+"/"+flag;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result) {
                if(result == 1){
                    swal("Done!","Stripe Charged Updated Successfully","success");
                    setTimeout(function () {
                        $("#message").hide();
                    }, 5000);
                    return false;
                }else{
                    swal("Cancel","Stripe Charged Updated Successfully","");
                    setTimeout(function () {
                        $("#message").hide();
                    }, 5000);
                    return false;
                }
                return false;
            }
        });
    });

</script>


