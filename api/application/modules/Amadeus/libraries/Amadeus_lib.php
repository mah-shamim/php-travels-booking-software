<?php
class Amadeus_lib {
  function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model('Amadeus/Amadeus_model');
  } 
  function index($param){
    if (!empty($param['origin']) && !empty($param['destination']) && !empty($param['departureDate']) && !empty($param['totalpassengers']) && !empty($param['class_type'])) {
      if (date('Y-m-d',strtotime($param['departureDate'])) < date('Y-m-d')) {
        ($param['triptypename'] == 'round')?$return_date = $param['return_date']:$return_date = "";
        $data = array(
          'error'=> 'Departure Date must be equal and greater than today.',
          'origin' => $param['origin'],
          'destination' => $param['destination'],
          'departureDate' => $param['departureDate'],
          'totalpassengers' => $param['totalpassengers'],
          'madult' => intval($param['madult']),
          'mchildren' => intval($param['madult']),
          'minfant' => intval($param['minfant']),
          'seniors' => intval($param['seniors']),
          'triptypename' => $param['triptypename'],
          'return_date' => $param['return_date'],
          'class_type' => $param['class_type'],
          'nonStop' => $param['nonStop'],
          'currency' => $param['currency'],
          'currencysymbol' => $param['currencysymbol'],
          'include' => $param['include'],
          'commission' => $param['commission'],
          'flight_data' =>""
        );
      }
      else {
        $current_time = date("m/d/Y h:i:s a", time());
        if ($current_time > $this->ci->session->userdata('access_token_time')) {
          $this->ci->session->unset_userdata('access_token');
          $this->ci->session->unset_userdata('access_token_time');
          $secret_data = $this->ci->Amadeus_model->get_sercet_keys();
          $api_credentials =  json_decode($secret_data,true);
          $grant_type = 'client_credentials';
          $client_id = $api_credentials['apiConfig']['client_id'];
          $client_secret = $api_credentials['apiConfig']['client_secret'];
          if (empty($client_id) || empty($client_secret)) {
            $data = array(
              'error'=> 'Please check API Settings',
              'origin' => $param['origin'],
              'destination' => $param['destination'],
              'departureDate' => $param['departureDate'],
              'totalpassengers' => $param['totalpassengers'],
              'madult' => intval($param['madult']),
              'mchildren' => intval($param['madult']),
              'minfant' => intval($param['minfant']),
              'seniors' => intval($param['seniors']),
              'triptypename' => $param['triptypename'],
              'return_date' => $param['return_date'],
              'class_type' => $param['class_type'],
              'nonStop' => $param['nonStop'],
              'commission' => $param['commission'],
              'currency' => "USD",
              'currencysymbol' => $param['currencysymbol'],
            );
          } else {
            $data = 'grant_type='.$grant_type.'&client_id='.$client_id.'&client_secret='.$client_secret;
            $ch = curl_init('https://test.api.amadeus.com/v1/security/oauth2/token');                               
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $token = curl_exec($ch);
            $token = json_decode($token,true);
            if (!empty($token['error'])) {
             $data = array(
              'error'=> 'Please check API Settings',
              'origin' => $param['origin'],
              'destination' => $param['destination'],
              'departureDate' => $param['departureDate'],
              'totalpassengers' => $param['totalpassengers'],
              'madult' => intval($param['madult']),
              'mchildren' => intval($param['madult']),
              'minfant' => intval($param['minfant']),
              'seniors' => intval($param['seniors']),
              'triptypename' => $param['triptypename'],
              'return_date' => $param['return_date'],
              'class_type' => $param['class_type'],
              'nonStop' => $param['nonStop'],
              'commission' => $param['commission'],
              'currency' => $param['currency'],
              'currencysymbol' => $param['currencysymbol'],
            );   
           } else {
            //set sessions of token so it can be reused again.
            $this->ci->session->set_userdata('access_token',$token['access_token']);
            $this->ci->session->set_userdata('access_token_time',date("m/d/Y h:i:s a", time()+ $token['expires_in']));
          }
        }
      }
      // now get data from amadeus
      if (empty($data['error'])) {
        if ($param['triptypename'] == 'round') {
          $return ='&returnDate='.$param['return_date'];
        } else {
          $return = '';
        }
        if ($param['include'] == 0) {
            $exclude_airline  = "";
        } else {
          $exclude_airline = '&includeAirlines'.$param['include'];
        }
        $api_url = 'https://test.api.amadeus.com/v1/shopping/flight-offers?origin='.$param['origin'].'&destination='.$param['destination'].'&departureDate='.$param['departureDate'].$return.'&adults='.$param['madult'].'&children='.$param['mchildren'].'&infants='.$param['minfant'].'&seniors='.$param['seniors'].'&travelClass='.$param['class_type']."&nonStop=".$param['nonStop']."&currency=".$param['currency']."&max=500".$exclude_airline;

        $ch = curl_init($api_url);                                       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('header' => "Authorization: Bearer " . $this->ci->session->userdata('access_token')));
        $result = curl_exec($ch);
        $data_flights = json_decode($result, true);
        $data = array(
          'error'=> '',
          'origin' => $param['origin'],
          'destination' => $param['destination'],
          'departureDate' => $param['departureDate'],
          'totalpassengers' => $param['totalpassengers'],
          'madult' => intval($param['madult']),
          'mchildren' => intval($param['madult']),
          'minfant' => intval($param['minfant']),
          'seniors' => intval($param['seniors']),
          'triptypename' => $param['triptypename'],
          'return_date' => $param['return_date'],
          'class_type' => $param['class_type'],
          'nonStop' => $param['nonStop'],
          'currency' => $param['currency'],
          'currencysymbol' => $param['currencysymbol'],
          'commission' => $param['commission'],
          'flight_data' =>$data_flights
        );
      }
    } 
  } else {
    $data = array(
      'error'=> 'Please fill all the fields propely.',
      'origin' => $param['origin'],
      'destination' => $param['destination'],
      'departureDate' => $param['departureDate'],
      'totalpassengers' => $param['totalpassengers'],
      'madult' => intval($param['madult']),
      'mchildren' => intval($param['madult']),
      'minfant' => intval($param['minfant']),
      'seniors' => intval($param['seniors']),
      'triptypename' => $param['triptypename'],
      'return_date' => $param['return_date'],
      'class_type' => $param['class_type'],
      'nonStop' => $param['nonStop'],
      'commission' => $param['commission'],
      'currency' => $param['currency'],
      'currencysymbol' => $param['currencysymbol'],
    );
  }
  return json_encode($data);
}
}