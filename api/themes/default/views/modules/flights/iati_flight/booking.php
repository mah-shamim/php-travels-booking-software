<?php

if(empty($priceDetailid)){

?>

    <script>

        window.location.href = '<?php echo base_url('flightsi'); ?>';

    </script>

<?php

}else{

?>

<style>

body {background:#eee}

</style>

<div style="margin-top:25px" class="container booking">

    <div class="row">

        <form action="<?php echo base_url('flightsi/success'); ?>" method="POST">
        <input type="hidden" name="currency" value="<?=$currency?>">
        <input type="hidden" name="totalPrice" value="<?=$totalPrice?>">
        <input type="hidden" name="priceDetailid" value="<?=$priceDetailid?>">
        <input type="hidden" name="baseFare" value="<?=$baseFare?>">
        <input type="hidden" name="tax" value="<?=$tax?>">
        <input type="hidden" name="serviceFee" value="<?=$serviceFee?>">

        <div class="col-md-8">

            <div class="panel panel-primary guest">

                <div class="panel-heading">Personal Details</div>

                <div class="panel-body">

                         <div class="row form-group">

    <div class="col-md-2"> <label>Name*</label> </div>

    <div class="col-md-5 col-xs-12">

        <input type="text" id="" class="form-control" required="" placeholder="Name" name="name" value="">

    </div>

    <div class="col-md-5 col-xs-12">

        <input type="text" id="" class="form-control" required="" placeholder="Sur Name" name="surname" value="">

    </div>

</div>

<div class="row form-group">

    <div class="col-md-2"> <label> Email* </label></div>

    <div class="col-md-10">

        <input type="email" id="" class="form-control" required="" name="email" placeholder="Your e-voucher will be sent to this email." value="">

    </div>

</div>

<div class="row form-group">

    <div class="col-md-2"> <label>Personal*</label> </div>

    <div class="col-md-3">

        <select id="" class="form-control" name="type">

            <option value="" disabled="" translate="" selected="selected">Gender</option>

            <option selected="" label="Adult" value="ADULT">Adult</option>

            <option label="Child" value="CHILD">Child</option>

            <option label="Infant" value="INFANT">Infant</option>

            <option label="Senior" value="SENIOR">Senior</option>

            <option label="Young" value="YOUNG">Young</option>

            <option label="Student" value="STUDENT">Student</option>

            <option label="Military" value="MILITARY">Military</option>

            <option label="Teacher" value="TEACHER">Teacher</option>

        </select>

    </div>

    <div class="col-md-3">

        <select id="" class="form-control" name="gender">

            <option value="" disabled="" translate="" selected="selected">Type</option>

            <option selected="" label="Male" value="MALE">Male</option>

            <option label="Female" value="FEMALE">Female</option>

        </select>

    </div>

    <div class="col-md-4">

        <input type="" name="birthdate" class="form-control" placeholder="Birth date yyyy-mm-dd"/>

    </div>

</div>

<div class="row form-group">

    <div class="col-md-2"> <label>Identity</label> </div>

    <div class="col-md-5 col-xs-12">

        <input type="text" id="" class="form-control" placeholder="Identity No" name="identityNo" value="">

    </div>

    <div class="col-md-5 col-xs-12">

        <input type="text" id="" class="form-control" placeholder="Foid" name="foid" value="">

    </div>

</div>

<div class="row form-group">

<div class="col-md-2"> <label>Contact*</label> </div>

<div class="col-md-5 col-xs-12">

    <input type="text" id="" class="form-control" required="" placeholder="Mobile" name="phoneNumber" value="">

</div>

<div class="col-md-5 col-xs-12">

    <input type="text" id="" class="form-control" required="" placeholder="E-ticket" name="mobilePhoneNumber" value="">

</div>

</div>



<div class="form-group" style="margin-bottom:0px">

<div class="panel panel-default">

  <div class="panel-heading">Passport</div>

  <div class="panel-body">

     <div class="row">

     <div class="col-md-2">

    <input type="text" id="" class="form-control" placeholder="Number" name="" value="">

    </div>



    <div class="col-md-2">

    <input type="text" id="" class="form-control" placeholder="Serial" name="" value="">

    </div>



    <div class="col-md-2">

    <input type="text" id="" class="form-control" placeholder="Issue Date" name="" value="">

    </div>



    <div class="col-md-2">

    <input type="text" id="" class="form-control" placeholder="End Date" name="" value="">

    </div>



    <div class="col-md-2">

    <input type="text" id="" class="form-control" placeholder="Cityzenship" name="" value="">

    </div>



    <div class="col-md-2">

    <input type="text" id="" class="form-control" placeholder="Issue Country" name="" value="">

    </div>



</div>

  </div>

</div>

</div>

          </div>

            </div>

            <div class="panel panel-default guest">

                <div class="panel-heading">

                    <label data-toggle="collapse" data-target="#someone" aria-expanded="false" aria-controls="someone" class="control control--checkbox ellipsis fs14">

                        I am booking for someone else

                        <input type="checkbox" checked="">

                        <div class="control__indicator"></div>

                    </label>

                </div>

                <div id="someone" aria-expanded="false" class="collapse">

                    <div class="panel-body">

                        <p>Please enter the name of the main guest of the room</p>

                        <div class="row">

                            <div class="col-md-3 col-xs-12"><label>Full name*</label></div>

                            <div class="col-md-3 col-xs-3">

                                <div class="form-group">

                                    <select class="form-control" name="booking_for_title">

                                        <option value="Title" disabled="">Title</option>

                                        <option selected="" value="Mr">Mr</option>

                                        <option value="Ms">Ms</option>

                                        <option value="Mrs">Mrs</option>

                                    </select>

                                </div>

                            </div>

                            <div class="col-md-3 col-xs-9">

                                <div class="form-group"><input class="form-control" name="booking_for_first_name" placeholder="First Name" value="Majid"></div>

                            </div>

                            <div class="col-md-3 col-xs-12s">

                                <div class="form-group"><input class="form-control" name="booking_for_last_name" placeholder="Last Name" value="Hussain"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="panel panel-default guest">

                <div class="panel-heading">

                    <label data-toggle="collapse" data-target="#special" aria-expanded="false" aria-controls="special" class="control control--checkbox ellipsis fs14">

                        Special Request

                        <input type="checkbox" checked="">

                        <div class="control__indicator"></div>

                    </label>

                </div>

                <div id="special" aria-expanded="false" class="collapse">

                    <div class="panel-body">

                        <textarea name="special_request" placeholder="Request details..." class="form-control" id="" cols="30" rows="5" value="Nothing Special"></textarea>

                    </div>

                </div>

            </div>

            <!-- <div class="panel panel-default guest">

                <div class="panel-heading">Payment Details</div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-md-4 form-groupt"> <label for="email">Payment Method*</label></div>

                        <div class="col-md-8 form-group">

                            <div class="col-md-6">

                                <label for="paypal" class="control control--radio">

                                    Paypal

                                    <input type="radio" name="payment_method" id="paypal" value="Paypal">

                                    <div class="control__indicator"></div>

                                </label>

                            </div>

                            <div class="col-md-6">

                                <label for="credit_card" class="control control--radio">

                                    Credit Card

                                    <input checked="" type="radio" name="payment_method" id="credit_card" value="Credit Card">

                                    <div class="control__indicator"></div>

                                </label>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-sm-7">

                            <p>In a hurry?</p>

                            <p>Pay with Visa Checkout, the easier way to pay online.</p>

                        </div>

                        <div class="col-sm-5">

                            <img class="pull-right img-responsive" src="http://www.booknow.co/themes/default/assets/img/visa.png">

                        </div>

                    </div>

                    <div class="credit-card__strike"> <span class="credit-card__strike-text h4 text-chambray">Or pay with traditional checkout</span> </div>

                    <hr>

                    <div class="row credit-card__form-container">

                        <div class="col-md-7">

                            <div class="row">

                                <div class="col-md-4"> <label for="ccname">Name on card*</label> </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control" placeholder="Your Name" id="name_card" name="name_card" value="Qasim">

                                </div>

                            </div>

                            <div class="clearfix">&nbsp;</div>

                            <div class="row">

                                <div class="col-md-4"> <label for="cardNumber">Card number*</label> </div>

                                <div class="col-md-8">

                                    <input class="form-control" id="" name="card_no" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" value="4321-87654-1112-1516">

                                </div>

                            </div>

                            <div class="clearfix">&nbsp;</div>

                            <div class="row">

                                <div class="col-md-4"> <label for="">Expiration date*</label> </div>

                                <div class="clearfix visible-xs visible-sm">&nbsp;</div>

                                <div class="col-md-4">

                                    <select class="form-control" required="required" name="month">

                                        <option value="" disabled="" translate="" selected="selected">Month</option>

                                        <option value="05" selected="">May 05</option>

                                                                                    <option label="01 - January" value="1">01 - January</option>

                                                                                    <option label="02 - February" value="2">02 - February</option>

                                                                                    <option label="03 - March" value="3">03 - March</option>

                                                                                    <option label="04 - April" value="4">04 - April</option>

                                                                                    <option label="05 - May" value="5">05 - May</option>

                                                                                    <option label="06 - June" value="6">06 - June</option>

                                                                                    <option label="07 - July" value="7">07 - July</option>

                                                                                    <option label="08 - August" value="8">08 - August</option>

                                                                                    <option label="09 - September" value="9">09 - September</option>

                                                                                    <option label="10 - October" value="10">10 - October</option>

                                                                                    <option label="11 - November" value="11">11 - November</option>

                                                                                    <option label="12 - December" value="12">12 - December</option>

                                                                            </select>

                                </div>

                                <div class="clearfix visible-xs visible-sm">&nbsp;</div>

                                <div class="col-md-4">

                                    <select class="form-control" required="required" name="year">

                                        <option value="" disabled="" translate="" selected="selected">Year</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2018" value="2018">2018</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2019" value="2019">2019</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2020" value="2020">2020</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2021" value="2021">2021</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2022" value="2022">2022</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2023" value="2023">2023</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2024" value="2024">2024</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2025" value="2025">2025</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2026" value="2026">2026</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2027" value="2027">2027</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2028" value="2028">2028</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2029" value="2029">2029</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2030" value="2030">2030</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2031" value="2031">2031</option>

                                                                                <option value="2018" selected="">2018</option>

                                            <option label="2032" value="2032">2032</option>

                                                                            </select>

                                </div>

                            </div>

                            <div class="clearfix">&nbsp;</div>

                            <div class="row">

                                <div class="col-md-4"> <label for="">Security code*</label> </div>

                                <div class="col-md-3 col-xs-8">

                                    <input type="text" id="" required="required" name="security_code" class="form-control" placeholder="***" value="321">

                                </div>

                                <div class="col-md-5 col-xs-4">

                                </div>

                            </div>

                        </div>

                        <div class="clearfix visible-xs visible-sm">&nbsp;</div>

                        <div class="col-md-5">

                            <div class="secure-panel">

                                <div class="panel-body">

                                    <div class="col-md-2">

                                        <div class="row"><img src="http://www.booknow.co/themes/default/assets/img/lock-icon.png" class="img-responsive" alt="secure"></div>

                                    </div>

                                    <div class="col-md-10">

                                        <div class="text-success"><strong>100% Secure</strong></div>

                                        We use 128-bit SSL encryption.

                                    </div>

                                    <div class="clearfix"></div>

                                    <hr>

                                    <div class="col-md-2">

                                        <div class="row"><img src="http://www.booknow.co/themes/default/assets/img/shield-icon.png" class="img-responsive" alt="secure"></div>

                                    </div>

                                    <div class="col-md-10">

                                        <div class="text-success"><strong>Trusted worldwide</strong></div>

                                        We do not store or view your card data.

                                    </div>

                                    <div class="clearfix"></div>

                                    <hr>

                                    <div class="col-md-2">

                                        <div class="row"><img src="http://www.booknow.co/themes/default/assets/img/credit-card-checkmark.png" class="img-responsive" alt="secure"></div>

                                    </div>

                                    <div class="col-md-10">

                                        <div class="text-success"><strong>Easy payment</strong></div>

                                        We accept the following payment methods:

                                    </div>

                                    <div class="clearfix"></div>

                                    <hr>

                                    <img class="img-responsive center-block" src="http://www.booknow.co/themes/default/assets/img/credit-cards.png" alt="availble credit cards">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div>

                    </div>

                </div>

            </div> -->

            <p><small>By completing this booking. I acknowledge and agree to the privacy policy and the terms &amp; conditions that are applicable to this hotel booking.</small></p>

            <button type="submit" class="btn btn-success btn-block btn-lg booking_botton" name="booking-btn">Complete Booking</button>

        </div>

        <div class="col-md-4 summary">

            <div class="row">

                <h4>BOOKING SUMMARY</h4>

                <hr>

                <div class="row">

                    <div class="col-md-4">

                        <img src="<?php echo $airline_logos.$flight->legs[0]->carrierCode.".png"; ?>" class="img-responsive" alt="">

                    </div>

                    <div class="col-md-8">  

                        <div class="row">

                            <h6 class="m0"><strong>From : 

                                <?php foreach($flight->legs as $leg): ?>  

                                    <span class="pull-right col-md-5"><?php echo $leg->departureAirport; ?></span>

                                <?php endforeach; ?>

                            </strong></h6>

                                <h6 class="m0"><strong>To : 

                                    <?php foreach($flight->legs as $leg): ?>  

                                        <span class="pull-right col-md-5"><?php echo $leg->arrivalAirport; ?></span>

                                    <?php endforeach; ?>

                            </strong></h6>

                        </div>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-12">

                        <div class="hotel_details_panel__checkout">

                        <?php foreach($flight->legs as $leg): ?>

                            <ul class="no-margin no-padding">

                                <li><b> Departure: </b><span class="pull-right"><?php echo $_SESSION['fromDate'].', '.substr($leg->departureTime,11, 5); ?></span></li>

                                <li><b>Arrival: </b><span class="pull-right"><?php echo $_SESSION['returnDate'].', '.$leg->localArrivalDate; ?></span></li>

                                <li><b>Total Travelling Tme: </b> <span class="pull-right"><?php echo $leg->legDurationMinute; ?> Min</span></li>

                                <li><b> Total Passengers:  </b> <span class="pull-right"><?php echo $_SESSION['adult']; ?></span></li>

                            </ul>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

                <!--<div class="panel panel-default">

                    <div class="panel-heading">Selected Rooms</div>

                    <div class="panel-body m0">

                        <p class="m0"><i class="fa fa-bed"></i> 01. <strong>Classic Double Room</strong> <span class="pull-right">For 2 Adults</span></p>

                        <hr>

                        <p class="m0">Bed and Breakfast BB</p>

                        <hr>

                       <p class="m0 text-success strong">Refundable</p>

                     </div>

                </div>-->

                <div class="form-group total-wrapper">

                    <div class="total_msg">

                        VAT <span class="pull-right">USD&nbsp;0.00</span>

                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <h4>

                                <div class="pull-left">Total (incl. VAT)</div>

                                <div class="pull-right">

                                    <strong>USD $

                                        <?php 

                                            foreach($flight->fares as $fare):

                                                echo $fare->totalSingleAdultFare;

                                            endforeach

                                        ?>

                                    </strong>

                                </div>

                            </h4>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                </div>

                <div class="panel">

                    <div class="panel-heading">

                        <h3 class="panel-title coupon-form__panel-title">Do you have a voucher code?</h3>

                    </div>

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="input-group btn-block">

                                    <input placeholder="Enter Voucher Code" class="form-control" value="" name="voucher">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="panel panel-white">

                 <div class="panel-heading">

                <h3 class="panel-title"><strong><?php echo trans('0382');?></strong></h3>

                </div>

                <div class="panel-body text-chambray">

                <p><?php echo trans('0381');?></p>

                <hr>

                <?php if(!empty($phone)){ ?><p> <i class="fa fa-phone"></i> <?php echo $phone; ?> </p><?php } ?>

                <hr>

                <p><i class="fa fa-envelope-o"></i> <?php echo $contactemail; ?></p>

            </div>

        </div>

            </div>

        </div>

        </form>

    </div>

</div>

<?php

}

?>