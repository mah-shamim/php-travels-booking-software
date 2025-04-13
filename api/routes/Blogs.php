<?php


// ======================== BLOG PAGES
$router->post('blogs_page', function() {

    // INCLUDE CONFIG
    include "./config.php";
    $lang = $_POST['lang'];
    $language_id = $db->select("languages", "*", array('name' => strtolower($lang)));
    $translation = $db->select("blogs_translations", "*", array("blog_id" => $_POST['id'],'language_id'=>$language_id[0]['id']));

    // PARAMS
    $params = array(
        "post_slug[~]"=> $_POST['slug_url'],
    );
    // PAGE
    $data = $db->select("blogs","*", $params);
    $data[0]['post_title']= !empty($translation[0]['post_title']) ? htmlentities($translation[0]['post_title']) : htmlentities($data[0]['post_title']);
    $data[0]['post_desc'] = !empty($translation[0]['post_desc']) ? htmlentities($translation[0]['post_desc']) : htmlentities($data[0]['post_desc']);
    $respose = array ( "status"=>true, "message"=>"BLOG page data", "data"=> $data );

echo json_encode($respose);

});

$router->post('blogs', function () {
    include "./config.php";
    $lang = $_POST['lang'];
    $defaultlanguagerow = $db->select("languages", "*", array('name' => $lang));
    $params = array('status' => 1);
    $get_blog = $db->select("blogs", "*", $params);
    $blogs = [];
        foreach ($get_blog as $value) {
            $translation = $db->select("blogs_translations", "*", array("blog_id" => $value['id'],'language_id'=>$defaultlanguagerow[0]['id']));
        if (!empty($translation) && !empty($translation[0]['post_title'])) {
            $post_title = $translation[0]['post_title'];
        } else {
            $post_title =  str_replace('-', ' ', $value['post_slug']);
        }
        $blogs[] = (object) [
            'id' => $value['id'],
            'post_title' => $post_title,
            'post_slug' =>  $value['post_slug'],
            'post_category' => $value['post_category'],
            'post_img' => $value['post_img'],
            'status' => $value['status'],
            'created_at' => $value['created_at'],
         
        ];
    }

    $response = array("status" => true, "message" => "blog page data", "data" => $blogs);

    echo json_encode($response);

});


//$router->post('details', function() {
//    // INCLUDE CONFIG
//    include "./config.php";
//
//
//    // PARAMS
//    $params = array(
//        "post_title"=>$_POST['page_name'],
//        "id"=>$_POST['id'],
//        "status"=>1
//      );
//
//    // PAGE
//
//    $data = $db->select("blogs","*",$params);
//    $data[0]['post_desc']=htmlentities($data[0]['post_desc']);
//    $respose = array ( "status"=>true, "message"=>"blog page data", "data"=> $data );
//
//echo json_encode($respose);
//
//});

// ======================== BLOG PAGES


?>