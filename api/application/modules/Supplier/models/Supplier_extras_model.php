<?php
class Supplier_extras_model extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function add_supplement($filename = null){

          $forever = $this->input->post('foreverfeatured');
        if($forever == "forever"){
            $ffrom = date('Y-m-d');
            $fto = date('Y-m-d', strtotime('+1 years'));
             $isforever = 'forever';
         }else{

          $ffrom = $this->input->post('ffrom');
          $fto = $this->input->post('fto');
           $isforever = '';
         }

         $suppforid = $this->input->post('extras_for_id');
         $suppmodule = $this->input->post('suppfor');

         $addsuppsid = implode(",",$suppforid);


   $data = array(
            'extras_title' => $this->input->post('suppname'),
            'extras_desc' => $this->input->post('suppdesc'),
            'extras_module' => $suppmodule,
            'extras_for' => $addsuppsid,
            'extras_from' => convert_to_unix($ffrom),
            'extras_to' => convert_to_unix($fto),
            'extras_basic_price' => $this->input->post('basicprice'),
            'extras_discount' => $this->input->post('discountprice'),
            'extras_added_on' => time(),
            'extras_image' => $filename,
            'extras_status' => $this->input->post('suppstatus'),
            'extras_forever' => $isforever

   );

   $this->db->insert('pt_extras',$data);


    }
      // udpate supplement
     function update_supplement($id,$filename = null){

          if(empty($filename)){

          $filename = $this->input->post('defimg');

          }
          $forever = $this->input->post('foreverfeatured');
        if($forever == "forever"){
            $ffrom = date('Y-m-d');
            $fto = date('Y-m-d', strtotime('+1 years'));
            $isforever = 'forever';
         }else{

          $ffrom = $this->input->post('ffrom');
          $fto = $this->input->post('fto');
          $isforever = '';
         }
         $suppforid = $this->input->post('extras_for_id');
         $suppmodule = $this->input->post('suppfor');

         $addsuppsid = implode(",",$suppforid);



   $data = array(
            'extras_title' => $this->input->post('suppname'),
            'extras_desc' => $this->input->post('suppdesc'),
            'extras_module' => $suppmodule,
            'extras_for' => $addsuppsid,
            'extras_from' => convert_to_unix($ffrom),
            'extras_to' => convert_to_unix($fto),
            'extras_basic_price' => $this->input->post('basicprice'),
            'extras_discount' => $this->input->post('discountprice'),
            'extras_image' => $filename,
            'extras_status' => $this->input->post('suppstatus'),
            'extras_forever' => $isforever

   );

   $this->db->where('extras_id',$id);
   $this->db->update('pt_extras',$data);


    }


     // add supplement photo

	function extras_photo($id = null)
	{

		$m = '';
		$fig = rand(1, 999999);
		$uploadedfile = $_FILES['defaultphoto']['tmp_name'];
		$filename = $_FILES['defaultphoto']['name'];
		$allowed = array("jpg", "jpeg","png","gif");
		list($width,$height)= getimagesize($uploadedfile);
		$extension = $this->__getExtension($filename);
 		$extension = strtolower($extension);
		$size = $_FILES['defaultphoto']['size']/1024;  // converted to KB
		$imgsize = round($size,2);
		if(!in_array($extension, $allowed))//if 1
		{
		$m = "<font color='red'>Invalid file type kindly select only jpg/jpeg, png, gif file types.</font>";
       // $m = "1";
		//end if 1
		}else{
		//else for if 1
		if($imgsize > MAX_IMAGE_UPLOAD) //if 2
		{

	  	    $uperror = round(MAX_IMAGE_UPLOAD/1024,2);
		$m = "<font color='red'> Only upto ".$uperror."MB size photos allowed.</font>";
        //$m = "2";
		}else{

		$filename = str_replace(" ","-",$filename);
		if(strlen($filename) > 15)
		{

		$filename = substr($filename,0,10);

		}
		$filename = $filename.".".$extension;
		if($extension == "jpg" || $extension == "jpeg")
		{
		$src = imagecreatefromjpeg($uploadedfile);

		}elseif($extension == "png"){

		$src = imagecreatefrompng($uploadedfile);

		}elseif($extension == "gif"){

		$src = imagecreatefromgif($uploadedfile);

		}


      	$tmp = imagecreatetruecolor($width,$height);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);

        imagecopyresampled($tmp,$src,0,0,0,0,$width,$height,$width,$height);


        $savefilebig = PT_extras_IMAGES_UPLOAD.$fig.$filename;

        if($extension == "jpg" || $extension == "jpeg")
		{
   		imagejpeg($tmp,$savefilebig,100);
		}elseif($extension == "png"){

		imagepng($tmp,$savefilebig);
		}elseif($extension == "gif"){

		imagegif($tmp,$savefilebig);
		}

		imagedestroy($src);
		imagedestroy($tmp);

    	$filename_db = $fig.$filename;

       if(!empty($id)){

        $this->update_supplement($id,$filename_db);

         $oldimg = $this->input->post('defimg');
         if(!empty($oldimg)){

         @unlink(PT_extras_IMAGES_UPLOAD.$oldimg);


         }
        $m = "done";



       }else{

        $this->add_supplement($filename_db);

        $m = "done";


       }


       }

		}



		return $m;
	}


	/*end add_supplement() */


    // get all extras of user
    function get_all_extras($userid){
           $ids = array();
           $this->db->select('hotel_id');
           $this->db->where('hotel_owned_by',$userid);
           $rs = $this->db->get('pt_hotels')->result();
           foreach($rs as $r){
             array_push($ids,$r->hotel_id);
           }
           if(!empty($ids)){
             foreach($ids as $id){
           $this->db->or_like('extras_for', $id, 'both');
             }

           }

           $this->db->order_by('extras_id','desc');
    return $this->db->get('pt_extras')->result();

    }


     // is my supplement
    function my_extras($userid){
           $ids = array();
           $sups = array();
           $this->db->select('hotel_id');
           $this->db->where('hotel_owned_by',$userid);
           $rs = $this->db->get('pt_hotels')->result();
           foreach($rs as $r){
             array_push($ids,$r->hotel_id);
           }
           $this->db->select('extras_id');
           if(!empty($ids)){
             foreach($ids as $id){
           $this->db->or_like('extras_for', $id, 'both');
             }

           }

           $this->db->order_by('extras_id','desc');
    $supres = $this->db->get('pt_extras')->result();

    if(!empty($supres)){
    foreach($supres as $sup){
      array_push($sups,$sup->extras_id);
      }
    }

     return $sups;
    }




    // get all data of single Supplement
    function get_extras_data($id){

    $this->db->where('extras_id',$id);

    return $this->db->get('pt_extras')->result();


    }



    // Disable Supplement

    public function disable_supp($id){

    $data = array(
       'extras_status' => '0'
    );

    $this->db->where('extras_id',$id);
    $this->db->update('pt_extras',$data);



    }

    // Enable Supplement

    public function enable_supp($id){

    $data = array(
       'extras_status' => '1'
    );

    $this->db->where('extras_id',$id);
    $this->db->update('pt_extras',$data);



    }


   function delete_supp($id){

   $this->db->select('extras_image');
  $this->db->where('extras_id',$id);
  $suppimgs = $this->db->get('pt_extras')->result();

   if(!empty($suppimgs)){

    @unlink(PT_extras_IMAGES_UPLOAD.$suppimgs[0]->extras_image);



   }



  $this->db->where('extras_id',$id);
  $this->db->delete('pt_extras');

   }



   // get file extension
 function __getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;

 }


}