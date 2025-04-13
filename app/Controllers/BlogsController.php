<?php 

// ======================================================== BLOG PAGE
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$router->get('/(blog)/(.*)', function($nav_menu,$uri) {

    $url = explode('/', $uri);
    if(!empty($_SESSION['phptravels_client_language_name'])){
        $clientlanguage = $_SESSION['phptravels_client_language_name'];
    }else{
        $clientlanguage = $_SESSION['defual_lang'];
    }
    // SEARCH PARAMS
    $params = array( "slug_url"=>$url[0],'lang'=>$clientlanguage,'id'=>$url[1]);
    $RESPONSE=POST(api_url.'blogs_page',$params);

    // pre($RESPONSE);
    // die;

    if(empty($RESPONSE->data)){
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => ($RESPONSE->data[0]->post_title),
        "meta_title" => ($RESPONSE->data[0]->post_title),
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        "data" => $data
    );

    views($meta,"Blog/Detail");

});


$router->get('/blogs', function() {

        if(!empty($_SESSION['phptravels_client_language_name'])){
            $clientlanguage = $_SESSION['phptravels_client_language_name'];
        }else{
            $clientlanguage = $_SESSION['defual_lang'];
        }
    $postdata = [
        'lang' => $clientlanguage,
    ];
    $RESPONSE = POST(api_url.'blogs', $postdata);
    // pre($RESPONSE);
    // var_dump($RESPONSE);
    // die;

    if (empty($RESPONSE->data)) {
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => "Blog | " . app()->app->business_name,
        "meta_title" => "Blog | " . app()->app->business_name,
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "data" => $data
    );

    views($meta, "Blog/List");

});



//$router->get('/(detail)/(.*)', function($uri) {
//
//    $result = explode('/', $_GET['url']);
//    $param = [
//        "page_name" => $result[1],
//        "id" => $result[2]
//    ];
//    $RESPONSE = POST(api_url . 'details', $param);
//
//    // pre($RESPONSE);
//    // var_dump($RESPONSE);
//    // die;
//
//    if (empty($RESPONSE->data)) {
//        REDIRECT(root);
//    } else {
//        $data = $RESPONSE;
//    }
//
//    $meta = array(
//        "title" => ($RESPONSE->data[0]->page_name),
//        "meta_title" => ($RESPONSE->data[0]->page_name),
//        "meta_desc" => "",
//        "meta_img" => "",
//        "meta_url" => "",
//        "meta_author" => "",
//        "data" => $data
//    );
//
//    views($meta, "Blog/Detail");
//
//});


// ======================================================== BLOG PAGE

?>