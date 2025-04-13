<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');
if (!function_exists('api_dates_between')) {

		function api_dates_between($start, $end) {
				$dates = array();
				while ($start < $end) {
						array_push($dates, $start);
						$start += 86400;
				}
				return $dates;
		}

}if (!function_exists('api_count_days')) {

		function api_count_days($date1, $date2) {
				$chkin = str_replace("/", "-", $date1);
				$chkout = str_replace("/", "-", $date2);
				$d1 = strtotime($chkin);
				$d2 = strtotime($chkout);
				if ($d1 > $d2) {
						return '-1';
				}
				else {
						$day_diff = abs($d2 - $d1);
						$days = $day_diff / 86400;
						$days = ceil($days);
						if ($days == 0) {
								$days = 1;
						}
						return $days;
				}
		}

}if (!function_exists('api_hotel_advanced_price')) {

		function api_hotel_advanced_price($hotelid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Hotels_model');
				$res = $CI->Hotels_model->get_hotel_adv_price($hotelid);
				return $res['basic'];
		}

}if (!function_exists('api_hotel_images')) {

		function api_hotel_images($hotelid) {
				$result = array();
				$CI = get_instance();
				$CI->load->model('Hotels/Hotels_model');
				$res = $CI->Hotels_model->hotelImages($hotelid);
				foreach ($res['all_slider'] as $img) {
						$result[]['thumb'] = PT_HOTELS_SLIDER . $img->himg_image;
				}
				return $result;
		}

}if (!function_exists('api_room_advanced_price')) {

		function api_room_advanced_price($roomid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Rooms_model');
				$res = $CI->Rooms_model->get_room_adv_price($roomid);
				return $res;
		}

}if (!function_exists('api_default_room_image')) {

		function api_default_room_image($roomid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Rooms_model');
				$res = $CI->Rooms_model->default_room_img($roomid);
				return $res;
		}

}if (!function_exists('limit_chars')) {

		function limit_chars($str, $n = 500, $end_char = '...') {
				if (strlen($str) < $n) {
						return $str;
				}
				$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
				if (strlen($str) <= $n) {
						return $str;
				}
				$out = "";
				foreach (explode(' ', trim($str)) as $val) {
						$out .= $val . ' ';
						if (strlen($out) >= $n) {
								$out = trim($out);
								return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
						}
				}
		}

}if (!function_exists('api_is_room_booked')) {

		function api_is_room_booked($id, $checkin, $checkout) {
				$chkin = str_replace("/", "-", $checkin);
				$chkout = str_replace("/", "-", $checkout);
				$days = api_dates_between(strtotime($chkin), strtotime($chkout));
				$CI = get_instance();
				$tdays = api_count_days($checkin, $checkout);
				$CI->db->select('booked_room_count,booked_checkout,booked_checkin');
				$CI->db->select_sum('booked_room_count');
				if ($tdays > 1) {
/* $CI->db->where_in("booked_checkin",$days);



$CI->db->or_where_in("booked_checkout",$days);*/
						$CI->db->where("booked_checkin <", strtotime($chkout));
						$CI->db->where("booked_checkout >", strtotime($chkin));
				}
				else {
						$CI->db->where("booked_checkin <", strtotime($chkout));
						$CI->db->where("booked_checkout >", strtotime($chkin));
				}
				$CI->db->where('booked_booking_status', 'pending');
				$CI->db->group_by('booked_room_id');
				$CI->db->having('booked_room_id', $id);
				$booked = $CI->db->get('pt_booked_rooms')->result();
				if (empty ($booked)) {
						return '0';
				}
				else {
						return $booked[0]->booked_room_count;
				}
		}

}if (!function_exists('api_hotel_opts')) {

		function api_hotel_opts($id, $type) {
				$CI = get_instance();
				$data = array();
				if ($type == "payment") {
						$CI->db->select('hotel_payment_opt');
				}
				elseif ($type == "amenities") {
						$CI->db->select('hotel_amenities');
				}
				$CI->db->where('hotel_id', $id);
				$rs = $CI->db->get('pt_hotels')->result();
				if ($type == "payment") {
						$opts = explode(",", $rs[0]->hotel_payment_opt);
				}
				elseif ($type == "amenities") {
						$opts = explode(",", $rs[0]->hotel_amenities);
				}
				foreach ($opts as $opt) {
						$CI->db->select('sett_name');
						$CI->db->where('sett_id', $opt);
						$pres = $CI->db->get('pt_hotels_types_settings')->result();
						$data[] = ucwords($pres[0]->sett_name);
				}
				return $data;
		}

}if (!function_exists('api_valid_invoice')) {

		function api_valid_invoice($id, $ref) {
				$CI = get_instance();
				$CI->db->select('booking_id');
				$CI->db->where('booking_id', $id);
				$CI->db->where('booking_ref_no', $ref);
				$res = $CI->db->get('pt_bookings')->num_rows();
				if ($res > 0) {
						return true;
				}
				else {
						return false;
				}
		}

}