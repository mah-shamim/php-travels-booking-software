<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Hotelajaxcalls extends MX_Controller {

    public $isadmin;

    function __construct() {
        modules :: load('Admin');
        $this->load->model('Hotels/Hotels_model');
        $this->load->model('Hotels/Rooms_model');
        $this->isadmin = $this->session->userdata('pt_logged_admin');
    }

    function makethumb() {
        $newthumb = $this->input->post('imgname');
        $hotelid = $this->input->post('itemid');
        $this->Hotels_model->updateHotelThumb($hotelid, $newthumb,"update");
    }

    function room_makethumb() {
        $newthumb = $this->input->post('imgname');
        $roomid = $this->input->post('itemid');
        $this->Rooms_model->updateRoomThumb($roomid, $newthumb,"update");
    }
// delete multiple Hotels

    public function delete_multiple_hotels() {
        $hotellist = $this->input->post('hotellist');
        foreach ($hotellist as $hotelid) {
            $this->Hotels_model->delete_hotel($hotelid);
        }
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// Delete Single hotel

    public function delete_single_hotel() {
        $hotelid = $this->input->post('hotelid');
        $this->Hotels_model->delete_hotel($hotelid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// delete multiple Rooms

    public function delete_multiple_rooms() {
        $roomlist = $this->input->post('roomlist');
        foreach ($roomlist as $roomid) {
            $this->Rooms_model->delete_room($roomid);
        }
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }

// Delete Single Room
    function delete_single_room() {
        $roomid = $this->input->post('roomid');
        $this->Rooms_model->delete_room($roomid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// update Hotel order

    public function update_hotel_order() {
        $hotelid = $this->input->post('id');
        $order = $this->input->post('order');
        $this->db->select('hotel_id');
        $total = $this->db->get('pt_hotels')->num_rows();

        if($order > $total){
            echo '0';
        }else{
            $this->Hotels_model->update_hotel_order($hotelid, $order);
            echo '1';
        }

    }
    public function update_discount() {
        $hotelid = $this->input->post('id');
        $order = $this->input->post('order');
        $module = $this->input->post('module');
        $this->Hotels_model->update_discount($hotelid, $order,$module);
        echo '1';
    }

// update Room order

    public function update_room_order() {
        $roomid = $this->input->post('id');
        $order = $this->input->post('order');
        $this->Rooms_model->update_room_order($roomid, $order);
    }
// update Images order

    public function update_image_order() {
        $imgid = $this->input->post('id');
        $order = $this->input->post('order');
        $this->Hotels_model->update_image_order($imgid, $order);
        echo "1";
    }
// update Images order

    public function update_room_image_order() {
        $imgid = $this->input->post('id');
        $order = $this->input->post('order');
        $this->Rooms_model->update_room_image_order($imgid, $order);
        echo "1";
    }

// delete multiple Advanced Prices

    public function delete_multiple_prices() {
        $pricelist = $this->input->post('pricelist');
        foreach ($pricelist as $priceid) {
            $this->Hotels_model->delete_prices($priceid);
        }
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// delete multiple Advanced Prices of Rooms

    public function delete_multiple_prices_room() {
        $pricelist = $this->input->post('pricelist');
        foreach ($pricelist as $priceid) {
            $this->Rooms_model->delete_prices($priceid);
        }
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// Disable multiple Hotels

    public function disable_multiple_hotels() {
        $hotellist = $this->input->post('hotellist');
        foreach ($hotellist as $hotelid) {
            $this->Hotels_model->disable_hotel($hotelid);
        }
        $this->session->set_flashdata('flashmsgs', "Disabled Successfully");
    }
// Enable multiple Hotels

    public function enable_multiple_hotels() {
        $hotellist = $this->input->post('hotellist');
        foreach ($hotellist as $hotelid) {
            $this->Hotels_model->enable_hotel($hotelid);
        }
        $this->session->set_flashdata('flashmsgs', "Enabled Successfully");
    }
// Disable multiple Rooms

    public function disable_multiple_rooms() {
        $roomlist = $this->input->post('roomlist');
        foreach ($roomlist as $roomid) {
            $this->Rooms_model->disable_room($roomid);
        }
        $this->session->set_flashdata('flashmsgs', "Disabled Successfully");
    }
// Enable multiple Rooms

    public function enable_multiple_rooms() {
        $roomlist = $this->input->post('roomlist');
        foreach ($roomlist as $roomid) {
            $this->Rooms_model->enable_room($roomid);
        }
        $this->session->set_flashdata('flashmsgs', "Enabled Successfully");
    }
// update Room Type

    public function update_roomtype() {
        $roomid = $this->input->post('id');
        $type = $this->input->post('type');
        $this->Rooms_model->update_room_type($roomid, $type);
    }
// delete single Advanced price

    public function delete_single_aprice() {
        $priceid = $this->input->post('priceid');
        $this->Hotels_model->delete_prices($priceid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// delete single Advanced price Room

    public function delete_single_aprice_room() {
        $priceid = $this->input->post('priceid');
        $this->Rooms_model->delete_prices($priceid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }
// delete single hotel unavailability

    public function delete_single_unavail() {
        $unavailid = $this->input->post('unavailid');
        $this->Hotels_model->delete_unavail($unavailid);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }

// delete multiple hotel unavailability
    function delete_multiple_unavail() {
        $unlist = $this->input->post('unlist');
        foreach ($unlist as $id) {
            $this->Hotels_model->delete_unavail($id);
        }
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }

// update featured hotel option
    function update_featured() {
        if(!empty($this->isadmin )){
            $this->Hotels_model->update_featured();
            echo "done";
        }
    }

    function add_price() {
        $this->Hotels_model->add_aprice();
    }

    function update_price() {
        $this->Hotels_model->update_aprice();
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }

    function add_unavail_hotel() {
        $this->Hotels_model->add_unavail_hotel();
    }

    function update_unavail() {
        $this->Hotels_model->update_unavail_hotel();
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }

    function add_price_room() {
        $this->load->helper('check');
        $rfrom = convert_to_unix($this->input->post('pricefrom'));
        $rto = convert_to_unix($this->input->post('priceto'));
        $roomid = $this->input->post('roomid');
        $rate = $this->input->post('basicprice');
        $advdates = pt_room_adv_dates($rfrom, $rto);
// print_r($advdates);
        foreach ($advdates as $ad) {
            $this->Rooms_model->update_room_adv($ad, $roomid, $rate);
        }
// $this->Rooms_model->add_aprice();
    }

    function update_price_room() {
        $this->Rooms_model->update_aprice();
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");
    }

    function delete_image() {
        $imgname = $this->input->post('imgname');
        $hotelid = $this->input->post('itemid');
        $imgid = $this->input->post('imgid');
        $this->Hotels_model->delete_image($imgname,$imgid,$hotelid);
    }

    function deleteMultipleHotelImages(){
        $data = $this->input->post('imgids');
        foreach($data as $d){
            $this->Hotels_model->delete_image($d['imgname'],$d['imgid'],$d['itemid']);
        }


    }

    function deleteMultipleRoomImages(){
        $data = $this->input->post('imgids');
        foreach($data as $d){
            $this->Rooms_model->delete_image($d['imgname'],$d['imgid'],$d['itemid']);
        }


    }

    function delete_room_image() {
        $imgname = $this->input->post('imgname');
        $roomid = $this->input->post('itemid');
        $imgid = $this->input->post('imgid');
        $this->Rooms_model->delete_image($imgname,$imgid,$roomid);
    }

    function app_rej_himages() {
        $this->Hotels_model->approve_reject_images();
    }

    function app_rej_rimages() {
        $this->Rooms_model->approve_reject_images();
    }



// Add hotel settings data
    function add_hotel_settings() {
        $this->Hotels_model->add_settings_data();
    }

// update hotel settings data
    function update_hotel_settings() {
        $this->Hotels_model->update_settings_data();
    }

// delete multiple settings
    function delete_multiple_settings() {
        $idlist = $this->input->post('idlist');
        foreach ($idlist as $id) {
            $this->Hotels_model->delete_settings($id);
        }
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }

// delete multiple settings
    function delete_single_settings() {
        $id = $this->input->post('id');
        $this->Hotels_model->delete_settings($id);
        $this->session->set_flashdata('flashmsgs', "Deleted Successfully");
    }

// disable multiple settings
    function disable_multiple_settings() {
        $idlist = $this->input->post('idlist');
        foreach ($idlist as $id) {
            $this->Hotels_model->disable_settings($id);
        }
        $this->session->set_flashdata('flashmsgs', "Disabled Successfully");
    }

// enable multiple settings
    function enable_multiple_settings() {
        $idlist = $this->input->post('idlist');
        foreach ($idlist as $id) {
            $this->Hotels_model->enable_settings($id);
        }
        $this->session->set_flashdata('flashmsgs', "Enabled Successfully");
    }
// Delete Hotel
    function delHotel(){
        $id = $this->input->post('id');
        $this->Hotels_model->delete_hotel($id);
    }
// Delete Multiple Hotels
    function delMultipleHotels(){
        $items = $this->input->post('items');
        foreach($items as $item){
            $this->Hotels_model->delete_hotel($item);
        }


    }
// Delete Room
    function delRoom(){
        $id = $this->input->post('id');
        $this->Rooms_model->deleteRoom($id);
    }
// Delete Multiple Rooms
    function delMultipleRooms(){
        $items = $this->input->post('items');
        foreach($items as $item){
            $this->Rooms_model->deleteRoom($item);
        }


    }
// Delete Room Prices
    function deleteRoomPrice(){
        $id = $this->input->post('id');
        $this->Rooms_model->deleteRoomPrice($id);
    }

    function delTypeSettings(){
        $id = $this->input->post('id');
        $this->Hotels_model->deleteTypeSettings($id);
    }

    // delete multiple settings
    function delMultiTypeSettings($type){

        $items = $this->input->post('items');

        foreach($items as $item){
            $this->Hotels_model->deleteMultiplesettings($item,$type);
        }

    }

    function hotelExtrasBooking()
    {
        $this->load->library('currconverter');
        $this->load->library('Hotels/Hotels_lib');
        $hotelid = $this->input->post('itemid');
        $roomid = $this->input->post('subitemid');
        $checkin = $this->input->post('checkin');
        $checkout = $this->input->post('checkout');
        $roomscount = $this->input->post('roomscount');
        $extras = $this->input->post('extras');
        $extrabeds = $this->input->post('bedscount');
        $adults = $this->input->post('adults');
        $taxAmount = $this->input->post('taxAmount');

        $total_rooms = explode(',', $roomid);
        $_roomscount = explode(',', $roomscount);
        $_extrabeds = json_decode($extrabeds, true);
        $response = array();
        foreach ($total_rooms as $index => $roomid)
        {
            $taxamount = 'ignore';
            $_extras = 0;
            $roomscount = $_roomscount[$index];
            $extrabeds = (isset($_extrabeds[$roomid]))?$_extrabeds[$roomid]:0;
            $_response = $this->Hotels_lib->getUpdatedDataBookResultObject($hotelid,$roomid,$checkin,$checkout,$roomscount,$_extras,$extrabeds, $adults, $taxamount);
            array_push($response, json_decode($_response));
        }

        $_final_response = new stdClass;
        $_final_response->grandTotal = 0;
        $_final_response->taxAmount = 0;
        $_final_response->depositAmount = 0;
        $_final_response->extrashtml = '';
        $_final_response->bookingType = '';
        $_final_response->currCode = '';
        $_final_response->currSymbol = '';
        $_final_response->subitem = array();
        $_final_response->stay = 0;
        $_final_response->extrasInfo = [];
        $_final_response->extraBedCharges = 0;
        foreach ($response as $resp)
        {
            $_final_response->tmp[] = $resp;
            $_final_response->grandTotal += $this->currconverter->removeComma($resp->grandTotal);
            $_final_response->taxAmount += $resp->taxAmount;
            $_final_response->depositAmount += round($resp->depositAmount);
            $_final_response->extrashtml .= $resp->extrashtml;
            $_final_response->bookingType = $resp->bookingType;
            $_final_response->currCode = $resp->currCode;
            $_final_response->currSymbol = $resp->currSymbol;
            $_final_response->subitem[] = $resp->subitem;
            $_final_response->extrasInfo = $resp->extrasInfo;
            $_final_response->stay = $resp->stay;
            $_final_response->extraBedCharges = $resp->extraBedCharges;
        }
        $this->load->library('currconverter');
        $curr = $this->currconverter;
        $extratotal = $this->Hotels_lib->extrasFee($extras);
        if (isset($extratotal['extrasTotalFee']) && ! empty($extratotal['extrasTotalFee'])) {
            $_final_response->grandTotal += $extratotal['extrasTotalFee'];
        }
        // Desposit amount
        $this->Hotels_lib->setDeposit($_final_response->grandTotal);
        $_final_response->depositAmount = $this->Hotels_lib->deposit;
        // Tax amount
        $this->Hotels_lib->setTax($_final_response->grandTotal);
        $_final_response->taxAmount = $this->Hotels_lib->taxamount;
        $_final_response->grandTotal += $_final_response->taxAmount;

        if(isset($extratotal['extrasInfo']) && ! empty($extratotal['extrasInfo'])) {
            foreach ($extratotal['extrasInfo'] as $einfo) {
                $_final_response->extrashtml .= "<li class='allextras'>". $einfo['title'] ."<span class='absolute-right'>
					" . $curr->symbol . $einfo['price'] . "</li>";

            }
        }
        $this->output->set_output(json_encode($_final_response));
    }

}