<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication controller
 *
 * This contoller perform authentication task.
 *
 * @category Controller
 * @author PHPTravels
 */
class Auth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->lang->load('front', pt_get_default_language());
    }

    public function signin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $this->db->select('accounts_id, ai_first_name, ai_last_name, accounts_email, accounts_type');
        $dataAdapter = $this->db->get_where('pt_accounts', [
            'accounts_email' => $email,
            'accounts_password' => sha1($password),
            'accounts_type' => 'customers'
        ]);

        if($dataAdapter->num_rows() > 0) 
        {
            // Create session
            $dataset = $dataAdapter->row();
            $this->session->set_userdata('pt_logged_customer', $dataset->accounts_id);
            $this->session->set_userdata('fname', $dataset->ai_first_name);
            $this->session->set_userdata('lname', $dataset->ai_last_name);
            $this->session->set_userdata('email', $dataset->accounts_email);
            $this->session->set_userdata('pt_role', $dataset->accounts_type);
            
            $response = array(
                'status' => 'success',
                'username_li' => $this->get_username_li($dataset->ai_first_name),
                'message' => trans('0596')
            );
        } 
        else 
        {
            $response = array(
                'status' => 'fail',
                'message' => 'Please use valid credentials only registered accounts can make the booking'
            );
        }
        //'message' => trans('0595')
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($response));
    }

    private function get_username_li($firstname)
    {
        $customer_loggedin = '
        <li>
            <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle go-text-right">
                <i class="icon_set_1_icon-70 go-right"></i> '. $firstname .' <b class="lightcaret mt-2 go-left"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="go-text-right" href="'.site_url('account').'">'. trans('02') .'</a>
                </li>
                <li>
                    <a class="go-text-right" href="'.site_url('account/logout').'">'. trans('03') .'</a>
                </li>
            </ul>
        </li>';
        return $customer_loggedin;
    }
}