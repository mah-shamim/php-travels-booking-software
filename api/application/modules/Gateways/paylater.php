<?php

function paylater_config() {
	$configarray = array( "FriendlyName" => array( "Type" => "System", "Value" => "Pay Later" ));
	return $configarray;
}


function paylater_link($params) {
	
	$code = "<p>" . nl2br( $params['instructions'] ). "</p>";
	return $code;
}