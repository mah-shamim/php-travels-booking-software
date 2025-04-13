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
    public $itineraries = array();


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
        $main_array = $this->data;

            $ci->load->library('Model/Response/AirLowFareSearchRsp');
            $responseParser = new AirLowFareSearchRsp();
            $responseParser->customFare = new CustomFare(); //$customFare;
            $outboundSegment = $responseParser->parse($main_array->data);

            foreach ($outboundSegment->itineraries as $flightdata) {
                $sub_array = array();
                $return_array = [];
                foreach ($flightdata->outbound->segments as $data) {

                $price = $flightdata->priceDetail->totalFare->Amount;
                $currency_code = $flightdata->priceDetail->totalFare->CurrencyCode;
                $duration_time = '';
                $departure_time = $data->departure->time;
                $arrival_time = $data->arrival->time;
                $departure_date = $data->departure->date;
                $arrival_date = $data->arrival->date;
                $class_type = '';
                $airline_name = $ci->tm->get_airline_name($data->airline->code);
                $departure_airport = '';
                $arrival_airport = '';
                $departure_code = $data->departure->airport->code;
                $arrival_code = $data->arrival->airport->code;
                $segment_time =  '';
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
                $img_code = base_url("uploads/images/flights/airlines/".$data->airline->code.".png");


                    $form = $this->hidden_parameters($flightdata);

                    array_push($sub_array,(object)[
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
                    "segment_time" => $segment_time,
                    "currency_code" => $currency_code,
                    "price" => round($price),
                    "airline_name" => $airline_name->name,
                    "booking_class" => $class_type,
                    "form" =>$form,
                ]);

            }
            $return_array["segments"][] = $sub_array;

            array_push($this->final_array,$return_array);
        }


        $this->final_array = array_slice($this->final_array, 0, $this->limit);
        $this->action_url = site_url('airway/checkout');


    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input type="hidden" name="itinerarie" value="'.htmlentities(json_encode($hidden_parameters)).'" />';
        return $input;

    }
}