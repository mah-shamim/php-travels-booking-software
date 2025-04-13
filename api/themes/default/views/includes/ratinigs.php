<?php if($appModule != "cars" && $appModule != "offers"){ ?>

      <!-- Start Review Total -->
      <?php include 'tripadvisor.php';?>


      <?php if(!empty($avgReviews->overall)){ ?>
      <div class="panel-body panel panel-default">
        <h4><strong><?php echo trans('042');?> </strong><?php echo $avgReviews->totalReviews; ?>  <strong><?php echo trans('035'); ?></strong> <?php echo $avgReviews->overall;?>/10</h4>
        <hr>
        <div class="clearfix"></div>
        <?php } ?>
        <!-- End Review Total -->
        <?php } ?>
        <!-- Start Hotel Reviews bars -->
        <?php if($appModule == "hotels" && !empty($avgReviews->overall)){ ?>
        <div class="row RTL">
          <div class="col-xs-12">
            <div class="col-xs-2 col-md-4 col-lg-1 go-right">
              <label class="text-left"><?php echo trans('030');?></label>
            </div>
            <div class="col-xs-9 col-md-8 col-lg-11 go-left">
              <div class="progress">
                <div class="progress-bar progress-bar-primary go-right" role="progressbar" aria-valuenow="20"
                  aria-valuemin="0" aria-valuemax="10" style="width: <?php echo $avgReviews->clean * 10;?>%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-2 col-md-4 col-lg-1 go-right">
              <label class="text-left"><?php echo trans('031');?></label>
            </div>
            <div class="col-xs-9 col-md-8 col-lg-11 go-left">
              <div class="progress">
                <div class="progress-bar progress-bar-primary go-right" role="progressbar" aria-valuenow="20"
                  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avgReviews->comfort * 10;?>%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-2 col-md-4 col-lg-1 go-right">
              <label class="text-left"><?php echo trans('032');?></label>
            </div>
            <div class="col-xs-9 col-md-8 col-lg-11 go-left">
              <div class="progress">
                <div class="progress-bar progress-bar-primary go-right" role="progressbar" aria-valuenow="20"
                  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avgReviews->location * 10;?>%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-2 col-md-4 col-lg-1 go-right">
              <label class="text-left"><?php echo trans('033');?></label>
            </div>
            <div class="col-xs-9 col-md-8 col-lg-11 go-left">
              <div class="progress">
                <div class="progress-bar progress-bar-primary go-right" role="progressbar" aria-valuenow="20"
                  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avgReviews->facilities * 10;?>%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-2 col-md-4 col-lg-1 go-right">
              <label class="text-left"><?php echo trans('034');?></label>
            </div>
            <div class="col-xs-9 col-md-8 col-lg-11 go-left">
              <div class="progress">
                <div class="progress-bar progress-bar-primary go-right" role="progressbar" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avgReviews->staff * 10;?>%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <?php } ?>
        <!-- End Hotel Reviews bars -->
       <!-- End Add/Remove Wish list Review Section -->
        <div class="row">
          <div class="clearfix"></div>
          <div class="col-md-12 form-group">
            <?php if($appModule != "cars" && $appModule != "ean" && $appModule != "offers" ){ ?>
            <button  data-toggle="collapse" data-parent="#accordion" class="writeReview btn btn-primary btn-block" href="#ADDREVIEW"><i class="icon_set_1_icon-68"></i> <?php echo trans('083');?></button>
            <?php if(!empty($reviews) > 0){ ?>
            <?php }  ?>
            <?php } ?>
            <?php if($appModule != "offers" && $appModule != "ean"){ ?>
            <?php $currenturl = current_url(); $wishlist = pt_check_wishlist($customerloggedin,$module->id); if($allowreg){ if($wishlist){ ?>
            <span class="btn wish btn-danger btn-outline removewishlist btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('028');?></span></span>
            <?php }else{ ?>
            <span class="btn wish addwishlist btn-danger btn-outline btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('029');?></span></span>
            <?php } } } ?>
          </div>
        </div>
      </div>

