<?php
class Goibiboflight_lib {
  function __construct() {
    $this->ci =& get_instance();
  }
    function index($param)
    {
        if (!empty($param['origin']) && !empty($param['destination']) && !empty($param['departureDate'])) {
            if($param['triptypename'] == 'round'){
                $date = 'dateofdeparture='.str_replace('-','',$param['departureDate']).'&dateofarrival='.str_replace('-','',$param['return_date']);
            }else{
                $date = 'dateofdeparture='.str_replace('-','',$param['departureDate']);
            }

            $apicall ='http://developer.goibibo.com/api/search/?app_id='.$param['application_id'].'&app_key='.$param['application_key'].'&format=json&source='.$param['origin'].'&destination='.$param['destination'].'&'.$date.'&seatingclass=E&adults='.$param['adult'].'&children='.$param['mchildren'].'&infants='.$param['minfant'].'&counter=100';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL =>$apicall,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));
            $data = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
        }
        return json_decode($data);
    }
}
