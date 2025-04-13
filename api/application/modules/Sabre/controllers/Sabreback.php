<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Sabreback extends MX_Controller {  

	public function __construct()
    {
        parent::__construct();
        $method_segment = $this->uri->segment(3);
        // Access Checkpoint
        // Module enabled/disabled checkpoint
        $chk = $this->App->service('ModuleService')->isActive('sabre');
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
        $this->data['page_title'] = 'Sabre Setting';
	}
	
	public function index()
    {
        $this->data['main_content'] = 'Sabre/index';
        $this->data['page_title'] = 'Sabre Index';
        $this->data['header_title'] = 'Sabre Index';
        $this->load->view('Admin/template', $this->data);
    }

    public function settings()
    {
        $this->data['moduleSetting'] = $this->App->service("ModuleService")->get("sabre");
        $this->data['main_content'] = 'Sabre/settings';
        $this->data['page_title'] = 'Sabre Settings';
        $this->data['header_title'] = 'Sabre Settings';
        $this->load->view('Admin/template', $this->data);
    }

    public function update_settings()
    {
        $payload = $this->input->post();
        $this->App->service("ModuleService")->update('sabre', 'apiConfig', $payload['apiConfig']);
        $this->App->service("ModuleService")->update('sabre', 'settings', $payload['settings']);
        redirect(base_url('admin/sabre/settings'));
	}
	
	public function bookings()
    {
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('sabre_bookings');
        $xcrud->columns('data', true);
        $xcrud->unset_add();
        $xcrud->unset_edit();
        $xcrud->unset_remove();
        $xcrud->unset_view();
        $xcrud->unset_print();
        $xcrud->unset_csv();
        $xcrud->label('PNR', 'PNR');
        $xcrud->button(base_url('sabre/get_invoice?pnr={PNR}'), 'View Invoice', 'fa fa-search-plus', 'btn btn-primary', ['target' => '_blank']);
        $this->data['content'] = $xcrud->render();
        $this->data['main_content'] = 'Sabre/bookings';
        $this->data['page_title'] = 'Sabre Bookings';
        $this->data['table_name'] = 'sabre_bookings';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Sabre Bookings';
        $this->load->view('Admin/template', $this->data);
    }

    public function continents()
    {
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('sabre_continents');
        $xcrud->columns('name, regional_fee, administration_fee, currency');
        $xcrud->fields('created_at', true);
        $xcrud->unset_view();
        $xcrud->unset_print();
        $xcrud->unset_csv();
        $this->data['content'] = $xcrud->render();
        $this->data['main_content'] = 'Sabre/continents';
        $this->data['page_title'] = 'Continents';
        $this->data['table_name'] = 'sabre_continents';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Continents Management';
        $this->load->view('Admin/template', $this->data);
    }

    public function airports()
    {
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_flights_airports');
        $xcrud->columns('name, code, cityName, countryName, continent_id');
        $xcrud->fields('name, code, cityName, countryName, continent_id', false);
        $xcrud->unset_add();
        $xcrud->unset_remove();
        $xcrud->unset_view();
        $xcrud->unset_print();
        $xcrud->unset_csv();
        $xcrud->column_callback('continent_id', 'getContinentName');
        $this->data['content'] = $xcrud->render();
        $this->data['main_content'] = 'temp_view';
        $this->data['page_title'] = 'Airports';
        $this->data['table_name'] = 'pt_flights_airports';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Airports Management';
        $this->load->view('Admin/template', $this->data);
    }
}
