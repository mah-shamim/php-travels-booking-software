<?php 

/* ---------------------------------------------- */
// VISA INDEX PAGE
/* ---------------------------------------------- */
$router->get('(visa)', function ($nav_menu) {
  
    // META DETAILS
    $meta = array(
        "title" => "Visa",
        "meta_title" => "Visa",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
    );

    views($meta,"Visa/Index");

});

// VISA SUBMISSION FORM
$router->get('(visa)/submit(.*)', function($nav_menu) {
    $url = explode('/', $_GET['url']);
    $count = count($url);
    if ($count < 4) { header('Location: '.root);  }

    $module = $url[0];
    $submit = $url[1];
    $from_country = $url[2];
    $to_country = $url[3];
    $date = $url[4];
    $ip = $_SERVER['REMOTE_ADDR'];
    $browser_version = $_SERVER['HTTP_USER_AGENT'];
    $request_type = 'web';

    $data = array(
    'from_country' => $from_country,
    'to_country' => $to_country,
    'ip' => $ip,
    'browser_version' => $browser_version,
    'request_type' => $request_type,
    );

    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    // CURLOPT_URL => api_url.'api/ivisa/search?appKey='.api_key,
    // CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_FOLLOWLOCATION => true,
    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    // CURLOPT_CUSTOMREQUEST => 'POST',
    // CURLOPT_POSTFIELDS => $data,
    // CURLOPT_HTTPHEADER => array(
    // 'Cookie: ci_session=j64b5qt3muujs1qhjcfjrdgdjio4oi9k'
    // ),
    // ));

    // $response = curl_exec($curl);
    // curl_close($curl);

    // SEO META INFORMATION
    $title = "Submit Visa";
    $meta_title = "Submmit VIsa";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";

    // META DETAILS
    $meta = array(
        "title" => "Visa",
        "meta_title" => "Visa",
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
    );

    // GENERATE LOGS
    // logs($SearchType = "Visa search ");
    // SEARCH_SESSION($MODULE=T::visa_visa,$CITY=strtoupper($from_country)."<i class='la la-arrow-right px-1'></i>".strtoupper($to_country));

    views($meta,"Visa/Visa_form");
});


$router->get('submit/visa', function() {
    
    // $data = array(
    // 'first_name' => $_POST['first_name'],
    // 'last_name' => $_POST['last_name'],
    // 'email' => $_POST['email'],
    // 'status' => 'waiting',
    // 'phone' => $_POST['phone'],
    // 'from_country' => $_POST['from_country'],
    // 'to_country' => $_POST['to_country'],
    // 'notes' => $_POST['notes'],
    // 'date' => $_POST['date'],
    // 'res_code' => '1234'
    // );
    
    // SEO META INFORMATION
    $title = "Submit Visa";
    $meta_title = "Submit Visa";
    $meta_appname = "";
    $meta_desc = "";
    $meta_img = "";
    $meta_url = "";
    $meta_author = "";
    $meta = "1";
    $body = views."visa/success.php";
    include layout;
   

});


?>