<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Amazonfinancemws {

    function __construct() {
        $CI = & get_instance();
        require_once ('MWSFinancesService/mwsfinanceconfig.inc.php'); //autoload classes, not needed if composer is being used
    }

}
?>