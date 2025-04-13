<?php
class Travelpayoutshotels_model extends CI_Model{
    public $jsonfile;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     // update front settings
       function update_front_settings(){
        $fdata = new stdClass();
        $fdata->showHeaderFooter = $this->input->post('showheaderfooter');

        $fdata->iframeID = $this->input->post('iframeid');
        $fdata->headerTitle = $this->input->post('headertitle');
        $fdata->WidgetURL = $this->input->post('WidgetURL');
        $fdata->WidgetURLMobile = $this->input->post('WidgetURLMobile');
        $fdata->status = $this->input->post('status');
        app()->service("ModuleService")->update('Travelpayoutshotels', 'settings', $fdata);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

      function get_front_settings(){
        $fileData = app()->service("ModuleService")->get('Travelpayoutshotels')->settings;
        return $fileData;
      }
}
