<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Check whether the site is offline or not.
 *
 */
class site_offline_hook{



    public function __construct()
    {
    log_message('debug','Accessing site_offline hook!');
    }

    public function is_offline()
    {
    if(file_exists(APPPATH.'config/config.php'))
    {
        include(APPPATH.'config/config.php');

          $CI = get_instance();

$site = $CI->db->select('offline_message,site_offline')->get('pt_app_settings')->result();
        if($site[0]->site_offline == "1")
        {

                $isadmin = $CI->uri->segment(1);

             if($isadmin == 'admin'){

             }else{

  $theme =  $CI->Settings_model->get_theme();
  $offlineMsg = $site[0]->offline_message;
    include("themes/$theme/views/home/offline.php");
  
        exit();


             }
        }
    }
    }


}
/* Location: ./system/application/hooks/site_offline_hook.php */