<?php 

require_once '_config.php';
// auth_check();

$title = "Forget Password";
$template = "forget_password";
$content = "";
$sender_name = "PHPTRAVELS";
$sender_email = "";
$receiver_email = "";
$receiver_name = "";

MAILER($template,$title,$content,$receiver_email,$receiver_name,$sender_name,$sender_email);

?>