<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Widget extends MX_Controller {
    private $myitems = array();
    public $role;
    public  $editpermission = true;
    public  $deletepermission = true;

    function __construct() {
//        modules :: load('supplier');
//        $chksupplier = modules :: run('Supplier/validsupplier');
//        $this->myitems = modules :: run('Supplier/myitems');
//
//        if (!$chksupplier) {
//            $this->session->set_userdata('prevURL', current_url());
//            redirect('supplier');
//        }

        $this->data['app_settings'] = $this->Settings_model->get_settings_data();
        $this->load->model('Admin/Bookings_model');
        $this->data['issupplier'] = $this->session->userdata('pt_logged_supplier');
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
        $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;
        $this->data['addpermission'] = true;

        $this->editpermission = pt_permissions("editbooking", $this->data['userloggedin']);
        $this->deletepermission = pt_permissions("deletebooking", $this->data['userloggedin']);
        $this->data['addpermission'] = pt_permissions("addbooking", $this->data['userloggedin']);


        //Tours Module Action
        $this->data['edittours']  = pt_permissions("edittours", $this->data['userloggedin']);
        $this->data['deletetours']  = pt_permissions("deletetours", $this->data['userloggedin']);
        $this->data['addpermission'] = pt_permissions("addtours", $this->data['userloggedin']);

        //Hotels Modules Action
        $this->data['edithotels']  = pt_permissions("edithotels", $this->data['userloggedin']);
        $this->data['deletehotels']  = pt_permissions("deletehotels", $this->data['userloggedin']);
        $this->data['addhotels'] = pt_permissions("addhotels", $this->data['userloggedin']);


        //Cars Modules Action
        $this->data['editcars']  = pt_permissions("editcars", $this->data['userloggedin']);
        $this->data['deletecars']  = pt_permissions("deletecars", $this->data['userloggedin']);
        $this->data['addcars'] = pt_permissions("addcars", $this->data['userloggedin']);

        $this->data['adminsegment'] = $this->uri->segment(1);
        $this->data['myitems'] = $this->myitems;

        $this->load->library('currconverter');
    }

    function index() {

        $this->data['page_title'] = 'Widget';
        $this->data['main_content'] = 'widget';
        $this->data['header_title'] = 'Widget';
        $this->load->view('Admin/template', $this->data);
    }

    //Get Suppliers Tours
    function tours() {
        $this->load->model('Tours/Tours_model');
        $this->load->library('Tours/Tours_lib');
        $tourd = $this->Tours_model->suppilertour($_GET['supplier_id']);
        $this->data['supplier'] = $this->Tours_lib->getResultObject($tourd);
        $this->data['page_title'] = 'Tours';
        $this->data['header_title'] = 'Widget';
        $this->load->view('Admin/widhet_iframe', $this->data);
    }

    //Get Suppliers Hotels
    function hotels() {
        $this->load->model('Hotels/Hotels_model');
        $this->load->library('Hotels/Hotels_lib');
        $hotel = $this->Hotels_model->suppilerhotel($_GET['supplier_id']);
        $result = $this->Hotels_lib->getResultObject($hotel);
        $this->data['supplier'] = $result;
        $this->data['page_title'] = 'Hotels';
        $this->data['header_title'] = 'Widget';
        $this->load->view('Admin/widhet_iframe', $this->data);
    }

    //Get Suppliers Cars
    function cars() {
        $this->load->model('Cars/Cars_model');
        $this->load->library('Cars/Cars_lib');
        $hotel = $this->Cars_model->suppilercars($_GET['supplier_id']);
        $result = $this->Cars_lib->getResultObject($hotel);
        $this->data['supplier'] = $result;
        $this->data['page_title'] = 'Cars';
        $this->data['header_title'] = 'Widget';
        $this->load->view('Admin/widhet_iframe', $this->data);
    }
}
