<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Reports extends MX_Controller {

    private $myitems = array();
    public $role;


    function __construct(){



    parent::__construct();



    modules::load('Admin');

       $chkadmin = modules::run('Supplier/validsupplier');
       $this->myitems = modules::run('Supplier/myitems');

   if(!$chkadmin){
    $this->session->set_userdata('prevURL', current_url());

      redirect('supplier');

   }

 $this->data['app_settings'] = $this->Settings_model->get_settings_data();

  $this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
  $this->role = $this->session->userdata('pt_role');
        $this->data['role'] = $this->role;

   $this->data['adminsegment'] = $this->uri->segment(1);

 }



    public function index()

	{

    $this->data['modules'] = $this->Modules_model->get_module_names();

    $this->data['chklib'] =  $this->ptmodules;

    $filter = $this->input->post('filtermod');

    $this->data['selmodule'] = $this->input->post('module');

    $module =  $this->data['selmodule'];

if(!empty($filter) && !empty($module)){

      $this->$module();



    }else{



    $this->data['monthly'] = $this->monthly_report();

    $this->data['thismonth'] = $this->this_month_report();

    $this->data['thisyear'] = $this->this_year_report();

    $this->data['thisday'] = $this->this_day_report();



    $this->data['main_content'] = 'modules/reports/reports';

	$this->data['page_title'] = 'Reports';



	$this->load->view('Admin/template',$this->data);



    }









    }



        public function hotels()

	{



    $this->data['monthly'] = $this->monthly_report('hotels');

    $this->data['thismonth'] = $this->this_month_report('hotels');

    $this->data['thisyear'] = $this->this_year_report('hotels');

    $this->data['thisday'] = $this->this_day_report('hotels');

    $this->data['main_content'] = 'modules/reports/reports';

	$this->data['page_title'] = 'Reports';



	$this->load->view('Admin/template',$this->data);



    }





    public function cruises()

	{



    $this->data['monthly'] = $this->monthly_report('cruises');

    $this->data['thismonth'] = $this->this_month_report('cruises');

    $this->data['thisyear'] = $this->this_year_report('cruises');

    $this->data['thisday'] = $this->this_day_report('cruises');

    $this->data['main_content'] = 'modules/reports/reports';

	$this->data['page_title'] = 'Reports';



	$this->load->view('Admin/template',$this->data);



    }



        public function tours()

	{



    $this->data['monthly'] = $this->monthly_report('tours');

    $this->data['thismonth'] = $this->this_month_report('tours');

    $this->data['thisyear'] = $this->this_year_report('tours');

    $this->data['thisday'] = $this->this_day_report('tours');

    $this->data['main_content'] = 'modules/reports/reports';

	$this->data['page_title'] = 'Reports';



	$this->load->view('Admin/template',$this->data);



    }



    public function cars()

	{



    $this->data['monthly'] = $this->monthly_report('cars');

    $this->data['thismonth'] = $this->this_month_report('cars');

    $this->data['thisyear'] = $this->this_year_report('cars');

    $this->data['thisday'] = $this->this_day_report('cars');

    $this->data['main_content'] = 'modules/reports/reports';

	$this->data['page_title'] = 'Reports';



	$this->load->view('Admin/template',$this->data);



    }



    function this_day_report($type = null){

        $myitems = array();

        if($type == "hotels"){

           $this->db->select('hotel_id');

           $this->db->where('hotel_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_hotels')->result();

           foreach($rs as $r){

             array_push($myitems,$r->hotel_id);

           }

        }elseif($type == "cruises"){

           $this->db->select('cruise_id');

           $this->db->where('cruise_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cruises')->result();

           foreach($rs as $r){

             array_push($myitems,$r->cruise_id);

           }

        }elseif($type == "tours"){

           $this->db->select('tour_id');

           $this->db->where('tour_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_tours')->result();

           foreach($rs as $r){

             array_push($myitems,$r->tour_id);

           }

        }elseif($type == "cars"){

           $this->db->select('car_id');

           $this->db->where('car_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cars')->result();

           foreach($rs as $r){

             array_push($myitems,$r->car_id);

           }

        }





    $first = time() - 86400;

    $last  = time();

    $this->db->select_sum('booking_amount_paid');

    if(!empty($type)){

    $this->db->where('booking_type',$type);

    }

    if(!empty($myitems)){

     $this->db->where_in('booking_item', $myitems);

    }elseif(!empty($this->myitems)){

     $this->db->where_in('booking_item', $this->myitems);

    }else{

    $this->db->where('booking_item', 0);



    }

    $this->db->where('booking_payment_date >=',$first);

    $this->db->where('booking_payment_date <=',$last);

    $this->db->where('booking_status','paid');

    $res = $this->db->get('pt_bookings')->result();

    return round($res[0]->booking_amount_paid,2);



    }



    function this_month_report($type = null){

         $myitems = array();

        if($type == "hotels"){

           $this->db->select('hotel_id');

           $this->db->where('hotel_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_hotels')->result();

           foreach($rs as $r){

             array_push($myitems,$r->hotel_id);

           }

        }elseif($type == "cruises"){

           $this->db->select('cruise_id');

           $this->db->where('cruise_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cruises')->result();

           foreach($rs as $r){

             array_push($myitems,$r->cruise_id);

           }

        }elseif($type == "tours"){

           $this->db->select('tour_id');

           $this->db->where('tour_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_tours')->result();

           foreach($rs as $r){

             array_push($myitems,$r->tour_id);

           }

        }elseif($type == "cars"){

           $this->db->select('car_id');

           $this->db->where('car_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cars')->result();

           foreach($rs as $r){

             array_push($myitems,$r->car_id);

           }

        }



    $from = strtotime(date('Y-m-01'));

    $to = strtotime(date('Y-m-t'));

    $this->db->select_sum('booking_amount_paid');

     if(!empty($type)){

    $this->db->where('booking_type',$type);

    }

    if(!empty($myitems)){

     $this->db->where_in('booking_item', $myitems);

    }elseif(!empty($this->myitems)){

     $this->db->where_in('booking_item', $this->myitems);

    }else{

    $this->db->where('booking_item', 0);



    }



    $this->db->where('booking_payment_date >=',$from);

    $this->db->where('booking_payment_date <=',$to);

    $this->db->where('booking_status','paid');

    $res = $this->db->get('pt_bookings')->result();

    return round($res[0]->booking_amount_paid,2);



    }



    function this_year_report($type = null){

           $myitems = array();

        if($type == "hotels"){

           $this->db->select('hotel_id');

           $this->db->where('hotel_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_hotels')->result();

           foreach($rs as $r){

             array_push($myitems,$r->hotel_id);

           }

        }elseif($type == "cruises"){

           $this->db->select('cruise_id');

           $this->db->where('cruise_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cruises')->result();

           foreach($rs as $r){

             array_push($myitems,$r->cruise_id);

           }

        }elseif($type == "tours"){

           $this->db->select('tour_id');

           $this->db->where('tour_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_tours')->result();

           foreach($rs as $r){

             array_push($myitems,$r->tour_id);

           }

        }elseif($type == "cars"){

           $this->db->select('car_id');

           $this->db->where('car_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cars')->result();

           foreach($rs as $r){

             array_push($myitems,$r->car_id);

           }

        }



    $year = date("Y");

    $first = strtotime($year."-01-01");

    $last  = strtotime($year."-12-31");

    $this->db->select_sum('booking_amount_paid');

    if(!empty($type)){

    $this->db->where('booking_type',$type);

    }

    if(!empty($myitems)){

     $this->db->where_in('booking_item', $myitems); 

    }elseif(!empty($this->myitems)){

     $this->db->where_in('booking_item', $this->myitems);

    }else{

    $this->db->where('booking_item', 0);



    }

    $this->db->where('booking_payment_date >=',$first);

    $this->db->where('booking_payment_date <=',$last);

    $this->db->where('booking_status','paid');

    $res = $this->db->get('pt_bookings')->result();

    return round($res[0]->booking_amount_paid,2);



    }

 //  from and to date report

 function from_to_report(){

      $from = str_replace("/","-",$this->input->post('from'));

    $to = str_replace("/","-",$this->input->post('to'));

    $type = $this->input->post('type');

          $myitems = array();

        if($type == "hotels"){

           $this->db->select('hotel_id');

           $this->db->where('hotel_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_hotels')->result();

           foreach($rs as $r){

             array_push($myitems,$r->hotel_id);

           }

        }elseif($type == "cruises"){

           $this->db->select('cruise_id');

           $this->db->where('cruise_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cruises')->result();

           foreach($rs as $r){

             array_push($myitems,$r->cruise_id);

           }

        }elseif($type == "tours"){

           $this->db->select('tour_id');

           $this->db->where('tour_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_tours')->result();

           foreach($rs as $r){

             array_push($myitems,$r->tour_id);

           }

        }elseif($type == "cars"){

           $this->db->select('car_id');

           $this->db->where('car_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cars')->result();

           foreach($rs as $r){

             array_push($myitems,$r->car_id);

           }

        }



    $this->db->select_sum('booking_amount_paid');

     if(!empty($type)){

    $this->db->where('booking_type',$type);

    }

    if(!empty($myitems)){

     $this->db->where_in('booking_item', $myitems);

    }elseif(!empty($this->myitems)){

     $this->db->where_in('booking_item', $this->myitems);

    }else{

    $this->db->where('booking_item', 0);



    }

    $this->db->where('booking_payment_date >=',strtotime($from));

    $this->db->where('booking_payment_date <=',strtotime($to));

    $this->db->where('booking_status','paid');

    $res = $this->db->get('pt_bookings')->result();

    $html = "<h1><strong>". $this->data['app_settings'][0]->currency_sign.round($res[0]->booking_amount_paid,2)."</strong></h1>";

    $html .= "<h5>From ".$this->input->post('from')." <br> to ".$this->input->post('to')."</h5>";



    echo $html;



    }

    function monthly_report($type = null){

     $datearray = array();

    $resultarray = array();

    $year = date("Y");

    for($m =1;$m < 13;$m++){

    $datearray[strtotime($year."-".$m."-1")] = strtotime($year."-".$m."-31");



    }





    $myitems = array();

    if($type == "hotels"){

    $this->db->select('hotel_id');

    $this->db->where('hotel_owned_by',$this->data['userloggedin']);

    $rs = $this->db->get('pt_hotels')->result();

    foreach($rs as $r){

    array_push($myitems,$r->hotel_id);

    }

    }elseif($type == "cruises"){

           $this->db->select('cruise_id');

           $this->db->where('cruise_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cruises')->result();

           foreach($rs as $r){

             array_push($myitems,$r->cruise_id);

           }

        }elseif($type == "tours"){

           $this->db->select('tour_id');

           $this->db->where('tour_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_tours')->result();

           foreach($rs as $r){

             array_push($myitems,$r->tour_id);

           }

        }elseif($type == "cars"){

           $this->db->select('car_id');

           $this->db->where('car_owned_by',$this->data['userloggedin']);

           $rs = $this->db->get('pt_cars')->result();

           foreach($rs as $r){

             array_push($myitems,$r->car_id);

           }

        }



    foreach($datearray as $start => $end){

    $this->db->select_sum('booking_amount_paid');

    if(!empty($type)){

    $this->db->where('booking_type',$type);

    }

    if(!empty($myitems)){

     $this->db->where_in('booking_item', $myitems);

    }else{

    $this->db->where('booking_item', 0);



    }

    $this->db->where('booking_payment_date >=',$start);

    $this->db->where('booking_payment_date <=',$end);

    $this->db->where('booking_status','paid');

    $res = $this->db->get('pt_bookings')->result();

    $resultarray[] = round($res[0]->booking_amount_paid,2);





    }

    return $resultarray;



  }

/*booking count reports*/
    function pendingbCount($type)
    {
        $account_type = $this->session->userdata('pt_accountType');

        $account_id = $this->session->userdata('pt_logged_id');
        // dd($account_type);
        $this->db->select("COUNT(*) AS total");
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $account_id);
        $this->db->where("hotels_bookings.booking_status", $type);
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $counts_hotel = $this->db->get('hotels_bookings')->row()->total;

        $this->db->select("COUNT(*) AS total");
        if ($account_type == "Supplier") {
        $this->db->where("flights_bookings.booking_user_id", $account_id);
        $this->db->where("flights_bookings.booking_status", $type);
        }else{ $this->db->where("flights_bookings.booking_status", $type);}
        $counts_flight = $this->db->get("flights_bookings")->row()->total;
        return $counts_hotel+$counts_flight;
    }


        function confirmedbCount($type)
    {
        $account_type = $this->session->userdata('pt_accountType');
        $account_id = $this->session->userdata('pt_logged_id');
        $this->db->select("COUNT(*) AS total");
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $account_id);
        $this->db->where("hotels_bookings.booking_status", $type);
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $counts_hotel = $this->db->get('hotels_bookings')->row()->total;

        $this->db->select("COUNT(*) AS total");
        if ($account_type == "Supplier") {
        $this->db->where("flights_bookings.booking_user_id", $account_id);
        $this->db->where("flights_bookings.booking_status", $type);
        }else{ $this->db->where("flights_bookings.booking_status", $type);}
        $counts_flight = $this->db->get("flights_bookings")->row()->total;
        return $counts_hotel+$counts_flight;
    }

        function cancelledbCount($type)
    {

        $account_type = $this->session->userdata('pt_accountType');
        $account_id = $this->session->userdata('pt_logged_id');
        $this->db->select("COUNT(*) AS total");
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $account_id);
        $this->db->where("hotels_bookings.booking_status", $type);
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $counts_hotel = $this->db->get('hotels_bookings')->row()->total;

        $this->db->select("COUNT(*) AS total");
        if ($account_type == "Supplier") {
        $this->db->where("flights_bookings.booking_user_id", $account_id);
        $this->db->where("flights_bookings.booking_status", $type);
        }else{ $this->db->where("flights_bookings.booking_status", $type);}
        $counts_flight = $this->db->get("flights_bookings")->row()->total;
        return $counts_hotel+$counts_flight;

    }

        function paidbCount($type)
    {
        $account_type = $this->session->userdata('pt_accountType');
        $account_id = $this->session->userdata('pt_logged_id');

        $this->db->select("COUNT(*) AS total");
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $account_id);
        $this->db->where("hotels_bookings.booking_payment_status", $type);
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $counts_hotel = $this->db->get('hotels_bookings')->row()->total;

        $this->db->select("COUNT(*) AS total");
        if ($account_type == "Supplier") {
        $this->db->where("flights_bookings.booking_user_id", $account_id);
        $this->db->where("flights_bookings.booking_payment_status", $type);
        }else{ $this->db->where("flights_bookings.booking_payment_status", $type);}
        $counts_flight = $this->db->get("flights_bookings")->row()->total;
        return $counts_hotel+$counts_flight;
    }

        function unpaidbCount($type)
    {
        $account_type = $this->session->userdata('pt_accountType');
        $account_id = $this->session->userdata('pt_logged_id');
        $this->db->select("COUNT(*) AS total");
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $account_id);
        $this->db->where("hotels_bookings.booking_payment_status", $type);
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $counts_hotel = $this->db->get('hotels_bookings')->row()->total;

        $this->db->select("COUNT(*) AS total");
        if ($account_type == "Supplier") {
        $this->db->where("flights_bookings.booking_user_id", $account_id);
        $this->db->where("flights_bookings.booking_payment_status", $type);
        }else{ $this->db->where("flights_bookings.booking_payment_status", $type);}
        $counts_flight = $this->db->get("flights_bookings")->row()->total;
        return $counts_hotel+$counts_flight;
    }

        function refundedbCount($type)
    {
        
        $account_type = $this->session->userdata('pt_accountType');
        $account_id = $this->session->userdata('pt_logged_id');
        $this->db->select("COUNT(*) AS total");
        $this->db->order_by('hotels_bookings.booking_id', 'desc');
        $this->db->where('pt_hotels.hotel_owned_by', $account_id);
        $this->db->where("hotels_bookings.booking_payment_status", $type);
        $this->db->join('pt_hotels', 'hotels_bookings.hotel_id = pt_hotels.hotel_id');
        $counts_hotel = $this->db->get('hotels_bookings')->row()->total;

        $this->db->select("COUNT(*) AS total");
        if ($account_type == "Supplier") {
        $this->db->where("flights_bookings.booking_user_id", $account_id);
        $this->db->where("flights_bookings.booking_payment_status", $type);
        }else{ $this->db->where("flights_bookings.booking_payment_status", $type);}
        $counts_flight = $this->db->get("flights_bookings")->row()->total;
        return $counts_hotel+$counts_flight;
    }
/*end booking count reports*/

}

