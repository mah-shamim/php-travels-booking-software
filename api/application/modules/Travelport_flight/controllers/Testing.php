<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
require_once "Travelport.php";
/**
 * Travelport Cart
 *
 * @category Frontend
 */
class Testing extends Travelport {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo $this->configuration->api_endpoint;
    }
}