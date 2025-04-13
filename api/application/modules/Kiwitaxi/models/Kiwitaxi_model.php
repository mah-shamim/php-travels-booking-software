<?php
class Kiwitaxi_model extends CI_Model {


		function __construct()

        {

            // Call the Model constructor

            parent :: __construct();

            $this->langdef = $this->session->userdata('set_lang');

            $this->langdef = (!empty($this->langdef))?$this->langdef:DEFLANG;

            $this->isSuperAdmin = $this->session->userdata('pt_logged_super_admin');

		}

		/*Get Currency Rate*/
		public function currencyrate($currencycode){
            $this->db->select('rate');
            $this->db->from('pt_currencies');
            $this->db->where('code',$currencycode);
            return $this->db->get()->row('rate');
        }
        /*booking data save kiwitaxi table*/
        public function kiwitaxi_booking($transfer_id,$flight_form,$flight_no,$loaction,$date_start,$pax,$child,$child_booster_count,$first_name,$last_name,$email,$phone,$msg,$taxi_img,$taxi_name,$type){
            $data = array(
            'transfer_id'=>$transfer_id,
                'flight_form'=>$flight_form,
                'flight_no'=>$flight_no,
                'date_time'=>$date_start,
                'loaction'=>$loaction,
                'pax'=>$pax,
                'child'=>$child,
                'child_booster_count'=>$child_booster_count,
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'email'=>$email,
                'phone'=>$phone,
                'taxi_msg'=>$msg,
                'taxi_image'=>$taxi_img,
                'taxi_name'=>$taxi_name,
                'payment_type'=>$type
            );
            $this->db->insert('bookings_kiwitaxi',$data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    /*booking data update kiwitaxi table*/
        public function updatedata($bookingid,$user_id,$amount,$currcncy_code,$bookingToken,$formUrl,$status,$paymentMethodRefined,$success_url){
            $this->db->set('amount',$amount);
            $this->db->set('currency',$currcncy_code);
            $this->db->set('bookingToken',$bookingToken);
            $this->db->set('formUrl',$formUrl);
            $this->db->set('paymentMethodRefined',$paymentMethodRefined);
            $this->db->set('status',$status);
            $this->db->set('url',$success_url);
            $this->db->set('user_id',$user_id);
            $this->db->where('id',$bookingid);
            $this->db->update('bookings_kiwitaxi');
            //dd($this->db->last_query());
        }
    /*booking data update status kiwitaxi table*/
        public function updatestatus($id,$status){
            $this->db->set('status',$status);
            $this->db->where('id',$id);
            $this->db->update('bookings_kiwitaxi');
        }

    /*booking get data  kiwitaxi table*/
        public function getData($id)//Get result of array
        {
            $this->db->where('id', $id);
            $query = $this->db->get('bookings_kiwitaxi');
            return $query->result();
        }

        /*User account Booking Show*/
        public function get_bookings($id){
            $this->db->where('user_id', $id);
            $query = $this->db->get('bookings_kiwitaxi');
            return $query->result();
        }
}

