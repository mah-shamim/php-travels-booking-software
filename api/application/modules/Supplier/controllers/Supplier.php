<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Supplier extends MX_Controller {
		private $abc;
		private $def;
		public $userid;
        public $role;

		function __construct() {
			
				$this->data['app_settings'] = $this->Settings_model->get_settings_data();
				$this->userid = $this->session->userdata('pt_logged_id');
				$this->role = $this->session->userdata('pt_role');
				$this->data['accType'] = $this->session->userdata('pt_accountType');

				$this->load->helper('date');
				$this->load->helper('pt_includes');
				$this->load->model('Helpers_models/Translation_model');
				$this->load->model('Helpers_models/Misc_model');
				$this->load->model('Helpers_models/Menus_model');
				$this->load->model('Admin/Countries_model');
				$this->load->model('Admin/Accounts_model');
				$this->load->model('Admin/Cms_model');
				$this->load->model('Admin/Modules_model');
				$this->load->model('Admin/Newsletter_model');
				$this->load->model('Hotels/Hotels_model');
				$this->load->model('Hotels/Rooms_model');
				$this->load->model('Supplier/Supplier_accounts_model');
				$this->load->model('Supplier/Supplier_hotel_model');
				$this->load->model('Supplier/Supplier_room_model');
				$this->data['issupplier'] = $this->session->userdata('pt_logged_supplier');

				$this->data['role'] = $this->role;
				$this->data['fullName'] = $this->session->userdata('fullName');
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');

				$this->lang->load("back", "en");

//$this->system();
		}

		public function index() {
//$this->system_resp();
				if ($this->validsupplier()) {
						$addnotes = $this->input->post('addnotes');
						$this->data['canQuickBook'] = pt_permissions("addbooking", $this->data['userloggedin']);
						$updatenotes = $this->input->post('updatenotes');
						if (!empty ($updatenotes)) {
								$this->Accounts_model->update_admin_notes($this->data['issupplier']);
						}
						elseif (!empty ($addnotes)) {
								$this->Accounts_model->add_admin_notes($this->data['issupplier']);
						}

						$this->data['quickmodules'] = $this->Modules_model->get_module_names();
						$this->data['chklib'] = $this->ptmodules;

// booking reports. 
$this->data['pendingCount'] = modules::run('Supplier/reports/pendingbCount', 'pending');
$this->data['confirmedCount'] = modules::run('Supplier/reports/confirmedbCount', 'confirmed');
$this->data['cancelledCount'] = modules::run('Supplier/reports/cancelledbCount', 'cancelled');
$this->data['paidCount'] = modules::run('Supplier/reports/paidbCount', 'paid');
$this->data['unpaidCount'] = modules::run('Supplier/reports/unpaidbCount', 'unpaid');
$this->data['refundedCount'] = modules::run('Supplier/reports/refundedbCount', 'refunded');
//End Reports Code
						$this->data['notes'] = $this->Accounts_model->admin_notes_image($this->data['issupplier']);
						$this->data['mainmodules'] = $this->Modules_model->get_module_names();
						$this->data['modules'] = $this->Modules_model->get_all_enabled_modules();
						$this->data['stats'] = "";//$this->Supplier_accounts_model->supplier_dashboard_stats($this->data['issupplier']);
						$this->data['main_content'] = 'Admin/dashboard/dashboard';
						$this->data['page_title'] = 'Dashboard';
						$this->load->view('Admin/template', $this->data);
				}
				else {
//secure login check
						$slogin = $this->secure_url();
						$skey = $this->secure_key();
						if ($slogin) {
								$key = $this->input->get('s');
								if (!empty ($key)) {
										if ($skey) {
												$this->data['pagetitle'] = 'Supplier Login';
												$this->load->view('Admin/login', $this->data);
										}
										else {
												Error_404($this);
										}
								}
								else {
										Error_404($this);
								}
						}
						else {
								$this->data['pagetitle'] = 'Supplier Login';
								$this->load->view('Admin/login', $this->data);
						}
				}
		}

		function login() {
				$username = $this->input->post('email');
				$password = $this->input->post('password');
				if ($this->input->is_ajax_request()) {

					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
						$this->form_validation->set_rules('password', 'Password', 'required');

						if ($this->form_validation->run() == FALSE) {

							$result = array("status" => false, "msg" => validation_errors(), "url" => "");
						}else{

							$login = $this->Accounts_model->login_supplier($username, $password);
						if ($login) {
							$prevurl = $this->session->userdata('prevURL');
							if(!empty($prevurl)){
								$url = $prevurl;
							}else{
								$url = base_url().'supplier';
							}

							$result = array("status" => true, "msg" => "", "url" => $url);
						}
						else {
							$result = array("status" => false, "msg" => "Invalid Login Credentials", "url" => "");

						}

						}
						echo json_encode($result);


				}
		}

	function resetpass(){

				$email = $this->input->post('email');
				$this->db->where('accounts_email', $email);
				$this->db->where('accounts_type', 'supplier');
				$check = $this->db->get('pt_accounts')->num_rows();

				if ($check > 0) {
						$newpass = random_string('alnum', 8);
						$updata = array('accounts_password' => sha1($newpass));
						$this->db->where('accounts_email', $email);
						$this->db->where('accounts_type', 'supplier');
						$this->db->update('pt_accounts', $updata);
						$this->load->model('Admin/Emails_model');
						$this->Emails_model->reset_password($email, $newpass);
				}
				echo $check;
		}

		function profile() {
if ($this->validsupplier()) {
          $update = $this->input->post('update');
          $subs = $this->input->post('newssub');
          $email = $this->input->post('email');
          if(!empty($update)){

             $updateResult = $this->__updateProfile($this->userid);
            if($updateResult->noError){

            if(!empty($subs)){
               $this->Newsletter_model->add_subscriber($email, $this->input->post('type'));
            }else{
               $this->Newsletter_model->remove_subscriber($email);
            }
             $this->session->set_flashdata('flashmsgs', 'Profile Updated');

             $this->data['msg'] = "";
             redirect('supplier/profile','refresh');

          }else{


          	 $this->data['msg'] = "<div class='alert alert-danger'>".$updateResult->msg."</div>";


          }


          }

          $this->data['profile'] = $this->Accounts_model->get_profile_details($this->userid);
          $this->data['isSubscribed'] = $this->Newsletter_model->is_subscribed($this->data['profile'][0]->accounts_email);
          $this->data['countries'] = $this->Countries_model->get_all_countries();
          $this->data['main_content'] = 'accounts/profile';
          $this->data['page_title'] = 'My Profile';
          $this->load->view('Admin/template', $this->data);
		}else{
			redirect('supplier');
		}

		}

//secure login check
		function secure_url() {
				$this->db->where('secure_supplier_status', '1');
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->num_rows();
				if ($res > 0) {
						return true;
				}
				else {
						return false;
				}
		}

//secure login url key
		function secure_key() {
				$this->db->where('secure_supplier_key', $this->input->get('s'));
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->num_rows();
				if ($res > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// is valid supplier
		function validsupplier() {
				if (!empty ($this->data['issupplier'])) {
						return true;
				}
				else {
						return false;
				}
		}

//supplier items
		function myitems() {
				$supplier = $this->data['issupplier'];
				$myitems = array();
				$this->db->select('hotel_id');
				$this->db->where('hotel_owned_by', $supplier);
				$rs = $this->db->get('pt_hotels')->result();
				foreach ($rs as $r) {
						array_push($myitems, $r->hotel_id);
				}
				$this->db->select('tour_id');
				$this->db->where('tour_owned_by', $supplier);
				$trs = $this->db->get('pt_tours')->result();
				foreach ($trs as $tr) {
						array_push($myitems, $tr->tour_id);
				}
                $this->db->select('rental_id');
                $this->db->where('rental_owned_by', $supplier);
                $trs = $this->db->get('pt_rentals')->result();
                foreach ($trs as $tr) {
                    array_push($myitems, $tr->tour_id);
                }
				$this->db->select('car_id');
				$this->db->where('car_owned_by', $supplier);
				$crs = $this->db->get('pt_cars')->result();
				foreach ($crs as $cr) {
						array_push($myitems, $cr->car_id);
				}

				return $myitems;
		}

//logout
		function logout() {
				$lastlogin = $this->session->userdata('pt_logged_time');
				$updatelogin = array('accounts_last_login' => $lastlogin);
				$this->db->where('accounts_id', $this->data['issupplier']);
				$this->db->update('pt_accounts', $updatelogin);
				$this->session->sess_destroy();
				redirect('supplier');
		}



// hotels module controller
		function hotels($args = null, $id = null, $roomid = null) {
				$hotelsmod = modules :: load('hotels/hotelsback/');
				if (!method_exists($hotelsmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$hotelsmod->index();
				}
				elseif ($args == "add") {
						$hotelsmod->add();
				}
				elseif ($args == "manage") {
						$hotelsmod->manage($id);
				}
				elseif ($args == "extras") {
						$hotelsmod->extras($id);
				}
                elseif ($args == "gallery") {
						$hotelsmod->gallery($id);
				}
                elseif ($args == "roomgallery") {
						$hotelsmod->roomgallery($id);
				}
				elseif ($args == "translate") {
						$hotelsmod->translate($id, $roomid);
				}
				elseif ($args == "rooms") {
						$hotelsmod->rooms($id, $roomid);
				}elseif ($args == "room_calender") {
					$room_calender = modules :: load('hotels/room_Calender');
					$room_calender->index($id);
			}
		}

// cars module controller
		function cars($args = null, $id = null) {
				$carsmod = modules :: load('cars/carsback/');
				if (!method_exists($carsmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$carsmod->index();
				}
				elseif ($args == "add") {
						$carsmod->add();
				}
				elseif ($args == "settings") {
						$carsmod->settings();
				}
				elseif ($args == "manage") {
						$carsmod->manage($id);
				}
				elseif ($args == "extras") {
						$carsmod->extras($id);
				}
                elseif ($args == "gallery") {
						$carsmod->gallery($id);
				}
				elseif ($args == "translate") {
						$carsmod->translate($id, $lang);
				}
		}

// Tours module controller
		function tours($args = null, $id = null) {
				$toursmod = modules :: load('tours/toursback/');
				if (!method_exists($toursmod, 'index')) {
						redirect('supplier');
				}
				if ($args == "") {
						$toursmod->index();
				}
				elseif ($args == "add") {
						$toursmod->add();
				}
				elseif ($args == "settings") {
						$toursmod->settings();
				}
				elseif ($args == "manage") {
						$toursmod->manage($id);
				}
				elseif ($args == "extras") {
						$toursmod->extras($id);
				}
                elseif ($args == "gallery") {
						$toursmod->gallery($id);
				}
				elseif ($args == "translate") {
						$toursmod->translate($id, $lang);
				}
		}


    // Rentals module controller
    function rentals($args = null, $id = null, $lang = null) {
        $rentalsmod = modules::load('rentals/rentalsback/');
        if (!method_exists($rentalsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $rentalsmod->index();
        } elseif ($args == "add") {
            $rentalsmod->add();
        } elseif ($args == "dates") {
            $rentalsmod->dates();
        } elseif ($args == "settings") {
            $rentalsmod->settings();
        } elseif ($args == "manage") {
            $rentalsmod->manage($id);
        } elseif ($args == "extras") {
            $rentalsmod->extras($id);
        } elseif ($args == "reviews") {
            $rentalsmod->reviews($id);
        } elseif ($args == "gallery") {
            $rentalsmod->gallery($id);
        } elseif ($args == "translate") {
            $rentalsmod->translate($id, $lang);
        }
    }

		public function __updateProfile($id){

		$profileResult = new stdClass;
        $profileResult->noError = TRUE;

        $now = date("Y-m-d H:i:s");


        $oldphoto = $this->input->post('oldphoto');
        if ($filename != null) {
            $filename = $filename;
            if (!empty ($oldphoto)) {
                unlink(PT_USERS_IMAGES_UPLOAD . $oldphoto);
            }
        }
        else {
            $filename = "";
        }
        $data = array('ai_title' => $this->input->post('title'),
        'ai_first_name' => $this->input->post('fname'),
        'ai_last_name' => $this->input->post('lname'),
        'ai_city' => $this->input->post('city'),
        'ai_state' => $this->input->post('state'),
        'ai_country' => $this->input->post('country'),
        'ai_address_1' => $this->input->post('address1'),
        'ai_address_2' => $this->input->post('address2'),
        'ai_mobile' => $this->input->post('mobile'),
        'ai_image' => $filename,
        'accounts_updated_at' => $now);
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);

        $oldemail = $this->input->post('oldemail');
        $newemail = $this->input->post('email');
        $password = $this->input->post('password');
        if ($oldemail != $newemail) {
            $this->db->select('accounts_email');
            $this->db->where('accounts_email', $newemail);
            $this->db->where('accounts_type', 'supplier');
            $nums = $this->db->get('pt_accounts')->num_rows();
            if ($nums > 0) {
              $profileResult->msg = "Email Already Exists";
              $profileResult->noError = FALSE;
            }
            else {
                $this->Accounts_model->change_email($id);
                 $profileResult->noError = TRUE;
            }
        }

        if (!empty ($password)) {
            $this->Accounts_model->change_password($id);
        }


        return $profileResult;
		}


		function locations($args = null, $id = null){


			$loc =  modules :: load('Admin/locations');
			if(empty($args)){
				echo $loc->index();

			}elseif($args == "add"){

				echo $loc->add();
			}elseif($args == "edit"){

				echo $loc->edit($id);
			}


        }


}
