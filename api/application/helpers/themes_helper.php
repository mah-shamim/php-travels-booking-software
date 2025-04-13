<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('pt_getThemeInfo'))
{

function pt_getThemeInfo( $file, $context = '' ) {

$default_headers = array(
		'Name'        => 'Theme Name',
		'ThemeURI'    => 'Theme URI',
		'Description' => 'Description',
		'Author'      => 'Author',
		'AuthorURI'   => 'Author URI',
		'Version'     => 'Version',
		'Template'    => 'Template',
		'Status'      => 'Status',
		'Tags'        => 'Tags',
		'TextDomain'  => 'Text Domain',
		'DomainPath'  => 'Domain Path',
	);



	// We don't need to write to the file, so just open for reading.
	$fp = fopen( $file, 'r' );

	// Pull only the first 8kiB of the file in.
	$file_data = fread( $fp, 8192 );

	fclose( $fp );

	// Make sure we catch CR-only line endings.
	$file_data = str_replace( "\r", "\n", $file_data );


    $all_headers = $default_headers;
	foreach ( $all_headers as $field => $regex ) {
		if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
			$all_headers[ $field ] = _cleanup_header_comment( $match[1] );
		else
			$all_headers[ $field ] = '';
	}

	return $all_headers;
}

}





if ( ! function_exists('_cleanup_header_comment'))
{

function _cleanup_header_comment($str) {
	return trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $str));
}

}

if (!function_exists('pt_defaultTheme')) {

		function pt_defaultTheme() {
				$CI = get_instance();
				$CI->load->model('admin/settings_model');
				$res = $CI->Settings_model->get_theme();
				return $res;
		}

}