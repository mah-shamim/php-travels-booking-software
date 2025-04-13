<div class="main-wrapper scrollspy-action">
  <section>
    <div class="container">
      <div class="row gap-40">
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="post-horizon-wrapper-02">
              <?php if(!empty($allposts['all'])){
                foreach($allposts['all'] as $post):
                $bloglib->set_id($post->post_id);
                $bloglib->post_short_details();
                ?>
              <article class="post-horizon-item">
                <div class="image">
                  <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="<?php echo $bloglib->title;?>" />
                </div>
                <div class="content">
                  <h4 class="float-none"><a href="<?php echo base_url().'blog/'.$post->post_slug;?>"><?php echo $bloglib->title;?></a></h4>
                  <div class="meta text-muted">
                    <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="text-dark">
                    <?php echo trans('0480');?>
                    </a> <span><?php echo $bloglib->date; ?></span>
                  </div>
                  <div class="blog-entry">
                    <p>
                      <?php echo character_limiter(strip_tags($bloglib->desc), 110);?>
                    </p>
                    <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="btn-read-more">
                    <?php echo trans('0286');?> <i class="dripicons-arrow-thin-right"></i></a>
                  </div>
                </div>
              </article>
              <?php endforeach; }else{ echo '<h1 class="text-center">' . trans("066") . '</h1>'; } ?>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-3">
          <?php include('sidebar.php'); ?>
        </div>
      </div>
    </div>
  </section>
</div>