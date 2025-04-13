<?php
class Supplier_room_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


  function is_my_room($roomid,$id){
     $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_owned_by,pt_hotels.hotel_title,pt_rooms.*');
    $this->db->where('pt_rooms.room_id',$roomid);
    $this->db->where('pt_hotels.hotel_owned_by',$id);
    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id');
   $rs = $this->db->get('pt_rooms')->num_rows();
   if($rs > 0){
     return true;
   }else{
     return false;
   }


  }


   function get_all_rooms($owner,$hotelid = null){


    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_owned_by,pt_hotels.hotel_title,pt_rooms.room_title,pt_rooms.room_hotel,pt_rooms.room_id,pt_rooms.room_type,pt_rooms.room_status,pt_rooms.room_added_on,pt_rooms.room_order');

    if(!empty($hotelid)){
     $this->db->where('pt_rooms.room_hotel',$hotelid);
    }

    $this->db->where('pt_hotels.hotel_owned_by',$owner);
    $this->db->order_by('pt_rooms.room_id','desc');
    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id','left');

    $query =  $this->db->get('pt_rooms');
    $data = $query->result();

    return $data;



    }


}