<?php


class AmadeusResponse
{

    public  $data;
    public  $airlines = [];
    public $mini_price;
    public $max_price;
    public $final_array = [];
    public $action_url;




    public function __construct($response="")
    {
        $this->data = json_decode($response);
        if(!empty($response))
        {
            $this->extract_data();
        }
    }
    function  extract_data()
    {
        $ci = get_instance();
        $ci->load->model('FlightTarco/TrFlights_model','tm');
        $ci->load->library('Hotels/Hotels_lib');
        $ci->load->library('Amadeus/FlightsSearchModel');
        $main_array = $this->data->flight_data->data;
        foreach ($main_array as $item)
        {
            foreach ($item->offerItems as $offerItems)
            {
                $return_array = [];
                foreach ($offerItems->services as $service)
                {
                    $sub_array = array();
                    foreach ($service->segments as $segment){

                        $flightSegment = $segment->flightSegment;

                        $arr_date = date_create($flightSegment->departure->at);
                        $arr_date = date_format($arr_date,"d/m/Y h:i:A");

                        $dep_date = date_create($flightSegment->arrival->at);
                        $dep_date = date_format($dep_date,"d/m/Y h:i:A");
                        $airline_name = $ci->tm->get_airline_name($flightSegment->carrierCode);
                        $check = true;
                        foreach ($this->airlines as $ar)
                        {
                            if($ar->thumbnail == $airline_name->thumbnail){
                                $check = false;
                                break;
                            }
                        }
                        if($check)
                        {
                            array_push($this->airlines,$airline_name);
                        }
                        $img_code = base_url("uploads/images/flights/airlines/$flightSegment->carrierCode.png");


                        $departure_time = $this->parseDate($dep_date)[1];
                        $departure_date = $this->parseDate($dep_date)[0];
                        $arrival_date = $this->parseDate($arr_date)[0];
                        $arrival_time = $this->parseDate($arr_date)[1];

                        $departure_code = $flightSegment->departure->iataCode;
                        $departure_airport = $ci->tm->get_airport_name($departure_code);
                        $arrival_code = $flightSegment->arrival->iataCode;
                        $arrival_airport = $ci->tm->get_airport_name($arrival_code);

                        $duration_time = $flightSegment->duration;
                        $currency_code = $ci->Hotels_lib->currencycode;
                        $current_currency_price = $ci->tm->currencyrate($ci->Hotels_lib->currencycode);
                        $price = ceil($offerItems->price->total * $current_currency_price);

                        if($price > $this->max_price)
                        {
                            $this->max_price = $price;
                        }
                        if($price > $this->mini_price)
                        {
                            $this->mini_price = $price;
                        }
                        $class_type = $this->data->class_type;


                        $data = new FlightsSearchModel();

                        $hidden_parameters = (object)[
                            'carrier_code'=>$flightSegment->carrierCode,
                            'iataCode_departure'=>$departure_code,
                            'iataCode_arrival'=>$arrival_code,
                            'departure_at'=>$flightSegment->departure->at,
                            'arrival_at'=>$flightSegment->arrival->at,
                            'travelclass'=>$segment->pricingDetailPerAdult->travelClass,
                            'seats'=>$segment->pricingDetailPerAdult->availability,
                            'totalpassengers'=>$data->adults + $data->children + $data->infants,
                            'madult'=>$data->adults,
                            'pricePerAdulttotal'=>calculate_commission($offerItems->pricePerAdult->total,$data->commission),
                            'pricePerAdulttotalTaxes'=>$offerItems->pricePerAdult->totalTaxes,
                            'mchildren'=>$data->children,
                            'pricePerChildtotal'=>calculate_commission($offerItems->pricePerChild->total,$data->commission),
                            'pricePerChildtotalTaxes'=>$offerItems->pricePerChild->totalTaxes,
                            'minfant'=>$data->infants,
                            'pricePerInfanttotal'=>calculate_commission($offerItems->pricePerInfant->total,$data->commission),
                            'pricePerInfanttotalTaxes'=>$offerItems->pricePerInfant->totalTaxes,
                            'seniors'=>intval(0),
                            'currency'=>$ci->session->userdata("currencycode"),
                            'currencysymbol'=>$ci->session->userdata("currencysymbol"),
                            'total_with_commission'=>calculate_commission($offerItems->price->total,$data->commission),
                            'total'=>$offerItems->price->total,
                            'totalTaxes'=>$offerItems->price->totalTaxes,
                            'pricePerSeniortotal'=>'',
                            'pricePerSeniortotalTaxes'=>'',

                        ];

                        $form = $this->hidden_parameters($hidden_parameters);
                        array_push($sub_array,(object)[
                            "img_code"=>$img_code,
                            "departure_time"=>$departure_time,
                            "departure_date"=>$departure_date,
                            "arrival_date"=>$arrival_date,
                            "arrival_time"=>$arrival_time,
                            "departure_code"=>$departure_code,
                            "departure_airport"=>$departure_airport,
                            "arrival_code"=>$arrival_code,
                            "arrival_airport"=>$arrival_airport,
                            "duration_time"=>$duration_time,
                            "currency_code"=>$currency_code,
                            "price"=>$price,
                            "airline_name"=>$airline_name->name,
                            "booking_class"=>$class_type,
                            "form"=>$form
                        ]);
                    }
                    $return_array["segments"][]= $sub_array;
                }
            }
           array_push($this->final_array,$return_array);
            $this->action_url = site_url("airlines/booking");

        }
    }
    public function parseDate($dataString)
    {
        $dataArray = explode(' ', $dataString);

        return $dataArray;
    }

    public function hidden_parameters($hidden_parameters){
        $input = '';
        $input .= '<input type="hidden" name="carrier_code[]" value="'.$hidden_parameters->carrier_code.'" />';
        $input .= '<input type="hidden" name="iataCode_departure[]" value="'.$hidden_parameters->iataCode_departure.'" />';
        $input .= '<input type="hidden" name="iataCode_arrival[]" value="'.$hidden_parameters->iataCode_arrival.'" />';
        $input .= '<input type="hidden" name="departure_at[]" value="'.$hidden_parameters->departure_at.'" />';
        $input .= '<input type="hidden" name="arrival_at[]" value="'.$hidden_parameters->arrival_at.'" />';
        $input .= '<input type="hidden" name="travelclass[]" value="'.$hidden_parameters->travelclass.'" />';
        $input .= '<input type="hidden" name="seats[]" value="'.$hidden_parameters->seats.'" />';
        $input .= '<input type="hidden" name="totalpassengers" value="'.$hidden_parameters->totalpassengers.'" />';
        $input .= '<input type="hidden" name="madult" value="'.$hidden_parameters->madult.'" />';
        if(!empty($hidden_parameters->pricePerAdulttotal)){
            $input .= '<input type="hidden" name="pricePerAdult[total]" value="'.$hidden_parameters->pricePerAdulttotal.'" />';
            $input .= '<input type="hidden" name="pricePerAdult[totalTaxes]" value="'.$hidden_parameters->pricePerAdulttotalTaxes.'" />';
        }
        $input .= '<input type="hidden" name="mchildren" value="'.$hidden_parameters->mchildren.'" />';
        if(!empty($hidden_parameters->pricePerChildtotal)){
            $input .= '<input type="hidden" name="pricePerChild[total]" value="'.$hidden_parameters->pricePerChildtotal.'" />';
            $input .= '<input type="hidden" name="pricePerChild[totalTaxes]" value="'.$hidden_parameters->pricePerChildtotalTaxes.'" />';
        }
        $input .= '<input type="hidden" name="minfant" value="'.$hidden_parameters->minfant.'" />';
        if(!empty($hidden_parameters->pricePerInfanttotal)){
            $input .= '<input type="hidden" name="pricePerInfant[total]" value="'.$hidden_parameters->pricePerInfanttotal.'" />';
            $input .= '<input type="hidden" name="pricePerInfant[totalTaxes]" value="'.$hidden_parameters->pricePerInfanttotalTaxes.'" />';
        }
        $input .= '<input type="hidden" name="seniors" value="'.$hidden_parameters->seniors.'" />';
        if(!empty($hidden_parameters->pricePerSeniortotal)){
            $input .= '<input type="hidden" name="pricePerSenior[total]" value="'.$hidden_parameters->pricePerSeniortotal.'" />';
            $input .= '<input type="hidden" name="pricePerSenior[totalTaxes]" value="'.$hidden_parameters->pricePerSeniortotalTaxes.'" />';
        }
        $input .= '<input type="hidden" name="currency" value="'.$hidden_parameters->currency.'" />';
        $input .= '<input type="hidden" name="currencysymbol" value="'.$hidden_parameters->currencysymbol.'" />';
        $input .= '<input type="hidden" name="total_with_commission" value="'.$hidden_parameters->total_with_commission.'" />';
        $input .= '<input type="hidden" name="total" value="'.$hidden_parameters->total.'" />';
        $input .= '<input type="hidden" name="totalTaxes" value="'.$hidden_parameters->totalTaxes.'" />';
        $input .= '<input type="hidden" name="flight_offers" value="Book Now" />';
        return $input;
    }

}