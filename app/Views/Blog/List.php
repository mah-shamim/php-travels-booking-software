<!-- ================================
    START BREADCRUMB AREA
================================= -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<section class="breadcrumb-area bread-bg-7">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading text-center">
                            <h2 class="sec__title text-white"><?=app()->app->business_name?> <?=T::blog?></h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
    <div class="bread-svg-box position-absolute">
        <!-- <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><polygon points="100 0 50 10 0 0 0 10 100 10"></polygon></svg> -->
    </div><!-- end bread-svg -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->
<?php if ( empty($meta['data']->data) ) { ?>
<div class="container text-center">
 <img src="<?=root?>assets/img/no_results.gif" alt="no results" />
</div>
<?php  } else { ?>

<!-- ================================
    START CARD AREA
================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row mt-5">
                    <?php $i = 0;
                    foreach ($meta['data']->data as $blog) {
                    $link_ = $blog->post_slug.'/'.$blog->id;
                    $link = preg_replace('/[&\@\.\;\" "]+/', '', $link_);
                    ?>
                        <div class="col-lg-6 responsive-column more">
                        <div class="card-item blog-card">
                            <div class="card-img">
                                <img src="<?=root?>uploads/blog/<?=$blog->post_img?>" alt="blog-img">
                            </div>
                            <!-- <div class="card-footer d-flex align-items-center justify-content-between"> -->
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
                                <!-- <div class="post-share">
                                    <ul>
                                        <li>
                                            <a href="<?=root?>blog/<?=strtolower($link)?>"><i class="la la-share icon-element"></i></a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                        </div><!-- end card-item -->
                        </div><!-- end card-item -->
                 <?php if (++$i == 50) break; }?>
                </div><!-- end row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-box mt-3 text-center">
                            <!-- <button id="loadMore" type="button" class="theme-btn btn btn-outline-primary px-4 py-2"> -->
                            <button id="loadMore" type="button" class="theme-btn mb-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
                                </svg>
                                <i class="la la-refresh mr-1"></i> <?=T::viewmore?>
                            </button>
                        </div><!-- end btn-box -->
                    </div><!-- end col-lg-12 -->
                </div><!-- end row -->
            </div><!-- end col-lg-8 -->
            <?php include "App/Views/Blog/Side.php"; ?>
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end card-area -->
<!-- ================================
    END CARD AREA
================================= -->

<?php } ?>

<script>
    $(".more").slice(0, $(".more").length ).hide();
    $(".more").slice(0, 4).show();


    $("#loadMore").on('click', function (e) {
        if($(".more:hidden").length > 0) {
            $(".more:hidden").slice(0, 4).slideDown();
            if ($(".more:hidden").length == 0) { $("#load").fadeOut('slow'); }
        }
    });


    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) { $('.totop a').fadeIn();
        } else { $('.totop a').fadeOut(); }
    });
</script>