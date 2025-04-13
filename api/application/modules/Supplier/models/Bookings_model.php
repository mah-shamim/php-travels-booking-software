<?php

class Bookings_model extends CI_Model {


    function supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id) {


        $hotel_arr = [];
        $this->db->select();
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $supplier_id);
        if (!empty($booking_status)) {
        $this->db->where('hotels_bookings.booking_status', $booking_status);
        }if (!empty($booking_payment_status)) {
        $this->db->where('hotels_bookings.booking_payment_status', $booking_payment_status);
        }
        $this->db->join('pt_accounts', 'hotels_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $hotels_bookings=$this->db->get('hotels_bookings')->result();

        foreach ($hotels_bookings as $hotels) {
            array_push($hotel_arr,(object) [
                'booking_id'=>$hotels->booking_id,
                'booking_ref_no'=>$hotels->booking_ref_no,
                'module'=>'hotels',
                'ai_first_name'=>$hotels->ai_first_name,
                'supplier_name'=>$hotels->supplier_name,
                'booking_from'=> $hotels->booking_from,
                'booking_status'=>$hotels->booking_status,
                'booking_payment_status'=>$hotels->booking_payment_status,
                'booking_date'=>$hotels->booking_date,
                'booking_curr_code'=>$hotels->booking_curr_code,
                'total_price'=>$hotels->total_price
            ]);
        }
        $flights_arr = [];
        $this->db->select();
        $this->db->order_by('flights_bookings.booking_id', 'desc');
        $this->db->where('flights_bookings.booking_user_id', $supplier_id);
        if (!empty($booking_status)) {
        $this->db->where('flights_bookings.booking_status', $booking_status);
        }if (!empty($booking_payment_status)) {
        $this->db->where('flights_bookings.booking_payment_status', $booking_payment_status);
        }
        $this->db->join('pt_accounts', 'flights_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $flights_bookings=$this->db->get('flights_bookings')->result();

        foreach ($flights_bookings as $flights) {
            array_push($flights_arr,(object) [
                'booking_id'=>$flights->booking_id,
                'booking_ref_no'=>$flights->booking_ref_no,
                'module'=>'flights',
                'ai_first_name'=>$flights->ai_first_name,
                'supplier_name'=>$flights->supplier_name,
                'booking_from'=> $flights->booking_from,
                'booking_status'=>$flights->booking_status,
                'booking_payment_status'=>$flights->booking_payment_status,
                'booking_date'=>$flights->booking_date,
                'booking_curr_code'=>$flights->booking_curr_code,
                'total_price'=>$flights->total_price
            ]);
        }
        return array_merge($hotel_arr,$flights_arr);
    }

/*booking status update*/
function update_booking_status($booking_id, $module, $booking_status){
        $table_name = $module.'_bookings';
        $data=array('booking_status'=>$booking_status);
        $result = $this->db->where('booking_id',$booking_id)->update($table_name,$data);
        return $result;
    }

function update_paybooking_status($booking_id, $module, $booking_payment_status){
        $table_name = $module.'_bookings';
        $data=array('booking_payment_status'=>$booking_payment_status);
        $result = $this->db->where('booking_id',$booking_id)->update($table_name,$data);
        return $result;
    }

function booking_del($booking_id, $module){
        $table_name = $module.'_bookings';
        $result = $this->db->where('booking_id',$booking_id)->delete($table_name);
        return $result;
    }
/*END booking status update*/



    // get all bookings
    function get_all_bookings_back_admin() {
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
                pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
                booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings');
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }
}