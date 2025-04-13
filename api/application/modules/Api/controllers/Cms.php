<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Cms extends REST_Controller {

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

    function cms_details_get(){
        $title = $this->input->get('title');
        $lang = $this->input->get('lang');
        $this->load->model('Helpers_models/Menus_model');
        $page_details = $this->Menus_model->get_cms_details($title,$lang);
        $p = (object) $page_details;
        if(!empty($p)){
        $this->response(array('response' => $p, 'error' => array('status' => FALSE,'msg' => '')), 200);
        }else{
        $this->response(array('response' => $p, 'error' => array('status' => TRUE,'msg' => 'Invalid Title')), 200);
        }
    }
}