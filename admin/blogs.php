<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();
CSRF();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

// ADD DATA
if (isset($_POST['add_new'])){
    // echo'<pre>';
    // print_r($_FILES);die;
    if (isset($_POST['status'])) { $STATUS = 1; } else { $STATUS = 0; };
    $filename=$_FILES['img']['name'];
    $location="../uploads/blog/".$filename;
            $params = array( 
            "status" => $STATUS,
            "post_title" => $_POST['post_title'],
            "post_slug" => $_POST['post_slug'],
            "created_at" => $_POST['created_at'],
            "post_desc" => $_POST['post_desc'],
            "post_img"=> $filename,
            "post_category" => $_POST['post_category'],
            );

            $data = INSERT('blogs',$params);
           
         
            move_uploaded_file($_FILES['img']["tmp_name"],$location);



            ALERT_MSG('updated');
            REDIRECT('blogs.php?pages=1');
            exit;
}

// UPDATE DATA
if (isset($_POST['update'])){
    
    if (isset($_POST['status'])) { $STATUS = 1; } else { $STATUS = 0; };
    
    $filename=$_FILES['img']['name'];

    if (empty($filename)){
        $filename=($_POST['blog_img']);
    }

    $uploadedFilePath = $_FILES['img']['tmp_name'];
    $destinationDirectory = "../uploads/blog/";

    move_uploaded_file($uploadedFilePath, $destinationDirectory . $_FILES['img']['name']);
    
            $params = array( 
            "status" => $STATUS,
            "post_title" => $_POST['post_title'],
            "created_at" => $_POST['created_at'],
            "post_slug" => $_POST['post_slug'],
            "post_desc" => $_POST['post_desc'],
            "post_img"=> $filename,
            "post_category" => $_POST['post_category'],
            );

            $id = $_POST['page_id'];

            $data = UPDATE('blogs',$params,$id);

            ALERT_MSG('updated');
            REDIRECT('blogs.php?pages=1');
            exit;
}

}


if(isset($_GET['category'])) { 

    $title = T::blog_category;
    include "_header.php";
?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::blog_category?></p>
        </div>
        <div class="float-end">
             
        </div>
    </div>
</div>
<?php 

    echo "<div class='container mt-4'";
    include('./xcrud/xcrud.php');
    $xcrud = Xcrud::get_instance();
    $xcrud->table('blog_categories');
    $xcrud->order_by('id','desc');

    // USER PERMISSIONS
    if (!isset($permission_delete)){ $xcrud->unset_remove(); }
    if (isset($permission_edit)){
    } else {
        $xcrud->unset_edit();
    }

    if (!isset($permission_add)){ 
        $xcrud->unset_add();
    }

    $xcrud->label(array('name' =>  T::name ));
    $xcrud->unset_title();
    $xcrud->unset_view();
    $xcrud->unset_csv();
    echo $xcrud->render();

    echo "</div>";
    include "_footer.php";
    exit;
}

$title = T::pages;
include "_header.php";

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::pages?></p>
        </div>
        <div class="float-end">
            <?php if (isset($permission_add)){ ?>
            <?php if(!isset($_GET['addpage'])) {  ?>
            <a href="./blogs.php?addpage=1" class="loading_effect btn btn-dark"><?=T::add?></a>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php 

    if(isset($_GET['addpage'])) { 
        if (isset($permission_add)){

    // GET DATA FROM API
    $params = array();
    $settings = GET('settings',$params)[0];
 

    $params = array();
    $blog_category = GET('blog_categories',$params);

    include "blogs_page.php";
    include "./_footer.php";
    }
    exit;
    } else

    if(isset($_GET['page'])) { 
    
    // GET DATA FROM API
    $params = array();
    $settings = GET('settings',$params)[0];

    $params = array();
    $blog_category = GET('blog_categories',$params);

    $params = array( "id"=>$_GET['page']);
    $blog = blog_get('blogs',$params)[0];

    include "blogs_page.php";
    include "./_footer.php";

    exit;
    } else { 
?>

<div class="container mt-3">

<!-- ========================================================================================================= -->

<?php 

include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('blogs');
$xcrud->order_by('id','desc');
$xcrud->columns('post_img,status,post_title,post_slug');
$xcrud->column_class('post_img', 'zoom_img');
$xcrud->change_type('post_img', 'image', true, array('width' => 200, 'path' => '../../uploads/blog/',
));
$xcrud->button('./translations.php?blog={id}','blog','<i> Translation <svg  style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></i>');

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (isset($permission_edit)){ 
    $xcrud->button('./blogs.php?page={id}','blogs','<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></i>');
    $xcrud->column_callback('status', 'create_status_blog_icon');
    //$xcrud->field_callback('status','Enable_Disable_Blog');
  
} else {
    
}

$xcrud->relation('post_category','blog_categories','id','cat_name');
$xcrud->label(array('status' =>  T::status, 'post_title' => T::page_name, 'id' => T::category, 'post_slug' => T::slug_url ));

$xcrud->unset_title();
$xcrud->unset_view();
$xcrud->unset_csv();
$xcrud->unset_edit();
$xcrud->unset_add();
$xcrud->column_width('status','5%');

echo $xcrud->render();

?>

<?php } ?>
</div>

<?php include "_footer.php" ?>