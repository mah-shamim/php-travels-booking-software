<?php
header('Access-Control-Allow-Origin: *');
class Invoice extends MX_Controller {
  function __construct() {
    parent::__construct();

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
    $this->data['phone'] = $this->load->get_var('phone');
    $this->data['errormsg'] = $this->session->flashdata("invoiceerror");
    $this->data['lang_set'] = $this->session->userdata('set_lang');
    $defaultlang = pt_get_default_language();
    if (empty($this->data['lang_set'])) {
      $this->data['lang_set'] = $defaultlang;
    }
    $this->data['usersession'] = $this->session->userdata('pt_logged_id');
    $this->lang->load("front", $this->data['lang_set']);
  }
/**
* For mobile
*/
  public function flight() {
    $this->load->model('Travelport_flight/TravelportModel_Cart');
    $cart = new TravelportModel_Cart();
    $PNR = $this->input->get('token', TRUE);
    $this->data = [];
    $this->data['message'] = NULL;
    $this->data['dataAdapter'] = $cart->get_invoice($PNR);
    $this->data['invoice_access_token'] = $PNR;
    $invoice_view = $this->theme->partial('modules/travelport/flight/invoice', $this->data, TRUE);
    $this->output->set_content_type('text/html');
    $this->output->set_output($invoice_view);
  }
  public function index() {
// Redirect to the same page after complete payment transaction
// This logic is for credimax gateway, checkout Credimaxinvoice controller
      $_SESSION['paymentGatewayAfterCompleteRedirect'] = $_SERVER['REQUEST_URI'];
    $this->load->helper('invoice');
    $this->data['hideLang'] = "hide";
    $this->data['hideCurr'] = "hide";
    $this->data['hidden'] = "hidden-sm hidden-xs";
    $bookingid = $this->input->get('id');
    $bookingref = $this->input->get('sessid');
    $ebookingid = $this->input->get('eid');
    $payerID = $this->input->get('PayerID');
    $token = $this->input->get('token');
    $this->data['hideHeader'] = "1";
      if (!empty($ebookingid)) {
      $this->data['invoice'] = pt_get_einvoice_details($ebookingid, $bookingref);
      $this->data['response'] = json_decode($this->data['invoice'][0]->book_response);
      if (empty($this->data['invoice'])) {
        redirect(base_url());
      }
      else {
        $this->lang->load("front", $this->data['lang_set']);
        $contact = $this->Settings_model->get_contact_page_details();
        $this->data['contactphone'] = $contact[0]->contact_phone;
        $this->data['contactemail'] = $contact[0]->contact_email;
        $this->data['contactaddress'] = $contact[0]->contact_address;
        $this->data['page_title'] = 'Invoice';
        $this->load->view('Admin/modules/global/einvoice', $this->data);
      }
    }
    else {
      if (empty($bookingref) || empty($bookingid)) {
        $bookingid = $this->session->userdata("BOOKING_ID");
        $bookingref = $this->session->userdata("REF_NO");
      }
      $this->data['invoice'] = invoiceDetails($bookingid, $bookingref);
      if (empty($this->data['invoice']->id)) {
        redirect(base_url());
      }
      else {
//for paypal express
        if (!empty($token) && !empty($payerID)) {
          $this->load->model("Admin/Bookings_model");
          $gateway = "paypalexpress";
          require_once "./application/modules/Gateways/" . $gateway . ".php";
          $this->load->model('Admin/Payments_model');
          $extraFields = array('token' => $token, 'payerid' => $payerID);
          $params = $this->Payments_model->getGatewayParams($gateway);
          $params['invoiceid'] = $bookingid;
          if (function_exists($gateway . "_verifypayment")) {
            $payResult = call_user_func($gateway . "_verifypayment", $params, $extraFields);
          }
          if ($payResult['status'] == "success") {
            $shortInfo = $this->Bookings_model->bookingShortInfo($payResult['invoiceid']);
            if ($shortInfo[0]->booking_deposit == $payResult['paid']) {
              updateInvoiceStatus($payResult['invoiceid'], $payResult['paid'], $payResult['transactionid'], $gateway, "paid", $shortInfo[0]->booking_type, $shortInfo[0]->booking_total);
              $invoicedetails = invoiceDetails($payResult['invoiceid'], $shortInfo[0]->booking_ref_no);
              $this->load->model('Admin/Emails_model');
              $this->Emails_model->paid_sendEmail_customer($invoicedetails);
              $this->Emails_model->paid_sendEmail_admin($invoicedetails);
              $this->Emails_model->paid_sendEmail_supplier($invoicedetails);
              $this->Emails_model->paid_sendEmail_owner($invoicedetails);
              redirect(base_url() . 'invoice?id=' . $bookingid . '&sessid=' . $bookingref, 'refresh');
            }
            else {
              echo "Amount is invalid";
              exit;
            }
          }
          else {
            print_r($payResult);
            exit;
          }
        }
        else {
          $this->lang->load("front", $this->data['lang_set']);
          $amountSess = $this->session->userdata('checkout_amount');
          $totalpaySess = $this->session->userdata('checkout_total');
          if (empty($amountSess)) {
            $this->session->set_userdata('checkout_amount', $this->data['invoice']->checkoutAmount);
          }
          if (empty($totalpaySess)) {
            $this->session->set_userdata('checkout_total', $this->data['invoice']->checkoutTotal);
          }
          if ($this->data['invoice']->status != "paid") {
            $this->load->model('Admin/Payments_model');
            $paygateways = $this->Payments_model->getAllPaymentsBack();
            $this->data['msg'] = json_decode($this->Payments_model->getGatewayMsg($this->data['invoice']->paymethod, $this->data['invoice']));
            $this->data['paymentGateways'] = $paygateways['activeGateways'];
            $this->data['payOnArrival'] = $this->Payments_model->payOnArrivalIsActive($paygateways['activeGateways']);
            $singleGateway = $this->Payments_model->onlySinglePaymentGatewayActive($paygateways['activeGateways']);
            if ($singleGateway['status'] == "yes") {
              $this->data['singleGateway'] = $singleGateway['name'];
            }
            else {
              $this->data['singleGateway'] = "";
            }
          }
//sort on basic of order
          usort($this->data['paymentGateways'],
          function ($a, $b) {
            return $a['order'] - $b['order'];
          }
          );
          $contact = $this->Settings_model->get_contact_page_details();
          $this->data['contactphone'] = $contact[0]->contact_phone;
          $this->data['contactemail'] = $contact[0]->contact_email;
          $this->data['contactaddress'] = $contact[0]->contact_address;
          $this->setMetaData("Invoice");
          if($this->data['invoice']->module == "flights")
          {
              $this->load->model('Flights/Flights_model');
              $flight_data = $this->Flights_model->get_flights_data($this->data['invoice']->bookingID,$this->data['invoice']->itemid);
              $tax = $this->Flights_model->get_taxdeposite($this->data['invoice']->setting_id);
              $this->data['flight_data'] = $flight_data[1];
              $this->data['item'] = $flight_data[0];
              $this->data['tax'] = $tax;
          }
          $this->theme->view('Admin/modules/global/invoice', $this->data, $this);
       // $this->load->view('Admin/modules/global/invoice', $this->data);
        }
      }
    }
  }
  function validate_coupon() {
    $code = $this->input->post('code');
    $bookingid = $this->input->post('bookingid');
    $this->load->model('Admin/Coupons_model');
    $resp = $this->Coupons_model->validatecoupon($code);
    if ($resp > 0) {
      $amount = $this->session->userdata('checkout_amount');
      $totalpay = $this->session->userdata('checkout_total');
      $alteredamount = $amount * $resp / 100;
      $alteredtotal = $totalpay * $resp / 100;
      $amount = $amount - round($alteredamount, 2);
      $totalpay = $totalpay - round($alteredtotal, 2);
      $data = array('coupon_used' => '1');
      $this->db->where('coupon_code', $code);
      $this->db->update('pt_coupons', $data);
      $data2 = array('booking_deposit' => $amount, 'booking_total' => $totalpay, 'booking_remaining' => $totalpay, 'booking_coupon' => $code, 'booking_coupon_rate' => $resp);
      $this->db->where('booking_id', $bookingid);
      $this->db->update('pt_bookings', $data2);
      echo $resp;
    }
    else {
      echo $resp;
    }
  }
  function updatePayOnArrival() {
    if ($this->input->is_ajax_request()) {
      if (!empty($_POST)) {
        $id = $this->input->post('id');
        $module = $this->input->post('module');
        $data = array('booking_status' => 'reserved', 'booking_payment_type' => 'payonarrival');
        $this->db->where('booking_id', $id);
        $this->db->update('pt_bookings', $data);
        if ($module == "hotels") {
          $data2 = array('booked_booking_status' => 'reserved');
          $this->db->where('booked_booking_id', $id);
          $this->db->update('pt_booked_rooms', $data2);
        }
      }
    }
  }
  function getGatewaylink($bookingid, $bookingref) {
    $this->load->helper('invoice');
    if ($this->input->is_ajax_request()) {
      if (!empty($_POST)) {
        $invoicdata = invoiceDetails($bookingid, $bookingref);
        $this->load->model('Admin/Payments_model');
        $gateway = $this->input->post('gateway');
        echo $this->Payments_model->getGatewayMsg($gateway, $invoicdata);
      }
    }
  }
  function notifyUrl($gateway) {
    $invoiceRedirect = array('ccavenue', 'faturah', 'directpay3g', 'payu');
    $this->load->helper('invoice');
    $payResult = array();
    $postdata = $this->input->post();
    $getdata = $this->input->get();
    if (!empty($postdata) || !empty($getdata)) {
      require_once "./application/modules/Gateways/" . $gateway . ".php";
      $this->load->model('Admin/Payments_model');
      $params = $this->Payments_model->getGatewayParams($gateway);
      if (function_exists($gateway . "_verifypayment")) {
        $payResult = call_user_func($gateway . "_verifypayment", $params);
      }
      $this->load->model("Admin/Bookings_model");
/*	$fileData = (object)$payResult;
$filename = $fileData->file.".json";

file_put_contents("application/".$filename, json_encode($fileData,JSON_PRETTY_PRINT));*/
      $shortInfo = $this->Bookings_model->bookingShortInfo($payResult['invoiceid']);
      $payResultObj = (object) $payResult;
      if ($payResult['status'] == "success") {
        if ($shortInfo[0]->booking_deposit == $payResult['paid']) {
          updateInvoiceStatus($payResult['invoiceid'], $payResult['paid'], $payResult['transactionid'], $gateway, "paid", $shortInfo[0]->booking_type, $shortInfo[0]->booking_total);
          updateInvoiceLogs($payResultObj->invoiceid, $payResultObj->logs);
          $invoicedetails = invoiceDetails($payResult['invoiceid'], $shortInfo[0]->booking_ref_no);
          $this->load->model('Admin/Emails_model');
          $this->Emails_model->paid_sendEmail_customer($invoicedetails);
          $this->Emails_model->paid_sendEmail_admin($invoicedetails);
          $this->Emails_model->paid_sendEmail_supplier($invoicedetails);
          $this->Emails_model->paid_sendEmail_owner($invoicedetails);
        }
      }
      else {
        updateInvoiceLogs($payResultObj->invoiceid, $payResultObj->logs);
      }
      if (in_array($gateway, $invoiceRedirect)) {
        redirect(base_url() . 'invoice?id=' . $payResult['invoiceid'] . '&sessid=' . $shortInfo[0]->booking_ref_no);
      }
    }
  }
  function callGatewayFunc($gateway, $function) {
    $postdata = $this->input->post();
    if (!empty($postdata)) {
      require_once "./application/modules/Gateways/" . $gateway . ".php";
      $this->load->model('Admin/Payments_model');
      $params = $this->Payments_model->getGatewayParams($gateway);
      if (function_exists($gateway . "_" . $function)) {
        call_user_func($gateway . "_" . $function, $params);
      }
      else {
        redirect(base_url());
      }
    }
    else {
      redirect(base_url());
    }
  }
}