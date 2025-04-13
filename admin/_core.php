<?php

// ALL RIGHTS RESERVED TO PHPTRAVELS (C)

// USING MEEDO NAMESPACE
use Medoo\Medoo;
    
    // SESSION START
    session_start();
    
    // GENERATE CSRF TOKEN
    function CSRF(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    
    // ROOT FUNCTION
    $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST']; $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']); define('root', $root);
    
    // FUNCTION FOR DEBUG RESPONSES
    function dd($d) { echo "<pre>"; print_r($d); echo "</pre>"; die(); }
    
    // REDIRECTION
    function REDIRECT($url) { 
        echo '<script>window.location.replace("'.$url.'");</script>';
        die;
    }
    
    // ALERT MSG
    function ALERT_MSG($msg){
    echo '<script>sessionStorage.setItem("alert_msg", "'.$msg.'")</script>';
    }
    
    // GET GET FROM THE API
    function APIGET($endpoint){
    $params = array("api_key"=>api_key);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,root.api_url.$endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $response = curl_exec($ch);
    curl_close($ch);
    return (json_decode($response));
    }
    
    // POST DATA TO THE API
    function APIPOST($endpoint,$params){
    
    // ADD API KEY TO CALL 
    $params['api_key'] = api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,root.api_url.$endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $response = curl_exec($ch);
    curl_close($ch);
    return (json_decode($response));
    }

    // GET DATA FROM DB
    function blog_get($name,$params){
        require_once "../_config.php";
        $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
        $data = $db->select($name,"*", $params);
        return $data;
    }

    // GET DATA FROM DB
    function GET($name,$params){
        require_once "../_config.php";
        $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
        if (empty($id)) {$d = [ "ORDER" => "id" ]; } else { $d = [ "id" => $params ]; }
        $data = $db->select($name,"*", $params);
        $data1 = json_encode($data);
        $data2 = json_decode($data1);
        return $data2;
    }
    
    // UPDATE DB DATA
    function UPDATE($name,$params,$id){
        require_once "../_config.php";
        $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
        $data = $db->update($name,$params, [ "id" => $id ]);
        return $data;
    }
    
    // INSERT DB DATA
    function INSERT($name,$params){
        require_once "../_config.php";
        $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
        $data = $db->insert($name,$params);
        return $data;
    }

    // DELETE DB DATA
    function DELETE($name,$params){
        require_once "../_config.php";
        $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
        $data = $db->delete($name,$params);
        return $data;
    }

    // DELETE DB DATA
    function BALANCE_UPDATE($from_value,$from_currency){
    require_once "../_config.php";
    $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
    
    $response = $db->select("currencies","*", ["status"=>1,"name" => $from_currency]);
    $to_currency = $db->select("currencies","*", ["status"=>1,"default"=>1]);
    $price_get = (str_replace(',','',$from_value) / $response[0]['rate']);
    $price =  number_format((float)$price_get, 2, '.', '');

    return $price;
        
    }

    include "_mailer.php";
    
    // INSERT LOGS TO DB
    function logs($user_id,$log_type,$datetime,$desc){
    require_once "../_config.php";
    
    $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
    $db->insert("logs", [
    "user_ip" => $_SERVER['REMOTE_ADDR'],
    "user_id" => $user_id,
    "type" => $log_type,
    "datetime" => $datetime,
    "description" => $desc
    ]);
    
    }
    function AJAXMAIL($template,$title,$content,$receiver_email,$receiver_name){ 

    echo '<script>

    var formdata = new FormData();
    formdata.append("ajaxemail", "");
    formdata.append("title", "'.$title.'");
    formdata.append("template", "'.$template.'");
    formdata.append("email", "'.$receiver_email.'");
    formdata.append("first_name", "'.$receiver_name.'");
    formdata.append("content", "'.$content.'");

    var requestOptions = {
    method: "POST",
    body: formdata,
    redirect: "follow"
    };

    fetch("./_post.php", requestOptions)
    .then(response => response.text())
    .then(result => console.log(result))
    .catch(error => console.log("error", error))';

    echo '</script>';
    
    }
    
    function ENCODE($key){
    $code = base64_encode(json_encode($key));
    return $code;
    }
    
    function DECODE($key){
    $code = json_decode(base64_decode($key));
    return $code;
    }
    
    // INCLUDE LANGUAGE LIB
    require_once 'lib/i18n/i18n.class.php';
    $i18n = new i18n(__DIR__.'/../lang/{LANGUAGE}.json','./cache/','');
    
    if (isset($_SESSION['phptravels_backend_user'])){
        $USER_SESSION = (DECODE($_SESSION['phptravels_backend_user']));
    
        if (isset($USER_SESSION->backend_user_language)){
            $i18n->setForcedLang($USER_SESSION->backend_user_language);
        } else {
            $i18n->setForcedLang('us');
        }
        // SET LANGUAGE IN SESSION
        $i18n->init();        
    }

    
    // AUTH LOGGED CHECK
    function auth_check(){ 
    
        // CHECK USER EMAL AND ID EXIST IN DB VALIDATION BEFORE LOGIN
        // $db = new Medoo([ 'type' => 'mysql', 'host' => "localhost", 'database' => dbname, 'username' => username, 'password' => password ]);
        // $user = $db->query("SELECT * FROM `users` WHERE `email` LIKE '".$USER_SESSION->backend_user_email."' AND `user_id` LIKE '".$USER_SESSION->backend_user_id."'")->fetchAll();
    
        if (isset($_SESSION['phptravels_backend_user'])){
            $USER_SESSION = (DECODE($_SESSION['phptravels_backend_user']));
        }
        
        if(!isset($USER_SESSION->backend_user_login) == true ){ 
            header("location: login-logout.php"); 
        }
    }

    $pages = array(

        "admin" => array(
            "page_access"=>"",
        ),

        "dashboard" => array(
            "page_access"=>"",
        ), 

        "settings" => array(
            "page_access"=>"",
            "edit"=>""
        ), 
        
        "modules" => array(
            "page_access"=>"",
            "edit"=>""           
        ),

        "payment_gateways" => array(
            "page_access"=>"",
            "edit"=>""
        ),

        "currencies" => array(
            "page_access"=>"",
            "edit"=>"",
            "delete"=>""
        ),

        "email_settings" => array(
            "page_access"=>"",
            "edit"=>""
        ),

        "profile" => array(
            "page_access"=>"",
            "edit"=>""
        ),
            
        "markups" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
            "view"=>""
        ),

        "users" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "users_roles" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "cms" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),
        "blogs" => array(
            "page_access"=>"",
            "add"=>"",
            "edit"=>"",
            "delete"=>"",
        ),
        "logs" => array(
            "page_access"=>"",
            "edit"=>"", 
            "delete"=>"", 
            "view"=>""
        ),

        "locations" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),
             
        "languages" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "translations" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "listings" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "bookings" => array(
            "page_access"=>"",
            "edit"=>"", 
            "delete"=>"", 
        ),

        "reports" => array(
            "page_access"=>"",
        ),

        "transactions" => array(
            "page_access"=>"",
        ),

        "flights" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "flights_airports" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "flights_airlines" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "flights_featured" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "flights_suggestions" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "hotels" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "hotels_settings" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "hotels_suggestions" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "tours" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "tours_settings" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "tours_suggestions" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "cars" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "cars_settings" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "cars_suggestions" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "newsletter" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),

        "countries" => array(
            "page_access"=>"",
            "add"=>"", 
            "edit"=>"", 
            "delete"=>"", 
        ),
              
    );
    
?>