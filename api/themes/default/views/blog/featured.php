<?php if(isModuleActive( 'blog')){ if($showOnHomePage !="No" ){ ?>

<!-- ================================
       START BLOG AREA
================================= -->
<section class="blog-area padding-top-30px padding-bottom-90px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55"><?php echo trans('0402');?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-50px">

            <?php foreach($posts as $p){ ?>
            <div class="col-lg-4 responsive-column">
                <div class="card-item blog-card">
                    <div class="card-img">
                        <img src="<?php echo $p->thumbnail;?>" alt="blog-img">
                        <!--<div class="post-format icon-element">
                            <i class="la la-photo"></i>
                        </div>-->
                        <div class="card-body">
                            <!--<div class="post-categories">
                                <a href="#" class="badge">Travel</a>
                                <a href="#" class="badge">lifestyle</a>
                            </div>-->
                            <!--<h3 class="card-title line-height-26"><a href="<?php echo $p->slug;?>"><?php echo character_limiter($p->title,25);?></a></h3>-->
                            <p class="card-meta">
                                <span class="post__date"> <?php echo $p->shortDesc;?></span>
                                <!--<span class="post-dot"></span> -->
                                <!--<span class="post__time">5 Mins read</span>-->
                            </p>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="author-content d-flex align-items-center">
                            <div class="author-img">
                                <img src="<?php echo $p->thumbnail;?>" alt="testimonial image">
                            </div>
                            <div class="author-bio">
                                <a href="<?php echo $p->slug;?>" class="author__title"><?php echo character_limiter($p->title,25);?></a>
                            </div>
                        </div>
                        <!--<div class="post-share">
                            <ul>
                                <li>
                                    <i class="la la-share icon-element"></i>
                                    <ul class="post-share-dropdown d-flex align-items-center">
                                        <li><a href="#"><i class="lab la-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="lab la-twitter"></i></a></li>
                                        <li><a href="#"><i class="lab la-instagram"></i></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>--><!--  -->
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-4 -->
            <?php } ?>

        </div><!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-box text-center pt-4">
                    <a href="<?php echo base_url(); ?>blog" class="theme-btn"><?=trans('0286');?> </a>
                </div>
            </div>
        </div>
    </div><!-- end container -->
</section><!-- end blog-area -->
<!-- ================================
       START BLOG AREA
================================= -->

<?php } ?>
<?php } ?>