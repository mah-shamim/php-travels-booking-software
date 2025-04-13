<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cache
{
    public static function read($response)
    {
        $response = file_get_contents(__DIR__."/Cache/Response/{$response}.json");
        return $response = json_decode($response);
    }

    public static function write($response, $resp)
    {
        file_put_contents(__DIR__."/Cache/Response/{$response}.json", $resp . PHP_EOL, LOCK_EX);
    }
}

/**
 * Token class
 *
 * https://developer.sabre.com/resources/getting_started_with_sabre_apis/sabre_apis_101/how_to_guides/rest_apis_token_credentials
 */
class Token {

    /**
     * API base url.
     */
    public $endpoint = 'https://api-crt.cert.havail.sabre.com/';

    /**
     * Always use the static value of V1, regardless of the version of authentication you are using.
     */
    public $version = "V1";

    /**
     * User ID (EPR).
     */
    public $userID = "";

    /**
     * Internet Pseudo City Code (IPCC)
     * Group (PCC)
     */
    public $IPCC = "";

    /**
     * "AA" for Travel Network customers, or your airline code for Airline Solutions customers, e.g. "LA". Separate each value with a colon.
     */
    public $domain = "AA";

    /**
     * Sabre APIs password.
     */
    public $password = "";


    public function __construct($configurations)
    {
        $this->userID = $configurations->apiConfig->user_id;
        $this->IPCC = $configurations->apiConfig->ipcc;
        $this->domain = $configurations->apiConfig->domain;
        $this->password = $configurations->apiConfig->password;

    }

    public function getHash()
    {
        $clientID = sprintf("%s:%s:%s:%s", $this->version, $this->userID, $this->IPCC, $this->domain);
        return base64_encode(base64_encode($clientID).":".base64_encode($this->password));
    }

    public function generate()
    {
        try
        {
            if (! empty($_SESSION['access_token'])) {
                $access_token = $_SESSION['access_token'];
                return (object) array(
                    'status' => 'success',
                    'access_token' => $access_token
                );
            }
            $this->endpoint = rtrim($this->endpoint, '/');
            // Init curl resource
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api-crt.cert.havail.sabre.com/v2/auth/token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Accept-Encoding: gzip, deflate",
                    "Authorization: Basic ".$this->getHash(),
                    "Cache-Control: no-cache",
                    "Connection: keep-alive",
                    "Content-Length: 0",
                    "Content-Type: application/x-www-form-urlencoded",
                    "Host: api-crt.cert.havail.sabre.com",
                    "Postman-Token: ef861496-7ebc-4882-aaa1-91dc56253a65,1cb757a1-06a4-42dc-a6fc-010f72002423",
                    "User-Agent: PostmanRuntime/7.19.0",
                    "cache-control: no-cache",
                    "grant_type: client_credentials"
                ),
            ));
            // send request.
            $resp = json_decode(curl_exec($curl));
            if (!curl_errno($curl)) {
                switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                    case 200:
                        $_SESSION['access_token'] = 'Bearer '.$resp->access_token;
                        $access_token = $_SESSION['access_token'];
                        return (object) array(
                            'status' => 'success',
                            'access_token' => $access_token
                        );
                        break;
                    default:
                        throw new Exception("Request failed!");
                }
            }
            // Close request to clear up some resources
            curl_close($curl);
        } catch (Exception $ex) {
            return array(
                'status' => 'fail',
                'data' => $resp,
                'error' => [
                    'message' => sprintf("Error while sending request, reason: %s\n",$ex->getMessage())
                ]
            );
        }
    }
}

class ServiceController {

    const Module = 'Sabre';

    /**
     * API mode.
     *
     * @var
     */
    public $sandboxMode = false;

    /**
     * Main api endpoint.
     *
     * @var
     */
    public $endpoint = 'https://api-crt.cert.havail.sabre.com/';

    /**
     * API bearer token.
     *
     * @var
     */
    public $access_token;


    public function __construct()
    {
        $configurations = app()->service("ModuleService")->get(self::Module);
        $token = new Token($configurations);
        if ($configurations->settings->mode == 'production') {
            $endpoint = 'https://api.havail.sabre.com/';
            $token->endpoint = $endpoint;
            $this->endpoint = $endpoint;
        }
        $response = $token->generate();
        $this->access_token = $response->access_token;
    }

    /**
     * Call to service.
     *
     * @return mix
     */
    public function service($service = NULL, $request = NULL, $data = NULL)
    {
        $requestType = get_class($request);
        $payload = json_encode([$service => $request]);
        if ($this->sandboxMode)
        {
            return (object) array(
                'status' => 'success',
                'data' => Cache::read($requestType)
            );
        }
        else
        {
            try
            {
                $this->endpoint = rtrim($this->endpoint, '/');
                // Get cURL resource
                $curl = curl_init();
                // Set some options
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $this->endpoint .'/'. $data['uri'],
                    CURLOPT_HTTPHEADER => [
                        'Accept: application/json',
                        'Authorization: '.$this->access_token,
                        'Content-Type: application/json'
                    ],
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => $payload
                ));

                // Send the request & save response to $resp
                $response = curl_exec($curl);
                // Close request to clear up some resources
                curl_close($curl);

                $resp = json_decode($response);
                if (empty($resp)) {
                    throw new Exception("Connection Error");
                } else if ($resp->status == 'Unknown' || $resp->status == 'NotProcessed' || $resp->status == 'Incomplete') {
                    throw new Exception($resp->message);
                } else {
                    Cache::write($requestType, $response);
                    return (object) array(
                        'status' => 'success',
                        'data' => $resp
                    );
                }
            } catch (Exception $ex) {
                exit(sprintf("Error while sending request, reason: %s\n", $ex->getMessage()));
            }
        }
    }
}
