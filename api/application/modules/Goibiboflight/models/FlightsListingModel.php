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
        $ci->load->library('Goibiboflight/FlightsSearchModel');
        $main_array = $this->data;
        //dd($main_array);
        foreach ($main_array->data->onwardflights as $flight){
            $one_array = array();
            $return_array = [];
            $arrival_time = $flight->arrtime;
            $arrival_date = date('Y-m-d', strtotime($flight->arrdate));
            $departure_date = date('Y-m-d', strtotime($flight->depdate));
            $departure_time = $flight->deptime;
            $tripclass = $flight->seatingclass;
            $duration = $flight->duration;
            $airline_name = $ci->tm->get_airline_name($flight->carrierid);
            $departure_code = $flight->origin;
            $departure_airport = $ci->tm->get_airport_name($departure_code);
            $arrival_code = $flight->destination;
            $arrival_airport = $ci->tm->get_airport_name($arrival_code);
            $currency_code = $ci->Hotels_lib->currencycode;
            $check = true;

            $price = $flight->fare->totalfare;
            foreach ($this->airlines as $ar) {
                if ($ar->thumbnail == $airline_name->thumbnail) {
                    $check = false;
                    break;
                }
            }
            if ($check) {
                array_push($this->airlines, $airline_name);
            }

            $current_currency_price = $ci->tm->currencyrate('INR');
            $con_rate = $ci->tm->currencyrate($ci->Hotels_lib->currencycode);
            if(!empty($price) && !empty($current_currency_price)) {
                $price_get = ceil($price/ $current_currency_price);
            }

            $prices = ceil($price_get * $con_rate);

            $img_code = base_url("uploads/images/flights/airlines/$flight->carrierid.png");

            $data = new FlightsSearchModel();

            if(!empty($ci->session->userdata("currencycode"))){
                $curr_code = $ci->session->userdata("currencycode");
            }else{
                $curr_code = $ci->Hotels_lib->currencycode;

            }

            if(!empty($ci->session->userdata("currencysymbol"))){
                $curr_sign = $ci->session->userdata("currencysymbol");
            }else{
                $curr_sign = $ci->Hotels_lib->currencysign;

            }
            $hidden_parameters = (object)[
                'carrier_code'=>$flight->carrierid,
                'iataCode_departure'=>$departure_code,
                'iataCode_arrival'=>$arrival_code,
                'departure_at'=>$departure_date,
                'departure_time'=>$departure_time,
                'arrival_at'=>$arrival_date,
                'arrival_time'=>$arrival_time,
                'duration_time'=>$duration,
                'travelclass'=>$tripclass,
                'totalpassengers'=>$data->adults + $data->children + $data->infants,
                'madult'=>$data->adults,
                'minfant'=>$data->infants,
                'currency'=>$curr_code,
                'currencysymbol'=>$curr_sign,
                'total'=>$prices
            ];

            $form = $this->hidden_parameters($hidden_parameters);

            $bj = (object)[
                "img_code" => $img_code,
                "departure_time" => $departure_time,
                "departure_date" => $departure_date,
                "arrival_date" => $arrival_date,
                "arrival_time" => $arrival_time,
                "departure_code" => $departure_code,
                "departure_airport" => $departure_airport,
                "arrival_code" => $arrival_code,
                "arrival_airport" => $arrival_airport,
                "duration_time" => $duration,
                "segment_time" => '',
                "currency_code" => $currency_code,
                "price" => $prices,
                "url" => '',
                "airline_name" => $airline_name->name,
                "booking_class" => $tripclass,
                "form" => $form,
            ];
            array_push($one_array, $bj);
            $return_array["segments"][] = $one_array;

            if(!empty($main_array->data->returnflights)){
                foreach ($main_array->data->returnflights as $flights) {
                    $array = array();
                    $return_array = [];
                    $return_array["segments"][] = $one_array;
                    $arrival_time = $flights->arrtime;
                    $arrival_date = date('Y-m-d', strtotime($flights->arrdate));
                    $departure_date = date('Y-m-d', strtotime($flights->depdate));
                    $departure_time = $flights->deptime;
                    $tripclass = $flights->seatingclass;
                    $airline_name = $ci->tm->get_airline_name($flights->carrierid);
                    $departure_code = $flights->origin;
                    $departure_airport = $ci->tm->get_airport_name($departure_code);
                    $arrival_code = $flights->destination;
                    $arrival_airport = $ci->tm->get_airport_name($arrival_code);
                    $currency_code = $ci->Hotels_lib->currencycode;
                    $check = true;

                    $price = $flights->fare->totalfare;

                    foreach ($this->airlines as $ar) {
                        if ($ar->thumbnail == $airline_name->thumbnail) {
                            $check = false;
                            break;
                        }
                    }
                    if ($check) {
                        array_push($this->airlines, $airline_name);
                    }

                    $current_currency_price = $ci->tm->currencyrate('INR');
                    $con_rate = $ci->tm->currencyrate($ci->Hotels_lib->currencycode);
                    if(!empty($price) && !empty($current_currency_price)) {
                        $price_get = ceil($price/ $current_currency_price);
                    }

                    $prices = ceil($price_get * $con_rate);
                    $img_code = base_url("uploads/images/flights/airlines/$flights->carrierid.png");
                    $bj = (object)[
                        "img_code" => $img_code,
                        "departure_time" => $departure_time,
                        "departure_date" => $departure_date,
                        "arrival_date" => $arrival_date,
                        "arrival_time" => $arrival_time,
                        "departure_code" => $departure_code,
                        "departure_airport" => $departure_airport,
                        "arrival_code" => $arrival_code,
                        "arrival_airport" => $arrival_airport,
                        "duration_time" => '',
                        "segment_time" => '',
                        "currency_code" => $currency_code,
                        "price" => $prices,
                        "url" => '',
                        "airline_name" => $airline_name->name,
                        "booking_class" => $tripclass,
                        "form" => '',
                    ];
                    array_push($array, $bj);
                    $return_array["segments"][] = $array;
                }

            }
            array_push($this->final_array, $return_array);

        }



        $this->final_array = array_slice($this->final_array, 0, $this->limit);
        $this->action_url = site_url("goibiboflight/booking");;
        $this->form_name = '';
    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input type="hidden" name="carrier_code[]" value="'.$hidden_parameters->carrier_code.'" />';
        $input .= '<input type="hidden" name="iataCode_departure[]" value="'.$hidden_parameters->iataCode_departure.'" />';
        $input .= '<input type="hidden" name="iataCode_arrival[]" value="'.$hidden_parameters->iataCode_arrival.'" />';
        $input .= '<input type="hidden" name="departure_at[]" value="'.$hidden_parameters->departure_at.'" />';
        $input .= '<input type="hidden" name="departure_time[]" value="'.$hidden_parameters->departure_time.'" />';
        $input .= '<input type="hidden" name="arrival_at[]" value="'.$hidden_parameters->arrival_at.'" />';
        $input .= '<input type="hidden" name="arrival_time[]" value="'.$hidden_parameters->arrival_time.'" />';
        $input .= '<input type="hidden" name="travelclass[]" value="'.$hidden_parameters->travelclass.'" />';
        $input .= '<input type="hidden" name="durationtime[]" value="'.$hidden_parameters->duration_time.'" />';
        $input .= '<input type="hidden" name="madult" value="'.$hidden_parameters->madult.'" />';
        $input .= '<input type="hidden" name="mchildren" value="'.$hidden_parameters->mchildren.'" />';
        $input .= '<input type="hidden" name="minfant" value="'.$hidden_parameters->minfant.'" />';
        $input .= '<input type="hidden" name="currency" value="'.$hidden_parameters->currency.'" />';
        $input .= '<input type="hidden" name="currencysymbol" value="'.$hidden_parameters->currencysymbol.'" />';
        $input .= '<input type="hidden" name="total" value="'.$hidden_parameters->total.'" />';
        $input .= '<input type="hidden" name="goflight_offers" value="Book Now" />';
        return $input;
    }
}