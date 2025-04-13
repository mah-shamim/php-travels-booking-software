<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Register extends MX_Controller {
        private $validlang;
		function __construct() {
// $this->session->sess_destroy();
				parent :: __construct();

                $ci = get_instance();
                $version = implode("=>",(array)$ci->db->query('SELECT VERSION()')->result()[0]);
                if($version > 5.6)
                {
                $ci->db->query('SET SESSION sql_mode = ""');
                $ci->db->query('SET SESSION sql_mode =
                REPLACE(REPLACE(REPLACE(
                @@sql_mode,
                "ONLY_FULL_GROUP_BY,", ""),
                ",ONLY_FULL_GROUP_BY", ""),
                "ONLY_FULL_GROUP_BY", "")');
                }


				$this->data['app_settings'] = $this->Settings_model->get_settings_data();
				$allowreg = $this->data['app_settings'][0]->allow_registration;

				$langcode = $this->uri->segment(2);

				$this->validlang = pt_isValid_language($langcode);
				if($this->validlang){
				$this->data['lang_set'] = $langcode;
				}else{
				$this->data['lang_set'] = $this->session->userdata('set_lang');
				}

				$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
				$this->data['phone'] = $this->load->get_var('phone');
				$this->data['contactemail'] = $this->load->get_var('contactemail');
				$defaultlang = pt_get_default_language();


				if (empty ($this->data['lang_set'])) {
						$this->data['lang_set'] = $defaultlang;
				}

				if ($allowreg == "0") {
						Error_404($this,$this->data);
				}
		}

		public function index() {
				$url = http_build_query($_GET);
				if (!empty ($url)) {
						$this->data['url'] = $url;
				}
				else {
						$this->data['url'] = "";
				}
				if (!empty ($this->data['usersession'])) {
						redirect(base_url() . 'account');
				}
				else {
			    		$this->lang->load("front", $this->data['lang_set']);
						$restricted = $this->data['app_settings'][0]->restrict_website;
						if($restricted == "Yes"){
						$this->data['hidden'] = "hidden-sm hidden-lg";
						}
						$this->setMetaData("Register");
						$this->data['langurl'] = base_url()."register/{langid}";
						$this->theme->view('register', $this->data, $this);
				}
		}

		function _remap($method, $params=array()){
		$funcs = get_class_methods($this);

		if(in_array($method, $funcs)){

		return call_user_func_array(array($this, $method), $params);

		}else{
			$this->index();
		}

		}

}
