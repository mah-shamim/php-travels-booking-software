<div class="main-wrapper scrollspy-action">
  <section>
    <div class="container">
      <div class="row gap-40">
        <div class="col-12 col-lg-9">
          <div class="content-wrapper">
            <div class="post-horizon-wrapper">
              <article class="post-horizon-item blog-single clearfix">
                <img src="<?php echo $thumbnail;?>" width="100%" class="img-responsive"/>
                <div class="blog-media">
                  <script src="//platform-api.sharethis.com/js/sharethis.js#property=5a59535372b70f00137efe19&product=inline-share-buttons"></script>
                  <div class="sharethis-inline-share-buttons st-justified st-has-labels  st-inline-share-buttons st-animated" id="st-1">
                    <div class="st-btn st-first" data-network="facebook" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/facebook.svg">
                      <span class="st-label">Share</span>
                    </div>
                    <div class="st-btn st-remove-label" data-network="twitter" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/twitter.svg">
                      <span class="st-label">Tweet</span>
                    </div>
                    <div class="st-btn st-remove-label" data-network="pinterest" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/pinterest.svg">
                      <span class="st-label">Pin</span>
                    </div>
                    <div class="st-btn st-remove-label" data-network="email" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/email.svg">
                      <span class="st-label">Email</span>
                    </div>
                    <div class="st-btn st-remove-label" data-network="whatsapp" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/whatsapp.svg">
                      <span class="st-label">Share</span>
                    </div>
                    <div class="st-btn st-remove-label" data-network="linkedin" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/linkedin.svg">
                      <span class="st-label">Share</span>
                    </div>
                    <div class="st-btn st-last st-remove-label" data-network="sharethis" style="display: inline-block;">
                      <img src="https://platform-cdn.sharethis.com/img/sharethis.svg">
                      <span class="st-label">Share</span>
                    </div>
                  </div>
                </div>
                <div class="blog-content mt-30">
                  <h3 class="float-none"><?php echo $title;?></h3>
                  <ul class="blog-meta">
                    <li><?php echo $date;?></li>
                  </ul>
                  <div class="blog-entry"> 
                    <?php echo $desc; ?>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-3">
          <?php include('sidebar.php'); ?>
        </div>
      </div>
      <?php if(!empty($related_posts)){ ?>
      <h3 class="ttu bold px-20"><?php echo trans('0289');?></h3>
      <div class="clear"></div>
      <div class="row equal-height cols-2 cols-md-2 cols-lg-4 gap-10 gap-md-20 gap-xl-30">
        <?php
          foreach($related_posts as $post):
          $bloglib->set_id($post->post_id);
          $bloglib->post_short_details(); ?>
        <div class="col">
          <figure class="featured-image-grid-item with-highlight">
            <div class="image">
              <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="image">
            </div>
            <figcaption class="content">
              <br>
              <div class="rating-item rating-sm">
                <h5 class="mb-0"><?php echo character_limiter(strip_tags($bloglib->title), 60);?></h5>
                <div class="clear"></div>
              </div>
            </figcaption>
            <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="position-absolute-href"></a>
          </figure>
        </div>
        <?php endforeach; ?>
        <?php  } ?>
      </div>
    </div>
  </section>
</div>