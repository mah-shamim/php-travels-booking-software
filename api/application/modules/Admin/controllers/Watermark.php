<?php
if (!defined('BASEPATH'))
		exit ('No direct script access allowed');

class Watermark extends MX_Controller {

	function apply($source_file_path){

			if(!empty($source_file_path)){

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

    }

		

}