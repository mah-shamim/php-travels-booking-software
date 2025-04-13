<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MX_Controller {
function __construct(){
// $this->session->sess_destroy();
parent::__construct();
$this->load->model('Admin/Accounts_model');
}
function index(){
$username =  $this->input->post('username');
$password =  $this->input->post('password');
if($this->input->is_ajax_request()){
$login = $this->Accounts_model->login_customer($username,$password);
if($login){
echo "true";
}else{
echo "Invalid Email or Password";
}
}
}
}