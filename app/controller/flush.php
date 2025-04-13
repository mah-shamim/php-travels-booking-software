<?php

$router->get('flush', function () {
$mysqli = new mysqli("localhost","root","","v8");

// Check connection
if ($mysqli -> connect_errno) {
echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
exit();
}  else { echo "Flush DB and Log Files"; }

// accountd table create and insert db
if ($result = $mysqli -> query(" TRUNCATE TABLE `pt_accounts`"));
if ($result = $mysqli -> query(" CREATE TABLE `pt_accounts` ( `accounts_id` int(11) NOT NULL, `ai_title` varchar(5) DEFAULT NULL, `accounts_type` enum('webadmin','admin','supplier','agent','customers','guest') NOT NULL, `currency` varchar(255) DEFAULT NULL, `balance` varchar(255) DEFAULT NULL, `ai_first_name` varchar(50) DEFAULT NULL, `ai_last_name` varchar(50) DEFAULT NULL, `accounts_is_admin` tinyint(4) NOT NULL DEFAULT 0, `accounts_email` varchar(255) NOT NULL, `accounts_password` varchar(50) NOT NULL, `ai_dob` varchar(50) DEFAULT NULL, `ai_country` varchar(5) DEFAULT NULL, `ai_state` varchar(250) DEFAULT NULL, `ai_city` varchar(250) DEFAULT NULL, `ai_address_1` text DEFAULT NULL, `ai_address_2` text DEFAULT NULL, `ai_mobile` varchar(20) DEFAULT NULL, `ai_fax` int(20) DEFAULT NULL, `ai_postal_code` varchar(50) DEFAULT NULL, `ai_passport` varchar(50) DEFAULT NULL, `ai_website` varchar(100) DEFAULT NULL, `ai_image` varchar(35) DEFAULT NULL, `accounts_created_at` datetime DEFAULT NULL, `accounts_updated_at` datetime DEFAULT NULL, `accounts_status` enum('yes','no') NOT NULL DEFAULT 'yes', `accounts_verified` tinyint(4) DEFAULT 1, `accounts_last_login` bigint(20) DEFAULT NULL, `accounts_permissions` text DEFAULT NULL, `appliedfor` text DEFAULT NULL, `facebook_id` varchar(200) DEFAULT NULL, `commission` varchar(250) DEFAULT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8; "));
if ($result = $mysqli -> query(" INSERT INTO `pt_accounts` (`accounts_id`, `ai_title`, `accounts_type`, `currency`, `balance`, `ai_first_name`, `ai_last_name`, `accounts_is_admin`, `accounts_email`, `accounts_password`, `ai_dob`, `ai_country`, `ai_state`, `ai_city`, `ai_address_1`, `ai_address_2`, `ai_mobile`, `ai_fax`, `ai_postal_code`, `ai_passport`, `ai_website`, `ai_image`, `accounts_created_at`, `accounts_updated_at`, `accounts_status`, `accounts_verified`, `accounts_last_login`, `accounts_permissions`, `appliedfor`, `facebook_id`, `commission`) VALUES (1, 'Mr', 'webadmin', 'USD', NULL, 'Super', 'Admin', 1, 'admin@phptravels.com', '6f4504dd6d8322708f1aa68a05c7ca9cfc2ee782', '0', 'US', NULL, NULL, 'address 1', 'address 2', '123456789', 0, '0', '0', '0', '', '1901-02-16 11:41:04', '2020-10-22 03:25:00', 'yes', 1, 1603885878, '0', '', NULL, NULL), (2, 'Mr', 'customers', 'USD', '224', 'Demo', 'User', 0, 'user@phptravels.com', '39babc332b412604066644a894d9f47b8fe2ad42', NULL, 'AU', '', '', 'R2, Avenue du Maroc', '', '123456', 0, '52000', NULL, NULL, NULL, '2014-04-16 12:51:46', '2016-01-13 07:03:35', 'yes', 1, NULL, NULL, NULL, NULL, NULL), (3, 'Mr', 'supplier', 'USD', NULL, 'Demo', 'Supplier', 0, 'supplier@phptravels.com', '27e45ec6a8d54cfe37f83b4d4c8b0d2680412f2e', NULL, 'US', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', '2020-01-05 22:17:30', '2020-01-27 22:43:02', 'yes', 1, 1618531824, 'addHotels,addTours,addCars,addbooking,addlocations,editHotels,editTours,editCars,editbooking,editlocations', '{\"appliedfor\":\"Hotels\",\"name\":\"\"}', NULL, '25'), (4, 'Mr', 'agent', 'USD', '10', 'Demo', 'Agent', 0, 'agent@phptravels.com', '5435661055ef838045ba0040b73722ce188f8177', NULL, 'AE', '', '', '', '', '', 0, '', NULL, NULL, '', '2021-04-16 02:31:15', '2021-05-02 04:56:44', 'yes', 1, NULL, NULL, '', NULL, ''); "));
if ($result = $mysqli -> query(" ALTER TABLE `pt_accounts` ADD PRIMARY KEY (`accounts_id`); "));
if ($result = $mysqli -> query(" ALTER TABLE `pt_accounts` MODIFY `accounts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5; COMMIT; "));
if ($result = $mysqli -> query("TRUNCATE TABLE `hotels_bookings`"));
if ($result = $mysqli -> query("TRUNCATE TABLE `hotels_rooms_bookings`"));
if ($result = $mysqli -> query("TRUNCATE TABLE `hotels_search_logs`"));
if ($result = $mysqli -> query("TRUNCATE TABLE `booking_visa`"));
if ($result = $mysqli -> query("TRUNCATE TABLE `flights_search_logs`"));
if ($result = $mysqli -> query("TRUNCATE TABLE `flights_bookings`"));
if ($result = $mysqli -> query("TRUNCATE TABLE `flights_bookings_routes`"));

{ $result; }

$mysqli -> close();

// remove and clear files
$logs = 'app/logs/'; foreach(glob($logs.'*.*') as $l){ unlink($l); }
$cache = 'app/cache/'; foreach(glob($cache.'*.*') as $c){ unlink($c); }

});