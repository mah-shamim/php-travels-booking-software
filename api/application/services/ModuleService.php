<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class ModuleService
{
    const DB_TABLE = 'modules';

    public function __construct()
    {
        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);
        $this->ci =& get_instance();

        $this->load->helper('file');
        $this->load->helper('directory');
//        $this->moduleDotJson = 'module.json';
//        $this->modulesDirPath = APPPATH . 'modules/';
//        $this->moduleDotJsonContent = $this->modulesDirPath . '%s/' . $this->moduleDotJson;
    }

    /**
     * Dump modules into database.
     *
     * @return array
     */
    public function dump()
    {
        $modules = directory_map($this->modulesDirPath, 2);
        $modulesConfigurations = array();
        foreach ($modules as $module => $moduleFiles)
        {
            if(in_array($this->moduleDotJson, $moduleFiles))
            {
                $configFile = sprintf($this->moduleDotJsonContent, $module);
                $configFileMetaData = read_file($configFile);
                $_module = json_decode($configFileMetaData);
                $_moduleName = strtolower($_module->name);
                $this->ci->db->where("LOWER(name) = '{$_moduleName}'", NULL, FALSE);
                $is_exist = $this->ci->db->get(self::DB_TABLE)->num_rows();
                if($is_exist <= 0) {
                    $this->ci->db->set('name', $_module->name);
                    $this->ci->db->set('is_active', $_module->active);
                    $this->ci->db->set('settings', $configFileMetaData);
                    $this->ci->db->insert(self::DB_TABLE);
                }
            }
        }
    }

    /**
     * Modules list with conifgurations detail.
     *
     * @return array
     */
    public function all()
    {
        if($this->ci->db->query("SHOW TABLES LIKE 'modules'")) {
            $modules = $this->ci->db->get(self::DB_TABLE)->result();
            $modulesConfigurations = array();
            foreach ($modules as $module)
            {
                $settings = json_decode($module->settings );
                $settings->id = $module->id;
                $settings->parent_id = $module->parent_id;
                $settings->ia_active = $module->is_active;
                if(empty($settings->is_delete))
                {
                    array_push($modulesConfigurations, $settings);
                }
            }
            // Sort modules in ascending order
            usort($modulesConfigurations, function($a, $b) {
                return $a->order - $b->order;
            });

            return $modulesConfigurations;
        }
        return [];
    }
       public function all_mod_front()
    {
        if($this->ci->db->query("SHOW TABLES LIKE 'modules'")) {
            $modules = $this->ci->db->order_by('order','asc')->get(self::DB_TABLE)->result();
            $modulesConfiger = array();
            foreach ($modules as $module)
            {
                  //max order for adding empty order ('-')
                $this->ci->db->select_max('order');
                $result =$this->ci->db->get('modules')->row();
                if (empty($module->order)) {$module->order = $result->order+1; }
                // if ($module->is_active == 1) {
                $settings = json_decode($module->settings);
                $settings->id = $module->id;
                $settings->parent_id = $module->parent_id;
                $settings->ia_active = $module->is_active;
                $settings->front_order = $module->order;
                if(empty($settings->is_delete))
                {
                    array_push($modulesConfiger, $settings);
                }
                // }


            }
            usort($modulesConfiger, function($a, $b) {
                return $a->front_order - $b->front_order;
            });
            return $modulesConfiger;
        }
        return [];
    }

    public function all_main()
    {
        $array = ['Hotels','Flights','Tours','Cars','Ivisa','Boats','Rentals'];
        $data = [];
       $return = $this->ci->db
       ->order_by('order','asc')
       ->get(self::DB_TABLE)
       ->result();
       if ($return) {
       foreach ($array as $key => $value) {
           foreach ($return as $module) {
           if ($module->name == $value) {
                array_push($data, 
                    array(
                        'parent_id'=>$module->parent_id,
                        'name'=>$module->name,
                        'order'=>$module->order));} } }
                usort($data, function($a, $b) {
                return $a->order - $b->order;
            });
        return $data;
    }
        return [];
    }

    function hotelmodules(){
        $return = $this->ci->db->where('parent_id','hotels')->order_by('order','asc')->get(self::DB_TABLE)->result();
        $data = [];
        foreach ($return as $module) {
            if ($module->name != 'Hotels' && $module->is_active == 1) {
                array_push($data,
                    array(
                        'name' => $module->name,
                    ));
            }
        }
        return $data;
    }

    function flightmodules(){
        $return = $this->ci->db->where('parent_id','flights')->order_by('order','asc')->get(self::DB_TABLE)->result();
        $data = [];
        foreach ($return as $module) {
            if ($module->name != 'Flights' && $module->is_active == 1) {
                array_push($data,
                    array(
                        'name' => $module->name,
                    ));
            }
        }
        return $data;
    }


    function tourmodules(){
        $return = $this->ci->db->where('parent_id','tours')->order_by('order','asc')->get(self::DB_TABLE)->result();
        $data = [];
        foreach ($return as $module) {
            if ($module->name != 'Tours' && $module->is_active == 1) {
                array_push($data,
                    array(
                        'name' => $module->name,
                    ));
            }
        }
        return $data;
    }

    function manaulmodules(){
        $return = $this->ci->db->where('name','Hotels')->order_by('order','asc')->get(self::DB_TABLE)->result();
        return $return;
    }

    function getmodulesdata($name){
        $return = $this->ci->db->where('name',$name)->order_by('order','asc')->get(self::DB_TABLE)->result();
        return $return;
    }

    public function all_mod_name()
    {
        $data = [];
        // $array = ['Hotels','Flights','Tours','Cars','Ivisa','Boats','Rentals','Offers'];
        /*remove Rentals and cruises*/
        $array = ['Hotels','Flights','Tours','Cars','Ivisa','Offers'];

        //max order for adding empty order ('-')
        $this->ci->db->select_max('order');
        $result =$this->ci->db->get('modules')->row();

            $active_mod = $this->ci->db
            ->select('parent_id,order,name')
            // ->where('is_active',1)
            ->order_by('order','asc')
            ->get(self::DB_TABLE)
            ->result();
        // $active_mod = '';
            foreach ($array as $key => $value) {
            foreach ($active_mod as $module) {
            if (empty($module->order)) {$module->order = $result->order+1;}
            if ($module->name == $value) {
            array_push($data,(object)[
                'parent_id'=>$module->parent_id,
                'order'=>$module->order
            ]);}}}
            usort($data, function($a, $b) {
                return $a->order - $b->order;
            });

            return $data;

    }

    /**
     * Modules menu check.
     *
     * @return array
     */
    public function check($name)
    {
        $this->ci->db->where('name',$name);
        return $this->ci->db->get('modules')->result();

    }

    /**
     * Get all enabled modules list
     *
     * @return array
     */
    public function getEnableModules()
    {
        $excludedModules = ['Blog','Offers','Newsletter','Reviews','Locations', 'Coupons'];
        $modules = $this->ci->db->where('is_active', 1)->where_not_in('name', $excludedModules)->get(self::DB_TABLE)->result();
        $modulesConfigurations = array();
        foreach ($modules as $module)
        {
            array_push($modulesConfigurations, json_decode($module->settings));
        }
        // Sort modules in ascending order
        usort($modulesConfigurations, function($a, $b) {
            return $a->order - $b->order;
        });
        return $modulesConfigurations;
    }

    /**
     * Get enabled modules list for quick booking.
     *
     * @return array
     */
    public function getQuickBookingModules()
    {
        $modules = $this->ci->db->where('is_active', 1)->get(self::DB_TABLE)->result();
        $modulesConfigurations = array();
        foreach ($modules as $module)
        {
            if (in_array(strtolower($module->name), ['cars','hotels','tours'])) {
                array_push($modulesConfigurations, json_decode($module->settings));
            }
        }
        // Sort modules in ascending order
        usort($modulesConfigurations, function($a, $b) {
            return $a->order - $b->order;
        });
        return $modulesConfigurations;
    }

    /**
     * Get single module
     *
     * @return array
     */
    public function get($module)
    {
        $module = $this->ci->db->where("LOWER(name) = '{$module}'", NULL, FALSE)->get(self::DB_TABLE)->row();
        return json_decode($module->settings);
    } 

    public function getstatus($parentid,$modulename,$status)
    {
        $module = $this->ci->db->where("parent_id = '{$parentid}'", NULL, FALSE)->get(self::DB_TABLE)->result();
        if($parentid != 'extra'){
        foreach ($module as $modelll){
            if($modulename == $modelll->name && $status != 'false'){
                $settings = $this->get($modulename);
                $settings->active = 1;
                $this->ci->db->set('is_active', 1);
                $this->ci->db->set('settings', json_encode($settings));
                $this->ci->db->where("LOWER(name) = '{$modulename}'", NULL, FALSE);
                $this->ci->db->update(self::DB_TABLE);
            }else{
                if($parentid != 'extra' && $modulename == $modelll->name && $status == 'false') {
                    $settings = $this->get($modelll->name);
                    $settings->active = 0;
                    $this->ci->db->set('is_active', 0);
                    $this->ci->db->set('settings', json_encode($settings));
                    $this->ci->db->where("LOWER(name) = '{$modelll->name}'", NULL, FALSE);
                    $this->ci->db->update(self::DB_TABLE);
                }
            }
        }
        }else{
            if($status != 'false'){
                $settings = $this->get($modulename);
                $settings->active = 1;
                $this->ci->db->set('is_active', 1);
                $this->ci->db->set('settings', json_encode($settings));
                $this->ci->db->where("LOWER(name) = '{$modulename}'", NULL, FALSE);
                $this->ci->db->update(self::DB_TABLE);
            }else{
                $settings = $this->get($modulename);
                $settings->active = 0;
                $this->ci->db->set('is_active', 0);
                $this->ci->db->set('settings', json_encode($settings));
                $this->ci->db->where("LOWER(name) = '{$modulename}'", NULL, FALSE);
                $this->ci->db->update(self::DB_TABLE);
            }

        }

    }

    /**
     * Enable module.
     *
     * @param  string
     * @return array
     */
    public function enable($module)
    {
        $settings = $this->get($module);
        $settings->active = 1;
        $this->ci->db->set('is_active', 1);
        $this->ci->db->set('settings', json_encode($settings));
        $this->ci->db->where("LOWER(name) = '{$module}'", NULL, FALSE);
        return $this->ci->db->update(self::DB_TABLE);
    }

    /**
     * Disable module.
     *
     * @param  string
     * @return array
     */
    public function disable($module)
    {
        $settings = $this->get($module);
        $settings->active = 0;
        $this->ci->db->set('is_active', 0);
        $this->ci->db->set('settings', json_encode($settings));
        $this->ci->db->where("LOWER(name) = '{$module}'", NULL, FALSE);
        return $this->ci->db->update(self::DB_TABLE);
    }

    /**
     * Update module by key and value.
     *
     * @param  string
     * @return array
     */
    public function update($module, $key, $val)
    {
        $settings = $this->get($module);
        $settings->{$key} = $val;
        $this->ci->db->set('settings', json_encode($settings));
        $this->ci->db->where("LOWER(name) = '{$module}'", NULL, FALSE);
        return $this->ci->db->update(self::DB_TABLE);
    }

    /**
     * Is module active or not.
     *
     * @param  string
     * @return array
     */
    public function isActive($module)
    {
        $this->ci->db->where("LOWER(name) = '{$module}'", NULL, FALSE);
        $is_active = $this->ci->db->get(self::DB_TABLE)->row()->is_active;
        return (!empty($is_active))?$is_active:"";
    }

    /**
     * Move up in order.
     *
     * @param  string
     * @return array
     */
    public function moveup($moduleName)
    {
        $allModules = $this->all();
        $currentModule = NULL;
        foreach($allModules as $module) {
            if(strtolower($module->name) == strtolower($moduleName)) {
                if( ! empty($currentModule) ) {
                    $this->update($moduleName, 'order', $currentModule->order);
                    $this->update($currentModule->name, 'order', $module->order);
                    break;
                }
            } else {
                $currentModule = $module;
            }
        }
    }

    /**
     * Move down in order.
     *
     * @param  string
     * @return array
     */
    public function movedown($moduleName)
    {
        $allModules = $this->all();
        foreach($allModules as $key => $module) {
            if(strtolower($module->name) == strtolower($moduleName) && isset($allModules[$key + 1])) {
                $nextModule = $allModules[$key + 1];
                if( ! empty($nextModule) ) {
                    $this->update($moduleName, 'order', $nextModule->order);
                    $this->update($nextModule->name, 'order', $module->order);
                    break;
                }
            }
        }
    }

    /*Set Order Modules */
    public function setorder($modulename,$order){
        $this->update($modulename, 'order', $order);
    }

    //Add page module
    public function addpagemodule($name,$parentid)
    {
        $allModules = $this->all();
        foreach ($allModules as $module){
            if($module->name == $name){
                $this->ci->db->where('content_page_title', $name);
                $check = $this->ci->db->get('pt_cms_content')->result();
                if (empty($check)) {
                    $pageadd = array(
                        'page_slug' => $name,
                        'slug_status' => 1,
                        'page_status' => 'Yes',
                        'page_target'=>'_self'

                    );
                    $this->ci->db->insert('pt_cms', $pageadd);
                    $data = array(
                        'content_page_id' =>$this->ci->db->insert_id(),
                        'content_lang_id' => 'en',
                        'content_page_title' => $name,
                        'content_special' => 2
                    );
                    $this->ci->db->insert('pt_cms_content', $data);
                }else{
                    if($name != 'Blog' && $name != 'Offers') {
                        $this->ci->db->where('page_slug', $name);
                        $this->ci->db->delete('pt_cms');
                        $this->ci->db->where('content_page_title', $name);
                        $this->ci->db->delete('pt_cms_content');
                    }else if($name == 'Blog' || $name == 'Offers'){
                        $this->ci->db->where('page_slug', $name);
                        $this->ci->db->delete('pt_cms');
                        $this->ci->db->where('content_page_title', $name);
                        $this->ci->db->delete('pt_cms_content');
                    }
                }
            }else{
                if($module->parent_id == $parentid) {
                    if($name != 'Blog' && $name != 'Offers') {
                        $this->ci->db->where('page_slug', $module->name);
                        $this->ci->db->delete('pt_cms');
                        $this->ci->db->where('content_page_title', $module->name);
                        $this->ci->db->delete('pt_cms_content');
                    }
                }
            }
        }

    }

    /*Reset Order Modules */
  public function resetorder(){
    $allModules = $this->all();
    $i = 0;
    foreach($allModules as $key => $module) {
        $i++;
        $this->update($module->name, 'order',$i);
    }
  
  }

}