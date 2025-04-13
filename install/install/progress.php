<html>
<head>
  <title>Installation</title>
  <link rel="shortcut icon" href="https://phptravels.com/assets/img/favicon.png">
  <style type="text/css">
   progress.active .progress-bar, .progress-bar.active { padding: 10px; }
  </style>
</head>
<body style="background:#ffffff;margin:0px">
<link rel="stylesheet" href="./style.css" />
<div class="progress" style="height:100vh !important">
  <div class="progress-bar progress-bar-striped active" id="progress" style="min-width:10%;display: flex; align-items: center; justify-content: center;">
    <span style="background: rgba(30, 30, 30, 0.8784313725490196); color: #fff; padding: 8px; border-radius: 6px;width:100px" id="information"></span>
  </div>
</div>

<div class="clearfix"></div>
<?php
  $total = 285;
  $arrayTimings = array("5000","10000","30000","400000","3000");
  for($i=1; $i<=$total; $i++){
  $keys = array_rand($arrayTimings);
  $val = $arrayTimings[$keys];
  $percent = intval($i/$total * 100);
  $percentage = $percent."%";
  if($percent == 100){
    $processed = "99%";
  }else{
    $processed = $percentage;
  }
  header( 'Content-type: text/html; charset=utf-8' );
  echo '<script language="javascript">
  document.getElementById("progress").style.width ="'.$processed.'";
  document.getElementById("information").innerHTML="'.$processed.' Completed";
  </script>';
  echo str_repeat(' ',1024*64);
  flush();
  usleep($val);
  }
  echo '<style>body{background:#eee !important;padding:45px}.progress{display: none;-webkit-transition: opacity 3s ease-in-out; -moz-transition: opacity 3s ease-in-out; -ms-transition: opacity 3s ease-in-out; -o-transition: opacity 3s ease-in-out;}</style><script language="javascript">document.getElementById("information").innerHTML="Process Completed"</script>';
?>
<div class="col-md-3"></div>
<div class="col-md-6">

<div class="panel panel-default">
  <div class="panel-heading">Installation Completed</div>
  <div class="panel-body">
  <p>🎉 Congratulations PHPTRAVELS installed successfully</p>
  <hr>
   <div class="block">
      <form action="<?php echo @$_POST['domain']; ?>" target="_blank" method="get">
        <button class="btn btn-default btn-lg btn-block">
          <h4 class="text-center"><strong>Homepage</strong></h4>
        </button>
      </form>
      <hr>
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          <img class="img-rounded img-responsive" style="border-radius: 8px;" src="./includes/assets/img/admin.png" alt="Admin Credentials">
        </div>
        <div class="col-md-10 row">
          <div class="visible-lg">
            <div style="margin-top:10px"></div>
          </div>
          <strong>Admin URL :</strong> <a target="_blank" href="<?php echo @$_POST['domain']; ?>admin/"><?php echo @$_POST['domain']; ?>admin/</a><br>
          <strong>Email :</strong> <?php echo @$_POST['admin_email']; ?><br>
          <strong>Password :</strong> <?php echo @$_POST['admin_password']; ?>
        </div>
      </div>
  </div>
<div class="clearfix"></div>
<hr>
<div class="clearfix"></div>
<p class="bold"><strong>XML Sitemap SEO</strong><br>
<a target="_blank" class="target" href="<?php echo @$_POST['domain']; ?>/sitemap.xml"><?php echo @$_POST['domain']; ?>api/sitemap.xml </a>
</p>
<hr>
<p>Documentation <a target="_blank" class="target" href="//docs.phptravels.com/"><strong>https://docs.phptravels.com</strong></a><br>
Happy Booking Business
</p>
<hr>
<p><span class="bold"><strong>Regards</strong></span><br>
  PHPTRAVELS Team
</p>
</div>
</div>
</div>
<div class="col-md-3"></div>
<div class="clearfix"></div>
</body>
</html>
