<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cartrawler_lib {  

	public $apiUrl = "";
	
	public function __construct(){
		$this->apiUrl = "//phptravels.com.co/api/locations.php";

	}

	public function getLocations($query = null){
		return file_get_contents('http://phptravels.com.co/api/locations.php?query=' . $query);
		// $url = $this->apiUrl."?query=$query";
		// echo curlCall($url);
	}

	public function timingList(){
  $start = "00:00";
$end = "23:59";
$timeArray = array();

$tStart = strtotime($start);
$tEnd = strtotime($end);
$tNow = $tStart;

while($tNow <= $tEnd){
  $timeArray[] = date("H:i",$tNow);
  $tNow = strtotime('+30 minutes',$tNow);
} 

return $timeArray;


	}

}






