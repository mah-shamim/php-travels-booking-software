<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::languages;
include "_header.php";

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::languages?></p>
        </div>
        <div class="float-end">
            <?php if (isset($permission_add)){ ?>
            <!-- <a href="./cms.php?addpage=1" class="loading_effect btn btn-dark"><?=T::add?></a> -->
            <?php } ?>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4">

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('languages');
$xcrud->order_by('id','desc');
$xcrud->columns('status,country_id,language_code,name,default,type');
$xcrud->fields('status,country_id,language_code,name,type');
$xcrud->button('./translations.php?languages={id}','languages','<i> Translation <svg  style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></i>');

$xcrud->column_callback('default', 'MakeDefault');

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (!isset($permission_edit)){ $xcrud->unset_edit(); } else { }

$xcrud->column_callback('status', 'create_status_icon');
$xcrud->field_callback('status','Enable_Disable');
if (!isset($permission_add)){ $xcrud->unset_add(); }

$xcrud->column_callback('country_id','country_flag');
$xcrud->relation('country_id','countries','iso','name');

$xcrud->label(array('status' =>  T::status, 'country_id' => T::country, 'type' => T::type ));

$xcrud->after_insert('create_lang');
$xcrud->before_remove('remove_lang');

$xcrud->unset_title();
$xcrud->unset_view();
$xcrud->unset_csv();
$xcrud->column_width('language_code','150px');
$xcrud->column_width('default','100px');
$xcrud->column_width('name','150px');
$xcrud->column_width('country_id','100px');
$xcrud->column_width('status','80px');
echo $xcrud->render();

?>

</div>

<?php include "_footer.php"; ?>