<!-- ================================
    START HOTEL AREA
================================= -->
<section class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55 bottom-line"><?=T::hotels_featured_hotels?></h2>
                </div>
            </div>
        </div>
        <div class="row padding-top-50px">
            <div class="col-lg-12">
                <div class="hotel-card-wrap">
                    <div class="hotel-card-carousel carousel-action">
                    <?php
                    foreach ($app->featured_hotels as $hotels){ {
                    $link = root.$session_lang.'/'.strtolower($currency).'/hotel/'.strtolower(str_replace(' ', '-', $hotels->location)).'/'.strtolower(str_replace(" ", "-", $hotels->title)).'/'.$hotels->id.'/'.date('d-m-Y',strtotime('+3 day')).'/'.date('d-m-Y',strtotime('+4 day')).'/1/2/0/1/IN/IN/0';
                    ?>
                    <div class="card-item mb-0">
                            <div class="card-img">
                                <a href="<?=$link?>" class="d-block">
                                 <img data-src="<?=$hotels->thumbnail?>" class="lazyload" alt="hotel-img" style="height:200px">
                                </a>
                              <span class="badge"><?php if(!empty($hotels->discount)){echo $hotels->discount;}else{echo "0";} ?> % <?=T::discount?> </span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><a href="<?=$link?>"><?=$hotels->title?></a></h3>
                                <p class="card-meta"><?=$hotels->location?></p>
                                <div class="card-rating">
                                    <span class="badge text-white">
                                    <?php for ($i = 1; $i <= $hotels->starsCount; $i++) { ?>
                                    <div class="la la-star-o"></div>
                                    <?php } ?>
                                    </span>
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                      <p>
                                        <span class="price__num"><?=$currency?> <?=$hotels->price?></span>
                                        <span class="price__text"><?=T::price?></span>
                                      </p>
                                    <a href="<?=$link?>" class="btn-text"><?=T::details?> <i class="la la-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================
    END HOTEL AREA
================================= -->