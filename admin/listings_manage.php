<script src="./assets/js/ck.js"></script>

<?php if (isset($_GET['listing']) == "addnew"){ 
      if (isset($listing)){ unset($listing); }
}?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <?php if(isset($listing) && (empty($listing->name))) { ?>
            <p class="m-0 page_title"><?=T::add?> <?=T::listing?></p>
            <?php } ?>

            <?php if(isset($listing) && (!empty($listing->name))) { ?>
            <p class="m-0 page_title"><strong><?=T::edit?></strong> <?=$listing->name?></p>
            <?php } ?>
        </div>
        <div class="float-end">
            <a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page"
                class="loading_effect btn btn-warning"><?=T::back?></a>
        </div>
    </div>
</div>

<form action="./listings.php" method="POST">

<div class="container mt-4 mb-4">
<div class="card">
<div class="card-body p-4">

<div class="mb-1 justify-content-between">



<?php 
if ($listing->listing_type == "hotels" ){ include "./listings_hotels.php";} 
?>

<?php $listing_id = ENCODE($listing->id); ?>
<input type="hidden" name="form_token" value="<?=$_SESSION["form_token"]?>">
<input type="hidden" name="listing_id" value="<?=($listing_id)?>">
</form>

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
    image: { toolbar: ["imageTextAlternative", "imageStyle:full", "imageStyle:side"], },
    licenseKey: "", })
    .then((editor) => { window.editor = editor; })
    .catch((error) => { console.error(""); console.error(error); });
</script>

<style>
    .page_head{position: relative;}
    .ck-editor__main {min-height:200px}
    .ck-editor__editable:not(.ck-focused) {min-height:180px !important;}
</style>

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

<script src="./assets/js/select2.js"></script>

<script>

var $ajax = $(".owned_change");
   function formatRepo(t) {  return t.loading ? t.text : (
   // console.log(t), 
   t.text +', '+'<small><strong>'+t.fname+' '+t.lname+'</strong><small>'
   ) }
   function formatRepoSelection(t) { 
            
    if(typeof t.fname === 'undefined') {
    var frist_last_name = "";
    } else { 
    var frist_last_name = t.fname+' '+t.lname;
    }

   return '<strong>'+frist_last_name+'</strong> ' + t.text }
   $ajax.select2({
       ajax: {
           url: "./_post.php",
           dataType: "json",
           data: function(t) {
               return {
                   email: $.trim(t.term)
               }
           },
           processResults: function(t) {
            // console.log(t.data)
               var e = [];
               return t.data.forEach(function(t) {
                   e.push({
                       id: t.user_id,
                       text: t.email,
                       fname: t.first_name,
                       lname: t.last_name
                   })
               }), console.log(e), {
                   results: e
               }
           },
           cache: !0
       },
       escapeMarkup: function(t) {
           return t
       },
       minimumInputLength: 3,
       templateResult: formatRepo,
       templateSelection: formatRepoSelection,
       dropdownPosition: 'below',
       cache: !0
   });
   
   $(document).on('select2:open', () => {
   document.querySelector('.select2-search__field').focus();
   });

</script>

<script>
    // select 2 location init for hotels search 
   var $ajax = $(".locations");
   function formatRepo(t) {  return t.loading ? t.text : (console.log(t), '<i class="flag ' + t.icon.toLowerCase() + '"></i>' + t.text +', '+'<strong>'+t.country_name+'</strong>') }
   function formatRepoSelection(t) { 
      
   if(typeof t.country_name === 'undefined') {
   var country_name_ = "";
   } else { 
   var country_name_ = t.country_name;
   }
      
   return t.text +' '+'<small><strong>'+country_name_+'</strong><small>' }
   $ajax.select2({
       ajax: {
           url: "../api/hotels_locations",
           dataType: "json",
           data: function(t) {
               return {
                   city: $.trim(t.term)
               }
           },
           processResults: function(t) {
            // console.log(t.data)
               var e = [];
               return t.data.forEach(function(t) {
                   e.push({
                       id: t.id,
                       text: t.city,
                       icon: t.country_code,
                       country_name: t.country
                   })
               }), console.log(e), {
                   results: e
               }
           },
           cache: !0
       },
       escapeMarkup: function(t) {
           return t
       },
       minimumInputLength: 3,
       templateResult: formatRepo,
       templateSelection: formatRepoSelection,
       dropdownPosition: 'below',
       cache: !0
   });
   
   $(document).on('select2:open', () => {
   document.querySelector('.select2-search__field').focus();
   });
</script>

<style>
.select2-container--default .select2-selection--single .select2-selection__rendered { padding: 0 0px; color: rgb(0 0 0 / 68%); line-height: 20px; text-transform: capitalize; margin-top: 6px; text-align: left; font-size: 1rem; font-weight: 100; }
.select2-container .select2-selection--single { box-sizing: border-box; cursor: pointer; display: block; height: 60px; user-select: none; -webkit-user-select: none; }
.select2-container .select2-selection--single { box-sizing: border-box; cursor: pointer; display: block; height: 60px; min-height: 44px; user-select: none; -webkit-user-select: none; }
</style>