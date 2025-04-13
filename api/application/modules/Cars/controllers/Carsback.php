<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Carsback extends MX_Controller {

		public $accType = "";
        public $role = "";
        public  $editpermission = true;
        public  $deletepermission = true;

		function __construct() {
				$seturl = $this->uri->segment(3);
				if ($seturl != "settings") {
						$chk = modules :: run('Home/is_main_module_enabled', 'cars');
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
                $this->data['appSettings'] = modules :: run('Admin/appSettings');
				$this->load->library('Ckeditor');
				$this->data['ckconfig'] = array();
				$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
				$this->data['ckconfig']['language'] = 'en';
				$this->data['ckconfig']['filebrowserBrowseUrl'] = '';
				$this->data['ckconfig']['filebrowserImageBrowseUrl'] = '';
				$this->data['ckconfig']['filebrowserFlashBrowseUrl'] = '';
				$this->data['ckconfig']['filebrowserUploadUrl'] = '';
				$this->data['ckconfig']['filebrowserImageUploadUrl'] = '';
				$this->data['ckconfig']['filebrowserFlashUploadUrl'] = '';
				/*$this->data['ckconfig']['filebrowserBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=files';
				$this->data['ckconfig']['filebrowserImageBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=images';
				$this->data['ckconfig']['filebrowserFlashBrowseUrl'] = base_url() . 'assets/include/kcfinder/browse.php?type=flash';
				$this->data['ckconfig']['filebrowserUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=files';
				$this->data['ckconfig']['filebrowserImageUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=images';
				$this->data['ckconfig']['filebrowserFlashUploadUrl'] = base_url() . 'assets/include/kcfinder/upload.php?type=flash';*/
				$this->load->helper('Cars/cars');
				$this->data['languages'] = pt_get_languages();
				$this->load->helper('xcrud');
				$this->data['c_model'] = $this->countries_model;

                $this->data['addpermission'] = true;
                if($this->role == "supplier" || $this->role == "admin"){
                $this->editpermission = pt_permissions("editcars", $this->data['userloggedin']);
                $this->deletepermission = pt_permissions("deletecars", $this->data['userloggedin']);
                $this->data['addpermission'] = pt_permissions("addcars", $this->data['userloggedin']);
                }


				$this->load->model('Admin/Locations_model');
				$this->data['locations'] = $this->Locations_model->getLocationsBackend();
				$this->load->helper('settings');
				$this->load->model('Admin/Accounts_model');
				$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
				$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
				$this->load->model('Cars/Cars_model');
		}

		function index() {
			if(!$this->data['addpermission'] && !$this->editpermission && !$this->deletepermission){
                	backError_404($this->data);

                }else{
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_cars');

                if($this->role == "supplier"){
                $xcrud->where('car_owned_by',$this->data['userloggedin']);

                }
				$xcrud->join('car_owned_by', 'pt_accounts', 'accounts_id');
				//$xcrud->join('car_city', 'pt_locations', 'id');
				$xcrud->order_by('pt_cars.car_id', 'desc');
				$xcrud->subselect('Owned By', 'SELECT CONCAT(ai_first_name, " ", ai_last_name) FROM pt_accounts WHERE accounts_id = {car_owned_by}');
				$xcrud->label('car_title', 'Name')->label('car_stars', 'Stars')->label('car_is_featured', '')->label('car_order', 'Order');
                if($this->editpermission){
                $xcrud->button(base_url() . $this->data['adminsegment'] . '/cars/manage/{car_slug}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
                $xcrud->column_pattern('car_title', '<a href="' . base_url() . $this->data['adminsegment'] . '/cars/manage/{car_slug}' . '">{value}</a>');
                }

                $xcrud->limit(50);
				$xcrud->unset_add();
				$xcrud->unset_edit();
				/*$xcrud->unset_remove(); */
				$xcrud->unset_view();
				$xcrud->column_width('car_order', '7%');
				$xcrud->columns('car_is_featured,thumbnail_image,car_title,car_stars,Owned By,car_location,car_slug,car_order,discount,car_status');

				$xcrud->search_columns('car_is_featured,car_title,car_stars,Owned By,car_city,car_order,car_status');
				$xcrud->label('pt_cars.car_location', 'Location');
				$xcrud->label('thumbnail_image', 'Image');
                $xcrud->column_callback('pt_cars.discount', 'discountInputCars');

                $xcrud->label('car_slug', 'Gallery');
				$xcrud->label('car_status', 'Status');
				$xcrud->column_callback('car_stars', 'create_stars');
				$xcrud->column_callback('pt_cars.car_order', 'orderInputCars');
				$xcrud->column_callback('pt_cars.car_is_featured', 'feature_starsCars');
				$xcrud->column_callback('car_slug', 'carGallery');
				$xcrud->column_callback('car_status', 'create_status_icon');
				$xcrud->column_callback('car_location', 'carsFirstLocation');
				$xcrud->column_class('thumbnail_image', 'zoom_img');
				$xcrud->change_type('thumbnail_image', 'image', false, array('width' => 200, 'path' => '../../'.PT_CARS_SLIDER_THUMB_UPLOAD, 'thumbs' => array(array('height' => 150, 'width' => 120, 'crop' => true, 'marker' => ''))));
				$this->data['content'] = $xcrud->render();
				$this->data['page_title'] = 'Cars Management';
				$this->data['main_content'] = 'temp_view';
                if($this->deletepermission){
                $this->data['table_name'] = 'pt_cars';
                $this->data['main_key'] = 'car_id';
                }
				$this->data['header_title'] = 'Cars Management';
				$this->data['add_link'] = base_url(). $this->data['adminsegment'] . '/cars/add';
				$this->load->view('Admin/template', $this->data);
			}


		}

		function add() {
				$this->load->model('Cars/Cars_uploads_model');
				$addcar = $this->input->post('submittype');
				$this->data['submittype'] = "add";

				if (!empty ($addcar)) {
						$this->form_validation->set_rules('carname', 'Car Name', 'trim|required');
						//$this->form_validation->set_rules('carbasic', 'Basic Price', 'trim|required');
/*      $this->form_validation->set_rules('ocity','Origin City', 'trim|required');
$this->form_validation->set_rules('dcity','Destination City', 'trim|required');
$this->form_validation->set_rules('startdate','car Start Date', 'trim|required');
$this->form_validation->set_rules('enddate','car End Date', 'trim|required');

*/

						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {

										$carid = $this->Cars_model->add_car($this->data['userloggedin']);
										$this->Cars_model->add_translation($this->input->post('translated'), $carid);
										$this->Cars_model->updateCarLocations($this->input->post('locations'), $carid);
										echo "done";
								}
				}
				else {
						$this->data['cartypes'] = $this->Cars_model->get_csettings_data("ctypes");
						$this->data['carpayments'] = $this->Cars_model->get_csettings_data("cpayments");
						$this->data['all_countries'] = $this->Countries_model->get_all_countries();
						$this->data['all_cars'] = $this->Cars_model->select_related_cars();
						$this->data['main_content'] = 'Cars/manage';
						$this->data['page_title'] = 'Add Car';
						$this->load->view('Admin/template', $this->data);
				}
		}

		function settings() {
				$this->load->model('admin/settings_model');
				$this->data['all_countries'] = $this->Countries_model->get_all_countries();
				$updatesett = $this->input->post('updatesettings');
				$updatetypesett = $this->input->post('updatetype');
				$addsettings = $this->input->post('add');

				if (!empty ($addsettings)) {
                    $id = $this->Cars_model->addSettingsData();
                    $this->Cars_model->updateSettingsTypeTranslation($this->input->post('translated'),$id);
                    redirect('admin/cars/settings');

				}

				if (!empty ($updatesett)) {
						$this->Cars_model->updateCarSettings();
						redirect('admin/cars/settings');
				}

				if (!empty ($updatetypesett)) {
                   $this->Cars_model->updateSettingsData();
                   $this->Cars_model->updateSettingsTypeTranslation($this->input->post('translated'),$this->input->post('settid'));
                    redirect('admin/cars/settings');

				}

				 $this->data['typeSettings'] = $this->Cars_model->get_car_settings_data();


				$this->LoadXcrudCarSettings("ctypes");
				$this->LoadXcrudCarSettings("cpayments");


				$this->data['settings'] = $this->Settings_model->get_front_settings("cars");
				$this->data['main_content'] = 'Cars/settings';
				$this->data['page_title'] = 'Cars Settings';
				$this->load->view('Admin/template', $this->data);
		}

		function manage($carname) {
				$this->data['upload_allowed'] = pt_can_upload();
				$this->load->model('Cars/Cars_uploads_model');
				$this->load->model('Admin/Accounts_model');
				if (empty ($carname)) {
						redirect($this->data['adminsegment'] . '/cars/');
				}

				$updatecar = $this->input->post('submittype');
				$carid = $this->input->post('carid');
				if (!empty ($updatecar)) {

						$this->form_validation->set_rules('carname', 'car Name', 'trim|required');
						//$this->form_validation->set_rules('carbasic', 'Car Basic', 'trim|required');

						if ($this->form_validation->run() == FALSE) {
								echo '<div class="alert alert-danger">' . validation_errors() . '</div><br>';
						}
						else {

										$this->Cars_model->update_car($carid);
						        		$this->Cars_model->update_translation($this->input->post('translated'), $carid);
						        		$this->Cars_model->updateCarLocations($this->input->post('locations'), $carid);
										$this->session->set_flashdata('flashmsgs', 'Car Updated Successfully');
										echo "done";

						}



				}
				else {
						$this->data['cdata'] = $this->Cars_model->get_car_data($carname);

						$comfixed = $this->data['cdata'][0]->car_comm_fixed;
                       $comper = $this->data['cdata'][0]->car_comm_percentage;
                       if($comfixed > 0){
                         $this->data['cardepositval'] = $comfixed;
                         $this->data['cardeposittype'] = "fixed";
                       }else{
                         $this->data['cardepositval'] = $comper;
                         $this->data['cardeposittype'] = "percentage";
                       }

                       $taxfixed = $this->data['cdata'][0]->car_tax_fixed;
                       $taxper = $this->data['cdata'][0]->car_tax_percentage;
                       if($taxfixed > 0){
                         $this->data['cartaxval'] = $taxfixed;
                         $this->data['cartaxtype'] = "fixed";
                       }else{
                         $this->data['cartaxval'] = $taxper;
                         $this->data['cartaxtype'] = "percentage";
                       }

						if (empty ($this->data['cdata'])) {
								redirect($this->data['adminsegment'] . '/cars/');
						}

						$this->data['carid'] = $this->data['cdata'][0]->car_id;
						$this->data['submittype'] = "update";

						$this->data['all_cars'] = $this->Cars_model->select_related_cars($this->data['cdata'][0]->car_id);
            $this->data['cartypes'] = $this->Cars_model->get_csettings_data("ctypes");
						$this->data['carpayments'] = $this->Cars_model->get_csettings_data("cpayments");

						$this->data['carlocations'] = $this->Cars_model->carSelectedLocations($this->data['cdata'][0]->car_id);

						$this->data['main_content'] = 'Cars/manage';
						$this->data['page_title'] = 'Manage Car';
						$this->load->view('Admin/template', $this->data);
				}
		}


// Gallery Cars
			function gallery($id) {
				$this->load->library('Cars/Cars_lib');
				$this->Cars_lib->set_carid($id);
				$this->data['itemid'] = $this->Cars_lib->get_id();
				$this->data['images'] = $this->Cars_model->carGallery($id);
                $this->data['imgorderUrl'] = base_url().'cars/carajaxcalls/update_image_order';
                $this->data['uploadUrl'] = base_url().'cars/carsback/galleryUpload/cars/';
                $this->data['delimgUrl'] = base_url().'cars/carajaxcalls/delete_image';
                $this->data['appRejUrl'] = base_url().'cars/carajaxcalls/app_rej_timages';
                $this->data['makeThumbUrl'] = base_url().'cars/carajaxcalls/makethumb';
                $this->data['delMultipleImgsUrl'] = base_url().'cars/carajaxcalls/deleteMultipleCarImages';
                $this->data['fullImgDir'] = PT_CARS_SLIDER;
                $this->data['thumbsDir'] = PT_CARS_SLIDER_THUMB;
				$this->data['main_content'] = 'Cars/gallery';
				$this->data['page_title'] = 'Car Gallery';
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
						$targetPath = PT_CARS_SLIDER_UPLOAD;
                        $targetFile = $targetPath . $saveFile;

						move_uploaded_file($tempFile, $targetFile);

						$config['image_library'] = 'gd2';
						$config['source_image'] = $targetFile;
                        $config['new_image'] = PT_CARS_SLIDER_THUMB_UPLOAD;

						$config['thumb_marker'] = '';
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width'] = THUMB_WIDTH;
						$config['height'] = THUMB_HEIGHT;
						$this->image_lib->clear();
						$this->image_lib->initialize($config);
						$this->image_lib->resize();

						modules :: run('Admin/watermark/apply',$targetFile);

                        /* Add images name to database with respective car id */
						$this->Cars_model->addPhotos($id, $saveFile);

				}

			}
		}






// Upload car Images

		public function do_upload() {
				$this->load->model('Cars/cars_uploads_model');
				echo $this->cars_uploads_model->__car_images();
		}
// Delete car images

		public function deleteimg($file, $type) {
				if ($type == "slider") {
						@ unlink(PT_CARS_SLIDER_THUMB_UPLOAD . $file);
						@ unlink(PT_CARS_SLIDER_UPLOAD . $file);
				}
				$this->db->where('cimg_image', $file);
				$this->db->delete('pt_car_images');
				$js = array("files" => array(array($file => "true")));
				echo json_encode($js);
		}

		function translate($carslug, $lang = null) {
				$this->load->library('Cars/Cars_lib');
				$this->Cars_lib->set_carid($carslug);
				$add = $this->input->post('add');
				$update = $this->input->post('update');
				if (empty ($lang)) {
						$lang = $this->langdef;
				}
				else {
						$lang = $lang;
				}
				if (empty ($carslug)) {
						redirect($this->data['adminsegment'] . '/cars/');
				}
				if (!empty ($add)) {
						$language = $this->input->post('langname');
						$carid = $this->input->post('carid');
						$this->Cars_model->add_translation($language, $carid);
						redirect($this->data['adminsegment'] . "/cars/translate/" . $carslug . "/" . $language);
				}
				if (!empty ($update)) {
						$slug = $this->Cars_model->update_translation($lang, $carslug);
						redirect($this->data['adminsegment'] . "/cars/translate/" . $slug . "/" . $lang);
				}
				$cdata = $this->Cars_lib->car_details();
				if ($lang == $this->langdef) {
						$carsdata = $this->Cars_lib->car_short_details();
						$this->data['carsdata'] = $carsdata;
						$this->data['transpolicy'] = $carsdata[0]->car_policy;
						$this->data['transdesc'] = $carsdata[0]->car_desc;
						$this->data['transtitle'] = $carsdata[0]->car_title;
				}
				else {
						$carsdata = $this->Cars_lib->translated_data($lang);
						$this->data['carsdata'] = $carsdata;
						$this->data['transid'] = $carsdata[0]->trans_id;
						$this->data['transpolicy'] = $carsdata[0]->trans_policy;
						$this->data['transdesc'] = $carsdata[0]->trans_desc;
						$this->data['transtitle'] = $carsdata[0]->trans_title;
				}
				$this->data['carid'] = $this->Cars_lib->get_id();
				$this->data['lang'] = $lang;
				$this->data['slug'] = $carslug;
				$this->data['language_list'] = pt_get_languages();
				if ($this->data['adminsegment'] == "supplier") {
						if ($this->data['userloggedin'] != $cdata[0]->car_owned_by) {
								redirect($this->data['adminsegment'] . '/cars/');
						}
				}
				$this->data['main_content'] = 'Cars/translate';
				$this->data['page_title'] = 'Translate Car';
				$this->load->view('Admin/template', $this->data);
		}

		function LoadXcrudCarSettings($type) {
				$xc = "xcrud" . $type;
				$xc = xcrud_get_instance();
				$xc->table('pt_cars_types_settings');
				$xc->where('sett_type', $type);
				$xc->order_by('sett_id', 'desc');
				$xc->button('#sett{sett_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
				$delurl = base_url().'cars/carajaxcalls/delTypeSettings';
               	$xc->button("javascript: delfunc('{sett_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self','id' => '{sett_id}'));


                if($type == "ctypes"){
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

				$xc->multiDelUrl = base_url().'cars/carajaxcalls/delMultiTypeSettings/'.$type;

				$this->data['content' . $type] = $xc->render();
		}

		function extras(){


          if($this->data['adminsegment'] == "supplier"){

        $supplierCars = $this->Cars_model->all_cars($this->data['userloggedin']);
        $allcars = $this->Cars_model->all_cars();
         echo  modules :: run('Admin/extras/listings','cars',$allcars, $supplierCars);

		}else{

			$cars = $this->Cars_model->all_cars();
         echo  modules :: run('Admin/extras/listings','cars',$cars);

		}
        }

        function reviews(){

         echo  modules :: run('Admin/reviews/listings','cars');
        }

}
