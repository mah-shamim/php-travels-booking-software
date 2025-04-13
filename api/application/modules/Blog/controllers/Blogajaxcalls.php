<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogajaxcalls extends MX_Controller {

	function __construct(){

     $this->load->model('Blog/Blog_model');

   }

     // delete multiple categories
     public function delMultipleCategories(){
      
      $catlist = $this->input->post('catlist');

      $items = $this->input->post('items');
      foreach($items as $item){
        $this->Blog_model->delete_cat($item);
      }


    }

      // delete multiple posts
     public function delMultiplePosts(){

      $items = $this->input->post('items');
      foreach($items as $item){
      $this->Blog_model->delete_post($item);
      }
        


    }


    // Delete Single category
    public function delete_single_category(){
      $catid = $this->input->post('catid');
   $this->Blog_model->delete_cat($catid);
     $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

    }

     // Delete Single Post
    public function delete_single_post(){
      $postid = $this->input->post('postid');
   $this->Blog_model->delete_post($postid);
     $this->session->set_flashdata('flashmsgs', "Deleted Successfully");

    }



    // update post order
	public function update_post_order(){
           $postid = $this->input->post('id');
          $order = $this->input->post('order');

          $this->Blog_model->update_post_order($postid,$order);

    }


    // Disable multiple categories
	public function disable_multiple_categories(){
          $catlist = $this->input->post('catlist');

          foreach($catlist as $catid){
          $this->Blog_model->disable_cat($catid);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");


    }

      // Disable multiple posts
	public function disable_multiple_posts(){
          $postlist = $this->input->post('postlist');

          foreach($postlist as $postid){
          $this->Blog_model->disable_post($postid);
          }
          $this->session->set_flashdata('flashmsgs', "Disabled Successfully");


    }

     // Enable multiple categories
	public function enable_multiple_categories(){
          $catlist = $this->input->post('catlist');

          foreach($catlist as $catid){
          $this->Blog_model->enable_cat($catid);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");


    }

     // Enable multiple posts
	public function enable_multiple_posts(){
          $postlist = $this->input->post('postlist');

          foreach($postlist as $postid){
          $this->Blog_model->enable_post($postid);
          }
          $this->session->set_flashdata('flashmsgs', "Enabled Successfully");


    }



}
