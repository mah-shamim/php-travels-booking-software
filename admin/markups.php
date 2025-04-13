<?php 

require_once '_config.php';
auth_check();

$title = T::markups; 
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?= T::markups ?></p>
</div>
<div class="float-end">
<!-- <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a> -->
</div>
</div>
</div>

<div class="container mt-3">

<?php 
if ($_GET['module'] == "hotels" || $_GET['module'] == "flights" || $_GET['module'] == "tours" || $_GET['module'] == "cars" || $_GET['module'] == "visa") {

if ($_GET['module'] == "hotels"){ include "markups_hotels.php"; }
if ($_GET['module'] == "flights"){ include "markups_flights.php"; }
if ($_GET['module'] == "tours"){ include "markups_tours.php"; }
if ($_GET['module'] == "cars"){ include "markups_cars.php"; }
if ($_GET['module'] == "visa"){ include "markups_visa.php"; }

} elseif ($_GET['module'] == "all") {

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('markups');
$xcrud->order_by('id','desc');

$xcrud->columns('status,b2c_markup,b2b_markup,user_markup,location,origin,destination,from_date,to_date,module_id,type,user_id');
$xcrud->fields('status,b2c_markup,b2b_markup,user_markup,location,origin,destination,from_date,to_date,module_id,type,user_id');
$xcrud->relation('module_id','modules','id','name');
$xcrud->relation('user_id','users','user_id','email','user_type="agent"');
$xcrud->relation('location','locations','id','city','status="1"');
$xcrud->relation('origin','flights_airports','id','code','status="1"');
$xcrud->relation('destination','flights_airports','id','code','status="1"');

$xcrud->field_callback('user_markup','markup');
$xcrud->field_callback('b2c_markup','markup');
$xcrud->field_callback('b2b_markup','markup');

$xcrud->column_pattern('user_markup','{value} %');
$xcrud->column_pattern('b2c_markup','{value} %');
$xcrud->column_pattern('b2b_markup','{value} %');

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_add)){ $xcrud->unset_add(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); }
if (!isset($permission_edit)){ 

} else {
    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
}

$xcrud->unset_title();
$xcrud->unset_view();
$xcrud->unset_csv();

// // REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

echo $xcrud->render();

} elseif ($_GET['module'] == "users") {

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('markups');
$xcrud->order_by('id','desc');

$xcrud->columns('status,user_markup,user_id,type');
$xcrud->fields('status,user_markup,user_id,type');
$xcrud->relation('module_id','modules','id','name');
$xcrud->relation('user_id','users','user_id','email','user_type="agent"');

$xcrud->field_callback('user_markup','markup');
$xcrud->column_pattern('user_markup','{value} %');

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_add)){ $xcrud->unset_add(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); }
if (!isset($permission_edit)){ 

} else {
    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
}

$xcrud->unset_title();
$xcrud->unset_view();
$xcrud->unset_csv();

// // REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

echo $xcrud->render();

}

?>

<?php include "_footer.php"; ?>