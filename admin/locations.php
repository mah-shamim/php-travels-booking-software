<?php 
use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::locations;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::locations?></p>
</div>
<div class="float-end">
<!-- <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a> -->
</div>
</div>
</div>

<div class="container mt-3">

<?php 

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('locations');
$xcrud->order_by('id','desc');
$xcrud->field_callback('status','Enable_Disable');
$xcrud->relation('country','locations','country','country');

// $xcrud->relation('country_code','countries','iso','iso');
// $xcrud->relation('country','locations','country','country','locations.status = "1"');

$xcrud->field_callback('status','Enable_Disable');
$xcrud->column_callback('status', 'create_status_icon');

$xcrud->columns('status,country_code,city,country');
$xcrud->fields('status,city,country,latitude,longitude');

$xcrud->column_callback('country_code','country_flag');

// FUNCTIONS
$xcrud->after_insert('country_code');
$xcrud->after_update('country_code');

$xcrud->unset_title();
$xcrud->unset_csv();
$xcrud->unset_view();
// $xcrud->unset_add();
// $xcrud->unset_edit();

$xcrud->language($USER_SESSION->backend_user_language);

// REFRESH PAGE
$xcrud->column_width('city','200px');
$xcrud->column_width('country_code','150px');
$xcrud->column_width('status','5%');

$xcrud->label(array('status' =>  T::status, 'country_code' => T::country, 'city' => T::city, 'country' => T::country ));

echo $xcrud->render();
?>

<?php include "_footer.php" ?>