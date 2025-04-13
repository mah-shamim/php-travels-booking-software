<?php

class Source
{
    public $ReceivedFrom;
}

class EndTransaction
{
    public $Source;

    public function __construct()
    {
        $this->Source = new Source();
    }
}

class PostProcessing
{
    public $RedisplayReservation;
    public $EndTransaction;

    public function __construct()
    {
        $this->EndTransaction = new EndTransaction();
    }
}

class ContactNumber
{
    public $NameNumber;
    public $Phone;
    public $PhoneUseType;
}

class ContactNumbers
{
    public $ContactNumber = array();
}

class PersonName
{
    public $NameNumber;
    public $NameReference;
    public $PassengerType;
    public $GivenName;
    public $Surname;
}

class CustomerInfo
{
    public $ContactNumbers;
    public $PersonName = array();

    public function __construct()
    {
        $this->ContactNumbers = new ContactNumbers();
    }
}

class TravelItineraryAddInfo
{
    public $CustomerInfo;

    public function __construct()
    {
        $this->CustomerInfo = new CustomerInfo();
    }
}

class MarketingAirline
{
    public $Code;
    public $FlightNumber;
}

class OriginLocation
{
    public $LocationCode;
}

class DestinationLocation
{
    public $LocationCode;
}

class FlightSegment
{
    public $DepartureDateTime;
    public $ArrivalDateTime;
    public $FlightNumber;
    public $NumberInParty;
    public $Status;
    public $ResBookDesigCode;
    public $MarketingAirline;
    public $OriginLocation;
    public $DestinationLocation;

    public function __construct()
    {
        $this->MarketingAirline = new MarketingAirline();
        $this->OriginLocation = new OriginLocation();
        $this->DestinationLocation = new DestinationLocation();
    }
}

class OriginDestinationInformation
{
    public $FlightSegment = array();
}

class AirBook
{
    public $OriginDestinationInformation;

    public function __construct()
    {
        $this->OriginDestinationInformation = new OriginDestinationInformation();
    }
}

class Booking
{
    public $haltOnAirPriceError;
    public $PostProcessing;
    public $TravelItineraryAddInfo;
    public $AirBook;

    public function __construct()
    {
        $this->PostProcessing = new PostProcessing();
        $this->TravelItineraryAddInfo = new TravelItineraryAddInfo();
        $this->AirBook = new AirBook();
    }

    public function setHaltOnAirPriceError($value)
    {
        $this->haltOnAirPriceError = $value;
    }

    public function setPostProcessing($value)
    {
        $this->PostProcessing->RedisplayReservation = $value;
    }

    public function setReceivedFrom($value)
    {
        $this->PostProcessing->EndTransaction->Source->ReceivedFrom = $value;
    }

    public function setContactNumber($contactNumber)
    {
        array_push($this->TravelItineraryAddInfo->CustomerInfo->ContactNumbers->ContactNumber, $contactNumber);
    }

    public function setpersonName($personName)
    {
        array_push($this->TravelItineraryAddInfo->CustomerInfo->PersonName, $personName);
    }

    public function setFlightSegment($flightSegment)
    {
        array_push($this->AirBook->OriginDestinationInformation->FlightSegment, $flightSegment);
    }
}