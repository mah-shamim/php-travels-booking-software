<?php
class Goibibo_model extends CI_Model{

    public function countries(){
        return $this->db->get('pt_flights_countries')->result_array();

    }

    public function insert_booking($params){
        $this->db->insert('pt_goibibo_booking',$params);
        return $this->db->insert_id();
    }
}