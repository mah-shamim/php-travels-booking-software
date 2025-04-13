<div class="col-lg-4 mt-5" style="height: fit-content;">
<div class="sidebar mb-0">
    <div class="sidebar-widget">
    <h3 class="title stroke-shape"><?=T::newblogs?></h3>

    <?php if ( empty($meta['data']->data) ) { echo "No Blogs Found"; } else { $i = 0;
    foreach ($meta['data']->data as $blog) { ?>
    <div class="card-item card-item-list recent-post-card d-flex align-items-center">
            <div class="card-img">
                <a href="<?=root?>blog/<?=str_replace(' ', '-', $blog->post_slug).'/'.$blog->id?>" class="d-block">
                    <img src="<?=root?>uploads/blog/<?=$blog->post_img?>" alt="blog-img" style="height:60px;width: 90px;">
                </a>
            </div>
            <div class="card-body">
                <h3 class="card-title" style="white-space: unset;">
                    <a href="<?=root?>blog/<?=str_replace(' ', '-', $blog->post_slug).'/'.$blog->id?>"><?=$blog->post_title?></a>
                </h3>
                <!--<p class="card-meta">
                    <span class="post__date"> 1 March, 2020</span>
                    <span class="post-dot"></span>
                    <span class="post__time">3 Mins read</span>
                </p>-->
            </div>
        </div><!-- end card-item -->
        <?php if (++$i == 7) break; } }?>
    </div><!-- end sidebar-widget -->
</div><!-- end sidebar -->
</div><!-- end col-lg-4 -->

<style>
    .recent-post-card.card-item .card-img {
        width: unset !important;
        padding-left: 10px;
    }

    div.col-lg-4:has(.sidebar) {
        border: 1px solid rgba(128,137,150,0.1);
        padding: 15px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        background-color: #fff;
        -webkit-box-shadow: 0 0 40px rgba(82,85,90,0.1);
        -moz-box-shadow: 0 0 40px rgba(82,85,90,0.1);
        box-shadow: 0 0 40px rgba(82,85,90,0.1)
    }
</style>