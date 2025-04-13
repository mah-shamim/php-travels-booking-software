<?php

// gateway name
$router->post('payment/bank-transfer', function() {
include "app/core/pay_params.php";
foreach ($_SESSION['app']->payment_gateways as $gateways){ if($gateways->title == "bank-transfer"){

$body = "
<style>.card-body{display:block !important}</style>
<p><strong>".T::bankname."</strong> $gateways->c1</p>
<p><strong>".T::bankaddress."</strong> $gateways->c2</p>
<p><strong>".T::accountnumber."</strong> $gateways->c3</p>
<p><strong>".T::swiftnumber."</strong> $gateways->c4</p>
<p><strong>".T::iban."</strong> $gateways->c5</p>
<hr>
<small>".T::noteinvoicemsg."</small>
"; }}

include "app/core/pay_view.php"; });