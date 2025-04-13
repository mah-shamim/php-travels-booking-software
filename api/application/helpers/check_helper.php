<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');
if (!function_exists('pt_room_adv_dates')) {

		function pt_room_adv_dates($start, $end) {
				$dates = array();
				while ($start <= $end) {
						array_push($dates, $start);
						$start += 86400;
				}
				return $dates;
		}

}if (!function_exists('pt_dates_between')) {

		function pt_dates_between($start, $end) {
				$dates = array();
				while ($start < $end) {
						array_push($dates, date("Y-m-d",$start));
						$start += 86400;
				}
				return $dates;
		}

}if (!function_exists('pt_dates_betweenn')) {

		function pt_dates_betweenn($start, $end) {
				$dates = array();
				$ss = convert_to_unix($start);
				$ee = convert_to_unix($end);
				while ($ss <= $ee) {
						$ss += 86400;
						array_push($dates, $ss);
				}
				return $dates;
		}


}

if (!function_exists('pt_in_dates')) {

		function pt_in_dates($from, $to, $checkDate) {
				$upperBound = $to;
				$lowerBound = $from;
				if ($lowerBound < $upperBound) {
						$between = $lowerBound <= $checkDate && $checkDate <= $upperBound;
				}
				else {
						$between = $checkDate <= $upperBound || $checkDate >= $lowerBound;
				}
				return $between;
		}

}if (!function_exists('pt_is_room_booked')) {

		function pt_is_room_booked($id, $checkin, $checkout) {
				$checkindate = convert_to_unix($checkin);
				$checkoutdate = convert_to_unix($checkout);
				$days = pt_dates_between($checkindate, $checkoutdate);

				$roomsbooked = array();
				$bookedid = array();
				$CI = get_instance();
				foreach($days as $day){
				$CI->db->select('booked_id,booked_room_count,booked_checkout,booked_checkin,booked_booking_status');
				$CI->db->where('booked_checkin <=',$day);	
				$CI->db->where('booked_checkout >',$day);					
				$CI->db->where('booked_booking_status !=', 'unpaid');
				//$CI->db->group_by('booked_room_id');
				$CI->db->where('booked_room_id', $id);
				$booked = $CI->db->get('pt_booked_rooms')->result();
				if (!empty ($booked)) {
					foreach($booked as $b){
					if(!in_array($b->booked_id,$bookedid)){

						$bookedid[] = $b->booked_id;
						$roomsbooked[] = $b->booked_room_count;
					}
				}

				}
				else {
						$roomsbooked[] = 0;
				}

				}
				return array_sum($roomsbooked);
		}

}if (!function_exists('ptRoomAvailability')) {

		function ptRoomAvailability($id, $checkin, $checkout) {
				$response = new stdClass;
				$checkindate = convert_to_unix($checkin);
				$checkoutdate = convert_to_unix($checkout);
				$days = pt_dates_between($checkindate, $checkoutdate);

				$response->isAvailable = TRUE;
				
				$roomsbooked = array();
				$bookedid = array();
				$ci = get_instance();
				$cc = array();
				foreach($days as $d){

				$currentyear = date("Y");	
				$dateparts = explode("-",$d);
				$year = $dateparts[0];
				$month = $dateparts[1];

				if($dateparts[2] < 10){
				$dateparts[2] = str_replace("0","",$dateparts[2]);
				}

				$day = "d".$dateparts[2];
				if($year == $currentyear){
				$y = '0';
				}else{
				$y = '1';
				}


				$ci->db->where('y',$y);
				$ci->db->where('m',$month);
				$ci->db->where('room_id',$id);

				$ravial = $ci->db->get('pt_rooms_availabilities')->result();
				$ckhavail = $ravial[0]->$day;
				
				if($ckhavail > 0){	
				    $cc[] = $ckhavail;				
					continue;
				}else{
					$response->isAvailable = FALSE;
					break;
				}

				
		

				}

				$response->dateByDate = $cc;

				return $response;

		}

}if (!function_exists('calendar_room_check')) {

		function calendar_room_check($id, $totalquantity, $chkdate) {
				$CI = get_instance();
				$CI->db->select('booked_room_count,booked_checkout,booked_checkin');
				$CI->db->select_sum('booked_room_count');
				$CI->db->where("booked_checkin <=", $chkdate);
				$CI->db->where("booked_checkout >", $chkdate);
				$CI->db->where('booked_booking_status', 'paid');
				$CI->db->or_where('booked_booking_status', 'reserved');
				$CI->db->group_by('booked_room_id');
				$CI->db->having('booked_room_id', $id);
				$booked = $CI->db->get('pt_booked_rooms')->result();
				if (empty ($booked)) {
						return true;
				}
				else {
						if ($booked[0]->booked_room_count >= $totalquantity) {
								return false;
						}
						else {
								return true;
						}
				}
		}

}