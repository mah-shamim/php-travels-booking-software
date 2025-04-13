<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Tour extends REST_Controller {

    function __construct() {
        // Construct our parent class
        parent :: __construct();
        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->output->set_content_type('application/json');
        $this->load->library('ApiClient');
        $this->load->model('Admin/Modules_model');
        $this->load->model('Admin/Locations_model');
    }

    //Aggregate Feature
    public function search_post(){
        //Manaul Tour Search API
        $Tours = $this->App->service('ModuleService')->isActive("Tours");
        $manaultour = $this->App->service('ModuleService')->getmodulesdata("Tours");
       if($Tours == 1){
           $loc_id = $this->Locations_model->getLocationDet($this->post('loaction'));
           $param = array(
               'endpoint' => site_url().'api/tours/search?appKey='.$this->input->get('appKey'),
               'city' => $loc_id
           );

           $tours = new ApiClient();
           $response = $tours->sendRequest('POST', 'search', $param);
           $re = json_decode($response);
           $arry = array();

           $b2c_markup = $manaultour[0]->b2c_markup;
           $b2b_markup = $manaultour[0]->b2b_markup;
           $b2e_markup = $manaultour[0]->b2e_markup;
           $servicefee = $manaultour[0]->servicefee;

           foreach ($re->response as $index => $data) {

               $price = round($data->price);
               $b2c_price = ($b2c_markup / 100) * $price;
               $b2b_price = ($b2b_markup / 100) * $price;
               $b2e_price = ($b2e_markup / 100) * $price;
               array_push($arry, (object)[
                   'tour_id' =>$data->tour_id,
                   'name' => $data->name,
                   'location' => $data->location,
                   'img' => $data->img,
                   'desc' => strip_tags($data->desc),
                   'price' => round($data->price),
                   'actual_price' => $data->price,
                   'b2c_price' => round($price + $b2c_price),
                   'b2b_price' => round($price + $b2b_price),
                   'b2e_price' => round($price + $b2e_price),
                   'b2c_markup' => $b2c_markup,
                   'b2b_markup' => $b2b_markup,
                   'b2e_markup' => $b2e_markup,
                   'service_fee' => $servicefee,
                   'duration' => $data->duration,
                   'rating' => $data->rating,
                   'redirected' => $data->redirected,
                   'supplier' => $data->supplier,
                   'latitude' => $data->latitude,
                   'longitude' => $data->longitude,
                   'currency_code' => $data->currency_code

               ]);

           }
       }


        // Multithreading Tours Search Api's
        $Multithreading = $this->App->service('ModuleService')->tourmodules();
        $array = array();
        foreach ($Multithreading as $key=>$value){
            $getvalue = $this->Modules_model->getmodulename($value['name']);
            $param = array(
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
                'b2c_markup' => $getvalue[0]->b2c_markup,
                'b2b_markup' => $getvalue[0]->b2b_markup,
                'b2e_markup' => $getvalue[0]->b2e_markup,
                'desposit' => $getvalue[0]->desposit,
                'tax' => $getvalue[0]->tax,
                'service_fee' => $getvalue[0]->servicefee,
                'supplier_id'=> $getvalue[0]->id,
                'checkin' => ($this->post('checkin')) ? strtoupper($this->post('checkin')) : "",
                'checkout' => ($this->post('checkout')) ? strtoupper($this->post('checkout')) : "",
                'loaction' => ($this->post('loaction')) ? strtoupper($this->post('loaction')) : "",
                'country' => ($this->post('country')) ? strtoupper($this->post('country')) : "",
                'endpoint' => "https://travelapi.co/modules/tours/".strtolower($value['name'])."/api/v1/search",
            );
            $tours = new ApiClient();
            $response = $tours->sendRequest('POST', 'search', $param);
            array_push($array,json_decode($response));
        }
        $json = $array;
        $arr = [];
        foreach ($json as $key=>$value){
            foreach ($value as $num=>$data){
                array_push($arr, (object)[
                    'tour_id' =>$data->tour_id,
                    'name' => $data->name,
                    'location' => $data->location,
                    'img' => $data->img,
                    'desc' => strip_tags($data->desc),
                    'price' => round($data->price),
                    'actual_price' => $data->price,
                    'b2c_price' => $data->b2c_price,
                    'b2b_price' => $data->b2b_price,
                    'b2e_price' => $data->b2e_price,
                    'b2c_markup' => $data->b2c_markup,
                    'b2b_markup' => $data->b2b_markup,
                    'b2e_markup' => $data->b2e_markup,
                    'service_fee' => $data->service_fee,
                    'duration' => $data->duration,
                    'rating' => $data->rating,
                    'redirected' => $data->redirected,
                    'supplier' => $data->supplier,
                    'latitude' => '',
                    'longitude' => '',
                    'currency_code' => $data->currency_code
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
        if($this->post('supplier') == 1){
            $manaultours = $this->App->service('ModuleService')->getmodulesdata("Tours");
            $param = array(
                'endpoint' => site_url()."api/tours/details?appKey=".$this->input->get('appKey')."&id=".$this->post('tour_id'),
            );
            $tourdet = new ApiClient();
            $manaul = $tourdet->sendRequest('GET', 'search', $param);

            $manaultour = json_decode($manaul);

            $b2c_markup = $manaultours[0]->b2c_markup;
            $b2b_markup = $manaultours[0]->b2b_markup;
            $b2e_markup = $manaultours[0]->b2e_markup;
            $servicefee = $manaultours[0]->servicefee;



            $price = round($manaultour->response->tour->perAdultPrice);
            $b2c_price = ($b2c_markup / 100) * $price;
            $b2b_price = ($b2b_markup / 100) * $price;
            $b2e_price = ($b2e_markup / 100) * $price;


            $price_chlid = round($manaultour->response->tour->perChildPrice);
            $b2c_price_chlid = ($b2c_markup / 100) * $price_chlid;
            $b2b_price_chlid = ($b2b_markup / 100) * $price_chlid;
            $b2e_price_chlid = ($b2e_markup / 100) * $price_chlid;

            $price_infant = round($manaultour->response->tour->perInfantPrice);
            $b2c_price_infant = ($b2c_markup / 100) * $price_infant;
            $b2b_price_infant = ($b2b_markup / 100) * $price_infant;
            $b2e_price_infant = ($b2e_markup / 100) * $price_infant;

            $img = [];
            foreach ($manaultour->response->tour->sliderImages as $photo){
                $img[] = $photo->fullImage;
            }

            $inclusions = [];
            foreach ($manaultour->response->tour->inclusions as $inclusion){
                $inclusions[] = $inclusion->name;
            }

            $exclusions = [];
            foreach ($manaultour->response->tour->exclusions as $exclusion){
                $exclusions[] = $exclusion->name;
            }


            $array = array(
                'tour_id' => $manaultour->response->tour->id,
                'name' => $manaultour->response->tour->title,
                'tour_type' => '',
                'location' => $manaultour->response->tour->location,
                'img' => $img,
                'desc' => strip_tags($manaultour->response->tour->desc),
                'price' => $price,
                'actual_price' => $manaultour->response->tour->perAdultPrice,
                'b2c_price_adult' => round($manaultour->response->tour->perAdultPrice + $b2c_price),
                'b2b_price_adult' => round($manaultour->response->tour->perAdultPrice + $b2b_price),
                'b2e_price_adult' => round($manaultour->response->tour->perAdultPrice + $b2e_price),
                'b2c_price_child' => round($manaultour->response->tour->perChildPrice + $b2c_price_chlid),
                'b2b_price_child' => round($manaultour->response->tour->perChildPrice + $b2b_price_chlid),
                'b2e_price_child' => round($manaultour->response->tour->perChildPrice + $b2e_price_chlid),
                'b2c_price_infant' => round($manaultour->response->tour->perInfantPrice + $b2c_price_infant),
                'b2b_price_infant' => round($manaultour->response->tour->perInfantPrice + $b2b_price_infant),
                'b2e_price_infant' => round($manaultour->response->tour->perInfantPrice + $b2e_price_infant),
                'b2c_markup' => $b2c_markup,
                'b2b_markup' =>  $b2b_markup,
                'b2e_markup' => $b2e_markup,
                'service_fee' => $servicefee,
                'adult_price' => $manaultour->response->tour->perAdultPrice,
                'child_price' => $manaultour->response->tour->perChildPrice,
                'infant_price' => $manaultour->response->tour->perInfantPrice,
                'maxAdults' => $manaultour->response->tour->maxAdults,
                'maxChild' => $manaultour->response->tour->maxChild,
                'maxInfant' => $manaultour->response->tour->maxInfant,
                'rating' => $manaultour->response->tour->starsCount,
                'longitude' => $manaultour->response->tour->longitude,
                'latitude' => $manaultour->response->tour->latitude,
                'redirect' => '',
                'inclusions' => $inclusions,
                'exclusions' => $exclusions,
                'currencycode' => $manaultour->response->tour->currCode,
                'duration' => '',
                'policy' => $manaultour->response->tour->policy,
                'max_travellers' => '',
                'departure_time' => '',
                'departure_point' => '',
                'supplier' =>$this->post('supplier')
            );
            $this->response($array);
        }

        // Multithreading Hotels Details Api's
        if($this->post('supplier') != 1) {
            $getvalue = $this->Modules_model->getmodule_id($this->post('supplier'));
            $param = array(
                'tour_id' => $this->post('tour_id'),
                'c1' => $getvalue[0]->c1,
                'supplier_id' => $this->post('supplier'),
                'b2c_markup' => $getvalue[0]->b2c_markup,
                'b2b_markup' => $getvalue[0]->b2b_markup,
                'b2e_markup' => $getvalue[0]->b2e_markup,
                'desposit' => $getvalue[0]->desposit,
                'tax' => $getvalue[0]->tax,
                'service_fee' => $getvalue[0]->servicefee,
                'endpoint' => "https://travelapi.co/modules/tours/".strtolower($getvalue[0]->name)."/api/v1/detail",
            );
            $tours = new ApiClient();
            $toursapi = $tours->sendRequest('POST', 'search', $param);

            if(!empty($toursapi)){
                $this->response($toursapi);
            }
        }
    }

}