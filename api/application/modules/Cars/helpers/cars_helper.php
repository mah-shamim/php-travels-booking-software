<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');
        if (!function_exists('getBackCarTranslation')) {

		function getBackCarTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('Cars/Cars_model');
          $res = $CI->Cars_model->getBackTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

} if (!function_exists('getTypesTranslation')) {

		function getTypesTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('Cars/Cars_model');
          $res = $CI->Cars_model->getTypesTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

}if (!function_exists('carLocationsInfo')) {

		function carLocationsInfo($i, $locid, $carid, $type) {
		  if(!empty($locid)){
          $CI = get_instance();
          $CI->load->model('Cars/Cars_model');
          $res = $CI->Cars_model->carLocationsInfo($i, $locid, $carid,$type);

          return $res;
          
		  
		  }else{

            return FALSE;
		  }

		}

}