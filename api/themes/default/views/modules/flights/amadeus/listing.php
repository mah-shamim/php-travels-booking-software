<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
    <section class="page-wrapper bg-light-primary">
        <div class="container">
            <div class="row gap-20 gap-md-30 gap-xl-40">
                <div class="col-12 col-lg-3">
                    <aside class="sidebar-wrapper filter-wrapper mb-10 mb-md-0">
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
                                    <form name="fFilters" action="<?php echo base_url().$appModule;?>/search" method="GET" role="search">
                                        <div class="sidebar-box">
                                            <div class="box-title">
                                                <h5><?=lang('0603')?></h5>
                                            </div>
                                            <div class="box-content">
                                                <div class="custom-control custom-radio">
                                                    <div class="go-right">
                                                        <input class="custom-control-input" type="radio" id="1" name="priceOrder" value="">
                                                        <label class="custom-control-label go-left" for="1"><?=lang('0604')?></label>
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
                                            </div>
                                        </div>
                                        <div class="sidebar-box">
                                            <div class="box-title">
                                                <h5><?php echo trans('0605');?></h5>
                                            </div>
                                            <div class="box-content">
                                                <?php  foreach($sr->airlines as $index=>$item) { ?>
                                                <div class="go-right">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" data-val="<?=$item->name?>" value="<?=$item->name?>" name="airlines" id="check_<?=$index?>" class="custom-control-input" />
                                                        <label for="check_<?=$index?>" class="custom-control-label go-left"> <img height="20" width="20" class="go-right amenities" src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?=$item->thumbnail?>">  <span>  <?="  ".$item->name?></span></label>
                                                    </div>
                                                </div>
                                                <?php if($index == 4) {?>
                                                <div id="filerPropertyTypeShowHide" class="collapse">
                                                    <div class="collapse-inner">
                                                    </div>
                                                </div>
                                                <?php } }?>
                                                <div class="clear mb-5"></div>
                                                <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-on" type="buttom" data-toggle="collapse" data-target="#filerPropertyTypeShowHide"><?=lang('0185')?> (+)</span>
                                                <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-off" type="buttom" data-toggle="collapse" data-target="#filerPropertyTypeShowHide"><?=lang('067')?> (-)</span>
                                            </div>
                                        </div>
                                        <!-- End of airlines -->
                                        <div class="sidebar-box">
                                            <div class="box-content">
                                                <button type="submit" class="btn btn-primary btn-block" id="searchform"><?php echo trans('012');?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="d-block d-lg-none">
                            <button type="buttom" class="btn btn-toggle btn-outline-primary btn-block collapsed collapsed-disapear" data-toggle="collapse" data-target="#filterResultCallapseOnMobile"><?=lang('0191')?></button>
                        </div>
                    </aside>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="content-wrapper">
                        <div class="d-lg-flex mb-30 mb-lg-10">
                            <div>
                                <?php if (!empty(explode("/",uri_string())[3])) { ?>
                                <h3 class="heading-title"><span>LHE <span class="text-lowercase"> To</span> </span> <span class="text-primary">DXB</span></h3>
                                <?php } ?>
                                <p class="text-muted post-heading"><?= count($module) ?> <?=lang('0535')?></p>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
                            </div>
                        </div>
                        <div id="change-search" class="collapse">
                            <div class="change-search-wrapper">
                                <?php  echo searchForm($appModule,$search); ?>
                            </div>
                        </div>
                        <?php foreach ($sr->final_array  as $main_index=>$item) {  ?>
                        <div  class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                            <div class="theme-search-results-item-preview">
                                <a class="theme-search-results-item-mask-link" href="#searchResultsItem-<?=$main_index?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-<?=$main_index?>"></a>
                                <div class="row" data-gutter="20">
                                    <form action="" class="row" method="post" enctype="multipart/form-data">
                                        <?php foreach ($item["segments"]  as $index=>$segment) {  ?>
                                        <div class="col-md-10 ">
                                            <div class="theme-search-results-item-flight-sections">
                                                <div class="theme-search-results-item-flight-section">
                                                    <div class="row row-no-gutter row-eq-height">
                                                        <div class="col-md-2">
                                                            <div class="theme-search-results-item-flight-section-airline-logo-wrap" style="background: #f8f8f8; border-radius: 5px;">
                                                                <img class="theme-search-results-item-flight-section-airline-logo" src="<?=$segment[0]->img_code; ?>"alt="Image Alternative text" title="Image Title">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10 ">
                                                            <div class="theme-search-results-item-flight-section-item">
                                                                <div class="row">
                                                                    <div class="col-md-3 ">
                                                                        <div class="theme-search-results-item-flight-section-meta">
                                                                            <p class="theme-search-results-item-flight-section-meta-time"><?=$segment[0]->departure_time?>
                                                                            </p>
                                                                            <p class="theme-search-results-item-flight-section-meta-city"><?=$segment[0]->departure_airport?></p>
                                                                            <p class="theme-search-results-item-flight-section-meta-date"><?=$segment[0]->departure_date?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 ">
                                                                        <div class="theme-search-results-item-flight-section-path">
                                                                            <div class="theme-search-results-item-flight-section-path-fly-time">
                                                                                <p><?=lang('0560')?> <?=$segment[0]->duration_time?></p>
                                                                            </div>
                                                                            <div class="theme-search-results-item-flight-section-path-line"></div>
                                                                            <div class="theme-search-results-item-flight-section-path-line-start">
                                                                                <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                                                                <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                                                                <div class="theme-search-results-item-flight-section-path-line-title"><?=$segment[0]->departure_code?></div>
                                                                            </div>
                                                                            <div class="theme-search-results-item-flight-section-path-line-end">
                                                                                <i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                                                                <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                                                                <div class="theme-search-results-item-flight-section-path-line-title"><?=end($segment)->arrival_code?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 ">
                                                                        <div class="theme-search-results-item-flight-section-meta">
                                                                            <p class="theme-search-results-item-flight-section-meta-time"><?=end($segment)->arrival_time?></p>
                                                                            <p class="theme-search-results-item-flight-section-meta-city"><?=end($segment)->arrival_airport?></p>
                                                                            <p class="theme-search-results-item-flight-section-meta-date"><?=end($segment)->arrival_date?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 class="theme-search-results-item-flight-section-airline-title"><?=$segment[0]->airline_name?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($index == 0) { ?>
                                        <div class="col-md-2 ">
                                            <div class="theme-search-results-item-book">
                                                <div class="theme-search-results-item-price">
                                                    <p class="theme-search-results-item-price-tag"><?=$segment[0]->currency_code." ".$segment[0]->price?></p>
                                                    <p class="theme-search-results-item-price-sign"><?=$segment[0]->booking_class?></p>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block theme-search-results-item-price-btn" ><?=lang('0142')?></button>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                            <div class="collapse theme-search-results-item-collapse" id="searchResultsItem-<?=$main_index?>">
                                <div class="theme-search-results-item-extend">
                                    <a class="theme-search-results-item-extend-close" href="#searchResultsItem-<?=$main_index?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-<?=$main_index?>">&#10005;</a>
                                    <?php foreach ($item["segments"]  as $main_segments) {  ?>
                                    <?php foreach ($main_segments  as $segment_collapse) {  ?>
                                    <div class="theme-search-results-item-extend-inner">
                                        <div class="theme-search-results-item-flight-detail-items">
                                            <div class="theme-search-results-item-flight-details">
                                                <div class="row">
                                                    <div class="col-md-3 ">
                                                        <div class="theme-search-results-item-flight-details-info">
                                                            <h5 class="theme-search-results-item-flight-details-info-title"><?=lang('0472')?></h5>
                                                            <p class="theme-search-results-item-flight-details-info-date"><?=$segment_collapse->departure_date?></p>
                                                            <p class="theme-search-results-item-flight-details-info-cities"><?=$segment_collapse->departure_airport?></p>
                                                            <p class="theme-search-results-item-flight-details-info-fly-time"><?=$segment_collapse->departure_time?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 ">
                                                        <div class="theme-search-results-item-flight-details-schedule">
                                                            <ul class="theme-search-results-item-flight-details-schedule-list">
                                                                <li>
                                                                    <i class="fa fa-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                                                    <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                                                    <p class="theme-search-results-item-flight-details-schedule-date"><?=lang('0606')?> <?=$segment_collapse->departure_date?></p>
                                                                    <div class="theme-search-results-item-flight-details-schedule-time">
                                                                        <span class="theme-search-results-item-flight-details-schedule-time-item">
                                                                            <?=$segment_collapse->departure_time?>
                                                                            <!--<span>pm</span>-->
                                                                        </span>
                                                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">-</span>
                                                                        <span class="theme-search-results-item-flight-details-schedule-time-item">
                                                                            <?=$segment_collapse->arrival_time?>
                                                                            <!--<span>pm</span>-->
                                                                        </span>
                                                                    </div>
                                                                    <p class="theme-search-results-item-flight-details-schedule-fly-time"><?=lang('0560')?> <?=$segment_collapse->duration_time?></p>
                                                                    <div class="theme-search-results-item-flight-details-schedule-destination">
                                                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                                                <b><?=$segment_collapse->departure_code?></b> <?=$segment_collapse->departure_airport?>
                                                                            </p>
                                                                            <!--<p class="theme-search-results-item-flight-details-schedule-destination-city"></p>-->
                                                                        </div>
                                                                        <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                                                            <span>&#8594;</span>
                                                                        </div>
                                                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                                                <b><?=$segment_collapse->arrival_code?></b> <?=$segment_collapse->arrival_airport?>
                                                                            </p>
                                                                            <p class="theme-search-results-item-flight-details-schedule-destination-city"></p>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="theme-search-results-item-flight-details-schedule-features">
                                                                        <li><?=$segment_collapse->airline_name?></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
var fillter_array = [];
$("input:checkbox").change(function () {
if(this.checked)
{
fillter_array.push($(this).data('val'))
}else{
fillter_array.splice(fillter_array.indexOf($(this).data('val')),1)
}

});
</script>

<style>
form{width: 100%;}
</style>