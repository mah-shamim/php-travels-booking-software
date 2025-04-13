<?php

use Curl\Curl;

// tours search page
$router->get(cars, function() {

    $title = "Search Cars";
    $meta_title = "Search Cars";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/cars/cars.php";
    include layout;

});

// hotels listing page
$router->get($session_langcur.cars.'(.*)', function() {
    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 9) { echo ""; }

    $language = $url[0];
    $currency = $url[1];
    $from_location = $url[3];
    $to_location = $url[4];
    $fromdate = $url[5];
    $todate = $url[6];
    $car_type = $url[7];
    $adults = $url[8];
    $childs = $url[9];

    // seo and meta tags
    $title = "Cars in ";
    $meta_title = "Cars in ";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // adding search credentials to session
    $_SESSION['carfrom_location']=$from_location;
    $_SESSION['carto_location']=$to_location;
    $_SESSION['carfromdate']=$fromdate;
    $_SESSION['cartodate']=$todate;
    $_SESSION['car_type']=$car_type;
    $_SESSION['cars_adults']=$adults;
    $_SESSION['cars_childs']=$childs;

    $body = views."modules/cars/listing.php";
    include layout;
});