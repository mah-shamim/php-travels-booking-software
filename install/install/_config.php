<?php

use Medoo\Medoo;

// DEVELOPMENT MODE
define('DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? 'On' : 'Off');

// API KEY
define('api_key','api_key001'); 
define('api_url', "api/"); // ADD SLASH IN THE END OF STRING

define('server','localhost'); 
define('dbname',"%DATABASE%"); 
define('username',"%USERNAME%"); 
define('password',"%PASSWORD%"); 