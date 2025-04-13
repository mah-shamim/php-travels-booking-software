<style>
.form-search-main-01 label{position:static}
.form-icon-left .icon-font{top:0}
.form-icon-left .form-control{padding-left:40px}
.typeahead__container{top:8px}
.form-search-main-01 button[type="submit"]{top:3px}
</style>
<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container tour-listing">
    <section class="page-wrapper bg-light-primary">
        <div class="container">
            <section class="bg-light-primary" style="padding:0px">
                <div class="container">
                    <div id="change-search" class="collapse">
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
                    <div class="row gap-20 gap-md-30 gap-xl-40">
                        <!--<div class="col-12 col-lg-3">
                            <aside class="sidebar-wrapper filter-wrapper mb-10 mb-md-0">
                                <form name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
                                    <div class="box-expand-lg">
                                        <div id="filterResultCallapseOnMobile" class="collapse box-collapse">
                                            <div class="wrapper-inner">
                                                <div class="sidebar-title bg-primary">
                                                    <div class="d-flex align-items-end">
                                                        <div>
                                                            <h4 class="text-white font-serif font400"><?=lang('0191')?></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sidebar-box">
                                                    <div class="box-title">
                                                        <h5><?php echo trans('0137');?> <?php echo trans('069');?></h5>
                                                    </div>
                                                    <div class="box-content">
                                                        <div class="rating-item rating-sm rating-inline">
                                                            <div class="rating-icons">
                                                                <?php $star = '<span class="rating-icon fas fa-star rating-rated"></span>'; ?>
                                                                <?php $stars = '<div class="rating-symbol-background rating-icon far fa-star"></div>'; ?>
                                                                <div class="custom-control custom-radio">
                                                                    <div class="go-right" style="margin-bottom:5px">
                                                                        <input id="1" type="radio" name="stars" class="custom-control-input go-right" value="1" <?php if($starsCount == "1"){echo "checked";}?>>
                                                                        <label class="custom-control-label go-left" for="1">&nbsp; <?php echo $star; ?><?php for($i=1;$i<=4;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                                                    </div>
                                                                    <div class="go-right" style="margin-bottom:5px">
                                                                        <input id="2" type="radio" name="stars" class="custom-control-input go-right" value="2" <?php if($starsCount == "2"){echo "checked";}?>>
                                                                        <label class="custom-control-label go-left" for="2">&nbsp; <?php for($i=1;$i<=2;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=3;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                                                    </div>
                                                                    <div class="go-right" style="margin-bottom:5px">
                                                                        <input id="3" type="radio" name="stars" class="custom-control-input" value="3" <?php if($starsCount == "3"){echo "checked";}?>>
                                                                        <label class="custom-control-label go-left" for="3">&nbsp; <?php for($i=1;$i<=3;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=2;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                                                    </div>
                                                                    <div class="go-right" style="margin-bottom:5px">
                                                                        <input id="4" type="radio" name="stars" class="custom-control-input" value="4" <?php if($starsCount == "4"){echo "checked";}?>>
                                                                        <label class="custom-control-label go-left" for="4">&nbsp; <?php for($i=1;$i<=4;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=1;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                                                    </div>
                                                                    <div class="go-right" style="margin-bottom:5px">
                                                                        <input id="5" type="radio" name="stars" class="custom-control-input" value="5" <?php if($starsCount == "5"){echo "checked";}?>>
                                                                        <label class="custom-control-label go-left" for="5">&nbsp; <?php for($i=1;$i<=5;$i++){ ?> <?php echo $star; ?> <?php } ?><?php for($i=1;$i<=0;$i++){ ?> <?php echo $stars; ?> <?php } ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sidebar-box">
                                                    <div class="box-title">
                                                        <h5><?php echo trans('0301');?></h5>
                                                    </div>
                                                    <div class="box-content">
                                                        <input id="price_range" />
                                                        <?php if(!empty($priceRange)){
                                                            $selectedprice = str_replace('-',',', $priceRange);
                                                        }else{
                                                            $selectedprice =  $minprice.",".$maxprice;
                                                        }?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="txtSearch" value="<?php echo @$_GET['txtSearch']; ?>">
                                                <input type="hidden" name="searching" value="<?php echo @$_GET['searching']; ?>">
                                                <input type="hidden" name="modType" value="<?php echo @$_GET['modType']; ?>">
                                                <div class="sidebar-box">
                                                    <div class="box-content">
                                                        <button type="submit" class="btn btn-primary btn-block" id="searchform"><?php echo trans('012');?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </aside>
                        </div>-->

                        <div class="col-12 col-lg-12" style="margin-top:-25px;">
                            <div class="content-wrapper">
                                <div class="d-lg-flex mb-10 row-reverse">
                                    <div>
                                        <?php if (!empty(explode("/",uri_string())[3])) { ?>
                                            <h3 class="heading-title float-none"><span><?=lang('Tours')?> <span class="text-lowercase"></span> </span> <span class="text-primary"><?= explode("/",uri_string())[3]; ?></span></h3>
                                        <?php } ?>
                                        <p class="text-muted post-heading"><?= count($results->data) ?> <?=lang('0535')?></p>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
                                    </div>
                                </div>
                                <div class="product-long-item-wrapper">
                                    <?php if(!empty($results->data)){ ?>
                                        <?php foreach($results->data as $item){ ?>

                                            <div class="product-long-item">
                                                <form action="<?php echo base_url()?>packages/detail/<?php echo  $item->data->productUrlName;?>" method="post" role="search">
                                                    <div class="row equal-height shrink-auto-md gap-15">
                                                        <div class="col-12 col-shrink">
                                                            <div class="image">
                                                                <img src="<?php echo $item->data->thumbnailHiResURL;?>" alt="<?php echo character_limiter($item->title,50);?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-auto">
                                                            <div class="col-inner d-flex flex-column">
                                                                <div class="content-top">
                                                                    <div class="d-flex">
                                                                        <div>
                                                                            <div class="rating-item rating-sm rating-inline">
                                                                                <div class="rating-icons">
                                                                                    <?php $stars_count = $item->data->rating;
                                                                                    if(!empty($stars_count)){
                                                                                    for ($i=4; $i >= 0 ; $i--) {
                                                                                        if ($stars_count > 0){
                                                                                            $stars_count--;
                                                                                            ?>
                                                                                            <i class="rating-icon fa fa-star"></i>
                                                                                        <?php }
                                                                                        else {?>
                                                                                            <i class="rating-symbol-background rating-icon far fa-star "></i>
                                                                                        <?php }
                                                                                    }
                                                                                    }?>

                                                                                </div>
                                                                            </div>
                                                                            <!--In href need to add next api lind to show product details-->
                                                                            <h5><a href="" class="code"><?php echo character_limiter($item->data->title,70);?></a></h5>
                                                                            <p class="location"><i class="fas fa-map-marker-alt "></i><a  href=""><?php echo character_limiter($item->data->primaryDestinationName,50);?></a></p>
                                                                        </div>
                                                                        <?php  if($item->data->price > 0){ ?>
                                                                            <div class="ml-auto">
                                                                                <div class="price">
                                                                                    <?=lang('0218')?> <?=lang('0273')?>
                                                                                    <span class="text-secondary"><?php echo $item->data->priceFormatted; ?></span>
                                                                                    <?=lang('0367')?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <?php echo strip_tags(character_limiter($item->data->shortDescription,450));?>
                                                                </div>
                                                                <div class="content-bottom mt-auto">
                                                                    <div class="d-flex align-items-center">
                                                                        <div>
                                                                            <p><i class="far"></i><strong><?php echo trans('0560');?>: <?php echo $item->data->duration;?></strong></p>
                                                                        </div>
                                                                        <div class="ml-auto">
                                                                            <input type="hidden" name="code" id="code" value="<?php echo $item->data->code ?>">
                                                                            <input type="hidden" name="image_thumb" id="image_thumb" value="<?php echo $item->data->thumbnailHiResURL ?>">
                                                                            <button type="submit" class="btn btn-primary btn-sm btn-wide"><?php echo trans('012');?></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </form>
                                            </div>
                                            <!--End of Foreach loop-->
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--End Row-->
                    </div>
                    <!--End Container-->
                </div>
                <!--End Section-->
            </section>
        </div>