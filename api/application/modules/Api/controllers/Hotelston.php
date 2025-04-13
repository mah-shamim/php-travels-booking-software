<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Hotelston extends REST_Controller {
    private $settings;
    function __construct() {
// Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->settings = $this->App->service("ModuleService")->get("hotelston")->settings;
        $this->apiConfig = $this->App->service("ModuleService")->get("hotelston")->apiConfig;
        $this->load->library('Hotelston/HotelApiClient');
        $this->load->model('Hotelston/Hotelston_model');
        $this->load->model('Hotelston/HotelsSearchModel');
        $this->load->library('Hotels/Hotels_lib');

    }

    function suggestions_post(){
        $query = $this->post('query');
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


    public function list_post()
    {
        $searchForm = (object)$this->post();

        if(!empty($this->session->userdata("currencycode"))){
            $curr_code = $this->session->userdata("currencycode");
        }else{
            $curr_code = $this->Hotels_lib->currencycode;
        }

        $current_currency_price = $this->Hotelston_model->currencyrate($this->apiConfig->currency);
        $con_rate = $this->Hotelston_model->currencyrate($curr_code);

        $hotel_id = $this->Hotelston_model->gethotel($this->post("country"));

        $arry = array();
        foreach ($hotel_id as $id){
            $rep = $this->HotelApiClient->callApi($id->hotel_id,$this->apiConfig);
            $reproom = $this->HotelApiClient->getroom($id->hotel_id,$this->apiConfig,$searchForm);
            print_r( $reproom);

            if(!empty($reproom->hotel->channel->room[0]->price) && !empty($current_currency_price)) {
                $price_get = ceil($reproom->hotel->channel->room[0]->price / $current_currency_price);
            }else{
                $price_get = 0;
            }

            $price = ceil($price_get * $con_rate);

            $percent_price =  $price *  $this->settings->markup / 100;
            if($price != 0) {
                array_push($arry, (object)[
                    'id' => $rep->hotel->id,
                    'company_name' => str_replace('&', '', $rep->hotel->name),
                    'description' => strip_tags($rep->hotel->descriptions->description[0]->_),
                    'image' => $rep->hotel->image[0]->url,
                    'city_name' => $rep->hotel->city->name,
                    'rating' => $rep->hotel->starRating,
                    'price' => round($price + $percent_price),
                    'convarte_price' => $price,
                    'percent' => $percent_price,
                    'actuall_price' => $reproom->hotel->channel->room[0]->price,
                    'currencies' => $curr_code,
                ]);
            }
        }
        $this->response(array('response' => $arry, 'error' => array('status' => TRUE,'msg' => '')), 200);

    }


    public function detail_post($slug = '')
    {
        $hotel_id = $this->post('hotel_id');
        $searchForm = (object)$this->post();
        $arry = array();
        $roomarry = array();
        $rep = $this->HotelApiClient->callApi($hotel_id,$this->apiConfig);
        $reproom = $this->HotelApiClient->getroom($hotel_id,$this->apiConfig,$searchForm);

        if(!empty($this->session->userdata("currencycode"))){
            $curr_code = $this->session->userdata("currencycode");
        }else{
            $curr_code = $this->Hotels_lib->currencycode;
        }


        $current_currency_price = $this->Hotelston_model->currencyrate($this->apiConfig->currency);
        $con_rate = $this->Hotelston_model->currencyrate($curr_code);

        foreach ($reproom->hotel->channel->room as $room){
            if(!empty($room->price) && !empty($current_currency_price)) {
                $price_get = ceil($room->price / $current_currency_price);
            }else{
                $price_get = 0;
            }

            $price = ceil($price_get * $con_rate);

            $percent_price =  $price *  $this->settings->markup / 100;

            array_push($roomarry,(object)[
                'price' => round($price + $percent_price),
                'convarte_price' => $price,
                'percent' => $percent_price,
                'actuall_price' => $room->price,
                'boardTypeid' => $room->boardType->id,
                'boardTypename' => $room->boardType->name,
                'roomTypeid' => $room->roomType->id,
                'roomTypename' => $room->roomType->name,
                'roomid' => $room->id,
                'currencies' => $curr_code,
                'set_currencies' => $this->apiConfig->currency,
            ]);
        }


        array_push($arry,(object)[
            'id' => $rep->hotel->id,
            'company_name' => str_replace('&', '', $rep->hotel->name),
            'description' => $rep->hotel->descriptions->description[0]->_,
            'images' => $rep->hotel->image,
            'city_name' => $rep->hotel->city->name,
            'rating' => $rep->hotel->starRating,
            'price' => 0,
            'rooms' => $reproom->hotel->channel->room,
            'room' => $roomarry,
            'amenities' => $rep->hotel->feature,
            'address' => $rep->hotel->address->_,
            'latitude' => '',
            'longitude' => '',
        ]);

        $this->response(array('response' => $arry, 'error' => array('status' => TRUE,'msg' => '')), 200);
    }

    public function booking_post(){
        $payload = $this->post();

        $userdetail = array(
            'title' => $payload['title'],
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'email' => $payload['email'],
            'country' => $payload['country'],
            'number' => $payload['number'],
            'title0' => $payload['title0'],
            'first_name0' => $payload['first_name0'],
            'last_name0' => $payload['last_name0'],
            'title1' => $payload['title1'],
            'first_name1' => $payload['first_name1'],
            'last_name1' => $payload['last_name1'],
            'first_name_children' => $payload['first_name_children'],
            'last_name_children' => $payload['last_name_children'],
        );

        $data = array(
            "room_id" => $payload['room_id'],
            "roomTypeId" => $payload['roomTypeId'],
            "boardTypeId" => $payload['boardTypeId'],
            "checkIn" => $payload['checkIn'],
            "checkOut" => $payload['checkOut'],
            "set_currencies" => $payload['set_currencies'],
            "currency" => $payload['currency'],
            "user_id" => $payload['user_id'],
            "price" => $payload['price'],
            "agentReferenceNumber" => $payload['agentReferenceNumber'],
            "hotel_id" => $payload['hotel_id'],
            "company_name" => $payload['company_name'],
            "images" => $payload['images'],
            "status" => 'unpaid',
            "booking_response" => json_encode($userdetail),
            "booking_payment_type" => '',
            "booking_txn_id" => '',
            "room" => $payload['room'],
        );

        if( $this->settings->booking_method == 'Book After Payment') {
            $data = array(
                "room_id" => $payload['room_id'],
                "roomTypeId" => $payload['roomTypeId'],
                "boardTypeId" => $payload['boardTypeId'],
                "checkIn" => $payload['checkIn'],
                "checkOut" => $payload['checkOut'],
                "set_currencies" => $payload['set_currencies'],
                "currency" => $payload['currency'],
                "user_id" => $payload['user_id'],
                "price" => $payload['price'],
                "agentReferenceNumber" => $payload['agentReferenceNumber'],
                "hotel_id" => $payload['hotel_id'],
                "company_name" => $payload['company_name'],
                "images" => $payload['images'],
                "status" => 'unpaid',
                "booking_response" => json_encode($userdetail),
                "bookingDetails" => '',
                "booking_payment_type" => '',
                "booking_txn_id" => '',
                "room" => $payload['room'],
            );
            $booking_id = $this->Hotelston_model->booking($data);
            $invoice = base_url("hotelston/invoice/{$booking_id}?n=y");
            $this->response(array('response' => $invoice, 'error' => array('status' => TRUE, 'msg' => '')), 200);
        }else{
        $rep = $this->HotelApiClient->callApibooking($data,$this->apiConfig);
        if(!empty($rep->error)){
            $this->response(array('response' => $rep->error->message, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }else {

            $data = array(
                "room_id" => $payload['room_id'],
                "roomTypeId" => $payload['roomTypeId'],
                "boardTypeId" => $payload['boardTypeId'],
                "checkIn" => $payload['checkIn'],
                "checkOut" => $payload['checkOut'],
                "set_currencies" => $payload['set_currencies'],
                "currency" => $payload['currency'],
                "user_id" => $payload['user_id'],
                "price" => $payload['price'],
                "agentReferenceNumber" => $payload['agentReferenceNumber'],
                "hotel_id" => $payload['hotel_id'],
                "company_name" => $payload['company_name'],
                "images" => $payload['images'],
                "status" => 'paid',
                "booking_response" => json_encode($userdetail),
                "booking_payment_type" => '',
                "booking_txn_id" => '',
                "room" => $payload['room'],
                "bookingDetails" => json_encode($rep->bookingDetails)
            );

            $booking_id = $this->Hotelston_model->booking($data);
            $invoice = base_url("hotelston/invoice/{$booking_id}?n=y");
            $this->response(array('response' => $invoice, 'error' => array('status' => TRUE, 'msg' => '')), 200);
        }
        }
    }


}
