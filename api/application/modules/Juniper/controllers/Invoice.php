<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 4/29/2019
 * Time: 10:45 PM
 */
class Invoice extends MX_Controller
{
    const MODULE = "Juniper";
    const THEME_MODULE = "modules/hotels/juniper/";

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

        $this->load->model('Juniper/Juniper_model');
    }

    /**
     * Show invoice of the specified booking.
     *
     * @param int $invoice_id
     */
    public function index($invoice_id = 0)
    {
        $this->data['pageTitle'] = 'Juniper Hotel Invoice' ;
        $this->data['header_title'] = 'Invoice';
        $invoice = $this->parseInvoiceData($invoice_id);
        $this->data['invoice'] = $invoice;
        $this->theme->view(self::THEME_MODULE.'/invoice', $this->data, $this);
    }

    /**
     * @param $booking
     * @return stdClass
     */
    private function parseInvoiceData($booking)
    {
        $bookingRequest = $this->Juniper_model->getBooking($booking);
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
        //dd($data->Items->HotelItem);
        $invoice->booking_number = $data->Items->HotelItem->ItemId;
        $invoice->bookingRemarks = '';
        $invoice->roomTypename = $data->Items->HotelItem->HotelRooms->HotelRoom->Name;
        $invoice->boardTypename = '';
        $invoice->address = $data->Items->HotelItem->HotelInfo->Address;
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