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
        $main_array = $this->data;
        foreach ($main_array as $mainindex=>$item) {
            $convert_array = (json_decode(json_encode($main_array),true));
            foreach ($convert_array[$mainindex] as $key=>$getdata) {
                $dataflight = (json_decode(json_encode($convert_array[$mainindex][$key]),true)['0']['flightItinerary']);
                foreach ($dataflight['segments']as $flightindex=>$items){
                    $sub_array = array();
                    $return_array = [];
                    foreach ($items as $idexflight=>$flight){
                            $flightdata = (object)$flight;
                            $price = $flightdata->fareDetails['totalPrice']['value'];
                            $currency_code = $flightdata->fareDetails['totalPrice']['unit'];
                            $duration_time = $getdata['0']['totalDuration']['day'] ."d".$getdata['0']['totalDuration']['hour'] ."h". $getdata['0']['totalDuration']['minute'] ."m";
                            $departure_time = $flightdata->departureTime['time']['hour'].":".$flightdata->departureTime['time']['minute'];
                            $arrival_time = $flightdata->arrivalTime['time']['hour'].":".$flightdata->arrivalTime['time']['minute'];
                            $departure_date = $flightdata->departureTime['date']['day']."-".$flightdata->departureTime['date']['month']."-".$flightdata->departureTime['date']['year'];
                            $arrival_date = $flightdata->arrivalTime['date']['day']."-".$flightdata->arrivalTime['date']['month']."-".$flightdata->arrivalTime['date']['year'];
                            $class_type = $flightdata->bookingInformation['CabinClass'];
                            $airline_name =$ci->tm->get_airline_name($flightdata->aircraft['carrier']['code']);
                            $departure_airport = $flightdata->origin['code'];
                            $arrival_airport = $flightdata->destination['code'];
                            $departure_code = $flightdata->origin['fullname'];
                            $arrival_code = $flightdata->destination['fullname'];
                            $segment_time =  $flightdata->journeyTime;
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
                            $img_code = base_url("uploads/images/flights/airlines/".$flightdata->aircraft['carrier']['code'].".png");

                        if(!empty(json_decode(json_encode($convert_array[$mainindex][$key]),true)['1']['flightItinerary'])) {
                            $dataflightreturn = json_decode(json_encode($convert_array[$mainindex][$key]), true)['1']['flightItinerary'];
                            foreach ($dataflightreturn['segments'] as $returnflightindex => $return_items) {
                                $hidden_parameters = (object)[
                                    'outbound' => implode(',', array_column($items, 'key')),
                                    'inbound' => implode(',', array_column($return_items, 'key')),
                                ];
                            }
                        }else{
                            $hidden_parameters = (object)[
                                'outbound' => implode(',', array_column($items, 'key')),
                            ];
                        }
                        $form = $this->hidden_parameters($hidden_parameters);

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
                                "price" => $price,
                                "airline_name" => $airline_name->name,
                                "booking_class" => $class_type,
                                "form" => $form,
                            ]);
                        }

                    $return_array["segments"][] = $sub_array;

                    if(!empty(json_decode(json_encode($convert_array[$mainindex][$key]),true)['1']['flightItinerary']))
                    {
                         $dataflightreturn =  json_decode(json_encode($convert_array[$mainindex][$key]),true)['1']['flightItinerary'];

                        foreach ($dataflightreturn['segments']as $returnflightindex=>$return_items) {
                            if($returnflightindex != 0)
                            {
                                $return_array = [];
                                $return_array["segments"][] = $sub_array;
                            }else{

                            }
                            $return_sub_array = array();
                            foreach ($return_items as $returnidexflight => $returnflight) {
                                $returnflightdata = (object)$returnflight;
                                $price = $returnflightdata->fareDetails['totalPrice']['value'];
                                $currency_code = $returnflightdata->fareDetails['totalPrice']['unit'];
                                $duration_time = $returnflightdata->totalDuration['day'] . "d" . $returnflightdata->totalDuration['hour'] . "h" . $returnflightdata->totalDuration['minute'] . "m";
                                $departure_time = $returnflightdata->departureTime['time']['hour'] . ":" . $returnflightdata->departureTime['time']['minute'];
                                $arrival_time = $returnflightdata->arrivalTime['time']['hour'] . ":" . $returnflightdata->arrivalTime['time']['minute'];
                                $departure_date = $returnflightdata->departureTime['date']['day'] . "-" . $returnflightdata->departureTime['date']['month'] . "-" . $returnflightdata->departureTime['date']['year'];
                                $arrival_date = $returnflightdata->arrivalTime['date']['day'] . "-" . $returnflightdata->arrivalTime['date']['month'] . "-" . $returnflightdata->arrivalTime['date']['year'];
                                $class_type = $returnflightdata->bookingInformation['CabinClass'];
                                $airline_name = $ci->tm->get_airline_name($flightdata->aircraft['carrier']['code']);
                                $departure_airport = $returnflightdata->origin['code'];
                                $arrival_airport = $returnflightdata->destination['code'];
                                $departure_code = $returnflightdata->origin['fullname'];
                                $arrival_code = $returnflightdata->destination['fullname'];
                                $segment_time =  $returnflightdata->journeyTime;
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
                                $img_code = base_url("uploads/images/flights/airlines/" . $flightdata->aircraft['carrier']['code'] . ".png");

                                array_push($return_sub_array, (object)[
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
                                    "price" => $price,
                                    "airline_name" => $airline_name->name,
                                    "booking_class" => $class_type,
                                    "form" => '',
                                ]);
                            }
                            $return_array["segments"][] = $return_sub_array;


                        }
                    }
                }

            }
            array_push($this->final_array,$return_array);

        }

        $this->final_array = array_slice($this->final_array, 0, $this->limit);
        $this->action_url = site_url('flight/cart/checkout');
    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input type="hidden" name="outbound" value="'.$hidden_parameters->outbound.'" />';
        $input .= '<input type="hidden" name="inbound" value="'.$hidden_parameters->inbound.'" />';
        return $input;
    }
}