<?php

class HotelException extends \Exception
{
    private $resp;

    public function __construct($message, $resp = NULL)
    {
        parent::__construct($message);

        $this->resp = $resp;
    }

    public function getErrorCode()
    {
        return $this->resp->error->code;
    }
}
