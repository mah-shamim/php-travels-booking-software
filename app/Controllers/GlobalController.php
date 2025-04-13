<?php 

$router->get('visitor_details', function () {
  
    header('Access-Control-Allow-Origin: *');
    header("Content-Type: application/json");

    include_once "credentials.php";
    global $geo_ip_cred;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.ip2location.io/?key=' . $geo_ip_cred . '&ip=' .$_SERVER['REMOTE_ADDR'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo($response);

});

$router->get('theme/(.+)', function ($theme) {
  
    $_SESSION['theme']=$theme;
    header("Location: ".root);
    // echo $theme;
  
});

$router->get('(sitemap.xml)', function ($nav_menu) {
  
    header("Content-type: text/xml");
    include "./sitemap/sitemap.php";
  
});

$router->get('(sitemap-pages.xml)', function ($nav_menu) {
  
    header('Content-type: application/xml; charset=utf-8');
    include "./sitemap/sitemap_pages.php";
  
});

$router->get('(supplier)', function ($nav_menu) {
  
    REDIRECT(root.'admin');
  
});

?>