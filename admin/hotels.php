<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::hotels;
include "_header.php";

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
             <p class="m-0 page_title"><?=T::hotels?></p>
         </div>
        <div class="float-end">
        <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#module_type" class="loading_effect btn btn-dark"><?=T::add?></a> -->
        </div>
    </div>
</div>

<div class="container mt-3">

<?php 

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('hotels');
$xcrud->default_tab('Hotel Details');

$xcrud->order_by('id','desc');

$xcrud->column_callback('stars', 'stars');

// $xcrud->button('./translations.php?hotels={id}','languages','<i> Translation <svg  style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></i>');
// $xcrud->button('./listings.php?listing_id={id}','User','<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></i>');

$xcrud->relation('location','locations','city','city');
$xcrud->relation('user_id','users','user_id','email','user_type="supplier"');
$xcrud->relation('currency','currencies','name','name','status=1');

$xcrud->unset_title();
$xcrud->unset_csv();
$xcrud->unset_view();
$xcrud->column_class('img', 'zoom_img');
$xcrud->change_type('img', 'image', true, array('width' => 200, 'path' => '../../uploads/',
// $xcrud->unset_add();
// $xcrud->unset_edit();
// 'thumbs'=>array(
// array('width'=> 50, 'marker'=>'_s'),
// array('width'=> 100, 'marker'=>'_m'),
// array('width'=> 500, 'marker'=>'_l'),
// array('width'=> 1000, 'marker'=>'_xl'),
// array('width' => 250, 'folder' => 'thumbs' // using 'thumbs' subfolder
// ))
));

// $xcrud->column_callback('thumb_img', 'thumb_img');
$xcrud->change_type('location_cords','point','39.909736,-6.679687',
array(
'text'=>'Your are here',
// 'search_text'=>'dubai',
'search'=>true,
'coords'=>true,
));

$xcrud->change_type('starts','select','1','1,2,3,4,5');
$xcrud->change_type('rating','select','1','0,1,2,3,4,5');

$seuser = DECODE($_SESSION['phptravels_backend_user']);
$params = array("type_name"=> $seuser->backend_user_type);
$role = GET('users_roles',$params);

// CONDITION IF ADMIN SHOW ALL LISTINGS ELSE SHOW ONLY USER BASED LISTING
if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){} else {
$xcrud->where('user_id =', DECODE($_SESSION['phptravels_backend_user'])->backend_user_id);
} }

// IF ADMIN SHOW ALL OPTIONS 
if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){
$xcrud->columns('status,featured,img,name,user_id,location,stars');
} else {
$xcrud->columns('img,name,location,stars');
} }

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); } else {
$xcrud->column_callback('user_id', 'user_id');
$xcrud->column_callback('location', 'location_id');
$xcrud->column_callback('status', 'create_status_icon');
$xcrud->column_callback('featured', 'featured');
$xcrud->field_callback('status','Enable_Disable');
$xcrud->field_callback('refundable','Yes_No');
$xcrud->field_callback('featured','Yes_No');
}

$xcrud->column_width('stars','110px');
$xcrud->column_width('img','60px');
$xcrud->column_width('featured','5%');
$xcrud->column_width('status','5%');

// REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

$images = $xcrud->nested_table('Images','id','hotels_images','hotel_id');
$images->columns('img');
$images->fields('img');
$images->column_class('img', 'zoom_img');
$images->change_type('img', 'image', true, array('width' => 200, 'path' => '../../uploads/',));

$images->change_type('hotel_id','hidden');

// ROOMS
$rooms = $xcrud->nested_table('Rooms','id','hotels_rooms','hotel_id');
$rooms->columns('thumb_img,room_type_id');
$rooms->fields('status,thumb_img,room_type_id');
$rooms->field_callback('status','Enable_Disable');
$rooms->relation('room_type_id','hotels_settings','id','name','setting_type = "rooms_type"');
$rooms->change_type('room_adults','select','1','1,2,3,4,5,6,7,8,9');
$rooms->change_type('room_children','select','0','0,1,2,3,4,5,6,7,8,9');
$rooms->column_class('thumb_img', 'zoom_img');
$rooms->change_type('thumb_img', 'image', true, array('width' => 200, 'path' => '../../uploads/',));
$rooms->column_callback('status', 'create_status_icon');
$rooms->default_tab('Hotel Room');

// ROOM OPTIONS
$rooms_options = $rooms->nested_table('Options','id','hotels_rooms_options','room_id'); 
$rooms_options->field_callback('breakfast','Yes_No');
$rooms_options->field_callback('cancellation','Yes_No');
$rooms_options->change_type('adults','select','1','1,2,3,4,5,6,7,8,9');
$rooms_options->change_type('childs','select','0','0,1,2,3,4,5,6,7,8,9');
$rooms_options->change_type('quantity','select','0','1,2,3,4,5,6,7,8,9,11,12,13,14,15,16,17,18,19,20');
$rooms_options->change_type('room_id','hidden');

$seuser = DECODE($_SESSION['phptravels_backend_user']);
$params = array("type_name"=> $seuser->backend_user_type);
$role = GET('users_roles',$params);

if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){
    $xcrud->relation('user_id','users','user_id','email','user_type="supplier"');
    $xcrud->columns('status,featured,img,name,user_id,location,stars');
    $xcrud->fields('status,name,featured,img,checkin,checkout,currency,user_id,refundable,stars,rating,hotel_amenities,desc,policy,cancellation,booking_age_requirement', false, 'Hotel Details');

} else {
   
    $xcrud->columns('img,name,location,stars');
    $xcrud->fields('name,img,checkin,checkout,currency,refundable,stars,rating,hotel_amenities,desc,policy,cancellation,booking_age_requirement', false, 'Hotel Details');

    $xcrud->pass_var('user_id', $seuser->backend_user_id);

    // CONDITION IF ADMIN SHOW ALL LISTINGS ELSE SHOW ONLY USER BASED LISTING
    $xcrud->where('user_id=', $seuser->backend_user_id);
    $xcrud->change_type('user_id','hidden');

} }

//$xcrud->fk_relation('hotel_amenities','id','hotels_amenties_fk','hotel_id','amenity_id','hotels_settings','id',array('name'),'setting_type');

$xcrud->fk_relation('hotel_amenities', 'id', 'hotels_amenties_fk', 'hotel_id', 'amenity_id', 'hotels_settings', 'id', array('name'), 'setting_type = "hotel_amenities"' );

$translation = $xcrud->nested_table('Translations','id','hotels_translations','hotel_id');
$translation->columns('name,desc,policy,language_id');
$translation->fields('name,desc,policy,language_id');
$translation->column_name('language_id','Languages');
$translation->relation('language_id','languages','id', 'name');
$translation->field_callback('language_id','checklanguage');
$translation->unset_add();
// $translation->relation('room_type_id','hotels_settings','id','name','setting_type = "rooms_type"');

//$translation->fk_relation('hotels_translations','id','hotels_translations_rel','hotel_id','language_id','languages','id',array('name'));

// $rooms->fields('status,thumb_img,room_type_id');
// $rooms->field_callback('status','Enable_Disable');
// $rooms->relation('room_type_id','hotels_settings','id','name','setting_type = "rooms_type"');
// $rooms->change_type('room_adults','select','1','1,2,3,4,5,6,7,8,9');
// $rooms->change_type('room_children','select','0','0,1,2,3,4,5,6,7,8,9');
// $rooms->column_class('thumb_img', 'zoom_img');
// $rooms->change_type('thumb_img', 'image', true, array('width' => 200, 'path' => '../../uploads/',));
// $rooms->column_callback('status', 'create_status_icon');
// $rooms->default_tab('Hotel Room');

$xcrud->fields('location,address,location_cords', false, 'Location');
$xcrud->fields('hotel_email,hotel_website,hotel_phone', false, 'Contact');

// $xcrud->fields('id', false, 'Translation');

echo $xcrud->render();

?>

<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvPooGV84U2zlu--JO8IQQvKDakc_VJ6k&libraries=places&callback=initAutocomplete"
async defer></script>

<script>
  $('.xcrud-tabs .menu .item').tab('change tab','tab1.php');
</script>

<?php include "_footer.php"; ?>