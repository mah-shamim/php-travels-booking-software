<?php

class PaymentCard {
    public $cardHolderName;
    public $cardType;
    public $cardNumber;
    public $expiryDate;
    public $cardCVC;
}

class ContactData {
    public $email;
    public $phoneNumber;   
}

class PaymentData {
    public function __construct()
    {
        $this->paymentCard = new PaymentCard();
        $this->contactData = new ContactData();
    }
}

class Holder {
    public $name;
    public $surname;
}

class Pax {
    public $roomId;
    public $type;
    public $name;
    public $surname;
}

class Room {
    public $rateKey;
    public $paxes = array();
}

class BookingReq {
    public $holder;
    public $rooms = array();
    public $clientReference;
    public $remark;
    public function __construct()
    {
        $this->holder = new Holder();
    }
}