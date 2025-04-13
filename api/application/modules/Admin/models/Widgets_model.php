<?php
class Widgets_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function get_widget_content($id){
    $this->db->where('widget_id',$id);
    $this->db->where('widget_status','Yes');
    $content = $this->db->get('pt_widgets')->result();
    if(!empty($content)){

    return $content[0]->widget_content;

    }else{

      return '';
    }

    }

    function getWidgetDetails($id){

    $this->db->where('widget_id',$id);
    return $this->db->get('pt_widgets')->result();
    

    }

    function addWidget(){
              $data = array(
            'widget_name' => $this->input->post('title'),
            'widget_status' => $this->input->post('status'),
            'widget_content' => $this->input->post('widgetbody')
            );
        $this->db->insert('pt_widgets',$data);
    }

    function updateWidget($id){
        $data = array(
            'widget_name' => $this->input->post('title'),
            'widget_status' => $this->input->post('status'),
            'widget_content' => $this->input->post('widgetbody')
            );
        $this->db->where('widget_id',$id);
        $this->db->update('pt_widgets',$data);

    }

    function deleteWidget($id){
        $this->db->where('widget_id',$id);
        $this->db->delete('pt_widgets');
        
    }


 }