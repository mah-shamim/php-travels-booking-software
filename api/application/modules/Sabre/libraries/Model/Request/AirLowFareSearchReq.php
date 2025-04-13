<?php 

class RequestorID
{
    public $Type;
    public $ID;

    public function __construct($type, $id)
    {
        $this->Type = $type;
        $this->ID = $id;
    }
}

class Source 
{
    public $PseudoCityCode = "F9CE";
    public $RequestorID;

    public function __construct($cityCode, $id)
    {
        $this->PseudoCityCode = "F9CE";
        $this->RequestorID->CompanyName->Code = "TN";
        $this->RequestorID->ID = "1";
        $this->RequestorID->Type = "1";
    }
}

class POS 
{
    public $Source = array();
}

class Location
{
    public $LocationCode;

    public function __construct($code)
    {
        $this->LocationCode = $code;
    }
} 

class Origin 
{
    public $DepartureDateTime;
    public $OriginLocation;
    public $DestinationLocation;

    public function __construct($origin, $destination, $datetime)
    {
        $this->DepartureDateTime = $datetime;
        $this->OriginLocation = new Location($origin);
        $this->DestinationLocation = new Location($destination);
    }
}

class Destination 
{
    public $DepartureDateTime;
    public $OriginLocation;
    public $DestinationLocation;

    public function __construct($origin, $destination, $datetime)
    {
        $this->DepartureDateTime = $datetime;
        $this->OriginLocation = new Location($origin);
        $this->DestinationLocation = new Location($destination);
    }
}

class Travler
{
    public $Code;
    public $Quantity;

    public function __construct($code, $quantity)
    {
        $this->Code = $code;
        $this->Quantity = $quantity;
    }
}

class AirTravelerAvail
{
    public $PassengerTypeQuantity = array();
}

class PriceRequestInformation
{
    public $CurrencyCode;

    public function __construct($CurrencyCode)
    {
        $this->CurrencyCode = $CurrencyCode;
    }
}

class TravelerInfoSummary
{
    public $AirTravelerAvail = array();
    public $PriceRequestInformation;
}

class RequestType
{
    public $Name;
}

class IntelliSellTransaction
{
    public $RequestType;

    public function __construct()
    {
        $this->RequestType = new RequestType();
    }
}

class TPA_Extensions
{
    public $IntelliSellTransaction;

    public function __construct()
    {
        $this->IntelliSellTransaction = new IntelliSellTransaction();
    }
}

class AirLowFareSearchReq
{
    public $POS;
    public $OriginDestinationInformation = array();
    public $TravelerInfoSummary;
    public $TPA_Extensions;
    public $Version;

    public function setPOS($cityCode, $requestorId)
    {
        $source = new Source($cityCode, $requestorId);
        $this->POS->Source[] = $source;
    }

    public function setOrigin($from, $to, $datetime)
    {
        $origin = new Origin($from, $to, $datetime);
        $this->OriginDestinationInformation[] = $origin;
    }

    public function setDestination($from, $to, $datetime)
    {
        $destination = new Destination($from, $to, $datetime);
        $this->OriginDestinationInformation[] = $destination;
    }

    public function setTravelerInfoSummary($airTravelerAvail, $CurrencyCode)
    {
        $this->TravelerInfoSummary->AirTravelerAvail[] = $airTravelerAvail;
        $this->TravelerInfoSummary->PriceRequestInformation = new PriceRequestInformation($CurrencyCode);
    }

    public function setTPA_Extensions($name)
    {
        $TPA_Extensions = new TPA_Extensions();
        $TPA_Extensions->IntelliSellTransaction->RequestType->Name = $name;
        $this->TPA_Extensions = $TPA_Extensions;
    }
}
