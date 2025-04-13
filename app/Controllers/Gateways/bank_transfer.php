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
$router->post('payment/bank_transfer', function() {

    $payload = json_decode(base64_decode($_POST['payload']));
    if($payload->type == 'wallet'){
    $payload->price = $_POST['price'];
    }

    // SUCCESS URL
    $success_url = (root).'payment/success/?token='.$_POST['payload'];
    $gateway = array_column(base()->payment_gateways, null, 'name')['Bank Transfer'];
    
 ?>
 <style>
    .card-body{display:block !important}
 </style>
    <?php 

    $body = '
    <p>'.$gateway->c1.'</p>
    <p>'.$gateway->c2.'</p>
    <p>'.$gateway->c3.'</p>
    <p>'.$gateway->c4.'</p>
    ';
    include "App/Views/Pay_view.php";
    
    });

?>