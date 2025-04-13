<?php

class Hotel_Bookings_model extends CI_Model {
    private $data = array();

    function __construct() {
        
    }

    function admin_get_hotel_bookings($booking_status,$booking_payment_status) {
        $hotel_arr = [];
        $this->db->select();
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        if (!empty($booking_status)) {
        $this->db->where('hotels_bookings.booking_status', $booking_status);
        }if (!empty($booking_payment_status)) {
        $this->db->where('hotels_bookings.booking_payment_status', $booking_payment_status);
        }
        $this->db->join('pt_accounts', 'hotels_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $hotels_bookings=$this->db->get('hotels_bookings')->result();

        foreach ($hotels_bookings as $hotels) {
            array_push($hotel_arr,(object) [
                'booking_id'=>$hotels->booking_id,
                'booking_ref_no'=>$hotels->booking_ref_no,
                'module'=>'hotels',
                'ai_first_name'=>$hotels->ai_first_name,
                'booking_status'=>$hotels->booking_status,
                'booking_payment_status'=>$hotels->booking_payment_status,
                'booking_date'=>$hotels->booking_date,
                'booking_curr_code'=>$hotels->booking_curr_code,
                'total_price'=>$hotels->total_price,
                'supplier_name'=>$hotels->supplier_name,
            ]);
        }
        return $hotel_arr;
    }
}