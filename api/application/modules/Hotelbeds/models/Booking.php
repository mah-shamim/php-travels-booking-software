<?php

class Booking extends CI_Model
{
    const DB_TABLE = 'pt_hotelbeds_booking';
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
        $invoice = $this->db->get(self::DB_TABLE)->row();
        $response_object = json_decode($invoice->response_object);
        $invoice->{'room'} = current($response_object->booking->hotel->rooms);
        $invoice->{'room_rate'} = current($invoice->{'room'}->rates);
        return $invoice;
    }

    public function save()
    {
        unset($this->id);
        $this->db->insert(self::DB_TABLE, $this);
        $this->id = $this->db->insert_id();
    }
}