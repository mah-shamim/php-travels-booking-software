<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Cars extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
        $this->response($this->invalidResponse, 400);
        }

        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        $this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
        $this->load->library('Cars/Cars_lib');
        $this->settings = $this->Settings_model->get_settings_data();
        $lang = $this->get('lang');
				$this->Cars_lib->set_lang($lang);
    }

    function list_get() {

        $offset = $this->get('offset');
        $list = $this->Cars_lib->show_cars($offset);

        $Objresponse = $list['all_cars'];
        $totalPages = ceil($list['paginationinfo']['totalrows'] / $list['paginationinfo']['perpage']);
        if (!empty ($Objresponse)){
            $this->response(array('response' => $Objresponse, 'error' => array('status' => FALSE,'msg' => ''), 'totalPages' => $totalPages), 200);

        }else {
        $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results not found')), 200);
        }


    }

    function locations_get(){
        $id = $this->get('id');
        $pickuplocations = $this->Cars_lib->getPickupLocationsList($id);
        $dropofflocations = $this->Cars_lib->getDropLocationsList($id);

         if (!empty ($pickuplocations) && !empty($dropofflocations)) {
$this->response(array('response' => array('pickupLocations' => $pickuplocations, 'dropoffLocations' => $dropofflocations), 'error' => array('status' => FALSE,'msg' => '')), 200);
        }
        else {
            $this->response(array('response' => array('error' => 'Locations could not be found')), 200);
        }
    }

    function cartypes_get(){
        $carTypes = $this->Cars_lib->carTypes();


         if (!empty ($carTypes)) {
             $this->response(array('response' => $carTypes, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }
        else {
        $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Types could not be found')), 200);
        }
    }

    function details_get() {
        $id = $this->get('id');
        $appDate = $this->get('date');

        if(empty($appDate)){
        $date = "";
        }else{
        $date = date($this->settings[0]->date_f, strtotime($appDate));
        }

        if (empty($id)) {
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Car ID is required')), 200);
        }
        $details['car'] = $this->Cars_lib->car_details($id, $date);
        $details['car']->pickupLocationList = $this->Cars_lib->getPickupLocationsList($id);
        $details['car']->dropoffLocationList = $this->Cars_lib->getDropLocationsList($id);
        $details['car']->desc = html_entity_decode(strip_tags($details['car']->desc),ENT_QUOTES);

        if (pt_is_module_enabled('reviews')) {
                        $details['reviews'] = $this->Cars_lib->car_reviews_for_api($details['car']->id);
                        $details['avgReviews'] = $this->Cars_lib->carReviewsAvg($details['car']->id);
        }

        if (!empty ($details)) {
            $this->response(array('response' => $details, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }else{

           $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Car Details could not be found')), 200);

        }

    }

    function search_get() {



                $offset = $this->input->get('offset');
                $cityid = $this->get('location');

                /*$appCheckout = $this->get('checkout');
                $checkout = date($this->settings[0]->date_f, strtotime($appCheckout));*/
                $details = $this->Cars_lib->search_cars($cityid , $offset);

                $Objresponse = $details['all_cars'];
                $totalPages = ceil($details['paginationinfo']['totalrows'] / $details['paginationinfo']['perpage']);
                if (!empty ($Objresponse)){
                    $this->response(array('response' => $Objresponse, 'error' => array('status' => FALSE,'msg' => ''), 'totalPages' => $totalPages), 200);

                }else {
                $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results not found')), 200);
                }
        }

        function invoice_post() 
        {
            $this->load->model('Admin/Bookings_model');
            $userid = $this->post('userId');
            $payload = $this->post();
            
            if( ! empty($userid) )
            {
                $data = $this->Bookings_model->do_cars_booking($payload);
            }
            else
            {
                $data = $this->Bookings_model->do_cars_guest_booking($payload);
            }
            
            $message = array('response' => $data);
            $this->response($message, 200); // 200 being the HTTP response code
        }

    function show_get($param, $vars = null) {
        $arr = $this->input->get();
        $arrstr = "";
        foreach($arr as $key => $val){
            $arrstr .= $key."=".$val."&";
        }

         $url = base_url()."api/cars/".$param."?".$arrstr;
        //              $url = base_url() . "api/hotels/hoteldetails?id=40";
        //  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
        //  $url = base_url()."api/hotels/user";
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        @ $json = json_decode($rawdata);
        echo "<pre>";
        print_r($json);
    }
}
