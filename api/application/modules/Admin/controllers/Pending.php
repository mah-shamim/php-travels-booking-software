<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Pending extends MX_Controller {

		public $role;

//private $userid = 1; //$this->session->userdata('userid');
		function __construct() {
				parent :: __construct();
				modules :: load('Admin');
				$chkadmin = modules :: run('Admin/validadmin');
				if (!$chkadmin) {
					$this->session->set_userdata('prevURL', current_url());
						redirect('admin');
				}
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    			$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
    			$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
    
// $this->data['modModel'] = $this->modules_model;
		}

		public function index() {
				$filter = $this->input->post('filter');
                $this->data['pendingitems'] = pendings_result();
				$this->data['filter'] = $filter;
				$this->data['type'] = $this->input->post('type');
				$this->data['module'] = $this->input->post('module');
				$this->data['chkinghotels'] = $this->ptmodules->is_mod_available_enabled("hotels");
				$this->data['chkingtours'] = $this->ptmodules->is_mod_available_enabled("tours");
				$this->data['chkingcars'] = $this->ptmodules->is_mod_available_enabled("cars");
				$this->data['chkingcruises'] = $this->ptmodules->is_mod_available_enabled("cruises");
				if (!empty ($filter)) {
						if ($this->data['type'] == 'reviews') {
								$chking = modules :: run('home/is_module_enabled', 'reviews');
								if (!$chking) {
										redirect('admin');
								}
								$this->data['reviews'] = $this->get_all_pending_reviews($this->data['module']);
						}
						if ($this->data['type'] == 'images') {
								if ($this->data['module'] == "hotels") {
										$chking = $this->ptmodules->is_mod_available_enabled("hotels");
										if (!$chking) {
												redirect('admin');
										}
										$this->data['hotelimages'] = $this->get_all_pending_images('hotels');
								}
								elseif ($this->data['module'] == "rooms") {
										$chking = $this->ptmodules->is_mod_available_enabled("hotels");
										if (!$chking) {
												redirect('admin');
										}
										$this->data['roomimages'] = $this->get_all_pending_images('rooms');
								}
								elseif ($this->data['module'] == "cruises") {
										$chking = $this->ptmodules->is_mod_available_enabled("cruises");
										if (!$chking) {
												redirect('admin');
										}
										$this->data['cruiseimages'] = $this->get_all_pending_images('cruises');
								}
								elseif ($this->data['module'] == "crooms") {
										$chking = $this->ptmodules->is_mod_available_enabled("cruises");
										if (!$chking) {
												redirect('admin');
										}
										$this->data['croomimages'] = $this->get_all_pending_images('crooms');
								}
								elseif ($this->data['module'] == "tours") {
										$chking = $this->ptmodules->is_mod_available_enabled("tours");
										if (!$chking) {
												redirect('admin');
										}
										$this->data['tourimages'] = $this->get_all_pending_images('tours');
								}
								elseif ($this->data['module'] == "cars") {
										$chking = $this->ptmodules->is_mod_available_enabled("cars");
										if (!$chking) {
												redirect('admin');
										}
										$this->data['carimages'] = $this->get_all_pending_images('cars');
								}
						}
                        if ($this->data['type'] == 'accounts') {
								if ($this->data['module'] == "supplier") {
										$this->data['supplier'] = $this->get_all_pending_accounts('supplier');
								}
								elseif ($this->data['module'] == "customers") {
										$this->data['customers'] = $this->get_all_pending_accounts('customers');
								}
						}
				}
				$this->data['main_content'] = 'modules/pending/pending';
				$this->data['page_title'] = 'Pending';
				$this->load->view('template', $this->data);
		}

		public function get_all_pending_reviews($module) {
			   	$this->db->where('review_status', '0');
				$this->db->where('review_module', $module);
				$this->db->order_by('review_id', 'desc');
				return $this->db->get('pt_reviews')->result();
		}

		public function get_all_pending_images($module) {
				if ($module == "hotels") {
						$this->db->where('himg_approved', '0');
						return $this->db->get('pt_hotel_images')->result();
				}
				elseif ($module == "rooms") {
						$this->db->where('rimg_approved', '0');
						return $this->db->get('pt_room_images')->result();
				}
				elseif ($module == "cruises") {
						$this->db->where('cimg_approved', '0');
						return $this->db->get('pt_cruise_images')->result();
				}
				elseif ($module == "crooms") {
						$this->db->where('rimg_approved', '0');
						return $this->db->get('pt_cruise_room_images')->result();
				}
				elseif ($module == "tours") {
						$this->db->where('timg_approved', '0');
						return $this->db->get('pt_tour_images')->result();
				}
				elseif ($module == "cars") {
						$this->db->where('cimg_approved', '0');
						return $this->db->get('pt_car_images')->result();
				}
		}

        public function get_all_pending_accounts($module) {
				if ($module == "supplier") {
						$this->db->select('accounts_id,ai_first_name,ai_last_name,accounts_email');
						$this->db->where('accounts_status', '0');
						$this->db->where('accounts_type', 'supplier');
						return $this->db->get('pt_accounts')->result();
				}
				elseif ($module == "customers") {
				        $this->db->select('accounts_id,ai_first_name,ai_last_name,accounts_email');
						$this->db->where('accounts_status', '0');
						$this->db->where('accounts_type', 'customers');
						return $this->db->get('pt_accounts')->result();
				}
		}

		function accept_single_review() {
				$id = $this->input->post('id');
				$data = array('review_status' => '1');
				$this->db->where('review_id', $id);
				$this->db->update('pt_reviews', $data);
		}

		function accept_single_image() {
				$id = $this->input->post('id');
				$module = $this->input->post('moduletype');
				if ($module == "hotels") {
						$data = array('himg_approved' => '1');
						$this->db->where('himg_id', $id);
						$this->db->update('pt_hotel_images', $data);
				}
				elseif ($module == "rooms") {
						$data = array('rimg_approved' => '1');
						$this->db->where('rimg_id', $id);
						$this->db->update('pt_room_images', $data);
				}
				elseif ($module == "crooms") {
						$data = array('rimg_approved' => '1');
						$this->db->where('rimg_id', $id);
						$this->db->update('pt_cruise_room_images', $data);
				}
				elseif ($module == "tours") {
						$data = array('timg_approved' => '1');
						$this->db->where('timg_id', $id);
						$this->db->update('pt_tour_images', $data);
				}
				elseif ($module == "cars") {
						$data = array('cimg_approved' => '1');
						$this->db->where('cimg_id', $id);
						$this->db->update('pt_car_images', $data);
				}
				elseif ($module == "cruises") {
						$data = array('cimg_approved' => '1');
						$this->db->where('cimg_id', $id);
						$this->db->update('pt_cruise_images', $data);
				}
		}


		function accept_multiple_images() {
				$imglist = $this->input->post('imglist');
				$module = $this->input->post('moduletype');
				foreach ($imglist as $img) {
						if ($module == "hotels") {
								$data = array('himg_approved' => '1');
								$this->db->where('himg_id', $img);
								$this->db->update('pt_hotel_images', $data);
						}
						elseif ($module == "rooms") {
								$data = array('rimg_approved' => '1');
								$this->db->where('rimg_id', $img);
								$this->db->update('pt_room_images', $data);
						}
						elseif ($module == "crooms") {
								$data = array('rimg_approved' => '1');
								$this->db->where('rimg_id', $img);
								$this->db->update('pt_cruise_room_images', $data);
						}
						elseif ($module == "tours") {
								$data = array('timg_approved' => '1');
								$this->db->where('timg_id', $img);
								$this->db->update('pt_tour_images', $data);
						}
						elseif ($module == "cars") {
								$data = array('cimg_approved' => '1');
								$this->db->where('cimg_id', $img);
								$this->db->update('pt_car_images', $data);
						}
						elseif ($module == "cruises") {
								$data = array('cimg_approved' => '1');
								$this->db->where('cimg_id', $img);
								$this->db->update('pt_cruise_images', $data);
						}
				}
				$this->session->set_flashdata('flashmsgs', "Accepted Successfully");
		}



		function reject_single_image() {
				$id = $this->input->post('id');
				$module = $this->input->post('moduletype');
				$name = $this->input->post('imgname');
				$type = $this->input->post('imgtype');
				if ($module == "hotels") {
						$this->load->model("Hotels/Hotels_model");
						$this->Hotels_model->delete_image($name, $type, $id);
				}
				elseif ($module == "rooms") {
						$this->load->model("Hotels/Rooms_model");
						$this->Rooms_model->delete_image($name, $id, $type);
				}
				elseif ($module == "crooms") {
						$this->load->model("cruises/cruises_rooms_model");
						$this->cruises_rooms_model->delete_image($name, $id, $type);
				}
				elseif ($module == "tours") {
						$this->load->model("Tours/Tours_model");
						$this->Tours_model->delete_image($name, $id, $type);
				}
				elseif ($module == "cars") {
						$this->load->model("cars/Cars_model");
						$this->Cars_model->delete_image($name, $id, $type);
				}
				elseif ($module == "cruises") {
						$this->load->model("cruises/cruises_model");
						$this->cruises_model->delete_image($name, $id, $type);
				}
		}

		function reject_multiple_images() {
				$this->load->model("Hotels/Hotels_model");
				$this->load->model("Hotels/Rooms_model");
				$imglist = $this->input->post('imglist');
				$module = $this->input->post('moduletype');
				foreach ($imglist as $img) {
						if ($module == "hotels") {
								$this->db->select('himg_type,himg_image');
								$this->db->where('himg_id', $img);
								$rs = $this->db->get('pt_hotel_images')->result();
								$imgtype = $rs[0]->himg_type;
								$imgname = $rs[0]->himg_image;
								$this->Hotels_model->delete_image($imgname, $imgtype, $img);
						}
						elseif ($module == "rooms") {
								$this->db->select('rimg_type,rimg_image');
								$this->db->where('rimg_id', $img);
								$rs = $this->db->get('pt_room_images')->result();
								$imgtype = $rs[0]->rimg_type;
								$imgname = $rs[0]->rimg_image;
								$this->Rooms_model->delete_image($imgname, $img, $imgtype);
						}
						elseif ($module == "crooms") {
								$this->load->model("cruises/cruises_rooms_model");
								$this->db->select('rimg_type,rimg_image');
								$this->db->where('rimg_id', $img);
								$rs = $this->db->get('pt_cruise_room_images')->result();
								$imgtype = $rs[0]->rimg_type;
								$imgname = $rs[0]->rimg_image;
								$this->cruises_rooms_model->delete_image($imgname, $img, $imgtype);
						}
						elseif ($module == "tours") {
								$this->load->model("Tours/Tours_model");
								$this->db->select('timg_type,timg_image');
								$this->db->where('timg_id', $img);
								$rs = $this->db->get('pt_tour_images')->result();
								$imgtype = $rs[0]->timg_type;
								$imgname = $rs[0]->timg_image;
								$this->Tours_model->delete_image($imgname, $img, $imgtype);
						}
						elseif ($module == "cruises") {
								$this->load->model("cruises/cruises_model");
								$this->db->select('cimg_type,cimg_image');
								$this->db->where('cimg_id', $img);
								$rs = $this->db->get('pt_cruise_images')->result();
								$imgtype = $rs[0]->cimg_type;
								$imgname = $rs[0]->cimg_image;
								$this->cruises_model->delete_image($imgname, $img, $imgtype);
						}
				}
				$this->session->set_flashdata('flashmsgs', "Rejected Successfully");
		}

		function accept_multiple_review() {
				$reviewlist = $this->input->post('reviewlist');
				foreach ($reviewlist as $review) {
						$data = array('review_status' => '1');
						$this->db->where('review_id', $review);
						$this->db->update('pt_reviews', $data);
				}
				$this->session->set_flashdata('flashmsgs', "Accepted Successfully");
		}

		function reject_single_review() {
				$id = $this->input->post('id');
				$this->db->where('review_id', $id);
				$this->db->delete('pt_reviews');
		}

		function reject_multiple_review() {
				$reviewlist = $this->input->post('reviewlist');
				foreach ($reviewlist as $id) {
						$this->db->where('review_id', $id);
						$this->db->delete('pt_reviews');
				}
				$this->session->set_flashdata('flashmsgs', "Rejected Successfully");
		}

        function reject_accountsingle() {
				$id = $this->input->post('id');
				$this->db->where('accounts_id', $id);
				$this->db->delete('pt_accounts');
		}

        function accept_accountsingle() {
				$id = $this->input->post('id');
               			$data = array('accounts_verified' => '1', 'accounts_status' => '1');
						$this->db->where('accounts_id', $id);
						$this->db->update('pt_accounts', $data);
				$this->session->set_flashdata('flashmsgs', "Accepted Successfully");
		}

        function reject_multiple_accounts() {
			   $acclist = $this->input->post('acclist');
				foreach ($acclist as $acc) {
                  $this->db->where('accounts_id',$acc);
                  $this->db->delete('pt_accounts');
				}
				$this->session->set_flashdata('flashmsgs', "Rejected Successfully");
		}

        function accept_multiple_accounts() {
			   $acclist = $this->input->post('acclist');
				foreach ($acclist as $acc) {
                	$data = array('accounts_verified' => '1', 'accounts_status' => '1');
						$this->db->where('accounts_id', $acc);
						$this->db->update('pt_accounts', $data);
				}
				$this->session->set_flashdata('flashmsgs', "Rejected Successfully");
		}

}