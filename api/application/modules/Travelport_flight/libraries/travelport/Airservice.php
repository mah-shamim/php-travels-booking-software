<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Travelport Air service
 * Date: Aug 03, 2017
 */
require_once 'ASoapClient.php';
require_once 'ReferenceData.php';

class Airservice extends ASoapClient
{
    /**
     * Data Dumping
     *
     * @var boolean
     */
    const DD = FALSE;

    private $AIRLINE_CARRIER_LOGO = NULL;

    private $airFlightDetailsList = NULL;

    private $airFareInfoList = NULL;

    private $airPricePoint = NULL;
    
    /**
	 * This integer define that how many element should be display in `flights in slider`.
	 * If the element count less then 5 then do not show display slider in view.
	 * The number should be 6 or greater.
	 *
	 * @var integer
	 */
    private $totalListingFound = 0;


    public function __construct($wsdl = NULL)
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();
        $CI->config->load('travelport', TRUE);
        $confTravelport = $CI->config->item('travelport');
        $wsdlPath = $confTravelport['AIR_WSDL_AND_SCHEMA_PATH'] . $wsdl . '.wsdl';
        
        // Constructor
        parent::__construct($wsdlPath);

        $this->AIRLINE_CARRIER_LOGO = $confTravelport['AIRLINE_CARRIER_LOGO'];
        $CI->load->library('travelport/ReferenceData');
    }

    public function service($parameters)
    {

        $response = $this->__soapCall('service', array("parameters" => $parameters));
        // Store response in session for next calls.
        $CI =& get_instance();
        $CI->session->set_userdata(array('travelportResp' => $response));

        $this->airFlightDetailsList = $response->FlightDetailsList;
        $this->airFareInfoList = $response->FareInfoList;
        
        $final_response = $this->final_response($response, $parameters);

        if ($this::DD) { $this->__dd_rough($response); }
        return $final_response;
    }

    private function final_response($response, $parameters)
    {
        if (empty($response) && count($response) == 0) {
            throw new Exception("Travelport response cannot be null for final response");
        }

        $phptravelDataStructure = array();
        $totalListingFoundTemp = array(); // For counting total listing, just for displaying on view
        
        foreach($response->AirPricePointList as $index => $AirPricePointArray)
        {
            $AirPricePointArray = is_object($AirPricePointArray) ? array($AirPricePointArray) : $AirPricePointArray;
            foreach($AirPricePointArray as $AirPricePoint)
            {
                $this->airPricePoint = $AirPricePoint;

                // new loop start
                $AirPricePoint_AirPricingInfo = is_object($AirPricePoint->AirPricingInfo) ? array($AirPricePoint->AirPricingInfo) : $AirPricePoint->AirPricingInfo;
                foreach($AirPricePoint_AirPricingInfo as $AirPricingInfo)
                {
                    $this->AirPricingInfo = $AirPricingInfo;
                    
                    $PlatingCarrier = 'carrier_'.hash('adler32', $AirPricingInfo->PlatingCarrier);
                    $TotalPriceHash = 'fare_'.hash('adler32', $AirPricePoint->TotalPrice);
                    $listboxkey = $PlatingCarrier.':'.$TotalPriceHash;

                    if ( ! in_array($PlatingCarrier, $phptravelDataStructure) ) {
                        $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash] = array();
                    }

                    if ( ! in_array($TotalPriceHash, $phptravelDataStructure[$PlatingCarrier]) ) {
                        $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash] = array();
                    }
                    
                    array_push($totalListingFoundTemp, $listboxkey);

                    // AirPricePoint: Carrier
                    // $phptravelDataStructure[$PlatingCarrier]['airports'] = array();

                    // AirPricePoint: Price
                    $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash]['price'] = $this->parse_price($AirPricePoint);
                    
                    $FlightOption = $AirPricingInfo->FlightOptionsList->FlightOption;
                    $FlightOptions = is_object($FlightOption) ? array($FlightOption) : $FlightOption;
                    foreach($FlightOptions as $index => $FlightOption)
                    {
                        // One Way or Round trip
                        $airlineTrip = $index; //$FlightOption->Origin.':'.$FlightOption->Destination;

                        // AirPricePoint: Origin
                        $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash][$airlineTrip]['origin'] = $this->parse_origin($FlightOption);

                        // AirPricePoint: Destination
                        $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash][$airlineTrip]['destination'] = $this->parse_destination($FlightOption);

                        // AirPricePoint: totalOptions
                        $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash][$airlineTrip]['flightItinerary']['totalOptions'] = is_object($FlightOption->Option) ? 1 : count($FlightOption->Option);
                        
                        $FlightOption_Option = is_object($FlightOption->Option) ? array($FlightOption->Option) : $FlightOption->Option;
                        foreach($FlightOption_Option as $OptionIndex => $Option)
                        {
                            // AirPricePoint: totalStops
                            $phptravelDataStructure[$PlatingCarrier][$TotalPriceHash][$airlineTrip]['flightItinerary']['totalStops'] = is_object($Option->BookingInfo) ? 0 : count($Option->BookingInfo) - 1;
                            
                            $path = array(); // Carrier path from origin to destination
                            $bookingInformation = array(); // Carrier path from origin to destination
                            $fareInformation = array(); // Flight booking fare information
                            
                            $Option_BookingInfo = is_object($Option->BookingInfo) ? array($Option->BookingInfo) : $Option->BookingInfo;
                            foreach($Option_BookingInfo as $BookingInfo)
                            {
                                array_push($path, $BookingInfo->SegmentRef);
                                $bookingInformation[$BookingInfo->SegmentRef] = array(
                                    'BookingCode' => $BookingInfo->BookingCode,
                                    'BookingCount' => $BookingInfo->BookingCount,
                                    'CabinClass' => $BookingInfo->CabinClass,
                                );
                                
                                $fareInformation[$BookingInfo->SegmentRef] = $this->parse_fareinfo($BookingInfo->FareInfoRef);
                            }

                            $pathFirstSegmentkey = current($path);
                            $pathLastSegmentkey = end($path);
                            
                            // Airsegment: Carrier
                            $this->parse_segment($phptravelDataStructure[$PlatingCarrier][$TotalPriceHash][$airlineTrip], $response, $pathFirstSegmentkey, $pathLastSegmentkey, $path, $OptionIndex, $bookingInformation, $fareInformation);
                        }
                    }

                } // new loop end
            }
        }

        $phptravelDataStructure['totalListingFound'] = count(array_unique($totalListingFoundTemp));

        return $phptravelDataStructure;
    }
    
    private function parse_segment_detail($flightdetail_key)
    {
        $this_airFlightDetailsList_FlightDetails = is_object($this->airFlightDetailsList->FlightDetails) ? array($this->airFlightDetailsList->FlightDetails) : $this->airFlightDetailsList->FlightDetails;
        $segment_detail = array_filter($this_airFlightDetailsList_FlightDetails, function($obj) use ($flightdetail_key) {
            return $obj->Key == $flightdetail_key;
        });

        return current($segment_detail);
    }

    private function parse_fareinfo($fareref_key)
    {
        $this->airFareInfoList->FareInfo = is_object($this->airFareInfoList->FareInfo) ? array($this->airFareInfoList->FareInfo) : $this->airFareInfoList->FareInfo;
        $segment_detail = array_filter($this->airFareInfoList->FareInfo, function($obj) use ($fareref_key) {
            return $obj->Key == $fareref_key;
        });
        
        // Just out baggage allowance information
        $fareInformation = current($segment_detail);
        
        $fareInformationObj = new StdClass();
        $fareInformationObj->BaggageAllowance = $fareInformation->BaggageAllowance;

        return $fareInformationObj;
    }

    /**
     * Parse Aircraft from segement and some other data
     * 
     * @return Array
     */
    private function parse_segment(&$phptravelDataStructure, $response, $pathFirstSegmentkey, $pathLastSegmentkey, $path, $OptionIndex, $bookingInformation, $fareInformation)
    {
        $referenceData = new ReferenceData();

        $firstSegmentkeySearching = TRUE;
        $lastSegmentkeySearching = TRUE;

        // All Key of the path array
        foreach ($path as $path_key)
        {
            $response_AirSegmentList_AirSegment = is_object($response->AirSegmentList->AirSegment) ? array($response->AirSegmentList->AirSegment) : $response->AirSegmentList->AirSegment;
            foreach ($response_AirSegmentList_AirSegment as $AirSegment)
            {
                // First Key
                if ($AirSegment->Key == $pathFirstSegmentkey && $firstSegmentkeySearching == TRUE)
                { 
                    $phptravelDataStructure['aircraft'] = array(
                        'carrier' => $referenceData->airline_carrier($AirSegment->Carrier),
                        'equipment' => $referenceData->airline_equipment($AirSegment->Equipment),
                        'image_path' => sprintf($this->AIRLINE_CARRIER_LOGO, $AirSegment->Carrier)
                    );

                    $phptravelDataStructure['origin']['departure'] = $this->parse_datetime($AirSegment->DepartureTime);
                    $firstSegmentkeySearching = FALSE; // Segment found
                }

                // Last Key
                if ($AirSegment->Key == $pathLastSegmentkey && $lastSegmentkeySearching == TRUE)
                {
                    $phptravelDataStructure['destination']['arrival'] = $this->parse_datetime($AirSegment->ArrivalTime);
                    $lastSegmentkeySearching = FALSE; // Segment found
                }
                
                if ($AirSegment->Key == $path_key)
                {
                    // Flight Itinerary
                    $phptravelDataStructure['flightItinerary']['segments'][$OptionIndex][] = array(
                        'key' => $AirSegment->Key,
                        'flightNumber' => $AirSegment->FlightNumber,
                        'group' => $AirSegment->Group,
                        'journeyTime' => $this->parse_minute_to_time($AirSegment->FlightTime),
                        'origin' => $referenceData->airport_detail($AirSegment->Origin),
                        'destination' => $referenceData->airport_detail($AirSegment->Destination),
                        'departureTime' => $this->parse_datetime($AirSegment->DepartureTime),
                        'arrivalTime' => $this->parse_datetime($AirSegment->ArrivalTime),
                        'aircraft' => array(
                            'carrier' => $referenceData->airline_carrier($AirSegment->Carrier),
                            'equipment' => $referenceData->airline_equipment($AirSegment->Equipment),
                            'image_path' => sprintf($this->AIRLINE_CARRIER_LOGO, $AirSegment->Carrier)
                        ),
                        'totalDuration' => $this->totalDuration($AirSegment->DepartureTime, $AirSegment->ArrivalTime),
                        'bookingInformation' => $bookingInformation[$AirSegment->Key],
                        'flightDetail' => $this->parse_segment_detail($AirSegment->FlightDetailsRef->Key),
                        'fareInformation' => $fareInformation[$AirSegment->Key],
                        'fareDetails' => array(
                            'basePrice' => $this->parse_price_string($this->airPricePoint->BasePrice),
                            'taxes' => $this->parse_price_string($this->airPricePoint->Taxes),
                            'totalPrice' => $this->parse_price_string($this->airPricePoint->TotalPrice),
                            'refundable' => @$this->AirPricingInfo->Refundable, // Some flight does not offer this attribute
                        )
                    );
                }     
            }  
        }
        
        // Trave Time Difference
        $phptravelDataStructure['totalDuration'] = $this->totalDuration(
            $phptravelDataStructure['origin']['departure']['timezone_stamp'],
            $phptravelDataStructure['destination']['arrival']['timezone_stamp']
        );
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

        return $totalDuration;
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
        // $timezone_name = timezone_name_from_abbr("", -1 * $dateTimeObj->getTimezone()->getName() * 60, false);

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

        $price_array['totalprice_unit'] = (string) preg_replace("/[^a-zA-Z]/", "", $AirPricePoint->TotalPrice);
        $price_array['totalprice_value'] = (int) preg_replace("/[^0-9\.]/", "", $AirPricePoint->TotalPrice);

        return $price_array;
    }

    private function parse_price_string($price_string)
    {
        $price_array = array();

        $price_array['unit'] = (string) preg_replace("/[^a-zA-Z]/", "", $price_string);
        $price_array['value'] = (int) preg_replace("/[^0-9\.]/", "", $price_string);

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

        echo "<pre>";

        echo '<br />Data Dumping: Start<br />';

        echo "<br />====== REQUEST FUNCTIONS =====<br />" . PHP_EOL;
        print_r($this->__getFunctions());

        echo "<br />====== REQUEST HEADERS =====<br />" . PHP_EOL;
        print_r($this->__getLastRequestHeaders());

        echo "<br />========= REQUEST XML ==========<br />" . PHP_EOL;
        print_r(htmlentities($this->__getLastRequest()));

        echo "<br />========= API RESPONSE =========<br />" . PHP_EOL;

        print_r($response);
        
        exit('<br />Data Dumping: End<br />');
    }
    
    private function __dd_json($response)
    {
        $CI =& get_instance();

        $CI->output->set_content_type('application/json');
        $CI->output->set_output(json_encode($response));
    }
}