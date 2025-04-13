<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * Travelport Ajax Requests Controller
 *
 * @category Controller
 */
class AjaxController extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('html');
        $this->output->set_content_type('application/json');
    }

    /**
     * Update travelport configurations
     *
     * @method Backend
     * @return json
     */
    public function update_configuration()
    {
        $payload = $this->input->post();
        
        $this->load->model('TravelportHotelModel_Conf');
        $configuration = new TravelportHotelModel_Conf();
        $id = $payload['id'];
        unset($payload['id']);
        $configuration->update($id, $payload);

        $this->output->set_output(json_encode(array(
            'status' => 'success'
        )));
    }

    /**
     * Save invoice and send to user and admin as notification
     *
     * @method Forntend
     * @return json
     */
    public function save_invoice()
    {
        $invoice_name = $this->input->post('invoice_name');
        $receivers = $this->input->post('receivers');
        $base64ImageString = $this->input->post('base64ImageString');
        
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64ImageString));
        $invoice_path = './uploads/images/travelport/' . $invoice_name;
        $save_ack = file_put_contents($invoice_path, $data); // Save invoice
        
        if ( ! empty($save_ack) )
        {   
            $receivers = (count($receivers) > 1) ? $receivers : current($receivers);

            $this->load->library('email');
            $this->email->from($this->email->mail_fromemail, $this->email->site_title);
            $this->email->to($receivers);
            $this->email->subject('Flight Reservation Invoice');
            
            $message  = $this->email->mail_header;
            $message .= img('uploads/images/travelport/' . $invoice_name);
            $message .= $this->email->mail_footer;
            
            $this->email->message($message);	
            $this->email->attach($invoice_path);
            $email_ack = $this->email->send();

            // echo $this->email->print_debugger();
            $response = array(
                'status' => 'success',
                'email_ack' => $email_ack,
                'receivers' => $receivers
            );
        }
        else
        {
            $response = array(
                'status' => 'fail',
            );
        }

        $this->output->set_output(json_encode($response));
    }

    /**
     * Delete multiple records
     *
     * Serves XCRUD delete all method
     * 
     * @return json
     */
    public function delete_multiple_record()
    {
        $this->db->where_in('id', $this->input->post('items'));
        $this->db->delete('tport_reservation');

        $this->output->set_output(json_encode(array(
            'data' => $this->input->post()
        )));
    }
}