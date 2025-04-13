<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
 *  Modules Controller
 */
class ModulesController extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajax request handler
     */
    public function updateStatus()
    {
        $module_name = $this->input->post('modulename');
        $this->db->query("UPDATE pt_modules 
            SET module_status = CASE WHEN module_status = 1 THEN 0 ELSE 1 END
            WHERE module_name = '{$module_name}'");

        $this->db->select('module_id, module_name, module_status');
        $this->db->where('module_name', $module_name);
        $dataAdapter = $this->db->get('pt_modules');
        $status = $dataAdapter->row()->module_status;

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'status' => ($status) ? 'enabled' : 'disabled'
        ]));
    }
}