<?php

set_include_path(get_include_path() . PATH_SEPARATOR .  getcwd().'\application\libraries');
function autoloadInboundClasses($className)
{
    $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    echo "<pre>"; print_r($filePath);


    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    foreach($includePaths as $includePath)
    {
        if(file_exists($includePath . DIRECTORY_SEPARATOR . $filePath))
        {
            require_once $filePath;
            return;
    }
}
}
spl_autoload_register('autoloadInboundClasses');
?>