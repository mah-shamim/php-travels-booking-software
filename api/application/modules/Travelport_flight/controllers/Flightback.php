<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * Travelport Flight controller
 *
 * @category Backend
 */
class Flightback extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		// Access Checkpoint
		// Module enabled/disabled checkpoint
		// $chk = modules :: run('Home/is_main_module_enabled', 'travelport_flight');
		// if ( ! $chk) {
		// 	// backError_404($this->data);
		// }

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
		$this->data['page_title'] = 'Travelport Setting';
	}

	public function index()
	{
		$this->data['main_content'] = 'Travelport_flight/index';
		$this->load->view('Admin/template', $this->data);
	}

	public function settings()
	{
		$this->load->model('TravelportModel_Conf');
		$travelport = new TravelportModel_Conf();
		$travelport->load();
		$this->data['travelportConf'] = $travelport;
		$this->data['main_content'] = 'Travelport_flight/index';
		$this->load->view('Admin/template', $this->data);
	}

	/**
	 * Travelport bookings
	 * This is a partial view booking table which is dispaly on admin dashboard.
	 * @return html
	 */
	public function bookings()
	{
		$this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
		$xcrud->table('tport_reservation');
		$xcrud->columns('id, customer, phone, total_price, currency, access_token, createdAt');
		$xcrud->order_by('id', 'desc');

		$xcrud->label('id','ID');
		$xcrud->label('createdAt','Created At');

		$this->data['add_link'] = '';
        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_edit();
        $xcrud->unset_print();
        $xcrud->unset_csv();

		$this->data['content'] = $xcrud->render();
		$this->data['main_content'] = 'Travelport_flight/bookings';
        $this->data['table_name'] = 'tport_reservation';
        $this->data['main_key'] = 'id';
		$this->data['page_title'] = 'Travelport Booking Management';
        $this->data['header_title'] = 'Travelport Booking Management';

		$this->load->view('temp_view', $this->data);
	}

	/**
	 * Travelport bookings
	 * This is whole booking view which is linked to booking page in travelport flight menu.
	 * @return html
	 */
	public function booking()
	{
		$this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
		$xcrud->table('tport_reservation');
		$xcrud->columns('id, customer, phone, total_price, currency, access_token, createdAt');
		$xcrud->order_by('id', 'desc');

		$xcrud->label('id','ID');
		$xcrud->label('createdAt','Created At');

		$this->data['add_link'] = '';
        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_edit();
        $xcrud->unset_print();
        $xcrud->unset_csv();

		$this->data['content'] = $xcrud->render();
		$this->data['main_content'] = 'Travelport_flight/bookings';
        $this->data['table_name'] = 'tport_reservation';
        $this->data['main_key'] = 'id';
		$this->data['page_title'] = 'Travelport Booking Management';
		$this->load->view('Admin/template', $this->data);
	}
}
