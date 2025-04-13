<?php
class Wegoflights_model extends CI_Model{
    public $jsonfile;


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->jsonfile =  APPPATH.'modules/integrations/Wegoflights/settings.json';
    }

     // update front settings
       function update_front_settings(){
        $fdata = new stdClass;
        $fdata->showHeaderFooter = $this->input->post('showheaderfooter');
        $fdata->url = $this->input->post('url');
        $fdata->aid = $this->input->post('aid');
        $fdata->brandID = $this->input->post('brandid');
        $fdata->searchBoxID = $this->input->post('searchid');
        $fdata->headerTitle = $this->input->post('headertitle');

        file_put_contents($this->jsonfile, json_encode($fdata,JSON_PRETTY_PRINT));
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

      function get_front_settings(){
        $fileData = json_decode(file_get_contents($this->jsonfile));
        return $fileData;
      }

}
