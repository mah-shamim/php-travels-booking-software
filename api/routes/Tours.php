<?php
// HEADERS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("X-Frame-Options: SAMEORIGIN");

/*==================
THIS FUNCTION IS USED TO SET THE MARKUP PRICE
==================*/
function price_con($price, $currency)
{
    $db = openconn();
    //FETCH THE PRICE CONVERSION RATE
    $default_currency = $db->select("currencies", "*", ["status" => 1, "default" => 1]);

    // 
    $current_currency_rate = $db->select("currencies", ["rate"], ["name" => $default_currency[0]['name']]);
    if (!empty($price) && !empty($current_currency_price[0]['rate'])) {
        $price = ceil(str_replace(',', '', $price) / $current_currency_rate[0]['rate']);
    } else {
        $price = ceil(str_replace(',', '', $price));
    }
    $con_rate = $db->select("currencies", ['rate'], ["name" => $currency]);
    $con_price = $price * $con_rate[0]['rate'];
    return $con_price;
}
function toursmarkup($module_id, $price, $date, $location)
{
    $conn = openconn();
    $markup = $conn->select('markups', "*", ['type' => 'tours', 'module_id' => $module_id, 'status' => 1]);
    $b2c = '';
    $b2c_markup = '';
    $b2b = '';
    $b2b_markup = '';
    if (!empty($markup)) {
        //THIS CODE CHECKS IF THE DATES ARE PRESENT OR NOT AND MAKES A SAME FORMAT OF DATE
        $city_id = ($location != null) ? $location : "";
        $date = new DateTime($date);
        if (($markup[0]['from_date'] != null && $markup[0]['to_date'] != null)) {
            $from_date = new DateTime($markup[0]['from_date']);
            $to_date = new DateTime($markup[0]['to_date']);
        } else {
            $from_date = "";
            $to_date = "";
        }

        if ((($from_date <= $date && $to_date >= $date) || $markup[0]['location'] == $city_id) && $markup[0]['user_id'] == null) {
            $b2c = $price + ($markup[0]['b2c_markup'] * $price) / 100;
            $b2c_markup = $markup[0]['b2c_markup'];
            $b2b = 0;
            $b2b_markup = 0;
        } else if ($markup[0]['user_id'] != null) {
            $b2b = $price + ($markup[0]['b2b_markup'] * $price) / 100;
            $b2b_markup = $markup[0]['b2b_markup'];
            $b2c = 0;
            $b2c_markup = 0;
        } else {
            $b2c = ($markup[0]['b2c_markup'] != null) ? $price + ($markup[0]['b2c_markup'] * $price) / 100 : $price + ($markup[0]['user_markup'] * $price) / 100;
            $b2c_markup = ($markup[0]['b2c_markup'] != null) ? $markup[0]['b2c_markup'] : $markup[0]['user_markup'];
            $b2b = 0;
            $b2b_markup = 0;
        }
    } else {
        $b2c = $price;
        $b2c_markup = 0;
        $b2b = 0;
        $b2b_markup = 0;
    }
    // return [$b2c,$b2c_markup,$b2b,$b2b_markup];
    return array(
        'b2c' => $b2c,
        'b2c_markup' => $b2c_markup,
        'b2b' => $b2b,
        'b2b_markup' => $b2b_markup,
    );
}

/*==================
THIS FUNCTION RETRIEVES A LIST OF ALL ACTIVE HOTEL MODULES
==================*/
function gettoursmodules()
{
    $conn = openconn(); // Open a connection to the database.
// Select all modules of type 'hotels' from the database
    $respose = $conn->select("modules", ['id', 'name','module_color'], ["type" => 'tours', 'status' => 1]);
    // Create an empty array to store the module data
    $data = [];
    // Loop through the results and add any active modules (excluding the 'flights' module itself)
    foreach ($respose as $module) {
        if ($module['name'] != 'hotels') {
            $data[] = array(
                'name' => $module['name'],
                'id' => $module['id'],
                'module_color' => $module['module_color']
            );
        }
    }
    // Return the list of active modules
    return $data;
}

/*==================
THIS FUNCTION RETRIEVES THE HOTEL MODULES DATA FROM DATABASE
==================*/
function gettourmoduledata($modulename)
{
    $conn = openconn(); // Open a connection to the database.
    // Use the database connection to select data from the 'modules' table where the name matches the input.
    $response = $conn->select("modules", "*", ["name" => $modulename]);
    // Return the results.
    return $response;
}

/**
 * Sends a request to a web service using cURL.
 *
 * @param string $req_method The HTTP request method to use (e.g. 'GET', 'POST', 'PUT', 'DELETE', etc.)
 * @param string $service The name of the web service being called (not used in this function)
 * @param array $payload An array of key-value pairs to include in the request
 * @param array $_headers An optional array of additional HTTP headers to include in the request
 *
 * @return mixed The response from the web service, or an error message if something went wrong
 */
function sendtourRequest($req_method = 'GET', $service = '', $payload = [], $_headers = [])
{
    // Get the URL from the payload and remove it from the array
    $url = $payload['endpoint'];
    unset($payload['endpoint']);

    // Set up cURL options
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
    curl_setopt($curl, CURLOPT_ENCODING, ""); // Handle all encodings
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10); // Follow up to 10 redirects
    curl_setopt($curl, CURLOPT_TIMEOUT, 0); // Time out after 30 seconds
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
TOURS SEARCH API
==================*/
$router->post('tours/search', function () {

    // INCLUDE CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('location');
    required('date');
    required('adults');
    required('childs');
    required('language');
    required('currency');
    required('ip');

    //PARAMETERS
    $params = array(
        "location" => $_POST['location'],
        "date" => $_POST['date'],
        "adults" => $_POST['adults'],
        "childs" => $_POST['childs'],
        "language" => $_POST['language'],
        "currency" => $_POST['currency'],
        "ip" => $_POST['ip'],
    );

    //GET THE MODULE ID
    $module_id = $db->select('modules', ['id','module_color'], ['name' => 'tours', 'type' => 'tours', 'status' => 1]);

    //CHECKS IF THE MODULE IS ACTIVE AND FETCH THE RESULT OF SEARCHED TOURS ACCORDING TO PARAMS
    if (!empty($module_id[0]['id'])) {
        $manual_tours = $db->select('tours', '*', ['location' => $params['location'], 'status' => 1]);

        //GET THE CODE OF CITY ACCORDING TO LOCATION NAME
        $loc_code = $db->select('locations', ['id'], ['city' => $params['location']]);

        $manual_response = [];
        if (!empty($manual_tours)) {
            foreach ($manual_tours as $value) {

                //PRICE CALCULATION ON THE BASE OF ADULTS AND CHILDS
                $price = ($params['adults'] * $value['tour_adult_price']) + ($params['childs'] * $value['tour_child_price']);
                
                //PRICE CONVERSION
                $con_price = price_con($price, $params['currency']);
                $country = $db->select('locations',['country'],['city' => $value['location']]);

                //MARKUP PRICES
                $markup = toursmarkup($module_id[0]['id'], $con_price, $params['date'], $loc_code[0]['id']);
                $markup_price = ($markup['b2c'] != 0 ) ? $markup['b2c'] : $markup['b2c'] ;
                if ($con_price != null) {
                    $manual_response[] = (object) [
                        'tour_id' => $value['id'],
                        'name' => $value['name'],
                        'location' => $value['location'].",".$country[0]['country'],
                        'img' => root."../uploads/".$value['img'],
                        'desc' => $value['desc'],
                        'price' => number_format((float) $markup_price, 2, '.', ''),
                        'actual_price' => number_format((float) $con_price, 2, '.', ''),
                        'b2c_price' => number_format((float) $markup['b2c'], 2, '.', ''),
                        'b2b_price' => number_format((float) $markup['b2b'], 2, '.', ''),
                        'b2c_markup' => $markup['b2c_markup'],
                        'b2b_markup' => $markup['b2b_markup'],
                        'rating' => $value['stars'],
                        'redirect' => "",
                        'supplier' => "tours",
                        'latitude' => $value['tour_latitude'],
                        'longitude' => $value['tour_longitude'],
                        'currency_code' => $params['currency'],
                        'color' => $module_id[0]['module_color']
                    ];
                }
            }
        }
    } else {
        $manual_response = [];
    }

    $data_tours =[];
    $array_count =[];
    $Multithreadingtours = gettoursmodules();
    if (!empty($Multithreadingtours)) {
        foreach ($Multithreadingtours as $value) {
            $getvalue = gettourmoduledata($value['name']); // Get module data for each active module
            $module_name = $value['name'];
            $module_id = $value['id'];
            // Determine whether the module is in development or production mode
            if ($getvalue[0]['dev_mode'] == 1) {
                $env = 'production';
            } else {
                $env = 'dev';
            }

            $module_color = $value['module_color'];


            //Call API's Parameters
            $param = array(
                // "endpoint" => "https://api.phptravels.com/tours/".strtolower($module_name)."/api/v1/search",
                "endpoint" => "",
                "location" => $_POST['location'],
                "date" => $_POST['date'],
                "adults" => $_POST['adults'],
                "childs" => $_POST['childs'],
                "language" => $_POST['language'],
                "currency" => $getvalue[0]['currency'],
                "ip" => $_POST['ip'],
                'c1' => $getvalue[0]['c1'],
                'c2' => $getvalue[0]['c2'],
                'c3' => $getvalue[0]['c3'],
                'c4' => $getvalue[0]['c4'],
                'c5' => $getvalue[0]['c5'],
                "env" => $env,
                "pagination" => $_POST['pagination']
            );

            $response = sendtourRequest('POST', 'search', $param);
            // $tours_rep = json_decode($response);
            $tours_rep = json_decode('');

            if (!empty($tours_rep)) {
                $array_count[] = $tours_rep->total;
                foreach ($tours_rep->response as $val) {
                    //PRICE CONVERSION
                    $con_price = price_con($val->price, $_POST['currency']);
                    //GET THE CODE OF CITY ACCORDING TO LOCATION NAME
                    $loc_code = $db->select('locations', ['id'], ['city' => $val->location]);

                    //MARKUP PRICES
                    $markup = toursmarkup($module_id, $con_price, $_POST['date'], $loc_code[0]['id']);
                    $markup_price = ($markup['b2c'] != 0 ) ? $markup['b2c'] : $markup['b2c'] ;

                    $data_tours[] = (object)[
                        'tour_id' => $val->tour_id,
                        'name' =>  $val->name,
                        'location' =>  $val->location,
                        'img' =>  root."uploads/".$val->img,
                        'desc' =>  $val->desc,
                        'price' => number_format((float)$markup_price, 2, '.', ''),
                        'actual_price' => number_format((float)$con_price, 2, '.', ''),
                        'b2c_price' => number_format((float)$markup['b2c'], 2, '.', ''),
                        'b2b_price' => number_format((float)$markup['b2b'], 2, '.', ''),
                        'b2c_markup' => $markup['b2c_markup'],
                        'b2b_markup' => $markup['b2b_markup'],
                        'rating' =>  $val->rating,
                        'redirect' =>  $val->redirect,
                        'supplier' =>  $module_name,
                        'latitude' =>  $val->latitude,
                        'longitude' =>  $val->longitude,
                        'currency_code' => $_POST['currency'],
                        'color' => $module_color,
                    ];
                }
            }
    }
    }

    if (!empty($manual_response) && !empty($data_tours)) {
        $data = array_merge($manual_response, $data_tours);
    } elseif (!empty($manual_response)) {
        $data = ['status'=>true,'response'=>$manual_response,'total'=>0];
    } elseif (!empty($data_tours)) {
        $data = ['status'=>true,'response'=>$data_tours,'total'=>max($array_count)];
    } else {
        $data = [];
    }
    echo json_encode($data);

});

/*==================
TOUR DETAIL API
==================*/
$router->post('tour/details', function () {

    // INCLUDE CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('tour_id');
    required('currency');
    required('supplier');
    required('adults');
    required('childs');

    //PARAMETERS
    $params = array(
        "tour_id" => $_POST['tour_id'],
        "currency" => $_POST['currency'],
        "date" => $_POST['date'],
        "adults" => $_POST['adults'],
        "childs" => $_POST['childs'],
        "supplier" => $_POST['supplier'],
    );

    $tour = $db->select('tours', '*', ['id' => $params['tour_id'], 'status' => 1]);

    $module_id = $db->select('modules', ['id'], ['name' => 'tours', 'type' => 'tours', 'status' => 1]); //GET THE MODULE ID
    if (!empty($tour) && !empty($module_id[0]['id'])) {
        $tour_type = $db->select('tours_types', ['name'], ['id' => $tour[0]['tour_type']]); //GETS THE TOUR_TYPE FROM DATABASE BASE ON TOUR_ID

        //TOUR IMAGES
        $tour_img = $db->select('tours_images', ['img'], ['tour_id' => $tour[0]['id']]);
        //check if img available
        $tour_imgs = [];
        if (!empty($tour_img)) {
            foreach ($tour_img as $value) {
                $tour_imgs[] = $value['img'];
            }
        }
        array_unshift($tour_imgs,$tour[0]['img']);

        //EXCLUSION
        $exclusions =[] ;
        $exc_id = $db->select('tours_exclusions_rel', ['exclusions_id'], ['tour_id' => $tour[0]['id']]);
        if (!empty($exc_id)) {
            foreach ($exc_id as $value) {
                $exc = $db->select('tours_exclusions', ['name'], ['exclusions_id' => $value['exclusions_id']]);
                $exclusions[] = $exc[0]['name'];
            }
        }
        //INCLUSION
        $inclusions =[] ;
        $inc_id = $db->select('tours_inclusions_rel', ['inclusions_id'], ['tour_id' => $tour[0]['id']]);
        if (!empty($inc_id)) {
            foreach ($inc_id as $value) {
                $inc = $db->select('tours_inclusions', ['name'], ['inclusions_id' => $value['inclusions_id']]);
                $inclusions[] = $inc[0]['name'];
            }
        }
        $tour_itinerary = $db->select('tours_itinerary',['itinerary'],['tour_id' => $params['tour_id'], 'ORDER' => ['itinerary' => 'ASC']]);
        $tours_itinerary = [];
        if(!is_null($tour_itinerary)) {
            foreach ($tour_itinerary as $key => $value) {
                $tours_itinerary[] = $value['itinerary'];
            }
        }
        //PRICE CALCULATION ON THE BASE OF ADULTS AND CHILDS
        $price = ($params['adults'] * $tour[0]['tour_adult_price']) + ($params['childs'] * $tour[0]['tour_child_price']);

        // PRICES CONVERSIONS
        $con_price = ($price) ? price_con( $price, $params['currency']) : 0;
        $con_adult_price = ($tour[0]['tour_adult_price']) ? price_con($tour[0]['tour_adult_price'], $params['currency']) : 0;
        $con_child_price = ($tour[0]['tour_child_price']) ? price_con($tour[0]['tour_child_price'], $params['currency']) : 0;
        $con_infant_price = ($tour[0]['tour_infant_price']) ? price_con($tour[0]['tour_infant_price'], $params['currency']) : 0;

        //MARKUP PRICES
        $loc_code = $db->select('locations', ['id'], ['city' => $tour[0]['location']]); //GETS THE LOCATION_ID FROM DATABASE FOR MARKUPS
        $markup = toursmarkup($module_id[0]['id'], $con_price, $params['date'], $loc_code[0]['id']);
        
        $adult_markup_price = toursmarkup($module_id[0]['id'], $con_adult_price, $params['date'], $loc_code[0]['id']);
        $child_markup_price = toursmarkup($module_id[0]['id'], $con_child_price, $params['date'], $loc_code[0]['id']);
        $infant_markup_price = toursmarkup($module_id[0]['id'], $con_infant_price, $params['date'], $loc_code[0]['id']);
        $price_markup = ($markup['b2c'] != 0) ? $markup['b2c'] :$markup['b2b'] ; //CHECKS WHICH MARKUP PRICE IS AVAIABLE

        $response = [
            'tour_id' => $tour[0]['id'],
            'name' => $tour[0]['name'],
            'tour_type' => $tour_type[0]['name'],
            'date' => $params['date'],
            'location' => $tour[0]['location'],
            'img' => $tour_imgs,
            'desc' => $tour[0]['desc'],
            'tours_itinerary' => $tours_itinerary,
            'price' => number_format((float)$price_markup, 2, '.', ''),
            'actual_price' => number_format($con_price, 2, '.', ''),
            'b2c_price_adult' => number_format($adult_markup_price['b2c'], 2, '.', ''),
            'b2b_price_adult' => number_format($adult_markup_price['b2b'], 2, '.', ''),
            'b2c_price_child' => number_format($child_markup_price['b2c'], 2, '.', ''),
            'b2b_price_child' => number_format($child_markup_price['b2b'], 2, '.', ''),
            'b2c_price_infant' => number_format($infant_markup_price['b2c'], 2, '.', ''),
            'b2b_price_infant' => number_format($infant_markup_price['b2b'], 2, '.', ''),
            'b2c_markup' => $adult_markup_price['b2c_markup'],
            'b2b_markup' => $adult_markup_price['b2c_markup'],
            'adult_price' => number_format($con_adult_price, 2, '.', ''),
            'child_price' => number_format($con_child_price, 2, '.', ''),
            'infant_price' => number_format($con_infant_price, 2, '.', ''),
            'max_Adults' => $tour[0]['tour_max_adults'],
            'max_Child' => $tour[0]['tour_max_child'],
            'max_Infant' => $tour[0]['tour_max_infant'],
            'rating' => $tour[0]['stars'],
            'longitude' => $tour[0]['tour_longitude'],
            'latitude' => $tour[0]['tour_latitude'],
            'redirect' => "",
            'inclusions' => $exclusions,
            'exclusions' => $inclusions,
            'currencycode' => $params['currency'],
            'duration' => "",
            'policy' => $tour[0]['policy'],
            'max_travellers' => $tour[0]['tour_max_adults'] + $tour[0]['tour_max_child'] + $tour[0]['tour_max_infant'],
            'departure_time' => "",
            'departure_point' => "",
            'supplier' => "tours",
            'multi_destinations' => "",
        ];
    } else {
        $response = [];
    }

    echo json_encode($response);
});

/*=======================
TOURS BOOKING REQUEST API
=======================*/
$router->post('tours/booking', function () {

    //CONFIG FILE
    include "./config.php";

    //VALIDATION
    $param = array(
        "booking_ref_no" => date('Ymdhis'),
        "booking_date" => date("Y-m-d"),
        "payment_status" =>'unpaid',
        "booking_status" => 'pending',
        "payment_gateway" => $_POST['payment_gateway'],
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "email" => $_POST['email'],
        "address" => $_POST['address'],
        "phone_country_code" => $_POST['phone_country_code'],
        "phone" => $_POST['phone'],
        "tours_id" => $_POST['tours_id'],
        "tours_name" => $_POST['tours_name'],
        "tour_type" => $_POST['tour_type'],
        "tour_img" => $_POST['tour_img'],
        "adults" => $_POST['adults'],
        "childs" => $_POST['childs'],
        "infants" => $_POST['infants'],
        "price_markup" => $_POST['price_markup'],
        "actual_price" => $_POST['actual_price'],
        "currency_original" => $_POST['currency_original'],
        "currency_markup" => $_POST['currency_markup'],
        "tour_location" => $_POST['tour_location'],
        "tour_latitude" => $_POST['tour_latitude'],
        "tour_longitude" => $_POST['tour_longitude'],
        "tour_stars" => $_POST['tour_stars'],
        "module_type" => $_POST['module_type'],
        "booking_data" => $_POST['booking_data'],
        "supplier" => $_POST['supplier'],
        "user_id" => $_POST['user_id'],
        "guest" => $_POST['guest'],
        "user_data" => $_POST['user_data'],
    );
    $db->insert("tours_bookings", $param); //INSERTION OF BOOKING DATA INTO DATABASE

    $data = (json_decode($_POST["user_data"]));
    $data = (object) array_merge((array) $data, array('booking_ref_no' => $param['booking_ref_no']));
    // HOOK 
    $hook = "tours_booking";
    include "./hooks.php";
    echo json_encode(array('status' => true, 'id' => $db->id(), 'booking_ref_no' => $param['booking_ref_no']));
});

/*=======================
TOURS BOOKING INVOICE API
=======================*/
$router->post('tours/invoice', function () {

    // CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    $booking_ref_no = $_POST["booking_ref_no"];

    $response = $db->select("tours_bookings", "*", ['booking_ref_no' => $booking_ref_no]); // SELECT THE BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER 
    if (!empty($response)) {
        echo json_encode(array('status' => true, 'response' => $response)); // RETURN INVOICE IF BOOKING REFERENCE NUMBER IS CORRECT
    } else {
        echo json_encode(array('status' => false, 'response' => 'The booking reference number in invalid')); // RETURN IF BOOKING REFERENCE NUMBER IS CORRECT
    }
});

/*=======================
TOURS BOOKING PAYMENT UPDATE API
=======================*/
$router->post('tours/booking_update', function () {
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    required('transaction_id');
    required('transaction_type');

    $booking_ref_no = $_POST['booking_ref_no'];
    $query = $db->select("tours_bookings", "*", ['booking_ref_no' => $booking_ref_no]); // SELECT THE BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER
    $params = array(
        "booking_ref_no" => $query[0]['booking_ref_no'],
        "booking_status" => "confirmed",
        "payment_status" => "paid",
        "payment_gateway" => $query[0]['payment_gateway'],
        "user_id" => $query[0]['user_id'],
        "transaction_id" => $_POST['transaction_id'],
        "transaction_desc" => "Payment for Invoice " . $query[0]['booking_ref_no'],
        "transaction_type" => $_POST['transaction_type'],
        "transaction_date" => date('Y-m-d'),
        "transaction_payment_gateway" => $query[0]['payment_gateway'],
        "transaction_amount" => $query[0]['price_markup'],
        "transaction_currency" => $query[0]['currency_markup'],
    );
    if (!empty($query)) {
        //UPDATE THE DATA IN HOTELS_BOOKING TABLE IN DATABASE
        $update = $db->update("tours_bookings", [
            'user_id' => $params['user_id'],
            'booking_date' => date('Y-m-d'),
            'booking_status' => $params['booking_status'],
            'transaction_id' => $params['transaction_id'],
            'payment_status' => $params['payment_status'],
            'payment_gateway' => $params['payment_gateway'],
            'payment_date' => date('Y-m-d'),
        ], [
                "booking_ref_no" => $booking_ref_no
            ]);

        $data = $db->select("tours_bookings", '*', ["booking_ref_no" => $booking_ref_no]); // SELECT THE UPDATED BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER
        
        //INSERT THE TRANSACTION INFO IN TRANSACTION TABLE IN DATABASE
        if ($data[0]['payment_status'] == 'paid') {
            $transaction_entry = $db->insert("transactions", [
                'description' => $params['transaction_desc'],
                'user_id' => $data[0]['user_id'],
                'trx_id' => $data[0]['transaction_id'],
                'type' => $params['transaction_type'],
                'date' => date('Y-m-d'),
                'amount' => $data[0]['price_markup'],
                'payment_gateway' => $data[0]['payment_gateway'],
                'currency' => $data[0]['currency_markup']
            ]);
        }

        // HOOK 
        $user = (json_decode($data[0]['user_data']));
        $hook = "tours_update_booking";
        include "./hooks.php";

        $response = array('status' => true, 'data' =>  $booking_ref_no);
    } else {
        $response = array('status' => false, 'data' => 'Please enter valid booking ref no');
    }
    echo json_encode($response);
});

/*=======================
TOURS BOOKING CANCELLATION API
=======================*/
$router->post('tours/cancellation', function () {
    //CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    $booking_ref_no = $_POST["booking_ref_no"];

    $params = array('cancellation_request' => 1, );
    $data = $db->update("tours_bookings", $params, ["booking_ref_no" => $booking_ref_no]); //UPDATE THE CANCELATION STATUS IN DATABASE IF REQUEST IS MADE

    $booking = $db->select("tours_bookings", '*', ["booking_ref_no" => $booking_ref_no]);
    $user = (json_decode($booking[0]['user_data']));

    // HOOK 
    $hook = "tours_cancellation_request";
    include "./hooks.php";

    echo json_encode(array('status' => true, 'message' => 'request received successfully'));

});

?>