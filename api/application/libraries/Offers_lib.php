<?php

class offers_lib {
/*

* Protected variables

*/
		protected $ci = NULL; //codeigniter instance
		protected $db; //database instatnce instance
		public $slug;
		public $module;
		public $title;
		public $desc;
		public $thumb;
		public $price;
		public $langdef;
		public $offerid;
		public $offerPhone;
		public $offerEmail;
		protected $lang;

		function __construct() {
//get the CI instance
				$this->ci = & get_instance();
				$this->db = $this->ci->db;
				$this->set_lang($this->ci->session->userdata('set_lang'));
                $this->langdef = DEFLANG;

		}


//set offer id by id
		function set_id($id) {
				$this->offerid = $id;

		}

		function set_offerid($offerslug) {
				$this->db->select('offer_id');
				$this->db->where('offer_slug', $offerslug);
				$r = $this->db->get('pt_special_offers')->result();
			    $this->offerid = $r[0]->offer_id;

		}

		function get_id() {
				return $this->offerid;
		}

		function settings() {
				return $this->ci->Settings_model->get_front_settings('offers');
		}

		function set_lang($lang){
                 if (empty ($lang)) {
                   $defaultlang = pt_get_default_language();
						$this->lang = $defaultlang;
				}
				else {
						$this->lang = $lang;
				}
        }


		function offer_details($offerid = null) {
			  $this->ci->load->library('currconverter');
			if(empty($offerid)){
				$offerid = $this->offerid;
			}
				$this->db->where('offer_id', $offerid);
				$details = $this->db->get('pt_special_offers')->result();
                $title = $this->get_title($details[0]->offer_title,$details[0]->offer_id);
				$slug = $details[0]->offer_slug;
				$desc = $this->get_description($details[0]->offer_desc,$details[0]->offer_id);
				$curr = $this->ci->currconverter;
				$offerPrice = $curr->convertPrice($details[0]->offer_price,0);

				$thumbnail = PT_OFFERS_IMAGES.$details[0]->offer_thumb;

				$sliderImages = $this->offerImages($details[0]->offer_id);
				if($details[0]->offer_forever ==  "forever"){
					$offerForever = true;
					$offerEnded = false;
				}else{
					$offerForever = false;
					$offerEnded = true;
				}

				$fullExpiry =  date('F j Y',$details[0]->offer_to);


                $detailResults = (object)array(
                	'id' => $details[0]->offer_id,'title' => $title, 'slug' => $slug,'thumbnail' => $thumbnail,
            'desc' => $desc,'sliderImages' => $sliderImages,'price' => $offerPrice,'currCode' => $curr->code,
            'currSymbol' => $curr->symbol,'phone' => $details[0]->offer_phone,'email' => $details[0]->offer_email,'offerForever' => $offerForever,'fullExpiryDate' => $fullExpiry);

                return $detailResults;
		}
//offer short details
		function offerShortDetails($offerid = null) {
			if(empty($offerid)){
				$offerid = $this->offerid;
			}
				$this->db->where('offer_id', $offerid);
				$details = $this->db->get('pt_special_offers')->result();
				$this->title = $this->get_title($details[0]->offer_title,$details[0]->offer_id);
				$this->slug = $details[0]->offer_slug;
				$this->desc = $this->get_description($details[0]->offer_desc,$details[0]->offer_id);
				$this->price = $details[0]->offer_price;
				$this->offerPhone = $details[0]->offer_phone;
				$this->offerEmail = $details[0]->offer_email;
				$this->thumb = PT_OFFERS_IMAGES.$details[0]->offer_thumb;
                return $details;
		}

	// get Offer images
		function offerImages($offerid){
		  if(empty($offerid)){
		    $offerid = $this->offerid;
		  }
			  	$this->db->where('oimg_offer_id', $offerid);
			  	$this->db->where('oimg_approved', '1');
				$this->db->order_by('oimg_order', 'asc');
				$res = $this->db->get('pt_offer_images')->result();
                foreach($res as $r){
                  $result[] = array("fullImage" => PT_OFFERS_IMAGES.$r->oimg_image,"thumbImage" => PT_OFFERS_THUMBS.$r->oimg_image);
                }
                return $result;
		}

		function get_title($deftitle,$offerid = null) {
			if(empty($offerid)){
				$offerid = $this->offerid;
			}
				if ($this->lang == $this->langdef) {
						$title = $deftitle;
				}
				else {
						$this->db->where('trans_offer_id', $offerid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_offers_translation')->result();
						$title = $res[0]->trans_title;
						if (empty ($title)) {
								$title = $deftitle;
						}
				}
				return $title;
		}

		function get_description($defdesc,$offerid =null) {
			if(empty($offerid)){
				$offerid = $this->offerid;
			}
				if ($this->lang == $this->langdef) {
						$desc = $defdesc;
				}
				else {
						$this->db->where('trans_offer_id', $offerid);
						$this->db->where('trans_lang', $this->lang);
						$res = $this->db->get('pt_offers_translation')->result();
						$desc = $res[0]->trans_desc;
						if (empty ($desc)) {
								$desc = $defdesc;
						}
				}
				return $desc;
		}


		function getHomePageOffers() {
			$settings = $this->settings();
			$limit = $settings[0]->front_homepage;
				$this->db->where('pt_special_offers.offer_from <=', time());
				$this->db->where('pt_special_offers.offer_to >=', time());
				$this->db->or_where('pt_special_offers.offer_forever','forever');
				$this->db->where('pt_special_offers.offer_status', 'Yes');
				$this->db->order_by('pt_special_offers.offer_order', 'desc');
				$this->db->limit($limit);
				$offers = $this->db->get('pt_special_offers')->result();
         		$result = $this->getResultObject($offers);
         		return $result;
		}

		function showOffers($offset = null) {
				$data = array();
				$settings = $this->settings();
				$sortby = $this->ci->input->get('sortby');
				$perpage = $settings[0]->front_listings;
				$totalSegments = $this->ci->uri->total_segments();
				if (!empty ($sortby)) {
						$orderby = $sortby;
				}
				else {
						$orderby = "newf";//$settings[0]->front_listings_order;
				}
             	$this->ci->load->model('Admin/Special_offers_model');
				$rh = $this->ci->Special_offers_model->list_specialOffers_front();
			    $offers = $this->ci->Special_offers_model->list_specialOffers_front($perpage, $offset, $orderby);
                $data['allOffers'] = $this->getResultObject($offers['all']);
                $data['paginationinfo'] = array('base' => 'offers/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
				return $data;
		}

//search special offers from front end

		function searchOffers($offset = null, $dfrom,$dto) {
				$data = array();
				$settings = $this->settings();
				$sortby = $this->ci->input->get('sortby');
				$perpage = 10;//$settings[0]->front_search;
				if (!empty ($sortby)) {
						$orderby = $sortby;
				}
				else {
						$orderby = $settings[0]->front_search_order;
				}

			   $rh = $this->ci->Special_offers_model->searchOffers('', '');
			   $offers = $this->ci->Special_offers_model->searchOffers($perpage, $offset,convert_to_unix($dfrom),convert_to_unix($dto));
               $data['allOffers'] = $this->getResultObject($offers['all']);
               $data['paginationinfo'] = array('base' => 'offers/search', 'totalrows' => $rh['rows'], 'perpage' => $perpage);
				return $data;
		}

		//make a result object all data of offers array
         function getResultObject($offers){
          $this->ci->load->library('currconverter');
          $result = array();
          $curr = $this->ci->currconverter;

          foreach($offers as $o){
            $details = $this->offerShortDetails($o->offer_id);
            if($details[0]->offer_forever ==  "forever"){
					$offerForever = true;
					$offerEnded = false;
				}else{
					$offerForever = false;
					$offerEnded = true;
				}

			$fullExpiry =  date('F j Y',$details[0]->offer_to);
            $price = $curr->convertPrice($this->price,0);
            $result['offers'][] = (object)array('id' => $o->offer_id, 'title' => $this->title, 'slug' => base_url().'offers/'.$this->slug,'thumbnail' => $this->thumb,
            'desc' => strip_tags($this->desc),'price' => $price,'currCode' => $curr->code,'currSymbol' => $curr->symbol,'phone' => $this->offerPhone,'email' => $this->offerEmail,
            'offerForever' => $offerForever,'fullExpiryDate' => $fullExpiry);
            }
            $result['count'] = count($offers);
            return $result;
        }



}
