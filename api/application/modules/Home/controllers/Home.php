<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends MX_Controller {  

    private $validlang;
    private $license = false;
    public $role;
    public function __construct() {
        parent::__construct();


        modules::load('Front');

        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $this->data['usersession'] = $this->session->userdata('pt_logged_customer');

        $pageslugg = $this->uri->segment(1);

        $this->validlang = pt_isValid_language($pageslugg);

        if ($this->validlang) {
            $this->data['lang_set'] = $pageslugg;
        } else {

            $this->data['lang_set'] = $this->session->userdata('set_lang');
        }

        $defaultlang = pt_get_default_language();


        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }

        $this->data['eancheckin'] = date("m/d/Y", strtotime("+1 days"));

        $this->data['eancheckout'] = date("m/d/Y", strtotime("+2 days"));

        $this->data['ctcheckin'] = date("m/d/Y", strtotime("+1 days"));

        $this->data['ctcheckout'] = date("m/d/Y", strtotime("+2 days"));

        $this->load->model('Admin/Countries_model');
        $ci = get_instance();
        $version = implode("=>",(array)$ci->db->query('SELECT VERSION()')->result()[0]);

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


       


    }


   
    public function license() {
        $appSetting = $this->db->get('pt_app_settings')->row();
        $this->load->view('license', compact('appSetting'));
    }

    public function phpinfo() {
        echo phpinfo();
        echo phpinfo(INFO_MODULES);
    }



    public function index()
    {

        require_once(APPPATH.'modules/Admin/controllers/System.php');
        $oHome =  new System();
        $license = $oHome->checksystem();
        $whitelist = array('127.0.0.1', '::1');
        if ($license || in_array($_SERVER['REMOTE_ADDR'], $whitelist) || $_SERVER['HTTP_HOST'] == "server") {

            $appSetting = $this->App->service('AppSettingService');
            $spaSettings = $appSetting->getSpaSettings();
            if (!empty($spaSettings) && $spaSettings->spa_status == 'enable') {
                $slug = str_replace(' ', '-', $spaSettings->spa_homepage);

                $html = modules::run($spaSettings->spa_module, $slug, true);

                if (!empty($html)) {
                    echo $html;
                    return;
                }
            }
            /*$this->output->cache(60*12);*/
            /*$this->output->enable_profiler(TRUE);*/
            $this->load->database(); // init db connection, already in code
            $this->db->save_queries = false; // ADD THIS LINE TO SOLVE ISSUE
            $this->lang->load("front", $this->data['lang_set']);
            $pageslug = $this->uri->segment(1);
            // for new menu
            if (strpos($pageslug, 'm-') !== false) {
                $pageslug = null;
            }
            $secondslug = $this->uri->segment(2);
            $langid = $this->session->userdata('set_lang');

            $currency_session = $this->session->userdata('currencycode');
            if (empty($currency_session)) {
                $this->defaultcurrencyset();
            }

            $defaultlang = pt_get_default_language();
            if (empty($langid)) {
                $langid = $defaultlang;
            }
            if ($this->validlang) {
                $pageslug = $this->uri->segment(2);
            }
            $this->load->model('Admin/Cms_model');
            $check = $this->Cms_model->check($pageslug);

            if ($pageslug == null || $pageslug == "home" || $this->validlang && empty($secondslug)) {
                $this->load->model('Admin/Special_offers_model');
                $activeModules = array();

//            foreach ($this->data['modulesname'] as $modules)
//            {
//                if($modules["foldername"] == "flights")
//                {
//                    $this->load->model($modules["module_name"].'/SearchModel');
//                    $searchmodel = new SearchModel();
//                    $this->data['search'] = $searchmodel;
//                }
//
//            }

                if (isModuleActive('hotels')) {
                    $activeModules[] = "hotels";
                    $this->load->library('Hotels/Hotels_lib');
                    $this->data['hotelslib'] = $this->Hotels_lib;
                    $this->load->helper("Hotels/hotels");
                    $this->load->model('Hotels/Hotels_model');
                    $this->load->model('Hotels/VariablesModel');
                    $this->data['totalStay'] = $this->Hotels_lib->stay;
                    $this->data['adults'] = $this->Hotels_lib->adults;
                    $this->data['child'] = (int)$this->Hotels_lib->children;
                    //  $this->data['latest_hotels'] = $this->Hotels_model->latest_hotels_front();
                    $this->data['hotelslocationsList'] = $this->Hotels_lib->getLocationsList();
                    $this->data['featuredHotels'] = $this->Hotels_lib->getFeaturedHotels();
                    $this->data['popularHotels'] = $this->Hotels_lib->getTopRatedHotels();
                    //  $this->data['hero_hotels'] = $this->Hotels_lib->hero_hotels_list();
                    //  $this->data['mini_hero_hotels'] = $this->Hotels_lib->mini_hero_hotels_list();
                    $hotelsmodel = new VariablesModel();
                    $this->data['searchFormhotels'] = $hotelsmodel;
                    $this->data['featuredSection']['modules']["hotels"] = (object)array("featured" => $this->data['featuredHotels'], 'moduleTitle' => trans('Hotels'), 'bgImg' => 'featured-hotels.jpg', 'booknowClass' => 'primary', 'featuredText' => trans('056'), 'featuredPrice' => 75, 'currCode' => 'USD');
                }

                if (isModuleActive('tours')) {
                    $activeModules[] = "tours";
                    $this->load->library('Tours/Tours_lib');
                    $this->data['tourslib'] = $this->Tours_lib;
                    $this->data['locationsList'] = $this->Tours_lib->getLocationsList();
                    $this->data['featuredTours'] = $this->Tours_lib->getFeaturedTours();
                    // $this->data['countryFeaturedTours'] = $this->Tours_lib->getCountryFeaturedTours();
                    $this->data['popularTours'] = $this->Tours_lib->getTopRatedTours();
                    $this->data['moduleTypes'] = $this->Tours_lib->tourTypes();
                    $this->data['checkin'] = $this->Tours_lib->date;
                    $this->data['adults'] = $this->Tours_lib->adults;
                    $this->data['child'] = (int)$this->Tours_lib->child;
                    $this->data['featuredSection']['modules']["tours"] = (object)array("featured" => $this->Tours_lib->getFeaturedTours(), 'moduleTitle' => trans('Tours'), 'bgImg' => 'featured-tours.jpg', 'booknowClass' => 'warning', 'featuredText' => trans('0451'), 'featuredPrice' => 200, 'currCode' => 'USD');
                    $this->data['tourLocations'] = $this->Tours_lib->toursByLocations();
                    $args = $this->session->userdata('tourseach');
                    $this->load->library('Tours/TourSearchForm');
                    $searchForm = new TourSearchForm();
                    if (!empty($args)) {
                        $searchForm->parseUriString($args);
                    }
                    $this->data['ToursSearchForm'] = $searchForm;
                    // default search field data list.
                    $this->data['defaultToursListForSearchField'] = $this->Tours_lib->getDefaultToursListForSearchField();
                    $this->load->helper("Tours/tours_front");
                    $this->load->model('Tours/Tours_model');
                }


                if (isModuleActive('rentals')) {
                    $activeModules[] = "rentals";

                    $this->load->library('Rentals/Rentals_lib');
                    $this->data['rentalslib'] = $this->Rentals_lib;
                    $this->data['locationsList'] = $this->Rentals_lib->getLocationsList();
                    $this->data['featuredRentals'] = $this->Rentals_lib->getFeaturedRentals();
                    // $this->data['countryFeaturedTours'] = $this->Tours_lib->getCountryFeaturedTours();
                    $this->data['popularRentals'] = $this->Rentals_lib->getTopRatedRentals();
                    $this->data['moduleTypes'] = $this->Rentals_lib->rentalTypes();
                    $this->data['checkin'] = $this->Rentals_lib->date;
                    $this->data['adults'] = $this->Rentals_lib->adults;
                    $this->data['child'] = (int)$this->Rentals_lib->child;
                    $this->data['featuredSection']['modules']["rentals"] = (object)array("featured" => $this->Rentals_lib->getFeaturedRentals(), 'moduleTitle' => trans('rental'), 'bgImg' => 'featured-tours.jpg', 'booknowClass' => 'warning', 'featuredText' => trans('0451'), 'featuredPrice' => 200, 'currCode' => 'USD');
                    $this->data['rentalLocations'] = $this->Rentals_lib->rentalsByLocations();
                    $args = $this->session->userdata('rentalseach');
                    $this->load->library('Rentals/RentalSearchForm');
                    $searchForm = new RentalSearchForm();
                    if (!empty($args)) {
                        $searchForm->parseUriString($args);
                    }
                    $this->data['RentalsSearchForm'] = $searchForm;
                    // default search field data list.
                    $this->data['defaultRentalsListForSearchField'] = $this->Rentals_lib->getDefaultRentalsListForSearchField();
                    $this->load->helper("Rentals/rentals_front");
                    $this->load->model('Rentals/Rentals_model');
                }

                if (isModuleActive('boats')) {
                    $activeModules[] = "boats";

                    $this->load->library('Boats/Boats_lib');
                    $this->data['boatslib'] = $this->Boats_lib;
                    $this->data['locationsList'] = $this->Boats_lib->getLocationsList();
                    $this->data['featuredBoats'] = $this->Boats_lib->getFeaturedBoats();
                    // $this->data['countryFeaturedTours'] = $this->Tours_lib->getCountryFeaturedTours();
                    $this->data['popularBoats'] = $this->Boats_lib->getTopRatedBoats();
                    $this->data['moduleTypes'] = $this->Boats_lib->boatTypes();
                    $this->data['checkin'] = $this->Boats_lib->date;
                    $this->data['adults'] = $this->Boats_lib->adults;
                    $this->data['child'] = (int)$this->Boats_lib->child;
                    $this->data['featuredSection']['modules']["boats"] = (object)array("featured" => $this->Boats_lib->getFeaturedBoats(), 'moduleTitle' => trans('boat'), 'bgImg' => 'featured-tours.jpg', 'booknowClass' => 'warning', 'featuredText' => trans('0451'), 'featuredPrice' => 200, 'currCode' => 'USD');
                    $this->data['boatLocations'] = $this->Boats_lib->boatsByLocations();
                    $args = $this->session->userdata('boatseach');
                    $this->load->library('Boats/BoatSearchForm');
                    $searchForm = new BoatSearchForm();
                    if (!empty($args)) {
                        $searchForm->parseUriString($args);
                    }
                    $this->data['BoatsSearchForm'] = $searchForm;
                    // default search field data list.
                    $this->data['defaultBoatsListForSearchField'] = $this->Boats_lib->getDefaultBoatsListForSearchField();
                    $this->load->helper("Boats/boats_front");
                    $this->load->model('Boats/Boats_model');
                }

                if (isModuleActive('Amadeus')) {
                    $moduleSetting = $this->App->service("ModuleService")->get("Amadeus");
                    $this->load->model('Amadeus/FlightsSearchModel');
                    $searchmodel = new FlightsSearchModel();
                    $this->data['AmadeusSearchForm'] = $searchmodel;
                    $this->data['amadeus_data'] = array(
                        'origin' => ($this->session->userdata('origin')) ? $this->session->userdata('origin') : "",
                        'destination' => ($this->session->userdata('origin')) ? $this->session->userdata('destination') : "",
                        'departureDate' => date('Y-m-d'),
                        'totalpassengers' => intval(1),
                        'madult' => intval(1),
                        'mchildren' => intval(0),
                        'minfant' => intval(0),
                        'seniors' => intval(0),
                        'class_type' => strtoupper('economy'),
                        'triptypename' => 'oneway',
                        'nonStop' => 'true',
                        'currency' => $this->session->userdata("currencycode"),
                        'currencysymbol' => $this->session->userdata("currencysymbol"),
                    );
                }

                if (isModuleActive('Juniper')) {
                    $moduleSetting = $this->App->service("ModuleService")->get("Juniper");
                    $params = $this->session->userdata('search_param');
                    $this->data['juniper_data'] = array(
                        'nationality' => (!empty($params['nationality'])) ? $params["nationality"] : "",
                        'checkin_date' => (!empty($params['checkin_date'])) ? $params["checkin_date"] : "",
                        'checkout_date' => (!empty($params['checkout_date'])) ? $params["checkout_date"] : "",
                        'city' => (!empty($params['city'])) ? $params["city"] : "",
                        'room_type' => (!empty($params['room_type'])) ? $params["room_type"] : "",
                        'room_required' => (!empty($params['room_required'])) ? $params["room_required"] : "",
                        'category' => (!empty($params['category'])) ? $params["category"] : "",
                        'stars' => (!empty($params['stars'])) ? $params["stars"] : ""
                    );
                }

                if (isModuleActive('Sabre')) {
                    $configurations = app()->service("ModuleService")->get('Sabre');
                    $origin = $this->session->userdata('sabre.origin');
                    $destination = $this->session->userdata('sabre.destination');
                    $tripType = $configurations->settings->tripType;
                    $classOfService = $configurations->settings->classOfService;

                    $this->load->library('Sabre/Model/SearchForm');
                    $searchForm = new SearchForm();
                    $searchForm->origin = $origin;
                    $searchForm->destination = $destination;
                    $searchForm->departure = date('Y-m-d', time());
                    if ($tripType == 'return') {
                        $searchForm->arrival = date('Y-m-d', strtotime('+1 day'));
                    }
                    $searchForm->tripType = $tripType;
                    $searchForm->classOfService = $classOfService;
                    $searchForm->passenger->adult = 1;
                    $searchForm->passenger->children = 0;
                    $searchForm->passenger->infant = 0;
                    $this->data['searchForm'] = $searchForm;
                }
                if (isModuleActive('TravelhopeFlights')) {
                    $args = $this->session->userdata('searchfilghtsQuery');
                    $this->load->library('TravelhopeFlights/Model/SearchForm');
                    $searchForm = new SearchForm();
                    if (!empty($args)) {
                        $searchForm->parseUriString($args);
                    }
                    $this->data['thfSearchForm'] = $searchForm;
                }
                if (isModuleActive('cars')) {
                    $activeModules[] = "cars";
                    $this->load->library('Cars/Cars_lib');
                    $this->data['carslib'] = $this->Cars_lib;
                    $this->data['carslocationsList'] = $this->Cars_lib->getLocationsList();
                    $this->data['carspickuplocationsList'] = $this->Cars_lib->getPickupLocationsList();
                    $this->data['carsdropofflocationsList'] = $this->Cars_lib->getDropLocationsList();
                    $this->data['featuredCars'] = $this->Cars_lib->getFeaturedCars();
                    $this->data['popularCars'] = $this->Cars_lib->getTopRatedCars();
                    $this->data['cartypes'] = $this->Cars_lib->carTypes();
                    $this->data['carModTiming'] = $this->Cars_lib->timingList();
                    $this->data['featuredSection']['modules']["cars"] = (object)array("featured" => $this->Cars_lib->getFeaturedCars(), 'moduleTitle' => trans('Cars'), 'bgImg' => 'featured-cars.jpg', 'booknowClass' => 'success', 'featuredText' => trans('0142'), 'featuredPrice' => 125, 'currCode' => 'USD');
                    $this->load->helper("Cars/cars_front");
                    $this->load->model('Cars/Cars_model');
                }

                if (isModuleActive('flights')) {
                    $activeModules[] = "flights";
                    $this->load->library('Flights/Flights_lib');
                    $this->data['flightslib'] = $this->Flights_lib;
                    $this->data['featuredFlights'] = $this->Flights_lib->getFeaturedFlights();
                }

                if (isModuleActive('hotelscombined')) {
                    $activeModules[] = "hotelscombined";
                    $this->load->model('Hotelscombined/Hotelscombined_model');
                    $settings = $this->Hotelscombined_model->get_front_settings();
                    $this->data['searchBoxID'] = $settings->searchBoxID;
                    $this->data['aid'] = $settings->aid;
                }

                $totalFeatured = count($this->data['featuredSection']['modules']);
                if ($totalFeatured == 1) {
                    $this->data['featuredSection']['divClass'] = "col-lg-12";
                } else if ($totalFeatured == 2) {
                    $this->data['featuredSection']['divClass'] = "col-md-6";
                } else {
                    $this->data['featuredSection']['divClass'] = "";
                }

                if (isModuleActive('blog')) {
                    $this->load->library('Blog/Blog_lib');
                    $this->data['bloglib'] = $this->Blog_lib;
                    $this->load->helper("Blog/blog_front");
                    $blog = $this->Blog_lib->latestPostsHomepage();
                    $this->data['posts'] = $blog->posts;
                    $settings = $this->Blog_lib->settings();
                    $this->data['showOnHomePage'] = $settings[0]->front_homepage_hero;
                }

                if (isModuleActive('Cartrawler')) {
                    $this->load->library('Cartrawler/Cartrawler_lib');

                    $this->data['timing'] = $this->Cartrawler_lib->timingList();
                }
                $dohopsettings = $this->Settings_model->get_front_settings("flightsdohop");
                $cartrawlersettings = $this->Settings_model->get_front_settings("cartrawler");
                $hotelsettings = $this->Settings_model->get_front_settings("hotels");
                $bookingsettings = $this->Settings_model->get_front_settings("booking");
                $this->data['topcities'] = explode(",", $hotelsettings[0]->front_top_cities);
                $this->data['offersenabled'] = $this->is_module_enabled('offers');
                if ($this->data['offersenabled']) {
                    $this->load->library('offers_lib');
                    $sOffers = $this->offers_lib->getHomePageOffers();
                    $this->data['specialoffers'] = $sOffers['offers'];
                    $this->data['offersCount'] = $sOffers['count'];
                }

                $activeModulesCount = count($activeModules);
                $divCol = 4;
                if ($activeModulesCount == 1) {
                    $divCol = 12;
                } elseif ($activeModulesCount == 2) {

                    $divCol = 6;
                } else {

                    $divCol = 4;
                }
                $this->data['divCol'] = $divCol;
                $this->data['checkin'] = date($this->data['app_settings'][0]->date_f, strtotime('+' . CHECKIN_SPAN . ' day', time()));
                $this->data['checkinMonth'] = strtoupper(date("F", strtotime('+' . CHECKIN_SPAN . ' day', time())));
                $this->data['checkinDay'] = date("d", strtotime('+' . CHECKIN_SPAN . ' day', time()));
                $this->data['checkout'] = date($this->data['app_settings'][0]->date_f, strtotime('+' . CHECKOUT_SPAN . ' day', time()));
                $this->data['checkoutMonth'] = strtoupper(date("F", strtotime('+' . CHECKOUT_SPAN . ' day', time())));
                $this->data['checkoutDay'] = date("d", strtotime('+' . CHECKOUT_SPAN . ' day', time()));
                $this->data['dohopusername'] = $dohopsettings[0]->cid;

                if (isModuleActive('Wegoflights')) {
                    $wegoSettings = $this->App->service('ModuleService')->get('Wegoflights');
                    $this->data['url'] = $wegoSettings->settings->url;
                }
                if (isModuleActive('ivisa')) {
                    $this->load->model('Ivisa/Ivisa_model');
                    //$ivisaSettings =  $this->Ivisa_model->get_front_settings();
                    $this->data['allcountries'] = $this->Countries_model->get_all_countries();
                    $country_name = $this->Ivisa_model->get_front_settings();
                    $this->data['countryname'] = $country_name->from;
                    $this->data['tocountry'] = $country_name->to;
                    $this->theme->view('modules/visa/search', $this->data, $this);
                }
                if (isModuleActive('travelpayouts')) {
                    $this->load->model('Travelpayouts/Travelpayouts_model');
                    $travelpayoutsSettings = $this->Travelpayouts_model->get_front_settings();
                    $this->data['WidgetURLFlight'] = $travelpayoutsSettings->WidgetURL;
                }
                if (isModuleActive('travelpayoutshotels')) {
                    $this->load->model('Travelpayoutshotels/Travelpayoutshotels_model');
                    $travelpayoutsSettings = $this->Travelpayoutshotels_model->get_front_settings();
                    $this->data['WidgetURLHotel'] = $travelpayoutsSettings->WidgetURL;
                }
                if (isModuleActive('travelport_flight')) {
                    // Load travelport model and populate search form with default values
                    $this->load->model('Travelport_flight/TravelportModel_Conf');
                    $travelportConfiguration = new TravelportModel_Conf();
                    $travelportConfiguration->load();
                    $this->data['travelportSearchFormData'] = array(
                        'searchQuery' => $this->session->userdata('searchQuery'),
                        'configuration' => $travelportConfiguration,
                        'requestType' => 'ajax'
                    );
                }
                if (isModuleActive('TravelhopeHotels')) {
                    $this->load->model('TravelhopeHotels/TravelhopeHotelsSearchForm');
                    $searchForm = new TravelhopeHotelsSearchForm();
                    $thhotelsSearchForm = $this->session->userdata("thhotelsSearchForm");
                    $searchForm->parseUriString($thhotelsSearchForm);
                    $this->data['searchForm'] = $searchForm;
                }
                if (isModuleActive('Kiwitaxi')) {
                    $this->data['searchForm'] = ["searchForm" => $this->session->userdata("ktaxilaoctform"), 'searchTo' => $this->session->userdata("ktaxilaoctto"), 'home' => !$is_home];
                }

                if (isModuleActive('Iwaystransfer')) {
                    $this->data['searchForm'] = ["searchForm" => $this->session->userdata("Iwaystransferlaoctform"), 'searchTo' => $this->session->userdata("Iwaystransferlaoctto"), 'home' => !$is_home];
                }
                $this->data['cartrawlerid'] = $cartrawlersettings[0]->cid;
                $this->data['affiliate'] = $bookingsettings[0]->cid;
                $this->data['ishome'] = "1";
                $this->data['sliderInfo'] = pt_get_main_slides();
                $this->data['main_content'] = 'index';
                $this->data['langurl'] = base_url() . "{langid}";
                $this->data['data'] = $this->data;
                $this->setMetaData();
                $this->theme->view('home/index', $this->data, $this);
            } elseif ($check) {
                $content = $this->Cms_model->get_page_content($pageslug, $langid);
                if (empty($content)) {
                    $content = $this->Cms_model->get_page_content($pageslug, '1');
                }
                $submitcontactform = $this->input->post('submit_contact');

                $this->data['res2'] = $this->Settings_model->get_contact_page_details();

                if (!empty($submitcontactform)) {
                    if (!empty($_POST['g-recaptcha-response'])) {
                        $captcha_response = htmlspecialchars($_POST['g-recaptcha-response']);
                        $recaptcha_site_secret = '6LdX3JoUAAAAAK6oiMNCnX7EGndE6nA0-dNv1HNv';
                        $curl = curl_init();
                        $captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";
                        curl_setopt($curl, CURLOPT_URL, $captcha_verify_url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=" . $recaptcha_site_secret . "&response=" . $captcha_response);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $captcha_output = curl_exec($curl);
                        curl_close($curl);
                        $decoded_captcha = json_decode($captcha_output, true);
                        if ($decoded_captcha['success'] == true) {
                            $this->form_validation->set_rules('contact_email', 'Email', 'trim|required|valid_email');
                            $this->form_validation->set_rules('contact_message', 'Message', 'trim|required');
                            if ($this->form_validation->run() == false) {
                                $this->data['validationerrors'] = validation_errors();
                            } else {
                                $this->load->model("Admin/Emails_model");
                                $senddata = array('contact_email' => $this->input->post('contact_email'), 'contact_name' => $this->input->post('contact_name'), 'contact_subject' => $this->input->post('contact_subject'), 'contact_message' => $this->input->post('contact_message'));
                                $this->Emails_model->send_contact_email($this->data['res2'][0]->contact_email, $senddata);
                                $this->data['successmsg'] = "Message Sent Successfully";
                            }
                        } else {
                            $this->data['validationerrors'] = "Recaptcha Verification Failed due to " . $decoded_captcha['error-codes'][0];
                        }
                    } else {
                        $this->data['validationerrors'] = "Please Verify Recaptcha";
                    }
                }

                $this->data['page_contents'] = $content;
                $this->data['main_content'] = 'cms/page-data';
                $this->setMetaData($content[0]->content_page_title, $content[0]->content_meta_desc, $content[0]->content_meta_keywords);
                $this->data['langurl'] = base_url() . "{langid}/" . $pageslug;
                if (strpos(@$content[0]->content_body, '{optional}') !== false) {
                    $this->theme->view('optional', $this->data, $this);
                } else {
                    if (strtolower($pageslug) == "contact-us") {
                        $this->theme->view('contact', $this->data, $this);
                    } else {
                        $this->theme->view('cms/page-data', $this->data, $this);
                    }
                }
            } elseif ($this->validlang && $pageslug == "supplier-register") {
                $this->supplier_register();
            } else {
                Error_404($this, $this->data);
            }
        }else {
            redirect('admin');
        }
    }

public function supplier_register() {
    $allowsupplierreg = $this->data['app_settings'][0]->allow_supplier_registration;
    if ($allowsupplierreg == "0") {
        Error_404($this);

        exit;
    }
    $this->load->model('Admin/Countries_model');
    $this->load->model('Admin/Accounts_model');
    $this->data['error'] = "";
    $this->data['success'] = $this->session->flashdata('success');
    $addaccount = $this->input->post('addaccount');
    $url = http_build_query($_GET);
    if (!empty($addaccount)) {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pt_accounts.accounts_email]');
        $this->form_validation->set_message('valid_email', 'Kindly Enter a Valid Email Address.');
        $this->form_validation->set_message('is_unique', 'Email Address is Already in Use.');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim');
        $this->form_validation->set_rules('state', 'State', 'trim');
        $this->form_validation->set_rules('fname', 'First Name', 'trim');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim');
        $this->form_validation->set_rules('address1', 'address 1', 'trim');
        $this->form_validation->set_rules('address2', 'address 2', 'trim');
        $this->form_validation->set_rules('mobile', 'mobile', 'trim');
        $this->form_validation->set_rules('itemname', 'Name', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->data['error'] = validation_errors();
        } else {

                /* if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])){

                $result = $this->Uploads_model->__profileimg();

                if($result == '1'){

                $this->data['errormsg'] = "Invalid file type kindly select only jpg/jpeg, png, gif file types";

                }elseif($result == '2'){

                $this->data['errormsg'] = "Only upto 2MB size photos allowed";

                }elseif($result == '3'){

                $this->session->set_flashdata('flashmsgs', "Customer Account Added Successfully");

                redirect('admin/accounts/customers/');

                }

            }else{*/

                $this->Accounts_model->register_supplier();

                //$this->session->set_flashdata('success', trans('0244'));

                $this->data['success'] = "1";

                //redirect(base_url() . 'supplier-register');

//   }
            }
        }

        $this->lang->load("front", $this->data['lang_set']);
        $restricted = $this->data['app_settings'][0]->restrict_website;
        if ($restricted == "Yes") {
            $this->data['hidden'] = "hidden-sm hidden-lg";
        }
        $this->data['allcountries'] = $this->Countries_model->get_all_countries();
        $this->data['langurl'] = base_url() . "{langid}/supplier-register";
        $this->setMetaData("supplier Registration");
        $this->theme->view('supplier-register', $this->data, $this);
    }
    // get all available modules for front - without integration modules
    public function available_modules() {
        $modules = array();
        $modlib = $this->ptmodules;
        $mainmodules = $modlib->moduleslist;
        $notallowed = array("blog");
        foreach ($mainmodules as $mainmod) {
            $istrue = $modlib->is_mod_available_enabled($mainmod);
            $isintegration = $modlib->is_integration($mainmod);
            if ($istrue && !$isintegration && !in_array($mainmod, $notallowed)) {
                $modules[] = $mainmod;
            }
        }

        return $modules;
    }

// check module availability
    public function is_module_enabled($module) {
        $result = $this->Modules_model->check_module($module);
        return $result;
    }

// check main module availability
    public function is_main_module_enabled($module) {
        $result = $this->Modules_model->check_main_module($module);
        return $result;
    }

//subscribe to newsletter
    public function subscribe() {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url());
        } else {
            $this->load->model('Admin/Newsletter_model');
            $email = $this->input->post('email');
            $this->form_validation->set_message('valid_email', 'Kindly Enter a Valid Email Address.');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run() == false) {
                echo validation_errors();
            } else {
                $res = $this->Newsletter_model->add_subscriber($email);
                if ($res) {
                    echo "Subscribed Successfully";
                } else {

                    echo "Already Subscribed";
                }
            }
        }
    }

    public function txtsearch() {
    }

    public function trackorder() {

        if ($this->input->is_ajax_request()) {
            $this->db->select('booking_status,booking_expiry,booking_deposit,booking_total');
            $this->db->where('booking_id', $this->input->post('code'));
            $rs = $this->db->get('pt_bookings')->result();
            if (!empty($rs)) {
                $html = "<p>Invoice Status : " . $rs[0]->booking_status . "</p>";
                $html .= "<p>Total : " . $this->data['app_settings'][0]->currency_code . " " . $this->data['app_settings'][0]->currency_sign . $rs[0]->booking_total . "</p>";
                if ($rs[0]->booking_status == "unpaid") {
                    $html .= " <p>Due Date : " . $rs[0]->booking_expiry . "</p>";
                }
                echo $html;
            } else {
                echo "<div class='alert alert-danger'>Invalid Code</div>";
            }
        } else {
            redirect(base_url());
        }
    }

    public function maps($lat = null, $long = null, $type, $id) {
        if (empty($lat) || empty($long)) {
            Error_404($this);
        } else {
            if ($type == "hotels") {
                $this->load->library('Hotels/Hotels_lib');
                $this->Hotels_lib->set_id($id);
                $this->Hotels_lib->hotel_short_details();
                $title = character_limiter($this->Hotels_lib->title, 15);
                $img = $this->Hotels_lib->thumbnail;
                $link = $this->Hotels_lib->slug;
                pt_show_map($lat, $long, '100%', '100%', $title, $img, 150, 80, $link);
            } elseif ($type == "tours") {
                $this->load->library('Tours/Tours_lib');
                $this->Tours_lib->set_id($id);
                $this->Tours_lib->tour_short_details();
                $title = character_limiter($this->Tours_lib->title, 15);
                $img = $this->Tours_lib->thumbnail;
                $link = $this->Tours_lib->slug;
                pt_show_map($lat, $long, '100%', '100%', $title, $img, 80, 80, $link);
            } elseif ($type == "cars") {
                $this->load->library('Cars/Cars_lib');
                $this->Cars_lib->set_id($id);
                $this->Cars_lib->car_short_details();
                $title = character_limiter($this->Cars_lib->title, 15);
                $img = $this->Cars_lib->thumbnail;
                $link = $this->Cars_lib->slug;
                pt_show_map($lat, $long, '100%', '100%', $title, $img, 80, 80, $link);
            } elseif ($type == "ean") {
                $link = "#";
                $img = $this->session->userdata('hotelThumb');
                pt_show_map($lat, $long, '100%', '100%', $title, $img, 80, 80, $link);
            }
        }
    }

    public function error() {
        $this->data['page_title'] = trans("0268");
        $this->theme->view('404', $this->data, $this);
    }

    public function cmsupload() {
        $url = 'uploads/cms/images/' . time() . '_' . $_FILES['upload']['name'];
        $functionNum = $_GET['CKEditorFuncNum'];
        if (($_FILES['upload'] == "none") or (empty($_FILES['upload']['name']))) {
            $message = "No file uploaded.";
        } else if ($_FILES['upload']["size"] == 0) {
            $message = "The file is of zero length.";
        } else if (($_FILES['upload']["type"] != "image/pjpeg") and ($_FILES['upload']["type"] != "image/jpeg") and ($_FILES['upload']["type"] != "image/png")) {
            $message = "Invalid Image.";
        } else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
            $message = "Hacking attempt Denied, don't try this here.";
        } else if (strpos($_FILES['upload']['name'], 'php') !== false) {
            $message = "Hacking attempt Denied, don't try to upload shells.";
        } else {
            $message = "";
            $move = @move_uploaded_file($_FILES['upload']['tmp_name'], $url);
            if (!$move) {
                $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
            }
            $url = base_url() . $url;
        }
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($functionNum, '$url', '$message');</script>";
    }

    public function suggestions_v2($module = "") {
        $query = $this->input->get('q');
        if (!empty($query)) {
            $result = array();
            if ($module == "hotels") {
                $this->load->library("Hotels/Hotels_lib");
                $result = $this->Hotels_lib->suggestionResults_v2($query);
            } elseif ($module == "tours") {
                $this->load->library("Tours/Tours_lib");
                $result = $this->Tours_lib->suggestionResults($query);
            }
            echo json_encode($result['forWeb']);
        }
    }

    public function suggestions($module) {
        $query = $this->input->get('q');
        if (!empty($query)) {
            $result = array();
            if ($module == "hotels") {
                $this->load->library("Hotels/Hotels_lib");
                $result = $this->Hotels_lib->suggestionResults($query);
            } elseif ($module == "tours") {
                $this->load->library("Tours/Tours_lib");
                $result = $this->Tours_lib->suggestionResults($query);
            }
            echo json_encode($result['forWeb']);
        }
    }

    public function getCities() {
        $jsonFile = APPPATH . "json/cities.json";
        $str = file_get_contents($jsonFile);
        $jsonData = json_decode($str, true);
        $result = array();
        $query = $this->input->get('term');
        //echo json_encode($str);
        foreach ($jsonData as $item) {
            //$result[] = $item;
            if (strpos(strtolower($item['name']), strtolower($query)) !== false) {
                $result[] = array("code" => $item['code'], "name" => $item['name']);
            }
        }

        echo json_encode($result);
    }

    /* Admin Controller ma be hai ya code */
    public function defaultcurrencyset(){
        $this->load->model('Admin/Settings_model');
        $this->Settings_model->defaultcurrency();
    }

    public function responsive(){
        $this->load->view('responsive');
    }

    public function booking(){
        $this->theme->view('home/booking', $this->data, $this);
    }

    public function pull(){
    shell_exec( 'git pull origin master' );
    echo "<style>h3{text-align: center; font-family: sans-serif; background: #eee; padding: 50px; border-bottom: 2px solid #d5d5d5;}></style>";
    echo "<h3>GIT PULLED</h3>";

    $starttime = microtime(true);
    exec('exec enaled');
    $endtime = microtime(true);
    $time_taken = $endtime-$starttime;

    }

}
