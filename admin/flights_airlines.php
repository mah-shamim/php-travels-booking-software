<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::airlines;
include "_header.php";

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::airlines?></p>
        </div>
        <div class="float-end">
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('flights_airlines');
$xcrud->order_by('id','desc');
$xcrud->columns('status,iata,name,country');
$xcrud->fields('status,iata,name,country');

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); } else { }

$xcrud->column_callback('status', 'create_status_icon');
$xcrud->field_callback('status','Enable_Disable');
if (!isset($permission_add)){ $xcrud->unset_add(); }

$xcrud->relation('country','countries','nicename','nicename');
// $xcrud->relation('city','locations','city','city');
// $xcrud->label(array('status' =>  T::status, 'country_id' => T::country, 'type' => T::type ));

$xcrud->after_insert('create_lang');
$xcrud->before_remove('remove_lang');

$xcrud->unset_title();
$xcrud->unset_view();
$xcrud->unset_csv();
$xcrud->column_width('iata','60px');
$xcrud->column_width('name','260px');
$xcrud->column_width('country','250px');
$xcrud->column_width('status','5%');
echo $xcrud->render();

?>

</div>

<?php include "_footer.php"; ?>