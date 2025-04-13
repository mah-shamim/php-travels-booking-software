<?php
$data['vendor_id'] = 28632;
$data['vendor_auth_code'] = '47b2e26d2eb36236d438c2138a33f6fb70531875e9e95944d0';

$data['title'] = 'Hotel Booking'; // name of product
$data['webhook_url'] = 'https://phptravels.com/callback'; // URL to call when product is purchased


$data['prices'] = [$currency.':' . $price];
// Setting some other (optional) data.
$data['custom_message'] = 'Room Reservation';
$data['return_url'] = base_url().'/thhotels/payment_success';

// Here we make the request to the Paddle API
$url = 'https://vendors.paddle.com/api/2.0/product/generate_pay_link';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);

// And handle the response...
$data = json_decode($response);
if($data->success) {
header("Location:".$data->response->url);
exit;
} else {
echo "Your request failed with error: ".$data->error->message;
}
?>