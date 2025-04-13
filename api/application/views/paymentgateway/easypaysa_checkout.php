<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Easypaysa Checkout</title>
</head>
<body>
<div class="clear"></div>
    <div align="center">
        <h3>Processing...</h3>
    </div>
    <form action="https://easypay.easypaisa.com.pk/easypay/Confirm.jsf " method="POST" id="easyPayAuthForm">
        <input name="auth_token" value="<?php echo $_GET['auth_token'] ?>" hidden="true"/>
        <input name="postBackURL" value="<?=base_url('gateways/easypaysaController/confirmation')?>" hidden="true"/>
    </form>
    <script>
        (function() {
            document.getElementById("easyPayAuthForm").submit();
        })();
    </script>
</body>
<html>