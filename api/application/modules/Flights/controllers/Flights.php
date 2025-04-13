<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Flights extends MX_Controller {

    public function __construct() 
	{
		parent :: __construct();

		$chk = modules::run('Home/is_main_module_enabled', 'flights');

		if ( ! $chk ) { Module_404(); }

		// For contact detail display in header.
		$this->data['phone'] = $this->load->get_var('phone');
		$this->data['contactemail'] = $this->load->get_var('contactemail');

		$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
		$this->data['appModule'] = "flights";
        $this->load->library('Flights/Flights_lib');
        $this->data['flight_lib'] = $this->Flights_lib;

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

		$this->data['pageTitle'] = "Flights List";
        $this->load->model('Flights/FlightsSearchModel');
    }

    public function index()
    {
        $this->theme->view('modules/flights/standard/listing', $this->data, $this);

    }
    public function search()
    {
        $this->load->model('Flights/Flights_model');

        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new FlightsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('flights',serialize($searchForm));

        $uri = $this->uri->uri_string();
        $payload = explode("/", $uri);
        if(!empty($searchForm->arrival)){
            $arr = $searchForm->arrival;
        }else{
            $arr = 0;
        }
        $params = array(
            $payload[0],
            $searchForm->origin,
            $searchForm->destination,
            $searchForm->departure_date,
            $arr,
            $searchForm->tripType,
            $searchForm->classType,
            $searchForm->adults,
            $searchForm->children,
            $searchForm->infant,
        );

        if(($uri != "flights" ) && ($payload[1] != "0")) {
            $payload = explode("/", $uri);
            if ($this->input->get('p')) {
                $page = $this->input->get('p');
            } else {
                $page = 1;
            }
            $result = $this->Flights_model->get_route($params,0,0,app()->service("ModuleService")->get('flights')->test);
            if(empty($result) && app()->service("ModuleService")->get('flights')->test == "true")
            {
                $result = $this->Flights_model->get_route($params,0,0,app()->service("ModuleService")->get('flights')->test);

            }
            $this->load->library('pagination');
            $config['base_url'] = base_url().implode("/",$params);
            $config['total_rows'] = count($result);
            $config['use_page_numbers'] = TRUE;

            if($params[5] == "round") {
                $config['per_page'] = 20*2;
            }
            else {
                $config['per_page'] = 20;
            }

            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] ="</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";

            $config["uri_segment"] = 14;
            $config['page_query_string'] = true;
            $config['query_string_segment'] = 'p';

            $config['attributes'] = array('class' => 'page-link');
            $this->pagination->initialize($config);
            $limit = $config['per_page'];

            $offset = ($page-1) *$limit;
            $str_links = $this->pagination->create_links();
            $str_links =  str_replace("&amp;","?",$str_links);
            $data["links"] =  explode('&nbsp;',$str_links );

            $data['result'] = $this->Flights_model->get_route($params, $limit, $offset,app()->service("ModuleService")->get('flights')->test);
            $dataset = $this->Flights_model->get_airlines($params,app()->service("ModuleService")->get('flights')->test);


        }else{

            if(count($params) == 1) {
                $payload = ["flights",0,0,0,0,0,0,1,0,0,0,0,0];
            }
            $data["links"] = $this->pagination->create_links();
            $data["links"] =  str_replace("&amp;","?",$data["links"]);
            $dataset = $this->Flights_model->get_airlines_all($payload,app()->service("ModuleService")->get('flights')->test);
            $data['result'] = $this->Flights_model->get_route_all($payload,app()->service("ModuleService")->get('flights')->test);

        }
        $Airlines = [];
            $carriers = [];
            for($i = 13; $i<=count($params);$i++)
            {
                array_push($carriers,str_replace('-',' ',$payload[$i]));
            }

            foreach ($dataset as &$res)
            {
                $res = (array) $res;
                if(in_array($res['name'], $carriers)) {
                    $res['check'] = true;
                } else {
                    $res['check'] = false;
                }
                $res = (object) $res;
                array_push($Airlines, $res);
            }
        $this->load->model('FlightsListingModel');
        $THF = new FlightsListingModel($data['result']);
        $data['airlines'] = $Airlines;
            $data['payload'] = $params;
        $this->data['search'] = $searchForm;
        $this->data["sr"] = $THF;
        $this->theme->view('modules/flights/listing', $this->data, $this);


    }

    function book() {

        $payload = array(
            $this->input->post('tripType'),
            $this->input->post('setting_id'),
            $this->input->post('adults'),
            $this->input->post('children'),
            $this->input->post('infant'),
        );
       // dd($payload);
        $this->load->model('Flights/Flights_model');
        $this->load->model('Admin/Countries_model');
        $this->data['allcountries'] = $this->Countries_model->get_all_countries();
        $this->load->library("Paymentgateways");
        $this->data['hideHeader'] = "1";
        $this->load->model('Admin/Payments_model');
        $result = $this->Flights_model->get_aeroimg(str_replace("-"," ",$payload[4]));
        $tax = $this->Flights_model->get_taxdeposite($payload[1]);

        $price = 0;
        foreach ($tax as $res)
        {
            $price  = $price + ($res->adults_price * $payload[2])+ ($res->child_price * $payload[3]) + ($res->infants_price * $payload[4]);
        }
        $date_time = array();
        foreach ($tax as $index=>$res)
        {
            $date_time_temp = array();
            $trans_locations = json_decode($res->transact);
            if($res->date_departure == "0000-00-00"){
             $date_departure = date("Y-m-d");
            }else{
                $date_departure = $res->date_departure;
            }
            $from_object = (object)["from_code"=>$res->from_code,"date"=>$date_departure,"time"=>$res->time_departure];
            array_push($date_time_temp,$from_object);

            for($j=0;$j<count($trans_locations);$j++)
            {
                    $date = json_decode($res->date_trans)[$j];
                    if (empty($date)) {
                        $date = date("Y-m-d", strtotime(($j + 1) . " day", strtotime(date('Y-m-d'))));
                    }
                    $from_object = (object)["from_code" => json_decode($trans_locations[$j])->code, "date" => $date, "time" => json_decode($res->time_trans)[$j]];
                    array_push($date_time_temp, $from_object);
            }
            if($res->date_arrival == "0000-00-00"){
                $date = date("Y-m-d",strtotime((count($trans_locations)+1)." day", strtotime(date("Y-m-d"))));
            }else{
                $date = $res->date_arrival;
            }
            $from_object = (object)["from_code"=>$res->to_code,"date"=>$date,"time"=>$res->time_departure];
            array_push($date_time_temp,$from_object);

            $date_time[$index] = $date_time_temp;
        }
        $this->data["date_time"] = $date_time_temp;
        //dd($this->data["date_time"]);

        $price = $this->Flights_lib->convertAmount($price);
        $taxpay = $tax[0]->tax/100;
        $depositepay = $tax[0]->deposite/100;
        $result->tax = $taxpay*$price;
        $result->deposite = $depositepay*($price+$result->tax);
        $result->total_price = $price+$result->tax;
        $result->adults = $price;
        $result->id = $payload[3];
        $this->data["module"] = $result;
        $this->data["tax"] = $tax;
        $this->data['setting_id'] = $payload[1];
       // dd($this->data["tax"] );
        $this->data["payload"] = $payload;
        $this->load->model('Admin/Accounts_model');
        $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer');
        $this->lang->load("front", $this->data['lang_set']);
        $this->data['profile'] = $this->Accounts_model->get_profile_details($loggedin);
        $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);
        $this->theme->view('modules/flights/booking', $this->data, $this);

    }

}