<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');
        if (!function_exists('getBackTourTranslation')) {

		function getBackTourTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('Tours/Tours_model');
          $res = $CI->Tours_model->getBackTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

} if (!function_exists('getBackRoomTranslation')) {

		function getBackRoomTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('Hotels/Rooms_model');
          $res = $CI->Rooms_model->getBackTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

}if (!function_exists('GetRoomQuantity')) {

		function GetRoomQuantity($id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('Hotels/Rooms_model');
          $res = $CI->Rooms_model->getRoomQuantity($id);
          return $res;
		  }else{
            return '0';
		  }

		}

}if (!function_exists('getTypesTranslation')) {

		function getTypesTranslation($lang, $id) {
		  if(!empty($id)){
          $CI = get_instance();
          $CI->load->model('Tours/Tours_model');
          $res = $CI->Tours_model->getTypesTranslation($lang,$id);
          return $res;
		  }else{
            return '';
		  }

		}

}if (!function_exists('isTourLocation')) {

		function isTourLocation($i, $locid, $tourid) {
		  if(!empty($locid)){

          $CI = get_instance();
          $CI->load->model('Tours/Tours_model');
          $res = $CI->Tours_model->isTourLocation($i, $locid, $tourid);

          if($res > 0){

          	return $res;

          }else{

          	return $res;
          }
          
		  
		  }else{
            return FALSE;
		  }

		}

}