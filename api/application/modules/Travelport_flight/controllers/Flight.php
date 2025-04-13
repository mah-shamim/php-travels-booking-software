<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * Travelport Flight controller
 *
 * @category Frontend
 */
class Flight extends MX_Controller {
	
	public $month_name = array(
		1 => 'January', 
		2 => 'February', 
		3 => 'March', 
		4 => 'April', 
		5 => 'May', 
		6 => 'June', 
		7 => 'July', 
		8 => 'August', 
		9 => 'September', 
		10 => 'October', 
		11 => 'November', 
		12 => 'December'
	);

	/**
	 * This constant define that how many element should be display in `flights in slider`.
	 * If the element count less then 5 then do not show display slider in view.
	 * The number should be 6 or greater.
	 *
	 * @var constant
	 */
	const TOTAL_FLIGHTS_IN_SLDIER = 5;


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

		// For menu `HOME` and `My Account` link in header.
		$this->lang->load("front", $this->data['lang_set']);

		$user_id = $this->session->userdata('pt_logged_customer');
        $this->data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;

		// Load travelport model and populate search form with default values
		$this->load->model('TravelportModel_Conf');
		$this->travelportConfiguration = new TravelportModel_Conf();
		$this->travelportConfiguration->load();
        $this->load->model('Travelport_flight/FlightsSearchModel');

		$this->data['pageTitle'] = "Flights List";
	}
	
	/**
	 * Flight listing through PHP request
	 *
	 * @return html
	 */
	public function index()
	{
		$search_query = NULL;
		$this->data['error'] = NULL;

		if ( func_num_args() < 5 ) {
			$searchQuery = $this->session->userdata('searchQuery');
			if (isset($searchQuery) && ! empty($searchQuery)) {
				$search_query = $searchQuery;
				$search_query['origin'] = $this->travelportConfiguration->default_origin;
    			$search_query['destination'] = $this->travelportConfiguration->default_destination;
				$datetime = new DateTime('tomorrow');
				$search_query['departure'] = $datetime->format('Y-m-d');
			} else {
				$search_query = array();
				$search_query['origin'] = $this->travelportConfiguration->default_origin;
    			$search_query['destination'] = $this->travelportConfiguration->default_destination;
				$datetime = new DateTime('tomorrow');
				$search_query['departure'] = $datetime->format('Y-m-d');
				$search_query['arrival'] = '';
				$search_query['triptype'] = 'oneway';
				$search_query['cabinclass'] = 'economy';
				$search_query['passenger']['tadult'] = 1;
				$search_query['passenger']['tchildren'] = 0;
				$search_query['passenger']['tinfant'] = 0;
				$search_query['passenger']['total'] = 1;
			}
		} else {
			$arguments = func_get_args();
			$search_query = $this->get_payload($arguments);
		}
		try {
			$this->session->set_userdata(array('searchQuery' => $search_query)); // Refresh session
			$this->data['travelportSearchFormData'] = array(
				'searchQuery' => $search_query,
				'configuration' => $this->travelportConfiguration,
				'requestType' => 'php'
			);
			$this->data['dataAdapter'] = $this->get_response($search_query);
			$this->data['month_name'] = $this->month_name;
			$segmentListCount = $this->data['dataAdapter']['totalListingFound'];
			$this->data['flightsListSliderflag'] = ($segmentListCount > $this::TOTAL_FLIGHTS_IN_SLDIER) ? TRUE : FALSE;
		}
		//catch exception
		catch(Exception $e) {
			$this->data['error'] = $this->box_warning($e->getMessage());
			// echo 'Please provide valid parameters, We are unable to process the request.';
			// redirect( base_url() );
		}
        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new FlightsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('Travelport_flight',serialize($searchForm));
      // $data = file_get_contents(FCPATH."data.json");
        $this->load->model('Travelport_flight/FlightsListingModel');
        $THF = new FlightsListingModel($this->data['dataAdapter']);
        $this->data['pageTitle'] = "Flights Results - From to ".$searchForm->origin." to ".$searchForm->destination;
        $this->data['search'] = $searchForm;
        $this->data['appModule'] = 'Travelport_flight';
        $this->data["sr"] = $THF;
//dd($THF->final_array);
        $this->theme->view('modules/flights/listing', $this->data, $this);
	}

	private function get_payload($arguments)
	{
	   // dd($arguments);
		$this->load->helper('security');
		$index = 0;
		$payload['passenger']['adult'] = 1;
		$payload['passenger']['children'] = 0;
		$payload['passenger']['infant'] = 0;
		$payload['triptype'] = 'oneway';

		$payload['origin'] = $this->security->xss_clean($arguments[0]);
		$index += 1;
		$payload['destination'] = $this->security->xss_clean($arguments[1]);
		$index += 1;
		$payload['departure'] = $this->security->xss_clean($arguments[4]);
		$index += 1;
		$payload['arrival'] = '';
		if($arguments[2] == 'round'){
            $arrival_date = $this->security->xss_clean($arguments[5]);
        }
		$arrivalDate = $this->validateDate($arrival_date);
		if ( isset($arrivalDate) && ! empty($arrivalDate) ) {
			$payload['arrival'] = $arrivalDate;
			$payload['triptype'] = 'round';
			$index += 1;
		}
		$payload['cabinclass'] = $this->security->xss_clean($arguments[3]);
		$index += 1;
        if($arguments[2] == 'round'){
            $passenger_adult = $this->security->xss_clean($arguments[6]);
            $payload['passenger']['adult'] = $this->get_int_from_string($passenger_adult);
            $index += 1;
            if (isset($arguments[$index])) {
                $passenger_children = $this->security->xss_clean($arguments[7]);
                $payload['passenger']['children'] = $this->get_int_from_string($passenger_children);
            }
            $index += 1;
            if (isset($arguments[$index])) {
                $passenger_infant = $this->security->xss_clean($arguments[8]);
                $payload['passenger']['infant'] = $this->get_int_from_string($passenger_infant);
            }
        }else {
            $passenger_adult = $this->security->xss_clean($arguments[5]);
            $payload['passenger']['adult'] = $this->get_int_from_string($passenger_adult);
            $index += 1;
            if (isset($arguments[$index])) {
                $passenger_children = $this->security->xss_clean($arguments[6]);
                $payload['passenger']['children'] = $this->get_int_from_string($passenger_children);
            }
            $index += 1;
            if (isset($arguments[$index])) {
                $passenger_infant = $this->security->xss_clean($arguments[7]);
                $payload['passenger']['infant'] = $this->get_int_from_string($passenger_infant);
            }
        }
		$payload['passenger']['total'] = $payload['passenger']['adult'] + $payload['passenger']['children'] + $payload['passenger']['infant'];
		return $payload;
	}
	
	private function validateDate($date)
	{
		$d = DateTime::createFromFormat('Y-m-d', $date);
		if ($d && $d->format('Y-m-d') === $date) {
			return $date;
		} else {
			return NULL;
		}
	}

	private function get_int_from_string($string)
    {
        return preg_replace("/[^0-9\.]/", "", $string);
    }

	public function getLowFareFlights()
	{
	    try {
			$payload = $this->input->post();
			
			// Save query in session for php request
			$this->session->set_userdata(['searchQuery' => $payload]);
			$this->data['travelportSearchFormData'] = array(
				'searchQuery' => $this->session->userdata('searchQuery'),
				'configuration' => $this->travelportConfiguration,
				'requestType' => 'ajax'
			);

			$this->data['dataAdapter'] = $this->get_response($payload);
			$this->data['month_name'] = $this->month_name;
			$segmentListCount = $this->data['dataAdapter']['totalListingFound'];
			$this->data['flightsListSliderflag'] = ($segmentListCount > $this::TOTAL_FLIGHTS_IN_SLDIER) ? TRUE : FALSE;
			
			$response = array(
				'status' => 'success',
				'body' => $this->theme->partial('modules/travelport/flight/index', $this->data, TRUE),
			);
		}
		//catch exception
		catch(Exception $e) {
			$response = array(
				'status' => 'fail',
				'body' => $this->box_warning($e->getMessage()),
			);
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}

	public function get_response($payload)
	{
		$this->load->library('Hotels/Hotels_lib');
		$currencey_code = $this->Hotels_lib->currencycode;
		if ($this->session->userdata('currencycode')) {
			$currencey_code = $this->session->userdata('currencycode');
		}
		
		$this->load->library('travelport/Airservice', 'AirLowFareSearchReq');
		$airLowFareSearchReq = $this->Airservice;

		$origin_city = $airLowFareSearchReq->city_detail($payload['origin']);
		$origin_country = $airLowFareSearchReq->country_detail($origin_city['countryCode']);
		$this->data['flying_from'] = $origin_city['fullname'] .', '. $origin_country['fullname'];
		$destination_city = $airLowFareSearchReq->city_detail($payload['destination']);
		$destination_country = $airLowFareSearchReq->country_detail($destination_city['countryCode']);
		$this->data['flying_to'] = $destination_city['fullname'] .', '. $destination_country['fullname'];
		
		$this->data['departure_time'] = $payload['departure'];
		$this->data['arrival_time'] = ( ! empty($payload['arrival'])) ? " - " . $payload['arrival'] : "";
		
		$parameters['AuthorizedBy'] = 'Travelport';
		$parameters['TargetBranch'] = $airLowFareSearchReq->branch_code;

		$parameters['BillingPointOfSaleInfo']['OriginApplication'] = 'UAPI';
		
		// Passanger
		// $parameters['SearchPassenger']['Code'] = 'ADT';
		$parameters['AirPricingModifiers']['CurrencyType'] = $currencey_code;
		$parameters['AirPricingModifiers']['AccountCodes']['AccountCode']['Code'] = '-';

		// AirSearchModifiers
		$parameters['AirSearchModifiers']['PreferredProviders']['Provider']['Code'] = '1G';

		// Cabin Class
		$parameters['AirSearchModifiers']['PreferredCabins']['CabinClass']['Type'] = $payload['cabinclass'];

		// SearchAirLeg
		$parameters['SearchAirLeg'] = array();
		$SearchAirLeg['SearchOrigin']['CityOrAirport']['Code'] = $payload['origin'];
		$SearchAirLeg['SearchOrigin']['CityOrAirport']['PreferCity'] = 'true';
		$SearchAirLeg['SearchDestination']['CityOrAirport']['Code'] = $payload['destination'];
		$SearchAirLeg['SearchDestination']['CityOrAirport']['PreferCity'] = 'true';
		$SearchAirLeg['SearchDepTime']['PreferredTime'] = $payload['departure'];
		
		array_push($parameters['SearchAirLeg'], $SearchAirLeg);

		if ($payload['triptype'] == 'round') 
		{
			$SearchAirLeg['SearchOrigin']['CityOrAirport']['Code'] = $payload['destination'];
			$SearchAirLeg['SearchOrigin']['CityOrAirport']['PreferCity'] = 'true';
			$SearchAirLeg['SearchDestination']['CityOrAirport']['Code'] = $payload['origin'];
			$SearchAirLeg['SearchDestination']['CityOrAirport']['PreferCity'] = 'true';
			$SearchAirLeg['SearchDepTime']['PreferredTime'] = $payload['arrival'];

			array_push($parameters['SearchAirLeg'], $SearchAirLeg);
		}

		$parameters['SearchPassenger'] = array();
		$passenger = array();
		// Passenger Adult
		for ($i = 0; $i < $payload['passenger']['adult']; $i++) {
			array_push($parameters['SearchPassenger'], array('Code' => 'ADT'));
			array_push($passenger, array('Code' => 'ADT', 'Name' => 'Adult'));
		}

		// Passenger: Children
		for ($i = 0; $i < $payload['passenger']['children']; $i++) {
			array_push($parameters['SearchPassenger'], array('Code' => 'CNN'));
			array_push($passenger, array('Code' => 'CNN', 'Name' => 'Children'));
		}

		// Passenger: Infant
		for ($i = 0; $i < $payload['passenger']['infant']; $i++) {
			array_push($parameters['SearchPassenger'], array('Code' => 'INF'));
			array_push($passenger, array('Code' => 'INF', 'Name' => 'Infant'));
		}

		// Passanger count store in session
		$this->session->set_userdata(array('SearchPassenger' => $passenger));


		return $airLowFareSearchReq->service($parameters);
	}

	private function box_warning($message)
	{
		return '<div class="container"><div class="text-center"><div class="alert alert-danger">
			<strong>Warning!</strong> '.$message.'
		</div></div></div>';
	}
}
