<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotelajaxcalls extends MX_Controller {

	function __construct(){

    modules::load('Admin');

	}

     // delete multiple Hotels
     public function delete_multiple_hotels(){
          $hotellist = $this->input->post('hotellist');

          foreach($hotellist as $hotelid){

     $this->Hotels_model->delete_hotel($hotelid);

          }

      $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }


    // Delete Single hotel
    public function delete_single_hotel(){
      $hotelid = $this->input->post('hotelid');
     $this->Hotels_model->delete_hotel($hotelid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }


     // delete multiple Rooms
     public function delete_multiple_rooms(){
          $roomlist = $this->input->post('roomlist');

          foreach($roomlist as $roomid){

     $this->Rooms_model->delete_room($roomid);

          }

      $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

    // Delete Single Room
    function delete_single_room(){
      $roomid = $this->input->post('roomid');
     $this->Rooms_model->delete_room($roomid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }


    // update Hotel order
	public function update_hotel_order(){
           $hotelid = $this->input->post('id');
          $order = $this->input->post('order');

          $this->Hotels_model->update_hotel_order($hotelid,$order);

    }

      // update Room order
	public function update_room_order(){
           $roomid = $this->input->post('id');
          $order = $this->input->post('order');

          $this->Rooms_model->update_room_order($roomid,$order);

    }

      // update Images order
	public function update_image_order(){
           $imgid = $this->input->post('id');
          $order = $this->input->post('order');

          $this->Hotels_model->update_image_order($imgid,$order);

    }



     // delete multiple Advanced Prices
	public function delete_multiple_prices(){
          $pricelist = $this->input->post('pricelist');

          foreach($pricelist as $priceid){
          $this->Hotels_model->delete_prices($priceid);
          }
          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

     // delete multiple Advanced Prices of Rooms
	public function delete_multiple_prices_room(){
          $pricelist = $this->input->post('pricelist');

          foreach($pricelist as $priceid){
          $this->Rooms_model->delete_prices($priceid);
          }
          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }


    // Disable multiple Hotels
	public function disable_multiple_hotels(){
          $hotellist = $this->input->post('hotellist');

          foreach($hotellist as $hotelid){
          $this->Hotels_model->disable_hotel($hotelid);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");


    }

     // Enable multiple Hotels
	public function enable_multiple_hotels(){
          $hotellist = $this->input->post('hotellist');

          foreach($hotellist as $hotelid){
          $this->Hotels_model->enable_hotel($hotelid);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");


    }

    // Disable multiple Rooms
	public function disable_multiple_rooms(){
          $roomlist = $this->input->post('roomlist');

          foreach($roomlist as $roomid){
          $this->Rooms_model->disable_room($roomid);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");


    }

        // Enable multiple Rooms
	public function enable_multiple_rooms(){
       $roomlist = $this->input->post('roomlist');

          foreach($roomlist as $roomid){
          $this->Rooms_model->enable_room($roomid);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");


    }

       // update Room Type
	public function update_roomtype(){
           $roomid = $this->input->post('id');
          $type = $this->input->post('type');

          $this->Rooms_model->update_room_type($roomid,$type);

    }


          // delete single Advanced price
    	public function delete_single_aprice(){
          $priceid = $this->input->post('priceid');

          $this->Hotels_model->delete_prices($priceid);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

     // delete single Advanced price Room
    	public function delete_single_aprice_room(){
          $priceid = $this->input->post('priceid');

          $this->Rooms_model->delete_prices($priceid);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }


        // delete single hotel unavailability
    	public function delete_single_unavail(){
          $unavailid = $this->input->post('unavailid');

          $this->Hotels_model->delete_unavail($unavailid);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");


    }

    // delete multiple hotel unavailability

   function delete_multiple_unavail(){

    $unlist = $this->input->post('unlist');

          foreach($unlist as $id){
          $this->Hotels_model->delete_unavail($id);
          }
          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

   }


   // update featured hotel option
    function update_featured(){
    $this->Hotels_model->update_featured();
    echo "done";

    }


    function add_price(){

          $this->Hotels_model->add_aprice();

    }

    function update_price(){

        $this->Hotels_model->update_aprice();
          $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }

     function add_unavail_hotel(){

          $this->Hotels_model->add_unavail_hotel();

    }

       function update_unavail(){

        $this->Hotels_model->update_unavail_hotel();
      $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }


      function add_price_room(){

          $this->Rooms_model->add_aprice();

    }


     function update_price_room(){

        $this->Rooms_model->update_aprice();
          $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }


    function delete_image(){
        $imgname = $this->input->post('imgname');
     $imgtype = $this->input->post('imgtype');
     $imgid = $this->input->post('imgid');
    $this->Hotels_model->delete_image($imgname,$imgtype,$imgid);

    }

    function delete_room_image(){

        $this->Rooms_model->delete_image();

    }

    function app_rej_himages(){

    $this->Hotels_model->approve_reject_images();

    }

      function app_rej_hvids(){

    $this->Hotels_model->approve_reject_videos();

    }

      function app_rej_rimages(){

    $this->Rooms_model->approve_reject_images();

    }

    function add_video_link(){
          $link = $this->input->post('linkname');
          $hotelid = $this->input->post('hotelid');
         $this->form_validation->set_rules('linkname','Link', 'trim|required');


  if ($this->form_validation->run() == FALSE)
		{

             echo  '<div class="alert alert-danger"><i class="fa fa-times-circle"></i>'.validation_errors().'</div><br>';



		}else{

        $this->Hotels_model->add_video_link($link,$hotelid,'youtube');
        echo '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Link Added Successfully.</div><br>';

		}


    }

   // Delete Video link
   function delete_video(){

   $this->Hotels_model->delete_vids();

   }

   // Add hotel settings data
   function add_hotel_settings(){


   $this->Hotels_model->add_settings_data();


   }
    // update hotel settings data
   function update_hotel_settings(){


   $this->Hotels_model->update_settings_data();


   }

     // delete multiple settings
   function delete_multiple_settings(){

    $idlist = $this->input->post('idlist');

          foreach($idlist as $id){
          $this->Hotels_model->delete_settings($id);
          }
          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

   }

     // delete multiple settings
   function delete_single_settings(){

          $id = $this->input->post('id');


          $this->Hotels_model->delete_settings($id);

          $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

   }

    // disable multiple settings
   function disable_multiple_settings(){

    $idlist = $this->input->post('idlist');

          foreach($idlist as $id){
          $this->Hotels_model->disable_settings($id);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");

   }

    // enable multiple settings
   function enable_multiple_settings(){

    $idlist = $this->input->post('idlist');

          foreach($idlist as $id){
          $this->Hotels_model->enable_settings($id);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");

   }

   //process booking
   function process_booking_guest(){


  $this->load->model('bookings_model');

 $this->form_validation->set_message('matches', 'Email not matching with confirm email.');
 $this->form_validation->set_rules('email','Email', 'required|valid_email');
 $this->form_validation->set_rules('confirmemail','Email', 'required|matches[email]');
 $this->form_validation->set_rules('firstname','First name', 'trim|required');
 $this->form_validation->set_rules('lastname','Last Name', 'trim|required');
 $this->form_validation->set_rules('country','Country', 'trim|required');



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
 $this->form_validation->set_rules('country','Country', 'trim|required');



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



}
