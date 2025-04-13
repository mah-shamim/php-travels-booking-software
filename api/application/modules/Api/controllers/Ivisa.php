<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Ivisa extends REST_Controller {

    const Module = "Ivisa";
    
    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
         $this->load->model('Apivisa_model');
        $this->output->set_content_type('application/json');
       }
       public function booking_post(){
        $reserve = sprintf("%06d", mt_rand(1, 999999));
        substr(number_format(time() * rand(),0,'',''),0,6);
        $insert=array(
          'first_name' =>$this->post('first_name'),
          'last_name' =>$this->post('last_name'),
          'email' =>$this->input->post('email'),
          'status'=>'waiting',
          'phone' =>$this->input->post('phone'),      
          'from_country' =>$this->input->post('from_country'),
          'to_country' =>$this->input->post('to_country'),
          'notes'=>$this->input->post('notes'),
          'date'=>$this->input->post('date'),
          'res_code'=> $reserve
    );
     $sucess=$this->Apivisa_model->book_user($insert);
     if($sucess){
        echo json_encode(array("msg"=>'User added Sucessfully' ,'status'=>True));
     }else{
         echo json_encode(array("msg"=>'User Not added' ,'status'=>False));
     }
   }
}