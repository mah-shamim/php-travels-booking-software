<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
Class Travelpayoutsflightapi extends MX_Controller{

    const Module = "TravelPayoutsFlightsAPI";
    private $config = [];
    public function __construct()
    {
    parent :: __construct();
    $chk = $this->App->service('ModuleService')->isActive(self::Module);
    if (!$chk) {
    Error_404($this);
    }
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

    $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;
    $this->load->model("Admin/Emails_model");
    $this->load->library('Travelpayoutsflightapi_lib');
    $this->load->model('TravelPayoutsFlightsAPI/TravelPayoutsFlights_model');
    $this->load->model('TravelPayoutsFlights_model');
    }

    /**
    *Homepage search form listing function for TravelPayoutFlightApi module
    * @return json
    */
    public function search()
    {
    if ($this->uri->segment(5) == 'round') {
    $return_date = $this->uri->segment(8);
    } else {
    $return_date = "";
    }
    if($this->uri->segment(6) == 'economy'){
    $class="Y";
    }else if($this->uri->segment(6) == 'business'){
    $class="C";
    }else{
    $class="Y";
    }
    $args = explode('/',  $this->uri->uri_string());
    $this->load->model('TravelPayoutsFlightsAPI/FlightsSearchModel');
    unset($args[0]);
    unset($args[1]);
    $segments = array_merge($args);
    $searchmodel = new FlightsSearchModel();
    $searchmodel->parseUriString($segments);
    $this->session->set_userdata('TravelPayoutsFlightsAPI',serialize($searchmodel));
    $param = array(
    'origin' => ($this->uri->segment(3))?strtoupper($this->uri->segment(3)):"",
    'destination' => ($this->uri->segment(4))?strtoupper($this->uri->segment(4)):"",
    'triptypename' => $this->uri->segment(5)?$this->uri->segment(5):'oneway',
    'departureDate' => ($this->uri->segment(7))?$this->uri->segment(7):'',
    'adult' => intval($this->uri->segment(9)?$this->uri->segment(9):1),
    'mchildren' => intval($this->uri->segment(10)?$this->uri->segment(10):0),
    'minfant' => intval($this->uri->segment(11)?$this->uri->segment(11):0),
    'return_date'=> $return_date,
    'api_endpoint'=>$this->config->api_endpoint,
    'marker_id'=>$this->config->marker_id,
    'token'=>$this->config->api_token,
    'class_trip'=>$class
    );

    $resp = $this->Travelpayoutsflightapi_lib->index($param);
      //  dd($resp);
    $this->load->model('TravelPayoutsFlightsAPI/FlightsListingModel');
    $TPFA = new FlightsListingModel($resp);
   $pric = $TPFA->final_array[0]['segments'][0][0];


    if(!empty($TPFA->final_array) && $pric->price !='0') {
        $this->data['pageTitle'] = "Flights Results - From to ".$searchmodel->origin." to ".$searchmodel->destination;
        $this->data['search'] = $searchmodel;
        $this->data['appModule'] = 'TravelPayoutsFlightsAPI';
        $this->data['action_url'] = $TPFA->action_url;
        $this->data['form_name'] = $TPFA->form_name;
        $this->data['orgin'] = $this->uri->segment(3);
        $this->data['des'] = $this->uri->segment(4);
        $this->data["sr"] = $TPFA;
        $this->theme->view('modules/flights/listing', $this->data, $this);
    }else{
        $this->search();
    }
    }

    /**
     *Listing page book now function for TravelPayoutFlightApi module
     * @return json
     */
    public function booking(){
        $userid = $this->session->userdata('pt_logged_customer');
        if(empty($userid)){
            $user_id = 0;
        }else{
            $user_id = $userid;
        }
        $departure_date = $this->input->post('departure_date');
        $price = $this->input->post('price');
        $currency_code = $this->input->post('currency_code');
        $url_id = $this->input->post('url');
        $form_city = $this->input->post('form_city');
        $to_city = $this->input->post('to_city');

        if($this->config->api_environment == 'sandbox'){
            $token = 'ddb8dddd-7bda-4db6-ab8e-1be7c177fa1d';
        }else{
            $token = $this->config->api_token;
        }
        $url = 'http://misc.travelpayouts.com/flights/redirect/'.$url_id;
        $data = array(
            'price'=>$price,
            'url'=>$url,
            'currency'=>$currency_code,
            'date'=>$departure_date,
            'user_id'=>$user_id,
            'form_city'=>$form_city,
            'to_city'=>$to_city
        );
        $this->TravelPayoutsFlights_model->travelpayoutflightapi_booking($data);
        echo json_encode(array("msg"=>$url ,'status'=>1));
    }

}