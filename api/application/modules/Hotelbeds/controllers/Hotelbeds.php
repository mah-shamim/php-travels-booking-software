<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 *  Module Controller
 */
class Hotelbeds extends MX_Controller
{
    public $cache_mode = true;
    public $sandbox_mode = false;
    public $imagePath = 'https://photos.hotelbeds.com/giata/';

    public function __construct()
    {
        parent::__construct();

        modules::load('Front');
        $this->load->library('ServiceController');
        $chk = $this->App->service('ModuleService')->isActive('hotelbeds');
        if (!$chk) { Error_404($this); }
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }
        $this->lang->load("front", $this->data['lang_set']);
        // Leftpanel filters
        $this->dbhb = getDatabaseConnection('hotelbeds');
        $this->data['facilities'] = $this->dbhb->select('*')->group_by('code')->get('facilities')->result();
        $this->data['accommodations'] = $this->dbhb->get('accommodations')->result();
        $this->data['concepts'] = $this->dbhb->where_in('content', ['Bed and breakfast','Half Board','Full board','All inclusive'])->get('boards')->result();
        $this->settings = $this->App->service("ModuleService")->get("hotelbeds")->settings;
        // $this->data['hideLang'] = "hide";
        $this->data['hideCurr'] = "hide";
        $this->data['vfHotelbedsMarkup'] = 'vfHotelbedsMarkup'; // helper variable function
        $this->data['markupPercentage'] = $this->settings->markup;

        $ci = get_instance();
        $version = implode("=>",(array)$ci->db->query('SELECT VERSION()')->result()[0]);
        if($version > 5.6)
        {
            $ci->db->query('SET SESSION sql_mode = ""');
            $ci->db->query('SET SESSION sql_mode =
                      REPLACE(REPLACE(REPLACE(
                      @@sql_mode,
                      "ONLY_FULL_GROUP_BY,", ""),
                      ",ONLY_FULL_GROUP_BY", ""),
                      "ONLY_FULL_GROUP_BY", "")');
        }
    }

    public function index(...$args)
    {
        $this->data['pagination'] = false;
        $minRate = $this->settings->minPrice;
        $maxRate = $this->settings->maxPrice;
        $availabilityReq = new AvailabilityReq();
        $availabilityReq->language = 'ENG';
        if(in_array('filter', $args))
        {
            list($filter, $stars,$price,$facilities,$accommodation) = $args;
            list($minRate, $maxRate) = explode(',', $price);
            $filter = new StdClass();
            $review = new StdClass();
            $keyword = new StdClass();
            $filter->minRate = $minRate;
            $filter->maxRate = $maxRate;
            $filter->minCategory = $stars;
            $availabilityReq->filter = $filter;
            $keyword->keyword = explode('-', $facilities);
            $availabilityReq->keywords = $keyword;
            $availabilityReq->accommodations = explode('-', $accommodation);
            $this->data['input']['fFacilities'] = $availabilityReq->keywords->keyword;
            $this->data['input']['fAccommodations'] = $availabilityReq->accommodations;
        }
        $stay = new StdClass();
        $stay->checkIn = date('Y-m-d');
        $stay->checkOut = date('Y-m-d', strtotime('+5 days'));
        $occupancies = new StdClass();
        $occupancies->rooms = 1;
        $occupancies->adults = 2;
        $occupancies->children = 0;
        $availabilityReq->stay = $stay;
        $availabilityReq->occupancies = [$occupancies];
        $destination = $this->settings->destination;
        $query = "
            SELECT 
                code
            FROM hotels 
            WHERE city LIKE '%{$destination}%' 
            OR name LIKE '%{$destination}%' 
            OR destinationCode LIKE '%{$destination}%' 
        ";
        $hotels = $this->dbhb->query($query)->result_array();
        $hotels = array_column($hotels, 'code');
        $availabilityReq->hotels = [
            'hotel' => $hotels
        ];
        // $availabilityReq->destination = ['code' => 'AAN'];
        $this->data['uri'] = 'hotelb';
        // $this->data['uri'] = 'hotelb/search/'.$country.'/'.$city.'/'.$checkIn.'/'.$checkOut.'/'.$adults.'/'.$childs;
        $this->data['detailpage_uri'] = 'hotelb/detail/%s/'.$stay->checkIn.'/'.$stay->checkOut.'/'.$occupancies->adults.'/'.$occupancies->children;
        $_SESSION['detailpage_uri'] = $this->data['detailpage_uri'];
        $this->data['base64_detailpage_uri'] = urlencode(base64_encode($this->data['detailpage_uri']));
        try {
            $apitude = new ServiceController();
            $apitude->sandbox_mode = $this->sandbox_mode;
            $availabilityResp = $apitude->service($availabilityReq, 'hotels');
            $this->data['hotels'] = $availabilityResp->get_hotels();
            $this->data['input'] = array(
                "checkin" => $stay->checkIn,
                "checkout" => $stay->checkOut,
                "adult" => $occupancies->adults,
                "children" => $occupancies->children,
                "destination" => 'FUE',
                "stars" => $stars,
                "price" => $minRate.'-'.$maxRate
            );
            $this->data['pageTitle'] = ucwords($destination);
            $this->data['input'] = (object) $this->data['input'];
            $this->session->set_userdata('checkIn', $stay->checkIn);
            $this->session->set_userdata('checkOut', $stay->checkOut);
            $this->theme->view('modules/hotels/hotelbeds/listing', $this->data, $this);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function pagination($page = 1, $base64_detailpage_uri)
    {
        try {
            $this->data['detailpage_uri'] = base64_decode(urldecode($base64_detailpage_uri));
            $this->data['pagination'] = true;
            $apitude = new ServiceController();
            $response = $apitude->pagination($page);
            if(isset($response) && ! empty($response)) {
                $availabilityResp = new AvailabilityResp($response);
                $this->data['hotels'] = $availabilityResp->get_hotels();
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode([
                    'status' => 'success',
                    'listHtml' => $this->theme->partial('modules/hotels/hotelbeds/listing', $this->data, $this)
                ]));
            } else {
                $this->output->set_output(json_encode([
                    'status' => 'fail'
                ]));
            }
        } catch (Exception $e) {
            $this->output->set_output(json_encode([
                'status' => 'fail',
                'message' => $e->getMessage()
            ]));
        }
    }

    public function search(...$args)
    {


        $this->data['pagination'] = false;
        $minRate = $this->settings->minPrice;
        $maxRate = $this->settings->maxPrice;
        $_SESSION['searchListingPage'] = base_url(uri_string());
        $availabilityReq = new AvailabilityReq();
        $availabilityReq->language = 'ENG';
        if(in_array('filter', $args))
        {
            list($country,$city,$checkIn,$checkOut,$adults,$childs,$childAges,$filter,$stars,$price,$facilities,$accommodation) = $args;
            list($minRate, $maxRate) = explode(',', $price);
            $filter = new StdClass();
            $boards = new StdClass();
            $filter->minRate = $minRate;
            $filter->maxRate = $maxRate;
            if (! empty($stars)) {
                $filter->minCategory = $stars;
            }
            $availabilityReq->filter = $filter;
            $_boards = explode('-', $facilities);
            $boards->board = array();
            foreach ($_boards as $i => $key) {
//                array_push($boards->board, $key);
            }
            $boards->included = true;
            $availabilityReq->boards = $boards;
            $availabilityReq->accommodations = array_filter(explode('-', $accommodation));
            $this->data['input'] = array(
                "stars" => $stars,
                "price" => $minRate.'-'.$maxRate,
                "fFacilities" => $_boards,
                "fAccommodations" => $availabilityReq->accommodations
            );
        }
        else
        {
            list($country,$city,$checkIn,$checkOut,$adults,$childs,$childAges) = $args;
        }
        $this->data['input']['price'] = $minRate.'-'.$maxRate;
        $this->data['input'] = (object) $this->data['input'];
        $checkin = explode('-', $checkIn);
        $checkout = explode('-', $checkOut);
        $stay = new StdClass();
        $stay->checkIn =  sprintf('%s-%s-%s', $checkin[2],$checkin[1],$checkin[0]);
        $stay->checkOut =  sprintf('%s-%s-%s', $checkout[2],$checkout[1],$checkout[0]);
        $occupancies = new StdClass();
        $occupancies->rooms = 1;
        $occupancies->adults = $adults;
        $occupancies->children = $childs;
        if($occupancies->children > 0) {
            $ages = explode('-', $childAges);
            $occupancies->paxes = [];
            for($i = 0; $i < $occupancies->children; $i++) {
                array_push($occupancies->paxes, array(
                    'type' => "CH",
                    'age' => $ages[$i]
                ));
            }
        }
        $availabilityReq->stay = $stay;
        $availabilityReq->occupancies = [$occupancies];
        // Destination either contain `location e.g city` or `hotel slug`.
        $destination = $country; // str_replace('-', '%', $city);
        $query = "
            SELECT code
            FROM hotels 
            WHERE slug = '{$destination}' OR city_slug = '{$destination}'
        ";
        $hotels = $this->dbhb->query($query)->result_array();
        $hotels = array_column($hotels, 'code');
        $availabilityReq->hotels = [
            'hotel' => $hotels
        ];
        $_SESSION['checkIn'] = $checkIn;
        $_SESSION['checkOut'] = $checkOut;
        $this->session->set_userdata('hb_checkin', str_replace('-', '/', $checkIn));
        $this->session->set_userdata('hb_checkout', str_replace('-', '/', $checkOut));
        $this->session->set_userdata('hb_s2_id', strtolower(str_replace(' ', '-', $country.'/'.$city)));
        $this->session->set_userdata('hb_s2_text', ucwords(str_replace('-', ' ', $country.' ( '.$city.' )')));
        $this->session->set_userdata('hb_adults', $occupancies->adults);
        $this->session->set_userdata('hb_children', $occupancies->children);
        // Destination base search is not available by default.
        // $availabilityReq->destination = ['code' => $this->input->get('destination')];
        if (empty($childAges)) {
            $childAges = '2';
        }
        $this->data['uri'] = 'hotelb/search/'.$country.'/'.$city.'/'.$checkIn.'/'.$checkOut.'/'.$adults.'/'.$childs.'/'.$childAges;
        $this->data['detailpage_uri'] = 'hotelb/detail/%s/'.$checkIn.'/'.$checkOut.'/'.$adults.'/'.$childs.'/'.$childAges;
        $this->data['base64_detailpage_uri'] = urlencode(base64_encode($this->data['detailpage_uri']));
        $this->data['pageTitle'] = ucwords($city);
        $this->data['appModule'] = "Hotelbeds";
        $this->load->model('Hotelbeds/HotelsSearchModel');

        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new HotelsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('Hotelbeds',serialize($searchForm));
        $this->data['searchFormhotels'] = $searchForm;

        try {
            $apitude = new ServiceController();
            $apitude->sandbox_mode = $this->sandbox_mode;
            $apitude->cache_falg = $this->cache_mode;
            $availabilityResp = $apitude->service($availabilityReq, 'hotels');
            if($availabilityResp instanceof AvailabilityResp) {
                $this->data['hotels'] = $availabilityResp->get_hotels();
            } else {
                $this->data['hotels'] = [];
            }
            $this->theme->view('modules/hotels/hotelbeds/listing', $this->data, $this);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getHotelBySlug($slug)
    {
        $query = "SELECT * FROM hotels WHERE slug = '{$slug}' OR city_slug = '{$slug}'";
        return $this->dbhb->query($query)->row();
    }

    public function detail(...$args)
    {
        $uri_string = uri_string();
        // if string contain 'recheck' then ok otherwise append it.
        if (strpos($uri_string, 'recheck') == false) {
            $uri_string = str_replace('detail', 'detail/recheck', $uri_string);
        }
        $_SESSION['detailPageUrl'] = base_url($uri_string);
        if($args[0] == 'recheck') {
            list($recheck,$slug,$checkIn,$checkOut,$adults,$childs,$childAges) = $args;
        } else {
            list($slug,$checkIn,$checkOut,$adults,$childs,$childAges) = $args;
        }
        $this->data['loadMap'] = true;
        $this->data['hotel'] = $this->getHotelBySlug($slug);
        if($args[0] == 'recheck')
        {
            $checkin = explode('-', $checkIn);
            $checkout = explode('-', $checkOut);
            $stay = new StdClass();
            $stay->checkIn =  sprintf('%s-%s-%s', $checkin[2],$checkin[1],$checkin[0]);
            $stay->checkOut =  sprintf('%s-%s-%s', $checkout[2],$checkout[1],$checkout[0]);
            $occupancies = new StdClass();
            $occupancies->rooms = 1;
            $occupancies->adults = $adults;
            $occupancies->children = $childs;
            if($occupancies->children > 0) {
                $ages = explode('-', $childAges);
                $occupancies->paxes = [];
                for($i = 0; $i < $occupancies->children; $i++) {
                    array_push($occupancies->paxes, array(
                        'type' => "CH",
                        'age' => (isset($ages[$i]) && !empty($ages[$i])) ? $ages[$i] : 5,
                    ));
                }
            }
            $availabilityReq = new AvailabilityReq();
            $availabilityReq->language = 'ENG';
            $availabilityReq->stay = $stay;
            $availabilityReq->occupancies = [$occupancies];
            $availabilityReq->hotels = ['hotel' => [$this->data['hotel']->code]];
            $apitude = new ServiceController();
            $apitude->sandbox_mode = $this->sandbox_mode;
            $this->session->set_userdata('checkIn', $stay->checkIn);
            $this->session->set_userdata('checkOut', $stay->checkOut);
            try {
                // the service will save the recheck response into cache.
                $apitude->service($availabilityReq, 'hotels');
            } catch (Exception $e) {
                $this->data['errorMessage'] = $e->getMessage();
            }
        }
        $this->data['featuredHotelsUrl'] = base_url("hotelb/detail/%s/{$checkIn}/{$checkOut}/{$adults}/{$childs}/{$childAges}");
        $this->data['input'] = (object) array(
            "checkin" => $checkIn,
            "checkout" => $checkOut,
            "adult" => $adults,
            "children" => $childs,
            "destination" => 'FUE',
            "totalStay" => pt_count_days($checkIn, $checkOut)
        );
        $_SESSION['checkIn'] = $checkIn;
        $_SESSION['checkOut'] = $checkOut;
        $this->data['pageTitle'] = $this->data['hotel']->name;
        $this->data['featuredHotels'] = $this->getFeaturedHotels($this->data['hotel']->destinationCode);
        // read response from the cache.
        $this->data['sessionHotel'] = $this->getHotelFromSession($this->data['hotel']->code);
        $this->data['detailPageUrl'] = base_url($uri_string);
        $this->theme->view('modules/hotels/hotelbeds/details', $this->data, $this);
    }

    /**
     * Featured hotels.
     *
     * @throws HotelException
     */
    public function getFeaturedHotels($destinationCode)
    {
        $this->dbhb->where('destinationCode', $destinationCode);
        $this->dbhb->limit(8);
        $response = $this->dbhb->get('hotels')->result();
        return $response;
    }

    /**
     * Recheck rate for specific rate key.
     * Dummy method.
     *
     * @throws HotelException
     */
    public function checkrate()
    {
        try {
            $rateKey = $this->input->post('rateKey');
            $apitude = new ServiceController();
            $checkrateResp = $apitude->service(array(
                "language" => "ENG",
                "upselling" => "True",
                "rooms" => array(
                    array(
                        "rateKey" => $rateKey
                    )
                )
            ), 'checkrates');

            $response["status"] = "fail";
            $response["data"] = $checkrateResp;
            if (isset($checkrateResp) && ! empty($checkrateResp)) {
                $checkrateResp = (array) $checkrateResp;
                $checkrateResp['resp']['hotels']['hotels'] = array($checkrateResp['hotel']);
                $_SESSION['hotelbedsSearchResult'] = json_encode((object) $checkrateResp);
                $response["status"] = "success";
                $response["data"] = $checkrateResp['hotel']->rooms[0]->rates[0];
            }

            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($response));
        } catch (Exception $e) {
            echo $e->getError();
        }
    }

    /**
     * Checkout form where we take user data and show credit card form
     * if user select AT_HOTEL option at previous page otherwise will
     * show a button on click an API request fired and invoice generated.
     */
    public function checkout($cache = 0)
    {
        $_SESSION['checkOutPostArray'] =  $_POST;
        if($cache == 1) {
            $_POST = $_SESSION['checkOutPostArray'];
        } else if(empty($_POST)) {
            return redirect($_SESSION['searchListingPage']);
        }
        $rateKey = $this->input->post('rateKey');
        $hotelname = $this->input->post('hotelname');
        $hotelslug = $this->input->post('hotelslug');
        $this->dbhb->where('slug', $hotelslug);
        $hotel = $this->dbhb->get('hotels')->row();
        $this->data['pageTitle'] = $hotel->name;
        $this->data['hotel_address'] = $hotel->address;
        $this->data['country_name'] = $hotel->countryName;
        $this->data['sessionHotel'] = $this->getRoom($hotel->code, $rateKey);
        $this->data['sessionHotel']->image = $this->imagePath.json_decode($hotel->images)[0]->path;
        $checkIn = $this->input->post('checkIn');
        $checkOut = $this->input->post('checkOut');
        $this->data['sessionHotel']->checkIn = $checkIn;
        $this->data['sessionHotel']->checkOut = $checkOut;
        $this->data['sessionHotel']->totalNights = pt_count_days($checkIn, $checkOut);
        $this->data['sessionHotel']->totalRooms = 1;
        $this->data['sessionHotel']->totalAdults = $this->input->post('adults');
        $this->data['sessionHotel']->totalChildrens = $this->input->post('childrens');
        $this->data['sessionHotel']->totalPax = $this->data['sessionHotel']->totalAdults + $this->data['sessionHotel']->totalChildrens;
        $this->data['detailPageUrl'] = $this->input->post("detailPageUrl");
        $this->theme->view('modules/hotels/hotelbeds/checkout', $this->data, $this);
    }

    /**
     * Invoice page, api return invoice data in response of booking,
     * so in this page we will show invoice and save in local db for the record.
     */
    public function invoice($invoice_id = 0, $session_id = 0)
    {
        $this->lang->load("front", $this->data['lang_set']);
        $contact = $this->Settings_model->get_contact_page_details();
        $this->data['contactphone'] = $contact[0]->contact_phone;
        $this->data['contactemail'] = $contact[0]->contact_email;
        $this->data['contactaddress'] = $contact[0]->contact_address;
        $this->data['page_title'] = 'Invoice';
        $this->data['header_title'] = 'Invoice';

        $this->load->model('Hotelbeds/Booking');
        $booking = new Booking();
        $this->data['invoice'] = $booking->load($invoice_id);
        $this->theme->view('modules/hotels/hotelbeds/invoice', $this->data, $this);
    }

    public function booking()
    {
        try {
            $payload = $this->input->post();
            $_SESSION['postOldData'] = $payload;
            $bookingReq = new BookingReq();
            $bookingReq->holder->name = $payload['first_name'];
            $bookingReq->holder->surname = $payload['last_name'];
            $bookingReq->clientReference = "IntegrationAgency";
            $bookingReq->remark = "Booking remarks are to be written here.";
            $room = new Room();
            $room->rateKey = $payload['rateKey'];
            for ($i = 0; $i < count($payload['name']); $i++)
            {
                $pax = new Pax();
                $pax->roomId = 1;
                $pax->type = $payload['type'][$i];
                $pax->name = $payload['name'][$i];
                $pax->surname = $payload['surname'][$i];
                array_push($room->paxes, $pax);
            }
            array_push($bookingReq->rooms, $room);
            $paymentType = $payload['paymentType'];
            if($paymentType == 'AT_HOTEL') {
                // Add credit card detail in request.
                $paymentData = new PaymentData();
                $paymentData->paymentCard->cardHolderName = $payload['cardHolderName'];
                $paymentData->paymentCard->cardType = $payload['cardType'];
                $paymentData->paymentCard->cardNumber = $payload['cardNumber'];
                $paymentData->paymentCard->expiryDate = $payload['expiryDates'];
                $paymentData->paymentCard->cardCVC = $payload['cardCVC'];
                $paymentData->contactData->email = $payload['email'];
                $paymentData->contactData->phoneNumber = $payload['phoneNumber'];
                $bookingReq->paymentData = $paymentData;
            }

            $apitude = new ServiceController();
            $apitude->sandbox_mode = $this->sandbox_mode;
            $bookingResp = $apitude->service($bookingReq, $paymentType);

            $this->dbhb->where('code', $bookingResp->booking->hotel->code);
            $hotel = $this->dbhb->get('hotels')->row();

            // Save booking
            $this->load->model('Hotelbeds/Booking');
            $this->Booking->hotel_name = $bookingResp->booking->hotel->name;
            $this->Booking->booking_reference = $bookingResp->booking->reference;
            $this->Booking->hotel_stars = $payload['hotelStars'];
            $this->Booking->hotel_location = $hotel->address;
            $this->Booking->hotel_image = $payload['hotelImage'];
            $this->Booking->room_name = current($bookingResp->booking->hotel->rooms)->name;
            $this->Booking->checkin = $bookingResp->booking->hotel->checkIn;
            $this->Booking->checkout = $bookingResp->booking->hotel->checkOut;
            $this->Booking->total_nights = $payload['totalNights'];
            $this->Booking->total_amount = $bookingResp->booking->totalNet;
            $this->Booking->markup = $this->settings->markup; // OTA percentage.
            $this->Booking->currency_code = $bookingResp->booking->currency;
            $this->Booking->booking_holder = json_encode([
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
                'email' => $payload['email'],
                'address' => $payload['address'],
                'mobile_code' => $payload['mobile_code'],
                'phone_number' => $payload['phone_number'],
            ]);
            $this->Booking->response_object = json_encode($bookingResp);
            $this->Booking->created_at = $bookingResp->booking->creationDate;
            $this->Booking->save();
            $booking_query=$this->db->last_query();
            // Register booking holder as a guest user in database.
            $this->db->insert('pt_accounts', [
                'ai_first_name' => $payload['first_name'],
                'ai_last_name' => $payload['last_name'],
                'accounts_email' => $payload['email'],
                'accounts_password' => 'guest',
                'ai_address_1' => $payload['address'],
                'ai_mobile' => $payload['mobile_code'].$payload['phone_number'],
                'accounts_type' => 'guest',
                'accounts_is_admin' => 0,
                'accounts_verified' => 1,
                'accounts_status' => 'yes'
            ]);
            $account_query=$this->db->last_query();
            // Send Notification
            $session_id = rand(0, 1000);
            $_SESSION['order_placed'] = TRUE;
            $_SESSION['notifiable_emails'] = $payload['email'];
            $_SESSION['invoice_url'] = base_url("hotelb/invoice/" . $this->Booking->id."/".$session_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode([
                'status' => 'success',
                'message' => 'Congratulations! Your booking has confirm successfully',
                'invoice_url' => base_url("hotelb/invoice/" . $this->Booking->id."/".$session_id)
            ]));
        } catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'invoice_url' => $this->input->post("detailPageUrl")
            ]));
        }
    }

    public function getRoom($hotel_code, $rateKey)
    {
        $hotelbeds = json_decode($_SESSION['hotelbedsSearchResult']);
        if(isset($hotelbeds) && ! empty($hotelbeds) && ! empty($hotelbeds->resp->hotels->hotels)) {
            foreach($hotelbeds->resp->hotels->hotels as &$hotel) {
                if($hotel->code == $hotel_code) {
                    foreach ($hotel->rooms as $room){
                        foreach ($room->rates as $rate) {
                            if($rate->rateKey == $rateKey) {
                                unset($hotel->rooms);
                                unset($room->rates);
                                $room->rate = $rate;
                                $hotel->room = $room;
                                return $hotel;
                            }
                        }
                    }
                }
            }
        }
    }

    public function getHotelFromSession($hotel_code)
    {
        $response = array();
        $hotelbeds = json_decode($_SESSION['hotelbedsSearchResult']);
        if(isset($hotelbeds) && ! empty($hotelbeds) && ! empty($hotelbeds->resp->hotels->hotels)) {
            foreach($hotelbeds->resp->hotels->hotels as $hotel) {
                if($hotel->code == $hotel_code) {
                    $response['rooms'] = $hotel->rooms;
                    $response['creditCards'] = $hotel->creditCards;
                    $response['hotel'] = $hotel;
                    break;
                }
            }
        }
        $response['checkIn'] = $hotelbeds->resp->hotels->checkIn;
        $response['checkOut'] = $hotelbeds->resp->hotels->checkOut;
        $response['total'] = $hotelbeds->resp->hotels->total;
        return $response;
    }

    /**
     * Save invoice and send to user and admin as notification
     *
     * @method Forntend
     * @return json
     */
    public function save_invoice()
    {
        $this->load->helper('html');
        $invoice_name = $this->input->post('invoice_name');
        $receivers = $this->input->post('receivers');
        $base64ImageString = $this->input->post('base64ImageString');
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64ImageString));
        $invoice_path = './uploads/images/hotelbeds/' . $invoice_name;
        $save_ack = file_put_contents($invoice_path, $data); // Save invoice
        if ( ! empty($save_ack) )
        {
            $_SESSION['order_placed'] = NULL;
            $this->load->library('email');
            $this->email->from($this->email->mail_fromemail, $this->email->site_title);
            $this->email->to($receivers);
            $this->email->subject('Flight Reservation Invoice');
            $message  = $this->email->mail_header;
            $message .= img('uploads/images/hotelbeds/' . $invoice_name);
            $message .= $this->email->mail_footer;
            $this->email->message($message);
            $this->email->attach($invoice_path);
            $email_ack = $this->email->send();
            // echo $this->email->print_debugger();
            $response = array(
                'status' => 'success',
                'email_ack' => $email_ack,
                'receivers' => $receivers
            );
        }
        else
        {
            $response = array(
                'status' => 'fail',
            );
        }
        $this->output->set_output(json_encode($response));
    }
}
