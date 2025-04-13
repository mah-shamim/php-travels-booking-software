<?php
header('Access-Control-Allow-Origin: *');
class Payments_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();


    }

    function getAllPaymentsBack()
    {
       $this->load->library('gatewayslib');
       $this->gatewayslib->init();
       $this->gatewayslib->getAllPaymentGateways();
       $data = array(
        "disabledGateways" => $this->gatewayslib->DisabledGateways,
        "activeGateways" => $this->gatewayslib->ActiveGateways,

        );

        return $data;
    }

        function getAllPaymentsBack_formainAPI()
    {
      $this->db->select();
      $this->db->from('payment_gateways');
      $this->db->where('payment_gateways.status',1);
      $this->db->order_by('payment_gateways.order','asc');
      $payment_gateways = $this->db->get()->result();
      $payment_arr = [];
      foreach ($payment_gateways as $pay_key) {
        if ($pay_key->dev == 1) {$pay_key->dev = true;
        }else{$pay_key->dev = false;}
          array_push($payment_arr, array(
            'title'=>str_replace(' ', '-', strtolower($pay_key->name)),
            'c1'=>$pay_key->c1,
            'c2'=>$pay_key->c2,
            'c3'=>$pay_key->c3,
            'c4'=>$pay_key->c4,
            'c5'=>$pay_key->c5,
            'dev'=>$pay_key->dev,
            'dev_endpoint'=>$pay_key->dev_endpoint,
            'pro_endpoint'=>$pay_key->pro_endpoint,
            'order'=>$pay_key->order,
          ));
      }
      return $payment_arr;
//        $this->load->library('gatewayslib');
//        $this->gatewayslib->init();
//        $this->gatewayslib->getAllPaymentGateways();
//        $data = array(
//         "disabledGateways" => $this->gatewayslib->DisabledGateways,
//         "activeGateways" => $this->gatewayslib->ActiveGateways,

//         );
//        usort($data['activeGateways'], function($a, $b) {
//           return $a['order'] - $b['order'];
//           });


//   $payment_arr = [];
//   $title_arr = [];
//   for ($i=0; $i < count($data['activeGateways']); $i++) {
//     $title = str_replace(' ', '-', strtolower($data['activeGateways'][$i]['displayName']));
//     $name = $data['activeGateways'][$i]['name'];
//     array_push($title_arr, array($title));
// }


// foreach ($data['activeGateways'][1]['gatewayValues'] as $k => $v) {
//             if ($k == 'banktransfer') {
//             $add_comma = str_replace("\r\n",",",str_replace(":",",",$data['activeGateways'][1]['gatewayValues'][$k]['instructions']));
//             $bank_cr=explode(",",$add_comma);
//             array_push($payment_arr,(object) array(
//             'title'=>$title_arr[0][0],
//             'c1'=> $bank_cr[1],
//             'c2'=>$bank_cr[3],
//             'c3'=>$bank_cr[5],
//             'c4'=>$bank_cr[7],
//             'c5'=>null,
//             ));
//             }

//             if ($k == 'paylater') {
//             array_push($payment_arr, (object) array(
//             'title'=>$title_arr[1][0],
//             'c1'=>null,
//             'c2'=>null,
//             'c3'=>null,
//             'c4'=>null,
//             'c5'=>null,
//             ));
//             }
//             if ($k == 'paypal') {
//             array_push($payment_arr, (object) array(
//             'title'=>$title_arr[2][0],
//             'c1'=>$data['activeGateways'][1]['gatewayValues'][$k]['email'],
//             'c2'=>null,
//             'c3'=>null,
//             'c4'=>null,
//             'c5'=>null,
//             ));
//             }
//             if ($k == 'stripe') {
//             array_push($payment_arr, (object) array(
//             'title'=>$title_arr[3][0],
//             'c1'=>$data['activeGateways'][1]['gatewayValues'][$k]['secretKey'],
//             'c2'=>$data['activeGateways'][1]['gatewayValues'][$k]['publishableKey'],
//             'c3'=>null,
//             'c4'=>null,
//             'c5'=>null,
//             ));
//             }
//     }
//        return $payment_arr;
    }


    function getGatewayConfigData($gateway){
      $this->load->library('gatewayslib');
      return $this->gatewayslib->getConfigDataOfGateway($gateway);
    }

    function activateGateway($config){
        $type = $config['type'];
        $name = $config[0]['FriendlyName']['Value'];
        $gateway = $config['gateway'];

        $this->db->where('gateway',$gateway);
        $this->db->delete('pt_paymentgateways');

        $this->db->select('order');
        $this->db->order_by('order','desc');
        $result = $this->db->get('pt_paymentgateways')->result();
        $order = $result[0]->order + 1;

        $data1 = array('gateway'=> $gateway, "setting" => "name", "value" => $name,'order' => $order);
        $this->db->insert('pt_paymentgateways', $data1);

        $data2 = array('gateway'=> $gateway, "setting" => "type", "value" => $type,'order' => $order);
        $this->db->insert('pt_paymentgateways', $data2);

        $data3 = array('gateway'=> $gateway, "setting" => "visible", "value" => "on",'order' => $order);
        $this->db->insert('pt_paymentgateways', $data3);

    }

    function deActivateGateway(){

      $newgateway = $this->input->post('gateway');
      $oldgateway = $this->input->post('oldgateway');

      $data = array('booking_payment_type' => $newgateway );
      $this->db->where('booking_payment_type',$oldgateway);
      $this->db->where('booking_status',"unpaid");
      $this->db->update('pt_bookings',$data);

      $this->db->where('gateway',$oldgateway);
      $this->db->delete('pt_paymentgateways');

    }

    function updateGateway(){

       $field = $this->input->post('field');
       $order = $this->input->post('order');
       $gateway = $this->input->post('gateway');
       if(empty($order)){
         $order = 1;
       }

        $this->db->where('gateway',$gateway);
        $this->db->delete('pt_paymentgateways');

       $dd = array(
        'setting' => 'name',
        'value' => $field['name'],
        'gateway' => $gateway,
        'order' => $order
        );

       $this->db->insert('pt_paymentgateways',$dd);

       foreach($field as $key => $val){
        if($key != 'name'){
        $data = array(
                'setting' => $key,
                'value' => $val,
                'gateway' => $gateway,
                'order' => $order

            );
        $this->db->insert('pt_paymentgateways',$data);
          }
       }

       }

       function get_all_payments_front(){
          $this->db->where('payment_status','1');
          $this->db->where('payment_show','1');
    return $this->db->get('pt_payment_gateways')->result();


    }

    function update_gateway(){
     $id = $this->input->post('paymentid');
     $status = $this->input->post('status');
     $name = $this->input->post('gatewayname');
     $testmode = $this->input->post('testmode');
     $devmode = $this->input->post('devmode');
     $apikey = $this->input->post('apikey');
     $password = $this->input->post('paymentpassword');
     $apisignature = $this->input->post('apisignature');
     $username = $this->input->post('username');
     $perfee = $this->input->post('perfee');

     $data = array(
            'payment_status' => $status,
            'payment_name' => $name,
            'payment_testmode' => $testmode,
            'payment_development_mode' => $devmode,
            'payment_apikey' => $apikey,
            'payment_password' => $password,
            'payment_signature' => $apisignature,
            'payment_percentage' => $perfee,
            'payment_username' => $username

     );
    $this->db->where('payment_id',$id);
    $this->db->update('pt_payment_gateways',$data);

    $this->session->set_flashdata('flashmsgs', "Updated Successfully");

    }

    function updateOrder($order,$action){
      $this->db->select('gateway');
      $this->db->where('order',$order);
      $pay = $this->db->get('pt_paymentgateways')->result();
      $gateway = $pay[0]->gateway;
      if($action == "up"){
         $order1 = $order - 1;
      }else{
         $order1 = $order + 1;
      }

      $data1 = array('order' => $order);
      $this->db->where('order',$order1);
      $this->db->update('pt_paymentgateways',$data1);

      $data2 = array('order' => $order1);
      $this->db->where('gateway',$gateway);
      $this->db->update('pt_paymentgateways',$data2);

    }

    function payOnArrivalIsActive($gateways){
      $active = array();
      foreach ($gateways as $gate) { array_push($active,$gate['name']); }
      if(in_array("payonarrival",$active)){
        return true;
      }else{
        return false;
      }
    }

    function onlySinglePaymentGatewayActive($gateways){
      $active = array();
      foreach ($gateways as $gate) { array_push($active,$gate['name']); }
      $count = count($active);
      if($count > 1){
        return array("status" => "no", "name" => "");
      }else{
        return array("status" => "yes", "name" => $active[0]);
      }

    }

    function getGatewayParams($gateway = null){
      $params = array();
      if(!empty($gateway)){
        $this->db->select('setting,value');
        $this->db->where('gateway',$gateway);
        $result = $this->db->get('pt_paymentgateways')->result();
        foreach($result as $res){
            $params[$res->setting] = $res->value;
        }

      }

      return $params;

      }

    function getGatewayMsg($gateway,$invoicvars){
        $this->settings = $this->Settings_model->get_settings_data();

          $params = $this->getGatewayParams($gateway);
          $params['charset'] = "UTF-8";
          $params['invoiceid'] = $invoicvars->id;
          $params['invoiceref'] = $invoicvars->code;
          $params['amount'] = $invoicvars->checkoutAmount;
          $params['currency'] = $invoicvars->currCode;
          $params['description'] = $this->settings[0]->site_title;
          $params['invoiceData'] = $invoicvars;

          $this->load->library('gatewayslib');
          if(!empty($gateway)){
          $msg = $this->gatewayslib->gatewayMsg($gateway,$params);

          }else{
          $msg = "";

          }
          return $msg;

    }

    function hotelstongetGatewayMsg($gateway,$invoicvars){
        $this->settings = $this->Settings_model->get_settings_data();

        $params = $this->getGatewayParams($gateway);
        $params['charset'] = "UTF-8";
        $params['invoiceid'] = $invoicvars->id;
        $params['invoiceref'] = $invoicvars->agentReferenceNumber;
        $params['amount'] = $invoicvars->total_amount;
        $params['currency'] = $invoicvars->currency_code;
        $params['description'] = $this->settings[0]->site_title;
        $params['invoiceData'] = $invoicvars;

        $this->load->library('gatewayslib');
        if(!empty($gateway)){
            $msg = $this->gatewayslib->gatewayMsg($gateway,$params);

        }else{
            $msg = "";

        }
        return $msg;

    }





}
