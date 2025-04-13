<!-- ================================
    START BREADCRUMB TOP BAR
    ================================= -->
<!--<section class="breadcrumb-top-bar">
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="breadcrumb-list breadcrumb-top-list">
<ul class="list-items d-flex justify-content-start">
<li><a href="<?=base_url();?>"><?=trans('01');?></a></li>
<li><?=trans('Hotels');?></li>
<li><?php echo character_limiter($module->title, 100);?></li>
</ul>
</div>
</div>
</div>
</div>
</section>-->
<!-- ================================
    END BREADCRUMB TOP BAR
    ================================= -->
<!-- ================================
    START ROOM DETAIL BREAD
    ================================= -->

<style>
.cabin-type .select-contain .dropdown-toggle { padding: 8px 20px }
.cabin-type .select-contain .dropdown-toggle::after { top:10px }
</style>

<section class="room-detail-bread" style="max-height:528px;overflow:hidden">
    <div class="full-width-slider carousel-action">
        <?php foreach($module->sliderImages as $img){ ?>
        <div class="full-width-slide-item">
            <img src="<?php echo $img['fullImage']; ?>" style="width:100%" alt="slider">
        </div>
        <?php } ?>
    </div>
    <!-- end full-width-slider -->
</section>
<!-- end room-detail-bread -->
<!-- ================================
    END ROOM DETAIL BREAD
    ================================= -->
<!-- ================================
    START BREADCRUMB AREA
    ================================= -->
<!-- <section class="breadcrumb-area bread-bg-7 py-0" style="background-image: url(<?php echo ($module->thumbnail);?> );">
<div class="breadcrumb-wrap">
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="breadcrumb-btn">
<div class="btn-box">
<a class="theme-btn" data-src="images/img1.jpg" data-fancybox="gallery" data-caption="Showing image - 01" data-speed="700"> <i class="la la-photo mr-2"></i>More Photos  </a>
</div>
<?php foreach($module->sliderImages as $img){ ?>
<a class="d-none" data-fancybox="gallery" data-src="<?php echo $img['fullImage']; ?>" data-caption="Showing image - 02" data-speed="700"></a>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</section>-->
<!-- ================================
    END BREADCRUMB AREA
    ================================= -->
<!-- ================================
    START TOUR DETAIL AREA
    ================================= -->
<section class="tour-detail-area padding-bottom-90px">
    <div class="single-content-navbar-wrap menu section-bg" id="single-content-navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-content-nav" id="single-content-nav">
                        <ul>
                            <li><a data-scroll="description" href="#description" class="scroll-link active"><?php echo trans('0248');?></a></li>
                            <li><a data-scroll="availability" href="#availability" class="scroll-link"><?php echo trans('0372');?></a></li>
                            <li><a data-scroll="amenities" href="#amenities" class="scroll-link"><?php echo trans('033');?></a></li>
                            <li><a data-scroll="faq" href="#faq" class="scroll-link"><?php echo trans('040');?></a></li>
                            <li><a data-scroll="location" href="#location" class="scroll-link"><?php echo trans('032');?></a></li>
                            <li><a data-scroll="reviews" href="#reviews" class="scroll-link"><?php echo trans('0396');?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single-content-navbar-wrap -->
    <div class="single-content-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-content-wrap padding-top-60px">
                        <div id="description" class="page-scroll">
                            <div class="single-content-item pb-4">
                                <h3 class="title font-size-26"><?php echo character_limiter($module->title, 100);?> <small class="stars"><?php echo $module->stars;?></small></h3>
                                <div class="d-flex align-items-center pt-2">
                                    <p class="mr-2"><i class="la la-map-marker"></i> <b><?php echo $module->location; ?>,</b></p>
                                    <p><span><?php echo character_limiter($module->mapAddress, 50);?></span></p>
                                </div>
                            </div>
                            <!-- end single-content-item -->
                            <div class="section-block"></div>
                            <div class="single-content-item mt-1">
                                <div class="single-content-item padding-bottom-40px">
                                    <h3 class="title font-size-20"><?php echo trans('0248'); ?></h3>
                                    <p><?php echo $module->desc; ?></p>
                                </div>
                                <!-- end single-content-item -->
                                <?php include $themeurl.'views/includes/socialshare.php';?>
                                <?php include $themeurl.'views/includes/copyURL.php';?>
                                <div id="amenities" class="page-scroll">
                                    <div class="single-content-item padding-top-10px padding-bottom-20px">
                                        <h3 class="title font-size-20"><?php echo trans('048'); ?></h3>
                                        <div class="amenities-feature-item pt-4">
                                            <div class="row">
                                                <?php if(!empty($module->amenities)){ ?>
                                                <?php foreach($module->amenities as $amt){ if(!empty($amt->name)){ ?>
                                                <?php if($appModule == "ean"){ ?>
                                                <li >
                                                    <span><img class="go-right" style="max-height:30px;max-width:40px" src="<?php echo $amt->icon;?>"></span>
                                                    <?php echo $amt->name; ?>
                                                </li>
                                                <?php } ?>
                                                <?php if($appModule == "hotels"){ ?>
                                                <div class="col-lg-4 responsive-column">
                                                    <div class="single-tour-feature d-flex align-items-center mb-3">
                                                        <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                            <i class="">
                                                            <img data-toggle="tooltip" class="go-right" data-placement="top" title="<?php echo $amt->name; ?>"  style="max-height:30px;max-width:40px" src="<?php echo $amt->icon;?>">
                                                            </i>
                                                        </div>
                                                        <div class="single-feature-titles">
                                                            <h3 class="title font-size-15 font-weight-medium"><?php echo $amt->name; ?></h3>
                                                        </div>
                                                    </div>
                                                    <!-- end single-tour-feature -->
                                                </div>
                                                <!-- end col-lg-4 -->
                                                <?php } ?>
                                                <?php } } ?>
                                                <?php } ?>
                                            </div>
                                            <!-- end row -->
                                        </div>
                                    </div>
                                    <!-- end single-content-item -->
                                    <div class="section-block mb-3"></div>
                                </div>
                                <?php require $themeurl.'views/modules/hotels/standard/rooms_modify_dates.php'; ?>
                            </div>
                            <!-- end single-content-item -->
                            <div class="section-block mb-1 mt-2"></div>
                        </div>
                        <!-- end description -->
                        <div id="availability" class="page-scroll">
                            <div class="single-content-item padding-top-10px padding-bottom-30px">
                                <h3 class="title font-size-20 mb-3">
                                    <?php echo trans('0372'); ?> <?=trans('0655')?> <?php echo $modulelib->stay; ?> <?php echo trans('0122');?>  <!--<?php echo trans('0197'); ?>-->
                                </h3>
                            <div class="section-block mb-2 mt-1"></div>
                               <!--<div class="contact-form-action padding-bottom-35px">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-lg-6 responsive-column">
                                                <div class="input-box">
                                                    <label class="label-text">Check in - Check out</label>
                                                    <div class="form-group">
                                                        <span class="la la-calendar form-icon"></span>
                                                        <input class="date-range form-control" type="text" name="daterange" value="04/28/2020">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 responsive-column">
                                                <div class="input-box">
                                                    <label class="label-text">Rooms</label>
                                                    <div class="form-group">
                                                        <div class="select-contain w-auto">
                                                            <select class="select-contain-select">
                                                                <option value="0">Select Rooms</option>
                                                                <option value="1">1 Room</option>
                                                                <option value="2">2 Rooms</option>
                                                                <option value="3">3 Rooms</option>
                                                                <option value="4">4 Rooms</option>
                                                                <option value="5">5 Rooms</option>
                                                                <option value="6">6 Rooms</option>
                                                                <option value="7">7 Rooms</option>
                                                                <option value="8">8 Rooms</option>
                                                                <option value="9">9 Rooms</option>
                                                                <option value="10">10 Rooms</option>
                                                                <option value="11">11 Rooms</option>
                                                                <option value="12">12 Rooms</option>
                                                                <option value="13">13 Rooms</option>
                                                                <option value="14">14 Rooms</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 responsive-column">
                                                <div class="input-box">
                                                    <label class="label-text">Adults (18+)</label>
                                                    <div class="form-group">
                                                        <div class="select-contain w-auto">
                                                            <select class="select-contain-select">
                                                                <option value="0">Select Adults</option>
                                                                <option value="1">1 Adults</option>
                                                                <option value="2">2 Adults</option>
                                                                <option value="3">3 Adults</option>
                                                                <option value="4">4 Adults</option>
                                                                <option value="5">5 Adults</option>
                                                                <option value="6">6 Adults</option>
                                                                <option value="7">7 Adults</option>
                                                                <option value="8">8 Adults</option>
                                                                <option value="9">9 Adults</option>
                                                                <option value="10">10 Adults</option>
                                                                <option value="11">11 Adults</option>
                                                                <option value="12">12 Adults</option>
                                                                <option value="13">13 Adults</option>
                                                                <option value="14">14 Adults</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 responsive-column">
                                                <div class="input-box">
                                                    <label class="label-text">Children (0-17)</label>
                                                    <div class="form-group">
                                                        <div class="select-contain w-auto">
                                                            <select class="select-contain-select">
                                                                <option value="0">Select Children</option>
                                                                <option value="1">1 Children</option>
                                                                <option value="2">2 Children</option>
                                                                <option value="3">3 Children</option>
                                                                <option value="4">4 Children</option>
                                                                <option value="5">5 Children</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="btn-box">
                                                    <button type="button" class="theme-btn">Search Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>-->
                                <!-- end contact-form-action -->
                                <div class="row gap-20 text-left">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="row gap-20">
                                            <div class="col-xss-12 col-xs-9 col-sm-8 col-md-8 go-text-right">
                                                <span><?=lang('0246')?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-sm-offset-4 col-md-6 col-md-offset-0">
                                        <div class="row gap-20">
                                            <div class="col-xs-12 col-sm-8 col-md-8 go-text-center">
                                                <span><?=lang('0435')?> <?=lang('0559')?></span>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 go-text-center">
                                                <span><?=lang('0155')?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if(!empty($modulelib->stayerror)){ ?>
                                <div class="panel-body">
                                    <div class="alert alert-danger go-text-right">
                                        <?php echo trans("0420"); ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if(!empty($rooms)){?>
                                    <form action="<?php echo base_url().$appModule;?>/book/<?php echo $module->bookingSlug;?>" method="GET">
                                      <div class="cabin-type padding-top-30px">
                                        <?php foreach($rooms as $r){ if($r->maxQuantity > 0){ ?>
                                        <input type="hidden" name="adults" value="<?php  echo $modulelib->adults; ?>" />
                                        <input type="hidden" name="child" value="<?php  echo $modulelib->children; ?>" />
                                        <input type="hidden" name="checkin" value="<?php  echo $modulelib->checkin; ?>" />
                                        <input type="hidden" name="checkout" value="<?php  echo $modulelib->checkout; ?>" />
                                        <input type="hidden" name="roomid" value="<?php echo $r->id; ?>" />
                                        <div class="cabin-type-item seat-selection-item d-flex mb-3">
                                            <div class="cabin-type-img flex-shrink-0">
                                                <img src="<?php echo $r->thumbnail;?>" alt="room">
                                                <div class="room-photos">
                                                    <a class="btn theme-btn-hover-gray btn-block" data-src="<?php echo $r->thumbnail;?>"
                                                        data-fancybox="gallery"
                                                        data-caption="Main room Image"
                                                        data-speed="700">
                                                    <i class="la la-photo mr-2"></i> <?=trans('0435');?> <?=trans('017');?>
                                                    </a>
                                                </div>
                                                <?php foreach($r->Images as $Img){ if($r->thumbnail != $Img['thumbImage']){ ?>
                                                <a class="d-none" data-fancybox="gallery" data-src="<?php echo $Img['thumbImage'];?>" data-caption="<?php echo $r->title;?>" data-speed="700"></a>
                                                <?php } } ?>
                                            </div>
                                            <div class="cabin-type-detail">
                                                <h3 class="title"><?php echo $r->title;?></h3>
                                                <div class="row pt-1">
                                                    <div class="col-lg-4 responsive-column">
                                                        <div class="single-tour-feature d-flex align-items-center mb-1">
                                                            <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-2">
                                                                <i class="las la-user"></i>
                                                            </div>
                                                            <div class="single-feature-titles">
                                                                <h3 class="title font-size-15 font-weight-medium"><?php echo trans('010');?> <?php echo $r->Info['maxAdults'];?><span data-toggle="tooltip" data-placement="top" title="<?php echo $r->Info['maxAdults'];?>"> <?php for($i =0; $i<$r->Info['maxAdults'];$i++) { ?> <i class="fas fa-male"> </i><?php } ?></span></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 responsive-column">
                                                        <div class="row">
                                                        <div class="col-6">
                                                        <div class="book_buttons hidden-xs hidden-sm go-right d-flex">
                                                            <button class="btn theme-btn-hover-gray" type="button" data-toggle="collapse" data-target="#availability<?php echo $r->id;?>" aria-expanded="false" aria-controls="#availability<?php echo $r->id;?>">
                                                            <?php echo trans('0251');?>
                                                            </button>
                                                        </div>
                                                        </div>

                                                        <div class="col-6 pl-0 mb-1 pr-4">
                                                        <?php if($r->extraBeds > 0){ ?>
                                                        <span class="fs-12"><?php echo trans('0428');?></span>
                                                        <select name="extrabeds[<?=$r->id?>]" class="form-control-sm w-100" id="">
                                                            <option value="0">0</option>
                                                            <?php for($i = 1; $i <= $r->extraBeds; $i++){ ?>
                                                            <option value="<?php echo $i;?>">
                                                                <?php echo $i;?>
                                                                <?php echo $r->currCode." ".$r->currSymbol.$i * $r->extrabedCharges;?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php } ?>
                                                    </div>

                                                    </div>

                                                    </div>
                                                    <div class="col-lg-4 responsive-column">
                                                        <div class="single-tour-feature d-flex align-items-center mb-1">
                                                            <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-2">
                                                                <i class="las la-female"></i>
                                                            </div>
                                                            <div class="single-feature-titles">
                                                                <h3 class="title font-size-15 font-weight-medium"><?php echo trans('011');?> <?php echo $r->Info['maxChild'];?><span data-toggle="tooltip" data-placement="top" title="<?php echo $r->Info['maxChild'];?>"> <?php for($i =0; $i<$r->Info['maxChild'];$i++) { ?> <i class="fas fa-male"> </i><?php } ?></span></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 responsive-column">
                                                        <div class="book_buttons hidden-xs hidden-sm go-right d-flex">
                                                            <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#details<?php echo $r->id;?>" aria-expanded="false" aria-controls="#details<?php echo $r->id;?>">
                                                            <?php echo trans('052');?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 responsive-column pl-0 pr-4">

                                                        <div class="select-contain w-100">
                                                        <select class="select-contain-select" name="roomscount[<?=$r->id?>]">
                                                            <?php for($q = 1; $q <= $r->maxQuantity; $q++){ ?>
                                                            <option value="<?php echo $q;?>">
                                                                <?php echo trans('016');?>  <?php echo $q;?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </div>
                                            <div class="cabin-price">
                                                <?php  if($r->price > 0){ ?>
                                                <p class="text-uppercase font-size-14"><?php echo trans('0245');?> <strong class="mt-n1 text-black font-size-18 font-weight-black d-block"><small><?php echo $r->currSymbol; ?></small><?php echo $r->price; ?></strong></p>
                                                <?php } ?>
                                                <div class="custom-checkbox mb-0">
                                                    <input type="checkbox"  name="rooms[]" value="<?=$r->id?>" id="<?php echo $r->price; ?>" class="custom-control-input go-left pull-right"/>
                                                    <label for="<?php echo $r->price; ?>" class="btn theme-btn-hover-gray">
                                                    <?=lang('0155')?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end cabin-type-item -->
                                    
                                       <div class="collapse" id="availability<?php echo $r->id;?>">
                                        <div class="card card-body">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-5">
                                                        <div class="form-group">
                                                            <select id="<?php echo $r->id;?>" class="form-control showcalendar">
                                                                <option value="0">
                                                                    <?php echo trans('0232');?>
                                                                </option>
                                                                <option value="<?php echo $first;?>">
                                                                    <?php echo $from1;?> -
                                                                    <?php echo $to1;?>
                                                                </option>
                                                                <option value="<?php echo $second;?>">
                                                                    <?php echo $from2;?> -
                                                                    <?php echo $to2;?>
                                                                </option>
                                                                <option value="<?php echo $third;?>">
                                                                    <?php echo $from3;?> -
                                                                    <?php echo $to3;?>
                                                                </option>
                                                                <option value="<?php echo $fourth;?>">
                                                                    <?php echo $from4;?> -
                                                                    <?php echo $to4;?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="roomcalendar<?php echo $r->id;?>" class="row"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="details<?php echo $r->id;?>">
                                        <div class="card card-body">
                                            <?php if(!empty($r->desc)){ ?>
                                            <p class="go-text-right RTL"><strong><?php echo trans('046');?> : </strong> </p>
                                            <span class="rooms-text"><?php echo $r->desc;?></span>
                                            <?php } ?>
                                            <hr>
                                            <?php if(!empty($r->Amenities)){ ?>
                                            <p class="RTL"><strong><?php echo trans('055');?> : </strong></p>
                                            <br>
                                            <div class="row">
                                                <?php foreach($r->Amenities as $roomAmenity){ if(!empty($roomAmenity->name)){ ?>
                                                <div class="col-md-4">
                                                    <div class="single-tour-feature d-flex align-items-center mb-3">
                                                        <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                            <i class="la la-check"></i>
                                                        </div>
                                                        <div class="single-feature-titles">
                                                            <h3 class="title font-size-15 font-weight-medium"><?php echo $roomAmenity->name;?></h3>
                                                        </div>
                                                    </div>
                                                    <!-- end single-tour-feature -->
                                                </div>
                                                <?php } } }  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } } ?>
                                    <button type="submit" class="book_button btn btn-success btn-block btn-lg chk" disabled>
                                    <?php echo trans('0142');?>
                                    </button>
                                </div></form>
                                <!-- end cabin-type -->
                                <?php }else{  echo '<div class="panel-body"><h4 class="alert alert-info">' . trans("066") . '</h4></div>'; } ?>
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
                                <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
                                <?php if(!empty($module->mapAddress)){ ?> <small class="hidden-xs">, </small>
                                <?php } ?>

                                <div class="sidebar-widget single-content-widget">
                                <h3 class="title stroke-shape"><?=lang('0143')?></h3>
                                <div class="enquiry-forum">
                                <div class="">
                                <div class="form-content">

                                <div class="map-holder">
                                <div id="hotel-detail-map" data-lat="<?php echo $module->latitude;?>" data-lon="<?php echo $module->longitude;?>" style="width: 100%; height: 480px;"></div>
                                <div class="infobox-wrapper">
                                <div id="infobox">
                                <div class="infobox-inner">
                                <div class="font500 font12 text-white"><?php echo character_limiter($module->title, 28);?></div>
                                </div>
                                </div>
                                </div>
                                </div>

                                </div>
                                <!-- end form-content -->
                                </div>
                                <!-- end form-box -->
                                </div>
                                <!-- end enquiry-forum -->
                                </div>

                             </div>
                            </div>
                            <!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div>
                        <!-- end location-map -->
                        <!-- end faq -->
                        <div id="faq" class="page-scroll">
                            <div class="single-content-item padding-top-40px padding-bottom-40px">
                                <h3 class="title font-size-20"><?php echo trans('0148');?></h3>
                                <div class="accordion accordion-item padding-top-30px" id="accordionExample2">
                                    <div class="card">
                                        <div class="card-header" id="faqHeadingFour">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link d-flex align-items-center justify-content-end flex-row-reverse font-size-16" type="button" data-toggle="collapse" data-target="#faqCollapseFour" aria-expanded="true" aria-controls="faqCollapseFour">
                                                <span class="ml-3"><?php echo trans('0148');?> </span>
                                                <i class="la la-minus"></i>
                                                <i class="la la-plus"></i>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="faqCollapseFour" class="collapse show" aria-labelledby="faqHeadingFour" data-parent="#accordionExample2">
                                            <div class="card-body d-flex">
                                                <p><?php if(!empty($module->policy)){ ?><?php echo $module->policy; } ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                    <div class="card">
                                        <div class="card-header" id="faqHeadingFive">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link d-flex align-items-center justify-content-end flex-row-reverse font-size-16" type="button" data-toggle="collapse" data-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                                                <span class="ml-3"><?php echo trans('07');?></span>
                                                <i class="la la-minus"></i>
                                                <i class="la la-plus"></i>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="faqCollapseFive" class="collapse" aria-labelledby="faqHeadingFive" data-parent="#accordionExample2">
                                            <div class="card-body d-flex">
                                                <p><b><?php echo trans('07');?></b> <?php echo $module->defcheckin;?> - <b><?php echo trans('09');?></b> <?php echo $module->defcheckout;?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                    <?php if(!empty($module->paymentOptions)){ ?>
                                    <div class="card">
                                        <div class="card-header" id="faqHeadingSix">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link d-flex align-items-center justify-content-end flex-row-reverse font-size-16" type="button" data-toggle="collapse" data-target="#faqCollapseSix" aria-expanded="false" aria-controls="faqCollapseSix">
                                                <span class="ml-3"><?php echo trans('0265');?></span>
                                                <i class="la la-minus"></i>
                                                <i class="la la-plus"></i>
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="faqCollapseSix" class="collapse" aria-labelledby="faqHeadingSix" data-parent="#accordionExample2">
                                            <div class="card-body d-flex">
                                                <p><?php foreach($module->paymentOptions as $pay){ if(!empty($pay->name)){ ?> <?php echo $pay->name;?> - <?php } } ?>.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                    <?php } ?>
                                        <!--<div class="card">
                                        <div class="card-header" id="faqHeadingSeven">
                                        <h2 class="mb-0">
                                        <button class="btn btn-link d-flex align-items-center justify-content-end flex-row-reverse font-size-16" type="button" data-toggle="collapse" data-target="#faqCollapseSeven" aria-expanded="false" aria-controls="faqCollapseSeven">
                                        <span class="ml-3">How do I set reservation requirements?</span>
                                        <i class="la la-minus"></i>
                                        <i class="la la-plus"></i>
                                        </button>
                                        </h2>
                                        </div>
                                        <div id="faqCollapseSeven" class="collapse" aria-labelledby="faqHeadingSeven" data-parent="#accordionExample2">
                                        <div class="card-body d-flex">
                                        <p>Mea appareat omittantur eloquentiam ad, nam ei quas oportere democritum. Prima causae admodum id est, ei timeam inimicus sed. Sit an meis aliquam, cetero inermis vel ut. An sit illum euismod facilisis Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                                        </div>
                                        </div>
                                        </div>-->
                                    <!-- end card -->
                                </div>
                            </div>
                            <!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div>
                        <!-- end faq -->
                        <?php } ?>
                        <div id="reviews" class="page-scroll">
                            <?php if($appModule != "cars" && $appModule != "offers"){ ?>
                            <?php if(!empty($avgReviews->overall)){ ?>
                            <h3 class="heading-title"><?php echo trans('042');?></h3>
                            <div class="clear"></div>
                            <?php } ?>
                            <?php } if (!empty($tripadvisorinfo->rating)) { ?>
                            <?php require $themeurl. 'views/includes/tripadvisor.php'; }else{?>
                            <?php if($appModule == "hotels" && !empty($avgReviews->overall)){ ?>
                            <div class="single-content-item padding-top-40px padding-bottom-40px">
                                <h3 class="title font-size-20">Reviews</h3>
                                <div class="review-container padding-top-30px">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="review-summary">
                                                <h2>4.5<span>/5</span></h2>
                                                <p>Excellent</p>
                                                <span>Based on 4 reviews</span>
                                            </div>
                                        </div>
                                        <!-- end col-lg-4 -->
                                        <div class="col-lg-8">
                                            <div class="review-bars">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="progress-item">
                                                            <h3 class="progressbar-title"><?php echo trans('030');?></h3>
                                                            <div class="progressbar-content line-height-20 d-flex align-items-center justify-content-between">
                                                                <div class="progressbar-box flex-shrink-0">
                                                                    <div class="progressbar-line" data-percent="<?php echo $avgReviews->clean * 10;?>%">
                                                                        <div class="progressbar-line-item bar-bg-1"></div>
                                                                    </div>
                                                                    <!-- End Skill Bar -->
                                                                </div>
                                                                <!-- <div class="bar-percent">4.6</div> -->
                                                            </div>
                                                        </div>
                                                        <!-- end progress-item -->
                                                    </div>
                                                    <!-- end col-lg-6 -->
                                                    <div class="col-lg-6">
                                                        <div class="progress-item">
                                                            <h3 class="progressbar-title"><?php echo trans('031');?></h3>
                                                            <div class="progressbar-content line-height-20 d-flex align-items-center justify-content-between">
                                                                <div class="progressbar-box flex-shrink-0">
                                                                    <div class="progressbar-line" data-percent="<?php echo $avgReviews->comfort * 10;?>%">
                                                                        <div class="progressbar-line-item bar-bg-2"></div>
                                                                    </div>
                                                                    <!-- End Skill Bar -->
                                                                </div>
                                                                <!-- <div class="bar-percent">4.7</div> -->
                                                            </div>
                                                        </div>
                                                        <!-- end progress-item -->
                                                    </div>
                                                    <!-- end col-lg-6 -->
                                                    <div class="col-lg-6">
                                                        <div class="progress-item">
                                                            <h3 class="progressbar-title"><?php echo trans('032');?></h3>
                                                            <div class="progressbar-content line-height-20 d-flex align-items-center justify-content-between">
                                                                <div class="progressbar-box flex-shrink-0">
                                                                    <div class="progressbar-line" data-percent="<?php echo $avgReviews->location * 10;?>%">
                                                                        <div class="progressbar-line-item bar-bg-3"></div>
                                                                    </div>
                                                                    <!-- End Skill Bar -->
                                                                </div>
                                                                <!--<div class="bar-percent">2.6</div>-->
                                                            </div>
                                                        </div>
                                                        <!-- end progress-item -->
                                                    </div>
                                                    <!-- end col-lg-6 -->
                                                    <div class="col-lg-6">
                                                        <div class="progress-item">
                                                            <h3 class="progressbar-title"><?php echo trans('033');?></h3>
                                                            <div class="progressbar-content line-height-20 d-flex align-items-center justify-content-between">
                                                                <div class="progressbar-box flex-shrink-0">
                                                                    <div class="progressbar-line" data-percent="<?php echo $avgReviews->facilities * 10;?>%">
                                                                        <div class="progressbar-line-item bar-bg-4"></div>
                                                                    </div>
                                                                    <!-- End Skill Bar -->
                                                                </div>
                                                                <!-- <div class="bar-percent">3.6</div>-->
                                                            </div>
                                                        </div>
                                                        <!-- end progress-item -->
                                                    </div>
                                                    <!-- end col-lg-6 -->
                                                    <div class="col-lg-6">
                                                        <div class="progress-item">
                                                            <h3 class="progressbar-title"><?php echo trans('034');?></h3>
                                                            <div class="progressbar-content line-height-20 d-flex align-items-center justify-content-between">
                                                                <div class="progressbar-box flex-shrink-0">
                                                                    <div class="progressbar-line" data-percent="<?php echo $avgReviews->staff * 10;?>%">
                                                                        <div class="progressbar-line-item bar-bg-5"></div>
                                                                    </div>
                                                                    <!-- End Skill Bar -->
                                                                </div>
                                                                <!--<div class="bar-percent">2.6</div>-->
                                                            </div>
                                                        </div>
                                                        <!-- end progress-item -->
                                                    </div>
                                                    <!-- end col-lg-6 -->
                                                </div>
                                                <!-- end row -->
                                            </div>
                                        </div>
                                        <!-- end col-lg-8 -->
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div>

                    </div>
                </div>
                <!-- end col-lg-8 -->
                <div class="col-lg-4">
                    <div class="sidebar single-content-sidebar mb-0">
                        <div class="sidebar-widget single-content-widget">
                            <div class="sidebar-widget-item">
                                <div class="sidebar-book-title-wrap mb-3">
                                    <?php if(!empty($module->discount)){?>
                                    <h3 class=""><?=$module->discount?> % <?=lang('0118')?></h3>
                                    <?php } ?>
                                    <?php if($hasRooms){ ?>
                                    <?php if($hasRooms || $appModule == "offers"){ ?>
                                    <p><span class="text-form"><?php echo trans('0273');?></span><span class="text-value ml-2 mr-1"><small><?php echo @$currencySign; ?></small><?php echo @$lowestPrice; ?></span> <a data-scroll="availability" href="#availability">
                                        <?php echo trans('0138');?>
                                        </a>
                                    </p>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                <?php if($appModule != "offers" && $appModule != "ean"){ ?>
                                <?php $currenturl = current_url(); $wishlist = pt_check_wishlist($customerloggedin,$module->id);
                                    if($allowreg && empty($tripadvisorinfo->rating)){
                                    if($wishlist){ ?>
                                <span class="btn wish btn-danger btn-outline removewishlist btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('028');?></span></span>
                                <?php }else{ ?>
                                <span class="btn wish addwishlist btn-success btn-outline btn-block"><span class="wishtext"><i class=" icon_set_1_icon-82"></i> <?php echo trans('029');?></span></span>
                                <?php } } } ?>
                            </div>
                            <!-- end sidebar-widget-item -->
                            <div class="sidebar-widget-item">
                                <div class="contact-form-action">
                                    <form action="#">
                                        <div class="input-box">
                                            <label class="label-text">Check in - Check out</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange" value="04/28/2020">
                                            </div>
                                        </div>
                                        <div class="input-box">
                                            <label class="label-text">Rooms</label>
                                            <div class="form-group">
                                                <div class="select-contain w-auto">
                                                    <select class="select-contain-select">
                                                        <option value="0">Select Rooms</option>
                                                        <option value="1">1 Room</option>
                                                        <option value="2">2 Rooms</option>
                                                        <option value="3">3 Rooms</option>
                                                        <option value="4">4 Rooms</option>
                                                        <option value="5">5 Rooms</option>
                                                        <option value="6">6 Rooms</option>
                                                        <option value="7">7 Rooms</option>
                                                        <option value="8">8 Rooms</option>
                                                        <option value="9">9 Rooms</option>
                                                        <option value="10">10 Rooms</option>
                                                        <option value="11">11 Rooms</option>
                                                        <option value="12">12 Rooms</option>
                                                        <option value="13">13 Rooms</option>
                                                        <option value="14">14 Rooms</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end sidebar-widget-item -->
                            <div class="sidebar-widget-item">
                                <div class="qty-box mb-2 d-flex align-items-center justify-content-between">
                                    <label class="font-size-16">Adults <span>Age 18+</span></label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="qtyInput" value="0">
                                    </div>
                                </div>
                                <!-- end qty-box -->
                                <div class="qty-box mb-2 d-flex align-items-center justify-content-between">
                                    <label class="font-size-16">Children <span>2-12 years old</span></label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="qtyInput" value="0">
                                    </div>
                                </div>
                                <!-- end qty-box -->
                                <div class="qty-box mb-2 d-flex align-items-center justify-content-between">
                                    <label class="font-size-16">Infants <span>0-2 years old</span></label>
                                    <div class="qtyBtn d-flex align-items-center">
                                        <input type="text" name="qtyInput" value="0">
                                    </div>
                                </div>
                                <!-- end qty-box -->
                            </div>
                            <!-- end sidebar-widget-item -->
                            <div class="btn-box pt-2">
                                <a href="tour-booking.html" class="theme-btn text-center w-100 mb-2"><i class="la la-shopping-cart mr-2 font-size-18"></i>Book Now</a>
                                <a href="#" class="theme-btn text-center w-100 theme-btn-transparent"><i class="la la-heart-o mr-2"></i>Add to Wishlist</a>
                                <div class="d-flex align-items-center justify-content-between pt-2">
                                    <a href="#" class="btn theme-btn-hover-gray font-size-15" data-toggle="modal" data-target="#sharePopupForm"><i class="la la-share mr-1"></i>Share</a>
                                    <p><i class="la la-eye mr-1 font-size-15 color-text-2"></i>3456</p>
                                </div>
                            </div>
                        </div>
                        <!-- end sidebar-widget -->
                        <div class="sidebar-widget single-content-widget">
                            <h3 class="title stroke-shape">Enquiry Form</h3>
                            <div class="enquiry-forum">
                                <div class="">
                                    <div class="form-content">
                                        <div class="contact-form-action">
                                            <form method="post">
                                                <div class="input-box">
                                                    <label class="label-text">Your Name</label>
                                                    <div class="form-group">
                                                        <span class="la la-user form-icon"></span>
                                                        <input class="form-control" type="text" name="text" placeholder="Your name">
                                                    </div>
                                                </div>
                                                <div class="input-box">
                                                    <label class="label-text">Your Email</label>
                                                    <div class="form-group">
                                                        <span class="la la-envelope-o form-icon"></span>
                                                        <input class="form-control" type="email" name="email" placeholder="Email address">
                                                    </div>
                                                </div>
                                                <div class="input-box">
                                                    <label class="label-text">Message</label>
                                                    <div class="form-group">
                                                        <span class="la la-pencil form-icon"></span>
                                                        <textarea class="message-control form-control" name="message" placeholder="Write message"></textarea>
                                                    </div>
                                                </div>
                                                <div class="input-box">
                                                    <div class="form-group">
                                                        <div class="custom-checkbox mb-0">
                                                            <input type="checkbox" id="agreeChb">
                                                            <label for="agreeChb">I agree with <a href="#">Terms of Service</a> and
                                                            <a href="#">Privacy Statement</a></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn-box">
                                                    <button type="button" class="theme-btn">Submit Enquiry</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end contact-form-action -->
                                    </div>
                                    <!-- end form-content -->
                                </div>
                                <!-- end form-box -->
                            </div>
                            <!-- end enquiry-forum -->
                        </div>
                        <!-- end sidebar-widget -->
                        <div class="sidebar-widget single-content-widget">
                            <h3 class="title stroke-shape">Why Book With Us?</h3>
                            <div class="sidebar-list">
                                <ul class="list-items">
                                    <li><i class="la la-dollar icon-element mr-2"></i>No-hassle best price guarantee</li>
                                    <li><i class="la la-microphone icon-element mr-2"></i>Customer care available 24/7</li>
                                    <li><i class="la la-thumbs-up icon-element mr-2"></i>Hand-picked Tours & Activities</li>
                                    <li><i class="la la-file-text icon-element mr-2"></i>Free Travel Insureance</li>
                                </ul>
                            </div>
                            <!-- end sidebar-list -->
                        </div>
                        <!-- end sidebar-widget -->

                        <div class="sidebar-widget single-content-widget">
                            <h3 class="title stroke-shape">Get a Question?</h3>
                            <p class="font-size-14 line-height-24">Do not hesitate to give us a call. We are an expert team and we are happy to talk to you.</p>
                            <div class="sidebar-list pt-3">
                                <ul class="list-items">
                                    <li><i class="la la-phone icon-element mr-2"></i><a href="#"><?=$module->hotel_phone?></a></li>
                                    <li><i class="la la-envelope icon-element mr-2"></i><a href="mailto:info@trizen.com">info@trizen.com</a></li>
                                </ul>
                            </div>
                            <!-- end sidebar-list -->
                        </div>
                        <!-- end sidebar-widget -->
                        <div class="sidebar-widget single-content-widget">
                            <h3 class="title stroke-shape">Organized by</h3>
                            <div class="author-content">
                                <div class="d-flex">
                                    <div class="author-img">
                                        <a href="#"><img src="images/team8.jpg" alt="testimonial image"></a>
                                    </div>
                                    <div class="author-bio">
                                        <h4 class="author__title"><a href="#">royaltravelagency</a></h4>
                                        <span class="author__meta">Member Since 2017</span>
                                        <span class="ratings d-flex align-items-center">
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star"></i>
                                        <i class="la la-star-o"></i>
                                        <span class="ml-2">305 Reviews</span>
                                        </span>
                                        <div class="btn-box pt-3">
                                            <a href="#" class="theme-btn theme-btn-small theme-btn-transparent">Ask a Question</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end sidebar-widget -->
                    </div>
                    <!-- end sidebar -->
                </div>
                <!-- end col-lg-4 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end single-content-box -->
</section>
<!-- end tour-detail-area -->




 <!-- end reviews -->
                     <div class="container">
                        <div class="review-box">
                            <div class="single-content-item padding-top-40px">
                                <h3 class="title font-size-20">Showing 3 guest reviews</h3>
                                <div class="comments-list padding-top-50px">
                                    <?php require $themeurl. 'views/includes/reviews_content.php';}?>
                                </div>
                                <?php
                                    if($appModule != "cars" && $appModule != "ean" && $appModule != "offers" && empty($tripadvisorinfo->rating)){ ?>
                                <!-- end comments-list -->
                                <div class="comment-forum padding-top-40px">
                                    <div class="form-box">
                                        <div class="form-title-wrap">
                                            <h3 class="title"><?php echo trans('083');?></h3>
                                        </div>
                                        <form class="form-horizontal row" method="POST" id="reviews-form-<?php echo $module->id;?>" action="" onsubmit="return false;">
                                            <div id="review_result<?php echo $module->id;?>" style="width:100%" >
                                            </div>
                                            <div class="alert resp" style="display:none"></div>
                                            <?php $mdCol = 12; if($appModule == "hotels"){ $mdCol = 8; ?>
                                            <div class="col-md-4 go-right">
                                                <div class="card-body">
                                                    <h3 class="text-center"><strong><?php echo trans('0389');?></strong>&nbsp;<span id="avgall_<?php echo $module->id; ?>"> 1</span> / 10</h3>
                                                    <div class="clear"></div>
                                                    <div class="row">
                                                        <div class="col-md-6 form-horizontal">
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo trans('030');?></label>
                                                                <div class="clear"></div>
                                                                <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_clean">
                                                                    <option value="1"> 1 </option>
                                                                    <option value="2"> 2 </option>
                                                                    <option value="3"> 3 </option>
                                                                    <option value="4"> 4 </option>
                                                                    <option value="5"> 5 </option>
                                                                    <option value="6"> 6 </option>
                                                                    <option value="7"> 7 </option>
                                                                    <option value="8"> 8 </option>
                                                                    <option value="9"> 9 </option>
                                                                    <option value="10"> 10 </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo trans('031');?></label>
                                                                <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_comfort">
                                                                    <option value="1"> 1 </option>
                                                                    <option value="2"> 2 </option>
                                                                    <option value="3"> 3 </option>
                                                                    <option value="4"> 4 </option>
                                                                    <option value="5"> 5 </option>
                                                                    <option value="6"> 6 </option>
                                                                    <option value="7"> 7 </option>
                                                                    <option value="8"> 8 </option>
                                                                    <option value="9"> 9 </option>
                                                                    <option value="10"> 10 </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo trans('032');?></label>
                                                                <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_location">
                                                                    <option value="1"> 1 </option>
                                                                    <option value="2"> 2 </option>
                                                                    <option value="3"> 3 </option>
                                                                    <option value="4"> 4 </option>
                                                                    <option value="5"> 5 </option>
                                                                    <option value="6"> 6 </option>
                                                                    <option value="7"> 7 </option>
                                                                    <option value="8"> 8 </option>
                                                                    <option value="9"> 9 </option>
                                                                    <option value="10"> 10 </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo trans('033');?></label>
                                                                <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_facilities">
                                                                    <option value="1"> 1 </option>
                                                                    <option value="2"> 2 </option>
                                                                    <option value="3"> 3 </option>
                                                                    <option value="4"> 4 </option>
                                                                    <option value="5"> 5 </option>
                                                                    <option value="6"> 6 </option>
                                                                    <option value="7"> 7 </option>
                                                                    <option value="8"> 8 </option>
                                                                    <option value="9"> 9 </option>
                                                                    <option value="10"> 10 </option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" id="loggedin" value="<?php echo $usersession;?>" />
                                                            <input type="hidden" id="itemid" value="<?php echo $module->id; ?>" />
                                                            <input type="hidden" id="module" value="<?php echo $appModule;?>" />
                                                            <input type="hidden" id="addtxt" value="<?php echo trans('029');?>" />
                                                            <input type="hidden" id="removetxt" value="<?php echo trans('028');?>" />
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo trans('034');?></label>
                                                                <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_staff">
                                                                    <option value="1"> 1 </option>
                                                                    <option value="2"> 2 </option>
                                                                    <option value="3"> 3 </option>
                                                                    <option value="4"> 4 </option>
                                                                    <option value="5"> 5 </option>
                                                                    <option value="6"> 6 </option>
                                                                    <option value="7"> 7 </option>
                                                                    <option value="8"> 8 </option>
                                                                    <option value="9"> 9 </option>
                                                                    <option value="10"> 10 </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-md-8">
                                                <div class="contact-form-action">
                                                    <div class="row card-body">
                                                        <div class="col-lg-6 responsive-column">
                                                            <div class="input-box">
                                                                <label class="label-text"><?php echo trans('0350');?></label>
                                                                <div class="form-group">
                                                                    <span class="la la-user form-icon"></span>
                                                                    <input class="form-control" type="text" name="fullname" placeholder="<?php echo trans('0390');?> <?php echo trans('0350');?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 responsive-column">
                                                            <div class="input-box">
                                                                <label class="label-text"><?php echo trans('094');?></label>
                                                                <div class="form-group">
                                                                    <span class="la la-envelope-o form-icon"></span>
                                                                    <input class="form-control" type="text" name="email" placeholder="<?php echo trans('0390');?> <?php echo trans('094');?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="input-box">
                                                                <label class="label-text"><?php echo trans('0391');?></label>
                                                                <div class="form-group">
                                                                    <span class="la la-pencil form-icon"></span>
                                                                    <textarea class="form-control" type="text" placeholder="<?php echo trans('0391');?>" name="reviews_comments" id="" cols="30" rows="10"></textarea>
                                                                </div>
                                                            </div>
                                                            <p class="text-danger"><strong><?php echo trans('0371');?></strong> : <?php echo trans('085');?></p>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="btn-box">
                                                                <button type="button" class="theme-btn addreview" id="<?php echo $module->id; ?>"><?php echo trans('086');?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="addreview" value="1" />
                                            <input type="hidden" name="overall" id="overall_<?php echo $module->id; ?>" value="1" />
                                            <input type="hidden" name="reviewmodule" value="<?php echo $appModule; ?>" />
                                            <input type="hidden" name="reviewfor" value="<?php echo $module->id; ?>" />

                                        </form>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- end single-content-wrap -->
                        </div>
                        </div>





<!-- ================================
    END TOUR DETAIL AREA
    ================================= -->
<div class="section-block"></div>
<?php if(!empty($module->relatedItems)){ ?>
<!-- ================================
    START RELATE TOUR AREA
    ================================= -->
<section class="related-tour-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2 class="sec__title"><?php if($appModule == "hotels" || $appModule == "ean"){ echo trans('0290'); }else if($appModule == "tours"){ echo trans('0453'); }else if($appModule == "cars"){ echo trans('0493'); } ?></h2>
                </div>
                <!-- end section-heading -->
            </div>
            <!-- end col-lg-12 -->
        </div>
        <!-- end row -->
        <div class="row padding-top-50px">
            <?php foreach($module->relatedItems as $item){ ?>
            <div class="col-lg-4 responsive-column">
                <div class="card-item">
                    <div class="card-img">
                        <a href="<?php echo $item->slug;?>" class="d-block">
                        <img src="<?php echo $item->thumbnail;?>" alt="hotel-img" style="height:230px">
                        </a>
                        <!--<span class="badge">Bestseller</span>-->
                        <!--<div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="Bookmark">
                            <i class="la la-heart-o"></i>
                        </div>-->
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,25);?></a></h3>
                        <p class="card-meta"><i class="la la-map-marker"></i> <?php echo character_limiter($item->location,20);?></p>
                        <div class="row">
                            <div class="card-rating col-6 pt-0">
                                <span class="badge text-white"><?php echo $item->stars;?></span>
                                <!--<span class="review__text">Average</span>
                                    <span class="rating__text">(30 Reviews)</span>-->
                            </div>
                            <div class="card-price d-flex justify-content-end col-6">
                                <?php if($item->price > 0){ ?>
                                <p>
                                    <span class="price__from"><?php echo trans( '0368');?></span>
                                    <span class="price__num"> <?php echo $item->currSymbol; ?><?php echo $item->price;?></span>
                                    <!--<span class="price__text">Per night</span>-->
                                </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card-item -->
            </div>
            <!-- end col-lg-4 -->
            <?php } ?>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end related-tour-area -->
<!-- ================================
    END RELATE TOUR AREA
    ================================= -->
<?php } ?>


<script>
$("[name^=rooms]").on('click', function() {
if ($('[name="rooms[]"]:checked').length > 0) {
$('[type=submit]').prop('disabled', false);
} else {
$('[type=submit]').prop('disabled', true);
}
});
</script>

<script>
    //------------------------------
    // Write Reviews
    //------------------------------
    $(function() {
            $('.reviewscore').change(function() {
                    var sum = 0;
                    var avg = 0;
                    var id = $(this).attr("id");
                    $('.reviewscore_' + id + ' :selected').each(function() {
                            sum += Number($(this).val());
                    });
                    avg = sum / 5;
                    $("#avgall_" + id).html(avg);
                    $("#overall_" + id).val(avg);
            });

            //submit review
            $(".addreview").on("click", function() {
                    var id = $(this).prop("id");
                    $.post("<?php echo base_url();?>admin/ajaxcalls/postreview", $("#reviews-form-" + id).serialize(), function(resp) {
                            var response = $.parseJSON(resp);
                            // alert(response.msg);
                            $("#review_result" + id).html("<div class='alert " + response.divclass + "'>" + response.msg + "</div>").fadeIn("slow");
                            if (response.divclass == "alert-success") {
                                    setTimeout(function() {
                                            $("#ADDREVIEW").removeClass('in');
                                            $("#ADDREVIEW").slideUp();
                                    }, 5000);
                            }
                    });
                    setTimeout(function() {
                            $("#review_result" + id).fadeOut("slow");
                    }, 3000);
            });
    })

    //------------------------------
    // Add to Wishlist
    //------------------------------
    $(function() {
            // Add/remove wishlist
            $(".wish").on('click', function() {
                    var loggedin = $("#loggedin").val();
                    var removelisttxt = $("#removetxt").val();
                    var addlisttxt = $("#addtxt").val();
                    var title = $("#itemid").val();
                    var module = $("#module").val();
                    if (loggedin > 0) {
                            if ($(this).hasClass('addwishlist')) {
                                    var confirm1 = confirm("<?php echo trans('0437');?>");
                                    if (confirm1) {
                                            $(".wish").removeClass('addwishlist btn-primary');
                                            $(".wish").addClass('removewishlist btn-warning');
                                            $(".wishtext").html(removelisttxt);
                                            $.post("<?php echo base_url();?>account/wishlist/add", {
                                                    loggedin: loggedin,
                                                    itemid: title,
                                                    module: module
                                            }, function(theResponse) {});
                                    }
                                    return false;
                            } else if ($(this).hasClass('removewishlist')) {
                                    var confirm2 = confirm("<?php echo trans('0436');?>");
                                    if (confirm2) {
                                            $(".wish").addClass('addwishlist btn-primary');
                                            $(".wish").removeClass('removewishlist btn-warning');
                                            $(".wishtext").html(addlisttxt);
                                            $.post("<?php echo base_url();?>account/wishlist/remove", {
                                                    loggedin: loggedin,
                                                    itemid: title,
                                                    module: module
                                            }, function(theResponse) {});
                                    }
                                    return false;
                            }
                    } else {
                            alert("<?php echo trans('0482');?>");
                    }
            });
            // End Add/remove wishlist
    })

    //------------------------------
    // Rooms
    //------------------------------

    $('.collapse').on('show.bs.collapse', function() {
            $('.collapse.in').collapse('hide');
    });
    <?php if($appModule == "hotels"){ ?>
            $('.showcalendar').on('change', function() {
                    var roomid = $(this).prop('id');
                    var monthdata = $(this).val();
                    $("#roomcalendar" + roomid).html("<br><br><div class='matrialprogress'><div class='indeterminate'></div></div>");
                    $.post("<?php echo base_url();?>hotels/roomcalendar", {
                            roomid: roomid,
                            monthyear: monthdata
                    }, function(theResponse) {
                            console.log(theResponse);
                            $("#roomcalendar" + roomid).html(theResponse);
                    });
            });

    <?php } ?>
</script>
