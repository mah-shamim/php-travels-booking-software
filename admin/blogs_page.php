<script src="./assets/js/ck.js"></script>

<form action="./blogs.php" method="POST" enctype="multipart/form-data">

<div class="container mt-4 mb-4">
<div class="card">
<div class="card-body p-5">

<div class="row mb-1">

<div class="col">
    <div class="row form-group mb-3">
        <label class="col-md-1 control-label text-left pt-2"><?=T::status?></label>
        <div class="col-md-8">
        <div class="form-check form-switch">
        <label class="form-check-label" for=""></label>
        <input <?php if(isset($blog)){ if ($blog['status'] == 1){ echo "checked";} }?> style="margin-top:10px;width: 40px; height: 20px;cursor:pointer" class="form-check-input" id="checkedbox" type="checkbox" name="status" value="">
        </div>
        </div>
    </div>
</div>
</div>

<div class="form-floating mb-3">
<input required type="text" placeholder="name" name="post_title" id="name" value="<?php if (isset($_GET['page'])){echo $blog['post_title'];}?>" class="form-control slugger-source">
<label for="name"><?=T::page_name?></label>
</div>

<div class="row">
<div class="col-md-8">

<div class="input-group mb-1">
<span class="input-group-text" id="basic-addon3" style="height:59px"><?=$settings->site_url?>/</span>
<div class="form-floating mb-3">
<input required type="text" placeholder="post_slug" name="post_slug" id="slug_url" value="<?php if (isset($_GET['page'])){echo $blog['post_slug'];}?>" class="form-control slugger-target">
<label for="slug_url"><?=T::slug_url?></label>
</div>

</div>

</div>

<div class="col-md-4">
<div class="form-floating mb-1">
<select required class="form-select" name="post_category">
<?php foreach($blog_category as $c){ ?>
<option value="<?=$c->id?>"><?=$c->cat_name?></option>
<?php } ?>
</select>
<label for=""><?=T::category?> <?=T::name?></label>
</div>
</div>
</div>

<div class="row mb-1">
    <div class="col-md-8">
    <div class="form-group mb-3">
        <label class="mb-2" for="img"><?=T::thumbnail?></label>
        <input class="form-control p-3 px-4" type="file" class="form-control" id="img" name="img">
    </div>
    </div>
    <div class="col-md-4">
    
    <label class="mb-2" for="img">&nbsp;</label>

    <div class="form-floating mb-3">
    <input required type="date" placeholder=" " name="created_at" value="<?php if (isset($_GET['page'])){echo $blog['created_at'];}?>" class="form-control slugger-target">
    <label for="created_at"><?=T::date?></label>
    </div>

    </div>
</div>

<script>
$("[name='category_id']").val(<?php if (isset($_GET['page'])){echo $blog['post_category'];}?>)
</script>

<?php if (!empty($blog['post_img'])){?>
<div class="row mb-4">
<div class="col-4">
<img src="../uploads/blog/<?=$blog['post_img']?>" alt="<?=$blog['post_img']?>" class="w-100 rounded-3">
<input value="<?=$blog['post_img']?>" type="hidden" name="blog_img">

</div>
</div>
<?php } ?>

<textarea name="post_desc" class="editor" cols="30" rows="10" class=""><?php if (isset($_GET['page'])){echo $blog['post_desc'];}?></textarea>
  
</div>

<div class="card-footer">
    <div class="mx-4 my-3">
        <button type="submit" class="btn btn-primary"> <?=T::submit?></button>
    </div>
</div>

</div>
</div>


<script>
ClassicEditor.create(document.querySelector(".editor"), {

    language: 'es',
    toolbar: {
        items: [
            "heading",
            "|",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "|",
            "indent",
            "outdent",
            "|",
            "imageUpload",
            "blockQuote",
            "mediaEmbed",
            "undo",
            "redo",
        ],
    },
    language: "en",
    image: {
        toolbar: ["imageTextAlternative", "imageStyle:full", "imageStyle:side"],
    },
    licenseKey: "",
})
    .then((editor) => {
        window.editor = editor;
    })
    .catch((error) => {
        console.error("Oops, something went wrong!");
        console.error(
            "Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:"
        );
        // console.warn("Build id: ref2goguw78q-8ghiwfe1qu83");
        console.error(error);
    });
</script>

<script>

let source = $('.slugger-source');
    let target = $('.slugger-target');

    //When the user is typing in the name field.
    source.keyup( function(){
        transformStringToSlug(source , target)
    });

    //When the user is typing in the target field
    target.keyup( function(){
        transformStringToSlug(target , target)
    });

    //Actually perform the sluggify
    function transformStringToSlug(the_source , the_target){

        string = the_source.val();

        //Remove any special chars, ignoring any spaces or hyphens
        var slug = string.replace(/[^a-zA-Z0-9\ \-]/g, "");

        //Replace any spaces with hyphens
        slug = slug.split(' ').join('-');

        //Chuck it back into lowercase
        slug = slug.toLowerCase();

        //Valiate out any double hyphens
        slug = slug.split('--').join('-');

        var lastChar = slug.substring(slug.length -1, slug.length);
        if ( lastChar == '-'){
            slug = slug.substring(0 , slug.length -1 );
        }

        //Dump it back to the destination input
        the_target.val( slug );
    }

</script>

<style>
.page_head{position: relative;}
</style>

<?php if (isset($_GET['addpage'])) { ?>
    <input type="hidden" name="add_new">
<?php } if (isset($_GET['page'])) { ?>
    <input type="hidden" name="update">
    <input type="hidden" name="page_id" value="<?=$_GET['page']?>">
<?php } ?>

<input type="hidden" name="form_token" value="<?=$_SESSION["form_token"]?>">
</form>