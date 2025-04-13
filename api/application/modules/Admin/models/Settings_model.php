<?php

class Settings_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

		//Check Ip
        function get_ip($ip){
		    $this->db->select('status');
		    $this->db->where('ip',$ip);
            $q = $this->db->get('pt_banip');
           return $q->row();
        }
		function get_settings_data() {
			$q = $this->db->get('pt_app_settings');
			return $q->result();
		}

// update seo settings
		function update_seo_settings() {
				$data = array('keywords' => $this->input->post('keywords'), 'meta_description' => $this->input->post('meta_description'), 'home_title' => $this->input->post('slogan'));
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

// update Js settings
		function update_js() {
			//'javascript' => $this->input->post('jcode')
				$data = array('google' => $this->input->post('gacode'));
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

// update general settings
		function update_settings() {
				$dateformat = $this->input->post('pt_date_format');
				$expiry = $this->input->post('bookingexpiry');
				$cancel = $this->input->post('bookingcancel');
				$codelength = $this->input->post('codelength');
				$mapApi = $this->input->post('mapapi');


				if ($codelength > 8 || $codelength < 4) {
						$codelength = 4;
				}
				if ($cancel < 1) {
						$cancel = 1;
				}
				if ($expiry < 1) {
						$expiry = 1;
				}
				if ($dateformat == "d/m/Y") {
						$jsdate = "dd/mm/yyyy";
				}
				elseif ($dateformat == "m-d-Y") {
						$jsdate = "mm-dd-yyyy";
				}
				elseif ($dateformat == "m/d/Y") {
						$jsdate = "mm/dd/yyyy";
				}
				elseif ($dateformat == "Y/m/d") {
						$jsdate = "yyyy/mm/dd";
				}
				elseif ($dateformat == "d-m-Y") {
						$jsdate = "dd-mm-yyyy";
				}
				elseif ($dateformat == "Y-m-d") {
						$jsdate = "yyyy-mm-dd";
				}
				$galleryApprove = "1";//$this->input->post('gallery');
				$sslUrl = 0; //$this->input->post('ssl_url');
				$data = array(
                    'offline_message' => $this->input->post('offlinemsg'),
                    'rss' => $this->input->post('rss'),
                    'default_theme' => $this->input->post('theme'),
                    'site_offline' => intval($this->input->post('site_offine')),
                    'site_title' => $this->input->post('site_title'),
					'site_url' => $this->input->post('site_url'),
                    'ssl_url' => $sslUrl,
                    'license_key' => $this->input->post('license'),
                    'site_name' => $this->input->post('site_name'),
                    'tag_line' => $this->input->post('tag_line'),
					'address' => $this->input->post('address'),
                    'phone' => $this->input->post('phone'),
                    'copyright' => $this->input->post('copyright'),
                    'reviews' => $this->input->post('reviews'),
                    'gallery_approve' => $galleryApprove,
                    'video_uploads' => $this->input->post('videouploads'),
					'default_lang' => $this->input->post('default_lang'),
                    'multi_lang' => intval($this->input->post('multi_lang')),
                    'default_city' => $this->input->post('default_city'),
                    'date_f' => $dateformat, 'date_f_js' => $jsdate,
                    'booking_expiry' => $expiry,
                    'booking_cancellation' => $cancel,
					'coupon_code_length' => $codelength,
                    'coupon_code_type' => $this->input->post('coupon_code_type'),
                    'searchbox' => $this->input->post('searchbox'),
                    'allow_registration' => intval($this->input->post('allow_registration')),
                    'user_reg_approval' => $this->input->post('user_reg_approval'),
					'allow_supplier_registration' => intval($this->input->post('allow_supplier_registration')),
					'allow_agent_registration' => intval($this->input->post('allow_agent_registration')),
                    'multi_curr' => intval($this->input->post('multicurr')),
                    'updates_check' => intval($this->input->post('updates')),
                    'restrict_website' => $this->input->post('restrict'),
                    'mapApi' => $mapApi );
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
               	$this->session->set_flashdata('flashmsgs', "Updated Successfully");

		}

// update security settings
		function update_security() {
				$data = array('secure_admin_key' => $this->input->post('secure_admin_key'), 'secure_admin_status' => intval($this->input->post('secure_admin_status')), 'secure_supplier_key' => $this->input->post('secure_supplier_key'), 'secure_supplier_status' => intval($this->input->post('secure_supplier_status')));
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

// end update security settings
// update currency settings
		function update_currency_code() {
				$data = array('currency_sign' => $this->input->post('currency_sign'), 'currency_code' => $this->input->post('currency_code'), 'multi_curr' => $this->input->post('multicurr'));
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

// get all currencies
		function get_currencies() {
				return $this->db->get('pt_currencies')->result();
		}

// get all currencies
		function get_currencies_front() {
				$this->db->where('is_active', 'Yes');
				return $this->db->get('pt_currencies')->result();
		}

//get mulitple currenices statys show/not show
		function get_curr_status() {
				$this->db->select('multi_curr');
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->result();
				if ($res[0]->multi_curr == '1') {
						return true;
				}
				else {
						return false;
				}
		}

// update currencies status
		function udpate_currencies($id) {
				$data = array('currency_status' => '1');
				$this->db->where('currency_id', $id);
				$this->db->update('pt_currencies', $data);
		}

// update other currencies status to 0
		function change_currencies_status($all) {
				$data = array('currency_status' => '0');
				$this->db->where_not_in('currency_id', $all);
				$this->db->update('pt_currencies', $data);
		}
// make a currency default
		function makeCurrencyDefault($id) {



        $dd = array(
                'is_default' => 'No'
                );
				$this->db->where('is_default', 'Yes');
				$this->db->update('pt_currencies',$dd);

        $d = array(
                'is_default' => 'Yes'
                );
				$this->db->where('id', $id);
				$this->db->update('pt_currencies',$d);


		$info = $this->getCurrencyInfo($id);

		$data = array('currency_sign' => $info->symbol, 'currency_code' => $info->code);
		$this->db->where('user', 'webadmin');
		$this->db->update('pt_app_settings', $data);


		}

//Delete Currency
		function deleteCurrency($id){
			$this->db->where('id',$id);
			$this->db->delete('pt_currencies');

		}

// date format saved in database
		function show_date_format() {
				$this->db->select('date_f,date_f_js');
				$res = $this->db->get('pt_app_settings')->result();
				return $res;
		}

// update header, footer logos and favicon image
		function update_logos($type, $filename) {
				if ($type == "hlogo") {
						$colname = "header_logo_img";
						$oldhlogo = $this->input->post('oldhlogo');
						if ($oldhlogo == $filename) {
						}
						else {
								if (!empty ($oldhlogo)) {
										@ unlink(PT_GLOBAL_UPLOADS_FOLDER . $oldhlogo);
								}
						}
				}
				elseif ($type == "flogo") {
						$colname = "footer_logo_img";
						$oldflogo = $this->input->post('oldflogo');
						if ($oldflogo == $filename) {
						}
						else {
								if (!empty ($oldflogo)) {
										@ unlink(PT_GLOBAL_UPLOADS_FOLDER . $oldflogo);
								}
						}
				}
				elseif ($type == "favimg") {
						$colname = "favicon_img";
						$oldfav = $this->input->post('oldfav');
						if ($oldfav == $filename) {
						}
						else {
								if (!empty ($oldfav)) {
										@ unlink(PT_GLOBAL_UPLOADS_FOLDER . $oldfav);
								}
						}
				}
				$data = array($colname => $filename);
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

// get watermark settings
		function get_watermark_data() {
				$this->db->where('wm_name', 'wmark');
				return $this->db->get('pt_watermark')->result();
		}

// update watermark data
		function update_watermark_data() {
				//$fcolor = $this->input->post('font_color');
				//$fontcolor = str_replace("#", "", $fcolor);
				$data = array('wm_type' => "img", 'wm_position' => $this->input->post('img_position'), 'wm_trans' => "0", 'wm_text' => "test", 'wm_font_color' => "fff", 'wm_font_size' => "12",'wm_image' => 'watermark.png', 'wm_status' => $this->input->post('wm_status'));
				$this->db->where('wm_name', 'wmark');
				$this->db->update('pt_watermark', $data);
		}

// get admin gallery approvals option
		function admin_gallery_approvals() {
				$this->db->select('gallery_approve');
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->result();
				$isadmin = $this->session->userdata('pt_logged_admin');
				if (empty ($isadmin)) {
						return $res[0]->gallery_approve;
				}
				else {
						return '1';
				}
		}

// Is upload allowed to server
		function upload_allowed() {
				$this->db->select('video_uploads');
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->result();
				return $res[0]->video_uploads;
		}

		public function render($context, $post) {
				return preg_replace_callback('/{(.*?)}/',

				function ($v) use ($context) {
						return isset ($context[$v[1]]) ? $context[$v[1]] : '';
				}
				, $post );
		}

// get contact page details
		function get_contact_page_details() {
				return $this->db->get('pt_contact_page')->result();
		}

// Update contact page details
		function update_contact_page_details() {
				$data = array(
				//	'contact_long' => $this->input->post('contact_long'),
				//	'contact_lat' => $this->input->post('contact_lat'),
					'contact_address' => $this->input->post('contact_address'),
					'contact_country' => $this->input->post('contact_country'),
					'contact_city' => $this->input->post('contact_city'),
					'contact_phone' => $this->input->post('contact_phone'),
					'contact_email' => $this->input->post('contact_email'),);
				$this->db->where('contact_id', $this->input->post('contact_page_id'));
				$this->db->update('pt_contact_page', $data);
		}

// get default theme
		function get_theme() {
				$this->db->select('default_theme');
				$this->db->where('user', 'webadmin');
				$res = $this->db->get('pt_app_settings')->result();
				return $res[0]->default_theme;
		}

// remove theme
		function remove_theme() {
				$theme = $this->input->post('themename');
				$currtheme = $this->get_theme();
				if ($theme == $currtheme) {
						$data = array('default_theme' => 'default');
						$this->db->where('user', 'webadmin');
						$this->db->update('pt_app_settings', $data);
				}
				$this->rrmdir('themes/' . $theme);
		}

// Select theme
		function select_theme() {
				$theme = $this->input->post('themename');
				$this->session->set_userdata('pt_theme_preview', $theme);
				$data = array('default_theme' => $theme);
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

// recursive funciton to delete all files and directory in the directory and then the directory also
		function rrmdir($path) {
// Open the source directory to read in files
				$i = new DirectoryIterator($path);
				foreach ($i as $f) {
						if ($f->isFile()) {
								unlink($f->getRealPath());
						}
						else
								if (!$f->isDot() && $f->isDir()) {
										$this->rrmdir($f->getRealPath());
								}
				}
				rmdir($path);
		}

// update front settings
		function update_front_settings() {
				$ufor = $this->input->post('updatefor');
				$data = array('front_icon' => $this->input->post('page_icon'), 'front_homepage' => $this->input->post('home'), 'front_homepage_order' => $this->input->post('order'), 'front_popular' => $this->input->post('popular'), 'front_popular_order' => $this->input->post('popularorder'), 'front_latest' => $this->input->post('latest'), 'front_listings' => $this->input->post('listings'), 'front_listings_order' => $this->input->post('listingsorder'), 'front_search' => $this->input->post('searchresult'), 'front_search_order' => $this->input->post('searchorder'), 'front_search_min_price' => $this->input->post('minprice'), 'front_search_max_price' => $this->input->post('maxprice'), 'front_checkin_time' => $this->input->post('checkin'), 'front_checkout_time' => $this->input->post('checkout'), 'front_txtsearch' => '1', 'front_tax_percentage' => $this->input->post('taxpercentage'), 'front_tax_fixed' => $this->input->post('taxfixed'), 'front_search_state' => $this->input->post('state'), 'front_sharing' => $this->input->post('sharing'), 'linktarget' => $this->input->post('target'), 'header_title' => $this->input->post('headertitle'));
				$this->db->where('front_for', $ufor);
				$this->db->update('pt_front_settings', $data);
				$this->session->set_flashdata('flashmsgs', "Updated Successfully");
		}

// get settings data
		function get_front_settings($ufor) {
				$this->db->where('front_for', $ufor);
				return $this->db->get('pt_front_settings')->result();
		}

		// get others_settings data
    function others_settings($ufor){
        $this->db->where('name', $ufor);
        return $this->db->get('modules')->result();
    }

// Get default check-in check-out time
		function get_default_checkin_out() {
				$this->db->select('front_checkin_time,front_checkout_time,front_for');
				$this->db->where('front_for', 'hotels');
				return $this->db->get('pt_front_settings')->result();
		}

// Install Theme .zip folder only
		function pt_install_theme() {
				if ($_FILES["zip_file"]["name"]) {
						$msg = "";
						$filename = $_FILES["zip_file"]["name"];
						$source = $_FILES["zip_file"]["tmp_name"];
						$type = $_FILES["zip_file"]["type"];
						$i = strrpos($filename, ".");
						if (!$i) {
								return "";
						}
						$l = strlen($filename) - $i;
						$ext = substr($filename, $i + 1, $l);
						if ($ext == "zip") {
								$target_path = "themes/" . $filename; // change this to the correct site path
								if (move_uploaded_file($source, $target_path)) {
										$zip = new ZipArchive();
										$x = $zip->open($target_path);
										if ($x === true) {
												$zip->extractTo("themes/"); // change this to the correct site path
												$zip->close();
												unlink($target_path);
										}
										$msg = "Theme has been uploaded successfully.";
								}
								else {
										$msg = "There was a problem with the upload. Please try again.";
								}
						}
						else {
								$msg = "Only .zip files allowed";
						}
						return $msg;
				}
		}

// Get all countries
		function get_all_countries() {
				//countries.json
		}

// get facebook settings
		function get_facebook_settings() {
				return $this->db->get('pt_fb_settings')->result();
		}

// update facebook settings
		function update_facebook_settings() {
				$data = array('app_id' => $this->input->post('appid'), 'app_secret' => $this->input->post('appsecret'), 'status' => $this->input->post('fbstatus'));
				$this->db->where('id', $this->input->post('fbid'));
				$this->db->update('pt_fb_settings', $data);
		}

// get facebook login status
		function facebook_login_status() {
				$res = $this->db->get('pt_fb_settings')->result();
				if ($res[0]->status == "1") {
						return true;
				}
				else {
						return false;
				}
		}

// update Mobile settings
		function update_mobile_settings() {
				$data = array('default_gateway' => $this->input->post('defaultgateway'));
				$this->db->where('user', 'webadmin');
				$this->db->update('pt_app_settings', $data);
		}

		function getSearchbox() {
				$this->db->select('searchbox');
				$rs = $this->db->get('pt_app_settings')->result();
				return $rs[0]->searchbox;
		}

// make a currency default
		function getDefaultCurrency() {
		        $result = array();
                $this->db->where('is_default', 'Yes');
				$rs = $this->db->get('pt_currencies')->result();
                $result = array('symbol' => $rs[0]->symbol,'code' => $rs[0]->code,'name' => $rs[0]->name,'rate' => $rs[0]->rate);
                return $result;
		}

// get currency info
		function getCurrencyInfo($id) {
		        $result = array();
                $this->db->where('id', $id);
				$rs = $this->db->get('pt_currencies')->result();
                $result = (object)array('symbol' => $rs[0]->symbol,'code' => $rs[0]->code,'name' => $rs[0]->name,'rate' => $rs[0]->rate);
                return $result;
		}

//Multi Currency Status
		function multiCurrencyStatus() {
				$this->db->select('multi_curr');
				$rs = $this->db->get('pt_app_settings')->result();
                if($rs[0]->multi_curr == '0'){
                  return false;
                }else{
                  return true;
                }

		}
		
	//change currecy
	function changeCurrency($id)
	{
		// Get sepecified currency from table.
		$this->db->where('id',$id);
		$dataset = $this->db->get('pt_currencies')->row();
		
//		// Update the `default flag` in currencies table
//		$this->db->set('is_default', 'No');
//		$this->db->update('pt_currencies');
//
//		$this->db->where('id', $id);
//		$this->db->update('pt_currencies', array(
//			'is_default' => 'Yes'
//		));
//
//		// Update default app currency
//		$this->db->update('pt_app_settings', array(
//			'currency_sign' => $dataset->symbol,
//			'currency_code' => $dataset->code
//		));

		// Store in session
		$this->session->set_userdata('currencycode', $dataset->code);
		$this->session->set_userdata('currencysymbol', $dataset->symbol);
		$this->session->set_userdata('currencyname', $dataset->name);
		$this->session->set_userdata('currencyrate', $dataset->rate);
	}

	/* Get All Currceny and Update Currceny rate*/
	public function all_currencies()
    {
       return $this->db->get('pt_currencies')->result();
    }
    public function curency_by_id($id)
    {
       return $this->db->where("id",$id)->get('pt_currencies')->row_array();
    }
    public function update($id,$array)
    {
        unset($array["id"]);
       return $this->db->where("id",$id)->update('pt_currencies',$array);
	}
	
	public function defaultcurrency(){
		$this->db->where('is_default','Yes');
		$this->db->select('*');
		$q = $this->db->get('pt_currencies');
		//print_r($q->num_rows());die;
		if($q->num_rows() == 0){
			$this->db->where('id','1');
			$this->db->set('is_default','Yes');
			$this->db->update('pt_currencies');
				
			}
		}

		/*get slider for main api*/
		 function active_slider()
		{
			$this->db->where('slide_status','Yes');
			$this->db->select('*');
			return $this->db->get('pt_sliders')->result();
		}

		/*get payment_gat for main api*/
	    function payment_gateways()
	    {
	      $payment_arr = [];
	      $files = glob("./application/modules/Gateways/*.php");
	      foreach($files as $file) {
	       $filename = explode('/', $file);
	       array_push($payment_arr, (object)array('title'=>strtolower(pathinfo($filename[4], PATHINFO_FILENAME))));
	   		}
	   		return $payment_arr;
	    }

}

