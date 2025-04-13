<?php

class Accounts_model extends CI_Model {

    function __construct() {
// Call the Model constructor
        parent :: __construct();
        $this->load->model('Admin/Emails_model');
    }

// Get all accounts active customers
    function get_active_customers() {
        $this->db->select('accounts_id,ai_first_name,ai_last_name,accounts_email,ai_mobile');
        $this->db->where('accounts_type', 'customers');
        $this->db->where('accounts_status', 'yes');
        $this->db->order_by('accounts_id', 'desc');
        $q = $this->db->get('pt_accounts')->result();
        return $q;
    }

    function update_profile($actype, $id, $filename = null) {

        $profileResult = new stdClass;
        $profileResult->noError = TRUE;
        $now = date("Y-m-d H:i:s");
        $permissions = $this->input->post('permissions');

        $oldphoto = $this->input->post('oldphoto');
        if ($filename != null) {
            $filename = $filename;
            if (!empty ($oldphoto)) {
                unlink(PT_USERS_IMAGES_UPLOAD . $oldphoto);
            }
        }
        else {
            $filename = "";
        }

        $isAdmin = $this->session->userdata('pt_logged_admin');

        if($isAdmin){

            if($actype == "supplier"){
                $appliedFor = json_encode(array("appliedfor" => $this->input->post('applyfor'), "name" => $this->input->post('itemname')));
            }else{
                $appliedFor = "";
            }

            $data3 = array('appliedfor' => $appliedFor);

        }else{
            $data3 = array();
        }

        $data1 = array('ai_title' => "", 'ai_first_name' => $this->input->post('fname'), 'ai_last_name' => $this->input->post('lname'),
// 'ai_dob' => $this->input->post('dob'),
            'ai_city' => $this->input->post('city'), 'ai_state' => $this->input->post('state'), 'ai_country' => $this->input->post('country'), 'ai_address_1' => $this->input->post('address1'), 'ai_address_2' => $this->input->post('address2'), 'ai_mobile' => $this->input->post('mobile'),
// 'ai_fax' => $this->input->post('fax'),
// 'ai_postal_code' => $this->input->post('postal_code'),
// 'ai_passport' => $this->input->post('passport'),
// 'ai_website' => $this->input->post('website'),
    'ai_image' => $filename, 'accounts_updated_at' => $now,
    'accounts_status' => $this->input->post('status'),
    'currency' => $this->input->post('currency'),
    'balance' => $this->input->post('balance'),
    'commission' => $this->input->post('commission'));
        if (!empty ($permissions)) {
            $permissions = implode(',', $permissions);
            $data2 = array('accounts_permissions' => $permissions);
        }


        if(!empty($permissions)){
            $data = array_merge($data1, $data2,$data3);
        }else{
            $data = array_merge($data1, $data3);
        }

        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);
        $oldemail = $this->input->post('oldemail');
        $newemail = $this->input->post('email');
        $password = $this->input->post('password');
        if ($oldemail != $newemail) {
            $this->db->select('accounts_email');
            $this->db->where('accounts_email', $newemail);
            $this->db->where('accounts_type', $actype);
            $nums = $this->db->get('pt_accounts')->num_rows();
            if ($nums > 0) {
                $profileResult->msg = "Email Already Exists";
                $profileResult->noError = FALSE;
            }
            else {
                $this->change_email($id);
                $profileResult->noError = TRUE;
            }
        }
        if (!empty ($password)) {
            $this->change_password($id);
        }
//hotels assignment
        $hotelsmod = isModuleActive("hotels");
        if ($hotelsmod) {
            $this->load->model('Hotels/Hotels_model');
            $this->Hotels_model->assignHotels($this->input->post('hotels'), $id);
        }

//tours assignment
        $toursmod = isModuleActive("tours");
        if ($toursmod) {
            $this->load->model('Tours/Tours_model');
            $this->Tours_model->assignTours($this->input->post('tours'), $id);
        }
//cars assignment
        $carsmod = isModuleActive("cars");
        if ($carsmod) {
            $this->load->model('Cars/Cars_model');
            $this->Cars_model->assignCars($this->input->post('cars'), $id);
        }

        return $profileResult;



    }

        function user_dashboard($id)
    {
        $dashboard = [];
        $this->db->select('balance,currency');
        $this->db->where('accounts_id', $id);
        $this->db->from('pt_accounts');
        $balance = $this->db->get()->row();

        $this->db->select('booking_status');
        $this->db->where('booking_user_id', $id);
        $this->db->from('hotels_bookings');
        $hotel_totel_booking = $this->db->get()->num_rows();

        $this->db->select('booking_status');
        $this->db->where('booking_user_id', $id);
        $this->db->where('booking_status', 'pending');
        $this->db->from('hotels_bookings');
        $hotel_pending_nvoices = $this->db->get()->num_rows();


        $this->db->select('booking_status');
        $this->db->where('booking_user_id', $id);
        $this->db->from('flights_bookings');
        $flight_totel_booking = $this->db->get()->num_rows();

        $this->db->select('booking_status');
        $this->db->where('booking_user_id', $id);
        $this->db->where('booking_status', 'pending');
        $this->db->from('flights_bookings');
        $flight_pending_nvoices = $this->db->get()->num_rows();
        return $dashboard = array(
            'currency'=> $balance->currency,
            'balance'=> intval($balance->balance),
            'totel_booking'=> $flight_totel_booking+$hotel_totel_booking,
            'pending_nvoices'=> $hotel_pending_nvoices+$flight_pending_nvoices
        );

    }
//update customer profile
    function update_profile_customer($id){
        $now = date("Y-m-d H:i:s");
        $data = array('ai_title' => "", 'ai_first_name' => $this->input->post('firstname'), 'ai_last_name' => $this->input->post('lastname'), 'ai_city' => $this->input->post('city'), 'ai_state' => $this->input->post('state'), 'ai_country' => $this->input->post('country'), 'ai_address_1' => $this->input->post('address1'), 'ai_address_2' => $this->input->post('address2'), 'ai_mobile' => $this->input->post('phone'), 'ai_fax' => $this->input->post('fax'), 'ai_postal_code' => $this->input->post('zip'), 'accounts_updated_at' => $now);
        $data1 = array();
        $email = $this->input->post('email');
        if(!empty($email)){
            $data1 = array('accounts_email' => $email);
        }

        $dataall = array_merge($data,$data1);
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $dataall);
        $password = $this->input->post('password');
        if (!empty ($password)) {
            $this->change_password($id);
        }
    }

// Add New Account
    function add_account($filename = null) {
        $now = date('Y-m-d H:i:s');
        $permissions = implode(',', $this->input->post('permissions'));
        $type = $this->input->post('type');
        if ($type == "admin") {
            $isadmin = '1';
        }
        else {
            $isadmin = '0';
        }

        if($type == "supplier"){
            $appliedFor = json_encode(array("appliedfor" => $this->input->post('applyfor'), "name" => $this->input->post('itemname')));
        }else{
            $appliedFor = "";
        }

        $data = array('accounts_email' => $this->input->post('email'), 'accounts_password' => sha1($this->input->post('password')), 'accounts_type' => $type, 'accounts_is_admin' => $isadmin, 'ai_title' => "", 'ai_first_name' => $this->input->post('fname'), 'ai_last_name' => $this->input->post('lname'), 'ai_dob' => $this->input->post('dob'), 'ai_city' => $this->input->post('city'), 'ai_country' => $this->input->post('country'), 'ai_state' => $this->input->post('state'), 'ai_address_1' => $this->input->post('address1'), 'ai_address_2' => $this->input->post('address2'), 'ai_mobile' => $this->input->post('mobile'), 'ai_fax' => $this->input->post('fax'), 'ai_postal_code' => $this->input->post('postal_code'), 'ai_passport' => $this->input->post('passport'), 'ai_website' => $this->input->post('website'), 'ai_image' => $filename, 'accounts_created_at' => $now, 'accounts_updated_at' => $now, 'accounts_status' => $this->input->post('status'), 'accounts_permissions' => $permissions,'appliedfor' => $appliedFor,'commission' => $this->input->post('commission'));
        $this->db->insert('pt_accounts', $data);
        $userid = $this->db->insert_id();
        //hotels Assign
        $hotelsmod = $this->ptmodules->is_mod_available_enabled("hotels");
        if ($hotelsmod) {
            $this->load->model('Hotels/Hotels_model');
            $this->Hotels_model->assignHotels($this->input->post('hotels'), $userid);
        }

        //tours assignment
        $toursmod = $this->ptmodules->is_mod_available_enabled("tours");
        if ($toursmod) {
            $this->load->model('Tours/Tours_model');
            $this->Tours_model->assignTours($this->input->post('tours'), $userid);
        }

        //car assignment
        $carsmod = $this->ptmodules->is_mod_available_enabled("cars");
        if ($carsmod) {
            $this->load->model('Cars/Cars_model');
            $this->Cars_model->assignCars($this->input->post('cars'), $userid);
        }
    }

// Add New supplier from fornt end register page
    function register_supplier() {
        $now = date('Y-m-d H:i:s');
        $appliedFor = json_encode(array("appliedfor" => $this->input->post('applyfor'), "name" => $this->input->post('itemname')));

        $password = rand(5, 15);
        $data = array('accounts_email' => $this->input->post('email'), 'accounts_password' => $password, 'accounts_type' => "supplier", 'accounts_is_admin' => 0, 'ai_title' => "", 'ai_first_name' => $this->input->post('fname'), 'ai_last_name' => $this->input->post('lname'), 'ai_city' => $this->input->post('city'), 'ai_country' => $this->input->post('country'), 'ai_state' => $this->input->post('state'), 'ai_address_1' => $this->input->post('address1'), 'ai_address_2' => $this->input->post('address2'), 'ai_mobile' => $this->input->post('mobile'),
//  'ai_image' => $filename,
            'accounts_created_at' => $now, 'accounts_updated_at' => $now, 'appliedfor' => $appliedFor,'accounts_verified' => 0, 'accounts_status' => 'yes');
        $this->db->insert('pt_accounts', $data);
        $name = $this->input->post('fname') . " " . $this->input->post('lname');
        $adata = array("email" => $this->input->post('email'), "name" => $name, "phone" => $this->input->post('mobile'), "address" => $this->input->post('address1'));
        $this->Emails_model->new_supplier_email($adata);
        $this->Emails_model->supplier_signup($adata);
    }

// Delete Account
    function delete_account($id) {
        $this->db->select('ai_image');
        $this->db->where('accounts_id', $id);
        $img = $this->db->get('pt_accounts')->result();
        $image = $img[0]->ai_image;

        if (!empty ($image)) {
            unlink(PT_USERS_IMAGES_UPLOAD . $image);
        }
        $this->db->where('accounts_id', $id);
        $this->db->delete('pt_accounts');
        $this->updateItemOwnedBy($id);

    }
    function getCommissionHotels($id,$commision){
        $this->db->where('hotel_owned_by', $id);
        $this->db->join('pt_bookings','pt_bookings.booking_item = hotel_id');
        $this->db->join('pt_payouts_invoice','pt_payouts_invoice.invoice_id = pt_bookings.booking_id','left');
        $this->db->where('payouts_id',null);
        $this->db->where('booking_status','paid');
        $results = $this->db->get('pt_hotels')->result();
        $final_commision = 0 ;
        foreach ($results as $item){
            $commision_amount = $item->booking_total/100;
            $commision_amount = $commision_amount * $commision;
            $final_commision = + $commision_amount;
        }
        return $final_commision;
    }
    function getCommissionCars($id,$commision){
        $this->db->where('car_owned_by', $id);
        $this->db->join('pt_bookings','pt_bookings.booking_item = car_id');
        $this->db->join('pt_payouts_invoice','pt_payouts_invoice.invoice_id = pt_bookings.booking_id','left');
        $this->db->where('payouts_id',null);
        $this->db->where('booking_status','paid');
        $results = $this->db->get('pt_cars')->result();
        $final_commision = 0 ;
        foreach ($results as $item){
            $commision_amount = $item->booking_total/100;
            $commision_amount = $commision_amount * $commision;
            $final_commision = + $commision_amount;
        }
        return $final_commision;
    }
    function getCommissionTours($id,$commision){
        $this->db->where('tour_owned_by', $id);
        $this->db->join('pt_bookings','pt_bookings.booking_item = tour_id');
        $this->db->join('pt_payouts_invoice','pt_payouts_invoice.invoice_id = pt_bookings.booking_id','left');
        $this->db->where('payouts_id',null);
        $this->db->where('booking_status','paid');
        $results = $this->db->get('pt_tours')->result();
        $final_commision = 0 ;
        foreach ($results as $item){
            $commision_amount = $item->booking_total/100;
            $commision_amount = $commision_amount * $commision;
            $final_commision = + $commision_amount;
        }
        return $final_commision;
    }

    function UpdateCommissionHotels($id){
        $this->db->where('accounts_id', $id);
        $result = $this->db->get('pt_accounts')->row();

        $this->db->where('hotel_owned_by', $id);
        $this->db->join('pt_bookings','pt_bookings.booking_item = hotel_id');
        $this->db->join('pt_payouts_invoice','pt_payouts_invoice.invoice_id = pt_bookings.booking_id','left');
        $this->db->where('payouts_id',null);
        $this->db->where('booking_status','paid');
        $results = $this->db->get('pt_hotels')->result();
        $final_commision = 0 ;
        foreach ($results as $item){
            $commision_amount = $item->booking_total/100;
            $commision_amount = $commision_amount * $result->commission;
            $final_commision = + $commision_amount;
        }
        $payouts_array = array(
            "amount"=>$final_commision,
            "supplier_id"=>$id,
            "status"=>"paid",
            "module"=>'hotels'
        );
        $this->db->insert('pt_payouts',$payouts_array);
        $last_id = $this->db->insert_id();

        foreach ($results as $item){
            $payouts_invoices = array(
                "invoice_id"=>$item->booking_id,
                "payouts_id"=>$last_id,
            );
            $this->db->insert('pt_payouts_invoice',$payouts_invoices);
        }

        return $final_commision;
    }
    function UpdateComissionTours($id){
        $this->db->where('accounts_id', $id);
        $result = $this->db->get('pt_accounts')->row();

        $this->db->where('tour_owned_by', $id);
        $this->db->join('pt_bookings','pt_bookings.booking_item = tour_id');
        $this->db->join('pt_payouts_invoice','pt_payouts_invoice.invoice_id = pt_bookings.booking_id','left');
        $this->db->where('payouts_id',null);
        $this->db->where('booking_status','paid');
        $results = $this->db->get('pt_tours')->result();
        $final_commision = 0 ;
        foreach ($results as $item){
            $commision_amount = $item->booking_total/100;
            $commision_amount = $commision_amount * $result->commission;
            $final_commision = + $commision_amount;
        }
        $payouts_array = array(
            "amount"=>$final_commision,
            "supplier_id"=>$id,
            "status"=>"paid",
            "module"=>'tours'
        );
        $this->db->insert('pt_payouts',$payouts_array);
        $last_id = $this->db->insert_id();

        foreach ($results as $item){
            $payouts_invoices = array(
                "invoice_id"=>$item->booking_id,
                "payouts_id"=>$last_id,
            );
            $this->db->insert('pt_payouts_invoice',$payouts_invoices);
        }

        return $final_commision;
    }
    function UpdateComissionCars($id){
        $this->db->where('accounts_id', $id);
        $result = $this->db->get('pt_accounts')->row();

        $this->db->where('car_owned_by', $id);
        $this->db->join('pt_bookings','pt_bookings.booking_item = car_id');
        $this->db->join('pt_payouts_invoice','pt_payouts_invoice.invoice_id = pt_bookings.booking_id','left');
        $this->db->where('payouts_id',null);
        $this->db->where('booking_status','paid');
        $results = $this->db->get('pt_cars')->result();
        $final_commision = 0 ;
        foreach ($results as $item){
            $commision_amount = $item->booking_total/100;
            $commision_amount = $commision_amount * $result->commission;
            $final_commision = + $commision_amount;
        }
        $payouts_array = array(
            "amount"=>$final_commision,
            "supplier_id"=>$id,
            "status"=>"paid",
            "module"=>'cars'
        );
        $this->db->insert('pt_payouts',$payouts_array);
        $last_id = $this->db->insert_id();

        foreach ($results as $item){
            $payouts_invoices = array(
                "invoice_id"=>$item->booking_id,
                "payouts_id"=>$last_id,
            );
            $this->db->insert('pt_payouts_invoice',$payouts_invoices);
        }

        return $final_commision;
    }

// Disable Account
    function disable_account($id) {
        $data = array('accounts_status' => 'no');
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);
    }

// Enable Account
    function approveAccount($id) {
        $data = array('accounts_status' => 'yes');
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);
    }

// remove profile image
    function remove_profile_image($userid, $oldphoto) {
        $data = array('ai_image' => '');
        $this->db->where('accounts_id', $userid);
        $this->db->update('pt_accounts', $data);
        unlink(PT_USERS_IMAGES_UPLOAD . $oldphoto);
    }

// Get all accounts data by type for example staff, customer, manager etc.
    function get_accounts_data($type) {
        $this->db->where('accounts_type', $type);
        $this->db->order_by('accounts_id', 'desc');
        $query = $this->db->get('pt_accounts');
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

// get all bookings with limit
    function get_accounts_data_limit($type, $perpage = null, $offset = null, $orderby = null) {
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->where('accounts_type', $type);
        $this->db->order_by('accounts_id', 'desc');
        $query = $this->db->get('pt_accounts', $perpage, $offset);
        $data['all'] = $query->result();
// $data['nums'] = $query->num_rows();
        return $data;
    }

// get all accounts info  by search for admin
    function search_all_accounts_limit($term, $type, $perpage = null, $offset = null, $orderby = null) {
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->like('accounts_email', $term);
        $this->db->or_like('ai_address_1', $term);
        $this->db->or_like('ai_address_2', $term);
        $this->db->or_like('ai_last_name', $term);
        $this->db->or_like('ai_first_name', $term);
        $this->db->order_by('accounts_id', 'desc');
        $this->db->having('accounts_type', $type);
        $query = $this->db->get('pt_accounts', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

// get all accounts info  by advance search for
    function adv_search_all_accounts_limit($data, $perpage = null, $offset = null, $orderby = null) {
        $country = $data["country"];
        $firstname = $data["firstname"];
        $lastname = $data["lastname"];
        $status = $data["status"];
        $type = $data["acctype"];
        $country = $data["country"];
        $email = $data["email"];
        $modules = explode(",", $data["modules"]);
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        if (!empty ($firstname)) {
            $this->db->like('ai_first_name', $firstname);
        }
        if (!empty ($lastname)) {
            $this->db->like('ai_last_name', $lastname);
        }
        if (!empty ($country)) {
            $this->db->where('ai_country', $country);
        }
        if (!empty ($modules)) {
            foreach ($modules as $m) {
                $this->db->like('accounts_permissions', $m);
            }
        }
        if (!empty ($email)) {
            $this->db->like('accounts_email', $email);
        }
        $this->db->where('accounts_status', $status);
        $this->db->order_by('accounts_id', 'desc');
        $this->db->where('accounts_type', $type);
        $query = $this->db->get('pt_accounts', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

// get profile details
    function get_profile_details($id) {
        $this->db->where('accounts_id', $id);
        $q = $this->db->get('pt_accounts')->result();
        return $q;
    }

// get email and name only
    function get_name_email($id) {
        $this->db->select('accounts_email,ai_first_name,ai_last_name,ai_mobile');
        $this->db->where('accounts_id', $id);
        $q = $this->db->get('pt_accounts')->result();
        return $q;
    }

// get user email
    function get_user_email($id) {
        $this->db->select('accounts_email');
        $this->db->where('accounts_id', $id);
        $q = $this->db->get('pt_accounts')->result();
        return $q[0]->accounts_email;
    }

// change email address
    function change_email($id) {
        $data = array('accounts_email' => $this->input->post('email'));
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);
    }

// change Password
    function change_password($id) {
        $data = array('accounts_password' => sha1($this->input->post('password')));
        $this->db->where('accounts_id', $id);
        $this->db->update('pt_accounts', $data);
    }

// Admin login
    function login_admin($username, $password) {
        $remember = $this->input->post('remember');
        $this->db->select('accounts_email,accounts_password,accounts_id,accounts_type,ai_first_name,ai_last_name');
        $this->db->where('accounts_email', $username);
        $this->db->where('accounts_password', sha1($password));
        $this->db->where('accounts_is_admin', '1');
        $this->db->where('accounts_status', 'yes');
        $q = $this->db->get('pt_accounts');
        $user = $q->result();
        $num = $q->num_rows();
        if ($num > 0) {
            if (empty ($remember)) {
                $this->session->sess_expire_on_close = TRUE;
            }
            $this->session->set_userdata('pt_logged_admin', $user[0]->accounts_id);
            $this->session->set_userdata('pt_logged_id', $user[0]->accounts_id);
            if ($user[0]->accounts_type == "webadmin") {
                $this->session->set_userdata('pt_logged_super_admin', 'superadmin');
                $this->session->set_userdata('pt_accountType', 'Super Admin');
            }
            else {
                $this->session->set_userdata('pt_accountType', 'Admin');
            }
            $this->session->set_userdata('pt_logged_time', time());
            $this->session->set_userdata('pt_role', $user[0]->accounts_type);
            $this->session->set_userdata('fullName', $user[0]->ai_first_name . " " . $user[0]->ai_last_name);
            // return $user;
            return true;
        }
        else {
            //return $user;
            return false;
        }
    }

// supplier login
    function login_supplier($username, $password) {
        $remember = $this->input->post('remember');
        $this->db->select('accounts_email,accounts_password,accounts_id,accounts_type,ai_first_name,ai_last_name');
        $this->db->where('accounts_email', $username);
        $this->db->where('accounts_password', sha1($password));
        $this->db->where('accounts_type', 'supplier');
        $this->db->where('accounts_status', 'yes');
        $q = $this->db->get('pt_accounts');
        $user = $q->result();
        $num = $q->num_rows();
        if ($num > 0) {
            if (empty ($remember)) {
                $this->session->sess_expire_on_close = TRUE;
            }
            $this->session->set_userdata('pt_logged_supplier', $user[0]->accounts_id);
            $this->session->set_userdata('pt_logged_id', $user[0]->accounts_id);
            $this->session->set_userdata('pt_accountType', 'Supplier');
            $this->session->set_userdata('pt_logged_time', time());
            $this->session->set_userdata('pt_role', $user[0]->accounts_type);
            $this->session->set_userdata('fullName', $user[0]->ai_first_name . " " . $user[0]->ai_last_name);
            return true;
        }
        else {
            return false;
        }
    }

//login
    function login_customer($username, $password) {
        $remember = $this->input->post('remember');
        $this->db->select('accounts_email,accounts_password,accounts_id,ai_first_name');
        $this->db->where('accounts_email', $username);
        $this->db->where('accounts_password', sha1($password));
        $this->db->where('accounts_type', 'customers');
        $this->db->where('accounts_status', 'yes');
        $q = $this->db->get('pt_accounts');
        $user = $q->result();
        $num = $q->num_rows();
        if ($num > 0) {
            if (empty ($remember)) {
                $this->session->sess_expire_on_close = TRUE;
            }
            $this->session->set_userdata('pt_logged_customer', $user[0]->accounts_id);
            $this->session->set_userdata('fname', $user[0]->ai_first_name);
            $this->session->set_userdata('pt_role', $user[0]->accounts_type);
            return true;
        }
        else {
            return false;
        }
    }

    function login_facebook($userdata) {
        $id = $userdata['id'];
        $email = $userdata['email'];
        $fname = $userdata['first_name'];
        $lname = $userdata['last_name'];
        $this->db->select('facebook_id,accounts_id,ai_first_name');
        $this->db->where('facebook_id', $id);
        $this->db->where('accounts_type', 'customers');
        $this->db->where('accounts_status', 'yes');
        $q = $this->db->get('pt_accounts');
        $user = $q->result();
        $num = $q->num_rows();
        if ($num > 0) {
            $this->session->set_userdata('pt_logged_customer', $user[0]->accounts_id);
            $this->session->set_userdata('fname', $user[0]->ai_first_name);
            $this->session->set_userdata('pt_role', $user[0]->accounts_type);
            return true;
        }
        elseif (!empty ($userdata)) {
            $now = date('Y-m-d H:i:s');
            $insertdata = array('accounts_email' => $email, 'facebook_id' => $id, 'ai_first_name' => $fname, 'ai_last_name' => $lname, 'facebook_id' => $id, 'accounts_type' => 'customers', 'accounts_status' => 'yes', 'accounts_verified' => '1', 'accounts_created_at' => $now, 'accounts_updated_at' => $now,);
            $this->db->insert('pt_accounts', $insertdata);
            $userid = $this->db->insert_id();
            $this->session->set_userdata('pt_logged_customer', $userid);
            return true;
        }
        else {
            return false;
        }
    }

// Signup account
    function signup_account($type, $status) {
        $address = $this->input->post('address');
        if(empty($address)){
            $address = "";
        }
        $now = date('Y-m-d H:i:s');
        $verified = '1';
        $password = $this->input->post('password');

        if (empty ($password)) {
            $password = rand(5, 15);
        }
        if ($type == "customers") {
            $city = "";
            if($status == "no"){
                $verified = '0';
            }

        }
        else {
            $city = $this->input->post('city');
        }
        $data = array('accounts_email' => $this->input->post('email'), 'accounts_password' => sha1($password), 'accounts_type' => $type, 'ai_title' => "", 'ai_first_name' => $this->input->post('firstname'), 'ai_last_name' => $this->input->post('lastname'),'ai_address_1' => $address, 'ai_city' => $city, 'ai_country' => $this->input->post('country'), 'ai_mobile' => $this->input->post('phone'), 'accounts_created_at' => $now, 'accounts_updated_at' => $now,'accounts_verified' => $verified, 'accounts_status' => $status);
        $this->db->insert('pt_accounts', $data);
        $id = $this->db->insert_id();
        if ($type == "customers") {
            if($status == "yes"){
                $this->session->set_userdata('pt_logged_customer', $id);
                $this->session->set_userdata('fname', $this->input->post('firstname'));
                $this->session->set_userdata('pt_role', $type);
            }

        }
        return $id;
    }

// Signup account via API
    function apisignup_account($userdata, $type = null) {
        $this->db->where('accounts_email',$userdata['email']);
        $nums = $this->db->get('pt_accounts')->num_rows();

        if($nums > 0){
            return FALSE;
        }else{

            $now = date('Y-m-d H:i:s');
            if(!empty($type)){
                $password = $userdata['password'];
                $accountStatus = 'yes';

            }

            $data = array('accounts_email' => $userdata['email'], 'accounts_password' => sha1($password), 'accounts_type' => $type, 'ai_first_name' => $userdata['first_name'], 'ai_last_name' => $userdata['last_name'], 'ai_mobile' => $userdata['phone'], 'ai_address_1' => $userdata['address'], 'accounts_created_at' => $now, 'accounts_updated_at' => $now, 'accounts_status' => $accountStatus);
            $this->db->insert('pt_accounts', $data);
            $id = $this->db->insert_id();
            return $id;

        }

    }



// List all bookings on account my bookings page
    function get_my_bookings($invoice_id) {
        $hotel_arr = [];
        $this->db->select();
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        if (!empty($invoice_id)) {
        $this->db->where('hotels_bookings.booking_ref_no', $invoice_id);}
        $this->db->join('pt_accounts', 'hotels_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $hotels_bookings=$this->db->get('hotels_bookings')->result();

        foreach ($hotels_bookings as $hotels) {
            array_push($hotel_arr,(object) [
                'booking_id'=>$hotels->booking_id,
                'booking_ref_no'=>$hotels->booking_ref_no,
                'module'=>'hotels',
                'paymethod'=>$hotels->booking_payment_gateway,
                'nights'=>$hotels->booking_nights,
                'checkin'=>$hotels->booking_checkin,
                'checkout'=>$hotels->booking_checkout,
                'date'=>pt_show_date_php($hotels->booking_date),
                'currCode'=>$hotels->booking_curr_code,
                'currSymbol'=>'',
                'checkoutAmount'=>$hotels->booking_deposit,
                'checkoutTotal'=>$hotels->total_price,
                'status'=>$hotels->booking_status,
                'bookingUser'=>$hotels->booking_user_id,
                'userFullName'=>$hotels->ai_first_name . " " . $hotels->ai_last_name,
                'accountEmail'=>$hotels->accounts_email,
                'userMobile'=>$hotels->ai_mobile,
                'userCountry'=>$hotels->ai_country,
                'userAddress'=>$hotels->ai_address_1. " " . $hotels->ai_address_2,
                "additionaNotes" => $hotels->booking_additional_notes,
                "couponCode" => $hotels->booking_coupon,
                "remainingAmount" => $hotels->booking_remaining,
                "guestInfo" => json_decode($hotels->booking_guest_info),
                'tax'=>$hotels->booking_tax,
                'amountPaid'=>$hotels->booking_amount_paid,
                'booking_payment_status'=>$hotels->booking_payment_status,
            ]);
        }
        $flights_arr = [];
        $this->db->select();
        $this->db->order_by('flights_bookings.booking_id', 'desc');
        if (!empty($invoice_id)) {
        $this->db->where('flights_bookings.booking_ref_no', $invoice_id);}
        $this->db->join('pt_accounts', 'flights_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $flights_bookings=$this->db->get('flights_bookings')->result();

        foreach ($flights_bookings as $flights) {
            array_push($flights_arr,(object) [
                'booking_id'=>$flights->booking_id,
                'booking_ref_no'=>$flights->booking_ref_no,
                'module'=>'flights',
                'paymethod'=>$flights->booking_payment_gateway,
                'nights'=>$flights->booking_nights,
                'checkin'=>$flights->booking_checkin,
                'checkout'=>$flights->booking_checkout,
                'date'=>pt_show_date_php($flights->booking_date),
                'currCode'=>$flights->booking_curr_code,
                'currSymbol'=>'',
                'checkoutAmount'=>$flights->booking_deposit,
                'checkoutTotal'=>$flights->total_price,
                'status'=>$flights->booking_status,
                'bookingUser'=>$flights->booking_user_id,
                'userFullName'=>$flights->ai_first_name . " " . $hotels->ai_last_name,
                'accountEmail'=>$flights->accounts_email,
                'userMobile'=>$flights->ai_mobile,
                'userCountry'=>$flights->ai_country,
                'userAddress'=>$flights->ai_address_1. " " . $hotels->ai_address_2,
                "additionaNotes" => $hotels->booking_additional_notes,
                "couponCode" => $hotels->booking_coupon,
                "remainingAmount" => $hotels->booking_remaining,
                "guestInfo" => json_decode($flights->booking_guest_info),
                'tax'=>$flights->booking_tax,
                'amountPaid'=>$flights->booking_amount_paid,
                'booking_payment_status'=>$flights->booking_payment_status,
            ]);
        }
        return array_merge($hotel_arr,$flights_arr);
    }


// List all user bookings on account my bookings page
    function get_user_bookings($id) {
        $this->load->helper('invoice');
        $hotel_arr = [];
        $this->db->select();
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        if (!empty($id)) {
        $this->db->where('pt_accounts.accounts_id', $id);}
        $this->db->join('pt_accounts', 'hotels_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $hotels_bookings=$this->db->get('hotels_bookings')->result();

        foreach ($hotels_bookings as $hotels) {
            array_push($hotel_arr,(object) [
                'booking_id'=>$hotels->booking_id,
                'booking_ref_no'=>$hotels->booking_ref_no,
                'module'=>'hotels',
                'ai_first_name'=>$hotels->ai_first_name,
                'booking_status'=>$hotels->booking_status,
                'booking_payment_status'=>$hotels->booking_payment_status,
                'booking_date'=>pt_show_date_php($hotels->booking_date),
                'booking_curr_code'=>$hotels->booking_curr_code,
                'total_price'=>$hotels->total_price
            ]);
        }
        $flights_arr = [];
        $this->db->select();
        $this->db->order_by('flights_bookings.booking_id', 'desc');
        if (!empty($id)) {
        $this->db->where('pt_accounts.accounts_id', $id);}
        $this->db->join('pt_accounts', 'flights_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $flights_bookings=$this->db->get('flights_bookings')->result();

        foreach ($flights_bookings as $flights) {
            array_push($flights_arr,(object) [
                'booking_id'=>$flights->booking_id,
                'booking_ref_no'=>$flights->booking_ref_no,
                'module'=>'flights',
                'ai_first_name'=>$flights->ai_first_name,
                'booking_status'=>$flights->booking_status,
                'booking_payment_status'=>$flights->booking_payment_status,
                'booking_date'=>pt_show_date_php($flights->booking_date),
                'booking_curr_code'=>$flights->booking_curr_code,
                'total_price'=>$flights->total_price
            ]);
        }
        return array_merge($hotel_arr,$flights_arr);
    }

// My wishlist
    function my_wishlist($user) {
        $this->db->where('wish_user', $user);
        $this->db->order_by('wish_id', 'desc');
        $res = $this->db->get('pt_wishlist')->result();
        $wishes = array();
        foreach ($res as $rs) {
            $lib = ucfirst($rs->wish_module) . "_lib";
            $this->load->library(ucfirst($rs->wish_module) . "/" . $lib);
            $retData = $this->$lib->wishListInfo($rs->wish_itemid);
            $wishes[] = (object) array('wishid' => $rs->wish_id, 'title' => $retData['title'], 'slug' => $retData['slug'], 'thumbnail' => $retData['thumbnail'], 'location' => $retData['location'], 'stars' => $retData['stars'], 'date' => pt_show_date_php($rs->wish_date));
        }
        return $wishes;
    }

    function dashboard_stats() {
        $sdata = array();
        $sdata['hotels'] = $this->db->count_all('pt_hotels');
        $sdata['blog'] = $this->db->count_all('pt_blog');
        $sdata['tours'] = $this->db->count_all('pt_tours');
        $sdata['cars'] = $this->db->count_all('pt_cars');
        $sdata['extras'] = $this->db->count_all('pt_extras');
        $sdata['reviews'] = $this->db->count_all('pt_reviews');
        $sdata['offers'] = $this->db->count_all('pt_special_offers');
        $sdata['newsletter'] = $this->db->count_all('pt_newsletter');
        $sdata['coupons'] = $this->db->count_all('pt_coupons');
        $this->db->where('accounts_type', 'customers');
        $this->db->from('pt_accounts');
        $sdata['customers'] = $this->db->count_all_results();
        $this->db->where('accounts_type', 'subadmins');
        $this->db->from('pt_accounts');
        $sdata['subadmins'] = $this->db->count_all_results();
        $this->db->where('accounts_type', 'supplier');
        $this->db->from('pt_accounts');
        $sdata['supplier'] = $this->db->count_all_results();
        return $sdata;
    }

// get admin notes and details like image and name etc
    function admin_notes_image($id) {
        $this->db->select('pt_admin_notes.notes_desc,pt_admin_notes.notes_user,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email,pt_accounts.ai_title,pt_accounts.ai_image,pt_accounts.accounts_last_login');
        $this->db->join('pt_admin_notes', 'pt_accounts.accounts_id = pt_admin_notes.notes_user', 'left');
        $this->db->where('pt_accounts.accounts_id', $id);
        return $this->db->get('pt_accounts')->result();
    }
//add admin notes

    public function add_admin_notes($id) {
        $data = array('notes_user' => $id, 'notes_desc' => $this->input->post('notes'));
        $this->db->insert('pt_admin_notes', $data);
    }
//update admin notes

    public function update_admin_notes($id) {
        $data = array('notes_desc' => $this->input->post('notes'));
        $this->db->where('notes_user', $id);
        $this->db->update('pt_admin_notes', $data);
    }

    function verify_account($userid, $accType = null) {
        $pass = random_string('alnum', 8);
        if($accType == "customers"){

            $data = array('accounts_verified' => 1, 'accounts_status' => 'yes');
        }else{

            $data = array('accounts_verified' => 1, 'accounts_status' => 'yes', 'accounts_password' => sha1($pass));
        }

        $this->db->where('accounts_id', $userid);
        $this->db->update('pt_accounts', $data);
        $udata = $this->get_name_email($userid);
        $to = $udata[0]->accounts_email;
        $name = $udata[0]->ai_first_name . " " . $udata[0]->ai_first_name;
        $phone = $udata[0]->ai_mobile;
        $this->Emails_model->email_verified($to, $pass, $name, $phone, $accType);
    }

    function updateItemOwnedBy($id){

        $hdata = array('hotel_owned_by' => '1');
        $this->db->where('hotel_owned_by',$id);
        $this->db->update('pt_hotels',$hdata);

        $tdata = array('tour_owned_by' => '1');
        $this->db->where('tour_owned_by',$id);
        $this->db->update('pt_tours',$tdata);

        $cdata = array('car_owned_by' => '1');
        $this->db->where('car_owned_by',$id);
        $this->db->update('pt_cars',$cdata);

    }

}
