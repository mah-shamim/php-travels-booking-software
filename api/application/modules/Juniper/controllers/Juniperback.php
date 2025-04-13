<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Juniperback extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Juniper/Juniper_model');
        $method_segment = $this->uri->segment(3);
        // Access Checkpoint
        // Module enabled/disabled checkpoint
        $chk = $this->App->service('ModuleService')->isActive('Juniper');
        if ( ! $chk && $method_segment != "settings" && $method_segment != "update_settings") {
            backError_404($this->data);
        }
        $this->role    = $this->session->userdata('pt_role');

        // If user is not log in then redirect the to admin panel.
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_id');

        if (empty($this->data['userloggedin']))
        {
            // Redirect user to admin/index (Admin Dashboard)
            $urisegment =  $this->uri->segment(1);

            $this->session->set_userdata('prevURL', current_url());

            redirect($urisegment);
        }

        // If user is admin then assign `admin` to segment otherwise `supplier`
        $administrator = $this->session->userdata('pt_logged_admin');

        if ( ! empty ($administrator))
        {
            $this->data['adminsegment'] = "admin";
        }
        else
        {
            $this->data['adminsegment'] = "supplier";
        }

        // Usecase 1: If someone make changes in session then this check can be helpful.
        // If segment string is `admin` then validate it otherwise validated `supplier`
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

        $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
        $this->data['page_title'] = 'Juniper Setting';
        $this->load->helper("all");
    }

    public function index()
    {
        $this->data['main_content'] = 'Juniper/index';
        $this->data['page_title'] = 'Juniper Index';
        $this->data['header_title'] = 'Juniper Index';
        $this->load->view('Admin/template', $this-> data);
    }

    public function settings()
    {   
        //$this->data['currency'] = $this->Juniper_model->currencies();
        $this->data['moduleSetting'] = $this->App->service("ModuleService")->get("Juniper");
        $this->data['main_content'] = 'Juniper/settings';
        $this->data['page_title'] = 'Juniper Settings';
        $this->data['header_title'] = 'Juniper Settings';
        $this->load->view('Admin/template', $this->data);
    }

    public function update_settings()
    {
        $payload = $this->input->post();
        $this->App->service("ModuleService")->update('Juniper', 'apiConfig', $payload['apiConfig']);
        $this->App->service("ModuleService")->update('Juniper', 'settings', $payload['settings']);
        $this->App->service("ModuleService")->update('Juniper', 'database', $payload['database']);

        redirect(base_url('admin/juniper/settings'));
    }


    public function bookings()
    {
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_juniper_booking');
        $xcrud->columns('id, agentReferenceNumber, checkIn, checkOut, company_name, price, currency, status');
        $xcrud->order_by('id', 'desc');

        $xcrud->button(base_url('hotelsj/invoice/{id}'), 'View Invoice', 'fa fa-search-plus', 'btn btn-primary', array('target' => '_blank'));

        $this->data['add_link'] = '';
        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_edit();
        $xcrud->unset_print();
        $xcrud->unset_csv();

        $this->data['content'] = $xcrud->render();
        $this->data['main_content'] = 'Juniper/bookings';
        $this->data['table_name'] = 'pt_juniper_booking';
        $this->data['main_key'] = 'id';
        $this->data['page_title'] = 'Juniper Booking Management';
        $this->data['header_title'] ='Juniper Booking Management';

        $this->load->view('Admin/template', $this->data);
    }
}
