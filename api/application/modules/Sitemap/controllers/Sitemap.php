<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends MX_Controller {


  function __construct(){

    $ci = get_instance();
    $version = implode("=>",(array)$ci->db->query('SELECT VERSION()')->result()[0]);
    if($version > 5.6)
    {
    $ci->db->query('SET SESSION sql_mode = ""');
    $ci->db->query('SET SESSION sql_mode =
    REPLACE(REPLACE(REPLACE(
    @@sql_mode,
    "ONLY_FULL_GROUP_BY,", ""),
    ",ONLY_FULL_GROUP_BY", ""),
    "ONLY_FULL_GROUP_BY", "")');
    }

$this->frontData();

  
 }

	public function index()
	{
    $this->data['cms'] = $this->__cms();
    $hotels = modules :: run('Home/is_main_module_enabled', 'hotels');
    if ($hotels){

        $this->data['hotels'] = $this->__hotels();
                }            
    $tours = modules :: run('Home/is_main_module_enabled', 'tours');
    if ($tours){
        
        $this->data['tours'] = $this->__tours();
                }

    $cars = modules :: run('Home/is_main_module_enabled', 'cars');
    if ($cars){
        
        $this->data['cars'] = $this->__cars();
               
               }   

    $blog = modules :: run('Home/is_main_module_enabled', 'blog');
    if ($blog){
        
        $this->data['posts'] = $this->__blog();
               
               }    

    $offers = modules :: run('Home/is_main_module_enabled', 'offers');
    if ($offers){
        
        $this->data['offers'] = $this->__offers();
               
               }    
    

    $this->load->view('sitemap',$this->data);

    }


    function __cms(){
    $this->db->select('page_slug');
    $this->db->where('page_status','Yes');
    $result = $this->db->get('pt_cms');
    return $result->result();


    }

    function __hotels(){
    $this->load->library('Hotels/Hotels_lib');
    return $this->Hotels_lib->siteMapData();

    }


     function __cars(){

    $this->load->library('Cars/Cars_lib');
    return $this->Cars_lib->siteMapData();


    }

    function __tours(){

    $this->load->library('Tours/Tours_lib');
    return $this->Tours_lib->siteMapData();


    }

    function __blog(){

    $this->load->library('Blog/Blog_lib');
    return $this->Blog_lib->siteMapData();


    }


    function __offers(){

    $res = array();      
      
      $this->db->order_by('offer_id','desc');
      $offrs = $this->db->get('pt_special_offers')->result();

      if(!empty($offrs)){
        foreach($offrs as $o){
            $res[] = (object)array('title' => $o->offer_title,'slug' => base_url().'offers/'.$o->offer_slug);
        }
      }
   
   return $res;

    }


}
