<div class="container">
  <div class="row mt-5 mb-5">
    <div class="col col align-self-start"></div>
    <div class="modal-content col align-self-center">
      <div class="modal-header">
        <div>
          <h5 class="modal-title title"><?php echo trans('04');?></h5>
          <p class="font-size-14"><?php echo trans('0658');?></p>
        </div>
      </div>
      <div class="modal-body">
        <div class="contact-form-action">
          <?php  if(!empty($customerloggedin)){ ?>
          <a href="<?php echo base_url()?>account/logout"><?php echo trans('03');?></a>
          <?php }else{ if (strpos($currenturl,'book') !== false) { }else{ ?>
          <form method="POST" action="" id="loginfrm" accept-charset="UTF-8" onsubmit="return false;">
            <div class="resultlogin"></div>
            <div id="login-overlay"></div>
            <?php if(!empty($url)){ ?>
            <input type="hidden" class="url" value="<?php echo base_url().'properties/reservation/'.$url;?>" />
            <?php }else{ ?>
            <input type="hidden" class="url" value="<?php echo base_url();?>account/" />
            <?php } ?>
            <div class="input-box">
              <label class="label-text"><?php echo trans('094');?></label>
              <div class="form-group">
                <span class="la la-user form-icon"></span>
                <input class="form-control" type="email" placeholder="<?php echo trans('094');?>" required="required" name="username">
              </div>
            </div>
            <!-- end input-box -->
            <div class="input-box">
              <label class="label-text"><?php echo trans('095');?></label>
              <div class="form-group mb-2">
                <span class="la la-lock form-icon"></span>
                <input class="form-control" type="password" placeholder="<?php echo trans('095');?>" required="required" name="password">
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="custom-checkbox mb-0">
                  <input type="checkbox" id="rememberchb">
                  <label for="rememberchb"><?php echo trans('0187');?></label>
                </div>
                <p class="forgot-password">
                  <a data-toggle="modal" href="#ForgetPassword"><?php echo trans('0112');?></a>
                </p>
              </div>
            </div>
            <!-- end input-box -->
            <div class="btn-box pt-3 pb-4">
              <button style="font-size: 16px;" type="submit" class="theme-btn btn-lg btn-block loginbtn w-100"><?php echo trans('04');?></button>
              <div class="mt-3 row">
                <?php if($registerationAllowed == "1"){ ?>
                <div class="col-md-12"><a class="btn btn-success br25 btn-block form-group" href="<?php echo base_url();?>register"><span></span><?php echo trans('0237');?></a></div>
                <?php } ?>
              </div>
            </div>
          </form>
        </div>
        <!-- end contact-form-action -->
      </div>
    </div>
    <div class="col align-self-end"></div>
  </div>
</div>
<?php if($fblogin){ ?>
<div class="form-group">
  <a href="<?php echo $fbloginurl;?>" class="btn btn-facebook btn-block"><i class="fa fa-facebook-square" ></i> <?php echo trans('0266');?></a>
</div>
<?php } ?>
<?php } }  ?>
<section>
  <div class="container">
    <!-- PHPTRAVELS forget password starting -->
    <div class="modal wow fadeIn animated" id="ForgetPassword" tabindex="" role="dialog" aria-labelledby="ForgetPassword" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <div>
              <h5 class="modal-title title"><?php echo trans('0112');?></h5>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="passresetfrm" accept-charset="UTF-8" onsubmit="return false;">
              <div class="resultreset"></div>
              <div class="input-group">
                <input type="text" placeholder="your@email.com" class="form-control" id="resetemail" name="email" required>
                <span class="input-group-btn">
                <button type="submit" class="btn btn-primary resetbtn" type="button"><?php echo trans('0114');?></button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PHPTRAVELS forget password ending -->
<script>
$(function(){
var url = $(".url").val();
// start login functionality
$(".loginbtn").on('click',function(){
$.post("<?php echo base_url();?>account/login",$("#loginfrm").serialize(), function(response){ if(response != 'true'){
$(".resultlogin").html("<div class='alert alert-danger'>"+response+"</div>"); }else{
$(".resultlogin").html("<div class='matrialprogress'><div class='indeterminate'></div></div> <div class='alert alert-success'><?php echo trans('0427');?></div>");
window.location.replace(url); }}); });
// end login functionality

// start password reset functionality
$(".resetbtn").on('click',function(){
var resetemail = $("#resetemail").val();
$(".resultreset").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
$.post("<?php echo base_url();?>account/resetpass",$("#passresetfrm").serialize(), function(response){
if($.trim(response) == '1'){
$(".resultreset").html("<div class='alert alert-success'>New Password sent to "+resetemail+", <?php echo trans('0426');?></div>");
}else{
$(".resultreset").html("<div class='alert alert-danger'><?php echo trans('0425');?></div>");
} }); });
// end password reset functionality
});
</script>