<?php 

require_once '_config.php';
auth_check();

// POST MODULES STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $params = array(
    "status" => $_POST['status'],
    );
    
    $id = $_POST['id'];
    UPDATE('payment_gateways',$params,$id);

    // INSERT TO LOGS
    $user_id = $USER_SESSION->backend_user_id;  
    $log_type = "gateway_status";
    $datetime = date("Y-m-d h:i:sa");
    $desc = "payment gateway status updated";
    logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));
    exit;
    
}

$title = T::payment_gateways; 
include "_header.php";

$params = array();
$gateways = GET('payment_gateways',$params);

if (isset($_GET['id'])){
include "payment-gateway.php";
die;
}

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::payment_gateways?></p>
</div>
<div class="float-end">
<a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a>
</div>
</div>
</div>

<div class="container">

<div class="row mt-1 g-3">

<?php 
foreach($gateways as $m) { ?>
<div class="col-md-4 col-lg-6 col-xxl-3 mb-1 modules_<?=$m->name ?>">
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex gap-3 align-items-center">
            <img class="card-quick-link-img" src="../assets/img/gateways/<?=strtolower(str_replace(' ', '_', $m->name))?>.png" style="border-radius: 6px;max-width:80px; max-height: 35px;">
            <div class="card-title text-truncate mb-1" style="text-transform:capitalize"> <strong><?=$m->name ?>  </strong></div>
            </div>

        </div>
        <div class="card-actions p-3 d-flex justify-content-sm-between">

        <?php if (isset($permission_edit)){ ?>
        <a class="loading_effect" href="<?=root?>payment_gateways.php?id=<?=$m->id?>">
        <button class="btn btn-danger btn-sm pull-left" style="text-transform:capitalize;font-weight:100;letter-spacing:0px">
        <svg class="m-1" opacity="0.8" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        <?=T::settings?></button>
        </a>
       

        <label style="margin-right: -50px;" class="form-check-label" for="module_<?=$m->id?>"><?=T::status?></label>
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
      <input <?=$check?> style="width: 40px; height: 20px;cursor:pointer" class="form-check-input" data-status="<?=$m->status?>" data-value="<?=$m->id ?>" data-item="<?=$m->name ?>" id="checkedbox" type="checkbox">
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
    "url": "./payment_gateways.php",
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
        vt.success("Status updated successfully",{
            title:"Status Updated",
            position: "top-center",
            callback: function (){ //
        } })

    });

  });

</script>

<?php include "_footer.php" ?>