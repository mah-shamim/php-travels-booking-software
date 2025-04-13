<?php

class Boats_model extends CI_Model {
        public $langdef;
		function __construct() {
// Call the Model constructor
				parent :: __construct();
                $this->langdef = DEFLANG;
		}

// Get all enabled boats short info
		function shortInfo($id = null) {
				$result = array();
				$this->db->select('boat_id,boat_title,boat_slug');
				if (!empty ($id)) {
						$this->db->where('boat_owned_by', $id);
				}
				$this->db->where('boat_status', 'Yes');
				$this->db->order_by('boat_id', 'desc');
				$boats = $this->db->get('pt_boats')->result();
				foreach($boats as $boat){
					$result[] = (object)array('id' => $boat->boat_id, 'title' => $boat->boat_title, 'slug' => $boat->boat_slug);
				}

				return $result;
		}

// Get all boats id and names only
		function all_boats_names($id = null) {
				$this->db->select('boat_id,boat_title');
				if (!empty ($id)) {
						$this->db->where('boat_owned_by', $id);
				}
				$this->db->order_by('boat_id', 'desc');
				return $this->db->get('pt_boats')->result();
		}

		// Get all boats for extras
		function all_boats($id = null) {
				$this->db->select('boat_id as id,boat_title as title');
				if (!empty ($id)) {
						$this->db->where('boat_owned_by', $id);
				}
				$this->db->order_by('boat_id', 'desc');
				return $this->db->get('pt_boats')->result();
		}

		function convert_price($amount) {

		}

// get latest boats
		function latest_boats_front() {
				$settings = $this->Settings_model->get_front_settings('boats');
				$limit = $settings[0]->front_latest;
				$this->db->select('pt_boats.boat_status,pt_boats.boat_basic_price,pt_boats.boat_basic_discount,pt_boats.boat_id,pt_boats.boat_desc,pt_boats.boat_title,pt_boats.boat_slug,pt_boats.boat_type,pt_boats_types_settings.sett_name');
				$this->db->order_by('pt_boats.boat_id', 'desc');
				$this->db->where('pt_boats.boat_status', 'Yes');
				$this->db->join('pt_boats_types_settings', 'pt_boats.boat_type = pt_boats_types_settings.sett_id', 'left');
				$this->db->limit($limit);
				return $this->db->get('pt_boats')->result();
		}

// get all data of single boat by slug
		function get_boat_data($boatname) {
				$this->db->select('pt_boats.*');
				$this->db->where('pt_boats.boat_slug', $boatname);

				return $this->db->get('pt_boats')->result();
		}

// get all boats info
		function get_all_boats_back($id = null) {
				$this->db->select('pt_boats.boat_featured_forever,pt_boats.boat_id,pt_boats.boat_title,pt_boats.boat_slug,pt_boats.boat_owned_by,pt_boats.boat_order,pt_boats.boat_status,pt_boats.boat_is_featured,
    pt_boats.boat_featured_from,pt_boats.boat_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_boats_types_settings.sett_name');
// $this->db->where('pt_boat_images.timg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_boats.boat_owned_by', $id);
				}
				$this->db->order_by('pt_boats.boat_id', 'desc');
				$this->db->join('pt_accounts', 'pt_boats.boat_owned_by = pt_accounts.accounts_id', 'left');
//$this->db->join('pt_boat_images','pt_boats.boat_id = pt_boat_images.timg_boat_id','left');
				$query = $this->db->get('pt_boats');
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all boats info with limit
		function get_all_boats_back_limit($id = null, $perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_boats.boat_featured_forever,pt_boats.boat_id,pt_boats.boat_title,pt_boats.boat_slug,pt_boats.boat_created_at,pt_boats.boat_owned_by,pt_boats.boat_order,pt_boats.boat_status,pt_boats.boat_is_featured,
    pt_boats.boat_featured_from,pt_boats.boat_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_boats_types_settings.sett_name');
// $this->db->where('pt_boat_images.timg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_boats.boat_owned_by', $id);
				}
				$this->db->order_by('pt_boats.boat_id', 'desc');
				$this->db->join('pt_accounts', 'pt_boats.boat_owned_by = pt_accounts.accounts_id', 'left');
//  $this->db->join('pt_boat_images','pt_boats.boat_id = pt_boat_images.timg_boat_id','left');
				$query = $this->db->get('pt_boats', $perpage, $offset);
				$data['all'] = $query->result();
				return $data;
		}

// add boat data
		function add_boat($user = null) {
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

                $this->db->select("boat_id");
				$this->db->order_by("boat_id", "desc");
				$query = $this->db->get('pt_boats');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$boatlastid = 1;
				}
				else {
						$boatlastid = $lastid[0]->boat_id + 1;
				}

				$boatcount = $query->num_rows();
				$boatorder = $boatcount + 1;
				$this->db->select("boat_id");
				$this->db->where("boat_title", $this->input->post('boatname'));
				$queryc = $this->db->get('pt_boats')->num_rows();
				if ($queryc > 0) {
						$boatslug = create_url_slug($this->input->post('boatname')) . "-" . $boatlastid;
				}
				else {
						$boatslug = create_url_slug($this->input->post('boatname'));
				}
				$amenities = @ implode(",", $this->input->post('boatamenities'));
				$exclusions = @ implode(",", $this->input->post('boatexclusions'));
				$paymentopt = @ implode(",", $this->input->post('boatpayments'));
				$relatedboats = @ implode(",", $this->input->post('relatedboats'));


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
				$boatLocation = $location[0];

				$stars = $this->input->post('boatstars');
				if(empty($stars)){
					$stars = 0;
				}

				$data = array('boat_title' => $this->input->post('boatname'),
					'boat_slug' => $boatslug, 'boat_desc' => $this->input->post('boatdesc'),
					'boat_stars' => intval($stars),
					'boat_is_featured' => $featured,
					'boat_featured_from' => convert_to_unix($ffrom),
					'boat_featured_to' => convert_to_unix($fto),
					'boat_owned_by' => $user,
					'boat_type' => $this->input->post('boattype'),
					'boat_location' => $boatLocation,
					'boat_latitude' => $this->input->post('latitude'),
					'boat_longitude' => $this->input->post('longitude'),
					'boat_mapaddress' => $this->input->post('boatmapaddress'),
	                //'boat_basic_price' => $this->input->post('basic'),
					//'boat_basic_discount' => $this->input->post('discount'),
					'boat_meta_title' => $this->input->post('boatmetatitle'),
					'boat_meta_keywords' => $this->input->post('boatkeywords'),
					'boat_meta_desc' => $this->input->post('boatmetadesc'), 'boat_amenities' => $amenities,
					'boat_exclusions' => $exclusions, 'boat_payment_opt' => $paymentopt,
					'boat_max_adults' => intval($this->input->post('maxadult')),
					'boat_max_child' => intval($this->input->post('maxchild')),
					'boat_max_infant' => intval($this->input->post('maxinfant')),
					'boat_adult_price' => floatval($this->input->post('adultprice')),
					'boat_child_price' => floatval($this->input->post('childprice')),
					'boat_infant_price' => floatval($this->input->post('infantprice')),
					'adult_status' => intval($this->input->post('adultstatus')),
					'child_status' => intval($this->input->post('childstatus')),
					'infant_status' => intval($this->input->post('infantstatus')),
					'boat_days' => intval($this->input->post('boatdays')),
					'boat_nights' => intval($this->input->post('boatnights')),
					'boat_hours' => intval($this->input->post('boathours')),
					'boat_privacy' => $this->input->post('boatprivacy'),
					'boat_status' => $this->input->post('boatstatus'),
					'boat_related' => $relatedboats, 'boat_order' => $boatorder,
					'boat_comm_fixed' => $commfixed, 'boat_comm_percentage' => $commper,
					'boat_tax_fixed' => $taxfixed, 'boat_tax_percentage' => $taxper,
					'boat_email' => $this->input->post('boatemail'),
					'boat_phone' => $this->input->post('boatphone'),
					'boat_website' => $this->input->post('boatwebsite'),
					'boat_fulladdress' => $this->input->post('boatfulladdress'),
					'boat_featured_forever' => $isforever,
					'boat_created_at' => time());
				$this->db->insert('pt_boats', $data);
				$boatid = $this->db->insert_id();
				$this->updateboatLocations($this->input->post('locations'), $boatid);
				return $boatid;
		}

// update boat data
		function update_boat($id) {

				$boatcomm = $this->input->post('deposit');
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


				$this->db->select("boat_id");
				$this->db->where("boat_id !=", $id);
				$this->db->where("boat_title", $this->input->post('boatname'));
				$queryc = $this->db->get('pt_boats')->num_rows();
				if ($queryc > 0) {
						$boatslug = create_url_slug($this->input->post('boatname')) . "-" . $id;
				}
				else {
						$boatslug = create_url_slug($this->input->post('boatname'));
				}
				$amenities = @ implode(",", $this->input->post('boatamenities'));
				$exclusions = @ implode(",", $this->input->post('boatexclusions'));
				$paymentopt = @ implode(",", $this->input->post('boatpayments'));
				$relatedboats = @ implode(",", $this->input->post('relatedboats'));

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
				$boatLocation = $location[0];

				$stars = $this->input->post('boatstars');
				if(empty($stars)){
					$stars = 0;
				}

				$data = array('boat_title' => $this->input->post('boatname'),
					'boat_slug' => $boatslug, 'boat_desc' => $this->input->post('boatdesc'),
					'boat_stars' => intval($stars),
					'boat_is_featured' => $featured,
					'boat_featured_from' => convert_to_unix($ffrom),
					'boat_featured_to' => convert_to_unix($fto),
					'boat_type' => $this->input->post('boattype'),
					'boat_location' => $boatLocation,
					'boat_latitude' => $this->input->post('latitude'),
					'boat_longitude' => $this->input->post('longitude'),
					'boat_mapaddress' => $this->input->post('boatmapaddress'),
	                //'boat_basic_price' => $this->input->post('basic'),
					//'boat_basic_discount' => $this->input->post('discount'),
					'boat_meta_title' => $this->input->post('boatmetatitle'),
					'boat_meta_keywords' => $this->input->post('boatkeywords'),
					'boat_meta_desc' => $this->input->post('boatmetadesc'), 'boat_amenities' => $amenities,
					'boat_exclusions' => $exclusions, 'boat_payment_opt' => $paymentopt,
					'boat_max_adults' => intval($this->input->post('maxadult')),
					'boat_max_child' => intval($this->input->post('maxchild')),
					'boat_max_infant' => intval($this->input->post('maxinfant')),
					'boat_adult_price' => floatval($this->input->post('adultprice')),
					'boat_child_price' => floatval($this->input->post('childprice')),
					'boat_infant_price' => floatval($this->input->post('infantprice')),
					'adult_status' => intval($this->input->post('adultstatus')),
					'child_status' => intval($this->input->post('childstatus')),
					'infant_status' => intval($this->input->post('infantstatus')),
					'boat_days' => intval($this->input->post('boatdays')),
					'boat_hours' => intval($this->input->post('boathours')),
					'boat_nights' => intval($this->input->post('boatnights')),
					'boat_privacy' => $this->input->post('boatprivacy'),
					'boat_status' => $this->input->post('boatstatus'),
					'boat_related' => $relatedboats,
					'boat_comm_fixed' => $commfixed, 'boat_comm_percentage' => $commper,
					'boat_tax_fixed' => $taxfixed, 'boat_tax_percentage' => $taxper,
					'boat_email' => $this->input->post('boatemail'),
					'boat_phone' => $this->input->post('boatphone'),
					'boat_website' => $this->input->post('boatwebsite'),
					'boat_fulladdress' => $this->input->post('boatfulladdress'),
					'boat_featured_forever' => $isforever);
				$this->db->where('boat_id', $id);
				$this->db->update('pt_boats', $data);

				$this->updateboatLocations($this->input->post('locations'), $id);
	}

// Add boat settings data
		function add_settings_data() {
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'), 'sett_type' => $this->input->post('typeopt'));
				$this->db->insert('pt_boats_types_settings', $data);
		}

// update boat settings data
		function update_settings_data() {
				$id = $this->input->post('id');
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'));
				$this->db->where('sett_id', $id);
				$this->db->update('pt_boats_types_settings', $data);
		}

// Disable boat settings
		function disable_settings($id) {
				$data = array('sett_status' => 'No');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_boats_types_settings', $data);
		}

// Enable boat settings
		function enable_settings($id) {
				$data = array('sett_status' => 'Yes');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_boats_types_settings', $data);
		}

// Delete boat settings
		function delete_settings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_boats_types_settings');
		}

// get all boats for related selection for backend
		function select_related_boats($id = null) {
				$this->db->select('boat_title,boat_id');
				if (!empty ($id)) {
						$this->db->where('boat_id !=', $id);
				}
				return $this->db->get('pt_boats')->result();
		}

// Get boat settings data
		function get_boat_settings_data($type = 0) {
			if(!empty($type)){
             	$this->db->where('sett_type', $type);
		  }

				$this->db->order_by('sett_id', 'desc');
				return $this->db->get('pt_boats_types_settings')->result();
		}

// Get boat settings data for adding boat
		function get_tsettings_data($type) {
				$this->db->where('sett_type', $type);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_boats_types_settings')->result();
		}

// Get boat settings data for adding boat
		function get_tsettings_data_front($type, $items) {
				$this->db->where('sett_type', $type);
				$this->db->where_in('sett_id', $items);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_boats_types_settings')->result();
		}

// add boat images by type
		function add_boat_image($type, $filename, $boatid) {
				$imgorder = 0;
				if ($type == "slider") {
						$this->db->where('timg_type', 'slider');
						$this->db->where('timg_boat_id', $boatid);
						$imgorder = $this->db->get('pt_boat_images')->num_rows();
						$imgorder = $imgorder + 1;
				}
				$this->db->where('timg_type', 'default');
				$this->db->where('timg_boat_id', $boatid);
				$hasdefault = $this->db->get('pt_boat_images')->num_rows();
				if ($hasdefault < 1) {
						$type = 'default';
				}
				$approval = pt_admin_gallery_approve();
				$data = array('timg_boat_id' => $boatid, 'timg_type' => $type, 'timg_image' => $filename, 'timg_order' => $imgorder, 'timg_approved' => $approval);
				$this->db->insert('pt_boat_images', $data);
		}

// update boat map order
		function update_map_order($id, $order) {
				$data = array('map_order' => $order);
				$this->db->where('map_id', $id);
				$this->db->update('pt_boats_maps', $data);
		}


// update boat order
		function update_boat_order($id, $order) {
				$data = array('boat_order' => $order);
				$this->db->where('boat_id', $id);
				$this->db->update('pt_boats', $data);
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



			 $data = array('boat_is_featured' => $isfeatured, 'boat_featured_forever' => $isforever);
				$this->db->where('boat_id', $id);
				$this->db->update('pt_boats', $data);
		}
// Disable boat

		public function disable_boat($id) {
				$data = array('boat_status' => 'No');
				$this->db->where('boat_id', $id);
				$this->db->update('pt_boats', $data);
		}
// Enable boat

		public function enable_boat($id) {
				$data = array('boat_status' => 'Yes');
				$this->db->where('boat_id', $id);
				$this->db->update('pt_boats', $data);
		}

// Delete boat
		function delete_boat($boatid) {
				$boatimages = $this->boat_images($boatid);
				foreach ($boatimages['all_slider'] as $sliderimg) {
						$this->delete_image($sliderimg->timg_image,$sliderimg->timg_id,$boatid);
				}


				$this->db->where('review_itemid', $boatid);
				$this->db->where('review_module', 'boats');
				$this->db->delete('pt_reviews');
				$this->db->where('map_boat_id', $boatid);
				$this->db->delete('pt_boats_maps');

				$this->db->where('item_id', $boatid);
                $this->db->delete('pt_boats_translation');

                $this->db->where('boat_id',$boatid);
            	$this->db->delete('pt_boat_locations');

				$this->db->where('boat_id', $boatid);
				$this->db->delete('pt_boats');
		}

// Get boat Images
		function boat_images($id) {
				$this->db->where('timg_boat_id', $id);
				$this->db->where('timg_type', 'default');
				$q = $this->db->get('pt_boat_images');
				$data['def_image'] = $q->result();
				$this->db->where('timg_type', 'slider');
				$this->db->order_by('timg_id', 'desc');
				$this->db->having('timg_boat_id', $id);
				$q = $this->db->get('pt_boat_images');
				$data['all_slider'] = $q->result();
				$data['slider_counts'] = $q->num_rows();
				return $data;
		}

//update boat thumbnail
		function update_thumb($oldthumb, $newthumb, $boatid) {
				$data = array('timg_type' => 'slider');
				$this->db->where('timg_id', $oldthumb);
				$this->db->where('timg_boat_id', $boatid);
				$this->db->update('pt_boat_images', $data);
				$data2 = array('timg_type' => 'default');
				$this->db->where('timg_id', $newthumb);
				$this->db->where('timg_boat_id', $boatid);
				$this->db->update('pt_boat_images', $data2);
		}

// Approve or reject Hotel Images
		function approve_reject_images() {
				$data = array('timg_approved' => $this->input->post('apprej'));
				$this->db->where('timg_id', $this->input->post('imgid'));
				$this->db->update('pt_boat_images', $data);
		}

// update image order
		function update_image_order($imgid, $order) {
				$data = array('timg_order' => $order);
				$this->db->where('timg_id', $imgid);
				$this->db->update('pt_boat_images', $data);
		}


// Delete boat Images
		function delete_image($imgname, $imgid, $boatid) {
				$this->db->where('timg_id', $imgid);
				$this->db->delete('pt_boat_images');
                $this->updateboatThumb($boatid,$imgname,"delete");
                @ unlink(PT_boatS_SLIDER_THUMB_UPLOAD . $imgname);
				@ unlink(PT_boatS_SLIDER_UPLOAD . $imgname);
		}

//update boat thumbnail
		function updateboatThumb($boatid,$imgname,$action) {
		  if($action == "delete"){
            $this->db->select('thumbnail_image');
            $this->db->where('thumbnail_image',$imgname);
            $this->db->where('boat_id',$boatid);
            $rs = $this->db->get('pt_boats')->num_rows();
            if($rs > 0){
              $data = array(
              'thumbnail_image' => PT_BLANK_IMG
              );
              $this->db->where('boat_id',$boatid);
              $this->db->update('pt_boats',$data);
            }
            }else{
              $data = array(
              'thumbnail_image' => $imgname
              );
              $this->db->where('boat_id',$boatid);
              $this->db->update('pt_boats',$data);
            }

		}




		function offers_data($id) {
				/*$this->db->where('offer_module', 'boats');
				$this->db->where('offer_item', $id);
				return $this->db->get('pt_special_offers')->result();*/
		}

		function add_to_map() {
				$maporder = 0;
				$boatid = $this->input->post('boatid');
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_boat_id', $boatid);
				$res = $this->db->get('pt_boats_maps')->num_rows();
				$addtype = $this->input->post('addtype');
				if ($addtype == "visit") {
						$maporder = $res + 1;
				}
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'), 'map_city_type' => $addtype, 'map_boat_id' => $boatid, 'map_order' => $maporder);
				$this->db->insert('pt_boats_maps', $data);
		}

		function update_boat_map() {
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'),);
				$this->db->where('map_id', $this->input->post('mapid'));
				$this->db->update('pt_boats_maps', $data);
		}

		function has_start_end_city($type, $boatid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', $type);
				$this->db->where('map_boat_id', $boatid);
				$nums = $this->db->get('pt_boats_maps')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

		function get_boat_map($boatid) {
				$this->db->where('map_boat_id', $boatid);
				return $this->db->get('pt_boats_maps')->result();
		}

		function delete_map_item($mapid) {
				$this->db->where('map_id', $mapid);
				$this->db->delete('pt_boats_maps');
		}

// get related boats for front-end
		function get_related_boats($boats) {
				$id = explode(",", $boats);
				$this->db->select('pt_boats.boat_title,pt_boats.boat_slug,pt_boats.boat_id,pt_boats.boat_basic_price,pt_boats.boat_basic_discount,pt_boats_types_settings.sett_name');
				$this->db->where_in('pt_boats.boat_id', $id);
/*  $this->db->where('pt_boat_images.timg_type','default');
$this->db->join('pt_boat_images','pt_boats.boat_id = pt_boat_images.timg_boat_id','left');*/
				$this->db->join('pt_boats_types_settings', 'pt_boats.boat_type = pt_boats_types_settings.sett_id', 'left');
				return $this->db->get('pt_boats')->result();
		}

// Check boat existence
		function boat_exists($slug) {
				$this->db->select('boat_id');
				$this->db->where('boat_slug', $slug);
				$this->db->where('boat_status', 'Yes');
				$nums = $this->db->get('pt_boats')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// List all boats on front listings page
		function list_boats_front($sprice = null, $perpage = null, $offset = null, $orderby = null) {
				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if ($orderby == "za") {
						$this->db->order_by('pt_boats.boat_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_boats.boat_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_boats.boat_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_boats.boat_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_boats.boat_order', 'asc');
				}
				$this->db->select('boat_id');
				$this->db->group_by('boat_id');

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_boats.boat_adult_price >=', $minp);
						$this->db->where('pt_boats.boat_adult_price <=', $maxp);
				}

				$this->db->where('boat_status', 'Yes');
				$query = $this->db->get('pt_boats', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// List all boats on front listings page by location
		function showboatsByLocation($locs, $sprice = null, $perpage = null, $offset = null, $orderby = null) {

				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if ($orderby == "za") {
						$this->db->order_by('pt_boats.boat_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_boats.boat_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_boats.boat_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_boats.boat_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_boats.boat_order', 'asc');
				}
				$this->db->select('boat_id');
				$this->db->group_by('boat_id');

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_boats.boat_adult_price >=', $minp);
						$this->db->where('pt_boats.boat_adult_price <=', $maxp);
				}

				if(is_array($locs)){
                $this->db->where_in('pt_boats.boat_location',$locs);
                }else{
                    $locs = str_replace('+', ' ', $locs);
                $this->db->where('pt_boats.boat_location',$locs);
                }

				$this->db->where('boat_status', 'Yes');
				$query = $this->db->get('pt_boats', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// Search boats from home page
		function search_boats_front($location = null, $sprice = null, $perpage = null, $offset = null, $orderby = null) {
				$this->load->helper('boats_front');
				$data = array();

				//$location = $this->input->get('location');

				$adults = $this->input->get('adults');
				$type = $this->input->get('type');

				//$sprice = $this->input->get('price');
				$stars = $this->input->get('stars');

				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_boats.boat_id,boat_type,boat_location,boat_adult_price,boat_title,boat_max_adults,boat_status,pt_boat_locations.*');
				if ($orderby == "za") {
						$this->db->order_by('pt_boats.boat_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_boats.boat_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_boats.boat_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_boats.boat_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_boats.boat_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_boats.boat_adult_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_boats.boat_adult_price', 'desc');
				}

				if(!empty($location)){
					//$this->db->like('pt_boats.boat_location', $location);
					$this->db->where('pt_boat_locations.location_id', $location);

				}


				if (!empty ($adults)) {
						$this->db->where('pt_boats.boat_max_adults >=', $adults);
				}

				if (!empty ($stars)) {
						$this->db->where('boat_stars', $stars);
				}



				if (!empty ($type)) {
						$this->db->where('pt_boats.boat_type', $type);
				}

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_boats.boat_adult_price >=', $minp);
						$this->db->where('pt_boats.boat_adult_price <=', $maxp);
				}
				$this->db->group_by('pt_boats.boat_id');
				$this->db->join('pt_boat_locations', 'pt_boats.boat_id = pt_boat_locations.boat_id');
				$this->db->where('pt_boats.boat_status', 'Yes');


		if(!empty($perpage)){

				$query = $this->db->get('pt_boats', $perpage, $offset);

				}else{

				$query = $this->db->get('pt_boats');

				}

				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

		function max_map_order($boatid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_boat_id', $boatid);
				return $this->db->get('pt_boats_maps')->num_rows();
		}

// get default image of boat
		function default_boat_img($id) {
				$this->db->where('timg_type', 'default');
				$this->db->where('timg_approved', '1');
				$this->db->where('timg_boat_id', $id);
				$res = $this->db->get('pt_boat_images')->result();
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
				$this->db->where('boat_slug', $cslug);
				$this->db->where('boat_id !=', $id);
				$nums = $this->db->get('pt_boats')->num_rows();
				if ($nums > 0) {
						$cslug = $cslug . "-" . $id;
				}
				else {
						$cslug = $cslug;
				}
				$data = array('boat_title' => $this->input->post('title'), 'boat_slug' => $cslug, 'boat_desc' => $this->input->post('desc'), 'boat_policy' => $this->input->post('policy'));
				$this->db->where('boat_id', $id);
				$this->db->update('pt_boats', $data);
				return $cslug;
		}

// Adds translation of some fields data
		function add_translation($postdata, $boatid) {
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
                'item_id' => $boatid,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_boats_translation', $data);
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
				$this->db->insert('pt_boats_translation', $data);

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
			    $this->db->update('pt_boats_translation', $data);
                }


              }

                }

		}

		 function getBackTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('item_id',$id);
            return $this->db->get('pt_boats_translation')->result();

        }

         function boatGallery($slug){

          $this->db->select('pt_boats.thumbnail_image as thumbnail,pt_boat_images.timg_id as id,pt_boat_images.timg_boat_id as itemid,pt_boat_images.timg_type as type,pt_boat_images.timg_image as image,pt_boat_images.timg_order as imgorder,pt_boat_images.timg_image as image,pt_boat_images.timg_approved as approved');
          $this->db->where('pt_boats.boat_slug',$slug);
          $this->db->join('pt_boat_images', 'pt_boats.boat_id = pt_boat_images.timg_boat_id', 'left');
          $this->db->order_by('pt_boat_images.timg_id','desc');
          return $this->db->get('pt_boats')->result();

        }

        function addPhotos($id,$filename){

         $this->db->select('thumbnail_image');
         $this->db->where('boat_id',$id);
         $rs = $this->db->get('pt_boats')->result();
         if($rs[0]->thumbnail_image == PT_BLANK_IMG){

               $data = array('thumbnail_image' => $filename);
               $this->db->where('boat_id',$id);
               $this->db->update('pt_boats',$data);
         }

        //add photos to boat images table
        $imgorder = 0;
        $this->db->where('timg_type', 'slider');
        $this->db->where('timg_boat_id', $id);
        $imgorder = $this->db->get('pt_boat_images')->num_rows();
        $imgorder = $imgorder + 1;

				$approval = pt_admin_gallery_approve();

		    	$insdata = array(
                'timg_boat_id' => $id,
                'timg_type' => 'slider',
                'timg_image' => $filename,
                'timg_order' => $imgorder,
                'timg_approved' => $approval
                );

				$this->db->insert('pt_boat_images', $insdata);


        }

        function assignboats($boats,$userid){

          if(!empty($boats)){
          $userboats = $this->userOwnedboats($userid);
                foreach($userboats as $tt){
                   if(!in_array($tt,$boats)){
                    $ddata = array(
                   'boat_owned_by' => '1'
                   );
                   $this->db->where('boat_id',$tt);
                   $this->db->update('pt_boats',$ddata);
                   }
                }

                foreach($boats as $t){
                   $data = array(
                   'boat_owned_by' => $userid
                   );
                   $this->db->where('boat_id',$t);
                   $this->db->update('pt_boats',$data);

                 }

                 }
        }

        function userOwnedboats($id){
          $result = array();
          if(!empty($id)){
          $this->db->where('boat_owned_by',$id);
          }

          $rs = $this->db->get('pt_boats')->result();
          if(!empty($rs)){
            foreach($rs as $r){
              $result[] = $r->boat_id;
            }
          }
          return $result;
        }

        // get number of photos of boat
		function photos_count($boatid) {
				$this->db->where('timg_boat_id', $boatid);
				return $this->db->get('pt_boat_images')->num_rows();
		}

		function updateboatSettings() {
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

		// get popular boats
		function popular_boats_front() {
				$settings = $this->Settings_model->get_front_settings('boats');
				$limit = $settings[0]->front_popular;
				$orderby = $settings[0]->front_popular_order;

                $this->db->select('pt_boats.boat_id,pt_boats.boat_status,pt_reviews.review_overall,pt_reviews.review_itemid');

                $this->db->select_avg('pt_reviews.review_overall', 'overall');
				$this->db->order_by('overall', 'desc');
				$this->db->group_by('pt_boats.boat_id');
				$this->db->join('pt_reviews', 'pt_boats.boat_id = pt_reviews.review_itemid');
				$this->db->where('boat_status', 'yes');
				$this->db->limit($limit);
			   	return $this->db->get('pt_boats')->result();
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
				$this->db->insert('pt_boats_types_settings', $data);
                return $this->db->insert_id();
                $this->session->set_flashdata('flashmsgs', "Updated Successfully");

		}

// update boat settings data
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
				$this->db->update('pt_boats_types_settings', $data);
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
				$this->db->insert('pt_boats_types_settings_translation', $data);

                }else{

                 $data = array(
                'trans_name' => $name
                );
				$this->db->where('sett_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_boats_types_settings_translation', $data);

              }


              }

                }
		}


         function getBackSettingsTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_boats_types_settings_translation')->result();

        }

        // Delete hotel settings
		function deleteTypeSettings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_boats_types_settings');

                $this->db->where('sett_id', $id);
				$this->db->delete('pt_boats_types_settings_translation');
		}

				// Delete multiple boat settings
		function deleteMultiplesettings($id, $type) {
				$this->db->where('sett_id', $id);
				$this->db->where('sett_type',$type);
				$this->db->delete('pt_boats_types_settings');

				$rowsDeleted = $this->db->affected_rows();

				if($rowsDeleted > 0){
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_boats_types_settings_translation');
				}


		}

         function getTypesTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_boats_types_settings_translation')->result();

        }

        function updateboatLocations($locations, $boatid){

        	$this->db->where('boat_id',$boatid);
        	$this->db->delete('pt_boat_locations');
        	$position = 0;

        	foreach($locations as $loc){

        		if(!empty($loc)){
        			$position++;
        			$data = array('position' => $position,'location_id' => $loc, 'boat_id' => $boatid);
        			$this->db->insert('pt_boat_locations', $data);
        		}
        	}

        }

        function isboatLocation($i, $locid, $boatid){
        	$this->db->where('position', $i);
        	$this->db->where('location_id', $locid);
        	$this->db->where('boat_id', $boatid);
        	$rs = $this->db->get('pt_boat_locations')->num_rows();
        	if($rs > 0){
        		return "selected";
        	}else{
        		return "";
        	}
        }

        function boatSelectedLocations($boatid){
          $result = array();
          $this->db->where('boat_id', $boatid);
          $res = $this->db->get('pt_boat_locations')->result();
          foreach($res as $r){
            $locInfo = pt_LocationsInfo($r->location_id);
            $result[$r->position] = (object)array('id' => $r->location_id,'name' => $locInfo->city.", ".$locInfo->country);
          }
         return $result;

        }

        public function getpackages($id)
        {
        $this->db->order_by('id', 'DESC');  //actual field name of id
        $this->db->where('boat_id',$id);
        $query=$this->db->get('pt_boats_packages');
        return $query->result();
        }
        public function getpackage($id)
        {
        $this->db->where('id',$id);
        $query=$this->db->get('pt_boats_packages');
        return $query->row();
        }

        public function suppilerboat($owned_id){
            $this->db->where('boat_owned_by',$owned_id);
            return $this->db->get('pt_boats')->result();
        }

    public function checkbooking($id){
        $data = str_replace('/','-',$_GET['checkin']);
        $da =  date("Y-m-d", strtotime($data));
        $this->db->where('booking_type','boats');
        $this->db->where('booking_item',$id);
        $this->db->where('booking_checkin',$da);
        $this->db->where('booking_status','paid');
        return $this->db->get('pt_bookings')->result();
    }
}
