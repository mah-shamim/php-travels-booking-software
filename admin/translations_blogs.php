<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include "_config.php";
    if (isset($_POST['update_blog'])){

        $filteredArray = array_filter($_REQUEST, function($value) {
            return $value !== 'update_blog'  && !empty($value);
        });
        foreach ($filteredArray as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $index => $item) {

                    if (!empty($item)) {
                        $params = array(
                            "post_title" => $value[0],
                            "post_desc" => $value[1],
                        );
                        $data = $db->update('blogs_translations',$params, [ "blog_id" => $filteredArray['blog_id'] , "language_id"=> $key]);
                    }else{
                        $params = array(
                            "post_title" => $value[0],
                            "post_desc" => $value[1],
                        );
                        $data = $db->update('blogs_translations',$params, [ "blog_id" => $filteredArray['blog_id'] , "language_id"=> $key]);
                    }
                }
            }
        }
        ALERT_MSG('updated');
        REDIRECT('blogs.php');
        exit;
    }

}
?>


<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::blog?> <?=T::translations?></p>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
               class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<form action="translations_blogs.php" method="post">

    <?php
    $params = array( "id"=> $_GET['blog']);
    $param = array('status'=>1);
    $languages = GET('languages',$param);
    $blogs = GET('blogs',$params);
    ?>

    <div class="container mt-4 mb-5">
        <div class="card">
            <div class="card-header">
            <?=str_replace('-',' ',$blogs[0]->post_slug);?>
            </div>
            <div class="card-body p-4">

                <?php foreach($languages as $lang => $i){
                    if($i->default != 1){
                        $params = array( "blog_id"=> $_GET['blog'],"language_id"=>$i->id);
                        $trans = GET('blogs_translations',$params)[0];
                    ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            <img src="./assets/img/flags/<?=strtolower($i->country_id)?>.svg"style="max-width:20px;">
                            <strong class="mx-2"><?=$i->name?></strong>
                        </div>
                        <div class="card-body">

                            <div class="form-floating mb-2">
                                <input class="form-control"  name="<?=strtolower($i->id)?>[]" value="<?=$trans->post_title ?? ""?>" />
                                <label for=""><?=T::name?></label>
                            </div>

                            <div class="form-floating mb-2">
                                <textarea class="form-control" placeholder="" id="" style="height: 100px" name="<?=strtolower($i->id)?>[]"><?=$trans->post_desc ?? ""?></textarea>
                                <label for=""><?=T::description?></label>
                            </div>


                        </div>
                    </div>
                <?php }
                }?>

            </div>

            <div class="card-footer text-muted" style="position: fixed; bottom: 0; width: 100%;background: #e9ecef;">
                <div class="mx-4 my-3">
                    <button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="update_blog" value="update_blog">
    <input type="hidden" name="blog_id" value="<?=$_GET['blog']?>">
</form>

<div class="mt-5" style="margin-bottom:100px;"></div>