<?php

class Paymentgateways
{
    /**
     * Protected variables
     */
    protected $_ci       = NULL;    //codeigniter instance

    private $_mainDir = array();


    /**
     * Paymentgateways::__construct()
     * @return void
    */
    function __construct()
    {

    	//get the CI instance
    $this->_ci = &get_instance();

    $this->_mainDir = APPPATH . 'modules/payment_gateways/';
   
    }

    function getAllGateways()
    {
        $gatways = directory_map($this->_mainDir,2);
        $count = 0;
            foreach($gatways as $gateway => $v ){
            $count++;
            @$info = ptGetPaymentGatewaysInfo($this->_mainDir."$gateway/info.txt" );
            $pgateways[] = (object)array("name" => $info['Name'], "displayName" => $info['DisplayName'],
                            'enable' => $info['Enable']);
            
    }

    return $pgateways;
    
    }

	

}