<?php

function getContinentName($value)
{
    $CI =& get_instance();
    $dataAdapter = $CI->db->where('id', $value)->get('sabre_continents');
    if ($dataAdapter->num_rows() > 0) {
        return $dataAdapter->row()->name;
    }
    return '';
}

function publish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function unpublish_action($xcrud)
{
    if ($xcrud->get('primary'))
    {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$xcrud->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $xcrud)
{
    // get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
    // set error message
    $xcrud->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $xcrud)
{
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $xcrud)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload')
    {
        unlink($file_path);
        $xcrud->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}


function show_description($value, $fieldname, $primary_key, $row, $xcrud)
{
    $result = '';
    if ($value == '1')
    {
        $result = '<i class="fa fa-check" />' . 'OK';
    }
    elseif ($value == '2')
    {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $xcrud)
{
    return '<input type="text" readonly class="xcrud-input" name="' . $xcrud->fieldname_encode($fieldname) . '" value="' . $value .
        '" />';
}
function unset_val($postdata)
{
    $postdata->del('Paid');
}

function format_phone($new_phone)
{
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $xcrud)
{
    var_dump($list);
}

function create_status_icon($value, $fieldname, $primary_key, $row, $xcrud)
{
    if($value == "Yes" || $value == "yes"){
        return '<i class="fa fa-check text-success"></i>';
    }else{
        return '<i class="fa fa-times text-danger"></i>';
    }

}

function long_date_fmt($value, $fieldname, $primary_key, $row, $xcrud)
{
    if(!empty($value)){
        return date("F j Y, h:i a",$value);
    }else{
        return "";
    }


}

function fmtDate($value, $fieldname, $primary_key, $row, $xcrud)
{
    if(!empty($value)){
        return pt_show_date_php($value);
    }else{
        return "";
    }
}

function Hbooking_fmtDate($value, $fieldname, $primary_key, $row, $xcrud)
{
    if(!empty($value)){
        $date=date_create($value);
        return date_format($date,"d/m/Y");
    }else{
        return "";
    }


}

function create_stars($value, $fieldname, $primary_key, $row, $xcrud) {
    $res = "";

    for($stars = 1; $stars <= 5; $stars++){

        if($stars <= $value){
            $res .= PT_STARS_ICON;
        }else{
            $res .= PT_EMPTY_STARS_ICON;
        }

    }


    return $res;
}

function feature_stars($value, $fieldname, $primary_key, $row, $xcrud){
    $url = base_url()."admin/hotelajaxcalls/update_featured";
    if($value == "yes"){
        return "<span class='star fa fa-star' onclick='fstar(\"$url\",\"no\",\"$primary_key\")' id=\"$primary_key\"  style='cursor: pointer;'></span>";
    }else{
        return "<span class='fa fa-star-o fstar' onclick='fstar(\"$url\",\"yes\",\"$primary_key\")' id=\"$primary_key\" style='cursor: pointer;' ></span>";
    }
}

// tours packages anchor
function packages($value, $fieldname, $primary_key, $row, $xcrud){
    return "<button class='btn btn-success btn-md' onClick=show_packages('".$primary_key."')> Packages </button>";
}

function hotelGallery($value, $fieldname, $primary_key, $row, $xcrud){
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }

    $photocounts =  pt_HotelPhotosCount($primary_key);
    return "<a href=".base_url().$role."/hotels/gallery/".$value.">Upload (".$photocounts.")</a>";
}

function image($value, $fieldname, $primary_key, $row, $xcrud){
    if (isset($value)) {
        $image_res = 'Image!';
        return "<img src=".base_url().PT_HOTELS_SLIDER_THUMBS_UPLOAD.$value." alt=".$image_res.">";
    }

}

function roomGallery($value, $fieldname, $primary_key, $row, $xcrud){
    $photocounts =  pt_RoomPhotosCount($primary_key);
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/hotels/roomgallery/".$primary_key.">Upload (".$photocounts.")</a>";
}

function roomPrices($value, $fieldname, $primary_key, $row, $xcrud){
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/hotels/rooms/prices/".$primary_key.">Prices </a>";
}

function flightPrices($value, $fieldname, $primary_key, $row, $xcrud){
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/flights/prices/".$primary_key.">Prices </a>";
}


function roomAvail($value, $fieldname, $primary_key, $row, $xcrud){
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/hotels/rooms/availability/".$primary_key.">Availability </a>";
}

function orderInputHotels($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."admin/hotelajaxcalls/update_hotel_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';


}

function discountInputHotels($value, $fieldname, $primary_key, $row, $xcrud) {
    $url_ = base_url()."admin/hotelajaxcalls/update_discount";
        $module = "hotels";
    return '<input style="width:60px" class="form-control input-sm" data-url='.$url_.'  data-module='.$module.' type="number" id="discount_'.$primary_key.'" value='.$value.' min="1" max="100" onblur="updateDiscount($(this).val(),'.$primary_key.','.$value.')" />';

}
function discountInputTours($value, $fieldname, $primary_key, $row, $xcrud) {
    $url_ = base_url()."admin/hotelajaxcalls/update_discount";
    $module = "tours";
    return '<input style="width:60px" class="form-control input-sm" data-url='.$url_.'  data-module='.$module.' type="number" id="discount_'.$primary_key.'" value='.$value.' min="1" max="100" onblur="updateDiscount($(this).val(),'.$primary_key.','.$value.')" />';

}


function discountInputRentals($value, $fieldname, $primary_key, $row, $xcrud) {
    $url_ = base_url()."admin/hotelajaxcalls/update_discount";
    $module = "rentals";
    return '<input style="width:60px" class="form-control input-sm" data-url='.$url_.'  data-module='.$module.' type="number" id="discount_'.$primary_key.'" value='.$value.' min="1" max="100" onblur="updateDiscount($(this).val(),'.$primary_key.','.$value.')" />';

}


function discountInputBoats($value, $fieldname, $primary_key, $row, $xcrud) {
    $url_ = base_url()."admin/hotelajaxcalls/update_discount";
    $module = "boats";
    return '<input style="width:60px" class="form-control input-sm" data-url='.$url_.'  data-module='.$module.' type="number" id="discount_'.$primary_key.'" value='.$value.' min="1" max="100" onblur="updateDiscount($(this).val(),'.$primary_key.','.$value.')" />';

}

function discountInputCars($value, $fieldname, $primary_key, $row, $xcrud) {
    $url_ = base_url()."admin/hotelajaxcalls/update_discount";
    $module = "tours";
    return '<input style="width:60px" class="form-control input-sm" data-url='.$url_.'  data-module='.$module.' type="number" id="discount_'.$primary_key.'" value='.$value.' min="1" max="100" onblur="updateDiscount($(this).val(),'.$primary_key.','.$value.')" />';

}

function translateExtras($value, $fieldname, $primary_key, $row, $xcrud){
    return '<a href="#extra'.$primary_key.'" data-toggle="modal"> Translate </a>';
}

function assignExtras($value, $fieldname, $primary_key, $row, $xcrud){
    return '<a href="#assign'.$primary_key.'" data-toggle="modal"> Assign </a>';
}

function orderInputPost($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."admin/ajaxcalls/update_post_order";

        return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';

}

function orderInputSlider($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."admin/ajaxcalls/update_slide_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';

}

function translateSlider($value, $fieldname, $primary_key, $row, $xcrud){
    $url = base_url().'admin/settings/sliders/translate/'.$primary_key;
    return '<a href="'.$url.'" > Translate </a>';
}

function orderInputSocial($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."admin/ajaxcalls/update_social_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';

}

function widgetCode($value, $fieldname, $primary_key, $row, $xcrud) {
    $string = "<?php echo run_widget(\$id); ?>";
    $str = str_replace("\$id",$value,$string);

    return htmlentities($str);

}

function orderInputOffers($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."admin/ajaxcalls/update_offers_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';

}

function OffersPhotos($value, $fieldname, $primary_key, $row, $xcrud){
    $photocounts =  pt_OffersPhotosCount($primary_key);
    return "<a href=".base_url()."admin/offers/gallery/".$primary_key.">Upload (".$photocounts.")</a>";
}

function MakeDefault($value, $fieldname, $primary_key, $row, $xcrud){
    if($value == "No"){
        $url = base_url().'admin/ajaxcalls/makeCurrDefault';
        return "<span id='".$primary_key."' data-url='".$url."' class='makeDefault btn btn-md' ><i style='font-size:18px' class='fa fa-circle-o'></i></span>";
    }else{
        return "<span class='btn btn-md ' ><i style='font-size:18px' class='fa fa-circle fa-2x'></i></span>";
    }


}

function pay_status($value, $fieldname, $primary_key, $row, $xcrud){
    if($value == "1"){
        return "Enabled";
    }else{
        return "Disabled";
    }


}

//Rentals functions

function rentalGallery($value, $fieldname, $primary_key, $row, $xcrud){
    $photocounts =  pt_RentalPhotosCount($primary_key);
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/rentals/gallery/".$value.">Upload (".$photocounts.")</a>";
}

function orderInputRentals($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."rentals/rentalajaxcalls/update_rental_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';


}


function feature_starsRentals($value, $fieldname, $primary_key, $row, $xcrud){
    $url = base_url()."rentals/rentalajaxcalls/update_featured";
    if($value == "yes"){
        return "<span class='star fa fa-star' onclick='fstar(\"$url\",\"no\",\"$primary_key\")' id=\"$primary_key\"  style='cursor: pointer;'></span>";
    }else{
        return "<span class='fa fa-star-o fstar' onclick='fstar(\"$url\",\"yes\",\"$primary_key\")' id=\"$primary_key\" style='cursor: pointer;' ></span>";
    }

}


//BOATS functions

function BoatGallery($value, $fieldname, $primary_key, $row, $xcrud){
    $photocounts =  pt_BoatPhotosCount($primary_key);
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/boats/gallery/".$value.">Upload (".$photocounts.")</a>";
}

function orderInputboats($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."boats/boatajaxcalls/update_boat_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';


}


function feature_starsboats($value, $fieldname, $primary_key, $row, $xcrud){
    $url = base_url()."boats/boatajaxcalls/update_featured";
    if($value == "yes"){
        return "<span class='star fa fa-star' onclick='fstar(\"$url\",\"no\",\"$primary_key\")' id=\"$primary_key\"  style='cursor: pointer;'></span>";
    }else{
        return "<span class='fa fa-star-o fstar' onclick='fstar(\"$url\",\"yes\",\"$primary_key\")' id=\"$primary_key\" style='cursor: pointer;' ></span>";
    }

}

//Tours functions

function tourGallery($value, $fieldname, $primary_key, $row, $xcrud){
    $photocounts =  pt_TourPhotosCount($primary_key);
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/tours/gallery/".$value.">Upload (".$photocounts.")</a>";
}

function orderInputTours($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."tours/tourajaxcalls/update_tour_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';


}

function feature_starsTours($value, $fieldname, $primary_key, $row, $xcrud){
    $url = base_url()."tours/tourajaxcalls/update_featured";
    if($value == "yes"){
        return "<span class='star fa fa-star' onclick='fstar(\"$url\",\"no\",\"$primary_key\")' id=\"$primary_key\"  style='cursor: pointer;'></span>";
    }else{
        return "<span class='fa fa-star-o fstar' onclick='fstar(\"$url\",\"yes\",\"$primary_key\")' id=\"$primary_key\" style='cursor: pointer;' ></span>";
    }

}


//Cars functions

function carGallery($value, $fieldname, $primary_key, $row, $xcrud){
    $photocounts =  pt_carPhotosCount($primary_key);
    $CI = get_instance();
    $role = $CI->session->userdata('pt_role');
    if($role != "supplier"){
        $role = "admin";
    }
    return "<a href=".base_url().$role."/cars/gallery/".$value.">Upload (".$photocounts.")</a>";
}

function orderInputCars($value, $fieldname, $primary_key, $row, $xcrud) {
    $url = base_url()."cars/carajaxcalls/update_car_order";

    return '<input class="form-control input-sm" data-url='.$url.' type="number" id="order_'.$primary_key.'" value='.$value.' min="1"  onblur="updateOrder($(this).val(),'.$primary_key.','.$value.')" />';


}

function feature_starsCars($value, $fieldname, $primary_key, $row, $xcrud){
    $url = base_url()."cars/carajaxcalls/update_featured";

    if($value == "yes"){
        return "<span class='star fa fa-star' onclick='fstar(\"$url\",\"no\",\"$primary_key\")' id=\"$primary_key\"  style='cursor: pointer;'></span>";
    }else{
        return "<span class='fa fa-star-o fstar' onclick='fstar(\"$url\",\"yes\",\"$primary_key\")' id=\"$primary_key\" style='cursor: pointer;' ></span>";
    }

}
/*hotels booking invoice_url*/
function Hinvoice_url($value, $fieldname, $primary_key, $row, $xcrud){
        $url = base_url('hotels/booking/')."?id=".$row["hotels_bookings.booking_id"]."&sessid=".$row["hotels_bookings.booking_ref_no"];

    return "<a class='btn btn-success' target='_blank' href='".$url."'  style='cursor: pointer;' >View Invoice</a>";
}

function invoice_url($value, $fieldname, $primary_key, $row, $xcrud){
    if($row["pt_bookings.booking_type"] == "viator"){
        $url = $row["pt_bookings.booking_logs"];
    }else{
        $url = base_url('invoice')."?id=".$row["pt_bookings.booking_id"]."&sessid=".$row["pt_bookings.booking_ref_no"];

    }
    return "<a class='btn btn-success' target='_blank' href='".$url."'  style='cursor: pointer;' >View Invoice</a>";
}
function getCommissionHotels($value, $fieldname, $primary_key, $row, $xcrud){
    $url_ = base_url()."admin/ajaxcalls/update_commission_hotels";
    $ci = get_instance();
    $ci->load->model('Admin/Accounts_model');
    $comission = $ci->Accounts_model->getCommissionHotels($primary_key,$row['pt_accounts.commission']);
    if($fieldname == 'pt_accounts.ai_website'){
        return '<input  class="form-control input-sm" id="'.$primary_key.'"  type="button" id="order_'.$primary_key.'" value='.$comission.' min="1"   />';
    }else{
        return '<input  class="form-control input-sm btn btn-success" id="'.$primary_key.'"  type="button" id="order_'.$primary_key.'" value="Mark Paid" min="1"  onclick="updateStatusComission(\''.$url_.'\','.$primary_key.')" />';
    }

}
function getCommissionTours($value, $fieldname, $primary_key, $row, $xcrud){
    $url_ = base_url()."admin/ajaxcalls/update_commission_tours";
    $ci = get_instance();
    $ci->load->model('Admin/Accounts_model');
    $comission = $ci->Accounts_model->getCommissionTours($primary_key,$row['pt_accounts.commission']);

    if($fieldname == 'pt_accounts.ai_website'){
        return '<input  class="form-control input-sm" id="'.$primary_key.'"  type="button" id="order_'.$primary_key.'" value='.$comission.' min="1"   />';
    }else{
        return '<input  class="form-control input-sm btn btn-success" id="'.$primary_key.'"  type="button" id="order_'.$primary_key.'" value="Mark Paid" min="1"  onclick="updateStatusComission(\''.$url_.'\','.$primary_key.')" />';
    }

}
function getCommissionCars($value, $fieldname, $primary_key, $row, $xcrud){
    $url_ = base_url()."admin/ajaxcalls/update_commission_cars";
    $ci = get_instance();
    $ci->load->model('Admin/Accounts_model');
    $comission = $ci->Accounts_model->getCommissionCars($primary_key,$row['pt_accounts.commission']);
    if($fieldname == 'pt_accounts.ai_website'){
        return '<input  class="form-control input-sm" id="'.$primary_key.'"  type="button" id="order_'.$primary_key.'" value='.$comission.' min="1"   />';
    }else{
        return '<input  class="form-control input-sm btn btn-success" id="'.$primary_key.'"  type="button" id="order_'.$primary_key.'" value="Mark Paid" min="1"  onclick="updateStatusComission(\''.$url_.'\','.$primary_key.')" />';
    }
}

function bookingStatusBtns($value, $fieldname, $primary_key, $row, $xcrud)
{
    $btntype = "info";
    if($value == "paid"){
        $btntype = "success";
    }elseif($value == "cancelled"){
        $btntype = "danger";

    }elseif($value == "reserved"){
        $btntype = "warning";
    }

    return '<span class="btn btn-xs btn-' .$btntype. '">'.ucfirst($value).'</span>';
}

function kiwitaxibookingStatusBtns($value,$fieldname, $primary_key, $row, $xcrud){
    if($value == 1){
        $status = 'paid';
        $btntype = "success";
    }else if($value == 2){
        $status = 'fail';
        $btntype = "danger";
    }else if($value == 3){
        $status = 'cancel';
        $btntype = "danger";
    }else{
        $status = 'unpaid';
        $btntype = "danger";
    }

    return '<span class="btn btn-xs btn-' .$btntype. '">'.ucfirst($status).'</span>';
}

function kiwitaxibookingdatetime($value,$fieldname, $primary_key, $row, $xcrud){

    return str_replace('+',' ',$value);
}

function reloadPage($primary, $xcrud)
{
    echo "<script type='text/javascript'>";
    echo "location.reload();";
    echo "</script>";
}

function locationsInfo($value, $fieldname, $primary_key, $row, $xcrud){

    $loc =  pt_LocationsInfo($value);

    if(!empty($value)){

        // $location = $loc->country." - ".$loc->city;
        $location = $loc->city;

    }else{

        $location = "";

    }
    return $location;
}

function carsFirstLocation($value, $fieldname, $primary_key, $row, $xcrud){
    $ci = get_instance();
    $ci->db->select('pickup_location_id');
    $ci->db->where('car_id',$primary_key);
    $ci->db->order_by('position','asc');
    $ci->db->limit(1);
    $res = $ci->db->get('pt_car_locations')->result();
    $location = 0;
    if(!empty($res)){
        $location = $res[0]->pickup_location_id;
    }

    $loc =  pt_LocationsInfo($location);

    if(!empty($location)){

        $carLoc = $loc->city;

    }else{

        $carLoc = "";

    }

    return $carLoc;
}

//Delete Coupon data from coupoin assign table
function deleteCouponData($primary, $xcrud){
    $db = Xcrud_db::get_instance();
    $db->query('DELETE FROM pt_coupons_assign WHERE couponid = ' . $db->escape($primary));
}


function countryName($value, $fieldname, $primary_key, $row, $xcrud){
    $ci = get_instance();
    $ci->load->model('Admin/Countries_model');
    return  $ci->Countries_model->getCountryInfo($value);
}
