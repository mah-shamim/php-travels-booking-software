<?php 

require_once '_config.php';

// INSERT TO LOGS
if (isset($USER_SESSION->backend_user_id)){
$user_id = $USER_SESSION->backend_user_id;    
$log_type = "logout";
$datetime = date("Y-m-d h:i:sa");
$desc = "user logout from account";
logs($user_id,$log_type,$datetime,$desc);
}

session_unset(); 
session_destroy();

?>

<?php ALERT_MSG('logout') ?>
<?php REDIRECT("login.php") ?>