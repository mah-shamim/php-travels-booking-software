<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 4/29/2019
 * Time: 10:45 PM
 */
class Invoice extends MX_Controller
{
    const MODULE = "Hotelston";
    const THEME_MODULE = "modules/hotels/hotelston/";

    public function __construct()
    {
        parent :: __construct();

        $chk = $this->App->service('ModuleService')->isActive(self::MODULE);
        if (!$chk) { Error_404($this); }

        modules::load('Front');
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();

        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }

        $this->lang->load("front", $this->data['lang_set']);
        $contact = $this->Settings_model->get_contact_page_details();
        $this->data['contactphone'] = $contact[0]->contact_phone;
        $this->data['contactemail'] = $contact[0]->contact_email;
        $this->data['contactaddress'] = $contact[0]->contact_address;

        $this->data['appModule'] = self::MODULE;

        $this->load->model('Hotelston/Hotelston_model');
    }

    /**
     * Show invoice of the specified booking.
     *
     * @param int $invoice_id
     */
    public function index($invoice_id = 0)
    {
        $this->data['pageTitle'] = 'Hotelston Invoice' ;
        $this->data['header_title'] = 'Invoice';
        $invoice = $this->parseInvoiceData($invoice_id);
        $this->data['invoice'] = $invoice;
        $this->load->model('Admin/Payments_model');
        $paygateways = $this->Payments_model->getAllPaymentsBack();
        $singleGateway = $this->Payments_model->onlySinglePaymentGatewayActive($paygateways['activeGateways']);
        $this->data['paymentGateways'] = $paygateways['activeGateways'];
        $this->data['singleGateway'] = $singleGateway['name'];
        $notification_flag = $this->input->get('n');
        $this->data['notification_flag'] = ($notification_flag == 'y') ? 1 : 0;
        $this->data['notifiable_emails'] = array($this->session->userdata('email'));
        $this->theme->view(self::THEME_MODULE.'/invoice', $this->data, $this);
    }

    /**
     * @param $booking
     * @return stdClass
     */
    private function parseInvoiceData($booking)
    {
        $bookingRequest = $this->Hotelston_model->getBooking($booking);
        $invoice = new stdClass();
        $invoice->id = $bookingRequest[0]->id;
        $invoice->booking_code = '';
        $invoice->additionaNotes = "";
        $invoice->currency_code = $bookingRequest[0]->currency;
        $invoice->total_amount = $bookingRequest[0]->price;
        $invoice->total_nights = "";
        $invoice->checkin = $bookingRequest[0]->checkIn;
        $invoice->checkout = $bookingRequest[0]->checkOut;
        $invoice->room_name = $bookingRequest[0]->hotel_data->room_name;
        $invoice->hotel_image = $bookingRequest[0]->images;
        $invoice->hotel_location = $bookingRequest->hotel_data->address;
        $invoice->hotel_name = $bookingRequest[0]->company_name;
        $data = json_decode($bookingRequest[0]->bookingDetails);
        $invoice->booking_number = $data->bookingReference;
        $invoice->bookingRemarks = strip_tags($data->hotel->rooms->room->bookingTerms->bookingRemarks);
        $invoice->roomTypename = $data->hotel->rooms->room->roomType->name;
        $invoice->boardTypename = $data->hotel->rooms->room->boardType->name;
        $invoice->address = $data->hotel->address;
        $invoice->agentReferenceNumber = $bookingRequest[0]->agentReferenceNumber;
        $invoice->status = $bookingRequest[0]->status;
        $invoice->accounts_email = $bookingRequest[0]->accounts_email;
        $invoice->userFullName = $bookingRequest[0]->ai_first_name ." ".$bookingRequest[0]->ai_last_name;
        $invoice->userAddress = $bookingRequest[0]->ai_address_1 ." ".$bookingRequest[0]->ai_address_2;
        $invoice->userMobile = $bookingRequest[0]->ai_mobile;
        $checkin = $bookingRequest[0]->checkIn;
        $checkOut = $bookingRequest[0]->checkOut;
        $now = strtotime($checkin); // or your date as well
        $your_date = strtotime($checkOut);
        $datediff =  $your_date - $now;
        $invoice->nights = round($datediff / (60 * 60 * 24));
        $invoice->guest = '';
        $invoice->created_at = '';

        return $invoice;
    }



}