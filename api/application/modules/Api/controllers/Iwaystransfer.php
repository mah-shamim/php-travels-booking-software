<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Iwaystransfer extends REST_Controller {
    const Module = "Iwaystransfer";
    private $config = [];
    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;
        $this->output->set_content_type('application/json');
        $this->load->model("Admin/Emails_model");
        $this->load->model("Iwaystransfer/Iwaystransfer_model");
        $this->load->library('Cars/Cars_lib');
        $this->load->library('Iwaystransfer/Iwaystransfer_lib');
    }

    /*IwaysTransfer place search(autocomplete)*/
    public function placesearch_post()
    {
        $q = $this->post('place_name');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kiwitaxi.com/search.php?lang=en&placefrom=true&to=&query=".$q,
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
        echo $response;
    }

    /*IwaysTransfer Get all Data List */
    public function getlist_post(){
        $url = $this->config->api_endpoint;
        $name_from = $this->post('placefrom');
        $name_to = $this->post('placeto');
        $resporginfrom = $this->Iwaystransfer_lib->index($name_from,$url);
        $resporginto = $this->Iwaystransfer_lib->index($name_to, $url);
        $start_place_point = $resporginfrom->lat.','.$resporginfrom->lng;
        $finish_place_point = $resporginto->lat.','.$resporginto->lng;
        //$start_place_point = '25.2531745,55.3656728';
        //$finish_place_point = '25.3284352,55.5122577';


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
            $this->response(array('response' => $err, 'error' => array('status' => False,'msg' => 'Record not found')), 200);
        } else {
            $this->response(array('response' => (json_decode($response,true)), 'error' => array('status' => True,'msg' => 'Record  found')), 200);
        }
        }


    public function booking_post(){
        $user_id = $this->post('user_id');
        $transfer_id = $this->post('price_id');
        $first_name = $this->post('first_name');
        $last_name = $this->post('last_name');
        $phone = $this->post('phone');
        $email = $this->post('email');
        $mseg = $this->post('msg');
        $flight_no = $this->post('flight_no');
        $fromdata1 = $this->post('start-time');
        $fromdatai = $this->post('ent-time');
        $loaction = $this->post('loaction');
        $pax = $this->post('pax');
        $taxi_img = $this->post('taxi_image');
        $taxi_name = $this->post('taxi_name');
        $amount = $this->post('amount');
        $start_place_point = $this->post('start_place_point');
        $finish_place_point = $this->post('finish_place_point');
        $laoction_to = $this->post('laoction_to');
        $laoction_form = $this->post('laoction_form');
        $pax_number = $this->post('pax_number');
        $pax_name = $this->post('pax_name');
        $locale = 'en';


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