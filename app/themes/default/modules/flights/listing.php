    <script src="<?=root.theme_url?>assets/js/mixitup.min.js"></script>
    <script src="<?=root.theme_url?>assets/js/mixitup-pagination.min.js"></script>
    <script src="<?=root.theme_url?>assets/js/mixitup-multifilter.min.js"></script>
    <script src="<?=root.theme_url?>assets/js/plugins/ion.rangeSlider.min.js"></script>
    <section class="breadcrumb-area bread-bg-flights">
    <div class="breadcrumb-wrap">
    <div class="container">
    <div class="row align-items-center">
    <div class="col-lg-6">
    <div class="breadcrumb-content">
    <div class="section-heading">
    <div class="left-side-info rtl-align-right" style="color:#fff">
    <span>
    <strong style="text-transform: capitalize">
    <h2 class="sec__title_list"><?php if(isset($_SESSION['flights_origin'])){ echo strtoupper($_SESSION['flights_origin']); } else {} ?> <i class="la la-arrow-right"></i> <?php if(isset($_SESSION['flights_destination'])){ echo strtoupper($_SESSION['flights_destination']); } else {} ?></h2>
    </strong>
    </span>
    <div>
    <p><strong><?=T::dates?> </strong>( <?php if(isset($_SESSION['flights_departure_date'])){ echo $_SESSION['flights_departure_date']; } else { $d=strtotime("+3 Days"); echo date("d-m-Y", $d); } ?> <i class="la la-arrow-right"></i> <?php if(isset($_SESSION['flights_returning_date'])){ echo $_SESSION['flights_returning_date']; } else { $d=strtotime("+5 Days"); echo date("d-m-Y", $d); } ?> )</p>
    <p><strong><?=T::flights_adults?></strong> <?php if(isset($_SESSION['flights_adults'])){ echo $_SESSION['flights_adults']; } else { echo "1"; } ?> <strong><?=T::flights_childs?></strong> <?php if(isset($_SESSION['flights_childs'])){ echo $_SESSION['flights_childs']; } else { echo "0"; } ?> <strong><?=T::flights_infants?></strong> <?php if(isset($_SESSION['flights_infants'])){ echo $_SESSION['flights_infants']; } else { echo "0"; } ?></p>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="breadcrumb-list">
    <ul class="list-items d-flex justify-content-end">
    <li><a href="javascript:void(0)"><?=T::flights_total_flights?> <?= count($flights_data); ?></a></li>
    </ul>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- end breadcrumb-wrap -->
    <!-- <div class="bread-svg-box">
    <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none">
    <polygon points="100 0 50 10 0 0 0 10 100 10"></polygon>
    </svg>
    </div>-->
    <!-- end bread-svg -->
    </section>
    <div class="modify_search">
    <div class="container">
    <?php include 'search.php';?>
    </div>
    </div>
    <?php if ( empty($flights_data) ) { ?>
    <div class="container text-center">
    <img src="<?=root?><?=theme_url?>assets/img/no_results.gif" alt="no results" />
    </div>
    <?php  } else { ?>
    <main class="cd-main-content container mt-5">
    <div class="row">
    <div class="col-md-3 d-none d-sm-block">
    <div class="sticky-top">
    <form>
    <div class="card-header">
    <strong><?=T::modifysearch?></strong>
    </div>
    <div class="sidebar mt-0">
    <div class="sidebar-widget">
    <div class="sidebar-widget-item">
    <div class="contact-form-action">
    <div class="sidebar-widget">
    <div class="sidebar-box">
    <h3 class="title stroke-shape"><?=T::flights_flightstops?></h3>
    <div class="box-content">
        <fieldset data-filter-group>
            <ul class="list remove_duplication">
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" value="all" type="radio" name="type" id="all" checked="">
                        <label class="form-check-label" for="all"> <?=T::flights_allrights?></label>
                    </div>
                </li>
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" type="radio" name="type" id="direct" value=".oneway_0"  value="">
                        <label class="form-check-label" for="direct"> <?=T::flights_direct?></label>
                    </div>
                </li>
                <?php foreach ($flights_data as $index => $item)  if ( count($item->segments[0])-1 == 1 ) { ?>
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" type="radio" name="type" id="<?=$index?>" value=".oneway_<?=count($item->segments[0])-1?>" value="">
                        <label class="form-check-label" for="<?=$index?>"> Stops <?=count($item->segments[0])-1?></label>
                    </div>
                </li>
                <?php } else {} ?>
                <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array()); foreach ($flights_data as $index => $item) if ( count($item->segments[0])-1 == 2 ) { ?>
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" type="radio" name="type" id="<?=$index?>" value=".oneway_<?=count($item->segments[0])-1?>" value="">
                        <label class="form-check-label" for="<?=$index?>"> Stops <?=count($item->segments[0])-1?></label>
                    </div>
                </li>
                <?php } ?>
                <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array()); foreach ($flights_data as $index => $item) if ( count($item->segments[0])-1 == 3 ) { ?>
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" type="radio" name="type" id="<?=$index?>" value=".oneway_<?=count($item->segments[0])-1?>" value="">
                        <label class="form-check-label" for="<?=$index?>"> Stops <?=count($item->segments[0])-1?></label>
                    </div>
                </li>
                <?php } ?>
                <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array()); foreach ($flights_data as $index => $item) if ( count($item->segments[0])-1 == 4 ) { ?>
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" type="radio" name="type" id="<?=$index?>" value=".oneway_<?=count($item->segments[0])-1?>" value="">
                        <label class="form-check-label" for="<?=$index?>"> Stops <?=count($item->segments[0])-1?></label>
                    </div>
                </li>
                <?php } ?>
                <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array()); foreach ($flights_data as $index => $item) if ( count($item->segments[0])-1 == 5 ) { ?>
                <li>
                    <div class="form-check">
                        <input class="form-check-input filter" type="radio" name="type" id="<?=$index?>" value=".oneway_<?=count($item->segments[0])-1?>" value="">
                        <label class="form-check-label" for="<?=$index?>"> Stops <?=count($item->segments[0])-1?></label>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </fieldset>
        <!-- cd-filter-content -->
    </div>
    </div>
    </div>
    <div class="sidebar-widget controls">
    <h3 class="title stroke-shape"><?=T::pricerange?></h3>
    <div class="sidebar-price-range">
    <div class="range-sliderrr">
        <input type="text" class="js-range-slider" data-ref="range-slider-a" value="" />
    </div>
    <div class="range-sliderrr" style="display:none">
        <input type="text" class="js-range-slider" data-ref="range-slider-b" value="" />
    </div>
    <!--<div class="main-search-input-item">
        <div class="price-slider-amount padding-bottom-20px">
            <label for="amount2" class="filter__label"><?=T::price?>:</label>
            <input type="text" id="amount2" class="amounts" id="filter-weight" data-filter-group="weight">
            <input id="price_range" name ='price' class="amounts" />
        </div>
        <div id="slider-range2" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
        </div>
    </div>
    <div class="btn-box pt-4">
        <button onclick="getInputValue();" class="theme-btn theme-btn-small theme-btn-transparent" type="button">Apply</button>
    </div>-->
    </div>
    </div>
    <fieldset data-filter-group>
    <div class="sidebar-box mb-4 controls">
    <h3 class="title stroke-shape" style="text-transform:capitalize"><?=T::flights_airlines?></h3>
    <ul class="list remove_duplication checkbox-group">
        <?php
        $stop_array = array("oneway_stop" => array(), "return_stop" => array()); foreach ($flights_data as $main_index => $item) { ?>
        <?php foreach ($item->segments as $index => $segment) {  ?>
        <li>
            <div class="custom-checkbox flights_line">
                <input class="filter" type="checkbox" id="flights_<?=$main_index?>" value=".<?=strtolower(str_replace(" ", "", $item->segments[0][0]->airline_name))?>">
                <label for="flights_<?=$main_index?>"> <img class="lazyload" data-src="<?= $segment[0]->img; ?>" style="background:transparent;max-width:20px;padding-top:0px;margin: 0 6px" /> <?= $segment[0]->airline_name ?></label>
            </div>
        </li>
        <?php } } ?>
    </ul>
    </div>
    </fieldset>
    <!--<div class="sidebar-box">
    <div class="box-content">
    <button type="submit" class="btn btn-primary btn-block" id="searchform"><?=T::modifysearch?></button>
    </div>
    </div>-->
    </div>
    </div>
    <!-- end sidebar-widget-item -->
    </div>
    <!-- end sidebar-widget -->
    </div>
    <!-- end sidebar -->
    </form>
    </div>
    <!-- cd-filter -->
    </div>
    <!-- cd-filter -->
    <div class="col-md-9">
    <?= signupdeals();?>
    <section data-ref="container">
    <ul class="catalog-panel">
    <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array()); foreach ($flights_data as $main_index => $item) {  ?>
    <li class="mix all <?=strtolower(str_replace(" ", "", $item->segments[0][0]->airline_name))?> oneway_<?=count($item->segments[0])-1?>" data-a="<?=$item->segments[0][0]->price?>" data-b="">
    <div class="theme-search-results-item _mb-10 theme-search-results-item-rounded theme-search-results-item-">


    <?php

    // dd($item->segments[0][0]);


    // $min = 0;$max =0; if($segment[0]->price < $min ){ $min = $segment[0]->price; } if($segment[0]->price > $max ){ $max = $segment[0]->price;  } echo $currency . " " . $segment[0]->price;

    if (type == "oneway"){

    $flight = [
    'oneway_adult_price'=>$item->segments[0][0]->adult_price,
    'oneway_child_price'=>$item->segments[0][0]->child_price,
    'oneway_infant_price'=>$item->segments[0][0]->infant_price,
    'currency'=> $currency,
    'total'=> adults * $item->segments[0][0]->adult_price + childs * $item->segments[0][0]->child_price + infants * $item->segments[0][0]->infant_price,

    'supplier'=> $item->segments[0][0]->type,
    'flight_type'=> type
    ];

    // dd($flight);

    $a_price = adults * $flight['oneway_adult_price'];
    $c_price = childs * $flight['oneway_child_price'];
    $i_price = infants * $flight['oneway_infant_price'];

    $price = $a_price + $c_price + $i_price;

    }

    if (type == "return"){

    $flight = [
    'oneway_adult_price'=>$item->segments[0][0]->adult_price,
    'oneway_child_price'=>$item->segments[0][0]->child_price,
    'oneway_infant_price'=>$item->segments[0][0]->infant_price,

    'return_adult_price'=>$item->segments[1][0]->adult_price,
    'return_child_price'=>$item->segments[1][0]->child_price,
    'return_infant_price'=>$item->segments[1][0]->infant_price,

    'currency'=> $currency,
    'total'=> adults * $item->segments[0][0]->adult_price + childs * $item->segments[0][0]->child_price + infants * $item->segments[0][0]->infant_price
    // return flight prices
    + adults * $item->segments[1][0]->adult_price + childs * $item->segments[1][0]->child_price + infants * $item->segments[1][0]->infant_price,

    'supplier'=> $item->segments[0][0]->type,
    'flight_type'=> type
    ];

    // dd($flight);

    $oneway_adults_price = adults * $flight['oneway_adult_price'];
    $oneway_childs_price = childs * $flight['oneway_child_price'];
    $oneway_infant_price = infants * $flight['oneway_infant_price'];

    $return_adults_price = adults * $flight['return_adult_price'];
    $return_childs_price = childs * $flight['return_child_price'];
    $return_infant_price = infants * $flight['return_infant_price'];

    $price_oneway = $oneway_adults_price + $oneway_childs_price + $oneway_infant_price;
    $price_return = $return_adults_price + $return_childs_price + $return_infant_price;

    $price = $price_oneway + $price_return;
    }

    // dd($item->segments[0]);
    // dd($item->segments[1]);

    $oneway_route = $item->segments[0];
    if (type == "return") {
    $return_route = $item->segments[1];
    } else { $return_route = ""; }

    $routes = [
    '0'=>$oneway_route,
    '1'=>$return_route,
    ];

    $travellers = [
    'adults' => adults,
    'childs' => childs,
    'infants' => infants,
    ];

    ?>

    <form class="row" action="<?=root?>flights/booking" name="<?= $segment[0]->form_name; ?>" method="post">
    <input name="routes" type="hidden" value="<?php echo base64_encode(json_encode($routes)) ?>">
    <input name="prices" type="hidden" value="<?php echo base64_encode(json_encode($flight)) ?>">
    <input name="travellers" type="hidden" value="<?php echo base64_encode(json_encode($travellers)) ?>">

    <div class="row g-0">
    <div class="col-md-10">

    <div class="theme-search-results-item-preview">
    <div class="theme-search-results-item-mask-link" data-bs-toggle="collapse" href="#searchResultsItem-<?= $main_index ?>" role="button"></div>
    <div class="row" data-gutter="20">
    <?php foreach ($item->segments as $index => $segment) {  // dd($segment); ?>
    <!--<form class="row" action="<?= $segment[0]->action; ?>" name="<?= $segment[0]->form_name; ?>" method="post">-->

    <?php //if (!empty($segment[0]->form)) { echo json_encode($segment[0]->form); } ?>

    <div class="col-md-12">
    <div class="theme-search-results-item-flight-sections">
        <div class="theme-search-results-item-flight-section">
            <div class="row-no-gutter row-eq-height row">
                <div class="col-md-2 col-12">
                    <div class="theme-search-results-item-flight-section-airline-logo-wrap" style="#background: #f8f8f8; border-radius: 5px;">
                        <h5 class="theme-search-results-item-flight-section-airline-title" style="margin-top:3px"><?= $segment[0]->airline_name ?></h5>
                        <?php // echo $segment[0]->type;?>
                        <img class="theme-search-results-item-flight-section-airline-logo lazyload" style="background:transparent" data-src="<?= $segment[0]->img; ?>">
                        <h5 class="theme-search-results-item-flight-section-airline-title" style="margin-top:44px"><strong><?= $segment[0]->departure_flight_no ?></strong></h5>
                    </div>
                </div>
                <div class="col-md-10 col-12">
                    <div class="theme-search-results-item-flight-section-item">
                        <div class="row">
                            <div class="col-md-3 col-3">
                                <div class="theme-search-results-item-flight-section-meta">
                                    <p class="theme-search-results-item-flight-section-meta-time"><?= date ('h:i a',strtotime($segment[0]->departure_time)); ?></p>
                                    <p class="theme-search-results-item-flight-section-meta-city"><?= $segment[0]->departure_airport ?></p>
                                    <p class="theme-search-results-item-flight-section-meta-date"><?= date ('d M Y',strtotime($segment[0]->departure_date)); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-6 g-0">
                                <div class="theme-search-results-item-flight-section-path">
                                    <div class="theme-search-results-item-flight-section-path-fly-time">
                                        <p><strong><?=T::flights_tripduration?> <?= $segment[0]->duration_time ?> <?=T::hours?></strong></p>
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
                                            style="margin-top:35px;color:#000;font-weight:bold;width:40px">
                                            <strong><?=T::flights_stops?> <?php if ($index == 0) { !in_array(count($segment) - 1, $stop_array["oneway_stop"]) ? array_push($stop_array["oneway_stop"], count($segment) - 1) : ""; } else { in_array(count($segment) - 1, $stop_array["return_stop"]); } ?> <?= count($segment) - 1 ?></strong>
                                        </div>
                                    </div>
                                    <div class="theme-search-results-item-flight-section-path-line-end">
                                        <i class="la la-plane-arrival theme-search-results-item-flight-section-path-icon"></i>
                                        <div class="theme-search-results-item-flight-section-path-line-dot"></div>
                                        <div class="theme-search-results-item-flight-section-path-line-title"><?= end($segment)->arrival_code ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="theme-search-results-item-flight-section-meta">
                                    <p class="theme-search-results-item-flight-section-meta-time"><?= date ('h:i a',strtotime($segment[0]->arrival_time));  ?></p>
                                    <p class="theme-search-results-item-flight-section-meta-city"><?= end($segment)->arrival_airport ?></p>
                                    <p class="theme-search-results-item-flight-section-meta-date"><?= date ('d M Y',strtotime($segment[0]->arrival_date));  ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php } ?>
    </div>
    </div>
    <div class="collapse theme-search-results-item-collapse" id="searchResultsItem-<?= $main_index ?>">
    <div class="theme-search-results-item-extend">
    <div class="theme-search-results-item-extend-close" data-bs-toggle="collapse" href="#searchResultsItem-<?= $main_index ?>" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="searchResultsItem-<?= $main_index ?>">&#10005;</div>
    <?php foreach ($item->segments as $main_segments) {
    /*dd($main_segments);*/
    foreach ($main_segments as $segment_collapse) { ?>
    <div class="theme-search-results-item-extend-inner">
    <div class="theme-search-results-item-flight-detail-items">
    <div class="theme-search-results-item-flight-details">
        <div class="row">
            <div class="col-md-3">
                <div class="theme-search-results-item-flight-details-info p-3">
                    <h5 class="theme-search-results-item-flight-details-info-title"><?=T::from?></h5>
                    <p class="theme-search-results-item-flight-details-info-date"><?= date ('d M Y',strtotime($segment[0]->departure_date)); ?></p>
                    <p class="theme-search-results-item-flight-details-info-cities"><?= $segment_collapse->departure_airport ?></p>
                    <p class="theme-search-results-item-flight-details-info-fly-time"><?= date ('h:i a',strtotime($segment[0]->departure_time)); ?></p>
                </div>
            </div>
            <div class="col-md-9">
                <div class="theme-search-results-item-flight-details-schedule">
                    <ul class="theme-search-results-item-flight-details-schedule-list">
                        <li>
                            <i class="la la-plane theme-search-results-item-flight-details-schedule-icon"></i>
                            <div class="theme-search-results-item-flight-details-schedule-dots"></div>
                            <p class="theme-search-results-item-flight-details-schedule-date"><?=T::to?> <?= date ('d M Y',strtotime($segment[0]->departure_date)); ?></p>
                            <div class="row">
                            <div class="col-5">

                            <div class="theme-search-results-item-flight-details-schedule-time">
                                <span class="theme-search-results-item-flight-details-schedule-time-item">
                                    <?= date ('h:i a',strtotime($segment[0]->departure_time)); ?>
                                    <!--<span>pm</span>-->
                                </span>
                                <span class="theme-search-results-item-flight-details-schedule-time-separator">-</span>
                                <span class="theme-search-results-item-flight-details-schedule-time-item">
                                    <?= date ('h:i a',strtotime($segment[0]->arrival_time)); ?>
                                    <!--<span>pm</span>-->
                                </span>
                            </div>
                            <p class="theme-search-results-item-flight-details-schedule-fly-time">
                              <strong>
                              <?=T::tripduration?>
                              <?= $segment_collapse->duration_time ?>
                             <?php // $from = new DateTime($segment[0]->departure_time);  $to = new DateTime($segment[0]->arrival_time); echo $from->diff($to)->format('%h:%i'); // 5:10 ?>
                             <?=T::hours?>
                             </strong>
                            </p>
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
                            </div>

                            <div class="col-7 flight_desc">
                            <p><strong><?=T::flights_flight_class?></strong> <?=$segment_collapse->class_type?> </p>
                            <?php if (!empty($segment_collapse->bagage)){ ?>
                            <p><strong><?=T::flights_baggage_kg?></strong> <?=$segment_collapse->bagage?> </p>
                            <?php } ?>
                            <hr>
                            <p><?=strip_tags($segment_collapse->desc)?> </p>
                            </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <?php } } ?>
    </div>
    </div>
    </div>

     <div class="col-md-2">
     <div class="theme-search-results-item-book row">
        <!--<div class="theme-search-results-item-price">
            <p class="theme-search-results-item-price-sign"><?= $segment[0]->class_type ?></p>
        </div>-->
        <?php if (isset($_SESSION['user_login']) == true OR $app->app->restrict_website == false ) { ?>

        <button type="submit" class="btn btn-primary btn-block theme-search-results-item-price-btn ladda" data-style="zoom-in">
        <strong><?=$currency.' ' .$price ?></strong>
        <span><?=T::booknow?></span></button>
        <?php } else { ?>

        <a href="<?=root?>login" class="btn btn-primary btn-block theme-search-results-item-price-btn ladda">
        <span class="ladda-label">
        <strong style="display:block"><?php $min = 0;$max =0; if($segment[0]->price < $min ){ $min = $segment[0]->price; } if($segment[0]->price > $max ){ $max = $segment[0]->price;  } echo $currency . " " . $segment[0]->price ?></strong>
        <i class="la la-basket"></i> <?=T::login_to_book?></span>
        </a>
        <!--<p><small style="display: inline-block; line-height: 18px; font-size: 10px;" class="text-danger"><?=T::only_registered_users_book?></small></p>-->
        <?php } ?>
        <!--<button type="submit" data-bs-toggle="collapse" href="#searchResultsItem-<?= $main_index ?>" class="btn btn-default btn-block btn-sm"><?=T::details?></button>-->
    </div>
    </div>
    </div>

    </form>
    </div>
    </li>
    <?php } ?>
    <li class="gap"></li>
    <li class="gap"></li>
    <li class="gap"></li>
    </ul>
    <div class="controls-pagination">
    <div class="mixitup-page-list"></div>
    <div class="mixitup-page-stats"></div>
    </div>
    <p class="fail-message"><i class="las la-info-circle"></i> <strong><?=T::noresultsfound?></strong></p>
    </section>
    <!-- cd-gallery -->
    </div>
    </div>
    <!-- cd-filter -->
    </main> <!-- cd-main-content -->
    <?php } ?>
    <style>
    /*.theme-search-results-item-flight-section-airline-title{text-overflow:ellipsis;overflow:hidden;width:120px;height:1.2em;white-space:nowrap}*/
    form{width:100%}
    #LIST li{width:100%}
    .form-inner label{position:static}
    .form-icon-left .icon-font{top:-2px}
    .iframe-container{overflow:hidden;// Calculated from the aspect ration of the content(in case of 16:9 it is 9/16= .5625) padding-top:56.25%}
    .iframe-container iframe{border:0;height:100%;left:0;position:absolute;top:0;width:100%;margin-top:96px}
    .iframe-container{height:100vh}
    .collapse .form-search-main-01 .row-return label{top:8px}
    .form-spin-group .form-icon-left .icon-font i{left: -9px;top: -10px;}
    </style>
    <script>
    // remove dupicate contents
    var seen = {};
    $(".remove_duplication").find("li").each(function(index, html_obj) { txt = $(this).text().toLowerCase();
    if(seen[txt]) { $(this).remove(); } else { seen[txt] = true; } });
    // price range and filteration
    var $rangeA = $('[data-ref="range-slider-a"]');
    var $rangeB = $('[data-ref="range-slider-b"]');
    $rangeA.ionRangeSlider({
    skin: "round",
    type: "double",
    <?php 
    // TO FIX RESULT VARIABLE ERROR
   // if(isset($result)) { ?>
    min: <?php foreach ($flights_data as $index => $item) {$result[$index] = $item->segments[0][0]->price;} echo  $min_price = min($result); ?>,
    max: <?php foreach ($flights_data as $index => $item) {$result[$index] = $item->segments[0][0]->price;} echo  $min_price = max($result); ?>,
    from: <?php foreach ($flights_data as $index => $item) {$result[$index] = $item->segments[0][0]->price;} echo  $min_price = min($result); ?>,
    to: <?php foreach ($flights_data as $index => $item) {$result[$index] = $item->segments[0][0]->price;} echo  $min_price = max($result); ?>,
    onChange: handleRangeInputChange
    <?php // } ?>
    });
    $rangeB.ionRangeSlider({
    skin: "round",
    type: "double",
    min: 0,
    max: 10,
    from: 0,
    to: 10,
    onChange: handleRangeInputChange
    });
    var instanceA = $rangeA.data("ionRangeSlider");
    var instanceB = $rangeB.data("ionRangeSlider");
    var container = document.querySelector('[data-ref="container"]');
    var mixer = mixitup(container, {
    animation: { duration: 350, queueLimit: 10, effectsIn: 'fade translateY(-100%)' },
    pagination: { limit: 25 },
    multifilter: { enable: true  },
    callbacks: {
    onMixStart: function(){ $('.fail-message').fadeOut(0); $('.controls-pagination').css('display','block'); },
    onMixFail: function(){ $('.fail-message').fadeIn(0); $('.controls-pagination').css('display','none'); }
    }
    });
    function getRange() {
    var aMin = Number(instanceA.result.from);
    var aMax = Number(instanceA.result.to);
    var bMin = Number(instanceB.result.from);
    var bMax = Number(instanceB.result.to);
    return {
    aMin: aMin,
    aMax: aMax,
    bMin: bMin,
    bMax: bMax,
    };
    }
    function handleRangeInputChange() {
    mixer.filter(mixer.getState().activeFilter);
    }
    function filterTestResult(result, target) {
    var a = Number(target.dom.el.getAttribute('data-a'));
    var b = Number(target.dom.el.getAttribute('data-b'));
    var range = getRange();
    console.log(range);
    if (a < range.aMin || a > range.aMax || b < range.bMin || b > range.bMax) {
    result = false;
    }
    return result;
    }
    mixitup.Mixer.registerFilter('testResultEvaluateHideShow', 'range', filterTestResult);
    </script>