<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Hotels extends MX_Controller {

   public function __construct() {

    $chk = modules::run('Home/is_main_module_enabled', 'hotels');

    if (!$chk) {
    Module_404();
    }

    $this->load->library('Hotels/Hotels_lib');
    $this->load->model('Hotels/Hotels_model');
    $this->load->model('Hotels/HotelsSearchModel');
    $this->data['phone'] = $this->load->get_var('phone');
    $this->data['contactemail'] = $this->load->get_var('contactemail');
    $this->data['usersession'] = $this->session->userdata('pt_logged_customer');
    $this->data['appModule'] = "hotels";
    $languageid = $this->uri->segment(2);
    $this->validlang = pt_isValid_language($languageid);
    if ($this->validlang) {
    $this->data['lang_set'] = $languageid;
    } else {

    $this->data['lang_set'] = $this->session->userdata('set_lang');
    }
    $defaultlang = pt_get_default_language();
    if (empty($this->data['lang_set'])) {
    $this->data['lang_set'] = $defaultlang;
    }
    $this->Hotels_lib->set_lang($this->data['lang_set']);
    $this->data['locationsList'] = $this->Hotels_lib->getLocationsList();
    $this->data['modulelib'] = $this->Hotels_lib;
    $this->hotelSettings = $this->Settings_model->get_front_settings('hotels')[0];
    $_SESSION['custom_hotels_checkin'] = date('d-m-Y');
    $_SESSION['custom_hotels_checkout'] = date('d-m-Y', strtotime('+1 days'));
    $this->data['conceptFilters'] = ['Bed Only', 'Bed & Breakfast', 'Half Board', 'Full Board', 'All Inclusive', 'Ultra All Inclusive'];


    }

    public function detail(...$args) {

        if (count($args) == 2) {
            list($city, $hotelname) = $args;
            $searchform_checkin = $_SESSION['custom_hotels_checkin'];
            $searchform_checkout = $_SESSION['custom_hotels_checkout'];
            $adults = 2;
            $childs = 0;
        } else {
            list($city, $hotelname, $searchform_checkin, $searchform_checkout, $adults, $childs) = $args;
            if (empty($searchform_checkin)) {
                $searchform_checkin = $_SESSION['custom_hotels_checkin'];
                $searchform_checkout = $_SESSION['custom_hotels_checkout'];
            }
            $_SESSION['search_hotels_checkin'] = '';
            $_SESSION['search_hotels_checkout'] = '';
        }
        if (!empty($_SESSION['search_hotels_checkin'])) {
            $searchform_checkin = $_SESSION['search_hotels_checkin'];
        }
        if (!empty($_SESSION['search_hotels_checkout'])) {
            $searchform_checkout = $_SESSION['search_hotels_checkout'];
        }
        $_GET['checkin'] = $searchform_checkin;
        $_GET['checkout'] = $searchform_checkout;
        $_GET['adults'] = $adults;
        $_GET['child'] = $childs;
        $_GET['searching'] = "";
        $_GET['roomscount'] = "";
        $this->Hotels_lib->checkin = $searchform_checkin;
        $this->Hotels_lib->checkout = $searchform_checkout;
        $this->Hotels_lib->stay = pt_count_days($searchform_checkin, $searchform_checkout);
        $this->Hotels_lib->adults = $adults;
        $this->Hotels_lib->children = $childs;
        $this->load->library('Hotels/Hotels_calendar_lib');
        $this->data['loadMap'] = true;
        $this->data['calendar'] = $this->Hotels_calendar_lib;
        $settings = $this->Settings_model->get_front_settings('hotels');
        $this->data['minprice'] = $settings[0]->front_search_min_price;
        $this->data['maxprice'] = $settings[0]->front_search_max_price;
        $this->data['checkin'] = $searchform_checkin;
        $this->data['checkout'] = $searchform_checkout;
        $check = $this->Hotels_model->hotel_exists($hotelname);
        if ($check && !empty($hotelname)) {
            $this->Hotels_lib->set_hotelid($hotelname);
            $this->data['module'] = $this->Hotels_lib->hotel_details();
            $this->data['hasRooms'] = $this->Hotels_lib->totalRooms($this->data['module']->id);
            $this->data['rooms'] = $this->Hotels_lib->hotel_rooms($this->data['module']->id);
            $this->data['from1'] = date("F Y");
            $this->data['to1'] = date("F Y", strtotime('+5 months'));
            $this->data['from2'] = date("F Y", strtotime('+6 months'));
            $this->data['to2'] = date("F Y", strtotime('+11 months'));
            $this->data['from3'] = date("F Y", strtotime('+12 months'));
            $this->data['to3'] = date("F Y", strtotime('+17 months'));
            $this->data['from4'] = date("F Y", strtotime('+18 months'));
            $this->data['to4'] = date("F Y", strtotime('+23 months'));
            $this->data['first'] = date("m") . "," . date("Y");
            $this->data['second'] = date("m", strtotime('+6 months')) . "," . date("Y", strtotime('+6 months'));
            $this->data['third'] = date("m", strtotime('+12 months')) . "," . date("Y", strtotime('+12 months'));
            $this->data['fourth'] = date("m", strtotime('+18 months')) . "," . date("Y", strtotime('+18 months'));
            // End Availability Calender settings variables
            $this->data['tripadvisorinfo'] = tripAdvisorInfo($this->data['module']->tripadvisorid);
            if (!empty($this->data['tripadvisorinfo']->rating)) {
                $tripAdvisorReviews = $this->Hotels_lib->tripAdvisorData($this->data['module']->tripadvisorid, $this->data['tripadvisorinfo']);
                $this->data['reviews'] = $tripAdvisorReviews->reviews;
            } else {
                $this->data['reviews'] = $this->Hotels_lib->hotelReviews($this->data['module']->id);
                $this->data['avgReviews'] = $this->Hotels_lib->hotelReviewsAvg($this->data['module']->id);
            }
            $this->data['checkinMonth'] = strtoupper(date("F", convert_to_unix($this->Hotels_lib->checkin)));
            $this->data['checkinDay'] = date("d", convert_to_unix($this->Hotels_lib->checkin));
            $this->data['checkoutMonth'] = strtoupper(date("F", convert_to_unix($this->Hotels_lib->checkout)));
            $this->data['checkoutDay'] = date("d", convert_to_unix($this->Hotels_lib->checkout));
            // Split date for new date desing on hotel single page
            $checkin = explode("/", $this->Hotels_lib->checkin);
            $this->data['d1first'] = $checkin[0];
            $this->data['d1second'] = $checkin[1];
            $this->data['d1third'] = $checkin[2];
            $checkout = explode("/", $this->Hotels_lib->checkout);
            $this->data['d2first'] = $checkout[0];
            $this->data['d2second'] = $checkout[1];
            $this->data['d2third'] = $checkout[2];
            $this->data['checkin'] = $this->Hotels_lib->checkin;
            $this->data['checkout'] = $this->Hotels_lib->checkout;
            // end Split date for new date desing on hotel single page
            $this->lang->load("front", $this->data['lang_set']);
            $datetime1 = new DateTime($this->data['checkin']);
            $datetime2 = new DateTime($this->data['checkout']);
            $interval = $datetime1->diff($datetime2)->format('%a');
            $this->data['totalStay'] = $interval;
            $this->data['modulelib']->stay = $this->data['totalStay'];
            $this->data['adults'] = (empty($adults)) ? $this->Hotels_lib->adults : $adults;
            $this->data['child'] = (empty($childs)) ? (int) $this->Hotels_lib->children : $childs;
            $this->data['currencySign'] = $this->Hotels_lib->currencysign;
            $this->data['lowestPrice'] = $this->Hotels_lib->bestPrice($this->data['module']->id);
            $this->data['langurl'] = base_url() . "hotels/{langid}/" . $this->data['module']->slug;
            $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);
            $this->data['city'] = $city;
            $this->data['checkin'] = (!empty($searchform_checkin)) ? $searchform_checkin : $this->data['checkin'];
            $this->data['checkin'] = str_replace('-', '/', $this->data['checkin']);
            $this->data['checkout'] = (!empty($searchform_checkout)) ? $searchform_checkout : $this->data['checkout'];
            $this->data['checkout'] = str_replace('-', '/', $this->data['checkout']);
            $this->data['hotelname'] = $hotelname;
            $this->data['city'] = $city;
            $this->theme->view('modules/hotels/details', $this->data, $this);
        } else {
            $this->listing();
        }
    }

    public function index($hotelname = '', $html = false) {

        $city = $this->uri->segment(3);

        $searchform_checkin = $this->uri->segment(5);
        $searchform_checkout = $this->uri->segment(6);


        $this->load->library('Hotels/Hotels_calendar_lib');
        $this->data['loadMap'] = true;
        $this->data['calendar'] = $this->Hotels_calendar_lib;
        $settings = $this->Settings_model->get_front_settings('hotels');
        $this->data['minprice'] = $settings[0]->front_search_min_price;
        $this->data['maxprice'] = $settings[0]->front_search_max_price;
        $this->data['checkin'] = $searchform_checkin;
        $this->data['checkout'] = $searchform_checkout;
        if (empty($hotelname)) {
            if ($this->validlang) {
                //$countryName = $this->uri->segment(3);

                //$cityName = $this->uri->segment(4);

                $hotelname = $this->uri->segment(5);
            } else {

                // $countryName = $this->uri->segment(2);

                // $cityName = $this->uri->segment(3);

                $hotelname = $this->uri->segment(4);
            }
        }

        $check = $this->Hotels_model->hotel_exists($hotelname);
        if ($check && !empty($hotelname)) {
            $this->Hotels_lib->set_hotelid($hotelname);
            $this->data['module'] = $this->Hotels_lib->hotel_details();
            $this->data['hasRooms'] = $this->Hotels_lib->totalRooms($this->data['module']->id);
            $this->data['rooms'] = $this->Hotels_lib->hotel_rooms($this->data['module']->id, $this->data['checkin'], $this->data['checkout']);
            // Availability Calender settings variables
            $this->data['from1'] = date("F Y");
            $this->data['to1'] = date("F Y", strtotime('+5 months'));
            $this->data['from2'] = date("F Y", strtotime('+6 months'));
            $this->data['to2'] = date("F Y", strtotime('+11 months'));
            $this->data['from3'] = date("F Y", strtotime('+12 months'));
            $this->data['to3'] = date("F Y", strtotime('+17 months'));
            $this->data['from4'] = date("F Y", strtotime('+18 months'));
            $this->data['to4'] = date("F Y", strtotime('+23 months'));
            $this->data['first'] = date("m") . "," . date("Y");
            $this->data['second'] = date("m", strtotime('+6 months')) . "," . date("Y", strtotime('+6 months'));
            $this->data['third'] = date("m", strtotime('+12 months')) . "," . date("Y", strtotime('+12 months'));
            $this->data['fourth'] = date("m", strtotime('+18 months')) . "," . date("Y", strtotime('+18 months'));

            // End Availability Calender settings variables

            $this->data['tripadvisorinfo'] = tripAdvisorInfo($this->data['module']->tripadvisorid);
            if (!empty($this->data['tripadvisorinfo']->rating)) {
                $tripAdvisorReviews = $this->Hotels_lib->tripAdvisorData($this->data['module']->tripadvisorid, $this->data['tripadvisorinfo']);
                $this->data['reviews'] = $tripAdvisorReviews->reviews;
            } else {
                $this->data['reviews'] = $this->Hotels_lib->hotelReviews($this->data['module']->id);
                $this->data['avgReviews'] = $this->Hotels_lib->hotelReviewsAvg($this->data['module']->id);
            }

            $this->data['checkinMonth'] = strtoupper(date("F", convert_to_unix($this->Hotels_lib->checkin)));
            $this->data['checkinDay'] = date("d", convert_to_unix($this->Hotels_lib->checkin));
            $this->data['checkoutMonth'] = strtoupper(date("F", convert_to_unix($this->Hotels_lib->checkout)));
            $this->data['checkoutDay'] = date("d", convert_to_unix($this->Hotels_lib->checkout));
            // Split date for new date desing on hotel single page
            $checkin = explode("/", $this->Hotels_lib->checkin);
            $this->data['d1first'] = $checkin[0];
            $this->data['d1second'] = $checkin[1];
            $this->data['d1third'] = $checkin[2];
            $checkout = explode("/", $this->Hotels_lib->checkout);
            $this->data['d2first'] = $checkout[0];
            $this->data['d2second'] = $checkout[1];
            $this->data['d2third'] = $checkout[2];
            $this->data['checkin'] = $this->Hotels_lib->checkin;
            $this->data['checkout'] = $this->Hotels_lib->checkout;
            // end Split date for new date desing on hotel single page
            $this->lang->load("front", $this->data['lang_set']);
            $this->data['totalStay'] = $this->Hotels_lib->stay;
            $this->data['adults'] = $this->Hotels_lib->adults;
            $this->data['child'] = (int) $this->Hotels_lib->children;
            $this->data['currencySign'] = $this->Hotels_lib->currencysign;
            $this->data['lowestPrice'] = $this->Hotels_lib->bestPrice($this->data['module']->id);
            $this->data['langurl'] = base_url() . "hotels/{langid}/" . $this->data['module']->slug;
            $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);
            $this->data['city'] = $city;
            $this->data['checkin'] = (!empty($searchform_checkin)) ? $searchform_checkin : $this->data['checkin'];
            $this->data['checkout'] = (!empty($searchform_checkout)) ? $searchform_checkout : $this->data['checkout'];

            if ($html)
            {
                return $this->theme->view('modules/hotels/details', $this->data, $this, true);
            } else {

                $this->theme->view('modules/hotels/details', $this->data, $this);
            }
        } else {
        //$this->listing();
        $this->load->model('Hotels/HotelsSearchModel');
        $searchForm = new HotelsSearchModel();
        $this->data['searchFormhotels'] = $searchForm;
        $this->data['featuredHotels'] = $this->Hotels_lib->getFeaturedHotels();
        $this->lang->load("front", $this->data['lang_set']);
        $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);
        $this->theme->view('modules/hotels/index', $this->data, $this);
        }
    }

    public function listing($page = 1) {

        // Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('hotels/listing');
        $config['total_rows'] = $this->db->get('pt_hotels')->num_rows();
        $config['per_page'] = $this->hotelSettings->front_listings;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = "<ul class='pagination justify-content-center justify-content-lg-left'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $limit = $config['per_page'];
        $offset = ($page - 1) * $limit;
        $country = 'NULL';
        $city = 'NULL';
        $this->data['module'] = $this->Hotels_model->getAllHotels($limit, $offset);
        $this->lang->load("front", $this->data['lang_set']);
        $this->data['amenities'] = $this->Hotels_lib->getHotelAmenities();
        $this->data['moduleTypes'] = $this->Hotels_lib->getHotelTypes();
        $settings = $this->Settings_model->get_front_settings('hotels');
        $this->data['minprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_min_price);
        $this->data['maxprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_max_price);
        $this->data['currCode'] = $this->Hotels_lib->currencycode;
        $this->data['currSign'] = $this->Hotels_lib->currencysign;
        $this->data['langurl'] = base_url() . "hotels/{langid}";
        $this->data['country'] = $country;
        $this->data['city'] = $city;
        $checkin = str_replace('/', '-', $_SESSION['hotel_checkin']);
        $checkout = str_replace('/', '-', $_SESSION['hotel_checkout']);
        $this->data['uri'] = base_url('hotels/search');
        $this->data['detailpage_uri'] = base_url('hotels/detail/%s/%s');
        // Load view
        $this->setMetaData('Search Results', "Hotel listings");
        $this->theme->view('modules/hotels/listing', $this->data, $this);
    }

    public function _listing($offset = null) {

        $this->data['loadMap'] = true;

        $this->lang->load("front", $this->data['lang_set']);

        $this->data['sorturl'] = base_url() . 'hotels/listings?';

        $settings = $this->Settings_model->get_front_settings('hotels');

        $this->data['minprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_min_price);

        $this->data['maxprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_max_price);

        //$this->data['popular_hotels'] = $this->Hotels_model->popular_hotels_front();

        $allhotels = $this->Hotels_lib->show_hotels($offset);

        $this->data['moduleTypes'] = $this->Hotels_lib->getHotelTypes();

        $this->data['amenities'] = $this->Hotels_lib->getHotelAmenities();

        $this->data['checkin'] = @$_GET['checkin'];

        $this->data['checkout'] = @$_GET['checkout'];

        if (empty($checkin)) {
            $this->data['checkin'] = $this->Hotels_lib->checkin;
        }

        if (empty($checkout)) {
            $this->data['checkout'] = $this->Hotels_lib->checkout;
        }

        $chin = $this->Hotels_lib->checkin;

        $chout = $this->Hotels_lib->checkout;

        if (empty($chin) || empty($chout)) {
            $this->data['pricehead'] = trans('0396');
        } else {

            $this->data['pricehead'] = trans('0397') . " " . $this->Hotels_lib->stay . " " . trans('0122');
        }

        $this->data['totalStay'] = $this->Hotels_lib->stay;

        $this->data['adults'] = $this->Hotels_lib->adults;

        $this->data['child'] = (int) $this->Hotels_lib->children;

        $this->data['selectedLocation'] = $this->Hotels_lib->selectedLocation;

        $this->data['module'] = $allhotels['all_hotels'];

        $this->data['info'] = $allhotels['paginationinfo'];

        $this->data['currCode'] = $this->Hotels_lib->currencycode;

        $this->data['currSign'] = $this->Hotels_lib->currencysign;

        $this->data['langurl'] = base_url() . "hotels/{langid}";

        $this->setMetaData($settings[0]->header_title, $settings[0]->meta_description, $settings[0]->meta_keywords);

        $this->theme->view('modules/hotels/listing', $this->data, $this);
    }

    public function list() {
    $this->lang->load("front", $this->data['lang_set']);
    $url = explode('/',  $this->uri->uri_string());
    $count = count($url);
 //   if ($count < 8) { echo "less than 8"; }

//    define('lang', $url[0]);
//    $currceny = $url[1];
    $country = $url[2];
    $city = $url[3];
    $checkin = $url[4];
    $checkout = $url[5];
    $adults = $url[6];
    $childs = $url[7];

 //   echo $country;
 //   echo $city;
 //   echo $checkin;
 //   echo $checkout;
 //   echo $adults;
 //   echo $childs;


  // dd ($url);


    $this->theme->view('modules/hotels/list', $this->data, $this);
    }


    public function search(...$args) {
        ini_set('display_errors', 1);

        $this->data['loadMap'] = true;
        $country = "NULL";

        $city = "NULL";

        $priceRange = 0;
        $stars = 0;
        $propertyTypes = "";
        $amenities = "";

        $this->load->model('Hotels/Hotels_model');
        $this->load->model('Hotels/HotelsSearchModel');

        $args = explode('/',  $this->uri->uri_string());
        unset($args[0]);
        unset($args[1]);
        $segments = array_merge($args);
        $searchForm = new HotelsSearchModel();
        $searchForm->parseUriString($segments);
        $this->session->set_userdata('Hotels',serialize($searchForm));

        $fswitch = true;

        // Pagination
        $this->load->library('pagination');
        $config['per_page'] = $this->hotelSettings->front_listings;
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        if (count($args) == 6 || count($args) == 7 || count($args) == 8) {
            $country = $args[2];
            $city = $args[3];
            $checkin = $args[4];
            $checkout = $args[5];
            $adults = $args[6];
            $childs = $args[7];


            //list($country, $city, $checkin, $checkout, $adults, $childs) = $args;

            $select2 = array(

                "id" => $country . '/' . $city,

                "text" => ucwords($city) . ', ' . ucwords(str_replace('-', ' ', $country)),

                "type" => 'location'

            );
            $config['uri_segment'] = 9;
            $limit = $config['per_page'];
            $page = (!isset($args[6])) ? 1 : $args[6];
            $offset = ($page - 1) * $limit;
            $config['base_url'] = base_url('hotels/search/' . $country . '/' . $city . '/' . $checkin . '/' . $checkout . '/' . $adults . '/' . $childs);
            $config['total_rows'] = count($this->Hotels_model->searchByLocation($city));
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $dataset = $this->Hotels_model->searchByLocation($city);
        } else if (count($args) == 5) {
            // Deprecated

            list($hotelname, $checkin, $checkout, $adults, $childs) = $args;

            $select2 = array(

                "id" => $hotelname,

                "text" => ucwords(str_replace('-', ' ', $hotelname)),

                "type" => 'hotel'

            );

            $dataset = $this->Hotels_model->searchByHotelname($hotelname);
        } else if (count($args) == 4) { // filters if user came from header menus

            list($stars, $priceRange, $propertyTypes, $amenities) = $args;

            $dataset = $this->Hotels_model->getAllHotelsByFilter($args);

            $this->data['uri'] = base_url('hotels/search');

            $fswitch = false;
        } else {
            list($country, $city, $checkin, $checkout, $adults, $childs, $stars, $priceRange, $propertyTypes, $amenities) = $args;
            $dataset = $this->Hotels_model->searchByFilters($args);
        }


        $country = $args[2];
        $city = $args[3];
        $checkin = $args[4];
        $checkout = $args[5];
        $adults = $args[6];
        $childs = $args[7];
        $stars = $args[8];
        $priceRange = $args[9];
        $propertyTypes = $args[10];
        $amenities = $args[11];
        $sort = $args[12];
        $this->session->set_userdata(array(

            "hotel_select2" => $select2,

            "hotel_checkin" => str_replace('-', '/', $checkin),

            "hotel_checkout" => str_replace('-', '/', $checkout),

            "hotel_adults" => $adults,

            "hotel_child" => $childs,

            "custom_hotels_checkin" => $checkin,

            "custom_hotels_checkout" => $checkout

        ));

        $_SESSION['search_hotels_checkin'] = $checkin;
        $_SESSION['search_hotels_checkout'] = $checkout;

        $this->data['module'] = $dataset;

        $this->lang->load("front", $this->data['lang_set']);

        $this->data['amenities'] = $this->Hotels_lib->getHotelAmenities();

        $this->data['moduleTypes'] = $this->Hotels_lib->getHotelTypes();

        $settings = $this->Settings_model->get_front_settings('hotels');

        $this->data['minprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_min_price);

        $this->data['maxprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_max_price);

        $this->data['currCode'] = $this->Hotels_lib->currencycode;

        $this->data['currSign'] = $this->Hotels_lib->currencysign;

        $this->data['langurl'] = base_url() . "hotels/{langid}";

        $this->data['country'] = $country;

        $this->data['city'] = $city;
        $this->data['sort'] = $sort;

        $this->data['priceRange'] = $priceRange;

        $this->data['starsCount'] = $stars;

        $this->data['fpropertyTypes'] = $propertyTypes;

        $this->data['famenities'] = $amenities;

        if ($fswitch) {
            $this->data['uri'] = base_url('hotels/search/' . $country . '/' . $city . '/' . $checkin . '/' . $checkout . '/' . $adults . '/' . $childs);
        }
        $this->data['detailpage_uri'] = base_url('hotels/detail/%s/%s/' . $checkin . '/' . $checkout . '/' . $adults . '/' . $childs);
        $this->setMetaData('Search Results', $country . " " . $city, $country . " " . $city);

        $this->data['searchFormhotels'] = $searchForm;
        $this->theme->view('modules/hotels/listing', $this->data, $this);
    }

    public function _search($country = null, $city = null, $citycode = null, $offset = null) {

        $this->session->set_userdata(array(
            "hotel_s2_id" => $citycode,
            "hotel_s2_text" => $this->input->get('txtSearch'),
            "hotel_checkin" => $this->input->get('checkin'),
            "hotel_checkout" => $this->input->get('checkout'),
            "hotel_adults" => $this->input->get('adults'),
            "hotel_child" => $this->input->get('child'),
            "hotel_mod_type" => $this->input->get('modType')
        ));

        $this->data['loadMap'] = true;

        $surl = http_build_query($_GET);

        $this->data['sorturl'] = base_url() . 'hotels/search?' . $surl . '&';

        $checkin = $this->input->get('checkin');

        $checkout = $this->input->get('checkout');

        $type = $this->input->get('type');

        $cityid = $this->input->get('searching');

        $modType = $this->input->get('modType');

        if (empty($country)) {
            $surl = http_build_query($_GET);

            $locationInfo = pt_LocationsInfo($cityid);

            $country = url_title($locationInfo->country, 'dash', true);

            $city = url_title($locationInfo->city, 'dash', true);

            $cityid = $locationInfo->id;

            if (!empty($cityid) && $modType == "location") {
                redirect('hotels/search/' . $country . '/' . $city . '/' . $cityid . '?' . $surl);
            } else {

                if (!empty($cityid) && $modType == "hotel") {
                    $this->Hotels_lib->set_id($cityid);

                    $this->Hotels_lib->hotel_short_details();

                    $title = $this->Hotels_lib->title;

                    $slug = $this->Hotels_lib->slug;

                    if (!empty($title)) {
                        redirect('hotels/' . $slug);
                    }
                }
            }
        } else {

            if ($modType == "location") {
                $cityid = $citycode;
            } else {

                $cityid = "";
            }

            if (is_numeric($country)) {
                $offset = $country;
            }
        }

        if (array_filter($_GET)) {
            if (!empty($cityid) && $modType == "location") {
                $allhotels = $this->Hotels_lib->search_hotels_by_text($cityid, $offset);
            } else {

                $allhotels = $this->Hotels_lib->search_hotels($offset);
            }

            $this->data['module'] = $allhotels['all'];

            $this->data['info'] = $allhotels['paginationinfo'];
        } else {

            $this->data['module'] = array();
        }

        $this->data['checkin'] = @$_GET['checkin'];

        $this->data['checkout'] = @$_GET['checkout'];

        if (empty($checkin)) {
            $this->data['checkin'] = $this->Hotels_lib->checkin;
        }

        if (empty($checkout)) {
            $this->data['checkout'] = $this->Hotels_lib->checkout;
        }

        $chin = $this->Hotels_lib->checkin;

        $chout = $this->Hotels_lib->checkout;

        if (empty($chin) || empty($chout)) {
            $this->data['pricehead'] = trans('0396');
        } else {

            $this->data['pricehead'] = trans('0397') . " " . $this->Hotels_lib->stay . " " . trans('0122');
        }

        $this->data['city'] = $cityid;

        $this->lang->load("front", $this->data['lang_set']);

        $this->data['selectedLocation'] = $cityid; //$this->Hotels_lib->selectedLocation;

        $this->data['totalStay'] = $this->Hotels_lib->stay;

        $this->data['adults'] = $this->Hotels_lib->adults;

        $this->data['child'] = (int) $this->Hotels_lib->children;

        $this->data['searchText'] = $this->input->get('txtSearch');

        $settings = $this->Settings_model->get_front_settings('hotels');

        $this->data['amenities'] = $this->Hotels_lib->getHotelAmenities();

        $this->data['moduleTypes'] = $this->Hotels_lib->getHotelTypes();

        $this->data['minprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_min_price);

        $this->data['maxprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_max_price);

        $this->data['currCode'] = $this->Hotels_lib->currencycode;

        $this->data['currSign'] = $this->Hotels_lib->currencysign;

        $this->data['langurl'] = base_url() . "hotels/{langid}";

        $this->setMetaData('Search Results', @$country . " " . @$city, @$country . " " . @$city);

        $this->theme->view('modules/hotels/listing', $this->data, $this);
    }

    public function book($hotelname) {

        $this->load->model('Admin/Countries_model');

        $this->data['allcountries'] = $this->Countries_model->get_all_countries();

        $check = $this->Hotels_model->hotel_exists($hotelname);

        $this->load->library("Paymentgateways");

        $this->data['hideHeader'] = "1";

        if ($check && !empty($hotelname)) {
            $this->load->model('Admin/Payments_model');

            $this->data['error'] = "";

            $this->Hotels_lib->set_hotelid($hotelname);

            $hotelID = $this->Hotels_lib->get_id();

            $roomID = $this->input->get('roomid');
            $rooms = $this->input->get('rooms');
            $roomsCount = $this->input->get('roomscount');
            $extrabeds = $this->input->get('extrabeds');

            $this->data['rooms'] = array();
            $this->data['module'] = array();
            $this->data['subitemid'] = array();
            $this->data['roomscount'] = array();
            $this->data['bedscount'] = array();
            $this->data['extrabedcharges'] = 0;
            $this->load->library('currconverter');

            foreach ($rooms as $index => $roomID) {
                $bookInfo = $this->Hotels_lib->getBookResultObject($hotelID, $roomID, $roomsCount[$roomID], $extrabeds[$roomID]);
                array_push($this->data['module'], $bookInfo['hotel']);
                $this->data['module'] = $bookInfo['hotel'];

                $this->data['extraChkUrl'] = $bookInfo['hotel']->extraChkUrl;

                $room = $bookInfo['room'];

                if ($room->price < 1 || $room->stay < 1) {
                    $this->data['error'] = "error";
                }

                $this->data['module_adults'] += $bookInfo['hotel']->adults;
                $this->data['currSymbol'] = $room->currSymbol;
                $this->data['currCode'] = $room->currCode;

                // $taxAmount = $this->currconverter->removeComma($bookInfo['hotel']->taxAmount);
                // $this->data['taxAmount'] += $taxAmount;
                // $depositAmount = $this->currconverter->removeComma($bookInfo['hotel']->depositAmount);
                // $this->data['depositAmount'] += $depositAmount;

                $price = $this->currconverter->removeComma($room->price);
                $this->data['price'] += $price;

                array_push($this->data['rooms'], $room);
                array_push($this->data['subitemid'], $roomID);
                array_push($this->data['roomscount'], $roomsCount[$roomID]);
                // array_push($this->data['bedscount'], $extrabeds[$roomID]);
                $extrabedcharges = $this->currconverter->removeComma($room->extraBedCharges);
                $this->data['extrabedcharges'] += $extrabedcharges;
            }
            $this->data['bedscount'] = json_encode($extrabeds);
            $this->Hotels_lib->setTax($this->data['price']);
            $this->data['taxAmount'] = $this->currconverter->convertPrice($this->Hotels_lib->taxamount);
            $this->Hotels_lib->setDeposit($this->data['price']);
            $this->data['depositAmount'] = $this->currconverter->convertPrice($this->Hotels_lib->deposit);
            $this->load->library('Hotels/Hotels_lib');
            $this->Hotels_lib->setDeposit($this->data['price']);
            $this->data['depositAmount'] = $this->Hotels_lib->deposit;
            $this->data['price'] += $this->Hotels_lib->taxamount;

            $this->load->model('Admin/Accounts_model');

            $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer');

            $this->lang->load("front", $this->data['lang_set']);

            $this->data['profile'] = $this->Accounts_model->get_profile_details($loggedin);
            $this->data['stay'] = pt_count_days($this->data['module']->checkin, $this->data['module']->checkout);

            $this->setMetaData($this->data['module']->title, $this->data['module']->metadesc, $this->data['module']->keywords);
            $this->theme->view('modules/hotels/standard/booking', $this->data, $this);
        } else {

            redirect("hotels");
        }
    }

    public function txtsearch() {

        echo $this->Hotels_model->textsearch();
    }

    public function roomcalendar() {

        $this->lang->load("front", $this->data['lang_set']);

        $this->load->library('Hotels/Hotels_calendar_lib');

        $this->data['calendar'] = $this->Hotels_calendar_lib;

        $this->data['roomid'] = $this->input->post('roomid');

        $monthYear = explode(",", $this->input->post('monthyear'));

        $this->data['initialmonth'] = $monthYear[0];

        $this->data['year'] = $monthYear[1];

        $this->load->view('calendar', $this->data);
    }

    public function _remap($method, $params = array()) {

        $funcs = get_class_methods($this);

        if (in_array($method, $funcs)) {
            return call_user_func_array(array($this, $method), $params);
        } else {

            $result = checkUrlParams($method, $params, $this->validlang);

            if ($result->showIndex) {
                $this->index();
            } else {

                $this->lang->load("front", $this->data['lang_set']);

                $this->data['sorturl'] = base_url() . 'hotels/listings?';

                $settings = $this->Settings_model->get_front_settings('hotels');

                $this->data['minprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_min_price);

                $this->data['maxprice'] = $this->Hotels_lib->convertAmount($settings[0]->front_search_max_price);

                $allhotels = $this->Hotels_lib->showHotelsByLocation($result, $result->offset);

                $this->data['moduleTypes'] = $this->Hotels_lib->getHotelTypes();

                $this->data['amenities'] = $this->Hotels_lib->getHotelAmenities();

                $this->data['checkin'] = @$_GET['checkin'];

                $this->data['checkout'] = @$_GET['checkout'];

                if (empty($checkin)) {
                    $this->data['checkin'] = $this->Hotels_lib->checkin;
                }

                if (empty($checkout)) {
                    $this->data['checkout'] = $this->Hotels_lib->checkout;
                }

                $chin = $this->Hotels_lib->checkin;

                $chout = $this->Hotels_lib->checkout;

                if (empty($chin) || empty($chout)) {
                    $this->data['pricehead'] = trans('0396');
                } else {

                    $this->data['pricehead'] = trans('0397') . " " . $this->Hotels_lib->stay . " " . trans('0122');
                }

                $this->data['selectedLocation'] = $this->Hotels_lib->selectedLocation;

                $this->data['module'] = $allhotels['all_hotels'];

                $this->data['info'] = $allhotels['paginationinfo'];

                $this->data['currCode'] = $this->Hotels_lib->currencycode;

                $this->data['currSign'] = $this->Hotels_lib->currencysign;

                $this->data['langurl'] = base_url() . "hotels/{langid}";

                $this->setMetaData($settings[0]->header_title, $settings[0]->meta_description, $settings[0]->meta_keywords);

                $this->theme->view('modules/hotels/listing', $this->data, $this);
            }
        }
    }

}
