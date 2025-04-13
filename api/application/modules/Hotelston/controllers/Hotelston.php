<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

ini_set('display_errors', 0);

class Hotelston extends MX_Controller
{
    const MODULE = "Hotelston";
    const THEME_MODULE = "modules/hotels/hotelston/";

    public function __construct()
    {
        parent :: __construct();
        modules::load('Front');
        $this->data['phone'] = $this->load->get_var('phone');
		$this->data['contactemail'] = $this->load->get_var('contactemail');
		$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
		$this->data['appModule'] = "hotels";
		$languageid = $this->uri->segment(2);
		$this->validlang = pt_isValid_language($languageid);
		if( $this->validlang ) {
			$this->data['lang_set'] =  $languageid;
		} else {
			$this->data['lang_set'] = $this->session->userdata('set_lang');
		}
		$defaultlang = pt_get_default_language();
		if ( empty($this->data['lang_set']) ) {
			$this->data['lang_set'] = $defaultlang;
		}
		// For menu `HOME` and `My Account` link in header.
		$this->lang->load("front", $this->data['lang_set']);
		$user_id = $this->session->userdata('pt_logged_customer');
        $this->data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;
        $this->data['appModule'] = self::MODULE;

        $this->settings = $this->App->service("ModuleService")->get("hotelston")->settings;
        $this->apiConfig = $this->App->service("ModuleService")->get("hotelston")->apiConfig;
        $this->load->library('Hotelston/HotelApiClient');
		$this->load->model('Hotelston/Hotelston_model');
        $this->load->model('Hotelston/HotelsSearchModel');

    }
    public function search()
    {
        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new HotelsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('Hotelston',serialize($searchForm));

        if(!empty($this->session->userdata("currencycode"))){
            $curr_code = $this->session->userdata("currencycode");
        }else{
            $curr_code = $this->Hotels_lib->currencycode;
        }

        $current_currency_price = $this->Hotelston_model->currencyrate($this->apiConfig->currency);
        $con_rate = $this->Hotelston_model->currencyrate($curr_code);

        $hotel_id = $this->Hotelston_model->gethotel($args[3]);
        $arry = array();
        foreach ($hotel_id as $id){
        $rep = $this->HotelApiClient->callApi($id->hotel_id,$this->apiConfig);
        $reproom = $this->HotelApiClient->getroom($id->hotel_id,$this->apiConfig,$searchForm);
            if(!empty($reproom->hotel->channel->room[0]->price) && !empty($current_currency_price)) {
                $price_get = ceil($reproom->hotel->channel->room[0]->price / $current_currency_price);
            }else{
                $price_get = 0;
            }

            $price = ceil($price_get * $con_rate);

           $percent_price =  $price *  $this->settings->markup / 100;

           if($price_get != 0) {
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

        $this->data['hotels'] = $arry;
        $this->data['pageTitle'] = 'Hotels Results' ;
        $this->data['searchForm'] = $searchForm;
        $this->data['appModule'] = self::MODULE;
        $this->theme->view(self::THEME_MODULE.'listing', $this->data, $this);

    }

    public function detail($slug = '')
    {
        $hotel_id = $this->input->post('hotel_id');
        $search_form = $this->input->post('search_form');
        $searchForm = json_decode($search_form);
        $arry = array();
        $roomarry = array();
        $rep = $this->HotelApiClient->callApi($hotel_id,$this->apiConfig);
        $reproom = $this->HotelApiClient->getroom($hotel_id,$this->apiConfig,json_decode($search_form));

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
            'room' => $roomarry,
            'rooms' => $reproom->hotel->channel->room,
            'amenities' => $rep->hotel->feature,
            'address' => $rep->hotel->address->_,
            'latitude' => '',
            'longitude' => '',
        ]);

        $data['hotel'] = $arry;
        $data['searchForm'] = $searchForm;
        $data['search_form'] = '';

        $this->theme->view(self::THEME_MODULE.'/details', $data, $this);
    }


    public function checkout($slug = '')
    {
        $this->load->model('Admin/Countries_model');
        $data['hotel_encoded'] = $this->input->post('hotel');
        $data['room_encoded'] = $this->input->post('room');
        $data['searchForm_encoded'] = $this->input->post('searchForm');
       $data['hotel'] = json_decode(base64_decode($data['hotel_encoded']));
       $data['room'] = json_decode(base64_decode($data['room_encoded']));
       $data['searchForm'] = json_decode(base64_decode($data['searchForm_encoded']));
        $user_id = $this->session->userdata('pt_logged_customer');
        $data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;
        $data['pageTitle'] = 'Hotels Booking Checkout' ;
        $data['allcountries'] = $this->Countries_model->get_all_countries();
        $this->theme->view(self::THEME_MODULE.'/checkout', $data, $this);
    }


    public function booking(){
        $payload = $this->input->post();
        $hotel = $this->input->post('hotel');
        $room = $this->input->post('room');
        $payload['hotelsdata'] = json_decode(base64_decode($hotel));
        $payload['room'] = json_decode(base64_decode($room));
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
          "set_currencies" => $payload['room']->set_currencies,
          "currency" => $payload['currency'],
          "price" => $payload['price'],
          "agentReferenceNumber" => $payload['agentReferenceNumber'],
          "hotel_id" => $payload['hotelsdata']->id,
          "company_name" => $payload['hotelsdata']->company_name,
          "images" => $payload['hotelsdata']->images[0]->url,
          "status" => 'unpaid',
          "user_id" => $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer'),
          "booking_response" => json_encode($userdetail), "",
          "booking_payment_type" => '',
          "booking_txn_id" => '',
          "room" => json_encode($payload['room']),
        );

        if( $this->settings->booking_method == 'Book After Payment') {
            $data = array(
                "room_id" => $payload['room_id'],
                "roomTypeId" => $payload['roomTypeId'],
                "boardTypeId" => $payload['boardTypeId'],
                "checkIn" => $payload['checkIn'],
                "checkOut" => $payload['checkOut'],
                "set_currencies" => $payload['room']->set_currencies,
                "currency" => $payload['currency'],
                "price" => $payload['price'],
                "agentReferenceNumber" => $payload['agentReferenceNumber'],
                "hotel_id" => $payload['hotelsdata']->id,
                "company_name" => $payload['hotelsdata']->company_name,
                "images" => $payload['hotelsdata']->images[0]->url,
                "status" => 'unpaid',
                "user_id" => $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer'),
                "booking_response" => json_encode($userdetail),
                "bookingDetails" => '',
                "booking_payment_type" => '',
                "booking_txn_id" => '',
                "room" => json_encode($payload['room']),
            );
            $booking_id = $this->Hotelston_model->booking($data);
            $rep = '';
            $rep->{'status'} = 'success';
            $rep->{'invoice_url'} = base_url("hotelst/invoice/{$booking_id}?n=y");
        }else{
            $rep = $this->HotelApiClient->callApibooking($data,$this->apiConfig);
            if(!empty($rep->error)){
                $rep->{'status'} = 'fail';
                $rep->{'message'} = $rep->error->message;
            }else{
                $data = array(
                    "room_id" => $payload['room_id'],
                    "roomTypeId" => $payload['roomTypeId'],
                    "boardTypeId" => $payload['boardTypeId'],
                    "checkIn" => $payload['checkIn'],
                    "checkOut" => $payload['checkOut'],
                    "set_currencies" => $payload['room']->set_currencies,
                    "currency" => $payload['currency'],
                    "price" => $payload['price'],
                    "agentReferenceNumber" => $payload['agentReferenceNumber'],
                    "hotel_id" => $payload['hotelsdata']->id,
                    "company_name" => $payload['hotelsdata']->company_name,
                    "images" => $payload['hotelsdata']->images[0]->url,
                    "status" => 'paid',
                    "user_id" => $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer'),
                    "booking_response" => json_encode($userdetail),
                    "bookingDetails" => json_encode($rep->bookingDetails),
                    "booking_payment_type" => '',
                    "booking_txn_id" => '',
                    "room" => json_encode($payload['room']),
                );
                $booking_id = $this->Hotelston_model->booking($data);
                $rep->{'status'} = 'success';
                $rep->{'invoice_url'} = base_url("hotelst/invoice/{$booking_id}?n=y");
            }

        }
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($rep));
    }

    public function getGatewaylink($bookingid) {
        if ($this->input->is_ajax_request()) {
            if (!empty($_POST)) {
                $invoicdata = $this->parseInvoiceData($bookingid);
                $this->load->model('Admin/Payments_model');
                $gateway = $this->input->post('gateway');
                echo $this->Payments_model->hotelstongetGatewayMsg($gateway, $invoicdata);
            }
        }
    }


    private function parseInvoiceData($booking)
    {
        $bookingRequest = $this->Hotelston_model->getBooking($booking);
        $invoice = new stdClass();
        $invoice->id = $bookingRequest[0]->id;
        $invoice->booking_code = '';
        $invoice->additionaNotes = "";
        $invoice->currency_code = $bookingRequest[0]->currency;
        $invoice->total_amount = $bookingRequest[0]->price;
        $invoice->total_nights = "";
        $invoice->checkin = $bookingRequest[0]->checkIn;
        $invoice->checkout = $bookingRequest[0]->checkOut;
        $invoice->room_name = $bookingRequest[0]->hotel_data->room_name;
        $invoice->hotel_image = $bookingRequest[0]->images;
        $invoice->hotel_location = $bookingRequest->hotel_data->address;
        $invoice->hotel_name = $bookingRequest[0]->company_name;
        $data = json_decode($bookingRequest[0]->bookingDetails);
        $invoice->booking_number = $data->bookingReference;
        $invoice->agentReferenceNumber = $bookingRequest[0]->agentReferenceNumber;
        $invoice->status = 'unpaid';
        $invoice->guest = '';
        $invoice->created_at = '';

        return $invoice;
    }

}

