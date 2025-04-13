<?php

class Cars_lib {
/**
* Protected variables
*/
		protected $ci = NULL; //codeigniter instance
		protected $db; //database instatnce instance
		protected $carid;
		public $slug;
		public $bookingSlug;
		public $stars;
		public $title;
		public $basicprice;
		public $discountprice;
		public $desc;
		public $policy;
		public $thumbnail;
		public $isspecial;
		public $currencysign;
		public $currencycode;
		public $isfeatured;
		public $isavailable;
		public $carType;
		public $transmission;
		public $doors;
		public $aiportPickup;
		public $baggage;
		public $passengers;
		public $city;
		public $location;
		public $longitude;
		public $latitude;
		public $country;
		public $state;
		public $langdef;
		public $selectedCarType;
		public $date;
		public $taxamount;
		public $tax_type;
		public $tax_value;
		public $deposit = 0;
		public $urlVars;
		public $pickupLocation;
		public $pickupLocationName;
		public $pickupDate;
		public $pickupTime;
		public $dropoffLocation;
		public $dropoffLocationName;
		public $dropoffDate;
		public $dropoffTime;
		public $errorCode;
		public $error;
		public $totalDays = 1;
		public $createdAt;
		protected $lang;


		function __construct() {
//get the CI instance
				$this->ci = & get_instance();
				$this->db = $this->ci->db;
				$this->appSettings = $this->ci->Settings_model->get_settings_data();

				$lang = $this->ci->session->userdata('set_lang');
				$defaultlang = pt_get_default_language();
				$this->ci->load->model('Cars/Cars_model');
				$this->ci->load->helper('Cars/cars_front');
				$searchVars = "";
				if (empty ($lang)) {
						$this->lang = $defaultlang;
				}
				else {
						$this->lang = $lang;
				}
                $this->langdef = DEFLANG;
                $this->errorCode = "";

                $this->pickupLocation = $this->ci->input->get('pickupLocation');
                $this->pickupDate = $this->ci->input->get('pickupDate');
                $this->pickupTime = $this->ci->input->get('pickupTime');

                if(empty($this->pickupTime)){
                	$this->pickupTime = "10:00";
                }



                $this->dropoffLocation = $this->ci->input->get('dropoffLocation');
                $this->dropoffDate = $this->ci->input->get('dropoffDate');
                $this->dropoffTime = $this->ci->input->get('dropoffTime');

                if(empty($this->dropoffTime)){
                	$this->dropoffTime = "10:00";
                }

                //checking errors
                if(empty($this->pickupLocation) || empty($this->dropoffLocation)){
                	$this->error = true;
                	$this->errorCode = "0543";
                }else{

                /*if($this->pickupLocation == $this->dropoffLocation){
                	$this->error = true;
                	$this->errorCode = "0544";
                }*/

                $getVariables = $this->ci->input->get();
				if(!empty($getVariables)){
                	$searchVars = "?&pickupLocation=".$this->pickupLocation."&dropoffLocation=".$this->dropoffLocation."&pickupDate=".$this->pickupDate."&pickupTime=".$this->pickupTime."&dropoffDate=".$this->dropoffDate."&dropoffTime=".$this->dropoffTime;
                }else{
                	$searchVars = "";
                }

            	}

                if(empty($this->pickupDate) && empty($this->dropoffDate)){

                  $this->pickupDate = date($this->appSettings[0]->date_f,strtotime('+'.CHECKIN_SPAN.' day', time()));
                  $this->dropoffDate = date($this->appSettings[0]->date_f,strtotime('+'.CHECKIN_SPAN.' day', time()));

               	}

                $typeid = $this->ci->input->get('type');
                //$this->urlVars = "?date=".$this->date.$searchVars;
                $getVariables = $this->ci->input->get();
				if(!empty($getVariables)){
                $this->urlVars = $searchVars;
                }else{
               	$this->urlVars = "";
                }
                $this->totalDays = pt_count_days($this->pickupDate, $this->dropoffDate);
                $this->selectedCarType = $this->selectedCarType($typeid);
		}

		function set_carid($carlug) {
				$this->db->select('car_id');
				$this->db->where('car_slug', $carlug);
				$r = $this->db->get('pt_cars')->result();
				$this->carid = $r[0]->car_id;
		}

        function set_lang($lang){
                 if (empty ($lang)) {
                   $defaultlang = pt_get_default_language();
						$this->lang = $defaultlang;
				}
				else {
						$this->lang = $lang;
				}
        }

//set car id by id
		function set_id($id, $currsign = null, $currcode = null) {
				$this->carid = $id;
				$this->currencysign = $currsign;
				$this->currencycode = $currcode;
		}

		function get_id() {
				return $this->carid;
		}

		function settings() {
				return $this->ci->Settings_model->get_front_settings('cars');
		}

		function wishListInfo($id) {
			  $this->car_short_details($id);
			   $title = $this->title;
			   $slug = "cars/".$this->slug;
			   $thumbnail = $this->thumbnail;

			   $location = $this->location;

			   $stars = pt_create_stars($this->stars);
			   $res = array(
			   	"title" => $title,
			   	"slug" => $slug,
			   	"thumbnail" => $thumbnail,
			   	"location" => $location->city,
			   	"stars" => $stars,

			   	);
			   return $res;

		}

		function selectedCarType($id){
			$option = "";
			if(!empty($id)){

			$res = $this->carTypeSettings($id);
			if(!empty($res->name)){
			$option = "<option value=".$res->id." selected >".$res->name."</option>";
			}


			}

			return $option;

		}

		function show_cars($offset = null) {
			  $totalSegments = $this->ci->uri->total_segments();
				$data = array();
				$settings = $this->settings();
				$perpage = $settings[0]->front_listings;
				$sortby = $this->ci->input->get('sortby');
				if (!empty ($sortby)) {
						$orderby = $sortby;
				}
				else {
						$orderby = $settings[0]->front_listings_order;
				}
				$rh = $this->ci->Cars_model->list_cars_front();
				$cars = $this->ci->Cars_model->list_cars_front($perpage, $offset, $orderby);
				$data['all_cars'] = $this->getResultObject($cars['all']);
				$data['paginationinfo'] = array('base' => 'cars/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
				return $data;
		}

// show cars listings on front page based on locations
		function showCarsByLocation($locs, $offset = null) {
				$data = array();
				$settings = $this->settings();
				$perpage = $settings[0]->front_listings;
				$sortby = $this->ci->input->get('sortby');
				if (!empty ($sortby)) {
						$orderby = $sortby;
				}
				else {
						$orderby = $settings[0]->front_listings_order;
				}
				$rh = $this->ci->Cars_model->listCarsByLocation($locs->locations);
				$cars = $this->ci->Cars_model->listCarsByLocation($locs->locations, $perpage, $offset, $orderby);
				$data['all_cars'] = $this->getResultObject($cars['all']);
				$data['paginationinfo'] = array('base' => 'cars/'.$locs->urlBase, 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $locs->uriSegment);
				return $data;
		}

		function search_cars($location, $offset = null) {

				$data = array();
				$settings = $this->settings();
				$perpage = $settings[0]->front_search;
				$orderby = $settings[0]->front_search_order;

				$priceRange = $this->priceRange($this->ci->input->get('price'));
				$rh = $this->ci->Cars_model->search_cars_front($location,$priceRange);

				$cars = $this->ci->Cars_model->search_cars_front($location,$priceRange , $perpage, $offset, $orderby);
				$this->setPickupDropoffLocationNames();

				$data['all_cars'] = $this->getResultObject($cars['all']);
				$data['paginationinfo'] = array('base' => 'cars/search', 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => 3);

				return $data;
		}

		function search_cars_by_text($offset = null, $cities = null) {
				$data = array();
				$settings = $this->settings();
				$perpage = $settings[0]->front_search;
				$orderby = $settings[0]->front_search_order;
				$rh = $this->ci->Cars_model->search_cars_by_text();
				$data['all_cars'] = $this->ci->Cars_model->search_cars_by_text($perpage, $offset, $orderby, $cities);
				return $data;
		}

// get car images
		function car_images($type) {
				$this->db->select('pt_cars.car_title,pt_cars.car_id,pt_car_images.*');
				$this->db->where('pt_cars.car_id', $this->carid);
				if ($type == "slider") {
						$typearray = array('default', 'slider');
						$this->db->where_in('pt_car_images.cimg_type', $typearray);
				}
				else {
						$this->db->where('pt_car_images.cimg_type', $type);
				}
				$this->db->where('pt_car_images.cimg_approved', '1');
				$this->db->join('pt_cars', 'pt_car_images.cimg_car_id = pt_cars.car_id', 'left');
				$this->db->order_by('pt_car_images.cimg_order', 'asc');
				return $this->db->get('pt_car_images')->result();
		}

		function car_details($carid = null) {
				if(empty($carid)){
				$carid = $this->carid;
			}else{
				$carid = $carid;
			}
		$this->ci->load->library('currconverter');
        $curr = $this->ci->currconverter;


				$this->db->where('car_id', $carid);
				$details = $this->db->get('pt_cars')->result();
     			$title = $this->get_title($details[0]->car_title,$carid);
				$stars = $details[0]->car_stars;
				$desc = $this->get_description($details[0]->car_desc,$details[0]->car_id);
				$policy = $this->get_policy($details[0]->car_policy,$details[0]->car_id);

				$keywords = $this->get_keywords($details[0]->car_meta_keywords,$details[0]->car_id);
				$metadesc = $this->get_metaDesc($details[0]->car_meta_desc,$details[0]->car_id);

				$carLocation = $this->getCarLocation($carid);
				$locationInfoUrl = pt_LocationsInfo($carLocation);

				$countryName = url_title($locationInfoUrl->country, 'dash', true);
				$cityName = url_title($locationInfoUrl->city, 'dash', true);

				$slug = $countryName.'/'.$cityName.'/'.$details[0]->car_slug.$this->urlVars;
				$bookingSlug = $details[0]->car_slug.$this->urlVars;


                if(!empty($details[0]->car_payment_opt)){
                $carPaymentOpts = explode(",",$details[0]->car_payment_opt);
                foreach($carPaymentOpts as $p){
                 $payopts[] = $this->carTypeSettings($p);
                }
                }else{
                	$payopts = array();
                }

                $paymentOptions = $payopts;

                if(!empty($details[0]->car_related)){

                $rcars = explode(",",$details[0]->car_related);

           		}else{

            	$rcars = "";

            	}

                $relatedCars = $this->getRelatedCars($rcars);

				$thumbnail = PT_CARS_SLIDER_THUMB.$details[0]->thumbnail_image;

				$carLocation = $this->getCarLocation($carid);

				$city = pt_LocationsInfo($carLocation, $this->lang);



				$location = $city->city;

                $latitude = $city->latitude;
                $longitude = $city->longitude;

                $carPrice = $this->carAmount($carid,$this->pickupLocation, $this->dropoffLocation, $this->pickupDate, $this->dropoffDate);

                if($carPrice > 0){

                	$showTotal = TRUE;
                }else{
                	$showTotal = FALSE;
                }

                $sliderImages = $this->carImages($details[0]->car_id);

				$taxcom = $this->car_tax_commision($details[0]->car_id);
				$comm_type = $taxcom['commtype'];
				$comm_value = $taxcom['commval'];
				$tax_type = $taxcom['taxtype'];
				$tax_value = $taxcom['taxval'];


				$this->comm_type = $taxcom['commtype'];
				$this->comm_value = $taxcom['commval'];

				$this->tax_type = $taxcom['taxtype'];
				$this->tax_value = $taxcom['taxval'];

				$this->setTax($carPrice);
			    $taxAmount = $curr->convertPrice($this->taxamount);

			    $totalCost = $this->taxamount + $carPrice;

				$this->setDeposit($curr->convertPriceFloat($totalCost));
				$depositAmount = $this->deposit;
				$this->setPickupDropoffLocationNames();

				$discount = $this->discount($details[0]->car_id);
                $detailResults = (object)array('id' => $details[0]->car_id, 'title' => $title, 'slug' => $slug, 'bookingSlug' => $bookingSlug,'thumbnail' => $thumbnail,
           		 'stars' => pt_create_stars($stars), 'starsCount' => $stars, 'location' => $location,'desc' => $desc,'latitude' => $latitude,'longitude' => $longitude,'sliderImages' => $sliderImages,'relatedItems' => $relatedCars,'paymentOptions' => $paymentOptions,
          		 'metadesc' => $metadesc,'keywords' => $keywords,'policy' => $policy,'currCode' => $curr->code,'currSymbol' => $curr->symbol,'date' => $this->date,'totalCost' => $curr->convertPrice($totalCost),'comType' => $comm_type, 'comValue' => $comm_value, 'taxType' => $tax_type, 'taxValue' => $tax_value,
                 'carPrice' => $carPrice,'totalDeposit' => $depositAmount, 'taxAmount' => $this->taxamount, 'showTotal' => $showTotal,'pickupLocation' => $this->pickupLocation,'dropoffLocation' => $this->dropoffLocation, 'pickupTime' => $this->pickupTime, 'pickupDate' => $this->pickupDate,'dropoffTime' => $this->dropoffTime, 'dropoffDate' => $this->dropoffDate, 'totalDays' => $this->totalDays,'discount'=>$discount);

                return $detailResults;
		}

		function car_short_details($carid = null) {

			if(empty($carid)){
				$carid = $this->carid;
			}

				$this->db->select('car_title,car_slug,car_location,car_type,car_stars,car_desc,car_policy,car_is_featured,car_basic_price,car_basic_discount,car_city,car_latitude,car_longitude,thumbnail_image,car_passengers,car_doors,car_baggage,car_transmission,car_airport_pickup,car_created_at');
				$this->db->where('car_id', $carid);
				$details = $this->db->get('pt_cars')->result();
				$this->title = $this->get_title($details[0]->car_title);
				$this->stars = $details[0]->car_stars;
				$this->desc = $this->get_description($details[0]->car_desc);
				$this->policy = $this->get_policy($details[0]->car_policy);
				$this->isfeatured = $this->is_featured();
				$this->thumbnail = PT_CARS_SLIDER_THUMB .$details[0]->thumbnail_image;
				$this->createdAt = $details[0]->car_created_at;

				$this->basicprice = $this->getCarPrice($carid, $this->pickupLocation, $this->dropoffLocation); //$details[0]->car_basic_price;

				$this->aiportPickup = $details[0]->car_airport_pickup;
				$this->baggage = $details[0]->car_baggage;
				$this->transmission = $details[0]->car_transmission;
				$this->passengers = $details[0]->car_passengers;
				$this->doors = $details[0]->car_doors;

				//$this->isavailable = pt_car_is_available($this->carid);
				$carLocation = $this->getCarLocation($carid);

				//get country and city name for url slug

				$locationInfoUrl = pt_LocationsInfo($carLocation);

				$countryName = url_title($locationInfoUrl->country, 'dash', true);
				$cityName = url_title($locationInfoUrl->city, 'dash', true);

				$this->slug = $countryName.'/'.$cityName.'/'.$details[0]->car_slug.$this->urlVars;
				$this->bookingSlug = $details[0]->car_slug.$this->urlVars;

				//End get country and city name for url slug

				$city = pt_LocationsInfo($carLocation, $this->lang);

				$this->location = $city->city;
				$this->latitude = $city->latitude;
				$this->longitude = $city->longitude;


				$type = $this->carTypeSettings($details[0]->car_type);
				$this->carType = $type->name;

				$taxcom = $this->car_tax_commision();
				$this->comm_type = $taxcom['commtype'];
				$this->comm_value = $taxcom['commval'];

				$this->tax_type = $taxcom['taxtype'];
				$this->tax_value = $taxcom['taxval'];

				$this->setPickupDropoffLocationNames();

				return $details;
		}

		function car_tax_commision($carid = null) {
			if(empty($carid)){
				$carid = $this->carid;
			}

				$res = array();
				$this->db->select('car_comm_fixed,car_comm_percentage,car_tax_fixed,car_tax_percentage');
				$this->db->where('car_id', $carid);
				$result = $this->db->get('pt_cars')->result();
				$commfixed = $result[0]->car_comm_fixed;
				$commper = $result[0]->car_comm_percentage;
				$taxfixed = $result[0]->car_tax_fixed;
				$taxper = $result[0]->car_tax_percentage;
				$res['commtype'] = "percentage";
				$res['commval'] = $commper;
				$res['taxtype'] = "percentage";
				$res['taxval'] = $taxper;
				if ($commfixed > 0) {
						$res['commtype'] = "fixed";
						$res['commval'] = $commfixed;
				}
				if ($taxfixed > 0) {
						$res['taxtype'] = "fixed";
						$res['taxval'] = $taxfixed;
				}

				$this->comm_type = $res['commtype'];
				$this->comm_value = $res['commval'];

				$this->tax_type = $res['taxtype'];
				$this->tax_value = $res['taxval'];

				return $res;
		}

		function get_title($deftitle,  $carid = null) {
			if (empty($carid)) {
				$carid = $this->carid;
			}
				if ($this->lang == $this->langdef) {
						$title = $deftitle;
				}
				else {
						$this->db->where('item_id', $carid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_cars_translation')->result();
						$title = $res[0]->trans_title;
						if (empty ($title)) {
								$title = $deftitle;
						}
				}
				return $title;
		}

		function get_description($defdesc,$carid = null) {

			if (empty($carid)) {
				$carid = $this->carid;
			}

				if ($this->lang == $this->langdef) {
						$desc = $defdesc;
				}
				else {
						$this->db->where('item_id', $carid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_cars_translation')->result();
						$desc = $res[0]->trans_desc;
						if (empty ($desc)) {
								$desc = $defdesc;
						}
				}
				return $desc;
		}

		function get_policy($defpolicy, $carid = null) {
			if (empty($carid)) {
				$carid = $this->carid;
			}
				if ($this->lang == $this->langdef) {
						$policy = $defpolicy;
				}
				else {
						$this->db->where('item_id', $carid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_cars_translation')->result();
						$policy = $res[0]->trans_policy;
						if (empty ($policy)) {
								$policy = $defpolicy;
						}
				}
				return $policy;
		}


		function get_keywords($defkeywords,$carid = null) {
		   if(empty($carid)){
            $carid = $this->carid;
		  }
				if ($this->lang == $this->langdef) {
						$keywords = $defkeywords;
				}
				else {
						$this->db->where('item_id', $carid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_cars_translation')->result();
						$keywords = $res[0]->metakeywords;
						if (empty ($keywords)) {
								$keywords = $defkeywords;
						}
				}
				return $keywords;
		}

		function get_metaDesc($defmeta,$carid = null) {
		   if(empty($carid)){
            $carid = $this->carid;
		  }
				if ($this->lang == $this->langdef) {
						$meta = $defmeta;
				}
				else {
						$this->db->where('item_id', $carid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_cars_translation')->result();
						$meta = $res[0]->metadesc;
						if (empty ($meta)) {
								$meta = $defmeta;
						}
				}
				return $meta;
		}

		function car_extras() {
				$today = time();
				$this->db->where('extras_from  <=', $today);
				$this->db->where('extras_to >=', $today);
				$this->db->where('extras_module', 'cars');
//  $this->db->or_where('extras_forever','forever');
				$this->db->order_by('extras_id', 'desc');
				$this->db->like('extras_for', $this->carid, 'both');
				$this->db->having('extras_status', '1');
				return $this->db->get('pt_extras')->result();
		}


		 function setDeposit($total){
          if($this->comm_type == "fixed"){
                $this->deposit = round($this->comm_value,2);
                }else{
                 $this->deposit = round(($total * $this->comm_value)/100,2);
                }
        }

        function setTax($amount){
          if($this->tax_type == "fixed"){
                $this->taxamount = round($this->tax_value,2);
                }else{
                 $this->taxamount = round(($amount * $this->tax_value)/100,2);
                }
        }


        function extrasFee($exts){
          $extFee = 0;
          $this->ci->load->library('currconverter');
          $curr = $this->ci->currconverter;
          foreach($exts as $ext){
             $this->db->select('extras_title,extras_desc,extras_discount,extras_basic_price');
             $this->db->where('extras_id',$ext);
             $rs = $this->db->get('pt_extras')->result();
             $amount = $rs[0]->extras_basic_price;
             $price = $curr->convertPriceFloat($amount);
             $extFee += $amount;
             $info = $this->extrasTranslation($ext,$rs[0]->extras_title,$rs[0]->extras_desc);

             $result['extrasIndividualFee'][] = array("id" => $ext, "price" => $price);
             $result['extrasInfo'][] = array("title" => $info['title'], "price" => $price);
          }
          $result['extrasTotalFee'] = $extFee;

          return $result;

        }

        // car Reviews for API
		function car_reviews_for_api($carid) {
			if(empty($carid)){
                  $carid = $this->carid;
                }
				$result = array();
				$this->db->select('review_overall as rating,review_name as review_by,review_comment,review_date');
				$this->db->where('review_status', 'Yes');
				$this->db->where('review_module', 'cars');
				$this->db->where('review_itemid', $carid);
				$this->db->order_by('review_id', 'desc');
				$rs = $this->db->get('pt_reviews')->result();
				foreach ($rs as $r) {
						$result[] = array("rating" => $r->rating, "review_by" => $r->review_by, "review_comment" => $r->review_comment, "review_date" => pt_show_date_php($r->review_date));
				}
				return $result;
		}




// car Reviews Averages
		function car_reviews_avg() {
				$this->db->select("COUNT(*) AS totalreviews");
				$this->db->select_avg('review_overall', 'overall');
				$this->db->select_avg('review_clean', 'clean');
				$this->db->select_avg('review_facilities', 'facilities');
				$this->db->select_avg('review_staff', 'staff');
				$this->db->select_avg('review_comfort', 'comfort');
				$this->db->select_avg('review_location', 'location');
				$this->db->where('review_status', '1');
				$this->db->where('review_module', 'cars');
				$this->db->where('review_itemid', $this->carid);
				return $this->db->get('pt_reviews')->result();
		}

// car rating
		function car_ratings() {
				$this->db->select('pt_cars_types_settings.sett_name');
				$this->db->where('pt_cars.car_id', $this->carid);
				$this->db->join('pt_cars_types_settings', 'pt_cars.car_ratings = pt_cars_types_settings.sett_id', 'left');
				$result = $this->db->get('pt_cars')->result();
				if (!empty ($result)) {
						return $result[0]->sett_name;
				}
				else {
						return '';
				}
		}

// car type
		function car_type() {
				$this->db->select('pt_car_types_settings.sett_name');
				$this->db->where('pt_cars.car_id', $this->carid);
				$this->db->join('pt_cars_types_settings', 'pt_cars.car_type = pt_cars_types_settings.sett_id', 'left');
				$result = $this->db->get('pt_cars')->result();
				if (!empty ($result)) {
						return $result[0]->sett_name;
				}
				else {
						return '';
				}
		}

		function carTypes(){

			$cartypes = array();

			$this->db->select('sett_name,sett_id');
			$this->db->where('sett_type', 'ctypes');
			$types = $this->db->get('pt_cars_types_settings')->result();

			foreach($types as $t){
				$tname = $this->carTypeSettings($t->sett_id);
				$cartypes[] = (object)array( 'id' => $t->sett_id, 'name' => $tname->name);

			}

			return $cartypes;


		}


		// Car Type
         function carTypeSettings($id){

				$language = $this->lang;
                $result = new stdClass;

				$this->db->select('sett_name');
				$this->db->where('sett_id', $id);
				$this->db->where('sett_status', 'Yes');
				$re = $this->db->get('pt_cars_types_settings')->result();
               //$result->icon = PT_CARS_ICONS.$re[0]->sett_img;
               	$result->id = $id;
				if ($language == $this->langdef) {
							$result->name = $re[0]->sett_name;
			    }else {
						$this->db->select('trans_name');
						$this->db->where('sett_id', $id);
						$this->db->where('trans_lang', $language);
						$r = $this->db->get('pt_cars_types_settings_translation')->result();
						if (empty ($r[0]->trans_name)) {
									$result->name = $re[0]->sett_name;
						}
						else {
								$result->name = $r[0]->trans_name;
						}

				}

				return $result;
		}

		function translated_data($lang) {
				$this->db->where('item_id', $this->carid);
				$this->db->where('trans_lang', $lang);
				return $this->db->get('pt_cars_translation')->result();
		}

		function get_thumbnail() {
				$res = $this->ci->Cars_model->default_car_img($this->carid);
				if (!empty ($res)) {
						return PT_CARS_SLIDER_THUMB . $res;

				}
				else {
						return PT_BLANK;
				}
		}

// car Price
		function car_price($basic, $discount) {
				$price = array();
				$price['code'] = $this->currencycode;
				$price['sign'] = $this->currencysign;
				$advprice = pt_car_advanced_price($this->carid);
				$mulcur = pt_default_currencies();
				if (empty ($mulcur)) {
						if (!empty ($advprice)) {
								$price['basic'] = $advprice['basic'];
								$price['discount'] = $advprice['discount'];
						}
						else {
								$price['basic'] = $basic;
								$price['discount'] = $discount;
						}
				}
				else {
						if (!empty ($advprice)) {
								$mbasic = $this->ci->Cars_model->convert_price($advprice['basic']);
								$mdiscount = $this->ci->Cars_model->convert_price($advprice['discount']);
								$price['basic'] = $mbasic['price'];
								$price['discount'] = $mdiscount['price'];
								$price['code'] = $mbasic['code'];
								$price['sign'] = $mbasic['sign'];
						}
						else {
								$mbasic = $this->ci->Cars_model->convert_price($basic);
								$mdiscount = $this->ci->Cars_model->convert_price($discount);
								$price['basic'] = $mbasic['price'];
								$price['discount'] = $mdiscount['price'];
								$price['code'] = $mbasic['code'];
								$price['sign'] = $mbasic['sign'];
						}
				}
				return $price;
		}


		// get car images
		function carImages($carid){
		  if(empty($carid)){
		    $carid = $this->carid;
		  }
			  	$this->db->where('cimg_car_id', $carid);
			  	$this->db->where('cimg_approved', '1');
				$this->db->order_by('cimg_order', 'asc');
				$res = $this->db->get('pt_car_images')->result();
				if(empty($res)){

					$result[] = array("fullImage" => PT_CARS_SLIDER_THUMB.PT_BLANK_IMG,"thumbImage" => PT_CARS_SLIDER_THUMB.PT_BLANK_IMG);

				}else{

				foreach($res as $r){
                  $result[] = array("fullImage" => PT_CARS_SLIDER.$r->cimg_image,"thumbImage" => PT_CARS_SLIDER_THUMB.$r->cimg_image);
                }

				}

                return $result;
		}

		function getFeaturedCars(){
          $cars = $this->featured_cars_list();
          $result = $this->getResultObject($cars);
          return $result;
        }

    function getFeaturedCarsmain($lang,$currency){
        $this->ci->load->model('Hotels/Hotels_model');
		    $this->lang = $lang;
        $cars = $this->featured_cars_list();
        $result = $this->getResultObject($cars);
        $results = [];
        foreach ($result as $key=>$value){
            $current_currency_price = $this->ci->Hotels_model->currencyrate($value->currCode);
            $con_rate = $this->ci->Hotels_model->currencyrate($currency);

            if(!empty($value->price) && !empty($current_currency_price)) {
                $price_get = ceil($value->price / $current_currency_price);
            }else{
                $price_get = 0;
            }
            $price = ceil($price_get * $con_rate);

            array_push($results,(object)[
                'id'=>$value->id,
                'title'=>$value->title,
                'slug'=>$value->slug,
                'thumbnail'=>$value->thumbnail,
                'stars'=>$value->stars,
                'starsCount'=>$value->starsCount,
                'location'=>$value->location,
                'desc'=>$value->desc,
                'doors'=>$value->doors,
                'passengers'=>$value->passengers,
                'transmission'=>$value->transmission,
                'airportPickup'=>$value->airportPickup,
                'baggage'=>$value->baggage,
                'price'=>$price,
                'currCode'=>$currency,
                'carType'=>$value->carType,
                'discount'=>$value->discount,
                'latitude'=>$value->latitude,
                'longitude'=>$value->longitude,
                'avgReviews'=>$value->avgReviews,
            ]);


        }
        return $results;
    }

        function getTopRatedCars(){
          $cars = $this->ci->Cars_model->popular_cars_front();
          $result = $this->getResultObject($cars);
          return $result;
        }


	  function getRelatedCars($cars){
       $resultcars = array();
       $result = array();
			 $settings = $this->settings();
			 $limit = $settings[0]->front_related;
			 $count = 0;
       if(!empty($cars)){
       	foreach($cars as $c){
					$count++;
	        if($count <= $limit){
            $resultcars[] = (object)array('car_id' => $c);
       		   }
       		   }

       }
        $result = $this->getLimitedResultObject($resultcars);


        return $result;

        }


        //Populate Car Types according to the location selected

		function getCarTypesLocationBased($location){

			$result = new stdClass;
			$result->hasResult = FALSE;
			$result->optionsList = "";
			$carTypes = array();
			$this->db->select('car_type');
			$this->db->where('car_location',$location);
			$this->db->group_by('car_type');
			$res = $this->db->get('pt_cars')->result();
			if(!empty($res)){
				foreach($res as $r){
					$carTypes[] = $r->car_type;
				}
				$result->hasResult = TRUE;
				foreach($carTypes as $type){
					$typeDetails = $this->carTypeSettings($type);
					$result->optionsList .= "<option value='".$typeDetails->id."' selected>".$typeDetails->name."</option>";
					$result->types[] = array("id" => $typeDetails->id, "name" => $typeDetails->name);
				}

			}else{
				$result->hasResult = FALSE;
			}
			return $result;
		}

		//Populate Car dropoff locations according to the pickup location selected

		function getDropoffLocations($location, $carid, $pickupDate = null, $dropoffDate = null){

			$result = new stdClass;
			$result->hasResult = FALSE;
			$result->optionsList = "";
			$this->db->select('dropoff_location_id');
			$this->db->where('pickup_location_id',$location);
			$this->db->where('car_id',$carid);
			$res = $this->db->get('pt_car_locations')->result();
			if(!empty($res)){
				$result->hasResult = TRUE;
				$cout = 0;
				foreach($res as $loc){
					$count++;
					if($count == 1){
					$selected = "selected";
					$result->priceInfo = $this->getCarPriceOnChangeLocation($carid, $location,$loc->dropoff_location_id,$pickupDate, $dropoffDate);
					}else{
					$selected = "";
					}

					$locInfo = pt_LocationsInfo($loc->dropoff_location_id, $this->lang);
					$result->optionsList .= "<option value='".$locInfo->id."'".$selected." >".$locInfo->city."</option>";
				}

			}else{
				$result->hasResult = FALSE;
			}
			return $result;
		}

		function getCarPriceOnChangeLocation($carid, $pickup,$dropoff,$pickupDate, $dropoffDate){
				$this->ci->load->library('currconverter');
				$curr = $this->ci->currconverter;
				$this->car_tax_commision($carid);


			    $result = new stdClass;
				$totalSum = $this->carAmount($carid, $pickup, $dropoff,$pickupDate,$dropoffDate);
				$total = $curr->convertPriceFloat($extTotal) + $curr->convertPriceFloat($totalSum);

				$this->setTax($total);

				$result->taxAmount = $this->taxamount;
				$result->grandTotal = $total + $this->taxamount;
				$this->setDeposit($result->grandTotal);

				$result->depositAmount = $this->deposit;

				return $result;

		}

         //make a result object limited data of cars array
         function getLimitedResultObject($cars){

          $this->ci->load->library('currconverter');
          $result = array();
          $curr = $this->ci->currconverter;
          if(!empty($cars)){
          	foreach($cars as $c){
            $this->set_id($c->car_id);
           	$this->car_short_details();
			$avgReviews = $this->carReviewsAvg();

			$price = $curr->convertPrice($this->basicprice);

            if(!empty($this->title)){

            $result[] = (object)array('id' => $this->carid, 'title' => $this->title, 'slug' => base_url().'cars/'.$this->slug,'thumbnail' => $this->thumbnail,
            'stars' => pt_create_stars($this->stars),'starsCount' => $this->stars, 'location' => $this->location,'price' => $price,'currCode' => $curr->code,'currSymbol' => $curr->symbol,'latitude' => $this->latitude, 'longitude' => $this->longitude,'avgReviews' => $avgReviews,'totalDays' => $this->totalDays);
            }

            }
          }

            return $result;
        }

         //make a result object of booking info
         function getBookResultObject($carid){
			$extrasCheckUrl = base_url().'cars/carajaxcalls/carExtrasBooking';
			$this->ci->load->library('currconverter');
			$result = array();
			$curr = $this->ci->currconverter;

			//car details for booking page
            $this->set_id($carid);
           	$this->car_short_details();
            $extras = $this->carExtras();

            if(!empty($this->dropoffDate)) {
                $totalSum = $this->basicprice+$this->basicprice;
            }else{
                $totalSum = $this->basicprice;
            }

            $subTotal = $curr->convertPrice($totalSum);

			$this->setTax($totalSum);
			$taxAmount = $curr->convertPrice($this->taxamount);
			$totalPrice = $curr->convertPriceFloat($totalSum) + $curr->convertPriceFloat($this->taxamount);

			$price = $curr->addComma($totalPrice);

			$this->setDeposit($totalPrice);

			$depositAmount = $curr->addComma($this->deposit);
			$this->setPickupDropoffLocationNames();

            $result["car"] = (object)array('id' => $this->carid, 'title' => $this->title, 'slug' => base_url().'cars/'.$this->slug,'bookingSlug' => $bookingSlug,'thumbnail' => $this->thumbnail,
            'stars' => pt_create_stars($this->stars),'starsCount' => $this->stars, 'location' => $this->location,'date' => $date,
            'metadesc' => $this->metadesc,'keywords' => $this->keywords,'extras' => $extras,'taxAmount' => $taxAmount,'depositAmount' => $depositAmount,
            'policy' => $this->policy,'extraChkUrl' => $extrasCheckUrl,'currCode' => $curr->code,'currSymbol' => $curr->symbol,'price' => $price,
            'subTotal' => $subTotal,'pickupLocation' => $this->pickupLocation,'dropoffLocation' => $this->dropoffLocation, 'pickupTime' => $this->pickupTime, 'pickupDate' => $this->pickupDate,'dropoffTime' => $this->dropoffTime, 'dropoffDate' => $this->dropoffDate, 'totalDays' => $this->totalDays);

        //end car details for booking page
          return $result;

        }

		function is_featured() {
				$this->db->select('car_id');
				$this->db->where('car_is_featured', '1');
				$this->db->where('car_featured_from <', time());
				$this->db->where('car_featured_to >', time());
				$this->db->where('car_id', $this->carid);
				return $this->db->get('pt_cars')->num_rows();
		}

		function featured_cars_list() {
				$settings = $this->settings();
				$limit = $settings[0]->front_homepage;
				$orderby = $settings[0]->front_homepage_order;
				$this->db->select('car_id,car_order,car_title,car_status');
				$this->db->where('car_is_featured', 'yes');
			 	$this->db->where('car_featured_from <', time());
			 	$this->db->where('car_featured_to >', time());
				$this->db->or_where('car_featured_forever', 'forever');
				$this->db->having('car_status', 'Yes');
                $this->db->join('pt_accounts', 'pt_accounts.accounts_id = pt_cars.car_owned_by');
				$this->db->limit($limit);
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
				return $this->db->get('pt_cars')->result();
		}


		function carExtras($carid = null) {
		   if(empty($carid)){
            $carid = $this->carid;
		  }
				$today = time();
                $result = array();
		   //	$this->db->where('extras_from  <=', $today);
			//	$this->db->where('extras_to >=', $today);
				$this->db->where('extras_module', 'cars');
//  $this->db->or_where('extras_forever','forever');
				$this->db->order_by('extras_id', 'desc');
				$this->db->like('extras_for', $carid, 'both');
				$this->db->having('extras_status', 'Yes');
				$ext = $this->db->get('pt_extras')->result();
				$this->ci->load->library('currconverter');
                $curr = $this->ci->currconverter;
                if(!empty($ext)){
                foreach($ext as $e){
                  $trans = $this->extrasTranslation($e->extras_id,$e->extras_title,$e->extras_desc);
                  $price = $curr->convertPrice($e->extras_basic_price);
                  $result[] = (object)array("id" => $e->extras_id,"extraTitle" => $trans['title'],"extraDesc" => $trans['desc'],'extraPrice' => $price,'thumbnail' => PT_CARS_EXTRAS_IMAGES.$e->extras_image);
                }

                }

                return $result;

		}


		function getLocationsList(){

			$resultLocations = array();
			$this->db->select('car_location');
			$this->db->group_by('car_location');
			$locations = $this->db->get('pt_cars')->result();
			foreach($locations as $loc){

				$locInfo = pt_LocationsInfo($loc->car_location, $this->lang);
				if(!empty($locInfo->city)){
				$resultLocations[] = (object)array('id' => $locInfo->id,'name' => $locInfo->city);
				}


			}
			return $resultLocations;

		}

		function getPickupLocationsList($carid = null){

			$resultLocations = array();
			$this->db->select('pickup_location_id');
			$this->db->group_by('pickup_location_id');
			if(!empty($carid)){
			$this->db->where('car_id',$carid);
			}
			$locations = $this->db->get('pt_car_locations')->result();
			foreach($locations as $loc){

				$locInfo = pt_LocationsInfo($loc->pickup_location_id, $this->lang);
				if(!empty($locInfo->city)){
				$resultLocations[] = (object)array('id' => $locInfo->id,'name' => $locInfo->city);
				}


			}
			return $resultLocations;

		}

		function getDropLocationsList($carid = null){

			$resultLocations = array();
			$this->db->select('dropoff_location_id');
			if(!empty($carid)){
			$this->db->where('car_id',$carid);
			}
			$this->db->group_by('dropoff_location_id');
			$locations = $this->db->get('pt_car_locations')->result();
			foreach($locations as $loc){

				$locInfo = pt_LocationsInfo($loc->dropoff_location_id, $this->lang);
				if(!empty($locInfo->city)){
				$resultLocations[] = (object)array('id' => $locInfo->id,'name' => $locInfo->city);
				}


			}
			return $resultLocations;

		}

		function onPickupLocationSelection($location){

			$result = new stdClass;
			$result->hasResult = FALSE;
			$result->optionsList = "";
			$this->db->select('dropoff_location_id');
			$this->db->group_by('dropoff_location_id');
			$res = $this->db->get('pt_car_locations')->result();

			$locationInfo = pt_LocationsInfo($location, $this->lang);
			$result->optionsList .= "<option value='".$locationInfo->id."' selected>".$locationInfo->city."</option>";


			if(!empty($res)){
				$result->hasResult = TRUE;
				foreach($res as $loc){
					if($loc->dropoff_location_id != $location){
					$locInfo = pt_LocationsInfo($loc->dropoff_location_id, $this->lang);
					$result->optionsList .= "<option value='".$locInfo->id."'>".$locInfo->city."</option>";
					}

				}

			}else{
				$result->hasResult = FALSE;
			}

			return $result;



		}




		function extrasTranslation($id,$title,$desc) {
						$language = $this->lang;
						$this->db->select('trans_title,trans_desc');
						$this->db->where('trans_extras_id', $id);
						$this->db->where('trans_lang', $language);
						$r = $this->db->get('pt_extras_translation')->result();
						if (empty ($r[0]->trans_title)) {
								$result['title'] = $title;

						}
						else {
								$result['title'] = $r[0]->trans_title;
						}
						if (empty ($r[0]->trans_desc)) {
								$result['desc'] = $desc;
						}
						else {
								$result['desc'] = $r[0]->trans_desc;
						}

				return $result;
		}

		// car Reviews
		function carReviews($carid = null) {
				if(empty($carid)){
                  $carid = $this->carid;
                }
				$this->db->where('review_status', 'Yes');
				$this->db->where('review_module', 'cars');
				$this->db->where('review_itemid', $carid);
				$this->db->order_by('review_id', 'desc');
				return $this->db->get('pt_reviews')->result();
		}

		// car  Reviews Averages
		function carReviewsAvg($carid = null) {
                if(empty($carid)){
                  $carid = $this->carid;
                }
				$this->db->select("COUNT(*) AS totalreviews");
				$this->db->select_avg('review_overall', 'overall');
				$this->db->select_avg('review_clean', 'clean');
				$this->db->select_avg('review_facilities', 'facilities');
				$this->db->select_avg('review_staff', 'staff');
				$this->db->select_avg('review_comfort', 'comfort');
				$this->db->select_avg('review_location', 'location');
				$this->db->where('review_status', 'Yes');
				$this->db->where('review_module', 'cars');
				$this->db->where('review_itemid', $carid);
				$res = $this->db->get('pt_reviews')->result();
                $clean = round($res[0]->clean, 1);
                $comfort = round($res[0]->comfort, 1);
                $location = round($res[0]->location, 1);
                $facilities = round($res[0]->facilities, 1);
                $staff = round($res[0]->staff, 1);
                $totalreviews = $res[0]->totalreviews;
                $overall = round($res[0]->overall,1);
                $result = (object)array('clean' => $clean,'comfort' => $comfort,'location' => $location,'facilities' => $facilities,'staff' => $staff,'totalReviews' => $totalreviews,'overall' => $overall );
                return $result;
		}


		 //make a result object all data of cars array
         function getResultObject($cars){
          $this->ci->load->library('currconverter');
          $result = array();
          $curr = $this->ci->currconverter;

          foreach($cars as $c){
            $this->set_id($c->car_id);
           	$this->car_short_details();

           	$discount = $this->discount($c->car_id);
            $price = $curr->convertPrice($this->basicprice);

            $carAvailable = $this->carAvailable($c->car_id, $this->pickupLocation,$this->dropoffLocation,$this->pickupDate, $this->pickupTime);

            $avgReviews = $this->carReviewsAvg();
            if($carAvailable){

            $result[] = (object)array('id' => $this->carid, 'title' => $this->title, 'slug' => base_url().'cars/'.$this->slug,'thumbnail' => $this->thumbnail,
            'stars' => pt_create_stars($this->stars),'starsCount' => $this->stars, 'location' => $this->location,'desc' => strip_tags($this->desc),'doors' => $this->doors,'passengers' => $this->passengers,
            'transmission' => $this->transmission,'airportPickup' => $this->aiportPickup,'baggage' => $this->baggage,'price' => $price,'currCode' => $curr->code,'currSymbol' => $curr->symbol,'avgReviews' => $avgReviews, 'latitude' => $this->latitude,'longitude' => $this->longitude,'carType' => $this->carType, 'discount' => $discount);
            }

        	}

            $this->currencycode = $curr->code;
            $this->currencysign = $curr->symbol;

           return $result;

        }

        //Get Discount
        function discount($id){
            $this->ci->db->select('discount');
            $this->ci->db->where('car_id',$id);
            $dis = $this->ci->db->get('pt_cars')->row();
            return $dis->discount;
        }
        //get updated values of booking data after extras and payment method updates
         function getUpdatedDataBookResultObject($carid, $extras, $pickup,$dropoff,$pickupDate,$dropoffDate){
          $this->ci->load->library('currconverter');
          $result = array();
          $curr = $this->ci->currconverter;

          $extratotal = $this->extrasFee($extras);
          $extTotal =  $extratotal['extrasTotalFee'];
          $paymethodTotal = 0; //$this->paymethodFee($this->ci->input->post('paymethod'),$total);

          $this->set_id($carid);
          $this->car_short_details();
          $daysCount = pt_count_days($pickupDate, $dropoffDate);
          $totalSum = $this->carAmount($carid, $pickup, $dropoff,$pickupDate,$dropoffDate);
          $carAmount = $curr->convertPriceFloat($totalSum);
          $total = $curr->convertPriceFloat($extTotal) + $carAmount;

          $this->setTax($total);

          $taxAmount = $curr->addComma($this->taxamount);
          $grandTotal = $total + $paymethodTotal + $this->taxamount;
          $this->setDeposit($grandTotal);

          $depositAmount = $this->deposit;


          $price = $grandTotal;

          $extrasHtml = "";
          foreach($extratotal['extrasInfo'] as $einfo){
          	$extrasHtml .= "<li class='allextras'>" . $einfo['title'] . "<span class='absolute-right'>
			  " . $curr->symbol . $curr->addComma($einfo['price']) . "</span></li>";
          }

         $subitem = array("total" => $carAmount);

          $result = (object)array('grandTotal' => $price,'taxAmount' => $taxAmount,
            	'depositAmount' => $depositAmount,'extrashtml' => $extrasHtml,
            	'bookingType' => "cars",'currCode' => $curr->code, 'totalDays' => $this->totalDays,
            	'currSymbol' => $curr->symbol,'subitem' => $subitem,'extrasInfo' => $extratotal,'stay' => $daysCount);

          //end car details for booking page
          return json_encode($result);

        }

        function getCarPrice($carid, $pickup = null, $dropoff = null){

        	$price = 0;
        	$this->db->where('car_id',$carid);
        	if(!empty($pickup) && !empty($dropoff)){
        	$this->db->where('pickup_location_id',$pickup);
        	$this->db->where('dropoff_location_id',$dropoff);
        	}


        	$this->db->order_by('price','asc');
        	$this->db->limit(1);
        	$res = $this->db->get('pt_car_locations')->result();
        	if(!empty($res)){

        		$price = $res[0]->price;

        	}

        	if($this->totalDays < 1){
        		$days = 1;
        	}else{
        		$days = $this->totalDays;
        	}
        	$finalPrice = round($price * $days,2);

        	return $finalPrice;

        }


        function carAmount($carid, $pickup = null, $dropoff = null,$pickupDate = null,$dropoffDate =null){

        	$price = 0;
        	$this->db->where('car_id',$carid);
        	$this->db->where('pickup_location_id',$pickup);
        	$this->db->where('dropoff_location_id',$dropoff);

        	$this->db->order_by('price','asc');
        	$this->db->limit(1);
        	$res = $this->db->get('pt_car_locations')->result();

        	if(!empty($res)){
            if(!empty($dropoffDate)) {
            $price = $res[0]->price+$res[0]->price;
            }else{
            $price = $res[0]->price;
            }
        	}

			if(!empty($pickupDate) && !empty($dropoffDate)){
			$daysCount = pt_count_days($pickupDate, $dropoffDate);
			}else{
			$daysCount = $this->totalDays;
			}


        	if($daysCount < 1){
        		$days = 1;
        	}else{
        		$days = $daysCount;
        	}


        	$finalPrice = round($price * $days,2);
        	return $finalPrice;

        }

        function checkCarPriceAtBooking($carid){
        	$price = $this->getCarPrice($carid,$this->pickupLocation, $this->dropoffLocation);
        	if($price < 1){
        		$this->error = TRUE;
        		$this->errorCode = "0549";
        	}else{
        		$this->error = FALSE;
        	}

        }


        public function checkErrors(){


        }

		public function timingList(){
		$start = "00:00";
		$end = "23:59";
		$timeArray = array();

		$tStart = strtotime($start);
		$tEnd = strtotime($end);
		$tNow = $tStart;

		while($tNow <= $tEnd){
		$timeArray[] = date("H:i",$tNow);
		$tNow = strtotime('+30 minutes',$tNow);
		}

		return $timeArray;


		}

		public function getCarLocation($id){
			$this->db->select('pickup_location_id');
			$this->db->where('car_id',$id);
			$this->db->where('position','1');
			$this->db->order_by('position','asc');
			$this->db->limit(1);
			$res = $this->db->get('pt_car_locations')->result();
			$location = 0;
			if(!empty($res)){
				$location = $res[0]->pickup_location_id;
			}
			return $location;

		}

		//convert price
        public function convertAmount($price){

          $this->ci->load->library('currconverter');
          $curr = $this->ci->currconverter;
          return $curr->convertPriceFloat($price);

        }

         public function convertPriceRange($price){

			$this->ci->load->library('currconverter');
			$curr = $this->ci->currconverter;
			return $curr->convertPriceRange($price,0);

        }

        public function priceRange($sprice){
        				$result = "";

        				if(!empty($sprice)){

						$sprice = str_replace(";", ",", $sprice);
						$sprice = explode(",", $sprice);

						$minprice = $this->convertPriceRange($sprice[0]);
						$maxprice = $this->convertPriceRange($sprice[1]);
						$result = $minprice."-".$maxprice;
					    }


						return $result;

        }

        public function bookedInvoiceInfo($bookid){
        	$result = new stdClass;
        	$this->db->where('booked_booking_id',$bookid);
        	$res = $this->db->get('pt_booked_cars')->result();

        	if(!empty($res)){
        		$pickup = pt_LocationsInfo($res[0]->booked_pickuplocation, $this->lang);
        		$drop = pt_LocationsInfo( $res[0]->booked_dropofflocation, $this->lang);

        		$result->pickupLocation = $pickup->city;
        		$result->dropoffLocation = $drop->city;
        		$result->pickupDate = fromDbToAppFormatDate($res[0]->booked_pickupdate);
        		$result->pickupTime = $res[0]->booked_pickuptime;
        		$result->dropoffTime = $res[0]->booked_dropoffTime;
        		$result->dropoffDate = fromDbToAppFormatDate($res[0]->booked_dropoffDate);
        	}

        	return $result;
        }

        public function carAvailable($carid, $pickupLocation,$dropoffLocation,$pickupDate, $pickupTime){

        			$this->db->select('date_f,date_f_js');
				    $res = $this->db->get('pt_app_settings')->result();
				    $datepickup = convert_to_unix($pickupDate,$res[0]->date_f);

        			$statuses = array("paid","reserved");
					$this->db->where('booked_pickuplocation', $pickupLocation);
					$this->db->where('booked_dropofflocation', $dropoffLocation);
					$this->db->where('booked_pickupdate', $datepickup);
					$this->db->where('booked_pickuptime', $pickupTime);
					$this->db->where('booked_car_id', $carid);
					$this->db->where_in('pt_booked_cars.booked_booking_status', $statuses);
					$num = $this->db->get('pt_booked_cars')->num_rows();
					if($num > 0){

						return FALSE;

					}else{

						return TRUE;
					}

        }

        function setPickupDropoffLocationNames(){
        	$result = new stdClass;
        	$pickup = pt_LocationsInfo($this->pickupLocation, $this->lang);
        	$drop = pt_LocationsInfo($this->dropoffLocation, $this->lang);
        	$result->pickup = $pickup->city;
        	$result->drop = $drop->city;

        	$this->pickupLocationName = $pickup->city;
        	$this->dropoffLocationName = $drop->city;
        	return $result;


        }

        public function siteMapData(){
          		$carsData = array();
				$this->db->select('car_id');
				$this->db->where('car_status','Yes');
				$result = $this->db->get('pt_cars');
				$cars = $result->result();
				if(!empty($cars)){
				$carsData = $this->getLimitedResultObject($cars);

				}

				return $carsData;
        }

         function getLatestCarsForAPI(){
			$this->ci->db->select('car_id,car_created_at');
			$this->ci->db->order_by('car_created_at','desc');
			$this->ci->db->limit('10');
			$items = $this->ci->db->get('pt_cars')->result();

		  $this->ci->load->library('currconverter');
          $result = array();
          $curr = $this->ci->currconverter;
          if(!empty($items)){

          	foreach($items as $h){
            $this->set_id($h->car_id);
           	$this->car_short_details();
            $price = $curr->convertPrice($this->basicprice);
            $avgReviews = $this->carReviewsAvg();

            if(!empty($this->title)){

            	$result[] = (object)array('id' => $h->car_id, 'title' => $this->title,'thumbnail' => $this->thumbnail,
            'starsCount' => $this->stars,'location' => $this->location, 'price' => $price,'currCode' => $curr->code,'currSymbol' => $curr->symbol,'avgReviews' => $avgReviews, 'createdAt' => $this->createdAt, 'module' => 'cars');

            }

             }
          }


          return $result;

		}

}
