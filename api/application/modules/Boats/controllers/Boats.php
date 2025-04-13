<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Boats extends MX_Controller {

    private $validlang;

    function __construct() {

// $this->session->sess_destroy();

        parent::__construct();

        $chk = modules::run('Home/is_main_module_enabled', 'Boats');

        if (!$chk) {
            Module_404();
        }

        $this->load->model('Admin/Accounts_model');
        $this->load->model('Admin/Emails_model');
        // $this->load->model('Viator/Viator');
        $this->data['app_settings'] = $this->Settings_model->get_settings_data();
        $this->load->helper('invoice');

        $this->load->library("Boats_lib");

        $this->load->model("Boats_model");

        $this->load->helper("boats_front");

        $this->data['usersession'] = $userid = $this->session->userdata('pt_logged_customer');

        $this->data['modulelib'] = $this->Boats_lib;

        $this->data['appModule'] = "boats";

        $this->data['phone'] = $this->load->get_var('phone');

        $this->data['contactemail'] = $this->load->get_var('contactemail');

        $languageid = $this->uri->segment(2);

        $this->validlang = pt_isValid_language($languageid);

        if ($this->validlang) {
            $this->data['lang_set'] = $languageid;
        } else {

            $this->data['lang_set'] = $this->session->userdata('set_lang');
        }

        $defaultlang = pt_get_default_language();

        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }

        $this->Boats_lib->set_lang($this->data['lang_set']);

        $this->data['locationsList'] = $this->Boats_lib->getLocationsList();

        $this->data['selectedAdults'] = $this->Boats_lib->adults;

        $this->data['selectedChild'] = $this->Boats_lib->child;

        $this->data['selectedInfants'] = $this->Boats_lib->infants;

        // default search field data list.
        $this->data['defaultboatsListForSearchField'] = $this->Boats_lib->getDefaultboatsListForSearchField();
    }

    public function index() {

        $settings = $this->Settings_model->get_front_settings('boats');

        $this->data['minprice'] = $settings[0]->front_search_min_price;

        $this->data['maxprice'] = $settings[0]->front_search_max_price;

        $this->data['loadMap'] = TRUE;

        if ($this->validlang) {
            //$countryName = $this->uri->segment(3);

            //$cityName = $this->uri->segment(4);

            $boatslug = $this->uri->segment(5);
        } else {

            // $countryName = $this->uri->segment(2);

            // $cityName = $this->uri->segment(3);

            $boatslug = $this->uri->segment(4);
        }

        $check = $this->Boats_model->boat_exists($boatslug);



        if ($check && !empty($boatslug)) {
            $this->lang->load("front", $this->data['lang_set']);

            $this->Boats_lib->set_boatid($boatslug);

            $this->data['module'] = $this->Boats_lib->boat_details();
             $this->data['packages'] = $this->Boats_model->getpackages($this->data['module']->id);
             foreach ($this->data['packages'] as &$dates){
                 if($dates->fix_dates  == "yes"){
                     $date1 = new DateTime($dates->start_date);
                     $date2 = new DateTime($dates->end_date);
                     $current_date = date('Y-m-d')."";
                     $current_date =  DateTime::createFromFormat('Y-m-d', $current_date);
                     $interval = $date1->diff($date2);

                     $dates->stay = $interval->days;
                     if($date1 <  $current_date){
                         $dates->status = false;
                     }else{
                         $dates->status = true;
                     }
                 }else{
                     $start_date  = $this->getDays($dates->from_day);
                     $end_date  = $this->getDays($dates->to_day);
                     $dates->stay =   ($end_date - $start_date) + 1;
                     $dates->status = true;

                 }
             }


            $this->data['moduleTypes'] = $this->Boats_lib->boatTypes();

            if (pt_is_module_enabled('reviews')) {
                $this->data['reviews'] = $this->Boats_lib->boatReviews($this->data['module']->id);

                $this->data['avgReviews'] = $this->Boats_lib->boatReviewsAvg($this->data['module']->id);
            }



            $this->data['checkin'] = $this->Boats_lib->date;

            $this->data['adults'] = $this->Boats_lib->adults;

            $this->data['child'] = (int) $this->Boats_lib->child;

            $this->data['checkinMonth'] = strtoupper(date("F", convert_to_unix($this->Boats_lib->date)));

            $this->data['checkinDay'] = date("d", convert_to_unix($this->Boats_lib->date));

            //$this->data['checkoutMonth'] = strtoupper(date("F",convert_to_unix($this->Boats_lib->checkout)));

            //$this->data['checkoutDay'] = date("d",convert_to_unix($this->Boats_lib->checkout));

            $this->data['langurl'] = base_url() . "boats/{langid}/" . $this->data['module']->slug;

            $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);

            $this->theme->view('modules/boats/details', $this->data, $this);
        } else {

            $this->listing();
        }
    }

    public function send_enquery(){

    }
    public function do_boats_booking($payload = array())
    {
        $this->load->library('currconverter');
        $this->load->library('Boats/Boats_model');
        $itemid_package  = $payload['package_id'];
        $itemid = $payload["itemid_package"];
        $child   =  "0";
        $infant  = "0";


        $bookingData = $this->Boats_model->getPackage($itemid_package);
        $adults = $bookingData->travelers;

        $subitem = (object)array(
            'adults'=>(object)array(
                "count"=>$adults
            )
        );

        if($bookingData->fix_dates == 'yes'){
            $checkin = $bookingData->start_date;
            $checkout = $bookingData->end_date;
        }else{
            $checkin = $bookingData->from_day;
            $checkout = $bookingData->to_day;
        }
        // $grandtotal = $this->currconverter->convertPriceFloat($bookingData->grandTotal);
        $grandtotal = $bookingData->price;
        //$deposit = $this->currconverter->convertPriceFloat($bookingData->depositAmount);
        $extrabeds      = 0;
        $deposit = 0;
        $tax = 0;
        $paymethodfee = 0;

        //$this->currconverter->convertPriceFloat($bookingData->paymethodFee);
        $extrasTotalFee = "0";
        $currCode = "USD";
        $currSymbol = "";
        $extras = NULL;

        $stay = "";
        $refno = random_string('numeric', 4);
        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $coupon = "";

        $data = array(
            'booking_ref_no' => $refno,
            'booking_type' => 'boats',
            'booking_item' => $itemid,
            'booking_subitem' => json_encode($subitem),
            'booking_extras' => $extras,
            'booking_date' => time(),
            'booking_expiry' => time() + $expiry,
            'booking_user' => $payload['userId'],
            'booking_status' => 'unpaid',
            'booking_additional_notes' => $payload['additionalnotes'],
            'booking_total' => $grandtotal,
            'booking_remaining' => $grandtotal,
            'booking_checkin' => $checkin,
            'booking_checkout' => $checkout,
            'booking_nights' => $stay,
            'booking_adults' => $adults,
            'booking_child' => $child,
            'booking_deposit' => $deposit,
            'booking_tax' => $tax,
            'booking_paymethod_tax' => $paymethodfee,
            'booking_extras_total_fee' => $extrasTotalFee,
            'booking_curr_code' => $currCode,
            'booking_curr_symbol' => $currSymbol,
            'booking_extra_beds' => $extrabeds,
            'booking_extra_beds_charges' => "",
            'booking_coupon_rate' => "",
            'booking_coupon' => "",
            'booking_guest_info' => ""
        );
        $this->db->insert('pt_bookings', $data);
        $bookid = $this->db->insert_id();
        dd($this->db->last_query());
        $bookingResult = array("error" => "yes", 'msg' => 'Error occured');

        $this->session->set_userdata("BOOKING_ID", $bookid);
        $this->session->set_userdata("REF_NO", $refno);

        $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
        $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url);
        $invoicedetails = invoiceDetails($bookid,$refno);

        $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        echo $url;
    }

    /**
     * Do boats guest booking
     */
    public function do_boats_guest_booking()
    {
        ini_set('display_errors',1);
        $this->load->model('Admin/Accounts_model');
        $payload = $this->input->post();
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['userId'] = $userid;

        return $this->do_boats_booking($payload);
    }

    public function getDays($days){
        if($days == "monday" ){
            return 1;
        }elseif ($days == "tuesday"){
            return 2;
        }elseif ($days == "wednesday"){
            return 3;
        }elseif ($days == "thursday"){
            return 4;
        }elseif ($days == "friday"){
            return 5;
        }elseif ($days == "saturday"){
            return 6;
        }elseif ($days == "sunday"){
            return 6;
        }
    }

    function listing($offset = null) {

        $this->lang->load("front", $this->data['lang_set']);

        $settings = $this->Settings_model->get_front_settings('boats');

        $this->data['moduleTypes'] = $this->Boats_lib->boatTypes();

        $allboats = $this->Boats_lib->show_boats($offset);

        $this->data['module'] = $allboats['all_boats'];

        $this->data['info'] = $allboats['paginationinfo'];

        $this->data['checkin'] = $this->Boats_lib->date;

        $this->data['adults'] = $this->Boats_lib->adults;

        $this->data['child'] = (int) $this->Boats_lib->child;

        $this->data['minprice'] = $this->Boats_lib->convertAmount($settings[0]->front_search_min_price);

        $this->data['maxprice'] = $this->Boats_lib->convertAmount($settings[0]->front_search_max_price);

        $this->data['currCode'] = $this->Boats_lib->currencycode;

        $this->data['currSign'] = $this->Boats_lib->currencysign;

        $this->data['langurl'] = base_url() . "boats/{langid}/";

        $this->setMetaData($settings[0]->header_title, $settings[0]->meta_description, $settings[0]->meta_keywords);

        $this->theme->view('modules/boats/listing', $this->data, $this);
    }

    function search($country = null, $city = null, $citycode = null, $offset = null) {

        $checkout = $this->input->get('checkout');

        $this->data['adults'] = (int) $this->input->get('adults');

        $this->data['child'] = (int) $this->input->get('child');

        $this->data['checkin'] = $this->input->get('date');

        //$country = $this->input->get('country');

        //$state = $this->input->get('state');

        $this->session->set_userdata('boatseach', $this->input->get());

        $type = $this->input->get('type');

        $cityid = $this->input->get('searching');

        $modType = $this->input->get('modType');

        if (empty($country)) {
            $surl = http_build_query($_GET);

            $locationInfo = pt_LocationsInfo($cityid);

            $country = url_title($locationInfo->country, 'dash', true);

            $city = url_title($locationInfo->city, 'dash', true);

            $cityid = $locationInfo->id;

            if (!empty($cityid) && $modType == "location") {
                redirect('boats/search/' . $country . '/' . $city . '/' . $cityid . '?' . $surl);
            } else if (!empty($cityid) && $modType == "boat") {
                $this->Boats_lib->set_id($cityid);

                $this->Boats_lib->boat_short_details();

                $title = $this->Boats_lib->title;

                $slug = $this->Boats_lib->slug;

                if (!empty($title)) {
                    redirect('boats/' . $slug);
                }
            }
        } else {

            if ($modType == "location") {
                $cityid = $citycode;
            } else {

                $cityid = "";
            }

            if (is_numeric($country)) {
                $offset = $country;
            }
        }

        if (array_filter($_GET)) {
            $allboats = $this->Boats_lib->search_boats($cityid, $offset);

            $this->data['module'] = $allboats['all_boats'];

            $this->data['info'] = $allboats['paginationinfo'];
        } else {

            $this->data['module'] = array();
        }

        $this->lang->load("front", $this->data['lang_set']);

        $this->data['city'] = $cityid;

        $this->data['selectedLocation'] = $cityid; //$this->Boats_lib->selectedLocation;

        $this->data['checkin'] = $this->Boats_lib->date;

        $this->data['adults'] = $this->Boats_lib->adults;

        $this->data['child'] = (int) $this->Boats_lib->child;

        $this->data['selectedboatType'] = $this->Boats_lib->selectedboatType;

        $args = $this->session->userdata('boatseach');
        $this->load->library('Boats/BoatSearchForm');
        $searchForm = new boatSearchForm();
        if (!empty($args)) {
            $searchForm->parseUriString($args);
        }
        $this->data['boatsSearchForm'] = $searchForm;
        $this->data['moduleTypes'] = $this->Boats_lib->boatTypes();

        $settings = $this->Settings_model->get_front_settings('boats');

        $this->data['searchText'] = $this->input->get('txtSearch');

        $this->data['minprice'] = $this->Boats_lib->convertAmount($settings[0]->front_search_min_price);

        $this->data['maxprice'] = $this->Boats_lib->convertAmount($settings[0]->front_search_max_price);

        $this->data['currCode'] = $this->Boats_lib->currencycode;

        $this->data['currSign'] = $this->Boats_lib->currencysign;

        $this->setMetaData('Search Results');

        $this->theme->view('modules/boats/listing', $this->data, $this);
    }

    function book($boatslug) {

        $this->load->model('Admin/Countries_model');

        $this->data['allcountries'] = $this->Countries_model->get_all_countries();

        $check = $this->Boats_model->boat_exists($boatslug);

        $this->load->library("Paymentgateways");

        $this->data['hideHeader'] = "1";

        //echo "<pre>";

        //print_r($this->Paymentgateways->getAllGateways());

        //echo "</pre>";

        if ($check && !empty($boatslug)) {
            $this->lang->load("front", $this->data['lang_set']);

            $this->load->model('Admin/Payments_model');

            $this->data['error'] = "";

            $this->Boats_lib->set_boatid($boatslug);

            $boatID = $this->Boats_lib->get_id();

            $bookInfo = $this->Boats_lib->getBookResultObject($boatID);

            $this->data['module'] = $bookInfo['boat'];

            $this->data['extraChkUrl'] = $bookInfo['boat']->extraChkUrl;

            $this->data['totalGuests'] = $this->Boats_lib->guestCount;

            /* if($this->data['room']->price < 1 ||  $this->data['room']->stay < 1){

            $this->data['error'] = "error";

            }*/

            //  $this->data['paymentTypes'] = $this->Payments_model->get_all_payments_front();

            $this->load->model('Admin/Accounts_model');

            $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer');

            $this->data['profile'] = $this->Accounts_model->get_profile_details($loggedin);

            $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);

            $this->theme->view('booking', $this->data, $this);
        } else {

            redirect("boats");
        }
    }

    function txtsearch() {
    }

    function featuredboats($locid = null) {

        if (empty($locid)) {
            $fboats = $this->Boats_lib->getFeaturedboats();
        } else {

            $fboats = $this->Boats_lib->getLocationBasedFeaturedboats($locid);
        }

        echo json_encode($fboats);
    }

    function boatmap($boatid) {
        if (!empty($boatid)) {
            //$starting = pt_boat_start_end_map($boatid, 'start');

            //$ending = pt_boat_start_end_map($boatid, 'end');

            //$visiting = pt_boat_visiting_map($boatid);

            $locationsData = $this->Boats_lib->boatLocations($boatid);

            //print_r($locationsData->locations); exit;

            $locations = $locationsData->locations;

            $this->load->library('mapbuilder');

            $map = $this->mapbuilder;

            $map->setScrollwheel(FALSE);

            $map->_setBounds = TRUE;

            $map->setCenter($locations[0]->lat, $locations[0]->long);

            $map->setMapTypeId('ROADMAP');

            $map->setSize('100%', '100%');

            $map->setApiKey($this->data['app_settings'][0]->mapApi);

            $latDiff = $locations[count($locations) - 1]->lat - $locations[0]->lat;

            $longDiff = $locations[count($locations) - 1]->long - $locations[0]->long;

            $maxDiff = max(array($latDiff, $longDiff));

            //echo "Lat: ".$latDiff."----";

            //echo "Long: ".$longDiff."----";

            //echo $maxDiff; exit;

            if ($maxDiff >= 0 && $maxDiff <= 0.0037) //zoom 17

            {
                $map->setZoom(14);
            } else if ($maxDiff > 0.0037 && $maxDiff <= 0.0070) //zoom 16

            {
                $map->setZoom(13);
            } else if ($maxDiff > 0.0070 && $maxDiff <= 0.0130) //zoom 15

            {
                $map->setZoom(12);
            } else if ($maxDiff > 0.0130 && $maxDiff <= 0.0290) //zoom 14

            {
                $map->setZoom(13);
            } else if ($maxDiff > 0.0290 && $maxDiff <= 0.0550) //zoom 13

            {
                $map->setZoom(10);
            } else if ($maxDiff > 0.0550 && $maxDiff <= 0.1200) //zoom 12

            {
                $map->setZoom(9);
            } else if ($maxDiff > 0.1200 && $maxDiff <= 0.4640) //zoom 10

            {
                $map->setZoom(8);
            } else if ($maxDiff > 0.4640 && $maxDiff <= 1.8580) //zoom 8

            {
                $map->setZoom(8);
            } else if ($maxDiff > 1.8580 && $maxDiff <= 3.5310) //zoom 7

            {
                $map->setZoom(7);
            } else if ($maxDiff > 3.5310 && $maxDiff <= 7.3367) //zoom 6

            {
                $map->setZoom(6);
            } else if ($maxDiff > 7.3367 && $maxDiff <= 14.222) //zoom 5

            {
                $map->setZoom(5);
            } else if ($maxDiff > 14.222 && $maxDiff <= 28.000) //zoom 4

            {
                $map->setZoom(4);
            } else if ($maxDiff > 28.000 && $maxDiff <= 58.000) //zoom 3

            {
                $map->setZoom(3);
            } else {

                $map->setZoom(1);
            }

            /*$locations = array();

            if (!empty ($starting)) {

            $locations[] = $starting;

            }

            if (!empty ($visiting)) {

            foreach ($visiting as $v) {

            $locations[] = $v;

            }

            }

            if (!empty ($ending)) {

            $locations[] = $ending;

            }*/

            $path1 = array();

            $count = 0;

            foreach ($locations as $location) {
                $count++;

                //if ($i < sizeof($locations)) {

                $path1[] = array($location->lat, $location->long);

                //}

                $map->addMarker($location->lat, $location->long, array('title' => $location->name, 'icon' => "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=$count|2b7de2|FFFFFF",

                    'html' => '<b>' . $location->name . '</b>', 'infoCloseOthers' => true));
            }

            $map->addPolyline($path1, '#0658bd', 3, 1);

            $map->show();
        }
    }

    function _remap($method, $params = array()) {

        $funcs = get_class_methods($this);

        if (in_array($method, $funcs)) {
            return call_user_func_array(array($this, $method), $params);
        } else {

            $result = checkUrlParams($method, $params, $this->validlang);

            if ($result->showIndex) {
                $this->index();
            } else {

                $this->lang->load("front", $this->data['lang_set']);

                $settings = $this->Settings_model->get_front_settings('boats');

                $this->data['moduleTypes'] = $this->Boats_lib->boatTypes();

                $allboats = $this->Boats_lib->showboatsByLocation($result, $result->offset);

                $this->data['module'] = $allboats['all_boats'];

                $this->data['info'] = $allboats['paginationinfo'];

                $this->data['date'] = $this->Boats_lib->date;

                $this->data['minprice'] = $this->Boats_lib->convertAmount($settings[0]->front_search_min_price);

                $this->data['maxprice'] = $this->Boats_lib->convertAmount($settings[0]->front_search_max_price);

                $this->data['currCode'] = $this->Boats_lib->currencycode;

                $this->data['currSign'] = $this->Boats_lib->currencysign;

                $this->data['langurl'] = base_url() . "boats/{langid}/";

                $this->setMetaData($settings[0]->header_title, $settings[0]->meta_description, $settings[0]->meta_keywords);

                $this->theme->view('modules/boats/standard/listing', $this->data, $this);
            }
        }
    }

}
