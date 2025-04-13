<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carajaxcalls extends MX_Controller {

    public $isadmin;
	function __construct(){

     $this->load->model('Cars/Cars_model');
     $this->isadmin = $this->session->userdata('pt_logged_admin');

   }

function makethumb() {
        $newthumb = $this->input->post('imgname');
        $carid = $this->input->post('itemid');

        $this->Cars_model->updateCarThumb($carid, $newthumb,"update");

    }
     // delete multiple cars
     public function delete_multiple_cars(){
          $carlist = $this->input->post('carlist');

          foreach($carlist as $carid){

     $this->Cars_model->delete_car($carid);

          }

      $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

    // Delete Car
        function delCar(){
          $id = $this->input->post('id');
          $this->Cars_model->delete_car($id);
        }

// Delete Multiple Cars
        function multiDelCars(){
          $items = $this->input->post('items');
          foreach($items as $item){
             $this->Cars_model->delete_car($item);
          }


        }

        function delTypeSettings(){
          $id = $this->input->post('id');
          $this->Cars_model->deleteTypeSettings($id);
        }


    // Delete Single car
    public function delete_single_car(){
      $carid = $this->input->post('carid');
   $this->Cars_model->delete_car($carid);
     $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

    }


        // update car map order
	public function update_map_order(){
           $mapid = $this->input->post('id');
          $order = $this->input->post('order');

          $this->Cars_model->update_map_order($mapid,$order);

    }

    // update car order
	public function update_car_order(){
      $carid = $this->input->post('id');
      $order = $this->input->post('order');
      $this->db->select('car_id');
          $total = $this->db->get('pt_cars')->num_rows();

          if($order > $total){
            echo '0';
          }else{
          $this->Cars_model->update_car_order($carid, $order);
            echo '1';
          }


    }


      // update Images order
	public function update_image_order(){
           $imgid = $this->input->post('id');
          $order = $this->input->post('order');

          $this->Cars_model->update_image_order($imgid,$order);
          echo "1";

    }




    // Disable multiple cars
	public function disable_multiple_cars(){
          $carlist = $this->input->post('carlist');

          foreach($carlist as $carid){
          $this->Cars_model->disable_car($carid);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");


    }

     // Enable multiple cars
	public function enable_multiple_cars(){
          $carlist = $this->input->post('carlist');

          foreach($carlist as $carid){
          $this->Cars_model->enable_car($carid);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");


    }



   // update featured car option
    function update_featured(){
      if(!empty($this->isadmin )){
    $this->Cars_model->update_featured();
    echo "done";
  }

    }


   // car Add to map
   function add_car_map(){
     $this->Cars_model->add_to_map();
   }

      // Update car map
   function update_car_map(){
     $this->Cars_model->update_car_map();
   }

   // Delete multiple map items
   function delete_multiple_map_items(){
    $mapids = $this->input->post('maplist');
    foreach($mapids as $id){
      $this->Cars_model->delete_map_item($id);
    }
   }

   // Delete Single map item
   function delete_single_map_item(){
      $id = $this->input->post('mapid');
     $this->Cars_model->delete_map_item($id);

   }

    function delete_image(){
        $imgname = $this->input->post('imgname');
        $carid = $this->input->post('itemid');
        $imgid = $this->input->post('imgid');
    $this->Cars_model->delete_image($imgname,$imgid,$carid);

    }

    function deleteMultipleCarImages(){
          $data = $this->input->post('imgids');
          foreach($data as $d){
                $this->Cars_model->delete_image($d['imgname'],$d['imgid'],$d['itemid']);
          }


        }

    function app_rej_timages(){

    $this->Cars_model->approve_reject_images();

    }



   // Add car settings data
   function add_car_settings(){


   $this->Cars_model->add_settings_data();


   }
    // update car settings data
   function update_car_settings(){


   $this->Cars_model->update_settings_data();


   }

     // delete multiple settings
   function delMultiTypeSettings($type){

    $items = $this->input->post('items');

          foreach($items as $item){
          $this->Cars_model->deleteMultiplesettings($item,$type);
          }

   }

     // delete multiple settings
   function delete_single_settings(){

          $id = $this->input->post('id');


          $this->Cars_model->delete_settings($id);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

   }

    // disable multiple settings
   function disable_multiple_settings(){

    $idlist = $this->input->post('idlist');

          foreach($idlist as $id){
          $this->Cars_model->disable_settings($id);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");

   }

    // enable multiple settings
   function enable_multiple_settings(){

    $idlist = $this->input->post('idlist');

          foreach($idlist as $id){
          $this->Cars_model->enable_settings($id);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");

   }




    // delete single car unavailability
    	public function delete_single_unavail(){
          $unavailid = $this->input->post('unavailid');

          $this->Cars_model->delete_unavail($unavailid);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

    // delete multiple car unavailability

   function delete_multiple_unavail(){

    $unlist = $this->input->post('unlist');

          foreach($unlist as $id){
          $this->Cars_model->delete_unavail($id);
          }
          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

   }

   function add_unavail_car(){

  $this->Cars_model->add_unavail_car();

    }

       function update_unavail(){

        $this->Cars_model->update_unavail_car();
      $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }


      function add_price(){

          $this->Cars_model->add_aprice();

    }

     // delete multiple Advanced Prices
	public function delete_multiple_prices(){
          $pricelist = $this->input->post('pricelist');

          foreach($pricelist as $priceid){
          $this->Cars_model->delete_prices($priceid);
          }
          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

  // reject images
      function app_rej_cimages(){

    $this->Cars_model->approve_reject_images();

    }

              // delete single Advanced price
    	public function delete_single_aprice(){
          $priceid = $this->input->post('priceid');

          $this->Cars_model->delete_prices($priceid);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

     function update_price(){

        $this->Cars_model->update_aprice();
          $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }
   //process booking
   function process_booking_guest(){


  $this->load->model('bookings_model');

 $this->form_validation->set_message('matches', 'Email not matching with confirm email.');
 $this->form_validation->set_rules('email','Email', 'required|valid_email');
 $this->form_validation->set_rules('confirmemail','Email', 'required|matches[email]');
 $this->form_validation->set_rules('firstname','First name', 'trim|required');
 $this->form_validation->set_rules('lastname','Last Name', 'trim|required');



  if($this->form_validation->run() == FALSE)
		{

           echo  validation_errors();

        }else{
         echo "";
         $this->Bookings_model->do_guest_booking();

        }


   }


         function process_booking_logged(){
       $this->load->model('bookings_model');
     $user =  $this->session->userdata('pt_logged_customer');
      echo "";
    $this->Bookings_model->do_booking($user);


   }

      function process_booking_login(){
       $this->load->model('bookings_model');


   $username =  $this->input->post('username');
   $password =  $this->input->post('password');

   if($this->input->is_ajax_request()){

   echo $this->Bookings_model->do_login_booking($username,$password);

   }

   }


      function process_booking_signup(){
       $this->load->model('bookings_model');

 $this->form_validation->set_message('matches', 'Password not matching with confirm password.');
 $this->form_validation->set_rules('email','Email', 'required|valid_email');
 $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
 $this->form_validation->set_rules('confirmpassword', 'Password', 'required|matches[password]');
 $this->form_validation->set_rules('firstname','First name', 'trim|required');
 $this->form_validation->set_rules('lastname','Last Name', 'trim|required');


  if($this->form_validation->run() == FALSE)
		{

           echo  "<div class='alert alert-danger'>".validation_errors()."</div>";

        }else{
          $this->db->select('accounts_email');
          $this->db->where('accounts_email',$this->input->post('email'));
          $this->db->where('accounts_type','customers');
          $nums = $this->db->get('pt_accounts')->num_rows();
          if($nums > 0){
          echo  "<div class='alert alert-danger'> Email Already Exists. </div>";

          }else{

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
      $this->load->library('Cars_lib');
      $location = $this->input->post('location');
      $response = $this->Cars_lib->onPickupLocationSelection($location);
      echo json_encode($response);
    }

    function getDropoffLocations(){
      $this->load->library('Cars_lib');
      $location = $this->input->post('location');
      $carid = $this->input->post('carid');
      $pickupDate = $this->input->post('pickupDate');
      $dropoffDate = $this->input->post('dropoffDate');
      $response = $this->Cars_lib->getDropoffLocations($location, $carid,$pickupDate,$dropoffDate);
      echo json_encode($response);
    }

    function getCarPriceAjax(){
      $this->load->library('Cars_lib');
      $pickup = $this->input->post('pickupLocation');
      $dropoff = $this->input->post('dropoffLocation');
      $carid = $this->input->post('carid');
      $pickupDate = $this->input->post('pickupDate');
      $dropoffDate = $this->input->post('dropoffDate');
      $response = $this->Cars_lib->getCarPriceOnChangeLocation($carid, $pickup,$dropoff,$pickupDate, $dropoffDate);
      echo json_encode($response);
    }


    function carExtrasBooking(){
        $this->load->library('Cars/Cars_lib');
        $carid = $this->input->post('itemid');
        $extras = $this->input->post('extras');
        $pickup = $this->input->post('pickuplocation');
        $drop = $this->input->post('dropofflocation');
        $pickupDate = $this->input->post('pickupDate');
        $dropDate = $this->input->post('dropoffDate');


        echo $this->Cars_lib->getUpdatedDataBookResultObject($carid,$extras,$pickup,$drop,$pickupDate,$dropDate);


       }



}
