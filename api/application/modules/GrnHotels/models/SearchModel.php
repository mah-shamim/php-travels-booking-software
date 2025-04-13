<?php
class SearchModel
{
    public $form_type;
    public $form_source;

    public function __construct()
    {
        $this->form_type = "iframe";  // url , form , iframe
        $settings = app()->service("ModuleService")->get('travelpayouts')->settings;
        $url = $settings->WidgetURL;
        $this->form_source = '<script charset="utf-8" type="text/javascript" src="'.$url.'"></script>';
    }
}
