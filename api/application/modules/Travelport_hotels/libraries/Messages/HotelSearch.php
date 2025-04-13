<?php 

class HotelLocation
{
    public $Location;
}

class HotelSearchLocation
{
    public function __construct()
    {
        $this->HotelLocation = new HotelLocation();
    }
}

class HotelSearchModifiers 
{
    public $NumberOfAdults;
    public $NumberOfRooms;
    public $ReturnPropertyDescription = true; // Supported Providers: Travelport Rooms and More (TRM)
    public $AvailableHotelsOnly = true;
    public $BookingGuestInformation;
    public $PreferredCurrency = "USD";
    public $HotelPaymentType;

    public function __construct()
    {
        $this->BookingGuestInformation = new BookingGuestInformation();
        $this->PermittedProviders = new PermittedProviders();
        $this->ReturnAmenities = true;
        $this->Amenities = array(); // Amenities filter
    }
}

/**
 * Amenities Search Modifier (Filter)
 * 
 * Minimum Occurs: 0
 * Maximum Occurs: 8
 */
class Amenity
{
    public function __construct($AmenityType, $Code)
    {
        $this->AmenityType = $AmenityType;
        $this->Code = $Code;
    }
}

class HotelSearch extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->AuthorizedBy = 'user';
        $this->TraceId = 'trace';
        $this->BillingPointOfSaleInfo = new BillingPointOfSaleInfo('UAPI');
        $this->HotelSearchLocation = new HotelSearchLocation();
        $this->HotelSearchModifiers = new HotelSearchModifiers();
        $this->HotelStay = new HotelStay();
    }

    public function setHotelSearchLocation($location)
    {
        $this->HotelSearchLocation->HotelLocation->Location = $location;
    }

    public function setHotelSearchModifiers($Rooms, $Adult, $ProviderCode, $PaymentType = NULL)
    {
        $this->HotelSearchModifiers->HotelPaymentType = $PaymentType;
        $this->HotelSearchModifiers->NumberOfRooms = $Rooms;
        $this->HotelSearchModifiers->NumberOfAdults = $Adult;
        // TRM required the following object
        $NumberOfRooms = array();
        for($i = 0; $i < $Rooms; $i++) {
            array_push($NumberOfRooms, new Room($Adult));
        }
        $this->HotelSearchModifiers->BookingGuestInformation->Room = $NumberOfRooms;
        if(empty($ProviderCode)) {
            unset($this->HotelSearchModifiers->PermittedProviders);
        } else {
            $this->HotelSearchModifiers->PermittedProviders->Provider->Code = $ProviderCode;
        }
    }

    public function setHotelSearchModifiersAmenities($AmenityType, $Code)
    {
        array_push($this->HotelSearchModifiers->Amenities, new Amenity($AmenityType, $Code));
    }

    public function setHotelStay($CheckinDate, $CheckoutDate)
    {
        $this->HotelStay->CheckinDate = $CheckinDate;
        $this->HotelStay->CheckoutDate = $CheckoutDate;
    }
}