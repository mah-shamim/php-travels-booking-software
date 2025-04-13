<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Main extends REST_Controller {

    function __construct() {
    // Construct our parent class

    parent :: __construct();
    if(!$this->isValidApiKey){
    $this->response($this->invalidResponse, 200);
    }

    // Configure limits on our controller methods. Ensure
    // you have created the 'limits' table and enabled 'limits'
    // within application/config/rest.php

    $this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
    $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
    $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key

    if($version > 5.6)
    {
    $ci->db->query('SET SESSION sql_mode = ""');
    $ci->db->query('SET SESSION sql_mode =
    REPLACE(REPLACE(REPLACE(
    @@sql_mode,
    "ONLY_FULL_GROUP_BY,", ""),
    ",ONLY_FULL_GROUP_BY", ""),
    "ONLY_FULL_GROUP_BY", "")');
    } 
        $this->load->library('Hotels/Hotels_lib');
        $this->load->library('Tours/Tours_lib');
        $this->load->library('Cars/Cars_lib');
        $this->load->library('Flights/Flights_lib');
        $this->load->model('Admin/Settings_model');
        $this->load->library('Blog/Blog_lib');
    }

        function getway_get()
        {
            $this->load->model('Admin/Payments_model');
            $getAllPaymentsBack = $this->Payments_model->getAllPaymentsBack_formainAPI();
        $this->response($getAllPaymentsBack);

        }
        function app_get() {

        $lang = $this->get('lang');
        $currencycode = $this->get('currency');
            $curr_code = $this->Hotels_lib->currencycode;

            if(!empty($currencycode)){
                $currency = $currencycode;
            }else{
                $currency = $curr_code;
            }
        $moduleslist = $this->App->service('ModuleService')->all_mod_front();
            $ordernumber = array();
            $modulesname = array();
            $hotels = 1; $flights = 1; $tours = 1; $visa = 1; $cars = 1; $rental = 1; $cruise = 1;
            foreach ($moduleslist as $index => $module) {
                if ($module->ia_active == 1 && $module->parent_id == 'hotels' && $hotels == 1) {
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('name' => 'hotels', 'status' => true, 'order' => $module->front_order);
                    array_push($modulesname, $namestore);
                    $hotels++;
                }
                if ($module->ia_active == 1 && $module->parent_id == 'flights' && $flights == 1) {
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('name' => 'flights', 'status' => true, 'order' => $module->front_order);
                    array_push($modulesname, $namestore);
                    $flights++;
                }
                if ($module->ia_active == 1 && $module->parent_id == 'tours' && $tours == 1) {
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('name' => 'tours', 'status' => true, 'order' => $module->front_order);
                    array_push($modulesname, $namestore);
                    $tours++;
                }
                if ($module->ia_active == 1 && $module->parent_id == 'visa' && $visa == 1) {
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('name' => 'visa', 'status' => true, 'order' => $module->front_order);
                    array_push($modulesname, $namestore);
                    $visa++;
                }
                if ($module->ia_active == 1 && $module->parent_id == 'cars' && $cars == 1) {
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('name' => 'cars', 'status' => true, 'order' => $module->front_order);
                    array_push($modulesname, $namestore);
                    $cars++;
                }
                if ($module->ia_active == 1 && $module->parent_id == 'rental' && $rental == 1) {
                    if ($module->name == 'Rentals') {
                        array_push($ordernumber, $module->front_order);
                        $namestore = array('name' => 'rentals', 'status' => true, 'order' => $module->front_order);
                        array_push($modulesname, $namestore);
                    }
                    $rental++;
                }

                if ($module->ia_active == 1 && $module->parent_id == 'cruise' && $cruise == 1) {
                    if ($module->name == 'Boats') {
                        array_push($ordernumber, $module->front_order);
                        $namestore = array('name' => 'boats', 'status' => true, 'order' => $module->front_order);
                        array_push($modulesname, $namestore);
                    }
                    $cruise++;
                }
            }

        $extramodules = $this->ptmodules->extramodules();
        $languageList = pt_get_response_languages();
        $cur =  $this->ptmodules->currencies();
        $feature_hotel =   $this->Hotels_lib->getFeaturedHotelsmain($lang,$currency);
        // dd($feature_hotel);
        $featuredTours = $this->Tours_lib->getFeaturedToursmain($lang,$currency);
        $featuredCars = $this->Cars_lib->getFeaturedCarsmain($lang,$currency);
        $featuredFlights = $this->Flights_lib->getFeaturedFlights();
            $Flights = [];
            $this->load->model('Hotels/Hotels_model');

            foreach ($featuredFlights as $key=>$value){

                $current_currency_price = $this->Hotels_model->currencyrate($value->currCode);
                $con_rate = $this->Hotels_model->currencyrate($currency);

                if(!empty($value->price) && !empty($current_currency_price)) {
                    $price_get = ceil($value->price / $current_currency_price);
                }else{
                    $price_get = 0;
                }
                $price = ceil($price_get * $con_rate);

                array_push($Flights,(object)[
                    'id'=>$value->id,
                    'title'=>$value->title,
                    'from'=>$value->from,
                    'to'=>$value->to,
                    'thumbnail'=>$value->thumbnail,
                    'desc'=>$value->desc,
                    'price'=>$price,
                    'currCode'=>$currency,
                ]);
            }
        $app = $this->Settings_model->get_settings_data();
        $slider = $this->Settings_model->active_slider();
        $footersocials = pt_get_footer_socials_main();
        $res2 = $this->Settings_model->get_contact_page_details();
        $blog = $this->Blog_lib->latestPostsmain($lang);
        $defaultLang = pt_get_default_language();
        if (!empty($lang)) {
        $H_menu = json_decode(get_header_menu_main(1,$lang));
        $F_menu = json_decode(get_footer_menu_main(2,$lang));
        }else{
        $H_menu = json_decode(get_header_menu_main(1,$defaultLang));
        $F_menu = json_decode(get_footer_menu_main(2,$defaultLang));
        }
        


        $F_pages = [];
        $footer_arr = [];
        foreach ($F_menu as $key=>$value)
        {array_push($F_pages,$value->page_name);}
        foreach (array_unique($F_pages) as $k => $v) {
        $F_arr = [];
        foreach ($F_menu as $key=>$value){
            if($value->page_name == $v){
                array_push($F_arr,(object)[
                    'href'=>$value->href,
                    'target'=>$value->target,
                    'title'=>$value->title
                ]);
            }
        }array_push($footer_arr, array($v=>$F_arr));}

        $H_pages = [];
        $header_arr = [];
        foreach ($H_menu as $key=>$value)
        {array_push($H_pages,$value->page_name);}
        foreach (array_unique($H_pages) as $k => $v) {
        $H_arr = [];
        foreach ($H_menu as $key=>$value){
            if($value->page_name == $v){
                array_push($H_arr,(object)[
                    'href'=>$value->href,
                    'target'=>$value->target,
                    'title'=>$value->title
                ]);
            }
        }array_push($header_arr, array($v=>$H_arr));}
        /*get payment_gat for main api*/
        $this->load->model('Admin/Payments_model');
        $payment_gateways = $this->Payments_model->getAllPaymentsBack_formainAPI();
        if ($app[0]->restrict_website == 'Yes') {
        $restrict_website = true;}else{$restrict_website = false;}

        if ($app[0]->allow_registration == 1) {
        $allow_registration = true;}else{$allow_registration = false;}

        if ($app[0]->allow_supplier_registration == 1) {
        $allow_supplier = true;}else{$allow_supplier = false;}

        if ($app[0]->allow_agent_registration == 1) {
        $allow_agent_registration = true;}else{$allow_agent_registration = false;}

        if ($app[0]->multi_curr == 1){
        $multi_currency = true;}else{$multi_currency = false;}

        if ($app[0]->multi_lang == 1){
        $multi_language  = true;}else{$multi_language  = false;}
        
        if (!empty ($modulesname)) {
        $this->response(array('modules' => $modulesname, 'slider'=> $slider,'payment_gateways'=>$payment_gateways, 'extras' => $extramodules, 'currencies' => $cur, 'languages'=>$languageList,'cms'=>array('header'=>$header_arr, 'footer'=>$footer_arr),'app' => array('appname' => $app[0]->site_title , 'site_url' => $app[0]->site_url ,'offline'=>$app[0]->site_offline,'offline_msg'=>$app[0]->offline_message,'restrict_website'=>$restrict_website,'allow_registration'=>$allow_registration,'allow_agent_registration'=>$allow_agent_registration,'suppliers_registration'=>$allow_supplier,'gmap_key'=>$app[0]->mapApi, 'default_language'=> $defaultLang, 'multi_currency' => $multi_currency,'multi_language' => $multi_language,'currency_code' => $curr_code,'copyright'=>$app[0]->copyright,'email'=>$res2[0]->contact_email,'phone'=>$res2[0]->contact_phone,'address'=>$res2[0]->contact_address),'social'=>$footersocials,'featured_hotels'=>$feature_hotel,'featured_flights'=>$Flights,'featured_tours'=>$featuredTours,'featured_cars'=>$featuredCars,'featured_blog'=>$blog), 200); // 200 being the HTTP response code
        }
        else {
        $this->response(array('response' => "", array('status' => TRUE,'msg' => 'Modules Not Found')), 200);
        }
        }


        function wego_get(){
        $this->load->model("Wegoflights/Wegoflights_model");
        $result = $this->Wegoflights_model->get_front_settings();
        if ($result->url) {
        $this->response(array('response' => $result), 200);
        }
        else {
        $this->response(array('response' => "",array('status' => TRUE,'msg' => 'WegoFlights Module Not Found')), 200);
        }
        }

        function travelstart_get(){
        $this->response(array('response' => array('url' => base_url().'flightst?mobile=yes')), 200);
        }

        function cartrawler_get(){

        $settings =  $this->Settings_model->get_front_settings("cartrawler");
        $result = new stdClass;
        $result->cid = $settings[0]->cid;
        if ($result->cid) {
        $this->response(array('response' => $result), 200);
        }

        else {
        $this->response(array('response' => "",array('status' => TRUE,'msg' => 'Cartrawler Module Not Found')), 200);
        }
        }

        function travelpayouts_get(){
        $this->response(array('response' => array('url' => base_url().'travelpayouts/mobile')), 200);
        }

        function travelpayoutshotels_get(){
        $this->response(array('response' => array('url' => base_url().'Travelpayoutshotels/mobile')), 200);
        }

        function items_get(){
        $hotelsEnable = pt_main_module_available("hotels");
        $toursEnable = pt_main_module_available("tours");
        $carsEnable = pt_main_module_available("cars");
        if($hotelsEnable){

        $this->load->library('Hotels/Hotels_lib');
        $list1 = $this->Hotels_lib->getLatestHotelsForAPI();

        }else{

        $eanEnable = pt_main_module_available("ean");

        if($eanEnable){
        $this->load->library("Ean/Ean_lib");
        $eanlist =	$this->Ean_lib->getHomePageFeaturedHotels();
        $list1 = $eanlist->hotels;
        }else{
        $list1 = array();
        }
        }

        if($toursEnable){
        $this->load->library('Tours/Tours_lib');

        $list2 = $this->Tours_lib->getLatestToursForAPI();
        }else{
        $list2 = array();
        }

		if($carsEnable){
		$this->load->library('Cars/Cars_lib');
		$list3 = $this->Cars_lib->getLatestCarsForAPI();
		}else{

		$list3 = array();
		}

        $list = array_merge($list1,$list2,$list3);
        usort($list, array($this, "cmp"));

        if (!empty ($list)){
        $this->response(array('response' => $list, 'error' => array('status' => FALSE,'msg' => '')), 200); // 200 being the HTTP response code
        }

        else {
        $this->response(array('response' => "", array('status' => TRUE,'msg' => 'Items Not Found')), 200);
        }
        }

		function aboutus_get(){
		$mobileSettings =	mobileSettings();
		$this->response(array('response' => $mobileSettings->aboutUs), 200);
		}

		function cmp($a, $b)
		{
		return strcmp($b->createdAt,$a->createdAt);
		}

}
