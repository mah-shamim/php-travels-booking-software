<?php

class Cars_model extends CI_Model {
		public $langdef;

		function __construct() {
// Call the Model constructor
				parent :: __construct();
				$this->langdef = DEFLANG;
		}

// Get all enabled cars short info
		function shortInfo($id = null) {
				$result = array();
				$this->db->select('car_id,car_title,car_slug');
				if (!empty ($id)) {
						$this->db->where('car_owned_by', $id);
				}
				$this->db->where('car_status', 'Yes');
				$this->db->order_by('car_id', 'desc');
				$cars = $this->db->get('pt_cars')->result();
				foreach($cars as $car){
					$result[] = (object)array('id' => $car->car_id, 'title' => $car->car_title, 'slug' => $car->car_slug);
				}

				return $result;
		}

		// Get all cars for extras
		function all_cars($id = null) {
				$this->db->select('car_id as id,car_title as title');
				if (!empty ($id)) {
						$this->db->where('car_owned_by', $id);
				}
				$this->db->order_by('car_id', 'desc');
				return $this->db->get('pt_cars')->result();
		}

// Get all cars id and names only
		function all_cars_names($id = null) {
				$this->db->select('car_id,car_title');
				if (!empty ($id)) {
						$this->db->where('car_owned_by', $id);
				}
				$this->db->order_by('car_id', 'desc');
				return $this->db->get('pt_cars')->result();
		}

// get latest cars
		function latest_cars_front() {
				$settings = $this->Settings_model->get_front_settings('cars');
				$limit = $settings[0]->front_latest;
				$this->db->select('pt_cars.car_status,pt_cars.car_basic_price,pt_cars.car_basic_discount,pt_cars.car_id,pt_cars.car_desc,pt_cars.car_stars,pt_cars.car_title,pt_cars.car_slug,pt_cars.car_city,pt_cars.car_type,pt_cars_types_settings.sett_name');
				$this->db->order_by('pt_cars.car_id', 'desc');
				$this->db->where('pt_cars.car_status', '1');
				$this->db->join('pt_cars_types_settings', 'pt_cars.car_type = pt_cars_types_settings.sett_id', 'left');
				$this->db->limit($limit);
				return $this->db->get('pt_cars')->result();
		}

// get all data of single car by slug
		function get_car_data($carname) {
				$this->db->select('pt_cars.*');
				$this->db->where('pt_cars.car_slug', $carname);
/* $this->db->where('pt_car_images.cimg_type','default');
$this->db->join('pt_car_images','pt_cars.car_id = pt_car_images.cimg_car_id','left');*/
				return $this->db->get('pt_cars')->result();
		}

// get all cars info
		function get_all_cars_back($id = null) {
				$this->db->select('pt_cars.car_featured_forever,pt_cars.car_stars,pt_cars.car_id,pt_cars.car_title,pt_cars.car_slug,pt_cars.car_owned_by,pt_cars.car_order,pt_cars.car_status,pt_cars.car_is_featured,
    pt_cars.car_featured_from,pt_cars.car_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_cars.car_basic_price');
// $this->db->where('pt_car_images.cimg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_cars.car_owned_by', $id);
				}
				$this->db->order_by('pt_cars.car_id', 'desc');
				$this->db->join('pt_accounts', 'pt_cars.car_owned_by = pt_accounts.accounts_id', 'left');
//$this->db->join('pt_car_images','pt_cars.car_id = pt_car_images.cimg_car_id','left');
//  $this->db->join('pt_cars_types_settings','pt_cars.car_type = pt_cars_types_settings.sett_id','left');
				$query = $this->db->get('pt_cars');
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all cars info with limit
		function get_all_cars_back_limit($id = null, $perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_cars.car_featured_forever,pt_cars.car_id,pt_cars.car_stars,pt_cars.car_title,pt_cars.car_slug,pt_cars.car_created_at,pt_cars.car_owned_by,pt_cars.car_order,pt_cars.car_status,pt_cars.car_is_featured,
    pt_cars.car_featured_from,pt_cars.car_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_cars.car_address,pt_cars.car_basic_price');
// $this->db->where('pt_car_images.cimg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_cars.car_owned_by', $id);
				}
				$this->db->order_by('pt_cars.car_id', 'desc');
				$this->db->join('pt_accounts', 'pt_cars.car_owned_by = pt_accounts.accounts_id', 'left');
//  $this->db->join('pt_car_images','pt_cars.car_id = pt_car_images.cimg_car_id','left');
//   $this->db->join('pt_cars_types_settings','pt_cars.car_type = pt_cars_types_settings.sett_id','left');
				$query = $this->db->get('pt_cars', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// add car data
		function add_car($user = null) {
			if(empty($user)){
				$user = 1;
			}

				$depval = floatval($this->input->post('depositvalue'));
                $deptype = $this->input->post('deposittype');

                $taxval = floatval($this->input->post('taxvalue'));
                $taxtype = $this->input->post('taxtype');

                $commper = 0;
                $commfixed = 0;
                $taxper = 0;
                $taxfixed = 0;
                if($deptype == "fixed"){
                 $commfixed = $depval;
                 $commper = 0;
                }else{
                 $commfixed = 0;
                 $commper = $depval;
                }

                if($taxtype == "fixed"){
                 $taxfixed = $taxval;
                 $taxper = 0;
                }else{
                 $taxfixed = 0;
                 $taxper = $taxval;
                }



				$this->db->select("car_id");
				$this->db->order_by("car_id", "desc");
				$query = $this->db->get('pt_cars');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$carlastid = 1;
				}
				else {
						$carlastid = $lastid[0]->car_id + 1;
				}
				$carcount = $query->num_rows();
				$carorder = $carcount + 1;
				$this->db->select("car_id");
				$this->db->where("car_title", $this->input->post('carname'));
				$queryc = $this->db->get('pt_cars')->num_rows();
				if ($queryc > 0) {
						$carslug = create_url_slug($this->input->post('carname')) . "-" . $carlastid;
				}
				else {
						$carslug = create_url_slug($this->input->post('carname'));
				}



				$featured = $this->input->post('isfeatured');

				if(empty($featured)){
					$featured = "no";
				}



                $ffrom = $this->input->post('ffrom');
				$fto = $this->input->post('fto');
				if(empty($ffrom) || empty($fto) && $featured == "yes" ){

                    $isforever = 'forever';

				}else{

				  	$isforever = '';
				}

				if($featured == "no"){
					$isforever = '';
				}

                $paymentopt =  @implode(",",$this->input->post('carpayments'));
				$relatedcars = @implode(",", $this->input->post('relatedcars'));
				$stars = $this->input->post('carstars');
				if(empty($stars)){
					$stars = 1;
				}



				$data = array('car_title' => $this->input->post('carname'), 'car_slug' => $carslug,
				'car_desc' => $this->input->post('cardesc'),
				'car_stars' => intval($stars),
				'car_is_featured' => $featured,
				'car_featured_from' => convert_to_unix($ffrom),
				'car_featured_to' => convert_to_unix($fto),
				'car_owned_by' => $user,
				'car_type' => $this->input->post('cartype'),
				'car_doors' => intval($this->input->post('doors')),
				'car_transmission' => $this->input->post('transmission'),
				'car_baggage' => $this->input->post('baggage'),
				'car_airport_pickup' => $this->input->post('airportpickup'),
				'car_cancel_anytime' => $this->input->post('cancel'),
				'car_free_amend' => $this->input->post('amend'),
				'car_unlimited_mile' => $this->input->post('mile'),
				'car_passengers' => intval($this->input->post('passangers')),
				'car_basic_price' => 1, //$this->input->post('carbasic'),
				//'car_basic_discount' => $this->input->post('cardiscount'),
				'car_meta_title' => $this->input->post('carmetatitle'),
				'car_meta_keywords' => $this->input->post('carkeywords'),
				'car_meta_desc' => $this->input->post('carmetadesc'),
				'car_policy' => $this->input->post('carpolicy'),
				//'car_address' => $this->input->post('address'),
				//'car_location' => $this->input->post('location'),
				//'car_country' => $this->input->post('country'),
				//'car_city_address' => $this->input->post('city'),
				//'car_mapaddress' => $this->input->post('carmapaddress'),
				//'car_city' => $this->input->post('carcity'),
				//'car_zip' => $this->input->post('zip'),
				//'car_longitude' => $this->input->post('longitude'),
				//'car_latitude' => $this->input->post('latitude'),
                'car_payment_opt' => $paymentopt,
				'car_status' => $this->input->post('carstatus'),
				'car_related' => $relatedcars,
				'car_order' => $carorder,
                'car_comm_fixed' => $commfixed,
				'car_comm_percentage' => $commper,
			    'car_tax_fixed' => $this->input->post('fixtax'),
				'car_tax_percentage' => $this->input->post('pertax'),
				'car_email' => $this->input->post('caremail'),
				'car_featured_forever' => $isforever,
				'car_created_at' => time());
				$this->db->insert('pt_cars', $data);

				$carid = $this->db->insert_id();

				return $carid;
		}

// update car data
		function update_car($id) {

		    	$carcomm = $this->input->post('deposit');
                $depval = floatval($this->input->post('depositvalue'));
                $deptype = $this->input->post('deposittype');

                $taxval = floatval($this->input->post('taxvalue'));
                $taxtype = $this->input->post('taxtype');

                $commper = 0;
                $commfixed = 0;
                $taxper = 0;
                $taxfixed = 0;
                if($deptype == "fixed"){
                 $commfixed = $depval;
                 $commper = 0;
                }else{
                 $commfixed = 0;
                 $commper = $depval;
                }

                if($taxtype == "fixed"){
                 $taxfixed = $taxval;
                 $taxper = 0;
                }else{
                 $taxfixed = 0;
                 $taxper = $taxval;
                }


				$this->db->select("car_id");
				$this->db->where("car_id !=", $id);
				$this->db->where("car_title", $this->input->post('carname'));
				$queryc = $this->db->get('pt_cars')->num_rows();
				if ($queryc > 0) {
						$carslug = create_url_slug($this->input->post('carname')) . "-" . $id;
				}
				else {
						$carslug = create_url_slug($this->input->post('carname'));
				}

				$paymentopt = @ implode(",", $this->input->post('carpayments'));
				$relatedcars = @ implode(",", $this->input->post('relatedcars'));

				$featured = $this->input->post('isfeatured');

				if(empty($featured)){
					$featured = "no";
				}

                $ffrom = $this->input->post('ffrom');
				$fto = $this->input->post('fto');
				if(empty($ffrom) || empty($fto) && $featured == "yes" ){

                    $isforever = 'forever';

				}else{

				  	$isforever = '';
				}

				if($featured == "no"){
					$isforever = '';
				}

				$stars = $this->input->post('carstars');
				if(empty($stars)){
					$stars = 1;
				}


				$data = array('car_title' => $this->input->post('carname'), 'car_slug' => $carslug,
				'car_desc' => $this->input->post('cardesc'),
				'car_stars' => intval($stars),
				'car_is_featured' => $featured,
				'car_featured_from' => convert_to_unix($ffrom),
				'car_featured_to' => convert_to_unix($fto),
				'car_type' => $this->input->post('cartype'),
				'car_doors' => intval($this->input->post('doors')),
				'car_transmission' => $this->input->post('transmission'),
				'car_baggage' => $this->input->post('baggage'),
				'car_airport_pickup' => $this->input->post('airportpickup'),
				'car_cancel_anytime' => $this->input->post('cancel'),
				'car_free_amend' => $this->input->post('amend'),
				'car_unlimited_mile' => $this->input->post('mile'),
				'car_passengers' => intval($this->input->post('passangers')),
				'car_basic_price' => 1, //$this->input->post('carbasic'),
				//'car_basic_discount' => $this->input->post('cardiscount'),
				'car_meta_title' => $this->input->post('carmetatitle'),
				'car_meta_keywords' => $this->input->post('carkeywords'),
				'car_meta_desc' => $this->input->post('carmetadesc'),
				'car_policy' => $this->input->post('carpolicy'),
				//'car_address' => $this->input->post('address'),
				//'car_location' => $this->input->post('location'),
				//'car_country' => $this->input->post('country'),
				//'car_city_address' => $this->input->post('city'),
				//'car_mapaddress' => $this->input->post('carmapaddress'),
				//'car_city' => $this->input->post('carcity'),
				//'car_zip' => $this->input->post('zip'),
				//'car_longitude' => $this->input->post('longitude'),
				//'car_latitude' => $this->input->post('latitude'),
                'car_payment_opt' => $paymentopt,
				'car_status' => $this->input->post('carstatus'),
				'car_related' => $relatedcars,
                'car_comm_fixed' => $commfixed,
				'car_comm_percentage' => $commper,
			    'car_tax_fixed' => $taxfixed,
				'car_tax_percentage' => $taxper,
				'car_email' => $this->input->post('caremail'),
				'car_featured_forever' => $isforever);

				$this->db->where('car_id', $id);
				$this->db->update('pt_cars', $data);

		}

// Add car settings data
		function add_settings_data() {
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'), 'sett_type' => $this->input->post('typeopt'));
				$this->db->insert('pt_cars_types_settings', $data);
		}

// update car settings data
		function update_settings_data() {
				$id = $this->input->post('id');
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'));
				$this->db->where('sett_id', $id);
				$this->db->update('pt_cars_types_settings', $data);
		}

// Disable car settings
		function disable_settings($id) {
				$data = array('sett_status' => 'No');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_cars_types_settings', $data);
		}

// Enable car settings
		function enable_settings($id) {
				$data = array('sett_status' => 'Yes');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_cars_types_settings', $data);
		}

// Delete car settings
		function delete_settings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_cars_types_settings');

				$this->db->where('sett_id', $id);
				$this->db->delete('pt_cars_types_settings_translation');
		}

// Delete multiple car settings
		function deleteMultiplesettings($id, $type) {
				$this->db->where('sett_id', $id);
				$this->db->where('sett_type',$type);
				$this->db->delete('pt_cars_types_settings');

				$rowsDeleted = $this->db->affected_rows();

				if($rowsDeleted > 0){
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_cars_types_settings_translation');
				}


		}

// get all cars for related selection for backend
		function select_related_cars($id = null) {
				$this->db->select('car_title,car_id');
				if (!empty ($id)) {
						$this->db->where('car_id !=', $id);
				}
				return $this->db->get('pt_cars')->result();
		}

// Get car settings data
		function get_car_settings_data($type = 0) {
				if(!empty($type)){
             	$this->db->where('sett_type', $type);
		  }

				$this->db->order_by('sett_id', 'desc');
				return $this->db->get('pt_cars_types_settings')->result();
		}

// Get car settings data for adding car
		function get_csettings_data($type) {
				$this->db->where('sett_type', $type);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_cars_types_settings')->result();
		}

// Get car settings data for adding car
		function get_tsettings_data_front($type, $items) {
				$this->db->where('sett_type', $type);
				$this->db->where_in('sett_id', $items);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_cars_types_settings')->result();
		}

// add car images by type
		function add_car_image($type, $filename, $carid) {
				$imgorder = 0;
				if ($type == "slider") {
						$this->db->where('cimg_type', 'slider');
						$this->db->where('cimg_car_id', $carid);
						$imgorder = $this->db->get('pt_car_images')->num_rows();
						$imgorder = $imgorder + 1;
				}
				$this->db->where('cimg_type', 'default');
				$this->db->where('cimg_car_id', $carid);
				$hasdefault = $this->db->get('pt_car_images')->num_rows();
				if ($hasdefault < 1) {
						$type = 'default';
				}
				$approval = pt_admin_gallery_approve();
				$data = array('cimg_car_id' => $carid, 'cimg_type' => $type, 'cimg_image' => $filename, 'cimg_order' => $imgorder, 'cimg_approved' => $approval);
				$this->db->insert('pt_car_images', $data);
		}

// update car image by type
		function update_car_image($type, $filename, $carid) {
				$data = array('cimg_image' => $filename);
				$this->db->where("cimg_type", $type);
				$this->db->where("cimg_car_id", $carid);
				$this->db->update('pt_car_images', $data);
		}

// get all cars info  by search
		function search_all_cars_back_limit($term, $id = null, $perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_cars.car_featured_forever,pt_cars.car_id,pt_cars.car_stars,pt_cars.car_title,pt_cars.car_slug,pt_cars.car_created_at,pt_cars.car_owned_by,pt_cars.car_order,pt_cars.car_status,pt_cars.car_is_featured,
    pt_cars.car_featured_from,pt_cars.car_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_cars_types_settings.sett_name');
//  $this->db->where('pt_car_images.cimg_type','default');
				$this->db->like('pt_cars.car_title', $term);
				$this->db->or_like('pt_accounts.ai_first_name', $term);
				$this->db->or_like('pt_accounts.ai_last_name', $term);
				if (!empty ($id)) {
						$this->db->where('pt_cars.car_owned_by', $id);
				}
				$this->db->order_by('pt_cars.car_id', 'desc');
				$this->db->join('pt_accounts', 'pt_cars.car_owned_by = pt_accounts.accounts_id', 'left');
//   $this->db->join('pt_car_images','pt_cars.car_id = pt_car_images.cimg_car_id','left');
				$this->db->join('pt_cars_types_settings', 'pt_cars.car_type = pt_cars_types_settings.sett_id', 'left');
				$query = $this->db->get('pt_cars', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all cars info  by advance search
		function adv_search_all_cars_back_limit($data, $id = null, $perpage = null, $offset = null, $orderby = null) {
				$price = $data["price"];
				$stars = $data["stars"];
				$ownedby = $data["ownedby"];
				$status = $data["status"];
				$cartitle = $data["cartitle"];
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_cars.car_featured_forever,pt_cars.car_id,pt_cars.car_basic_price,pt_cars.car_stars,pt_cars.car_title,pt_cars.car_slug,pt_cars.car_created_at,pt_cars.car_owned_by,pt_cars.car_order,pt_cars.car_status,pt_cars.car_is_featured,
    pt_cars.car_featured_from,pt_cars.car_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_cars_types_settings.sett_name');
				if (!empty ($id)) {
						$this->db->where('pt_cars.car_owned_by', $id);
				}
				if (!empty ($ownedby)) {
						$this->db->where('pt_cars.car_owned_by', $ownedby);
				}
				if (!empty ($cartitle)) {
						$this->db->like('pt_cars.car_title', $cartitle);
				}
				if (!empty ($price)) {
						$this->db->like('pt_cars.car_basic_price', $price);
				}
				if (!empty ($stars)) {
						$this->db->like('pt_cars.car_stars', $stars);
				}
				$this->db->where('car_status', $status);
				$this->db->order_by('pt_cars.car_id', 'desc');
				$this->db->join('pt_accounts', 'pt_cars.car_owned_by = pt_accounts.accounts_id', 'left');
				$this->db->join('pt_cars_types_settings', 'pt_cars.car_type = pt_cars_types_settings.sett_id', 'left');
				$query = $this->db->get('pt_cars', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// update car map order
		function update_map_order($id, $order) {
				$data = array('map_order' => $order);
				$this->db->where('map_id', $id);
				$this->db->update('pt_cars_maps', $data);
		}

// update car order
		function update_car_order($id, $order) {
				$data = array('car_order' => $order);
				$this->db->where('car_id', $id);
				$this->db->update('pt_cars', $data);
		}

// update featured status
		function update_featured() {
				$isfeatured = $this->input->post('isfeatured');
                $id = $this->input->post('id');

                if($isfeatured == "no"){
					$isforever = '';
				}else{

				$isforever = "forever";

				}

			 $data = array('car_is_featured' => $isfeatured, 'car_featured_forever' => $isforever);
				$this->db->where('car_id', $id);
				$this->db->update('pt_cars', $data);
		}
// Disable car

		public function disable_car($id) {
				$data = array('car_status' => '0');
				$this->db->where('car_id', $id);
				$this->db->update('pt_cars', $data);
		}
// Enable car

		public function enable_car($id) {
				$data = array('car_status' => '1');
				$this->db->where('car_id', $id);
				$this->db->update('pt_cars', $data);
		}

// Delete car
		function delete_car($carid) {
				$carimages = $this->car_images($carid);
				foreach ($carimages['all_slider'] as $sliderimg) {
						$this->delete_image($sliderimg->cimg_image, 'slider', $sliderimg->cimg_id);
				}



				$this->db->where('review_itemid', $carid);
				$this->db->where('review_module', 'cars');
				$this->db->delete('pt_reviews');

				$this->db->where('item_id', $carid);
                $this->db->delete('pt_cars_translation');

                $this->db->where('car_id',$carid);
            	$this->db->delete('pt_car_locations');

				$this->db->where('car_id', $carid);
				$this->db->delete('pt_cars');
		}





		 function carGallery($slug){

          $this->db->select('pt_cars.thumbnail_image as thumbnail,pt_car_images.cimg_id as id,pt_car_images.cimg_car_id as itemid,pt_car_images.cimg_type as type,pt_car_images.cimg_image as image,pt_car_images.cimg_order as imgorder,pt_car_images.cimg_image as image,pt_car_images.cimg_approved as approved');
          $this->db->where('pt_cars.car_slug',$slug);
          $this->db->join('pt_car_images', 'pt_cars.car_id = pt_car_images.cimg_car_id', 'left');
          $this->db->order_by('pt_car_images.cimg_id','desc');
          return $this->db->get('pt_cars')->result();

        }

// Get car Images
		function car_images($id) {
				$this->db->where('cimg_car_id', $id);
				$this->db->where('cimg_type', 'default');
				$q = $this->db->get('pt_car_images');
				$data['def_image'] = $q->result();
				$this->db->where('cimg_type', 'slider');
				$this->db->order_by('cimg_id', 'desc');
				$this->db->having('cimg_car_id', $id);
				$q = $this->db->get('pt_car_images');
				$data['all_slider'] = $q->result();
				$data['slider_counts'] = $q->num_rows();
				return $data;

		}

//update car thumbnail
		function update_thumb($oldthumb, $newthumb, $carid) {
				$data = array('cimg_type' => 'slider');
				$this->db->where('cimg_id', $oldthumb);
				$this->db->where('cimg_car_id', $carid);
				$this->db->update('pt_car_images', $data);
				$data2 = array('cimg_type' => 'default');
				$this->db->where('cimg_id', $newthumb);
				$this->db->where('cimg_car_id', $carid);
				$this->db->update('pt_car_images', $data2);
		}

// Approve or reject Hotel Images
		function approve_reject_images() {
				$data = array('cimg_approved' => $this->input->post('apprej'));
				$this->db->where('cimg_id', $this->input->post('imgid'));
				$this->db->update('pt_car_images', $data);
		}

// update image order
		function update_image_order($imgid, $order) {
				$data = array('cimg_order' => $order);
				$this->db->where('cimg_id', $imgid);
				$this->db->update('pt_car_images', $data);
		}


// Delete car Images
		function delete_image($imgname, $imgid, $carid) {
				$this->db->where('cimg_id', $imgid);
				$this->db->delete('pt_car_images');
				$this->updateCarThumb($carid,$imgname,"delete");
				@ unlink(PT_CARS_SLIDER_THUMB_UPLOAD . $imgname);
			    @ unlink(PT_CARS_SLIDER_UPLOAD . $imgname);

		}

//update car thumbnail
		function updateCarThumb($carid,$imgname,$action) {
		  if($action == "delete"){
            $this->db->select('thumbnail_image');
            $this->db->where('thumbnail_image',$imgname);
            $this->db->where('car_id',$carid);
            $rs = $this->db->get('pt_cars')->num_rows();
            if($rs > 0){
              $data = array(
              'thumbnail_image' => PT_BLANK_IMG
              );
              $this->db->where('car_id',$carid);
              $this->db->update('pt_cars',$data);
            }

            }else{
              $data = array(
              'thumbnail_image' => $imgname
              );
              $this->db->where('car_id',$carid);
              $this->db->update('pt_cars',$data);
            }

		}



		function add_to_map() {
				$maporder = 0;
				$carid = $this->input->post('carid');
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_car_id', $carid);
				$res = $this->db->get('pt_cars_maps')->num_rows();
				$addtype = $this->input->post('addtype');
				if ($addtype == "visit") {
						$maporder = $res + 1;
				}
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'), 'map_city_type' => $addtype, 'map_car_id' => $carid, 'map_order' => $maporder);
				$this->db->insert('pt_cars_maps', $data);
		}

		function update_car_map() {
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'),);
				$this->db->where('map_id', $this->input->post('mapid'));
				$this->db->update('pt_cars_maps', $data);
		}

		function has_start_end_city($type, $carid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', $type);
				$this->db->where('map_car_id', $carid);
				$nums = $this->db->get('pt_cars_maps')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// get data of single ar by id for maps
		function car_data_for_map($id) {
				$this->db->select('pt_cars.car_id,pt_cars.car_title,pt_cars.car_slug');
				$this->db->where('pt_cars.car_id', $id);
/*$this->db->where('pt_hotel_images.himg_type','default');
$this->db->where('pt_hotel_images.himg_approved','1');
$this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');*/
				return $this->db->get('pt_cars')->result();
		}

// get related cars for front-end
		function get_related_cars($cars) {
				$id = explode(",", $cars);
				$this->db->select('pt_cars.car_title,pt_cars.car_type,pt_cars.car_slug,pt_cars.car_stars,pt_cars.car_id,pt_cars.car_basic_price,pt_cars.car_basic_discount,pt_cars_types_settings.sett_name');
				$this->db->where_in('pt_cars.car_id', $id);
/*  $this->db->where('pt_car_images.cimg_type','default');
$this->db->join('pt_car_images','pt_cars.car_id = pt_car_images.cimg_car_id','left');*/
				$this->db->join('pt_cars_types_settings', 'pt_cars.car_type = pt_cars_types_settings.sett_id', 'left');
				return $this->db->get('pt_cars')->result();
		}

// Check car existence
		function car_exists($slug) {
				$this->db->select('car_id');
				$this->db->where('car_slug', $slug);
				$this->db->where('car_status', 'Yes');
				$nums = $this->db->get('pt_cars')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// List all cars on front listings page
		function list_cars_front($perpage = null, $offset = null, $orderby = null) {
				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}

				if ($orderby == "za") {
						$this->db->order_by('pt_cars.car_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_cars.car_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_cars.car_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_cars.car_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_cars.car_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_cars.car_basic_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_cars.car_basic_price', 'desc');
				}
				elseif ($orderby == "s_lh") {
						$this->db->order_by('pt_cars.car_stars', 'asc');
				}
				elseif ($orderby == "s_hl") {
						$this->db->order_by('pt_cars.car_stars', 'desc');
				}
				$this->db->group_by('pt_cars.car_id');
				$this->db->where('pt_cars.car_status', 'Yes');
                $this->db->join('pt_accounts', 'pt_accounts.accounts_id = pt_cars.car_owned_by');
				$query = $this->db->get('pt_cars', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// List all cars on front listings page based on locations
		function listCarsByLocation($locs, $perpage = null, $offset = null, $orderby = null) {
				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}

				if ($orderby == "za") {
						$this->db->order_by('pt_cars.car_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_cars.car_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_cars.car_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_cars.car_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_cars.car_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_cars.car_basic_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_cars.car_basic_price', 'desc');
				}
				elseif ($orderby == "s_lh") {
						$this->db->order_by('pt_cars.car_stars', 'asc');
				}
				elseif ($orderby == "s_hl") {
						$this->db->order_by('pt_cars.car_stars', 'desc');
				}
				$this->db->group_by('pt_cars.car_id');

				if(is_array($locs)){
                $this->db->where_in('pt_cars.car_city',$locs);
                }else{
                $this->db->where('pt_cars.car_city',$locs);
                }

				$this->db->where('pt_cars.car_status', 'Yes');
				$query = $this->db->get('pt_cars', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// Search cars from home page
		function search_cars_front($location = null, $sprice = null, $perpage = null, $offset = null, $orderby = null, $cities = null) {
				$this->load->helper('cars_front');
				$data = array();
				$airportpickup = $this->input->get('pickup');
				$stars = $this->input->get('stars');
				$endloc = $this->input->get('dcity');
				$start = $this->input->get('start');
				$end = $this->input->get('end');
				$days = $this->input->get('days');
				$passengers = $this->input->get('passengers');
				$doors = $this->input->get('doors');
				$ptype = $this->input->get('ptype');
				$type = $this->input->get('type');
				$ctype = $this->input->get('ctype');
				$category = $this->input->get('category');
				//$sprice = $this->input->get('price');
				$pickupLocation = $this->input->get('pickupLocation');
				$dropoffLocation = $this->input->get('dropoffLocation');
//$days = pt_count_days($checkin,$checkout);
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}

				if ($orderby == "za") {
						$this->db->order_by('pt_cars.car_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_cars.car_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_cars.car_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_cars.car_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_cars.car_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_cars.car_basic_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_cars.car_basic_price', 'desc');
				}
				if (!empty ($days)) {
						$this->db->where('pt_cars.car_days', $days);
				}
				if (!empty ($passengers)) {
						$this->db->where('pt_cars.car_passengers', $passengers);
				}

				if (!empty ($stars)) {
						$this->db->where('pt_cars.car_stars', $stars);
				}
				if (!empty ($type)) {
						$this->db->where_in('pt_cars.car_type', $type);
				}

				if (!empty ($sprice)) {

						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_car_locations.price >=', $minp);
						$this->db->where('pt_car_locations.price <=', $maxp);
						$this->db->join('pt_car_locations', 'pt_cars.car_id = pt_car_locations.car_id', 'left');
				}
				if (!empty ($doors)) {
						$this->db->where_in('pt_cars.car_doors', $doors);
				}
				if(!empty($airportpickup)){
				$this->db->where('pt_cars.car_airport_pickup', $airportpickup);
				}

				if(!empty($location)){
					$this->db->like('pt_cars.car_location', $location);
				}

				$this->db->group_by('pt_cars.car_id');
				$this->db->where('pt_cars.car_status', 'Yes');

				if(!empty($pickupLocation) && !empty($dropoffLocation)){


					$this->db->where('pt_car_locations.pickup_location_id', $pickupLocation);
					$this->db->where('pt_car_locations.dropoff_location_id', $dropoffLocation);
					$this->db->join('pt_car_locations', 'pt_cars.car_id = pt_car_locations.car_id', 'left');
				}

				if(!empty($perpage)){

				$query = $this->db->get('pt_cars', $perpage, $offset);

				}else{

				$query = $this->db->get('pt_cars');

				}



				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// Search Cars By text
		function search_cars_by_text($perpage = null, $offset = null, $orderby = null, $cities = null) {
				$data = array();
				$txtsearch = $this->input->get('searching');
				$checkin = $this->input->get('checkin');
				$checkout = $this->input->get('checkout');
				$adult = $this->input->get('adults');
				$child = $this->input->get('child');
				$stars = $this->input->get('stars');
				$passengers = $this->input->get('passengers');
				$doors = $this->input->get('doors');
				$days = pt_count_days($checkin, $checkout);
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_cars.*');
//  $this->db->select_avg('pt_reviews.review_overall','overall');
				$this->db->group_by('pt_cars.car_id');
//  $this->db->join('pt_reviews','pt_cars.car_id = pt_reviews.review_itemid','left');
				$this->db->like('pt_cars.car_title', $txtsearch);
				if ($orderby == "za") {
						$this->db->order_by('pt_cars.car_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_cars.car_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_cars.car_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_cars.car_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_cars.car_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_cars.car_basic_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_cars.car_basic_price', 'desc');
				}
				elseif ($orderby == "s_lh") {
						$this->db->order_by('pt_cars.car_stars', 'asc');
				}
				elseif ($orderby == "s_hl") {
						$this->db->order_by('pt_cars.car_stars', 'desc');
				}
				if (!empty ($stars)) {
						$this->db->where('pt_cars.car_stars', $stars);
				}
				if (!empty ($doors)) {
						$this->db->where_in('pt_cars.car_doors', $doors);
				}
				if (!empty ($passengers)) {
						$this->db->where('pt_cars.car_passengers', $passengers);
				}
				$this->db->where('pt_cars.car_status', '1');
				$query = $this->db->get('pt_cars', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// get default image of car
		function default_car_img($id) {
				$this->db->where('cimg_type', 'default');
				$this->db->where('cimg_approved', '1');
				$this->db->where('cimg_car_id', $id);
				$res = $this->db->get('pt_car_images')->result();
				if (!empty ($res)) {
						return $res[0]->cimg_image;
				}
				else {
						return '';
				}
		}

		 function addPhotos($id,$filename){

         $this->db->select('thumbnail_image');
         $this->db->where('car_id',$id);
         $rs = $this->db->get('pt_cars')->result();
         if($rs[0]->thumbnail_image == PT_BLANK_IMG){

               $data = array('thumbnail_image' => $filename);
               $this->db->where('car_id',$id);
               $this->db->update('pt_cars',$data);
         }

        //add photos to car images table
        $imgorder = 0;
        $this->db->where('cimg_type', 'slider');
        $this->db->where('cimg_car_id', $id);
        $imgorder = $this->db->get('pt_car_images')->num_rows();
        $imgorder = $imgorder + 1;

				$approval = pt_admin_gallery_approve();

		    	$insdata = array(
                'cimg_car_id' => $id,
                'cimg_type' => 'slider',
                'cimg_image' => $filename,
                'cimg_order' => $imgorder,
                'cimg_approved' => $approval
                );

				$this->db->insert('pt_car_images', $insdata);


        }

        function assignCars($cars,$userid){

          if(!empty($cars)){
          $usercars = $this->userOwnedCars($userid);
                foreach($usercars as $cc){
                   if(!in_array($cc,$cars)){
                    $ddata = array(
                   'car_owned_by' => '1'
                   );
                   $this->db->where('car_id',$cc);
                   $this->db->update('pt_cars',$ddata);
                   }
                }

                foreach($cars as $c){
                   $data = array(
                   'car_owned_by' => $userid
                   );
                   $this->db->where('car_id',$c);
                   $this->db->update('pt_cars',$data);

                 }

                 }
        }

        function userOwnedCars($id){
          $result = array();
          if(!empty($id)){
          $this->db->where('car_owned_by',$id);
          }

          $rs = $this->db->get('pt_cars')->result();
          if(!empty($rs)){
            foreach($rs as $r){
              $result[] = $r->car_id;
            }
          }
          return $result;
        }

		 // get number of photos of car
		function photos_count($carid) {
				$this->db->where('cimg_car_id', $carid);
				return $this->db->get('pt_car_images')->num_rows();
		}

// Advanced Price info of a car
		function get_car_adv_price($id) {
				$data = array();
				$today = time();
				$this->db->where('cp_car_id', $id);
				$this->db->where('cp_from <=', $today);
				$this->db->where('cp_to >=', $today);
				$query = $this->db->get('pt_car_aprice')->result();
				if (!empty ($query)) {
						$data['basic'] = $query[0]->hp_basic;
						$data['discount'] = $query[0]->hp_discount;
				}
				return $data;
		}

// Add Unavailability Info of car
		function add_unavail_car() {
				$unavailfrom = $this->input->post('unavailfrom');
				$unavailto = $this->input->post('unavailto');
				$data = array('cun_car_id' => $this->input->post('carid'), 'cun_from' => convert_to_unix($unavailfrom), 'cun_to' => convert_to_unix($unavailto));
				$this->db->insert('pt_car_unavailability', $data);
		}

// Get Unavailabity data of hotel
		function get_car_unavail($id) {
				$this->db->where('cun_car_id', $id);
				$this->db->order_by('cun_id', 'desc');
				return $this->db->get('pt_car_unavailability')->result();
		}

// Update Unavailabilty of car
		function update_unavail_car() {
				$ufrom = $this->input->post('unavailfrom');
				$uto = $this->input->post('unavailto');
				$data = array('cun_from' => convert_to_unix($ufrom), 'cun_to' => convert_to_unix($uto));
				$this->db->where('cun_id', $this->input->post('unavailid'));
				$this->db->update('pt_car_unavailability', $data);
		}

// Delete Unavailabilty of car
		function delete_unavail($id) {
				$this->db->where('cun_id', $id);
				$this->db->delete('pt_car_unavailability');
		}

// make car unavailable if matches today's date
// Add advanced car price
		function add_aprice() {
				$apfrom = $this->input->post('pricefrom');
				$apto = $this->input->post('priceto');
				$data = array('cp_car_id' => $this->input->post('carid'), 'cp_basic' => $this->input->post('basicprice'), 'cp_discount' => $this->input->post('discountprice'), 'cp_from' => convert_to_unix($apfrom), 'cp_to' => convert_to_unix($apto));
				$this->db->insert('pt_car_aprice', $data);
		}

// Get advanced car price
		function get_all_aprice($id) {
				$this->db->where('cp_car_id', $id);
				$this->db->order_by('cp_id', 'desc');
				return $this->db->get('pt_car_aprice')->result();
		}

// Update advanced car price
		function update_aprice() {
				$apfrom = $this->input->post('pricefrom');
				$apto = $this->input->post('priceto');
				$data = array('cp_basic' => $this->input->post('basicprice'), 'cp_discount' => $this->input->post('discountprice'), 'cp_from' => convert_to_unix($apfrom), 'cp_to' => convert_to_unix($apto));
				$this->db->where('cp_id', $this->input->post('priceid'));
				$this->db->update('pt_car_aprice', $data);
		}

// Delete Advanced Price
		function delete_prices($id) {
				$this->db->where('cp_id', $id);
				$this->db->delete('pt_car_aprice');
		}

// is car available or not
		function car_is_available($id) {
				$result = true;
				$this->db->select('cun_status');
				$this->db->where('cun_car_id', $id);
				$res = $this->db->get('pt_car_unavailability')->result();
				if (!empty ($res)) {
						if ($res[0]->hun_status == '1') {
								$result = true;
						}
						else {
								$result = false;
						}
				}
				return $result;
		}

// make car unavailable if matches today's date
		function make_unavailable() {
				$today = time();
				$this->db->select('cun_id');
				$this->db->where('cun_to <', $today);
				$hunids = $this->db->get('pt_car_unavailability')->result();
				foreach ($hunids as $id) {
						$data = array('cun_status' => '1');
						$this->db->where('cun_id', $id->cun_id);
						$this->db->update('pt_car_unavailability', $data);
				}
		}

// for auto suggestions search
		function textsearch() {
				$q = $this->input->get('q');
				$r = $this->input->get('type');
				$term = mysql_real_escape_string($q);
				$query = $this->db->query("SELECT car_title as name FROM pt_cars WHERE car_title LIKE '%$term%' ")->result();
				foreach ($query as $qry) {
						echo $qry->name . "\n";
				}
		}

// Adds translation of some fields data
		function add_translation($postdata, $carid) {
		foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];
                $metatitle = $val['metatitle'];
				$metadesc = $val['metadesc'];
				$keywords = $val['keywords'];
				$policy = $val['policy'];
                $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_policy' => $policy,
                'metatitle' => $metatitle,
                'metadesc' => $metadesc,
                'metakeywords' => $keywords,
                'item_id' => $carid,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_cars_translation', $data);
                }

                }
		}

// Update translation of some fields data
		function update_translation($postdata, $id) {
	 foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];
                $metatitle = $val['metatitle'];
				$metadesc = $val['metadesc'];
				$kewords = $val['keywords'];
				$policy = $val['policy'];
                $transAvailable = $this->getBackTranslation($lang,$id);

                if(empty($transAvailable)){
                   $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_policy' => $policy,
                'metatitle' => $metatitle,
                'metadesc' => $metadesc,
                'metakeywords' => $kewords,
                'item_id' => $id,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_cars_translation', $data);

                }else{
                 $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_policy' => $policy,
                'metatitle' => $metatitle,
                'metadesc' => $metadesc,
                'metakeywords' => $kewords,
                );
				$this->db->where('item_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_cars_translation', $data);
                }


              }

                }

		}

		 function getBackTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('item_id',$id);
            return $this->db->get('pt_cars_translation')->result();

        }

		function convert_price($amount) {

		}


		function updateCarSettings() {
				$ufor = $this->input->post('updatefor');

				$data = array('front_icon' => $this->input->post('page_icon'),
                'front_homepage' => $this->input->post('home'),
                'front_homepage_order' => $this->input->post('homeorder'),
                'front_related' => $this->input->post('related'),
                //'front_popular' => $this->input->post('popular'),
                //'front_popular_order' => $this->input->post('popularorder'),
                'front_latest' => $this->input->post('latest'),
                'front_listings' => $this->input->post('listings'),
                'front_listings_order' => $this->input->post('listingsorder'),
                'front_search' => $this->input->post('searchresult'),
                'front_search_order' => $this->input->post('searchorder'),
                'front_search_min_price' => $this->input->post('minprice'),
                'front_search_max_price' => $this->input->post('maxprice'),
                'front_txtsearch' => '1',
				'linktarget' => $this->input->post('target'), 'header_title' => $this->input->post('headertitle'),
				'meta_keywords' => $this->input->post('keywords'),
				'meta_description' => $this->input->post('description')
				);
				$this->db->where('front_for', $ufor);
				$this->db->update('pt_front_settings', $data);
				$this->session->set_flashdata('flashmsgs', "Updated Successfully");
		}

		// get popular cars
		function popular_cars_front() {
				$settings = $this->Settings_model->get_front_settings('cars');
				$limit = $settings[0]->front_popular;
				$orderby = $settings[0]->front_popular_order;

                $this->db->select('pt_cars.car_id,pt_cars.car_status,pt_reviews.review_overall,pt_reviews.review_itemid');

                $this->db->select_avg('pt_reviews.review_overall', 'overall');
				$this->db->order_by('overall', 'desc');
				$this->db->group_by('pt_cars.car_id');
				$this->db->join('pt_reviews', 'pt_cars.car_id = pt_reviews.review_itemid');
				$this->db->where('car_status', 'yes');
				$this->db->limit($limit);
			   	return $this->db->get('pt_cars')->result();
		}


		function addSettingsData() {
		        $filename = "";
                $type = $this->input->post('typeopt');
				$data = array(
                'sett_name' => $this->input->post('name'),
                'sett_status' => $this->input->post('statusopt'),
                'sett_selected' => $this->input->post('setselect'),
                'sett_type' => $type
                );
				$this->db->insert('pt_cars_types_settings', $data);
                return $this->db->insert_id();
                $this->session->set_flashdata('flashmsgs', "Updated Successfully");

		}



		// update car settings data
		function updateSettingsData() {
				$id = $this->input->post('settid');
                $type = $this->input->post('typeopt');
                 $filename = "";

				$data = array('sett_name' => $this->input->post('name'),
                'sett_status' => $this->input->post('statusopt'),
                'sett_selected' => $this->input->post('setselect')
                );
				$this->db->where('sett_id', $id);
				$this->db->update('pt_cars_types_settings', $data);
                $this->session->set_flashdata('flashmsgs', "Updated Successfully");
		}


		 function updateSettingsTypeTranslation($postdata,$id) {

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $name = $val['name'];

                $transAvailable = $this->getBackSettingsTranslation($lang,$id);

                if(empty($transAvailable)){
                 $data = array(
                'trans_name' => $name,
                'sett_id' => $id,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_cars_types_settings_translation', $data);

                }else{

                 $data = array(
                'trans_name' => $name
                );
				$this->db->where('sett_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_cars_types_settings_translation', $data);

              }


              }

                }
		}


         function getBackSettingsTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_cars_types_settings_translation')->result();

        }

        // Delete car settings
		function deleteTypeSettings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_cars_types_settings');

                $this->db->where('sett_id', $id);
				$this->db->delete('pt_cars_types_settings_translation');
		}


		function getTypesTranslation($lang,$id){

		$this->db->where('trans_lang',$lang);
		$this->db->where('sett_id',$id);
		return $this->db->get('pt_cars_types_settings_translation')->result();

		}


		function updateCarLocations($locations, $carid){

        	$this->db->where('car_id',$carid);
        	$this->db->delete('pt_car_locations');
        	$position = 0;

        	foreach($locations as $loc){
        		$pickup = $loc['pickup'];
        		$dropoff = $loc['dropoff'];
        		$price = $loc['price'];

        		if(!empty($pickup) && !empty($dropoff) && !empty($price) ){
        			$position++;
        			if($position == 1){
        				$updateCarLocation = array('car_city' => $pickup);
        				$this->db->where('car_id',$carid);
        				$this->db->update('pt_cars',$updateCarLocation);

        			}

        			$data = array('position' => $position,
        				'pickup_location_id' => $pickup,
        				'dropoff_location_id' => $dropoff,
        				'price' => $price,
        				'car_id' => $carid);
        			$this->db->insert('pt_car_locations', $data);
        		}
        	}

        }

		function carLocationsInfo($i, $locid,$carid, $type){
			$result = new stdClass;
			$result->isPickup = FALSE;
			$result->isDropoff = FALSE;
			$result->price = "";
			$this->db->where('car_id',$carid);
			$this->db->where('position',$i);
			if($type == "pickup"){
			$this->db->where('pickup_location_id',$locid);
			}

			if($type == "dropoff"){
			$this->db->where('dropoff_location_id',$locid);
			}
			$res = $this->db->get('pt_car_locations')->result();
			if(!empty($res)){
				$result->price = $res[0]->price;
				$result->isDropoff = TRUE;
				$result->isPickup = TRUE;
			}

			return $result;
		}

		function carSelectedLocations($carid){
			$result = array();
			$this->db->where('car_id', $carid);

			$res = $this->db->get('pt_car_locations')->result();
			foreach($res as $r){
				if($r->pickup_location_id > 0){
					$pickupLocInfo = pt_LocationsInfo($r->pickup_location_id);
					$result['pickup'][$r->position] = (object)array('id' => $r->pickup_location_id,'name' => $pickupLocInfo->city.", ".$pickupLocInfo->country,'price' => $r->price);

				}

				if($r->dropoff_location_id > 0){
					$dropoffLocInfo = pt_LocationsInfo($r->dropoff_location_id);
					$result['dropoff'][$r->position] = (object)array('id' => $r->dropoff_location_id,'name' => $dropoffLocInfo->city.", ".$dropoffLocInfo->country,'price' => $r->price);

				}

				$result['price'][$r->position] = $r->price;

					}
		 return $result;

		}



        public function suppilercars($owned_id){
            $this->db->where('car_owned_by',$owned_id);
            return $this->db->get('pt_cars')->result();
        }

}
