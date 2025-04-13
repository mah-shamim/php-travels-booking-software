<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('pt_post_thumbnail'))
{
    function pt_post_thumbnail($id)
    {
       $CI = get_instance();

    $CI->load->model('Blog_model');

    $res = $CI->Blog_model->post_thumbnail($id);

   if(!empty($res)){
     return PT_BLOG_IMAGES.$res;
   }else{
     return PT_BLANK;
   }


    }
}

if ( ! function_exists('pt_posts_count'))
{
    function pt_posts_count($id)
    {
       $CI = get_instance();

    $CI->load->model('Blog_model');

    return $CI->Blog_model->category_posts_count($id);


    }
}

if ( ! function_exists('pt_blog_category_name'))
{
    function pt_blog_category_name($id)
    {
       $CI = get_instance();

    $CI->load->model('Blog_model');

    return $CI->Blog_model->category_name($id);


    }
}
