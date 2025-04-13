<?php

use Curl\Curl;

// LIST PAGE
$router->get(blog, function() {

$req = new Curl();
$url = explode('/', $_GET['url']);
$req->get(api_url.'api/blog/list?appKey='.api_key);
if ($req->error) { 	// $req->error;
} else { $blogs_data = json_decode($req->response); };

$title = "Blog";
$meta_title = "Blog";
$meta_appname = "";
$meta_desc = "";
$meta_img = "";
$meta_url = ""; 
$meta_author = "";
$meta = "1";

$body = views."modules/blog/list.php";
include layout; });

// DETAILS PAGE
$router->get(blog.'(.*)', function() {

$req = new Curl();
$url = explode('/', $_GET['url']);
$req->get(api_url.'api/blog/detail?id='.$url[2].'?appKey'.api_key);

$blogs_details = json_decode($req->response);

// dd($blogs_details);
// die;

$title = $blogs_details->response->title;
$meta_title = $blogs_details->response->title;
$meta_appname = "";
$meta_desc = strip_tags($blogs_details->response->description);
$meta_img = "";
$meta_url = "";
$meta_author = "";
$meta = "1";

$body = views."modules/blog/detail.php";
include layout; });