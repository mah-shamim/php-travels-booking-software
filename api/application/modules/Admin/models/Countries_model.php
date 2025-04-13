<?php

class Countries_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

		function countryDetails($countrySlug){
			$data = array();
			$countries = $this->get_all_countries();
			$result = new stdClass;
			$result->valid = FALSE;
			$countryName = strtolower(deUrlTitle($countrySlug));
			$locations = $this->countryLocations($countryName);
			$locationIDs = array();
			if(!empty($locations)){
				foreach($locations as $loc){
				$locationIDs[] = $loc->id;
				}

			}

			foreach($countries as $c){
				$data[$c->id] = strtolower($c->short_name);
			}

			if(in_array($countryName,$data)){
				$result->valid = TRUE;
				$result->countryName = $countryName;
				$result->countrySlug = $countrySlug;
				$result->locations = $locationIDs;

			}

			return $result;
		}

		function countryLocations($country){
			$this->db->where('country',$country);
			return $this->db->get('pt_locations')->result();
		}

		function getLocationID($locName = null){
			$locid = "";
			if(!empty($locName)){
			$this->db->where('location',$locName);
			$l = $this->db->get('pt_locations')->result();
			if(!empty($l)){
			$locid =	$l[0]->id;
			}
			}

			return $locid;
		}



// Get all countries
		function get_all_countries() {
				$countriesData = json_decode(file_get_contents("application/json/countries.json"));
				usort($countriesData, array($this, "sortByName"));
				return $countriesData;
		}

		function getCountryInfo($code){
			$name = $code;
			$countries = $this->get_all_countries();
			foreach($countries as $c){
				if($c->iso2 == $code){
					$name = $c->short_name;
					break;
				}
			}

			return $name;
		}

        // Get all countries
		function Api_all_countries() {

				/*$this->db->select('short_name as name,iso2 as code');
				$this->db->where('country_status', '1');
				$this->db->order_by('short_name', 'asc');
				$q = $this->db->get('pt_countries')->result();
				return $q;*/

				$countries = $this->get_all_countries();
				$apiCountries = array();
				foreach($countries as $c){
				$apiCountries[] = (object)array('name' => $c->short_name,'code' => $c->iso2);
				}
				return $apiCountries;
		}

		function sortByName($a, $b)
		{
		return strcmp($a->short_name, $b->short_name);
		}

}
