<?php
use Curl\Curl;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*header manu*/
foreach ($app->cms->header as $key => $value) {
foreach ($value as $k => $v) {
foreach ($v as $mk => $mv) {
$c = str_replace(' ', '-', strtolower($mv->href));
$router->get($c, function() use ( $c )  {
$url = explode('/', $_GET['url']);
$title = str_replace('-', '%20', $url[0]);
$title_cap = ucwords($title);
$req = new Curl();
$req->get(api_url.'api/cms/cms_details?appKey='.api_key.'&title='.$title_cap,'&lang='.$_SESSION['session_lang']);
$reqs = json_decode($req->response);
if (!empty($reqs->response->content_body)) {
$content = $reqs->response->content_body;
$page_title = $reqs->response->content_page_title;
}else{
$content = 'Data Not Found!';
$page_title = $url[0];
}
$title = $page_title;
$meta_title = $page_title;
$meta_appname = $page_title;
$meta_desc = "";
$meta_img = "";
$meta_url = "";
$meta_author = "";
$meta = "1";

// $body = views."modules/cms/".$c.".php";
$body = views."modules/cms/cms.php";
include layout;

});
}}}

/*footer manu*/
foreach ($app->cms->footer as $key => $value) {
foreach ($value as $k => $v) {
foreach ($v as $mk => $mv) {
$c = str_replace(' ', '-', strtolower($mv->href));
$router->get($c, function() use ( $c )  {
$url = explode('/', $_GET['url']);
$title = str_replace('-', '%20', $url[0]);
$title_cap = ucwords($title);
$req = new Curl();
$req->get(api_url.'api/cms/cms_details?appKey='.api_key.'&title='.$title_cap,'&lang='.$_SESSION['session_lang']);
$reqs = json_decode($req->response);
if (!empty($reqs->response->content_body)) {
$content = $reqs->response->content_body;
$page_title = $reqs->response->content_page_title;
}else{
$content = 'Data Not Found!';
$page_title = $url[0];
}
$title = $page_title;
$meta_title = $page_title;
$meta_appname = $page_title;
$meta_desc = "";
$meta_img = "";
$meta_url = "";
$meta_author = "";
$meta = "1";


// $body = views."modules/cms/".$c.".php";
$body = views."modules/cms/cms.php";
include layout;

});
}}}


$router->get('contact(.*)', function() {

$title = "Contact";
$meta_title = "Contact";
$meta_appname = "";
$meta_desc = "";
$meta_img = "";
$meta_url = "";
$meta_author = "";
$meta = "1";

$body = views."modules/cms/contact.php";
include layout;
});

$router->post('contact', function() {

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    // $mail->isSMTP();                                            //Send using SMTP
    // $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->Username   = 'user@example.com';                     //SMTP username
    // $mail->Password   = 'secret';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    // $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($_SESSION['admin_email'], 'Contact Form');
    $mail->addAddress($_POST['email'], $_POST['name']);     //Add a recipient
    $mail->addReplyTo($_SESSION['admin_email'], 'reply');
    // $mail->addAddress('');               //Name is optional
    //  $mail->addCC('');
    //  $mail->addBCC('');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Contact From '.$_POST['name'];
    $mail->Body    = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#f6f7f8!important"> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <meta name="viewport" content="width=device-width"> <style type="text/css"> [EmailCSS] </style> <!--[if gte mso 9]> <style type="text/css"> .container-radius{ padding-left: 48px; padding-right: 48px; padding-top 32px; } a{ text-decoration: none; text-underline-style: none; text-underline-color: none; } .padding-title{ padding-top: 10px; padding-bottom:10px; padding-left: 8px; padding-right: 8px; margin-top: 16px; margin-bottom: 0; } @media only screen and (max-width: 628px) { .small-float-center { margin: 0 auto !important; float: none !important; text-align: center !important } .container-radius{ border-spacing: 0 !important; padding-left: 16px!important; padding-right: 16px!important; padding-top: 16px!important; } } </style> <![endif]--> <!--[if mso]> <style> .padding-title{ padding-top: 10px; padding-bottom:10px; padding-left: 8px; padding-right: 8px; margin-bottom: 0; margin-top:16px; } .container-radius { padding-top: 32px; } @media only screen and (max-width: 628px) { .small-float-center { margin: 0 auto !important; float: none !important; text-align: center !important } .container-radius{ border-spacing: 0 !important; padding-left: 16px !important; padding-right: 16px !important; padding-top: 16px !important; } } </style> <![endif]--> </head> <body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;box-sizing:border-box;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;min-width:100%;padding:0;text-align:left;width:100%!important"> <span class="preheader" style="color:#fff;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span> <table class="body" style="Margin:0;background-color:#f6f7f8;border-collapse:collapse;border-color:transparent;border-spacing:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;width:100%"> <!--[if gte mso 9]> <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#fff"/> </v:background> <![endif]--> <tr style="padding:0;text-align:left;vertical-align:top"> <td class="center" align="center" valign="top" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <center data-parsed="" style="min-width:580px;width:100%"> <table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="0" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table align="center" class="container header float-center" style="Margin:0 auto;background:0 0;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px;max-width:580px;"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table class="row collapse logo-wrapper" style="background:0 0;border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th class="small-12 large-6 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:left;width:200px;"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th valign="middle" height="49" style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"> <a target="_blanl" href="'.root.'"> <img width="200" class="header-logo" src="'.api_url.'/uploads/global/logo.png" alt="" style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:220px;width:auto;height:auto;outline:0;text-decoration:none;max-height:49px"> </a> </th> </tr> </table> </th> <th class="small-12 large-6 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0;padding-left:0;padding-right:0;text-align:right;width:320px;vertical-align:middle;"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:right;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:right"> <span class="header-top-text" style="color:#ACB0B8;display:table;font-size:12px;line-height:29px;text-align:right;width:100%;margin-left:auto;">Having problems viewing this email?<a class="faded-link" href="'.root.'contact" style="Margin:0;color:#7C8088!important;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none;margin-left:6px;line-height:8px;"> Contact Us</a></span> </th> </tr> </table> </th> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table cellspacing="0" cellpadding="0" border="0" align="center" class="container body-drip float-center" style="Margin:0 auto;border-bottom-left-radius:3px;border-bottom-right-radius:3px;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px;max-width:580px"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"><table class="container-radius" style="border-top-width:0;border-top-color:#e6e6e6;border-left-width:1px;border-right-width:1px;border-bottom-width:1px;border-bottom-color:#e6e6e6;border-right-color:#e6e6e6;border-left-color:#e6e6e6;border-style:solid; border-bottom-left-radius:3px;border-bottom-right-radius:3px;display:table;padding-bottom:32px;border-spacing:48px 0;border-collapse:separate;width:100%;background:#fff;max-width:580px;"> <tbody> <tr> <td> <table class="row" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"></tr> </tbody> </table> <table class="spacer mobile-hide" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="32px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:32px;font-weight:400;hyphens:auto;line-height:32px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table>
    <p>
    <strong>Name</strong> : '.$_POST['name'].'<br />
    <strong>Email</strong> : '.$_POST['email'].'<br />
    <strong>Message</strong> : '.$_POST['message'].'<br />
    </p>
    </td> </tr> </tbody> </table> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="40px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table align="left" class="container aside-content" style="Margin:0 auto;background:#f6f7f8;border-collapse:collapse;border-color:transparent;border-spacing:0;margin:0 auto;padding:0;text-align:inherit;vertical-align:top;width:580px"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table class="row row-wide" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th class="small-12 large-8 columns first" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0!important;padding-bottom:16px;padding-left:0;padding-right:0;text-align:left;width:338.67px;vertical-align:middle;"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left"> <p style="Margin:0;Margin-bottom:10px;margin-top:10px!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"> <a class="footer-link-color" href="'.root.'" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><b style="text-underline-style: none;border-bottom:none;border-top:none;">'.root.'</b></a> </p> </th> </tr> </table> </th> <!--<th class="small-12 large-4 columns last" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0!important;text-align:left;width:120px"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left"> <table class="menu" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:auto;margin-left:auto;border-spacing:0"> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/fb.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/g.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/t.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/linkedin.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/youtube.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="menu-item float-center" style="Margin:0 auto;color:#0a0a0a;float:none;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:4px 0!important;text-align:center"> <a href="#" style="Margin:0;color:#0057FF;font-family:Roboto,sans-serif;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;text-decoration:none"><span class="rounded-button" style="align-items:center;display:flex;float:right;height:42px;justify-content:center;width:42px;"><img src="img/instagram.png" alt="" style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto"> </span></a> </th> </tr> </table> </td> </tr> </table> </th> </tr> </table> </th>--> </tr> </tbody> </table> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table class="spacer float-center" style="Margin:0 auto;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="40px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <hr align="center" class="float-center" style="background:#dddedf;border:none;color:#dddedf;height:1px;margin-bottom:0;margin-top:0"> <table align="center" class="container aside-content float-center" style="Margin:0 auto;background:#f6f7f8;border-collapse:collapse;border-color:transparent;border-spacing:0;float:none;margin:0 auto;padding:0;text-align:center;vertical-align:top;width:580px"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> <table class="row collapsed footer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <table class="row row-wide" style="border-collapse:collapse;border-color:transparent;border-spacing:0;display:table;padding:0;position:relative;text-align:left;vertical-align:top;width:100%"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <th class="small-12 large-12 columns first last" style="Margin:0 auto;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0 auto;padding:0!important;padding-bottom:16px;text-align:left;width:532px"> <table style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%"> <tr style="padding:0;text-align:left;vertical-align:top"> <th style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left"> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;background:#f6f7f8"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <table style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;border-spacing:0!important;"> <tbody> <tr> <th class="small-12 large-2 columns first" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/login" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">Login to your account</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/tooking-tips" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">How to Book</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="{'.root.'/terms-of-use" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">Terms of service</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/privacy-policy" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">Privacy policy</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> <th class="small-12 large-2 columns last" tabindex="0" role="button" style="text-decoration:none;padding-left:0!important;text-align:left !important;" align="left"> <a class="footer-link" role="link" target="_blank" rel="noopener" href="'.root.'/about-us" style="Margin:0;color:#0C70DE;font-family:Roboto,sans-serif;cursor:pointer;font-size:12px;font-weight:400;line-height:29px;display:inline-block;margin:0;padding:0;text-align:left;text-decoration:none;line-height:18px"><font color="#0C70DE">About Us</font></a> </th> <th style="Margin:0 auto;color:#0a0a0a;width:16px;display:inline-block;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;" width="16px"></th> </tr> </tbody> </table> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;background:#f6f7f8"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="16px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> <span class="footer-description" style="color:#ACB0B8;font-size:11px;line-height:18px;padding-bottom:30px;">All rights reserved.</span> </th> <th class="expander" style="Margin:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;visibility:hidden;width:0"></th> </tr> </table> </th> </tr> </tbody> </table> </tr> </tbody> </table> </td> </tr> </tbody> </table> </center> </td> </tr> </table><!-- prevent Gmail on iOS font size manipulation --> <table class="spacer" style="border-collapse:collapse;border-color:transparent;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%;background:#f6f7f8"> <tbody> <tr style="padding:0;text-align:left;vertical-align:top"> <td height="24px" style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding:0;text-align:left;vertical-align:top;word-wrap:break-word"> </td> </tr> </tbody> </table> </body> </html>
    ';

    $mail->AltBody = '';
    $mail->send();
    header('Location: '.root.'contact/success'); }
    catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
});