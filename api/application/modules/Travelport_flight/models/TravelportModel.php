<?php 

class TravelportModel extends CI_Model 
{
    const DB_TABLE = 'tport_reservation';
    const DB_PK = 'id';

    public $id;
    public $userId;
    public $airCreateReservationReq;
    public $airCreateReservationResp;
    public $access_token;
    public $createdAt;
    public $updatedAt;


    public function __construct()
    {
        parent::__construct();
    }

    public function get_bookings($actor_id = 0)
    {
        require_once __DIR__.'/../libraries/travelport/ReferenceData.php';        
        $referenceData = new ReferenceData();
        
        $this->db->select('currency, total_price, access_token, airCreateReservationResp, createdAt');
        $this->db->where('userId', $actor_id);
        $dataAdapter = $this->db->get($this::DB_TABLE);
        if ($dataAdapter->num_rows() > 0) {
            $ret_dataset = array();
            foreach($dataAdapter->result() as $dataset) {
                $airCreateReservationResp = unserialize($dataset->airCreateReservationResp);
                $outbound = is_object($airCreateReservationResp->outbound->segment) ? $airCreateReservationResp->outbound->segment : current($airCreateReservationResp->outbound->segment);
                $dataset->destination = (Object) $referenceData->airport_detail($outbound->Destination);
                $dataset->carrier = (Object) $referenceData->airline_carrier($outbound->Carrier);
                $dataset->createdAt = date('d/m/Y', strtotime($dataset->createdAt));
                unset($dataset->airCreateReservationResp);
                
                array_push($ret_dataset, $dataset);
            }
            
            return $ret_dataset;
        }
        
        return array();
    }
}