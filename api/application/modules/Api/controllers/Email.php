<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Email extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
        $this->response($this->invalidResponse, 400);
        }
        $this->load->model('Admin/Emails_model');
    }

    function globalmail_post(){
        $parm = array(
            'email'=>$this->input->post('email'),
            'body'=>$this->input->post('body'),
            'subject'=>$this->input->post('subject'),
            'cc_mail'=>$this->input->post('cc_mail')
        );
        $this->Emails_model->globalmail($parm);
        $this->response(array('status' => TRUE), 200);
    }
}