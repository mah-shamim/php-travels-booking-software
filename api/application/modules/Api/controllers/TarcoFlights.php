<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class TarcoFlights extends REST_Controller {
    private $settings;
    private $config = [];
    const MODULE = "FlightTarco";

    function __construct() {
// Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->config = $this->App->service('ModuleService')->get(self::MODULE)->apiConfig;
        $this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
        $this->load->model('Flights/Flights_model');
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

        $currency = "SAR";


        $OriginDestinations = array();
        $passengers = array();

        array_push($OriginDestinations, array(
            "OriginCode" => $form,
            "DestinationCode" => $to,
            "TargetDate" => $departure_date
        ));

        if ($form->tripType == "return") {
            array_push($OriginDestinations, array(
                "OriginCode" => $form,
                "DestinationCode" => $to,
                "TargetDate" => $arrival_date
            ));
        }

        if ($form->passenger->adult > 0 ) {
            array_push($passengers, array(
                "Ref" => "PADT",
                "PassengerQuantity" => $adults,
                "PassengerTypeCode" => "AD"
            ));
        }

        if ($form->passenger->children > 0) {
            array_push($passengers, array(
                "Ref" => "PCHD",
                "PassengerQuantity" => $childs,
                "PassengerTypeCode" => "CHD"
            ));
        }

        if ($form->passenger->infant > 0) {
            array_push($passengers, array(
                "Ref" => "PINF",
                "PassengerQuantity" => $infants,
                "PassengerTypeCode" => "INF"
            ));
        }
        $requestPaylod = array(
            "FareDisplaySettings" => array(
                "SaleCurrencyCode" => $currency
            ),
            "OriginDestinations" => $OriginDestinations,
            "Passengers" => $passengers
        );
        $this->load->library("FlightTarco/TarcoClient");
        $response = $this->TarcoClient->callService("SearchFlights", $requestPaylod,$this->config);
        if ($response->ResponseInfo->Error != null) {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results Not found')), 200);
        }
        $this->load->model('FlightTarco/FlightTarcoSearchRsp');
        $FlightTarcoSearchRsp = new FlightTarcoSearchRsp($response);
        if (!empty ($FlightTarcoSearchRsp)){
            $this->response(array('response' =>$FlightTarcoSearchRsp->final_array, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }else {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results Not found')), 200);
        }
    }
    function detail_get() {
        $this->load->library("FlightTarco/TarcoClient");


        $payload = $this->input->get();
        $response = $this->TarcoClient->callService("PrepareFlights", array(
            "Offer" => array(
                "Ref" => $payload['Offer_Ref'],
                "RefItinerary" => $payload['Offer_RefItinerary']
            )
        ));
        if ($response->ResponseInfo->Error != null) {
            exit($response->ResponseInfo->Error->Message);
        }
//        $this->load->model('FlightTarco/PrepareFlightsRsp');
//        $FlightTarcoSearchRsp = new PrepareFlightsRsp($response);

        if (!empty ($response)){
            $this->response(array('response' => $response, 'error' => array('status' => FALSE,'msg' => '')), 200);

        }else {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results Not found')), 200);

        }
    }

}
