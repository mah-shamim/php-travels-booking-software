<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wegoflightsback extends MX_Controller {

	function __construct(){
        $method_segment = $this->uri->segment(3);
        $chk = app()->service('ModuleService')->isActive('wegoflights');
        if ( ! $chk && $method_segment != "settings" && $method_segment != "update_settings") {
            backError_404($this->data);
        }
    $checkingadmin = $this->session->userdata('pt_logged_admin');
    if(!empty($checkingadmin)){
    $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
    }else{
    $this->data['userloggedin'] = $this->session->userdata('pt_logged_agent');
    }
    if(empty($this->data['userloggedin'])){
    redirect("admin");
    }
    if(!empty($checkingadmin)){
    $this->data['adminsegment'] = "admin";
    }else{
    $this->data['adminsegment'] = "agent";
    }

    $this->load->helper('settings');
    $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
    }
    function index(){
    }

    function settings(){
        $payload = $this->input->post();
        if (!empty($payload)) {
            app()->service("ModuleService")->update('wegoflights', 'settings', $payload);
            redirect('admin/wegoflights/settings');
        }
        $this->data['settings'] = app()->service("ModuleService")->get('wegoflights')->settings;
        $this->data['main_content'] = 'Wegoflights/settings';
        $this->data['page_title'] = 'Wego Flights Settings';
        $this->load->view('Admin/template',$this->data);
    }
}