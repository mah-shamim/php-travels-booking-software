<?php

class Special_offers_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

        function get_offer_data($slug){
          $this->db->where('offer_slug',$slug);
          return $this->db->get('pt_special_offers')->result();
        }

        function makeSlug($title,$offerlastid = null){
                        $slug = create_url_slug($title);
                        $this->db->select("offer_id");
						$this->db->where("offer_slug", $slug);
                        if(!empty($offerlastid)){
                         $this->db->where('offer_id !=',$offerlastid);
                        }
						$queryc = $this->db->get('pt_special_offers')->num_rows();
						if ($queryc > 0) {
								$slug = $slug."-".$offerlastid;
						}
                        return $slug;
    }

// add offer
		function add_offer(){
                $this->db->select("offer_id");
				$this->db->order_by("offer_id", "desc");
				$query = $this->db->get('pt_special_offers');
				$lastid = $query->result();
				$count = $query->num_rows();
				if (empty ($lastid)) {
						$offerlastid = 1;
						$order = 1;
				}
				else {
						$offerlastid = $lastid[0]->offer_id + 1;
						$order = $count + 1;
				}


               $offerslug = $this->makeSlug($this->input->post('offertitle'),$offerlastid);
			   $spfrom = $this->input->post('ofrom');
			   $spto = $this->input->post('oto');
				if (!empty($spfrom) || !empty($spto)) {
		 			$isforever = '';
				}else{

				    $isforever = 'forever';
				}

				$data = array(
                'offer_title' => $this->input->post('offertitle'),
                'offer_desc' => $this->input->post('offerdesc'),
                'offer_price' => $this->input->post('offerprice'),
                'offer_from' => convert_to_unix($spfrom),
                'offer_to' => convert_to_unix($spto),
                'offer_forever' => $isforever,
                'offer_slug' => $offerslug,
                'offer_order' => $order,
                'offer_phone' => $this->input->post('offerphone'),
                'offer_email' => $this->input->post('offeremail'),
                'offer_status' => $this->input->post('offerstatus')
                );
				$this->db->insert('pt_special_offers', $data);
                $offerid = $this->db->insert_id();
                $this->update_translation($this->input->post('translated'), $offerid);
		}

//udpate Special Offer
		function update_offer($id) {

               $offerslug = $this->makeSlug($this->input->post('offertitle'),$id);
			   $spfrom = $this->input->post('ofrom');
			   $spto = $this->input->post('oto');
				if (!empty($spfrom) || !empty($spto)) {
		 			$isforever = '';
				}else{

				    $isforever = 'forever';
				}

				$data = array(
                'offer_title' => $this->input->post('offertitle'),
                'offer_desc' => $this->input->post('offerdesc'),
                'offer_price' => $this->input->post('offerprice'),
                'offer_from' => convert_to_unix($spfrom),
                'offer_to' => convert_to_unix($spto),
                'offer_forever' => $isforever,
                'offer_slug' => $offerslug,
                'offer_phone' => $this->input->post('offerphone'),
                'offer_email' => $this->input->post('offeremail'),
                'offer_status' => $this->input->post('offerstatus')
                );
				$this->db->where('offer_id', $id);
				$this->db->update('pt_special_offers', $data);
                $this->update_translation($this->input->post('translated'), $id);

                }

// Remove From special offers
		function remove_from_specialoffer($id) {
				$this->db->where('offer_id', $id);
				$this->db->delete('pt_special_offers');
		}

/*end add_supplement() */
// get all extras
		function get_all_extras() {
				$this->db->order_by('extras_id', 'desc');
				return $this->db->get('pt_extras')->result();
		}
// Disable Offer

		public function disable_offer($id) {
				$data = array('offer_status' => '0');
				$this->db->where('offer_id', $id);
				$this->db->update('pt_special_offers', $data);
		}
// Enable Offer

		public function enable_offer($id) {
				$data = array('offer_status' => '1');
				$this->db->where('offer_id', $id);
				$this->db->update('pt_special_offers', $data);
		}

		function delete_supp($id) {
				$this->db->select('extras_image');
				$this->db->where('extras_id', $id);
				$suppimgs = $this->db->get('pt_extras')->result();
				if (!empty ($suppimgs)) {
						@ unlink(PT_EXTRAS_IMAGES_UPLOAD . $suppimgs[0]->extras_image);
				}
				$this->db->where('extras_id', $id);
				$this->db->delete('pt_extras');
		}

		function get_special_offers_front() {
				$result = array();
				$modules = $this->ptmodules->get_enabled_modules();
				$this->db->where('pt_special_offers.offer_from <=', time());
				$this->db->where('pt_special_offers.offer_to >=', time());
				$this->db->where_in('pt_special_offers.offer_module', $modules);
				$this->db->where('pt_special_offers.offer_status', '1');
				$this->db->order_by('pt_special_offers.offer_id', 'desc');
				$resultingquery = $this->db->get('pt_special_offers', $perpage, $offset);
				$chkinghotels = $this->ptmodules->is_mod_available_enabled("hotels");
				$chkingtours = $this->ptmodules->is_mod_available_enabled("tours");
				$chkingcars = $this->ptmodules->is_mod_available_enabled("cars");
				$chkingcruises = $this->ptmodules->is_mod_available_enabled("cruises");
				if (!empty ($resultingquery)) {
						foreach ($resultingquery->result() as $r) {
								if ($r->offer_module == "hotels" && $chkinghotels) {
//  $query = $this->db->query("SELECT module as module,hotel_id as id, hotel_title as title,hotel_basic_price as basicprice,hotel_basic_discount as discountprice FROM pt_hotels WHERE hotel_id = $r->offer_item")->result();
										$this->db->select('pt_hotels.hotel_id as itemid,pt_hotels.module as module,pt_hotels.hotel_slug as slug,pt_hotels.hotel_title as title,pt_hotels.hotel_desc as description,pt_hotels.hotel_basic_price as basicprice,pt_hotels.hotel_basic_discount as discountprice');
										$this->db->where_in('pt_hotels.hotel_id', $r->offer_item);
// $this->db->where('pt_hotel_images.himg_type','default');
										$this->db->where('pt_hotels.hotel_status', '1');
// $this->db->join('pt_hotel_images','pt_hotels.hotel_id = pt_hotel_images.himg_hotel_id','left');
										$query = $this->db->get('pt_hotels')->result();
								}
								elseif ($r->offer_module == "cruises" && $chkingcruises) {
										$this->db->select('pt_cruises.cruise_id as itemid,pt_cruises.module as module,pt_cruises.cruise_slug as slug,pt_cruises.cruise_title as title,pt_cruises.cruise_desc as description,pt_cruises.cruise_basic_price as basicprice,pt_cruises.cruise_basic_discount as discountprice');
										$this->db->where_in('pt_cruises.cruise_id', $r->offer_item);
										$this->db->where('pt_cruises.cruise_status', '1');
										$query = $this->db->get('pt_cruises')->result();
								}
								elseif ($r->offer_module == "tours" && $chkingtours) {
										$this->db->select('pt_tours.tour_id as itemid,pt_tours.tour_slug as slug, pt_tours.module as module,pt_tours.tour_title as title,pt_tours.tour_desc as description,pt_tours.tour_basic_price as basicprice,pt_tours.tour_basic_discount as discountprice');
										$this->db->where_in('pt_tours.tour_id', $r->offer_item);
//  $this->db->where('pt_tour_images.timg_type','default');
										$this->db->where('pt_tours.tour_status', '1');
//  $this->db->join('pt_tour_images','pt_tours.tour_id = pt_tour_images.timg_tour_id','left');
										$query = $this->db->get('pt_tours')->result();
								}
								elseif ($r->offer_module == "cars" && $chkingcars) {
										$this->db->select('pt_cars.car_id as itemid,pt_cars.car_slug as slug, pt_cars.module as module,pt_cars.car_title as title,pt_cars.car_desc as description,pt_cars.car_basic_price as basicprice,pt_cars.car_basic_discount as discountprice');
										$this->db->where_in('pt_cars.car_id', $r->offer_item);
										$this->db->where('pt_cars.car_status', '1');
										$query = $this->db->get('pt_cars')->result();
								}
								if (!empty ($query)) {
										array_push($result, $query);
								}
						}
						$result['rows'] = $resultingquery->num_rows();
				}
				return $result;
		}

/// List all offers on front listings page
		function list_specialOffers_front($perpage = null, $offset = null, $orderby = null) {
				$data = array();
               // $hotelslist = $lists['hotels'];
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->where('pt_special_offers.offer_from <=', time());
				$this->db->where('pt_special_offers.offer_to >=', time());
				$this->db->or_where('pt_special_offers.offer_forever','forever');
				$this->db->where('pt_special_offers.offer_status', 'Yes');
				$this->db->order_by('pt_special_offers.offer_id', 'desc');
				$query = $this->db->get('pt_special_offers', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}


//get all special offers admin
		function admin_get_all_special_offers() {
				$this->db->order_by('offer_id', 'desc');
				return $this->db->get('pt_special_offers')->result();
		}

// get all bookings with limit
		function admin_get_all_special_offers_limit($perpage = null, $offset = null, $orderby = null) {
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->order_by('offer_id', 'desc');
				$query = $this->db->get('pt_special_offers', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}

// get all bookings info  by advance search for admin
		function adv_search_all_offers_back_limit($data, $perpage = null, $offset = null, $orderby = null) {
				$status = $data["status"];
				$module = $data["module"];
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				if (!empty ($module)) {
						$this->db->where('offer_module', $module);
				}
				$this->db->where('offer_status', $status);
				$this->db->order_by('offer_id', 'desc');
				$query = $this->db->get('pt_special_offers', $perpage, $offset);
				$data['all'] = $query->result();
				$data['nums'] = $query->num_rows();
				return $data;
		}
// update offer order
		function update_offer_order($id, $order){
				$data = array('offer_order' => $order);
				$this->db->where('offer_id', $id);
				$this->db->update('pt_special_offers', $data);
		}


         // Update translation of some fields data
		function update_translation($postdata,$id) {

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];

                $transAvailable = $this->getBackOffersTranslation($lang,$id);

                if(empty($transAvailable)){
                   $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_offer_id' => $id,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_offers_translation', $data);

                }else{
                 $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,

                );
				$this->db->where('trans_offer_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_offers_translation', $data);
                }


              }

                }
		}

        function getBackOffersTranslation($lang, $id) {
				$this->db->where('trans_lang', $lang);
				$this->db->where('trans_offer_id', $id);
				return $this->db->get('pt_offers_translation')->result();
		}

        // Delete Offer
        function deleteOffer($id){

          $this->db->select('oimg_offer_id,oimg_image');
          $this->db->where('oimg_offer_id',$id);
          $offerimgs = $this->db->get('pt_offer_images')->result();

          foreach($offerimgs as $img){

          @unlink(PT_OFFERS_IMAGES_UPLOAD.$img->oimg_image);
          @unlink(PT_OFFERS_THUMBS_UPLOAD.$img->oimg_image);
          $this->db->where('oimg_offer_id',$img->oimg_offer_id);
          $this->db->delete('pt_offer_images');

          }

          $this->deleteOfferTranslations($id);

          $this->db->where('offer_id',$id);
          $this->db->delete('pt_special_offers');

             }

       function deleteOfferTranslations($id){

            $this->db->where('trans_offer_id',$id);
            $this->db->delete('pt_offers_translation');
        }

       function addPhotos($id,$filename){
         $this->db->select('offer_thumb');
         $this->db->where('offer_id',$id);
         $rs = $this->db->get('pt_special_offers')->result();
         if($rs[0]->offer_thumb == PT_BLANK_IMG){
               $data = array('offer_thumb' => $filename);
               $this->db->where('offer_id',$id);
               $this->db->update('pt_special_offers',$data);
         }

        //add photos to offer images table
        $imgorder = 0;
        $this->db->where('oimg_offer_id', $id);
        $imgorder = $this->db->get('pt_offer_images')->num_rows();
        $imgorder = $imgorder + 1;
            	$insdata = array(
                'oimg_offer_id' => $id,
                'oimg_image' => $filename,
                'oimg_order' => $imgorder,

                );
		$this->db->insert('pt_offer_images', $insdata);


        }

         // get offer gallery images
       function offerGallery($id){
          $this->db->select('pt_special_offers.offer_thumb as thumbnail,pt_offer_images.oimg_id as id,pt_offer_images.oimg_offer_id as itemid,pt_offer_images.oimg_image as image,pt_offer_images.oimg_order as imgorder');
          $this->db->where('pt_special_offers.offer_id',$id);
          $this->db->join('pt_offer_images', 'pt_special_offers.offer_id = pt_offer_images.oimg_offer_id', 'left');
          $this->db->order_by('pt_offer_images.oimg_id','desc');
          return $this->db->get('pt_special_offers')->result();
        }

        // get number of photos of offer
	   function photos_count($id) {
				$this->db->where('oimg_offer_id', $id);
				return $this->db->get('pt_offer_images')->num_rows();
		}

      // update offer image order
      function update_offer_image_order($imgid,$order){
              $data = array(
              'oimg_order' => $order
              );

              $this->db->where('oimg_id',$imgid);
              $this->db->update('pt_offer_images',$data);
      }

     //update offer thumbnail
		function updateOfferThumb($offerid,$imgname,$action) {
		  if($action == "delete"){
            $this->db->select('offer_thumb');
            $this->db->where('offer_thumb',$imgname);
            $this->db->where('offer_id',$offerid);
            $rs = $this->db->get('pt_special_offers')->num_rows();
            if($rs > 0){
              $data = array(
              'offer_thumb' => PT_BLANK_IMG
              );
              $this->db->where('offer_id',$offerid);
              $this->db->update('pt_special_offers',$data);
            }
            }else{
              $data = array(
              'offer_thumb' => $imgname
              );
              $this->db->where('offer_id',$offerid);
              $this->db->update('pt_special_offers',$data);
            }

		}

        // Delete offer Images
    function delete_image($imgname = null, $imgid = null, $offerid = null ){

                 $this->db->where('oimg_id',$imgid);
                 $this->db->delete('pt_offer_images');
                 $this->updateOfferThumb($offerid,$imgname,"delete");
                 @unlink(PT_OFFERS_THUMBS_UPLOAD.$imgname);
                @unlink(PT_OFFERS_IMAGES_UPLOAD.$imgname);


    }

    function offerExists($slug){
    	$this->db->where('offer_slug',$slug);
    	$nums = $this->db->get('pt_special_offers')->num_rows();
    	if($nums > 0){
    		return TRUE;
    	}else{
    		return FALSE;
    	}

    }


    //search offers by text
		function searchOffers($perpage = null, $offset = null, $dfrom = null,$dto = null) {
				$data = array();

                $searchtxt =  $this->input->get('searching');
                			
				

                //$hotelslist = $lists['hotels'];
				if ($offset != null) {
						$offset = ($offset == 1) ? 0 : ($offset * $perpage) - $perpage;
				}
				$this->db->select('pt_special_offers.*,pt_offers_translation.trans_title');
				if(!empty($searchtxt)){
				$this->db->like('pt_special_offers.offer_title', $searchtxt);
				$this->db->or_like('pt_offers_translation.trans_title', $searchtxt);
			
					
			
				}
				
				if(!empty($dfrom) && !empty($dto)){				
				$this->db->where('pt_special_offers.offer_from <=', $dfrom);
				$this->db->where('pt_special_offers.offer_to >=', $dto);
				$this->db->or_where('pt_special_offers.offer_forever','forever');
				}

							
			
				$this->db->join('pt_offers_translation', 'pt_special_offers.offer_id = pt_offers_translation.trans_offer_id', 'left');
				$this->db->group_by('pt_special_offers.offer_id');
                $this->db->having('pt_special_offers.offer_status', 'Yes');
                
                
				$query = $this->db->get('pt_special_offers', $perpage, $offset);
				$data['all'] = $query->result();
				$data['rows'] = $query->num_rows();
				return $data;
		}



}