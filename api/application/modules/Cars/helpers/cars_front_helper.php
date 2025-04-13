<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('pt_default_car_image'))
{
    function pt_default_car_image($carid)
    {
       $CI = get_instance();

    $CI->load->model('Cars_model');

    $res = $CI->Cars_model->default_car_img($carid);


    return $res;

    }
}


if ( ! function_exists('pt_car_is_available'))
{
    function pt_car_is_available($carid)
    {
       $CI = get_instance();

    $CI->load->model('Cars_model');

    $res = $CI->Cars_model->car_is_available($carid);


    return $res;

    }
}

if ( ! function_exists('pt_get_csettings_data'))
{
    function pt_get_csettings_data($type)
    {
       $CI = get_instance();

    $CI->load->model('Cars_model');

    $res = $CI->Cars_model->get_csettings_data($type);


    return $res;

    }
}


if ( ! function_exists('pt_car_commission'))
{
    function pt_car_commission($id)
    {
      $res = array();
       $CI = get_instance();

    $CI->db->select('car_comm_fixed,car_comm_percentage');
    $CI->db->where('car_id',$id);
    $result = $CI->db->get('pt_cars')->result();
    $res['fixed_com'] = $result[0]->car_comm_fixed;
    $res['per_com'] = $result[0]->car_comm_percentage;

      return $res;

    }
}




if ( ! function_exists('pt_days_between'))
{

function pt_days_between($start, $end){
   $dates = array();
   while($start <= $end)
   {
     array_push(
          $dates,$start

       );
       $start += 86400;
   }
   return $dates;
}

}


if ( ! function_exists('car_booking_adv_price'))
{
    function car_booking_adv_price($id,$checkin,$checkout)
    {



     $data = array();
     $prices = array();
    

   $days = pt_dates_between(convert_to_unix($checkin),convert_to_unix($checkout));
     $CI = get_instance();
   $CI->db->select('car_basic_price,car_basic_discount');
   $CI->db->where('car_id',$id);
   $rs = $CI->db->get('pt_cars')->result();
   $bprice = $rs[0]->car_basic_price;
   $dprice = $rs[0]->car_basic_discount;
   if($dprice > 0){
   $mainprice = $dprice;
   }else{
   $mainprice = $bprice;
   }

   foreach($days as $d){
     $CI->db->select('cp_basic,cp_discount');
     $CI->db->where("cp_from <=",$d);
    $CI->db->where("cp_to >",$d);
     $CI->db->where('cp_car_id',$id);
    $rslt = $CI->db->get('pt_car_aprice')->result();

    if(!empty($rslt)){
     $advbprice = $rslt[0]->cp_basic;
     $advdprice = $rslt[0]->cp_discount;

     if($advdprice > 0){
         $prices[] = $advdprice;
     }else{
         $prices[] = $advbprice;
     }


    }else{
      $prices[] = $mainprice;
    }

   }

   $average_price = array_sum($prices) / count($prices);

   return round($average_price,2);


   /* $data = array();

        $checkin = str_replace("/","-",$checkin);

    $checkout = str_replace("/","-",$checkout);

    $days = pt_dates_between(strtotime($checkin),strtotime($checkout));

     $CI = get_instance();



    $CI->db->select('cp_basic,cp_discount');

    $CI->db->where_in('cp_from',$days);

    $CI->db->or_where_in('cp_to',$days);

    $CI->db->group_by('cp_car_id');

    $CI->db->having('cp_car_id',$id);





   return $CI->db->get('pt_car_aprice')->result();

*/

 }

}


if ( ! function_exists('pt_is_car_booked'))
{
    function pt_is_car_booked($id,$checkin,$checkout)
 {


    $checkindate = convert_to_unix($checkin);
    $checkoutdate = convert_to_unix($checkout);

     $days = pt_dates_between($checkindate,$checkoutdate);
    $CI = get_instance();
    $tdays = pt_count_days($checkin,$checkout);
      $CI->db->select('booked_checkout,booked_checkin');
    $CI->db->select_sum('booked_room_count');

    if($tdays > 1){
    $CI->db->where_in("booked_checkin",$days);
    $CI->db->or_where_in("booked_checkout",$days);

    }else{


    $CI->db->where("booked_checkin <",$checkoutdate);
    $CI->db->where("booked_checkout >",$checkindate);


    }



    $CI->db->where('booked_booking_status','paid');
    $CI->db->group_by('booked_car_id');
    $CI->db->having('booked_car_id',$id);

    $booked = $CI->db->get('pt_booked_cars')->num_rows();


    return $booked;

 }

}

