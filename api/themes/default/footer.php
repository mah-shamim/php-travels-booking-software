<!-- ================================
       START FOOTER AREA
================================= -->
<section class="footer-area section-bg padding-top-100px padding-bottom-30px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <div class="footer-logo padding-bottom-10px">
                    <a href="<?php echo base_url(); ?>" class="foot__logo"><img style="max-width: 150px;" src="<?php echo PT_GLOBAL_IMAGES_FOLDER.$app_settings[0]->header_logo_img;?>" alt="logo"></a>
                    </div><!-- end logo -->
                    <!--<p class="footer__desc">Morbi convallis bibendum urna ut viverra. Maecenas consequat</p>-->
                    <ul class="list-items pt-3">
                    <!--<li>3015 Grand Ave, Coconut Grove,<br> Cerrick Way, FL 12345</li>-->
                        <?php if( ! empty($phone) ) { ?>
                        <li><strong> <?php echo $phone; ?> </strong></li>
                        <?php } ?>
                        <?php if( ! empty($contactemail) ) { ?>
                        <li><strong><a href="mailto:<?php echo $contactemail; ?>"><?php echo $contactemail; ?></a></strong></li>
                        <?php } ?>

                        <li><a href="<?php echo base_url(); ?>privacy-policy"><?=trans('0148')?></a></li>
                        <li><a href="<?php echo base_url(); ?>terms-of-use"><?=trans('0147')?></a></li>
                    </ul>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->

            <div class="col-lg-6 responsive-column">
            <ul class="foot_menu w-100">
            <?=menu(2);?>
            </ul>
            </div>

            <!--<div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <h4 class="title curve-shape pb-3 margin-bottom-20px" data-text="curvs">Company</h4>
                    <ul class="list-items list--items">
                        <li><a href="about.html">About us</a></li>
                        <li><a href="services.html">Services</a></li>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="blog-grid.html">News</a></li>
                        <li><a href="contact.html">Support</a></li>
                        <li><a href="#">Advertising</a></li>
                    </ul>
                </div>
            </div>-->

            <div class="col-lg-3 responsive-column">
                <div class="footer-item">
                    <h4 class="title curve-shape pb-3 margin-bottom-20px" data-text="curvs"><?=trans('024')?> <?=trans('059')?></h4>
                    <p class="footer__desc pb-3"><?=trans(0111);?></p>
                    <div class="contact-form-action">
                     <?php if(isModuleActive('newsletter')){ ?>
                        <h6 class="footer-title"><?php echo trans('0111');?></h6>
                        <div class="clear"></div>
                            <div id="message-newsletter_2"></div>
                            <form role="search" onsubmit="return false;"></form>
                            <div class="input-box">
                                <label class="label-text"></label>
                                <div class="form-group mb-0">
                                    <span class="la la-envelope form-icon"></span>
                                    <input type="email" class="form-control sub_email" id="exampleInputEmail1" placeholder="<?php echo trans('0403');?>">
                                    <button class="theme-btn theme-btn-small submit-btn sub_newsletter" type="submit"><?php echo trans('024');?></button>
                                    <span class="font-size-14 pt-1"><!--<i class="la la-lock mr-1"></i>-->
                                    <a class="newstext" href="javascript:void(0);">
                                        <div class="wow fadeIn subscriberesponse"></div>
                                    </a>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div><!-- end footer-item -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="term-box footer-item">
                    <ul class="list-items list--items d-flex align-items-center">
                     <?php echo $app_settings[0]->copyright;?>
                    </ul>
                </div>
            </div><!-- end col-lg-8 -->
             <div class="col-lg-4">
                <div class="footer-social-box text-right">
                    <ul class="social-profile">
                        <?php foreach($footersocials as $fs){ ?>
                        <!--<a href="<?php echo $fs->social_link;?>" data-toggle="tooltip" data-placement="top" title="<?php echo $fs->social_name;?>" target="_blank"><img src="<?php echo PT_SOCIAL_IMAGES; ?><?php echo $fs->social_icon;?>" class="social-icons-footer sc-97mfds-11 hccXzw" /></a>-->
                        <li><a href="<?php echo $fs->social_link;?>" target="_blank"><i class="lab la-<?=str_replace(" ","-",strtolower($fs->social_name) ) ?>"></i></a></li>
                        <?php } ?>
                        <!--<li><a href="#"><i class="lab la-twitter"></i></a></li>
                        <li><a href="#"><i class="lab la-instagram"></i></a></li>
                        <li><a href="#"><i class="lab la-linkedin-in"></i></a></li>-->
                    </ul>
                </div>
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
    <div class="section-block mt-4"></div>
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-12">
                <div class="copy-right-content d-flex align-items-center justify-content-end padding-top-30px">
                    <h3 class="font-size-15" style="width:100%">
                    <!-- ********************   Removing powered by linkback will result to cancellation of your support service.    ********************  -->
                    <div class="d-none d-md-block" style="padding:0px;position:relative">
                    <div class="container">
                    <div class="text-center">Powered by &nbsp;<a href="http://www.phptravels.com" target="_blank"> <img src="<?php echo base_url(); ?>uploads/global/phptravels.png" style="height:22px;display: inline-block; -webkit-transform: translateY(0px);transform: translateY(0px);" height="22" alt="PHPTRAVELS" /> <strong>&nbsp;PHPTRAVELS</strong></a></div>
                    </div>
                    </div>
                    <!-- ********************   Removing powered by linkback will result to cancellation of your support service.    ********************  -->
                    </h3>
                    <img src="images/payment-img.png" alt="">
                </div><!-- end copy-right-content -->
            </div><!-- end col-lg-5 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end footer-area -->
<!-- ================================
       START FOOTER AREA
================================= -->

<!-- start back-to-top -->
<div id="back-to-top">
    <i class="la la-angle-up" title="Go top"></i>
</div>
<!-- end back-to-top -->

<!-- tripadvisors block -->
<?php if($tripmodule){ ?>
<div class="footerbg text-center d-none d-md-block">
    <a class="btn-block" target="_blank" href="//www.tripadvisor.com/pages/terms.html"><img width="200" lass="block-center" src="<?php echo PT_GLOBAL_IMAGES_FOLDER . 'tripadvisor.png';?>" alt="TripAdvisor" /></a>
    <p>Ratings and Reviews Powered by TripAdvisor</p>
</div>
<?php } ?>
<!-- tripadvisors block -->

<!-- start Footer Wrapper -->
<footer id="footer" class="footer-wrapper scrollspy-stopper <?php echo @$hidden; ?>">
</footer>

    <!--fade effect for pages-->
    <!--
    <script>
    $(function(){
        $('body').fadeIn();
        $('a').click(function(){
         if ($(this)[0].parentNode.parentNode.classList[0] != "horizon-sticky-nav" && $(this)[0].parentNode.parentNode.classList[0] != "nav")
         {
         $('body').fadeOut( 200, function(){
         setInterval(function(){
         $('body').fadeIn() }, 500);
          })
         }
        });
    });
    </script>
    -->

    <!-- jQuery -->

    <script>
    $( document ).ready(function() {
    size_li = $("#LIST li").size();
    x=30;
    $('#LIST li:lt('+x+')').show();
    $('#loadMore').click(function () {
    x= (x+30 <= size_li) ? x+30 : size_li;
    $('#LIST li:lt('+x+')').show();
    $('#showLess').show();
    if(x == size_li){
    $('#loadMore').hide();
    }
    });
    });
    </script>

    <?php if (!$is_home): ?>
    <?php $whitelist = array( '127.0.0.1','::1' ); if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) { ?>
    <!-- Google Maps -->
    <?php if (pt_main_module_available('ean') || $loadMap) { ?>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $app_settings[0]->mapApi; ?>&libraries=places"></script>
    <?php } } else { ?>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $app_settings[0]->mapApi; ?>&libraries=places"></script>
    <?php } ?>
    <script type="text/javascript" src="<?= $theme_url; ?>assets/js/plugins/infobox.js"></script>
    <script type="text/javascript" src="<?= $theme_url; ?>assets/js/custom-detail-map.js"></script>
    <?php endif; ?>
    <script src="<?= $theme_url; ?>assets/js/select2.js"></script>
    <?php include "script.php"; ?>
    <div id="cookyGotItBtnBox" style="display: none" data-wow-duration="0.5s" data-wow-delay="5s" role="dialog" class="wow fadeIn cc-window cc-banner cc-type-info cc-theme-block cc-color-override--1961008818 ">
    <span id="cookieconsent:desc" class="cc-message">This website uses cookies to ensure you get the best experience on our website. <a aria-label="learn more about cookies" role="button" tabindex="0" class="cc-link" href="<?php echo base_url(); ?>cookies-policy" rel="noopener noreferrer nofollow" target="_blank">Learn more</a></span>
    <div class="cc-compliance">
    <button aria-label="dismiss cookie message" role="button" tabindex="0" class="cc-btn cc-dismiss" onclick="cookyGotItBtn()">Got it!</button></div>
    </div>
</body>
<!--<script src="<?= $theme_url; ?>assets/js/jquery-3.4.1.min.js"></script>-->
<script src="<?= $theme_url; ?>assets/js/jquery-ui.js"></script>
<script src="<?= $theme_url; ?>assets/js/popper.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/bootstrap.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/bootstrap-select.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/moment.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/daterangepicker.js"></script>
<script src="<?= $theme_url; ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/jquery.fancybox.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/jquery.countTo.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/animated-headline.js"></script>
<script src="<?= $theme_url; ?>assets/js/jquery.filer.min.js"></script>
<script src="<?= $theme_url; ?>assets/js/jquery.ripples-min.js"></script>
<script src="<?= $theme_url; ?>assets/js/quantity-input.js"></script>
<script src="<?= $theme_url; ?>assets/js/main.js"></script>

<div class="modal-popup">
<div class="modal fade" id="flights_load" tabindex="1" role="dialog"  aria-hidden="ture" style="margin:0px!important;padding-left:16px!important">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:100%;height:100%;margin:0px!important">
<div class="modal-content" style="border-radius:15px">
<div class="text-center d-flex justify-content-center">
<img src="<?=base_url();?>uploads/global/logo.png" class="img-fluid mx-auto d-block" style="max-width: 300px;;position:absolute;margin:50px auto;" alt="" />
</div>
<div id="loading_flight" class="loading-results-globe-wrapper" style="background:#fff;height:80vh;overflow:hidden;border-radius:15px">
<div class="loading-results-globe ski-svg-responsive ski-svg-globe-geometry-loadingpage" style="margin-top:-200px">
<span class="origin"><small><?=trans('0273');?></small> <strong><span id="from_city"></span></strong> <small id="datestart"></small></span>
<span class="destination-prefix"><?=trans('0642');?></span> <span class="destination" id="to_city"></span>
<div class="loading-results-track">
<div class="loading-results-track-progress is-active"></div>
<div class="loading-results-progress is-active"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

</html>