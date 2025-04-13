<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

ini_set('display_errors', 0);

class Pkfarehotel extends MX_Controller
{
    const Module = "Pkfarehotel";
    private $config = [];

    public function __construct()
    {
        parent :: __construct();

        modules::load('Front');
        $this->data['phone'] = $this->load->get_var('phone');
		$this->data['contactemail'] = $this->load->get_var('contactemail');
		$this->data['usersession'] = $this->session->userdata('pt_logged_customer');
		$this->data['appModule'] = "hotelston";
		$languageid = $this->uri->segment(2);
		$this->validlang = pt_isValid_language($languageid);
		if( $this->validlang ) {
			$this->data['lang_set'] =  $languageid;
		} else {
			$this->data['lang_set'] = $this->session->userdata('set_lang');
		}
		$defaultlang = pt_get_default_language();
		if ( empty($this->data['lang_set']) ) {
			$this->data['lang_set'] = $defaultlang;
		}
		// For menu `HOME` and `My Account` link in header.
		$this->lang->load("front", $this->data['lang_set']);
        $this->config = $this->App->service('ModuleService')->get(self::Module)->apiConfig;

        $user_id = $this->session->userdata('pt_logged_customer');
        $this->data['userAuthorization'] = (isset($user_id) && ! empty($user_id)) ? 1 : 0;
		$this->data['pageTitle'] = "Hotels List";
    }
    public function search()
    {
//        $args = explode('/',  $this->uri->uri_string());
//        $sing = md5($this->config->partner_id.$this->config->partner_key);
//        $data_array = array(
//            "request" => array(
//                "checkInDate" => $this->uri->segment(5),
//                "checkOutDate" => $this->uri->segment(6),
//                "regionId" => '597',
//                "numberOfAdult" => $this->uri->segment(7),
//                "numberOfRoom" => 1,
//                "languageCode" => 'en_US',
//            ),
//            "authentication" => array('partnerId' => $this->config->partner_id, 'sign' => $sing),
//        );
//        $get_data = (json_encode($data_array));
//
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://testhotelapi.pkfare.com/hotel/queryHotelList",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => $get_data,
//            CURLOPT_HTTPHEADER => array(
//                "cache-control: no-cache",
//                "content-type: application/json",
//                "postman-token: aaceaec8-819e-ac60-268b-b07886fbcf2c"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        $hotelid  = json_decode($response);
//        if(!empty($hotelid)){
            $sing = md5($this->config->partner_id.$this->config->partner_key);
            $data_array = array(
                "request" => array(
                    "hotelId" => '240915',
                    "languageCode" => 'en_US',
                ),
                "authentication" => array('partnerId' => $this->config->partner_id, 'sign' => $sing),
            );

            dd(json_encode($data_array));
       // }

	}



}