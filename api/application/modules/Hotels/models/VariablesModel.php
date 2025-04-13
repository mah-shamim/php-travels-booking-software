<?php

class VariablesModel
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

    public $hotelorigin;
    public $hoteldestination;
    public $hotelcheckin;
    public $hotelcheckout;
    public $hoteldatetype;
    public $hotelchildrenage;
    public $hotelrooms;
    public $hotelnights;
    public $hotelroute;
    public $hotelcurrency;

    /*Form Name Define */
    public $hotelnamedestination;
    public $hotelnamecheckin;
    public $hotelnamecheckout;
    public $hotelnameadult;
    public $hotelnameinfant;
    public $hotelnamechildren;
    public $hotelnamenight;
    public $hotelnamecurrency;

    public function __construct()
    {
    $this->hotelnamedestination = 'dest';
    $this->hotelnamecheckin = 'checkin';
    $this->hotelnamecheckout = 'checkout';
    $this->hotelnameadult = 'adults';
    $this->hotelnamechildren = 'child';
    $this->hotelnameinfant = 'infant';
    $this->hoteladult = 2;
    $this->hotelchildren = 0;
    $this->hotelshow_adult = true;
    $this->hotelshow_children = true;
    $this->hotelshow_childrenage = false;
    $this->hotelshow_infant = false;
    $this->hotelshow_rooms_count = false;
    $this->hotelshow_nights = false;
    $this->hoteldatetype = date('m/d/y', strtotime('+1 day'));
    $this->hotelroute = base_url().'hotels/search';
    }

}