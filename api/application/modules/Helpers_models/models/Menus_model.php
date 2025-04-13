<?php

class Menus_model extends CI_Model {

    function __construct() {
// Call the Model constructor
        parent :: __construct();

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

    }

    function get_all_header_items() {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title,pt_cms_content.content_special');
        $this->db->where('pt_cms.page_header_menu', '1');
        $this->db->where('pt_cms.page_parent', '0');
        $this->db->where('pt_cms_content.content_lang_id', DEFLANG);
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->order_by('pt_cms.page_header_order', 'asc');
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id');
        $query = $this->db->get('pt_cms');
        return $query->result();
    }

    function get_all_footer_items($col) {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title');
        $this->db->where('pt_cms.page_footer_col', $col);
        $this->db->where('pt_cms_content.content_lang_id', DEFLANG);
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->order_by('pt_cms.page_footer_order', 'asc');
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id');
        $query = $this->db->get('pt_cms');
        return $query->result();
    }

    function get_menu_items($col, $type) {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title,pt_cms_content.content_special');
        $this->db->where('pt_cms_content.content_lang_id', DEFLANG);
        $this->db->where('pt_cms.page_status', 'Yes');
        if ($type == "header") {
            $this->db->where('pt_cms.page_header_menu', '1');
            $this->db->order_by('pt_cms.page_header_order', 'asc');
        }
        else {
            $this->db->where('pt_cms.page_footer_col', $col);
            $this->db->order_by('pt_cms.page_footer_order', 'asc');
        }
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id');
        $query = $this->db->get('pt_cms');
        return $query->result();
    }

    function get_non_menu_items() {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title,pt_cms_content.content_special');
        $this->db->where('pt_cms_content.content_lang_id', DEFLANG);
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->where('pt_cms_content.content_special !=', '1');
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id');
        $query = $this->db->get('pt_cms');

        return $query->result();
    }

    function change_menu_header_order($listorder) {
        $count = 1;
        foreach ($listorder as $lo) {
            $data = array('page_header_order' => $count);
            $this->db->where('page_id', $lo);
            $this->db->update('pt_cms', $data);
            $count++;
        }
    }

    function change_menu_footer_order($listorder) {
        $count = 1;
        foreach ($listorder as $lo) {
            $data = array('page_footer_order' => $count);
            $this->db->where('page_id', $lo);
            $this->db->update('pt_cms', $data);
            $count++;
        }
    }

// update footer cols lables
    function update_footer_cols_label($id, $labeltext) {
        $data = array('menu_title' => $labeltext);
        $this->db->where('menu_id', $id);
        $this->db->update('pt_menus', $data);
    }

// Show footer cols labels
    function show_footer_cols_label($col) {
        $this->db->select('menu_title');
        $this->db->where('menu_id', $col);
        $res = $this->db->get('pt_menus')->result();
        return $res[0]->menu_title;
    }

// Show all footer cols labels
    function get_footer_menus_label() {
        $this->db->where('coltype', 'footer');
        $res = $this->db->get('pt_menus')->result();
        return $res;
    }

// Get all header menu
    function get_header_menu() {
        $this->db->where('status', '1');
        $this->db->where('coltype', 'header');
        $res = $this->db->get('pt_menus')->result();
        return $res;
    }

    function get_header_menu_status()
    {
        $this->db->select('page_id, slug_status');
        $dataAdapter = $this->db->get('pt_cms');
        if ($dataAdapter->num_rows() > 0) {
            $dataset = $dataAdapter->result_array();

            return array_combine(array_column($dataset, 'page_id'), array_column($dataset, 'slug_status'));
        }

        return NULL;
    }

// Get all footer menu columns except horizontal
    function get_footer_menus($id = null) {
        $currlang = $this->session->userdata('set_lang');
        $this->db->where('pt_menus.status', '1');
        if (!empty ($id)) {
            $this->db->where('pt_menus.menu_id', $id);
        }
        //	$this->db->where('pt_menus.coltype', 'footer');
        $this->db->join('pt_menus_translation', 'pt_menus.menu_id = pt_menus_translation.trans_menu_id','left');
        $this->db->group_by('pt_menus.menu_id');
        if(!empty($currlang) && $currlang != DEFLANG){
            $this->db->where('pt_menus_translation.trans_lang', $currlang);
        }
        $this->db->order_by('pt_menus.order', 'asc');
        $res = $this->db->get('pt_menus')->result();

        if(!empty($res)){

            foreach($res as $r){
                if(!empty($currlang) && $currlang != DEFLANG){
                    $title = $r->trans_title;
                    if(empty($title)){
                        $title = $r->menu_title;
                    }
                }else{
                    $title = $r->menu_title;
                }
                $result[] = array("title" => $title, "menuitems" => $r->menu_items);
            }

        }else{


            $this->db->where('pt_menus.status', '1');
            if (!empty ($id)) {
                $this->db->where('pt_menus.menu_id', $id);
            }
            $this->db->group_by('pt_menus.menu_id');
            $this->db->order_by('pt_menus.order', 'asc');
            $res2 = $this->db->get('pt_menus')->result();

            foreach($res2 as $re){
                $result[] = array("title" => $re->menu_title, "menuitems" => $re->menu_items);
            }


        }

        return $result;
    }

// Get footer horizontal title
    function get_footer_horizontal() {
        $this->db->where('status', '1');
        $this->db->where('coltype', 'horizontal');
        $res = $this->db->get('pt_menus')->result();
        return $res;
    }

    function translate_update($item, $langu) {
        $data = array($langu => $this->input->post($item));
        $this->db->where('gt_item_key', $item);
        $this->db->update('pt_global_translations', $data);
    }

// translate word in given language
    function translate_word($word) {
        $langu = $this->session->userdata('language');
        $this->db->select("$langu,gt_item_key");
        $this->db->where('gt_item_key', $word);
        $result = $this->db->get('pt_global_translations')->result();
        return @ $result[0]->$langu;
    }

// get page title in defined language
    function get_title_in_lang($pageid, $langid) {
        $this->db->select('content_page_title');
        $this->db->where('content_special', '0');
        $this->db->where('content_page_id', $pageid);
        $this->db->where('content_lang_id', $langid);
        $res = $this->db->get('pt_cms_content')->result();
        if (!empty ($res)) {
            $result = $res[0]->content_page_title;
        }
        if (empty ($result)) {
            $this->db->select('content_page_title');
            $this->db->where('content_special', '0');
            $this->db->where('content_page_id', $pageid);
            $this->db->where('content_lang_id', DEFLANG);
            $ress = $this->db->get('pt_cms_content')->result();
            $result = $ress[0]->content_page_title;
        }
        return $result;
    }

// get all child pages of the parent page
    function get_child_pages($pageid, $langid) {
        $this->db->select('pt_cms.*,pt_cms_content.content_page_title');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id');
        $this->db->where('pt_cms.page_parent', $pageid);
        $this->db->where('pt_cms_content.content_lang_id', $langid);
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->order_by('pt_cms.page_header_order', 'asc');
        $result = $this->db->get('pt_cms')->result();
        return $result;
    }

// get all parent pages
    function get_all_parents() {
        $this->db->select('pt_cms.page_parent,pt_cms.page_status');
        $this->db->where('pt_cms.page_parent !=', '0');
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->group_by('pt_cms.page_parent');
        $result = $this->db->get('pt_cms')->result();
        return $result;
    }

// if page has child page
    function has_child($pageid) {
        $this->db->select('page_parent');
        $this->db->where('page_parent', $pageid);
        $rs = $this->db->get('pt_cms')->num_rows();
        if ($rs > 0) {
            return true;
        }
        else {
            return false;
        }
    }

// populate sub menu items
    function populate_submenu($types) {
        if ($types == "hotelstypes") {
            $this->db->select('sett_id AS id, sett_name AS label');
            $this->db->where('sett_type', 'htypes');
            $this->db->where('sett_status', 'Yes');
            return $this->db->get('pt_hotels_types_settings')->result();
        }
    }

// Get all menus
    function get_menus($id = null) {
        if (!empty ($id)) {
            $this->db->where('menu_id', $id);
        }
        return $this->db->get('pt_menus')->result();
    }

// Add Menu
    function add_menu() {
        $data = array(
            'menu_title' => $this->input->post('menutitle'),
            'status' => $this->input->post('status'),
            //'coltype' => $this->input->post('mtype')
        );
        $this->db->insert('pt_menus', $data);
        $id = $this->db->insert_id();
        $this->update_translation($this->input->post('translated'),$id);
    }

//Delete menu
    function del_menu($id) {
        $this->db->where('menu_id', $id);
        $this->db->delete("pt_menus");

        $this->db->where('trans_menu_id', $id);
        $this->db->delete("pt_menus_translation");
    }

// Update Menu details
    function update_menu_detail() {
        $data = array('menu_title' => $this->input->post('menutitle'), 'status' => $this->input->post('status'));
        $this->db->where('menu_id', $this->input->post('menu'));
        $this->db->update('pt_menus', $data);
        $this->update_translation($this->input->post('translated'),$this->input->post('menu'));
    }

    function add_to_header($page) {
        $this->db->select('page_header_order');
        $this->db->order_by('page_header_order', 'desc');
        $rs = $this->db->get('pt_cms')->result();
        $lastorder = $rs[0]->page_header_order;
        $order = $lastorder + 1;
        $data = array('page_header_order' => $order, 'page_header_menu' => '1');
        $this->db->where('page_id', $page);
        $this->db->update('pt_cms', $data);
    }

    function add_to_footer($page, $menu) {
        $this->db->select('page_footer_order');
        $this->db->order_by('page_footer_order', 'desc');
        $rs = $this->db->get('pt_cms')->result();
        $lastorder = $rs[0]->page_footer_order;
        $order = $lastorder + 1;
        $data = array('page_footer_order' => $order, 'page_footer_col' => $menu);
        $this->db->where('page_id', $page);
        $this->db->update('pt_cms', $data);
    }

    function remove_from_header($page) {
        $data = array('page_header_order' => '0', 'page_header_menu' => '0');
        $this->db->where('page_id', $page);
        $this->db->update('pt_cms', $data);
    }

    function remove_from_footer($page, $menu) {
        $data = array('page_footer_order' => '0', 'page_footer_col' => '0');
        $this->db->where('page_id', $page);
        $this->db->update('pt_cms', $data);
    }

// Add page to selected menu
    function add_to_menu() {
        $pageids = $this->input->post('pages');
        $menu = $this->input->post('menu');
        $menutype = $this->input->post('menutype');
        $this->db->where('menu_id', $menu);
        $rs = $this->db->get('pt_menus')->result();
        $menuitems = json_decode($rs[0]->menu_items);
        $mitems = array();
        foreach ($menuitems as $marr) {
            $mitems[] = $marr->id;
            if (!empty ($marr->children)) {
                foreach ($marr->children as $ch) {
                    $mitems[] = $ch->id;
                }
            }
        }
        $this->data['menuarray'] = $mitems;
        foreach ($pageids as $page) {
            if (!in_array($page, $mitems)) {
                $newPage = new stdClass();
                $newPage->id = $page;
                $menuitems[] = $newPage;
            }
        }
        $string = json_encode($menuitems);
        $this->update_menu($string, $menu);
        $this->session->set_flashdata('flashmsgs', 'Menu Updated Successfully');
    }


// update menu items and order
    function update_menu($string, $menuid) {
        $data = array('menu_items' => $string);
        $this->db->where('menu_id', $menuid);
        $this->db->update('pt_menus', $data);

    }

    function get_page_details($pageid) {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title,pt_cms_content.content_special');
        $this->db->where('pt_cms_content.content_lang_id', DEFLANG);
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->where('pt_cms.page_id', $pageid);
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id','right');
        $query = $this->db->get('pt_cms');
        return $query->result();
    }

    function get_page_details_api($pageid,$lang) {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title,pt_cms_content.content_special');
        $this->db->where('pt_cms_content.content_lang_id', $lang);
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->where('pt_cms.page_id', $pageid);
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id','right');
        $res = $this->db->get('pt_cms')->result();
        if (!empty($res)) {
            $result = $res;
        }
        if (empty($result)) {
        $this->db->select('pt_cms.*,pt_cms_content.content_lang_id,pt_cms_content.content_page_title,pt_cms_content.content_special');
        $this->db->where('pt_cms_content.content_lang_id', 'en');
        $this->db->where('pt_cms.page_status', 'Yes');
        $this->db->where('pt_cms.page_id', $pageid);
        $this->db->group_by('pt_cms.page_id');
        $this->db->join('pt_cms_content', 'pt_cms.page_id = pt_cms_content.content_page_id','right');
        $ress = $this->db->get('pt_cms')->result();
        $result = $ress;
        }
        return $result;
    }

    /*cms details page api_function*/
    function get_cms_details($page_title,$lang) {
        // dd(pt_get_default_language());
        // DEFLANG
        $this->db->select('content_page_id');
        $this->db->like('pt_cms_content.content_page_title', $page_title);
        $page_id = $this->db->get('pt_cms_content')->row();
        // dd($page_id->content_page_id);
        $this->db->select('pt_cms_content.content_body,pt_cms_content.content_page_title,pt_cms_content.content_special,pt_cms_content.content_meta_keywords,pt_cms_content.content_meta_desc');
        $this->db->where('pt_cms_content.content_page_id', $page_id->content_page_id);
        $this->db->where('pt_cms_content.content_lang_id', $lang);
        $query = $this->db->get('pt_cms_content');
        return $query->row();
    }

    function child_page_active($pages) {
        $isactive = false;
        if (!empty ($pages)) {
            foreach ($pages as $page) {
                $this->db->where('page_status', 'Yes');
                $this->db->where('page_id', $page->id);
                $num = $this->db->get('pt_cms')->num_rows();
                if ($num > 0) {
                    $isactive = true;
                    break;
                }
                else {
                    $isactive = false;
                }
            }
        }
        return $isactive;
    }

    // Update translation of some fields data
    function update_translation($postdata,$id){

        foreach($postdata as $lang => $val){
            if(array_filter($val)){
                $title = $val['title'];

                $transAvailable = $this->getBackTranslation($lang,$id);

                if(empty($transAvailable)){
                    $data = array(
                        'trans_title' => $title,
                        'trans_menu_id' => $id,
                        'trans_lang' => $lang,

                    );
                    $this->db->insert('pt_menus_translation', $data);

                }else{
                    $data = array(
                        'trans_title' => $title,
                    );
                    $this->db->where('trans_menu_id', $id);
                    $this->db->where('trans_lang', $lang);
                    $this->db->update('pt_menus_translation', $data);
                }


            }

        }
    }

    function getBackTranslation($lang, $id) {
        $this->db->where('trans_lang', $lang);
        $this->db->where('trans_menu_id', $id);
        return $this->db->get('pt_menus_translation')->result();
    }

}