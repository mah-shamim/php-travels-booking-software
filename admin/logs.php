<?php 
use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::logs;
include "_header.php";
?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::logs?></p>
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
$xcrud->table('logs');
$xcrud->order_by('id','desc');
$xcrud->where('user_id', $USER_SESSION->backend_user_id);
$xcrud->columns('user_ip,type,datetime,description');
$xcrud->unset_title();
$xcrud->unset_csv();
$xcrud->unset_add();
$xcrud->unset_edit();
// $xcrud->unset_view();

// REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

$xcrud->language($USER_SESSION->backend_user_language);
$xcrud->label(array('user_ip' =>  T::user_ip, 'type' => T::type, 'datetime' => T::date_time, 'description' => T::description ));

echo $xcrud->render();
?>

<?php include "_footer.php" ?>