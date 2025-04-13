<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-action">
    <div class="page-wrapper page-payment bg-light">
        <div class="container">
            <div class="row gap-30">
                <div class="col-12 col-lg-4 order-lg-last">
                    <aside class="sticky-kit sidebar-wrapper">
                        <a data-toggle="collapse" href="#details" class="product-small-item">
                            <div class="image">
                                <img style="height: 75px; padding: 10px 0px 0px 10px;object-fit: contain;" src="<?php echo base_url(); ?>uploads/images/flights/airlines/3T.png" alt="image" />
                            </div>
                            <div class="content">
                                <div class="content-body">
                                    <h6>Airline & Number</h6>
                                    <?php foreach ($DataAdapter->extract_data() as $data): ?>
                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <strong><?=$data->OriginCode?></strong> <?=$data->departure_airport?></span>
                                    <div class="row"></div>
                                    <span class="meta text-muted"><i class="ion-location text-info"></i> <strong><?=$data->DestinationCode?></strong> <?=$data->arrival_airport?> </span>
                                </div>
                            </div>
                        </a>
                        <div id="details" class="panel-collapse collapse">
                            <div class="panel-body">
                                <section>
                                    <p><strong class="text-primary"><?php echo trans('0472');?></strong></p>
                                    <?php foreach ($DataAdapter->FareInfo->Itineraries as $Itinerary): ?>
                                    <?php foreach ($Itinerary->AirOriginDestinations as $Index => $AirOriginDestination): ?>
                                    <?php $TotalStops = count($AirOriginDestination->AirCoupons) - 1; ?>
                                    <?php foreach ($AirOriginDestination->AirCoupons as $AirCoupons): ?>
                                    <?php $Segment = $DataAdapter->getAirSegment($AirCoupons->RefSegment); ?>
                                    <?php if($Index == 0): ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p><?php echo trans('08');?></p>
                                            <p><small><?= date('Y-m-d H:i', strtotime($Segment->FlightInfo->DepartureDate)) ?></small></p>
                                            <p><small><?= date('Y-m-d H:i', strtotime($Segment->FlightInfo->ArrivalDate)) ?></small></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><?php echo $Segment->AirlineDesignator; ?></p>
                                            <p><?php echo $Segment->OriginCode; ?></p>
                                            <p><?php echo $Segment->DestinationCode; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><?php echo trans('0564');?>: <?php echo $Segment->FlightInfo->FlightNumber ?> Class: <?php echo $Segment->BookingClass->CabinClassCode; ?></p>
                                            <p>Carrier: <?php echo $Segment->AirlineDesignator; ?></p>
                                            <p><?php echo trans('0565');?>: <?php echo $Segment->FlightInfo->DurationMinutes; ?> Mints</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><?php echo $segment->detail->bookingInfo->CabinClass; ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($Index == 1): ?>
                                    <p><strong class="text-primary"><?php echo trans('0473');?></strong></p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p><?php echo trans('08');?></p>
                                            <p><?= date('Y-m-d H:i', strtotime($Segment->FlightInfo->DepartureDate)) ?></p>
                                            <p><?= date('Y-m-d H:i', strtotime($Segment->FlightInfo->ArrivalDate)) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><?php echo $Segment->AirlineDesignator; ?></p>
                                            <p><?php echo $Segment->OriginCode; ?></p>
                                            <p><?php echo $Segment->DestinationCode; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><?php echo trans('0564');?>: <?php echo $Segment->FlightInfo->FlightNumber ?> Class: <?php echo $Segment->BookingClass->CabinClassCode; ?></p>
                                            <p>Carrier: <?php echo $Segment->AirlineDesignator; ?></p>
                                            <p><?php echo trans('0565');?>: <?php echo $Segment->FlightInfo->DurationMinutes; ?> Mints</p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><?php echo $segment->detail->bookingInfo->CabinClass; ?></p>
                                        </div>
                                    </div>
                                    <!--/ .row -->
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    <div>
                                    </div>
                                </section>
                            </div>
                            <div class="panel-footer">&nbsp;</div>
                        </div>
                        <div class="clear"></div>
                        <div class="booking-selection-box">
                            <div class="content">
                                <h5 class="font-serif font400"><?=lang('0411')?></h5>
                                <ul class="booking-amount-list clearfix mb-20">
                                    <?php if($Index == 0): ?>
                                    <li>
                                        <?= $data->DepartureDate ?> <span class="font700"><?= $data->OriginCode ?></span>
                                    </li>
                                    <li class="text-right">
                                        <?= $data->ArrivalDate ?> <span class="font700"><?= $data->DestinationCode ?></span>
                                    </li>
                                    <?php endif; ?>
                                    <?php if($Index == 1): ?>
                                    <li class="text-right">
                                        <?= $data->OriginCode ?> <span class="font700"><?= $data->DestinationCode ?></span>
                                    </li>
                                    <?php endif; ?>

                                </ul>
                                <h5 class="font-serif font400"><?=lang('0127')?></h5>
                                <div class="hotel-room-sm-item mb-30">
                                    <div class="the-room-item">
                                        <h6><?=lang('0528')?> <?=lang('0259')?></h6>
                                        <div class="clearfix">

                                            <?php if($Index == 0): ?>
                                            <span class="amount"><?php echo $data->DurationMinutes; ?></span>
                                            <?php endif; ?>

                                            <!--<span class="price"></span>-->
                                        </div>
                                    </div>
                                    <div class="the-room-item">
                                        <h6><i class="ion-location text-info"></i> <?=lang('0273')?> <?=$data->departure_airport?></h6>
                                        <div class="clearfix">
                                            <span class="amount"><i class="ion-location text-info"></i> <?=lang('0274')?> <?=$data->arrival_airport?></span>
                                            <!--<span class="price"></span>-->
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <h5 class="font-serif font400"><?=lang('070')?></h5>
                                <ul class="summary-price-list">
                                    <?php $Currency = $DataAdapter->FareInfo->SaleCurrencyCode; ?>
                                    <li><?=lang('0562')?> <span class="absolute-right"><?php echo $Currency.' '.$DataAdapter->FareInfo->SaleCurrencyAmountTotal->BaseAmount; ?> </span></li>
                                    <li><?=lang('0563')?> <span class="absolute-right"><?php echo $Currency.' '.$DataAdapter->FareInfo->SaleCurrencyAmountTotal->TaxAmount; ?> </span></li>
                                    <li class="total"><?php echo trans('0124');?><span class="text-main absolute-right"> <?php echo $Currency.' '.$DataAdapter->FareInfo->SaleCurrencyAmountTotal->TotalAmount; ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="content-wrapper">
                        <div class="success-box">
                            <div class="icon">
                                <span><i class="ri ri-check-square"></i></span>
                            </div>
                            <div class="content">
                                <h4><?=lang('0566')?></h4>
                                <p><?=lang('045')?></p>
                            </div>
                        </div>
                        <div class="alert alert-warning pt-10 pb-10 mb-30" role="alert"><i class="fas fa-info-circle mr-5"></i><?=lang('0473')?> <?=lang('0294')?>? <a href="<?php echo base_url(); ?>login" class="letter-spacing-0"><?=lang('0236')?></a></div>
                        <form class="payment-form-wrapper" method="post" id="tarcoForm" name="">
                            <h3 class="heading-title"><span><?=lang('0460')?></span></h3>
                            <p class="post-heading"><?=lang('045')?></p>
                            <div class="bg-white-shadow pt-25 ph-30">
                                <div class="row gap-20 mb-0">
                                    <input type="hidden" name="Passengers" required value='<?=json_encode($DataAdapter->Passengers)?>'>
                                    <input type="hidden" name="Price" required value='<?=$DataAdapter->FareInfo->SaleCurrencyAmountTotal->TotalAmount?>'>
                                    <input type="hidden" name="Ref" required value='<?=$DataAdapter->Ref?>'>
                                    <input type="hidden" name="Offer_RefItinerary" required value='<?=$DataAdapter->Offer_RefItinerary?>'>
                                    <input type="hidden" name="FlightData" value='<?=json_encode($DataAdapter->main_array)?>'>
                                    <input type="hidden" name="currcey_code" value="<?=$Currency?>">
                                    <?php foreach($DataAdapter->Passengers as $index => $Passenger): ?>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label><?php echo trans('0607');?></label>
                                            <?=($Passenger->PassengerTypeCode == 'AD')?"Adult":$Passenger->PassengerTypeCode?>
                                            <select class="form-control form-bg-light" id="title" name="CivilityCode[]" required>
                                                <option value="Mr"><?php echo trans('0567');?>.</option>
                                                <option value="Ms"><?php echo trans('0568');?>.</option>
                                                <option value="Master"><?php echo trans('0569');?>.</option>
                                                <option value="Miss"><?php echo trans('0570');?>.</option>
                                                <option value="Mrs"><?php echo trans('0571');?>.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label><?=lang('090')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light"   id="firstname" name="Firstname[]" required value="<?=($config->api_environment == "sandbox") ? "Jhon".chr($index +65): "" ?>" placeholder="<?=lang('090')?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label><?=lang('0608')?> <?=lang('0350')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" id="middlename" name="Middlename[]" required value="<?=($config->api_environment == "sandbox") ? "Doe".chr($index +65) : "" ?>" placeholder="<?=lang('0608')?> <?=lang('0350')?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label><?=lang('091')?> <span class="font12 text-danger">*</span></label>
                                            <input type="text" class="form-control form-bg-light" id="lastname" name="Surname[]" required value="<?=($config->api_environment == "sandbox") ? "khan".chr($index +65) : "" ?>" placeholder="<?=lang('091')?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label>Gender <span class="font12 text-danger">*</span></label>
                                            <select class="form-control form-bg-light" id="gender" name="Gender[]" required>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Doucment Country<span class="font12 text-danger">*</span></label>
                                                <select data-placeholder="Select" id="IssueCountryCode" name="IssueCountryCode[]" class="form-control go-text-right RTL">
                                                    <option value=""> <?php echo trans('0158');?> <?php echo trans('0105');?> </option>
                                                    <?php foreach($allcountries as $c){ ?>
                                                        <option value="<?php echo $c->iso2;?>" <?php if($c->iso2 == "US"){echo "selected";} ?> ><?php echo $c->short_name;?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Country<span class="font12 text-danger">*</span></label>
                                                <select data-placeholder="Select" id="NationalityCountryCode" name="NationalityCountryCode[]" class="form-control go-text-right RTL">
                                                    <option value=""> <?php echo trans('0158');?> <?php echo trans('0105');?> </option>
                                                    <?php foreach($allcountries as $c){ ?>
                                                        <option value="<?php echo $c->iso2;?>"  <?php if($c->iso2 == "US"){echo "selected";} ?> ><?php echo $c->short_name;?></option>
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Date Of Birth <span class="font12 text-danger">*</span></label>
                                                <input type="text"  class="DOB form-control form-bg-light" id="" name="DateOfBirth[]" required value="<?=($config->api_environment == "sandbox") ? "01/01/1970": "" ?>" placeholder="Select data">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Document Expiry Date <span class="font12 text-danger">*</span></label>
                                                <input type="text" class="DateTours form-control form-bg-light" value="01/01/2025" id="DocumentExpiryDate" name="DocumentExpiryDate[]" required  placeholder="Select data">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Document Issuance Date <span class="font12 text-danger">*</span></label>
                                                <input type="text" class="DOB form-control form-bg-light" id="DocumentIssuanceDate" name="DocumentIssuanceDate[]" required  value="<?=($config->api_environment == "sandbox") ? "01/01/2019": "" ?>" placeholder="Select data">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Document Type Code <span class="font12 text-danger">*</span></label>
                                                <input type="text" class="form-control form-bg-light" id="DocumentTypeCode" name="DocumentTypeCode[]" required value="PP" placeholder="Document Type Code">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                                <label>Document Number <span class="font12 text-danger">*</span></label>
                                                <input type="text" class="form-control form-bg-light"  id="DocumentNumber" name="DocumentNumber[]" required value="<?=($config->api_environment == "sandbox") ? "123456789": "" ?>" placeholder="Document Number">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <input type="hidden" name="SpecialServices" required value='<?=json_encode($DataAdapter->SpecialServices)?>'>

                                            <div class="col-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="CTCE"><?=lang('0607')?> <?=lang('094')?></label>
                                                    <input type="text" class="form-control form-bg-light" value="<?=($config->api_environment == "sandbox") ? "test@gmail.com": "" ?>" id="CTCE" name="email" required placeholder="<?=lang('0607')?> <?=lang('094')?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="CTCH"><?=lang('0256')?></label>
                                                    <input type="text" class="form-control form-bg-light" id="CTCH" value="<?=($config->api_environment == "sandbox") ? "033321231231": "" ?>"  name="phone_number" required placeholder="<?=lang('0256')?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="CTCM"><?=lang('0173')?></label>
                                                    <input type="text" class="form-control form-bg-light" id="CTCM" value="<?=($config->api_environment == "sandbox") ? "033321231231": "" ?>" name="mobile_number" required placeholder="<?=lang('0173')?>">
                                                </div>
                                            </div>
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <label><?=lang('0178')?></label>
                                            <textarea name="" id="" cols="30" rows="3" class="form-control form-bg-light" placeholder="<?=lang('0415')?>"><?=($config->api_environment == "sandbox") ? "Description": "" ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button onclick="scrollWin(0, -15000)" type="submit" class="btn btn-primary btn-lg btn-block completebook upClick" id="confirmBooking"><?php echo trans('0306');?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="fullwidth-horizon-sticky border-0">&#032;</div>
            <!-- is used to stop the above stick menu -->
        </div>
    </div>
</div>
<!-- end Main Wrapper -->
<!--/ .scroll up -->
<script>
function scrollWin(x, y) {
window.scrollBy(x, y);
}
</script>
<!--/ .scroll up -->
<script>
$(document).ready(function() {
$(window).keydown(function(event){
if(event.keyCode == 13) {
event.preventDefault();
return false;
}
});
$("#tarcoForm").on('submit', function(e) {
    $("#confirmBooking").attr("disabled", true);
    e.preventDefault();
var payload = $(this).serializeArray();
$('.loader-wrapper').show();
$.post( base_url + 'FlightTarco/booking', payload, function(response) {
$('.loader-wrapper').hide();
     var response = JSON.parse(response);
     if(response.status == true){
         window.location.href = response.msg;
     }else{
         alert(response.msg);
         $("#confirmBooking").attr("disabled", false);

     }
});
});
});
</script>