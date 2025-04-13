<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin extends MX_Controller {
    public $data = array();
    public $userid;
    public $role;
    private $jsonFile;
    private $license = false;

    function __construct() {
        $this->load->helper('date');
        $this->load->helper('xcrud');
        $this->load->helper('themes');
        $this->load->helper('pt_includes');
        $this->load->model('Helpers_models/Translation_model');
        $this->load->model('Helpers_models/Misc_model');
        $this->load->model('Helpers_models/Menus_model');
        $this->load->model('Admin/Countries_model');
        $this->load->model('Admin/Accounts_model');
        $this->load->model('Admin/Cms_model');
        $this->load->model('Admin/Modules_model');
        $this->load->model('Admin/Newsletter_model');
        $this->load->model('Hotels/Hotels_model');
        $this->load->model('Hotels/Rooms_model');
        $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');
        $this->jsonFile = "application/updates.json";
        $this->userid = $this->session->userdata('pt_logged_id');
        $this->data['accType'] = $this->session->userdata('pt_accountType');
        $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');

        if (file_exists('install')) {
            $this->data['removedir'] = '1';
        } else {
            $this->data['removedir'] = '0';
        }

        $this->lang->load("back", "en");
        $this->refreshLastActivity();
    }

    public function index() {
        require_once(APPPATH.'modules/Admin/controllers/System.php');
        $oHome =  new System();
        $license = $oHome->checksystem();
        $whitelist = array('127.0.0.1', '::1');
        if ($license || in_array($_SERVER['REMOTE_ADDR'], $whitelist) || $_SERVER['HTTP_HOST'] == "server") {
            if ($this->validadmin()) {

                $addnotes = $this->input->post('addnotes');
                $updatenotes = $this->input->post('updatenotes');
                if (!empty($updatenotes)) {
                    $this->Accounts_model->update_admin_notes($this->data['isadmin']);
                } elseif (!empty($addnotes)) {
                    $this->Accounts_model->add_admin_notes($this->data['isadmin']);
                }
                //update pt_sessions table to remove all previous data
                $this->updateSessionsTable();
                if ($this->role != "webadmin") {
                    $this->data['canQuickBook'] = pt_permissions("addbooking", $this->data['userloggedin']);

                } else {
                    $this->data['canQuickBook'] = TRUE;

                }
                $this->data['app_settings'] = $this->Settings_model->get_settings_data();

                //Start Reports Code
                $this->data['currCode'] = $this->data['app_settings'][0]->currency_code;
                $this->defaultcurrencyset();

                $this->data['oneEightyDays'] = modules::run('Admin/reports/diffLastDuration', '180');
                $this->data['nintyDays'] = modules::run('Admin/reports/diffLastDuration', '90');
                $this->data['sixtyDays'] = modules::run('Admin/reports/diffLastDuration', '60');
                $this->data['yesterday'] = modules::run('Admin/reports/diffLastDuration', '1');
                $this->data['today'] = modules::run('Admin/reports/today');

                //for total amount paid
                $this->data['thirtyDaysPaid'] = modules::run('Admin/reports/diffLastDurationPaid', '30');
                $this->data['oneEightyDaysPaid'] = modules::run('Admin/reports/diffLastDurationPaid', '180');
                $this->data['nintyDaysPaid'] = modules::run('Admin/reports/diffLastDurationPaid', '90');
                $this->data['sixtyDaysPaid'] = modules::run('Admin/reports/diffLastDurationPaid', '60');
                $this->data['yesterdayPaid'] = modules::run('Admin/reports/diffLastDurationPaid', '1');
                $this->data['todayPaid'] = modules::run('Admin/reports/diffLastDurationPaid', '0');
                //end for total amount paid

                $this->data['oneEightyDaysExpedia'] = modules::run('Admin/reports/diffLastDurationExpedia', '180');
                $this->data['nintyDaysExpedia'] = modules::run('Admin/reports/diffLastDurationExpedia', '90');
                $this->data['sixtyDaysExpedia'] = modules::run('Admin/reports/diffLastDurationExpedia', '60');
                $this->data['yesterdayExpedia'] = modules::run('Admin/reports/diffLastDurationExpedia', '1');
                $this->data['todayExpedia'] = modules::run('Admin/reports/diffLastDurationExpedia', '0');
                $this->data['thirtyDaysExpedia'] = modules::run('Admin/reports/diffLastDurationExpedia', '30');

                $this->data['thirtyDays'] = modules::run('Admin/reports/thirtydays');

                $this->data['graphReport'] = modules::run('Admin/reports/graphReport');
                $this->data['graphReportHotels'] = modules::run('Admin/reports/graphReport', 'hotels');
                $this->data['graphReportFlights'] = modules::run('Admin/reports/graphReport', 'flights');
                $this->data['graphReportTours'] = modules::run('Admin/reports/graphReport', 'tours');
                $this->data['graphReportRentals'] = modules::run('Admin/reports/graphReport', 'rentals');
                $this->data['graphReportCars'] = modules::run('Admin/reports/graphReport', 'cars');
                $this->data['graphReportExpedia'] = modules::run('Admin/reports/graphReportExpedia');
 
                // Travelport
                $this->data['graphReportTravelport'] = modules::run('Admin/reports/graphReportTravelport'); // Chart Data
                $this->data['travelportCurrentDaySale'] = modules::run('Admin/reports/travelport_today_sale'); // Current Day Sale Amount
                $this->data['travelportLastThirtyDays'] = modules::run('Admin/reports/travelport_last_thirty_days_sale'); // Last 30 Days Sale Amount
                $this->data['travelportLastNinghtyDays'] = modules::run('Admin/reports/travelport_last_ninghty_days_sale'); // Last 90 Days Sale Amount

                // Travelhope Flight
                $this->data['graphReportTravelhopeFlight'] = modules::run('Admin/reports/graphReportTravelhopeFlight'); // Chart Data
                // Travelhope Hotel
                $this->data['graphReportTravelhopeHotel'] = modules::run('Admin/reports/graphReportTravelhopeHotel'); // Chart Data

                $modules = new stdClass;
                $modules->hotels = (object) array("name" => "Hotels", "data" => $this->data['graphReportHotels']['amounts']);
                $modules->flights = (object) array("name" => "Flights", "data" => $this->data['graphReportFlights']['amounts']);
                $modules->tours = (object) array("name" => "Tours", "data" => $this->data['graphReportTours']['amounts']);
                $modules->rentals = (object) array("name" => "Rentals", "data" => $this->data['graphReportRentals']['amounts']);
                $modules->cars = (object) array("name" => "Cars", "data" => $this->data['graphReportCars']['amounts']);
                $modules->ean = (object) array("name" => "Expedia", "data" => $this->data['graphReportExpedia']['amounts']);
                $modules->travelport_flight = (object) array("name" => "Flights", "data" => $this->data['graphReportTravelport']);
                $modules->travelhope_flight = (object) array("name" => "Thflights", "data" => $this->data['graphReportTravelhopeFlight']['amounts']);
                $modules->travelhope_hotel = (object) array("name" => "Thhotels", "data" => $this->data['graphReportTravelhopeHotel']['amounts']);

                $hotelsMod = isModuleActive('hotels');
                $flightsMod = isModuleActive('flights');
                $toursMod = isModuleActive('tours');
                $rentalsMod = isModuleActive('rentals');
                $carsMod = isModuleActive('cars');
                $eanMod = isModuleActive('ean');
                $travelport_flight = isModuleActive('travelport_flight');

                if ($hotelsMod) {
                    $modules->graphModules[] = $modules->hotels;
                }

                if ($flightsMod) {
                    $modules->graphModules[] = $modules->flights;
                }

                if ($toursMod) {
                    $modules->graphModules[] = $modules->tours;
                }
                if ($rentalsMod) {
                    $modules->graphModules[] = $modules->rentals;
                }
                if ($carsMod) {
                    $modules->graphModules[] = $modules->cars;
                }

                if ($eanMod) {
                    $modules->graphModules[] = $modules->ean;
                }

                if ($travelport_flight) {
                    $this->data['travelportSeries'] = json_encode(array($modules->travelport_flight));
                }

                if (isModuleActive('TravelhopeFlights')) {
                    $modules->graphModules[] = $modules->travelhope_flight;
                }

                if (isModuleActive('TravelhopeHotels')) {
                    $modules->graphModules[] = $modules->travelhope_hotel;
                }

                $array = $modules->graphModules;

                $this->data['resArray'] = json_encode($array);

                // Accounts reports.
                $this->data['adminAccountsCount'] = modules::run('Admin/reports/accountsCount', 'admin');
                $this->data['supplierAccountsCount'] = modules::run('Admin/reports/accountsCount', 'supplier');
                $this->data['customersAccountsCount'] = modules::run('Admin/reports/accountsCount', 'customers');
                $this->data['guestAccountsCount'] = modules::run('Admin/reports/accountsCount', 'guest');

                $this->data['agentAccountsCount'] = modules::run('Admin/reports/accountsCount', 'agent');

                $this->data['totalBookings'] = modules::run('Admin/reports/totalBookings');
                //End Reports Code

                // booking reports.
                $this->data['pendingCount'] = modules::run('Admin/reports/pendingbCount', 'pending');

                $this->data['confirmedCount'] = modules::run('Admin/reports/confirmedbCount', 'confirmed');

                $this->data['cancelledCount'] = modules::run('Admin/reports/cancelledbCount', 'cancelled');

                $this->data['paidCount'] = modules::run('Admin/reports/paidbCount', 'paid');

                $this->data['unpaidCount'] = modules::run('Admin/reports/unpaidbCount', 'unpaid');

                $this->data['refundedCount'] = modules::run('Admin/reports/refundedbCount', 'refunded');
                //End Reports Code

                $this->data['quickmodules'] = app()->service('ModuleService')->getQuickBookingModules();

                $this->data['chklib'] = $this->ptmodules;

                $this->data['blogenabled'] = isModuleActive('blog');
                $this->data['newsletterEnabled'] = isModuleActive('newsletter');
                $this->data['thismonth'] = modules::run('Admin/reports/this_month_report');
                $this->data['thisyear'] = modules::run('Admin/reports/this_year_report');
                $this->data['thisday'] = modules::run('Admin/reports/this_day_report');
                $this->data['mainmodules'] = $this->Modules_model->get_module_names();
                $this->data['modules'] = $this->Modules_model->get_all_enabled_modules();
                $this->data['customers'] = $this->Accounts_model->get_active_customers();
                $this->data['smsaddon'] = $this->Modules_model->check_module("smsaddon");
                $visits = $this->visitors_stats();
                $this->data['totalDays'] = $visits->totalDays;
                $this->data['uniqueVisits'] = $visits->uniqueVisits;
                $this->data['totalHits'] = $visits->totalHits;

                $xaxis = [];
                for ($i = 0; $i <= 31; $i++) {
                    $xaxis[] = date("m-d", strtotime('-' . $i . ' days'));
                }
                sort($xaxis);
                $this->data['xaxis'] = $xaxis;

                $this->data['notes'] = $this->Accounts_model->admin_notes_image($this->data['isadmin']);
                $this->data['main_content'] = 'dashboard/dashboard'; 
                $this->data['page_title'] = 'Dashboard';

                $this->data['stats'] = $this->Accounts_model->dashboard_stats();
                $this->load->view('template', $this->data);

            } else {

                //secure login check

                $slogin = $this->secure_url();
                $skey = $this->secure_key();
                if ($slogin) {
                    $key = $this->input->get('s');
                    if (!empty($key)) {
                        if ($skey) {
                            $this->data['pagetitle'] = 'Administator Login';
                            $this->load->view('login', $this->data);
                        } else {
                            backError_404();
                        }
                    } else {
                        backError_404();
                    }
                } else {
                    $this->data['pagetitle'] = 'Administator Login';
                    $this->load->view('login', $this->data);

                }
            }
        } else {
            $this->license();
        }
    }

    function login() {

        $username = $this->input->post('email');
        $password = $this->input->post('password');
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {

                $result = array("status" => false, "msg" => validation_errors(), "url" => "");
            } else {

                $login = $this->Accounts_model->login_admin($username, $password);
                if ($login) {
                    $prevurl = $this->session->userdata('prevURL');
                    if (!empty($prevurl)) {
                        $url = $prevurl;
                    } else {
                        $url = base_url() . 'admin';
                    }

                    $result = array("status" => true, "msg" => "", "url" => $url);
                } else {
                    $result = array("status" => false, "msg" => "Invalid Login Credentials", "url" => "");

                }

            }
            //$l = array('session' => $this->session->userdata('pt_logged_admin'));
            echo json_encode($result);

        }
    }

    function resetpass() {
        $acc = array("admin", "webadmin");
        $email = $this->input->post('email');
        $this->db->where('accounts_email', $email);
        $this->db->where_in('accounts_type', $acc);

        $check = $this->db->get('pt_accounts')->num_rows();
        if ($check > 0) {
            $newpass = random_string('alnum', 8);
            $updata = array('accounts_password' => sha1($newpass));
            $this->db->where('accounts_email', $email);
            $this->db->where('accounts_type', 'webadmin');
            $this->db->or_where('accounts_type', 'admin');
            $this->db->update('pt_accounts', $updata);
            $this->load->model('Admin/Emails_model');
            $this->Emails_model->reset_password($email, $newpass);
        }
        echo $check;
    }

    function profile() {
        if ($this->validadmin()) {
            $update = $this->input->post('update');
            $subs = $this->input->post('newssub');
            $email = $this->input->post('email');
            if (!empty($update)) {

                $updateResult = $this->Accounts_model->update_profile('admin', $this->userid);
                if ($updateResult->noError) {

                    if (!empty($subs)) {
                        $this->Newsletter_model->add_subscriber($email, $this->input->post('type'));
                    } else {
                        $this->Newsletter_model->remove_subscriber($email);
                    }
                    $this->session->set_flashdata('flashmsgs', 'Profile Updated');

                    $this->data['msg'] = "";
                    redirect('admin/profile', 'refresh');

                } else {

                    $this->data['msg'] = "<div class='alert alert-danger'>" . $updateResult->msg . "</div>";

                }

            }

            $this->data['profile'] = $this->Accounts_model->get_profile_details($this->userid);
            $this->data['isSubscribed'] = $this->Newsletter_model->is_subscribed($this->data['profile'][0]->accounts_email);
            $this->data['countries'] = $this->Countries_model->get_all_countries();
            $this->data['main_content'] = 'accounts/profile';
            $this->data['page_title'] = 'My Profile';
            $this->load->view('template', $this->data);
        } else {
            redirect('admin');
        }
    }

    function license() {
        $submit = $this->input->post('check');
        if (!empty($submit)) {
            $this->session->set_flashdata('invalid', '<div class="alert alert-danger text-center">License key is invalid!</div>');
            $key = $this->input->post('licensekey');
            $this->update_license_key($key);
            redirect('admin');
        }

        $this->data['pagetitle'] = 'Verify Your License';
        $this->load->view('licenseform', $this->data);
    }

//secure login check
    function secure_url() {
        $this->db->where('secure_admin_status', '1');
        $this->db->where('user', 'webadmin');
        $res = $this->db->get('pt_app_settings')->num_rows();
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }

//secure login url key
    function secure_key() {
        $this->db->where('secure_admin_key', $this->input->get('s'));
        $this->db->where('user', 'webadmin');
        $res = $this->db->get('pt_app_settings')->num_rows();
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }

// visitors stats
    function visitors_stats() {
        $visitsResults = new stdClass;
        // $visitsData = json_decode(file_get_contents("application/json/visits.json"));
        $visitsData = $this->db->select('data_object')->get('visitors')->row()->data_object;
        $visitsData = json_decode($visitsData);

        $visitsData->days = array_slice($visitsData->days, -30, 30, true);

        $visitsResults->totalDays = count((array) $visitsData->days);

        $uniqueVisits = array();
        foreach ($visitsData->days as $uv) {
            $visitsResults->uniqueVisits[] = $uv->unique;
        }

        foreach ($visitsData->days as $th) {
            $visitsResults->totalHits[] = $th->hits;
        }

        return $visitsResults;
    }

// reset visitors stats
    function resetVisits() {
        if ($this->input->post('isAjax') == "yes") {
            $currMonth = date("m");
            $f = new stdClass;
            $f->days = array();
            $f->currMonth = $currMonth;

            // file_put_contents("application/json/visits.json", json_encode($f, JSON_PRETTY_PRINT));
            $this->db->set('data_object', json_encode($f, JSON_PRETTY_PRINT));
            $this->db->update('visitors');
        }
    }

/******************************************************************
//THIS METHOD RETURNS A SET OF DATES IN AN ARRAY BASED ON INPUT
 *******************************************************************/
    function createDatesArray($start, $end) {
        $to = strtotime(date('Y-m-t'));
        if ($end <= $to) {
            $dates = array();
            while ($start <= $end) {
                array_push($dates, date('Y-m-d', $start));
                $start += 86400;
            }
            return $dates;
        }
    }

// is valid admin
    function validadmin() {

        if (!empty($this->data['isadmin'])) {
            return true;
        } else {
            return false;
        }
    }

    //logout
    function logout() {
        $lastlogin = $this->session->userdata('pt_logged_time');
        $updatelogin = array('accounts_last_login' => $lastlogin);
        $this->db->where('accounts_id', $this->userid);
        $this->db->update('pt_accounts', $updatelogin);
        $this->session->sess_destroy();
        redirect('admin');
    }


    function update_license_key($key) {
        $ldata = array('license_key' => $key);
        $this->db->where('user', 'webadmin');
        $this->db->update('pt_app_settings', $ldata);
    }

//    function update_local_key($key) {
//        $kdata = array('local_key' => $key);
//        $this->db->where('user', 'webadmin');
//        $this->db->update('pt_app_settings', $kdata);
//    }
//Update pt_sessions table to remove all the data which was added six hours ago
    function updateSessionsTable() {
        $pastSixHours = time() - 84600;
        $this->db->where('last_activity <', $pastSixHours);
        $this->db->delete('pt_sessions');
    }
//refresh last activity
    function refreshLastActivity() {

        $session = $this->session->userdata('session_id');
        $data = array(
            'last_activity' => time()

        );
        $this->db->where('session_id', $session);
        $this->db->update('pt_sessions', $data);

    }

    function appSettings() {
        $this->db->where('user', 'webadmin');
        $res = $this->db->get('pt_app_settings')->result();
        $result = array(
            'currencysign' => $res[0]->currency_sign,
            'currencycode' => $res[0]->currency_code,
            'defaultLang' => $res[0]->default_lang,
            'dateFormat' => $res[0]->date_f,
            'dateFormatJs' => $res[0]->date_f_js,
            'mapApi' => $res[0]->mapApi
        );
        return (object) $result;
    }

// hotels module controller
    function hotels($args = null, $id = null, $roomid = null) {
        $hotelsmod = modules::load('hotels/hotelsback/');
        if (!method_exists($hotelsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $hotelsmod->index();
        } elseif ($args == "add") {
            $hotelsmod->add();
        } elseif ($args == "settings") {
            $hotelsmod->settings();
        } elseif ($args == "manage") {
            $hotelsmod->manage($id);
        } elseif ($args == "extras") {
            $hotelsmod->extras($id);
        } elseif ($args == "reviews") {
            $hotelsmod->reviews($id);
        } elseif ($args == "gallery") {
            $hotelsmod->gallery($id);
        } elseif ($args == "roomgallery") {
            $hotelsmod->roomgallery($id);
        } elseif ($args == "translate") {
            $hotelsmod->translate($id, $roomid);
        } elseif ($args == "rooms") {
            $hotelsmod->rooms($id, $roomid);
        }
    }

// cars module controller
    function cars($args = null, $id = null, $lang = null) {
        $carsmod = modules::load('cars/carsback/');
        if (!method_exists($carsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $carsmod->index();
        } elseif ($args == "add") {
            $carsmod->add();
        } elseif ($args == "settings") {
            $carsmod->settings();
        } elseif ($args == "manage") {
            $carsmod->manage($id);
        } elseif ($args == "extras") {
            $carsmod->extras($id);
        } elseif ($args == "reviews") {
            $carsmod->reviews($id);
        } elseif ($args == "gallery") {
            $carsmod->gallery($id);
        } elseif ($args == "translate") {
            $carsmod->translate($id, $lang);
        }
    }

// Tours module controller
    function tours($args = null, $id = null, $lang = null) {
        $toursmod = modules::load('tours/toursback/');
        if (!method_exists($toursmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $toursmod->index();
        } elseif ($args == "add") {
            $toursmod->add();
        } elseif ($args == "dates") {
            $toursmod->dates();
        } elseif ($args == "settings") {
            $toursmod->settings();
        } elseif ($args == "manage") {
            $toursmod->manage($id);
        } elseif ($args == "extras") {
            $toursmod->extras($id);
        } elseif ($args == "reviews") {
            $toursmod->reviews($id);
        } elseif ($args == "gallery") {
            $toursmod->gallery($id);
        } elseif ($args == "translate") {
            $toursmod->translate($id, $lang);
        }
    }


    // Rentals module controller
    function rentals($args = null, $id = null, $lang = null) {
        $rentalsmod = modules::load('rentals/rentalsback/');
        if (!method_exists($rentalsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $rentalsmod->index();
        } elseif ($args == "add") {
            $rentalsmod->add();
        } elseif ($args == "dates") {
            $rentalsmod->dates();
        } elseif ($args == "settings") {
            $rentalsmod->settings();
        } elseif ($args == "manage") {
            $rentalsmod->manage($id);
        } elseif ($args == "extras") {
            $rentalsmod->extras($id);
        } elseif ($args == "reviews") {
            $rentalsmod->reviews($id);
        } elseif ($args == "gallery") {
            $rentalsmod->gallery($id);
        } elseif ($args == "translate") {
            $rentalsmod->translate($id, $lang);
        }
    }


    // Boats module controller
    function boats($args = null, $id = null, $lang = null) {
        $boatsmod = modules::load('boats/boatsback/');
        if (!method_exists($boatsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $boatsmod->index();
        } elseif ($args == "add") {
            $boatsmod->add();
        } elseif ($args == "dates") {
            $boatsmod->dates();
        } elseif ($args == "settings") {
            $boatsmod->settings();
        } elseif ($args == "manage") {
            $boatsmod->manage($id);
        } elseif ($args == "extras") {
            $boatsmod->extras($id);
        } elseif ($args == "reviews") {
            $boatsmod->reviews($id);
        } elseif ($args == "gallery") {
            $boatsmod->gallery($id);
        } elseif ($args == "translate") {
            $boatsmod->translate($id, $lang);
        }
    }

    // flights module controller
    function flights($args = null, $id = null, $roomid = null) {
        $flightsmod = modules::load('flights/flightsback/');
        if (!method_exists($flightsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $flightsmod->index();
        } elseif ($args == "add") {
            $flightsmod->add();
        } elseif ($args == "settings") {
            $flightsmod->settings();
        } elseif ($args == "manage") {
            $flightsmod->manage($id);
        } elseif ($args == "extras") {
            $flightsmod->extras($id);
        } elseif ($args == "reviews") {
            $flightsmod->reviews($id);
        } elseif ($args == "gallery") {
            $flightsmod->gallery($id);
        } elseif ($args == "translate") {
            $flightsmod->translate($id, $roomid);
        }

    }

// ean module controller
    function ean($args = null, $id = null) {
        $eanmod = modules::load('ean/eanback/');
        if (!method_exists($eanmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
//$eanmod->index();
        } elseif ($args == "add") {
//$eanmod->add();
        } elseif ($args == "settings") {
            $eanmod->settings();
        } elseif ($args == "bookings") {
            $eanmod->bookings();
        } elseif ($args == "dashboardBookings") {
            $eanmod->dashboardBookings();
        }
    }


// flightstravelstart module controller
    function travelstart($args = null, $id = null) {
        $travelstartmod = modules::load('travelstart/travelstartback/');
        if (!method_exists($travelstartmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
//$dohopmod->index();
        } elseif ($args == "add") {
//$dohopmod->add();
        } elseif ($args == "settings") {
            $travelstartmod->settings();
        } elseif ($args == "manage") {
//$dohopmod->manage($id);
        }
    }

// travelpayouts
    function travelpayouts($args = null, $id = null) {
        $travelpayoutsmod = modules::load('travelpayouts/travelpayoutsback/');
        if (!method_exists($travelpayoutsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
//$dohopmod->index();
        } elseif ($args == "add") {
//$dohopmod->add();
        } elseif ($args == "settings") {
            $travelpayoutsmod->settings();
        } elseif ($args == "manage") {
//$dohopmod->manage($id);
        }
    }

// RentalCars module controller
    function rentalcars($args = null, $id = null) {
        $rentalcarmod = modules::load('rentalcars/rentalcarsback/');
        if (!method_exists($rentalcarmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
//$rentalcarmod->index();
        } elseif ($args == "add") {
//$rentalcarmod->add();
        } elseif ($args == "settings") {
            $rentalcarmod->settings();
        } elseif ($args == "manage") {
//$rentalcarmod->manage($id);
        }
    }

// Hotelscombined module controller
    function hotelscombined($args = null, $id = null) {

        $hotelscombinedmod = modules::load('hotelscombined/hotelscombinedback/');
        if (!method_exists($hotelscombinedmod, 'index')) {
            redirect('admin');
        }

        if ($args == "settings") {
            $hotelscombinedmod->settings();
        }

    }

    // wegoflights module controller
    function wegoflights($args = null, $id = null) {
        $wegoflightsmod = modules::load('wegoflights/wegoflightsback/');
        if (!method_exists($wegoflightsmod, 'index')) {
            redirect('admin');
        }
        if ($args == "settings") {
            $wegoflightsmod->settings();
        }
    }

// Ivisa module controller
    function ivisa($args = null, $id = null) {
        $ivisabackmod = modules::load('ivisa/ivisaback/');
        if (!method_exists($ivisabackmod, 'index')) {
            redirect('admin');
        }
        if ($args == "settings") {
            $ivisabackmod->settings();
        }
    }

// booking module controller
    function booking($args = null, $id = null) {
        $bookingmod = modules::load('booking/bookingback/');
        if (!method_exists($bookingmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
//$bookingmod->index();
        } elseif ($args == "add") {
//$bookingmod->add();
        } elseif ($args == "settings") {
            $bookingmod->settings();
        } elseif ($args == "manage") {
//$bookingmod->manage($id);
        }
    }

// TripAdvisor module controller
    function tripadvisor($args = null, $id = null) {
        $tripadvisormod = modules::load('tripadvisor/tripadvisorback/');
        if (!method_exists($tripadvisormod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
//$tripadvisormod->index();
        } elseif ($args == "add") {
//$tripadvisormod->add();
        } elseif ($args == "settings") {
            $tripadvisormod->settings();
        } elseif ($args == "manage") {
//$tripadvisormod->manage($id);
        }
    }

// Cartrawler module controller
    function cartrawler($args = null, $id = null) {
        $cartrawlermod = modules::load('cartrawler/cartrawlerback/');
        if (!method_exists($cartrawlermod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {

        } elseif ($args == "add") {

        } elseif ($args == "settings") {
            $cartrawlermod->settings();
        } elseif ($args == "manage") {

        }
    }

// blog module controller
    function blog($args = null, $id = null, $lang = null) {
        $blogmod = modules::load('blog/blogback/');
        if (!method_exists($blogmod, 'index')) {
            redirect('admin');
        }
        if ($args == "") {
            $blogmod->index();
        } elseif ($args == "add") {
            $blogmod->add();
        } elseif ($args == "category") {
            $blogmod->category();
        } elseif ($args == "settings") {
            $blogmod->settings();
        } elseif ($args == "manage") {
            $blogmod->manage($id);
        } elseif ($args == "translate") {
            $blogmod->translate($id, $lang);
        }
    }

    public function defaultcurrencyset(){
        $this->load->model('Admin/Settings_model');
        $this->Settings_model->defaultcurrency();
    }

    public function banip(){
       $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_banip');
        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Ban IP Management';
        $this->data['main_content'] = 'newsletter_view';
        $this->data['table_name'] = 'pt_banip';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Ban IP Management';
        $this->load->view('template', $this->data);
    }
    public function payouts($payload,$module="hotels"){
        if ($payload == "paid"){
          $this->paid($module);
          return;
        }
        if($module == "hotels"){
            $this->load->helper('xcrud');
            $xcrud = xcrud_get_instance();
            $xcrud->table('pt_accounts');
            $xcrud->where('accounts_type','supplier');
            $xcrud->unset_add();
            $xcrud->unset_view();
            $xcrud->unset_edit();
            $xcrud->unset_view();
            $xcrud->unset_remove();
            $xcrud->columns(array('ai_first_name','ai_last_name','accounts_email','commission','ai_website','ai_mobile'));
            $xcrud->column_callback('ai_website','getCommissionHotels');
            $xcrud->column_callback('ai_mobile','getCommissionHotels');
            $xcrud->label(array('ai_website'=>"Total"));
            $this->data['content'] = $xcrud->render();
            $this->data['page_title'] = 'Payouts Management';
            $this->data['main_content'] = 'payout_view';
            $this->data['table_name'] = 'pt_payouts';
            $this->data['main_key'] = 'id';
            $this->data['header_title'] = 'Payouts Management';
            $this->load->view('template', $this->data);
        }elseif($module == "cars"){
            $this->load->helper('xcrud');
            $xcrud = xcrud_get_instance();
            $xcrud->unset_add();
            $xcrud->unset_view();
            $xcrud->unset_edit();
            $xcrud->unset_view();
            $xcrud->unset_remove();
            $xcrud->table('pt_accounts');
            $xcrud->where('accounts_type','supplier');
            $xcrud->columns(array('ai_first_name','ai_last_name','accounts_email','commission','ai_website','ai_mobile'));
            $xcrud->column_callback('ai_website','getCommissionCars');
            $xcrud->column_callback('ai_mobile','getCommissionCars');
            $xcrud->label(array('ai_website'=>"Total"));
            $this->data['content'] = $xcrud->render();
            $this->data['page_title'] = 'Payouts Management';
            $this->data['main_content'] = 'payout_view';
            $this->data['table_name'] = 'pt_payouts';
            $this->data['main_key'] = 'id';
            $this->data['header_title'] = 'Payouts Management';
            $this->load->view('template', $this->data);

        }elseif($module == "tours"){

            $this->load->helper('xcrud');
            $xcrud = xcrud_get_instance();
            $xcrud->unset_add();
            $xcrud->unset_view();
            $xcrud->unset_edit();
            $xcrud->unset_view();
            $xcrud->unset_remove();
            $xcrud->table('pt_accounts');
            $xcrud->where('accounts_type','supplier');
            $xcrud->columns(array('ai_first_name','ai_last_name','accounts_email','commission','ai_website','ai_mobile'));
            $xcrud->column_callback('ai_website','getCommissionTours');
            $xcrud->column_callback('ai_mobile','getCommissionTours');
            $xcrud->label(array('ai_website'=>"Total"));
            $this->data['content'] = $xcrud->render();
            $this->data['page_title'] = 'Payouts Management';
            $this->data['main_content'] = 'payout_view';
            $this->data['table_name'] = 'pt_payouts';
            $this->data['main_key'] = 'id';
            $this->data['header_title'] = 'Payouts Management';
            $this->load->view('template', $this->data);

        }

    }
    public function paid($module=""){
        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_remove();
        $xcrud->table('pt_payouts');
        $xcrud->join('supplier_id','pt_accounts','accounts_id',[],'not_insert');
        $xcrud->fields(array('status'));
        $xcrud->columns(array('pt_accounts.accounts_email','pt_accounts.ai_first_name','pt_accounts.ai_last_name','status','amount','created_at'));
        $customers = $xcrud->nested_table('Invoices','id','pt_payouts_invoice','payouts_id');
        $customers->join('invoice_id','pt_bookings','booking_id',[],'not_insert');
        $customers->columns(array('pt_bookings.booking_id','pt_bookings.booking_date','pt_bookings.booking_user','pt_bookings.booking_total','pt_bookings.booking_ref_no'));
        $customers->column_callback('pt_bookings.booking_ref_no','invoice_url');
        $customers->unset_view();
        $customers->unset_edit();
        if($module == "hotels" || $module == "tours" || $module == "cars"){
            $xcrud->where('module',$module);
        }
        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Payouts Management';
        $this->data['main_content'] = 'payout_view';
        $this->data['table_name'] = 'pt_payouts';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Payouts Management';
        $this->load->view('template', $this->data);
    }

}
