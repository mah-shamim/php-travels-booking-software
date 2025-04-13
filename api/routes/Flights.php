<?php
function m_flight()
{
    include "./config.php";
    $data = $db->select("modules", ['status', 'module_color', 'id'], ["type" => 'flights', 'name' => 'flights', 'status' => 1]);
    if (!empty($data)) {
        return $data;
    }
}

function get_flight($m_param)
{
    $db = openconn(); // Open a connection to the database.
    $get_data = $db->select("flights", "*", ["from_airport" => $m_param['origin'], 'to_airport' => $m_param['destination'], 'status' => 1]);
    if (!empty($get_data)) {
        return $get_data;
    }else{
        return [];
    }
}

function flight_stop($flight_id)
{
    $db = openconn(); // Open a connection to the database.
    $stop_data = $db->select("flights_routes", "*", ["flights_id" => $flight_id]);
    if (!empty($stop_data)) {
        return $stop_data;
    }
}

function airline_name($code)
{
    $db = openconn(); // Open a connection to the database.
    $airline_name = $db->select("flights_airlines", "name", ["iata" => $code]);
    if (!empty($airline_name)) {
        return $airline_name[0];
    }else{
        return '';
    }
}

function total_duration($id)
{
    $db = openconn(); // Open a connection to the database.
    $total_duration = $db->query("SELECT SUM(flights_routes.duration) AS total_duration 
                             FROM flights 
                             JOIN flights_routes ON flights.id = flights_routes.flights_id 
                             WHERE flights.id = " . $id)->fetchColumn();
    if (!empty($total_duration)) {
        return $total_duration;
    } else {
        return 0;
    }
}

function markup($module_id, $price, $date, $origin, $destination,$user_id)
{
    $conn = openconn(); // Open a connection to the database.
    $markup = $conn->select('markups', "*", ['module_id' => $module_id, 'status' => 1]);
    if (!empty($markup)) {
        //THIS CODE CHECKS IF THE DATES ARE PRESENT OR NOT AND MAKES A SAME FORMAT OF DATE
        if (($markup[0]['from_date'] != null && $markup[0]['to_date'] != null)) {
            $from_date = new DateTime($markup[0]['from_date']);
            $to_date = new DateTime($markup[0]['to_date']);
            $date = new DateTime($date);
        } else {
            $from_date = "";
            $to_date = "";
        }
        //THIS CODE CHECKS IF THE ORIGIN AND DESTINATION ARE PRESENT OR NOT AND FETCHES THE ID'S
        if ($markup[0]['origin'] != null && $markup[0]['destination'] != null) {
            $dep_airport = $conn->select('flights_airports', ['id'], ['code' => $origin]);
            $arr_airport = $conn->select('flights_airports', ['id'], ['code' => $destination]);
            $departure_airport = $dep_airport[0]['id'];
            $arrival_airport = $arr_airport[0]['id'];
        } else {
            $departure_airport = $origin;
            $arrival_airport = $destination;
        }

        $response = '';
        //THIS CODE PROVIDES THE MARKUP PICES ON THE BASE OF DATE,LOCATION,USER
        if ((($from_date <= $date && $to_date >= $date) || ($markup[0]['origin'] == $departure_airport && $markup[0]['destination'] == $arrival_airport)) && $user_id == '') {
            $response = $price + ($markup[0]['b2c_markup'] * $price) / 100;
            $markup_percentage = $markup[0]['b2c_markup'];
        } else if($user_id != ''){
            $response = $price + ($markup[0]['b2b_markup'] * $price) / 100;
            $markup_percentage = $markup[0]['b2b_markup'];
        } else {
            $response = ($markup[0]['b2c_markup'] != '') ? $price + ($markup[0]['b2c_markup'] * $price) / 100 :  $price + ($markup[0]['user_markup'] * $price) / 100;
            $markup_percentage = ($markup[0]['b2c_markup'] != '') ? $markup[0]['b2c_markup'] : $markup[0]['user_markup'];
        }
    } else {
        $response = $price;
        $markup_percentage = "0";
    }
    return [$response, $markup_percentage];
}

// INCLUDE CONFIG
// This function retrieves a list of all active flight modules.
function getmodules()
{
    $db = openconn(); // Open a connection to the database.

    // Select all modules of type 'flights' from the database
    $respose = $db->select("modules", ['id','name', 'status'], ["type" => 'flights']);
    // Create an empty array to store the module data
    $data = [];
    // Loop through the results and add any active modules (excluding the 'flights' module itself)
    foreach ($respose as $module) {
        if ($module['name'] != 'flights' && $module['status'] == 1) {
            $data[] = array(
                'name' => $module['name'],
                'id' => $module['id']
            );
        }
    }
    // Return the list of active modules
    return $data;
}

/**
 * Retrieves data from the 'modules' table in the database where the module name matches the input.
 *
 * @param string $modulename The name of the module to retrieve data for.
 * @return array|null Returns an array containing the module data if successful, or null if there was an error.
 */
function getmoduledata($modulename)
{
    $conn = openconn(); // Open a connection to the database.
    // Use the database connection to select data from the 'modules' table where the name matches the input.
    $response = $conn->select("modules", "*", ["name" => $modulename]);
    // Return the results.
    return $response;
}

function currencyrate($code)
{
    $conn = openconn(); // Open a connection to the database.
    $response = $conn->select("currencies", "*", ["name" => $code]);
    // Return the results.
    return $response[0]['rate'];
}
/**
 * Saves a booking record to the database.
 *
 * @param array $data An array of data to save.
 *
 * @return array An array containing the response status, ID of the inserted record, and booking reference number.
 */
function save_booking($data)
{
    include "./config.php";
    $data['booking_ref_no'] = date('Ymdhis');
    $data['booking_date'] = date('Y-m-d');
    $data['payment_status'] = 'unpaid';
    $data['booking_status'] = 'pending';
    $db->insert("flights_bookings", $data);
    return array('status' => true, 'id' => $db->id(), 'booking_ref_no' => $data['booking_ref_no']);
}
/**
 * Get booking record to the database.
 *
 * @param array $data An array of data to get.
 *
 * @return array An array containing the response status, and booking response.
 */
function get_booking($data)
{
    include "./config.php"; // include the configuration file
    $response = $db->select("flights_bookings", "*", ['booking_ref_no' => $data['booking_ref_no']]); // select the booking from the database
    if (!empty($response)) {
        return array('status' => true, 'response' => $response); // return the booking details if found
    } else {
        return array('status' => false, 'response' => ''); // return false if the booking was not found
    }
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
function sendRequest($req_method = 'GET', $service = '', $payload = [], $_headers = [])
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


//This function retrieves a list of all flight modules get data.
$router->post('flights/search', function () {

    // INCLUDE CONFIG
    //include "./config.php";

    $main_array = array();
    $object_array = array();

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

    if ($_POST["type"] == 'round') {
        // If the "type" field in the POST request is set to 'return', set the $checktrip variable to 'round'
        $checktrip = 'round';
    } else {
        // If the "type" field in the POST request is not set to 'return', set the $checktrip variable to 'oneway'
        $checktrip = 'oneway';
    }

    if ($checktrip == 'round') {
        // If the user has selected a round-trip option, assign the value of the "return_date" field in the POST request to the $return_date variable
        $return_date = $_POST["return_date"];
        // Assign the integer value of the "adults" field in the POST request to the $adults variable, or 1 if the field is not set or is empty
        $adults = intval($_POST["adults"] ? $_POST["adults"] : 1);
        // Assign the integer value of the "children" field in the POST request to the $children variable, or 0 if the field is not set or is empty
        $children = intval($_POST["children"] ? $_POST["children"] : 0);
        // Assign the integer value of the "infants" field in the POST request to the $infants variable, or 0 if the field is not set or is empty
        $infants = intval($_POST["infants"] ? $_POST["infants"] : 0);
    } else {
        // If the user has selected a one-way trip option, set the $return_date variable to an empty string
        $return_date = "";
        // Assign the integer value of the "adults" field in the POST request to the $adults variable, or 1 if the field is not set or is empty
        $adults = intval($_POST["adults"] ? $_POST["adults"] : 1);
        // Assign the integer value of the "children" field in the POST request to the $children variable, or 0 if the field is not set or is empty
        $children = intval($_POST["children"] ? $_POST["children"] : 0);
        // Assign the integer value of the "infants" field in the POST request to the $infants variable, or 0 if the field is not set or is empty
        $infants = intval($_POST["infants"] ? $_POST["infants"] : 0);
    }
    if ($_POST["class_type"] == 'economy') {
        // If the "class_type" field in the POST request is set to 'economy', set the $class variable to "economy"
        $class = "economy";
    } else if ($_POST["class_type"] == 'business') {
        // If the "class_type" field in the POST request is set to 'business', set the $class variable to "business"
        $class = "business";
    } else {
        // If the "class_type" field in the POST request is set to neither 'economy' nor 'business', set the $class variable to "Y"
        $class = "Y";
    }
    $response = m_flight();
    if (!empty($response)) {
        $m_param = array(
            'origin' => ($_POST["origin"]) ? strtoupper($_POST["origin"]) : "",
            'destination' => ($_POST["destination"]) ? strtoupper($_POST["destination"]) : "",
        );
        $get_flight = get_flight($m_param);
        $test_array = array();
        if ($checktrip == 'oneway') {
            foreach ($get_flight as $value) {
                // Get the current exchange rate for the segment's currency
                $current_currency_price = currencyrate('USD');
                // Get the exchange rate for the user's selected currency
                $con_rate = currencyrate($_POST["currency"]);


                // Calculate the adult price in the current currency, if both the segment's adult price and the current currency price are available
                if (!empty($value['adult_seat_price']) && !empty($current_currency_price)) {
                    $adult_price = ceil(str_replace(',', '', $value['adult_seat_price']) / $current_currency_price);
                } else {
                    // If either the segment's adult price or the current currency price is missing, set the adult price to 0
                    $adult_price = 0;
                }

                // Calculate the children price in the current currency, if both the segment's children price and the current currency price are available
                if (!empty($value['child_seat_price']) && !empty($current_currency_price)) {
                    $child_price = ceil(str_replace(',', '', $value['child_seat_price']) / $current_currency_price);
                } else {
                    // If either the segment's children price or the current currency price is missing, set the children price to 0
                    $child_price = 0;
                }

                // Calculate the infant price in the current currency, if both the segment's infant price and the current currency price are available
                if (!empty($value['infant_seat_price']) && !empty($current_currency_price)) {
                    $infant_price = ceil(str_replace(',', '', $value['infant_seat_price']) / $current_currency_price);
                } else {
                    // If either the segment's infant price or the current currency price is missing, set the infant price to 0
                    $infant_price = 0;
                }

                // Convert prices to the current currency using the conversion rate
                $a_price = $adult_price * $con_rate; // Adult price
                $c_price = $child_price * $con_rate; // Child price
                $i_price = $infant_price * $con_rate; // Infant price

                //Flights Stop
                $flight_stop = flight_stop($value['id']);

                $totalDuration = (total_duration($value['id'])) + ( (int)$value['duration'] );
                $check_airport = '';
                $airport = [];
                if (!empty($flight_stop)) {
                    foreach ($flight_stop as $key => $stop_data) {
                        $check_airport = $stop_data['from_airport'];
                        $airport[$key] = $stop_data['from_airport'];
                        if ($key == 1) {
                            $air_port = $airport[0];
                        } elseif ($key == 2) {
                            $air_port = $airport[1];
                        } else {
                            $air_port = $value['from_airport'];
                        }

                        $am_price = markup($response[0]['id'], $a_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'],$_POST["user_id"]);
                        $cm_price = markup($response[0]['id'], $c_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'],$_POST["user_id"]);
                        $im_price = markup($response[0]['id'], $i_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'],$_POST["user_id"]);
                        $test_array[] = (object) [
                            "img" => '',
                            "flight_no" => (string) $value['id'],
                            "airline" => airline_name($value['airline']),
                            "class" => $_POST["class_type"],
                            "baggage" => $value['baggage'],
                            "cabin_baggage" => $value['cabin_baggage'],
                            "departure_airport" => $air_port,
                            "departure_time" => date("H:i",strtotime($stop_data['departure_time'])),
                            "departure_date" => $_POST["departure_date"],
                            "departure_code" => $air_port,
                            "arrival_airport" => $stop_data['from_airport'],
                            "arrival_date" => $_POST["departure_date"],
                            "arrival_time" => date("H:i",strtotime($stop_data['arrival_time'])),
                            'arrival_code' => $stop_data['from_airport'],
                            'duration_time' =>  $stop_data['duration'],
                            'total_duration' => (string) $totalDuration,
                            'currency' => $_POST["currency"],
                            'actual_currency' => $_POST["currency"],
                            'actual_price' => (string) $value['adult_seat_price'],
                            'price' => number_format((float) $a_price, 2, '.', ''),
                            'adult_price' => number_format((float) $a_price, 2, '.', ''),
                            'adult_markup_price' => number_format((float) $am_price[0], 2, '.', ''),
                            'child_price' => number_format((float) $c_price, 2, '.', ''),
                            'child_markup_price' => number_format((float) $cm_price[0], 2, '.', ''),
                            'infant_price' => number_format((float) $i_price, 2, '.', ''),
                            'infant_markup_price' => number_format((float) $im_price[0], 2, '.', ''),
                            'markup_percentage' => $am_price[1],
                            'booking_data' => (object) [],
                            'redirect_url' => '',
                            'refundable' =>$value['refundable'],
                            "supplier" => 'flights',
                            "type" => $_POST['type'],
                            "color" => $response[0]['module_color'],
                        ];
                    }
                }

                if (!empty($check_airport)) {
                    $from_airport = $check_airport;
                } else {
                    $from_airport = $value['from_airport'];
                }
                $am_price = markup($response[0]['id'], $a_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'],$_POST["user_id"]);
                $cm_price = markup($response[0]['id'], $c_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'],$_POST["user_id"]);
                $im_price = markup($response[0]['id'], $i_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'],$_POST["user_id"]);
                $test_array[] = (object) [
                    "img" => '',
                    "flight_no" => (string) $value['id'],
                    "airline" => airline_name($value['airline']),
                    "class" => $_POST["class_type"],
                    "baggage" => $value['baggage'],
                    "cabin_baggage" => $value['cabin_baggage'],
                    "departure_airport" => $from_airport,
                    "departure_time" => date("H:i",strtotime($value['departure_time'])),
                    "departure_date" => $_POST["departure_date"],
                    "departure_code" => $from_airport,
                    "arrival_airport" => $value['to_airport'],
                    "arrival_date" => $_POST["departure_date"],
                    "arrival_time" => date("H:i",strtotime($value['arrival_time'])),
                    'arrival_code' => $value['to_airport'],
                    'duration_time' => $value['duration'],
                    'total_duration' => (string) $totalDuration,
                    'currency' => $_POST["currency"],
                    'actual_currency' => $_POST["currency"],
                    'actual_price' => (string) $value['adult_seat_price'],
                    'price' => number_format((float) $a_price, 2, '.', ''),
                    'adult_price' => number_format((float) $a_price, 2, '.', ''),
                    'adult_markup_price' => number_format((float) $am_price[0], 2, '.', ''),
                    'child_price' => number_format((float) $c_price, 2, '.', ''),
                    'child_markup_price' => number_format((float) $cm_price[0], 2, '.', ''),
                    'infant_price' => number_format((float) $i_price, 2, '.', ''),
                    'infant_markup_price' => number_format((float) $im_price[0], 2, '.', ''),
                    'markup_percentage' => $am_price[1],
                    'booking_data' => (object) [],
                    'redirect_url' => '',
                    'refundable' =>$value['refundable'],
                    "supplier" => 'flights',
                    "type" => $_POST['type'],
                    "color" => $response[0]['module_color'],
                ];
                $object_array[] = $test_array;
                $main_array[]["segments"] = $object_array;
                $test_array = [];
                $object_array = [];
            }
        }

        if ($checktrip == 'round') {

            // Get the current exchange rate for the segment's currency
            $current_currency_price = currencyrate('USD');
            // Get the exchange rate for the user's selected currency
            $con_rate = currencyrate($_POST["currency"]);


            // Calculate the adult price in the current currency, if both the segment's adult price and the current currency price are available
            if (!empty($get_flight[0]['adult_seat_price']) && !empty($current_currency_price)) {
                $adult_price = ceil(str_replace(',', '', $get_flight[0]['adult_seat_price']) / $current_currency_price);
            } else {
                // If either the segment's adult price or the current currency price is missing, set the adult price to 0
                $adult_price = 0;
            }

            // Calculate the children price in the current currency, if both the segment's children price and the current currency price are available
            if (!empty($get_flight[0]['child_seat_price']) && !empty($current_currency_price)) {
                $child_price = ceil(str_replace(',', '', $get_flight[0]['child_seat_price']) / $current_currency_price);
            } else {
                // If either the segment's children price or the current currency price is missing, set the children price to 0
                $child_price = 0;
            }

            // Calculate the infant price in the current currency, if both the segment's infant price and the current currency price are available
            if (!empty($get_flight[0]['infant_seat_price']) && !empty($current_currency_price)) {
                $infant_price = ceil(str_replace(',', '', $get_flight[0]['infant_seat_price']) / $current_currency_price);
            } else {
                // If either the segment's infant price or the current currency price is missing, set the infant price to 0
                $infant_price = 0;
            }

            // Convert prices to the current currency using the conversion rate
            $a_price = $adult_price * $con_rate; // Adult price
            $c_price = $child_price * $con_rate; // Child price
            $i_price = $infant_price * $con_rate; // Infant price

            //Flights Stop
            $flight_stop = flight_stop($get_flight[0]['id']);
            $totalDuration = (total_duration($get_flight[0]['id'])) + ((int)$get_flight[0]['duration']);
            $check_airport = '';
            $airport = [];
            if (!empty($flight_stop)) {
                foreach ($flight_stop as $key => $stop_data) {
                    $check_airport = $stop_data['from_airport'];
                    $airport[$key] = $stop_data['from_airport'];
                    if ($key == 1) {
                        $air_port = $airport[0];
                    } elseif ($key == 2) {
                        $air_port = $airport[1];
                    } else {
                        $air_port = $get_flight[0]['from_airport'];
                    }
                    $am_price = markup($response[0]['id'], $a_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                    $cm_price = markup($response[0]['id'], $c_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                    $im_price = markup($response[0]['id'], $i_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                    $test_array[] = (object)[
                        "img" => '',
                        "flight_no" => (string)$get_flight[0]['id'],
                        "airline" => airline_name($get_flight[0]['airline']),
                        "class" => $_POST["class_type"],
                        "baggage" => $get_flight[0]['baggage'],
                        "cabin_baggage" => $get_flight[0]['cabin_baggage'],
                        "departure_airport" => $air_port,
                        "departure_time" => date("H:i", strtotime($stop_data['departure_time'])),
                        "departure_date" => $_POST["departure_date"],
                        "departure_code" => $air_port,
                        "arrival_airport" => $stop_data['from_airport'],
                        "arrival_date" => $_POST["departure_date"],
                        "arrival_time" => date("H:i", strtotime($stop_data['arrival_time'])),
                        'arrival_code' => $stop_data['from_airport'],
                        'duration_time' => $stop_data['duration'],
                        'total_duration' => (string)$totalDuration,
                        'currency' => $_POST["currency"],
                        'actual_currency' => $_POST["currency"],
                        'actual_price' => (string)$get_flight[0]['adult_seat_price'],
                        'price' => number_format((float)$a_price, 2, '.', ''),
                        'adult_price' => number_format((float)$a_price, 2, '.', ''),
                        'adult_markup_price' => number_format((float)$am_price[0], 2, '.', ''),
                        'child_price' => number_format((float)$c_price, 2, '.', ''),
                        'child_markup_price' => number_format((float)$cm_price[0], 2, '.', ''),
                        'infant_price' => number_format((float)$i_price, 2, '.', ''),
                        'infant_markup_price' => number_format((float)$im_price[0], 2, '.', ''),
                        'markup_percentage' => $am_price[1],
                        'booking_data' => (object)[],
                        'refundable' => '',
                        'redirect_url' => '',
                        "supplier" => 'flights',
                        "type" => $_POST['type'],
                        "color" => $response[0]['module_color'],
                    ];
                }
            }

            if (!empty($check_airport)) {
                $from_airport = $check_airport;
            } else {
                $from_airport = $get_flight[0]['from_airport'];
            }
            $am_price = markup($response[0]['id'], $a_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
            $cm_price = markup($response[0]['id'], $c_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
            $im_price = markup($response[0]['id'], $i_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
            $test_array[] = (object)[
                "img" => '',
                "flight_no" => (string)$get_flight[0]['id'],
                "airline" => airline_name($get_flight[0]['airline']),
                "class" => $_POST["class_type"],
                "baggage" => $get_flight[0]['baggage'],
                "cabin_baggage" => $get_flight[0]['cabin_baggage'],
                "departure_airport" => $from_airport,
                "departure_time" => date("H:i", strtotime($get_flight[0]['departure_time'])),
                "departure_date" => $_POST["departure_date"],
                "departure_code" => $from_airport,
                "arrival_airport" => $get_flight[0]['to_airport'],
                "arrival_date" => $_POST["departure_date"],
                "arrival_time" => date("H:i", strtotime($get_flight[0]['arrival_time'])),
                'arrival_code' => $get_flight[0]['to_airport'],
                'duration_time' => $get_flight[0]['duration'],
                'total_duration' => (string)$totalDuration,
                'currency' => $_POST["currency"],
                'actual_currency' => $_POST["currency"],
                'actual_price' => (string)$get_flight[0]['adult_seat_price'],
                'price' => number_format((float)$a_price, 2, '.', ''),
                'adult_price' => number_format((float)$a_price, 2, '.', ''),
                'adult_markup_price' => number_format((float)$am_price[0], 2, '.', ''),
                'child_price' => number_format((float)$c_price, 2, '.', ''),
                'child_markup_price' => number_format((float)$cm_price[0], 2, '.', ''),
                'infant_price' => number_format((float)$i_price, 2, '.', ''),
                'infant_markup_price' => number_format((float)$im_price[0], 2, '.', ''),
                'markup_percentage' => $am_price[1],
                'booking_data' => (object)[],
                'redirect_url' => '',
                'refundable' => '',
                "supplier" => 'flights',
                "type" => $_POST['type'],
                "color" => $response[0]['module_color'],
            ];

            $object_array[] = $test_array;


            $return_param = array(
                'origin' => ($_POST["destination"]) ? strtoupper($_POST["destination"]) : "",
                'destination' => ($_POST["origin"]) ? strtoupper($_POST["origin"]) : "",
            );

            $return_flight = get_flight($return_param);
            if (!empty($return_flight)) {
                // Calculate the adult price in the current currency, if both the segment's adult price and the current currency price are available
                if (!empty($return_flight[0]['adult_seat_price']) && !empty($current_currency_price)) {
                    $adult_price = ceil(str_replace(',', '', $return_flight[0]['adult_seat_price']) / $current_currency_price);
                } else {
                    // If either the segment's adult price or the current currency price is missing, set the adult price to 0
                    $adult_price = 0;
                }

                // Calculate the children price in the current currency, if both the segment's children price and the current currency price are available
                if (!empty($return_flight[0]['child_seat_price']) && !empty($current_currency_price)) {
                    $child_price = ceil(str_replace(',', '', $return_flight[0]['child_seat_price']) / $current_currency_price);
                } else {
                    // If either the segment's children price or the current currency price is missing, set the children price to 0
                    $child_price = 0;
                }

                // Calculate the infant price in the current currency, if both the segment's infant price and the current currency price are available
                if (!empty($return_flight[0]['infant_seat_price']) && !empty($current_currency_price)) {
                    $infant_price = ceil(str_replace(',', '', $return_flight[0]['infant_seat_price']) / $current_currency_price);
                } else {
                    // If either the segment's infant price or the current currency price is missing, set the infant price to 0
                    $infant_price = 0;
                }

                // Convert prices to the current currency using the conversion rate
                $a_price = $adult_price * $con_rate; // Adult price
                $c_price = $child_price * $con_rate; // Child price
                $i_price = $infant_price * $con_rate; // Infant price

                //Flights Stop
                $return_stop = flight_stop($return_flight[0]['id']);
                $totalDuration = (total_duration($return_flight[0]['id'])) + ((int)$return_flight[0]['duration']);
                $check_airport = '';
                $airport = [];
                if (!empty($return_stop)) {
                    foreach ($return_stop as $key => $return_data) {
                        $check_airport = $return_data['from_airport'];
                        $airport[$key] = $return_data['from_airport'];
                        if ($key == 1) {
                            $air_port = $airport[0];
                        } elseif ($key == 2) {
                            $air_port = $airport[1];
                        } else {
                            $air_port = $get_flight[0]['from_airport'];
                        }
                        $am_price = markup($response[0]['id'], $a_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                        $cm_price = markup($response[0]['id'], $c_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                        $im_price = markup($response[0]['id'], $i_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                        $test_array[] = (object)[
                            "img" => '',
                            "flight_no" => (string)$return_flight[0]['id'],
                            "airline" => airline_name($return_flight[0]['airline']),
                            "class" => $_POST["class_type"],
                            "baggage" => $return_flight[0]['baggage'],
                            "cabin_baggage" => $return_flight[0]['cabin_baggage'],
                            "departure_airport" => $air_port,
                            "departure_time" => date("H:i", strtotime($return_data['departure_time'])),
                            "departure_date" => $_POST["return_date"],
                            "departure_code" => $air_port,
                            "arrival_airport" => $return_data['from_airport'],
                            "arrival_date" => $_POST["return_date"],
                            "arrival_time" => date("H:i", strtotime($return_data['arrival_time'])),
                            'arrival_code' => $return_data['from_airport'],
                            'duration_time' => $return_data['duration'],
                            'total_duration' => (string)$totalDuration,
                            'currency' => $_POST["currency"],
                            'actual_currency' => $_POST["currency"],
                            'actual_price' => (string)$return_flight[0]['adult_seat_price'],
                            'price' => number_format((float)$a_price, 2, '.', ''),
                            'adult_price' => number_format((float)$a_price, 2, '.', ''),
                            'adult_markup_price' => number_format((float)$am_price[0], 2, '.', ''),
                            'child_price' => number_format((float)$c_price, 2, '.', ''),
                            'child_markup_price' => number_format((float)$cm_price[0], 2, '.', ''),
                            'infant_price' => number_format((float)$i_price, 2, '.', ''),
                            'infant_markup_price' => number_format((float)$im_price[0], 2, '.', ''),
                            'markup_percentage' => $am_price[1],
                            'booking_data' => (object)[],
                            'refundable' => '',
                            'redirect_url' => '',
                            "supplier" => 'flights',
                            "type" => $_POST['type'],
                            "color" => $response[0]['module_color'],
                        ];
                    }
                }

                if (!empty($check_airport)) {
                    $from_airport = $check_airport;
                } else {
                    $from_airport = $return_flight[0]['from_airport'];
                }
                $am_price = markup($response[0]['id'], $a_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                $cm_price = markup($response[0]['id'], $c_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                $im_price = markup($response[0]['id'], $i_price, $_POST["departure_date"], $get_flight[0]['from_airport'], $get_flight[0]['to_airport'], $_POST["user_id"]);
                $obj[] = (object)[
                    "img" => '',
                    "flight_no" => (string)$return_flight[0]['id'],
                    "airline" => airline_name($return_flight[0]['airline']),
                    "class" => $_POST["class_type"],
                    "baggage" => $return_flight[0]['baggage'],
                    "cabin_baggage" => $return_flight[0]['cabin_baggage'],
                    "departure_airport" => $from_airport,
                    "departure_time" => date("H:i", strtotime($return_flight[0]['departure_time'])),
                    "departure_date" => $_POST["return_date"],
                    "departure_code" => $from_airport,
                    "arrival_airport" => $return_flight[0]['to_airport'],
                    "arrival_date" => $_POST["return_date"],
                    "arrival_time" => date("H:i", strtotime($return_flight[0]['arrival_time'])),
                    'arrival_code' => $return_flight[0]['to_airport'],
                    'duration_time' => $return_flight[0]['duration'],
                    'total_duration' => (string)$totalDuration,
                    'currency' => $_POST["currency"],
                    'actual_currency' => $_POST["currency"],
                    'actual_price' => (string)$return_flight[0]['adult_seat_price'],
                    'price' => number_format((float)$a_price, 2, '.', ''),
                    'adult_price' => number_format((float)$a_price, 2, '.', ''),
                    'adult_markup_price' => number_format((float)$am_price[0], 2, '.', ''),
                    'child_price' => number_format((float)$c_price, 2, '.', ''),
                    'child_markup_price' => number_format((float)$cm_price[0], 2, '.', ''),
                    'infant_price' => number_format((float)$i_price, 2, '.', ''),
                    'infant_markup_price' => number_format((float)$im_price[0], 2, '.', ''),
                    'markup_percentage' => $am_price[1],
                    'booking_data' => (object)[],
                    'redirect_url' => '',
                    "supplier" => 'flights',
                    'refundable' => '',
                    "type" => $_POST['type'],
                    "color" => $response[0]['module_color'],
                ];

                $object_array[] = $obj;
                $main_array[]["segments"] = $object_array;
                $test_array = [];
                $object_array = [];
            }

        }
        $rep = $main_array;
    }

    $array = [];
    // Get all active flight modules
    $Multithreading = getmodules();
    if (!empty($Multithreading)) {
        foreach ($Multithreading as $key => $value) {
            // Get module data for each active module
            $getvalue = getmoduledata($value['name']);
            $module_currency = $getvalue[0]['currency'];
            $color = $getvalue[0]['module_color'];

            // Determine whether the module is in development or production mode
            if ($getvalue[0]['dev_mode'] == 1) {
                $evn = 'pro';
            } else {
                $evn = 'dev';
            }

            // Set parameters for flight search
            $param = array(
                'c1' => $getvalue[0]['c1'],
                'c2' => $getvalue[0]['c2'],
                'c3' => $getvalue[0]['c3'],
                'c4' => $getvalue[0]['c4'],
                'c5' => $getvalue[0]['c5'],
                'evn' => $evn,
                'origin' => ($_POST["origin"]) ? strtoupper($_POST["origin"]) : "",
                'destination' => ($_POST["destination"]) ? strtoupper($_POST["destination"]) : "",
                'triptypename' => $_POST["type"] ? $_POST["type"] : 'oneway',
                'departure_date' => $_POST["departure_date"],
                'class_type' => $_POST["class_type"],
                'return_date' => $return_date,
                'adults' => $adults,
                'childrens' => $children,
                'infants' => $infants,
                'class' => $class,
                //'endpoint' => $root ."/modules/flights/". strtolower($value['name']) ."/api/v1/search",
                'endpoint' => "https://api.phptravels.com/flights/".strtolower($value['name'])."/api/v1/search",
                "currency" => $module_currency,
                "user_ip" => $_POST["ip"],
                "type" => $checktrip,
                "api_mode" => $getvalue[0]['payment_mode'],
            );

            $response = sendRequest('POST', 'search', $param);
            $fligt_rep = json_decode($response);

            if (!empty($fligt_rep)) {
                $arr_rep = [];
                foreach ($fligt_rep as $data_rep) {
                    $return_rep["segments"] = array();
                    foreach ($data_rep->segments as $seg_rep) {
                        $one_array_rep = array();
                        $segments_rep["segments"] = array();
                        foreach ($seg_rep as $segment_rep) {


                            // Get the current exchange rate for the segment's currency
                            $current_currency_price = currencyrate($segment_rep->currency);
                            // Get the exchange rate for the user's selected currency
                            $con_rate = currencyrate($_POST["currency"]);


                            // Convert the segment's price to the user's selected currency
                            if (!empty($segment_rep->price) && !empty($current_currency_price)) {
                                // Remove commas from the price string and divide by the current currency rate, then round up to the nearest whole number
                                $price_get = ceil(str_replace(',', '', $segment_rep->price) / $current_currency_price);
                            } else {
                                // If the segment price or currency rate is not available, set the converted price to 0
                                $price_get = 0;
                            }

                            // Calculate the adult price in the current currency, if both the segment's adult price and the current currency price are available
                            if (!empty($segment_rep->adult_price) && !empty($current_currency_price)) {
                                $adult_price = ceil(str_replace(',', '', $segment_rep->adult_price) / $current_currency_price);
                            } else {
                                // If either the segment's adult price or the current currency price is missing, set the adult price to 0
                                $adult_price = 0;
                            }

                            // Calculate the children price in the current currency, if both the segment's children price and the current currency price are available
                            if (!empty($segment_rep->child_price) && !empty($current_currency_price)) {
                                $child_price = ceil(str_replace(',', '', $segment_rep->child_price) / $current_currency_price);
                            } else {
                                // If either the segment's children price or the current currency price is missing, set the children price to 0
                                $child_price = 0;
                            }

                            // Calculate the infant price in the current currency, if both the segment's infant price and the current currency price are available
                            if (!empty($segment_rep->infant_price) && !empty($current_currency_price)) {
                                $infant_price = ceil(str_replace(',', '', $segment_rep->infant_price) / $current_currency_price);
                            } else {
                                // If either the segment's infant price or the current currency price is missing, set the infant price to 0
                                $infant_price = 0;
                            }

                            // Convert prices to the current currency using the conversion rate
                            $price = $price_get * $con_rate; // Total price
                            $a_price = $adult_price * $con_rate; // Adult price
                            $c_price = $child_price * $con_rate; // Child price
                            $i_price = $infant_price * $con_rate; // Infant price
                            $am_price = markup($value['id'], $a_price, $param["departure_date"], $param['origin'], $param['destination'],$_POST["user_id"]);
                            $cm_price = markup($value['id'], $c_price, $param["departure_date"], $param['origin'], $param['destination'],$_POST["user_id"]);
                            $im_price = markup($value['id'], $i_price, $param["departure_date"], $param['origin'], $param['destination'],$_POST["user_id"]);
                            $m_price = markup($value['id'], $price, $param["departure_date"], $param['origin'], $param['destination'],$_POST["user_id"]);

                            $bj_rep = (object)[
                                "img" => $segment_rep->img,
                                "flight_no" => $segment_rep->flight_no,
                                "airline" => $segment_rep->airline,
                                "class" => $segment_rep->class,
                                "baggage" => $segment_rep->baggage,
                                "cabin_baggage" => $segment_rep->cabin_baggage,
                                "departure_airport" => $segment_rep->departure_airport,
                                "departure_time" => $segment_rep->departure_time,
                                "departure_date" => $segment_rep->departure_date,
                                "departure_code" => $segment_rep->departure_code,
                                "arrival_airport" => $segment_rep->arrival_airport,
                                "arrival_date" => $segment_rep->arrival_date,
                                "arrival_time" => $segment_rep->arrival_time,
                                'arrival_code' => $segment_rep->arrival_code,
                                'duration_time' => $segment_rep->duration_time,
                                'total_duration' => $segment_rep->total_duration,
                                'currency' => $_POST["currency"],
                                'actual_currency' => $segment_rep->currency,
                                'actual_price' => $segment_rep->price,
                                'price' => number_format((float)$m_price[0], 2, '.', ''),
                                'adult_price' => number_format((float)$a_price, 2, '.', ''),
                                'adult_markup_price' => number_format((float)$am_price[0], 2, '.', ''),
                                'child_price' => number_format((float)$c_price, 2, '.', ''),
                                'child_markup_price' => number_format((float)$cm_price[0], 2, '.', ''),
                                'infant_price' => number_format((float)$i_price, 2, '.', ''),
                                'infant_markup_price' => number_format((float)$im_price[0], 2, '.', ''),
                                'markup_percentage' => $m_price[1],
                                'booking_data' => $segment_rep->booking_data,
                                'redirect_url' => $segment_rep->redirect_url,
                                "supplier" => $segment_rep->supplier,
                                "type" => $segment_rep->type,
                                "refundable" => $segment_rep->refundable,
                                "color" => $color,
                            ];
                            $one_array_rep[] = $bj_rep;
                        }
                        if ($checktrip == 'round') {
                            $return_rep["segments"][] = $one_array_rep;
                        } else {
                            $segments_rep["segments"][] = $one_array_rep;
                        }
                    }
                    if ($checktrip == 'round') {
                        $arr_rep[] = $return_rep;
                    } else {
                        $arr_rep[] = $segments_rep;
                    }
                }
                $array[] = $arr_rep;
            }
        }

        $json = $array;
        $arr = [];
        if(!empty($json)){
        foreach ($json as $value) {
            foreach ($value as $data) {
                $return["segments"] = array();
                foreach ($data['segments'] as $seg) {
                    $one_array = array();
                    $segments["segments"] = array();
                    foreach ($seg as $segment) {

                        $bj = (object)[
                            "img" => $segment->img,
                            "flight_no" => $segment->flight_no,
                            "airline" => $segment->airline,
                            "class" => $segment->class,
                            "baggage" => $segment->baggage,
                            "cabin_baggage" => $segment->cabin_baggage,
                            "departure_airport" => $segment->departure_airport,
                            "departure_time" => $segment->departure_time,
                            "departure_date" => $segment->departure_date,
                            "departure_code" => $segment->departure_code,
                            "arrival_airport" => $segment->arrival_airport,
                            "arrival_date" => $segment->arrival_date,
                            "arrival_time" => $segment->arrival_time,
                            'arrival_code' => $segment->arrival_code,
                            'duration_time' => $segment->duration_time,
                            'total_duration' => $segment->total_duration,
                            'currency' => $segment->currency,
                            'actual_currency' => $segment->actual_currency,
                            'actual_price' => $segment->actual_price,
                            'price' => $segment->price,
                            'adult_price' => $segment->adult_price,
                            'adult_markup_price' => $segment->adult_markup_price,
                            'child_price' => $segment->child_price,
                            'child_markup_price' => $segment->child_markup_price,
                            'infant_price' => $segment->infant_price,
                            'infant_markup_price' => $segment->infant_markup_price,
                            'markup_percentage' => $segment->markup_percentage,
                            'booking_data' => $segment->booking_data,
                            'redirect_url' => $segment->redirect_url,
                            "supplier" => $segment->supplier,
                            "refundable" => $segment->refundable,
                            "type" => $segment->type,
                            "color" => $segment->color,
                        ];
                        $one_array[] = $bj;
                    }
                    if ($checktrip == 'round') {
                        $return["segments"][] = $one_array;
                    } else {
                        $segments["segments"][] = $one_array;
                    }
                }
                if ($checktrip == 'round') {
                    $arr[] = $return;
                } else {
                    $arr[] = $segments;
                }
            }
        }
    }

    }

    if (!empty($arr[0]['segments']) && !empty($rep)) {
        $data = array_merge($rep, $arr);
    } elseif (!empty($arr[0]['segments'])) {
        $data = $arr;
    } elseif (!empty($rep)) {
        $data = $rep;
    } else {
        $data = [];
    }
    echo json_encode($data);
});

/**
 * Handles a POST request to book a flight.
 *
 * This function expects the following parameters to be passed in the $_POST array:
 * - module_type: The type of module being booked.
 * - price_original: The original price of the booking.
 * - price_markup: The markup added to the original price.
 * - checkin: The check-in date.
 * - checkout: The check-out date.
 * - adults: The number of adult passengers.
 * - childs: The number of child passengers.
 * - infants: The number of infant passengers.
 * - currency_original: The original currency of the booking.
 * - currency_markup: The currency used for the markup.
 * - booking_data: The booking data.
 * - supplier: The supplier of the booking.
 * - user_id: The ID of the user making the booking.
 * - guest: Whether the booking is for a guest user.
 * - routes: The routes being booked.
 *
 * @return void Outputs a JSON-encoded response containing the result of the booking attempt.
 */
$router->post('flights/book', function () {
    $param = array(
        'module_type' => $_POST["module_type"],
        'payment_gateway' => $_POST["payment_gateway"],
        'price_original' => $_POST["price_original"],
        'price_markup' => $_POST["price_markup"],
        'checkin' => $_POST["checkin"],
        'checkout' => $_POST["checkout"],
        'adults' => $_POST["adults"],
        'childs' => $_POST["childs"],
        'infants' => $_POST["infants"],
        'currency_original' => $_POST["currency_original"],
        'currency_markup' => $_POST["currency_markup"],
        "booking_data" => $_POST["booking_data"],
        "supplier" => $_POST["supplier"],
        "user_id" => $_POST["user_id"],
        "user_data" => $_POST["user_data"],
        "guest" => $_POST["guest"],
        "routes" => $_POST["routes"],
        "flight_type" => $_POST["flight_type"],
    );
    $save_booking = save_booking($param);


    $data = (json_decode($_POST["user_data"]));
    $data = (object) array_merge((array) $data, array('booking_ref_no' => $save_booking['booking_ref_no']));

    // HOOK 
    $hook = "flights_booking";
    include "./hooks.php";

    echo json_encode($save_booking);

});

$router->post('flights/invoice', function () {
    $param = array(
        'booking_ref_no' => $_POST["booking_ref_no"], // set the booking reference number from the POST data
    );
    $get_booking = get_booking($param); // call the get_booking function to retrieve the booking details

    echo json_encode($get_booking); // encode the response as JSON and send it back to the client
});

$router->post('flights/booking_update', function () {
    include "./config.php";

    $data = $db->select("flights_bookings", "*", ["booking_ref_no" => $_POST['booking_ref_no']]);

    if (!empty($data)) {
        $getvalue = getmoduledata($data[0]['supplier']);
        // Determine whether the module is in development or production mode
        if ($getvalue[0]['dev_mode'] == 1) {
            $evn = 'pro';
        } else {
            $evn = 'dev';
        }

        if(!empty($_POST['pit_id'])){
            $pit_id = $_POST['pit_id'];
        }else{
            $pit_id = '';
        }
        if($getvalue[0]['prn_type'] == $_POST['booking_type']) {
            $param = array(
                'c1' => $getvalue[0]['c1'],
                'c2' => $getvalue[0]['c2'],
                'c3' => $getvalue[0]['c3'],
                'c4' => $getvalue[0]['c4'],
                'c5' => $getvalue[0]['c5'],
                'evn' => $evn,
                //'endpoint' => $root . "/modules/flights/".strtolower($data['supplier'])."/api/v1/booking",
                'endpoint' => "https://api.phptravels.com/flights/" . strtolower($data[0]['supplier']) . "/api/v1/booking",
                "booking_ref_no" => $data[0]['booking_ref_no'],
                "booking_data" => $data[0]['booking_data'],
                "guest" => $data[0]['guest'],
                "nationality" => $data[0]['nationality'],
                "flight_type" => $data[0]['flight_type'],
                "user_data" => $data[0]['user_data'],
                "pit_id" => $pit_id,
            );

            $response = sendRequest('POST', 'search', $param);

            $savebooking = json_decode($response);
        }else{
            $savebooking = (object)['Prn'=>'Your booking on Hold'];
        }

        $db->update("flights_bookings", [
            "pnr" => $savebooking->Prn,
            "booking_response" => $response,
            "payment_status" => $_POST['payment_status'],
            "booking_status" => $_POST['booking_status'],
            "transaction_id" => $_POST['transaction_id'],
            "payment_gateway" => $_POST['payment_gateway'],
            "error_response" => $savebooking->response_error,
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

        $user = (json_decode($data[0]['user_data']));

        // HOOK 
        $hook = "flights_update_booking";
        include "./hooks.php";

        if ($savebooking->Prn) {
            echo json_encode(array('status' => true, 'Prn' => $savebooking->Prn));
        } else {
            echo json_encode(array('status' => false, 'Prn' => $savebooking->Prn));
        }
    } else {
        echo json_encode(array('status' => false, 'response' => 'Please valid booking ref no'));
    }
});

$router->post('flights/cancellation', function () {

    include "./config.php";

    $params = array('cancellation_request' => 1, );
    $data = $db->update("flights_bookings", $params, ["booking_ref_no" => $_POST['booking_ref_no']]);

    $booking = $db->select("flights_bookings", '*', ["booking_ref_no" => $_POST['booking_ref_no']]);
    $user = (json_decode($booking[0]['user_data']));

    // HOOK 
    $hook = "flights_cancellation_request";
    include "./hooks.php";

    echo json_encode(array('status' => true, 'message' => 'request received successfully'));

});