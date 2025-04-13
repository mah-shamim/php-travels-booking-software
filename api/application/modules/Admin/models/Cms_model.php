<?php
class Cms_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }




    // get the content of page in selected language
    function translated_content($pageid,$langid){

    $this->db->where('content_page_id',$pageid);
    $this->db->where('content_lang_id',$langid);

    $q = $this->db->get('pt_cms_content');

    return $q->result();

    }

    // get page data by page id
    function get_page_data($pageid){

   $this->db->where('pt_cms_content.content_page_id',$pageid);
   $this->db->where('pt_cms_content.content_lang_id',DEFLANG);
   $this->db->join('pt_cms','pt_cms.page_id = pt_cms_content.content_page_id');
   $q = $this->db->get('pt_cms_content');

   return $q->result();

    }

    function makeSlug($title,$pagelastid = null){
                        $slug = create_url_slug($title);
                        $this->db->select("page_id");
						$this->db->where("page_slug", $slug);
                        if(!empty($pagelastid)){
                         $this->db->where('page_id !=',$pagelastid);
                        }
						$queryc = $this->db->get('pt_cms')->num_rows();
						if ($queryc > 0) {
								$slug = $slug."-".$pagelastid;
						}
                        return $slug;
    }
    // Add a CMS page
    function addpage()
    {
       $this->db->select("page_id");
				$this->db->order_by("page_id", "desc");
				$query = $this->db->get('pt_cms');
				$lastid = $query->result();
				if (empty ($lastid)) {
						$pagelastid = 1;
				}
				else {
						$pagelastid = $lastid[0]->page_id + 1;
				}

    $pageslug = $this->input->post('pageslug');
    if(empty($pageslug)){
      $pageslug = $this->makeSlug($this->input->post('pagetitle'),$pagelastid);
      }else{
      $pageslug = $this->makeSlug($pageslug,$pagelastid);
      }
      $data = array(
        'page_slug' => $pageslug,
        'page_external_link' => $this->input->post('externalink'),
        'page_status' => $this->input->post('status'),
        'page_icon' => $this->input->post('page_icon'),
        'page_divider' => 0,
        'page_target' => $this->input->post('pagetarget')
      );
     $this->db->insert('pt_cms',$data);
     $pageid = $this->db->insert_id();
    $now = date("Y-m-d H:i:s");
     $data2 = array(
            'content_page_id' => $pageid,
            'content_lang_id' => DEFLANG,
            'content_page_title' => $this->input->post('pagetitle'),
            'content_body' => $this->input->post('pagebody'),
            'content_meta_keywords' => $this->input->post('keywords'),
            'content_meta_desc' => $this->input->post('pagedesc'),
            'content_created' => $now,
            'content_updated' => $now
     );

     $this->db->insert('pt_cms_content',$data2);
     return $pageid;

    }

    // Update a CMS page
     function updatepage()
    {
    $pagetitle = $this->input->post('pagetitle');
    $pageslug = $this->input->post('pageslug');
    if(empty($pageslug)){
      $pageslug = $this->makeSlug($pagetitle,$this->input->post('pageid'));
      }else{
      $pageslug = $this->makeSlug($pageslug,$this->input->post('pageid'));
      }

      $data = array(
        'page_slug' => $pageslug,
        'page_external_link' => $this->input->post('externalink'),
        'page_status' => $this->input->post('status'),
        'page_icon' => $this->input->post('page_icon'),
      //   'page_divider' => $this->input->post('page_divider'),
        'page_target' => $this->input->post('pagetarget')
      );
     $this->db->where('page_id',$this->input->post('pageid'));
     $this->db->update('pt_cms',$data);
      $now = date("Y-m-d H:i:s");
      $data2 = array(

            'content_page_title' => $pagetitle,
            'content_body' => $this->input->post('pagebody'),
            'content_meta_keywords' => $this->input->post('keywords'),
            'content_meta_desc' => $this->input->post('pagedesc'),
            'content_updated' => $now
     );
     $this->db->where('content_id',$this->input->post('contentid'));
     $this->db->update('pt_cms_content',$data2);



    }

     // Get CMS pages titles
    public function get_cms_pages_title($langid = null,$self = null){
      if($langid == null){
        $langid = DEFLANG;
        }
         $this->db->select('content_page_id,content_page_title');
         $this->db->where('content_lang_id',$langid);
         if($self != null){
         $this->db->where('content_page_id !=',$self);

         }
         $this->db->where('content_special', 0);
         $this->db->group_by('content_page_id');
         $res =  $this->db->get('pt_cms_content');
         return $res->result();
    }

    // Get all CMS pages
    public function get_all_cms_pages(){
    $this->db->where('pt_cms_content.content_special','0');
    $this->db->join('pt_cms_content','pt_cms.page_id = pt_cms_content.content_page_id');
    $this->db->order_by('pt_cms.page_id','desc');
    $this->db->group_by('pt_cms.page_id');
    $result = $this->db->get('pt_cms');
    return $result->result();
    }

    // Delete CMS Page
    public function delete_page($pageid){

    $this->db->where('page_id',$pageid);
    $this->db->delete('pt_cms');

    $this->db->where('content_page_id',$pageid);
    $this->db->delete('pt_cms_content');


    }

     // Disable CMS Page
    public function disable_page($pageid){

    $data = array(
       'page_status' => 'No'
    );

    $this->db->where('page_id',$pageid);
    $this->db->update('pt_cms',$data);



    }

      // Enable CMS Page
    public function enable_page($pageid){

    $data = array(
       'page_status' => 'Yes'
    );

    $this->db->where('page_id',$pageid);
    $this->db->update('pt_cms',$data);



    }


    // check page existance
    	function check($slug)
		{

        $this->db->where('page_slug',$slug);
		$q = $this->db->get('pt_cms');
		$n = $q->num_rows();
		if($n > 0)
		{
		return true;
		}else{
		return false;
		}
		}

    // Get page content
   function get_page_content($page,$langid){

		$this->db->where('pt_cms.page_slug',$page);
        $this->db->where('pt_cms.page_status','Yes');
        $this->db->where('pt_cms_content.content_special','0');
        $this->db->where('pt_cms_content.content_lang_id',$langid);
        $this->db->join('pt_cms','pt_cms_content.content_page_id = pt_cms.page_id');
		return $this->db->get('pt_cms_content')->result();


		}



   	function getBackTranslation($lang, $id) {
				$this->db->where('trans_lang', $lang);
				$this->db->where('trans_menu_id', $id);
				return $this->db->get('pt_menus_translation')->result();
		}


     // Adds translation of some fields data
		function add_translation($postdata,$id) {
		  foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];
                $metadesc = $val['metadesc'];
				$kewords = $val['keywords'];

                  $data = array(
                'content_page_title' => $title,
                'content_body' => $desc,
                'content_meta_desc' => $metadesc,
                'content_meta_keywords' => $kewords,
                'content_page_id' => $id,
                'content_lang_id' => $lang
                );
				$this->db->insert('pt_cms_content', $data);

                }

                }


		}

        // Update translation of some fields data
		function update_translation($postdata,$id) {

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];
				$metadesc = $val['metadesc'];
				$kewords = $val['keywords'];
                $transAvailable = $this->getBackCMSTranslation($lang,$id);

                if(empty($transAvailable)){
                   $data = array(
                'content_page_title' => $title,
                'content_body' => $desc,
                'content_meta_desc' => $metadesc,
                'content_meta_keywords' => $kewords,
                'content_page_id' => $id,
                'content_lang_id' => $lang
                );
				$this->db->insert('pt_cms_content', $data);

                }else{
                 $data = array(
                'content_page_title' => $title,
                'content_body' => $desc,
                'content_meta_desc' => $metadesc,
                'content_meta_keywords' => $kewords,
                );
				$this->db->where('content_page_id', $id);
				$this->db->where('content_lang_id', $lang);
			    $this->db->update('pt_cms_content', $data);
                }


              }

                }
		}



    function getBackCMSTranslation($lang, $id) {
				$this->db->where('content_lang_id', $lang);
				$this->db->where('content_page_id', $id);
				return $this->db->get('pt_cms_content')->result();
		}

}
