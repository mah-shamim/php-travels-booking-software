<?php
class Cars_uploads_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('misc_model');
        $this->load->model('Admin/Countries_model');
        $this->load->model('Admin/Accounts_model');
        $this->load->model('Cars/Cars_model');


    }

   // get file extension
 function __getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;

 }


     // upload car default image

	function __car_default($id = null)
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


		if($width > 250){
		$newwidth1 = 250;
		}else{
		$newwidth1 = $width;
		}
		if($height > 150){
		$newheight1 = 150;

		}else{
		$newheight1 = $height;

		}

		$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
        imagealphablending($tmp1, false);
		imagesavealpha($tmp1, true);

		imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


		$savefile = PT_CARS_MAIN_THUMB_UPLOAD.$fig.$filename;

	   	if($extension == "jpg" || $extension == "jpeg")
		{
		imagejpeg($tmp1,$savefile,100);
		}elseif($extension == "png"){
		imagepng($tmp1,$savefile);
		}elseif($extension == "gif"){
		imagegif($tmp1,$savefile);
		}

		imagedestroy($src);
		imagedestroy($tmp1);
		$filename_db = $fig.$filename;

       if(!empty($id)){
        $this->Cars_model->update_car($id);
        $this->Cars_model->update_car_image('default',$filename_db,$id);
         $oldimg = $this->input->post('oldimg');
         if(!empty($oldimg)){

         @unlink(PT_CARS_MAIN_THUMB_UPLOAD.$oldimg);

         }
        $m = "done";

       }else{

        $carid = $this->Cars_model->add_car();
        $this->Cars_model->add_car_image('default',$filename_db,$carid);

        $m = "done";


       }


       }

		}



		return $m;
	}


	/*end __car_default() */


   // upload car Images

	function __car_images()
	{


	$imgtype = $this->input->post('imagetype');
	$carid = $this->input->post('carid');

		foreach($_FILES['files']['tmp_name'] as $key => $tmp_name){
		$fig = rand(1, 999999);
		$uploadedfile = $_FILES['files']['tmp_name'][$key];
		$filename = $_FILES['files']['name'][$key];
		$allowed = array("jpg", "jpeg","png","gif");
		list($width,$height)= getimagesize($uploadedfile);
		$extension = $this->__getExtension($filename);
 		$extension = strtolower($extension);
        $orignalsize =  $_FILES['files']['size'][$key];
		$size = $_FILES['files']['size'][$key]/1024;  // converted to KB
		$imgsize = round($size,2);

		//else for if 1
		if($imgsize > 2050) //if 2
		{
		     $js = array( "files" => array(
    array("error" => "size must be less than 2 MB")

    )

    );
        return json_encode($js);


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

    	if($width > 720){
		$newwidth1 = 720;
		}else{
		$newwidth1 = $width;
		}
		if($height > 480){
		$newheight1 = 480;

		}else{
		$newheight1 = $height;

		}


		$tmp=imagecreatetruecolor($newwidth1,$newheight1);



		$tmp1=imagecreatetruecolor($width,$height);

		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
		imagecopyresampled($tmp1,$src,0,0,0,0,$width,$height,$width,$height);


        if($imgtype == "slider"){
         $savethumb = PT_CARS_SLIDER_THUMB_UPLOAD.$fig.$filename;
		$savefile = PT_CARS_SLIDER_UPLOAD.$fig.$filename;

        }elseif($imgtype == "interior"){
         $savethumb = PT_CARS_INTERIOR_THUMB_UPLOAD.$fig.$filename;
		$savefile = PT_CARS_INTERIOR_UPLOAD.$fig.$filename;

        }elseif($imgtype == "exterior"){
         $savethumb = PT_CARS_EXTERIOR_THUMB_UPLOAD.$fig.$filename;
		$savefile = PT_CARS_EXTERIOR_UPLOAD.$fig.$filename;

        }


  if($extension == "gif"){

     imagegif($tmp,$savethumb);
		imagegif($tmp1,$savefile);

}elseif($extension == "jpg" || $extension == "jpeg"){

      imagejpeg($tmp,$savethumb,100);
		imagejpeg($tmp1,$savefile,100);

}elseif($extension == "png"){

   imagepng($tmp,$savethumb);
   imagepng($tmp1,$savefile);

}

      // Applying Watermark
        $wmdata = $this->Settings_model->get_watermark_data();

        if($wmdata[0]->wm_status == '1'){
          if($wmdata[0]->wm_type == "img"){
            $watermark_imgpath = PT_GLOBAL_IMAGES_FOLDER.$wmdata[0]->wm_image;
$this->image_watermark($savefile,$savefile,$watermark_imgpath,$wmdata[0]->wm_position);

          }else{

 $this->text_watermark($savefile, $savefile,$wmdata[0]->wm_font_color,$wmdata[0]->wm_font_size,$wmdata[0]->wm_text);

          }


        }else{

        }

          // end Applying Watermark

		imagedestroy($src);
		imagedestroy($tmp);
		imagedestroy($tmp1);

         $this->Cars_model->add_car_image($imgtype,$fig.$filename,$carid);

             if($imgtype == "slider"){

         $thumburl = PT_CARS_SLIDER_THUMB.$fig.$filename;
           $imgurls = PT_CARS_SLIDER.$fig.$filename;
           $delimg = base_url()."cars/carsback/deleteimg/".$fig.$filename."/".$imgtype;


           }

   $js = array( "files" => array(
    array("thumbnailUrl" => $thumburl, "name" => $fig.$filename, "size" => $orignalsize, "url" => $imgurls, "deleteUrl" => $delimg, "deleteType" => "DELETE"  )

    )

    );
      return json_encode($js);

        }




       }




    }


	/*end __car_images() */

}