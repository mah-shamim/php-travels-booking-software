
<style>
    body { background:#eee}
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
        color: white !important;
        cursor: default;
        background: #76ce85;
    }
    .nav-tabs>li>a {
        background: rgba(0, 0, 0, 0.09);
        border-radius: 0px;
        color: #000 !important;
        padding: 10px;
        font-size: 14px;
    }
    .switch-ios.switch-light {
        margin-top: 5px !important;
    }
    body{
        background:#fff;
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
</style>
<style>
    .btn-circle {border-radius: 50%;font-size: 54px;padding: 10px 20px;}
</style>
<?php if($result == "success" && $appModule == "ean"){ ?>
    <!-- Start Result of Expedia booking for submit -->
    <div class="modal-dialog modal-lg" style="z-index: 10;">
        <div class="modal-content">
            <div class="modal-body">
                <br><br>
                <div class="center-block">
                    <center>
                        <button class="btn btn-circle block-center btn-lg btn-success"><i class="fa fa-check"></i></button>
                        <h3 class="text-center"><?php echo trans('0409');?> <b class="text-success wow flash animted animated"><?php echo trans('0135');?></b></h3>
                        <p class="text-center"><?php echo $msg;?></p>
                        <p><?php echo trans('0540'); ?>: <?php echo $itineraryID; ?></p>
                        <p><?php echo trans('0539'); ?>: <?php echo $confirmationNumber; ?></p>
                        <?php if(!empty($nightlyRateTotal)){ ?>
                            <p><strong>Total Nightly Rate: <?php echo $currency." ".$nightlyRateTotal; ?></strong></p>
                        <?php } ?>
                        <?php if(!empty($SalesTax)){ ?>
                            <p><strong>Sales Tax: <?php echo $currency." ".$SalesTax; ?></strong></p>
                        <?php } ?>
                        <?php if(!empty($HotelOccupancyTax)){ ?>
                            <p>><strong>Hotel Occupancy Tax: <?php echo $currency." ".$HotelOccupancyTax; ?></strong></p>
                        <?php } ?>
                        <?php if(!empty($TaxAndServiceFee)){ ?>
                            <p><strong>Tax and Service Fee: <?php echo $currency." ".$TaxAndServiceFee; ?></strong></p>
                        <?php } ?>
                        <p><b>  <?php echo trans('0124');?> :</b> <?php echo $currency.$grandTotal;?> (<?php echo trans('0538'); ?>) </p>
                        <p><?php echo trans('0537'); ?> </p>
                        <?php if(!empty($checkInInstructions)){ ?>
                            <p><strong><?php echo trans('0458'); ?></strong> : <?php echo strip_tags($checkInInstructions); ?></p>
                        <?php } ?>
                        <?php if(!empty($specialCheckInInstructions)){ ?>
                            <p><strong>Special Check-in Instructions</strong> : <?php echo strip_tags($specialCheckInInstructions); ?></p>
                        <?php } ?>
                        <?php if(!empty($nonRefundable)){ ?>
                            <p><strong><?php echo trans('0309'); ?></strong> : <?php echo $cancellationPolicy; ?></p>
                        <?php } ?>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- End Result of Expedia booking for submit -->
<?php  }else{ ?>
    <div class="page-wrapper page-payment bg-light">
        <div class="container booking">
            <!-- Start Fail Result of Expedia booking for submit -->
            <?php if($result == "fail" && $appModule == "ean"){ ?>
                <div class="alert alert-danger wow bounce" role="alert">
                    <p><?php echo $msg;?></p>
                </div>
            <?php } ?>
            <!-- End Fail Result of Expedia booking for submit -->
            <div class="container offset-0">
                <div class="loadinvoice">
                    <div class="acc_section">
                        <!-- RIGHT CONTENT -->
                        <div class="row">
                            <div class="col-md-8 offset-0 go-right order-2 order-lg-first" style="margin-bottom:50px;">
                                <div class="clearfix"></div>
                                <div class="">
                                    <div class="result"></div>
                                    <?php if(!empty($error)){ ?>
                                        <h1 class="text-center strong"><?php echo trans('0432');?></h1>
                                        <h3 class="text-center"><?php echo trans('0431');?></h3>
                                    <?php }else{ ?>
                                    <!-- Start Other Modules Booking left section -->
                                    <?php if($appModule != "ean") { ?>
                                        <div class="success-box">
                                            <div class="icon">
                                                <span><i class="ri ri-check-square"></i></span>
                                            </div>
                                            <div class="content">
                                                <h4><?php echo trans('045');?></h4>
                                                <p><?php echo trans('0529');?></p>
                                            </div>
                                        </div>
                                        <h3 class="heading-title"><span><?php echo trans('088');?></span></h3>
                                        <div class="clear"></div>
                                        <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                            <?php include $themeurl.'views/includes/booking/profile.php'; ?>
                                        </div>
                                        <form id="bookingdetails" class="hidden-xs hidden-sm" action="" onsubmit="return false">
                                            <?php if(!empty($module->extras)){ ?>
                                                <div class="clearfix"></div>
                                                <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                                    <?php include $themeurl.'views/includes/booking/extras.php'; ?>
                                                </div>
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
                                            <input type="hidden" name="adults" value="<?php echo $module->adults;?>" />
                                            <input type="hidden" id="couponid" name="couponid" value="" />
                                            <input type="hidden" id="btype" name="btype" value="<?php echo $appModule;?>" />
                                            <input type="hidden" name="tourType" id="tourType" value="<?php echo $module->tourType; ?>"/>
                                            <?php if($appModule == "hotels"){ ?>
                                                <input type="hidden" name="subitemid" value="<?php echo $room->id;?>" />
                                                <input type="hidden" name="roomscount" value="<?php echo $room->roomscount;?>" />
                                                <input type="hidden" name="bedscount" value="<?php echo $room->extraBedsCount;?>" />
                                                <input type="hidden" name="checkin" value="<?php echo $module->checkin;?>" />
                                            <?php } ?>
                                            <?php if($appModule == "tours"){ ?>
                                                <?php if (!empty($module->duration)) { ?>
                                                    <input type="hidden" name="code" id="code" value="<?php echo $module->code; ?>"/>
                                                    <input type="hidden" name="startDate" id="startDate" value="<?php echo $module->startDate; ?>"/>
                                                    <input type="hidden" name="endDate" id="endDate" value="<?php echo $module->endDate; ?>"/>
                                                    <input type="hidden" name="adults" id="adults" value="<?php echo $module->adults;?>"/>
                                                    <input type="hidden" name="seniors" id="seniors" value="<?php echo $module->seniors; ?>"/>
                                                    <input type="hidden" name="youth" id="youth" value="<?php echo $module->youth; ?>"/>
                                                    <input type="hidden" name="children" id="children" value="<?php echo $module->children; ?>"/>
                                                    <input type="hidden" name="infants" id="infants" value="<?php echo $module->infants; ?>"/>
                                                <?php } else{ ?>
                                                    <input type="hidden" name="subitemid" value="<?php echo $module->id;?>" />
                                                    <input type="hidden" name="children" value="<?php echo $module->children;?>" />
                                                    <input type="hidden" name="checkin" value="<?php echo $module->date;?>" />
                                                    <input type="hidden" name="infant" value="<?php echo $module->infants;?>" />
                                                <?php }
                                            } ?>
                                            <?php if($appModule == "rentals"){ ?>
                                                <?php if (!empty($module->duration)) { ?>
                                                    <input type="hidden" name="code" id="code" value="<?php echo $module->code; ?>"/>
                                                    <input type="hidden" name="startDate" id="startDate" value="<?php echo $module->startDate; ?>"/>
                                                    <input type="hidden" name="endDate" id="endDate" value="<?php echo $module->endDate; ?>"/>
                                                    <input type="hidden" name="adults" id="adults" value="<?php echo $module->adults;?>"/>
                                                    <input type="hidden" name="seniors" id="seniors" value="<?php echo $module->seniors; ?>"/>
                                                    <input type="hidden" name="youth" id="youth" value="<?php echo $module->youth; ?>"/>
                                                    <input type="hidden" name="children" id="children" value="<?php echo $module->children; ?>"/>
                                                    <input type="hidden" name="infants" id="infants" value="<?php echo $module->infants; ?>"/>
                                                <?php } else{ ?>
                                                    <input type="hidden" name="subitemid" value="<?php echo $module->id;?>" />
                                                    <input type="hidden" name="children" value="<?php echo $module->children;?>" />
                                                    <input type="hidden" name="checkin" value="<?php echo $module->date;?>" />
                                                    <input type="hidden" name="infant" value="<?php echo $module->infants;?>" />
                                                <?php }
                                            } ?>
                                            <?php if($appModule == "boats"){ ?>
                                                <?php if (!empty($module->duration)) { ?>
                                                    <input type="hidden" name="code" id="code" value="<?php echo $module->code; ?>"/>
                                                    <input type="hidden" name="startDate" id="startDate" value="<?php echo $module->startDate; ?>"/>
                                                    <input type="hidden" name="endDate" id="endDate" value="<?php echo $module->endDate; ?>"/>
                                                    <input type="hidden" name="adults" id="adults" value="<?php echo $module->adults;?>"/>
                                                    <input type="hidden" name="seniors" id="seniors" value="<?php echo $module->seniors; ?>"/>
                                                    <input type="hidden" name="youth" id="youth" value="<?php echo $module->youth; ?>"/>
                                                    <input type="hidden" name="children" id="children" value="<?php echo $module->children; ?>"/>
                                                    <input type="hidden" name="infants" id="infants" value="<?php echo $module->infants; ?>"/>
                                                <?php } else{ ?>
                                                    <input type="hidden" name="subitemid" value="<?php echo $module->id;?>" />
                                                    <input type="hidden" name="children" value="<?php echo $module->children;?>" />
                                                    <input type="hidden" name="checkin" value="<?php echo $module->date;?>" />
                                                    <input type="hidden" name="infant" value="<?php echo $module->infants;?>" />
                                                <?php }
                                            } ?>
                                            <?php if($appModule == "cars"){ ?>
                                                <input type="hidden" name="pickuplocation" value="<?php echo $module->pickupLocation;?>" />
                                                <input type="hidden" name="dropofflocation" value="<?php echo $module->dropoffLocation;?>" />
                                                <input type="hidden" name="pickupDate" value="<?php echo $module->pickupDate;?>" />
                                                <input type="hidden" name="pickupTime" value="<?php echo $module->pickupTime;?>" />
                                                <input type="hidden" name="dropoffDate" value="<?php echo $module->dropoffDate;?>" />
                                                <input type="hidden" name="dropoffTime" value="<?php echo $module->dropoffTime;?>" />
                                                <input type="hidden" name="totalDays" value="<?php echo $module->totalDays;?>" />
                                            <?php } ?>
                                            <?php if($appModule == "flights"){ ?>
                                                <div class="panel">
                                                    <div class="panel-heading">Passengers</div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label class="pure-material-textfield-outlined float-none">
                                                                <input type="text" id="passenger_name_0" name="passenger[name]"  placeholder=" ">
                                                                <span><?php echo trans('0350');?></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="pure-material-textfield-outlined float-none">
                                                                <input type="text" id="passenger_age_0" name="passenger[age]"  placeholder=" ">
                                                                <span><?php echo trans('0524');?></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="pure-material-textfield-outlined float-none">
                                                                <input type="text" id="passenger_passport_0" name="passenger[passportnumber]" placeholder=" ">
                                                                <span><?php echo trans('0523');?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="children" value="<?php echo $payload[12];?>" />
                                                <input type="hidden" name="checkin" value="<?php echo $payload[4];?>" />
                                                <input type="hidden" name="checkout" value="<?php echo $payload[5];?>" />
                                                <input type="hidden" name="type" value="<?php echo $payload[2];?>" />
                                                <input type="hidden" name="class" value="<?php echo $payload[8];?>" />
                                                <input type="hidden" name="aero" value="<?php echo $payload[6];?>" />
                                                <input type="hidden" name="from" value="<?php echo $tax[0]->from_code;?>" />
                                                <input type="hidden" name="taxamount" value="<?php echo $module->tax;?>" />
                                                <input type="hidden" name="totalamount" value="<?php echo $module->total_price;?>" />
                                                <input type="hidden" name="depositeamount" value="<?php echo $module->deposite;?>" />
                                                <input type="hidden" name="to" value="<?php echo $tax[0]->to_code;?>" />
                                                <input type="hidden" name="infant" value="<?php echo $payload[13];?>" />
                                            <?php } ?>

                                            <?php if(!empty($module->tourType) && ($module->tourType == "Viator")){?>
                                            <?php } else { ?>
                                            <?php  include $themeurl.'views/includes/booking/coupon.php';  ?>
                                            <?php } ?>

                                            <div class="clearfix"></div>
                                            <!-- Start Tour Travellers data fields -->

                                            <?php if(!empty($module->tourType) && ($module->tourType == "Viator")){?>
                                            <?php } else { ?>
                                            <?php if($appModule == "tours") { ?>
                                                <div class="panel panel-default">
                                                    <h3 class="heading-title"><span><?php echo trans('0521');?></span></h3>
                                                    <div class="panel-body">
                                                        <div class="form-horizontal">
                                                            <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                                                <?php for($i = 1; $i <= $totalGuests;$i++){ ?>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][name]"  placeholder=" "/>
                                                                                <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0350');?></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][passportnumber]"  placeholder=" "/>
                                                                                <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0523');?></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][age]"  placeholder=" "/>
                                                                                <span><?php echo trans('0524');?></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php } ?>

                                            <?php if($appModule == "rentals") { ?>
                                                <div class="panel panel-default">
                                                    <h3 class="heading-title"><span><?php echo trans('0521');?></span></h3>
                                                    <div class="panel-body">
                                                        <div class="form-horizontal">
                                                            <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                                                <?php for($i = 1; $i <= $totalGuests;$i++){ ?>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][name]"  placeholder=" "/>
                                                                                <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0350');?></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][passportnumber]"  placeholder=" "/>
                                                                                <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0523');?></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][age]"  placeholder=" "/>
                                                                                <span><?php echo trans('0524');?></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>



                                            <?php if($appModule == "boats") { ?>
                                                <div class="panel panel-default">
                                                    <h3 class="heading-title"><span><?php echo trans('0521');?></span></h3>
                                                    <div class="panel-body">
                                                        <div class="form-horizontal">
                                                            <div class="bg-white-shadow pt-25 ph-30 pb-40 mt-30">
                                                                <?php for($i = 1; $i <= $totalGuests;$i++){ ?>
                                                                    <div class="row form-group">
                                                                        <div class="col-md-4">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][name]"  placeholder=" "/>
                                                                                <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0350');?></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][passportnumber]"  placeholder=" "/>
                                                                                <span><?php echo trans('0522');?> <?php echo $i;?> <?php echo trans('0523');?></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label class="pure-material-textfield-outlined float-none">
                                                                                <input type="" name="passport[<?php echo $i;?>][age]"  placeholder=" "/>
                                                                                <span><?php echo trans('0524');?></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- End Tour Travellers data fields -->

                                            <br><br>
                                            <?php if(!empty($module->policy)){ ?>
                                                <div class="alert alert-info mt-30">
                                                    <strong class="RTL go-right"><?php echo trans('045');?></strong><br>
                                                    <p class="RTL" style="font-size:12px"><?php echo $module->policy;?></p>
                                                </div>
                                            <?php } ?>
                                            <p class="RTL"><?php echo trans('0416');?></p>
                                            <div class="form-group">
                                                <span id="waiting"></span>
                                                <?php  if(!empty($module->tourType) && ($module->tourType == "Viator")) {?>
                                                <button type="submit" class="btn btn-success btn-lg btn-block completebook" name="<?php if(empty($usersession)){ echo "guest";}else{ echo "logged"; } ?>"><?php echo trans('027');?></button>
                                                    <script>

                                                        $("#bookingdetails").submit(function (event) {
                                                            event.preventDefault();
                                                            let code = $("#code").val();
                                                            let startDate = $("#startDate").val().split('/').join('-');
                                                            let endDate = $("#endDate").val().split('/').join('-');

                                                            var guestform =  $("#guestform").serializeArray();
                                                            var price = "<?=$module->price?>";

                                                            var validation = false;
                                                            var name_attr = "";
                                                            guestform.forEach((item)=>{
                                                                if((item.value == "") && (item.name != "additionalnotes") && (item.name != "country") ){
                                                                    validation = true;
                                                                    name_attr = item.name;
                                                                }
                                                            });
                                                            var account_info = $("#guestform").serialize();
                                                            account_info =  account_info+"&code="+code+"&startDate="+startDate+"&endDate="+endDate+"&price="+price;

                                                            if(!validation){

                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: base_url + 'viator/beforeBooking' ,
                                                                    data: account_info,
                                                                    success: function (response) {
                                                                        window.open(response, '_blank');

                                                                        window.location.href = base_url;
                                                                    },
                                                                });
                                                            }else{
                                                                alert(name_attr+" is missing");
                                                            }


                                                            // window.location.href = + arr.join('/');
                                                        });

                                                    </script>
                                                <?php } else{ ?>
                                                    <button type="submit" class="btn btn-success btn-lg btn-block completebook" name="<?php if(empty($usersession)){ echo "guest";}else{ echo "logged"; } ?>"  onclick="return completebook('<?php echo base_url();?>','<?php echo trans('0159')?>');"><?php echo trans('0306');?></button>
                                                <?php } ?>
                                            </div>
                                        </form>
                                        <!-- End Other Modules Booking left section -->
                                    <?php }else{ if($nonRefundable){ ?>
                                        <div class="alert alert-info"> This rate is non-refundable and cannot be changed or cancelled - if you do choose to change or cancel this booking you will not be refunded any of the payment. </div>
                                    <?php } ?>
                                        <!-- Start Expedia Booking Form -->
                                        <div class="panel panel-primary">
                                            <h3 class="heading-title"><?php echo trans('088');?></h3>
                                            <div class="clear"></div>
                                            <div class="bg-white-shadow pt-25 ph-30 pb-40">
                                                <form role="form" action="" method="POST">
                                                    <div class="step row go-right">
                                                        <div class="col-md-6  go-right">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('0171');?></label>
                                                                <input class="form-control" id="card-holder-firstname" type="text" placeholder="<?php echo trans('0171');?>" name="firstName"  value="<?php echo @@$profile[0]->ai_first_name?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6  go-left">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('0172');?></label>
                                                                <input class="form-control" id="card-holder-lastname" type="text" placeholder="<?php echo trans('0172');?>" name="lastName"  value="<?php echo @$profile[0]->ai_last_name?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 go-right">
                                                            <div class="form-group ">
                                                                <label  class="required  go-right"><?php echo trans('094');?></label>
                                                                <input class="form-control" id="card-holder-email" type="text" placeholder="<?php echo trans('094');?>" name="email"  value="<?php echo @$profile[0]->accounts_email; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 go-right">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('0173');?></label>
                                                                <input class="form-control" id="card-holder-phone" type="text" placeholder="<?php echo trans('0414');?>" name="phone"  value="<?php echo @$profile[0]->ai_mobile; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6  go-right">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('0105');?></label>
                                                                <select data-placeholder="Select" id="country" name="country" class="form-control go-text-right RTL">
                                                                    <option value=""> <?php echo trans('0158');?> <?php echo trans('0105');?> </option>
                                                                    <?php foreach($allcountries as $c){ ?>
                                                                        <option value="<?php echo $c->iso2;?>" <?php makeSelected($c->iso2, @$profile[0]->ai_country); ?> ><?php echo $c->short_name;?></option>
                                                                    <?php }  ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6  go-left">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('0101');?></label>
                                                                <input id="card-holder-state" class="form-control" type="text" placeholder="<?php echo trans('0101');?>" name="province"  value="<?php if(!empty($profile[0]->ai_state)){ echo @$profile[0]->ai_state; } ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 go-right">
                                                            <div class="form-group ">
                                                                <label  class="required  go-right"><?php echo trans('0100');?></label>
                                                                <input id="card-holder-city" class="form-control" type="text" placeholder="<?php echo trans('0100');?>" name="city"  value="<?php echo @$profile[0]->ai_mobile; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 go-left">
                                                            <div class="form-group">
                                                                <label  class="required go-right"><?php echo trans('0103');?></label>
                                                                <input id="card-holder-postalcode" class="form-control" type="text" placeholder="<?php echo trans('0104');?>" name="postalcode"  value="<?php if(!empty($profile[0]->ai_postal_code)){ echo @$profile[0]->ai_postal_code; } ?>">
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-md-12  go-right">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('098');?></label>
                                                                <textarea class="form-control" placeholder="<?php echo trans('098');?>" rows="4"  name="address"><?php echo @$profile[0]->ai_address_1; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <!--End step -->
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
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6  go-right">
                                                            <div class="form-group ">
                                                                <label  class="required go-right"><?php echo trans('0330');?></label>
                                                                <select class="form-control" name="cardtype" id="cardtype">
                                                                    <option value="">Select Card</option>
                                                                    <?php foreach($payment as $pay){ ?>
                                                                        <option value="<?php echo $pay['code'];?>"> <?php echo $pay['name'];?> </option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6  go-left">
                                                            <div class="form-group ">
                                                                <label  class="required"><?php echo trans('0316');?></label>
                                                                <input type="text" class="form-control" name="cardno" id="card-number" pattern=".{12,}" required title="12 characters minimum" placeholder="Credit Card Number" onkeypress="return isNumeric(event)" value="<?php echo set_value('cardno');?>" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group ">
                                                                <label  class="required"><?php echo trans('0329');?></label>
                                                                <select class="form-control" name="expMonth" id="expiry-month">
                                                                    <option value="01"><?php echo trans('0317');?> (01)</option>
                                                                    <option value="02"><?php echo trans('0318');?> (02)</option>
                                                                    <option value="03"><?php echo trans('0319');?> (03)</option>
                                                                    <option value="04"><?php echo trans('0320');?> (04)</option>
                                                                    <option value="05"><?php echo trans('0321');?> (05)</option>
                                                                    <option value="06"><?php echo trans('0322');?> (06)</option>
                                                                    <option value="07"><?php echo trans('0323');?> (07)</option>
                                                                    <option value="08"><?php echo trans('0324');?> (08)</option>
                                                                    <option value="09"><?php echo trans('0325');?> (09)</option>
                                                                    <option value="10"><?php echo trans('0326');?> (10)</option>
                                                                    <option value="11"><?php echo trans('0327');?> (11)</option>
                                                                    <option value="12"><?php echo trans('0328');?> (12)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 go-left">
                                                            <div class="form-group">
                                                                <label  class="required go-right">&nbsp;</label>
                                                                <select class="form-control" name="expYear" id="expiry-year">
                                                                    <?php for($y = date("Y");$y <= date("Y") + 10;$y++){?>
                                                                        <option value="<?php echo $y?>"><?php echo $y; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 go-left">
                                                            <div class="form-group">
                                                                <label  class="required go-right"><?php echo trans('0331');?></label>
                                                                <input type="text" class="form-control" name="cvv" id="cvv" placeholder="<?php echo trans('0331');?>" value="<?php echo set_value('cvv');?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 go-left">
                                                            <label  class="required" style="float:none !important;">&nbsp;</label>
                                                            <img src="<?php echo base_url(); ?>assets/img/cc.png" class="img-responsive" />
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12 check-right">
                                                            <p class="p-10 check-right">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" name="" id="policy" value="1" >
                                                                <label for="policy" class="custom-control-label"><?php echo trans('0416');?></label>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <br>
                                                            <a href="http://developer.ean.com/terms/en/" class="ml-20" target="blank">Terms and Conditions</a>
                                                            </p>
                                                            <div class="form-group">
                                                                <div class="alert alert-danger submitresult"></div>
                                                                <span id="waiting"></span>
                                                                <div class="col-md-12"><button type="submit" class="btn btn-success btn-lg btn-block paynowbtn" onclick="return expcheck();" name="<?php if(empty($usersession)){ echo "guest";}else{ echo "logged"; } ?>" ><?php echo trans('0306');?></button></div>
                                                                <div class="clearfix"></div>
                                                                <hr>
                                                                <div class="panel-body">
                                                                    <p style="font-size:12px" class="RTL"> <?php echo $checkInInstructions; ?></p>
                                                                    <?php if(!empty($specialCheckInInstructions)){ ?>
                                                                        <p style="font-size:12px" class="RTL"> <?php echo $specialCheckInInstructions; ?></p>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- End Expedia Booking Form -->
                                    <?php } ?>
                                </div>
                            </div>

                            <?php if(!empty($module->tourType) && ($module->tourType == "Viator")){?>
                            </div>
                            <?php } ?>

                            <div class="col-md-4 summary">
                                <!--  *****************************************************  -->
                                <!--                      HOTELS MODULE                      -->
                                <!--  *****************************************************  -->
                                <?php if($appModule == "hotels"){ ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <h6 class="m0"><strong> <?php echo $module->title;?></strong></h6>
                                                <p  class="m0"> <i class="fa fa-map-marker RTL"></i> <?php echo $module->location;?></p>
                                                <p  class="m0">
                                                    <?php echo $module->stars;?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="no-margin no-padding">
                                                <?php if($appModule == "hotels"){ ?>
                                                    <li><b> <?php echo trans('07');?></b><span class="pull-right"><?php echo $module->checkin;?></span></li>
                                                    <li><b> <?php echo trans('09');?></b><span class="pull-right"><?php echo $module->checkout;?></span></li>
                                                    <li><b> <?php echo trans('060');?> </b> <span class="pull-right"><?php echo $room->stay;?></span></li>
                                                    <!--<li><b> <?php echo trans('0412');?> </b> <span class="pull-right"><?php echo $room->currCode;?> <?php echo $room->currSymbol;?> <?php echo $room->perNight;?></span></li>-->
                                                    <?php if($room->extraBedsCount > 0){ ?>
                                                        <li><b> <?php echo trans('0429');?> </b> <span class="pull-right"><?php echo $room->currCode;?> <?php echo $room->currSymbol;?><?php echo $room->extraBedCharges; ?></span></li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><?php echo trans('016');?></div>
                                        <div class="panel-body m0">
                                            <?php if($appModule == "hotels") {?>
                                            <!-- price for each room with quantity -->
                                            <p class="m0"><i class="fa fa-bed"></i> <?php echo $room->roomscount;?> <strong><?php echo $room->title;?></strong> <span class="pull-right">For 2 Adults - $250</span></p>
                                            <hr>
                                            <!--<hr>
                    <p class="m0">Bed and Breakfast BB</p>
                    <?php } ?>
                    <?php if ($detail->room->refundable == 0) { ?>
                        <p  class="m0 text-danger strong">Non-refundable</p>
                    <?php } else { ?>
                        <p  class="m0 text-success strong">Refundable</p>
                    <?php } ?>-->
                                        </div>
                                    </div>
                                    <div class="total_table">
                                        <table class="table table_summary">
                                            <tbody>
                                            <tr class="beforeExtraspanel">
                                                <td>
                                                    <?php echo trans('0153');?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo $room->currCode;?> <?php echo $room->currSymbol;?><span id="displaytax"><?php echo $module->taxAmount;?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="booking-deposit-font">
                                                    <strong><?php echo trans('0126');?></strong>
                                                </td>
                                                <td class="pull-right">
                                                    <strong><span class="booking-deposit-font go-left"><?php echo $room->currCode;?> <?php echo $room->currSymbol;?><span id="displaydeposit"><?php echo $module->depositAmount?></span></span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table style="margin-bottom:0px" class="table table_summary">
                                            <tbody>
                                            <tr style="border-top: 1px dotted white;">
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="tr10">
                                                <td class="booking-deposit-font">
                                                    <strong><?php echo trans('0124');?></strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong><?php echo $room->currCode;?> <?php echo $room->currSymbol;?><span id="displaytotal"><?php echo $room->price;?></span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                      HOTELS MODULE                      -->
                                <!--  *****************************************************  -->
                                <!--  *****************************************************  -->
                                <!--                      FLIGHTS MODULE                     -->
                                <!--  *****************************************************  -->
                                <div class="clear"></div>
                                <?php if($appModule == "flights"){  ?>
                                    <?php foreach($tax as $tx  ) {?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div style="padding: 16px;" class="img-thumbnail">
                                                    <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$tx->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <?php $trans_locations = json_decode($tx->transact);
                                                    $transcat = array();
                                                    array_push($transcat,$tx->from_code);
                                                    for($j=0;$j<count($trans_locations);$j++)
                                                    {
                                                        array_push($transcat,json_decode($trans_locations[$j])->code);
                                                    }
                                                    array_push($transcat,$tx->to_code);
                                                    for($tindex = 0; $tindex<count($transcat);$tindex++){
                                                        ?>
                                                        <h6 class="m0"><strong> <?php echo $transcat[$tindex];?> <?php if($tindex != count($transcat)-1){ ?><i class="fa fa-arrow-right RTL"></i><?php }?></strong></h6>
                                                    <?php }?>
                                                    <p  class="m0"> </p>
                                                    <p  class="m0"><?php echo $payload[7];?></p>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    <?php }?>
                                    <ul class="no-margin no-padding">
                                        <?php for($i = 0 ; $i<count($date_time);$i+=2) {  ?>
                                            <li><b> Departure date From <?=$date_time[$i]->from_code?></b><span class="pull-right"><?=$date_time[$i]->date?></span></li>
                                            <li><b> Arrival date at <?=$date_time[$i+1]->from_code?></b><span class="pull-right"><?=$date_time[$i+1]->date?></span></li>
                                            <li><b> Departure time from <?=$date_time[$i]->from_code?>  </b> <span class="pull-right"><?=$date_time[$i]->time?></span></li>
                                            <li><b> Arrival Time at <?=$date_time[$i+1]->from_code?>  </b> <span class="pull-right"><?=$date_time[$i+1]->time?></span></li>
                                        <?php }?>
                                        <li><b> Total Travelling Hours  </b> <span class="pull-right"><?=$tax[0]->total_hours;?></span></li>
                                        <li><b> Adults  </b> <span class="pull-right"><?=$payload[4]; ?></span></li>
                                        <li><b> Childs  </b> <span class="pull-right"><?=$payload[5]; ?></span></li>
                                        <li><b> Infacts  </b> <span class="pull-right"><?=$payload[6]; ?></span></li>
                                    </ul>
                                    <div class="total_table">
                                        <table class="table table_summary">
                                            <tbody>
                                            <tr class="beforeExtraspanel">
                                                <td>
                                                    <?php echo trans('0153');?>
                                                </td>
                                                <td class="text-right">
                                                    <?php echo $flight_lib->currencycode;?> <?php echo $module->tax;?><span id="displaytax"><?php echo $flight_lib->currencysign;?></span>
                                                </td>
                                            </tr>
                                            <div class="booking-deposit">
                                                <tr>
                                                    <td class="booking-deposit-font">
                                                        <strong><?php echo trans('0126');?></strong>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo $flight_lib->currencycode;?> <?php echo $module->deposite;?><span id="displaytax"><?php echo $flight_lib->currencysign;?></span>
                                                    </td>
                                                </tr>
                                                <!--<tr>
                        <td class="booking-deposit-font">
                            <strong><?php echo trans('0126');?></strong>
                        </td>
                        <td class="text-right">
                            <?php echo $flight_lib->currencycode;?> <?php echo $module->total_price;?><span id="displaytax"><?php echo $flight_lib->currencysign;?></span>
                        </td>
                        </tr>-->
                                            </div>
                                            </tbody>
                                        </table>
                                        <table style="margin-bottom:0px" class="table table_summary">
                                            <tbody>
                                            <tr style="border-top: 1px dotted white;">
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="tr10">
                                                <td class="booking-deposit-font">
                                                    <strong><?php echo trans('0124');?></strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong><?php echo $flight_lib->currencycode;?> <?php echo $module->total_price + $module->tax;?><span id="displaytax"><?php echo $flight_lib->currencysign;?></span></strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                      FLIGHTS MODULE                     -->
                                <!--  *****************************************************  -->
                                <!--  *****************************************************  -->
                                <!--                      TOURS MODULE                       -->
                                <!--  *****************************************************  -->
                                <?php if($appModule == "tours") {?>
                                    <aside class="sticky-kit sidebar-wrapper">
                                        <a href="#" class="product-small-item">
                                            <div class="image">
                                                <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                            </div>
                                            <div class="content">
                                                <div class="content-body">
                                                    <div class="rating-item rating-sm rating-inline mb-7">
                                                        <div class="rating-icons">
                                                            <?php if(!empty($module->duration)){ ?>
                                                                <?php $stars = $module->stars;
                                                                for ($i=4; $i >= 0 ; $i--) {
                                                                    if ($stars > 0){
                                                                        $stars--;
                                                                        ?>
                                                                        <i class="rating-icon fa fa-star"></i>
                                                                    <?php }
                                                                    else {?>
                                                                        <i class="rating-symbol-background rating-icon far fa-star "></i>
                                                                    <?php }
                                                                } ?>
                                                            <?php }else{ ?>
                                                                <?php echo $module->stars; }?>
                                                        </div>
                                                        <!-- <p class="rating-text text-muted font-10">26 reviews</p> -->
                                                    </div>
                                                    <h6><?php echo $module->title;?></h6>
                                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <?php echo $module->location;?></span>
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
                                                    <?php if(!empty($module->duration)){?>
                                                        <li><b> <?php echo trans('0271');?> <?php echo trans('0275');?></b><span class="float-right"><?php echo $module->duration;?></span></li>
                                                    <?php }
                                                    else{?>
                                                        <li><b> <?php echo trans('0271');?> <?php echo trans('0275');?></b><span class="float-right"><?php echo $module->tourDays;?></span></li>
                                                        <li><b> <?php echo trans('0271');?> <?php echo trans('0122');?></b><span class="float-right"><?php echo $module->tourNights;?></span></li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="clear"></div>
                                                <div class="hotel-room-sm-item mb-20">
                                                    <div class="the-room-item">
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0547');?> </h6>
                                                            <?php if (!empty($module->duration)){ ?>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->startDate;?></strong>
                                                            <?php } else { ?>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->date;?></strong>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('010');?>  (<?php echo $module->adults;?>)</h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->adultprice;?></strong>
                                                        </div>
                                                        <?php if($module->seniors > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6>Seniors  (<?php echo $module->seniors;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->seniorprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->youth > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6>Youth(<?php echo $module->youth;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->youthprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->children > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6><?php echo trans('011');?>  (<?php echo $module->children;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->childprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->infants > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6><?php echo trans('0282');?>   (<?php echo $module->infants;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->infantprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0408');?></strong></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->subTotal;?></strong>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <ul class="summary-price-list">
                                                    <li><?php echo trans('0153');?><span class="absolute-right" id="displaytax"><?php echo $module->currSymbol;?><?php echo $module->taxAmount;?></span></li>
                                                    <li><?php echo trans('0126');?><span class="absolute-right" id="displaydeposit"><?php echo $module->currSymbol;?> <?php echo $module->depositAmount?></span></li>
                                                    <li class="total"><?php echo trans('0124');?> <span class="text-main absolute-right" id="displaytotal"><?php echo $module->currSymbol;?><?php echo $module->price;?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </aside>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                      TOURS MODULE                       -->
                                <!--  *****************************************************  -->
                                <!--  *****************************************************  -->
                                <!--                      Rentals MODULE                       -->
                                <!--  *****************************************************  -->
                                <?php if($appModule == "rentals") {?>
                                    <aside class="sticky-kit sidebar-wrapper">
                                        <a href="#" class="product-small-item">
                                            <div class="image">
                                                <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                            </div>
                                            <div class="content">
                                                <div class="content-body">
                                                    <div class="rating-item rating-sm rating-inline mb-7">
                                                        <div class="rating-icons">
                                                            <?php if(!empty($module->duration)){ ?>
                                                                <?php $stars = $module->stars;
                                                                for ($i=4; $i >= 0 ; $i--) {
                                                                    if ($stars > 0){
                                                                        $stars--;
                                                                        ?>
                                                                        <i class="rating-icon fa fa-star"></i>
                                                                    <?php }
                                                                    else {?>
                                                                        <i class="rating-symbol-background rating-icon far fa-star "></i>
                                                                    <?php }
                                                                } ?>
                                                            <?php }else{ ?>
                                                                <?php echo $module->stars; }?>
                                                        </div>
                                                        <!-- <p class="rating-text text-muted font-10">26 reviews</p> -->
                                                    </div>
                                                    <h6><?php echo $module->title;?></h6>
                                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <?php echo $module->location;?></span>
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
                                                    <?php if(!empty($module->duration)){?>
                                                        <li><b> <?php echo trans('0630');?> <?php echo trans('0275');?></b><span class="float-right"><?php echo $module->duration;?></span></li>
                                                    <?php }
                                                    else{?>
                                                        <li><b> <?php echo trans('0630');?> <?php echo trans('0275');?></b><span class="float-right"><?php echo $module->rentalDays;?></span></li>
                                                        <li><b> <?php echo trans('0630');?> <?php echo trans('0122');?></b><span class="float-right"><?php echo $module->rentalNights;?></span></li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="clear"></div>
                                                <div class="hotel-room-sm-item mb-20">
                                                    <div class="the-room-item">
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0547');?> </h6>
                                                            <?php if (!empty($module->duration)){ ?>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->startDate;?></strong>
                                                            <?php } else { ?>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->date;?></strong>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('010');?>  (<?php echo $module->adults;?>)</h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->adultprice;?></strong>
                                                        </div>
                                                        <?php if($module->seniors > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6>Seniors  (<?php echo $module->seniors;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->seniorprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->youth > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6>Youth(<?php echo $module->youth;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->youthprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->children > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6><?php echo trans('011');?>  (<?php echo $module->children;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->childprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->infants > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6><?php echo trans('0282');?>   (<?php echo $module->infants;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->infantprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0408');?></strong></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->subTotal;?></strong>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <ul class="summary-price-list">
                                                    <li><?php echo trans('0153');?><span class="absolute-right" id="displaytax"><?php echo $module->currSymbol;?><?php echo $module->taxAmount;?></span></li>
                                                    <li><?php echo trans('0126');?><span class="absolute-right" id="displaydeposit"><?php echo $module->currSymbol;?> <?php echo $module->depositAmount?></span></li>
                                                    <li class="total"><?php echo trans('0124');?> <span class="text-main absolute-right" id="displaytotal"><?php echo $module->currSymbol;?><?php echo $module->price;?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </aside>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                      Rentals MODULE                       -->
                                <!--  *****************************************************  -->
                                <!--  *****************************************************  -->
                                <!--                      Boats MODULE                       -->
                                <!--  *****************************************************  -->
                                <?php if($appModule == "boats") {?>
                                    <aside class="sticky-kit sidebar-wrapper">
                                        <a href="#" class="product-small-item">
                                            <div class="image">
                                                <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                            </div>
                                            <div class="content">
                                                <div class="content-body">
                                                    <div class="rating-item rating-sm rating-inline mb-7">
                                                        <div class="rating-icons">
                                                            <?php if(!empty($module->duration)){ ?>
                                                                <?php $stars = $module->stars;
                                                                for ($i=4; $i >= 0 ; $i--) {
                                                                    if ($stars > 0){
                                                                        $stars--;
                                                                        ?>
                                                                        <i class="rating-icon fa fa-star"></i>
                                                                    <?php }
                                                                    else {?>
                                                                        <i class="rating-symbol-background rating-icon far fa-star "></i>
                                                                    <?php }
                                                                } ?>
                                                            <?php }else{ ?>
                                                                <?php echo $module->stars; }?>
                                                        </div>
                                                        <!-- <p class="rating-text text-muted font-10">26 reviews</p> -->
                                                    </div>
                                                    <h6><?php echo $module->title;?></h6>
                                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <?php echo $module->location;?></span>
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
                                                    <?php if(!empty($module->duration)){?>
                                                        <li><b> <?php echo trans('0633');?> <?php echo trans('0275');?></b><span class="float-right"><?php echo $module->duration;?></span></li>
                                                    <?php }
                                                    else{?>
                                                        <li><b> <?php echo trans('0633');?> <?php echo trans('0275');?></b><span class="float-right"><?php echo $module->boatDays;?></span></li>
                                                        <li><b> <?php echo trans('0633');?> <?php echo trans('0122');?></b><span class="float-right"><?php echo $module->boatNights;?></span></li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="clear"></div>
                                                <div class="hotel-room-sm-item mb-20">
                                                    <div class="the-room-item">
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0547');?> </h6>
                                                            <?php if (!empty($module->duration)){ ?>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->startDate;?></strong>
                                                            <?php } else { ?>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->date;?></strong>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('010');?>  (<?php echo $module->adults;?>)</h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->adultprice;?></strong>
                                                        </div>
                                                        <?php if($module->seniors > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6>Seniors  (<?php echo $module->seniors;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->seniorprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->youth > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6>Youth(<?php echo $module->youth;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->youthprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->children > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6><?php echo trans('011');?>  (<?php echo $module->children;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->childprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <?php if($module->infants > 0) { ?>
                                                            <div class="mb-20">
                                                                <h6><?php echo trans('0282');?>   (<?php echo $module->infants;?>)</h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->infantprice;?></strong>
                                                            </div>
                                                            <div class="clear"></div>
                                                        <?php } ?>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0408');?></strong></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->subTotal;?></strong>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <ul class="summary-price-list">
                                                    <li><?php echo trans('0153');?><span class="absolute-right" id="displaytax"><?php echo $module->currSymbol;?><?php echo $module->taxAmount;?></span></li>
                                                    <li><?php echo trans('0126');?><span class="absolute-right" id="displaydeposit"><?php echo $module->currSymbol;?> <?php echo $module->depositAmount?></span></li>
                                                    <li class="total"><?php echo trans('0124');?> <span class="text-main absolute-right" id="displaytotal"><?php echo $module->currSymbol;?><?php echo $module->price;?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </aside>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                      Boats MODULE                       -->
                                <!--  *****************************************************  -->
                                <!--  *****************************************************  -->
                                <!--                      CARS MODULE                        -->
                                <!--  *****************************************************  -->
                                <?php if($appModule == "cars"){ ?>
                                    <aside class="sticky-kit sidebar-wrapper">
                                        <a href="#" class="product-small-item">
                                            <div class="image">
                                                <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                            </div>
                                            <div class="content">
                                                <div class="content-body">
                                                    <div class="rating-item rating-sm rating-inline mb-7">
                                                        <div class="rating-icons">
                                                            <?php echo $module->stars;?>
                                                        </div>
                                                        <!-- <p class="rating-text text-muted font-10">26 reviews</p> -->
                                                    </div>
                                                    <h6><?php echo $module->title;?></h6>
                                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <?php echo $module->location;?></span>
                                                </div>
                                                <!-- <div class="price">
                                                  from <span class="text-secondary font700">$895</span> /night
                                                  </div> -->
                                            </div>
                                        </a>
                                        <div class="clear"></div>
                                        <div class="booking-selection-box">
                                            <div class="content">
                                                <div class="clear"></div>
                                                <div class="hotel-room-sm-item mb-20">
                                                    <div class="the-room-item">
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0210');?> <?php echo trans('032');?></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $modulelib->pickupLocationName;?></strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0210');?> <?php echo trans('08');?></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"> <?php echo $module->pickupDate;?></strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6> <?php echo trans('0210');?> <?php echo trans('0259');?></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"> <?php echo $module->pickupTime;?></strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6> <?php echo trans('0211');?> <?php echo trans('032');?></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"> <?php echo $modulelib->dropoffLocationName;?> </strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0211');?> <?php echo trans('08');?></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;">  <?php echo $module->dropoffDate;?></strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0211');?> <?php echo trans('0259');?></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;">   <?php echo $module->dropoffTime;?></strong>
                                                        </div>
                                                        <div class="clear"></div>
                                                        <div class="mb-20">
                                                            <h6><?php echo trans('0408');?></strong></h6>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $module->currSymbol;?> <?php echo $module->subTotal;?></strong>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <ul class="summary-price-list">
                                                    <li><?php echo trans('0153');?><span class="absolute-right" id="displaytax"><?php echo $module->currSymbol;?><?php echo $module->taxAmount;?></span></li>
                                                    <li><?php echo trans('0126');?><span class="absolute-right" id="displaydeposit"><?php echo $module->currSymbol;?> <?php echo $module->depositAmount?></span></li>
                                                    <li class="total"><?php echo trans('0124');?> <span class="text-main absolute-right" id="displaytotal"><?php echo $module->currSymbol;?><?php echo $module->price;?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </aside>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                      CARS MODULE                        -->
                                <!--  *****************************************************  -->
                                <?php if($appModule == "ean"){ ?>
                                    <aside class="sticky-kit sidebar-wrapper">
                                        <a href="#" class="product-small-item">
                                            <div class="image">
                                                <img src="<?php if($appModule == "flights") echo PT_FLIGHTS_AIRLINES.$module->thumbnail;else echo $module->thumbnail; ?>" class="img-responsive" alt="<?php echo $module->title;?>">
                                            </div>
                                            <div class="content">
                                                <div class="content-body">
                                                    <div class="rating-item rating-sm rating-inline mb-7 go-text-left go-right">
                                                        <div class="rating-icons">
                                                            <?php echo $module->stars;?>
                                                        </div>

                                                    </div>
                                                    <div class="clear"></div>
                                                    <h6><?php echo $module->title;?></h6>
                                                    <div class="clear"></div>
                                                    <span class="meta text-muted go-right"><i class="ion-location text-info"></i> <?php echo $module->location;?></span>
                                                    <div class="clear"></div>
                                                </div>

                                            </div>
                                        </a>
                                        <div class="clear"></div>
                                        <div class="booking-selection-box">
                                            <div class="content">
                                                <div class="clear"></div>
                                                <div class="hotel-room-sm-item mb-20">
                                                    <div class="the-room-item">
                                                        <div class="mb-20">
                                                            <ul class="booking-amount-list clearfix mb-20">
                                                                <li class="mb-10">
                                                                    <strong class="go-right "><?php echo trans('016');?></strong>
                                                                    <strong class="price float-right text-danger"><?php echo $roomsCount;?></strong>
                                                                    <div class="clear"></div>
                                                                </li>
                                                                <li>
                                                                    <strong class="go-right "><?php echo trans('010');?></strong>
                                                                    <strong class="price float-right go-right text-danger"><?php echo $adultCount;?></strong>
                                                                    <div class="clear"></div>
                                                                </li>
                                                                <?php if($childCount > 0){ ?>
                                                                <li>
                                                                    <?php echo trans('011');?>
                                                                    <?php echo $childCount;  ?>Age(s) <?php if(is_array($childAges)){ echo implode(',',$childAges); }else{ echo $childAges; } } ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><strong>  <?php echo trans('07');?></strong></h6>
                                                            <div class="clear"></div>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"> <?php echo $checkin;?></strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><strong> <?php echo trans('09');?></strong></h6>
                                                            <div class="clear"></div>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"> <?php echo $checkout;?></strong>
                                                        </div>
                                                        <div class="mb-20">
                                                            <h6><strong><?php echo trans('060');?></strong></h6>
                                                            <div class="clear"></div>
                                                            <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $nights;?></strong>
                                                        </div>
                                                        <?php if(!empty($pricesNightByNight)){ foreach($pricesNightByNight as $key => $val){ ?>
                                                            <div class="mb-20">
                                                                <h6><strong><?php echo $key;?></strong></h6>
                                                                <div class="clear"></div>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $currency." ".$val; ?></strong>
                                                            </div>
                                                        <?php } } ?>
                                                        <?php if(!empty($ExtraPersonFee)){ ?>
                                                            <div class="mb-20">
                                                                <h6><strong>Extra Person Fee</strong></h6>
                                                                <div class="clear"></div>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $currency." ".$ExtraPersonFee; ?></strong>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="clear"></div>
                                                        <?php if(!empty($SalesTax)){ ?>
                                                            <div class="mb-20">
                                                                <h6><strong>Sales Tax</strong></h6>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $currency." ".$SalesTax; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                        <?php if(!empty($HotelOccupancyTax)){ ?>
                                                            <div class="mb-20">
                                                                <h6><strong>Hotel Occupancy Tax</strong></h6>
                                                                <div class="clear"></div>
                                                                <strong class="price float-right d-block text-danger" style="margin-top:-15px;"><?php echo $currency." ".$HotelOccupancyTax; ?></strong>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="clear"></div>
                                                        <hr>
                                                        <div class="mb-20">
                                                            <h5><strong><?php echo trans('016');?></strong></h5>
                                                            <div class="clear"></div>
                                                            <ul class="summary-price-list">
                                                                <li class="go-right p-0"><i class="fa fa-bed go-right pl-10"></i><strong><?php echo @$roomscount;?> <?php echo $roomname; ?></strong></li>
                                                                <div class="clear"></div>
                                                            </ul>
                                                        </div>
                                                        <hr>
                                                        <div class="clear"></div>
                                                    </div>
                                                </div>
                                                <ul class="summary-price-list">
                                                    <li><?php echo trans('0541');?><span class="absolute-right"><?php echo $currency." ".$tax; ?></span></li>
                                                    <?php if(!empty($hotelCharges)){ ?>
                                                        <li>Mandatory Taxes and Fees<span class="absolute-right"><?php echo $currency." ".$hotelCharges; ?></span></li>
                                                    <?php } ?>
                                                    <li class="total"><?php echo trans('0124');?> <span class="text-main absolute-right"><?php echo $currency." ".$total; ?></span></li>
                                                </ul>
                                                <hr>
                                                <div>
                                                    <p class="mb-10"><?php echo trans('0212');?></p>
                                                    <h5 class="heading-title">Cancellation Policy</h5>
                                                    <div class="clear"></div>

                                                    <?php echo $cancelpolicy;?>
                                                </div>
                                            </div>
                                        </div>
                                    </aside>
                                <?php } ?>
                                <?php } ?>
                                <!--  *****************************************************  -->
                                <!--                    Expedia MODULE                       -->
                                <!--  *****************************************************  -->
                                <!-- <div class="panel panel-white">
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
                </div> -->
                                <div class="clearfix"></div>
                                <!--
                <?php if($appModule != "ean"){ ?>
                <div class="panel-footer row" style="background: #E6EDF7;font-size:12px">
                  <p><?php echo trans('0461');?></p>
                </div>
                <?php } ?>-->
                                <!--
                <?php if(!empty($phone)){ ?>
                <div class="panel-body">
                  <h4 class="opensans text-center"><i class="icon_set_1_icon-57"></i><?php echo trans('061');?></h4>
                  <p class="opensans size30 lblue xslim text-center"><?php echo $phone; ?></p>
                </div>
                <?php } ?>
                -->
                            </div>
                        </div>
                    </div>
                    <!-- Booking Final Starting -->
                    <div class="col-md-12 offset-0 final_section go-right"  style="display:none;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="step-pane" id="step4">
                                    <div class="matrialprogress show"><div class="indeterminate"></div></div>
                                    <h2 class="text-center"><?php echo trans('0179');?></h2>
                                    <p class="text-center"><?php echo trans('0180');?></p>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php } ?>
<?php if($appModule == "ean"){ ?>
    <!-- Start JS for Expedia -->
    <script type="text/javascript">
        $(function(){$(".submitresult").hide()})
        function expcheck(){
            alert("here");
            $(".submitresult").html("").fadeOut("fast");
            var cardno=$("#card-number").val();
            var cardtype=$("#cardtype").val();
            var email=$("#card-holder-email").val();
            var country=$("#country").val();
            var cvv=$("#cvv").val();
            var city=$("#card-holder-city").val();
            var state=$("#card-holder-state").val();
            var postalcode=$("#card-holder-postalcode").val();
            var firstname=$("#card-holder-firstname").val();
            var lastname=$("#card-holder-lastname").val();
            var policy=$("#policy").val();
            var minMonth=new Date().getMonth()+1;
            var minYear=new Date().getFullYear();
            var month=parseInt($("#expiry-month").val(),10);
            var year=parseInt($("#expiry-year").val(),10);
            if(country=="US"){
                if($.trim(postalcode)==""){
                    $(".submitresult").html("Enter Postal Code").fadeIn("slow");
                    return!1
                }else if($.trim(state)==""){
                    $(".submitresult").html("Enter State").fadeIn("slow");
                    return!1
                }}
            if($.trim(firstname)==""){
                $(".submitresult").html("Enter First Name").fadeIn("slow");
                return!1
            }else if($.trim(lastname)==""){
                $(".submitresult").html("Enter Last Name").fadeIn("slow");
                return!1
            }else if($.trim(cardno)==""){
                $(".submitresult").html("Enter Card number").fadeIn("slow");
                return!1
            }else if($.trim(cardtype)==""){
                $(".submitresult").html("Select Card Type").fadeIn("slow");
                return!1
            }else if(month<=minMonth&&year<=minYear){
                $(".submitresult").html("Invalid Expiration Date").fadeIn("slow");
                return!1
            }else if($.trim(cvv)==""){
                $(".submitresult").html("Enter Security Code").fadeIn("slow");
                return!1
            }else if($.trim(country)==""){
                $(".submitresult").html("Select Country").fadeIn("slow");
                return!1
            }else if($.trim(city)==""){
                $(".submitresult").html("Enter City").fadeIn("slow");
                return!1
            }else if($.trim(email)==""){
                $(".submitresult").html("Enter Email").fadeIn("slow");
                return!1
            }else if(!$('#policy').is(':checked')){
                $(".submitresult").html("Please Accept Cancellation Policy").fadeIn("slow");
                return!1
            }else{
                $(".paynowbtn").hide();
                $(".submitresult").removeClass("alert-danger");
                $(".submitresult").html("<div class='matrialprogress'><div class='indeterminate'></div></div>").fadeIn("slow")
            }}
        function isNumeric(evt)
        {var e=evt||window.event;var charCode=e.which||e.keyCode;if(charCode>31&&(charCode<47||charCode>57))
            return!1;if(e.shiftKey)return!1;return!0}
    </script>
    <!-- End JS for Expedia -->
<?php }?>
<style>
    #rotatingImg { display: none; }
    .booking-bg { padding: 10px 0 5px 0; width: 100%; background-image: url('<?php echo $theme_url; ?>assets/images/step-bg.png'); background-color: #222; text-align: center; }
    .bookingFlow__message { color: white; font-size: 18px; margin-top: 5px; margin-bottom: 15px; letter-spacing: 1px; }
    .select2-choice { font-size: 13px !important; padding: 0 0 0 10px!important; }
</style>
<?php if($appModule != "ean"){ ?>
    <script src="<?php echo base_url(); ?>assets/js/booking.js"></script>
<?php } ?>
<div class="clearfix"></div>