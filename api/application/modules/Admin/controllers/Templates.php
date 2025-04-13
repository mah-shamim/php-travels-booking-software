<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Templates extends MX_Controller {

		public $role;

		function __construct() {
				parent :: __construct();
				modules :: load('Admin');
				$chkadmin = modules :: run('Admin/validadmin');
			 $superAdmin = $this->session->userdata('pt_logged_super_admin');

        if (!$chkadmin || !$superAdmin) {
          $this->session->set_userdata('prevURL', current_url());


            redirect('admin');

        }
				$this->load->model('Templates_model');
/*  $chk = modules::run('home/is_module_enabled','coupons');
if(!$chk){
redirect('admin');
}*/
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
                $this->data['isSuperAdmin'] = $superAdmin;
               	$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
/*  if(!pt_permissions('coupons',$this->data['userloggedin'])){
redirect('admin');
}*/
// $this->load->model('coupons_model');
				$this->load->library('Ckeditor');
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				$this->data['ckconfig']['filebrowserBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=files';
				$this->data['ckconfig']['filebrowserImageBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=images';
				$this->data['ckconfig']['filebrowserFlashBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=flash';
				$this->data['ckconfig']['filebrowserUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=files';
				$this->data['ckconfig']['filebrowserImageUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=images';
				$this->data['ckconfig']['filebrowserFlashUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=flash';
		}

		public function email($template = null) {
				if (!empty ($template)) {
						$update = $this->input->post('update');
						if (!empty ($update)) {
								$this->Templates_model->update_details();
								redirect('admin/templates/email');
						}
						$this->load->model("Emails_model");
						$this->data['variables'] = $this->Emails_model->shortcode_variables($template);
						$this->data['details'] = $this->Templates_model->get_template_detail($template);
						$this->data['main_content'] = 'modules/templates/email/update';
						$this->data['page_title'] = 'Email Templates';
						$this->load->view('template', $this->data);
				}
				else {
						$this->data['templates'] = $this->Templates_model->get_all_templates();
						$this->data['main_content'] = 'modules/templates/email/index';
						$this->data['page_title'] = 'Email Templates';
						$this->load->view('template', $this->data);
				}
		}

		public function sms_settings()
		{
			if(isset($_POST) && ! empty($_POST)) {
				update_sms_api('sms_api', $_POST);
				
				$this->session->set_flashdata('sms_api_ack', 'Setting Updated Successfully');
				redirect('admin/templates/sms_settings');
			} else {
				$this->data['sms_api'] = (array) sms_api_loader('sms_api');

				$this->load->library('SmsTemplateManager');
				$templateManager = new SmsTemplateManager();
				$this->data['templates'] = json_decode($templateManager->get());
				$this->data['main_content'] = 'modules/templates/sms/settings';
				$this->data['page_title'] = 'SMS Template Settings';

				$this->load->view('template', $this->data);
			}
		}

		public function sms_test()
		{
			$recepient = $this->input->post('recepient');
			$message = $this->input->post('message');
			$response = send_sms($recepient, $message);

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($response));
		}

		public function updateSmsTemplate()
		{
			$this->load->library('SmsTemplateManager');
			$templateManager = new SmsTemplateManager();
			$id = $this->input->post('id');
			$data = $this->input->post();
			$updatedObject = $templateManager->update($id, $data);

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode([
				'status' => 'success',
				'updatedObject' => $updatedObject
			]));
		}
}
