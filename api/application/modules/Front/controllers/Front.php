<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
  class Front extends MX_Controller {
  public $frontdata = array();
  function __construct() {
    $theme = @ $_GET['theme'];
    $this->restrictedAccess();
    // $lang = @ $_GET['lang'];
    // if (!empty ($lang)) {
    // 		set_language($lang);
    // }
    $themepreview = $this->session->userdata('pt_theme_preview');
    if (!empty($theme)) {
      $this->session->set_userdata('pt_theme_preview', $theme);
      $this->theme->set_theme($theme);
      redirect(current_url());
    }
    if (!empty($themepreview)) {
      $this->theme->set_theme($themepreview);
    }
    parent::__construct();
    $this->load->model('Admin/Cms_model');
    $this->load->model('Admin/Modules_model');
    $this->load->helper('settings');
    $this->load->helper('text');
    $res = $this->Settings_model->get_contact_page_details();
    $this->frontdata['phone'] = $res[0]->contact_phone;
    $this->frontdata['contactemail'] = $res[0]->contact_email;
//$this->__bookings_expired();
    $this->__visitors_count($this->input->ip_address());
    $this->load->vars($this->frontdata);
   // $this->__modulecheck();
  }
  function __bookings_expired() {
    $this->db->select('booking_id');
    $this->db->where('booking_expiry <', time());
    $this->db->where('booking_status', 'unpaid');
    $bookings = $this->db->get('pt_bookings')->result();
    foreach ($bookings as $b) {
      $this->db->where('booked_booking_id', $b->booking_id);
      $this->db->delete('pt_booked_rooms');
      $this->db->where('booking_id', $b->booking_id);
      $this->db->delete('pt_bookings');
    }
  }
//  function __modulecheck() {
//    $mods = array("Hotels", "Tours", "Cars", "Flights", "Blog", "Ean", "Tripadvisor", "Cartrawler");
//    $modlist = $this->ptmodules->allmoduleslist;
//    foreach ($mods as $m) {
//      if (!in_array($m, $modlist)) {
//        $this->__update_module_status($m);
//      }
//    }
//  }
//  function __update_module_status($m) {
//    $data = array('page_header_menu' => '0', 'page_status' => 'No');
//    $this->db->where("page_slug", $m);
//    $this->db->update("pt_cms", $data);
//  }
  function __visitors_count($ip) {
    $currMonth = date("m");
   //$currYear = date("Y");
   //$totalDays = cal_days_in_month(CAL_GREGORIAN, $currMonth, $currYear);
   /*
   start update json file for visits
   */
    // $fileData = json_decode(file_get_contents("application/json/visits.json"));
    // $f = (object) $fileData;
    $fileData = $this->db->select('data_object')->get('visitors')->row()->data_object;
    $f = json_decode($fileData);
    $ipAdress = $_SERVER['REMOTE_ADDR'];
    $currentDay = date('d');
    if ($currentDay < 10) {
      $day = str_replace("0", "", $currentDay) - 1;
    }
    else {
      $day = $currentDay - 1;
    }
    $totalCount = count($f->days);
    if ($totalCount < $day) {
      for ($i = 1; $i <= $day; $i++) {
        $addOldVisit = new stdClass;
        $addOldVisit->unique = 0;
        $addOldVisit->hits = 0;
        $addOldVisit->ip = array();
        array_push($f->days, $addOldVisit);
      }
    }
    else {
      if (empty($f->days[$day]->hits)) {
        $addVisit = new stdClass;
        $addVisit->unique = 1;
        $addVisit->hits = 1;
        $addVisit->ip = array($ipAdress);
        array_push($f->days, $addVisit);
      }
      else {
        $f->days[$day]->hits++;
        if (!in_array($ipAdress, $f->days[$day]->ip)) {
          $f->days[$day]->unique++;
          $f->days[$day]->ip[] = $ipAdress;
        }
      }
    }
    if ($f->currMonth != $currMonth) {
      $f->days = array();
      $f->currMonth = $currMonth;
    }
    // file_put_contents("application/json/visits.json", json_encode($f, JSON_PRETTY_PRINT));
    $this->db->set('data_object', json_encode($f, JSON_PRETTY_PRINT));
    $this->db->update('visitors');
    /*
    end update json file for visits
    */
  }
  function restrictedAccess() {
    $settingsData = $this->Settings_model->get_settings_data();
    $restricted = $settingsData[0]->restrict_website;
    $url = $this->uri->segment(1);
    if ($restricted == "Yes") {
      $allwedUrl = array("login", "register", "supplier-register", "account");
      $userLogged = $this->session->userdata('pt_logged_customer');
      $roleLogged = $this->session->userdata('pt_role');
      if (empty($userLogged) && empty($roleLogged)) {
        if (!in_array($url, $allwedUrl)) {
          redirect(base_url() . 'login');
        }
      }
    }
  }
}