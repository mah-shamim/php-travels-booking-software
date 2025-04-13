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
        $main_array = $this->data;
        foreach ($main_array->data->solutions as $solution) {
            $return["segments"] = array();
            foreach ($main_array->data->flights as $item) {
                foreach ($solution->journeys as $key=>$journey){
                if ($item->flightId == $solution->journeys->$key[0]) {
                    $one_array = array();
                    $segments["segments"] = array();
                    foreach ($item->segmengtIds as $data) {
                        foreach ($main_array->data->segments as $flight) {
                            if ($flight->segmentId == $data) {
                                $arrival_time = $flight->strArrivalTime;
                                $arrival_date = $flight->strArrivalDate;
                                $departure_date = $flight->strDepartureDate;
                                $departure_time = $flight->strDepartureTime;
                                $tripclass = $flight->cabinClass;
                                $airline_name = $ci->tm->get_airline_name($flight->airline);
                                $departure_code = $flight->departure;
                                $departure_airport = $ci->tm->get_airport_name($departure_code);
                                $arrival_code = $flight->arrival;
                                $arrival_airport = $ci->tm->get_airport_name($arrival_code);
                                $currency_code = $ci->Hotels_lib->currencycode;
                                $check = true;

                                $price = round($solution->adtFare);

                                foreach ($this->airlines as $ar) {
                                    if ($ar->thumbnail == $airline_name->thumbnail) {
                                        $check = false;
                                        break;
                                    }
                                }
                                if ($check) {
                                    array_push($this->airlines, $airline_name);
                                }

                                $img_code = base_url("uploads/images/flights/airlines/$flight->airline.png");
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
                                    "price" => $price,
                                    "url" => '',
                                    "airline_name" => $airline_name->name,
                                    "booking_class" => $tripclass,
                                    "form" => '',
                                ];
                                array_push($one_array, $bj);
                            }
                        }
                    }

                    if($ci->uri->segment(5) == 'round'){
                        $return["segments"][] = $one_array;
                    }else{
                        $segments["segments"][] = $one_array;
                    }

                }
            }
        }
            if($ci->uri->segment(5) == 'round') {
                array_push($this->final_array, $return);
            }else{
                array_push($this->final_array, $segments);
            }
            $this->final_array = array_slice($this->final_array, 0, $this->limit);
            $this->action_url = '';
            $this->form_name = '';
        }
    }
}