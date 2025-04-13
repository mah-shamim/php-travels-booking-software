<?php 

class TravelportHotelModel_Conf extends CI_Model 
{
    const DB_TABLE = 'tporthotel_configuration';
    const DB_PK = 'id';

    public $id;
    public $target;
    public $header_title;
    public $api_username;
    public $api_password;
    public $branch_code;
    public $pcc;
    public $api_endpoint;
    public $sandbox_mode;
    public $default_origin;
    public $default_destination;
    public $meta_keywords;
    public $meta_description;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_id() { return $this->id; }
    public function get_target() { return $this->target; }
    public function get_header_title() { return $this->header_title; }
    public function get_api_username() { return $this->api_username; }
    public function get_api_password() { return $this->api_password; }
    public function get_branch_code() { return $this->branch_code; }
    public function get_pcc() { return $this->pcc; }
    public function get_api_endpoint() { return $this->api_endpoint; }
    public function get_sandbox_mode() { return $this->sandbox_mode; }
    public function get_default_origin() { return $this->default_origin; }
    public function get_default_destination() { return $this->default_destination; }
    public function get_meta_keywords() { return $this->meta_keywords; }
    public function get_meta_description() { return $this->meta_description; }
    public function get_created_at() { return $this->created_at; }
    public function get_updated_at() { return $this->updated_at; }

    public function set_id($id) { $this->id = $id; }
    public function set_target($target) { $this->target = $target; }
    public function set_header_title($header_title) { $this->header_title = $header_title; }
    public function set_api_username($api_username) { $this->api_username = $api_username; }
    public function set_api_password($api_password) { $this->api_password = $api_password; }
    public function set_branch_code($branch_code) { $this->branch_code = $branch_code; }
    public function set_pcc($pcc) { $this->pcc = $pcc; }
    public function set_api_endpoint($api_endpoint) { $this->api_endpoint = $api_endpoint; }
    public function set_sandbox_mode($sandbox_mode) { $this->sandbox_mode = $sandbox_mode; }
    public function set_default_origin($default_origin) { $this->default_origin = $default_origin; }
    public function set_default_destination($default_destination) { $this->default_destination = $default_destination; }
    public function set_meta_keywords($meta_keywords) { $this->meta_keywords = $meta_keywords; }
    public function set_meta_description($meta_description) { $this->meta_description = $meta_description; }
    public function set_created_at($created_at) { $this->created_at = $created_at; }
    public function set_updated_at($updated_at) { $this->updated_at = $updated_at; }

    public function load()
    {
        $dataAdapter = $this->db->get($this::DB_TABLE);
        if ($dataAdapter->num_rows() > 0) {
            foreach($dataAdapter->row() as $col => $val) {
                $this->{$col} = $val;
            }
        }
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $dataAdapter = $this->db->get($this::DB_TABLE);
        if($dataAdapter->num_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->update($this::DB_TABLE, $data);
        } else {
            $this->db->insert($this::DB_TABLE, $data);
        }
    }
}