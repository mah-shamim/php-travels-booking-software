<?php 

/* ---------------------------------------------- */
// FLIGHTS INDEX PAGE
/* ---------------------------------------------- */
$router->get('(flights)', function ($nav_menu) {

    // META DETAILS
    $meta = array(
        "title" => T::flights_searchforbestflights,
        "meta_title" => T::flights_searchforbestflights,
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
    );

    views($meta,"Flights/Index");

});

// ======================================================== FLIGHTS INVOCE

$router->get('/(flights)/invoice/(\d+)', function($nav_menu,$id) { 


    // SEARCH PARAMS
    $params = array( "booking_ref_no"=>$id,);
    $RESPONSE=POST(api_url.'flights/invoice',$params);

    // dd($RESPONSE->response);

    if(empty($RESPONSE->response)){
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => "Flights Invoice",
        "meta_title" => "Flights invoice",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        "data" => $data->response[0]
    );

    views($meta,"Flights/Invoice");

});

// ======================================================== FLIGHTS INVOICE


// IMAGES FOR FEATURED FLIGHTS
$router->get('regions', function() { 

    header('Content-Type: application/json; charset=utf-8');
    $req = new Curl();
    $req->get('https://www.kayak.com/mvm/smartyv2/search?f=j&s=airportonly&where='.$_GET['q']);
    $respose = array ( "status"=>"true", "message"=>"image", "data"=> $req->response[0]->destination_images->image_jpeg );
    echo json_encode($respose);

});

// ======================================================== LISTING PAGE
$router->get('(flights)/(.*)', function($nav_menu)  {
    
    CSRF();

    $uri = explode('/', $_GET['url']);
    $count = count($uri);
    
    if ($uri[3] == "oneway"){
        $_SESSION['flights_origin']=$uri[1];
        $_SESSION['flights_destination']=$uri[2];
        $_SESSION['flights_type']=$uri[3];
        $_SESSION['flights_class']=$uri[4];
        $_SESSION['flights_departure_date']=$uri[5];
        $_SESSION['flights_adults']=$uri[6];
        $_SESSION['flights_childs']=$uri[7];
        $_SESSION['flights_infants']=$uri[8];
    };

    if ($uri[3] == "return"){
        $_SESSION['flights_origin']=$uri[1];
        $_SESSION['flights_destination']=$uri[2];
        $_SESSION['flights_type']=$uri[3];
        $_SESSION['flights_class']=$uri[4];
        $_SESSION['flights_departure_date']=$uri[5];
        $_SESSION['flights_returning_date']=$uri[6];
        $_SESSION['flights_adults']=$uri[7];
        $_SESSION['flights_childs']=$uri[8];
        $_SESSION['flights_infants']=$uri[9];
    };

    // FLIGHT TYPE
    if ($_SESSION['flights_type'] == "oneway") {
        $flight_type = "oneway";
    } elseif ($_SESSION['flights_type'] == "return") {
        $flight_type = "round";
    } elseif ($_SESSION['flights_type'] == "multi") {
        $flight_type = "multi";
    }

    if (isset($_SESSION['phptravels_client']->user_id)){
    $user_id=$_SESSION['phptravels_client']->user_id;
    } else {
    $user_id="";
    }

    // FLIGHT RETURN DATE
    isset($_SESSION['flights_returning_date'])?$return_date=$_SESSION['flights_returning_date']:$return_date="";

    if ($uri[1] == "multiway"){
        $_SESSION['flights_origin']=$uri[1];
        $_SESSION['flights_destination']=$uri[2];
        $_SESSION['flights_type']=$uri[3];
        $_SESSION['flights_class']=$uri[4];
        $_SESSION['flights_departure_date']=$uri[5];
        $_SESSION['flights_returning_date']=$uri[6];
        $_SESSION['flights_adults']=$uri[7];
        $_SESSION['flights_childs']=$uri[8];
        $_SESSION['flights_infants']=$uri[9];
    };
    
    // META DETAILS
    $meta = array(
        "title" => "Flights Result",
        "meta_title" => "Flights Result",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "adults"=>$_SESSION['flights_adults'],
        "childs"=>$_SESSION['flights_childs'],
        "infants"=>$_SESSION['flights_infants'],
        "type"=>$_SESSION['flights_type'],
        "nav_menu" => $nav_menu,
    );

    // SEARCH PARAMS
    $params = array(
        "origin"=>$_SESSION['flights_origin'],
        "destination"=>$_SESSION['flights_destination'],
        "departure_date"=>$_SESSION['flights_departure_date'],
        "return_date"=>$return_date,
        "adults"=>$_SESSION['flights_adults'],
        "children"=>$_SESSION['flights_childs'],
        "infants"=>$_SESSION['flights_infants'],
        "type"=>$flight_type,
        "currency"=>currency,
        "class_type"=>$_SESSION['flights_class'],
        "ip"=>user_ip(),
        "user_id"=>$user_id,
    );


    $duration_time = (duration * 60);
    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $duration_time)) {
        unset($_SESSION["data_flight"]);
        unset($_SESSION["url"]);
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
        $RESPONSE = POST(api_url . 'flights/search', $params);
        if (!empty($RESPONSE)) {
            $meta['data'] = $RESPONSE;
            $_SESSION['data_flight'] = $RESPONSE;
            $_SESSION['url'] = explode('""',$actual_link);
            $_SESSION['last_activity'] = time();
        } else {
            $meta['data'] = [];
        }
    }else{
        $meta['data']=$_SESSION['data_flight'];
        $_SESSION['url'] = explode('""',$actual_link);
    }

    views($meta,"Flights/Flights");
    
// ADD SEARCH TO SESSION
// SEARCH_SESSION($MODULE=T::flights_flights,$CITY=strtoupper($uri[3])."<i class='la la-arrow-right px-1'></i>".strtoupper($url[4]));

});

// ======================================================== FLIGHTS BOOKING

$router->post('(flights)/booking', function($nav_menu) {
    
    CSRF();

    $payload = json_decode(base64_decode($_POST['payload']));
    $routes = json_decode(base64_decode($_POST['routes']));
    $travellers = json_decode(base64_decode($_POST['travellers']));
        
    // META DETAILS
    $meta = array(
        "title" => "Flights Booking",
        "meta_title" => "Flights Booking",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "data"=>$payload,
        "routes"=>$routes,
        "travellers"=>$travellers,
        "nav_menu" => $nav_menu,
    );

    // CHECK USER SESSION
    function user_id()
    { if (isset($_SESSION['phptravels_client']->user_id)) {
        return $_SESSION['phptravels_client']->user_id;} else { return "0";}
    } $user_id = user_id();

    views($meta, "Flights/Booking");

});

// ======================================================== FLIGHTS BOOKING


// ======================================================== FLIGHTS BOOK

$router->post('(flights)/book', function() {

    CSRF();
    // $payload = json_decode(base64_decode($_POST['payload']));
    $routes = json_decode(base64_decode($_POST['routes']));
    $traveller = json_decode(base64_decode($_POST['travellers']));

    // dd($_POST);

    // ADULTS
    $data = [];
    for ($i = 1; $i <= $traveller->adults; $i++) {
    array_push($data, (object) array(
    'traveller_type'=>$_POST["traveller_type_".$i],
    'title'=>$_POST["title_".$i],
    'first_name'=>$_POST["first_name_".$i],
    'last_name'=>$_POST["last_name_".$i],
    'nationality'=>$_POST["nationality_".$i],
    'dob_day'=>$_POST["dob_day_".$i],
    'dob_month'=>$_POST["dob_month_".$i],
    'dob_year'=>$_POST["dob_year_".$i],
    'passport'=>$_POST["passport_".$i],
    'passport_day_expiry'=>$_POST["passport_day_expiry_".$i],
    'passport_month_expiry'=>$_POST["passport_month_expiry_".$i],
    'passport_year_expiry'=>$_POST["passport_year_expiry_".$i],
    'passport_issuance_day'=>$_POST["passport_issuance_day_".$i],
    'passport_issuance_month'=>$_POST["passport_issuance_month_".$i],
    'passport_issuance_year'=>$_POST["passport_issuance_year_".$i]
    ));
    }

    // CHILDS
    for ($x = 1; $x <= $traveller->childs; $x++) {
    $adults = $traveller->adults;
    array_push($data, (object) array(
    'traveller_type'=>$_POST["traveller_type_".$x+$adults],
    'title'=>$_POST["title_".$x+$adults],
    'first_name'=>$_POST["first_name_".$x+$adults],
    'last_name'=>$_POST["last_name_".$x+$adults],
    'nationality'=>$_POST["nationality_".$x+$adults],
    'dob_day'=>$_POST["dob_day_".$x+$adults],
    'dob_month'=>$_POST["dob_month_".$x+$adults],
    'dob_year'=>$_POST["dob_year_".$x+$adults],
    'passport'=>$_POST["passport_".$x+$adults],
    'passport_day_expiry'=>$_POST["passport_day_expiry_".$x+$adults],
    'passport_month_expiry'=>$_POST["passport_month_expiry_".$x+$adults],
    'passport_year_expiry'=>$_POST["passport_year_expiry_".$x+$adults],
    'passport_issuance_day'=>$_POST["passport_issuance_day_".$x+$adults],
    'passport_issuance_month'=>$_POST["passport_issuance_month_".$x+$adults],
    'passport_issuance_year'=>$_POST["passport_issuance_year_".$x+$adults],
    ));
    }

    // INFANTS
    for ($b = 1; $b <= $traveller->infants; $b++) {
    $a = $traveller->childs+$traveller->adults;
    array_push($data, (object) array(
    'traveller_type'=>$_POST["traveller_type_".$b+$a],
    'title'=>$_POST["title_".$b+$a],
    'first_name'=>$_POST["first_name_".$b+$a],
    'last_name'=>$_POST["last_name_".$b+$a],
    'nationality'=>$_POST["nationality_".$b+$a],
    'dob_day'=>$_POST["dob_day_".$b+$a],
    'dob_month'=>$_POST["dob_month_".$b+$a],
    'dob_year'=>$_POST["dob_year_".$b+$a],
    'passport'=>$_POST["passport_".$b+$a],
    'passport_day_expiry'=>$_POST["passport_day_expiry_".$b+$a],
    'passport_month_expiry'=>$_POST["passport_month_expiry_".$b+$a],
    'passport_year_expiry'=>$_POST["passport_year_expiry_".$b+$a],
    'passport_issuance_day'=>$_POST["passport_issuance_day_".$b+$a],
    'passport_issuance_month'=>$_POST["passport_issuance_month_".$b+$a],
    'passport_issuance_year'=>$_POST["passport_issuance_year_".$b+$a],
    ));
    }
    $guests = json_encode($data,JSON_PRETTY_PRINT);

    // CHECK USER SESSION
    function user_id()
    { if (isset($_SESSION['phptravels_client']->user_id)) {
    return $_SESSION['phptravels_client']->user_id;} else { return "0";}
    } $user_id = user_id();

    $count = count($routes->segments[0]);
    $seg_index = $count-1;
    if($seg_index != 0){
        $arrivel_date = $routes->segments[0][$seg_index]->arrival_date;
    }else{
        $arrivel_date = $routes->segments[0][0]->arrival_date;
    }

    $array = array(
    'module_type' => 'flights',
    "price_original"=>$routes->segments[0][0]->price,
    "flight_type"=>$routes->segments[0][0]->type,
    "price_markup"=>$routes->segments[0][0]->price,
    "checkin"=>$routes->segments[0][0]->departure_date,
    "checkout" => $arrivel_date,
    "payment_gateway" => ($_POST['payment_gateway']),
    "adults"=>$traveller->adults,
    "childs"=>$traveller->childs,
    "infants"=>$traveller->infants,
    "currency_original"=>$routes->segments[0][0]->currency,
    "currency_markup"=>$routes->segments[0][0]->currency,
    "booking_data"=>json_encode($routes->segments[0][0]->booking_data, JSON_PRETTY_PRINT),
    "supplier"=>$routes->segments[0][0]->supplier,
    "user_id"=>$user_id,
    "user_data"=>json_encode($_POST['user'], JSON_PRETTY_PRINT),
    "guest"=>($guests),
    "routes"=>json_encode($routes, JSON_PRETTY_PRINT),
    );

    $RESPONSE=POST(api_url.'flights/book',$array);

    // dd($RESPONSE->booking_ref_no);

    if(isset($RESPONSE->booking_ref_no)){
        $_SESSION['booking_celebration'] = true;
        REDIRECT(root.'flights/invoice/'.$RESPONSE->booking_ref_no);
    } else {
        echo "<script>There was some problem with the booking redirecting to homepage</script>";
        REDIRECT(root);
    }

});

// ======================================================== FLIGHTS BOOK

?>