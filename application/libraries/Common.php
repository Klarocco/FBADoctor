<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("PasswordHash.php");

class Common {

    public function nohtml($message) {

        $message = trim($message);
        $message = strip_tags($message);
        $message = htmlspecialchars($message, ENT_QUOTES);
        return $message;
    }

    public function encrypt($password) {
        $phpass = new PasswordHash(12, false);
        $hash = $phpass->HashPassword($password);
        return $hash;
    }

    public function get_user_role($user) {
        if (isset($user->user_role_name)) {
            return $user->user_role_name;
        } else {
            if ($user->user_role == -1) {
                return lang("ctn_33");
            } else {
                return lang("ctn_34");
            }
        }
    }

    public function randomPassword()
    {
        $letters = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q",
            "r", "s", "t", "u", "v", "w", "x", "y", "z"
        );
        $pass = "";
        for ($i = 0; $i < 10; $i++) {
            shuffle($letters);
            $letter = $letters[0];
            if (rand(1, 2) == 1) {
                $pass .= $letter;
            } else {
                $pass .= strtoupper($letter);
            }
            if (rand(1, 3) == 1) {
                $pass .= rand(1, 9);
            }
        }
        return $pass;
    }

    public function checkAccess($level, $required) {
        $CI = & get_instance();
        if ($level < $required) {
            $CI->template->error(
                    "You do not have the required access to use this page. 
                You must be a " . $this->getAccessLevel($required)
                    . "to use this page."
            );
        }
    }

    public function send_email($subject, $body, $emailt, $fromEmail = "" ,$attachment = '')
    {
        $CI = & get_instance();
        $CI->load->library('email');
        $CI->email->initialize($CI->config);
        if (!empty($fromEmail))
        {
            $CI->email->from($fromEmail);
            $CI->email->reply_to($fromEmail);
        } else
        {
            $CI->email->from("nishant@webdimensions.co.in","Support FBADoctor");
        }
        if($attachment !=''){
            $CI->email->attach($attachment);
        }
        $CI->email->to($emailt);
        $CI->email->subject($subject);
        $CI->email->message($body);

        if ($CI->email->send())
        {
           $CI->email->clear(TRUE);
           return 1;
        }
        else
        {
            return 0;
        }
    }

    public function check_mime_type($file) {
        return true;
    }

    public function replace_keywords($array, $message) {
        foreach ($array as $k => $v) {
            $message = str_replace($k, $v, $message);
        }
        return $message;
    }

    public function convert_time($timestamp) {
        $time = $timestamp - time();
        if ($time <= 0) {
            $days = 0;
            $hours = 0;
            $mins = 0;
            $secs = 0;
        } else {
            $days = intval($time / (3600 * 24));
            $hours = intval(($time - ($days * (3600 * 24))) / 3600);
            $mins = intval(($time - ($days * (3600 * 24)) - ($hours * 3600) ) / 60);
            $secs = intval(($time - ($days * (3600 * 24)) - ($hours * 3600) - ($mins * 60)));
        }
        return array(
            "days" => $days,
            "hours" => $hours,
            "mins" => $mins,
            "secs" => $secs
        );
    }

    public function get_time_string($time) {
        if (isset($time['days']) &&
                ($time['days'] > 1 || $time['days'] == 0)) {
            $days = lang("ctn_294");
        } else {
            $days = lang("ctn_295");
        }
        if (isset($time['hours']) &&
                ($time['hours'] > 1 || $time['hours'] == 0)) {
            $hours = lang("ctn_296");
        } else {
            $hours = lang("ctn_297");
        }
        if (isset($time['mins']) &&
                ($time['mins'] > 1 || $time['mins'] == 0)) {
            $mins = lang("ctn_298");
        } else {
            $mins = lang("ctn_299");
        }
        if (isset($time['secs']) &&
                ($time['secs'] > 1 || $time['secs'] == 0)) {
            $secs = lang("ctn_300");
        } else {
            $secs = lang("ctn_301");
        }
        // Create string
        $timeleft = "";
        if (isset($time['days'])) {
            $timeleft = $time['days'] . " " . $days;
        }
        if (isset($time['hours'])) {
            if (!empty($timeleft)) {
                if (!isset($time['mins'])) {
                    $timeleft .= " " . lang("ctn_302") . " " . $time['hours'] . " "
                            . $hours;
                } else {
                    $timeleft .= ", " . $time['hours'] . " " . $hours;
                }
            } else {
                $timeleft .= $time['hours'] . " " . $hours;
            }
        }
        if (isset($time['mins'])) {
            if (!empty($timeleft)) {
                if (!isset($time['secs'])) {
                    $timeleft .= " " . lang("ctn_302") . " " . $time['mins'] . " "
                            . $mins;
                } else {
                    $timeleft .= ", " . $time['mins'] . " " . $mins;
                }
            } else {
                $timeleft .= $time['mins'] . " " . $mins;
            }
        }
        if (isset($time['secs'])) {
            if (!empty($timeleft)) {
                $timeleft .= " " . lang("ctn_302") . " " . $time['secs'] . " "
                        . $secs;
            } else {
                $timeleft .= $time['secs'] . " " . $secs;
            }
        }
        return $timeleft;
    }

    public function has_permissions($required, $user) {
        if (!isset($user->info->user_role_id))
            return 0;
        foreach ($required as $permission) {
            if (isset($user->info->{$permission}))
                return 1;
        }
        return 0;
    }

    public function Countries() {
        return array(
            "US" => "United States",
            "CA" => "Canada",
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antiqua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BV" => "Bouvet Islands",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "VI" => "British Virgin Islands",
            "BN" => "Brunei",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CW" => "Curacao",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "EC" => "Equador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands",
            "FO" => "Faroe Islands",
            "FM" => "Federated States of Micronesia",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MK" => "Macedonia",
            "MR" => "Mauritania",
            "YT" => "Mayotte",
            "FX" => "Metropolitan France",
            "MX" => "Mexico",
            "MD" => "Moldova",
            "MN" => "Mongolia",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "KR" => "Republic of Korea",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russia",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SH" => "St. Helena",
            "KN" => "St. Kitts and Nevis",
            "LC" => "St. Lucia",
            "VC" => "St. Vincent and the Grenadines",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen Islands",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syria",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "UK" => "United Kingdom",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VA" => "Vatican City",
            "VE" => "Venezuela",
            "VN" => "Vietnam",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "YU" => "Yugoslavia",
            "ZR" => "Zaire",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe");
    }

    function States() {
        return array(
            "AL" => "Alabama",
            "AK" => "Alaska",
            "AZ" => "Arizona",
            "AR" => "Arkansas",
            "CA" => "California",
            "CO" => "Colorado",
            "CT" => "Connecticut",
            "DE" => "Delaware",
            "DC" => "District of Columbia",
            "FL" => "Florida",
            "GA" => "Georgia",
            "HI" => "Hawaii",
            "ID" => "Idaho",
            "IL" => "Illinois",
            "IN" => "Indiana",
            "IA" => "Iowa",
            "KS" => "Kansas",
            "KY" => "Kentucky",
            "LA" => "Louisiana",
            "ME" => "Maine",
            "MD" => "Maryland",
            "MA" => "Massachusetts",
            "MI" => "Michigan",
            "MN" => "Minnesota",
            "MS" => "Mississippi",
            "MO" => "Missouri",
            "MT" => "Montana",
            "NE" => "Nebraska",
            "NV" => "Nevada",
            "NH" => "New Hampshire",
            "NJ" => "New Jersey",
            "NM" => "New Mexico",
            "NY" => "New York",
            "NC" => "North Carolina",
            "ND" => "North Dakota",
            "OH" => "Ohio",
            "OK" => "Oklahoma",
            "OR" => "Oregon",
            "PA" => "Pennsylvania",
            "RI" => "Rhode Island",
            "SC" => "South Carolina",
            "SD" => "South Dakota",
            "TN" => "Tennessee",
            "TX" => "Texas",
            "UT" => "Utah",
            "VT" => "Vermont",
            "VA" => "Virginia",
            "WA" => "Washington",
            "WV" => "West Virginia",
            "WI" => "Wisconsin",
            "WY" => "Wyoming",
        );
    }

    function paymenttype() {
        return array(
            'Credit Card' => "Credit Card",
            'PayPal' => "PayPal",
            'ACH' => "ACH",
            'Check' => "Check",
            'Wire' => "Wire",
            'Free/No Charge' => "Free/No Charge",
        );
    }

    function creditcardtype() {
        return array(
            'visa' => "visa",
            'mastercard' => "mastercard",
            'discover' => "discover",
            'AmEx' => "American Express",
        );
    }

    function FormatYesNoNA($data) {
        if ($data == 1)
            $data = 'Yes';
        else if ($data == 2)
            $data = 'No';
        else
            $data = 'N/A';
        return $data;
    }

    function DoPersonalizedFields($text, $fields = array(), $demoFields = false) {
        error_reporting(0);
        if ($demoFields == true) {
            $fields['orderid'] = '1111-11111-1111';
            $fields['buyername'] = 'John Doe';
            $fields['amazonstorename'] = 'Your Amazon Store Name';
            $fields['purchasedateorginal'] = date("j/n/Y");
            $fields['amazonasin'] = '1111111';

            if (empty($fields['mws_sellerid']))
                $fields['mws_sellerid'] = '1111111';
            $fields['productname'] = 'Your product name here.';
            $fields['sku'] = 'Your product sku here.';
            $fields['buyeremail'] = 'John@gmail.com';
            $fields['itemprice'] = 'Your product price here.';
            $fields['shippingprice'] = 'Your product shipping price here.';
            $fields['shipaddress1'] = 'Your Shiping Address here.';
            $fields['shipcity'] = 'Your ship city here';
            $fields['shipcountry'] = 'Your ship country here';
            $fields['shipstate'] = 'Your ship state here';
            $fields['shipzip'] = 'Your ship zip here';
            $fields['quantity'] = 'Your product quantity';
            $fields['productimg'] = '<img src="' . base_url() . 'images/templatelogo/productimg.jpg" alt="your product image" width="247" height="247" />';
//            $fields['productreviewurl'] = '<a href="https://www.amazon.com/review/create-review?ie=UTF8&asin=" style="background-color:#3cc1f2; max-width:600px; width:100%; color:#FFF; display:table; border-radius:50px; text-align:center; font-size:20px; text-decoration:none; line-height:15px;"><p id="u96-2">Yes</p></a>';
        }
        $amazonTld = '.com';
        if (!empty($fields['saleschannel'])) {
            if ($fields['saleschannel'] == 'Amazon.com') {
                $fields['mws_marketplaceid'] = 'ATVPDKIKX0DER';
                $amazonTld = '.com';
            }
            if ($fields['saleschannel'] == 'Amazon.ca') {
                $fields['mws_marketplaceid'] = 'A2EUQ1WTGCTBG2';
                $amazonTld = '.ca';
            }
            if ($fields['saleschannel'] == 'Amazon.mx') {
                $fields['mws_marketplaceid'] = 'A1AM78C64UM0Y8';
                $amazonTld = '.mx';
            }
            if ($fields['saleschannel'] == 'Amazon.de') {
                $fields['mws_marketplaceid'] = 'A1PA6795UKMFR9';
                $amazonTld = '.de';
            }
            if ($fields['saleschannel'] == 'Amazon.es') {
                $fields['mws_marketplaceid'] = 'A1RKKUPIHCS9HS';
                $amazonTld = '.es';
            }
            if ($fields['saleschannel'] == 'Amazon.fr') {
                $fields['mws_marketplaceid'] = 'A13V1IB3VIYZZH';
                $amazonTld = '.fr';
            }
            if ($fields['saleschannel'] == 'Amazon.in') {
                $fields['mws_marketplaceid'] = 'A21TJRUUN4KGV';
                $amazonTld = '.in';
            }
            if ($fields['saleschannel'] == 'Amazon.it') {
                $fields['mws_marketplaceid'] = 'APJ6JRA9NG5V4';
                $amazonTld = '.it';
            }
            if ($fields['saleschannel'] == 'Amazon.co.uk') {
                $fields['mws_marketplaceid'] = 'A1F83G8C2ARO7P';
                $amazonTld = '.co.uk';
            }
            if ($fields['saleschannel'] == 'Amazon.jp') {
                $fields['mws_marketplaceid'] = 'A1VC38T7YXB528';
                $amazonTld = '.jp';
            }
            if ($fields['saleschannel'] == 'Amazon.com.cn') {
                $fields['mws_marketplaceid'] = 'AAHKV2X7AFYLW';
                $amazonTld = '.com.cn';
            }
        }
        if ($fields['small_img_url'] == '')
            $fields['small_img_url'] = '';
        $text = str_replace("[imagebase_url]", base_url(), $text);
        $text = str_replace("[amazontld]", $amazonTld, $text);
        $text = str_replace("[sku]", $fields['sku'], $text);
        $text = str_replace("[buyeremail]", $fields['buyeremail'], $text);
        $text = str_replace("[itemprice]", $fields['itemprice'], $text);
        $text = str_replace("[shippingprice]", $fields['shippingprice'], $text);
        $text = str_replace("[quantity]", $fields['quantity'], $text);
        $text = str_replace("[shipaddress1]", $fields['shipaddress1'], $text);
        $text = str_replace("[shipcity]", $fields['shipcity'], $text);
        $text = str_replace("[shipcountry]", $fields['shipcountry'], $text);
        $text = str_replace("[shipstate]", $fields['shipstate'], $text);
        $text = str_replace("[shipzip]", $fields['shipzip'], $text);
        $text = str_replace("[productname]", $fields['productname'], $text);
        $text = str_replace("[[OrderNumber]]", $fields['orderid'], $text);
        $text = str_replace("[ordernumber]", $fields['orderid'], $text);
        $text = str_replace("[orderdetailboxcolor]", $fields['orderdetailboxcolor'], $text);
        $text = str_replace("[orderdetailboxtext]", $fields['orderdetailboxtext'], $text);
        $text = str_replace("[order number]", $fields['orderid'], $text); // for people who make a typo
        $text = str_replace('{$amazonlogo}', '<img src="' . base_url() . 'images/templatelogo/amazon-logo.png" alt="Logo" >', $text);
        if($fields['small_img_url']){
            $productImage = '"<img src="'.$fields['small_img_url'].'" height="247" width="247">"';
        }else{
            $productImage = '<img src="http://ecx.images-amazon.com/images/I/31piTDF7v4L.jpg" height="247" width="247">';
        }
        $text = str_replace("[productimg]", $productImage , $text);
        $text = str_replace("[[OrderLink]]", '<a href="https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '">https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '</a>', $text);
        $text = str_replace("[orderlink]", '<a href="https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '">https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '</a>', $text);
        $text = str_replace("[customorderlink]", 'https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'], $text);
        $text = str_replace("[excellentbuttonlink]", 'https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?order=' . $fields['orderid'].'&pageSize=1', $text);
        $text = str_replace("[productReviewLink]", 'https://www.amazon.com/review/create-review?asin='.$fields[amazonasin],$text);
        preg_match_all("/\[orderlink:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        preg_match_all("/\[customorderlink:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        preg_match_all("/\[Excellentbuttonlink:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        preg_match_all("/\[productReviewLink:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '">' . $matches[1][$i] . '</a>', $text);
        }
        $text = str_replace("[order-link]", '<a href="https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '">https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '</a>', $text);
        preg_match_all("/\[order-link:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/gp/css/order-details?orderId=' . $fields['orderid'] . '">' . $matches[1][$i] . '</a>', $text);
        }
        $text = str_replace("[CompanyName]", $fields['amazonstorename'], $text);
        $text = str_replace("[amazonstorename]", $fields['amazonstorename'], $text);
        $text = str_replace("[[CustomerName]]", ucwords($fields['buyername']), $text);
        $text = str_replace("[customername]", ucwords($fields['buyername']), $text);
        $tmp = explode(" ", $fields['buyername']);
        $firstname = $tmp[0];
        if (count($tmp) == 1)
            $lastname = '';
        else
            $lastname = array_pop($tmp);

        $text = str_replace("[[CustomerFirstName]]", ucwords($firstname), $text);
        $text = str_replace("[[CustomerLastName]]", ucwords($lastname), $text);
        $text = str_replace("[customerfirstname]", ucwords($firstname), $text);
        $text = str_replace("[customerlastname]", ucwords($lastname), $text);
        $text = str_replace("[[OrderDate]]", $fields['purchasedateorginal'], $text);
        $text = str_replace("[orderdate]", $fields['purchasedateorginal'], $text);
        $text = str_replace("[notsogreat]", "https://www.amazon.com/gp/help/contact/contact.html?marketplaceID=ATVPDKIKX0DER&orderID={$fields['orderid']}&sellerID={$fields['mws_sellerid']}",$text);
        $text = str_replace("[addreviewurl]", '<a href="' . base_url() . 'productreview?orderid=' . $fields['orderid'] . '"><p>No Thanks</p></a>', $text);
        $text = str_replace("[[FeedbackLink]]", '<a href="https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '">Leave Seller Feedback</a>', $text);
        $text = str_replace("[sellerfeedbacklink]", '<a href="https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '">Leave Seller Feedback</a>', $text);
        preg_match_all("/\[sellerfeedbacklink:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '">' . $matches[1][$i] . '</a>', $text);
        }

        $text = str_replace("[sellerfeedback-link]", '<a href="https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '">Leave Seller Feedback</a>', $text);
        preg_match_all("/\[sellerfeedback-link:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '">' . $matches[1][$i] . '</a>', $text);
        }
        $text = str_replace("[sellerfeedbacklonglink]", 'https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '', $text);
        $text = str_replace("[sellerfeedback-url]", 'https://www.amazon' . $amazonTld . '/gp/feedback/leave-customer-feedback.html/?pageSize=1&order=' . $fields['orderid'] . '', $text);
//        $product_url = base_url() . 'product?orderid=';
//        $text = str_replace("[[ProductReviewLink]]", '<a href="' . $product_url . $fields['orderid'] . '">Leave Product Review</a>', $text);
//        $text = str_replace("[productreview-link]", '<a href="' . $product_url . $fields['orderid'] . '">Leave Product Review</a>', $text);
//        preg_match_all("/\[productreview-link:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
//        $count = count($matches[1]);
//        for ($i = 0; $i < $count; $i++) {
//
//            $text = str_replace($matches[0][$i], '<a href="' . $product_url . $fields['orderid'] . '">' . $matches[1][$i] . '</a>', $text);
//        }
//        $text = str_replace("[productreview-url]", $product_url, $text);
        $text = str_replace("[productreviewurl]", '<a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=' . $fields['amazonasin'] . '" style="background-color:#3cc1f2; max-width:600px; width:100%; color:#FFF; display:table; border-radius:50px; text-align:center; font-size:20px; text-decoration:none; line-height:15px;"><p id="u96-2">Yes</p></a>', $text);
        $text = str_replace("[[ProductReviewLink]]", '<a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=' . $fields['amazonasin'] . '">Leave Product Review</a>', $text);
        $text = str_replace("[productreview-link]", '<a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=' . $fields['amazonasin'] . '">Leave Product Review</a>', $text);
        preg_match_all("/\[productreview-link:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=' . $fields['amazonasin'] . '">' . $matches[1][$i] . '</a>', $text);
        }
        $text = str_replace("[productreview-url]", 'https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=', $text);

        $text = str_replace("[amazonstorelink]", '<a href="https://www.amazon' . $amazonTld . '/shops/' . $fields['mws_sellerid'] . '">Visit ' . $fields['amazonstorename'] . ' store</a>', $text);
        preg_match_all("/\[amazonstorelink:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/shops/' . $fields['mws_sellerid'] . '">' . $matches[1][$i] . '</a>', $text);
        }
        $text = str_replace("[amazonstore-link]", '<a href="https://www.amazon' . $amazonTld . '/shops/' . $fields['mws_sellerid'] . '">Visit ' . $fields['amazonstorename'] . ' store</a>', $text);
        preg_match_all("/\[amazonstore-link:([A-Za-z\|!#,\.$0-9 ]*)\]/is", $text, $matches);
        $count = count($matches[1]);
        for ($i = 0; $i < $count; $i++) {

            $text = str_replace($matches[0][$i], '<a href="https://www.amazon' . $amazonTld . '/shops/' . $fields['mws_sellerid'] . '">' . $matches[1][$i] . '</a>', $text);
        }
        $text = str_replace("[amazonstore-url]", 'https://www.amazon' . $amazonTld . '/shops/' . $fields['mws_sellerid'] . '', $text);
        $text = str_replace("[[ItemList]]", '<ul><li>' . $fields['productname'] . '</li></ul>', $text);
        $text = str_replace("[orderitems]", '<ul><li>' . $fields['productname'] . '</li></ul>', $text);
        $text = str_replace("[[ItemListReviewLink]]", '<ul><li>' . $fields['productname'] . ' <a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=abc">Leave Product Review</a></li></ul>', $text);
        $text = str_replace("[orderitemsreviewlink]", '<ul><li>' . $fields['productname'] . ' <a href="' . $product_url . $fields['orderid'] . '">Leave Product Review</a></li></ul>', $text);
        // No bullet
        $text = str_replace("[[ItemListnobullet]]", $fields['productname'], $text);
        $text = str_replace("[orderitemsnobullet]", $fields['productname'], $text);
        $text = str_replace("[[ItemListReviewLinknobullet]]", $fields['productname'] . ' <a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=">Leave Product Review</a>', $text);
        $text = str_replace("[orderitemsreviewlinknobullet]", $fields['productname'] . ' <a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=">Leave Product Review</a>', $text);
        return $text;
    }
    function ReturnEmailType($type) {
        switch ($type) {
            case 1:
                return '1st Email';
                break;
            case 2:
                return '2nd Email';
                break;
            case 3:
                return '3rd Email';
                break;
            case 4:
                return '4th Email';
                break;
        }
    }
    function ReturnsmsType($type) {
        switch ($type) {
            case 1:
                return '1st SMS Feedback Reminder';
                break;
            case 2:
                return '2nd SMS Feedback Reminder';
                break;
            case 3:
                return '3rd SMS Feedback Reminder';
                break;
            case 4:
                return '4th SMS Feedback Reminder';
                break;
        }
    }
    function ReplaceOtherFeedbackSystemTags($text = '') {

        $text = str_replace("[[first-name]]", "[customerfirstname]", $text);
        $text = str_replace("[[buyer-name]]", "[customername]", $text);

        $text = str_replace("[[excellent-feedback-link]]", "[sellerfeedbackexcellent-link]", $text);
        $text = str_replace("[[feedback-link]]", "[sellerfeedback-link]", $text);

        $text = str_replace("[[order-link]]", "[order-link]", $text);
        $text = str_replace("[[contact-link]]", "[contact-link]", $text);

        $text = str_replace("[[store-link]]", "[amazonstore-link]", $text);
        $text = str_replace("[[product-review-link]]", "[productreview-link]", $text);
        $text = str_replace("[[asin]]", "[asin]", $text); // asin coming soon

        $text = str_replace("[[product-name]]", "[productname]", $text);
        $text = str_replace("[[msku]]", "[sku]", $text);
        $text = str_replace("[[quantity]]", "[quantity]", $text);

        $text = str_replace("[[price-item]]", "[itemprice]", $text);
        $text = str_replace("[[price-shipping]]", "[shippingprice]", $text);
        $text = str_replace("[[buyer-email]]", "[buyeremail]", $text);

        $text = str_replace("[[recipient]]", "[recipient]", $text);
        $text = str_replace("[[ship-address1]]", "[shipaddress1]", $text);
        $text = str_replace("[[ship-address2]]", "[shipaddress2]", $text);
        $text = str_replace("[[ship-city]]", "[shipcity]", $text);
        $text = str_replace("[[ship-state]]", "[shipstate]", $text);
        $text = str_replace("[[ship-zip]]", "[shipzip]", $text);
        $text = str_replace("[[ship-country]]", "[shipcountry]", $text);

        $text = str_replace("[[carrier]]", "[shippingcarrier]", $text);
        $text = str_replace("[[tracking-number]]", "[trackingnumber]", $text);
        $text = str_replace("[[estimated-arrival]]", "[estimatedarrivaldate]", $text);
        $text = str_replace("[[productimg]]", "[productimg]", $text);
        return $text;
    }
    function ReplaceHtmlTags($text = '') {
        $baseurl = base_url();
        $text = str_replace("[imagebase_url]", $baseurl, $text);
        return $text;
    }
    function ReturnMessageHTML($messageID = 0) {
        $CI = & get_instance();
        $CI->load->database();
        $query = $CI->db->query("SELECT
			m.ID_MESSAGE, m.html_msg,m.emailtype,m.wizard,
			m.subject,m.fromname,m.headerText,m.headerContent,m.bottombodyHeader,m.bottombodyText,m.bodyHeader,m.footerHeaderText,m.footerText,m.ID_IMAGE,m.ID_SatisfactionGuaranteedImage,m.logourl,m.homepagefooter,m.wizardbody,m.headercolor,m.squarecolor,
			m.backgroundcolor,m.bordercolor,m.fontcolor,m.datemodified,m.ID_TEMPLATE,m.headerimage,
			m.ID_ACCOUNT, i.filename,i.height, i.width, m.wizard, s.amazonstorename,m.homepagefooter,m.orderdetailboxcolor,m.orderdetailboxtext 
			FROM (feedback_messages AS m, feedback_settings as s)
				LEFT JOIN imagehosting as i ON (i.ID_IMAGE = m.ID_IMAGE)
			WHERE s.ID_ACCOUNT = m.ID_ACCOUNT AND m.ID_MESSAGE = $messageID
			");
        $msgRow = $query->row_array();
        $satisfactionQuery = $CI->db->query("SELECT i.filename FROM (imagehosting as i,feedback_settings as s)LEFT JOIN feedback_messages as m ON (m.ID_SatisfactionGuaranteedImage = i.ID_IMAGE) WHERE s.ID_ACCOUNT = m.ID_ACCOUNT AND m.ID_MESSAGE = $messageID");
        $satisfactionImages = $satisfactionQuery->row_array();
        $headerimageQuery = $CI->db->query("SELECT i.filename FROM (imagehosting as i,feedback_settings as s)LEFT JOIN feedback_messages as m ON (m.headerimage = i.ID_IMAGE) WHERE s.ID_ACCOUNT = m.ID_ACCOUNT AND m.ID_MESSAGE = $messageID");
        $headerImages = $headerimageQuery->row_array();
        $data = '';
        if (!empty($msgRow['wizard']) && !empty($msgRow['ID_TEMPLATE'])) {
            $query = $CI->db->query("
		SELECT ID_TEMPLATE, html_msg,backgroundcolor, bordercolor, fontcolor, title,previewimage,SatisfactionGuaranteedImage,logoimage
		FROM feedback_templates
		WHERE ID_TEMPLATE = " . $msgRow['ID_TEMPLATE'] . "
		");
            $templateRow = $query->row_array();

            $data = $templateRow['html_msg'];
            $data = str_replace('{$amazonlogo}', '<img src="' . base_url() . 'images/templatelogo/amazon-logo.png" alt="Logo" >', $data);
            $data = str_replace('{$subject}', $msgRow['subject'], $data);
            $data = str_replace('{$headercolor}', $msgRow['headercolor'], $data);
            $data = str_replace('{$squarecolor}', $msgRow['squarecolor'], $data);
            $data = str_replace('{$headerText}', $msgRow['headerText'], $data);
            $data = str_replace('{$headerContent}', $msgRow['headerContent'], $data);
            $data = str_replace('{$bottombodyHeader}', $msgRow['bottombodyHeader'], $data);
            $data = str_replace('{$bottombodyText}', $msgRow['bottombodyText'], $data);
            $data = str_replace('{$bodyHeader}', $msgRow['bodyHeader'], $data);
            $data = str_replace('{$bodyText}', $msgRow['wizardbody'], $data);
            $data = str_replace('{$footerHeaderText}', $msgRow['footerHeaderText'], $data);
            $data = str_replace('{$footerText}', $msgRow['footerText'], $data);
            $data = str_replace('{$backgroundcolor}', $msgRow['backgroundcolor'], $data);
            $data = str_replace('{$bordercolor}', $msgRow['bordercolor'], $data);
            $data = str_replace('{$fontcolor}', $msgRow['fontcolor'], $data);
            $data = str_replace('{$siteurl}', base_url(), $data);

            $data = str_replace("[Excellentbuttonlink]", '', $data);
            $data = str_replace('{$imgurl}', base_url().'images/templates/'.$msgRow['ID_TEMPLATE'].'/', $data);
//            $data = str_replace("[productimg]", $productImage , $data);
            $data = str_replace("[imagebase_url]", base_url(), $data);
            $data = str_replace('{$orderboxbackcolor}', ($msgRow['orderdetailboxcolor'] ? $msgRow['orderdetailboxcolor'] : '565857'), $data);
            $data = str_replace('{$orderboxtextcolor}', ($msgRow['orderdetailboxtext'] ? $msgRow['orderdetailboxtext'] : 'fff'), $data);
//            $data = str_replace("[productreviewurl]", '<a href="https://www.amazon' . $amazonTld . '/review/create-review?ie=UTF8&asin=' . $fields['amazonasin'] . '" style="background-color:#3cc1f2; max-width:600px; width:100%; color:#FFF; display:table; border-radius:50px; text-align:center; font-size:20px; text-decoration:none; line-height:15px;"><p id="u96-2">Yes</p></a>', $data);
            if(!empty($headerImages['filename']))
                $data = str_replace('{$headerimage}', base_url().'images/templatelogo/'.$msgRow['ID_ACCOUNT'].'/'.$headerImages['filename'], $data);
            else
                $data = str_replace('{$headerimage}', base_url().'images/templates/'.$msgRow['ID_TEMPLATE'].'/images/main-image.png', $data);
            if (!empty($satisfactionImages['filename']))
                $data = str_replace('{$satisfacationImage}', '<img src="' . base_url() . 'images/satisfactionImage/' . $msgRow['ID_ACCOUNT'] . '/' . $satisfactionImages['filename'] . '" alt="satisfactionImage" class="block" border="0" height="' . $msgRow['height'] . '" width="' . $msgRow['width'] . '" style="display: block; border: none;">', $data);
            else
                $data = str_replace('{$satisfacationImage}', '<img src="' . base_url() . 'images/' . $templateRow['SatisfactionGuaranteedImage'] . '" alt="satisfactionImage" class="block" style="display: block; border: none;">', $data);
            if (!empty($msgRow['filename']))
                $data = str_replace('{$logo}', '<img src="' . base_url() . 'images/templatelogo/' . $msgRow['ID_ACCOUNT'] . '/' . $msgRow['filename'] . '" alt="Logo" class="block" border="0" height="' . $msgRow['height'] . '" width="' . $msgRow['width'] . '" style="display: block; border: none;">', $data);
            else
                $data = str_replace('{$logo}', '<h1><font face="Arial Black">' . $msgRow['amazonstorename'] . '</font></h1>', $data);



            // If no footer
            IF ($msgRow['homepagefooter'] == 0)
                $data = str_replace("[amazonstorelink]", '', $data);
//            $data = str_replace("[addreviewurl]", '<a href="' . base_url() . 'productreview?orderid=' . '"><p>No Thanks</p></a>', $data);
            // $data = str_replace("[productimg]", 'Your Product Image here', $data);
            $data = str_replace('<!-- ///////////////////////////////////// NEWSLETTER CONTENT  /////////////////////////////////// -->', '', $data);
            $data = str_replace('<!-- ////////////////////////////////// START MAIN CONTENT WRAP ////////////////////////////////// -->', '', $data);
            $data = str_replace('<!-- WRAPPER TABLE -->', '', $data);
            $data = str_replace('<!-- ////////////////////////////////// END MAIN CONTENT ///////////////////////////////////////// -->', '', $data);
            $data = str_replace('<!-- ////////////////////////////////// END MAIN CONTENT WRAP //////////////////////////////////// -->', '', $data);
            $data = str_replace('<!-- ///////////////////////////////////// END NEWSLETTER CONTENT  /////////////////////////////// -->', '', $data);
            $data = str_replace('<!-- END WRAPPER TABLE -->', '', $data);
            $data = str_replace('{$message}', nl2br($msgRow['wizardbody']), $data);
        }
        else {
            $data = $msgRow['html_msg'];
        }
        return $data;
    }
    function Emailtype() {
        return array(
            '1' => "1st Email",
            '2' => "2nd Email",
            '3' => "3rd Email",
            '4' => "4th Email",
        );
    }
    function smstype() {
        return array(
            '1' => "1st SMS Feedback Reminder",
            '2' => "2nd SMS Feedback Reminder",
            '3' => "3rd SMS Feedback Reminder",
            '4' => "4th SMS Feedback Reminder",
        );
    }
    function smsgateway() {
        return array(
            'planet' => "planet",
            'plivo' => "plivo",
            'twilio' => "twilio",
            'clickatell' => "clickatell",
            'nexmo' => "nexmo",
        );
    }
    function orderimportdays() {
        return array(
            '10' => "10 Days",
            '15' => "15 Days",
            '20' => "20 Days",
            '30' => "30 Days",
        );
    }
    function LoadFeedbackSettings($accountID) {
        $CI = & get_instance();
        $CI->load->database();
        if (empty($accountID))
            return 0;
        $query = $CI->db->query("SELECT s.*,a.planstringid,p.ID_FEEDBACKPLAN, p.title, p.emails, p.plan_productreviewlink, p.plan_requestremovalfeedback,
                           p.plan_alertsfornegativefeedback,p.plan_lateshippmentemail,p.plan_reports,p.overage_emails
                           FROM (feedback_settings as s, accounts as a)
                           LEFT JOIN feedback_plans as p ON (p.ID_FEEDBACKPLAN = a.ID_FEEDBACKPLAN)
                           WHERE a.ID_ACCOUNT = s.ID_ACCOUNT AND s.ID_ACCOUNT = $accountID LIMIT 1");
        $settings = $query->row_array();
        ;
        return $settings;
    }
    function GetMarketPlaceIDFromSalesChannel($saleschannel) {

        if ($saleschannel == 'Amazon.com') {
            return 'ATVPDKIKX0DER';
        }
        if ($saleschannel == 'Amazon.ca') {
            return 'A2EUQ1WTGCTBG2';
        }
        if ($saleschannel == 'Amazon.mx') {
            return 'A1AM78C64UM0Y8';
        }
        if ($saleschannel == 'Amazon.de') {
            return 'A1PA6795UKMFR9';
        }
        if ($saleschannel == 'Amazon.es') {
            return 'A1RKKUPIHCS9HS';
        }
        if ($saleschannel == 'Amazon.fr') {
            return 'A13V1IB3VIYZZH';
        }
        if ($saleschannel == 'Amazon.in') {
            return 'A21TJRUUN4KGV';
        }
        if ($saleschannel == 'Amazon.it') {
            return 'APJ6JRA9NG5V4';
        }
        if ($saleschannel == 'Amazon.co.uk') {
            return 'A1F83G8C2ARO7P';
        }
        if ($saleschannel == 'Amazon.jp') {
            return 'A1VC38T7YXB528';
        }
        if ($saleschannel == 'Amazon.com.cn') {
            return 'AAHKV2X7AFYLW';
        }
        return '';
    }
    function GetSingleASN($storename = '', $accountID = 0) {
        global $store, $AMAZON_SERVICE_URL, $db, $FBC_amazon_reqest_info;
        $asnText = '';
        $CI = & get_instance();
        $CI->load->library('amazon');
        // Getting asins
        $result = $CI->db->query("
	SELECT a.ID_ACCOUNT, s.mws_sellerid, m.marketplace_id, d.access_key, d.secret_key, m.host,s.amazonstorename,
	s.loadedfirstorderdata,s.mws_authtoken
	FROM accounts as a, feedback_settings as s
        LEFT JOIN marketplaces as m ON (m.id = s.mws_marketplaceid)
        LEFT JOIN dev_accounts as d ON (d.marketplace_id = m.id)
	WHERE s.ID_ACCOUNT = a.ID_ACCOUNT and s.apiactive = 1 AND s.asinstoprocess != 0 AND a.removed = 0 AND s.mws_marketplaceid is not null AND a.enabled = 1 AND d.access_key  is not null and d.secret_key is not null
	AND a.ID_ACCOUNT = $accountID");
        foreach ($result->result() as $row) {
            if (empty($row->access_key))
                continue;
            if (empty($row->marketplace_id))
                continue;
            $skus = array();
            $result2 = $CI->db->query("SELECT sku,amazonasin FROM feedback_asin WHERE ID_ACCOUNT = " . $row->ID_ACCOUNT . " AND completed = 0 AND errored = 0 AND ID_ASIN = $asnID");
            foreach ($result2->result() as $skuRow) {
                $skus[] = $skuRow->sku;
                if (!empty($skuRow->amazonasin))
                    return $skuRow->amazonasin;
            }
            if (empty($skus))
                continue;
            $store[$row->amazonstorename]['fdc_requesttype'] = "getasin";
            $store[$row->amazonstorename]['ID_ACCOUNT'] = $row->ID_ACCOUNT;
            $store[$row->amazonstorename]['merchantId'] = $row->mws_sellerid; //Merchant ID for this store
            $store[$row->amazonstorename]['marketplaceId'] = $row->marketplace_id; //Marketplace ID for this store
            $store[$row->amazonstorename]['keyId'] = $row->access_key; //Access Key ID
            $store[$row->amazonstorename]['secretKey'] = $row->secret_key; //Secret Access Key for this store
            $store[$row->amazonstorename]['MWSAuthToken'] = $row->mws_authtoken; //Secret Access Key for this store
            $AMAZON_SERVICE_URL = $row->host . "/";
            $productInfo = new AmazonProductInfo($row->amazonstorename);
            $productInfo->setSKUs($skus);
            // Do the request
            $productInfo->fetchMyPrice();
            $productList = $productInfo->getProduct();
            //print_r($productList);
            if (is_array($productList)) {
                foreach ($productList as $product) {
                    // Printing out a product
                    //print_r($product);
                    if (is_object($product)) {
                        $data = $product->getData();
                        $asin = (string) $data['Identifiers']['MarketplaceASIN']['ASIN'];
                        $SellerSKU = (string) $data['Identifiers']['SKUIdentifier']['SellerSKU'];
                        $MarketplaceId = (string) $data['Identifiers']['MarketplaceASIN']['MarketplaceId'];
                        //echo "ASIN: " . $asin . " sELLER SKU: ". $SellerSKU . " MKTG: " . $MarketplaceId . "<BR>";
                        $asnText = $asin;
                        $CI->db->query("UPDATE feedback_asin SET amazonasin = '$asin', completed = 1 WHERE ID_ACCOUNT = " . $row->ID_ACCOUNT . " AND sku = '$SellerSKU' and mws_marketplaceid = '$MarketplaceId'");
                    } ELSE {
                        if (substr_count($product, " is an invalid SellerSKU for marketplace ") > 0) {
                            $tmp = explode(" is an invalid SellerSKU for marketplace ", $product);
                            $skuid = $tmp[0];
                            $mtpid = $tmp[1];
                            $CI->db->query("DELETE FROM feedback_asin WHERE ID_ACCOUNT = " . $row->ID_ACCOUNT . " AND sku = '$skuid' and mws_marketplaceid = '$mtpid'");
                        }
                    }
                } // end foreach
            } // end isarray
            //print_r($productInfo);
        }
        return $asnText;
    }
    function LogTextFile($message = '', $file = 'log.txt') {
        error_log(date("m-d-Y, g:i:s a") . " " . $message . "\n", 3, $_SERVER['DOCUMENT_ROOT'] . '/refund_rescuer/' . $file);
    }

    function GetProductImgad_Asin($amazonstore = '', $accountID = 0, $sku) {

        global $store, $AMAZON_SERVICE_URL, $db, $FBC_amazon_reqest_info, $accountid;

        $imgurl = '';
        $products = array();
        $CI = & get_instance();
        $CI->load->library('amazon');
        // Getting asins

        $productInfo = new AmazonProductList($amazonstore);
        $productInfo->setIdType("SellerSKU");
        //print_r($productInfo);exit;
        // Do the request
        $productInfo->setProductIds($sku);
        $productInfo->fetchProductList();

        $productList = $productInfo->getProduct();
        // print_r($productList);exit;
        if (is_array($productList)) {
            foreach ($productList as $product) {
                // Printing out a product
                if (is_object($product)) {
                    $data = $product->getData();
                    $attributedata[] = $data['AttributeSets'];
                    foreach ($attributedata as $data1) {
                        foreach ($data1 as $row) {
                            $products['small_url'] = $row['SmallImage']['URL'];
                        }
                    }
                    $products['asin'] = $data['Identifiers']['MarketplaceASIN']['ASIN'];
                    //$MarketplaceId = (string) $data['Identifiers']['MarketplaceASIN']['MarketplaceId'];
                    //$imgurl = $small_img_url;
                    // $CI->db->query("UPDATE feedback_orders join feedback_asin on feedback_orders.sku = feedback_asin.sku SET small_img_url = '. $small_img_url .' WHERE `feedback_orders`.`ID_ACCOUNT` = '. $accountid .' AND `feedback_asin`.`amazonasin` = '. $asin .'");
                }
            } // end foreach
        } // end isarray
        $products['small_url'] = str_replace("._SL75_", "", $products['small_url']);
        return json_encode($products);
    }

    function phonecodebycountry($country) {
        switch ($country) {
            case 'US':
                return 1;
                break;
            case 'India':
                return 91;
                break;
        }
    }

    /*
     * setup for stripe payment gatway
     */

    function stripe_setting() {
        include (APPPATH . "/libraries/stripe/init.php");
        \Stripe\Stripe::setApiKey(secret_key);
    }
}

?>
