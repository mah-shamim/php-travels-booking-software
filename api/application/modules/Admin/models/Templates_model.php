<?php

class Templates_model extends CI_Model {

             private $data = array();

    function __construct()

    {

        // Call the Model constructor

        parent::__construct();



    }



    function get_all_templates(){

      return $this->db->get('pt_email_templates')->result();

    }

    function get_template_detail($temp){

      $this->db->where('temp_name',$temp);

      return $this->db->get('pt_email_templates')->result();

    }


    function update_details()
    {
        $tmp_name = $this->input->post('tempname');

        $data = array(

        'temp_subject' => $this->input->post('subject'),

        'temp_title' => $this->input->post('title'),

        'temp_body' => $this->input->post('tempbody'),

        );

        $this->db->where('temp_name',$tmp_name);

        $this->db->update('pt_email_templates',$data);
    }

    function get_sms_template_body($temp_name)
    {
        $this->db->select('temp_body');
        $this->db->where('temp_name', $temp_name);
        return $this->db->get('pt_sms_templates')->row()->temp_body;
    }

}