<section class="blog-area padding-top-30px padding-bottom-90px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h4 class="sec__title line-height-55">
                        <strong><?=T::latestonblogs?></strong>    
                    </h4>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row" style="padding-top: 50px;">

          <?php $i = 0; foreach (base()->featured_blog as $blog){ {
          $link = str_replace(' ', '-', $blog->post_slug);
          ?>
             <div class="col-lg-4 responsive-column">
                <div class="card-item blog-card">
                    <div class="card-img">
                        <img src="<?=root?>uploads/blog/<?=$blog->post_img?>" alt="blog-img">
                    </div>
                    <div class="card-footer">
                        <div class="author-bio">
                            <a href="<?=root?>blog/<?=strtolower($link)?>" class="author__title d-flex justify-content-between align-items-center">
                                <span>
                                    <?=$blog->post_title?>
                                </span>
                                <span class="share--post d-flex justify-content-center align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 16l6-6-6-6"/>
                                        <path d="M4 21v-7a4 4 0 0 1 4-4h11"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-4 -->
            <?php if (++$i == 3) break; } } ?>

        </div><!-- end row -->
        <!-- <div class="row">
            <div class="col-lg-12">
                <div class="btn-box text-center pt-4">
                    <a href="<?=root?>blogs" class="theme-btn"><?=T::viewmore?></a>
                </div>
            </div>
        </div> -->
    </div><!-- end container -->
</section>