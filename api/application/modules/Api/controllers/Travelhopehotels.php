<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Travelhopehotels extends REST_Controller {

    const MODULE = "TravelhopeHotels";
    private $config = [];
    const SLUG = "thhotels";
    
    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('TravelhopeHotels/ApiClient');
        $this->load->library('Hotels/Hotels_lib');
        $this->load->model('TravelhopeHotels/TravelhopeHotelsSearchForm');
        $this->load->model('TravelhopeHotels/BookinngEngineBookings');
        $this->config = $this->App->service('ModuleService')->get(self::MODULE)->apiConfig;
        $this->client_ip = $this->input->ip_address();
       }

       /*TravelHopeHotel Suggestion Search Place*/
       public function suggestions_post(){
           $query = $this->post('query');
           $suggestions = $this->Hotels_lib->suggestionResults_v2($query);

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

   /*TravelHopeHotel Get List*/
   public function list_post(){
       $city = $this->post('city');
       $country = $this->post('country');
       $checkin = $this->post('checkin');
       $checkout = $this->post('checkout');
       $adults = $this->post('adults');
       $children = $this->post('children');
       $currceny_code = $this->post('currceny_code');
       $par = array($city,$country,$checkin,$checkout,$adults,$children);
       $searchForm = new TravelhopeHotelsSearchForm();
       $searchForm->parseUriString($par);
       $searchForm->setOtaId($this->config->ota_id);
       $searchForm->setCurrency($currceny_code);
       $searchForm->setIpAddress($this->client_ip);
       $thfBooking = new BookinngEngineBookings();
       $thfBooking->setSearchRequest($searchForm->getInJson());
       $thfBooking->setDestination($searchForm->getDestination());
       $thfBooking->setCheckin($searchForm->getCheckin());
       $thfBooking->setCheckout($searchForm->getCheckout());
       $thfBooking->setAdults($searchForm->getAdults());
       $thfBooking->setChildren($searchForm->getChildren());
       $thope = new ApiClient($this->config);
       log_message('debug', 'SearchRequest[travelhopeHotels]: ' . $searchForm->getInJson());
       $response = $thope->sendRequest('GET', 'search', $searchForm);
       log_message('debug', 'SearchResponse[travelhopeHotels]: ' . $response);
       $thfBooking->setSearchResponse($response);
       $response = json_decode($response);
       if($response->data){
           $this->response(array('response' => $response->data, 'error' => array('status' => FALSE,'msg' => '')), 200);
       }else{
           $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results could not be found')), 200);
       }
   }

    /*TravelHopeHotel Get detail*/
    public function detail_post(){
        $thfBooking = new BookinngEngineBookings();
        $detailRequestPayload = array(
            'currency' => $this->post('currency'),
            'checkin' => $this->post('checkin'),
            'checkout' => $this->post('checkout'),
            'hotel_id' =>$this->post('hotel_id'),
            'ip_address' => '::1',
            'ota_id' => $this->config->ota_id,
            'vendor' => 3,
            'custom_payload' => $this->post('custom_payload')
        );
        $thope = new ApiClient($this->config);
        $thfBooking->setCheckoutRequest(json_encode($detailRequestPayload));
        $response = $thope->sendRequest('GET', 'details', $detailRequestPayload);
        $thfBooking->setCheckoutResponse($response);
        $response = json_decode($response);
        if($response->hotels){
            $this->response(array('response' => $response->hotels, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }else{
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results could not be found')), 200);
        }
    }

    /*TravelHopeHotel Booking*/
    public function book_post(){
        // Booking object
        $thfBooking = new BookinngEngineBookings();
        $thfBooking->setUserId($this->post('user_id'));
        $thfBooking->setHotelName($this->post('hotel_name'));
        $thfBooking->setRoomName($this->post('room_name'));
        $thfBooking->setPrice($this->post('price'));
        $thfBooking->setCurrency($this->post('currency'));
        $thfBooking->setCheckin($this->post('checkin'));
        $thfBooking->setCheckout($this->post('checkout'));
        $thfBooking->setAdults($this->post('adults'));
        $thfBooking->setChildren($this->post('children'));

        $this->load->model(self::MODULE.'/Booking');
        $booking = new Booking();
        $booking->setAccount([
            'title' => $this->post('title'),
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'email' => $this->post('email'),
            'mobile_code' => $this->post('mobile_code'),
            'number' => $this->post('number')
        ]);
        $booking->setPaymentDetails([
            'name_card' => $this->post('name_card'),
            'card_no' => $this->post('card_no'),
            'month' => $this->post('month'),
            'year' => $this->post('year'),
            'security_code' => $this->post('security_code')
        ]);
        $booking->setHotelData([
            'hotel_id' => $this->post('hotel_id'),
            'hotel_name' => $this->post('hotel_name'),
            'room_name' => $this->post('room_name'),
            'rating' => $this->post('rating'),
            'address' => $this->post('address'),
            'mobile_number' => $this->post('mobile_number'),
            'longitude' => $this->post('longitude'),
            'latitude' => $this->post('latitude')
        ]);
        $booking->setRoomData([
            'checkin' => $this->post('checkin'),
            'checkout' => $this->post('checkout'),
            'adults' => $this->post('adults'),
            'children' => $this->post('children'),
            'room_id' => $this->post('room_id'),
            'price' => $this->post('price'),
            'currency' =>$this->post('currency')
        ]);
        $booking->setOtaId($this->config->ota_id);
        $booking->setVendor('3');
        $booking->setIpAddress('::1');
        $thope = new ApiClient($this->config);
        $thfBooking->setBookingRequest($booking->toJson());
        $response = $thope->sendRequest('POST', 'booking', $booking->toJson(), array('Content-Type:application/json'));
        $thfBooking->setBookingResponse($response);
        $response = json_decode($response);
        if ($response->code == 200) {
            // log response in db.
            $thfBooking->setBookingId($response->data->id);
            $this->response(array('response' => base_url(self::SLUG."/invoice/{$response->data->id}?n=y"), 'error' => array('status' => FALSE,'msg' => '')), 200);
        } else {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results could not be found')), 200);
        }
        $thfBooking->update();

    }
}