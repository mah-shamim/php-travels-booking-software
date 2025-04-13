<?php
// HEADERS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("X-Frame-Options: SAMEORIGIN");

/*==================
THIS FUNCTION RETRIEVES A LIST OF ALL ACTIVE HOTEL MODULES
==================*/
function gethotelmodules()
{
    $conn = openconn(); // Open a connection to the database. 
// Select all modules of type 'hotels' from the database
    $respose = $conn->select("modules", ['id', 'name'], ["type" => 'hotels', 'status' => 1]);
    // Create an empty array to store the module data
    $data = [];
    // Loop through the results and add any active modules (excluding the 'flights' module itself)
    foreach ($respose as $module) {
        if ($module['name'] != 'hotels') {
            $data[] = array(
                'name' => $module['name'],
                'id' => $module['id']
            );
        }
    }
    // Return the list of active modules
    return $data;
}

/*==================
THIS FUNCTION RETRIEVES THE HOTEL MODULES DATA FROM DATABASE
==================*/
function gethotelmoduledata($modulename)
{
    $conn = openconn(); // Open a connection to the database.
    // Use the database connection to select data from the 'modules' table where the name matches the input.
    $response = $conn->select("modules", "*", ["name" => $modulename]);
    // Return the results.
    return $response;
}

/*==================
THIS FUNCTION IS USED TO SEND A CURL REQUEST TO FETCH THE DATA OF OTHER API'S BY PASSING THE REQUIRED PARAMETERS
==================*/
function sendhotelRequest($req_method = 'GET', $service = '', $payload = [], $_headers = [])
{
    // Get the URL from the payload and remove it from the array
    $url = $payload['endpoint'];
    unset($payload['endpoint']);

    // Set up cURL options
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
    curl_setopt($curl, CURLOPT_ENCODING, ""); // Handle all encodings
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10); // Follow up to 10 redirects
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // Time out after 30 seconds
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); // Use HTTP/1.1

    // Set the request method and payload

    if ($req_method == 'POST') {
        curl_setopt($curl, CURLOPT_POST, true); // Use POST method
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload); // Include payload in request
    } else {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); // Use GET method
        $url = $url . "?" . http_build_query($payload); // Add payload to URL as query string
    }

    // Set headers
    $headers[] = "cache-control: no-cache"; // Add default cache control header
    if (!empty($headers)) {
        $headers = array_merge($headers, $_headers); // Merge additional headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); // Set headers in request
    }
    // Set the URL and execute the request
    curl_setopt($curl, CURLOPT_URL, $url);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    // Handle errors
    if ($err) {
        $response = $err;
    }

    // Return the response or error message
    return $response;
}

/*==================
THIS FUNCTION IS USED TO SET THE MARKUP PRICE
==================*/
function markup_price($module_id, $price, $date, $location)
{
    $conn = openconn();
    $markup = $conn->select('markups', "*", ['type' => 'hotels', 'module_id' => $module_id, 'status' => 1]);
    $response = '';
    if (!empty($markup)) {
        //THIS CODE CHECKS IF THE DATES ARE PRESENT OR NOT AND MAKES A SAME FORMAT OF DATE
        $city_id = $conn->select('locations', ['id'], ['city' => $location]);
        $city_id = ($city_id[0]['id'] != null) ? $city_id[0]['id'] : "";
        $checkin = new DateTime($date[0]);
        $checkout = new DateTime($date[1]);
        if (($markup[0]['from_date'] != null && $markup[0]['to_date'] != null)) {
            $from_date = new DateTime($markup[0]['from_date']);
            $to_date = new DateTime($markup[0]['to_date']);
        } else {
            $from_date = "";
            $to_date = "";
        }

        if ((($from_date <= $checkin && $to_date >= $checkout) || $markup[0]['location'] == $city_id) && $markup[0]['user_id'] == null) {
            $response = $price + ($markup[0]['b2c_markup'] * $price) / 100;
        } else if ($markup[0]['user_id'] != null) {
            $response = $price + ($markup[0]['b2b_markup'] * $price) / 100;
        } else {
            $response = ($markup[0]['b2c_markup'] != null) ? $price + ($markup[0]['b2c_markup'] * $price) / 100 : $price + ($markup[0]['user_markup'] * $price) / 100;
        }
    } else {
        $response = $price;
    }
    return $response;
}

// ======================== APP
$router->post('featured', function () {

    // INCLUDE CONFIG
    include "./config.php";
    AUTH_CHECK();

    $params = array(
        "status" => 1,
        "listing_type" => "hotels",
    );

    $response = $db->select("hotels", "*", $params);
    echo json_encode($response);

});

/*==================
HOTEL SEARCH API
==================*/
$router->post('hotel_search', function () {

    // INCLUDE CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('city');
    required('checkin');
    required('checkout');
    required('nationality');
    required('adults');
    required('childs');
    required('rooms');
    required('currency');

    //SAVING DATA FOR AUTHENTICATION PURPOSE
    $location_id = $_POST["city"];
    $currency_id = $_POST["currency"];
    $checkin_date = $_POST["checkin"];
    $checkout_date = $_POST["checkout"];


    $rate = $db->select("currencies", ['rate'], ["name" => $currency_id]); // GET RATE FROM CURRENCIES TABLE
    $days = str_replace("-", "", date("Y-m-d", strtotime($_POST['checkout']))) - str_replace("-", "", date("Y-m-d", strtotime($_POST['checkin']))); //CALULATING DAYS
    $city_data = $db->select("locations", "*", ["city[~]" => $location_id]); // GET CITY DATA FROM THE DATABASE
    (isset($city_data[0]['id'])) ? $city_id = $city_data[0]['city'] : $city_id = ""; // CONDITION IF CITY ID DO NOT EXIST

    // GET DATA OF LOCATION TABLE AND HOTEL TABLE FROM DATABASE
    $hotels = $db->select(
        "hotels",
        [
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
            "hotels.location_cords",
            "hotels.address",
            "hotels.user_id"
        ],
        [
            "location" => $city_id
        ]
    );

    foreach ($hotels as $value) {
        //GET THE LOWEST PRICE OF ROOM FROM DATABASE ACCORDING TO ROOM ID AND SHOW IT IN HOTEL SEARCH RESULT
        $room_data = $db->select('hotels_rooms', [
            "[>]hotels_rooms_options" => ["id" => "room_id"]
        ], [
                'hotels_rooms_options.price'
            ], ['hotel_id' => $value['id']]);

        // CHECK IF LOCATION EXIST
        if (!empty($value['location_cords'])) {
            $cords = explode(",", $value['location_cords']);
        }
        !empty($cords[0]) ? $latitude = $cords[0] : $latitude = null; // CONDITION IF LOCATION LATITUDE CORDS EXIST
        !empty($cords[1]) ? $longitude = $cords[1] : $longitude = null; // CONDITION IF LOCATION LATITUDE CORDS EXIST
        $actual_room_price = !empty($room_data) ? $room_data[0]['price'] * $rate[0]['rate'] : 0; // CONVERTING ACCUAL PRICE ACCORDING TO USER SELECTED CURRENCY

        //GET MODULE_ID FROM MODULES TABLE
        $module = $db->select('modules', ['id', 'status','module_color'], ['name' => 'hotels', 'type' => 'hotels']);

        //THIS FUNCTION GETS THE REQUIRED PARAMETERS AND RETURNS THE MARKUP PRICE
        $markup_mprice = markup_price($module[0]['id'], $actual_room_price, array(0 => $checkin_date, 1 => $checkout_date), $city_id);
        if (!empty($rate[0]['rate'])) {
            if ($actual_room_price != null && $module[0]['status'] == 1) {
                //THIS RESPONSE IS FROM LOCAL DATABSE NAMED AS MANUAL RESPONSE
                $m_response[] = (object) [
                    "hotel_id" => $value['id'],
                    "img" => $value['img'],
                    "name" => $value['name'],
                    "location" => $value['city'] . ' ' . $value['country'],
                    "address" => $value['address'],
                    "stars" => $value['stars'],
                    "rating" => $value['stars'],
                    "latitude" => $latitude,
                    "longitude" => $longitude,
                    "actual_price" => number_format($actual_room_price * $days, 2),
                    "actual_price_per_night" => number_format($actual_room_price, 2),
                    "markup_price" => number_format($markup_mprice * $days, 2),
                    "markup_price_per_night" => number_format($markup_mprice, 2),
                    "currency" => $currency_id,
                    "booking_currency" => $currency_id,
                    "service_fee" => "0",
                    "supplier_name" => "hotels",
                    "supplier_id" => $module[0]['id'],
                    "redirect" => "",
                    "booking_data" => (object)[],
                    "color" => $module[0]['module_color'],
                ];
            }
        } else {
            $m_response = [];
        }
    }

    /*=======================
    HOTEL SEARCH RESPONSE OF OF API'S THROUGH CURL REQUEST
    =======================*/

    // Split the REQUEST_URI into an array of strings using the forward slash (/) character as the separator
    $uri = explode('/', $_SERVER['REQUEST_URI']);
    // Check if the HTTP_HOST value matches the string "localhost"
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        // Set the root variable to the concatenation of the protocol (http or https), the current HTTP_HOST value, and the first component of the REQUEST_URI array
        $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/' . $uri[1];
    } else {
        // Set the root variable to the concatenation of the protocol (http or https) and the current HTTP_HOST value
        $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    }

    $Multithreadinghotel = gethotelmodules(); // CALLS THE FUNTION TO GET ALL THE ACTIVE HOTEL MODULES
    if (!empty($Multithreadinghotel)) {
        foreach ($Multithreadinghotel as $value) {

            $getvalue = gethotelmoduledata($value['name']); // Get module data for each active module
            $module_name = $value['name'];
            $module_id = $value['id'];
            // Determine whether the module is in development or production mode
            if ($getvalue[0]['dev_mode'] == 1) {
                $env = 'production';
            } else {
                $env = 'dev';
            }

            //VALIDATION
            $param = array(
                "endpoint" => "https://api.phptravels.com/hotels/".strtolower($module_name)."/api/v1/hotel_search",
                "city" => $_POST['city'],
                "checkin" => $checkin_date,
                "checkout" => $checkout_date,
                "nationality" => $_POST['nationality'],
                "adults" => $_POST['adults'],
                "childs" => $_POST['childs'],
                "child_age" => $_POST['child_age'],
                "rooms" => $_POST['rooms'],
                "language" => $_POST['language'],
                "currency" => $currency_id,
                'c1' => $getvalue[0]['c1'],
                'c2' => $getvalue[0]['c2'],
                'c3' => $getvalue[0]['c3'],
                'c4' => $getvalue[0]['c4'],
                'c5' => $getvalue[0]['c5'],
                "env" => $env
            );

            $c_response = (array) json_decode(sendhotelRequest('POST', 'hotel_search', $param)); //SENDING CURL REQUEST TO FETCH THE OTHER ACTIVE MODULES DATA
            foreach ($c_response as $values) {
                $actual_price = $values->price * $rate[0]['rate']; //ACTUAL PRICE OF HOTEL

                //THIS FUNCTION GETS THE REQUIRED PARAMETERS AND RETURNS THE MARKUP PRICE
                $markup_cprice = markup_price($module_id, $actual_price, array(0 => $checkin_date, 1 => $checkout_date), $city_id);

                // MAKING FINAL RESPONSE OF HOTEL SEARCH OF CURL REQUEST FOR MERGING INTO MANUAL HOTEL SEARCH
                $curl_response[] = [
                    "hotel_id" => $values->hotel_id,
                    "img" => $values->img,
                    "name" => $values->name,
                    "location" => $values->location,
                    "address" => $values->address,
                    "stars" => $values->stars,
                    "rating" => $values->rating,
                    "latitude" => $values->latitude,
                    "longitude" => $values->longitude,
                    "actual_price" => number_format($actual_price, 2),
                    "actual_price_per_night" => number_format($actual_price / $days, 2),
                    "markup_price" => number_format($markup_cprice, 2),
                    "markup_price_per_day" => number_format($markup_cprice / $days, 2),
                    "currency" => $currency_id,
                    "booking_currency" => $currency_id,
                    "service_fee" => $values->service_fee,
                    "supplier_name" => $module_name,
                    "supplier_id" => $module_id,
                    "redirect" => $values->redirect,
                    "booking_data" => $values->booking_data,
                    "color" => $module[0]['module_color'],
                ];
            }
        }
    }
    //THIS CODE CHECKS THAT MANUAL AND CURL RESPONSES ARE AVAILABLE IF AVAILABLE THEN IT MERGES THEM AND SHOW THE FINAL RESPONSE

    if (!empty($m_response) && !empty($curl_response)) {
        $response = array("status" => true, "message" => "Hotels Data", "data" => array_merge($m_response, $curl_response));
    } elseif (!empty($m_response)) {
        $response = array("status" => true, "message" => "Curl Hotels Data", "data" => $m_response);
    } elseif (!empty($curl_response)) {
        $response = array("status" => true, "message" => "Curl Hotels Data", "data" => $curl_response);
    } else {
        $response = [];
    }

    echo json_encode($response);

});

/*=======================
HOTELS_DETAILS API
=======================*/
$router->post('hotel_details', function () {

    // INCLUDE CONFIG
    include "./config.php";

    // VALIDATION
    required('hotel_id');
    required('checkin');
    required('checkout');
    required('adults');
    required('childs');
    required('child_age');
    required('rooms');
    required('language');
    required('currency');
    required('nationality');

    // SAVING DATA GOT FROM VALIDATION
    $hotel_id = $_POST["hotel_id"];
    $checkin = $_POST["checkin"];
    $checkout = $_POST["checkout"];
    $adults = $_POST["adults"];
    $childs = $_POST["childs"];
    $child_age = $_POST["child_age"];
    $rooms = $_POST["rooms"];
    $language_name = $_POST["language"];
    $currency = $_POST["currency"];
    $nationality = $_POST["nationality"];
    $supplier_name = $_POST["supplier_name"];

    $rate = $db->select("currencies", ["rate", "name"], ["name" => $currency]);
    $days = str_replace("-", "", date("Y-m-d", strtotime($_POST['checkout']))) - str_replace("-", "", date("Y-m-d", strtotime($_POST['checkin']))); //CALULATING DAYS
    //GET DATA FROM hotels_ROOMS TABLE AND hotels TABLE
    $details = $db->select("hotels", "*", [
        "id" => $hotel_id
    ]);

    if (!empty($details)) {
        // GET DATA FROM LOCATIONS TABLE AND hotels TABLE
//        $locations = $db->select(
//            "locations",
//            [
//                "[>]hotels" => ["city" => "location"]
//            ],
//            [
//                "hotels.id",
//                "locations.city",
//                "locations.country"
//            ]
//
//        );

        $locations = $db->select("locations","*",["city" => $details[0]['location']]);

        //GET DATA FROM hotels_IMAGES TABLE
        $room_imgs = $db->select("hotels_images", ['img'], ["hotel_id" => $hotel_id]);
        $room_imgs1 = "";
        foreach ($room_imgs as $value) {
            foreach ($value as $index) {
                $room_imgs1 .= $index . " ";
            }
        }

        $room_imgs_array = explode(" ", trim($room_imgs1));

        //GET HOTEL AMENITIES FROM hotels TABLE AND hotels_SETINGS TABLE
        $hotel_amenities = $db->select("hotels_amenties_fk", ['amenity_id'], ["hotel_id" => $hotel_id]);
        if (!empty($hotel_amenities[0]['amenity_id'])) {
            $test = [];
            foreach ($hotel_amenities as $values) {
//                foreach ($values as $value) {
//                    $test = str_replace('"', '', $value);
//                    $test = str_replace('[', '', $test);
//                    $test = str_replace(']', '', $test);
//                    $test = explode(',', $test);
//                }
                $hotel_amenities_array = $db->select("hotels_settings", ['name'], ["id" => $values['amenity_id']]);
//               dd();
//                foreach ($hotel_amenities_array as $values) {
                    $amenities[] = $hotel_amenities_array[0]['name'];
                //}
            }

        } else {
            $amenities = [];
        }



        //GET ROOM AMENITIES FROM hotels_SETTINGS TABLE
        $room_amenities = $db->select("hotels_settings", ['name'], ["setting_type" => "room_amenities"]);

        $room_amenities1 = "";
        foreach ($room_amenities as $value) {
            foreach ($value as $index) {
                $room_amenities1 .= $index . "_";
            }
        }

        $room_amenities_array = explode("_", trim($room_amenities1));
        
        //GET MODULE_ID FROM MODULES TABLE
        $module_id = $db->select('modules', ['id'], ['name' => $supplier_name, 'type' => 'hotels']);

        //GET DATA FROM hotels_ROOMS TABLE AND hotels_SETTINGS TABLE OF ROOMS
        $rooms = $db->select(
            "hotels_rooms",
            [
                "[>]hotels_settings" => ["room_type_id" => "id"]
            ],
            [
                "hotels_rooms.id",
                "hotels_settings.name",
                "hotels_rooms.thumb_img",
                "hotels_rooms.room_quantity",
                "hotels_rooms.extra_bed",
                "hotels_rooms.extra_bed_charges",
            ],
            [
                "setting_type" => "rooms_type",
                "hotel_id" => $hotel_id
            ]
        );

        $room_details = []; $actual_room_price = 0; $markup_price = 0;
        foreach ($rooms as $index) {
            $room_price = $db->select("hotels_rooms_options", ['room_id','price'], ["room_id" => $index['id']]);

            if (!empty($room_price[0]['price'])) {
                $actual_room_price = $room_price[0]['price'] * $rate[0]['rate']; // CONVERTING ACCUAL PRICE ACCORDING TO USER SELECTED CURRENCY
                $markup_price = markup_price($module_id[0]['id'], $actual_room_price, array(0 => $checkin, 1 => $checkout), $locations[0]['city']);
               
                //GET ROOM OPTIONS FROM hotels_ROOMS_OPTIONS TABLE 
                $room_options = $db->select(
                    "hotels_rooms_options",
                    [
                        "room_id",
                        "price",
                        "quantity",
                        "adults",
                        "childs",
                        "cancellation",
                        "breakfast",
                    ],
                    [
                        "room_id" => $index['id']
                    ]
                );
                $options = [];
                foreach ($room_options as $key => $value) {
                    if (!empty($room_price)) {
                        $option_price = $value['price'] * $rate[0]['rate'];
                        //THIS FUNCTION GETS THE REQUIRED PARAMETERS AND RETURNS THE MARKUP PRICE

                        $markup_room_option_price = markup_price($module_id[0]['id'], $option_price, array(0 => $checkin, 1 => $checkout), $locations[0]['city']);
                    }

                    if ($value['price'] != 0) {
                        $options[] = [
                            "id" => $value['room_id'],
                            "currency" => $rate[0]['name'],
                            "price" => number_format($option_price * $days, 2),
                            "per_day" => number_format($option_price, 2),
                            "markup_price" => number_format($markup_room_option_price * $days, 2),
                            "markup_price_per_night" => number_format($markup_room_option_price, 2),
                            "service_fee" => 10,
                            "quantity" => $value['quantity'],
                            "adults" => $value['adults'],
                            "child" => $value['childs'],
                            "children_ages" => $child_age,
                            "bookingurl" => "",
                            "booking_data" => "",
                            "extrabeds_quantity" => $rooms[0]['extra_bed'],
                            "extrabed_price" => $rooms[0]['extra_bed_charges'],
                            "cancellation" => $value['cancellation'],
                            "breakfast" => $value['breakfast'],
                            "room_booked" => 0
                        ];
                    } else {
                        $options = "NO OPTIONS AVAILABLE";
                    }
                }

                isset($details[0]['refundable']) ? $refundable = $details[0]['refundable'] : $refundable = "";

                //MAKING OBJECT OF ROOMS
                $room_details[] = (object) [
                    "id" => $index['id'],
                    "name" => $index['name'],
                    "actual_price" => number_format($actual_room_price * $days, 2),
                    "actual_price_per_night" => number_format($actual_room_price, 2),
                    "markup_price" => number_format($markup_price * $days, 2),
                    "markup_price_per_night" => number_format($markup_price, 2),
                    "service_fee" => 0,
                    "currency" => $currency,
                    "refundable" => $refundable,
                    "refundable_date" => "",
                    "img" => $index['thumb_img'],
                    "amenities" => $room_amenities_array,
                    "options" => $options
                ];
            }
        }
        //SHOWING FINAL RESULTS AS AN OBJECT OF HOTEL ROOMS
        $response = (object) [
            "id" => $details[0]['id'],
            "name" => $details[0]['name'],
            "city" => $locations[0]['city'],
            "country" => $locations[0]['country'],
            "address" => $details[0]['address'],
            "stars" => $details[0]['stars'],
            "ratings" => $details[0]['rating'],
            "longitude" => $details[0]['location_cords'],
            "latitude" => $details[0]['location_cords'],
            "desc" => $details[0]['desc'],
            "img" => $room_imgs_array,
            "amenities" => $amenities,
            "supplier_name" => "hotels",
            "supplier_id" => $module_id[0]['id'],
            "rooms" => $room_details,
            "checkin" => $details[0]['checkin'],
            "checkout" => $details[0]['checkout'],
            "policy" => $details[0]['policy'],
            "booking_age_requirement" => $details[0]['booking_age_requirement'],
            "cancellation" => $details[0]['cancellation'],
            "tax_percentage" => "2",
            "hotel_phone" => $details[0]['hotel_phone'],
            "hotel_email" => $details[0]['hotel_email'],
            "hotel_website" => $details[0]['hotel_website'],
            "discount" => 0,
        ];
    } else {
                // Get module data for each active module
                $getvalue = gethotelmoduledata($supplier_name);
                // Determine whether the module is in development or production mode
                if ($getvalue[0]['dev_mode'] == 1) {
                    $env = 'production';
                } else {
                    $env = 'dev';
                }

                //VALIDATION
                $param = array(
                   //"endpoint" => $root . "/modules/hotels/" . strtolower($supplier_name) . "/api/v1/hotel_details",
                    "endpoint" => "https://api.phptravels.com/hotels/".strtolower($supplier_name)."/api/v1/hotel_details",
                    "hotel_id" => $hotel_id,
                    "checkin" => $checkin,
                    "checkout" => $checkout,
                    "nationality" => $nationality,
                    "adults" => $adults,
                    "childs" => $childs,
                    "child_age" => $child_age,
                    "rooms" => $rooms,
                    "language" => $language_name,
                    "currency" => $currency,
                    "supplier_name" => $supplier_name,
                    'c1' => $getvalue[0]['c1'],
                    'c2' => $getvalue[0]['c2'],
                    'c3' => $getvalue[0]['c3'],
                    'c4' => $getvalue[0]['c4'],
                    'c5' => $getvalue[0]['c5'],
                    "env" => $env
                );

        $curl = sendhotelRequest('POST', 'hotel_details', $param); //SENDS A CURL REQUEST TO FETCH THE HOTEL DETAIL RESPONSE ACCORDING TO GIVEN SUPPLIER NAME
        $hotel_details = json_decode($curl); //DECODE THE FETCHED RESPONSE

        if ($hotel_details != null) {
            //DEFINING THE REQUIRED VARIABLES
            $rooms = [];
            $actual_price = 0;
            $actual_option_price = 0;
            $markup_price = 0;
            $markup_room_option_price = 0;

            //MAKING ROOM AND ROOM OPTION RESPONSE WITH MARKUP PRICES 
            foreach ($hotel_details->rooms as $value) {
                $markup_room_price = 0;
                $actual_price = $value->price * $rate[0]['rate']; //ACTUAL PRICE OF HOTEL ROOMS ACCORDING TO USER SELECTED CURRECNY
                //MARKUP PRICE FOR HOTEL ROOMS
                $markup_price = markup_price($getvalue[0]['id'], $actual_price, array(0 => $checkin, 1 => $checkout), $hotel_details->city);
                $options = [];
                $options_array = $value->options;

                foreach ($options_array as $key => $values) {
                    //MARKUP PRICE FOR HOTEL ROOM OPTIONS
                    $actual_option_price = $values->price * $rate[0]['rate']; //ACTUAL PRICE OF HOTEL ROOMS ACCORDING TO USER SELECTED CURRECNY
                    $markup_room_option_price = markup_price($getvalue[0]['id'], $actual_option_price, array(0 => $checkin, 1 => $checkout), $hotel_details->city);
                        $options[] = [
                            "id" => $values->id,
                            "currency" => $param['currency'],
                            "price" => number_format($actual_option_price, 2),
                            "per_day" => number_format($actual_option_price / $days, 2),
                            "markup_price" => number_format($markup_room_option_price, 2),
                            "markup_price_per_night" => number_format($markup_room_option_price / $days, 2),
                            "service_fee" => $values->service_fee,
                            "quantity" => $values->quantity,
                            "adults" => $values->adults,
                            "child" => $values->child,
                            "children_ages" => $values->children_ages,
                            "bookingurl" => $values->bookingurl,
                            "booking_data" => $values->booking_data,
                            "extrabeds_quantity" => $values->extrabeds_quantity,
                            "extrabed_price" => $values->extrabed_price,
                            "cancellation" => $values->cancellation,
                            "breakfast" => $values->breakfast,
                            "room_booked" => $values->room_booked
                        ];
                }

                if ($actual_price != 0.00 && !empty($options)) {
                    $rooms[] = [
                        "id" => $value->id,
                        "name" => $value->name,
                        "actual_price" => number_format($actual_price, 2),
                        "actual_price_per_night" => number_format($actual_price / $days, 2),
                        "markup_price" => number_format($markup_price, 2),
                        "markup_price_per_night" => number_format($markup_price / $days, 2),
                        "service_fee" => $value->service_fee,
                        "currency" => $param['currency'],
                        "refundable" => $value->refundable,
                        "refundable_date" => $value->refundable_date,
                        "img" => $value->images,
                        "amenities" => $value->amenities,
                        "options" => $options,
                    ];
                }
            }

            //FINAL RESPONSE OF HOTEL DETAILS
            $response = (object) [
                "id" => $hotel_details->id,
                "name" => $hotel_details->name,
                "city" => $hotel_details->city,
                "country" => $hotel_details->country,
                "address" => $hotel_details->address,
                "stars" => $hotel_details->stars,
                "ratings" => $hotel_details->rating,
                "longitude" => $hotel_details->longitude.",".$hotel_details->latitude,
                "latitude" => $hotel_details->latitude,
                "desc" => $hotel_details->desc,
                "img" => $hotel_details->img,
                "amenities" => $hotel_details->amenities,
                "supplier_name" => $getvalue[0]['name'],
                "supplier_id" => $getvalue[0]['id'],
                "rooms" => $rooms,
                "checkin" => $hotel_details->checkin,
                "checkout" => $hotel_details->checkout,
                "booking_age_requirement" => $hotel_details->booking_age_requirement,
                "policy" => $hotel_details->policy,
                "cancellation" => $hotel_details->cancellation,
                "tax_percentage" => $hotel_details->tax_percentage,
                "hotel_phone" => $hotel_details->hotel_phone,
                "hotel_email" => $hotel_details->hotel_email,
                "hotel_website" => $hotel_details->hotel_website,
                "discount" => $hotel_details->discount,
            ];

        } else {
            $response = "SOMETHING WENT WRONG PLEASE CONTACT SUPPORT FOR FURTHER ASSISSTENCE";
        }

    }
    echo json_encode($response);
});

/*=======================
HOTEL_BOOKING REQUEST API
=======================*/
$router->post('hotel_booking', function () {

    //CONFIG FILE
    include "./config.php";

    //VALIDATION
    $param = array(
        'price_original' => $_POST["price_original"],
        'price_markup' => $_POST["price_markup"],
        'vat' => $_POST["vat"],
        'tax' => $_POST["tax"],
        'gst' => $_POST["gst"],
        'first_name' => $_POST["first_name"],
        'last_name' => $_POST["last_name"],
        'email' => $_POST["email"],
        'address' => $_POST["address"],
        'phone_country_code' => $_POST["phone_country_code"],
        'phone' => $_POST["phone"],
        'country' => $_POST["country"],
        'nationality' => $_POST["nationality"],
        'stars' => $_POST["stars"],
        'hotel_id' => $_POST["hotel_id"],
        'hotel_name' => $_POST["hotel_name"],
        'hotel_phone' => $_POST["hotel_phone"],
        'hotel_email' => $_POST["hotel_email"],
        'hotel_website' => $_POST["hotel_website"],
        'hotel_address' => $_POST["hotel_address"],
        'room_data' => $_POST["room_data"],
        'location' => $_POST["location"],
        'location_cords' => $_POST["location_cords"],
        'hotel_img' => $_POST["hotel_img"],
        'checkin' => $_POST["checkin"],
        'checkout' => $_POST["checkout"],
        'adults' => $_POST["adults"],
        'childs' => $_POST["childs"],
        'child_ages' => $_POST["child_ages"],
        'currency_original' => $_POST["currency_original"],
        'currency_markup' => $_POST["currency_markup"],
        'booking_data' => $_POST["booking_data"],
        'supplier' => $_POST["supplier"],
        'user_id' => $_POST["user_id"],
        'user_data' => $_POST["user_data"],
        'guest' => $_POST["guest"],
        'booking_ref_no' => date('Ymdhis'),
        'booking_date' => date('Y-m-d'),
        'payment_gateway' => $_POST["payment_gateway"],
        'payment_status' => 'unpaid',
        'booking_status' => 'pending',
    );

    $db->insert("hotels_bookings", $param); //INSERTION OF BOOKING DATA INTO DATABASE

    $data = (json_decode($_POST["user_data"]));
    $data = (object) array_merge((array) $data, array('booking_ref_no' => $param['booking_ref_no']));
    // HOOK 
    $hook = "hotels_booking";
    include "./hooks.php";
    echo json_encode(array('status' => true, 'id' => $db->id(), 'booking_ref_no' => $param['booking_ref_no']));
});

/*=======================
HOTEL_BOOKING INVOICE API
=======================*/
$router->post('hotels/invoice', function () {

    // CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    $booking_ref_no = $_POST["booking_ref_no"];

    $response = $db->select("hotels_bookings", "*", ['booking_ref_no' => $booking_ref_no]); // SELECT THE BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER 
    if (!empty($response)) {
        echo json_encode(array('status' => true, 'response' => $response)); // RETURN INVOICE IF BOOKING REFERENCE NUMBER IS CORRECT
    } else {
        echo json_encode(array('status' => false, 'response' => 'The booking reference number in invalid')); // RETURN IF BOOKING REFERENCE NUMBER IS CORRECT
    }
});

/*=======================
HOTEL_BOOKING PAYMENT UPDATE API
=======================*/
$router->post('hotels/booking_update', function () {
    include "./config.php";

    $booking_ref_no = $_POST['booking_ref_no'];
    $data_hotel = $db->select("hotels_bookings", "*", ['booking_ref_no' => $booking_ref_no]); // SELECT THE BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER
    if (!empty($data_hotel)) {
        $gethotels = gethotelmoduledata($data_hotel[0]['supplier']);

        if ($gethotels[0]['dev_mode'] == 1) {
            $evn_hotel = 'pro';
        } else {
            $evn_hotel = 'dev';
        }


        $param = array(
            'c1' => $gethotels[0]['c1'],
            'c2' => $gethotels[0]['c2'],
            'c3' => $gethotels[0]['c3'],
            'c4' => $gethotels[0]['c4'],
            'c5' => $gethotels[0]['c5'],
            'evn' => $evn_hotel,
            //'endpoint' => "http://localhost/modules/hotels/".strtolower($gethotels[0]['name'])."/api/v1/booking",
            //'endpoint' => "https://api.phptravels.com/flights/".strtolower($data[0]['supplier'])."/api/v1/booking",
            "booking_ref_no" => $data_hotel[0]['booking_ref_no'],
            "booking_data" => $data_hotel[0]['booking_data'],
            "guest" => $data_hotel[0]['guest'],
            "nationality" => $data_hotel[0]['nationality'],
            "user_data" => $data_hotel[0]['user_data'],

        );

            $url = "https://api.phptravels.com/hotels/".strtolower($gethotels[0]['name'])."/api/v1/booking";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param)); // Encode the data in the proper format
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp_hotel = curl_exec($ch);
            if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            }
            curl_close($ch);

        //$resp_hotel = sendhotelRequest('POST', 'search', $param);
        $booking_hotel = json_decode($resp_hotel);

        $db->update("hotels_bookings", [
            "booking_pnr" => $booking_hotel->Prn,
            "booking_response" => $resp_hotel,
            "payment_status" => $_POST['payment_status'],
            "booking_status" => $_POST['booking_status'],
            "transaction_id" => $_POST['transaction_id'],
            "payment_gateway" => $_POST['payment_gateway'],
            "error_response" => $booking_hotel->response_error,
        ], [
            "booking_ref_no" => $_POST['booking_ref_no']
        ]);

        $db->insert("transactions", [
            "description" => $_POST['transaction_desc'],
            "user_id" =>  $_POST['transaction_user_id'],
            "trx_id" => $_POST['transaction_id'],
            "type" => $_POST['transaction_type'],
            "date" => date('Y-m-d'),
            "amount" => $_POST['transaction_amount'],
            "payment_gateway" =>  $_POST['transaction_payment_gateway'],
            "currency" => $_POST['transaction_currency'] ,
        ]);

        $user = (json_decode($data_hotel[0]['user_data']));
            $hook = "hotels_update_booking";
            include "./hooks.php";

        if ($booking_hotel->Prn) {
            echo json_encode(array('status' => true, 'Prn' => $booking_hotel->Prn));
        } else {
            echo json_encode(array('status' => false, 'Prn' => $booking_hotel->Prn));
        }
    }else{
        echo json_encode(array('status' => false, 'response' => 'Please valid booking ref no'));
    }
});

/*=======================
HOTEL_BOOKING PAYMENT UPDATE API
=======================*/
$router->post('hotels/cancellation', function () {
    //CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    $booking_ref_no = $_POST["booking_ref_no"];

    $params = array('cancellation_request' => 1, );
    $data = $db->update("hotels_bookings", $params, ["booking_ref_no" => $booking_ref_no]); //UPDATE THE CANCELATION STATUS IN DATABASE IF REQUEST IS MADE

    $booking = $db->select("hotels_bookings", '*', ["booking_ref_no" => $booking_ref_no]);
    $user = (json_decode($booking[0]['user_data']));

    // HOOK 
    $hook = "hotels/cancellation_request";
    include "./hooks.php";

    echo json_encode(array('status' => true, 'message' => 'request received successfully'));

});
?>