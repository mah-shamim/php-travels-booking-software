<?php
class Pkfareflight_lib {
  function __construct() {
    $this->ci =& get_instance();
  } 
  function index($param)
  {
      if (!empty($param['origin']) && !empty($param['destination']) && !empty($param['departureDate'])) {

          $sing = md5($param['partner_id'].$param['partner_key']);
          if($param['triptypename'] == 'round' ) {
              $data_array = array(
                  "search" => array(
                      "adults" => intval($param['adult']),
                      "children" => intval($param['mchildren']),
                      "infants" => intval($param['minfant']),
                      "nonstop" => 0,
                      "searchAirLegs" => [array(
                          "cabinClass" => 'Economy',
                          "departureDate" => $param['departureDate'],
                          "destination" => $param['destination'],
                          "origin" => $param['origin']
                      ),
                          array( "cabinClass" => 'Economy',
                              "departureDate" => $param['return_date'],
                              "destination" => $param['origin'],
                              "origin" => $param['destination']),
                      ],
                      "solutions" => 0,
                  ),
                  "authentication" => array('partnerId' => $param['partner_id'], 'sign' => $sing),
              );
          }else {
              $data_array = array(
                  "search" => array(
                      "adults" => intval($param['adult']),
                      "children" => intval($param['mchildren']),
                      "infants" => intval($param['minfant']),
                      "nonstop" => 0,
                      "searchAirLegs" => [array(
                          "cabinClass" => 'Economy',
                          "departureDate" => $param['departureDate'],
                          "destination" => $param['destination'],
                          "origin" => $param['origin']
                      ),
                      ],
                      "solutions" => 0,
                  ),
                  "authentication" => array('partnerId' => $param['partner_id'], 'sign' => $sing),
              );
          }
          $data_json = json_encode($data_array);
          $data = base64_encode($data_json);
          $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL =>'https://open.pkfare.com/apitest/shopping?param='.$data,
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
      return json_decode(gzdecode($data));
  }
}