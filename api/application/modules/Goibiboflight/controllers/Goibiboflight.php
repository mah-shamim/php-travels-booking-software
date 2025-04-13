<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
Class Goibiboflight extends MX_Controller
{

    const Module = "Goibiboflight";
    private $config = [];

    public function __construct()
    {
        parent:: __construct();
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
        $this->load->library('Goibiboflight_lib');
        $this->load->model('Goibibo_model');

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
        if ($this->uri->segment(6) == 'economy') {
            $class = "Y";
        } else if ($this->uri->segment(6) == 'business') {
            $class = "C";
        } else {
            $class = "Y";
        }
        $args = explode('/', $this->uri->uri_string());
        $this->load->model('Goibiboflight/FlightsSearchModel');
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchmodel = new FlightsSearchModel();
        $searchmodel->parseUriString($segments);
        $this->session->set_userdata('Goibiboflight', serialize($searchmodel));
        $param = array(
            'origin' => ($this->uri->segment(3)) ? strtoupper($this->uri->segment(3)) : "",
            'destination' => ($this->uri->segment(4)) ? strtoupper($this->uri->segment(4)) : "",
            'triptypename' => $this->uri->segment(5) ? $this->uri->segment(5) : 'oneway',
            'departureDate' => ($this->uri->segment(7)) ? $this->uri->segment(7) : '',
            'adult' => intval($this->uri->segment(9) ? $this->uri->segment(9) : 1),
            'mchildren' => intval($this->uri->segment(10) ? $this->uri->segment(10) : 0),
            'minfant' => intval($this->uri->segment(11) ? $this->uri->segment(11) : 0),
            'return_date' => $return_date,
            'application_id' => $this->config->application_id,
            'application_key' => $this->config->application_key,
            'class_trip' => $class
        );
        $resp = $this->Goibiboflight_lib->index($param);
        // file_put_contents(APPPATH.'response/goflight1.json',json_encode($resp));
        //$resp = file_get_contents(FCPATH . 'application/response/goflight.json');
        // dd($resp);
        $this->load->model('Goibiboflight/FlightsListingModel');
        $THF = new FlightsListingModel($resp);
        $this->data['pageTitle'] = "Flights Results - From to " . $searchmodel->origin . " to " . $searchmodel->destination;
        $this->data['search'] = $searchmodel;
        $this->data['appModule'] = 'Goibiboflight';
        $this->data['link'] = '';
        $this->data['orgin'] = $this->uri->segment(3);
        $this->data['des'] = $this->uri->segment(4);
        $this->data["sr"] = $THF;
        $this->data["action_url"] = $THF->action_url;
        $this->theme->view('modules/flights/listing', $this->data, $this);
    }

    /**
     *Listing page book now function for Goibiboflight module
     * @return json
     */

    public function booking()
    {
        $data = $this->input->post();
        $data['pageTitle'] = 'Booking';
        $this->data['booking_data'] = $data;
        $this->data['countries'] = $this->Goibibo_model->countries();
        $this->theme->view('modules/flights/goibiboflight/booking', $data, $this);
    }

    /**
     *Booking page book now function for Goibiboflight module
     * @return json
     */
    public function invoice()
    {
        $madult = $this->input->post("madult", true);
        $madult_passenger = ($madult['passenger']) ? $madult['passenger'] : 0;
        $mchildren = $this->input->post("mchildren", true);
        $minfant = $this->input->post("minfant", true);
        $madult_total = ($madult['total']) ? $madult['total'] : 0;
        $mchildren_passenger = ($mchildren['passenger']) ? $mchildren['passenger'] : 0;
        $minfant_passenger = ($minfant['passenger']) ? $minfant['passenger'] : 0;

        $data = $this->input->post('booking_data', true);
        $params = array(
            'madult' => $madult_passenger,
            'mchildren' => $mchildren_passenger,
            'minfant' => $minfant_passenger,
            'currency' => $this->input->post("currency"),
            'totalPrice' => $madult_total,
            'firstname' => $this->input->post("firstname", true),
            'lastname' => $this->input->post("lastname", true),
            'email' => $this->input->post("email", true),
            'phone' => $this->input->post("phone", true),
            'address' => $this->input->post("address", true),
            'country' => $this->input->post("country", true),
            'note' => $this->input->post("additionalnotes", true),
            'carrier_code' => $data['carrier_code'][0],
            'iataCode_departure' => $data['iataCode_departure'][0],
            'iataCode_arrival' => $data['iataCode_arrival'][0],
            'departure_at' => $data['departure_at'][0],
            'arrival_at' => $data['arrival_at'][0],
            'created_on' => date("Y-m-d H:i:s"),
            'status' => 'pending',
        );
        $booking_id = $this->Goibibo_model->insert_booking($params);
        if ($booking_id > 0) {
            $this->load->library('email');
            $this->email->from($this->email->mail_fromemail, $this->email->site_title);
            $this->email->to($this->input->post("email"));
            $this->email->subject('Flight Booking Confirmation');

            $message = $this->email->mail_header;
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

}