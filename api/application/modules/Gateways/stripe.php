<?php

require_once(dirname(__FILE__) . "/stripe-php/init.php");
require_once(dirname(__FILE__) . "/stripe-php/lib/Stripe.php");



function stripe_config() {
    $configarray = array(
     "FriendlyName" => array("Type" => "System", "Value"=>"Stripe"),
     "secretKey" => array("FriendlyName" => "Secret Key", "Type" => "text", "Size" => "40", ),
     "publishableKey" => array("FriendlyName" => "Publishable Key", "Type" => "text", "Size" => "40", ) 
    );
	return $configarray;
}

function stripe_capture($params) {
  try {
      $currency = $params['currency'];

      \Stripe\Stripe::setApiKey($params['secretKey']);
      if($params['cardnum']) {
	  
	    // convert stored cc to stripe stored cc
	    $whmcs_client_id = $params['clientdetails']['id'];
	    $cchash = md5($cc_encryption_hash.$whmcs_client_id);
	    $firstname = $params['firstname'];
	    $lastname = $params['lastname'];
	    $email = $params['email'];
	   // $address1 = $params['address1'];
	   // $address2 = $params['address2'];
	    //$city = $params['city'];
	   // $state = $params['state'];
	   // $postcode = $params['postcode'];
	    //$country = $params['country'];
        $card = array("number" => $params['cardnum'],
        "exp_month" => $params['expMonth'],
        "exp_year" => $params['expYear'],
        "name" => $firstname . " " . $lastname,
        "cvc" => $params['cccvv'],
       /* "address_line1" => $address1,
        "address_line2" => $address2,
        "address_zip" => $postcode,
        "address_state" => $state,
        "address_city" => $city,
        "address_country" => $country*/

        );

          $result = \Stripe\Token::create(array(
              "card" => array(

                  "number" => $params['cardnum'],
                  "exp_month" => $params['expMonth'],
                  "exp_year" => $params['expYear'],
                  "cvc" => $params['cccvv']
              )
          ));
          $token = $result['id'];
	   // $stripe_customer =  \Stripe\Customer::create(array("email" => $email,"card" => $card));
	    //$card = $stripe_customer->sources->retrieve($stripe_customer->default_source);
	   
        
        $charge = \Stripe\Charge::create(array(
		    "amount" => $params['amount']*100,
		    "currency" => $currency,
            "source" => $token,
            "description" => "Payment of Invoice #" . $params['invoiceid'])
		  );
		  
		  if ($charge->paid == true) {

  		/*  $balance_transaction = \Stripe\BalanceTransaction::retrieve($charge->balance_transaction);
		    $fee = $balance_transaction->fee / 100;*/

        $result = array("status" => "success","invoiceid" => $params['invoiceid'],"paid" => $params['amount'],"transactionid" => $charge->id,"msg" => "");
        return $result; 
		  
      }
		  else {
       $result = array("status" => "fail","invoiceid" => "","paid" => 0,"transactionid" => 0,"msg" => $charge->failure_message);

      return $result; 

		  }
        
	    
	  }
	  else {

    $result = array("status" => "fail","invoiceid" => "","paid" => 0,"transactionid" => 0,"msg" => "Error Occurred Please Try again Later");

    return $result; 
	  }
 
  }
  catch (Exception $e) {
    $body = $e->getJsonBody();
    $error_message = $body["error"]["message"];
    $result = array("status" => "fail","invoiceid" => "","paid" => 0,"transactionid" => 0,"msg" => $error_message);

    return $result; 
  }

}