<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Newsletter extends MX_Controller {

		public $role;
		function __construct() {
//	echo modules::run('Admin/validadmin');
				modules :: load('Admin');
				$chkadmin = modules :: run('Admin/validadmin');
				if (!$chkadmin) {
					$this->session->set_userdata('prevURL', current_url());
						redirect('admin');
				}
				$chk = modules :: run('Home/is_module_enabled', 'newsletter');
				if (!$chk) {
					$this->session->set_userdata('prevURL', current_url());
						redirect('admin');
				}
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    			$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
    			$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;

				if (!pt_permissions('newsletter', $this->data['userloggedin'])) {
						redirect('admin');
				}
		}

		public function index() {
				$this->load->helper('xcrud');
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_newsletter');
               	$xcrud->order_by('newsletter_id', 'desc');
                $xcrud->unset_add();
                $xcrud->label('newsletter_type','Type');
                $xcrud->label('newsletter_status','Enabled');
                $this->data['add_link'] = base_url().'admin/newsletter/send';
                $this->data['addpermission'] = true;
				$this->data['content'] = $xcrud->render();
				$this->data['page_title'] = 'Newsletter Management';
				$this->data['main_content'] = 'newsletter_view';
                $this->data['table_name'] = 'pt_newsletter';
                $this->data['main_key'] = 'newsletter_id';
                $this->data['header_title'] = 'Newsletter Management';
				$this->load->view('template', $this->data);
                $xcrud->unset_edit();
                }

        	public function send() {
                $news_inc = $this->__newsletter_includes();
                $this->data['fblink'] = $news_inc['facebook'][0]->social_link;
                $this->data['twitterlink'] = $news_inc['twitter'][0]->social_link;
                $this->data['admin_email'] =  $news_inc['main'][0]->accounts_email;
                $this->data['mobile'] =  $news_inc['main'][0]->ai_mobile;
                $this->data['twittericon'] = PT_SOCIAL_IMAGES.$news_inc['twitter'][0]->social_icon;
                $this->data['fbicon'] = PT_SOCIAL_IMAGES.$news_inc['facebook'][0]->social_icon;
                $this->data['logo'] =  PT_GLOBAL_IMAGES_FOLDER.$news_inc['main'][0]->header_logo_img;
                $this->data['hometitle'] =  $news_inc['main'][0]->home_title;
                $this->data['sitetitle'] = $news_inc['main'][0]->site_title;
                $sendnews = $this->input->post('sendnews');
                $this->data['newslist'] = $this->Newsletter_model->get_all_subscribers();
                if(!empty($sendnews)){
                $type = $this->input->post('sendto');
                $emails = $this->Newsletter_model->get_emails($type);
                $subject = $this->input->post('subject');
                $site_url = base_url();
                $msg =  $this->input->post('content');

                $this->Newsletter_model->sendNewsletter($msg,$subject);
                $this->session->set_flashdata('flashmsgs', "Newsletter Sent Successfully");
                redirect('admin/newsletter/');
                }

				$this->data['page_title'] = 'Send Newsletter';
				$this->data['main_content'] = 'newsletter/send';
			  	$this->data['header_title'] = 'Newsletter Management';
				$this->load->view('template', $this->data);
		}

		function __newsletter_includes() {
				$this->db->select('pt_app_settings.site_title,pt_app_settings.home_title,pt_app_settings.header_logo_img,pt_accounts.accounts_email,pt_accounts.ai_mobile');
				$this->db->join('pt_app_settings', 'pt_accounts.accounts_type = pt_app_settings.user');
				$data['main'] = $this->db->get('pt_accounts')->result();
				$this->db->select('social_name,social_link,social_icon');
				$this->db->where('social_name', 'facebook');
				$data['facebook'] = $this->db->get('pt_socials')->result();
				$this->db->select('social_name,social_link,social_icon');
				$this->db->where('social_name', 'twitter');
				$data['twitter'] = $this->db->get('pt_socials')->result();
				return $data;
		}

		function delMultipleSubscribers(){
			$items = $this->input->post('items');
			foreach($items as $item){
				$this->db->where('newsletter_id',$item);
				$this->db->delete('pt_newsletter');
			}
		}

}
