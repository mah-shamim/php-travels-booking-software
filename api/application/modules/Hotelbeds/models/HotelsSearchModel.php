<?php

class HotelsSearchModel
{
    public $hoteladult;
    public $hotelchildren;
    public $hotelinfant;

    public $is_child_range;
    public $is_infant_range;

    public $hotelshow_adult;
    public $hotelshow_children;
    public $hotelshow_childrenage;
    public $hotelshow_infant;
    public $hotelshow_rooms_count;
    public $hotelshow_nights;

    public $hotellocation;
    public $hotelcheckin;
    public $hotelcheckout;
    public $hoteldatetype;
    public $hoteldatecheckin;
    public $hotelchildrenage;
    public $hotelrooms;
    public $hotelnights;
    public $hotelroute;
    public $location_url;
    public $hotelcurrency;
    public $hotellocationname;


    public function __construct()
    {
        $this->hoteladult = 2;
        $this->hotelchildren = 0;
        $this->hotelshow_adult = true;
        $this->hotelshow_children = true;
        $this->hotelshow_childrenage = false;
        $this->hotelshow_infant = false;
        $this->hotelshow_rooms_count = false;
        $this->hotelshow_nights = false;
        $this->hoteldatetype = date('m/d/y', strtotime('+3 day'));
        $this->hoteldatecheckin = date('m/d/y',strtotime('+4 day'));
        $this->hotelroute = base_url().'hotelb/search';
        $this->location_url = base_url().'suggestions/hotelbedsHotels';
    }

    public function parseUriString($args)
    {
        $this->hotellocationname = $args[0].'/'.$args[1];
        $this->hotellocation = $args[0].','.$args[1];
        $this->hotelcheckin = $args[2];
        $this->hotelcheckout = $args[3];
        $this->hoteladult = $args[4];
        $this->hotelchildren = $args[5];
    }
}