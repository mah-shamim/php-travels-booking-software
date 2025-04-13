<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
require_once APPPATH . 'modules/Travelport_flight/libraries/travelport/ReferenceData.php';

class Suggession extends MX_Controller {
    
    private $access = TRUE;

    function __construct() 
    {
        // Construct our parent class
        parent :: __construct();

        $this->output->set_content_type('application/json');

        $mobile = mobileSettings("apiKey");
        $user_api_key = $mobile->apiKey;
        $api_Key = $this->input->get('appKey');
        
        if( $user_api_key != $api_Key)
        {
            // Output the data
            $this->output->set_output(json_encode([
                'status' => 'fail',
                'message' => 'Invalid App Key'
            ]));
            
            // Display the data and exit execution
            $this->output->_display();
            exit;
        }
    }

    public function airports()
    {
        $query = $this->input->get('q');
        
        $file = APPPATH . "json/airports.json";
        $myfile = fopen($file, "r");
        $file_content = fread($myfile, filesize($file));
        fclose($myfile);
        
        $file_content = json_decode($file_content);
        $filterd_contents = array_filter($file_content, function($airport) use ($query) {
            return preg_match('/'.strtolower($query).'/', strtolower(sprintf('%s %s', $airport->fullname, $airport->code)));
        });
        
        $final_response = array();
        foreach($filterd_contents as $filterd_content) 
        {
            array_push($final_response, array(
                'id' => $filterd_content->code, 
                'text'=> sprintf('%s - (%s)', $filterd_content->fullname, $filterd_content->code),
                'countryCode' => $filterd_content->countryCode
            ));
        }

        $this->output->set_output(json_encode(array(
            'response' => $final_response
        )));
    }
}