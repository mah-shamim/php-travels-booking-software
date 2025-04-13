<?php
class AllFlights extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        modules::load('Front');
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }
        $this->lang->load("front", $this->data['lang_set']);

        $this->load->library('AllFlights/ApiClient');

    }

    function index(){
            $this->load->model('Flights/FlightsSearchModel');
            $searchForm = new FlightsSearchModel();
            $this->data['searchFormflights'] = $searchForm;
            $this->theme->view('modules/flights/index', $this->data, $this);
    }

    function search()
    {
            if ($this->uri->segment(5) == 'round') {
                $return_date = $this->uri->segment(8);
            } else {
                $return_date = "";
            }
            if ($this->uri->segment(6) == 'economy') {
                $class = "economy";
            } else if ($this->uri->segment(6) == 'business') {
                $class = "C";
            } else {
                $class = "economy";
            }

            $param = array(
                'origin' => ($this->uri->segment(3)) ? strtoupper($this->uri->segment(3)) : "",
                'destination' => ($this->uri->segment(4)) ? strtoupper($this->uri->segment(4)) : "",
                'triptypename' => $this->uri->segment(5) ? $this->uri->segment(5) : 'oneway',
                'departureDate' => date('Y-m-d', strtotime($this->uri->segment(7))),
                'adult' => intval($this->uri->segment(9) ? $this->uri->segment(9) : 1),
                'children' => intval($this->uri->segment(10) ? $this->uri->segment(10) : 0),
                'infant' => intval($this->uri->segment(11) ? $this->uri->segment(11) : 0),
                'return_date' => date('Y-m-d', strtotime($return_date)),
                'endpoint' => site_url()."api/Flight/search?appKey=phptravels",
                'class_trip' => $class,
                "currency_code" => "USD",
            );
            $flight = new ApiClient();
            $response = $flight->sendRequest('POST', 'search', $param);
            // dd($response);

        $this->load->model('Flights/FlightsSearchModel');
        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new FlightsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('flights',serialize($searchForm));

        $this->data['pageTitle'] = "Flights Results - From to ". $this->uri->segment(3) ."to ". $this->uri->segment(4) ;
        $this->data['search'] = $searchForm;
        $this->data['appModule'] = 'flights';
        $this->data['orgin'] = $this->uri->segment(3);
        $this->data['des'] = $this->uri->segment(4);
        $this->data["sr"] = json_decode($response);
        //dd($this->data["sr"]);
        $this->theme->view('modules/flights/listing', $this->data, $this);

    }
}