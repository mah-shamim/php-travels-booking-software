<!DOCTYPE html>
<html lang="en" dir="<?= $USER_SESSION->backend_user_language_position ?>">
<head>
    <meta charset="UTF-8">
    <title><?php if (isset($title)) {echo $title;} ?></title>
    <link rel="shortcut icon" href="../uploads/global/favicon.png?v<?= rand(0, 99999999999) ?>">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="Cache-control" content="private">
    <meta http-equiv="refresh" content="4000; ./login-logout.php" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/app.css" />
    <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
</head>

<?php if($USER_SESSION->backend_user_language_position=="rtl"){?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./assets/css/rtl.css" />
    <style>
        *{text-decoration:none !important}
        main header .btn{border:transparent !important}
        header ul .alerts  button {display: flex}
    </style>
<?php } ?>

<body>
<div class="bodyload">
    <div class="rotatingDiv"></div>
</div>
<script>
setTimeout(function() {
    $('.bodyload').fadeOut();
}, 100);

$(document).on("click", ".loadeffect, .loading_effect", function() {
    var newUrl = $(this).attr("href");
    if (!newUrl || newUrl[0] === "#") {
        location.hash = newUrl;
        return;
    }
    $('.bodyload').fadeIn();
    location = newUrl;
    return false;
});
</script>

<main>

<?php $url_name = basename($_SERVER['PHP_SELF'], ".php");

$params = array("user_id" => $USER_SESSION->backend_user_id);
$user_type_id = GET('users', $params)[0]->user_type;

if (empty($user_type_id)) {
    echo '<div style="gap:10px; width: 100%; display: flex; justify-content: center; align-items: center; background: #1b2a47; color: #fff; font-size: 14px;">This user has no " User Type "
<a href="./login-logout.php" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning">  Logout</a>
</div>';
    exit;
}

$params = array("type_name" => $user_type_id);
$data = GET('users_roles', $params)[0]->permissions;
$user_permissions = (json_decode($data));

    // $access_not_allowed = '<div style="gap:10px; width: 100%; display: flex; justify-content: center; align-items: center; background: #1b2a47; color: #fff; font-size: 14px;">Page Access Not Allowed
    // <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning">  Back</a>
    // </div>';

foreach ($pages as $p => $i) {

    if (isset($user_permissions->modules->edit)) {
        if ($url_name == "module-setting") {
            // echo $access_not_allowed;
            REDIRECT("./login-logout.php");
            exit;
        }
    }

    if (!isset($user_permissions->$p->page_access) && $url_name == $p) {
        // echo $access_not_allowed;
        REDIRECT("./login-logout.php");
        exit;
    }
}
if (isset($user_permissions->$url_name->add)) {
    $permission_add = 1;
}
if (isset($user_permissions->$url_name->edit)) {
    $permission_edit = 1;
} else {
    $alert_edit = 1;
}
if (isset($user_permissions->$url_name->view)) {
    $permission_view = 1;
}
if (isset($user_permissions->$url_name->delete)) {
    $permission_delete = 1;
}

?>

<header class="d-flex flex-column flex-shrink-0 text-white sidebar" style="width:240px;background:#000;overflow:auto">
    <div class="p-3 d-flex items-align-center justify-content-between border-bottom pb-3 mb-3 ">
        <a href="./dashboard.php" class="loadeffect d-flex align-items-center link-light text-decoration-none gap-2">
            <img src="../uploads/global/favicon.png?v<?= rand(0, 99999999999) ?>"
                style="max-width: 30px; border-radius:10px">
            <span class="fw-semibold"><?= T::dashboard ?></span>
        </a>
        <a href="<?= root . ('../') ?>" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <g fill="none" fill-rule="evenodd">
                    <path
                        d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h5M15 3h6v6M10 14L20.2 3.8" />
                </g>
            </svg>
        </a>
    </div>
    <ul class="nav nav-pills flex-column mb-auto p-0">

    <li class="mb-0 alerts">
        <div class="btn-group dropend w-100">
        <button data-bs-auto-close="false" class="text-start btn btn-outline-light btn-toggle w-100 gap-3" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <svg style="margin-left:-27px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path></svg>
        <div class="d-flex justify-content-between w-100">
        <div><?=T::alerts?></div>
        <div class="mx-4">

        <?php 
        $params = array( 'status' => 1 );
        $count = GET('notifications',$params);
        ?>

        <span class="bg-danger p-1 rounded-5 px-2 notificaition_count_number" style="font-size:10px"><?=count($count)?></span>
        </div>
        </div>
        </button>
        <hr>
        <ul class="dropdown-menu drapdown" style="z-index:9999;border-radius:0;position:fixed !important;margin: 0 240px;transform: none !important;">

        <?php
        array_multisort(array_column($count,'date'), SORT_DESC, $count);
        foreach($count as $c){ ?>
        <li><a class="dropdown-item notification_<?=$c->id?>" href="#">
        <button style="border-radius: 5px !important;" class="btn btn-warning btn-sm p-3 py-0" onclick="notification(<?=$c->id?>)">
        <svg class="m-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
        </button> 
        <span class="px-2"><?=$c->name?></span></a></li>
        <?php } ?>

        </ul>
        </div>
    </li>

    <script>
        function notification(name){
            $('.notification_'+name).fadeOut(200);
            var form = new FormData();
            form.append("notification_delete", "");
            form.append("id", name);
            var settings = {
            "url": "./_post.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
            };
            $.ajax(settings).done(function (response) { 
                console.log(response); 
                $('.notificaition_count_number').html(parseInt($('.notificaition_count_number').html(), 10)-1)
            });
        }
    </script>

    <!--===================================================================================== SETTINGS -->

        <?php
        if (
            isset($user_permissions->settings->page_access)
            || isset($user_permissions->payment_gateways->page_access)
            || isset($user_permissions->currencies->page_access)
            || isset($user_permissions->locations->page_access)
            || isset($user_permissions->email_settings->page_access)
            || isset($user_permissions->languages->page_access)
            || isset($user_permissions->users_roles->page_access)
            || isset($user_permissions->countries->page_access)
         ) { ?> 

            <li class="mb-0">
            <button 
            class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
            data-bs-toggle="collapse" data-bs-target="#settings-collapse"
            aria-expanded="<?php if ($url_name == "settings" || $url_name == "countries" || $url_name == "payment_gateways" || $url_name == "payment-gateway" || $url_name == "currencies" || $url_name == "locations" || $url_name == "email_settings" || $url_name == "languages" || $url_name == "users_roles" ) {
                echo "true";
            } else {
                echo "false";
            } ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            <?= T::settings ?>
            </button>
            <div class="collapse <?php if ($url_name == "settings" || $url_name == "countries" || $url_name == "payment_gateways" || $url_name == "payment-gateway" || $url_name == "module-setting" || $url_name == "currencies" || $url_name == "locations" || $url_name == "email_settings" || $url_name == "languages" || $url_name == "users_roles") { echo "show"; } ?>" id="settings-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">

            <!-- SETTINGS -->
            <?php if (isset($user_permissions->settings->page_access)) { ?> 
                <li><a href="./settings.php" class="loadeffect link-light <?php if ($url_name == "settings") { echo "active"; } ?>"><?= T::general ?> <?= T::settings ?></a></li> 
            <?php } ?> 

            <!-- USERS ROLES -->
            <?php if (isset($user_permissions->users_roles->page_access)) { ?>
            <li><a href="./users_roles.php" class="loadeffect link-light  <?php if ($url_name == "users_roles") { echo "active"; } ?>"><?= T::users_roles ?></a> </li>
            <?php } ?>

            <!-- PAYMENT GATEWAYS -->
            <?php if (isset($user_permissions->payment_gateways->page_access)) { ?>
                <li><a href="./payment_gateways.php" class="loadeffect link-light  <?php if ($url_name == "payment_gateways" || $url_name == "payment_gateway") { echo "active"; } ?>"><?= T::payment_gateways ?></a> </li> 
            <?php } ?> 

            <!-- CURRENCIES -->
            <?php if (isset($user_permissions->currencies->page_access)) { ?>
                <li><a href="./currencies.php" class="loadeffect link-light  <?php if ($url_name == "currencies") { echo "active"; } ?>"><?= T::currencies ?></a> </li> 
            <?php } ?> 

            <!-- EMAIL SETTINGS -->
            <?php if (isset($user_permissions->email_settings->page_access)) { ?>
                <li><a href="./email_settings.php" class="loadeffect link-light  <?php if ($url_name == "email_settings") { echo "active"; } ?>"><?= T::email_settings ?></a> </li> 
            <?php } ?> 

            <!-- LOCATIONS -->
            <?php if (isset($user_permissions->locations->page_access)) { ?>
                <li><a href="./locations.php" class="loadeffect link-light  <?php if ($url_name == "locations") { echo "active"; } ?>"><?= T::locations ?></a> </li>
            <?php } ?> 

            <!-- LANGUAGES -->
            <?php if (isset($user_permissions->languages->page_access)) { ?>
                <li><a href="./languages.php" class="loadeffect link-light  <?php if ($url_name == "languages") { echo "active"; } ?>"><?= T::languages ?></a> </li>
            <?php } ?> 

            <!-- COUNTRIES -->
            <?php if (isset($user_permissions->countries->page_access)) { ?>
                <li><a href="./countries.php" class="loadeffect link-light  <?php if ($url_name == "countries") { echo "active"; } ?>"><?= T::countries ?></a> </li>
            <?php } ?> 

            </ul>
            </div>
            </li>
        <?php } ?>

    <!--===================================================================================== SETTINGS -->


    <!--===================================================================================== MARKUPS -->

    <?php if (isset($user_permissions->modules->page_access)) { ?>  

    <li class="mb-0">
    <a class="loadeffect text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3 <?php if ($url_name == "modules"){ echo "active"; } ?>" href="./modules.php">
    <svg style="margin-left: -30px;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <?= T::modules ?>
    </a>

    </li>
    <?php } ?>

    <!--===================================================================================== SETTINGS -->

    <!--===================================================================================== MARKUPS -->
    <?php
    if (
        isset($user_permissions->markups->page_access)
    ) { ?>
            
            <li class="mb-0">
            <button 
            class="text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3 #<?php if ($url_name == "markups") { echo "active"; } ?>"
            data-bs-toggle="collapse" data-bs-target="#markups-collapse"
            aria-expanded="<?php if ($url_name == "markups") {
                echo "true";
            } else {
                echo "false";
            } ?>">
            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
            <?= T::markups ?>
            </button>
            <div class="collapse <?php if ($url_name == "markups") { echo "show"; } ?>"
            id="markups-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
            
            <!-- <li><a href="./markups.php?module=all" class="loadeffect link-light
            <?php if (isset($_GET['module'])) { if ($_GET['module'] == "all") 
                { echo "active"; } } ?>"><?=T::all.' '.T::markups ?></a>
            </li> -->

            <li><a href="./markups.php?module=users" class="loadeffect link-light
            <?php if (isset($_GET['module'])) { if ($_GET['module'] == "users") 
                { echo "active"; } } ?>"><?=T::users ?></a>
            </li>

            <?php 
            
            $params = array("status" => 1);
            $modules=(GET("modules",$params));

            $temp_module = array_unique(array_column($modules, 'type'));
            $module_status = array_intersect_key($modules, $temp_module);

            $keys = array_column($module_status, 'order');
            array_multisort($keys, SORT_ASC, $module_status);

            foreach ($module_status as $module){
                if($module->type == "flights" && $module->status == 1 && $module->name =="flights"){$flight_active = 1;}
                if($module->type == "hotels" && $module->status == 1 && $module->name =="hotels"){$hotels_active = 1;}
                if($module->type == "tours" && $module->status == 1 && $module->name =="tours"){$tours_active = 1;}
                if($module->type == "cars" && $module->status == 1 && $module->name =="cars"){$cars_active = 1;}
                if($module->type == "extra" && $module->status == 1 && $module->name =="blog"){$blog_active = 1;}
            ?>

            <?php if (isset($module->type)){ if ($module->type == "hotels"){ ?>
            <li><a href="./markups.php?module=hotels" class="loadeffect link-light
                <?php if (isset($_GET['module'])) { if ($_GET['module'] == "hotels")
                { echo "active"; } } ?>"><?=T::hotels ?></a>
            </li>
            <?php } } ?>

            <?php if (isset($module->type)){ if ($module->type == "flights"){ ?>
            <li><a href="./markups.php?module=flights" class="loadeffect link-light
                <?php if (isset($_GET['module'])) { if ($_GET['module'] == "flights")
                { echo "active"; } } ?>"><?=T::flights ?></a>
            </li>
            <?php } } ?>


            <?php if (isset($module->type)){ if ($module->type == "tours"){ ?>
            <li><a href="./markups.php?module=tours" class="loadeffect link-light
                <?php if (isset($_GET['module'])) { if ($_GET['module'] == "tours")
                { echo "active"; } } ?>"><?=T::tours ?></a>
            </li>
            <?php } } ?>


            <?php if (isset($module->type)){ if ($module->type == "cars"){ ?>
            <li><a href="./markups.php?module=cars" class="loadeffect link-light
                <?php if (isset($_GET['module'])) { if ($_GET['module'] == "cars")
                { echo "active"; } } ?>"><?=T::cars ?></a>
            </li>
            <?php } } ?>


            <!-- <?php if (isset($module->type)){ if ($module->type == "visa"){ ?>
            <li><a href="./markups.php?module=visa" class="loadeffect link-light
                <?php if (isset($_GET['module'])) { if ($_GET['module'] == "visa")
                { echo "active"; } } ?>"><?=T::visa ?></a>
            </li>
            <?php } } ?> -->


            <?php } ?>

            </ul>
            </div>
            </li>
        <?php } ?>

    <!--===================================================================================== MARKUPS -->


    <!--===================================================================================== USERS -->
    <?php
    if (
        isset($user_permissions->users->page_access)
    ) { ?>

            <?php
            $params = array();
            $users_roles = GET('users_roles', $params); ?>
                <li class="mb-0">
                <button
                class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
                data-bs-toggle="collapse" data-bs-target="#users-collapse"
                aria-expanded="<?php if ($url_name == "customer" || $url_name == "admin" || $url_name == "staff" || $url_name == "agent" || $url_name == "supplier" || $url_name == "profile") {
                    echo "true";
                } else {
                    echo "false";
                } ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <?= T::users ?>
                </button>
                <div class="collapse <?php if ($url_name == "users" || $url_name == "admins" || $url_name == "staff" || $url_name == "agents" || $url_name == "suppliers" || $url_name == "profile") {
                    echo "show";
                } ?>"
                id="users-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
                <?php if (isset($user_permissions->users->page_access)) { ?>
                    <li><a href="./users.php?users=all-users"
                    class="loadeffect link-light  <?php if (isset($_GET['users'])) {
                        if ($_GET['users'] == "all-users") {
                            echo "active";
                        }
                    } ?>"><?= T::all . ' ' . T::users ?></a>
                    </li>
                <?php } ?>


                <hr class="m-0 my-1 mt-2">
                <?php foreach ($users_roles as $u) { ?>
                    <li><a href="./users.php?user_type=<?= $u->type_name ?>"
                    class="loadeffect link-light  <?php if (isset($_GET['user_type'])) {
                        if ($_GET['user_type'] == $u->type_name) {
                            echo "active";
                        }
                    } ?>"><?= $u->type_name ?></a>
                    </li>
                <?php } ?>
                </ul>
                </div>
                </li>
        <?php } ?>

    <!--===================================================================================== USERS -->

    <!--===================================================================================== CMS -->

        <?php
        if (
            isset($user_permissions->cms->page_access)
        ) { ?>
                                <li class="mb-0">
                                    <button
                                        class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
                                        data-bs-toggle="collapse" data-bs-target="#cms-collapse"
                                        aria-expanded="<?php if ($url_name == "cms") {
                                            echo "true";
                                        } else {
                                            echo "false";
                                        } ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                        <?= T::cms ?>
                                    </button>
                                    <div class="collapse <?php if ($url_name == "cms") {
                                        echo "show";
                                    } ?>"
                                        id="cms-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">

                                            <?php
                                            if (
                                                isset($user_permissions->cms->add)
                                                || isset($user_permissions->cms->add)
                                            ) { ?>

                                                                <li><a href="./cms.php?addpage=1"
                                                                        class="loadeffect link-light <?php if (isset($_GET['addpage'])) {
                                                                            echo "active";
                                                                        } ?>"><?= T::cms_add_page ?></a>
                                                                </li>
                                            <?php } ?>
                                            <li><a href="./cms.php?pages=1"
                                                    class="loadeffect link-light <?php if (isset($_GET['pages']) || (isset($_GET['page']))) {
                                                        echo "active";
                                                    } ?>"><?= T::cms_pages ?></a>
                                            </li>
                                            <li><a href="./cms.php?menu=1"
                                                    class="loadeffect link-light <?php if (isset($_GET['menu'])) {
                                                        echo "active";
                                                    } ?>"><?= T::cms_menu ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
            <?php } ?>

    <!--===================================================================================== CMS -->


     <!--===================================================================================== BLOG -->

     <?php

        if (
            isset($user_permissions->blogs->page_access)
        ) { if(!empty($blog_active) && $blog_active == 1){ ?>
                                <li class="mb-0">
                                    <button
                                        class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
                                        data-bs-toggle="collapse" data-bs-target="#blog-collapse"
                                        aria-expanded="<?php if ($url_name == "blogs") {
                                            echo "true";
                                        } else {
                                            echo "false";
                                        } ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg>
                                        <?= T::blog ?>
                                    </button>
                                    <div class="collapse <?php if ($url_name == "blogs") {
                                        echo "show";
                                    } ?>"
                                        id="blog-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">

                                            <?php
                                            if (
                                                isset($user_permissions->blogs->add)
                                                || isset($user_permissions->blogs->add)
                                            ) { ?>
                                            <li><a href="./blogs.php?addpage=1"
                                                    class="loadeffect link-light <?php if (isset($_GET['addpage'])) {
                                                        echo "active";
                                                    } ?>"><?= T::Blog_add_page ?></a>
                                            </li>
                                            <?php } ?>
                                            <li><a href="./blogs.php?pages=1"
                                                    class="loadeffect link-light <?php if (isset($_GET['pages']) || (isset($_GET['page']))) {
                                                        echo "active";
                                                    } ?>"><?= T::Blog_pages ?></a>
                                            </li>
                                            <li><a href="./blogs.php?category=1"
                                                    class="loadeffect link-light <?php if (isset($_GET['category'])) {
                                                        echo "active";
                                                    } ?>"><?= T::blog_category ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
            <?php } } ?>

    <!--===================================================================================== BLOG -->

    <!--===================================================================================== NEWSLETTER -->

    <?php
        if ( isset($user_permissions->newsletter->page_access) ) { ?>
            <li class="mb-0">
            <a class="loadeffect text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3 <?php if ($url_name == 'newsletter') {
                echo "active";
            } ?>" href="./newsletter.php">

            <svg style="margin-left: -30px;" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>

             <?= T::newsletter ?></a>
            </li>
        <?php } ?>

    <!--===================================================================================== NEWSLETTER -->

    <!--===================================================================================== REPORTS -->

     <!-- <?php
        if (
            isset($user_permissions->reports->page_access)
        ) { ?>
        <li class="mb-0">
            <button 
                class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
                data-bs-toggle="collapse" data-bs-target="#reports-collapse"
                aria-expanded="<?php if ($url_name == "reports") {
                    echo "true";
                } else {
                    echo "false";
                } ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>
                <?= T::reports ?>
            </button>
            <div class="collapse <?php if ($url_name == "reports") {
                echo "show";
            } ?>" id="reports-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
                    <li><a href="./reports.php?bookings" class="loadeffect link-light <?php if (isset($_GET['bookings']) || (isset($_GET['bookings']))) {
                        echo "active";
                    } ?>"><?= T::bookings ?></a></li>
                    <li><a href="./reports.php?users" class="loadeffect link-light <?php if (isset($_GET['users']) || (isset($_GET['users']))) {
                        echo "active";
                    } ?>"><?= T::users ?></a></li>
                </ul>
            </div>
        </li>
        <?php } ?>   -->

    <!--===================================================================================== REPORTS -->

        <li class="border-top my-1"></li>

    <!--===================================================================================== BOOKINGS -->

        <!-- <?php
        if (
            isset($user_permissions->bookings->page_access)
        ) { ?>
        <li class="mb-0">
            <button 
                class="text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3"
                data-bs-toggle="collapse" data-bs-target="#bookings-collapse"
                aria-expanded="<?php if ($url_name == "bookings") {
                    echo "true";
                } else {
                    echo "false";
                } ?>">
            <svg style="margin-left: -30px;" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <?= T::bookings ?>
            </button>
            <div class="collapse <?php if ($url_name == "bookings") {
                echo "show";
            } ?>" id="bookings-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
                   
                   <li><a href="./bookings.php?flights" class="loadeffect link-light <?php if (isset($_GET['flights']) || (isset($_GET['flights']))) {
                        echo "active";
                    } ?>"><?= T::flights.' '.T::bookings ?></a></li>

                    <li><a href="./bookings.php?hotels" class="loadeffect link-light <?php if (isset($_GET['hotels']) || (isset($_GET['hotels']))) {
                        echo "active";
                    } ?>"><?= T::hotels.' '.T::bookings ?></a></li>

                    <li><a href="./bookings.php?tours" class="loadeffect link-light <?php if (isset($_GET['tours']) || (isset($_GET['tours']))) {
                        echo "active";
                    } ?>"><?= T::tours.' '.T::bookings ?></a></li>

                    <li><a href="./bookings.php?cars" class="loadeffect link-light <?php if (isset($_GET['cars']) || (isset($_GET['cars']))) {
                        echo "active";
                    } ?>"><?= T::cars.' '.T::bookings ?></a></li>

                  <li><a href="./bookings.php?visa" class="loadeffect link-light <?php if (isset($_GET['visa']) || (isset($_GET['visa']))) {
                        echo "active";
                    } ?>"><?= T::visa.' '.T::bookings ?></a></li> 

                </ul>
            </div>
        </li>
        <?php } ?> -->

    <!--===================================================================================== BOOKINGS -->

    <!--===================================================================================== BOOKINGS -->

    <?php
        if ( isset($user_permissions->bookings->page_access) ) { ?>
            <li class="mb-0">
            <a class="loadeffect text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3 <?php if ($url_name == 'bookings') {
                echo "active";
            } ?>" href="./bookings.php">
            <svg style="margin-left: -30px;" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>

             <?= T::bookings ?></a>
            </li>
        <?php } ?>

    <!--===================================================================================== BOOKINGS -->

     <!--===================================================================================== BOOKINGS -->

     <?php
        if ( isset($user_permissions->transactions->page_access) ) { ?>
            <li class="mb-0">
            <a class="loadeffect text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3 <?php if ($url_name == 'transactions') {
                echo "active";
            } ?>" href="./transactions.php">
            <svg style="margin-left: -30px;" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>

             <?= T::transactions ?></a>
            </li>
        <?php } ?>

    <!--===================================================================================== BOOKINGS -->


    <!--===================================================================================== FLIGHTS -->

    <?php
        if (
            isset($user_permissions->flights->page_access)
            || isset($user_permissions->flights_airports->page_access)
            || isset($user_permissions->flights_airlines->page_access)
            || isset($user_permissions->flights_featured->page_access)
            || isset($user_permissions->flights_suggestions->page_access)
            
        ) { if(!empty($flight_active) && $flight_active == 1){
            ?>
            <li class="mb-0">
                <button 
                    class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
                    data-bs-toggle="collapse" data-bs-target="#flights-collapse"
                    aria-expanded="<?php if 
                    ($url_name == "flights") {
                        echo "true";
                    } else {
                        echo "false";
                    } ?>">

                    <svg  style="margin-top:-5px" fill="#ffffff" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="0" stroke-linecap="round" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.72 26.2c-0.040 0-0.080 0-0.12 0-0.28-0.040-0.48-0.2-0.64-0.44l-1.96-3.56-3.56-1.96c-0.24-0.12-0.4-0.36-0.44-0.64s0.040-0.52 0.24-0.72l1.8-1.8c0.2-0.2 0.48-0.28 0.76-0.24l2.040 0.36 2.68-2.68-6.48-3.2c-0.24-0.12-0.4-0.36-0.48-0.64s0.040-0.56 0.24-0.76l2-2c0.2-0.2 0.52-0.28 0.8-0.24l8.48 2.2 2.96-2.96c1.040-1.040 3.48-1.8 4.72-0.56 0.56 0.56 0.76 1.48 0.56 2.52-0.16 0.84-0.6 1.64-1.12 2.16l-2.96 2.96 2.2 8.48c0.080 0.28 0 0.6-0.24 0.8l-2 2c-0.2 0.2-0.48 0.28-0.76 0.24s-0.52-0.2-0.64-0.48l-3.2-6.48-2.68 2.68 0.36 2.040c0.040 0.28-0.040 0.56-0.24 0.76l-1.8 1.8c-0.080 0.28-0.28 0.36-0.52 0.36zM2.24 19.28l2.8 1.52c0.16 0.080 0.24 0.2 0.32 0.32l1.52 2.8 0.68-0.68-0.32-2.040c-0.040-0.28 0.040-0.56 0.24-0.76l3.84-3.84c0.2-0.2 0.48-0.28 0.76-0.24s0.52 0.2 0.64 0.48l3.2 6.48 0.8-0.8-2.2-8.48c-0.080-0.28 0-0.6 0.24-0.8l3.28-3.28c0.6-0.6 0.92-1.96 0.56-2.32s-1.72 0-2.32 0.56l-3.28 3.28c-0.2 0.2-0.52 0.28-0.8 0.24l-8.52-2.2-0.8 0.8 6.48 3.2c0.24 0.12 0.4 0.36 0.48 0.64s-0.040 0.56-0.24 0.76l-3.84 3.84c-0.2 0.2-0.48 0.28-0.76 0.24l-2.040-0.36-0.72 0.64z"></path>
                    </svg>

                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg> -->
                    <?= T::flights ?>
                </button>
                <div class="collapse <?php if ($url_name == "flights" || $url_name == "flights_airports" || $url_name == "flights_airlines" || $url_name == "flights_featured" || $url_name == "flights_suggestions") {
                    echo "show";
                } ?>" id="flights-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
               
                            <!-- FLIGHTS AIRPORTS -->
                            <?php if (isset($user_permissions->flights->page_access)) { ?>
                            <li><a href="./flights.php" class="loadeffect link-light  <?php if ($url_name == "flights") { echo "active"; } ?>"><?= T::flights?></a> </li>
                            <?php } ?> 

                            <!-- FLIGHTS AIRPORTS -->
                            <?php if (isset($user_permissions->flights_airports->page_access)) { ?>
                                <li><a href="./flights_airports.php" class="loadeffect link-light  <?php if ($url_name == "flights_airports") { echo "active"; } ?>"><?= T::flights . ' ' . T::airports ?></a> </li>
                            <?php } ?> 

                            <!-- FLIGHTS AIRLINES -->
                            <?php if (isset($user_permissions->flights_airlines->page_access)) { ?>
                                <li><a href="./flights_airlines.php" class="loadeffect link-light  <?php if ($url_name == "flights_airlines") { echo "active"; } ?>"><?= T::flights . ' ' . T::airlines ?></a> </li>
                            <?php } ?> 

                            <!-- FLIGHTS FEATURED -->
                            <?php if (isset($user_permissions->flights_featured->page_access)) { ?>
                                <li><a href="./flights_featured.php" class="loadeffect link-light  <?php if ($url_name == "flights_featured") { echo "active"; } ?>"><?= T::flights . ' ' . T::featured ?></a> </li>
                            <?php } ?> 

                            <!-- FLIGHTS SUGGESTIONS -->
                            <?php if (isset($user_permissions->flights_suggestions->page_access)) { ?>
                                <li><a href="./flights_suggestions.php" class="loadeffect link-light  <?php if ($url_name == "flights_suggestions") { echo "active"; } ?>"><?= T::flights_suggestions ?></a> </li>
                            <?php } ?> 

                    </ul>
                </div>
            </li>
        <?php } } ?>

    <!--===================================================================================== FLIGHTS -->

    <!--===================================================================================== HOTELS -->

    <?php
        if (
            isset($user_permissions->hotels->page_access) ||
            isset($user_permissions->hotels_settings->page_access) ||
            isset($user_permissions->hotels_suggestions->page_access) 
        ) { if(!empty($hotels_active) && $hotels_active == 1){ ?>
            <li class="mb-0">
                <button 
                    class="text-start btn btn-outline-light btn-toggle  collapsed w-100 gap-3"
                    data-bs-toggle="collapse" data-bs-target="#hotels-collapse"
                    aria-expanded="<?php if 
                    ($url_name == "hotels") {
                        echo "true";
                    } else {
                        echo "false";
                    } ?>">

                    <svg fill="#fff" stroke-linecap="round" version="1.1" stroke-width="4" width="18" height="18" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path stroke="white" stroke-width="1" d="M5 10C3.355469 10 2 11.355469 2 13L2 28.1875C2.003906 28.25 2.015625 28.3125 2.03125 28.375C2.03125 28.386719 2.03125 28.394531 2.03125 28.40625C1.582031 29.113281 1.214844 29.867188 0.9375 30.6875C0.316406 32.519531 0.0507813 34.621094 0 37L0 38C0 38.03125 0 38.0625 0 38.09375L0 50L7 50L7 46C7 45.167969 7.203125 44.734375 7.46875 44.46875C7.734375 44.203125 8.167969 44 9 44L41 44C41.832031 44 42.265625 44.203125 42.53125 44.46875C42.796875 44.734375 43 45.167969 43 46L43 50L50 50L50 38.15625C50.003906 38.105469 50.003906 38.050781 50 38C50 37.65625 50.007813 37.332031 50 37C49.949219 34.621094 49.683594 32.519531 49.0625 30.6875C48.785156 29.875 48.414063 29.136719 47.96875 28.4375C47.988281 28.355469 48 28.273438 48 28.1875L48 13C48 11.355469 46.644531 10 45 10 Z M 5 12L45 12C45.5625 12 46 12.4375 46 13L46 26.15625C45.753906 25.949219 45.492188 25.75 45.21875 25.5625C44.550781 25.101563 43.824219 24.671875 43 24.3125L43 20C43 19.296875 42.539063 18.75 42.03125 18.40625C41.523438 18.0625 40.902344 17.824219 40.125 17.625C38.570313 17.226563 36.386719 17 33.5 17C30.613281 17 28.429688 17.226563 26.875 17.625C26.117188 17.820313 25.5 18.042969 25 18.375C24.5 18.042969 23.882813 17.820313 23.125 17.625C21.570313 17.226563 19.386719 17 16.5 17C13.613281 17 11.429688 17.226563 9.875 17.625C9.097656 17.824219 8.476563 18.0625 7.96875 18.40625C7.460938 18.75 7 19.296875 7 20L7 24.3125C6.175781 24.671875 5.449219 25.101563 4.78125 25.5625C4.507813 25.75 4.246094 25.949219 4 26.15625L4 13C4 12.4375 4.4375 12 5 12 Z M 16.5 19C19.28125 19 21.34375 19.234375 22.625 19.5625C23.265625 19.726563 23.707031 19.925781 23.90625 20.0625C23.988281 20.117188 23.992188 20.125 24 20.125L24 22C17.425781 22.042969 12.558594 22.535156 9 23.625L9 20.125C9.007813 20.125 9.011719 20.117188 9.09375 20.0625C9.292969 19.925781 9.734375 19.726563 10.375 19.5625C11.65625 19.234375 13.71875 19 16.5 19 Z M 33.5 19C36.28125 19 38.34375 19.234375 39.625 19.5625C40.265625 19.726563 40.707031 19.925781 40.90625 20.0625C40.988281 20.117188 40.992188 20.125 41 20.125L41 23.625C37.441406 22.535156 32.574219 22.042969 26 22L26 20.125C26.007813 20.125 26.011719 20.117188 26.09375 20.0625C26.292969 19.925781 26.734375 19.726563 27.375 19.5625C28.65625 19.234375 30.71875 19 33.5 19 Z M 24.8125 24C24.917969 24.015625 25.019531 24.015625 25.125 24C25.15625 24 25.1875 24 25.21875 24C35.226563 24.015625 41.007813 25.0625 44.09375 27.1875C45.648438 28.257813 46.589844 29.585938 47.1875 31.34375C47.707031 32.875 47.917969 34.761719 47.96875 37L2.03125 37C2.082031 34.761719 2.292969 32.875 2.8125 31.34375C3.410156 29.585938 4.351563 28.257813 5.90625 27.1875C8.992188 25.058594 14.785156 24.011719 24.8125 24 Z M 2 39L48 39L48 48L45 48L45 46C45 44.832031 44.703125 43.765625 43.96875 43.03125C43.234375 42.296875 42.167969 42 41 42L9 42C7.832031 42 6.765625 42.296875 6.03125 43.03125C5.296875 43.765625 5 44.832031 5 46L5 48L2 48Z"/></svg>

                   <?= T::hotels ?>
                </button>
                <div class="collapse <?php if ($url_name == "hotels" || $url_name == "hotels_settings" || $url_name == "hotels_suggestions") {
                    echo "show";
                } ?>" id="hotels-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
                        
                            <?php if (isset($user_permissions->hotels->page_access)) { ?>
                                <li><a href="./hotels.php" class="loadeffect link-light  <?php if ($url_name == "hotels") { echo "active"; } ?>"><?= T::hotels ?></a> </li>
                            <?php } ?> 

                            <?php if (isset($user_permissions->hotels_settings->page_access)) { ?>
                                <li><a href="./hotels_settings.php" class="loadeffect link-light  <?php if ($url_name == "hotels_settings") { echo "active"; } ?>"><?= T::hotels.' '.T::settings  ?></a> </li>
                            <?php } ?> 

                            <?php if (isset($user_permissions->hotels_suggestions->page_access)) { ?>
                                <li><a href="./hotels_suggestions.php" class="loadeffect link-light  <?php if ($url_name == "hotels_suggestions") { echo "active"; } ?>"><?= T::hotels.' '.T::suggestions  ?></a> </li>
                            <?php } ?> 
 
                    </ul>
                </div>
            </li>
        <?php } }?>

    <!--===================================================================================== HOTELS -->
    

     <!--===================================================================================== TOURS -->

     <?php
        if (
            isset($user_permissions->tours->page_access) ||
            isset($user_permissions->tours_settings->page_access) ||
            isset($user_permissions->tours_suggestions->page_access) 
        ) { if(!empty($tours_active) && $tours_active == 1){  ?>
            <li class="mb-0">
                <button 
                    class="text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3"
                    data-bs-toggle="collapse" data-bs-target="#tours-collapse"
                    aria-expanded="<?php if 
                    ($url_name == "tours") {
                        echo "true";
                    } else {
                        echo "false";
                    } ?>">

                <svg fill="#fff" width="18" height="18" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                 <path d="M28 7.75h-3.75v-2.75c-0.002-1.794-1.456-3.248-3.25-3.25h-10c-1.794 0.002-3.248 1.456-3.25 3.25v2.75h-3.75c-1.794 0.002-3.248 1.456-3.25 3.25v16c0.002 1.794 1.456 3.248 3.25 3.25h24c1.794-0.001 3.249-1.456 3.25-3.25v-16c-0.002-1.794-1.456-3.248-3.25-3.25h-0zM10.25 5c0.006-0.412 0.338-0.744 0.749-0.75h10.001c0.412 0.006 0.744 0.338 0.75 0.749v2.751h-11.5zM28.75 27c-0.006 0.412-0.338 0.744-0.749 0.75h-24.001c-0.412-0.006-0.744-0.338-0.75-0.749v-16.001c0.006-0.412 0.338-0.744 0.749-0.75h24.001c0.412 0.006 0.744 0.338 0.75 0.749v0.001z"></path>
                </svg>

                <?= T::tours ?>
                </button>
                <div class="collapse <?php if ($url_name == "tours" || $url_name == "tours_settings" || $url_name == "tours_suggestions") {
                    echo "show";
                } ?>" id="tours-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
                        
                            <?php if (isset($user_permissions->tours->page_access)) { ?>
                                <li><a href="./tours.php" class="loadeffect link-light  <?php if ($url_name == "tours") { echo "active"; } ?>"><?= T::tours ?></a> </li>
                            <?php } ?> 

                            <?php if (isset($user_permissions->tours_settings->page_access)) { ?>
                                <li><a href="./tours_settings.php" class="loadeffect link-light  <?php if ($url_name == "tours_settings") { echo "active"; } ?>"><?= T::tours.' '.T::settings  ?></a> </li>
                            <?php } ?> 

                            <?php if (isset($user_permissions->tours_suggestions->page_access)) { ?>
                                <li><a href="./tours_suggestions.php" class="loadeffect link-light  <?php if ($url_name == "tours_suggestions") { echo "active"; } ?>"><?= T::tours.' '.T::suggestions  ?></a> </li>
                            <?php } ?> 
 
                    </ul>
                </div>
            </li>
        <?php } }?>

    <!--===================================================================================== TOURS -->


    <!--===================================================================================== CARS -->

    <?php
        if (
            isset($user_permissions->cars->page_access) ||
            isset($user_permissions->cars_settings->page_access) ||
            isset($user_permissions->cars_suggestions->page_access) 
        ) { if(!empty($cars_active) && $cars_active == 1){ ?>
            <li class="mb-0">
                <button 
                    class="text-start btn btn-outline-light btn-toggle collapsed w-100 gap-3"
                    data-bs-toggle="collapse" data-bs-target="#cars-collapse"
                    aria-expanded="<?php if 
                    ($url_name == "cars") {
                        echo "true";
                    } else {
                        echo "false";
                    } ?>">

                        <!-- <svg width="18" height="18" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.77988 6.77277C6.88549 6.32018 7.28898 6 7.75372 6H16.2463C16.711 6 17.1145 6.32018 17.2201 6.77277L17.7398 9H17H7H6.26019L6.77988 6.77277ZM2 11H2.99963C2.37194 11.8357 2 12.8744 2 14V15C2 16.3062 2.83481 17.4175 4 17.8293V20C4 20.5523 4.44772 21 5 21H6C6.55228 21 7 20.5523 7 20V18H17V20C17 20.5523 17.4477 21 18 21H19C19.5523 21 20 20.5523 20 20V17.8293C21.1652 17.4175 22 16.3062 22 15V14C22 12.8744 21.6281 11.8357 21.0004 11H22C22.5523 11 23 10.5523 23 10C23 9.44772 22.5523 9 22 9H21C20.48 9 20.0527 9.39689 20.0045 9.90427L19.9738 9.77277L19.1678 6.31831C18.851 4.96054 17.6405 4 16.2463 4H7.75372C6.35949 4 5.14901 4.96054 4.8322 6.31831L4.02616 9.77277L3.99548 9.90426C3.94729 9.39689 3.51999 9 3 9H2C1.44772 9 1 9.44772 1 10C1 10.5523 1.44772 11 2 11ZM7 11C5.34315 11 4 12.3431 4 14V15C4 15.5523 4.44772 16 5 16H6H18H19C19.5523 16 20 15.5523 20 15V14C20 12.3431 18.6569 11 17 11H7ZM6 13.5C6 12.6716 6.67157 12 7.5 12C8.32843 12 9 12.6716 9 13.5C9 14.3284 8.32843 15 7.5 15C6.67157 15 6 14.3284 6 13.5ZM16.5 12C15.6716 12 15 12.6716 15 13.5C15 14.3284 15.6716 15 16.5 15C17.3284 15 18 14.3284 18 13.5C18 12.6716 17.3284 12 16.5 12Z" fill=""></path>
                        </svg> -->

                        <svg width="21" height="21" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.77988 6.77277C6.88549 6.32018 7.28898 6 7.75372 6H16.2463C16.711 6 17.1145 6.32018 17.2201 6.77277L17.7398 9H17H7H6.26019L6.77988 6.77277ZM2 11H2.99963C2.37194 11.8357 2 12.8744 2 14V15C2 16.3062 2.83481 17.4175 4 17.8293V20C4 20.5523 4.44772 21 5 21H6C6.55228 21 7 20.5523 7 20V18H17V20C17 20.5523 17.4477 21 18 21H19C19.5523 21 20 20.5523 20 20V17.8293C21.1652 17.4175 22 16.3062 22 15V14C22 12.8744 21.6281 11.8357 21.0004 11H22C22.5523 11 23 10.5523 23 10C23 9.44772 22.5523 9 22 9H21C20.48 9 20.0527 9.39689 20.0045 9.90427L19.9738 9.77277L19.1678 6.31831C18.851 4.96054 17.6405 4 16.2463 4H7.75372C6.35949 4 5.14901 4.96054 4.8322 6.31831L4.02616 9.77277L3.99548 9.90426C3.94729 9.39689 3.51999 9 3 9H2C1.44772 9 1 9.44772 1 10C1 10.5523 1.44772 11 2 11ZM7 11C5.34315 11 4 12.3431 4 14V15C4 15.5523 4.44772 16 5 16H6H18H19C19.5523 16 20 15.5523 20 15V14C20 12.3431 18.6569 11 17 11H7ZM6 13.5C6 12.6716 6.67157 12 7.5 12C8.32843 12 9 12.6716 9 13.5C9 14.3284 8.32843 15 7.5 15C6.67157 15 6 14.3284 6 13.5ZM16.5 12C15.6716 12 15 12.6716 15 13.5C15 14.3284 15.6716 15 16.5 15C17.3284 15 18 14.3284 18 13.5C18 12.6716 17.3284 12 16.5 12Z" fill=""></path>
                        </svg>

                <?= T::cars ?>
                </button>
                <div class="collapse <?php if ($url_name == "cars" || $url_name == "cars_settings" || $url_name == "cars_suggestions") {
                    echo "show";
                } ?>" id="cars-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small p-0">
                        
                            <?php if (isset($user_permissions->cars->page_access)) { ?>
                                <li><a href="./cars.php" class="loadeffect link-light  <?php if ($url_name == "cars") { echo "active"; } ?>"><?= T::cars ?></a> </li>
                            <?php } ?> 

                            <?php if (isset($user_permissions->cars_suggestions->page_access)) { ?>
                                <li><a href="./cars_suggestions.php" class="loadeffect link-light  <?php if ($url_name == "cars_suggestions") { echo "active"; } ?>"><?= T::cars.' '.T::suggestions  ?></a> </li>
                            <?php } ?> 
 
                    </ul>
                </div>
            </li>
        <?php } }?>

    <!--===================================================================================== CARS -->


        <!-- <li class="mb-1">
            <button 
                class="btn btn-toggle align-items-center  collapsed" data-bs-toggle="collapse"
                data-bs-target="#account-collapse" aria-expanded="false">
                Bookings
            </button>
            <div class="collapse" id="account-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="#" class="link-light ">New...</a></li>
                    <li><a href="#" class="link-light ">Profile</a></li>
                    <li><a href="#" class="link-light ">Settings</a></li>
                    <li><a href="#" class="link-light ">Sign out</a></li>
                </ul>
            </div>
        </li> -->

    </ul>
    <hr>
    <div class="dropdown p-2 mb-2 mx-2">
        <a style="font-weight: 400;font-size: 14px;" href="#"
            class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="./assets/img/user.png" alt="" width="24" height="24" class="user_circle me-2">
            <?= $USER_SESSION->backend_user_name ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item loadeffect" href="./dashboard.php"><?= T::dashboard ?></a></li>

            <?php if (isset($user_permissions->settings->page_access)) { ?>
                                <li><a class="dropdown-item loadeffect" href="./settings.php"><?= T::settings ?></a></li>
            <?php } ?>

            <?php if (isset($user_permissions->logs->page_access)) { ?>
                                <li><a class="dropdown-item loadeffect" href="./logs.php"><?= T::logs ?></a></li>
            <?php } ?>

            <?php if (isset($user_permissions->profile->page_access)) { ?>
                                <li><a class="dropdown-item loadeffect" href="./profile.php"><?= T::profile ?></a></li>
            <?php } ?>

            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item loadeffect" href="login-logout.php"><?= T::logout ?></a></li>
        </ul>
    </div>
</header>
<section style="overflow:auto" class="w-100">

<?php if (isset($alert_edit) && $url_name != "dashboard" && $url_name != "transactions") { ?>
<!-- EDIT ALERT -->
<div class="alert alert-warning m-0">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
<?= T::content_editing_role ?>
</div>
<?php } ?>


  <script>

    // POPUP ALERTS MATERIAL STYLE 
    // $.alert({
    // icon: '',
    // theme: 'material',
    // closeIcon: true,
    // animation: 'scale',
    // type: 'orange',
    // title: 'Alert!',
    // content: 'Simple alert!',
    // });
  
  </script>
