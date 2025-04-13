<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'ServiceController.php';
include_once 'Datatype/AvailabilityReq.php';

class HotelbedsLib extends ServiceController {

    public function availability($availabilityReq)
    {
        $resp = $this->service($availabilityReq, 'hotels');
        return $resp;
    }

    public function checkrate($payload = array())
    {
        $resp = $this->service($payload,'checkrates');
        return $resp;
    }

    public function booking($payload = array())
    {

        $resp = $this->service($payload,'booking');
        return $resp;
    }

    /**
     * API health test
     */
    public function status()
    {
        $resp = $this->service('status');
        var_dump($resp);
    }
}