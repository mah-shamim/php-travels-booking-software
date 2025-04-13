<?php
class Ivisa_model extends CI_Model{
    public $jsonfile;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->jsonfile =  APPPATH.'modules/Ivisa/settings.json';
    }

     // update front settings
       function update_front_settings(){
        $fdata = new stdClass;
        $fdata->showHeaderFooter = $this->input->post('showheaderfooter');
        $fdata->aid = $this->input->post('aid');
        $fdata->headerTitle = $this->input->post('headertitle');
        $fdata->from = $this->input->post('from');
        $fdata->to = $this->input->post('to');
        $fdata->from_code = $this->input->post('from_code');
        $fdata->to_code = $this->input->post('to_code');

        file_put_contents($this->jsonfile, json_encode($fdata,JSON_PRETTY_PRINT));
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

      function get_front_settings(){
        $fileData = json_decode(file_get_contents($this->jsonfile));
        return $fileData;
      }

      public function get_countries(){
        $result=$this->db->get('pt_flights_countries');
        return  $result->result_array();
        }
                                            
      public function bookin($data){
        $this->db->insert('booking_visa',$data);
        $last_id = $this->db->insert_id();
        return $last_id;
        }
        
      public function get_code(){
      $last = $this->db->order_by('id',"desc")
               ->limit(1)
               ->get('booking_visa');
      return $last->result();
   }

    public function get_invoice($code){
    $this->db->where('res_code',$code);
    $query = $this->db->get('booking_visa');
    return $query->result();   
   }
}
