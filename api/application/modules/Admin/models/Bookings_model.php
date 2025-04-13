<?php

class Bookings_model extends CI_Model {
    private $data = array();

    function __construct() {
        // Call the Model constructor
        parent :: __construct();
        $this->load->model('Admin/Accounts_model');
        $this->load->model('Admin/Emails_model');
        // $this->load->model('Viator/Viator');
        $this->data['app_settings'] = $this->Settings_model->get_settings_data();
        $this->load->helper('invoice');
    }

    function admin_get_all_bookings($booking_status,$booking_payment_status) {
        $hotel_arr = [];
        $this->db->select();
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        if (!empty($booking_status)) {
        $this->db->where('hotels_bookings.booking_status', $booking_status);
        }if (!empty($booking_payment_status)) {
        $this->db->where('hotels_bookings.booking_payment_status', $booking_payment_status);
        }
        $this->db->join('pt_accounts', 'hotels_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $hotels_bookings=$this->db->get('hotels_bookings')->result();

        foreach ($hotels_bookings as $hotels) {
            array_push($hotel_arr,(object) [
                'booking_id'=>$hotels->booking_id,
                'booking_ref_no'=>$hotels->booking_ref_no,
                'module'=>'hotels',
                'ai_first_name'=>$hotels->ai_first_name,
                'supplier_name'=>$hotels->supplier_name,
                'booking_from'=> $hotels->booking_from,
                'booking_status'=>$hotels->booking_status,
                'booking_payment_status'=>$hotels->booking_payment_status,
                'booking_date'=>$hotels->booking_date,
                'booking_curr_code'=>$hotels->booking_curr_code,
                'total_price'=>$hotels->total_price
            ]);
        }
        $flights_arr = [];
        $this->db->select();
        $this->db->order_by('flights_bookings.booking_id', 'desc');
        if (!empty($booking_status)) {
        $this->db->where('flights_bookings.booking_status', $booking_status);
        }if (!empty($booking_payment_status)) {
        $this->db->where('flights_bookings.booking_payment_status', $booking_payment_status);
        }
        $this->db->join('pt_accounts', 'flights_bookings.booking_user_id = pt_accounts.accounts_id', 'left');
        $flights_bookings=$this->db->get('flights_bookings')->result();

        foreach ($flights_bookings as $flights) {
            array_push($flights_arr,(object) [
                'booking_id'=>$flights->booking_id,
                'booking_ref_no'=>$flights->booking_ref_no,
                'module'=>'flights',
                'ai_first_name'=>$flights->ai_first_name,
                'supplier_name'=>$flights->supplier_name,
                'booking_from'=> $flights->booking_from,
                'booking_status'=>$flights->booking_status,
                'booking_payment_status'=>$flights->booking_payment_status,
                'booking_date'=>$flights->booking_date,
                'booking_curr_code'=>$flights->booking_curr_code,
                'total_price'=>$flights->total_price
            ]);
        }
        return array_merge($hotel_arr,$flights_arr);
    }

/*booking status update*/
    function update_booking_status($booking_id, $module, $booking_status){
        $table_name = $module.'_bookings';
        $data=array('booking_status'=>$booking_status);
        $result = $this->db->where('booking_id',$booking_id)->update($table_name,$data);
        return $result;
    }

    function update_paybooking_status($booking_id, $module, $booking_payment_status){
        $table_name = $module.'_bookings';
        $data=array('booking_payment_status'=>$booking_payment_status);
        $result = $this->db->where('booking_id',$booking_id)->update($table_name,$data);
        return $result;
    }

function booking_del($booking_id, $module){
        $table_name = $module.'_bookings';
        $result = $this->db->where('booking_id',$booking_id)->delete($table_name);
        return $result;
    }
/*END booking status update*/



    // get all bookings
    function get_all_bookings_back_admin() {
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
                pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
                booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings');
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    // get all bookings with limit
    function get_all_bookings_back_limit_admin($perpage = null, $offset = null, $orderby = null) {
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings', $perpage, $offset);
        $data['all'] = $query->result();
        // $data['nums'] = $query->num_rows();
        return $data;
    }

    // get all bookings info  by search for admin
    function search_all_bookings_back_limit_admin($term, $perpage = null, $offset = null, $orderby = null) {
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        $this->db->like('pt_bookings.booking_type', $term);
        $this->db->or_like('pt_bookings.booking_id', $term);
        $this->db->or_like('pt_accounts.ai_first_name', $term);
        $this->db->or_like('pt_accounts.ai_last_name', $term);
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    // get all bookings info  by advance search for admin
    function adv_search_all_bookings_back_limit_admin($data, $perpage = null, $offset = null, $orderby = null) {
        $invoice = $data["invoiceno"];
        $invoicefromdate = $data["invoicefromdate"];
        $invoicetodate = $data["invoicetodate"];
        $status = $data["status"];
        $customername = $data["customername"];
        $module = $data["module"];
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        if (!empty ($invoice)) {
            $this->db->where('pt_bookings.booking_id', $invoice);
        }
        if (!empty ($module)) {
            $this->db->where('pt_bookings.booking_type', $module);
        }
        if (!empty ($status)) {
            $this->db->where('pt_bookings.booking_status', $status);
        }
        if (!empty ($customername)) {
            $this->db->like('pt_accounts.ai_first_name', $customername);
            $this->db->or_like('pt_accounts.ai_last_name', $customername);
        }
        if (!empty ($invoicefromdate)) {
            $this->db->where('pt_bookings.booking_date >=', $invoicefromdate);
            $this->db->where('pt_bookings.booking_date <=', $invoicetodate);
        }
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    // Get supplier's bookings
    function supplier_get_all_bookings($myitems) {
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        if (!empty ($myitems)) {
            $this->db->where_in('pt_bookings.booking_item', $myitems);
        }
        else {
            $this->db->where('pt_bookings.booking_item', 0);
        }
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings');
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    // Get supplier's bookings in limit
    function supplier_get_all_bookings_limit($myitems, $perpage = null, $offset = null, $orderby = null) {
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        if (!empty ($myitems)) {
            $this->db->where_in('pt_bookings.booking_item', $myitems);
        }
        else {
            $this->db->where('pt_bookings.booking_item', 0);
        }
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    // get all bookings info  by search for admin
    function search_all_bookings_back_limit_supplier($term, $myitems, $perpage = null, $offset = null, $orderby = null) {
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        $this->db->like('pt_bookings.booking_type', $term);
        $this->db->or_like('pt_bookings.booking_id', $term);
        $this->db->or_like('pt_accounts.ai_first_name', $term);
        $this->db->or_like('pt_accounts.ai_last_name', $term);
        if (!empty ($myitems)) {
            $this->db->where_in('pt_bookings.booking_item', $myitems);
        }
        else {
            $this->db->where('pt_bookings.booking_item', 0);
        }
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    // get all bookings info  by advance search for admin
    function adv_search_all_bookings_back_limit_supplier($data, $myitems, $perpage = null, $offset = null, $orderby = null) {
        $invoice = $data["invoiceno"];
        $invoicefromdate = $data["invoicefromdate"];
        $invoicetodate = $data["invoicetodate"];
        $status = $data["status"];
        $customername = $data["customername"];
        $module = $data["module"];
        if ($offset != null) {
            $offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
        }
        $this->db->select('pt_bookings.booking_user,pt_bookings.booking_cancellation_request,pt_bookings.booking_id,pt_bookings.booking_type,pt_bookings.booking_expiry,pt_bookings.booking_ref_no,
            pt_bookings.booking_status,pt_bookings.booking_item,pt_bookings.booking_item_title,
            booking_total,pt_bookings.booking_deposit,pt_bookings.booking_date,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.accounts_email');
        if (!empty ($invoice)) {
            $this->db->where('pt_bookings.booking_id', $invoice);
        }
        if (!empty ($module)) {
            $this->db->where('pt_bookings.booking_type', $module);
        }
        if (!empty ($status)) {
            $this->db->where('pt_bookings.booking_status', $status);
        }
        if (!empty ($customername)) {
            $this->db->like('pt_accounts.ai_first_name', $customername);
            $this->db->or_like('pt_accounts.ai_last_name', $customername);
        }
        if (!empty ($invoicefromdate)) {
            $this->db->where('pt_bookings.booking_date >=', $invoicefromdate);
            $this->db->where('pt_bookings.booking_date <=', $invoicetodate);
        }
        if (!empty ($myitems)) {
            $this->db->where_in('pt_bookings.booking_item', $myitems);
        }
        else {
            $this->db->where('pt_bookings.booking_item', 0);
        }
        $this->db->join('pt_accounts', 'pt_bookings.booking_user = pt_accounts.accounts_id', 'left');
        $this->db->order_by('pt_bookings.booking_id', 'desc');
        $query = $this->db->get('pt_bookings', $perpage, $offset);
        $data['all'] = $query->result();
        $data['nums'] = $query->num_rows();
        return $data;
    }

    function do_login_booking($username, $password) {
        $login = $this->Accounts_model->login_customer($username, $password);
        if ($login) {
            $userid = $this->session->userdata('pt_logged_customer');
            return $this->do_booking($userid);
        }
        else {
            $bookingResult = array("error" => "yes", 'msg' => 'Invalid Email or Password');
            return $bookingResult;
        }
    }

    function do_customer_booking() {
        $userid = $this->Accounts_model->signup_account('customers', '1');
        return $this->do_booking($userid);
    }

    function doGuestBooking($bookquick = null)
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');

        if(empty($bookquick))
        {
            return $this->do_booking($userid);
        }
        else
        {
            return $this->doQuickBooking($userid);
        }
    }

    // ======================================================================
    //                  Hotels, Tours And Cars Bookings
    // ======================================================================

    /**
     * Tours Booking
     */
    public function do_tours_booking($payload = array())
    {
        $this->load->library('currconverter');
        $this->load->library('Tours/Tours_lib');

        $itemid  = $payload['itemid'];
        $adults  = $payload['adults'];
        $child   =  $payload['children'];
        $infant  = $payload['infant'];
        $apiDate = $payload['tdate'];
        $checkin  = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
        $checkout = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));

        $bookingData = json_decode($this->Tours_lib->getUpdatedDataBookResultObject($itemid, $adults,$child,$infant,NULL));

        // $grandtotal = $this->currconverter->convertPriceFloat($bookingData->grandTotal);
        $grandtotal = $this->currconverter->removeComma($bookingData->grandTotal);
        $checkin = databaseDate($checkin);
        $checkout = databaseDate($checkout);
        //$deposit = $this->currconverter->convertPriceFloat($bookingData->depositAmount);
        $extrabeds      = 0;
        $deposit = $this->currconverter->removeComma($bookingData->depositAmount);
        $tax = $this->currconverter->removeComma($bookingData->taxAmount);
        $paymethodfee = 0;

        //$this->currconverter->convertPriceFloat($bookingData->paymethodFee);
        $extrasTotalFee = $this->currconverter->removeComma($bookingData->extrasInfo->extrasTotalFee);
        $currCode = $bookingData->currCode;
        $currSymbol = $bookingData->currSymbol;
        $subitem = json_encode($bookingData->subitem);
        $extras = NULL;
        if (property_exists($bookingData->extrasInfo, 'extrasIndividualFee')) {
            $extras = json_encode($bookingData->extrasInfo->extrasIndividualFee);
        }

        $stay = $bookingData->stay;
        $extrabedscharges = $this->currconverter->removeComma($bookingData->extraBedCharges);
        $refno = random_string('numeric', 4);
        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $couponRate = 0;
        $couponCode = 0;

        $coupon = $payload['couponid'];
        if($coupon > 0)
        {
            $cResult = pt_applyCouponDiscount($coupon, $grandtotal);
            $cResultDeposit = pt_applyCouponDiscount($coupon, $deposit);
            $cResultTax = pt_applyCouponDiscount($coupon, $tax);

            $couponRate = $cResult->value;
            $couponCode = $cResult->code;

            $grandtotal = $cResult->amount;
            $deposit = $cResultDeposit->amount;
            $tax = $cResultTax->amount;

            $this->updateCoupon($coupon);
        }

        $data = array(
            'booking_ref_no' => $refno,
            'booking_type' => 'tours',
            'booking_item' => $itemid,
            'booking_subitem' => $subitem,
            'setting_id' => '',
            'booking_extras' => $extras,
            'booking_date' => time(),
            'booking_expiry' => time() + $expiry,
            'booking_user' => $payload['userId'],
            'booking_status' => 'unpaid',
            'booking_additional_notes' => $payload['additionalnotes'],
            'booking_total' => $grandtotal,
            'booking_remaining' => $grandtotal,
            'booking_checkin' => $checkin,
            'booking_checkout' => $checkout,
            'booking_nights' => $stay,
            'booking_adults' => $adults,
            'booking_child' => $child,
            'booking_deposit' => $deposit,
            'booking_tax' => $tax,
            'booking_paymethod_tax' => $paymethodfee,
            'booking_extras_total_fee' => $extrasTotalFee,
            'booking_curr_code' => $currCode,
            'booking_curr_symbol' => $currSymbol,
            'booking_extra_beds' => $extrabeds,
            'booking_extra_beds_charges' => $extrabedscharges,
            'booking_coupon_rate' => $couponRate,
            'booking_coupon' => $couponCode,
            'booking_guest_info' => $passportInfo
        );
        $this->db->insert('pt_bookings', $data);
        $bookingResult = array("error" => "yes", 'msg' => 'Error occured');
        $bookingResult = array("error" => "yes", 'msg' => 'Error occured');

        $this->session->set_userdata("BOOKING_ID", $bookid);
        $this->session->set_userdata("REF_NO", $refno);

        $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
        $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url);
        $invoicedetails = invoiceDetails($bookid,$refno);

        $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        return $bookingResult;
    }

    /**
     * Do tours guest booking
     */
    public function do_tours_guest_booking($payload = array())
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['userId'] = $userid;

        return $this->do_tours_booking($payload);
    }


    public function hotels_booking($payload = array())
    {
      // dd($payload);
        $paymethodfee = 0;
        $refno = random_string('numeric', 4);
        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $couponRate = 0;
        $couponCode = 0;

        $coupon = $payload['couponid'];

        $checkin    = date('Y-m-d', strtotime($payload['booking_checkin']));
        $checkout   = date('Y-m-d', strtotime($payload['booking_checkout']));

        $data = array(
            'booking_ref_no' => $refno,
            'booking_supplier' => $payload['booking_supplier'],
            'hotel_id' => $payload['hotel_id'],
            'hotel_name' => $payload['hotel_name'],
            'deposit_type' => $payload['deposit_type'],
            'tax_type' => $payload['tax_type'],
            'total_price' => $payload['total_price'],
            'booking_date' => time(),
            'booking_user_id' => $payload['booking_user_id'],
            'booking_remaining' => $payload['total_price'],
            'booking_status' => 'pending',
            'booking_additional_notes' => @$payload['additionalnotes'],
            'booking_checkin' => $checkin,
            'booking_checkout' => $checkout,
            'booking_nights' => $payload['booking_nights'],
            'booking_adults' => $payload['booking_adults'],
            'booking_childs' =>$payload['booking_childs'],
            'booking_deposit' => $payload['booking_deposit'],
            'booking_tax' => $payload['booking_tax'],
            'booking_curr_code' => $payload['booking_curr_code'],
            'hotel_img' => $payload['hotel_img'],
            'hotel_loaction' => $payload['loaction'],
            'booking_payment_gateway' => $payload['booking_payment_gateway'],
            'lang' => $payload['latitude'],
            'long' => $payload['longitude'],
            'booking_coupon' => $couponCode,
            'booking_guest_info' => $payload['guest'],
            'booking_key' => $payload['booking_key'],
            'hotel_stars' => $payload['hotel_stars'],
            'supplier_name' => $payload['supplier_name'],
            'hotel_phone' => $payload['hotel_phone'],
            'hotel_email' => $payload['hotel_email'],
            'hotel_website' => $payload['hotel_website'],
            'country_code' => $payload['country_code'],
            'city_code' => $payload['city_code'],
            'nationality' => $payload['nationality'],
            'booking_from' => $payload['booking_from'],
            'room_adult_price' => $payload['room_adult_price'],
            'room_child_price' => $payload['room_child_price'],
            'price_type' => $payload['price_type'],
            'children_ages' => $payload['children_ages'],
        );
        $this->db->insert('hotels_bookings', $data);
        $bookid = $this->db->insert_id();
        $room = $payload['rooms'];

        $rp = json_decode($room);
        foreach ($rp as $key=>$value){
            $this->db->insert('hotels_rooms_bookings', array(
                'room_name' => $value->room_name,
                'room_price' => $value->room_price,
                'room_qaunitity' => $value->room_qaunitity,
                'room_extrabed_price' => $value->room_extrabed_price,
                'room_extrabed' => $value->room_extrabed,
                'booking_id' => $bookid,
                'room_actual_price' => $value->room_actual_price,
            ));
        }

        $bookingResult = array('id'=>$bookid,'sessid'=>$refno);
        return $bookingResult;
    }

    //Do quick booking by admin
    function doQuickBook($userid){

        $payload = $this->input->post();
        $change_checkin = str_replace('/','-',$payload['checkin']);
        $checkin    = date('Y-m-d', strtotime($change_checkin));
        $change_checkout = str_replace('/','-',$payload['checkout']);
        $checkout   = date('Y-m-d', strtotime($change_checkout));
        $refno = random_string('numeric', 4);
        $this->load->library('Hotels/Hotels_lib');
        $this->Hotels_lib->set_id($payload['itemid']);
        $details['hotel'] = $this->Hotels_lib->hotel_details();
        $rooms = $this->Hotels_lib->room_short_details($payload['subitemid']);
        $title = $this->Hotels_lib->getRoomType($rooms[0]->room_type);

        if($payload['childpricecal'] == 'By Fixed'){
            $price_type = 0;
            $price = $payload['totalamount'];
        }else{
            $price = $payload['quickDeposit'];
            $price_type = 1;
        }
        if(!empty($payload['childpricecal'])){
            $childpricecal = $payload['childpricecal'];
        }else{
            $childpricecal = '';
        }

        if(!empty($payload['adultpricecal'])){
            $adultpricecal = $payload['adultpricecal'];
        }else{
            $adultpricecal = '';
        }
        $adult_travellers = $payload['adultscount'];
        $child_travellers = $payload['childcount'];
        $passportInfo = [];

        for ($i = 0; $i < $adult_travellers; $i++) {
            array_push($passportInfo, (object) array(
                'title'=>$_POST["adult_type_".$i],
                'first_name'=>$_POST["first_name_traveller_".$i],
                'last_name'=>$_POST["last_name_traveller_".$i],
                'age'=>'',
            ));
        }


        for ($i = 0; $i < $child_travellers; $i++) {
            array_push($passportInfo, (object) array(
                'title'=>$_POST["user_type_chlid_".$i],
                'first_name'=>$_POST["first_name_traveller_chlid_".$i],
                'last_name'=>$_POST["last_name_traveller_chlid_".$i],
                'age'=>$_POST["child_age_".$i],
            ));
        }
        $passport = json_encode($passportInfo);
        $data = array(
            'booking_ref_no' => $refno,
            'booking_supplier' => 1,
            'hotel_id' => $payload['itemid'],
            'hotel_name' => $payload['itemtitle'],
            'deposit_type' => $details['hotel']->deposit_type,
            'tax_type' => $details['hotel']->tax_type,
            'total_price' => $price,
            'booking_date' => time(),
            'booking_user_id' => $payload['customer'],
            'booking_remaining' => $price,
            'booking_status' => 'pending',
            'booking_additional_notes' => @$payload['additionalnotes'],
            'booking_checkin' => $checkin,
            'booking_checkout' => $checkout,
            'booking_nights' => $payload['stay'],
            'booking_adults' => $payload['adultscount'],
            'booking_childs' =>$payload['childcount'],
            'booking_deposit' => $payload['quickDeposit'],
            'booking_tax' => $payload['taxhotel'],
            'booking_curr_code' => $payload['currencycode'],
            'hotel_img' => $details['hotel']->thumbnail,
            'hotel_loaction' => $details['hotel']->location,
            'booking_payment_gateway' => $payload['paymethod'],
            'lang' =>$details['hotel']->latitude,
            'long' => $details['hotel']->longitude,
            'booking_coupon' => 0,
            'booking_guest_info' => $passport,
            'booking_key' => '',
            'hotel_stars' => $details['hotel']->starsCount,
            'supplier_name' => 'manual',
            'hotel_phone' => $details['hotel']->hotel_phone,
            'hotel_email' => $details['hotel']->hotel_email,
            'hotel_website' => $details['hotel']->hotel_website,
            'country_code' => '',
            'city_code' => '',
            'nationality' => '',
            'booking_from' => 'admin',
            'room_adult_price' => $adultpricecal,
            'room_child_price' => $childpricecal,
            'price_type' =>$price_type,
            'children_ages' => '0',
        );

       $this->db->insert('hotels_bookings', $data);
       $bookid = $this->db->insert_id();

            $this->db->insert('hotels_rooms_bookings', array(
                'room_name' => $title,
                'room_price' => $payload['totalroomprice'],
                'room_qaunitity' => $payload['roomscount'],
                'room_extrabed_price' => '',
                'room_extrabed' => '',
                'booking_id' => $bookid,
                'room_actual_price' => $payload['totalroomprice'],
            ));
            return $bookid;
    }

    function cancelbooking($payload = array()){
        $this->db->where('booking_id',$payload['id']);
        $data = $this->db->get('hotels_bookings')->result();
       if(!empty($data)){
        $data = array(
            'booking_cancellation_request' => $payload['booking_cancellation_request'],
        );
        $this->db->where('booking_id',$payload['id']);
        $check = $this->db->update('hotels_bookings',$data);
        $bookingResult = array('response'=>true,'booking_id'=>$payload['id']);
        return $bookingResult;
       }else{
           return   array('response'=>false,'booking_id'=>$payload['id']);
       }
    }

    function flightcancelbooking($payload = array()){
        $this->db->where('booking_id',$payload['id']);
        $this->db->where('booking_ref_no',$payload['invoice_id']);
        $data = $this->db->get('flights_bookings')->result();
        if(!empty($data)){
            $data = array(
                'booking_cancellation_request' => $payload['booking_cancellation_request'],
            );
            $this->db->where('booking_id',$payload['id']);
            $check = $this->db->update('flights_bookings',$data);
            $bookingResult = array('response'=>true,'booking_id'=>$payload['id']);
            return $bookingResult;
        }else{
            return   array('response'=>false,'booking_id'=>$payload['id']);
        }
    }

    function bookinginvoiceupdate($payload = array()){
        $this->db->where('booking_id',$payload['id']);
        $data = $this->db->get('hotels_bookings')->result();
        if(!empty($data)) {
            $data = array(
                'booking_txn_id' => $payload['txn_id'],
                'book_token' => $payload['token'],
                'booking_logs' => $payload['logs'],
                'booking_payment_status' => $payload['payment_status'],
                'payment_desc' => $payload['desc'],
                'booking_remaining' => $payload['remaining_amount'],
                'booking_amount_paid' => $payload['amount_paid'],
                'booking_status' => $payload['status'],
                'booking_payment_date' => $payload['payment_date'],
                'booking_payment_gateway' => $payload['payment_gateway'],
            );

            $this->db->where('booking_id',$payload['id']);
            $this->db->update('hotels_bookings',$data);
        $this->db->select('hotels_bookings.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $this->db->where('hotels_bookings.booking_id',$payload['id']);
        $this->db->join('pt_accounts','hotels_bookings.booking_user_id = pt_accounts.accounts_id','left');
        $invoiceData = $this->db->get('hotels_bookings')->result();
      $this->Emails_model->paid_send_customeremail($invoiceData);
      $this->Emails_model->paid_send_adminemail($invoiceData);
            $bookingResult = array('response'=>true,'booking_id'=>$payload['id'],'sessid'=>$payload['ref_id'],);
            return $bookingResult;
        }else{
            return   array('response'=>false,'booking_id'=>$payload['id']);
        }
    }

    function flightbookinginvoiceupdate($payload = array()){
        $this->db->where('booking_id',$payload['id']);
        $this->db->where('booking_ref_no',$payload['invoice_id']);
        $data = $this->db->get('flights_bookings')->result();
        if(!empty($data)) {
            $data = array(
                'booking_txn_id' => $payload['txn_id'],
                'book_token' => $payload['token'],
                'booking_logs' => $payload['logs'],
                'booking_payment_status' => $payload['payment_status'],
                'payment_desc' => $payload['desc'],
                'booking_remaining' => $payload['remaining_amount'],
                'booking_amount_paid' => $payload['amount_paid'],
                'booking_status' => $payload['status'],
                'booking_payment_date' => $payload['payment_date'],
                'booking_payment_gateway' => $payload['payment_gateway'],
            );

            $this->db->where('booking_id',$payload['id']);
            $this->db->update('flights_bookings',$data);
            $this->db->select('flights_bookings.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
            $this->db->where('flights_bookings.booking_id',$payload['id']);
            $this->db->join('pt_accounts','flights_bookings.booking_user_id = pt_accounts.accounts_id','left');
            $invoiceData = $this->db->get('flights_bookings')->result();
            $this->Emails_model->paid_send_customeremail($invoiceData);
            $this->Emails_model->paid_send_adminemail($invoiceData);
            $bookingResult = array('response'=>true,'booking_id'=>$payload['id'],'sessid'=>$payload['invoice_id'],);
            return $bookingResult;
        }else{
            return   array('response'=>false,'booking_id'=>$payload['id']);
        }
    }

    /**
     * Hotels Booking
     *
     */
    public function do_hotels_booking($payload = array())
    {
        $this->load->library('currconverter');
        $this->load->library('Hotels/Hotels_lib');
//dd($payload);
        $error          = true;
        $itemid         = $payload['itemid'];
        $roomid         = $payload['subitemid'];
        $checkin        = $payload['checkin'];
        $checkout       = $payload['checkout'];
        $roomscount     = $payload['roomscount'];
        $bookingtype    = $payload['btype'];
        $extras         = NULL;
        $extrabeds      = 0;
        $passportInfo   = "";
        $apicheckin     = $payload['apicheckin'];
        $apicheckout    = $payload['apicheckout'];
        if( ! empty($apicheckin) )
        {
            $checkin    = date($this->data['app_settings'][0]->date_f, strtotime($apicheckin));
            $checkout   = date($this->data['app_settings'][0]->date_f, strtotime($apicheckout));
        }

        $bookingData = json_decode($this->Hotels_lib->getUpdatedDataBookResultObject($itemid, $roomid, $checkin, $checkout, $roomscount, $extras, $extrabeds));
        if ($bookingData->stay <= 0)
        {
            return $bookingResult = array("error" => "yes", 'msg' => 'Booking stay must be greater then zero');
        }


        $grandtotal = $this->currconverter->removeComma($bookingData->grandTotal);
        $checkin = databaseDate($checkin);
        $checkout = databaseDate($checkout);

        $deposit = $this->currconverter->removeComma($bookingData->depositAmount);
        $tax = $this->currconverter->removeComma($bookingData->taxAmount);
        $paymethodfee = 0;

        $extrasTotalFee = $this->currconverter->removeComma($bookingData->extrasInfo->extrasTotalFee);
        $currCode = $bookingData->currCode;
        $currSymbol = $bookingData->currSymbol;
        $subitem = json_encode($bookingData->subitem);
        $extras = json_encode($bookingData->extrasInfo->extrasIndividualFee);
        $stay = $bookingData->stay;
        $extrabedscharges = $this->currconverter->removeComma($bookingData->extraBedCharges);
        $refno = random_string('numeric', 4);
        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $couponRate = 0;
        $couponCode = 0;

        $coupon = $payload['couponid'];



        $data = array(
            'booking_ref_no' => $refno,
            'booking_type' => $bookingtype,
            'booking_item' => $itemid,
            'booking_subitem' => $subitem,
            'booking_extras' => $extras,
            'booking_date' => time(),
            'booking_expiry' => time() + $expiry,
            'booking_user' => $payload['userId'],
            'booking_status' => 'unpaid',
            'booking_additional_notes' => @$payload['additionalnotes'],
            'booking_total' => $grandtotal,
            'booking_remaining' => $grandtotal,
            'booking_checkin' => $checkin,
            'booking_checkout' => $checkout,
            'booking_nights' => $stay,
            'booking_adults' => $payload['adults'],
            'booking_child' =>"",
            'booking_deposit' => $deposit,
            'booking_tax' => $tax,
            'booking_paymethod_tax' => $paymethodfee,
            'booking_extras_total_fee' => $extrasTotalFee,
            'booking_curr_code' => $currCode,
            'booking_curr_symbol' => $currSymbol,
            'booking_extra_beds' => $extrabeds,
            'booking_extra_beds_charges' => $extrabedscharges,
            'booking_coupon_rate' => $couponRate,
            'booking_coupon' => $couponCode,
            'booking_guest_info' => $passportInfo
        );
        //dd($data);
        $this->db->insert('pt_bookings', $data);
        $bookid = $this->db->insert_id();

        $this->session->set_userdata("BOOKING_ID", $bookid);
        $this->session->set_userdata("REF_NO", $refno);

        $this->db->insert('pt_booked_rooms', array(
            'booked_booking_id' => $bookid,
            'booked_room_id' => $bookingData->subitem->id,
            'booked_room_count' => $bookingData->subitem->count,
            'booked_checkin' => $checkin,
            'booked_checkout' => $checkout,
            'booked_booking_status' => 'unpaid'
        ));

        $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
        $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url ,'id'=>$bookid,'sessid'=>$refno);
        $invoicedetails = invoiceDetails($bookid,$refno);

        $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        return $bookingResult;
    }

    /**
     * Hotels guest booking
     */
    public function do_hotels_guest_booking($payload = array())
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['userId'] = $userid;

        return $this->do_hotels_booking($payload);
    }

    public function hotels_guest_booking($payload = array())
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['booking_user_id'] = $userid;

        return $this->hotels_booking($payload);
    }


    /**
     * Cars Booking
     *
     */
    public function do_cars_booking($payload = array())
    {
        $this->load->library('currconverter');
        $this->load->library('Cars/Cars_lib');

        $error          = true;
        $itemid         = $payload['itemid'];
        $roomid         = $payload['subitemid'];

        $pickupDate      = $payload['pickupDate'];
        $dropoffDate     = $payload['dropoffDate'];
        $pickuplocation  = $payload['pickuplocation'];
        $dropofflocation = $payload['dropofflocation'];
        $pickuptime      = $payload['pickupTime'];
        $droptime        = $payload['dropoffTime'];

        $roomscount     = $payload['roomscount'];
        $bookingtype    = $payload['btype'];
        $extras         = NULL;
        $extrabeds      = 0;
        $passportInfo   = "";

        $apiDate = $payload['cdate'];
        if( empty($apiDate) )
        {
            $checkin    =  $pickupDate;
            $checkout   =  $dropoffDate;
        }
        else
        {
            $checkin    = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
            $checkout   = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
        }

        $bookingData = json_decode($this->Cars_lib->getUpdatedDataBookResultObject($itemid, $extras, $pickuplocation, $dropofflocation, $pickupDate, $dropoffDate));

        $grandtotal = $this->currconverter->removeComma($bookingData->grandTotal);
        $checkin    = databaseDate($checkin);
        $checkout   = databaseDate($checkout);

        $deposit        = $this->currconverter->removeComma($bookingData->depositAmount);
        $tax            = $this->currconverter->removeComma($bookingData->taxAmount);
        $paymethodfee   = 0;

        $extrasTotalFee = $this->currconverter->removeComma($bookingData->extrasInfo->extrasTotalFee);
        $currCode       = $bookingData->currCode;
        $currSymbol     = $bookingData->currSymbol;
        $subitem        = json_encode($bookingData->subitem);
        $extras         = json_encode($bookingData->extrasInfo->extrasIndividualFee);
        $stay           = $bookingData->stay;
        $refno          = random_string('numeric', 4);
        $expiry         = $this->data['app_settings'][0]->booking_expiry * 86400;
        $couponRate     = 0;
        $couponCode     = 0;
        $extrabedscharges = $this->currconverter->removeComma($bookingData->extraBedCharges);

        $coupon = $payload['couponid'];
        if($coupon > 0)
        {
            $cResult        = pt_applyCouponDiscount($coupon, $grandtotal);
            $cResultDeposit = pt_applyCouponDiscount($coupon, $deposit);
            $cResultTax     = pt_applyCouponDiscount($coupon, $tax);

            $couponRate = $cResult->value;
            $couponCode = $cResult->code;

            $grandtotal = $cResult->amount;
            $deposit    = $cResultDeposit->amount;
            $tax        = $cResultTax->amount;

            $this->updateCoupon($coupon);
        }

        $data = array(
            'booking_ref_no' => $refno,
            'booking_type' => $bookingtype,
            'booking_item' => $itemid,
            'booking_subitem' => $subitem,
            'booking_extras' => $extras,
            'booking_date' => time(),
            'booking_expiry' => time() + $expiry,
            'booking_user' => $payload['userId'],
            'booking_status' => 'unpaid',
            'booking_additional_notes' => '',
            'booking_total' => $grandtotal,
            'booking_remaining' => $grandtotal,
            'booking_checkin' => $checkin,
            'booking_checkout' => $checkout,
            'booking_nights' => $stay,
            'booking_adults' => $payload['adults'],
            'booking_child' => $payload['children'],
            'booking_deposit' => $deposit,
            'booking_tax' => $tax,
            'booking_paymethod_tax' => $paymethodfee,
            'booking_extras_total_fee' => $extrasTotalFee,
            'booking_curr_code' => $currCode,
            'booking_curr_symbol' => $currSymbol,
            'booking_extra_beds' => $extrabeds,
            'booking_extra_beds_charges' => $extrabedscharges,
            'booking_coupon_rate' => $couponRate,
            'booking_coupon' => $couponCode,
            'booking_guest_info' => $passportInfo
        );
        $this->db->insert('pt_bookings', $data);
        $bookid = $this->db->insert_id();

        $this->session->set_userdata("BOOKING_ID", $bookid);
        $this->session->set_userdata("REF_NO", $refno);

        $this->db->insert('pt_booked_rooms', array(
            'booked_booking_id' => $bookid,
            'booked_room_id' => $bookingData->subitem->id,
            'booked_room_count' => $bookingData->subitem->count,
            'booked_checkin' => $checkin,
            'booked_checkout' => $checkout,
            'booked_booking_status' => 'unpaid'
        ));

        $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
        $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url);
        $invoicedetails = invoiceDetails($bookid,$refno);

        $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        return $bookingResult;
    }

    /**
     * Cars guest booking
     */
    public function do_cars_guest_booking($payload = array())
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['userId'] = $userid;

        return $this->do_cars_booking($payload);
    }

    function do_viator_booking($array){
        $this->db->insert('pt_bookings',$array);
    }


    // ============================== End: Bookings ======================================

    function do_booking($userid) {

        $error = true;
        $this->load->library('currconverter');
        $itemid = $this->input->post('itemid');
        $roomid = $this->input->post('subitemid');
        $checkin = $this->input->post('checkin');
        $checkout = $this->input->post('checkout');
        $roomscount = $this->input->post('roomscount');
        $bookingtype = $this->input->post('btype');
        $tourType = $this->input->post('tourType');
        $extras = $this->input->post('extras');
        $extrabeds = $this->input->post('bedscount');
        $additionalnotes = $this->input->post('additionalnotes');
        $setting_id = $this->input->post('setting_id');
        //$passportInfo = "";

        // Passengers passport detail
        $passports = $this->input->post('passport');
        $passportInfo = [];
        if ( ! empty($passports) ) {
            for ($i = 1; $i <= count($passports); $i++) {
                array_push($passportInfo, array(
                    'name' => $passports[$i]['name'],
                    'age' => $passports[$i]['age'],
                    'passportnumber' => $passports[$i]['passportnumber'],
                ));
            }
        }
        $passportInfo = json_encode($passportInfo);


        if ($bookingtype == "hotels")
        {
            $rooms = explode(',', $roomid);
            $roomscount = explode(',', $roomscount);
            $_extrabeds = json_decode($extrabeds, true);
            $extrabeds = array_sum($_extrabeds);
            $apicheckin = $this->input->post('apicheckin');
            $apicheckout = $this->input->post('apicheckout');
            $adults = $this->input->post('adults');
            $taxAmount = $this->input->post('taxAmount');
            if( ! empty($apicheckin) )
            {
                $checkin = date($this->data['app_settings'][0]->date_f, strtotime($apicheckin));
                $checkout = date($this->data['app_settings'][0]->date_f, strtotime($apicheckout));
            }

            $this->load->library('Hotels/Hotels_lib');
            $bookingData = array();
            $error = false;
            foreach($rooms as $index => $roomID)
            {
                if (count($rooms) > 1) {
                    $taxAmount = 0;
                    $_extras = 'ignore';
                } else {
                    $taxAmount = 0;
                    $_extras = $extras;
                }
                $roomscount_id = $roomscount[$index];
                $extrabeds_id = (isset($_extrabeds[$roomID]))?$_extrabeds[$roomID]:0;
                $_bookingData = json_decode($this->Hotels_lib->getUpdatedDataBookResultObject($itemid, $roomID, $checkin, $checkout, $roomscount_id, $_extras, $extrabeds_id, $adults, $taxAmount));
                array_push($bookingData, $_bookingData);
                if ($_bookingData->stay < 1 && $error == false)
                {
                    $error = true;
                }
            }
            $checkin = databaseDate($checkin);
            $checkout = databaseDate($checkout);
            $grandtotal = 0;
            foreach(array_column($bookingData, 'grandTotal') as $_grandtotal) {
                $grandtotal += $this->currconverter->removeComma($_grandtotal);
            }
            $deposit = 0;
            foreach(array_column($bookingData, 'depositAmount') as $amount) {
                $deposit += $this->currconverter->removeComma($amount);
            }
            $tax = 0;
            foreach(array_column($bookingData, 'taxAmount') as $taxAmount) {
                $tax += $this->currconverter->removeComma($taxAmount);
            }
            $extrasTotalFee = 0;
            if (count($rooms) > 1) {
                $extratotal = $this->Hotels_lib->extrasFee($extras);
                if (isset($extratotal['extrasTotalFee']) && ! empty($extratotal['extrasTotalFee'])) {
                    $extrasTotalFee += $extratotal['extrasTotalFee'];
                }
            } else {
                foreach(array_column(array_column($bookingData, 'extrasInfo'), 'extrasTotalFee') as $_extrasTotalFee) {
                    $extrasTotalFee += $this->currconverter->removeComma($_extrasTotalFee);
                }
            }
            if (! empty($extrasTotalFee) && count($rooms) > 1) {
                $grandtotal += $extrasTotalFee;
            }
            $this->load->library('Hotels/Hotels_lib');
            $hotel_lib = new Hotels_lib();
            $hotel_lib->hotelid = $itemid;
            $taxDetail = $hotel_lib->hotel_tax_commision();
            if (count($rooms) > 1) {
                if ($taxDetail['commtype'] == "fixed") {
                    $deposit = round($taxDetail['commval'], 2);
                }
                else {
                    $deposit = round(($grandtotal * $taxDetail['commval']) / 100, 2);
                }
            }
            if ($taxDetail['taxtype'] == "fixed") {
                $tax = round($taxDetail['taxval'], 2);
            } else {
                $tax = round(($grandtotal * $taxDetail['taxval']) / 100, 2);
            }
            $grandtotal += $tax;
            $paymethodfee = 0;
            $currCode = $bookingData[0]->currCode;
            $currSymbol = $bookingData[0]->currSymbol;
            $subitem = array_column($bookingData, 'subitem');
            $subitem = json_encode($subitem);
            $_extrasIndividualFee = array();
            if (count($rooms) > 1) {
                $extrasInfo = $this->Hotels_lib->extrasFee($extras);
                $extras = json_encode($extrasInfo['extrasIndividualFee']);
            } else {
                $extrasInfo = array_column($bookingData, 'extrasInfo');
                foreach($extrasInfo as $info) {
                    if(!empty($info->extrasIndividualFee)) {
                        $_extrasIndividualFee = $info->extrasIndividualFee;
                    }
                }
                $extras = json_encode($_extrasIndividualFee);
            }
            $adults = $this->input->post('adults');
            $child = $this->input->post('children');
            // $stay = array_sum(array_column($bookingData, 'stay'));
            $datetime1 = new DateTime($checkin);
            $datetime2 = new DateTime($checkout);
            $stay = $datetime1->diff($datetime2)->format('%a');
            $extraBedCharges = array_sum(array_column($bookingData, 'extraBedCharges'));
            $extrabedscharges = $this->currconverter->removeComma($extraBedCharges);
            $refno = random_string('numeric', 4);
            $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;
            $couponRate = 0;
            $couponCode = 0;
            $coupon = $this->input->post('couponid');
            if($coupon > 0)
            {
                $cResult = pt_applyCouponDiscount($coupon, $grandtotal);
                $cResultDeposit = pt_applyCouponDiscount($coupon, $deposit);
                $cResultTax = pt_applyCouponDiscount($coupon, $tax);

                $couponRate = $cResult->value;
                $couponCode = $cResult->code;

                $grandtotal = $cResult->amount;
                $deposit = $cResultDeposit->amount;
                $tax = $cResultTax->amount;

                $this->updateCoupon($coupon);
            }

            if ( ! $error )
            {
                $data = array(
                    'booking_ref_no' => $refno,
                    'booking_type' => $bookingtype,
                    'booking_item' => $itemid,
                    'booking_subitem' => $subitem,
                    'booking_extras' => $extras,
                    'booking_date' => time(),
                    'booking_expiry' => time() + $expiry,
                    'booking_user' => $userid,
                    'booking_status' => 'unpaid',
                    'booking_additional_notes' => $this->input->post('additionalnotes'),
                    'booking_total' => $grandtotal,
                    'booking_remaining' => $grandtotal,
                    'booking_checkin' => $checkin,
                    'booking_checkout' => $checkout,
                    'booking_nights' => $stay,
                    'booking_adults' => $adults,
                    'booking_child' => $child,
                    'booking_deposit' => $deposit,
                    'booking_tax' => $tax,
                    'booking_paymethod_tax' => $paymethodfee,
                    'booking_extras_total_fee' => $extrasTotalFee,
                    'booking_curr_code' => $currCode,
                    'booking_curr_symbol' => $currSymbol,
                    'booking_extra_beds' => $extrabeds,
                    'booking_extra_beds_charges' => $extrabedscharges,
                    'booking_coupon_rate' => $couponRate,
                    'booking_coupon' => $couponCode,
                    'booking_guest_info' => $passportInfo
                );
                $this->db->insert('pt_bookings', $data);
                $bookid = $this->db->insert_id();
                $this->session->set_userdata("BOOKING_ID", $bookid);
                $this->session->set_userdata("REF_NO", $refno);
                foreach($rooms as $index => $roomID)
                {
                    $rdata = array(
                        'booked_booking_id' => $bookid,
                        'booked_room_id' => $bookingData[$index]->subitem->id,
                        'booked_room_count' => $bookingData[$index]->subitem->count,
                        'booked_checkin' => $checkin,
                        'booked_checkout' => $checkout,
                        'booked_booking_status' => 'unpaid'
                    );
                    $this->db->insert('pt_booked_rooms', $rdata);
                }
                $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
                $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url);
                $invoicedetails = invoiceDetails($bookid,$refno);
                $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
                $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
                $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
                $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);
            }
            else
            {
                $bookingResult = array("error" => "yes", 'msg' => 'Error occured');
            }

            return $bookingResult;
        }
        elseif($bookingtype == "tours")
        {
            if ($tourType == "Viator"){
                require_once(APPPATH.'modules/Viator/controllers/Viator.php');
                $Viator =  new Viator();
                $productCode = $this->input->post('code');
                $startDate = $this->input->post('startDate');
                $endDate = $this->input->post('endDate');
                $adults = $this->input->post('adults');
                $seniors = $this->input->post('seniors');
                $youth = $this->input->post('youth');
                $children = $this->input->post('children');
                $infants = $this->input->post('infants');
                $arr = [$productCode,$startDate,$endDate];
                $bookingData = $Viator->beforeBooking($arr);

            }else{
                $adults = $this->input->post('adults');
                $child = $this->input->post('children');
                $infant = $this->input->post('infant');

                $apiDate = $this->input->post('tdate');
                if(empty($apiDate)){
                    $checkin = $this->input->post('date');
                    $checkout = $this->input->post('date');

                    if(empty($checkin)){
                        $checkin = $this->input->post('checkin');
                        $checkout = $this->input->post('checkin');
                    }

                }else{
                    $checkin = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
                    $checkout = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));


                }
                $this->load->library('Tours/Tours_lib');
                $bookingData = json_decode($this->Tours_lib->getUpdatedDataBookResultObject($itemid, $adults,$child,$infant,$extras));
                $error = false;

                // Passengers passport detail
                $passports = $this->input->post('passport');
                $passportInfo = [];
                if ( ! empty($passports) ) {
                    for ($i = 1; $i <= count($passports); $i++) {
                        array_push($passportInfo, array(
                            'name' => $passports[$i]['name'],
                            'age' => $passports[$i]['age'],
                            'passportnumber' => $passports[$i]['passportnumber'],
                        ));
                    }
                }
                $passportInfo = json_encode($passportInfo);
            }
        }
        elseif($bookingtype == "rentals")
        {
                $adults = $this->input->post('adults');
                $child = $this->input->post('children');
                $infant = $this->input->post('infant');

                $apiDate = $this->input->post('tdate');
                if(empty($apiDate)){
                    $checkin = $this->input->post('date');
                    $checkout = $this->input->post('date');

                    if(empty($checkin)){
                        $checkin = $this->input->post('checkin');
                        $checkout = $this->input->post('checkin');
                    }

                }else{
                    $checkin = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
                    $checkout = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));


                }
                $this->load->library('Rentals/Rentals_lib');
                $bookingData = json_decode($this->Rentals_lib->getUpdatedDataBookResultObject($itemid, $adults,$child,$infant,$extras));
                $error = false;

                // Passengers passport detail
                $passports = $this->input->post('passport');
                $passportInfo = [];
                if ( ! empty($passports) ) {
                    for ($i = 1; $i <= count($passports); $i++) {
                        array_push($passportInfo, array(
                            'name' => $passports[$i]['name'],
                            'age' => $passports[$i]['age'],
                            'passportnumber' => $passports[$i]['passportnumber'],
                        ));
                    }
                }
                $passportInfo = json_encode($passportInfo);
            }

        elseif($bookingtype == "boats")
        {
            $adults = $this->input->post('adults');
            $child = $this->input->post('children');
            $infant = $this->input->post('infant');

            $apiDate = $this->input->post('tdate');
            if(empty($apiDate)){
                $checkin = $this->input->post('date');
                $checkout = $this->input->post('date');

                if(empty($checkin)){
                    $checkin = $this->input->post('checkin');
                    $checkout = $this->input->post('checkin');
                }

            }else{
                $checkin = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
                $checkout = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));


            }
            $this->load->library('Boats/Boats_lib');
            $bookingData = json_decode($this->Boats_lib->getUpdatedDataBookResultObject($itemid, $adults,$child,$infant,$extras));
            $error = false;

            // Passengers passport detail
            $passports = $this->input->post('passport');
            $passportInfo = [];
            if ( ! empty($passports) ) {
                for ($i = 1; $i <= count($passports); $i++) {
                    array_push($passportInfo, array(
                        'name' => $passports[$i]['name'],
                        'age' => $passports[$i]['age'],
                        'passportnumber' => $passports[$i]['passportnumber'],
                    ));
                }
            }
            $passportInfo = json_encode($passportInfo);
        }
        elseif($bookingtype == "flights")
        {

            $adults = $this->input->post('adults');
            $child = $this->input->post('children');
            $infant = $this->input->post('infant');
            $type = $this->input->post('type');
            $taxamount = $this->input->post('taxamount');
            $totalamount = $this->input->post('totalamount');
            $depositeamount = $this->input->post('depositeamount');
            $setting_id = $this->input->post('setting_id');

//dd($setting_id);

            $error = false;
            $this->load->library('Flights/Flights_lib');
            $extras = (object)array('from' => $this->input->post('from'),'to' => $this->input->post('to'),'type'=> $type);
            $bookingData = (object) array('grandTotal' => $totalamount, 'taxAmount' => $taxamount, 'depositAmount' => $depositeamount, 'extrashtml' => "", 'bookingType' => "flights", 'currCode' => $this->Flights_lib->currencycode, 'stay' => 1, 'currSymbol' => $this->Flights_lib->currencysign, 'subitem' => $extras, 'extrasInfo' => "",'booking_guest_info'=> $passportInfo,'setting_id'=>$setting_id);
       //dd($bookingData);
        }
        elseif($bookingtype == "cars")
        {

            $apiDate = $this->input->post('cdate');
            if(empty($apiDate)){

                $checkin =  $this->input->post('pickupDate');
                $checkout =  $this->input->post('dropoffDate');


            }else{
                $checkin = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));
                $checkout = date($this->data['app_settings'][0]->date_f, strtotime($apiDate));


            }

            $pickup = $this->input->post('pickuplocation');
            $drop = $this->input->post('dropofflocation');
            $pickuptime = $this->input->post('pickupTime');
            $pickupdate = $this->input->post('pickupDate');
            $dropdate = $this->input->post('dropoffDate');
            $droptime = $this->input->post('dropoffTime');


            $this->load->library('Cars/Cars_lib');
            $bookingData = json_decode($this->Cars_lib->getUpdatedDataBookResultObject($itemid,$extras,$pickup,$drop,$pickupdate,$dropdate));
            $error = false;
        }



        // $grandtotal = $this->currconverter->convertPriceFloat($bookingData->grandTotal);
        $grandtotal = $this->currconverter->removeComma($bookingData->grandTotal);
        $checkin = databaseDate($checkin);
        $checkout = databaseDate($checkout);
        //$deposit = $this->currconverter->convertPriceFloat($bookingData->depositAmount);

        $deposit = $this->currconverter->removeComma($bookingData->depositAmount);
        $tax = $this->currconverter->removeComma($bookingData->taxAmount);
        $paymethodfee = 0;

        //$this->currconverter->convertPriceFloat($bookingData->paymethodFee);
        $extrasTotalFee = $this->currconverter->removeComma($bookingData->extrasInfo->extrasTotalFee);
        $currCode = $bookingData->currCode;
        $currSymbol = $bookingData->currSymbol;
        $subitem = json_encode($bookingData->subitem);
        $extras = json_encode($bookingData->extrasInfo->extrasIndividualFee);
        $adults = $this->input->post('adults');
        $child = $this->input->post('children');
        $stay = $bookingData->stay;
        $extrabedscharges = $this->currconverter->removeComma($bookingData->extraBedCharges);
        $refno = random_string('numeric', 4);
        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $couponRate = 0;
        $couponCode = 0;

        $coupon = $this->input->post('couponid');
        if($coupon > 0){

            $cResult = pt_applyCouponDiscount($coupon, $grandtotal);
            $cResultDeposit = pt_applyCouponDiscount($coupon, $deposit);
            $cResultTax = pt_applyCouponDiscount($coupon, $tax);

            $couponRate = $cResult->value;
            $couponCode = $cResult->code;

            $grandtotal = $cResult->amount;
            $deposit = $cResultDeposit->amount;
            $tax = $cResultTax->amount;


            $this->updateCoupon($coupon);

        }
        if (!$error) {
            $data = array('booking_ref_no' => $refno, 'booking_type' => $bookingtype, 'booking_item' => $itemid, 'booking_subitem' => $subitem, 'booking_extras' => $extras, 'booking_date' => time(), 'booking_expiry' => time() + $expiry, 'booking_user' => $userid, 'booking_status' => 'unpaid', 'booking_additional_notes' => $additionalnotes, 'booking_total' => $grandtotal, 'booking_remaining' => $grandtotal, 'booking_checkin' => $checkin, 'booking_checkout' => $checkout, 'booking_nights' => $stay, 'booking_adults' => $adults, 'booking_child' => $child,
                //    'booking_payment_type' => $paymethod,
                'booking_deposit' => $deposit, 'booking_tax' => $tax, 'booking_paymethod_tax' => $paymethodfee, 'booking_extras_total_fee' => $extrasTotalFee, 'booking_curr_code' => $currCode, 'booking_curr_symbol' => $currSymbol, 'booking_extra_beds' => $extrabeds, 'booking_extra_beds_charges' => $extrabedscharges, 'booking_coupon_rate' => $couponRate, 'booking_coupon' => $couponCode, 'booking_guest_info' => $passportInfo,'setting_id'=>$setting_id);
            $this->db->insert('pt_bookings', $data);
            $bookid = $this->db->insert_id();
            $this->session->set_userdata("BOOKING_ID", $bookid);
            $this->session->set_userdata("REF_NO", $refno);

            if ($bookingtype == "hotels") {
                foreach($rooms as $index => $roomID) {
                    $rdata = array('booked_booking_id' => $bookid, 'booked_room_id' => $bookingData->subitem[$index]->id, 'booked_room_count' => $bookingData->subitem[$index]->count, 'booked_checkin' => $checkin, 'booked_checkout' => $checkout, 'booked_booking_status' => 'unpaid');
                    $this->db->insert('pt_booked_rooms', $rdata);
                }
            }
            elseif ($bookingtype == "cars") {
                $cdata = array('booked_booking_id' => $bookid, 'booked_car_id' =>  $itemid, 'booked_pickupdate' => $checkin, 'booked_pickuptime' => $pickuptime, 'booked_pickuplocation' => $pickup, 'booked_dropofflocation' => $drop,'booked_dropoffDate' => databaseDate($dropdate), 'booked_dropoffTime' => $droptime, 'booked_booking_status' => 'unpaid');
                $this->db->insert('pt_booked_cars', $cdata);
            }

            $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
            $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url);
            $invoicedetails = invoiceDetails($bookid,$refno);

            $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
            $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
            $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
            $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        }
        else {
            $bookingResult = array("error" => "yes", 'msg' => 'Error occured');
        }

        return $bookingResult;
    }


    //Do quick booking by admin
    function doQuickBooking($userid){





        $this->load->library('currconverter');

        $itemid = $this->input->post('itemid');

        $subitemid = $this->input->post('subitemid');
        $setting_id = $this->input->post('setting_id');


        $roomscount = $this->input->post('roomscount');

        $bookingtype = $this->input->post('btype');

        $quickDeposit = $this->input->post('quickDeposit');

        $extras = $this->input->post('extras');

        $perNight = $this->input->post('perNight');

        $grandtotal = $this->input->post('grandtotal');

        $stay = $this->input->post('stay');



        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $paymethodfee = 0;







        $extrabeds = 0;//$this->input->post('bedscount');



        if ($bookingtype == "hotels") {

            $this->load->library('Hotels/Hotels_lib');

            $extrasInfo = $this->Hotels_lib->extrasFee($extras);

            $extrasData = json_encode($extrasInfo['extrasIndividualFee']);

            $subitemData = json_encode(array("id" => $subitemid, "price" => $perNight,"count" => $roomscount));



        }elseif($bookingtype == "tours"){

            $adults = $this->input->post('adults');

            $child = $this->input->post('children');

            $infant = $this->input->post('infants');





            /* $checkin = $this->input->post('checkin');

             $checkout = $this->input->post('checkin');

                  */





            $this->load->library('Tours/Tours_lib');

            $extrasInfo = $this->Tours_lib->extrasFee($extras);

            $extrasData = json_encode($extrasInfo['extrasIndividualFee']);

            $bookingData = json_decode($this->Tours_lib->getUpdatedDataBookResultObject($itemid, $adults,$child,$infant,$extras));

            $subitemData = json_encode($bookingData->subitem);

        }elseif($bookingtype == "rentals"){

            $adults = $this->input->post('adults');

            $child = $this->input->post('children');

            $infant = $this->input->post('infants');

            $this->load->library('Rentals/Rentals_lib');

            $extrasInfo = $this->Rentals_lib->extrasFee($extras);

            $extrasData = json_encode($extrasInfo['extrasIndividualFee']);

            $bookingData = json_decode($this->Rentals_lib->getUpdatedDataBookResultObject($itemid, $adults,$child,$infant,$extras));

            $subitemData = json_encode($bookingData->subitem);

        }elseif($bookingtype == "cars"){





            $this->load->library('Cars/Cars_lib');

            $extrasInfo = $this->Cars_lib->extrasFee($extras);

            $extrasData = json_encode($extrasInfo['extrasIndividualFee']);

            $bookingData = json_decode($this->Cars_lib->getUpdatedDataBookResultObject($itemid,$extras));

            $subitemData = json_encode($bookingData->subitem);

        }



        $checkin = databaseDate($this->input->post('checkin'));

        $checkout = databaseDate($this->input->post('checkout'));

        $tax = $this->input->post('taxamount');



        $extrasTotalFee = $this->input->post('totalsupamount');



        $currCode = $this->input->post('currencycode');

        $currSymbol = $this->input->post('currencysign');



        $extrabedscharges = 0;//$this->currconverter->convertPriceFloat($bookingData->extraBedCharges);

        $refno = random_string('numeric', 4);



        $data = array('booking_ref_no' => $refno, 'booking_type' => $bookingtype,

            'booking_item' => $itemid,

            'booking_subitem' => $subitemData,

            'setting_id' => $setting_id,

            'booking_extras' => $extrasData, 'booking_date' => time(),

            'booking_expiry' => time() + $expiry, 'booking_user' => $userid,

            'booking_status' => 'unpaid',

            'booking_additional_notes' => "",

            'booking_total' => $grandtotal,

            'booking_remaining' => $grandtotal,

            'booking_checkin' => $checkin,

            'booking_checkout' => $checkout,

            'booking_nights' => $stay,

            'booking_adults' => '1',

            'booking_child' => '0',

            'booking_payment_type' => $this->input->post('paymethod'),

            'booking_deposit' => $quickDeposit,

            'booking_tax' => $tax,

            'booking_paymethod_tax' => $paymethodfee,

            'booking_extras_total_fee' => $extrasTotalFee,

            'booking_curr_code' => $currCode,

            'booking_curr_symbol' => $currSymbol,

            'booking_extra_beds' => $extrabeds,

            'booking_extra_beds_charges' => $extrabedscharges

        );



        $this->db->insert('pt_bookings', $data);
        $bookid = $this->db->insert_id();







        if ($bookingtype == "hotels") {

            $rdata = array('booked_booking_id' => $bookid, 'booked_room_id' => $subitemid, 'booked_room_count' => $roomscount, 'booked_checkin' => $checkin, 'booked_checkout' => $checkout, 'booked_booking_status' => 'unpaid');

            $this->db->insert('pt_booked_rooms', $rdata);

        }

        elseif ($bookingtype == "cars") {

            $cdata = array('booked_booking_id' => $bookid, 'booked_car_id' => $this->input->post('itemid'), 'booked_checkin' => convert_to_unix($checkin), 'booked_checkout' => convert_to_unix($checkout), 'booked_booking_status' => 'unpaid');

            $this->db->insert('pt_booked_cars', $cdata);

        }



        $invoicedetails = invoiceDetails($bookid,$refno);



        $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);

        $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);

        $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
    }

    //Update booking details
    function update_booking($id) {
        $status = $this->input->post('status');
        $deposit = $this->input->post('totaltopay');
        $total = $this->input->post('grandtotal');
        $bookingtype = $this->input->post('btype');
        $bookid = $this->input->post('bookingid');
        if($status == "paid"){
            $remaining = $total - $deposit;
            $paid = $deposit;
            $paytime = time();
        }else{
            $remaining = $total;
            $paid = 0;
        }

        $data = array(
            'booking_status' => $status,
            'booking_deposit' => $deposit,
            'booking_payment_type' => $this->input->post('paymethod'),
            'booking_remaining' => $remaining,
            'booking_amount_paid' => $paid,
            'booking_payment_date' => $paytime
        );
        $this->db->where('booking_id',$bookid);
        $this->db->update('pt_bookings',$data);

        if ($bookingtype == "hotels") {

            $rdata = array('booked_booking_status' => $status);
            $this->db->where('booked_booking_id', $bookid);
            $this->db->update('pt_booked_rooms', $rdata);

        }elseif ($bookingtype == "cars") {
            $cdata = array('booked_booking_status' => $status);
            $this->db->where('booked_booking_id', $bookid);
            $this->db->update('pt_booked_cars', $cdata);
        }

        if($status == "paid"){
            $refno = $this->input->post('refcode');

            $invoicedetails = invoiceDetails($bookid,$refno);

            $this->Emails_model->paid_sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
            $this->Emails_model->paid_sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);
            $this->Emails_model->paid_sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
            $this->Emails_model->paid_sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);


        }

    }

    function delete_booking($id) {
        $this->db->where('booking_id', $id);
        $this->db->delete('pt_bookings');
        $this->db->where('booked_booking_id', $id);
        $this->db->delete('pt_booked_rooms');
        $this->db->where('review_booking_id', $id);
        $this->db->delete('pt_reviews');
        $this->db->where('booked_booking_id', $id);
        $this->db->delete('pt_booked_cars');
    }

    function cancel_booking($id) {
        $updata = array('booking_status' => 'cancelled');
        $this->db->where('booking_id', $id);
        $this->db->update('pt_bookings', $updata);
        $this->db->where('booked_booking_id', $id);
        $this->db->delete('pt_booked_rooms');
        $this->db->where('booked_booking_id', $id);
        $this->db->delete('pt_booked_cars');
        $this->db->where('review_booking_id', $id);
        $this->db->delete('pt_reviews');
    }

    // change booking status to paid
    function booking_status_paid($id) {
        $this->db->select('booking_total,booking_deposit,booking_type');
        $this->db->where('booking_id', $id);
        $bk = $this->db->get('pt_bookings')->result();
        $btotal = $bk[0]->booking_total;
        $bdep = $bk[0]->booking_deposit;
        $btype = $bk[0]->booking_type;
        $data1 = array('booking_status' => 'paid', 'booking_amount_paid' => $bdep, 'booking_remaining' => $btotal - $bdep, 'booking_payment_date' => time());
        $this->db->where('booking_id', $id);
        $this->db->update('pt_bookings', $data1);
        if ($btype == "hotels") {
            $data2 = array('booked_booking_status' => 'paid');
            $this->db->where('booked_booking_id', $id);
            $this->db->update('pt_booked_rooms', $data2);
        }
        elseif ($btype == "cruises") {
            $data2 = array('booked_booking_status' => 'paid');
            $this->db->where('booked_booking_id', $id);
            $this->db->update('pt_booked_cruise_rooms', $data2);
        }
        elseif ($btype == "cars") {
            $data3 = array('booked_booking_status' => 'paid');
            $this->db->where('booked_booking_id', $id);
            $this->db->update('pt_booked_cars', $data3);
        }
    }

    // change booking status to unpaid
    function booking_status_unpaid($id) {
        $this->db->select('booking_total,booking_deposit,booking_type');
        $this->db->where('booking_id', $id);
        $bk = $this->db->get('pt_bookings')->result();
        $btotal = $bk[0]->booking_total;
        $bdep = $bk[0]->booking_deposit;
        $btype = $bk[0]->booking_type;
        $data1 = array('booking_status' => 'unpaid', 'booking_amount_paid' => 0, 'booking_remaining' => $btotal,);
        $this->db->where('booking_id', $id);
        $this->db->update('pt_bookings', $data1);
        if ($btype == "hotels") {
            $data2 = array('booked_booking_status' => 'unpaid');
            $this->db->where('booked_booking_id', $id);
            $this->db->update('pt_booked_rooms', $data2);
        }
        elseif ($btype == "cruises") {
            $data2 = array('booked_booking_status' => 'unpaid');
            $this->db->where('booked_booking_id', $id);
            $this->db->update('pt_booked_cruise_rooms', $data2);
        }
        elseif ($btype == "cars") {
            $data3 = array('booked_booking_status' => 'unpaid');
            $this->db->where('booked_booking_id', $id);
            $this->db->update('pt_booked_cars', $data3);
        }
    }

    function cancel_booking_approve($id) {
        // delete booking and send email
        $useremail = $this->userinfo_by_bookingid($id);
        $this->Emails_model->booking_approve_cancellation_email($useremail);
        $this->cancel_booking($id);
        //  $this->delete_booking($id);
    }

    function cancel_booking_reject($id) {
        $data = array('booking_cancellation_request' => '2');
        $this->db->where('booking_id', $id);
        $this->db->update('pt_bookings', $data);
        $useremail = $this->userinfo_by_bookingid($id);
        $this->Emails_model->booking_reject_cancellation_email($useremail, $id);
    }

    function userinfo_by_bookingid($id) {
        $this->db->select('booking_user');
        $this->db->where('booking_id', $id);
        $res = $this->db->get('pt_bookings')->result();
        $user = $res[0]->booking_user;
        $uemail = $this->Accounts_model->get_user_email($user);
        return $uemail;
    }

    function get_booking_details_by_id($id) {
        $this->db->where('booking_id', $id);
        return $this->db->get('pt_bookings')->result();
    }

    function getBookingRefNo($id) {
        $this->db->select('booking_ref_no');
        $this->db->where('booking_id', $id);
        $res = $this->db->get('pt_bookings')->result();
        return $res[0]->booking_ref_no;
    }



    function bookingShortInfo($id){
        $this->db->select('booking_ref_no,booking_deposit,booking_type,booking_total,booking_deposit');
        $this->db->where('booking_id',$id);
        return $this->db->get('pt_bookings')->result();
    }

    function updateCoupon($couponid){

        $this->db->where('id',$couponid);
        $res = $this->db->get('pt_coupons')->result();
        $uses = $res[0]->uses + 1;

        $data = array(
            'uses' => $uses
        );
        $this->db->where('id',$couponid);

        $this->db->update('pt_coupons',$data);

    }


    public function flights_guest_booking($payload = array())
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['booking_user_id'] = $userid;

        return $this->flights_booking($payload);
    }


    public function flights_booking($payload = array())
    {
        $refno = random_string('numeric', 4);
        $data = array(
            'booking_ref_no' => $refno,
            'booking_supplier' => $payload['booking_supplier'],
            'flights_id' => $payload['flight_id'],
            'deposit_type' => $payload['deposit_type'],
            'tax_type' => $payload['tax_type'],
            'total_price' => $payload['total_price'],
            'booking_date' => time(),
            'booking_user_id' => $payload['booking_user_id'],
            'booking_remaining' => $payload['total_price'],
            'booking_status' => 'pending',
            'booking_additional_notes' => @$payload['additionalnotes'],
            'booking_infants' => $payload['booking_infants'],
            'booking_adults' => $payload['booking_adults'],
            'booking_childs' =>$payload['booking_childs'],
            'booking_deposit' => $payload['booking_deposit'],
            'booking_tax' => $payload['booking_tax'],
            'booking_curr_code' => $payload['booking_curr_code'],
            'booking_payment_gateway' => $payload['booking_payment_gateway'],
            'booking_guest_info' => $payload['guest'],
            'booking_key' => $payload['booking_key'],
            'supplier_name' => $payload['supplier_name'],
            'nationality' => $payload['nationality'],
            'booking_from' => $payload['booking_from'],
            'routes' => $payload['flights_data'],
        );
        $this->db->insert('flights_bookings', $data);
       $bookid = $this->db->insert_id();
        $bookingResult = array('id'=>$bookid,'sessid'=>$refno);
        return $bookingResult;
    }


    public function flights_invoice($payload = array()){
        $this->db->where('booking_id',$payload['booking_id']);
        $this->db->where('booking_ref_no',$payload['invoice_id']);
        $data =  $this->db->get('flights_bookings')->result();
        if(!empty($data)){
            $this->db->select('flights_bookings.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
            $this->db->where('flights_bookings.booking_id',$payload['booking_id']);
            $this->db->join('pt_accounts','flights_bookings.booking_user_id = pt_accounts.accounts_id','left');
            $invoiceData = $this->db->get('flights_bookings')->result();
            return   array('response'=>true,'booking_response'=>$invoiceData);
        }else{
            return   array('response'=>false,'booking_id'=>$payload['booking_id']);
        }
    }
    public function do_flights_guest_booking($payload = array())
    {
        $userid = $this->Accounts_model->signup_account('guest', '0');
        $payload['userId'] = $userid;

        return $this->do_flights_booking($payload);
    }

    public function do_flights_booking($payload = array())
    {
        $this->load->library('currconverter');

        $this->load->library('Flights/Flights_lib');
        $extras = (object)array('from' => $payload['from'],'to' => $payload['to'],'type'=> $payload['type']);
        $bookingData = json_decode($this->Flights_lib->getUpdatedDataBookResultObject($payload['itemid'],$payload['adults'],$payload['children'],$payload['infant'],$extras));

        $grandtotal = $this->currconverter->removeComma($bookingData->grandTotal);

        $deposit = $this->currconverter->removeComma($bookingData->depositAmount);
        $tax = $this->currconverter->removeComma($bookingData->taxAmount);
        $paymethodfee = 0;

        $extrasTotalFee = $this->currconverter->removeComma($bookingData->extrasInfo->extrasTotalFee);
        $currCode = $bookingData->currCode;
        $currSymbol = $bookingData->currSymbol;
        $subitem = json_encode($bookingData->subitem);
        $extras = json_encode($bookingData->extrasInfo->extrasIndividualFee);
        $stay = $bookingData->stay;
        $extrabedscharges = $this->currconverter->removeComma($bookingData->extraBedCharges);
        $refno = random_string('numeric', 4);
        $expiry = $this->data['app_settings'][0]->booking_expiry * 86400;

        $couponRate = 0;
        $couponCode = 0;

        $coupon = $payload['couponid'];
        if($coupon > 0)
        {
            $cResult = pt_applyCouponDiscount($coupon, $grandtotal);
            $cResultDeposit = pt_applyCouponDiscount($coupon, $deposit);
            $cResultTax = pt_applyCouponDiscount($coupon, $tax);

            $couponRate = $cResult->value;
            $couponCode = $cResult->code;

            $grandtotal = $cResult->amount;
            $deposit = $cResultDeposit->amount;
            $tax = $cResultTax->amount;

            $this->updateCoupon($coupon);
        }

        // Passengers passport detail
        $passports = $this->input->post('passport');
        $setting_id = $this->input->post('setting_id');
        $passportInfo = [];
        if ( ! empty($passports) ) {
            for ($i = 1; $i <= count($passports); $i++) {
                array_push($passportInfo, array(
                    'name' => $passports[$i]['name'],
                    'age' => $passports[$i]['age'],
                    'passportnumber' => $passports[$i]['passportnumber'],
                ));
            }
        }
        $passportInfo = json_encode($passportInfo);
        $data = array(
            'booking_ref_no' => $refno,
            'booking_type' => "flights",
            'booking_item' => $payload['itemid'],
            'booking_subitem' => $subitem,
            'setting_id' => $setting_id,
            'booking_extras' => $extras,
            'booking_date' => time(),
            'booking_expiry' => time() + $expiry,
            'booking_user' => $payload['userId'],
            'booking_status' => 'unpaid',
            'booking_additional_notes' => "",
            'booking_total' => $grandtotal,
            'booking_remaining' => $grandtotal,
            'booking_checkin' => "0000-00-00",
            'booking_checkout' => "0000-00-00",
            'booking_nights' => $stay,
            'booking_adults' => $payload['adults'],
            'booking_child' => $payload['children'],
            'booking_deposit' => $deposit,
            'booking_tax' => $tax,
            'booking_paymethod_tax' => $paymethodfee,
            'booking_extras_total_fee' => $extrasTotalFee,
            'booking_curr_code' => $currCode,
            'booking_curr_symbol' => $currSymbol,
            'booking_extra_beds' => "",
            'booking_extra_beds_charges' => $extrabedscharges,
            'booking_coupon_rate' => $couponRate,
            'booking_coupon' => $couponCode,
            'booking_guest_info' => $passportInfo,
        );
        $this->db->insert('pt_bookings', $data);
        $bookid = $this->db->insert_id();

        $this->session->set_userdata("BOOKING_ID", $bookid);
        $this->session->set_userdata("REF_NO", $refno);

        $url = base_url() . 'invoice?id=' . $bookid . '&sessid=' . $refno;
        $bookingResult = array("error" => "no", 'msg' => '', 'url' => $url);
        $invoicedetails = invoiceDetails($bookid,$refno);

        $this->Emails_model->sendEmail_customer($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_admin($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_owner($invoicedetails,$this->data['app_settings'][0]->site_title);
        $this->Emails_model->sendEmail_supplier($invoicedetails,$this->data['app_settings'][0]->site_title);

        return $bookingResult;
    }



}
