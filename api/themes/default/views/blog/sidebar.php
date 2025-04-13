
                <div class="sidebar mb-0">
                    <div class="sidebar-widget">
                        <h3 class="title stroke-shape"><?php echo trans('0284');?></h3>
                        <div class="contact-form-action">
                            <form action="<?php echo base_url().'blog/search'; ?>" method="GET">
                                <div class="input-box">
                                    <div class="form-group mb-0">
                                        <input class="form-control pl-3" type="text" placeholder="<?php echo trans('0283');?>" name="s">
                                        <button class="search-btn" type="submit"><i class="la la-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- end sidebar-widget -->
                    <?php if(!empty($categories)){ ?>
                    <div class="sidebar-widget">
                        <h3 class="title stroke-shape"><?php echo trans('0288');?></h3>
                        <div class="sidebar-category">
                            <?php  foreach($categories as $cat):
                            $count = pt_posts_count($cat->id);
                            if($count > 0){
                            ?>
                            <div class="custom-checkbox">
                                <input type="checkbox" id="cat1">
                                <label for="cat1"><a href="<?php echo base_url().'blog/category?cat='.$cat->slug; ?>"><?php echo $cat->name;?><span class="font-size-13 ml-1">(<?php echo $count;?>)</span></a></label>
                            </div>
                            <?php  } endforeach; ?>
                        </div>
                    </div><!-- end sidebar-widget -->
                      <?php  } ?>
                    <div class="sidebar-widget">
                        <div class="section-tab section-tab-2 pb-3">
                            <ul class="nav nav-tabs justify-content-center" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="recent-tab" data-toggle="tab" href="#recent" role="tab" aria-controls="recent" aria-selected="true">
                                       Recent
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="popular-tab" data-toggle="tab" href="#popular" role="tab" aria-controls="popular" aria-selected="false">
                                        Popular
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="false">
                                        New
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <?php if(!empty($popular_posts)){ ?>
                            <div class="tab-pane " id="recent" role="tabpanel" aria-labelledby="recent-tab">
                                <?php
                                  foreach($popular_posts as $post):
                                  $bloglib->set_id($post->post_id);
                                  $bloglib->post_short_details(); ?>
                                <div class="card-item card-item-list recent-post-card">
                                    <div class="card-img">
                                        <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="d-block">
                                            <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="<?php echo $bloglib->title;?>">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><a href="<?php echo base_url().'blog/'.$post->post_slug;?>"><?php echo character_limiter(strip_tags($bloglib->title), 30);?></a></h3>
                                        <p class="card-meta">
                                            <span class="post__date"><?php echo $bloglib->date;?></span>
                                            <span class="post-dot"></span>
                                            <span class="post__time">3 Mins read</span>
                                        </p>
                                    </div>
                                </div><!-- end card-item -->
                                <?php endforeach; ?>
                            </div><!-- end tab-pane -->
                        <?php } ?>
                      <?php if(!empty($popular_posts)){ ?>
                        <div class="tab-pane fade show active" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                                <?php
                                  foreach($popular_posts as $post):
                                  $bloglib->set_id($post->post_id);
                                  $bloglib->post_short_details(); ?>
                                <div class="card-item card-item-list recent-post-card">
                                    <div class="card-img">
                                        <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="d-block">
                                            <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="<?php echo $bloglib->title;?>">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><a href="<?php echo base_url().'blog/'.$post->post_slug;?>"><?php echo character_limiter(strip_tags($bloglib->title), 30);?></a></h3>
                                        <p class="card-meta">
                                            <span class="post__date"><?php echo $bloglib->date;?></span>
                                            <span class="post-dot"></span>
                                            <span class="post__time">3 Mins read</span>
                                        </p>
                                    </div>
                                </div><!-- end card-item -->
                                <?php endforeach; ?>
                            </div><!-- end tab-pane -->
                            <?php  } ?>
                            <?php if(!empty($popular_posts)){ ?>
                            <div class="tab-pane " id="new" role="tabpanel" aria-labelledby="new-tab">
                                <?php
                                  foreach($popular_posts as $post):
                                  $bloglib->set_id($post->post_id);
                                  $bloglib->post_short_details(); ?>
                                <div class="card-item card-item-list recent-post-card">
                                    <div class="card-img">
                                        <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="d-block">
                                            <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" alt="<?php echo $bloglib->title;?>">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title"><a href="<?php echo base_url().'blog/'.$post->post_slug;?>"><?php echo character_limiter(strip_tags($bloglib->title), 30);?></a></h3>
                                        <p class="card-meta">
                                            <span class="post__date"><?php echo $bloglib->date;?></span>
                                            <span class="post-dot"></span>
                                            <span class="post__time">3 Mins read</span>
                                        </p>
                                    </div>
                                </div><!-- end card-item -->
                                <?php endforeach; ?>
                            </div><!-- end tab-pane -->
                            <?php  } ?>
                        </div>
                    </div><!-- end sidebar-widget -->
                </div><!-- end sidebar -->
