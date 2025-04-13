<?php 

require_once '_config.php';
auth_check();
CSRF();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // LOGO 
    if (!empty($_FILES["logo"]["name"])) {
    $file_name      = $_FILES["logo"]["name"];
    $temp_name      = $_FILES["logo"]["tmp_name"];
    $imgtype        = $_FILES["logo"]["type"];
    $uploaded       = '../uploads/global/logo.png';
    $path = $_FILES['logo']['name']; 
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext=="png") {}else{ echo "Invalid image logo format allowed only PNG images"; die; }
    if(move_uploaded_file($temp_name, $uploaded));
    }

    // FAVICON 
    if (!empty($_FILES["favicon"]["name"])) {
    $file_name      = $_FILES["favicon"]["name"];
    $temp_name      = $_FILES["favicon"]["tmp_name"];
    $imgtype        = $_FILES["favicon"]["type"];
    $uploaded       = '../uploads/global/favicon.png';
    $path = $_FILES['favicon']['name']; 
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext=="png") {}else{ echo "Invalid image favicon format allowed only PNG images"; die; }
    if(move_uploaded_file($temp_name, $uploaded));
    }

    // BG 
    if (!empty($_FILES["coverimage"]["name"])) {
    $file_name      = $_FILES["coverimage"]["name"];
    $temp_name      = $_FILES["coverimage"]["tmp_name"];
    $imgtype        = $_FILES["coverimage"]["type"];
    $uploaded       = '../uploads/global/bg.png';
    $path = $_FILES['coverimage']['name']; 
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext=="png") {}else{ echo "Invalid image cover image format allowed only PNG images"; die; }
    if(move_uploaded_file($temp_name, $uploaded));
    }
    
    $params = array( 
    'user_id' => $USER_SESSION->backend_user_id, 
    'business_name' => $_POST['business_name'], 
    'site_url' => $_POST['site_url'], 
    'license_key' => $_POST['license_key'], 
    'site_offline' => $_POST['site_offline'], 
    'offline_message' => $_POST['offline_message'], 
    'home_title' => $_POST['home_title'], 
    'meta_description' => $_POST['meta_description'], 
    'guest_booking' => $_POST['guest_booking'], 
    'user_registration' => $_POST['user_registration'], 
    'supplier_registration' => $_POST['supplier_registration'], 
    'agent_registration' => $_POST['agent_registration'], 
    'javascript' => $_POST['javascript'], 
    'multi_language' => $_POST['multi_language'], 
    'multi_currency' => $_POST['multi_currency'], 
    'social_facebook' => $_POST['social_facebook'], 
    'social_twitter' => $_POST['social_twitter'], 
    'social_linkedin' => $_POST['social_linkedin'], 
    'social_instagram' => $_POST['social_instagram'], 
    'social_google' => $_POST['social_google'], 
    'social_whatsapp' => $_POST['social_whatsapp'], 
    'social_youtube' => $_POST['social_youtube'], 
    'contact_email' => $_POST['contact_email'], 
    'contact_phone' => $_POST['contact_phone'], 
    'address' => $_POST['address'], 
    'map_address' => $_POST['map_address'], 
    'default_theme' => $_POST['default_theme'], 
    'theme_name' => $_POST['theme_name'], 
    );

    $id = 1;
    $res = UPDATE('settings',$params,$id);

    // INSERT TO LOGS
    $user_id = $USER_SESSION->backend_user_id;    
    $log_type = "settings_updated";
    $datetime = date("Y-m-d h:i:sa");
    $desc = "user updated main settings";
    logs($user_id,$log_type,$datetime,$desc.json_encode($_REQUEST));
    
    ALERT_MSG('updated');
    REDIRECT("settings.php");

}

$title = T::settings; 
include "_header.php";

// GET DATA FROM API
$params = array();
$settings = GET('settings',$params)[0];

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::settings?></p>
</div>
<div class="float-end">
<a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a>
</div>
</div>
</div>

<div class="container mt-2">

<form action="settings.php" method="post" onsubmit="submission()" enctype="multipart/form-data">

<div class="py-2">

<div class="row gx-3">
  <div class="col-lg-8">
     <div class="card card-raised mb-3" style="min-height:760px;">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::main?> <?=T::settings?></strong></div>
        <div class="card-subtitle mb-4"><?=T::application_name_and_tags?></div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::business_name?></label>
          <div class="col-md-9">
            <input type="text" name="business_name" class="form-control" value="<?=$settings->business_name?>">
           </div>
        </div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::domain_name?></label>
          <div class="col-md-9">
          <input type="text" name="site_url" class="form-control" value="<?=$settings->site_url?>">
          </div>
        </div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::license_key?></label>
          <div class="col-md-9">
          <input type="text" name="license_key" class="form-control" value="<?=$settings->license_key?>">
          </div>
        </div>
       
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::website_offline?></label>
          <div class="col-md-9">
          <select class="form-select site_offline" name="site_offline">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
          </div>
        </div>
        <script>
            // ENABLE DISABLE OFFLINE MESSAGE BOX
            $('.site_offline').val(<?=$settings->site_offline?>)
            if (<?=$settings->site_offline?> == 1) {
                $('.offline_message').attr('disabled', false)
            } else {
                $('.offline_message').attr('disabled', true)
            }
        </script>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::website_message?></label>
          <div class="col-md-9">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Message" name="offline_message" id="offmsg" style="height: 100px" readonly=""><?=$settings->offline_message?></textarea>
              <label for=""><?=T::site_website_message?></label>
            </div>
          </div>
        </div>
          
        <hr>
        <div class="card-title"><strong><?=T::website_theme?></strong></div>
        <div class="card-subtitle mb-4"><?=T::select_color_theme?></div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::default_color?></label>
          <div class="col-md-9">
          <div class="form-floating">
          <input type="color" id="theme_color" name="default_theme" class="form-control" value="<?=$settings->default_theme?>">
              <label for=""><?=T::color?></label>
          </div>
          </div>
        </div>

        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::theme.' '.T::name?></label>
          <div class="col-md-9">
            
          <div class="form-floating mb-3">
          <select class="form-select" name="theme_name">
          
          <?php 

          $themes = scandir("../assets/css/themes");
          foreach ($themes as $theme){ 
            if (!in_array($theme, array(".", ".."))) {  
              $name = substr($theme,0,-4);
          ?>
            
          <option value="<?=$name?>"><?=$name?></option>

          <?php } } ?>

          </select>
          <label for=""><?=T::theme.' '.T::name?></label>
          </div>
          
          </div>
        </div> 
        
        <script>
            $("[name='theme_name']").val("<?=$settings->theme_name?>")
        </script>

        <div class="text-end">
          <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>
        </div>
      </div>
    </div>

    <script>
    document.getElementById("theme_color").value = "<?=$settings->default_theme?>";
    </script>

    <div class="card card-raised mb-3">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::seo?></strong></div>
        <div class="card-subtitle mb-4"><?=T::seo_and_meta_tags?></div>
        <div class="row form-group mb-2">
          <label class="col-md-3 control-label text-left pt-2"><?=T::meta_title?></label>
          <div class="col-md-9">
            <label class="pure-material-textfield-outlined">
            <input name="home_title" type="text" placeholder="Home Title" class="form-control" value="<?=$settings->home_title?>">
            </label>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::meta_description?></label>
          <div class="col-md-9">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Description of Homepage" name="meta_description" style="height: 100px"><?=$settings->meta_description?></textarea>
              <label for=""><?=T::message?></label>
            </div>
          </div>
        </div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::xml_sitemap?></label>
          <div class="col-md-9">
            <div class="row">
              <label class="col-md-6"><a class="btn-block btn btn-warning w-100" target="_blank" href="../sitemap.xml"><?=T::sitemap?></a></label>
              <label class="col-md-6">
                <?php if (isset($permission_edit)){ ?>
              <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
              <?php } ?>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-raised mb-3">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::accounts?></strong></div>
        <div class="card-subtitle mb-4"><?=T::users_and_accounts_settings?></div>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::guest_booking?></label>
          <div class="col-md-9">
          <select class="form-select guest_booking" name="guest_booking">
            <option value="1"><?=T::yes?></option>
            <option value="0"><?=T::no?></option>
          </select>
            <small><?=T::if_selected_yes_only_registered_users_Can_book?></small>
          </div>
        </div>
        <script>
            $("[name='guest_booking']").val(<?=$settings->guest_booking?>)
        </script>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::users_registration?></label>
          <div class="col-md-9">
          <select class="form-select" name="user_registration">
          <option value="1"><?=T::yes?></option>
          <option value="0"><?=T::no?></option>
          </select>
          </div>
        </div>
        <script>
            $("[name='user_registration']").val(<?=$settings->user_registration?>)
        </script>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::suppliers_registration?></label>
          <div class="col-md-9">
          <select class="form-select" name="supplier_registration">
          <option value="1"><?=T::yes?></option>
          <option value="0"><?=T::no?></option>
          </select>
          </div>
        </div>
        <script>
            $("[name='supplier_registration']").val(<?=$settings->supplier_registration?>)
        </script>
        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::agents_registration?></label>
          <div class="col-md-9">
          <select class="form-select" name="agent_registration">
          <option value="1"><?=T::yes?></option>
          <option value="0"><?=T::no?></option>
          </select>
          </div>
        </div>
        <script>
            $("[name='agent_registration']").val(<?=$settings->agent_registration?>)
        </script>
        <div class="text-end">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="card card-raised mb-3">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::system?> <?=T::settings?></strong></div>
        <div class="card-subtitle mb-4"><?=T::system_settings_and_configurations?></div>

        <div class="row form-group mb-3">
          <label class="col-md-3 control-label text-left pt-2"><?=T::tracking_and_analytics?></label>
          <div class="col-md-9">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Paste your tracking &amp; analytics code here." name="javascript" style="height: 100px"><?=$settings->javascript?></textarea>
              <label for=""><?=T::tracking_code?></label>
            </div>
          </div>
        </div>
        <div class="text-end">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>        </div>
      </div>
    </div>

    <div class="card card-raised mb-3">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::contact?></strong></div>
        <div class="card-subtitle mb-4"><?=T::contact_details?></div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="address" value="<?=$settings->address?>" class="form-control">
        <label for=""><?=T::address?></label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="map_address" value="<?=$settings->map_address?>" class="form-control">
        <label for=""><?=T::adress_on_map?></label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="contact_email" value="<?=$settings->contact_email?>" class="form-control">
        <label for=""><?=T::contact?> <?=T::email?></label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="contact_phone" value="<?=$settings->contact_phone?>" class="form-control">
        <label for=""><?=T::contact?> <?=T::phone?></label>
        </div>
         
        <div class="text-end">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>        </div>
      </div>
    </div>

  </div>
  <div class="col-lg-4">
    <div class="card card-raised mb-3" style="min-height:760px;">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::branding?></strong></div>
        <div class="card-subtitle mb-4"><?=T::business_logo_and_favicon?></div>
        <!-- Account privacy optinos-->
        <div class="card p-3 mb-3">
          <label><strong><?=T::business_logo?></strong></label>
          <div class="caption fst-italic text-muted mb-4"><?=T::Only_png_file_supported_max_size_1_mb?></div>
          <img src="../uploads/global/logo.png?v<?=rand(0,99999999999)?>" class="hlogo_preview_img img-fluid">
          <hr>
          <input type="file" class="btn btn-light" id="hlogo" name="logo">
        </div>
        <div class="card p-3 mb-3">
          <label><strong><?=T::favicon?></strong></label>
          <div class="caption fst-italic text-muted mb-4"><?=T::Only_png_file_supported_max_size_1_mb?></div>
          <img src="../uploads/global/favicon.png?v<?=rand(0,99999999999)?>" class="favimage_preview_img img-fluid" style="max-width:60px">
          <hr>
          <input type="file" class="btn btn-light" id="favimage" name="favicon">
        </div>
        <div class="text-end">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>
        </div>
        
      </div>
    </div>

    <div class="card card-raised mb-3">
      <div class="card-body p-4">
        <!-- <div class="card-title">Cover and Social Media</div>
        <div class="card-subtitle mb-4">Homepage cover and media channels link</div> -->

        <div class="card p-3 mb-3">
          <label><strong><?=T::homepage_cover?></strong></label>
          <div class="caption fst-italic text-muted mb-4"><?=T::Only_png_file_supported_max_size_1_mb?></div>
          <img src="../uploads/global/bg.png?v<?=rand(0,99999999999)?>" class="coverimage_preview_img img-fluid" style="max-width:100%">
          <hr>
          <input type="file" class="btn btn-light" id="coverimage" name="coverimage">
        </div>
        <div class="text-end">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>
        </div>

      </div>
    </div>

    <div class="card card-raised mb-3">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::language_and_currencies?></strong></div>
        <div class="card-subtitle mb-4"><?=T::configure_default_settings?></div>

        <div class="form-floating mb-3">
        <select class="form-select" name="multi_language">
        <option value="1"><?=T::yes?></option>
        <option value="0"><?=T::no?></option>
        </select>
        <label for=""><?=T::multi_language?></label>
        </div>

        <script>
            $("[name='multi_language']").val(<?=$settings->multi_language?>)
        </script>

        <div class="form-floating mb-3">
        <select class="form-select" name="multi_currency">
        <option value="1"><?=T::yes?></option>
        <option value="0"><?=T::no?></option>
        </select>
        <label for=""><?=T::multi_currency?></label>
        </div>

        <script>
            $("[name='multi_currency']").val("<?=$settings->multi_currency?>")
        </script>
        <div class="text-end">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="card card-raised mb-5">
      <div class="card-body p-4">
        <div class="card-title"><strong><?=T::social_links?></strong></div>
        <div class="card-subtitle mb-4"><?=T::social_media_pages_links?></div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_facebook" value="<?=$settings->social_facebook?>" class="form-control">
        <label for="">Facebook</label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_twitter" value="<?=$settings->social_twitter?>" class="form-control">
        <label for="">Twitter</label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_linkedin" value="<?=$settings->social_linkedin?>" class="form-control">
        <label for="">LinkedIn</label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_instagram" value="<?=$settings->social_instagram?>" class="form-control">
        <label for="">Instagram</label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_google" value="<?=$settings->social_google?>" class="form-control">
        <label for="">Google</label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_youtube" value="<?=$settings->social_youtube?>" class="form-control">
        <label for="">Youtube</label>
        </div>

        <div class="form-floating mb-3">
        <input type="text" placeholder="" name="social_whatsapp" value="<?=$settings->social_whatsapp?>" class="form-control">
        <label for="">Whatsapp</label>
        </div>
        
        <div class="text-end mt-2">
        <?php if (isset($permission_edit)){ ?>
          <button class="btn-block btn btn-primary" type="submit"> <?=T::updating_settings?></button>
          <?php } ?>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

<input type="hidden" name="form_token" value="<?=$_SESSION["form_token"]?>">
</form>

</div>

<script>
  $(function(){

  offstatus();
  // mailserver options
  var mailserver = $("#mailserver").val();
  if(mailserver == "php"){
  $(".smtp").hide();
   }else{
  $(".smtp").show();
  }
  // mailserver options
  $("#mailserver").on('change', function() {
  var mserver = $(this).val();
  if(mserver == "php"){
  $(".smtp").hide();
  }else{
  $(".smtp").show();
  }
  });

  // OFFLINE OPTION SELECTION
  $(".site_offline").on('change', function() {
    offstatus();
  });

  $("#hlogo").change(function(){

  var preview = $('.hlogo_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("hlogo").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });

  $("#favimage").change(function(){
  var abc = $(this).attr('name');

  var preview = $('.favimage_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("favimage").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });

  // COVERIMAGE
  $("#coverimage").change(function(){
  var abc = $(this).attr('name');

  var preview = $('.coverimage_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("coverimage").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });


  $("#wmlogo").change(function(){

  var preview = $('.wmlogo_preview_img');
  preview.fadeOut();

  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("wmlogo").files[0]);

  oFReader.onload = function (oFREvent) {
  preview.attr('src', oFREvent.target.result).fadeIn();
  };

  });

  $(".testEmail").on('click',function(){
    var id = $(".testemailtxt").val();
    $.post("https://phptravels.net/api/admin/ajaxcalls/testingEmail", {email: id}, function(resp){
    alert(resp);
    console.log(resp);
    });
  })

  });

  // function themeinfo(){
  // var id = $(".theme").val();

  // $.post("https://phptravels.net/api/admin/ajaxcalls/ThemeInfo", {theme: id}, function(resp){
  // var obj = jQuery.parseJSON(resp);

  // $("#themename").html(obj.Name);
  // $("#themedesc").html(obj.Description);
  // $("#themeauthor").html(obj.Author);
  // $("#themeversion").html(obj.Version);
  // $("#screenshot").prop("src",obj.screenshot);

  // });
  // }

  function submission(){ $('.bodyload').fadeIn(150); }

  function offstatus(){
  var status = $(".site_offline").val();
  if(status == "1"){ $("#offmsg").prop("readonly",false); }else{
    $("#offmsg").prop("readonly",true);
  } }


</script>

<?php include "_footer.php" ?>