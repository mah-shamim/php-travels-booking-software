<?php 

class Tax
{
    public $currencyCode;
    public $amount = 0;
}

class AdministrationFee
{
    public $currencyCode;
    public $amount = 0;
}

class CustomFare
{
    public $tax;
    public $administrationFee;

    public function __construct()
    {
        $this->tax = new Tax();
        $this->administrationFee = new AdministrationFee();
    }
}

class Taxes
{
    public $total;
    public $summary;

    public function __construct($airItineraryPricingInfo)
    {
        $this->total = array_sum(array_column($airItineraryPricingInfo->ItinTotalFare->Taxes->Tax, 'Amount'));
        $this->summary = $airItineraryPricingInfo->ItinTotalFare->Taxes->Tax;
    }
}

class DetailPrice
{
    public $baseFare;
    public $taxes;
    public $totalFare;

    public function __construct($airItineraryPricingInfo)
    {
        $this->baseFare = $airItineraryPricingInfo->ItinTotalFare->BaseFare;
        $this->taxes = new Taxes($airItineraryPricingInfo);
        $this->totalFare = $airItineraryPricingInfo->ItinTotalFare->TotalFare;
    }
}

class Helper 
{
    public static function dd($data)
    {
        echo '<pre>'; print_r($data); die();
    }

    public static function getAirEquipType($segment)
    {
        return $segment->Equipment[0]->AirEquipType;
    }

    public static function getTerminalID($object)
    {
        if (property_exists($object, 'TerminalID')) {
            return $object->TerminalID;
        }
        return '';
    }
}

class AirLowFareSearchRsp
{
    public $customFare;
    public $itineraries = array();
    public $filters = array(
        'airlines' => array()
    );

    public function __construct()
    {
        // Administratin and Regional fee
    }

    public function parse($data)
    {
        foreach ($data->OTA_AirLowFareSearchRS->PricedItineraries->PricedItinerary as $itinerary)
        {
            $outbound = $this->parseOutbound($itinerary);
            $inbound = $this->parseInbound($itinerary);
            $priceDetail = $this->parsePriceDetail($itinerary);
            $priceDetail->customFare = $this->customFare;

            array_push($this->itineraries, array(
                'flightType' => $itinerary->AirItinerary->DirectionInd,
                'outbound' => $outbound,
                'inbound' => $inbound,
                'priceDetail' => $priceDetail,
            ));
        }
        $this->itineraries = json_decode(json_encode($this->itineraries));
        $this->filters['airlines'] = (object) array_map("unserialize", array_unique(array_map("serialize", $this->filters['airlines'])));
        $this->filters = (object) $this->filters;
        return $this;
    }

    public function parseOutbound($itinerary)
    {
        $outbound['totalStops'] = 0;
        $outbound['segments'] = array();
        $outboundSegment = $itinerary->AirItinerary->OriginDestinationOptions->OriginDestinationOption[0];
        foreach ($outboundSegment->FlightSegment as $segment) {
            $outbound['totalStops'] = (count($outboundSegment->FlightSegment) - 1);
            $segmentArray = array(
                'flightNumber' => $segment->FlightNumber,
                'marriageGrp' => $segment->MarriageGrp,
                'departure' => array(
                    'date' => date('Y-m-d', strtotime($segment->DepartureDateTime)),
                    'time' => date('H:i', strtotime($segment->DepartureDateTime)),
                    'airport' => array(
                        'code' => $segment->DepartureAirport->LocationCode,
                        'terminal' => Helper::getTerminalID($segment->DepartureAirport),
                    )
                ),
                'arrival' => array(
                    'date' => date('Y-m-d', strtotime($segment->ArrivalDateTime)),
                    'time' => date('H:i', strtotime($segment->ArrivalDateTime)),
                    'airport' => array(
                        'code' => $segment->ArrivalAirport->LocationCode,
                        'terminal' => Helper::getTerminalID($segment->ArrivalAirport),
                    )
                ),
                'airline' => array(
                    'code' => $segment->OperatingAirline->Code,
                    'image' => base_url("uploads/images/flights/airlines/".$segment->OperatingAirline->Code.".png")
                ),
                'equipment' => array(
                    'type' => Helper::getAirEquipType($segment)
                )
            );
            array_push($outbound['segments'], $segmentArray);
            array_push($this->filters['airlines'], (object) $segmentArray['airline']);
        }
        return $outbound;
    }

    public function parseInbound($itinerary)
    {
        $inbound['totalStops'] = 0;
        $inbound['segments'] = array();
        if ($itinerary->AirItinerary->DirectionInd == 'Return') {
            $inboundSegment = $itinerary->AirItinerary->OriginDestinationOptions->OriginDestinationOption[1];
            foreach ($inboundSegment->FlightSegment as $segment) {
                $inbound['totalStops'] = (count($inboundSegment->FlightSegment) - 1);
                $segmentArray = array(
                    'flightNumber' => $segment->FlightNumber,
                    'marriageGrp' => $segment->MarriageGrp,
                    'departure' => array(
                        'date' => date('Y-m-d', strtotime($segment->DepartureDateTime)),
                        'time' => date('H:i', strtotime($segment->DepartureDateTime)),
                        'airport' => array(
                            'code' => $segment->DepartureAirport->LocationCode,
                            'terminal' => Helper::getTerminalID($segment->DepartureAirport),
                        )
                    ),
                    'arrival' => array(
                        'date' => date('Y-m-d', strtotime($segment->ArrivalDateTime)),
                        'time' => date('H:i', strtotime($segment->ArrivalDateTime)),
                        'airport' => array(
                            'code' => $segment->ArrivalAirport->LocationCode,
                            'terminal' => Helper::getTerminalID($segment->ArrivalAirport),
                        )
                    ),
                    'airline' => array(
                        'code' => $segment->OperatingAirline->Code,
                        'image' => base_url("uploads/images/flights/airlines/".$segment->OperatingAirline->Code.".png")
                    ),
                    'equipment' => array(
                        'type' => Helper::getAirEquipType($segment)
                    )
                );
                array_push($inbound['segments'], $segmentArray);
                array_push($this->filters['airlines'], (object) $segmentArray['airline']);
            }
        }
        return $inbound;
    }

    public function parsePriceDetail($itinerary)
    {
        $airItineraryPricingInfo = $itinerary->AirItineraryPricingInfo[0];
        return new DetailPrice($airItineraryPricingInfo);
    }
}
