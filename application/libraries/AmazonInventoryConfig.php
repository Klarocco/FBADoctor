<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AmazonInventoryConfig
{

    function __construct()
    {
        $CI = & get_instance();
        require_once ('FBAInboundServiceMWS/amazonInventory.inc.php');
    }

}
?>