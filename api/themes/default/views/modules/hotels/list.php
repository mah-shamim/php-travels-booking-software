<!-- ================================
    START BREADCRUMB AREA
    ================================= -->
<section class="breadcrumb-area bread-bg-7">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title_list">
                                <?php if (!empty(explode("/",uri_string())[3])) { ?> <?=lang('Hotels')?> <?= explode("/",uri_string())[3]; ?><?php } ?>
                            </h2>
                        </div>
                    </div>
                    <!-- end breadcrumb-content -->
                </div>
                <!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list">
                        <ul class="list-items d-flex justify-content-end">
                            <li><a href="#"><?= count($module) ?> <?=lang('0535')?></a></li>
                        </ul>
                    </div>
                    <!-- end breadcrumb-list -->
                </div>
                <!-- end col-lg-6 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end breadcrumb-wrap -->
    <div class="bread-svg-box">
        <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
            <polygon points="100 0 50 10 0 0 0 10 100 10"></polygon>
        </svg>
    </div>
    <!-- end bread-svg -->
</section>
<!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
    ================================= -->
<!-- ================================
    START CARD AREA
    ================================= -->
<section class="card-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="filter-wrap margin-bottom-30px">
                    <div class="filter-top d-flex align-items-center justify-content-between pb-4">
                        <div>
                           <!-- <h3 class="title font-size-24"></h3>
                            <p class="font-size-14"><span class="mr-1 pt-1">Book with confidence:</span>No hotel booking fees</p>
                        --></div>
                        <div class="d-flex align-items-center">
                            <!-- end btn-box -->
                        </div>
                    </div>
                    <!-- end filter-top -->
                    <div class="filter-bar d-flex align-items-center justify-content-between">
                        <div class="filter-bar-filter d-flex flex-wrap align-items-center">
                            <div class="filter-option">
                                <h3 class="title font-size-16"><?=lang('0136')?>:</h3>
                            </div>
                            <div class="filter-option">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn dropdown--btn" href="#" role="button" data-toggle="dropdown">
                                    <?=lang('070')?>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-wrap">
                                        <div class="dropdown-item">
                                            <div class="sidebar-review">
                                                <div class="sidebar-box">
                                                    <div class="">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" <?php if($sort == "1"){echo "checked";} ?> id="priceOrderDes" name="priceOrder" value="des">
                                                            <label class="custom-control-label" for="priceOrderDes"><?=lang('0599')?></label>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" <?php if($sort == "0"){echo "checked";} ?> id="priceOrderAsc" name="priceOrder" value="acs">
                                                            <label class="custom-control-label" for="priceOrderAsc"><?=lang('0600')?></label>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end dropdown-item -->
                                    </div>
                                    <!-- end dropdown-menu -->
                                </div>
                                <!-- end dropdown -->
                            </div>
                            <div class="filter-option">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn dropdown--btn" href="#" role="button" data-toggle="dropdown">
                                    Review Score
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-wrap">
                                        <div class="dropdown-item">
                                            <div class="checkbox-wrap">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="r1">
                                                    <label for="r1">
                                                    <span class="ratings d-flex align-items-center">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <span class="color-text-3 font-size-13 ml-1">(55.590)</span>
                                                    </span>
                                                    </label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="r2">
                                                    <label for="r2">
                                                    <span class="ratings d-flex align-items-center">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star-o"></i>
                                                    <span class="color-text-3 font-size-13 ml-1">(40.590)</span>
                                                    </span>
                                                    </label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="r3">
                                                    <label for="r3">
                                                    <span class="ratings d-flex align-items-center">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star-o"></i>
                                                    <i class="la la-star-o"></i>
                                                    <span class="color-text-3 font-size-13 ml-1">(23.590)</span>
                                                    </span>
                                                    </label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="r4">
                                                    <label for="r4">
                                                    <span class="ratings d-flex align-items-center">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star-o"></i>
                                                    <i class="la la-star-o"></i>
                                                    <i class="la la-star-o"></i>
                                                    <span class="color-text-3 font-size-13 ml-1">(12.590)</span>
                                                    </span>
                                                    </label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="r5">
                                                    <label for="r5">
                                                    <span class="ratings d-flex align-items-center">
                                                    <i class="la la-star"></i>
                                                    <i class="la la-star-o"></i>
                                                    <i class="la la-star-o"></i>
                                                    <i class="la la-star-o"></i>
                                                    <i class="la la-star-o"></i>
                                                    <span class="color-text-3 font-size-13 ml-1">(590)</span>
                                                    </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end dropdown-item -->
                                    </div>
                                    <!-- end dropdown-menu -->
                                </div>
                                <!-- end dropdown -->
                            </div>
                            <div class="filter-option">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn dropdown--btn" href="#" role="button" data-toggle="dropdown">
                                    Facilities
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-wrap">
                                        <div class="dropdown-item">
                                            <div class="checkbox-wrap">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb1">
                                                    <label for="catChb1">Pet Allowed</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb2">
                                                    <label for="catChb2">Groups Allowed</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb3">
                                                    <label for="catChb3">Tour Guides</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb4">
                                                    <label for="catChb4">Access for disabled</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb5">
                                                    <label for="catChb5">Room Service</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb6">
                                                    <label for="catChb6">Parking</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb7">
                                                    <label for="catChb7">Restaurant</label>
                                                </div>
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="catChb8">
                                                    <label for="catChb8">Pet friendly</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end dropdown-item -->
                                    </div>
                                    <!-- end dropdown-menu -->
                                </div>
                                <!-- end dropdown -->
                            </div>
                        </div>
                        <!-- end filter-bar-filter -->
                        <div class="">
                            <a href="#" class="theme-btn btn-toggle collapsed btn-change-search" data-toggle="modal" data-target="#modifyPopupForm"><i class="la la-sync"></i> <?=trans('0106');?> <?=trans('0379');?></a>

                            <!--<select class="select-contain-select">
                                <option value="1">Short by default</option>
                                <option value="2">Popular Hotel</option>
                                <option value="3">Price: low to high</option>
                                <option value="4">Price: high to low</option>
                                <option value="5">A to Z</option>
                            </select>-->
                        </div>
                        <!-- end select-contain -->
                    </div>
                    <!-- end filter-bar -->
                </div>
                <!-- end filter-wrap -->
            </div>
            <!-- end col-lg-12 -->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-4">
                <div class="sidebar mt-0">
                    <div class="sidebar-widget">
                        <h3 class="title stroke-shape"><?=lang('0191')?></h3>
                        <form onsubmit="submitForm(event)" name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
                            <div class="sidebar-widget">
                                <h3 class="title stroke-shape"><?php echo trans('0137');?> <?php echo trans('069');?></h3>
                                <div class="sidebar-review">
                                    <?php $star = '<span class="stars la la-star"></span>'; ?>
                                    <?php $stars = '<div class="stars la la-star-o"></div>'; ?>
                                    <div class="custom-control custom-radio">
                                        <div class=" custom-ratting">
                                            <input id="1" type="radio" name="stars" class="custom-control-input" value="1" <?php if($starsCount == "1"){echo "checked";}?>>
                                            <label class="custom-control-label " for="1">&nbsp; <?php echo $star; ?><?php for($i=1;$i<=4;$i++){ ?> <?php echo $stars; ?> <?php } ?>
                                            </label>
                                            <div class="clear"></div>
                                        </div>
                                        <div class=" custom-ratting">
                                            <input id="2" type="radio" name="stars" class="custom-control-input" value="2" <?php if($starsCount == "2"){echo "checked";}?>>
                                            <label class="custom-control-label" for="2">&nbsp; <?php for($i=1;$i<=2;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=3;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                            <div class="clear"></div>
                                        </div>
                                        <div class=" custom-ratting">
                                            <input id="3" type="radio" name="stars" class="custom-control-input" value="3" <?php if($starsCount == "3"){echo "checked";}?>>
                                            <label class="custom-control-label" for="3">&nbsp; <?php for($i=1;$i<=3;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=2;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                            <div class="clear"></div>
                                        </div>
                                        <div class=" custom-ratting">
                                            <input id="4" type="radio" name="stars" class="custom-control-input" value="4" <?php if($starsCount == "4"){echo "checked";}?>>
                                            <label class="custom-control-label" for="4">&nbsp; <?php for($i=1;$i<=4;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=1;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                            <div class="clear"></div>
                                        </div>
                                        <div class=" custom-ratting" >
                                            <input id="5" type="radio" name="stars" class="custom-control-input" value="5" <?php if($starsCount == "5"){echo "checked";}?>>
                                            <label class="custom-control-label" for="5">&nbsp; <?php for($i=1;$i<=5;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=0;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-widget">
                                <h3 class="title stroke-shape"><?php echo trans('0301');?></h3>
                                <div class="sidebar-price-range">
                                    <div class="main-search-input-item">
                                        <div class="price-slider-amount padding-bottom-20px">
                                            <label for="amount2" class="filter__label">Price:</label>
                                            <input type="text" id="amount2" class="amounts">
                                            <!-- <input id="price_range" name ='price' class="amounts" /> -->
                                        </div>
                                        <!-- end price-slider-amount -->
                                        <div id="slider-range2"></div>
                                        <!-- end slider-range -->
                                    </div>
                                    <!-- end main-search-input-item -->
                                    <!-- <div class="btn-box pt-4">
                                        <button onclick="getInputValue();" class="theme-btn theme-btn-small theme-btn-transparent" type="button"><?=trans('0641');?></button>
                                    </div> -->
                                </div>
                            </div>
                            <!-- end sidebar-widget -->
                            <?php if(!empty($amenities)){ ?>
                            <div class="sidebar-widget">
                                <h3 class="title stroke-shape"><?php echo trans('048');?></h3>
                                <div class="sidebar-review">
                                    <div class="sidebar-category">
                                        <?php $varAmt = explode('-', $famenities);
                                            if(empty($varAmt)){
                                                    $varAmt = array();
                                            }
                                            foreach($amenities as $index => $hamt){
                                                    if (in_array($hamt->name, $conceptFilters)) { continue; }
                                                    ?>
                                        <?php if ($index==4)  {   ?>
                                        <div id="facilitiesMenu" class="collapse">
                                            <div class="collapse-inner">
                                                <?php  }  ?>
                                                <div>
                                                    <div class="custom-checkbox">
                                                        <input type="checkbox" value="<?php echo $hamt->id;?>" <?php if(in_array($hamt->id,$varAmt)){echo "checked";}?> name="amenities[]" id="<?php echo $hamt->name;?>" class="custom-control-input" />
                                                        <label for="<?php echo $hamt->name;?>" class="custom-control-label"> <img height="25" width="25" class="go-right amenities" src="<?php echo $hamt->icon;?>">  <span style="transform: translateY(-6px); display: inline-block;"><?php echo $hamt->name;?></span></label>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php if (count($amenities)>4 )   { ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <a class="btn-text" data-toggle="collapse" href="#facilitiesMenu" role="button" aria-expanded="false" aria-controls="facilitiesMenu">
                                        <span class="show-more"><?=lang('0185')?> <i class="la la-angle-down"></i></span>
                                        <span class="show-less"><?=lang('067')?> <i class="la la-angle-up"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="sidebar-widget">
                                <h3 class="title stroke-shape"><?php echo trans('0478'); ?></h3>
                                <div class="sidebar-review">
                                    <div class="sidebar-box">
                                        <?php $vartype = explode('-', $fpropertyTypes);
                                            if(empty($vartype)){ $vartype = array(); }
                                            foreach($moduleTypes as $mtype){ if(!empty($mtype->name)){ ?>
                                        <div>
                                            <div class="custom-checkbox">
                                                <input type="checkbox" value="<?php echo $mtype->id;?>" <?php if(in_array($mtype->id,$vartype)){echo "checked";}?> name="type[]" id="<?php echo $mtype->name;?>" class="custom-control-input" />
                                                <label for="<?php echo $mtype->name;?>" class="custom-control-label">&nbsp;&nbsp;<?php echo $mtype->name;?></label>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <?php }} ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="txtSearch" value="<?php echo @$_GET['txtSearch']; ?>">
                            <input type="hidden" name="searching" value="<?php echo @$_GET['searching']; ?>">
                            <input type="hidden" name="modType" value="<?php echo @$_GET['modType']; ?>">
                            <div class="sidebar-box">
                                <div class="box-content">
                                    <button  type="submit" class="btn btn-primary btn-lg btn-block" id="searchform"><?php echo trans('012');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end sidebar-widget -->
                </div>
                <!-- end sidebar -->
            </div>
            <!-- end col-lg-4 -->
            <div class="col-lg-8">
                <?php if(!empty($module)){ ?>
                <?php foreach($module as $item){ $hotel_title = ($item->trans_title)?$item->trans_title:$item->hotel_title; $hotel_desc = ($item->trans_desc)?$item->trans_desc:$item->hotel_desc; $city = (isset($item->location_trans) && $item->location_trans != 'NULL')?$item->location_trans:$city; ?>
                <div class="card-item card-item-list">
                    <div class="card-img">
                        <a href="<?php echo sprintf($detailpage_uri, strtolower($city), strtolower($item->hotel_slug)); ?>" class="d-block">
                        <img src="<?php echo base_url('uploads/images/hotels/slider/thumbs/'.$item->thumbnail_image);?>" alt="hotel-img">
                        </a>
                        <?php if(!empty($item->discount)){?><span class="badge"><?=$item->discount?> % <?=lang('0118')?></span><?php } ?>
                        <!--<div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="Bookmark">
                            <i class="la la-heart-o"></i>
                            </div>-->
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php echo sprintf($detailpage_uri, strtolower($city), strtolower($item->hotel_slug)); ?>"><?php echo character_limiter($hotel_title,20);?></a></h3>
                        <p class="card-meta"><i class="la la-map-marker"></i> <?php echo $city;?></p>
                        <!--<p class="card-meta"><?php echo character_limiter($hotel_desc,150);?></p>-->
                        <?php if($appModule != "offers"){ ?>
                        <a class="ellipsisFIX go-text-right mob-fs14" href="javascript:void(0);" onclick="showMap('<?php echo base_url();?>home/maps/<?php echo $item->hotel_latitude; ?>/<?php echo $item->hotel_longitude; ?>/<?php echo $appModule; ?>/<?php echo $item->hotel_id;?>','modal');" title="<?php echo $city;?>">
                            <!--MAP-->
                        </a>
                        <?php for($i=0;$i<5;$i++):  if($i < $item->hotel_stars):  ?>
                        <span class="la la-star stars"></span>
                        <?php else: ?>
                        <div class="la la-star-o stars"></div>
                        <?php endif; endfor; } ?>
                        <?php  if($item->avg_review > 0){ ?>
                        <div class="card-rating pt-0 pb-0">
                            <span class="badge text-white"><?=number_format($item->avg_review, 2, '.', '')?></span>
                            <span class="review__text"><?=lang('0208')?></span>
                            <span class="rating__text"><?=floor(($item->reviews_count/2))?> <?=lang('042')?></span>
                        </div>
                        <?php } ?>
                        <ul class="list-icon-absolute list-inline-block">
                            <?php
                                $cnt = 0;
                                if(!empty($amenities = json_decode($item->h_amenities))){
                                foreach($amenities as $amenity){
                                $name = ($amenity->trans_name)?$amenity->trans_name:$amenity->sett_name;
                                $cnt++;
                                if($cnt <= 10){
                                ?>
                            <img title="<?=$name?>" data-toggle="tooltip" data-placement="top" style="height:20px;" src="<?=base_url('uploads/images/hotels/amenities/'.$amenity->sett_img)?>" alt="<?=$name?>" />
                            <?php } } } ?>
                        </ul>
                        <div class="card-price d-flex align-items-end justify-content-end">
                            <?php  if($item->price > 0){ ?>
                            <p class="float-right">
                                <span class="price__from"><?=lang('0218')?> <?=lang('0273')?></span>
                                <span class="price__num"><?php echo $currSign; ?><?php echo currencyConverter($item->price);?></span>
                                <span class="price__text"><?=lang('0245')?></span>
                            </p>
                            <?php } ?>
                            <!--<a href="<?php echo sprintf($detailpage_uri, strtolower($city), strtolower($item->hotel_slug)); ?>" class="btn-text"><?php echo trans('0177');?><i class="la la-angle-right"></i></a>-->
                        </div>
                    </div>
                </div>
                <!-- end card-item -->
                <?php } ?>
                <div class="mt-10 mt-md-0">
                <ul class="social-profile d-flex justify-content-center">
                    <?php echo $pagination; ?>
                </ul>
                </div>
                <?php }else{  echo '<h2 class="text-center">' . trans("066") . '</h2>'; } ?>
            </div>
            <!-- end col-lg-8 -->
        </div>

    </div>
    <!-- end container -->
</section>
<!-- end card-area -->
<!-- ================================
    END CARD AREA
    ================================= -->
<div class="clearfix"></div>
<!-- end modal-shared -->
<div class="modal-popup">
    <div class="modal fade" id="modifyPopupForm" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:80%">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title title" id="exampleModalLongTitle3"><?=trans('0106');?> <?=trans('0379');?></h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo searchForm($appModule,$searchFormhotels); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal-popup -->

<script>
    app.controller('HOTELS', function($scope) {
    function hotels(){

    .then((data)=>{
    $scope.hotels = data.data.response;
    console.log(data.data.response);
    return data.data.response
    });
    }
    })
</script>