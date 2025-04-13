
<!-- ================================
    START TOUR DETAIL AREA
================================= -->
<section class="tour-detail-area padding-bottom-90px">
    <?php if (!empty($hotel->name)) { ?>
    <div class="single-content-navbar-wrap menu section-bg" id="single-content-navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-content-nav" id="single-content-nav">
                        <ul>
                            <li><a data-scroll="description" href="#description" class="scroll-link active"><?=T::hotels_hoteldetails?></a></li>
                            <li><a data-scroll="availability" href="#availability" class="scroll-link"><?=T::hotels_rooms?></a></li>
                            <li><a data-scroll="amenities" href="#amenities" class="scroll-link"><?=T::amenities?></a></li>
                            <?php if (!empty($hotel->policy)) { ?> <li><a data-scroll="faq" href="#faq" class="scroll-link"><?=T::policy?></a></li><?php } ?>
                            <!--<li><a data-scroll="reviews" href="#reviews" class="scroll-link"><?=T::reviews?></a></li>-->
                            <li><a data-scroll="reviews" href="#map" class="scroll-link"><?=T::map?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end single-content-navbar-wrap -->
    <?php } ?>

    <div class="container">

<?php if (!empty($hotel->name)) { ?>
<div class="single-content-item my-4">
    <div class="row">
    <div class="col-md-7">
    <h3 class="title font-size-26"><?=$hotel->name?>
    <?php for ($i = 1; $i <= $hotel->stars; $i++) { ?>
    <div class="stars la la-star"></div>
    <?php } ?>
    </h3>

    <div class="d-flex align-items-center pt-2">
        <?php if (empty($hotel->location)) {} else { ?>
        <p class="mr-2"><?=$hotel->location?>, <?=$hotel->name?></p>
        <?php } ?>
        <div class="Clear"></div>
    </div>
    </div>

    <div class="col-md-2 bestvalue">
    <?php if (!empty($hotel->discount)) { ?>
    <img style="width:50px;background:transparent" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMCIgaGVpZ2h0PSIzNCIgdmlld0JveD0iMCAwIDMwIDM0Ij4KICAgIDxkZWZzPgogICAgICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iYSIgeDE9IjUwJSIgeDI9IjUwJSIgeTE9IjUwJSIgeTI9Ijk2LjElIj4KICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI0UwQjk1MyIvPgogICAgICAgICAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNCQTkxMTkiLz4KICAgICAgICA8L2xpbmVhckdyYWRpZW50PgogICAgICAgIDxsaW5lYXJHcmFkaWVudCBpZD0iYiIgeDE9IjUwJSIgeDI9IjUwJSIgeTE9IjEuNDI4JSIgeTI9Ijk2LjElIj4KICAgICAgICAgICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI0UwQjk1MyIvPgogICAgICAgICAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNCQTkxMTkiLz4KICAgICAgICA8L2xpbmVhckdyYWRpZW50PgogICAgPC9kZWZzPgogICAgPGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzKSI+CiAgICAgICAgICAgIDxwYXRoIGZpbGw9InVybCgjYSkiIGQ9Ik0yMS43NTYgMzAuMDY3bC00LjE5My0xLjU3Mi0yLjQyNiAzLjY0OS02LjE0OC0xOC4zNCA2LjYxOC0yLjE0NnoiIHRyYW5zZm9ybT0icm90YXRlKC00IDE1LjM3MiAyMS45KSIvPgogICAgICAgICAgICA8cGF0aCBmaWxsPSJ1cmwoI2EpIiBkPSJNMi41ODkgMzAuMDY3bDQuMTkzLTEuNTcyIDIuNDI1IDMuNjQ5IDYuMTUtMTguMzQtNi42Mi0yLjE0NnoiIHRyYW5zZm9ybT0icm90YXRlKDQgOC45NzMgMjEuOSkiLz4KICAgICAgICAgICAgPHBhdGggZmlsbD0idXJsKCNiKSIgc3Ryb2tlPSIjRkZGIiBzdHJva2Utd2lkdGg9Ii41IiBkPSJNMjQgMTIuMzc1YzAgMS4wNDQtMS43MzUgMS43OS0xLjk1MiAyLjc1OC0uMjg5Ljk3Ljg2OCAyLjUzNS4zNjIgMy40My0uNTA2Ljg5NC0yLjMxNC42Ny0zLjAzNiAxLjQxNi0uNzIzLjc0NS0uNTA3IDIuNjEtMS4zNzQgMy4xMy0uODY3LjUyMy0yLjMxMy0uNTk1LTMuMzI1LS4zNzItLjk0LjIyNC0xLjY2MyAyLjAxMy0yLjY3NSAyLjAxMy0xLjAxMiAwLTEuNzM1LTEuNzktMi42NzUtMi4wMTMtLjk0LS4yOTgtMi40NTguODk1LTMuMzI1LjM3M3MtLjY1LTIuMzg2LTEuMzc0LTMuMTMxYy0uNzIyLS43NDYtMi41My0uNTIyLTMuMDM2LTEuNDE3LS41MDYtLjg5NC41NzktMi4zODUuMzYyLTMuNDI5QzEuNzM1IDE0LjE2NCAwIDEzLjQyIDAgMTIuMzc1czEuNzM1LTEuNzkgMS45NTItMi43NThjLjI4OS0uOTctLjg2OC0yLjUzNS0uMzYyLTMuNDMuNTA2LS44OTQgMi4zMTQtLjY3IDMuMDM2LTEuNDE2LjcyMy0uNzQ2LjUwNy0yLjYxIDEuMzc0LTMuMTMxLjg2Ny0uNTIyIDIuMzEzLjU5NiAzLjMyNS4zNzNDMTAuMjY1IDEuNzg5IDEwLjk4OCAwIDEyIDBjMS4wMTIgMCAxLjczNSAxLjc5IDIuNjc1IDIuMDEzLjk0LjI5OCAyLjQ1OC0uODk1IDMuMzI1LS4zNzMuODY4LjUyMi42NSAyLjM4NiAxLjM3NCAzLjEzMS43MjIuNzQ2IDIuNTMuNTIyIDMuMDM2IDEuNDE3LjUwNi44OTQtLjU3OSAyLjM4NS0uMzYyIDMuNDI5LjIxNy44OTQgMS45NTIgMS43MTQgMS45NTIgMi43NTh6Ii8+CiAgICAgICAgICAgIDxlbGxpcHNlIGN4PSIxMiIgY3k9IjEyLjM3NSIgZmlsbD0iI0ZGRiIgcng9IjgiIHJ5PSI4LjI1Ii8+CiAgICAgICAgPC9nPgogICAgICAgIDxnIGZpbGw9IiNCQTkxMTkiPgogICAgICAgICAgICA8cGF0aCBkPSJNOS4wNjIgMTEuNTEzbDUuMjE0IDYuMzU2LTIuMzY1LTYuMzU2ek0xMi4zNzYgMTEuNTEzbDIuNTIgNi43NzIgMi41NjgtNi43NzJ6TTE1LjQ1NyAxOC4wMzRsNS4zNDgtNi41MjFIMTcuOTN6TTE4Ljc2NSA4LjA4NGgtMy4zNzNsMi4zMTMgMi43OTV6TTE3LjMxMSAxMS4wODRMMTQuOTMzIDguMjFsLTIuMzc3IDIuODc0ek0xNC40NzUgOC4wODRIMTEuMWwxLjA0NyAyLjgxNHpNMTAuNzM3IDguMzU1TDkgMTEuMDg0aDIuNzUxek0yMC44NjcgMTEuMDg0TDE5LjEzIDguMzUybC0xLjAzNiAyLjczMnoiLz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPgo=" alt="" />
    <p><?=$hotel->discount?> %</p>
    <p><strong><small>&nbsp;<?=T::discount?></small></strong></p>
    <?php } ?>
    </div>

    <div class="col-md-3">
    <div class="review-summary text-center p-1">
       <strong><h4 class="text-success"><strong><?=$hotel->stars?></strong><span> / 5 <i class="la la-thumbs-up"></i></span></h4></strong>
      <span><small><strong><?=T::excellentvalueformoney?></strong></small></span>
    </div>
    </div>
    </div>
</div>
<?php } ?>

<?php if (!empty($hotel->img)) { ?>
<div class="hero_slider">
<div class="row">

<?php
if (isset($hotel->img[0])) {
$hotel_img = $hotel->img[0];
?>
<div class="col-md-6 g-2 my-0">

<a class="btn theme-btn" style="position: absolute; bottom: 0;border:transparent" data-src="<?=$hotel->img[0]?>" data-fancybox="gallery">
<i class="la la-photo mr-2"></i> <?=T::morephotos?>
</a>

<?php foreach ($hotel->img as $img) { ?>
<a class="d-none" data-src="<?=$img?>"
data-fancybox="gallery"
data-caption=""
data-speed="700">
</a>
<?php } ?>

<img data-sizes="auto" data-src="<?= $hotel->img[0]?>" class="img-fluid lazyload" style="width:100%;" />

</div>

<?php $no_img = '<div class="col-md-6 g-0 slide_img">  <img src="'.api_url.'uploads/images/hotels/slider/thumbs/blank.jpg" class="img-fluid" /></div>'; ?>

<div class="col-md-6 g-4 my-0">
<div class="row slider_imgs">
<?php if (isset($hotel->img[1])) { ?>
<div class="col-md-6 g-0 slide_img"> <img src="<?=$hotel->img[1]?>" class="img-fluid lazyload" data-src="<?=$hotel->img[1]?>" data-fancybox="gallery" /></div>
<?php } else { echo $no_img; } ?>

<?php if (isset($hotel->img[2])) { ?>
<div class="col-md-6 g-0 slide_img"> <img src="<?=$hotel->img[2]?>" class="img-fluid lazyload" data-src="<?=$hotel->img[2]?>" data-fancybox="gallery" /></div>
<?php } else { echo $no_img; } ?>

<?php if (isset($hotel->img[3])) { ?>
<div class="col-md-6 g-0 slide_img"> <img src="<?=$hotel->img[3]?>" class="img-fluid lazyload" data-src="<?=$hotel->img[3]?>" data-fancybox="gallery" /></div>
<?php } else { echo $no_img; } ?>

<?php if (isset($hotel->img[4])) { ?>
<div class="col-md-6 g-0 slide_img"> <img src="<?=$hotel->img[4]?>" class="img-fluid lazyload" data-src="<?=$hotel->img[4]?>" data-fancybox="gallery" /></div>
<?php } else { echo $no_img; } ?>
</div>
</div>

<?php } else { $hotel_img = "";  ?>
<!--<div class="col-md-6 g-0 slide_img"> <img src="" class="img-fluid" /></div>-->
<?php } ?>

</div>
</div>
<?php } ?>

</div>

    <div class="single-content-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-content-wrap padding-top-10px">
                        <?php if (!empty($hotel->name)) { ?>
                        <div id="description" class="page-scroll">

                            <div class="section-block"></div>
                            <div class="single-content-item padding-top-30px padding-bottom-10px">
                                <h3 class="title font-size-20"><?=T::about?> <?=$hotel->name?></h3>
                                <?php if (empty($hotel->desc)) {} else { ?>
                                <p class="py-3"><?=$hotel->desc?></p>
                                <?php } ?>
                            </div>
                            <!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div><!-- end description -->
                        <?php } ?>


                        <?php 
                        
                        // dd($hotel->rooms);

                        if (!empty($hotel->rooms)) { ?>
                        <div id="availability" class="page-scroll">

                            <div class="section-heading mt-3 mb-3">
                            <h3 class="sec__title_left left-line"><?=T::hotels_availablerooms?></h3>
                            </div>

                            <div class="single-content-item padding-top-40px padding-bottom-30px rooms">
                                <?php foreach ($hotel->rooms as $index => $room) { ?>
                                <div class="card mb-4">
                                <div class="card-header default">
                                <strong><?=$room->name?></strong>
                                </div>
                                <div class="card-body">

                                <div class="row">
                                <div class="col-md-3">
                                <?php

                                if (!isset($room->img[0])) { ?>
                                <img data-expand="-20" data-src="<?=root?>app/themes/default/assets/img/data/hotel.jpg" alt="image" class="img-fluid lazyload" style="max-height: 178px; width: 100%;cursor:pointer">
                                <?php } else {?>
                                <img data-expand="-20" data-src="<?=$room->img[0]?>" alt="image" class="img-fluid room_img lazyload" data-fancybox="rooms_<?=$index?>">
                                <?php } ?>

                                <?php
                                foreach ($room->img as $img) { ?>
                                <a class="d-none" data-src="<?=$img?>"
                                data-fancybox="rooms_<?=$index?>"
                                data-caption=""
                                data-speed="700">
                                </a>
                                <?php } ?>

                                </div>

                                <div class="col-md-9">

                                <form action="<?=root?>hotels/booking" method="POST">
                                <?php foreach ($room->options as $rms){
                                // dd($rms);
                                ?>
                                <div class="row g-0">

                                <div class="col-md-4">
                                <p><strong><?=T::amenities?></strong></p>
                                <div class="borders d-grid">
                                <?php  $i = 0;  $items = $room->amenities; shuffle($items); foreach ($items as $it) { if (++$i == 7) break; ?>
                                <p class="hotels_amenities"><i class="la la-check me-2"></i> <?=$it->name?></p>
                                <?php } ?>
                                <!--<p><i class="la la-info-circle me-2"></i> <small><strong><?=T::showmore?></strong></small></p>-->
                                </div>
                                </div>

                                <div class="col-md-3">
                                <p><strong><?=T::max_guests?></strong></p>

                                <div class="borders flexcenter">
                                <div class="row">
                                <div class="col-md-12 responsive-column">
                                <div class="single-tour-feature d-flex align-items-center mb-3">
                                        <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-2">
                                            <i class="la la-user"></i>
                                        </div>
                                        <div class="single-feature-titles">
                                            <h3 class="title font-size-15 font-weight-medium"><?=T::adults?> <?=$rms->adults?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 responsive-column">
                                    <div class="single-tour-feature d-flex align-items-center">
                                        <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-2">
                                            <i class="la la-female"></i>
                                        </div>
                                        <div class="single-feature-titles">
                                            <h3 class="title font-size-15 font-weight-medium"><?=T::child?> <?=$rms->child?></h3>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>

                                </div>

                                <?php
                                // if price by travellers 
                                if ($rms->price_type == "1"){ 
                                    
                                $adults_price = $adults * $rms->room_adult_price;
                                $childs_price = $childs * $rms->room_child_price;

                                $travellers_price = $adults_price + $childs_price;

                                // check if agent is login
                                if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "agent") { 
                                
                                $price_b2b = ($rms->b2b_markup / 100) * $travellers_price;
                                $price = $price_b2b + $travellers_price;

                                }
                                } else { 
                                    
                                $price_b2c = ($rms->b2c_markup / 100) * $travellers_price;
                                $price = $price_b2c + $travellers_price;

                                }

                                // check if customer is login
                                if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "customers") { 
                                
                                $price_b2c = ($rms->b2c_markup / 100) * $travellers_price;
                                $price = $price_b2c + $travellers_price;

                                } }


                                }

                                // if price fixed by night
                                else {

                                // check if agent is login
                                if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "agent") { $price = $rms->b2b_price; }
                                } else { $price = $rms->b2c_price; }

                                // check if customer is login
                                if(isset($_SESSION["user_type"])) { if ($_SESSION["user_type"] == "customers") { $price = $rms->b2c_price; } 
                                }
                                
                                } 

                                ?>

                                <div class="col-md-2">
                                <p><strong><?=T::price?>
    
                                </strong></p>
                                <div class="borders d-grid">
                                <p class="text-uppercase font-size-14"><!--<?=T::pernight?>--><strong class="mt-n1 text-black font-size-18 font-weight-black d-block"><?=$currency?> <?=number_format( $price,2); //will give you string(4) "1.00" ?></strong></p>

                                <?php 
                                // remove option if price by travellers 
                                if ($rms->price_type == 0){ 

                                if ($rms->quantity == "") { } else { ?>
                                <p class="mt-1"><small><?=T::hotels_noofrooms?></small></p>
                                <select name="room_quantity" class="form-select" style="font-size:11px">
                                <?php for ($i = 1; $i <= $rms->quantity; $i++){ ?>
                                <option class="" value="<?=$i?>"><?=$i?> - <?=$currency?> <?=$i * $price ?></option>
                                <?php } ?>
                                </select>
                                <?php } } ?>
                                
                                <small>
                                <?php if ($rms->price_type == 1){ ?>
                                <input name="room_quantity" type="hidden" value="1" />
                                <p style="line-height:1"> <?=$adults .' '. T::hotels_adults ?> <strong class="d-block"><?=$currency .' '. $adults * $rms->room_adult_price ?></strong></p>
                                <hr>
                                <p style="line-height:1"> <?=$childs .' '. T::hotels_childs ?> <strong class="d-block"><?=$currency .' '. $childs * $rms->room_child_price?></strong></p>
                                <?php } ?>
                                </small>

                                </div>
                                </div>
                                <div class="col-md-3">
                                <p><strong>&nbsp;</strong></p>

                                <?php
                                if (isset($hotel->hotel_phone)) { $hotel_phone = $hotel->hotel_phone; } else { $hotel_phone = ""; }
                                if (isset($hotel->hotel_email)) { $hotel_email = $hotel->hotel_email; } else { $hotel_email = ""; }
                                if (isset($hotel->hotel_website)) { $hotel_website = $hotel->hotel_website; } else { $hotel_website = ""; }

                                // $price = number_format( $rms->price,2);
                                $real_price = number_format( $rms->real_price,2);

                                // to fix hotel image bug
                                if (isset($hotel_img)){ $hotel_img = $hotel_img; } else { $hotel_img ="";  }

                                // take travellers from session
                                if ($rms->price_type == "1"){ 
                                    $adults_numb = $adults;
                                    $childs_numb = $childs;
                                } else {
                                    $adults_numb = $rms->adults;
                                    $childs_numb = $rms->child; 
                                }

                                $payload = [
                                "supplier_name" => $hotel->supplier_name,
                                "hotel_id" => $hotel->id,
                                "hotel_name" => $hotel->name,
                                "hotel_img" => $hotel_img,
                                "hotel_address" => $hotel->location . "&nbsp;" . $hotel->address,
                                "hotel_stars" => $hotel->stars,
                                "room_id" => $room->id,
                                "room_type" => $room->name,
                                "currency" => $currency,
                                "room_price" => $price,
                                "real_price" => $real_price,
                                "checkin" => $checkin,
                                "checkout" => $checkout,
                                "adults" => $adults_numb,
                                "childs" => $childs_numb,
                                "supplier" => $supplier,
                                "nationality" => $nationality,
                                "tax_type" => $hotel->tax_type,
                                "tax" => $hotel->tax_amount,
                                "deposit_type" => $hotel->deposit_type,
                                "deposit_amount" => $hotel->deposit_amount,
                                "country_code" => $country_code,
                                "city_code" => $city_code,
                                "city_name" => $city,
                                "latitude" => $hotel->latitude,
                                "longitude" => $hotel->longitude,
                                "bookingKey" => $rms->bookingKey,
                                "hotel_phone" => $hotel_phone,
                                "hotel_email" => $hotel_email,
                                "hotel_website" => $hotel_website,
                                "children_ages" => $rms->children_ages,
                                ];
                                ?>

                                <input name="payload" type="hidden" value="<?php echo base64_encode(json_encode($payload)) ?>">
                                <div class="borders p-4" style="display: flex; justify-content: center; align-items: center;background: #f2f4f6;flex-wrap: wrap;">
                                <div class="row">

                                <?php if (isset($_SESSION['user_login']) == true OR $app->app->restrict_website == false ) { ?>
                                <button type="submit" class="effect ladda effect" data-style="zoom-in">
                                <span class="ladda-label"><i class="la la-basket"></i> <?=T::booknow?></span>
                                </button>
                                <?php } else { ?>
                                <a href="<?=root?>login" class="effect ladda effect d-grid gap-2 text-center">
                                <span class="ladda-label"><i class="la la-basket"></i> <?=T::login_to_book?></span>
                                </a>
                                <p><small style="display: inline-block; line-height: 18px; font-size: 10px;" class="text-danger"><?=T::only_registered_users_book?></small></p>
                                <?php } ?>

                                <style>
                                .break { flex-basis: 100%; height: 0; }
                                </style>

                                <!--<div class="custom-checkbox mt-4">
                                <input type="checkbox" id="select">
                                <label for="select" class=""><?=T::select?></label>
                                </div>-->
                                </div>

                                 <?php
                                 if (!empty($room->refundable)) {
                                 if ($room->refundable == "Yes" ) { ?>
                                 <div class="break"></div>
                                 <div class="py-2" style="display:flex;font-size: 12px;justify-content: space-between;font-weight: bold;flex-wrap: wrap;">
                                 <p class="text-success"><i class="la la-refresh me-2"></i> <?=T::refundable?></p> &nbsp;&nbsp;
                                 <p><i class="fa fa-clock"></i> <?=$room->refundable_date?></p>
                                 </div>
                                 <?php } } ?>

                                </div>
                                </div>
                                </div>

                                <?php } ?>
                                </form>
                                </div>
                                </div>

                                </div><!-- end cabin-type -->
                                </div><!-- end cabin-type -->
                                <?php } ?>

                            </div><!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div><!-- end location-map -->
                        <?php } else { ?>
                        <div class="card-body alert-danger mt-5" role="alert">
                        <p><i class="la la-info-circle"></i> <?=T::noroomsavailabletrydifferentdates?></p>
                        </div>

                        <?php require_once 'search.php';?>
                        <?php } ?>

                        <?php if (!empty($hotel->amenities)) { ?>
                        <div id="amenities" class="page-scroll">
                            <div class="single-content-item padding-top-40px padding-bottom-20px">
                                <h3 class="title font-size-20"><?=T::hotels_hotel?> <?=T::amenities?></h3>
                                <div class="amenities-feature-item pt-4">
                                    <div class="row">
                                    <?php foreach ($hotel->amenities as $index => $item) { ?>
                                    <div class="col-lg-4 responsive-column">
                                        <div class="single-tour-feature d-flex align-items-center mb-3">
                                            <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                <?php if (empty($item->icon)) { ?>
                                                <i class="la la-check"></i>
                                                <?php } ?>
                                                <img src="<?=$item->icon?>" alt="" style="max-width:20px" />
                                            </div>
                                            <div class="single-feature-titles">
                                                <h3 class="title font-size-15 font-weight-medium"><?=$item->name?></h3>
                                                <!--<span class="font-size-13">4 Star</span>-->
                                            </div>
                                        </div><!-- end single-tour-feature -->
                                    </div><!-- end col-lg-4 -->
                                    <?php } ?>
                                    </div><!-- end row -->
                                </div>
                            </div><!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div><!-- end faq -->
                        <?php } ?>

                        <?php if (!empty($hotel->policy)) { ?>
                        <div id="faq" class="page-scroll">
                            <div class="single-content-item padding-top-40px padding-bottom-40px">
                                <h3 class="title font-size-20"><?=T::policy?></h3>
                                <div class="accordion accordion-item padding-top-30px" id="accordionExample2">
                                 <p><?=$hotel->policy?></p>
                                </div>
                            </div><!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div><!-- end faq -->
                        <?php } ?>

                        <?php if (empty($hotel->payment_option)) { } else { ?>
                        <div id="payment" class="page-scroll">
                            <div class="single-content-item padding-top-40px padding-bottom-20px">
                                <h3 class="title font-size-20"><?=T::paymentoptions?></h3>
                                <div class="amenities-feature-item pt-4">
                                    <div class="row">
                                    <?php foreach ($hotel->payment_option as $index => $item) { ?>
                                    <div class="col-lg-3 responsive-column">
                                        <div class="single-tour-feature d-flex align-items-center mb-3">
                                            <div class="single-feature-icon icon-element ml-0 flex-shrink-0 mr-3">
                                                <i class="la la-check"></i>
                                            </div>
                                            <div class="single-feature-titles">
                                                <h3 class="title font-size-15 font-weight-medium"><?=$item->name?></h3>
                                                <!--<span class="font-size-13">4 Star</span>-->
                                            </div>
                                        </div><!-- end single-tour-feature -->
                                    </div><!-- end col-lg-4 -->
                                    <?php } ?>
                                    </div><!-- end row -->
                                </div>
                            </div><!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div><!-- end faq -->
                        <?php } ?>

                        <?php if (!empty($hotel->longitude)) { ?>
                        <div id="map" class="page-scroll">
                            <div class="single-content-item padding-top-40px padding-bottom-20px">
                                <h3 class="title font-size-20"><?=T::hotels_hotelmap?></h3>
                                <div class="amenities-feature-item pt-4">
                                    <div class="row">
                                     <iframe src="https://maps.google.com/maps?q=<?=$hotel->longitude?>,<?=$hotel->latitude?>&z=15&output=embed" width="100%" height="270" frameborder="0" style="border:0"></iframe>
                                    </div><!-- end row -->
                                </div>
                            </div><!-- end single-content-item -->
                            <div class="section-block"></div>
                        </div><!-- end faq -->
                        <?php } ?>

                    </div><!-- end single-content-wrap -->
                </div><!-- end col-lg-8 -->

            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end single-content-box -->
</section><!-- end tour-detail-area -->
<!-- ================================
    END TOUR DETAIL AREA
================================= -->

<div class="section-block"></div>

<?php if (empty($_SESSION['related_hotels'])) { } else { ?>
<!-- ================================
  related AREA
  ================================= -->
<section class="hotel-area section-bg section-padding overflow-hidden padding-right-100px padding-left-100px">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading text-center">
          <h2 class="sec__title line-height-55 bottom-line"><?=T::youmightalsolike?></h2>
        </div>
      </div>
    </div>
    <div class="row padding-top-50px">
      <div class="col-lg-12">
        <div class="hotel-card-wrap">
          <div class="hotel-card-carousel carousel-action">
            <?php
              shuffle($_SESSION['related_hotels']);
              foreach ($_SESSION['related_hotels'] as $index => $related) { if ($index < 15) {
              $link = root.$session_lang.'/'.strtolower($currency).'/hotel/'.strtolower(str_replace(' ', '-', $city)).'/'.strtolower(str_replace(" ", "-", $related->name)).'/'.$related->hotel_id.'/'.$checkin.'/'.$checkout.'/'.$rooms.'/'.$adults.'/'.$childs.'/'.$related->supplier.'/'.$nationality.'/'.strtoupper($related->country_code).'/'.$related->city_code; ?>
            <div class="card-item mb-0">
              <div class="card-img">
                <a href="<?=$link?>" class="d-block">
                <img src="<?=$related->img?>" alt="hotel-img" style="height:200px">
                </a>
                <?php if(!empty($hotels->discount)){ ?>
                <span class="badge"> <?= $hotels->discount ?> % <?=T::discount?> </span>
                <?php } ?>
              </div>
              <div class="card-body">
                <h3 class="card-title"><a href="<?=$link?>"><?=$related->name?></a></h3>
                <p class="card-meta"><?=$related->location?></p>
                <div class="card-rating" style="height:60px">
                 <?php if (empty($related->rating)) {} else { ?>
                  <span class="badge text-white"><?=$related->rating?></span>
                  <span class="review__text">
                    <?php for ($i = 1; $i <= $related->rating; $i++) { ?>
                    <div class="stars la la-star"></div>
                    <?php } ?>
                  </span>
                  <?php } ?>
                </div>
                <div class="card-price d-flex align-items-center justify-content-between">
                  <p>
                    <span class="price__num"><?=$currency?> <?=$related->price?></span>
                    <span class="price__text"><?=T::price?> </span>
                  </p>
                  <a href="<?=$link?>" class="btn-text"><?=T::details?> <i class="la la-angle-right"></i></a>
                </div>
              </div>
            </div>
            <?php } } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>

<script src="<?=root.theme_url?>assets/js/navbar-sticky.js"></script>
<style>
.form-control, .form-select{min-height:36px}
</style>