<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ean_lib {

        public  $cid;
        public  $ci;
        public  $rev;
      	public  $apiKey;
        public  $local;
    	  public  $currency;
        public  $customerUserAgent;
        public  $customerIpAddress;
        public $apiurl;
        public $bookingurl;
        public $apistr;
        public $homePagePopularCity;
        public $homePagePopularCount;
        public $homePageFeaturedCity;
        public $homePageFeaturedCount;
        public $relatedCount;
        public $baseUrl;
        public $secret;
        public $sig;
        public $totalStay;
        public $itinUrl;


	function __construct($_apiKey = "n2cxz49a5vd9u9verw3afva7" ,$_local = "en_US",$_currency = "USD"){
        $this->ci = &get_instance();
        $this->baseUrl = base_url().EANSLUG;
        $this->ci->load->model('Admin/Settings_model');
        $configdata = $this->ci->Settings_model->get_front_settings("ean");
        $homePageCities = json_decode($configdata[0]->front_top_cities);
        $defLang = $configdata[0]->language;
        if(empty($defLang)){
          $defLang = $_local;
        }

        $minorRev = $configdata[0]->front_tax_fixed;

        if($minorRev < 30){
          $minorRev = 30;
        }

        $this->relatedCount = $configdata[0]->front_related;

        $this->homePagePopularCity = $homePageCities->p;
        $this->homePageFeaturedCity = $homePageCities->f;

        $this->homePageFeaturedCount = $configdata[0]->front_homepage;
        $this->homePagePopularCount = $configdata[0]->front_popular;

        if($configdata[0]->testing_mode == "0"){

      //  $this->apiurl = "http://api.ean.com/ean-services/rs/hotel/v3/";
         $this->apiurl = "http://api.eancdn.com/ean-services/rs/hotel/v3/";
         $this->bookingurl = "https://book.api.ean.com/ean-services/rs/hotel/v3/res?";
         $this->itinUrl = "http://api.ean.com/ean-services/rs/hotel/v3/itin?";

        }else{
       $this->apiurl = "http://dev.api.ean.com/ean-services/rs/hotel/v3/";
       $this->bookingurl = "https://dev.api.ean.com/ean-services/rs/hotel/v3/res?";
       $this->itinUrl = "http://dev.api.ean.com/ean-services/rs/hotel/v3/itin?";


        }

        $this->cid = $configdata[0]->cid;
        $this->rev = $minorRev;
	      $this->apiKey = $configdata[0]->apikey;
	      $this->secret = $configdata[0]->secret;
	      $this->local = $this->checkLang($defLang);

        $currencycode = $this->ci->session->userdata('currencycode');

        if(empty($currencycode)){
          $this->currency = $configdata[0]->currency;
        }else{
            $this->currency = $currencycode;
        }

        $this->customerUserAgent = trim($_SERVER['HTTP_USER_AGENT']);
        $this->customerIpAddress = trim($this->ci->input->ip_address());
        $date =  trim(gmdate('U'));
        $this->sig = strtolower(md5($this->apiKey.$this->secret.$date));

	}


  function setLang($lang = "en"){
    $this->local = $this->checkLang($lang);
  }


  function checkLang($lang){

  $this->ci->load->model('Ean/Ean_model');
  $langlist = $this->ci->Ean_model->languagesList();
  $l = $langlist[$lang];

  if(!empty($l)){
  return $l;
  }else{
  return "en";
  }

  }


        /*
         * function for API call using curl
         */
	function apiCall($url){


            $url = str_replace(" ", '%20', $url);


            $header[] = "Accept: application/json";
            $header[] = "Accept-Encoding: gzip";
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
            curl_setopt($ch,CURLOPT_ENCODING , "gzip");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $response = json_decode(curl_exec($ch),true);

            $curlinfo = curl_getinfo($ch);


            return $response;

        }



        /*
         * funtion to get the list of hotels
         */
	function HotelListsDateless($arrayInfo){

            $city = $arrayInfo['city'];
            $cityId = array_key_exists('cityId', $arrayInfo) ? $arrayInfo['cityId'] : '' ;
            $countryCode = $arrayInfo['countryCode'];
            $rooms = $arrayInfo['rooms'];
            $numberOfResult = array_key_exists('numberOfResult', $arrayInfo) ? $arrayInfo['numberOfResult'] :10;

            /*filtering
             * please check the Filtering Methods section for compleate list http://developer.ean.com/docs/read/hotel_list
             */
            $propertyCategory = array_key_exists('propertyCategory', $arrayInfo) ? $arrayInfo['propertyCategory'] : '' ;
            $amenities = array_key_exists('amenities', $arrayInfo) ? $arrayInfo['amenities'] : '' ;
            $maxStarRating = array_key_exists('maxStarRating', $arrayInfo) ? $arrayInfo['maxStarRating'] : '' ;
            $minStarRating = array_key_exists('minStarRating', $arrayInfo) ? $arrayInfo['minStarRating'] : '' ;
            $minRate = array_key_exists('minRate', $arrayInfo) ? $arrayInfo['minRate'] : '' ;
            $maxRate = array_key_exists('maxRate', $arrayInfo) ? $arrayInfo['maxRate'] : '' ;

            /*
             * sorting
             * please check the Sorting Options section for compleate list http://developer.ean.com/docs/read/hotel_list
             *
             */
            $sort = $arrayInfo['sort'] = array_key_exists('sort', $arrayInfo) ? $arrayInfo['sort'] : 'NO_SORT' ;

           $str= $this->apiurl.'list?minorRev='.$this->rev.'&cid='.$this->cid.'&sig='.$this->sig.
                    '&apiKey='.$this->apiKey.'&customerSessionId&customerUserAgent='.$this->customerUserAgent.'&customerIpAddress='.$this->customerIpAddress.'&locale='.$this->local.
                    '&currencyCode='.$this->currency.
                    '&city='.$city.
                    '&destinationId='.$cityId.
                    '&countryCode='.$countryCode.
                    '&propertyCategory='.$propertyCategory.
                    '&amenities='.$amenities.
                    '&maxStarRating='.$maxStarRating.
                    '&minStarRating='.$minStarRating.
                    '&minRate='.$minRate.
                    '&maxRate'.$maxRate.
                    '&sort='.$sort.
                    '&supplierCacheTolerance=MED&arrivalDate='.$checkIn.
                    '&departureDate='.$checkOut.'&'.$rooms.'&numberOfResults='.$numberOfResult.
                    '&supplierCacheTolerance=MED_ENHANCED';
                    $this->totalStay($checkIn,$checkOut);

            return $this->apiCall($str);
	}
      function listhotels(){
        $date =  trim(gmdate('U'));
        $sig = strtolower(md5($this->apiKey.$this->secret.$date));

        $str = $this->apiurl.'list?minorRev='.$this->rev.'&sig='.$sig.'&cid='.$this->cid.'&apiKey='.$this->apiKey.'&city=Seattle';
        return $this->apiCall($str);

      }

//get popular hotels home page
  function getHomePagePopularHotels() {
        $checkin = date("m/d/Y", strtotime("+1 days"));
        $checkout = date("m/d/Y", strtotime("+2 days"));
        $this->data['checkin'] = $checkin;
        $this->data['checkout'] = $checkout;
        $adults = 2;
        $arrayInfo["city"] = $this->homePagePopularCity;
        $arrayInfo['checkIn'] = trim($checkin);
        $arrayInfo['checkOut'] = trim($checkout);
        $arrayInfo['rooms'] = "room1=$adults";
        $arrayInfo['numberOfResult'] = $this->homePagePopularCount;
        $arrayInfo['sort'] = 'QUALITY';
        $result = $this->HotelLists($arrayInfo);
        $response = new stdClass;
        $totalcounts = $result['HotelListResponse']['HotelList']['@size'];
         $this->totalStay($checkin,$checkout);

      if($totalcounts > 1){
       $resultarray = $result['HotelListResponse']['HotelList']['HotelSummary'];
      }else{
      $resultarray[] = $result['HotelListResponse']['HotelList']['HotelSummary'];
      }
      $response->errorMsg = "";

      if(!empty($result['HotelListResponse']['EanWsError'])){
          $response->errorMsg = $result['HotelListResponse']['EanWsError']['verboseMessage'];
      }

      $response->hotels = $this->getShortResultsObject($result, $resultarray);



      return $response;



    }

//get featured hotels home page
  function getHomePageFeaturedHotels() {
        $checkin = date("m/d/Y", strtotime("+1 days"));
        $checkout = date("m/d/Y", strtotime("+2 days"));
        $this->data['checkin'] = $checkin;
        $this->data['checkout'] = $checkout;
        $adults = 2;
        $arrayInfo["city"] = $this->homePageFeaturedCity;
        $arrayInfo['checkIn'] = trim($checkin);
        $arrayInfo['checkOut'] = trim($checkout);
        $arrayInfo['rooms'] = "room1=$adults";
        $arrayInfo['numberOfResult'] = $this->homePageFeaturedCount;
        $result = $this->HotelLists($arrayInfo);
        $response = new stdClass;
        $totalcounts = $result['HotelListResponse']['HotelList']['@size'];

      if($totalcounts > 1){
       $resultarray = $result['HotelListResponse']['HotelList']['HotelSummary'];
      }else{
      $resultarray[] = $result['HotelListResponse']['HotelList']['HotelSummary'];
      }
      $response->errorMsg = "";

      if(!empty($result['HotelListResponse']['EanWsError'])){
          $response->errorMsg = $result['HotelListResponse']['EanWsError']['verboseMessage'];
      }

     $response->hotels = $this->getShortResultsObject($result, $resultarray);

        return $response;



    }


    //get related hotels for hotel single page of same city
  function getRelatedHotels($city) {
        $checkin = date("m/d/Y", strtotime("+1 days"));
        $checkout = date("m/d/Y", strtotime("+2 days"));
        $this->data['checkin'] = $checkin;
        $this->data['checkout'] = $checkout;
        $adults = 2;
        $arrayInfo["city"] = $city;
        $arrayInfo['checkIn'] = trim($checkin);
        $arrayInfo['checkOut'] = trim($checkout);
        $arrayInfo['rooms'] = "room1=$adults";
        $arrayInfo['numberOfResult'] = $this->relatedCount;
        $result = $this->HotelLists($arrayInfo);
        $response = new stdClass;
        $totalcounts = $result['HotelListResponse']['HotelList']['@size'];

      if($totalcounts > 1){
       $resultarray = $result['HotelListResponse']['HotelList']['HotelSummary'];
      }else{
      $resultarray[] = $result['HotelListResponse']['HotelList']['HotelSummary'];
      }
      $response->errorMsg = "";

      if(!empty($result['HotelListResponse']['EanWsError'])){
          $response->errorMsg = $result['HotelListResponse']['EanWsError']['verboseMessage'];
      }

     $response->hotels = $this->getShortResultsObject($result, $resultarray);

        return $response;



    }

        /*
         * funtion to get the list of hotels
         */
	function HotelLists($arrayInfo){

            $city = $arrayInfo['city'];
            $cityId = array_key_exists('destinationId', $arrayInfo) ? $arrayInfo['destinationId'] : '' ;
           // $countryCode = $arrayInfo['countryCode'];
            $checkIn = $arrayInfo['checkIn'];
            $checkOut = $arrayInfo['checkOut'];
            $rooms = $arrayInfo['rooms'];
            $numberOfResult = array_key_exists('numberOfResult', $arrayInfo) ? $arrayInfo['numberOfResult'] :20;

             $this->totalStay($checkIn,$checkOut);

            /*filtering
             * please check the Filtering Methods section for compleate list http://developer.ean.com/docs/read/hotel_list
             */
            $propertyCategory = array_key_exists('propertyCategory', $arrayInfo) ? $arrayInfo['propertyCategory'] : '' ;
            $amenities = array_key_exists('amenities', $arrayInfo) ? $arrayInfo['amenities'] : '' ;
            $maxStarRating = array_key_exists('maxStarRating', $arrayInfo) ? $arrayInfo['maxStarRating'] : '' ;
            $minStarRating = array_key_exists('minStarRating', $arrayInfo) ? $arrayInfo['minStarRating'] : '' ;
            $minRate = array_key_exists('minRate', $arrayInfo) ? $arrayInfo['minRate'] : '' ;
            $maxRate = array_key_exists('maxRate', $arrayInfo) ? $arrayInfo['maxRate'] : '' ;

            /*
             * sorting
             * please check the Sorting Options section for compleate list http://developer.ean.com/docs/read/hotel_list
             *
             */
            $sort = $arrayInfo['sort'] = array_key_exists('sort', $arrayInfo) ? $arrayInfo['sort'] : 'NO_SORT' ;

           $str= $this->apiurl.'list?minorRev='.$this->rev.'&cid='.$this->cid.'&sig='.$this->sig.
                    '&apiKey='.$this->apiKey.'&customerSessionId&customerUserAgent='.$this->customerUserAgent.'&customerIpAddress='.$this->customerIpAddress.'&locale='.$this->local.
                    '&currencyCode='.$this->currency.
                    '&city='.$city.'&arrivalDate='.$checkIn.'&departureDate='.$checkOut.'&'.$rooms.'&numberOfResults='.$numberOfResult.
                   '&destinationId='.$cityId.'&sort='.$sort.'&maxStarRating='.$maxStarRating.'&minStarRating='.$minStarRating.
                   '&minRate='.$minRate.'&maxRate='.$maxRate.'&propertyCategory='.$propertyCategory.'&supplierCacheTolerance=MED_ENHANCED';
                  //  '&countryCode='.$countryCode.
                  //  '&propertyCategory='.$propertyCategory.
                  //  '&amenities='.$amenities.
                  //  '&maxStarRating='.$maxStarRating.
                  //  '&minStarRating='.$minStarRating.
                 //   '&minRate='.$minRate.
                 //   '&maxRate'.$maxRate.
                 //   '&sort='.$sort.
                 //   '&supplierCacheTolerance=MED&arrivalDate='.$checkIn;
               $this->apistr = $str;
            return $this->apiCall($str);
	}

        /*
         * function to get hotelList more page
         */
        function HotelListsMore($arrayInfo){

            $customerSessionId = trim($arrayInfo['customerSessionId']);
            $cacheKey = trim($arrayInfo['cacheKey']);
            $cacheLocation = trim($arrayInfo['cacheLocation']);

            $str = $this->apiurl."list?minorRev=".$this->rev."&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "&customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&locale=".$this->local.
                    "&currencyCode=".$this->currency.
                    "&cacheKey=".$cacheKey.
                    "&cacheLocation=".$cacheLocation;
             $this->apistr = $str;
            return $this->apiCall($str);


        }

        /*
         * function to get

         */
        function HotelDetails($arrayInfo) {

            $hotelId = trim($arrayInfo['hotelId']);
            $customerSessionId = trim($arrayInfo['customerSessionId']);

            $str = $this->apiurl."info?minorRev=".$this->rev."&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "&customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&locale=".$this->local.
                    "&currencyCode=".$this->currency.
                    "&hotelId=".$hotelId.
                    "&options=0";

            return $this->apiCall($str);
        }

        /*
         * function to get hotel room Availability
         */
        function HotelRoomAvailability($arrayInfo){
            //TODO
            $hotelId = trim($arrayInfo['hotelId']);
            $customerSessionId = trim($arrayInfo['customerSessionId']);
            $checkIn = $arrayInfo['checkIn'];
            $checkOut = $arrayInfo['checkOut'];
            $roomcode = $arrayInfo['roomTypeCode'];
            $ratekey = $arrayInfo['rateKey'];
            $ratecode = $arrayInfo['rateCode'];
            $rooms = $arrayInfo['rooms'];

            $str = $this->apiurl."avail?minorRev=".$this->rev."&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "&customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&locale=".$this->local.
                    "&currencyCode=".$this->currency.
                    "&hotelId=".$hotelId.
                    "&arrivalDate=".$checkIn.
                    "&departureDate=".$checkOut.
                    "&roomTypeCode=".$roomcode.
                    "&rateKey=".$ratekey.
                    "&rateCode=".$ratecode.
                    "&includeDetails=true&includeRoomImages=true&options=ROOM_TYPES,ROOM_AMENITIES&".$rooms;
                     $this->apistr = $str;
            return $this->apiCall($str);
        }
         /*
         * function for API call using curl POST
         */
	function apiPostCall($url,$data){

    $url = str_replace(" ", '%20', $url);
    $fields = array(   'cid' => $this->cid,
            'sig' => $this->sig,
						'apiKey' => $this->apiKey,
						'customerUserAgent' => urlencode($this->customerUserAgent),
						'customerIpAddress' => urlencode($this->customerIpAddress),
						'customerSessionId' => urlencode($data['sessionid']),
						'locale' => $this->local,
						'currencyCode' => $this->currency,
						'hotelId' => $data['hotel'],
						'arrivalDate' => $data['checkin'],
						'departureDate' => $data['checkout'],
						'supplierType' => E,
						'rateKey' => $data['ratekey'],
						'roomTypeCode' => $data['roomtype'],
						'rateCode' => $data['ratecode'],
						'chargeableRate' => $data['total'],
						'room1' => $data['adults'],
						'room1FirstName' => urlencode($data['firstName']),
						'room1LastName' => urlencode($data['lastName']),
						'firstName' => urlencode($data['firstName']),
						'lastName' => urlencode($data['lastName']),
						'email' => $data['email'],
						'creditCardType' => $data['cardtype'],
						'creditCardNumber' => $data['cardno'],
						'creditCardIdentifier' => $data['cvv'],
						'creditCardExpirationMonth' => $data['expMonth'],
						'creditCardExpirationYear' => $data['expYear'],
						'address1' => $data['address'],
						'city' => $data['city'],
						'homePhone' => $data['phone'],
						'stateProvinceCode' => $data['province'],
						'countryCode' => $data['country'],
            'postalCode' => $data['postalcode'],
						'affiliateConfirmationId' => $data['affiliateConfirmationId'],
				);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

// url encode for space
//            $ch=curl_init($url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            $r=curl_exec($ch);
//            curl_close($ch);
//            $response = json_decode($r,true);

 $ch = curl_init();
    $timeout = 3;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
   curl_setopt($ch,CURLOPT_POST, count($fields));
   curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $rawdata = curl_exec($ch);
    curl_close($ch);
     @$response = json_decode($rawdata);



       /*  $header[] = "Accept: application/json";
            $header[] = "Accept-Encoding: gzip";
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
            curl_setopt($ch,CURLOPT_ENCODING , "gzip");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $response = json_decode(curl_exec($ch),true);

            $curlinfo = curl_getinfo($ch);*/

//          echo "<pre>";
//          print_r($curlinfo);

            if(array_key_exists('EanWsError',$response)){
                echo "<pre>";
                print_r($response);
                echo "<pre>";
                die();

            } else{
                return $response;
            }


        }
        /*
         * function to book hotel room Reservation
         */
       function HotelRoomReservation($arrayInfo = null) {
            //TODO
           // $hotelId = trim($arrayInfo['hotelId']);
           // $hotelId = "328631";
          //  $customerSessionId = trim($arrayInfo['customerSessionId']);
          //  $customerSessionId = "0ABAAABB-AFB9-0A91-4A72-5BF67A2946B5";
          //  $checkIn = $arrayInfo['checkIn'];
          //  $checkIn = "12/24/2014";
          //  $checkOut = $arrayInfo['checkOut'];
           // $checkOut = "12/31/2014";
          //  $rooms = $arrayInfo['rooms'];


           return $this->apiPostCall($this->bookingurl,$_POST);


       }
//        /*
//         * function to cancel hotel room Booking
//         */





        function LocationInfo($arrayInfo) {

            //TODO
            $city = $arrayInfo["city"];

            $customerSessionId = '';
            $address = '';
            $stateProvinceCode = '';
            $countryCode = $arrayInfo['countryCode'];

             $str = $this->apiurl."geoSearch?minorRev=21&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "&customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&locale=".$this->local.
                    "&currencyCode=".$this->currency.
                    "&address=".$address.
                    "&city=".$city.
                    "&stateProvinceCode=".$stateProvinceCode.
                    "&countryCode=".$countryCode;
            return $this->apiCall($str);
        }




    public function getHotelList($arrayInfo)
    {


            $city = $arrayInfo['city'];
            $cityId = array_key_exists('cityId', $arrayInfo) ? $arrayInfo['cityId'] : '' ;
           // $countryCode = $arrayInfo['countryCode'];
            $checkIn = $arrayInfo['checkIn'];
            $checkOut = $arrayInfo['checkOut'];
            $rooms = $arrayInfo['rooms'];
            $numberOfResult = array_key_exists('numberOfResult', $arrayInfo) ? $arrayInfo['numberOfResult'] :10;

            /*filtering
             * please check the Filtering Methods section for compleate list http://developer.ean.com/docs/read/hotel_list
             */
            $propertyCategory = array_key_exists('propertyCategory', $arrayInfo) ? $arrayInfo['propertyCategory'] : '' ;
            $amenities = array_key_exists('amenities', $arrayInfo) ? $arrayInfo['amenities'] : '' ;
            $maxStarRating = array_key_exists('maxStarRating', $arrayInfo) ? $arrayInfo['maxStarRating'] : '' ;
            $minStarRating = array_key_exists('minStarRating', $arrayInfo) ? $arrayInfo['minStarRating'] : '' ;
            $minRate = array_key_exists('minRate', $arrayInfo) ? $arrayInfo['minRate'] : '' ;
            $maxRate = array_key_exists('maxRate', $arrayInfo) ? $arrayInfo['maxRate'] : '' ;

            /*
             * sorting
             * please check the Sorting Options section for compleate list http://developer.ean.com/docs/read/hotel_list
             *
             */
            $sort = $arrayInfo['sort'] = array_key_exists('sort', $arrayInfo) ? $arrayInfo['sort'] : 'NO_SORT' ;

           $str= $this->apiurl.'list?minorRev='.$this->rev.'&cid='.$this->cid.'&sig='.$this->sig.
                    '&apiKey='.$this->apiKey.'&customerSessionId&customerUserAgent='.$this->customerUserAgent.'&customerIpAddress='.$this->customerIpAddress.'&locale='.$this->local.
                    '&currencyCode='.$this->currency.
                    '&city='.$city.'&arrivalDate='.$checkIn.'&departureDate='.$checkOut.'&'.$rooms.'&numberOfResults='.$numberOfResult;
                  //  '&destinationId='.$cityId.
                  //  '&countryCode='.$countryCode.
                  //  '&propertyCategory='.$propertyCategory.
                  //  '&amenities='.$amenities.
                  //  '&maxStarRating='.$maxStarRating.
                  //  '&minStarRating='.$minStarRating.
                 //   '&minRate='.$minRate.
                 //   '&maxRate'.$maxRate.
                 //   '&sort='.$sort.
                 //   '&supplierCacheTolerance=MED&arrivalDate='.$checkIn.
                           //    '&supplierCacheTolerance=MED_ENHANCED';



        $result = array();

       $hotels = $this->apiCall($str);


            while ($hotels != null) {
                if (isset($hotels['HotelList'])) {
                    if ($hotels['HotelList']['@size'] > 1) {
                        $result = array_merge($result, $hotels['HotelList']['HotelSummary']);
                    } else {
                        $result = array_merge($result, array($hotels['HotelList']['HotelSummary']));
                    }
                }

                if (!$hotels['moreResultsAvailable']) {
                    break;
                }

                if (isset($arrayInfo['numberOfResults']) && count($result) <= intval($arrayInfo['numberOfResults'])) {
                    break;
                }


                       $customerSessionId = trim($hotels['customerSessionId']);
            $cacheKey = trim($hotels['cacheKey']);
            $cacheLocation = trim($hotels['cacheLocation']);

            $str2 = $this->apiurl."list?minorRev=21&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&locale=".$this->local.
                    "&currencyCode=".$this->currency.
                    "&cacheKey=".$cacheKey.
                    "&cacheLocation=".$cacheLocation;



                $hotels = $this->apiCall($str2);
            }




        return $hotels;
    }

 /*
         * function to get hotel payment option info
         */
        function paymentinfo($arrayInfo){
            //TODO
            $hotelId = trim($arrayInfo['hotelId']);
            $customerSessionId = trim($arrayInfo['customerSessionId']);

            $str = $this->apiurl."paymentInfo?minorRev=".$this->rev."&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "&customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&hotelId=".$hotelId.
                    "&rateKey=".$ratekey;
            $this->apistr = $str;
            return $this->apiCall($str);
        }


          function HotelRoomCancellation($arrayInfo) {
          $cnumber = $arrayInfo["confirmationnumber"];
          $iid = $arrayInfo["itineraryid"];
          $email = $arrayInfo["email"];
          $currency = $arrayInfo["currency"];
             $str = $this->apiurl."cancel?minorRev=".$this->rev."&cid=".$this->cid.'&sig='.$this->sig.
                    "&apiKey=".$this->apiKey.
                    "&customerUserAgent=".$this->customerUserAgent.
                    "&customerIpAddress=".$this->customerIpAddress.
                    "&customerSessionId=".$customerSessionId.
                    "&locale=".$this->local.
                    "&currencyCode=".$currency.
                    "&email=".$email.
                    "&itineraryId=".$iid.
                    "&confirmationNumber=".$cnumber;

            return $this->apiCall($str);
        }

        function get_all_bookings(){
        $user =  $this->ci->session->userdata('pt_logged_customer');
        $this->ci->load->model('Ean/Ean_model');
        return $this->ci->Ean_model->get_user_bookings($user);
        }


        function getShortResultsObject($result, $resultarray){
            $this->ci->load->helper('text');
            $resultData = array();
            foreach($resultarray as $res){

            $thumbnail = str_replace("_t","_b",$res['thumbNailUrl']);
            $slug = $this->baseUrl."hotel"."/".$res['hotelId']."/".$result['HotelListResponse']['customerSessionId'];
            $rating = $res['hotelRating'];
            $resultData[] = (object)array(
            'id' => $res['hotelId'],
            'title' => character_limiter($res['name'],28),
            'stars' => pt_create_stars(intval($res['hotelRating'])),
            'location' => $res['city'],
            'thumbnail' => "https://images.travelnow.com".$thumbnail,
            'currCode' => $res['rateCurrencyCode'],
            'price' => $res['lowRate'],
            'slug' => $slug,
            'rating' => $rating,

            );

            }

            return $resultData;

        }

      function itinRequestResp($itID, $email){

      $str = $this->itinUrl.'minorRev='.$this->rev.'&cid='.$this->cid.'&sig='.$this->sig.
      '&apiKey='.$this->apiKey.'&customerSessionId&customerUserAgent='.$this->customerUserAgent.'&customerIpAddress='.$this->customerIpAddress.'&locale='.$this->local.
      '&currencyCode='.$this->currency.
      '&itineraryId='.$itID.'&email='.$email;
      $this->apistr = $str;

      $response = $this->apiCall($str);
      return $response;
      }

      function totalStay($ckin, $chkout){
      $start = strtotime($ckin);
      $end = strtotime($chkout);

      $daysBetween = ceil(abs($end - $start) / 86400);
      $this->totalStay = $daysBetween;
      return $daysBetween;
      }

}
