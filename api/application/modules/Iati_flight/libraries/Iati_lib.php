<?php

class Iati_lib {

    

    protected $testapi_url;

    protected $api_url;

    protected $authCode;



    public function __construct(){

        $this->testapi_url = "http://testapi.iati.com/rest/";

        $this->api_url = "https://api.iati.com/rest/";

        $this->authCode = app()->service("ModuleService")->get("iati_flight")->apiConfig->authCode;

    }



    public function getSearchResults($params){

        // echo "<pre>";print_r($params);exit();

        $flights = $this->testapi_url."flightSearch/";

        return $this->post($flights, $params);

    }



    public function getMakeTicket($params){

        // echo "<pre>";print_r($params);exit();
        
        $flights = $this->testapi_url."makeDummyTicket/"; // replace endpoint with `makeTicket` when live.

        return $this->post($flights, $params);

    }



    public function getPriceDetail($params){

        // echo "<pre>";print_r($params);exit();

        $flights = $this->testapi_url."priceDetail/";

        return $this->post($flights, $params);

    }



    public function get($url){

        $url = $url.$this->authCode."/";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);

    }



    public function post($url, $params){

        $url = $url.$this->authCode."/";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

            'Accept-Encoding: gzip,deflate',

            'Accept: application/json;charset=UTF-8',

            'Content-Type: application/json'

            ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);

    }



}   