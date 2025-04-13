<?php

class Juniper_model extends CI_Model
{
//    public function getcode($name){
//        $this->db->where('Name',str_replace('-',' ',$name));
//        $query = $this->db->get('pt_juniper_zonelist')->result();
//        if(!empty($query[0]->JPDCode)){
//            $this->db->where('Zone_JPDCode',$query[0]->JPDCode);
//            $query = $this->db->get('pt_juniper_hotellist')->result();
//            $arr = array();
//            foreach ($query as $code){
//                $arr[] = $code->JPCode;
//            }
//            return $arr;
//        }
//
//    }

    function currencyrate($currencycode){
        $this->db->select('rate');
        $this->db->from('pt_currencies');
        $this->db->where('name',$currencycode);
        return $this->db->get()->row('rate');
    }

    public function booking($data){
        $this->db->insert('pt_juniper_booking',$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function getBooking($id){
        $this->db->select('pt_juniper_booking.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $this->db->where('id',$id);
        $this->db->join('pt_accounts','pt_juniper_booking.user_id = pt_accounts.accounts_id','left');
        $query = $this->db->get('pt_juniper_booking');
        return $query->result();
    }

}