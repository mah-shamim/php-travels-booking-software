<!-- ================================
START DESTINATION AREA
================================= -->
<section class="destination-area section--padding">
<div class="container">
<div class="row align-items-center">
<div class="col-lg-8">
<div class="section-heading">
<h2 class="sec__title_left left-line" style="font-size:22px"><?=T::tours_featured_tours?></h2>
<!--<p class="sec__desc pt-3">Morbi convallis bibendum urna ut viverra Maecenas quis</p> -->
</div><!-- end section-heading -->
</div><!-- end col-lg-8 -->
<div class="col-lg-4">
<!--<div class="btn-box btn--box text-right">
 <a href="<?=root?>tours" class="theme-btn"><?=T::tours_view_more_tours?></a>
</div>-->
</div>
</div><!-- end row -->
<div class="row padding-top-50px">
<?php foreach($app->featured_tours as $item){
$name = str_replace(' ', '-', $item->title);
$link = root.$session_lang.'/'.strtolower($currency).'/tour/'.strtolower(str_replace(' ', '-', $item->location)).'/'.strtolower(str_replace(" ", "-", $item->title)).'/'.$item->id.'/'.date('d-m-Y',strtotime('+3 day')).'/1/0/0'; ?>

<div class="col-lg-4">
<a href="<?=$link?>">
    <div class="card-item destination-card">
        <div class="card-img">
            <img data-src="<?=$item->thumbnail?>" class="lazyload" style="height:250px" alt="destination-img">
            <span class="badge"><?=$item->location?></span>
        </div>
        <div class="card-body mb-1">
            <span class="ratings d-flex align-items-center mr-1">
                <?php for ($i = 1; $i <= $item->starsCount; $i++) { ?>
                <div class="stars la la-star-o"></div>
                <?php } ?>
                <span class="rating__text cw"> <small>( <?=$item->avgReviews->overall?> )</small></span>
                </span>
            <h3 class="card-title"><?=$item->title?></h3>
            <div class="card-rating d-flex align-items-center">
            </div>
            <div class="card-price d-flex align-items-center justify-content-between">
                <p class="tour__text"> <!--<?php //echo trans( '0142'); ?>--></p>
                <?php if($item->price > 0){ ?>
                <p>
                    <span class="price__from"><?=T::price?></span>
                    <span class="price__num"><strong><?=$currency?> <?php echo $item->price?></strong></span>
                </p>
                <?php } ?>
            </div>
        </div>
    </div>
</a>
</div>

<?php } ?>
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end destination-area -->
<!-- ================================
END DESTINATION AREA
================================= -->