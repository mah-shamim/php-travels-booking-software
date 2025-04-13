<?php

function banktransfer_config() {
	$configarray = array( "FriendlyName" => array( "Type" => "System", "Value" => "Bank Transfer" ), "instructions" => array( "FriendlyName" => "Bank Transfer Instructions", "Type" => "textarea", "Rows" => "5", "Value" => "Bank Name:
Payee Name:
Sort Code:
Account Number:", "Description" => "The instructions you want displaying to customers who choose this payment method" ) );
	return $configarray;
}


function banktransfer_link($params) {
	
	$code = "<p>" . nl2br( $params['instructions'] ). "</p>";
	return $code;
}