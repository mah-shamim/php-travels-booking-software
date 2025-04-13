<?php 

/* ---------------------------------------------- */
// CARS INDEX PAGE
/* ---------------------------------------------- */
$router->get('(cars)', function ($nav_menu) {
  
    // META DETAILS
    $meta = array(
        "title" => "Cars",
        "meta_title" => "Cars",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
    );

    views($meta,"Cars/Index");

});

// ========================================================  INVOCE

$router->get('/(cars)/invoice/(\d+)', function($nav_menu,$id) { 

    // SEARCH PARAMS
    $params = array( "booking_ref_no"=>$id,);
    $RESPONSE=POST(api_url.'cars/invoice',$params);
    // dd($RESPONSE);

    if(empty($RESPONSE->response)){
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => "Cars Invoice",
        "meta_title" => "Cars invoice",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        "data" => $data->response[0]
    );

    views($meta,"Cars/Invoice");

});

// ========================================================  INVOICE

// ======================================================== CARS SEARCH RESULTS

$router->get('/(cars)/(.*)', function($nav_menu,$uri) {

    $url = explode('/', $uri);
    $count = count($url);

    // REDIRECT HOME IF URI PARAMS ARE LESS THEN 7
    if ($count > 7 ) { REDIRECT(root); }

    $from_airport = $url[0];
    $date = $url[1];
    $adults = $url[2];
    $childs = $url[3];

    // SEARCH PARAMS
    $params = array(
        "from_airport" => $from_airport,
        "language" => "en",
        "date" => $date,
        "adults" => $adults,
        "childs" => $childs,
        "currency" => currency,
        "ip" => $_SERVER['REMOTE_ADDR'],
    );

    // META DETAILS
    $meta = array(
        "title" => T::cars.' - '.ucfirst($from_airport),
        "meta_title" => T::cars.' - '.ucfirst($from_airport),
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "date" => $date,
        "adults" => $adults,
        "childs" => $childs,
        "nav_menu" => $nav_menu,
    );

    $duration_time = (duration * 60);
    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $duration_time)) {
        unset($_SESSION["related_cars"]);
        unset($_SESSION["url"]);
        unset($_SESSION["data_car"]);
        unset($_SESSION["related_cars_data"]);
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
        $RESPONSE = POST(api_url . 'cars/search', $params);

        if (isset($RESPONSE->data)) {
            $meta['data'] = $RESPONSE->data;
            $_SESSION['related_cars'] = $RESPONSE;
            $_SESSION['related_cars_data'] = $RESPONSE;
            $_SESSION['data_car'] = $RESPONSE->data;
            $_SESSION['url'] = explode('""',$actual_link);
            $_SESSION['last_activity'] = time();
        }
    }else{
        $meta['data']=$_SESSION['data_car'];
        $_SESSION['related_hotels'] = $_SESSION['related_cars_data'];
        $_SESSION['url'] = explode('""',$actual_link);
    }
    
    // ADD SEARCH CRITERIA TO SESSION
    $_SESSION['cars_flights_origin'] = $from_airport;
    // $_SESSION['cars_destination_id'] = 2;
    $_SESSION['date'] = $date;
    $_SESSION['cars_adults'] = $adults;
    $_SESSION['cars_childs'] = $childs;

    views($meta,"Cars/Cars");

});

// ========================================================  BOOKING

$router->post('(cars)/booking', function($nav_menu) {
    
    CSRF();
    $hashed = json_decode(base64_decode($_REQUEST['payload']));

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

    views($meta, "Cars/Booking");

});

// ======================================================== HOTELS BOOKING

// ======================================================== HOTELS BOOK

$router->post('(cars)/book', function() {
    
    CSRF();

    $payload = json_decode(base64_decode($_POST['payload']));

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

    $guest = json_encode($data);

    // CHECK USER SESSION
    function user_id()
    { if (isset($_SESSION['phptravels_client']->user_id)) {
    return $_SESSION['phptravels_client']->user_id;} else { return "0";}
    } $user_id = user_id();
    // print_r($payload);die();
    $params = array(
        'first_name' => $_POST['user']['first_name'],
        'last_name' => $_POST['user']['last_name'],
        'email' => $_POST['user']['email'],
        'address' => $_POST['user']['address'],
        'phone_country_code' => $_POST['user']['country_code'],
        'phone' => $_POST['user']['country_code'],
        "cars_name" => $payload->car_name,
        "car_img" => $payload->car_img,
        "car_location" => $payload->car_location,
        "car_stars" => $payload->car_stars,
        "car_id" => $payload->car_id,
        "booking_data" => $payload->booking_data,
        "cancellation" => $payload->cancellation,
        "booking_adults" => $payload->adults,
        "booking_childs" => $payload->childs,
        "price_markup" => $payload->price,
        "actual_price" => $payload->actual_price,
        "booking_curr_code" => $payload->currency,
        "module_type" => $payload->module_type,
        "booking_payment_gateway" => $_POST['payment_gateway'],
        "booking_supplier" => $payload->supplier,
        "user_id" => $user_id,
        "booking_guest_info" => $guest,
        "user_data" => json_encode($_POST['user'], JSON_PRETTY_PRINT),
    );

    // FINAL BOOKING REQUEST
    $REQUEST=POST(api_url.'cars/booking', $params);
    if ($REQUEST->status == true) {
    $invoice_url = root.'cars/invoice/' . $REQUEST->booking_ref_no;
    $_SESSION['booking_celebration'] = true;
    REDIRECT($invoice_url);
    }

});

// ======================================================== CARS BOOK


?>