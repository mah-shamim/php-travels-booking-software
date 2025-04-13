<?php
class Translation_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

    }



    function get_default_lang(){
    $this->db->select('default_lang');
    $q = $this->db->get('pt_app_settings')->result();
        return $q[0]->default_lang;
    }


}