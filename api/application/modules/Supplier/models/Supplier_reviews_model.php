<?php
class Supplier_reviews_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }




    // get all reviews
    function get_all_reviews($userid){

               $ids = array();
           $this->db->select('hotel_id');
           $this->db->where('hotel_owned_by',$userid);
           $rs = $this->db->get('pt_hotels')->result();
           foreach($rs as $r){
             array_push($ids,$r->hotel_id);
           }
           if(!empty($ids)){
             foreach($ids as $id){
           $this->db->or_where('review_itemid', $id);
             }

           }

    $this->db->order_by('review_id','desc');
    return $this->db->get('pt_reviews')->result();



    }


}