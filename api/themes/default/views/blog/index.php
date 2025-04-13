<!-- ================================
    START CARD AREA
================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                <?php if(!empty($allposts['all'])){
                foreach($allposts['all'] as $post):
                $bloglib->set_id($post->post_id);
                $bloglib->post_short_details();
                ?>
                    <div class="col-lg-6 responsive-column">
                        <div class="card-item blog-card">
                            <div class="card-img">
                                <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="<?php echo $bloglib->title;?>">
                                
                                <div class="card-body">
                                    <h3 class="card-title line-height-26"><a href="<?php echo base_url().'blog/'.$post->post_slug;?>"><?php echo $bloglib->title;?></a></h3>
                                    <p class="card-meta">
                                        <span class="post__date"> <?php echo $bloglib->date; ?></span>
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
                  <?php endforeach; }else{ echo '<h1 class="text-center">' . trans("066") . '</h1>'; } ?>
                </div><!-- end row -->
                <div class="row d-none">
                    <div class="col-lg-12">
                        <div class="btn-box mt-3 text-center">
                            <button type="button" class="theme-btn"><i class="la la-refresh mr-1"></i>Load More</button>
                            <p class="font-size-13 pt-2">Showing 1 - 12 of 44 Posts</p>
                        </div><!-- end btn-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
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