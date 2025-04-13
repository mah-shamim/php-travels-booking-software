<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/**
* Travelport Invoice
*
* @category Frontend
*/
class Invoice extends MX_Controller {
  public function __construct() {
    parent::__construct();
    $chk = modules::run('Home/is_main_module_enabled', 'travelport_flight');
    if (!$chk) {
      Module_404();
    }
// For contact detail display in header.
    $this->data['phone'] = $this->load->get_var('phone');
    $this->data['contactemail'] = $this->load->get_var('contactemail');
    $this->data['usersession'] = $this->session->userdata('pt_logged_customer');
    $this->data['appModule'] = "travelport_flight";
    $languageid = $this->uri->segment(2);
    $this->validlang = pt_isValid_language($languageid);
    if ($this->validlang) {
      $this->data['lang_set'] = $languageid;
    }
    else {
      $this->data['lang_set'] = $this->session->userdata('set_lang');
    }
    $defaultlang = pt_get_default_language();
    if (empty($this->data['lang_set'])) {
      $this->data['lang_set'] = $defaultlang;
    }
// For menu `HOME` and `My Account` link in header.
    $this->lang->load("front", $this->data['lang_set']);
  }
/**
* Invoice page
*
* @return json
*/
  public function index() {
    $this->load->model('TravelportModel_Cart');
    $cart = new TravelportModel_Cart();
    $PNR = $this->input->get('token', TRUE);
    $this->data['pageTitle'] = 'Flight Invoice';
    $this->data['message'] = NULL;
    $this->data['dataAdapter'] = $cart->get_invoice($PNR);
    $this->data['invoice_access_token'] = $PNR;
    $this->theme->view('modules/travelport/flight/invoice', $this->data, $this, FALSE);
  }
  
}