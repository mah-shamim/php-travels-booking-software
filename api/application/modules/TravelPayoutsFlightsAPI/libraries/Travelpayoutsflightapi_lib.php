<?php
class Travelpayoutsflightapi_lib {
  function __construct() {
    $this->ci =& get_instance();
  } 
  function index($param){
      if (!empty($param['origin']) && !empty($param['destination']) && !empty($param['departureDate'])) {

          if($param['triptypename'] != 'round' ) {
              $sing =md5($param['token'].':localhost:en:' . $param['marker_id'] . ':' . intval($param['adult']) . ':' . intval($param['mchildren']) . ':' . intval($param['minfant']) . ':' . $param['departureDate'] . ':' . $param['destination'] . ':' . $param['origin'] . ':' . $param['class_trip'] . ':110.36.223.2');
              $segments = array((object)[
                  "origin"         => $param['origin'],
                  "destination"        => $param['destination'],
                  "date"         => $param['departureDate']
              ]
              );
          }else{
              $sing =  md5($param['token'].':localhost:en:' . $param['marker_id'] . ':' . intval($param['adult']) . ':' . intval($param['mchildren']) . ':' . intval($param['minfant']) . ':' . $param['departureDate'] . ':' . $param['destination'] . ':' . $param['origin'] . ':' . $param['return_date'] . ':' . $param['origin'] . ':' . $param['destination'] . ':' . $param['class_trip'] . ':110.36.223.2');
              $segments = array((object)[
                  "origin"         => $param['origin'],
                  "destination"        => $param['destination'],
                  "date"         => $param['departureDate']
              ],
              [
                  "origin"         => $param['destination'],
                  "destination"        => $param['origin'],
                  "date"         => $param['return_date']
              ]
              );
          }


          $data_array =  array(
              "signature"        => $sing,
              "marker"        => $param['marker_id'],
              "host"        => 'localhost',
              "user_ip"        => '110.36.223.2',
              "locale"        => 'en',
              "trip_class"        => 'Y',
              "passengers"         => array(
                  "adults"         => intval($param['adult']),
                  "children"        => intval($param['mchildren']),
                  "infants"         => intval($param['minfant'])
              ),
              "segments"         =>$segments,
          );

          $data_string = json_encode($data_array);
          $ch = curl_init( $param['api_endpoint'].'v1/flight_search');
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json'
              )
          );

          $result = curl_exec($ch);
          $data1 = json_decode($result);

          if(!empty($data1)){
              $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL =>$param['api_endpoint'].'v1/flight_search_results?uuid='.$data1->search_id,
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

      }
 return json_decode($data);
}
}