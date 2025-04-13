<?php

// SERVICE BY https://apilayer.com
// BEFORE USING THE SERVICE MAKE SURE YOU HAVE THE VALID LICENSE KEYS

use Medoo\Medoo;

require_once '_config.php';
$curl = curl_init();

$currencies = $db->select('currencies','*', ["default" => 1]);
$default_currency=($currencies[0]['name']);

$currencies_update = $db->select('currencies','*');
foreach ($currencies_update as $d){

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.apilayer.com/currency_data/convert?to=".$d['name']."&from=".$default_currency."&amount=1",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: text/plain",
    "apikey: ".api_layer_key,
  ),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET"
));

$response = curl_exec($curl);

curl_close($curl);
$rate = json_decode($response);

if (!empty($d['name']) && !empty($rate->result)){

echo "<pre>";
echo $d['name'] . ' => ' .$rate->result; 
echo "<pre>";
echo "<hr>";

$params = array( 'rate' => $rate->result, );
$data = $db->update('currencies',$params, [ "name" => $d['name'] ]);

$options = array( 'cluster' => 'us2', 'useTLS' => true);
$pusher = new Pusher\Pusher('be4840bf63594e1468bb', '89406484859350dc3714','1585424', $options);

} else {
    echo $response;
}

}

// PUSH NOTIFICATION
$push_data['message1'] = 'Currencies Updated';
$push_data['message2'] = 'Currencies rates updated';
$pusher->trigger('my-channel', 'event', $push_data);

?>

