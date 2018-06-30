$.noConflict();
$(document).ready(function () {
    jQuery.validator.addMethod("time12h",function(a,b){
        return this.optional(b)||/^((0?[1-9]|1[012])(:[0-5]\d){1,2}(\ ?[AP]M))$/i.test(a)
        },"Please enter a valid time in 12-hour am/pm format");
    jQuery.validator.addMethod("phoneUS",function(a,b){
        return a=a.replace(/\s+/g,""),this.optional(b)||a.length>9&&a.match(/^(\+?1-?)?(\([2-9]([02-9]\d|1[02-9])\)|[2-9]([02-9]\d|1[02-9]))-?[2-9]([02-9]\d|1[02-9])-?\d{4}$/)
        },"Please specify a valid phone number");
      
    /*
     * paymentmethod form validation
     */
    jQuery("#paymentmethodadd").validate({
     
        rules: {
            cardholdername:"required",
            firstname: "required",
            lastname: "required",
            email: {
                required:true,
                email:true
            },
            city:"required",
            state:"required",
            zip:{
                required:true,
                number:true
            },
            address: "required",
            Payment: "required",
            // Credit_Card_Number: "required",
            cardsecuritycode:
            {
                required:true,
                number:true
            },
            expiremonth: {
                required:true,
                number:true,
                range: [1, 12]
            },
            expireyear:{
                required:true,
                number:true,
                minlength: 4
            },
        },
        messages: {
            firstname: "Please enter first name",
            cardholdername: "Please enter cardholder name",
            lastname: "Please enter Last name",
            email: 
            {
                required:"Please enter email address",
                email:"Please enter valid email address"
            },
            city:"Please enter city",
            state:"Please enter state",
            zip:{
                required:"Please enter zip code",
                number:"Please only enter numeric"
            },
            address: "Please enter address",
            Payment: "Please select your payment method",
            // Credit_Card_Number: "Please enter  credit card number",
            cardsecuritycode:
            {
                required:"Please enter securitycode",
                number:"Please only enter numeric"
            },
            expiremonth:
            {
                required:"Please enter valid expire month",
                number:"Please enter numeric only",
                range:"Please enter valid month"
            },
            expireyear:
            {
                required:"Please enter expire year",
                number:"Please enter numeric only",
                minlength:"Please enter valid year"
            },
        }
    });
    //Add Account form validation
    jQuery("#add_account_form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            company: "required",
            ID_FEEDBACKPLAN: "required",
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 5
            },
            password2: {
                required: true,
                minlength: 5,
                equalTo: "#password-in"
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            first_name: "Please enter your First name",
            last_name: "Please enter your Last name",
            company: "Please enter your company name",
            username: {
                required: "Please enter a User name",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            ID_FEEDBACKPLAN: "please select Feedback plan"
        }
    });
    //Edit Account form validation
    jQuery("#edit_account_form").validate({
        rules: {
            company: "required",
        },
        messages: {
            company: "please enter your company name",
        }
    });
    //feedback_setting form validation
    jQuery("#feedback_setting_form").validate({
        rules: {
            amazonstorename: {
                required: true,
            },
            feedbackfromemailaddress: {
                required: true,
                email: true
            },
            mws_sellerid: {
                required: true,
            },
            mws_marketplaceid: "required",
            mws_authtoken: "required"
        },
        messages: {
            amazonstorename: {
                required: "Please enter a Amazone Store Name",
            },
            feedbackfromemailaddress: 
            {
                required:"Please enter a email address",
                email:"Please enter a valid email address",
            },
            mws_sellerid: "Please enter Amazon Seller Id",
            mws_marketplaceid: "Please select Amazon Marketplace Id",
            mws_authtoken: "Please enter Amazon Auth Token"
        }
    });
    //feedback_alert_setting form validation
    jQuery("#feedback_alert_from").validate({
        rules: {
            set_notification_fbalerts_email: {
                required: true,
                email: true
            },
        },
        messages: {
            set_notification_fbalerts_email: "Please enter a valid email address",
        }
    });
    //add marketplace account form
    jQuery("#add_marketplace_account_form").validate({
        rules: {
            marketplace_id: "required",
            marketplace_name: "required",
            host: "required"
        },
        messages: {
            marketplace_id: "Please enter a marketplaceid",
            marketplace_name: "Please enter markeplace name",
            host: "Please enter valid host name",
        }
    });
    jQuery("#edit_marketplace_account").validate({
        rules: {
            marketplace_id: "required",
            marketplace_name: "required",
            host: {
                required: true,
                url: true
            }
        },
        messages: {
            marketplace_id: "Please enter a marketplaceid",
            marketplace_name: "Please enter markeplace name",
            host: "Please enter valid host name",
        }
    });
    //add developer account form validation
    jQuery("#dev_add_account_form").validate({
        rules: {
            access_key: "required",
            secret_key: "required"
        },
        messages: {
            access_key: "Please enter access key",
            secret_key: "Please enter secret key",
        }
    });
    /*
     * edit developer account form validation
     */
    jQuery("#edit_dev_account_form").validate({
        rules: {
            access_key: "required",
            secret_key: "required"
        },
        messages: {
            access_key: "Please enter access key",
            secret_key: "Please enter secret key",
        }
    });
    /*
     * Email Setting form validation
     */
    jQuery("#email_setting_form").validate({
        rules: {
            set_sendemails_fbafeedbackdays:
            {
                required:true,
                number:true
            },
            set_sendemails_time: 
            {
                required:true,
                time12h:true
            },
            set_secondfollowupemail_days:
            {
                number:true,  
            },
            set_thirdfollowupemail_days:
            {
                number:true,
                
            },
            set_fourthfollowupemail_days:
            {
                number:true,
            },
             
            
        },
        messages: {
            set_sendemails_fbafeedbackdays:
            {
                
                required:"Please enter days after first order email sends ",
                number:"Please enter only numeric value"
            },
            set_sendemails_time:
            {
                required:"Please enter email send time",
            //time12h:"Please enter proper format"
            },
            set_secondfollowupemail_days:
            {
                number:"Please enter only numeric value",  
            },
            set_thirdfollowupemail_days:
            {
                number:"Please enter only numeric value",  
            },
            set_fourthfollowupemail_days:
            {
                number:"Please enter only numeric value",  
            },
                
        }
    });
    /*
     * sms Setting form validation
     */
    jQuery("#sms_setting_form").validate({
        rules: {
            set_sendsms_feedbackdays:
            {
                required:true,
                number:true
            },
            set_sendsms_time: 
            {
                required:true,
                time12h:true
            },
            set_secondfollowupsms_days:
            {
                number:true,  
            },
            set_thirdfollowupsms_days:
            {
                number:true,
                
            },
            set_fourthfollowupsms_days:
            {
                number:true,
            },
        },
        messages: {
            set_sendsms_feedbackdays:
            {
                required:"Please enter days after first sms sends ",
                number:"Please enter only numeric value"
            },
            set_sendsms_time:
            {
                required:"Please enter sms send time"
            },
            set_secondfollowupsms_days:
            {
                number:"Please enter only numeric value",  
            },
            set_thirdfollowupsms_days:
            {
                number:"Please enter only numeric value",  
            },
            set_fourthfollowupsms_days:
            {
                number:"Please enter only numeric value",  
            },

        }
    });
    /*
     *User setting Form validation 
     */
    jQuery("#user_settings_form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
        },
        messages: {
            first_name: "Please enter your First name",
            last_name: "Please enter your Last name",
        }
    });
    /*
     *Gloabal setting Form validation 
     */
    jQuery("#global_setting_form").validate({
        rules: {
            site_name: "required",
            site_email: {
                required: true,
                email: true
            },
            upload_path: "required",
            upload_path_relative: "required",
            date_format: "required",
            file_types: "required",
            file_size: "required",
        },
        messages: {
            site_name: "Please enter Site name",
            site_email: 
            {
                required:"Please enter email address",
                email:"Please enter valid email address",
            },
            upload_path: "Please enter Upload path",
            upload_path_relative: "Please enter relative upload path",
            date_format: "Please enter valid date format",
            file_types: "Please enter file types",
            file_size: "Please enter file size",
        }
    });
    /*
     * email template edit wizard form validation
     */
    jQuery("#email_template_edit_wizard").validate({
        rules: {
            emailtype: "required",
            subject: "required",
            fromname: "required",
            message: "required",
        },
        messages: {
            emailtype: "You need to select an email type",
            subject: "A subject is required",
            fromname: "A from name is required",
            message: "A message is required",
        }
    });
    /*
     * edit_template_with_html_editor
     */
    jQuery("#edit_template_with_html_editor").validate({
        rules: {
            emailtype: "required",
            subject: "required",
            fromname: "required",
            message: "required",
        },
        messages: {
            emailtype: "You need to select an email type",
            subject: "A subject is required",
            fromname: "A from name is required",
            message: "A message is required",
        }
    });
    /*
     * view temolate message form
     */
    jQuery("#view_template_msg_form").validate({
        rules: {
            subject: "required",
            email: {
                //required: true,
                email: true
            }
        },
        messages: {
            subject: "A subject is required",
            email: "Please enter valid email address",
        }
    });
    /*
     * add sms template form validation
     */
    jQuery("#add_template_form").validate({
        rules: {
            smstype: "required",
            template_name: "required",
            message: "required"
        },
        messages: {
            smstype: "Please select sms type",
            template_name: "Please enter Template name",
            message: "Please enter Message",
        }
    });
    /*
     * add bad revieform validation
     */
    jQuery("#add_review_form").validate({
        rules: {
            username: "required",
            message: "required"
        },
        messages: {
            username: "Please enter email address",
            message: "Please enter Message",
        }
    });
    /*
     * add sms api config data form validation
     */
    jQuery("#add_sms_api_form").validate({
        rules: {
            authid: "required",
            authtoken: "required",
            senderno: "required",
        },
        messages: {
            authid: "Please enter Auth id or username",
            authtoken: "Please enter Auth Token",
            senderno: "Please enter Sender No",
        }
    });
    /*
     * edit sms config form validation
     */
    jQuery("#edit_sms_config_data").validate({
        rules: {
            authid: "required",
            authtoken: "required",
            senderno: 
            {
                required:true,
                phoneUS:true
            }
        },
        messages: {
            authid: "Please enter Auth id or username",
            authtoken: "Please enter Auth Token",
            senderno: 
            {
                required:"Please enter Sender No",
            }
        }
    });
    /*
     * Add subscription plan form validation
     */
    jQuery("#add_plan_form").validate({
        rules: {
            plan_name: "required",
            plan_email: 
            {
                required:true,
                number:true
            },
            plan_sms: 
            {
                required:true,
                number:true
            },
            price: 
            {
                required:true,
                number:true
            },
            days: 
            {
                required:true,
                number:true
            },
            trialdays:
            {
                required:true,
                number:true,
            },
        },
        messages: {
            plan_name: "Please enter Plan name",
            plan_email: 
            {
                required:"Please enter No.of email send",
                number:"Please enter only numeric value"
            },
            plan_sms:
            {
                required:"Please enter No.of sms send",
                number:"Please enter only numeric value"
            },
            price:
            {
                required:"Please enter price for plan",
                number:"Please enter only numeric value"
            },
            days:
            {
                required:"Please enter No.of days for plan",
                number:"Please enter only numeric value"
            },
            trialdays:
            {
                required:"Please enter No.of days for Trial",
                number:"Please enter only numeric value",
            },
        }
    });
    /*
     * Add subscription plan form validation 
     */
    jQuery("#edit_subscription_form").validate({
        rules: {
            plan_name: "required",
            plan_email: 
            {
                required:true,
                number:true
            },
            plan_sms: 
            {
                required:true,
                number:true
            },
            price: 
            {
                required:true,
                number:true
            },
            days: 
            {
                required:true,
                number:true
            },
            trial_days:{
                number:true
            }    
        },
        messages: {
            plan_name: "Please enter Plan name",
            plan_email: 
            {
                required:"Please enter No.of email send",
                number:"Please enter only numeric value"
            },
            plan_sms:
            {
                required:"Please enter No.of sms send",
                number:"Please enter only numeric value"
            },
            price:
            {
                required:"Please enter price for plan",
                number:"Please enter only numeric value"
            },
            days:
            {
                required:"Please enter No.of days for plan",
                number:"Please enter only numeric value"
            },
            trial_days:
            {
                number:"Please enter only numeric value"
            }
        }
    });
    /*
     * update sms template  form validation 
     */   
    jQuery("#edit_sms_template").validate({
        rules: {
            smstype: "required",
            template_name: "required",
            message: "required",
            
        },
        messages: {
            smstype: "Please enter Sms type",
            template_name: "Please enter Template name",
            message: "Please enter Message",
        }
    });
    /*
     * change password form validation 
     */
    jQuery("#change_password_form").validate({
        rules: {
            current_password: "required",
            new_pass1:
            {
                required: true,
                minlength:6
            },
            new_pass2:
            {
                required:true,
                equalTo: "#new_pass1",
                minlength:6
            }
            
        },
        messages: {
            current_password: "Please enter Current password",
            new_pass1: 
            {
                required:"Please enter New password",
                minlength:"Please enter atlease 6 characters",
            },
            new_pass2: 
            {
                required:"Please enter Confirm new password",
                equalTo:"please enter same password as new password",
                minlength:"Please enter atlease 6 characters"
            }
        }
    });
    //feedback_setting form validation
    jQuery("#amazon_setting_form").validate({
        rules: {
           
            mws_sellerid: {
                required: true,
            },
            mws_marketplaceid: "required",
            mws_authtoken: "required"
        },
        messages: {
           
            mws_sellerid: "Please enter Amazon Seller Id",
            mws_marketplaceid: "Please select Amazon Marketplace Id",
            mws_authtoken: "Please enter Amazon Auth Token"
        }
    });
    
});