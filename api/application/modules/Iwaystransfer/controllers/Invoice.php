<?php
class Invoice extends MX_Controller
{
    const Module = 'Iwaystransfer';

    public function __construct()
    {
        parent :: __construct();

        $chk = $this->App->service('ModuleService')->isActive(self::Module);
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

        $this->data['appModule'] = self::Module;
        $this->load->model('Iwaystransfer/Iwaystransfer_model');


    }

    /**
     * Show Payment Status of the specified booking.
     */
    public function index()
    {
        $url_array = $this->uri->segment_array();
        /*decryption id*/

        $id = ((0x0000FFFF & $url_array[3]) << 16) + ((0xFFFF0000 & $url_array[3]) >> 16);

        $status  = 'Unpaid';


        $this->data['pageTitle'] = 'Invoice-'.$status;
        $this->data['bookingstatus'] = $status;
        $inovice = $this->Iwaystransfer_model->getData($id);
        $this->data['id'] = $inovice['0']->id;
        $this->data['bookingToken'] = $inovice['0']->booking_code;
        $this->data['first_name'] = $inovice['0']->first_name;
        $this->data['last_name'] = $inovice['0']->last_name;
        $this->data['phone'] = $inovice['0']->phone;
        $this->data['email'] = $inovice['0']->email;
        $this->data['transfer_id'] = $inovice['0']->transfer_id;
        $this->data['date_time'] = $inovice['0']->date_time;
        $this->data['flight_form'] = $inovice['0']->laoction_form;
        $this->data['loaction']  = $inovice['0']->laoction_to;
        $this->data['pax'] = $inovice['0']->pax;
        $this->data['child'] = 0;
        $this->data['flight_no'] = $inovice['0']->flight_no;
        $this->data['taxi_image'] = $inovice['0']->taxi_image;
        $this->data['taxi_name'] = $inovice['0']->taxi_name;
        $this->data['amount'] = $inovice['0']->amount;
        $this->data['currency'] = $inovice['0']->currency;
        $this->data['status'] = 'Unpaid';
        $this->data['taxi_msg'] = $inovice['0']->msg;
        $this->data['date'] = $inovice['0']->fromdata2;
        $this->theme->view('modules/cars/iwaystransfer/invoice', $this->data, $this);
    }
}