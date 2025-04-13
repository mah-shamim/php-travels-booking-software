<!-- ================================
    START BREADCRUMB AREA
================================= -->
<section class="breadcrumb-area bread-bg-booking pt-3 pb-3" id="">
    <div class="breadcrumb-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <div class="section-heading">
                            <h2 class="sec__title text-white text-center"><?=T::tours_tour_booking?></h2>
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
<form action="<?=root?>tours/book" method="POST" class="book">
<section class="booking-area padding-top-50px padding-bottom-70px">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="form-box mb-2">
                    <div class="form-title-wrap">
                        <h3 class="title"><?=T::yourpersonalinformation?></h3>
                    </div><!-- form-title-wrap -->
                    <?php include views."modules/accounts/booking_user.php";?>
                </div><!-- end form-box -->

                <div class="form-box payment-received-wrap mb-2">
                    <div class="form-title-wrap">
                        <h3 class="title"><?=T::travellersinformation?></h3>
                    </div>
                    <div class="card-body">
                    <?php
                    if (isset($_SESSION['tours_adults'])) {

                    if (empty($_POST['adults'])) {$adults=0;} else {$adults=$_POST['adults'];}
                    if (empty($_POST['childs'])) {$childs=0;} else {$childs=$_POST['childs'];}
                    if (empty($_POST['infants'])) {$infants=0;} else {$infants=$_POST['infants'];}

                    $travellers = $adults + $childs + $infants;

                    } else $travellers =2; for ($i = 1; $i <= $travellers; $i++) {

                    // generate random words
                    $range1 = range('A', 'Z');  $index1 = array_rand($range1);
                    $range2 = range('A', 'Z');  $index2 = array_rand($range2); ?>


                     <div class="card mb-3">
                        <div class="card-header">
                            <?=T::traveller?> <?=$i?>
                        </div>
                        <div class="card-body">
                          <div class="row">
                        <div class="col-md-2">
                        <label class="label-text"><?=T::title?></label>
                         <select name="title_<?=$i?>" class="form-select">
                             <option value="Mr"><?=T::mr?></option>
                             <option value="Miss"><?=T::miss?></option>
                             <option value="Mrs"><?=T::mrs?></option>
                         </select>
                        </div>
                        <div class="col-md-5">
                        <label class="label-text"><?=T::firstname?></label>
                        <input type="text" name="firstname_<?=$i?>" class="form-control" placeholder="<?=T::firstname?>" value="<?php if (dev == 1){echo "Elan".$range1[$index1];}?>"/>
                        </div>
                        <div class="col-md-5">
                        <label class="label-text"><?=T::lastname?></label>
                        <input type="text" name="lastname_<?=$i?>" class="form-control" placeholder="<?=T::lastname?>" value="<?php if (dev == 1){echo "Mask".$range2[$index2];}?>"/>
                        </div>
                        </div>
                        </div>
                     </div>
                     <?php } ?>
                    </div>
                 </div>

                <?php include views."partcials/payment_methods.php"; ?>

                <div class="col-lg-12">
                    <div class="input-box">
                        <div class="form-group">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="agreechb" onchange="document.getElementById('booking').disabled = !this.checked;" <?php if (dev == 1){echo "checked";}?>>
                                <label for="agreechb"><?=T::bycontinuingyouagreetothe?> <a target="_blank" href="<?=root?>terms-of-use"> &nbsp; <?=T::termsandconditions?></a></label>
                            </div>
                        </div>
                    </div>
                </div><!-- end col-lg-12 -->

                <div class="col-lg-12">
                    <div class="btn-box">
                     <button class="theme-btn book" type="submit" id="booking" <?php if (dev == 1){} else{echo "disabled";}?>><?=T::confirmbooking?></button>
                    </div>
                </div><!-- end col-lg-12 -->

            </div><!-- end col-lg-8 -->
            <div class="col-lg-4">
                <div class="form-box booking-detail-form">
                    <div class="form-title-wrap">
                        <h3 class="title"><?=T::bookingdetails?></h3>
                    </div><!-- end form-title-wrap -->
                    <div class="form-content">
                        <div class="card-item shadow-none radius-none mb-0">
                            <div class="card-img pb-2">
                             <img src="<?=$tour->img[0]?>" alt="img">
                            </div>
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between">
                                    <div>
                                     <?php for ($i = 1; $i <= $tour->rating; $i++) { ?>
                                     <span class="stars la la-star"></span>
                                     <?php } ?>
                                        <h3 class="card-title"><?=$tour->name?></h3>
                                        <p class="card-meta"><?=$tour->location?></p>
                                    </div>
                                    <!--<div>
                                        <a href="#" class="btn ml-1"><i class="la la-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                    </div>-->
                                </div>
                                <!--<div class="card-rating">
                                    <span class="badge text-white">4.4/5</span>
                                    <span class="review__text">Average</span>
                                    <span class="rating__text">(30 Reviews)</span>
                                </div>-->
                                <div class="section-block"></div>
                                <ul class="list-items list-items-2 py-2">
                                    <li><span><?=T::date?>:</span><?=$_POST['date']?></li>
                                </ul>
                                <div class="section-block"></div>
                                <h3 class="card-title pt-3 pb-2 font-size-15"><a href="#"><strong><?=T::travelerdetails?></strong></a></h3>
                                <div class="section-block"></div>

                                <ul class="list-items list-items-2 py-3">
                                    <li><span><?=T::adults?>:</span><?=$adults?> <?php if (!empty($adults)){ echo "- ". $currency." ".$tour->b2c_adult_price * $adults; } ?> </li>
                                    <li><span><?=T::child?>:</span><?=$childs?> <?php if (!empty($childs)){ echo "- ". $currency." ".$tour->b2c_child_price * $childs; } ?> </li>
                                    <li><span><?=T::infants?>:</span><?=$infants?> <?php if (!empty($infants)){ echo "- ". $currency." ".$tour->b2c_infants_price * $infants; } ?> </li>
                                </ul>

                                <?php

                                // cleaning and creating vars
                                $adults_price = $tour->b2c_adult_price * $adults;
                                $childs_price = $tour->b2c_child_price * $childs;
                                $infants_price = $tour->b2c_infant_price * $infants;

                                // merging all pricies to sub total
                                $sub_total = $adults_price + $childs_price + $infants_price;
                                ?>

                                <div class="section-block"></div>
                                <ul class="list-items list-items-2 pt-3">
                                    <li><span><?=T::subtotal?>:</span><?=$currency?> <?= $sub_total ?> </li>
                                    <?php if (isset($tour->tax)) {?>
                                    <li><span><?=T::taxesandfees?>:</span><?=$currency?> </li>
                                    <?php } ?>
                                    <hr>
                                    <li style="font-size:22px"><span><?=T::totalprice?>:</span><strong><?=$currency?> <?=$_POST['price']?> </strong></li>
                                    <hr>
                                    <li><span><?=T::depositnow?>:</span><strong><?=$currency?> <?=$_POST['price']?></strong></li>
                                    <!--<li><span><?=T::remaining?>:</span><strong><?=$currency?> 56 </strong></li>-->
                                </ul>
                            </div>
                        </div><!-- end card-item -->
                    </div><!-- end form-content -->
                </div><!-- end form-box -->
            </div><!-- end col-lg-4 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end booking-area -->

<?php $booking = json_decode(json_encode($tour), true);
$booking['travellers'] = $adults + $childs + $infants;;
?>
<input type="hidden" name="payload" value="<?= base64_encode(json_encode($booking)) ?>" />

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
.card-item .card-title{white-space:unset}
</style>