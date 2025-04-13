<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');
if (!function_exists('Error_404')) {

	function Error_404($mainController,$data = null) {
		$CI = get_instance();
		$data['page_title'] = trans("0268");
		$CI->theme->view('404',$data, $mainController);



	}

}if (!function_exists('Module_404')) {

	function Module_404($data = null) {

		redirect(base_url().'notfound');


	}

}if (!function_exists('backError_404')) {

	function backError_404($data = null) {
		$CI = get_instance();
		$data['page_title'] = trans("0268");
		$data['main_content'] = '404';
		$CI->load->view('Admin/template', $data);


	}

}if (!function_exists('NotifyMsg')) {

	function NotifyMsg($msg) {
		if(!empty($msg)){
			echo "<script>
			new PNotify({
				title: 'Changes Saved!',
				type: 'info',
				animation: 'fade'
				});
				</script>";
			}
		}

	}if (!function_exists('convert_to_unix')) {

		function convert_to_unix($date, $result = null) {
			$CI = get_instance();
			if(empty($result)){
				$CI->load->model('Admin/Settings_model');
				$res = $CI->Settings_model->show_date_format();

				$result = $res[0]->date_f;
			}

			$rslt = "";
			if ($result == "m/d/Y") {
				$date = str_replace("-", "/", $date);
				$rslt = strtotime($date);
			}
			elseif ($result == "Y/m/d") {
				$date = str_replace("-", "/", $date);
				$rslt = strtotime($date);
			}
			elseif ($result == "d/m/Y") {
				$date = str_replace("/", "-", $date);
				$rslt = strtotime($date);
			}
			elseif ($result == "d-m-Y") {
				$rslt = strtotime($date);
			}
			elseif ($result == "m-d-Y") {
				$date = str_replace("-", "/", $date);
				$rslt = strtotime($date);
			}
			else {
				$rslt = strtotime($date);
			}
			return $rslt;
		}

	}if (!function_exists('formatFullDate')) {

		function formatFullDate($datetime,$format,$empty_text = '') {
			if($format == 'm/d/Y'){
				$field_date_format = 'M d, Y';
			}elseif($format == 'd/m/Y'){
				$field_date_format = 'd M, Y';
			}

			$datetime_check = preg_replace('/0|-| |:/', '', $datetime);
			if($datetime_check != ''){
				$datetime_new = @mktime(substr($datetime, 11, 2), substr($datetime, 14, 2),
					substr($datetime, 17, 2), substr($datetime, 5, 2),
					substr($datetime, 8, 2), substr($datetime, 0, 4));

				return @date($field_date_format, $datetime_new);
			}else{
				return $empty_text;
			}

		}

	}if (!function_exists('databaseDate')) {

		function databaseDate($date) {
			$format = ptGetDateFormat();
			$retDate = "";
			if($format['date_f'] == 'm/d/Y'){
				$retDate = substr($date, 6, 4).'-'.substr($date, 0, 2).'-'.substr($date, 3, 2);
			}elseif($format['date_f'] == 'd/m/Y'){
				$retDate = substr($date, 6, 4).'-'.substr($date, 3, 2).'-'.substr($date, 0, 2);
			}
			return $retDate;

		}

	}if (!function_exists('fromDbToAppFormatDate')) {
//format a date from database which is YYYY-MM-DD format to application settings format
		function fromDbToAppFormatDate($date) {
			$fmtDate = explode("-",$date);
			$year = $fmtDate[0];
			$m = $fmtDate[1];
			$day = $fmtDate[2];
			$format = ptGetDateFormat();
			$retDate = "";
			if($format['date_f'] == 'm/d/Y'){
				$retDate = $m."/".$day."/".$year;
			}elseif($format['date_f'] == 'd/m/Y'){
				$retDate = $day."/".$m."/".$year;
			}
			return $retDate;

		}

	}if (!function_exists('pt_main_module_available')) {

		function pt_main_module_available($module) {
			$CI = get_instance();
			$CI->load->library('ptmodules');
			$listmods = $CI->ptmodules->moduleslist;
			$intlistmods = $CI->ptmodules->integratedmoduleslist;
			$enabled = $CI->ptmodules->is_main_module_enabled($module);
			$allmods = array_merge($listmods, $intlistmods);
			if (in_array(ucfirst($module), $allmods) && $enabled) {
				return true;
			}
			else {
				return false;
			}
		}

	}
	if (!function_exists('module_status_check')) {

		function module_status_check($module) {
		// if($module == 'travelpayoutshotels') {
		// 	require_once __DIR__ .'/../modules/integrations/Travelpayoutshotels/controllers/Travelpayoutshotelsback.php';
		// 	$response = call_user_func('Travelpayoutshotelsback::getModuleStatus');
		// 	return $response;
		// }
		}

	}
	if (!function_exists('pt_default_theme')) {

		function pt_default_theme() {
			$CI = get_instance();
			$CI->load->model('Admin/Settings_model');
			$res = $CI->Settings_model->get_theme();
			return $res;
		}

	}if (!function_exists('ptCurrencies')) {

		function ptCurrencies() {
			$CI = get_instance();
			$CI->load->library('currconverter');
			return $CI->currconverter->getCurrencies();
		}

	}
if (!function_exists('defaultCurrencies')) {

    function defaultCurrencies() {
        $CI = get_instance();
        $CI->load->model('Admin/Settings_model');
       $code =  $CI->Settings_model->getDefaultCurrency();
       return $code['code'];
    }

}
	if (!function_exists('ptCurrencies')) {

		function ptCurrencies() {
			$CI = get_instance();
				/*$CI->load->library('currconverter');
				return $CI->currconverter->getCurrencies();*/
			}

		}if (!function_exists('pt_searchbox')) {

			function pt_searchbox($txt) {
				$CI = get_instance();
				$CI->load->model('Admin/Settings_model');
// returns true or false for multiple currencies usage
				$res = $CI->Settings_model->getSearchbox();
				if ($res == $txt) {
					echo "active in";
				}
				else {
					echo "";
				}
			}

		}if (!function_exists('pt_get_types_details')) {

			function pt_get_types_details($type, $items) {
				$CI = get_instance();
				$CI->load->model('Hotels/Hotels_model');
				$res = $CI->Hotels_model->get_hsettings_data_front($type, $items);
				return $res;
			}

		}if (!function_exists('pt_hotel_commission')) {

			function pt_hotel_commission($id) {
				$res = array();
				$CI = get_instance();
				$CI->db->select('hotel_comm_fixed,hotel_comm_percentage');
				$CI->db->where('hotel_id', $id);
				$result = $CI->db->get('pt_hotels')->result();
				$res['fixed_com'] = $result[0]->hotel_comm_fixed;
				$res['per_com'] = $result[0]->hotel_comm_percentage;
				return $res;
			}

		}if (!function_exists('pt_is_subscribed')) {

			function pt_is_subscribed($email) {
				$CI = get_instance();
				$CI->load->model('newsletter_model');
				$res = $CI->Newsletter_model->is_subscribed($email);
				return $res;
			}

		}if (!function_exists('pt_get_footer_socials')) {

			function pt_get_footer_socials() {
				$CI = get_instance();
				$CI->load->model('Helpers_models/Misc_model');
				$res = $CI->Misc_model->get_all_footer_social();
				return $res;
			}

		}
if (!function_exists('pt_get_footer_socials_main')) {

    function pt_get_footer_socials_main() {
        $CI = get_instance();
        $CI->load->model('Helpers_models/Misc_model');
        $res = $CI->Misc_model->get_all_footer_social();
        $arr = [];
        foreach ($res as $check){
            if($check->social_status == 'Yes'){
                $status = true;
            }else{
                $status = false;
            }
            $arr[]= array("social_id" =>  $check->social_id,"social_name" => $check->social_name,"social_link" =>$check->social_link, "social_position" => $check->social_position,'social_order'=>$check->social_order,'status'=>$status,'social_icon'=>$check->social_icon);
        }
        return $arr;
    }

}
	if (!function_exists('pt_get_header_socials')) {

			function pt_get_header_socials() {
				$CI = get_instance();
				$CI->load->model('Helpers_models/Misc_model');
				$res = $CI->Misc_model->get_all_header_social();
				return $res;
			}

		}if (!function_exists('pt_get_main_slides')) {

			function pt_get_main_slides() {
				$result = new stdClass;
				$CI = get_instance();
				$CI->load->model('Helpers_models/Misc_model');
				$CI->load->library('sliders_lib');
				$sliderlib = $CI->sliders_lib;

				$res = $CI->Misc_model->get_all_main_slides();
				$result->totalSlides = count($res);
				$result->slides = array();
				$scount = 0;
				foreach($res as $r){
					$sliderlib->set_id($r->slide_id);
					$sliderlib->slide_details();
					$scount++;
					if($scount == 1){ $sactive = "active"; }else{ $sactive = ""; }
					$result->slides[] = (object)array('title' => $sliderlib->title,'thumbnail' => PT_SLIDER_IMAGES.$r->slide_image,'desc' => $sliderlib->desc,'optionalText' => $sliderlib->optionalText, 'sactive' => $sactive);
				}

				return $result;
			}

		}if (!function_exists('pt_user_country_city_state')) {

			function pt_user_country_city_state($city) {
				$CI = get_instance();
				$CI->load->model('countries_model');
				$res = $CI->Countries_model->get_city_data($city);
				return $res;
			}

		}if (!function_exists('create_url_slug')) {

			function create_url_slug($string) {
				$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
				return $slug;
			}

		}if (!function_exists('pt_show_front_modules')) {

			function pt_show_front_modules() {
				$CI = get_instance();
				$CI->load->model('modules_model');
				$res = $CI->Modules_model->get_front_modules();
				return $res;
			}

		}if (!function_exists('ptGetDateFormat')) {

			function ptGetDateFormat() {
				$CI = get_instance();
				$CI->load->model('settings_model');
				$res = $CI->Settings_model->show_date_format();
				$result['js_format'] = $res[0]->date_f_js;
				$result['date_f'] = $res[0]->date_f;
				return $result;
			}

		}if (!function_exists('pt_str_date_convert')) {

			function pt_str_date_convert($format, $str) {
				if (empty ($str)) {
					echo "";
				}
				else {
					echo date($format, $str);
				}
			}

		}if (!function_exists('pt_show_date_php')) {

			function pt_show_date_php($str) {
				$CI = get_instance();
				$CI->load->model('settings_model');
				$res = $CI->Settings_model->show_date_format();
				$result = $res[0]->date_f;
				if($str > 0){
					return date($result, $str);
				}else{
					return "";
				}

			}

		}if (!function_exists('pt_change_date_string')) {

			function pt_change_date_string() {
				$CI = get_instance();
				$CI->load->model('settings_model');
				$res = $CI->Settings_model->show_date_format();
				$result = $res[0]->date_f;
				if ($result == "m/d/Y") {
					return false;
				}
				else {
					return true;
				}
			}

		}if (!function_exists('pt_admin_gallery_approve')) {

			function pt_admin_gallery_approve() {
				$CI = get_instance();
				$CI->load->model('settings_model');
				$res = $CI->Settings_model->admin_gallery_approvals();
				return $res;
			}

		}if (!function_exists('pt_can_upload')) {

			function pt_can_upload() {
				$CI = get_instance();
				$CI->load->model('settings_model');
				$res = $CI->Settings_model->upload_allowed();
				return $res;
			}

		}if (!function_exists('pt_rooms_count')) {

			function pt_rooms_count($hotelid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Hotels_model');
				$res = $CI->Hotels_model->rooms_count($hotelid);
				return $res;
			}

		}if (!function_exists('pt_reviews_count')) {

			function pt_reviews_count($hotelid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Hotels_model');
				$res = $CI->Hotels_model->reviews_count($hotelid);
				return $res;
			}

		}if (!function_exists('pt_get_room_images')) {

			function pt_get_room_images($roomid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Rooms_model');
				$res = $CI->Rooms_model->room_images_front($roomid);
				return $res;
			}

		}if (!function_exists('pt_license_check')) {

			function pt_license_check() {
				$CI = get_instance();
				$CI->db->select('license_key,local_key,secret_key');
				$CI->db->where('user', 'webadmin');
				$res = $CI->db->get('pt_app_settings')->result();
				return $res;
			}

		}if (!function_exists('pt_default_hotel_image')) {

			function pt_default_hotel_image($hotelid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Hotels_model');
				$res = $CI->Hotels_model->default_hotel_img($hotelid);
				return $res;
			}

		}if (!function_exists('pt_default_cruise_image')) {

			function pt_default_cruise_image($cruiseid) {
				$CI = get_instance();
				$CI->load->model('cruises/cruises_model');
				$res = $CI->cruises_model->default_cruise_img($cruiseid);
				return $res;
			}

		}if (!function_exists('pt_default_car_image')) {

			function pt_default_car_image($carid) {
				$CI = get_instance();
				$CI->load->model('Cars/Cars_model');
				$res = $CI->Cars_model->default_car_img($carid);
				return $res;
			}

		}if (!function_exists('pt_default_room_image')) {

			function pt_default_room_image($roomid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Rooms_model');
				$res = $CI->Rooms_model->default_room_img($roomid);
				return $res;
			}

		}if (!function_exists('pt_default_tour_image')) {

			function pt_default_tour_image($tourid) {
				$CI = get_instance();
				$CI->load->model('Tours/Tours_model');
				$res = $CI->Tours_model->default_tour_img($tourid);
				return $res;
			}

		}if (!function_exists('pt_car_advanced_price')) {

			function pt_car_advanced_price($carid) {
				$CI = get_instance();
				$CI->load->model('Cars/Cars_model');
				$res = $CI->Cars_model->get_car_adv_price($carid);
				return $res;
			}

		}if (!function_exists('pt_room_advanced_price')) {

			function pt_room_advanced_price($roomid) {
				$CI = get_instance();
				$CI->load->model('Hotels/Rooms_model');
				$res = $CI->Rooms_model->get_room_adv_price($roomid);
				return $res;
			}

		}if (!function_exists('pt_count_days')) {

			function pt_count_days($date1, $date2) {
				$d1 = convert_to_unix($date1);
				$d2 = convert_to_unix($date2);
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

		}if (!function_exists('pt_return_cities')) {

			function pt_return_cities($id, $type) {
				$CI = get_instance();
				$CI->load->model('Admin/Countries_model');
				if ($type == "country") {
					$res = $CI->Countries_model->get_cities_by_country($id);
				}
				elseif ($type == "state") {
					$res = $CI->Countries_model->get_cities_by_state($id);
				}
				return $res;
			}

		}if (!function_exists('pt_get_icon')) {

			function pt_get_icon($id) {
				$CI = get_instance();
				$CI->db->select('front_icon,front_for');
				$CI->db->where('front_for', $id);
				$res = $CI->db->get('pt_front_settings')->result();
				if (!empty ($res)) {
					return $res[0]->front_icon;
				}
				else {
					return '';
				}
			}

		}if (!function_exists('pt_linktarget')) {

			function pt_linktarget($id) {
				$CI = get_instance();
				$CI->db->select('linktarget,front_for');
				$CI->db->where('front_for', $id);
				$res = $CI->db->get('pt_front_settings')->result();
				if (!empty ($res)) {
					return $res[0]->linktarget;
				}
				else {
					return '';
				}
			}

		}if (!function_exists('pt_check_wishlist')) {

			function pt_check_wishlist($user, $itemid, $module = "hotels") {
				$CI = get_instance();
				$CI->db->select('wish_id');
				$CI->db->where('wish_user', $user);
				$CI->db->where('wish_itemid', $itemid);
				$CI->db->where('wish_module', $module);
				$wres = $CI->db->get('pt_wishlist')->num_rows();
				if ($wres > 0) {
					return true;
				}
				else {
					return false;
				}
			}

		}if (!function_exists('pt_my_rooms')) {

			function pt_my_rooms($user) {
				$CI = get_instance();
				$rooms = array();
				$CI->db->select('hotel_id');
				$CI->db->where('hotel_owned_by', $user);
				$myhotels = $CI->db->get('pt_hotels')->result();
				foreach ($myhotels as $h) {
					$CI->db->select('room_id');
					$CI->db->where('room_hotel', $h->hotel_id);
					$myroom = $CI->db->get('pt_rooms')->result();
					foreach ($myroom as $r) {
						$rooms[] = $r->room_id;
					}
				}
				return $rooms;
			}

		}if (!function_exists('pt_get_module_item_info')) {

			function pt_get_module_item_info($module, $id) {
				$CI = get_instance();
				$CI->load->model('modules_model');
				return $CI->Modules_model->get_for_details($module, $id);
			}

		}if (!function_exists('pt_pendings_count')) {

			function pt_pendings_count($type, $module = null) {
				$counts = array();
				$CI = get_instance();
				if ($type = 'reviews') {
					$CI->load->model('Reviews_model');
					$counts['reviews'][$module] = $CI->Reviews_model->count_pending_reviews($module);
				}
				$CI->load->model('Helpers_models/Misc_model');
				if ($type = 'images') {
					if ($module == 'hotels') {
						$counts['images']['hotels'] = $CI->Misc_model->count_pending_hotel_images();
					}
					elseif ($module == 'rooms') {
						$counts['images']['rooms'] = $CI->Misc_model->count_pending_room_images();
					}
					elseif ($module == 'cruises') {
						$counts['images']['cruises'] = $CI->Misc_model->count_pending_cruise_images();
					}
					elseif ($module == 'crooms') {
						$counts['images']['crooms'] = $CI->Misc_model->count_pending_croom_images();
					}
					elseif ($module == 'tours') {
						$counts['images']['tours'] = $CI->Misc_model->count_pending_tour_images();
					}
					elseif ($module == 'cars') {
						$counts['images']['cars'] = $CI->Misc_model->count_pending_car_images();
					}
				}

				if ($type = 'accounts') {
					if ($module == 'supplier') {
						$counts['accounts']['supplier'] = $CI->Misc_model->count_pending_accounts_supplier();
					}
					elseif ($module == "customers") {
						$counts['accounts']['customers'] = $CI->Misc_model->count_pending_accounts_cust();
					}
				}
				return $counts;
			}

		}if (!function_exists('pt_image_paths_constants')) {

			function pt_image_paths_constants($type, $module) {
				if ($module == "hotels") {
					if ($type == 'slider') {
						return PT_HOTELS_SLIDER;
					}
					elseif ($type == 'interior') {
						return PT_HOTELS_INTERIOR;
					}
					elseif ($type == 'exterior') {
						return PT_HOTELS_EXTERIOR;
					}
				}
				elseif ($module == "cruises") {
					if ($type == 'default') {
						return PT_CRUISES_MAIN_THUMB;
					}
					elseif ($type == 'slider') {
						return PT_CRUISES_SLIDER;
					}
					elseif ($type == 'interior') {
						return PT_CRUISES_PINTERIOR;
					}
					elseif ($type == 'exterior') {
						return PT_CRUISES_EXTERIOR;
					}
				}
				elseif ($module == "rooms") {
					if ($type == 'default') {
						return PT_ROOMS_MAIN_THUMB;
					}
					elseif ($type == '') {
						return PT_ROOMS_IMAGES;
					}
				}
				elseif ($module == "crooms") {
					if ($type == 'default') {
						return PT_CRUISE_ROOMS_MAIN_THUMB;
					}
					elseif ($type == '') {
						return PT_CRUISE_ROOMS_IMAGES;
					}
				}
				elseif ($module == "tours") {
					if ($type == 'default') {
						return PT_TOURS_SLIDER;
					}
					elseif ($type == 'slider') {
						return PT_TOURS_SLIDER;
					}
				}
				elseif ($module == "cars") {
					if ($type == 'default') {
						return PT_CARS_SLIDER;
					}
					elseif ($type == 'slider') {
						return PT_CARS_SLIDER;
					}
				}
			}

		}if (!function_exists('pt_active_link')) {

			function pt_active_link($slug = null) {
				require APPPATH.'config/routes.php';
				$CI = get_instance();
				$segment = $CI->uri->segment(1);
				$routeSlug = "";
				if(!empty($slug)){
					$routeSlug = array_search($slug, $route);
				}
				if(!empty($routeSlug)){
					$slug = $routeSlug;
				}

				if (empty ($segment) && empty ($slug)) {
					return 'active';
				}
				elseif ($segment == $slug) {
					return 'active';
				}
			}

		}if (!function_exists('pt_back_active_link')) {

			function pt_back_active_link($link, $slug) {
				if ($link == $slug) {
					echo "active";
				}
				elseif ($link == "backup" && $slug == "settings") {
					echo "active";
				}
			}

		}if (!function_exists('pt_is_special')) {

			function pt_is_special($module, $id) {
			   /*	$CI = get_instance();
				$CI->db->where('offer_from <', time());
				$CI->db->where('offer_to >', time());
				$CI->db->where('offer_module', $module);
				$CI->db->where('offer_item', $id);
				$CI->db->having('offer_status', '1');
				$ores = $CI->db->get('pt_special_offers')->num_rows();
				if ($ores > 0) {
						return TRUE;
				}
				else {
						return FALSE;
					}*/
				}

			}if (!function_exists('pt_permissions')) {

				function pt_permissions($module, $id) {
					$CI = get_instance();
					if (!$CI->session->userdata('pt_logged_super_admin')) {
						$CI->db->where('accounts_id', $id);
						$CI->db->like('accounts_permissions', $module, 'both');
						$perms = $CI->db->get('pt_accounts')->num_rows();
						if ($perms > 0) {
							return TRUE;
						}
						else {
							return FALSE;
						}
					}
					else {
						return TRUE;
					}
				}

			}if (!function_exists('pt_create_stars')) {

				function pt_create_stars($totalstars) {
					$icon = "";
					for($stars = 1; $stars <= 5; $stars++){

						if($stars <= $totalstars){
							$icon .= PT_STARS_ICON;
						}else{
							$icon .= PT_EMPTY_STARS_ICON;
						}

					}
					return $icon;

				}

			}if (!function_exists('getPagination')) {

				function getPagination($count, $perpage, $currentpage = null) {
					$paginationCount = floor($count / $perpage);
					$paginationModCount = $count % $perpage;
					if (!empty ($paginationModCount)) {
						$paginationCount++;
					}
					$html = array();
					$html['total'] = $paginationCount;
					$html['pages'] = '';
					if ($html['total'] > 0) {
						if ($paginationCount > 10) {
							$midrange = 9;
							$start_range = $currentpage - floor($midrange / 2);
							$end_range = $currentpage + floor($midrange / 2);
							if ($start_range <= 0) {
								$end_range += abs($start_range) + 1;
								$start_range = 1;
							}
							if ($end_range > $paginationCount) {
								$start_range -= $end_range - $paginationCount;
								$end_range = $paginationCount;
							}
							$range = range($start_range, $end_range);
							$html['pages'] .= '<ul class="pagination">

							<li class="first link" id="1">

							<a  href="javascript:void(0)" onclick="changePagination(\'1\',\'1\')">First</a>

							</li>';
							for ($i = 1; $i <= $paginationCount; $i++) {
								if ($range[0] > 2 And $i == $range[0])
									$html['pages'] .= '<li><a href="javascript:void(0)">...</a> </li>';
// loop through all pages. if first, last, or in range, display
								if ($i == 1 Or $i == $paginationCount Or in_array($i, $range)) {
									$html['pages'] .= ($i == $currentpage) ? '<li id="li_' . $i . '" class="litem active">

									<a  href="javascript:void(0)" >

									' . ($i) . '

									</a>

									</li>' : '<li id="li_' . $i . '" class="litem">

									<a  href="javascript:void(0)" onclick="changePagination(\'' . $i . '\',\'' . $i . '\')">

									' . ($i) . '

									</a>

									</li>';
								}
								if ($range[$midrange - 1] < $paginationCount - 1 And $i == $range[$midrange - 1])
									$html['pages'] .= '<li><a href="javascript:void(0)">...</a> </li>';
							}
							if ($currentpage < $paginationCount) {
								$html['pages'] .= '<li class="next" id="' . $paginationCount . '">

								<a href="javascript:void(0)" onclick="changePagination(\'' . ($currentpage + 1) . '\',\'' . ($currentpage + 1) . '\')">Next</a>

								</li>';
								$html['pages'] .= '<li class="last" id="' . $paginationCount . '">

								<a href="javascript:void(0)" onclick="changePagination(\'' . ($paginationCount) . '\',\'' . $paginationCount . '\')">Last</a>

								</li></ul>';
							}
						}
						else {
							$html['pages'] .= '<ul class="pagination">';
							if ($currentpage != 1) {
								$html['pages'] .= '<li class="first link" id="1">

								<a  href="javascript:void(0)" onclick="changePagination(\'1\',\'1\')">First</a>

								</li>';
							}
							for ($i = 1; $i <= $paginationCount; $i++) {
								$html['pages'] .= ($i == $currentpage) ? '<li id="li_' . $i . '" class="litem active">

								<a  href="javascript:void(0)" >

								' . ($i) . '

								</a>

								</li>' : '<li id="li_' . $i . '" class="litem">

								<a  href="javascript:void(0)" onclick="changePagination(\'' . $i . '\',\'' . $i . '\')">

								' . ($i) . '

								</a>

								</li>';
							}
							if ($currentpage < $paginationCount) {
								$html['pages'] .= '<li class="next" id="' . $paginationCount . '">

								<a href="javascript:void(0)" onclick="changePagination(\'' . ($currentpage + 1) . '\',\'' . ($currentpage + 1) . '\')">Next</a>

								</li>';
								$html['pages'] .= '<li class="last" id="' . $paginationCount . '">

								<a href="javascript:void(0)" onclick="changePagination(\'' . ($paginationCount) . '\',\'' . $paginationCount . '\')">Last</a>

								</li></ul>';
							}
						}
					}
					return $html;
				}

			}if (!function_exists('pt_embed_videos')) {

				function pt_embed_videos($url) {
					$CI = get_instance();
					$CI->load->library('c_video_providers');
					$video_code = $CI->c_video_providers->get_video_code($url);
					if ($video_code === false) {
						echo "video provider isn't support<br>";
					}
					else {
						$video_info = $CI->c_video_providers->get_video_info($video_code);
/*	echo "video code: $video_code<br>";

echo "link: <a href='".$video_info['url_watch']."'>".$video_info['url_watch']."</a><br>";

echo "preview small: <img src='".$video_info['url_img_preview']['small']."'><br>";

echo "preview medium: <img src='".$video_info['url_img_preview']['medium']."'><br>";

echo "preview large: <img src='".$video_info['url_img_preview']['large']."'><br>";*/
echo "<a class='youtube' href='" . $video_info['url_embed'] . "'><img src='" . $video_info['url_img_preview']['small'] . "'></a><br>";
// echo $video_info['embed']."<br>";
}
}

}if (!function_exists('pt_embed_videos_front')) {

	function pt_embed_videos_front($url) {
		$CI = get_instance();
		$CI->load->library('c_video_providers');
		$video_code = $CI->c_video_providers->get_video_code($url);
		if ($video_code === false) {
			echo "video provider isn't support<br>";
		}
		else {
			$video_info = $CI->c_video_providers->get_video_info($video_code);
			echo "<a href='" . $video_info['url_embed'] . "'><img src='" . $video_info['url_img_preview']['large'] . "'></a>";

		}
	}

}
/*********



This function accepts latitude, longitude, map width, map height.

optional parameters title, image url, image width, image height and url link



**********/
if (!function_exists('pt_show_map')) {

	function pt_show_map($lati, $long, $mapwidth, $mapheight, $title = null, $img = null, $imgwidth = null, $imgheight = null, $link = null) {
		if (empty ($link)) {
			$link = "#";
		}
		$CI = get_instance();

		$res = $CI->db->get('pt_app_settings')->result();
		$mapApi = $res[0]->mapApi;

		$CI->load->library('mapbuilder');
		$map = $CI->mapbuilder;
		$map->setMapTypeId('ROADMAP');
// Set map's center position by latitude and longitude coordinates.
		$map->setCenter($lati, $long);
		$map->setSize($mapwidth, $mapheight);
		$map->setApiKey($mapApi);
		$map->addMarker($lati, $long, array('title' => urldecode($title),'icon' => PT_DEFAULT_IMAGE . 'marker.png', 'defColor' => '#FA6D6D', 'defSymbol' => '', 'html' => '<div style="width:100%;height:120px;"><a href="' . $link . '"><div><img src="' . $img . '" width="' . $imgwidth . '" height="' . $imgheight . '" /></div><b>' . urldecode($title) . '</b></a></div>', 'infoCloseOthers' => true));
		$map->setZoom(14);
// Display the map.
		$map->show();
	}

}if (!function_exists('run_widget')) {

	function run_widget($id) {
		$CI = get_instance();
		$CI->load->model('Admin/Widgets_model');
		echo $CI->Widgets_model->get_widget_content($id);
	}

}if (!function_exists('pendings_result')) {

	function pendings_result() {
		$total = array();
		$reviewscount['reviews'] = 0;
		$supplierscount = 0;
		$custcount = 0;
		$ricounts = 0;
		$hicounts = 0;
		$ticounts = 0;
		$hvcounts = 0;
		$tvcounts = 0;
		$cicounts = 0;
		$cricounts = 0;
		$croomicounts = 0;
		$cvcounts = 0;
		$croomimgscount = 0;
		$hrevcounts = 0;
		$trevcounts = 0;
		$crevcounts = 0;
		$cruiserevcounts = 0;
		$supplieracountscount = pt_pendings_count('accounts', 'supplier');
		$supplierscount = $supplieracountscount['accounts']['supplier'];

		$custacountscount = pt_pendings_count('accounts', 'customers');
		$custcount = $custacountscount['accounts']['customers'];

		$total['suppliers'] = $supplierscount;
		$total['customers'] = $custcount;

		$hotelimgscount = pt_pendings_count('images', 'hotels');
		$hicounts = $hotelimgscount['images']['hotels'];
		$roomimgscount = pt_pendings_count('images', 'rooms');
		$ricounts = $roomimgscount['images']['rooms'];
		$total['img_rooms'] = $ricounts;
		$total['img_hotels'] = $hicounts;
		$cruiseimgscount = pt_pendings_count('images', 'cruises');
		$cricounts = $cruiseimgscount['images']['cruises'];
		$croomimgscount = pt_pendings_count('images', 'crooms');
		$croomicounts = $croomimgscount['images']['crooms'];
		$total['img_crooms'] = $croomicounts;
		$total['img_cruises'] = $cricounts;
		$reviewshotelcount = pt_pendings_count('reviews', 'hotels');
		$hrevcounts = $reviewshotelcount['reviews']['hotels'];
		$total['rev_hotels'] = $hrevcounts;
		$reviewscruisecount = pt_pendings_count('reviews', 'cruises');
		$cruiserevcounts = $reviewscruisecount['reviews']['cruises'];
		$total['rev_cruises'] = $cruiserevcounts;
		$tourimgscount = pt_pendings_count('images', 'tours');
		$ticounts = $tourimgscount['images']['tours'];
		$total['img_tours'] = $ticounts;
		$reviewstourcount = pt_pendings_count('reviews', 'tours');
		$trevcounts = $reviewstourcount['reviews']['tours'];
		$total['rev_tours'] = $trevcounts;
		$carsimgscount = pt_pendings_count('images', 'cars');
		$cicounts = $carsimgscount['images']['cars'];
		$total['img_cars'] = $cicounts;
		$reviewscarcount = pt_pendings_count('reviews', 'cars');
		$crevcounts = $reviewscarcount['reviews']['cars'];
		$total['rev_cars'] = $crevcounts;
		$totalreviews = $hrevcounts + $trevcounts + $crevcounts + $cruiserevcounts;
		$totalimages = $ricounts + $hicounts + $ticounts + $cicounts + $cricounts + $croomicounts;
		$total['totalreviews'] = $totalreviews;
		$total['totalimages'] = $totalimages;
		$total['grandtotal'] = $totalimages + $totalreviews + $custcount + $supplierscount;
		return $total;
	}

}if (!function_exists('email_template_detail')) {

	function email_template_detail($id) {
		$CI = get_instance();
		$CI->load->model('Admin/Templates_model');
		return $CI->Templates_model->get_template_detail($id);
	}

}

if ( ! function_exists('sms_template_body')) 
{
	function sms_template_body($template_name) 
	{
		$CI = get_instance();
		$CI->load->model('Admin/Templates_model');
		return $CI->Templates_model->get_sms_template_body($template_name);
	}
}

if (!function_exists('info_general')) {

	function info_general($type) {
		$result = '';
		$CI = get_instance();
		if ($type == "os") {
			$result = PHP_OS;
		}
		elseif ($type == "mysqli") {
			if (function_exists('mysqli_connect')) {
				$result = true;
			}
			else {
				$result = false;
			}
		}
		elseif ($type == "modrewrite") {
			if (function_exists('apache_get_modules')) {
				if (!in_array('mod_rewrite', apache_get_modules())) {
					$result = false;
				}
				else {
					$result = true;
				}
			}
			else {
				$mod_rewrite = getenv('HTTP_MOD_REWRITE') == 'On' ? true : false;
				if (!$mod_rewrite) {
					$result = false;
				}
				else {
					$result = true;
				}
			}
		}
		elseif ($type == "mysqlversion") {
			$q = $CI->db->query("SHOW VARIABLES LIKE 'version'");
			$r = $q->result();
			$result = $r[0]->Value;
		}
		return $result;
	}

}if (!function_exists('tripAdvisorInfo')) {

	function tripAdvisorInfo($id) {
		$result = "";
		$CI = get_instance();
		$tripmodule = $CI->ptmodules->is_mod_available_enabled("tripadvisor");
		if ($tripmodule && !empty ($id)) {
			$CI->load->library('Tripadvisor/Tripadvisor_lib');
        	return $CI->Tripadvisor_lib->location($id);
		}
		else {
			return $result;
		}
	}

}if (!function_exists('pt_set_langurl')) {

	function pt_set_langurl($url, $id){
		$completeurl = str_replace("{langid}",$id,$url);
		return $completeurl;

	}

}if (!function_exists('isRTL')) {

	function isRTL($language = "en"){
		$CI = get_instance();
		$sessRTL = $CI->session->userdata('isRtl');
		if(!empty($sessRTL)){

			return $sessRTL;

		}else{

			$file = file_get_contents("application/language/$language/name.txt", true);
			$name = explode(",",$file);
			return $name[1];

		}


	}

}if (!function_exists('languageName')) {

	function languageName($language = "en"){
		$CI = get_instance();
		$file = file_get_contents("application/language/$language/name.txt", true);
		$name = explode(",",$file);
		return $name[0];

	}

}if (!function_exists('setFrmVal')) {

	function setFrmVal($val,$fval) {
		if(!empty($val)){
			return $val;
		}else{
			return $fval;
		}

	}

}if (!function_exists('pt_HotelPhotosCount')) {

	function pt_HotelPhotosCount($hotelid) {
		$CI = get_instance();
		$CI->load->model('Hotels/Hotels_model');
		$res = $CI->Hotels_model->photos_count($hotelid);
		return $res;
	}

}if (!function_exists('pt_RoomPhotosCount')) {

	function pt_RoomPhotosCount($roomid) {
		$CI = get_instance();
		$CI->load->model('Hotels/Rooms_model');
		$res = $CI->Rooms_model->photos_count($roomid);
		return $res;
	}

}if (!function_exists('pt_OffersPhotosCount')) {

	function pt_OffersPhotosCount($id) {
		$CI = get_instance();
		$CI->load->model('Admin/Special_offers_model');
		$res = $CI->Special_offers_model->photos_count($id);
		return $res;
	}

}if (!function_exists('GetMonthMaxDay')) {

	function GetMonthMaxDay($year,$month) {
		if(empty($month)) $month = date('m');
		if(empty($year)) $year = date('Y');
		$result = strtotime("{$year}-{$month}-01");
		$result = strtotime('-1 second', strtotime('+1 month', $result));
		return date('d', $result);

	}

}if (!function_exists('makeSelected')) {

	function makeSelected($val1,$val2) {
		if($val1 == $val2){
			echo "selected";
		}else{
			echo "";
		}

	}

}if (!function_exists('getBackExtrasTranslation')) {

	function getBackExtrasTranslation($lang, $id) {
		if(!empty($id)){
			$CI = get_instance();
			$CI->load->model('Admin/Extras_model');
			$res = $CI->Extras_model->getBackTranslation($lang,$id);
			return $res;
		}else{
			return '';
		}

	}

}if (!function_exists('getMenusTranslation')) {

	function getMenusTranslation($lang, $id) {
		if(!empty($id)){
			$CI = get_instance();
			$CI->load->model('Admin/Cms_model');
			$res = $CI->Cms_model->getBackTranslation($lang,$id);
			return $res;
		}else{
			return '';
		}

	}

}if (!function_exists('getBackCMSTranslation')) {

	function getBackCMSTranslation($lang, $id) {
		if(!empty($id)){
			$CI = get_instance();
			$CI->load->model('Admin/Cms_model');
			$res = $CI->Cms_model->getBackCMSTranslation($lang,$id);
			return $res;
		}else{
			return '';
		}

	}

}if (!function_exists('getBackBlogTranslation')) {

	function getBackBlogTranslation($lang, $id) {
		if(!empty($id)){
			$CI = get_instance();
			$CI->load->model('Blog/Blog_model');
			$res = $CI->Blog_model->getBackBlogTranslation($lang,$id);
			return $res;
		}else{
			return '';
		}

	}

}if (!function_exists('getBlogCategoriesTranslation')) {

	function getBlogCategoriesTranslation($lang, $id) {
		if(!empty($id)){
			$CI = get_instance();
			$CI->load->model('Blog/Blog_model');
			$res = $CI->Blog_model->getBlogCatsTranslation($lang,$id);
			return $res;
		}else{
			return '';
		}

	}

}if (!function_exists('getBackOffersTranslation')) {

	function getBackOffersTranslation($lang, $id) {
		if(!empty($id)){
			$CI = get_instance();
			$CI->load->model('Admin/Special_offers_model');
			$res = $CI->Special_offers_model->getBackOffersTranslation($lang,$id);
			return $res;
		}else{
			return '';
		}

	}

}if (!function_exists('createPagination')) {

	function createPagination($info) {

		$CI = get_instance();
		$CI->load->library('Bootpagination');
		return $CI->bootpagination->dopagination($info);

	}

}if (!function_exists('addHttp')) {

	function addHttp($url) {

		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https://' : 'http://';
			$url = $http.$url;
		}
		return $url;

	}

}if (!function_exists('defineGatewayField')) {

	function defineGatewayField($gateway, $type, $name, $defaultvalue, $friendlyname, $size, $description) {
		global $GatewayFieldDefines;

		if ($type == "dropdown") {
			$options = $description;
			$description = "";
		}
		else {
			$options = "";
		}

		$GatewayFieldDefines[$name] = array("FriendlyName" => $friendlyname, "Type" => $type, "Size" => $size, "Description" => $description, "Value" => $defaultvalue, "Options" => $options);
	}

}if(!function_exists('getExtraTitleImg')){
	function getExtraTitleImg($extra){
		$info = new stdClass;

		$CI = get_instance();
		$language = $CI->session->userdata('set_lang');
		if(empty($language)){

			$language = pt_get_default_language();
		}

		$CI->db->select('extras_title,extras_desc,extras_image');
		$CI->db->where('extras_id',$extra);
		$re = $CI->db->get('pt_extras')->result();
		if ($language == DEFLANG) {
			$info->title = $re[0]->extras_title;
		}else {
			$CI->db->select('trans_title');
			$CI->db->where('trans_extras_id', $extra);
			$CI->db->where('trans_lang', $language);
			$r = $CI->db->get('pt_extras_translation')->result();
			if (empty ($r[0]->trans_title)) {
				$info->title = $re[0]->extras_title;
			}
			else {
				$info->title = $r[0]->trans_title;
			}

		}
		$info->image = $re[0]->extras_image;
		return $info;

	}
}if (!function_exists('moduleConfigFieldOutput')) {

	function moduleConfigFieldOutput($values) {
		if (!$values['Value']) {
			$values['Value'] = $values['Default'];
		}


		if ($values['Type'] == "text") {
			$code = "<input type=\"text\" name=\"" . $values['Name'] . "\" size=\"" . $values['Size'] . "\" value=\"" . $values['Value'] . "\" />";

			if ($values['Description']) {
				$code .= " " . $values['Description'];
			}
		}
		else {
			if ($values['Type'] == "password") {
				$code = "<input type=\"password\" name=\"" . $values['Name'] . "\" size=\"" . $values['Size'] . "\" value=\"" . $values['Value'] . "\" />";

				if ($values['Description']) {
					$code .= " " . $values['Description'];
				}
			}
			else {
				if ($values['Type'] == "yesno") {
					$code = "<label><input type=\"checkbox\" name=\"" . $values['Name'] . "\"";

					if ($values['Value']) {
						$code .= " checked=\"checked\"";
					}

					$code .= " /> " . $values['Description'] . "</label>";
				}
				else {
					if ($values['Type'] == "dropdown") {
						$code = "<select name=\"" . $values['Name'] . "\">";
						$options = explode(",", $values['Options']);
						foreach ($options as $tempval) {
							$code .= "<option value=\"" . $tempval . "\"";

							if ($values['Value'] == $tempval) {
								$code .= " selected=\"selected\"";
							}

							$code .= ">" . $tempval . "</option>";
						}

						$code .= "</select>";

						if ($values['Description']) {
							$code .= " " . $values['Description'];
						}
					}
					else {
						if ($values['Type'] == "radio") {
							$code = "";

							if ($values['Description']) {
								$code .= $values['Description'] . "<br />";
							}

							$options = explode(",", $values['Options']);

							if (!$values['Value']) {
								$values['Value'] = $options[0];
							}

							foreach ($options as $tempval) {
								$code .= "<label><input type=\"radio\" name=\"" . $values['Name'] . "\" value=\"" . $tempval . "\"";

								if ($values['Value'] == $tempval) {
									$code .= " checked=\"checked\"";
								}

								$code .= " /> " . $tempval . "</label><br />";
							}
						}
						else {
							if ($values['Type'] == "textarea") {
								$cols = ($values['Cols'] ? $values['Cols'] : "60");
								$rows = ($values['Rows'] ? $values['Rows'] : "5");
								$code = "<textarea name=\"" . $values['Name'] . "\" cols=\"" . $cols . "\" rows=\"" . $rows . "\">" . $values['Value'] . "</textarea>";

								if ($values['Description']) {
									$code .= "<br />" . $values['Description'];
								}
							}
							else {
								$code = $values['Description'];
							}
						}
					}
				}
			}
		}

		return $code;
	}

}if (!function_exists('curlCall')) {

	function curlCall($url, $postfields = null, $curlopts = array()) {


		if (!array_key_exists("CURLOPT_TIMEOUT", $curlopts)) {
			$curlopts['CURLOPT_TIMEOUT'] = 100;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		if ($postfields) {
			$fieldstring = $postfields;

			if (is_array($fieldstring)) {
				$fieldstring = "";
				foreach ($postfields as $k => $v) {
					$fieldstring .= "" . $k . "=" . urlencode($v) . "&";
				}
			}

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldstring);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $curlopts['CURLOPT_TIMEOUT']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		if (array_key_exists("HEADER", $curlopts)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $curlopts['HEADER']);
		}

		$retval = curl_exec($ch);

		if (curl_errno($ch)) {
			$retval = "CURL Error: " . curl_errno($ch) . " - " . curl_error($ch);
		}

		curl_close($ch);

		/*if ($debug_output) {
			echo (("<textarea rows=\"12\" cols=\"120\">URL: " . $url . "\r\n") . "\r\nData: " . $fieldstring . "\r\n") . "\r\nResponse: " . $retval . "</textarea><br>";
		}*/

		return $retval;
	}

}if (!function_exists('checkUpdatesCount')) {

	function checkUpdatesCount() {
		$ci = get_instance();
		$response = new stdClass;

		$ci->db->select('updates_check');
		$ci->db->where('user', 'webadmin');
		$res = $ci->db->get('pt_app_settings')->result();
		$duration = $res[0]->updates_check * 3600;
		if($duration > 0){

			$current = time();

			$check = $ci->db->get('pt_updates')->result();

			if(empty($check)){

				$lastupdate = 0;

			}else{

				$lastupdate = $check[0]->lastchecked;

			}


			if($current > $lastupdate){
				$listData = curlCall(UPDATES_LIST_URL);
				$ci->db->truncate('pt_updates');
				$data = array('updateslist' => $listData,'lastchecked' => $duration + $current);

				$ci->db->insert('pt_updates',$data);

			}else{

				$listData = $check[0]->updateslist;

			}




			$updatesList = json_decode($listData);
			$fileData = json_decode(file_get_contents("application/updates.json"));
			$myUpdates = array();
			if (!empty($updatesList)) {
				foreach($updatesList->list as $l){
					if(!empty($l->ptversion)){
						if($l->ptversion == PT_VERSION){
							$myUpdates[] = $l->update;
						}
					}

				}
			}

			$result = array_diff($myUpdates,$fileData->updated);
			$response->count = count($result);
			$response->list = (!empty($updatesList->list))?$updatesList->list:"";
			$response->myUpdates = $myUpdates;
			$response->showUpdates = TRUE;

		}else{
			$response->showUpdates = FALSE;

		}


		return $response;

	}

}if (!function_exists('pt_TourPhotosCount')) {

	function pt_TourPhotosCount($tourid) {
		$CI = get_instance();
		$CI->load->model('Tours/Tours_model');
		$res = $CI->Tours_model->photos_count($tourid);
		return $res;
	}

}if (!function_exists('pt_RentalPhotosCount')) {

    function pt_RentalPhotosCount($rentalid) {
        $CI = get_instance();
        $CI->load->model('Rentals/Rentals_model');
        $res = $CI->Rentals_model->photos_count($rentalid);
        return $res;
    }

}if (!function_exists('pt_BoatPhotosCount')) {

    function pt_BoatPhotosCount($boatid) {
        $CI = get_instance();
        $CI->load->model('Boats/Boats_model');
        $res = $CI->Boats_model->photos_count($boatid);
        return $res;
    }

}if (!function_exists('pt_LocationsInfo')) {

	function pt_LocationsInfo($locid, $lang = null) {
		$CI = get_instance();
		$CI->load->model('Admin/Locations_model');
		$res = $CI->Locations_model->getLocationDetails($locid, $lang);
		return $res;
	}

}if (!function_exists('pt_carPhotosCount')) {

	function pt_carPhotosCount($carid) {
		$CI = get_instance();
		$CI->load->model('Cars/Cars_model');
		$res = $CI->Cars_model->photos_count($carid);
		return $res;
	}

}if (!function_exists('pt_isInWishList')) {

	function pt_isInWishList($module, $itemid) {
		$CI = get_instance();
		$user = $CI->session->userdata('pt_logged_customer');
		$CI->db->where('wish_module',$module);
		$CI->db->where('wish_itemid',$itemid);
		$CI->db->where('wish_user',$user);
		$nums = $CI->db->get('pt_wishlist')->num_rows();
		if($nums > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}if (!function_exists('pt_couponAssigned')) {

	function pt_couponAssigned($couponid, $module, $itemid) {
		$CI = get_instance();

		$CI->db->where('module',$module);
		$CI->db->where('item',$itemid);
		$CI->db->where('couponid',$couponid);
		$nums = $CI->db->get('pt_coupons_assign')->num_rows();
		if($nums > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}if (!function_exists('pt_couponAssignedAllItems')) {

	function pt_couponAssignedAllItems($couponid, $module) {
		$CI = get_instance();

		$CI->db->where('module',$module);
		$CI->db->where('item','all');
		$CI->db->where('couponid',$couponid);
		$nums = $CI->db->get('pt_coupons_assign')->num_rows();
		if($nums > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

}if (!function_exists('pt_couponVerify')) {

	function pt_couponVerify($couponcode, $module, $itemid) {
		$CI = get_instance();
		$current = time();

		if(empty($couponcode) || empty($module) || empty($itemid)){

			$response = array('status' => 'fail', 'couponid' => "", 'value' => "", 'msg' => "Invalid Coupon Code");


		}else{

				//check forever status

			$CI->db->where('code',$couponcode);
			$CI->db->where('status','Yes');
			$CI->db->where('forever','Yes');
			$foreverCheck = $CI->db->get('pt_coupons');

				//check expiry
			$CI->db->where('code',$couponcode);
			$CI->db->where('status','Yes');
			$CI->db->where('startdate <', $current);
			$CI->db->where('expirationdate >', $current);
			$expiryCheck = $CI->db->get('pt_coupons');

			if($foreverCheck->num_rows() > 0 || $expiryCheck->num_rows() > 0){

				if($foreverCheck->num_rows() > 0){
					$cop = $foreverCheck->result();
					$couponid = $cop[0]->id;
					$value = $cop[0]->value;
					$maxuses = $cop[0]->maxuses;
					$used = $cop[0]->uses;

				}elseif($expiryCheck->num_rows() > 0){
					$cop = $expiryCheck->result();
					$couponid = $cop[0]->id;
					$value = $cop[0]->value;
					$maxuses = $cop[0]->maxuses;
					$used = $cop[0]->uses;
				}
				$totalRemain = 1;
				if($maxuses > 0){
					$totalRemain = $maxuses - $used;
				}

				if($totalRemain > 0){

					$CI->db->where('module',$module);
					$CI->db->where('item','all');
					$CI->db->or_where('item',$itemid);
					$CI->db->where('couponid',$couponid);
					$nums = $CI->db->get('pt_coupons_assign')->num_rows();
					if($nums > 0){

						$response = array('status' => 'success', 'couponid' => $couponid, 'value' => round($value,1), 'msg' => "");

					}else{

						$response = array('status' => 'irrelevant', 'couponid' => "", 'value' => "", 'msg' => "This coupon code is not applicable here.");

					}

				}else{

					$response = array('status' => 'fail', 'couponid' => "", 'value' => "", 'msg' => "Invalid Coupon");

				}


			}else{

				$response = array('status' => 'fail', 'couponid' => "", 'value' => "", 'msg' => "Invalid Coupon");

			}

		}



		return json_encode($response);
	}


}if (!function_exists('pt_applyCouponDiscount')) {

	function pt_applyCouponDiscount($couponid, $amount) {

		$CI = get_instance();
		$CI->db->where('id',$couponid);
		$res = $CI->db->get('pt_coupons')->result();

		if(!empty($res)){

			$value = $res[0]->value;

			$amt = $amount * ($value/100);
			$newAmt = $amount - $amt;
			$code = $couponid;

		}else{

			$value = 0;
			$newAmt = $amount;
			$code = 0;
		}



		$result = new stdClass;

		$result->value = $value;
		$result->amount = $newAmt;
		$result->code = $code;


		return $result;


	}

}if (!function_exists('appObj')) {

	function appObj() {

		$CI = get_instance();
		return $CI;


	}

}if (!function_exists('deUrlTitle')) {

	function deUrlTitle($string, $separator = '-') {

		$output = str_replace($separator, ' ', $string);

		return trim($output);
	}

}if (!function_exists('checkUrlParams')) {

	function checkUrlParams($method, $params = array(),$isValidLang) {
		$CI = get_instance();
		$urlBase = $method;

		$result = new stdClass;
		$result->showIndex = FALSE;
		$paramCount = 0;
		if(!empty($params)){
			foreach($params as $p){
				$paramCount++;
				$paramKey = "param".$paramCount;
				$result->$paramKey = $p;
			}
		}
		if($isValidLang){

			if($paramCount > 0){
				$result->countrySlug = $result->param1;
				$result->location = $result->param2;
				$result->itemSlug = $result->param3;
				$urlBase .= '/'.$result->countrySlug;
				if(is_numeric($result->location)){
					$result->offset = $result->location;
					$result->uriSegment = 4;
				}else{
					$urlBase .= '/'.$result->location;
					$result->offset = $result->itemSlug;
					$result->uriSegment = 5;
				}



				if(!empty($result->itemSlug)){
					if(!is_numeric($result->itemSlug)){
						$result->showIndex = TRUE;
					}else{
						$result->showIndex = FALSE;
					}

				}

			}else{
				$result->showIndex = TRUE;
			}



		}else{

			$result->countrySlug = $method;
			if($paramCount > 0){
				$result->location = $result->param1;
				$result->itemSlug = $result->param2;
			}

			if(!empty($result->itemSlug) && !is_numeric($result->itemSlug)){
				$result->showIndex = TRUE;
			}

			if(is_numeric($result->location)){
				$result->offset = $result->location;
				$result->uriSegment = 3;
			}else{
				$urlBase .= '/'.$result->location;
				$result->offset = $result->itemSlug;
				$result->uriSegment = 4;
			}


		}

		if(empty($result->location) || is_numeric($result->location)){
			$CI->load->model('Admin/Countries_model');
			$result->countrySlug = str_replace('+', ' ', $result->countrySlug);
			$countryDetails = $CI->Countries_model->countryDetails($result->countrySlug);
			$result->locations = $countryDetails->locations;
		}else{

			$CI->load->model('Admin/Countries_model');
			$loc = deUrlTitle($result->location);
			$locID = $CI->Countries_model->getLocationID($loc);
			$result->locations = $locID;

		}

		$result->urlBase = $urlBase;

		return $result;

	}

}if (!function_exists('mobileSettings')) {

	function mobileSettings($sKey = null) {

		$result = new stdClass;

		$CI = get_instance();

		if(!empty($sKey)){

			$CI->db->where('settingsKey',$sKey);

		}

		$res = $CI->db->get('pt_mobile_settings')->result();

		if(!empty($res) && !empty($sKey)){

			$result->$sKey = $res[0]->settingsValue;

		}elseif(!empty($res)){
			foreach($res as $r){
				$resKey = $r->settingsKey;
				$result->$resKey = $r->settingsValue;
			}

		}


		return $result;


	}

}
