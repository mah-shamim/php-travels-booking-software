<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('pt_get_file_data_modules'))
{

function pt_get_file_data_modules( $file, $context = '' ) {

$default_headers = array(
		'Name'        => 'Module Name',
		'DisplayName' => 'Module Display Name',
		'Icon'        => 'Module Icon',
		'AdminMenu'   => 'Admin Menu',
		'SupplierMenu'   => 'Supplier Menu',
		'isIntegration'   => 'Integration',
        'Version'     => 'Version'

	);



	// We don't need to write to the file, so just open for reading.
	$fp = fopen( $file, 'r' );

	// Pull only the first 8kiB of the file in.
	$file_data = fread( $fp, 8192 );

	fclose( $fp );

	// Make sure we catch CR-only line endings.
	$file_data = str_replace( "\r", "\n", $file_data );


    $all_headers = $default_headers;
	foreach ( $all_headers as $field => $regex ){
		if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
			$all_headers[ $field ] = _cleanup_header_comment_modules( $match[1] );
		else
			$all_headers[ $field ] = '';
	}

	return $all_headers;
}

}



// Reading Payment Gateways configs
if ( ! function_exists('ptGetPaymentGatewaysInfo'))
{

function ptGetPaymentGatewaysInfo( $file, $context = '' ) {

$default_headers = array(
		'Name'        => 'Gateway Name',
		'DisplayName' => 'Gateway Display Name',
		'Enable' => 'Enable'
		);



	// We don't need to write to the file, so just open for reading.
	$fp = fopen( $file, 'r' );

	// Pull only the first 8kiB of the file in.
	$file_data = fread( $fp, 8192 );

	fclose( $fp );

	// Make sure we catch CR-only line endings.
	$file_data = str_replace( "\r", "\n", $file_data );


    $all_headers = $default_headers;
	foreach ( $all_headers as $field => $regex ){
		if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
			$all_headers[ $field ] = _cleanup_header_comment_modules( $match[1] );
		else
			$all_headers[ $field ] = '';
	}

	return $all_headers;
}

}

if ( ! function_exists('_cleanup_header_comment_modules'))
{

function _cleanup_header_comment_modules($str) {
	return trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $str));
}

}