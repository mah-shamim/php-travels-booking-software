<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();
CSRF();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

// ADD DATA
if (isset($_POST['add_new'])){
    
    if (isset($_POST['status'])) { $STATUS = 1; } else { $STATUS = 0; };

            $params = array( 
            "status" => $STATUS,
            "page_name" => $_POST['page_name'],
            "slug_url" => $_POST['slug_url'],
            "content" => $_POST['content'],
            "menu_id" => $_POST['menu_id'],
            );

            $data = INSERT('cms',$params);

            ALERT_MSG('updated');
            REDIRECT('cms.php?pages=1');
            exit;
}

// UPDATE DATA
if (isset($_POST['update'])){
    
    if (isset($_POST['status'])) { $STATUS = 1; } else { $STATUS = 0; };

            $params = array( 
            "status" => $STATUS,
            "page_name" => $_POST['page_name'],
            "slug_url" => $_POST['slug_url'],
            "content" => $_POST['content'],
            "menu_id" => $_POST['menu_id'],
            );

            $id = $_POST['page_id'];
            $data = UPDATE('cms',$params,$id);

            ALERT_MSG('updated');
            REDIRECT('cms.php?pages=1');
            exit;
}

}

if(isset($_GET['menu'])) { 

    $title = T::cms_menu;
    include "_header.php";
?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::cms_menu?></p>
        </div>
        <div class="float-end">
             
        </div>
    </div>
</div>
<?php 

    echo "<div class='container mt-4'";
    include('./xcrud/xcrud.php');
    $xcrud = Xcrud::get_instance();
    $xcrud->table('cms_menu');
    $xcrud->order_by('id','desc');
    $xcrud->columns('name');

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
            <a href="./cms.php?addpage=1" class="loading_effect btn btn-dark"><?=T::add?></a>
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
    $cms_menu = GET('cms_menu',$params);

    include "cms_page.php";
    include "./_footer.php";
    }
    exit;
    } else

    if(isset($_GET['page'])) { 
 
    // GET DATA FROM API
    $params = array();
    $settings = GET('settings',$params)[0];

    $params = array();
    $cms_menu = GET('cms_menu',$params);

    $params = array( "id"=>$_GET['page']);
    $cms = GET('cms',$params)[0];

    include "cms_page.php";
    include "./_footer.php";

    exit;
    } else { 
?>

<div class="container mt-3">

<!-- ========================================================================================================= -->

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('cms');
$xcrud->order_by('id','desc');
$xcrud->columns('status,page_name,slug_url,menu_id');

$xcrud->button('./translations.php?cms={id}','cms','<i> Translation <svg  style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></i>');

// USER PERMISSIONS
if (!isset($permission_delete)){ $xcrud->unset_remove(); }
if (isset($permission_edit)){ 
    $xcrud->button('./cms.php?page={id}','cms','<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></i>');
    $xcrud->column_callback('status', 'create_status_icon');
    $xcrud->field_callback('status','Enable_Disable');
} else {
    
}

$xcrud->relation('menu_id','cms_menu','id','name');
$xcrud->label(array('status' =>  T::status, 'page_name' => T::page_name, 'menu_id' => T::menu, 'slug_url' => T::slug_url  ));

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