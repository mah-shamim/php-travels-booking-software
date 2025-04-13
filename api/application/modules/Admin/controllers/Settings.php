<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');
		
class Settings extends MX_Controller {

		public $role;
		public $langdef;

		function __construct() {
			parent::__construct();
				modules :: load('Admin');
				$chkadmin = modules :: run('Admin/validadmin');
				$superAdmin = $this->session->userdata('pt_logged_super_admin');

				if (!$chkadmin || !$superAdmin) {
					$this->session->set_userdata('prevURL', current_url());


						redirect('admin');

				}

				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
                $this->langdef = DEFLANG;
                $this->data['languages'] = pt_get_languages();
                $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
                $this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
				$this->data['isSuperAdmin'] = $superAdmin;



        }

		public function index() {
				$this->app_settings();
		}

		public function update_spa_settings()
        {
            $data = array(
                'spa_status' =>  $this->input->post('spa_status'),
                'spa_homepage' => $this->input->post('spa_homepage'),
                'spa_module' =>  $this->input->post('spa_module')
            );
            $appSetting = $this->App->service('AppSettingService');
            $appSetting->setSpaSettings($data);
        }

		public function app_settings() {
		        $this->load->helper('themes');
				$this->load->model('Admin/Uploads_model');
				$this->load->model('Admin/Emails_model');
				$this->load->model('Payments_model');
                $this->load->library('Browser');
                $this->data['browserlib'] = $this->browser;
                $this->data['themes'] = directory_map('./themes/',2);
				$seosettings = $this->input->post('seosettings');
				$globalsettings = $this->input->post('globalsettings');
				$updatecurr = $this->input->post('updatecurr');
				$currlist = $this->input->post('default_currencies');
				$bhrs_update = $this->input->post('bhrs_update');
				$watermark_settings = $this->input->post('watermark_settings');
				$mailserver_settings = $this->input->post('mailserver_update');
				//$securitysettings = $this->input->post('securitysettings');
				//$mobilesettings = $this->input->post('mobilesettings');

				$this->data['mobileSettings'] = mobileSettings();

				if (!empty ($updatecurr)) {
						$this->Settings_model->update_currency_code();
						if (!empty ($currlist)) {
								foreach ($currlist as $cl) {
										$this->Settings_model->udpate_currencies($cl);
								}
								$this->Settings_model->change_currencies_status($currlist);
						}
						$this->data['successmsg'] = "Updated Successfully";
				}
				if (!empty ($globalsettings)) {
				        $this->update_spa_settings();
						$error = true;
						$this->Settings_model->update_settings();
						$this->Settings_model->update_seo_settings();
						$this->Settings_model->update_js();
						$this->Settings_model->update_contact_page_details();
						$this->Settings_model->update_watermark_data();
						$this->mobileSettingsUpdate();
                        $mails = $this->input->post('defmailer');
						if ($mails == 'smtp') {
								$this->form_validation->set_rules('smtppass', 'SMTP Password', 'required');
								$this->form_validation->set_rules('smtpuser', 'SMTP Username', 'trim|required');
								$this->form_validation->set_rules('smtphost', 'SMTP Hostname', 'trim|required');
								$this->form_validation->set_rules('smtpport', 'SMTP Port', 'trim|required');
								if ($this->form_validation->run() == FALSE) {
								}
								else {
										$this->Emails_model->update_mailserver();
										$this->data['successmsg'] = "Updated Successfully";
								}
						}
						else {
								$this->Emails_model->update_mailserver();
								$this->data['successmsg'] = "Updated Successfully";
						}
						$this->Settings_model->update_facebook_settings();
						$error = false;
						if (!empty ($_FILES['hlogo']) && !empty ($_FILES['hlogo']['name'])) {
								$res = $this->Uploads_model->__fav_and_logo("hlogo");
								if ($res == "success") {
										$error = false;
								}
								else {
									$this->session->set_flashdata('flashmsgs', $res);
										$error = true;
										$errortxt = $res;
								}
						}
						if (!empty ($_FILES['flogo']) && !empty ($_FILES['flogo']['name'])) {
								$ress = $this->Uploads_model->__fav_and_logo("flogo");
								if ($ress == "success") {
										$error = false;
								}
								else {
									$this->session->set_flashdata('flashmsgs', $ress);
										$error = true;
										$errortxt = $ress;
								}
						}
						if (!empty ($_FILES['favimg']) && !empty ($_FILES['favimg']['name'])) {
								$resss = $this->Uploads_model->__fav_and_logo("favimg");
								if ($resss == "success") {
										$error = false;
								}
								else {
									    $this->session->set_flashdata('flashmsgs', $resss);
										$error = true;
										$errortxt = $resss;
								}
						}

						if (!empty ($_FILES['wmimg']) && !empty ($_FILES['wmimg']['name'])) {
								$resWm = $this->Uploads_model->__fav_and_logo("wmimg");
								if ($resWm == "success") {
										$error = false;
								}
								else {
									    $this->session->set_flashdata('flashmsgs', $resWm);
										$error = true;
										$errortxt = $resWm;
								}
						}

						if ($error == FALSE) {
								$this->data['successmsg'] = "Updated Successfully";
						}
						else {
								$this->data['errormsg'] = $errortxt;
						}

                       redirect('admin/settings/','refresh');


				}

				/*if (!empty ($securitysettings)) {
						$this->Settings_model->update_security();
						$this->data['successmsg'] = "Updated Successfully";
				}

				if (!empty ($mobilesettings)) {
						$this->Settings_model->update_mobile_settings();
						$this->data['successmsg'] = "Updated Successfully";
				}*/
				$paymentdata = $this->Payments_model->getAllPaymentsBack();
				$this->data['all_payments'] = $paymentdata;
				$this->data['contact_data'] = $this->Settings_model->get_contact_page_details();
				$this->data['settings'] = $this->Settings_model->get_settings_data();
				$this->data['wm_settings'] = $this->Settings_model->get_watermark_data();
				$this->data['currencies'] = $this->Settings_model->get_currencies();
				$this->data['mailserver'] = $this->Emails_model->get_mailserver();
				$this->data['fbsettings'] = $this->Settings_model->get_facebook_settings();
				$flashMsg = $this->session->flashdata('flashmsgs');
				if(!empty($flashMsg)){
				$this->data['errormsg'] = $flashMsg;
				}
                $appSetting = $this->App->service('AppSettingService');
				$spa_settings = $appSetting->getSpaSettings();
                $this->data['spa_settings'] = $spa_settings;
                $this->data['spa_homepage_dd'] = $this->get_spa_homepage_dd($spa_settings);
				$this->data['main_content'] = 'settings/application-settings';
				$this->data['page_title'] = 'Application Settings';
				$this->load->view('template', $this->data);
		}

		public function get_spa_homepage_dd($spa_settings)
        {
            $module = rtrim($spa_settings->spa_module, 's');
            $this->db->select($module.'_title AS title');
            $dataAdapter = $this->db->get('pt_'.$module.'s');
            $html = '';
            if($dataAdapter->num_rows() > 0) {
                foreach ($dataAdapter->result() as $dataset) {
                    $selected = ($spa_settings->spa_homepage == $dataset->title)?'selected':'';
                    $html .= '<option value="'.$dataset->title.'" '.$selected.'>'.$dataset->title.'</option>';
                }
            }
            return $html;
        }

		public function modules() {
				$this->data['modules'] = $this->App->service('ModuleService')->all();
				$this->data['main_content'] = 'settings/modules';
				$this->data['page_title'] = 'Modules';
				$this->load->view('template', $this->data);
		}

		public function widgets($args = null, $widgetid = null) {
			$this->load->library('Ckeditor');
			$this->data['ckconfig'] = array();
			$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
			$this->data['ckconfig']['language'] = 'en';
			$this->data['ckconfig']['height'] = '350px';
			$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
			$this->load->model("Admin/Widgets_model");

	if ($args == 'add') {
						$action = $this->input->post('action');
						if ($action == "add") {
								$this->form_validation->set_rules('title', 'Widget Name', 'trim|required');
								$this->form_validation->set_rules('widgetbody', 'Widget Content', 'trim');
								if ($this->form_validation->run() == FALSE) {
								}
								else {
										$widgetid = $this->Widgets_model->addWidget();
                                        $this->session->set_flashdata('flashmsgs', 'Widget added Successfully');
										redirect('admin/settings/widgets');

								}
						}
						$this->data['action'] = 'add';
						$this->data['main_content'] = 'settings/manage_widgets';
						$this->data['page_title'] = 'Widgets - Add Widget';
						$this->load->view('template', $this->data);
				}
				elseif ($args == 'edit') {

						if (empty ($widgetid)) {
								redirect('admin/settings/widgets');
						}
						else {
								$updatepage = $this->input->post('action');
								if ($updatepage == "update") {
								     	$pagetitle = $this->input->post('title');
										$this->form_validation->set_rules('title', 'Widget Name', 'trim|required');

										if ($this->form_validation->run() == FALSE) {
										}
										else {
											$this->Widgets_model->updateWidget($widgetid);
											redirect('admin/settings/widgets');

										}
								}

								$this->data['widgetid'] = $widgetid;
								$this->data['action'] = "update";
								$this->data['details'] = $this->Widgets_model->getWidgetDetails($widgetid);
								$this->data['main_content'] = 'settings/manage_widgets';
								$this->data['page_title'] = 'Widgets - Edit Page';
								$this->load->view('template', $this->data);
						}
				}else{

				$this->load->helper('xcrud');
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_widgets');
				$xcrud->order_by('widget_id','desc');
				$xcrud->columns('widget_name,widget_id, widget_status');
				$xcrud->label('widget_id','Widget Code');
				$xcrud->column_callback('widget_id', 'widgetCode');
				$xcrud->search_columns('widget_name,widget_status');
				$xcrud->fields('widget_name,widget_status,widget_content');
				$xcrud->limit(50);

				$xcrud->unset_add();
				$xcrud->unset_view();
				$xcrud->unset_edit();

				$this->data['addpermission'] = true;

				$this->data['add_link'] = base_url().'admin/settings/widgets/add';

				$xcrud->button(base_url() .'admin/settings/widgets/edit/{widget_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));

				$this->data['content'] = $xcrud->render();
				//$this->data['dontload'] = "yes";
				$this->data['page_title'] = 'Widgets Management';
				$this->data['main_content'] = 'temp_view';
                $this->data['table_name'] = 'pt_widgets';
                $this->data['main_key'] = 'widget_id';
				$this->data['header_title'] = 'Widgets Management';
				$this->load->view('Admin/template', $this->data);



				}




				}

/*old paymentgateways function*/
		// public function paymentgateways() {
		// 		$this->load->model('Payments_model');
		// 		$action = $this->input->post('action');
		// 		if ($action == "activate") {

		// 			$gateway = $this->input->post('gateway');
		// 			$gatewayconfig = $this->Payments_model->getGatewayConfigData($gateway);
		// 			$this->Payments_model->activateGateway($gatewayconfig);
		// 			redirect('admin/settings/paymentgateways');
		// 		}
		// 		if ($action == "save") {

		// 			//print_r($this->input->post()); exit;
		// 			$this->Payments_model->updateGateway();
		// 			redirect('admin/settings/paymentgateways');
		// 		}
		// 		if ($action == "deactivate") {

		// 			$this->Payments_model->deActivateGateway();
		// 			redirect('admin/settings/paymentgateways');
		// 		}
		// 		$this->data['all_payments'] = $this->Payments_model->getAllPaymentsBack();

		// 		//sort on basic of order
		// 		usort($this->data['all_payments']['activeGateways'], function($a, $b) {
		// 			return $a['order'] - $b['order'];
		// 			});
		// 		//end sort on basis of order

		// 		$this->data['main_content'] = 'settings/payment-gateways';
		// 		$this->data['page_title'] = 'Payment Gateways';
		// 		$this->load->view('template', $this->data);
		// }

		public function themesettings() {
				$this->load->helper('directory');
				$this->load->helper('themes');
				$uploadtheme = $this->input->post('uploadtheme');
				if (!empty ($uploadtheme)) {
//  $this->data['msg'] =  $this->Settings_model->pt_install_theme();
				}
				$this->data['currtheme'] = $this->Settings_model->get_theme();
				$this->data['main_content'] = 'settings/themesettings';
				$this->data['page_title'] = 'Theme Settings';
				$this->load->view('template', $this->data);
		}

		public function sliders($trans = null, $id = null, $lang = null) {

        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_sliders');

        if (!empty ($trans) && !empty ($id)) {
						$this->load->library('sliders_lib');
                        $this->data['sliderlib'] = $this->sliders_lib;
						$this->sliders_lib->set_id($id);

						$update = $this->input->post('update');

						if (empty ($id)) {
								redirect('admin/sliders/');
						}

						if (!empty ($update)) {
						  $this->sliders_lib->update_translation($this->input->post('translated'),$id);
                      	  redirect("admin/settings/sliders/translate/" . $id);
						}

						$this->data['slideid'] = $this->sliders_lib->get_id();
						$this->data['lang'] = $lang;
 						$this->data['main_content'] = 'settings/slidertranslate';
						$this->data['page_title'] = 'Translate Slide';
						$this->load->view('template', $this->data);
				}else{
                        $xcrud->change_type('slide_image', 'image', false, array(
                        'path' => '../../'.PT_SLIDER_IMAGES_UPLOAD
                        ));
                        $xcrud->columns('slide_image,slide_title_text,slide_desc_text,slide_optional_text,slide_status,slide_order,slide_link');
                        $xcrud->fields('slide_image,slide_title_text,slide_desc_text,slide_optional_text, slide_status'); // fields in details
                        $xcrud->column_callback('slide_order', 'orderInputSlider');
                        $xcrud->column_callback('slide_link', 'translateSlider');
                        $xcrud->column_class('slide_image','zoom_img');
                        $xcrud->label('slide_link','Translate');
                        $this->data['content'] = $xcrud->render();
                        $this->data['page_title'] = 'Slider Management';
                        $this->data['main_content'] = 'temp_view';
                        $this->data['table_name'] = 'pt_sliders';
                        $this->data['main_key'] = 'slide_id';
                        $this->data['header_title'] = 'Slider Management';
                        $this->load->view('template', $this->data);


				}
		}

		public function social() {

        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_socials');
        $xcrud->change_type('social_icon', '', false, array(
        'width' => 450,
        'path' => '../../'.PT_SOCIAL_IMAGES_UPLOAD));

        $xcrud->columns('social_icon,social_name,social_link,social_order,social_status');
        $xcrud->fields('social_icon,social_name,social_link,social_status,social_position'); // fields in details
        $xcrud->change_type('social_position','hidden','footer');
        $xcrud->column_class('social_icon','zoom_img');
        $xcrud->column_callback('social_order', 'orderInputSocial');

        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Social Connections Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_socials';
        $this->data['main_key'] = 'social_id';
        $this->data['header_title'] = 'Social Connections Management';
        $this->load->view('template', $this->data);
    }

   		// function for paymentgateways_new
   		public function paymentgateways() {
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('payment_gateways');
        $xcrud->order_by('order','asc');
        $xcrud->columns('name,status,dev,dev_endpoint,pro_endpoint,order');
        $xcrud->fields('name,status,dev,c1,c2,c3,c4,c5,dev_endpoint,pro_endpoint,order');
        $xcrud->column_callback('status','pay_status');
        $xcrud->column_callback('dev','pay_status');
        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'PAYMENT GATEWAYS MANAGEMENT';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'payment_gateways';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'PAYMENT GATEWAYS MANAGEMENT';
        $this->load->view('template', $this->data);
    }

		public function cscm($args = null) {

		}

		public function dummy() {
				$this->data['main_content'] = 'modules/hotels/dummy';
				$this->data['page_title'] = 'Social Connections';
				$this->load->view('template', $this->data);
		}

		function integrations() {
			redirect('admin/settings');
				/*$hasintegration = $this->ptmodules->has_integration();
				if ($hasintegration) {
						$this->data['modules'] = $this->ptmodules->integratedmodules;
						$this->data['main_content'] = 'settings/integrations';
						$this->data['page_title'] = 'Modules';
						$this->load->view('template', $this->data);
				}
				else {
						redirect('admin/settings');
				}*/
		}

        function api(){
        	redirect('admin');
             /* $submit = $this->input->post('mobilesettings');
              if(!empty($submit)){
                $data = array(
                'default_gateway' => $this->input->post('defaultgateway')
                );
                $this->db->where('user','webadmin');
                $this->db->update('pt_app_settings',$data);
                $this->session->set_flashdata('flashmsgs', 'Updated Successfully');
                redirect('admin/settings/mobile');

              }
              $this->data['settings'] = $this->Settings_model->get_settings_data();
              $this->load->model('Payments_model');
              $this->data['all_payments'] = $this->Payments_model->get_all_payments_back();
              $this->data['main_content'] = 'settings/api';
              $this->data['page_title'] = 'API Settings';
              $this->load->view('template', $this->data);*/
        } 

       public function currencies(){
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_currencies');
        $xcrud->columns('name,symbol,code,rate,is_active,is_default');
        $xcrud->column_callback('is_default', 'MakeDefault');
        $xcrud->search_columns('name,symbol,code,rate,is_active');
        $xcrud->label('is_active','Active')->label('is_default','Default');
        $xcrud->fields('name,symbol,code,rate,is_active');
        $xcrud->limit(25);

        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Currencies Management';
        $this->data['main_content'] = 'currency_view';
        $this->data['table_name'] = 'pt_currencies';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Currencies Management';
        $this->load->view('template', $this->data);

       }


       function redirectSettings($param = null){
      redirect('admin/settings/'.$param,'refresh');
   }

   /*Currceny Api and data update*/
   public function cron()
   {
	require_once  FCPATH.'/config/currency.php';
	   $currencies = $this->Settings_model->all_currencies();
	   $send_currency = "";
	   foreach ($currencies as $index => $currency) {
		   if ($index == 0) {
			   $send_currency = $currency->name;
		   } else {
			   $send_currency = $send_currency . "," . $currency->name;
		   }
	   }
	   $result = (array)json_decode(file_get_contents('http://apilayer.net/api/live?access_key='.$currency_key.'&source=USD&currencies=' . $send_currency))->quotes;
	  if(!empty($result)) {
          foreach ($currencies as $currency) {
              $currency_or = $this->Settings_model->curency_by_id($currency->id);
              $currency_or["rate"] = $result["USD" . $currency->name];
              $this->Settings_model->update($currency_or["id"], $currency_or);
          }
      }
	  return  redirect('admin/settings/currencies','refresh');
   }
   public function downloadSitemap(){
   			$this->load->helper('download');
			$data =  $data = file_get_contents(base_url().'sitemap.xml');
			$name = 'sitemap.xml';

			force_download($name, $data);
   }

   public function mobileSettingsUpdate(){

   	$mobile = $this->input->post('mobile');
   	if(!empty($mobile)){
   		foreach($mobile as $key => $val){
   			$this->db->where('settingsKey',$key);
   			$num = $this->db->get('pt_mobile_settings')->num_rows();

   			if($num > 0){
   				$data = array('settingsValue' => $val);
   				$this->db->where('settingsKey',$key);
   				$this->db->update('pt_mobile_settings',$data);
   			}else{
   				$insdata = array('settingsKey' => $key,'settingsValue' => $val);
   				$this->db->insert('pt_mobile_settings',$insdata);

   			}
   		}
   	}

   }

}
