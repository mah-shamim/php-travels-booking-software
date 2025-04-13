<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class KiwiBack extends MX_Controller {
        public $accType = "";
        public $role = "";
        public  $editpermission = true;
        public  $deletepermission = true;
		function __construct() {
				$seturl = $this->uri->segment(3);
				if ($seturl != "settings") {
						$chk = modules :: run('Home/is_main_module_enabled', 'Kiwi');
						if (!$chk) {
								backError_404($this->data);
						}
				}
				$checkingadmin = $this->session->userdata('pt_logged_admin');
				$this->accType = $this->session->userdata('pt_accountType');
				$this->role = $this->session->userdata('pt_role');

		        $this->data['userloggedin'] = $this->session->userdata('pt_logged_id');
				if (empty ($this->data['userloggedin'])) {
					$urisegment =  $this->uri->segment(1);
					$this->session->set_userdata('prevURL', current_url());
						redirect($urisegment);
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
						$chksupplier = modules :: run('supplier/validsupplier');
						if (!$chksupplier) {
								redirect('supplier');
						}
				}
				$this->data['appModule'] = "flights";

                $this->data['appSettings'] = modules :: run('Admin/appSettings');
				$this->load->library('Ckeditor');
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				//$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
				$this->load->helper('Flights/flights');
				$this->data['languages'] = pt_get_languages();
				$this->load->helper('xcrud');
				$this->data['c_model'] = $this->countries_model;
				$this->data['tripadvisor    '] = $this->ptmodules->is_mod_available_enabled("tripadvisor");
                $this->data['addpermission'] = true;
                if($this->role == "supplier" || $this->role == "admin"){
                $this->editpermission = pt_permissions("editflights", $this->data['userloggedin']);
                $this->deletepermission = pt_permissions("deleteflights", $this->data['userloggedin']);
                $this->data['addpermission'] = pt_permissions("addflights", $this->data['userloggedin']);
                }
				$this->data['all_countries'] = $this->Countries_model->get_all_countries();
				$this->load->helper('settings');
				$this->load->model('Admin/Accounts_model');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');

		}

		function index(){

			$this->load->helper('xcrud');
			$xcrud = xcrud_get_instance();
			$xcrud->table('pt_flights');
			$xcrud->change_type('thumbnail', 'image', false, array(
			'width' => 450,
			'path' => '../../'.PT_FLIGHTS_SLIDER_UPLOAD));
		//	$xcrud->columns('social_icon,social_name,social_link,social_order,social_status');
			$xcrud->column_class('thumnail','zoom_img');
			$xcrud->column_callback('status', 'create_status_icon');
			$this->data['content'] = $xcrud->render();
			$this->data['page_title'] = 'Flights Management';
			$this->data['main_content'] = 'temp_view';
            $this->data['table_name'] = 'pt_flights';
            $this->data['main_key'] = 'id';
			$this->data['header_title'] = 'Flights Management';
			$this->load->view('Admin/template', $this->data);

		}

		public function setting_routes(){
		     $s = app()->service("ModuleService")->get("flights")->test;
            $this->data['page_title'] = 'Flights Management';
            $this->data['main_content'] = 'settings';
            $this->data["check"] = $s;
            $this->data['header_title'] = 'Flights Management';
            $this->load->view('Admin/template', $this->data);
        }
        public function add_settings(){

		   $mode = $this->input->post('mode');
		   if($mode == 1){
            app()->service("ModuleService")->update("flights","test","true");}
		   else{
		    app()->service("ModuleService")->update("flights","test","false");}

            echo '<div class="alert alert-success">' . "Successfully Save" . '</div>';

        }

    function airlines(){

        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_flights_airlines');
        $xcrud->change_type('thumbnail', 'image', false, array(
            'width' => 450,
            'path' => '../../'.PT_FLIGHTS_AIRLINES_UPLOAD));

        //	$xcrud->columns('social_icon,social_name,social_link,social_order,social_status');
        $xcrud->column_class(array('thumnail','zoom_img'));

        $xcrud->relation('country','pt_flights_countries','name',array('name'));

        $xcrud->validation_required('thumbnail');

        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Flights Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_flights_airlines';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Flights Management';
        $this->load->view('Admin/template', $this->data);

    }
    function countries(){

        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_flights_countries');

        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Country Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_flights_countries';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Country Management';
        $this->load->view('Admin/template', $this->data);

    }

    function airports(){

        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_flights_airports');


        //	$xcrud->columns('social_icon,social_name,social_link,social_order,social_status');
        $xcrud->column_class('thumnail','zoom_img');
        $xcrud->column_callback('status', 'create_status_icon');
        $xcrud->relation('Country Name','countries','country_name','name');

        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Airports';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_flights_airports';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Airports Management';
        $this->load->view('Admin/template', $this->data);

    }



		function settings(){
				$isadmin = $this->session->userdata('pt_logged_admin');
				if (empty ($isadmin)) {
						redirect($this->data['adminsegment'] . '/Flights/');
				}
				$this->data['all_countries'] = $this->Countries_model->get_all_countries();
				$updatesett = $this->input->post('updatesettings');
				$addsettings = $this->input->post('add');
				$updatetypesett = $this->input->post('updatetype');

				if (!empty ($updatesett)) {
						$this->Flights_model->updateflightsettings();
						redirect('admin/Flights/settings');
				}

                if (!empty ($addsettings)) {
                    $id = $this->Flights_model->addSettingsData();
                    $this->Flights_model->updateSettingsTypeTranslation($this->input->post('translated'),$id);
                    redirect('admin/Flights/settings');

				}

                if (!empty ($updatetypesett)) {
                   $this->Flights_model->updateSettingsData();
                   $this->Flights_model->updateSettingsTypeTranslation($this->input->post('translated'),$this->input->post('settid'));
                    redirect('admin/Flights/settings');

				}

				$this->LoadXcrudflightsettings("hamenities");
				$this->LoadXcrudflightsettings("htypes");
				$this->LoadXcrudflightsettings("hpayments");
				$this->LoadXcrudflightsettings("ramenities");
				$this->LoadXcrudflightsettings("rtypes");
                $this->data['typeSettings'] = $this->Flights_model->get_flight_settings_data();
				$this->data['all_flights'] = $this->Flights_model->all_Flights_names();
				@ $this->data['settings'] = $this->Settings_model->get_front_settings("flights");
				$this->data['main_content'] = 'Flights/settings';
				$this->data['page_title'] = 'flights Settings';
				$this->load->view('Admin/template', $this->data);
		}
// Add flights

		public function add() {
                 if(!$this->data['addpermission']){
                 backError_404($this->data);

				  }else{
                $this->load->model('Admin/Uploads_model');
				$addflight = $this->input->post('submittype');

                $this->data['submittype'] = "add";

				if (!empty ($addflight)) {
						$this->form_validation->set_rules('flightname', 'flight Name', 'trim|required');
						$this->form_validation->set_rules('flightdesc', 'Description', 'trim|required');
						$this->form_validation->set_rules('flightcity', 'Location', 'trim|required');
						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
								$flightid = $this->Flights_model->add_flight($this->data['userloggedin']);
								$this->Flights_model->add_translation($this->input->post('translated'), $flightid);
								$this->session->set_flashdata('flashmsgs', 'flight added Successfully');
								echo "done";
						}
				}
				else {
						$this->data['main_content'] = 'Flights/manage';
						$this->data['page_title'] = 'Add flight';
						$this->data['headingText'] = 'Add flight';
						$this->data['default_checkin_out'] = $this->Settings_model->get_default_checkin_out();
						$this->data['checkin'] = $this->data['default_checkin_out'][0]->front_checkin_time;
						$this->data['checkout'] = $this->data['default_checkin_out'][0]->front_checkout_time;
						$this->data['htypes'] = pt_get_hsettings_data("htypes");
						$this->data['hamts'] = pt_get_hsettings_data("hamenities");
						$this->data['hpayments'] = pt_get_hsettings_data("hpayments");
						$this->data['all_flights'] = $this->Flights_model->select_related_flights($this->data['userloggedin']);
						$this->load->model('Admin/Locations_model');
						$this->data['locations'] = $this->Locations_model->getLocationsBackend();
						$this->load->view('Admin/template', $this->data);
				}
			}
		}

		function manage($flightslug) {
				if (empty ($flightslug)) {
						redirect($this->data['adminsegment'] . '/Flights/');
				}
               if(!$this->editpermission){
                 echo "<center><h1>Access Denied</h1></center>";
                 backError_404($this->data);
				  }else{
				$updateflight = $this->input->post('submittype');
				$this->data['submittype'] = "update";
				$flightid = $this->input->post('flightid');
				if (!empty ($updateflight)) {
						$this->form_validation->set_rules('flightname', 'flight Name', 'trim|required');
						$this->form_validation->set_rules('flightdesc', 'Description', 'trim|required');
						$this->form_validation->set_rules('flightcity', 'Location', 'trim|required');
						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {
								$this->Flights_model->update_flight($flightid);
								$this->Flights_model->update_translation($this->input->post('translated'), $flightid);
								$this->session->set_flashdata('flashmsgs', 'flight Updated Successfully');
								echo "done";
						}
				}
				else {
						@ $this->data['hdata'] = $this->Flights_model->get_flight_data($flightslug);
						$comfixed = @ $this->data['hdata'][0]->flight_comm_fixed;
						$comper = $this->data['hdata'][0]->flight_comm_percentage;
						if ($comfixed > 0) {
								$this->data['flightdepositval'] = $comfixed;
								$this->data['flightdeposittype'] = "fixed";
						}
						else {
								$this->data['flightdepositval'] = $comper;
								$this->data['flightdeposittype'] = "percentage";
						}
						$taxfixed = $this->data['hdata'][0]->flight_tax_fixed;
						$taxper = $this->data['hdata'][0]->flight_tax_percentage;
						if ($taxfixed > 0) {
								$this->data['flighttaxval'] = $taxfixed;
								$this->data['flighttaxtype'] = "fixed";
						}
						else {
								$this->data['flighttaxval'] = $taxper;
								$this->data['flighttaxtype'] = "percentage";
						}
						if ($this->data['adminsegment'] == "supplier") {
								if ($this->data['userloggedin'] != $this->data['hdata'][0]->flight_owned_by) {
										redirect($this->data['adminsegment'] . '/Flights/');
								}
						}
						$this->data['main_content'] = 'Flights/manage';
						$this->data['page_title'] = 'Manage flight';
						$this->data['headingText'] = 'Update ' . $this->data['hdata'][0]->flight_title;
						$locInfo = pt_LocationsInfo($this->data['hdata'][0]->flight_city);
						$this->data['locationName'] = $locInfo->city.", ".$locInfo->country;
						$this->data['checkin'] = $this->data['hdata'][0]->flight_check_in;
						$this->data['checkout'] = $this->data['hdata'][0]->flight_check_out;
						$this->data['hrelated'] = explode(",", $this->data['hdata'][0]->flight_related);
						$this->data['featuredfrom'] = pt_show_date_php($this->data['hdata'][0]->flight_featured_from);
						$this->data['featuredto'] = pt_show_date_php($this->data['hdata'][0]->flight_featured_to);
						$this->data['htypes'] = pt_get_hsettings_data("htypes");
						$this->data['hamts'] = pt_get_hsettings_data("hamenities");
						$this->data['flightamt'] = explode(",", $this->data['hdata'][0]->flight_amenities);
						$this->data['hpayments'] = pt_get_hsettings_data("hpayments");
						$this->data['flightpaytypes'] = explode(",", $this->data['hdata'][0]->flight_payment_opt);
						$this->data['all_flights'] = $this->Flights_model->select_related_flights($this->data['userloggedin']);
						$this->load->model('Admin/Locations_model');
						$this->data['locations'] = $this->Locations_model->getLocationsBackend();
						$this->data['flightid'] = $this->data['hdata'][0]->flight_id;
						$this->load->view('Admin/template', $this->data);
				}
			}
		}
		
		function translate($flightslug, $lang = null) 
		{
			$this->load->library('Flights/Flights_lib');
			$this->Flights_lib->set_flightid($flightslug);
			$add = $this->input->post('add');
			$update = $this->input->post('update');
			if (empty ($lang)) {
					$lang = $this->langdef;
			}
			else {
					$lang = $lang;
			}
			$this->data['lang'] = $lang;
			if (empty ($flightslug)) {
					redirect($this->data['adminsegment'] . '/Flights/');
			}
			if (!empty ($add)) {
					$language = $this->input->post('langname');
					$flightid = $this->input->post('flightid');
					$this->Flights_model->add_translation($language, $flightid);
					redirect($this->data['adminsegment'] . "/Flights/translate/" . $flightslug . "/" . $language);
			}
			if (!empty ($update)) {
					$slug = $this->Flights_model->update_translation($lang, $flightslug);
					redirect($this->data['adminsegment'] . "/Flights/translate/" . $slug . "/" . $lang);
			}
			$hdata = $this->Flights_lib->flight_details();
			if ($lang == $this->langdef) {
					$flightsdata = $this->Flights_lib->flight_short_details();
					$this->data['flightsdata'] = $flightsdata;
					$this->data['transpolicy'] = $flightsdata[0]->flight_policy;
					$this->data['transadditional'] = $flightsdata[0]->flight_additional_facilities;
					$this->data['transdesc'] = $flightsdata[0]->flight_desc;
					$this->data['transtitle'] = $flightsdata[0]->flight_title;
			}
			else {
					$flightsdata = $this->Flights_lib->translated_data($lang);
					$this->data['flightsdata'] = $flightsdata;
					$this->data['transid'] = $flightsdata[0]->trans_id;
					$this->data['transpolicy'] = $flightsdata[0]->trans_policy;
					$this->data['transadditional'] = $flightsdata[0]->trans_additional;
					$this->data['transdesc'] = $flightsdata[0]->trans_desc;
					$this->data['transtitle'] = $flightsdata[0]->trans_title;
			}
			$this->data['flightid'] = $this->Flights_lib->get_id();
			$this->data['lang'] = $lang;
			$this->data['slug'] = $flightslug;
			$this->data['language_list'] = pt_get_languages();
			if ($this->data['adminsegment'] == "supplier") {
					if ($this->data['userloggedin'] != $hdata[0]->flight_owned_by) {
							redirect($this->data['adminsegment'] . '/Flights/');
					}
			}
			$this->data['main_content'] = 'Flights/translate';
			$this->data['page_title'] = 'Translate flight';
			$this->load->view('Admin/template', $this->data);
		}

		function gallery($id) {
				$this->load->library('Flights/Flights_lib');
				$this->Flights_lib->set_flightid($id);
				$this->data['itemid'] = $this->Flights_lib->get_id();
				$this->data['images'] = $this->Flights_model->flightGallery($id);
                $this->data['imgorderUrl'] = base_url().'admin/flightajaxcalls/update_image_order';
                $this->data['uploadUrl'] = base_url().'Flights/flightsback/galleryUpload/Flights/';
                $this->data['delimgUrl'] = base_url().'admin/flightajaxcalls/delete_image';
                $this->data['appRejUrl'] = base_url().'admin/flightajaxcalls/app_rej_himages';
                $this->data['makeThumbUrl'] = base_url().'admin/flightajaxcalls/makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'admin/flightajaxcalls/deleteMultipleflightImages';
                $this->data['fullImgDir'] = PT_Flights_SLIDER;
                $this->data['thumbsDir'] =PT_Flights_SLIDER_THUMBS;
				$this->data['main_content'] = 'Flights/gallery';
				$this->data['page_title'] = 'flight Gallery';
				$this->load->view('Admin/template', $this->data);
		}

        function roomgallery($id) {
				$this->data['images'] = $this->Rooms_model->roomGallery($id);
                $this->data['imgorderUrl'] = base_url().'admin/flightajaxcalls/update_room_image_order';
                $this->data['uploadUrl'] = base_url().'Flights/flightsback/galleryUpload/rooms/';
                $this->data['delimgUrl'] = base_url().'admin/flightajaxcalls/delete_room_image';
                $this->data['appRejUrl'] = base_url().'admin/flightajaxcalls/app_rej_rimages';
                $this->data['makeThumbUrl'] = base_url().'admin/flightajaxcalls/room_makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'admin/flightajaxcalls/deleteMultipleRoomImages';
                $this->data['fullImgDir'] = PT_ROOMS_IMAGES;
                $this->data['thumbsDir'] = PT_ROOMS_THUMBS;
               	$this->data['itemid'] = $id;
                $this->data['main_content'] = 'Flights/gallery';
				$this->data['page_title'] = 'Room Gallery';
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

                        if($type == "flights"){
						$targetPath = PT_Flights_SLIDER_UPLOAD;
                        }elseif($type == "rooms"){
                        $targetPath = PT_ROOMS_IMAGES_UPLOAD;
                        }

						$targetFile = $targetPath . $saveFile;
						move_uploaded_file($tempFile, $targetFile);
						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;

						if($type == "flights"){
						$config['new_image'] = PT_Flights_SLIDER_THUMBS_UPLOAD;
						}elseif($type == "rooms"){
						$config['new_image'] = PT_ROOMS_THUMBS_UPLOAD;
						}

						$config['thumb_marker'] = '';
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = THUMB_WIDTH;
						$config['height'] = THUMB_HEIGHT;
						$this->image_lib->clear();
						$this->image_lib->initialize($config);
						$this->image_lib->resize();

						modules :: run('Admin/watermark/apply',$targetFile);

                        if($type == "flights"){
                    /* Add images name to database with respective flight id */
						$this->Flights_model->addPhotos($id, $saveFile);
                        }elseif($type == "rooms"){
                    /* Add images name to database with respective room id */
                        $this->Rooms_model->addPhotos($id, $saveFile);
                        }

                    }
				}
		}

		function LoadXcrudflightsettings($type) 
		{
				$xc = "xcrud" . $type;
				$xc = xcrud_get_instance();
				$xc->table('pt_Flights_types_settings');
				$xc->where('sett_type', $type);
				$xc->order_by('sett_id', 'desc');
				$xc->button('#sett{sett_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
				$delurl = base_url().'admin/flightajaxcalls/delTypeSettings';
               	$xc->button("javascript: delfunc('{sett_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self','id' => '{sett_id}'));


                if($type == "rtypes" || $type == "htypes"){
                $xc->columns('sett_name,sett_status');
                }else{
                 if($type == "hamenities"){
                 $xc->columns('sett_img,sett_name,sett_selected,sett_status');
                $xc->column_class('sett_img', 'zoom_img');
				$xc->change_type('sett_img', 'image', false, array('width' => 200, 'path' => '../../'.PT_Flights_ICONS_UPLOAD, 'thumbs' => array(array('height' => 150, 'width' => 120, 'crop' => true, 'marker' => ''))));

                 }else{
                $xc->columns('sett_name,sett_selected,sett_status');
                }

                 }
                $xc->search_columns('sett_name,sett_selected,sett_status');
                $xc->label('sett_name', 'Name')->label('sett_selected', 'Selected')->label('sett_status', 'Status')->label('sett_img', 'Icon');
                $xc->unset_add();
				$xc->unset_edit();
				$xc->unset_remove();
				$xc->unset_view();
				$xc->multiDelUrl = base_url().'admin/flightajaxcalls/delMultiTypeSettings/'.$type;
				$this->data['content' . $type] = $xc->render();
		}

        function extras(){


		if($this->data['adminsegment'] == "supplier"){

			 $supplierflights = $this->Flights_model->all_flights($this->data['userloggedin']);
			 $allflights = $this->Flights_model->all_flights();

			 echo  modules :: run('Admin/extras/listings','flights',$allflights, $supplierflights);

		}else{


			 $flights = $this->Flights_model->all_flights();

			echo  modules :: run('Admin/extras/listings','flights',$flights);

		}


        }

        function reviews(){

         echo  modules :: run('Admin/Reviews/listings','flights');
        }

}
