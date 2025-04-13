<?php

use Curl\Curl;

$router->get(offers, function() {

$req = new Curl();
$req->get(api_url.'api/offers/list?appKey='.api_key);
if ($req->error) {  // $req->error;
} else { $offers_data = json_decode($req->response); };

$title = "Offers";
$meta_title = "Offers";
$meta_appname = "";
$meta_desc = "";
$meta_img = "";
$meta_url = ""; 
$meta_author = "";
$meta = "1";

$body = views."modules/offers/list.php";
include layout;

});

$router->get('offers/'.'(.*)', function() {
 
$req = new Curl();
$url = explode('/', $_GET['url']);
$req->get(api_url.'api/offers/details?offer_id='.$url[2].'&appKey='.api_key);
if ($req->error) { 	// $req->error;
} else { $offers = json_decode($req->response); };
$offers_details = $offers->response;
$title = "offers";
$meta_title = "offers";
$meta_appname = "";
$meta_desc = "offers";
$meta_img = "";
$meta_url = "";
$meta_author = "";
$meta = "1";

$body = views."modules/offers/detail.php";
include layout; });
