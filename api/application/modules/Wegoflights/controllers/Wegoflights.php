<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WegoFlights extends MX_Controller {


  function __construct(){
  // $this->session->sess_destroy();
  parent::__construct();
  $this->data['lang_set'] = $this->session->userdata('set_lang');
  $chk = modules::run('Home/is_main_module_enabled','wegoflights');
  if(!$chk){
  Error_404($this);
  }
  $this->data['phone'] = $this->load->get_var('phone');
  $this->data['contactemail'] = $this->load->get_var('contactemail');
  $defaultlang = pt_get_default_language();
  if(empty($this->data['lang_set'])){
  $this->data['lang_set'] = $defaultlang;
  }
  $this->lang->load("front",$this->data['lang_set']);
  }
  public function index()
  {
  $settings =  app()->service("ModuleService")->get('wegoflights')->settings;
  $this->data['url'] = $settings->url;
  $this->data['aid'] = $settings->aid;
  $this->data['brandID'] = $settings->brandID;
  $this->setMetaData($settings->headerTitle);
  $this->data['searchBoxID'] = $settings->searchBoxID;
  $loadheaderfooter = $settings->showHeaderFooter;
  if($loadheaderfooter == "no"){
  $this->theme->partial('modules/flights/wegoflights/index',$this->data);
  }else{
  $this->theme->view('modules/flights/wegoflights/index',$this->data, $this);
  }
  }

  public function flight_results()
  {

      $segments = explode("/",uri_string());
      $this->load->model('Wegoflights/FlightsSearchModel');
      unset($segments[0]);
      unset($segments[1]);
      $segments = array_merge($segments);
      $searchmodel = new FlightsSearchModel();
      $searchmodel->parseUriString($segments);
      $this->data["search"] = $searchmodel;
      $this->session->set_userdata('Wegoflights',serialize($searchmodel));

      $this->theme->view('modules/flights/listing',$this->data,$this);
  }

  }
