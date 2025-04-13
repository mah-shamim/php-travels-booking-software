<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="https://phptravels.com/assets/img/favicon.png">
    <title>PHPTRAVELS - Installation</title>
    <link href="./assets/css/reset.css" rel="stylesheet">
    <link href="./assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href='./assets/plugins/bootstrap-select/css/bootstrap-select.min.css' rel='stylesheet' type='text/css'>
    <link href='./assets/builds/tailwind.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
    body,
    html {
        font-size: 16px;
    }

    body {
        font-family: "Inter", sans-serif;
        background: #f8fafc;
    }

    body>* {
        font-size: 14px;
    }
    .logo { margin-right: 30px; overflow: hidden; height: 50px; margin-top: 0; border-radius: 5px; padding: 8px 0; width: 200px; display: flex; line-height: 12px; align-items: center; text-decoration: none; justify-content: center; }

    </style>
</head>

<body>
    <div class="tw-max-w-4xl tw-w-full tw-mx-auto tw-my-6">
        <div class="logo tw-mt-5 tw-mb-5 tw-p-3 tw-inline-block tw-w-full" style="display: flex; justify-content: center; margin: auto; margin-bottom: 20px;">

        <a href="https://phptravels.com/" class="logo waves-effect" style="margin-right:30px">
        <svg style="max-height: 45px; max-width: 45px; margin-left: -10px; margin-top: -5px;" version="1.0" xmlns="http://www.w3.org/2000/svg" class="" width="700.000000pt" height="700.000000pt" viewBox="0 0 700.000000 700.000000" preserveAspectRatio="xMidYMid meet">
        <g transform="translate(0.000000,700.000000) scale(0.100000,-0.100000)" fill="#004aff" stroke="none">
        <path d="M4435 5753 c-307 -19 -533 -75 -848 -209 l-156 -66 -78 45 c-146 86 -349 156 -563 193 -115 20 -360 23 -445 5 -141 -29 -285 -91 -330 -141 -42 -46 -7 -157 90 -288 l44 -60 68 34 c112 55 204 74 367 74 87 0 164 -6 202 -15 74 -17 174 -54 174 -64 0 -8 -171 -70 -275 -100 -320 -91 -556 -73 -658 50 -54 67 -97 165 -97 222 0 60 -12 54 -40 -21 -28 -73 -28 -158 -2 -278 43 -196 136 -378 224 -443 94 -69 244 -98 431 -81 317 28 432 73 1177 461 489 255 824 365 1145 376 157 6 237 -7 327 -53 72 -36 153 -116 185 -183 25 -49 28 -67 27 -146 0 -105 -22 -172 -89 -275 -65 -101 -174 -196 -415 -361 -188 -129 -664 -429 -682 -429 -4 0 -8 19 -8 43 0 107 -57 347 -126 536 -30 82 -175 390 -202 429 -6 10 -59 -13 -218 -94 -115 -59 -210 -108 -212 -110 -2 -1 14 -33 35 -71 134 -235 217 -551 248 -944 l6 -76 -138 -78 c-245 -139 -511 -317 -803 -538 -172 -131 -243 -191 -368 -312 -275 -265 -473 -617 -489 -865 -4 -75 -2 -94 22 -160 66 -182 187 -375 300 -478 54 -49 138 -103 182 -116 20 -7 20 -3 -13 61 -123 241 -21 584 288 969 189 236 545 536 869 732 789 479 1159 721 1514 987 267 200 412 385 494 630 107 320 19 641 -248 905 -148 146 -286 223 -484 270 -75 18 -310 43 -361 38 -12 -1 -43 -3 -71 -5z"></path> <path d="M3955 2994 c-154 -91 -285 -171 -291 -177 -7 -7 -24 -50 -39 -97 -85 -260 -216 -498 -365 -662 -116 -128 -345 -305 -490 -378 -30 -15 -91 -40 -135 -55 -44 -16 -85 -32 -91 -37 -19 -14 -36 -88 -35 -153 1 -114 63 -232 148 -282 37 -21 56 -26 109 -24 121 3 264 51 412 138 294 172 642 576 832 968 100 206 159 392 200 633 19 114 37 292 29 292 -2 -1 -130 -75 -284 -166z"></path>
        </g></svg>
        <div>
        <text style="font-size: 20px;font-weight: 700;display: block; margin-bottom: 5px;color: #000;" id="PHPTRAVELS" class="cls-1" x="50" y="20"><em>phptravels</em></text>
        <text style="font-size: 10.5px;color: #000;" id="TRAVEL_TECHNOLOGY_PARTNER" data-name="TRAVEL TECHNOLOGY PARTNER" class="cls-2" x="50" y="33"><em>Travel Tech Partner</em></text>
        </div>
        </a>

        </div>

        <?php include('steps.php'); ?>
        <div class="tw-bg-white tw-rounded tw-px-4 tw-py-6 tw-border tw-border-solid tw-border-neutral-200">
            <?php if ($debug != '') { ?>
            <div class="sql-debug-alert alert alert-success">
                <?php echo $debug; ?>
            </div>
            <?php } ?>
            <?php if (isset($error) && $error != '') { ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
            <?php } ?>
            <?php
                if ($current_step == 1) {
                    include_once('requirements.php');
                } elseif ($current_step == 2) {
                    include_once('file_permissions.php');
                } elseif ($current_step == 3) {
                    include_once('database.php');
                } elseif ($current_step == 4) {
                    include_once('install.php');
                } elseif ($current_step == 5) {
                    include_once('finish.php');
                }
            ?>
        </div>
    </div>

    <script src='./assets/plugins/jquery/jquery.min.js'></script>
    <script src='./assets/plugins/bootstrap/js/bootstrap.min.js'></script>
    <script src='./assets/plugins/bootstrap-select/js/bootstrap-select.min.js'></script>
    <script>
    $(function() {
        $('select').selectpicker();

        $('#installForm').on('submit', function(e) {
            $('#installBtn').prop('disabled', true);
            $('#installBtn').text('Please wait...');
        });

        setTimeout(function() {
            $('.sql-debug-alert').slideUp();
        }, 4000);
    });
    </script>
</body>

</html>