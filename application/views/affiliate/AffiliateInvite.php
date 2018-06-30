<!--CREATED DATE: 02/06/2017-->
<div class="white-area-content">
    <div class="db-header clearfix">
        <div class="page-header-title"> <span class="fa fa-asterisk"></span> Affiliate</div>
        <div class="db-header-extra"> <a href="<?php echo base_url().'affiliate/index' ?>" class="btn btn-success btn-sm">Go Back</a></div>
    </div>

    <div class="form-group">
        <?php if (isset($_SESSION['errors'])) { ?>
            <div><span><font color="#FF0000"><?php echo $_SESSION['errors']; ?></font></span></div>
        <?php } unset($_SESSION['errors']); ?>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
        <li class="active"><a href="<?php echo base_url().'affiliate'?>">Affiliate</a></li>
        <li class="active">Affiliate Invite User Form</li>
    </ol>
    <hr>
    <?php echo form_open(site_url("Affiliate/sendAffiliate/".$userDetails->ID_ACCOUNT), array("class" => "form-horizontal", "id" => "addAffiliate")) ?>
    <div class="form-group">
        <label for="txtAffiliateUrl" class="col-sm-2 control-label asterisk">Your Affiliate URL:</label>
        <div class="col-sm-8">
            <input type="text" id="txtAffiliateUrl" name="txtAffiliateUrl" value="<?php echo base_url().'register/index/'.$userDetails->ID_ACCOUNT; ?>" class="form-control" readonly/>
        </div>
    </div>
    <div class="form-group">
        <label for="txtUserName" class="col-sm-2 control-label">Enter User Name:</label>
        <div class="col-sm-3">
            <input type="text" id="txtUserName" name="txtUserName" value="" class="form-control" placeholder="Enter name"  required>
        </div>
        <label for="txtEmail" class="col-sm-2 control-label">Enter User Email:</label>
        <div class="col-sm-3">
            <input type="email" id="txtEmail" name="txtEmail" value="" class="form-control" placeholder="example@gmail.com" onblur="validateEmail(this);" required>
        </div>
        <input type="button" id="addUser" name="addUser" class="btn btn-success" value="Add to List">
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <div class="col-md-2"><label for="txtUserName" class="col-sm-12 control-label asterisk">Added List Display</label></div>
            <div class="col-md-8" id="addedList" style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #000000;height:auto;">
                <div id="field">
                    <div class="col-md-12">
                        <div class="col-md-4"><strong>User Name</div>
                        <div class="col-md-4">Email</div>
                        <div class="col-md-4">Action</strong></div>
                    </div>
                </div>
                <div class="contents"></div>
            </div>
            <div id="listItem"><input class="hidden" value="0" id="countValue"></div>
            <div class="col-md-2"><button type="button"  id="clearAddedList" name="clearAddedList" class="btn btn-success">Clear List</button></div>
        </div>
    </div>
    <div class="form-group">
        <label for="txtSubject" class="col-sm-2 control-label asterisk">Subject:</label>
        <div class="col-sm-8">
            <input type="text" id="txtSubject" name="txtSubject" value="" onblur="copySubject(this);" class="form-control" required/>
        </div>
    </div>
    <div class="form-group">
        <label for="txtAffiliateMessage" class="col-sm-2 control-label asterisk">Affiliate Message:</label>
        <div class="col-sm-8">
            <textarea class="form-control" id="description" name="text" rows="3"><?php print_r($htmlContent); ?></textarea>
        </div>
    </div>
    <input type="hidden" value="0" name="counterText" id="counterText">
    <input type="hidden" value="0" name="editedSubjectText" id="editedSubjectText">
    <input type="button" name="sendEmail" id="sendEmail" class="btn btn-success form-control" value="Send Email">
    <?php echo form_close(); ?>
</div>
<script src="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<script>
    function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (reg.test(emailField.value) == false){
            emailField.value = '';
            $("#message").remove();
            $('.breadcrumb').append("<div class='alert alert-danger' style='margin-top:25px;margin-bottom:0px;' id='message'>Invalid Email Address.</div>");
            setTimeout(function () {$("#message").hide();}, 4000);return false;
        }
        return true;
    }

    function copySubject(subject){
        $('#editedSubjectText').val(subject.value);
    }

    $(document).ready(function(){
        var next = 1;
        $("#userDetails").find('tbody').empty();
        $('.contents').on('click', '.removeMe', function()
        {
            $(this).parent("div").remove();
            next = next - 1;
        });

        $('#addUser').click( function ()
        {
            if(next<=5){
                if($('#txtUserName').val()=='' ||$('#txtEmail').val()=='' ){
                    $("#message").remove();
                    $('.breadcrumb').append("<div class='alert alert-danger' style='margin-top:25px;margin-bottom:0px;' id='message'>User Name or Email Address is Missing.</div>");
                    setTimeout(function () {$("#message").hide();}, 4000);return false;
                }
                else{
                    newIn = "<div class='subDiv' id='field" + next + "' style='padding-top: 10px;'>";
                    newIn = newIn + "<div class='col-md-4'>";
                    newIn = newIn + "<input type='text' required='required' name='userName' value='"+$('#txtUserName').val()+"' class='form-control userName' id='userName" + next + "' required/>";
                    newIn = newIn + "</div>";
                    newIn = newIn + "<div class='col-md-4'><input type='email' name='userEmail' value='"+$('#txtEmail').val()+"' class='form-control userEmail' onblur='validateEmail(this);' id='userEmail" + next + "' required/>";
                    newIn = newIn + "</div>";
                    newIn = newIn + "<span class='removeMe'><a href='javascript:void(0);' class='btn btn-danger remove-me'>-</span></div>";
                    $(newIn).appendTo(".contents");
                    next = next + 1;
                }
            }
            else{
                $("#message").remove();
                $('.breadcrumb').append("<div class='alert alert-info' style='margin-top:25px;margin-bottom:0px;' id='message'>You can Add 5 User Name and Email Address to List.</div>");
                setTimeout(function () {$("#message").hide();}, 4000);return false;
            }
            $('#txtUserName').val('');
            $('#txtEmail').val('');
        });

        $(document).on("click", "#clearAddedList", function(e){
            $('.contents').remove();
        });

        $(document).on("click", "#sendEmail", function(e){
            if (jQuery("#addAffiliate").valid()) {
                var userDetails =[];
                var txtUserName = document.getElementsByClassName("userName");
                var txtUserEmail = document.getElementsByClassName("userEmail");
                for(var count=0;count<txtUserEmail.length;count++){
                    userDetails.push( {
                        userName: txtUserName[count].value,
                        userEmail: txtUserEmail[count].value,
                    });
                }
                var textArea = CKEDITOR.instances['description'].getData();
                var subject = '';
                if($('#editedSubjectText').val()==''){
                    subject = $('#txtSubject').val();
                }
                else{
                    subject =$('#editedSubjectText').val();
                }
                var baseURL = '<?php echo site_url() . 'Affiliate/sendAffiliate/'.$userDetails->ID_ACCOUNT; ?>';
                $.ajax({
                    type: "POST",
                    url: baseURL,
                    data:{userDetails:userDetails,affiliateUrl:$('#txtAffiliateUrl').val(), affiliateMessage:textArea,subject:subject},
                    success: function (result) {
                        var data = $.parseJSON(result);
                        if (data=="1") {
                            swal("", "Affiliate User Invitation Email Sent Successfully", "success");
                            $("#savedata").show();
                        }
                        else {
                            swal("", data, "Affiliate User Invitation Failed")
                        }
                        $('.contents').remove();
                    }
                });
            }
        });
    });

    $("document").ready(function()
    {
        $("#addAffiliate").validate(
            {
                rules :
                    {
                        txtSubject : "required",
                        txtUserName : "required",
                        txtEmail : "required"
                    },
                messages :
                    {
                        txtSubject : "Please Enter Subject.",
                        txtUserName : "PLease Enter User Name.",
                        txtEmail : "Please Enter Email Address."
                    }
            });
    });

</script>

<script src="<?php echo base_url() ?>scripts/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('description');
    });
</script>