<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Travelport Air service
 * Date: Aug 03, 2017
 */
require_once 'ASoapClient.php';
require_once 'ReferenceData.php';

class Airprice extends ASoapClient
{
    /**
     * Data Dumping
     *
     * @var boolean
     */
    const DD = FALSE;

    private $AIRLINE_CARRIER_LOGO = NULL;

    private $ResponseMessage = NULL;

    private $AirSegment = NULL;

    private $AirPricingSolution = NULL;

    private $AirPricingInfo = NULL;

    private $BookingInfo = NULL;

    private $base_price = 0;

    private $total_price = 0;


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
        parent::__construct($wsdlPath);

        $this->AIRLINE_CARRIER_LOGO = $confTravelport['AIRLINE_CARRIER_LOGO'];
        $CI->load->library('travelport/ReferenceData');
    }

    public function service($parameters)
    {
        $parameters["AirPricingCommand"] = [
            "AirPricingModifiers" => [
                "FaresIndicator" => "AllFares"
            ]
        ];
        $response = $this->__soapCall('service', array("parameters" => $parameters));

        if (empty($response) && count($response) == 0) {
            throw new Exception("Travelport response cannot be null for final response");
        }
        
        $CI =& get_instance();
        $CI->session->set_userdata(array('travelportCartResp' => $response));
        
        if ($this::DD) { $this->__dd_rough($response); }
        
        // deep copy
        $clone_response = unserialize(serialize($response));
        //dd( $clone_response->AirPriceResult->AirPricingSolution);
        $this->ResponseMessage = $clone_response->ResponseMessage;
        $this->AirSegment = $clone_response->AirItinerary->AirSegment;
        $this->AirPricingInfo = $clone_response->AirPriceResult->AirPricingSolution->AirPricingInfo;
        // $this->BookingInfo = $clone_response->AirPriceResult->AirPricingSolution->AirPricingInfo->BookingInfo;
        $this->AirPricingSolution = $clone_response->AirPriceResult->AirPricingSolution;
        // $this->base_price = $this->parse_price_string($clone_response->AirPriceResult->AirPricingSolution->ApproximateBasePrice);
        // $this->total_price = $this->parse_price_string($clone_response->AirPriceResult->AirPricingSolution->TotalPrice);

        $travelportCheckoutResp = $this->generate_response();
        $CI->session->set_userdata(array('travelportCheckoutResp' => $travelportCheckoutResp));
        
        return $travelportCheckoutResp;
    }

    private function generate_response()
    {
        $final_response = new StdClass();
        // $final_response->base_price = $this->base_price;
        // $final_response->total_price = $this->total_price;
        $final_response->inbound = new StdClass();
        $final_response->outbound = new StdClass();
        $final_response->inbound->segment = array();
        $final_response->outbound->segment = array();
        
        $this->AirPricingInfo = is_object($this->AirPricingInfo) ? array($this->AirPricingInfo) : $this->AirPricingInfo;
        //dd( $this->AirPricingInfo);
        $duplicateEntry = array();
        foreach($this->AirPricingInfo as $AirPricingInfo)
        {
            $AirPricingInfo_BookingInfo = is_object($AirPricingInfo->BookingInfo) ? array($AirPricingInfo->BookingInfo) : $AirPricingInfo->BookingInfo;
            foreach($AirPricingInfo_BookingInfo as $BookingInfo)
            {
                if ( ! in_array($BookingInfo->SegmentRef, $duplicateEntry) )
                {
                    $this_AirSegment = is_object($this->AirSegment) ? array($this->AirSegment) : $this->AirSegment;
                    $segment = (Object) current(array_filter($this_AirSegment, function(&$AirSegment) use($BookingInfo) {
                        if ($AirSegment->Key == $BookingInfo->SegmentRef)
                        {
                            $referenceData = new ReferenceData();
                            $segmentDetail = new StdClass();

                            $carrier = (Object) $referenceData->airline_carrier($AirSegment->Carrier);
                            $carrier->image_path = sprintf($this->AIRLINE_CARRIER_LOGO, $AirSegment->Carrier);

                            $equipment = (Object) $referenceData->airline_equipment($AirSegment->Equipment);
                            
                            $segmentDetail->carrier = $carrier;
                            $segmentDetail->equipment = $equipment;
                            $segmentDetail->bookingInfo = $BookingInfo;
                            $segmentDetail->totalDuration = $this->totalDuration($AirSegment->DepartureTime, $AirSegment->ArrivalTime);

                            $AirSegment->detail = $segmentDetail;

                            return TRUE;
                        }
                    }));

                    if ($segment->Group) {
                        array_push($final_response->inbound->segment, $segment);
                    } else {
                        array_push($final_response->outbound->segment, $segment);
                    }

                    array_push($duplicateEntry, $BookingInfo->SegmentRef);
                }
            }
        }
        
        $final_response->airPricingSolution = (Object) array(
            "Key" => $this->AirPricingSolution->Key,
            "CompleteItinerary" => $this->AirPricingSolution->CompleteItinerary,
            "QuoteDate" => $this->AirPricingSolution->QuoteDate,
            "TotalPrice" => $this->AirPricingSolution->TotalPrice,
            "BasePrice" => $this->AirPricingSolution->BasePrice,
            "ApproximateTotalPrice" => $this->AirPricingSolution->ApproximateTotalPrice,
            "ApproximateBasePrice" => $this->AirPricingSolution->ApproximateBasePrice,
            "EquivalentBasePrice" => @$this->AirPricingSolution->EquivalentBasePrice, // For some type of trips this attribute come missing
            "Taxes" => $this->AirPricingSolution->Taxes,
            "Fees" => $this->AirPricingSolution->Fees,
            "ApproximateTaxes" => $this->AirPricingSolution->ApproximateTaxes,                        
        );

        return $final_response;
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