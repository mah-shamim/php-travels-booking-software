<?php

class Ptmodules
{
    protected $_ci = NULL;
    protected $_config = array();
    public $moduleslist = array();
    public $integratedmoduleslist = array();
    public $allmoduleslist = array();
    public $integratedmodules = array();
    public $notinclude = array();

    public function __construct()
    {
        $this->_ci = get_instance();
//        $this->list_modules();
//        $this->integrated_modules_list();
//        $this->all_modules();
//        $this->integrated_modules();
        $this->moduleslist = app()->service('ModuleService')->all();
        $this->notinclude = array("Blog");
        $this->excludedModules = []; // array("tripadvisor","newsletter","reviews","coupons");
    }

    function list_modules() {
            $this->_ci->load->helper('directory');
            $dirs = directory_map(APPPATH . 'modules', 2);
            foreach ($dirs as $d => $e) {
                    if (file_exists(APPPATH . 'modules/' . $d . '/config.php')) {
                            $this->moduleslist[] = $d;
                    }
            }
            return $this->moduleslist;
    }

    function integrated_modules_list() {
            $this->_ci->load->helper('directory');
            $dirs = directory_map(APPPATH . 'modules/', 2);
            foreach ($dirs as $d => $e) {
                    if (file_exists(APPPATH . 'modules/' . $d . '/config.php')) {
                            $this->integratedmoduleslist[] = $d;
                    }
            }
            return $this->integratedmoduleslist;
    }

    function all_modules() {
            $allmodules = array_merge($this->moduleslist, $this->integratedmoduleslist);
            $this->allmoduleslist = $allmodules;
            return $allmodules;
    }

    function integrated_modules() {
            $modules = $this->integratedmoduleslist;
            $this->_ci->load->helper('modules');
            foreach ($modules as $m) {
                    $isenabled = $this->is_main_module_enabled($m);
                    $isavailable = $this->is_module_available($m);
//   $isingration = $this->is_integration($m);
                    if ($isavailable) {
                            $modulesinfo = pt_get_file_data_modules(APPPATH . 'modules/' . $m . '/config.php');
                            $this->integratedmodules[] = $modulesinfo;
                    }
            }
            return $this->integratedmodules;
    }

    function read_config() {
             $this->_ci->load->helper('modules');
             $configdata = array();
             foreach ($this->moduleslist as $mods) {
                     $modulesinfo2 = pt_get_file_data_modules(APPPATH . 'modules/' . $mods . '/config.php');
                     $configdata[] = $modulesinfo2;
             }
             foreach ($this->integratedmoduleslist as $mods) {
                     $modulesinfo = pt_get_file_data_modules(APPPATH . 'modules/' . $mods . '/config.php');
                     $configdata[] = $modulesinfo;
             }
             return $configdata;
//        return $this->moduleslist;
    }

    function show_display_name($mod) {
            $this->_ci->load->helper('modules');
            if(in_array(ucfirst($mod),$this->integratedmoduleslist)){
                $modulesinfo = pt_get_file_data_modules(APPPATH . 'modules/' . $mod . '/config.php');
            }else{
                $modulesinfo = pt_get_file_data_modules(APPPATH . 'modules/' . $mod . '/config.php');
            }

            return $modulesinfo;
    }

    function has_integration() {
            $this->_ci->load->helper('modules');
            $hasintegration = false;
            foreach ($this->integratedmoduleslist as $mods) {
/* $isenabled = $this->is_main_module_enabled(strtolower($mods));
if($isenabled){*/
                    $modulesinfo = pt_get_file_data_modules(APPPATH . 'modules/' . $mods . '/config.php');
                    $chk = $modulesinfo['isIntegration'];
                    if ($chk == "Yes") {
                            $hasintegration = true;
                            break;
                    }
//  }
            }
            return $hasintegration;
/*
$chk =  pt_get_file_data_modules( APPPATH.'modules/ean/config.php' );
return $chk['isIntegration'];*/
    }

    function is_integration($mod) {
            $this->_ci->load->helper('modules');
/* $modulesinfo = pt_get_file_data_modules( APPPATH.'modules/'.$mod.'/config.php' );
$chk = $modulesinfo['isIntegration'];*/
// if($chk == "Yes"){
            if (in_array($mod, $this->integratedmoduleslist)) {
                    return true;
            }
            else {
                    return false;
            }
    }

    function is_module_available($modname) {
            $intmods = $this->integratedmoduleslist;
            $listmods = $this->moduleslist;
            $allmodules = array_merge($listmods, $intmods);
            if (in_array(ucfirst($modname), $allmodules)) {
                    return True;
            }
            else {
                    return False;
            }
    }

//    function disable_from_db($menutitle) {
//            $data1 = array('page_header_menu' => '0', 'page_status' => 'No');
//            $this->_ci->db->where("page_slug", $menutitle);
//            $this->_ci->db->or_where("module_dir_name", $menutitle);
//            $this->_ci->db->update("pt_cms", $data1);
//    }
//
    function is_main_module_enabled($module) {
            $this->_ci->db->select('page_id');
            $this->_ci->db->where('page_status', 'Yes');
            $this->_ci->db->where('page_slug', $module);
            $this->_ci->db->or_where('page_status', 'Yes');
            $this->_ci->db->where("module_dir_name", $module);
            $rows = $this->_ci->db->get('pt_cms')->num_rows();
            if ($rows > 0) {
                return true;
            }
            else {
                return false;
            }
    }



    function is_main_module_enabled_active($module){
        $this->_ci->db->select('is_active');
        $this->_ci->db->where('is_active', '1');
        $this->_ci->db->where('name', $module);
        $rows = $this->_ci->db->get('modules')->num_rows();
        if ($rows > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    function is_mod_available_enabled($module) {
            $enabled = $this->is_main_module_enabled_active($module);
            //$available = $this->is_module_available($module);
            if ($enabled) {
                    return True;
            }
            else {
                    return False;
            }
    }

    function get_enabled_modules(){
            $modules = $this->moduleslist;
            $enabled = array();
            foreach ($modules as $m) {
                    $isenabled = $this->is_main_module_enabled($m);
                    $isavailable = $this->is_module_available($m);
                    $isingration = $this->is_integration($m);
                    if ($isenabled && $isavailable && !$isingration) {
                            $enabled[] = $m;
                    }
            }
            return $enabled;
    }

    function list_all_modules() {
            $modules = $this->allmoduleslist;
            $result = array();

            foreach ($modules as $m) {
                    $isenabled = $this->is_main_module_enabled($m);
                    $isavailable = $this->is_module_available($m);
                    $isingration = $this->is_integration($m);
                    if ($isavailable) {
                            $result["response"][$m] = $isenabled;
                    }
            }
            return $result;
    }

    /**
     * Modules List
     *
     * @return array
     */
    public function listModuleForApi()
    {
        $result = array();
        // $all_module = ['hotels','flights','tours','cars','cruise','visa'];
        /*remove cruise*/
        $hotels =1; $flights =1; $tours =1; $cars =1; $visa =1; $cruise =1; $rental =1;
        $all_module = ['hotels','flights','tours','cars','visa'];
        foreach ($all_module as $modkey => $modvalue) {
        $this->_ci->db->select('is_active,order');
        $this->_ci->db->where('is_active', '1');
        $this->_ci->db->where('parent_id', $modvalue);
        $row = $this->_ci->db->get('modules')->result();
        if (!empty($row)) { $order = $row[0]->order;$status =  true;
            array_push($result, (object) array(
                "title" => strtolower($modvalue),
                "status" => $status,
                "order"=>$order,
                "parent_id"=>$modvalue));
        }
        }
        return $result;

        
        // $result = array();
        // foreach($this->moduleslist as $module)
        // {
        // array_push($result, (object) array(
        //     "title" => $module->name,
        //     "status" => ($module->active)?true:false));
        // }
        // return $result;
    }


    function extramodules(){
        $result = array();
        $all_extra = ['Newsletter','Coupons','Locations','Blog','Offers'];
        foreach ($all_extra as $modkey => $modvalue) {
            $this->_ci->db->select('is_active');
            $this->_ci->db->where('is_active', '1');
            $this->_ci->db->where('name', $modvalue);
            $rows = $this->_ci->db->get('modules')->num_rows();
            if ($rows > 0) { $status =  true;
                array_push($result, (object) array(
                    "title" => strtolower($modvalue),
                    "status" => $status));
            }

        }
        return $result;
    }

    function currencies(){
        $cur =  ptCurrencies();
       // dd($cur);
        $result = array();
        $count = 1;
        foreach ($cur as $cry){

            if($cry->is_default == 'Yes'){
                $status = true;
            }else{
                $status = false;
            }

            if($cry->is_active == 'Yes'){
                $status_active = true;
            }else{
                $status_active = false;
            }

            array_push($result, (object) array(
                "id" => $count,
                "name" =>$cry->name,
                "symbol" =>$cry->symbol,
                "code" =>$cry->code,
                "rate" =>$cry->rate,
                "decimals" =>$cry->decimals,
                "symbol_placement" =>$cry->symbol_placement,
                "primary_order" =>$cry->primary_order,
                "default" => $status,
                "status" =>$status_active,
            ));
            $count++;
        }
        return $result;
        }



	function _listModuleForApi() {
				$modules = $this->allmoduleslist;

				$result = array();
				$count = 0;
				$notinclude = array('tripadvisor');

				foreach ($modules as $m) {
						$isenabled = $this->is_main_module_enabled($m);


						$isavailable = $this->is_module_available($m);


						$isingration = $this->is_integration($m);

						if ($isavailable && !in_array($m,$notinclude)) {
							if($isenabled){
							$count++;

							}

								//$result["response"][$m] = $isenabled;
								$result[] = (object)array("title" => $m, "status" => $isenabled);
						}
				}


$this->_ci->load->model('Admin/Modules_model');

$othermodules =	$this->_ci->Modules_model->get_all_modules();
$notinc = array("newsletter","reviews","coupons");

foreach($othermodules as $omod){
	if(!in_array($omod->module_name, $notinc)){
	if($omod->module_status == "1"){
		$result[] = (object)array("title" => $omod->module_name, "status" => true);
		$count++;
	}
}

}



				//$result["response"]['othermocules'] = $othermodules;
              	return $result;
		}

    function modules_permissions($othermodules){
                $modules = $this->allmoduleslist;
				$result = array();
                $notinclude = array('Blog','Offers','Coupons');
			   	foreach($modules as $m){
						$isenabled = $this->is_main_module_enabled($m);
						$isavailable = $this->is_module_available($m);
						$isintegration = $this->is_integration($m);
						if ($isavailable && !$isintegration && !in_array($m,$notinclude)){
							$result[] = $m;
							}
				}

                foreach($othermodules as $md){
                  	if (!in_array($md->module_name,$notinclude)){
							$result[] = $md->module_name;
                            }
				}

              	return $result;
        }

    function supplierModulesPermission(){
                $modules = $this->moduleslist;
				$result = array();
                $notinclude = array('Blog','Offers','Coupons');
			   	foreach($modules as $m){
						$isenabled = isModuleActive($m->name);
						if ($isenabled && !in_array($m->name,$notinclude)){
							$result[] = $m->name;
						}
				}

               return $result;
        }
}
