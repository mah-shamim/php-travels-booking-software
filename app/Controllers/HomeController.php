<?php

$router->get('/', function() {

// META DETAILS
$meta = array(
    "title"=>app()->app->home_title,
    "meta_title"=>app()->app->home_title,
    "meta_desc"=>app()->app->meta_description,
    "meta_img"=>"",
    "meta_url"=>"",
    "meta_author"=>"",
);

// CHECK WEBSITE OFFLINE
// if ($_SESSION['app']->app->offline == true) { require_once views."offline.php"; session_destroy(); die; };

// CLEAR SESSION CHILD AGES | dd($_SESSION); | dd($_SESSION['ages']);
if (isset($_SESSION['ages'])) {
unset($_SESSION["ages"]);
unset($_SESSION["hotels_childs"]);
}

if(isset($_SESSION['origin'])){ $origin=$_SESSION['origin'];}
else{$origin='';} if(isset($_SESSION['destination'])){$destination=$_SESSION['destination'];}
else{$destination ='';}
 
views($meta,"Home");

});

$router->get('phpinfo', function() {
phpinfo();
});

$router->get('timeout', function() {

// META DETAILS
$meta = array(
    "title"=>app()->app->home_title,
    "meta_title"=>app()->app->home_title,
    "meta_desc"=>app()->app->meta_description,
    "meta_img"=>"",
    "meta_url"=>"",
    "meta_author"=>"",
);

views($meta,"Timeout");

});

$router->get('more-services', function() {
    
// META DETAILS
$meta = array(
"title"=>app()->app->home_title,
"meta_title"=>app()->app->home_title,
"meta_desc"=>app()->app->meta_description,
"meta_img"=>"",
"meta_url"=>"",
"meta_author"=>"",
);

views($meta,"More_services");

});

$router->get('ip', function() {
$ip ="110.36.223.2";
$geo_url = "http://api.ipstack.com/";
$geo = $geo_url.$ip."?access_key=e19ca7b0c95b61b4359e47031ccd2176";
dd(json_decode(file_get_contents($geo)));
});