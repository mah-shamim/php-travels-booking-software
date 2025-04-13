<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::newsletter;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::newsletter?></p>
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
$xcrud->table('newsletter');
$xcrud->order_by('id','desc');
$xcrud->columns('name,email,created_at');
// $xcrud->fields('status,name,country,rate,status');
// $xcrud->validation_required('name');
// $xcrud->validation_required('country');
// $xcrud->validation_required('rate');

$xcrud->unset_title();
// $xcrud->unset_csv();
$xcrud->unset_view();

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ 
    $xcrud->unset_edit(); 
   
} else {

    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
    $xcrud->column_callback('default', 'MakeDefault');
    
}

$xcrud->column_width('name','200px');
$xcrud->column_width('email','400px');
$xcrud->language($USER_SESSION->backend_user_language);

// REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

echo $xcrud->render();

?>

<?php include "_footer.php" ?>