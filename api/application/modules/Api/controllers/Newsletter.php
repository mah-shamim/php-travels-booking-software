<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Newsletter extends REST_Controller {

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

    function subscribe_get(){
        $email = $this->input->get('email');
        $this->load->model('Admin/Newsletter_model');
        $subscribers = $this->Newsletter_model->add_subscriber($email, $type = "subscribers");
        if(!empty($subscribers)){
        $this->response(array('status' => TRUE), 200);
        }else{
        $this->response(array('status' => FALSE), 200);
        }
    }
}