<?php 

class Invoice 
{
    public $status;
    public $PNR;
    public $errors;
    public $warnings;
    public $segments;
    public $contactNumbers;
    public $passengers;
    public $itineraryRef;
    public $baseFare;
    public $tax;
    public $administrationFee;
    public $total = 0;
    public $fullname;
    public $email;
    public $phone;

    public function parse($data)
    {
        $data = $data->data;

        $this->setStatus($data);
        $this->setPNR($data);
        $this->setErrors($data);
        $this->setWarnings($data);
        $this->setSegments($data);
        $this->setContactNumbers($data);
        $this->setPassengers($data);
        $this->setItineraryRef($data);
    }

    public function setStatus($data)
    {
        $this->status = $data->CreatePassengerNameRecordRS->ApplicationResults->status;
    }

    public function setErrors($data)
    {
        if(property_exists($data->CreatePassengerNameRecordRS->ApplicationResults, 'Error')) {
            $this->errors = $data->CreatePassengerNameRecordRS->ApplicationResults->Error;
        }
    }

    public function setWarnings($data)
    {
        if(property_exists($data->CreatePassengerNameRecordRS->ApplicationResults, 'Warning')) {
            $this->warnings = $data->CreatePassengerNameRecordRS->ApplicationResults->Warning;
        }
    }

    public function setPNR($data)
    {
        $this->PNR = $data->CreatePassengerNameRecordRS->ItineraryRef->ID;
    }

    public function setSegments($data)
    {
        $this->segments = $data->CreatePassengerNameRecordRS->AirBook->OriginDestinationOption->FlightSegment;
    }

    public function setContactNumbers($data)
    {
        $this->contactNumbers = $data->CreatePassengerNameRecordRS->TravelItineraryRead->TravelItinerary->CustomerInfo->ContactNumbers->ContactNumber;
    }

    public function setPassengers($data)
    {
        $this->passengers = $data->CreatePassengerNameRecordRS->TravelItineraryRead->TravelItinerary->CustomerInfo->PersonName;
    }

    public function setItineraryRef($data)
    {
        $this->itineraryRef = $data->CreatePassengerNameRecordRS->TravelItineraryRead->TravelItinerary->ItineraryRef;
    }

    public function setBaseFare($itinerarie)
    {
        if ($itinerarie->priceDetail->customFare->tax->amount == 0) {
            $this->baseFare = $itinerarie->priceDetail->baseFare->CurrencyCode.' '.$itinerarie->priceDetail->baseFare->Amount;
        } else {
            $this->baseFare = $itinerarie->priceDetail->totalFare->CurrencyCode.' '.$itinerarie->priceDetail->totalFare->Amount;
        }
    }

    public function setTax($itinerarie)
    {
        if ($itinerarie->priceDetail->customFare->tax->amount == 0) {
            $this->tax = $itinerarie->priceDetail->taxes->summary[0]->CurrencyCode.' '.$itinerarie->priceDetail->taxes->summary[0]->Amount;
        } else {
            $this->tax = $itinerarie->priceDetail->customFare->tax->currencyCode.' '.$itinerarie->priceDetail->customFare->tax->amount;
        }
    }

    public function setAdministrationFee($itinerarie)
    {
        $this->administrationFee = $itinerarie->priceDetail->customFare->administrationFee->currencyCode.' '.$itinerarie->priceDetail->customFare->administrationFee->amount;
    }

    public function getTotal($itinerarie)
    {
        $total = $itinerarie->priceDetail->totalFare->Amount + $itinerarie->priceDetail->customFare->administrationFee->amount + $itinerarie->priceDetail->customFare->tax->amount;
        $this->total = $itinerarie->priceDetail->totalFare->CurrencyCode.' '.$total;
        return $this->total;
    }

    public function setFullName($surname, $fullname)
    {
        $this->fullname = $surname.'.'.$fullname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setMobile($phone)
    {
        $this->phone = $phone;
    }
}
