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
                            <h2 class="sec__title_list"><?=trans('0405')?> <?=trans('0145')?></h2>
                        </div>
                    </div><!-- end breadcrumb-content -->
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <div class="breadcrumb-list">
                        <!--<ul class="list-items d-flex justify-content-end">
                            <li><a href="index.html">Home</a></li>
                            <li>Hotel Booking</li>
                        </ul>-->
                    </div><!-- end breadcrumb-list -->
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end breadcrumb-wrap -->
    <div class="bread-svg-box">
        <svg class="bread-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 10" preserveAspectRatio="none"><polygon points="100 0 50 10 0 0 0 10 100 10"></polygon></svg>
    </div><!-- end bread-svg -->
</section><!-- end breadcrumb-area -->
<!-- ================================
    END BREADCRUMB AREA
================================= -->

<!-- ================================
    START BOOKING AREA
================================= -->
<section class="booking-area padding-top-100px padding-bottom-70px">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
              <?php if($appModule != "ean") { ?>
              <?php include $themeurl.'views/includes/booking/profile.php'; ?>
              <form id="bookingdetails" class="payment-form-wrapper hidden-xs hidden-sm" action="" onsubmit="return false">
                            <?php if(!empty($module->extras)){ ?>
                            <div class="clearfix"></div>
                            <?php include $themeurl.'views/includes/booking/extras.php'; ?>
                            <!--End step -->
                            <?php } ?>
                            <script type="text/javascript">
                                $(function(){
                                $('.popz').popover({ trigger: "hover" });
                                });
                            </script>
                            <!-- Complete This booking button only starting -->
                            <div class="panel panel-default btn_section" style="display:none;">
                                <div class="panel-body">
                                    <center>
                                </div>
                            </div>
                            <!-- End Complete This booking button only -->
                            <input type="hidden" id="itemid" name="itemid" value="<?php echo $module->id;?>" />
                            <input type="hidden" name="checkout" value="<?php echo $module->checkout;?>" />
                            <input type="hidden" name="checkin" value="<?php echo $module->checkin;?>" />
                            <input type="hidden" name="adults" value="<?php echo $module_adults;?>" />
                            <input type="hidden" id="couponid" name="couponid" value="" placeholder="coupon id"/>
                            <input type="hidden" id="btype" name="btype" value="<?php echo $appModule;?>" />
                            <input type="hidden" name="subitemid" value="<?php echo implode(',',$subitemid);?>" />
                            <input type="hidden" name="roomscount" value="<?php echo implode(',',$roomscount);?>" />
                            <input type="hidden" name="taxAmount" value="<?php echo $taxAmount;?>" />
                            <input type="hidden" name="bedscount" value='<?php echo $bedscount;?>' placeholder="bedscount"/>
                            <?php  include $themeurl.'views/includes/booking/coupon.php';  ?>
                            <div class="clearfix"></div>
                        </form>
                        <!-- <?php include $themeurl.'views/includes/booking/payment.php'; ?>-->


                        <?php if(!empty($module->policy)){ ?>
                        <div class="alert alert-info">
                            <strong class="RTL go-right"><?php echo trans('045');?></strong><br>
                            <p class="RTL" style="font-size:12px"><?php echo $module->policy;?></p>
                        </div>
                        <?php } ?>
                         <p class="RTL go-text-right"><?php echo trans('0416');?></p>
                         <br>
               <div class="form-group">
              <span id="waiting"></span>
              <button type="submit" class="theme-btn completebook" name="<?php if(empty($usersession)){ echo "guest";}else{ echo "logged"; } ?>"  onclick="return completebook('<?php echo base_url();?>','<?php echo trans('0159')?>');"><?php echo trans('0306');?></button>
            </div>
                        <!-- End Other Modules Booking left section -->
                        <?php }else{ if($nonRefundable){ ?>
                        <div class="alert alert-info"> This rate is non-refundable and cannot be changed or cancelled - if you do choose to change or cancel this booking you will not be refunded any of the payment. </div>
                        <?php } ?>
                        <input type="hidden" name="pay" value="1" />
                        <input type="hidden" name="adults" value="<?php echo $_GET['adults'];?>" />
                        <input type="hidden" name="sessionid" value="<?php echo $_GET['sessionid']; ?>" />
                        <input type="hidden" name="hotel" value="<?php echo $_GET['hotel']; ?>" />
                        <input type="hidden" name="hotelname" value="<?php echo $HotelSummary['name'];?>" />
                        <input type="hidden" name="hotelstars" value="<?php echo $hotelStars;?>" />
                        <input type="hidden" name="location" value="<?php echo $HotelSummary['city'];?>" />
                        <input type="hidden" name="thumbnail" value="<?php echo $HotelImages['HotelImage'][0]['url']; ?>" />
                        <input type="hidden" name="roomname" value="<?php echo $roomname; ?>" />
                        <input type="hidden" name="roomtotal" value="<?php echo $roomtotal; ?>" />
                        <input type="hidden" name="checkin" value="<?php echo $_GET['checkin']; ?>" />
                        <input type="hidden" name="checkout" value="<?php echo $_GET['checkout']; ?>" />
                        <input type="hidden" name="roomtype" value="<?php echo $_GET['roomtype']; ?>" />
                        <input type="hidden" name="ratecode" value="<?php echo $_GET['ratecode']; ?>" />
                        <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
                        <input type="hidden" name="affiliateConfirmationId" value="<?php echo $eanlib->cid.$affiliateConfirmationId; ?>" />
                        <input type="hidden" name="total" value="<?php echo $total; ?>" />
                        <input type="hidden" name="tax" value="<?php echo $tax; ?>" />
                        <input type="hidden" name="nights" value="<?php echo $nights; ?>" />
                        <div class="clearfix"></div>
                        <?php } ?>

                    </div><!-- end col-lg-8 -->
                    <div class="col-lg-4">
                        <div class="form-box booking-detail-form">
                            <div class="form-title-wrap">
                                <h3 class="title"><?=trans('0127')?></h3>
                            </div><!-- end form-title-wrap -->
                            <div class="form-content">
                                <div class="card-item shadow-none radius-none mb-0">
                                    <div class="card-img pb-4">
                                        <a href="javascript:void(0);" class="d-block">
                                            <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" alt="<?php echo $module->title;?>">
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3 class="card-title"><?php echo $module->title;?></h3>
                                                <p class="card-meta"><i class="la la-map-marker"></i><?php echo $module->location;?></p>
                                                <p class="card-meta stars"><?php echo $module->stars;?></p>
                                            </div>
                                            <!--<div>
                                                <a href="hotel-single.html" class="btn ml-1"><i class="la la-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                            </div>-->
                                        </div>
                                        <!--<div class="card-rating">
                                            <span class="badge text-white">4.4/5</span>
                                            <span class="review__text">Average</span>
                                            <span class="rating__text">(30 Reviews)</span>
                                        </div>-->
                                        <div class="section-block"></div>
                                        <ul class="list-items list-items-2 py-2">
                                            <li><span><?php echo trans('07');?>:</span><?php echo $module->checkin;?></li>
                                            <li><span><?php echo trans('09');?>:</span><?php echo $module->checkout;?></li>
                                            <li><span><?php echo trans('060');?>:</span><?php echo $stay;?></li>
                                        </ul>
                                        <div class="section-block"></div>
                                        <b><?=trans('016');?></b>
                                        <ul class="list-items list-items-2 py-2">
                                            <?php foreach($rooms as $room): ?>
                                            <li><?php echo $room->roomscount;?> <?php echo $room->title;?>: <br><?php echo $room->maxAdults;?> <?=trans('010');?> <strong><?=$room->currSymbol.' '.$room->Info['totalPrice']?></strong></li>
                                            <?php endforeach; ?>
                                        </ul>

                                        <div class="section-block"></div>

                                        <ul class="list-items list-items-2 py-2">
                                        <?php if($room->extraBedsCount > 0){ ?>
                                        <li>
                                        <b> <?php echo trans('0429');?> </b>
                                        <span class="float-right">
                                        <?php echo $room->currCode;?> <?php echo $room->currSymbol;?><?php echo $room->extraBedCharges; ?>
                                        </span>
                                        </li>
                                        <?php } ?>
                                        </ul>

                                        <hr>

                                        <!--<h3 class="card-title pt-3 pb-2 font-size-15"><a href="hotel-single.html">Order Details</a></h3> -->
                                        <div class="section-block"></div>
                                        <!--
                                        <ul class="list-items list-items-2 py-3">
                                            <li><span>Room Type:</span>Standard family</li>
                                            <li><span>Room:</span>2 Rooms</li>
                                            <li><span>Per Room Price:</span>$121</li>
                                            <li><span>Adults:</span>4</li>
                                            <li><span>Stay:</span>4 Nights</li>
                                        </ul>
                                        <div class="section-block"></div>
                                        <ul class="list-items list-items-2 pt-3">
                                            <li><span>Sub Total:</span>$240</li>
                                            <li><span>Taxes And Fees:</span>$5</li>
                                            <li><span>Total Price:</span>$245</li>
                                        </ul>-->

                                        <ul class="summary-price-list list-items list-items-2 pt-3s">
                                            <li><span><?php echo trans('0153');?></span> <span class="absolute-right" id="displaytax"> <?php echo $currSymbol;?> <?php echo $taxAmount;?></span></li>
                                            <li><span><?=trans('0429');?></span> <span class="absolute-right" id="extrabedcharges"> <?php echo $currSymbol;?> <?php echo $extrabedcharges?></span></li>
                                            <li><span><?php echo trans('0126');?></span> <span class="absolute-right" id="displaydeposit"> <?php echo $currSymbol;?> <?php echo $depositAmount?></span></li>
                                            <li class="total" style="font-size:18px;margin-top:8px;font-weight:bold"><span><?php echo trans('0124');?></span> <span class="text-main absolute-right" id="displaytotal" style="font-weight:900"><?php echo $currSymbol;?> <?php echo $price;?></span></li>
                                        </ul>

                                    </div>
                                </div><!-- end card-item -->
                            </div><!-- end form-content -->
                        </div><!-- end form-box -->
                    </div><!-- end col-lg-4 -->
                </div><!-- end row -->
                </div><!-- end container -->
                </section><!-- end booking-area -->
                <!-- ================================
                END BOOKING AREA
                ================================= -->

                <div class="section-block"></div>
                <script src="<?php echo base_url(); ?>assets/js/booking.js"></script>