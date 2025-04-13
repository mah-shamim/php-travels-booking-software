<?php 

require_once '_config.php';
auth_check();

// POST MODULES STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $params = array( 
    'id' => $_POST['id'], 
    'c1' => $_POST['c1'], 
    'c2' => $_POST['c2'], 
    'c3' => $_POST['c3'], 
    'c4' => $_POST['c4'], 
    'c5' => $_POST['c5'],
    'c6' => $_POST['c6'],
    'dev_mode' => $_POST['dev_mode'],
    'payment_mode' => $_POST['payment_mode'],
    'currency' => $_POST['currency'], 
    'module_color' => $_POST['module_color'], 
    'prn_type' => $_POST['prn_type'],
    );

    $id = $_POST['id'];
    UPDATE('modules',$params,$id);

    // INSERT TO LOGS
    $user_id = $USER_SESSION->backend_user_id;    
    $log_type = "module_settings";
    $datetime = date("Y-m-d h:i:sa");
    $desc = "module credentials updated";
    logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));

    ALERT_MSG('updated');
    REDIRECT('modules.php');
    exit;
    
}

// GET DATA FROM API
$params = array(  'id' => $_GET['id'] );
$module = (GET('modules',$params)[0]);

$params = array();
$currencies = GET('currencies',$params);

if ($module->status == 1) { $check = "checked"; } else { $check = ""; }

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=$module->name?> <?=T::settings?></p>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<div class="">

    <div class="container py-4">
        <form action="module.php" method="POST">
            <div class="card p-5">
                <div class="panel-heading">

                <?php if (isset($permission_edit)){ ?>
                    <div class="float-start mb-5 d-flex gap-2 align-items-center">
                        <label class="form-check-label" for="module"><?=T::status?></label>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="module"></label>
                            <input <?=$check?> style="width: 40px; height: 20px;cursor:pointer" class="form-check-input"
                                data-status="<?=$module->status?>" data-value="<?=$_GET['id'] ?>"
                                data-item="<?=$module->name?>" id="checkedbox" type="checkbox">
                        </div>
                    </div>
                    <?php } ?>

                    <div class="float-end mb-5">
                    </div>

                    <div class="clearfix"></div>

                </div>
                <div class="panel-body">

                    <div class="tab-content form-horizontal">
                        
                    <?php if ($module->name == "hotels" || $module->name == "flights" || $module->name == "tours" || $module->name == "cars" || $module->name == "visa"){?>
                    
                    <input type="hidden" value="" name="c1" >
                    <input type="hidden" value="" name="c2" >
                    <input type="hidden" value="" name="c3" >
                    <input type="hidden" value="" name="c4" >
                    <input type="hidden" value="" name="c5" >
                    <input type="hidden" value="" name="c6" >
                    <input type="hidden" value="" name="dev_mode" >
                    <input type="hidden" value="" name="payment_mode" >
                    <input type="hidden" value="" name="currency" >

                    <?php } else { ?>
                        <p><strong><?=T::module_api_credentials?></strong></p>
                        <div class="row form-group mb-4 mt-4">
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c1" value="<?=$module->c1?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 1</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c2" value="<?=$module->c2?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 2</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c3" value="<?=$module->c3?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 3</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c4" value="<?=$module->c4?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 4</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c5" value="<?=$module->c5?>"
                                           class="form-control">
                                    <label for=""><?=T::credential?> 5</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c6" value="<?=$module->c6?>"
                                           class="form-control">
                                    <label for=""><?=T::credential?> 6</label>
                                </div>
                            </div>
                     

                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" name="dev_mode">
                                        <option value="1"><?=T::production?></option>
                                        <option value="0"><?=T::development?></option>
                                    </select>
                                    <label for=""><?=T::dev_mode?></label>
                                </div>

                                <script>
                                $("[name='dev_mode']").val("<?=$module->dev_mode?>")
                                </script>

                            </div>

                            <div class="col-md-4 mb-3">

                                <div class="form-floating">
                                    <select class="form-select" name="payment_mode">
                                        <option value="1"><?=T::merchant_api_booking_on_site?></option>
                                        <option value="0"><?=T::affiliate_api_ooking_on_other_site?></option>
                                    </select>
                                    <label for=""><?=T::payment_mode?></label>

                                    <script>
                                    $("[name='payment_mode']").val("<?=$module->payment_mode?>")
                                    </script>

                                </div>
                            </div>


                            <div class="col-md-2 mb-3">

                                <div class="form-floating">
                                    <select class="form-select" name="currency" required>
                                        <?php foreach($currencies as $c) { ?>
                                        <option value="<?=$c->name?>"><?=$c->name?></option>
                                        <?php } ?>
                                    </select>
                                    <label for=""><?=T::currency?></label>
                                </div>

                                <script>
                                $("[name='currency']").val("<?=$module->currency?>")
                                </script>

                            </div>
                            <?php } ?>

                            <div class="col-md-2 mb-3">
                                <div class="form-floating">
                                    <input type="color" id="module_color" name="module_color" class="form-control"
                                        value="<?=$module->module_color?>">
                                    <label for=""><?=T::color?></label>
                                </div>
                            </div>
                     

                    <div class="col-md-4">

                        <div class="form-floating">
                            <select class="form-select" name="prn_type">
                                <option value="1">Manual</option>
                                <option value="0">Auto</option>
                            </select>
                            <label for="">PNR <?=T::type?></label>

                            <script>
                                $("[name='prn_type']").val("<?=$module->prn_type?>")
                            </script>

                        </div>
                    </div>
                    </div>
                    </div>

                <hr class="mt-4 mb-4">

                <div class="mt-3">
                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                    <?php if (isset($permission_edit)){ ?>
                    <button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
                    <?php } ?>
                </div>
        </form>

    </div>

<script>
document.getElementById("module_color").value = "<?=$module->module_color?>";
// $('body').bind('copy',function(e) {
// e.preventDefault(); return false;
// });
</script>

<script>
$('[id=checkedbox]').on('click', function() {

    var status = $(this).data("status");
    var id = $(this).data("value");
    var item = $(this).data("item");

    var isChecked = this.checked;

    // CONDITION TO CHECK THE STATUS
    if (isChecked == true) {
        var checks = 1
    } else {
        var checks = 0
    }

    var form = new FormData();
    form.append("id", id);
    form.append("status", checks);

    var settings = {
        "url": "modules.php",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };

    $.ajax(settings).done(function(response) {
        // console.log(response);
        alert('Module status updated')
    });

});
</script>

</div>

<style>
.xcrud-rightside, .xcrud-top-actions { margin-top: -60px; }
.form-horizontal .control-label { max-height: 60px; }
</style>

<?php include "_footer.php"; ?>