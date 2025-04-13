<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed'); 

class ModuleServiceProvider
{
    public function register($App)
    {
        include_once APPPATH.'/services/ModuleService.php';
        $App->bind('ModuleService', new ModuleService());

        include_once APPPATH.'/services/AppSettingService.php';
        $App->bind('AppSettingService', new AppSettingService());
    }
}