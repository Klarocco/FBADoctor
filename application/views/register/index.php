<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<style>
    .error
    {
        color: red;
    }

</style>
<div class="container">
    <div class="row">
        <div class="col-md-5 center-block-e" style="margin-top: -65px;">
            <div class="login-page-header">
                <img src="<?php echo base_url();?>images/logo.png" class="user-image " alt="User Image"><br><br>
                <?php echo lang("ctn_212") ?> <?php echo $this->settings->info->site_name ?>
            </div>
            <div class="login-page" style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #000000;padding-bottom: 5px;">
                <?php if (!empty($fail)) : ?>
                    <div class="alert alert-danger"><?php echo $fail ?></div>
                <?php endif; ?>

                <?php echo form_open(site_url("register"), array("class" => "form-horizontal", "id" => "register_form")) ?>
                <?php if(!empty($affiliate)) :?>
                    <div class="form-group hidden">
                        <label for="affilietId" class="col-md-3 label-heading">Affiliet User Id</label>
                        <div class="col-md-9">
                            <input type="hidden" class="form-control" id="affiliateId" name="affiliateId" value="<?php echo $affiliate; ?>" readonly>
                        </div>
                    </div>
                <?php endif;?>
                <div class="form-group">

                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_343") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="store-in" name="storename"
                               value="">
                    </div>
                </div>
                <div class="form-group">

                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_214") ?></label>
                    <div class="col-md-9">
                        <input type="email" class="form-control" id="email-in" name="email"
                               value="<?php if (isset($email)) echo $email; ?>">
                    </div>
                </div>

                <div class="form-group">

                    <label for="username-in" class="col-md-3 label-heading"><?php echo lang("ctn_215") ?></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="username" name="username"
                               value="<?php if (isset($username)) echo $username; ?>">
                        <div id="username_check"></div>
                    </div>

                </div>

                <div class="form-group">

                    <label for="password-in" class="col-md-3 label-heading"><?php echo lang("ctn_216") ?></label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" id="password-in" name="password" minlength="6" maxlength="16">
                    </div>
                </div>

                <div class="form-group">

                    <label for="cpassword-in" class="col-md-3 label-heading"><?php echo lang("ctn_217") ?></label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" id="cpassword-in" name="password2" value="" minlength="6" maxlength="16">
                    </div>
                </div>

                <div class="form-group">

                    <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_218") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="fname-in" name="first_name"
                               value="<?php if (isset($first_name)) echo $first_name ?>">
                    </div>
                </div>
                <div class="form-group">

                    <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_219") ?></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="lname-in" name="last_name"
                               value="<?php if (isset($last_name)) echo $last_name ?>">
                    </div>
                </div>

                <?php if (!$this->settings->info->disable_captcha) : ?>
                    <div class="form-group">

                        <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_220") ?></label>
                        <div class="col-md-9">
                            <p><?php echo $cap['image'] ?></p>
                            <input type="text" class="form-control" id="captcha-in" name="captcha"
                                   placeholder="<?php echo lang("ctn_306") ?>" value="">
                        </div>
                    </div>
                <?php endif; ?>


                <input type="submit" name="s" class="btn btn-primary form-control"
                       value="<?php echo lang("ctn_221") ?>"/>

                <hr style="border-top-width: 0px;margin-bottom: 5px;margin-top: 10px;">

                <p><?php echo lang("ctn_222") ?></p>

                <?php if (!$this->settings->info->disable_social_login) : ?>

                <?php endif; ?>

                <p class="decent-margin"><a href="<?php echo site_url("login") ?>"
                                            class="btn btn-success form-control"><?php echo lang("ctn_223") ?></a></p>

                <?php echo form_close() ?>
            </div>

        </div>
    </div>
</div>

<script>
    $("document").ready(function () {
        $("#register_form").validate({

            rules: {
                storename: "required",
                email: {
                    required: true,
                    email: true

                },
                username: "required",
                password: "required",
                password2: {
                    required: true,
                    equalTo: '#password-in'
                },
                first_name: "required",
                last_name: "required",
                captcha: "required"
            },
            messages: {
                storename: "Please enter storename",
                email: {
                    required: "Please enter email",
                    email: "Please enter valid email"

                },
                username: "Please enter username",
                password: "Please enter password",
                password: "Please enter minimum six character",
                password2: {
                    required: "Please enter confirm password",
                    equalTo: "Please enter same password"
                },
                first_name: "Please enter first name",
                last_name: "Please enter last name",
                captcha: "Please enter captcha"

            }
        });
    });
</script>