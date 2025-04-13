<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Travelport Air Ticket Reservation
 * Date: Aug 19, 2017
 */
require_once 'ASoapClient.php';
require_once 'ReferenceData.php';

class Reservation extends ASoapClient
{
    /**
     * Data Dumping
     *
     * @var boolean
     */
    const DD = FALSE;

    private $AIRLINE_CARRIER_LOGO = NULL;

    private $ResponseMessage = NULL;

    private $BookingTraveler = NULL;

    private $ProviderReservationInfo = NULL;

    private $AirReservation = NULL;

    private $AirPricingInfo = NULL;

    private $AirSolutionChangedInfo = NULL;


    public function __construct($wsdl = NULL, $path = NULL)
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();

        // Load travelport configurations
        $CI->config->load('travelport', TRUE);
        $confTravelport = $CI->config->item('travelport');
        
        if (is_array($wsdl)) {
            list($wsdl, $path) = $wsdl;
        }

        if ($path == NULL) {
            $wsdlPath = $confTravelport['AIR_WSDL_AND_SCHEMA_PATH'] . $wsdl . '.wsdl';
        } else {
            $wsdlPath = $confTravelport[$path] . $wsdl . '.wsdl';
        }
        
        // Constructor
        parent::__construct($wsdlPath, $confTravelport);

        $this->AIRLINE_CARRIER_LOGO = $confTravelport['AIRLINE_CARRIER_LOGO'];
        $CI->load->library('travelport/ReferenceData');
    }

    public function service($parameters)
    {

        $response = $this->__soapCall('service', array("parameters" => $parameters));
        //dd($response);
        if (empty($response) && count($response) == 0) {
            throw new Exception("Travelport response cannot be null for final response");
        }

        if ($this::DD) { $this->__dd_rough($response); }


        if(property_exists($response, "ResponseMessage")) 
        {
            $this->ResponseMessage = $response->ResponseMessage;
        }

        if(property_exists($response, "UniversalRecord")) 
        {
            $this->UniversalRecord = $response->UniversalRecord;
        }
        
        if(property_exists($this->UniversalRecord, "BookingTraveler")) 
        {
            $this->BookingTraveler = $this->UniversalRecord->BookingTraveler;
            $this->BookingTraveler = is_object($this->BookingTraveler) ? array($this->BookingTraveler) : $this->BookingTraveler;
        }

        if(property_exists($this->UniversalRecord, "ProviderReservationInfo")) 
        {
            $this->ProviderReservationInfo = $this->UniversalRecord->ProviderReservationInfo;
        }

        if(property_exists($this->UniversalRecord, "AirReservation")) 
        {
            $this->AirReservation = $this->UniversalRecord->AirReservation;
        }

        if(property_exists($this->AirReservation, "AirPricingInfo")) 
        {
            $this->AirPricingInfo = $this->AirReservation->AirPricingInfo;
        }

        if(property_exists($response, "AirSolutionChangedInfo"))
        {
            $this->AirSolutionChangedInfo = $response->AirSolutionChangedInfo;
        }
        
        return $this->generate_response();
    }

    private function generate_response()
    {
        $final_response = new StdClass();
        $final_response->pnr = $this->UniversalRecord->LocatorCode;
        $final_response->responseMessage = $this->ResponseMessage;
        $final_response->bookingTraveler = $this->get_BookingTraveler();
        $final_response->inbound = new StdClass();
        $final_response->outbound = new StdClass();
        $final_response->inbound->segment = array();
        $final_response->outbound->segment = array();
        // $final_response->AirPricingSolution = $this->AirSolutionChangedInfo->AirPricingSolution;
        $final_response->aggregatePrice = $this->get_aggregatePrice($this->AirSolutionChangedInfo);
        
        $referenceData = new ReferenceData();
        $this_AirReservation_AirSegment = is_object($this->AirReservation->AirSegment) ? array($this->AirReservation->AirSegment) : $this->AirReservation->AirSegment;
        foreach($this_AirReservation_AirSegment as $AirSegment)
        {
            $segmentDetail = new StdClass();
            $carrier = (Object) $referenceData->airline_carrier($AirSegment->Carrier);
            $carrier->image_path = sprintf($this->AIRLINE_CARRIER_LOGO, $AirSegment->Carrier);
            $equipment = (Object) $referenceData->airline_equipment($AirSegment->Equipment);  
            $segmentDetail->carrier = $carrier;
            $segmentDetail->equipment = $equipment;
            $segmentDetail->totalDuration = $this->totalDuration($AirSegment->DepartureTime, $AirSegment->ArrivalTime);
            $AirSegment->detail = $segmentDetail;

            if ($AirSegment->Group) {
                array_push($final_response->inbound->segment, $AirSegment);
            } else {
                array_push($final_response->outbound->segment, $AirSegment);
            }
        }

        return $final_response;
    }

    private function get_aggregatePrice($AirSolutionChangedInfo)
    {
        $aggregate_price['base']['unit'] = NULL;
        $aggregate_price['base']['value'] = 0;
        $aggregate_price['taxes']['unit'] = NULL;
        $aggregate_price['taxes']['value'] = 0;
        $aggregate_price['total']['unit'] = NULL;
        $aggregate_price['total']['value'] = 0;
        
        $AirSolutionChangedInfo_AirPricingInfo = is_object($AirSolutionChangedInfo->AirPricingSolution->AirPricingInfo) ? array($AirSolutionChangedInfo->AirPricingSolution->AirPricingInfo) : $AirSolutionChangedInfo->AirPricingSolution->AirPricingInfo;
        if (! empty($AirSolutionChangedInfo_AirPricingInfo) )
        {
            foreach($AirSolutionChangedInfo_AirPricingInfo as $AirPricingInfo)
            {
                $ApproximateBasePrice = $this->parse_price_string($AirPricingInfo->ApproximateBasePrice);
                $Taxes = $this->parse_price_string($AirPricingInfo->Taxes);
                $TotalPrice = $this->parse_price_string($AirPricingInfo->TotalPrice);
                $passengerTypeCount = 1;
                if (is_array($AirPricingInfo->PassengerType)) {
                    $passengerTypeCount = count($AirPricingInfo->PassengerType);
                }
                $aggregate_price['base']['unit'] = $ApproximateBasePrice['unit'];
                $aggregate_price['base']['value'] += ($ApproximateBasePrice['value'] * $passengerTypeCount);

                $aggregate_price['taxes']['unit'] = $Taxes['unit'];
                $aggregate_price['taxes']['value'] += ($Taxes['value'] * $passengerTypeCount);

                $aggregate_price['total']['unit'] = $TotalPrice['unit'];
                $aggregate_price['total']['value'] += ($TotalPrice['value'] * $passengerTypeCount);
            }
        }

        return (Object) $aggregate_price;
    }

    private function get_BookingTraveler()
    {
        $booking_traveler = array();
        $shippingAddress = NULL;
        foreach($this->BookingTraveler as $BookingTraveler)
        {
            $traveler = new StdClass();
            $traveler->fullname = sprintf('%s %s %s', $BookingTraveler->BookingTravelerName->Prefix, $BookingTraveler->BookingTravelerName->First, $BookingTraveler->BookingTravelerName->Last);
            // Host only allows one Address/Delivery Address. Only one sent in request.
            if(property_exists($BookingTraveler, 'DeliveryInfo')) {
                if(property_exists($BookingTraveler->DeliveryInfo->ShippingAddress, 'Street')) {
                    $shippingAddress = sprintf('%s, POBOX %s, %s, %s', $BookingTraveler->DeliveryInfo->ShippingAddress->Street, $BookingTraveler->DeliveryInfo->ShippingAddress->PostalCode, $BookingTraveler->DeliveryInfo->ShippingAddress->City, $BookingTraveler->DeliveryInfo->ShippingAddress->Country);
                }
            }
            $phoneNumber = is_object($BookingTraveler->PhoneNumber) ? $BookingTraveler->PhoneNumber : current($BookingTraveler->PhoneNumber);
            // $traveler->phoneNumber = sprintf('%s (%s) %s', @$phoneNumber->CountryCode, @$phoneNumber->AreaCode, $phoneNumber->Number);
            $traveler->phoneNumber = $phoneNumber->Number;
            $traveler->email = $BookingTraveler->Email->EmailID;
            $traveler->providerLocator = $this->UniversalRecord->LocatorCode;

            array_push($booking_traveler, $traveler);
        }
        
        $booking_traveler['shippingAddress'] = $shippingAddress;
        return $booking_traveler;
    }

    private function totalDuration($departure_timezone, $arrival_timezone)
    {
        $origin_timezone_name = new DateTime($departure_timezone);
        $destination_timezone_name = new DateTime($arrival_timezone);
        $diff    = $origin_timezone_name->diff($destination_timezone_name);
        
        $totalDuration = array(
            'day' => $diff->format('%a'),
            'hour' => $diff->format('%H'),
            'minute' => $diff->format('%i'),
            'second' => $diff->format('%s'),
        );

        return (Object) $totalDuration;
    }

    /**
     * Timestamp with zone parser
     * href: href: https://stackoverflow.com/questions/18056543/parsing-a-datetime-string-with-timezone-in-php
     *
     * @return Array
     */
    private function parse_datetime($timezone_stamp)
    {
        $dateTimeObj = new DateTime($timezone_stamp);
        // $dateTimeObj_temp = (array) $dateTimeObj; // Unaccessable object property `timezone`, gives error dont know why, so have to typecast it.

        // $dateTimeObj = date_parse($timezone_stamp);
        // $timezone_name = timezone_name_from_abbr("", -1 * $dateTimeObj_temp['timezone'] * 60, false);

        return array(
            // 'datestring' => sprintf('%s-%s-%s', $dateTimeObj['year'], $dateTimeObj['month'], $dateTimeObj['day']),
            // 'timetring' => sprintf('%s:%s:%s', $dateTimeObj['hour'], $dateTimeObj['minute'], $dateTimeObj['second']),
            'date' => array(
                'year' => $dateTimeObj->format('Y'),
                'month' => $dateTimeObj->format('m'),
                'day' => $dateTimeObj->format('d'),
            ),
            'time' => array(
                'hour' => $dateTimeObj->format('H'),
                'minute' => $dateTimeObj->format('i'),
                'second' => $dateTimeObj->format('s'),
            ),
            'timezone_stamp' => $timezone_stamp,
            'timezone_name' => '',
        );
    }

    /**
     * Convert number of minutes to time
     * href: https://stackoverflow.com/questions/8563535/convert-number-of-minutes-into-hours-minutes-using-php
     *
     * @return Array
     */
    private function parse_minute_to_time($minutes)
    {
        $zero    = new DateTime('@0');
        $offset  = new DateTime('@' . $minutes * 60);
        $diff    = $zero->diff($offset);

        return $diff->format('%h Hours %i Minutes');
    }
    
    /**
     * Remove everything except [number] and [dot]
     * 
     * @return Array
     */
    private function parse_price($AirPricePoint)
    {
        $price_array = array();

        $price_array['totalprice_unit'] = preg_replace("/[^a-zA-Z]/", "", $AirPricePoint->TotalPrice);
        $price_array['totalprice_value'] = preg_replace("/[^0-9\.]/", "", $AirPricePoint->TotalPrice);

        return $price_array;
    }

    private function parse_price_string($price_string)
    {
        $price_array = array();

        $price_array['unit'] = preg_replace("/[^a-zA-Z]/", "", $price_string);
        $price_array['value'] = preg_replace("/[^0-9\.]/", "", $price_string);

        return $price_array;
    }
    
    /**
     * Parse Origin
     * 
     * @return Array
     */
    private function parse_origin($FlightOption)
    {
        $referenceData = new ReferenceData();
        $origin_array = array();

        $origin_array['airport'] = $referenceData->airport_detail($FlightOption->Origin);

        return $origin_array;
    }

    /**
     * Parse Destination
     * 
     * @return Array
     */
    private function parse_destination($FlightOption)
    {
        $referenceData = new ReferenceData();
        $destination_array = array();

        $destination_array['airport'] = $referenceData->airport_detail($FlightOption->Destination);

        return $destination_array;
    }
    
    /**
     * City detail against city code
     * 
     * @return Array
     */
    public function city_detail($city_code)
    {
        $referenceData = new ReferenceData();

        return $referenceData->city_detail($city_code);
    }

    /**
     * Country code against country detail
     * 
     * @return Array
     */
    public function country_detail($country_code)
    {
        $referenceData = new ReferenceData();

        return $referenceData->country_detail($country_code);
    }

    /**
     * Get single column from array of Objects or Arrays
     * 
     * @return Array
     */
    private function get_array_column($aDataObj, $columnToStrip)
    {
        $columnValues = array_map(function($e) use ($columnToStrip) {
            return is_object($e) ? $e->{$columnToStrip} : $e[$columnToStrip];
        }, $aDataObj);

        return $columnValues;
    }

    private function __dd_rough($response = NULL)
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);

        echo '<br>Data Dumping: Start</br>';

        echo "====== REQUEST FUNCTIONS =====" . PHP_EOL;
        var_dump($this->__getFunctions());

        echo "====== REQUEST HEADERS =====" . PHP_EOL;
        var_dump($this->__getLastRequestHeaders());

        echo "========= REQUEST ==========" . PHP_EOL;
        var_dump(htmlentities($this->__getLastRequest()));

        echo "========= FUNCTIONS =========" . PHP_EOL;
        var_dump($this->__getFunctions());

        echo "========= RESPONSE =========" . PHP_EOL;
        echo "<pre>";
        print_r($response);
        
        exit('<br>Data Dumping: End</br>');
    }
    
    private function __dd_json($response)
    {
        $CI =& get_instance();

        $CI->output->set_content_type('application/json');
        $CI->output->set_output(json_encode($response));
    }
}