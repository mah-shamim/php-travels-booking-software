<?php
class Uploads_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('misc_model');
        $this->load->model('countries_model');
        $this->load->model('accounts_model');

    }

   // get file extension
 function __getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;

 }


  // upload header logo, footer logo and favicon

	function __fav_and_logo($type){
    
		$m = '';
		$fig = rand(1, 999999);
        if($type == "flogo"){
        $uploadedfile = $_FILES['flogo']['tmp_name'];
		$filename = $_FILES['flogo']['name'];
        $size = $_FILES['flogo']['size']/1024;

        }elseif($type == "hlogo"){
         $uploadedfile = $_FILES['hlogo']['tmp_name'];
		$filename = $_FILES['hlogo']['name'];
        $size = $_FILES['hlogo']['size']/1024;  // converted to KB
        }elseif($type == "favimg"){
        $uploadedfile = $_FILES['favimg']['tmp_name'];
 		$filename = $_FILES['favimg']['name'];
        $size = $_FILES['favimg']['size']/1024;  // converted to KB
        }elseif($type == "wmimg"){
         $uploadedfile = $_FILES['wmimg']['tmp_name'];
		$filename = $_FILES['wmimg']['name'];
        $size = $_FILES['wmimg']['size']/1024;  // converted to KB
        }

    	//$allowed = array("jpg", "jpeg","png","gif");
    	$allowed = array("png");
		list($width,$height)= getimagesize($uploadedfile);
		$extension = $this->__getExtension($filename);
 		$extension = strtolower($extension);

		$imgsize = round($size,2);
		if(!in_array($extension, $allowed))//if 1
		{
		$m = "<font color='red'>Invalid file type kindly select only  png file type.</font>";
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

        if($type == "flogo"){
        $filename = "footer-logo.".$extension;

        }elseif($type == "hlogo"){

        $filename = "logo.".$extension;

        }elseif($type == "favimg"){

        $filename = "favicon.".$extension;
        }elseif($type == "wmimg"){

        $filename = "watermark.".$extension;
        }



		if($extension == "jpg" || $extension == "jpeg")
		{
		$src = imagecreatefromjpeg($uploadedfile);

		}elseif($extension == "png"){

		$src = imagecreatefrompng($uploadedfile);

		}elseif($extension == "gif"){

		$src = imagecreatefromgif($uploadedfile);

		}


 /*		if($width > 250){
		$newwidth1 = 250;
		}else{
		$newwidth1 = $width;
		}
		if($height > 250){
		$newheight1 = 250;

		}else{
		$newheight1 = $height;

		}*/

		$tmp1=imagecreatetruecolor($width,$height);
        imagealphablending($tmp1, false);
		imagesavealpha($tmp1, true);

		imagecopyresampled($tmp1,$src,0,0,0,0,$width,$height,$width,$height);


		$savefile = PT_GLOBAL_UPLOADS_FOLDER.$filename;

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
	   //	$filename_db = $fig.$filename;

      if($type == "wmimg"){


      }else{
      $this->Settings_model->update_logos($type,$filename);

      }



		$e = '<font color="green">Updated Successfully.</font>';
        $m = "success";
		}

		}



		return $m;
	}


	/*end __fav_and_logo() */

 // upload profile picture

	function __profileimg($id = null)
	{

		$m = '';
		$fig = rand(1, 999999);
		$uploadedfile = $_FILES['photo']['tmp_name'];
		$filename = $_FILES['photo']['name'];

    	$allowed = array("jpg", "jpeg","png","gif");
		list($width,$height)= getimagesize($uploadedfile);
		$extension = $this->__getExtension($filename);
 		$extension = strtolower($extension);
		$size = $_FILES['photo']['size']/1024;  // converted to KB
		$imgsize = round($size,2);
		if(!in_array($extension, $allowed))//if 1
		{
		$e = "<font color='red'>Invalid file type kindly select only jpg/jpeg, png, gif file types.</font>";
        $m = "1";
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


		if($width > 150){
		$newwidth1 = 150;
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


		$savefile = PT_USERS_IMAGES_UPLOAD.$fig.$filename;

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
        if($id == null){
            	$this->Accounts_model->add_account($filename_db);

        }else{

          	$this->Accounts_model->update_profile('',$id,$filename_db);

        }

		$e = '<font color="green">Updated Successfully.</font>';
        $m = "3";
		}

		}



		return $m;
	}


	/*end __profileimg() */

    // upload Social Icon

	function __socialimg($id = null)
	{

		$m = '';
		$fig = rand(1, 999999);
		$uploadedfile = $_FILES['photo']['tmp_name'];
		$filename = $_FILES['photo']['name'];
		$allowed = array("jpg", "jpeg","png","gif");
		list($width,$height)= getimagesize($uploadedfile);
		$extension = $this->__getExtension($filename);
 		$extension = strtolower($extension);
		$size = $_FILES['photo']['size']/1024;  // converted to KB
		$imgsize = round($size,2);
		if(!in_array($extension, $allowed))//if 1
		{
		$m = "<font color='red'>Invalid file type kindly select only jpg/jpeg, png, gif file types.</font>";
        //$m = "1";
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


		if($width > 150){
		$newwidth1 = 150;
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


		$savefile = PT_SOCIAL_IMAGES_UPLOAD.$fig.$filename;

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

                if($id == null){

       	$this->Misc_model->addsocial($filename_db);


        }else{

         $this->Misc_model->update_social($id,$filename_db);
        }



        $m = "done";
		}

		}



		return $m;
	}


	/*end __socialimg() */


     // upload Slider Image

	function __sliderimg($id = null)
	{

		$m = '';
		$fig = rand(1, 999999);
		$uploadedfile = $_FILES['photo']['tmp_name'];
		$filename = $_FILES['photo']['name'];
		$allowed = array("jpg", "jpeg","png","gif");
		list($width,$height)= getimagesize($uploadedfile);
		$extension = $this->__getExtension($filename);
 		$extension = strtolower($extension);
		$size = $_FILES['photo']['size']/1024;  // converted to KB
		$imgsize = round($size,2);
		if(!in_array($extension, $allowed))//if 1
		{
		$m = "<font color='red'>Invalid file type kindly select only jpg/jpeg, png, gif file types.</font>";
        //$m = "1";
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


       $newwidth= 100;
       $newheight= 100;

       $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagealphablending($tmp, false);
		imagesavealpha($tmp, true);

		$tmp1=imagecreatetruecolor($width,$height);
        imagealphablending($tmp1, false);
		imagesavealpha($tmp1, true);

		imagecopyresampled($tmp1,$src,0,0,0,0,$width,$height,$width,$height);
	    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);


       $savethumb = PT_SLIDER_IMAGES_UPLOAD_THUMBS.$fig.$filename;
		$savefile = PT_SLIDER_IMAGES_UPLOAD.$fig.$filename;

	   	if($extension == "jpg" || $extension == "jpeg")
		{
		imagejpeg($tmp1,$savefile,100);
		}elseif($extension == "png"){
		imagepng($tmp1,$savefile);
		}elseif($extension == "gif"){
		imagegif($tmp1,$savefile);
		}

     	if($extension == "jpg" || $extension == "jpeg")
		{
		imagejpeg($tmp,$savethumb,100);
		}elseif($extension == "png"){
		imagepng($tmp,$savethumb);
		}elseif($extension == "gif"){
		imagegif($tmp,$savethumb);
		}

		imagedestroy($src);
		imagedestroy($tmp1);
		imagedestroy($tmp);

		$filename_db = $fig.$filename;
        if($id == null){

        $this->Misc_model->addslide($filename_db);


        }else{

         $this->Misc_model->updateslider_data($id,$filename_db);
        }


		$e = '<font color="green">Updated Successfully.</font>';
        $m = "done";
		}

		}



		return $m;
	}


	/*end __sliderimg() */

    // Upload sql file
    function __uploadsql(){

     if(isset($_FILES['datasqlfile'])){
    $errors= array();
    $file_name = $_FILES['datasqlfile']['name'];
    $file_size =$_FILES['datasqlfile']['size'];
    $file_tmp =$_FILES['datasqlfile']['tmp_name'];
    $file_type=$_FILES['datasqlfile']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['datasqlfile']['name'])));
    $extensions = array("sql");
    if(in_array($file_ext,$extensions )=== false){
    $errors['done'] = false;
    $errors['msg']=$file_type;//"extension not allowed, please choose a SQL file.";
    }else{
    //move_uploaded_file($file_tmp,PT_SQL_UPLOAD.$file_name);
    $errors['done'] = true;
    $errors['msg']= $file_type;//"File uploaded successfully.";
    }
  return $errors;

}

    }

    // Upload sql file
    function __sqlUpload(){

     if(isset($_FILES['datasqlfile'])){

		$config['upload_path'] = PT_SQL_UPLOAD;
		$config['allowed_types'] = '*';


		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('datasqlfile'))
		{
			
			$errors['done'] = false;
  			$errors['msg']= $this->upload->display_errors();
		}
		else
		{
			$dataUpload = $this->upload->data();

			$filename = $dataUpload['file_name'];
			$fullPath = $dataUpload['full_path'];
			$fileExt = $dataUpload['file_ext'];

			$find   = '.php';
			$pos = strpos($filename, $find);

			if ($pos === false && $fileExt == ".sql") {

			$errors['done'] = true;
			$errors['msg'] = "File uploaded successfully.";
			
			} else {

			$errors['done'] = false;
			$errors['msg'] = "File type Not allowed.";
			unlink(PT_SQL_UPLOAD.$filename);

			}

			
			

			
		}

/*    $errors= array();
    $file_name = $_FILES['datasqlfile']['name'];
    $file_size =$_FILES['datasqlfile']['size'];
    $file_tmp =$_FILES['datasqlfile']['tmp_name'];
    $file_type=$_FILES['datasqlfile']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['datasqlfile']['name'])));
    $extensions = array("sql");
    if(in_array($file_ext,$extensions )=== false){
    $errors['done'] = false;
    $errors['msg']="extension not allowed, please choose a SQL file.";
    }else{
    move_uploaded_file($file_tmp,PT_SQL_UPLOAD.$file_name);
    $errors['done'] = true;
    $errors['msg']= "File uploaded successfully.";
    }

    */

  return $errors;

}

    }



/************* Watermark functions *******************/
/****************************************************/


// watermark text only

function text_watermark($oldimage_name, $new_image_name,$hex,$font_size,$water_mark_text)
{

$font_path = "assets/fonts/watermark/arial.ttf"; // Font file


list($width,$height) = getimagesize($oldimage_name);
//$width = $height = 300;
$image = imagecreatetruecolor($width, $height);

   $x = imagesx($image);
    $y = imagesy($image);

   $dx = 10;
   $dy = $y - 20;


$filetype = substr($oldimage_name,strlen($oldimage_name)-4,4);
$filetype = strtolower($filetype);
if($filetype == ".gif") $image_src = @imagecreatefromgif($oldimage_name);
if($filetype == ".jpg") $image_src = @imagecreatefromjpeg($oldimage_name);
if($filetype == ".png") $image_src = @imagecreatefrompng($oldimage_name);
if (!$image) die();



imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $width, $height);

  $a = hexdec(substr($hex,0,2));
  $b = hexdec(substr($hex,2,2));
  $c = hexdec(substr($hex,4,2));
   $txtcolor = imagecolorallocate($image, $a, $b, $c);



imagettftext($image, $font_size, 0, $dx, $dy, $txtcolor, $font_path, $water_mark_text);

if($filetype == ".gif"){
  imagegif($image,$new_image_name);

}elseif($filetype == ".jpg"){
 imagejpeg($image, $new_image_name, 100);

}elseif($filetype == ".png"){

   imagepng($image,$new_image_name);

}




imagedestroy($image);
imagedestroy($image_src);

return true;


}





// image water mark

function image_watermark($source_file_path){


$this->db->where('wm_name', 'wmark');
$wmResult = $this->db->get('pt_watermark')->result();


$watermark_imgpath = "uploads/global/watermark.png";

$p = $wmResult[0]->wm_position;

if($wmResult[0]->wm_status == 1){

/* $source_file_path ="uploads/img.png";
 $output_file_path ="uploads/img.png";
*/

$output_file_path = $source_file_path;

list($source_width, $source_height, $source_type) = getimagesize($source_file_path);
 if ($source_type === NULL) {
 return false;
 }
 switch ($source_type) {
 case IMAGETYPE_GIF:
 $source_gd_image = imagecreatefromgif($source_file_path);
 break;
 case IMAGETYPE_JPEG:
 $source_gd_image = imagecreatefromjpeg($source_file_path);
 break;
 case IMAGETYPE_PNG:
 $source_gd_image = imagecreatefrompng($source_file_path);
 break;
 default:
 return false;
 }
 $overlay_gd_image = imagecreatefrompng($watermark_imgpath);


 //getting the image size for the original image
$img_w = imagesx($source_gd_image);
$img_h = imagesy($source_gd_image);


 $w_w = imagesx($overlay_gd_image);
 $w_h = imagesy($overlay_gd_image);




if($p == "tl") {
    $dest_x = 20;
    $dest_y = 10;
} elseif ($p == "tc") {
    $dest_x = ($img_w - $w_w)/2;
    $dest_y = 10;
} elseif ($p == "tr") {
    $dest_x = $img_w - $w_w;
    $dest_y = 10;
} elseif ($p == "cl") {
    $dest_x = 0;
    $dest_y = ($img_h - $w_h)/2;
} elseif ($p == "c") {
    $dest_x = ($img_w - $w_w)/2;
    $dest_y = ($img_h - $w_h)/2;
} elseif ($p == "cr") {
    $dest_x = $img_w - $w_w;
    $dest_y = ($img_h - $w_h)/2;
} elseif ($p == "bl") {
    $dest_x = 20;
    $dest_y = $img_h - $w_h - 20;
} elseif ($p == "bc") {
    $dest_x = ($img_w - $w_w)/2;
    $dest_y = $img_h - $w_h - 20;
} elseif ($p == "br") {
    $dest_x = $img_w - $w_w - 20;
    $dest_y = $img_h - $w_h - 20;
}

 imagecopy($source_gd_image, $overlay_gd_image, $dest_x, $dest_y, 0, 0, $w_w, $w_h);


 imagepng($source_gd_image, $output_file_path);
 imagedestroy($source_gd_image);
 imagedestroy($overlay_gd_image);

}

  }


/************* End Watermark functions *******************/
/****************************************************/


}