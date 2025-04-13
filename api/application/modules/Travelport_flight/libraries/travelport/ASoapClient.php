<?php

abstract class ASoapClient extends \SoapClient
{
    /**
     * Api endpoint service
     *
     * @var array
     */
    protected $end_service = "AirService";

    /**
     * Http stream context Array
     *
     * @var array
     */
    protected $context = null;

    /**
     * Configuration Array
     *
     * @var array
     */
    protected $config = null;

    /**
     * Options Array
     *
     * @var array
     */
    protected $options = null;

    /**
     * Travelport API Username
     *
     * @var string
     */
    protected $username = null;

    /**
     * Travelport API Password
     *
     * @var string
     */
    protected $password = null;

    /**
     * Travelport API Endpoint
     *
     * @var string
     */
    protected $endpoint = null;

    /**
     * Travelport API WSDL Request file path
     *
     * @var string
     */
    protected $wsdl = null;
    
    /**
     * Travelport API branch code
     *
     * @var string
     */
    public $branch_code;


    public function __construct($wsdl, $options = null) 
    {
        $this->wsdl = $wsdl;
        $CI =& get_instance();
        $CI->load->model('TravelportModel_Conf');
        $configurationsObj = new TravelportModel_Conf();
        $configurationsObj->load();
        
        $this->endpoint = $configurationsObj->get_api_endpoint() . $this->end_service;
        $this->username = $configurationsObj->get_api_username();
        $this->password = $configurationsObj->get_api_password();
        $this->branch_code = $configurationsObj->get_branch_code();

        // Set Soap Config
        $this->setConfig();

        // Set Soap Context
        $this->setContext();

        // Create Classmap Array
        // $this->setClassmap();

        // Set Soap options
        $this->setOptions();

        // Set the WSDL endpoint
        $this->__setLocation($this->endpoint);

        // Create the SoapClient
        parent::__construct($this->wsdl, $this->options);
    }

    /**
     * Set Soap Config
     *
     * @param string $wsdl
     * @param string $endpoint
     * @return array $config
     */
    protected function setConfig() {
        // Check WSDL
        if ($this->wsdl == null) {
            throw new Exception("WSDL cannot be null");
        }
        
        // Credentials
        $this->config = array(
            'username' => $this->username,
            'password' => $this->password,
            'wsdl' => $this->wsdl,
            'endpoint' => $this->endpoint
        );

        // Setting config
        return $this->config;
    }

    /**
     * Set Soap Context
     *
     * @return array $context
     */
    protected function setContext() {
        $this->context = array(
            'http' => array(
                'header' => array(
                    'Content-Type: text / xml; charset = UTF-8',
                    'Accept-Encoding: gzip, deflate',
                    'SOAPAction: ""'
                )),
            'ssl' => array(
                'ciphers' => 'AES256-SHA',
                'verify_peer' => false,
                'verify_peer_name' => false
            )
        );
        return $this->context;
    }

    /**
     * Set Soap Options
     *
     * @param array $config
     * @param array $context
     * @return array $options
     */
    protected function setOptions()
    {
        $this->options = array(
            'soap_version' => 'SOAP_1_2',
            'encoding' => 'UTF-8',
            'exceptions' => true,
            'stream_context' => stream_context_create($this->context),
            'trace' => true,
            'login' => $this->username,
            'password' => $this->password
        );

        // Setting options
        return $this->options;
    }
}