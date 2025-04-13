<?php 

class HotelMediaLinks extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->AuthorizedBy = 'user';
        $this->TraceId = 'trace';
        $this->BillingPointOfSaleInfo = new BillingPointOfSaleInfo('UAPI');
        $this->SizeCode = 'C';
        $this->RichMedia = 0;
    }

    public function setHotelProperty($HotelChain , $HotelCode)
    {
        $this->HotelProperty = new HotelProperty($HotelChain , $HotelCode);
    }
}