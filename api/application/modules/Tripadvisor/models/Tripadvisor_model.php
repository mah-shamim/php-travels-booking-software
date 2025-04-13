<?php
class Tripadvisor_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     // update front settings
       function update_front_settings(){
        $ufor = $this->input->post('updatefor');
         $data = array(
         'cid' =>  $this->input->post('version'),
         'apikey' => $this->input->post('apikey')
         );
        $this->db->where('front_for',$ufor);
        $this->db->update('pt_front_settings',$data);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }


}