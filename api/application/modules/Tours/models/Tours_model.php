<?php

class Tours_model extends CI_Model {
        public $langdef;
		function __construct() {
// Call the Model constructor
				parent :: __construct();
                $this->langdef = DEFLANG;
		}

// Get all enabled tours short info
		function shortInfo($id = null) {
				$result = array();
				$this->db->select('tour_id,tour_title,tour_slug');
				if (!empty ($id)) {
						$this->db->where('tour_owned_by', $id);
				}
				$this->db->where('tour_status', 'Yes');
				$this->db->order_by('tour_id', 'desc');
				$tours = $this->db->get('pt_tours')->result();
				foreach($tours as $tour){
					$result[] = (object)array('id' => $tour->tour_id, 'title' => $tour->tour_title, 'slug' => $tour->tour_slug);
				}

				return $result;
		}

// Get all tours id and names only
		function all_tours_names($id = null) {
				$this->db->select('tour_id,tour_title');
				if (!empty ($id)) {
						$this->db->where('tour_owned_by', $id);
				}
				$this->db->order_by('tour_id', 'desc');
				return $this->db->get('pt_tours')->result();
		}

		// Get all tours for extras
		function all_tours($id = null) {
				$this->db->select('tour_id as id,tour_title as title');
				if (!empty ($id)) {
						$this->db->where('tour_owned_by', $id);
				}
				$this->db->order_by('tour_id', 'desc');
				return $this->db->get('pt_tours')->result();
		}

		function convert_price($amount) {

		}

// get latest tours
		function latest_tours_front() {
				$settings = $this->Settings_model->get_front_settings('tours');
				$limit = $settings[0]->front_latest;
				$this->db->select('pt_tours.tour_status,pt_tours.tour_basic_price,pt_tours.tour_basic_discount,pt_tours.tour_id,pt_tours.tour_desc,pt_tours.tour_title,pt_tours.tour_slug,pt_tours.tour_type,pt_tours_types_settings.sett_name');
				$this->db->order_by('pt_tours.tour_id', 'desc');
				$this->db->where('pt_tours.tour_status', 'Yes');
				$this->db->join('pt_tours_types_settings', 'pt_tours.tour_type = pt_tours_types_settings.sett_id', 'left');
				$this->db->limit($limit);
				return $this->db->get('pt_tours')->result();
		}

// get all data of single tour by slug
		function get_tour_data($tourname) {
				$this->db->select('pt_tours.*');
				$this->db->where('pt_tours.tour_slug', $tourname);

				return $this->db->get('pt_tours')->result();
		}

// get all tours info
		function get_all_tours_back($id = null) {
				$this->db->select('pt_tours.tour_featured_forever,pt_tours.tour_id,pt_tours.tour_title,pt_tours.tour_slug,pt_tours.tour_owned_by,pt_tours.tour_order,pt_tours.tour_status,pt_tours.tour_is_featured,
    pt_tours.tour_featured_from,pt_tours.tour_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_tours_types_settings.sett_name');
// $this->db->where('pt_tour_images.timg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_tours.tour_owned_by', $id);
				}
				$this->db->order_by('pt_tours.tour_id', 'desc');
				$this->db->join('pt_accounts', 'pt_tours.tour_owned_by = pt_accounts.accounts_id', 'left');
//$this->db->join('pt_tour_images','pt_tours.tour_id = pt_tour_images.timg_tour_id','left');
				$query = $this->db->get('pt_tours');
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all tours info with limit
		function get_all_tours_back_limit($id = null, $perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_tours.tour_featured_forever,pt_tours.tour_id,pt_tours.tour_title,pt_tours.tour_slug,pt_tours.tour_created_at,pt_tours.tour_owned_by,pt_tours.tour_order,pt_tours.tour_status,pt_tours.tour_is_featured,
    pt_tours.tour_featured_from,pt_tours.tour_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_tours_types_settings.sett_name');
// $this->db->where('pt_tour_images.timg_type','default');
				if (!empty ($id)) {
						$this->db->where('pt_tours.tour_owned_by', $id);
				}
				$this->db->order_by('pt_tours.tour_id', 'desc');
				$this->db->join('pt_accounts', 'pt_tours.tour_owned_by = pt_accounts.accounts_id', 'left');
//  $this->db->join('pt_tour_images','pt_tours.tour_id = pt_tour_images.timg_tour_id','left');
				$query = $this->db->get('pt_tours', $perpage, $offset);
				$data['all'] = $query->result();
				return $data;
		}

// add tour data
		function add_tour($user = null) {
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

                $this->db->select("tour_id");
				$this->db->order_by("tour_id", "desc");
				$query = $this->db->get('pt_tours');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$tourlastid = 1;
				}
				else {
						$tourlastid = $lastid[0]->tour_id + 1;
				}

				$tourcount = $query->num_rows();
				$tourorder = $tourcount + 1;
				$this->db->select("tour_id");
				$this->db->where("tour_title", $this->input->post('tourname'));
				$queryc = $this->db->get('pt_tours')->num_rows();
				if ($queryc > 0) {
						$tourslug = create_url_slug($this->input->post('tourname')) . "-" . $tourlastid;
				}
				else {
						$tourslug = create_url_slug($this->input->post('tourname'));
				}
				$amenities = @ implode(",", $this->input->post('touramenities'));
				$exclusions = @ implode(",", $this->input->post('tourexclusions'));
				$paymentopt = @ implode(",", $this->input->post('tourpayments'));
				$relatedtours = @ implode(",", $this->input->post('relatedtours'));


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
				$tourLocation = $location[0];

				$stars = $this->input->post('tourstars');
				if(empty($stars)){
					$stars = 0;
				}

				$data = array('tour_title' => $this->input->post('tourname'),
					'tour_slug' => $tourslug, 'tour_desc' => $this->input->post('tourdesc'),
					'tour_stars' => intval($stars),
					'tour_is_featured' => $featured,
					'tour_featured_from' => convert_to_unix($ffrom),
					'tour_featured_to' => convert_to_unix($fto),
					'tour_owned_by' => $user,
					'tour_type' => $this->input->post('tourtype'),
					'tour_location' => $tourLocation,
					'tour_latitude' => $this->input->post('latitude'),
					'tour_longitude' => $this->input->post('longitude'),
					'tour_mapaddress' => $this->input->post('tourmapaddress'),
	                //'tour_basic_price' => $this->input->post('basic'),
					//'tour_basic_discount' => $this->input->post('discount'),
					'tour_meta_title' => $this->input->post('tourmetatitle'),
					'tour_meta_keywords' => $this->input->post('tourkeywords'),
					'tour_meta_desc' => $this->input->post('tourmetadesc'), 'tour_amenities' => $amenities,
					'tour_exclusions' => $exclusions, 'tour_payment_opt' => $paymentopt,
					'tour_max_adults' => intval($this->input->post('maxadult')),
					'tour_max_child' => intval($this->input->post('maxchild')),
					'tour_max_infant' => intval($this->input->post('maxinfant')),
					'tour_adult_price' => floatval($this->input->post('adultprice')),
					'tour_child_price' => floatval($this->input->post('childprice')),
					'tour_infant_price' => floatval($this->input->post('infantprice')),
					'adult_status' => intval($this->input->post('adultstatus')),
					'child_status' => intval($this->input->post('childstatus')),
					'infant_status' => intval($this->input->post('infantstatus')),
					'tour_days' => intval($this->input->post('tourdays')),
					'tour_nights' => intval($this->input->post('tournights')),
					'tour_hours' => intval($this->input->post('tourhours')),
					'tour_privacy' => $this->input->post('tourprivacy'),
					'tour_status' => $this->input->post('tourstatus'),
					'tour_related' => $relatedtours, 'tour_order' => $tourorder,
					'tour_comm_fixed' => $commfixed, 'tour_comm_percentage' => $commper,
					'tour_tax_fixed' => $taxfixed, 'tour_tax_percentage' => $taxper,
					'tour_email' => $this->input->post('touremail'),
					'tour_phone' => $this->input->post('tourphone'),
					'tour_website' => $this->input->post('tourwebsite'),
					'tour_fulladdress' => $this->input->post('tourfulladdress'),
					'tour_featured_forever' => $isforever,
					'tour_created_at' => time());
				$this->db->insert('pt_tours', $data);
				$tourid = $this->db->insert_id();
				$this->updateTourLocations($this->input->post('locations'), $tourid);
				return $tourid;
		}

// update tour data
		function update_tour($id) {

				$tourcomm = $this->input->post('deposit');
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


				$this->db->select("tour_id");
				$this->db->where("tour_id !=", $id);
				$this->db->where("tour_title", $this->input->post('tourname'));
				$queryc = $this->db->get('pt_tours')->num_rows();
				if ($queryc > 0) {
						$tourslug = create_url_slug($this->input->post('tourname')) . "-" . $id;
				}
				else {
						$tourslug = create_url_slug($this->input->post('tourname'));
				}
				$amenities = @ implode(",", $this->input->post('touramenities'));
				$exclusions = @ implode(",", $this->input->post('tourexclusions'));
				$paymentopt = @ implode(",", $this->input->post('tourpayments'));
				$relatedtours = @ implode(",", $this->input->post('relatedtours'));

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
				$tourLocation = $location[0];

				$stars = $this->input->post('tourstars');
				if(empty($stars)){
					$stars = 0;
				}

				$data = array('tour_title' => $this->input->post('tourname'),
					'tour_slug' => $tourslug, 'tour_desc' => $this->input->post('tourdesc'),
					'tour_stars' => intval($stars),
					'tour_is_featured' => $featured,
					'tour_featured_from' => convert_to_unix($ffrom),
					'tour_featured_to' => convert_to_unix($fto),
					'tour_type' => $this->input->post('tourtype'),
					'tour_location' => $tourLocation,
					'tour_latitude' => $this->input->post('latitude'),
					'tour_longitude' => $this->input->post('longitude'),
					'tour_mapaddress' => $this->input->post('tourmapaddress'),
	                //'tour_basic_price' => $this->input->post('basic'),
					//'tour_basic_discount' => $this->input->post('discount'),
					'tour_meta_title' => $this->input->post('tourmetatitle'),
					'tour_meta_keywords' => $this->input->post('tourkeywords'),
					'tour_meta_desc' => $this->input->post('tourmetadesc'), 'tour_amenities' => $amenities,
					'tour_exclusions' => $exclusions, 'tour_payment_opt' => $paymentopt,
					'tour_max_adults' => intval($this->input->post('maxadult')),
					'tour_max_child' => intval($this->input->post('maxchild')),
					'tour_max_infant' => intval($this->input->post('maxinfant')),
					'tour_adult_price' => floatval($this->input->post('adultprice')),
					'tour_child_price' => floatval($this->input->post('childprice')),
					'tour_infant_price' => floatval($this->input->post('infantprice')),
					'adult_status' => intval($this->input->post('adultstatus')),
					'child_status' => intval($this->input->post('childstatus')),
					'infant_status' => intval($this->input->post('infantstatus')),
					'tour_days' => intval($this->input->post('tourdays')),
					'tour_hours' => intval($this->input->post('tourhours')),
					'tour_nights' => intval($this->input->post('tournights')),
					'tour_privacy' => $this->input->post('tourprivacy'),
					'tour_status' => $this->input->post('tourstatus'),
					'tour_related' => $relatedtours,
					'tour_comm_fixed' => $commfixed, 'tour_comm_percentage' => $commper,
					'tour_tax_fixed' => $taxfixed, 'tour_tax_percentage' => $taxper,
					'tour_email' => $this->input->post('touremail'),
					'tour_phone' => $this->input->post('tourphone'),
					'tour_website' => $this->input->post('tourwebsite'),
					'tour_fulladdress' => $this->input->post('tourfulladdress'),
					'tour_featured_forever' => $isforever);
				$this->db->where('tour_id', $id);
				$this->db->update('pt_tours', $data);

				$this->updateTourLocations($this->input->post('locations'), $id);
	}

// Add tour settings data
		function add_settings_data() {
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'), 'sett_type' => $this->input->post('typeopt'));
				$this->db->insert('pt_tours_types_settings', $data);
		}

// update tour settings data
		function update_settings_data() {
				$id = $this->input->post('id');
				$data = array('sett_name' => $this->input->post('name'), 'sett_status' => $this->input->post('statusopt'), 'sett_selected' => $this->input->post('selectopt'));
				$this->db->where('sett_id', $id);
				$this->db->update('pt_tours_types_settings', $data);
		}

// Disable tour settings
		function disable_settings($id) {
				$data = array('sett_status' => 'No');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_tours_types_settings', $data);
		}

// Enable tour settings
		function enable_settings($id) {
				$data = array('sett_status' => 'Yes');
				$this->db->where('sett_id', $id);
				$this->db->update('pt_tours_types_settings', $data);
		}

// Delete tour settings
		function delete_settings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_tours_types_settings');
		}

// get all tours for related selection for backend
		function select_related_tours($id = null) {
				$this->db->select('tour_title,tour_id');
				if (!empty ($id)) {
						$this->db->where('tour_id !=', $id);
				}
				return $this->db->get('pt_tours')->result();
		}

// Get tour settings data
		function get_tour_settings_data($type = 0) {
			if(!empty($type)){
             	$this->db->where('sett_type', $type);
		  }

				$this->db->order_by('sett_id', 'desc');
				return $this->db->get('pt_tours_types_settings')->result();
		}

// Get tour settings data for adding tour
		function get_tsettings_data($type) {
				$this->db->where('sett_type', $type);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_tours_types_settings')->result();
		}

// Get tour settings data for adding tour
		function get_tsettings_data_front($type, $items) {
				$this->db->where('sett_type', $type);
				$this->db->where_in('sett_id', $items);
				$this->db->where('sett_status', 'Yes');
				return $this->db->get('pt_tours_types_settings')->result();
		}

// add Tour images by type
		function add_tour_image($type, $filename, $tourid) {
				$imgorder = 0;
				if ($type == "slider") {
						$this->db->where('timg_type', 'slider');
						$this->db->where('timg_tour_id', $tourid);
						$imgorder = $this->db->get('pt_tour_images')->num_rows();
						$imgorder = $imgorder + 1;
				}
				$this->db->where('timg_type', 'default');
				$this->db->where('timg_tour_id', $tourid);
				$hasdefault = $this->db->get('pt_tour_images')->num_rows();
				if ($hasdefault < 1) {
						$type = 'default';
				}
				$approval = pt_admin_gallery_approve();
				$data = array('timg_tour_id' => $tourid, 'timg_type' => $type, 'timg_image' => $filename, 'timg_order' => $imgorder, 'timg_approved' => $approval);
				$this->db->insert('pt_tour_images', $data);
		}

// update tour map order
		function update_map_order($id, $order) {
				$data = array('map_order' => $order);
				$this->db->where('map_id', $id);
				$this->db->update('pt_tours_maps', $data);
		}


// update tour order
		function update_tour_order($id, $order) {
				$data = array('tour_order' => $order);
				$this->db->where('tour_id', $id);
				$this->db->update('pt_tours', $data);
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



			 $data = array('tour_is_featured' => $isfeatured, 'tour_featured_forever' => $isforever);
				$this->db->where('tour_id', $id);
				$this->db->update('pt_tours', $data);
		}
// Disable Tour

		public function disable_tour($id) {
				$data = array('tour_status' => 'No');
				$this->db->where('tour_id', $id);
				$this->db->update('pt_tours', $data);
		}
// Enable Tour

		public function enable_tour($id) {
				$data = array('tour_status' => 'Yes');
				$this->db->where('tour_id', $id);
				$this->db->update('pt_tours', $data);
		}

// Delete tour
		function delete_tour($tourid) {
				$tourimages = $this->tour_images($tourid);
				foreach ($tourimages['all_slider'] as $sliderimg) {
						$this->delete_image($sliderimg->timg_image,$sliderimg->timg_id,$tourid);
				}


				$this->db->where('review_itemid', $tourid);
				$this->db->where('review_module', 'tours');
				$this->db->delete('pt_reviews');
				$this->db->where('map_tour_id', $tourid);
				$this->db->delete('pt_tours_maps');

				$this->db->where('item_id', $tourid);
                $this->db->delete('pt_tours_translation');

                $this->db->where('tour_id',$tourid);
            	$this->db->delete('pt_tour_locations');

				$this->db->where('tour_id', $tourid);
				$this->db->delete('pt_tours');
		}

// Get Tour Images
		function tour_images($id) {
				$this->db->where('timg_tour_id', $id);
				$this->db->where('timg_type', 'default');
				$q = $this->db->get('pt_tour_images');
				$data['def_image'] = $q->result();
				$this->db->where('timg_type', 'slider');
				$this->db->order_by('timg_id', 'desc');
				$this->db->having('timg_tour_id', $id);
				$q = $this->db->get('pt_tour_images');
				$data['all_slider'] = $q->result();
				$data['slider_counts'] = $q->num_rows();
				return $data;
		}

//update tour thumbnail
		function update_thumb($oldthumb, $newthumb, $tourid) {
				$data = array('timg_type' => 'slider');
				$this->db->where('timg_id', $oldthumb);
				$this->db->where('timg_tour_id', $tourid);
				$this->db->update('pt_tour_images', $data);
				$data2 = array('timg_type' => 'default');
				$this->db->where('timg_id', $newthumb);
				$this->db->where('timg_tour_id', $tourid);
				$this->db->update('pt_tour_images', $data2);
		}

// Approve or reject Hotel Images
		function approve_reject_images() {
				$data = array('timg_approved' => $this->input->post('apprej'));
				$this->db->where('timg_id', $this->input->post('imgid'));
				$this->db->update('pt_tour_images', $data);
		}

// update image order
		function update_image_order($imgid, $order) {
				$data = array('timg_order' => $order);
				$this->db->where('timg_id', $imgid);
				$this->db->update('pt_tour_images', $data);
		}


// Delete tour Images
		function delete_image($imgname, $imgid, $tourid) {
				$this->db->where('timg_id', $imgid);
				$this->db->delete('pt_tour_images');
                $this->updateTourThumb($tourid,$imgname,"delete");
                @ unlink(PT_TOURS_SLIDER_THUMB_UPLOAD . $imgname);
				@ unlink(PT_TOURS_SLIDER_UPLOAD . $imgname);
		}

//update tour thumbnail
		function updateTourThumb($tourid,$imgname,$action) {
		  if($action == "delete"){
            $this->db->select('thumbnail_image');
            $this->db->where('thumbnail_image',$imgname);
            $this->db->where('tour_id',$tourid);
            $rs = $this->db->get('pt_tours')->num_rows();
            if($rs > 0){
              $data = array(
              'thumbnail_image' => PT_BLANK_IMG
              );
              $this->db->where('tour_id',$tourid);
              $this->db->update('pt_tours',$data);
            }
            }else{
              $data = array(
              'thumbnail_image' => $imgname
              );
              $this->db->where('tour_id',$tourid);
              $this->db->update('pt_tours',$data);
            }

		}




		function offers_data($id) {
				/*$this->db->where('offer_module', 'tours');
				$this->db->where('offer_item', $id);
				return $this->db->get('pt_special_offers')->result();*/
		}

		function add_to_map() {
				$maporder = 0;
				$tourid = $this->input->post('tourid');
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_tour_id', $tourid);
				$res = $this->db->get('pt_tours_maps')->num_rows();
				$addtype = $this->input->post('addtype');
				if ($addtype == "visit") {
						$maporder = $res + 1;
				}
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'), 'map_city_type' => $addtype, 'map_tour_id' => $tourid, 'map_order' => $maporder);
				$this->db->insert('pt_tours_maps', $data);
		}

		function update_tour_map() {
				$data = array('map_city_name' => $this->input->post('citytitle'), 'map_city_lat' => $this->input->post('citylat'), 'map_city_long' => $this->input->post('citylong'),);
				$this->db->where('map_id', $this->input->post('mapid'));
				$this->db->update('pt_tours_maps', $data);
		}

		function has_start_end_city($type, $tourid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', $type);
				$this->db->where('map_tour_id', $tourid);
				$nums = $this->db->get('pt_tours_maps')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

		function get_tour_map($tourid) {
				$this->db->where('map_tour_id', $tourid);
				return $this->db->get('pt_tours_maps')->result();
		}

		function delete_map_item($mapid) {
				$this->db->where('map_id', $mapid);
				$this->db->delete('pt_tours_maps');
		}

// get related tours for front-end
		function get_related_tours($tours) {
				$id = explode(",", $tours);
				$this->db->select('pt_tours.tour_title,pt_tours.tour_slug,pt_tours.tour_id,pt_tours.tour_basic_price,pt_tours.tour_basic_discount,pt_tours_types_settings.sett_name');
				$this->db->where_in('pt_tours.tour_id', $id);
/*  $this->db->where('pt_tour_images.timg_type','default');
$this->db->join('pt_tour_images','pt_tours.tour_id = pt_tour_images.timg_tour_id','left');*/
				$this->db->join('pt_tours_types_settings', 'pt_tours.tour_type = pt_tours_types_settings.sett_id', 'left');
				return $this->db->get('pt_tours')->result();
		}

// Check tour existence
		function tour_exists($slug) {
				$this->db->select('tour_id');
				$this->db->where('tour_slug', $slug);
				$this->db->where('tour_status', 'Yes');
				$nums = $this->db->get('pt_tours')->num_rows();
				if ($nums > 0) {
						return true;
				}
				else {
						return false;
				}
		}

// List all tours on front listings page
		function list_tours_front($sprice = null, $perpage = null, $offset = null, $orderby = null) {
				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if ($orderby == "za") {
						$this->db->order_by('pt_tours.tour_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_tours.tour_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_tours.tour_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_tours.tour_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_tours.tour_order', 'asc');
				}
				$this->db->select('tour_id');
				$this->db->group_by('tour_id');

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_tours.tour_adult_price >=', $minp);
						$this->db->where('pt_tours.tour_adult_price <=', $maxp);
				}

				$this->db->where('tour_status', 'Yes');
				$query = $this->db->get('pt_tours', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// List all tours on front listings page by location
		function showToursByLocation($locs, $sprice = null, $perpage = null, $offset = null, $orderby = null) {

				$data = array();
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if ($orderby == "za") {
						$this->db->order_by('pt_tours.tour_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_tours.tour_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_tours.tour_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_tours.tour_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_tours.tour_order', 'asc');
				}
				$this->db->select('tour_id');
				$this->db->group_by('tour_id');

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_tours.tour_adult_price >=', $minp);
						$this->db->where('pt_tours.tour_adult_price <=', $maxp);
				}

				if(is_array($locs)){
                $this->db->where_in('pt_tours.tour_location',$locs);
                }else{
                    $locs = str_replace('+', ' ', $locs);
                $this->db->where('pt_tours.tour_location',$locs);
                }

				$this->db->where('tour_status', 'Yes');
				$query = $this->db->get('pt_tours', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

// Search tours from home page
		function search_tours_front($location = null, $sprice = null, $perpage = null, $offset = null, $orderby = null) {
				$this->load->helper('tours_front');
				$data = array();

				//$location = $this->input->get('location');

				$adults = $this->input->get('adults');
				$type = $this->input->get('type');

				//$sprice = $this->input->get('price');
				$stars = $this->input->get('stars');

				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_tours.tour_id,tour_type,tour_location,tour_adult_price,tour_title,tour_max_adults,tour_status,pt_tour_locations.*');
				if ($orderby == "za") {
						$this->db->order_by('pt_tours.tour_title', 'desc');
				}
				elseif ($orderby == "az") {
						$this->db->order_by('pt_tours.tour_title', 'asc');
				}
				elseif ($orderby == "oldf") {
						$this->db->order_by('pt_tours.tour_id', 'asc');
				}
				elseif ($orderby == "newf") {
						$this->db->order_by('pt_tours.tour_id', 'desc');
				}
				elseif ($orderby == "ol") {
						$this->db->order_by('pt_tours.tour_order', 'asc');
				}
				elseif ($orderby == "p_lh") {
						$this->db->order_by('pt_tours.tour_adult_price', 'asc');
				}
				elseif ($orderby == "p_hl") {
						$this->db->order_by('pt_tours.tour_adult_price', 'desc');
				}

				if(!empty($location)){
					//$this->db->like('pt_tours.tour_location', $location);
					$this->db->where('pt_tour_locations.location_id', $location);

				}


				if (!empty ($adults)) {
						$this->db->where('pt_tours.tour_max_adults >=', $adults);
				}

				if (!empty ($stars)) {
						$this->db->where('tour_stars', $stars);
				}



				if (!empty ($type)) {
						$this->db->where('pt_tours.tour_type', $type);
				}

				if (!empty ($sprice)) {
						$sprice = explode("-", $sprice);
						$minp = $sprice[0];
						$maxp = $sprice[1];
						$this->db->where('pt_tours.tour_adult_price >=', $minp);
						$this->db->where('pt_tours.tour_adult_price <=', $maxp);
				}
				$this->db->group_by('pt_tours.tour_id');
				$this->db->join('pt_tour_locations', 'pt_tours.tour_id = pt_tour_locations.tour_id');
				$this->db->where('pt_tours.tour_status', 'Yes');


		if(!empty($perpage)){

				$query = $this->db->get('pt_tours', $perpage, $offset);

				}else{

				$query = $this->db->get('pt_tours');

				}

				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}

		function max_map_order($tourid) {
				$this->db->select('map_id');
				$this->db->where('map_city_type', 'visit');
				$this->db->where('map_tour_id', $tourid);
				return $this->db->get('pt_tours_maps')->num_rows();
		}

// get default image of tour
		function default_tour_img($id) {
				$this->db->where('timg_type', 'default');
				$this->db->where('timg_approved', '1');
				$this->db->where('timg_tour_id', $id);
				$res = $this->db->get('pt_tour_images')->result();
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
				$this->db->where('tour_slug', $cslug);
				$this->db->where('tour_id !=', $id);
				$nums = $this->db->get('pt_tours')->num_rows();
				if ($nums > 0) {
						$cslug = $cslug . "-" . $id;
				}
				else {
						$cslug = $cslug;
				}
				$data = array('tour_title' => $this->input->post('title'), 'tour_slug' => $cslug, 'tour_desc' => $this->input->post('desc'), 'tour_policy' => $this->input->post('policy'));
				$this->db->where('tour_id', $id);
				$this->db->update('pt_tours', $data);
				return $cslug;
		}

// Adds translation of some fields data
		function add_translation($postdata, $tourid) {
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
                'item_id' => $tourid,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_tours_translation', $data);
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
				$this->db->insert('pt_tours_translation', $data);

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
			    $this->db->update('pt_tours_translation', $data);
                }


              }

                }

		}

		 function getBackTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('item_id',$id);
            return $this->db->get('pt_tours_translation')->result();

        }

         function tourGallery($slug){

          $this->db->select('pt_tours.thumbnail_image as thumbnail,pt_tour_images.timg_id as id,pt_tour_images.timg_tour_id as itemid,pt_tour_images.timg_type as type,pt_tour_images.timg_image as image,pt_tour_images.timg_order as imgorder,pt_tour_images.timg_image as image,pt_tour_images.timg_approved as approved');
          $this->db->where('pt_tours.tour_slug',$slug);
          $this->db->join('pt_tour_images', 'pt_tours.tour_id = pt_tour_images.timg_tour_id', 'left');
          $this->db->order_by('pt_tour_images.timg_id','desc');
          return $this->db->get('pt_tours')->result();

        }

        function addPhotos($id,$filename){

         $this->db->select('thumbnail_image');
         $this->db->where('tour_id',$id);
         $rs = $this->db->get('pt_tours')->result();
         if($rs[0]->thumbnail_image == PT_BLANK_IMG){

               $data = array('thumbnail_image' => $filename);
               $this->db->where('tour_id',$id);
               $this->db->update('pt_tours',$data);
         }

        //add photos to tour images table
        $imgorder = 0;
        $this->db->where('timg_type', 'slider');
        $this->db->where('timg_tour_id', $id);
        $imgorder = $this->db->get('pt_tour_images')->num_rows();
        $imgorder = $imgorder + 1;

				$approval = pt_admin_gallery_approve();

		    	$insdata = array(
                'timg_tour_id' => $id,
                'timg_type' => 'slider',
                'timg_image' => $filename,
                'timg_order' => $imgorder,
                'timg_approved' => $approval
                );

				$this->db->insert('pt_tour_images', $insdata);


        }

        function assignTours($tours,$userid){

          if(!empty($tours)){
          $usertours = $this->userOwnedTours($userid);
                foreach($usertours as $tt){
                   if(!in_array($tt,$tours)){
                    $ddata = array(
                   'tour_owned_by' => '1'
                   );
                   $this->db->where('tour_id',$tt);
                   $this->db->update('pt_tours',$ddata);
                   }
                }

                foreach($tours as $t){
                   $data = array(
                   'tour_owned_by' => $userid
                   );
                   $this->db->where('tour_id',$t);
                   $this->db->update('pt_tours',$data);

                 }

                 }
        }

        function userOwnedTours($id){
          $result = array();
          if(!empty($id)){
          $this->db->where('tour_owned_by',$id);
          }

          $rs = $this->db->get('pt_tours')->result();
          if(!empty($rs)){
            foreach($rs as $r){
              $result[] = $r->tour_id;
            }
          }
          return $result;
        }

        // get number of photos of tour
		function photos_count($tourid) {
				$this->db->where('timg_tour_id', $tourid);
				return $this->db->get('pt_tour_images')->num_rows();
		}

		function updateTourSettings() {
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

		// get popular tours
		function popular_tours_front() {
				$settings = $this->Settings_model->get_front_settings('tours');
				$limit = $settings[0]->front_popular;
				$orderby = $settings[0]->front_popular_order;

                $this->db->select('pt_tours.tour_id,pt_tours.tour_status,pt_reviews.review_overall,pt_reviews.review_itemid');

                $this->db->select_avg('pt_reviews.review_overall', 'overall');
				$this->db->order_by('overall', 'desc');
				$this->db->group_by('pt_tours.tour_id');
				$this->db->join('pt_reviews', 'pt_tours.tour_id = pt_reviews.review_itemid');
				$this->db->where('tour_status', 'yes');
				$this->db->limit($limit);
			   	return $this->db->get('pt_tours')->result();
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
				$this->db->insert('pt_tours_types_settings', $data);
                return $this->db->insert_id();
                $this->session->set_flashdata('flashmsgs', "Updated Successfully");

		}

// update tour settings data
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
				$this->db->update('pt_tours_types_settings', $data);
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
				$this->db->insert('pt_tours_types_settings_translation', $data);

                }else{

                 $data = array(
                'trans_name' => $name
                );
				$this->db->where('sett_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_tours_types_settings_translation', $data);

              }


              }

                }
		}


         function getBackSettingsTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_tours_types_settings_translation')->result();

        }

        // Delete hotel settings
		function deleteTypeSettings($id) {
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_tours_types_settings');

                $this->db->where('sett_id', $id);
				$this->db->delete('pt_tours_types_settings_translation');
		}

				// Delete multiple tour settings
		function deleteMultiplesettings($id, $type) {
				$this->db->where('sett_id', $id);
				$this->db->where('sett_type',$type);
				$this->db->delete('pt_tours_types_settings');

				$rowsDeleted = $this->db->affected_rows();

				if($rowsDeleted > 0){
				$this->db->where('sett_id', $id);
				$this->db->delete('pt_tours_types_settings_translation');
				}


		}

         function getTypesTranslation($lang,$id){

            $this->db->where('trans_lang',$lang);
            $this->db->where('sett_id',$id);
            return $this->db->get('pt_tours_types_settings_translation')->result();

        }

        function updateTourLocations($locations, $tourid){

        	$this->db->where('tour_id',$tourid);
        	$this->db->delete('pt_tour_locations');
        	$position = 0;

        	foreach($locations as $loc){

        		if(!empty($loc)){
        			$position++;
        			$data = array('position' => $position,'location_id' => $loc, 'tour_id' => $tourid);
        			$this->db->insert('pt_tour_locations', $data);
        		}
        	}

        }

        function isTourLocation($i, $locid, $tourid){
        	$this->db->where('position', $i);
        	$this->db->where('location_id', $locid);
        	$this->db->where('tour_id', $tourid);
        	$rs = $this->db->get('pt_tour_locations')->num_rows();
        	if($rs > 0){
        		return "selected";
        	}else{
        		return "";
        	}
        }

        function tourSelectedLocations($tourid){
          $result = array();
          $this->db->where('tour_id', $tourid);
          $res = $this->db->get('pt_tour_locations')->result();
          foreach($res as $r){
            $locInfo = pt_LocationsInfo($r->location_id);
            $result[$r->position] = (object)array('id' => $r->location_id,'name' => $locInfo->city.", ".$locInfo->country);
          }
         return $result;

        }

        public function getpackages($id)
        {
        $this->db->order_by('id', 'DESC');  //actual field name of id
        $this->db->where('tour_id',$id);
        $query=$this->db->get('pt_tours_packages');
        return $query->result();
        }
        public function getpackage($id)
        {
        $this->db->where('id',$id);
        $query=$this->db->get('pt_tours_packages');
        return $query->row();
        }

        public function suppilertour($owned_id){
            $this->db->where('tour_owned_by',$owned_id);
            return $this->db->get('pt_tours')->result();
        }
}
