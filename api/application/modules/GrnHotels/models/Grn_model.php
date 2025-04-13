<?php
class Grn_model extends CI_Model{
    public $jsonfile;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->dbhb = getDatabaseConnection('GrnHotels');
    }

     // update front settings
       function update_front_settings(){
        $fdata = new stdClass();
        $fdata->showHeaderFooter = $this->input->post('showheaderfooter');

        $fdata->aid = $this->input->post('aid');
        $fdata->brandID = $this->input->post('brandid');
        $fdata->searchBoxID = $this->input->post('searchid');
        $fdata->headerTitle = $this->input->post('headertitle');

        app()->service("ModuleService")->update('Hotelscombined', 'settings', $fdata);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

      function get_front_settings(){
        $fileData = app()->service("ModuleService")->get('Hotelscombined')->settings;
        return $fileData;
      }
      function get_grn_cities($city){
        $results = $this->dbhb->like('name',$city,'both')
            ->get('grn_cities')->result();
        return $results;
      }
      function getHotels($city){
          $this->dbhb->where("city_code","C!".$city);
        return  $this->dbhb->get('grn_hotels')->result();

      }
      function save_invoice($data,$accounts){
        $data["created_at"] = date('Y-m-d');
          $this->dbhb->insert('grn_bookings',$data);
        $id = $this->dbhb->insert_id();

        foreach ($accounts as $account){
            $account["booking_id"] = $id;
            $this->dbhb->insert('grn_booking_accounts',$account);
        }
        return $id;

      }
      function get_invoice($id){

          $this->dbhb->where('id',$id);
        $booking = $this->dbhb->get('grn_bookings')->row();
          $this->dbhb->where("booking_id",$id);
        $booking->accounts = $this->dbhb->get('grn_booking_accounts')->result();
        return $booking;
      }
      function bind_cities($result){
          $this->dbhb->delete('grn_cities');
          $this->dbhb->insert_batch('grn_cities', $result->cities);
      }
      function bind_hotels($result){
        foreach ($result as $item){
            $this->dbhb->insert('grn_hotels',$item);
        }
//          $this->db->insert_batch('grn_hotels', $result);
//          dd($result);
      }
      function getCountries(){
        return $this->dbhb->get('pt_flights_countries')->result();
      }

}
