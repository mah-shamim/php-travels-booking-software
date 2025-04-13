<?php 

class TravelportModel_Cart extends CI_Model 
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

    public function save_AirCreateReservationReqRsp($request, $response)
    {
        $timestamp = date('Y-m-d H:m:i');
        $this->userId = time(); // timestamp as unique id for guest user
        $userId = $this->session->userdata('pt_logged_customer');
        if (isset($userId) && ! empty($userId)) {
            $this->userId = $userId;
        }
        $this->customer = current($response->bookingTraveler)->fullname;
        $this->phone = current($response->bookingTraveler)->phoneNumber;
        $this->access_token = $response->pnr;
        $this->total_price = $response->aggregatePrice->total['value'];
        $this->currency = $response->aggregatePrice->total['unit'];
        $this->airCreateReservationReq = serialize($request);
        $this->airCreateReservationResp = serialize($response);
        $this->createdAt = $timestamp;
        $this->updatedAt = $timestamp;
        $this->db->insert($this::DB_TABLE, $this);

        return (Object) array('access_token' => $this->access_token);
    }

    /**
     * Delete travelport data from session
     *
     * @return void
     */
    public function refreshTravelportSessionData()
    {
        $array_items = array(
            'travelportCheckoutResp', 
            'SearchPassenger', 
            'travelportResp', 
            'travelportCartResp',
        );  // `searchQuery` Need this data in session for search form so the form prepopulated on load next time

        $this->session->unset_userdata($array_items);
    }

    public function get_invoice($PNR)
    {
        $this->db->select('airCreateReservationResp');
        $this->db->where('access_token', $PNR);
        $dataAdapter = $this->db->get($this::DB_TABLE);
        if ($dataAdapter->num_rows() > 0) {
            $dataset = $dataAdapter->row();
            
            return unserialize($dataset->airCreateReservationResp);
        }
        
        return array();
    }
}