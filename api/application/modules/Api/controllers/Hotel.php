<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Hotel extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();
        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('ApiClient');


        $this->load->library('Hotels/Hotels_lib');
        $this->load->model('Hotels/Hotels_model');
        $this->load->model('Admin/Modules_model');

    }

    //Aggregate Feature
    public function search_post(){
        //Manaul Hotel Search API
    $Hotel = $this->App->service('ModuleService')->isActive("Hotels");
    $manaulHotel = $this->App->service('ModuleService')->manaulmodules();
    $paylod = $this->post();
    $this->Hotels_lib->search_logs($paylod);
    $this->load->library('Hotels/Hotels_lib');
    $curr_code = $this->Hotels_lib->currencycode;
    if(!empty($this->post('currency'))){
        $currency = $this->post('currency');
    }else{
        $currency = $curr_code;
    }
    if($Hotel == 1) {

            $city_get = $this->Hotels_lib->suggestionResults_v2($this->post('city'));

            $param = array(
                'endpoint' => site_url().'api/hotels/search?appKey='.$this->input->get('appKey').'&checkin='.$this->post('checkin').'&checkout='.$this->post('checkout').'&location='.$city_get['forApi']['items'][0]->loc_id.'&lang='.$this->post('lang'),
            );
            $hotels = new ApiClient();
            $manaul = $hotels->sendRequest('GET', 'search', $param);
            $re = json_decode($manaul);
            $arry = array();
            foreach ($re->response as $index => $item) {
                $current_currency_price = $this->Hotels_model->currencyrate($item->currCode);
                $con_rate = $this->Hotels_model->currencyrate($currency);

                if(!empty($item->price) && !empty($current_currency_price)) {
                    $price_get = ceil($item->price / $current_currency_price);
                }else{
                    $price_get = 0;
                }

                if(!empty($item->b2c_markup)){
                    $b2c_markup = $item->b2c_markup;
                }else{
                    $b2c_markup = $manaulHotel[0]->b2c_markup;
                }

                if(!empty($item->b2b_markup)){
                    $b2b_markup = $item->b2b_markup;
                }else{
                    $b2b_markup = $manaulHotel[0]->b2b_markup;
                }


                if(!empty($item->b2e_markup)){
                    $b2e_markup = $item->b2e_markup;
                }else{
                    $b2e_markup = $manaulHotel[0]->b2e_markup;
                }

                if(!empty($item->service_fee)){
                    $service_fee = $item->service_fee;
                }else{
                    $service_fee = $manaulHotel[0]->servicefee;
                }


                // from to dates nights count
                $checkout = strtotime($this->post('checkout'));
                $checkin = strtotime($this->post('checkin'));
                $nights = $checkout - $checkin;
               $totaldays =  round($nights / (60 * 60 * 24));

                $price = $price_get * $con_rate;

                $b2c_price = ($b2c_markup / 100) * $price;
                $b2b_price = ($b2b_markup / 100) * $price;
                $b2e_price = ($b2e_markup / 100) * $price;


                $ament = [];
                foreach ($item->amenities as $aem){
                    if(!empty($aem->name)) {
                        $ament[] = (object)array("icon" => $aem->icon, "name" => $aem->name);
                    }
                }

                array_push($arry, (object)[
                    'hotel_id' => $item->id,
                    'name' => $item->title,
                    'location' => $item->location,
                    'stars' => str_replace('Stars', '', $item->starsCount),
                    'rating' => str_replace('Stars', '', $item->starsCount),
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'price' => $price * $totaldays,
                    'pre_day' => $price,
                    'actual_price' => $item->price,
                    'b2c_price' => ($price + $b2c_price)*$totaldays,
                    'b2b_price' => ($price + $b2b_price)*$totaldays,
                    'b2e_price' =>  ($price + $b2e_price)*$totaldays,
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' =>  $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $service_fee,
                    'img' => $item->thumbnail,
                    'currency' => $currency,
                    'actual_currency' => $item->currCode,
                    'supplier' => 1,
                    'supplier_name' => 'manual',
                    'redirect' => "",
                    'city_code' => '',
                    'country_code' => '',
                    'address' => $item->address,
                    'discount' => $item->discount,
                    'amenities' => $ament,

                ]);

            }

        }

        // Multithreading Hotels Search Api's
      $Multithreading = $this->App->service('ModuleService')->hotelmodules();
        $array = array();
        foreach ($Multithreading as $key=>$value){
            $getvalue = $this->Modules_model->getmodulename($value['name']);
            $b2c_markup =  $getvalue[0]->b2c_markup;
            $b2b_markup =  $getvalue[0]->b2b_markup;
            $b2e_markup =  $getvalue[0]->b2e_markup;
            $servicefee =  $getvalue[0]->servicefee;
            $desposit =  $getvalue[0]->desposit;

            $param = array(
                'city' => $this->post('city'),
                'c1' => $getvalue[0]->c1,
                'c2' => $getvalue[0]->c2,
                'c3' => $getvalue[0]->c3,
                'c4' => $getvalue[0]->c4,
                'c5' => $getvalue[0]->c5,
                'c6' => $getvalue[0]->c6,
                'c7' => $getvalue[0]->c7,
                'c8' => $getvalue[0]->c8,
                'c9' => $getvalue[0]->c9,
                'c10' => $getvalue[0]->c10,
                'checkin' => $this->post('checkin'),
                'checkout' => $this->post('checkout'),
                'nationality' => $this->post('nationality'),
                'adults' => $this->post('adults'),
                'chlids' => $this->post('chlids'),
                'child_age' => $this->post('child_age'),
                'rooms' => $this->post('rooms'),
                'endpoint' => "https://travelapi.co/modules/hotels/".strtolower($value['name'])."/api/v1/search",
            );
            $hotels = new ApiClient();
            $response = $hotels->sendRequest('POST', 'search', $param);
            $array_aggrate = array();
            $aggrate = json_decode($response);
            foreach ($aggrate as $add_price){
                $b2c_price = ($b2c_markup / 100) * $add_price->actual_price;
                $b2b_price = ($b2b_markup / 100) * $add_price->actual_price;
                $b2e_price = ($b2e_markup / 100) * $add_price->actual_price;

                array_push($array_aggrate, (object)[
                    'hotel_id' => $add_price->hotel_id,
                    'name' => $add_price->name,
                    'location' => $add_price->location,
                    'stars' => $add_price->stars,
                    'rating' => $add_price->rating,
                    'latitude' => $add_price->latitude,
                    'longitude' => $add_price->longitude,
                    'price' => $add_price->price,
                    'actual_price' => $add_price->price,
                    'b2c_price' => ($add_price->actual_price + $b2c_price),
                    'b2b_price' => ($add_price->actual_price + $b2b_price),
                    'b2e_price' =>  ($add_price->actual_price + $b2e_price),
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' =>  $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $servicefee,
                    'img' => $add_price->img,
                    'currency' => $add_price->currency,
                    'actual_currency' => $add_price->actual_currency,
                    'supplier' => $getvalue[0]->id,
                    'supplier_name' => strtolower($value['name']),
                    'redirect' =>  $add_price->redirect,
                    'city_code' =>  $add_price->city_code,
                    'country_code' =>  $add_price->country_code,
                    'address' => $add_price->address,
                    'discount' => $desposit,
                    'amenities' => $add_price->amenities,

                ]);

            }
            array_push($array,$array_aggrate);
        }
        //$a1=file_get_contents(FCPATH."application/json/api_data.json");
        $json = $array;
        $arr = [];
        foreach ($json as $key=>$value){
            foreach ($value as $num=>$data){
                array_push($arr, (object)[
                    'hotel_id' => $data->hotel_id,
                    'name' => $data->name,
                    'location' => $data->location,
                    'stars' => $data->stars,
                    'rating' => $data->rating,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'price' => $data->price,
                    'actual_price' => $data->actual_price,
                    'b2c_price' => $data->b2c_price,
                    'b2b_price' => $data->b2b_price,
                    'b2e_price' => $data->b2e_price,
                    'b2c_markup' => $data->b2c_markup,
                    'b2b_markup' =>  $data->b2b_markup,
                    'b2e_markup' => $data->b2e_markup,
                    'service_fee' => $data->service_fee,
                    'img' => $data->img,
                    'currency' => $data->currency,
                    'actual_currency' => $data->actual_currency,
                    'supplier' => $data->supplier,
                    'supplier_name' => $data->supplier_name,
                    'redirect' => $data->redirect,
                    'city_code' => $data->city_code,
                    'country_code' => $data->country_code,
                    'address' => $data->address,
                    'discount' => $data->discount,
                    'amenities' => $data->amenities,
                ]);
            }
        }

        if(!empty($arr) && !empty($arry)){
            $data = array_merge($arry,$arr);
        }elseif (!empty($arr)){
            $data = $arr;
        }elseif (!empty($arry)){
            $data = $arry;
        }else{
            $data = '';
        }

        $this->response($data);
    }

    function detail_post(){

        //Manual Hotel Detail API

        $curr_code = $this->Hotels_lib->currencycode;
        if(!empty($this->post('currency'))){
            $currency = $this->post('currency');
        }else{
            $currency = $curr_code;
        }
        if($this->post('supplier') == 1){
            $manaulHotel = $this->App->service('ModuleService')->manaulmodules();
            $param = array(
                'endpoint' => site_url()."api/hotels/hoteldetails?appKey=".$this->input->get('appKey')."&id=".$this->post('hotel_id'),
            );

            $hotels = new ApiClient();
            $manaul = $hotels->sendRequest('GET', 'search', $param);

            $butt = json_decode($manaul);
            $room = [];

            foreach ($butt->response->rooms as $ro){
                $current_currency_price = $this->Hotels_model->currencyrate($ro->currCode);
                $con_rate = $this->Hotels_model->currencyrate($currency);

                if(!empty($ro->price) && !empty($current_currency_price)) {
                    $price_get = ceil($ro->price / $current_currency_price);
                }else{
                    $price_get = 0;
                }
                $price = ceil($price_get * $con_rate);



                // from to dates nights count
                $checkout = strtotime($this->post('checkout'));
                $checkin = strtotime($this->post('checkin'));
                $nights = $checkout - $checkin;
                $totaldays =  round($nights / (60 * 60 * 24));


                if(!empty($butt->response->hotel->b2c_markup)){
                    $b2c_markup = $butt->response->hotel->b2c_markup;
                }else{
                    $b2c_markup = $manaulHotel[0]->b2c_markup;
                }

                if(!empty($butt->response->hotel->b2b_markup)){
                    $b2b_markup = $butt->response->hotel->b2b_markup;
                }else{
                    $b2b_markup = $manaulHotel[0]->b2b_markup;
                }


                if(!empty($butt->response->hotel->b2e_markup)){
                    $b2e_markup = $butt->response->hotel->b2e_markup;
                }else{
                    $b2e_markup = $manaulHotel[0]->b2e_markup;
                }

                if(!empty($butt->response->hotel->service_fee)){
                    $service_fee = $butt->response->hotel->service_fee;
                }else{
                    $service_fee = $manaulHotel[0]->servicefee;
                }


                $b2c_price = ($b2c_markup / 100) * $price;
                $b2b_price = ($b2b_markup / 100) * $price;
                $b2e_price = ($b2e_markup / 100) * $price;

                $room_image = [];
                foreach ($ro->Images as $img){
                    array_push($room_image,$img->fullImage);
                }

                $ro_ament = [];
                foreach ($ro->Amenities as $ro_aem){
                    if(!empty($ro_aem->name)) {
                        $ro_ament[] = (object)array("icon" => $ro_aem->icon, "name" => $ro_aem->name);
                    }
                }

                array_push($room, (object)[
                    'id' => $ro->id,
                    'name' => $ro->title,
                    'price' => $price,
                    'pre_day' => $price,
                    'real_price' => $ro->price,
                    'b2c_price' => ($price + $b2c_price) * $totaldays,
                    'b2b_price' => ($price + $b2b_price)*$totaldays,
                    'b2e_price' => ($price + $b2e_price)*$totaldays,
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' =>  $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $service_fee,
                    'actual_currency' => $ro->currCode,
                    'currency' => $this->post('currency'),
                    'refundable' => '',
                    'refundable_date' => '',
                    'img' => $room_image,
                    'amenities' => $ro_ament,
                    'options' => array([
                        'id' => $ro->id,
                        'currCode'=>$ro->currCode,
                        'price' => $price,
                        'pre_day' => $price,
                        'real_price' => $ro->price,
                        'b2c_price' => ($price + $b2c_price) * $totaldays,
                        'b2b_price' => ($price + $b2b_price)*$totaldays,
                        'b2e_price' => ($price + $b2e_price)*$totaldays,
                        'b2c_markup' => $b2c_markup,
                        'b2b_markup' =>  $b2b_markup,
                        'b2e_markup' => $b2e_markup,
                        'service_fee' => $service_fee,
                        'quantity' => $ro->Info->quantity,
                        'adults' => $ro->Info->maxAdults,
                        'child' => $ro->Info->maxChild,
                        'children_ages' => 0,
                        'bookingurl' => '',
                        'bookingKey' => '',
                        'extrabeds_quantity' => $ro->extraBeds,
                        'extrabed_price' => $ro->extrabedCharges,
                        'room_adult_price' => $ro->room_adult_price,
                        'room_child_price' => $ro->room_child_price,
                        'price_type' => $ro->price_type,
                        'cancellation_info' => '',


                    ]),
                ]);


            }

            if(!empty($butt->response->hotel->tax_type)){
                $tax = $butt->response->hotel->tax_type;
            }else{
                $tax = $manaulHotel[0]->tax_type;
            }

            if(!empty($butt->response->hotel->deposit_type)){
                $deposit_type = $butt->response->hotel->deposit_type;
            }else{
                $deposit_type = $manaulHotel[0]->deposit_type;
            }

            if(!empty($butt->response->hotel->tax_amount)){
                $tax_amount = $butt->response->hotel->tax_amount;
            }else{
                $tax_amount = $manaulHotel[0]->tax;
            }

            if(!empty($butt->response->hotel->deposit_amount)){
                $deposit_amount = $butt->response->hotel->deposit_amount;
            }else{
                $deposit_amount = $manaulHotel[0]->desposit;
            }
            $image = [];
            foreach ($butt->response->hotel->sliderImages as $img){
                array_push($image,$img->fullImage);
            }

            $ament = [];
            foreach ($butt->response->hotel->amenities as $aem){
                if(!empty($butt->response->hotel->amenities)) {
                    $ament[] = (object)array("icon" => $aem->icon, "name" => $aem->name);
                }
            }
            $detail = array(
                'id' => $butt->response->hotel->id,
                'name' => $butt->response->hotel->title,
                'location' => $butt->response->hotel->location,
                'stars' => $butt->response->hotel->starsCount,
                'rating' => $butt->response->hotel->starsCount,
                'longitude' =>  $butt->response->hotel->latitude,
                'latitude' => $butt->response->hotel->longitude,
                'desc' =>  $butt->response->hotel->desc,
                'img' =>  $image,
                'amenities' =>$ament,
                'supplier_name' => 'manual',
                'supplier' => 1,
                'rooms' => $room,
                'policy' => $butt->response->hotel->policy,
                'address' => $butt->response->hotel->mapAddress,
                'tax_type' => $tax,
                'tax_amount' => $tax_amount,
                'deposit_type' => $deposit_type,
                'deposit_amount' => $deposit_amount,
                'payment_option' => $butt->response->hotel->paymentOptions,
                'hotel_phone' => $butt->response->hotel->hotel_phone,
                'hotel_email' => $butt->response->hotel->hotel_email,
                'hotel_website' => $butt->response->hotel->hotel_website,
                'discount' => $butt->response->hotel->discount,
            );

            $this->response($detail);
        }

        // Multithreading Hotels Details Api's
        if($this->post('supplier') != 1) {
            $getvalue = $this->Modules_model->getmodule_id($this->post('supplier'));
            $b2c_markup =  $getvalue[0]->b2c_markup;
            $b2b_markup =  $getvalue[0]->b2b_markup;
            $b2e_markup =  $getvalue[0]->b2e_markup;
            $servicefee =  $getvalue[0]->servicefee;
            $param = array(
                'hotel_id' => $this->post('hotel_id'),
                'city_code' => $this->post('city_code'),
                'country_code' => strtoupper($this->post('country_code')),
                'c1' => $getvalue[0]->c1,
                'c2' => $getvalue[0]->c2,
                'c3' => $getvalue[0]->c3,
                'c4' => $getvalue[0]->c4,
                'c5' => $getvalue[0]->c5,
                'c6' => $getvalue[0]->c6,
                'c7' => $getvalue[0]->c7,
                'c8' => $getvalue[0]->c8,
                'c9' => $getvalue[0]->c9,
                'c10' => $getvalue[0]->c10,
                'checkin' => $this->post('checkin'),
                'checkout' => $this->post('checkout'),
                'nationality' => $this->post('nationality'),
                'adults' => $this->post('adults'),
                'chlids' => $this->post('chlids'),
                'child_age' => $this->post('child_ages'),
                'rooms' => $this->post('rooms'),
                'endpoint' => "https://travelapi.co/modules/hotels/".strtolower($getvalue[0]->name)."/api/v1/detail",
            );
            $hotels = new ApiClient();
            $rezlives = $hotels->sendRequest('POST', 'search', $param);

            $rep = json_decode($rezlives);
            $room = [];
            foreach ($rep->rooms as $ro){

                $b2c_price = ($b2c_markup / 100) * $ro->real_price;
                $b2b_price = ($b2b_markup / 100) * $ro->real_price;
                $b2e_price = ($b2e_markup / 100) * $ro->real_price;

                array_push($room, (object)[
                    'id' => $ro->id,
                    'name' => $ro->name,
                    'price' => $ro->price,
                    'real_price' => $ro->real_price,
                    'b2c_price' => ($ro->real_price + $b2c_price),
                    'b2b_price' => ($ro->real_price + $b2b_price),
                    'b2e_price' => ($ro->real_price + $b2e_price),
                    'b2c_markup' => $b2c_markup,
                    'b2b_markup' =>  $b2b_markup,
                    'b2e_markup' => $b2e_markup,
                    'service_fee' => $servicefee,
                    'actual_currency' => $ro->actual_currency,
                    'currency' => $ro->currency,
                    'refundable' => $ro->refundable,
                    'refundable_date' => $ro->refundable_date,
                    'img' => $ro->img,
                    'amenities' => $ro->amenities,
                    'options' => array([
                        'id' => $ro->options[0]->id,
                        'currCode'=>$ro->options[0]->currCode,
                        'price' => $ro->options[0]->price,
                        'real_price' => $ro->options[0]->real_price,
                        'b2c_price' => ($ro->real_price + $b2c_price),
                        'b2b_price' => ($ro->real_price + $b2b_price),
                        'b2e_price' => ($ro->real_price + $b2e_price),
                        'b2c_markup' => $b2c_markup,
                        'b2b_markup' =>  $b2b_markup,
                        'b2e_markup' => $b2e_markup,
                        'service_fee' => $servicefee,
                        'quantity' => $ro->options[0]->quantity,
                        'adults' => $ro->options[0]->adults,
                        'child' => $ro->options[0]->child,
                        'children_ages' => $ro->options[0]->children_ages,
                        'bookingurl' => $ro->options[0]->bookingurl,
                        'bookingKey' => $ro->options[0]->bookingKey,
                        'extrabeds_quantity' => $ro->options[0]->extrabeds_quantity,
                        'extrabed_price' => $ro->options[0]->extrabed_price,
                        'room_adult_price' => $ro->options[0]->room_adult_price,
                        'room_child_price' => $ro->options[0]->room_child_price,
                        'price_type' =>$ro->options[0]->price_type,
                        'cancellation_info' => $ro->options[0]->cancellation_info,
                    ]),
                ]);

            }

            $detail = array(
                'id' => $rep->id,
                'name' => $rep->name,
                'location' => $rep->location,
                'stars' => $rep->stars,
                'rating' => $rep->rating,
                'longitude' => $rep->longitude,
                'latitude' => $rep->latitude,
                'desc' =>  $rep->desc,
                'img' =>  $rep->img,
                'amenities' =>$rep->amenities,
                'supplier_name' => strtolower($getvalue[0]->name),
                'supplier' => $getvalue[0]->id,
                'rooms' => $room,
                'policy' => $rep->policy,
                'address' => $rep->address,
                'tax_type' =>  $getvalue[0]->tax_type,
                'tax_amount' =>  $getvalue[0]->tax,
                'deposit_type' =>  $getvalue[0]->deposit_type,
                'deposit_amount' =>  $getvalue[0]->desposit,
                'payment_option' => $rep->payment_option,
                'hotel_phone' => $rep->hotel_phone,
                'hotel_email' =>$rep->hotel_email,
                'hotel_website' => $rep->hotel_website,
                'discount' => '',
            );

            $this->response($detail);
        }
    }

    function book_post(){
            $param = array(
                'hotel_id' => $this->post('hotel_id'),
                'total_price' => $this->post('total_price'),
                'firstname' => $this->post('firstname'),
                'lastname' => $this->post('lastname'),
                'email' => $this->post('email'),
                'address' => $this->post('address'),
                'phone' => $this->post('phone'),
                'booking_checkin' => $this->post('checkin'),
                'couponid' => 0,
                'booking_adults' => $this->post('adults'),
                'booking_childs' => $this->post('childs'),
                'booking_deposit' => $this->post('deposit'),
                'booking_tax' => $this->post('tax'),
                'booking_curr_code' => $this->post('curr_code'),
                'tax_type' => $this->post('tax_type'),
                'deposit_type' => $this->post('deposit_type'),
                'hotel_name' => $this->post('hotel_name'),
                'booking_checkout' => $this->post('checkout'),
                'booking_nights' => $this->post('nights'),
                'loaction' => $this->post('loaction'),
                'hotel_img' => $this->post('hotel_img'),
                'booking_supplier' => $this->post('supplier'),
                'booking_payment_gateway' =>  $this->post('payment_gateway'),
                'booking_user_id' =>  $this->post('user_id'),
                'latitude' =>  $this->post('latitude'),
                'longitude' =>  $this->post('longitude'),
                'rooms' =>  $this->post('rooms'),
                'endpoint' => site_url()."/api/hotels/hotelbooking?appKey=".$this->input->get('appKey'),
                'booking_key' => $this->post('booking_key'),
                'guest' => $this->post('guest'),
                'supplier_name' => $this->post('supplier_name'),
                'hotel_stars' => $this->post('stars'),
                'hotel_phone' => $this->post('hotel_phone'),
                'hotel_email' => $this->post('hotel_email'),
                'hotel_website' => $this->post('hotel_website'),
                'country_code' => $this->post('hotel_country_code'),
                'city_code' => $this->post('hotel_city_code'),
                'nationality' => $this->post('hotel_nationality'),
                'booking_from' => $this->post('booking_from'),
                'room_adult_price' => $this->post('room_adult_price'),
                'room_child_price' => $this->post('room_child_price'),
                'price_type' => $this->post('price_type'),
                'children_ages' => $this->post('children_ages'),
            );
            $hotels = new ApiClient();
            $book = $hotels->sendRequest('POST', 'search', $param);
            if(!empty($book)){
                $checkbooking = json_decode($book);
                $site_url = $this->post('invoice_url').$checkbooking->response->sessid."/".$checkbooking->response->id;
                $this->Hotels_lib->invoceurlupdate($checkbooking->response->id,$site_url);
                $bookingResult = array('response'=>true,'id'=>$checkbooking->response->id,'sessid'=>$checkbooking->response->sessid);
               $this->response($bookingResult);
            }
    }

     function invoice_post(){
            $parm = array(
                'id' => $this->post('booking_id'),
                'ref_id' => $this->post('ref_id'),
                'status' => $this->post('status'),
                'payment_gateway' => $this->post('payment_gateway'),
                'amount_paid' => $this->post('amount_paid'),
                'remaining_amount' => $this->post('remaining_amount'),
                'payment_date' => $this->post('payment_date'),
                'txn_id' => $this->post('txn_id'),
                'token' => $this->post('token'),
                'logs' => $this->post('logs'),
                'payment_status' => $this->post('payment_status'),
                'desc' => $this->post('desc'),
                'endpoint' => site_url()."/api/hotels/invoicebooking?appKey=".$this->input->get('appKey'),
            );
            $hotels = new ApiClient();
            $bookinvoice = $hotels->sendRequest('POST', 'search', $parm);
         $this->response($bookinvoice);
     }

     function cofirmedbooking_post(){

         $booking_id = $this->post('booking_id');
       $chk = $this->Hotels_lib->get_booking($booking_id);
      if(!empty($chk)){
             $getvalue = $this->Modules_model->getmodule_id($chk[0]->booking_supplier);
             $roomdata = $this->Hotels_lib->getrooms_data($chk[0]->booking_id);
             $parm = array(
                 'hotel_id' => $chk[0]->hotel_id,
                 'city_code' => $chk[0]->city_code,
                 'country_code' => $chk[0]->country_code,
                 'c1' => $getvalue[0]->c1,
                 'c2' => $getvalue[0]->c2,
                 'c3' => $getvalue[0]->c3,
                 'c4' => $getvalue[0]->c4,
                 'c5' => $getvalue[0]->c5,
                 'c6' => $getvalue[0]->c6,
                 'c7' => $getvalue[0]->c7,
                 'c8' => $getvalue[0]->c8,
                 'c9' => $getvalue[0]->c9,
                 'c10' => $getvalue[0]->c10,
                 'checkin' => date('d-m-Y',strtotime($chk[0]->booking_checkin)),
                 'checkout' => date('d-m-Y',strtotime($chk[0]->booking_checkout)),
                 'nationality' => $chk[0]->nationality,
                 'adults' => $chk[0]->booking_adults,
                 'chlids' => $chk[0]->booking_childs,
                 'booking_key' => $chk[0]->booking_key,
                 'total_rooms' => $roomdata[0]->room_qaunitity,
                 'room_name' => $roomdata[0]->room_name,
                 'room_price' => $roomdata[0]->room_actual_price,
                 'hotel_name' => $chk[0]->hotel_name,
                 'booking_guest_info' => $chk[0]->booking_guest_info,
                 'booking_id' => $chk[0]->booking_id,
                 'booking_ref_no' => $chk[0]->booking_ref_no,
                 'children_ages' => $chk[0]->children_ages,
                 'endpoint' => "https://travelapi.co/modules/hotels/".strtolower($getvalue[0]->name)."/api/v1/booking",
             );
             $bookinghotels = new ApiClient();
             $bookconf = $bookinghotels->sendRequest('POST', 'search', $parm);
             if(!empty($bookconf)){
                 $store = $this->Hotels_lib->response_booking($booking_id,$bookconf);
                 $this->response(array('status' => True,'invoice_url' => $store[0]->invoice_url), 200);

             }else{
                 $this->response(array('status' => False,'msg' => 'something is worng please check your request'), 200);
             }
         }else{
             $this->response(array('status' => False,'msg' => 'Record not found'), 200);
         }
     }
     function cancellation_post(){
         $parm = array(
             'id' => $this->post('booking_id'),
             'ref_id' => $this->post('ref_id'),
             'supplier' => $this->post('supplier'),
             'booking_cancellation_request' => $this->post('cancellation_request'),
             'endpoint' => site_url()."/api/hotels/cancellationbooking?appKey=".$this->input->get('appKey'),
         );
         $hotels = new ApiClient();
         $cancelbook = $hotels->sendRequest('POST', 'search', $parm);
         $this->response($cancelbook);
     }
}