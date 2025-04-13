<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-7">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading text-center">
                            <h2 class="sec__title text-white"><?=$app->app->appname?> <?=T::blog?></h2>
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

<?php if ( empty($blogs_data) ) { ?>
<div class="container text-center">
 <img src="<?=root?><?=theme_url?>assets/img/no_results.gif" alt="no results" />
</div>
<?php  } else { ?>

<!-- ================================
    START CARD AREA
================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <?php $i = 0;
                    foreach ($blogs_data->response->posts as $blog) {
                    $link_ = str_replace(' ', '-', $blog->title).'/'.$blog->id;
                    $link = preg_replace('/[&\@\.\;\" "]+/', '', $link_);
                    ?>
                        <div class="col-lg-6 responsive-column more">
                        <div class="card-item blog-card">
                            <div class="card-img">
                                <img src="<?=$blog->thumbnail?>" alt="blog-img" style="height:200px">
                                <!--
                                <div class="post-format icon-element">
                                    <i class="la la-photo"></i>
                                </div>
                                <div class="card-body">
                                    <div class="post-categories">
                                        <a href="#" class="badge">Travel</a>
                                        <a href="#" class="badge">lifestyle</a>
                                    </div>
                                    <h3 class="card-title line-height-26"><a href=""></a></h3>
                                    <p class="card-meta">
                                        <span class="post__date"> 1 January, 2020</span>
                                        <span class="post-dot"></span>
                                        <span class="post__time">5 Mins read</span>
                                    </p>
                                </div>-->
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="author-content d-flex align-items-center">
                                    <!--<div class="author-img">
                                        <img src="<?=root?><?=theme_url?>images/small-team1.jpg" alt="testimonial image">
                                    </div>-->
                                    <div class="author-bio">
                                        <a href="<?=root?>blog/<?=strtolower($link)?>" class="author__title"><?=$blog->title?></a>
                                    </div>
                                </div>
                                <div class="post-share">
                                    <ul>
                                        <li>
                                            <a href="<?=root?>blog/<?=strtolower($link)?>"><i class="la la-share icon-element"></i></a>
                                            <!--<ul class="post-share-dropdown d-flex align-items-center">
                                                <li><a href="#"><i class="lab la-facebook-f"></i></a></li>
                                                <li><a href="#"><i class="lab la-twitter"></i></a></li>
                                                <li><a href="#"><i class="lab la-instagram"></i></a></li>
                                            </ul>-->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- end card-item -->
                        </div><!-- end card-item -->
                 <?php if (++$i == 50) break; }?>
                </div><!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-box mt-3 text-center">
                            <button id="loadMore" type="button" class="theme-btn"><i class="la la-refresh mr-1"></i> <?=T::viewmore?></button>
                        </div><!-- end btn-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
            </div><!-- end col-lg-8 -->
            <?php  include views."modules/blog/side.php"; ?> 
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end card-area -->
<!-- ================================
    END CARD AREA
================================= -->

<?php } ?>

<script>
$(function () {
    $(".more").slice(0, 6).show();
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".more:hidden").slice(0, 6).slideDown();
        if ($(".more:hidden").length == 0) { $("#load").fadeOut('slow'); }
        $('html,body').animate({ scrollTop: $(this).offset().top }, 500);
    });
});

$(window).scroll(function () {
    if ($(this).scrollTop() > 50) { $('.totop a').fadeIn();
    } else { $('.totop a').fadeOut(); }
});
</script>

<style>
.more { display:none; }
.totop { position: fixed; bottom: 10px; right: 20px; }
.totop a { display: none; }
a,a:visited { color: #33739E; text-decoration: none; display: block; margin: 10px 0; }
a:hover { text-decoration: none; }
</style>