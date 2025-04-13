<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-5">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading text-center">
                            <h2 class="sec__title text-white"><?=$app->app->appname?> <?=T::offers?></h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
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
          <?php
          $i = 0;
          foreach ($offers_data->response as $offers) {
          $links = str_replace(' ', '-', $offers->title).'/'.$offers->id;
          $link = strtolower($links);
          ?>
            <div class="col-lg-4 responsive-column">
                <div class="card-item blog-card">
                    <div class="card-img">
                        <img src="<?=$offers->thumbnail?>" alt="blog-img" style="height:200px">
                        <!--<div class="post-format icon-element">
                            <i class="la la-photo"></i>
                        </div>-->
                        <div class="card-body">
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <div class="author-content d-flex align-items-center">
                            <div class="author-bio">
                                <a href="<?=root.offers.'/'.$link?>" class="author__title"><?=$offers->title?></a>
                             </div>
                            </div>
                        <div class="post-share">
                            <ul>
                                <li>
                                    <a href="<?=root.offers.'/'.$link?>"><i class="la la-share icon-element"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-4 -->
        <?php if (++$i == 50) break; } ?>
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end card-area -->
<!-- ================================
    END CARD AREA
================================= -->

<div class="section-block"></div>