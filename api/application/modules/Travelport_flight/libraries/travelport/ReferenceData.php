<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Travelport Reference Data decoder
 * Date: Aug 05, 2017
 */

class ReferenceData
{
    /**
     * Reference data path to Airline Equipment file
     *
     * @var String
     */
    const AIRLINE_EQUIPMENT = 'RAEQ.TXT';

    /**
     * Reference data path to Airline Carrier file
     *
     * @var String
     */
    const AIRLINE_CARRIER = 'RAIR.TXT';

    /**
     * Reference data path to Airline Carrier file
     *
     * @var String
     */
    const AIRPORT_DETAIL = 'RAPT.TXT';

    /**
     * Reference data path to City file
     *
     * @var String
     */
    const CITY_DETAIL = 'RCTY.TXT';

    /**
     * Reference data path to Country file
     *
     * @var String
     */
    const COUNTRY_DETAIL = 'RCNT.TXT';

    /**
     * Reference data path
     *
     * @var String
     */
    private $referenceDataPath = NULL;

    /**
     * Data Dumping
     *
     * @var boolean
     */
    const DD = FALSE;


    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();

        // Load travelport configurations
        $CI->config->load('travelport', TRUE);
        $confTravelport = $CI->config->item('travelport');
        
        $this->referenceDataPath = $confTravelport['REFERENCE_DATA'];
    }

    public function airline_equipment($equipment_code)
    {
        $file = $this->referenceDataPath . $this::AIRLINE_EQUIPMENT;

        $csv = file_get_contents($file);
        $content = array_map("str_getcsv", explode("\n", $csv));
        
        list($code, $fullname, $shortname) = current(array_filter($content, function($element) use($equipment_code){
			return isset($element[0]) && $element[0] == $equipment_code;
		}));

        return array(
            'code' => isset($code) ? $code : $equipment_code,
            'fullname' => $fullname,
            'shortname' => $shortname,
        );
    }

    public function airline_carrier($carrier_code)
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();
        
        // Load travelport configurations
        $CI->config->load('travelport', TRUE);
        $confTravelport = $CI->config->item('travelport');

        $file = $this->referenceDataPath . $this::AIRLINE_CARRIER;

        $csv = file_get_contents($file);
        $content = array_map("str_getcsv", explode("\n", $csv));
        
        list($code, $fullname, $shortname) = current(array_filter($content, function($element) use($carrier_code){
			return isset($element[0]) && $element[0] == $carrier_code;
		}));

        return array(
            'code' => isset($code) ? $code : $carrier_code,
            'fullname' => $fullname,
            'shortname' => $shortname,
            'image_path' => sprintf($confTravelport['AIRLINE_CARRIER_LOGO'], $code)
        );
    }

    public function airport_detail($airport_code)
    {
        $file = $this->referenceDataPath . $this::AIRPORT_DETAIL;

        $csv = file_get_contents($file);
        $content = array_map("str_getcsv", explode("\n", $csv));
        
        list($code, $dontknowField_1, $fullname, $countryCode, $stateCode) = current(array_filter($content, function($element) use($airport_code){
			return isset($element[0]) && $element[0] == $airport_code;
		}));

        return array(
            'code' => isset($code) ? $code : $airport_code,
            'fullname' => $fullname,
            'countryCode' => $countryCode,
            'stateCode' => $stateCode,
        );
    }

    public function json_airport_detail()
    {
        $file = $this->referenceDataPath . $this::AIRPORT_DETAIL;

        $csv = file_get_contents($file);
        $content = array_map("str_getcsv", explode("\n", $csv));

        $json_content = array();
        foreach($content as $line)
        {
            array_push($json_content, array(
                'code' => $line[0],
                'fullname' => $line[2],
                'countryCode' => $line[3],
                'stateCode' => $line[4],
            ));
        }

        $file = fopen(APPPATH."json/airports.json", "w");
        echo fwrite($file, json_encode($json_content));
        fclose($file);
    }

    /**
     * City/Airport code
     *
     * @return array
     */
    public function city_detail($city_code)
    {
        $file = $this->referenceDataPath . $this::CITY_DETAIL;

        $csv = file_get_contents($file);
        $content = array_map("str_getcsv", explode("\n", $csv));
        
        list($code, $dontknowField_1, $fullname, $countryCode, $stateCode) = current(array_filter($content, function($element) use($city_code){
			return isset($element[0]) && $element[0] == $city_code;
		}));

        return array(
            'code' => isset($code) ? $code : $city_code,
            'fullname' => $fullname,
            'countryCode' => $countryCode,
            'stateCode' => $stateCode,
        );
    }

    public function country_detail($country_code)
    {
        $file = $this->referenceDataPath . $this::COUNTRY_DETAIL;

        $csv = file_get_contents($file);
        $content = array_map("str_getcsv", explode("\n", $csv));
        
        list($code, $fullname, $currencyCode) = current(array_filter($content, function($element) use($country_code){
			return isset($element[0]) && $element[0] == $country_code;
		}));

        return array(
            'code' => isset($code) ? $code : $country_code,
            'fullname' => $fullname,
            'currencyCode' => $currencyCode,
        );
    }

}