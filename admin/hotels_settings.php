<?php

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::hotels.' '.T::settings;
include "_header.php";

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::hotels?> <?=T::settings?></p>
         </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>
<div class="container mt-4 mb-4">
<div class="card">
  <div class="card-body p-5">
   <div class="nav nav-tabs nav-pills nav-justified pb-3" id="nav-tab" role="tablist">
    <a class="nav-link active" id="" data-bs-toggle="tab" href="#nav-hotels_types" role="tab" aria-controls="nav-home" aria-selected="true"><?=T::hotels.' '.T::types?></a>
    <a class="nav-link" id="" data-bs-toggle="tab" href="#nav-hotels_amenities" role="tab" aria-controls="nav-profile" aria-selected="false"><?=T::hotels.' '.T::amenities?></a>
    <a class="nav-link" id="" data-bs-toggle="tab" href="#nav-rooms_types" role="tab" aria-controls="nav-contact" aria-selected="false"><?=T::rooms.' '.T::types?></a>
    <a class="nav-link" id="" data-bs-toggle="tab" href="#nav-rooms_amenities" role="tab" aria-controls="nav-contact" aria-selected="false"><?=T::rooms.' '.T::amenities?></a>
  </div>
<div class="tab-content py-4" id="">
  <div class="tab-pane fade show active" id="nav-hotels_types" role="tabpanel" aria-labelledby="">

    <?php 
    include('./xcrud/xcrud.php');

    function settings($name){
    $xcrud = Xcrud::get_instance();
    $xcrud->table('hotels_settings');
    $xcrud->where('setting_type', $name);
    $xcrud->columns('name');
    $xcrud->change_type('setting_type','hidden'); 
    $xcrud->fields('name,setting_type');
    $xcrud->unset_csv();
    $xcrud->unset_title();
    $xcrud->unset_view();
    $xcrud->pass_default('setting_type',$name);
    echo $xcrud->render();

    }

    settings('hotels_type');
    ?>

  </div>
  <div class="tab-pane fade" id="nav-hotels_amenities" role="tabpanel" aria-labelledby="">
    <?php settings('hotel_amenities'); ?>
  </div>
  <div class="tab-pane fade" id="nav-rooms_types" role="tabpanel" aria-labelledby="">
  <?php settings('rooms_type'); ?>
  </div>
  <div class="tab-pane fade" id="nav-rooms_amenities" role="tabpanel" aria-labelledby="">
  <?php settings('room_amenities'); ?>
  </div>
</div>

  </div>
 </div>
</div>

<style>
  .xcrud-rightside, .xcrud-top-actions {margin-top:0 !important; padding-bottom: 15px;}
  .xcrud-list-container { padding: 0; } 
  .xcrud-list thead { background: #eee}
  table { margin-top: 10px }
</style>

<?php include "_footer.php"; ?>