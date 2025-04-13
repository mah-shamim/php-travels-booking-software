<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tripadvisor_lib {

     	public  $apiKey;
        public $apiurl;
        public $apistr;
        public $version;


	function __construct(){
       // $this->CI =& get_instance();
        //$this->CI->load->library('upload', $config);
        $this->ci = &get_instance();
        $this->ci->load->model('Admin/Settings_model');
        $configdata = $this->ci->Settings_model->get_front_settings("tripadvisor");
        $this->apiKey = $configdata[0]->apikey;
        $this->version = trim($configdata[0]->cid);
        if($configdata[0]->testing_mode == "0"){
         $this->apiurl = "https://api.tripadvisor.com/api/partner/".$this->version."/";
        }else{
         $this->apiurl = "https://api.tripadvisor.com/api/partner/".$this->version."/";
        }

	}



        /*
         * function for API call using curl
         */
	function apiCall($url){

    $ch = curl_init();
    $timeout = 3;
    curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt ($ch, CURLOPT_USERAGENT,
                 "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $rawdata = curl_exec($ch);
    curl_close($ch);
     @$json = json_decode($rawdata);
     return $json;

        }

        /*
         * funtion to get tripadvisor details by location attribute
         */
	function location($id){
           $str = $this->apiurl.'location/'.$id.'?key='.$this->apiKey;
            $this->apistr = $str;
            return $this->apiCall($str);
	}

}
