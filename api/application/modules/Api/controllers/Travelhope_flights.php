<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Travelhope_flights extends REST_Controller {
    const Module = "TravelhopeFlights";
    private $config = [];
    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        /*Load Library and Model*/
        $this->load->library('TravelhopeFlights/ApiClient');
        $this->load->library('TravelhopeFlights/Model/SearchForm');
        $this->load->library('Hotels/Hotels_lib');
        $this->load->model('TravelhopeFlights/BookinngEngineBookings');
        $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;
        $this->output->set_content_type('application/json');
    }

    /*Travel Hope Flights Get all Data List */
    public function search_post()
    {

        if ($this->config->api_environment == 'sandbox') {
            $test = 1;
        }else{
            $test = 0;
        }
        $thfBooking = new BookinngEngineBookings();
        $milliseconds = round(microtime(true) * 1000);
        $thfBooking->setSessionKey($milliseconds);
        $searchForm = new SearchForm();
        $searchForm->ota_id = $this->config->ota_id;
        $searchForm->test = $test;
        $searchForm->currency = $this->Hotels_lib->currencycode;

        $searchForm->from_code = $this->post('from_code');
        $searchForm->to_code = $this->post('to_code');
        $searchForm->date_from = $this->post('date_from');
        $searchForm->return_from = $this->post('return_from');
        $searchForm->adults = $this->post('adults');
        $searchForm->children = $this->post('children');
        $searchForm->infants = $this->post('infants');
        $searchForm->flight_type = $this->post('flight_type');
        $thfBooking->setSearchRequest(json_encode($searchForm));
        $thfBooking->setOrigin($searchForm->from_code);
        $thfBooking->setDestination($searchForm->to_code);
        $thfBooking->setDepartureDate($searchForm->date_from);
        $thfBooking->setArrivalDate($searchForm->return_from);
        $thfBooking->setAdults($searchForm->adults);
        $thfBooking->setChildren($searchForm->children);
        $thfBooking->setInfants($searchForm->infants);
        $thope = new ApiClient($this->config);
        $response = $thope->sendRequest('GET', 'search', $searchForm);

        $thfBooking->setSearchResponse('');
        $thfBooking->save();


        if (!empty ($response)) {
            echo  $response;
        }else{

            $this->response(array('response' => '', 'error' => array('status' => FALSE,'msg' => 'Record not found')), 200);

        }
    }

    /*Travel Hope Flights Detail Api*/
    public function detail_post(){

        if ($this->config->api_environment == 'sandbox') {
            $test = 1;
        }else{
            $test = 0;
        }
        $pnum = $this->post('adults') + $this->post('children') + $this->post('infants');
        $params = array(
            'bnum' => $pnum,
            'pnum' => $pnum,
            'test' =>  $test,
            'custom_payload' => array(
                'booking_token' => $this->post('booking_token'),
                'visitor_uniqid' =>$this->post('visitor_uniqeid'),
            ),
            'flight_id' => $this->post('flight_id'),
            'adults' => $this->post('adults'),
            'children' => $this->post('children'),
            'infants' => $this->post('infants'),
            'ota_id' => $this->config->ota_id,
            'vendor' => 5
        );
        $thope = new ApiClient($this->config);
        $response = $thope->sendRequest('POST', 'details', json_encode($params), ["Content-Type:application/json"]);
        $contents = $response;
        echo  $contents;
    }

    /*Travel Hope Flights Booking*/
    public function booking_post(){

        if ($this->config->api_environment == 'sandbox') {
            $test = 1;
        }else{
            $test = 0;
        }

        $this->load->library('TravelhopeFlights/Model/Booking');
        $booking = new Booking();

        $params = array(
            'custom_payload' => json_decode($this->post('custom_payload')),
            'flight_id' => $this->post('flight_id'),
            'account' =>[
                'title' => $this->post('title'),
                'first_name' => $this->post('first_name'),
                'last_name' => $this->post('last_name'),
                'email' => $this->post('email'),
                'mobile_code' => $this->post('mobile_code'),
                'number' => $this->post('number'),
            ],
            'adults' => json_decode($this->post('adults')),
            'children'=>json_decode($this->post('children')),
            'infants' => json_decode($this->post('infants')),
            'special_request' => '',
            'payment_details' => [
                'name_card' => $this->post('name_card'),
                'card_no' => $this->post('card_no'),
                'month' => $this->post('month'),
                'year' => $this->post('year'),
                'security_code' => $this->post('security_code'),
            ],
            'flight_data' => array(
                array(
                    'operating_airline_iata' => $this->post('operating_airline_iata'),
                    'operating_airline_name' => $this->post('operating_airline_name'),
                    'from_city' => $this->post('from_city'),
                    'from_code' => $this->post('from_code'),
                    'to_code' => $this->post('to_code'),
                    'departure_time' => $this->post('departure_time'),
                    'to_city' => $this->post('to_city'),
                    'arrival_time' => $this->post('arrival_time'),
                    'price' => $this->post('price'),
                    'flight_id' => $this->post('flight_id'),
                    'to_country' => $this->post('to_country'),
                    'from_country' => $this->post('from_country'),
                    'to_station' => $this->post('to_station'),
                    'from_station' => $this->post('from_station'),
                    'flight_no' => $this->post('flight_no')
                ),
                array(
                    'operating_airline_iata' => $this->post('operating_airline_iata'),
                    'operating_airline_name' => $this->post('operating_airline_name'),
                    'from_city' => $this->post('from_city'),
                    'from_code' => $this->post('from_code'),
                    'to_code' => $this->post('to_code'),
                    'departure_time' => $this->post('departure_time'),
                    'to_city' => $this->post('to_city'),
                    'arrival_time' => $this->post('arrival_time'),
                    'price' => $this->post('price'),
                    'flight_id' => $this->post('flight_id'),
                    'to_country' => $this->post('to_country'),
                    'from_country' => $this->post('from_country'),
                    'to_station' => $this->post('to_station'),
                    'from_station' => $this->post('from_station'),
                    'flight_no' => $this->post('flight_no')
                ),
            ),
            'voucher' => 0,
            'ota_id' => $this->config->ota_id,
            'vendor' => 5,
            'test' => $test,
            'ip_address' => '127.0.0.1'

        );
        $booking->setCustomPayload($params['custom_payload']);
        $booking->setFlightId($params['flight_id']);
        $booking->setAccount($params['account']);
        $booking->setAdults($params['adults']);
        $booking->setChildren($params['children']);
        $booking->setInfants($params['infants']);
        $booking->setPaymentDetails($params['payment_details']);
        $flightData = $params['flight_data'];
        $booking->setFlightData($flightData);
        $booking->setVoucher(0);
        $booking->setOtaId($this->config->ota_id);
        $booking->setVendor(5);
        $booking->setIpAddress('127.0.0.1');
        $booking->setpaymentmetod($test);
        $thope = new ApiClient($this->config);
        $response = $thope->sendRequest('POST', 'booking', $booking->toJson(), ["content-Type:application/json"]);
        echo  $response;
    }
}