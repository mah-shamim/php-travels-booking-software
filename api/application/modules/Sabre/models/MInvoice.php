<?php 

class MInvoice extends CI_Model 
{
    public $id;
    public $PNR;
    public $fullname;
    public $email;
    public $phone;
    public $base_fare;
    public $tax;
    public $administration_fee;
    public $total;
    public $data;

    public function save($data)
    {
        $this->load($data->PNR);
        if (empty($this->id))
        {
            $this->db->set('PNR', $data->PNR);
            $this->db->set('fullname', $data->fullname);
            $this->db->set('email', $data->email);
            $this->db->set('phone', $data->phone);
            $this->db->set('base_fare', $data->baseFare);
            $this->db->set('tax', $data->tax);
            $this->db->set('administration_fee', $data->administrationFee);
            $this->db->set('total', $data->total);
            $this->db->set('data', serialize($data));
            $this->db->insert('sabre_bookings');
        }
    }

    public function load($PNR)
    {
        $this->db->where('PNR', $PNR);
        $dataAdapter = $this->db->get('sabre_bookings');
        if ($dataAdapter->num_rows() > 0) {
            $row = $dataAdapter->row();
            $this->populate($row);
            // $this->id = $row->id;
            // $this->PNR = $row->PNR;
            // $this->fullname = $row->fullname;
            // $this->email = $row->email;
            // $this->phone = $row->phone;
            // $this->base_fare = $row->base_fare;
            // $this->tax = $row->tax;
            // $this->administration_fee = $row->administration_fee;
            // $this->total = $row->total;
            // $this->data = $row->data;
        }
    }

    public function populate($row)
    {
        foreach ($row as $key => $val)
        {
            $this->{$key} = $val;
        }
    }
}