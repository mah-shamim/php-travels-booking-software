<?php 
class BookingTravelerName
{
    public $Prefix; // Mr
    public $First; // Jhon
    public $Last; // Smith
}

class PhoneNumber
{
    public $Location; // DEN
    public $CountryCode; // 1
    public $AreaCode; // 303
    public $Number; // 123456789
}

class Email
{
    public $EmailID;
}

class Address
{
    public $AddressName;
    public $Street;
    public $City;
    public $State;
    public $PostalCode;
    public $Country;
}

class BookingTraveler
{
    /**
     * Age e.g 20
     * 
     * @var int $Age
     */
    public $Age;
    /**
     * DOB of date formate YYYY-mm-dd
     * e.g 1978-03-03
     * 
     * @var date $DOB
     */
    public $DOB;
    /**
     * Gender of single character code 
     * e.g M/F
     * 
     * @var char $Gender
     */
    public $Gender;
    /**
     * Nationality ISO Code of two character
     * e.g US
     * 
     * @var int $Nationality
     */
    public $Nationality;
    /**
     * Travler type
     * e.g ADT, CHD, INF
     * 
     * @var int $Nationality
     */
    public $TravelerType;
    
    public function __construct()
    {
        $this->BookingTravelerName = new BookingTravelerName();
        $this->PhoneNumber = new PhoneNumber();
        $this->Email = new Email();
        $this->Address = new Address();
    }
}

class HotelRateDetail
{
    public $RatePlanType;
}

class CreditCard
{
    public $Type;
    public $Number;
    public $ExpDate;
    public $CVV;
}

class Guarantee
{
    public $Type;

    public function __construct()
    {
        $this->CreditCard = new CreditCard();
    }
}

class GuestInformation
{
    public $NumberOfRooms;
    public $NumberOfAdults;
}

class HotelReservation extends BaseModel
{
    public $ProviderCode;

    public function __construct()
    {
        parent::__construct();
        $this->AuthorizedBy = 'user';
        $this->TraceId = 'trace';
        $this->BillingPointOfSaleInfo = new BillingPointOfSaleInfo('UAPI');
        $this->BookingTraveler = [];
        $this->HotelRateDetail = new HotelRateDetail();
        $this->HotelProperty = new HotelProperty();
        $this->HotelStay = new HotelStay();
        $this->Guarantee = new Guarantee();
        $this->GuestInformation = new GuestInformation();
    }

    public function setBookingTraveler($Age, $DOB, $Gender, $Nationality, $TravelerType)
    {
        $this->BookingTraveler->Age = $Age;
        $this->BookingTraveler->DOB = $DOB;
        $this->BookingTraveler->Gender = $Gender;
        $this->BookingTraveler->Nationality = $Nationality;
        $this->BookingTraveler->TravelerType = $TravelerType;
    }

    public function setBookingTravelerName($Prefix, $First, $Last)
    {
        $this->BookingTraveler->BookingTravelerName->Prefix = $Prefix;
        $this->BookingTraveler->BookingTravelerName->First = $First;
        $this->BookingTraveler->BookingTravelerName->Last = $Last;
    }

    public function setPhoneNumber($Location, $CountryCode, $AreaCode, $Number)
    {
        $this->BookingTraveler->PhoneNumber->Location = $Location;
        $this->BookingTraveler->PhoneNumber->CountryCode = $CountryCode;
        $this->BookingTraveler->PhoneNumber->AreaCode = $AreaCode;
        $this->BookingTraveler->PhoneNumber->Number = $Number;
    }

    public function setEmail($EmailID)
    {
        $this->BookingTraveler->Email->EmailID = $EmailID;
    }

    public function setAddress($AddressName, $Street, $City, $State, $PostalCode, $Country)
    {
        $this->BookingTraveler->Address->AddressName = $AddressName;
        $this->BookingTraveler->Address->Street = $Street;
        $this->BookingTraveler->Address->City = $City;
        $this->BookingTraveler->Address->State = $State;
        $this->BookingTraveler->Address->PostalCode = $PostalCode;
        $this->BookingTraveler->Address->Country = $Country;
    }

    public function setHotelRateDetail($RatePlanType)
    {
        $this->HotelRateDetail->RatePlanType = $RatePlanType;
    }

    public function setHotelProperty($HotelChain, $HotelCode)
    {
        $this->HotelProperty->HotelChain = $HotelChain;
        $this->HotelProperty->HotelCode = $HotelCode;
    }

    public function setHotelStay($CheckinDate, $CheckoutDate)
    {
        $this->HotelStay->CheckinDate = $CheckinDate;
        $this->HotelStay->CheckoutDate = $CheckoutDate;
    }

    public function setGuarantee($Type, $CardType, $Number, $ExpDate, $CVV)
    {
        $this->Guarantee->Type = $Type;
        $this->Guarantee->CreditCard->Type = $CardType;
        $this->Guarantee->CreditCard->Number = $Number;
        $this->Guarantee->CreditCard->ExpDate = $ExpDate;
        $this->Guarantee->CreditCard->CVV = $CVV;
    }

    public function setGuestInformation($NumberOfRooms, $NumberOfAdults)
    {
        $this->GuestInformation->NumberOfRooms = $NumberOfRooms;
        $this->GuestInformation->NumberOfAdults = $NumberOfAdults;
    }

    public function setHostToken($Key)
    {
        $this->HostToken = $Key;
    }
}