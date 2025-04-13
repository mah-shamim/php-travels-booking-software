<?php
header('Access-Control-Allow-Origin: *');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'modules/Api/libraries/REST_Controller.php';

class Viator extends REST_Controller {
	private $settings;
		function __construct() {
// Construct our parent class
				parent :: __construct();

			 if(!$this->isValidApiKey){
               	$this->response($this->invalidResponse, 400);
            }
// Configure limits on our controller methods. Ensure
// you have created the 'limits' table and enabled 'limits'
// within application/config/rest.php
				$this->methods['list_get']['limit'] = 500; //500 requests per hour per user/key
				$this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
				$this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
				$this->load->library('Hotels/Hotels_lib');
				$this->load->model('Api/Apihotels_model');
                $this->config_api = $this->App->service('ModuleService')->get('Viator')->settings;
                $this->settings = $this->Settings_model->get_settings_data();
				$lang = $this->get('lang');
				$this->Hotels_lib->set_lang($lang);

        }




	function search_get() {


				if (!$this->get('startDate')) {
						$this->response(array('response' => array('error' => 'Check In date is required')), 200);
				}
				if (!$this->get('location')) {
						$this->response(array('response' => array('error' => 'Location is required')), 200);
				}
				if (!$this->get('endDate')) {
						$this->response(array('response' => array('error' => 'Check Out date is required')), 200);
				}
				if (!$this->get('country')) {
						$this->response(array('response' => array('error' => 'Country date is required')), 200);
				}


            if($this->config_api->api_environment == 'sandbox'){
                $endppoint = 'https://viatorapi.viator.com/service/';
            }else{
                $endppoint = $this->config_api->api_endpoint;
            }

            $apikey = $this->config_api->apiKey;

            $location = $this->get('location');
            $startDate = $this->get('startDate');
            $endDate = $this->get('endDate');
            $country = $this->get('country');
            $locate = $country.",".$location;
            $url = $endppoint."search/freetext?apiKey=".$apikey;
            $payload = array("text"=>$locate,"startDate"=>$startDate,"endDate"=>$endDate);
            $headers  = array("Content-Type:application/json");

            $response = $this->curl_call('post',$url,json_encode($payload),$headers);

            $results = json_decode($response);

			if (!empty ($results)){
					$this->response(array('response' => $results, 'error' => array('status' => FALSE,'msg' => '')), 200);

			}else {
			   $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results Not found')), 200);

			}
		}

    function booking_get()
    {
        $uri = explode('/', uri_string());
        $productCodes[] = $this->input->get("code");
        $startDate = str_replace("/",'-',$this->input->get("startDate"));
        $endDate = str_replace("/",'-',$this->input->get("endDate"));
        $secretKey = "380374363657375804";
        $url = "https://viatorapi.viator.com/service/available/products?apiKey=".$secretKey;
        $getPayload = array("productCodes" => $productCodes,"startDate"=>$startDate,"endDate"=>$endDate);
        $headers = array("Content-Type:application/json","Accept:application/json");
        $result = $this->curl_call('post',$url,json_encode($getPayload),$headers);


        $result = json_decode($result);
        if(!empty($result->success))
        {
            $this->response(array('response' => (object)array("url"=>$result->data[0]->webURL ), 'error' => array('status' => FALSE,'msg' => '')), 200);

        }
        else{
            $this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results Not found')), 200);

        }
        die;
    }

    function curl_call($method,$url, $params, $headers = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($method == 'post')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        else
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $url = $url."?".http_build_query($params);
        }
        $content = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return $err;
        } else {
            return $content;
        }
    }


    function suggestions_get(){
		$query = $this->input->get('query');
		$suggestions = $this->Hotels_lib->suggestionResults($query);

		if(empty($query)){
				$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Query missing')), 200);
		}

		if (!empty ($suggestions['forApi']['items'])) {
		$this->response(array('response' => $suggestions['forApi']['items'], 'error' => array('status' => FALSE,'msg' => '')), 200);
		}
		else {
		$this->response(array('response' => '', 'error' => array('status' => TRUE,'msg' => 'Results could not be found')), 200);
		}
		}


		function user_post() {
				$message = array('name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
				$this->response($message, 200); // 200 being the HTTP response code
		}

		function invoice_post() 
        {
            $this->load->model('Admin/Bookings_model');
            $userid = $this->post('userId');
            $payload = $this->post();
            
            if( ! empty($userid) )
            {
                $data = $this->Bookings_model->do_hotels_booking($payload);
            }
            else
            {
                $data = $this->Bookings_model->do_hotels_guest_booking($payload);
            }
            
            $message = array('response' => $data);
            $this->response($message, 200); // 200 being the HTTP response code
        }

        function countries_get() {
          $this->load->model('Admin/Countries_model');
          $list = $this->Countries_model->Api_all_countries();
	    	if (!empty ($list)) {
						$this->response(array('response' => $list, 200)); // 200 being the HTTP response code
				}
				else {
						$this->response(array('response' => array('error' => 'countries could not be found')), 200);
				}
		}

		function show_get($param,$vars = null) {
			$arr = $this->input->get();
			$arrstr = "";
			foreach($arr as $key => $val){
				$arrstr .= $key."=".$val."&";
			}

			 $url = base_url()."api/hotels/".$param."?".$arrstr;
			//	$url = base_url() . "api/hotels/hoteldetails?id=40";
			//  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
			//  $url = base_url()."api/hotels/user";
			$ch = curl_init();
			$timeout = 3;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			@ $json = json_decode($rawdata);
			echo "<pre>";
			print_r($json);
		}

		function chkpost_get() {
// $url = base_url()."api/hotels/list";
// $url = base_url()."api/hotels/hoteldetails?id=40";
//  $url = base_url()."api/hotels/book?id=40&checkin=20/01/2015&checkout=22/01/2015";
				$url = base_url() . "api/hotels/invoice";
				$fields = array('email' => 'mail@example.com', 'firstname' => 'JohnDue', 'room' => "25_250_2", 'checkin' => "12/01/2015", 'checkout' => "15/01/2015", 'lastname' => "JohnDue", 'phone' => "1323", 'address' => "fafdasf", 'payment_type' => 'Paypal_Express', 'id' => "123", 'title' => "hotel name", 'depost' => "123", 'total_amount' => "456", 'tax' => "123456", 'payment_method_tax' => "15", 'nights' => 3);
//url-ify the data for the POST
				foreach ($fields as $key => $value) {
						$fields_string .= $key . '=' . $value . '&';
				}
				rtrim($fields_string, '&');
				$ch = curl_init();
				$timeout = 3;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
				$rawdata = curl_exec($ch);
				curl_close($ch);
				@ $json = json_decode($rawdata);
				echo "<pre>";
				print_r($json);
		}

}
