<?php
class TravelPayoutsFlights_model extends CI_Model {


		function __construct()

        {

            // Call the Model constructor

            parent :: __construct();

            $this->langdef = $this->session->userdata('set_lang');

            $this->langdef = (!empty($this->langdef))?$this->langdef:DEFLANG;

            $this->isSuperAdmin = $this->session->userdata('pt_logged_super_admin');

		}
        /*booking data save bookings travelpayoutsflightapi table*/
        public function travelpayoutflightapi_booking($data){
            $this->db->insert('bookings_travelpayoutsflightapi',$data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }

}

