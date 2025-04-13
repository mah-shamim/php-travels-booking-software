<div class="col-lg-4">
<div class="sidebar mb-0">
    <!--<div class="sidebar-widget">
        <h3 class="title stroke-shape">Search Post</h3>
        <div class="contact-form-action">
            <form action="#">
                <div class="input-box">
                    <div class="form-group mb-0">
                        <input class="form-control pl-3" type="text" placeholder="Type your keywords...">
                        <button class="search-btn" type="submit"><i class="la la-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>-->
    <div class="sidebar-widget">
    <h3 class="title stroke-shape"><?=T::newblogs?></h3>

    <?php if ( empty($blogs_data) ) { echo "No Blogs Found"; } else { $i = 0;
    foreach ($blogs_data->response->posts as $blog) { ?>
    <div class="card-item card-item-list recent-post-card">
            <div class="card-img">
                <a href="<?=root?>blog/<?=str_replace(' ', '-', $blog->title).'/'.$blog->id?>" class="d-block">
                    <img src="<?=$blog->thumbnail?>" alt="blog-img" style="height:60px;width: 90px;">
                </a>
            </div>
            <div class="card-body">
                <h3 class="card-title" style="white-space: unset;"><a href="<?=root?>blog/<?=str_replace(' ', '-', $blog->title).'/'.$blog->id?>"><?=$blog->title?></a></h3>
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