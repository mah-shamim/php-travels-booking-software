<?php 
require __DIR__.'/Messages/BaseModel.php';
require __DIR__.'/Messages/CommonClasses.php';
require __DIR__.'/Messages/HotelSearch.php';
require __DIR__.'/Messages/HotelDetails.php';
require __DIR__.'/Messages/HotelMediaLinks.php';
require __DIR__.'/Messages/HotelReservation.php';

class HotelApiClient 
{
    public $requestXML   = __DIR__.'/wsdl_and_schema/hotel_v42_0/Request.wsdl';
    public $client;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->model('TravelportHotelModel_Conf');
        $Configuration = new TravelportHotelModel_Conf();
        $Configuration->load();
        $this->apiUrl = $Configuration->get_api_endpoint();
        $this->publicKey = $Configuration->get_api_username();
        $this->secretKey = $Configuration->get_api_password();
        $this->targetBranch = $Configuration->get_branch_code();
    }

    public function callApi($requestPayload, $cache = FALSE)
    {
        $serviceName = get_class($requestPayload);
        if($cache) {
            return $this->readFromCache($serviceName);
        }
        // $this->prepareSerivceWSDLForRequest($serviceName);
        if($serviceName == 'HotelSearch') {
            $this->requestXML = __DIR__.'/wsdl_and_schema/hotel_v42_0/HotelSearch.wsdl';
        } else if($serviceName == 'HotelDetails') {
            $this->requestXML = __DIR__.'/wsdl_and_schema/hotel_v42_0/HotelDetails.wsdl';
        } else if($serviceName == 'HotelReservation') {
            $this->requestXML = __DIR__.'/wsdl_and_schema/universal_v42_0/HotelReservation.wsdl';
        } else if($serviceName == 'HotelMediaLinks') {
            $this->requestXML = __DIR__.'/wsdl_and_schema/hotel_v42_0/HotelMediaLinks.wsdl';
        }
        $this->client = new SoapClient($this->requestXML, array(
            'soap_version' => 'SOAP_1_2',
            'encoding' => 'UTF-8',
            'exceptions' => true,
            'stream_context' => stream_context_create(array(
                'http' => array(
                    'header' => array(
                        'Content-Type: text/xml; charset=UTF-8',
                        'Accept-Encoding: gzip, deflate',
                        'SOAPAction: ""'
                    )),
                'ssl' => array(
                    'ciphers' => 'AES256-SHA',
                    'verify_peer' => false,
                    'verify_peer_name' => false
                )
            )),
            'trace' => true,
            'login' => $this->publicKey,
            'password' => $this->secretKey
        ));
        try {
            $result = $this->client->__soapCall("service", [
                'parameters' => $requestPayload
            ]);
            $this->cacheReqRsp($result, $requestPayload, $serviceName);
            return $result;
        } catch(SoapFault $e) {
            throw new Exception("SOAP Fault: (faultcode: {$e->faultcode}, faultstring: {$e->faultstring})");
            // trigger_error("SOAP Fault: (faultcode: {$e->faultcode}, faultstring: {$e->faultstring})", E_USER_ERROR);
        }
    }

    public function prepareSerivceWSDLForRequest($requestService)
    {
        if(strpos($requestService, 'Reservation') !== false) {
            $this->requestXML = str_replace('hotel_v42_0', 'universal_v42_0', $this->requestXML);
        }
        $request = simplexml_load_file($this->requestXML);
        $request->binding->attributes()['name'] = sprintf('%sServiceBinding', $requestService);
        $request->binding->attributes()['type'] = sprintf('tns:%sServicePortType', $requestService);
        $request->service->port->attributes()['name'] = sprintf('%sServicePort', $requestService);
        $request->service->port->attributes()['binding'] = sprintf('tns:%sServiceBinding', $requestService);
        $request->saveXML($this->requestXML);
    }

    public function getAmenities()
    {
		$xml = file_get_contents(__DIR__.'/StaticContent/Amenities.xml');
        // SimpleXML seems to have problems with the colon ":" in the <xxx:yyy> response tags, so take them out
        $xml    = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
        $xml    = simplexml_load_string($xml);
        $json   = json_encode($xml);
        $resp   = json_decode($json, true);
        $amenities = array();
        foreach($resp['SOAPBody']['utilReferenceDataRetrieveRsp']['utilReferenceDataItem'] as $item)
        {
            if($item['@attributes']['Deprecated'] == 'false')
            {
                array_push($amenities, (object) array(
                    'code' => $item['@attributes']['Code'],
                    // 'Name' => $item['@attributes']['Name'],
                    'description' => $item['@attributes']['Description'],
                    // 'utilAdditionalInfo' => $item['utilAdditionalInfo'],
                    'facilityGroupCode' => ($item['utilAdditionalInfo'] == 'Hotel Amenity') ? 'HA' : 'RA'
                ));
            }
        }
        return $amenities;
    }
    
    public function cacheReqRsp($result, $requestPayload, $serviceName)
    {
        $f = fopen(__DIR__.'/ReqRsp/'.$serviceName.'Req.json', 'w');
        fwrite($f, json_encode($requestPayload));
        fclose($f);
        $f = fopen(__DIR__.'/ReqRsp/'.$serviceName.'Rsp.json', 'w');
        fwrite($f, json_encode($result));
        fclose($f);
    }

    public function readFromCache($serviceName)
    {
        $file = __DIR__.'/ReqRsp/'.$serviceName.'Rsp.json';
        $f = fopen($file, 'r');
        $response = json_decode(fread($f, filesize($file)));
        fclose($f);
        return $response;
    }

    public function getFunctions()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        echo '<pre>';
        print_r(htmlentities($this->client->__getFunctions()));
        echo '</pre>';
    }

    public function getLastRequest()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        echo '<pre>';
        var_dump(htmlentities($this->client->__getLastRequest()));
        echo '</pre>';
    }

    public function getLastRequestHeaders()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        echo '<pre>';
        print_r(htmlentities($this->client->__getLastRequestHeaders()));
        echo '</pre>';
    }
}
