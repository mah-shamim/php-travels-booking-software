<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**

 * Iati Flight controller

 *

 * @category Frontend

 */

class Iati_flight extends MX_Controller {

	const CACHE_DATA = false;

    public function __construct(){

		parent::__construct();

		

		// Access Checkpoint

		// Module enabled/disabled checkpoint

		$chk = $this->App->service('ModuleService')->isActive('iati_flight');

		if ( ! $chk) {

			backError_404($this->data);

		}

		

		// For contact detail display in header.

		$this->data['phone'] = $this->load->get_var('phone');

		$this->data['contactemail'] = $this->load->get_var('contactemail');



		$this->data['usersession'] = $this->session->userdata('pt_logged_customer');

		$this->data['appModule'] = "iati_flight";



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

		

        $this->data['page_title'] = 'Iati Flights Management';

		$this->data['header_title'] = 'Iati Flights Management';

		$this->load->library('Iati_flight/Iati_lib');

        $this->load->model('Iati_flight/FlightsSearchModel');

    }



	public function search(){

        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new FlightsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('Iati_flight',serialize($searchForm));
		$check = isset($searchForm->arrival) ? true : false;
		$iati_origin = json_decode($searchForm->origin);
		$iati_destination = json_decode($searchForm->destination);
		// echo "<pre>";print_r($iati_origin);exit();
		if(!(isset($iati_origin) && isset($iati_destination))){
			$this->session->set_userdata(array(
				'orig' => $searchForm->origin,
				'dest' => $searchForm->destination,
				'fromDate' =>  $searchForm->departure_date,
				'returnDate' =>  $searchForm->arrival,
				'adult' =>  $searchForm->adults
			));
		}else{
			$this->session->set_userdata(array(
				'orig' => $searchForm->origin,
				'dest' => $searchForm->destination,
				'fromDate' =>  $searchForm->departure_date,
				'returnDate' =>  $searchForm->arrival,
				'adult' =>  $searchForm->adults
			));
		}
		$params = array(
			"fromAirport" => isset($iati_origin) ? $searchForm->origin : $searchForm->origin,
			"allinFromCity" => true,
			"toAirport" => isset($iati_destination) ? $searchForm->destination : $searchForm->destination,
			"fromDate" => $searchForm->departure_date,
			"returnDate" => $searchForm->arrival,
			"adult" => $searchForm->adults,
			"child" => $searchForm->children,
			"usePersonFares" => true,
			"getBaggageInfo" => true,
			"currency" => $this->session->userdata('currencycode')
		);
		$returnFlightsArray = array();
		$singleFlightsArray = array();
		if (self::CACHE_DATA) {
			$result = file_get_contents(APPPATH.'modules/Iati_flight/libraries/response/listing.json');
			$results = json_decode($result);
		} else {
			$results = $this->Iati_lib->getSearchResults($params);
		}

        dd($results);

        $this->data['searchId'] = $results->result->searchId;

		foreach($results->result->flights as $flight) { 

			if($flight->returnFlight){

				array_push($returnFlightsArray, $flight);

			}else{

				array_push($singleFlightsArray, $flight);

			}

		}



		$outboudCount = count($singleFlightsArray);

		$inboundCount = count($returnFlightsArray);

		

		$total_size = ($outboudCount < $inboundCount) ? $outboudCount : $inboundCount;

		$finalResult = array();



		if($check){	

			for($i = 0; $i < $total_size; $i++) {

				$tempArray = array();

				if(isset($singleFlightsArray[$i])) {

					array_push($tempArray, $singleFlightsArray[$i]);

				}

				if(isset($returnFlightsArray[$i])) {

					array_push($tempArray, $returnFlightsArray[$i]);

				}

				array_push($finalResult, $tempArray);

			}

		}else{

			$finalResult = $singleFlightsArray;

		}



		$this->data['isReturnFlight'] = isset($_GET['arrival']) ? true : false;

		$this->data['airline_logos'] = PT_AIRLINE_LOGOS;

		$this->data['iatiData'] = $finalResult;

		// echo "<pre>";print_r($finalResult);exit();

		$this->theme->view('modules/iati_flight/listing', $this->data['iatiData'], $this);

	}



	public function makeTicket(){

		$this->data['hideLang'] = "hide";

		$this->data['hideCurr'] = "hide";

		$this->data['hideHeader'] = "1";



		$this->data['airline_logos'] = PT_AIRLINE_LOGOS;



		$bookingData = $_POST['bookingData'];

		$searchId = $_POST['searchId'];

		$flight = json_decode($bookingData);



		$params = array(

				"searchId" => $searchId,

				"fareRefereces" => [

					array(

						"itineraryId" => $flight->id,

						"fareType" => "ECONOMY"

					)

				],

				"passengers" => [

					array(

						"type" => "ADULT",

						"count" => 1

					)

				],

				"cip" => false,

				"currency" => "USD"

		);



		$results = $this->Iati_lib->getPriceDetail($params);
		
		$this->data['flight'] = $flight;

		$this->data['priceDetailid'] = $results->result->id;
		$this->data['currency'] = $results->result->currency;
		$this->data['totalPrice'] = $results->result->totalPrice;
		$this->data['baseFare'] = $results->result->fares[0]->baseFare;
		$this->data['tax'] = $results->result->fares[0]->tax;
		$this->data['serviceFee'] = $results->result->fares[0]->serviceFee;
		$this->session->set_userdata('iati_flight_segment', json_encode($flight));
		$this->session->set_userdata('iati_flight', json_encode($_POST['flight']));
		
		$this->theme->view('modules/iati_flight/booking', $this->data, $this);
	}



	public function success(){

		$this->data['hideLang'] = "hide";

		$this->data['hideCurr'] = "hide";

		$this->data['hideHeader'] = "1";



		$params = array(
			"notes" => "TEST PNR CREATION",
			"priceDetailId" => $_POST['priceDetailid'],
			"cip" => "false",
			"contactInfo" => array(
				"email" => $_POST['email'],
				"phoneNumber" => $_POST['phoneNumber'],
				"mobilePhoneNumber" => $_POST['mobilePhoneNumber']
			),
			"passengers" => [
				array(
					"name" => $_POST['name'],
					"surname" => $_POST['surname'],
					"birthdate" => $_POST['birthdate'],
					"gender" => $_POST['gender'],
					"type" => $_POST['type'],
					"foid" => [
						"no" => "ABC123", 
						"citizenhipCountry" => "TR"
					]
				)
			],
			"returnEticket" => true,
			"returnError" => false 
		);

		$results = $this->Iati_lib->getMakeTicket($params);

		if(property_exists($results, 'error')) {
			echo 'ErrorCode: '.$results->error->errorCode.' Details: '.$results->error->details.' <br>';
			echo '<a href="'.base_url('flightsi').'">Back to List</a>';
			die();
		}

		// Save booking
		$pnr = $results->result->pnr;
		$dataAdapter = $this->db->get_where('pt_iati_bookings', ['pnr' => $pnr]);
		$id = 0;
		if($dataAdapter->num_rows() <= 0) {
			$segment = $this->session->userdata('iati_flight_segment');
			$iati_flight = $this->session->userdata('iati_flight');
			$this->db->insert('pt_iati_bookings', array(
				'user_id' => 0,
				'passengers' => json_encode($params['passengers']),
				'contact_info' => json_encode($params['contactInfo']),
				'base_fare' => $_POST['baseFare'],
				'tax' => $_POST['tax'],
				'service_fee' => $_POST['serviceFee'],
				'total_price' => $_POST['totalPrice'],
				'currency' => $_POST['currency'],
				'segment' => $segment,
				'iati_flight' => $iati_flight,
				'pnr' => $results->result->pnr,
				'order_id' => $results->result->orderId,
				'air_create_reservation_req' => json_encode($params),
				'air_create_reservation_resp' => json_encode($results),
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			));
			$id = $this->db->insert_id();
		} else {
			$id = $dataAdapter->row()->id;
		}
		$this->data['bookingResult'] = $results;
		$this->data['invoice'] = base_url('flightsi/invoice/'.$id);
		$this->theme->view('modules/iati_flight/success', $this->data, $this);
	}

	public function invoice($id)
	{
		$this->db->where('id', $id);
		$this->db->or_where('pnr', $id);
		$dataAdapter = $this->db->get('pt_iati_bookings');
		$invoice = $dataAdapter->row();
		$invoice->passengers = json_decode($invoice->passengers);
		$invoice->contact_info = json_decode($invoice->contact_info);
		$invoice->segment = json_decode($invoice->segment);
		$iati_flight = json_decode($invoice->iati_flight);
		$segments['outbound'] = array();
		$segments['inbound'] = array();
		foreach ($iati_flight as $index => $flight) 
		{
			$flight = json_decode($flight);
			if (! empty($flight)) 
			{
				if ($index == 0) {
					$segments['outbound'] = $flight;
				}
				elseif ($index == 1) {
					$segments['inbound'] = $flight;
				}
			}
		}
		$invoice->iati_flight = $segments;
		$this->data['invoice'] = $invoice;
		$this->theme->view('modules/iati_flight/invoice', $this->data, $this);
	}

	public function save_invoice()
	{
		$invoice_name = $this->input->post('invoice_name');
        $receivers = $this->input->post('receivers');
        $base64ImageString = $this->input->post('base64ImageString');
        
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64ImageString));
        $invoice_path = './uploads/images/iati_flight/' . $invoice_name;
        $save_ack = file_put_contents($invoice_path, $data); // Save invoice
        
        if ( ! empty($save_ack) )
        {   
			$this->load->library('email');
            $this->email->from($this->email->mail_fromemail, $this->email->site_title);
            $this->email->to($receivers);
            $this->email->subject('Flight Reservation Invoice');
            
            $message  = $this->email->mail_header;
            $message .= img('uploads/images/iati_flight/' . $invoice_name);
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

	public function index(){



		$set_date = date('Y-m-d');

		$from = date('Y-m-d', strtotime($set_date .' +1 day'));

		$to = date('Y-m-d', strtotime($set_date .' +2 day'));



		$params = array(

			"fromAirport" => $this->App->service("ModuleService")->get("iati_flight")->defaultSettings->from,

			"allinFromCity" => true,

			"toAirport" => $this->App->service("ModuleService")->get("iati_flight")->defaultSettings->to,

			"fromDate" => $from,

			"returnDate" => $to,

			"adult" => 1,

			"child" => 1,

			"usePersonFares" => true,

			"getBaggageInfo" => true,

			"currency" => $this->session->userdata('currencycode')

		);



		$this->session->set_userdata(array(

			'orig' => $this->App->service("ModuleService")->get("iati_flight")->defaultSettings->from,

			'dest' => $this->App->service("ModuleService")->get("iati_flight")->defaultSettings->to,

			'fromDate' =>  $from,

			'returnDate' =>  $to,

			'adult' =>  1

		));



		$returnFlightsArray = array();

		$singleFlightsArray = array();

		$results = $this->Iati_lib->getSearchResults($params);

		

		$this->data['searchId'] = $results->result->searchId;

		// echo "<pre>";print_r($results);exit();

		

		foreach($results->result->flights as $flight) { 

			if(!($flight->returnFlight)){

				array_push($singleFlightsArray, $flight);

			}

		}



		$this->data['airline_logos'] = PT_AIRLINE_LOGOS;

		$this->data['iatiData'] = $singleFlightsArray;

		

		// echo "<pre>";print_r($singleFlightsArray);exit();

		$this->theme->view('modules/iati_flight/listing', $this->data['iatiData'], $this);

	}



}