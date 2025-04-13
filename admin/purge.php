<?php 

require_once '_config.php';
auth_check();

$db->query("TRUNCATE TABLE visa_bookings");
$db->query("TRUNCATE TABLE cars_bookings");
$db->query("TRUNCATE TABLE tours_bookings");
$db->query("TRUNCATE TABLE hotels_bookings");
$db->query("TRUNCATE TABLE flights_bookings");
$db->query("TRUNCATE TABLE logs");
$db->query("TRUNCATE TABLE notifications");
$db->query("TRUNCATE TABLE transactions");
$db->query("TRUNCATE TABLE flights_routes");
$db->query("TRUNCATE TABLE flights");
$db->query("UPDATE countries SET `traffic`= 0");

?>