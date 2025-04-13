<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
require_once "Flight.php";
/**
 * Travelport Cart
 *
 * @category Frontend
 */
ini_set('display_errors', 1);
class Cart extends Flight {

    private $aFareInfo = NULL;

    private $AIRLINE_CARRIER_LOGO = NULL;


	public function __construct() 
	{
		parent :: __construct();

        $chk = modules::run('Home/is_main_module_enabled', 'travelport_flight');

        if ( ! $chk ) { Module_404(); }

        // For contact detail display in header.
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');

        $this->data['usersession'] = $this->session->userdata('pt_logged_customer');
        $this->data['appModule'] = "travelport_flight";

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
        $this->data['languageList'] = pt_get_languages();
        $this->data['footersocials'] = pt_get_footer_socials();
        $this->data['currenturl'] = uri_string();
        // For menu `HOME` and `My Account` link in header.
        $this->lang->load("front", $this->data['lang_set']);

        $user_id = $this->session->userdata('pt_logged_customer');
        $this->data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;


        // Load travelport configurations
        $this->config->load('travelport', TRUE);
        $confTravelport = $this->config->item('travelport');

        $this->AIRLINE_CARRIER_LOGO = $confTravelport['AIRLINE_CARRIER_LOGO'];

        $this->data['pageTitle'] = "Flight Booking";
    }

    /**
     * When user click on booknow button, this function gets called. 
     *
     * @return json
     */
    public function checkout()
    {
        $payload = $this->input->post();
       // dd($payload);
//        try {
            $response = $this->get_response($payload);

            $this->session->set_userdata(array('travelportCheckoutResp' => $response));
            
            $summary = new StdClass();
            $outbound_segment_first = is_object($response->outbound->segment) ? $response->outbound->segment : current($response->outbound->segment);
            $outbound_segment_last = is_object($response->outbound->segment) ? $response->outbound->segment : end($response->outbound->segment);
            
            $summary->triptype = (empty($inbound)) ? "oneway" : "round";
            
            $referenceData = new ReferenceData();
            $segmentDetail = new StdClass();
            $carrier = (Object) $referenceData->airline_carrier($outbound_segment_first->Carrier);
            $carrier->image_path = sprintf($this->AIRLINE_CARRIER_LOGO, $outbound_segment_first->Carrier);
            $equipment = (Object) $referenceData->airline_equipment($outbound_segment_first->Equipment);
            
            $summary->carrier = $carrier;
            $summary->equipment = $equipment;
            $summary->outbound = (Object) array(
                'Carrier' => $outbound_segment_first->Carrier,
                'Origin' => $outbound_segment_first->Origin,
                'Destination' => $outbound_segment_last->Destination,
                'DepartureTime' => $this->parse_datetime($outbound_segment_first->DepartureTime),
                'ArrivalTime' => $this->parse_datetime($outbound_segment_last->ArrivalTime),
            );
            if ($summary->triptype == 'round') {
                $inbound_segment_first = is_object($response->inbound->segment) ? $response->inbound->segment : current($response->inbound->segment);
                $inbound_segment_last = is_object($response->inbound->segment) ? $response->inbound->segment : end($response->inbound->segment);
                $summary->inbound = (Object) array(
                    'Carrier' => $inbound_segment_first->Carrier,
                    'Origin' => $inbound_segment_first->Origin,
                    'Destination' => $inbound_segment_last->Destination,
                    'DepartureTime' => $this->parse_datetime($inbound_segment_first->DepartureTime),
                    'ArrivalTime' => $this->parse_datetime($inbound_segment_last->ArrivalTime),
                );
            }
            
            $response->summary = $summary;
            $response->searchPassenger = (Object) $this->session->userdata('SearchPassenger');
            $this->data['dataAdapter'] = $response;

            // Fake data for pre-populate the checkout form, only in sandbox mode. 
            $fakedata = new StdClass();
            $fakedata->sandbox_mode = 0;
            if ($this->travelportConfiguration->sandbox_mode) {
                $fakedata->sandbox_mode = 1;
                $fakedata->first_name = 'John';
                $fakedata->last_name = 'Smith';
                $fakedata->phone_number = '00123456789';
                $fakedata->nationality = 'United States';
                $fakedata->card_number = '5416144754363722';
                $fakedata->cvv = '123';
            }
            $this->data['fakedata'] = $fakedata;

			$response = array(
				'status' => 'success',
				'body' => $this->theme->partial('modules/flights/travelport/cart_checkout', $this->data, TRUE),
			);
//		}
//		//catch exception
//		catch(Exception $e) {
//            $response = array(
//				'status' => 'fail',
//				'body' => '<div class="alert alert-danger text-center" style="margin: 5%;">'.$e->getMessage().'</div>',
//			);
//		}
        
        //$this->output->set_content_type('application/json');
		//$this->output->set_output(json_encode($response));
       // dd($response['body']);
        echo $response['body'];
    }

    /**
     * Place order, Final hit.
     * 
     * When a booking is made in Universal API, a Passenger Name Record (PNR), 
     * also known as a Booking File, and a Universal Record (UR) are created.
     *
     * This function create PNR and also store booking record into local DB for invoice.
     *
     * @return json
     */
    public function placeorder()
    {
        try {
            $notifiable_emails = "";
            $passengerForm = $this->input->post();
            $response = $this->get_placeorder_response($passengerForm);
            //dd($response);
            $this->data['dataAdapter'] = $response;
            $this->data['order_placed'] = TRUE;
            $this->data['notifiable_emails'] = $notifiable_emails;
            $this->data['invoice_url'] = site_url('flight/invoice?token=' . $response->pnr);

            // Send Notifications through ajax requests on page load
            $invoice_body = $this->theme->partial('modules/flights/travelport/invoice', $this->data, TRUE);
            
			$response = array(
				'status' => 'success',
				'body' => $invoice_body,
			);
		}
		//catch exception
		catch(Exception $e) {
            $response = array(
				'status' => 'fail',
				'body' => $e->getMessage(),
			);
		}
        //$this->output->set_content_type('application/json');
        //$this->output->set_output(json_encode($response));
        echo $response['body'];
    }

    /**
     * Place an order in travelport
     *
     * @param  Booking form parameters
     * @return Array
     */
    public function get_placeorder_response($passengerForm)
    {
        //dd($passengerForm);
        $notifiable_emails = array();
        $passengers = array();
        for($index = 0; $index <= $passengerForm['formsCount']; $index++) 
        {
            $passenger = new StdClass();
            $passenger->title = $this->get_passenger($passengerForm['title'][$index]);
            $passenger->firstname = $this->get_passenger($passengerForm['firstname'][$index]);
            $passenger->lastname = $this->get_passenger($passengerForm['lastname'][$index]);
            $passenger->phone = $this->get_passenger($passengerForm['phone'][$index]);
            $passenger->email = $this->get_passenger($passengerForm['email'][$index]);
            $passenger->nationality = $this->get_passenger($passengerForm['nationality'][$index]);
            $passenger->code = $this->get_passenger($passengerForm['code'][$index]);
            
            array_push($passengers, $passenger);
            array_push($notifiable_emails, $passenger->email);
        }
        //dd( $passengerForm);
        $this->load->library('travelport/Reservation', ['AirCreateReservationReq', 'UNIVERSAL']);
        $AirCreateReservationReq = $this->Reservation;
        $parameters = $this->payload_placeorder($passengerForm, $passengers, $AirCreateReservationReq->branch_code);
        $response = $AirCreateReservationReq->service($parameters);
        //dd( $response);
        // Final place order Request/Response for invoice page
        $this->load->model('TravelportModel_Cart');
        $cart = new TravelportModel_Cart();
        $this->data['recervation'] = $cart->save_AirCreateReservationReqRsp($parameters, $response);
//        $cart->refreshTravelportSessionData();

        return $response;
    }

    public function get_passenger($value)
    {
        if (is_array($value)) {
            return current($value);
        } else {
            return $value;
        }
    }

    private function payload_placeorder($passengerForm, $passengers, $branch_code)
    {
        $checkoutResp = $this->session->userdata('travelportCheckoutResp');
        
        $FormOfPaymentKey = $this->generateRandomString(5);
        $FormOfPaymentKey = 'FPK'.$FormOfPaymentKey;
        $PaymentKey = 'PK'.$FormOfPaymentKey;

        $parameters['AuthorizedBy'] = 'Travelport';
        $parameters['TargetBranch'] = $branch_code;
        $parameters['ProviderCode'] = '1G';
        $parameters['RetainReservation'] = 'Both';
        $parameters['BillingPointOfSaleInfo'] = array('OriginApplication' => 'UAPI');
        $BookingTraveler = $this->BookingTraveler($passengers);
        $parameters['BookingTraveler'] = $BookingTraveler;
        /*
         * <CreditCard CVV="" Number="" Type="" Key="0010" />
         * <DebitCard  CVV="" Number="" Type="" />
         * <Check RoutingNumber="456" AccountNumber="7890" CheckNumber="1234567" />
         *
         * Permitted values are [
         *  Credit, Ticket, Cash, Check, Certificate, Debit, Invoice, 
         *  Requisition, MiscFormOfPayment, UnitedNations, DirectPayment, AgentVoucher, AccountReceivable, 
         *  AgentNonRefundable, AgencyPayment, DirectBill, OtherGuaranteeInfo, Voucher, MiscFormOfPaymentCash, 
         *  MiscFormOfPaymentCredit, StateGovtTransferRequest, Agent, GovtTransferRequest, NonRefundable, Enett
         * ]
         * 
         * CA: Master Card
         */
        // $parameters['FormOfPayment'] = array('Type' => 'Check');
        // $parameters['FormOfPayment']['Check'] = array('RoutingNumber' => 'Check', 'AccountNumber' => '7890', 'CheckNumber' => '1234567');
        $parameters['FormOfPayment'] = array('Type' => 'Credit', 'Key' => $FormOfPaymentKey);
        $parameters['FormOfPayment']['CreditCard'] = array(
            'CVV' => $passengerForm['cvv'], 
            'Number' => $passengerForm['cardno'], 
            'Type' => $passengerForm['cardtype'], 
            'ExpDate' => sprintf('%s-%s', $passengerForm['expYear'], $passengerForm['expMonth'])
        );

        $AirPricingSolution = $this->get_AirPricingSolution($BookingTraveler);
        $AirPricingSolution->AirSegment = array();
        if ( ! empty($checkoutResp->outbound->segment) ) 
        {
            foreach($checkoutResp->outbound->segment as $segment)
            {
                $placeorderSegment = clone $segment;
                unset($placeorderSegment->detail);
                array_push($AirPricingSolution->AirSegment, $placeorderSegment);
            }
        }

        if ( ! empty($checkoutResp->inbound->segment) ) 
        {
            foreach($checkoutResp->inbound->segment as $segment)
            {
                $placeorderSegment = clone $segment;
                unset($placeorderSegment->detail);
                array_push($AirPricingSolution->AirSegment, $placeorderSegment);
            }
        }
        $parameters['AirPricingSolution'] = $AirPricingSolution;
        $parameters['ActionStatus'] = array('Type' => 'ACTIVE', 'TicketDate' => 'T*', 'ProviderCode' => '1G');
        // Payment information - must be used in conjunction with credit card info
        $parameters['Payment'] = array('Key' => $PaymentKey, 'Type' => 'Itinerary', 'FormOfPaymentRef' => $FormOfPaymentKey, 'Amount' => $AirPricingSolution->TotalPrice);

        return $parameters;
    }

    private function BookingTraveler($passengers)
    {
        $BookingTraveler = array();
        $DeliveryAddressFlag = TRUE;
        foreach($passengers as $index => $passenger)
        {
            $key = $index;
            $key .= $this->generateRandomString(7);

            $traveler = new StdClass();
            $traveler->Key = $key;
            $traveler->TravelerType = $passenger->code;
            // Infant date of birth is required
            $year = (date('Y') - 5);
            if ($passenger->code == 'INF') {
                $year = (date('Y') - 1);
            }
            $traveler->DOB = sprintf('%s-%s-%s', $year, date('m'), date('d'));
            // $traveler->Nationality = $passenger->nationality;
            $traveler->BookingTravelerName = (Object) array(
                'Prefix' => $passenger->title,
                'First' => $passenger->firstname,
                'Last' => $passenger->lastname,
            );
            
            // Host only allows one Address/Delivery Address. Only one sent in request.
            if ($DeliveryAddressFlag)
            {
                $traveler->DeliveryInfo = new StdClass();
                $traveler->DeliveryInfo->ShippingAddress = new StdClass(); 
                $traveler->DeliveryInfo->ShippingAddress->Key = $key;
                // $traveler->DeliveryInfo->ShippingAddress->Street = new StdClass();
                // $traveler->DeliveryInfo->ShippingAddress->Street = "Street 4, HH Block DHA";
                // $traveler->DeliveryInfo->ShippingAddress->City = "Lahore";
                // $traveler->DeliveryInfo->ShippingAddress->PostalCode = "54810";
                // $traveler->DeliveryInfo->ShippingAddress->Country = "PK";
                $DeliveryAddressFlag = FALSE;
            }

            $traveler->PhoneNumber = new StdClass();
            // $traveler->PhoneNumber->Location = "LHE";
            // $traveler->PhoneNumber->CountryCode = "+92";
            // $traveler->PhoneNumber->AreaCode = "42";
            $traveler->PhoneNumber->Number = $passenger->phone;
            $traveler->Email = new StdClass();
            $traveler->Email->EmailID = $passenger->email;
            // $traveler->SSR = new StdClass();
            // $traveler->SSR->Type = "DOCS";
            // href: https://support.travelport.com/webhelp/uapi/Content/Air/Shared_Air_Topics/SSRs_(Special_Service_Requests).htm
            // $traveler->SSR->FreeText = "P/PK/S12345678/PK/01FEB91/M/01JAN21/{$passenger->lastname}/{$passenger->firstname}";
            // $traveler->SSR->Carrier = "QR";

            array_push($BookingTraveler, $traveler);
        }

        return $BookingTraveler;
    }

    private function get_AirPricingSolution($BookingTraveler)
    {
        $passengerTypeArray = array();
        foreach($BookingTraveler as $BookingTravelerObj)
        {
            if( ! array_key_exists($BookingTravelerObj->TravelerType, $passengerTypeArray) ) {
                $passengerTypeArray[$BookingTravelerObj->TravelerType] = array();
            }
            
            array_push($passengerTypeArray[$BookingTravelerObj->TravelerType], (Object) array(
                'Code' => $BookingTravelerObj->TravelerType,
                'BookingTravelerRef' => $BookingTravelerObj->Key,
            ));
        }
        
        $travelportCartResp = $this->session->userdata('travelportCartResp');
        if (empty($travelportCartResp)) {
            throw new Exception("Response cache has been cleared, search again this trip.");
        }

        $AirPricingSolution = new StdClass();
        $AirPricingSolution->Key = $travelportCartResp->AirPriceResult->AirPricingSolution->Key;
        $AirPricingSolution->TotalPrice = $travelportCartResp->AirPriceResult->AirPricingSolution->TotalPrice;
        $AirPricingSolution->BasePrice = $travelportCartResp->AirPriceResult->AirPricingSolution->BasePrice;
        $AirPricingSolution->ApproximateTotalPrice = $travelportCartResp->AirPriceResult->AirPricingSolution->ApproximateTotalPrice;
        $AirPricingSolution->ApproximateBasePrice = $travelportCartResp->AirPriceResult->AirPricingSolution->ApproximateBasePrice;
        $AirPricingSolution->EquivalentBasePrice = @$travelportCartResp->AirPriceResult->AirPricingSolution->EquivalentBasePrice; // Missing in some search response
        $AirPricingSolution->Taxes = $travelportCartResp->AirPriceResult->AirPricingSolution->Taxes;
        $AirPricingSolution->Fees = $travelportCartResp->AirPriceResult->AirPricingSolution->Fees;
        $AirPricingSolution->AirPricingInfo = array();
        
        /*
         * Check Array Or Object
         * 
         * Problem: 
         * I am getting a warning like 3100 : INVALID INPUT and Some of the requested AirPricingInfos 
         * could not be saved for the requested provider.
         *
         * Solution:
         * We have removed the PlatingCarrier from the request.
         * Please Remove the PlatingCarrier attribute from the AirPricingInfo and give it a try.
         * href: https://github.com/Travelport/travelport-uapi-tutorial/issues/232
         * href: https://github.com/Travelport/travelport-uapi-tutorial-php/issues/70
         */
        
        $aAirPricingInfo = $travelportCartResp->AirPriceResult->AirPricingSolution->AirPricingInfo;
        if(is_object($aAirPricingInfo)) 
        {
            // Deep Copy of object
            $clone_AirPricingInfo = unserialize(serialize($aAirPricingInfo));
            $passengerType = is_object($aAirPricingInfo->PassengerType) ? $aAirPricingInfo->PassengerType : current($aAirPricingInfo->PassengerType);
            $clone_AirPricingInfo->PassengerType = $passengerTypeArray[$passengerType->Code];
            unset($clone_AirPricingInfo->PlatingCarrier); // PlatingCarrier Deprecated in request
            $AirPricingSolution->AirPricingInfo = $clone_AirPricingInfo;
        }
        else 
        {
            foreach($aAirPricingInfo as $AirPricingInfo)
            {
                // Deep Copy of object
                $clone_AirPricingInfo = unserialize(serialize($AirPricingInfo));
                $passengerType = is_object($AirPricingInfo->PassengerType) ? $AirPricingInfo->PassengerType : current($AirPricingInfo->PassengerType);
                $clone_AirPricingInfo->PassengerType = $passengerTypeArray[$passengerType->Code];
                unset($clone_AirPricingInfo->PlatingCarrier); // PlatingCarrier Deprecated in request
                array_push($AirPricingSolution->AirPricingInfo, $clone_AirPricingInfo);
            }
        }
        
        $AirPricingSolution->HostToken = $travelportCartResp->AirPriceResult->AirPricingSolution->HostToken;

        return $AirPricingSolution;
    }
    
    public function get_response($payload)
    {

        // Load travelport model and populate search form with default values
		$this->load->model('TravelportModel_Conf');
		$this->travelportConfiguration = new TravelportModel_Conf();
        $this->travelportConfiguration->load();
        
        $this->load->library('Hotels/Hotels_lib');
		$currencey_code = $this->Hotels_lib->currencycode;
		if ($this->session->userdata('currencycode')) {
			$currencey_code = $this->session->userdata('currencycode');
		}
        $response = $this->session->userdata('travelportResp');
        $this->aFareInfo = $response->FareInfoList->FareInfo;

        $this->load->library('travelport/Airprice', 'AirPriceReq');
		$AirpriceReq = $this->Airprice;
        $outbound = $payload['outbound'];
		$inbound = $payload['inbound'];
        $segment_key = array_merge(explode(',', $outbound), explode(',', $inbound));
        $parameters['AuthorizedBy'] = 'Travelport';
        $parameters['TargetBranch'] = $AirpriceReq->branch_code;
        $parameters['BillingPointOfSaleInfo'] = array('OriginApplication' => 'UAPI');
        $parameters['AirItinerary']['AirSegment'] = array();
        $parameters['AirPricingModifiers'] = array('CurrencyType' => $currencey_code);

        foreach(castToArray($response->AirSegmentList->AirSegment) as $segment)
        {
            // Clone segment object, so the orignal object being protected from amendments.
            $segment_temp = unserialize(serialize($segment));
            if (in_array($segment->Key, $segment_key)) 
            {
                $segment_temp->ProviderCode = $segment->AirAvailInfo->ProviderCode;
                unset($segment_temp->FlightDetailsRef);
                unset($segment_temp->AirAvailInfo);
                array_push($parameters['AirItinerary']['AirSegment'], $segment_temp);
            }
        }
        
        $passengers = $this->session->userdata('SearchPassenger');
        $parameters['SearchPassenger'] = array();
        foreach ($passengers as $index => $passenger)
        {
            $unique_key = $this->generateRandomString(5);
            $unique_key = 'PT'.$index.$unique_key;
            array_push($parameters['SearchPassenger'], array(
                'BookingTravelerRef' => $unique_key, 
                'Key' => $unique_key, 
                'Code' => $passenger['Code']
            ));
        }
        
        $parameters['AirPricingCommand']['AirSegmentPricingModifiers'] = array();
        $response_AirPricePointList_AirPricePoint = is_object($response->AirPricePointList->AirPricePoint) ? array($response->AirPricePointList->AirPricePoint) : $response->AirPricePointList->AirPricePoint;
        $duplicateEntry = array(); // Prevent Duplicate entries
        foreach($response_AirPricePointList_AirPricePoint as $AirPricePoint)
        {
            $AirPricePoint_AirPricingInfo = is_object($AirPricePoint->AirPricingInfo) ? array($AirPricePoint->AirPricingInfo) : $AirPricePoint->AirPricingInfo;
            foreach($AirPricePoint_AirPricingInfo as $AirPricingInfo)
            {
                $FlightOptions = $AirPricingInfo->FlightOptionsList->FlightOption;
                $FlightOptions = is_object($FlightOptions) ? array($FlightOptions) : $FlightOptions;
                foreach($FlightOptions as $FlightOption)
                {
                    $aOption = is_object($FlightOption->Option) ? array($FlightOption->Option) : $FlightOption->Option;
                    foreach($aOption as $Option)
                    {
                        $Option_BookingInfo = is_object($Option->BookingInfo) ? array($Option->BookingInfo) : $Option->BookingInfo;
                        foreach($Option_BookingInfo as $BookingInfo)
                        {
                            if (in_array($BookingInfo->SegmentRef, $segment_key) && ! in_array($BookingInfo->SegmentRef, $duplicateEntry)) 
                            {
                                $FareInfo = $this->fareInfoList($BookingInfo->FareInfoRef);
                                array_push($parameters['AirPricingCommand']['AirSegmentPricingModifiers'], array(
                                    'AirSegmentRef' => $BookingInfo->SegmentRef, 
                                    'FareBasisCode' => $FareInfo->FareBasis,
                                    'PermittedBookingCodes' => array('BookingCode' => array('Code' => $BookingInfo->BookingCode))
                                ));

                                array_push($duplicateEntry, $BookingInfo->SegmentRef);
                            }
                        }
                    }
                }
            }
        }

        // Payment type Credit, Check
        $parameters['FormOfPayment'] = array('Type' => 'Credit');

        return $AirpriceReq->service($parameters);
    }

    private function fareInfoList($fareInfoRef)
    {
        $result = array_filter($this->aFareInfo, function($fareInfo) use ($fareInfoRef) {
            if ($fareInfo->Key == $fareInfoRef) {
                return TRUE;
            }
        });

        return (Object) current($result);
    }

    public function generateRandomString($length = 10) 
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

   /**
    * Timestamp with zone parser
    * href: href: https://stackoverflow.com/questions/18056543/parsing-a-datetime-string-with-timezone-in-php
    *
    * @return Array
    */
    private function parse_datetime($timezone_stamp)
    {
        $dateTimeObj = new DateTime($timezone_stamp);
        return $dateTimeObj->format('l jS F Y \a\t g:ia');
    }
}