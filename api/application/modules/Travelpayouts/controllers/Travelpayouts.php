<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Travelpayouts extends MX_Controller {
  function __construct() {
// $this->session->sess_destroy();
    parent::__construct();
    $this->data['lang_set'] = $this->session->userdata('set_lang');
      $chk = app()->service('ModuleService')->isActive('Travelpayouts');
      if ( ! $chk) {
          backError_404($this->data);
      }
    $this->data['phone'] = $this->load->get_var('phone');
    $this->data['contactemail'] = $this->load->get_var('contactemail');
    $defaultlang = pt_get_default_language();
    if (empty($this->data['lang_set'])) {
      $this->data['lang_set'] = $defaultlang;
    }
    $this->lang->load("front", $this->data['lang_set']);
  }
  public function index() {

        $settings = app()->service("ModuleService")->get('travelpayouts')->settings;
        $this->data['iframeID'] = $settings->iframeID;
        $this->setMetaData($settings->headerTitle);
        $loadheaderfooter = $settings->showHeaderFooter;
        $isMobile = $_GET['mobile'];
        $this->load->model('SearchModel');
        $this->data["search"] = new SearchModel();
        if ($loadheaderfooter == "no" || $isMobile == "yes") {
          $this->theme->partial('modules/travelpayouts/flight/index', $this->data);
        }
        else {
          $this->theme->view('modules/travelpayouts/flight/index', $this->data, $this);
        }
  }
    public function flight_results()
    {
        $segments = explode("/",uri_string());
        $this->load->model('Travelpayouts/FlightsSearchModel');
        unset($segments[0]);
        unset($segments[1]);
        $segments = array_merge($segments);
        $searchmodel = new FlightsSearchModel();
        $searchmodel->parseUriString($segments);
        $this->data["search"] = $searchmodel;
        $this->session->set_userdata('Travelpayouts',serialize($searchmodel));
        $this->theme->view('modules/flights/listing',$this->data,$this);
    }
  public function mobile(){
    $settings = app()->service("ModuleService")->get('travelpayouts')->settings;
    $this->data['WidgetURLMobile'] = $settings->WidgetURLMobile;
    $this->data['hidden'] = "hidden";
    $this->theme->view('modules/flights/travelpayouts/mobile', $this->data,$this);

  }
}
