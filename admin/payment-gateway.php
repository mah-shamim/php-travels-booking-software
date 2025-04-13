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
    'dev_mode' => $_POST['dev_mode'], 
    );

    $id = $_POST['id'];
    UPDATE('payment_gateways',$params,$id);

    // INSERT TO LOGS
    $user_id = $USER_SESSION->backend_user_id;    
    $log_type = "gateway_credentials";
    $datetime = date("Y-m-d h:i:sa");
    $desc = "payment credentials status updated";
    logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));

    ALERT_MSG('updated');
    REDIRECT('payment_gateways.php');
    die;  

}

// GET DATA FROM API
$params = array(  'id' => $_GET['id'] );
$gateway = (GET('payment_gateways',$params)[0]);

if ($gateway->status == 1) { $check = "checked"; } else { $check = ""; }

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=$gateway->name?> <?=T::settings?></p>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<div class="container">

    <div class="container py-4">
        <form action="payment-gateway.php" method="POST">
            <div class="card p-5">
                <div class="panel-heading">

                <?php if (isset($permission_edit)){ ?>
                    <div class="float-start mb-5 d-flex gap-2 align-items-center">
                        <label class="form-check-label" for="gateway"><?=T::status?></label>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="gateway"></label>
                            <input <?=$check?> style="width: 40px; height: 20px;cursor:pointer" class="form-check-input"
                                data-status="<?=$gateway->status?>" data-value="<?=$_GET['id'] ?>"
                                data-item="<?=$gateway->name?>" id="checkedbox" type="checkbox">
                        </div>
                    </div>
                    <?php } ?>

                    <div class="float-end mb-5">
                    </div>

                    <div class="clearfix"></div>

                </div>
                <div class="panel-body">
                    <div class="tab-content form-horizontal">

                        <p><strong><?=T::api_credentials?></strong></p>

                        <div class="row form-group mb-4 mt-4">

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c1" value="<?=$gateway->c1?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 1</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c2" value="<?=$gateway->c2?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 2</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c3" value="<?=$gateway->c3?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 3</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="c4" value="<?=$gateway->c4?>"
                                        class="form-control">
                                    <label for=""><?=T::credential?> 4</label>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="row form-group mb-3">

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" name="dev_mode" required>
                                        <option value="0"><?=T::production?></option>
                                        <option value="1"><?=T::development?></option>
                                    </select>
                                    <label for=""><?=T::dev_mode?></label>
                                </div>

                                <script>
                                $("[name='dev_mode']").val("<?=$gateway->dev_mode?>")
                                </script>

                            </div>

                            <!-- <div class="col-md-2">

        <label for="">Currency</label>
        <select class="form-select" name="currency">
        <option value="USD">USD</option>
        <option value="PKR">PKR</option>
        </select>

        <script>
        $("[name='currency']").val("")
        </script>

        </div> -->

                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <input type="hidden" name="id" value="<?=$_GET['id']?>">
                    <?php if (isset($permission_edit)){ ?>
                    <button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
                    <?php } ?>
                </div>
        </form>

    </div>
    <style>
    .form-horizontal .control-label {
        max-height: 60px;
    }
    </style>

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
            "url": "./payment_gateways.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function(response) {
            // console.log(response);
            alert('Gateway status updated')
        });

    });
    </script>

</div>

<?php include "_footer.php";