<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Bookings extends MX_Controller { 
    private $myitems = array();
    public $role;
    public  $editpermission = true; 
    public  $deletepermission = true;

    function __construct() {
        modules :: load('supplier');
        $chksupplier = modules :: run('Supplier/validsupplier');
        $this->myitems = modules :: run('Supplier/myitems');

        if (!$chksupplier) {
            $this->session->set_userdata('prevURL', current_url());
            redirect('supplier');
        }

        $this->data['app_settings'] = $this->Settings_model->get_settings_data();
        $this->load->model('Supplier/Bookings_model');
        $this->data['issupplier'] = $this->session->userdata('pt_logged_supplier');
        $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
        $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;
        $this->data['addpermission'] = true;

        $this->editpermission = pt_permissions("editbooking", $this->data['userloggedin']);
        $this->deletepermission = pt_permissions("deletebooking", $this->data['userloggedin']);
        $this->data['addpermission'] = pt_permissions("addbooking", $this->data['userloggedin']);

        $this->data['adminsegment'] = $this->uri->segment(1);
        $this->data['myitems'] = $this->myitems;
    }

    function index() {
        $supplier_id = $this->session->userdata('pt_logged_id');
        $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
        $this->data['main_content'] = 'admin/bookings';
        $this->data['page_title'] = 'All Bookings View';
        $this->load->view('admin/template', $this->data);
    }


    function dashboardBookings(){

        $this->load->helper('xcrud');
        $xcrud = xcrud_get_instance();
        $xcrud->table('pt_bookings');
        if(!empty($this->myitems)){
         $xcrud->where('pt_bookings.booking_item',$this->myitems);
     }else{
        $xcrud->where('pt_bookings.booking_item','0');
     }

        $xcrud->join('booking_user', 'pt_accounts', 'accounts_id');
        $xcrud->order_by('booking_id', 'desc');
        $xcrud->columns('booking_id,booking_ref_no,pt_accounts.ai_first_name,booking_type,booking_date,booking_total,booking_amount_paid,booking_remaining,booking_status');
        $xcrud->label('booking_id', 'ID')->label('booking_ref_no', 'Ref No.')->label('pt_accounts.ai_first_name', 'Customer')->label('booking_type', 'Module')->label('booking_date', 'Date')->label('booking_total', 'Total')->label('booking_amount_paid', 'Paid')->label('booking_remaining', 'Remaining')->label('booking_status', 'Status');
        $xcrud->column_callback('booking_date', 'fmtDate');
        $xcrud->search_columns('booking_id,booking_ref_no,pt_accounts.ai_first_name,booking_type,booking_status');
        $xcrud->column_callback('booking_status', 'bookingStatusBtns');
        $xcrud->button(base_url() . 'invoice/?id={booking_id}&sessid={booking_ref_no}', 'View Invoice', 'fa fa-search-plus', 'btn btn-primary', array('target' => '_blank'));

        if($this->editpermission){
        $xcrud->button(base_url() . $this->data['adminsegment'] . '/bookings/edit/{booking_type}/{booking_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
        }

        if($this->deletepermission){
        $delurl = base_url() . 'supplier/bookings/delBooking';
        $xcrud->button("javascript: delfunc('{booking_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self'));
        }


        $xcrud->unset_add();
        $xcrud->unset_view();
        $xcrud->unset_remove();
        $xcrud->unset_edit();
        $xcrud->unset_print();
        $xcrud->unset_csv();
        $this->data['content'] = $xcrud->render();
        $this->data['page_title'] = 'Recent Bookings';
        $this->data['main_content'] = 'temp_view';
        $this->data['header_title'] = 'Recent Bookings';
        $this->load->view('temp_view', $this->data);
    }




//resend invoice
    function resendinvoice() {
        $invoiceid = $this->input->post('id');
        $refno = $this->input->post('refno');
        $this->load->helper('invoice');
        $invoicedetails = invoiceDetails($invoiceid, $refno);
        $this->load->model('Admin/Emails_model');
        $this->Emails_model->resend_invoice($invoicedetails);
    }

    function edit($module, $id) {
         if(!$this->editpermission){
                 echo "<center><h1>Access Denied</h1></center>";
                 backError_404($this->data);
                  }else{
        $this->load->helper('invoice');
        $this->load->model('Admin/Payments_model');
        $this->data['paygateways'] = $this->Payments_model->getAllPaymentsBack();
        $this->data['supptotal'] = 0;
        $updatebooking = $this->input->post('updatebooking');
        if (!empty ($updatebooking)) {
            $this->Bookings_model->update_booking($id);
            redirect(base_url() . "supplier/bookings");
        }
        if (!empty ($module) && !empty ($id)) {
            $this->data['chklib'] = $this->ptmodules;
            $refNo = $this->Bookings_model->getBookingRefNo($id);
            $this->data['bdetails'] = invoiceDetails($id, $refNo);
            $this->data['service'] = $this->data['bdetails']->module;
            $this->data['applytax'] = "yes";
            foreach ($this->data['bdetails']->bookingExtras as $extras) {
                $bookedextras[] = $extras->id;
                $extrasprices[] = $extras->price;
            }
            $this->data['bookedsups'] = $bookedextras;
            $this->data['supptotal'] = array_sum($extrasprices);
//hotels module
            if ($module == "hotels") {
                $this->load->library('Hotels/Hotels_lib');
                $this->Hotels_lib->set_id($this->data['bdetails']->itemid);
                $this->Hotels_lib->hotel_short_details();
                $this->data['tax_type'] = $this->Hotels_lib->tax_type;
                $this->data['tax_val'] = $this->Hotels_lib->tax_value;
                $this->data['commtype'] = $this->Hotels_lib->comm_type;
                $this->data['commvalue'] = $this->Hotels_lib->comm_value;
                $this->data['selectedroom'] = $this->data['bdetails']->subItem->id;
                $this->data['subitemprice'] = $this->data['bdetails']->subItem->price;
                $this->data['rquantity'] = $this->data['bdetails']->subItem->quantity;
                $this->data['rto    tal'] = $this->data['bdetails']->subItem->price * $this->data['bdetails']->subItem->quantity * $this->data['bdetails']->nights;
                $this->data['hrooms'] = $this->Hotels_lib->rooms_id_title_only();
                $this->data['sups'] = $this->Hotels_lib->hotelExtras();
                $this->data['hotelslib'] = $this->Hotels_lib;
                $this->data['totalrooms'] = $this->Hotels_lib->room_total_quantity($this->data['bdetails']->subItem->id);
                $this->data['checkinlabel'] = "Check-In";
                $this->data['checkoutlabel'] = "Check-Out";
            }

            $this->data['main_content'] = 'modules/bookings/edit';
            $this->data['page_title'] = 'Edit Booking';
            $this->load->view('Admin/template', $this->data);
        }
        else {
            redirect('supplier/bookings');
        }
     }
    }

    function split_subitem($string) {
        return explode("_", $string);
    }

    // delete single booking
        function delBooking() {
            if (!$this->input->is_ajax_request()) {
                redirect('admin');
            }
            else {
                $id = $this->input->post('id');
                $this->Bookings_model->delete_booking($id);
                $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
            }
        }

    // Delete Multiple Bookings
        function delMultipleBookings(){
              if (!$this->input->is_ajax_request()) {
                redirect('admin');
            }
            else {
                $items = $this->input->post('items');
                foreach($items as $item){
                $this->Bookings_model->delete_booking($item);

                }

                }
        }


            // pending booking details
        function pending() {
        $supplier_id = $this->session->userdata('pt_logged_id');
        $booking_status = 'pending';
        $booking_payment_status = '';
    $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
        $this->data['main_content'] = 'Admin/bookings';
        $this->data['page_title'] = 'Pending Bookings View';
        $this->load->view('Admin/template', $this->data);
    }


            // confirmed booking details
        function confirmed() {
        $supplier_id = $this->session->userdata('pt_logged_id');
        $booking_status = 'confirmed';
        $booking_payment_status = '';
    $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
        $this->data['main_content'] = 'Admin/bookings';
        $this->data['page_title'] = 'confirmed Bookings View';
        $this->load->view('Admin/template', $this->data);
    }    
            // cancelled booking details
        function cancelled() {
        $supplier_id = $this->session->userdata('pt_logged_id');
        $booking_status = 'cancelled';
        $booking_payment_status = '';
    $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
        $this->data['main_content'] = 'Admin/bookings';
        $this->data['page_title'] = 'cancelled Bookings View';
        $this->load->view('Admin/template', $this->data);
    }

            // unpaid booking details
        function unpaid() {
        $supplier_id = $this->session->userdata('pt_logged_id');
        $booking_status = '';
        $booking_payment_status = 'unpaid';
    $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
        $this->data['main_content'] = 'Admin/bookings';
        $this->data['page_title'] = 'unpaid Bookings View';
        $this->load->view('Admin/template', $this->data);
    }        
            // paid booking details
        function paid() {
        $supplier_id = $this->session->userdata('pt_logged_id');
        $booking_status = '';
        $booking_payment_status = 'paid';
    $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
        $this->data['main_content'] = 'Admin/bookings';
        $this->data['page_title'] = 'paid Bookings View';
        $this->load->view('Admin/template', $this->data);
    }       
// disputed booking details
    function refunded() {
    $supplier_id = $this->session->userdata('pt_logged_id');
    $booking_status = '';
    $booking_payment_status = 'refunded';
    $this->data['all_booking'] = $this->Bookings_model->supplier_get_all_bookings($booking_status,$booking_payment_status,$supplier_id);
    $this->data['main_content'] = 'Admin/bookings';
    $this->data['page_title'] = 'refunded Bookings View';
    $this->load->view('Admin/template', $this->data);
    }

    
    public function update_booking_status()
    {
        $booking_id = $this->input->post('booking_id');
        $module = $this->input->post('module');
        $booking_status = $this->input->post('booking_status');
        $result = $this->Bookings_model->update_booking_status($booking_id, $module, $booking_status);
        if ($result) {
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }

    }

public function update_paybooking_status()
    {
        $booking_id = $this->input->post('booking_id');
        $module = $this->input->post('module');
        $update_paybooking_status = $this->input->post('update_paybooking_status');
        $result = $this->Bookings_model->update_paybooking_status($booking_id, $module, $update_paybooking_status);
        if ($result) {
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }

    } 

public function booking_del()
    {
        $booking_id = $this->input->post('booking_id');
        $module = $this->input->post('module');
        $result = $this->Bookings_model->booking_del($booking_id, $module);
        if ($result) {
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }

    }

}
