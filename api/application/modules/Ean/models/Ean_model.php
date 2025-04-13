<?php
class Ean_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     // update front settings
       function update_front_settings(){

        $homePage = array("p" => $this->input->post('pcity'), "f" => $this->input->post('fcity'));
        $homepageCities = json_encode($homePage);

        $ufor = $this->input->post('updatefor');
         $data = array(
         'front_icon' =>  $this->input->post('page_icon'),
         'front_listings' =>  $this->input->post('listings'),
         'front_popular' =>  $this->input->post('popular'),
         'front_homepage' =>  $this->input->post('home'),
         'front_top_cities' =>  $homepageCities,
         'front_search_city' =>  $this->input->post('defcity'),
         'front_search' =>  $this->input->post('frontsearch'),
         'front_related' =>  $this->input->post('related_hotels'),
         'apikey' =>  $this->input->post('apikey'),
         'cid' =>  $this->input->post('cid'),
         'secret' =>  $this->input->post('secret'),
         'front_tax_fixed' =>  $this->input->post('revision'),
         'header_title' =>  $this->input->post('headertitle'),
         'linktarget' =>  $this->input->post('target'),
         'currency' =>  $this->input->post('currency'),
         'front_search_min_price' =>  $this->input->post('minprice'),
         'front_search_max_price' =>  $this->input->post('maxprice'),
         'language' =>  $this->input->post('language'),
         'testing_mode' =>  intval($this->input->post('mode')),
         'meta_keywords' => $this->input->post('keywords'),
        'meta_description' => $this->input->post('description')


         );
        $this->db->where('front_for',$ufor);
        $this->db->update('pt_front_settings',$data);
        $this->session->set_flashdata('flashmsgs', "Updated Successfully");

      }

    function insert_booking($insertdata){

    $data = array(
      'book_user' => $insertdata['user'],
      'book_checkin' => $insertdata['checkin'],
      'book_checkout' => $insertdata['checkout'],
      'book_hotelid' => $insertdata['hotel'],
      'book_hotel' => $insertdata['hotelname'],
      'book_stars' => $insertdata['stars'],
      'book_location' => $insertdata['location'],
      'book_roomname' => $insertdata['roomname'],
      'book_roomtotal' => $insertdata['roomtotal'],
      'book_tax' => $insertdata['tax'],
      'book_total' => $insertdata['total'],
      'book_currency' => $insertdata['currency'],
      'book_email' => $insertdata['email'],
      'book_itineraryid' => $insertdata['itineraryid'],
      'book_confirmation' => $insertdata['confirmation'],
      'book_nights' => $insertdata['nights'],
      'book_thumbnail' => $insertdata['thumbnail'],
      'book_date' => time(),
      'book_response' => $insertdata['bookResponse']
    );

    $this->db->insert('pt_ean_booking',$data);

    }

    function cancel_my_booking($id,$cancelnumber){

    $data = array(
    'book_cancelnumber' => $cancelnumber,
    );
    $this->db->where('book_id',$id);

    $this->db->update('pt_ean_booking',$data);
    }

    function get_my_bookings($user){
    $this->db->where('book_user',$user);
    $this->db->order_by('book_id','desc');
    $results = $this->db->get('pt_ean_booking')->result();
    $bookings = new stdClass;
    foreach($results as $rs){
        $bookings->bookings[] = (object)array(
            'title' => $rs->book_hotel,
            'stars' => pt_create_stars($rs->book_stars),
            'checkin' => $rs->book_checkin,
            'checkout' => $rs->book_checkout,
            'thumbnail' => $rs->book_thumbnail,
            'location' => $rs->book_location,
            'id' => $rs->book_id,
            'code' => $rs->book_itineraryid,
            'total' => $rs->book_total,
            'currency' => $rs->book_currency,
            'cancelNumber' => $rs->book_cancelnumber

            );

    }

    return $bookings;


    }

    function get_single_booking($id){
    $this->db->where('book_id',$id);
    return $this->db->get('pt_ean_booking')->result();
    }

    function get_all_bookings(){
    return $this->db->get('pt_ean_booking')->result();
    }

      // get all bookings
    function get_all_bookings_back_admin(){

    $this->db->join('pt_accounts','pt_ean_booking.book_user = pt_accounts.accounts_id','left');
    $this->db->order_by('pt_ean_booking.book_id','desc');


    $query =  $this->db->get('pt_ean_booking');

    $data['all'] = $query->result();
    $data['nums'] = $query->num_rows();
    return $data;

    }


    // get all bookings with limit
    function get_all_bookings_back_limit_admin($perpage = null,$offset = null, $orderby = null){

     if($offset != null){

     $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;

     }

    $this->db->join('pt_accounts','pt_ean_booking.book_user = pt_accounts.accounts_id','left');
    $this->db->order_by('pt_ean_booking.book_id','desc');


    $query =  $this->db->get('pt_ean_booking',$perpage,$offset);

    $data['all'] = $query->result();
   // $data['nums'] = $query->num_rows();
    return $data;

    }

    // Guest Signup account for expedia
    function eanSignup_account($userdata) {

        $now = date('Y-m-d H:i:s');
        $password = rand(6, 15);
        $data = array('accounts_email' => $userdata['email'], 'accounts_password' => sha1($password), 'accounts_type' => 'guest', 'ai_first_name' => $userdata['firstName'],
            'ai_last_name' => $userdata['lastName'], 'ai_mobile' => $userdata['phone'], 'ai_address_1' => $userdata['address'], 'accounts_created_at' => $now,
            'ai_country' => $userdata['country'],'ai_city' => $userdata['city'], 'ai_state' => $userdata['province'], 'ai_postal_code' => $userdata['postalcode'],'accounts_updated_at' => $now, 'accounts_status' => 'no');
        $this->db->insert('pt_accounts', $data);
        $id = $this->db->insert_id();
        return $id;
    }


    function delete_booking($id) {
              $this->db->where('book_id', $id);
              $this->db->delete('pt_ean_booking');

          }

          function languagesList(){
                    
               $list = array(
                 'en' => 'en_US',
                 'ar' => 'ar_SA',
                 'cs' => 'cs_CZ',
                 'da' => 'da_DK',
                 'de' => 'de_DE',
                 'el' => 'el_GR',
                 'es' => 'es_ES',
                 'et' => 'et_EE',
                 'fi' => 'fi_FI',
                 'fr' => 'fr_FR',
                 'hu' => 'hu_HU',
                 'hr' => 'hr_HR',
                 'id' => 'id_ID',
                 'is' => 'is_IS',
                 'it' => 'it_IT',
                 'ja' => 'ja_JP',
                 'ko' => 'ko_KR',
                 'ms' => 'ms_MY',
                 'lv' => 'lv_LV',
                 'lt' => 'lt_LT',
                 'nl' => 'nl_NL',
                 'no' => 'no_NO',
                 'pl' => 'pl_PL',
                 'pt' => 'pt_BR',
                 'ru' => 'ru_RU',
                 'sv' => 'sv_SE',
                 'sk' => 'sk_SK',
                 'th' => 'th_TH',
                 'tr' => 'tr_TR',
                 'uk' => 'uk_UA',
                 'vi' => 'vi_VN',
                 'zh' => 'zh_TW'
                 );

            return $list;

             }

             function getPropertyAmenities($lang){
               $langDetails = $this->languagesList();
               $lang = $langDetails[$lang];

               $this->db->where('amtype','PropertyAmenity');
               $list = $this->db->get('amenities')->result();
               $result = array();
               if(!empty($list)){

                 foreach ($list as $l) {
                   $this->db->where('lang',$lang);
                   $this->db->where('attrid',$l->id);
                   $res = $this->db->get('amenities_translation')->result();
                   if(!empty($res)){
                     $name = $res[0]->trans_name;
                   }else{
                     $name = $l->name;
                   }
                 $result[] = (object) array('id' => $l->id, 'name' => $name);
                 }
               }

               return $result;

             }

             function getRoomAmenities($lang){
               $langDetails = $this->languagesList();
               $lang = $langDetails[$lang];

               $this->db->where('amtype','RoomAmenity');
               $list = $this->db->get('amenities')->result();
               $result = array();
               if(!empty($list)){

                 foreach ($list as $l) {
                   $this->db->where('lang',$lang);
                   $this->db->where('attrid',$l->id);
                   $res = $this->db->get('amenities_translation')->result();
                   if(!empty($res)){
                     $name = $res[0]->trans_name;
                   }else{
                     $name = $l->name;
                   }
                 $result[] = (object) array('id' => $l->id, 'name' => $name);
                 }
               }

               return $result;

             }


}
