<?php

class Modules_model extends CI_Model {

		function __construct() {
// Call the Model constructor
				parent :: __construct();
		}

		function get_all_modules() {
				$this->db->where('module_front !=', '2');
				return $this->db->get('pt_modules')->result();
		}

		function get_all_enabled_modules() {
				$this->db->where('module_status', '1');
				return $this->db->get('pt_modules')->result();
		}

// Get Enabled front end modules
		function get_front_modules() {
				$this->db->where('module_status', '1');
				$this->db->where('module_front', '1');
				$rs = $this->db->get('pt_modules')->result();
				return $rs;
		}
        public function add_module($post)
        {
            $inser_array = ["name"=>$post["name"],"is_active"=>$post["active"],"settings"=>json_encode($post)];
            $this->db->insert('modules',$inser_array);
        }
        public function update_module($post,$name)
        {
            $update_array = array("settings"=>json_encode($post));
            $this->db->where("name" , $name);
            $this->db->update('modules',$update_array);
        }

		function check_module($module) {
				return isModuleActive($module);
		}

//		function disable_module($name) {
//				$data = array('module_status' => '0');
//				$this->db->where('module_name', $name);
//				$this->db->update('pt_modules', $data);
//				$data2 = array('page_status' => 'No');
//				$this->db->where('page_slug', $name);
//				$this->db->update('pt_cms', $data2);
//		}
//
//		function enable_module($name) {
//				$data = array('module_status' => '1');
//				$this->db->where('module_name', $name);
//				$this->db->update('pt_modules', $data);
//				$data2 = array('page_status' => 'Yes');
//				$this->db->where('page_slug', $name);
//				$this->db->update('pt_cms', $data2);
//		}

//		function enable_main_module($menutitle) {
//				$notallowed = array("tripadvisor");
//				$this->db->select("page_id");
//				$this->db->where("page_slug", $menutitle);
//				$rs = $this->db->get('pt_cms')->result();
//				$pageid = $rs[0]->page_id;
//				$data1 = array('page_status' => 'Yes');
//				$this->db->where("page_slug", $menutitle);
//				$this->db->update("pt_cms", $data1);
//				if (!in_array($menutitle, $notallowed)) {
//						$this->db->where('coltype', 'header');
//						$menudetail = $this->db->get('pt_menus')->result();
//						$menuitems = json_decode($menudetail[0]->menu_items);
//						$p = array();
//						$c = array();
//						foreach ($menuitems as $mmm) {
//								$p[] = $mmm->id;
//								if (!empty ($mmm->children)) {
//										foreach ($mmm->children as $mc) {
//												$c[] = $mc->id;
//										}
//								}
//						}
//						$d = array_merge($p, $c);
//						if (!in_array($pageid, $d)) {
//								$addItem = new stdClass();
//								$addItem->id = $pageid;
//								$menuitems[] = $addItem;
//								$string = json_encode($menuitems);
//								$this->Menus_model->update_menu($string, $menudetail[0]->menu_id);
//						}
//				}
//		}

//		function disable_main_module($menutitle) {
//				$this->db->select("page_id");
//				$this->db->where("page_slug", $menutitle);
//				$rs = $this->db->get('pt_cms')->result();
//				$pageid = $rs[0]->page_id;
//				$data1 = array('page_status' => 'No');
//				$this->db->where("page_slug", $menutitle);
//				$this->db->update("pt_cms", $data1);
/*
$this->db->where('coltype','header');
$menudetail = $this->db->get('pt_menus')->result();
$mm = json_decode($menudetail[0]->menu_items);
foreach($mm as $k => $v){
if($v->id == $pageid){
unset($mm[$k]->id);
}
if(!empty($v->children)){

foreach($v->children as $kk => $vv){
if($vv->id == $pageid){
unset($v->children[$kk]->id);
}
}

}

}


$string = json_encode($mm);

$this->Menus_model->update_menu($string,$menudetail[0]->menu_id); */
		//}

// get modules names
		function get_module_names() {
		    $modules = app()->service('ModuleService')->getEnableModules();
		    return $modules;
//				$this->load->library('ptmodules');
//				$mod1 = $this->ptmodules->moduleslist;
//				$mod2 = $this->ptmodules->integratedmoduleslist;
//				$mergedmods = array_merge($mod1, $mod2);
//				return $mergedmods;
/*   $this->db->select('module_name');
$this->db->where('module_front','1');
$this->db->where('module_status','1');

return $this->db->get('pt_modules')->result();*/
		}

// check availability of main module
		function check_main_module($module) {
				return isModuleActive($module);
		}

//get selected module all items
		function get_module_items_all($module) {
				$rslt;
				if ($module == "hotels") {
						$this->db->select('hotel_id AS id,hotel_title AS title');
						$rslt = $this->db->get('pt_hotels')->result();
				}
				elseif ($module == "tours") {
						$this->db->select('tour_id AS id,tour_title AS title');
						$rslt = $this->db->get('pt_tours')->result();
				}
				elseif ($module == "cruises") {
						$this->db->select('cruise_id AS id,cruise_title AS title');
						$rslt = $this->db->get('pt_cruises')->result();
				}
				return $rslt;
		}

//get selected module all items of a user
		function get_supplier_module_items_all($module, $user) {
				$rslt;
				if ($module == "hotels") {
						$this->db->select('hotel_id AS id,hotel_title AS title');
						$this->db->where('hotel_owned_by', $user);
						$rslt = $this->db->get('pt_hotels')->result();
				}
				elseif ($module == "tours") {
						$this->db->select('tour_id AS id,tour_title AS title');
						$this->db->where('tour_owned_by', $user);
						$rslt = $this->db->get('pt_tours')->result();
				}
				elseif ($module == "cruises") {
						$this->db->select('cruise_id AS id,cruise_title AS title');
						$this->db->where('cruise_owned_by', $user);
						$rslt = $this->db->get('pt_cruises')->result();
				}
				return $rslt;
		}

//get selected module items
		function get_module_items($module) {
				$HTML = "";
				if ($module == "hotels") {
						$this->db->select('hotel_id AS id,hotel_title AS title');
						$this->db->order_by('hotel_id', 'desc');
						$rslt = $this->db->get('pt_hotels')->result();
						foreach ($rslt as $r) {
								$HTML .= "<option value='" . $r->id . "'>" . $r->title . "</option>";
						}
				}
				elseif ($module == "tours") {
						$this->db->select('tour_id AS id,tour_title AS title');
						$this->db->order_by('tour_id', 'desc');
						$rslt = $this->db->get('pt_tours')->result();
						foreach ($rslt as $r) {
								$HTML .= "<option value='" . $r->id . "'>" . $r->title . "</option>";
						}
				}
				elseif ($module == "cruises") {
						$this->db->select('cruise_id AS id,cruise_title AS title');
						$this->db->order_by('cruise_id', 'desc');
						$rslt = $this->db->get('pt_cruises')->result();
						foreach ($rslt as $r) {
								$HTML .= "<option value='" . $r->id . "'>" . $r->title . "</option>";
						}
				}
				return $HTML;
		}

//get selected module items for specific user
		function get_supplier_module_items($module, $id) {
				$HTML = "";
				if ($module == "hotels") {
						$this->db->select('hotel_id AS id,hotel_title AS title');
						$this->db->where('hotel_owned_by', $id);
						$this->db->order_by('hotel_id', 'desc');
						$rslt = $this->db->get('pt_hotels')->result();
						foreach ($rslt as $r) {
								$HTML .= "<option value='" . $r->id . "'>" . $r->title . "</option>";
						}
				}
				elseif ($module == "tours") {
						$this->db->select('tour_id AS id,tour_title AS title');
						$this->db->where('tour_owned_by', $id);
						$this->db->order_by('tour_id', 'desc');
						$rslt = $this->db->get('pt_tours')->result();
						foreach ($rslt as $r) {
								$HTML .= "<option value='" . $r->id . "'>" . $r->title . "</option>";
						}
				}
				elseif ($module == "cruises") {
						$this->db->select('cruise_id AS id,cruise_title AS title');
						$this->db->where('cruise_owned_by', $id);
						$this->db->order_by('cruise_id', 'desc');
						$rslt = $this->db->get('pt_cruises')->result();
						foreach ($rslt as $r) {
								$HTML .= "<option value='" . $r->id . "'>" . $r->title . "</option>";
						}
				}
				return $HTML;
		}

//get details of item of a given module
		function get_for_details($module, $id) {
				if ($module == "hotels") {
						$this->db->select('hotel_id,hotel_title,hotel_slug');
						$this->db->where('hotel_id', $id);
						$this->db->order_by('hotel_id', 'desc');
						$rslt = $this->db->get('pt_hotels')->result();
						$result['id'] = $rslt[0]->hotel_id;
						$result['title'] = $rslt[0]->hotel_title;
						$result['slug'] = "hotels/".$rslt[0]->hotel_slug;
				}
				elseif ($module == "tours") {
						$this->db->select('tour_id,tour_title,tour_slug');
						$this->db->where('tour_id', $id);
						$this->db->order_by('tour_id', 'desc');
						$rslt = $this->db->get('pt_tours')->result();
						$result['id'] = $rslt[0]->tour_id;
						$result['title'] = $rslt[0]->tour_title;
						$result['slug'] = "tours/".$rslt[0]->tour_slug;
				}
				elseif ($module == "cars") {
						$this->db->select('car_id,car_title,car_slug');
						$this->db->where('car_id', $id);
						$this->db->order_by('car_id', 'desc');
						$rslt = $this->db->get('pt_cars')->result();
						$result['id'] = $rslt[0]->car_id;
						$result['title'] = $rslt[0]->car_title;
						$result['slug'] = "cars/".$rslt[0]->car_slug;
				}
				elseif ($module == "cruises") {
						$this->db->select('cruise_id,cruise_title,cruise_slug');
						$this->db->where('cruise_id', $id);
						$this->db->order_by('cruise_id', 'desc');
						$rslt = $this->db->get('pt_cruises')->result();
						$result['id'] = $rslt[0]->cruise_id;
						$result['title'] = $rslt[0]->cruise_title;
						$result['slug'] = "cruises/".$rslt[0]->cruise_slug;
				}
				return $result;
		}


		function checkmodule($parent_id){
            $string = file_get_contents("https://travelapi.co/modules/modules.json");
            $json_a = json_decode($string, true);
            foreach ($json_a[$parent_id] as $chk) {
                $this->db->where('name',$chk);
                $this->db->where('parent_id',$parent_id);
                $rslt = $this->db->get('modules')->result();
                if(empty($rslt)){
                    if($parent_id == 'hotels') {
                        $parms = array(
                            'parent_id' => $parent_id,
                            'name' => $chk,
                            'is_active' => 0,
                            'settings' => '{"name":"'.$chk.'","label":"'.$chk.'","slug":"'.strtolower($chk).'","frontend":{"label":"Hotels","slug":"properties","icon":"hotel.png"},"description":"","active":0,"order":"7","menus":{"icon":"fa fa-building","admin":[{"label":"Bookings","link":"admin\/'.strtolower($chk).'\/bookings"},{"label":"Settings","link":"admin\/'.strtolower($chk).'\/settings"}],"supplier":[]}}',
                            'order' => 2,
                        );
                        $this->db->insert('modules', $parms);
                    }
                    if($parent_id == 'flights') {
                        $parms = array(
                            'parent_id' => $parent_id,
                            'name' => $chk,
                            'is_active' => 0,
                            'settings' => '{"name":"'.$chk.'","label":"'.$chk.'","slug":"'.strtolower($chk).'","test":"false","frontend":{"label":"Flights","slug":"flights","icon":"la la-plane"},"description":"","active":0,"order":"2","menus":{"icon":"fa fa-plane","admin":[{"label":"Settings","link":"admin/settings/modules/module_setting\/'.strtolower($chk).'\/"},{"label":"Bookings","link":"admin\/'.strtolower($chk).'\/bookings"}],"supplier":[]},"":null}',
                            'order' => 2,
                        );
                        $this->db->insert('modules', $parms);
                    }
                }
            }
        }


        function getmodule($module_id){
            $this->db->where('name',$module_id);
            $rslt = $this->db->get('modules')->result();
            return $rslt;
        }

    function getmodule_id($module_id){
        $this->db->where('id',$module_id);
        $rslt = $this->db->get('modules')->result();
        return $rslt;
    }
    function getmodulename($module_name){
        $this->db->where('name',$module_name);
        $rslt = $this->db->get('modules')->result();
        return $rslt;
		}

        function updatemodule_data($parm){
            $this->db->where('name',$parm['modulename']);
            $rslt = $this->db->get('modules')->result();
            unset($parm['modulename']);
            if(!empty($rslt)){
                $this->db->where('id',$rslt[0]->id);
                $this->db->update('modules', $parm);
            }

        }
}