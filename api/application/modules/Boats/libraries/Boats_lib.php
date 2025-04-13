<?php
class boats_lib {
/**
* Protected variables
*/
  protected $ci = NULL; //codeigniter instance
  protected $db; //database instatnce instance
  public $appSettings;
  public $boatid;
  public $title;
  public $slug;
  public $bookingSlug;
  public $stars;
  public $desc;
  public $policy;
  public $basicprice;
  public $discountprice;
  protected $lang;
  public $currencysign;
  public $currencycode;
  public $location;
  public $latitude;
  public $longitude;
  public $isfeatured;
  public $thumbnail;
  public $inclusions;
  public $exclusions;
  public $adultStatus;
  public $childStatus;
  public $infantStatus;
  public $boatNights;
  public $boatDays;
  public $boathours;
  public $boatType;
  public $adults;
  public $child;
  public $infants;
  public $selectedLocation;
  public $selectedboatType;
  public $date;
  public $adultPrice;
  public $childPrice;
  public $infantPrice;
  public $urlVars;
  public $error;
  public $errorCode;
  public $tax_type;
  public $tax_value;
  public $deposit = 0;
  public $taxamount;
  public $guestCount;
  public $createdAt;
  public $langdef;
  function __construct() {

//get the CI instance
    $this->ci = & get_instance();
    $this->db = $this->ci->db;
    $this->appSettings = $this->ci->Settings_model->get_settings_data();
    $lang = $this->ci->session->userdata('set_lang');
    $defaultlang = pt_get_default_language();
    $this->ci->load->model('Boats/Boats_model');
    $this->ci->load->helper('Boats/boats_front');
    if (empty($lang)) {
      $this->lang = $defaultlang;
    }
    else {
      $this->lang = $lang;
    }
    $this->error = false;
    $this->errorCode = "";
    $this->date = $this->ci->input->get('date');
    $typeid = $this->ci->input->get('type');
    $this->selectedboatType = $this->selectedboatType($typeid);
    $selectedAdults = $this->ci->input->get('adults');
    $selecteChildren = $this->ci->input->get('child');
    $selectedInfants = $this->ci->input->get('infant');
    $loc = $this->ci->input->get('location');
    if (!empty($selectedAdults)) {
      $this->adults = $selectedAdults;
    }
    else {
      $this->adults = PT_DEFAULT_ADULTS_COUNT;
    }
    if (!empty($selecteChildren)) {
      $this->child = $selecteChildren;
    }
    else {
      $this->child = 0;
    }
    if (!empty($selectedInfants)) {
      $this->infants = $selectedInfants;
    }
    else {
      $this->infants = 0;
    }
    if (!empty($loc)) {
      $this->selectedLocation = $loc;
    }
    else {
      $this->selectedLocation = "";
    }
    if (empty($this->date)) {
      $this->date = date($this->appSettings[0]->date_f, strtotime('+' . CHECKIN_SPAN . ' day', time()));
    }
    $this->guestCount = $this->adults + $this->child + $this->infants;
    $getVariables = $this->ci->input->get();
    if (!empty($getVariables)) {
      $this->urlVars = "?date=" . $this->date . "&adults=" . $this->adults;
    }
    else {
      $this->urlVars = "";
    }
    $this->langdef = DEFLANG;
  }

  public function getDefaultboatsListForSearchField()
  {
      $boats = $this->db->select('boat_id AS id, boat_title AS text, "boat" AS module, "false" AS disabled')->get('pt_boats')->result();
      $locations = $this->db->query("
        SELECT pt_locations.id AS id, CONCAT(country, ', ', location) AS text, 'location' AS `module`, 'false' AS disabled 
        FROM `pt_boat_locations` 
        JOIN pt_locations ON pt_locations.id = pt_boat_locations.location_id
        WHERE `boat_id` IN (
            SELECT boat_id FROM `pt_boats`
        )
        GROUP BY pt_locations.id
      ")->result();

      $resultin_array = [
          ["text" => "boats", "children" => $boats],
          ["text" => "Locations", "children" => $locations]
      ];

      return json_encode($resultin_array);
  }

  function set_boatid($boatslug) {
    $this->db->select('boat_id');
    $this->db->where('boat_slug', $boatslug);
    $r = $this->db->get('pt_boats')->result();
    $this->boatid = $r[0]->boat_id;
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
//set boat id by id
  function set_id($id, $currsign = null, $currcode = null) {
    $this->boatid = $id;
    $this->currencysign = $currsign;
    $this->currencycode = $currcode;
  }
  function get_id() {
    return $this->boatid;
  }
  function settings() {
    return $this->ci->Settings_model->get_front_settings('boats');
  }
  function wishListInfo($id) {
    $this->boat_short_details($id);
    $title = $this->title;
    $slug = base_url() . 'boats/' . $this->slug;
    $thumbnail = $this->thumbnail;
    $location = $this->location;
    $stars = pt_create_stars($this->stars);
    $res = array("title" => $title, "slug" => $slug, "thumbnail" => $thumbnail, "location" => $location->city, "stars" => $stars,);
    return $res;
  }
  function selectedboatType($id) {
    $option = "";
    if (!empty($id)) {
      $res = $this->boatTypeSettings($id);
      if (!empty($res->name)) {
        $option = "<option value=" . $res->id . " selected >" . $res->name . "</option>";
      }
    }
    return $option;
  }
  function show_boats($offset = null) {
    $totalSegments = $this->ci->uri->total_segments();
    $data = array();
    $settings = $this->settings();
    $perpage = $settings[0]->front_listings;
    $sortby = $this->ci->input->get('sortby');
    if (!empty($sortby)) {
      $orderby = $sortby;
    }
    else {
      $orderby = $settings[0]->front_listings_order;
    }
    $priceRange = $this->priceRange($this->ci->input->get('price'));
    $rh = $this->ci->Boats_model->list_boats_front($priceRange);
    $boats = $this->ci->Boats_model->list_boats_front($priceRange, $perpage, $offset, $orderby);
    $data['all_boats'] = $this->getResultObject($boats['all']);
    $data['paginationinfo'] = array('base' => 'boats/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
    return $data;
  }
  function showboatsByLocation($locs, $offset = null) {
    $data = array();
    $settings = $this->settings();
    $perpage = $settings[0]->front_listings;
    $sortby = $this->ci->input->get('sortby');
    if (!empty($sortby)) {
      $orderby = $sortby;
    }
    else {
      $orderby = $settings[0]->front_listings_order;
    }
    $priceRange = $this->priceRange($this->ci->input->get('price'));
    $rh = $this->ci->Boats_model->showboatsByLocation($locs->locations, $priceRange);
    $boats = $this->ci->Boats_model->showboatsByLocation($locs->locations, $priceRange, $perpage, $offset, $orderby);
    $data['all_boats'] = $this->getResultObject($boats['all']);
    $data['paginationinfo'] = array('base' => 'boats/' . $locs->urlBase, 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => $locs->uriSegment);
    return $data;
  }
  function search_boats($location, $offset = null) {
    $data = array();
    $settings = $this->settings();
    $perpage = $settings[0]->front_search;
    $orderby = $settings[0]->front_search_order;
    $totalSegments = $this->ci->uri->total_segments();
    if ($totalSegments < 5) {
      $location = "";
      $segments = "";
      $urisegment = 3;
    }
    else {
      $segments = '/' . $this->ci->uri->segment(3) . '/' . $this->ci->uri->segment(4) . '/' . $this->ci->uri->segment(5);
      $urisegment = 6;
    }
    $priceRange = $this->priceRange($this->ci->input->get('price'));
    $rh = $this->ci->Boats_model->search_boats_front($location, $priceRange);
    $boats = $this->ci->Boats_model->search_boats_front($location, $priceRange, $perpage, $offset, $orderby);

      $boat = array();
      foreach ($boats['all'] as $check){
          $data = $this->ci->Rentals_model->checkbooking($check->rental_id);
          if(empty($data)){

              array_push($boat, (object)[
                  'boat_id'=>$check->boat_id,
                  'boat_type'=>$check->boat_type,
                  'boat_location'=>$check->boat_location,
                  'boat_adult_price'=>$check->boat_adult_price,
                  'boat_title'=>$check->boat_title,
                  'boat_status'=>$check->boat_status,
                  'id'=>$check->id,
                  'position'=>$check->boat_type,
                  'location_id'=>$check->boat_type
              ]);
          }
      }

    $data['all_boats'] = $this->getResultObject($boat);
    $data['paginationinfo'] = array('base' => 'boats/search' . $segments, 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => $urisegment);
    return $data;
  }

  function search_boats_api($location, $offset = null) {
    $data = array();
    $settings = $this->settings();
    $perpage = $settings[0]->front_search;
    $orderby = $settings[0]->front_search_order;
    $totalSegments = $this->ci->uri->total_segments();
    $segments = "";
    $priceRange = $this->priceRange($this->ci->input->get('price'));
    $rh = $this->ci->Boats_model->search_boats_front($location, $priceRange);
    $boats = $this->ci->Boats_model->search_boats_front($location, $priceRange, $perpage, $offset, $orderby);
    $data['all_boats'] = $this->getResultObject($boats['all']);
    $data['paginationinfo'] = array('base' => 'boats/search' . $segments, 'totalrows' => $rh['rows'], 'perpage' => $perpage);
    return $data;
  }

  function boat_details($boatid = null, $date = null) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    else {
      $boatid = $boatid;
    }
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    if (!empty($date)) {
      $this->date = $date;
    }
    $this->db->where('boat_id', $boatid);
    $details = $this->db->get('pt_boats')->result();
    $title = $this->get_title($details[0]->boat_title, $details[0]->boat_id);
    $stars = $details[0]->boat_stars;
    $desc = $this->get_description($details[0]->boat_desc, $details[0]->boat_id);
    $policy = $this->get_policy($details[0]->boat_privacy, $details[0]->boat_id);
    $locationInfoUrl = pt_LocationsInfo($details[0]->boat_location);
    $countryName = url_title($locationInfoUrl->country, 'dash', true);
    $cityName = url_title($locationInfoUrl->city, 'dash', true);
    $slug = $countryName . '/' . $cityName . '/' . $details[0]->boat_slug . $this->urlVars;
    $bookingSlug = $details[0]->boat_slug . $this->urlVars;
    $keywords = $this->get_keywords($details[0]->boat_meta_keywords, $details[0]->boat_id);
    $metadesc = $this->get_metaDesc($details[0]->boat_meta_desc, $details[0]->boat_id);
    $boatDays = $details[0]->boat_days;
    $boathours = $details[0]->boat_hours;
    $boatNights = $details[0]->boat_nights;
    if (!empty($details[0]->boat_amenities)) {
      $boatAmenities = explode(",", $details[0]->boat_amenities);
      foreach ($boatAmenities as $tm) {
        $amts[] = $this->boatTypeSettings($tm);
      }
    }
    else {
      $amts = array();
    }
    $inclusions = $amts;
    if (!empty($details[0]->boat_exclusions)) {
      $boatExclusions = explode(",", $details[0]->boat_exclusions);
      foreach ($boatExclusions as $exc) {
        $excs[] = $this->boatTypeSettings($exc);
      }
    }
    else {
      $excs = array();
    }
    $exclusions = $excs;
    if (!empty($details[0]->boat_payment_opt)) {
      $boatPaymentOpts = explode(",", $details[0]->boat_payment_opt);
      foreach ($boatPaymentOpts as $p) {
        $payopts[] = $this->boatTypeSettings($p);
      }
    }
    else {
      $payopts = array();
    }
    $paymentOptions = $payopts;
    if (!empty($details[0]->boat_related)) {
      $rboats = explode(",", $details[0]->boat_related);
    }
    else {
      $rboats = "";
    }
    $relatedboats = $this->getRelatedboats($rboats);
    $thumbnail = PT_BOATS_SLIDER_THUMB . $details[0]->thumbnail_image;
    $city = pt_LocationsInfo($details[0]->boat_location, $this->lang);
    $location = $city->city; // $details[0]->boat_location;
//	$isfeatured = $this->is_featured();
    $website = $details[0]->boat_website;
    $phone = $details[0]->boat_phone;
    $email = $details[0]->boat_email;
    $taxcom = $this->boat_tax_commision();
    $comm_type = $taxcom['commtype'];
    $comm_value = $taxcom['commval'];
    $tax_type = $taxcom['taxtype'];
    $tax_value = $taxcom['taxval'];
    $latitude = $details[0]->boat_latitude;
    $longitude = $details[0]->boat_longitude;
    $totalAdutlsPrice = $details[0]->boat_adult_price * $this->adults;
    $totalChildPrice = $details[0]->boat_child_price * $this->child;
    $totalInfantsPrice = $details[0]->boat_infant_price * $this->infants;
    $adultPrice = $curr->convertPrice($totalAdutlsPrice);
    $childPrice = $curr->convertPrice($totalChildPrice);
    $infantPrice = $curr->convertPrice($totalInfantsPrice);
    $perAdultPrice = $curr->convertPrice($details[0]->boat_adult_price);
    $perChildPrice = $curr->convertPrice($details[0]->boat_child_price);
    $perInfantPrice = $curr->convertPrice($details[0]->boat_infant_price);
    $maxAdults = $details[0]->boat_max_adults;
    $maxChild = $details[0]->boat_max_child;
    $maxInfant = $details[0]->boat_max_infant;
    $this->checkErrors($maxAdults, $maxChild, $maxInfant);
    $adultStatus = $details[0]->adult_status;
    $childStatus = $details[0]->child_status;
    $infantStatus = $details[0]->infant_status;
    $sliderImages = $this->boatImages($details[0]->boat_id);
    $totalCost = $totalAdutlsPrice + $totalChildPrice + $totalInfantsPrice;
    $taxcom = $this->boat_tax_commision($details[0]->boat_id);
    $this->comm_type = $taxcom['commtype'];
    $this->comm_value = $taxcom['commval'];
    $this->tax_type = $taxcom['taxtype'];
    $this->tax_value = $taxcom['taxval'];
    $this->setDeposit($curr->convertPriceFloat($totalCost, 2));
    $depositAmount = $this->deposit;
    $discount = $this->discount($boatid);
    $detailResults = (object) array('id' => $details[0]->boat_id, 'title' => $title, 'slug' => $slug, 'bookingSlug' => $bookingSlug, 'thumbnail' => $thumbnail, 'stars' => pt_create_stars($stars), 'starsCount' => $stars, 'location' => $location, 'desc' => $desc, 'inclusions' => $inclusions, 'exclusions' => $exclusions, 'latitude' => $latitude, 'longitude' => $longitude, 'sliderImages' => $sliderImages, 'relatedItems' => $relatedboats, 'paymentOptions' => $paymentOptions, 'metadesc' => $metadesc, 'keywords' => $keywords, 'policy' => $policy, 'website' => $website, 'email' => $email, 'phone' => $phone, 'maxAdults' => $maxAdults, 'maxChild' => $maxChild, 'maxInfant' => $maxInfant, 'adultStatus' => $adultStatus, 'childStatus' => $childStatus, 'infantStatus' => $infantStatus, 'adultPrice' => $adultPrice, 'childPrice' => $childPrice, 'infantPrice' => $infantPrice, 'perAdultPrice' => $perAdultPrice, 'perChildPrice' => $perChildPrice, 'perInfantPrice' => $perInfantPrice, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'date' => $this->date, 'totalCost' => $curr->convertPrice($totalCost), 'comType' => $comm_type, 'comValue' => $comm_value, 'taxType' => $tax_type, 'taxValue' => $tax_value, 'boatDays' => $boatDays, 'boathours' => $boathours, 'boatNights' => $boatNights, 'totalDeposit' => $depositAmount, 'mapAddress' => $details[0]->boat_mapaddress, 'discount' =>$discount);
    return $detailResults;
  }
  function boat_short_details($boatid = 0) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $this->db->select('boat_title,boat_stars,boat_slug,boat_desc,boat_privacy,boat_max_adults,boat_max_child,
   boat_max_infant,boat_basic_price,boat_basic_discount,boat_adult_price,boat_child_price,boat_infant_price,boat_amenities,boat_exclusions,boat_days,boat_nights,thumbnail_image,boat_location,boat_latitude,boat_longitude,boat_type,boat_created_at');
    $this->db->where('boat_id', $boatid);
    $details = $this->db->get('pt_boats')->result();
    $this->stars = $details[0]->boat_stars;
    $this->title = $this->get_title($details[0]->boat_title, NULL);
    $this->desc = $this->get_description($details[0]->boat_desc, NULL);
    $this->policy = $this->get_policy($details[0]->boat_privacy, NULL);
    $this->boatDays = $details[0]->boat_days;
    $this->boathours = $details[0]->boat_hours;
    $this->boatNights = $details[0]->boat_nights;
    $this->boatNights = $details[0]->boat_nights;
    $this->createdAt = $details[0]->boat_created_at;
    $maxAdults = $details[0]->boat_max_adults;
    $maxChild = $details[0]->boat_max_child;
    $maxInfant = $details[0]->boat_max_infant;
    $this->checkErrors($maxAdults, $maxChild, $maxInfant);
//get country and city name for url slug
    $locationInfoUrl = pt_LocationsInfo($details[0]->boat_location);
    $countryName = url_title($locationInfoUrl->country, 'dash', true);
    $cityName = url_title($locationInfoUrl->city, 'dash', true);
    $this->slug = $countryName . '/' . $cityName . '/' . $details[0]->boat_slug . $this->urlVars;
    $this->bookingSlug = $details[0]->boat_slug . $this->urlVars;
    $city = pt_LocationsInfo($details[0]->boat_location, $this->lang);
    $this->location = $city->city;
//$details[0]->boat_location;
    $this->latitude = $details[0]->boat_latitude;
    $this->longitude = $details[0]->boat_longitude;
    $this->thumbnail = PT_BOATS_SLIDER_THUMB . $details[0]->thumbnail_image;
    $type = $this->boatTypeSettings($details[0]->boat_type);
    $this->boatType = $type->name;
    $taxcom = $this->boat_tax_commision();
    $this->comm_type = $taxcom['commtype'];
    $this->comm_value = $taxcom['commval'];
    $this->tax_type = $taxcom['taxtype'];
    $this->tax_value = $taxcom['taxval'];
    $this->adultPrice = $details[0]->boat_adult_price;
    $this->childPrice = $details[0]->boat_child_price;
    $this->infantPrice = $details[0]->boat_infant_price;
    $this->isfeatured = $this->is_featured(NULL);
    return $details;
  }
  function boat_tax_commision($boatid = null) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $res = array();
    $this->db->select('boat_comm_fixed,boat_comm_percentage,boat_tax_fixed,boat_tax_percentage');
    $this->db->where('boat_id', $boatid);
    $result = $this->db->get('pt_boats')->result();
    $commfixed = $result[0]->boat_comm_fixed;
    $commper = $result[0]->boat_comm_percentage;
    $taxfixed = $result[0]->boat_tax_fixed;
    $taxper = $result[0]->boat_tax_percentage;
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
// get boat images
  function boatImages($boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $this->db->where('timg_boat_id', $boatid);
    $this->db->where('timg_approved', '1');
    $this->db->order_by('timg_order', 'asc');
    $res = $this->db->get('pt_boat_images')->result();
    if (empty($res)) {
      $result[] = array("fullImage" => PT_BOATS_SLIDER_THUMB . PT_BLANK_IMG, "thumbImage" => PT_BOATS_SLIDER_THUMB . PT_BLANK_IMG);
    }
    else {
      foreach ($res as $r) {
        $result[] = array("fullImage" => PT_BOATS_SLIDER . $r->timg_image, "thumbImage" => PT_BOATS_SLIDER_THUMB . $r->timg_image);
      }
    }
    return $result;
  }
  function getFeaturedboats() {
    $boats = $this->featured_boats_list();
    $result = $this->getResultObject($boats);
    return $result;
  }
  function getCountryFeaturedboats() {
    $boats = $this->featured_boats_list_by_country();
    $result = $this->getCoutryResultObject($boats);
    return $result;
  }
  function getLocationBasedFeaturedboats($loc) {
    $settings = $this->settings();
    $limit = $settings[0]->front_homepage;
    $this->db->select('boat_id');
    $this->db->where('boat_location', $loc);
    $this->db->where('boat_status', 'Yes');
    $boatsList = $this->db->get('pt_boats')->result();
    $boats = array();
    foreach ($boatsList as $t) {
      $isFeatured = $this->is_featured($t->boat_id);
      if ($isFeatured) {
        $boats[] = (object) array('boat_id' => $t->boat_id);
      }
    }
    $boats = array_slice($boats, 0, $limit);
    $result = $this->getResultObject($boats);
    return $result;
  }
  function getTopRatedboats() {
    $boats = $this->ci->Boats_model->popular_boats_front();
    $result = $this->getResultObject($boats);
    return $result;
  }
  function getRelatedboats($boats) {
    $resultboats = array();
    $result = array();
    $settings = $this->settings();
    $limit = $settings[0]->front_related;
    $count = 0;
    if (!empty($boats)) {
      foreach ($boats as $t) {
        $count++;
        if($count <= $limit){
          $resultboats[] = (object) array('boat_id' => $t);
        }

      }
    }
    $result = $this->getLimitedResultObject($resultboats);
    return $result;
  }
// Get boat updated Price on changing adults, child and infant count.
  function updatedPrice($boatid, $adults = 1, $child = 0, $infant = 0) {
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    $this->db->select('boat_adult_price,boat_child_price,boat_infant_price');
    $this->db->where('boat_id', $boatid);
    $details = $this->db->get('pt_boats')->result();
    $totalAdutlsPrice = $details[0]->boat_adult_price * $adults;
    $totalChildPrice = $details[0]->boat_child_price * $child;
    $totalInfantsPrice = $details[0]->boat_infant_price * $infant;
    $adultPrice = $curr->convertPrice($totalAdutlsPrice);
    $childPrice = $curr->convertPrice($totalChildPrice);
    $infantPrice = $curr->convertPrice($totalInfantsPrice);
    $totalCost = $totalAdutlsPrice + $totalChildPrice + $totalInfantsPrice;
    $taxcom = $this->boat_tax_commision($boatid);
    $this->comm_type = $taxcom['commtype'];
    $this->comm_value = $taxcom['commval'];
    $this->tax_type = $taxcom['taxtype'];
    $this->tax_value = $taxcom['taxval'];
    $this->setDeposit($totalCost);
    $depositAmount = $this->deposit;
    if (!empty($curr->symbol)) {
      $currSymbol = $curr->symbol;
    }
    else {
      $currSymbol = "";
    }
    $detailResults = array('id' => $boatid, 'adultPrice' => $adultPrice, 'childPrice' => $childPrice, 'infantPrice' => $infantPrice, 'currCode' => $curr->code, 'currSymbol' => $currSymbol, 'totalDeposit' => $curr->convertPrice($depositAmount), 'totalCost' => $curr->convertPrice($totalCost));
    return json_encode($detailResults);
  }
  function get_thumbnail() {
    $res = $this->ci->Boats_model->default_boat_img($this->boatid);
    if (!empty($res)) {
      return PT_BOATS_SLIDER_THUMB . $res;
    }
    else {
      return PT_BLANK;
    }
  }
  function get_title($deftitle, $boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    if ($this->lang == $this->langdef) {
      $title = $deftitle;
    }
    else {
      $this->db->where('item_id', $boatid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_boats_translation')->result();
      $title = $res[0]->trans_title;
      if (empty($title)) {
        $title = $deftitle;
      }
    }
    return $title;
  }
  function get_description($defdesc, $boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    if ($this->lang == $this->langdef) {
      $desc = $defdesc;
    }
    else {
      $this->db->where('item_id', $boatid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_boats_translation')->result();
      $desc = $res[0]->trans_desc;
      if (empty($desc)) {
        $desc = $defdesc;
      }
    }
    return $desc;
  }
  function get_policy($defpolicy, $boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    if ($this->lang == $this->langdef) {
      $policy = $defpolicy;
    }
    else {
      $this->db->where('item_id', $boatid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_boats_translation')->result();
      $policy = $res[0]->trans_policy;
      if (empty($policy)) {
        $policy = $defpolicy;
      }
    }
    return $policy;
  }
  function get_keywords($defkeywords, $boatid = null) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    if ($this->lang == $this->langdef) {
      $keywords = $defkeywords;
    }
    else {
      $this->db->where('item_id', $boatid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_boats_translation')->result();
      $keywords = $res[0]->metakeywords;
      if (empty($keywords)) {
        $keywords = $defkeywords;
      }
    }
    return $keywords;
  }
  function get_metaDesc($defmeta, $boatid = null) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    if ($this->lang == $this->langdef) {
      $meta = $defmeta;
    }
    else {
      $this->db->where('item_id', $boatid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_boats_translation')->result();
      $meta = $res[0]->metadesc;
      if (empty($meta)) {
        $meta = $defmeta;
      }
    }
    return $meta;
  }
  function boatExtras($boatid = null) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $today = time();
    $result = array();
//	$this->db->where('extras_from  <=', $today);
//	$this->db->where('extras_to >=', $today);
    $this->db->where('extras_module', 'boats');
//  $this->db->or_where('extras_forever','forever');
    $this->db->order_by('extras_id', 'desc');
    $this->db->like('extras_for', $boatid, 'both');
    $this->db->having('extras_status', 'Yes');
    $ext = $this->db->get('pt_extras')->result();
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    if (!empty($ext)) {
      foreach ($ext as $e) {
        $trans = $this->extrasTranslation($e->extras_id, $e->extras_title, $e->extras_desc);
        $price = $curr->convertPrice($e->extras_basic_price);
        $result[] = (object) array("id" => $e->extras_id, "extraTitle" => $trans['title'], "extraDesc" => $trans['desc'], 'extraPrice' => $price, 'thumbnail' => PT_BOATS_EXTRAS_IMAGES . $e->extras_image);
      }
    }
    return $result;
  }
  function getLocationsList() {
    $resultLocations = array();
    $this->db->select('location_id');
    $this->db->group_by('location_id');
    $locations = $this->db->get('pt_boat_locations')->result();
    foreach ($locations as $loc) {
      $locInfo = pt_LocationsInfo($loc->location_id, $this->lang);
      if (!empty($locInfo->city)) {
        $resultLocations[] = (object) array('id' => $locInfo->id, 'name' => $locInfo->city);
      }
    }
    return $resultLocations;
  }
  function extras_translation($id) {
    $language = $this->lang;
    $result = array();
    $this->db->select('extras_title,extras_desc');
    $this->db->where('extras_id', $id);
    $re = $this->db->get('pt_extras')->result();
    if ($language == $this->langdef) {
      $result['title'] = $re[0]->extras_title;
      $result['desc'] = $re[0]->extras_desc;
    }
    else {
      $this->db->select('trans_title,trans_desc');
      $this->db->where('trans_extras_id', $id);
      $this->db->where('trans_lang', $language);
      $r = $this->db->get('pt_extras_translation')->result();
      if (empty($r[0]->trans_title)) {
        $result['title'] = $re[0]->extras_title;
      }
      else {
        $result['title'] = $r[0]->trans_title;
      }
      if (empty($r[0]->trans_desc)) {
        $result['desc'] = $re[0]->extras_desc;
      }
      else {
        $result['desc'] = $r[0]->trans_desc;
      }
    }
    return $result;
  }
// boat Reviews
  function boat_reviews($boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'boats');
    $this->db->where('review_itemid', $boatid);
    $this->db->order_by('review_id', 'desc');
    return $this->db->get('pt_reviews')->result();
  }
// boat Reviews for API
  function boat_reviews_for_api($boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $result = array();
    $this->db->select('review_overall as rating,review_name as review_by,review_comment,review_date');
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'boats');
    $this->db->where('review_itemid', $boatid);
    $this->db->order_by('review_id', 'desc');
    $rs = $this->db->get('pt_reviews')->result();
    foreach ($rs as $r) {
      $result[] = array("rating" => $r->rating, "review_by" => $r->review_by, "review_comment" => $r->review_comment, "review_date" => pt_show_date_php($r->review_date));
    }
    return $result;
  }
// boat  Reviews Averages
  function boatReviewsAvg($boatid = 0) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $this->db->select("COUNT(*) AS totalreviews");
    $this->db->select_avg('review_overall', 'overall');
    $this->db->select_avg('review_clean', 'clean');
    $this->db->select_avg('review_facilities', 'facilities');
    $this->db->select_avg('review_staff', 'staff');
    $this->db->select_avg('review_comfort', 'comfort');
    $this->db->select_avg('review_location', 'location');
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'boats');
    $this->db->where('review_itemid', $boatid);
    $res = $this->db->get('pt_reviews')->result();
    $clean = round($res[0]->clean, 1);
    $comfort = round($res[0]->comfort, 1);
    $location = round($res[0]->location, 1);
    $facilities = round($res[0]->facilities, 1);
    $staff = round($res[0]->staff, 1);
    $totalreviews = $res[0]->totalreviews;
    $overall = round($res[0]->overall, 1);
    $result = (object) array('clean' => $clean, 'comfort' => $comfort, 'location' => $location, 'facilities' => $facilities, 'staff' => $staff, 'totalReviews' => $totalreviews, 'overall' => $overall);
    return $result;
  }
// boat visiting Cities
  function boat_visiting_cities() {
    $this->db->select('map_city_name');
    $this->db->where('map_city_type', 'visit');
    $this->db->where('map_boat_id', $this->boatid);
    return $this->db->get('pt_boats_maps')->result();
  }
  function translated_data($lang) {
    $this->db->where('item_id', $this->boatid);
    $this->db->where('trans_lang', $lang);
    return $this->db->get('pt_boats_translation')->result();
  }
  function is_featured($boatid) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    else {
      $boatid = $boatid;
    }
    $this->db->select('boat_id');
    $this->db->where('boat_is_featured', 'yes');
    $this->db->where('boat_featured_from <', time());
    $this->db->where('boat_featured_to >', time());
    $this->db->or_where('boat_featured_forever', 'forever');
    $this->db->having('boat_id', $boatid);
    return $this->db->get('pt_boats')->num_rows();
  }
  function featured_boats_list() {
    $settings = $this->settings();
    $limit = $settings[0]->front_homepage;
    $orderby = $settings[0]->front_homepage_order;
    $this->db->select('boat_id,boat_order,boat_title,boat_status,boat_location');
    $this->db->where('boat_is_featured', 'yes');
    $this->db->where('boat_featured_from <', time());
    $this->db->where('boat_featured_to >', time());
    $this->db->or_where('boat_featured_forever', 'forever');
    $this->db->having('boat_status', 'Yes');
    $this->db->limit($limit);
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
    return $this->db->get('pt_boats')->result();
  }

  //test function by Hafiz Abuzar
  function featured_boats_list_by_country() {
    $settings = $this->settings();
    $limit = $settings[0]->front_homepage;
    $orderby = $settings[0]->front_homepage_order;
    $this->db->select('boat_id,boat_order,boat_title,boat_status,boat_location, count(boat_location) as total_boat, loc.country');
    $this->db->join('pt_locations as loc', 'loc.id = pt_boats.boat_location', 'inner');
    $this->db->where('boat_is_featured', 'yes');
    $this->db->where('boat_featured_from <', time());
    $this->db->where('boat_featured_to >', time());
    $this->db->or_where('boat_featured_forever', 'forever');
    $this->db->group_by('loc.country');
    $this->db->having('boat_status', 'Yes');
    $this->db->limit($limit);
    $this->db->order_by('total_boat', 'desc');
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
    //$this->db->get('pt_boats');
    //echo $this->db->last_query(); die;

    return $this->db->get('pt_boats')->result();
  }
  // end test function by Hafiz Abuzar





// boat Reviews
  function boatReviews($boatid = null) {
    if (empty($boatid)) {
      $boatid = $this->boatid;
    }
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'boats');
    $this->db->where('review_itemid', $boatid);
    $this->db->order_by('review_id', 'desc');
    return $this->db->get('pt_reviews')->result();
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
  function boatTypes() {
    $boattypes = array();
    $this->db->select('sett_name,sett_id');
    $this->db->where('sett_type', 'ttypes');
    $types = $this->db->get('pt_boats_types_settings')->result();
    foreach ($types as $t) {
      $tname = $this->boatTypeSettings($t->sett_id);
      $boattypes[] = (object) array('id' => $t->sett_id, 'name' => $tname->name);
    }
    return $boattypes;
  }
// boat Type
  function boatTypeSettings($id) {
    $language = $this->lang;
    $result = new stdClass;
    $this->db->select('sett_name,sett_img');
    $this->db->where('sett_id', $id);
    $this->db->where('sett_status', 'Yes');
    $re = $this->db->get('pt_boats_types_settings')->result();
    $result->icon = PT_BOSTS_ICONS . $re[0]->sett_img;
    $result->id = $id;
    if ($language == $this->langdef) {
      $result->name = $re[0]->sett_name;
    }
    else {
      $this->db->select('trans_name');
      $this->db->where('sett_id', $id);
      $this->db->where('trans_lang', $language);
      $r = $this->db->get('pt_boats_types_settings_translation')->result();
      if (empty($r[0]->trans_name)) {
        $result->name = $re[0]->sett_name;
      }
      else {
        $result->name = $r[0]->trans_name;
      }
    }
    return $result;
  }
//Populate boat Types according to the location selected
  function getboatTypesLocationBased($location) {
    $result = new stdClass;
    $result->hasResult = FALSE;
    $result->optionsList = "";
    $boatTypes = array();
    $boatIDs = array();
    $this->db->where('location_id', $location);
    $this->db->group_by('boat_id');
    $boats = $this->db->get('pt_boat_locations')->result();
    if (!empty($boats)) {
      foreach ($boats as $t) {
        $boatIDs[] = $t->boat_id;
      }
    }
    $this->db->select('boat_type');
//$this->db->where('boat_location',$location);
    if (!empty($boatIDs)) {
      $this->db->where_in('boat_id', $boatIDs);
    }
    else {
      $this->db->where('boat_id', '0');
    }
    $this->db->group_by('boat_type');
    $res = $this->db->get('pt_boats')->result();
    if (!empty($res)) {
      foreach ($res as $r) {
        $boatTypes[] = $r->boat_type;
      }
      $result->hasResult = TRUE;
      foreach ($boatTypes as $type) {
        $typeDetails = $this->boatTypeSettings($type);
        $result->optionsList .= "<option value='" . $typeDetails->id . "' selected>" . $typeDetails->name . "</option>";
        $result->types[] = array("id" => $typeDetails->id, "name" => $typeDetails->name);
      }
    }
    else {
      $result->hasResult = FALSE;
      $result->optionsList = "<option value='' selected> Select </option>";
    }
    return $result;
  }
  function boatLocations($id = null) {
    $result = new stdClass;
    if (empty($id)) {
      $id = $this->boatid;
    }
    $this->db->where('boat_id', $id);
    $locs = $this->db->get('pt_boat_locations')->result();
    foreach ($locs as $l) {
      $locInfo = pt_LocationsInfo($l->location_id, $this->lang);
      if (!empty($locInfo->city)) {
        $result->locations[] = (object) array('id' => $locInfo->id, 'name' => $locInfo->city, 'lat' => $locInfo->latitude, 'long' => $locInfo->longitude);
      }
    }
    return $result;
  }
//make a result object all data of boats array
  function getResultObject($boats) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    foreach ($boats as $t) {
      $this->set_id($t->boat_id);
      $this->boat_short_details($t->boat_id);
      $adultprice = $this->adultPrice * $this->adults;
      $childprice = $this->childPrice;
      $infantprice = $this->infantPrice;
      $price = $curr->convertPrice($adultprice);
      $discount = $this->discount($t->boat_id);
      $avgReviews = $this->boatReviewsAvg(NULL);
      $result[] = (object) array('id' => $this->boatid, 'title' => $this->title, 'slug' => base_url() . 'boats/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'desc' => strip_tags($this->desc), 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'inclusions' => $this->inclusions, 'avgReviews' => $avgReviews, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'boatDays' => $this->boatDays, 'boatNights' => $this->boatNights, 'boatType' => $this->boatType, 'discount' => $discount);
    }
    $this->currencycode = $curr->code;
    $this->currencysign = $curr->symbol;
    return $result;
  }

  //Discount get boat
    function discount($id){
        $this->ci->db->select('discount');
        $this->ci->db->where('boat_id',$id);
        $dis = $this->ci->db->get('pt_boats')->row();
        return $dis->discount;
    }
  // Featured countires boats
  function getCoutryResultObject($boats) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    foreach ($boats as $t) {
      $this->set_id($t->boat_id);
      $this->boat_short_details($t->boat_id);
      $adultprice = $this->adultPrice * $this->adults;
      $childprice = $this->childPrice;
      $infantprice = $this->infantPrice;
      $price = $curr->convertPrice($adultprice);
      $avgReviews = $this->boatReviewsAvg(NULL);
      $this->slug = urlencode(strtolower($t->country));
      $result[] = (object) array(
          'id' => $this->boatid,
          'total_boats' => $t->total_boat,
          'country' => $t->country,
          'title' => $this->title,
          'slug' => base_url() . 'boats/' . $this->slug,
          'thumbnail' => $this->thumbnail,
          'stars' => pt_create_stars($this->stars),
          'starsCount' => $this->stars,
          'location' => $this->location,
          'desc' => strip_tags($this->desc),
          'price' => $price,
          'currCode' => $curr->code,
          'currSymbol' => $curr->symbol,
          'inclusions' => $this->inclusions,
          'avgReviews' => $avgReviews,
          'latitude' => $this->latitude,
          'longitude' => $this->longitude,
          'boatDays' => $this->boatDays,
          'boathours' => $this->boathours,
          'boatNights' => $this->boatNights,
          'boatType' => $this->boatType
      );
    }

    $this->currencycode = $curr->code;
    $this->currencysign = $curr->symbol;

    return $result;
  }
  // end


//make a result object limited data of boats array
  function getLimitedResultObject($boats) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    if (!empty($boats)) {
      foreach ($boats as $t) {
        $this->set_id($t->boat_id);
        $this->boat_short_details();
        $adultprice = $this->adultPrice * $this->adults;
        $childprice = $this->childPrice;
        $infantprice = $this->infantPrice;
        $avgReviews = $this->boatReviewsAvg();
        $price = $curr->convertPrice($adultprice);
        if (!empty($this->title)) {
          $result[] = (object) array('id' => $this->boatid, 'title' => $this->title, 'slug' => base_url() . 'boats/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars),'starsCount' => $this->stars, 'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'avgReviews' => $avgReviews,);
        }
      }
    }
    return $result;
  }
//make a result object of single boat
  function getSingleResultObject($id) {
    $this->ci->load->library('currconverter');
    $result = "";
    $curr = $this->ci->currconverter;
    if (!empty($id)) {
      $this->set_id($id);
      $this->boat_short_details();
      $adultprice = $this->adultPrice * $this->adults;
      $childprice = $this->childPrice;
      $infantprice = $this->infantPrice;
      $avgReviews = $this->boatReviewsAvg();
      $price = $curr->convertPrice($adultprice);
      if (!empty($this->title)) {
        $result = (object) array('id' => $this->boatid, 'title' => $this->title, 'slug' => base_url() . 'boats/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'avgReviews' => $avgReviews,);
      }
    }
    return $result;
  }
//make a result object of booking info
  function getBookResultObject($boatid, $date = null, $adults = null, $child = null, $infants = null) {
    if (empty($date)) {
      $date = $this->date;
    }
    $extrasCheckUrl = base_url() . 'boats/boatajaxcalls/boatExtrasBooking';
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
//boat details for booking page
    $this->set_id($boatid);
    $this->boat_short_details();
    $extras = $this->boatExtras();
    if (empty($adults)) {
      $adults = $this->adults;
    }
    if (empty($child)) {
      $child = $this->child;
    }
    if (empty($infants)) {
      $infants = $this->infants;
    }
    $adultPrice = $this->adultPrice * $adults;
    $childPrice = $this->childPrice * $child;
    $infantPrice = $this->infantPrice * $infants;
    $totalSum = $adultPrice + $childPrice + $infantPrice;
    $subTotal = $curr->convertPriceFloat($adultPrice) + $curr->convertPriceFloat($childPrice) + $curr->convertPriceFloat($infantPrice);
// $subTotal = $childPrice;
    $this->setTax($subTotal);
    $taxAmount = $curr->addComma($this->taxamount);
    $totalPrice = $subTotal + $this->taxamount;
    $price = $curr->addComma($totalPrice);
    $this->setDeposit($totalPrice);
    $depositAmount = $curr->addComma($this->deposit);
    $result["boat"] = (object) array('id' => $this->boatid, 'title' => $this->title, 'slug' => base_url() . 'boats/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'date' => $date, 'metadesc' => $this->metadesc, 'keywords' => $this->keywords, 'extras' => $extras, 'taxAmount' => $taxAmount, 'depositAmount' => $depositAmount, 'policy' => $this->policy, 'extraChkUrl' => $extrasCheckUrl, 'adults' => $adults, 'children' => $child, 'infants' => $infants, 'boatDays' => $this->boatDays, 'boathours' => $this->boathours, 'boatNights' => $this->boatNights, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'price' => $price, 'adultprice' => $curr->convertPrice($adultPrice), 'childprice' => $curr->convertPrice($childPrice), 'infantprice' => $curr->convertPrice($infantPrice), 'subTotal' => $subTotal);
//end boat details for booking page
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
  function extrasFee($exts) {
    $extFee = 0;
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    foreach ($exts as $ext) {
      $this->db->select('extras_title,extras_desc,extras_discount,extras_basic_price');
      $this->db->where('extras_id', $ext);
      $rs = $this->db->get('pt_extras')->result();
      $amount = $rs[0]->extras_basic_price;
      $price = $curr->convertPriceFloat($amount);
      $extFee += $amount;
      $info = $this->extrasTranslation($ext, $rs[0]->extras_title, $rs[0]->extras_desc);
      $result['extrasIndividualFee'][] = array("id" => $ext, "price" => $price);
      $result['extrasInfo'][] = array("title" => $info['title'], "price" => $price);
    }
    $result['extrasTotalFee'] = $extFee;
    return $result;
  }
//get updated values of booking data after extras and payment method updates
  function getUpdatedDataBookResultObject($boatid, $adults = 1, $child = 0, $infant = 0, $extras) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    $extratotal = $this->extrasFee($extras);
    $extTotal = $extratotal['extrasTotalFee'];
    $paymethodTotal = 0; //$this->paymethodFee($this->ci->input->post('paymethod'),$total);
    $this->set_id($boatid);
    $this->boat_short_details();
    $adultPrice = $this->adultPrice * $adults;
    $childPrice = $this->childPrice * $child;
    $infantPrice = $this->infantPrice * $infant;
    $totalSum = $adultPrice + $childPrice + $infantPrice;
    $total = $curr->convertPriceFloat($extTotal) + $curr->convertPriceFloat($adultPrice) + $curr->convertPriceFloat($childPrice) + $curr->convertPriceFloat($infantPrice);
    $this->setTax($total);
    $taxAmount = $curr->addComma($this->taxamount);
    $grandTotal = $total + $paymethodTotal + $this->taxamount;
    $this->setDeposit($grandTotal);
    $depositAmount = $this->deposit;
    $price = $grandTotal;
//$perNight = $curr->convertPrice($roomprice['perNight'],0);
    $extrasHtml = "";
    foreach ($extratotal['extrasInfo'] as $einfo) {
      $extrasHtml .= "<tr class='allextras'><td>" . $einfo['title'] . "</td>
          					<td class='text-right'>" . $curr->code . " " . $curr->symbol . $curr->addComma($einfo['price']) . "</td></tr>";
    }
    $adultsSubitem = array("price" => $curr->convertPriceFloat($this->adultPrice), "count" => $adults);
    if ($child > 0) {
      $childSubitem = array("price" => $curr->convertPriceFloat($this->childPrice), "count" => $child);
    }
    else {
      $childSubitem = "";
    }
    if ($infant > 0) {
      $infantSubitem = array("price" => $curr->convertPriceFloat($this->infantPrice), "count" => $infant);
    }
    else {
      $infantSubitem = "";
    }
    $subitem = array("adults" => $adultsSubitem, "child" => $childSubitem, "infant" => $infantSubitem);
    $result = (object) array('grandTotal' => $price, 'taxAmount' => $taxAmount, 'depositAmount' => $depositAmount, 'extrashtml' => $extrasHtml, 'bookingType' => "boats", 'currCode' => $curr->code, 'stay' => 1, 'currSymbol' => $curr->symbol, 'subitem' => $subitem, 'extrasInfo' => $extratotal);
//end boat details for booking page
    return json_encode($result);
  }
  public function checkErrors($maxAdults, $maxChild, $maxInfant) {
    if ($maxAdults < $this->adults) {
      $this->error = true;
      $this->errorCode = "0455";
    }
    elseif ($maxChild < $this->child) {
      $this->error = true;
      $this->errorCode = "0456";
    }
    elseif ($maxInfant < $this->infants) {
      $this->error = true;
      $this->errorCode = "0457";
    }
  }
//convert price
  public function convertAmount($price) {
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    return $curr->convertPriceFloat($price);
  }
  public function convertPriceRange($price) {
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    return $curr->convertPriceRange($price, 0);
  }
  public function priceRange($sprice) {
    $result = "";
    if (!empty($sprice)) {
      $sprice = str_replace(";", ",", $sprice);
      $sprice = explode(",", $sprice);
      $minprice = $this->convertPriceRange($sprice[0]);
      $maxprice = $this->convertPriceRange($sprice[1]);
      $result = $minprice . "-" . $maxprice;
    }
    return $result;
  }
  public function boatsByLocations($totalnums = 7) {
    $locData = new stdClass;
    $this->db->select('location_id,boat_id');
    $this->db->where('position', '1');
    $this->db->group_by('location_id');
    $result = $this->db->get('pt_boat_locations')->result();
    foreach ($result as $rs) {
      $this->db->select('boat_id');
      $this->db->where('boat_location', $rs->location_id);
      $this->db->where('boat_status', 'Yes');
      $boats = $this->db->get('pt_boats')->result();
/*$boatData = $this->getSingleResultObject($rs->boat_id);*/
      $locationInfo = pt_LocationsInfo($rs->location_id, $this->lang);
      $locData->locations[] = (object) array('id' => $rs->location_id, 'name' => $locationInfo->city, 'count' => count($boats), 'boats' => $boats);
    }
    usort($locData->locations, array($this, "cmp"));
    $locData->locations = array_slice($locData->locations, 0, $totalnums);
    return $locData;
  }
  function cmp($a, $b) {
    return $a->count < $b->count;
  }
  public function siteMapData() {
    $boatsData = array();
    $this->db->select('boat_id');
    $this->db->where('boat_status', 'Yes');
    $result = $this->db->get('pt_boats');
    $boats = $result->result();
    if (!empty($boats)) {
      $boatsData = $this->getLimitedResultObject($boats);
    }
    return $boatsData;
  }
  public function suggestionResults($query) {
    $response = array();
    $this->db->select('pt_boats_translation.trans_title as title, pt_boats.boat_id as id,pt_boats.boat_title as title');
    $this->db->like('pt_boats.boat_title', $query);
    $this->db->or_like('pt_boats_translation.trans_title', $query);
    $this->db->join('pt_boats_translation', 'pt_boats.boat_id = pt_boats_translation.item_id', 'left');
    $this->db->group_by('pt_boats.boat_id');
    $this->db->limit('25');
    $res = $this->db->get('pt_boats')->result();
    $boats = array();
    $locations = array();
    $this->db->select('pt_locations.id,pt_locations.location');
    $this->db->like('pt_locations.location', $query);
//$this->db->or_like('pt_locations.country',$query);
    $this->db->limit('25');
    $this->db->group_by('pt_locations.id');
    $this->db->join('pt_boat_locations', 'pt_locations.id = pt_boat_locations.location_id');
    $locres = $this->db->get('pt_locations')->result();
    if (!empty($locres)) {
    foreach ($locres as $l) {
        $lc++;
        $locInfo = pt_LocationsInfo($l->id, $this->lang);
        $locations[] = (object) array('id' => $l->id, 'text' => $locInfo->city.", ".$locInfo->country, 'module' => 'location', 'disabled' => false);
      }
    }
    if (!empty($res)) {
    foreach ($res as $r) {
        $title = $this->get_title($r->title, $r->id);
        $boats[] = (object) array('id' => $r->id, 'text' => trim($title), 'module' => 'boat', 'disabled' => false);
      }
    }
    $tt = array("text" => "boats", "children" => $boats);
    $ll = array("text" => "Locations", "children" => $locations);
    if(!empty($boats)){
      $response[] = $tt;
    }
  if(!empty($locations)){
    $response[] = $ll;
  }
  $responseApi = array_merge($boats, $locations);
  $dataResponse['forApi'] = array("items" => $responseApi);

   $dataResponse['forWeb'] = $response;
   return $dataResponse;
  }
  // boats Loaction Load By Default Mobile Api
    public function suggestionResultsapi() {
        $response = array();
        $locations = array();
        $this->db->select('pt_locations.id,pt_locations.location');
        $this->db->limit('50');
        $this->db->group_by('pt_locations.id');
        $this->db->join('pt_boat_locations', 'pt_locations.id = pt_boat_locations.location_id');
        $locres = $this->db->get('pt_locations')->result();
        if (!empty($locres)) {
            foreach ($locres as $l) {
                $locInfo = pt_LocationsInfo($l->id, $this->lang);
                $locations[] = (object) array('id' => $l->id, 'text' => $locInfo->city.", ".$locInfo->country, 'module' => 'location', 'disabled' => false);
            }
        }
        $ll = array("text" => "Locations", "children" => $locations);
        if(!empty($locations)){
            $response[] = $ll;
        }
        $responseApi =  $locations;
        $dataResponse['forApi'] = array("items" => $responseApi);
        return $dataResponse;
    }
  function getLatestboatsForAPI() {
    $this->ci->db->select('boat_id,boat_created_at');
    $this->ci->db->order_by('boat_created_at', 'desc');
    $this->ci->db->limit('10');
    $items = $this->ci->db->get('pt_boats')->result();
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    if (!empty($items)) {
      foreach ($items as $h) {
        $this->set_id($h->boat_id);
        $this->boat_short_details();
        $adultprice = $this->adultPrice * $this->adults;
        $price = $curr->convertPrice($adultprice);
        $avgReviews = $this->boatReviewsAvg();
        if (!empty($this->title)) {
          $result[] = (object) array('id' => $h->boat_id, 'title' => $this->title, 'thumbnail' => $this->thumbnail, 'starsCount' => $this->stars,'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'avgReviews' => $avgReviews, 'createdAt' => $this->createdAt, 'module' => 'boats');
        }
      }
    }
    return $result;
  }
}
