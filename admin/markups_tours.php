<?php 

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('markups');
$xcrud->order_by('id','desc');

$xcrud->columns('status,b2c_markup,b2b_markup,location,from_date,to_date,module_id');
$xcrud->fields('status,b2c_markup,b2b_markup,location,from_date,to_date,module_id,type');
$xcrud->relation('module_id','modules','id','name','type="tours"');
$xcrud->relation('user_id','users','user_id','email','user_type="agent"');
$xcrud->relation('location','locations','id','city','status="1"');

$xcrud->field_callback('b2c_markup','markup');
$xcrud->field_callback('b2b_markup','markup');

$xcrud->column_pattern('b2c_markup','{value} %');
$xcrud->column_pattern('b2b_markup','{value} %');

// SPECIFY MODULE
$xcrud->change_type('type','hidden');  
$xcrud->where('type=', "tours");
$xcrud->pass_default('type','tours');

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
// $xcrud->language($USER_SESSION->backend_user_language);

// // REFRESH PAGE
$xcrud->after_insert('refresh');
$xcrud->after_update('refresh');

// $xcrud->column_width('status','5%');
echo $xcrud->render();

?>