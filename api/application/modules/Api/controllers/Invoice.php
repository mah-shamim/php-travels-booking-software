<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Invoice extends REST_Controller {

    const FLIGHT_KEY = 1984;
    
    public function __construct() 
    {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey)
        {
            $this->response($this->invalidResponse, 400);
        }
    }

    public function info_get() 
    {
        $this->load->helper('invoice');
        $this->load->helper('Api/apihelp');

        $id   = $this->get('invoiceno');
        $code = $this->get('invoicecode');

        if($this::FLIGHT_KEY == $id) {
            // Travelport Flight
            $this->load->model('Travelport_flight/TravelportModel_Cart');
            $info = $this->TravelportModel_Cart->get_invoice($code);
            $url  = base_url("invoice/flight?token=" . $code);
        } else {
            $info = api_valid_invoice($id, $code);
            $url  = base_url() . "invoice?id=" . $id . "&sessid=" . $code;
        }

        if ($info) {
            $this->response(array('response' => array('url' => $url, 'error' => "")), 200); // 200 being the HTTP response code
        }
        else {
            $this->response(array('response' => array('url' => $url, 'error' => 'Invoice Not Found')), 200);
        }
    }

    public function verifyCoupon_post()
    {
        $code   = $this->post('code');
        $module = $this->post('module');
        $itemid = $this->post('itemId');
        $resp   = json_decode(pt_couponVerify($code, $module, $itemid));

        $this->response(array('response' => $resp), 200); // 200 being the HTTP response code
    }

    public function list_get() 
    {
        $this->load->model('Admin/Accounts_model');
        $userid = $this->get('userid');
        $bookings = $this->Accounts_model->get_my_bookings($userid);

        $travelportBookingsArray = array();
        if (pt_main_module_available('travelport_flight')) 
        {
            $this->load->model('Travelport_flight/TravelportModel');
            $travelportBookings = $this->TravelportModel->get_bookings($userid);
            if(isset($travelportBookings) && ! empty($travelportBookings)) {
                foreach($travelportBookings as $travelportBooking) {
                    array_push($travelportBookingsArray, array(
                        'id' => $this::FLIGHT_KEY,
                        'title' => $travelportBooking->destination->fullname,
                        'thumbnail' => $travelportBooking->carrier->image_path,
                        'checkin' => $travelportBooking->createdAt,
                        'checkout' => '',
                        'checkoutTotal' => $travelportBooking->total_price,
                        'code' => $travelportBooking->access_token,
                        'currCode' => $travelportBooking->currency,
                    ));
                }

                // Merge
                $bookings = array_merge($bookings, $travelportBookingsArray);
            }
        }

        if ( ! empty($bookings))
        {
            $this->response(array(
                'response' => $bookings, 
                'error' => array(
                    'status' => FALSE,
                    'msg' => ''
                )
            ), 200);
        }
        else 
        {
            $this->response(array(
                'response' => '', 
                'error' => array(
                    'status' => TRUE,
                    'msg' => 'Bookings not found'
                )
            ), 200);
        }
    }
}
