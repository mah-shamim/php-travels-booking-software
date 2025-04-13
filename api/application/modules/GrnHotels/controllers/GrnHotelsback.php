<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GrnHotelsback extends MX_Controller {

    const MODULE = "GrnHotels";


    function __construct(){
        parent::__construct();
        $method_segment = $this->uri->segment(3);
        // Access Checkpoint
        // Module enabled/disabled checkpoint
        $chk = $this->App->service('ModuleService')->isActive(self::MODULE);
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

            $this->data['adminsegment'] = "admin";
        $this->load->helper('xcrud');


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
        $this->data['page_title'] = 'GrnHotels Setting';
    }

    function index(){

    }


    public function settings()
    {
        $this->data['moduleSetting'] = $this->App->service("ModuleService")->get(self::MODULE);
        $this->data['main_content'] = self::MODULE.'/settings';
        $this->data['page_title'] = self::MODULE.' Settings';
        $this->data['header_title'] = self::MODULE.' Settings';
        $this->load->view('Admin/template', $this->data);
    }

    public function update_settings()
    {
        $payload = $this->input->post();
        $this->App->service("ModuleService")->update('GrnHotels', 'apiConfig', $payload['apiConfig']);
        $this->App->service("ModuleService")->update('GrnHotels', 'database', $payload['database']);

        redirect(base_url('admin/grnhotels/settings'));
    }

    public function bookings(){
        $xc = xcrud_get_instance();
        $xc->table('grn_bookings');
        $xc->columns(array('hotel_name','room_name','hotel_price','card_name'));
        $xc->nested_table('Accounts','id','grn_booking_accounts','booking_id'); // 2nd level
        $xc->order_by('id', 'desc');
        $this->data['content'] = $xc->render();
        $this->data['page_title'] = 'Hotels Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'grn_bookings';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Hotels Management';
        $this->load->view('Admin/template', $this->data);
    }


    }
