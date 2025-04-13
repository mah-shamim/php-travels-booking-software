<?php 

class Passenger 
{
    public $adult;
    public $children;
    public $infant;

    public function total()
    {
        $totalPassengers = (int) $this->adult;
        $totalPassengers += (int) $this->children;
        $totalPassengers += (int) $this->infant;
        return $totalPassengers;
    }
}
