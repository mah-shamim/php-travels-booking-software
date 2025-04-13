<?php
if (!defined('BASEPATH'))
	exit ('No direct script access allowed');

class Blogback extends MX_Controller {
	public $accType = "";
	public $langdef;
	public  $editpermission = true;
	public  $deletepermission = true;
	public $role;

	function __construct() {
		$seturl = $this->uri->segment(3);
		if ($seturl != "settings") {
			$chk = modules :: run('Home/is_main_module_enabled', 'blog');
			if (!$chk) {
				redirect("admin");
			}
		}
		$checkingadmin = $this->session->userdata('pt_logged_admin');
		$this->accType = $this->session->userdata('pt_accountType');
		$this->data['isadmin'] = $this->session->userdata('pt_logged_admin');
    	$this->data['isSuperAdmin'] = $this->session->userdata('pt_logged_super_admin');

		$this->role = $this->session->userdata('pt_role');
		$this->data['role'] = $this->role;

		if (!empty ($checkingadmin)) {
			$this->data['userloggedin'] = $this->session->userdata('pt_logged_admin');
		}
		else {
			$this->data['userloggedin'] = $this->session->userdata('pt_logged_supplier');
		}
		if (empty ($this->data['userloggedin'])) {
			redirect("admin");
		}
		if (!empty ($checkingadmin)) {
			$this->data['adminsegment'] = "admin";
		}
		else {
			$this->data['adminsegment'] = "supplier";
		}
		if (empty($this->data['isSuperAdmin'])) {

				redirect('admin');
		}


		$this->data['c_model'] = $this->countries_model;
		$this->data['addpermission'] = true;
		if($this->accType == "supplier"){
			$this->editpermission = pt_permissions("editblog", $this->data['userloggedin']);
			$this->deletepermission = pt_permissions("deleteblog", $this->data['userloggedin']);
			$this->data['addpermission'] = pt_permissions("addblog", $this->data['userloggedin']);
		}
		$this->load->helper('settings');
		$this->load->helper('Blog/blog_front');
		$this->load->model('Blog/Blog_model');
		$this->load->library('Ckeditor');
		$this->data['ckconfig'] = array();
		$this->data['ckconfig']['toolbar'] = array(array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format', 'Styles'), array('NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'), array('Image', 'Link', 'Unlink', 'Anchor', 'Table', 'HorizontalRule', 'SpecialChar', 'Maximize'), array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),);
		$this->data['ckconfig']['language'] = 'en';
		$this->data['ckconfig']['height'] = '350px';
		$this->data['ckconfig']['filebrowserUploadUrl'] =  base_url().'home/cmsupload';
		$this->langdef = DEFLANG;
		$this->data['languages'] = pt_get_languages();
	}

	function index() {

		$this->load->helper('xcrud');
		$xcrud = xcrud_get_instance();
		$xcrud->table('pt_blog');
		$xcrud->join('post_category','pt_blog_categories','cat_id');
		$xcrud->change_type('post_category','select','email2@ex.com','email1@ex.com,email2@ex.com,email3@ex.com,email4@ex.com,email5@ex.com');
		$xcrud->order_by('post_id','desc');
		$xcrud->columns('post_img,post_title,pt_blog_categories.cat_name,post_created_at,post_order,post_status');
		$xcrud->label('post_title','Name')->label('pt_blog_categories.cat_name','Category')->label('post_created_at','Date')->label('post_order','Order')->label('post_status','Status')->label('post_img','Thumb');
		$xcrud->fields('post_img,post_title,pt_blog_categories.cat_name,post_desc,post_created_at,post_status');
		$xcrud->change_type('post_img', 'image', false, array(
			'width' => 200,
			'path' => '../../'.PT_BLOG_IMAGES_UPLOAD,
			'thumbs' => array(array(
				'crop' => true,
				'marker' => ''))));
		$xcrud->unset_add();
		$xcrud->unset_view();
		$xcrud->unset_edit();
		$xcrud->unset_remove();
		$this->data['add_link'] = base_url().'admin/blog/add';
		if($this->editpermission){
			$xcrud->button(base_url() . $this->data['adminsegment'] . '/blog/manage/{post_slug}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('target' => '_self'));
			$xcrud->column_pattern('post_title', '<a href="' . base_url() . $this->data['adminsegment'] . '/blog/manage/{post_slug}' . '">{value}</a>');
		}

		if($this->deletepermission){
		$delurl = base_url().'admin/ajaxcalls/delBlog';
        $xcrud->button("javascript: delfunc('{post_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self'));
       }
		$xcrud->search_columns('post_title,pt_blog_categories.cat_name,post_order,post_status');
		$xcrud->column_callback('post_order', 'orderInputPost');
		$xcrud->column_callback('post_created_at','fmtDate');
		$xcrud->column_class('post_img','zoom_img');

		$this->data['content'] = $xcrud->render();
		$this->data['page_title'] = 'Blog Management';
		$this->data['main_content'] = 'temp_view';
        $this->data['table_name'] = 'pt_blog';
        $this->data['main_key'] = 'post_id';
		$this->data['header_title'] = 'Blog Management';
		$this->load->view('template', $this->data);

	}

	function add() {

		$addpost = $this->input->post('action');
		if ($addpost == "add") {
			$this->form_validation->set_rules('title', 'Post Title', 'trim|required');
			$this->form_validation->set_rules('pageslug', 'Post Slug', 'trim');
			$this->form_validation->set_rules('keywords', 'Meta Keywords', 'trim');
			$this->form_validation->set_rules('metadesc', 'Meta Description', 'trim');
			$this->form_validation->set_rules('desc', 'Post Content', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
			}
			else {
				if (isset ($_FILES['defaultphoto']) && !empty ($_FILES['defaultphoto']['name'])) {
					$result = $this->Blog_model->blog_photo();
						$this->session->set_flashdata('flashmsgs', 'Post added Successfully');
						redirect('admin/blog');

				}
				else {
					$postid = $this->Blog_model->add_post();

					$this->session->set_flashdata('flashmsgs', 'Post added Successfully');
					redirect('admin/blog');
				}
			}
		}
		$this->data['action'] = "add";
		$this->data['all_posts'] = $this->Blog_model->select_related_posts();
		$this->data['categories'] = $this->Blog_model->get_enabled_categories();
		$this->data['main_content'] = 'Blog/manage';
		$this->data['page_title'] = 'Add Blog';
		$this->load->view('Admin/template', $this->data);
	}

	function settings() {
		$this->load->model('admin/settings_model');
		$updatesett = $this->input->post('updatesettings');
		if (!empty ($updatesett)) {
			$this->Blog_model->update_front_settings();
			redirect('admin/blog/settings');
		}
		$this->data['settings'] = $this->Settings_model->get_front_settings("blog");
		$this->data['main_content'] = 'Blog/settings';
		$this->data['page_title'] = 'Blog Settings';
		$this->load->view('Admin/template', $this->data);
	}

	function manage($slug) {
		if (empty ($slug)) {
			redirect('admin/blog');
		}
		$updatepost = $this->input->post('action');
		$postid = $this->input->post('postid');
		$this->data['action'] = "update";
		if ($updatepost == "update" ) {
			$this->form_validation->set_rules('title', 'Post Title', 'trim|required');
			$this->form_validation->set_rules('pageslug', 'Post Slug', 'trim');
			$this->form_validation->set_rules('keywords', 'Meta Keywords', 'trim');
			$this->form_validation->set_rules('metadesc', 'Meta Description', 'trim');
			$this->form_validation->set_rules('desc', 'Post Content', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
			}
			else {
				if (isset ($_FILES['defaultphoto']) && !empty ($_FILES['defaultphoto']['name'])) {
					$this->Blog_model->blog_photo($postid);
					$this->session->set_flashdata('flashmsgs', 'Post Updated Successfully');
					redirect('admin/blog');
				}
				else {
					$this->Blog_model->update_post($postid);
					$this->session->set_flashdata('flashmsgs', 'Post Updated Successfully');
					redirect('admin/blog');
				}
			}
		}
		else {
			$this->data['pdata'] = $this->Blog_model->get_post_data($slug);
			if (empty ($this->data['pdata'])) {
				redirect('admin/blog');
			}

			$this->data['related_selected'] = explode(",", $this->data['pdata'][0]->post_related);
			$this->data['all_posts'] = $this->Blog_model->select_related_posts($this->data['pdata'][0]->post_id);
			$this->data['categories'] = $this->Blog_model->get_enabled_categories();
			$this->data['main_content'] = 'Blog/manage';
			$this->data['page_title'] = 'Manage Post';
			$this->load->view('Admin/template', $this->data);
		}
	}

	function category() {
		$this->load->helper('xcrud');
		$updatecat = $this->input->post('updatecat');
		if(!empty($updatecat)){
			$this->Blog_model->updatecategory();
			redirect('admin/blog/category');
		}

		$addcat = $this->input->post('addcat');
		if(!empty($addcat)){
			$this->Blog_model->addcategory();
			redirect('admin/blog/category');
		}
		$xcrud = xcrud_get_instance();

		$xcrud->table('pt_blog_categories');
		$xcrud->order_by('cat_id','desc');
		$xcrud->columns('cat_name,cat_slug,cat_status');
		$xcrud->label('cat_name','Name')->label('cat_slug','Slug')->label('cat_status','Status');
		$xcrud->button('#cat{cat_id}', 'Edit', 'fa fa-edit', 'btn btn-warning', array('data-toggle' => 'modal'));
		$delurl = base_url().'admin/ajaxcalls/delBlogCat';
        $xcrud->button("javascript: delfunc('{cat_id}','$delurl')",'DELETE','fa fa-times', 'btn-danger',array('target'=>'_self'));


		$xcrud->unset_add();
		$xcrud->unset_edit();
		$xcrud->unset_remove();
		$xcrud->unset_view();
		$this->data['categories'] = $this->Blog_model->get_all_categories_back();

		$this->data['content'] = $xcrud->render();
		$this->data['page_title'] = 'Blog Categories';
		$this->data['main_content'] = 'blog_categories_view';
		$this->data['header_title'] = 'Blog Categories';
        $this->data['table_name'] = 'pt_blog_categories';
        $this->data['main_key'] = 'cat_id';
		$this->load->view('template', $this->data);
	}


	function translate($blogslug, $lang = null) {
		$this->load->library('Blog/Blog_lib');
		$this->Blog_lib->set_blogid($blogslug);
		$add = $this->input->post('add');
		$update = $this->input->post('update');
		if (empty ($lang)) {
			$lang = $this->langdef;
		}
		else {
			$lang = $lang;
		}
		if (empty ($blogslug)) {
			redirect('admin/blog/');
		}
		if (!empty ($add)) {
			$language = $this->input->post('langname');
			$postid = $this->input->post('postid');
			$this->Blog_model->add_translation($language, $postid);
			redirect("admin/blog/translate/" . $blogslug . "/" . $language);
		}
		if (!empty ($update)) {
			$slug = $this->Blog_model->update_translation($lang, $blogslug);
			redirect("admin/blog/translate/" . $slug . "/" . $lang);
		}
		$cdata = $this->Blog_lib->post_details();
		if ($lang == $this->langdef) {
			$blogdata = $this->Blog_lib->post_short_details();
			$this->data['blogdata'] = $blogdata;
			$this->data['transdesc'] = $blogdata[0]->post_desc;
			$this->data['transtitle'] = $blogdata[0]->post_title;
		}
		else {
			$blogdata = $this->Blog_lib->translated_data($lang);
			$this->data['blogdata'] = $blogdata;
			$this->data['transid'] = $blogdata[0]->trans_id;
			$this->data['transdesc'] = $blogdata[0]->trans_desc;
			$this->data['transtitle'] = $blogdata[0]->trans_title;
		}
		$this->data['postid'] = $this->Blog_lib->get_id();
		$this->data['lang'] = $lang;
		$this->data['slug'] = $blogslug;
		$this->data['language_list'] = pt_get_languages();
		$this->data['main_content'] = 'Blog/translate';
		$this->data['page_title'] = 'Translate Post';
		$this->load->view('Admin/template', $this->data);
	}

}
