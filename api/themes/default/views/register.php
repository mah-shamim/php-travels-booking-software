<div class="container">
  <div class="row mt-5 mb-5">
    <div class="col col align-self-start"></div>
    <div class="modal-content col align-self-center">
      <div class="modal-header">
        <div>
          <h5 class="modal-title title"><?php echo trans('0115');?></h5>
          <p class="font-size-14"><?php echo trans('0659');?></p>
        </div>
      </div>
      <div class="modal-body">
        <div class="contact-form-action" id="login">

            <?php  if(!empty($customerloggedin)){ ?>
            <a href="<?php echo base_url()?>account/logout"><?php echo trans('03');?></a>
            <?php }else{ if (strpos($currenturl,'book') !== false) { }else{ ?>
            <form action="" method="POST" id="headersignupform">

            <div class="resultlogin"></div>
            <div id="login-overlay"></div>
            <?php if(!empty($url)){ ?>
            <input type="hidden" class="url" value="<?php echo base_url().'properties/reservation/'.$url;?>" />
            <?php }else{ ?>
            <input type="hidden" class="url" value="<?php echo base_url();?>account/" />
            <?php } ?>

            <div class="input-box">
              <label class="label-text"><?php echo trans('090');?></label>
              <div class="form-group">
                <span class="la la-user form-icon"></span>
                <input class="form-control" type="text" placeholder="<?php echo trans('090');?>" name="firstname" value="" required>
              </div>
            </div>

            <div class="input-box">
              <label class="label-text"><?php echo trans('091');?></label>
              <div class="form-group">
                <span class="la la-user form-icon"></span>
                <input class="form-control" type="text" placeholder="<?php echo trans('091');?>" name="lastname" value="" required>
              </div>
            </div>

            <div class="input-box">
              <label class="label-text"><?php echo trans('0173');?></label>
              <div class="form-group">
                <span class="la la-phone form-icon"></span>
                <input class="form-control" type="text" placeholder="<?php echo trans('0173');?>" name="phone" value="" required>
              </div>
            </div>

            <div class="input-box">
              <label class="label-text"><?php echo trans('094');?></label>
              <div class="form-group">
                <span class="la la-envelope form-icon"></span>
                <input class="form-control" type="text" placeholder="<?php echo trans('094');?>" name="email" value="" required>
              </div>
            </div>

            <div class="input-box">
              <label class="label-text"><?php echo trans('095');?></label>
              <div class="form-group">
                <span class="la la-lock form-icon"></span>
                <input class="form-control" type="password" placeholder="<?php echo trans('095');?>" name="password" value="" required>
              </div>
            </div>

            <div class="input-box">
              <label class="label-text"><?php echo trans('096');?></label>
              <div class="form-group">
                <span class="la la-lock form-icon"></span>
                <input class="form-control" type="password" placeholder="<?php echo trans('095');?>" name="confirmpassword" value="" required>
              </div>
            </div>

            <div class="form-group">
              <button style="font-size: 16px;" type="submit" class="signupbtn btn_full btn btn-success btn-block btn-lg"><i class="fa fa-check-square-o"></i> <?php echo trans('0115');?></button>
            </div>
            <?php if(!empty($url)){ ?>
            <input type="hidden" class="url" value="<?php echo base_url().'properties/reservation/?'.$url;?>" />
            <?php }else{ ?>
            <input type="hidden" class="url" value="<?php echo base_url();?>account/" />
            <?php } ?>
          </form>
          <?php } } ?>

            <!-- end input-box -->
            <div class="btn-box pb-1">
              <button style="font-size: 16px;" type="submit" class="theme-btn btn-block loginbtn w-100"><?php echo trans('04');?></button>
              <div class="mt-3 row">
                <?php if($registerationAllowed == "1"){ ?>
                <div class="col-md-12">
                <a style="font-size: 16px;" class="btn btn-success br25 btn-block form-group" href="<?php echo base_url();?>register"><span></span><?php echo trans('0237');?></a>
                </div>
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



<script>
$(function(){
var url = $(".url").val();
// start sign up functionality

$("#headersignupform").submit(function(e) {
e.preventDefault();
$.post("<?php echo base_url();?>account/signup",$("#headersignupform").serialize(), function(response){
if($.trim(response) == 'true'){
$(".resultsignup").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
window.location.replace(url);
}else{
$(".resultsignup").html(response); } }); });
// end signup functionality

});
</script>
