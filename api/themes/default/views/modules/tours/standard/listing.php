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
                                 <?=lang('Tours')?> <?php echo $ToursSearchForm->from_code; ?>
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
                            <!--<li>Hotel</li>
                            <li>Hotel List</li>-->
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
                            <!--<div class="btn-box">
                            </div>-->
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
                        <!--
                            <select class="select-contain-select">
                                <option value="1">Short by default</option>
                                <option value="2">Popular Hotel</option>
                                <option value="3">Price: low to high</option>
                                <option value="4">Price: high to low</option>
                                <option value="5">A to Z</option>
                            </select>
                            -->
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
                        <form name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
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
                                            <input id="price_range" name = 'price' class="amounts" />
                                        </div>
                                        <!-- end price-slider-amount -->
                                        <div id="slider-range2"></div>
                                        <!-- end slider-range -->
                                    </div>
                                    <!-- end main-search-input-item -->
                                    <div class="btn-box pt-4">
                                        <button class="theme-btn theme-btn-small theme-btn-transparent" type="button"><?=trans('0641');?></button>
                                    </div>
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
                        <a href="<?php echo $item->slug;?>" class="d-block">
                        <img src="<?php echo $item->thumbnail;?>" alt="hotel-img">
                        </a>
                        <?php if(!empty($item->discount)){?><span class="badge"><?=$item->discount?> % <?=lang('0118')?></span><?php } ?>
                        <!--<div class="add-to-wishlist icon-element" data-toggle="tooltip" data-placement="top" title="Bookmark">
                            <i class="la la-heart-o"></i>
                            </div>-->
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><a href="<?php echo $item->slug;?>"><?php echo character_limiter($item->title,30);?></a></h3>
                        <p class="card-meta"><i class="la la-map-marker"></i> <?php echo $item->location;?></p>
                        <p class="card-meta"><?php echo character_limiter($item->desc,120);?></p>
                        <p><i class="far"></i><?php echo trans('0222');?>: <b><?php echo character_limiter($item->tourType,5); ?></b> <?php echo trans('0275');?>: <strong><?php echo $item->tourDays;?></strong>  <?php echo trans('0276');?>: <strong><?php echo $item->tourNights;?></strong></p>

                        <?php if($appModule != "offers"){ ?>
                        <a class="ellipsisFIX go-text-right mob-fs14" href="javascript:void(0);" onclick="showMap('<?php echo base_url();?>home/maps/<?php echo $item->hotel_latitude; ?>/<?php echo $item->hotel_longitude; ?>/<?php echo $appModule; ?>/<?php echo $item->hotel_id;?>','modal');" title="<?php echo $city;?>">
                            <!--MAP-->
                        </a>
                        <!--<?php for($i=0;$i<5;$i++):  if($i < $item->star):  ?>
                        <span class="la la-star stars"></span>
                        <?php else: ?>
                        <div class="la la-star-o stars"></div>
                        <?php endif; endfor; } ?>-->
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
                   <?php echo createPagination($info);?>
                </ul>
                </div>
                <?php }else{  echo '<h2 class="text-center">' . trans("066") . '</h2>'; } ?>

            </div>
            <!-- end col-lg-8 -->
        </div>
        <!-- end row -->
        <!-- end row -->
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
                    <?php echo searchForm($appModule, $data); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal-popup -->
<div class="col-md-3 hidden-sm hidden-xs filter">
    <script>
        var starRating=document.getElementsByClassName('custom-stars');var starInput=document.querySelectorAll('.custom-control-input');var customRating=starRating[0].querySelectorAll('.custom-ratting');for(var i=0;i<starInput.length;i++){starInput[i].addEventListener('change',function(){if(this.checked==!0){customRating[i].classList.add('checked')}else{customRating[i].classList.remove('checked')}})};
        $("form[name=fFilters]").on("submit",function(e){e.preventDefault();var uri='<?=$uri?>';var stars=$("input[name='stars']:checked").val()||0;var price=$("input[name=price]").val();var propertyTypes=$('.icheckbox_square-grey.checked input[name^="type"]').map(function(){return this.value}).get();var amenities=$('.icheckbox_square-grey.checked input[name^="amenities"]').map(function(){return this.value}).get();price=price.replace(';','-')||0;propertyTypes=propertyTypes.join("-")||0;amenities=amenities.join("-")||0;var redirect_url=uri+"/"+stars+"/"+price+"/"+propertyTypes+"/"+amenities;window.location.href=redirect_url});
    </script>
</div>
<!-- END OF CONTENT -->

<!-- End container -->
<script>
// Sorting according to prices.
$("[name^=priceOrder]").click(function(){var order=$(this).val();if(order=='des'){var sort=1}else{var sort=0}
var uri='<?=$uri?>';var stars=0;var price=$("input[name=price]").val();var propertyTypes=$('.icheckbox_square-grey.checked input[name^="type"]').map(function(){return this.value}).get();var amenities=$('.icheckbox_square-grey.checked input[name^="amenities"]').map(function(){return this.value}).get();price=price.replace(';','-')||0;propertyTypes=propertyTypes.join("-")||0;amenities=amenities.join("-")||0;var redirect_url=uri+"/"+stars+"/"+price+"/"+propertyTypes+"/"+amenities+"/"+sort;window.location.href=redirect_url});
</script>





<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div  class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo trans('0254');?></h4>
      </div>
      <div class="mapContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-block btn-lg pfb0" data-dismiss="modal"><?php echo trans('0234');?></button>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<script>
  <?php if($appModule == "cars"){ ?>
  $(function(){
    $(".saveDates").on("click",function(){
      var pickup = $("#departcar").val();
      var drop = $("#returncar").val();
      var htmlvar = pickup+' - '+drop;
      $(".datesModal").html(htmlvar);
    });
  })
  
  <?php } ?>
  
  $('#collapseMap').on('shown.bs.collapse', function(e){
  (function(A) {
  
  if (!Array.prototype.forEach)
   A.forEach = A.forEach || function(action, that) {
     for (var i = 0, l = this.length; i < l; i++)
       if (i in this)
         action.call(that, this[i], i, this);
     };
  
   })(Array.prototype);
  
   var
   mapObject,
   markers = [],
   markersData = {
  
     'map-red': [
      <?php foreach($module as $item): ?>
     {
       name: 'hotel name',
       location_latitude: "<?php echo $item->latitude;?>",
       location_longitude: "<?php echo $item->longitude;?>",
       map_image_url: "<?php echo $item->thumbnail;?>",
       name_point: "<?php echo $item->title;?>",
       description_point: "<?php echo character_limiter(strip_tags(trim($item->desc)),75);?>",
       url_point: "<?php echo $item->slug;?>"
     },
      <?php endforeach; ?>
  
     ],
  
   };
     var mapOptions = {
        <?php if(empty($_GET)){ ?>
       zoom: 10,
        <?php }else{ ?>
         zoom: 12,
        <?php } ?>
       center: new google.maps.LatLng(<?php echo $item->latitude;?>, <?php echo $item->longitude;?>),
       mapTypeId: google.maps.MapTypeId.ROADMAP,
  
       mapTypeControl: false,
       mapTypeControlOptions: {
         style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
         position: google.maps.ControlPosition.LEFT_CENTER
       },
       panControl: false,
       panControlOptions: {
         position: google.maps.ControlPosition.TOP_RIGHT
       },
       zoomControl: true,
       zoomControlOptions: {
         style: google.maps.ZoomControlStyle.LARGE,
         position: google.maps.ControlPosition.TOP_RIGHT
       },
       scrollwheel: false,
       scaleControl: false,
       scaleControlOptions: {
         position: google.maps.ControlPosition.TOP_LEFT
       },
       streetViewControl: true,
       streetViewControlOptions: {
         position: google.maps.ControlPosition.LEFT_TOP
       },
       styles: [/*map styles*/]
     };
     var
     marker;
     mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
     for (var key in markersData)
       markersData[key].forEach(function (item) {
         marker = new google.maps.Marker({
           position: new google.maps.LatLng(item.location_latitude, item.location_longitude),
           map: mapObject,
           icon: '<?php echo base_url(); ?>assets/img/' + key + '.png',
         });
  
         if ('undefined' === typeof markers[key])
           markers[key] = [];
         markers[key].push(marker);
         google.maps.event.addListener(marker, 'click', (function () {
       closeInfoBox();
       getInfoBox(item).open(mapObject, this);
       mapObject.setCenter(new google.maps.LatLng(item.location_latitude, item.location_longitude));
      }));
  
  });
  
   function hideAllMarkers () {
     for (var key in markers)
       markers[key].forEach(function (marker) {
         marker.setMap(null);
       });
   };
  
   function closeInfoBox() {
     $('div.infoBox').remove();
   };
  
   function getInfoBox(item) {
     return new InfoBox({
       content:
       '<div class="marker_info" id="marker_info">' +
       '<img style="width:280px;height:140px" src="' + item.map_image_url + '" alt=""/>' +
       '<h3>'+ item.name_point +'</h3>' +
       '<span>'+ item.description_point +'</span>' +
       '<a href="'+ item.url_point + '" class="btn btn-primary"><?php echo trans('0177');?></a>' +
       '</div>',
       disableAutoPan: true,
       maxWidth: 0,
       pixelOffset: new google.maps.Size(40, -190),
       closeBoxMargin: '0px -20px 2px 2px',
       closeBoxURL: "<?php echo $theme_url; ?>assets/img/close.png",
       isHidden: false,
       pane: 'floatPane',
       enableEventPropagation: true
     }); };  });
</script>