<?php 

// ======================================================== CMS PAGE

$router->get('/(page)/(.*)', function($nav_menu,$uri) {

    $url = explode('/', $uri);

    // SEARCH PARAMS
    $params = array( "slug_url"=>$url[0],);
    $RESPONSE=POST(api_url.'cms_page',$params);

    // pre($RESPONSE->data);
    // die;

    if(empty($RESPONSE->data)){
        REDIRECT(root);
    } else {
        $data = $RESPONSE;
    }

    $meta = array(
        "title" => ($RESPONSE->data[0]->page_name),
        "meta_title" => ($RESPONSE->data[0]->page_name),
        "meta_desc" => "",
        "meta_img" => "",
        "meta_url" => "",
        "meta_author" => "",
        "nav_menu" => $nav_menu,
        "data" => $data
    );

    views($meta,"Cms/Page");

});

// ======================================================== CMS PAGE

?>