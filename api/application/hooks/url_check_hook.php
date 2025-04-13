<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Check whether the url is with www or without www
 *
 */
class url_check_hook{



    public function __construct()
    {
    log_message('debug','Accessing url_check hook!');
    }

    public function checkwww()
    {

      
        $CI = get_instance();
          
        $setting = $CI->db->select('site_url')->get('pt_app_settings')->row();
        $currencies = $CI->db->select('*')->where('is_default', 'Yes')->get('pt_currencies')->row();

//        $_SESSION['currencysymbol'] = $currencies->symbol;
//        $_SESSION['currencycode'] = $currencies->code;
//        $_SESSION['currencyname'] = $currencies->name;
//        $_SESSION['currencyrate'] = $currencies->rate;
//        dd($_SESSION);


//        $currUrl = base_url();
//        $uriString = uri_string();
//        $newUrlwithWWW = str_replace($_SERVER['HTTP_HOST'], "www.".$_SERVER['HTTP_HOST'],$currUrl);
//        $newUrlwithoutWWW = str_replace("www.", "",$currUrl);
//
//        $haswww = $this->hasWWW($currUrl);
//        $hasSiteUrlwww = $this->hasWWW($setting->site_url);
//        if($hasSiteUrlwww){
//          if($haswww){
//          // exit("no redirect");
//          }else{
//            header("HTTP/1.1 301 Moved Permanently");
//            redirect($newUrlwithWWW.$uriString);
//          // exit("do redirect to ".$newUrlwithWWW);
//          }
//
//        }else{
//
//        if($haswww){
//          header("HTTP/1.1 301 Moved Permanently");
//            redirect($newUrlwithoutWWW.$uriString);
//          //exit("redirect to ".$newUrlwithoutWWW);
//          }else{
//            //exit("no redirect");
//          }
//
//
//        }
    
    }

    function hasWWW($string){
    $urlstr =  explode(".",$string);
    if (strpos($urlstr[0], 'www') !== false) {

    return TRUE;

    }else{

    return FALSE;

    }

    }


}
/* Location: ./system/application/hooks/url_check_hook.php */