<?php 

class BillingPointOfSaleInfo 
{
    public function __construct($Origin = NULL)
    {
        $this->OriginApplication = $Origin;
    }
}

class Provider 
{
    public $Code;
}

class PermittedProviders
{
    public function __construct()
    {
        $this->Provider = new Provider();
    }
}

class HotelStay 
{
    public $CheckinDate;
    public $CheckoutDate;
}

class HotelProperty 
{
    public $HotelChain;
    public $HotelCode;

    public function __construct($HotelChain = NULL, $HotelCode = NULL)
    {
        $this->HotelChain = $HotelChain;
        $this->HotelCode = $HotelCode;
    }
}

class Room
{
    public function __construct($Adults = NULL)
    {
        $this->Adults = $Adults; // Intiger
    }
}

class BookingGuestInformation
{
    public $Room = array(); // Array of Room Objects
}