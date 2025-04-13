<?php

// USING MEEDO NAMESPACE
use Medoo\Medoo;

// VENDORS
require_once __DIR__ . "../../vendor/autoload.php";
require_once  __DIR__."/../_config.php";
require_once  __DIR__."/_core.php";

// define('api_key','api_key001');

// AUTO CURRENCY UPDATE API LAYER KEY 
define('api_layer_key','tV49I6NAZAujknDAtR6ywfhlBlytvZ9P');

$db = new Medoo([
'type' => 'mysql',
'host' => server,
'database' => dbname,
'username' => username,
'password' => password
]);