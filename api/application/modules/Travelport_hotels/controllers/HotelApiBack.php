<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class HotelApiBack extends MX_Controller
{
    public function __construct()
	{
		parent::__construct();
		// if ( ! pt_module_has_enable('hotelport') ) {
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
        $this->load->model('TravelportHotelModel_Conf');
        $travelport = new TravelportHotelModel_Conf();
        $travelport->load();
        $this->data['travelportConf'] = $travelport;
		$this->data['main_content'] = 'Travelport_hotels/index';
		$this->load->view('Admin/template', $this->data);
	}

	public function settings()
	{
		$this->load->model('TravelportHotelModel_Conf');
		$travelport = new TravelportHotelModel_Conf();
        $travelport->load();
        $this->data['travelportConf'] = $travelport;
		$this->data['main_content'] = 'Travelport_hotels/index';
		$this->load->view('Admin/template', $this->data);
    }
    
    /**
	 * Travelport bookings
	 *
	 * @return html
	 */
	public function bookings()
	{
		$this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
		$xcrud->table('pt_hotelport_bookings');
		$xcrud->columns('hotel_name, hotel_location, room_name, checkin, checkout, total_nights, total_amount, currency_code, created_at');
		$xcrud->button(base_url('hotelport/invoice/{id}'), 'View Invoice', 'fa fa-search-plus', 'btn btn-primary', array('target' => '_blank'));
		$this->data['add_link'] = '';
        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_edit();
        $xcrud->unset_print();
        $xcrud->unset_csv();

		$this->data['content'] = $xcrud->render();
		$this->data['main_content'] = 'travelport_hotels/bookings';
		$this->data['page_title'] = 'Travelport Booking Management';
        $this->data['header_title'] = 'Travelport Booking Management';

		$this->load->view('Admin/template', $this->data);
	}
}