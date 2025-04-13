<?php


class FlightsListingModel
{

    public $data;
    public $airlines = [];
    public $mini_price;
    public $max_price;
    public $final_array = [];
    public $limit = 50;
    public $action_url;
    public $form_name;


    public function __construct($response = "")
    {
        $this->data = $response;

        if (!empty($response)) {
            $this->extract_data();
        }
    }

    function extract_data()
    {
        $ci = get_instance();
        $ci->load->model('FlightTarco/TrFlights_model', 'tm');
        $ci->load->model('Flights/FlightsSearchModel');
        $ci->load->library('Flights/Flights_lib');
        $ci->load->library('Hotels/Hotels_lib');
        $main_array = $this->data;
        //dd($main_array);
        $one_array = array();
        foreach ($main_array as $mainindex=>$item) {
            $segments["segments"] = array();
            $bookpayload = [];
            if(!empty($ci->session->userdata("currencycode"))){
                $currency_code = $ci->session->userdata("currencycode");
            }else{
                $currency_code = $ci->Hotels_lib->currencycode;
            }
                $departure_time = $item->time_departure;
                $duration_time = $item->total_hours;
                $arrival_time = $item->time_arrival;
                $departure_date = $item->date_departure;
                $arrival_date = $item->date_arrival;
                $class_type = $item->flight_type;
                $departure_code = '';
                $arrival_code = '';
                $departure_airport = $item->from_code;
                $arrival_airport = $item->to_code;
                $img = str_replace(".png","",$item->thumbnail);
                $airline_name = $ci->tm->get_airline_name($img);
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
                $img_code = base_url("uploads/images/flights/airlines/$img.png");

                $data = new FlightsSearchModel();

            $args = explode('/',  $ci->uri->uri_string());
            unset($args[0]);
            unset($args[1]);
            $segments = array_merge($args);
            $data->parseUriString($segments);
            $ci->session->set_userdata('Flights',serialize($data));


                $price = $ci->Flights_lib->convertAmount(
                ($item->adults_price * $data->adults) +
                ($item->infants_price * $data->children) +
                ($item->child_price * $data->infant));

            $hidden_parameters = (object)[
                'tripType'=>$data->tripType,
                'setting_id'=>$item->setting_id,
                'adults'=>$data->adults,
                'children'=>$data->children,
                'infant'=>$data->infant,
            ];

            $form = $this->hidden_parameters($hidden_parameters);
                $bj =  (object)[
                    "img_code" => $img_code,
                    "departure_time" => $departure_time,
                    "departure_date" => $departure_date,
                    "arrival_date" => $arrival_date,
                    "arrival_time" => $arrival_time,
                    "departure_code" => $departure_code,
                    "departure_airport" => $departure_airport,
                    "arrival_code" => $arrival_code,
                    "arrival_airport" => $arrival_airport,
                    "duration_time" => $duration_time,
                    "currency_code" => $currency_code,
                    "price" => $price,
                    "airline_name" => $airline_name->name,
                    "booking_class" => $class_type,
                    "form" => $form,
                ];
            $segments["segments"][][] = $bj;
            array_push($this->final_array, $segments);
        }
        $this->final_array = array_slice($this->final_array, 0, $this->limit);
        $this->action_url = site_url('flights/book');
    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input name="tripType" type="hidden"  value="'.$hidden_parameters->tripType.'" />';
        $input .= '<input name="setting_id" type="hidden"  value="'.$hidden_parameters->setting_id.'" />';
        $input .= '<input name="adults" type="hidden"  value="'.$hidden_parameters->adults.'" />';
        $input .= '<input name="children" type="hidden"  value="'.$hidden_parameters->children.'" />';
        $input .= '<input name="infant" type="hidden"  value="'.$hidden_parameters->infant.'" />';
        return $input;

    }

}