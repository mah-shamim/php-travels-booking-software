<?php

// PARAMS TO USE FOR GATEWAY
// ===================================>
// Booking REF  -> ($payload->booking_ref_no)
// Invoice URL  -> ($payload->invoice_url)
// Client Email -> ($payload->client_email)
// Price        -> ($payload->price);
// Currency     -> ($payload->currency)
// ===================================>

// GATEWAY NAME CONTROLLER ( IF SPACES IN NAME FOLLOW BY UNDERSCOPE INSTEAD DASH )
$router->post('payment/worldpay', function() { 
    
$payload = json_decode(base64_decode($_POST['payload']));
if($payload->type == 'wallet'){
$payload->price = $_POST['price'];
}

// dd($payload);  

$success_url = (root).'payment/success/?token='.$_POST['payload'];
$gateway = array_column(base()->payment_gateways, null, 'name')['Worldpay'];


?>

    <style>
    .card-body{display: inline !important;}
    </style>
    
    <form action="https://secure-test.worldpay.com/wcc/purchase" method="POST"> <!-- Specifies the URL for our test environment -->
    <input type="hidden" name="testMode" value="100"> <!-- 100 instructs our test system -->
    <input type="hidden" name="instId" value="<?=$gateway->c1?>"> <!-- A mandatory parameter -->
    <input type="hidden" name="cartId" value="<?=$gateway->c2?>"> <!-- A mandatory parameter - reference for the item purchased -->
    <input type="hidden" name="amount" value="<?=$payload->price?>"> <!-- A mandatory parameter -->
    <input type="hidden" name="currency" value="<?=$payload->currency?>"> <!-- A mandatory parameter. ISO currency code -->
    <?php $body = '
    <input type=submit value="Pay Now" style="width: 100%; height: 50px; font-weight: 600; cursor: pointer;">
    </form>'; ?>

    <?php 
    include "App/Views/Pay_view.php";
    });

?>