<?php
class Travelpayouts_model extends CI_Model{
    public $jsonfile;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     // update front settings
       function update_front_settings(){
        $fdata = new stdClass;
        $fdata->showHeaderFooter = $this->input->post('showheaderfooter');

        $fdata->iframeID = $this->input->post('iframeid');
        $fdata->headerTitle = $this->input->post('headertitle');
        $fdata->WidgetURL = $this->input->post('WidgetURL');
        $fdata->WidgetURLMobile = $this->input->post('WidgetURLMobile');
        app()->service("ModuleService")->update('travelpayouts', 'settings', $fdata);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

      function get_front_settings(){
        $fileData = app()->service("ModuleService")->get('travelpayouts')->settings;
        return $fileData;
      }

}
