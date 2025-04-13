<?php  if (!empty ($tripadvisorinfo->rating)) { ?>
<div class="detail-review-header">
<div class="average-score">
  <div class="progress-radial mx-auto progress-radial-md progress-<?php echo $tripadvisorinfo->rating * 20;?>">
    <div class="overlay">
      <div class="progress-radial-inner">
        <div class="caption">
          <h5><?php echo trans('0396'); ?> <?php echo trans('0340'); ?></h5>
          <p class="number text-primary"><?php echo $tripadvisorinfo->rating;?>/<small>5</small></p>
          <a href="#" class="text-muted"><?php echo $avgReviews->totalReviews; ?> <?php echo trans('035'); ?> </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="content">
<div class="row">
<div class="col-6">
<div class="row gap-20">
<div class="col-12 col-sm-12">
<a href="<?php echo $tripadvisorinfo->web_url;?>" target="_blank"><img class="img-responsive center-block" src="<?php echo PT_GLOBAL_IMAGES_FOLDER . 'tripadvisor.png';?>" alt="tripadvisor" /></a>
</div>
</div>
<div class="row mt-10 gap-20">
<div class="col-12 col-sm-12">
<h4 class="progress-label"><strong><?php echo trans('0303');?> <?php echo $tripadvisorinfo->ranking_data->ranking_string;?></strong></h4>
</div>
</div>
<div class="row mt-10 gap-20">
<div class="col-12 col-sm-12">
<a href="//tripadvisor.com/pages/terms.html" target="_blank"> &copy TripAdvisor 2016</a>
</div>
</div>
<div class="row mt-10 gap-20">
<div class="col-12 col-sm-12">
<p><strong><a href="<?php echo $tripadvisorinfo->web_url;?>" target="_blank"> <?php echo $tripadvisorinfo->num_reviews;?> <?php echo trans('042');?></a></strong></p>
</div>
</div>
<div class="row mt-10 gap-20">
<div class="col-12 col-sm-12">
<strong><?php echo trans('0230');?></strong>
<div class="clearfix"></div>
<img src="<?php echo $tripadvisorinfo->rating_image_url;?>" alt="" />
</div>
</div>
</div>
<div class="col-6">
<br><br><br>
<a class="btn btn-success btn-lg btn-block" href="<?php echo $tripadvisorinfo->write_review;?>" target="_blank"><i class="icon_set_1_icon-68"></i> <?php echo trans('0337');?></a>
<a target="_blank" href="<?php echo $tripadvisorinfo->web_url;?>" class="btn btn-primary btn-lg btn-block btn-lgs"><i class="icon_set_1_icon-93"></i> <?php echo trans('0394');?></a>
</div>
</div>
</div>
</div>
<?php } ?>