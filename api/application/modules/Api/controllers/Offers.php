<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Offers extends REST_Controller {

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
                $this->load->library('offers_lib');
        }

        function list_get() {
                $offset = $this->get('offset');
                $list = $this->offers_lib->showOffers($offset);
                $totalPages = ceil($list['paginationinfo']['totalrows'] / $list['paginationinfo']['perpage']);
                if (!empty ($list['allOffers'])) {
              $this->response(array('response' => $list['allOffers']['offers'], 'error' => array('status' => FALSE,'msg' => ''),'totalPages' => $totalPages), 200);
                }
                else {
            	$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Offers could not be found')), 200);
                }
        }

        function details_get() {

                if (!$this->get('offer_id')) {
                $this->response(array('response' => array('error' => 'Offer ID is required')), 200);
                }

                $this->offers_lib->set_id($this->get('offer_id'));
                $details = $this->offers_lib->offer_details();
                $details->desc = html_entity_decode(strip_tags($details->desc),ENT_QUOTES);

                if (!empty ($details)) {

  $this->response(array('response' => $details, 'error' => array('status' => FALSE,'msg' => '')), 200);

                }else {

  $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Offer Details could not be found')), 200);


                }

        }

        function sendMessage_post(){
                $this->load->model('Admin/Emails_model');
                $this->Emails_model->offerContactEmail();
            $this->response(array('response' => "Email Sent", 'error' => array('status' => FALSE,'msg' => '')), 200);
        }
}
