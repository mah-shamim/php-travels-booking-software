<?php
class TourSearchForm
{
    public $from_code;
    public $checkin;
    public $adults = 1;

    public function __construct()
    {
        $this->checkin = date('d/m/Y');
    }

    public function parseUriString($args)
    {
        $this->from_code = $args['txtSearch'];
        $this->checkin = $args['checkin'];
        $this->adults = $args['adults'];
    }

}
