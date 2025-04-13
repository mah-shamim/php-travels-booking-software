<div class="detail-review-header">
<div class="average-score">
<div class="progress-radial mx-auto progress-radial-md progress-<?php echo ceil(($avgReviews->overall))*10 ;?>">
<div class="overlay">
<div class="progress-radial-inner">
<div class="caption">
<h5><?php echo trans('0396'); ?> <?php echo trans('0340'); ?></h5>
<div class="clear"></div>
<p class="number text-primary"><?php echo $avgReviews->overall;?></p>
<a href="#" class="text-muted"><?php echo $avgReviews->totalReviews; ?> <?php echo trans('035'); ?> </a>
</div>
</div>
</div>
</div>
</div>
<div class="content">
<div class="row gap-10 align-items-center">
<div class="col-12 col-md-6">
<p class="line-125"><?php echo trans('0136'); ?></p>
</div>
<div class="col-12 col-md-6">
<select class="chosen-the-basic form-control" tabindex="2">
<option value="0"><?php echo trans('0396'); ?> (<?php echo $avgReviews->totalReviews; ?>)</option>
</select>
</div>
</div>

</div>
</div>
<div class="review-wrapper mb-10">
<?php if(!empty($reviews) > 0){ ?>
<?php if(!empty($reviews)){ foreach($reviews as $rev){ ?>


<div class="comment">
<div class="comment-avatar">
<img class="avatar__img" alt="" src="<?php echo base_url(); ?>assets/img/user_blank.jpg">
</div>
<div class="comment-body">
<div class="meta-data">
<h3 class="comment__author"><?php echo $rev->review_name;?></h3>
<div class="meta-data-inner d-flex">
<span class="ratings d-flex align-items-center mr-1">
<i class="la la-star"></i>
<i class="la la-star"></i>
<i class="la la-star"></i>
<i class="la la-star"></i>
<i class="la la-star"></i>
</span>
<p class="comment__date"><?php echo pt_show_date_php($rev->review_date);?></p>
</div>
</div>
<p class="comment-content">

<?php if(!empty($rev->reviewUrl)){ ?>
<a href="<?php echo $rev->reviewUrl;?>" target ="_blank">
<?php echo character_limiter($rev->review_comment,1000);?>
</a>
<?php }{ ?> 
<?php echo character_limiter($rev->review_comment,1000);?>
<?php } ?>
</p>
<!--<div class="comment-reply d-flex align-items-center justify-content-between">
<a class="theme-btn" href="#" data-toggle="modal" data-target="#replayPopupForm">
<span class="la la-mail-reply mr-1"></span>Reply
</a>
<div class="reviews-reaction">
<a href="#" class="comment-like"><i class="la la-thumbs-up"></i> 13</a>
<a href="#" class="comment-dislike"><i class="la la-thumbs-down"></i> 2</a>
<a href="#" class="comment-love"><i class="la la-heart-o"></i> 5</a>
</div>
</div>-->
</div>
</div>

<?php } ?>
<?php } ?>
<?php } ?>
</div>