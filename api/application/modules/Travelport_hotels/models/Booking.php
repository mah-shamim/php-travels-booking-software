<?php

class Booking extends CI_Model
{
    const DB_TABLE = 'pt_hotelport_bookings';
    const DB_TABLE_PK = 'id';

    public $id;
    public $hotel_name;
    public $hotel_stars;
    public $hotel_location;
    public $hotel_image;
    public $room_name;
    public $checkin;
    public $checkout;
    public $total_nights;
    public $total_amount;
    public $currency_code;
    public $booking_holder;
    public $response_object;
    public $created_at;

    public function get()
    {
        $dataAdapter = $this->db->get(self::DB_TABLE);
        if($dataAdapter->num_rows() > 0) {
            return $dataAdapter->result();
        }
        return [];
    }

    public function load($id = 0)
    {
        $this->db->where('id', $id);
        return $this->db->get(self::DB_TABLE)->row();
    }

    public function save()
    {
        unset($this->id);
        $this->db->insert(self::DB_TABLE, $this);
        $this->id = $this->db->insert_id();
    }
}