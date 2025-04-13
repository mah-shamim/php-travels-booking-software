<?php
    use AppRouter\Router;

    // GET SERVER ROOT PATH
    $root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    define('root', $root);

    // DD FUNCTION FOR DEBUG RESPONSES
    function dd($d)
    {
        header("Content-Type: application/json");
        print_r($d);
        die;
    }

    // DD FUNCTION FOR DEBUG RESPONSES
    function pre($d)
    {
        echo "<pre style='line-height: 16px; font-weight: 700; font-family: inherit;'>";
        print_r($d);
        echo "</pre>";
    }

    // X-FRAME OPTIONS
    header("X-Frame-Options: SAMEORIGIN");

    // REDIRECT TO INSTALL
    if (!file_exists('_config.php')) {
        header('Location: ./install');
    }

    // CREATE CACHE AND LOGS IF NOT EXIST
    if (!file_exists('App/Logs')) {
        mkdir('App/Logs', 0777, true);
    }
    if (!file_exists('cache')) {
        mkdir('cache', 0777, true);
    }

    // CREATE HTACCESS FILE IF DOES NOT EXIST ON SERVER
    if (!file_exists('.htaccess')) {
        $content = 'RewriteEngine On' . "\n";
        $content .= 'RewriteCond %{REQUEST_FILENAME} !-d' . "\n";
        $content .= 'RewriteCond %{REQUEST_FILENAME} !-f' . "\n";
        $content .= 'RewriteCond %{REQUEST_FILENAME} !-l' . "\n\n";
        $content .= 'RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]';
        file_put_contents('.htaccess', $content);
        header('Location: ' . root);
    }

    // REDIRECT USER TO INSTALLER IF NO CONFIG FOUND
    if (!file_exists('_config.php')) {
        header('Location: ' . root . 'install');
    }

    // ENVIROMENT OF API SERVER
    define('ENVIRONMENT', 'production');


    $maxExecutionTime = ini_get('max_execution_time');
    if($maxExecutionTime == 30){
        echo "required max_execution_time 120";die;
    }


    // PHP CHECK VERSION IF BELOW v8
    $php = explode('.', phpversion()); 
    
    if ($php[0] < 8.0 ) {
    include "App/Views/php.php";
    die; } else {

    // MAIN APP CONFIG FILE
    require "vendor/autoload.php";
    require_once "_config.php";
    require_once "credentials.php";
    require "App/Lib/os.php";
    require "App/Lib/router.php";

    }
    
    session_start();
    
    // ERROR 404 PAGE
    $router = new Router(function ($method, $path, $statusCode, $exception) {
    http_response_code($statusCode);

    // META DETAILS
    $meta = array(
        "title" => "404",
        "meta_title" => "404",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    views($meta,"404");

    });

    function clean_var($value){
       $value= strtolower(str_replace(' ', '-', $value));
        return $value;
    }

    /* INIT MULTI LANG */
    require './App/Lib/I18n/i18n.class.php';
    $i18n = new i18n('./lang/{LANGUAGE}.json', './cache/', 'us');

    if (!isset($_SESSION['phptravels_client_language_country'])) {
        $i18n->setForcedLang('us');
        $i18n->init();
    } else {
        $i18n->setForcedLang($_SESSION['phptravels_client_language_country']);
        $i18n->init();
    }

    // SESSION SET DEFAULT LANGUAGE
    $router->get('/language/(.+)/(.+)/(.+)', function ($country, $name, $dir) {
        $_SESSION['phptravels_client_language_country'] = $country;
        $_SESSION['phptravels_client_language_name'] = $name;
        $_SESSION['phptravels_client_language_dir'] = $dir;
        REDIRECT(root);
    });

    // SESSION SET DEFAULT LANGUAGE
    $router->get('/(currency)/(.+)', function ($currency, $code) {
        $_SESSION['phptravels_client_currency'] = $code;
        if(!empty($_SESSION["data_flight"]) && !empty($_SESSION["url"])) {
            unset($_SESSION["data_flight"]);
            unset($_SESSION["url"]);
        }
        REDIRECT(root);
    });

    // DIRECTION FUNCTION
    function REDIRECT($url)
    {
        echo '<script>window.location.replace("' . $url . '");</script>';
        die;
    }

    // ALERT MSG
    function ALERT_MSG($msg)
    {
        echo '<script>sessionStorage.setItem("alert_msg", "' . $msg . '")</script>';
    }
    

    // PHP CHECK VERSION IF BELOW v8
    $php = explode('.', phpversion());
    if ($php[0] < 8) {
        // include "app/core/php.php";
        die;
    }

    $api_key = "api_key001";

    function base(){
        global $api_key;
        $params['api_key'] = $api_key;
        if(!empty( $_SESSION['phptravels_client_currency'])){
            $client_currency =  $_SESSION['phptravels_client_currency'];
            $params['currency'] = $client_currency;
        }

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, root . "api/app");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        // $response = curl_exec($ch);
        // curl_close($ch);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => root . "api/app",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $params,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;

        if (isset(json_decode($response)->data)){
            return json_decode($response)->data;
        } else {

            include "App/Controllers/DemoController.php";

            if($_SERVER['SERVER_NAME']=="phptravels.site" || $_SERVER['SERVER_NAME']=="phptravels.net"){
            echo "<style>body{gap:5px;background: #eee; display: flex; justify-content: center; align-items: center; font-family: system-ui; color: #0f1736;}</style>";
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
            echo "<title>No Response</title>";
            echo "NO RESPONSE FROM API SERVER";
            };
            die;
        }
    }    

    // SITE OFFLINE MESSAGE
    if(base()->app->site_offline==1){
        echo base()->app->offline_message;
        echo '<style>body{display: flex; justify-content: center; align-items: center; font-family: sans-serif;}</sctyle>';
        die;
    }

    function GET($endpoint){
        global $api_key;
        $params['api_key'] = $api_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, root . "./" . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    function POST($endpoint,$params){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => root . "./" . $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $params,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);

    }

    function POST_MODULES($endpoint,$params){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $params,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);

    }

    // AIRLINE LOGO FUNCTION
    function airline_logo($name){

        $url = "https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/";

        if (empty($name)){
            $img = root."assets/img/no_flight.png";
        } else {

            // SHOW MISSING AIRINES LOGOS
            if ($name=="G9"){
                $img = root."assets/img/airlines/G9.png";
            } else if ($name=="F3"){
                $img = root."assets/img/airlines/F3.png";
            }else {
                $img = $url.$name.".svg";
            }

        }

        return $img;
    }

    // ADD SESSION TO FUNCTION
    $_SESSION['app'] = base();

    // SET DEFAUT CURRENCY IF DOES NOT HAVE ONE
    if (!isset($_SESSION['phptravels_client_currency'])){
        foreach (app()->currencies as $currency){ if($currency->default == 1){ 
            $_SESSION['phptravels_client_currency'] = $currency->name; 
        } } 
    }

    define('currency',$_SESSION['phptravels_client_currency'] );
    define('dev', 0 );
    define('duration', 5 );

    function app(){ return $_SESSION['app']; }

    define('meta_url', "");
    define('meta_author', "");

    // DEFINE TEMAPLTE VIEWS
    define('invoice_layout', "App/Views/Invoice_layout.php");
    define('layout', "App/Views/Invoice_layout.php");

    function views($meta,$view){

        $body = "App/Views/".$view.".php";
        include "App/Views/Main.php";

    }

    $current_uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // GET CLIENT IP
    function user_ip(){

         $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'no-ip';
        return $ipaddress;
 
    }

    // SESSION VIEW AND DESTROY CONROLLERS
    $router->get('s', function () {
        echo "<pre>";
        json_decode(print_r($_SESSION));
    });
    
    $router->get('sd', function () {
        session_destroy();
        echo '
        <style>body{background:#545454;display:flex;justify-content:center;align-items: center;}</style>
        <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#fff"> <g fill="none" fill-rule="evenodd" stroke-width="2"> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> <circle cx="22" cy="22" r="1"> <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline" keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" /> <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0" calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1" repeatCount="indefinite" /> </circle> </g> </svg>
        <meta http-equiv="refresh" content="1; URL=' . root . '"/>';
    });

    // GENEARATE QR FOR INVOICE PAGE
    $router->post('qr', function () {
        define("QRSERVER", "https://api.qrserver.com/");
        function get_qr($to_encode) {
            $size = 100;
            $encode_d = urlencode($to_encode);
            return '<img src="'.QRSERVER.'v1/create-qr-code/?data='.$encode_d.'&size='.$size.'x'.$size.'" alt="'.$to_encode.'" title="'.$to_encode.'" />';
        }
            if($_POST['get_qr']) {
                echo get_qr($_POST['get_qr']);
            };
    });

    // EXTENSION CHECKUP
    // if (extension_loaded('soap')) {} else {
    //     dd("PHP EXT SOAP IS NOT ENABLED ON YOUR SERVER");
    // }

    // AUTOLOAD CONTROLLERS
    require_once "App/Controllers/HomeController.php";
    require_once "App/Controllers/HotelsController.php";
    require_once "App/Controllers/AccountsController.php";
    require_once "App/Controllers/BlogsController.php";
    require_once "App/Controllers/CarsController.php";
    require_once "App/Controllers/CmsController.php";
    require_once "App/Controllers/FlightsController.php";
    require_once "App/Controllers/GlobalController.php";
    require_once "App/Controllers/OffersController.php";
    require_once "App/Controllers/ToursController.php";
    require_once "App/Controllers/VisaController.php";
    require_once "App/Controllers/PaymentController.php";
    
    // DYNAMIC CONTROLLERS FOR PAYMENT GATEWAYS
    $controller = 'App/Controllers/Gateways';
    $indir = array_filter(scandir($controller), function ($item) use ($controller) {
        return !is_dir($controller . '/' . $item);
    });
    foreach ($indir as $key => $value) {
        include $controller . '/' . $value;
    }

    // GENERATE CSRF TOKEN
    function CSRF(){

        // dd($_REQUEST);
        // if ($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['form_token'] == $_POST['form_token'] ) {
        if (isset($_POST['form_token']) ) {
            if (isset($_POST["form_token"]) && isset($_SESSION["form_token"]) && $_POST["form_token"]==$_SESSION["form_token"]) {  
            } else {
                echo '<body style="background: #282828; color: #fff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; gap: 25px; text-decoration: none !important;">';
                echo '<p role="alert">Incorrect CSRF Token</p>';
                echo '<a style="text-decoration: none; color: #141414; background: orange; padding: 14px 25px; border-radius: 6px;" href="javascript:window.history.back();">Back</a>';
                echo '</body>';
                die;
            }
        }

        $_SESSION["form_token"] = bin2hex(random_bytes(32));
    }

    // MAIL SENDER FUNCTION
    function MAILER($template,$title,$content,$receiver_email,$receiver_name){

        $sender_name = base()->app->email_sender_name;
        $sender_email = base()->app->email_sender_email;
        $website_url = root.('../'); 

        ob_start();
        include "./email/".$template.".php";
        $views = ob_get_clean();

        $params = array(
        "api_key" => base()->app->email_api_key,
        "to" => array("".$receiver_name." <".$receiver_email.">"),
        "sender" => "".$sender_name." <".$sender_email.">",
        "subject" => $title,
        "html_body" => $views,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.smtp2go.com/v3/email/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $res = curl_exec($ch);
        curl_close($ch);
        // echo $res;

    }

    // STORE LOGS TO LOGGING FILE
    function logs($SearchType)
    {
        $log = "IP: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . '- Type => ' . $SearchType . ' - URL => ' . $_GET['url'] . PHP_EOL .
            "------------------------------------" . PHP_EOL;
        $logs_path = "App/Logs";
        if (!file_exists($logs_path)) {
            mkdir("App/Logs", 0777);
        } else {
        }
        ;
        file_put_contents('App/Logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);
    };

    // STORE SEARCHS TO SESSION
    function SEARCH_SESSION($MODULE, $CITY)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $b_ = (object) array($MODULE, $CITY, $actual_link);
        if (isset($_SESSION['SEARCHES'])) {
        } else {
            $_SESSION['SEARCHES'] = array();
        }
        array_push($_SESSION['SEARCHES'], $b_);
    };

    \Sentry\init(['dsn' => 'https://d6b14fcbf6e243e9be4bdd1d65a5c6ee@o4504935119060992.ingest.sentry.io/4504997467521025' ]);

    // try {
    //     $this->functionFailsForSure();
    // } catch (\Throwable $exception) {
    //     \Sentry\captureException($exception);
    // }

    $router->dispatchGlobal();