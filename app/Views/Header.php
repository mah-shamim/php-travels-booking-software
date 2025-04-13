<!DOCTYPE HTML>

<?php
// CHECK AND ADD LANGUAGE CODE TO DIR
if (isset($_SESSION['phptravels_client_language_dir'])){ $lang_dir = $_SESSION['phptravels_client_language_dir'];
} else { foreach (app()->languages as $lang){ if($lang->default == 1){ $lang_dir = strtolower($lang->type); $_SESSION['defual_lang'] = $lang->name; } } }

require_once  "credentials.php";

// CHECK AVAILABLE MODULE TYPE
$modules = app()->modules;
$temp_module = array_unique(array_column($modules, 'type'));
$module_status = array_intersect_key($modules, $temp_module);

?>

<html lang="en" dir="<?=$lang_dir?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title><?php if (isset($meta['title'])){echo $meta['title'];}?></title>
    <link rel="stylesheet" type="text/css" href="<?=root?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=root?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?=root?>assets/css/theme.css">

    <?php if (isset($_SESSION['theme'])){?>
    <link rel="stylesheet" type="text/css" href="<?=root?>assets/css/themes/<?=$_SESSION['theme']?>.css">
    <?php } ?>

    <!-- THEME -->
    <link rel="stylesheet" type="text/css" href="<?=root?>assets/css/themes/<?=(base()->app->theme_name)?>.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?=root?>uploads/global/favicon.png">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
    <script src="<?=root?>assets/js/select2.js"></script>

    <?php 
    if (($lang_dir)=="RTL") { ?>
    <!-- RTL CSS  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" type="text/css" href="<?=root?>assets/css/rtl.css">
    <?php } ?>

    <!-- YOUR JS CODE GOES HERE -->
    <?php
    echo(base()->app->javascript);
    // echo ("\n");
    ?>
</head>

<body id="fadein">

<div class="bodyload">
    <div class="rotatingDiv"></div>
</div>

<!-- THEME PRIMARY COLOR -->
<style>:root {--theme-bg: <?=base()->app->default_theme?>}</style>

<?php 
require_once "App/Views/DemoContent.php";
?>
    <header class="navbar fixed-top navbar-expand-lg p-lg-0">

        <div class="container">
            <!-- logo  -->
            <div class="d-flex">

                <!-- <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3; overflow: visible;"><g fill="none" fill-rule="nonzero"><path d="m2 16h28"></path><path d="m2 24h28"></path><path d="m2 8h28"></path></g></svg> -->

                <a href="<?=root?>" class="fadeout navbar-brand m-0 p-0 rounded-3">
                    <img class="logo p-1 rounded" style="max-width: 140px;max-height: 50px;" src="<?=root?>uploads/global/logo.png" alt="logo">
                </a>
            </div>

            <!-- toggle button  -->
            <button class="navbar-toggler rounded-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- nav items  -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                
                <!-- left  -->
                <div class="nav-item--left ms-lg-5">
                    
                    <ul class="header_menu navbar-nav">
                        
                        <?php 
                        $keys = array_column($module_status, 'order');
                        array_multisort($keys, SORT_ASC, $module_status);
                        foreach ($module_status as $module){
                        ?>

                        <?php if (isset($module->type)){ if ($module->type == "hotels"){ ?>
                        <li> <a class="nav-link fadeout <?php if(isset($meta['nav_menu'])){ if ($meta['nav_menu']=="hotels" || $meta['nav_menu']=="hotel"){ echo "active";} } ?>"
                                href="<?=root?>hotels"><?=T::hotels?></a></li>
                        <?php } } ?>

                        <?php if (isset($module->type)){ if ($module->type == "flights"){ ?>
                        <li> <a class="nav-link fadeout <?php if(isset($meta['nav_menu'])){ if ($meta['nav_menu']=="flights"){ echo "active";} } ?>"
                                href="<?=root?>flights"><?=T::flights?></a></li>
                        <?php } } ?>

                        <?php if (isset($module->type)){ if ($module->type == "tours"){ ?>
                        <li> <a class="nav-link fadeout <?php if(isset($meta['nav_menu'])){ if ($meta['nav_menu']=="tours" || $meta['nav_menu']=="tour"){ echo "active";} } ?>"
                                href="<?=root?>tours"><?=T::tours?></a></li>
                        <?php } } ?>

                        <?php if (isset($module->type)){ if ($module->type == "cars"){ ?>
                        <li> <a class="nav-link fadeout <?php if(isset($meta['nav_menu'])){ if ($meta['nav_menu']=="cars"){ echo "active";} } ?>"
                                href="<?=root?>cars"><?=T::cars?></a></li>
                        <?php } } ?>

                        <?php if (isset($module->type)){ if ($module->type == "visa"){ ?>
                        <li> <a class="nav-link fadeout <?php if(isset($meta['nav_menu'])){ if ($meta['nav_menu']=="visa"){ echo "active";} } ?>"
                                href="<?=root?>visa"><?=T::visa?></a></li>
                        <?php } } ?>

                            <?php if (isset($module->type)){ if ($module->type == "extra"){ ?>
                                <li> <a class="nav-link fadeout <?php if(isset($meta['nav_menu'])){ if ($meta['nav_menu']=="Blog"){ echo "active";} } ?>"
                                        href="<?=root?>blogs"><?=T::blog?></a></li>
                            <?php } } ?>
                        <?php } ?>

                    </ul>

                </div>
                
                <!-- right  -->
                <div class="nav-item--right" role="search">
                    <ul class="navbar-nav gap-2 me-auto mb-2 mb-lg-0">

                        <?php if (app()->app->multi_language == 1) {?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn ps-3 p-0 py-2 px-0 text-center d-flex align-items-center justify-content-center gap-0"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                <?php if (!isset($_SESSION['phptravels_client_language_country'])) { ?>
                                <img class="mx-2" style="width:18px"
                                    src="<?=root?>assets/img/flags/<?php foreach (app()->languages as $lang){ if($lang->default == 1){ echo strtolower($lang->country_id); } }?>.svg"
                                    alt="flag">
                                <?php } else {?>
                                <img class="mx-2" style="width:18px"
                                    src="<?=root?>assets/img/flags/<?=$_SESSION['phptravels_client_language_country']?>.svg"
                                    alt="flag">
                                <?php } ?>

                                <strong class="h6 m-0 header_options">
                                    <?php if (!isset($_SESSION['phptravels_client_language_name'])) { ?>
                                    <?php foreach (app()->languages as $lang){ if($lang->default == 1){ echo $lang->name; $def_language = $lang->name; } }?>
                                    <?php } else {?>
                                    <?=$_SESSION['phptravels_client_language_name']?>
                                    <?php } ?>
                                </strong>
                                <svg class="mx-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu rounded-1">
                                <?php foreach(app()->languages as $lang){ ?>
                                <li><a class="dropdown-item d-flex gap-3 fadeout"
                                        href="<?=root?>language/<?=strtolower($lang->country_id)?>/<?=$lang->name?>/<?=$lang->type?>">
                                        <img style="width:18px"
                                             src="<?=root?>assets/img/flags/<?=strtolower($lang->country_id)?>.svg"
                                             alt="flag"> </i><span><?=$lang->name?></span></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if (app()->app->multi_currency == 1) {?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn px-0 ps-3 text-center d-flex align-items-center justify-content-center gap-1"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <strong class="h6 m-0 header_options">
                                    <?php if (!isset($_SESSION['phptravels_client_currency'])) { ?>
                                    <?php foreach (app()->currencies as $currency){ if($currency->default == 1){ echo $currency->name; } }?>
                                    <?php } else {?>
                                    <?=$_SESSION['phptravels_client_currency']?>
                                    <?php } ?>
                                </strong>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu rounded-1">
                            <?php
                            foreach (app()->currencies as $currency) { { ?>
                                <li><a class="dropdown-item fadeout" href="<?=root?>currency/<?=$currency->name?>">
                                        <img class="mx-2" style="width:18px"
                                            src="<?=root?>assets/img/flags/<?=strtolower($currency->iso)?>.svg"
                                            alt="flag">
                                        <span><strong><?=$currency->name?></strong></span>
                                        <span class="mx-2">-</span> <small><?=$currency->nicename?></small>
                                    </a></li>
                                <?php } } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php if (app()->app->user_registration == 1) {?>
                        <li class="nav-item dropdown">
                            <a class="bg-light nav-link dropdown-toggle btn btn-outline-secondary px-0 ps-3 text-center d-flex align-items-center justify-content-center gap-2 border-0"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                <svg stroke="#000" class="pe-1" xmlns="http://www.w3.org/2000/svg" width="20"
                                    height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>

                                <strong class="m-0 text-dark">
                                    <?=T::account?>
                                </strong>

                                <svg stroke="#000" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>

                            </a>

                            <?php if(!isset($_SESSION['phptravels_client']->user_id)) { ?>
                            <ul class="dropdown-menu bg-white rounded-2">
                                <li><a class="dropdown-item fadeout" href="<?=root?>login"> <?=T::login?> </i></a></li>
                                <li><a class="dropdown-item fadeout" href="<?=root?>signup"> <?=T::signup?> </i></a></li>
                            </ul>
                            <?php } ?>

                            <?php if(isset($_SESSION['phptravels_client']->user_id)) { ?>
                            <ul class="dropdown-menu bg-white rounded-4">
                                <li><a class="dropdown-item fadeout" href="<?=root?>dashboard"> <?=T::dashboard?></i></a></li>
                                <li><a class="dropdown-item fadeout" href="<?=root?>bookings"> <?=T::bookings?></i></a></li>
                                <li><a class="dropdown-item fadeout" href="<?=root?>wallet"> <?=T::wallet?></i></a></li>
                                <li><a class="dropdown-item fadeout" href="<?=root?>profile"> <?=T::profile?></i></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fadeout" href="<?=root?>logout"> <?=T::logout?></i></a></li>
                            </ul>
                            <?php } ?>

                        </li>
                        <?php } ?>

                    </ul>
                </div>
                
            </div>
            <!-- nav items end  -->
        </div>
    </header>


    <script>
    
    // HEADER NAVBAR
    let resize = true;
    $(window).scroll(function() {
        var nav = $('#navbarMain');
        var top = 50;
        if ($(window).scrollTop() >= top && resize) {
            $("header").addClass('swap_navbar');
        } else if(resize) {
            $("header").removeClass('swap_navbar');
        }        
    });

    $(window).on("load", (function() {
        if($(window).innerWidth() + 10 < 769) {
            $("header").addClass('swap_navbar');
            resize = false;
        }
        else {
            $("header").removeClass('swap_navbar');
            resize = true;
        }
    }));

    $(window).on("load", (function() {
    var scroll = $(window).scrollTop();
    if (scroll > 20 ) {
        $("header").addClass('swap_navbar');
    }
    }) )

    </script>

    <script>
    // ger users country
    var requestUrl = "<?=root?>visitor_details";
    fetch(requestUrl)
    .then(function(response) { return response.json(); })
    .then(function(c) { var user_country = c['country_name']; 
    
    // console.log("Visitor Country :"+ " "+ user_country);

    // submit to db
    var req = '<?=root.api_url?>traffic?country=' + user_country; fetch(req) });
    </script>

<!-- PLAN ANIMATION -->
<!-- <div id="splash">
  <div class="anim">
    <div id="loader">
      <svg version="1.1" width="60px" height="70px" viewBox="0 0 60 70">
        <defs>
          <filter id="f1" x="0" y="0">
            <feGaussianBlur in="SourceGraphic" stdDeviation="2" />
          </filter>
        </defs>
        <g id="airplane">
          <path fill="#000" d="M0.677,20.977l4.355,1.631c0.281,0.104,0.579,0.162,0.88,0.16l9.76-0.004L30.46,41.58c0.27,0.34,0.679,0.545,1.112,0.541
            h1.87c0.992,0,1.676-0.992,1.322-1.918l-6.643-17.439l6.914,0.002l6.038,6.037c0.265,0.266,0.624,0.412,0.999,0.418l1.013-0.004
            c1.004-0.002,1.684-1.012,1.312-1.938l-2.911-7.277l2.912-7.278c0.372-0.928-0.313-1.941-1.313-1.938h1.017
            c-0.375,0-0.732,0.15-0.996,0.414l-6.039,6.039h-6.915l6.646-17.443c0.354-0.926-0.33-1.916-1.321-1.914l-1.87-0.004
            c-0.439,0.004-0.843,0.203-1.112,0.543L15.677,17.24l-9.765-0.002c-0.3,0.002-0.597,0.055-0.879,0.16L0.678,19.03
            C-0.225,19.36-0.228,20.637,0.677,20.977z" transform="translate(44,0) rotate(90 0 0)" />
        </g>
        <g id="shadow" transform="scale(.9)">
          <path fill="#000" fill-opacity="0.3" d="M0.677,20.977l4.355,1.631c0.281,0.104,0.579,0.162,0.88,0.16l9.76-0.004L30.46,41.58c0.27,0.34,0.679,0.545,1.112,0.541
            h1.87c0.992,0,1.676-0.992,1.322-1.918l-6.643-17.439l6.914,0.002l6.038,6.037c0.265,0.266,0.624,0.412,0.999,0.418l1.013-0.004
            c1.004-0.002,1.684-1.012,1.312-1.938l-2.911-7.277l2.912-7.278c0.372-0.928-0.313-1.941-1.313-1.938h1.017
            c-0.375,0-0.732,0.15-0.996,0.414l-6.039,6.039h-6.915l6.646-17.443c0.354-0.926-0.33-1.916-1.321-1.914l-1.87-0.004
            c-0.439,0.004-0.843,0.203-1.112,0.543L15.677,17.24l-9.765-0.002c-0.3,0.002-0.597,0.055-0.879,0.16L0.678,19.03
            C-0.225,19.36-0.228,20.637,0.677,20.977z" transform="translate(64,30) rotate(90 0 0)" filter="url(#f1)" />
        </g>
      </svg>
    </div>
  </div>
</div> -->