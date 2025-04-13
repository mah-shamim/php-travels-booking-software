<?php 

require_once '_config.php';
auth_check();

// POST MODULES STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $params = array(
    "status" => $_POST['status'],
    );
    
    $id = $_POST['id'];
    UPDATE('modules',$params,$id);

     // INSERT TO LOGS
     $user_id = $USER_SESSION->backend_user_id;  
     $log_type = "module_status";
     $datetime = date("Y-m-d h:i:sa");
     $desc = "module status updated";
     logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));
     exit;
  
}

$title = T::modules; 
include "_header.php";

$params = array();
$modules = GET('modules',$params);

if (isset($_GET['id'])){
include "module.php";
die;
}

?>
<script src="./assets/js/sortable.js"></script>

<div class="page_head">

    <div class="d-flex justify-content-between align-items-center">
        <p class=" py-0 mb-0 pt-2" style="margin-top:-10px"><?=T::modules?></p>
        <div class=" gap-2 d-flex">
            <div class="btn btn-outline-dark module_all"><?=T::all?></div>
            <div class="btn btn-outline-dark module_flights"><?=T::flights?></div>
            <div class="btn btn-outline-dark module_hotels"><?=T::hotels?></div>
            <div class="btn btn-outline-dark module_tours"><?=T::tours?></div>
            <div class="btn btn-outline-dark module_cars"><?=T::cars?></div>
            <!-- <div class="btn btn-outline-dark module_visa"><?=T::visa?></div> -->
        </div>
    </div>

</div>

<div class="container">


<table class="table w-100 mt-2 bg-white">
    <thead>
        <tr>
            <th class="text-center p-2 py-3"></th>
            <th class="text-center p-2 py-3"><?=T::images?></th>
            <th class="text-center p-2 py-3"><?=T::color?></th>
            <th class="p-2 py-3"><?=T::name?></th>
            <th class="p-2 py-3"><?=T::status?></th>
            <th class="p-2 py-3"><?=T::settings?></th>
        </tr>
    </thead>

    <tbody id="SORT">
        <?php 
        
        $keys = array_column($modules, 'order');
        array_multisort($keys, SORT_ASC, $modules);

        foreach($modules as $i => $m) {
          if($m->active==1){
        ?>

        <tr class="modules_sort modules_<?=$m->name ?> type_<?=$m->type ?>" data-order="<?=$i+1?>" data-name="<?=$m->name ?>" data-module_id="<?=$m->id ?>">

        <th style="width: 50px;">
        <svg style="cursor:hand" class="handle mx-3" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5.2 9l-3 3 3 3M9 5.2l3-3 3 3M15 18.9l-3 3-3-3M18.9 9l3 3-3 3M3.3 12h17.4M12 3.2v17.6"/></svg>
        </th>

        <th style="width: 120px;" class="max-auto">
        <div style="">
        <img class="card-quick-link-img mx-auto d-flex" src="./assets/img/modules/<?=$m->name?>.png" style="border-radius: 6px;max-width:35px; margin-bottom: -10px; ">
        </div>
        </th>

        <th style="width: 50px;">
        <div data-bs-toggle="tooltip" data-bs-placement="top" title="" style="background: <?=$m->module_color?>; width: 15px; height: 15px; position: static; border-radius: 12px; z-index: 99; margin-top: -8px;" data-bs-original-title="Module Color" aria-label="Module Color"></div>
        </th>
        
        <th class="text-capitalize" style="width: 220px;">
        <?=$m->name ?> <small class="fw-light mx-1" style="font-size:13px;color:#939cc2"><?=$m->type ?></small>
        </th>

        <th style="width: 120px;">

        <?php if (isset($permission_edit)){ ?>

        <!-- <label style="margin-right: 0px;" class="form-check-label" for="module_<?=$m->id?>"><?=T::status?></label> -->
        <label class="ellipsis pull-right">

      <?php

        // CONDITION TO CHECK FOR STATUS
        if ($m->status == 1) {
            $check = "checked=''";
        } else {
            $check = "";
        }

      ?>

      <div class="form-check form-switch">
      <label class="form-check-label" for="module_<?=$m->id ?>"></label>
      <input <?=$check?> style="width: 40px; height: 20px;cursor:pointer" class="form-check-input" data-status="<?=$m->status?>" data-value="<?=$m->id?>" data-item="<?=$m->name?>" id="checkedbox" type="checkbox">
      </div>
      <?php } ?>

        </label>

        </th>       

        <th>

        <a class="loading_effect" href="<?=root?>modules.php?id=<?=$m->id?>">
        <button class="btn btn-danger btn-sm pull-left mdc-ripple-upgraded" style="text-transform:capitalize;font-weight:100;letter-spacing:0px">
        <svg class="m-1" opacity="0.8" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        <?=T::settings?></button>
        </a>
        </th>
        
        </tr>
        <?php } } ?>
    </tbody>
</table>

<div class="row mt-1 g-3 d-none">

<?php 
foreach($modules as $m) { ?>
<div class="col-md-4 col-lg-6 col-xxl-3 mb-1 modules_<?=$m->name ?> type_<?=$m->type ?>">
    <div class="card">
        <div class="card-body p-3 bg-light">
            <div class="d-flex gap-3 align-items-center">
            <img class="card-quick-link-img" src="./assets/img/modules/<?=$m->name?>.png" style="border-radius: 6px;max-width:35px">
            <div class="card-title text-truncate mb-1" style="text-transform:capitalize"> <strong><?=$m->name ?>  <?php if ($m->name !== $m->type) { echo $m->type; } ?> </strong></div>
            </div>
            
            <!-- <p class="card-text" style="line-height: 15px;"><small>To configure or setup credentials click on settings</small></p> -->
        </div>

        <div class="card-actions p-3 d-flex justify-content-sm-between">

        <span data-bs-toggle="tooltip" data-bs-placement="top" title="" style="background:<?=$m->module_color?>;width: 15px; height: 15px; position: absolute; z-index: 1; top: 24px; right: 28px; border-radius: 12px;" data-bs-original-title="Module Color" aria-label="Module Color"></span>

        <?php if (isset($permission_edit)){ ?>
        <a class="loading_effect" href="<?=root?>modules.php?id=<?=$m->id?>">
        <button class="btn btn-danger btn-sm pull-left mdc-ripple-upgraded" style="text-transform:capitalize;font-weight:100;letter-spacing:0px">
        <svg class="m-1" opacity="0.8" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        <?=T::settings?></button>
        </a>
        <?php } ?>

        <?php if (isset($permission_edit)){ ?>

        <label style="margin-right: 0px;" class="form-check-label" for="module_<?=$m->id?>"><?=T::status?></label>
        <label class="ellipsis pull-right">

      <?php

        // CONDITION TO CHECK FOR STATUS
        if ($m->status == 1) {
            $check = "checked=''";
        } else {
            $check = "";
        }

      ?>

      <div class="form-check form-switch">
      <label class="form-check-label" for="module_<?=$m->id ?>"></label>
      <input <?=$check?> style="width: 40px; height: 20px;cursor:pointer" class="form-check-input" data-status="<?=$m->status?>" data-value="<?=$m->id?>" data-item="<?=$m->name?>" id="checkedbox" type="checkbox">
      </div>
      <?php } ?>

        </label>
        </div>
    </div>
</div>
<?php } ?>

</div>
</div>

<script>
var sorting = document.getElementById('SORT');

new Sortable(sorting, {
    handle: '.handle', // handle's class
    animation: 250,
    ghostClass: 'bg-light',

    onEnd: function(e) {
        
        $('#SORT tr').each(function (i) {
        var numbering = i + 1;
        $(this).attr('data-order', numbering);

                var order_id = $(this).attr("data-order");
                var module_id = $(this).attr("data-module_id");

                var form = new FormData();
                form.append("order_id", order_id);
                form.append("module_id", module_id);
                form.append("module_order", "module_order");

                var settings = {
                "url": "_post.php",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
                };

                $.ajax(settings).done(function (response) {
                console.log(response);
                });

        });


         // ALERT POPUP MESSAGE
         vt.success("Module status updated successfully",{
            title:"Module Updated",
            position: "top-center",
            callback: function (){ //
        } })

    }
});
</script>

<script>

function showallmodules(){
    $('.type_flights').fadeIn(0);
    $('.type_hotels').fadeIn(0);
    $('.type_tours').fadeIn(0);
    $('.type_cars').fadeIn(0);
    $('.type_visa').fadeIn(0);
}

// FILTER MODULES FUNCTION
$('.module_all').on('click', function() {
    showallmodules()
})

$('.module_flights').on('click', function() {
    showallmodules()
    $('.type_hotels').fadeOut(0);
    $('.type_tours').fadeOut(0);
    $('.type_cars').fadeOut(0);
    $('.type_visa').fadeOut(0);
})

$('.module_hotels').on('click', function() {
    showallmodules()
    $('.type_flights').fadeOut(0);
    $('.type_tours').fadeOut(0);
    $('.type_cars').fadeOut(0);
    $('.type_visa').fadeOut(0);
})

$('.module_tours').on('click', function() {
    showallmodules()
    $('.type_flights').fadeOut(0);
    $('.type_hotels').fadeOut(0);
    $('.type_cars').fadeOut(0);
    $('.type_visa').fadeOut(0);
})

$('.module_cars').on('click', function() {
    showallmodules()
    $('.type_flights').fadeOut(0);
    $('.type_hotels').fadeOut(0);
    $('.type_tours').fadeOut(0);
    $('.type_visa').fadeOut(0);
})

$('.module_visa').on('click', function() {
    showallmodules()
    $('.type_flights').fadeOut(0);
    $('.type_hotels').fadeOut(0);
    $('.type_tours').fadeOut(0);
    $('.type_cars').fadeOut(0);
})

// UPDATE STATUS OF MODULE ONCLICK
$('[id=checkedbox]').on('click', function() {

    var status = $(this).data("status");
    var id = $(this).data("value");
    var item = $(this).data("item");

    var isChecked = this.checked;

    // CONDITION TO CHECK THE STATUS
    if (isChecked == true) { var checks = 1 } else { var checks = 0 }

    var form = new FormData();
    form.append("id", id);
    form.append("status", checks);

    var settings = {
    "url": "./modules.php",
    "method": "POST",
    "timeout": 0,
    "processData": false,
    "mimeType": "multipart/form-data",
    "contentType": false,
    "data": form
    };

    $.ajax(settings).done(function (response) {
    console.log(response);

        // ALERT POPUP MESSAGE
        vt.success("Module status updated successfully",{
            title:"Module Updated",
            position: "top-center",
            callback: function (){ //
        } })

    });

  });

</script>

<style>
    .type_visa{display:none}
</style>

<?php include "_footer.php" ?>