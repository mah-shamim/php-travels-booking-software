<?php if(isModuleActive( 'cars')){ ?>
<!-- ================================
    START CAR AREA
================================= -->
<section class="car-area section-bg section-padding ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title"><?php echo trans('0490');?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-50px">
            <div class="col-lg-12">
                <div class="car-wrap">
                    <div class="car-carousel carousel-action">

                       <?php foreach($featuredCars as $item){ ?>
                        <div class="card-item car-card mb-0">
                            <div class="card-img">
                                <a href="<?php echo $item->slug;?>" class="d-block">
                                    <img src="<?php echo $item->thumbnail;?>" style="height:200px" alt="car-img">
                                </a>
                                <?php if(!empty($item->discount)){?><span class="badge"><span class="discount"><?=$item->discount?> % <?=lang('0118')?></span></span><?php } ?>
                                <!--<div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="Save for later">
                                    <i class="la la-heart-o"></i>
                                </div>-->
                            </div>
                            <div class="card-body">
                                <p class="card-meta"><?php echo character_limiter($item->location,20);?></p>
                                <h3 class="card-title"><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,25);?></a></h3>
                                <div class="card-rating">
                                    <span class="badge text-white"><?php echo $item->stars;?></span>
                                    <!--<span class="review__text">Average</span>
                                    <span class="rating__text">(30 Reviews)</span>-->
                                </div>
                                <!--<div class="card-attributes">
                                    <ul class="d-flex align-items-center">
                                        <li class="d-flex align-items-center" data-toggle="tooltip" data-placement="top" title="Passenger"><i class="la la-users"></i><span>4</span></li>
                                        <li class="d-flex align-items-center" data-toggle="tooltip" data-placement="top" title="Luggage"><i class="la la-suitcase"></i><span>1</span></li>
                                    </ul>
                                </div>-->
                                <div class="card-price d-flex align-items-center justify-content-between">
                                    <?php if($item->price > 0){ ?>
                                    <p>
                                        <span class="price__from"><?php echo trans( '0142');?> </span>
                                        <span class="price__num"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                                        <span class="price__text"><?=lang('0258')?></span>
                                    </p>
                                    <?php } ?>
                                    <a href="<?php echo $item->slug;?>" class="btn-text"><?=trans('052')?><i class="la la-angle-right"></i></a>
                                </div>
                            </div>
                           </div><!-- end card-item -->
                           <?php } ?>

                        </div><!-- end card-item -->
                    </div><!-- end car-carousel -->
                </div>
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
</section><!-- end car-area -->
<!-- ================================
    END CAR AREA
================================= -->
<?php } ?>