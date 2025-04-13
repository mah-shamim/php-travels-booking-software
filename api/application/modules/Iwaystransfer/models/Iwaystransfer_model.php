<?php
class Iwaystransfer_model extends CI_Model {

    public function insert_booking($params){
        $this->db->insert('pt_iwaystransfer_booking',$params);
        return $this->db->insert_id();
    }


    /*booking data update Iwaystransfer table*/
    public function updatedata($bookingid,$user_id,$success_url){
        $this->db->set('status','upaid');
        $this->db->set('url',$success_url);
        $this->db->set('user_id',$user_id);
        $this->db->where('id',$bookingid);
        $this->db->update('pt_iwaystransfer_booking');
    }

    /*booking get data  iwaystransfer_booking table*/
    public function getData($id)//Get result of array
    {
        $this->db->where('id', $id);
        $query = $this->db->get('pt_iwaystransfer_booking');
        return $query->result();
    }
}

