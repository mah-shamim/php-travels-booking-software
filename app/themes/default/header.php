<?php

/* get app data from session */
$app = $_SESSION['app'];
foreach ($app->currencies as $curreny){ if($curreny->default == true && $curreny->status == true){ $default_currency = $curreny->name; } }
$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST']; $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

/* modules status condition */
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'flights' ) { $flights = 1; $flights_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'hotels' ) { $hotels = 1; $hotels_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'tours' ) { $tours = 1; $tours_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'cars' ) { $cars = 1; $cars_order = $model->order; } }
foreach ($app->modules as $model){if($model->status == true && $model->name  == 'visa' ) { $visa = 1; $visa_order = $model->order; } }
foreach ($app->extras  as $model){if($model->status == true && $model->title == 'newsletter' ) { $newsletter = 1; } }
foreach ($app->extras  as $model){if($model->status == true && $model->title == 'blog' ) { $blog = 1; } }
foreach ($app->extras  as $model){if($model->status == true && $model->title == 'offers' ) { $offers = 1; } }

// currency from session
$currency = $_SESSION['session_currency'];
$session_currency = $_SESSION['session_currency'];
$session_lang = $_SESSION['session_lang'];
$_SESSION['admin_email'] = $app->app->email;
require_once theme_url."partcials.php";
?>

<!DOCTYPE html>
<?php
// RTL checkup for languages
$dir='app/lang';
$indir = array_filter(scandir($dir,1), function($item)
{return !is_dir('app/lang/'.$item);}); $fils_data = array();
foreach ($indir as $key=>$value){ $string = file_get_contents("app/lang/".$value);
array_push ($fils_data,json_decode($string));}
foreach ($fils_data as $key){ if ($key->lang_code == $_SESSION['session_lang']){
if ($key->language_type == "RTL"){
$RTL = 1; ?>
<html lang="en" dir="rtl">
<?php } }
else { echo '<html lang="en">'; } } ?>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta http-equiv="refresh" content="6000; <?=$root?>timeout" />

<?php if ($meta == 1) {?>
<!-- for meta search engines and SEO content -->
<meta property="og:title" content="<?=$meta_title;?>"/>
<meta property="og:site_name" content="<?=$app->app->appname;?>"/>
<meta property="og:description" content="<?=$meta_desc;?>"/>
<meta property="og:image" content="<?=$meta_img;?>"/>
<meta property="og:url" content="<?=$meta_url;?>"/>
<meta property="og:publisher" content="<?=$meta_author;?>"/>
<?php } ?>

<title><?=$title;?> - <?=$app->app->appname?></title>
<base href="<?=root;?>">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/line-awesome.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/owl.theme.default.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/jquery.fancybox.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/animate.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/animated-headline.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/flag-icon.min.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/style.css">
<link rel="stylesheet" href="<?=root.theme_url?>style.css">
<link rel="stylesheet" href="<?=root.theme_url?>assets/css/mobile.css">

<script> var baseurl = "<?=root?>"; </script>
<link rel="shortcut icon" href="<?=api_url;?>uploads/global/favicon.png">
<script src="<?=root.theme_url?>assets/js/jquery/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

<?php if (isset($RTL)) { ?>
<link rel='stylesheet' href='<?=root;?><?=theme_url?>assets/css/style-rtl.css'/>
<link href="https://fonts.googleapis.com/css?family=Tajawal:300,400,500,700,800&amp;subset=arabic" rel="stylesheet">
<?php } ?>

<script>var root = '<?=root?>'</script>
</head>
<body>

<!-- loading effect -->
<!--<div class="preloader centerrotate" id="preloader">
 <div class="rotatingDiv"></div>
</div>-->

<!-- ================================
         START HEADER AREA
================================= -->
<header class="header-area">
    <div class="header-top-bar padding-right-100px padding-left-100px">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="header-top-content">
                        <div class="header-left">
                            <ul class="list-items">
                                <li><a href="tel:<?=$app->app->phone?>"> <i class="la la-phone mr-1"></i> <?=$app->app->phone?></a></li>
                                <li><a href="mailto:<?=$app->app->email?>"><i class="la la-envelope mr-1"></i><?=$app->app->email?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php  /* get Language files data */ $indir = array_filter(scandir('app/lang',1), function($item) {return !is_dir('app/lang/'.$item);}); $files_data = array(); foreach ($indir as $key=>$value){ $string = file_get_contents("app/lang/".$value); array_push ($files_data,json_decode($string)); } ?>

                <div class="col-lg-6">
                    <div class="header-top-content">
                        <div class="header-right d-flex align-items-center justify-content-end">

                            <?php if ($app->app->multi_language == true) { ?>
                            <div class="header-right-action pt-1 pe-2">
                            <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="languages" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="flag-icon flag-icon-<?php foreach ($files_data as $lang){ if($lang->lang_code == $session_lang){ echo $lang->country_code; } }?> mr-1"></span>
                            <?php foreach ($files_data as $lang){ if($lang->lang_code == $session_lang){ echo $lang->language_name; } }?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="languages">
                            <?php foreach($files_data as $item){ $lan = $item->lang_code; { ?>
                            <li><a class="dropdown-item" href="<?=root?>lang-<?=$item->lang_code?>"><span class="flag-icon flag-icon-<?=$item->country_code?> mr-1"></span> <?=$item->language_name?></a></li>
                            <?php } } ?>
                            </ul>
                            </div>
                            </div>
                            <?php } ?>

                            <?php if ($app->app->multi_currency == true) { ?>
                            <div class="header-right-action  pt-1 pe-2">
                            <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="currency" data-bs-toggle="dropdown" aria-expanded="false">
                            <?=$session_currency?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="currency">
                            <?php foreach ($app->currencies as $currencies){ if($currencies->status == true){ ?>
                            <li><a class="dropdown-item" href="<?=root?>currency-<?=$currencies->name?>"> <?=$currencies->name?></a></li>
                            <?php } } ?>
                            </ul>
                            </div>
                            </div>
                            <?php } ?>

                            <?php if (!isset($_SESSION['user_login']) == true) { ?>

                            <!-- suppliers registration and login -->
                            <?php if ($app->app->suppliers_registration == true) { ?>
                            <div class="header-right-action pt-1 pe-2">
                            <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="supplier" data-bs-toggle="dropdown" aria-expanded="false">
                            <?=T::supplier?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="supplier">
                            <li><a class="dropdown-item" href="<?=root?>signup-supplier"><?=T::signup?></a></li>
                            <li><a class="dropdown-item" href="<?=api_url?>supplier" target="_blank"><?=T::login?></a></li>
                            </ul>
                            </div>
                            </div>
                            <?php } ?>

                            <!-- agents registration and login -->
                            <?php if ($app->app->allow_agent_registration == true) { ?>
                            <div class="header-right-action pt-1 pe-2">
                            <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="agents" data-bs-toggle="dropdown" aria-expanded="false">
                            <?=T::agents?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="agents">
                            <li><a class="dropdown-item" href="<?=root?>signup-agent"><?=T::signup?></a></li>
                            <li><a class="dropdown-item" href="<?=root?>login" target="_blank"><?=T::login?></a></li>
                            </ul>
                            </div>
                            </div>
                            <?php } } ?>

                            <!-- customers registration and login -->
                            <?php if (isset($_SESSION['user_login']) == true) { ?>
                            <div class="header-right-action pt-1 pe-2">
                            <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="currency" data-bs-toggle="dropdown" aria-expanded="false">
                            <?=T::account?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="currency">
                            <li><a class="dropdown-item" href="<?=root?>account/dashboard"> <?=T::dashboard?></a></li>
                            <li><a class="dropdown-item" href="<?=root?>account/logout"> <?=T::logout?></a></li>
                            </ul>
                            </div>
                            </div>
                            <?php } else { ?>
                            <?php if ($app->app->allow_registration == true) { ?>
                            <a href="<?=root?>signup" class="theme-btn theme-btn-small"><?=T::signup?></a>
                            <?php } ?>
                            <a href="<?=root?>login" class="theme-btn theme-btn-small theme-btn-transparent ml-1"><?=T::login?></a>
                            <?php } ?>
                        </div>
                        <!-- end nav-btn -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-menu-wrapper padding-right-100px padding-left-100px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-wrapper">
                        <a href="javascript:void(0)" class="down-button"><i class="la la-angle-down"></i></a>
                        <div class="logo">
                            <a href="<?=root;?>" style="border-radius:5px">
                            <img style="max-height:40px;border-radius:5px;background:transparent;padding:4px;" src="<?=api_url;?>uploads/global/logo.png" alt="logo">
                            </a>
                            <div class="menu-toggler">
                                <i class="la la-bars"></i>
                                <i class="la la-times"></i>
                            </div>
                        </div>
                        <div class="main-menu-content">
                            <nav>
                                <ul>
                                    <li><a href="<?=root;?>" title="home"><?=T::home?></a></li>
                                    <?php foreach ($app->modules as $model){ ?>

                                    <?php  if ($model->status == true && $model->name == 'hotels') { ?>
                                    <li><a href="<?=root;?><?=$model->name?>" title="home"><?=T::hotels_hotels?></a></li>
                                    <?php } ?>

                                    <?php if ($model->status == true && $model->name == 'flights') { ?>
                                    <li><a href="<?=root;?><?=$model->name?>" title="home"><?=T::flights_flights?></a></li>
                                    <?php } ?>

                                    <?php if ($model->status == true && $model->name == 'tours') { ?>
                                    <li><a href="<?=root;?><?=$model->name?>" title="home"><?=T::tours_tours?></a></li>
                                    <?php } ?>

                                    <?php if ($model->status == true && $model->name == 'cars') { ?>
                                    <li><a href="<?=root;?><?=$model->name?>" title="home"><?=T::cars_cars?></a></li>
                                    <?php } ?>

                                    <?php if ($model->status == true && $model->name == 'visa') { ?>
                                    <li><a href="<?=root;?><?=$model->name?>" title="home"><?=T::visa_visa?></a></li>
                                    <?php } } ?>

                                    <?php  if (isset($blog)) { if ($blog == 1) {?>
                                    <li><a href="<?=root;?>blog" title="blog"><?=T::blog?></a></li>
                                    <?php } } ?>

                                    <?php  if (isset($offers)) { if ($offers == 1) {?>
                                    <li><a href="<?=root;?>offers" title="offers"><?=T::offers?></a></li>
                                    <?php } } ?>

                                    <!-- header manue -->
                                    <?php foreach ($app->cms->header as $key => $value) {
                                    foreach ($value as $k => $v) { ?>
                                    <li class="footm">
                                    <?php if ($k == $v[0]->title && count($v) < 2){ ?>
                                    <a href="<?=$v[0]->href?>"><?= $k ?></a>
                                    <?php  }elseif($k == $v[0]->title && count($v) > 1){?>
                                    <a href="<?=$v[0]->href?>"><?= $k ?> <i class="la la-angle-down"></i></a>
                                    <?php }?>
                                    <?php if (count($v) > 1) {?>
                                    <ul class="dropdown-menu-item">
                                    <?php foreach ($v as $mk => $mv) { if ($mv->title != $k) {?>
                                    <li><a href="<?=$root;?><?= $mv->href ?>"><?= $mv->title ?></a></li><?php }} ?>
                                    </ul> <?php } ?>
                                    </li> <?php } } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ================================
         END HEADER AREA
================================= -->