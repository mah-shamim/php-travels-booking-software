<!-- ================================
    START BREADCRUMB AREA
================================= -->
<style>.blog-bg-7{background-image: url("<?php echo $thumbnail;?>");}</style>
<section class="breadcrumb-area blog-bg-7">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title_list"><?php echo $title;?></h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list d-none">
                        <ul class="list-items d-flex justify-content-end">
                            <li><a href="index.html">Home</a></li>
                            <li>Blog</li>
                            <li>Blog Details</li>
                        </ul>
                    </div><!-- end breadcrumb-list -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
    <div class="bread-svg-box">
        <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><polygon points="100 0 50 10 0 0 0 10 100 10"></polygon></svg>
    </div><!-- end bread-svg -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->
<!-- ================================
    START CARD AREA
================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card-item blog-card blog-card-layout-2 blog-single-card mb-5">
                    <div class="card-img before-none">
                        <img src="<?php echo $thumbnail;?>" alt="blog-img">
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="post-categories">
                            <a href="#" class="badge">Travel</a>
                            <a href="#" class="badge">lifestyle</a>
                        </div>
                        <h3 class="card-title font-size-28"><?php echo $title;?></h3>
                        <p class="card-meta pb-3">
                            <span class="post__author">By <a href="#" class="text-gray">John Doe</a></span>
                            <span class="post-dot"></span>
                            <span class="post__date"> <?php echo $date;?></span>
                            <span class="post-dot"></span>
                            <span class="post__time"><a href="#" class="text-gray">4 Comments</a></span>
                            <span class="post-dot"></span>
                            <span class="post__time"><a href="#" class="text-gray">202 Likes</a></span>
                        </p>
                        <div class="section-block"></div>
                        <p class="card-text py-3"><?php echo $desc; ?></p>
                        
                    </div>
                </div><!-- end card-item -->
                <div class="section-block"></div>
                <?php if(!empty($related_posts)){ ?>

                <div class="related-posts pt-5 pb-4">
                    <h3 class="title"><?php echo trans('0289');?></h3>
                    <div class="row pt-4">
                    <?php
                      foreach($related_posts as $post):
                      $bloglib->set_id($post->post_id);
                      $bloglib->post_short_details(); ?>
                        <div class="col-lg-6 responsive-column">
                            <div class="card-item blog-card">
                                <div class="card-img">
                                    <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="blog-img">
                                    <div class="post-format icon-element">
                                        <i class="la la-photo"></i>
                                    </div>
                                    <div class="card-body">
                                        <div class="post-categories">
                                            <a href="#" class="badge">Travel</a>
                                            <a href="#" class="badge">lifestyle</a>
                                        </div>
                                        <h3 class="card-title line-height-26"><a href="<?php echo base_url().'blog/'.$post->post_slug;?>"><?php echo character_limiter(strip_tags($bloglib->title), 60);?></a></h3>
                                        <p class="card-meta">
                                            <span class="post__date"> 1 January, 2020</span>
                                            <span class="post-dot"></span>
                                            <span class="post__time">5 Mins read</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="author-content d-flex align-items-center">
                                        <div class="author-img">
                                            <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="testimonial image">
                                        </div>
                                        <div class="author-bio">
                                            <a href="#" class="author__title">Leroy Bell</a>
                                        </div>
                                    </div>
                                    <div class="post-share">
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
                                    </div>
                                </div>
                            </div><!-- end card-item -->
                        </div><!-- end col-lg-6 -->
                    <?php endforeach; ?>
                    </div><!-- end row -->
                </div>
                <?php  } ?>
                <div class="section-block"></div>


            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">
            <?php include('sidebar.php'); ?>
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end card-area -->
<!-- ================================
    END CARD AREA
================================= -->