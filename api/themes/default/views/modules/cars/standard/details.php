<link href="<?php echo $theme_url; ?>assets/include/slider/slider.min.css" rel="stylesheet" />
<script src="<?php echo $theme_url; ?>assets/js/details.js"></script>
<script src="<?php echo $theme_url; ?>assets/include/slider/slider.js"></script>
<style>
  @media (min-width: 992px){
  .header-waypoint-sticky.header-main {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 99999;
  }
  }
  .amint-text {
  display: inline-block;
  transform: translateY(-10px);
  }
  .form-icon-left {
  display: flex;
  }
  .form-icon-left >label {
  flex: 2;
  }
  .form-icon-left > select {
  flex: 2;
  }
  .collapse .card-body{
  margin-bottom:10px;
  }
  .table-condensed>tbody>tr>td{
  padding:5px;
  }
  .section-title h3{
  font-family:inherit !important;
  }
  .header-main .header-nav{
  box-shadow:none !important;
  }
  .panel-heading{
  padding: 11px 18px;
  background-color: #f8f8f8;
  border-bottom: 1px solid #e7e7e7;
  font-size: 14px;
  color: #000;
  border-top-right-radius: 3px;
  border-top-left-radius: 3px;
  text-transform: uppercase;
  letter-spacing: 2px;
  }
  .tchkin{
  height: calc(2.7em + .75rem + 2px);
  margin-top: 20px !important;
  }
  ul.booking-amount-list:before{
  content:''
  }
  ul.booking-amount-list li {
  width: 100%;
  float: none;
  }
  .select2-container .select2-choice{
  overflow:visible !important;
  }
</style>
<div class="main-wrapper scrollspy-action">
  <div class="page-wrapper page-detail bg-light">
    <div class="detail-header">
      <div class="container">
        <div class="d-flex flex-column flex-lg-row sb">
          <?php if($appModule != "offers"){ ?>
          <div class="o2">
            <h2 id="detail-content-sticky-nav-00" class="name"><?php echo character_limiter($module->title, 28);?></h2>
            <div class="star-rating-wrapper">
              <div class="rating-item rating-inline">
                <div class="rating-icons">
                  <?php echo $module->stars;?>
                  <!-- <input type="hidden" class="rating" data-filled="rating-icon fas fa-star rating-rated" data-empty="rating-icon far fa-star" data-fractions="2" data-readonly value="4.5"/> -->
                </div>
              </div>
            </div>
              <?php if(!empty($module->discount)){?><div class="discount"><?=$module->discount?> % <?=lang('0118')?></div><?php } ?>
            <div class="clear"></div>
            <p class="location go-text-right">
              <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
              <i class="material-icons text-info small">place</i>
              <?php } ?>
              <?php echo $module->location; ?>
              <?php if(!empty($module->mapAddress)){ ?> <small class="hidden-xs">, <?php echo character_limiter($module->mapAddress, 50);?></small>
              <?php } ?>
              <a href="#detail-content-sticky-nav-03" class="anchor">
              <?php echo trans('0143');?>
              </a>
            </p>
          </div>
          <?php } ?>
          <div class="ml-lg-auto text-left text-lg-right mt-20 mt-lg-0 o1">
            <?php  if($item->price > 0){ ?>
            <div class="price">
              <span class="text-secondary"><?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
            </div>
            <?php } ?>
            <a href="#detail-content-sticky-nav-01" class="anchor btn btn-primary btn-wide">
            <?php echo trans('046');?>
            </a>
          </div>
        </div>
      </div>
    </div>
    <span id="detail-content-sticky-nav-00" class="d-block"></span>
    <div class="fullwidth-horizon-sticky d-none d-lg-block">
      <div class="fullwidth-horizon-sticky-inner">
        <div class="container">
          <div class="fullwidth-horizon-sticky-item clearfix">
            <ul id="horizon-sticky-nav" class="horizon-sticky-nav clearfix">
              <li>
                <a href="#detail-content-sticky-nav-00"><?php echo trans('044');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-01"><?php echo trans('0248');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-02"><?php echo trans('040');?></a>
              </li>
              <li>
                <a href="#detail-content-sticky-nav-03"><?php echo trans('032');?></a>
              </li>
              <!-- <li>
                <a href="#detail-content-sticky-nav-04"><?php echo trans('033');?></a>
              </li> -->
              <!-- <li>
                <a href="#detail-content-sticky-nav-05"><?php echo trans('040');?></a>
              </li> -->
              <li>
                <a href="#detail-content-sticky-nav-06"><?php echo trans('0493');?></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div id="change-search" class="collapse mt-30">
        <div class="change-search-wrapper">
          <div class="row gap-10 gap-xl-20 align-items-end">
            <div class="col-12 col-lg-12">
              <div class="form-group">
                <?php echo searchForm($appModule, $data); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row gap-30">
        <div class="col-12 col-lg-8 col-xl-9 o1">
          <div class="content-wrapper">
            <div class="slick-gallery-slideshow detail-gallery">
              <div class="slider gallery-slideshow">
                <?php foreach($module->sliderImages as $img){ ?>
                <div>
                  <div class="image"><img src="<?php echo $img['fullImage']; ?>" alt="Images" /></div>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php require $themeurl.'views/socialshare.php';?>
<?php include $themeurl.'views/includes/copyURL.php';?>
            <div id="detail-content-sticky-nav-01" class="fullwidth-horizon-sticky-section car-over">
              <h3 class="heading-title"><span><?php echo trans('0248'); ?></span></h3>
              <div class="clear"></div>
              <?php echo character_limiter($module->desc,1000 );?>
              <hr>
            </div>
            <div class="clear"></div>
            <div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section">
              <script>
                $("form[name=fModifySearch]").submit(function (e) {
                    e.preventDefault();
                    let values = {};
                    $.each($(this).serializeArray(), function(i, field) {
                        values[field.name] = field.value;
                    });
                    redirectUrl = values.city+'/'+values.hotelname+'/'+values.checkin.replace(/\//g,'-')+'/'+values.checkout.replace(/\//g,'-')+'/'+values.adults+'/'+values.child;
                    window.location.href = '<?=base_url('hotels/detail/')?>'+redirectUrl;
                });
              </script>
              <?php if($appModule == "offers"){  }else if($appModule == "cars" || $appModule == "hotels" || $appModule == "ean" || $appModule == "tours"){ ?>
              <!-- Start checkInInstructions -->
              <?php if(!empty($checkInInstructions)){ ?>
              <div class="panel panel-default">
                <div class="panel-heading go-text-right panel-green">
                  <?php echo trans('0550'); ?>
                </div>
                <?php }  if(!empty($checkInInstructions)){ ?>
                <div class="panel-body">
                  <span class="RTL">
                    <p>
                      <?php echo $checkInInstructions; ?>
                    </p>
                  </span>
                </div>
              </div>
              <?php } ?>
              <!-- end checkInInstructions -->
              <!-- Start SpecialcheckInInstructions -->
              <?php if(!empty($specialCheckInInstructions)){ ?>
              <div class="panel panel-default">
                <div class="panel-heading go-text-right panel-green">
                  <?php echo trans('0551'); ?>
                </div>
                <?php }  if(!empty($specialCheckInInstructions)){ ?>
                <div class="panel-body">
                  <span class="RTL">
                    <p>
                      <?php echo $specialCheckInInstructions; ?>
                    </p>
                  </span>
                </div>
              </div>
              <?php } ?>
              <!-- End SpecialcheckInInstructions -->
              <div id="detail-content-sticky-nav-05" class="fullwidth-horizon-sticky-section">
                <h3 class="heading-title"><span><?php echo trans('0148');?></span></h3>
                <div class="clear"></div>
                <div class="feature-box-2 mb-0 bg-white">
                  <div class="feature-row">
                    <div class="row gap-10 gap-md-30">
                      <div class="col-xs-12 col-sm-4 col-md-3 o2">
                        <h6><?php echo trans('0148');?></h6>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-9 o1">
                        <p class="go-text-right"><?php if(!empty($module->policy)){ ?><?php echo $module->policy; } ?></p>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <?php if(!empty($module->paymentOptions)){ ?>
                  <div class="feature-row">
                    <div class="row gap-10 gap-md-30">
                      <div class="col-xs-12 col-sm-4 col-md-3 o2">
                        <h6><?php echo trans('0265');?></h6>
                      </div>
                      <div class="col-xs-12 col-sm-8 col-md-9 o1">
                        <p><?php foreach($module->paymentOptions as $pay){ if(!empty($pay->name)){ ?>
                          <?php echo $pay->name;?> -
                          <?php } } ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="container">
                <div class="">
                  <div class="clearfix"></div>
                  <!-- Start checkInInstructions -->
                  <?php if(!empty($checkInInstructions)){ ?>
                  <div class="panel panel-default">
                    <div class="panel-heading go-text-right panel-green">
                      <?php echo trans('0550'); ?>
                    </div>
                    <?php }  if(!empty($checkInInstructions)){ ?>
                    <div class="panel-body">
                      <span class="RTL">
                        <p>
                          <?php echo $checkInInstructions; ?>
                        </p>
                      </span>
                    </div>
                  </div>
                  <?php } ?>
                  <!-- End checkInInstructions -->
                  <!-- Start SpecialcheckInInstructions -->
                  <?php if(!empty($specialCheckInInstructions)){ ?>
                  <div class="panel panel-default">
                    <div class="panel-heading go-text-right panel-green">
                      <?php echo trans('0551'); ?>
                    </div>
                    <?php }  if(!empty($specialCheckInInstructions)){ ?>
                    <div class="panel-body">
                      <span class="RTL">
                        <p>
                          <?php echo $specialCheckInInstructions; ?>
                        </p>
                      </span>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              </form>
            </div>
            </section>
            <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
              <h3 class="heading-title"><span><?=lang('0143')?></span></h3>
              <div class="clear"></div>
              <div class="hotel-detail-location-wrapper">
                <div class="row gap-30">
                  <div class="col-12 col-md-12">
                    <div class="map-holder">
                      <div id="hotel-detail-map" data-lat="<?php echo $module->latitude;?>" data-lon="<?php echo $module->longitude;?>" style="width: 100%; height: 480px;"></div>
                      <div class="infobox-wrapper">
                        <div id="infobox">
                          <div class="infobox-inner">
                            <div class="font500 font12"><?php echo character_limiter($module->title, 28);?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!------------------------  Related Listings   ------------------------------>
            <div id="detail-content-sticky-nav-06" class="fullwidth-horizon-sticky-section">
              <div class="container">
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
                </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <?php require $themeurl.'views/includes/review.php';?>
                <?php require $themeurl.'views/includes/reviews.php';?>
                <div class="clearfix"></div>
              </div>
            </div>
            <!-- End Hotel Reviews bars -->
            <!-- End Add/Remove Wish list Review Section -->
          </div>
          <div  class="col-12 col-lg-4 col-xl-3 order-lg-last o1">
            <aside class="sticky-kit sidebar-wrapper">
              <?php if($appModule == "cars"){ ?>
              <form class="" action="<?php echo base_url().$appModule;?>/book/<?php echo $module->bookingSlug;?>" method="GET" role="search">
                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-block btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
                <div class="booking-selection-box mt-20">
                  <div class="heading clearfix">
                    <div class="d-flex align-items-end">
                      <div>
                        <h5 class="text-white font-serif font400"><?php echo trans('0463'); ?></h5>
                        <div class="clear"></div>
                      </div>
                    </div>
                  </div>
                  <div class="content">
                    <div class="hotel-room-sm-item">
                      <div class="the-hotel-item">
                        <p class ="go-text-right">
                          <?php echo trans('0210');?>
                        </p>
                      </div>
                      <div class="the-hotel-item">
                        <select name="pickupLocation" class="chosen-the-basic form-control" id="pickuplocation" required>
                          <option value=""><?php echo trans('0447');?></option>
                          <?php foreach($carspickuplocationsList as $locations): ?>
                          <option value="<?php echo $locations->id;?>" <?php echo makeSelected($selectedpickupLocation, $locations->id); ?> ><?php echo $locations->name;?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="the-hotel-item">
                        <p class="go-text-right"><?php echo trans('0211');?></p>
                      </div>
                      <div class="the-hotel-item">
                        <select name="dropoffLocation" class="form-control" id="droplocation" required>
                          <option value=""><?php echo trans('0447');?></option>
                          <?php if(!empty($selecteddropoffLocation)){ foreach($carsdropofflocationsList as $locations): ?>
                          <option value="<?php echo $locations->id;?>" <?php echo makeSelected($selecteddropoffLocation, $locations->id); ?> ><?php echo $locations->name;?></option>
                          <?php endforeach; } ?>
                        </select>
                      </div>
                      <div class="the-hotel-item">
                        <p class="go-text-right"><?php echo trans('0210');?> <?php echo trans('08');?></p>
                      </div>
                      <div class="the-hotel-item">
                        <p><input id="departcar2" name="pickupDate" value="<?php echo $module->pickupDate;?>" placeholder="date" type="text" class="form-control carDates" required></p>
                      </div>
                      <div class="the-hotel-item">
                        <p><?php echo trans('0210');?> <?php echo trans('0259');?></p>
                      </div>
                      <div class="the-hotel-item">
                        <select class="form-control input" name="pickupTime">
                          <?php foreach($carModTiming as $time){ ?>
                          <option value="<?php echo $time; ?>" <?php makeSelected($pickupTime,$time); ?> ><?php echo $time; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="the-hotel-item">
                        <p class="go-text-right"><?php echo trans('0211');?> <?php echo trans('08');?></p>
                      </div>
                      <div class="the-hotel-item">
                        <input id="returncar2" name="dropoffDate" value="<?php echo $module->dropoffDate;?>" placeholder="date" type="text" class="form-control carDates" required>
                      </div>
                      <div class="the-hotel-item">
                        <p class="go-text-right"><?php echo trans('0211');?> <?php echo trans('0259');?></p>
                      </div>
                      <div class="the-hotel-item">
                        <select class="form-control input" name="dropoffTime">
                          <?php foreach($carModTiming as $time){ ?>
                          <option value="<?php echo $time; ?>" <?php makeSelected($dropoffTime,$time); ?> ><?php echo $time; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <input type="hidden" id="cartotals" value="<?php echo $module->showTotal; ?>">
                    </div>
                    <div class="showTotal fadeIn animated">
                      <div class="col-xs-12 well well-sm text-center">
                        <h4 class="totalCost strong float-none"><?php echo trans('078');?> <?php echo $module->currCode;?> <?php echo $module->currSymbol;?><strong><span class="grandTotal"><?=$module->totalCost?></span></strong></h4>
                        
                        <p><small> <?php echo trans('0153');?> <?php echo $module->currCode;?> <?php echo $module->currSymbol;?><span class="totalTax"> <?php echo $module->taxAmount;?></span> </small></p>
                        <small> <?php echo trans('0126');?> <?php echo $module->currCode;?> <?php echo $module->currSymbol;?><span class="totaldeposit"> <?php echo $module->totalDeposit;?></span> </small>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr style="margin-top: 5px; margin-bottom: 12px;">
                    <button type="submit" class="btn btn-secondary btn-block mt-20"><?php echo trans('0142');?></button>
                  </div>
                </div>
              </form>
              <?php } ?>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="fullwidth-horizon-sticky border-0">&#032;</div>
<!-- is used to stop the above stick menu -->
</div>
</div>
<?php if(!empty($module->relatedItems)){ ?>
<section class="bg-white section-sm">
  <div class="container">
    <div class="section-title mb-25">
      <h3><?php if($appModule == "hotels" || $appModule == "ean"){ echo trans('0290'); }else if($appModule == "tours"){ echo trans('0453'); }else if($appModule == "cars"){ echo trans('0493'); } ?></h3>
      <div class="clear"></div>
    </div>
    <div class="row equal-height cols-1 cols-sm-2 cols-lg-3 gap-10 gap-lg-20 gap-xl-30">
      <?php foreach($module->relatedItems as $item){ ?>
      <div class="col">
        <div class="product-grid-item">
          <a href="<?php echo $item->slug;?>">
            <div class="image">
              <img src="<?php echo $item->thumbnail;?>" alt="Image">
            </div>
            <div class="content clearfix">
              <div class="rating-item rating-sm go-text-right">
                <div class="rating-icons">
                  <?php echo $item->stars;?>
                </div>
                <!-- <p class="rating-text text-muted"><span class="bg-primary">9.3</span> <strong class="text-dark">Fabulous</strong> - 367 reviews</p> -->
              </div>
              <div class="short-info">
                <h5 class="RTL"><?php echo character_limiter($item->title,25);?></h5>
                <div class="clear"></div>
                <p class="location go-text-right"><i class="fas fa-map-marker-alt text-primary"></i> <?php echo character_limiter($item->location,20);?></p>

                <?php if($item->price > 0){ ?>
                <div class="mt-10">
                    <?php echo trans( '0368');?>
                    <span class="text-secondary"><strong><?php echo $item->currSymbol; ?><?php echo $item->price;?></strong></span>
                </div>
                <?php } ?>
            </div>
            </div>
          </a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>
</div>
<input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
<input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
<input type="hidden" id="module" value="<?php echo $appModule;?>" />
<input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
<input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />
<script>
  $(function(){
    $(".changeInfo").on("change",function(){
      var tourid = "<?php echo $module->id; ?>";
      var adults = $("#selectedAdults").val();
      var child = $("#selectedChild").val();
      var infants = $("#selectedInfants").val();
        $.post("<?php echo base_url()?>tours/tourajaxcalls/changeInfo",{tourid: tourid, adults: adults, child: child, infants: infants},function(resp){
        var result = $.parseJSON(resp);
        $(".adultPrice").html(result.currSymbol+result.adultPrice);
        $(".childPrice").html(result.currSymbol+result.childPrice);
        $(".infantPrice").html(result.currSymbol+result.infantPrice);
        $(".totalCost").html(result.currCode+" "+result.currSymbol+result.totalCost);
        $(".totaldeposit").html(result.currCode+" "+result.currSymbol+result.totalDeposit);
        console.log(result);
      })
    }); //end of change info
  })// end of document ready
</script>
<!-- aside -->
<script>
  //------------------------------
  // Write Reviews
  //------------------------------
   $(function(){
   $('.reviewscore').change(function(){
   var sum = 0;
   var avg = 0;
   var id = $(this).attr("id");
   $('.reviewscore_'+id+' :selected').each(function() {
   sum += Number($(this).val());
   });
   avg = sum/5;
   $("#avgall_"+id).html(avg);
   $("#overall_"+id).val(avg);
   });
  
   //submit review
   $(".addreview").on("click",function(){
   var id = $(this).prop("id");
   $.post("<?php echo base_url();?>admin/ajaxcalls/postreview", $("#reviews-form-"+id).serialize(), function(resp){
   var response = $.parseJSON(resp);
   // alert(response.msg);
   $("#review_result"+id).html("<div class='alert "+response.divclass+"'>"+response.msg+"</div>").fadeIn("slow");
   if(response.divclass == "alert-success"){
   setTimeout(function(){
   $("#ADDREVIEW").removeClass('in');
   $("#ADDREVIEW").slideUp();
   }, 5000);
   }
   });
   setTimeout(function(){
   $("#review_result"+id).fadeOut("slow");
   }, 3000);
   });
   })
  
  $('.collapse').on('show.bs.collapse', function () {
       $('.collapse.in').collapse('hide');
   });
  //------------------------------
  // Add to Wishlist
  //------------------------------
     $(function(){
   // Add/remove wishlist
   $(".wish").on('click',function(){
   var loggedin = $("#loggedin").val();
   var removelisttxt = $("#removetxt").val();
   var addlisttxt = $("#addtxt").val();
   var title = $("#itemid").val();
   var module = $("#module").val();
   if(loggedin > 0){ if($(this).hasClass('addwishlist')){
    var confirm1 = confirm("<?php echo trans('0437');?>");
    if(confirm1){
   $(".wish").removeClass('addwishlist btn-primary');
   $(".wish").addClass('removewishlist btn-warning');
   $(".wishtext").html(removelisttxt);
   $.post("<?php echo base_url();?>account/wishlist/add", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){ });
    }
    return false;
   }else if($(this).hasClass('removewishlist')){
   var confirm2 = confirm("<?php echo trans('0436');?>");
   if(confirm2){
   $(".wish").addClass('addwishlist btn-primary'); $(".wish").removeClass('removewishlist btn-warning');
   $(".wishtext").html(addlisttxt);
   $.post("<?php echo base_url();?>account/wishlist/remove", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){
   });
   }
   return false;
   } }else{ alert("<?php echo trans('0482');?>"); } });
   // End Add/remove wishlist
   })
</script>