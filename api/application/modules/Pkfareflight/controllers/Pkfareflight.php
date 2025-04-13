<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
Class Pkfareflight extends MX_Controller{

    const Module = "Pkfareflight";
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
    $this->load->library('Pkfareflight_lib');

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
            $this->load->model('Pkfareflight/FlightsSearchModel');
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchmodel = new FlightsSearchModel();
        $searchmodel->parseUriString($segments);
        $this->session->set_userdata('Pkfareflight',serialize($searchmodel));
        $param = array(
            'origin' => ($this->uri->segment(3))?strtoupper($this->uri->segment(3)):"",
            'destination' => ($this->uri->segment(4))?strtoupper($this->uri->segment(4)):"",
            'triptypename' => $this->uri->segment(5)?$this->uri->segment(5):'oneway',
            'departureDate' => ($this->uri->segment(7))?$this->uri->segment(7):'',
            'adult' => intval($this->uri->segment(9)?$this->uri->segment(9):1),
            'mchildren' => intval($this->uri->segment(10)?$this->uri->segment(10):0),
            'minfant' => intval($this->uri->segment(11)?$this->uri->segment(11):0),
            'return_date'=> $return_date,
            'partner_id'=>$this->config->partner_id,
            'partner_key'=>$this->config->partner_key,
            'class_trip'=>$class
        );
        $resp = $this->Pkfareflight_lib->index($param);

       // file_put_contents(APPPATH.'response/pkflight2.json',json_encode($resp));
       //$resp = file_get_contents(FCPATH.'application/response/pkflight2.json');
        //dd($resp);
        $this->load->model('Pkfareflight/FlightsListingModel');
        $THF = new FlightsListingModel($resp);
        //dd($THF);
        $this->data['pageTitle'] = "Flights Results - From to ".$searchmodel->origin." to ".$searchmodel->destination;
        $this->data['search'] = $searchmodel;
        $this->data['appModule'] = 'Pkfareflight';
        $this->data['link'] = '';
        $this->data['orgin'] = $this->uri->segment(3);
        $this->data['des'] = $this->uri->segment(4);
        $this->data["sr"] = $THF;
        $this->data["action_url"] = $THF->action_url;
        $this->theme->view('modules/flights/listing', $this->data, $this);
    }

    /**
     *Listing page book now function for TravelPayoutFlightApi module
     * @return json
     */

    public function checkout()
    {
        $data['pageTitle'] = 'Booking';
        $this->theme->view('modules/flights/pkfare_flight/checkout', $data, $this);
    }
}