<?php

class Amadeus_model extends CI_Model
{
    public function get_airport($query){
    	return $this->db->query("SELECT *
        FROM pt_flights_airports
         WHERE (code LIKE '%$query%' OR name LIKE '%$query%')
        ORDER BY CASE
       WHEN (code LIKE '%$query%' AND name LIKE '%$query%') THEN 1
        WHEN (code LIKE '%$query%' AND name NOT LIKE '%$query%') THEN 2
         ELSE 3
         END, code")->result_array();
    }

    public function get_sercet_keys(){
    	$query = $this->db->get_where('modules', array('name' =>'Amadeus'));
    	$data = $query->row_array();
    	return $data['settings'];
    }

    public function get_airport_name($code){
        $this->db->where('code', $code);
        $query = $this->db->get('pt_flights_airports');
        $data = $query->row_array();
        return $data['cityName']." - ".$data['name']. " (".$data['code'].")";
    }

    public function insert_booking($params){
        $this->db->insert('pt_amadeus_booking',$params);
        return $this->db->insert_id();
    }
    
    public function insert_flight_data($params){
        $this->db->insert('pt_amadeus_flight_segments',$params);
    }

    public function countries(){
        return $this->db->get('pt_flights_countries')->result_array();

    }
}