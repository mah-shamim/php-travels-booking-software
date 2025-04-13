<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Cars extends MX_Controller {
        private $validlang;

		function __construct() {
				parent :: __construct();

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

                modules :: load('Front');
				$this->frontData();
				$this->load->library("Cars_lib");
				$this->load->model("cars/Cars_model");
				$this->load->helper("Cars_front");
				$this->data['phone'] = $this->load->get_var('phone');
				$this->data['contactemail'] = $this->load->get_var('contactemail');
				$this->data['app_settings'] = $this->Settings_model->get_settings_data();
				$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
				$this->data['appModule'] = "cars";
				$this->data['modulelib'] = $this->Cars_lib;
				$chk = modules :: run('Home/is_main_module_enabled', 'cars');
				if (!$chk) {
						Error_404($this);
				}
                 $languageid = $this->uri->segment(2);
                $this->validlang = pt_isValid_language($languageid);

                if($this->validlang){
                  $this->data['lang_set'] =  $languageid;
                }else{
                  $this->data['lang_set'] = $this->session->userdata('set_lang');
                }

                $defaultlang = pt_get_default_language();
				if (empty ($this->data['lang_set'])){
						$this->data['lang_set'] = $defaultlang;
				}

				$this->data['carslocationsList'] = $this->Cars_lib->getLocationsList();
				$this->data['carspickuplocationsList'] = $this->Cars_lib->getPickupLocationsList();
				$this->data['carsdropofflocationsList'] = $this->Cars_lib->getDropLocationsList();


				$this->data['allowreg'] = $this->data['app_settings'][0]->allow_registration;


                $this->Cars_lib->set_lang($this->data['lang_set']);

		}

		public function index($carname = '', $html = false) {

				$settings = $this->Settings_model->get_front_settings('cars');
				$this->data['minprice'] = $settings[0]->front_search_min_price;
				$this->data['maxprice'] = $settings[0]->front_search_max_price;
				$this->data['loadMap'] = TRUE;
                if(empty($carname)) {
                    if($this->validlang){
                        //$countryName = $this->uri->segment(3);
                        //$cityName = $this->uri->segment(4);
                        $carname = $this->uri->segment(5);
                    }else{
                        // $countryName = $this->uri->segment(2);
                        // $cityName = $this->uri->segment(3);
                        $carname = $this->uri->segment(4);
                    }
                }

				$check = $this->Cars_model->car_exists($carname);
				if ($check && !empty ($carname)) {
						$this->Cars_lib->set_carid($carname);
						$this->data['module'] = $this->Cars_lib->car_details();

						if (pt_is_module_enabled('reviews')) {
								$this->data['reviews'] = $this->Cars_lib->carReviews($this->data['module']->id);
								$this->data['avg_reviews'] = $this->Cars_lib->carReviewsAvg($this->data['module']->id);
						}

						$this->data['carModTiming'] = $this->Cars_lib->timingList();

						$this->data['checkinMonth'] = strtoupper(date("F",convert_to_unix($this->Cars_lib->pickupDate)));
						$this->data['checkinDay'] = date("d",convert_to_unix($this->Cars_lib->pickupDate));
						$this->data['checkoutMonth'] = strtoupper(date("F",convert_to_unix($this->Cars_lib->dropoffDate)));
						$this->data['checkoutDay'] = date("d",convert_to_unix($this->Cars_lib->dropoffDate));

						$this->data['pickupTime'] = $this->Cars_lib->pickupTime;
						$this->data['dropoffTime'] = $this->Cars_lib->dropoffTime;
						$this->data['selectedpickupLocation'] = $this->input->get('pickupLocation');
			        	$this->data['selecteddropoffLocation'] = $this->input->get('dropoffLocation');


						$this->data['carspickuplocationsList'] = $this->Cars_lib->getPickupLocationsList($this->data['module']->id);
						$this->data['carsdropofflocationsList'] = $this->Cars_lib->getDropLocationsList($this->data['module']->id);


						$res = $this->Settings_model->get_contact_page_details();
						$this->lang->load("front", $this->data['lang_set']);

						$this->data['phone'] = $res[0]->contact_phone;
                        $this->data['langurl'] = base_url()."cars/{langid}/".$this->data['module']->slug;

$this->setMetaData($this->data['module']->title,$this->data['module']->metadesc,$this->data['module']->keywords);

                    if($html) {
                        return $this->theme->view('modules/cars/standard/details', $this->data, $this, true);
                    } else {
                        $this->theme->view('modules/cars/standard/details', $this->data, $this);
                    }
				}
				else {
						$this->listing();
				}
		}

		function listing($offset = null) {
				$this->lang->load("front", $this->data['lang_set']);
				$settings = $this->Settings_model->get_front_settings('cars');
				$this->data['moduleTypes'] = $this->Cars_lib->carTypes();

				$this->data['pickupTime'] = $this->Cars_lib->pickupTime;
				$this->data['dropoffTime'] = $this->Cars_lib->dropoffTime;

				$this->data['carModTiming'] = $this->Cars_lib->timingList();

				$allcars = $this->Cars_lib->show_cars($offset);

				$this->data['checkin'] = $this->Cars_lib->pickupDate;
				$this->data['checkout'] = $this->Cars_lib->dropoffDate;

				$this->data['module'] = $allcars['all_cars'];
				$this->data['minprice'] = $this->Cars_lib->convertAmount($settings[0]->front_search_min_price);
				$this->data['maxprice'] = $this->Cars_lib->convertAmount($settings[0]->front_search_max_price);
				$this->data['currCode'] = $this->Cars_lib->currencycode;
				$this->data['currSign'] = $this->Cars_lib->currencysign;
				$this->data['info'] = $allcars['paginationinfo'];
			    $this->data['langurl'] = base_url()."cars/{langid}";

			    $this->setMetaData($settings[0]->header_title,$settings[0]->meta_description,$settings[0]->meta_keywords);

				$this->theme->view('modules/cars/standard/listing', $this->data, $this);


		}



		function search($country = null, $city = null, $citycode = null,$offset = null) {
			    $this->data['carModTiming'] = $this->Cars_lib->timingList();
				$checkout = $this->input->get('checkout');
				$adult = $this->input->get('adults');
				$child = $this->input->get('child');
				//$country = $this->input->get('country');
				//$state = $this->input->get('state');

				$type = $this->input->get('type');
				$txtsearch = $this->input->get('searching');
				$cityid = $this->input->get('location');

				if(empty($country)){
					unset($_GET['location']);
					$surl = http_build_query($_GET);
					$locationInfo = pt_LocationsInfo($cityid);
					$country = url_title($locationInfo->country, 'dash', true);
					$city = url_title($locationInfo->city, 'dash', true);
					$cityid = $locationInfo->id;
					if(!empty($cityid)){
						redirect('cars/search/'.$country.'/'.$city.'/'.$cityid.'?'.$surl);
					}


				}else{
					$cityid = $citycode;
					if(is_numeric($country)){
						$offset = $country;
					}

				}

				if (array_filter($_GET)) {

						$allcars = $this->Cars_lib->search_cars($cityid, $offset);

						$this->data['module'] = $allcars['all_cars'];
			        	$this->data['info'] = $allcars['paginationinfo'];
				}
				else {
						$this->data['module'] = array();
				}
				$this->data['city'] = $cityid;

				$this->lang->load("front", $this->data['lang_set']);


				$this->data['selectedLocation'] = $cityid;//$this->Tours_lib->selectedLocation;
				$this->data['selectedpickupLocation'] = $this->input->get('pickupLocation');
				$this->data['selecteddropoffLocation'] = $this->input->get('dropoffLocation');

				$this->data['checkin'] = $this->Cars_lib->pickupDate;
				$this->data['checkout'] = $this->Cars_lib->dropoffDate;

				$this->data['pickupLocationName'] = $this->Cars_lib->pickupLocationName;
				$this->data['dropoffLocationName'] = $this->Cars_lib->dropoffLocationName;

				$this->data['selectedCarType'] = $this->Cars_lib->selectedCarType;
				$this->data['pickupDate'] = $this->Cars_lib->pickupDate;
				$this->data['dropoffDate'] = $this->Cars_lib->dropoffDate;
				$this->data['pickupTime'] = $this->Cars_lib->pickupTime;
				$this->data['dropoffTime'] = $this->Cars_lib->dropoffTime;



				$this->data['moduleTypes'] = $this->Cars_lib->carTypes();
				$settings = $this->Settings_model->get_front_settings('cars');
				$this->data['minprice'] = $this->Cars_lib->convertAmount($settings[0]->front_search_min_price);
				$this->data['maxprice'] = $this->Cars_lib->convertAmount($settings[0]->front_search_max_price);
				$this->data['currCode'] = $this->Cars_lib->currencycode;
				$this->data['currSign'] = $this->Cars_lib->currencysign;
				$this->setMetaData("Search Results");
				$this->theme->view('modules/cars/standard/listing', $this->data, $this);
		}


	function book($carslug) {
				$this->load->model('Admin/Countries_model');

				$this->data['allcountries'] = $this->Countries_model->get_all_countries();

			    $check = $this->Cars_model->car_exists($carslug);
				$this->load->library("Paymentgateways");
				$this->data['hideHeader'] = "1";


  				if ($check && !empty($carslug)) {
  				  	$this->load->model('Admin/Payments_model');

                      $this->Cars_lib->set_carid($carslug);
                      $carID = $this->Cars_lib->get_id();
                      $bookInfo = $this->Cars_lib->getBookResultObject($carID);
                      $this->Cars_lib->checkCarPriceAtBooking($carID);
                      $this->data['module'] = $bookInfo['car'];
                      $this->data['extraChkUrl'] = $bookInfo['car']->extraChkUrl;
                      $this->data['error'] = $this->Cars_lib->error;
                      $this->data['errorCode'] = $this->Cars_lib->errorCode;

                      $this->load->model('Admin/Accounts_model');
                      $this->lang->load("front", $this->data['lang_set']);

                      $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer');
                      $this->data['profile'] = $this->Accounts_model->get_profile_details($loggedin);
                    $this->setMetaData($this->data['module']->title,$this->data['module']->metadesc,$this->data['module']->keywords);
					  $this->theme->view('booking', $this->data, $this);
				}else{
                   redirect("cars");
				}
		}

		function txtsearch() {
				echo $this->Cars_model->textsearch();
		}

		function _remap($method, $params=array()){
		$funcs = get_class_methods($this);
		if(in_array($method, $funcs)){

		return call_user_func_array(array($this, $method), $params);

		}else{

			$result = checkUrlParams($method, $params,$this->validlang);
			if($result->showIndex){
			$this->index();
			}else{

				$this->lang->load("front", $this->data['lang_set']);
				$settings = $this->Settings_model->get_front_settings('cars');
				$this->data['moduleTypes'] = $this->Cars_lib->carTypes();
				$this->data['pickupTime'] = $this->Cars_lib->pickupTime;
				$this->data['carModTiming'] = $this->Cars_lib->timingList();
				$allcars = $this->Cars_lib->showCarsByLocation($result, $result->offset);
				$this->data['module'] = $allcars['all_cars'];
				$this->data['minprice'] = $this->Cars_lib->convertAmount($settings[0]->front_search_min_price);
				$this->data['maxprice'] = $this->Cars_lib->convertAmount($settings[0]->front_search_max_price);
				$this->data['currCode'] = $this->Cars_lib->currencycode;
				$this->data['currSign'] = $this->Cars_lib->currencysign;
				$this->data['info'] = $allcars['paginationinfo'];
			    $this->data['langurl'] = base_url()."cars/{langid}";

			    $this->setMetaData($settings[0]->header_title,$settings[0]->meta_description,$settings[0]->meta_keywords);
				$this->theme->view('modules/cars/standard/listing', $this->data, $this);

			}
		}
		}
}
