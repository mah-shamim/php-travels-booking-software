<?php

use Medoo\Medoo;

// ======================== SIGNUP
$router->post('signup', function() {

    // INCLUDE CONFIG
    include "./config.php";

        // VALIDATION
        required('first_name'); 
        required('last_name'); 
        required('phone'); 
        required('phone_country_code'); 
        required('email'); 
        required('password');
 
        $mob = $new_str = str_replace(' ', '', $_POST['phone']); 
        $phone = preg_replace('/[^A-Za-z0-9\-]/', '', $mob); // removes special chars.
 
        // EMAIL EXIST VALIDATION
        $exist_mail = $db->select('users', [ 'email', ], [ 'email' => $_POST['email'], ]);
        if (isset($exist_mail[0]['email'])) { 
            $respose = array ( "status"=>false, "message"=>"email already exist.", "data"=> "" );
            echo json_encode($respose);
            die;
        }

        // GENERATE RANDOM CODE FOR EMAIL
        $mail_code = rand(100000, 999999);

        // UUID
        $rand = rand(100, 99);
        $date = date('Ymdhis');
        $user_id = $date.$rand;

        // GENERATE PASSWORD AND DATETIME
        $password = md5($_POST['password']);
        $date = date('Y-m-d H:i:s');

        // GET DEFAULT CURRENCY NAME
        $currencies = $db->select("currencies","*" );
        foreach ($currencies as $currency){ if($currency['default'] == 1){ $currency_id = $currency['name']; } }

        $db->insert("users", [
            "user_id" => $user_id,
            "first_name" => $_POST['first_name'],
            "last_name" => $_POST['last_name'],
            "phone_country_code" => $_POST['phone_country_code'],
            "email" => $_POST['email'],
            "phone" => $phone,
            "email_code" => $mail_code,
            "currency_id" => $currency_id,
            "password" => $password,
            "status" => $_POST['status']??0,
            "user_type" => "Customer",
            "created_at" => $date,
        ]);

        $user_id_ = $db->id();
        $user_info = $db->select("users","*", [ "id" => $user_id_ ]);

        $respose = array ( "status"=>true, "message"=>"account registered successfully.", "data"=> $user_info );
        echo json_encode($respose);

        $link = root.'../'.'account/activation/'.$user_id.'/'.$mail_code;

        // HOOK 
        $hook="user_signup";
        include "./hooks.php";

});
// ======================== SIGNUP

// ======================== ACCOUNT ACTIVATION
$router->post('activation', function() {

    // INCLUDE CONFIG
    include "./config.php"; 
    
    required('user_id'); 
    required('email_code');

    $user = $db->select("users","*", [ "user_id" => $_POST['user_id'] ]);
    
    if (isset($user[0]['status'])){
    if ($user[0]['status'] == !1){

        // HOOK 
        $hook="account_activated";
        include "./hooks.php";

        $data = $db->update("users", [ "status" => 1, ], [
        "user_id" => $_POST['user_id'],
        "email_code" => $_POST['email_code'],
        ]);

    }} 

    $respose = array ( "status"=>true, "message"=>"account activated", "data"=> $user );
    echo json_encode($respose);

});

// ======================== LOGIN
$router->post('login', function() {

    // INCLUDE CONFIG
    include "./config.php";

    // VALIDATION
    required('email'); 
    required('password');

    $data = $db->select("users","*", [
        "email" => $_POST['email'],
        "password" => md5($_POST['password']),
    ]);

    
    if(isset($data[0])) { 
    
        if ($data[0]['status'] == 0) {
            $respose = array ( "status"=> false, "message"=>"user account not verified", "data"=> $data[0] );
            echo json_encode($respose);
            die;
        }; 

        $user_data = (object)$data[0]; 
        $respose = array ( "status"=> true, "message"=>"user details", "data"=> $user_data );

        if (isset($user_data)){
        if ($user_data->status == 1){

        // HOOK 
        $hook="login";
        include "./hooks.php";
        
        }}

        // INSERT TO LOGS
        $user_id = $user_data->user_id;    
        $log_type = "login";
        $datetime = date("Y-m-d h:i:sa");
        $desc = "user logged into account" .get_client_ip();
        logs($user_id,$log_type,$datetime,$desc);

        include "./logs.php";

    } else {
    $respose = array ( "status"=>false, "message"=>"no user found", "data"=> null );
}

echo json_encode($respose);

});

// ======================== FORGET PASSWORD
$router->post('forget_password', function() {

    // INCLUDE CONFIG
    include "./config.php";

    required('email');

    // CHECK EMAIL
    $user = $db->select("users", "*", [ "email" => $_POST['email'] ]);

        if (isset($user[0]['status'])) {

            if ($user[0]['status'] == 1) {

                // CHANGE PASSWORD
                $newpass = rand(100000, 999999);
                $data = $db->update("users", [
                "password" => md5($newpass),
                ], [ "email" => $_POST['email'], ]);

                // IF UPDATED SUCCESSFULLY
                if ($data->rowCount() == 1) {

                    $respose = array ( "status"=>true, "message"=>"password has been sent to email", "data"=> $data );

                    // HOOK 
                    $hook="forget_password";
                    include "./hooks.php";
                
                }

            } else {
                $respose = array ( "status"=>"none", "message"=>"not_activated", "data"=> null );
            }
        } else {
            $respose = array ( "status"=>false, "message"=>"no user found", "data"=> null );
        }

    echo json_encode($respose);

});


// ======================== GET PROFILE DATA
$router->post('profile', function() {

    // INCLUDE CONFIG
    include "./config.php";
    required('user_id');

    // USERS
    $data = $db->select("users", "*", ["user_id" => $_POST['user_id'],]);
    if (!empty($data)) {
        $respose = array("status" => "true", "message" => "profile details", "data" => $data);
    } else {
        $respose = array("status" => "false", "message" => "no profile found", "data" => "");
    }
    echo json_encode($respose);

});

// ======================== PROFILE UPDATE
$router->post('profile_update', function() {

    // INCLUDE CONFIG
    include "./config.php";

    required('user_id'); 
    required('first_name'); 
    required('last_name'); 
    required('email'); 
    required('phone'); 
    required('phone_country_code'); 
    required('country_code'); 

    // PASSWORD CONDITION
    if(!empty($_POST['password'])) { $password = $_POST['password']; } else { $password = ""; }

    // USER UPDATE
    $data = $db->update("users", [ 
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "email" => $_POST['email'],
        "phone" => $_POST['phone'],
        "password" => md5($_POST['password']),
        "phone_country_code" => $_POST['phone_country_code'],
        "country_code" => $_POST['country_code'],
        "state" => $_POST['state'],
        "city" => $_POST['city'],
        "address1" => $_POST['address1'],
        "address2" => $_POST['address2'],
     ], [
        "user_id" => $_POST['user_id'],
    ]);

    $respose = array ( "status"=>"true", "message"=>"profile updated", "data"=> $data );
    echo json_encode($respose);

});

// ======================== PROFILE UPDATE
$router->post('wallet_booking', function() {

    // INCLUDE CONFIG
    include "./config.php";

    required('user_id'); 
    required('price'); 
    required('currency'); 

    // USER UPDATE
    $data = $db->update("users", [ 
        "balance[-]" => $_POST['price'],
     ], [
        "user_id" => $_POST['user_id'],
    ]);

    // USER TRX INSERT
    $data = $db->insert("transactions", [ 
        "description" => "purchased with balance",
        "type" => "purchase",
        "amount" => $_POST['price'],
        "user_id" => $_POST['user_id'],
        "currency" => $_POST['currency'],
        "payment_gateway" => "wallet_balance",
        "date" =>date('Ymdhis'),
    ]);

    $respose = array ( "status"=>"true", "message"=>"balance updated", "data"=> $data );
    echo json_encode($respose);

});

// ======================== PROFILE UPDATE
$router->post('user_bookings', function() {

    // INCLUDE CONFIG
    include "./config.php";
    required('user_id'); 
   
    // $params = array(
    //     "user_id" => $_POST['user_id'],
    //     "ORDER" => [ "id" => "DESC", ],
    //     "LIMIT" => 500
    // );


    // PARAMS
    $params = array(
        "user_id" => $_POST['user_id'],
        "ORDER" => [ "booking_id" => "DESC", ],
        "LIMIT" => 250
    );

    // LOCATIONS
    $data['flights'] = $db->select("flights_bookings","*", $params );


    // USER UPDATE
    $data['hotels'] = $db->select("hotels_bookings","*",[ "user_id"=>$_POST['user_id'] ]);
    $data['tours'] = $db->select("tours_bookings","*",[ "user_id"=>$_POST['user_id'] ]);
    $data['cars'] = $db->select("cars_bookings","*",[ "user_id"=>$_POST['user_id'] ]);
    $data['visa'] = $db->select("visa_bookings","*",[ "user_id"=>$_POST['user_id'] ]);

        // $params = array( "status" => 1, "ORDER" => [ "order" => "DESC", ], "LIMIT"=>[0,50] );

    $respose = array ( "status"=>"true", "message"=>"available user bookings", "data"=> $data );
    echo json_encode($respose);

});

// ======================== PROFILE UPDATE
$router->get('traffic', function() {

    // INCLUDE CONFIG
    include "./config.php";
    // required('country'); 
   
    // TRAFFIC UPDATE
    $data = $db->update("countries", [ 
        "traffic[+]" => 1,
     ], [
        "nicename" => $_GET['country'],
    ]);

 
    $respose = array ( "status"=>"true", "message"=>"available user bookings", "data"=> $data );
    echo json_encode($respose);

});

?>