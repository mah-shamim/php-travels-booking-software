<?php

// gateway name
$router->post('payment/stripe', function() {
include "app/core/pay_params.php";

\Stripe\Stripe::setApiKey($c2);

$session = \Stripe\Checkout\Session::create([
'customer_email' => $client_email,
'payment_method_types' => ['card'],
'line_items' => [[
'name' => 'Booking',
'description' => $booking_id.$booking_no,
// 'images' => ['https://example.com/t-shirt.png'],
'amount' => $price * 100,
'currency' => $currency,
'quantity' => 1,
]],
'success_url' => $success_url,
'cancel_url' => $invoice_url,
]);

$session_id = $session->id;

if ($session_id) {

echo "<script>
var stripe = Stripe('<?=$c1?>');
stripe.redirectToCheckout({
sessionId: '" . $session_id . "'
}).then(function (result) {
});
</script>";

} else { echo 'No Session ID!'; } ?>


<script src="<?=$url?>"></script>

<script>
function checkout(session_id) {
var stripe = Stripe('<?=$c1?>');
stripe.redirectToCheckout({
sessionId: '<?= $session_id; ?>'
}).then(function (result) {
// If `redirectToCheckout` fails due to a browser or network
// error, display the localized error message to your customer
// using `result.error.message`.
});
}
</script>

<?php
$body = '<a href="#" type="button" onclick="checkout()" style="background: #5469d4;" class="pay"/>'.T::paynow.' <small> '.$currency.' </small>'.$price.'</a>';
include "app/core/pay_view.php";
?>

<?php  });
