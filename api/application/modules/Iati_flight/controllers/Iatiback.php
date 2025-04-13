<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**

 * Iati Flight controller

 *

 * @category Frontend

 */

class Iatiback extends MX_Controller {

    public function __construct(){

		parent::__construct();

		$method_segment = $this->uri->segment(3);

        // Access Checkpoint

        // Module enabled/disabled checkpoint

        $chk = $this->App->service('ModuleService')->isActive('iati_flight');

        if ( ! $chk && !in_array($method_segment, ['update_settings','settings'])) {

            backError_404($this->data);

            redirect('/admin');

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

		$this->data['page_title'] = 'Iati Flight Setting';

    }



    public function index(){

        $this->data['main_content'] = 'index';

        $this->load->view('Admin/template', $this->data);

    } 



    public function settings(){

		$set_date = date('Y-m-d');

		$from = date('Y-m-d', strtotime($set_date .' +1 day'));

		$to = date('Y-m-d', strtotime($set_date .' +2 day'));

		$this->data['authCode'] = $this->App->service("ModuleService")->get("iati_flight")->apiConfig->authCode;

		$this->data['from'] = $this->App->service("ModuleService")->get("iati_flight")->defaultSettings->from;

		$this->data['to'] = $this->App->service("ModuleService")->get("iati_flight")->defaultSettings->to;

		$this->data['departure'] = $from;

		$this->data['arrival'] = $to;

        $this->data['main_content'] = 'index';

        $this->load->view('Admin/template', $this->data);

    }



	public function update_settings(){

        $this->App->service("ModuleService")->update("iati_flight", "apiConfig", $_POST['apiConfig']);

		$this->App->service("ModuleService")->update("iati_flight", "defaultSettings", $_POST['defaultSettings']);

		redirect('admin/flightsi/settings');

	}

    

    public function bookings(){

		$this->load->helper('xcrud');

        $xcrud = xcrud_get_instance();

		$xcrud->table('pt_iati_bookings');
		
		$xcrud->columns('passengers,base_fare,tax,service_fee,total_price,currency,pnr,order_id,created_at');
		$xcrud->column_callback('passengers', 'iati_passengers_list');
		$xcrud->column_callback('pnr', 'iati_invoice');

        $xcrud->unset_add();

        $xcrud->unset_view();

        $xcrud->unset_edit();

        $xcrud->unset_print();

        $xcrud->unset_csv();

		$this->data['content'] = $xcrud->render();

		$this->data['main_content'] = 'bookings';
        $this->data['table_name'] = 'pt_iati_bookings';
        $this->data['main_key'] = 'id';

        $this->load->view('Admin/template', $this->data);

	}



}