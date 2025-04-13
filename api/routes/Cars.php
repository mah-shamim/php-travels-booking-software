<?php
// HEADERS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("X-Frame-Options: SAMEORIGIN");


/*==================
THIS FUNCTION IS USED TO SET THE MARKUP PRICE
==================*/
function price_conn($price, $currency)
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
function carsmarkup($module_id, $price, $date, $location)
{
    $conn = openconn();
    $markup = $conn->select('markups', "*", ['type' => 'cars', 'module_id' => $module_id, 'status' => 1]);
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
TOURS SEARCH API
==================*/
$router->post('cars/search', function () {

    // INCLUDE CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('from_airport');
    required('language');
    required('date');
    required('adults');
    required('childs');
    required('currency');
    required('ip');

    //PARAMETERS
    $params = array(
        "from_airport" => $_POST['from_airport'],
        "lang" => $_POST['language'],
        "date" => $_POST['date'],
        "adults" => $_POST['adults'],
        "childs" => $_POST['childs'],
        "currency" => $_POST['currency'],
        "ip" => $_POST['ip'],
    );

    $module = $db->select('modules', '*', ['name' => 'cars','type' => 'cars','status' => 1]);
    if (!empty($module[0]['id'])) {
        $cars = $db->select('cars', '*', ['airport_code' => $params['from_airport']]);
        $m_cars = [];
        if (!empty($cars)) {
            foreach ($cars as $key => $value) {
                $con_price = price_conn($value['price'],$params['currency']);
                $markup = carsmarkup($module[0]['id'],$value['price'],$params['date'],$value['car_city']);
                $price_markup = ($markup['b2c']) ? $markup['b2c'] : $markup['b2b'] ;
                $m_cars[]= [
                    'id' => $value['id'],
                    'title' => $value['name'],
                    'img' => $value['img'],
                    'stars' => $value['stars'],
                    'from_airport' => $value['airport_code'],
                    'desc' => $value['desc'],
                    'supplier_name' => "cars",
                    'module_color' => $module [0]['module_color'],
                    'price' => $price_markup,
                    'actual_price' => $value['price'],
                    'b2c_price' =>$markup['b2c'],
                    'b2b_price' => $markup['b2b'],
                    'b2c_markup' => $markup['b2c_markup'],
                    'b2b_markup' => $markup['b2b_markup'] ,  
                    'currency' => $params['currency'],
                    'redirect' => "",
                    'color' => $module[0]['module_color']
                ];
            }
        }
        $response = array("status" => true, "message" => "MANUAL CARS", "data" => $m_cars);
    } else {
        $response = array("status" => false, "message" => "MANUAL CARS", "data" => "NO CARS AVAILABLE FOR THIS AIRPORT");
    }
    echo json_encode($response);
});

/*=======================
CARS_BOOKING REQUEST API
=======================*/
$router->post('cars/booking', function () {
    
    //CONFIG FILE
    include "./config.php";
    //VALIDATION
    $user_data=json_decode($_POST['user_data']);
    $param = array(
        "booking_ref_no" => date('Ymdhis'),
        "car_id" => $_POST['car_id'],
        "booking_status" => 'pending',
        "price_markup" => $_POST['price_markup'],
        "actual_price" => $_POST['actual_price'],
        "amount_paid"=>0,
        "payment_status" =>'unpaid',
        "payment_gateway" => $_POST['booking_payment_gateway'],
        "first_name"=>$_POST['first_name'],
        "last_name"=>$_POST['last_name'],
        "email"=>$_POST['email'],
        "address"=>$_POST['address'],
        "phone_country_code"=>$_POST['phone_country_code'],
        "phone"=>$_POST['phone'],
        "country"=>$user_data->country_code,
        "booking_date" => date("Y-m-d"),
        "user_id" => $_POST['user_id'],
        "booking_additional_notes"=>"",
        "infants" =>0,
        "adults" => $_POST['booking_adults'],
        "childs" => $_POST['booking_childs'],
        "currency_original" => $_POST['booking_curr_code'],
        "currency_markup" => $_POST['booking_curr_code'],
        "transaction_id" => "",
        "guest" => $_POST['booking_guest_info'],
        "user_data" => $_POST['user_data'],
        "booking_data" => $_POST['booking_data'],
        "booking_response" => "",
        "payment_desc" => "",
        "supplier" => $_POST['booking_supplier'],
        "payment_date" => "",
        "redirect" => "",
        "cars_name" => $_POST['cars_name'],
        "car_img" => $_POST['car_img'],
        "car_location" => $_POST['car_location'],
        "car_stars" => $_POST['car_stars'],
        "cancellation_request" => $_POST['cancellation'],
        "cancellation_status" => 0,
        "module_type" => $_POST['module_type'],
        "pnr" => ""
    );

    $db->insert("cars_bookings", $param); //INSERTION OF BOOKING DATA INTO DATABASE
    $data = (json_decode($_POST["user_data"]));
    $data = (object) array_merge((array) $data, array('booking_ref_no' => $param['booking_ref_no']));
    // HOOK 
    $hook = "cars_booking";
    include "./hooks.php";
    echo json_encode(array('status' => true, 'id' => $db->id(), 'booking_ref_no' => $param['booking_ref_no']));
});

/*=======================
CARS_BOOKING INVOICE API
=======================*/
$router->post('cars/invoice', function () {

    // CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    $booking_ref_no = $_POST["booking_ref_no"];

    $response = $db->select("cars_bookings", "*", ['booking_ref_no' => $booking_ref_no]); // SELECT THE BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER 
    if (!empty($response)) {
        echo json_encode(array('status' => true, 'response' => $response)); // RETURN INVOICE IF BOOKING REFERENCE NUMBER IS CORRECT
    } else {
        echo json_encode(array('status' => false, 'response' => 'The booking reference number in invalid')); // RETURN IF BOOKING REFERENCE NUMBER IS CORRECT
    }
});

/*=======================
CARS BOOKING PAYMENT UPDATE API
=======================*/
$router->post('cars/booking_update', function () {
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    required('transaction_id');
    required('transaction_type');

    $booking_ref_no = $_POST['booking_ref_no'];
    $query = $db->select("cars_bookings", "*", ['booking_ref_no' => $booking_ref_no]); // SELECT THE BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER
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
        //UPDATE THE DATA IN CARS_BOOKING TABLE IN DATABASE
        $update = $db->update("cars_bookings", [
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

        $data = $db->select("cars_bookings", '*', ["booking_ref_no" => $booking_ref_no]); // SELECT THE UPDATED BOOKING DATA FROM DATABASE ACCORDING TO BOOKING REFERENCE NUMBER
        
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
        $hook = "cars_update_booking";
        include "./hooks.php";

        $response = array('status' => true, 'data' =>  $booking_ref_no);
    } else {
        $response = array('status' => false, 'data' => 'Please enter valid booking ref no');
    }
    echo json_encode($response);
});

/*=======================
CARS BOOKING CANCELLATION API
=======================*/
$router->post('cars/cancellation', function () {
    //CONFIG FILE
    include "./config.php";

    // VALIDATION
    required('booking_ref_no');
    $booking_ref_no = $_POST["booking_ref_no"];

    $params = array('cancellation_request' => 1, );
    $data = $db->update("cars_bookings", $params, ["booking_ref_no" => $booking_ref_no]); //UPDATE THE CANCELATION STATUS IN DATABASE IF REQUEST IS MADE

    $booking = $db->select("cars_bookings", '*', ["booking_ref_no" => $booking_ref_no]);
    $user = (json_decode($booking[0]['user_data']));

    // HOOK 
    $hook = "cars_cancellation_request";
    include "./hooks.php";

    echo json_encode(array('status' => true, 'message' => 'request received successfully'));

});

?>