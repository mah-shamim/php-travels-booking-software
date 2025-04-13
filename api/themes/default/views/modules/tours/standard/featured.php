<?php if(isModuleActive( 'tours')){ ?>

<!-- ================================
    START DESTINATION AREA
================================= -->
<section class="destination-area section--padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="section-heading">
                    <h2 class="sec__title_left"><?php echo trans('0451');?></h2>
                    <!--<p class="sec__desc pt-3">Morbi convallis bibendum urna ut viverra Maecenas quis</p> -->
                </div><!-- end section-heading -->
            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">
                <div class="btn-box btn--box text-right">
                    <a href="<?php echo base_url(); ?>tours" class="theme-btn"><?=trans('0452')?></a>
                </div>
            </div>
        </div><!-- end row -->
        <div class="row padding-top-50px">

        <?php foreach($featuredTours as $item){ ?>
            <div class="col-lg-4">
               <!-- <div class="card-item destination-card">
                    <div class="card-img">
                        <img src="images/destination-img2.jpg" alt="destination-img">
                        <span class="badge"></span>
                        <?php if(!empty($item->discount)){?><span class="discount"><?=$item->discount?> % <?=lang('0118')?></span><?php } ?>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><a href="tour-details.html"><?php echo character_limiter($item->title,25);?></a></h3>
                        <div class="card-rating d-flex align-items-center">
                            <span class="ratings d-flex align-items-center mr-1">
                                <i class="la la-star"></i>
                                <i class="la la-star"></i>
                                <i class="la la-star"></i>
                                <i class="la la-star-o"></i>
                                <i class="la la-star-o"></i>
                            </span>
                            <span class="rating__text">( <?php echo $item->avgReviews->overall ?> )</span>
                        </div>
                        <div class="card-price d-flex align-items-center justify-content-between">
                            <p class="tour__text">
                                <?php echo $item->tourDays; ?> <?php echo trans('0275');?> / <?php echo $item->tourNights; ?> <?php echo trans('0276');?>
                            </p>


                        </div>
                    </div>
                </div>-->

                <div class="card-item destination-card">
                    <div class="card-img">
                        <img src="<?php echo $item->thumbnail;?>" style="height:250px" alt="destination-img">
                        <span class="badge"><?php echo character_limiter($item->location,20);?></span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php echo $item->slug."?date=".date('d/m/Y')."&adults=1";?>"><?php echo character_limiter($item->title,30);?></a></h3>
                        <div class="card-rating d-flex align-items-center">
                            <span class="ratings d-flex align-items-center mr-1">

                            <?php echo $item->stars;?>  <!--<?php echo trans('042');?>-->

                            </span>
                            <span class="rating__text">( <?php echo $item->avgReviews->overall ?> )</span>
                        </div>
                        <div class="card-price d-flex align-items-center justify-content-between">
                            <p class="tour__text">
                               <!--<?php echo trans( '0142'); ?>-->
                            </p>

                            <?php if($item->price > 0){ ?>
                            <p>
                                <span class="price__from"><?=trans('070')?></span>
                                <span class="price__num"><?php echo $item->currSymbol;?> <?php echo $item->price;?></span>
                            </p>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end destination-area -->
<!-- ================================
    END DESTINATION AREA
================================= -->
<?php } ?>