<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';
class Travelpayoutsflightapi extends REST_Controller {
    const Module = "TravelPayoutsFlightsAPI";
    private $config = [];
    public  $data;
    public  $airlines = [];
    public $mini_price;
    public $max_price;
    public $final_array = [];
    public $limit = 50;

    function __construct() {
        // Construct our parent class
        parent :: __construct();

        if(!$this->isValidApiKey){
            $this->response($this->invalidResponse, 400);
        }
        $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;
        $this->output->set_content_type('application/json');
        $this->load->model('TravelPayoutsFlightsAPI/TravelPayoutsFlights_model');

    }
    /*TravelPayoutsFlightsAPI get list*/
    public function search_post(){

        //dd($this->post());
        $orgin = $this->post('origin');
        $destination = $this->post('destination');
        $triptypename = $this->post('triptypename');
        $departureDate = $this->post('departureDate');
        $adult = $this->post('adult');
        $children = $this->post('children');
        $infant = $this->post('infant');
        $return_date = $this->post('return_date');
        $class_trip = $this->post('class_trip');
        $currencycode = $this->post('currency_code');

        if($this->config->api_environment == 'sandbox'){
            $token = 'e68847b2-e052-11e9-8891-dae1d83fdc87';
        }else{
            $token = $this->config->api_token;
        }

       $booking_link =  'http://misc.travelpayouts.com/flights/redirect/'.$token;

        if($triptypename != 'round' ) {
            $sing =md5($this->config->api_token.':localhost:en:' . $this->config->marker_id . ':' . intval($adult) . ':' . intval($children) . ':' . intval($infant) . ':' . $departureDate . ':' . $destination . ':' . $orgin . ':' . $class_trip . ':110.36.223.2');
            $segments = array((object)[
                "origin"         => $orgin,
                "destination"        => $destination,
                "date"         => $departureDate
            ]
            );
        }else{
            $sing =  md5($this->config->api_token.':localhost:en:'.$this->config->marker_id.':'.intval($adult).':'.intval($children).':'.intval($infant).':'.$departureDate.':'.$destination.':'.$orgin.':'.$return_date.':'.$orgin.':'.$destination.':'.$class_trip.':110.36.223.2');
            $segments = array((object)[
                "origin"         => $orgin,
                "destination"        => $destination,
                "date"         => $departureDate
            ],
                [
                    "origin"         => $destination,
                    "destination"        => $orgin,
                    "date"         => $return_date
                ]
            );
        }

        $data_array =  array(
            "signature"        => $sing,
            "marker"        => $this->config->marker_id,
            "host"        => 'localhost',
            "user_ip"        => '110.36.223.2',
            "locale"        => 'en',
            "trip_class"        => $class_trip,
            "passengers"         => array(
                "adults"         => $adult,
                "children"        => $children,
                "infants"         => $infant
            ),
            "segments"         =>$segments,
        );

        $data_string = json_encode($data_array);

        $ch = curl_init( $this->config->api_endpoint.'v1/flight_search');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            )
        );

        $result = curl_exec($ch);
        $data1 = json_decode($result);
//dd($data1);
        if(!empty($data1)){
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$this->config->api_endpoint.'v1/flight_search_results?uuid='.$data1->search_id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));
            $data = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

        }
        $main_array = json_decode($data);
        $this->load->model('FlightTarco/TrFlights_model', 'tm');
        $this->load->library('Hotels/Hotels_lib');
        foreach ($main_array as $item) {

            if(!empty($item->proposals)) {
                foreach ($item->proposals as $fligtdata) {

                    foreach ($fligtdata->terms as $getprice) {
                        $return_array = [];
                        foreach ($fligtdata->segment as $segment) {

                            $sub_array = array();
                            foreach ($segment->flight as $flights) {

                                $arrival_time = $flights->arrival_time;
                                $arrival_date = $flights->arrival_date;
                                $departure_date = $flights->departure_date;
                                $departure_time = $flights->departure_time;
                                $duration = $flights->duration;
                                $trip_class = $flights->trip_class;
                                $aircraft = $flights->aircraft;
                                $airline_name = $this->tm->get_airline_name($flights->operating_carrier);

                                $departure_code = $flights->departure;
                                $departure_airport = $this->tm->get_airport_name($departure_code);
                                $arrival_code = $flights->arrival;

                                $arrival_airport = $this->tm->get_airport_name($arrival_code);
                                $currency_code = $currencycode;

                                $hours = str_pad(floor($duration /60),2,"0",STR_PAD_LEFT);
                                $mins  = str_pad($duration %60,2,"0",STR_PAD_LEFT);

                                if((int)$hours > 24){
                                    $days = str_pad(floor($hours /24),2,"0",STR_PAD_LEFT);
                                    $hours = str_pad($hours %24,2,"0",STR_PAD_LEFT);
                                }
                                if(isset($days)) { $days = $days." Day[s] ";}

                                $check = true;
                                foreach ($this->airlines as $ar) {
                                    if ($ar->thumbnail == $airline_name->thumbnail) {
                                        $check = false;
                                        break;
                                    }
                                }
                                if ($check) {
                                    array_push($this->airlines, $airline_name);
                                }
                                $img_code = base_url("uploads/images/flights/airlines/$flights->operating_carrier.png");
                                $current_currency_price = $this->tm->currencyrate($getprice->currency);
                                $con_rate = $this->tm->currencyrate($currencycode);
                                $price_get = ceil($getprice->price /  $current_currency_price);
                                $price = ceil($price_get*$con_rate);
                                $max_stop = $getprice->max_stops;
                                $hidden_parameters = (object)[
                                    'departure_date'=>$departure_date,
                                    'price'=>$price,
                                    'currency_code'=>$currency_code,
                                    'url'=>$getprice->url,
                                    'form_city'=>$orgin,
                                    'to_city'=>$destination,
                                    'sign'=>$item->search_id

                                ];
                                $form = $this->hidden_parameters($hidden_parameters);
                                array_push($sub_array, (object)[
                                    "img_code" => $img_code,
                                    "departure_time" => $departure_time,
                                    "departure_date" => $departure_date,
                                    "arrival_date" => $arrival_date,
                                    "arrival_time" => $arrival_time,
                                    "departure_code" => $departure_code,
                                    "departure_airport" => $departure_airport,
                                    "arrival_code" => $arrival_code,
                                    "arrival_airport" => $arrival_airport,
                                    "duration_time" => $days.$hours.":".$mins,
                                    "currency_code" => $currency_code,
                                    "price" => $price,
                                    "url" =>$booking_link."/".$getprice->url,
                                    "airline_name" => $airline_name->name."".$aircraft,
                                    "booking_class" => $trip_class,
                                    "form" => $form,
                                    "form_name" => 'tpfbooking',
                                    "action" => '',
                                    "type" => "TravelPayoutflight",
                                ]);
                            }
                            $return_array["segments"][] = $sub_array;
                        }
                    }
                    array_push($this->final_array, $return_array);
                    $this->final_array = array_slice($this->final_array, 0, $this->limit);

                }
            }
        }
        if(!empty($this->final_array) && $price !='0') {
            echo json_encode($this->final_array);
        }else{
            $this->search_post();
        }
    }


    /*TravelPayoutsFlightApi Booking*/
    public function booking_post(){
        $user_id = 0;
        $departure_date = $this->post('departure_date');
        $price = $this->post('price');
        $currency_code = $this->post('currency_code');
        $url = $this->post('url');
        $form_city = $this->post('form_city');
        $to_city = $this->post('to_city');

        $data = array(
            'price'=>$price,
            'url'=>$url,
            'currency'=>$currency_code,
            'date'=>$departure_date,
            'user_id'=>$user_id,
            'form_city'=>$form_city,
            'to_city'=>$to_city
        );
        $this->TravelPayoutsFlights_model->travelpayoutflightapi_booking($data);
        echo json_encode(array("msg"=>$url ,'status'=>1));
    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input type="hidden" name="departure_date" value="'.$hidden_parameters->departure_date.'" />';
        $input .= '<input type="hidden" name="price" value="'.$hidden_parameters->price.'" />';
        $input .= '<input type="hidden" name="currency_code" value="'.$hidden_parameters->currency_code.'" />';
        $input .= '<input type="hidden" name="url" value="'.$hidden_parameters->sign."/".$hidden_parameters->url.'" />';
        $input .= '<input type="hidden" name="form_city" value="'.$hidden_parameters->form_city.'" />';
        $input .= '<input type="hidden" name="to_city" value="'.$hidden_parameters->to_city.'" />';
        return $input;
    }
}