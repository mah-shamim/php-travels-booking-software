<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('invoiceDetails'))
{
    function invoiceDetails($id,$ref,$reviewData = null)
    {
      $CI = get_instance();
        $CI->db->select('pt_bookings.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $CI->db->where('pt_bookings.booking_id',$id);
        $CI->db->where('pt_bookings.booking_ref_no',$ref);
        $CI->db->join('pt_accounts','pt_bookings.booking_user = pt_accounts.accounts_id','left');
        $invoiceData = $CI->db->get('pt_bookings')->result();
        $bookingsubitem = json_decode($invoiceData[0]->booking_subitem);
        $bookingExtras = json_decode($invoiceData[0]->booking_extras);
        $bookingExtrasInfo = array();
        $subItemData = "";
        $itemData = "";
        $fullExpiry =  date('F j Y',$invoiceData[0]->booking_expiry);
        $bookedItemInfo = "";

         $imgPathExtras = "";
        if($invoiceData[0]->booking_type == 'hotels'){
          $imgPathExtras = PT_EXTRAS_IMAGES;
        }else if($invoiceData[0]->booking_type == 'tours'){
          $imgPathExtras = PT_TOURS_EXTRAS_IMAGES;
        }else if($invoiceData[0]->booking_type == 'rentals'){
            $imgPathExtras = PT_RENTALS_EXTRAS_IMAGES;
        }else if($invoiceData[0]->booking_type == 'boats'){
            $imgPathExtras = PT_BOATS_EXTRAS_IMAGES;
        }else if($invoiceData[0]->booking_type == 'cars'){
          $imgPathExtras = PT_CARS_EXTRAS_IMAGES;
        }

        if(!empty($bookingExtras)){

         foreach($bookingExtras as $bext){
          $extTitle = getExtraTitleImg($bext->id);

          $bookingExtrasInfo[] = (object)array("id" => $bext->id,"title" => $extTitle->title,"price" => $bext->price,"thumbnail" => $imgPathExtras.$extTitle->image);
        }

        }

        if($invoiceData[0]->booking_type == 'hotels'){
          $CI->load->library('Hotels/Hotels_lib');
          $CI->Hotels_lib->set_id($invoiceData[0]->booking_item);
          $lang = $CI->input->get('lang');

          if(!empty($lang)){
          $CI->Hotels_lib->set_lang($lang);
          }

          $CI->Hotels_lib->hotel_short_details();
          $itemData = array(
            "title" => $CI->Hotels_lib->title,
            'thumbnail' => $CI->Hotels_lib->thumbnail,
            'stars' => pt_create_stars($CI->Hotels_lib->stars),
            'location' => $CI->Hotels_lib->location,
            'latitude' => $CI->Hotels_lib->latitude,
            'longitude' => $CI->Hotels_lib->longitude,
            'hotelAddress' => $CI->Hotels_lib->hoteladdress,
            'hotel_phone' => $CI->Hotels_lib->phone,
            );
          
          // dd($itemData);
          $subItemData = array();
          $bookingsubitem = (is_array($bookingsubitem))?$bookingsubitem:[$bookingsubitem];
          foreach($bookingsubitem as $item) {
            $roomTitle = $CI->Hotels_lib->getRoomTitleOnly($item->id);
            $subItemData[] = (object)array(
              'id' => $item->id,
              'title' => $roomTitle,
              'price' => $item->price,
              'quantity' => $item->count,
              'totalNightsPrice' => $item->price * $item->count * $invoiceData[0]->booking_nights,
              'total' => $item->price * $item->count
            ); 
          }

        }
        elseif($invoiceData[0]->booking_type == 'tours'){
          $CI->load->library('Tours/Tours_lib');
          $CI->Tours_lib->set_id($invoiceData[0]->booking_item);
          $lang = $CI->input->get('lang');

          if(!empty($lang)){
          $CI->Tours_lib->set_lang($lang);
          }
          $CI->Tours_lib->tour_short_details();
          $itemData = array(
            "title" => $CI->Tours_lib->title,
            'thumbnail' => $CI->Tours_lib->thumbnail,
            'stars' => pt_create_stars($CI->Tours_lib->stars),
            'location' => $CI->Tours_lib->location,
            );
          $subItemData = $bookingsubitem;
          /*
          $subItemData = (object)array(
            'id' => $bookingsubitem->id,
            'title' => $roomTitle,
            'price' => $bookingsubitem->price,
            'quantity' => $bookingsubitem->count,
            'totalNightsPrice' => $bookingsubitem->price * $bookingsubitem->count * $invoiceData[0]->booking_nights,
            'total' => $bookingsubitem->price * $bookingsubitem->count);*/
        }elseif($invoiceData[0]->booking_type == 'rentals'){
            $CI->load->library('Rentals/Rentals_lib');
            $CI->Rentals_lib->set_id($invoiceData[0]->booking_item);
            $lang = $CI->input->get('lang');

            if(!empty($lang)){
                $CI->Rentals_lib->set_lang($lang);
            }
            $CI->Rentals_lib->rental_short_details();
            $itemData = array(
                "title" => $CI->Rentals_lib->title,
                'thumbnail' => $CI->Rentals_lib->thumbnail,
                'stars' => pt_create_stars($CI->Rentals_lib->stars),
                'location' => $CI->Rentals_lib->location,
            );
            $subItemData = $bookingsubitem;
        }elseif($invoiceData[0]->booking_type == 'boats'){
            $CI->load->library('Boats/Boats_lib');
            $CI->Boats_lib->set_id($invoiceData[0]->booking_item);
            $lang = $CI->input->get('lang');

            if(!empty($lang)){
                $CI->Boats_lib->set_lang($lang);
            }
            $CI->Boats_lib->boat_short_details();
            $itemData = array(
                "title" => $CI->Boats_lib->title,
                'thumbnail' => $CI->Boats_lib->thumbnail,
                'stars' => pt_create_stars($CI->Boats_lib->stars),
                'location' => $CI->Boats_lib->location,
            );
            $subItemData = $bookingsubitem;
        }elseif($invoiceData[0]->booking_type == 'cars'){
          $CI->load->library('Cars/Cars_lib');
          $CI->Cars_lib->set_id($invoiceData[0]->booking_item);
          $lang = $CI->input->get('lang');

          if(!empty($lang)){
          $CI->Cars_lib->set_lang($lang);
          }
          $CI->Cars_lib->car_short_details();
          $itemData = array(
            "title" => $CI->Cars_lib->title,
            'thumbnail' => $CI->Cars_lib->thumbnail,
            'stars' => pt_create_stars($CI->Cars_lib->stars),
            'location' => $CI->Cars_lib->location,
            );
          $subItemData = $bookingsubitem;
          $bookedItemInfo = $CI->Cars_lib->bookedInvoiceInfo($id);

        }

        $currencySymbol = $invoiceData[0]->booking_curr_symbol;
        if(empty($currencySymbol)){
         $currencySymbol = "";
        }

        //dd($invoiceData);
        $returnData = (object)array("id" => $invoiceData[0]->booking_id,
          "module" => $invoiceData[0]->booking_type,
          "itemid" => $invoiceData[0]->booking_item,
          "paymethod" => $invoiceData[0]->booking_payment_type,
          "code" => $invoiceData[0]->booking_ref_no,
          "nights" => $invoiceData[0]->booking_nights,
          "checkin" => fromDbToAppFormatDate($invoiceData[0]->booking_checkin),
          "checkout" => fromDbToAppFormatDate($invoiceData[0]->booking_checkout),
          "date" => pt_show_date_php($invoiceData[0]->booking_date),
          "currCode" => $invoiceData[0]->booking_curr_code,
          "currSymbol" => $currencySymbol,
          "checkoutAmount" => $invoiceData[0]->booking_deposit,
          "checkoutTotal" => $invoiceData[0]->booking_total,
          "status" => $invoiceData[0]->booking_status,
          "accountEmail" => $invoiceData[0]->accounts_email,
          "bookingID" => $invoiceData[0]->booking_id,
          "expiry" => pt_show_date_php($invoiceData[0]->booking_expiry),
          "expiryUnixtime" => $invoiceData[0]->booking_expiry,
          "bookingDate" => pt_show_date_php($invoiceData[0]->booking_date),
          "title" => $itemData['title'],
          "thumbnail" => $itemData['thumbnail'],
          "stars" => $itemData['stars'],
          "location" => $itemData['location'],
          "latitude" => $itemData['latitude'],
          "longitude" => $itemData['longitude'],
          "hotelAddress" => $itemData['hotelAddress'],
          "hotel_phone" => $itemData['hotel_phone'],
          "nights" => $invoiceData[0]->booking_nights,
          "tax" => $invoiceData[0]->booking_tax,
          "subItem" => $subItemData,
          "extraBeds" => $invoiceData[0]->booking_extra_beds,
          "extraBedsCharges" => $invoiceData[0]->booking_extra_beds_charges,
          "cancelRequest" => $invoiceData[0]->booking_cancellation_request,
          "expiryFullDate" => $fullExpiry,
          "reviewsData" => $reviewData,
          "bookingExtras" => $bookingExtrasInfo,
          "amountPaid" => $invoiceData[0]->booking_amount_paid,
          "bookingUser" => $invoiceData[0]->booking_user,
          "userCountry" => $invoiceData[0]->ai_country,
          "userFullName" => $invoiceData[0]->ai_first_name . " " . $invoiceData[0]->ai_last_name,
          "userMobile" => $invoiceData[0]->ai_mobile,
          "userAddress" => $invoiceData[0]->ai_address_1. " " . $invoiceData[0]->ai_address_2,
          "additionaNotes" => $invoiceData[0]->booking_additional_notes,
          "couponCode" => $invoiceData[0]->booking_coupon,
          "couponRate" => $invoiceData[0]->booking_coupon_rate,
          "remainingAmount" => $invoiceData[0]->booking_remaining,
          "guestInfo" => json_decode($invoiceData[0]->booking_guest_info),
          "bookedItemInfo" => $bookedItemInfo,
          "setting_id" => $invoiceData[0]->setting_id,


          );

          return $returnData;


    }
}



if ( ! function_exists('HotelstoninvoiceDetails'))
{
    function HotelstoninvoiceDetails($id,$ref,$reviewData = null)
    {
        $CI = get_instance();
        $CI->db->select('pt_hotelston_booking.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $CI->db->where('pt_hotelston_booking.id',$id);
        $CI->db->where('pt_hotelston_booking.agentReferenceNumber',$ref);
        $CI->db->join('pt_accounts','pt_hotelston_booking.user_id = pt_accounts.accounts_id','left');
        $invoiceData = $CI->db->get('pt_hotelston_booking')->result();
        $returnData = (object)array("id" => $invoiceData[0]->id,
            "bookingUser" => $invoiceData[0]->user_id,
            "accountEmail" => $invoiceData[0]->accounts_email,
            "code" => $invoiceData[0]->agentReferenceNumber,
            "checkoutAmount" => $invoiceData[0]->price,
            "currCode" => $invoiceData[0]->currency,
        );

        return $returnData;

    }
}


if ( ! function_exists('gethotelstoninvoice'))
{
    function gethotelstoninvoice($id)
    {
        $CI = get_instance();
        $CI->db->select('pt_hotelston_booking.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
        $CI->db->where('pt_hotelston_booking.id',$id);
        $CI->db->join('pt_accounts','pt_hotelston_booking.user_id = pt_accounts.accounts_id','left');
        $invoiceData = $CI->db->get('pt_hotelston_booking')->result();
        $returnData = (object)array("id" => $invoiceData[0]->id,
            "bookingUser" => $invoiceData[0]->user_id,
            "accountEmail" => $invoiceData[0]->accounts_email,
            "code" => $invoiceData[0]->agentReferenceNumber,
            "price" => $invoiceData[0]->room,
            "currCode" => $invoiceData[0]->currency,
            "room_id" => $invoiceData[0]->room_id,
            "roomTypeId" => $invoiceData[0]->roomTypeId,
            "boardTypeId" => $invoiceData[0]->boardTypeId,
            "checkIn" => $invoiceData[0]->checkIn,
            "checkOut" => $invoiceData[0]->checkOut,
            "currency" => $invoiceData[0]->set_currencies,
            "booking_response" => $invoiceData[0]->booking_response,
            "agentReferenceNumber" => $invoiceData[0]->agentReferenceNumber,
            "hotel_id" => $invoiceData[0]->hotel_id,

        );

        return $returnData;

    }
}

if ( ! function_exists('pt_get_einvoice_details'))
{
    function pt_get_einvoice_details($id,$itid)
    {
    $CI = get_instance();
    $CI->db->select('pt_ean_booking.*,pt_accounts.ai_mobile,pt_accounts.accounts_id,pt_accounts.ai_country,pt_accounts.accounts_email,pt_accounts.ai_first_name,pt_accounts.ai_last_name,pt_accounts.ai_address_1,pt_accounts.ai_address_2');
    $CI->db->where('pt_ean_booking.book_id',$id);
    $CI->db->where('pt_ean_booking.book_itineraryid',$itid);
    $CI->db->join('pt_accounts','pt_ean_booking.book_user = pt_accounts.accounts_id','left');
    $invoiceData = $CI->db->get('pt_ean_booking')->result();

   /* $returnData = (object)array("id" => $invoiceData[0]->book_id,
          "module" => "ean",
          "itemid" => $invoiceData[0]->book_hotelid,
          "paymethod" => "",
          "code" => "",
          "nights" => $invoiceData[0]->book_nights,
          "checkin" => date("M j, Y", strtotime($invoiceData[0]->book_checkin)),
          "checkout" => date("M j, Y", strtotime($invoiceData[0]->book_checkout)),
          "date" => pt_show_date_php($invoiceData[0]->book_date),
          "currCode" => $invoiceData[0]->book_currency,
          "currSymbol" => "",
          "checkoutAmount" => $invoiceData[0]->book_total,
          "checkoutTotal" => $invoiceData[0]->book_total,
          "status" => "paid",
          "accountEmail" => "",
          "bookingID" => $invoiceData[0]->book_id,
          "expiry" => "",
          "expiryUnixtime" => "",
          "bookingDate" => pt_show_date_php($invoiceData[0]->book_date),
          "title" => $invoiceData[0]->book_hotel,
          "thumbnail" => "",
          "stars" => "",
          "location" => "",
          "nights" => $invoiceData[0]->book_nights,
          "tax" => "",
          "subItem" => "",
          "extraBeds" => "",
          "extraBedsCharges" => "",
          "cancelRequest" => "",
          "expiryFullDate" => "",
          "reviewsData" => "",
          "bookingExtras" => "",
          "amountPaid" => "",
          "bookingUser" => $invoiceData[0]->book_user,
          "userCountry" => $invoiceData[0]->ai_country,
          "userFullName" => $invoiceData[0]->ai_first_name . " " . $invoiceData[0]->ai_last_name,
          "userMobile" => $invoiceData[0]->ai_mobile,
          "userAddress" => $invoiceData[0]->ai_address_1. " " . $invoiceData[0]->ai_address_2,
          "additionaNotes" => "",
          "couponCode" => "",
          "couponRate" => "",
          "remainingAmount" => "",
          "guestInfo" => "",
          "book_response" => $invoiceData[0]->book_response

          );*/

          return $invoiceData;


    }
}

if(! function_exists('updateInvoiceStatus')){
  function updateInvoiceStatus($invoiceid,$amount,$txnid,$paymethod,$status,$module,$totalamount){
    $CI = get_instance();
    $remaining = $totalamount - $amount;
    $bookingdata = array(
      'booking_status' => $status,
      'booking_amount_paid' => $amount,
      'booking_txn_id' => $txnid,
      'booking_remaining' => $remaining,
      'booking_payment_type' => $paymethod
      );
    $CI->db->where('booking_id',$invoiceid);
    $CI->db->update('pt_bookings',$bookingdata);

    if($module == "hotels"){
    $roombookingdata = array("booked_booking_status" => $status);
    $CI->db->where('booked_booking_id', $invoiceid);
    $CI->db->update('pt_booked_rooms',$roombookingdata);
    }

    if($module == "cars"){
    $carbookingdata = array("booked_booking_status" => $status);
    $CI->db->where('booked_booking_id', $invoiceid);
    $CI->db->update('pt_booked_cars',$carbookingdata);
    }


  }
}

if(! function_exists('updatehotelstoninvoice')){
    function updatehotelstoninvoice($invoiceid,$amount,$txnid,$paymethod,$status,$booking){
        $CI = get_instance();
        $bookingdata = array(
            'status' => $status,
            'booking_amount_paid' => $amount,
            'booking_txn_id' => $txnid,
            'booking_payment_type' => $paymethod,
            'bookingDetails' => $booking
        );
        $CI->db->where('id',$invoiceid);
        $CI->db->update('pt_hotelston_booking',$bookingdata);
    }
}

if(!function_exists('updateInvoiceLogs')){
  function updateInvoiceLogs($invoiceid,$logs = ""){
    $CI = get_instance();
    if(!empty($logs)){

    $logData = array(
    'booking_logs' => $logs
    );

    $CI->db->where('booking_id',$invoiceid);
    $CI->db->update('pt_bookings',$logData);

    }


  }
}

if ( ! function_exists('pt_get_selected_rooms'))
{
    function pt_get_selected_rooms($roomstring)
    {
      $CI = get_instance();
       $eachroom = explode(",",$roomstring);
       $detail = array();
       foreach($eachroom as $er){

         $detail[] = explode("_",$er);

       }

       return $detail;

    }
}



if ( ! function_exists('pt_get_room_title'))
{
    function pt_get_room_title($id)
    {
      $CI = get_instance();

$CI->db->select('room_title');
$CI->db->where('room_id',$id);
$res = $CI->db->get('pt_rooms')->result();
  return $res[0]->room_title;

    }
}




if ( ! function_exists('pt_booked_extras'))
{
    function pt_booked_extras($id)
    {
      $CI = get_instance();
   $result = array();
$CI->db->select('extras_title,extras_discount,extras_basic_price');
$CI->db->where('extras_id',$id);
$res = $CI->db->get('pt_extras')->result();
if(!empty($res)){

$result['title'] = $res[0]->extras_title;
if($res[0]->extras_discount > 0){

$result['price'] = $res[0]->extras_discount;


}else{

$result['price'] = $res[0]->extras_basic_price;


}

}
return $result;

  }
}



if ( ! function_exists('pt_tax_details'))
{
    function pt_tax_details($type,$id)
    {
    $deftax = 0;
   $deftype = 'fixed';

   $CI = get_instance();
   $result = array();
   $CI->db->select('front_tax_fixed,front_tax_percentage');
   $CI->db->where('front_for',$type);
   $defaultsettings = $CI->db->get('pt_front_settings')->result();

   if($defaultsettings[0]->front_tax_fixed > 0){
   $deftax = $defaultsettings[0]->front_tax_fixed;
   $deftype = 'fixed';

   }elseif($defaultsettings[0]->front_tax_percentage > 0){

    $deftax = $defaultsettings[0]->front_tax_percentage;
   $deftype = 'percentage';

   }



   if($type == "hotels"){

   $CI->db->select('hotel_title,hotel_tax_fixed,hotel_tax_percentage');
   $CI->db->where('hotel_id',$id);
   $hotel = $CI->db->get('pt_hotels')->result();
   $result['title'] = $hotel[0]->hotel_title;

   if($hotel[0]->hotel_tax_fixed > 0){
   $result['tax'] = $hotel[0]->hotel_tax_fixed;
   $result['tax_type'] = 'fixed';

   }elseif($hotel[0]->hotel_tax_percentage > 0){

   $result['tax'] = $hotel[0]->hotel_tax_percentage;
   $result['tax_type'] = 'percentage';

   }else{

   $result['tax'] = $deftax;
   $result['tax_type'] = $deftype;


   }


   }elseif($type == "tours"){
   $CI->db->select('tour_title,tour_tax_fixed,tour_tax_percentage');
   $CI->db->where('tour_id',$id);
   $tour = $CI->db->get('pt_tours')->result();
   $result['title'] = $tour[0]->tour_title;

   if($tour[0]->tour_tax_fixed > 0){
   $result['tax'] = $tour[0]->tour_tax_fixed;
   $result['tax_type'] = 'fixed';

   }elseif($tour[0]->tour_tax_percentage > 0){

   $result['tax'] = $tour[0]->tour_tax_percentage;
   $result['tax_type'] = 'percentage';

   }else{

   $result['tax'] = $deftax;
   $result['tax_type'] = $deftype;


   }



   }elseif($type == "cars"){
   $CI->db->select('car_title,car_tax_fixed,car_tax_percentage');
   $CI->db->where('car_id',$id);
   $car = $CI->db->get('pt_cars')->result();
   $result['title'] = $car[0]->car_title;

   if($car[0]->tour_tax_fixed > 0){
   $result['tax'] = $car[0]->car_tax_fixed;
   $result['tax_type'] = 'fixed';

   }elseif($car[0]->car_tax_percentage > 0){

   $result['tax'] = $car[0]->car_tax_percentage;
   $result['tax_type'] = 'percentage';

   }else{

   $result['tax'] = $deftax;
   $result['tax_type'] = $deftype;


   }



   }elseif($type == "cruises"){
   $CI->db->select('cruise_title,cruise_tax_fixed,cruise_tax_percentage');
   $CI->db->where('cruise_id',$id);
   $cruise = $CI->db->get('pt_cruises')->result();
   $result['title'] = $cruise[0]->cruise_title;

   if($cruise[0]->cruise_tax_fixed > 0){
   $result['tax'] = $cruise[0]->cruise_tax_fixed;
   $result['tax_type'] = 'fixed';

   }elseif($cruise[0]->cruise_tax_percentage > 0){

   $result['tax'] = $cruise[0]->cruise_tax_percentage;
   $result['tax_type'] = 'percentage';

   }else{

   $result['tax'] = $deftax;
   $result['tax_type'] = $deftype;


   }



   }

return $result;

  }

}



if ( ! function_exists('pt_total_accomodates'))
{
    function pt_total_accomodates($array)
    {

      $result = array();
      $comsep = explode(",",$array);
      foreach($comsep as $com){
      $items = explode("_",$com);
      $result[$items[0]] = $items[2];

      }
      return $result;

  }
}


if ( ! function_exists('suppliers_hotels'))
{
    function suppliers_hotels($supplier_id)
    {

      $result = array();
      $CI = get_instance();
      $CI->db->select();
      $CI->db->where('hotel_owned_by',$supplier_id);
      $result = $CI->db->get('pt_hotels')->result();
      return $result;

  }
}
