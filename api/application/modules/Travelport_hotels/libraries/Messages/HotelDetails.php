<?php 
class Aggregator
{
    public $Name;
}

class PermittedAggregators
{
    public function __construct()
    {
        $this->Aggregator = new Aggregator();
    }
}

class HotelDetailsModifiers 
{
    public $NumberOfAdults;
    public $NumberOfRooms;

    public function __construct()
    {
        $this->RateRuleDetail = "Complete";
        $this->PermittedProviders = new PermittedProviders();
        $this->HotelStay = new HotelStay();
        // $this->PermittedAggregators = new PermittedAggregators();
        $this->BookingGuestInformation = new BookingGuestInformation();
    }
}

class HostToken
{
    public $Host;
    public $Key;
}

class HotelDetails extends BaseModel
{
    // public $HostToken;

    public function __construct()
    {
        parent::__construct();
        $this->AuthorizedBy = 'user';
        $this->TraceId = 'trace';
        $this->ReturnMediaLinks = true;
        $this->BillingPointOfSaleInfo = new BillingPointOfSaleInfo('UAPI');
        $this->HotelDetailsModifiers = new HotelDetailsModifiers();
    }

    public function setHotelProperty($HotelChain , $HotelCode)
    {
        $this->HotelProperty = new HotelProperty($HotelChain , $HotelCode);
    }

    public function setHotelDetailsModifiers($Rooms, $Adults, $CheckinDate, $CheckoutDate, $ProviderCode)
    {
        $this->HotelDetailsModifiers = new HotelDetailsModifiers();
        $this->HotelDetailsModifiers->NumberOfRooms = $Rooms;
        $this->HotelDetailsModifiers->NumberOfAdults = $Adults;
        $this->HotelDetailsModifiers->HotelStay->CheckinDate = $CheckinDate;
        $this->HotelDetailsModifiers->HotelStay->CheckoutDate = $CheckoutDate;
        $this->HotelDetailsModifiers->PermittedProviders->Provider->Code = $ProviderCode;
    }

    public function setHostToken($Key)
    {
        $this->HostToken = $Key;
    }

    public function setPermittedAggregators($AggregatorName)
    {
        $this->HotelDetailsModifiers->PermittedAggregators->Aggregator->Name = $AggregatorName;
    }

    public function setBookingGuestInformation($NumberOfRooms, $Adults)
    {
        for($room = 0; $room < $NumberOfRooms; $room++) {
            array_push($this->HotelDetailsModifiers->BookingGuestInformation->Room, new Room($Adults));
        }
    }
}