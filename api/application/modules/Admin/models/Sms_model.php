<?php

class Sms_model extends CI_Model {
    
    const DB_TABLE = 'pt_sms_templates';
    const DB_TABLE_PK = 'temp_id';
    
    public function get_shortcode_variables($template_name) 
    {
        $this->db->select('temp_vars');
        $this->db->where('temp_name', $template_name);
        $dataAdapter = $this->db->get($this::DB_TABLE);
        if($dataAdapter->num_rows() > 0) {
            $row = $dataAdapter->row();
            return explode(' ', trim($row->temp_vars));
        }

        return NULL;
    }
}