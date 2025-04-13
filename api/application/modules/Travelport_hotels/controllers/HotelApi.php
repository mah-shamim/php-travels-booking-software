<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

ini_set('display_errors', 0);

class HotelApi extends MX_Controller
{
    public $cacheResponse;

    public function __construct()
    {
        parent :: __construct();
        
		// $chk = modules::run('Home/is_main_module_enabled', 'travelport_hotel');
		// if ( ! $chk ) { Module_404(); }
        // For contact detail display in header.
        modules::load('Front');
        $this->data['phone'] = $this->load->get_var('phone');
		$this->data['contactemail'] = $this->load->get_var('contactemail');
		$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
		$this->data['appModule'] = "travelport_hotel";
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
		$this->data['pageTitle'] = "Hotels List";

		$this->load->library('HotelApiClient');
        $this->data['facilities'] = $this->HotelApiClient->getAmenities();
        $this->cacheResponse = FALSE;
        $_SESSION['destination'] = "DXB";
        $_SESSION['provider'] = '1G'; // TRM/1G (Provider TRM is not authorized)
        $_SESSION['rooms'] = 1;
        $_SESSION['adults'] = 2;
        $_SESSION['checkinDate'] = date('Y-m-d');
        $_SESSION['checkoutDate'] = date('Y-m-d', strtotime('+1 days'));
    }

    public function index()
    {
        $adults = $this->input->get('adults',true);
        $checkin = $this->input->get('checkin', true);
        $checkout = $this->input->get('checkout', true);
        $_SESSION['destination'] = $this->input->get('destination', true)?$this->input->get('destination',true):$_SESSION['destination'];
        $_SESSION['rooms'] = 1; // $this->input->get('rooms', true)?$this->input->get('rooms',true):$_SESSION['rooms'];
        $_SESSION['adults'] = $adults?$adults:$_SESSION['adults'];
        $_SESSION['checkinDate'] = $checkin?$checkin:$_SESSION['checkinDate'];
        $_SESSION['checkoutDate'] = $checkout?$checkout:$_SESSION['checkoutDate'];
        try {
            $request = new HotelSearch();
            $request->setHotelSearchLocation($_SESSION['destination']);
            /**
             * For testing select PostPay as a HotelPaymentType.
             * https://support.travelport.com/webhelp/uapi/uAPI.htm#Hotel/Hotel_TRM/TRM%20Testing.htm#BestPractices%3FTocPath%3DHotel%7CTravelport%2520Rooms%2520and%2520More%2520via%2520Universal%2520API%7CTesting%7C_____2
             * setHotelSearchModifiers(rooms, adults, provider, HotelPaymentType)
             */
			$request->setHotelSearchModifiers($_SESSION['rooms'], $_SESSION['adults'], $_SESSION['provider']);
            $request->setHotelStay($_SESSION['checkinDate'], $_SESSION['checkoutDate']);
            dd($request);
            $this->data['hotels'] = $this->HotelApiClient->callApi($request, $this->cacheResponse);
            $this->data['adults'] = $_SESSION['adults'];
            $this->data['checkinDate'] = $_SESSION['checkinDate'];
            $this->data['checkoutDate'] = $_SESSION['checkoutDate'];
            $this->data['searchText'] = $_SESSION['destination'];
            $this->data['totalrows'] = 0;
            if(isset($this->data['hotels']->HotelSearchResult)) {
                $this->data['totalrows'] = count($this->data['hotels']->HotelSearchResult);
            }
            $this->theme->view('modules/travelport/hotel/index', $this->data, $this);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function search()
    {
        $adults = $this->input->get('adults',true);
        $checkin = $this->input->get('checkin', true);
        $checkout = $this->input->get('checkout', true);
        $_SESSION['destination'] = $this->input->get('destination', true)?$this->input->get('destination',true):$_SESSION['destination'];
        $_SESSION['rooms'] = 1; // $this->input->get('rooms', true)?$this->input->get('rooms',true):$_SESSION['rooms'];
        $_SESSION['adults'] = $adults?$adults:$_SESSION['adults'];
        $_SESSION['checkinDate'] = $checkin?$checkin:$_SESSION['checkinDate'];
        $_SESSION['checkoutDate'] = $checkout?$checkout:$_SESSION['checkoutDate'];
        try {
            $request = new HotelSearch();
            $request->setHotelSearchLocation($_SESSION['destination']);
            /**
             * For testing select PostPay as a HotelPaymentType.
             * https://support.travelport.com/webhelp/uapi/uAPI.htm#Hotel/Hotel_TRM/TRM%20Testing.htm#BestPractices%3FTocPath%3DHotel%7CTravelport%2520Rooms%2520and%2520More%2520via%2520Universal%2520API%7CTesting%7C_____2
             * setHotelSearchModifiers(rooms, adults, provider, HotelPaymentType)
             */
            $request->setHotelSearchModifiers($_SESSION['rooms'], $_SESSION['adults'], $_SESSION['provider']);
            foreach($_GET['facilities'] as $type => $codes) {
                foreach($codes as $code) {
                    $request->setHotelSearchModifiersAmenities($type, $code);
                }
            }
            $request->setHotelStay($_SESSION['checkinDate'], $_SESSION['checkoutDate']);
            $this->data['hotels'] = $this->HotelApiClient->callApi($request, $this->cacheResponse);
            $this->data['adults'] = $_SESSION['adults'];
            $this->data['checkinDate'] = $_SESSION['checkinDate'];
            $this->data['checkoutDate'] = $_SESSION['checkoutDate'];
            $this->data['searchText'] = $_SESSION['destination'];
            $this->data['totalrows'] = 0;
            if(isset($this->data['hotels']->HotelSearchResult)) {
                $this->data['totalrows'] = count($this->data['hotels']->HotelSearchResult);
            }
            $this->theme->view('modules/travelport/hotel/index', $this->data, $this);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
	}
    
    /**
     * Address (Both)
     * Phone (Both) 
     * Name (Both)
     * HotelRating (TRM)
     * Gallery (TRM, 1G(In seperate call))
     * Mape (TRM)
     * Description (TRM)
     */
	public function detail()
    {
        try {
            $_SESSION['hotelCode'] = $this->input->post('hotelCode',true);
            $_SESSION['hotelChain'] = $this->input->post('hotelChain',true);
            $_SESSION['RateSupplier'] = $this->input->post('RateSupplier',true);
            $_SESSION['HostToken'] = $this->input->post('HostToken',true);
            $_SESSION['checkinDate'] = $this->input->post('checkinDate',true);
            $_SESSION['checkoutDate'] = $this->input->post('checkoutDate',true);
            $_SESSION['adults'] = $this->input->post('adults',true);
            $request = new HotelDetails();
            $request->setHotelProperty($_SESSION['hotelChain'], $_SESSION['hotelCode']);
            $request->setHotelDetailsModifiers($_SESSION['rooms'], $_SESSION['adults'], $_SESSION['checkinDate'], $_SESSION['checkoutDate'], $_SESSION['provider']);
            // $request->setPermittedAggregators($_SESSION['RateSupplier']);
            $request->setBookingGuestInformation($_SESSION['rooms'], $_SESSION['adults']);
            // $request->setHostToken($_SESSION['HostToken']);
            $this->data['hotelDetail'] = $this->HotelApiClient->callApi($request, $this->cacheResponse);
            $hotelSearchRsp = $this->HotelApiClient->readFromCache('HotelSearch');
            $hotelSearchObj = array_filter($hotelSearchRsp->HotelSearchResult, function($hotel) {
                $hotelCode = ($_SESSION['hotelCode'])?$_SESSION['hotelCode']:$this->data['hotelDetail']->AggregatorHotelDetails->HotelProperty->HotelCode;
                return ($hotel->HotelProperty->HotelCode == $hotelCode);
            });
            $this->data['hotelSearch'] = current($hotelSearchObj);
            $this->data['adults'] = $_SESSION['adults'];
            $this->data['checkinDate'] = $_SESSION['checkinDate'];
            $this->data['checkoutDate'] = $_SESSION['checkoutDate'];
            $this->session->set_userdata('sessionHotel', $this->data['hotelSearch']);
            $this->session->set_userdata('hotelDetail', $this->data['hotelDetail']);
            $this->data['gallery'] = $this->mediaLinks($_SESSION['hotelChain'], $_SESSION['hotelCode']);
            $this->theme->view('modules/travelport/hotel/detail'.'_'.$_SESSION['provider'], $this->data, $this);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function rateAndRule()
    {
        try {
            $_SESSION['checkinDate'] = ($this->input->get('checkin', true))?$this->input->get('checkin',true):$_SESSION['checkinDate'];
            $_SESSION['checkoutDate'] = ($this->input->get('checkout', true))?$this->input->get('checkout',true):$_SESSION['checkoutDate'];
            $_SESSION['adults'] = ($this->input->get('adults', true))?$this->input->get('adults',true):$_SESSION['adults'];
            $this->session->set_userdata('checkinDate', $_SESSION['checkinDate']);
            $this->session->set_userdata('checkoutDate', $_SESSION['checkoutDate']);
            $this->data['checkinDate'] = $_SESSION['checkinDate'];
            $this->data['checkoutDate'] = $_SESSION['checkoutDate'];
            $this->data['adults'] = $_SESSION['adults'];
            $request = new HotelDetails();
            $request->setHotelProperty($_SESSION['hotelChain'], $_SESSION['hotelCode']);
            $request->setHotelDetailsModifiers($_SESSION['rooms'], $_SESSION['adults'], $_SESSION['checkinDate'], $_SESSION['checkoutDate'], $_SESSION['provider']);
            // $request->setPermittedAggregators($_SESSION['RateSupplier']);
            $request->setBookingGuestInformation($_SESSION['rooms'], $_SESSION['adults']);
            $request->setHostToken($_SESSION['HostToken']);
            $this->data['hotelDetail'] = $this->HotelApiClient->callApi($request, $this->cacheResponse);
            $this->session->set_userdata('hotelDetail', $this->data['hotelDetail']);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode([
                'body' => $this->theme->partial('modules/travelport/hotel/hotelRateDetail', $this->data, TRUE)
            ]));
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function checkout()
    {
        if(isset($_POST) && ! empty($_POST)) {
            $RatePlanType = $this->input->post('RatePlanType');
            $this->session->set_userdata('RatePlanType', $RatePlanType);
            $this->session->set_userdata('GuaranteeType', $this->input->post('GuaranteeType'));
            $this->session->set_userdata('checkinDate', $this->input->post('checkinDate'));
            $this->session->set_userdata('checkoutDate', $this->input->post('checkoutDate'));
            $this->session->set_userdata('adults', $this->input->post('adults'));
            $this->data['checkinDate'] = $_SESSION['checkinDate'];
            $this->data['checkoutDate'] = $_SESSION['checkoutDate'];
            $this->data['totalNights'] = pt_count_days($this->data['checkinDate'], $this->data['checkoutDate']);
            $this->session->set_userdata('totalNights', $this->data['totalNights']);
            $this->data['totalRooms'] = $_SESSION['rooms'];
            $this->data['adults'] = $_SESSION['adults'];
            $this->data['hotelDetail'] = $this->session->userdata('hotelDetail');
            $this->data['roomDetail'] = current(array_filter($this->data['hotelDetail']->RequestedHotelDetails->HotelRateDetail, function($room) use ($RatePlanType) {
                return ($room->RatePlanType == $RatePlanType);
            }));
            $text = $this->data['roomDetail']->RoomRateDescription[0]->Text;
            $this->data['room_name'] = (is_array($text))?implode('<br>, ', $text):$text;
            $this->session->set_userdata('hotelport_room_name', $this->data['room_name']);
            $this->theme->view('modules/travelport/hotel/checkout', $this->data, $this);
        } else {
            redirect('hotelport');
        }
    }

    public function book()
	{
        try {
            $payload = $this->input->post();
            $_SESSION['postOldData'] = $payload;
            $ratePlanType = $this->session->userdata('RatePlanType');
            $guaranteeType = $this->session->userdata('GuaranteeType');
            $requestReservation = new HotelReservation();
            $requestReservation->ProviderCode = $_SESSION['provider'];
            for($i = 0; $i < count($payload['first_name']); $i++) {
                $BookingTraveler = new BookingTraveler();
                $BookingTraveler->BookingTravelerName->First = $payload['first_name'][$i];
                $BookingTraveler->BookingTravelerName->Last = $payload['last_name'][$i];
                $BookingTraveler->PhoneNumber->Number = $payload['phone'][$i];
                $BookingTraveler->Email->EmailID = $payload['email'][$i];
                $BookingTraveler->Address->AddressName = 'Home';
                $BookingTraveler->Address->Street = $payload['street'];
                $BookingTraveler->Address->City = $payload['city'];
                $BookingTraveler->Address->State = $payload['state'];
                $BookingTraveler->Address->PostalCode = $payload['postal_code'];
                $BookingTraveler->Address->Country = $payload['country_code'];
                array_push($requestReservation->BookingTraveler, $BookingTraveler);
            }
            $requestReservation->setHotelRateDetail($ratePlanType);
            $requestReservation->setHotelProperty($_SESSION['hotelChain'], $_SESSION['hotelCode']);
            $requestReservation->setHotelStay($_SESSION['checkinDate'], $_SESSION['checkoutDate']);
            $requestReservation->setGuarantee($guaranteeType, 'CA', $payload['cardNumber'], ($payload['year'].'-'.$payload['month']), $payload['cardCVC']);
            $requestReservation->setGuestInformation($_SESSION['rooms'], $_SESSION['adults']);
            // $requestReservation->setHostToken($_SESSION['HostToken']);
            $bookingResp = $this->HotelApiClient->callApi($requestReservation);
            $universalRecord = $bookingResp->UniversalRecord;

            // Save booking
            $this->load->model('Travelport_hotels/Booking');
            $this->Booking->hotel_name = $universalRecord->HotelReservation->HotelProperty->Name;
            $this->Booking->hotel_stars = 0;
            $this->Booking->hotel_location = implode(',<br>',$universalRecord->HotelReservation->HotelProperty->PropertyAddress->Address);
            $this->Booking->hotel_image = base_url('themes/default/assets/img/hotel.jpg');
            $this->Booking->room_name = $this->session->userdata('hotelport_room_name');
            $this->Booking->checkin = $universalRecord->HotelReservation->HotelStay->CheckinDate;
            $this->Booking->checkout = $universalRecord->HotelReservation->HotelStay->CheckoutDate;
            $this->Booking->total_nights = $this->session->userdata('totalNights');
            $this->Booking->total_amount = $universalRecord->HotelReservation->HotelRateDetail->Total;
            $this->Booking->currency_code = 'AED';
            $this->Booking->booking_holder = json_encode($requestReservation->BookingTraveler);
            $this->Booking->response_object = json_encode($bookingResp);
            $this->Booking->created_at = $universalRecord->HotelReservation->CreateDate;
            $this->Booking->save();

            // Send Notification
            $session_id = rand(0, 1000);
            $_SESSION['order_placed'] = TRUE;
            $_SESSION['notifiable_emails'] = $payload['email'];
            $_SESSION['invoice_url'] = base_url("hotelb/invoice/" . $this->Booking->id."/".$session_id);
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode([
                'status' => 'success',
                'message' => 'Congratulations! Your booking has confirm successfully',
                'invoice_url' => base_url("hotelport/invoice/" . $this->Booking->id."/".$session_id),
                'booking' => $this->Booking
            ]));
        } catch (Exception $e) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'invoice_url' => ''
            ]));
        }
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

        $this->load->model('Travelport_hotels/Booking');
        $booking = new Booking();
        $this->data['invoice'] = $booking->load($invoice_id);
        $this->data['guests'] = json_decode($this->data['invoice']->booking_holder);
        $this->data['bookingCode'] = json_decode($this->data['invoice']->response_object)
        ->UniversalRecord->HotelReservation->BookingConfirmation;
        $this->theme->view('modules/travelport/hotel/invoice', $this->data, $this);
    }

    /**
     * Seperate request for gallery
     * Provider: 1G
     */
    public function mediaLinks($HotelChain, $HotelCode)
    {
        $request = new HotelMediaLinks();
        $request->setHotelProperty($HotelChain, $HotelCode);
        $hotelMedia = $this->HotelApiClient->callApi($request, FALSE);
        if(array_key_exists('MediaItem', $hotelMedia->HotelPropertyWithMediaItems)) {
        	$this->data['hotelMedia'] = $hotelMedia->HotelPropertyWithMediaItems->MediaItem;
        } else {
        	$this->data['hotelMedia'] = NULL;
        }
        $gallery = array_filter($this->data['hotelMedia'], function($image) {
            return ($image->sizeCode == 'C');
        });
        // $this->output->set_content_type('application/json');
        // $this->output->set_output(json_encode($gallery));
        return $gallery;
    }
}