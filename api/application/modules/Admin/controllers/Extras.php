<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Extras extends MX_Controller {
		public  $role;
		public  $accType;
		private $langdef;

		function __construct() {
				modules::load('Admin');
				$this->load->model('Admin/Extras_model');
				$this->data['adminsegment'] = "admin";
				$this->data['userloggedin'] = $this->session->userdata('pt_logged_id');
	        	//$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
	        	$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
   				$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
   				$this->role = $this->session->userdata('pt_role');
				$this->data['role'] = $this->role;
				$this->accType = $this->session->userdata('pt_accountType');
    
   	 			$this->data['modModel'] = $this->modules_model;
		}

		function listings($module,$items = null, $supplierItems = null){
		  if(!empty($items)){
              $this->data['itemslist'] = $items;
		  }
		  if(!empty($supplierItems)){
		  	$this->data['supplieritems'] = $supplierItems;
		  	 $this->data['itemslist'] = $supplierItems;
		  	 foreach($items as $i){
		  	 $onlyIDs[] = $i->id;	
		  	 }

		  	 foreach($supplierItems as $sid){
		  	 	$suppIDs[] = $sid->id;
		  	 }

		  	$otherItems = array_diff($onlyIDs, $suppIDs);

              $this->data['otherItems'] = implode(",",$otherItems);
		  }


/*		  foreach($items as $i){
		  	$supplierItems[] = $i->id; 
		  }

		  $itemsCombined = implode(",",$supplierItems);*/



		        $this->data['languages'] = pt_get_languages();

                $updateextra = $this->input->post('updateextra');
                $updateassign = $this->input->post('updateassign');
				$id = $this->input->post('extrasid');

				if (!empty ($updateextra)) {

                    $this->Extras_model->update_translation($this->input->post('translated'),$id);
				}

                if (!empty ($updateassign)) {
                      $this->Extras_model->update_extras($id);
				}
				if($module == "tours"){
				$imageUpload = PT_TOURS_EXTRAS_IMAGES_UPLOAD;	
				}elseif($module == "cars"){					
				$imageUpload = PT_CARS_EXTRAS_IMAGES_UPLOAD;
				}else{
				$imageUpload = PT_EXTRAS_IMAGES_UPLOAD;
				}

                $this->load->helper('xcrud');
				$xcrud = xcrud_get_instance();
				$xcrud->table('pt_extras');
				
				$xcrud->where('extras_module',$module);
				$xcrud->column_class('extras_image', 'zoom_img');
				$xcrud->order_by('pt_extras.extras_id', 'desc');
				$xcrud->limit(50);
				
				if($this->role == "supplier"){
				$xcrud->columns('extras_image,extras_title,extras_status,extras_basic_price,extras_for');
				$xcrud->unset_add();
				$xcrud->unset_edit();
				$xcrud->unset_remove();
				}else{
				$xcrud->columns('extras_image,extras_title,extras_status,extras_basic_price,extras_for,extras_discount');
				$xcrud->column_callback('extras_discount','translateExtras');
				}
				
				$xcrud->search_columns('extras_title,extras_status,extras_basic_price');
				$xcrud->fields('extras_image,extras_title,extras_status,extras_basic_price,extras_module');

				$xcrud->label('extras_image', 'Thumb')->label('extras_title', 'Name')->label('extras_added_on', 'Date')->label('extras_status', 'Status')->label('extras_basic_price', 'Price')->label('extras_desc', 'Description')->label('extras_discount','Translate')->label('extras_for','Assign');
				$xcrud->change_type('extras_image', 'image', false, array('width' => 200, 'path' => '../../'.$imageUpload, 'thumbs' => array(array('crop' => true, 'marker' => ''))));
				$xcrud->change_type('extras_module', 'hidden', $module); 
				
				$xcrud->column_callback('extras_for','assignExtras');

				$xcrud->after_insert('reloadPage');

				$this->data['content'] = $xcrud->render();
				$this->data['extras'] = $this->Extras_model->get_all_extras();
				$this->data['page_title'] = 'Extras Management';
				$this->data['main_content'] = 'extras_view';
                $this->data['table_name'] = 'pt_extras';
                $this->data['main_key'] = 'extras_id';
				$this->data['header_title'] = 'Extras Management';
				$this->load->view('Admin/template', $this->data);
        }

		

}