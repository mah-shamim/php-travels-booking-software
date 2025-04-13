<?php

// ======================= GOOGLE LOGIN CREATIONALS
const google_login = true;
$google_client_id = '48292472266-agb9cjbo6v6ala0cdrc4c1r936env6iu';

// ======================= Facebbok LOGIN CREATIONALS
const facebook_login = true;
$facebook_client_id = '1065505746900715';

// ======================= TWITTER LOGIN CREATIONALS
const twitter_login = false;
$twitter_consumer_key = 'MjVcT3r1vwAsSCN2hZqTCIpOc';
$twitter_consumer_secret = 'oG2vT3QmuWo6G9p5UlGQovtVZC45FI95dAxuTvZgz6IaTKvNoV';

// ======================= Instagram LOGIN CREATIONALS
const instagram_login = false;
$instagram_consumer_key = '1051319635876673';
$instagram_consumer_secret = '42cd4496926288cc9084e84ea06ef92a';

// SIGNUP NEW API KEY AT : https://www.ip2location.io
// ======================= IP2LOCATION.IO API CRDENTIALs
$geo_ip_cred = "BD365E594553B668F99B361F3CD95613";

// REQUEST TYPE 
$uri = explode('/', $_SERVER['REQUEST_URI']);
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/' . $uri[1];
    define("google_client_id", '48292472266-agb9cjbo6v6ala0cdrc4c1r936env6iu');
    define("facebook_client_id", '1065505746900715');
    define("twitter_consumer_key", 'yIJWHEnLiqSiTSM9Nw4vX8c7y');
    define("twitter_consumer_secret", 'Mn2Q5GsApaiOwLfYPsPX95OJuIuU85cyCcOrTxZsMhaAhYc9Fz');
    define("twitter_redirect_url", $root."/Social_Login");
    define("instagram_consumer_key", '1051319635876673');
    define("instagram_consumer_secret", '42cd4496926288cc9084e84ea06ef92a');
    // for check on localhost this comment line work
    // define("instagram_redirect_url", 'https://localhost/v9/Social_Login');
     define("instagram_redirect_url",  $root."/Social_Login");// run for server side this line work

} else {

    $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    define("google_client_id", $google_client_id);
    define("facebook_client_id", $facebook_client_id);
    define("twitter_consumer_key", $twitter_consumer_key);
    define("twitter_consumer_secret", $twitter_consumer_secret);
    define("twitter_redirect_url", $root."Social_Login");
    define("instagram_consumer_key", $instagram_consumer_key);
    define("instagram_consumer_secret", $instagram_consumer_secret);
    define("instagram_redirect_url", $root."Social_Login");


}