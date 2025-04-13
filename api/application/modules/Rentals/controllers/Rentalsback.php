<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Rentalsback extends MX_Controller {
	    public $accType = "";
		private $langdef;
		public  $editpermission = true;
        public  $deletepermission = true;

		function __construct() {
				$chk = modules :: run('Home/is_main_module_enabled', 'rentals');
				$seturl = $this->uri->segment(3);
				if ($seturl != "settings") {
						$chk = modules :: run('Home/is_main_module_enabled', 'rentals');
						if (!$chk) {
								backError_404($this->data);
						}
				}
				$checkingadmin = $this->session->userdata('pt_logged_admin');
				$this->accType = $this->session->userdata('pt_accountType');
				$this->role = $this->session->userdata('pt_role');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');

				if (!empty ($checkingadmin)) {
						$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
				}
				else {
						$this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
				}
				if (empty ($this->data['userloggedin'])) {
						redirect("admin");
				}
				if (!empty ($checkingadmin)) {
						$this->data['adminsegment'] = "admin";
				}
				else {
						$this->data['adminsegment'] = "supplier";
				}
				if ($this->data['adminsegment'] == "admin") {
						$chkadmin = modules :: run('Admin/validadmin');
						if (!$chkadmin) {
								redirect('admin');
						}
				}
				else {
						$chksupplier = modules :: run('Supplier/validsupplier');
						if (!$chksupplier) {
								redirect('supplier');
						}
				}
                /*   $chk = modules::run('home/is_module_enabled','rentals');
                if(!$chk){
                redirect('admin');
                }*/
				$this->data['c_model'] = $this->countries_model;
				if (!pt_permissions('rentals', $this->data['userloggedin'])) {
						redirect('admin');
				}

				$this->data['appSettings'] = modules :: run('Admin/appSettings');
				$this->load->helper('settings');
				$this->load->model('Rentals/Rentals_model');
				$this->load->library('Ckeditor', base_url('assets/include/ckeditor/'));
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format','Font', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				//$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
                $this->data['ckconfig']['extraPlugins'] = 'colorbutton';
                $this->langdef = DEFLANG;
                $this->load->helper('xcrud');
                $this->load->helper('Rentals/rentals');
                $this->data['addpermission'] = true;
                if($this->role == "supplier" || $this->role == "admin"){
                $this->editpermission = pt_permissions("editrentals", $this->data['userloggedin']);
                $this->deletepermission = pt_permissions("deleterentals", $this->data['userloggedin']);
                $this->data['addpermission'] = pt_permissions("addrentals", $this->data['userloggedin']);
                }
                $this->data['languages'] = pt_get_languages();


        }

		function index() {
				if(!$this->data['addpermission'] && !$this->editpermission && !$this->deletepermission){
                	backError_404($this->data);

                }else{
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_rentals');

                if($this->role == "supplier"){
                $xcrud->where('rental_owned_by',$this->data['userloggedin']);

                }
				$xcrud->join('rental_owned_by', 'pt_accounts', 'accounts_id');
				$xcrud->order_by('pt_rentals.rental_id', 'desc');
				$xcrud->subselect('Owned By', 'SELECT CONCAT(ai_first_name, " ", ai_last_name) FROM pt_accounts WHERE accounts_id = {rental_owned_by}');
				$xcrud->label('rental_title', 'Name')->label('rental_stars', 'Stars')->label('rental_is_featured', '')->label('rental_order', 'Order');
                if($this->editpermission){
                $xcrud->button(base_url() . $this->data['adminsegment'] . '/rentals/manage/{rental_slug}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
                $xcrud->column_pattern('rental_title', '<a href="' . base_url() . $this->data['adminsegment'] . '/rentals/manage/{rental_slug}' . '">{value}</a>');
                }

                if($this->deletepermission){
                $delurl = base_url().'rentals/rentalajaxcalls/delrental';
                $xcrud->button("javascript: delfunc('{rental_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('id' => '{rental_id}'));
                }

                $xcrud->limit(50);
				$xcrud->unset_add();
				$xcrud->unset_edit();
			 	$xcrud->unset_remove();
				$xcrud->unset_view();
				$xcrud->column_width('rental_order', '7%');
				$xcrud->columns('rental_is_featured,thumbnail_image,rental_title,rental_stars,Owned By,rental_slug,rental_type,rental_order,discount,rental_status');

				$xcrud->search_columns('rental_title,rental_stars,Owned By,rental_order,rental_status');
                $xcrud->column_callback('pt_rentals.discount', 'discountInputRentals');

                $xcrud->label('thumbnail_image', 'Image');
				$xcrud->label('rental_slug', 'Gallery');
				$xcrud->label('rental_type', 'Packages');
				$xcrud->label('rental_status', 'Status');
				$xcrud->column_callback('rental_stars', 'create_stars');
				$xcrud->column_callback('rental_type', 'packages');
				$xcrud->column_callback('pt_rentals.rental_order', 'orderInputRentals');
				$xcrud->column_callback('pt_rentals.rental_is_featured', 'feature_starsRentals');
				$xcrud->column_callback('rental_slug', 'rentalGallery');
				$xcrud->column_callback('rental_status', 'create_status_icon');
				$xcrud->column_class('thumbnail_image', 'zoom_img');
				$xcrud->change_type('thumbnail_image', 'image', false, array('width' => 200, 'path' => '../../'.PT_RENTALS_SLIDER_THUMB_UPLOAD, 'thumbs' => array(array('height' => 150, 'width' => 120, 'crop' => true, 'marker' => ''))));
				$this->data['content'] = $xcrud->render();
				$this->data['page_title'] = 'Rentals Management';
				$this->data['main_content'] = 'temp_view';
                if($this->deletepermission){
                $this->data['table_name'] = 'pt_rentals';
                $this->data['main_key'] = 'rental_id';
                }
				$this->data['header_title'] = 'Rentals Management';
				$this->data['add_link'] = base_url(). $this->data['adminsegment'] . '/rentals/add';
				$this->load->view('Admin/template', $this->data);
			}
		}

		function add() {
			if(!$this->data['addpermission']){
                backError_404($this->data);
			    }else{
				$addrental = $this->input->post('submittype');
				$this->data['adultStatus'] = "";
				$this->data['childStatus'] = "readonly";
				$this->data['infantStatus'] = "readonly";
				$this->data['adultInput'] = "1";
				$this->data['childInput'] = "0";
				$this->data['infantInput'] = "0";
                $this->data['submittype'] = "add";
       

				if (!empty ($addrental)) {
						$this->form_validation->set_rules('rentalname', 'rental Name', 'trim|required');
						$this->form_validation->set_rules('rentaltype', 'rental Type', 'trim|required');
						$this->form_validation->set_rules('adultprice', 'Adult Price', 'trim|required');
						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							$rentallocations = $this->rentalLocationsCheck($this->input->post('locations'));
							if(empty($rentallocations)){
								echo '<div class="alert alert-danger">Please Select at least One location</div><br>';
							}else{
							$rentalid = $this->Rentals_model->add_rental($this->data['userloggedin']);
							$this->Rentals_model->add_translation($this->input->post('translated'), $rentalid);
							$this->session->set_flashdata('flashmsgs', 'rental added Successfully');
							echo "done";
						}
						}

				}
				else {

						$this->data['rentaltypes'] = $this->Rentals_model->get_tsettings_data("ttypes");
						$this->data['rentalcategories'] = $this->Rentals_model->get_tsettings_data("tcategory");
						$this->data['rentalratings'] = $this->Rentals_model->get_tsettings_data("tratings");
						$this->data['rentalinclusions'] = $this->Rentals_model->get_tsettings_data("tamenities");
						$this->data['rentalexclusions'] = $this->Rentals_model->get_tsettings_data("texclusions");
						$this->data['rentalpayments'] = $this->Rentals_model->get_tsettings_data("tpayments");
						$this->data['all_countries'] = $this->Countries_model->get_all_countries();
						$this->data['all_rentals'] = $this->Rentals_model->select_related_rentals($this->data['userloggedin']);

						$this->load->model('Admin/Locations_model');

						//$this->data['locations'] = $this->Locations_model->getLocationsBackend();

						$this->data['main_content'] = 'Rentals/manage';
						$this->data['page_title'] = 'Add rental';
						$this->data['headingText'] = 'Add rental';
						$this->load->view('Admin/template', $this->data);
				}
			}



		}

		function settings() {
			$isadmin = $this->session->userdata('pt_logged_admin');
				if (empty ($isadmin)) {
						redirect($this->data['adminsegment'] . '/rentals/');
				}
				$updatesett = $this->input->post('updatesettings');
				$addsettings = $this->input->post('add');
				$updatetypesett = $this->input->post('updatetype');

				if (!empty ($updatesett)) {

						$this->Rentals_model->updaterentalSettings();
						redirect('admin/rentals/settings');
				}

                if (!empty ($addsettings)) {
                    $id = $this->Rentals_model->addSettingsData();
                    $this->Rentals_model->updateSettingsTypeTranslation($this->input->post('translated'),$id);
                    redirect('admin/rentals/settings');

				}

                if (!empty ($updatetypesett)) {
                   $this->Rentals_model->updateSettingsData();
                   $this->Rentals_model->updateSettingsTypeTranslation($this->input->post('translated'),$this->input->post('settid'));
                    redirect('admin/rentals/settings');

				}

				$this->LoadXcrudrentalSettings("tamenities");
				$this->LoadXcrudrentalSettings("ttypes");
				$this->LoadXcrudrentalSettings("tpayments");
				$this->LoadXcrudrentalSettings("texclusions");

                $this->data['typeSettings'] = $this->Rentals_model->get_rental_settings_data();

				@ $this->data['settings'] = $this->Settings_model->get_front_settings("rentals");
				$this->data['main_content'] = 'Rentals/settings';
				$this->data['page_title'] = 'Rentals Settings';
				$this->load->view('Admin/template', $this->data);

		/*
				$this->load->model('admin/settings_model');
				$this->data['all_countries'] = $this->Countries_model->get_all_countries();
				$updatesett = $this->input->post('updatesettings');
				if (!empty ($updatesett)) {
						$this->Settings_model->update_front_settings();
						redirect('admin/rentals/settings');
				}
				$this->data['rentaltypes'] = $this->Rentals_model->get_rental_settings_data("ttypes");
				$this->data['rentalcategories'] = $this->Rentals_model->get_rental_settings_data("tcategory");
				$this->data['rentalratings'] = $this->Rentals_model->get_rental_settings_data("tratings");
				$this->data['rentalinclusions'] = $this->Rentals_model->get_rental_settings_data("tamenities");
				$this->data['rentalexclusions'] = $this->Rentals_model->get_rental_settings_data("texclusions");
				$this->data['rentalpayments'] = $this->Rentals_model->get_rental_settings_data("tpayments");
				$this->data['settings'] = $this->Settings_model->get_front_settings("rentals");
				$this->data['main_content'] = 'rentals/settings';
				$this->data['page_title'] = 'rentals Settings';
				$this->load->view('Admin/template', $this->data);*/
		}

		function manage($rentalname) {
				$this->data['upload_allowed'] = pt_can_upload();

				$this->load->model('Rentals/Rentals_uploads_model');
				$this->load->model('Admin/Accounts_model');
				if (empty ($rentalname)) {
						redirect($this->data['adminsegment'] . '/rentals/');
				}
				$updaterental = $this->input->post('submittype');
				$this->data['submittype'] = "update";
				$rentalid = $this->input->post('rentalid');
				if (!empty ($updaterental)) {
						$this->form_validation->set_rules('rentalname', 'rental Name', 'trim|required');
						$this->form_validation->set_rules('rentaltype', 'rental Type', 'trim|required');
						$this->form_validation->set_rules('adultprice', 'Adult Price', 'trim|required');

						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							$rentallocations = $this->rentalLocationsCheck($this->input->post('locations'));
							if(empty($rentallocations)){
								echo '<div class="alert alert-danger">Please Select at least One location</div><br>';
							}else{

							$this->Rentals_model->update_rental($rentalid);
							$this->Rentals_model->update_translation($this->input->post('translated'), $rentalid);
							$this->session->set_flashdata('flashmsgs', 'rental Updated Successfully');
							echo "done";

							}



						}
				}
				else {

						$this->data['tdata'] = $this->Rentals_model->get_rental_data($rentalname);

						if (empty ($this->data['tdata'])) {
								redirect($this->data['adminsegment'] . '/rentals/');
						}
                       $comfixed = $this->data['tdata'][0]->rental_comm_fixed;
                       $comper = $this->data['tdata'][0]->rental_comm_percentage;
                       if($comfixed > 0){
                         $this->data['rentaldepositval'] = $comfixed;
                         $this->data['rentaldeposittype'] = "fixed";
                       }else{
                         $this->data['rentaldepositval'] = $comper;
                         $this->data['rentaldeposittype'] = "percentage";
                       }

                       $taxfixed = $this->data['tdata'][0]->rental_tax_fixed;
                       $taxper = $this->data['tdata'][0]->rental_tax_percentage;
                       if($taxfixed > 0){
                         $this->data['rentaltaxval'] = $taxfixed;
                         $this->data['rentaltaxtype'] = "fixed";
                       }else{
                         $this->data['rentaltaxval'] = $taxper;
                         $this->data['rentaltaxtype'] = "percentage";
                       }

                        $adultStatus = $this->data['tdata'][0]->adult_status;
                        $childStatus = $this->data['tdata'][0]->child_status;
                        $infantStatus = $this->data['tdata'][0]->infant_status;

                        if($adultStatus == "0"){
                        	$this->data['adultStatus'] = "readonly";
                        	$this->data['adultInput'] = "0";
                        }else{
                        	$this->data['adultStatus'] = "";
                        	$this->data['adultInput'] = "1";
                        }

                        if($childStatus == "0"){
                        	$this->data['childStatus'] = "readonly";
                        	$this->data['childInput'] = "0";
                        }else{
                        	$this->data['childStatus'] = "";
                        	$this->data['childInput'] = "1";
                        }

                        if($infantStatus == "0"){

                        	$this->data['infantStatus'] = "readonly";
                        	$this->data['infantInput'] = "0";
                        }else{

                        	$this->data['infantStatus'] = "";
                        	$this->data['infantInput'] = "1";
                        }

						$this->data['all_rentals'] = $this->Rentals_model->select_related_rentals($this->data['tdata'][0]->rental_id);
						$this->data['map_data'] = $this->Rentals_model->get_rental_map($this->data['tdata'][0]->rental_id);
						$this->data['maxmaporder'] = $this->Rentals_model->max_map_order($this->data['tdata'][0]->rental_id);
						$this->data['has_start'] = $this->Rentals_model->has_start_end_city("start", $this->data['tdata'][0]->rental_id);
						$this->data['has_end'] = $this->Rentals_model->has_start_end_city("end", $this->data['tdata'][0]->rental_id);
						$this->data['offers_data'] = $this->Rentals_model->offers_data($this->data['tdata'][0]->rental_id);
						$this->data['userinfo'] = $this->Accounts_model->get_profile_details($this->data['tdata'][0]->rental_owned_by);
						$this->data['rentaltypes'] = $this->Rentals_model->get_tsettings_data("ttypes");
						$this->data['rentalcategories'] = $this->Rentals_model->get_tsettings_data("tcategory");
						$this->data['rentalratings'] = $this->Rentals_model->get_tsettings_data("tratings");
						$this->data['rentalinclusions'] = $this->Rentals_model->get_tsettings_data("tamenities");
						$this->data['rentalexclusions'] = $this->Rentals_model->get_tsettings_data("texclusions");
						$this->data['rentalpayments'] = $this->Rentals_model->get_tsettings_data("tpayments");
						$this->data['rentalid'] = $this->data['tdata'][0]->rental_id;

						$this->load->model('Admin/Locations_model');
						//$this->data['locations'] = $this->Locations_model->getLocationsBackend();
						$this->data['rentallocations'] = $this->Rentals_model->rentalSelectedLocations($this->data['tdata'][0]->rental_id);

						$this->data['main_content'] = 'Rentals/manage';
						$this->data['page_title'] = 'Manage Rental';
						$this->load->view('Admin/template', $this->data);
				}
		}


				function gallery($id) {

				$this->load->library('Rentals/Rentals_lib');
				$this->Rentals_lib->set_rentalid($id);
				$this->data['itemid'] = $this->Rentals_lib->get_id();
				$this->data['images'] = $this->Rentals_model->rentalGallery($id);
                $this->data['imgorderUrl'] = base_url().'rentals/rentalajaxcalls/update_image_order';
                $this->data['uploadUrl'] = base_url().'rentals/rentalsback/galleryUpload/rentals/';
                $this->data['delimgUrl'] = base_url().'rentals/rentalajaxcalls/delete_image';
                $this->data['appRejUrl'] = base_url().'rentals/rentalajaxcalls/app_rej_timages';
                $this->data['makeThumbUrl'] = base_url().'rentals/rentalajaxcalls/makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'rentals/rentalajaxcalls/deleteMultiplerentalImages';
                $this->data['fullImgDir'] = PT_RENTALS_SLIDER;
                $this->data['thumbsDir'] = PT_RENTALS_SLIDER_THUMB;
				$this->data['main_content'] = 'Rentals/gallery';
				$this->data['page_title'] = 'Rental Gallery';
				$this->load->view('Admin/template', $this->data);
		}


		function galleryUpload($type, $id) {
				$this->load->library('image_lib');
				if (!empty ($_FILES)) {

						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['name'];
						$fileName = str_replace(" ", "-", $_FILES['file']['name']);
						$fig = rand(1, 999999);
						$saveFile = $fig . '_' . $fileName;
                        if (strpos($fileName,'php') !== false) {

						}else{
						$targetPath = PT_RENTALS_SLIDER_UPLOAD;
                        $targetFile = $targetPath . $saveFile;

						move_uploaded_file($tempFile, $targetFile);

						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;
                        $config['new_image'] = PT_RENTALS_SLIDER_THUMB_UPLOAD;

						$config['thumb_marker'] = '';
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = THUMB_WIDTH;
						$config['height'] = THUMB_HEIGHT;
						$this->image_lib->clear();
						$this->image_lib->initialize($config);
						$this->image_lib->resize();

						modules :: run('Admin/watermark/apply',$targetFile);

                        /* Add images name to database with respective hotel id */
						$this->Rentals_model->addPhotos($id, $saveFile);

				}
			}
		}


// Delete rental images

		public function deleteimg($file, $type) {
				if ($type == "slider") {
						@ unlink(PT_RENTALS_SLIDER_THUMB_UPLOAD . $file);
						@ unlink(PT_RENTALS_SLIDER_THUMB_UPLOAD . $file);
				}
				$this->db->where('timg_image', $file);
				$this->db->delete('pt_rental_images');
				$js = array("files" => array(array($file => "true")));
				echo json_encode($js);
		}


		function translate($rentalslug, $lang = null) {
				$this->load->library('Rentals/Rentals_lib');
				$this->Rentals_lib->set_rentalid($rentalslug);
				$add = $this->input->post('add');
				$update = $this->input->post('update');
				if (empty ($lang)) {
						$lang = $this->langdef;
				}
				else {
						$lang = $lang;
				}
				if (empty ($rentalslug)) {
						redirect($this->data['adminsegment'] . '/rentals/');
				}
				if (!empty ($add)) {
						$language = $this->input->post('langname');
						$rentalid = $this->input->post('rentalid');
						$this->Rentals_model->add_translation($language, $rentalid);
						redirect($this->data['adminsegment'] . "/rentals/translate/" . $rentalslug . "/" . $language);
				}
				if (!empty ($update)) {
						$slug = $this->Rentals_model->update_translation($lang, $rentalslug);
						redirect($this->data['adminsegment'] . "/rentals/translate/" . $slug . "/" . $lang);
				}
				$tdata = $this->rentals_lib->rental_details();
				if ($lang == $this->langdef) {
						$rentalsdata = $this->rentals_lib->rental_short_details();
						$this->data['rentalsdata'] = $rentalsdata;
						$this->data['transpolicy'] = $rentalsdata[0]->rental_privacy;
						$this->data['transdesc'] = $rentalsdata[0]->rental_desc;
						$this->data['transtitle'] = $rentalsdata[0]->rental_title;
				}
				else {
						$rentalsdata = $this->rentals_lib->translated_data($lang);
						$this->data['rentalsdata'] = $rentalsdata;
						$this->data['transid'] = $rentalsdata[0]->trans_id;
						$this->data['transpolicy'] = $rentalsdata[0]->trans_policy;
						$this->data['transdesc'] = $rentalsdata[0]->trans_desc;
						$this->data['transtitle'] = $rentalsdata[0]->trans_title;
				}
				$this->data['rentalid'] = $this->rentals_lib->get_id();
				$this->data['lang'] = $lang;
				$this->data['slug'] = $rentalslug;
				$this->data['language_list'] = pt_get_languages();
				if ($this->data['adminsegment'] == "supplier") {
						if ($this->data['userloggedin'] != $tdata[0]->rental_owned_by) {
								redirect($this->data['adminsegment'] . '/rentals/');
						}
				}
				$this->data['main_content'] = 'Rentals/translate';
				$this->data['page_title'] = 'Translate Rental';
				$this->load->view('Admin/template', $this->data);
		}


		function LoadXcrudrentalSettings($type) {
				$xc = "xcrud" . $type;
				$xc = xcrud_get_instance();
				$xc->table('pt_rentals_types_settings');
				$xc->where('sett_type', $type);
				$xc->order_by('sett_id', 'desc');
				$xc->button('#sett{sett_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
				$delurl = base_url().'rentals/rentalajaxcalls/delTypeSettings';
               	$xc->button("javascript: delfunc('{sett_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self','id' => '{sett_id}'));


                if($type == "ttypes"){
                $xc->columns('sett_name,sett_status');
                }else{

                $xc->columns('sett_name,sett_selected,sett_status');
                }

                $xc->search_columns('sett_name,sett_selected,sett_status');
                $xc->label('sett_name', 'Name')->label('sett_selected', 'Selected')->label('sett_status', 'Status')->label('sett_img', 'Icon');
                $xc->unset_add();
				$xc->unset_edit();
				$xc->unset_remove();
				$xc->unset_view();

				$xc->multiDelUrl = base_url().'rentals/rentalajaxcalls/delMultiTypeSettings/'.$type;

				$this->data['content' . $type] = $xc->render();
		}

		function extras(){


         if($this->data['adminsegment'] == "supplier"){
			 $supplierrentals = $this->Rentals_model->all_rentals($this->data['userloggedin']);
			 $allrentals = $this->Rentals_model->all_rentals();

         echo  modules :: run('Admin/extras/listings','rentals',$allrentals,$supplierrentals);

		}else{

			$rentals = $this->Rentals_model->all_rentals();
         echo  modules :: run('Admin/extras/listings','rentals',$rentals);

		}

        }

        function reviews(){

         echo  modules :: run('Admin/reviews/listings','rentals');
        }


        function rentalLocationsCheck($locations){
        	$locArray = array();
        	foreach($locations as $loc){

        		if(!empty($loc)){
        			$locArray[] = $loc;
        		}
        	}

        	return $locArray;
        }

        function dates() {
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_rentals_packages');
        $xcrud->order_by('id', 'desc');
        $xcrud->change_type('start_date', 'date', date('Y-m-d'));
        $xcrud->change_type('end_date', 'date', date('Y-m-d'));
        $xcrud->change_type('rental_id', 'hidden',$this->input->get('id'));
        $xcrud->columns(array('rental_id'),true);
        $xcrud->where('rental_id',$this->input->get('id'));
        $this->data['content'] = $xcrud->render();
        $this->load->view('Rentals/xcrud', $this->data);
        }


}
