<!-- <script src="<?= root ?>assets/js/mixitup.min.js"></script>
<script src="<?= root ?>assets/js/mixitup-pagination.min.js"></script>
<script src="<?= root ?>assets/js/mixitup-multifilter.min.js"></script> -->
<script src="<?= root ?>assets/js/plugins/ion.rangeSlider.min.js"></script>


<!-- listjs  -->
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

<div class="py-4 mb-0">
    <div class="container">
        <div class="flights_listing">
        <?php require_once "./App/Views/Flights/Search.php"; ?>
        </div>
    </div>
</div>

<?php
//print_r($meta['data']);die;
//if (isset($meta['data'])) {
//    $FLIGHTS_DATA = $meta['data'];
//    $_SESSION['FLIGHTS_DATA'] = $FLIGHTS_DATA;
//}

if(!empty($meta['data'])){
    $FLIGHTS_DATA = $meta['data'];
    //$_SESSION['FLIGHTS_DATA'] = $FLIGHTS_DATA;
}
if (empty($meta['data'])) {
    include "App/Views/No_results.php";
 } else { ?>

    <div class="position-relative container-fluid bg-light pt-4 pb-4">

        <div class="container">
            <div class="row g-3">
                <!-- left side  -->
                <div class="col-lg-3 d-md-none d-lg-block">
                    
                    <!-- <div class="sticky-top sticky-bottom" style="bottom:100px"> -->
                    <div class="">


                    <div class="card border-0 rounded-3 search_filter_options" id="fadein">
                    <div class="card-body">
                    <form>

                    <div class="p-5 load_hide justify-content-center align-items-center" style="min-height:171.4px;display:flex"> <div class="loading_home"> <div class="bg-white"> </div> </div> </div>
                    
                            <div class="">
                                <!-- <strong><?= T::modifysearch ?></strong> -->
                            </div>
                            <div class="sidebar mt-0 loadcontent">
                                <div class="sidebar-widget">
                                    <div class="sidebar-widget-item">
                                        <div class="contact-form-action">
                                            <div class="sidebar-widget">
                                                <div class="sidebar-box">
                                                    <p><strong><?= T::flights_stops ?></strong></p>
                                                    <div class="box-content controls">
                                                        <!-- <ul class="list remove_duplication radio--filter" style="max-height:200px;overflow:hidden"> -->
                                                        <ul class="list remove_duplication stop--radio-filter" style="max-height:200px;overflow:hidden">
                                                            <li>
                                                                <div class="form-check">
                                                                    <!-- <input class="form-check-input filter" value=".all" type="radio" name="type" id="all" checked> -->
                                                                    <input class="form-check-input filter" value=".mix" type="radio" name="type" id="all" checked>
                                                                    <label class="form-check-label w-100" for="all"> <?= T::all .' '.T::flights ?></label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-check">
                                                                    <input class="form-check-input filter" type="radio" name="type" id="direct" value=".oneway_0">
                                                                    <label class="form-check-label w-100" for="direct"> <?= T::direct ?></label>
                                                                </div>
                                                            </li>
                                                            <?php foreach ($FLIGHTS_DATA as $index => $item)
                                                                if (count($item->segments[0]) - 1 == 1) { ?>
                                                                        <li>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input filter" type="radio" name="type" id="<?= $index ?>" value=".oneway_<?= count($item->segments[0]) - 1 ?>">
                                                                                <label class="form-check-label w-100" for="<?= $index ?>"> <?=T::stops?> <?= count($item->segments[0]) - 1 ?></label>
                                                                            </div>
                                                                        </li>
                                                                <?php } ?>
                                                            <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array());
                                                            foreach ($FLIGHTS_DATA as $index => $item)
                                                                if (count($item->segments[0]) - 1 == 2) { ?>
                                                                        <li>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input filter" type="radio" name="type" id="<?= $index ?>" value=".oneway_<?= count($item->segments[0]) - 1 ?>">
                                                                                <label class="form-check-label w-100" for="<?= $index ?>"> <?=T::stops?> <?= count($item->segments[0]) - 1 ?></label>
                                                                            </div>
                                                                        </li>
                                                                <?php } ?>
                                                            <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array());
                                                            foreach ($FLIGHTS_DATA as $index => $item)
                                                                if (count($item->segments[0]) - 1 == 3) { ?>
                                                                        <li>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input filter" type="radio" name="type" id="<?= $index ?>" value=".oneway_<?= count($item->segments[0]) - 1 ?>">
                                                                                <label class="form-check-label w-100" for="<?= $index ?>"> <?=T::stops?> <?= count($item->segments[0]) - 1 ?></label>
                                                                            </div>
                                                                        </li>
                                                                <?php } ?>
                                                            <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array());
                                                            foreach ($FLIGHTS_DATA as $index => $item)
                                                                if (count($item->segments[0]) - 1 == 4) { ?>
                                                                        <li>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input filter" type="radio" name="type" id="<?= $index ?>" value=".oneway_<?= count($item->segments[0]) - 1 ?>">
                                                                                <label class="form-check-label w-100" for="<?= $index ?>"> <?=T::stops?> <?= count($item->segments[0]) - 1 ?></label>
                                                                            </div>
                                                                        </li>
                                                                <?php } ?>
                                                            <?php $stop_array = array("oneway_stop" => array(), "return_stop" => array());
                                                            foreach ($FLIGHTS_DATA as $index => $item)
                                                                if (count($item->segments[0]) - 1 == 5) { ?>
                                                                        <li>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input filter" type="radio" name="type" id="<?= $index ?>" value=".oneway_<?= count($item->segments[0]) - 1 ?>">
                                                                                <label class="form-check-label w-100" for="<?= $index ?>"> <?=T::stops?> <?= count($item->segments[0]) - 1 ?></label>
                                                                            </div>
                                                                        </li>
                                                                <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sidebar-widget controls">
                                                <p class="mt-3"><strong><?= T::pricerange ?> ( <?=currency?> )</strong></p>
                                                <div class="sidebar-price-range">
                                                    <div class="range-sliderrr">
                                                        <input type="text" class="js-range-slider" data-ref="range-slider-a" value="" />
                                                    </div>
                                                    <!-- <div class="range-sliderrr" style="display:none">
                                                        <input type="text" class="js-range-slider" data-ref="range-slider-b" value="" />
                                                    </div> -->
                                                    <!--<div class="main-search-input-item">
                                                    <div class="price-slider-amount padding-bottom-20px">
                                                        <label for="amount2" class="filter__label"><?= T::price ?>:</label>
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
                                                <div class="sidebar-box mb-4 controls">
                                                        <p class="mt-3"><strong><?= T::oneway ?> <?= T::airlines ?></strong></p>

                                                        <ul class="list remove_duplication checkbox-group oneway--checkbox-filter">
                                                            <?php

                                                            $ar = array();
                                                            foreach($FLIGHTS_DATA as $key => $item){
                                                                foreach ($item->segments[0] as $i => $l){
                                                                    $img = ($item->segments[0][0]->img);
                                                                    $airline = ($item->segments[0][0]->airline);
                                                                    $ar_ = array( "img"=>$img,  "airline"=>$airline, );
                                                                    array_push($ar,$ar_);
                                                            }
                                                            }
                                                            
                                                            $result = array_map("unserialize", array_unique(array_map("serialize", $ar)));
                                                            $result = array_values($result);
                                                            ?>

                                                            <?php foreach($result as $j =>$r) {?>
                                                            <li>
                                                                <div class="form-check flights_line d-flex gap-2">
                                                                    <input class="form-check-input filter" type="checkbox" id="oneway_flights_<?=$j?>" value=".oneway_<?=str_replace(' ','',$r['airline'])?>">
                                                                    <label class="form-check-label w-100 text--overflow" for="oneway_flights_<?=$j?>"> 
                                                                    <img class="lazyload" src="<?=airline_logo($r['img'])?>" style="background:transparent;max-width:20px;max-height:20px;padding-top:0px;margin: 0 6px" /><?=($r['airline'])?></label>
                                                                </div>
                                                            </li>
                                                            <?php } ?>

                                                        </ul>
                                                </div>

                                            <?php if ($_SESSION['flights_type']=="return"){ ?>
                                                <div class="sidebar-box mb-4 controls return--check">
                                                    <p class="mt-3"><strong><?= T::return ?> <?= T::airlines ?></strong></p>
                                                    <ul class="list checkbox-group return--checkbox-filter">
                                                    
                                                        <?php

                                                        $ar = array();
                                                        foreach($FLIGHTS_DATA as $key => $item){
                                                            foreach ($item->segments[1] as $i => $l){
                                                                $img = ($l->img);
                                                                $airline = ($l->airline);
                                                                $ar_ = array( "img"=>$img,  "airline"=>$airline, );
                                                                array_push($ar,$ar_);
                                                        }
                                                        }
                                                        
                                                        $result = array_map("unserialize", array_unique(array_map("serialize", $ar)));
                                                        $result = array_values($result);

                                                        ?>

                                                        <?php foreach($result as $j =>$r) {?>
                                                        <li>
                                                            <div class="form-check flights_line d-flex gap-2">
                                                                <input class="form-check-input filter" type="checkbox" id="return_flights_<?=$j?>" value=".return_<?=str_replace(' ','',$r['airline'])?>">
                                                                <label class="form-check-label w-100 text--overflow" for="return_flights_<?=$j?>"> 
                                                                <img class="lazyload" src="<?=airline_logo($r['img'])?>" style="background:transparent;max-width:20px;max-height:20px;padding-top:0px;margin: 0 6px" /><?=($r['airline'])?></label>
                                                            </div>
                                                        </li>
                                                        <?php } ?>

                                                    </ul>
                                                </div>

                                            <?php } ?>

                                            <div class="sidebar-box mob_filter">
                                                <div class="box-content">
                                                    <!-- flight search submit  -->
                                                    <!-- <button class="fss btn btn-primary btn-block" id="filter_submit"><?= T::submit ?></button> -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>

            <!-- right side  -->
            <div class="col-lg-9"> 
            <div class="new-m-main-tit__content flex1 mb-3" style="background: url('<?=root?>assets/img/flight_search.avif') center bottom -220px / cover, rgb(50, 100, 255);">
            <div class="stacked-color"></div>
            <div class="flex tit-travel-restriction-wrapper">
                <h2 class="new-main-tit mx-2">
                    <span class="j_listABTit">
                    <?= count($FLIGHTS_DATA) ?> <?=T::flights_found?>                        
                    </span>
                </h2>
                <span class="title__fetched-time" style="color: rgb(255, 255, 255);">
                    <strong class="text-uppercase mx-3">
                        <?=$_SESSION['flights_origin']?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h13M12 5l7 7-7 7"/>
                        </svg>
                        <?=$_SESSION['flights_destination']?>
                    </strong>
                    <?=$_SESSION['flights_departure_date']?> 
                    <?php 
                        // SHOW ONLY WHEN FLIGHT IS RETURN
                        if ($_SESSION['flights_type']=="return"){ ?>
                    -
                    <?=$_SESSION['flights_returning_date']?> 
                    <?php } ?>
                </span>
            </div>
            </div>

                <!-- user hotel filter  -->
                <nav class="#sticky-top uhf sorting" style="top:80px" id="data">
                    <ul class="flex-nowrap gap-2 flex-sm-wrap gap-sm-0 nav nav-pills nav-justified bg-white rounded overflow-hidden mb-3">
                        <li class="nav-item">
                            <!-- <button data-sort="price:asc" role="button" class="nav-link border-end active rounded-0 px-0" data-bs-toggle="tab"> -->
                            <button data-value="asc" role="button" class="nav-link border-end active rounded-0 px-0" data-bs-toggle="tab">
                                <span class="d-block w-100 d-flex align-items-center justify-content-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>    
                                <?=T::lowest_to_higher?> </span>
                            </button>
                        </li>
                        <li class="nav-item">
                        <!-- <button data-sort="price:desc" role="button" class="nav-link border-end rounded-0 px-0" data-bs-toggle="tab"> -->
                        <button data-value="desc" role="button" class="nav-link border-end rounded-0 px-0" data-bs-toggle="tab">
                                <span class="d-block w-100 d-flex align-items-center justify-content-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20V10M6 20V4M18 20v-4"/></svg>    
                                <?=T::highest_to_lower?> </span>
                            </button>
                        </li>
                    </ul>

                </nav>
                <!-- user select nav end -->

                <div class="p-5 load_hide justify-content-center align-items-center" style="min-height:171.4px;display:flex"> 
                <div class="loading_home"> <div class="bg-white"> </div> 
                </div> 
                </div>               

                <div class="mixitup--container mt-2 loadcontent" id="flights--list-js">

                    <ul id="flight--list-targets" class="list">
                        <?php 
                        
                        // dd(json_encode($FLIGHTS_DATA));

                            foreach ($FLIGHTS_DATA as $i => $item) {
                            foreach ($item as $index => $segment) {

                                    $oneway_route = $item->segments[0];
                                    if ($meta['type'] == "return") {
                                    $return_route = $item->segments[1];
                                    } else { $return_route = ""; }

                                    // $routes = [
                                    // '0'=>$oneway_route,
                                    // '1'=>$return_route,
                                    // ];

                                    $routes = $item;

                                    // pre($routes);

                                    $travellers = [
                                    'adults' => $meta['adults'],
                                    'childs' => $meta['childs'],
                                    'infants' => $meta['infants'],
                                    ];

                                ?>

                                <li class="mix all card bg-white rounded-2 p-2 mt-2 p-0 flight_list
                                <?php if(!empty($item->segments[0][0]->img)){ echo $item->segments[0][0]->img;}?>
                                return_<?=( count($segment[0]) - 1)?> oneway_<?=( count($segment[0]) - 1)?> <?php if(!empty($item->segments[1][0]->airline)){ echo 'return_'.str_replace(' ','',$item->segments[1][0]->airline);}?> oneway_<?=str_replace(' ','',$item->segments[0][0]->airline)?> oneway_all" data-a="<?=$item->segments[0][0]->price?>"
                                data-price="<?=$item->segments[0][0]->price?>"
                                 data-all="oneway_all"
                                 data-stop="oneway_<?=( count($segment[0]) - 1)?>"
                                 data-oneway="oneway_<?=str_replace(' ','',$item->segments[0][0]->airline)?>"
                                 data-return="<?php if(!empty($item->segments[1][0]->airline)){ echo 'return_'.str_replace(' ','',$item->segments[1][0]->airline);}?>"
                                 >

                                <form class="" action="<?=root?>flights/booking" name="" method="post">

                                <input name="payload" type="hidden" value="<?php echo base64_encode(json_encode($segment[0])) ?>">
                                <input name="routes" type="hidden" value="<?php echo base64_encode(json_encode($routes)) ?>">
                                <input name="travellers" type="hidden" value="<?php echo base64_encode(json_encode($travellers)) ?>">
                                
                                <div class="px-1 pt-1 pb-2">
                                    <div class="row px-2">
                                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                                            <div class="py-2">
                                            <span style="width: 8px; height: 8px; position: absolute; z-index: 1; border-radius: 12px; padding: 0;background: <?=$segment[0][0]->color?>; top: 10px; left: 10px;"></span>
                                                <img style="max-width: 40px; max-height: 40px;" src="<?=airline_logo($segment[0][0]->img)?>" class="w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="mt-3 mt-sm-0 col-md-7">
                                            <h6 class="mb-0"><strong>
                                                    <!-- <?= date('d M Y', strtotime($segment[0][0]->departure_date)); ?>  -->
                                                    <?= date('h:i a', strtotime($segment[0][0]->departure_time)); ?>
                                                    -
                                                    <!-- <?= date('d M Y', strtotime($segment[0][count($segment[0]) - 1]->arrival_date)); ?>  -->
                                                    <?= date('h:i a', strtotime($segment[0][0]->arrival_time)); ?>
                                                </strong></h6>
                                            <p class="mb-1"><?= $segment[0][0]->airline ?> - <small> <?= $segment[0][0]->flight_no ?> </small></p>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">

                                                <div class="col-6 col-md-6">
                                                    <h6 class="mb-0"><strong><?= T::flights_tripduration ?> </strong></h6>
                                                    <p class="mb-0"> <?= $segment[0][0]->total_duration ?> <?= T::hours ?> </p>
                                                </div>

                                                <!-- FLIGHT STOPS -->
                                                <div class="col-6 col-md-6 text-end">
                                                    <h6 class="mb-0"><strong> <?= T::flights_stops ?>
                                                            <?php
                                                            // dd($index);
                                                            // if ($index == 0) { 
                                                            //     // !in_array(count($segment) - 1, 
                                                            //     // $stop_array["oneway_stop"]) ? array_push($stop_array["oneway_stop"], 
                                                            //     // count($segment) - 1) : "";
                                                            //  } else { 
                                                            //     in_array(count($segment) , 
                                                            //     $stop_array["return_stop"]); } 
                                                
                                                            ?>
                                                            <?= count($segment[0]) - 1; ?>
                                                        </strong></h6>
                                                    <p class="mb-0"><?= $segment[0][0]->departure_code ?> - <?= end($segment[0])->arrival_code ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    
                                <?php if ($_SESSION['flights_type']=="return"){ ?>

                                    <!-- RETURN -->
                                    <div class="px-1 pt-1 pb-2">
                                        <hr class="mt-0">
                                        <div class="row px-2">
                                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                <div class="py-2">
                                                    <img style="max-width: 40px; max-height: 40px;" src="<?=airline_logo($item->segments[1][0]->img)?>" class="w-100" alt="">
                                                </div>
                                            </div>
                                            <div class="mt-3 mt-sm-0 col-md-7">
                                                <h6 class="mb-0"><strong>
                                                        <?= date('h:i a', strtotime($item->segments[1][0]->departure_time)); ?>
                                                        -
                                                        <?= date('h:i a', strtotime($item->segments[1][0]->arrival_time)); ?>
                                                    </strong>
                                                </h6>
                                                <p class="mb-1"><?= $item->segments[1][0]->airline ?> - <small>  <?= $item->segments[1][0]->flight_no ?> </small></p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">

                                                    <div class="col-6 col-md-6">
                                                        <h6 class="mb-0"><strong><?= T::flights_tripduration ?> </strong></h6>
                                                        <p class="mb-0"> <?= $item->segments[1][0]->total_duration ?> <?= T::hours ?> </p>
                                                    </div>

                                                    <!-- FLIGHT STOPS -->
                                                    <div class="col-6 col-md-6 text-end">
                                                        <h6 class="mb-0"><strong> <?= T::flights_stops ?>

                                                                <?= count($segment[0]) - 1; ?>

                                                            </strong></h6>
                                                        <p class="mb-0"><?= end($segment[0])->arrival_code ?> <?= $segment[0][0]->departure_code ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                                <hr class="mt-0 mt-2 mb-1">

                                                <div class="pt-2 px-0 d-flex flex-column flex-sm-row justify-content-between">
                                                    <h6 class="order-2 order-sm-1 m-0 d-flex justify-content-center justify-content-sm-start align-items-center mt-3 mt-sm-0"><strong>
                                                        <small style="font-size: 14px; color: #aeaeae; font-weight: 100;"><?=T::from?></small> 
                                                            <?=currency?> <?= number_format((float) $segment[0][0]->price, 2, '.', '') ?>
                                                        </strong>
                                                    </h6>
                                                    <div class="order-1 order-sm-2 d-flex justify-content-between justify-content-sm-start gap-2">
                            
                                                    <?php $rand = rand(000000000,999999999)?>
                                                    <button 
                                                        class="flex-grow-1 btn btn-outline-dark" 
                                                        type="button" 
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#more_details_<?=$rand?>" 
                                                        aria-expanded="true"
                                                        aria-controls="more_details_<?=$rand?>"
                                                        onclick="moreDetails(this)"
                                                        >
                                                        <?=T::more_details?>
                                                        </button>
                                                        <button type="submit" class="flex-grow-1 btn btn-dark"><?= T::select ?> <?= T::flight ?></button>
                                                    </div>
                                                </div>
                                                
                                                <div class="collapse mt-2" id="more_details_<?=$rand?>">


                                                            <?php foreach ($item->segments as $main_segments) {
                                                            /*dd($main_segments);*/
                                                            $count_ = 0;
                                                            foreach ($main_segments as $segment_collapse) { ?>
                                                                 
                                                                 <div class="">
                                                        <div class="mx-2">

                                                        <div class="position-relative bg-light p-3 rounded-4 border">
                                                                <!-- <div class="position-absolute border bg-light" style="width: 1px; height: 53px; top: 37px; left: 23px; border-color: #000 !important;"></div> -->
                                        

                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="row g-0">
                                                                            
                                                                            <!-- timeline  -->
                                                                            <div class="col-1 position-relative d-flex flex-column flight--timeline z-3 overflow-hidden">

                                                                                <!-- <span class="d-inline-block position-absolute bg-light mb-2 me-4"> -->
                                                                                <span class="d-inline-block bg-light">
                                                                                    <svg class="bg-light" style="margin-top: 12px" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle></svg>
                                                                                    <!-- <svg class="bg-light" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle></svg> -->
                                                                                </span>
                                                                                <!-- <span class="d-inline-block position-absolute bg-light mb-2 me-4 bottom--timeline"> -->
                                                                                <span class="d-inline-block mt-auto bottom--timeline">
                                                                                    <!-- <svg class="bg-light" style="margin-bottom: 14px" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle></svg> -->
                                                                                    <svg class="bg-light" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle></svg>
                                                                                </span>
                                                                                
                                                                            </div>

                                                                            <div class="col">
                                                                                <div class="d-flex flex-wrap mt-2">
                                                                                    <div class="flight--ddt fw-bold d-flex align-items-center gap-2 flex-wrap">
                                                                                        <?=calendar_icon()?>
                                                                                        <span><?= date ('d M Y',strtotime($main_segments[$count_]->departure_date)); ?></span>
                                                                                        <?=time_icon()?>
                                                                                        <span class="me-3 d-flex align-items-center gap-2">
                                                                                        <?= date ('h:i a',strtotime($main_segments[$count_]->departure_time)); ?>
                                                                                        </span>
                                                                                    </div>
                                                        
                                                                                    <small class="d-sm-inline"><?=T::depart_from?> <b><?= $segment_collapse->departure_code ?></b> ( <?= $segment_collapse->departure_airport ?> ) </small>
                                                                                </div>

                                                                                <div class="mt-2 h6" style="font-size: 14px;">
                                                                                    <span><?=T::tripduration?></span>
                                                                                    <span><?= $segment_collapse->duration_time ?></span>
                                                                                </div>

                                                                                <div class="d-flex flex-wrap">
                                                                                    <div class="flight--ddt fw-bold d-flex align-items-center gap-2 flex-wrap">
                                                                                        <?=calendar_icon()?>
                                                                                        <span><?= date ('d M Y',strtotime($main_segments[$count_]->arrival_date)); ?></span>
                                                                                        <?=time_icon()?>
                                                                                        <span class="me-3 d-flex align-items-center gap-2">
                                                                                            <?= date ('h:i a',strtotime($main_segments[$count_]->arrival_time)); ?>
                                                                                        </span>
                                                                                    </div>
                                                                                    <small class="d-sm-inline"><?=T::arrive_at?> <b><?= $segment_collapse->arrival_code ?></b> ( <?= $segment_collapse->arrival_airport ?> )</small>
                                                                                </div>
                                                                            </div>

                                                                            
                                                                        </div>
                                                                    </div>


                                                               

                                                                    <div class="col-md-2 d-flex align-items-center mt-2 mt-md-0">
                                                                        <div class="form-check d-flex align-items-center gap-2 p-0">
                                                                            <input class="form-check-input m-0" type="radio" name="" id="" value="" checked>
                                                                            <label class="form-check-label" for="flight">
                                                                            <?=T::selected?>                        
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            
                                                            </div>
                                                           
                                                            <div class="flight--tco small--text d-flex flex-wrap mt-3 mb-3 text-muted fw-bold gap-2" style="font-size: 12px;">
                                                                <!-- <span class="border rounded-5 px-3 text-capitalize"><?=$s->type?></span> -->
                                                                <span class="border rounded-5 px-3 text-capitalize"><?=T::airline?> <strong class="text-dark"><?=$segment_collapse->airline?> - <?=$segment_collapse->flight_no?></strong></span>
                                                                <span class="border rounded-5 px-3 text-capitalize"><?=T::tripduration?> <strong class="text-dark"><?= $segment_collapse->duration_time ?></strong></span>
                                                                <span class="border rounded-5 px-3 text-capitalize"><?=T::flight_class?> <strong class="text-dark"><?=$_SESSION['flights_class']?></strong></span>
                                                                <?php if(!empty($segment_collapse->baggage)){ ?>
                                                                <span class="border rounded-5 px-3 text-capitalize"><?=T::baggage?> <strong class="text-dark"><?=$segment_collapse->baggage?></strong></span>
                                                                <?php } ?>

                                                                <?php if($segment_collapse->refundable==1){ ?>
                                                                <span class="border rounded-5 px-3 text-capitalize"><?=T::refundable?> </span>
                                                                <?php } else { ?>
                                                                <span class="border rounded-5 px-3 text-capitalize"><?=T::nonerefundable?></span>
                                                                <?php } ?>
                                                            </div>

                                                                <?php 
                                                                $count_++; } } ?>

                                                        </div>

                                                    </div>
                                                </div>
                                            </li>
                                        </form>
                                <?php } ?>
                        <?php } ?>
                    </ul>

                    <div class="listjs--pagination-container d-flex gap-1 items-center">
                        <button class="pag--nav prev--pag" type="button" data-add="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/>
                            </svg>
                        </button>
                        <ul class="pagination--listjs"></ul>
                        <button class="pag--nav next--pag" type="button" data-add="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 17l5-5-5-5M6 17l5-5-5-5"/>
                            </svg>
                        </button>
                    </div>
                    <!-- <div class="controls-pagination">
                    <div class="mixitup-page-list"></div>
                    <div class="mixitup-page-stats"></div>
                    </div> -->
                    <p class="fail-message"> <strong><?=T::noresultsfound ?></strong></p>

                    <!-- card section end  -->
                </div>

                <!-- right side end  -->
            </div>

            <!-- simple row end  -->
        </div>

        <!-- simple container end  -->
    </div>


    <!-- container fluid end  -->
    </div>

<script defer>
    // remove dupicate contents
    var seen = {};
    $(".remove_duplication").find("li").each(function(index, html_obj) { txt = $(this).text().toLowerCase();
        if(seen[txt]) { $(this).remove(); } else { seen[txt] = true; } });

    // when user click on more details button 
    function moreDetails(element) {
        $("body,html").animate({ scrollTop: $(element).parents("li.mix.all").offset().top - 90 }, 10);
    }
    
    // price range and filteration
    const $rangeA = $('[data-ref="range-slider-a"]');

    $rangeA.ionRangeSlider({
        skin: "round",
        type: "double",
        <?php
        // TO FIX RESULT VARIABLE ERROR
        if (empty($FLIGHTS_DATA[0])) {} else { ?>
        min: <?php foreach ($FLIGHTS_DATA as $index => $item) {$result[$index] = str_ireplace(',', '', $item->segments[0][0]->price); } echo min($result); ?>,
        max: <?php foreach ($FLIGHTS_DATA as $index => $item) {$result[$index] = str_ireplace(',', '', $item->segments[0][0]->price);} echo max($result); ?>,
        from: <?php foreach ($FLIGHTS_DATA as $index => $item) {$result[$index] = str_ireplace(',', '', $item->segments[0][0]->price);} echo min($result); ?>,
        to: <?php foreach ($FLIGHTS_DATA as $index => $item) {$result[$index] = str_ireplace(',', '', $item->segments[0][0]->price);} echo max($result); ?>,
        // onChange: handleRangeInputChange
        // onFinish: handleRangeInputChange
        onFinish: function(data) {
            minPrice = data.from;
            maxPrice = data.to;

            $("body,html").animate({ scrollTop: $("#flight--list-targets").offset().top - 250 }, 10);
            filterItems();
        }
        <?php } ?>
    });


    const instanceA = $rangeA.data("ionRangeSlider");

    var minPrice = instanceA.result.min;
    var maxPrice = instanceA.result.max;

    // filtered data 
    let currentStop = 'mix';

    // for selected checkboxes
    let checkedOnewayValue = [];
    let checkedReturnValue = [];


    // all filter controls 
    const stopControls = document.querySelectorAll(".stop--radio-filter > li > .form-check > input[type='radio']");
    const checkOnewayControl = document.querySelectorAll(".oneway--checkbox-filter > li > .form-check > input[type='checkbox']");
    const checkReturnControl = document.querySelectorAll(".return--checkbox-filter > li > .form-check > input[type='checkbox']");
    const orderControl = document.querySelectorAll(".uhf.sorting > ul.nav.nav-pills > li.nav-item > button.nav-link");


    // list js code 
    var options = {
        valueNames: [
            { data: ['all'] },
            { data: ['stop'] },
            { data: ['oneway'] },
            { data: ['price'] },
            { data: ['return'] }
        ],
        page: 25,
        pagination: true,
        pagination: [{
            paginationClass: "pagination--listjs",
            outerWindow: 1
        }]
    };

    var flightsList = new List("flights--list-js", options);

    // stop filter 
    stopControls.forEach(_stopFilter => {
        _stopFilter.addEventListener("click", function() {
            currentStop = this.value.replace(".", "");

            $("body,html").animate({ scrollTop: $("#flight--list-targets").offset().top - 250 }, 10);
            filterItems();
        });
    });


    // oneway filter 
    checkOnewayControl.forEach(_onewaychecked => {
        _onewaychecked.addEventListener("click", function() {

            checkedOnewayValue.length = 0;
            checkOnewayControl.forEach(_onewayCheckedItem => {
                if(_onewayCheckedItem.checked) { checkedOnewayValue.push(_onewayCheckedItem.value.replace(".", "")) }
            })

            $("body,html").animate({ scrollTop: $("#flight--list-targets").offset().top - 250 }, 10);

            filterItems();
            
        });
        
    });
    
    flightsList.sort("price", {
            order: 'asc'
    });
    // order button 
    orderControl.forEach(_orderBtn => {
        _orderBtn.addEventListener("click", function() {
            const _order = this.getAttribute("data-value");

            flightsList.sort("price", {
                order: _order
            });

        });
    });

    // return filter 
    checkReturnControl.forEach(_returnChecked => {
        _returnChecked.addEventListener("click", function() {

            checkedReturnValue.length = 0;
            checkReturnControl.forEach(_returnCheckedItem => {
                if(_returnCheckedItem.checked) { checkedReturnValue.push(_returnCheckedItem.value.replace(".", "")) }
            })

            $("body,html").animate({ scrollTop: $("#flight--list-targets").offset().top - 250 }, 10);
            filterItems();

        })

    });

    
    // filter the items 
    function filterItems() {
        flightsList.filter(function (item) {
            if(currentStop == "mix" && checkedOnewayValue.length > 0 && checkedReturnValue.length > 0) {
                return (
                    ( checkedOnewayValue.indexOf(item.values().oneway) > -1) &&
                    ( checkedReturnValue.indexOf(item.values().return) > -1) &&
                    ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                );
            } else if(currentStop == "mix" && checkedOnewayValue.length > 0) {
                return (
                    ( checkedOnewayValue.indexOf(item.values().oneway) > -1) &&
                    ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                );
            } else if(currentStop == "mix" && checkedReturnValue.length > 0) {
                return (
                    ( checkedReturnValue.indexOf(item.values().return) > -1) &&
                    ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                );
            } else if(checkedOnewayValue.length > 0 && checkedReturnValue.length > 0) {
                return (
                        ( checkedOnewayValue.indexOf(item.values().oneway) > -1) &&
                        ( checkedReturnValue.indexOf(item.values().return) > -1) &&
                        (item.values().stop == currentStop ) && 
                        ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                    );
            } else if(checkedOnewayValue.length > 0) {
                return (
                        ( checkedOnewayValue.indexOf(item.values().oneway) > -1) &&
                        (item.values().stop == currentStop ) && 
                        ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                    );
            } else if(checkedReturnValue.length > 0) {
                return (
                        ( checkedReturnValue.indexOf(item.values().return) > -1) &&
                        (item.values().stop == currentStop ) && 
                        ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                    );
            } else if(currentStop == "mix") {
                return (
                    (item.values().all == "oneway_all" ) && 
                    ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                );
            }else {
                return (
                    (item.values().stop == currentStop ) &&
                    ( parseFloat(item.values().price) >= minPrice && parseFloat(item.values().price) <= maxPrice)
                )
            }
        
        });

    }

    flightsList.on("updated", function(list) {
        clearTimeout(filterAnimation);

        list.visibleItems.forEach(_item => {
            _item.elm.classList.add("filter--animation")
        })

        clearTimeout(filterAnimation);
        var filterAnimation = setTimeout(() => {
            list.visibleItems.forEach(_item => {
                _item.elm.classList.remove("filter--animation")
            })
        }, 200);

        // document.querySelector("h2.new-main-tit.mx-2 > span.j_listABTit").textContent = `${list.visibleItems.length} Flights Found`;

        if(list.visibleItems.length === 0) { 
            // hiding pagination 
            $(".listjs--pagination-container").attr("style", "display: none !important");
            
            
            // show error message 
            document.querySelector(".fail-message").style.display = "block";
            document.querySelector(".fail-message").classList.add("filter--animation");
            
            clearTimeout(failFilterAnimation);
            var failFilterAnimation = setTimeout(() => {
                document.querySelector(".fail-message").classList.remove("filter--animation");
            }, 200);
        } else {
            // showing pagination 
            $(".listjs--pagination-container").attr("style", "display: ");
            
            // hiding wrror message 
            document.querySelector(".fail-message").style.display = "none"; 
        }
    });

    // pagination navigation 
    document.querySelectorAll(".pag--nav").forEach(_pagNavBtn => {
        _pagNavBtn.addEventListener("click", function() {
           const _activePage = parseInt( document.querySelector(".listjs--pagination-container > .pagination--listjs > li.active > a").getAttribute("data-i") );
           const _toAdd = parseInt( this.getAttribute("data-add") );
           
        //    sum 
           const _pageNumber = _activePage + _toAdd;
           
           //    get the next element if exist 
           const _getNextElement = document.querySelector(`.listjs--pagination-container > .pagination--listjs > li > a[data-i="${_pageNumber}"]`);
           
           //  if exist trigger click
           if( _getNextElement ) {
            _getNextElement.click();
           }
        });
    });
    

</script>

<?php } ?>