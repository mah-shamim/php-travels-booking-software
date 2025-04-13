<?php if(isModuleActive( 'hotels')){ ?>
<!-- ================================
    START HOTEL AREA
================================= -->
<section class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55"><?php echo trans('056');?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-50px">
            <div class="col-lg-12">
                <div class="hotel-card-wrap">
                    <div class="hotel-card-carousel carousel-action">
                   <?php foreach($featuredHotels as $item){ ?>
                    <div class="card-item mb-0">
                            <div class="card-img">
                                <a href="<?php echo $item->slug;?>" class="d-block">
                                    <img src="<?php echo $item->thumbnail;?>" alt="hotel-img" style="height:200px">
                                </a>
                                <?php if(!empty($item->discount)){?><span class="badge"><?=$item->discount?> % <?=lang('0118')?></span><?php } ?>
                                <!--<div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="Bookmark">
                                    <i class="la la-heart-o"></i>
                                </div>-->
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,25);?></a></h3>
                                <p class="card-meta"><?php echo character_limiter($item->location,20);?></p>
                                <div class="card-rating">
                                    <span class="badge text-white"><?php echo $item->stars;?></span>
                                    <!--<span class="review__text">Average</span>
                                    <span class="rating__text">(30 Reviews)</span>-->
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                     <?php if($item->price > 0){ ?>
                                      <p>
                                        <!--<span class="price__from"><?php echo trans( '0142');?></span>-->
                                        <span class="price__num"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                                        <span class="price__text"><?=lang('0245')?> </span>
                                      </p>
                                    <?php } ?>
                                    <a href="<?php echo $item->slug;?>" class="btn-text"><?=lang('052');?><i class="la la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                       <?php } ?>
                    </div><!-- end hotel-card-carousel -->
                </div>
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container-fluid -->
</section><!-- end hotel-area -->
<!-- ================================
    END HOTEL AREA
================================= -->
<?php } ?>