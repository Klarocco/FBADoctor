<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Amazon
{
    function __construct()
    {
        $CI = & get_instance();
        require_once('phpamazonmws/includes/classes.php'); //autoload classes, not needed if composer is being used
   }

}

?>
