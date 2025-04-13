<?php 

require_once '_config.php';
auth_check();

// POST MODULES STATUS
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $params = array( 
    'email_api_key' => $_POST['email_api_key'], 
    'email_sender_name' => $_POST['email_sender_name'], 
    'email_sender_email' => $_POST['email_sender_email'], 
    );

    $id = 1;
    UPDATE('settings',$params,$id);

    // INSERT TO LOGS
    $user_id = $USER_SESSION->backend_user_id;    
    $log_type = "email_settings";
    $datetime = date("Y-m-d h:i:sa");
    $desc = "updated email settings";
    logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));

    ALERT_MSG('updated');
    REDIRECT("email_settings.php");

}

$title = T::email_settings; 
include "_header.php";

// GET DATA FROM API
$params = array();
$settings = GET('settings',$params)[0];

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::email_settings?></p>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<div class="container">

    <div class="container py-4">
        <form action="./email_settings.php" method="POST">
            <div class="card p-5">

                <div class="panel-body">
                    <div class="tab-content form-horizontal">

                        <p><strong><?=T::api_credentials?></strong></p>
                        <p><?=T::signup_email_api?></p>

                        <div class="row form-group mb-4 mt-4">

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="email_api_key"
                                        value="<?=$settings->email_api_key?>" class="form-control" required>
                                    <label for=""><?=T::api_key?></label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="email_sender_name"
                                        value="<?=$settings->email_sender_name?>" class="form-control" required>
                                    <label for=""><?=T::sender_name?></label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" placeholder="" name="email_sender_email"
                                        value="<?=$settings->email_sender_email?>" class="form-control" required>
                                    <label for=""><?=T::sender_email?></label>
                                </div>
                            </div>

                        </div>

                        <hr>

                    </div>
                </div>

                <div class="mt-3">
                <?php if (isset($permission_edit)){ ?>
                    <button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
                <?php } ?>
                </div>
        </form>

    </div>

    <div class="card p-5 mt-3">
        <p class="mb-4"><?=T::to_test_email?></p>
        <div class="row">
            <div class="col-md-3">
                <div class="form-floating">
                    <input type="email" placeholder="" id="test_mail_id" name="" value="" class="form-control" required>
                    <label for=""><?=T::sender_email?></label>
                </div>
            </div>
        </div>

        <hr class="mt-4 col">
        <div class="mt-3">
        <?php if (isset($permission_edit)){ ?>
            <button type="submit" class="test_mail btn btn-primary"> <?=T::send_test_email?></button>
        <?php } ?>

            <button class="btn btn-primary loading_button" type="button" disabled style="display:none">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <?=T::email_test_email?>
            </button>
            
            <div style="display:none" class="mt-4 alert alert-secondary">
            <p id="result"></p>
            </div>

        </div>
    </div>
</div>
</div>

<script>
$('.test_mail').on('click', function() {

    var test_mail_id = $("#test_mail_id").val();

    if (test_mail_id == "") {
        alert('<?=T::test_mail_msg_1?>');
        window.location.reload();
    } else {

        $(".loading_button").show();
        $(".test_mail").hide();

        var form = new FormData();
        form.append("ajaxemail", "");
        form.append("title", "Test Email");
        form.append("template", "test_email");
        form.append("email", test_mail_id);
        form.append("first_name", "Test Success");
        form.append("Content", "test");

        var settings = {
            "url": "./_post.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function(response) {

            // const result = JSON.parse(response);

            $('.alert').fadeIn(250)
            $('#result').text(response)

            console.log(response);

            alert(
                '<?=T::test_mail_msg_2?>');
            $(".loading_button").hide();
            $(".test_mail").show();
        });

    }

});

</script>

<?php include "_footer.php";