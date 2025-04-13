<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Boatsback extends MX_Controller {
	    public $accType = "";
		private $langdef;
		public  $editpermission = true;
        public  $deletepermission = true;

		function __construct() {
				$chk = modules :: run('Home/is_main_module_enabled', 'Boats');
				$seturl = $this->uri->segment(3);
				if ($seturl != "settings") {
						$chk = modules :: run('Home/is_main_module_enabled', 'Boats');
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
                /*   $chk = modules::run('home/is_module_enabled','boats');
                if(!$chk){
                redirect('admin');
                }*/
				$this->data['c_model'] = $this->countries_model;
				if (!pt_permissions('boats', $this->data['userloggedin'])) {
						redirect('admin');
				}

				$this->data['appSettings'] = modules :: run('Admin/appSettings');
				$this->load->helper('settings');
				$this->load->model('Boats/Boats_model');
				$this->load->library('Ckeditor', base_url('assets/include/ckeditor/'));
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format','Font', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				//$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
                $this->data['ckconfig']['extraPlugins'] = 'colorbutton';
                $this->langdef = DEFLANG;
                $this->load->helper('xcrud');
                $this->load->helper('Boats/boats');
                $this->data['addpermission'] = true;
                if($this->role == "supplier" || $this->role == "admin"){
                $this->editpermission = pt_permissions("editboats", $this->data['userloggedin']);
                $this->deletepermission = pt_permissions("deleteboats", $this->data['userloggedin']);
                $this->data['addpermission'] = pt_permissions("addboats", $this->data['userloggedin']);
                }
                $this->data['languages'] = pt_get_languages();


        }

		function index() {
				if(!$this->data['addpermission'] && !$this->editpermission && !$this->deletepermission){
                	backError_404($this->data);

                }else{
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_boats');

                if($this->role == "supplier"){
                $xcrud->where('boat_owned_by',$this->data['userloggedin']);

                }
				$xcrud->join('boat_owned_by', 'pt_accounts', 'accounts_id');
				$xcrud->order_by('pt_boats.boat_id', 'desc');
				$xcrud->subselect('Owned By', 'SELECT CONCAT(ai_first_name, " ", ai_last_name) FROM pt_accounts WHERE accounts_id = {boat_owned_by}');
				$xcrud->label('boat_title', 'Name')->label('boat_stars', 'Stars')->label('boat_is_featured', '')->label('boat_order', 'Order');
                if($this->editpermission){
                $xcrud->button(base_url() . $this->data['adminsegment'] . '/boats/manage/{boat_slug}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
                $xcrud->column_pattern('boat_title', '<a href="' . base_url() . $this->data['adminsegment'] . '/boats/manage/{boat_slug}' . '">{value}</a>');
                }

                if($this->deletepermission){
                $delurl = base_url().'boats/boatajaxcalls/delboat';
                $xcrud->button("javascript: delfunc('{boat_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('id' => '{boat_id}'));
                }

                $xcrud->limit(50);
				$xcrud->unset_add();
				$xcrud->unset_edit();
			 	$xcrud->unset_remove();
				$xcrud->unset_view();
				$xcrud->column_width('boat_order', '7%');
				$xcrud->columns('boat_is_featured,thumbnail_image,boat_title,boat_stars,Owned By,boat_slug,boat_type,boat_order,discount,boat_status');

				$xcrud->search_columns('boat_title,boat_stars,Owned By,boat_order,boat_status');
                $xcrud->column_callback('pt_boats.discount', 'discountInputBoats');

                $xcrud->label('thumbnail_image', 'Image');
				$xcrud->label('boat_slug', 'Gallery');
				$xcrud->label('boat_type', 'Packages');
				$xcrud->label('boat_status', 'Status');
				$xcrud->column_callback('boat_stars', 'create_stars');
				$xcrud->column_callback('boat_type', 'packages');
				$xcrud->column_callback('pt_boats.boat_order', 'orderInputboats');
				$xcrud->column_callback('pt_boats.boat_is_featured', 'feature_starsboats');
				$xcrud->column_callback('boat_slug', 'boatGallery');
				$xcrud->column_callback('boat_status', 'create_status_icon');
				$xcrud->column_class('thumbnail_image', 'zoom_img');
				$xcrud->change_type('thumbnail_image', 'image', false, array('width' => 200, 'path' => '../../'.PT_BOATS_SLIDER_THUMB_UPLOAD, 'thumbs' => array(array('height' => 150, 'width' => 120, 'crop' => true, 'marker' => ''))));
				$this->data['content'] = $xcrud->render();
				$this->data['page_title'] = 'boats Management';
				$this->data['main_content'] = 'temp_view';
                if($this->deletepermission){
                $this->data['table_name'] = 'pt_boats';
                $this->data['main_key'] = 'boat_id';
                }
				$this->data['header_title'] = 'boats Management';
				$this->data['add_link'] = base_url(). $this->data['adminsegment'] . '/boats/add';
				$this->load->view('Admin/template', $this->data);
			}
		}

		function add() {
			if(!$this->data['addpermission']){
                backError_404($this->data);
			    }else{
				$addboat = $this->input->post('submittype');
				$this->data['adultStatus'] = "";
				$this->data['childStatus'] = "readonly";
				$this->data['infantStatus'] = "readonly";
				$this->data['adultInput'] = "1";
				$this->data['childInput'] = "0";
				$this->data['infantInput'] = "0";
                $this->data['submittype'] = "add";
       

				if (!empty ($addboat)) {
						$this->form_validation->set_rules('boatname', 'boat Name', 'trim|required');
						$this->form_validation->set_rules('boattype', 'boat Type', 'trim|required');
						$this->form_validation->set_rules('adultprice', 'Adult Price', 'trim|required');
						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							$boatlocations = $this->boatLocationsCheck($this->input->post('locations'));
							if(empty($boatlocations)){
								echo '<div class="alert alert-danger">Please Select at least One location</div><br>';
							}else{
							$boatid = $this->Boats_model->add_boat($this->data['userloggedin']);
							$this->Boats_model->add_translation($this->input->post('translated'), $boatid);
							$this->session->set_flashdata('flashmsgs', 'boat added Successfully');
							echo "done";
						}
						}

				}
				else {

						$this->data['boattypes'] = $this->Boats_model->get_tsettings_data("ttypes");
						$this->data['boatcategories'] = $this->Boats_model->get_tsettings_data("tcategory");
						$this->data['boatratings'] = $this->Boats_model->get_tsettings_data("tratings");
						$this->data['boatinclusions'] = $this->Boats_model->get_tsettings_data("tamenities");
						$this->data['boatexclusions'] = $this->Boats_model->get_tsettings_data("texclusions");
						$this->data['boatpayments'] = $this->Boats_model->get_tsettings_data("tpayments");
						$this->data['all_countries'] = $this->Countries_model->get_all_countries();
						$this->data['all_boats'] = $this->Boats_model->select_related_boats($this->data['userloggedin']);

						$this->load->model('Admin/Locations_model');

						//$this->data['locations'] = $this->Locations_model->getLocationsBackend();

						$this->data['main_content'] = 'Boats/manage';
						$this->data['page_title'] = 'Add boat';
						$this->data['headingText'] = 'Add boat';
						$this->load->view('Admin/template', $this->data);
				}
			}



		}

		function settings() {
			$isadmin = $this->session->userdata('pt_logged_admin');
				if (empty ($isadmin)) {
						redirect($this->data['adminsegment'] . '/boats/');
				}
				$updatesett = $this->input->post('updatesettings');
				$addsettings = $this->input->post('add');
				$updatetypesett = $this->input->post('updatetype');

				if (!empty ($updatesett)) {

						$this->Boats_model->updateboatSettings();
						redirect('admin/boats/settings');
				}

                if (!empty ($addsettings)) {
                    $id = $this->Boats_model->addSettingsData();
                    $this->Boats_model->updateSettingsTypeTranslation($this->input->post('translated'),$id);
                    redirect('admin/boats/settings');

				}

                if (!empty ($updatetypesett)) {
                   $this->Boats_model->updateSettingsData();
                   $this->Boats_model->updateSettingsTypeTranslation($this->input->post('translated'),$this->input->post('settid'));
                    redirect('admin/boats/settings');

				}

				$this->LoadXcrudboatSettings("tamenities");
				$this->LoadXcrudboatSettings("ttypes");
				$this->LoadXcrudboatSettings("tpayments");
				$this->LoadXcrudboatSettings("texclusions");

                $this->data['typeSettings'] = $this->Boats_model->get_boat_settings_data();

				@ $this->data['settings'] = $this->Settings_model->get_front_settings("boats");
				$this->data['main_content'] = 'Boats/settings';
				$this->data['page_title'] = 'Boats Settings';
				$this->load->view('Admin/template', $this->data);

		/*
				$this->load->model('admin/settings_model');
				$this->data['all_countries'] = $this->Countries_model->get_all_countries();
				$updatesett = $this->input->post('updatesettings');
				if (!empty ($updatesett)) {
						$this->Settings_model->update_front_settings();
						redirect('admin/boats/settings');
				}
				$this->data['boattypes'] = $this->Boats_model->get_boat_settings_data("ttypes");
				$this->data['boatcategories'] = $this->Boats_model->get_boat_settings_data("tcategory");
				$this->data['boatratings'] = $this->Boats_model->get_boat_settings_data("tratings");
				$this->data['boatinclusions'] = $this->Boats_model->get_boat_settings_data("tamenities");
				$this->data['boatexclusions'] = $this->Boats_model->get_boat_settings_data("texclusions");
				$this->data['boatpayments'] = $this->Boats_model->get_boat_settings_data("tpayments");
				$this->data['settings'] = $this->Settings_model->get_front_settings("boats");
				$this->data['main_content'] = 'boats/settings';
				$this->data['page_title'] = 'boats Settings';
				$this->load->view('Admin/template', $this->data);*/
		}

		function manage($boatname) {
				$this->data['upload_allowed'] = pt_can_upload();

				$this->load->model('Boats/Boats_uploads_model');
				$this->load->model('Admin/Accounts_model');
				if (empty ($boatname)) {
						redirect($this->data['adminsegment'] . '/boats/');
				}
				$updateboat = $this->input->post('submittype');
				$this->data['submittype'] = "update";
				$boatid = $this->input->post('boatid');
				if (!empty ($updateboat)) {
						$this->form_validation->set_rules('boatname', 'boat Name', 'trim|required');
						$this->form_validation->set_rules('boattype', 'boat Type', 'trim|required');
						$this->form_validation->set_rules('adultprice', 'Adult Price', 'trim|required');

						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							$boatlocations = $this->boatLocationsCheck($this->input->post('locations'));
							if(empty($boatlocations)){
								echo '<div class="alert alert-danger">Please Select at least One location</div><br>';
							}else{

							$this->Boats_model->update_boat($boatid);
							$this->Boats_model->update_translation($this->input->post('translated'), $boatid);
							$this->session->set_flashdata('flashmsgs', 'boat Updated Successfully');
							echo "done";

							}



						}
				}
				else {

						$this->data['tdata'] = $this->Boats_model->get_boat_data($boatname);

						if (empty ($this->data['tdata'])) {
								redirect($this->data['adminsegment'] . '/boats/');
						}
                       $comfixed = $this->data['tdata'][0]->boat_comm_fixed;
                       $comper = $this->data['tdata'][0]->boat_comm_percentage;
                       if($comfixed > 0){
                         $this->data['boatdepositval'] = $comfixed;
                         $this->data['boatdeposittype'] = "fixed";
                       }else{
                         $this->data['boatdepositval'] = $comper;
                         $this->data['boatdeposittype'] = "percentage";
                       }

                       $taxfixed = $this->data['tdata'][0]->boat_tax_fixed;
                       $taxper = $this->data['tdata'][0]->boat_tax_percentage;
                       if($taxfixed > 0){
                         $this->data['boattaxval'] = $taxfixed;
                         $this->data['boattaxtype'] = "fixed";
                       }else{
                         $this->data['boattaxval'] = $taxper;
                         $this->data['boattaxtype'] = "percentage";
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

						$this->data['all_boats'] = $this->Boats_model->select_related_boats($this->data['tdata'][0]->boat_id);
						$this->data['map_data'] = $this->Boats_model->get_boat_map($this->data['tdata'][0]->boat_id);
						$this->data['maxmaporder'] = $this->Boats_model->max_map_order($this->data['tdata'][0]->boat_id);
						$this->data['has_start'] = $this->Boats_model->has_start_end_city("start", $this->data['tdata'][0]->boat_id);
						$this->data['has_end'] = $this->Boats_model->has_start_end_city("end", $this->data['tdata'][0]->boat_id);
						$this->data['offers_data'] = $this->Boats_model->offers_data($this->data['tdata'][0]->boat_id);
						$this->data['userinfo'] = $this->Accounts_model->get_profile_details($this->data['tdata'][0]->boat_owned_by);
						$this->data['boattypes'] = $this->Boats_model->get_tsettings_data("ttypes");
						$this->data['boatcategories'] = $this->Boats_model->get_tsettings_data("tcategory");
						$this->data['boatratings'] = $this->Boats_model->get_tsettings_data("tratings");
						$this->data['boatinclusions'] = $this->Boats_model->get_tsettings_data("tamenities");
						$this->data['boatexclusions'] = $this->Boats_model->get_tsettings_data("texclusions");
						$this->data['boatpayments'] = $this->Boats_model->get_tsettings_data("tpayments");
						$this->data['boatid'] = $this->data['tdata'][0]->boat_id;

						$this->load->model('Admin/Locations_model');
						//$this->data['locations'] = $this->Locations_model->getLocationsBackend();
						$this->data['boatlocations'] = $this->Boats_model->boatSelectedLocations($this->data['tdata'][0]->boat_id);

						$this->data['main_content'] = 'Boats/manage';
						$this->data['page_title'] = 'Manage boat';
						$this->load->view('Admin/template', $this->data);
				}
		}


				function gallery($id) {

				$this->load->library('Boats/Boats_lib');
				$this->Boats_lib->set_boatid($id);
				$this->data['itemid'] = $this->Boats_lib->get_id();
				$this->data['images'] = $this->Boats_model->boatGallery($id);
                $this->data['imgorderUrl'] = base_url().'boats/boatajaxcalls/update_image_order';
                $this->data['uploadUrl'] = base_url().'boats/boatsback/galleryUpload/boats/';
                $this->data['delimgUrl'] = base_url().'boats/boatajaxcalls/delete_image';
                $this->data['appRejUrl'] = base_url().'boats/boatajaxcalls/app_rej_timages';
                $this->data['makeThumbUrl'] = base_url().'boats/boatajaxcalls/makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'boats/boatajaxcalls/deleteMultipleboatImages';
                $this->data['fullImgDir'] = PT_BOATS_SLIDER;
                $this->data['thumbsDir'] = PT_BOATS_SLIDER_THUMB;
				$this->data['main_content'] = 'Boats/gallery';
				$this->data['page_title'] = 'boat Gallery';
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
						$targetPath = PT_BOATS_SLIDER_UPLOAD;
                        $targetFile = $targetPath . $saveFile;

						move_uploaded_file($tempFile, $targetFile);

						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;
                        $config['new_image'] = PT_BOATS_SLIDER_THUMB_UPLOAD;

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
						$this->Boats_model->addPhotos($id, $saveFile);

				}
			}
		}


// Delete boat images

		public function deleteimg($file, $type) {
				if ($type == "slider") {
						@ unlink(PT_BOATS_SLIDER_THUMB_UPLOAD . $file);
						@ unlink(PT_BOATS_SLIDER_THUMB_UPLOAD . $file);
				}
				$this->db->where('timg_image', $file);
				$this->db->delete('pt_boat_images');
				$js = array("files" => array(array($file => "true")));
				echo json_encode($js);
		}


		function translate($boatslug, $lang = null) {
				$this->load->library('Boats/Boats_lib');
				$this->Boats_lib->set_boatid($boatslug);
				$add = $this->input->post('add');
				$update = $this->input->post('update');
				if (empty ($lang)) {
						$lang = $this->langdef;
				}
				else {
						$lang = $lang;
				}
				if (empty ($boatslug)) {
						redirect($this->data['adminsegment'] . '/boats/');
				}
				if (!empty ($add)) {
						$language = $this->input->post('langname');
						$boatid = $this->input->post('boatid');
						$this->Boats_model->add_translation($language, $boatid);
						redirect($this->data['adminsegment'] . "/boats/translate/" . $boatslug . "/" . $language);
				}
				if (!empty ($update)) {
						$slug = $this->Boats_model->update_translation($lang, $boatslug);
						redirect($this->data['adminsegment'] . "/boats/translate/" . $slug . "/" . $lang);
				}
				$tdata = $this->Boats_lib->boat_details();
				if ($lang == $this->langdef) {
						$boatsdata = $this->Boats_lib->boat_short_details();
						$this->data['boatsdata'] = $boatsdata;
						$this->data['transpolicy'] = $boatsdata[0]->boat_privacy;
						$this->data['transdesc'] = $boatsdata[0]->boat_desc;
						$this->data['transtitle'] = $boatsdata[0]->boat_title;
				}
				else {
						$boatsdata = $this->Boats_lib->translated_data($lang);
						$this->data['boatsdata'] = $boatsdata;
						$this->data['transid'] = $boatsdata[0]->trans_id;
						$this->data['transpolicy'] = $boatsdata[0]->trans_policy;
						$this->data['transdesc'] = $boatsdata[0]->trans_desc;
						$this->data['transtitle'] = $boatsdata[0]->trans_title;
				}
				$this->data['boatid'] = $this->Boats_lib->get_id();
				$this->data['lang'] = $lang;
				$this->data['slug'] = $boatslug;
				$this->data['language_list'] = pt_get_languages();
				if ($this->data['adminsegment'] == "supplier") {
						if ($this->data['userloggedin'] != $tdata[0]->boat_owned_by) {
								redirect($this->data['adminsegment'] . '/boats/');
						}
				}
				$this->data['main_content'] = 'Boats/translate';
				$this->data['page_title'] = 'Translate boat';
				$this->load->view('Admin/template', $this->data);
		}


		function LoadXcrudboatSettings($type) {
				$xc = "xcrud" . $type;
				$xc = xcrud_get_instance();
				$xc->table('pt_boats_types_settings');
				$xc->where('sett_type', $type);
				$xc->order_by('sett_id', 'desc');
				$xc->button('#sett{sett_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
				$delurl = base_url().'boats/boatajaxcalls/delTypeSettings';
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

				$xc->multiDelUrl = base_url().'boats/boatajaxcalls/delMultiTypeSettings/'.$type;

				$this->data['content' . $type] = $xc->render();
		}

		function extras(){


         if($this->data['adminsegment'] == "supplier"){
			 $supplierboats = $this->Boats_model->all_boats($this->data['userloggedin']);
			 $allboats = $this->Boats_model->all_boats();

         echo  modules :: run('Admin/extras/listings','boats',$allboats,$supplierboats);

		}else{

			$boats = $this->Boats_model->all_boats();
         echo  modules :: run('Admin/extras/listings','boats',$boats);

		}

        }

        function reviews(){

         echo  modules :: run('Admin/reviews/listings','boats');
        }


        function boatLocationsCheck($locations){
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
        $xcrud->table('pt_boats_packages');
        $xcrud->order_by('id', 'desc');
        $xcrud->change_type('start_date', 'date', date('Y-m-d'));
        $xcrud->change_type('end_date', 'date', date('Y-m-d'));
        $xcrud->change_type('boat_id', 'hidden',$this->input->get('id'));
        $xcrud->columns(array('boat_id'),true);
        $xcrud->where('boat_id',$this->input->get('id'));
        $this->data['content'] = $xcrud->render();
        $this->load->view('boats/xcrud', $this->data);
        }


}
