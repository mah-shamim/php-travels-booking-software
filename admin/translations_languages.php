<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

include "_config.php";
include "translations_params.php";

$items = array();
$la = array($_REQUEST['trans']);

$da = [];
foreach($_REQUEST['trans'] as $index=>$key){
$da[$_REQUEST['words'][$index]] = $key;
}

$array = array($_REQUEST['trans']);
file_put_contents("../lang/".$_REQUEST['lang'].".json", print_r(json_encode($da), true));

ALERT_MSG('updated');
REDIRECT('languages.php');
}
?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::languages?> <?=T::translations?></p>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<form action="translations_languages.php" method="post">

<?php 

include "translations_params.php";

if(isset($_GET['languages'])){
$params = array( "id"=> $_GET['languages']);
$language = GET('languages',$params)[0];
$current_lang = strtolower($language->country_id);
$langs = json_decode(file_get_contents("../lang/".$current_lang.".json"));
}

?>

<div class="container mt-4 mb-5">
<div class="card">
<div class="card-body p-5">

<div class="row mb-3 g-4">
<input type="hidden" name="lang" value="<?=$current_lang?>">
<?php foreach($lang as $l => $i){ ?>

    <div class="col-md-4 mb-4">
    <input type="hidden" name="words[]" id="" class="form-control" value="<?=$l?>" readonly="">

        <div class="form-floating">

            <input placeholder="Translation goes here" type="text" name="trans[]" id="" class="form-control" value="<?php if(isset($langs->$l)){echo $langs->$l;}?>" required>   
            <label for="" style="text-transform: capitalize; background: #eee; width: auto; height: 14px; border-radius: 8px; line-height: 1px; margin-left: 10px; top: -8px;"><?=$l?></label>

        </div>

    </div>

<?php } ?>


</div>

</div>

<div class="card-footer text-muted" style="position: fixed; bottom: 0; width: 100%;background: #e9ecef;">
<div class="">
<button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
</div>
</div>

</div>

</div>

</form>