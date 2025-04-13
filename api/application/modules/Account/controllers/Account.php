<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Account extends MX_Controller {
		private $loggedin;
	//	private $fbloggedin;
		private $validlang;

		function __construct() {
				parent :: __construct();

                $ci = get_instance();
                $version = implode("=>",(array)$ci->db->query('SELECT VERSION()')->result()[0]);
                if($version > 5.6)
                {
                $ci->db->query('SET SESSION sql_mode = ""');
                $ci->db->query('SET SESSION sql_mode =
                REPLACE(REPLACE(REPLACE(
                @@sql_mode,
                "ONLY_FULL_GROUP_BY,", ""),
                ",ONLY_FULL_GROUP_BY", ""),
                "ONLY_FULL_GROUP_BY", "")');
                }

				//$this->load->library('facebook');
				$this->data['app_settings'] = $this->Settings_model->get_settings_data();
				$langcode = $this->uri->segment(2);
                $this->validlang = pt_isValid_language($langcode);
                if($this->validlang){
                	$this->data['lang_set'] = $langcode;
                }else{
                	$this->data['lang_set'] = $this->session->userdata('set_lang');
                }


				$this->load->model('Admin/Accounts_model');
				$this->load->model('Admin/Countries_model');
				$this->load->model('Admin/Newsletter_model');
				$this->loggedin = $this->session->userdata('pt_logged_customer');
			//	$this->fbloggedin = $this->session->userdata('fb_token');

				$this->data['phone'] = $this->load->get_var('phone');
				$this->data['contactemail'] = $this->load->get_var('contactemail');
				$defaultlang = pt_get_default_language();
				if (empty ($this->data['lang_set'])) {
						$this->data['lang_set'] = $defaultlang;
				}

		}

		public function index() {
				$code = $this->input->get('code');
				if (empty ($this->loggedin)) {
						redirect(base_url() . 'login');
				}
				elseif (!empty ($code)) {
					//	$fbuser = $this->facebook->get_user();
						$fblogin = $this->Accounts_model->login_facebook($fbuser);
						if ($fblogin) {
								redirect(base_url() . 'account');
						}
						else {
								redirect(base_url() . 'login');
						}
				}
				else {
						$this->invoices();
				}
		}

		function invoices($offset = null) 
		{
			$this->load->helper('text');
			$this->lang->load("front", $this->data['lang_set']);

			//$this->data['fbuser'] = $this->facebook->get_user();
			//$perpage = 10;
			$this->data['allcountries'] = $this->Countries_model->get_all_countries();
			$this->data['profile'] = $this->Accounts_model->get_profile_details($this->loggedin);
			$rh = $this->Accounts_model->get_my_bookings($this->loggedin);
			$this->data['wishlist'] = $this->Accounts_model->my_wishlist($this->loggedin);



			if (pt_main_module_available('ean')) {
					$this->load->model('Ean/Ean_model');
					$this->data['eanbookings'] = $this->Ean_model->get_my_bookings($this->loggedin);
			}
			else {
					$this->data['eanbookings'] = "";
			}

			$this->data['travelportBookings'] = NULL;
			if (pt_main_module_available('travelport_flight')) 
			{
				$this->load->model('Travelport_flight/TravelportModel');
				$this->data['travelportBookings'] = $this->TravelportModel->get_bookings($this->loggedin);
			}

			/*Kiwitaxi Booking Show user account*/
			if (pt_main_module_available('Kiwitaxi')) 
			{
                $this->load->model('Kiwitaxi/Kiwitaxi_model');
				$this->data['kiwitaxiBookings']= $this->Kiwitaxi_model->get_bookings($this->loggedin);
			}




            $this->data['bookings'] = $this->Accounts_model->get_my_bookings($this->loggedin);
            $this->load->model('Hotelston/Hotelston_model');
            $this->data['HotelstonBookings']= $this->Hotelston_model->get_bookings($this->loggedin);
            //dd($this->data['HotelstonBookings']);
			$this->data['is_subscribed'] = $this->Newsletter_model->is_subscribed($this->data['profile'][0]->accounts_email);
			$this->data['cancel_duration'] = $this->data['app_settings'][0]->booking_cancellation * 86400;
			$this->data['langurl'] = base_url()."account/{langid}";
			$this->setMetaData("My Account");
			$this->theme->view('account/account', $this->data, $this);
		}

		function newsletter_action() {
				$action = $this->input->post('action');
				$email = $this->input->post('email');
				if (empty ($action)) {
						redirect(base_url());
				}
				else {
						if ($action == "add") {
								$this->Newsletter_model->add_subscriber($email);
						}
						elseif ($action == "remove") {
								$this->Newsletter_model->remove_subscriber($email);
						}
				}
		}

		function update_profile() {
				$password = $this->input->post('password');
				$cpassword = $this->input->post('confirmpassword');
				$oldemail = $this->input->post('oldemail');
				$newemail = $this->input->post('email');
// $this->form_validation->set_rules('firstname','First Name', 'trim|required');
//  $this->form_validation->set_rules('lastname','Last Name', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				if (!empty ($password)) {
						$this->form_validation->set_message('matches', 'Passwords not matching.');
						$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			    	$this->form_validation->set_rules('confirmpassword', 'Password', 'required|matches[password]');
				}
				if ($this->form_validation->run() == FALSE) {
						echo '
<div class="alert alert-danger">' . validation_errors() . '</div>
<br>';
				}
				else {
						if ($oldemail != $newemail) {
								$this->db->where('accounts_email', $newemail);
								$this->db->where('accounts_type', 'customer');
								$nums = $this->db->get('pt_accounts')->num_rows();
								if ($nums > 0) {
										echo '
<div class="alert alert-danger">Email Already Exists.</div>
';
								}
								else {
										$this->Accounts_model->change_email($this->loggedin);
										echo '
<div class="alert alert-success">Profile Updated Successfully.</div>
';
								}
						}
						else {
								$this->Accounts_model->update_profile_customer($this->loggedin);
								echo '
<div class="alert alert-success">Profile Updated Successfully.</div>
';
						}
				}
		}

//Wishlist actions
		function wishlist($action) {
			if(empty($this->loggedin)){
			$userid = $this->input->post('loggedin');
		}else{
			$userid = $this->loggedin;
		}

			if(!empty($userid)){

				if ($action == 'add') {
						$data = array(
							'wish_user' => $userid,
							'wish_itemid' => $this->input->post('itemid'),
							'wish_module' => $this->input->post('module'),
							'wish_date' => time());
						$this->db->insert('pt_wishlist', $data);
				}
				elseif ($action == 'remove') {
						$this->db->where('wish_user', $userid);
						$this->db->where('wish_itemid', $this->input->post('itemid'));
						$this->db->where('wish_module', $this->input->post('module'));
						$this->db->delete('pt_wishlist');
				}
				elseif ($action == 'single') {
						$this->db->where('wish_id', $this->input->post('id'));
						$this->db->delete('pt_wishlist');
				}
			}

			if(!empty($userid)){
				$result = array("isloggedIn" => TRUE);
			}else{
				$result = array("isloggedIn" => FALSE);
			}

			echo json_encode($result);

		}

// sign up functionality
		function signup() {
			$this->lang->load("front", $this->data['lang_set']);
				$this->form_validation->set_message('matches', 'Password not matching with confirm password.');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
				$this->form_validation->set_rules('confirmpassword', 'Password', 'required|matches[password]');
				$this->form_validation->set_rules('firstname', 'First name', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
						echo "<div class='alert alert-danger'>" . validation_errors() . "</div>";
				}
				else {
						$this->db->select('accounts_email');
						$this->db->where('accounts_email', $this->input->post('email'));
						$this->db->where('accounts_type', 'customers');
						$nums = $this->db->get('pt_accounts')->num_rows();
						if ($nums > 0) {
								echo "<div class='alert alert-danger'> Email Already Exists. </div>";
						}
						else {
							$allowed = $this->data['app_settings'][0]->user_reg_approval;
							if($allowed == "No"){
								$accStatus = "no";
								$response = "<div class='alert alert-success'> ".trans('0244')." </div>";
							}else{
								$accStatus = "yes";
								$response = "true";
							}

								$this->Accounts_model->signup_account('customers', $accStatus);
								$this->load->model('Admin/Emails_model');
								$fullname = $this->input->post('firstname') . " " . $this->input->post('lastname');
								$edata = array("email" => $this->input->post('email'), "fullname" => $fullname, "mobile" => $this->input->post('mobile'), "password" => $this->input->post('password'));
								if($accStatus == "no"){
								$this->Emails_model->new_customer_email($edata);
								$this->Emails_model->customer_signup($edata);
							}else{

								$this->Emails_model->signupEmail($edata);

							}




// $this->session->set_userdata('pt_logged_customer',$id);
								echo $response;
						}
				}
		}

		function addreview() {
				$this->load->model('Admin/Reviews_model');
				$addrev = $this->input->post('addreview');
				if (empty ($addrev)) {
						redirect('account');
				}
				$this->form_validation->set_rules('reviews_comments', 'Comment', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
						echo '
<div class="alert alert-danger"><i class="fa fa-times-circle"></i> ' . validation_errors() . '</div>
<br>';
				}
				else {
						$this->Reviews_model->add_review_cust($this->data['app_settings'][0]->reviews);
						echo "done";
				}
		}

//cancel booking
		function cancelbooking() {
				$data = array('booking_cancellation_request' => 1);
				$this->db->where('booking_id', $this->input->post('id'));
				$this->db->update('pt_bookings', $data);
// send email for request cancellation
				$useremail = $this->Accounts_model->get_user_email($this->loggedin);
				$this->load->model('Admin/Emails_model');
				$this->Emails_model->booking_request_cancellation_email($useremail, $this->input->post('id'));
		}

		function resetpass() {
				$email = $this->input->post('email');
				$this->db->where('accounts_email', $email);
				$this->db->where('accounts_type', 'customers');
				$check = $this->db->get('pt_accounts')->num_rows();
				if ($check > 0) {
						$newpass = random_string('alnum', 8);
						$updata = array('accounts_password' => sha1($newpass));
						$this->db->where('accounts_email', $email);
						$this->db->where('accounts_type', 'customers');
						$this->db->update('pt_accounts', $updata);
						$this->load->model('Admin/Emails_model');
						echo "1";
						$this->Emails_model->reset_password($email, $newpass);
				}
				else {
						echo "0";
				}
		}

		function resetpassadmin() {
				$email = $this->input->post('email');
				$this->db->where('accounts_email', $email);
				$this->db->where('accounts_type', 'webadmin');
				$check = $this->db->get('pt_accounts')->num_rows();
				if ($check > 0) {
						$newpass = random_string('alnum', 8);
						$updata = array('accounts_password' => sha1($newpass));
						$this->db->where('accounts_email', $email);
						$this->db->where('accounts_type', 'webadmin');
						$this->db->update('pt_accounts', $updata);
						$this->load->model('Admin/Emails_model');
						echo "1";
						$this->Emails_model->reset_password($email, $newpass);
				}
				else {
						echo "0";
				}
		}

		function resetpasssupplier() {
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
						echo "1";
						$this->Emails_model->reset_password($email, $newpass);
				}
				else {
						echo "0";
				}
		}

		function _remap($method, $params=array()){
		$funcs = get_class_methods($this);
		if(in_array($method, $funcs)){

		return call_user_func_array(array($this, $method), $params);

		}else{

			$result = checkUrlParams($method, $params,$this->validlang);
			if($result->showIndex){
			$this->index();
			}



		}

		}

		function logout() {

				$this->session->unset_userdata('pt_logged_customer');
				$this->session->unset_userdata('fname');
				$this->session->unset_userdata('lname');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('pt_role');
				
				//$this->load->library('facebook');
			//	$this->facebook->logoutfb();
				redirect(base_url() . 'login','refresh');
		}

}
