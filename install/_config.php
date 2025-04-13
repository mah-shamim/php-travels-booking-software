<?php

use Medoo\Medoo;
define('DEBUG', true);

// EXECUTE ONLY ON LOCALHOST
$whitelist = array( '127.0.0.1', '::1' );
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){

// DEVELOPMENT MODE
error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? 'On' : 'Off'); 
}

// API KEY
define('api_key','api_key001'); 
define('api_url', "api/"); // ADD SLASH IN THE END OF STRING

define('server','localhost'); 
define('dbname',"%DATABASE%"); 
define('username',"%USERNAME%"); 
define('password',"%PASSWORD%"); 