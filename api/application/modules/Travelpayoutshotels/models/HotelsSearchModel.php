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
        $this->hoteldatetype = date('d/m/Y', strtotime('+3 day'));
        $this->hoteldatecheckin = date('d/m/Y',strtotime('+4 day'));
        $this->hotelroute = base_url().'tphotels/search';
        $this->location_url = base_url().'home/suggestions_v2/hotels';
    }
    public function parsString($arr)
    {
        $this->hotellocation = urlencode($arr[3]);
        $this->hotelcheckin = $arr[4];
        $this->hotelcheckout = $arr[5];
        $this->hoteladult = $arr[6];
        $this->hotelchildren = $arr[7];
    }
    public function genrateQueryString()
    {
        $hotelcheckin = new DateTime($this->hotelcheckin);
        $hotelcheckout = new DateTime($this->hotelcheckout);

        if($this->hotelchildren != 0){
            $child = $this->hotelchildren;
        }else{
            $child = '';

        }
        return  "destination=".$this->hotellocation."&checkIn=".$hotelcheckin->format('Y-m-d')."&checkOut=".$hotelcheckout->format('Y-m-d')."&children=".$child."&adults=".$this->hoteladult;

    }

}