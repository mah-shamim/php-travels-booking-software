<script>
  $(function(){
    themeinfo();
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

    // offline status option
  $(".offstatus").on('change', function() {
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
    $.post("<?php echo base_url();?>admin/ajaxcalls/testingEmail", {email: id}, function(resp){
    alert(resp);
    console.log(resp);
    });
  })

  });

  function themeinfo(){
  var id = $(".theme").val();

  $.post("<?php echo base_url();?>admin/ajaxcalls/ThemeInfo", {theme: id}, function(resp){
  var obj = jQuery.parseJSON(resp);

  $("#themename").html(obj.Name);
  $("#themedesc").html(obj.Description);
  $("#themeauthor").html(obj.Author);
  $("#themeversion").html(obj.Version);
  $("#screenshot").prop("src",obj.screenshot);

  });
  }

  function offstatus(){
  var status = $(".offstatus").val();
  if(status == "1"){
    $("#offmsg").prop("readonly",false);
  }else{
    $("#offmsg").prop("readonly",true);
  }
  }
</script>
<style>
  .nav-tabs > li > a {letter-spacing:0px}
  .nav-tabs > li > a:active {color:#000 !important}
</style>

<?php if(!empty($errormsg)){  echo '<div class="alert alert-success">'.$errormsg.'</div>'; } ?>

<form action="" method="POST" enctype="multipart/form-data" class="row form-horizontal">
  <div class="col-md-4 sticky">
    <div class="panel panel-default">
      <div class="panel-heading">Main Settings</div>
      <div class="panel-body">
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Business Name</label>
          <div class="col-md-9">
            <input name="site_title" type="text"  placeholder="Business Name" class="form-control" value="<?php echo $settings[0]->site_title;?>" />
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Site URL</label>
          <div class="col-md-9">
            <input class="form-control" type="text" placeholder="Website url here" name="site_url" value="<?php echo $settings[0]->site_url;?>">
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">License Key</label>
          <div class="col-md-9">
            <input class="form-control" type="text" placeholder="License Key" name="license" value="<?php echo $settings[0]->license_key;?>">
          </div>
        </div>
        <div class="row form-group">
              <label  class="col-md-3 control-label text-left">API AppKey</label>
              <div class="col-md-9">
                <input name="mobile[apiKey]" type="text"  placeholder="API Key" class="form-control" value="<?php echo $mobileSettings->apiKey;?>" />
            <div style="width: 100%; text-align: center; background: #eee; padding: 6px;">API URL : <a target="_blank" href="<?php echo base_url(); ?>"><strong><?php echo base_url(); ?></strong></a> </div>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Copyrights</label>
          <div class="col-md-9">
            <input name="copyright" type="text" placeholder="copyrights" class="form-control" value="<?php echo $settings[0]->copyright; ?>"/>
          </div>
        </div>
        <div class="row form-group" hidden>
          <label  class="col-md-3 control-label text-left">Date Formate</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="pt_date_format">
              <option value="d/m/Y" <?php if ($settings[0]->date_f == "d/m/Y") {echo "selected";}?> >dd/mm/yyyy</option>
              <option value="m/d/Y" <?php if ($settings[0]->date_f == "m/d/Y") {echo "selected";}?> >mm/dd/yyyy</option>
            </select>
          </div>
          </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Multi Language</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="multi_lang">
              <option value="1" <?php if ($settings[0]->multi_lang == '1') {echo 'selected';}?> >Enabled</option>
              <option value="0" <?php if ($settings[0]->multi_lang == '0') {echo 'selected';}?> >Disabled</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Default Language</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="default_lang">
              <?php
                $language_list = pt_get_languages();
                foreach ($language_list as $langid => $langname) {
                ?>
              <option value="<?php echo $langid;?>" <?php if ($settings[0]->default_lang == $langid) {echo 'selected';}?> ><?php echo $langname['name'];?></option>
              <?php
                }
                ?>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Multi Currency</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="multicurr">
              <option value="1" <?php if ($settings[0]->multi_curr == "1") {echo 'selected';}?> >Enable</option>
              <option value="0" <?php if ($settings[0]->multi_curr == "0") {echo 'selected';}?> >Disable</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Guest Booking </label>
          <div class="col-md-9">
            <select name="restrict" class="form-control">
              <option value="No" <?php makeSelected('No',$settings[0]->restrict_website); ?> > No </option>
              <option value="Yes" <?php makeSelected('Yes',$settings[0]->restrict_website); ?> > Yes ( Only registered users can book)</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Users Registration</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="allow_registration">
              <option value="1" <?php if ($settings[0]->allow_registration == "1") {echo "selected";}?> >Yes</option>
              <option value="0" <?php if ($settings[0]->allow_registration == "0") {echo "selected";}?> >No</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Users Reg. Approval</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="user_reg_approval">
              <option value="Yes" <?php if ($settings[0]->user_reg_approval == "Yes") {echo "selected";}?> >Auto Approve</option>
              <option value="No" <?php if ($settings[0]->user_reg_approval == "No") {echo "selected";}?> >Admin Approve</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Suppliers</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="allow_supplier_registration">
              <option value="1" <?php if ($settings[0]->allow_supplier_registration == "1") {echo "selected";}?> >Enabled</option>
              <option value="0" <?php if ($settings[0]->allow_supplier_registration == "0") {echo "selected";}?> >Disabled</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Agents</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="allow_agent_registration">
              <option value="1" <?php if ($settings[0]->allow_agent_registration == "1") {echo "selected";}?> >Enabled</option>
              <option value="0" <?php if ($settings[0]->allow_agent_registration == "0") {echo "selected";}?> >Disabled</option>
            </select>
          </div>
        </div>
        <div class="row form-group">
          <label  class="col-md-3 control-label text-left">Reviews</label>
          <div class="col-md-9">
            <select data-placeholder="Select" class="form-control" name="reviews">
              <option value="Yes" <?php if ($settings[0]->reviews == "Yes") {echo "selected";}?> >Auto Approve</option>
              <option value="No" <?php if ($settings[0]->reviews == "No") {echo "selected";}?> >Admin Approve</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading" style="border-bottom: 1px solid #fff">
        <!--<div class="panel-title"><i class="fa fa-cogs"></i>Application Settings</div>-->
        <ul class="nav nav-tabs" style="display: flex; justify-content: center; align-items: center;">
          <li class="active"><a href="#GENERAL" data-toggle="tab">General</a></li>
          <!--<li class=""><a href="#SINGLE" data-toggle="tab">Single Site</a></li>-->
          <li class=""><a href="#MOBILE" data-toggle="tab">Mobile</a></li>
          <li class=""><a href="#WATERMARK" data-toggle="tab">WaterMark</a></li>
          <li class=""><a href="#EMAIL" data-toggle="tab">Email</a></li>
          <li class=""><a href="#THEMES" data-toggle="tab">Themes</a></li>
          <li class=""><a href="#CONTACT" data-toggle="tab">Contact</a></li>
          <li class=""><a href="#SERVER" data-toggle="tab">Server Info</a></li>
        </ul>
      </div>
      <div class="panel-body">
        <div class="tab-content form-horizontal">
          <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
            <div class="well well-sm">
              <div class="panel-body">
                <label  class="col-md-2 control-label text-left">Business Logo</label>
                <div class="col-md-4">
                  <div class="input-group input-xs">
                    <input type="file" class="btn btn-default" id="hlogo" name="hlogo">
                    <span class="help-block">Only PNG file supported</span>
                  </div>
                </div>
                <div class="col-md-4 pull-right">
                  <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'logo.png?id='.rand(1,99);?>"  class="hlogo_preview_img img-responsive" />
                </div>
              </div>
            </div>
            <div class="well well-sm">
              <div class="panel-body">
                <label  class="col-md-2 control-label text-left">Favicon</label>
                <div class="col-md-4">
                  <div class="input-group input-xs">
                    <input type="file" class="btn btn-default" id="favimage" name="favimg">
                    <span class="help-block">Only PNG file supported</span>
                  </div>
                </div>
                <div class="col-md-2 pull-right">
                  <img style="border-radius:6px" src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png?id='.rand(1,99);?>" width="60" height="60" alt="" class="img-responsive favimage_preview_img pull-right" />
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Offline</label>
              <div class="col-md-5">
                <select data-placeholder="Select" class="form-control offstatus" name="site_offine">
                  <option value="1" <?php if ($settings[0]->site_offline == '1') {echo 'selected';}?> >Yes</option>
                  <option value="0" <?php if ($settings[0]->site_offline == '0') {echo 'selected';}?> >No</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Offline Message</label>
              <div class="col-md-10">
                <textarea name="offlinemsg" id="offmsg" placeholder="Our website is currently offline for maintenance. Please visit us later." class="form-control" cols="" rows="2"><?php echo $settings[0]->offline_message; ?></textarea>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Home Title</label>
              <div class="col-md-10">
                <input name="slogan" type="text" placeholder="Slogan" class="form-control" value="<?php echo $settings[0]->home_title;?>" />
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Default Keywords</label>
              <div class="col-md-10">
                <input class="form-control" type="text" placeholder="Keyword of homepage" name="keywords" value="<?php echo $settings[0]->keywords;?>" >
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Default Description</label>
              <div class="col-md-10">
                <textarea class="form-control" rows="2" placeholder="Description of homepage" name="meta_description" ><?php echo $settings[0]->meta_description;?></textarea>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left"> Google Map API </label>
              <div class="col-md-10">
                <input class="form-control" type="text" placeholder="Google Map API" name="mapapi" value="<?php echo $settings[0]->mapApi; ?>" >
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Tracking & Analytics</label>
              <div class="col-md-10">
                <textarea class="form-control" rows="4" placeholder="Paste your tracking & analytics code here" name="gacode" ><?php echo $settings[0]->google;?></textarea>
              </div>
            </div>
            <!-- <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Force SSL</label>
              <div class="col-md-2">
              <select data-placeholder="Select" class="form-control" name="ssl_url">
              <option value="1" <?php if ($settings[0]->ssl_url == '1') {echo 'selected';}?> >Enabled</option>
              <option value="0" <?php if ($settings[0]->ssl_url == '0') {echo 'selected';}?> >Disabled</option>
              </select>
              </div>
              </div> -->
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Booking Expiry </label>
              <div class="col-md-6">
                <input class="form-control" type="number" placeholder="Days" name="bookingexpiry" min="1" value="<?php echo $settings[0]->booking_expiry;?>">
              </div>
              <small><strong> Enter Number of days in which unpaid booking expires</strong></small>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Coupon code Type </label>
              <div class="col-md-6">
                <select data-placeholder="Select" class="form-control" name="coupon_code_type">
                  <option value="alpha" <?php if ($settings[0]->coupon_code_type == "alpha") {echo "selected";}?> >Alphabets Only</option>
                  <option value="numeric" <?php if ($settings[0]->coupon_code_type == "numeric") {echo "selected";}?> > Numbers Only </option>
                  <option value="alnum" <?php if ($settings[0]->coupon_code_type == "alnum") {echo "selected";}?> > Alphabets and Numbers both</option>
                </select>
              </div>
              <small><strong>Select Coupon Code type to be generated as coupon codes </strong></small>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left"> Coupon code Length </label>
              <div class="col-md-6">
                <input class="form-control" type="number" placeholder="" name="codelength" min="4" max="8" value="<?php echo $settings[0]->coupon_code_length;?>">
              </div>
              <small><strong>Enter coupon code length min: 4, max: 8  </strong></small>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">RSS Enabled</label>
              <div class="col-md-4">
                <select name="rss" class="form-control">
                  <option value="1" <?php if ($settings[0]->rss == '1') {echo 'selected';}?>>Enabled</option>
                  <option value="0" <?php if ($settings[0]->rss == '0') {echo 'selected';}?>>Disabled</option>
                </select>
              </div>
              <label class="col-md-3"><a class="btn btn-success btn-block" target="_blank" href="<?php base_url(); ?>admin/settings/downloadSitemap">Download Sitemap</a></label>
              <label class="col-md-3"><a class="btn btn-primary btn-block" target="_blank" href="<?php base_url(); ?>sitemap.xml">Show Sitemap</a></label>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Check Updates</label>
              <div class="col-md-4">
                <select name="updates" class="form-control">
                  <?php for($i = 1; $i <= 7; $i++){ $d = $i * 24; if($i > 1){ $days = "Days"; }else{ $days = "Day"; } ?>
                  <option value="<?php echo $d;?>" <?php if ($settings[0]->updates_check == $d) {echo 'selected';}?>>Every <?php echo $i." ".$days; ?></option>
                  <?php } ?>
                  <option value="0" <?php if ($settings[0]->updates_check == '0') {echo 'selected';}?>>Never</option>
                </select>
              </div>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in form-horizontal" id="SINGLE">
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Status</label>
              <div class="col-md-2">
                <select class="form-control" name="spa_status">
                  <option>Select Status</option>
                  <option value="enable" <?=($spa_settings->spa_status == 'enable')?'selected':''?>>Enable</option>
                  <option value="disable" <?=($spa_settings->spa_status == 'disable')?'selected':''?>>Disable</option>
                </select>
              </div>
              <div class="col-md-6">
                <p style="padding: 5px;">By enabling this feauture you site will convert to one page content site.</p>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Module Name</label>
              <div class="col-md-2">
                <select class="form-control" name="spa_module">
                  <!--<option>Select Module</option>-->
                  <option value="hotels" <?=($spa_settings->spa_module == 'hotels')?'selected':''?>>Hotels</option>
                  <option value="tours" <?=($spa_settings->spa_module == 'tours')?'selected':''?>>Tours</option>
                  <option value="cars" <?=($spa_settings->spa_module == 'cars')?'selected':''?>>Cars</option>
                </select>
              </div>
              <div class="col-md-8">
                <select class="chosen-multi-select" data-placeholder="my placeholder"  name="spa_homepage"><?=$spa_homepage_dd?></select>
              </div>
            </div>
            <script>
              $('[name=spa_module]').change(function(){
                  var payload = { module: $(this).val() };
                  $.get('<?=base_url("suggestions/spaAutoComplete")?>',payload,function(res){
                      // var res=JSON.parse(res);
                      $('[name=spa_homepage]').html(res.html);
                  });
              });
            </script>
            <div class="alert alert-danger">
              <p>Please select your disired content from selectbox to appear on main site. please note this is highly recommended to use this option only when you are running single business website for example : Hotel owner, tour operator or car rental only.</p>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="MOBILE">
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Mobile Section Footer</label>
              <div class="col-md-2">
                <select data-placeholder="Select" class="form-control" name="mobile[mobileSectionStatus]">
                  <option value="Yes" <?php makeSelected('Yes',$mobileSettings->mobileSectionStatus); ?> >Enable</option>
                  <option value="No" <?php makeSelected('No',$mobileSettings->mobileSectionStatus); ?> > Disable</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile[iosUrl]" placeholder="iOS Store URL" value="<?php echo $mobileSettings->iosUrl;?>" />
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile[androidUrl]" placeholder="Android Store URL" value="<?php echo $mobileSettings->androidUrl;?>" />
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Front-end Mob Redirect</label>
              <div class="col-md-2">
                <select data-placeholder="Select" class="form-control" name="mobile[mobileRedirectStatus]">
                  <option value="Yes" <?php makeSelected('Yes',$mobileSettings->mobileRedirectStatus); ?> >Enable</option>
                  <option value="No" <?php makeSelected('No',$mobileSettings->mobileRedirectStatus); ?> > Disable</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="mobile[mobileRedirectUrl]" placeholder="URL" value="<?php echo @$mobileSettings->mobileRedirectUrl;?>" />
              </div>
              <p>Enable this only if you want to redirect mobile users.</p>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">About Us</label>
              <div class="col-md-10">
                <textarea class="form-control" rows="10"  name="mobile[aboutUs]" placeholder="About Us" ><?php echo @$mobileSettings->aboutUs;?></textarea>
              </div>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="WATERMARK">
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Enable</label>
              <div class="col-md-5">
                <select data-placeholder="Select" class="form-control" name="wm_status">
                  <option value="1" <?php echo makeSelected("1",$wm_settings[0]->wm_status); ?> >Yes</option>
                  <option value="0" <?php echo makeSelected("0",$wm_settings[0]->wm_status); ?> >No</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Position</label>
              <div class="col-md-5">
                <select data-placeholder="Select" class="form-control" name="img_position">
                  <option value="tr" <?php echo makeSelected("tr",$wm_settings[0]->wm_position); ?> >Top Right</option>
                  <option value="tl" <?php echo makeSelected("tl",$wm_settings[0]->wm_position); ?> >Top Left</option>
                  <option value="tc" <?php echo makeSelected("tc",$wm_settings[0]->wm_position); ?> >Top Center</option>
                  <option value="br" <?php echo makeSelected("br",$wm_settings[0]->wm_position); ?> >Bottom Right</option>
                  <option value="bl" <?php echo makeSelected("bl",$wm_settings[0]->wm_position); ?> >Bottom Left</option>
                  <option value="bc" <?php echo makeSelected("bc",$wm_settings[0]->wm_position); ?> >Bottom Center</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Watermark Image</label>
              <div class="col-md-4">
                <div class="input-group input-xs">
                  <input type="file" class="btn btn-default" id="wmlogo" name="wmimg">
                  <span class="help-block">Only PNG file supported</span>
                </div>
              </div>
              <div class="col-md-4 pull-right">
                <img src="<?php echo PT_GLOBAL_IMAGES_FOLDER.'watermark.png?id='.rand(1,99);?>"  class="wmlogo_preview_img img-responsive" />
              </div>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="EMAIL">
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Mailer</label>
              <div class="col-md-4">
                <select name="defmailer" class="form-control" id="mailserver">
                  <option value="php" <?php if( $mailserver[0]->mail_default == "php"){ echo "selected"; } ?> >PHP Mailer</option>
                  <option value="smtp" <?php if( $mailserver[0]->mail_default == "smtp"){ echo "selected"; } ?>   >SMTP</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Email</label>
              <div class="col-md-4">
                <input type="email" name="fromemail" placeholder="Email" class="form-control" value="<?php echo $mailserver[0]->mail_fromemail;?>" />
              </div>
            </div>
            <hr>
            <div class="smtp">
              <div class="row form-group">
                <label  class="col-md-2 control-label text-left">SMTP Secure</label>
                <div class="col-md-2">
                  <select name="smtpsecure" class="form-control">
                    <option value="ssl" <?php if( $mailserver[0]->mail_secure == "ssl"){ echo "selected"; } ?>>SSL</option>
                    <option value="tls" <?php if($mailserver[0]->mail_secure == "tls"){ echo "selected"; } ?> >TLS</option>
                    <option value="no" <?php if($mailserver[0]->mail_secure == "no"){ echo "selected"; } ?> >No</option>
                  </select>
                </div>
              </div>
              <div class="row form-group">
                <label  class="col-md-2 control-label text-left">SMTP Host</label>
                <div class="col-md-4">
                  <input type="text" name="smtphost" placeholder="Host" class="form-control" value="<?php echo $mailserver[0]->mail_hostname;?>" />
                </div>
              </div>
              <div class="row form-group">
                <label  class="col-md-2 control-label text-left">SMTP Port</label>
                <div class="col-md-2">
                  <input type="text" name="smtpport" placeholder="Port" value="<?php echo $mailserver[0]->mail_port;?>" class="form-control"/>
                </div>
              </div>
              <div class="row form-group">
                <label  class="col-md-2 control-label text-left">SMTP Username</label>
                <div class="col-md-4">
                  <input type="text" name="smtpuser" placeholder="Username" value="<?php echo $mailserver[0]->mail_username;?>" class="form-control"/>
                </div>
              </div>
              <div class="row form-group">
                <label  class="col-md-2 control-label text-left">SMTP Password</label>
                <div class="col-md-4">
                  <input type="text" name="smtppass" placeholder="password" value="<?php echo $mailserver[0]->mail_password;?>" class="form-control"/>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left">Test Email Reciever </label>
              <div class="col-md-4">
                <input type="text" name="" placeholder="Email" value="" class="form-control testemailtxt"/>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left "><br></label>
              <div class="col-md-4">
                <span class="btn btn-sm btn-primary testEmail">Test Email</span>
              </div>
            </div>
            <hr>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left ">Global Email Header</label>
              <div class="col-md-10">
                <textarea name="mailheader" class="form-control" rows="40" cols="100"><?php echo $mailserver[0]->mail_header;?></textarea>
              </div>
            </div>
            <div class="row form-group">
              <label  class="col-md-2 control-label text-left ">Global Email Footer</label>
              <div class="col-md-10">
                <textarea name="mailfooter" class="form-control" rows="40" cols="100"><?php echo $mailserver[0]->mail_footer;?></textarea>
              </div>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="THEMES">
            <div class="row form-group">
              <label  class="col-md-1 control-label text-left">Theme</label>
              <div class="col-md-2">
                <select name="theme" class="form-control theme">
                  <?php foreach($themes as $theme => $v )
                    {     @$themeinfo = pt_getThemeInfo( "themes/$theme/style.css" );
                    ?>
                  <option value="<?php echo $theme;?>" <?php if($settings[0]->default_theme == $theme){ echo "selected"; } ?> ><?php echo $themeinfo['Name']; ?></option>
                  <?php  } ?>
                </select>
              </div>
              <div class="col-md-2">
                <img id="screenshot" src="" class="img-responsive img-thumbnail" alt="themes" />
              </div>
              <div class="col-md-6">
                <p><strong>Theme Name :</strong> <span id="themename"></span></p>
                <p><strong>Description :</strong> <span id="themedesc"></span></p>
                <p><strong>Author :</strong> <span id="themeauthor"></span></p>
                <p><strong>Version :</strong> <span id="themeversion"></span></p>
              </div>
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="CONTACT">
            <div class="panel-body">
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Phone Number</label>
                <div class="col-md-4">
                  <input class="form-control input-sm" type="text" placeholder="Phone Number" name="contact_phone" value="<?php echo $contact_data[0]->contact_phone;?>">
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Email</label>
                <div class="col-md-4">
                  <input class="form-control input-sm" type="text" placeholder="Email address" name="contact_email" value="<?php echo $contact_data[0]->contact_email;?>">
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Address</label>
                <div class="col-md-6">
                  <textarea cols="20" rows="5" type="text" class="form-control" placeholder="Office Address" name="contact_address"  /><?php echo $contact_data[0]->contact_address;?></textarea>
                </div>
              </div>
              <input type="hidden" name="contact_page_id" value="<?php echo $contact_data[0]->contact_id;?>">
            </div>
          </div>
          <div class="tab-pane wow fadeIn animated in" id="SERVER">
            <div class="list-group">
              <a href="" class="list-group-item"><strong> Server OS </strong> <span  class="pull-right"><?php echo info_general('os');?></span></a>
              <a href="" class="list-group-item"><strong> Browser </strong> <span  class="pull-right"><?php echo $browserlib->getBrowser()." ".$browserlib->getVersion() ?> </span></a>
              <a data-toggle="modal" href="#phpinfo" class="list-group-item"><strong> PHP Version </strong> <span  class="pull-right"><?php echo phpversion(); echo phpversion('tidy'); ?></span></a>
              <a href="" class="list-group-item"><strong> MySQL Version </strong> <span  class="pull-right"><?php echo info_general('mysqlversion');?></span></a>
              <a href="" class="list-group-item"><strong> MySQLi </strong> <span  class="pull-right"> <?php $mysqli = info_general('mysqli'); if($mysqli){ ?><i class='btn btn-success btn-xs glyphicon glyphicon-ok'></i><?php }else{?><i class='btn btn-danger btn-xs glyphicon glyphicon-remove'></i> <?php } ?> </span></a>
              <a href="" class="list-group-item"><strong> Mod_Rewrite </strong> <span  class="pull-right"> <?php $modrewrite = info_general('modrewrite'); if($modrewrite){ ?><i class='btn btn-success btn-xs glyphicon glyphicon-ok'></i><?php }else{?><i class='btn btn-danger btn-xs glyphicon glyphicon-remove'></i> <?php } ?> </span></a>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-footer">
        <input type="hidden" name="globalsettings" value="1"/>
        <button class="btn btn-primary btn-block btn-lg">Submit</button>
      </div>
    </div>
  </div>
</form>