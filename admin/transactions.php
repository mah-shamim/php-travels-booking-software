<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::transactions;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::transactions?></p>
</div>
<div class="float-end">
<!-- <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning">Back</a> -->
</div>
</div>
</div>

<div class="container mt-3">

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('transactions');
$xcrud->order_by('id','desc');

// CONDITION IF ADMIN SHOW ALL LISTINGS ELSE SHOW ONLY USER BASED LISTING
if (isset($role[0])){ if (strtolower($role[0]->type_name) == "admin" ){} else {
$xcrud->where('user_id =', DECODE($_SESSION['phptravels_backend_user'])->backend_user_id);
} }

$xcrud->relation('currency','currencies','name','name');
$xcrud->relation('payment_gateway','payment_gateways','name','name');
$xcrud->relation('user_id','users','user_id','email');

$xcrud->unset_title();
$xcrud->unset_add();
// $xcrud->unset_view();

$xcrud->change_type('description','textarea'); 
// $xcrud->pass_default('date',date("Y.m.d")); 

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ 
    $xcrud->unset_edit(); 
   
} else {
    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
    $xcrud->column_callback('default', 'MakeDefault');
}

$xcrud->language($USER_SESSION->backend_user_language);

// REFRESH PAGE
$xcrud->after_insert('update_user_wallet');
// $xcrud->after_insert('refresh');

echo $xcrud->render();

?>

<?php include "_footer.php" ?>

<style>
    .form-check { display:none}
</style>