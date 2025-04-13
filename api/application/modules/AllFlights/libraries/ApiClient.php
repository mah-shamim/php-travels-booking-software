<?php
class ApiClient
{


    public function __construct()
    {

    }

    /**
     * @param string $req_method
     * @param string $service
     * @param array $payload
     * @return mixed|string
     */
    public function sendRequest($req_method = 'GET', $service = '', $payload = [], $_headers = [])
    {
        $url = $payload['endpoint'];
        unset($payload['endpoint']);


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if ($req_method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            $url = $url."?".http_build_query($payload);
        }
        $headers[] = "cache-control: no-cache";
        if (! empty($headers) ) {
            $headers = array_merge($headers, $_headers);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_URL, $url);

        $response = curl_exec( $curl );
        $err      = curl_error( $curl );

        curl_close( $curl );

        if ( $err ) {
            $response = $err;
        }

        return $response;
    }
}