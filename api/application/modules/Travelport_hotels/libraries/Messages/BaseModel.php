<?php 

class BaseModel
{
    public $TargetBranch;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->model('TravelportHotelModel_Conf');
        $Configuration = new TravelportHotelModel_Conf();
        $Configuration->load();
        $this->TargetBranch = $Configuration->get_branch_code();
    }
}