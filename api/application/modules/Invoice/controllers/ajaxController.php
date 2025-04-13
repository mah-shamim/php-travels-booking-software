<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ajaxController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->output->set_content_type('application/json');
    }

    public function set_paid()
    {
        $payload = $this->input->post();
        // Update status
        $this->db->set('booking_status', 'paid');
        $this->db->where('booking_id', $payload['order']['id']);
        $this->db->update('pt_bookings');
        
        $this->output->set_output(json_encode([
            'status' => 'success',
            'message' => 'Status updated',
            'data' => $payload
        ]));
    }
}