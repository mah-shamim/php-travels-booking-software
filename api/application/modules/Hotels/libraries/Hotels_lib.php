<?php

class Hotels_lib {

/**

* Protected variables

*/

  protected $ci = NULL; //codeigniter instance

  protected $db; //database instatnce instance

  public $hotelid;

  public $appSettings;

  public $tripadvisorid;

  public $title;

  public $slug;

  public $bookingSlug;

  public $stars;

  public $basicprice;

  public $discountprice;

  public $desc;

  public $location;

  public $country;

  public $policy;

  public $roomid;

  public $roomtitle;

  public $roomdesc;

  public $roomprice;

  public $roompernight;

  public $thumbnail;

  public $isspecial;

  public $currencysign;

  public $currencycode;

  public $isfeatured;

  public $trusted;

  public $bestprice;

  public $refundable;

  public $arrivalpay;

  public $comm_type;

  public $comm_value;

  public $tax_type;

  public $tax_value;

  public $deposit = 0;

  public $taxamount = 0;

  public $bookingtotal = 0;

  public $phone;

  public $email;

  public $website;

  public $checkin;

  public $checkout;

  public $defcheckin;

  public $defcheckout;

  public $adults;

  public $children;

  public $stay = 1;

  public $roomscount = 1;

  public $stayerror = "";

  public $roomscounterror = "";

  public $checkinout = "";

  public $langdef;

  public $lowestprice;

  public $roomsavailable = false;

  public $amenities;

  public $paymentOptions;

  public $sliderImages;

  public $latitude;

  public $logitude;
  
  public $hoteladdress;

  public $relatedHotels;

  public $selectedLocation;

  public $keywords;

  public $metadesc;

  public $createdAt;

  protected $lang;

  function __construct() {

//get the CI instance

    $this->ci = & get_instance();

      $version = implode("=>",(array)$this->ci->db->query('SELECT VERSION()')->result()[0]);
      if($version > 5.6)
      {
          $this->ci->db->query('SET SESSION sql_mode = ""');
          $this->ci->db->query('SET SESSION sql_mode =
                      REPLACE(REPLACE(REPLACE(
                      @@sql_mode,
                      "ONLY_FULL_GROUP_BY,", ""),
                      ",ONLY_FULL_GROUP_BY", ""),
                      "ONLY_FULL_GROUP_BY", "")');
      }
    $this->db = $this->ci->db;

    $this->appSettings = $this->ci->Settings_model->get_settings_data();

    $this->ci->load->model('Hotels/Hotels_model');


    $this->currencysign = $this->appSettings[0]->currency_sign;

    $this->currencycode = $this->appSettings[0]->currency_code;

    $this->checkin = $this->ci->input->get('checkin');

    $this->checkout = $this->ci->input->get('checkout');

    $loc = $this->ci->input->get('searching');

    $this->children = 0;

    $adultss = $this->ci->input->get('adults');

    if (empty($adultss)) {

      $this->adults = 2;

    }

    else {

      $this->adults = $this->ci->input->get('adults');

    }

    $childd = $this->ci->input->get('child');

    if (empty($childd)) {

      $this->children = 0;

    }

    else {

      $this->children = $this->ci->input->get('child');

    }

    $rcc = $this->ci->input->get('roomscount');

    if (empty($rcc)) {

      $this->roomscount = 1;

    }

    else {

      $this->roomscount = $this->ci->input->get('roomscount');

    }

    $this->stay = pt_count_days($this->checkin, $this->checkout);

    if (empty($this->checkin) || empty($this->checkout)) {

      $this->stay = 1;

      $this->checkin = date($this->appSettings[0]->date_f, strtotime('+' . CHECKIN_SPAN . ' day', time()));

      $this->checkout = date($this->appSettings[0]->date_f, strtotime('+' . CHECKOUT_SPAN . ' day', time()));

    }

    $unixcheckin = convert_to_unix($this->checkin);

    $unixcheckout = convert_to_unix($this->checkout);

    $current = strtotime(date('m/d/Y'));

    if (empty($this->checkin) || empty($this->checkout)) {

//	$this->showprice = false;

    }

    elseif ($unixcheckin < $current || $unixcheckout < $current || $unixcheckin > $unixcheckout) {

      $this->stayerror = "1";

    }

    else {

      $getVariables = $this->ci->input->get();

      if (!empty($getVariables)) {

        $this->checkinout = "?&checkin=" . $this->checkin . "&checkout=" . $this->checkout . "&adults=" . $this->adults . "&child=" . $this->children;

      }

    }

    if (!empty($loc)) {

      $this->selectedLocation = $loc;

    }

    else {

      $this->selectedLocation = "";

    }

    $this->set_lang($this->ci->session->userdata('set_lang'));

    $this->langdef = DEFLANG;

  }

  function set_hotelid($hotelslug) {

    $this->db->select('hotel_id');

    $this->db->where('hotel_slug', $hotelslug);

    $r = $this->db->get('pt_hotels')->result();

    $this->hotelid = $r[0]->hotel_id;

  }

  function set_lang($lang) {

    if (empty($lang)) {

      $defaultlang = pt_get_default_language();

      $this->lang = $defaultlang;

    }

    else {

      $this->lang = $lang;

    }

  }

//set hotel id by id

  function set_id($id) {

    $this->hotelid = $id;

  }

  function get_id() {

    return $this->hotelid;

  }

  function settings() {

    return $this->ci->Settings_model->get_front_settings('hotels');

  }

  function wishListInfo($id) {

/* $this->db->select('hotel_title,hotel_slug,thumbnail_image,hotel_city,hotel_stars');

$this->db->where('hotel_id',$id);

$result = $this->db->get('pt_hotels')->result();*/

    $this->hotel_short_details($id);

    $title = $this->title;

    $slug = base_url() . 'hotels/' . $this->slug;

    $thumbnail = $this->thumbnail;

    $location = $this->location;

//pt_LocationsInfo($result[0]->hotel_city, $this->lang);

    $stars = pt_create_stars($this->stars);

    $res = array("title" => $title, "slug" => $slug, "thumbnail" => $thumbnail, "location" => $location->city, "stars" => $stars);

    return $res;

  }

  function show_hotels($offset = null) {

    $totalSegments = $this->ci->uri->total_segments();

    $data = array();

    $settings = $this->settings();

    $sortby = $this->ci->input->get('sortby');

    $perpage = $settings[0]->front_listings;

    if (!empty($sortby)) {

      $orderby = $sortby;

    }

    else {

      $orderby = $settings[0]->front_listings_order;

    }

// $hotelslist = $this->hotelswithrooms();

    $rh = $this->ci->Hotels_model->list_hotels_front();

//	$data['all_hotels'] = $this->ci->Hotels_model->list_hotels_front($perpage, $offset, $orderby);

    $hotels = $this->ci->Hotels_model->list_hotels_front($perpage, $offset, $orderby);

    $data['all_hotels'] = $this->getResultObject($hotels['all']);

    $data['paginationinfo'] = array('base' => 'hotels/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);

    return $data;

  }

  function showHotelsByLocation($locs, $offset = null) {

    $data = array();

    $settings = $this->settings();

    $sortby = $this->ci->input->get('sortby');

    $perpage = $settings[0]->front_listings;

    if (!empty($sortby)) {

      $orderby = $sortby;

    }

    else {

      $orderby = $settings[0]->front_listings_order;

    }

// $hotelslist = $this->hotelswithrooms();

    $rh = $this->ci->Hotels_model->listHotelsByLocation($locs->locations);

//	$data['all_hotels'] = $this->ci->Hotels_model->list_hotels_front($perpage, $offset, $orderby);

    $hotels = $this->ci->Hotels_model->listHotelsByLocation($locs->locations, $perpage, $offset, $orderby);

    $data['all_hotels'] = $this->getResultObject($hotels['all']);

    $data['paginationinfo'] = array('base' => 'hotels/' . $locs->urlBase, 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => $locs->uriSegment);

    return $data;

  }

  function search_hotels($offset = null) {

    $data = array();

    $settings = $this->settings();

    $sortby = $this->ci->input->get('sortby');

    $perpage = $settings[0]->front_search;

    if (!empty($sortby)) {

      $orderby = $sortby;

    }

    else {

      $orderby = $settings[0]->front_search_order;

    }

// $hotelslist = $this->hotelswithrooms();

    $rh = $this->ci->Hotels_model->search_hotels_front('', '', '', '', '');

    $hotels = $this->ci->Hotels_model->search_hotels_front($perpage, $offset, $orderby);

    $data['all'] = $this->getResultObject($hotels['all']);

    $data['paginationinfo'] = array('base' => 'hotels/search', 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => 3);

    return $data;

  }

  function search_hotels_by_text($cityid, $offset = null, $checkin = null, $checkout = null) {

    $data = array();

    $settings = $this->settings();

    $sortby = $this->ci->input->get('sortby');

    $perpage = $settings[0]->front_search;

    if (!empty($sortby)) {

      $orderby = $sortby;

    }

    else {

      $orderby = $settings[0]->front_search_order;

    }

// $hotelslist = $this->hotelswithrooms();

    $rh = $this->ci->Hotels_model->search_hotels_by_text($cityid, '', '', '', '');

    $hotels = $this->ci->Hotels_model->search_hotels_by_text($cityid, $perpage, $offset, $orderby, $checkin, $checkout);

    $data['all'] = $this->getResultObject($hotels['all']);

    $segments = '/' . $this->ci->uri->segment(3) . '/' . $this->ci->uri->segment(4) . '/' . $this->ci->uri->segment(5);

    $data['paginationinfo'] = array('base' => 'hotels/search' . $segments, 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => 6);

    return $data;

  }

// get hotel images

  function hotelImages($hotelid) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $this->db->where('himg_hotel_id', $hotelid);

    $this->db->where('himg_approved', '1');

    $this->db->order_by('himg_order', 'asc');

    $res = $this->db->get('pt_hotel_images')->result();

    if (empty($res)) {

      $result[] = array("fullImage" => PT_HOTELS_SLIDER_THUMBS . PT_BLANK_IMG, "thumbImage" => PT_HOTELS_SLIDER_THUMBS . PT_BLANK_IMG);

    }

    else {

      foreach ($res as $r) {

        $result[] = array("fullImage" => PT_HOTELS_SLIDER . $r->himg_image, "thumbImage" => PT_HOTELS_SLIDER_THUMBS . $r->himg_image);

      }

    }

    return $result;

  }

// get hotel rooms

  function hotel_rooms($hotelid = null, $checkin = null, $checkout = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $this->db->select('room_id as id');

    $this->db->where('room_hotel', $hotelid);

    $this->db->where('room_status', 'Yes');

    $this->db->where('room_min_stay <=', $this->stay);

    $this->db->order_by('room_id', 'desc');

    $q = $this->db->get('pt_rooms');

    $data = $q->result();

    return $this->getRoomsResultObject($data, $checkin, $checkout);

  }

  function totalRooms($hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $this->db->select('room_id');

    $this->db->where('room_hotel', $hotelid);

    $this->db->where('room_status', 'Yes');

    return $this->db->get('pt_rooms')->num_rows();

  }

// get Room images

  function roomImages($id, $count = null) {

    $result = array();

    $this->db->where('rimg_room_id', $id);

    $this->db->where('rimg_approved', '1');

    $this->db->order_by('rimg_order', 'asc');

    if (!empty($count)) {

      $this->db->limit($count);

    }

    $res = $this->db->get('pt_room_images')->result();

    if (!empty($res)) {

      foreach ($res as $r) {

        $result[] = array("fullImage" => PT_ROOMS_IMAGES . $r->rimg_image, "thumbImage" => PT_ROOMS_THUMBS . $r->rimg_image);

      }

    }

    return $result;

  }

// get hotel rooms with limited details

  function rooms_id_title_only($hotelid = null) {

    $this->db->select('pt_rooms.room_id,pt_rooms.room_title,room_quantity,room_adults,room_children,room_min_stay');

    if (empty($hotelid)) {

      $this->db->where('pt_rooms.room_hotel', $this->hotelid);

    }

    else {

      $this->db->where('pt_rooms.room_hotel', $hotelid);

    }

    $this->db->where('pt_rooms.room_status', 'Yes');

    $this->db->order_by('pt_rooms.room_order', 'asc');

    $q = $this->db->get('pt_rooms');

    $data = $q->result();

    return $data;

  }

// Room Price

  function room_price($roomid, $currsign = null, $currcode = null) {

    $this->ci->load->helper('check');

    $price = array();

    $this->roomid = $roomid;

    $advprice = room_booking_adv_price($roomid, $this->checkin, $this->checkout);

    $mulcur = "";

    $taxval = $this->tax_value;

    $taxtype = $this->tax_type;

    $commtype = $this->comm_type;

    $commval = $this->comm_value;

    if (empty($mulcur)) {

      $this->roompernight = $advprice;

      $this->roomprice = $advprice * $this->stay * $this->roomscount;

    }

    else {

      $mbasic = $this->ci->Hotels_model->convert_price($advprice);

      $this->roompernight = $mbasic['price'];

      $this->roomprice = $mbasic['price'] * $this->stay * $this->roomscount;

      $this->currencycode = $mbasic['code'];

      $this->currencysign = $mbasic['sign'];

    }

    if ($this->tax_type == "fixed") {

      $this->taxamount = $this->tax_value;

      $this->bookingtotal = $this->roomprice + $this->taxamount;

    }

    else {

      $this->taxamount = ($this->roomprice * $this->tax_value) / 100;

      $this->bookingtotal = $this->roomprice + $this->taxamount;

    }

    $this->setDeposit($this->bookingtotal);

  }

  function hotel_details() {

    $this->db->where('hotel_id', $this->hotelid);

    $details = $this->db->get('pt_hotels')->result();


    $tripadvisorid = $details[0]->tripadvisor_id;

    $title = $this->get_title($details[0]->hotel_title, $details[0]->hotel_id);

    $stars = $details[0]->hotel_stars;

    $desc = $this->get_description($details[0]->hotel_desc, $details[0]->hotel_id);

    $policy = $this->get_policy($details[0]->hotel_policy, $details[0]->hotel_id);

    $keywords = $this->get_keywords($details[0]->hotel_meta_keywords, $details[0]->hotel_id);

    $metadesc = $this->get_metaDesc($details[0]->hotel_meta_desc, $details[0]->hotel_id);

    $locationInfoUrl = pt_LocationsInfo($details[0]->hotel_city);

    $countryName = url_title($locationInfoUrl->country, 'dash', true);

    $cityName = url_title($locationInfoUrl->city, 'dash', true);

    $slug = $countryName . '/' . $cityName . '/' . $details[0]->hotel_slug . $this->checkinout;

    $bookingSlug = $details[0]->hotel_slug . $this->checkinout;

    if (!empty($details[0]->hotel_amenities)) {

      $hotelAmenities = explode(",", $details[0]->hotel_amenities);

      foreach ($hotelAmenities as $hm) {

        $amts[] = $this->amenitiesTranslation($hm);

      }

    }

    else {

      $amts = array();

    }

    $amenities = $amts;

    if (!empty($details[0]->hotel_payment_opt)) {

      $hotelPaymentOpts = explode(",", $details[0]->hotel_payment_opt);

      foreach ($hotelPaymentOpts as $p) {

        $payopts[] = $this->amenitiesTranslation($p);

      }

    }

    else {

      $payopts = array();

    }

    $paymentOptions = $payopts;

    if (!empty($details[0]->hotel_related)) {

      $rhotels = explode(",", $details[0]->hotel_related);

    }

    else {

      $rhotels = "";

    }

    $relatedHotels = $this->getRelatedHotels($rhotels);

    $thumbnail = PT_HOTELS_SLIDER_THUMBS . $details[0]->thumbnail_image;

    $city = pt_LocationsInfo($details[0]->hotel_city, $this->lang);

//	$this->isfeatured = $this->is_featured();

    $website = $details[0]->hotel_website;

    $phone = $details[0]->hotel_phone;

    $email = $details[0]->hotel_email;


    $taxcom = $this->hotel_tax_commision();

    $comm_type = $taxcom['commtype'];

    $comm_value = $taxcom['commval'];

    $tax_type = $taxcom['taxtype'];

    $tax_value = $taxcom['taxval'];

    $latitude = $details[0]->hotel_latitude;

    $b2c_markup = $details[0]->b2c_markup;

    $b2b_markup = $details[0]->b2b_markup;

    $b2e_markup = $details[0]->b2e_markup;

    $hotel_email = $details[0]->hotel_email;

    $hotel_phone = $details[0]->hotel_phone;

    $hotel_website = $details[0]->hotel_website;

    $service_fee = $details[0]->service_fee;

    $longitude = $details[0]->hotel_longitude;

    $defcheckin = $details[0]->hotel_check_in;

    $defcheckout = $details[0]->hotel_check_out;

    $this->tripadvisorid = $tripadvisorid;

    $sliderImages = $this->hotelImages($details[0]->hotel_id);

      $discount = $this->discount($details[0]->hotel_id);
      $taxamount = $this->taxamount($details[0]->hotel_id);


     //dd($taxamount['tax_type']);

    $detailResults = (object) array('id' => $details[0]->hotel_id,'meta_title'=>$details[0]->hotel_meta_title, 'title' => $title, 'slug' => $slug, 'bookingSlug' => $bookingSlug, 'thumbnail' => $thumbnail, 'stars' => pt_create_stars($stars), 'starsCount' => $stars, 'location' => $city->city, 'desc' => $desc, 'amenities' => $amenities, 'latitude' => $latitude, 'longitude' => $longitude, 'sliderImages' => $sliderImages, 'relatedItems' => $relatedHotels, 'paymentOptions' => $paymentOptions, 'defcheckin' => $defcheckin, 'defcheckout' => $defcheckout, 'metadesc' => $metadesc, 'keywords' => $keywords, 'policy' => $policy, 'tripadvisorid' => $tripadvisorid, 'mapAddress' => $details[0]->hotel_map_city,'discount' => $discount, 'hotel_phone' => $details[0]->hotel_phone,'tax_type'=>$taxamount['tax_type'],'tax_amount'=>$taxamount['tax_amount'],'deposit_type'=>$taxamount['deposit_type'],'deposit_amount'=>$taxamount['deposit_amount'],'b2c_markup'=>$b2c_markup,'b2b_markup'=>$b2b_markup,'b2e_markup'=>$b2e_markup,'service_fee'=>$service_fee,'hotel_phone'=>$hotel_phone,'hotel_email'=>$hotel_email,'hotel_website'=>$hotel_website);

    return $detailResults;

  }

  function hotel_short_details($id = null) {

    if (empty($id)) {

      $id = $this->hotelid;

    }

    $this->db->select('hotel_id,hotel_phone,hotel_email,hotel_website,hotel_title,hotel_desc,hotel_policy,tripadvisor_id,hotel_city,hotel_basic_price,hotel_basic_discount,hotel_is_featured,hotel_map_city,



   hotel_trusted,hotel_best_price,hotel_stars,hotel_slug,hotel_refundable,hotel_ratings,hotel_arrivalpay,thumbnail_image,hotel_amenities,hotel_latitude,hotel_longitude,hotel_meta_keywords,hotel_meta_desc,hotel_created_at');

    $this->db->where('hotel_id', $id);

    $details = $this->db->get('pt_hotels')->result();

    $this->tripadvisorid = $details[0]->tripadvisor_id;

    $this->title = $this->get_title($details[0]->hotel_title);

    $this->stars = $details[0]->hotel_stars;

    $this->desc = $this->get_description($details[0]->hotel_desc);

    $this->policy = $this->get_policy($details[0]->hotel_policy, NULL);

    $this->keywords = $this->get_keywords($details[0]->hotel_meta_keywords, $details[0]->hotel_id);

    $this->metadesc = $this->get_metaDesc($details[0]->hotel_meta_desc, $details[0]->hotel_id);

    $this->createdAt = $details[0]->hotel_created_at;

    $hotelAmenities = explode(",", $details[0]->hotel_amenities);

    foreach ($hotelAmenities as $hm) {

      $amenities[] = $this->amenitiesTranslation($hm);

    }

    $this->amenities = $amenities;

    $this->thumbnail = PT_HOTELS_SLIDER_THUMBS . $details[0]->thumbnail_image;

    $this->isspecial = pt_is_special('hotels', $this->hotelid);

//get country and city name for url slug

    $locationInfoUrl = pt_LocationsInfo($details[0]->hotel_city);

    $countryName = url_title($locationInfoUrl->country, 'dash', true);

    $cityName = url_title($locationInfoUrl->city, 'dash', true);

    $this->slug = $countryName . '/' . $cityName . '/' . $details[0]->hotel_slug . $this->checkinout;

    $this->bookingSlug = $details[0]->hotel_slug . $this->checkinout;

//		$pricing = $this->hotel_price($details[0]->hotel_basic_price, $details[0]->hotel_basic_discount);

//			$this->basicprice = $pricing['basic'];

//			$this->discountprice = $pricing['discount'];

    $city = pt_LocationsInfo($details[0]->hotel_city, $this->lang);

    $this->location = $city->city;

//	$this->country = $location[0]->short_name;

    $this->isfeatured = $this->is_featured();

    $this->trusted = $details[0]->hotel_trusted;

//	$this->bestprice = $details[0]->hotel_best_price;

    $this->refundable = $details[0]->hotel_refundable;

    $this->arrivalpay = $details[0]->hotel_arrivalpay;

    $this->website = $details[0]->hotel_website;

    $this->phone = $details[0]->hotel_phone;

    $this->email = $details[0]->hotel_email;

    $taxcom = $this->hotel_tax_commision();

    $this->comm_type = $taxcom['commtype'];

    $this->comm_value = $taxcom['commval'];

    $this->tax_type = $taxcom['taxtype'];

    $this->tax_value = $taxcom['taxval'];

    $this->latitude = $details[0]->hotel_latitude;

    $this->longitude = $details[0]->hotel_longitude;
    $this->hoteladdress = $details[0]->hotel_map_city;
    

    $this->sliderImages = $this->hotelImages(NULL);

    return $details;

  }

  function get_title($deftitle, $hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    if ($this->lang == $this->langdef) {

      $title = $deftitle;

    }

    else {

      $this->db->where('item_id', $hotelid);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_hotels_translation')->result();

      $title = $res[0]->trans_title;

      if (empty($title)) {

        $title = $deftitle;

      }

    }

    return $title;

  }

  function get_description($defdesc, $hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    if ($this->lang == $this->langdef) {

      $desc = $defdesc;

    }

    else {

      $this->db->where('item_id', $hotelid);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_hotels_translation')->result();

      $desc = $res[0]->trans_desc;

      if (empty($desc)) {

        $desc = $defdesc;

      }

    }

    return $desc;

  }

  function get_policy($defpolicy, $hotelid) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    if ($this->lang == $this->langdef) {

      $policy = $defpolicy;

    }

    else {

      $this->db->where('item_id', $hotelid);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_hotels_translation')->result();

      $policy = $res[0]->trans_policy;

      if (empty($policy)) {

        $policy = $defpolicy;

      }

    }

    return $policy;

  }

  function get_keywords($defkeywords, $hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    if ($this->lang == $this->langdef) {

      $keywords = $defkeywords;

    }

    else {

      $this->db->where('item_id', $hotelid);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_hotels_translation')->result();

      $keywords = $res[0]->metakeywords;

      if (empty($keywords)) {

        $keywords = $defkeywords;

      }

    }

    return $keywords;

  }

  function get_metaDesc($defmeta, $hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    if ($this->lang == $this->langdef) {

      $meta = $defmeta;

    }

    else {

      $this->db->where('item_id', $hotelid);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_hotels_translation')->result();

      $meta = $res[0]->metadesc;

      if (empty($meta)) {

        $meta = $defmeta;

      }

    }

    return $meta;

  }

  function hotelExtras($hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $today = time();

    $result = array();

//	$this->db->where('extras_from  <=', $today);

//	$this->db->where('extras_to >=', $today);

    $this->db->where('extras_module', 'hotels');

//  $this->db->or_where('extras_forever','forever');

    $this->db->order_by('extras_id', 'desc');

    $this->db->like('extras_for', $hotelid, 'both');

    $this->db->having('extras_status', 'Yes');

    $ext = $this->db->get('pt_extras')->result();

    $this->ci->load->library('currconverter');

    $curr = $this->ci->currconverter;

    if (!empty($ext)) {

      foreach ($ext as $e) {

        $trans = $this->extrasTranslation($e->extras_id, $e->extras_title, $e->extras_desc);

        $price = $curr->convertPrice($e->extras_basic_price, 0);

        $result[] = (object) array("id" => $e->extras_id, "extraTitle" => $trans['title'], "extraDesc" => $trans['desc'], 'extraPrice' => $price, 'thumbnail' => PT_EXTRAS_IMAGES . $e->extras_image);

      }

    }

    return $result;

  }

  function getHotelTypes() {

    $htypes = pt_get_hsettings_data("htypes");

    $result = array();

    foreach ($htypes as $htype) {

      $trans = $this->amenitiesTranslation($htype->sett_id);

      $result[] = (object) array("id" => $htype->sett_id, "name" => $trans->name);

    }

    return $result;

  }

  function getHotelAmenities() {

    $amts = pt_get_hsettings_data("hamenities");

    $result = array();

    foreach ($amts as $amt) {

      $trans = $this->amenitiesTranslation($amt->sett_id);

      $result[] = (object) array("id" => $amt->sett_id, 'icon' => PT_HOTELS_ICONS . $amt->sett_img, "name" => $trans->name);

    }

    return $result;

  }

// Hotel Amenities translation

  function amenitiesTranslation($id) {

    $language = $this->lang;

    $result = new stdClass;

    $this->db->select('sett_name,sett_img');

    $this->db->where('sett_id', $id);

    $this->db->where('sett_status', 'Yes');

    $re = $this->db->get('pt_hotels_types_settings')->result();

    $result->icon = PT_HOTELS_ICONS . $re[0]->sett_img;

    if ($language == $this->langdef) {

      $result->name = $re[0]->sett_name;

    }

    else {

      $this->db->select('trans_name');

      $this->db->where('sett_id', $id);

      $this->db->where('trans_lang', $language);

      $r = $this->db->get('pt_hotels_types_settings_translation')->result();

      if (empty($r[0]->trans_name)) {

        $result->name = $re[0]->sett_name;

      }

      else {

        $result->name = $r[0]->trans_name;

      }

    }

    return $result;

  }

  function extrasTranslation($id, $title, $desc) {

    $language = $this->lang;

    $this->db->select('trans_title,trans_desc');

    $this->db->where('trans_extras_id', $id);

    $this->db->where('trans_lang', $language);

    $r = $this->db->get('pt_extras_translation')->result();

    if (empty($r[0]->trans_title)) {

      $result['title'] = $title;

    }

    else {

      $result['title'] = $r[0]->trans_title;

    }

    if (empty($r[0]->trans_desc)) {

      $result['desc'] = $desc;

    }

    else {

      $result['desc'] = $r[0]->trans_desc;

    }

    return $result;

  }

// hotel Price

  function hotel_price($basic, $discount) {

    $price = array();

    $price['code'] = $this->currencycode;

    $price['sign'] = $this->currencysign;

    $mulcur = "";

    return $price;

  }

// hotel Reviews

  function hotelReviews($hotelid = null) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $this->db->where('review_status', 'Yes');

    $this->db->where('review_module', 'hotels');

    $this->db->where('review_itemid', $hotelid);

    $this->db->order_by('review_id', 'desc');

    return $this->db->get('pt_reviews')->result();

  }

// hotel Reviews for API

  function hotel_reviews_for_api($hotelid) {

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $this->set_id($hotelid);

    $this->hotel_short_details();

    $tripAdvisorID = $this->tripadvisorid;

    $tripStatus = $this->tripAdvisorStatus();

    if ($tripStatus && !empty($tripAdvisorID)) {

      $avgReviews = $this->tripAdvisorData($tripAdvisorID, NULL, TRUE);

      if (empty($avgReviews->overall)) {

        $result = array();

        $this->db->select('review_overall,review_name,review_comment,review_date');

        $this->db->where('review_status', 'Yes');

        $this->db->where('review_module', 'hotels');

        $this->db->where('review_itemid', $hotelid);

        $this->db->order_by('review_id', 'desc');

        $rs = $this->db->get('pt_reviews')->result();

        foreach ($rs as $r) {

          $result[] = array("review_overall" => $r->review_overall, "review_name" => $r->review_name, "review_comment" => $r->review_comment, "review_date" => pt_show_date_php($r->review_date), 'maxRating' => 10);

        }

      }

      else {

        $result = $avgReviews->reviews;

      }

    }

    else {

      $result = array();

      $this->db->select('review_overall,review_name,review_comment,review_date');

      $this->db->where('review_status', 'Yes');

      $this->db->where('review_module', 'hotels');

      $this->db->where('review_itemid', $hotelid);

      $this->db->order_by('review_id', 'desc');

      $rs = $this->db->get('pt_reviews')->result();

      foreach ($rs as $r) {

        $result[] = array("review_overall" => $r->review_overall, "review_name" => $r->review_name, "review_comment" => $r->review_comment, "review_date" => pt_show_date_php($r->review_date), 'maxRating' => 10);

      }

    }

    return $result;

  }

// hotel Reviews Averages

  function hotelReviewsAvg($hotelid = 0) {

    $clean = 0;

    $comfort = 0;

    $location = 0;

    $facilities = 0;

    $staff = 0;

    $totalreviews = 0;

    $overall = 0;

    if (pt_is_module_enabled('hotels')) {

      if (empty($hotelid)) {

        $hotelid = $this->hotelid;

      }

      $this->db->select("COUNT(*) AS totalreviews");

      $this->db->select_avg('review_overall', 'overall');

      $this->db->select_avg('review_clean', 'clean');

      $this->db->select_avg('review_facilities', 'facilities');

      $this->db->select_avg('review_staff', 'staff');

      $this->db->select_avg('review_comfort', 'comfort');

      $this->db->select_avg('review_location', 'location');

      $this->db->where('review_status', 'Yes');

      $this->db->where('review_module', 'hotels');

      $this->db->where('review_itemid', $hotelid);

      $res = $this->db->get('pt_reviews')->result();

      $clean = round($res[0]->clean, 1);

      $comfort = round($res[0]->comfort, 1);

      $location = round($res[0]->location, 1);

      $facilities = round($res[0]->facilities, 1);

      $staff = round($res[0]->staff, 1);

      $totalreviews = $res[0]->totalreviews;

      $overall = round($res[0]->overall, 1);

    }

    $result = (object) array('clean' => $clean, 'comfort' => $comfort, 'location' => $location, 'facilities' => $facilities, 'staff' => $staff, 'totalReviews' => $totalreviews, 'overall' => $overall);

    return $result;

  }

  function getLocationsList() {

    $resultLocations = array();

    $this->db->select('hotel_city');

    $this->db->group_by('hotel_city');

    $locations = $this->db->get('pt_hotels')->result();

    foreach ($locations as $loc) {

      $locInfo = pt_LocationsInfo($loc->hotel_city, $this->lang);

      if (!empty($locInfo->city)) {

        $resultLocations[] = (object) array('id' => $locInfo->id, 'name' => $locInfo->city);

      }

    }

    return $resultLocations;

  }


  function translated_data($lang) {

    $this->db->where('item_id', $this->hotelid);

    $this->db->where('trans_lang', $lang);

    return $this->db->get('pt_hotels_translation')->result();

  }

  function room_short_details($id) {

    $this->db->select('room_id,room_quantity,room_type,room_title,room_desc,room_adults,room_children,room_amenities,thumbnail_image,extra_bed,extra_bed_charges,room_adult_price,room_child_price,price_type');

    $this->db->where('pt_rooms.room_id', $id);

    $details = $this->db->get('pt_rooms')->result();

//$this->roomtitle = $this->get_room_title($details[0]->room_title, $id);

    $this->roomtitle = $this->getRoomType($details[0]->room_type);

    $this->roomdesc = $this->get_room_description($details[0]->room_desc, $id);

    $roomAmenities = explode(",", $details[0]->room_amenities);

    foreach ($roomAmenities as $rm) {

      $amtsRoom[] = $this->amenitiesTranslation($rm);

    }

    $details['amenities'] = $amtsRoom;

// $this->room_price($id,$currsign,$currcode);

    return $details;

  }

  function getRoomTitleOnly($id) {

    $this->db->select('room_title,room_type');

    $this->db->where('room_id', $id);

    $details = $this->db->get('pt_rooms')->result();

//$roomTitle = $this->get_room_title($details[0]->room_title, $id);

    $roomTitle = $this->getRoomType($details[0]->room_type);

    return $roomTitle;

  }

  function get_room_title($deftitle, $id) {

    if ($this->lang == $this->langdef) {

      $title = $deftitle;

    }

    else {

      $this->db->where('item_id', $id);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_rooms_translation')->result();

      $title = $res[0]->trans_title;

      if (empty($title)) {

        $title = $deftitle;

      }

    }

    return $title;

  }

  function available_rooms() {

    $this->ci->load->helper('check');

    $result = array();

    $rooms = $this->rooms_id_title_only();

    foreach ($rooms as $room) {

      $unavail = pt_is_room_unvailable($room->room_id, $this->checkin, $this->checkout);

      $bookedrooms = pt_is_room_booked($room->room_id, $this->checkin, $this->checkout);

      $maxadults = true;

      $maxchild = true;

      $minstay = $room->room_min_stay;

      if ($this->adults > $room->room_adults) {

        $maxadults = false;

      }

      else {

        $maxadults = true;

      }

      if ($this->children > $room->room_children) {

        $maxchild = false;

      }

      else {

        $maxchild = true;

      }

      $totalroomscount = $room->room_quantity;

      $availablerooms = $totalroomscount - $bookedrooms;

      if (!$unavail && $availablerooms > 0 && $maxadults && $maxchild && $minstay <= $this->stay) {

        $roomdetails = $this->room_short_details($room->room_id);

        $result[] = array('hotelid' => $this->hotelid, 'id' => $room->room_id, 'roomlargethumb' => $this->roomlargethumb, 'roomsmallthumb' => $this->roomsmallthumb, 'roomtitle' => $this->roomtitle, 'desc' => $this->roomdesc, 'roomprice' => $this->roomprice, 'available_quantity' => $availablerooms, 'totalquantity' => $room->room_quantity, 'room_children' => $roomdetails[0]->room_children, 'room_adults' => $roomdetails[0]->room_adults, 'room_size' => $roomdetails[0]->room_size, 'room_bed_size' => $roomdetails[0]->room_bed_size, 'roomspecials' => $this->roomspecials, 'roomadditional' => $this->roomadditional, 'room_amenities' => $roomdetails[0]->room_amenities);

      }

    }

    if (!empty($result)) {

      $this->roomsavailable = true;

    }

    else {

      $this->roomsavailable = false;

    }

    return $result;

  }

  function validroomscount($shortdetails) {

    $this->roomscounterror = "";

// $unavail =  pt_is_room_unvailable($shortdetails[0]->room_id,$this->checkin,$this->checkout);

    $bookedrooms = pt_is_room_booked($shortdetails[0]->room_id, $this->checkin, $this->checkout);

    $availablerooms = $shortdetails[0]->room_quantity - $bookedrooms;

    if ($this->children > $shortdetails[0]->room_children) {

      $this->roomscounterror = "Maximum children exceeded.";

    }

    if ($this->adults > $shortdetails[0]->room_adults) {

      $this->roomscounterror = "Maximum Adults exceeded.";

    }

    if ($availablerooms < $this->roomscount) {

      $this->roomscounterror = "Room Not available for booking.";

    }

  }

  function get_room_description($defdesc, $id) {

    if ($this->lang == $this->langdef) {

      $desc = $defdesc;

    }

    else {

      $this->db->where('item_id', $id);

      $this->db->where('trans_lang', $this->lang);

      $res = $this->db->get('pt_rooms_translation')->result();

      $desc = $res[0]->trans_desc;

      if (empty($desc)) {

        $desc = $defdesc;

      }

    }

    return $desc;

  }

  function rooms_translated_data($lang, $id) {

    $this->db->where('item_id', $id);

    $this->db->where('trans_lang', $lang);

    return $this->db->get('pt_rooms_translation')->result();

  }

  function room_total_quantity($id) {

    $this->db->select('room_quantity');

    $this->db->where('room_id', $id);

    $res = $this->db->get('pt_rooms')->result();

    if (!empty($res)) {

      return $res[0]->room_quantity;

    }

    else {

      return '0';

    }

  }

  function hotel_tax_commision() {

    $res = array();

    $this->db->select('hotel_comm_fixed,hotel_comm_percentage,hotel_tax_fixed,hotel_tax_percentage');

    $this->db->where('hotel_id', $this->hotelid);

    $result = $this->db->get('pt_hotels')->result();

    $commfixed = $result[0]->hotel_comm_fixed;

    $commper = $result[0]->hotel_comm_percentage;

    $taxfixed = $result[0]->hotel_tax_fixed;

    $taxper = $result[0]->hotel_tax_percentage;

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

    return $res;

  }

  function is_featured() {

    $this->db->select('hotel_id');

    $this->db->where('hotel_is_featured', 'yes');

    $this->db->where('hotel_featured_from <', time());

    $this->db->where('hotel_featured_to >', time());

    $this->db->where('hotel_id', $this->hotelid);

    return $this->db->get('pt_hotels')->num_rows();

  }

  function specialofferslist($limit = 0) {

    $this->db->select('offer_item');

    $this->db->where('pt_special_offers.offer_from <=', time());

    $this->db->where('pt_special_offers.offer_to >=', time());

    $this->db->where_in('pt_special_offers.offer_module', 'hotels');

    $this->db->where('pt_special_offers.offer_status', '1');

    $this->db->order_by('pt_special_offers.offer_item', 'desc');

    $this->db->limit($limit);

    return $this->db->get('pt_special_offers')->result();

  }

  function featured_hotels_list() {

    $settings = $this->settings();

    $limit = $settings[0]->front_homepage;

    $orderby = $settings[0]->front_homepage_order;

    $this->db->select('hotel_id,hotel_order,hotel_title,hotel_status,hotel_basic_price');

    $this->db->where('hotel_is_featured', 'yes');

    $this->db->where('hotel_featured_from <', time());

    $this->db->where('hotel_featured_to >', time());

    $this->db->or_where('hotel_featured_forever', 'forever');

    $this->db->having('hotel_status', 'Yes');

    $this->db->limit($limit);

    if ($orderby == "za") {

      $this->db->order_by('pt_hotels.hotel_title', 'desc');

    }

    elseif ($orderby == "az") {

      $this->db->order_by('pt_hotels.hotel_title', 'asc');

    }

    elseif ($orderby == "oldf") {

      $this->db->order_by('pt_hotels.hotel_id', 'asc');

    }

    elseif ($orderby == "newf") {

      $this->db->order_by('pt_hotels.hotel_id', 'desc');

    }

    elseif ($orderby == "ol") {

      $this->db->order_by('pt_hotels.hotel_order', 'asc');

    }

    return $this->db->get('pt_hotels')->result();

  }

  function getFeaturedHotels() {
    $hotels = $this->featured_hotels_list();

    $result = $this->getResultObject($hotels);

    return $result;

  }

    function getFeaturedHotelsmain($lang,$currency) {
        $this->ci->load->model('Hotels/Hotels_model');
        $this->lang = $lang;
        $hotels = $this->featured_hotels_list();
        $result = $this->getResultObject($hotels);
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
                'amenities'=>$value->amenities,
                'avgReviews'=>$value->avgReviews,
                'latitude'=>$value->latitude,
                'longitude'=>$value->longitude,
                'discount'=>$value->discount,
                'address'=>$value->address,
                'price'=>$price,
                'currCode'=>$currency,
            ]);


        }
        return $results;

    }
  function getTopRatedHotels() {

    $hotels = $this->ci->Hotels_model->popular_hotels_front();

    $result = $this->getResultObject($hotels);

    return $result;

  }

  function getRelatedHotels($hotels) {

    $resulthotels = array();

    $result = array();

    $settings = $this->settings();

    $limit = $settings[0]->front_related;

    $count = 0;

    if (!empty($hotels)) {

      foreach ($hotels as $h) {

        $count++;

        if($count <= $limit){

        $resulthotels[] = (object) array('hotel_id' => $h);

        }

      }

    }

    $result = $this->getLimitedResultObject($resulthotels);

    return $result;

  }

  function hero_hotels_list() {

    $this->db->select('front_homepage_hero');

    $rslt = $this->db->get('pt_front_settings')->result();

    $hotels = $rslt[0]->front_homepage_hero;

    if (!empty($hotels)) {

      $herohotels = explode(",", $hotels);

    }

    else {

      $herohotels = "";

    }

    return $herohotels;

  }

  function mini_hero_hotels_list() {

    $this->db->select('front_homepage_small_hero');

    $rslt = $this->db->get('pt_front_settings')->result();

    $minihotels = $rslt[0]->front_homepage_small_hero;

    if (!empty($minihotels)) {

      $miniherohotels = explode(",", $minihotels);

    }

    else {

      $miniherohotels = "";

    }

    return $miniherohotels;

  }

// List 2 top rated hotels from each city passed to to this function

  function top_rated_hotels($city) {

    $this->db->select('pt_hotels.hotel_id');

    $this->db->select_avg('pt_reviews.review_overall', 'overall');

    $this->db->where('pt_hotels.hotel_city', $city);

    $this->db->group_by('pt_hotels.hotel_id');

    $this->db->join('pt_reviews', 'pt_hotels.hotel_id = pt_reviews.review_itemid', 'left');

    $this->db->where('pt_hotels.hotel_status', '1');

    $this->db->order_by('pt_reviews.review_overall', 'desc');

    $this->db->limit(2);

    return $this->db->get('pt_hotels')->result();

  }

  function bestPrice($hotelid = null) {

    $this->ci->load->library('currconverter');

    $curr = $this->ci->currconverter;

    if (empty($hotelid)) {

      $hotelid = $this->hotelid;

    }

    $this->ci->load->model('Hotels/Rooms_model');

    $this->db->select('room_id');

    $this->db->where('room_hotel', $hotelid);

    $res = $this->db->get('pt_rooms')->result();

    foreach ($res as $r) {

      $p = $this->ci->Rooms_model->getRoomPrice($r->room_id, $this->checkin, $this->checkout);

      if($p['price_type'] == 1){
          $ad_ch = $p['room_child_price'] + $p['room_adult_price'];
          $result[] = $ad_ch;
      }else {
          $result[] = $p['perNight'];
      }
//  $result[] = $p;

    }
    $down_price = min($result);
    $price = $curr->convertPrice($down_price);

    return $price;

//  return $result;

  }

  function hotelswithrooms() {

    $this->ci->load->helper('check');

    $result = array();

    $this->db->select('hotel_id');

    $this->db->where('hotel_status', 'Yes');

    $hotels = $this->db->get('pt_hotels')->result();

    foreach ($hotels as $hotel) {

      $rooms = $this->rooms_id_title_only($hotel->hotel_id);

      foreach ($rooms as $room) {

        $unavail = pt_is_room_unvailable($room->room_id, $this->checkin, $this->checkout);

        $bookedrooms = pt_is_room_booked($room->room_id, $this->checkin, $this->checkout);

        $totalroomscount = $room->room_quantity;

        $availablerooms = $totalroomscount - $bookedrooms;

        if (!$unavail && $availablerooms > 0) {

          if (!in_array($hotel->hotel_id, $result['hotels'])) {

            $result['hotels'][] = $hotel->hotel_id;

          }

          $result['rooms'][] = $room->room_id;

        }

      }

    }

    return $result;

  }

  function paymethodFee($id, $total) {

    $result = 0;

    $this->db->select('payment_percentage');

    $this->db->where('payment_id', $id);

    $res = $this->db->get('pt_payment_gateways')->result();

    if (!empty($res) && $total > 0) {

      $result = round($total * $res[0]->payment_percentage / 100, 2);

    }

    return $result;

  }

  function extrasFee($exts) {

    $extFee = 0;

    $result['extrasIndividualFee'] = array();

    $result['extrasInfo'] = array();

    $result['extrasTotalFee'] = array();

    $this->ci->load->library('currconverter');

    $curr = $this->ci->currconverter;

    if (isset($exts) && ! empty($exts))

    {
      $exts = is_array($exts)?$exts:[$exts];

      foreach ($exts as $ext) {

        $this->db->select('extras_title,extras_desc,extras_discount,extras_basic_price');

        $this->db->where('extras_id', $ext);

        $rs = $this->db->get('pt_extras')->result();

        $amount = $rs[0]->extras_basic_price;

        $price = $curr->convertPriceFloat($amount, 2);

        $extFee += $amount;

        $info = $this->extrasTranslation($ext, $rs[0]->extras_title, $rs[0]->extras_desc);

        $result['extrasIndividualFee'][] = array("id" => $ext, "price" => $price);

        $result['extrasInfo'][] = array("title" => $info['title'], "price" => $price);

      }

    }

    $result['extrasTotalFee'] = $extFee;

    return $result;

  }

  function setDeposit($total) {

    if ($this->comm_type == "fixed") {

      $this->deposit = round($this->comm_value, 2);

    }

    else {

      $this->deposit = round(($total * $this->comm_value) / 100, 2);

    }

  }

  function setTax($amount) {

    if ($this->tax_type == "fixed") {

      $this->taxamount = round($this->tax_value, 2);

    }

    else {

      $this->taxamount = round(($amount * $this->tax_value) / 100, 2);

    }
  }

//make a result object all data of hotels array

  function getResultObject($hotels) {

    $this->ci->load->library('currconverter');

    $result = array();

    $curr = $this->ci->currconverter;
//dd($hotels);
    foreach ($hotels as $h) {

      $this->set_id($h->hotel_id);

      $this->hotel_short_details();


      $bestprice = $this->bestPrice();

      $price = $bestprice;

      $discount = $this->discount($h->hotel_id);

      $tripAdvisorID = $this->tripadvisorid;

      $tripStatus = $this->tripAdvisorStatus();


      if ($tripStatus && !empty($tripAdvisorID)) {

        $avgReviews = $this->tripAdvisorData($tripAdvisorID);

        if (empty($avgReviews->overall)) {

          $avgReviews = $this->hotelReviewsAvg();

        }

      }

      else {

        $avgReviews = $this->hotelReviewsAvg(NULL);

      }

      $priceRange = $this->priceRange(@$_GET['price']);

      if (!empty($_GET['price'])) {

        if (($price >= $priceRange->minprice) && ($price <= $priceRange->maxprice)) {

          $result[] = (object) array('id' => $this->hotelid, 'title' => $this->title, 'slug' => base_url() . 'hotels/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'desc' => strip_tags($this->desc), 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'amenities' => $this->amenities, 'avgReviews' => $avgReviews, 'latitude' => $this->latitude, 'longitude' => $this->longitude,'discount' => $discount,'address'=>$this->hoteladdress,'b2c_markup'=>$h->b2c_markup,'b2b_markup'=>$h->b2b_markup,'b2e_markup'=>$h->b2e_markup,'service_fee'=>$h->service_fee);

        }

      }


      else {

        $result[] = (object) array('id' => $this->hotelid, 'title' => $this->title, 'slug' => base_url() . 'hotels/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'desc' => strip_tags($this->desc), 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'amenities' => $this->amenities, 'avgReviews' => $avgReviews, 'latitude' => $this->latitude, 'longitude' => $this->longitude,'discount' => $discount,'address'=>$this->hoteladdress,'b2c_markup'=>$h->b2c_markup,'b2b_markup'=>$h->b2b_markup,'b2e_markup'=>$h->b2e_markup,'service_fee'=>$h->service_fee);

      }

    }

    $this->currencycode = $curr->code;

    $this->currencysign = $curr->symbol;

    return $result;

  }

//make a result object limited data of hotels array

  function getLimitedResultObject($hotels) {

    $this->ci->load->library('currconverter');

    $result = array();

    $curr = $this->ci->currconverter;

    if (!empty($hotels)) {

      foreach ($hotels as $h) {

        $this->set_id($h->hotel_id);

        $this->hotel_short_details();

        $bestprice = $this->bestPrice();

        $price = $bestprice;

        $tripAdvisorID = $this->tripadvisorid;

        $tripStatus = $this->tripAdvisorStatus();

        if ($tripStatus && !empty($tripAdvisorID)) {

          $avgReviews = $this->tripAdvisorData($tripAdvisorID);

          if (empty($avgReviews->overall)) {

            $avgReviews = $this->hotelReviewsAvg();

          }

        }

        else {

          $avgReviews = $this->hotelReviewsAvg();

        }

        if (!empty($this->title)) {

          $result[] = (object) array('id' => $this->hotelid, 'title' => $this->title, 'desc' => $this->desc, 'slug' => base_url() . 'hotels/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars),'starsCount' => $this->stars, 'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'avgReviews' => $avgReviews, 'latitude' => $this->latitude, 'longitude' => $this->longitude);

        }

      }

    }

    $this->currencycode = $curr->code;

    $this->currencysign = $curr->symbol;

    return $result;

  }

//make a result object of Rooms Array

  function getRoomsResultObject($rooms, $checkin = null, $checkout = null) {

    if (empty($checkin)) {

      $checkin = $this->checkin;

    }

    if (empty($checkout)) {

      $checkout = $this->checkout;

    }

    $this->ci->load->library('currconverter');

    $this->ci->load->helper('check');

    $Roomresult = array();

    $curr = $this->ci->currconverter;

    $this->ci->load->model('Hotels/Rooms_model');

    foreach ($rooms as $room) {

      $details = $this->room_short_details($room->id);

      $extrabeds = $details[0]->extra_bed;

      $room_adult_price = $details[0]->room_adult_price;

      $room_child_price = $details[0]->room_child_price;

        $price_type = $details[0]->price_type;

      $images = $this->roomImages($room->id, 5);
      $this->ci->Rooms_model->adults = $this->adults;
      $this->ci->Rooms_model->children = $this->children;
      $roomprice = $this->ci->Rooms_model->getRoomPrice($room->id, $checkin, $checkout);
      $bookedRooms = pt_is_room_booked($room->id, $checkin, $checkout);

      $checkAvail = ptRoomAvailability($room->id, $checkin, $checkout);

      $chkArray = $checkAvail->dateByDate;

      if ($checkAvail->isAvailable) {

        if (!empty($chkArray)) {

          if ($chkArray[0] > 0 && $chkArray[0] != $details[0]->room_quantity) {

            $availQuantity = $chkArray[0] - $bookedRooms;

          }

          else {

            $availQuantity = $details[0]->room_quantity - $bookedRooms;

          }

        }

        else {

          $availQuantity = $details[0]->room_quantity - $bookedRooms;

        }

      }

      else {

        $availQuantity = 0;

      }

      $bedcharges = $curr->convertPriceFloat($roomprice['extrabed'], 0);

      $price = $curr->convertPrice($roomprice['totalPrice'], 0);

      if ($roomprice['maxAdults'] >= $this->adults && $roomprice['maxChild'] >= $this->children) {

        $Roomresult[] = (object) array('id' => $room->id, 'title' => $this->roomtitle, 'desc' => $this->roomdesc, 'maxAdults' => $details[0]->room_adults, 'maxChild' => $details[0]->room_children, 'maxQuantity' => $availQuantity, 'thumbnail' => PT_ROOMS_THUMBS . $details[0]->thumbnail_image, 'Images' => $images, 'Amenities' => $details['amenities'], 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'Info' => $roomprice, 'extraBeds' => $extrabeds, 'extrabedCharges' => $bedcharges,'room_adult_price'=>$room_adult_price,'room_child_price' =>$room_child_price,'price_type'=>$price_type);

      }

    }

    return $Roomresult;

  }

//make a result object of Rooms Array

  function getBookResultObject($hotelid, $roomid, $roomscount, $extrabeds = 0, $checkin = null, $checkout = null) {

    if (empty($checkin)) {

      $checkin = $this->checkin;

    }

    if (empty($checkout)) {

      $checkout = $this->checkout;

    }

    $extrasCheckUrl = base_url() . 'admin/hotelajaxcalls/hotelExtrasBooking';

    $this->ci->load->library('currconverter');

    $result = array();

    $curr = $this->ci->currconverter;

    $this->ci->load->model('Hotels/Rooms_model');

//room details for booking page

    $details = $this->room_short_details($roomid);

    $this->ci->Rooms_model->adults = $this->adults; 
    $this->ci->Rooms_model->children = $this->children; 
    
    $roomprice = $this->ci->Rooms_model->getRoomPrice($roomid, $checkin, $checkout);

    $perNight = $curr->convertPrice($roomprice['perNight']);

//hotel details for booking page

    $this->set_id($hotelid);

    $this->hotel_short_details();

    $extras = $this->hotelExtras();

    $extrabedcharges = $roomprice['extrabed'] * $extrabeds;

    $totalSum = ($roomprice['totalPrice'] * $roomscount) + $extrabedcharges;
    
    $this->setTax($totalSum);

    $taxAmount = $curr->convertPrice($this->taxamount);

    $totalPrice = $totalSum;// + $this->taxamount;

    $bedcharges = $curr->convertPrice($extrabedcharges);

    $price = $curr->convertPrice($totalPrice);

    $this->setDeposit($totalPrice);

    $depositAmount = $curr->convertPrice($this->deposit);

    $result["room"] = (object) array('id' => $roomid, 'title' => $this->roomtitle, 'desc' => $this->roomdesc, 'maxAdults' => $details[0]->room_adults, 'maxChild' => $details[0]->room_children, 'maxQuantity' => $details[0]->room_quantity, 'thumbnail' => PT_ROOMS_THUMBS . $details[0]->thumbnail_image, 'Images' => $images, 'Amenities' => $details['amenities'], 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'perNight' => $perNight, 'Info' => $roomprice, 'stay' => $roomprice['stay'], 'roomscount' => $roomscount, 'extraBedCharges' => $bedcharges, 'extraBedsCount' => $extrabeds);

//end room details for booking page

    $result["hotel"] = (object) array('id' => $this->hotelid, 'title' => $this->title, 'slug' => base_url() . 'hotels/' . $this->slug, 'bookingSlug' => $this->bookingSlug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'checkin' => $checkin, 'checkout' => $checkout, 'metadesc' => $this->metadesc, 'keywords' => $this->keywords, 'extras' => $extras, 'taxAmount' => $taxAmount, 'depositAmount' => $depositAmount, 'policy' => $this->policy, 'extraChkUrl' => $extrasCheckUrl, 'adults' => $this->adults, 'children' => $this->children);

//end hotel details for booking page

    return $result;

  }

//get updated values of booking data after extras and payment method updates

  function getUpdatedDataBookResultObject($hotelid, $roomid, $checkin, $checkout, $roomscount, $extras, $extrabeds = 0, $adults = 0, $_taxamount = 0) {

    $this->ci->load->library('currconverter');

    $result = array();

    $curr = $this->ci->currconverter;

    $this->ci->load->model('Hotels/Rooms_model');

//room details for booking page

    $details = $this->room_short_details($roomid);

    $extratotal = $this->extrasFee($extras);

    $this->ci->Rooms_model->adults = $adults;
    $this->ci->Rooms_model->children = 0;

    $roomprice = $this->ci->Rooms_model->getRoomPrice($roomid, $checkin, $checkout);

    $extrabedcharges = $roomprice['extrabed'] * $extrabeds;

    $total = ($roomprice['totalPrice'] * $roomscount) + $extratotal['extrasTotalFee'] + $extrabedcharges; // Tax will only impose on basic price.

    $paymethodTotal = 0; //$this->paymethodFee($this->ci->input->post('paymethod'),$total);

    $this->set_id($hotelid);

    $this->hotel_short_details();

    $this->setTax($total);

    if (!empty($_taxamount)) { // on extra for single room.
      $this->taxamount = $_taxamount;
    }
    if ($_taxamount == 'ignore') {
      $this->taxamount = 0;
    }
    
    $taxAmount = $curr->convertPrice($this->taxamount);

    $grandTotal = $total + $paymethodTotal + $this->taxamount;

    $this->setDeposit($grandTotal);

    $depositAmount = $curr->convertPrice($this->deposit);

    $bedcharges = $curr->convertPrice($extrabedcharges);

    $price = $curr->convertPrice($grandTotal);

    $perNight = $curr->convertPriceFloat($roomprice['perNight'], 2);

    $extrasHtml = "";

    if(isset($extratotal['extrasInfo']) && ! empty($extratotal['extrasInfo'])) {

      foreach ($extratotal['extrasInfo'] as $einfo) {

        $extrasHtml .= "<tr class='allextras'><td>" . $einfo['title'] . "</td>

                      <td class='text-right'>" . $curr->code . " " . $curr->symbol . $einfo['price'] . "</td></tr>";

      }

    }

    

    $subitem = array("id" => $roomid, "price" => $perNight, "count" => $roomscount);

    $result = (object) array('grandTotal' => $price, 'taxAmount' => $taxAmount, 'depositAmount' => $depositAmount, 'extrashtml' => $extrasHtml, 'bookingType' => "hotels", 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'subitem' => $subitem, 'stay' => $roomprice['stay'], 'extrasInfo' => $extratotal, 'extraBedCharges' => $bedcharges);

//end hotel details for booking page

    return json_encode($result);

  }

//convert price

  public function convertAmount($price) {

    $this->ci->load->library('currconverter');

    $curr = $this->ci->currconverter;

    return $curr->convertPriceFloat($price, 0);

  }

  public function convertPriceRange($price) {

    $this->ci->load->library('currconverter');

    $curr = $this->ci->currconverter;

    return $curr->convertPriceRange($price, 0);

  }

  public function priceRange($sprice) {

    $sprice = str_replace(";", ",", $sprice);

    $sprice = explode(",", $sprice);

    $result = new stdClass;

    $result->minprice = $sprice[0];

    $result->maxprice = isset($sprice[1]) ? $sprice[1] : 0;

    return $result;

  }

  public function siteMapData() {

    $hotelsData = array();

    $this->db->select('hotel_id');

    $this->db->where('hotel_status', 'Yes');

    $result = $this->db->get('pt_hotels');

    $hotels = $result->result();

    if (!empty($hotels)) {

      $hotelsData = $this->getLimitedResultObject($hotels);

    }

    return $hotelsData;

  }

// Get Room Type to show instead of title

  function getRoomType($id) {

    $language = $this->lang;

    $result = new stdClass;

    $this->db->select('sett_name,sett_img');

    $this->db->where('sett_id', $id);

    $this->db->where('sett_type', "rtypes");

    $re = $this->db->get('pt_hotels_types_settings')->result();

    if ($language == $this->langdef) {

      $result = $re[0]->sett_name;

    }

    else {

      $this->db->select('trans_name');

      $this->db->where('sett_id', $id);

      $this->db->where('trans_lang', $language);

      $r = $this->db->get('pt_hotels_types_settings_translation')->result();

      if (empty($r[0]->trans_name)) {

        $result = $re[0]->sett_name;

      }

      else {

        $result = $r[0]->trans_name;

      }

    }

    return $result;

  }


    public function getLocationsListsearch()
    {

        $this->db->select('pt_hotels.hotel_id as id, pt_hotels_translation.trans_title, pt_hotels.hotel_title, (

            select location from pt_locations where id = pt_hotels.hotel_city) as city');

        $this->db->join('pt_hotels_translation', 'pt_hotels.hotel_id = pt_hotels_translation.item_id', 'left');

        $this->db->group_by('pt_hotels.hotel_id');

        $this->db->limit('25');

        $res = $this->db->get('pt_hotels')->result();

        $hotels = array();

        if (!empty($res)) {

            foreach ($res as $r) {

                $title = (empty($r->trans_title))?$r->hotel_title:$r->trans_title;

                $title = $this->get_title($title, $r->id);

                $hotels[] = (object) array(

                    'id' => str_replace(' ','-',strtolower($r->city))."/".str_replace(' ','-',strtolower($r->hotel_title)),

                    'text' => $title.", ".$r->city,

                    'module' => 'hotel',

                    'disabled' => false

                );

            }

        }


        $locres = $this->db->query("
            SELECT  DISTINCT `pt_locations`.`country`, `pt_locations`.`location`  FROM `pt_locations` INNER JOIN `pt_hotels` ON `pt_hotels`.`hotel_city` = `pt_locations`.`id`  LIMIT 50
            ")->result();

        if (!empty($locres)) {

            foreach ($locres as $locInfo) {

                //$locInfo = pt_LocationsInfo($l->id, $this->lang);

                $locations[] = (object) array(

                    'id' => str_replace(' ','-',strtolower($locInfo->country))."/".str_replace(' ','-',strtolower($locInfo->location)),

                    'text' => $locInfo->location.", ".$locInfo->country,

                    'module' => 'location',

                    'disabled' => false

                );

            }

        }

//        $locations = $this->db->query("
//        SELECT CONCAT(country, '/', location) AS id, CONCAT(location, ', ',country) AS text, 'location' AS `module`, 'false' AS disabled
//        FROM `pt_locations` LIMIT 50
//      ")->result();

        $resultin_array = [
            ["text" => "Hotels", "children" => $hotels],
            ["text" => "Locations", "children" => $locations]
        ];
        return json_encode($resultin_array);
    }
    public function suggestionResults_v2($query) {

    if($version > 5.6)
            {
                $ci->db->query('SET SESSION sql_mode = ""');
                $ci->db->query('SET SESSION sql_mode =
                          REPLACE(REPLACE(REPLACE(
                          @@sql_mode,
                          "ONLY_FULL_GROUP_BY,", ""),
                          ",ONLY_FULL_GROUP_BY", ""),
                          "ONLY_FULL_GROUP_BY", "")');
            }

        $response = array();

        $this->db->select('pt_hotels.hotel_id as id, pt_hotels_translation.trans_title, pt_hotels.hotel_title, (

            select location from pt_locations where id = pt_hotels.hotel_city) as city');

        $this->db->like('pt_hotels.hotel_title', $query);

        $this->db->or_like('pt_hotels_translation.trans_title', $query);

        $this->db->join('pt_hotels_translation', 'pt_hotels.hotel_id = pt_hotels_translation.item_id', 'left');

        $this->db->group_by('pt_hotels.hotel_id');

        $this->db->limit('25');

        $res = $this->db->get('pt_hotels')->result();

        $hotels = array();

        $locations = array();

        $this->db->select('id,country,location as city');

        $this->db->like('location', $query);

        $this->db->limit('25');

        $locres = $this->db->get('pt_locations')->result();

        if (!empty($locres)) {

            foreach ($locres as $l) {

                $locInfo = pt_LocationsInfo($l->id, $this->lang);

                $locations[] = (object) array(

                    'id' => str_replace(' ','-',strtolower($locInfo->country))."/".str_replace(' ','-',strtolower($l->city)),

                    'text' => $locInfo->city.", ".$locInfo->country,

                    'module' => 'location',

                    'disabled' => false,
                    'loc_id' => $locInfo->id

                );

            }

        }

        if (!empty($res)) {

            foreach ($res as $r) {

                $title = (empty($r->trans_title))?$r->hotel_title:$r->trans_title;

                $title = $this->get_title($title, $r->id);

                $hotels[] = (object) array(

                    'id' => str_replace(' ','-',strtolower($r->city))."/".str_replace(' ','-',strtolower($r->hotel_title)),

                    'text' => $title.", ".$r->city,

                    'module' => 'hotel',

                    'disabled' => false,

                    'loc_id' => $locInfo->id

                );

            }

        }



        $hh = array("text" => "Hotels", "children" => $hotels);

        $ll = array("text" => "Locations", "children" => $locations);

        if(!empty($hotels)){

            $response[] = $hh;

        }

        if(!empty($locations)){

            $response[] = $ll;

        }



        $responseApi = array_merge($hotels, $locations);

        $dataResponse['forApi'] = array("items" => $responseApi);



        $dataResponse['forWeb'] = $response;

        return $dataResponse;

    }



  public function suggestionResults($query) {

    $response = array();

    $this->db->select('pt_hotels_translation.trans_title as title,pt_hotels.hotel_id as id,pt_hotels.hotel_title as title');

    $this->db->like('pt_hotels.hotel_title', $query);

    $this->db->or_like('pt_hotels_translation.trans_title', $query);

    $this->db->join('pt_hotels_translation', 'pt_hotels.hotel_id = pt_hotels_translation.item_id', 'left');

    $this->db->group_by('pt_hotels.hotel_id');

    $this->db->limit('25');

    $res = $this->db->get('pt_hotels')->result();

    $hotels = array();

    $locations = array();

    $this->db->select('id,location');

    $this->db->like('location', $query);

//$this->db->or_like('country',$query);

    $this->db->limit('50');

    $locres = $this->db->get('pt_locations')->result();

    if (!empty($locres)) {

      //$locations[] = (object) array('id' => '', 'name' => '', 'module' => 'location', 'disabled' => true);

      foreach ($locres as $l) {

        $locInfo = pt_LocationsInfo($l->id, $this->lang);

        $locations[] = (object) array('id' => $l->id, 'text' => $locInfo->city.", ".$locInfo->country, 'module' => 'location', 'disabled' => false);

      }

    }

    if (!empty($res)) {

      foreach ($res as $r) {

        $title = $this->get_title($r->title, $r->id);

        $hotels[] = (object) array('id' => $r->id, 'text' => trim($title), 'module' => 'hotel', 'disabled' => false);

      }

    }

    $hh = array("text" => "Hotels", "children" => $hotels);

    $ll = array("text" => "Locations", "children" => $locations);

    if(!empty($hotels)){

      $response[] = $hh;

    }

  if(!empty($locations)){

    $response[] = $ll;

  }



  $responseApi = array_merge($hotels, $locations);

  $dataResponse['forApi'] = array("items" => $responseApi);



   $dataResponse['forWeb'] = $response;

   return $dataResponse;

  }

// TripAdvisor Reviews Averages

  function tripAdvisorData($id, $tripInfo = null, $fromApi = false) 

  {

    if (!empty($tripInfo)) 

    {

      $info = $tripInfo;

    }

    else {

      $info = tripAdvisorInfo($id);

    }

    

    $reviewsData = array();

    if (property_exists($info, "reviews"))

    {

        $reviews = $info->reviews;

        foreach ($reviews as $rev) {

          $date = explode("T", $rev->published_date);

          $fdate = strtotime($date[0]);

          if ($fromApi) {

            $fdate = pt_show_date_php(strtotime($date[0]));

          }

          $reviewsData[] = (object) array('id' => $rev->id, 'review_comment' => $rev->text, 'review_name' => $rev->user->username, 'review_overall' => $rev->rating, 'maxRating' => 5, 'reviewUrl' => $rev->url, 'review_date' => $fdate);

        }

    }



    $result = (object) array(

      'totalReviews' => @$info->num_reviews, 

      'overall' => @$info->rating, 

      'imgUrl' => @$info->rating_image_url, 

      'reviews' => $reviewsData

    );

    return $result;

  }

  function tripAdvisorStatus() {

    $tripmodule = $this->ci->ptmodules->is_mod_available_enabled("tripadvisor");

    return $tripmodule;

  }

  function getLatestHotelsForAPI() {

    $this->ci->db->select('hotel_id,hotel_created_at');

    $this->ci->db->order_by('hotel_created_at', 'desc');

    $this->ci->db->limit('10');

    $items = $this->ci->db->get('pt_hotels')->result();

    $this->ci->load->library('currconverter');

    $result = array();

    $curr = $this->ci->currconverter;

    if (!empty($items)) {

      foreach ($items as $h) {

        $this->set_id($h->hotel_id);

        $this->hotel_short_details();

        $bestprice = $this->bestPrice();

        $price = $bestprice;

        $tripAdvisorID = $this->tripadvisorid;

        $tripStatus = $this->tripAdvisorStatus();

        if ($tripStatus && !empty($tripAdvisorID)) {

          $avgReviews = $this->tripAdvisorData($tripAdvisorID);

          if (empty($avgReviews->overall)) {

            $avgReviews = $this->hotelReviewsAvg();

          }

        }

        else {

          $avgReviews = $this->hotelReviewsAvg();

        }

        if (!empty($this->title)) {

          $result[] = (object) array('id' => $h->hotel_id, 'title' => $this->title, 'thumbnail' => $this->thumbnail, 'starsCount' => $this->stars, 'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'avgReviews' => $avgReviews, 'createdAt' => $this->createdAt, 'module' => 'hotels');

        }

      }

    }

    return $result;

  }


  public function discount($id){
      $this->ci->db->select('discount');
      $this->ci->db->where('hotel_id',$id);
      $dis = $this->ci->db->get('pt_hotels')->row();
      if(!empty($dis->discount)){
          return $dis->discount;
      }else{
          return '';
      }

  }

    public function taxamount($id){

        $this->ci->db->where('hotel_id',$id);
        $tax = $this->ci->db->get('pt_hotels')->row();

        $check1 = $tax->hotel_comm_fixed;
        $check2 = $tax->hotel_comm_percentage;
        $check3 = $tax->hotel_tax_fixed;
        $check4 = $tax->hotel_tax_percentage;

        if ( $check1 > 0) {
            $deposit_type = "fixed";
            $deposit_amount = $tax->hotel_comm_fixed;
        }

        if ($check2 > 0 ) {
            $deposit_type = "percentage";
            $deposit_amount = $tax->hotel_comm_percentage;
        }

        if ($check4 > 0) {
            $tax_type = "percentage";
            $tax_amount = $tax->hotel_tax_percentage;
        }

        if ($check3 > 0) {
            $tax_type = "fixed";
            $tax_amount = $tax->hotel_tax_fixed;
        }

        $array = array('deposit_type'=> $deposit_type,'deposit_amount'=> $deposit_amount,'tax_type'=>$tax_type,'tax_amount'=>$tax_amount);

        return $array;


    }


    public function search_logs($paylod){

      $parms = array(
          'destination' =>$paylod['city'],
          'adults' =>$paylod['adults'],
          'chlids' =>$paylod['chlids'],
          'checkin' =>date('Y-m-d',strtotime($paylod['checkin'])),
          'checkout' =>date('Y-m-d',strtotime($paylod['checkout'])),
          'ip' =>$paylod['ip'],
          'browser_version' =>$paylod['browser_version'],
          'type' =>$paylod['type'],
          'os' =>$paylod['os'],
          'date_time' =>date('Y-m-d H:i:s'),
      );
      $this->db->insert('hotels_search_logs',$parms);
        $logid = $this->db->insert_id();
      return $logid;
    }

    public function get_booking($id){
      $this->db->where('booking_id',$id);
     return $this->db->get('hotels_bookings')->result();
    }

    public function getrooms_data($id){
        $this->db->where('booking_id',$id);
        return $this->db->get('hotels_rooms_bookings')->result();
    }
    public function invoceurlupdate($id,$invoice_url){
        $this->ci->load->model('Admin/Emails_model');
      $parm = array('invoice_url'=>$invoice_url);
        $this->db->where('booking_id',$id);
        $this->db->update('hotels_bookings',$parm);

        $this->db->select('hotels_bookings.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $this->db->where('hotels_bookings.booking_id',$id);
        $this->db->join('pt_accounts','hotels_bookings.booking_user_id = pt_accounts.accounts_id','left');
        $invoiceData = $this->db->get('hotels_bookings')->result();

        $type = $invoiceData[0]->booking_supplier;
        if($type == 1){
            $moduletype = 'hotels';
            $invoiceData['module'] = $moduletype;
            $this->ci->Emails_model->send_suppliermail($invoiceData);
        }

        $this->ci->Emails_model->send_customeremail($invoiceData);
        $this->ci->Emails_model->send_adminemail($invoiceData);


    }

    public function response_booking($id,$bookconf){
        $this->ci->load->model('Admin/Emails_model');
        $parm = array('booking_response'=>$bookconf);
        $this->db->where('booking_id',$id);
        $this->db->update('hotels_bookings',$parm);

        $this->db->where('booking_id',$id);
        $getinovice_link = $this->db->get('hotels_bookings')->result();

       return $getinovice_link;
    }
}

