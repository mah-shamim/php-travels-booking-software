<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Boatajaxcalls extends MX_Controller {

		public $isadmin;

		function __construct() {

				$this->load->model('Boats/Boats_model');
				$this->isadmin = $this->session->userdata('pt_logged_admin');
		}

	function makethumb() {
				$newthumb = $this->input->post('imgname');
				$boatid = $this->input->post('itemid');

				$this->Boats_model->updateboatThumb($boatid, $newthumb,"update");

		}

		function delTypeSettings(){
          $id = $this->input->post('id');
          $this->Boats_model->deleteTypeSettings($id);
        }

             // delete multiple settings
   function delMultiTypeSettings($type){

    $items = $this->input->post('items');

          foreach($items as $item){
          $this->Boats_model->deleteMultiplesettings($item,$type);
          }

   }

		// Delete boat
        function delboat(){
          $id = $this->input->post('id');
          $this->Boats_model->delete_boat($id);
        }



// Delete Multiple boats
        function delMultipleboats(){
          $items = $this->input->post('items');
          foreach($items as $item){
          	$this->Boats_model->delete_boat($item);
          }


        }


// Delete Single boat

		public function delete_single_boat() {
				$boatid = $this->input->post('boatid');
				$this->Boats_model->delete_boat($boatid);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}
// update boat map order

		public function update_map_order() {
				$mapid = $this->input->post('id');
				$order = $this->input->post('order');
				$this->Boats_model->update_map_order($mapid, $order);
		}
// update boat order

		public function update_boat_order() {
		  $boatid = $this->input->post('id');
		  $order = $this->input->post('order');
		  $this->db->select('boat_id');
          $total = $this->db->get('pt_boats')->num_rows();

          if($order > $total){
            echo '0';
          }else{
          $this->Boats_model->update_boat_order($boatid, $order);
            echo '1';
          }

		}


		// update Images order

		public function update_image_order() {
				$imgid = $this->input->post('id');
				$order = $this->input->post('order');
				$this->Boats_model->update_image_order($imgid, $order);
                echo "1";
		}


// Disable multiple boats

		public function disable_multiple_boats() {
				$boatlist = $this->input->post('boatlist');
				foreach ($boatlist as $boatid) {
						$this->Boats_model->disable_boat($boatid);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}
// Enable multiple boats

		public function enable_multiple_boats() {
				$boatlist = $this->input->post('boatlist');
				foreach ($boatlist as $boatid) {
						$this->Boats_model->enable_boat($boatid);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}


// update featured boat option
		function update_featured() {
			if(!empty($this->isadmin )){
				$this->Boats_model->update_featured();
				echo "done";
			}

		}

// boat Add to map
		function add_boat_map() {
				$this->Boats_model->add_to_map();
		}

// Update boat map
		function update_boat_map() {
				$this->Boats_model->update_boat_map();
		}

// Delete multiple map items
		function delete_multiple_map_items() {
				$mapids = $this->input->post('maplist');
				foreach ($mapids as $id) {
						$this->Boats_model->delete_map_item($id);
				}
		}

// Delete Single map item
		function delete_single_map_item() {
				$id = $this->input->post('mapid');
				$this->Boats_model->delete_map_item($id);
		}

		function delete_image() {
				$imgname = $this->input->post('imgname');
				$boatid = $this->input->post('itemid');
				$imgid = $this->input->post('imgid');
				$this->Boats_model->delete_image($imgname,$imgid,$boatid);
		}

		        function deleteMultipleboatImages(){
          $data = $this->input->post('imgids');
          foreach($data as $d){
                $this->Boats_model->delete_image($d['imgname'],$d['imgid'],$d['itemid']);
          }


        }


		function app_rej_timages() {
				$this->Boats_model->approve_reject_images();
		}


// Add boat settings data
		function add_boat_settings() {
				$this->Boats_model->add_settings_data();
		}

// update boat settings data
		function update_boat_settings() {
				$this->Boats_model->update_settings_data();
		}

// delete multiple settings
		function delete_multiple_settings() {
				$idlist = $this->input->post('idlist');
				foreach ($idlist as $id) {
						$this->Boats_model->delete_settings($id);
				}
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}

// delete multiple settings
		function delete_single_settings() {
				$id = $this->input->post('id');
				$this->Boats_model->delete_settings($id);
				$this->session->set_flashdata('flashmsgs', "Deleted Successfully");
		}

// disable multiple settings
		function disable_multiple_settings() {
				$idlist = $this->input->post('idlist');
				foreach ($idlist as $id) {
						$this->Boats_model->disable_settings($id);
				}
				$this->session->set_flashdata('flashmsgs', "Disabled Successfully");
		}

// enable multiple settings
		function enable_multiple_settings() {
				$idlist = $this->input->post('idlist');
				foreach ($idlist as $id) {
						$this->Boats_model->enable_settings($id);
				}
				$this->session->set_flashdata('flashmsgs', "Enabled Successfully");
		}


//process booking
		function process_booking_guest() {
				$this->load->model('bookings_model');
				$this->form_validation->set_message('matches', 'Email not matching with confirm email.');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('confirmemail', 'Email', 'required|matches[email]');
				$this->form_validation->set_rules('firstname', 'First name', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
						echo validation_errors();
				}
				else {
						echo "";
						$this->Bookings_model->do_guest_booking();
				}
		}

		function process_booking_logged() {
				$this->load->model('bookings_model');
				$user = $this->session->userdata('pt_logged_customer');
				echo "";
				$this->Bookings_model->do_booking($user);
		}

		function process_booking_login() {
				$this->load->model('bookings_model');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				if ($this->input->is_ajax_request()) {
						echo $this->Bookings_model->do_login_booking($username, $password);
				}
		}

		function process_booking_signup() {
				$this->load->model('bookings_model');
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
								$this->Bookings_model->do_customer_booking();
								echo "";
						}
				}
/*

$this->load->model('bookings_model');

$vars = $this->input->post();
$this->form_validation->set_message('is_unique', 'Email Already exists.');
$this->form_validation->set_message('matches', 'Passwords not matching.');
$this->form_validation->set_rules('email','Email', 'required|valid_email|is_unique[pt_accounts.accounts_email]');
$this->form_validation->set_rules('firstname','First name', 'trim|required');
$this->form_validation->set_rules('lastname','Last Name', 'trim|required');
$this->form_validation->set_rules('password','Password', 'required|min_length[6]|matches[confirmpassword]');


if($this->form_validation->run() == FALSE)
{

echo  validation_errors();

}else{

$this->Bookings_model->do_customer_booking();

}*/
		}


		function onChangeLocation(){
			$this->load->library('Boats/Boats_lib');
			$location = $this->input->post('location');
			$response = $this->Boats_lib->getboatTypesLocationBased($location);
			echo json_encode($response);
		}

		function changeInfo(){
			$this->load->library('Boats/Boats_lib');
			$boatid = $this->input->post('boatid');

			$adults = $this->input->post('adults');
			$child = $this->input->post('child');
			$infants = $this->input->post('infants');

			$response = $this->Boats_lib->updatedPrice($boatid, $adults, $child, $infants);
			echo $response;
		}

		function boatExtrasBooking(){
        $this->load->library('Boats/Boats_lib');
        $boatid = $this->input->post('itemid');
        $adults = $this->input->post('adults');
        $child = $this->input->post('children');
        $infant = $this->input->post('infant');
        $extras = $this->input->post('extras');


        echo $this->Boats_lib->getUpdatedDataBookResultObject($boatid,$adults,$child,$infant,$extras);


       }

}
