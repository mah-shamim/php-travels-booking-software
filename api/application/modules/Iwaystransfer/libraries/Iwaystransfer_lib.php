<?php

class Iwaystransfer_lib
{
    function __construct()
    {
        $this->ci =& get_instance();
    }

    function index($param,$url)
    {
        //Get Code orgin from,to
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url."transnextgen/v1/places/find?lang=en&term=".$param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: d66af0b1-25d4-cff1-217d-78677dbc103f"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $getid_orign = json_decode($response);
            $orginplaceid = $getid_orign->result[0]->place_id;
        }


        //Orgin from get lat,long

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url."transnextgen/v1/places/".$orginplaceid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 5bd24e43-8ad8-e7f4-bd89-5e9199c7a263"
            ),
        ));

        $responselag = curl_exec($curl);
        $errlag = curl_error($curl);

        curl_close($curl);

        if ($errlag) {
            echo "cURL Error #:" . $err;
        } else {
            $resp = json_decode($responselag);
            $lag_log = $resp->result->geometry->location;

        }
       return $lag_log;
    }
}