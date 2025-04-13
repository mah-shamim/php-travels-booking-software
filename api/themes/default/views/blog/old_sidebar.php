<aside class="sidebar-wrapper style-02">
  <div class="sidebar-box">
    <div class="box-title">
      <h5><span><?php echo trans('0284');?></span></h5>
      <div class="clear"></div>
    </div>
    <div class="box-content">
      <form class="quick-form-box" action="<?php echo base_url().'blog/search'; ?>" method="GET">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="<?php echo trans('0283');?>" name="s" style="font-size:1rem;">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php if(!empty($categories)){ ?>
  <div class="sidebar-box">
    <div class="box-title">
      <h5><span><?php echo trans('0288');?></span></h5>
      <div class="clear"></div>
    </div>
    <div class="box-content">
      <ul class="category-list">
        <?php  foreach($categories as $cat):
          $count = pt_posts_count($cat->id);
          if($count > 0){
          ?>
        <li><a href="<?php echo base_url().'blog/category?cat='.$cat->slug; ?>"><?php echo $cat->name;?><span>(<?php echo $count;?>)</span></a></li>
        <?php  } endforeach; ?>
      </ul>
    </div>
  </div>
  <?php  } ?>
  <?php if(!empty($popular_posts)){ ?>
  <div class="sidebar-box">
    <div class="box-title">
      <h5><span><?php echo trans('0287');?></span></h5>
      <div class="clear"></div>
    </div>
    <div class="box-content">
      <ul class="post-small-list">
        <?php
          foreach($popular_posts as $post):
          $bloglib->set_id($post->post_id);
          $bloglib->post_short_details(); ?>
        <li class="clearfix">
          <a href="<?php echo base_url().'blog/'.$post->post_slug;?>">
            <div class="image">
              <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="<?php echo $bloglib->title;?>" />
            </div>
            <div class="content">
              <h6><?php echo character_limiter(strip_tags($bloglib->title), 30);?></h6>
              <p class="recent-post-sm-meta text-muted"><i class="dripicons-calendar mr-5"></i>
                <?php echo $bloglib->date;?>
              </p>
            </div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php  } ?>
  </div>
</aside>