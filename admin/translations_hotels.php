<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

include "_config.php";

// dd(json_encode($_REQUEST));

// ADD DATA
if (isset($_POST['add_new'])){
    
    $params = array( 
    "data" => json_encode($_REQUEST),
    "module" => $_POST['module'],
    "item_id" => $_POST['item_id'],
    );

    $data = INSERT('translations',$params);

    ALERT_MSG('updated');
    REDIRECT('listings.php');
    exit;
}

}

$params = array( "id"=> $_GET['hotels']);
$hotel = GET('listings',$params)[0];

$params = array( "item_id"=> $_GET['hotels']);
$trans = GET('translations',$params)[0];

// dd(json_decode($trans->data)->name_sa);

?>


<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::hotel?> <?=T::translations?></p>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<form action="translations_hotels.php" method="post">

<?php 

include "translations_params.php";

$params = array( "id"=> $_GET['hotels']);
$hotel = GET('listings',$params)[0];
 
$params = array();
$languages = GET('languages',$params);
?>

<div class="container mt-4 mb-5">
<div class="card">
<div class="card-body p-4">

<?php foreach($languages as $lang => $i){ ?>
 
    <div class="card mt-3 <?php if($i->default == 1){ echo "d-none"; } ?>">
    <div class="card-header">
    <img src="./assets/img/flags/<?=strtolower($i->country_id)?>.svg"style="max-width:20px;">
    <strong class="mx-2"><?=$i->name?></strong>   
    </div>
    <div class="card-body">

    <div class="form-floating mb-2">
    <textarea class="form-control" placeholder=" " id="" style="height: 100px" name="name_<?=strtolower($i->country_id)?>" value=""></textarea>
    <label for=""><?=T::name?></label>
    </div>

    <div class="form-floating mb-2">
    <textarea class="form-control" placeholder=" " id="" style="height: 100px" name="desc_<?=strtolower($i->country_id)?>" value=""></textarea>
    <label for=""><?=T::description?></label>
    </div>

    <div class="form-floating mb-2">
    <textarea class="form-control" placeholder=" " id="" style="height: 100px" name="policy_<?=strtolower($i->country_id)?>" value=""></textarea>
    <label for=""><?=T::policy?></label>
    </div>

    <div class="form-floating">
    <textarea class="form-control" placeholder=" " id="" style="height: 100px" name="address_<?=strtolower($i->country_id)?>" value=""></textarea>
    <label for=""><?=T::address?></label>
    </div>

</div>
</div>
 
<script>
  $("[name='name_<?=strtolower($i->country_id)?>']").val('qasim')
</script>

<?php } ?>

</div>

<div class="card-footer text-muted" style="position: fixed; bottom: 0; width: 100%;background: #e9ecef;">
<div class="mx-4 my-3">
<button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
</div>
</div>

</div>

</div>
<input type="hidden" name="add_new" value="add_new">
<input type="hidden" name="module" value="hotels">
<input type="hidden" name="item_id" value="<?=$_GET['hotels']?>">
</form>

<div class="mt-5" style="margin-bottom:100px;"></div>