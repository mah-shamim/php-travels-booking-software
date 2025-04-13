<?php


class FlightsListingModel
{

    public  $data;
    public  $airlines = [];
    public $mini_price;
    public $max_price;
    public $final_array = [];
    public $limit = 50;
    public $action_url;
    public $form_name;

    public function __construct($response="")
    {
        $this->data = $response;

        if(!empty($response))
        {
            $this->extract_data();
        }
    }
    function  extract_data()
    {
        $ci = get_instance();
        $ci->load->model('FlightTarco/TrFlights_model', 'tm');
        $ci->load->library('Hotels/Hotels_lib');
        $ci->load->library('TravelPayoutsFlightsAPI/FlightsSearchModel');
        $main_array = $this->data;
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
                                $duration_time = $flights->duration;
                                $duration = $fligtdata->total_duration;
                                $tripclass = $flights->trip_class;
                                $aircraft = $flights->aircraft;
                                $airline_name = $ci->tm->get_airline_name($flights->operating_carrier);
                                $sign = $fligtdata->sign;
                                $departure_code = $flights->departure;
                                $departure_airport = $ci->tm->get_airport_name($departure_code);
                                $arrival_code = $flights->arrival;

                                $arrival_airport = $ci->tm->get_airport_name($arrival_code);
                                $currency_code = $ci->Hotels_lib->currencycode;

                                //Segment Time Duraction
                                $hours = str_pad(floor($duration_time /60),2,"0",STR_PAD_LEFT);
                                $mins  = str_pad($duration_time %60,2,"0",STR_PAD_LEFT);

                                if((int)$hours > 24){
                                    $days = str_pad(floor($hours /24),2,"0",STR_PAD_LEFT);
                                    $hours = str_pad($hours %24,2,"0",STR_PAD_LEFT);
                                }
                                if(isset($days)) { $days = $days." Day[s] ";}

                                //Total time Duraction
                                $hour = str_pad(floor($duration /60),2,"0",STR_PAD_LEFT);
                                $min  = str_pad($duration %60,2,"0",STR_PAD_LEFT);

                                if((int)$hour > 24){
                                    $day = str_pad(floor($hour /24),2,"0",STR_PAD_LEFT);
                                    $hour = str_pad($hour %24,2,"0",STR_PAD_LEFT);
                                }
                                if(isset($day)) { $day = $day." Day[s] ";}

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

                                if($tripclass == 'C'){
                                    $trip_class="Business";
                                }else{
                                    $trip_class="Economy";
                                }
                                $img_code = base_url("uploads/images/flights/airlines/$flights->operating_carrier.png");
                                $current_currency_price = $ci->tm->currencyrate($getprice->currency);
                                $con_rate = $ci->tm->currencyrate($ci->Hotels_lib->currencycode);
                                if(!empty($getprice->price) && !empty($current_currency_price)) {
                                   $price_get = ceil($getprice->price / $current_currency_price);
                                }

                                $price = ceil($price_get * $con_rate);

                                $search = new FlightsSearchModel();
                                $hidden_parameters = (object)[
                                    'departure_date'=>$departure_date,
                                    'price'=>$price,
                                    'currency_code'=>$currency_code,
                                    'url'=>$getprice->url,
                                    'form_city'=>$search->origin,
                                    'to_city'=>$search->destination,
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
                                    "duration_time" => $day.$hour.":".$min,
                                    "segment_time" => $days.$hours.":".$mins,
                                    "currency_code" => $currency_code,
                                    "price" => $price,
                                    "url" =>$getprice->url,
                                    "airline_name" => $airline_name->name."".$aircraft,
                                    "booking_class" => $trip_class,
                                    "form" => $form,
                                ]);
                            }
                            $return_array["segments"][] = $sub_array;
                        }
                    }
                    array_push($this->final_array, $return_array);
                    $this->final_array = array_slice($this->final_array, 0, $this->limit);
                    $this->action_url ='';
                    $this->form_name ='tpfbooking';
                }
            }
            }
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