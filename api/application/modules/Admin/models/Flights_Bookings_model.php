<?php

class Flights_Bookings_model extends CI_Model {
    private $data = array();

    function __construct() {
        
    }

    function admin_get_flights_bookings($booking_status,$booking_payment_status) {
        $hotel_arr = [];
        $this->db->select();
        $this->db->order_by('flights_bookings.booking_id', 'desc');
        if (!empty($booking_status)) {
        $this->db->where('flights_bookings.booking_status', $booking_status);
        }if (!empty($booking_payment_status)) {
        $this->db->where('flights_bookings.booking_payment_status', $booking_payment_status);
        }
        $this->db->join('pt_accounts', 'flights_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $flights_bookings=$this->db->get('flights_bookings')->result();

        foreach ($flights_bookings as $flights) {
            array_push($hotel_arr,(object) [
                'booking_id'=>$flights->booking_id,
                'booking_ref_no'=>$flights->booking_ref_no,
                'module'=>'flights',
                'ai_first_name'=>$flights->ai_first_name,
                'booking_status'=>$flights->booking_status,
                'booking_payment_status'=>$flights->booking_payment_status,
                'booking_date'=>$flights->booking_date,
                'booking_curr_code'=>$flights->booking_curr_code,
                'total_price'=>$flights->total_price
            ]);
        }
        return $hotel_arr;
    }
}