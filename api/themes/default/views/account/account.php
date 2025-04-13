<!-- start cssload-loader -->
<div class="preloader" id="preloader">
    <div class="loader">
        <svg class="spinner" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
    </div>
</div>
<!-- end cssload-loader -->

<!-- ================================
       START DASHBOARD NAV
================================= -->
<div class="sidebar-nav">
    <div class="sidebar-nav-body">
        <div class="side-menu-close">
            <i class="la la-times"></i>
        </div><!-- end menu-toggler -->
        <div class="author-content">
            <div class="d-flex align-items-center">
                <div class="author-img avatar-sm">
                    <img src="<?php echo PT_DEFAULT_IMAGE."user.png";?>" alt="testimonial image">
                </div>
                <div class="author-bio">
                    <h4 class="author__title"><?php echo trans('0307');?> <?php echo $profile[0]->ai_first_name; ?> <?php echo $profile[0]->ai_last_name; ?></h4>
                  <span>
                    <script> function startTime() { var today=new Date(); var h=today.getHours(); var m=today.getMinutes(); var s=today.getSeconds(); m=checkTime(m); s=checkTime(s); document.getElementById('txt').innerHTML=h+":"+m+":"+s; t=setTimeout(function(){startTime()},500); } function checkTime(i) { if (i<10) { i="0" + i; } return i; } </script>
                      <strong class="size22">
                        <body onload="startTime()">
                          <div id="txt"></div>
                        </body>
                      </strong>
                      <span>
                        <script> var tD = new Date(); var datestr =  tD.getDate(); document.write(""+datestr+""); </script> <script type="text/javascript"> var d=new Date(); var weekday=new Array("","","","","","", ""); var monthname=new Array("January","February","March","April","May","June","July","August","September","Octobar","November","December"); document.write(monthname[d.getMonth()] + " "); </script>
                        <script> var tD = new Date(); var datestr = tD.getFullYear(); document.write(""+datestr+""); </script>
                      </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="sidebar-menu-wrap">
            <ul class="sidebar-menu list-items">
                <li class="#page-active"><a href="#bookings" data-toggle="tab" onclick="mySelectUpdate()"><i class="la la-shopping-cart mr-2"></i><?php echo trans('072');?></a></li>
                <li><a href="#profile" data-toggle="tab" onclick="mySelectUpdate()"><i class="la la-user mr-2 text-color-2"></i><?php echo trans('073');?></a></li>
                <li><a href="#wishlist" data-toggle="tab" onclick="mySelectUpdate()"><i class="la la-heart mr-2 text-color-4"></i><?php echo trans('074');?></a></li>
                <li><a href="#newsletter" data-toggle="tab" onclick="mySelectUpdate()"><i class="la la-cog mr-2 text-color-5"></i><?php echo trans('023');?></a></li>
                <li><a href="<?=base_url('account/logout')?>"><i class="la la-power-off mr-2 text-color-6"></i><?=trans('03');?></a></li>
            </ul>
        </div><!-- end sidebar-menu-wrap -->
    </div>
</div><!-- end sidebar-nav -->
<!-- ================================
       END DASHBOARD NAV
================================= -->
    <!-- START DASHBOARD AREA -->
<section class="dashboard-area">
  <div class="dashboard-content-wrap tab-content">
    <div class="clearfix"></div>
    <div class="tab-pane fade in active show" id="bookings">
      <?php include $themeurl.'views/account/bookings.php'; ?>
    </div>
    <div class="tab-pane fade in" id="profile">
      <?php include $themeurl.'views/account/profile.php'; ?>
    </div>
    <!-- END OF TAB 2 -->
    <!-- TAB 3 -->
    <div class="tab-pane fade in" id="wishlist">
      <?php include $themeurl.'views/account/wishlist.php'; ?>
    </div>
    <!-- END OF TAB 3 -->
    <!-- TAB 7 -->
    <div style="min-height:464px" class="tab-pane fade in" id="newsletter">
      <?php include $themeurl.'views/account/newsletter.php'; ?>
    </div>
  </div>
</section>


<!-- END OF CONTENT -->
<script type="text/javascript">
 // $('.comments').popover({ trigger: "hover" });
  // Update Profile
  $('.updateprofile').on('click',function(){
//  $('html, body').animate({
//  scrollTop: $(".toppage").offset().top - 100
//  },'slow');
  $.post("<?php echo base_url();?>account/update_profile", $("#profilefrm").serialize(), function(msg){
  $(".accountresult").html(msg).fadeIn("slow");
  slidediv();
      location.reload();
  });
});

  //newsletter subscription
  $(".newsletter").click(function(){
  var email = $(this).val();
  var action = '';
  var msg = '';
  if($(this).prop( "checked" )){
  action = 'add';
  msg = "<?php echo trans('0487');?>";
  }else{
  action = 'remove';
  msg = "<?php echo trans('0489');?>";
  }
  $.post("<?php echo base_url();?>account/newsletter_action", { email: email, action: action }, function(resp){
  $(".accountresult").html('<div class="alert alert-success">'+msg+'</div>').fadeIn("slow");
  slidediv();
  });
  });
  // Remove wish
  $(".removewish").on('click',function(){
  var id = $(this).prop('id');
  var confirm1 = confirm("<?php echo trans('0436');?>");
  if(confirm1){
     $("#wish"+id).fadeOut("slow");
  $.post("<?php echo base_url();?>account/wishlist/single", { id: id }, function(theResponse){
  });
  }
  });

  // Request Cancellation
  $(".cancelreq").on('click',function(){
  var id = $(this).prop('id');
  $.alert.open('confirm', 'Are you sure you want to Cancel this booking', function(answer) {
  if (answer == 'yes'){
  $.post("<?php echo base_url();?>account/cancelbooking", { id: id }, function(theResponse){
  location.reload();
  });
  }
  })
  });

  // Request EAN Cancellation
  $(".ecancel").on('click',function(){
  var id = $(this).prop('id');
  $.alert.open('confirm', 'Are you sure you want to Cancel this booking', function(answer) {
  if (answer == 'yes'){
  $.post("<?php echo base_url();?>ean/cancel", { id: id }, function(theResponse){
    if(theResponse != "0"){
      alert(theResponse);
    }
  //console.log(theResponse);
  location.reload();
  });
  }
  })
  });

  $('.reviewscore').change(function(){
  var sum = 0;
  var avg = 0;
  var id = $(this).attr("id");
  $('.reviewscore_'+id+' :selected').each(function() {
  sum += Number($(this).val());
  });
  avg = sum/5;
  $("#avgall_"+id).html(avg);
  $("#overall_"+id).val(avg);
  });

  //submit review
  $(".addreview").on("click",function(){
  var id = $(this).prop("id");
  $.post("<?php echo base_url();?>account/addreview", $("#reviews-form-"+id).serialize(), function(resp){
  if($.trim(resp) == "done"){
  $("#review_result"+id).html("<div class='matrialprogress'><div class='indeterminate'></div></div>").fadeIn("slow");
  location.reload();
  }else{
  $("#review_result"+id).html(resp).fadeIn("slow");
  }
  });
  setTimeout(function(){
  $("#review_result"+id).fadeOut("slow");
  }, 3000);
  });

  function slidediv(){
  setTimeout(function(){
  $(".accountresult").fadeOut("slow");
  }, 4000);
  }
  function mySelectUpdate(){
    var act = document.querySelectorAll('.active')
    for(var i = 0; i < act.length;i++){
      act[i].classList.remove('active')
    }
  }
</script>

<style>
.header-area{position: relative; z-index: 9999;-webkit-box-shadow: 0 0 40px rgba(82,85,90,0.1); -moz-box-shadow: 0 0 40px rgba(82,85,90,0.1); box-shadow: 0 0 40px rgba(82,85,90,0.1); }
.author-content{padding-top:150px;}
.cw{color:#fff !important}
.footer-area{z-index:9999}
.author-content{padding-top:140px !important}
</style>