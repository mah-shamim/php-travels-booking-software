<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

       private $validlang;

  function __construct(){
   // $this->session->sess_destroy();
    parent::__construct();

    //$this->load->library('facebook');
  $this->data['app_settings'] = $this->Settings_model->get_settings_data();
   $allowreg = $this->data['app_settings'][0]->allow_registration;
   if($allowreg == "0"){
     Error_404($this);
   }
   modules::load('home');
    $langcode = $this->uri->segment(2);

    $this->validlang = pt_isValid_language($langcode);
    if($this->validlang){
    $this->data['lang_set'] = $langcode;
    }else{
    $this->data['lang_set'] = $this->session->userdata('set_lang');
    }

  $this->data['usersession'] =   $this->session->userdata('pt_logged_customer');
  $this->data['fbsession'] = $this->session->userdata('fb_token');
      $this->data['phone'] = $this->load->get_var('phone');
      $this->data['contactemail'] = $this->load->get_var('contactemail');

   $defaultlang = pt_get_default_language();
   if(empty($this->data['lang_set'])){

      $this->data['lang_set'] = $defaultlang;
   }
   $this->lang->load("front",$this->data['lang_set']);
 }

	public function index()
	{


    if(!empty($this->data['usersession']) || !empty($this->data['fbsession'])){

     redirect(base_url().'account');

    }else{
     echo $this->data['fbsession'];
    $this->data['fblogin'] = $this->Settings_model->facebook_login_status();
    //$this->data['fbloginurl'] = $this->facebook->login_url();

    $url = http_build_query($_GET);
    if(!empty($url)){
     $this->data['url'] = '?'.$url;
    }else{
     $this->data['url'] = "";
    }

    $this->data['pageTitle'] = 'Login';
    $restricted = $this->data['app_settings'][0]->restrict_website;
    $this->data['registerationAllowed'] = $this->data['app_settings'][0]->allow_registration;
    if($restricted == "Yes"){
     $this->data['hidden'] = "hidden-sm hidden-lg";
    }

    $this->data['langurl'] = base_url()."login/{langid}";

    $this->theme->view('login',$this->data, $this);
    }


     }

     function _remap($method, $params=array()){
     $funcs = get_class_methods($this);

     if(in_array($method, $funcs)){

     return call_user_func_array(array($this, $method), $params);

     }else{
       $this->index();
     }

     }



}
