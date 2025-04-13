<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class AppSettingService
{
    const PATH = APPPATH . "json/app_settings.json";

    public function __construct()
    {
        $appsettings = file_get_contents($this::PATH);
        $this->settings = json_decode($appsettings);
    }

    public function getSpaSettings()
    {
        return $this->settings->spa_settings;
    }

    public function setSpaSettings($data)
    {
        $this->settings->spa_settings = $data;
        file_put_contents($this::PATH, json_encode($this->settings, JSON_PRETTY_PRINT));
    }

    public function getHomepageFeatureItems()
    {
        return $this->settings->homepage_feature_items;
    }

    public function setHomepageFeatureItems($data)
    {
        $this->settings->homepage_feature_items = $data;
        file_put_contents($this::PATH, json_encode($this->settings, JSON_PRETTY_PRINT));
    }
}