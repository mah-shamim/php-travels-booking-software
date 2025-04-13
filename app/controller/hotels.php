<?php

use Curl\Curl;

/* ---------------------------------------------- */
// Hotels index page controller
/* ---------------------------------------------- */
$router->get(hotels, function () {
    $title = T::hotels_search_hotels;
    $meta_title = T::hotels_search_hotels;
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $body = views . "modules/hotels/hotels.php";
    include layout;
});

/* ---------------------------------------------- */
// Hotels search page for listing
/* ---------------------------------------------- */
$router->get($session_langcur . hotels . '(.*)', function () {

    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 8) {echo "";}

    define('lang', $url[0]);
    $currency = strtoupper($url[1]);
    $city = $url[3];
    $checkin = $url[4];
    $checkout = $url[5];
    $rooms = $url[6];
    $adults = $url[7];
    $childs = $url[8];
    $nationality = $url[9];

    // seo and meta tags
    $title = "Hotels in " . $city;
    $meta_title = "Hotels in " . $city;
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // from to dates nights count
    $cin = strtotime($checkin);
    $cout = strtotime($checkout);
    $nights = $cout - $cin;

    // adding search credentials to session
    $_SESSION['hotels_location'] = $city;
    $_SESSION['hotels_checkin'] = $checkin;
    $_SESSION['hotels_checkout'] = $checkout;
    $_SESSION['hotels_adults'] = $adults;
    $_SESSION['hotels_childs'] = $childs;
    $_SESSION['hotels_rooms'] = $rooms;
    $_SESSION['hotels_nationality'] = $nationality;


    if(isset($_SESSION['ages']) && !empty($_SESSION['ages'])){
        $ch_ages = $_SESSION['ages'];
    }else{
        $ch_ages = '';
    }

    // REMOVE DASH FROM CITY ON END 
    if(substr($city, -1) == '-') { $city_ = substr($city, 0, -1);
    } else { $city_ =  $city; } 

    $parms = array(
    'city' => $city_,
    'checkin' => $checkin,
    'checkout' => $checkout,
    'nationality' => $nationality,
    'adults' => $adults,
    'chlids' => $childs,
    'child_ages' => $ch_ages,
    'rooms' => $rooms,
    'lang' => $_SESSION['session_lang'],
    'currency' => $currency,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'browser_version' => $_SERVER['HTTP_USER_AGENT'],
    'type' => 'web',
    'os' => get_operating_system()
    );
    $req = new Curl();
    $req->post(api_url.'api/hotel/search?appKey='.api_key, $parms);
    if ($req->error) { //echo 'Error: ' . $req->errorCode . ': ' . $req->errorMessage . "\n";
    } else {
        $hotels_data = $req->response;

    // storing hotels to session to show as related hotels on details page
    $_SESSION['related_hotels'] = $hotels_data;
    };

    // dd(json_encode($hotels_data));

    // generate logs
    logs($SearchType = "Hotels Search");

    // adding search to session
    SEARCH_SESSION($MODULE=T::hotels_hotels,$CITY=$city);

    $body = views . "modules/hotels/listing.php";
    include layout;
});

/* ---------------------------------------------- */
// Hotels details page
/* ---------------------------------------------- */
$router->get($session_langcur.hotel.'(.*)', function () {
    $url = explode('/', $_GET['url']);
    $count = count($url);if ($count < 9) {echo "";}
    $url_lang = $url[0];
    $url_currency = $url[1];
    $module_name = $url[2];
    $city = $url[3];
    $hotel_name = $url[4];
    $hotel_id = $url[5];
    $checkin = $url[6];
    $checkout = $url[7];
    $rooms = $url[8];
    $adults = $url[9];
    $childs = $url[10];
    $supplier = $url[11];
    $nationality = $url[12];
    $country_code = $url[13];
    $city_code = $url[14];

    if(isset($_SESSION['ages']) && !empty($_SESSION['ages'])){
        $ch_ages = $_SESSION['ages'];
    }else{
        $ch_ages = '';
    }

    $req = new Curl();
    $req->post(api_url . 'api/hotel/detail?appKey=' . api_key, array(
        'hotel_id' => $hotel_id,
        'city_code' => $city_code,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'nationality' => $nationality,
        'adults' => $adults,
        'chlids' => $childs,
        'rooms' => $rooms,
        'country_code' => $country_code,
        'supplier' => $supplier,
        'child_ages' => $ch_ages,
    ));
    if ($req->error) { //echo 'Error: ' . $req->errorCode . ': ' . $req->errorMessage . "\n";
    } else { $hotel = $req->response;};

    $title = $hotel_name;
    $meta_title = $hotel_name;
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // generate logs
    logs($SearchType = "Hotels Details ");

    $body = views . "modules/hotels/details.php";
    include layout;
});

/* ---------------------------------------------- */
// Hotels booking controller
/* ---------------------------------------------- */
$router->post('hotels/booking', function () {

    $title = "Hotel Booking";
    $meta_title = "Hotel Booking";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    $payload = json_decode(base64_decode($_POST['payload']));

    //dd($payload);die;
    // dd($_POST);

    $booking_data = json_decode(base64_decode($_POST['payload']));

    if(isset($_POST['room_quantity']) && !empty($_POST['room_quantity'])){
        $rooms_quatity = $_POST['room_quantity'];
    }else{
        $rooms_quatity = 1;
    }

    $cin = strtotime($booking_data->checkin);
    $cout = strtotime($booking_data->checkout);
    $nights = $cout - $cin;

    // user session check
    if (isset($_SESSION['user_login']) == true) {
        $req = new Curl();
        $req->post(api_url . 'api/login/get_profile?appKey=' . api_key, array('id' => $_SESSION['user_id'], ));
        $profile = json_decode($req->response);
        $profile_data = $profile->response;
        // dd($profile_data);
    } else {}

    // generate logs
    logs($SearchType = "Hotels Booking");

    $body = views . "modules/hotels/booking.php";
    include layout;

});

/* ---------------------------------------------- */
// Hotels booking confirmation
/* ---------------------------------------------- */
$router->post('hotels/book', function () {

    $payload = json_decode(base64_decode($_POST['payload']));

    //dd($payload->total_price);
   //  dd($_POST);
   //  die;

    // function if user logged in get his id for booking
    function user_id()
    { if (isset($_SESSION['user_login']) == true) {
        return $_SESSION['user_id'];} else { return "0";}
    } $user_id = user_id();

    $rom[] = array(
    'room_name'=>$payload->room_type,
    'room_price'=>$payload->room_price,
    'room_qaunitity'=>$payload->room_quantity,
    'room_extrabed_price'=>0,
    'room_extrabed'=>0,
    'room_actual_price'=>$payload->real_price,
    );

    $adult_travellers = $payload->adult_travellers;
    $child_travellers = $payload->child_travellers;

    $data = [];

     for ($i = 1; $i <= $adult_travellers; $i++) {
        array_push($data, (object) array(
            'title'=>$_POST["title_".$i],
            'first_name'=>$_POST["firstname_".$i],
            'last_name'=>$_POST["lastname_".$i],
            'age'=>'',
            ));
      }

      for ($x = 1; $x <= $child_travellers; $x++) {
        array_push($data, (object) array(
            'title'=>'mr',
            'first_name'=>$_POST["firstname_".$x],
            'last_name'=>$_POST["lastname_".$x],
            'age'=>$_POST["child_age_".$x],
            ));
      }

     

    // array_push($data, (object) array(
    // 'title'=>'blank',
    // ));

    $guest = json_encode($data);

    if(isset($_SESSION['ages']) && !empty($_SESSION['ages'])){
        $ch_ages = $_SESSION['ages'];
    }else{
        $ch_ages = '';
    }
    // final booking post request
    $req = new Curl();
    $req->post(api_url . 'api/hotel/book?appKey=' . api_key, array(
    'hotel_id' => $payload->hotel_id,
    'stars' => $payload->hotel_stars,
    'total_price' => $payload->total_price,
    'checkin' => $payload->checkin,
    'checkout' => $payload->checkout,
    'adults' => $payload->adults,
    'childs' => $payload->childs,
    'child_ages' => $ch_ages,
    'deposit' => $payload->deposit_amount,
    'tax' => $payload->total_tax,
    'firstname' => $_POST['firstname'],
    'lastname' => $_POST['lastname'],
    'email' => $_POST['email'],
    'address' => $_POST['address'],
    'phone' => $_POST['phone'],
    'supplier' => $payload->supplier,
    'curr_code' => $payload->currency,
    'tax_type' => $payload->tax,
    'hotel_name' => $payload->hotel_name,
    'nights' => $payload->nights,
    'loaction' => $payload->city_name,
    'hotel_img' => $payload->hotel_img,
    'rooms' => json_encode($rom),
    'deposit_type' => $payload->deposit_type,
    'user_id' => $user_id,
    'payment_gateway' => $_POST['payment_gateway'],
    'latitude' => $payload->latitude,
    'longitude' => $payload->longitude,
    'booking_key' => $payload->bookingKey,
    'children_ages' => $payload->children_ages,
    'real_price' => $payload->real_price,

    'guest' => $guest,

    // extra fields
    'room_id' => $payload->room_id,
    'roomscount' => $payload->room_quantity,
    'city_code' => $payload->city_code,
    'country_code' => $_POST['country_code'],
    'nationality' => $_POST['nationality'],
    "hotel_phone" => $payload->hotel_phone,
    "hotel_email" => $payload->hotel_email,
    "hotel_website" => $payload->hotel_website,
    "hotel_city_code" => $payload->city_code,
    "hotel_nationality" => $payload->nationality,
    "hotel_country_code" => $payload->country_code,

    "booking_from" => 'Web App',
    "supplier_name" => $payload->supplier_name,
    "invoice_url" => root . 'hotels/booking/invoice/',

    "price_type" => '0',
    "room_adult_price" => '',
    "room_child_price" => '',

    ));
    if ($req->response == true) {
    $invoice_url =  root . 'hotels/booking/invoice/' . $req->response->sessid . '/' . $req->response->id;
    header('Location: ' .$invoice_url);
    } else { echo "Booking Error Please Try Again."; }

    // $booking = json_decode($req->response);


    // generate logs
    logs($SearchType = "Hotel Book ");

});

/* ---------------------------------------------- */
// Hotels booking voucher
/* ---------------------------------------------- */
$router->get('hotels/booking/invoice/(.*)', function () {
    $url = explode('/', $_GET['url']);

    $req = new Curl();
    $req->get(api_url.'api/hotels/booking?appKey='.api_key.'&invoice_id='.$url[3].'&booking_id='.$url[4] );
    $data = $req->response;
    $booking = $data->response;

    // dd(json_encode($booking));
 
    $title = "Hotel Invoice";
    $meta_title = "Hotel Invoice";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // $json = json_encode($booking);
    // $bytes = file_put_contents("invoice.json", $json);

    $invoice = views . "modules/hotels/invoice.php";
    $body = invoice_layout;
    include layout;
});

/* ---------------------------------------------- */
// hotels booking updated after payment request
/* ---------------------------------------------- */
$router->get('hotels/invoice/update', function () {

    /*echo $_GET['booking_id'];
    echo $_GET['booking_no'];
    echo $_GET['booking_status'];
    echo $_GET['payment_status'];
    echo $_GET['payment_gateway'];
    echo $_GET['amount_paid'];
    echo $_GET['remaining_amount'];
    echo $_GET['payment_date'];
    echo $_GET['txn_id'];
    echo $_GET['token'];
    echo $_GET['logs'];
    echo $_GET['desc'];*/

   //  $payload = json_decode(base64_decode($_POST['payload']));

    $req = new Curl();
    $req->post(api_url.'api/hotel/invoice?appKey='.api_key, array(
    'booking_id' => $_GET['booking_id'],
    'ref_id' => $_GET['booking_no'],
    'status' => $_GET['booking_status'],
    'payment_status' => $_GET['payment_status'],
    'payment_gateway' => $_GET['payment_gateway'],
    'amount_paid' => "",
    'remaining_amount' => "",
    'payment_date' => date("Y-m-d"), //.date(" h:i:s a")
    'txn_id' => "",
    'token' => "",
    'logs' => "",
    'desc' => ""
    ));

    /*dd($req->response);
    die;*/


    if ($req->response == true) {

    // send request to third-party API supplier
    $confirm = new Curl();
    $confirm->post(api_url.'api/hotel/cofirmedbooking?appKey='.api_key, array(
    'booking_id' => $_GET['booking_id'],
    ));

    //dd($confirm);
    //die;

    header('Location:'.root.'hotels/booking/invoice/'.$_GET['booking_no'].'/'.$_GET['booking_id']);
    } else { echo "Booking Error Please Try Again."; }

    // $booking = json_decode($req->response);

    // generate logs
    logs($SearchType = "Hotel booking paid " );

});


/* ---------------------------------------------- */
// hotels cancellation request
/* ---------------------------------------------- */
$router->post('hotels/cancellation', function () {

    // final booking post request
    $req = new Curl();
    $req->post(api_url.'api/hotel/cancellation?appKey='.api_key, array(
    'booking_no' => $_POST['booking_no'],
    'booking_id' => $_POST['booking_id'],
    'cancellation_request' => 1
    ));

    if ($req->response == true) {
        header('Location: ' . root . 'hotels/booking/invoice/' . $_POST['booking_no'] . '/' . $_POST['booking_id']);
    } else { echo "Booking Error Please Try Again."; }

    // $booking = json_decode($req->response);

    // generate logs
    logs($SearchType = "Hotel Cancel Request ID".$_POST['booking_id'] );

});


/* ---------------------------------------------- */
// Hotels get location
/* ---------------------------------------------- */
$router->get('hotels_locations', function () {
    if (isset($_GET['q']) && !empty($_GET['q'])) {
    $req = new Curl();
    $req->get(api_url . "api/hotels/locations?appKey=" . api_key . "&name=" . $_GET['q']);
    if ($req->error) { // $req->error;
    } else { $final_results = array();
    foreach ($req->response->locations as $item) {
    if ($item->countrycode === null) {$icon = "NA";} else { $icon = $item->countrycode;}
    array_push($final_results, (object) array("id" => $item->city, "text" => $item->city, "icon" => $icon));}
    echo json_encode($final_results);
};}});

// store child ages to session
$router->post('child_ages', function () {

$array = [];
foreach ($_POST as $i){

array_push($array, (object) array(
'ages'=>  $i,
));
 
}

$ages = json_encode($array);
$_SESSION['ages'] = $ages;
$ages_ = $_SESSION['ages'];

print_r($ages_);
die;

});