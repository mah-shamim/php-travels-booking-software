<?php 

// ======================================================== HOTELS INDEX

$router->get('(hotels)', function ($nav_menu) {

    // META DETAILS
    $meta = array(
        "title" => T::hotels_search_hotels,
        "meta_title" => T::hotels_search_hotels,
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        
    );

    views($meta,"Hotels/Index");
    
});

// ======================================================== HOTELS INDEX

// ======================================================== HOTELS INVOCE

$router->get('/(hotels)/invoice/(\d+)', function($nav_menu,$id) { 

    // SEARCH PARAMS
    $params = array( "booking_ref_no"=>$id,);
    $RESPONSE=POST(api_url.'hotels/invoice',$params);

    if(empty($RESPONSE->response)){
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => "Hotels Invoice",
        "meta_title" => "Hotels invoice",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        "data" => $data->response[0]
    );

    views($meta,"Hotels/Invoice");

});

// ======================================================== HOTELS INVOICE


// ======================================================== HOTELS SEARCH RESULTS

$router->get('/(hotels)/(.*)', function($nav_menu,$uri) {

    $url = explode('/', $uri);
    $count = count($url);

    // REDIRECT HOME IF URI PARAMS ARE LESS THEN 7
    if ($count > 7 ) { REDIRECT(root); }

    $city_name = $url[0];
    $checkin = $url[1];
    $checkout = $url[2];
    $rooms = $url[3];
    $adults = $url[4];
    $childs = $url[5];
    $nationality = $url[6];

    // SEARCH PARAMS
    $params = array(
        "city"=>$city_name,
        "checkin"=>$checkin,
        "checkout"=>$checkout,
        "rooms"=>$rooms,
        "adults"=>$adults,
        "childs"=>$childs,
        "nationality"=>$nationality,
        "ip"=>user_ip(),
        "currency"=>currency,
        "language"=>"en",
        "child_age"=>"0"
    );

    // META DETAILS
    $meta = array(
        "title" => T::hotels.' - '.ucfirst($city_name),
        "meta_title" => T::hotels.' - '.ucfirst($city_name),
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "checkin" => $checkin,
        "checkout" => $checkout,
        "rooms" => $rooms,
        "adults" => $adults,
        "childs" => $childs,
        "nationality" => $nationality,
        "nav_menu" => $nav_menu,
    );

    $duration_time = (duration * 60);
    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $duration_time)) {
        unset($_SESSION["related_hotels"]);
        unset($_SESSION["url"]);
        unset($_SESSION["data_hotel"]);
        unset($_SESSION["related_hotels_data"]);
    }

    if (!empty($_SESSION['url'])) {
        $a1 = $_SESSION['url'];
        $check = 1;
        $url_check = array_diff($a1, explode('""', $actual_link));
        if (!empty($url_check)) {
            $check = 0;
        }
    } else {
        $check = 0;
    }
    if($check == 0) {
        // SEARCH REQUEST
        $RESPONSE = POST(api_url . 'hotel_search', $params);

        if (isset($RESPONSE->data)) {
            $meta['data'] = $RESPONSE->data;
            $_SESSION['related_hotels'] = $RESPONSE;
            $_SESSION['related_hotels_data'] = $RESPONSE;
            $_SESSION['data_hotel'] = $RESPONSE->data;
            $_SESSION['url'] = explode('""',$actual_link);
            $_SESSION['last_activity'] = time();
        }
    }else{
        $meta['data']=$_SESSION['data_hotel'];
        $_SESSION['related_hotels'] = $_SESSION['related_hotels_data'];
        $_SESSION['url'] = explode('""',$actual_link);
    }
    
    // ADD SEARCH CRITERIA TO SESSION
    $_SESSION['hotels_location'] = $city_name;
    $_SESSION['hotels_checkin'] = $checkin;
    $_SESSION['hotels_checkout'] = $checkout;
    $_SESSION['hotels_adults'] = $adults;
    $_SESSION['hotels_childs'] = $childs;
    $_SESSION['hotels_rooms'] = $rooms;
    $_SESSION['hotels_nationality'] = $nationality;

    views($meta,"Hotels/Hotels");

});

// ======================================================== HOTELS SEARCH RESULTS


// ======================================================== HOTELS DETAILS

$router->get('/(hotel)/(.*)', function($nav_menu,$url) {
    
    $url = explode('/', $_GET['url']);
    $count = count($url);if ($count < 9) {echo "";}

    $hotel_id = $url[1];
    $hotel_name = $url[2];
    $checkin = $url[3];
    $checkout = $url[4];
    $rooms = $url[5];
    $adults = $url[6];
    $childs = $url[7];
    $hash = $url[8];
    
    $hashed = json_decode(base64_decode($hash));

    (isset($_SESSION['hotels_nationality']))?$nationality=$_SESSION['hotels_nationality']:$nationality="US";

    // SEARCH PARAMS
    $params = array(
        "hotel_id"=>$hotel_id,
        "checkin"=>$checkin,
        "checkout"=>$checkout,
        "adults"=>$adults,
        "childs"=>$childs,
        "child_age"=>0,
        "rooms"=>$rooms,
        "language"=>"en",
        "currency"=>currency,
        "nationality"=>$nationality,
        "supplier_name"=>$hashed->supplier_name
    );

    // META DETAILS
    $meta_ = array();
    
    // SEARCH REQUEST
    $RESPONSE=POST(api_url.'hotel_details',$params);

    // $RESPONSE=POST(api_url.'hotel_details',$params);    
    if(isset($RESPONSE)){ $meta_['data']=$RESPONSE;

        // ADD Tours TO SESSION
        if (isset($_SESSION['HOTEL_DETAILS'])){
            $key = array_search($RESPONSE->id, array_column($_SESSION['HOTEL_DETAILS'], 'id'));
            if($key == 0 && gettype($key) == 'integer'){
                $key = 1;
            }
            if(empty($key)){
                $_SESSION['HOTEL_DETAILS'][] = $RESPONSE;
            }
        } else {
            $_SESSION['HOTEL_DETAILS'][] = $RESPONSE;
        }
    }
    
    if(isset($_SESSION['ages']) && !empty($_SESSION['ages'])){
        $ch_ages = $_SESSION['ages'];
    }else{
        $ch_ages = '';
    } 
    
    // META DETAILS
    $meta = array(
        "title" => T::hotel.' '.$meta_['data']->name,
        "meta_title" => T::hotel.' '.$meta_['data']->name,
        "meta_desc" => T::hotel.' '.$meta_['data']->desc,
        "meta_img" => T::hotel.' '.$meta_['data']->img[0],
        "meta_url" => "",
        "meta_author" => "",
        "checkin" => $checkin,
        "checkout" => $checkout,
        "rooms" => $rooms,
        "adults" => $adults,
        "childs" => $childs,
        "nationality" => "",
        "data"=> $meta_['data'],
        "nav_menu" => $nav_menu,

    );

    views($meta, "Hotels/Details");

});

// ======================================================== HOTELS DETAILS

// ======================================================== HOTELS BOOKING

$router->post('(hotels)/booking', function($nav_menu) {
    
    CSRF();
    $hashed = json_decode(base64_decode($_REQUEST['payload'])); 
    $hashed->room_quantity=($_POST['room_quantity']);

    // META DETAILS
    $meta = array(
    "title" => T::bookings,
    "meta_title" => T::bookings,
    "meta_desc" => "",
    "meta_img" => "",
    "meta_url" => "",
    "meta_author" => "",
    "nationality" => "",
    "data"=> $hashed,
    "nav_menu" => $nav_menu,
    );

    views($meta, "Hotels/Booking");

});

// ======================================================== HOTELS BOOKING

// ======================================================== HOTELS BOOK

$router->post('(hotels)/book', function() {
    
    CSRF();

    $payload = json_decode(base64_decode($_POST['payload']));

    $room[] = array(
    'room_id'=>$payload->room_id,
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
        $data[] = (object)array(
            'traveller_type' => 'adults',
            'title' => $_POST["title_" . $i],
            'first_name' => $_POST["firstname_" . $i],
            'last_name' => $_POST["lastname_" . $i],
            'age' => '',
        );
      }

      for ($x = 1; $x <= $child_travellers; $x++) {
        $data[] = (object)array(
            'traveller_type' => 'child',
            'title' => 'mr',
            'first_name' => $_POST["firstname_" . $x],
            'last_name' => $_POST["lastname_" . $x],
            'age' => $_POST["child_age_" . $x],
        );
      }

    $guest = json_encode($data);

    if(isset($_SESSION['ages']) && !empty($_SESSION['ages'])){
        $ch_ages = $_SESSION['ages'];
    }else{
        $ch_ages = '';
    }

    // CHECK USER SESSION
    function user_id()
    { if (isset($_SESSION['phptravels_client']->user_id)) {
    return $_SESSION['phptravels_client']->user_id;} else { return "0";}
    } $user_id = user_id();

    $params = array(
    'price_original' => $payload->real_price,
    'price_markup' => $payload->room_price,
    'vat' => '',
    'tax' => '',
    'gst' => '',
    'first_name' => $_POST['user']['first_name'],
    'last_name' => $_POST['user']['last_name'],
    'email' => $_POST['user']['email'],
    'address' => $_POST['user']['address'],
    'phone_country_code' => $_POST['user']['country_code'],
    'phone' => $_POST['user']['country_code'],
    'country' => $_POST['user']['nationality'],
    'stars' => $payload->hotel_stars,
    'hotel_id' => $payload->hotel_id,
    'hotel_name' => $payload->hotel_name,
    'hotel_img' => $payload->hotel_img,

    'hotel_phone' => $payload->hotel_phone,
    'hotel_email' => $payload->hotel_email,
    'hotel_website' => $payload->hotel_website,
    'hotel_address' => $payload->hotel_address,

    'room_data' => json_encode($room, JSON_PRETTY_PRINT),
    'location' => $payload->city_name,
    'location_cords' => $payload->latitude.','.$payload->longitude,
    'checkin' => $payload->checkin,
    'checkout' => $payload->checkout,
    'adults' => $payload->adults,
    'childs' => $payload->childs,
    'child_ages' => $payload->children_ages,
    'currency_original' => $payload->currency,
    'currency_markup' =>  $payload->currency,

    'booking_data' => json_encode($payload->booking_data    , JSON_PRETTY_PRINT),
    'supplier' => $payload->supplier_name,
    'user_id' => $user_id,

    'nationality' => $_POST['user']['nationality'],
    'payment_gateway' => $_POST['payment_gateway'],
    'guest' => ($guest),
    "user_data"=>json_encode($_POST['user'], JSON_PRETTY_PRINT),

    );

    // FINAL BOOKING REQUEST
    $REQUEST=POST(api_url.'hotel_booking', $params); 

    if ($REQUEST->status == true) {
    $invoice_url = root.'hotels/invoice/' . $REQUEST->booking_ref_no;
    $_SESSION['booking_celebration'] = true;
    REDIRECT($invoice_url);
    }

});

// ======================================================== HOTELS BOOK


// ======================================================== HOTELS STORE CHILDS AGE SESSION

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

// ======================================================== HOTELS STORE CHILDS AGE SESSION



?>