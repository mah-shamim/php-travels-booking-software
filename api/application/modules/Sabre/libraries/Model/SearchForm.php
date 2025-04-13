<?php 

include_once 'Passenger.php';

class SearchForm
{
    public $origin;
    public $destination;
    public $departure;
    public $arrival;
    public $tripType;
    public $classOfService;
    public $passenger;

    public function __construct()
    {
        $this->passenger = new Passenger();
    }

    public function parseUriString($args)
    {
        $this->origin = $args[0];
        $this->destination = $args[1];
        $this->classOfService = $args[3];
        $this->tripType = $args[2];
        $this->departure = $args[4];
        if ($this->tripType == 'return') {
            $this->arrival = $args[5];
            $this->passenger->adult = $args[6];
            $this->passenger->children = $args[7];
            $this->passenger->infant = $args[8];
        } else {
            $this->passenger->adult = $args[5];
            $this->passenger->children = $args[6];
            $this->passenger->infant = $args[7];
        }
    }
}
