<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Flight_Searches extends MX_Controller {
    function __construct() {
        modules :: load('Admin');
        $chkadmin = modules :: run('Admin/validadmin');
        if (!$chkadmin) {
            $this->session->set_userdata('prevURL', current_url());
            redirect('admin');
        }
        $this->data['app_settings'] = $this->Settings_model->get_settings_data();
        $checkingadmin = $this->session->userdata('pt_logged_admin');
        if (!empty ($checkingadmin)) {
            $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
        }
        else {
            $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
        }
        if (!empty ($checkingadmin)) {
            $this->data['adminsegment'] = "admin";
        }
        else {
            $this->data['adminsegment'] = "supplier";
        }
        $this->load->model('Admin/Bookings_model');
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
        $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;
        $this->data['addpermission'] = true;
        if($this->role == "admin"){
        $this->editpermission = pt_permissions("editbooking", $this->data['userloggedin']);
        $this->deletepermission = pt_permissions("deletebooking", $this->data['userloggedin']);
        $this->data['addpermission'] = pt_permissions("addbooking", $this->data['userloggedin']);
        }

        $this->lang->load("back", "en");
        } 

   function index() {
    $this->load->helper('xcrud');
    $xcrud = xcrud_get_instance();
    $xcrud->table('flights_search_logs');
    $xcrud->order_by('id','desc');

    $this->data['content'] = $xcrud->render();
    $this->data['page_title'] = 'Flights Search Management';
    $this->data['main_content'] = 'temp_view';
    $this->data['table_name'] = 'flights_search_logs';
    $this->data['main_key'] = 'id';
    $this->data['header_title'] = 'Flights Search Management';
    $this->load->view('template', $this->data);
    }


// Delete Multiple Bookings
    function delMultipleBookings(){
echo "string";
    }

}