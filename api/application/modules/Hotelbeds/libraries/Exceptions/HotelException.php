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

    public function getErrorMessage()
    {
        return $this->resp->error->code;
    }

    public function getError()
    {
        return json_encode($this->resp->error);
    }
}
