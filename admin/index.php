<?php

// ALL RIGHTS RESERVED TO PHPTRAVELS

// USING MEEDO NAMESPACE
use Medoo\Medoo;

// X-FRAME OPTIONS
header("X-Frame-Options: SAMEORIGIN");

// INCLUDE CORE FILE
require_once '_config.php';

// CREATE CACHE AND LOGS IF NOT EXIST
if(!file_exists('./cache')) {  mkdir('./cache', 0777, true); }

// ======================== INDEX
header("Location: login.php"); 
exit;

?>