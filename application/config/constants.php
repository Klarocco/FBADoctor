<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define("RESPOND_NEGATIVE_FEEDBACK_SUBJECT", "Regarding your order with [amazonstorename]");
define("RESPOND_NEGATIVE_FEEDBACK_MESSAGE",'Dear [customername],

We hope that we have adequately met your needs and addressed
your concerns regarding your recent order for:
[orderitems]
If everything has been addressed, we kindly ask you to remove or edit
your feedback by clicking the link below:
<a href="https://www.amazon[amazontld]/gp/feedback/leave-consolidated-feedback.html/?ie=UTF8&mode=submitted&orderID=[ordernumber]">
https://www.amazon[amazontld]/gp/feedback/leave-consolidated-feedback.html/?ie=UTF8&mode=submitted&orderID=[ordernumber]</a> You can remove feedback by clicking Remove Feedback button after finding the order mentioned above.

Thank you for your business,

Sincerely,

[amazonstorename]');

define('DEFAULT_SUBJECT','Your recent Order with Amazon (order: [ordernumber])');

define('DEFAULT_MESSAGE','Dear [customerfirstname] [customerlastname],

Thank you for shopping with us on Amazon.  We are contacting you to ensure your expectations were met for your order with [amazonstorename].

We pride ourselves in providing quality customer service.  If you had a pleasant buying experience with us, we would appreciate if you could leave us a feedback on Amazon.  If for any reason, you did not have a positive shopping experience, please allow us the opportunity to address your concerns before leaving a feedback.

To leave Seller Feedback, please click the link below:
[sellerfeedbacklink]

Here are the details for your Amazon order: [ordernumber]
[orderitemsreviewlink]

Regards,

[amazonstorename]');

define('CUSTOM_TEMPLATE16','It would mean so much if you could take the 5 seconds to leave feedback on your recent order. If for any reason, you did not have a positive shopping experience, please allow us the opportunity to address your concerns.');

define('HEADERTEXT','[customerfirstname], Thank You');
define('HEADERCONTENT','for shopping with us on Amazon. We are contacting you to ensure your expectations were met for your order with Carolina Sweethearts');
define('BODYHEADER','How is it going so far?');
//define('BODYTEXT','It would mean so much if you could take the 5 seconds to leave feedback on your recent order. If for any reason, you did not have a positive shopping experience, please allow us the opportunity to address your concerns.');

define('CUSTOM_TEMPLATE17','Hi [customerfirstname]! Thank you for ordering the [productname]. Would you be willing to share your experience below?');
define('HEADERTEXT17','We\'d Love to Hear From You');

//stripe config key of Webdimensions
define('publishable_key', 'pk_test_95PfFHVkestIYeHSGtEGpeXH');
define('secret_key', 'sk_test_lHwLvb5bcr5BxnJ9rIpDWLrg');

// Email Template's Constants.

// Need to test it on server using webhook & stripe .
define('NEGATIVE_FEEDBACK_REQUEST',15);
define('SUBSCRIPTION_CHARGE_SUCCESSFUL',14);
define('SUBSCRIPTION_CHARGE_FAILED',13);
define('CUSTOMER_CARD_DETAIL_CHANGE',12);
define('SUBSCRIPTION_TRIAL_WILL_END',8);


// Tested Properly.

define('USER_ACTIVATION',7);
define('WELCOME_EMAIL',3);
define('SUBSCRIPTION_CREATE',6);
define('SUBSCRIPTION_UPDATE',5);
define('SUBSCRIPTION_CANCEL',4);


// Need to integrate it .
define('PASSWORD_RESET',11);

//integrated it .
define('NEGATIVE_FEEDBACK_RESPONSE',10);

//import days
define('import_days',50);
define('XMLAPI_HOST','www.FBADoctor.com');
define('XMLAPI_USERNAME','FBADoctor');
define('XMLAPI_PASS','YNduey0XfY#KqLov');
define('XMLAPI_PORT',2083);
define('XMLAPI_EMAIL_PASS','FBADoctor');
define('XMLAPI_QUOTA',20);
define('XMLAPI_DOMAIN','FBADoctor.com');
define('XMLAPI_DEST_NAME','support@FBADoctor.com');

define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);


define('AMAZONMWSINVENTORYABSPATH','E:/wamp64/www/FBADoctor/application/libraries/');
define('UPSACCESSLICENCENUMBER','8BEFB9015E0D2859');
define('UPSUSERID','marcrosoft');
define('UPSUSERPASSWORD','ddqpou87');

