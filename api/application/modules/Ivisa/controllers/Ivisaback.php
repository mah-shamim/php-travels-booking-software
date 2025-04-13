<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ivisaback extends MX_Controller {

	function __construct(){
	$seturl =  $this->uri->segment(3);
    if($seturl != "settings"){
    $chk = modules::run('Home/is_main_module_enabled','ivisa');
    if(!$chk){
    backError_404();
    }
    }
    $checkingadmin = $this->session->userdata('pt_logged_admin');
    if(!empty($checkingadmin)){
    $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
    }else{
    $this->data['userloggedin'] = $this->session->userdata('pt_logged_agent');
    }
    if(empty($this->data['userloggedin'])){
    redirect("admin");
    }
    if(!empty($checkingadmin)){
    $this->data['adminsegment'] = "admin";
    }else{
    $this->data['adminsegment'] = "agent";
    }

        if ($this->data['adminsegment'] == "admin")
        {
            $checkpoint = modules :: run('Admin/validadmin');
            if ( ! $checkpoint) // If checkpoint become fail
            {
                redirect('admin');
            }
        }
        else
        {
            $checkpoint = modules :: run('supplier/validsupplier');
            if ( ! $checkpoint) // If checkpoint become fail
            {
                redirect('supplier');
            }
        }

        // Assign PHP Travel app settings, get it from settings table.
        $this->data['appSettings'] = modules :: run('Admin/appSettings');

        $this->data['addpermission'] = true;

        if($this->role == "supplier" || $this->role == "admin")
        {
            $this->editpermission = pt_permissions("edithotels", $this->data['userloggedin']);
            $this->deletepermission = pt_permissions("deletehotels", $this->data['userloggedin']);

            $this->data['addpermission'] = pt_permissions("addhotels", $this->data['userloggedin']);
        }

    $this->load->helper('settings');
    $this->load->model('Ivisa/Ivisa_model');
    $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
    }
    function index(){
    }

    function settings(){
    $updatesett = $this->input->post('updatesettings');
    if(!empty($updatesett)){
    $this->Ivisa_model->update_front_settings();
    redirect('admin/ivisa/settings');
    }
    $this->data['settings'] = $this->Ivisa_model->get_front_settings();
    $this->data['main_content'] = 'Ivisa/settings';
	$this->data['page_title'] = 'IVisa Settings';
    $this->data['countries'] = $this->Ivisa_model->get_countries();
	$this->load->view('Admin/template',$this->data);
    }

    function bookings(){
    $this->load->helper('xcrud');
    $xcrud = xcrud_get_instance();
    $xcrud->table('booking_visa');
    $xcrud->columns('status,date,res_code,first_name,last_name,email,from_country,to_country');
    $xcrud->order_by('id', 'desc');
    /*$xcrud->fields('social_icon,social_name,social_link,social_status,social_position');*/
    $this->data['content'] = $xcrud->render();
    $this->data['page_title'] = 'Visa Bookings';
    $this->data['main_content'] = 'temp_view';
    $this->data['table_name'] = 'booking_visa';
    $this->data['main_key'] = 'id';
    $this->data['header_title'] = 'Visa Bookings';
    $this->load->view('Admin/template', $this->data);
    }

    }
