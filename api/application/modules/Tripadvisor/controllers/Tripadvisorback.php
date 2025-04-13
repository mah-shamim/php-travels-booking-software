<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tripadvisorback extends MX_Controller {


	function __construct(){
	    $seturl =  $this->uri->segment(3);
      if($seturl != "settings"){
        $chk = modules::run('Home/is_main_module_enabled','tripadvisor');
   if(!$chk){
       backError_404($this->data);

   }
      }
     $checkingadmin = $this->session->userdata('pt_logged_admin');
    if(!empty($checkingadmin)){

      $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');

    }else{

      $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');

    }

    if(empty($this->data['userloggedin'])){
     redirect("admin");
    }

    if(!empty($checkingadmin)){
     $this->data['adminsegment'] = "admin";

    }else{
      $this->data['adminsegment'] = "supplier";
    }

    if($this->data['adminsegment'] == "admin"){

   $chkadmin = modules::run('Admin/validadmin');
   if(!$chkadmin){
      redirect('admin');
   }

    }else{

   $chksupplier = modules::run('supplier/validsupplier');
   if(!$chksupplier){
      redirect('supplier');
   }


    }

   if(!pt_permissions('tripadvisor',$this->data['userloggedin'])){

     redirect('admin');
   }
    $this->load->helper('settings');
    $this->load->model('Tripadvisor/Tripadvisor_model');

    $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');


    }

    function index(){

    }


    function settings(){

    $updatesett = $this->input->post('updatesettings');

    if(!empty($updatesett)){

    $this->Tripadvisor_model->update_front_settings();
    redirect('admin/tripadvisor/settings');

    }

    $this->data['settings'] = $this->Settings_model->get_front_settings("tripadvisor");
    $this->data['main_content'] = 'Tripadvisor/settings';
	$this->data['page_title'] = 'Trip Advisor Settings';

	$this->load->view('Admin/template',$this->data);

    }



    }
