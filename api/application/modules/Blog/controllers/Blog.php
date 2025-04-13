<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Blog extends MX_Controller {

    private $validlang;

    function __construct() {
        parent :: __construct();
        $this->frontData();

        $this->load->library("Blog_lib");
        $this->load->model("Blog/Blog_model");
        $this->load->helper("blog_front");
        $this->data['phone'] = $this->load->get_var('phone');
        $this->data['contactemail'] = $this->load->get_var('contactemail');
        $this->data['lang_set'] = $this->session->userdata('set_lang');
        $this->data['usersession'] = $this->session->userdata('pt_logged_customer');
        $this->data['bloglib'] = $this->Blog_lib;
        $chk = modules :: run('Home/is_main_module_enabled', 'blog');
        if (!$chk) {
            Error_404($this);
        }



        $settings = $this->Settings_model->get_front_settings('blog');

        $languageid = $this->uri->segment(2);
                $this->validlang = pt_isValid_language($languageid);

                if($this->validlang){
                  $this->data['lang_set'] =  $languageid;
                }else{
                  $this->data['lang_set'] = $this->session->userdata('set_lang');
                }

        $defaultlang = pt_get_default_language();
        if (empty ($this->data['lang_set'])){
            $this->data['lang_set'] = $defaultlang;
        }



        $this->lang->load("front", $this->data['lang_set']);
        $this->Blog_lib->set_lang($this->data['lang_set']);
        $this->data['popular_posts'] = $this->Blog_model->get_popular_posts($settings[0]->front_popular);
        $this->data['categories'] = $this->Blog_lib->getCategories();
    }

    public function index() {
        $settings = $this->Settings_model->get_front_settings('blog');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";

        if($this->validlang){

                    $slug = $this->uri->segment(3);

                }else{

                    $slug = $this->uri->segment(2);
                }
        if (!empty ($slug)) {
            $this->Blog_lib->set_blogid($slug);
            $this->data['details'] = $this->Blog_lib->post_details();
            $this->data['title'] = $this->Blog_lib->title;
            $this->data['desc'] = $this->Blog_lib->desc;
            $this->data['thumbnail'] = $this->Blog_lib->thumbnail;
            $this->data['date'] = $this->Blog_lib->date;
            $hits = $this->Blog_lib->hits + 1;
            $this->Blog_model->update_visits($this->data['details'][0]->post_id, $hits);
            $relatedstatus = $settings[0]->testing_mode;
            if ($relatedstatus == "1") {
                $this->data['related_posts'] = $this->Blog_model->get_related_posts($this->data['details'][0]->post_related, $settings[0]->front_related);
            }
            else {
                $this->data['related_posts'] = "";
            }
            $res = $this->Settings_model->get_contact_page_details();

            $this->data['phone'] = $res[0]->contact_phone;

            $this->data['langurl'] = base_url()."blog/{langid}/".$this->Blog_lib->slug;

$this->setMetaData($this->Blog_lib->title,$this->data['details'][0]->post_meta_desc,$this->data['details'][0]->post_meta_keywords);

            $this->theme->view('blog/blog', $this->data, $this);
        }
        else {
            $this->listing();
        }
    }

    function listing($offset = null) {
        $settings = $this->Settings_model->get_front_settings('blog');
        $this->data['ptype'] = "index";
        $this->data['categoryname'] = "";
        $allposts = $this->Blog_lib->show_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['langurl'] = base_url()."blog/{langid}/";
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('blog/index', $this->data, $this);
    }

    function search($offset = null) {
        $this->data['ptype'] = "search";
        $this->data['categoryname'] = "";
        $settings = $this->Settings_model->get_front_settings('blog');
        $allposts = $this->Blog_lib->search_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->data['langurl'] = base_url()."blog/{langid}/";
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('blog/index', $this->data, $this);
    }

    function category($offset = null) {
        $settings = $this->Settings_model->get_front_settings('blog');
        $id = $this->input->get('cat');
        $this->data['ptype'] = "category";
        $this->data['categoryname'] = pt_blog_category_name($id);
        $allposts = $this->Blog_lib->category_posts($offset);
        $this->data['allposts'] = $allposts['all_posts'];
        $this->data['info'] = $allposts['paginationinfo'];
        $this->setMetaData( $settings[0]->header_title);
        $this->theme->view('blog/index', $this->data, $this);
    }

    function _remap($method, $params=array()){
		$funcs = get_class_methods($this);

		if(in_array($method, $funcs)){

		return call_user_func_array(array($this, $method), $params);

		}else{
				$this->index();
		}

		}

}
