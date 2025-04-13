<style>
    body{background:#eee} .account-section { margin-bottom: 17px; margin-top: 10px; }
    .overme {
    width: 130px;
    overflow:hidden;
    white-space:nowrap;
    text-overflow: ellipsis;
    display:inline-block;
    }
    .tab-pane.active{
    display:block;
    }
  .nav-tabs>li>a {
  background: rgba(0, 0, 0, 0.09);
  border-radius: 0px;
  color: #000 !important;
  padding: 10px;
  font-size: 14px;
  }
  ul.booking-amount-list:before{
  content:"";
  }
  ul.booking-amount-list li {
  width:100% !important;
  float:none !important;
  }
  ul.booking-amount-list{
  display: flex;
  flex-direction: column;
  }
  .booking-amount-list b{
  font-size:15px;
  }
  ul.summary-price-list li {
  border-bottom:none;
  }

  .header-main .header-nav{
  position:relative;
  background:#fff;
  z-index:1;
  }

    .secure-panel{background:#f7f6f6;border-radius:7px;}
    .secure-panel img{padding:6px;}
    .secure-panel hr{margin-top:10px;margin-bottom:10px;border:0;border-top:1px solid #d4d4d4;}
    .img-responsive{display:block;max-width:100%;height:auto;}
    @media (min-width:992px){
    .col-md-2,.col-md-10{float:left;}
    .col-md-10{width:83.33333333%;}
    .col-md-2{width:16.66666667%;}
    }
    .panel-body{padding:15px;}
    .clearfix:before,.clearfix:after,.row:before,.row:after,.panel-body:before,.panel-body:after{display:table;content:" ";}
    .clearfix:after,.row:after,.panel-body:after{clear:both;}
    .center-block{display:block;margin-right:auto;margin-left:auto;}
    .total-wrapper{background-color:#0044cc!important;}
    .pull-right{float:right;}
    .pull-left{float:left;}
    .total-wrapper{border-radius:2px;background-color:#0031bc;color:white;padding:11px 12px 0;}
    .total-wrapper .total_msg:first-child{border-bottom:1px solid #ffffff;border-top:transparent;padding:5px 0;margin-top:0;}
    strong{font-weight:700;}
    @media print{
    *,*:before,*:after{color:#000!important;text-shadow:none!important;background:transparent!important;-webkit-box-shadow:none!important;box-shadow:none!important;}
    }
    *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
    *:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
    h4{font-family:inherit;font-weight:500;line-height:1.1;color:inherit;}
    h4{margin-top:10px;margin-bottom:10px;padding-bottom:2px;}
    h4{font-size:18px;}
    .row{margin-right:-15px;margin-left:-15px;}
    .form-group{margin-bottom:15px;}
    .panel-body{padding:15px;}
    .clearfix:before,.clearfix:after,.row:before,.row:after,.panel-body:before,.panel-body:after{display:table;content:" ";}
    .clearfix:after,.row:after,.panel-body:after{clear:both;}
    .pull-right{float:right!important;}
    .pull-left{float:left!important;}
    .summary hr { margin: 5px 0; }
    .summary p { margin-bottom: 0px; }
</style>
<div class="container booking" id="thhotels">
    <div class="row">
        <div class="col-md-8 mt-30">
        <div class="success-box d-none d-md-block">
              <div class="icon">
                <span><i class="ri ri-check-square"></i></span>
              </div>
              <div class="content">
                <h4><?php echo trans('045');?></h4>
                <div class="clear"></div>
                <p><?php echo trans('0529');?></p>
                   </div>
                      </div>
            <div class="bg-white-shadow pt-25 ph-30 pb-40">
                <div class="account-section">
                    <div class="alert alert-danger text-center font-size-h2" id="countdown">00:00</div>
                    <?php if ($userAuthorization == 0): ?>
                    <div class="row mb15">
                        <div class="col-md-6">
                            <a class="btn btn-primary btn-block btn-tab text-white" id="btn-login">Login for Booking</a>
                        </div>
                        <div class="col-md-6">
                            <a  class="btn btn-default btn-block btn-tab active" id="btn-guest">Guest Booking</a>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="login" class="tab-pane">
                            <div class="form-group">
                                <label for="email"><?php echo trans('094');?></label>
                                <input type="email" name="email" value="" id="email" placeholder="<?php echo trans('094');?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password"><?php echo trans('095');?></label>
                                <input type="password" name="password" value="" id="password" placeholder="<?php echo trans('095');?>" class="form-control">
                            </div>
                        </div>
                        <div id="guest" class="tab-pane active">
                            <div class="form-group text-center">
                                <br>
                                <p class="alert alert-info"><?php echo trans('0522');?> <?php echo trans('0145');?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <br/>
            <div class="bg-white-shadow pt-25 ph-30 pb-40">
                <form name="bookingForm" action="<?=base_url('thhotels/pay')?>" method="post">
                    <div class="panel panel-primary guest">
                        <div class="panel-heading">Booking Information</div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="first_name"><?php echo trans('089');?></label>
                                    <select class="form-control" id="title" name="title">
                                        <option value="Mr."><?php echo trans('0567');?>.</option>
                                        <option value="Ms."><?php echo trans('0568');?>.</option>
                                        <option value="Master."><?php echo trans('0569');?>.</option>
                                        <option value="Miss."><?php echo trans('0570');?>.</option>
                                        <option value="Mrs."><?php echo trans('0571');?>.</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="first_name"><?php echo trans('0171');?></label>
                                    <input type="text" id="first_name" class="form-control" required placeholder="<?php echo trans('0171');?>" name="first_name" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="last_name"><?php echo trans('0172');?></label>
                                    <input type="text" id="last_name" class="form-control" required placeholder="<?php echo trans('0172');?>" name="last_name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="email"><?php echo trans('094');?></label>
                                    <input type="email" id="email" class="form-control" required name="email" placeholder="<?php echo trans('094');?>" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="country_code"><?php echo trans('0105');?></label>
                                    <select id="country_code" class="form-control chosen-the-basic " name="country">
                                        <option value=""><?php echo trans('0484');?></option>
                                        <?php
                                            foreach($allcountries as $country){
                                                    ?>
                                        <option value="<?php echo $country->iso2;?>" <?php if($profile[0]->ai_country == $country->iso2){echo "selected";}?> ><?php echo $country->short_name;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_number"><?php echo trans('092');?></label>
                                    <input type="text" id="phone_number" name="number" value="" required maxlength="12" minlength="4" placeholder="<?=trans('0256');?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="panel panel-default guest">
                        <div class="panel-heading go-text-right"><?php echo trans('0407');?> <?php echo trans('0177');?></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-7">
                                    <p class="go-text-left">In a hurry?</p>
                                    <p class="go-text-left">Pay with Visa Checkout, the easier way to pay online.</p>
                                </div>
                                <div class="col-sm-5">
                                    <img class="img-responsive" src="<?php echo $theme_url; ?>assets/img/visa.png">
                                </div>
                            </div>
                            <div class="credit-card__strike"> <span class="credit-card__strike-text h4 text-chambray">Or pay with traditional checkout</span> </div>
                            <hr>
                            <div class="row credit-card__form-container">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-4"> <label for="cardHolderName">Name on card*</label> </div>
                                        <div class="col-md-8 mb-20">
                                            <input type="text" class="form-control" required placeholder="Your Name" id="cardHolderName" name="name_card" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"> <label for="cardNumber"><?=trans('0316');?>*</label> </div>
                                        <div class="col-md-8 mb-20">
                                            <input class="form-control" id="cardNumber" required name="card_no" type="text" placeholder="xxxx-xxxx-xxxx-xxxx" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"> <label for="month"><?=trans('0329');?>*</label> </div>
                                        <div class="col-md-4">
                                            <select class="form-control" id="month" name="month">
                                                <option value="01" selected>01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-20">
                                            <select class="form-control" name="year">
                                                <option value="2018" selected>2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"> <label for="cardCVC">Security code*</label> </div>
                                        <div class="col-md-4 col-xs-8">
                                            <input type="text" id="cardCVC" required="required" name="security_code" class="form-control" placeholder="***" value="" >
                                        </div>
                                        <div class="col-md-5 col-xs-4">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="secure-panel">
                                        <div class="panel-body">
                                            <div class="col-md-2">
                                                <div class="row"><img src="<?php echo $theme_url; ?>assets/img/lock-icon.png" class="img-responsive" alt="secure" /></div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="text-success"><strong>100% Secure</strong></div>
                                                We use 128-bit SSL encryption.
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr>
                                            <div class="col-md-2">
                                                <div class="row"><img src="<?php echo $theme_url; ?>assets/img/shield-icon.png" class="img-responsive" alt="secure" /></div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="text-success"><strong>Trusted worldwide</strong></div>
                                                We do not store or view your card data.
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr>
                                            <div class="col-md-2">
                                                <div class="row"><img src="<?php echo $theme_url; ?>assets/img/credit-card-checkmark.png" class="img-responsive" alt="secure" /></div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="text-success"><strong>Easy payment</strong></div>
                                                We accept the following payment methods:
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr>
                                            <img class="img-responsive center-block" src="<?php echo $theme_url; ?>assets/img/credit-cards.png" alt="availble credit cards">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <p class="go-text-right"><small><?php echo trans('0416');?></small></p>
                    <input type="hidden" name="search_form" value='<?=$search_form_encoded?>'>
                    <input type="hidden" name="room" value='<?=$room_encoded?>'>
                    <input type="hidden" name="hotel" value='<?=$hotel_encoded?>'>
                    </form>

                    <form action="<?=base_url('thhotels/pay')?>" method="post">
                        <input type="hidden" name="price" value="<?=$room->price?>">
                        <input type="hidden" name="currency" value="<?=$hotel->currency_name?>">

                    <button type="submit" style="cursor:pointer" class="btn btn-success btn-block btn-lg paddle_button" data-product="578346" data-theme="none" data-success="<?php echo base_url(); ?>payment-success"><?php echo trans('0335');?></button>


                    <!--<button class="btn btn-success btn-block btn-lg booking_botton" type="submit" id="completeBooking"><?php echo trans('0335');?></button>-->

             </form>
            </div>
        </div>



        <div class="col-12 col-lg-4 order-lg-last">
          <aside class="sticky-kit sidebar-wrapper">
            <a href="#" class="product-small-item">
              <div class="image">
              <img src="<?=$hotel->thumb?>" class="img-responsive" alt="hotel image">
              </div>
              <div class="content">
                <div class="content-body">
                  <div class="rating-item rating-sm rating-inline mb-7 go-text-right">
                    <div class="rating-icons">
                    <?php for ($stars = 0; $stars < $hotel->rating; $stars++): ?>
                            <i class="fa fa-star text-warning"></i>
                            <?php endfor; ?>
                    </div>
                    <!-- <p class="rating-text text-muted font-10">26 reviews</p> -->
                  </div>
                  <h6><?=$hotel->company_name?></h6>
                  <div class="clear"></div>
                  <span class="meta text-muted go-right"><i class="ion-location text-info go-right ml-3"></i> <?=$hotel->address?></span>
                <div class="clear"></div>
                </div>
                <!-- <div class="price">
                  from <span class="text-secondary font700">$895</span> /night
                  </div> -->
              </div>
            </a>
            <div class="clear"></div>
            <div class="booking-selection-box">
              <div class="content">
                <ul class="booking-amount-list clearfix mb-20">
                  <li class="go-text-right"><b> <?php echo trans('07');?></b><span class="float-right go-left"><?=$searchForm->getCheckin()?></span></li>
                  <li class="go-text-right"><b> <?php echo trans('09');?></b><span class="float-right go-left"><?=$searchForm->getCheckout()?></span></li>
                  <li class="go-text-right"><b> <?php echo trans('060');?> </b> <span class="float-right go-left"><?=$searchForm->getTotalNight()?></span></li>
                  <li class="go-text-right"><b> <?php echo trans('016');?> </b> <span class="float-right go-left"><?=$searchForm->getTotalRooms()?></span></li>
                
                  <?php if($room->extraBedsCount > 0){ ?>
                  <li>
                    <b> <?php echo trans('0429');?> </b>
                    <span class="float-right">
                    <?php echo $room->currCode;?> <?php echo $room->currSymbol;?><?php echo $room->extraBedCharges; ?>
                    </span>
                  </li>
                  <?php } ?>
                </ul>
                <div class="clear"></div>
                <h5 class="font-serif font400"><?php echo trans('016');?></h5>
                <div class="clear"></div>
                <div class="hotel-room-sm-item mb-30">
                  <div class="the-room-item">
                  <div class="mb-30">
                    <h6 class="rtl-mr-0"><i class="fa fa-bed go-right"></i> <?=$searchForm->getTotalRooms()?> <?=$room->room_name?></h6>
                    <div class="clear"></div>
                    <span class="amount go-right">For <?=$searchForm->getAdults()?> <?php echo trans('010');?></span>

                      <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?=$room->currSymbol.' '.$room->Info['totalPrice']?></strong>
                      </div>
                      <div class="clear"></div>
                      <p class="m-0 text-left"><?=$room->type?></p>
                    <div class="clearfix">

                    </div>
                  </div>
                </div>
        
                <ul class="summary-price-list">
                  <li class="total"><?php echo trans('0124');?><small> (incl. VAT)</small> <span class="text-main absolute-right" id="displaytotal"><?=$hotel->currency_name.$room->price?></span></li>
                <div class="clear"></div>
                </ul>
              </div>
            </div>
          </aside>
        </div>






        <!-- <div class="col-md-4 summary mt-30">
            <div class="bg-white-shadow pt-25 ph-30 pb-40 ">
                <h4><?php echo trans('0411');?></h4>
                <div class="clear"></div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <img src="<?=$hotel->thumb?>" class="img-responsive" alt="hotel image">
                    </div>
                    <div class="col-md-12">
                        <h6 class="mb-0"><strong><?=$hotel->company_name?></strong></h6>
                        <div class="clear"></div>
                        <p  class="mb-0"><?=$hotel->address?></p>
                        <p  class="mb-0">
                            <?php for ($stars = 0; $stars < $hotel->rating; $stars++): ?>
                            <i class="fa fa-star text-warning"></i>
                            <?php endfor; ?>
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="hotel_details_panel__checkout">
                            <ul class="no-margin no-padding">
                                <li><b class="go-right"> <?php echo trans('07');?> <?php echo trans('08');?></b><span class="float-right"><?=$searchForm->getCheckin()?></span></li>
                                <li><b class="go-right"> <?php echo trans('09');?> <?php echo trans('08');?></b><span class="float-right"><?=$searchForm->getCheckout()?></span></li>
                                <li><b class="go-right"> <?php echo trans('0276');?> </b> <span class="float-right"><?=$searchForm->getTotalNight()?></span></li>
                                <li><b class="go-right"> <?php echo trans('0227');?> </b> <span class="float-right"><?=$searchForm->getTotalRooms()?></span></li>
                            </ul>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="panel panel-default">
                    <h5 class="panel-heading"><?php echo trans('016');?> </h5>
                    <div class="clear"></div>
                    <div class="panel-body m-0">
                        <p class="m-0 d-flex align-items-baseline">
                            <i class="fa fa-bed mr-10"></i> 01. <strong class="overme"><?=$room->room_name?></strong>
                            <span class="ml-auto">For <?=$searchForm->getAdults()?> <?php echo trans('010');?></span>
                        </p>
                        <hr>
                        <p class="m-0 text-left"><?=$room->type?></p>
                        <hr>
                    </div>
                </div>
                <div class="form-group total-wrapper">
                    <div class="panel-body">
                        <h4 class="d-flex justify-content-between float-none">
                            <div class="o2"><strong><?php echo trans('078');?></strong> <small>(incl. VAT)</small></div>
                            <div class="o1"><strong><?=$hotel->currency_name.$room->price?></strong></div>

                        </h4>
                    </div>
                </div>
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong><?php echo trans('0382');?></strong></h3>
                        <div class="clear"></div>
                    </div>
                    <div class="panel-body text-chambray">
                        <p><?php echo trans('0381');?></p>
                        <hr>
                        <?php if(!empty($phone)){ ?>
                        <p> <i class="fa fa-phone"></i> <?php echo $phone; ?> </p>
                        <?php } ?>
                        <hr>
                        <p><i class="fa fa-envelope-o"></i> <?php echo $contactemail; ?></p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<div style="margin:100px"></div>
<script>
    const countdownBox = 'countdown';

    // Set the date we're counting down to
    var expiry_minutes = '10';
    var countDownDate = new Date(new Date().getTime() + expiry_minutes * 60000).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById(countdownBox).innerHTML = minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                    clearInterval(x);
                    // Unhold seats.
                    if (v.seats.length > 0) {
                            v.unHoldSeat(v.seats);
                    } else {
                            document.getElementById(countdownBox).innerHTML = "EXPIRED";
                            setTimeout(function () { window.location.href = '<?=base_url()?>'; }, 3000);
                    }
            }
    }, 1000);

    function do_booking(form)
    {
            var button = $("#thhotels button[id=completeBooking]");
            var oldText = button.text();
            button.text('Processing...');
            button.attr("disabled", true);
            $.post(form.attr('action'), form.serialize(), function(response) {
                    console.log(response);
                    button.text(oldText);
                    button.attr("disabled", false);
                    if(response.status == 'fail') {
                            button.after('<div style="margin-top: 10px;padding: 25px;background: #fbd5d5;">'+response.message+'</div>');
                    } else {
                            button.after('<div style="margin-top: 10px;padding: 25px;background: #fbd5d5;">'+response.message+'</div>');
                            setTimeout(function() {
                                    window.location.href = response.invoice_url;
                            }, 3000);
                    }
            });
    }

    const auth_check = '<?=$userAuthorization?>';
    $("#thhotels form[name=bookingForm]").on("submit", function(e) {
            e.preventDefault();
            var form = $(this);

            if (auth_check == 1) {
                    do_booking(form);
            } else {
                    // Authenticate first
                    var fEmail = $('#login [name=email]');
                    var fPassword = $('#login [name=password]');
                    const payload = {
                            email: fEmail.val(),
                            password: fPassword.val()
                    };
                    $.post(base_url + 'auth/signin', payload, function (response) {
                            if (response.status == 'success') {
                                    do_booking(form);
                            } else {
                                    fEmail.css('border', 'solid 1px red');
                                    fPassword.css('border', 'solid 1px red');
                                    alert('Authentication Error: ' + response.message);
                            }
                    });
            }
    });
    $('.btn-tab').on('click',function(){
            var activeTab = document.querySelectorAll(".active");
            for (var i = 0; i < activeTab.length; i++) {
    activeTab[i].classList.remove("active");
    }
            if($(this).is('#btn-login')){
                    $(this).addClass('active')
                    $('#login').addClass('active')

            }else if($(this).is('#btn-guest')){
                    $('#guest').addClass('active')
                    $(this).addClass('active')
            }
    })
</script>