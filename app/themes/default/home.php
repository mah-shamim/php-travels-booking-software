<style>
.lazyloading{background:#c3cdd6}
</style>

<section class="hero-wrapper">
  <div class="hero-box hero-bg active lazyload" data-bg="<?=api_url?>uploads/images/slider/<?php foreach ($app->slider as $item){ if( $item->slide_order == 1 && $item->slide_status == "Yes" ) echo $item->slide_image; } ?>" style="min-height:371px;background-attachment: fixed;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mx-auto responsive--column-l">
          <div class="hero-content pb-4 ">
            <div class="section-heading">
              <!--<h2 class="sec__titles cd-headline zoom d-none d-sm-block" style="color:#fff">
                <?=T::hero1; ?> <span class="cd-words-wrapper" style="width: 252.5px;">
                <?php foreach ($app->modules as $model){ if($model->status == true){ ?>
                <b class="is-hidden" style="text-transform: capitalize;"><?=$model->name ?></b>
                <?php } } ?>
                <b class="is-visible">Flights</b>
                </span>
              </h2>
              <p class="text-white strong"><?=T::hero2; ?></p>-->
            </div>
          </div>
          <!-- end hero-content -->
          <div class="section-tab fade-in glass" style="min-height:167px">
            <ul class="nav nav-tabs listitems" id="Tab" role="tablist">
              <?php if (isset($hotels)) { if ($hotels == 1) {?><li data-position="<?= $hotels_order ?>" class="nav-item" role="presentation"><button class="nav-link" id="hotels-tab" data-bs-toggle="tab" data-bs-target="#hotels" type="button" role="tab" aria-controls="hotels" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-hotel mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-hotel mx-1"></i> <?=T::hotels_hotels; ?></span></button></li><?php } } ?>
              <?php if (isset($flights)) { if ($flights == 1) {?><li data-position="<?= $flights_order ?>" class="nav-item" role="presentation"><button class="nav-link" id="hotels-tab" data-bs-toggle="tab" data-bs-target="#flights" type="button" role="tab" aria-controls="flights" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-plane mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-plane mx-1"></i> <?=T::flights_flights; ?></span></button></li><?php } } ?>
              <?php if (isset($tours)) { if ($tours == 1) {?><li data-position="<?= $tours_order ?>" class="nav-item" role="presentation"><button class="nav-link" id="tours-tab" data-bs-toggle="tab" data-bs-target="#tours" type="button" role="tab" aria-controls="tours" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-briefcase mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-briefcase mx-1"></i> <?=T::tours_tours; ?></span></button></li><?php } } ?>
              <?php if (isset($cars)) { if ($cars == 1) {?><li data-position="<?= $cars_order ?>" class="nav-item" role="presentation"><button class="nav-link" id="cars-tab" data-bs-toggle="tab" data-bs-target="#cars" type="button" role="tab" aria-controls="cars" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-car mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-car mx-1"></i> <?=T::cars_cars; ?></span></button></li><?php } } ?>
              <?php if (isset($visa)) { if ($visa == 1) {?><li data-position="<?= $visa_order ?>" class="nav-item" role="presentation"><button class="nav-link" id="visa-tab" data-bs-toggle="tab" data-bs-target="#visa" type="button" role="tab" aria-controls="visa" aria-selected="false"><span class="d-xl-none d-lg-none"><i class="la la-passport mx-1"></i></span><span class="d-none d-lg-block d-xl-block"><i class="la la-passport mx-1"></i> <?=T::visa_visa; ?></span></button></li><?php } } ?>
            </ul>
            <div class="tab-content search-fields-container search_area search_tabs" id="TabContent">
              <?php foreach ($app->modules as $model){ if($model->status == true){ ?>
              <div class="tab-pane fade" id="<?=$model->name ?>" role="<?=$model->name ?>" aria-labelledby="<?=$model->name ?>-tab">
              <?php require_once 'modules/'.$model->name.'/search.php';?>
              </div>
              <?php } } ?>
            </div>
          </div>
          <?php // recent searches from session
          if (isset($_SESSION['SEARCHES'])) { ?>
          <div class="row mt-3">
          <div class="col-md-12">
          <p class="mb-0 cw"><?=T::recentsearches?></p>
          <hr style="margin: 4px 0; color: #fff;">
          </div>
            <?php  $max = 12;
            $max_print = count(array_unique($_SESSION['SEARCHES'], SORT_REGULAR));
            krsort($_SESSION['SEARCHES']); foreach (array_unique($_SESSION['SEARCHES'], SORT_REGULAR) as $index => $SEARCHES)  if ($max_print < $max) {
            { $urlm = 0; $urlc = 1; $urlb = 2; }
            ?>
            <div class="col-md-2 mt-3">
            <div class="list-group drop-reveal-list recentsearches">
            <a href="<?=$SEARCHES->$urlb?>" class="list-group-item list-group-item-action border-top-0" target="_blank">
            <div class="msg-body d-flex align-items-center">
                <div class="icon-element flex-shrink-0 mr-3 ml-0">
                <?php if(strtolower($SEARCHES->$urlm) =="hotels"){?><i class="la la-hotel"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="flights"){?><i class="la la-plane"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="tours"){?><i class="la la-briefcase"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="cars"){?><i class="la la-car"></i><?php } ?>
                <?php if(strtolower($SEARCHES->$urlm) =="visa"){?><i class="la la-passport"></i><?php } ?>
                </div>
                <div class="msg-content w-100">
                    <h3 class="title pb-0 px-2" style="text-transform:uppercase"><?=$SEARCHES->$urlm?></h3>
                    <p class="msg-text px-2" style="text-transform:capitalize"><?=$SEARCHES->$urlc?></p>
                </div>
            </div>
            </a>
            </div>
            </div>
            <?php } ?>
          </div>
          <?php } else {} ?>
        </div>
      </div>
    </div>
    <!--<svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
      <path d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path>
    </svg>-->
  </div>
</section>
<section class="info-area info-bg padding-top-50px padding-bottom-50px text-center">
   <div class="container">
      <div class="row">
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <i class="la la-bullhorn"></i>
               </div>
               <div class="info-content">
                  <h4 class="info__title"><?=T::hero1?></h4>
                  <p class="info__desc">
                     <?=T::hero2?>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <i class="la la-globe"></i>
               </div>
               <!-- end info-icon-->
               <div class="info-content">
                  <h4 class="info__title"><?=T::hero3?></h4>
                  <p class="info__desc">
                     <?=T::hero4?>
                  </p>
               </div>
            </div>
         </div>
         <div class="col-lg-4">
            <div class="icon-box">
               <div class="info-icon">
                  <i class="la la-thumbs-up"></i>
               </div>
               <div class="info-content">
                  <h4 class="info__title"><?=T::hero5?></h4>
                  <p class="info__desc">
                     <?=T::hero6?>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<?php
if (isset($flights)) { if ($flights == 1) { include theme_url."modules/flights/featured.php"; } }
if (isset($hotels)) { if ($hotels == 1) { include theme_url."modules/hotels/featured.php"; } }
if (isset($tours)) { if ($tours == 1) { include theme_url."modules/tours/featured.php"; } }
if (isset($cars)) { if ($cars == 1) { include theme_url."modules/cars/featured.php"; } }
if (isset($offers)) { if ($offers == 1) { include theme_url."modules/offers/featured.php"; } }
if (isset($blog)) { if ($blog == 1) { include theme_url."modules/blog/featured.php"; } }
?>