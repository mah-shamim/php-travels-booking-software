<?php

// ======================== APP
$router->post('app', function() {

    // INCLUDE CONFIG
    include "./config.php";
    AUTH_CHECK();

    // APP SETTINGS
    $data = $db->select("settings","*", []);
    $modules = $db->select("modules","*", [ "status" => 1, ]);

    // HOTELS SUGGESTIONS
    $params = array( "status" => 1, "ORDER" => [ "order" => "DESC", ], "LIMIT"=>[0,50] );

    $hotels_suggestions = $db->select("hotels_suggestions",[
        "[>]locations" => ["city"=>"city"]
    ],[
        "locations.country",
        "locations.id",
        "hotels_suggestions.city",
        "hotels_suggestions.status",
        "hotels_suggestions.order",
    ],
    [ "hotels_suggestions.status" => 1 ,"ORDER" => ["hotels_suggestions.order" => "DESC"]]
    );
    // $cars_suggestions = $db->select("cars_suggestions",[
    //     "[>]locations" => ["city"=>"city"]
    // ],[
    //     "locations.country",
    //     "locations.id",
    //     "cars_suggestions.city",
    //     "cars_suggestions.status",
    //     "cars_suggestions.order",
    // ],
    // [ "cars_suggestions.status" => 1 ,"ORDER" => ["cars_suggestions.order" => "DESC"]]
    // );


    $cars_suggestions = $db->select("cars_suggestions",[
        "[>]flights_airports" => ["city_airport"=>"code"]
    ],[
        "flights_airports.country",
        "flights_airports.airport",
        "flights_airports.city",
        "cars_suggestions.city_airport",
        "cars_suggestions.status",
    ],
    [ "cars_suggestions.status" => 1 ,"ORDER" => ["cars_suggestions.order" => "ASC"]]
    );


    

    $tours_suggestions = $db->select("tours_suggestions",[
        "[>]locations" => ["city"=>"city"]
    ],[
        "locations.country",
        "locations.id",
        "tours_suggestions.city",
        "tours_suggestions.status",
        "tours_suggestions.order",
    ],
    [ "tours_suggestions.status" => 1 ,"ORDER" => ["tours_suggestions.order" => "DESC"]]
    );

    $featured_data = $db->query("SELECT
    origin.city AS origin,
    destination.city AS destination,
    `flights_featured`.`status` AS status,
    `flights_featured`.`price` AS price,
    `flights_featured`.`from_airport` AS origin_code,
    `flights_featured`.`to_airport` AS destination_code,
    `flights_featured`.`airline` AS airline,
    `flights_featured`.`id` AS id,
    airline.name AS airline_name
    FROM `flights_featured`
    JOIN `flights_airports` AS origin ON from_airport = origin.code
    JOIN `flights_airports` AS destination ON to_airport = destination.code
    JOIN `flights_airlines` AS airline ON airline = airline.code"
    )->fetchAll();

    foreach ($featured_data as $value){

        if ($value['status']==1){

            $default_currency = $db->select("currencies", "*", ["status" => 1,"default"=>1]);
            if(!empty($_POST["currency"])){
                $currency = $_POST["currency"];
            }else{
                $currency = $default_currency[0]['name'];
            }
            $current_currency_price =  $db->select("currencies", "*", ["name" => $default_currency[0]['name']]);
            // Get the exchange rate for the user's selected currency

            if (!empty($value['price']) && !empty($current_currency_price)) {
               $price = ceil(str_replace(',', '', $value['price']) / $current_currency_price[0]['rate']);
            } else {
                $price = 0;
            }
            $con_rate = $db->select("currencies", "*", ["name" => $currency]);
            $con_price = $price * $con_rate[0]['rate'];

            $featured_flight[] = array(
                "id"=>$value['id'],
                "origin_code"=>$value['origin_code'],
                "origin"=>$value['origin'],
                "destination_code"=>$value['destination_code'],
                "destination"=>$value['destination'],
                "price"=>number_format((float) $con_price, 2, '.', ''),
                "airline_name"=>$value['airline_name'],
                "airline"=>$value['airline'],
            );

        }

    }

    // TO PREVENT FROM FEATURED FLIGHTS ERROR
    empty($featured_flight)?$featured_flight="":$featured_flight=$featured_flight;
     
    $flights_suggestion = $db->select("flights_suggestions",[
        "[>]flights_airports" => ["city_airport"=>"code"]
    ],[
        "flights_airports.country",
        "flights_airports.airport",
        "flights_airports.city",
        "flights_suggestions.city_airport",
        "flights_suggestions.type",
        "flights_suggestions.status",
    ]);

    foreach ($flights_suggestion as $value){
        if ($value['status']==1){
            $flights_suggestions[] = array(
                "country"=>$value['country'],
                "airport"=>$value['airport'],
                "city"=>$value['city'],
                "city_airport"=>$value['city_airport'],
                "type"=>$value['type'],
                "type"=>$value['type'],
            );
        }
    }    

    // TO PREVENT FROM SUGGESTIONS FLIGHTS ERROR 
    empty($flights_suggestions)?$flights_suggestions="":$flights_suggestions=$flights_suggestions;


    // CURRENCIES
     $currencies = $db->select("currencies", [
         "[>]countries" => ["country" => "iso"]
    ], [
        "countries.nicename",
        "currencies.name",
        "currencies.default",
        "currencies.status",
        "countries.iso",
    ],[ "status" => 1, ]);

    $languages = $db->select("languages","*", [ "status" => 1, ]);
    $payment_gateways = $db->select("payment_gateways","*", [ "status" => 1, ]);

    // FEATURE TOURS
    $featured_tours = $db->select("tours",  
   [
       "tours.id",
       "tours.tour_basic_price",
       "tours.module",
       "tours.name",
       "tours.img",
       "tours.location",
       "tours.stars",
       "tours.status",
   ],[ 
    "tours.status" => 1,
    "tours.featured" => 1,
    "ORDER" => [ "id" => "ASC" ]
   ]);
   $tours = array();
   foreach ($featured_tours as $value){
   
   $default_currency = $db->select("currencies", "*", ["status" => 1,"default"=>1]);
   if(!empty($_POST["currency"])){
       $currency = $_POST["currency"];
   }else{
       $currency = $default_currency[0]['name'];
   }
   $current_currency_price =  $db->select("currencies", ["rate"], ["name" => $default_currency[0]['name']]);
   // Get the exchange rate for the user's selected currency

   if (!empty($value['tour_basic_price']) && !empty($current_currency_price)) {
      $price = ceil(str_replace(',', '', $value['tour_basic_price']) / $current_currency_price[0]['rate']);
   } else {
       $price = 0;
   }
   $con_rate = $db->select("currencies", "*", ["name" => $currency]);
   $con_price = $price * $con_rate[0]['rate'];
 
   if ($con_price != 0){
       $tours[] = (object)[
           "id"=>$value['id'],
           "basic_price"=>$value['tour_basic_price'],
           "adult"=>2,
           "child"=>0,
           "infants"=>0,
           "supplier"=>$value['module'],
           "name"=>$value['name'],
           "img"=>$value['img'],
           "location"=>$value['location'],
           "stars"=>$value['stars'],
           "status"=>$value['status'],
           "price"=>number_format((float) $con_price, 2),
           ];
       }
   }
//    FEATURE CARS
   $featured_cars = $db->select("cars",  
     [
         "cars.id",
         "cars.price",
         "cars.module",
         "cars.currency",
         "cars.name",
         "cars.img",
         "cars.airport_code",
         "cars.stars",
         "cars.status",
     ],[ 
      "cars.status" => 1,
      "cars.featured" => 1,
      "ORDER" => [ "id" => "ASC" ]
     ]);
     $cars = array();
     foreach ($featured_cars as $value){
     
     $default_currency = $db->select("currencies", "*", ["status" => 1,"default"=>1]);
     if(!empty($_POST["currency"])){
         $currency = $_POST["currency"];
     }else{
         $currency = $default_currency[0]['name'];
     }
     $current_currency_price =  $db->select("currencies", ["rate"], ["name" => $default_currency[0]['name']]);
     // Get the exchange rate for the user's selected currency
  
     if (!empty($value['price']) && !empty($current_currency_price)) {
        $price = ceil(str_replace(',', '', $value['price']) / $current_currency_price[0]['rate']);
     } else {
         $price = 0;
     }
     $con_rate = $db->select("currencies", "*", ["name" => $currency]);
     $con_price = $price * $con_rate[0]['rate'];
   
     if ($con_price != 0){
         $cars[] = (object)[
             "id"=>$value['id'],
             "cars_price"=>$value['price'],
             "adult"=>2,
             "child"=>0,
             "infants"=>0,
             "supplier"=>$value['module'],
             "currency"=>$value['currency'],
             "name"=>$value['name'],
             "img"=>$value['img'],
             "location"=>$value['airport_code'],
             "stars"=>$value['stars'],
             "status"=>$value['status'],
             "price"=>number_format((float) $con_price, 2),
             ];
         }
     }

    // FEATURED HOTELS
    $featured_hotels = $db->select("hotels", [
         "[>]locations" => ["location" => "city"]
    ], 
    [
        "hotels.id",
        "locations.city",
        "locations.country",
        "hotels.name",
        "hotels.img",
        "hotels.location",
        "hotels.stars",
        "hotels.status",
    ],[ 
        "hotels.status" => 1,
        "hotels.featured" => 1,
        "ORDER" => [ "id" => "ASC" ]
    ]);

    $hotels = array();
    foreach ($featured_hotels as $value){

        $room_data = $db->select('hotels_rooms', [
            "[>]hotels_rooms_options" => ["id" => "room_id"]
        ], [
                'hotels_rooms_options.price'
            ], ['hotel_id' => $value['id']]);
    
    $default_currency = $db->select("currencies", "*", ["status" => 1,"default"=>1]);
    if(!empty($_POST["currency"])){
        $currency = $_POST["currency"];
    }else{
        $currency = $default_currency[0]['name'];
    }
    $current_currency_price =  $db->select("currencies", ["rate"], ["name" => $default_currency[0]['name']]);
    // Get the exchange rate for the user's selected currency

    if (!empty($room_data[0]['price']) && !empty($current_currency_price)) {
       $price = ceil(str_replace(',', '', $room_data[0]['price']) / $current_currency_price[0]['rate']);
    } else {
        $price = 0;
    }
    $con_rate = $db->select("currencies", "*", ["name" => $currency]);
    $con_price = $price * $con_rate[0]['rate'];
    
    if ($price != 0){
        $hotels[] = (object)[
            "id"=>$value['id'],
            "city"=>$value['city'],
            "country"=>$value['country'],
            "name"=>$value['name'],
            "img"=>$value['img'],
            "location"=>$value['location'],
            "stars"=>$value['stars'],
            "status"=>$value['status'],
            "price"=>number_format((float) $con_price, 2),
            ];
        }
    }

    // CMS
    $cms = $db->select("cms", [
        "[>]cms_menu" => ["menu_id" => "id"]
   ], [
       "cms_menu.name",
       "cms.page_name",
       "cms.slug_url",
 
   ],[ "status" => 1, ]);

    // BLOG
//     $blog = $db->select("blogs", [
//         "[>]blog_categories" => ["post_category" => "id"]
//    ], [
//        "blog_categories.cat_name",
//        "blogs.post_title",
//        "blogs.post_slug",
//        "blogs.post_img",
//        "blogs.id",

//    ],[ "status" =>1 ,"ORDER"=>['blogs.id'=>"DESC"]]
//     );

    // BLOG
    $blog = $db->select("blogs", [
        "blogs.post_title",
        "blogs.post_slug",
        "blogs.post_img",
        "blogs.id",

    ],[ "status" =>1 ,"LIMIT"=>3,"ORDER"=>['blogs.id'=>"DESC"]]
    );

    // BLOG
    // $blog = $db->select("blogs","*",[ "LIMIT"=>3,"status" =>1 ,"ORDER"=>['id'=>"DESC"]]);

    $respose = array ( "status"=> true, "message"=>"app main response",
    "data"=>array(
        "app"=> $data[0],
        "modules"=> $modules,
        "currencies"=> $currencies,
        "languages"=> $languages,
        "featured_hotels"=> $hotels,
        "featured_tours"=> $tours,
        "featured_cars"=> $cars,
        "hotels_suggestions"=> $hotels_suggestions,
        "cars_suggestions"=> $cars_suggestions,
        "tours_suggestions"=> $tours_suggestions,
        "featured_flights"=> $featured_flight,
        "flights_suggestions"=> $flights_suggestions,
        "payment_gateways"=> $payment_gateways,
        "cms"=> $cms,
        "featured_blog"=> $blog,
    ),
    );

echo json_encode($respose);

});
// ======================== APP

// ======================== CMS PAGES
$router->post('cms_page', function() {

    // INCLUDE CONFIG
    include "./config.php";

    // PARAMS
    $params = array(
        "slug_url[~]"=> $_POST['slug_url'],
      );

    // PAGE
    $data = $db->select("cms","*", $params);
    $data[0]['content']=htmlentities($data[0]['content']);
    $respose = array ( "status"=>true, "message"=>"CMS page data", "data"=> $data );

echo json_encode($respose);

});
// ======================== CMS PAGES

// ======================== Locations
$router->get('hotels_locations', function() {

    // INCLUDE CONFIG
    include "./config.php";

    // PARAMS
    $params = array(
        "status" => 1,
        "city[~]"=> $_GET['city'],
        "ORDER" => [ "id" => "DESC", ],
        "LIMIT" => 50
    );

    // LOCATIONS
    $data = $db->select("locations","*", $params );

    $respose = array ( "status"=>true, "message"=>"locations data", "data"=> $data );

echo json_encode($respose);

});

// ======================== TOURS LOCATIONS
$router->get('tours_locations', function() {

    // INCLUDE CONFIG
    include "./config.php";

    // PARAMS
    $params = array(
        "status" => 1,
        "city[~]"=> $_GET['city'],
        "ORDER" => [ "id" => "DESC", ],
        "LIMIT" => 50
    );

    // LOCATIONS
    $data = $db->select("locations","*", $params );

    $respose = array ( "status"=>true, "message"=>"locations data", "data"=> $data );

    echo json_encode($respose);

});
// ======================== TOURS LOCATIONS

// ======================== FLIGHTS LOCATIONS
$router->get('flights_locations', function() {

        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://www.kayak.com/mvm/smartyv2/search?f=j&s=airportonly&where='.$_GET['city'],
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // ));
        // $data = curl_exec($curl);
        // curl_close($curl);
        // echo ($data);
        
        // INCLUDE CONFIG
        include "./config.php";

        // PARAMS
        $params = array(
            "status" => 1,
            "code[=]"=> $_GET['city'],
            "ORDER" => [ "id" => "DESC", ],
            "LIMIT" => 50
        );

        // LOCATIONS
        $data = $db->select("flights_airports","*", $params );

        if (empty($data)) {

         // PARAMS
        $params = array(
            "status" => 1,
            "city[~]"=> $_GET['city'],
            "ORDER" => [ "id" => "DESC", ],
            "LIMIT" => 50
        );
        $data = $db->select("flights_airports","*", $params );
        echo json_encode(utf8ize($data));
        die;

        }

        $respose = array ( "status"=>true, "message"=>"locations data", "data"=> $data );
        echo json_encode(utf8ize($data));

});

function utf8ize( $mixed ) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } elseif (is_string($mixed)) {
        return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
    }
    return $mixed;
}
// ======================== FLIGHTS LOCATIONS 

// ======================== NEWSLETTER
$router->post('newsletter-subscribe', function() {

    // INCLUDE CONFIG
    include "./config.php";

    required('name');
    required('email');

    // EMAIL EXIST VALIDATION
    $exist_mail = $db->select('newsletter', [ 'email', ], [ 'email' => $_POST['email'], ]);
    if (isset($exist_mail[0]['email'])) { 
        $respose = array ( "status"=>false, "message"=>"email already exist.", "data"=> "" );
        echo json_encode($respose);
        die;
    }

    $datetime = date("Y-m-d h:i:sa");

    // PARAMS
    $params = array(
        "name" => $_POST['name'],
        "email"=> $_POST['email'],
        "created_at"=> $datetime,
    );

    $data = $db->insert("newsletter", $params );

    $respose = array ( "status"=>true, "message"=>"newsletter email subscribed", "data"=> $data);

    // HOOK 
    $name=$_POST['name'];
    $email=$_POST['email'];

    $hook="newsletter_subscribe";
    include "./hooks.php";

    echo json_encode($respose);

});
// ======================== NEWSLETTER




?>