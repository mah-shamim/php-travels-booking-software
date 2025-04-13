<?php

class Rentals_model extends CI_Model {
        public $langdef;
		function __construct() {
// Call the Model constructor
				parent :: __construct();
                $this->langdef = DEFLANG;
		}

// Get all enabled rentals short info
		function shortInfo($id = null) {
				$result = array();
				$this->db->select('rental_id,rental_title,rental_slug');
				if (!empty ($id)) {
						$this->db->where('rental_owned_by', $id);
				}
				$this->db->where('rental_status', 'Yes');
				$this->db->order_by('rental_id', 'desc');
				$rentals = $this->db->get('pt_rentals')->result();
				foreach($rentals as $rental){
					$result[] = (object)array('id' => $rental->rental_id, 'title' => $rental->rental_title, 'slug' => $rental->rental_slug);
				}

				return $result;
		}

// Get all rentals id and names only
		function all_rentals_names($id = null) {
				$this->db->select('rental_id,rental_title');
				if (!empty ($id)) {
						$this->db->where('rental_owned_by', $id);
				}
				$this->db->order_by('rental_id', 'desc');
				return $this->db->get('pt_rentals')->result();
		}

		// Get all rentals for extras
		function all_rentals($id = null) {
				$this->db->select('rental_id as id,rental_title as title');
				if (!empty ($id)) {
						$this->db->where('rental_owned_by', $id);
				}
				$this->db->order_by('rental_id', 'desc');
				return $this->db->get('pt_rentals')->result();
		}

		function convert_price($amount) {

		}

// get latest rentals
		function latest_rentals_front() {
				$settings = $this->Settings_model->get_front_settings('rentals');
				$limit = $settings[0]->front_latest;
				$this->db->select('pt_rentals.rental_status,pt_rentals.rental_basic_price,pt_rentals.rental_basic_discount,pt_rentals.rental_id,pt_rentals.rental_desc,pt_rentals.rental_title,pt_rentals.rental_slug,pt_rentals.rental_type,pt_rentals_types_settings.sett_name');
				$this->db->order_by('pt_rentals.rental_id', 'desc');
				$this->db->where('pt_rentals.rental_status', 'Yes');
				$this->db->join('pt_rentals_types_settings', 'pt_rentals.rental_type = pt_rentals_types_settings.sett_id', 'left');
				$this->db->limit($limit);
				return $this->db->get('pt_rentals')->result();
		}

// get all data of single rental by slug
		function get_rental_data($rentalname) {
				$this->db->select('pt_rentals.*');
				$this->db->where('pt_rentals.rental_slug', $rentalname);

				return $this->db->get('pt_rentals')->result();
		}

// get all rentals info
		function get_all_rentals_back($id = null) {
				$this->db->select('pt_rentals.rental_featured_forever,pt_rentals.rental_id,pt_rentals.rental_title,pt_rentals.rental_slug,pt_rentals.rental_owned_by,pt_rentals.rental_order,pt_rentals.rental_status,pt_rentals.rental_is_featured,
    pt_rentals.rental_featured_from,pt_rentals.rental_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_rentals_types_settings.sett_name');
// $this->db->where('pt_rental_images.timg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_rentals.rental_owned_by', $id);
				}
				$this->db->order_by('pt_rentals.rental_id', 'desc');
				$this->db->join('pt_accounts', 'pt_rentals.rental_owned_by = pt_accounts.accounts_id', 'left');
//$this->db->join('pt_rental_images','pt_rentals.rental_id = pt_rental_images.timg_rental_id','left');
				$query = $this->db->get('pt_rentals');
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all rentals info with limit
		function get_all_rentals_back_limit($id = null, $perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_rentals.rental_featured_forever,pt_rentals.rental_id,pt_rentals.rental_title,pt_rentals.rental_slug,pt_rentals.rental_created_at,pt_rentals.rental_owned_by,pt_rentals.rental_order,pt_rentals.rental_status,pt_rentals.rental_is_featured,
    pt_rentals.rental_featured_from,pt_rentals.rental_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_rentals_types_settings.sett_name');
// $this->db->where('pt_rental_images.timg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_rentals.rental_owned_by', $id);
				}
				$this->db->order_by('pt_rentals.rental_id', 'desc');
				$this->db->join('pt_accounts', 'pt_rentals.rental_owned_by = pt_accounts.accounts_id', 'left');
//  $this->db->join('pt_rental_images','pt_rentals.rental_id = pt_rental_images.timg_rental_id','left');
				$query = $this->db->get('pt_rentals', $perpage, $offset);
				$data['all'] = $query->result();
				return $data;
		}

// add rental data
		function add_rental($user = null) {
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

                $this->db->select("rental_id");
				$this->db->order_by("rental_id", "desc");
				$query = $this->db->get('pt_rentals');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$rentallastid = 1;
				}
				else {
						$rentallastid = $lastid[0]->rental_id + 1;
				}

				$rentalcount = $query->num_rows();
				$rentalorder = $rentalcount + 1;
				$this->db->select("rental_id");
				$this->db->where("rental_title", $this->input->post('rentalname'));
				$queryc = $this->db->get('pt_rentals')->num_rows();
				if ($queryc > 0) {
						$rentalslug = create_url_slug($this->input->post('rentalname')) . "-" . $rentallastid;
				}
				else {
						$rentalslug = create_url_slug($this->input->post('rentalname'));
				}
				$amenities = @ implode(",", $this->input->post('rentalamenities'));
				$exclusions = @ implode(",", $this->input->post('rentalexclusions'));
				$paymentopt = @ implode(",", $this->input->post('rentalpayments'));
				$relatedrentals = @ implode(",", $this->input->post('relatedrentals'));


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

				$location =  $this->input->post('locations');
				$rentalLocation = $location[0];

				$stars = $this->input->post('rentalstars');
				if(empty($stars)){
					$stars = 0;
				}

				$data = array('rental_title' => $this->input->post('rentalname'),
					'rental_slug' => $rentalslug, 'rental_desc' => $this->input->post('rentaldesc'),
					'rental_stars' => intval($stars),
					'rental_is_featured' => $featured,
					'rental_featured_from' => convert_to_unix($ffrom),
					'rental_featured_to' => convert_to_unix($fto),
					'rental_owned_by' => $user,
					'rental_type' => $this->input->post('rentaltype'),
					'rental_location' => $rentalLocation,
					'rental_latitude' => $this->input->post('latitude'),
					'rental_longitude' => $this->input->post('longitude'),
					'rental_mapaddress' => $this->input->post('rentalmapaddress'),
	                //'rental_basic_price' => $this->input->post('basic'),
					//'rental_basic_discount' => $this->input->post('discount'),
					'rental_meta_title' => $this->input->post('rentalmetatitle'),
					'rental_meta_keywords' => $this->input->post('rentalkeywords'),
					'rental_meta_desc' => $this->input->post('rentalmetadesc'), 'rental_amenities' => $amenities,
					'rental_exclusions' => $exclusions, 'rental_payment_opt' => $paymentopt,
					'rental_max_adults' => intval($this->input->post('maxadult')),
					'rental_max_child' => intval($this->input->post('maxchild')),
					'rental_max_infant' => intval($this->input->post('maxinfant')),
					'rental_adult_price' => floatval($this->input->post('adultprice')),
					'rental_child_price' => floatval($this->input->post('childprice')),
					'rental_infant_price' => floatval($this->input->post('infantprice')),
					'adult_status' => intval($this->input->post('adultstatus')),
					'child_status' => intval($this->input->post('childstatus')),
					'infant_status' => intval($this->input->post('infantstatus')),
					'rental_days' => intval($this->input->post('rentaldays')),
					'rental_nights' => intval($this->input->post('rentalnights')),
					'rental_hours' => intval($this->input->post('rentalhours')),
					'rental_privacy' => $this->input->post('rentalprivacy'),
					'rental_status' => $this->input->post('rentalstatus'),
					'rental_related' => $relatedrentals, 'rental_order' => $rentalorder,
					'rental_comm_fixed' => $commfixed, 'rental_comm_percentage' => $commper,
					'rental_tax_fixed' => $taxfixed, 'rental_tax_percentage' => $taxper,
					'rental_email' => $this->input->post('rentalemail'),
					'rental_phone' => $this->input->post('rentalphone'),
					'rental_website' => $this->input->post('rentalwebsite'),
					'rental_fulladdress' => $this->input->post('rentalfulladdress'),
					'rental_featured_forever' => $isforever,
					'rental_created_at' => time());
				$this->db->insert('pt_rentals', $data);
				$rentalid = $this->db->insert_id();
				$this->updaterentalLocations($this->input->post('locations'), $rentalid);
				return $rentalid;
		}

// update rental data
		function update_rental($id) {

				$rentalcomm = $this->input->post('deposit');
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


				$this->db->select("rental_id");
				$this->db->where("rental_id !=", $id);
				$this->db->where("rental_title", $this->input->post('rentalname'));
				$queryc = $this->db->get('pt_rentals')->num_rows();
				if ($queryc > 0) {
						$rentalslug = create_url_slug($this->input->post('rentalname')) . "-" . $id;
				}
				else {
						$rentalslug = create_url_slug($this->input->post('rentalname'));
				}
				$amenities = @ implode(",", $this->input->post('rentalamenities'));
				$exclusions = @ implode(",", $this->input->post('rentalexclusions'));
				$paymentopt = @ implode(",", $this->input->post('rentalpayments'));
				$relatedrentals = @ implode(",", $this->input->post('relatedrentals'));

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

				$location =  $this->input->post('locations');
				$rentalLocation = $location[0];

				$stars = $this->input->post('rentalstars');
				if(empty($stars)){
					$stars = 0;
				}

				$data = array('rental_title' => $this->input->post('rentalname'),
					'rental_slug' => $rentalslug, 'rental_desc' => $this->input->post('rentaldesc'),
					'rental_stars' => intval($stars),
					'rental_is_featured' => $featured,
					'rental_featured_from' => convert_to_unix($ffrom),
					'rental_featured_to' => convert_to_unix($fto),
					'rental_type' => $this->input->post('rentaltype'),
					'rental_location' => $rentalLocation,
					'rental_latitude' => $this->input->post('latitude'),
					'rental_longitude' => $this->input->post('longitude'),
					'rental_mapaddress' => $this->input->post('rentalmapaddress'),
	                //'rental_basic_price' => $this->input->post('basic'),
					//'rental_basic_discount' => $this->input->post('discount'),
					'rental_meta_title' => $this->input->post('rentalmetatitle'),
					'rental_meta_keywords' => $this->input->post('rentalkeywords'),
					'rental_meta_desc' => $this->input->post('rentalmetadesc'), 'rental_amenities' => $amenities,
					'rental_exclusions' => $exclusions, 'rental_payment_opt' => $paymentopt,
					'rental_max_adults' => intval($this->input->post('maxadult')),
					'rental_max_child' => intval($this->input->post('maxchild')),
					'rental_max_infant' => intval($this->input->post('maxinfant')),
					'rental_adult_price' => floatval($this->input->post('adultprice')),
					'rental_child_price' => floatval($this->input->post('childprice')),
					'rental_infant_price' => floatval($this->input->post('infantprice')),
					'adult_status' => intval($this->input->post('adultstatus')),
					'child_status' => intval($this->input->post('childstatus')),
					'infant_status' => intval($this->input->post('infantstatus')),
					'rental_days' => intval($this->input->post('rentaldays')),
					'rental_hours' => intval($this->input->post('rentalhours')),
					'rental_nights' => intval($this->input->post('rentalnights')),
					'rental_privacy' => $this->input->post('rentalprivacy'),
					'rental_status' => $this->input->post('rentalstatus'),
					'rental_related' => $relatedrentals,
					'rental_comm_fixed' => $commfixed, 'rental_comm_percentage' => $commper,
					'rental_tax_fixed' => $taxfixed, 'rental_tax_percentage' => $taxper,
					'rental_email' => $this->input->post('rentalemail'),
					'rental_phone' => $this->input->post('rentalphone'),
					'rental_website' => $this->input->post('rentalwebsite'),
					'rental_fulladdress' => $this->input->post('rentalfulladdress'),
					'rental_featured_forever' => $isforever);
				$this->db->where('rental_id', $id);
				$this->db->update('pt_rentals', $data);

				$this->updaterentalLocations($this->input->post('locations'), $id);
	}

// Add rental settings data
		function add_settings_data() {
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'), 'sett_type' => $this->input->post('typeopt'));
				$this->db->insert('pt_rentals_types_settings', $data);
		}

// update rental settings data
		function update_settings_data() {
				$id = $this->input->post('id');
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'));
				$this->db->where('sett_id', $id);
				$this->db->update('pt_rentals_types_settings', $data);
		}

// Disable rental settings
		function disable_settings($id) {
				$data = array('sett_status' => 'No');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_rentals_types_settings', $data);
		}

// Enable rental settings
		function enable_settings($id) {
				$data = array('sett_status' => 'Yes');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_rentals_types_settings', $data);
		}

// Delete rental settings
		function delete_settings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_rentals_types_settings');
		}

// get all rentals for related selection for backend
		function select_related_rentals($id = null) {
				$this->db->select('rental_title,rental_id');
				if (!empty ($id)) {
						$this->db->where('rental_id !=', $id);
				}
				return $this->db->get('pt_rentals')->result();
		}

// Get rental settings data
		function get_rental_settings_data($type = 0) {
			if(!empty($type)){
             	$this->db->where('sett_type', $type);
		  }

				$this->db->order_by('sett_id', 'desc');
				return $this->db->get('pt_rentals_types_settings')->result();
		}

// Get rental settings data for adding rental
		function get_tsettings_data($type) {
				$this->db->where('sett_type', $type);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_rentals_types_settings')->result();
		}

// Get rental settings data for adding rental
		function get_tsettings_data_front($type, $items) {
				$this->db->where('sett_type', $type);
				$this->db->where_in('sett_id', $items);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_rentals_types_settings')->result();
		}

// add rental images by type
		function add_rental_image($type, $filename, $rentalid) {
				$imgorder = 0;
				if ($type == "slider") {
						$this->db->where('timg_type', 'slider');
						$this->db->where('timg_rental_id', $rentalid);
						$imgorder = $this->db->get('pt_rental_images')->num_rows();
						$imgorder = $imgorder + 1;
				}
				$this->db->where('timg_type', 'default');
				$this->db->where('timg_rental_id', $rentalid);
				$hasdefault = $this->db->get('pt_rental_images')->num_rows();
				if ($hasdefault < 1) {
						$type = 'default';
				}
				$approval = pt_admin_gallery_approve();
				$data = array('timg_rental_id' => $rentalid, 'timg_type' => $type, 'timg_image' => $filename, 'timg_order' => $imgorder, 'timg_approved' => $approval);
				$this->db->insert('pt_rental_images', $data);
		}

// update rental map order
		function update_map_order($id, $order) {
				$data = array('map_order' => $order);
				$this->db->where('map_id', $id);
				$this->db->update('pt_rentals_maps', $data);
		}


// update rental order
		function update_rental_order($id, $order) {
				$data = array('rental_order' => $order);
				$this->db->where('rental_id', $id);
				$this->db->update('pt_rentals', $data);
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



			 $data = array('rental_is_featured' => $isfeatured, 'rental_featured_forever' => $isforever);
				$this->db->where('rental_id', $id);
				$this->db->update('pt_rentals', $data);
		}
// Disable rental

		public function disable_rental($id) {
				$data = array('rental_status' => 'No');
				$this->db->where('rental_id', $id);
				$this->db->update('pt_rentals', $data);
		}
// Enable rental

		public function enable_rental($id) {
				$data = array('rental_status' => 'Yes');
				$this->db->where('rental_id', $id);
				$this->db->update('pt_rentals', $data);
		}

// Delete rental
		function delete_rental($rentalid) {
				$rentalimages = $this->rental_images($rentalid);
				foreach ($rentalimages['all_slider'] as $sliderimg) {
						$this->delete_image($sliderimg->timg_image,$sliderimg->timg_id,$rentalid);
				}


				$this->db->where('review_itemid', $rentalid);
				$this->db->where('review_module', 'rentals');
				$this->db->delete('pt_reviews');
				$this->db->where('map_rental_id', $rentalid);
				$this->db->delete('pt_rentals_maps');

				$this->db->where('item_id', $rentalid);
                $this->db->delete('pt_rentals_translation');

                $this->db->where('rental_id',$rentalid);
            	$this->db->delete('pt_rental_locations');

				$this->db->where('rental_id', $rentalid);
				$this->db->delete('pt_rentals');
		}

// Get rental Images
		function rental_images($id) {
				$this->db->where('timg_rental_id', $id);
				$this->db->where('timg_type', 'default');
				$q = $this->db->get('pt_rental_images');
				$data['def_image'] = $q->result();
				$this->db->where('timg_type', 'slider');
				$this->db->order_by('timg_id', 'desc');
				$this->db->having('timg_rental_id', $id);
				$q = $this->db->get('pt_rental_images');
				$data['all_slider'] = $q->result();
				$data['slider_counts'] = $q->num_rows();
				return $data;
		}

//update rental thumbnail
		function update_thumb($oldthumb, $newthumb, $rentalid) {
				$data = array('timg_type' => 'slider');
				$this->db->where('timg_id', $oldthumb);
				$this->db->where('timg_rental_id', $rentalid);
				$this->db->update('pt_rental_images', $data);
				$data2 = array('timg_type' => 'default');
				$this->db->where('timg_id', $newthumb);
				$this->db->where('timg_rental_id', $rentalid);
				$this->db->update('pt_rental_images', $data2);
		}

// Approve or reject Hotel Images
		function approve_reject_images() {
				$data = array('timg_approved' => $this->input->post('apprej'));
				$this->db->where('timg_id', $this->input->post('imgid'));
				$this->db->update('pt_rental_images', $data);
		}

// update image order
		function update_image_order($imgid, $order) {
				$data = array('timg_order' => $order);
				$this->db->where('timg_id', $imgid);
				$this->db->update('pt_rental_images', $data);
		}


// Delete rental Images
		function delete_image($imgname, $imgid, $rentalid) {
				$this->db->where('timg_id', $imgid);
				$this->db->delete('pt_rental_images');
                $this->updaterentalThumb($rentalid,$imgname,"delete");
                @ unlink(PT_RENTALS_SLIDER_THUMB_UPLOAD . $imgname);
				@ unlink(PT_RENTALS_SLIDER_UPLOAD . $imgname);
		}

//update rental thumbnail
		function updaterentalThumb($rentalid,$imgname,$action) {
		  if($action == "delete"){
            $this->db->select('thumbnail_image');
            $this->db->where('thumbnail_image',$imgname);
            $this->db->where('rental_id',$rentalid);
            $rs = $this->db->get('pt_rentals')->num_rows();
            if($rs > 0){
              $data = array(
              'thumbnail_image' => PT_BLANK_IMG
              );
              $this->db->where('rental_id',$rentalid);
              $this->db->update('pt_rentals',$data);
            }
            }else{
              $data = array(
              'thumbnail_image' => $imgname
              );
              $this->db->where('rental_id',$rentalid);
              $this->db->update('pt_rentals',$data);
            }

		}




		function offers_data($id) {
				/*$this->db->where('offer_module', 'rentals');
				$this->db->where('offer_item', $id);
				return $this->db->get('pt_special_offers')->result();*/
		}

		function add_to_map() {
				$maporder = 0;
				$rentalid = $this->input->post('rentalid');
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_rental_id', $rentalid);
				$res = $this->db->get('pt_rentals_maps')->num_rows();
				$addtype = $this->input->post('addtype');
				if ($addtype == "visit") {
						$maporder = $res + 1;
				}
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'), 'map_city_type' => $addtype, 'map_rental_id' => $rentalid, 'map_order' => $maporder);
				$this->db->insert('pt_rentals_maps', $data);
		}

		function update_rental_map() {
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'),);
				$this->db->where('map_id', $this->input->post('mapid'));
				$this->db->update('pt_rentals_maps', $data);
		}

		function has_start_end_city($type, $rentalid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', $type);
				$this->db->where('map_rental_id', $rentalid);
				$nums = $this->db->get('pt_rentals_maps')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

		function get_rental_map($rentalid) {
				$this->db->where('map_rental_id', $rentalid);
				return $this->db->get('pt_rentals_maps')->result();
		}

		function delete_map_item($mapid) {
				$this->db->where('map_id', $mapid);
				$this->db->delete('pt_rentals_maps');
		}

// get related rentals for front-end
		function get_related_rentals($rentals) {
				$id = explode(",", $rentals);
				$this->db->select('pt_rentals.rental_title,pt_rentals.rental_slug,pt_rentals.rental_id,pt_rentals.rental_basic_price,pt_rentals.rental_basic_discount,pt_rentals_types_settings.sett_name');
				$this->db->where_in('pt_rentals.rental_id', $id);
/*  $this->db->where('pt_rental_images.timg_type','default');
$this->db->join('pt_rental_images','pt_rentals.rental_id = pt_rental_images.timg_rental_id','left');*/
				$this->db->join('pt_rentals_types_settings', 'pt_rentals.rental_type = pt_rentals_types_settings.sett_id', 'left');
				return $this->db->get('pt_rentals')->result();
		}

// Check rental existence
		function rental_exists($slug) {
				$this->db->select('rental_id');
				$this->db->where('rental_slug', $slug);
				$this->db->where('rental_status', 'Yes');
				$nums = $this->db->get('pt_rentals')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// List all rentals on front listings page
		function list_rentals_front($sprice = null, $perpage = null, $offset = null, $orderby = null) {
				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if ($orderby == "za") {
						$this->db->order_by('pt_rentals.rental_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_rentals.rental_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_rentals.rental_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_rentals.rental_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_rentals.rental_order', 'asc');
				}
				$this->db->select('rental_id');
				$this->db->group_by('rental_id');

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_rentals.rental_adult_price >=', $minp);
						$this->db->where('pt_rentals.rental_adult_price <=', $maxp);
				}

				$this->db->where('rental_status', 'Yes');
				$query = $this->db->get('pt_rentals', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// List all rentals on front listings page by location
		function showrentalsByLocation($locs, $sprice = null, $perpage = null, $offset = null, $orderby = null) {

				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if ($orderby == "za") {
						$this->db->order_by('pt_rentals.rental_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_rentals.rental_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_rentals.rental_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_rentals.rental_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_rentals.rental_order', 'asc');
				}
				$this->db->select('rental_id');
				$this->db->group_by('rental_id');

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_rentals.rental_adult_price >=', $minp);
						$this->db->where('pt_rentals.rental_adult_price <=', $maxp);
				}

				if(is_array($locs)){
                $this->db->where_in('pt_rentals.rental_location',$locs);
                }else{
                    $locs = str_replace('+', ' ', $locs);
                $this->db->where('pt_rentals.rental_location',$locs);
                }

				$this->db->where('rental_status', 'Yes');
				$query = $this->db->get('pt_rentals', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// Search rentals from home page
		function search_rentals_front($location = null, $sprice = null, $perpage = null, $offset = null, $orderby = null) {
				$this->load->helper('rentals_front');
				$data = array();

				//$location = $this->input->get('location');

				$adults = $this->input->get('adults');
				$type = $this->input->get('type');

				//$sprice = $this->input->get('price');
				$stars = $this->input->get('stars');

				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_rentals.rental_id,rental_type,rental_location,rental_adult_price,rental_title,rental_max_adults,rental_status,pt_rental_locations.*');
				if ($orderby == "za") {
						$this->db->order_by('pt_rentals.rental_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_rentals.rental_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_rentals.rental_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_rentals.rental_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_rentals.rental_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_rentals.rental_adult_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_rentals.rental_adult_price', 'desc');
				}

				if(!empty($location)){
					//$this->db->like('pt_rentals.rental_location', $location);
					$this->db->where('pt_rental_locations.location_id', $location);

				}


				if (!empty ($adults)) {
						$this->db->where('pt_rentals.rental_max_adults >=', $adults);
				}

				if (!empty ($stars)) {
						$this->db->where('rental_stars', $stars);
				}



				if (!empty ($type)) {
						$this->db->where('pt_rentals.rental_type', $type);
				}

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_rentals.rental_adult_price >=', $minp);
						$this->db->where('pt_rentals.rental_adult_price <=', $maxp);
				}
				$this->db->group_by('pt_rentals.rental_id');
				$this->db->join('pt_rental_locations', 'pt_rentals.rental_id = pt_rental_locations.rental_id');
				$this->db->where('pt_rentals.rental_status', 'Yes');


		if(!empty($perpage)){

				$query = $this->db->get('pt_rentals', $perpage, $offset);

				}else{

				$query = $this->db->get('pt_rentals');

				}

				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

		function max_map_order($rentalid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_rental_id', $rentalid);
				return $this->db->get('pt_rentals_maps')->num_rows();
		}

// get default image of rental
		function default_rental_img($id) {
				$this->db->where('timg_type', 'default');
				$this->db->where('timg_approved', '1');
				$this->db->where('timg_rental_id', $id);
				$res = $this->db->get('pt_rental_images')->result();
				if (!empty ($res)) {
						return $res[0]->timg_image;
				}
				else {
						return '';
				}
		}

// update translated data os some fields in english
		function update_english($id) {
				$cslug = create_url_slug($this->input->post('title'));
				$this->db->where('rental_slug', $cslug);
				$this->db->where('rental_id !=', $id);
				$nums = $this->db->get('pt_rentals')->num_rows();
				if ($nums > 0) {
						$cslug = $cslug . "-" . $id;
				}
				else {
						$cslug = $cslug;
				}
				$data = array('rental_title' => $this->input->post('title'), 'rental_slug' => $cslug, 'rental_desc' => $this->input->post('desc'), 'rental_policy' => $this->input->post('policy'));
				$this->db->where('rental_id', $id);
				$this->db->update('pt_rentals', $data);
				return $cslug;
		}

// Adds translation of some fields data
		function add_translation($postdata, $rentalid) {
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
                'item_id' => $rentalid,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_rentals_translation', $data);
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
				$this->db->insert('pt_rentals_translation', $data);

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
			    $this->db->update('pt_rentals_translation', $data);
                }


              }

                }

		}

		 function getBackTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('item_id',$id);
            return $this->db->get('pt_rentals_translation')->result();

        }

         function rentalGallery($slug){

          $this->db->select('pt_rentals.thumbnail_image as thumbnail,pt_rental_images.timg_id as id,pt_rental_images.timg_rental_id as itemid,pt_rental_images.timg_type as type,pt_rental_images.timg_image as image,pt_rental_images.timg_order as imgorder,pt_rental_images.timg_image as image,pt_rental_images.timg_approved as approved');
          $this->db->where('pt_rentals.rental_slug',$slug);
          $this->db->join('pt_rental_images', 'pt_rentals.rental_id = pt_rental_images.timg_rental_id', 'left');
          $this->db->order_by('pt_rental_images.timg_id','desc');
          return $this->db->get('pt_rentals')->result();

        }

        function addPhotos($id,$filename){

         $this->db->select('thumbnail_image');
         $this->db->where('rental_id',$id);
         $rs = $this->db->get('pt_rentals')->result();
         if($rs[0]->thumbnail_image == PT_BLANK_IMG){

               $data = array('thumbnail_image' => $filename);
               $this->db->where('rental_id',$id);
               $this->db->update('pt_rentals',$data);
         }

        //add photos to rental images table
        $imgorder = 0;
        $this->db->where('timg_type', 'slider');
        $this->db->where('timg_rental_id', $id);
        $imgorder = $this->db->get('pt_rental_images')->num_rows();
        $imgorder = $imgorder + 1;

				$approval = pt_admin_gallery_approve();

		    	$insdata = array(
                'timg_rental_id' => $id,
                'timg_type' => 'slider',
                'timg_image' => $filename,
                'timg_order' => $imgorder,
                'timg_approved' => $approval
                );

				$this->db->insert('pt_rental_images', $insdata);


        }

        function assignrentals($rentals,$userid){

          if(!empty($rentals)){
          $userrentals = $this->userOwnedrentals($userid);
                foreach($userrentals as $tt){
                   if(!in_array($tt,$rentals)){
                    $ddata = array(
                   'rental_owned_by' => '1'
                   );
                   $this->db->where('rental_id',$tt);
                   $this->db->update('pt_rentals',$ddata);
                   }
                }

                foreach($rentals as $t){
                   $data = array(
                   'rental_owned_by' => $userid
                   );
                   $this->db->where('rental_id',$t);
                   $this->db->update('pt_rentals',$data);

                 }

                 }
        }

        function userOwnedrentals($id){
          $result = array();
          if(!empty($id)){
          $this->db->where('rental_owned_by',$id);
          }

          $rs = $this->db->get('pt_rentals')->result();
          if(!empty($rs)){
            foreach($rs as $r){
              $result[] = $r->rental_id;
            }
          }
          return $result;
        }

        // get number of photos of rental
		function photos_count($rentalid) {
				$this->db->where('timg_rental_id', $rentalid);
				return $this->db->get('pt_rental_images')->num_rows();
		}

		function updaterentalSettings() {
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
				'linktarget' => $this->input->post('target'),
				'header_title' => $this->input->post('headertitle'),
				'meta_keywords' => $this->input->post('keywords'),
				'meta_description' => $this->input->post('description')
				);
				$this->db->where('front_for', $ufor);
				$this->db->update('pt_front_settings', $data);

				$this->session->set_flashdata('flashmsgs', "Updated Successfully");
		}

		// get popular rentals
		function popular_rentals_front() {
				$settings = $this->Settings_model->get_front_settings('rentals');
				$limit = $settings[0]->front_popular;
				$orderby = $settings[0]->front_popular_order;

                $this->db->select('pt_rentals.rental_id,pt_rentals.rental_status,pt_reviews.review_overall,pt_reviews.review_itemid');

                $this->db->select_avg('pt_reviews.review_overall', 'overall');
				$this->db->order_by('overall', 'desc');
				$this->db->group_by('pt_rentals.rental_id');
				$this->db->join('pt_reviews', 'pt_rentals.rental_id = pt_reviews.review_itemid');
				$this->db->where('rental_status', 'yes');
				$this->db->limit($limit);
			   	return $this->db->get('pt_rentals')->result();
		}



		function addSettingsData() {
		        $filename = "";
                $type = $this->input->post('typeopt');
				$data = array(
                'sett_name' => $this->input->post('name'),
                'sett_status' => $this->input->post('statusopt'),
                'sett_selected' => $this->input->post('setselect'),
                'sett_type' => $type,
                'sett_img' => $filename
                );
				$this->db->insert('pt_rentals_types_settings', $data);
                return $this->db->insert_id();
                $this->session->set_flashdata('flashmsgs', "Updated Successfully");

		}

// update rental settings data
		function updateSettingsData() {
				$id = $this->input->post('settid');
                $type = $this->input->post('typeopt');
                 $filename = "";

				$data = array('sett_name' => $this->input->post('name'),
                'sett_status' => $this->input->post('statusopt'),
                'sett_selected' => $this->input->post('setselect'),
                'sett_img' => $filename

                );
				$this->db->where('sett_id', $id);
				$this->db->update('pt_rentals_types_settings', $data);
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
				$this->db->insert('pt_rentals_types_settings_translation', $data);

                }else{

                 $data = array(
                'trans_name' => $name
                );
				$this->db->where('sett_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_rentals_types_settings_translation', $data);

              }


              }

                }
		}


         function getBackSettingsTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_rentals_types_settings_translation')->result();

        }

        // Delete hotel settings
		function deleteTypeSettings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_rentals_types_settings');

                $this->db->where('sett_id', $id);
				$this->db->delete('pt_rentals_types_settings_translation');
		}

				// Delete multiple rental settings
		function deleteMultiplesettings($id, $type) {
				$this->db->where('sett_id', $id);
				$this->db->where('sett_type',$type);
				$this->db->delete('pt_rentals_types_settings');

				$rowsDeleted = $this->db->affected_rows();

				if($rowsDeleted > 0){
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_rentals_types_settings_translation');
				}


		}

         function getTypesTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_rentals_types_settings_translation')->result();

        }

        function updaterentalLocations($locations, $rentalid){

        	$this->db->where('rental_id',$rentalid);
        	$this->db->delete('pt_rental_locations');
        	$position = 0;

        	foreach($locations as $loc){

        		if(!empty($loc)){
        			$position++;
        			$data = array('position' => $position,'location_id' => $loc, 'rental_id' => $rentalid);
        			$this->db->insert('pt_rental_locations', $data);
        		}
        	}

        }

        function isrentalLocation($i, $locid, $rentalid){
        	$this->db->where('position', $i);
        	$this->db->where('location_id', $locid);
        	$this->db->where('rental_id', $rentalid);
        	$rs = $this->db->get('pt_rental_locations')->num_rows();
        	if($rs > 0){
        		return "selected";
        	}else{
        		return "";
        	}
        }

        function rentalSelectedLocations($rentalid){
          $result = array();
          $this->db->where('rental_id', $rentalid);
          $res = $this->db->get('pt_rental_locations')->result();
          foreach($res as $r){
            $locInfo = pt_LocationsInfo($r->location_id);
            $result[$r->position] = (object)array('id' => $r->location_id,'name' => $locInfo->city.", ".$locInfo->country);
          }
         return $result;

        }

        public function getpackages($id)
        {
        $this->db->order_by('id', 'DESC');  //actual field name of id
        $this->db->where('rental_id',$id);
        $query=$this->db->get('pt_rentals_packages');
        return $query->result();
        }
        public function getpackage($id)
        {
        $this->db->where('id',$id);
        $query=$this->db->get('pt_rentals_packages');
        return $query->row();
        }

        public function suppilerrental($owned_id){
            $this->db->where('rental_owned_by',$owned_id);
            return $this->db->get('pt_rentals')->result();
        }



        public function checkbooking($id){
		    $data = str_replace('/','-',$_GET['checkin']);
		    $da =  date("Y-m-d", strtotime($data));
		    $this->db->where('booking_type','rentals');
		    $this->db->where('booking_item',$id);
		    $this->db->where('booking_checkin',$da);
		    $this->db->where('booking_status','paid');
            return $this->db->get('pt_bookings')->result();
        }
}
