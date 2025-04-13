<?php
class Supplier_hotel_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    // Get all hotels id and names only
    function all_hotels_names($id){

    $this->db->select('hotel_id,hotel_title');
    $this->db->where('hotel_owned_by',$id);
    $this->db->order_by('hotel_id','desc');
    return $this->db->get('pt_hotels')->result();


    }

    // get all hotels info
    function get_supplier_hotels($id){
    $this->db->select('pt_hotels.hotel_featured_forever,pt_hotels.hotel_id,pt_hotels.hotel_title,pt_hotels.hotel_stars,
    pt_hotels.hotel_owned_by,pt_hotels.hotel_order,pt_hotels.hotel_status,pt_hotels.hotel_is_featured,
    pt_hotels.hotel_featured_from,pt_hotels.hotel_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name');
    $this->db->where('pt_hotels.hotel_owned_by',$id);
  //  $this->db->where('pt_hotel_images.himg_type','default');
    $this->db->order_by('pt_hotels.hotel_id','desc');
    $this->db->join('pt_accounts','pt_hotels.hotel_owned_by = pt_accounts.accounts_id','left');
   // $this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');

    $query =  $this->db->get('pt_hotels');

    $data['all'] = $query->result();
    $data['nums'] = $query->num_rows();
    return $data;

    }

     // get all hotels info  by search
    function search_all_hotels_back($id){
    $hotel = $this->input->post('hotelid');
    $status = $this->input->post('status');
    $city = $this->input->post('hotelcity');
    $owned = $this->input->post('ownedby');
    $stars = $this->input->post('hotelstars');
    $group = $this->input->post('hotelgroup');
    $category = $this->input->post('hotelcategory');
    $type = $this->input->post('hoteltype');


    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title,pt_hotels.hotel_type,pt_hotels.hotel_city,pt_hotels.hotel_stars,
    pt_hotels.hotel_owned_by,pt_hotels.hotel_order,pt_hotels.hotel_status,pt_hotels.hotel_is_featured,
    pt_hotels.hotel_featured_from,pt_hotels.hotel_featured_to,pt_accounts.accounts_id,pt_accounts.ai_first_name,pt_accounts.ai_last_name');

    if(!empty($hotel)){

    $this->db->where('pt_hotels.hotel_id',$hotel);
    }

    if(!empty($stars)){

    $this->db->where('pt_hotels.hotel_stars',$stars);
    }

   if(!empty($owned)){

    $this->db->where('pt_hotels.hotel_owned_by',$owned);
    }

   if(!empty($city)){

    $this->db->where('pt_hotels.hotel_city',$city);
    }

      if(!empty($type)){

    $this->db->where('pt_hotels.hotel_type',$type);

    }


     if($status == '1' || $status == '0'){

    $this->db->where('pt_hotels.hotel_status',$status);


    }

   // $this->db->where('pt_hotel_images.himg_type','default');
    $this->db->where('pt_hotels.hotel_owned_by',$id);
    $this->db->order_by('pt_hotels.hotel_id','desc');
    $this->db->join('pt_accounts','pt_hotels.hotel_owned_by = pt_accounts.accounts_id','left');
  //  $this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');

    $query =  $this->db->get('pt_hotels');

    $data['all'] = $query->result();

    $data['nums'] = $this->db->get('pt_hotels')->num_rows();

    return $data;

    }

    // get all data of single hotel by title
    function get_hotel_data($hotelname){

    $this->db->select('pt_hotels.*');
    $this->db->where('pt_hotels.hotel_slug',$hotelname);
   // $this->db->where('pt_hotel_images.himg_type','default');
   // $this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');
    return $this->db->get('pt_hotels')->result();


    }

     // get data of single hotel by id for maps
    function hotel_data_for_map($id){

    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title');
    $this->db->where('pt_hotels.hotel_id',$id);
   // $this->db->where('pt_hotel_images.himg_type','default');
   // $this->db->where('pt_hotel_images.himg_approved','1');
   // $this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');
    return $this->db->get('pt_hotels')->result();


    }

  // update hotel data

   function update_hotel($id){

   $this->load->model('Admin/Special_offers_model');

         $recreation =  @implode(",",$this->input->post('hotelrecreation'));
         $amenities =  @implode(",",$this->input->post('hotelamenities'));
         $paymentopt =  @implode(",",$this->input->post('hotelpayments'));
         $relatedhotels =  @implode(",",$this->input->post('relatedhotels'));

          $forever = $this->input->post('foreverfeatured');
          $featured = $this->input->post('isfeatured');
         if($forever == "forever" || $featured == "0"){
            $ffrom = date('Y-m-d');
            $fto = date('Y-m-d', strtotime('+1 years'));
            $isforever = 'forever';
         }else{

          $ffrom = $this->input->post('ffrom');
            $fto = $this->input->post('fto');
              $isforever = '';
         }

      $hslug = create_url_slug($this->input->post('hotelname'));

   $data = array(
            'hotel_title' => $this->input->post('hotelname'),
            'hotel_slug' => $hslug,
            'hotel_desc' => $this->input->post('hoteldesc'),
            'hotel_surroundings' => $this->input->post('hotelsurroundings'),
            'hotel_services' => $this->input->post('hotelservices'),
            'hotel_admin_review' => $this->input->post('adminreview'),
            'hotel_stars' => $this->input->post('hotelstars'),
            'hotel_ratings' => $this->input->post('hotelratings'),
            'hotel_is_featured' => $this->input->post('isfeatured'),
            'hotel_featured_from' => convert_to_unix($ffrom),
            'hotel_featured_to' =>  convert_to_unix($fto),
            'hotel_owned_by' => $this->input->post('ownedby'),
            'hotel_type' => $this->input->post('hoteltype'),
            'hotel_city' => $this->input->post('hotelcity'),
            'hotel_basic_price' => $this->input->post('hotelprice'),
            'hotel_basic_discount' => $this->input->post('hoteldiscount'),
            'hotel_latitude' => $this->input->post('latitude'),
            'hotel_longitude' => $this->input->post('longitude'),
            'hotel_meta_title' => $this->input->post('hotelmetatitle'),
            'hotel_meta_keywords' => $this->input->post('hotelkeywords'),
            'hotel_meta_desc' => $this->input->post('hotelmetadesc'),
            'hotel_amenities' => $amenities,
            'hotel_payment_opt' => $paymentopt,
            'hotel_adults' => $this->input->post('adults'),
            'hotel_children' => $this->input->post('children'),
            'hotel_check_in' => $this->input->post('checkintime'),
            'hotel_check_out' => $this->input->post('checkouttime'),
            'hotel_main_policy' => $this->input->post('hotelmainpolicy'),
            'hotel_terms' => $this->input->post('hotelterms'),
            'hotel_policy' => $this->input->post('hotelpolicy'),
            'hotel_refund' => $this->input->post('hotelrefund'),
            'hotel_status' => $this->input->post('hotelstatus'),
            'hotel_related' => $relatedhotels,
            'hotel_comm_fixed' => $this->input->post('fixcom'),
            'hotel_comm_percentage' => $this->input->post('percom'),
            'hotel_tax_fixed' => $this->input->post('fixtax'),
            'hotel_tax_percentage' => $this->input->post('pertax'),
            'hotel_email' => $this->input->post('hotelemail'),
            'hotel_featured_forever' => $isforever


   );
   $this->db->where('hotel_id',$id);
   $this->db->update('pt_hotels',$data);

   $isSpecial = $this->input->post('isSpecial');
   $offerid = $this->input->post('spofferid');

   if(empty($offerid) && $isSpecial == "1"){

    $this->Special_offers_model->add_to_specialoffer('hotels',$id);

   }elseif(!empty($offerid) && $isSpecial == "0"){

    $this->Special_offers_model->remove_from_specialoffer($offerid);

   }elseif(!empty($offerid) && $isSpecial == "1"){

    $this->Special_offers_model->update_specialoffer($offerid);

   }


   }




 // add hotel images by type
   function add_hotel_image($type,$filename,$hotelid){
     $imgorder = 0;
   if($type == "interior"){
   $this->db->where('himg_type','interior');
   $imgorder = $this->db->get('pt_hotel_images')->num_rows();
   $imgorder = $imgorder + 1;
   }elseif($type == "exterior"){
   $this->db->where('himg_type','exterior');
   $imgorder = $this->db->get('pt_hotel_images')->num_rows();
   $imgorder = $imgorder + 1;
   }elseif($type == "slider"){
   $this->db->where('himg_type','slider');
   $imgorder = $this->db->get('pt_hotel_images')->num_rows();
   $imgorder = $imgorder + 1;
   }
        $approval = pt_admin_gallery_approve();
        $this->db->where('himg_type','default');
   $this->db->where('himg_hotel_id',$hotelid);
   $hasdefault = $this->db->get('pt_hotel_images')->num_rows();
   if($hasdefault < 1){
     $type = 'default';
   }

      $data = array(
        'himg_hotel_id' => $hotelid,
        'himg_type' => $type,
        'himg_image' => $filename,
        'himg_order' => $imgorder,
        'himg_approved' => $approval

      );
      $this->db->insert('pt_hotel_images',$data);

   }

  // update hotel image by type
   function update_hotel_image($type,$filename,$hotelid){


      $data = array(

        'himg_image' => $filename

      );
      $this->db->where("himg_type",$type);
      $this->db->where("himg_hotel_id",$hotelid);
      $this->db->update('pt_hotel_images',$data);

   }

   // update hotel order
   function update_hotel_order($id,$order){

    $data = array(
       'hotel_order' => $order
    );

    $this->db->where('hotel_id',$id);
    $this->db->update('pt_hotels',$data);



    }

     // Disable Hotel

    public function disable_hotel($id){

    $data = array(
       'hotel_status' => '0'
    );

    $this->db->where('hotel_id',$id);
    $this->db->update('pt_hotels',$data);



    }

    // Enable Hotel

    public function enable_hotel($id){

    $data = array(
       'hotel_status' => '1'
    );

    $this->db->where('hotel_id',$id);
    $this->db->update('pt_hotels',$data);



    }

    // update featured status
    function update_featured(){

             $forever = $this->input->post('foreverfeatured');
             $isfeatured = $this->input->post('isfeatured');
          if($isfeatured == '1'){
         if($forever == "forever"){
              $ffrom = date('Y-m-d');
            $fto = date('Y-m-d', strtotime('+1 years'));
            $isforever = 'forever';


         }else{
            $ffrom = $this->input->post('ffrom');
            $fto = $this->input->post('fto');
              $isforever = '';
         }

         }else{
            $ffrom = '';
            $fto = '';
            $isforever = 'forever';
         }
         $hotelid = $this->input->post('hotelid');
         $data = array(
             'hotel_is_featured' => $isfeatured,
            'hotel_featured_from' => convert_to_unix($ffrom),
            'hotel_featured_to' => convert_to_unix($fto),
            'hotel_featured_forever' => $isforever

         );
         $this->db->where('hotel_id',$hotelid);
         $this->db->update('pt_hotels',$data);



    }

    // Add advanced hotel price

    function add_aprice(){
          $apfrom = $this->input->post('pricefrom');
          $apto = $this->input->post('priceto');
    $data = array(
        'hp_hotel_id' => $this->input->post('hotelid'),
        'hp_basic' => $this->input->post('basicprice'),
        'hp_discount' => $this->input->post('discountprice'),
        'hp_from' => convert_to_unix($apfrom),
        'hp_to' => convert_to_unix($apto)

    );

    $this->db->insert('pt_hotel_aprice',$data);

    }

      // Update advanced hotel price

    function update_aprice(){
          $apfrom = $this->input->post('pricefrom');
          $apto = $this->input->post('priceto');
    $data = array(
        'hp_basic' => $this->input->post('basicprice'),
        'hp_discount' => $this->input->post('discountprice'),
        'hp_from' => convert_to_unix($apfrom),
        'hp_to' => convert_to_unix($apto)

    );
    $this->db->where('hp_id',$this->input->post('priceid'));
    $this->db->update('pt_hotel_aprice',$data);

    }


    // Delete Advanced Price
    function delete_prices($id){

       $this->db->where('hp_id',$id);
       $this->db->delete('pt_hotel_aprice');

    }

    // Get Hotel Images
    function hotel_images($id){

     $this->db->where('himg_hotel_id',$id);
    $this->db->where('himg_type','default');
    $q =  $this->db->get('pt_hotel_images');
    $data['def_image'] = $q->result();


       $this->db->where('himg_type','slider');
    $this->db->or_where('himg_type','default');
    $this->db->having('himg_hotel_id',$id);
    $q =  $this->db->get('pt_hotel_images');
    $data['all_slider'] = $q->result();
    $data['slider_counts'] = $q->num_rows();

    $this->db->where('himg_hotel_id',$id);
    $this->db->where('himg_type','interior');
    $q2 =  $this->db->get('pt_hotel_images');
    $data['all_interior'] = $q2->result();
    $data['interior_counts'] = $q2->num_rows();

     $this->db->where('himg_hotel_id',$id);
    $this->db->where('himg_type','exterior');
    $q3 =  $this->db->get('pt_hotel_images');
    $data['all_exterior'] = $q3->result();
    $data['exterior_counts'] = $q3->num_rows();

    return $data;


    }
    // Delete Hotel Images
    function delete_image($imgname,$imgtype,$imgid){

    $this->db->where('himg_id',$imgid);
    $this->db->delete('pt_hotel_images');
    if($imgtype == "slider"){

    @unlink(PT_HOTELS_SLIDER_THUMBS_UPLOAD.$imgname);
    @unlink(PT_HOTELS_SLIDER_UPLOAD.$imgname);

    }elseif($imgtype == "interior"){
     @unlink(PT_HOTELS_INTERIOR_THUMBS_UPLOAD.$imgname);
    @unlink(PT_HOTELS_INTERIOR_UPLOAD.$imgname);

    }elseif($imgtype == "exterior"){
      @unlink(PT_HOTELS_EXTERIOR_THUMBS_UPLOAD.$imgname);
    @unlink(PT_HOTELS_EXTERIOR_UPLOAD.$imgname);

    }elseif($imgtype == "default"){
      @unlink(PT_HOTELS_SLIDER_THUMBS_UPLOAD.$imgname);

    }

    }

    // update image order
    function update_image_order($imgid,$order){
      $data = array(
       'himg_order' => $order
    );

    $this->db->where('himg_id',$imgid);
    $this->db->update('pt_hotel_images',$data);



    }


   // get number of rooms of hotel
   function rooms_count($hotelid){

   $this->db->where('room_hotel',$hotelid);
   return $this->db->get('pt_rooms')->num_rows();

   }

      // get number of reviews of hotel
   function reviews_count($hotelid){

   $this->db->where('review_itemid',$hotelid);
   $this->db->where('review_module','hotels');
   return $this->db->get('pt_reviews')->num_rows();

   }

    // get number of photos of hotel
   function photos_count($hotelid){

   $this->db->where('himg_hotel_id',$hotelid);
   $this->db->where('himg_type !=','default');
   $this->db->where('himg_approved','1');
   return $this->db->get('pt_hotel_images')->num_rows();

   }

    // get default image of hotel
    function default_hotel_img($id){

    $this->db->where('himg_type','default');
    $this->db->where('himg_hotel_id',$id);

    $res = $this->db->get('pt_hotel_images')->result();
    return $res[0]->himg_image;

    }

   // Approve or reject Hotel Images
   function approve_reject_images(){
   $data = array(

            'himg_approved' =>   $this->input->post('apprej')

   );
   $this->db->where('himg_id',$this->input->post('imgid'));
   $this->db->update('pt_hotel_images',$data);


   }


   // Delete Hotel
   function delete_hotel($hotelid){


   $hotelimages = $this->hotel_images($hotelid);

   foreach($hotelimages['all_slider'] as $sliderimg){
     $this->delete_image($sliderimg->himg_image,'slider',$sliderimg->himg_id);

   }

    foreach($hotelimages['all_interior'] as $interiorimg){
     $this->delete_image($interiorimg->himg_image,'interior',$interiorimg->himg_id);

   }

    foreach($hotelimages['all_exterior'] as $exteriorimg){
     $this->delete_image($exteriorimg->himg_image,'exterior',$exteriorimg->himg_id);

   }

    $this->delete_image($hotelimages['def_image'][0]->himg_image,'default',$hotelimages['def_image'][0]->himg_id);

  $this->db->select('room_id,room_hotel');
  $this->db->where('room_hotel',$hotelid);
  $rooms = $this->db->get('pt_rooms')->result();
  foreach($rooms as $r){
  $this->db->select('rimg_room_id,rimg_image');
  $this->db->where('rimg_room_id',$r->room_id);
  $roomimgs = $this->db->get('pt_room_images')->result();

  foreach($roomimgs as $rmimg){

    @unlink(PT_ROOMS_THUMBS_UPLOAD.$rmimg->rimg_image);
    @unlink(PT_ROOMS_IMAGES_UPLOAD.$rmimg->rimg_image);
    @unlink(PT_ROOMS_MAIN_THUMB_UPLOAD.$rmimg->rimg_image);
  $this->db->where('rimg_room_id',$rmimg->rimg_room_id);
  $this->db->delete('pt_room_images');

  }


  }





  $this->db->where('room_hotel',$hotelid);
  $this->db->delete('pt_rooms');

  $this->db->where('offer_item',$hotelid);
  $this->db->where('offer_module','hotels');
  $this->db->delete('pt_special_offers');

  $this->db->where('review_itemid',$hotelid);
  $this->db->where('review_module','hotels');
  $this->db->delete('pt_reviews');

  $this->db->where('hotel_id',$hotelid);
  $this->db->delete('pt_hotels');



   }

   // Add hotel settings data
   function add_settings_data(){

   $data = array(
     'sett_name'  => $this->input->post('name'),
     'sett_status'  => $this->input->post('statusopt'),
     'sett_selected'  => $this->input->post('selectopt'),
     'sett_type'  => $this->input->post('typeopt')
   );

   $this->db->insert('pt_hotels_types_settings',$data);

   }

    // update hotel settings data
   function update_settings_data(){
     $id = $this->input->post('id');
   $data = array(
     'sett_name'  => $this->input->post('name'),
     'sett_status'  => $this->input->post('statusopt'),
     'sett_selected'  => $this->input->post('selectopt')

   );
   $this->db->where('sett_id',$id);
   $this->db->update('pt_hotels_types_settings',$data);

   }


   // Get hotel settings data
   function get_hotel_settings_data($type){

    $this->db->where('sett_type',$type);
    $this->db->order_by('sett_id','desc');
    return $this->db->get('pt_hotels_types_settings')->result();

   }

    // Get hotel settings data for adding hotel or room
   function get_hsettings_data($type){

    $this->db->where('sett_type',$type);
    $this->db->where('sett_status','Yes');
    return $this->db->get('pt_hotels_types_settings')->result();

   }


    // Get hotel settings data for adding hotel or room
   function get_hsettings_data_front($type,$items){

    $this->db->where('sett_type',$type);
    $this->db->where_in('sett_id',$items);
    $this->db->where('sett_status','Yes');
    return $this->db->get('pt_hotels_types_settings')->result();

   }

  // Disable hotel settings
   function disable_settings($id){
   $data = array(
   'sett_status' => 'No'

   );
   $this->db->where('sett_id',$id);

   $this->db->update('pt_hotels_types_settings',$data);

   }

   // Enable hotel settings
   function enable_settings($id){
   $data = array(
   'sett_status' => 'Yes'

   );
   $this->db->where('sett_id',$id);

   $this->db->update('pt_hotels_types_settings',$data);

   }

   // Delete hotel settings

   function delete_settings($id){


   $this->db->where('sett_id',$id);
   $this->db->delete('pt_hotels_types_settings');


   }

   // Check by slug
   function hotel_exists($slug){


   $this->db->select('hotel_title');
   $this->db->where('hotel_slug',$slug);
   $this->db->where('hotel_status','1');
   $nums = $this->db->get('pt_hotels')->num_rows();

   if($nums > 0){

   return true;

   }else{

   return false;

   }


   }

   // List all hotels on front listings page
   function list_hotels_front($perpage = null,$offset = null, $orderby = null){
   $data = array();
   if($offset != null){

   $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;

   }
   $this->db->select('pt_hotels.*');
   if($orderby == "za"){

   $this->db->order_by('pt_hotels.hotel_title','desc');


   }elseif($orderby == "az"){

  $this->db->order_by('pt_hotels.hotel_title','asc');

   }elseif($orderby == "oldf"){

  $this->db->order_by('pt_hotels.hotel_id','asc');

   }elseif($orderby == "newf"){

  $this->db->order_by('pt_hotels.hotel_id','desc');

   }elseif($orderby == "ol"){

  $this->db->order_by('pt_hotels.hotel_order','asc');

   }
    $this->db->select_avg('pt_reviews.review_overall','overall');
  $this->db->group_by('pt_hotels.hotel_id');
  $this->db->join('pt_reviews','pt_hotels.hotel_id = pt_reviews.review_itemid','left');

   $this->db->where('pt_hotels.hotel_status','1');


   $query = $this->db->get('pt_hotels',$perpage,$offset);

    //  $data['all']  = $this->db->get('pt_hotels',$perpage,$offset)->result();

   $data['all']  = $query->result();

   $data['rows'] = $query->num_rows();



   return $data;

   }

   // Search hotels from home page
   function search_hotels_front($perpage = null,$offset = null, $orderby = null,$cities = null){


   $data = array();
    $checkin = $this->input->get('checkin');
    $checkout = $this->input->get('checkout');
    $adult = $this->input->get('adults');
    $child = $this->input->get('child');
    $country = $this->input->get('country');
    $state = $this->input->get('state');
    $hotelcity = $this->input->get('city');
    $types = $this->input->get('type');
    $groups = $this->input->get('group');
    $categories = $this->input->get('category');
    $stars= $this->input->get('stars');
    $sprice = $this->input->get('price');

 $days = pt_count_days($checkin,$checkout);

   if($offset != null){

   $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;

   }
   $this->db->select('pt_hotels.*');
   if($orderby == "za"){

   $this->db->order_by('pt_hotels.hotel_title','desc');


   }elseif($orderby == "az"){

  $this->db->order_by('pt_hotels.hotel_title','asc');

   }elseif($orderby == "oldf"){

  $this->db->order_by('pt_hotels.hotel_id','asc');

   }elseif($orderby == "newf"){

  $this->db->order_by('pt_hotels.hotel_id','desc');

   }elseif($orderby == "ol"){

  $this->db->order_by('pt_hotels.hotel_order','asc');

   }


      if(!empty($adult)){

  $this->db->where('pt_hotels.hotel_adults <=',$adult);


    }

     if(!empty($child)){

  $this->db->where('pt_hotels.hotel_children <=',$child);


    }

    if(!empty($country)){

        if(!empty($cities)){
     $this->db->where_in('pt_hotels.hotel_city',$cities);

        }else{
         $this->db->where('pt_hotels.hotel_city','0');

        }


    }

      if(!empty($state)){

            if(!empty($cities)){
    $this->db->where_in('pt_hotels.hotel_city',$cities);

        }else{
         $this->db->where('pt_hotels.hotel_city','0');

        }



    }

      if(!empty($hotelcity)){


     $this->db->where('pt_hotels.hotel_city',$hotelcity);


    }


      if(!empty($types)){


     $this->db->where_in('pt_hotels.hotel_type',$types);


    }


          if(!empty($stars)){


     $this->db->where('pt_hotels.hotel_stars',$stars);


    }

          if(!empty($sprice)){

    $sprice = explode(",",$sprice);
   $minp = $sprice[0];
   $maxp = $sprice[1];

     $this->db->where('pt_hotels.hotel_basic_price >=',$minp);
     $this->db->where('pt_hotels.hotel_basic_price <=',$maxp);


    }


  $this->db->select_avg('pt_reviews.review_overall','overall');
  $this->db->group_by('pt_hotels.hotel_id');
  $this->db->join('pt_reviews','pt_hotels.hotel_id = pt_reviews.review_itemid','left');
    $this->db->where('pt_hotels.hotel_status','1');
   $query = $this->db->get('pt_hotels',$perpage,$offset);


   $data['all']  = $query->result();

   $data['rows'] = $query->num_rows();



   return $data;

   }




  // Advanced Price info of a hotel

  function get_hotel_adv_price($id){
   $data = array();
  $today = time();
  $this->db->where('hp_hotel_id',$id);
$this->db->where('hp_from <=',$today);
  $this->db->where('hp_to >=',$today);
  $query = $this->db->get('pt_hotel_aprice')->result();
    if(!empty($query)){

$data['basic'] = $query[0]->hp_basic;
  $data['discount'] = $query[0]->hp_discount;


    }

  return $data;


  }




     function search_hotels_by_text($perpage = null,$offset = null, $orderby = null,$cities = null){
      $data = array();


   $txtsearch = $this->input->get('searching');

    $checkin = $this->input->get('checkin');
    $checkout = $this->input->get('checkout');
    $adult = $this->input->get('adults');
    $child = $this->input->get('child');


 $days = pt_count_days($checkin,$checkout);

  if($offset != null){

   $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;

   }




  $this->db->select('pt_hotels.*');
  $this->db->select_avg('pt_reviews.review_overall','overall');
  $this->db->group_by('pt_hotels.hotel_id');
  $this->db->join('pt_reviews','pt_hotels.hotel_id = pt_reviews.review_itemid','left');
  $this->db->like('pt_hotels.hotel_title', $txtsearch);
   if($orderby == "za"){

   $this->db->order_by('pt_hotels.hotel_title','desc');


   }elseif($orderby == "az"){

  $this->db->order_by('pt_hotels.hotel_title','asc');

   }elseif($orderby == "oldf"){

  $this->db->order_by('pt_hotels.hotel_id','asc');

   }elseif($orderby == "newf"){

  $this->db->order_by('pt_hotels.hotel_id','desc');

   }elseif($orderby == "ol"){

  $this->db->order_by('pt_hotels.hotel_order','asc');

   }



  $this->db->where('pt_hotels.hotel_status','1');
  $query = $this->db->get('pt_hotels',$perpage,$offset);

   $data['all']  = $query->result();

   $data['rows'] = $query->num_rows();





   return $data;

   }


   // for auto suggestions search
    function textsearch(){
 	$q = $this->input->get('q');
	$term = mysql_real_escape_string($q);
    $query = $this->db->query("SELECT hotel_title as name FROM pt_hotels WHERE hotel_title LIKE '%$term%' ")->result();


   foreach($query as $qry){

    echo $qry->name."\n";

     }



    }
  // get all hotels for related selection for backend
  function select_related_hotels($id = null){


  $this->db->select('hotel_title,hotel_id');
  if(!empty($id)){

  $this->db->where('hotel_id !=',$id);

  }


  return $this->db->get('pt_hotels')->result();



  }

  // get related hotels for front-end
  function get_related_hotels($hotels){
   $id = explode(",",$hotels);
  $this->db->select('pt_hotels.hotel_title,pt_hotels.hotel_id,pt_hotels.hotel_basic_price,pt_hotels.hotel_basic_discount,pt_hotels.hotel_stars,pt_hotel_images.himg_image,pt_hotel_images.himg_approved');
  $this->db->where_in('pt_hotels.hotel_id',$id);
  $this->db->where('pt_hotel_images.himg_type','default');
  $this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');

  return $this->db->get('pt_hotels')->result();

  }

  // get featured hotels

   function featured_hotels_front(){
        $settings =  $this->Settings_model->get_front_settings('hotels');
        $limit = $settings[0]->front_homepage;
        $orderby = $settings[0]->front_homepage_order;
   $this->db->select('pt_hotels.hotel_status,pt_hotels.hotel_id,pt_hotels.hotel_desc,pt_hotels.hotel_stars,
   pt_hotels.hotel_title,pt_hotels.hotel_city,pt_hotels.hotel_basic_price,pt_hotels.hotel_basic_discount');
   $this->db->select_avg('pt_reviews.review_overall','overall');
   $this->db->where('pt_hotels.hotel_is_featured','yes');
   $this->db->where('pt_hotels.hotel_featured_from <',time());
   $this->db->where('pt_hotels.hotel_featured_to >',time());
   $this->db->group_by('pt_hotels.hotel_id');
   $this->db->join('pt_reviews','pt_hotels.hotel_id = pt_reviews.review_itemid','left');
   $this->db->having('hotel_status','1');
   $this->db->limit($limit);
   if($orderby == "za"){

   $this->db->order_by('pt_hotels.hotel_title','desc');


   }elseif($orderby == "az"){

  $this->db->order_by('pt_hotels.hotel_title','asc');

   }elseif($orderby == "oldf"){

  $this->db->order_by('pt_hotels.hotel_id','asc');

   }elseif($orderby == "newf"){

  $this->db->order_by('pt_hotels.hotel_id','desc');

   }elseif($orderby == "ol"){

  $this->db->order_by('pt_hotels.hotel_order','asc');

   }



   return $this->db->get('pt_hotels')->result();

   }
    // get popular hotels
    function popular_hotels_front(){
        $settings =  $this->Settings_model->get_front_settings('hotels');
        $limit = $settings[0]->front_popular;
        $orderby = $settings[0]->front_popular_order;
   $this->db->select('pt_hotels.hotel_status,pt_hotels.hotel_id,pt_hotels.hotel_desc,pt_hotels.hotel_stars,
   pt_hotels.hotel_title,pt_hotels.hotel_city,pt_hotels.hotel_basic_price,pt_hotels.hotel_basic_discount');
   $this->db->select_avg('pt_reviews.review_overall','overall');
   $this->db->order_by('overall','desc');
   $this->db->group_by('pt_hotels.hotel_id');
   $this->db->join('pt_reviews','pt_hotels.hotel_id = pt_reviews.review_itemid');
   $this->db->where('hotel_status','1');
   $this->db->limit($limit);
   if($orderby == "za"){

   $this->db->order_by('pt_hotels.hotel_title','desc');


   }elseif($orderby == "az"){

  $this->db->order_by('pt_hotels.hotel_title','asc');

   }elseif($orderby == "oldf"){

  $this->db->order_by('pt_hotels.hotel_id','asc');

   }elseif($orderby == "newf"){

  $this->db->order_by('pt_hotels.hotel_id','desc');

   }elseif($orderby == "ol"){

  $this->db->order_by('pt_hotels.hotel_order','asc');

   }



   return $this->db->get('pt_hotels')->result();

   }

       // get latest hotels
    function latest_hotels_front(){
        $settings =  $this->Settings_model->get_front_settings('hotels');
        $limit = $settings[0]->front_latest;

   $this->db->select('pt_hotels.hotel_status,pt_hotels.hotel_id,pt_hotels.hotel_desc,pt_hotels.hotel_stars,
   pt_hotels.hotel_title,pt_hotels.hotel_city,pt_hotels.hotel_basic_price,pt_hotels.hotel_basic_discount');
   $this->db->select_avg('pt_reviews.review_overall','overall');
   $this->db->order_by('pt_hotels.hotel_id','desc');
   $this->db->group_by('pt_hotels.hotel_id');
   $this->db->join('pt_reviews','pt_hotels.hotel_id = pt_reviews.review_itemid','left');
   $this->db->where('hotel_status','1');
   $this->db->limit($limit);

   return $this->db->get('pt_hotels')->result();

   }

  function offers_data($id){

  $this->db->where('offer_module','hotels');
  $this->db->where('offer_item',$id);
return  $this->db->get('pt_special_offers')->result();



  }



  function is_mine_hotel($hotel,$id){
  $title = str_replace("-"," ",$hotel);
  $this->db->where('hotel_title',$title);
  $this->db->where('hotel_owned_by',$id);
  $res = $this->db->get('pt_hotels')->num_rows();
  if($res > 0){
    return true;
  }else{
    return false;
  }

  }


}