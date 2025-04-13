<?php

require("../../../init.php");
require("../../../includes/functions.php");
require("../../../includes/gatewayfunctions.php");
require("../../../includes/invoicefunctions.php");
require_once("init.php");


if (isset($_SESSION['uid'])) {
   $whmcs_client_id = $_SESSION['uid'];
   $result = select_query("tblclients","gatewayid,email", array("id" => $whmcs_client_id));
   $customer_data = mysql_fetch_array($result);
   $gateway_id = $customer_data['gatewayid'];
   $cchash = md5($cc_encryption_hash.$whmcs_client_id);
   $email = $customer_data['email'];;
   global $CONFIG;
   $systemurl = ($CONFIG['SystemSSLURL']) ? $CONFIG['SystemSSLURL'].'/' : $CONFIG['SystemURL'].'/';

   $result = select_query("tblpaymentgateways","value", array("gateway" => "stripe","setting" => "secretKey"));
   $gateway_data = mysql_fetch_array($result);
   
   $country_code_check = get_query_val("tblpaymentgateways","value", array("gateway" => "stripe", "setting" => "countryCodeCheck"));

   try {
	   \Stripe\Stripe::setApiKey($gateway_data['value']);
	   
	   $create_new_customer = true;
	   	   
	   if ($gateway_id != null && $gateway_id != '') {
	     try {
	       $stripe_customer = \Stripe\Customer::retrieve($gateway_id);
	       $create_new_customer = false;
	       if ($stripe_customer->deleted) {
		       $create_new_customer = true;
	       }
	     }
	     catch (Exception $e) {
		   $create_new_customer = true;
	     }
	     
	   }
	   if ($create_new_customer) {
	       
		   $stripe_customer =  \Stripe\Customer::create(array(
	                           "email" => $email,
	                           "card" => $_REQUEST['stripeToken']));
	      
	                        
	       $client_record_query = select_query("tblclients","billingcid,country", array("id" =>$_SESSION['uid']));
           $client_record = mysql_fetch_array($client_record_query);
           $client_country = "";
  
         
           if ($client_record["billingcid"] != 0 ) {
             $billing_contact_query = select_query("tblcontacts","country", array("id" => $client_record["billingcid"]));
             $billing_contact = mysql_fetch_array($billing_contact_query);
             $client_country = $billing_contact["country"];  
           }
           else {
            $client_country = $client_record["country"];
           }
   
           $card = $stripe_customer->sources->retrieve($stripe_customer->default_source);
	        
           if ($country_code_check != "on" || $client_country == $card->country ) {
  	         $exp_date = $_REQUEST['ccexpirymonth'].substr($_REQUEST['ccexpiryyear'],-2);
	         full_query("UPDATE tblclients set expdate = AES_ENCRYPT('".$exp_date."','". $cchash. "') WHERE id = ". $whmcs_client_id);
	         update_query("tblclients", array("cardtype" => $card->brand, "gatewayid" =>$stripe_customer->id,"cardlastfour" => $card->last4), array("id" => $whmcs_client_id));
  	       }
	       else {
		     if (!isset($_POST['invoiceid'])) {
    	       logTransaction($gateway_name["value"],"Country Code does not match billing address country Customer ID:" . $_SESSION['uid'],"Error"); 
               header( 'Location: '.$systemurl.'clientarea.php?action=creditcard&error=1');
             }
	         else {
		       logTransaction($gateway_name["value"],"Country Code does not match billing address country, Invoice #" . $_POST['invoiceid'] . " Customer ID:" . $_SESSION['uid'],"Error"); 
		       echo "error";
	         }
		 }	     
	       
	   }
	   else {
		 // update existing customer  
		 $stripe_customer = \Stripe\Customer::retrieve($gateway_id);
	     $stripe_customer->card = $_REQUEST['stripeToken'];
	     $stripe_customer->save();
	     
	     $card = $stripe_customer->sources->retrieve($stripe_customer->default_source);
	     
	     $client_record_query = select_query("tblclients","billingcid,country", array("id" => $_SESSION['uid']));
         $client_record = mysql_fetch_array($client_record_query);
         $client_country = "";
  
         if ($client_record["billingcid"] != 0 ) {
           $billing_contact_query = select_query("tblcontacts","country", array("id" => $client_record["billingcid"]));
           $billing_contact = mysql_fetch_array($billing_contact_query);
           $client_country = $billing_contact["country"];  
         }
         else {
          $client_country = $client_record["country"];
         }
         
         if ($country_code_check != "on" || $client_country == $card->country ) {
	       $exp_date = $_REQUEST['ccexpirymonth'].substr($_REQUEST['ccexpiryyear'],-2);
	       full_query("UPDATE tblclients set expdate = AES_ENCRYPT('".$exp_date."','". $cchash. "') WHERE id = ". $whmcs_client_id);
	       update_query("tblclients", array("cardtype" => $card->brand, "gatewayid" =>$stripe_customer->id,"cardlastfour" => $card->last4), array("id" => $whmcs_client_id));
	     }
	     else {
		   if (!isset($_POST['invoiceid'])) {
    	     logTransaction($gateway_name["value"],"Country Code does not match billing address country Customer ID:" . $_SESSION['uid'],"Error"); 
    	     $_SESSION['card_error'] = true;
             header( 'Location: '.$systemurl.'clientarea.php?action=creditcard&error=1');
             exit();
           }
	       else {
		     logTransaction($gateway_name["value"],"Country Code does not match billing address country, Invoice #" . $_POST['invoiceid'] . " Customer ID:" . $_SESSION['uid'],"Error"); 
		     echo "error";
	       }
		 }
	   
	   }
	   if (!isset($_POST['invoiceid'])) {
         header( 'Location: '.$systemurl.'clientarea.php?action=creditcard');
       }
   }
   catch(Exception $e) {
       $body = $e->getJsonBody();
       $error_message = $body["error"]["message"];
       $result = select_query("tblpaymentgateways","value", array("gateway" => "stripe","setting" => "name"));
       $gateway_name = mysql_fetch_array($result);
 	   if (!isset($_POST['invoiceid'])) {
    	 logTransaction($gateway_name["value"],$error_message,"Error"); 
    	 $_SESSION['card_error'] = true;
         header( 'Location: '.$systemurl.'clientarea.php?action=creditcard&error=1');
       }
	   else {
		 logTransaction($gateway_name["value"],$error_message,"Error"); 
		 echo "error";
	   }
   }
   

	
}



?>