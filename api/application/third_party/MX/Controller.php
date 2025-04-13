<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require_once dirname(__FILE__).'/Base.php';
require_once dirname(__FILE__).'/Collection.php';
		
class MX_Controller
{
    public $autoload = array();
    public $data = array();
    public $appSettings;
    public $App;
    public $ip;

    public function __construct()
    {

        /** load the CI class for Modular Extensions **/
        require_once dirname(__FILE__) . '/Base.php';
        require_once dirname(__FILE__) . '/Collection.php';

        $class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
        log_message('debug', $class . " MX_Controller Initialized");
        Modules::$registry[strtolower($class)] = $this;

        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader');
        $this->load->initialize($this);

        /* autoload module items */
        $this->load->_autoloader($this->autoload);
        if(CI::$APP->config->item('ban_ip') == 1) {
            $this->ip = $this->Settings_model->get_ip($_SERVER['HTTP_X_FORWARDED_FOR']);
        }else{
            $this->ip = '';
        }
        if ($this->ip->status != 'blocked') {
        $this->appSettings = $this->Settings_model->get_settings_data();
        $this->data['app_settings'] = $this->appSettings;
        $settings = (array)current($this->appSettings);
        $settings = new StdClass();
        $settings->active_link = strtolower($this->uri->segments[1]);
        $this->data['appSettings'] = $settings;

        $this->load->library('Browser');
        $browser = new Browser();
        $this->data['ismobile'] = $browser->isMobile();

        // App magic box
        $this->App = new Collection();
        // Bootstrap service providers
        $this->bootstrapServicesProvider();

        $this->data['modulesList'] = $this->App->service('ModuleService')->all_mod_front();
        $this->data['all_main'] = $this->App->service('ModuleService')->all_main();
        $enabledModules = $this->App->service('ModuleService')->getEnableModules();
        $this->data['theme_url'] = $this->theme->_data['theme_url'];


        //Order number sort
        $ordernumber = array();
        $modulesname = array();

        // echo "<pre>";
        // print_r($this->App->service('ModuleService')->all_mod_front());
        $hotels = 1; $flights = 1; $tours = 1; $visa = 1; $cars = 1; $rental = 1; $cruise = 1;
        foreach ($this->data['modulesList'] as $index => $module) {
            if ($module->ia_active == 1 && $module->parent_id == 'hotels' && $hotels == 1) {
                if ($module->name == 'Hotels') {
                    $modulename = 'Hotels';
                } else if ($module->name == 'Ean') {
                    $modulename = 'expedia';
                } else {
                    $modulename = $module->name;
                }
                array_push($ordernumber, $module->front_order);
                $namestore = array('link' => 'hotels', 'foldername' => 'hotels', 'name' => '0616', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                array_push($modulesname, $namestore);

            $hotels++;}
            if ($module->ia_active == 1 && $module->parent_id == 'flights' && $flights == 1) {
                if ($module->name == 'Flights') {
                    $modulename = 'Flights';
                } else {
                    $modulename = $module->name;
                }
                array_push($ordernumber, $module->front_order);
                $namestore = array('link' => 'flights', 'foldername' => 'flights', 'name' => '0564', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                array_push($modulesname, $namestore);
            $flights++;}
            if ($module->ia_active == 1 && $module->parent_id == 'tours' && $tours == 1) {
                if ($module->name == 'Tours') {
                    $modulename = 'standard';
                } else {
                    $modulename = $module->name;
                }
                array_push($ordernumber, $module->front_order);
                $namestore = array('link' => 'tours', 'foldername' => 'tours/' . $modulename . '', 'name' => '0279', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                array_push($modulesname, $namestore);
            $tours++;}
            if ($module->ia_active == 1 && $module->parent_id == 'visa' && $visa == 1) {
                if ($module->name == 'Ivisa') {
                    $modulename = 'standard';
                } else {
                    $modulename = $module->name;
                }
                array_push($ordernumber, $module->front_order);
                $namestore = array('link' => 'visa', 'foldername' => 'visa', 'name' => '0577', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                array_push($modulesname, $namestore);
            $visa++;}
            if ($module->ia_active == 1 && $module->parent_id == 'cars' && $cars == 1) {
                if ($module->name == 'Cars') {
                    $modulename = 'standard';
                } else {
                    $modulename = $module->name;
                }
                array_push($ordernumber, $module->front_order);
                $namestore = array('link' => 'cars', 'foldername' => 'cars/' . $modulename . '', 'name' => '0617', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                array_push($modulesname, $namestore);
            $cars++;}


            if ($module->ia_active == 1 && $module->parent_id == 'rental' && $rental == 1) {
                if ($module->name == 'Rentals') {
                    $modulename = $module->name;
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('link' => 'rentals', 'foldername' => 'rentals', 'name' => '0630', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                    array_push($modulesname, $namestore);
                }
            $rental++;}

            if ($module->ia_active == 1 && $module->parent_id == 'cruise' && $cruise == 1) {
                if ($module->name == 'Boats') {
                    $modulename = $module->name;
                    array_push($ordernumber, $module->front_order);
                    $namestore = array('link' => 'boats', 'foldername' => 'boats', 'name' => '0633', 'order' => $module->front_order, 'slug' => $module->slug, 'module_name' => $modulename, 'icon'=>$module->frontend->icon);
                    array_push($modulesname, $namestore);
                }
            $cruise++;}
        }

        $this->data['order'] = min($ordernumber);
        $this->data['modulesname'] = $modulesname;

        // for new menu
        $currentView = $settings->active_link;
        $firstModule = strtolower(current($enabledModules)->frontend->slug);
        if ($currentView == 'home') {
            $this->data['active_menu'] = $firstModule;
            $this->data['is_home'] = true;
        } elseif ($currentView == '' || strlen($currentView) == 2) { // locale string
            $this->data['active_menu'] = $firstModule;
            $this->data['is_home'] = true;
        } elseif (strpos($currentView, 'm-') !== false) {
            $this->data['active_menu'] = explode('-', $currentView)[1];
            $this->data['is_home'] = true;
        } else {
            $this->data['active_menu'] = $currentView;
            $this->data['is_home'] = false;
        }
    }else{
            echo "<style>body{font-family:calibri;padding:0px;margin:0px}.alert{background:#E60000;text-align:center;padding:35px;color:#fff}.box{height:24px;width:10%;position:relative:display:block}</style>";
            echo "<div class='alert'><h2>Your access has been blocked.</h2></div>";
            echo "<p style='text-align:center'>Contact the web master.</p>";
        }
}

	/**
	 * Bootstrape app service provider.
	 */
	public function bootstrapServicesProvider()
	{
		$this->load->helper('directory');
		$providers = directory_map(APPPATH.'/providers');
		foreach($providers as $provider) {
			include_once APPPATH.'/providers/'.$provider;
			$class = rtrim($provider, '.php');
			$providerObject = new $class();
			$providerObject->register($this->App);
		}
	}

	public function __get($class) {
		return CI::$APP->$class;
	}

	public function frontData(){
		//$this->data['lang_set'] = $this->theme->_data['lang_set'];

		$headerMenu = getHeaderMenu($this->data['lang_set']);


		$this->data['headerMenu'] = $headerMenu;
		$this->data['ishome'] = $this->uri->segment(1);
		$this->data['currenturl'] = uri_string();

		$this->data['isRTL'] = isRTL($this->data['lang_set']);
		$this->data['allowreg'] = $this->data['app_settings'][0]->allow_registration;
		$this->data['allowsupplierreg'] = $this->data['app_settings'][0]->allow_supplier_registration;
		$this->data['tripmodule'] = $this->ptmodules->is_mod_available_enabled("tripadvisor");
		$this->data['mSettings'] = mobileSettings();
		$this->data['footersocials'] = pt_get_footer_socials();
		$this->data['languageList'] = pt_get_languages();

		$ind_count = [];
		foreach ($this->data['footersocials'] as $index=>$value){
            array_push($ind_count,$index);
        }
        $this->data['socialcount'] = $ind_count;
		return $this->data;


	}

	public function setMetaData($title = null, $desc = null, $keywords = null ){

		if(empty($title)){
			$this->data['pageTitle'] = $this->appSettings[0]->home_title;
		}else{
			$this->data['pageTitle'] = $title;
		}

		if(empty($desc)){
			$this->data['metadescription'] = $this->appSettings[0]->meta_description;
		}else{
			$this->data['metadescription'] = $desc;
		}

		if(empty($keywords)){
			$this->data['metakeywords'] = $this->appSettings[0]->keywords;
		}else{
			$this->data['metakeywords'] = $keywords;
		}


	}
}

if ( ! function_exists('app')) 
{		
	function app()
	{
 		$MX = new MX_Controller();
		return $MX->App;
	}
}