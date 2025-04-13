<?php
class Tours_lib {
/**
* Protected variables
*/
  protected $ci = NULL; //codeigniter instance
  protected $db; //database instatnce instance
  public $appSettings;
  public $tourid;
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
  public $tourNights;
  public $tourDays;
  public $tourhours;
  public $tourType;
  public $adults;
  public $child;
  public $infants;
  public $selectedLocation;
  public $selectedTourType;
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
    $this->ci->load->model('Tours/Tours_model');
    $this->ci->load->helper('Tours/tours_front');
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
    $this->selectedTourType = $this->selectedTourType($typeid);
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

  public function getDefaultToursListForSearchField()
  {
      $tours = $this->db->select('tour_id AS id, tour_title AS text, "tour" AS module, "false" AS disabled')->get('pt_tours')->result();
      $locations = $this->db->query("
        SELECT pt_locations.id AS id, CONCAT(country, ', ', location) AS text, 'location' AS `module`, 'false' AS disabled 
        FROM `pt_tour_locations` 
        JOIN pt_locations ON pt_locations.id = pt_tour_locations.location_id
        WHERE `tour_id` IN (
            SELECT tour_id FROM `pt_tours`
        )
        GROUP BY pt_locations.id
      ")->result();

      $resultin_array = [
          ["text" => "Locations", "children" => $locations],
          ["text" => "Tours", "children" => $tours]
      ];

      return json_encode($resultin_array);
  }

  function set_tourid($tourslug) {
    $this->db->select('tour_id');
    $this->db->where('tour_slug', $tourslug);
    $r = $this->db->get('pt_tours')->result();
    $this->tourid = $r[0]->tour_id;
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
//set tour id by id
  function set_id($id, $currsign = null, $currcode = null) {
    $this->tourid = $id;
    $this->currencysign = $currsign;
    $this->currencycode = $currcode;
  }
  function get_id() {
    return $this->tourid;
  }
  function settings() {
    return $this->ci->Settings_model->get_front_settings('tours');
  }
  function wishListInfo($id) {
    $this->tour_short_details($id);
    $title = $this->title;
    $slug = base_url() . 'tours/' . $this->slug;
    $thumbnail = $this->thumbnail;
    $location = $this->location;
    $stars = pt_create_stars($this->stars);
    $res = array("title" => $title, "slug" => $slug, "thumbnail" => $thumbnail, "location" => $location->city, "stars" => $stars,);
    return $res;
  }
  function selectedTourType($id) {
    $option = "";
    if (!empty($id)) {
      $res = $this->tourTypeSettings($id);
      if (!empty($res->name)) {
        $option = "<option value=" . $res->id . " selected >" . $res->name . "</option>";
      }
    }
    return $option;
  }
  function show_tours($offset = null) {
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
    $rh = $this->ci->Tours_model->list_tours_front($priceRange);
    $tours = $this->ci->Tours_model->list_tours_front($priceRange, $perpage, $offset, $orderby);
    $data['all_tours'] = $this->getResultObject($tours['all']);
    $data['paginationinfo'] = array('base' => 'tours/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
    return $data;
  }
  function showToursByLocation($locs, $offset = null) {
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
    $rh = $this->ci->Tours_model->showToursByLocation($locs->locations, $priceRange);
    $tours = $this->ci->Tours_model->showToursByLocation($locs->locations, $priceRange, $perpage, $offset, $orderby);
    $data['all_tours'] = $this->getResultObject($tours['all']);
    $data['paginationinfo'] = array('base' => 'tours/' . $locs->urlBase, 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => $locs->uriSegment);
    return $data;
  }
  function search_tours($location, $offset = null) {
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
    $rh = $this->ci->Tours_model->search_tours_front($location, $priceRange);
    $tours = $this->ci->Tours_model->search_tours_front($location, $priceRange, $perpage, $offset, $orderby);
    $data['all_tours'] = $this->getResultObject($tours['all']);
    $data['paginationinfo'] = array('base' => 'tours/search' . $segments, 'totalrows' => $rh['rows'], 'perpage' => $perpage, 'urisegment' => $urisegment);
    return $data;
  }

  function search_tours_api($location, $offset = null) {
      //dd($location);
    $data = array();
    $settings = $this->settings();
    $perpage = $settings[0]->front_search;
    $orderby = $settings[0]->front_search_order;
    $totalSegments = $this->ci->uri->total_segments();
    $segments = "";
    $priceRange = $this->priceRange($this->ci->input->get('price'));
    $rh = $this->ci->Tours_model->search_tours_front($location, $priceRange);
    $tours = $this->ci->Tours_model->search_tours_front($location, $priceRange, $perpage, $offset, $orderby);
    $data['all_tours'] = $this->getResultObject($tours['all']);
    $data['paginationinfo'] = array('base' => 'tours/search' . $segments, 'totalrows' => $rh['rows'], 'perpage' => $perpage);
    return $data;
  }

  function tour_details($tourid = null, $date = null) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    else {
      $tourid = $tourid;
    }
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    if (!empty($date)) {
      $this->date = $date;
    }
    $this->db->where('tour_id', $tourid);
    $details = $this->db->get('pt_tours')->result();
    $title = $this->get_title($details[0]->tour_title, $details[0]->tour_id);
    $stars = $details[0]->tour_stars;
    $desc = $this->get_description($details[0]->tour_desc, $details[0]->tour_id);
    $policy = $this->get_policy($details[0]->tour_privacy, $details[0]->tour_id);
    $locationInfoUrl = pt_LocationsInfo($details[0]->tour_location);
    $countryName = url_title($locationInfoUrl->country, 'dash', true);
    $cityName = url_title($locationInfoUrl->city, 'dash', true);
    $slug = $countryName . '/' . $cityName . '/' . $details[0]->tour_slug . $this->urlVars;
    $bookingSlug = $details[0]->tour_slug . $this->urlVars;
    $keywords = $this->get_keywords($details[0]->tour_meta_keywords, $details[0]->tour_id);
    $metadesc = $this->get_metaDesc($details[0]->tour_meta_desc, $details[0]->tour_id);
    $tourDays = $details[0]->tour_days;
    $tourhours = $details[0]->tour_hours;
    $tourNights = $details[0]->tour_nights;
    if (!empty($details[0]->tour_amenities)) {
      $tourAmenities = explode(",", $details[0]->tour_amenities);
      foreach ($tourAmenities as $tm) {
        $amts[] = $this->tourTypeSettings($tm);
      }
    }
    else {
      $amts = array();
    }
    $inclusions = $amts;
    if (!empty($details[0]->tour_exclusions)) {
      $tourExclusions = explode(",", $details[0]->tour_exclusions);
      foreach ($tourExclusions as $exc) {
        $excs[] = $this->tourTypeSettings($exc);
      }
    }
    else {
      $excs = array();
    }
    $exclusions = $excs;
    if (!empty($details[0]->tour_payment_opt)) {
      $tourPaymentOpts = explode(",", $details[0]->tour_payment_opt);
      foreach ($tourPaymentOpts as $p) {
        $payopts[] = $this->tourTypeSettings($p);
      }
    }
    else {
      $payopts = array();
    }
    $paymentOptions = $payopts;
    if (!empty($details[0]->tour_related)) {
      $rtours = explode(",", $details[0]->tour_related);
    }
    else {
      $rtours = "";
    }
    $relatedTours = $this->getRelatedTours($rtours);
    $thumbnail = PT_TOURS_SLIDER_THUMB . $details[0]->thumbnail_image;
    $city = pt_LocationsInfo($details[0]->tour_location, $this->lang);
    $location = $city->city; // $details[0]->tour_location;
//	$isfeatured = $this->is_featured();
    $website = $details[0]->tour_website;
    $phone = $details[0]->tour_phone;
    $email = $details[0]->tour_email;
    $taxcom = $this->tour_tax_commision();
    $comm_type = $taxcom['commtype'];
    $comm_value = $taxcom['commval'];
    $tax_type = $taxcom['taxtype'];
    $tax_value = $taxcom['taxval'];
    $latitude = $details[0]->tour_latitude;
    $longitude = $details[0]->tour_longitude;
    $totalAdutlsPrice = $details[0]->tour_adult_price * $this->adults;
    $totalChildPrice = $details[0]->tour_child_price * $this->child;
    $totalInfantsPrice = $details[0]->tour_infant_price * $this->infants;
    $adultPrice = $curr->convertPrice($totalAdutlsPrice);
    $childPrice = $curr->convertPrice($totalChildPrice);
    $infantPrice = $curr->convertPrice($totalInfantsPrice);
    $perAdultPrice = $curr->convertPrice($details[0]->tour_adult_price);
    $perChildPrice = $curr->convertPrice($details[0]->tour_child_price);
    $perInfantPrice = $curr->convertPrice($details[0]->tour_infant_price);
    $maxAdults = $details[0]->tour_max_adults;
    $maxChild = $details[0]->tour_max_child;
    $maxInfant = $details[0]->tour_max_infant;
    $this->checkErrors($maxAdults, $maxChild, $maxInfant);
    $adultStatus = $details[0]->adult_status;
    $childStatus = $details[0]->child_status;
    $infantStatus = $details[0]->infant_status;
    $sliderImages = $this->tourImages($details[0]->tour_id);
    $totalCost = $totalAdutlsPrice + $totalChildPrice + $totalInfantsPrice;
    $taxcom = $this->tour_tax_commision($details[0]->tour_id);
    $this->comm_type = $taxcom['commtype'];
    $this->comm_value = $taxcom['commval'];
    $this->tax_type = $taxcom['taxtype'];
    $this->tax_value = $taxcom['taxval'];
    $this->setDeposit($curr->convertPriceFloat($totalCost, 2));
    $depositAmount = $this->deposit;
    $discount = $this->discount($tourid);
    $detailResults = (object) array('id' => $details[0]->tour_id, 'title' => $title, 'slug' => $slug, 'bookingSlug' => $bookingSlug, 'thumbnail' => $thumbnail, 'stars' => pt_create_stars($stars), 'starsCount' => $stars, 'location' => $location, 'desc' => $desc, 'inclusions' => $inclusions, 'exclusions' => $exclusions, 'latitude' => $latitude, 'longitude' => $longitude, 'sliderImages' => $sliderImages, 'relatedItems' => $relatedTours, 'paymentOptions' => $paymentOptions, 'metadesc' => $metadesc, 'keywords' => $keywords, 'policy' => $policy, 'website' => $website, 'email' => $email, 'phone' => $phone, 'maxAdults' => $maxAdults, 'maxChild' => $maxChild, 'maxInfant' => $maxInfant, 'adultStatus' => $adultStatus, 'childStatus' => $childStatus, 'infantStatus' => $infantStatus, 'adultPrice' => $adultPrice, 'childPrice' => $childPrice, 'infantPrice' => $infantPrice, 'perAdultPrice' => $perAdultPrice, 'perChildPrice' => $perChildPrice, 'perInfantPrice' => $perInfantPrice, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'date' => $this->date, 'totalCost' => $curr->convertPrice($totalCost), 'comType' => $comm_type, 'comValue' => $comm_value, 'taxType' => $tax_type, 'taxValue' => $tax_value, 'tourDays' => $tourDays, 'tourhours' => $tourhours, 'tourNights' => $tourNights, 'totalDeposit' => $depositAmount, 'mapAddress' => $details[0]->tour_mapaddress, 'discount' =>$discount);
    return $detailResults;
  }
  function tour_short_details($tourid = 0) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $this->db->select('tour_title,tour_stars,tour_slug,tour_desc,tour_privacy,tour_max_adults,tour_max_child,
   tour_max_infant,tour_basic_price,tour_basic_discount,tour_adult_price,tour_child_price,tour_infant_price,tour_amenities,tour_exclusions,tour_days,tour_nights,thumbnail_image,tour_location,tour_latitude,tour_longitude,tour_type,tour_created_at');
    $this->db->where('tour_id', $tourid);
    $details = $this->db->get('pt_tours')->result();
    $this->stars = $details[0]->tour_stars;
    $this->title = $this->get_title($details[0]->tour_title, NULL);
    $this->desc = $this->get_description($details[0]->tour_desc, NULL);
    $this->policy = $this->get_policy($details[0]->tour_privacy, NULL);
    $this->tourDays = $details[0]->tour_days;
    $this->tourhours = $details[0]->tour_hours;
    $this->tourNights = $details[0]->tour_nights;
    $this->tourNights = $details[0]->tour_nights;
    $this->createdAt = $details[0]->tour_created_at;
    $maxAdults = $details[0]->tour_max_adults;
    $maxChild = $details[0]->tour_max_child;
    $maxInfant = $details[0]->tour_max_infant;
    $this->checkErrors($maxAdults, $maxChild, $maxInfant);
//get country and city name for url slug
    $locationInfoUrl = pt_LocationsInfo($details[0]->tour_location);
    $countryName = url_title($locationInfoUrl->country, 'dash', true);
    $cityName = url_title($locationInfoUrl->city, 'dash', true);
    $this->slug = $countryName . '/' . $cityName . '/' . $details[0]->tour_slug . $this->urlVars;
    $this->bookingSlug = $details[0]->tour_slug . $this->urlVars;
    $city = pt_LocationsInfo($details[0]->tour_location, $this->lang);
    $this->location = $city->city;
//$details[0]->tour_location;
    $this->latitude = $details[0]->tour_latitude;
    $this->longitude = $details[0]->tour_longitude;
    $this->thumbnail = PT_TOURS_SLIDER_THUMB . $details[0]->thumbnail_image;
    $type = $this->tourTypeSettings($details[0]->tour_type);
    $this->tourType = $type->name;
    $taxcom = $this->tour_tax_commision();
    $this->comm_type = $taxcom['commtype'];
    $this->comm_value = $taxcom['commval'];
    $this->tax_type = $taxcom['taxtype'];
    $this->tax_value = $taxcom['taxval'];
    $this->adultPrice = $details[0]->tour_adult_price;
    $this->childPrice = $details[0]->tour_child_price;
    $this->infantPrice = $details[0]->tour_infant_price;
    $this->isfeatured = $this->is_featured(NULL);
    return $details;
  }
  function tour_tax_commision($tourid = null) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $res = array();
    $this->db->select('tour_comm_fixed,tour_comm_percentage,tour_tax_fixed,tour_tax_percentage');
    $this->db->where('tour_id', $tourid);
    $result = $this->db->get('pt_tours')->result();
    $commfixed = $result[0]->tour_comm_fixed;
    $commper = $result[0]->tour_comm_percentage;
    $taxfixed = $result[0]->tour_tax_fixed;
    $taxper = $result[0]->tour_tax_percentage;
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
// get tour images
  function tourImages($tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $this->db->where('timg_tour_id', $tourid);
    $this->db->where('timg_approved', '1');
    $this->db->order_by('timg_order', 'asc');
    $res = $this->db->get('pt_tour_images')->result();
    if (empty($res)) {
      $result[] = array("fullImage" => PT_TOURS_SLIDER_THUMB . PT_BLANK_IMG, "thumbImage" => PT_TOURS_SLIDER_THUMB . PT_BLANK_IMG);
    }
    else {
      foreach ($res as $r) {
        $result[] = array("fullImage" => PT_TOURS_SLIDER . $r->timg_image, "thumbImage" => PT_TOURS_SLIDER_THUMB . $r->timg_image);
      }
    }
    return $result;
  }
  function getFeaturedTours() {
    $tours = $this->featured_tours_list();
    $result = $this->getResultObject($tours);
    return $result;
  }
    function getFeaturedToursmain($lang,$currency) {
        $this->ci->load->model('Hotels/Hotels_model');
      $this->lang = $lang;
        $tours = $this->featured_tours_list();
        $result = $this->getResultObject($tours);
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
                'price'=>$price,
                'currCode'=>$currency,
                'inclusions'=>$value->inclusions,
                'tourDays'=>$value->tourDays,
                'tourNights'=>$value->tourNights,
                'tourType'=>$value->tourType,
            ]);


        }
        return $results;
    }
  function getCountryFeaturedTours() {
    $tours = $this->featured_tours_list_by_country();
    $result = $this->getCoutryResultObject($tours);
    return $result;
  }
  function getLocationBasedFeaturedTours($loc) {
    $settings = $this->settings();
    $limit = $settings[0]->front_homepage;
    $this->db->select('tour_id');
    $this->db->where('tour_location', $loc);
    $this->db->where('tour_status', 'Yes');
    $toursList = $this->db->get('pt_tours')->result();
    $tours = array();
    foreach ($toursList as $t) {
      $isFeatured = $this->is_featured($t->tour_id);
      if ($isFeatured) {
        $tours[] = (object) array('tour_id' => $t->tour_id);
      }
    }
    $tours = array_slice($tours, 0, $limit);
    $result = $this->getResultObject($tours);
    return $result;
  }
  function getTopRatedTours() {
    $tours = $this->ci->Tours_model->popular_tours_front();
    $result = $this->getResultObject($tours);
    return $result;
  }
  function getRelatedTours($tours) {
    $resulttours = array();
    $result = array();
    $settings = $this->settings();
    $limit = $settings[0]->front_related;
    $count = 0;
    if (!empty($tours)) {
      foreach ($tours as $t) {
        $count++;
        if($count <= $limit){
          $resulttours[] = (object) array('tour_id' => $t);
        }

      }
    }
    $result = $this->getLimitedResultObject($resulttours);
    return $result;
  }
// Get Tour updated Price on changing adults, child and infant count.
  function updatedPrice($tourid, $adults = 1, $child = 0, $infant = 0) {
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    $this->db->select('tour_adult_price,tour_child_price,tour_infant_price');
    $this->db->where('tour_id', $tourid);
    $details = $this->db->get('pt_tours')->result();
    $totalAdutlsPrice = $details[0]->tour_adult_price * $adults;
    $totalChildPrice = $details[0]->tour_child_price * $child;
    $totalInfantsPrice = $details[0]->tour_infant_price * $infant;
    $adultPrice = $curr->convertPrice($totalAdutlsPrice);
    $childPrice = $curr->convertPrice($totalChildPrice);
    $infantPrice = $curr->convertPrice($totalInfantsPrice);
    $totalCost = $totalAdutlsPrice + $totalChildPrice + $totalInfantsPrice;
    $taxcom = $this->tour_tax_commision($tourid);
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
    $detailResults = array('id' => $tourid, 'adultPrice' => $adultPrice, 'childPrice' => $childPrice, 'infantPrice' => $infantPrice, 'currCode' => $curr->code, 'currSymbol' => $currSymbol, 'totalDeposit' => $curr->convertPrice($depositAmount), 'totalCost' => $curr->convertPrice($totalCost));
    return json_encode($detailResults);
  }
  function get_thumbnail() {
    $res = $this->ci->Tours_model->default_tour_img($this->tourid);
    if (!empty($res)) {
      return PT_TOURS_SLIDER_THUMB . $res;
    }
    else {
      return PT_BLANK;
    }
  }
  function get_title($deftitle, $tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    if ($this->lang == $this->langdef) {
      $title = $deftitle;
    }
    else {
      $this->db->where('item_id', $tourid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_tours_translation')->result();
      $title = $res[0]->trans_title;
      if (empty($title)) {
        $title = $deftitle;
      }
    }
    return $title;
  }
  function get_description($defdesc, $tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    if ($this->lang == $this->langdef) {
      $desc = $defdesc;
    }
    else {
      $this->db->where('item_id', $tourid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_tours_translation')->result();
      $desc = $res[0]->trans_desc;
      if (empty($desc)) {
        $desc = $defdesc;
      }
    }
    return $desc;
  }
  function get_policy($defpolicy, $tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    if ($this->lang == $this->langdef) {
      $policy = $defpolicy;
    }
    else {
      $this->db->where('item_id', $tourid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_tours_translation')->result();
      $policy = $res[0]->trans_policy;
      if (empty($policy)) {
        $policy = $defpolicy;
      }
    }
    return $policy;
  }
  function get_keywords($defkeywords, $tourid = null) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    if ($this->lang == $this->langdef) {
      $keywords = $defkeywords;
    }
    else {
      $this->db->where('item_id', $tourid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_tours_translation')->result();
      $keywords = $res[0]->metakeywords;
      if (empty($keywords)) {
        $keywords = $defkeywords;
      }
    }
    return $keywords;
  }
  function get_metaDesc($defmeta, $tourid = null) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    if ($this->lang == $this->langdef) {
      $meta = $defmeta;
    }
    else {
      $this->db->where('item_id', $tourid);
      $this->db->where('trans_lang', $this->lang);
      $res = $this->db->get('pt_tours_translation')->result();
      $meta = $res[0]->metadesc;
      if (empty($meta)) {
        $meta = $defmeta;
      }
    }
    return $meta;
  }
  function tourExtras($tourid = null) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $today = time();
    $result = array();
//	$this->db->where('extras_from  <=', $today);
//	$this->db->where('extras_to >=', $today);
    $this->db->where('extras_module', 'tours');
//  $this->db->or_where('extras_forever','forever');
    $this->db->order_by('extras_id', 'desc');
    $this->db->like('extras_for', $tourid, 'both');
    $this->db->having('extras_status', 'Yes');
    $ext = $this->db->get('pt_extras')->result();
    $this->ci->load->library('currconverter');
    $curr = $this->ci->currconverter;
    if (!empty($ext)) {
      foreach ($ext as $e) {
        $trans = $this->extrasTranslation($e->extras_id, $e->extras_title, $e->extras_desc);
        $price = $curr->convertPrice($e->extras_basic_price);
        $result[] = (object) array("id" => $e->extras_id, "extraTitle" => $trans['title'], "extraDesc" => $trans['desc'], 'extraPrice' => $price, 'thumbnail' => PT_TOURS_EXTRAS_IMAGES . $e->extras_image);
      }
    }
    return $result;
  }
  function getLocationsList() {
    $resultLocations = array();
    $this->db->select('location_id');
    $this->db->group_by('location_id');
    $locations = $this->db->get('pt_tour_locations')->result();
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
// tour Reviews
  function tour_reviews($tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'tours');
    $this->db->where('review_itemid', $tourid);
    $this->db->order_by('review_id', 'desc');
    return $this->db->get('pt_reviews')->result();
  }
// tour Reviews for API
  function tour_reviews_for_api($tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $result = array();
    $this->db->select('review_overall as rating,review_name as review_by,review_comment,review_date');
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'tours');
    $this->db->where('review_itemid', $tourid);
    $this->db->order_by('review_id', 'desc');
    $rs = $this->db->get('pt_reviews')->result();
    foreach ($rs as $r) {
      $result[] = array("rating" => $r->rating, "review_by" => $r->review_by, "review_comment" => $r->review_comment, "review_date" => pt_show_date_php($r->review_date));
    }
    return $result;
  }
// tour  Reviews Averages
  function tourReviewsAvg($tourid = 0) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $this->db->select("COUNT(*) AS totalreviews");
    $this->db->select_avg('review_overall', 'overall');
    $this->db->select_avg('review_clean', 'clean');
    $this->db->select_avg('review_facilities', 'facilities');
    $this->db->select_avg('review_staff', 'staff');
    $this->db->select_avg('review_comfort', 'comfort');
    $this->db->select_avg('review_location', 'location');
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'tours');
    $this->db->where('review_itemid', $tourid);
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
// Tour visiting Cities
  function tour_visiting_cities() {
    $this->db->select('map_city_name');
    $this->db->where('map_city_type', 'visit');
    $this->db->where('map_tour_id', $this->tourid);
    return $this->db->get('pt_tours_maps')->result();
  }
  function translated_data($lang) {
    $this->db->where('item_id', $this->tourid);
    $this->db->where('trans_lang', $lang);
    return $this->db->get('pt_tours_translation')->result();
  }
  function is_featured($tourid) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    else {
      $tourid = $tourid;
    }
    $this->db->select('tour_id');
    $this->db->where('tour_is_featured', 'yes');
    $this->db->where('tour_featured_from <', time());
    $this->db->where('tour_featured_to >', time());
    $this->db->or_where('tour_featured_forever', 'forever');
    $this->db->having('tour_id', $tourid);
    return $this->db->get('pt_tours')->num_rows();
  }
  function featured_tours_list() {
    $settings = $this->settings();
    $limit = $settings[0]->front_homepage;
    $orderby = $settings[0]->front_homepage_order;
    $this->db->select('tour_id,tour_order,tour_title,tour_status,tour_location');
    $this->db->where('tour_is_featured', 'yes');
    $this->db->where('tour_featured_from <', time());
    $this->db->where('tour_featured_to >', time());
    $this->db->or_where('tour_featured_forever', 'forever');
    $this->db->having('tour_status', 'Yes');
    $this->db->limit($limit);
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
    return $this->db->get('pt_tours')->result();
  }

  //test function by Hafiz Abuzar
  function featured_tours_list_by_country() {
    $settings = $this->settings();
    $limit = $settings[0]->front_homepage;
    $orderby = $settings[0]->front_homepage_order;
    $this->db->select('tour_id,tour_order,tour_title,tour_status,tour_location, count(tour_location) as total_tour, loc.country');
    $this->db->join('pt_locations as loc', 'loc.id = pt_tours.tour_location', 'inner');
    $this->db->where('tour_is_featured', 'yes');
    $this->db->where('tour_featured_from <', time());
    $this->db->where('tour_featured_to >', time());
    $this->db->or_where('tour_featured_forever', 'forever');
    $this->db->group_by('loc.country');
    $this->db->having('tour_status', 'Yes');
    $this->db->limit($limit);
    $this->db->order_by('total_tour', 'desc');
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
    //$this->db->get('pt_tours');
    //echo $this->db->last_query(); die;

    return $this->db->get('pt_tours')->result();
  }
  // end test function by Hafiz Abuzar





// tour Reviews
  function tourReviews($tourid = null) {
    if (empty($tourid)) {
      $tourid = $this->tourid;
    }
    $this->db->where('review_status', 'Yes');
    $this->db->where('review_module', 'tours');
    $this->db->where('review_itemid', $tourid);
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
  function tourTypes() {
    $tourtypes = array();
    $this->db->select('sett_name,sett_id');
    $this->db->where('sett_type', 'ttypes');
    $types = $this->db->get('pt_tours_types_settings')->result();
    foreach ($types as $t) {
      $tname = $this->tourTypeSettings($t->sett_id);
      $tourtypes[] = (object) array('id' => $t->sett_id, 'name' => $tname->name);
    }
    return $tourtypes;
  }
// Tour Type
  function tourTypeSettings($id) {
    $language = $this->lang;
    $result = new stdClass;
    $this->db->select('sett_name,sett_img');
    $this->db->where('sett_id', $id);
    $this->db->where('sett_status', 'Yes');
    $re = $this->db->get('pt_tours_types_settings')->result();
    $result->icon = PT_TOURS_ICONS . $re[0]->sett_img;
    $result->id = $id;
    if ($language == $this->langdef) {
      $result->name = $re[0]->sett_name;
    }
    else {
      $this->db->select('trans_name');
      $this->db->where('sett_id', $id);
      $this->db->where('trans_lang', $language);
      $r = $this->db->get('pt_tours_types_settings_translation')->result();
      if (empty($r[0]->trans_name)) {
        $result->name = $re[0]->sett_name;
      }
      else {
        $result->name = $r[0]->trans_name;
      }
    }
    return $result;
  }
//Populate Tour Types according to the location selected
  function getTourTypesLocationBased($location) {
    $result = new stdClass;
    $result->hasResult = FALSE;
    $result->optionsList = "";
    $tourTypes = array();
    $tourIDs = array();
    $this->db->where('location_id', $location);
    $this->db->group_by('tour_id');
    $tours = $this->db->get('pt_tour_locations')->result();
    if (!empty($tours)) {
      foreach ($tours as $t) {
        $tourIDs[] = $t->tour_id;
      }
    }
    $this->db->select('tour_type');
//$this->db->where('tour_location',$location);
    if (!empty($tourIDs)) {
      $this->db->where_in('tour_id', $tourIDs);
    }
    else {
      $this->db->where('tour_id', '0');
    }
    $this->db->group_by('tour_type');
    $res = $this->db->get('pt_tours')->result();
    if (!empty($res)) {
      foreach ($res as $r) {
        $tourTypes[] = $r->tour_type;
      }
      $result->hasResult = TRUE;
      foreach ($tourTypes as $type) {
        $typeDetails = $this->tourTypeSettings($type);
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
  function tourLocations($id = null) {
    $result = new stdClass;
    if (empty($id)) {
      $id = $this->tourid;
    }
    $this->db->where('tour_id', $id);
    $locs = $this->db->get('pt_tour_locations')->result();
    foreach ($locs as $l) {
      $locInfo = pt_LocationsInfo($l->location_id, $this->lang);
      if (!empty($locInfo->city)) {
        $result->locations[] = (object) array('id' => $locInfo->id, 'name' => $locInfo->city, 'lat' => $locInfo->latitude, 'long' => $locInfo->longitude);
      }
    }
    return $result;
  }
//make a result object all data of tours array
  function getResultObject($tours) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    foreach ($tours as $t) {
      $this->set_id($t->tour_id);
      $this->tour_short_details($t->tour_id);
      $adultprice = $this->adultPrice * $this->adults;
      $childprice = $this->childPrice;
      $infantprice = $this->infantPrice;
      $price = $curr->convertPrice($adultprice);
      $discount = $this->discount($t->tour_id);
      $avgReviews = $this->tourReviewsAvg(NULL);
      $result[] = (object) array('id' => $this->tourid, 'title' => $this->title, 'slug' => base_url() . 'tours/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'desc' => strip_tags($this->desc), 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'inclusions' => $this->inclusions, 'avgReviews' => $avgReviews, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'tourDays' => $this->tourDays, 'tourNights' => $this->tourNights, 'tourType' => $this->tourType, 'discount' => $discount);
    }
    $this->currencycode = $curr->code;
    $this->currencysign = $curr->symbol;
    return $result;
  }

  //Discount get Tour
    function discount($id){
        $this->ci->db->select('discount');
        $this->ci->db->where('tour_id',$id);
        $dis = $this->ci->db->get('pt_tours')->row();
        return $dis->discount;
    }
  // Featured countires tours
  function getCoutryResultObject($tours) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    foreach ($tours as $t) {
      $this->set_id($t->tour_id);
      $this->tour_short_details($t->tour_id);
      $adultprice = $this->adultPrice * $this->adults;
      $childprice = $this->childPrice;
      $infantprice = $this->infantPrice;
      $price = $curr->convertPrice($adultprice);
      $avgReviews = $this->tourReviewsAvg(NULL);
      $this->slug = urlencode(strtolower($t->country));
      $result[] = (object) array(
          'id' => $this->tourid,
          'total_tours' => $t->total_tour,
          'country' => $t->country,
          'title' => $this->title,
          'slug' => base_url() . 'tours/' . $this->slug,
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
          'tourDays' => $this->tourDays,
          'tourhours' => $this->tourhours,
          'tourNights' => $this->tourNights,
          'tourType' => $this->tourType
      );
    }

    $this->currencycode = $curr->code;
    $this->currencysign = $curr->symbol;

    return $result;
  }
  // end


//make a result object limited data of tours array
  function getLimitedResultObject($tours) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    if (!empty($tours)) {
      foreach ($tours as $t) {
        $this->set_id($t->tour_id);
        $this->tour_short_details();
        $adultprice = $this->adultPrice * $this->adults;
        $childprice = $this->childPrice;
        $infantprice = $this->infantPrice;
        $avgReviews = $this->tourReviewsAvg();
        $price = $curr->convertPrice($adultprice);
        if (!empty($this->title)) {
          $result[] = (object) array('id' => $this->tourid, 'title' => $this->title, 'slug' => base_url() . 'tours/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars),'starsCount' => $this->stars, 'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'avgReviews' => $avgReviews,);
        }
      }
    }
    return $result;
  }
//make a result object of single tour
  function getSingleResultObject($id) {
    $this->ci->load->library('currconverter');
    $result = "";
    $curr = $this->ci->currconverter;
    if (!empty($id)) {
      $this->set_id($id);
      $this->tour_short_details();
      $adultprice = $this->adultPrice * $this->adults;
      $childprice = $this->childPrice;
      $infantprice = $this->infantPrice;
      $avgReviews = $this->tourReviewsAvg();
      $price = $curr->convertPrice($adultprice);
      if (!empty($this->title)) {
        $result = (object) array('id' => $this->tourid, 'title' => $this->title, 'slug' => base_url() . 'tours/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'latitude' => $this->latitude, 'longitude' => $this->longitude, 'avgReviews' => $avgReviews,);
      }
    }
    return $result;
  }
//make a result object of booking info
  function getBookResultObject($tourid, $date = null, $adults = null, $child = null, $infants = null) {
    if (empty($date)) {
      $date = $this->date;
    }
    $extrasCheckUrl = base_url() . 'tours/tourajaxcalls/tourExtrasBooking';
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
//tour details for booking page
    $this->set_id($tourid);
    $this->tour_short_details();
    $extras = $this->tourExtras();
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
    $result["tour"] = (object) array('id' => $this->tourid, 'title' => $this->title, 'slug' => base_url() . 'tours/' . $this->slug, 'thumbnail' => $this->thumbnail, 'stars' => pt_create_stars($this->stars), 'starsCount' => $this->stars, 'location' => $this->location, 'date' => $date, 'metadesc' => $this->metadesc, 'keywords' => $this->keywords, 'extras' => $extras, 'taxAmount' => $taxAmount, 'depositAmount' => $depositAmount, 'policy' => $this->policy, 'extraChkUrl' => $extrasCheckUrl, 'adults' => $adults, 'children' => $child, 'infants' => $infants, 'tourDays' => $this->tourDays, 'tourhours' => $this->tourhours, 'tourNights' => $this->tourNights, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'price' => $price, 'adultprice' => $curr->convertPrice($adultPrice), 'childprice' => $curr->convertPrice($childPrice), 'infantprice' => $curr->convertPrice($infantPrice), 'subTotal' => $subTotal);
//end tour details for booking page
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
  function getUpdatedDataBookResultObject($tourid, $adults = 1, $child = 0, $infant = 0, $extras) {
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    $extratotal = $this->extrasFee($extras);
    $extTotal = $extratotal['extrasTotalFee'];
    $paymethodTotal = 0; //$this->paymethodFee($this->ci->input->post('paymethod'),$total);
    $this->set_id($tourid);
    $this->tour_short_details();
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
    $result = (object) array('grandTotal' => $price, 'taxAmount' => $taxAmount, 'depositAmount' => $depositAmount, 'extrashtml' => $extrasHtml, 'bookingType' => "tours", 'currCode' => $curr->code, 'stay' => 1, 'currSymbol' => $curr->symbol, 'subitem' => $subitem, 'extrasInfo' => $extratotal);
//end tour details for booking page
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
  public function toursByLocations($totalnums = 7) {
    $locData = new stdClass;
    $this->db->select('location_id,tour_id');
    $this->db->where('position', '1');
    $this->db->group_by('location_id');
    $result = $this->db->get('pt_tour_locations')->result();
    foreach ($result as $rs) {
      $this->db->select('tour_id');
      $this->db->where('tour_location', $rs->location_id);
      $this->db->where('tour_status', 'Yes');
      $tours = $this->db->get('pt_tours')->result();
/*$tourData = $this->getSingleResultObject($rs->tour_id);*/
      $locationInfo = pt_LocationsInfo($rs->location_id, $this->lang);
      $locData->locations[] = (object) array('id' => $rs->location_id, 'name' => $locationInfo->city, 'count' => count($tours), 'tours' => $tours);
    }
    usort($locData->locations, array($this, "cmp"));
    $locData->locations = array_slice($locData->locations, 0, $totalnums);
    return $locData;
  }
  function cmp($a, $b) {
    return $a->count < $b->count;
  }
  public function siteMapData() {
    $toursData = array();
    $this->db->select('tour_id');
    $this->db->where('tour_status', 'Yes');
    $result = $this->db->get('pt_tours');
    $tours = $result->result();
    if (!empty($tours)) {
      $toursData = $this->getLimitedResultObject($tours);
    }
    return $toursData;
  }
  public function suggestionResults($query) {
    $response = array();
    $this->db->select('pt_tours_translation.trans_title as title, pt_tours.tour_id as id,pt_tours.tour_title as title');
    $this->db->like('pt_tours.tour_title', $query);
    $this->db->or_like('pt_tours_translation.trans_title', $query);
    $this->db->join('pt_tours_translation', 'pt_tours.tour_id = pt_tours_translation.item_id', 'left');
    $this->db->group_by('pt_tours.tour_id');
    $this->db->limit('25');
    $res = $this->db->get('pt_tours')->result();
    $tours = array();
    $locations = array();
    $this->db->select('pt_locations.id,pt_locations.location');
    $this->db->like('pt_locations.location', $query);
//$this->db->or_like('pt_locations.country',$query);
    $this->db->limit('25');
    $this->db->group_by('pt_locations.id');
    $this->db->join('pt_tour_locations', 'pt_locations.id = pt_tour_locations.location_id');
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
        $tours[] = (object) array('id' => $r->id, 'text' => trim($title), 'module' => 'tour', 'disabled' => false);
      }
    }
    $tt = array("text" => "Tours", "children" => $tours);
    $ll = array("text" => "Locations", "children" => $locations);
    if(!empty($tours)){
      $response[] = $tt;
    }
  if(!empty($locations)){
    $response[] = $ll;
  }
  $responseApi = array_merge($tours, $locations);
  $dataResponse['forApi'] = array("items" => $responseApi);

   $dataResponse['forWeb'] = $response;
   return $dataResponse;
  }
  // Tours Loaction Load By Default Mobile Api
    public function suggestionResultsapi() {
        $response = array();
        $locations = array();
        $this->db->select('pt_locations.id,pt_locations.location');
        $this->db->limit('50');
        $this->db->group_by('pt_locations.id');
        $this->db->join('pt_tour_locations', 'pt_locations.id = pt_tour_locations.location_id');
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
  function getLatestToursForAPI() {
    $this->ci->db->select('tour_id,tour_created_at');
    $this->ci->db->order_by('tour_created_at', 'desc');
    $this->ci->db->limit('10');
    $items = $this->ci->db->get('pt_tours')->result();
    $this->ci->load->library('currconverter');
    $result = array();
    $curr = $this->ci->currconverter;
    if (!empty($items)) {
      foreach ($items as $h) {
        $this->set_id($h->tour_id);
        $this->tour_short_details();
        $adultprice = $this->adultPrice * $this->adults;
        $price = $curr->convertPrice($adultprice);
        $avgReviews = $this->tourReviewsAvg();
        if (!empty($this->title)) {
          $result[] = (object) array('id' => $h->tour_id, 'title' => $this->title, 'thumbnail' => $this->thumbnail, 'starsCount' => $this->stars,'location' => $this->location, 'price' => $price, 'currCode' => $curr->code, 'currSymbol' => $curr->symbol, 'avgReviews' => $avgReviews, 'createdAt' => $this->createdAt, 'module' => 'tours');
        }
      }
    }
    return $result;
  }
}
