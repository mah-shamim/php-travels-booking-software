<?php
class Boats_uploads_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('misc_model');
        $this->load->model('Boats/Boats_model');


    }

  
 



}