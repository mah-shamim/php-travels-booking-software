<?php
class Hotelston_model extends CI_Model{

    public function gethotel($code){
        $this->db->where('country_name',$code);
        $query = $this->db->get('hotelston_id');
        return $query->result();
    }

    public function booking($data){
        $this->db->insert('pt_hotelston_booking',$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function getBooking($id){
        $this->db->select('pt_hotelston_booking.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $this->db->where('id',$id);
        $this->db->join('pt_accounts','pt_hotelston_booking.user_id = pt_accounts.accounts_id','left');
        $query = $this->db->get('pt_hotelston_booking');
        return $query->result();
    }

    function currencyrate($currencycode){
        $this->db->select('rate');
        $this->db->from('pt_currencies');
        $this->db->where('name',$currencycode);
        return $this->db->get()->row('rate');
    }

    /*User account Booking Show*/
    public function get_bookings($id){
        $this->db->where('user_id', $id);
        $query = $this->db->get('pt_hotelston_booking');
        return $query->result();
    }
}
