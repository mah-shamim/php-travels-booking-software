<?php

use Curl\Curl;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$router->get(login.'(.*)', function() {

    // if user already logged in take him to dashboard
    if(isset($_SESSION["user_type"])) { header('Location: '.root.'account/dashboard'); die; }

    $title = "Login";
    $meta_title = "Login";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/accounts/login.php";
    include layout;
});

// verify user from api and return the results
$router->post('login', function() {

    $req = new Curl();
    $req->post(api_url.'api/login/check?appKey='.api_key, array(
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    ));
    header('Content-Type: application/json');
    $reqs = json_decode($req->response);
    if ($reqs->response == true ){
    $_SESSION['user_id']=$reqs->userInfo->id;
    $_SESSION['user_name']=$reqs->userInfo->firstName;
    $_SESSION['user_type']=$reqs->userInfo->type;
    $_SESSION['user_login']="true";
    header('Location: '.root.'account/dashboard');
    } else {
    header('Location: '.root.'login/failed');
    }
});

// signup page
$router->get(signup.'(.*)', function() {

    $title = "Signup";
    $meta_title = "Signup";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $body = views."modules/accounts/signup.php";
    include layout;
});

// signup user from api and return results
$router->post(signup, function() {

    $req = new Curl();
    $req->post(api_url.'api/login/signup?appKey='.api_key, array(
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'phone' => $_POST['phone'],
    'email' => $_POST['email'],
    'password' => $_POST['password'],
    'address' => $_POST['address'],
    'type' => $_POST['type'],
    ));
    header('Content-Type: application/json');
    $reqs = json_decode($req->response);
    if ($reqs->response == true ){
    header('Location: '.root.'login/signup');
    } else {
    header('Location: '.root.'signup/failed');
    }
});

// user password reset
$router->post('reset_password', function() {

    $req = new Curl();
    $req->post(api_url.'api/login/reset_password?appKey='.api_key, array(
    'email' => $_POST['email'],
    ));
    header('Content-Type: application/json');
    $reqs = json_decode($req->response);
    if ($reqs->response == true ){

    $mail = new PHPMailer(true);
    try {

    //Recipients
    $mail->setFrom($_SESSION['admin_email'], 'Reset Password');
    $mail->addAddress($_POST['email']); //Add a recipient
    $mail->addReplyTo($_SESSION['admin_email'], 'reply');

    //Content
    $mail->isHTML(true);  //Set email format to HTML
    $mail->Subject = 'Reset Password';
    $mail->Body    = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#f6f7f8!important"> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <meta name="viewport" content="width=device-width"> <style type="text/css"> [EmailCSS] </style> <!--[if gte mso 9]> <style type="text/css"> .container-radius{ padding-left: 48px; padding-right: 48px; padding-top 32px; } a{ text-decoration: none; text-underline-style: none; text-underline-color: none; } .padding-title{ padding-top: 10px; padding-bottom:10px; padding-left: 8px; padding-right: 8px; margin-top: 16px; margin-bottom: 0; } @media only screen and (max-width: 628px) { .small-float-center { margin: 0 auto !important; float: none !important; text-align: center !important } .container-radius{ border-spacing: 0 !important; padding-left: 16px!important; padding-right: 16px!important; padding-top: 16px!important; } } </style> <![endif]--> <!--[if mso]> <style> .padding-title{ padding-top: 10px; padding-bottom:10px; padding-left: 8px; padding-right: 8px; margin-bottom: 0; margin-top:16px; } .container-radius { padding-top: 32px; } @media only screen and (max-width: 628px) { .small-float-center { margin: 0 auto !important; float: none !important; text-align: center !important } .container-radius{ border-spacing: 0 !important; padding-left: 16px !important; padding-right: 16px !important; padding-top: 16px !important; } } </style> <![endif]--> </head> <body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;box-sizing:border-box;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"> <span class="preheader" style="color:#fff;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span> <table class="body" style="Margin:0;background-color:#f6f7f8;border-collapse:collapse;border-color:transparent;border-spacing:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%"> <!--[if gte mso 9]> <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#fff"/> </v:background> <![endif]--> <tr style="padding:0;text-align:left;vertical-align:top"> <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <center data-parsed="" style="min-width:580px;width:100%"> <table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="0" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table align="center" class="container header float-center" style="Margin:0 auto;background:0 0;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px;max-width:580px;"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table class="row collapse logo-wrapper" style="background:0 0;border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th class="small-12 large-6 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:200px;"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th valign="middle" height="49" style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"> <a target="_blanl" href="'.root.'"> <img width="200" class="header-logo" src="'.api_url.'/uploads/global/logo.png" alt="" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:220px;width:auto;height:auto;outline:0;text-decoration:none;max-height:49px"> </a> </th> </tr> </table> </th> <th class="small-12 large-6 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:right;width:320px;vertical-align:middle;"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:right;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:right"> <span class="header-top-text" style="color:#ACB0B8;display:table;font-size:12px;line-height:29px;text-align:right;width:100%;margin-left:auto;">Having problems viewing this email?<a class="faded-link" href="'.root.'contact" style="Margin:0;color:#7C8088!important;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none;margin-left:6px;line-height:8px;"> Contact Us</a></span> </th> </tr> </table> </th> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table cellspacing="0" cellpadding="0" border="0" align="center" class="container body-drip float-center" style="Margin:0 auto;border-bottom-left-radius:3px;border-bottom-right-radius:3px;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px;max-width:580px"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="container-radius" style="border-top-width:0;border-top-color:#e6e6e6;border-left-width:1px;border-right-width:1px;border-bottom-width:1px;border-bottom-color:#e6e6e6;border-right-color:#e6e6e6;border-left-color:#e6e6e6;border-style:solid; border-bottom-left-radius:3px;border-bottom-right-radius:3px;display:table;padding-bottom:32px;border-spacing:48px 0;border-collapse:separate;width:100%;background:#fff;max-width:580px;"> <tbody> <tr> <td> <table class="row" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"></tr> </tbody> </table> <table class="spacer mobile-hide" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table>
    <p>
    <strong>New Password</strong> : 365486<br />
    </p>
    </td> </tr> </tbody> </table> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="40px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table align="left" class="container aside-content" style="Margin:0 auto;background:#f6f7f8;border-collapse:collapse;border-color:transparent;border-spacing:0;margin:0 auto;padding:0;text-align:inherit;vertical-align:top;width:580px"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table class="row row-wide" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th class="small-12 large-8 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0!important;padding-bottom:16px;padding-left:0;padding-right:0;text-align:left;width:338.67px;vertical-align:middle;"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left"> <p style="Margin:0;Margin-bottom:10px;margin-top:10px!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"> <a class="footer-link-color" href="'.root.'" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><b style="text-underline-style: none;border-bottom:none;border-top:none;">'.root.'</b></a> </p> </th> </tr> </table> </th> <!--<th class="small-12 large-4 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0!important;text-align:left;width:120px"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left"> <table class="menu" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:auto;margin-left:auto;border-spacing:0"> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/fb.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/g.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/t.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/linkedin.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/youtube.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/instagram.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> </tr> </table> </td> </tr> </table> </th> </tr> </table> </th>--> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="40px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <hr align="center" class="float-center" style="background:#dddedf;border:none;color:#dddedf;height:1px;margin-bottom:0;margin-top:0"> <table align="center" class="container aside-content float-center" style="Margin:0 auto;background:#f6f7f8;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table class="row collapsed footer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <table class="row row-wide" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0!important;padding-bottom:16px;text-align:left;width:532px"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left"> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;background:#f6f7f8"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;border-spacing:0!important;"> <tbody> <tr> <th class="small-12 large-2 columns first" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/login" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">Login to your account</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/tooking-tips" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">How to Book</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="{'.root.'/terms-of-use" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">Terms of service</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/privacy-policy" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">Privacy policy</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns last" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/about-us" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">About Us</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> </tr> </tbody> </table> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;background:#f6f7f8"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <span class="footer-description" style="color:#ACB0B8;font-size:11px;line-height:18px;padding-bottom:30px;">All rights reserved.</span> </th> <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th> </tr> </table> </th> </tr> </tbody> </table> </tr> </tbody> </table> </td> </tr> </tbody> </table> </center> </td> </tr> </table><!-- prevent Gmail on iOS font size manipulation --> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;background:#f6f7f8"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="24px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> </body> </html>
    ';

    $mail->AltBody = '';
    $mail->send();
    header('Location: '.root.'login/reset/success'); }
    catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; }
    } else {
    header('Location: '.root.'login/reset/fail');
    }
});

// user dashboard page
if (isset($_SESSION['user_login']) == true){
$router->get('account/dashboard', function() {

    $title = "Dashboard";
    $meta_title = "dashboard";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $dashboard_active = "page-active";

    $body = views."modules/accounts/dashboard.php";
    include layout;
});};

// user dashboard page
if (isset($_SESSION['user_login']) == true){
$router->get('account/add_funds', function() {

    $title = "Add Funds";
    $meta_title = "Add funds";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $add_funds = "page-active";

    $body = views."modules/accounts/add_funds.php";
    include layout;
});};

// user dashboard page
if (isset($_SESSION['user_login']) == true){
$router->get('account/funds-success', function() {

    $title = "Funds Added";
    $meta_title = "Funds Added";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $add_funds = "page-active";

    $body = views."modules/accounts/funds_added.php";
    include layout;
});};

if (isset($_SESSION['user_login']) == true){
$router->get('account/bookings', function() { 

   $req = new Curl();
   $req->post(api_url.'api/login/booking?appKey='.api_key, array(
   'user_id' => $_SESSION['user_id'],
   ));
    $booking = json_decode($req->response);

    // dd($booking);
    // exit;
    if (empty($booking->error->status)) {
    $booking_data = $booking->response;
    }else{
        $booking_data = array((object)array('booking_empty'=>true));
    }
    $title = "Bookings";
    $meta_title = "Bookings";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $bookings_active = "page-active";

    $body = views."modules/accounts/bookings.php";
    include layout;
});};

if (isset($_SESSION['user_login']) == true){
    $router->get('account/profile(.*)', function() {
    $req = new Curl();
    $req->post(api_url.'api/login/get_profile?appKey='.api_key, array(
    'id' => $_SESSION['user_id'],
    ));

    $profile = json_decode($req->response);
    $profile_data = $profile->response;

    $title = "Profile";
    $meta_title = "Profile";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $profile_active = "page-active";

    $body = views."modules/accounts/profile.php";
    include layout;
});};

// profile information update
$router->post('account/profile_update', function() {
   $req = new Curl();
   $req->post(api_url.'api/login/post_profile?appKey='.api_key, array(
   $_POST,
   ));

    $res = json_decode($req->response);
    $update = $res->response;
    if ($update == 1) {
    header('Location: '.root.'account/profile/success');
    }else{

    $title = "Dashboard";
    $meta_title = "dashboard";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $profile_active = "page-active";

    $body = views."modules/accounts/profile.php";
    include layout;
    }
});

// pay with balance for wallet
$router->post('account/balance', function () {

    // final booking post request
    $req = new Curl();
    $req->post(api_url.'api/login/balance?appKey='.api_key, array(
    'user_id' => $_POST['user_id'],
    'balance' => $_POST['balance'],
    'currency' => $_POST['currency'],
    ));

    if ($req->response == true) {
        header('Location: '.$_POST['success_url']);
    } else { echo "Booking Error Please Try Again."; }

    // $booking = json_decode($req->response);

    // generate logs
    logs($SearchType = "Pay with wallet balance" );

});

// add balance to wallet
$router->get('account/add_balance', function () {

    // final booking post request
    $req = new Curl();
    $req->post(api_url.'api/login/balance?appKey='.api_key, array(
    'user_id' => $_GET['user_id'],
    'balance' => $_GET['balance'],
    'currency' => $_GET['currency'],
    ));

    if ($req->response == true) {
        header('Location: '.root.''.$_GET['success_url']);
    } else { echo "Can't add balance some technical error contact support."; }

    // $booking = json_decode($req->response);

    // generate logs
    logs($SearchType = "Wallet add balance".$_GET['balance']  );

});

// session destroy and user logout then redirect to login page
$router->get('account/logout', function() {
session_destroy();
header('Location: '.root.'login');
});