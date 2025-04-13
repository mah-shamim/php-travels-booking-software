<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Toursback extends MX_Controller {
	    public $accType = "";
		private $langdef;
		public  $editpermission = true;
        public  $deletepermission = true;

		function __construct() {
				$chk = modules :: run('Home/is_main_module_enabled', 'tours');
				$seturl = $this->uri->segment(3);
				if ($seturl != "settings") {
						$chk = modules :: run('Home/is_main_module_enabled', 'tours');
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
                /*   $chk = modules::run('home/is_module_enabled','tours');
                if(!$chk){
                redirect('admin');
                }*/
				$this->data['c_model'] = $this->countries_model;
				if (!pt_permissions('tours', $this->data['userloggedin'])) {
						redirect('admin');
				}

				$this->data['appSettings'] = modules :: run('Admin/appSettings');
				$this->load->helper('settings');
				$this->load->model('Tours/Tours_model');
				$this->load->library('Ckeditor', base_url('assets/include/ckeditor/'));
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format','Font', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				//$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';

                $this->data['ckconfig']['extraPlugins'] = 'colorbutton';
                $this->langdef = DEFLANG;
                $this->load->helper('xcrud');
                $this->load->helper('Tours/tours');
                $this->data['addpermission'] = true;
                if($this->role == "supplier" || $this->role == "admin"){
                $this->editpermission = pt_permissions("edittours", $this->data['userloggedin']);
                $this->deletepermission = pt_permissions("deletetours", $this->data['userloggedin']);
                $this->data['addpermission'] = pt_permissions("addtours", $this->data['userloggedin']);
                }
                $this->data['languages'] = pt_get_languages();

        }

		function index() {

				if(!$this->data['addpermission'] && !$this->editpermission && !$this->deletepermission){
                	backError_404($this->data);

                }else{
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_tours');

                if($this->role == "supplier"){
                $xcrud->where('tour_owned_by',$this->data['userloggedin']);

                }
				$xcrud->join('tour_owned_by', 'pt_accounts', 'accounts_id');
				$xcrud->order_by('pt_tours.tour_id', 'desc');
				$xcrud->subselect('Owned By', 'SELECT CONCAT(ai_first_name, " ", ai_last_name) FROM pt_accounts WHERE accounts_id = {tour_owned_by}');
				$xcrud->label('tour_title', 'Name')->label('tour_stars', 'Stars')->label('tour_is_featured', '')->label('tour_order', 'Order');
                if($this->editpermission){
                $xcrud->button(base_url() . $this->data['adminsegment'] . '/tours/manage/{tour_slug}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
                $xcrud->column_pattern('tour_title', '<a href="' . base_url() . $this->data['adminsegment'] . '/tours/manage/{tour_slug}' . '">{value}</a>');
                }

                if($this->deletepermission){
                $delurl = base_url().'tours/tourajaxcalls/delTour';
                $xcrud->button("javascript: delfunc('{tour_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('id' => '{tour_id}'));
                }

                $xcrud->limit(50);
				$xcrud->unset_add();
				$xcrud->unset_edit();
			 	$xcrud->unset_remove();
				$xcrud->unset_view();
				$xcrud->column_width('tour_order', '7%');
				$xcrud->columns('tour_is_featured,thumbnail_image,tour_title,tour_stars,Owned By,tour_slug,tour_order,discount,tour_status');

				$xcrud->search_columns('tour_title,tour_stars,Owned By,tour_order,tour_status');
                $xcrud->column_callback('pt_tours.discount', 'discountInputTours');

                $xcrud->label('thumbnail_image', 'Image');
				$xcrud->label('tour_slug', 'Gallery');
				$xcrud->label('tour_type', 'Packages');
				$xcrud->label('tour_status', 'Status');
				$xcrud->column_callback('tour_stars', 'create_stars');
				$xcrud->column_callback('tour_type', 'packages');
				$xcrud->column_callback('pt_tours.tour_order', 'orderInputTours');
				$xcrud->column_callback('pt_tours.tour_is_featured', 'feature_starsTours');
				$xcrud->column_callback('tour_slug', 'tourGallery');
				$xcrud->column_callback('tour_status', 'create_status_icon');
				$xcrud->column_class('thumbnail_image', 'zoom_img');
				$xcrud->change_type('thumbnail_image', 'image', false, array('width' => 200, 'path' => '../../'.PT_TOURS_SLIDER_THUMB_UPLOAD, 'thumbs' => array(array('height' => 150, 'width' => 120, 'crop' => true, 'marker' => ''))));
				$this->data['content'] = $xcrud->render();
				$this->data['page_title'] = 'Tours Management';
				$this->data['main_content'] = 'temp_view';
                if($this->deletepermission){
                $this->data['table_name'] = 'pt_tours';
                $this->data['main_key'] = 'tour_id';
                }
				$this->data['header_title'] = 'Tours Management';
				$this->data['add_link'] = base_url(). $this->data['adminsegment'] . '/tours/add';
				$this->load->view('Admin/template', $this->data);
			}
		}

		function add() {
			if(!$this->data['addpermission']){
                backError_404($this->data);
			    }else{
				$addtour = $this->input->post('submittype');
				$this->data['adultStatus'] = "";
				$this->data['childStatus'] = "readonly";
				$this->data['infantStatus'] = "readonly";
				$this->data['adultInput'] = "1";
				$this->data['childInput'] = "0";
				$this->data['infantInput'] = "0";
                $this->data['submittype'] = "add";
       

				if (!empty ($addtour)) {
						$this->form_validation->set_rules('tourname', 'Tour Name', 'trim|required');
						$this->form_validation->set_rules('tourtype', 'Tour Type', 'trim|required');
						$this->form_validation->set_rules('adultprice', 'Adult Price', 'trim|required');
						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							$tourlocations = $this->tourLocationsCheck($this->input->post('locations'));
							if(empty($tourlocations)){
								echo '<div class="alert alert-danger">Please Select at least One location</div><br>';
							}else{
							$tourid = $this->Tours_model->add_tour($this->data['userloggedin']);
							$this->Tours_model->add_translation($this->input->post('translated'), $tourid);
							$this->session->set_flashdata('flashmsgs', 'Tour added Successfully');
							echo "done";
						}
						}

				}
				else {

						$this->data['tourtypes'] = $this->Tours_model->get_tsettings_data("ttypes");
						$this->data['tourcategories'] = $this->Tours_model->get_tsettings_data("tcategory");
						$this->data['tourratings'] = $this->Tours_model->get_tsettings_data("tratings");
						$this->data['tourinclusions'] = $this->Tours_model->get_tsettings_data("tamenities");
						$this->data['tourexclusions'] = $this->Tours_model->get_tsettings_data("texclusions");
						$this->data['tourpayments'] = $this->Tours_model->get_tsettings_data("tpayments");
						$this->data['all_countries'] = $this->Countries_model->get_all_countries();
						$this->data['all_tours'] = $this->Tours_model->select_related_tours($this->data['userloggedin']);

						$this->load->model('Admin/Locations_model');

						//$this->data['locations'] = $this->Locations_model->getLocationsBackend();

						$this->data['main_content'] = 'Tours/manage';
						$this->data['page_title'] = 'Add Tour';
						$this->data['headingText'] = 'Add Tour';
						$this->load->view('Admin/template', $this->data);
				}
			}



		}

		function settings() {

			$isadmin = $this->session->userdata('pt_logged_admin');
				if (empty ($isadmin)) {
						redirect($this->data['adminsegment'] . '/tours/');
				}
				$updatesett = $this->input->post('updatesettings');
				$addsettings = $this->input->post('add');
				$updatetypesett = $this->input->post('updatetype');

				if (!empty ($updatesett)) {

						$this->Tours_model->updateTourSettings();
						redirect('admin/tours/settings');
				}

                if (!empty ($addsettings)) {
                    $id = $this->Tours_model->addSettingsData();
                    $this->Tours_model->updateSettingsTypeTranslation($this->input->post('translated'),$id);
                    redirect('admin/tours/settings');

				}

                if (!empty ($updatetypesett)) {
                   $this->Tours_model->updateSettingsData();
                   $this->Tours_model->updateSettingsTypeTranslation($this->input->post('translated'),$this->input->post('settid'));
                    redirect('admin/tours/settings');

				}

				$this->LoadXcrudTourSettings("tamenities");
				$this->LoadXcrudTourSettings("ttypes");
				$this->LoadXcrudTourSettings("tpayments");
				$this->LoadXcrudTourSettings("texclusions");

                $this->data['typeSettings'] = $this->Tours_model->get_tour_settings_data();

				@ $this->data['settings'] = $this->Settings_model->get_front_settings("tours");
				$this->data['main_content'] = 'Tours/settings';
				$this->data['page_title'] = 'Tours Settings';
				$this->load->view('Admin/template', $this->data);

		/*
				$this->load->model('admin/settings_model');
				$this->data['all_countries'] = $this->Countries_model->get_all_countries();
				$updatesett = $this->input->post('updatesettings');
				if (!empty ($updatesett)) {
						$this->Settings_model->update_front_settings();
						redirect('admin/tours/settings');
				}
				$this->data['tourtypes'] = $this->Tours_model->get_tour_settings_data("ttypes");
				$this->data['tourcategories'] = $this->Tours_model->get_tour_settings_data("tcategory");
				$this->data['tourratings'] = $this->Tours_model->get_tour_settings_data("tratings");
				$this->data['tourinclusions'] = $this->Tours_model->get_tour_settings_data("tamenities");
				$this->data['tourexclusions'] = $this->Tours_model->get_tour_settings_data("texclusions");
				$this->data['tourpayments'] = $this->Tours_model->get_tour_settings_data("tpayments");
				$this->data['settings'] = $this->Settings_model->get_front_settings("tours");
				$this->data['main_content'] = 'Tours/settings';
				$this->data['page_title'] = 'Tours Settings';
				$this->load->view('Admin/template', $this->data);*/
		}

		function manage($tourname) {

				$this->data['upload_allowed'] = pt_can_upload();
				$this->load->model('Tours/Tours_uploads_model');
				$this->load->model('Admin/Accounts_model');
				if (empty ($tourname)) {
						redirect($this->data['adminsegment'] . '/tours/');
				}
				$updatetour = $this->input->post('submittype');
				$this->data['submittype'] = "update";
				$tourid = $this->input->post('tourid');
				if (!empty ($updatetour)) {
						$this->form_validation->set_rules('tourname', 'Tour Name', 'trim|required');
						$this->form_validation->set_rules('tourtype', 'Tour Type', 'trim|required');
						$this->form_validation->set_rules('adultprice', 'Adult Price', 'trim|required');

						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
							$tourlocations = $this->tourLocationsCheck($this->input->post('locations'));
							if(empty($tourlocations)){
								echo '<div class="alert alert-danger">Please Select at least One location</div><br>';
							}else{

							$this->Tours_model->update_tour($tourid);
							$this->Tours_model->update_translation($this->input->post('translated'), $tourid);
							$this->session->set_flashdata('flashmsgs', 'Tour Updated Successfully');
							echo "done";

							}



						}
				}
				else {
						$this->data['tdata'] = $this->Tours_model->get_tour_data($tourname);

						if (empty ($this->data['tdata'])) {
								redirect($this->data['adminsegment'] . '/tours/');
						}
                       $comfixed = $this->data['tdata'][0]->tour_comm_fixed;
                       $comper = $this->data['tdata'][0]->tour_comm_percentage;
                       if($comfixed > 0){
                         $this->data['tourdepositval'] = $comfixed;
                         $this->data['tourdeposittype'] = "fixed";
                       }else{
                         $this->data['tourdepositval'] = $comper;
                         $this->data['tourdeposittype'] = "percentage";
                       }

                       $taxfixed = $this->data['tdata'][0]->tour_tax_fixed;
                       $taxper = $this->data['tdata'][0]->tour_tax_percentage;
                       if($taxfixed > 0){
                         $this->data['tourtaxval'] = $taxfixed;
                         $this->data['tourtaxtype'] = "fixed";
                       }else{
                         $this->data['tourtaxval'] = $taxper;
                         $this->data['tourtaxtype'] = "percentage";
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

						$this->data['all_tours'] = $this->Tours_model->select_related_tours($this->data['tdata'][0]->tour_id);
						$this->data['map_data'] = $this->Tours_model->get_tour_map($this->data['tdata'][0]->tour_id);
						$this->data['maxmaporder'] = $this->Tours_model->max_map_order($this->data['tdata'][0]->tour_id);
						$this->data['has_start'] = $this->Tours_model->has_start_end_city("start", $this->data['tdata'][0]->tour_id);
						$this->data['has_end'] = $this->Tours_model->has_start_end_city("end", $this->data['tdata'][0]->tour_id);
						$this->data['offers_data'] = $this->Tours_model->offers_data($this->data['tdata'][0]->tour_id);
						$this->data['userinfo'] = $this->Accounts_model->get_profile_details($this->data['tdata'][0]->tour_owned_by);
						$this->data['tourtypes'] = $this->Tours_model->get_tsettings_data("ttypes");
						$this->data['tourcategories'] = $this->Tours_model->get_tsettings_data("tcategory");
						$this->data['tourratings'] = $this->Tours_model->get_tsettings_data("tratings");
						$this->data['tourinclusions'] = $this->Tours_model->get_tsettings_data("tamenities");
						$this->data['tourexclusions'] = $this->Tours_model->get_tsettings_data("texclusions");
						$this->data['tourpayments'] = $this->Tours_model->get_tsettings_data("tpayments");
						$this->data['tourid'] = $this->data['tdata'][0]->tour_id;

						$this->load->model('Admin/Locations_model');
						//$this->data['locations'] = $this->Locations_model->getLocationsBackend();
						$this->data['tourlocations'] = $this->Tours_model->tourSelectedLocations($this->data['tdata'][0]->tour_id);

						$this->data['main_content'] = 'Tours/manage';
						$this->data['page_title'] = 'Manage Tour';
						$this->load->view('Admin/template', $this->data);
				}
		}


				function gallery($id) {

				$this->load->library('Tours/Tours_lib');
				$this->Tours_lib->set_tourid($id);
				$this->data['itemid'] = $this->Tours_lib->get_id();
				$this->data['images'] = $this->Tours_model->tourGallery($id);
                $this->data['imgorderUrl'] = base_url().'tours/tourajaxcalls/update_image_order';
                $this->data['uploadUrl'] = base_url().'tours/toursback/galleryUpload/tours/';
                $this->data['delimgUrl'] = base_url().'tours/tourajaxcalls/delete_image';
                $this->data['appRejUrl'] = base_url().'tours/tourajaxcalls/app_rej_timages';
                $this->data['makeThumbUrl'] = base_url().'tours/tourajaxcalls/makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'tours/tourajaxcalls/deleteMultipleTourImages';
                $this->data['fullImgDir'] = PT_TOURS_SLIDER;
                $this->data['thumbsDir'] = PT_TOURS_SLIDER_THUMB;
				$this->data['main_content'] = 'Tours/gallery';
				$this->data['page_title'] = 'Tour Gallery';
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
						$targetPath = PT_TOURS_SLIDER_UPLOAD;
                        $targetFile = $targetPath . $saveFile;

						move_uploaded_file($tempFile, $targetFile);

						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;
                        $config['new_image'] = PT_TOURS_SLIDER_THUMB_UPLOAD;

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
						$this->Tours_model->addPhotos($id, $saveFile);

				}
			}
		}


// Delete tour images

		public function deleteimg($file, $type) {
				if ($type == "slider") {
						@ unlink(PT_TOURS_SLIDER_THUMB_UPLOAD . $file);
						@ unlink(PT_TOURS_SLIDER_UPLOAD . $file);
				}
				$this->db->where('timg_image', $file);
				$this->db->delete('pt_tour_images');
				$js = array("files" => array(array($file => "true")));
				echo json_encode($js);
		}


		function translate($tourslug, $lang = null) {
				$this->load->library('Tours/Tours_lib');
				$this->Tours_lib->set_tourid($tourslug);
				$add = $this->input->post('add');
				$update = $this->input->post('update');
				if (empty ($lang)) {
						$lang = $this->langdef;
				}
				else {
						$lang = $lang;
				}
				if (empty ($tourslug)) {
						redirect($this->data['adminsegment'] . '/tours/');
				}
				if (!empty ($add)) {
						$language = $this->input->post('langname');
						$tourid = $this->input->post('tourid');
						$this->Tours_model->add_translation($language, $tourid);
						redirect($this->data['adminsegment'] . "/tours/translate/" . $tourslug . "/" . $language);
				}
				if (!empty ($update)) {
						$slug = $this->Tours_model->update_translation($lang, $tourslug);
						redirect($this->data['adminsegment'] . "/tours/translate/" . $slug . "/" . $lang);
				}
				$tdata = $this->Tours_lib->tour_details();
				if ($lang == $this->langdef) {
						$toursdata = $this->Tours_lib->tour_short_details();
						$this->data['toursdata'] = $toursdata;
						$this->data['transpolicy'] = $toursdata[0]->tour_privacy;
						$this->data['transdesc'] = $toursdata[0]->tour_desc;
						$this->data['transtitle'] = $toursdata[0]->tour_title;
				}
				else {
						$toursdata = $this->Tours_lib->translated_data($lang);
						$this->data['toursdata'] = $toursdata;
						$this->data['transid'] = $toursdata[0]->trans_id;
						$this->data['transpolicy'] = $toursdata[0]->trans_policy;
						$this->data['transdesc'] = $toursdata[0]->trans_desc;
						$this->data['transtitle'] = $toursdata[0]->trans_title;
				}
				$this->data['tourid'] = $this->Tours_lib->get_id();
				$this->data['lang'] = $lang;
				$this->data['slug'] = $tourslug;
				$this->data['language_list'] = pt_get_languages();
				if ($this->data['adminsegment'] == "supplier") {
						if ($this->data['userloggedin'] != $tdata[0]->tour_owned_by) {
								redirect($this->data['adminsegment'] . '/tours/');
						}
				}
				$this->data['main_content'] = 'Tours/translate';
				$this->data['page_title'] = 'Translate Tour';
				$this->load->view('Admin/template', $this->data);
		}


		function LoadXcrudTourSettings($type) {
				$xc = "xcrud" . $type;
				$xc = xcrud_get_instance();
				$xc->table('pt_tours_types_settings');
				$xc->where('sett_type', $type);
				$xc->order_by('sett_id', 'desc');
				$xc->button('#sett{sett_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
				$delurl = base_url().'tours/tourajaxcalls/delTypeSettings';
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

				$xc->multiDelUrl = base_url().'tours/tourajaxcalls/delMultiTypeSettings/'.$type;

				$this->data['content' . $type] = $xc->render();
		}

		function extras(){


         if($this->data['adminsegment'] == "supplier"){
			 $supplierTours = $this->Tours_model->all_tours($this->data['userloggedin']);
			 $alltours = $this->Tours_model->all_tours();

         echo  modules :: run('Admin/extras/listings','tours',$alltours,$supplierTours);

		}else{

			$tours = $this->Tours_model->all_tours();
         echo  modules :: run('Admin/extras/listings','tours',$tours);

		}

        }

        function reviews(){

         echo  modules :: run('Admin/reviews/listings','tours');
        }


        function tourLocationsCheck($locations){
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
        $xcrud->table('pt_tours_packages');
        $xcrud->order_by('id', 'desc');
        $xcrud->change_type('start_date', 'date', date('Y-m-d'));
        $xcrud->change_type('end_date', 'date', date('Y-m-d'));
        $xcrud->change_type('tour_id', 'hidden',$this->input->get('id'));
        $xcrud->columns(array('tour_id'),true);
        $xcrud->where('tour_id',$this->input->get('id'));
        $this->data['content'] = $xcrud->render();
        $this->load->view('Tours/xcrud', $this->data);
        }


}
