<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

$title = T::countries;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::countries?></p>
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
$xcrud->table('countries');
$xcrud->order_by('id','desc');
// $xcrud->columns('status,default,country,name,rate,status');
// $xcrud->fields('status,name,country,rate,status');
$xcrud->validation_required('nicename');
$xcrud->validation_required('iso2');
$xcrud->unset_title();
$xcrud->unset_csv();
$xcrud->unset_view();

$xcrud->column_callback('name','country_flag'); 

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


<script>
   $('.auto_update').on('click', function() {
   $('.spinner_loading').fadeIn(250);

    var form = new FormData();
    form.append("id", "");

    var settings = {
        "url": "cron_currencies.php",
        "method": "GET",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };

    $.ajax(settings).done(function(response) {
        // console.log(response);
        // alert('Currencies has been updated');
        location.reload();
        $('.spinner_loading').fadeOut(250);

    });

    });
</script>

<?php include "_footer.php" ?>