<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?> ">
    <title><?php echo $pagetitle;?></title>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/login.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/fa.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/include/login/ladda-themeless.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.js"></script>
    <script src="<?php echo base_url(); ?>assets/include/login/spin.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/include/login/ladda.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
  </head>
  <style>
label {width:100%}
input { font-weight: 400;
    border-radius: 5px; }

  .alert-inverse {position: absolute; margin-top: -270px; margin-left: -30px; width: 350px; height: 300px; text-align: center; padding-top: 124px; text-transform: uppercase; font-weight: bold; font-size: 16px; letter-spacing: 2px; background-color: rgba(19, 19, 19, 0.89); color: #ffffff; }
  .form-signin .form-control { height: 50px; border-radius: 3px;position: relative; -webkit-box-sizing: border-box; box-sizing: border-box; margin-bottom: 10px!important; border: 0px; border: 1px solid #9d9d9d; font-size: 16px; }
  .form-signin .btn-primary { height: 50px; border-radius: 3px !important;font-size: 14px; letter-spacing: 4px; }
  .btn-primary { background: #0031bc;border-radius: 5px; }
   body { background:#ffffff !important }
    .matrialprogress{position:relative;height:10px;display:block;width:100%;background-color:#bfc1ce;border-radius:2px;background-clip:padding-box;margin:.5rem 0 1rem 0;overflow:hidden}
    .matrialprogress .determinate{position:absolute;background-color:inherit;top:0;bottom:0;background-color:#3f51b5;transition:width .3s linear}
    .matrialprogress .indeterminate{background-color:#3f51b5}
    .matrialprogress .indeterminate:before{content:'';position:absolute;background-color:inherit;top:0;left:0;bottom:0;will-change:left,right;-webkit-animation:indeterminate 2.1s cubic-bezier(0.65,0.815,0.735,0.395) infinite;animation:indeterminate 2.1s cubic-bezier(0.65,0.815,0.735,0.395) infinite}
    .matrialprogress .indeterminate:after{content:'';position:absolute;background-color:inherit;top:0;left:0;bottom:0;will-change:left,right;-webkit-animation:indeterminate-short 2.1s cubic-bezier(0.165,0.84,0.44,1) infinite;animation:indeterminate-short 2.1s cubic-bezier(0.165,0.84,0.44,1) infinite;-webkit-animation-delay:1.15s;animation-delay:1.15s}
    @-webkit-keyframes indeterminate{0%{left:-35%;right:100%}
    60%{left:100%;right:-90%}
    100%{left:100%;right:-90%}
    }@keyframes indeterminate{0%{left:-35%;right:100%}
    60%{left:100%;right:-90%}
    100%{left:100%;right:-90%}
    }@-webkit-keyframes indeterminate-short{0%{left:-200%;right:100%}
    60%{left:107%;right:-8%}
    100%{left:107%;right:-8%}
    }@keyframes indeterminate-short{0%{left:-200%;right:100%}
    60%{left:107%;right:-8%}
    100%{left:107%;right:-8%}
    }
body {
    background: #000000
}
body:after {
    content:'';
    position: fixed;
    height: 100%%;
    width: 100%;
    top: 0;
    bottom: 0;
    border-top: 2px solid #000daa;
    background-image: radial-gradient(circle farthest-side at center bottom,#3056d3,#02269e 125%);
    z-index:1;
}
  input { width: 100%; height: 44px; padding: 10px; margin-bottom: 10px; color: #000 !important; font-weight: bold }
  </style>

  <script>
    $(function() {
      Login.init()
    });
  </script>
  <script type="text/javascript">
    $(function () {
    $(".form-signin").on('submit',function(){
    $(".resultlogin").html("<div class='alert alert-inverse loading wow fadeOut animated'>Hold On...</div>");
    $.post("<?php echo base_url().$this->uri->segment(1);?>/login",$(".form-signin").serialize(), function(response){
    var resp = $.parseJSON(response);
    console.log(resp);
    if(!resp.status){
    $(".resultlogin").html("<div class='alert alert-danger loading wow fadeIn animated'>"+resp.msg+"</div>");
    }else{
    $(".resultlogin").html("<div class='alert alert-success login wow fadeIn animated'>Redirecting Please Wait...</div>");
    window.location.replace(resp.url);
    }
    }); });
    $(".resetbtn").on('click',function(){
    var resetemail = $("#resetemail").val();
    if(resetemail == ""){
    alert("Please Enter Email Address");
    }else{
     $(".resultreset").html("<div class='matrialprogress'><div class='indeterminate'></div></div>");
     $.post("<?php echo base_url().$this->uri->segment(1);?>/resetpass",$("#passresetfrm").serialize(), function(response){
     if($.trim(response) == '1'){
     $(".resultreset").html("<div class='alert alert-success'>New Password sent to "+resetemail+", Kindly check email.</div>");
     }else{
     $(".resultreset").html("<div class='alert alert-danger'>Email Not Found</div>");
     } });
     }
     });
     });
  </script>
   <body>
   <?=demo_header();?>
   <div style="z-index: 9999;margin-top:-200px;position: fixed; width: 500px; height: 200px; margin: 7% auto; /* Will not center vertically and won't work in IE6/7. */ left: 0; right: 0;">
    <img data-wow-duration="0.2s" data-wow-delay="0.2s" src="<?php echo base_url(); ?>assets/img/admin.png" class="wow fadeIn center-block" style="width:78px;height:60px;margin-bottom:25px" alt="" />
    <form method="POST" data-wow-duration="0.2s" data-wow-delay="0.2s" class="form-signin form-horizontal wow fadeIn animated" role="form" onsubmit="return false;">
      <div>
        <h2 class="form-heading text-center" style="text-transform: uppercase; letter-spacing: 5px; margin-top: 0px;"><strong>Login Panel</strong></h2>
       <label class="">
        <input type="text" name="email" placeholder="Email" required="" autofocus="" class="">
      </label>
      <label class="">
        <input type="password" name="password" placeholder="Password" required="" autofocus="" class="">
      </label>
       <div class="row form-group">
          <div class="col-xs-6">
            <label class="checkbox">
            <input type="checkbox" name="remember" value="remember-me"> Remember me </label>
          </div>
          <div class="col-xs-6">
            <div class="forget-password text-right">
              <a id="link-forgot" href="javascript:void(0)"> <strong>Forget Password</strong></a>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
      <button data-wow-duration="2s" data-wow-delay="s" type="submit" class="btn btn-primary btn-block ladda-button fadeIn animated btn-lg" data-style="zoom-in">Login</button>
      <div style="margin-top:10px" class="resultlogin"></div>
    </form>
    <form role="form" class="logpanel form-forgot form-horizontal wow flipInY animated" style="display: none"  id="passresetfrm" onsubmit="return false;">
      <h2 class="form-heading text-center"> Forgot Password</h2>
      <div class="resultreset"></div>
      <div style="font-size: 12px;" class="text-center">Enter your email address to reset your password</div>
      <br>
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-envelope"></i>
        </span>
        <input type="email" id="resetemail" name="email" placeholder="Email" class="form-control">
      </div>
      <br>
      <div class="form-actions">
        <button type="button" class="btn btn-primary btn-back"><i class="fa fa-angle-left"></i>&nbsp;Back</button>
        <button id="btn-forgot" type="button" class="btn btn-success pull-right resetbtn ladda-button">Reset My Password</button>
      </div>
    </form>
    </div>
      <div style="background:#001757;position:fixed;bottom:0px;width: 100%; padding: 15px;z-index:9999" data-wow-duration="0.5s" data-wow-delay="0.5s" class="text-center wow fadeIn"><small> <p data-wow-duration="1s" data-wow-delay="1s" class="text-center wow fadeInDown" style="color:#ffffff;margin-bottom: 0px; text-transform: uppercase; letter-spacing: 2px;"> Powered by  <a target="_blank" style="color: #FFFFFF" href="http://phptravels.com"><b>PHPTRAVELS</b></a> <a href="http://phptravels.com/change-log/#<?php echo PT_VERSION; ?>"></a><?php echo PT_VERSION; ?></p> </small></div>
   </body>
</html>
    <script>
    Ladda.bind( 'div:not(.progress-demo) button', { timeout: 2000 } );
    Ladda.bind( '.progress-demo button', {
    	callback: function( instance ) {
    		var progress = 0;
    		var interval = setInterval( function() {
    			progress = Math.min( progress + Math.random() * 0.1, 1 );
    			instance.setProgress( progress );
    			if( progress === 1 ) {
    				instance.stop();
    				clearInterval( interval );
    			}
    		}, 200 );
    	}
    } );
  </script>
  <script src="<?php echo base_url(); ?>assets/js/login.js"></script>
  <script src="<?php echo base_url(); ?>assets/include/icheck/icheck.min.js"></script>
  <link href="<?php echo base_url(); ?>assets/include/icheck/square/grey.css" rel="stylesheet">
  <script>
    var cb, optionSet1;
        $(".checkbox").iCheck({
          checkboxClass: "icheckbox_square-grey",
          radioClass: "iradio_square-grey"
        });

        $(".radio").iCheck({
          checkboxClass: "icheckbox_square-grey",
          radioClass: "iradio_square-grey"
        });
  </script>

  <!-- WOWJs -->
  <script>
    new WOW().init();
  </script>
  <!-- WOWJs -->