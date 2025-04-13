<link rel="stylesheet" href="<?php echo $theme_url; ?>assets/css/circle.css" />
<link rel="stylesheet" href="<?php echo $theme_url; ?>assets/css/single.css" />
<link href="<?php echo $theme_url; ?>assets/include/slider/slider.min.css" rel="stylesheet" />
<link href="<?php echo $theme_url; ?>assets/css/magnific-popup.css" rel="stylesheet" />
<script src="<?php echo $theme_url; ?>assets/js/single.js"></script>
<script src="<?php echo $theme_url; ?>/assets/js/jquery.nicescroll.min.js"></script>
<script src="<?php echo $theme_url; ?>assets/include/slider/slider.js"></script>

<div class="mtslide2 sliderbg2"></div>
 <?php include 'includes/head.php';?>
 <?php include 'includes/map.php';?>
<div id="OVERVIEW" class="container">
<div class="row">
  <div class="col-md-12">
    <div class="panel with-nav-tabs panel-default">
    <div class="tabsbar">
        <ul class="RTL visible-lg visible-md nav nav-tabs nav-justified">
          <li class="text-center"><a class="tabsBtn" href="#OVERVIEW" data-toggle="tab"><?php echo trans('0248');?></a></li>
          <?php if(!empty($offer->desc)){ ?><li class="text-center"><a class="tabsBtn" href="#DESCRIPTION" data-toggle="tab"><?php echo trans('046');?></a></li><?php  } ?>
        </ul>
    </div>
      <div style="padding:10px">
        <div class="row">
           <?php include 'includes/slider.php';?>
           <?php include 'includes/aside.php';?>
        </div>
        </div>
         <?php include 'includes/overview.php';?>
      </div>
   </div>
  </div>
  </div>