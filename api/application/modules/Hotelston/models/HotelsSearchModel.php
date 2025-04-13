<?php

class HotelsSearchModel
{
    public $hoteladult;
    public $hotelchildren;
    public $hotelinfant;

    public $hotelshow_adult;
    public $hotelshow_children;
    public $hotelshow_childrenage;
    public $hotelshow_infant;
    public $hotelshow_rooms_count;
    public $hotelshow_nights;

    public $hotellocation;
    public $hotellocationname;
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
    public $hotelloactionsearch;


    public function __construct()
    {
        $this->hoteladult = 2;
        $this->hotelchildren = 1;
        $this->hotelshow_adult = true;
        $this->hotelshow_children = true;
        $this->hotelshow_childrenage = false;
        $this->hotelshow_infant = false;
        $this->hotelshow_rooms_count = false;
        $this->hotelshow_nights = false;
        $this->hoteldatetype = date('Y-m-d', strtotime('+2 day'));
        $this->hoteldatecheckin = date('Y-m-d',strtotime('+1 day'));
        $this->hotelroute = base_url().'hotelst/search';
        $this->location_url = base_url().'home/suggestions_v2/hotels';
        $this->hotelloactionsearch = $this->searchlist();
    }

    public  function searchlist(){
        $ci = get_instance();
        $ci->load->library('Hotels/Hotels_lib');
       return $ci->Hotels_lib->getLocationsListsearch();
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