<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GrnHotels extends MX_Controller
{
    const Module = "GrnHotels";
    private $config = [];
    function __construct()
    {
// $this->session->sess_destroy();
        parent::__construct();
        $this->frontData();
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->config = app()->service("ModuleService")->get(self::Module);
        if (!$this->config) {
            backError_404($this->data);
        }
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if (empty($this->data['lang_set'])) {
            $this->data['lang_set'] = $defaultlang;
        }
        $this->load->model('Grn_model');
        $this->lang->load("front", $this->data['lang_set']);


        $contact = $this->Settings_model->get_contact_page_details();
        $this->data['contactphone'] = $contact[0]->contact_phone;
        $this->data['contactemail'] = $contact[0]->contact_email;
        $this->data['contactaddress'] = $contact[0]->contact_address;

        $this->data['appModule'] = "GrnHotels";

    }

    public function index()
    {
        $settings = app()->service("ModuleService")->get('hotelscombined')->settings;
        $this->data['aid'] = $settings->aid;
        $this->data['brandID'] = $settings->brandID;
        $this->data['searchBoxID'] = $settings->searchBoxID;
        $this->setMetaData($settings->headerTitle);
        $loadheaderfooter = $settings->showHeaderFooter;
        if ($loadheaderfooter == "no") {
            $this->theme->partial('modules/hotelscombined/index', $this->data);
        } else {
            $this->theme->view('modules/hotelscombined/index', $this->data, $this);
        }
    }

    function GrnCities()
    {
      $reults =  $this->Grn_model->get_grn_cities($this->input->get('q'));
      $final_array = array();
      foreach ($reults as $item){
          array_push($final_array,(object)array(
              "id"=>substr($item->code,2),
              "text"=>$item->name
          ));
      }
      echo  json_encode($final_array);
    }
    function Search(){
       $city = $this->uri->segment(3);

       $start_date = $this->uri->segment(4);
       $end_date = $this->uri->segment(5);
       $adults = $this->uri->segment(6);
       $children = $this->uri->segment(7);
       $hotels = $this->Grn_model->getHotels($city);
       $hotel_code = array_column($hotels,'code');
       $children_ages = array();
       for($i=0;$i<$children;$i++){
           array_push($children_ages,rand(2,10));
        }
       $rooms = array();
       if(!empty($children_ages)){
           array_push($rooms,(object)array(
               "adults"=>$adults,
               "children_ages"=>$children_ages
           ));
       }else{
           array_push($rooms,(object)array(
           "adults"=>$adults,
       ));

       }
        $start_date = explode("-",$start_date);
        $start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];

        $end_date = explode("-",$end_date);
        $end_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];

       $final_object = array(
           "hotel_codes"=>$hotel_code,
           "checkin"=>$start_date,
           "checkout"=>$end_date,
           "client_nationality"=>"IN",
           "currency"=>"INR",
           "cutoff_time"=>8000,
           "rooms"=>$rooms

       );

        if ($this->config->apiConfig->api_environment == 'sandbox') {
            $url = "https://api-sandbox.grnconnect.com/api/v3/hotels/availability";
        }else{
           exit("production url missing");
        }
       $headers_object = array(
           "api-key:".$this->config->apiConfig->api_key,
           "Content-Type:application/json",
           "Accept-Encoding:application/json",
           "Accept:application/json",
       );
        $results =  json_decode($this->sendRequest('POST',$url,json_encode($final_object),$headers_object));
        $this->data['searchFormhotels'] = [];
        $this->data["hotels"] = $results;
        $this->data["payload"] = implode("/",$this->uri->segment_array());
        $this->theme->view('modules/hotels/grnhotels/listing', $this->data, $this);
    }
    function book(){
        $payload = explode("/",$this->input->post("payload"));
        $city = $payload[2];
        $start_date = $payload[3];
        $end_date = $payload[4];
        $adults = $payload[5];
        $children = $payload[6];

        $start_date = explode("-",$start_date);
        $start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];

        $end_date = explode("-",$end_date);
        $end_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];

        $this->data["final_payload"] = json_encode($this->input->post());

        $passengers = array();
        for ($i=0;$i<$adults;$i++){
            array_push($passengers,"Adult");
        }
       for ($i=0;$i<$children;$i++){
                array_push($passengers,"Child");
       }

        $this->data["hotel"] = $this->input->post("hotel");
        $this->data["payload"] = $payload;

        $this->data["passengers"] = $passengers;


        $fakedata = new StdClass();
        if ($this->config->apiConfig->api_environment == 'sandbox') {
            $fakedata->sandbox_mode = 1;
            $fakedata->name = 'James';
            $fakedata->surname = 'Patrick';
            $fakedata->email = 'james@pat.com';
            $fakedata->phone_number = '6614565589';
            $fakedata->card_number = 'AAAPL1234C';
        }
        $this->load->model('Admin/Countries_model');

        $this->data['allcountries'] = $this->Countries_model->get_all_countries();
        $this->data['fakedata'] = $fakedata;

        $this->theme->view('modules/hotels/grnhotels/checkout', $this->data, $this);

    }
    public function booking(){

        $payload = json_decode($this->input->post("payload"));
        $book = $payload->book;
        $hotel = $payload->hotel;
        $card = (object)$this->input->post("card");
        $request_payload =  explode("/",$payload->payload);

        $titles = $this->input->post('title');
        $name = $this->input->post('name');
        $surname = $this->input->post('surname');
        $type = $this->input->post('type');



        $city = $request_payload[2];
        $start_date = $request_payload[3];
        $end_date = $request_payload[4];
        $adults = $request_payload[5];
        $children = $request_payload[6];


        $start_date = explode("-",$start_date);
        $start_date = $start_date[2]."-".$start_date[1]."-".$start_date[0];

        $end_date = explode("-",$end_date);
        $end_date = $end_date[2]."-".$end_date[1]."-".$end_date[0];

        $recheck_payload = array(
            "rate_key"=>$book->rate_key,
            "group_code"=>$book->group_code
        );
        $headers_object = array(
            "api-key:".$this->config->apiConfig->api_key,
            "Content-Type:application/json",
            "Accept-Encoding:application/json",
            "Accept:application/json",
        );
        if ($this->config->apiConfig->api_environment == 'sandbox') {
            $recheck_url = "https://api-sandbox.grnconnect.com/api/v3/hotels/availability/$book->search_id/rates/?action=recheck";
        }else{
            exit("production url is missing");
        }
       $response =  $this->recheck($recheck_url,json_encode($recheck_payload),$headers_object);
        $booking_payload = array(
            "search_id"=>$book->search_id,
            "hotel_code"=>$book->hotel_code,
            "city_code"=>$book->city_code,
            "group_code"=>$book->group_code,
            "checkin"=>$start_date,
            "checkout"=>$end_date,
            "booking_comments"=>"Testing",
            "payment_type"=>$book->payment_type,
        );

        $passenger = array();

        foreach ($titles as $index=>$title){

            array_push($passenger,array(
               "title"=>$title,
               "name"=>$name[$index],
               "surname"=>$surname[$index],
               "type"=>$type[$index],
            ));
        }
        $booking_payload["booking_items"][] = (object)array(
            "room_code"=>$book->room_code,
            "rate_key"=>$book->rate_key,
            "rooms"=>array((object)array(
                "room_reference" => $book->room_reference,
                "paxes"=>$passenger
            ))
        );
        $booking_payload["holder"] = (object)$this->input->post("card");

        if ($this->config->apiConfig->api_environment == 'sandbox') {
            $booking_url = "https://api-sandbox.grnconnect.com/api/v3/hotels/bookings";
        }else{
            exit("production url is missing");
        }

        $invoice_data = array(
            "hotel_name"=>$hotel->hotel_name,
            "hotel_image"=>$hotel->image,
            "hotel_price"=>$hotel->price,
            "hotel_currency"=>$hotel->currency,
            "room_name"=>$hotel->room_name,
            "card_title"=>$card->title,
            "card_name"=>$card->name,
            "card_surname"=>$card->surname,
            "card_pan_number"=>$card->pan_number,
            "card_mobile_number"=>$card->phone_number,
            "card_email"=>$card->email,
            "client_nationality"=>$card->client_nationality,
            "checkin"=>$start_date,
            "checkout"=>$end_date
        );

       $response =  json_decode($this->recheck($booking_url,json_encode($booking_payload),$headers_object));

        if(!empty($response->status) && ($response->status == "confirmed" || $response->status =="pending" )){
          $id =  $this->Grn_model->save_invoice($invoice_data,$passenger);
          echo json_encode(array('status'=>true,'url'=>base_url('grnhotels/invoice/'.$id)));
        }else{
            echo json_encode(array('status'=>false,'url'=>""));
        }
    }

    function bindcities(){
        $endpoint = "https://api-sandbox.grnconnect.com/api/v3/cities/";

        $headers_object = array(
            "api-key:".$this->config->apiConfig->api_key,
            "Content-Type:application/json",
            "Accept-Encoding:application/json",
            "Accept:application/json",
        );
        $results =  json_decode($this->getCities($endpoint,$headers_object));

        $this->Grn_model->bind_cities($results);
        echo "done";
    }
    function bindhotels(){

        $countries = $this->Grn_model->getCountries();
        foreach ($countries as $country){
            $endpoint = "https://api-sandbox.grnconnect.com/api/v3/hotels/?country=".$country->iso;

            $headers_object = array(
                "api-key:".$this->config->apiConfig->api_key,
                "Content-Type:application/json",
                "Accept-Encoding:application/json",
                "Accept:application/json",
            );
            $results =  json_decode($this->getCities($endpoint,$headers_object));
            if(!empty($results->hotels)){
                 $this->Grn_model->bind_hotels($results->hotels);
            }
        }
        echo "done";
    }


    public function sendRequest($req_method = 'GET', $url = '', $payload = [], $_headers = [])
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if ($req_method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            $url = $url."?".http_build_query($payload);
        }

        if (! empty($_headers) ) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $_headers);
        }

        curl_setopt($curl, CURLOPT_URL, $url);

        $response = curl_exec( $curl );
        $err      = curl_error( $curl );

        curl_close( $curl );

        if ( $err ) {
            $response = $err;
        }

        return $response;
    }

    public function recheck($url,$payload,$headers){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$payload,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        return $response;
    }

    public function invoice(){
        $id = $this->uri->segment(3);
        $this->data["invoice"] =  $this->Grn_model->get_invoice($id);
        $this->data["invoice"]->module =  "hotels";
        $this->theme->view('modules/hotels/grnhotels/invoice', $this->data, $this);

    }

    public function getCities($endpoint,$header){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        return $response;
    }


}