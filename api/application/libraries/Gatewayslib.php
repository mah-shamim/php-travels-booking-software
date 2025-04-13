<?php

class Gatewayslib {
/**
* Protected variables
*/
		protected $CI;
/**
* Public variables
*/

public $GatewayValues = array();
public $GatewayConfig = array();
public $ActiveGateways = array();
public $DisabledGateways = array();
public $includedmodules = array();


		function __construct() {
				//get the CI instance
				$this->CI = & get_instance();
		}

		function init()
		{
			$this->CI->db->order_by('order','asc');
			$rslt = $this->CI->db->get('pt_paymentgateways')->result();
			foreach($rslt as $rs)
			{
				$gwv_gateway = $rs->gateway;
				$gwv_setting = $rs->setting;
				$gwv_value = $rs->value;
				$order = $rs->order;
				$this->GatewayValues[$gwv_gateway][$gwv_setting] = $gwv_value;
				$this->GatewayValues[$gwv_gateway]['order'] = $order;
			}
		}

		function getAllPaymentGateways()
		{
			$dh = opendir('./application/modules/Gateways');
			while (false !== $file = readdir($dh)) // Reading file
			{
				$fileext = explode(".", $file, 2);
				$filename = $fileext[0];
				$extension = $fileext[1];
				$file = trim($file);
				if ( ($file != "index.php" && $extension == "php") && !in_array($filename, $this->includedmodules) )
				{
					$this->includedmodules[] = $filename;
					$gwv_modulename = $filename;

					if (!$this->isValidforPath($filename)) {
						exit("Invalid Gateway Module Name");
					}

					require_once "./application/modules/Gateways/" . $filename . ".php";

					if (function_exists($gwv_modulename . "_config")) {
						$this->GatewayConfig[$gwv_modulename] = call_user_func($gwv_modulename . "_config");
					}
					else
					{
						$GatewayFieldDefines = array();
						$GatewayFieldDefines['FriendlyName'] = array( "Type" => "System", "Value" => $GATEWAYMODULE[$gwv_modulename . "visiblename"] );

						if ($GATEWAYMODULE[$gwv_modulename . "notes"]) {
							$GatewayFieldDefines['UsageNotes'] = array( "Type" => "System", "Value" => $GATEWAYMODULE[$gwv_modulename . "notes"] );
						}

						call_user_func( $gwv_modulename . "_activate" );
						$this->GatewayConfig[$gwv_modulename] = $GatewayFieldDefines;
					}

					if (isset($this->GatewayValues[$gwv_modulename]['type'])) {
						$this->ActiveGateways[] = array(
							"name" => $gwv_modulename,
							"displayName" => $this->GatewayConfig[$gwv_modulename]['FriendlyName']['Value'],
							'configData' => $this->GatewayConfig[$gwv_modulename],
							'gatewayValues' => $this->GatewayValues,
							'order' => $this->GatewayValues[$gwv_modulename]['order']
						);
					}
					else {
						$this->DisabledGateways[] = array(
							"name" => $gwv_modulename,
							"displayName" => $this->GatewayConfig[$gwv_modulename]['FriendlyName']['Value']
						);
					}
				}
 			}
			
			closedir($dh);
		}

		function getConfigDataOfGateway($gateway){

			$gatewayConfigData = array();


		if (!$this->isValidforPath($gateway)) {
			exit("Invalid Gateway Module Name");
		}

		require_once "./application/modules/Gateways/" . $gateway . ".php";

		if (function_exists($gateway . "_config")) {
			$gatewayConfigData[] = call_user_func($gateway . "_config");
		}

		if (function_exists($gateway . "_capture")) {
			$gatewayConfigData["type"] = "CC";
		}else{
		$gatewayConfigData["type"] = "Invoices";

		}

		$gatewayConfigData["gateway"] = $gateway;


		return $gatewayConfigData;
		}

		function isValidforPath($name) {
		if (!is_string($name) || empty($name)) {
			return false;
		}


		if (!ctype_alnum(str_replace(array("_", "-"), "", $name))) {
			return false;
		}

		return true;
	}

	function gatewayMsg($gateway,$params){

		require_once "./application/modules/Gateways/" . $gateway . ".php";
		$response = array("iscreditcard" => "0","gateway" => $gateway, "htmldata" => "");

		if (function_exists($gateway . "_link")) {
			$msg = call_user_func($gateway . "_link",$params);
			$response = array("iscreditcard" => "0","gateway" => $gateway, "htmldata" => $msg);
		}elseif(function_exists($gateway . "_capture")) {
			$response = array("iscreditcard" => "1","gateway" => $gateway, "htmldata" => "");
		}

		return json_encode($response);

	}




}
