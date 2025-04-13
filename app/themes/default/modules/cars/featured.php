<!-- ================================
    START HOTEL AREA
================================= -->
<section class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55 bottom-line">Featured cars</h2>
                </div>
            </div>
        </div>
        <div class="row padding-top-50px">
            <div class="col-lg-12">
                <div class="hotel-card-wrap">
                    <div class="hotel-card-carousel carousel-action">
                                                               
                    <?php foreach ($app->featured_cars as $cars){ {
                    $name = str_replace(' ', '-', $cars->title);
                    ?>
                    <div class="card-item mb-0">
                            <div class="card-img">
                                <a href="#" class="d-block">
                                    <img src="<?=$cars->thumbnail?>" alt="hotel-img" style="height:200px">
                                </a>
                              <span class="badge"><?php if(!empty($cars->discount)){echo $cars->discount;}else{echo "0";} ?> % <?=T::discount?> </span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><a href="#"><?=$cars->title?></a></h3>
                                <p class="card-meta"><?=$cars->location?></p>
                                <div class="card-rating">
                                    <span class="badge text-white">
                                    <?php for ($i = 1; $i <= $cars->starsCount; $i++) { ?>
                                    <div class="la la-star"></div>
                                    <?php } ?>
                                    </span>
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                      <p>
                                        <span class="price__num"><?=$currency?> <?=$cars->price?></span>
                                        <span class="price__text"><?=T::price?> </span>
                                      </p>
                                    <a href="<?=root?><?=$session_lang?>/<?=strtolower($currency)?>/hotel/<?=strtolower($name)?>/654987/24-03-2021/27-03-2021/2/0" class="btn-text"><?=T::details?> <i class="la la-angle-right"></i></a>
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