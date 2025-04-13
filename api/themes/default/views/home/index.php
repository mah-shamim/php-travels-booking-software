<?php include $themeurl. 'views/home/slider.php';  ?>

<?php include $themeurl. 'views/modules/flights/standard/featured.php';?>
<?php include $themeurl. 'views/modules/hotels/standard/featured.php';?>
<?php include $themeurl. 'views/modules/tours/standard/featured.php';?>
<?php include $themeurl. 'views/modules/rentals/featured.php';?>
<?php include $themeurl. 'views/modules/boats/featured.php';?>
<?php include $themeurl. 'views/modules/cars/standard/featured.php';  ?>
<?php include $themeurl. 'views/modules/extra/offers/featured.php';?>
<?php include $themeurl. 'views/blog/featured.php' ;?>


<?php if($mSettings->mobileSectionStatus == "Yes"){ ?>
<!-- ================================
    START MOBILE AREA
================================= -->
<section class="mobile-app padding-top-100px padding-bottom-50px section-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="mobile-app-content">
                    <div class="section-heading">
                        <h2 class="sec__titles line-height-55"><?php echo trans('0386'); ?></h2>
                    </div><!-- end section-heading -->
                    <ul class="info-list padding-top-30px">
                        <li class="d-flex align-items-center mb-3"><span class="la la-check icon-element flex-shrink-0 ml-0"></span> <?php echo trans('0387'); ?></li>
                        <!--<li class="d-flex align-items-center mb-3"><span class="la la-check icon-element flex-shrink-0 ml-0"></span> Free cancellation on select hotels</li>
                        <li class="d-flex align-items-center mb-3"><span class="la la-check icon-element flex-shrink-0 ml-0"></span> Get real-time trip updates</li>-->
                    </ul>
                    <br><br>
                    <div class="btn-box padding-top-30px">
                    <?php if(!empty($mSettings->iosUrl)){ ?>
                    <a target="_blank" href="<?php echo $mSettings->iosUrl; ?>" class="d-inline-block mr-3">
                    <img src="<?php echo $theme_url; ?>assets/images/app-store.png" alt="istore">
                    </a>
                    <?php } ?>
                    <?php if(!empty($mSettings->androidUrl)){ ?>
                    <a target="_blank" href="<?php echo $mSettings->androidUrl; ?>" class="d-inline-block">
                    <img src="<?php echo $theme_url; ?>assets/images/google-play.png" alt="">
                    </a>
                    <?php } ?>
                    </div><!-- end btn-box -->
                </div>
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6">
                <div class="mobile-img">
                    <img src="<?php echo $theme_url; ?>assets/images/mobile-app.png" alt="mobile-img">
                </div>
            </div><!-- end col-lg-5 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end mobile-app -->
<!-- ================================
    END MOBILE AREA
================================= -->

<!-- ================================
       START CLIENTLOGO AREA
================================= -->
<section class="clientlogo-area padding-top-80px padding-bottom-80px text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="client-logo">
                    <div class="client-logo-item"><img src="<?php echo $theme_url; ?>assets/img/footer/1.png" alt="brand image"></div>
                    <div class="client-logo-item"><img src="<?php echo $theme_url; ?>assets/img/footer/2.png" alt="brand image"></div>
                    <div class="client-logo-item"><img src="<?php echo $theme_url; ?>assets/img/footer/3.png" alt="brand image"></div>
                    <div class="client-logo-item"><img src="<?php echo $theme_url; ?>assets/img/footer/4.png" alt="brand image"></div>
                    <div class="client-logo-item"><img src="<?php echo $theme_url; ?>assets/img/footer/5.png" alt="brand image"></div>
                    <div class="client-logo-item"><img src="<?php echo $theme_url; ?>assets/img/footer/6.png" alt="brand image"></div>
                </div><!-- end client-logo -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end clientlogo-area -->
<!-- ================================
       START CLIENTLOGO AREA
================================= -->

<?php } ?>