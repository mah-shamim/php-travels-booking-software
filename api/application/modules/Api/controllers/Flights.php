<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Flights extends REST_Controller {
    public $final_array = [];
    private $settings;
    function __construct() {
// Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
// Configure limits on our controller methods. Ensure
// you have created the 'limits' table and enabled 'limits'
// within application/config/rest.php
        $this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
        $this->load->model('Flights/Flights_model');
    }

    function featured_get() {
        $list = $this->Hotels_lib->getFeaturedHotels();
        if (!empty ($list)) {
            $this->response(array('response' => $list, 'error' => array('status' => FALSE,'msg' => '')), 200);

        }
        else {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotels could not be found')), 200);
        }
    }

    function list_get() {
        //	$perpage = $this->get('perpage');
        $offset = $this->get('offset');
        // if (empty ($perpage)) {
        // 		$perpage = 10;
        // }
        if (empty ($offset)) {
            $offset = 1;
        }

        $list = $this->Hotels_lib->show_hotels($offset);
        $Objresponse = $list['all_hotels'];
        $totalPages = ceil($list['paginationinfo']['totalrows'] / $list['paginationinfo']['perpage']);
        if (!empty ($Objresponse)){
            $this->response(array('response' => $Objresponse, 'error' => array('status' => FALSE,'msg' => ''), 'totalPages' => $totalPages), 200);

        }else {

            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotels Not found')), 200);
        }
    }


    function book_get() {

        if (!$this->get('hotelId')) {
            $this->response(array('response' => array('error' => 'Hotel ID is required')), 200);
        }
        if (!$this->get('checkIn')) {
            $this->response(array('response' => array('error' => 'Check In date is required')), 200);
        }
        if (!$this->get('checkOut')) {
            $this->response(array('response' => array('error' => 'Check Out date is required')), 200);
        }
        $appCheckin= $this->get('checkIn');
        $checkin = date($this->settings[0]->date_f, strtotime($appCheckin));

        $appCheckout = $this->get('checkOut');
        $checkout = date($this->settings[0]->date_f, strtotime($appCheckout));

        $details = $this->Hotels_lib->getBookResultObject($this->get('hotelId'),$this->get('roomId'),$this->get('roomsCount'),$extrabeds = 0,$checkin,$checkout);

        if (!empty ($details['hotel'])) {
            $this->response(array('response' => $details, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }
        else {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Hotel Details Could Not be Found')), 200);
        }


    }

    function search_get() {

        $arrival_date= $this->get('arrival_date');
        $departure_date= $this->get('departure_date');
        $type = $this->get('type');
        $form = $this->get('from');
        $to = $this->get('to');
        $adults = $this->get('adults');
        $childs = $this->get('childs');
        $infants = $this->get('infants');
        $cabinclass = $this->get('cabinclass');
        $this->load->model('Flights/Flights_model');
        $this->load->library('Flights/Flights_lib');
       $details = $this->Flights_model->getApiRoutes($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);
       if(empty($details) && app()->service("ModuleService")->get('flights')->test == "true")
        {
            $details = $this->Flights_model->getApiRoutes($arrival_date, $departure_date, $type,$form,$to,$cabinclass,app()->service("ModuleService")->get('flights')->test);

        }
        $sendResult = array();
        $demo_details = array();

        foreach ($details as $i => $dt ) {

//            dd($dt->id);
//
            $get_price = $this->Flights_model->flightprice($dt->id,$arrival_date,$departure_date,$type);
            $price = ($get_price[0]->adults * $adults) + ($get_price[0]->childs * $childs) + ($get_price[0]->infants * $infants);
            if($type == 'round'){
                $typeof = 'return';
            }else{
                $typeof = $type;
            }

           // $price = ($get_price[0]->adults * $adults) + ($get_price[0]->childs * $childs) + ($get_price[0]->infants * $infants);
           if ($price != 0) {

            $return_array = [];
            $mainArray = array();
            if (($dt->date_departure == "0000-00-00") || (empty($dt->date_departure))) {
                $date_departure = date('Y-m-d');
            } else {
                $date_departure = $dt->date_departure;
            }
            $ob = (object)["code" => $dt->from_code, "label" => $dt->from_location, "date" => $date_departure
                , "flight_no" => json_decode($dt->flight_no)[0], "time" => $dt->time_departure, "aero_img" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail];
            array_push($mainArray, $ob);
            $transact = json_decode($dt->transact);
            $date_trans = json_decode($dt->date_trans);
            $time_trans = json_decode($dt->time_trans);
            $flight_no = json_decode($dt->flight_no);
            $aero_trans = json_decode($dt->aero_trans);


            for ($index = 0; $index < count($transact); $index++) {
                if (($date_trans[$index] == "0000-00-00") || (empty($date_trans[$index]))) {
                    $date_t = date('Y-m-d', strtotime("+" . ($index + 1) . " day"));
                } else {
                    $date_t = $date_trans[$index];

                }
                $ob = (object)["code" => json_decode($transact[$index])->code, "label" => json_decode($transact[$index])->label, "date" => $date_t
                    , "flight_no" => $flight_no[$index + 1], "time" => $time_trans[$index], "aero_img" => ""];
                array_push($mainArray, $ob);
            }
            if (($dt->date_arrival == "0000-00-00") || (empty($date_trans[$index]))) {
                $date_arrival = date('Y-m-d', strtotime("+" . (count($date_trans) + 1) . " day"));
            } else {
                $date_arrival = $dt->date_arrival;
            }
            $ob = (object)["code" => $dt->to_code, "label" => $dt->to_location, "date" => $date_arrival
                , "flight_no" => json_decode($dt->flight_no)[0], "time" => $dt->time_arrival, "aero_img" => ""];
            array_push($mainArray, $ob);
            $object_array = array();

                   for ($h = 0; $h < count($mainArray); $h += 2) {
                       if (!empty(json_decode($dt->flight_no)[0])) {
                           $flight_no = json_decode($dt->flight_no)[0];
                       } else {
                           $flight_no = "";
                       }
//                $object = (object)[
//                    "from_code"=>$mainArray[$h]->code,
//                    "from_label"=>$mainArray[$h]->label,
//                    "from_date"=>$mainArray[$h]->date,
//                    "flight_no"=>$flight_no,
//                    "from_time"=>$mainArray[$h]->time,
//                    "aero_img"=>$mainArray[$h]->aero_img,
//                    "to_code"=>$mainArray[$h+1]->code,
//                    "to_label"=>$mainArray[$h+1]->label,
//                    "to_date"=>$mainArray[$h+1]->date,
//                    "to_time"=>$mainArray[$h+1]->time,
//                ];
//                array_push($object_array,$object);

                       $hidden_parameters = (object)[
                           'tripType' => $type,
                           'setting_id' => $dt->setting_id,
                           'adults' => $adults,
                           'children' => $childs,
                           'infant' => $infants,
                       ];

                       $form = $this->hidden_parameters($hidden_parameters);
//dd($dt);


                       array_push($object_array, (object)[
                           "img_code" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail,
                           "departure_time" => $mainArray[$h]->time,
                           "departure_date" => date('Y-m-d', strtotime($departure_date)),
                           "arrival_date" => date('Y-m-d', strtotime($departure_date)),
                           "arrival_time" => $mainArray[$h + 1]->time,
                           "departure_code" => $mainArray[$h]->code,
                           "departure_airport" => $mainArray[$h]->label,
                           "arrival_code" => $mainArray[$h + 1]->code,
                           "arrival_airport" => $mainArray[$h + 1]->label,
                           "duration_time" => $details[$i]->total_hour,
                           "currency_code" => $this->Flights_lib->currencycode,
                           "price" => ($get_price[0]->adults * $adults) + ($get_price[0]->childs * $childs) + ($get_price[0]->infants * $infants),
                           "url" => '',
                           "airline_name" => $details[$i]->name,
                           "booking_class" => '',
                           "form" => $form,
                           "form_name" => '',
                           "action" => site_url('flights/book'),
                           "type" => "Manual flight",
                       ]);


                   }

                   $return_array["segments"][] = $object_array;

//            $demo_details[$i] = new stdClass();
//            $demo_details[$i]->mainArray = $object_array;
//            $demo_details[$i]->id = $details[$i]->id;
//            $demo_details[$i]->name = $details[$i]->name;
//            $demo_details[$i]->total_hours = $details[$i]->total_hours;
//            $demo_details[$i]->desc_flight = strip_tags($dt->desc_flight);
//            $demo_details[$i]->thumbnail = PT_FLIGHTS_AIRLINES.$details[$i]->thumbnail;
//            $demo_details[$i]->currency = $this->Flights_lib->currencycode;
//            if(empty($this->Flights_lib->currencysign))
//            {
//                $demo_details[$i]->symbol = "";
//            }
//            else{
//                $demo_details[$i]->symbol = $this->Flights_lib->currencysign;
//            }
//            $demo_details[$i]->price = ($dt->adults_price * $adults)+($dt->child_price * $childs)+($dt->infants_price * $infants);

            if ($type == "round") {

                if ($typeof == "return") {
                    $mainArray = array();
                    if (($details[$i + 1]->date_departure == "0000-00-00") || (empty($details[$i + 1]->date_departure))) {
                        $date_departure = date('Y-m-d');
                    } else {
                        $date_departure = $details[$i + 1]->date_departure;
                    }

                    $ob = (object)["code" => $details[$i + 1]->from_code, "label" => $details[$i + 1]->from_location, "date" => $date_departure
                        , "flight_no" => json_decode($details[$i + 1]->flight_no)[0], "time" => $details[$i + 1]->time_departure, "aero_img" => PT_FLIGHTS_AIRLINES . $details[$i + 1]->thumbnail];
                    array_push($mainArray, $ob);

                    $transact = json_decode($details[$i + 1]->transact);
                    $date_trans = json_decode($details[$i + 1]->date_trans);
                    $time_trans = json_decode($details[$i + 1]->time_trans);
                    $flight_no = json_decode($details[$i + 1]->flight_no);
                    $aero_trans = json_decode($details[$i + 1]->aero_trans);

                    $object_array = array();
                    for ($index = 0; $index < count($transact); $index++) {
                        if (($date_trans[$index] == "0000-00-00") || (empty($date_trans[$index]))) {
                            $date_t = date('Y-m-d');
                        } else {
                            $date_t = $date_trans[$index];
                        }
                        $ob = (object)["code" => json_decode($transact[$i])->code, "label" => json_decode($transact[$i])->label, "date" => $date_t
                            , "flight_no" => $flight_no[$index + 1], "time" => $time_trans[$index], "aero_img" => ""];
                        array_push($mainArray, $ob);
                    }
                    if (($details[$i + 1]->date_arrival == "0000-00-00") || (empty($details[$i + 1]->date_arrival))) {
                        $date_arrival = date('Y-m-d');
                    } else {
                        $date_arrival = $details[$i + 1]->date_arrival;
                    }
                    $ob = (object)["code" => $details[$i + 1]->to_code, "label" => $details[$i + 1]->to_location, "date" => $date_arrival
                        , "flight_no" => json_decode($details[$i + 1]->flight_no)[0], "time" => $details[$i + 1]->time_arrival, "aero_img" => ""];
                    array_push($mainArray, $ob);


                    $object_array = array();
                    for ($h = 0; $h < count($mainArray); $h += 2) {
                        if (!empty(json_decode($dt->flight_no)[0])) {
                            $flight_no = json_decode($dt->flight_no)[0];
                        } else {
                            $flight_no = "";
                        }

//                        $object = (object)[
//                            "from_code"=>$mainArray[$h]->code,
//                            "from_label"=>$mainArray[$h]->label,
//                            "from_date"=>$mainArray[$h]->date,
//                            "flight_no"=>$flight_no,
//                            "from_time"=>$mainArray[$h]->time,
//                            "aero_img"=>$mainArray[$h]->aero_img,
//                            "to_code"=>$mainArray[$h+1]->code,
//                            "to_label"=>$mainArray[$h+1]->label,
//                            "to_date"=>$mainArray[$h+1]->date,
//                            "to_time"=>$mainArray[$h+1]->time,
//                        ];

                        array_push($object_array, (object)[
                            "img_code" => PT_FLIGHTS_AIRLINES . $details[$i]->thumbnail,
                            "departure_time" => $mainArray[$h]->time,
                            "departure_date" =>$arrival_date,
                            "arrival_date" => $arrival_date,
                            "arrival_time" => $mainArray[$h + 1]->time,
                            "departure_code" => $mainArray[$h]->code,
                            "departure_airport" => $mainArray[$h]->label,
                            "arrival_code" => $mainArray[$h + 1]->code,
                            "arrival_airport" => $mainArray[$h + 1]->label,
                            "duration_time" => $details[$i]->total_hour,
                            "currency_code" => $this->Flights_lib->currencycode,
                            "price" =>  ($get_price[0]->adults * $adults) + ($get_price[0]->childs * $childs) + ($get_price[0]->infants * $infants),
                            "url" => '',
                            "airline_name" => $details[$i]->name,
                            "booking_class" => '',
                            "form" => $form,
                            "form_name" => '',
                            "action" => site_url('flights/book'),
                            "type" => "Manual flight",
                        ]);

                    }

                    $return_array["segments"][] = $object_array;

                    //dd($object_array);
                    array_push($this->final_array, $return_array);

//                    $details[$i]->price = ($dt->adults_price * $adults)+($details[$i+1]->adults_price*$adults)+($dt->child_price * $childs)+($details[$i+1]->child_price*$childs)+($dt->infants_price * $infants)+($details[$i+1]->infants_price*$infants);
//                    $details[$i+1]->thumbnail = PT_FLIGHTS_AIRLINES.$details[$i+1]->thumbnail;
//                    $details[$i+1]->mainArray = $object_array_return;
//                    $demo_details[$i] = array("oneway"=>$demo_details[$i],"return"=>$details[$i+1]);
//                    array_push($sendResult,$demo_details[$i]);
                }

            } else {

                array_push($this->final_array, $return_array);

//                $demo_details[$i] = array("oneway"=>$demo_details[$i],"return"=>json_decode('{}'));
//                array_push($sendResult,$demo_details[$i]);
            }
        }
        }
        if (!empty ($details)){
            echo json_encode($this->final_array);
        }
    }

    function suggestions_get(){
        $query = $this->input->get('query');
        $suggestions = $this->Hotels_lib->suggestionResults($query);

        if(empty($query)){
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Query missing')), 200);
        }

        if (!empty ($suggestions['forApi']['items'])) {
            $this->response(array('response' => $suggestions['forApi']['items'], 'error' => array('status' => FALSE,'msg' => '')), 200);
        }
        else {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results could not be found')), 200);
        }
    }


    function user_post() {
        $message = array('name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        $this->response($message, 200); // 200 being the HTTP response code
    }

    function invoice_post()
    {
        $this->load->model('Admin/Bookings_model');
        $userid = $this->post('userId');
        $payload = $this->post();
        if(!empty($userid) )
        {
            $data = $this->Bookings_model->do_flights_booking($payload);
        }
        else
        {
            $data = $this->Bookings_model->do_flights_guest_booking($payload);
        }
        $message = array('response' => $data);
        $this->response($message, 200); // 200 being the HTTP response code
    }

    function flightbooking_post()
    {
        $payload = $this->post();
        $this->load->model('Admin/Bookings_model');
        //$userid = $payload['booking_user_id'];
        if($payload['booking_user_id'] == 0){
            unset($payload['booking_user_id']);
        }
        if(!empty($payload['booking_user_id']) )
        {
            $data = $this->Bookings_model->flights_booking($payload);
        }
        else
        {
            $data = $this->Bookings_model->flights_guest_booking($payload);
        }

        $message = array('response' => $data);
        $this->response($message, 200);
    }


    function flightinovice_post(){
        $payload = $this->post();
        $this->load->model('Admin/Bookings_model');
        $data = $this->Bookings_model->flights_invoice($payload);
        $this->response($data, 200);
    }

    function cancellationbooking_post(){
        $payload = $this->post();
        $this->load->model('Admin/Bookings_model');
        $data = $this->Bookings_model->flightcancelbooking($payload);
        $this->response($data, 200);
    }

    function invoicebooking_post(){
        $payload = $this->post();
        $this->load->model('Admin/Bookings_model');
        $data = $this->Bookings_model->flightbookinginvoiceupdate($payload);
        $this->response($data, 200);
    }
    function countries_get() {
        $this->load->model('Admin/Countries_model');
        $list = $this->Countries_model->Api_all_countries();
        if (!empty ($list)) {
            $this->response(array('response' => $list, 200)); // 200 being the HTTP response code
        }
        else {
            $this->response(array('response' => array('error' => 'countries could not be found')), 200);
        }
    }

    function show_get($param,$vars = null) {
        $arr = $this->input->get();
        $arrstr = "";
        foreach($arr as $key => $val){
            $arrstr .= $key."=".$val."&";
        }

        $url = base_url()."api/hotels/".$param."?".$arrstr;
        //	$url = base_url() . "api/hotels/hoteldetails?id=40";
        //  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
        //  $url = base_url()."api/hotels/user";
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        @ $json = json_decode($rawdata);
        echo "<pre>";
        print_r($json);
    }

    function chkpost_get() {
// $url = base_url()."api/hotels/list";
// $url = base_url()."api/hotels/hoteldetails?id=40";
//  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
        $url = base_url() . "api/hotels/invoice";
        $fields = array('email' => 'mail@example.com', 'firstname' => 'JohnDue', 'room' => "25_250_2", 'checkin' => "12/01/2015", 'checkout' => "15/01/2015", 'lastname' => "JohnDue", 'phone' => "1323", 'address' => "fafdasf", 'payment_type' => 'Paypal_Express', 'id' => "123", 'title' => "hotel name", 'depost' => "123", 'total_amount' => "456", 'tax' => "123456", 'payment_method_tax' => "15", 'nights' => 3);
//url-ify the data for the POST
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        @ $json = json_decode($rawdata);
        echo "<pre>";
        print_r($json);
    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input name="tripType" type="hidden"  value="'.$hidden_parameters->tripType.'" />';
        $input .= '<input name="setting_id" type="hidden"  value="'.$hidden_parameters->setting_id.'" />';
        $input .= '<input name="adults" type="hidden"  value="'.$hidden_parameters->adults.'" />';
        $input .= '<input name="children" type="hidden"  value="'.$hidden_parameters->children.'" />';
        $input .= '<input name="infant" type="hidden"  value="'.$hidden_parameters->infant.'" />';
        return $input;

    }

}
