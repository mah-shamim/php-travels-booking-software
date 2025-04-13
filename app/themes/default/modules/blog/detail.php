<!-- ================================
    START CARD AREA
================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-item blog-card blog-card-layout-2 blog-single-card mb-5">
                    <div class="card-img before-none">
                        <?php if (isset($blogs_details->response->thumbnail)) { ?>
                        <img src="<?=$blogs_details->response->thumbnail?>" alt="blog-img">
                        <?php } else {} ?>
                    </div>
                    <div class="card-body">
                        <!--<div class="post-categories">
                            <a href="#" class="badge">Travel</a>
                            <a href="#" class="badge">lifestyle</a>
                        </div>-->
                        <h3 class="card-title font-size-28"><?=$blogs_details->response->title?></h3>
                        <!--<p class="card-meta pb-3">
                            <span class="post__author">By <a href="#" class="text-gray">John Doe</a></span>
                            <span class="post-dot"></span>
                            <span class="post__date"> 1 January, 2020</span>
                            <span class="post-dot"></span>
                            <span class="post__time"><a href="#" class="text-gray">4 Comments</a></span>
                            <span class="post-dot"></span>
                            <span class="post__time"><a href="#" class="text-gray">202 Likes</a></span>
                        </p>-->
                        <div class="section-block"></div>
                        <p class="card-text py-3">
                            <?= $blogs_details->response->description ?></p>
                    </div>
                </div><!-- end card-item -->
            </div><!-- end col-lg-8 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end card-area -->
<!-- ================================
    END CARD AREA
================================= -->
<div class="section-block"></div>