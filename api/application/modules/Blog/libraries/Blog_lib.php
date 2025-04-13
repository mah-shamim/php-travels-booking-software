<?php

class Blog_lib {
/**
* Protected variables
*/
		protected $ci = NULL; //codeigniter instance
		protected $db; //database instatnce instance
		protected $blogid;
		public $title;
		public $slug;
		public $desc;
		public $date;
		public $thumbnail;
		public $hits;
		public $langdef;
		protected $lang;

		function __construct() {
//get the CI instance
			$this->ci = & get_instance();
			$this->db = $this->ci->db;
			$this->ci->load->model('Blog/Blog_model');
			$lang = $this->ci->session->userdata('set_lang');
			$defaultlang = pt_get_default_language();

			$this->set_lang($this->ci->session->userdata('set_lang'));
            $this->langdef = DEFLANG;
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

		function set_blogid($slug) {
			$this->db->select('post_id');
			$this->db->where('post_slug', $slug);
			$r = $this->db->get('pt_blog')->result();
			$this->blogid = $r[0]->post_id;
		}

//set car id by id
		function set_id($id) {
			$this->blogid = $id;
		}

		function get_id() {
			return $this->blogid;
		}

		function settings() {
			return $this->ci->Settings_model->get_front_settings('blog');
		}

		function show_posts($offset = null,$perpage = null) {
			$totalSegments = $this->ci->uri->total_segments();
			$data = array();
			$settings = $this->settings();
			if(empty($perpage)){
				$perpage = $settings[0]->front_listings;
			}

			$sortby = $this->ci->input->get('sortby');
			if (!empty ($sortby)) {
				$orderby = $sortby;
			}
			else {
				$orderby = $settings[0]->front_listings_order;
			}
			$rh = $this->ci->Blog_model->list_posts_front();
			$data['all_posts'] = $this->ci->Blog_model->list_posts_front($perpage, $offset, $orderby);
			$data['paginationinfo'] = array('base' => 'blog/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
			return $data;
		}

    function show_post($offset = null,$perpage = null) {
        $totalSegments = $this->ci->uri->total_segments();
        $data = array();
        $settings = $this->settings();
        if(empty($perpage)){
            $perpage = $settings[0]->front_listings;
        }

        $sortby = $this->ci->input->get('sortby');
        if (!empty ($sortby)) {
            $orderby = $sortby;
        }
        else {
            $orderby = $settings[0]->front_listings_order;
        }
        $rh = $this->ci->Blog_model->list_posts_front();
        $data['all_posts'] = $this->ci->Blog_model->list_posts_fronts($offset, $orderby);
        $data['paginationinfo'] = array('base' => 'blog/listing', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
        return $data;
    }
		function post_details() {
			$this->db->select('pt_blog.*,pt_blog_categories.cat_name');
			$this->db->where('pt_blog.post_id', $this->blogid);
			$this->db->join('pt_blog_categories', 'pt_blog.post_category = pt_blog_categories.cat_id', 'left');
			$details = $this->db->get('pt_blog')->result();
			$this->slug = $details[0]->post_slug;
			$this->title = $this->get_title($details[0]->post_title);
			$this->desc = $this->get_description($details[0]->post_desc);
			$this->thumbnail = $this->post_thumbnail($details[0]->post_id);
			$this->date = pt_show_date_php($details[0]->post_created_at);
			$this->hits = $details[0]->post_visits;
			return $details;
		}

		function post_short_details() {
			$this->db->select('post_title,post_desc,post_created_at,post_slug');
			$this->db->where('pt_blog.post_id', $this->blogid);
			$details = $this->db->get('pt_blog')->result();
			$this->slug = $details[0]->post_slug;
			$this->title = $this->get_title($details[0]->post_title);
			$this->desc = $this->get_description($details[0]->post_desc);
			$this->date = pt_show_date_php($details[0]->post_created_at);
			$this->thumbnail = $this->post_thumbnail($this->blogid);
			return $details;
		}

		function post_thumbnail($id) {
			$res = $this->ci->Blog_model->post_thumbnail($id);
			if (!empty ($res)) {
				return PT_BLOG_IMAGES . $res;
			}
			else {
				return PT_BLANK;
			}
		}

		function search_posts($offset = null) {
			$totalSegments = $this->ci->uri->total_segments();
			$data = array();
			$settings = $this->settings();
			$perpage = $settings[0]->front_search;
			$orderby = $settings[0]->front_search_order;
			$rh = $this->ci->Blog_model->search_posts_front();
			$data['all_posts'] = $this->ci->Blog_model->search_posts_front($perpage, $offset, $orderby);
			$data['paginationinfo'] = array('base' => 'blog/search', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
			return $data;
		}

		function latestPostsHomepage() {
			$results = new stdClass;
			$settings = $this->settings();
			$perpage = $settings[0]->front_homepage;
			$orderby = $settings[0]->front_homepage_order;
			$posts = $this->ci->Blog_model->latest_posts($perpage, $orderby);
			$results->posts  = array();
			foreach($posts as $p){
				$this->set_id($p->post_id);
				$this->post_short_details();
				$shortdesc = strip_tags($this->desc);
				$results->posts[] = (object)array('id' => $p->post_id, 'title' => $this->title,'thumbnail' => $this->thumbnail,'desc' => $this->desc, 'shortDesc' =>  character_limiter($shortdesc,60),'slug' => base_url().'blog/'.$this->slug);
			}
			return $results;
		}

    function latestPostsmain($lang) {
		    $this->lang = $lang;
        $results = new stdClass;
        $settings = $this->settings();
        $perpage = $settings[0]->front_homepage;
        $orderby = $settings[0]->front_homepage_order;
        $posts = $this->ci->Blog_model->latest_posts($perpage, $orderby);
        $results = array();
        foreach($posts as $p){
            $this->set_id($p->post_id);
            $this->post_short_details();
            $shortdesc = strip_tags($this->desc);
            $results[] = (object)array('id' => $p->post_id, 'title' => $this->title,'thumbnail' => $this->thumbnail,'desc' => $this->desc, 'shortDesc' =>  $shortdesc,'slug' => base_url().'blog/'.$this->slug);
        }
        return $results;
    }

		function category_posts($offset = null) {
			$totalSegments = $this->ci->uri->total_segments();
			$data = array();
			$settings = $this->settings();
			$perpage = $settings[0]->front_listings;
			$orderby = $settings[0]->front_listings_order;
			$rh = $this->ci->Blog_model->category_posts_front();
			$data['all_posts'] = $this->ci->Blog_model->category_posts_front($perpage, $offset, $orderby);
			$data['paginationinfo'] = array('base' => 'blog/category', 'totalrows' => $rh['rows'], 'perpage' => $perpage,'urisegment' => $totalSegments);
			return $data;
		}

		function get_title($deftitle) {
			if ($this->lang == $this->langdef) {
				$title = $deftitle;
			}
			else {
				$this->db->where('item_id', $this->blogid);
				$this->db->where('trans_lang', $this->lang);
				$res = $this->db->get('pt_blog_translation')->result();
				$title = $res[0]->trans_title;
				if (empty ($title)) {
					$title = $deftitle;
				}
			}
			return $title;
		}

		function get_description($defdesc) {
			if ($this->lang == $this->langdef) {
				$desc = $defdesc;
			}
			else {
				$this->db->where('item_id', $this->blogid);
				$this->db->where('trans_lang', $this->lang);
				$res = $this->db->get('pt_blog_translation')->result();
				$desc = $res[0]->trans_desc;
				if (empty ($desc)) {
					$desc = $defdesc;
				}
			}
			return $desc;
		}

		function getCategories(){
			$result = $this->ci->Blog_model->get_enabled_categories();
			foreach($result as $rs){
				$title = $this->getCategoryTitle($rs->cat_name,$rs->cat_id);

				$cats[] = (object)array("id" => $rs->cat_id, "name" => $title, "slug" => $rs->cat_slug );

			}
			return $cats;
		}

		function getCategoryTitle($deftitle,$catid) {
			if ($this->lang == $this->langdef) {
				$title = $deftitle;
			}
			else {
				$this->db->where('cat_id', $catid);
				$this->db->where('trans_lang', $this->lang);
				$res = $this->db->get('pt_blog_categories_translation')->result();
				$title = $res[0]->cat_name;
				if (empty ($title)) {
					$title = $deftitle;
				}
			}
			return $title;
		}

		function translated_data($lang) {
			$this->db->where('item_id', $this->blogid);
			$this->db->where('trans_lang', $lang);
			return $this->db->get('pt_blog_translation')->result();
		}

		function getLimitedResultObject($posts){
          $result = array();
          if(!empty($posts)){
          	foreach($posts as $post){


            	$result[] = (object)array('title' => $post->post_title, 'slug' => base_url()."blog/".$post->post_slug);


             }
          }

            return $result;
        }


		 public function siteMapData(){
          		$postsData = array();
				$this->db->select('post_title,post_slug');
				$this->db->where('post_status','Yes');
				$result = $this->db->get('pt_blog');
				$posts = $result->result();
				if(!empty($posts)){

				$postsData = $this->getLimitedResultObject($posts);

				}

				return $postsData;
        }

	}
