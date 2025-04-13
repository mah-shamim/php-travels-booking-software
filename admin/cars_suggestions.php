<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::cars.' '.T::suggestions;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::cars.' '.T::suggestions?></p>
</div>
<div class="float-end">
<!-- <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning">  Back</a> -->
</div>
</div>
</div>

<div class="container mt-3">

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('cars_suggestions');
$xcrud->order_by('id','desc');
$xcrud->relation('city','locations','city','city');
$xcrud->unset_title();
$xcrud->unset_csv();
$xcrud->unset_view();

// $xcrud->column_callback('country','country_flag'); 

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ 
    $xcrud->unset_edit(); 
   
} else {

    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
    $xcrud->column_callback('default', 'MakeDefault');
    
}

$xcrud->column_width('default','100px');
$xcrud->column_width('name','100px');
$xcrud->column_width('country','100px');
$xcrud->column_width('status','100px');
$xcrud->language($USER_SESSION->backend_user_language);

// REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

echo $xcrud->render();

?>

<?php include "_footer.php" ?>