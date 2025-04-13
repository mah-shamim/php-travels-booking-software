<!doctype html>
<html lang="en" <?php if($isRTL == "RTL"){ ?> dir="RTL"<?php } ?> >
  <head>
    <?=google_tag();?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="<?php echo @$metadescription; ?>">
    <meta name="keywords" content="<?php echo @$metakeywords; ?>">
    <meta name="author" content="PHPTRAVELS">
    <title><?php echo @$pageTitle; ?></title>
    <!-- facebook -->
    <meta property="og:title" content="<?php if(!empty($module->meta_title)){ echo $module->meta_title; }else{ echo @$pageTitle;  } ?>"/>
    <meta property="og:site_name" content="<?php echo $app_settings[0]->site_title;?>"/>
    <meta property="og:description" content="<?php if($app_settings[0]->seo_status == "1"){echo $metadescription;}?>"/>
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/global/favicon.png"/>
    <meta property="og:url" content="<?php echo $app_settings[0]->site_url;?>/"/>
    <meta property="og:publisher" content="<?php echo base_url(); ?>"/>
    <!--<script>document.getElementById("homeload").remove();</script>-->
    <!-- MetaTags -->
    <script type="application/ld+json">
    {
    "@context" : "http://schema.org",
    "@type" : "Corporation",
    "brand": "<?php echo $app_settings[0]->site_title;?>",
    "description": "<?php echo @$metadescription; ?>",
    "name" : "<?php echo $app_settings[0]->site_title;?>",
    "founders": [
    ""
    ],
    "foundingDate": "2019-05",
    "foundingLocation": "",
    "knowsAbout": "<?php echo @$metadescription; ?>",
    "legalName": "<?php echo $app_settings[0]->site_title;?>",
    "logo" : "<?php echo base_url(); ?>uploads/global/favicon.png",
    "numberOfEmployees": "10",
    "ownershipFundingInfo": "<?php echo base_url(); ?>about-Us",
    "url" : "<?php echo base_url(); ?>",
    "sameAs" : [
    <?php $count = $socialcount; foreach($footersocials as  $key=>$value) { if($key == end($count)){ echo '"'.$value->social_link.'"'. "\n";}else{echo '"'.$value->social_link.'"'. ",\n"; } } ?>
    ],
    "slogan": "<?php echo $app_settings[0]->site_title;?>",
    "tickerSymbol": [
    "NYSE:SHOP",
    "TSX:SHOP"
    ],
    "awards": "https://phptravels.com/"
    }
    </script>

    <!-- Fav and Touch Icons -->
    <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Font face -->
    <!--<link href="https://fonts.googleapis.com/css?family=Aleo:300,300i,400,400i,700,700i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">-->
    <!-- CDN URL -->

    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/line-awesome.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/daterangepicker.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/animated-headline.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/jquery-ui.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/jquery.filer.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/style.css">
    <link rel="stylesheet" href="<?=$theme_url ?>assets/css/mobile.css">
    <link rel="stylesheet" href="<?=$theme_url ?>style.css">
    <style> @import "<?php echo $theme_url; ?>assets/css/childstyle.css"; </style>

    <?php if($isRTL == "RTL"){ ?>
    <link href="<?php echo $theme_url; ?>assets/css/style-rtl.css" rel="stylesheet">
    <link href="<?php echo $theme_url; ?>RTL.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Tajawal:300,400,500,700,800&amp;subset=arabic" rel="stylesheet">
    <?php } ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- RTL CSS -->
    <script src="<?=$theme_url ?>assets/js/jquery-3.4.1.min.js"></script>
    <!-- Mobile Redirect -->
    <?php if($mSettings->mobileRedirectStatus == "Yes"){ if($ishome != "invoice"){ ?> <script>if(/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)){ window.location ="<?php echo $mSettings->mobileRedirectUrl; ?>";}</script> <?php } } ?>
    <!-- Autocomplete files-->
    <!--<link href="<?php echo $theme_url; ?>assets/js/autocomplete/easy-autocomplete.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo $theme_url; ?>assets/js/autocomplete/jquery.easy-autocomplete.min.js" type="text/javascript" ></script>
    --><!-- <script src="<?php echo $theme_url; ?>assets/js/plugins/datepicker.js"></script> -->
    <!-- Autocomplete files-->
    <script>var base_url = '<?php echo base_url(); ?>';</script>
    <?php echo $app_settings[0]->google; ?>
    </head>
    <?php
    echo "<style>body{margin:0px;padding:0px}</style>";
    ?>
  <!-- start Body -->
  <body class="with-waypoint-sticky" onload="document.body.style.opacity='1'">
  <?=demo_header();?>

<!-- start cssload-loader -->
<!--<div class="preloader" id="preloader">
    <div class="loader">
        <svg class="spinner" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
    </div>
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
                               <?php if( ! empty($phone) ) { ?> <li><a href="#"><i class="la la-phone mr-1"></i> <!--<?php echo trans('0438');?>--> <?php echo $phone; ?></a></li> <?php } ?>
                               <?php if( ! empty($contactemail) ) { ?><li><a href="mailto:<?php echo $contactemail; ?>"><i class="la la-envelope mr-1"></i><?php echo $contactemail; ?></a></li><?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-top-content">
                        <div class="header-right d-flex align-items-center justify-content-end">
                            <?php if(empty($langname))
                            { $langname = languageName($lang_set);} else{ $langname = $langname;}
                             if (strpos($currenturl,'book') !== false || !empty($hideLang) || strpos($currenturl,'checkout') !== false) { } else{
                                    if($app_settings[0]->multi_lang == '1'){ $default_lang = $app_settings[0]->default_lang;if(!empty($lang_set) && $lang_set == 'en')
                                                { $default_lang = 'us';}else{
                                            foreach($languageList as $ldir => $lname){if ($lang_set == $ldir) {
                                                    $default_lang = $lname['country'];}}}?>
                            <div class="header-right-action">
                                <div class="select-contain select--contain w-auto">
                                    <select class="select-contain-select" onchange="location = this.value;">
                                    <?php $count=1; while($count <= 1) {?>
                                        <option value="en" data-content='<span class="flag-icon flag-icon-<?=$default_lang?> mr-1"></span><?=$langname?>'></option>
                                    <?php $count++; } ?>
                                      <?php  foreach($languageList as $ldir => $lname){
                                         $selectedlang = ''; 
                                        if(!empty($lang_set) && $lang_set == $ldir)
                                            { $selectedlang = 'selected'; }
                                        elseif(empty($lang_set) && $default_lang == $ldir)
                                            { $selectedlang = 'selected'; }if ($lname['name'] != $langname) {?>
                                      <option id="<?php echo $ldir; ?>" value="<?php echo pt_set_langurl($langurl,$ldir);?>" data-content='<span class="flag-icon flag-icon-<?php if($lname['country'] != $default_lang)echo $lname['country'];?> mr-1"></span> <?php if($lname['name'] != $langname) echo $lname['name'];?>'></option>
                                      <!--<a id="<?php echo $ldir; ?>"  ><span class="image"><img src="<?php echo PT_LANGUAGE_IMAGES.$ldir.".png";?>" alt="image" /></span> </a> -->
                                      <?php  }} ?>
                                    </select>
                                </div>
                            </div>
                           <?php } ?>
                          <?php } ?>
                            <div class="header-right-action">
                                <div class="select-contain select--contain w-auto">
                                    <?php if(strpos($currenturl,'book') == false &&  strpos($currenturl,'checkout') == false && $app_settings[0]->multi_curr == 1 && empty($hideCurr)): $currencies = ptCurrencies(); ?>
                                    <select class="select-contain-select" id="selectBox" onchange="change_currency()">
                                        <option><?php echo isset($_SESSION['currencycode']) ? $_SESSION['currencycode'] : defaultCurrencies(); ?></option>
                                        
                                        <?php foreach($currencies as $c):
                                        if (empty($_SESSION['currencycode']) && $c->name != defaultCurrencies()) {?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->name;?></option>
                                        <?php }if (!empty($_SESSION['currencycode'] && $_SESSION['currencycode'] != $c->name)) {?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->name;?></option>
                                        <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!--<?php if($allowsupplierreg){ ?>
                            <div class="header-right-action">
                            <a href="<?php echo base_url(); ?>supplier-register/" class="theme-btn theme-btn-small"><?php echo trans('0241');?></a>
                            <a href="<?php echo base_url(); ?>supplier/" class="theme-btn theme-btn-small theme-btn-transparent ml-1"><?php echo trans('0527');?></a>
                            </div>
                            <?php } ?>-->

                            <?php  if(!empty($customerloggedin)){ ?>
                            <li class="d-none d-md-block fl">
                            <div class="dropdown dropdown-login dropdown-tab">
                            <a href="javascript:void(0);" class="btn btn-text-inherit btn-interactive" id="dropdownCurrency" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-user"></i> <!--<?php echo $firstname; ?>--> <?php echo trans('0146');?> <i class="la la-angle-down"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownCurrency">
                            <div class="">
                            <a class="dropdown-item active tr" href="<?php echo base_url(); ?>account"><?php echo trans('073');?></a>
                            <a class="dropdown-item tr" href="<?php echo base_url(); ?>account/logout/"><?php echo trans('03');?></a>
                            </div>
                            </div>
                            </div>
                            </li>

                            <div class="nav-btn">
                            <?php }else{ if (strpos($currenturl,'book') !== false || strpos($currenturl,'checkout') !== false) { }else{ if($allowreg == "1"){ ?>
                            <a href="<?php echo base_url(); ?>register" class="theme-btn theme-btn-small"><?php echo trans('0115');?></a>
                            <a href="<?php echo base_url(); ?>login" class="theme-btn theme-btn-small theme-btn-transparent ml-1"><?php echo trans('04');?></a>
                            <?php } } } ?>
                            </div><!-- end nav-btn -->

                        </div>
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
                        <a href="#" class="down-button"><i class="la la-angle-down"></i></a>
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>">
                               <img style="max-width:150px" src="<?php echo PT_GLOBAL_IMAGES_FOLDER.$app_settings[0]->header_logo_img;?>" alt="<?php echo @$pageTitle; ?>">
                            </a>
                            <div class="menu-toggler">
                                <i class="la la-bars"></i>
                                <i class="la la-times"></i>
                            </div><!-- end menu-toggler -->
                        </div><!-- end logo -->
                        <div class="main-menu-content">
                            <nav>

                            <ul>
                            <li><a href="<?php echo base_url(); ?>" title="home"><?=lang('01')?></a></li>
                            <?=menu(1);?>
                            </ul>
                              <!--<?=menu(1);?>-->
                            </nav>
                        </div><!-- end main-menu-content -->

                    </div><!-- end menu-wrapper -->
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container-fluid -->
    </div><!-- end header-menu-wrapper -->
</header>
<!-- ================================
         END HEADER AREA
================================= -->