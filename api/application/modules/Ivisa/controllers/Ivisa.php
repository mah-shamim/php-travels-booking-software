<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ivisa extends MX_Controller {

      function __construct()
      {
          parent::__construct();
          $this->load->model("Ivisa_model");

          $this->data['lang_set'] = $this->session->userdata('set_lang');
          $chk = modules::run('Home/is_main_module_enabled','ivisa');
          
          if(!$chk){
            Error_404($this);
          }

          $this->data['phone'] = $this->load->get_var('phone');
          $this->data['contactemail'] = $this->load->get_var('contactemail');
          $defaultlang = pt_get_default_language();
          
          if(empty($this->data['lang_set']))
          {
            $this->data['lang_set'] = $defaultlang;
          }
          
          $this->lang->load("front",$this->data['lang_set']);
           $this->load->model("Admin/Emails_model");
      }

    public function index()
    {

      $this->data['fr']=$this->input->get('nationality_country');
      $this->data['ft']=$this->input->get('destination_country');
      $this->data['date']=$this->input->get('date');

        $settings = $this->Ivisa_model->get_front_settings();

        $countries_json  = file_get_contents('./application/json/countries.json');
        $countries_array = json_decode($countries_json, TRUE);
        $parameters      = $this->input->get();

        if (empty($parameters)) 
        {
            $parameters['nationality_country'] = $settings->from;
            $parameters['destination_country'] = $settings->to;
        }

        $this->data['filteredCountires'] = array();
        foreach($countries_array as $countries_object)
        {
            if(trim($parameters['nationality_country']) == $countries_object['iso2'] || trim($parameters['nationality_country']) == trim($countries_object['short_name']))
            {
                $this->data['filteredCountires']['nationality_country'] = $countries_object;
            }
            else if(trim($parameters['destination_country']) == $countries_object['iso2'] || trim($parameters['destination_country']) == trim($countries_object['short_name']))
            {
                $this->data['filteredCountires']['destination_country'] = $countries_object;
            }
        }

     $this->data['url'] = $settings->url;
     $this->data['affiliate_code'] = $settings->aid;
     $this->setMetaData($settings->headerTitle);
     $loadheaderfooter = $settings->showHeaderFooter;

        if($loadheaderfooter == "no")
        {
            $this->theme->partial('modules/visa/index',$this->data);
        }
        else
        {
            $this->theme->view('modules/visa/index',$this->data, $this);
        }
} 

     public function booking(){

     $this->form_validation->set_rules('email', 'Email', 'required');
     $this->form_validation->set_rules('confirmemail', 'email ', 'required|matches[email]');
     if($this->form_validation->run() == FALSE)
        {
          $this->data['form_errors']="Confirm email must be same";
          $this->theme->view('modules/visa/index',$this->data, $this);
         }
      else{
     $reserve = sprintf("%06d", mt_rand(1, 999999));
     substr(number_format(time() * rand(),0,'',''),0,6);
     $data=array(
          'first_name' =>$this->input->post('first_name'),
          'last_name' =>$this->input->post('last_name'),
          'email' =>$this->input->post('email'),
          'status'=>'waiting',
          'phone' =>$this->input->post('phone'),      
          'from_country' =>$this->input->post('from_country'),
          'to_country' =>$this->input->post('to_country'),
          'notes'=>$this->input->post('notes'),
          'date'=>$this->input->post('date'),
          'res_code'=> $reserve

);
     $this->load->model("Ivisa_model");
     $confirm=$this->Ivisa_model->bookin($data);
     if($confirm){
     redirect("visa/confirmation");
     }
  }
}
      public function confirmation(){

      $this->data['page_title'] = trans("0268");
      $invoice=$this->Ivisa_model->get_code();
      $this->data['res_cod']=$invoice[0]->res_code;
      $this->Emails_model->visasend_invoice($invoice);
      $this->theme->view('modules/visa/confirmation',$this->data,$this);
    }
     

     public function invoice(){
      $code=$this->uri->segment(3);
      $this->data['invoice_details']=$this->Ivisa_model->get_invoice($code);
      $this->theme->view('modules/visa/invoice',$this->data,$this);
    }
    
}