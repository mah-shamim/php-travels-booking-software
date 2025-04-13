<section class="blog-area padding-top-30px padding-bottom-90px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title line-height-55"><?=T::latestonblogs?></h2>
                </div><!-- end section-heading -->
            </div><!-- end col-lg-12 -->
        </div><!-- end row -->
        <div class="row padding-top-50px">

          <?php $i = 0; foreach ($app->featured_blog as $blog){ {
          $link = str_replace(' ', '-', $blog->title);
          ?>
             <div class="col-lg-4 responsive-column">
                <div class="card-item blog-card">
                    <div class="card-img">
                        <img src="<?=$blog->thumbnail?>" alt="blog-img">
                        <!--<div class="post-format icon-element">
                            <i class="la la-photo"></i>
                        </div>-->
                        <!--<div class="card-body">
                           <p class="card-meta">
                                <span class="post__date"><?=$blog->thumbnail?></span>
                            </p>
                        </div>-->
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="author-content d-flex align-items-center">
                            <div class="author-bio">
                                <a href="<?=root.blog?>/<?=strtolower($link)?>/<?=$blog->id?>" class="author__title"><?=$blog->title?></a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-4 -->
            <?php if (++$i == 3) break; } } ?>

        </div><!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-box text-center pt-4">
                    <a href="<?=root.blog?>" class="theme-btn"><?=T::viewmore?></a>
                </div>
            </div>
        </div>
    </div><!-- end container -->
</section>