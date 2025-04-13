<?php 
$booking_data=($meta['data']);
$routes=($meta['routes']);
$travellers_data=($meta['travellers']);
?>

<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="bread-bg-booking pt-3 pb-3 bg-primary mb-3" id="">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <p class="mb-0 text-white text-center fw-bold"><?=T::flights.' '.T::booking?></p>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<div class="booking_loading" style="display:none">
<div class="rotatingDiv"></div>
</div>

<div class="booking_data">
<!-- ================================
    START BOOKING AREA
================================= -->
<form action="<?=root?>flights/book" method="POST" class="book">
<section class="booking-area padding-top-50px padding-bottom-70px">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-box mb-2">
                    <div class="form-title-wrap">
                        <h3 class="title"> <?=T::personal_information?> </h3>
                    </div> 
                    <?php include "App/Views/Accounts/Booking_user.php";?>
                </div>
                <div class="form-box payment-received-wrap mb-2">
                    <div class="form-title-wrap">
                        <h3 class="title"> <?=T::travellers_information?></h3>
                    </div>
                    <div class="card-body">
                    <?php include "App/Views/Flights/Booking_travellers.php" ?>
                    </div>
                 </div>
                 <?php include "App/Views/Payment_methods.php"; ?>
                <?php // CANCELLATION POLICY
                if (!empty($booking_data->cancellation_policy)) {
                    $cancellation_policy = $booking_data->cancellation_policy
                ?>
                <div class="alert alert-danger p-3 mt-2" style="font-size: 14px; line-height: normal;">
                    <p><strong><?=cancellation?> <?=policy?></strong></p>
                    <div class="to--be">

                        <p> <?=$booking_data->cancellation_policy?></p>

                        <div class="read--more">
                            <input class="d-none" type="checkbox" name="" id="show--more">    
                            <label class="d-block w-100 fw-bold" for="show--more" id="to--be_1">
                            <?=read_omore?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b02a37" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                            </label>
                            <label class="d-none w-100 fw-bold" for="show--more" id="to--be_2">
                            <?=read_less?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b02a37" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
                            </label>
                        </div>

                    </div>
                </div>
                <?php } else { $cancellation_policy = ""; }?>

                <div class="col-lg-12">
                    <div class="input-box">
                        <div class="">
                            
                            <div class="d-flex gap-3 alert border">
                            <input class="form-check-input" type="checkbox" id="agreechb" onchange="document.getElementById('booking').disabled = !this.checked;" <?php if (dev == 1){echo "checked";}?>>
                            <label for="agreechb"> I agree to all<a target="_blank" href="<?=root?>terms-of-use"> &nbsp; Terms & Condition</a></label>

                            </div>
                            
                        </div>
                    </div>
                </div><!-- end col-lg-12 -->

                <div class="col-lg-12 mb-5">
                    <div class="btn-box mt-3">
                     <button style="height:50px" class="btn btn-primary w-100 btn-lg book" type="submit" id="booking" <?php if (dev == 1){} else{echo "disabled";}?>> Confirm Booking</button>
                    </div>
                </div><!-- end col-lg-12 -->

            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">

                <div class="sticky-top mb-5">

                <!-- ONEWAY FLIGHT -->
                <div class="form-box booking-detail-form mb-2">
                        <div class="form-title-wrap p-3">
                            <h6 class="text-capitalize m-0"><?=T::oneway?> <?=T::flight?> <?=T::details?></h6>
                        </div> 
                        <div class="form-content">
                            <div class="card-item shadow-none radius-none mb-0">
                                <?php 
                                                                
                                foreach ($routes->segments[0] as $index => $r ) { ?>
                                    <ul class="list-items list-items-2 py-3 pb-0 pt-0">
                                        <li class="fs-6 d-flex align-items-center gap-1 "><span class="fs-5 text-white"><strong class="d-flex align-items-center gap-2"><?=$r->departure_code?> <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M12 5l7 7-7 7"/></svg> <?=$r->arrival_code?></strong></span> 
                                        <div class="d-flex gap-3">
                                        <strong> <?=$r->departure_time?> </strong>
                                        <?=plane_icon()?>
                                        </div>
                                        </li>
                                        <li class="d-flex mt-1 gap-3">
                                        <img class="img-fluid col-md-1 mb-2" src="<?=airline_logo($r->img)?>" style="background: #fff; height: 40px; width: 40px; border-radius: 5px; padding: 7px; margin-bottom: 13px;">
                                        <ul class="mx-0 w-100 mb-4">
                                        <li class="lh-1 mt-0 gap-3 row"> <div class="color-light col-md-4"><?=T::flight?></div> <div class="col-md-6"><?=$r->flight_no?></div></li>
                                        <li class="lh-1 mt-0 gap-3 row"> <div class="color-light col-md-4"><?=T::flight_class?></div> <div class="col-md-6"><?=$r->class?></div></li>
                                        <li class="lh-1 mt-0 gap-3 row"> <div class="color-light col-md-4"><?=T::airline?></div> <div class="col-md-7"><?=$r->airline?></div></li>
                                        </ul>
                                        <li class="section-block my-3 mb-3 mt-0"></li>
                                        <?php } ?>
                                        <li class="lh-1 mt-0"><span><?=T::baggage?></span><?=($routes->segments[0][0]->baggage); ?></li>
                                        <li class="lh-1 mt-3"><span><?=T::cabin_baggage?></span><?=($routes->segments[0][0]->cabin_baggage); ?></li>
                                    </ul>
                        </div> 
                    </div> 
               </div>


               <?php if ($_SESSION['flights_type']=="return"){ ?>
                <!-- RETURN FLIGHT -->
               <div class="form-box booking-detail-form mb-2">
                        <div class="form-title-wrap">
                        <h6 class="text-capitalize m-0"><?=T::return?> <?=T::flight?> <?=T::details?></h6>
                        </div> 
                        <div class="form-content">
                            <div class="card-item shadow-none radius-none mb-0">
                                <?php foreach ($routes->segments[1] as $index => $r ) { ?>
                                    <ul class="list-items list-items-2 py-3 pb-0 pt-0">
                                        <li class="fs-6 d-flex align-items-center gap-1 "><span class="fs-5 text-white"><strong class="d-flex align-items-center gap-2"><?=$r->departure_airport?> <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M12 5l7 7-7 7"/></svg> <?=$r->arrival_airport?></strong></span> 
                                        <div class="d-flex gap-3">
                                        <strong> <?=$r->departure_time?> </strong>
                                        <?=plane_icon()?>
                                        </div>
                                        </li>
                                        <li class="d-flex mt-1 gap-3">
                                        <img class="img-fluid col-md-1 mb-2" src="<?=airline_logo($r->img)?>" style="background: #fff; height: 40px; width: 40px; border-radius: 5px; padding: 7px; margin-bottom: 13px;">
                                        <ul class="mx-0 w-100 mb-4">
                                        <li class="lh-1 mt-0 gap-3 row"> <div class="color-light col-md-4"><?=T::flight?></div> <div class="col-md-6"><?=$r->flight_no?></div></li>
                                        <li class="lh-1 mt-0 gap-3 row"> <div class="color-light col-md-4"><?=T::flight_class?></div> <div class="col-md-6"><?=$r->class?></div></li>
                                        <li class="lh-1 mt-0 gap-3 row"> <div class="color-light col-md-4"><?=T::airline?></div> <div class="col-md-7"><?=$r->airline?></div></li>
                                        </ul>
                                        <li class="section-block my-3 mb-3 mt-0"></li>
                                        <?php } ?>
                                        <li class="lh-1 mt-0"><span><?=T::baggage?></span><?=($routes->segments[1][0]->baggage); ?></li>
                                        <li class="lh-1 mt-3"><span><?=T::cabin_baggage?></span><?=($routes->segments[1][0]->cabin_baggage); ?></li>
                                    </ul>
                        </div> 
                    </div> 
               </div>
               <?php } ?>

                <div class="form-box booking-detail-form mb-4">

                <div class="form-content">
                <div class="card-item shadow-none radius-none mb-0">

                <ul class="list-items list-items-2 py-0">

                <li class="lh-1 mt-0"><span><?=T::price?></span><?=($routes->segments[0][0]->currency); ?> <?=($routes->segments[0][0]->price); ?></li>
                <li class="lh-1 mt-3"><span><?=T::vat?></span> (0%)</li>

                <!-- <div class="section-block my-3"></div> -->

                </ul>
                </div>
                </div>

                <div class="form-title-wrap">
                <ul class="list-items list-items-2 py-0">

                <li class="lh-1">
                <h5 class="m-0">
                <span><strong class="text-uppercase"><?=T::total?></strong></span><strong><?=($routes->segments[0][0]->currency); ?> <?=($routes->segments[0][0]->price); ?></strong></li>

                </h5>    

                </ul>
                </div>

                </div>
                </div>
                </div>

            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end booking-area -->

<input type="hidden" name="booking_data" value="<?=base64_encode(json_encode($booking_data)) ?>" />
<input type="hidden" name="routes" value="<?=base64_encode(json_encode($routes)) ?>" />
<input type="hidden" name="travellers" value="<?=base64_encode(json_encode($travellers_data)) ?>" />
 
</form>

<!-- ================================
    END BOOKING AREA
================================= -->
</div>

<script>
$(".book").submit(function() {
$("body").scrollTop(0);
$(".booking_loading").css("display", "block");
$(".booking_data").css("display", "none");
});
</script>

<style>
.form-check{cursor:pointer}
.header-top-bar,.main-menu-content,.info-area,.footer-area,.cta-area{display:none}
.menu-wrapper{display: flex; justify-content: center; padding: 12px;}
.nav-link:focus, .nav-link:hover { color: var(--theme-bg) !important; }

/* cancellation read more  */
.to--be > p { max-height: calc(3.5em + 2px); overflow: hidden; }
.to--be > .read--more { display: none; }
.to--be > .read--more > label { cursor: pointer; }
.to--be:has(:checked) > p { max-height: unset !important; }
.to--be:has(:checked) > .read--more > #to--be_1 { display: none !important; }
.to--be:has(:checked) > .read--more > #to--be_2 { display: block !important; }
header #navbarSupportedContent { display: none !important }
header { height: 80px; }
header .container{ justify-content: center !important; }
.newsletter-section { display: none}
</style>

<script>
if( (document.querySelector('.to--be > p').scrollHeight) > (document.querySelector('.to--be > p').offsetHeight) ) {
    document.querySelector('.to--be > .read--more').style.display = "block";
}
</script>