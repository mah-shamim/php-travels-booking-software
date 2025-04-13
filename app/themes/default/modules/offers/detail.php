<!-- ================================
    START CARD AREA 
================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-item blog-card blog-card-layout-2 blog-single-card mb-5">
                    <div class="card-img before-none">
                        <img src="<?=$offers_details->thumbnail?>" alt="blog-img">
                    </div>
                    <div class="card-body">
                        <h3 class="card-title font-size-28"><?=$offers_details->title?></h3>
                        <div class="section-block"></div>
                        <p class="card-text py-3">
                            <?php // echo "<pre>"; print_r($offers_details); ?>
                        </p>

                        <p><?=$offers_details->desc?></p>
                        <hr>
                        <p><strong><?=T::price?></strong> <?=$offers_details->currCode?> <?=$offers_details->price?></p>
                        <p><strong><?=T::phone?></strong> <?=$offers_details->phone?></p>
                        <p><strong><?=T::email?></strong> <?=$offers_details->email?></p>
                        <p><strong><?=T::expirydate?></strong> <?=$offers_details->fullExpiryDate?></p>
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-8 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end card-area -->
<!-- ================================
    END CARD AREA
================================= -->
<div class="section-block"></div>