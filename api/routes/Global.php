<?php

use Medoo\Medoo;

// ======================== COUNTRIES
$router->post('countries', function() {

    // INCLUDE CONFIG
    include "./config.php";
    AUTH_CHECK();

    $params = array( "country_status" => 1, );
    $respose = $db->select("countries", "*", $params);

echo json_encode($respose);

});

// ======================== RESET DB
$router->get('reset', function() {

    // INCLUDE CONFIG
    include "./config.php";
  
    $db->query("TRUNCATE TABLE `hotels_bookings`");
    $db->query("TRUNCATE TABLE `flights_bookings`");
    $db->query("TRUNCATE TABLE `tours_bookings`");
    $db->query("TRUNCATE TABLE `cars_bookings`");
    $db->query("TRUNCATE TABLE `visa_bookings`");
    $db->query("TRUNCATE TABLE `logs`");
    $db->query("TRUNCATE TABLE `transactions`");
    $db->query("TRUNCATE TABLE `notifications`");
    $db->query("TRUNCATE TABLE `newsletter`");

    $db->query("UPDATE `countries` SET `traffic` = '0'");
    $db->query("UPDATE `users` SET `balance` = '0'");

    $dir = '../App/Logs/';
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) { if ($file != "." && $file != "..") { unlink($dir . $file); } }
        closedir($handle);
    }
    sleep(1);
    $dir = '../cache/';
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) { if ($file != "." && $file != "..") { unlink($dir . $file); } }
        closedir($handle);
    }

    echo "DONE BRO";
 
});

?>