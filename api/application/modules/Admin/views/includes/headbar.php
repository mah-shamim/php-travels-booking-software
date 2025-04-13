  <header>
  <?php $sidebarReduced = $this->session->userdata('sideBar'); ?>
  <input type="hidden" id="sidebarclass" class="<?php echo $sidebarReduced;?>">
  <nav role="navigation" class="navbar navbar-fixed-top navbar-super social-navbar">
    <div class="navbar-header">
      <a href="<?php echo base_url().$this->uri->segment(1);?>" class="navbar-brand">
      <i class="fa fa-inbox light"></i>
      <span>Dashboard</span>
      </a>
    </div>
    <div class="navbar-toggle navtogglebtn"><i class="fa fa-align-justify"></i>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li class="dropdown navbar-super-fw hidden-xs">
          <a>
            <span>
              <script> function startTime() { var today=new Date(); var h=today.getHours(); var m=today.getMinutes(); var s=today.getSeconds(); m=checkTime(m); s=checkTime(s); document.getElementById('txt').innerHTML=h+":"+m+":"+s; t=setTimeout(function(){startTime()},500); } function checkTime(i) { if (i<10) { i="0" + i; } return i; } </script>
              <strong>
                <body onload="startTime()" class=""></body>
                <div class="pull-left  wow fadeInLeft animated" id="txt"></div>
              </strong>
              &nbsp;|&nbsp;
              <small class="pull-right wow fadeInRight animated">
                <script> var tD = new Date(); var datestr =  tD.getDate(); document.write(""+datestr+""); </script> <script type="text/javascript"> var d=new Date(); var weekday=new Array("","","","","","", ""); var monthname=new Array("January","February","March","April","May","June","July","August","September","Octobar","November","December"); document.write(monthname[d.getMonth()] + " "); </script>
                <script> var tD = new Date(); var datestr = tD.getFullYear(); document.write(""+datestr+""); </script>
              </small>
            </span>
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="divider-vertical"></li>
        <li class="dropdown">
          <a href="#" data-toggle="dropdown" data-hover="dropdown" data-delay="0" class="dropdown-toggle"><i class="fa fa-caret-down fa-lg"></i>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo base_url().$this->uri->segment(1);?>/profile/"><i class="glyphicon glyphicon-user"></i>&nbsp;My Profile</a>
            </li>
            <li>
              <a href="<?php echo base_url().$this->uri->segment(1);?>/logout"><i class="fa fa-sign-out"></i>&nbsp;Log Out</a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="//phptravels.org/submitticket.php?step=2&deptid=1" target="_blank"><i class="fa fa-info"></i>&nbsp;Help</a>
            </li>
          </ul>
        </li>
      </ul>
      <?php if($isadmin){ ?>
      <!--<div class="nav-indicators">
        <ul class="nav navbar-nav navbar-right nav-indicators-body">
          <li class="dropdown nav-notifications">
            <a href="#" data-toggle="dropdown" data-hover="dropdown" data-delay="0" class="dropdown-toggle">
            <span class="badge notifyRevCount"></span><i class="fa fa-comments fa-lg"></i>
            </a>
            <ul class="dropdown-menu revdropdown">
              <li class="nav-notifications-header revnotifyHeader">
                <a tabindex="-1" href="javascript:void(0)">You have <strong><span class="notifyRevCount"></span></strong> Pending Reviews</a>
              </li>
            </ul>
          </li>
          <li class="dropdown nav-messages">
            <a href="javascript:void(0)" data-toggle="dropdown" data-hover="dropdown" data-delay="0" class="dropdown-toggle">
            <span class="badge notifyAccountsCount"></span><i class="fa fa-user fa-lg"></i>
            </a>
            <ul class="dropdown-menu accountsdropdown">
              <li class="nav-messages-header accountsnotifyHeader">
                <a tabindex="-1" href="javascript:void(0)">You have <strong><span class="notifyAccountsCount"></span></strong> Pending Supplier(s)</a>
              </li>
              <li class="nav-messages-footer">
                <a tabindex="-1" href="<?php echo base_url(); ?>admin/accounts/suppliers/">View all Suppliers</a>
              </li>
            </ul>
          </li>
          <li class="dropdown nav-messages">
            <a href="#" data-toggle="dropdown" data-hover="dropdown" data-delay="0" class="dropdown-toggle">
            <span class="badge notifyBookingsCount"></span><i class="fa fa-file-text fa-lg"></i>
            </a>
            <ul class="dropdown-menu bookingsdropdown">
              <li class="nav-messages-header bookingsnotifyHeader">
                <a tabindex="-1" href="javascript:void(0)">You have <strong><span class="notifyBookingsCount"></span></strong> new bookings</a>
              </li>
              <li class="nav-messages-footer">
                <a tabindex="-1" href="<?php echo base_url(); ?>admin/bookings/">View all Bookings</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>-->
      <?php } ?>
    </div>
  </nav>
</header>
<script type="text/javascript">
  $(function(){
    <?php if($isadmin) { ?>
    <?php } ?>

    var sideClass = $("#sidebarclass").prop('class');
    $('body').addClass(sideClass);
    $(".navtogglebtn").on('click',function(){
      var sidebar = '';
      if($('body').hasClass('reduced-sidebar')){
        sidebar = "";
      }else{
        sidebar = "reduced-sidebar";
      }
      $.post("<?php echo base_url();?>admin/ajaxcalls/reduceSidebar", {sidebar: sidebar}, function(resp){
      });
      });
      });

  function getNotifications(){
    // $.post("<?php echo base_url();?>admin/ajaxcalls/notifications",{},function(response){
    //
    //   var resp = $.parseJSON(response);
    //   if(resp.totalReviews > 0){
    //
    //     $(".notifyRevCount").html(resp.totalReviews);
    //     $(".revnotifyHeader").show();
    //     /*if($("li").hasClass("notificationReviews")){
    //
    //     }else{
    //
    //     }*/
    //     $(".notificationReviews").remove();
    //     $(".revnotifyHeader").after(resp.revhtml);
    //
    //
    //   }else{
    //      $(".revnotifyHeader").hide();
    //    $(".notifyRevCount").html("");
    //   }
    //
    //   //Supplier notifications
    //   if(resp.totalAccounts > 0){
    //     $(".notifyAccountsCount").html(resp.totalAccounts);
    //     $(".accountsnotifyHeader").show();
    //     if($("li").hasClass("notificationAccounts")){
    //
    //     }else{
    //      $(".accountsnotifyHeader").after(resp.accountshtml);
    //     }
    //
    //   }else{
    //      $(".accountsnotifyHeader").hide();
    //    $(".notifyAccountsCount").html("");
    //   }
    //
    //  //Booking notifications
    //   if(resp.totalBookings > 0){
    //     $(".notifyBookingsCount").html(resp.totalBookings);
    //     $(".bookingsnotifyHeader").show();
    //     if($("li").hasClass("notificationBookings")){
    //
    //     }else{
    //      $(".bookingsnotifyHeader").after(resp.bookingshtml);
    //     }
    //
    //   }else{
    //      $(".bookingsnotifyHeader").hide();
    //    $(".notifyBookingsCount").html("");
    //   }
    //
    // });
  }
</script>
