<!-- ================================
    START HERO-WRAPPER AREA
================================= -->
<section class="hero-wrapper">

        <?php  if ($sliderInfo->totalSlides > 0) {
            foreach ($sliderInfo->slides as $ms) { ?>
            <div class="hero-box hero-bg <?php echo $ms->sactive; ?>" style="background-image: url(<?php echo $ms->thumbnail; ?>);">
            <?php }  } else { ?>
            <div class="hero-box hero-bg" style="background-image: url(<?php echo $theme_url; ?>assets/img/data/slider.jpg);">
        <?php } ?>

        <!--<span class="line-bg line-bg1"></span>
        <span class="line-bg line-bg2"></span>
        <span class="line-bg line-bg3"></span>
        <span class="line-bg line-bg4"></span>
        <span class="line-bg line-bg5"></span>
        <span class="line-bg line-bg6"></span>-->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto responsive--column-l">
                    <div class="hero-content pb-4 ">
                        <div class="section-heading">
                            <h2 class="sec__titles cd-headline zoom d-none d-sm-block" style="color:#fff">
                                <?php echo $ms->title; ?> <span class="cd-words-wrapper">
                                <b class="is-visible">Tours</b>
                                <b>Adventures</b>
                                <b>Flights</b>
                                <b>Hotels</b>
                                <b>Cars</b>
                                <b>Cruises</b>
                                <b>Package Deals</b>
                                <b>Fun</b>
                                <b>People</b>
                                </span>
                               <?php echo $ms->desc; ?>
                            </h2>
                        </div>
                    </div><!-- end hero-content -->
                    <div class="section-tab text-center">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                          <?php include 'menu.php'; ?>

                            <!--<li class="nav-item">
                                <a class="nav-link d-flex align-items-center" id="hotel-tab" data-toggle="tab" href="#hotel" role="tab" aria-controls="hotel" aria-selected="false">
                                    <i class="la la-hotel mr-1"></i>Hotels
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" id="package-tab" data-toggle="tab" href="#package" role="tab" aria-controls="package" aria-selected="false">
                                    <i class="la la-shopping-bag mr-1"></i>Vacation Packages
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" id="car-tab" data-toggle="tab" href="#car" role="tab" aria-controls="car" aria-selected="true">
                                    <i class="la la-car mr-1"></i>Cars
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" id="cruise-tab" data-toggle="tab" href="#cruise" role="tab" aria-controls="cruise" aria-selected="false">
                                    <i class="la la-ship mr-1"></i>Cruises
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" id="tour-tab" data-toggle="tab" href="#tour" role="tab" aria-controls="tour" aria-selected="false">
                                    <i class="la la-globe mr-1"></i>Tours
                                </a>
                            </li>-->
                        </ul>
                    </div><!-- end section-tab -->
                    <div class="tab-content search-fields-container" id="myTabContent">
          
                            <?php  
                            $hotels =1; $flights =1; $tours =1; $cars =1; $visa =1; $cruise =1; $rental =1;
                            foreach ($modulesList as $index => $module) {
                            if ($module->ia_active == 1 && $module->parent_id == 'hotels' && $hotels==1) { ?>
                            <div class="tab-pane fade <?php if ($order == $module->front_order) { echo "active show"; } ?>" id="hotels" role="tabpanel" aria-labelledby="hotels-tab">
                            <?php Search_Form($module->name,"hotels"); ?>
                            </div>
                            <?php $hotels++; }
                            if ($module->ia_active == 1 && $module->parent_id == 'flights' && $flights==1) { ?>
                            <!-- Flights  -->
                            <div class="tab-pane fade <?php if ($order == $module->front_order) { echo "active show"; } ?>" id="flights" role="tabpanel" aria-labelledby="flights-tab">
                            <?php Search_Form($module->name,"flights"); ?>
                            </div>
                            
                            <?php $flights++; } if ($module->ia_active == 1 && $module->parent_id == 'cars' && $cars == 1) { ?>
                            <!-- Cars  -->
                            <div role="tabpanel" class="tab-pane <?php if ($order == $module->front_order) { echo "active in show"; } ?>" id="cars" aria-labelledby="home-tab">
                            <?php if (isModuleActive('cars')) { ?><?php $module = 'cars'; ?><?php echo searchForm('cars', $data); ?><?php } ?>
                            </div>

                            <?php $cars++;} if ($module->ia_active == 1 && $module->parent_id == 'tours' && $tours == 1) { ?>
                            <!-- Tours  -->
                            <div role="tabpanel" class="tab-pane <?php if ($order == $module->front_order) { echo "active in show";
                            } ?>" id="tours" aria-labelledby="home-tab">
                            <?php if (isModuleActive('tours')) { ?><?php $module = 'tours'; ?><?php echo searchForm('tours', $data); ?><?php } ?>
                            </div>

                            <?php $tours++;} if ($module->ia_active == 1 && $module->parent_id == 'rental'&& $rental==1) { if($module->name == 'Rentals'){ ?>
                            <div role="tabpanel" class="tab-pane <?php if ($order == $module->front_order) {
                            echo "active in show";
                            } ?>" id="rentals" aria-labelledby="home-tab">
                            <?php if (isModuleActive('rentals')) { ?><?php $module = 'rentals'; ?><?php echo searchForm('rentals', $data); ?><?php } ?>
                            </div>

                            <?php } $rental++;} if ($module->ia_active == 1 && $module->parent_id == 'cruise' && $cruise==1) { if($module->name == 'Boats'){ ?>
                            <div role="tabpanel" class="tab-pane <?php if ($order == $module->front_order) {
                            echo "active in show";
                            } ?>" id="boats" aria-labelledby="home-tab">
                            <?php if (isModuleActive('boats')) { ?><?php $module = 'boats'; ?><?php echo searchForm('boats', $data); ?><?php } ?>
                            </div>

                            <?php } $cruise++; } if ($module->ia_active == 1 && $module->parent_id == 'visa' && $visa==1) { ?>
                            <!-- Visa -->
                            <div role="tabpanel" class="tab-pane <?php if ($order == $module->front_order) { echo "active in show"; } ?>" id="visa" aria-labelledby="home-tab">
                            <?php if (isModuleActive('ivisa')) { ?><?php echo searchForm('ivisa', $data); ?><?php } ?>
                            </div>
                            <?php $visa++; }
                            } ?>
                      
                        <div class="tab-pane fade" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                            <div class="contact-form-action">
                                <form action="#" class="row align-items-center">
                                    <div class="col-lg-3 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Destination / Hotel name</label>
                                            <div class="form-group">
                                                <span class="la la-map-marker form-icon"></span>
                                                <input class="form-control" type="text" placeholder="Enter city or property">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-3 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Check in</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-3 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Check out</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-3">
                                        <div class="input-box">
                                            <label class="label-text">Guests and Rooms</label>
                                            <div class="form-group">
                                                <div class="dropdown dropdown-contain">
                                                    <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                        <span>Guests <span class="qtyTotal guestTotal">0</span></span>
                                                        <span class="hiphens font-size-20 mx-1">-</span>
                                                        <span>Rooms <span class="roomTotal">0</span></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-wrap">
                                                        <div class="dropdown-item">
                                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                                <label>Rooms</label>
                                                                <div class="roomBtn d-flex align-items-center">
                                                                    <input type="text" name="roomInput" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                                <label>Adults</label>
                                                                <div class="qtyBtn d-flex align-items-center">
                                                                    <input type="text" name="qtyInput" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                                <label>Children</label>
                                                                <div class="qtyBtn d-flex align-items-center">
                                                                    <input type="text" name="qtyInput" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end dropdown -->
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                </form>
                            </div>
                            <div class="btn-box">
                                <a href="hotel-search-result.html" class="theme-btn">Search Now</a>
                            </div>
                        </div><!-- end tab-pane -->
                        <div class="tab-pane fade" id="package" role="tabpanel" aria-labelledby="package-tab">
                            <div class="section-tab section-tab-2 pb-3">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="flight-hotel-tab" data-toggle="tab" href="#flight-hotel" role="tab" aria-controls="flight-hotel" aria-selected="true">
                                            Flight + Hotel
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="flight-hotel-car-tab" data-toggle="tab" href="#flight-hotel-car" role="tab" aria-controls="flight-hotel-car" aria-selected="false">
                                            Flight + Hotel + Car
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="flight-car-tab" data-toggle="tab" href="#flight-car" role="tab" aria-controls="flight-car" aria-selected="false">
                                            Flight + Car
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="hotel-car-tab" data-toggle="tab" href="#hotel-car" role="tab" aria-controls="hotel-car" aria-selected="true">
                                            Hotel + Car
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- end section-tab -->
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="flight-hotel" role="tabpanel" aria-labelledby="flight-hotel-tab">
                                    <div class="contact-form-action">
                                        <form action="#" class="row align-items-center">
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Flying from</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input class="form-control" type="text" placeholder="City or airport">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Flying to</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input class="form-control" type="text" placeholder="City or airport">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Departing - Returning</label>
                                                    <div class="form-group">
                                                        <span class="la la-calendar form-icon"></span>
                                                        <input class="date-range form-control" type="text" name="daterange" value="04/28/2020">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3">
                                                <div class="input-box">
                                                    <label class="label-text">Guests and Rooms</label>
                                                    <div class="form-group">
                                                        <div class="dropdown dropdown-contain">
                                                            <a class="dropdown-toggle dropdown-btn" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                                                <span>Guests <span class="qtyTotal guestTotal_5">0</span></span>
                                                                <span class="hiphens font-size-20 mx-1">-</span>
                                                                <span>Rooms <span class="roomTotal roomTotal_2">0</span></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-wrap">
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Rooms</label>
                                                                        <div class="roomBtn d-flex align-items-center">
                                                                            <input type="text" name="roomInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Adults</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Children</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- end dropdown -->
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                        </form>
                                    </div>
                                    <div class="checkmark-wrap">
                                        <div class="custom-checkbox d-inline-block mb-0 mr-3">
                                            <input type="checkbox" id="directFlightChb">
                                            <label for="directFlightChb">Direct flights only</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mb-0">
                                            <input type="checkbox" id="onlyHotelChb">
                                            <label for="onlyHotelChb">I only need a hotel for part of my stay</label>
                                        </div>
                                    </div><!-- end checkmark-wrap -->
                                    <div class="btn-box pt-3">
                                        <a href="activity-search-result.html" class="theme-btn">Search Now</a>
                                    </div>
                                </div><!-- end tab-pane -->
                                <div class="tab-pane fade" id="flight-hotel-car" role="tabpanel" aria-labelledby="flight-hotel-car-tab">
                                    <div class="contact-form-action">
                                        <form action="#" class="row align-items-center">
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Flying from</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input type="text" class="form-control" placeholder="City or airport">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Flying to</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input class="form-control" type="text" placeholder="City or airport">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Departing - Returning</label>
                                                    <div class="form-group">
                                                        <span class="la la-calendar form-icon"></span>
                                                        <input class="date-range form-control" type="text" name="daterange" value="04/28/2020">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3">
                                                <div class="input-box">
                                                    <label class="label-text">Guests and Rooms</label>
                                                    <div class="form-group">
                                                        <div class="dropdown dropdown-contain">
                                                            <a class="dropdown-toggle dropdown-btn" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                                                <span>Guests <span class="qtyTotal guestTotal_6">0</span></span>
                                                                <span class="hiphens font-size-20 mx-1">-</span>
                                                                <span>Rooms <span class="roomTotal roomTotal_3">0</span></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-wrap">
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Rooms</label>
                                                                        <div class="roomBtn d-flex align-items-center">
                                                                            <input type="text" name="roomInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Adults</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Children</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- end dropdown -->
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                        </form>
                                    </div>
                                    <div class="checkmark-wrap">
                                        <div class="custom-checkbox d-inline-block mb-0 mr-3">
                                            <input type="checkbox" id="directFlightChb2">
                                            <label for="directFlightChb2">Direct flights only</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mb-0">
                                            <input type="checkbox" id="onlyHotelChb2">
                                            <label for="onlyHotelChb2">I only need a hotel for part of my stay</label>
                                        </div>
                                    </div><!-- end checkmark-wrap -->
                                    <div class="btn-box pt-3">
                                        <a href="activity-search-result.html" class="theme-btn">Search Now</a>
                                    </div>
                                </div><!-- end tab-pane -->
                                <div class="tab-pane fade" id="flight-car" role="tabpanel" aria-labelledby="flight-car-tab">
                                    <div class="contact-form-action">
                                        <form action="#" class="row align-items-center">
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Flying from</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input class="form-control" type="text" placeholder="City or airport">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Flying to</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input class="form-control" type="text" placeholder="City or airport">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Departing - Returning</label>
                                                    <div class="form-group">
                                                        <span class="la la-calendar form-icon"></span>
                                                        <input class="date-range form-control" type="text" name="daterange" value="04/28/2020">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="input-box">
                                                    <label class="label-text">Passengers</label>
                                                    <div class="form-group">
                                                        <div class="dropdown dropdown-contain">
                                                            <a class="dropdown-toggle dropdown-btn" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                                                                <span>Passengers <span class="qtyTotal guestTotal_7">0</span></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-wrap">
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Adults</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Children</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Infants</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- end dropdown -->
                                                    </div>
                                                </div>
                                            </div>
                                        </form><!-- end row -->
                                    </div>
                                    <div class="checkmark-wrap">
                                        <div class="custom-checkbox d-inline-block mb-0">
                                            <input type="checkbox" id="directFlightChb3">
                                            <label for="directFlightChb3">Direct flights only</label>
                                        </div>
                                    </div><!-- end checkmark-wrap -->
                                    <div class="btn-box pt-3">
                                        <a href="activity-search-result.html" class="theme-btn">Search Now</a>
                                    </div>
                                </div><!-- end tab-pane -->
                                <div class="tab-pane fade" id="hotel-car" role="tabpanel" aria-labelledby="hotel-car-tab">
                                    <div class="contact-form-action">
                                        <form action="#" class="row align-items-center">
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Going to</label>
                                                    <div class="form-group">
                                                        <span class="la la-map-marker form-icon"></span>
                                                        <input class="form-control" type="text" placeholder="Enter City or property">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Check in - Check-out</label>
                                                    <div class="form-group">
                                                        <span class="la la-calendar form-icon"></span>
                                                        <input class="date-range form-control" type="text" name="daterange" value="04/28/2020">
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3 pr-0">
                                                <div class="input-box">
                                                    <label class="label-text">Room Type</label>
                                                    <div class="form-group">
                                                        <div class="select-contain w-auto">
                                                            <select class="select-contain-select">
                                                                <option value="0">Select Type</option>
                                                                <option value="1">Single</option>
                                                                <option value="2">Double</option>
                                                                <option value="3">Triple</option>
                                                                <option value="4">Quad</option>
                                                                <option value="5">Queen</option>
                                                                <option value="6">King</option>
                                                                <option value="7">Twin</option>
                                                                <option value="8">Double-double</option>
                                                                <option value="9">Studio</option>
                                                                <option value="10">Suite</option>
                                                                <option value="11">Mini Suite</option>
                                                                <option value="12">President Suite</option>
                                                                <option value="13">President Suite</option>
                                                                <option value="14">Apartments</option>
                                                                <option value="15">Connecting rooms</option>
                                                                <option value="16">Murphy Room</option>
                                                                <option value="17">Accessible Room</option>
                                                                <option value="18">Cabana</option>
                                                                <option value="19">Adjoining rooms</option>
                                                                <option value="20">Adjacent rooms</option>
                                                                <option value="21">Villa</option>
                                                                <option value="22">Executive Floor</option>
                                                                <option value="23">Smoking room</option>
                                                                <option value="24">Non-Smoking Room</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                            <div class="col-lg-3">
                                                <div class="input-box">
                                                    <label class="label-text">Guests and Rooms</label>
                                                    <div class="form-group">
                                                        <div class="dropdown dropdown-contain">
                                                            <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                                <span>Guests <span class="qtyTotal guestTotal_8">0</span></span>
                                                                <span class="hiphens font-size-20 mx-1">-</span>
                                                                <span>Rooms <span class="roomTotal roomTotal_4">0</span></span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-wrap">
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Rooms</label>
                                                                        <div class="roomBtn d-flex align-items-center">
                                                                            <input type="text" name="roomInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Adults</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="dropdown-item">
                                                                    <div class="qty-box d-flex align-items-center justify-content-between">
                                                                        <label>Children</label>
                                                                        <div class="qtyBtn d-flex align-items-center">
                                                                            <input type="text" name="qtyInput" value="0">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- end dropdown -->
                                                    </div>
                                                </div>
                                            </div><!-- end col-lg-3 -->
                                        </form>
                                    </div>
                                    <div class="btn-box pt-2">
                                        <a href="activity-search-result.html" class="theme-btn">Search Now</a>
                                    </div>
                                </div><!-- end tab-pane -->
                            </div>
                        </div><!-- end tab-pane -->
                        <div class="tab-pane fade" id="car" role="tabpanel" aria-labelledby="car-tab">
                            <div class="contact-form-action">
                                <form action="#" class="row align-items-center">
                                    <div class="col-lg-4 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Picking up</label>
                                            <div class="form-group">
                                                <span class="la la-map-marker form-icon"></span>
                                                <input class="form-control" type="text" placeholder="City, airport or address">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                    <div class="col-lg-4 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Pick-up date</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-box">
                                            <label class="label-text">Time</label>
                                            <div class="form-group">
                                                <div class="select-contain w-auto">
                                                    <select class="select-contain-select">
                                                        <option value="1200AM">12:00AM</option>
                                                        <option value="1230AM">12:30AM</option>
                                                        <option value="0100AM">1:00AM</option>
                                                        <option value="0130AM">1:30AM</option>
                                                        <option value="0200AM">2:00AM</option>
                                                        <option value="0230AM">2:30AM</option>
                                                        <option value="0300AM">3:00AM</option>
                                                        <option value="0330AM">3:30AM</option>
                                                        <option value="0400AM">4:00AM</option>
                                                        <option value="0430AM">4:30AM</option>
                                                        <option value="0500AM">5:00AM</option>
                                                        <option value="0530AM">5:30AM</option>
                                                        <option value="0600AM">6:00AM</option>
                                                        <option value="0630AM">6:30AM</option>
                                                        <option value="0700AM">7:00AM</option>
                                                        <option value="0730AM">7:30AM</option>
                                                        <option value="0800AM">8:00AM</option>
                                                        <option value="0830AM">8:30AM</option>
                                                        <option value="0900AM" selected>9:00AM</option>
                                                        <option value="0930AM">9:30AM</option>
                                                        <option value="1000AM">10:00AM</option>
                                                        <option value="1030AM">10:30AM</option>
                                                        <option value="1100AM">11:00AM</option>
                                                        <option value="1130AM">11:30AM</option>
                                                        <option value="1200PM">12:00PM</option>
                                                        <option value="1230PM">12:30PM</option>
                                                        <option value="0100PM">1:00PM</option>
                                                        <option value="0130PM">1:30PM</option>
                                                        <option value="0200PM">2:00PM</option>
                                                        <option value="0230PM">2:30PM</option>
                                                        <option value="0300PM">3:00PM</option>
                                                        <option value="0330PM">3:30PM</option>
                                                        <option value="0400PM">4:00PM</option>
                                                        <option value="0430PM">4:30PM</option>
                                                        <option value="0500PM">5:00PM</option>
                                                        <option value="0530PM">5:30PM</option>
                                                        <option value="0600PM">6:00PM</option>
                                                        <option value="0630PM">6:30PM</option>
                                                        <option value="0700PM">7:00PM</option>
                                                        <option value="0730PM">7:30PM</option>
                                                        <option value="0800PM">8:00PM</option>
                                                        <option value="0830PM">8:30PM</option>
                                                        <option value="0900PM">9:00PM</option>
                                                        <option value="0930PM">9:30PM</option>
                                                        <option value="1000PM">10:00PM</option>
                                                        <option value="1030PM">10:30PM</option>
                                                        <option value="1100PM">11:00PM</option>
                                                        <option value="1130PM">11:30PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                </form>
                                <form action="#" class="row align-items-center">
                                    <div class="col-lg-4 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Drop-off</label>
                                            <div class="form-group">
                                                <span class="la la-map-marker form-icon"></span>
                                                <input class="form-control" type="text" placeholder="Same as pick-up">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                    <div class="col-lg-4 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Drop-off date</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-box">
                                            <label class="label-text">Time</label>
                                            <div class="form-group">
                                                <div class="select-contain w-auto">
                                                    <select class="select-contain-select">
                                                        <option value="1200AM">12:00AM</option>
                                                        <option value="1230AM">12:30AM</option>
                                                        <option value="0100AM">1:00AM</option>
                                                        <option value="0130AM">1:30AM</option>
                                                        <option value="0200AM">2:00AM</option>
                                                        <option value="0230AM">2:30AM</option>
                                                        <option value="0300AM">3:00AM</option>
                                                        <option value="0330AM">3:30AM</option>
                                                        <option value="0400AM">4:00AM</option>
                                                        <option value="0430AM">4:30AM</option>
                                                        <option value="0500AM">5:00AM</option>
                                                        <option value="0530AM">5:30AM</option>
                                                        <option value="0600AM">6:00AM</option>
                                                        <option value="0630AM">6:30AM</option>
                                                        <option value="0700AM">7:00AM</option>
                                                        <option value="0730AM">7:30AM</option>
                                                        <option value="0800AM">8:00AM</option>
                                                        <option value="0830AM">8:30AM</option>
                                                        <option value="0900AM" selected>9:00AM</option>
                                                        <option value="0930AM">9:30AM</option>
                                                        <option value="1000AM">10:00AM</option>
                                                        <option value="1030AM">10:30AM</option>
                                                        <option value="1100AM">11:00AM</option>
                                                        <option value="1130AM">11:30AM</option>
                                                        <option value="1200PM">12:00PM</option>
                                                        <option value="1230PM">12:30PM</option>
                                                        <option value="0100PM">1:00PM</option>
                                                        <option value="0130PM">1:30PM</option>
                                                        <option value="0200PM">2:00PM</option>
                                                        <option value="0230PM">2:30PM</option>
                                                        <option value="0300PM">3:00PM</option>
                                                        <option value="0330PM">3:30PM</option>
                                                        <option value="0400PM">4:00PM</option>
                                                        <option value="0430PM">4:30PM</option>
                                                        <option value="0500PM">5:00PM</option>
                                                        <option value="0530PM">5:30PM</option>
                                                        <option value="0600PM">6:00PM</option>
                                                        <option value="0630PM">6:30PM</option>
                                                        <option value="0700PM">7:00PM</option>
                                                        <option value="0730PM">7:30PM</option>
                                                        <option value="0800PM">8:00PM</option>
                                                        <option value="0830PM">8:30PM</option>
                                                        <option value="0900PM">9:00PM</option>
                                                        <option value="0930PM">9:30PM</option>
                                                        <option value="1000PM">10:00PM</option>
                                                        <option value="1030PM">10:30PM</option>
                                                        <option value="1100PM">11:00PM</option>
                                                        <option value="1130PM">11:30PM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                </form><!-- end row -->
                            </div>
                            <div class="advanced-wrap">
                                <a class="btn collapse-btn theme-btn-hover-gray font-size-15" data-toggle="collapse" href="#collapseSix" role="button" aria-expanded="false" aria-controls="collapseSix">
                                    Advanced options <i class="la la-angle-down ml-1"></i>
                                </a>
                                <div class="pt-3 collapse" id="collapseSix">
                                    <div class="row">
                                        <div class="col-lg-3 pr-0">
                                            <div class="input-box">
                                                <label class="label-text">Car type</label>
                                                <div class="form-group">
                                                    <div class="select-contain w-auto">
                                                        <select class="select-contain-select">
                                                            <option value="1">No preference</option>
                                                            <option value="2">Economy</option>
                                                            <option value="3">Compact</option>
                                                            <option value="4">Midsize</option>
                                                            <option value="5">Standard</option>
                                                            <option value="6">Fullsize</option>
                                                            <option value="7">Premium</option>
                                                            <option value="8">Luxury</option>
                                                            <option value="9">Convertible</option>
                                                            <option value="10">Minivan</option>
                                                            <option value="11">Sport Utility</option>
                                                            <option value="12">Sports car</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-3 -->
                                        <div class="col-lg-3 pr-0">
                                            <div class="input-box">
                                                <label class="label-text">Rental car company</label>
                                                <div class="form-group">
                                                    <div class="select-contain w-auto">
                                                        <select class="select-contain-select">
                                                            <option value="">No preference</option>
                                                            <option value="AC">ACE Rent A Car</option>
                                                            <option value="AD">Advantage Rent-A-Car</option>
                                                            <option value="AL">Alamo Rent A Car</option>
                                                            <option value="ZI">Avis</option>
                                                            <option value="ZD">Budget</option>
                                                            <option value="ZR">Dollar Rent A Car</option>
                                                            <option value="EY">Economy Rent a Car</option>
                                                            <option value="ET">Enterprise</option>
                                                            <option value="EP">Europcar</option>
                                                            <option value="FX">Fox Rental Cars</option>
                                                            <option value="ZE">Hertz</option>
                                                            <option value="MW">Midway Car Rental</option>
                                                            <option value="ZL">National Car Rental</option>
                                                            <option value="NU">N� Car</option>
                                                            <option value="ZA">Payless</option>
                                                            <option value="RO">Routes Car Rental</option>
                                                            <option value="SX">Sixt</option>
                                                            <option value="ZT">Thrifty Car Rental</option>
                                                            <option value="SV">U-Save</option>
                                                            <option value="SC">Silvercar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-3 -->
                                        <div class="col-lg-3">
                                            <div class="input-box">
                                                <label class="label-text">Discount code</label>
                                                <div class="form-group">
                                                    <div class="select-contain w-auto">
                                                        <select class="select-contain-select">
                                                            <option value="0">I don't have a code</option>
                                                            <option value="1">Corporate or contracted</option>
                                                            <option value="2">Special or advertised</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col-lg-3 -->
                                    </div><!-- end row -->
                                </div>
                            </div><!-- end advanced-wrap -->
                            <div class="btn-box pt-3">
                                <a href="car-search-result.html" class="theme-btn">Search Now</a>
                            </div>
                        </div><!-- end tab-pane -->
                        <div class="tab-pane fade" id="cruise" role="tabpanel" aria-labelledby="cruise-tab">
                            <div class="contact-form-action">
                                <form action="#" class="row align-items-center">
                                    <div class="col-lg-3 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Going to</label>
                                            <div class="form-group">
                                                <div class="select-contain w-auto">
                                                    <select class="select-contain-select">
                                                        <option value="">Select destination</option>
                                                        <optgroup label="Most Popular">
                                                            <option value="caribbean">Caribbean</option>
                                                            <option value="bahamas">Bahamas</option>
                                                            <option value="mexico">Mexico</option>
                                                            <option value="alaska">Alaska</option>
                                                            <option value="europe">Europe</option>
                                                            <option value="bermuda">Bermuda</option>
                                                            <option value="hawaii">Hawaii</option>
                                                            <option value="nepal">Nepal</option>
                                                            <option value="italy">Italy</option>
                                                            <option value="canada-new-england">Canada / New England</option>
                                                        </optgroup>
                                                        <optgroup label="Other Destinations">
                                                            <option value="arctic-antarctic">Arctic / Antarctic</option>
                                                            <option value="middle-east">Middle East</option>
                                                            <option value="africa">Africa</option>
                                                            <option value="panama-canal">Panama Canal</option>
                                                            <option value="asia">Asia</option>
                                                            <option value="pacific-coastal">Pacific Coastal</option>
                                                            <option value="australia-new-zealand">Australia / New Zealand</option>
                                                            <option value="central-america">Central America</option>
                                                            <option value="galapagos">Galapagos</option>
                                                            <option value="getaway-at-sea">Getaway at Sea</option>
                                                            <option value="transatlantic">Transatlantic</option>
                                                            <option value="world-cruise">World</option>
                                                            <option value="south-america">South America</option>
                                                            <option value="south-pacific">South Pacific</option>
                                                            <option value="transpacific">Transpacific</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-3 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Departs as early as</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-3 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Departs as late as</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                    <div class="col-lg-3">
                                        <div class="input-box">
                                            <label class="label-text">Travelers in the cabin</label>
                                            <div class="form-group">
                                                <div class="dropdown dropdown-contain">
                                                    <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                                        <span>Travelers <span class="qtyTotal guestTotal_9">0</span></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-wrap">
                                                        <div class="dropdown-item">
                                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                                <label>Adults</label>
                                                                <div class="qtyBtn d-flex align-items-center">
                                                                    <input type="text" name="qtyInput" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                                <label>Children</label>
                                                                <div class="qtyBtn d-flex align-items-center">
                                                                    <input type="text" name="qtyInput" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-item">
                                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                                <label>Infants</label>
                                                                <div class="qtyBtn d-flex align-items-center">
                                                                    <input type="text" name="qtyInput" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end dropdown -->
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-3 -->
                                </form>
                            </div>
                            <div class="btn-box">
                                <a href="cruise-search-result.html" class="theme-btn">Search Now</a>
                            </div>
                        </div><!-- end tab-pane -->
                        <div class="tab-pane fade" id="tour" role="tabpanel" aria-labelledby="tour-tab">
                            <div class="contact-form-action">
                                <form action="#" class="row align-items-center">
                                    <div class="col-lg-4 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">Where would like to go?</label>
                                            <div class="form-group">
                                                <span class="la la-map-marker form-icon"></span>
                                                <input class="form-control" type="text" placeholder="Destination, city, or region">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                    <div class="col-lg-4 pr-0">
                                        <div class="input-box">
                                            <label class="label-text">From</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-box">
                                            <label class="label-text">To</label>
                                            <div class="form-group">
                                                <span class="la la-calendar form-icon"></span>
                                                <input class="date-range form-control" type="text" name="daterange-single" value="04/28/2020">
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-4 -->
                                </form>
                            </div>
                            <div class="advanced-wrap">
                                <a class="btn collapse-btn theme-btn-hover-gray font-size-15" data-toggle="collapse" href="#collapseSeven" role="button" aria-expanded="false" aria-controls="collapseSeven">
                                    Advanced search <i class="la la-angle-down ml-1"></i>
                                </a>
                                <div class="pt-3 collapse" id="collapseSeven">
                                    <div class="slider-range-wrap">
                                        <div class="price-slider-amount padding-bottom-20px">
                                            <label for="amount" class="filter__label">Price Range</label>
                                            <input type="text" id="amount" class="amounts">
                                        </div><!-- end price-slider-amount -->
                                        <div id="slider-range"></div><!-- end slider-range -->
                                    </div><!-- end slider-range-wrap -->
                                    <div class="checkbox-wrap padding-top-30px">
                                        <h3 class="title font-size-15 pb-3">Tour Categories</h3>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb1">
                                            <label for="tourChb1">Active Adventure Tours</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb2">
                                            <label for="tourChb2">Ecotourism</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb3">
                                            <label for="tourChb3">Escorted Tours</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb4">
                                            <label for="tourChb4">Group Tours</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb5">
                                            <label for="tourChb5">Ligula</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb6">
                                            <label for="tourChb6">Family Tours</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb7">
                                            <label for="tourChb7">City Trips</label>
                                        </div>
                                        <div class="custom-checkbox d-inline-block mr-4">
                                            <input type="checkbox" id="tourChb8">
                                            <label for="tourChb8">National Parks Tours</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-box pt-3">
                                <a href="tour-search-result.html" class="theme-btn">Search Now</a>
                            </div>
                        </div><!-- end tab-pane -->
                    </div>
                </div><!-- end col-lg-12 -->
            </div><!-- end row -->
        </div><!-- end container -->
        <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 10 0 0 A 90 59, 0, 0, 0, 100 0 L 100 10 Z"></path></svg>
    </div>
</section><!-- end hero-wrapper -->
<!-- ================================
    END HERO-WRAPPER AREA
================================= -->

<!-- ================================
    START INFO AREA
================================= -->
<section class="info-area info-bg padding-top-50px padding-bottom-50px text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="icon-box">
                    <div class="info-icon">
                        <i class="la la-bullhorn"></i>
                    </div><!-- end info-icon-->
                    <div class="info-content">
                        <h4 class="info__title"><?=trans('0646');?></h4>
                        <p class="info__desc">
                         <?=trans('0648');?>
                        </p>
                    </div><!-- end info-content -->
                </div><!-- end icon-box -->
            </div><!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="icon-box margin-top-50px">
                    <div class="info-icon">
                       <i class="la la-globe"></i>
                    </div><!-- end info-icon-->
                    <div class="info-content">
                        <h4 class="info__title"><?=trans('0649');?></h4>
                        <p class="info__desc">
                         <?=trans('0650');?>
                        </p>
                    </div><!-- end info-content -->
                </div><!-- end icon-box -->
            </div><!-- end col-lg-4 -->
            <div class="col-lg-4">
                <div class="icon-box">
                    <div class="info-icon">
                       <i class="la la-thumbs-up"></i>
                    </div><!-- end info-icon-->
                    <div class="info-content">
                        <h4 class="info__title"><?=trans('0651');?></h4>
                        <p class="info__desc">
                         <?=trans('0652');?>
                        </p>
                    </div><!-- end info-content -->
                </div><!-- end icon-box -->
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end info-area -->
<!-- ================================
    END INFO AREA
================================= -->


<!--    <?php if ($sliderInfo->totalSlides > 1) { ?>
        <div class="slick-item">
            <div class="bg-image <?php echo $ms->sactive; ?>" data-dark-overlay="4"
                 style="background-image:url('<?php echo $theme_url; ?>assets/img/data/slider.jpg');">
            </div>
        </div>
    <?php } ?>-->

    <div class="hero-form-absolute" id="search">
        <div class="container">
            <div class="row gap-40 gap-lg-60 align-items-center fe">
                <div class="col-lg-12 col-xs-12 col-md-12">
                    <div class="hero-form-inner text-white">
                        <div class="menu-horizontal-wrapper-02">
                            <nav class="menu-horizontal-02">
                                <ul class="nav row-reverse <?php if ($isRTL == "RTL") { ?> justify-content-center <?php } ?>">

                                </ul>
                            </nav>
                            <div class="tab-content">



                                <!--
                            <?php if (isModuleActive('Travelstart')) { ?>
                                <li class="text-center">
                                    <a href="<?php echo base_url('flightst'); ?>">
                                        <i class="fa fa-plane outline-icon visible-xs"></i>
                                        <div class="visible-xs visible-md clearfix"></div>
                                        <span class="hidden-xs"><?php echo trans('Travelstart'); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                            -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end slick hero slider -->

<!--<script>
$(".hero-form-absolute,input").click(function() {
 $('html, body').animate({
  scrollTop: $("#search").offset().top
 }, 1);
});
</script>-->