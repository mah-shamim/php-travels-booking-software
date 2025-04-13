<?php (defined('BASEPATH')) OR exit('No direct script access allowed');



class MY_Config extends CI_Config {

	public function __construct()
	{
		$this->config =& get_config();

// Set the base_url automatically if none was provided
		if (empty($this->config['base_url']))
		{
			if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $tmplt = "%s://%s%s";
            $end = $dir;
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

			$this->set_item('base_url', $base_url);
		}

	}
}