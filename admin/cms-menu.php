<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
$params = array( "status" => $_POST['status'],);
$id = $_POST['id'];
$data = UPDATE('users_roles_permissions',$params,$id);
exit;
}

$title = T::cms_menu;
include "_header.php";

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::cms_menu?></p>
</div>
<div class="float-end">
<a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a>
</div>
</div>
</div>

<div class="container mt-3">

content goes here 

<?php include "_footer.php" ?>