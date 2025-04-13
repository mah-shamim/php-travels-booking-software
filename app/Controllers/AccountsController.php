<?php


// ======================================================== SIGNUP GET
$router->get('signup', function() {

    CSRF();

    // META DETAILS
    $meta = array(
        "title" => T::signup,
        "meta_title" => T::signup,
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    // GET COUNTRIES FROM THE API
    $meta['countries'] = (GET(api_url."countries"));

    views($meta,"Accounts/Signup");

});
// ======================================================== SIGNUP GET


// ======================================================== SIGNUP POST
$router->post('signup', function() {

    CSRF();

    $params = array(
        "api_key" => api_key,
        "first_name" => $_REQUEST['first_name'],
        "last_name" => $_REQUEST['last_name'],
        "phone" => $_REQUEST['phone'],
        "phone_country_code" => $_REQUEST['phone_country_code'],
        "email" => $_REQUEST['user_email'],
        "password" => $_REQUEST['password'],
    );

    // SIGNUP POST 
    $res = POST(api_url.'signup', $params);

    if ($res->status == 1) {
        REDIRECT(root . 'signup_success');
    } else {
        ALERT_MSG('account_exist');
        REDIRECT(root . 'signup');
    }
 
});
// ======================================================== SIGNUP POST


// ======================================================== SOCIAL SIGNUP POST
$router->post('socialsignup', function() {

    CSRF();
    
    $params1 = array(
        "api_key" => api_key,
        "first_name" => $_REQUEST['first_name'],
        "last_name" => $_REQUEST['last_name'],
        "phone" => $_REQUEST['phone'],
        "phone_country_code" => $_REQUEST['phone_country_code'],
        "email" => $_REQUEST['email'],
        "password" => $_REQUEST['password'],
        "status"=>$_REQUEST['status']
    );


    // SOCIAL SIGNUP POST 
    $res1 = POST(api_url.'signup', $params1);
    if($res1->status == 1){
        
        $params2 = array(
            "api_key" => api_key,
            "email" => $_REQUEST['email'],
            "password" => $_REQUEST['password'],
        );
        $res2 = POST(api_url.'login',$params2);
        
        if (isset($res2->data->user_id)) {

            // IF ACCOUNT STATUS IS 1 REDIRECT TO DASHBOARD
            if ($res2->data->status == 1) {
                $_SESSION['phptravels_client'] = $res2->data;
                echo json_encode(['redirect'=>'dashboard','alert'=>'']);
            } else {

                // IF ACCOUNT STATUS IS 0 SHOW MSG
                echo json_encode(['redirect'=>'login','alert'=>'not_active']);
            }
        } else {
            // IF NO ACCOUNT EXIST SHOW MSG AND RETURN TO LOGIN
            echo json_encode(['redirect'=>'login','alert'=>'invalid_login']);
        }

    }else{
        $params3 = array(
            "api_key" => api_key,
            "email" => $_REQUEST['email'],
            "password" => $_REQUEST['password'],
        );
        $res3 = POST(api_url.'login',$params3);

        // CONDITION IF RETURNS USER ID UPON REQUEST
        if (isset($res3->data->user_id)) {

            // IF ACCOUNT STATUS IS 1 REDIRECT TO DASHBOARD
            if ($res3->data->status == 1) {
                $_SESSION['phptravels_client'] = $res3->data;
                echo json_encode(['redirect'=>'dashboard','alert'=>'']);
            } else {

                // IF ACCOUNT STATUS IS 0 SHOW MSG
                echo json_encode(['redirect'=>'login','alert'=>'not_active']);
            }
        } else {
            // IF NO ACCOUNT EXIST SHOW MSG AND RETURN TO LOGIN
            echo json_encode(['redirect'=>'login','alert'=>'invalid_login']);
        }
        // echo json_encode(['redirect'=>'signup','alert'=>'account_exist']);
    }

 
});
// ======================================================== SOCIAL SIGNUP POST

// ======================================================== SIGNUP GET SUCCESS
$router->get('signup_success', function() {

    // META DETAILS
    $meta = array(
        "title" => T::signup." Success",
        "meta_title" => T::signup." Success",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    views($meta,"Accounts/Signup_success");

});
// ======================================================== SIGNUP GET SUCCESS


// ======================================================== ACCOUNT ACTIVATION GET
$router->get('account/activation/(\d+)/(\d+)', function($user_id,$email_code) {

    $params = array(
        "api_key" => api_key,
        "email_code" => $email_code,
        "user_id" => $user_id,
    );

    $res = POST(api_url.'activation', $params);

    // META DETAILS
    $meta = array(
        "title" => "Account Activated",
        "meta_title" => "Account Activated",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    views($meta,"Accounts/Account_activated");

});
// ======================================================== ACCOUNT ACTIVATION POST


// ======================================================== LOGIN GET
$router->get('login', function() {

    CSRF();

    // LOGIN CHECKUP
    if (isset($_SESSION['phptravels_client']->user_id)) {
        REDIRECT(root . 'dashboard');
    }

    // META DETAILS
    $meta = array(
        "title" => "Login",
        "meta_title" => "Login",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    views($meta,"Accounts/Login");

});

// ======================================================== LOGIN GET


// ======================================================== LOGIN POST
$router->post('login', function() {

    CSRF();

    // PARAMS TO SEND IN API
    $params = array(
        "api_key" => api_key,
        "email" => $_POST['email'],
        "password" => $_POST['password'],
    );

    // REQUEST TO API 
    $res = POST(api_url.'login',$params);

        // CONDITION IF RETURNS USER ID UPON REQUEST
        if (isset($res->data->user_id)) {

            // IF ACCOUNT STATUS IS 1 REDIRECT TO DASHBOARD
            if ($res->data->status == 1) {
                $_SESSION['phptravels_client'] = $res->data;
                REDIRECT(root . 'dashboard');
            } else {

                // IF ACCOUNT STATUS IS 0 SHOW MSG
                ALERT_MSG('not_active');
                REDIRECT(root . 'login');
            }
        } else {
            
            // IF NO ACCOUNT EXIST SHOW MSG AND RETURN TO LOGIN
            ALERT_MSG('invalid_login');
            REDIRECT(root . 'login');
        }
    
});
// ======================================================== LOGIN POST



// ======================================================== LOGIN POST
$router->post('sociallogin', function() {

    CSRF();

    // PARAMS TO SEND IN API
    $params = array(
        "api_key" => api_key,
        "email" => $_POST['email'],
        "password" => $_POST['password'],
    );

    // REQUEST TO API 
    $res = POST(api_url.'login',$params);

        // CONDITION IF RETURNS USER ID UPON REQUEST
        if (isset($res->data->user_id)) {

            // IF ACCOUNT STATUS IS 1 REDIRECT TO DASHBOARD
            if ($res->data->status == 1) {
                $_SESSION['phptravels_client'] = $res->data;
                echo json_encode(['redirect'=>'dashboard']);
            } else {

                // IF ACCOUNT STATUS IS 0 SHOW MSG
                echo json_encode(['redirect'=>'login','alert'=>'not_active']);
            }
        } else {
            
            // IF NO ACCOUNT EXIST SHOW MSG AND RETURN TO LOGIN
            echo json_encode(['redirect'=>'login','alert'=>'invalid_login']);
        }
       
    
});
// ======================================================== LOGIN POST


// ======================================================== DASHBOARD GET
$router->get('(dashboard)', function($menu) {

    // LOGIN CHECKUP
    if (!isset($_SESSION['phptravels_client']->user_id)) {
        REDIRECT(root . 'login');
    }

    // META DETAILS
    $meta = array(
        "title" => "Dashboard",
        "meta_title" => "",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    $meta['dashboard_active']=$menu;
    views($meta,"Accounts/Dashboard");

});
// ======================================================== DASHBOARD GET


// ======================================================== BOOKINGS GET
$router->get('(bookings)', function($menu) {

    // LOGIN CHECKUP
    if (!isset($_SESSION['phptravels_client']->user_id)) {
        REDIRECT(root.'login');
    }

    // META DETAILS
    $meta = array(
        "title" => "My Bookings",
        "meta_title" => "",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    // CALL API GET DATA
    $params = array(
        "api_key" => api_key,
        "user_id" => $_SESSION['phptravels_client']->user_id,
    );
    $meta['data'] = POST(api_url.'user_bookings', $params)->data;

    $meta['bookings_active']=$menu;
    views($meta, "Accounts/Bookings");

});
// ======================================================== BOOKINGS GET


// ======================================================== WALLET GET
$router->get('(wallet)', function($menu) {

    // LOGIN CHECKUP
    if (!isset($_SESSION['phptravels_client']->user_id)) {
        REDIRECT(root . 'login');
    }
    
      // META DETAILS
      $meta = array(
        "title" => "Wallet",
        "meta_title" => "",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    $meta['wallet_active']=$menu;

    views($meta, "Accounts/Wallet");
    

});
// ======================================================== WALLET GET


// ======================================================== PROFILE GET
$router->get('(profile)', function($menu) {

    CSRF();

    // META DETAILS
    $meta = array(
        "title" => "Profile",
        "meta_title" => "",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
    );

    // CALL API GET DATA
    $params = array(
        "api_key" => api_key,
        "user_id" => $_SESSION['phptravels_client']->user_id,
    );
    $meta['data'] = POST(api_url.'profile', $params)->data[0];

    $params = array("api_key" => api_key);
    $meta['countries'] = POST(api_url.'countries', $params);

    // LOGIN CHECKUP
    if (!isset($_SESSION['phptravels_client']->user_id)) {
        REDIRECT(root . 'login');
    }

    $meta['profile_active']=$menu;

    views($meta, "Accounts/Profile");

});
// ======================================================== PROFILE GET


// ======================================================== PROFILE POST
$router->post('profile', function() {

    CSRF();

    // CALL API GET DATA
    $params = array(
        "api_key" => api_key,
        "user_id" => $_SESSION['phptravels_client']->user_id,
        "first_name" => $_POST['first_name'],
        "last_name" => $_POST['last_name'],
        "email" => $_POST['email'],
        "phone" => $_POST['phone'],
        "password" => $_POST['password'],
        "phone_country_code" => $_POST['phone_country_code'],
        "country_code" => $_POST['country_code'],
        "state" => $_POST['state'],
        "city" => $_POST['city'],
        "address1" => $_POST['address1'],
        "address2" => $_POST['address2'],
    );

    $res = POST(api_url.'profile_update', $params);
    ALERT_MSG('updated');
    REDIRECT(root . 'profile');
    
});
// ======================================================== PROFILE POST


// ======================================================== SESSION DESTROY
$router->get('sd', function() {

    // dd($_SESSION['phptravels_client']);
    session_destroy();
    REDIRECT(root);

});
// ======================================================== SESSION DESTROY


// ======================================================== SESSION PRINT
$router->get('session', function() {

    dd($_SESSION['phptravels_client']);

});
// ======================================================== SESSION PRINT


// ======================================================== LOGOUT
$router->get('logout', function() {

    unset($_SESSION['phptravels_client']);
    // session_destroy();
    ALERT_MSG('logout');
    REDIRECT(root);

});
// ======================================================== LOGOUT


// ======================================================== LOGOUT
$router->get('Social_Login', function() {
    views([], "Accounts/Social_Login");
});
// ======================================================== LOGOUT


?>