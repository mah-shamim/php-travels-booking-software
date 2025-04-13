<?php
class Invoice extends MX_Controller
{
    const Module = 'Kiwitaxi';

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
        $this->load->model('Kiwitaxi/Kiwitaxi_model');


    }

    /**
     * Show Payment Status of the specified booking.
     */
    public function index()
    {
        $url_array = $this->uri->segment_array();

        /*decryption id*/

        $id = ((0x0000FFFF & $url_array[3]) << 16) + ((0xFFFF0000 & $url_array[3]) >> 16);



        if($url_array[4] == 'paid'){
            $this->Kiwitaxi_model->updatestatus($id,1);
            $status =  $url_array[4];
        }else if($url_array[4] == 'fail'){
            $this->Kiwitaxi_model->updatestatus($id,2);
            $status = $url_array[4];
        }else if($url_array[4] == 'cancel'){
            $this->Kiwitaxi_model->updatestatus($id,3);
            $status = $url_array[4];
        }else{
            $status  = 'Unpaid';
        }



        $this->data['pageTitle'] = 'Invoice-'.$status;
        $this->data['bookingstatus'] = $status;
        $inovice = $this->Kiwitaxi_model->getData($id);
        $this->data['id'] = $inovice['0']->id;
        $this->data['bookingToken'] = $inovice['0']->bookingToken;
        $this->data['first_name'] = $inovice['0']->first_name;
        $this->data['last_name'] = $inovice['0']->last_name;
        $this->data['phone'] = $inovice['0']->phone;
        $this->data['email'] = $inovice['0']->email;
        $this->data['transfer_id'] = $inovice['0']->transfer_id;
        $this->data['date_time'] = $inovice['0']->date_time;
        $this->data['flight_form'] = str_replace('+',' ',$inovice['0']->flight_form);
        $this->data['loaction'] = str_replace('+',' ',$inovice['0']->loaction);
        $this->data['pax'] = $inovice['0']->pax;
        $this->data['child'] = $inovice['0']->child;
        $this->data['flight_no'] = $inovice['0']->flight_no;
        $this->data['taxi_image'] = $inovice['0']->taxi_image;
        $this->data['taxi_name'] = $inovice['0']->taxi_name;
        $this->data['amount'] = $inovice['0']->amount;
        $this->data['currency'] = $inovice['0']->currency;

        if($inovice['0']->status == 1){
            $this->data['status'] = 'Paid';
        }else if($inovice['0']->status == 2){
            $this->data['status'] = 'Fail';
        }else if($inovice['0']->status == 3){
            $this->data['status'] = 'Cancel';
        }else{
            $this->data['status'] = 'Unpaid';
        }

        if($inovice['0']->payment_type == 'full'){
            $this->data['payment_type'] = lang('0609');
        }else{
            $this->data['payment_type'] = lang('0345');
        }
        if(!empty($inovice['0']->taxi_msg)){
            $this->data['taxi_msg'] = $inovice['0']->taxi_msg;
        }else{
            $this->data['taxi_msg'] = lang('0178');
        }
        $date_time = explode("+",$inovice['0']->date_time);
        $this->data['time'] = date('h:i a', strtotime($date_time[1]));
        $this->data['date'] = date('M d, Y', strtotime($date_time[0]));
        $this->theme->view('modules/cars/kiwitaxi/invoice', $this->data, $this);
    }
}