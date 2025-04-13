<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Viator extends MX_Controller {

    function __construct()
    {
        parent::__construct();


        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->load->helper('text');
        $chk = app()->service('ModuleService')->isActive('Viator');
        if ( ! $chk) {
            backError_404($this->data);
        }
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $defaultlang = pt_get_default_language();
        if(empty($this->data['lang_set'])){
            $this->data['lang_set'] = $defaultlang;
        }
        $this->lang->load("front",$this->data['lang_set']);
        $this->config = $this->App->service('ModuleService')->get('Viator')->settings;

    }

    public function index()
    {
        $settings = app()->service("ModuleService")->get('Viator')->settings;
        $this->data['affid'] = $settings->affid;
        $this->data['iframeID'] = $settings->iframeID;
        $this->setMetaData($settings->headerTitle);
        $loadheaderfooter = $settings->showHeaderFooter;

        header('X-Frame-Options: ALLOW');

        $isMobile = $_GET['mobile'];
        if ($loadheaderfooter == "no" || $isMobile == "yes") {
            $this->theme->partial('modules/viator/index',$this->data);
        }else{
            $this->theme->view('modules/viator/index',$this->data, $this);
        }

    }

    public function search()
    {

        if($this->config->api_environment == 'sandbox'){
            $endppoint = 'https://viatorapi.viator.com/service/';
        }else{
            $endppoint = $this->config->api_endpoint;
        }

        $apikey = $this->config->apiKey;

        $uri = explode("/",uri_string());

        $country = $uri[2];
        $location = $uri[3];
        $startDate = $uri[4];
        $endDate = $uri[5];
        $this->session->set_userdata('Viator_startdate',$startDate);
        $this->session->set_userdata('Viator_endDate',$endDate);
        $this->session->set_userdata('Viator_location',$location);
        $this->session->set_userdata('Viator_country',$country);



        $locate = $location.','.$country;
        $url = $endppoint."search/freetext?apiKey=".$apikey;
        $payload = array("text"=>$locate,"startDate"=>$startDate,"endDate"=>$endDate);
        $headers  = array("Content-Type:application/json","exp-api-key:".$apikey);
        $response = $this->curl_call('post',$url,json_encode($payload),$headers);
        $results = json_decode($response);
        /* Json array result have multiple sub arrays, in result there is data[0] array and then nested arrays are
        catIds and subCatIds, data[0] array have all other values of each product*/
//        dd($result->data[0]->data);
        //dd($results);
        $this->data['results'] = $results;
        $this->data['pageTitle'] = $location ;
        $this->data['appModule'] = "Viator";
        $this->theme->view('modules/tours/viator/listing', $this->data, $this);
    }

    public function detail()
    {
        if($this->config->api_environment == 'sandbox'){
            $endppoint = 'https://viatorapi.viator.com/service/';
        }else{
            $endppoint = $this->config->api_endpoint;
        }

        if(!empty($this->session->userdata("currencycode"))){
            $curr_code = $this->session->userdata("currencycode");
        }else{
            $curr_code = $this->Hotels_lib->currencycode;
        }

        $apikey = $this->config->apiKey;

        $uri = explode("/",uri_string());
        $productCodes[0] = $uri[2];
        $code = $this->input->post('code');
        $url = $endppoint."product?code=".$code."&currencyCode=USD&apiKey=".$apikey;
        $getPayload = array("code" => $code);
        $headers  = array("Content-Type:application/json","exp-api-key:".$apikey);
        $detailResponse = $this->curl_call('get',$url,json_encode($getPayload),$headers);
        $details = json_decode($detailResponse);
        //dd($details);
        $this->data['details'] = $details;
        //dd($this->data['details']);
        $this->data['image_thumb'] = $this->input->post('image_thumb');
        $this->theme->view('modules/tours/viator/details',$this->data,$this);
    }

    function checkAvailability()
    {
        $uri = explode("/", uri_string());
        $date = str_replace('-','/',$uri[3]);
        $endDate = str_replace('-','/',$uri[5]);
        $totalCost = $uri[19];
        $singleCost = $uri[17];
        $currencyCode = $uri[21];
        $adults=0;
        $seniors=0;
        $youth=0;
        $child=0;
        $infant=0;
        $picture = str_replace('_','/',$uri[23]);
        $rating = $uri[25];
        $title = str_replace('%20',' ',$uri[27]);
        $location = str_replace('%20', ' ', $uri[29]);
        $duration = str_replace('%20',' ',$uri[31]);
        $code = $uri[33];

        if($uri[6] == "adults" && $uri[7] > 0)
        {
            $adults = $uri[7];
        }
        if($uri[8] == "seniors" && $uri[9] > 0)
        {
            $seniors = $uri[9];
        }
        if($uri[10] == "youth" && $uri[11] > 0)
        {
            $youth = $uri[11];
        }
        if($uri[12] == "child" && $uri[13] > 0)
        {
            $child = $uri[13];
        }
        if($uri[14] == "infant" && $uri[15] > 0)
        {
            $infant = $uri[15];
        }
//        dd($uri);
        $arr = new stdClass();
        $arr->code = $code;
        $arr->title = $title;
        $arr->thumbnail = $picture;
        $arr->stars = $rating;
        $arr->title = $title;
        $arr->location = $location;
        $arr->duration = $duration;
        $arr->tourType = "Viator";
        $arr->adults = $adults;
        $arr->adultprice = $adults * $singleCost;
        $arr->seniors = $seniors;
        $arr->seniorprice = $seniors * $singleCost;
        $arr->youth = $youth;
        $arr->youthprice = $youth * $singleCost;
//        dd($arr->youthprice);
        $arr->children = $child;
        $arr->childprice = $child * $singleCost;
        $arr->infants = $infant;
        $arr->infantprice = $infant * $singleCost;
//        dd($arr->infantprice);
        $arr->startDate = $date;
        $arr->endDate = $endDate;
        $arr->singleCost = $singleCost;
        $arr->totalCost = $totalCost;
        $arr->subTotal = ($arr->adultprice + $arr->seniorprice) + ($arr->youthprice + $arr->childrenprice) + $arr->infantprice;
        $arr->price = $arr->subTotal;
        $arr->currSymbol = $currencyCode;
        $checkDate = str_replace("-","",$date);
//        dd($arr);
        $this->data['module'] = $arr;
        $this->data['appModule'] = 'tours';
        $this->load->model('Admin/Countries_model');
        $this->data['allcountries'] = $this->Countries_model->get_all_countries();
        $this->data['date'] = $date;
        $this->data["app_settings"][0]->allow_registration = 0;
//        dd($arr->youthprice);

        $client =

        $this->theme->view('booking', $this->data, $this);
    }
    function fetech_images(){

    }
    function beforeBooking()
    {
        $uri = explode('/', uri_string());
        $apikey = $this->config->apiKey;
        $productCodes[] = $this->input->post("code");
        $startDate = str_replace("/",'-',$this->input->post("startDate"));
        $endDate = str_replace("/",'-',$this->input->post("endDate"));
        $secretKey = $apikey;
        $url = "https://viatorapi.viator.com/service/available/products?apiKey=".$secretKey;
        $getPayload = array("productCodes" => $productCodes,"startDate"=>$startDate,"endDate"=>$endDate);
        $headers = array("Content-Type:application/json","Accept:application/json","exp-api-key:".$secretKey);
        $result = $this->curl_call('post',$url,json_encode($getPayload),$headers);
        $this->load->model('Admin/Accounts_model');
        $this->load->model('Admin/Bookings_model');
        $userid = $this->Accounts_model->signup_account('guest', '0');

        $result = json_decode($result);
        if(!empty($result->success))
        {
            $booking_data = array(
                "booking_ref_no"=>0,
                "booking_type"=>"viator",
                "booking_user"=>$userid,
                "booking_checkin"=>"$startDate",
                "booking_total"=>$this->input->post("price"),
                "booking_checkout"=>"$startDate",
                "booking_logs"=>$result->data[0]->webURL,
                "booking_item"=>$this->input->post("code"),
            );
            $this->Bookings_model->do_viator_booking($booking_data );

            exit( $result->data[0]->webURL);
        }
        else{
            echo "not Available";
        }
        die;
    }

    function curl_call($method,$url, $params, $headers = array())
    {

        //dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($method == 'post')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        else
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $url = $url."?".http_build_query($params);
        }
        $content = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return $err;
        } else {
            return $content;
        }
    }
}