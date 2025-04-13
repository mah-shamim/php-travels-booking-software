<?php

class sliders_lib
{
    /**
     * Protected variables
     */
    protected $ci       = NULL;    //codeigniter instance
    protected $db;    //database instatnce instance
    protected $slideid;
    public $title;
    public $desc;
    public $optionalText;
    public $date;
    public $langdef;
    protected $lang;


   function __construct()
    {

    	//get the CI instance
    	$this->ci = &get_instance();
        $this->db = $this->ci->db;
        $lang = $this->ci->session->userdata('set_lang');
        $defaultlang = pt_get_default_language();
        $this->langdef = DEFLANG;
        if(empty($lang)){
        $this->lang = $defaultlang;
        }else{
          $this->lang = $lang;
        }


    }

    //set slider id by id
    function set_id($id){

         $this->slideid  = $id;
    }

        function get_id(){
      return $this->slideid;
    }

 function slide_details(){
   $this->db->select('slide_title_text,slide_desc_text,slide_optional_text');
   $this->db->where('slide_id',$this->slideid);
   $details = $this->db->get('pt_sliders')->result();
   $this->title = $this->get_title($details[0]->slide_title_text);
   $this->desc = $this->get_description($details[0]->slide_desc_text);
   $this->optionalText = $this->get_optionalText($details[0]->slide_optional_text);

   return $details;

  }


  function get_title($deftitle){
    if($this->lang == $this->langdef){
    $title = $deftitle;
    }else{
    $this->db->where('item_id',$this->slideid);
    $this->db->where('trans_lang',$this->lang);
    $res = $this->db->get('pt_sliders_translation')->result();
    $title = $res[0]->trans_title;
    if(empty($title)){
     $title = $deftitle;
    }
    }

    return $title;
  }

  function get_description($defdesc){
    if($this->lang == $this->langdef){
    $desc = $defdesc;
    }else{
    $this->db->where('item_id',$this->slideid);
    $this->db->where('trans_lang',$this->lang);
    $res = $this->db->get('pt_sliders_translation')->result();
    $desc = $res[0]->trans_desc;
    if(empty($desc)){
     $desc = $defdesc;
    }
    }

    return $desc;
  }

   function get_optionalText($deftxt){
    
    if($this->lang == $this->langdef){
    $txtopt = $deftxt;
    }else{
    $this->db->where('item_id',$this->slideid);
    $this->db->where('trans_lang',$this->lang);
    $res = $this->db->get('pt_sliders_translation')->result();
    $txtopt = $res[0]->trans_optional;
    if(empty($txtopt)){
     $txtopt = $deftxt;
    }
    }

    return $txtopt;
  }



     // Update translation of some fields data
		function update_translation($postdata,$id) {

       foreach($postdata as $lang => $val){
		     if(array_filter($val)){
		        $title = $val['title'];
                $desc = $val['desc'];
                $optional = $val['optional'];

                $transAvailable = $this->getBackTranslation($lang,$id);

                if(empty($transAvailable)){
                   $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_optional' => $optional,
                'item_id' => $id,
                'trans_lang' => $lang
                );
				$this->db->insert('pt_sliders_translation', $data);

                }else{
                 $data = array(
                'trans_title' => $title,
                'trans_desc' => $desc,
                'trans_optional' => $optional
                );
				$this->db->where('item_id', $id);
				$this->db->where('trans_lang', $lang);
			    $this->db->update('pt_sliders_translation', $data);
                }


              }

                }
		}

	function getBackTranslation($lang, $id) {
				$this->db->where('trans_lang', $lang);
				$this->db->where('item_id', $id);
				return $this->db->get('pt_sliders_translation')->result();
		}


}