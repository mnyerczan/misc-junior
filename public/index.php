<?php


error_reporting(1);

// Back to the app root
chdir("../");



$config = require "config/server.php";

require "app/functions.php";


// Root directory. Must be at least '/' !
define("APPROOT", $config["applicationRoot"]);

// remove application directory from path
if (APPROOT !== "/")
    $cleanedUri = str_replace( APPROOT,'', explode('?', $config["cwd"])[0]);
else
    $cleanedUri = explode('?', $config["cwd"])[0];
    
// Define backstep for correct url to download sources from public/ folder..
define('BACKSTEP', calcBackStep($cleanedUri));


require "app/core/core.php";