<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Routesflights extends MX_Controller
{
    public $accType = "";
    public $role = "";
    public $editpermission = true;
    public $deletepermission = true;

    function __construct()
    {
        $seturl = $this->uri->segment(3);
        if ($seturl != "settings") {
            $chk = modules:: run('Home/is_main_module_enabled', 'Kiwi');
            if (!$chk) {
                backError_404($this->data);
            }
        }

        $checkingadmin = $this->session->userdata('pt_logged_admin');
        $this->accType = $this->session->userdata('pt_accountType');
        $this->role = $this->session->userdata('pt_role');

        $this->data['userloggedin'] = $this->session->userdata('pt_logged_id');

        if (empty ($this->data['userloggedin'])) {
            $urisegment = $this->uri->segment(1);
            $this->session->set_userdata('prevURL', current_url());
            redirect($urisegment);
        }
        if (!empty ($checkingadmin)) {
            $this->data['adminsegment'] = "admin";
        } else {
            $this->data['adminsegment'] = "supplier";
        }
        if ($this->data['adminsegment'] == "admin") {

            $chkadmin = modules:: run('Admin/validadmin');
            if (!$chkadmin) {

                redirect('admin');
            }
        } else {
            $chksupplier = modules:: run('supplier/validsupplier');
            if (!$chksupplier) {
                redirect('supplier');
            }
        }

        $this->data['appSettings'] = modules:: run('Admin/appSettings');
        $this->load->library('Ckeditor');
        $this->data['ckconfig'] = array();
        $this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
        $this->data['ckconfig']['language'] = 'en';
        //$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
        $this->load->helper('Flights/flights');
        $this->data['languages'] = pt_get_languages();
        $this->load->helper('xcrud');
        $this->data['c_model'] = $this->countries_model;
        $this->data['tripadvisor'] = $this->ptmodules->is_mod_available_enabled("tripadvisor");
        $this->data['addpermission'] = true;
        if ($this->role == "supplier" || $this->role == "admin") {
            $this->editpermission = pt_permissions("editflights", $this->data['userloggedin']);
            $this->deletepermission = pt_permissions("deleteflights", $this->data['userloggedin']);
            $this->data['addpermission'] = pt_permissions("addflights", $this->data['userloggedin']);
        }
        $this->data['all_countries'] = $this->Countries_model->get_all_countries();
        $this->load->helper('settings');
        $this->load->model('Admin/Accounts_model');
        $this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
        $this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');

    }

    function routes()
    {

        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_flights_routes');
        $xcrud->limit(50);
        $xcrud->unset_add();
        $xcrud->unset_edit();
        $xcrud->unset_remove();
        $xcrud->unset_view();
        $xcrud->button(base_url() . $this->data['adminsegment'] . '/kiwi/routes/manage/{setting_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
        $xcrud->column_pattern('tour_title', '<a href="' . base_url() . $this->data['adminsegment'] . '/kiwi/routes/manage/' . '">{value}</a>');

        $xcrud->join('setting_id', 'pt_flights_routes_setting', 'id', [], 'not_insert');
        $xcrud->columns(array('pt_flights_routes.from_location', 'pt_flights_routes.to_location', 'pt_flights_routes_setting.flightstatus', 'pt_flights_routes_setting.flight_mode', 'pt_flights_routes_setting.total_hours', 'pt_flights_routes.date_departure', 'pt_flights_routes.date_arrival', 'pt_flights_routes.time_departure', 'pt_flights_routes.time_arrival','pt_flights_routes_setting.test'));
        $xcrud->label(array('pt_flights_routes.from_location' => 'From', 'pt_flights_routes.to_location' => 'To', 'flightstatus' => 'Status', 'flight_mode' => 'Flight Type', 'total_hours' => 'Total Hours', 'pt_flights_routes.date_departure' => 'Departure Date', 'pt_flights_routes.date_arrival' => 'Date Arrival', 'pt_flights_routes.time_departure' => 'Time Departure', 'pt_flights_routes.time_arrival' => 'Time Arrival'));
        $xcrud->order_by('id', 'desc');
        $xcrud->where('type !=', '');
       $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Flights Management';
        $this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_flights_routes';
        $this->data['main_key'] = 'id';
        $this->data['header_title'] = 'Flights Management';
        $this->data['add_link'] = base_url() . $this->data['adminsegment'] . '/kiwi/routes/add';
        $this->load->view('Admin/template', $this->data);
    }

    function add()
    {
        $addtour = $this->input->post('submittype');
        $flightStatus = $this->input->post('flightstatus');
        $this->data['submittype'] = "add";
        $this->data['adultprice'] = "";
        $this->data['childprice'] = "0";
        $this->data['infantprice'] = "0";
        $this->data['flightmode'] = "oneway";
        $this->data['flight_type'] = "economy";
        $this->data['checkType'] = "add";

        $this->data['main_content'] = 'Kiwi/manage';
        $this->data['page_title'] = 'Add Flight';
        $this->data['headingText'] = 'Add Flight';
        $this->load->view('Admin/template', $this->data);

    }

    function manage($routeId)
    {

        $mianArray = array();
        $this->load->model('Kiwi/Flights_model');
        $this->data['tdata'] = $this->Flights_model->get_flight_data($routeId);

        if (empty ($this->data['tdata'])) {
            redirect('admin/routes');
        }
        $this->data['submittype'] = "manage";
        $this->data['checkType'] = "manage";
        $loca = json_decode($this->data['tdata'][0]->transact);
        $locations = array();
        for($i = 0;$i<count($loca);$i++)
        {
            array_push($locations, json_decode($loca[$i]));
        }
        $from_object = (object)["code" => $this->data['tdata'][0]->from_code, "label" => $this->data['tdata'][0]->from_location];
        array_unshift($locations, $from_object);
        $to_object = (object)["code" => $this->data['tdata'][0]->to_code, "label" => $this->data['tdata'][0]->to_location];
        array_push($locations, $to_object);

        $aeroplanes = json_decode($this->data['tdata'][0]->aero_trans);
        array_unshift($aeroplanes, $this->data['tdata'][0]->aero_dep);
        array_push($aeroplanes, $this->data['tdata'][0]->aero_arrival);

        $times = json_decode($this->data['tdata'][0]->time_trans);
        array_unshift($times, $this->data['tdata'][0]->time_arrival);
        array_push($times, $this->data['tdata'][0]->time_departure);

        $dates = json_decode($this->data['tdata'][0]->date_trans);
        array_unshift($dates, $this->data['tdata'][0]->date_departure);
        array_push($dates, $this->data['tdata'][0]->date_arrival);

        array_walk($dates, function (&$val, $key) {
            if(!empty($val))
            {
                list($year, $month, $day) = explode('-', $val);
                $val = sprintf('%s/%s/%s', $day, $month, $year);
            }

        });
        $adultprice = $this->data['tdata'][0]->adults_price;
        $childprice = $this->data['tdata'][0]->child_price;
        $infantprice = $this->data['tdata'][0]->infants_price;
        $price = (object)["adultprice" => $adultprice, "childprice" => $childprice, "infantprice" => $infantprice];

        $flight_no = json_decode($this->data['tdata'][0]->flight_no);
        $onewayArray = (object)["locations" => $locations, "aeroplanes" => $aeroplanes, "flight_no" => $flight_no, "dates" => $dates, "times" => $times, "price" => $price];
        array_push($mianArray, $onewayArray);

        $this->data['routeId'] = $routeId;
        $this->data['total_hours'] = $this->data['tdata'][0]->total_hours;
        $this->data['flightstatus'] = $this->data['tdata'][0]->flightstatus;
        $this->data['refundable'] = $this->data['tdata'][0]->refundable;
        $this->data['flight_type'] = $this->data['tdata'][0]->flight_type;
        $this->data['flightmode'] = $this->data['tdata'][0]->flight_mode;
        $this->data['desc_flight'] = $this->data['tdata'][0]->desc_flight;
        $this->data['deposite'] = $this->data['tdata'][0]->deposite;
        $this->data['tax'] = $this->data['tdata'][0]->tax;


        //Start Return
        if ($this->data['tdata'][0]->type == "return") {

            $loca = json_decode($this->data['tdata'][0]->transact);
            $locations = array();
            for($i = 0;$i<count($loca);$i++)
            {
                array_push($locations, json_decode($loca[$i]));
            }
            $from_object = (object)["code" => $this->data['tdata'][1]->from_code, "label" => $this->data['tdata'][1]->from_location];
            array_unshift($locations, $from_object);
            $to_object = (object)["code" => $this->data['tdata'][1]->to_code, "label" => $this->data['tdata'][1]->to_location];
            array_push($locations, $to_object);

            $aeroplanes = json_decode($this->data['tdata'][1]->aero_trans);
            array_unshift($aeroplanes, $this->data['tdata'][1]->aero_dep);
            array_push($aeroplanes, $this->data['tdata'][1]->aero_arrival);

            $times = json_decode($this->data['tdata'][1]->time_trans);
            array_unshift($times, $this->data['tdata'][1]->time_arrival);
            array_push($times, $this->data['tdata'][1]->time_departure);

            $dates = json_decode($this->data['tdata'][1]->date_trans);
            array_unshift($dates, $this->data['tdata'][1]->date_departure);
            array_push($dates, $this->data['tdata'][1]->date_arrival);

            array_walk($dates, function (&$val, $key) {
                if(!empty($val))
                {
                    list($year, $month, $day) = explode('-', $val);
                    $val = sprintf('%s/%s/%s', $day, $month, $year);
                }

            });
            $adultprice = $this->data['tdata'][1]->adults_price;
            $childprice = $this->data['tdata'][1]->child_price;
            $infantprice = $this->data['tdata'][1]->infants_price;
            $price = (object)["adultprice" => $adultprice, "childprice" => $childprice, "infantprice" => $infantprice];

            $flight_no = json_decode($this->data['tdata'][1]->flight_no);
            $onewayArray = (object)["locations" => $locations, "aeroplanes" => $aeroplanes, "flight_no" => $flight_no, "dates" => $dates, "times" => $times, "price" => $price];
            array_push($mianArray, $onewayArray);

        }

        //End Return

        $this->data["mainArray"] = $mianArray;


        $this->data['main_content'] = 'Kiwi/manage';
        $this->data['page_title'] = 'Manage Flight';
        $this->data['headingText'] = 'Manage Flight';
        $this->load->view('Admin/template', $this->data);

    }

    function add_post()
    {

        $this->load->model('Kiwi/Flights_model');
        $this->Flights_model->add_flight();
        echo '<div class="alert alert-success">' . "Successfully Save" . '</div><br>';
    }

    function manage_post()
    {
        $this->load->model('Kiwi/Flights_model');
        $this->Flights_model->update_flight();
        echo '<div class="alert alert-success">' . "Successfully Updated" . '</div><br>';

    }
}
