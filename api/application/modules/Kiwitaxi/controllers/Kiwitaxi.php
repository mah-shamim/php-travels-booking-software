<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
Class Kiwitaxi extends MX_Controller{

    const Module = "Kiwitaxi";
    private $config = [];
    public function __construct()
    {
        parent :: __construct();
        $chk = $this->App->service('ModuleService')->isActive(self::Module);
        if (!$chk) {
            Error_404($this);
        }

        modules::load('Front');
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }
        $this->lang->load("front", $this->data['lang_set']);
        $this->data['appModule'] = self::Module;
        $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;
        $this->load->library('Hotels/Hotels_lib');
        $this->load->model('Kiwitaxi/Kiwitaxi_model');
        $this->load->model("Admin/Emails_model");
        $this->load->library('Cars/Cars_lib');

    }

    /**
     *Homepage search form autocomplete function for kawitaxi taxi module
     * @return json
     */
    public function kawitaxiloaction(){
        $q = $this->input->get('query');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->api_endpoint."search.php?lang=en&placefrom=true&to=&query=".$q,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $json = json_decode($response, true);
        foreach ($json['suggestions'] as $l) {
            $locations[] = (object) array('id' => $l, 'text' => $l);
        }
        $results = json_encode($locations);
        $this->output->set_output($results);
    }

    /**
     *Homepage search form listing function for kawitaxi taxi module
     * @return json
     */
    public function search(){
        $array = $this->uri->segment_array();
        $name_from = str_replace("-","+",$array[3]);
        $name_to = str_replace("-","+",$array[4]);
        $name_from1 = str_replace("-"," ",$array[3]);
        $name_to1 = str_replace("-"," ",$array[4]);
        $curl = curl_init();
       curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->api_endpoint."services/data/route_transfers?name_from=".$name_from."&name_to=".$name_to."&security_token=".$this->config->security_token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
       curl_close($curl);
        if(!empty($this->session->userdata('set_lang'))){
            $lang = $this->session->userdata('set_lang');
        }else{
            $lang = pt_get_default_language();
        }
        $this->session->set_userdata('ktaxilaoctform', $name_from1);
        $this->session->set_userdata('ktaxilaoctto', $name_to1);
        //$response = file_get_contents('kiwisearchlog.json',true);
        $data['lang'] = $lang;
        $data['laoction_form'] = $name_from1;
        $data['laoction_to'] = $name_to1;
        $data['taxi']  = json_decode($response, true );
        $data['photo'] = $this->config->photo;
        $data['pageTitle'] = count($data['taxi'][0]['transfers']).' Taxi' ;
        $data['currencycode']= $this->Hotels_lib->currencycode;
        $data['currencyrate'] = $this->Kiwitaxi_model->currencyrate($this->Hotels_lib->currencycode);
        $data['kiwitaxicurrency'] = $this->config->kawitaxicurrceny;
        $data['kiwitaxicurrencycode'] = $this->config->kawitaxicurrceny;
        $count_price = array();
        $baggage = array();
        $pax = array();
        foreach ($data['taxi'][0]['transfers'] as $key => $value) {
            if(!empty($value['price'][strtolower($this->Hotels_lib->currencycode)]['cost'])){
                $count_price[]= (int)$value['price'][strtolower($this->Hotels_lib->currencycode)]['cost'];
            }else{
            $count_price[] =  (int)round($value['price']['usd']['cost'] * $this->Kiwitaxi_model->currencyrate($this->Hotels_lib->currencycode));
            }
            $baggage[] = $value['type']['baggage'];
            $pax[] = $value['type']['pax'];
        }
        $price = array_count_values($count_price);
        $baggage = array_count_values($baggage);
        $pax = array_count_values($pax);
        $data['price'] = $price;
        $data['baggage'] = $baggage;
        $data['pax'] = $pax;
        $data['price_array'] = $count_price;
        $data['baggage_array'] = $baggage;
        $data['pax_array'] = $pax;
        $data['searchForm'] = ["searchForm"=>$this->session->userdata("ktaxilaoctform"),'searchTo'=>$this->session->userdata("ktaxilaoctto")];
        $this->theme->view('modules/cars/kiwitaxi/listing', $data, $this);
    }

    /**
     *checkout kawitaxi taxi module
     * @return json
     */
    public function checkout(){
        $user_id = $this->session->userdata('pt_logged_customer');
        $data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;
        $type = $this->config->kawitaxipayment;
        $name = (object)$this->input->post();
        $fakedata = new StdClass();
        if ($this->config->api_environment == 'sandbox') {
            $fakedata->fname = 'john';
            $fakedata->lname = 'smith';
            $fakedata->email = 'john@gmail.com';
            $fakedata->phone_number = '12345678910';
            $fakedata->text = 'test test test test test test';
            $fakedata->flightno = 'SU1234';
            $fakedata->date = date('Y-m-d');
            $fakedata->destloaction = 'JW Marriott Marquis Dubai';
            $fakedata->checkbox = 'checked';
        }
        if($this->config->api_environment == 'sandbox'){
            $faketime = '23:00';
        }else{
            $faketime = trans( '0259');
        }
        $data['kiwiModTiming'] = $this->Cars_lib->timingList();
        $data['fakedata'] = $fakedata;
        $data['faketime'] = $faketime;
        $data['pageTitle'] ='Checkout - '.$name->name;
        $data['parms'] = $name;
        $data['paymenttype'] = $type;
        $this->theme->view('modules/cars/kiwitaxi/checkout', $data, $this);
    }

    /**
     *booking kawitaxi taxi module
     * @return json
     */
    public function booking(){
        $userid = $this->session->userdata('pt_logged_customer');
        if(empty($userid)){
            $user_id = 0;
        }else{
            $user_id = $userid;
        }
        $transfer_id = $this->input->post('transfer_id');
        $flight_form = str_replace(' ','+',$this->input->post('flight_form'));
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $msg = $this->input->post('msg');
        $flight_no = $this->input->post('flight_no');
        $date = $this->input->post('date');
        $time = $this->input->post('time');
        $loaction = str_replace(' ','+',$this->input->post('loaction'));
        $pax = $this->input->post('pax');
        $child = $this->input->post('child');
        $child_booster_count = $this->input->post('child_booster_count');
        $taxi_img = $this->input->post('taxi_image');
        $taxi_name = $this->input->post('taxi_name');
        $type = $this->input->post('paymenttype');
        $amount = $this->input->post('amount');
        $locale = 'en';
        $date_start = $date."+".$time;
        $return_transfer = 0;


        $bookingid = $this->Kiwitaxi_model->kiwitaxi_booking($transfer_id,$flight_form,$flight_no,$loaction,$date_start,$pax,$child,$child_booster_count,$first_name,$last_name,$email,$phone,$msg,$taxi_img,$taxi_name,$type);

        /*encryption id*/
        $id_en = ((0x0000FFFF & $bookingid) << 16) + ((0xFFFF0000 & $bookingid) >> 16);

        /*decryption id*/
        $id_de = ((0x0000FFFF & $id_en) << 16) + (((0xFFFF0000 & $id_en) >> 16) & 0x0000FFFF);

        $inovice_url = base_url("taxi/invoice/{$id_en}");
        $success_url = base_url("taxi/invoice/{$id_en}/paid");
        $fail_url = base_url("taxi/invoice/{$id_en}/fail");
        $cancel_url  = base_url("taxi/invoice/{$id_en}/cancel");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL =>$this->config->api_endpoint."services/booking/validate?transfer_id=".$transfer_id."&flight_from=".$flight_form."&address_from=".$flight_no."&address_to=".$loaction."&date_start=".$date_start."&passenger_count=".$pax."&child_chair_count=".$child."&child_booster_count=".$child_booster_count."&client_name=".$first_name."&client_email=".$email."&client_mobile_phone=".$phone."&locale=".$locale,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $data = json_decode($response);

        if(empty($data)){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$this->config->api_endpoint."services/booking/payment_amount?transfer_id=".$transfer_id."&payment_method=".'card'."&payment_type=".$type."&child_chair_count=".$child."&child_booster_count=".$child_booster_count."&return_transfer=".$return_transfer."&security_token=".$this->config->security_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$this->config->api_endpoint."services/booking/confirmation?transfer_id=".$transfer_id."&flight_from=".$flight_form."&address_from=".$flight_no."&address_to=".$loaction."&date_start=".$date_start."&passenger_count=".$pax."&child_chair_count=".$child."&child_booster_count=".$child_booster_count."&client_name=".$first_name."&client_email=".$email."&client_mobile_phone=".$phone."&locale=".$locale."&currency_code=".$this->config->kawitaxicurrceny."&payment_type=".$type."&payment_method=".'card'."&success_url=".$success_url."&fail_url=".$fail_url."&cancel_url=".$cancel_url."&pap=".$this->config->partner_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));
            $response = curl_exec($curl);

            $err = curl_error($curl);
            curl_close($curl);

           $data1 = json_decode($response);

            if(empty($data1->errors[0]->message->en)){
              $this->Kiwitaxi_model->updatedata($id_de,$user_id,$amount,$data1->currency->code,$data1->bookingToken,$data1->formUrl,0,$data1->paymentMethodRefined,$inovice_url);
              $senddata = array('first_name' => $first_name, 'last_name' =>$last_name , 'invoiceid' => $id_en, 'send_email' =>$email);
              $this->Emails_model->kiwitaxisend_invoice($senddata);
              if($type == "none"){
                  echo json_encode(array("msg"=>$inovice_url ,'status'=>1));

              }else{
                  echo json_encode(array("msg"=>$data1->formUrl ,'status'=>1));
              }
          }else{
              echo json_encode(array("msg"=>$data1->errors[0]->message->en ,'status'=>0));
          }
        }else{
            echo json_encode(array("msg"=>$data[0]->message->en ,'status'=>0));
        }

    }
}