<?php

class Rooms_model extends CI_Model{

    public $langdef;
    public $adults;
    public $children;

    function __construct()

    {

        // Call the Model constructor

        parent::__construct();

        $this->langdef = DEFLANG;

    }





    // get all rooms info

    function get_all_rooms($hotelid = null,$userid = null){

    $data = array();



    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_owned_by,pt_hotels.hotel_title,pt_hotels.hotel_slug,pt_rooms.room_title,pt_rooms.room_hotel,pt_rooms.room_id,pt_rooms.room_type,pt_rooms.room_status,pt_rooms.room_added_on,pt_rooms.room_order');



    if(!empty($hotelid)){

     $this->db->where('pt_rooms.room_hotel',$hotelid);

    }



    if(!empty($userid)){

     $this->db->where('pt_hotels.hotel_owned_by',$userid);

    }



    $this->db->order_by('pt_rooms.room_id','desc');

    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id','left');



    $query =  $this->db->get('pt_rooms');

    $data['all'] = $query->result();

    $data['nums'] = $query->num_rows();



    return $data;



    }





        // get all rooms info

    function get_all_rooms_limit($hotelid = null,$userid = null, $perpage = null,$offset = null, $orderby = null){

    $data = array();



        if($offset != null){



     $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;



     }



    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title,pt_hotels.hotel_slug,pt_rooms.room_title,pt_rooms.room_hotel,pt_rooms.room_id,pt_rooms.room_type,pt_rooms.room_status,pt_rooms.room_added_on,pt_rooms.room_order');



    if(!empty($hotelid)){

     $this->db->where('pt_rooms.room_hotel',$hotelid);

    }

    if(!empty($userid)){

     $this->db->where('pt_hotels.hotel_owned_by',$userid);

    }

    $this->db->order_by('pt_rooms.room_id','desc');

    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id','left');



    $query =  $this->db->get('pt_rooms',$perpage,$offset);

    $data['all'] = $query->result();

   // $data['nums'] = $query->num_rows();



    return $data;



    }



      // get all rooms info by search

    function search_all_rooms(){

       $hotelid = $this->input->post('hotelid');

       $status = $this->input->post('status');

       $roomtype = $this->input->post('roomtype');

       $rfrom = strtotime($this->input->post('ffrom'));

       $rto = strtotime($this->input->post('fto'));





    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title,pt_rooms.room_title,pt_rooms.room_hotel,pt_rooms.room_id,pt_rooms.room_type,pt_rooms.room_status,pt_rooms.room_added_on,pt_rooms.room_order');



    if(!empty($hotelid)){

     $this->db->where('pt_rooms.room_hotel',$hotelid);

    }



     if($status == '0' || $status == '1'){

     $this->db->where('pt_rooms.room_status',$status);

    }



    if(!empty($rfrom)){

     $this->db->where('pt_rooms.room_added_on >=',$rfrom);

    }



    if(!empty($rto)){

     $this->db->where('pt_rooms.room_added_on <=',$rto);

    }



     if(!empty($roomtype)){

     $this->db->where('pt_rooms.room_type',$roomtype);

    }





    $this->db->order_by('pt_rooms.room_id','desc');

    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id','left');



    $query =  $this->db->get('pt_rooms');

    $data = $query->result();



    return $data;







    }







    // get all rooms info by search

    function search_all_rooms_back_limit($term, $userid = null, $perpage = null,$offset = null, $orderby = null){



      if($offset != null){



   $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;



   }



    $data = array();



    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title,pt_rooms.room_title,pt_rooms.room_hotel,pt_rooms.room_id,pt_rooms.room_type,pt_rooms.room_status,pt_rooms.room_added_on,pt_rooms.room_order');

    $this->db->like('pt_hotels.hotel_title',$term);

    $this->db->or_like('pt_rooms.room_title',$term);

    $this->db->order_by('pt_rooms.room_id','desc');

    $this->db->group_by('pt_rooms.room_id');

    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id','left');

    if(!empty($userid)){

     $this->db->where('pt_hotels.hotel_owned_by',$userid);

    }

    $query =  $this->db->get('pt_rooms',$perpage,$offset);

    $data['all'] = $query->result();



    $data['nums'] = $query->num_rows();



    return $data;







    }





     // get all rooms info by advance search

    function adv_search_all_rooms_back_limit($data, $userid = null, $perpage = null,$offset = null, $orderby = null){

     $roomtitle = $data["roomtitle"];

    $roomtype = $data["roomtype"];

    $status = $data["status"];

    $hotelid = $data["hotelid"];

      if($offset != null){



   $offset = ($offset  == 1) ? 0 : ($offset * $perpage) - $perpage;



   }



    $data = array();



    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title,pt_rooms.room_title,pt_rooms.room_hotel,pt_rooms.room_id,pt_rooms.room_type,pt_rooms.room_status,pt_rooms.room_added_on,pt_rooms.room_order');

     if(!empty($hotelid)){

     $this->db->where('pt_hotels.hotel_id',$hotelid);

    }



     if(!empty($roomtitle)){

    $this->db->like('pt_rooms.room_title',$roomtitle);

    }



     if(!empty($roomtype)){

    $this->db->like('pt_rooms.room_type',$roomtype);

    }





     if(!empty($userid)){

     $this->db->where('pt_hotels.hotel_owned_by',$userid);

    }



    $this->db->where('pt_rooms.room_status',$status);

    $this->db->order_by('pt_rooms.room_id','desc');

    $this->db->group_by('pt_rooms.room_id');

    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id','left');



    if(!empty($userid)){

     $this->db->where('pt_hotels.hotel_owned_by',$userid);

    }

    $query =  $this->db->get('pt_rooms',$perpage,$offset);

    $data['all'] = $query->result();



    $data['nums'] = $query->num_rows();



    return $data;







    }



    // get all data of single Room by id

    function getRoomData($roomid){



    $this->db->select('pt_hotels.hotel_id,pt_hotels.hotel_title,pt_rooms.*');

    $this->db->where('pt_rooms.room_id',$roomid);

    $this->db->join('pt_hotels','pt_rooms.room_hotel = pt_hotels.hotel_id');

    return $this->db->get('pt_rooms')->result();





    }



   // add room data

   function add_room(){



   $this->db->where('room_hotel',$this->input->post('hotelid'));

   $nums = $this->db->get('pt_rooms')->num_rows();

   $roomorder = $nums + 1;

  $quantity = $this->input->post('quantity');

   $ramts = $this->input->post('roomamenities');

   if(!empty($ramts)){

    $amenities =  implode(",",$ramts);

   }else{

     $amenities =  "";

   }



   if($quantity < 1){

   $quantity = 1;



   }



$extrabeds = $this->input->post('extrabeds');

   if($extrabeds > 0){

     $bedcharges =  $this->input->post('bedcharges');

   }else{

     $bedcharges = 0;

   }





   $data = array(

            'room_title' => "",

            'room_desc' => $this->input->post('roomdesc'),

            'room_hotel' => $this->input->post('hotelid'),

            'room_basic_price' => floatval($this->input->post('basicprice')),

            'room_adult_price' => floatval($this->input->post('adultsprice')),

            'room_child_price' => floatval($this->input->post('childprice')),

            'price_type' => floatval($this->input->post('price_type')),

            'room_amenities' => $amenities,

            'room_type' => intval($this->input->post('roomtype')),

            'room_status' => $this->input->post('roomstatus'),

            'room_adults' => intval($this->input->post('adults')),

            'room_children' => intval($this->input->post('children')),

            'room_min_stay' =>  intval($this->input->post('minstay')),

            'extra_bed_charges' =>  floatval($bedcharges),

            'extra_bed' =>  intval($this->input->post('extrabeds')),

            'room_quantity' => $quantity,

            'room_order' => $roomorder,

            'room_added_on' => time()



   );



   $this->db->insert('pt_rooms',$data);

   $roomid = $this->db->insert_id();

   if($roomid > 0){

   $this->addRoomAvailability($roomid,$quantity); 

   }

   

   return $roomid;

   }





  // update room data

   function update_room($roomid){



           $ramts = $this->input->post('roomamenities');

   if(!empty($ramts)){

    $amenities =  implode(",",$ramts);

   }else{

     $amenities =  "";

   }

        $quantity = $this->input->post('quantity');

  if($quantity < 1){

   $quantity = 1;



   }



   $extrabeds = $this->input->post('extrabeds');

   if($extrabeds > 0){

     $bedcharges =  $this->input->post('bedcharges');

   }else{

     $bedcharges = 0;

   }



   $data = array(

            'room_title' => "",

            'room_desc' => $this->input->post('roomdesc'),

            'room_hotel' => $this->input->post('hotelid'),

            'room_basic_price' => floatval($this->input->post('basicprice')),

       'room_adult_price' => floatval($this->input->post('adultsprice')),

       'room_child_price' => floatval($this->input->post('childprice')),

        'price_type' => floatval($this->input->post('price_type')),

            'room_amenities' => $amenities,

            'room_type' => intval($this->input->post('roomtype')),

            'room_status' => $this->input->post('roomstatus'),

            'room_adults' => intval($this->input->post('adults')),

            'room_children' => intval($this->input->post('children')),

            'room_min_stay' =>  intval($this->input->post('minstay')),

            'extra_bed_charges' =>  floatval($this->input->post('bedcharges')),

            'extra_bed' =>  intval($this->input->post('extrabeds')),

            'room_quantity' => $quantity,

   );



   $this->db->where('room_id',$roomid);

   $this->db->update('pt_rooms',$data);

   $oldquantity = $this->input->post('oldquantity');



   if($oldquantity != $quantity){

     $this->updateRoomAvailability($roomid,$quantity);

   }



   }







 // add room images by type

   function add_room_image($type,$filename,$roomid){

   $imgorder = 0;



   $this->db->where('rimg_room_id',$roomid);

   $imgorder = $this->db->get('pt_room_images')->num_rows();

   $imgorder = $imgorder + 1;

    $approval = pt_admin_gallery_approve();



   $this->db->where('rimg_type','default');

   $this->db->where('rimg_room_id',$roomid);

   $hasdefault = $this->db->get('pt_room_images')->num_rows();

   if($hasdefault < 1){

     $type = 'default';

   }



      $data = array(

        'rimg_room_id' => $roomid,

        'rimg_type' => $type,

        'rimg_image' => $filename,

        'rimg_order' => $imgorder,

        'rimg_approved' => $approval



      );

      $this->db->insert('pt_room_images',$data);



   }





   //update room thumbnail

    function update_thumb($oldthumb,$newthumb,$roomid){

    $data = array(



            'rimg_type' => ''



   );

   $this->db->where('rimg_id',$oldthumb);

   $this->db->where('rimg_room_id',$roomid);

   $this->db->update('pt_room_images',$data);





   $data2 = array(



           'rimg_type' => 'default'



   );

   $this->db->where('rimg_id',$newthumb);

   $this->db->where('rimg_room_id',$roomid);

   $this->db->update('pt_room_images',$data2);



   }



   // get default image of room

    function default_room_img($id){



    $this->db->where('rimg_type','default');

    $this->db->where('rimg_approved','1');

    $this->db->where('rimg_room_id',$id);



    $res = $this->db->get('pt_room_images')->result();

    if(!empty($res)){

    return $res[0]->rimg_image;

    }else{

      return '';

    }





    }



  // update Room image by type

   function update_room_image($type,$filename,$roomid){





      $data = array(



        'rimg_image' => $filename



      );

      $this->db->where("rimg_type",$type);

      $this->db->where("rimg_room_id",$roomid);

      $this->db->update('pt_room_images',$data);



   }



   // update room order

   function update_room_order($id,$order){



    $data = array(

       'room_order' => $order

    );



    $this->db->where('room_id',$id);

    $this->db->update('pt_rooms',$data);







    }



        // update room image order

    function update_room_image_order($imgid,$order){

      $data = array(

       'rimg_order' => $order

    );



    $this->db->where('rimg_id',$imgid);

    $this->db->update('pt_room_images',$data);







    }



     // Disable Room



    public function disable_room($id){



    $data = array(

       'room_status' => '0'

    );



    $this->db->where('room_id',$id);

    $this->db->update('pt_rooms',$data);







    }



    // Enable Room



    public function enable_room($id){



    $data = array(

       'room_status' => '1'

    );



    $this->db->where('room_id',$id);

    $this->db->update('pt_rooms',$data);







    }







    // Get Room Images

    function room_images($id){



    $this->db->where('rimg_room_id',$id);

    $this->db->order_by('rimg_id','desc');

    $q =  $this->db->get('pt_room_images');

    $data['all_images'] = $q->result();

    $data['counts'] = $q->num_rows();





    return $data;





    }







    // update image order

    function update_image_order($imgid,$order){

      $data = array(

       'himg_order' => $order

    );



    $this->db->where('himg_id',$imgid);

    $this->db->update('pt_hotel_images',$data);







    }



     // update Room Type

    function update_room_type($roomid,$type){

      $data = array(

       'room_type' => $type

    );



    $this->db->where('room_id',$roomid);

    $this->db->update('pt_rooms',$data);







    }





    // Approve or reject Room Images

   function approve_reject_images(){

   $data = array(



            'rimg_approved' =>   $this->input->post('apprej')



   );

   $this->db->where('rimg_id',$this->input->post('imgid'));

   $this->db->update('pt_room_images',$data);





   }









   // get room images for hotel page

   function room_images_front($id){



   $this->db->where('rimg_room_id',$id);

   $this->db->where('rimg_type !=','default');

   $this->db->order_by('rimg_order','asc');

   $this->db->where('rimg_approved','1');



   return $this->db->get('pt_room_images')->result();





   }





   // update translated data os some fields in english

  function update_english($id){



   $data = array(

            'room_title' => "",

            'room_desc' => $this->input->post('desc'),

            'room_additional_facilities' => $this->input->post('additional'),

            'room_specials' => $this->input->post('specials')

   );

   $this->db->where('room_id',$id);

   $this->db->update('pt_rooms',$data);

  }







    // get number of photos of room

    function photos_count($roomid) {

        $this->db->where('rimg_room_id', $roomid);

          return $this->db->get('pt_room_images')->num_rows();

    }

    // get room gallery images

     function roomGallery($id){

          $this->db->select('pt_rooms.thumbnail_image as thumbnail,pt_room_images.rimg_id as id,pt_room_images.rimg_room_id as itemid,pt_room_images.rimg_type as type,pt_room_images.rimg_image as image,pt_room_images.rimg_order as imgorder,pt_room_images.rimg_image as image,pt_room_images.rimg_approved as approved');

          $this->db->where('pt_rooms.room_id',$id);

          $this->db->join('pt_room_images', 'pt_rooms.room_id = pt_room_images.rimg_room_id', 'left');

          $this->db->order_by('pt_room_images.rimg_id','desc');

          return $this->db->get('pt_rooms')->result();

        }



     // Adds translation of some fields data

    function add_translation($postdata,$id) {

      foreach($postdata as $lang => $val){

         if(array_filter($val)){

           // $title = $val['title'];

                $desc = $val['desc'];



                $data = array(

                'trans_title' => "",

                'trans_desc' => $desc,

                'item_id' => $id,

                'trans_lang' => $lang

                );

        $this->db->insert('pt_rooms_translation', $data);

                }



                }



    }

   // Update translation of some fields data

    function update_translation($postdata,$id) {



       foreach($postdata as $lang => $val){

         if(array_filter($val)){

           // $title = $val['title'];

                $desc = $val['desc'];

                $transAvailable = $this->getBackTranslation($lang,$id);

                if(empty($transAvailable)){



                $data = array(

                'trans_title' => "",

                'trans_desc' => $desc,

                'item_id' => $id,

                'trans_lang' => $lang

                );

        $this->db->insert('pt_rooms_translation', $data);



                }else{



                $data = array(

                'trans_title' => "",

                'trans_desc' => $desc,

                );

        $this->db->where('item_id', $id);

        $this->db->where('trans_lang', $lang);

          $this->db->update('pt_rooms_translation', $data);



                }





              }



                }

    }



  function getBackTranslation($lang,$id){



            $this->db->where('trans_lang',$lang);

            $this->db->where('item_id',$id);

            return $this->db->get('pt_rooms_translation')->result();



        }



      // Delete Room Images

    function delete_image($imgname = null, $imgid = null, $roomid = null ){



                 $this->db->where('rimg_id',$imgid);

                 $this->db->delete('pt_room_images');

                 $this->updateRoomThumb($roomid,$imgname,"delete");

                 @unlink(PT_ROOMS_THUMBS_UPLOAD.$imgname);

                @unlink(PT_ROOMS_IMAGES_UPLOAD.$imgname);





    }

        //update room thumbnail

    function updateRoomThumb($roomid,$imgname,$action) {

      if($action == "delete"){

            $this->db->select('thumbnail_image');

            $this->db->where('thumbnail_image',$imgname);

            $this->db->where('room_id',$roomid);

            $rs = $this->db->get('pt_rooms')->num_rows();

            if($rs > 0){

              $data = array(

              'thumbnail_image' => PT_BLANK_IMG

              );

              $this->db->where('room_id',$roomid);

              $this->db->update('pt_rooms',$data);

            }

            }else{

              $data = array(

              'thumbnail_image' => $imgname

              );

              $this->db->where('room_id',$roomid);

              $this->db->update('pt_rooms',$data);

            }



    }



        function addPhotos($id,$filename){

         $this->db->select('thumbnail_image');

         $this->db->where('room_id',$id);

         $rs = $this->db->get('pt_rooms')->result();

         if($rs[0]->thumbnail_image == PT_BLANK_IMG){

               $data = array('thumbnail_image' => $filename);

               $this->db->where('room_id',$id);

               $this->db->update('pt_rooms',$data);

         }



        //add photos to hotel images table

        $imgorder = 0;

        $this->db->where('rimg_room_id', $id);

        $imgorder = $this->db->get('pt_room_images')->num_rows();

        $imgorder = $imgorder + 1;



        $approval = pt_admin_gallery_approve();

          $insdata = array(

                'rimg_room_id' => $id,

                'rimg_image' => $filename,

                'rimg_order' => $imgorder,

                'rimg_approved' => $approval

                );

        $this->db->insert('pt_room_images', $insdata);





        }

        // get room quantity

        function getRoomQuantity($id){

          $this->db->select('room_quantity');

          $this->db->where('room_id',$id);

          $rs = $this->db->get('pt_rooms')->result();

          return $rs[0]->room_quantity;

        }



        //Add Room advanced prices

        function addRoomPrices($roomid){



          $datefrom = databaseDate($this->input->post('fromdate'));

          $dateto = databaseDate($this->input->post('todate'));



          $data = array(

          'room_id' => $roomid,

          'date_from' => $datefrom,

          'date_to' => $dateto,

          'adults' => intval($this->input->post('adult')),

          'children' => intval($this->input->post('child')),

          'extra_bed_charge' => floatval($this->input->post('bedcharges')),

          'mon' => floatval($this->input->post('mon')),

          'tue' => floatval($this->input->post('tue')),

          'wed' => floatval($this->input->post('wed')),

          'thu' => floatval($this->input->post('thu')),

          'fri' => floatval($this->input->post('fri')),

          'sat' => floatval($this->input->post('sat')),

          'sun' => floatval($this->input->post('sun'))



          );



          $this->db->insert('pt_rooms_prices',$data);

          $this->session->set_flashdata('flashmsgs', "Price Added Successfully");

        }



        //Add Room advanced prices

        function updateRoomPrices($prices){

            foreach($prices as $p => $v){

           $data = array(

          'adults' => intval($v['adults']),

          'children' => intval($v['child']),

          'extra_bed_charge' => floatval($v['extra_bed_charges']),

          'mon' => floatval($v['mon']),

          'tue' => floatval($v['tue']),

          'wed' => floatval($v['wed']),

          'thu' => floatval($v['thu']),

          'fri' => floatval($v['fri']),

          'sat' => floatval($v['sat']),

          'sun' => floatval($v['sun'])

          );



          $this->db->where('id',$p);

          $this->db->update('pt_rooms_prices',$data);

            }



          $this->session->set_flashdata('flashmsgs', "Price Updated Successfully");

        }

        // get Room advanced prices

        function getRoomPrices($roomid){



          $this->db->where('room_id',$roomid);

          $this->db->order_by('date_from','ASC');

          return $this->db->get('pt_rooms_prices')->result();

        }



        function deleteRoomPrice($id){

            $this->db->where('id',$id);

            $this->db->delete('pt_rooms_prices');

        }



        function addRoomAvailability($roomid,$count){





      for($y = 0; $y <= 1; $y++){ // 0 - current, 1 - next year

        $sql_temp = 'INSERT INTO pt_rooms_availabilities (id, room_id, y, m ';

        $sql_temp_values = '';

        for($i=1; $i<=31; $i++){

          $sql_temp .= ', d'.$i;

          $sql_temp_values .= ', '.$count;

        }

        $sql_temp .= ')';

        $sql_temp .= 'VALUES (NULL, '.$roomid.', '.$y.', _MONTH_'.$sql_temp_values.');';



        for($i = 1; $i <= 12; $i++){

          $sql = str_replace('_MONTH_', $i, $sql_temp);

           $this->db->query($sql);

        }

      }



        }



        function updateRoomAvailability($roomid,$count){



            $this->db->select('id');

            $this->db->where('room_id',$roomid);

            $rows = $this->db->get('pt_rooms_availabilities')->num_rows();

            if($rows < 1){

              $this->addRoomAvailability($roomid,$count);

            }else{



            $sql = 'UPDATE pt_rooms_availabilities SET ';

      for($day = 1; $day <= 31; $day ++){

        if($day > 1) $sql .= ', ';

        $sql .= 'd'.$day.' = '.$count;

      }

      $sql .= ' WHERE room_id = '.$roomid;

      $this->db->query($sql);



            }





        }



         function deleteRoomAvailability($roomid){



            $this->db->where('room_id',$rooomid);

            $this->db->delete('pt_rooms_availabilities');

        }



         function deleteRoomTranslations($roomid){



            $this->db->where('item_id',$roomid);

            $this->db->delete('pt_rooms_translation');

        }



        // Delete Room

        function deleteRoom($id){



          $this->db->select('rimg_room_id,rimg_image');

          $this->db->where('rimg_room_id',$id);

          $roomimgs = $this->db->get('pt_room_images')->result();



          foreach($roomimgs as $rmimg){



          @unlink(PT_ROOMS_THUMBS_UPLOAD.$rmimg->rimg_image);

          @unlink(PT_ROOMS_IMAGES_UPLOAD.$rmimg->rimg_image);

          $this->db->where('rimg_room_id',$rmimg->rimg_room_id);

          $this->db->delete('pt_room_images');



          }

          $this->deleteRoomPrice($id);

          $this->deleteRoomAvailability($id);

          $this->deleteRoomTranslations($id);



          $this->db->where('room_id',$id);

          $this->db->delete('pt_rooms');



             }

        function getRoomBasicInfo($roomid){

          $this->db->select('room_basic_price,room_adult_price,room_child_price,extra_bed_charges,room_adults,room_children,room_quantity,price_type');

          $this->db->where('room_id',$roomid);

          $rs = $this->db->get('pt_rooms')->result();

          if(!empty($rs)){

            $roomprice['basicprice'] = $rs[0]->room_basic_price;

            $roomprice['room_adult_price'] = $rs[0]->room_adult_price;

            $roomprice['room_child_price'] = $rs[0]->room_child_price;

            $roomprice['price_type'] = $rs[0]->price_type;

            $roomprice['extrabed'] = $rs[0]->extra_bed_charges;

            $roomprice['maxAdults'] = $rs[0]->room_adults;

            $roomprice['maxChild'] = $rs[0]->room_children;

            $roomprice['quantity'] = $rs[0]->room_quantity;

          }else{

            $roomprice['basicprice'] = '0';

            $roomprice['room_adult_price'] = '0';

            $roomprice['room_child_price'] = '0';

            $roomprice['extrabed'] = '0';

            $roomprice['maxAdults'] = '0';

            $roomprice['quantity'] = '0';

          }

          return $roomprice;

        }



        function getRoomPrice($roomid,$checkin,$checkout){
          /*
            $date_from = '2015-06-02';
            $date_to = '2015-06-08';
        */
        
           $checkin =  databaseDate($checkin);
           $checkout = databaseDate($checkout);
          $date_from = $checkin;
          $date_to = $checkout;
           $explodeDfrom = explode("-",$date_from);
          $info = $this->getRoomBasicInfo($roomid);
          $total_price = 0;
          $extrabedcharges = 0;
          $offset = 0;
           $price = array();
           $extrabed = $info['extrabed'];
       while($date_from < $date_to){
         $curr_date_from = $date_from;
   
         $offset++;
         $current = getdate(mktime(0,0,0,$explodeDfrom[1],$explodeDfrom[2]+$offset,$explodeDfrom[0]));
         $date_from = $current['year'].'-'.self::ConvertToDecimal($current['mon']).'-'.self::ConvertToDecimal($current['mday']);
               $curr_date_to = $date_from;
   
   
         $sql = 'SELECT
               r.room_id,
               r.room_quantity,
               r.room_basic_price,
               r.extra_bed,
               r.extra_bed_charges,
               rp.adults,
               rp.children,
               rp.mon,
               rp.tue,
               rp.wed,
               rp.thu,
               rp.fri,
               rp.sat,
               rp.sun,
               rp.sun,
               rp.extra_bed_charge,
               rp.is_default
             FROM pt_rooms r
               INNER JOIN pt_rooms_prices rp ON r.room_id = rp.room_id
             WHERE
               r.room_id = ? AND
               (
                 (rp.date_from <= ? AND rp.date_to = ? ) OR
                 (rp.date_from <= ? AND rp.date_to >= ? )
               )
               AND rp.adults = ? AND rp.children = ?';
   
         $room_info = $this->db->query($sql,array($roomid,$curr_date_from,$curr_date_from,$curr_date_from,$curr_date_to,$this->adults,$this->children));
               $res = $room_info->result();
              if(!empty($res)){
           //  $arr_week_price = $room_info[0];
   
           // calculate total sum, according to week day prices
           $start = strtotime($curr_date_from);
           $end = strtotime($curr_date_to);
           while($start < $end) {
             // take default weekday price if weekday price is empty
                       $day = strtolower(date('D', $start));
             if(empty($res[0]->$day)){
   
                 $room_price = $info['basicprice'];
   
             }else{
   
               $room_price = $res[0]->$day;
   
             }
   
             $total_price += $room_price;
             $extrabedcharges += $res[0]->extra_bed_charge;
                     //   $dates["roomprice"][] = array(date("Y-m-d",$start) => $day);
             $start = strtotime('+1 day', $start);
   
           }
              // $dates[] = array("currentdatefrom" => $curr_date_from, "offset" => $offset, "currentdateto" => $curr_date_to, "roomprice" => $room_price);
               $price[] = $room_price;
               $adults = $res[0]->adults;
               $child = $res[0]->children;
              
         }else{
   
           $room_price = $info['basicprice'];
           $extrabedcharges += $info['extrabed'];
           $total_price += $room_price;
        
           $price[] = $room_price;
           $adults = $info['maxAdults'];
           $child = $info['maxChild'];
   
         }
   
       }

           $stay = count($price);
           $result['roomID'] = $roomid;
           $result['perNight'] = round(array_sum($price) / $stay,2);
           $result['room_adult_price'] = $info['room_adult_price'];
           $result['room_child_price'] = $info['room_child_price'];
           $result['price_type'] = $info['price_type'];
           $result['stay'] = $stay;
           $result['totalPrice'] = $result['perNight'] * $stay;
           $result['checkin'] = $checkin;
           $result['checkout'] = $checkout;
           $result['extrabed'] = $extrabedcharges;
           $result['maxAdults'] =  $adults;//$info['maxAdults'];
           $result['maxChild'] = $child;
           $result['quantity'] = $info['quantity'];
         //  $result['pricebreakdown'] = $price;
           return $result;
   
   
   
    }



    /**

   *  Convert to decimal number with leading zero

   *    @param $number

   */

    private static function ConvertToDecimal($number)

  {

    return (($number < 0) ? '-' : '').((abs($number) < 10) ? '0' : '').abs($number);

  }





}