<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Sabre extends MX_Controller {

    const Module = "Sabre";
    const DATE_FORMAT = 'Y-m-d\TH:i:s';
    const ADULT = 'ADT';
    const CHILD = 'CHD';
    const INFANT = 'INF';        
    const CACHE_ENABLED = false;

    public $origin = 'DFW';
    public $destination = 'CDG';
    public $tripType = 'oneWay';
    public $classOfService = 'ECONOMY';
    public $currencyCode = 'EUR'; // Default Currency
    public $requestTypeName = '50ITINS';

    public $airLowFareSearchURI = 'v1/offers/shop';
    public $bookingURI = 'v2.1.0/passenger/records?mode=create';

    public function __construct() 
	{
		parent :: __construct();
        
		$chk = $this->App->service('ModuleService')->isActive(self::Module);
        if (!$chk) { Error_404($this); }

        modules::load('Front');

        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if (empty($this->data['lang_set'])) {
          $this->data['lang_set'] = $defaultlang;
        }
        $this->lang->load("front", $this->data['lang_set']);
        $this->data['appModule'] = self::Module;
        $this->currencyCode = $this->data['app_settings'][0]->currency_code;
    }

    public function index($searchForm = NULL)
    {
        $configurations = app()->service("ModuleService")->get(self::Module);
        $this->origin = $this->session->userdata('sabre.origin');
        $this->destination = $this->session->userdata('sabre.destination');
        $this->tripType = $configurations->settings->tripType;
        $this->classOfService = $configurations->settings->classOfService;

        if (empty($searchForm))
        {
            $this->load->library('Model/SearchForm');
            $searchForm = new SearchForm();
            $searchForm->origin = $this->origin;
            $searchForm->destination = $this->destination;
            $searchForm->departure = date(self::DATE_FORMAT, time());
            $searchForm->arrival = date(self::DATE_FORMAT, strtotime('+1 day'));
            $searchForm->tripType = $this->tripType;
            $searchForm->classOfService = $this->classOfService;
            $searchForm->passenger->adult = 1;
            $searchForm->passenger->children = 0;
            $searchForm->passenger->infant = 0;
        }

        $this->load->library('Sabre/ServiceController');
        $client = new ServiceController();
        $client->sandboxMode = false;
//        if (self::CACHE_ENABLED)
//        {
//            if (isset($_SESSION['cache_expiry']) && time() < $_SESSION['cache_expiry']) {
//                $client->sandboxMode = true; // load cache response
//            } else {
//                $_SESSION['cache_expiry'] = time() + (3600 * 120); // cache response data and set expiry
//            }
//        }

        $this->load->library('Model/Request/AirLowFareSearchReq');
        $AirLowFareSearchReq = new AirLowFareSearchReq();
        
        // Prepare request
        $requestorId = new RequestorID($configurations->apiConfig->domain, $configurations->apiConfig->user_id);
        $AirLowFareSearchReq->setPOS($configurations->apiConfig->group, $requestorId);
        $AirLowFareSearchReq->Version = "1";
        $AirLowFareSearchReq->setOrigin($searchForm->origin, $searchForm->destination, $searchForm->departure);
        if ($searchForm->tripType == 'return') {
            $AirLowFareSearchReq->setDestination($searchForm->destination, $searchForm->origin, $searchForm->arrival);
        }
        $airTravelerAvail = new AirTravelerAvail();
        $airTravelerAvail->PassengerTypeQuantity[] = new Travler(self::ADULT, (int) $searchForm->passenger->adult);
        if ($searchForm->passenger->children) {
            $airTravelerAvail->PassengerTypeQuantity[] = new Travler(self::CHILD, (int) $searchForm->passenger->children);
        }
        if ($searchForm->passenger->infant) {
            $airTravelerAvail->PassengerTypeQuantity[] = new Travler(self::INFANT, (int) $searchForm->passenger->infant);
        }
        $AirLowFareSearchReq->setTravelerInfoSummary($airTravelerAvail, $this->currencyCode);
        $AirLowFareSearchReq->setTPA_Extensions($this->requestTypeName);
        // End: Request payload
        $response = $client->service('OTA_AirLowFareSearchRQ', $AirLowFareSearchReq, array(
            'uri' => $this->airLowFareSearchURI,
        ));
       // dd($response);
        $this->load->model('Sabre/FlightsListingModel');
        $THF = new FlightsListingModel($response);
        $this->data['pageTitle'] = "Search Results - From ".$searchForm->origin." to ".$searchForm->destination;
        $this->data['searchForm'] = $searchForm;
        $this->data['appModule'] = 'Sabre';
        $this->data['link'] = '';
        $this->data["sr"] = $THF;
        $this->data["action_url"] = $THF->action_url;
        $this->theme->view('modules/flights/listing', $this->data, $this);
    }

    public function get_custom_fee($origin)
    {
        $customFare = new CustomFare();

        $configurations = app()->service("ModuleService")->get(self::Module);
        if ($configurations->settings->taxFlag == 'Enabled') 
        {
            $this->db->select('continents.*');
            $this->db->join('continents', 'continents.id = pt_flights_airports.continent_id');
            $this->db->where('pt_flights_airports.code', $origin);
            $dataAdapter = $this->db->get('pt_flights_airports');
            if ($dataAdapter->num_rows() > 0) {
                $dataset = $dataAdapter->row();
                $customFare->tax->currencyCode = $dataset->currency;
                $customFare->tax->amount = $dataset->regional_fee;
                $customFare->administrationFee->currencyCode = $dataset->currency;
                $customFare->administrationFee->amount = $dataset->administration_fee;
            }
        }

        return $customFare;
    }

    public function search(...$args)
    {
        $this->load->library('Model/SearchForm');
        $searchForm = new SearchForm();
        $searchForm->parseUriString($args);
        $searchForm->departure = date(self::DATE_FORMAT, strtotime($searchForm->departure));
        if ($searchForm->tripType == 'return') {
            $searchForm->arrival = date(self::DATE_FORMAT, strtotime($searchForm->arrival));
        }
        $this->session->set_userdata('sabre.origin', $searchForm->origin);
        $this->session->set_userdata('sabre.destination', $searchForm->destination);
        $this->index($searchForm);
    }

    public function checkout()
    {
        $this->load->library('Model/SearchForm');
        $itinerarie = json_decode($this->input->post('itinerarie'));
        $searchForm = unserialize($this->input->post('searchForm'));
        $this->data['pageTitle'] = "Booking";
        $this->data['itinerarie'] = $itinerarie;
        $this->data['searchForm'] = $searchForm;
        $this->theme->view('modules/flights/sabre/booking', $this->data, $this);
    }

    public function booking()
    {
        $itinerarie = json_decode($this->input->post('itinerarie'));
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $surname = $this->input->post('surname');
        $fullname = $this->input->post('fullname');
        $passengerType = $this->input->post('passengerType');
        $totalPassengers = count($surname);
        
        $this->load->library('Model/Booking');
        
        $createPNRRQ = new Booking();
        $createPNRRQ->setPostProcessing(true);
        $createPNRRQ->setReceivedFrom('SP TEST');
        $createPNRRQ->setHaltOnAirPriceError(true);

        $contactNumber = new ContactNumber();
        $contactNumber->NameNumber = '1.1';
        $contactNumber->Phone = $phone;
        $contactNumber->PhoneUseType = 'W';
        $createPNRRQ->setContactNumber($contactNumber);

        for ($i = 0; $i < $totalPassengers; $i++)
        {
            $personName = new PersonName();
            $personName->NameNumber = ($i+1).'.1';
            $personName->NameReference = 'MMM';
            $personName->PassengerType = $passengerType[$i];
            $personName->GivenName = $fullname[$i];
            $personName->Surname = $surname[$i];
            $createPNRRQ->setpersonName($personName);
        }
        
        foreach ($itinerarie->outbound->segments as $segment)
        {
            $flightSegment = new FlightSegment();
            $flightSegment->DepartureDateTime = $segment->departure->date.'T'.$segment->departure->time.':00';
            $flightSegment->ArrivalDateTime = $segment->arrival->date.'T'.$segment->arrival->time.':00';
            $flightSegment->FlightNumber = $segment->flightNumber;
            $flightSegment->NumberInParty = (string) $totalPassengers;
            $flightSegment->Status = 'NN';
            $flightSegment->ResBookDesigCode = 'V';
            $flightSegment->MarketingAirline->Code = $segment->airline->code;
            $flightSegment->MarketingAirline->FlightNumber = $segment->flightNumber;
            $flightSegment->OriginLocation->LocationCode = $segment->departure->airport->code;
            $flightSegment->DestinationLocation->LocationCode = $segment->arrival->airport->code;
            $createPNRRQ->setFlightSegment($flightSegment);
        }
        
        if (! empty($itinerarie->inbound->segments) )
        {
            foreach ($itinerarie->inbound->segments as $segment)
            {
                $flightSegment = new FlightSegment();
                $flightSegment->DepartureDateTime = $segment->departure->date.'T'.$segment->departure->time.':00';
                $flightSegment->ArrivalDateTime = $segment->arrival->date.'T'.$segment->arrival->time.':00';
                $flightSegment->FlightNumber = $segment->flightNumber;
                $flightSegment->NumberInParty =(string) $totalPassengers;
                $flightSegment->Status = 'NN';
                $flightSegment->ResBookDesigCode = 'V';
                $flightSegment->MarketingAirline->Code = $segment->airline->code;
                $flightSegment->MarketingAirline->FlightNumber = $segment->flightNumber;
                $flightSegment->OriginLocation->LocationCode = $segment->departure->airport->code;
                $flightSegment->DestinationLocation->LocationCode = $segment->arrival->airport->code;
                $createPNRRQ->setFlightSegment($flightSegment);
            }
        }
        
        $this->load->library('Sabre/ServiceController');
        $client = new ServiceController();
        $client->sandboxMode = false;
        if (self::CACHE_ENABLED)
        {
            $client->sandboxMode = true;
        }
        $response = $client->service('CreatePassengerNameRecordRQ', $createPNRRQ, array(
            'uri' => $this->bookingURI,
        ));

        $this->load->library('Model/Invoice');
        $invoice = new Invoice();
        $invoice->parse($response);
        $invoice->setBaseFare($itinerarie);
        $invoice->setTax($itinerarie);
        $invoice->setAdministrationFee($itinerarie);
        $invoice->getTotal($itinerarie);
        $invoice->setFullName($surname[0], $fullname[0]);
        $invoice->setEmail($email);
        $invoice->setMobile($phone);
        
        // Save invoice
        if ( ! empty($invoice->PNR) ) {
            $this->save_invoice($invoice);
        }

        $this->data['invoice'] = $invoice;
        $this->theme->view('modules/sabre/invoice', $this->data, $this);
    }

    public function save_invoice($data)
    {
        $this->load->model('Sabre/MInvoice');
        $invoice = new MInvoice();
        $invoice->save($data);
    }

    public function get_invoice()
    {
        $PNR = $this->input->get('pnr');
        $this->load->library('Model/Invoice');
        $this->load->model('Sabre/MInvoice');

        $invoice = new MInvoice();
        $invoice->load($PNR);
        
        $this->data['invoice'] = unserialize($invoice->data);

        $this->theme->view('modules/sabre/invoice', $this->data, $this);
    }
}
