<?php
header('Access-Control-Allow-Origin: *');

class Api extends MX_Controller {
     public $data = array();
     private $validlang;
        function __construct() {
// Construct our parent class
                parent :: __construct();

               modules :: load('Home');

                $defaultlang = pt_get_default_language();

                 $languageid = $this->uri->segment(2);
                 $this->validlang = pt_isValid_language($languageid);

                if($this->validlang){
                  $this->data['lang_set'] =  $languageid;
                }else{
                  $this->data['lang_set'] = $this->session->userdata('set_lang');
                }

                if (empty ($this->data['lang_set'])){
                        $this->data['lang_set'] = $defaultlang;
                }

               $this->data['phone'] = $this->load->get_var('phone');
               $this->data['contactemail'] = $this->load->get_var('contactemail');
               $this->data['app_settings'] = $this->Settings_model->get_settings_data();
               $this->data['apiKeySession'] = $this->session->userdata('apiKey');

        }

        function index(){


           $submit = $this->input->post('submit');
           $key = $this->input->post('key');
           $mobile = mobileSettings("apiKey");
           $api = $mobile->apiKey;
           $this->data['apikey'] = $api;

           if(!empty($submit)){

            if($key == $api){

              $this->session->set_userdata('apiKey',$api);
              redirect(base_url().'api');


            }else{

              $this->data['error'] = TRUE;

            }

           }

           $this->lang->load("front", $this->data['lang_set']);
           $this->data['page_title'] = "API Docs";
           $this->data['langurl'] = base_url()."api/{langid}";
           $this->theme->view('api', $this->data, $this);

        }

}
