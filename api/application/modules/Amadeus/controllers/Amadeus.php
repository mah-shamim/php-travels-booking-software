<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');
class Amadeus extends MX_Controller 
{
    public $sandbox_mode = false;

    public function __construct()
    {
        parent::__construct();
        modules::load('Front');
        $chk = $this->App->service('ModuleService')->isActive('amadeus');
        if (!$chk) { Error_404($this); }
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }
        $this->lang->load("front", $this->data['lang_set']);
        $this->data['hideLang'] = "show";
        $this->data['hideCurr'] = "";
        $this->data['appModule'] = 'amadeus';
        $this->load->module("Amadeus");
        $this->load->model('Amadeus/Amadeus_model');
        $this->load->model('Amadeus/FlightsSearchModel');
        $this->load->library('Amadeus_lib');
        $this->data['search_form'] = ('');
        $this->load->helper("all");
        $this->load->library('Hotels/Hotels_lib');

    }

    public function index()
    {
        $segments = explode("/",uri_string());
        $this->load->model('Amadeus/FlightsSearchModel');
        unset($segments[0]);
        unset($segments[1]);
        $segments = array_merge($segments);
        $searchmodel = new FlightsSearchModel();
        $searchmodel->parseUriString($segments);
        $this->session->set_userdata('Amadeus',serialize($searchmodel));
        $this->data['moduleSetting'] = $this->App->service("ModuleService")->get("Amadeus");
        if(!empty($this->session->userdata("currencycode"))){
            $currency_code = $this->session->userdata("currencycode");
        }else{
            $currency_code = $this->Hotels_lib->currencycode;
        }
        $param = array(
            'origin' => ($searchmodel->origin)?strtoupper($searchmodel->origin):"",
            'destination' => ($searchmodel->destination)?strtoupper($searchmodel->destination):"",
            'departureDate' => ($searchmodel->departure_date)?date("Y-m-d",strtotime($searchmodel->departure_date)):date('Y-m-d'),
            'totalpassengers' => intval($searchmodel->adults + $searchmodel->children + $searchmodel->infants),
            'madult' => intval($searchmodel->adults?$searchmodel->adults:1),
            'mchildren' => intval($searchmodel->children?$searchmodel->children:0),
            'minfant' => intval($searchmodel->infants?$searchmodel->infants:0),
            'seniors' => intval(0),
            'class_type' => strtoupper($searchmodel->classType?$searchmodel->classType:'economy'),
            'triptypename' => $searchmodel->tripType?$searchmodel->tripType:'oneway',
            'nonStop' => 'true',
            'currency' => $currency_code,
            'currencysymbol' => $this->session->userdata("currencysymbol"),
            'commission' => $this->data['moduleSetting']->apiConfig->commission,
            'return_date'=> $searchmodel->reture_date
        );
        $data_from_library = $this->Amadeus_lib->index($param);
        $this->load->model('AmadeusResponse');
        $AMS = new AmadeusResponse($data_from_library);
        $this->data['pageTitle'] = "Search Results - From ".$searchmodel->origin." to ".$searchmodel->destination;
        $this->data['search'] = $searchmodel;
        $this->data["sr"] = $AMS;
          $this->theme->view('modules/flights/listing',$this->data,$this);
    }

    public function airport_data(){
        $search = $this->input->get('q');
        $airport_data = $this->Amadeus_model->get_airport($search);
        $json = [];
        foreach ($airport_data as $code) {
            $json[] = ['id'=>$code['code'], 'text'=> $code['cityName']." - ".$code['name']. " (".$code['code'].")" ];
        }
        echo json_encode($json);
    }

    public function airlines(){
        $search = $this->input->get('q');
        $airport_data = $this->Amadeus_model->get_airline($search);
        $json = [];
        foreach ($airport_data as $code) {
            $json[] = ['id'=>$code['iata'], 'text'=> $code['airline']." (".$code['iata'].")" ];
        }
        echo json_encode($json);
    }

    public function booking(){
        $this->data['pageTitle'] = "Booking";
        $data = $this->input->post();
        if (empty($data)) {
            redirect(site_url('airlines'));
        } elseif(empty($data['flight_offers'])){
            redirect(site_url('airlines'));
        } else {
            $this->data['booking_data'] = $data;
            $this->data['countries'] = $this->Amadeus_model->countries();
            $this->theme->view('modules/flights/amadeus/booking',$this->data,$this);
        }
    }

    public function invoice(){
        $madult = $this->input->post("madult",true);
        $mchildren = $this->input->post("mchildren",true);
        $minfant = $this->input->post("minfant",true);
        $seniors = $this->input->post("seniors",true);
        $madult_passenger = ($madult['passenger'])?$madult['passenger']:0;
        $madult_total = ($madult['total'])?$madult['total']:0;
        $madult_tax = ($madult['totalTaxes'])?$madult['totalTaxes']:0;    
        $mchildren_passenger = ($mchildren['passenger'])?$mchildren['passenger']:0;
        $mchildren_total = ($mchildren['total'])?$mchildren['total']:0;
        $mchildren_tax = ($mchildren['totalTaxes'])?$mchildren['totalTaxes']:0;    
        $minfant_passenger = ($minfant['passenger'])?$minfant['passenger']:0;
        $minfant_total = ($minfant['total'])?$minfant['total']:0;
        $minfant_tax = ($minfant['totalTaxes'])?$minfant['totalTaxes']:0;    
        $seniors_passenger = ($seniors['passenger'])?$seniors['passenger']:0;
        $seniors_total = ($seniors['total'])?$seniors['total']:0;
        $seniors_tax = ($seniors['totalTaxes'])?$seniors['totalTaxes']:0;    

        $params  = array(
            'madult'=> $madult_passenger,
            'madult_price'=> $madult_total,
            'madult_tax'=>$madult_tax,
            'mchildren'=>$mchildren_passenger,
            'mchildren_price'=>$mchildren_total,
            'mchildren_tax'=>$mchildren_tax,
            'minfant'=>$minfant_passenger,
            'minfant_price'=>$minfant_total,
            'minfant_tax'=>$minfant_tax,
            'seniors'=>$seniors_passenger,
            'seniors_price'=>$seniors_total,
            'seniors_tax'=>$seniors_tax, 
            'currency' => $this->input->post("currency"),
            'totalTaxes' => $this->input->post("totalTaxes",true),
            'totalPrice' => $this->input->post("totalPrice",true),
            'commission'=>($this->input->post("total_with_commission",true))-($this->input->post("totalPrice",true)),
            'total_with_commission' => $this->input->post("total_with_commission",true),
            'total_amount_with_tax' => $this->input->post("total_amount_with_tax",true),
            'firstname' => clean($this->input->post("firstname",true)),
            'lastname' => clean($this->input->post("lastname",true)),
            'email' => clean($this->input->post("email",true)),
            'phone' => clean($this->input->post("phone",true)),
            'address' => clean($this->input->post("address",true)),
            'country' => clean($this->input->post("country",true)),
            'note' => clean($this->input->post("additionalnotes",true)),
            'created_on' => date("Y-m-d H:i:s")
        );
        $booking_id = $this->Amadeus_model->insert_booking($params);
        if ($booking_id > 0) {
            $booking_data = $this->input->post("booking_data");
            $count = count($booking_data['carrier_code']);
            for ($i=0; $i < $count ; $i++) {
                $flight_segment = array(
                    'booking_id'=> $booking_id,
                    'carrier_code' => $booking_data['carrier_code'][$i],
                    'iataCode_departure'=> $booking_data['iataCode_departure'][$i],
                    'iataCode_arrival'=> $booking_data['iataCode_arrival'][$i],
                    'departure_at'=> date("Y-m-d H:i:s", strtotime($booking_data['departure_at'][$i])),
                    'arrival_at'=>date("Y-m-d H:i:s", strtotime($booking_data['arrival_at'][$i])),
                    'create_on'=> date('Y-m-d H:i:s')
                );  
                $this->Amadeus_model->insert_flight_data($flight_segment);
            }
            $data['email'] = $this->input->post();
            $this->load->library('email');
            $this->email->from($this->email->mail_fromemail, $this->email->site_title);
            $this->email->to(clean($this->input->post("email")));
            $this->email->subject('Flight Booking Confirmation');

            $message  = $this->email->mail_header;
            // $message .= $this->load->view('email',$data,true);
            $message .= $this->email->mail_footer;
            $this->email->message($message);
            //$this->email->send();
            $status = array('status' => 1);
        } else {
            $status = array('status' => 0);
        }
        echo json_encode($status);
    }
    
    function redirect(){
        redirect(site_url("airlines"));
    }
}
