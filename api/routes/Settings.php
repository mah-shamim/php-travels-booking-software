<?php

use Curl\Curl;

// ======================== MAIN SETTINGS 
$router->post('settings', function() {

    // INCLUDE CONFIG
    include "./config.php";
 
    $val = "business_name"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "api_secret_key"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "site_url"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "license_key"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "site_offline"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "offline_message"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "home_title"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "meta_description"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    
    $val = "guest_booking"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "user_registration"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "supplier_registration"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "agent_registration"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "javascript"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    
    $val = "multi_language"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "default_language"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "multi_currency"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    
    $val = "social_facebook"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "social_twitter"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "social_linkedin"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "social_instagram"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "social_google"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "social_whatsapp"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "social_youtube"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }

    // UPDATE SETTINGS
    $data = $db->update("settings", $data , [ "id" => 1, ]);

    if ($data->rowCount() == 1) {
    $respose = array ( "status"=>true, "message"=>"settings udpated", "data"=> $data );
    echo json_encode($respose);
    }
     
});

// ======================== MODULES
$router->post('modules', function() {
    
    // INCLUDE CONFIG
    include "./config.php";

    $data = $db->select("modules","*", [ ]);

    $respose = array ( "status"=>true, "message"=>"modules data", "data"=> $data );
    echo json_encode($respose);

});

// ======================== MODULES UPDATE
$router->post('modules_update', function() {
    
    // INCLUDE CONFIG
    include "./config.php";

    $data['status'] = $_POST['status'];
    $data = $db->update("modules", $data , [ "id" => $_POST['id'], ]);
    $respose = array ( "status"=>true, "message"=>"modules data", "data"=> $data );
    echo json_encode($respose);

});

// ======================== MODULE
$router->post('module', function() {
    
    // INCLUDE CONFIG
    include "./config.php";
    $data = $db->select("modules","*", [ "id" => $_POST['id'], ]);
    $respose = array ( "status"=>true, "message"=>"modules data", "data"=> $data );
    echo json_encode($respose);

});

// ======================== MODULES UPDATE
$router->post('module-update', function() {
    
    // INCLUDE CONFIG
    include "./config.php";

    $val = "c1"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "c2"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "c3"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "c4"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "dev_mode"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "payment_mode"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "module_color"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "currency"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
 
    $data = $db->update("modules", $data, [ "id" => $_POST['id'], ]);

    $respose = array ( "status"=>true, "message"=>"module data updated", "data"=> $data );
    echo json_encode($respose);

});

// ======================== GATEWAYS
$router->post('payment_gateways', function() {
    
    // INCLUDE CONFIG
    include "./config.php";
    $data = $db->select("payment_gateways","*", [ "ORDER" => "order", ]);
    $respose = array ( "status"=>true, "message"=>"modules data", "data"=> $data );
    echo json_encode($respose);

});

// ======================== MODULE
$router->post('payment_gateway', function() {
    
    // INCLUDE CONFIG
    include "./config.php";
    $data = $db->select("payment_gateways","*", [ "id" => $_POST['id'], ]);
    $respose = array ( "status"=>true, "message"=>"payment_gateway data", "data"=> $data );
    echo json_encode($respose);

});

// ======================== GATEWAY UPDATE
$router->post('payment_gateways_update', function() {
    
    // INCLUDE CONFIG
    include "./config.php";

    $data['status'] = $_POST['status'];
    $data = $db->update("payment_gateways", $data , [ "id" => $_POST['id'], ]);
    $respose = array ( "status"=>true, "message"=>"payment_gateways data", "data"=> $data );
    echo json_encode($respose);

});

// ======================== GATEWAY UPDATE
$router->post('payment_gateway_update', function() {
    
    // INCLUDE CONFIG
    include "./config.php";

    $val = "c1"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "c2"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "c3"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "c4"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
    $val = "dev_mode"; if(isset($_POST[$val]) || !empty($_POST[$val])) { $data[$val] = $_POST[$val]; }
 
    $data = $db->update("payment_gateways", $data, [ "id" => $_POST['id'], ]);

    $respose = array ( "status"=>true, "message"=>"payment gateway data updated", "data"=> $data );
    echo json_encode($respose);

});

// ======================== CURRENCIES
$router->post('currencies', function() {
    
    // INCLUDE CONFIG
    include "./config.php";
    $data = $db->select("currencies","*", [ "ORDER" => "id" ]);
    $respose = array ( "status"=>true, "message"=>"currencies data", "data"=> $data );
    echo json_encode($respose);

});

?>