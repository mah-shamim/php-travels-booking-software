<?php

class Extras_model extends CI_Model {
		public $langdef;

		function __construct() {
// Call the Model constructor
				parent :: __construct();
				$this->langdef = DEFLANG;
		}

		function add_supplement($filename = null) {
				$forever = $this->input->post('foreverfeatured');
				if ($forever == "forever") {
						$ffrom = date('Y-m-d');
						$fto = date('Y-m-d', strtotime('+1 years'));
						$isforever = 'forever';
				}
				else {
						$ffrom = $this->input->post('ffrom');
						$fto = $this->input->post('fto');
						$isforever = '';
				}
				$suppforid = $this->input->post('extras_for_id');
				$suppmodule = $this->input->post('suppfor');
				$addsuppsid = implode(",", $suppforid);
				$data = array('extras_title' => $this->input->post('suppname'), 'extras_desc' => $this->input->post('suppdesc'), 'extras_module' => $suppmodule, 'extras_for' => $addsuppsid, 'extras_from' => convert_to_unix($ffrom), 'extras_to' => convert_to_unix($fto), 'extras_basic_price' => $this->input->post('basicprice'), 'extras_discount' => $this->input->post('discountprice'), 'extras_added_on' => time(), 'extras_image' => $filename, 'extras_status' => $this->input->post('suppstatus'), 'extras_forever' => $isforever);
				$this->db->insert('pt_extras', $data);
		}

//udpate extras
		function update_extras($id) {

				/*$forever = $this->input->post('foreverfeatured');
				if ($forever == "forever") {
						$ffrom = date('Y-m-d');
						$fto = date('Y-m-d', strtotime('+1 years'));
						$isforever = 'forever';
				}
				else {
						$ffrom = $this->input->post('ffrom');
						$fto = $this->input->post('fto');
						$isforever = '';
				}*/
				$itemsid = $this->input->post('items');
				$otheritems = $this->input->post('otheritems');
				$extrasid = implode(",", $itemsid);

				if(!empty($otheritems)){	

				if(!empty($extrasid)){
				$extrasid = $extrasid.",".$otheritems;		
				}else{
				$extrasid = $otheritems;	
				}				
				
				}

		
			   //	$data = array('extras_for' => $addsuppsid, 'extras_from' => convert_to_unix($ffrom), 'extras_to' => convert_to_unix($fto), 'extras_basic_price' => $this->input->post('basicprice'), 'extras_discount' => $this->input->post('discountprice'), 'extras_image' => $filename, 'extras_status' => $this->input->post('suppstatus'), 'extras_forever' => $isforever);
				$data = array('extras_for' => $extrasid);
				$this->db->where('extras_id', $id);
				$this->db->update('pt_extras', $data);
		}

// add supplement photo
		function extras_photo($id = null) {
				$m = '';
				$fig = rand(1, 999999);
				$uploadedfile = $_FILES['defaultphoto']['tmp_name'];
				$filename = $_FILES['defaultphoto']['name'];
				$allowed = array("jpg", "jpeg", "png", "gif");
				list($width, $height) = getimagesize($uploadedfile);
				$extension = $this->__getExtension($filename);
				$extension = strtolower($extension);
				$size = $_FILES['defaultphoto']['size'] / 1024; // converted to KB
				$imgsize = round($size, 2);
				if (!in_array($extension, $allowed))//if 1
						{
						$m = "<font color='red'>Invalid file type kindly select only jpg/jpeg, png, gif file types.</font>";
// $m = "1";
//end if 1
				}
				else {
//else for if 1
						if ($imgsize > MAX_IMAGE_UPLOAD) //if 2
								{
								$uperror = round(MAX_IMAGE_UPLOAD / 1024, 2);
								$m = "<font color='red'> Only upto " . $uperror . "MB size photos allowed.</font>";
//$m = "2";
						}
						else {
								$filename = str_replace(" ", "-", $filename);
								if (strlen($filename) > 15) {
										$filename = substr($filename, 0, 10);
								}
								$filename = $filename . "." . $extension;
								if ($extension == "jpg" || $extension == "jpeg") {
										$src = imagecreatefromjpeg($uploadedfile);
								}
								elseif ($extension == "png") {
										$src = imagecreatefrompng($uploadedfile);
								}
								elseif ($extension == "gif") {
										$src = imagecreatefromgif($uploadedfile);
								}
								$tmp = imagecreatetruecolor($width, $height);
								imagealphablending($tmp, false);
								imagesavealpha($tmp, true);
								imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);
								$savefilebig = PT_extras_IMAGES_UPLOAD . $fig . $filename;
								if ($extension == "jpg" || $extension == "jpeg") {
										imagejpeg($tmp, $savefilebig, 100);
								}
								elseif ($extension == "png") {
										imagepng($tmp, $savefilebig);
								}
								elseif ($extension == "gif") {
										imagegif($tmp, $savefilebig);
								}
								imagedestroy($src);
								imagedestroy($tmp);
								$filename_db = $fig . $filename;
								if (!empty ($id)) {
										$this->update_supplement($id, $filename_db);
										$oldimg = $this->input->post('defimg');
										if (!empty ($oldimg)) {
												@ unlink(PT_extras_IMAGES_UPLOAD . $oldimg);
										}
										$m = "done";
								}
								else {
										$this->add_supplement($filename_db);
										$m = "done";
								}
						}
				}
				return $m;
		}

/*end add_supplement() */
// get all extras
		function get_all_extras() {
				$this->db->order_by('extras_id', 'desc');
				return $this->db->get('pt_extras')->result();
		}

// get all data of single Supplement
		function get_extras_data($id) {
				$this->db->where('extras_id', $id);
				return $this->db->get('pt_extras')->result();
		}
// Disable Supplement

		public function disable_supp($id) {
				$data = array('extras_status' => '0');
				$this->db->where('extras_id', $id);
				$this->db->update('pt_extras', $data);
		}
// Enable Supplement

		public function enable_supp($id) {
				$data = array('extras_status' => '1');
				$this->db->where('extras_id', $id);
				$this->db->update('pt_extras', $data);
		}

		function deleteExtra($id) {
				$this->db->select('extras_image');
				$this->db->where('extras_id', $id);
				$suppimgs = $this->db->get('pt_extras')->result();
				if (!empty ($suppimgs)) {
						@ unlink(PT_EXTRAS_IMAGES_UPLOAD . $suppimgs[0]->extras_image);
				}
				$this->db->where('extras_id', $id);
				$this->db->delete('pt_extras');
		}

// get file extension
		function __getExtension($str) {
				$i = strrpos($str, ".");
				if (!$i) {
						return "";
				}
				$l = strlen($str) - $i;
				$ext = substr($str, $i + 1, $l);
				return $ext;
		}

// get short data of single supplement
		function extras_short_data($id) {
				$this->db->select('extras_title,extras_desc');
				$this->db->where('extras_id', $id);
				return $this->db->get('pt_extras')->result();
		}

// get short translated data of single supplement
		function extras_translated_data($lang, $id) {
				$this->db->where('trans_extras_id', $id);
				$this->db->where('trans_lang', $lang);
				return $this->db->get('pt_extras_translation')->result();
		}

// Adds translation of some fields data
		function add_translation($suppid, $language) {
				$title = $this->input->post('title');
				$desc = $this->input->post('desc');
				$data = array('trans_title' => $title, 'trans_desc' => $desc, 'trans_extras_id' => $suppid, 'trans_lang' => $language,);
				$this->db->insert('pt_extras_translation', $data);
				$this->session->set_flashdata('flashmsgs', 'Changes Saved');
		}


        // Update translation of some fields data
		function update_translation($postdata,$id) {

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];

                $transAvailable = $this->getBackTranslation($lang,$id);

                if(empty($transAvailable)){
                   $data = array(
                'trans_title' => $title,
                'trans_extras_id' => $id,
                'trans_lang' => $lang

                );
				$this->db->insert('pt_extras_translation', $data);

                }else{

                $data = array(
                'trans_title' => $title,
                );
				$this->db->where('trans_extras_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_extras_translation', $data);

                }


              }

                }
		}



		function getBackTranslation($lang, $id) {
				$this->db->where('trans_lang', $lang);
				$this->db->where('trans_extras_id', $id);
				return $this->db->get('pt_extras_translation')->result();
		}

}