<!-- ================================
    START BREADCRUMB AREA
    ================================= -->
<section class="breadcrumb-area bread-bg-6">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title_list"><?= $search->origin ?> <i class="las la-arrow-right"></i> <?= $search->destination ?></h2>
                        </div>
                    </div>
                    <!-- end breadcrumb-content -->
                </div>
                <!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list">
                        <!--<ul class="list-items d-flex justify-content-end">
                            <li><a href="index.html">Home</a></li>
                            <li>Flight</li>
                            <li>Flight List</li>
                            </ul>-->
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
<!-- start Main Wrapper -->
<?php if ($search->listing_type == "iframe") {
    echo $search->listing_source;
    } else { ?>
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
                            <h3 class="title font-size-24"><?php if(!empty($sr)){ echo count($sr);}else{echo 0;} ?> <?= lang('0535') ?></h3>
                            <p class="font-size-14"><span class="mr-1 pt-1">Book with confidence:</span>No flight booking fees</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary btn-toggle collapsed btn-change-search" data-toggle="collapse" data-target="#change-search"><?= lang('0106') ?> <?= lang('012') ?></button>
                            <!-- <a href="flight-grid.html" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="la la-th-large"></i></a>
                                <a href="flight-list.html" data-toggle="tooltip" data-placement="top" title="List View" class="active"><i class="la la-th-list"></i></a>
                                -->
                        </div>
                    </div>
                    <!-- end filter-top -->
                    <div id="change-search" class="collapse mt-0 mb-4" style="background: #e4e9ed; padding: 15px; border-radius: 6px">
                        <div class="change-search-wrapper">
                            <?php echo Search_Form($appModule, "flights"); ?>
                        </div>
                    </div>
                    <!--<div class="filter-bar d-flex align-items-center justify-content-between">
                        <div class="filter-bar-filter d-flex flex-wrap align-items-center">
                                <div class="filter-option">
                                        <h3 class="title font-size-16">Filter by:</h3>
                                </div>
                                <div class="filter-option">
                                        <div class="dropdown dropdown-contain">
                                                <a class="dropdown-toggle dropdown-btn dropdown--btn" href="#" role="button" data-toggle="dropdown">
                                                        Filter Price
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-wrap">
                                                        <div class="dropdown-item">
                                                                <div class="slider-range-wrap">
                                                                        <div class="price-slider-amount padding-bottom-20px">
                                                                                <label for="amount" class="filter__label">Price:</label>
                                                                                <input type="text" id="amount" class="amounts">
                                                                        </div>
                                                                        <div id="slider-range"></div>
                                                                </div>
                                                                <div class="btn-box pt-4">
                                                                        <button class="theme-btn theme-btn-small theme-btn-transparent" type="button">Apply</button>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
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
                                                </div>
                                        </div>
                                </div>

                                <div class="filter-option">
                                        <div class="dropdown dropdown-contain">
                                                <a class="dropdown-toggle dropdown-btn dropdown--btn" href="#" role="button" data-toggle="dropdown">
                                                        Airlines
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-wrap">
                                                        <div class="dropdown-item">
                                                                <div class="checkbox-wrap">
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb1">
                                                                                <label for="catChb1">Major Airlines</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb2">
                                                                                <label for="catChb2">United Airlines</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb3">
                                                                                <label for="catChb3">Delta Airlines</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb4">
                                                                                <label for="catChb4">Alitalia</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb5">
                                                                                <label for="catChb5">US Airways</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb6">
                                                                                <label for="catChb6">Air France</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb7">
                                                                                <label for="catChb7">Air Tahiti Nui</label>
                                                                        </div>
                                                                        <div class="custom-checkbox">
                                                                                <input type="checkbox" id="catChb8">
                                                                                <label for="catChb8">Indigo</label>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <div class="select-contain">
                                <select class="select-contain-select">
                                        <option value="1">Short by default</option>
                                        <option value="2">Popular Flight</option>
                                        <option value="3">Price: low to high</option>
                                        <option value="4">Price: high to low</option>
                                        <option value="5">A to Z</option>
                                </select>
                        </div>
                        </div>-->
                </div>
                <!-- end filter-wrap -->
            </div>
            <!-- end col-lg-12 -->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-3">
                <div class="sidebar mt-0">
                    <div class="sidebar-widget">
                        <h3 class="title stroke-shape"><?= lang('0191') ?></h3>
                        <div class="sidebar-widget-item">
                            <div class="contact-form-action">
                                <form name="fFilters" action="<?php echo base_url() . $appModule; ?>/search"
                                    method="GET" role="search">
                                    <div class="sidebar-box">
                                        <div class="box-title">
                                            <h5><?= lang('0603') ?></h5>
                                        </div>
                                        <div class="box-content">
                                            <div id="group_main" class="custom-control custom-radio">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sidebar-box">
                                        <div class="box-title">
                                            <h5><?php echo trans('0301'); ?></h5>
                                        </div>
                                        <div class="box-content">
                                            <input class="js-range-slider"/>
                                        </div>
                                    </div>
                                    <div class="sidebar-box">
                                        <div class="box-title">
                                            <h5><?php echo trans('0605'); ?></h5>
                                        </div>
                                        <div class="box-content">
                                            <?php foreach ($sr->airlines as $index => $item) { ?>
                                            <div class="go-right">
                                                <div class="custom-control custom-checkbox"
                                                    onclick="topFunction()" id="myBtn">
                                                    <input type="checkbox"
                                                        data-val="<?= str_replace(" ", "", $item->name) ?>"
                                                        value="<?= $item->name ?>" name="airlines"
                                                        id="check_<?= $index ?>"
                                                        class="custom-control-input back-to-top"/>
                                                    <label for="check_<?= $index ?>"
                                                        class="custom-control-label go-left"> <img
                                                        height="20" width="20"
                                                        class="go-right amenities"
                                                        src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?= $item->thumbnail ?>">
                                                    <span>  <?= "  " . $item->name ?></span></label>
                                                </div>
                                            </div>
                                            <?php if ($index == 4) { ?>
                                            <div id="filerPropertyTypeShowHide" class="collapse">
                                                <div class="collapse-inner">
                                                </div>
                                            </div>
                                            <?php }
                                                } ?>
                                            <div class="clear mb-5"></div>
                                            <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-on"
                                                type="buttom" data-toggle="collapse"
                                                data-target="#filerPropertyTypeShowHide"><?= lang('0185') ?> (+)</span>
                                            <span class="btn btn-toggle btn-text-inherit text-secondary text-uppercase font10 letter-spacing-1 font600 collapsed collapsed-off"
                                                type="buttom" data-toggle="collapse"
                                                data-target="#filerPropertyTypeShowHide"><?= lang('067') ?> (-)</span>
                                        </div>
                                    </div>
                                    <div class="sidebar-box">
                                        <div class="box-content">
                                            <button type="submit" class="btn btn-primary btn-block"
                                                id="searchform"><?php echo trans('012'); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end sidebar-widget-item -->
                    </div>
                    <!-- end sidebar-widget -->
                </div>
                <!-- end sidebar -->
            </div>
            <!-- end col-lg-4 -->
            <div class="col-lg-9">
                <ul id="LIST" class="catalog-panel list_data">
                    <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array());
                        foreach ($sr as $main_index => $item) {
                                ?>
                    <li class="all  item <?=strtolower(str_replace(" ", "", $item->segments[0][0]->airline_name))?> oneway_<?=count($item->segments[0])-1?>  ">
                        <input type="hidden" value="<?=$item->segments[0][0]->price?>" id="price" >
                        <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">
                            <div class="theme-search-results-item-preview">
                                <div class="theme-search-results-item-mask-link"
                                    href="#searchResultsItem-<?= $main_index ?>" role="button"
                                    data-toggle="collapse" aria-expanded="false"
                                    aria-controls="searchResultsItem-<?= $main_index ?>"></div>
                                <div class="row" data-gutter="20">
                                    <?php foreach ($item->segments as $index => $segment) {  ?>
                                    <form class="row" action="<?= $segment[0]->action; ?>"
                                        name="<?= $segment[0]->form_name; ?>" method="post">
                                        <?php if (!empty($segment[0]->form)) {
                                            echo $segment[0]->form;
                                            } ?>
                                        <div class="col-md-10 ">
                                            <div class="theme-search-results-item-flight-sections">
                                                <div class="theme-search-results-item-flight-section">
                                                    <div class="row-no-gutter row-eq-height">
                                                        <div class="col-md-2">
                                                            <div class="theme-search-results-item-flight-section-airline-logo-wrap"
                                                                style="#background: #f8f8f8; border-radius: 5px;">
                                                                <h5 class="theme-search-results-item-flight-section-airline-title"
                                                                    style="margin-top:3px"><?= $segment[0]->airline_name ?></h5>
                                                                <?php // echo $segment[0]->type;?>
                                                                <img class="theme-search-results-item-flight-section-airline-logo"
                                                                    src="<?= $segment[0]->img_code; ?>"
                                                                    alt="airline" title="airline">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10 ">
                                                            <div class="theme-search-results-item-flight-section-item">
                                                                <div class="row">
                                                                    <div class="col-md-3 ">
                                                                        <div class="theme-search-results-item-flight-section-meta">
                                                                            <p class="theme-search-results-item-flight-section-meta-time"><?= $segment[0]->departure_time ?>
                                                                            </p>
                                                                            <p class="theme-search-results-item-flight-section-meta-city"><?= $segment[0]->departure_airport ?></p>
                                                                            <p class="theme-search-results-item-flight-section-meta-date"><?= $segment[0]->departure_date ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 ">
                                                                        <div class="theme-search-results-item-flight-section-path">
                                                                            <div class="theme-search-results-item-flight-section-path-fly-time">
                                                                                <p><?= lang('0560') ?> <?= $segment[0]->duration_time ?></p>
                                                                            </div>
                                                                            <div class="theme-search-results-item-flight-section-path-line"></div>
                                                                            <div class="theme-search-results-item-flight-section-path-line-start">
                                                                                <i class="la la-plane-departure theme-search-results-item-flight-section-path-icon"></i>
                                                                                <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                                                                <div class="theme-search-results-item-flight-section-path-line-title"><?= $segment[0]->departure_code ?></div>
                                                                            </div>
                                                                            <div class="theme-search-results-item-flight-section-path-line-middle">
                                                                                <!--<i class="fa fa-plane theme-search-results-item-flight-section-path-icon"></i>
                                                                                    <div class="theme-search-results-item-flight-section-path-line-dot"></div>-->
                                                                                <div class="theme-search-results-item-flight-section-path-line-title"
                                                                                    style="margin-top:35px;color:#000">
                                                                                    <strong><?= lang('0623') ?><?php if ($index == 0) {
                                                                                        !in_array(count($segment) - 1, $stop_array["oneway_stop"]) ? array_push($stop_array["oneway_stop"], count($segment) - 1) : "";
                                                                                        } else {
                                                                                        in_array(count($segment) - 1, $stop_array["return_stop"]);
                                                                                        } ?> <?= count($segment) - 1 ?></strong>
                                                                                </div>
                                                                            </div>
                                                                            <div class="theme-search-results-item-flight-section-path-line-end">
                                                                                <i class="la la-plane-arrival theme-search-results-item-flight-section-path-icon"></i>
                                                                                <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                                                                <div class="theme-search-results-item-flight-section-path-line-title"><?= end($segment)->arrival_code ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 ">
                                                                        <div class="theme-search-results-item-flight-section-meta">
                                                                            <p class="theme-search-results-item-flight-section-meta-time"><?= end($segment)->arrival_time ?></p>
                                                                            <p class="theme-search-results-item-flight-section-meta-city"><?= end($segment)->arrival_airport ?></p>
                                                                            <p class="theme-search-results-item-flight-section-meta-date"><?= end($segment)->arrival_date ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($index == 0) { ?>
                                        <div class="col-md-2 ">
                                            <div class="theme-search-results-item-book">
                                                <div class="theme-search-results-item-price">
                                                    <p class="theme-search-results-item-price-tag">
                                                        <strong><?php $min = 0;$max =0; if($segment[0]->price < $min ){ $min = $segment[0]->price;  }  if($segment[0]->price > $max ){ $max = $segment[0]->price;  } echo $segment[0]->currency_code . " " . $segment[0]->price ?></strong>
                                                    </p>
                                                    <!--<p class="theme-search-results-item-price-sign"><?= $segment[0]->booking_class ?></p>-->
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary btn-block theme-search-results-item-price-btn"><?= lang('0142') ?></button>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="collapse theme-search-results-item-collapse"
                                id="searchResultsItem-<?= $main_index ?>">
                                <div class="theme-search-results-item-extend">
                                    <div class="theme-search-results-item-extend-close"
                                        href="#searchResultsItem-<?= $main_index ?>" role="button"
                                        data-toggle="collapse" aria-expanded="false"
                                        aria-controls="searchResultsItem-<?= $main_index ?>">&#10005;
                                    </div>
                                    <?php foreach ($item->segments as $main_segments) { ?>
                                    <?php foreach ($main_segments as $segment_collapse) { ?>
                                    <div class="theme-search-results-item-extend-inner">
                                        <div class="theme-search-results-item-flight-detail-items">
                                            <div class="theme-search-results-item-flight-details">
                                                <div class="row">
                                                    <div class="col-md-3 ">
                                                        <div class="theme-search-results-item-flight-details-info">
                                                            <h5 class="theme-search-results-item-flight-details-info-title"><?= lang('0472') ?></h5>
                                                            <p class="theme-search-results-item-flight-details-info-date"><?= $segment_collapse->departure_date ?></p>
                                                            <p class="theme-search-results-item-flight-details-info-cities"><?= $segment_collapse->departure_airport ?></p>
                                                            <p class="theme-search-results-item-flight-details-info-fly-time"><?= $segment_collapse->departure_time ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 ">
                                                        <div class="theme-search-results-item-flight-details-schedule">
                                                            <ul class="theme-search-results-item-flight-details-schedule-list">
                                                                <li>
                                                                    <i class="la la-plane theme-search-results-item-flight-details-schedule-icon"></i>
                                                                    <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                                                                    <p class="theme-search-results-item-flight-details-schedule-date"><?= lang('0606') ?> <?= $segment_collapse->arrival_date ?></p>
                                                                    <div class="theme-search-results-item-flight-details-schedule-time">
                                                                        <span class="theme-search-results-item-flight-details-schedule-time-item">
                                                                            <?= $segment_collapse->departure_time ?>
                                                                            <!--<span>pm</span>-->
                                                                        </span>
                                                                        <span class="theme-search-results-item-flight-details-schedule-time-separator">-</span>
                                                                        <span class="theme-search-results-item-flight-details-schedule-time-item">
                                                                            <?= $segment_collapse->arrival_time ?>
                                                                            <!--<span>pm</span>-->
                                                                        </span>
                                                                    </div>
                                                                    <p class="theme-search-results-item-flight-details-schedule-fly-time"><?= lang('0560') ?> <?= $segment_collapse->segment_time ?></p>
                                                                    <div class="theme-search-results-item-flight-details-schedule-destination">
                                                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                                                <b><?= $segment_collapse->departure_code ?></b> <?= $segment_collapse->departure_airport ?>
                                                                            </p>
                                                                            <!--<p class="theme-search-results-item-flight-details-schedule-destination-city"></p>-->
                                                                        </div>
                                                                        <div class="theme-search-results-item-flight-details-schedule-destination-separator">
                                                                            <span>&#8594;</span>
                                                                        </div>
                                                                        <div class="theme-search-results-item-flight-details-schedule-destination-item">
                                                                            <p class="theme-search-results-item-flight-details-schedule-destination-title">
                                                                                <b><?= $segment_collapse->arrival_code ?></b> <?= $segment_collapse->arrival_airport ?>
                                                                            </p>
                                                                            <p class="theme-search-results-item-flight-details-schedule-destination-city"></p>
                                                                        </div>
                                                                    </div>
                                                                    <ul class="theme-search-results-item-flight-details-schedule-features">
                                                                        <li><?= $segment_collapse->airline_name ?></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }
                                        } ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php }  ?>
                </ul>
            </div>
        </div>
        <!--<div class="row">
            <div class="col-lg-12">
                    <div class="btn-box mt-3 text-center">
                            <button type="button" class="theme-btn"><i class="la la-refresh mr-1"></i>Load More</button>
                            <p class="font-size-13 pt-2">Showing 1 - 6 of 24 Flights</p>
                    </div>
            </div>
            </div>-->
    </div>
</section>
<!-- ================================
    END CARD AREA
    ================================= -->
<?php } ?>
<div class="section-block"></div>
<style>
    .theme-search-results-item-flight-section-airline-title{text-overflow:ellipsis;overflow:hidden;width:120px;height:1.2em;white-space:nowrap}
    form{width:100%}
    .hide{display:none}
    .show{display:block!important}
    #LIST li{width:100%}
    .form-inner label{position:static}
    .form-icon-left .icon-font{top:-2px}
    .iframe-container{overflow:hidden;// Calculated from the aspect ration of the content(in case of 16:9 it is 9/16= .5625) padding-top:56.25%}
    .iframe-container iframe{border:0;height:100%;left:0;position:absolute;top:0;width:100%;margin-top:96px}
    .iframe-container{height:100vh}
    .collapse .form-search-main-01 .row-return label{top:8px}
    .form-spin-group .form-icon-left .icon-font i{left: -9px;top: -10px;}
</style>
<script type="text/javascript">
    var oneway_list = <?=json_encode($stop_array["oneway_stop"]);?>;
    var direct_lang = "<?= lang('0604') ?>";
    var stop_lang = "<?= lang('0423') ?>";
    oneway_list.sort(function(a, b){return a-b});
    oneway_list.forEach(function (item) {
            var display_lang = (item == 0) ? direct_lang : item + " " + stop_lang;
            $("#group_main").append(
                    '<div class="go-right"> ' +
                    '<input class="custom-control-input"  type="radio" id="'+item+'"name="priceOrder" value="'+item+'">' +
                    '<label class="custom-control-label go-left" for="'+item+'"> '+ display_lang + '</label></div>');
    });

    var main = $(".all");
    var filter_airlines = [];
    var filter_stop = "";
    var min_price= <?=$min?>;
    var max_price= <?=$max?>;

    $('input[type="checkbox"]').click(function ()
    {
            if(in_array($(this).val().replace(/ /g, "").toLowerCase(),filter_airlines)){
                    filter_airlines.splice(filter_airlines.indexOf($(this).val().replace(/ /g, "").toLowerCase()), 1);
            }else{
                    filter_airlines.push($(this).val().replace(/ /g, "").toLowerCase());
            }
            filter_engine();
    });
    function filter_engine()
    {
            var temp_filter = filter_airlines_func(main);
            temp_filter = filter_stops_func(temp_filter);
            temp_filter = filter_price_func(temp_filter);
            $("#LIST").empty();
            $("#LIST").append(temp_filter);
    }
    function filter_airlines_func(loop_array)
    {
            var temp_array = [];
            if(filter_airlines.length){
                    for(var i=0;i<loop_array.length;i++){
                            if(in_array(loop_array[i].classList[2],filter_airlines)){
                                    temp_array.push(loop_array[i]);
                            }
                    }
                    return temp_array;
            }else{
                    return loop_array;
            }

    }
    function filter_stops_func(loop_array)
    {
            var temp_array = [];
            if(filter_stop != ""){
                    for(var i=0;i<loop_array.length;i++){
                            if(loop_array[i].classList[3] == filter_stop){
                                    temp_array.push(loop_array[i]);
                            }
                    }
                    return temp_array;
            }else{
                    return loop_array;
            }

    }

    function filter_price_func(loop_array) {
            var temp_array = [];
            for(var i = 0; i < loop_array.length; i++) {
                    var price = parseInt($(loop_array[i]).find("#price").val());
                    if (price > min_price &&  price < max_price ) {
                            temp_array.push(loop_array[i]);
                    }
            }
            return temp_array;

    }

    $('input[type="radio"]').click(function () {
            filter_stop = "oneway_" + $(this).val();
            filter_engine();
    });


    function in_array(needle, haystack) {
            for (var i in haystack) {
                    if (haystack[i] == needle) return true;
            }
            return false;
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
            document.body.scrollTop = 20; // For Safari
            document.documentElement.scrollTop = 20; // For Chrome, Firefox, IE and Opera
    }

    // price range
    function slider() {
            $(".js-range-slider").ionRangeSlider({
                    type: "double",
                    min: min_price,
                    max: max_price,
                    from: min_price,
                    to: max_price,
                    grid: true,
                    onChange: function (data) {
                            min_price =  data.from;
                            max_price = data.to
                            filter_engine();
                    }
            });
    }

    $("[name='tpfbooking']").on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var payload = form.serializeArray();
            $.post(base_url + 'tpflightapi/booking', payload, function (response) {
                    result = jQuery.parseJSON(response);
                    $(location).attr('href', result.msg);
            });
    });
</script>