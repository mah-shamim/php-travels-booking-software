<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Kiwitaxi extends REST_Controller {
    const Module = "Kiwitaxi";
    private $config = [];
    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;
        $this->output->set_content_type('application/json');
        $this->load->model('Kiwitaxi/Kiwitaxi_model');
        $this->load->model("Admin/Emails_model");
    }

    /*Kiwitaxi place search(autocomplete)*/
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

    /*Kiwitaxi Get all Data List */
    public function getlist_post(){
        $place_from =  str_replace(" ","+",$this->post('place_from'));
        $place_to = str_replace(" ","+",$this->post('place_to'));
        $currencycode = $this->post('currencycode');
        $lang = $this->post('lang');

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->config->api_endpoint."services/data/route_transfers?name_from=".$place_from."&name_to=".$place_to."&security_token=".$this->config->security_token,
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

        if (!empty ($response)) {
            $taxi = json_decode($response, true );
            if (!empty($taxi[0]['transfers'] )) {
                $array = [];
             foreach ($taxi[0]['transfers'] as $key => $value){

                 $currencyrate = $this->Kiwitaxi_model->currencyrate($currencycode);
                 if(!empty($value['price'][strtolower($currencycode)]['cost'])){
                     $price_convert = $value['price'][strtolower($currencycode)]['cost'];
                 }else{
                     $price_convert = round($value['price']['usd']['cost'] * $currencyrate);
                 }
                 $name = $value['type']['name'][$lang];
                 if(!empty($name)){
                     $car_name =  $name;
                 }else{
                     $car_name =  $value['type']['name']['en'];
                 }
                 $carExamples = $value['type']['carExamples'][$lang];
                 if(!empty($carExamples)){
                     $carExamples =  $carExamples;
                 }else{
                     $carExamples =  $value['type']['carExamples']['en'];
                 }
                 $description = $value['type']['description'][$lang];
                 if(!empty($description)){
                     $des =  $description;
                 }else{
                     $des =  $value['type']['description']['en'];
                 }
                 array_push($array, (object)[
                        "transfer_id" => $value['id'],
                        "carname" => $car_name,
                        "price" => $price_convert,
                        "currencycode" => $currencycode,
                        "img" => base_url().'uploads/images/kiwitaxi/'.str_replace(' ','_',strtolower($car_name)).'.jpg',
                        "pax" => $value['type']['pax'],
                        "bag" => $value['type']['baggage'],
                        "carExamples" => $carExamples,
                        "description" => $des,

                    ]);
             }
                $this->response($array);
            }else{
                $this->response(array('response' => '', 'error' => array('status' => FALSE,'msg' => 'Record not found')), 200);
            }
        }else{

            $this->response(array('response' => '', 'error' => array('status' => FALSE,'msg' => 'Record not found')), 200);

        }

    }

    /*Kiwitaxi Confirm booking*/
    public function confirmation_post(){
        $user_id = 0;
        $transfer_id = $this->post('transfer_id');
        $flight_form = str_replace(' ','+',$this->post('flight_form'));
        $first_name = $this->post('first_name');
        $last_name = $this->post('last_name');
        $phone = $this->post('phone');
        $email = $this->post('email');
        $msg = $this->post('msg');
        $flight_no = $this->post('flight_no');
        $date = $this->post('date');
        $time = $this->post('time');
        $loaction = str_replace(' ','+',$this->post('loaction'));
        $pax = $this->post('pax');
        $child = $this->post('child');
        $taxi_img = $this->post('taxi_image');
        $taxi_name = $this->post('taxi_name');
        $type = $this->post('paymenttype');
        $amount = $this->post('amount');
        $locale = 'en';
        $date_start = $date."+".$time;
        $return_transfer = 0;

        $bookingid = $this->Kiwitaxi_model->kiwitaxi_booking($transfer_id,$flight_form,$flight_no,$loaction,$date_start,$pax,$child,$first_name,$last_name,$email,$phone,$msg,$taxi_img,$taxi_name,$type);

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
            CURLOPT_URL =>$this->config->api_endpoint."services/booking/validate?transfer_id=".$transfer_id."&flight_from=".$flight_form."&address_from=".$flight_no."&address_to=".$loaction."&date_start=".$date_start."&passenger_count=".$pax."&child_chair_count=".$child."&client_name=".$first_name."&client_email=".$email."&client_mobile_phone=".$phone."&locale=".$locale,
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
                CURLOPT_URL =>$this->config->api_endpoint."services/booking/payment_amount?transfer_id=".$transfer_id."&payment_method=".'card'."&payment_type=".$type."&child_chair_count=".$child."&return_transfer=".$return_transfer."&security_token=".$this->config->security_token,
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
                CURLOPT_URL =>$this->config->api_endpoint."services/booking/confirmation?transfer_id=".$transfer_id."&flight_from=".$flight_form."&address_from=".$flight_no."&address_to=".$loaction."&date_start=".$date_start."&passenger_count=".$pax."&child_chair_count=".$child."&client_name=".$first_name."&client_email=".$email."&client_mobile_phone=".$phone."&locale=".$locale."&currency_code=".$this->config->kawitaxicurrceny."&payment_type=".$type."&payment_method=".'card'."&success_url=".$success_url."&fail_url=".$fail_url."&cancel_url=".$cancel_url."&pap=".$this->config->partner_id,
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
                echo json_encode(array("msg"=>$data1->formUrl ,'status'=>1));
            }else{
                echo json_encode(array("msg"=>$data1->errors[0]->message->en ,'status'=>0));
            }
        }else{
            echo json_encode(array("msg"=>$data[0]->message->en ,'status'=>0));
        }

    }
}