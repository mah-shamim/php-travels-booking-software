<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
Class Iwaystransfer extends MX_Controller{

    const Module = "Iwaystransfer";
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
        $this->load->model("Admin/Emails_model");
        $this->load->model("Iwaystransfer/Iwaystransfer_model");
        $this->load->library('Cars/Cars_lib');
        $this->load->library('Iwaystransfer/Iwaystransfer_lib');


    }

    /**
     *Homepage search form listing function for Iwaystaxi taxi module
     * @return json
     */
    public function search(){
        $array = $this->uri->segment_array();
        $name_from = $array[3];
        $name_to = $array[4];
        $url = $this->config->api_endpoint;
        $resporginfrom = $this->Iwaystransfer_lib->index($name_from,$url);
        $resporginto = $this->Iwaystransfer_lib->index($name_to, $url);
        $start_place_point = $resporginfrom->lat.','.$resporginfrom->lng;
        $finish_place_point = $resporginto->lat.','.$resporginto->lng;
        //$start_place_point = '25.2531745,55.3656728';
        //$finish_place_point = '25.3284352,55.5122577';

        $this->session->set_userdata('Iwaystransferlaoctform', $name_from);
        $this->session->set_userdata('Iwaystransferlaoctto', $name_to);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url."transnextgen/v1/prices?user_id=".$this->config->user_id."&lang=en&currency=USD&start_place_point=".$start_place_point."&finish_place_point=".$finish_place_point,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: b4dd3e7e-e43a-006c-dfc4-5277d06e09e7"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $resp = (json_decode($response,true));
        }
        $data['laoction_form'] = $name_from;
        $data['laoction_to'] = $name_to;
        $data['taxi']  = $resp;
        $data['pageTitle'] = count($resp['result']).' Taxi' ;
        $count_price = array();
        $pax = array();
        foreach ($resp['result'] as $key => $value) {
            $count_price[]= (int)$value['price'];
            $pax[] = $value['car_class']['capacity'];
            }

        $price = array_count_values($count_price);
        $pax = array_count_values($pax);
        $data['price'] = $price;
        $data['pax'] = $pax;
        $data['price_array'] = $count_price;
        $data['pax_array'] = $pax;
        $data['start_place_point'] = $start_place_point;
        $data['finish_place_point'] = $finish_place_point;
        $data['searchForm'] = ["searchForm"=>$this->session->userdata("Iwaystransferlaoctform"),'searchTo'=>$this->session->userdata("Iwaystransferlaoctto")];
        $this->theme->view('modules/cars/iwaystransfer/listing', $data, $this);
    }

    /**
     *checkout iwaystransfer taxi module
     * @return json
     */
    public function checkout(){
        $user_id = $this->session->userdata('pt_logged_customer');
        $data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;
        $name = (object)$this->input->post();
        $fakedata = new StdClass();
        if ($this->config->api_environment == 'sandbox') {
            $fakedata->fname = 'john';
            $fakedata->lname = 'smith';
            $fakedata->email = 'john@gmail.com';
            $fakedata->phone_number = '12345678910';
            $fakedata->text = 'test test test test test test';
            $fakedata->flightno = '1234';
            $fakedata->date = date('Y-m-d');
            $fakedata->destloaction = 'Dubai';
            $fakedata->checkbox = 'checked';
            $fakedata->paxname = 'john';
            $fakedata->paxmobile = '+92309876456';
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
        $data['paymenttype'] = '';
        $this->theme->view('modules/cars/iwaystransfer/checkout', $data, $this);
    }

    /**
     *booking iwaystransfer taxi module
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
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $mseg = $this->input->post('msg');
        $flight_no = $this->input->post('flight_no');
        $date1 = $this->input->post('date');
        $datei = $this->input->post('idate');
        $time1 = $this->input->post('time');
        $timei = $this->input->post('itime');
        $loaction = $this->input->post('loaction');
        $pax = $this->input->post('pax');
        $taxi_img = $this->input->post('taxi_image');
        $taxi_name = $this->input->post('taxi_name');
        $amount = $this->input->post('amount');
        $start_place_point = $this->input->post('start_place_point');
        $finish_place_point = $this->input->post('finish_place_point');
        $laoction_to = $this->input->post('laoction_to');
        $laoction_form = $this->input->post('laoction_form');
        $pax_number = $this->input->post('pax_number');
        $pax_name = $this->input->post('pax_name');
        $locale = 'en';

        $fromdata1 = $date1 ." ". $time1;
        $fromdatai = $datei ." ". $timei;

        $payload = array(
            'lang'=>$locale,
            'currency'=>'USD',
            'trips' =>[
                array(
                    'lang'=>$locale,
                    'currency'=>'USD',
                    'price_id'=>$transfer_id,
                    'comment'=>$mseg,
                    'additional_change_Itinerary'=>3,
                    'additional_wait'=>3,
                    'fare_on_toll_road'=>3,
                    'send_params' =>array(
                        'send_client_voucher' =>true,
                        'send_admin_voucher' =>true,
                        'send_client_doc' =>true,
                        'send_admin_doc' =>true,
                    ),
                    'start_location' =>array(
                        'flight_number' =>$flight_no,
                        'terminal_number' => '',
                        'address' => $laoction_form,
                        'location' => $start_place_point,
                        'train_carriage_number' => '',
                        'train_number' => '',
                        'time' => $fromdata1,
                    ),
                    'finish_location'=>array(
                        'time' =>$fromdatai,
                        'location' => $finish_place_point,
                        'address' => $laoction_to,
                    ),
                    'additional_location' =>[],
                    'passengers'=>[
                        array(
                            'name' =>$pax_name,
                            'phone' =>$pax_number,
                            'email' =>$email
                        ),
                    ],
                ),
                array(
                    'lang'=>$locale,
                    'currency'=>'USD',
                    'price_id'=>$transfer_id,
                    'comment'=>$mseg,
                    'additional_change_Itinerary'=>3,
                    'additional_wait'=>3,
                    'fare_on_toll_road'=>3,
                    'send_params' =>array(
                        'send_client_voucher' =>true,
                        'send_admin_voucher' =>true,
                        'send_client_doc' =>true,
                        'send_admin_doc' =>true,
                    ),
                    'start_location' =>array(
                        'flight_number' =>$flight_no,
                        'terminal_number' => '',
                        'address' => $laoction_form,
                        'location' => $start_place_point,
                        'train_carriage_number' => '',
                        'train_number' => '',
                        'time' => $fromdata1,
                    ),
                    'finish_location'=>array(
                        'time' =>$fromdatai,
                        'location' => $finish_place_point,
                        'address' => $laoction_to,
                    ),
                    'additional_location' =>[],
                    'passengers'=>[
                        array(
                            'name' =>$pax_name,
                            'phone' =>$pax_number,
                            'email' =>$email
                        ),
                    ],
                ),

            ],
        );
        $sendata = json_encode($payload);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->config->api_endpoint."transnextgen/v1/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $sendata,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 19db0f55-be65-551c-14a5-d11170b4ed5d"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $msg = json_decode($response);
        if(empty($msg->error)){

            $parms = array(
                'price_id' =>$transfer_id,
                'first_name' =>$first_name,
                'last_name' =>$last_name,
                'phone' =>$phone,
                'email' =>$email,
                'msg' =>$mseg,
                'flight_no' =>$flight_no,
                'fromdata1' =>$fromdata1,
                'fromdata2' =>$fromdatai,
                'laoction_form' =>$laoction_form,
                'laoction_to' =>$laoction_to,
                'start_place_point' =>$start_place_point,
                'finish_place_point' =>$finish_place_point,
                'pax_number' =>$pax_number,
                'pax_name' =>$pax_name,
                'amount' =>$amount,
                'taxi_image' =>$taxi_img,
                'taxi_name' =>$taxi_name,
                'currency' =>'USD',
                'booking_code' =>$msg->result[0]->booker_number,
                'transfer_id' =>$msg->result[0]->transaction,
                'user_id' =>$user_id,
                'url' =>'',
                'status' =>'',
            );
            $booking_id = $this->Iwaystransfer_model->insert_booking($parms);
            if ($booking_id > 0) {
                $this->load->library('email');
                $this->email->from($this->email->mail_fromemail, $this->email->site_title);
                $this->email->to($this->input->post("email"));
                $this->email->subject('Car Booking Confirmation');

                $message = $this->email->mail_header;
                // $message .= $this->load->view('email',$data,true);
                $message .= $this->email->mail_footer;
                $this->email->message($message);
                $this->email->send();

                /*encryption id*/
                $id_en = ((0x0000FFFF & $booking_id) << 16) + ((0xFFFF0000 & $booking_id) >> 16);
                $inovice_url = base_url("itaxi/invoice/{$id_en}");
                $this->Iwaystransfer_model->updatedata($booking_id,$user_id,$inovice_url);

                echo json_encode(array("msg"=>$inovice_url ,'status'=>1));

            } else {
                echo json_encode(array("msg"=>"Some Error Booking" ,'status'=>0));
            }

        }else{
            echo json_encode(array("msg"=>$msg->error->message ,'status'=>0));
        }
    }

}

