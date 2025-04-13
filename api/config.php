<?php

use Medoo\Medoo;

// DD FUNCTION FOR DEBUG RESPONSES
function dd($d) {  
  header("Content-Type: application/json");
  print_r(json_encode($d));
  die; }

// CONFIG
require_once '../_config.php';

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');

$whitelist = array( '127.0.0.1', '::1' );
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){ 
$host = "localhost"; } else { $host = "api-4b8a059e84"; }

function openconn(){
  $db_host = server;
  $db_name = dbname;
  $db_user = username;
  $db_pass = password;

// Connect the database.
  $db = new Medoo([
      'type' => 'mysql',
      'host' => $db_host,
      'database' => $db_name,
      'username' => $db_user,
      'password' => $db_pass
  ]);
  return $db;
}

$db_host = server;
$db_name = dbname;
$db_user = username;
$db_pass = password;

// Connect the database.
$db = new Medoo([
  'type' => 'mysql',
  'host' => $db_host,
  'database' => $db_name,
  'username' => $db_user,
  'password' => $db_pass
]);
// MAIL SENDER FUNCTION
function MAILER($template,$title,$content,$receiver_email,$receiver_name){
  
  require_once '../_config.php';
  $db = new mysqli(server,username,password,dbname);
  $res = $db->query('SELECT * FROM `settings` WHERE 1')->fetch_object();
  $sender_name = $res->email_sender_name;
  $sender_email = $res->email_sender_email;
  $website_url = $res->site_url;

  ob_start();
  include "../email/".$template.".php";
  $views = ob_get_clean();

  $params = array(
  "api_key" => $res->email_api_key,
  "to" => array("".$receiver_name." <".$receiver_email.">"),
  "sender" => "".$sender_name." <".$sender_email.">",
  "subject" => $title,
  "html_body" => $views,
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://api.smtp2go.com/v3/email/send");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  $res = curl_exec($ch);
  curl_close($ch);
  // echo $res;

}

// INSERT LOGS TO DB
function logs($user_id,$log_type,$datetime,$desc){
  require_once "../_config.php";
  
  $db = new Medoo([ 'type' => 'mysql', 'host' => server, 'database' => dbname, 'username' => username, 'password' => password ]);
  $db->insert("logs", [
  "user_ip" => $_SERVER['REMOTE_ADDR'],
  "user_id" => $user_id,
  "type" => $log_type,
  "datetime" => $datetime,
  "description" => $desc
  ]);
  
  }

// FUNCTION FOR REQUIRED PARAMS
function required($val){ if(isset($_REQUEST[$val]) && trim($_POST[$val]) !== "") {} else { echo $val." - param or value missing "; die; } }

// USER IP
function get_client_ip() { $ipaddress = ''; if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP'); else if(getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR'); else if(getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED'); else if(getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR'); else if(getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED'); else if(getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR'); else $ipaddress = 'UNKNOWN'; return $ipaddress; }

function AUTH_CHECK(){
  // API KEY AUTH LOOKUP
if(isset($_POST['api_key']) && trim($_POST['api_key']) !== "") {} else { 
  $respose = array ( "status"=>false, "message"=>"api_key param or value missing" );
  echo json_encode($respose);  
die; }

if ($_POST['api_key'] == api_key) {} else  { 
  $respose = array ( "status"=>false, "message"=>"api_key invalid" );
  echo json_encode($respose);
die; }
}

