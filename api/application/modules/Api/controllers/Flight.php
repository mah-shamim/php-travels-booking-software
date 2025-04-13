<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Flight extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('ApiClient');
        $this->load->library('Flights/Flights_lib');
        $this->load->model('Admin/Modules_model');
       // header('Content-type: application/json');

    }
    public function search_post(){
        //Manaul Flights API Api
        $Flights = $this->App->service('ModuleService')->isActive("Flights");
        if ($this->post('type') == 'return') {
            $checktrip = 'round';
        }else{
            $checktrip = 'oneway';
        }
        $currency = $this->post('currency');
        if ($checktrip == 'round' ) {
            $returndate = date('Y-m-d', strtotime($this->post('return_date')));
            $adults = intval($this->post('adults') ? $this->post('adults') : 1);
            $childrens = intval($this->post('childrens') ? $this->post('childrens') : 0);
            $infants =  intval($this->post('infants') ? $this->post('infants') : 0);
        } else {
            $returndate = "";
            $adults = intval($this->post('adults') ? $this->post('adults') : 1);
            $childrens = intval($this->post('childrens') ? $this->post('childrens') : 0);
            $infants =  intval($this->post('infants') ? $this->post('infants') : 0);
        }
        if ($this->post('class_type') == 'economy') {
            $class = "economy";
        } else if ($this->post('class_type') == 'business') {
            $class = "business";
        } else {
            $class = "Y";
        }

        if($Flights == 1) {
            $origin =  ($this->post('origin')) ? strtoupper($this->post('origin')) : "";
            $destination = ($this->post('destination')) ? strtoupper($this->post('destination')) : "";
            $type = $checktrip ? $checktrip : 'oneway';
            $departure_date = date('Y-m-d', strtotime($this->post('departure_date')));
            $return_date = $returndate;
            $class_trip = $class;

            $paylod = $this->post();
            $this->Flights_lib->search_logs($paylod);


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>  site_url().'api/new_flights/search?appKey='.$this->input->get('appKey').'&from='.$origin.'&to='.$destination.'&departure_date='.$departure_date.'&arrival_date='.$return_date.'&type='.$type.'&cabinclass='.$class_trip.'&adults='.$adults.'&childs='.$childrens.'&infants='.$infants.'&currency='.$currency,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: ci_session=4dd34e644b9cf60f6b6dd035da89da1f5215fc9c'
                ),
            ));

            $res = curl_exec($curl);
            $rep = json_decode($res);
            curl_close($curl);
        }

        
        // Multithreading Flights Search Api's
        $Multithreading = $this->App->service('ModuleService')->flightmodules();

        $array = array();
       foreach ($Multithreading as $key=>$value){
          $getvalue = $this->Modules_model->getmodulename($value['name']);
            $param = array(
                'c1' => $getvalue[0]->c1,
                'c2' => $getvalue[0]->c2,
                'c3' => $getvalue[0]->c3,
                'c4' => $getvalue[0]->c4,
                'c5' => $getvalue[0]->c5,
                'c6' => $getvalue[0]->c6,
                'c7' => $getvalue[0]->c7,
                'c8' => $getvalue[0]->c8,
                'c9' => $getvalue[0]->c9,
                'c10' => $getvalue[0]->c10,
                'origin' => ($this->post('origin')) ? strtoupper($this->post('origin')) : "",
                'destination' => ($this->post('destination')) ? strtoupper($this->post('destination')) : "",
                'triptypename' => $this->post('triptypename') ? $this->post('triptypename') : 'oneway',
                'departure_date' =>date('Y-m-d', strtotime($this->post('departure_date'))),
                'return_date' => $returndate,
                'adults' => $adults,
                'childrens' => $childrens,
                'infants' => $infants,
                'endpoint' => "https://travelapi.co/modules/flights/".strtolower($value['name'])."/api/v1/search",
                'class_trip' => $class,
                "currency" => $this->post('currency'),
                "type" => $checktrip,
            );
            $fligts = new ApiClient();
            $response = $fligts->sendRequest('POST', 'search', $param);
            array_push($array,json_decode($response));
       }
       // dd($array); die;
        $json = $array;
        $arr = [];
        foreach ($json as $value){
            foreach ($value as $data){
                $return["segments"] = array();
                foreach ($data->segments as $seg ) {
                    $one_array = array();
                    $segments["segments"] = array();
                    foreach ($seg as $segment) {
                        $bj = (object)[
                            "departure_flight_no" => $segment->departure_flight_no,
                            "img" => $segment->img,
                            "departure_time" => $segment->departure_time,
                            "departure_date" => $segment->departure_date,
                            "arrival_time" => $segment->arrival_time,
                            "arrival_date" => $segment->arrival_date,
                            "departure_code" => $segment->departure_code,
                            "departure_airport" => $segment->departure_airport,
                            "arrival_code" => $segment->arrival_code,
                            "arrival_airport" => $segment->arrival_airport,
                            "duration_time" => $segment->duration_time,
                            "currency_code" => $segment->currency_code,
                            "price" => $segment->price,
                            "adult_price" => $segment->adult_price,
                            "child_price" => $segment->child_price,
                            "infant_price" => $segment->infant_price,
                            "url" => '',
                            "airline_name" => $segment->airline_name,
                            "class_type" => $segment->class_type,
                            "form" => $segment->form,
                            "form_name" => '',
                            "action" => '',
                            "type" => $segment->type,
                            "luggage" => '',
                            "desc" => '',
                            "booking_token" => $segment->booking_token,
                            "refundable" => '',
                        ];
                        array_push($one_array, $bj);
                    }
                    if($checktrip == 'round'){
                        $return["segments"][] = $one_array;
                    }else{
                        $segments["segments"][] = $one_array;
                    }
                }
                if($checktrip == 'round') {
                    array_push($arr, $return);
                }else{
                    array_push($arr, $segments);
                }
            }
        }

        if(!empty($arr) && !empty($rep)){
            $data = array_merge($rep,$arr);
        }elseif (!empty($arr)){
            $data = $arr;
        }elseif (!empty($rep)){
            $data = $rep;
        }else{
            $data = '';
        }

        $this->response($data);
    }

    function book_post()
    {
        $param = array(
            'flight_id' => $this->post('flight_id'),
            'total_price' => $this->post('total_price'),
            'firstname' => $this->post('firstname'),
            'lastname' => $this->post('lastname'),
            'email' => $this->post('email'),
            'address' => $this->post('address'),
            'phone' => $this->post('phone'),
            'flight_type' => $this->post('flight_type'),
            'booking_adults' => $this->post('adults'),
            'booking_childs' => $this->post('childs'),
            'booking_infants' => $this->post('infants'),
            'booking_deposit' => $this->post('deposit'),
            'booking_tax' => $this->post('tax'),
            'booking_curr_code' => $this->post('curr_code'),
            'tax_type' => $this->post('tax_type'),
            'deposit_type' => $this->post('deposit_type'),
            'booking_supplier' => $this->post('supplier'),
            'booking_payment_gateway' => $this->post('payment_gateway'),
            'booking_user_id' => $this->post('user_id'),
            'flights_data' => $this->post('flights_data'),
            'endpoint' => site_url() . "/api/flights/flightbooking?appKey=".$this->input->get('appKey'),
            'booking_key' => $this->post('booking_key'),
            'guest' => $this->post('guest'),
            'supplier_name' => $this->post('supplier_name'),
            'nationality' => $this->post('nationality'),
            'booking_from' => $this->post('booking_from'),
        );
        // $this->response($param); exit;

        $flights = new ApiClient();
        $book = $flights->sendRequest('POST', 'search', $param);
        if(!empty($book)){
            $checkbooking = json_decode($book);
            $site_url = $this->post('invoice_url').$checkbooking->response->sessid."/".$checkbooking->response->id;
            $this->Flights_lib->invoceurlupdate($checkbooking->response->id,$site_url);
            $bookingResult = array('response'=>true,'id'=>$checkbooking->response->id,'sessid'=>$checkbooking->response->sessid);
            $this->response($bookingResult);
        }
    }


    function invoice_get(){
    $parm = array(
      'booking_id' =>$this->get('booking_id'),
      'invoice_id' =>$this->get('invoice_id'),
      'endpoint' => site_url() . "api/flights/flightinovice?appKey=phptravels",
    );
        $flights = new ApiClient();
        $get_invoice = $flights->sendRequest('POST', 'search', $parm);
        $this->response($get_invoice);
    }

    function invoicebooking_post(){
        $parm = array(
            'id' => $this->post('booking_id'),
            'invoice_id' => $this->post('invoice_id'),
            'status' => $this->post('status'),
            'payment_gateway' => $this->post('payment_gateway'),
            'amount_paid' => $this->post('amount_paid'),
            'remaining_amount' => $this->post('remaining_amount'),
            'payment_date' => $this->post('payment_date'),
            'txn_id' => $this->post('txn_id'),
            'token' => $this->post('token'),
            'logs' => $this->post('logs'),
            'payment_status' => $this->post('payment_status'),
            'desc' => $this->post('desc'),
            'endpoint' => site_url()."/api/flights/invoicebooking?appKey=".$this->input->get('appKey'),
        );
        $flights = new ApiClient();
        $bookinvoice = $flights->sendRequest('POST', 'search', $parm);
        $this->response($bookinvoice);
    }

    function cancellation_post(){
        $parm = array(
            'id' => $this->post('booking_id'),
            'invoice_id' => $this->post('invoice_id'),
            'booking_cancellation_request' => $this->post('cancellation_request'),
            'endpoint' => site_url()."/api/flights/cancellationbooking?appKey=".$this->input->get('appKey'),
        );
        $flights = new ApiClient();
        $cancelbook = $flights->sendRequest('POST', 'search', $parm);
        $this->response($cancelbook);
    }

/*flight booking*/
function booking_post(){
    $travelers_information = array();
    $booking_id = $this->post('booking_id');
    $check = $this->Flights_lib->get_booking($booking_id);
    if ($check) {
    $booking_guest_info = json_decode($check->booking_guest_info);
    $guests = [];
    foreach ($booking_guest_info as $key) {
    if ($key->title == 'Mr') {$gender = 'MALE';}else{$gender = 'FEMALE';}
array_push($guests,array(
    "traveler_type"=> $key->traveller_type,
    "title"=> $key->title,
    "first_name"=> $key->first_name,
    "last_name"=> $key->last_name,
    "dateofBirth"=> date('Y-m-d', strtotime($key->dob_year.'-'.$key->dob_month.'-'.$key->dob_day)),
    "gender"=> $gender,
    "email"=> $check->accounts_email,
    "calling_code"=> 34,
    "number"=> $check->ai_mobile,
    "documentType"=> "PASSPORT",
    "birthPlace"=> "Madrid",
    "issuanceLocation"=> "Madrid",
    "issuanceDate"=> date('Y-m-d', strtotime($key->passport_issuance_year.'-'.$key->passport_issuance_month.'-'.$key->passport_issuance_day)),
    "expiryDate"=> date('Y-m-d', strtotime($key->passport_year.'-'.$key->passport_month.'-'.$key->passport_day)),
    "issuanceCountry"=> "ES",
    "validityCountry"=> "ES",
    "nationality"=> "ES",
    "holder"=> true
));
}
    $travelers_information[] = array(
    "first_name"=> $check->ai_first_name,
    "last_name"=> $check->ai_last_name,
    "companyName"=> "PHPTRAVELS",
    "countryCallingCode"=> 34,
    "number"=> $check->ai_mobile,
    "emailAddress"=> $check->accounts_email,
    "address"=> "70 Crown Street, LONDON",
    "postalCode"=> "28014",
    "cityName"=> 'Madrid',
    "countryCode"=> 'ES',
    "traveler_information"=>$guests
);
    $routes = json_decode($check->routes)[0][0]->form;
    $travelers_information = $travelers_information;
    $c1 = 'client_credentials';
    $c2 = 'B9wRGKqW9KitLGURs3hF3KEGlsOSs2rr';
    $c3 = 'sMiP1tjGFDDyeTyD';

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost/modules/flights/amadeus/api/v1/booking',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'flights_data' => json_encode($routes),
        'guest' => json_encode($travelers_information),
        'c1'=> $c1,
        'c2' => $c2,
        'c3' => $c3
    ),
    CURLOPT_HTTPHEADER => array(
    'Cookie: ci_session=f9iaugefmm4r5gpq8jnconavvii48vu7'
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $this->response($response);
    }else{
        $this->response(array('msg'=>'booking data not found!'));
    }

    }
}