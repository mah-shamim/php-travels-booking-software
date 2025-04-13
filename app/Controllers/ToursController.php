<?php 

/* ---------------------------------------------- */
// TOURS INDEX PAGE
/* ---------------------------------------------- */
$router->get('(tours)', function ($nav_menu) {
  
    // META DETAILS
    $meta = array(
        "title" => "Tours",
        "meta_title" => "Tours",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
    );

    views($meta,"Tours/Index");

});

// ======================================================== TOURS INVOCE

$router->get('/(tours)/invoice/(\d+)', function($nav_menu,$id) { 

    // SEARCH PARAMS
    $params = array( "booking_ref_no"=>$id,);
    $RESPONSE=POST(api_url.'tours/invoice',$params);

    if(empty($RESPONSE->response)){
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => "Tours Invoice",
        "meta_title" => "Tours invoice",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        "data" => $data->response[0]
    );

    views($meta,"Tours/Invoice");

});

// ======================================================== TOURS INVOICE

// ======================================================== TOURS SEARCH RESULTS
$router->get('/(tours)/(.*)', function($nav_menu,$uri) {

    $url = explode('/', $uri);
    $count = count($url);
    if ($count < 4 ) { REDIRECT(root); }

    $location_id = $url[0];
    $location = $url[1];
    $date = $url[2];
    $adults = $url[3];
    $childs = $url[4];

    // GET PAGINATION NUMBER
    if(!empty($url[5])){
        $page_number = $url[5];
    }else{
        $page_number =1;
    }
    
    // SEARCH PARAMS
    $params = array(
        "location" => $location,
        "date" => $date,
        "adults" => $adults,
        "childs" => $childs,
        "language" => "en",
        "currency" => currency,
        "ip" => user_ip(),
        "pagination" => $page_number,
    );

    // META DETAILS
    $meta = array(
        "title" => T::tours.' - '.ucfirst($location),
        "meta_title" => T::tours.' - '.ucfirst($location),
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "date" =>  $date,
        "adults" => $adults,
        "childs" => $childs,
        "nav_menu" => $nav_menu,
        "page_number" => $page_number,
        "location" => $location,
        "ip" => user_ip(),
    );

//    $duration = (duration * 60);
//    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $duration)) {
//        unset($_SESSION["related_tours"]);
//        unset($_SESSION["url"]);
//        unset($_SESSION["data_tours"]);
//    }
//
//    if (!empty($_SESSION['url'])) {
//        $a1 = $_SESSION['url'];
//        $check = 1;
//        $url_check = array_diff($a1, explode('""', $actual_link));
//        if (!empty($url_check)) {
//            $check = 0;
//        }
//    } else {
//        $check = 0;
//    }
//
//    if($check == 0){
        // $RESPONSE=POST(api_url.'tours/search',$params);
        // if(isset($RESPONSE)){
        //     $meta['data']=$RESPONSE;
        //     // ADD RESULTS TO SESSION
        //     $_SESSION['related_tours'] = $RESPONSE;
        //     $_SESSION['data_tours'] = $RESPONSE;
        //    // $_SESSION['url'] = explode('""',$actual_link);
        //     //$_SESSION['last_activity'] = time();
        // }
//    }else{
//        $meta['data']=$_SESSION['data_tours'];
//        $_SESSION['related_tours'] = $_SESSION['data_tours'];
//        $_SESSION['url'] = explode('""',$actual_link);
//    }
    // ADD SEARCH CRITERIA TO SESSION

    $_SESSION['tours_location_id'] = $location_id;
    $_SESSION['tours_location'] = $location;
    $_SESSION['tours_date'] = $date;
    $_SESSION['tours_adults'] = $adults;
    $_SESSION['tours_childs'] = $childs;

    views($meta,"Tours/Tours");

});
// ======================================================== TOURS SEARCH RESULTS

// ======================================================== TOURS DETAILS RESULT

$router->get('/(tour)/(.*)', function($nav_menu,$url) {
        
    $url = explode('/', $_GET['url']);
    $count = count($url);if ($count < 5) {echo "";}

    $tour_id = $url[1];
    $supplier = $url[2];
    $date = $url[3];
    $adults = $url[4];
    $childs = $url[5];
    
    // GET MODULE CREDENTIALS
    $module = array_column(base()->modules, null, 'name')[$supplier];

    //SEARCH PARAMS
    $params = array(
        "tour_id"=>$tour_id,
        "currency"=>currency,
        "date" => $date,
        "adults" => $adults,
        "childs"=>$childs,
        "supplier"=>$supplier,
        "language"=>"en",
        "c1"=>($module->c1),
        "c2"=>($module->c2),
        "c3"=>($module->c3),
        "c4"=>($module->c4),
        "c5"=>($module->c5),
        "c6"=>($module->c6),
    );

    // META DETAILS
    $meta_ = array();

    // SEARCH REQUEST
    if ($supplier=="tours"){
    $RESPONSE=POST(api_url.'tour/details',$params);
    }else{
    $API_URL = "https://api.phptravels.com/tours/".$supplier."/api/v1/detail";
    $RESPONSE=POST_MODULES($API_URL,$params); 
    }

    // dd($params);

    $mods = array();
    foreach (base()->modules as $i => $m){

        if ($m->type=="tours"){

            $arrs = array(
            "name"=>$m->name,
            "c1"=>$m->c1,
            "c2"=>$m->c2,
            "c3"=>$m->c3,
            "c4"=>$m->c4,
            "c5"=>$m->c6,
            "c6"=>$m->c6,
            );

            array_push($mods,$arrs);

        }
    };

    // dd($gateway);

    if(isset($RESPONSE)){

    $meta_['data']=$RESPONSE;

    }
    $tour_name = $meta_['data']->name ?? "";
    $name = $meta_['data']->name ?? "";
    $desc = $meta_['data']->name ?? "";
    $data = $meta_['data'] ?? "";
    $img = isset($meta_['data']->img[0]) ? $meta_['data']->img[0] : "";

    // META DETAILS
    $meta = array(
        "title" => T::tour.' '.$tour_name,
        "meta_title" => T::tour.' '.$name,
        "meta_desc" => T::tour.' '.$desc,
        "meta_img" => T::tour.' '.$img,
        "meta_url" => "",
        "meta_author" => "",
        "date" => $date,
        "adults" => $adults,
        "childs" => $childs,
        "nationality" => "",
        "data"=> $data,
        "nav_menu" => $nav_menu,

    );

    views($meta, "Tours/Details");

});

// ======================================================== TOURS DETAILS RESULT

// ======================================================== HOTELS BOOKING

$router->post('(tours)/booking', function($nav_menu) {
    
    CSRF();
    $hashed = json_decode(base64_decode($_REQUEST['payload']));
    $price = json_decode(base64_decode($_REQUEST['price']));
    if ($price == null) {
        $total_price = $hashed->price;
        $adults = $hashed->adults;
        $childs = $hashed->childs;
        $date = $hashed->date;
    } else {
        $total_price = $price[0];
        $adults = $price[1];
        $childs = $price[2];
        $date = $price[3];
    }
    

    $data = [
        "tours_id" => $hashed->tours_id,
        "tours_name" => $hashed->tours_name,
        "tour_img" => $hashed->tour_img,
        "tour_type" => $hashed->tour_type,
        "date" => $date,
        "adults" => $adults,
        "childs" => $childs,
        "infants" => "",
        "total_price" => $total_price,
        "actual_price" => $hashed->actual_price,
        "user_id" => "",
        "currency_original" => $hashed->currency_original,
        "currency_markup" => $hashed->currency_markup,
        "supplier" => $hashed->supplier,
        "tour_location" => $hashed->tour_location,
        "tour_latitude" => $hashed->tour_latitude,
        "tour_longitude" => $hashed->tour_longitude,
        "tour_stars" => $hashed->tour_stars,
        "booking_data" => "",
        "module_type" => $hashed->module_type,
        "cancellation_policy" => $hashed->cancellation,
    ];

    // META DETAILS
    $meta = array(
    "title" => T::bookings,
    "meta_title" => T::bookings,
    "meta_desc" => "",
    "meta_img" => "",
    "meta_url" => "",
    "meta_author" => "",
    "nationality" => "",
    "data"=> $data,
    "nav_menu" => $nav_menu,
    );

    views($meta, "Tours/Booking");

});

// ======================================================== HOTELS BOOKING

// ======================================================== HOTELS BOOK

$router->post('(tours)/book', function() {
    
    CSRF();

    $payload = json_decode(base64_decode($_POST['payload']));


    $adult_travellers = $payload->adults;
    $child_travellers = $payload->childs;

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
    'first_name' => $_POST['user']['first_name'],
    'last_name' => $_POST['user']['last_name'],
    'email' => $_POST['user']['email'],
    'address' => $_POST['user']['address'],
    'phone_country_code' => $_POST['user']['country_code'],
    'phone' => $_POST['user']['country_code'],
    "tours_id" => $payload->tours_id,
    "tours_name" => $payload->tours_name,
    "tour_img" => $payload->tour_img,
    "tour_type" => $payload->tour_type,
    "adults" => $payload->adults,
    "childs" => $payload->childs,
    "infants" => "",
    "price_markup" => $payload->total_price,
    "actual_price" => $payload->actual_price,
    "currency_original" => $payload->currency_original,
    "currency_markup" => $payload->currency_markup,
    "tour_location" => $payload->tour_location,
    "tour_latitude" => $payload->tour_latitude,
    "tour_longitude" => $payload->tour_longitude,
    "tour_stars" => $payload->tour_stars,
    "module_type" => $payload->module_type,
    
    'booking_data' => json_encode($payload->booking_data    , JSON_PRETTY_PRINT),
    'supplier' => $payload->supplier,
    'user_id' => $user_id,

    'payment_gateway' => $_POST['payment_gateway'],
    'guest' => $guest,
    "user_data"=>json_encode($_POST['user'], JSON_PRETTY_PRINT),

    );

    // FINAL BOOKING REQUEST
    $REQUEST=POST(api_url.'tours/booking', $params);

    if ($REQUEST->status == true) {
    $invoice_url = root.'tours/invoice/'.$REQUEST->booking_ref_no;
    $_SESSION['booking_celebration'] = true;
    REDIRECT($invoice_url);
    }

});

// ======================================================== HOTELS BOOK
?>