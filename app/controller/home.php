<?php

use Curl\Curl;
$router->get('/', function() {
$title = slogan;
$meta_title = slogan;
$meta_desc = "";
$meta_img = "";
$meta_url = meta_url;
$meta_author = meta_author;
$meta = "1";

// website offline check
if ($_SESSION['app']->app->offline == true) { require_once views."offline.php"; session_destroy(); die; };

// CLEAR SESSION CHILD AGES | dd($_SESSION); | dd($_SESSION['ages']); 
if (isset($_SESSION['ages'])) { 
unset($_SESSION["ages"]);
unset($_SESSION["hotels_childs"]);
}

if(isset($_SESSION['origin'])){ $origin=$_SESSION['origin'];}
else{$origin='';} if(isset($_SESSION['destination'])){$destination=$_SESSION['destination'];}
else{$destination ='';}
$body = views."home.php";
include layout;
});

$router->get('phpinfo', function() {
phpinfo();
});

$router->get('timeout', function() {
$title = slogan;
$meta_title = slogan;
$meta_desc = "";
$meta_img = "";
$meta_url = meta_url;
$meta_author = meta_author;
$meta = "1";
// session_destroy();
$body = views."timeout.php";
include layout;
});

$router->get('ip', function() {
$ip ="110.36.223.2";
$geo_url = "http://api.ipstack.com/";
$geo = $geo_url.$ip."?access_key=e19ca7b0c95b61b4359e47031ccd2176";
dd(json_decode(file_get_contents($geo)));
}); 

$router->get('subscribe', function() {
if ($_GET['S_email']) {
$req = new Curl();
$req->get(api_url.'api/newsletter/subscribe?appKey='.api_key.'&email='.$_GET['S_email']);
echo $req->response;}else{
echo json_encode(array('error'=>'please add email!'));
}});