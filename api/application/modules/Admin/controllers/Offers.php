<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Offers extends MX_Controller {
		public $role;

		function __construct() {
				modules :: load('Admin');
				$chkadmin = modules :: run('Admin/validadmin');
				if (!$chkadmin) {
					$this->session->set_userdata('prevURL', current_url());
						redirect('admin');
				}
				$seturl = $this->uri->segment(3);
				if ($seturl != "settings") {
						$chk = modules :: run('home/is_module_enabled', 'offers');
						if (!$chk) {
								redirect('admin');
						}
				}
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				$checkingadmin = $this->session->userdata('pt_logged_admin');
				if (!empty ($checkingadmin)) {
						$this->data['adminsegment'] = "admin";
				}
				else {
						$this->data['adminsegment'] = "supplier";
				}
				if (!pt_permissions('offers', $this->data['userloggedin'])) {
						redirect('admin');
				}
				$this->load->model('Admin/Special_offers_model');
				$this->load->helper('settings');
                $this->load->library('Ckeditor');
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
				$this->data['languages'] = pt_get_languages();
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
				$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;

		}

		function index() {
				$this->load->helper('xcrud');
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_special_offers');
				$xcrud->order_by('offer_id','desc');
                $xcrud->unset_add();
                $xcrud->unset_view();
                $xcrud->unset_edit();
                $xcrud->unset_remove();
                $this->data['addpermission'] = true;
                $xcrud->column_width('offer_thumb', '10%');
                $xcrud->column_width('offer_order', '10%');
                $xcrud->columns('offer_thumb,offer_title,offer_price,offer_status,offer_forever,offer_order');
                $xcrud->search_columns('offer_title,offer_price,offer_order');
                $xcrud->button(base_url() . $this->data['adminsegment'] . '/offers/manage/{offer_slug}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));

                $delurl = base_url().'admin/ajaxcalls/delOffer';
                $xcrud->column_class('offer_thumb', 'zoom_img');
                $xcrud->change_type('offer_thumb', 'image', false, array('width' => 200, 'path' => '../../'.PT_OFFERS_THUMBS_UPLOAD, 'thumbs' => array(array('height' => 150, 'width' => 120, 'crop' => true, 'marker' => ''))));
                $xcrud->label('offer_thumb','Thumbnail');
                $xcrud->label('offer_forever','Gallery');
                $xcrud->label('offer_order','Order');
                $xcrud->label('offer_price','Price');
                $xcrud->label('offer_title','Title');
                $xcrud->column_callback('offer_forever', 'OffersPhotos');
                $xcrud->column_callback('offer_order', 'orderInputOffers');
                $this->data['add_link'] = base_url(). $this->data['adminsegment'] . '/offers/add';
                $this->data['content'] = $xcrud->render();

				$this->data['page_title'] = 'Offers Management';
				$this->data['main_content'] = 'temp_view';
                $this->data['table_name'] = 'pt_special_offers';
                $this->data['main_key'] = 'offer_id';
				$this->data['header_title'] = 'Offers Management';
				$this->load->view('template', $this->data);
		}

        function add() {
        $this->load->model('Admin/Uploads_model');
				$addoffer = $this->input->post('submittype');
                $this->data['submittype'] = "add";

				if (!empty ($addoffer)) {
						$this->form_validation->set_rules('offertitle', 'Offer Title', 'trim|required');
						$this->form_validation->set_rules('offerdesc', 'Offer Description', 'trim|required');
				 		if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
								$this->Special_offers_model->add_offer();

								$this->session->set_flashdata('flashmsgs', 'Offer added Successfully');
								echo "done";
						}
				}
				else {

				$this->data['page_title'] = 'Add Offer';
				$this->data['main_content'] = 'modules/offers/manage';
				$this->data['header_title'] = 'Offers Management';
				$this->load->view('template', $this->data);
				}





		}


        function manage($offerslug) {
				if (empty ($offerslug)) {
						redirect($this->data['adminsegment'] . '/offers/');
				}

				$updateoffer = $this->input->post('submittype');
				$this->data['submittype'] = "update";
				$offerid = $this->input->post('offerid');
				if (!empty ($updateoffer)) {
						$this->form_validation->set_rules('offertitle', 'Offer Title', 'trim|required');
						$this->form_validation->set_rules('offerdesc', 'Offer Description', 'trim|required');
				 		if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							   	$this->Special_offers_model->update_offer($offerid);
								$this->session->set_flashdata('flashmsgs', 'Offer Updated Successfully');
								echo "done";
						}
				}
				else {
					   @$this->data['offerdata'] = $this->Special_offers_model->get_offer_data($offerslug);


						$this->data['headingText'] = 'Update ' . $this->data['offerdata'][0]->offer_title;
						$this->data['ofrom'] = pt_show_date_php($this->data['offerdata'][0]->offer_from);
						$this->data['oto'] = pt_show_date_php($this->data['offerdata'][0]->offer_to);
                        $this->data['offerid'] = $this->data['offerdata'][0]->offer_id;
                        $this->data['main_content'] = 'modules/offers/manage';
                        $this->data['header_title'] = 'Offers Management';
                        $this->load->view('template', $this->data);
				}
		}

		function settings() {
				$updatesett = $this->input->post('updatesettings');
				if (!empty ($updatesett)) {
						$this->Settings_model->update_front_settings();
						redirect('admin/offers/settings');
				}
				$this->data['settings'] = $this->Settings_model->get_front_settings("offers");
				$this->data['main_content'] = 'modules/offers/settings';
				$this->data['page_title'] = 'Special Offer Settings';
				$this->load->view('template', $this->data);
		}

        function gallery($id) {
				$this->data['images'] = $this->Special_offers_model->offerGallery($id);
                $this->data['imgorderUrl'] = base_url().'admin/ajaxcalls/update_offer_image_order';
                $this->data['uploadUrl'] = base_url().'admin/offers/galleryUpload/';
                $this->data['delimgUrl'] = base_url().'admin/ajaxcalls/delete_offer_image';
                $this->data['makeThumbUrl'] = base_url().'admin/ajaxcalls/offer_makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'admin/ajaxcalls/deleteMultipleOfferImages';
                $this->data['fullImgDir'] = PT_OFFERS_IMAGES;
                $this->data['thumbsDir'] = PT_OFFERS_THUMBS;
               	$this->data['itemid'] = $id;
                $this->data['main_content'] = 'Admin/gallery';
				$this->data['page_title'] = 'Offers Gallery';
				$this->load->view('Admin/template', $this->data);
		}

		function galleryUpload($id) {
				$this->load->library('image_lib');
				if (!empty ($_FILES)) {
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						$fileName = str_replace(" ", "-", $_FILES['file']['name']);
						$fig = rand(1, 999999);
						$saveFile = $fig . '_' . $fileName;

						if (strpos($fileName,'php') !== false) {

						}else{
						$targetPath = PT_OFFERS_IMAGES_UPLOAD;

						$targetFile = $targetPath . $saveFile;
						move_uploaded_file($tempFile, $targetFile);
						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;

						$config['new_image'] = PT_OFFERS_THUMBS_UPLOAD;
						$config['thumb_marker'] = '';
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = THUMB_WIDTH;
						$config['height'] = THUMB_HEIGHT;
						$this->image_lib->clear();
						$this->image_lib->initialize($config);
						$this->image_lib->resize();

						modules :: run('Admin/watermark/apply',$targetFile);

					/* Add images name to database with respective offer id */
					$this->Special_offers_model->addPhotos($id, $saveFile);
         	}

					}
		}


		}
