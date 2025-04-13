<?php
$payload = json_decode(base64_decode($_POST['payload']));
$booking_id = $payload->booking_id;
$booking_no = $payload->booking_no;
$invoice_url = $payload->invoice_url;
$desc = $payload->desc;
$currency = $payload->currency;
$client_email = $payload->client_email;
$gateway = $_POST['payment_gateway'];

// condition if price submitted through form post then take this price
if (!empty($_POST['price'])) { $price = $_POST['price']; }
else { $price = $payload->price; }

// get existing balance to add with new funds
if (isset($payload->balance)) { $balance = $payload->balance; }
else { $balance = ""; }

$url = $_POST['url'];
$c1 = $_POST['c1'];
$c2 = $_POST['c2'];
$c3 = $_POST['c3'];
$c4 = $_POST['c4'];
$c5 = $_POST['c5'];
$dev = $_POST['dev'];

//$price = $_POST['price'];

// condition if payment method is invoice then success URL should be this one
if ($payload->type == "invoice") {

// success get url to update the invoice
$success = root."hotels/invoice/update?
booking_id=".$booking_id."
&booking_no=".$booking_no."
&booking_status=confirmed
&payment_status=paid
&payment_date=".date('Y-m-d')."
&txn_id=0
&token=0
&logs=0
&desc=0
&payment_gateway=".$gateway."
&amount_paid=".$price."
&remaining_amount
";
$success_url=preg_replace('/\s+/', '', $success);
}

// condifiton if payment method is wallet redirect to wallet funds page
if ($payload->type == "wallet") {

// combine new funds value and old exisint balance in amount param
$amount = $balance + $price;

// generate success URL for final update to add balance to users account
$success = root."
account/add_balance?
user_id=".$_SESSION['user_id']."
&balance=".$amount."
&currency=".$payload->currency."
&success_url=account/funds-success
";
$success_url=preg_replace('/\s+/', '', $success);
}