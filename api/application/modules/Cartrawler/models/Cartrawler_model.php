<?php
class Cartrawler_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     // update front settings
       function update_front_settings(){
        $ufor = $this->input->post('updatefor');
         $data = array(
         'front_icon' =>  $this->input->post('page_icon'),
         'cid' =>  $this->input->post('username'),
         'header_title' =>  $this->input->post('headertitle'),
         'linktarget' =>  $this->input->post('target'),
         'load_headerfooter' =>  $this->input->post('showheaderfooter'),
         'currency' =>  $this->input->post('currency'),
         'secret' =>  $this->input->post('url')

         );
        $this->db->where('front_for',$ufor);
        $this->db->update('pt_front_settings',$data);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }


}