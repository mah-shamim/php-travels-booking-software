<style>
    [name=bookingForm] {
        margin: 25px auto;
    }
</style>
<div class="container">
    <form name="bookingForm" action="<?=site_url("airway/booking")?>" method="POST">
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Passenger Information
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                        <?php //for ($i = 0; $i < $searchForm->passenger->total(); $i++): ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="surname">Sur Name</label>
                                    <select name="surname[]" id="surname" class="form-control" required>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label for="fullname">Full Name</label>
                                    <input class="form-control" type="text" required name="fullname[]" id="fullname" placeholder="Enter name">
                                </div>
                                <div class="col-md-3">
                                    <label for="passengerType">Passenger Type</label>
                                    <select name="passengerType[]" id="passengerType" class="form-control" required>
                                        <option value="ADT">Adult</option>
                                        <option value="CHD">Child</option>
                                        <option value="INF">Infant</option>
                                    </select>
                                </div>
                            </div>
                            <?php //endfor; ?>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" required class="form-control" placeholder="Enter email">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" required class="form-control" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="note">Note</label>
                                    <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <strong>
                        By clicking to complete this booking I acknowledge that I have read and accept the Rules &amp; Restrictions.</strong>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">CONFIRM THIS BOOKING</button>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-primary" style="border: none;">
                    <div class="panel-heading">Booking Summary</div>
                    <div class="panel-body">
                        <?php if(! empty($itinerarie->outbound->segments) ): ?>
                            <h4 style="padding: 15px;">
                                Outbound <i class="fa fa-arrow-right"></i>
                                <span class="pull-right">Total Stops: <?=$itinerarie->outbound->totalStops?></span>
                            </h4>
                            <?php foreach ($itinerarie->outbound->segments as $segment): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="img-thumbnail" style="max-width: 100px;" src="<?=$segment->airline->image?>" class="img-responsive" alt="<?=$segment->airline->code?>">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="line-height: 15px;" class="pull-right">
                                            <strong>
                                                <?=$segment->departure->airport->code?> 
                                                <i class="fa fa-arrow-right RTL"></i> 
                                                <span><?=$segment->arrival->airport->code?></span>
                                            </strong>
                                        </h6>
                                    </div>
                                </div>
                                <br>
                                <table style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td>Departure</td>
                                            <td>
                                                <span class="pull-right">
                                                    <?=$segment->departure->date?> At <?=$segment->departure->time?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Arrival</td>
                                            <td>
                                                <span class="pull-right">
                                                    <?=$segment->arrival->date?> At <?=$segment->arrival->time?>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table><br/>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if(! empty($itinerarie->inbound->segments) ): ?>
                            <hr>
                            <h4 style="padding: 15px;">
                                Inbound <i class="fa fa-arrow-right"></i>
                                <span class="pull-right">Total Stops: <?=$itinerarie->inbound->totalStops?></span>
                            </h4>
                            <?php foreach ($itinerarie->inbound->segments as $segment): ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img class="img-thumbnail" style="max-width: 100px;" src="<?=$segment->airline->image?>" class="img-responsive" alt="<?=$segment->airline->code?>">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="line-height: 15px;" class="pull-right">
                                            <strong>
                                                <?=$segment->departure->airport->code?> 
                                                <i class="fa fa-arrow-right RTL"></i> 
                                                <span><?=$segment->arrival->airport->code?></span>
                                            </strong>
                                        </h6>
                                    </div>
                                </div>
                                <br>
                                <table style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td>Departure</td>
                                            <td>
                                                <span class="pull-right">
                                                    <?=$segment->departure->date?> At <?=$segment->departure->time?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Arrival</td>
                                            <td>
                                                <span class="pull-right">
                                                    <?=$segment->arrival->date?> At <?=$segment->arrival->time?>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="total_table">
                    <div class="booking-deposit">
                    </div>
                    <table class="table table_summary">
                        <tbody>
                            <tr class="beforeExtraspanel">
                                <td>Tax</td>
                                <td class="text-right">
                                    <?=$itinerarie->priceDetail->totalFare->CurrencyCode.
                                    $itinerarie->priceDetail->taxes->total?>
                                </td>
                            </tr>
                            <!-- <tr class="beforeExtraspanel">
                                <td>Administration Fee</td>
                                <td class="text-right">
                                    <=$itinerarie->priceDetail->customFare->administrationFee->currencyCode.
                                    $itinerarie->priceDetail->customFare->administrationFee->amount?>
                                </td>
                            </tr> -->
                            <tr>
                                <td class="booking-deposit-font"><strong>Ticket Amount</strong></td>
                                <td class="text-right">
                                    <?=$itinerarie->priceDetail->baseFare->CurrencyCode.
                                    $itinerarie->priceDetail->baseFare->Amount?>
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
                                <td class="booking-deposit-font"><strong>Total Amount</strong></td>
                                <td class="text-right">
                                    <?=
                                        $itinerarie->priceDetail->totalFare->CurrencyCode.' '.
                                        (
                                            $itinerarie->priceDetail->totalFare->Amount+
                                            $itinerarie->priceDetail->customFare->tax->amount+
                                            $itinerarie->priceDetail->customFare->administrationFee->amount
                                        )
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12" style="margin-top:25px">
            <div class="panel panel-white">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Need Help?</strong></h3>
                    </div>
                    <div class="panel-body text-chambray text-center" style="font-size:18px">
                        <p class="col-md-4"><i class="fa fa-support"></i> 24/7 Customer Support</p>
                        <p class="col-md-4"><i class="fa fa-phone"></i> +92-3311442244 </p>
                        <p class="col-md-4"><i class="fa fa-envelope-o"></i> info@phptravels.com</p>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="itinerarie" value='<?=json_encode($itinerarie)?>'/>
    </form>    
</div>
