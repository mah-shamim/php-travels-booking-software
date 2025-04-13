<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::listings;
include "_header.php";

if(isset($_POST['listing_id'])) { 

if(isset($_POST['featured'])){ $featured = 1; } else { $featured = 0; }
if(isset($_POST['status'])){ $status = 1; } else { $status = 0; }
if(isset($_POST['refundable'])){ $refundable = 1; } else { $refundable = 0; }

$id=(DECODE($_POST['listing_id']));
$params = array( 
    "refundable" => $refundable,
    "status" => $status,
    "featured" => $featured,
    "mapaddress" => $_POST['mapaddress'],
    "latitude" => $_POST['latitude'],
    "longitude" => $_POST['longitude'],
    "currency_id" => $_POST['currency_id'],
    "location_id" => $_POST['location_id'],
    "name" => $_POST['name'],
    "amenities" => json_encode($_POST['amenities']),
    "slug" => $_POST['slug'],
    "desc" => $_POST['desc'],
    "policy" => $_POST['policy'],
    "owned_by" => $_POST['owned_by'],
    "settings_type" => $_POST['settings_type'],
    "stars" => $_POST['stars'],
);
$data = UPDATE('listings',$params,$id);
ALERT_MSG('updated');

// INSERT TO LOGS
$user_id = $USER_SESSION->backend_user_id;    
$log_type = "listing";
$datetime = date("Y-m-d h:i:sa");
$desc = "listing details added - updated";
logs($user_id,$log_type,$datetime,$desc.json_encode($_REQUEST));

REDIRECT('listings.php?all_listings');
}

if(isset($_GET['listing_id'])) {
$params = array("id"=>$_GET['listing_id']);
$data = GET('listings',$params);
if (isset($data[0])){
$listing = $data[0];


// REDIRECT IF LISTING DO NOT BELONG TO USER OR ADMIN CAN VIEW IT ONLY
$seuser = DECODE($_SESSION['phptravels_backend_user']);
$params = array("type_name"=> $seuser->backend_user_type);
$role = GET('users_roles',$params);

if (isset($role[0]->type_name)) {
if (strtolower($role[0]->type_name) == "admin") { } else {
    if ($listing->owned_by != $seuser->backend_user_id) { 
        REDIRECT('listings.php?all_listings'); 
    }
}}

} else {
// REDIRECT IF THERE IS NO LISTING
REDIRECT('./listings.php?all_listings');
}

include "listings_manage.php";
include "_footer.php";
exit;
}

if(isset($_GET['listing'])) { 
        
        // DELETE IF FOUND DRAFT DATA
        $listing = $db->query("SELECT * FROM `listings` WHERE `name` LIKE ''")->fetchAll();
        if (isset($listing[0]['id'])){
            $params = array( "id" => $listing[0]['id']);
            $data = DELETE('listings',$params);
        } 

        if ($_GET['listing'] == $_GET['listing'] && $_GET['listing'] != "addnew"){

            $params = array( 
                "name" => "",
                "listing_type" => $_GET['listing'],
            );

            $data = INSERT('listings',$params);
            $listing = $db->query("SELECT * FROM `listings` WHERE `name` LIKE ''")->fetchAll();
            REDIRECT("./listings.php?listing_id=".$listing[0]['id']);

        }
        
}

// GET DATA
if(isset($_GET['listing'])) { 

// GET DATA FROM API
include "listings_manage.php";
include "_footer.php";
exit;
}

// GET DATA
if(isset($_GET['listings_settings'])) { 
include "listings_settings.php";
include "_footer.php";
exit;
}

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
             <p class="m-0 page_title"><?=T::listings?></p>
         </div>
        <div class="float-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#module_type" class="loading_effect btn btn-dark"><?=T::add?></a>
        </div>
    </div>
</div>

<div class="container mt-3">

<?php 

// DELETE IF FOUND DRAFT DATA
$listing = $db->query("SELECT * FROM `listings` WHERE `name` LIKE ''")->fetchAll();
if (isset($listing[0]['id'])){
$params = array( "id" => $listing[0]['id']);
$data = DELETE('listings',$params);
} 

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('listings');
$xcrud->order_by('id','desc');

$xcrud->column_callback('stars', 'stars');
$xcrud->button('./translations.php?hotels={id}','languages','<i> Translation <svg  style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></i>');
$xcrud->button('./listings.php?listing_id={id}','User','<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></i>');

// $xcrud->relation('location_id','locations','id','city');

$xcrud->unset_title();
$xcrud->unset_add();
$xcrud->unset_edit();
$xcrud->unset_csv();
$xcrud->unset_view();
$xcrud->column_class('thumb_img', 'zoom_img');
// $xcrud->change_type('thumb_img', 'image', true, array('width' => 200, 'path' => '../../uploads/hotels/',
// // 'thumbs'=>array(
// // array('width'=> 50, 'marker'=>'_s'),
// // array('width'=> 100, 'marker'=>'_m'),
// // array('width'=> 500, 'marker'=>'_l'),
// // array('width'=> 1000, 'marker'=>'_xl'),
// // array('width' => 250, 'folder' => 'thumbs' // using 'thumbs' subfolder
// // ))
// ));

$xcrud->column_callback('thumb_img', 'thumb_img');

$seuser = DECODE($_SESSION['phptravels_backend_user']);
$params = array("type_name"=> $seuser->backend_user_type);
$role = GET('users_roles',$params);

// CONDITION IF ADMIN SHOW ALL LISTINGS ELSE SHOW ONLY USER BASED LISTING
if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){} else {
$xcrud->where('owned_by =', DECODE($_SESSION['phptravels_backend_user'])->backend_user_id);
} }

// IF ADMIN SHOW ALL OPTIONS 
if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){
$xcrud->columns('status,featured,thumb_img,name,owned_by,location_id,stars,listing_type');
} else {
$xcrud->columns('thumb_img,name,location_id,stars,listing_type');
} }

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); } else {
$xcrud->column_callback('name', 'name_link');
$xcrud->column_callback('owned_by', 'owned_by');
$xcrud->column_callback('location_id', 'location_id');
$xcrud->column_callback('status', 'create_status_icon');
$xcrud->column_callback('featured', 'featured');
$xcrud->field_callback('status','Enable_Disable');
}

$xcrud->language($USER_SESSION->backend_user_language);
$xcrud->label(array('status' =>  T::status, 'thumb_img' => T::thumb, 'stars' => T::stars, 'listing_type' => T::type ));
$xcrud->column_width('listing_type','60px');
$xcrud->column_width('stars','110px');
$xcrud->column_width('thumb_img','60px');
$xcrud->column_width('featured','5%');
$xcrud->column_width('status','5%');
echo $xcrud->render();

?>

<?php include "_footer.php"; ?>