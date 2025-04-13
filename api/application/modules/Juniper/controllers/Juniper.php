<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Juniper extends MX_Controller
{
    const MODULE = "Juniper";
    const THEME_MODULE = "modules/hotels/juniper/";

  public function __construct()
  {
    parent::__construct();
      $ci = get_instance();
      $version = implode("=>",(array)$ci->db->query('SELECT VERSION()')->result()[0]);
      if($version > 5.6)
      {
          $ci->db->query('SET SESSION sql_mode = ""');
          $ci->db->query('SET SESSION sql_mode =
                REPLACE(REPLACE(REPLACE(
                @@sql_mode,
                "ONLY_FULL_GROUP_BY,", ""),
                ",ONLY_FULL_GROUP_BY", ""),
                "ONLY_FULL_GROUP_BY", "")');
      }
    modules::load('Front');
    $chk = $this->App->service('ModuleService')->isActive('Juniper');
    if (!$chk) {
      Error_404($this);
    }

    $this->data['lang_set'] = $this->session->userdata('set_lang');
    $this->data['phone'] = $this->load->get_var('phone');
    $this->data['contactemail'] = $this->load->get_var('contactemail');
    $defaultlang = pt_get_default_language();
    if (empty($this->data['lang_set'])) {
      $this->data['lang_set'] = $defaultlang;
    }
    $this->lang->load("front", $this->data['lang_set']);
    $this->data['hideLang'] = "show";
    $this->data['hideCurr'] = "";
    $this->data['appModule'] = 'Juniper';
    $this->load->model('Juniper/HotelsSearchModel');
    $this->load->model('Juniper/Juniper_model');
    $this->load->library('Juniper/Juniper_lib');
      $this->settings = $this->App->service("ModuleService")->get("Juniper")->settings;
      $this->apiConfig = $this->App->service("ModuleService")->get("Juniper")->apiConfig;

      $this->dbhb = getDatabaseConnection('juniper');

  }

  public function search()
  {
      $args = explode('/',  $this->uri->uri_string());
      unset($args[0]);
      unset($args[1]);
      $segments = array_merge($args);
      $searchForm = new HotelsSearchModel();
      $searchForm->parseUriString($segments);
      $this->session->set_userdata('Juniper',serialize($searchForm));

      if(!empty($this->session->userdata("currencycode"))){
          $curr_code = $this->session->userdata("currencycode");
      }else{
          $curr_code = $this->Hotels_lib->currencycode;
      }
      //$check = $this->Juniper_model->getcode($args[2]);
      $this->dbhb->where('Name',str_replace('-',' ',$args[2]));
      $query = $this->dbhb->get('pt_juniper_zonelist')->result();
      if(!empty($query[0]->JPDCode)){
          $this->dbhb->where('Zone_JPDCode',$query[0]->JPDCode);
          $query = $this->dbhb->get('pt_juniper_hotellist')->result();
          $arr = array();
          foreach ($query as $code){
              $arr[] = $code->JPCode;
          }
          $check =  $arr;
      }
      $arry = array();
      $reposne = $this->Juniper_lib->callApi($check,$this->apiConfig,$searchForm);
      //dd($reposne);
      foreach ($reposne->AvailabilityRS->Results->HotelResult as $rep){
          if(empty($reposne->AvailabilityRS->Errors->Error)){

              $reposne_det = $this->Juniper_lib->getimage($rep->Code,$this->apiConfig);
              $current_currency_price = $this->Juniper_model->currencyrate($rep->HotelOptions->HotelOption->Prices->Price->Currency);
              $con_rate = $this->Juniper_model->currencyrate($curr_code);

              $price_get = ceil($rep->HotelOptions->HotelOption->Prices->Price->TotalFixAmounts->Service->Amount / $current_currency_price);

              $price = ceil($price_get * $con_rate);

              $percent_price =  $price *  $this->settings->markup / 100;

//              array_push($arry, (object)[
//                  'id' => $rep->Code,
//                  'company_name' => $rep->HotelInfo->Name,
//                  'description' => '',
//                  'image' => '',
//                  'city_name' => $rep->HotelInfo->Address,
//                  'rating' => str_replace('Stars','',$rep->HotelInfo->HotelCategory->_),
//                  'price' => round($price + $percent_price),
//                  'convarte_price' => $price,
//                  'percent' => $percent_price,
//                  'actuall_price' => $rep->HotelOptions->HotelOption->Prices->Price->TotalFixAmounts->Service->Amount,
//                  'actuall_curr' => $rep->HotelOptions->HotelOption->Prices->Price->Currency,
//                  'RatePlanCode' => $rep->HotelOptions->HotelOption->RatePlanCode,
//                  'currencies' => $curr_code,
//              ]);


              array_push($arry, (object)[
                  'id' => $rep->Code,
                  'company_name' => $rep->HotelInfo->Name,
                  'description' => $reposne_det->ContentRS->Contents->HotelContent->Descriptions->Description[0]->_,
                  'image' => $reposne_det->ContentRS->Contents->HotelContent->Images->Image[0]->FileName,
                  'city_name' => $rep->HotelInfo->Address,
                  'rating' => str_replace('Stars','',$rep->HotelInfo->HotelCategory->_),
                  'price' => round($price + $percent_price),
                  'convarte_price' => $price,
                  'percent' => $percent_price,
                  'actuall_price' => $rep->HotelOptions->HotelOption->Prices->Price->TotalFixAmounts->Service->Amount,
                  'actuall_curr' => $rep->HotelOptions->HotelOption->Prices->Price->Currency,
                  'RatePlanCode' => $rep->HotelOptions->HotelOption->RatePlanCode,
                  'currencies' => $curr_code,
              ]);

          }
      }

      $this->data['hotels'] = $arry;
      $this->data['pageTitle'] = 'Hotels Results' ;
      $this->data['searchForm'] = $searchForm;
      $this->data['appModule'] = self::MODULE;
      $this->theme->view(self::THEME_MODULE.'listing', $this->data, $this);
  }

    public function detail($slug = '')
    {
        $hotel_id = $this->input->post('hotel_id');
        $RatePlanCode = $this->input->post('RatePlanCode');
        $search_form = $this->input->post('search_form');
        $searchForm = json_decode($search_form);
        $arry = array();
        $roomarry = array();
        $rep = $this->Juniper_lib->getdetail($hotel_id,$RatePlanCode,$this->apiConfig,$searchForm);

        if(!empty($this->session->userdata("currencycode"))){
            $curr_code = $this->session->userdata("currencycode");
        }else{
            $curr_code = $this->Hotels_lib->currencycode;
        }

        $current_currency_price = $this->Juniper_model->currencyrate($rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->Prices->Price->Currency);
        $con_rate = $this->Juniper_model->currencyrate($curr_code);


        foreach ($rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelRooms as $room){

                $price_get = ceil($rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->HotelRequiredFields->HotelBooking->Elements->HotelElement->HotelBookingInfo->Price->PriceRange->Maximum / $current_currency_price);

            $price = ceil($price_get * $con_rate);

            $percent_price =  $price *  $this->settings->markup / 100;
            array_push($roomarry,(object)[
                'price' => round($price + $percent_price),
                'convarte_price' => $price,
                'percent' => $percent_price,
                'actuall_price' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->HotelRequiredFields->HotelBooking->Elements->HotelElement->HotelBookingInfo->Price->PriceRange->Maximum,
                'boardTypeid' => '',
                'boardTypename' => $room->Name,
                'roomTypeid' => '',
                'roomTypename' => $room->RoomCategory->Type,
                'roomid' => '',
                'currencies' => $curr_code,
                'Minimum' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->HotelRequiredFields->HotelBooking->Elements->HotelElement->HotelBookingInfo->Price->PriceRange->Minimum,
                'set_currencies' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->HotelRequiredFields->HotelBooking->Elements->HotelElement->HotelBookingInfo->Price->PriceRange->Currency,
            ]);
        }


        array_push($arry,(object)[
            'id' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Code,
            'company_name' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->HotelName,
            'description' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Descriptions->Description[1]->_,
            'images' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Images->Image,
            'city_name' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Zone->Name,
            'rating' => str_replace('Stars','',$rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->HotelCategory->_),
            'price' => 0,
            'room' => $roomarry,
            'rooms' => $roomarry,
            'bookingCode' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->BookingCode->_,
            'amenities' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Features->Feature,
            'address' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Address->Address,
            'latitude' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Address->Latitude,
            'longitude' => $rep->BookingRulesRS->Results->HotelResult->HotelOptions->HotelOption->PriceInformation->HotelContent->Address->Longitude,
        ]);

        $data['hotel'] = $arry;
        $data['searchForm'] = $searchForm;
        $data['search_form'] = '';
        $data['userloggedin'] = $this->session->userdata('pt_logged_customer');
        $this->data['pageTitle'] = 'Hotel-detail' ;

        $this->theme->view(self::THEME_MODULE.'/details', $data, $this);
    }

    public function checkout($slug = '')
    {
        $this->load->model('Admin/Countries_model');
        $data['hotel_encoded'] = $this->input->post('hotel');
        $data['room_encoded'] = $this->input->post('room');
        $data['searchForm_encoded'] = $this->input->post('searchForm');
        $data['hotel'] = json_decode(base64_decode($data['hotel_encoded']));
        $data['room'] = json_decode(base64_decode($data['room_encoded']));
        $data['searchForm'] = json_decode(base64_decode($data['searchForm_encoded']));
        $user_id = $this->session->userdata('pt_logged_customer');
        $data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;
        $data['pageTitle'] = 'Hotels Booking Checkout' ;
        $data['allcountries'] = $this->Countries_model->get_all_countries();
        $this->theme->view(self::THEME_MODULE.'/checkout', $data, $this);
    }


    public function booking(){
        $payload = $this->input->post();
        $hotel = $this->input->post('hotel');
        $room = $this->input->post('room');
        $payload['hotelsdata'] = json_decode(base64_decode($hotel));
        $payload['room'] = json_decode(base64_decode($room));

        $userdetail = array(
            'title' => $payload['title'],
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name'],
            'email' => $payload['email'],
            'country' => $payload['country'],
            'number' => $payload['number'],
            'title0' => $payload['title0'],
            'first_name0' => $payload['first_name0'],
            'last_name0' => $payload['last_name0'],
            'title1' => $payload['title1'],
            'first_name1' => $payload['first_name1'],
            'last_name1' => $payload['last_name1'],
        );
        $data = array(
            "checkIn" => $payload['checkIn'],
            "checkOut" => $payload['checkOut'],
            "set_currencies" => $payload['room']->set_currencies,
            "currency" => $payload['currency'],
            "price" => $payload['price'],
            "actu_price" => $payload['room']->actuall_price,
            "Minimum" => $payload['Minimum'],
            "agentReferenceNumber" => $payload['agentReferenceNumber'],
            "hotel_id" => $payload['hotelsdata']->id,
            "company_name" => $payload['hotelsdata']->company_name,
            "images" => $payload['hotelsdata']->images[0]->FileName,
            "status" => 'unpaid',
            "user_id" => $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer'),
            "booking_response" => json_encode($userdetail), "",
            "booking_code" => $payload['hotelsdata']->bookingCode,
            "bookingDetails" => '',
            "room" => json_encode($payload['room']),
        );


            $rep = $this->Juniper_lib->booking($data,$this->apiConfig);

            if(!empty($rep->BookingRS->Errors->Error)){
                $rep->{'status'} = 'fail';
                $rep->{'message'} = $rep->BookingRS->Errors->Error->Text;
            }else{
                $data = array(
                    "checkIn" => $payload['checkIn'],
                    "checkOut" => $payload['checkOut'],
                    "set_currencies" => $payload['room']->set_currencies,
                    "currency" => $payload['currency'],
                    "price" => $payload['price'],
                    "agentReferenceNumber" => $payload['agentReferenceNumber'],
                    "hotel_id" => $payload['hotelsdata']->id,
                    "company_name" => $payload['hotelsdata']->company_name,
                    "images" => $payload['hotelsdata']->images[0]->FileName,
                    "status" => $rep->BookingRS->Reservations->Reservation->Status,
                    "user_id" => $loggedin = $this->loggedin = $this->session->userdata('pt_logged_customer'),
                    "booking_response" => json_encode($userdetail),
                    "bookingDetails" => json_encode($rep->BookingRS->Reservations->Reservation),
                    "room" => json_encode($payload['room']),
                    "actual_price"=> $payload['room']->actuall_price,
                );
                $booking_id = $this->Juniper_model->booking($data);
                $rep->{'status'} = 'success';
                $rep->{'invoice_url'} = base_url("hotelsj/invoice/{$booking_id}?n=y");
            }

        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($rep));
    }
}