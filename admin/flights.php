<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::flights;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::flights?></p>
</div>
<div class="float-end">
<a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning">  <?=T::back?></a>
</div>
</div>
</div>

<div class="container mt-3">

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('flights');
$xcrud->order_by('id','desc');
//$xcrud->relation('airline','flights_airlines','code','name');
$xcrud->relation('airline','flights_airlines','iata','name');
$xcrud->relation('from_airport','flights_airports','code','code');
$xcrud->relation('to_airport','flights_airports','code','code');

$xcrud->label(array('adult_seat price' =>  "adult_price", 'child_seat_price' =>  "child price", 'infant_seat_price' =>  "infant price" ));

$xcrud->pass_default('adult_seat_price',0);
$xcrud->pass_default('child_seat_price',0);
$xcrud->pass_default('infant_seat_price',0);

$xcrud->unset_title();
$xcrud->unset_csv();
$xcrud->unset_view();

$rooms_options = $xcrud->nested_table('id','id','flights_routes','flights_id'); 
$rooms_options->change_type('flights_id', 'hidden');
$rooms_options->relation('from_airport','flights_airports','code','code');
$rooms_options->label('from_airport','airport');
//$rooms_options->relation('to_airport','flights_airports','code','code');
$rooms_options->change_type('departure_time', 'time');

$seuser = DECODE($_SESSION['phptravels_backend_user']);
$params = array("type_name"=> $seuser->backend_user_type);
$role = GET('users_roles',$params);

// IF ADMIN SHOW ALL OPTIONS 
if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){
    $xcrud->column_callback('user_id', 'user_id');

    $xcrud->relation('user_id','users','email','email','user_type="supplier"');
    $xcrud->columns('status,user_id,airline,from_airport,to_airport,adult_seat_price,child_seat_price,infant_seat_price,type');
    $xcrud->fields('status,user_id,airline,from_airport,to_airport,adult_seat_price,child_seat_price,infant_seat_price,duration,departure_time,arrival_time,baggage,cabin_baggage,type,refundable');
} else {
    $xcrud->columns('airline,from_airport,to_airport,adult_seat_price,child_seat_price,infant_seat_price,type');
    $xcrud->fields('user_id,airline,from_airport,to_airport,adult_seat_price,child_seat_price,infant_seat_price,duration,departure_time,arrival_time,baggage,cabin_baggage,type,refundable');
    
    $xcrud->pass_var('user_id', $seuser->backend_user_email);

    // CONDITION IF ADMIN SHOW ALL LISTINGS ELSE SHOW ONLY USER BASED LISTING
    $xcrud->where('user_id =', $seuser->backend_user_email);
    $xcrud->change_type('user_id','hidden');

} }

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); 
} else {
    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
}

$xcrud->column_width('status','100px');
$xcrud->language($USER_SESSION->backend_user_language);

$xcrud->field_callback('refundable','Enable_Disable');

// REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

echo $xcrud->render();

?>

<?php include "_footer.php" ?>