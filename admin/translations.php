<?php 

use Medoo\Medoo;
require_once '_config.php';
auth_check();

$title = T::translations;
include "_header.php";

// GET DATA
if(isset($_GET['languages'])) { 
 include "translations_languages.php";
 include "_footer.php";
}

// GET DATA
if(isset($_GET['hotels'])) { 
    include "translations_hotels.php";
    include "_footer.php";
   }


// GET DATA
if(isset($_GET['blog'])) {
    include "translations_blogs.php";
    include "_footer.php";
}
exit;

?>

<div class="container mt-4 mb-4">
<div class="card">
<div class="card-body p-5">



</div>
</div>
</div>

<?php include "_footer.php"; ?>