<div class="header-mob hidden-xs">
    <div class="container">
        <div class="col-xs-2 text-leftt">
            <a data-toggle="tooltip" data-placement="right" title="<?php echo trans('0533'); ?>"
                class="icon-angle-left pull-left mob-back" onclick="goBack()"></a>
            </div>
            <div class="col-xs-1 text-center pull-right hidden-xs ttu hidden-lg">
                <div class="row">
                    <a class="btn btn-success btn-xs btn-block" data-toggle="collapse" data-target="#modify"
                    aria-expanded="false" aria-controls="modify">
                    <i class="icon-filter mob-filter"></i>
                    <span><?php echo trans('0106'); ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="search_head">
    <?php echo searchForm("Amadeus", $amadeus_data); ?>
</div>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-md-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                 Air Lines
             </div>
             <div class="panel-body">
                <?php 
                $carrier_codes = [];
                if (!empty($amadeus_data['flight_data'])) {
                    if (empty($amadeus_data['flight_data']['errors']) && empty($amadeus_data['error'] && !empty($amadeus_data['flight_data']))) {
                        foreach ($amadeus_data['flight_data']['data'] as $flight) {
                            foreach ($flight['offerItems'] as $flight_offers) {       
                                foreach ($flight_offers['services'] as $flight_services) { 
                                    foreach ($flight_services['segments'] as $flight_segments) { 
                                        if (!in_array($flight_segments['flightSegment']['carrierCode'], $carrier_codes)) {
                                            $carrier_codes[] = $flight_segments['flightSegment']['carrierCode'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                foreach ($carrier_codes as $value) { ?>
                    <p style="padding:5px:border-bottom:1px solid #e2e2e2">
                        <label><input type="radio" value="<?php echo $value; ?>" name="flights" rel="<?php echo $value; ?>">
                            <img src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?php echo $value; ?>.png" style="width: 100px" alt="">
                        </label>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-9" >
        <div class="flight-listing" >
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li><a class="arrow-flight <?php if ($amadeus_data['departureDate'] == date('Y-m-d')) echo "disabled" ?>" onclick="change_date_departure('<?php echo date("Y-m-d", strtotime("-1 day", strtotime($amadeus_data['departureDate']))) ?>',3)" href="javascript:void();">
                    <br>
                    <i class="glyphicon-chevron-right fa fa-angle-left"></i>
                    <br>
                    <br>
                </a>
            </li>
            <?php
            $increment = 1;
            $decrement = 3;
            for ($i = 1; $i <= 7; $i++) {
                if ($i == 4) {
                    $active = 'class="active"';
                } else {
                    $active = '';
                }
                if ($i < 4) {
                    $op = "- " . $decrement;
                    $decrement--;
                } else if ($i == 4) {
                    $op = "+ 0";
                } else {
                    $op = "+ " . $increment;
                    $increment++;
                }
                ?>
                <li <?php echo $active; ?>>
                    <?php
                    $date = ($amadeus_data['departureDate']) ? $amadeus_data['departureDate'] : date('Y-m-d');
                    $curDate = date("D-M-d", strtotime($op . " day", strtotime($date)));
                    $passDate = date("Y-m-d", strtotime($op . " day", strtotime($date)));
                    if ($passDate < date("Y-m-d")) {
                        $disabled = "disabled";
                        $tag = "span";
                    } else {
                        $disabled = "enable";
                    }
                    $arraDate = explode('-', $curDate);
                    ?>
                    <a class="<?= $disabled ?>" href="javascript:void();" <?php if ($passDate >= date("Y-m-d")) { ?>
                        onclick="change_date_departure('<?php echo $passDate; ?>')" <?php } ?> > 
                        <?php echo $arraDate[0] ?>
                        <br>
                        <strong>
                            <?php echo $arraDate[1] ?>    
                        </strong>
                        <br>
                        <?php echo $arraDate[2]; ?>
                    </a>
                </li>
                <?php } ?>
            <li>
                <a class="arrow-flight" onclick="change_date_departure('<?php echo date("Y-m-d", strtotime("+1 day", strtotime($amadeus_data['departureDate']))) ?>')" href="javascript:void();" >
                    <br>
                    <i class="glyphicon-chevron-right fa fa-angle-right"></i>
                    <br><br>
                </a>
            </li>
        </ul>
    </div>
    <br>
    <?php
    if (!empty($amadeus_data['flight_data']['errors'])) { ?>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <i class='fa fa-ban'></i> <?php echo $amadeus_data['flight_data']['errors'][0]['title']; ?>
            </div>
            <div class="panel-body">
                <?php echo $amadeus_data['flight_data']['errors'][0]['detail']; ?>
            </div>
        </div>
    <?php } ?>
    <?php
    if (!empty($amadeus_data['error'])) { ?>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <i class='fa fa-ban'></i> Error
            </div>
            <div class="panel-body">
                <?php echo $amadeus_data['error']; ?>
            </div>
        </div>
        <?php
    }
    ?>
    <table class="table table-border table-hover table-condensed table-striped" id="list" style="background:#fff;padding-top: 10px;">
        <?php
        if (!empty($amadeus_data['flight_data'])) {
            if (empty($amadeus_data['flight_data']['errors']) && empty($amadeus_data['error'])) {
                foreach ($amadeus_data['flight_data']['data'] as $flight) {
                    foreach ($flight['offerItems'] as $flight_offers) { ?>
                        <tr>
                            <td class="wow fadeIn p-10-0 animated"  style="visibility: visible; ">
                                <form action="<?php echo site_url("airlines/booking"); ?>" method="POST">
                                    <?php       
                                    foreach ($flight_offers['services'] as $flight_services) { 
                                        foreach ($flight_services['segments'] as $flight_segments) {
                                            $iataCode_departure = $flight_segments['flightSegment']['departure']['iataCode'];
                                            $departure_at = explode("T", $flight_segments['flightSegment']['departure']['at']);
                                            $departure_at_date = $departure_at[0];
                                            $departure_at_time = explode("+", $departure_at[1]);
                                            $departure_time = $departure_at_time[0];
                                            $iataCode_arrival = $flight_segments['flightSegment']['arrival']['iataCode'];
                                            $arrival_at = explode("T", $flight_segments['flightSegment']['arrival']['at']);
                                            $arrival_at_date = $arrival_at[0];
                                            $arrival_at_time = explode("+", $arrival_at[1]);
                                            $arrival_time = $arrival_at_time[0];
                                            $carrier_code = $flight_segments['flightSegment']['carrierCode'];
                                            $flight_number = $flight_segments['flightSegment']['aircraft']['code'];
                                            ?>
                                            <div class="col-md-12 col-sm-12 " rel="<?php echo $carrier_code; ?>">
                                                <?php echo $carrier_code; ?>
                                                <div class="row pt10">
                                                    <div class="col-md-2 col-xs-4 text-center">
                                                        <img src="<?php echo base_url(); ?>uploads/images/flights/airlines/<?php echo $carrier_code; ?>.png" class="img-responsive center-block" style="margin-top: 6px;" alt="">
                                                        <small><?php echo $flight_number; ?></small>
                                                        <input type="hidden" name="carrier_code[]" value="<?php echo $carrier_code; ?>">
                                                    </div>
                                                    <div class="col-md-7 col-sm-3 col-xs-4">
                                                        <!--<img src="http://www.phptravels.net/themes/default/assets/img/qr.png" class="inline visible-xs" alt="Departure">-->
                                                        <p>
                                                            <strong>
                                                                <span>
                                                                    <?php echo($iataCode_departure); ?>
                                                                    <input type="hidden" name="iataCode_departure[]" value="<?php echo($iataCode_departure); ?>">
                                                                </span>
                                                                &nbsp;&nbsp;
                                                                <i class="fa fa-arrow-right"></i>
                                                                &nbsp;&nbsp;
                                                                <span><?php echo $iataCode_arrival; ?></span>
                                                                <input type="hidden" name="iataCode_arrival[]" value="<?php echo $iataCode_arrival; ?>">
                                                            </strong></p>
                                                            <p>
                                                                Departure&nbsp;&nbsp;
                                                                <small><?php echo date('D d-M-Y', strtotime($flight_segments['flightSegment']['departure']['at'])); ?>
                                                                &nbsp;<?php echo date('H:i:s a', strtotime($flight_segments['flightSegment']['departure']['at'])); ?>
                                                                <input type="hidden" name="departure_at[]" value="<?php echo $flight_segments['flightSegment']['departure']['at']; ?>">
                                                                &nbsp;UTC <?php echo $flight_segments['flightSegment']['departure']['at'][19] . $departure_at_time[1]; ?></small><br>
                                                                Arrival&nbsp;&nbsp; <small><?php echo date('D d-M-Y', strtotime($flight_segments['flightSegment']['arrival']['at'])); ?>
                                                                &nbsp;<?php echo date('H:i:s a', strtotime($flight_segments['flightSegment']['arrival']['at'])); ?>
                                                                &nbsp;UTC <?php echo $flight_segments['flightSegment']['arrival']['at'][19] . $arrival_at_time[1]; ?></small>
                                                                <input type="hidden" name="arrival_at[]" value="<?php echo $flight_segments['flightSegment']['arrival']['at']; ?>">
                                                            </p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <small><p style="text-align: right;">
                                                                Travel Class: <?php echo($flight_segments['pricingDetailPerAdult']['travelClass']); ?>
                                                                <input type="hidden" name="travelclass[]" value="<?php echo($flight_segments['pricingDetailPerAdult']['travelClass']); ?>">
                                                                <br>
                                                                Available Seats: <?php echo($flight_segments['pricingDetailPerAdult']['availability']); ?>
                                                                <input type="hidden" name="seats[]" value="<?php echo($flight_segments['pricingDetailPerAdult']['availability']); ?>">                         
                                                            </p></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++; } ?>
                                                
                                            <?php } ?>
                                            <div class="col-md-12 col-sm-12">
                                                <!-- <pre>
                                                    <?php print_r($flight_offers); ?>
                                                </pre> -->
                                                <span class="btn btn-primary btn-sm btn-round">
                                                    Total Passengers <?php echo $amadeus_data['totalpassengers']; ?>
                                                    <input type="hidden" name="totalpassengers" value="<?php echo $amadeus_data['totalpassengers'];  ?>" />
                                                </span>
                                                &nbsp;
                                                <span class="btn btn-primary btn-sm btn-round">
                                                    Adults <?php echo $amadeus_data['madult']; ?>
                                                    <input type="hidden" name="madult" value="<?php echo $amadeus_data['madult'];  ?>" />
                                                    <?php   
                                                    if (!empty($flight_offers['pricePerAdult'])) { ?>
                                                        <input type="hidden" name="pricePerAdult[total]" value="<?php echo calculate_commission($flight_offers['pricePerAdult']['total'],$amadeus_data['commission']); ?>">
                                                        <input type="hidden" name="pricePerAdult[totalTaxes]" value="<?php echo $flight_offers['pricePerAdult']['totalTaxes']; ?>">
                                                    <?php  }
                                                    ?>
                                                </span>
                                                &nbsp;
                                                <span class="btn btn-primary btn-sm btn-round">
                                                    Childrens <?php echo $amadeus_data['mchildren']; ?>
                                                    <input type="hidden" name="mchildren" value="<?php echo $amadeus_data['mchildren'];  ?>" />
                                                    <?php   
                                                    if (!empty($flight_offers['pricePerChild'])) { ?>
                                                        <input type="hidden" name="pricePerChild[total]" value="<?php echo calculate_commission($flight_offers['pricePerChild']['total'],$amadeus_data['commission']); ?>">
                                                        <input type="hidden" name="pricePerChild[totalTaxes]" value="<?php echo $flight_offers['pricePerChild']['totalTaxes']; ?>">
                                                    <?php  }
                                                    ?>
                                                </span>
                                                &nbsp;
                                                <span class="btn btn-primary btn-sm btn-round">
                                                    Infants <?php echo $amadeus_data['minfant']; ?>
                                                    <input type="hidden" name="minfant" value="<?php echo $amadeus_data['minfant'];  ?>" />
                                                    <?php   
                                                    if (!empty($flight_offers['pricePerInfant'])) { ?>
                                                        <input type="hidden" name="pricePerInfant[total]" value="<?php echo calculate_commission($flight_offers['pricePerInfant']['total'],$amadeus_data['commission']); ?>">
                                                        <input type="hidden" name="pricePerInfant[totalTaxes]" value="<?php echo $flight_offers['pricePerInfant']['totalTaxes']; ?>">
                                                    <?php  }
                                                    ?>
                                                </span>
                                                &nbsp;
                                                <span class="btn btn-primary btn-sm btn-round">
                                                    Seniors <?php echo $amadeus_data['seniors']; ?>
                                                    <input type="hidden" name="seniors" value="<?php echo $amadeus_data['seniors'];  ?>" />
                                                    <?php   
                                                    if (!empty($flight_offers['pricePerSenior'])) { ?>
                                                        <input type="hidden" name="pricePerSenior[total]" value="<?php echo calculate_commission($flight_offers['pricePerSenior']['total'],$amadeus_data['commission']); ?>">
                                                        <input type="hidden" name="pricePerSenior[totalTaxes]" value="<?php echo $flight_offers['pricePerSenior']['totalTaxes']; ?>">
                                                    <?php  }
                                                    ?>
                                                </span>
                                                <span class="pull-right" >
                                                    <div style="text-align:right">Total Price : <?php echo $amadeus_data['currency']; ?> <?php echo number_format(($flight_offers['price']['total']*($amadeus_data['commission']/100))+$flight_offers['price']['total'], 2); ?><br>
                                                        Total Tax : <?php echo $amadeus_data['currency']; ?> <?php echo number_format($flight_offers['price']['totalTaxes'],2); ?>
                                                    </div>
                                                    <input type="hidden" name="currency" value="<?php echo $amadeus_data['currency']; ?>">
                                                    <input type="hidden" name="currencysymbol" value="<?php echo $amadeus_data['currencysymbol']; ?>" id="currency">
                                                    <input type="hidden" name="total_with_commission" value="<?php echo calculate_commission($flight_offers['price']['total'],$amadeus_data['commission']);?>">
                                                    <input type="hidden" name="total" value="<?php echo $flight_offers['price']['total']; ?>">
                                                    <input type="hidden" name="totalTaxes" value="<?php echo $flight_offers['price']['totalTaxes']; ?>">
                                                    <br>
                                                    <input type="submit" class="btn btn-primary btn-sm pull-right btn-round" name="flight_offers" value="Book Now" />
                                                    <br><br>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            } 
                        } 
                    }
                } else { ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <i class='fa fa-ban'></i> Not Found
                        </div>
                        <div class="panel-body">
                            No Flight Found.
                        </div>
                    </div>
                <?php }
                ?>
            </table>
        </div>
        <style type="text/css">
        body {
            font-weight: 700;
            background: #f2f2f2;
        }
        .select2-container {
            height: 60px;
        }

        .select2-selection__arrow {
            display: none;
        }

        .select2-selection--single {
            border: none !important;
            border-left: 2px solid #e9e9e9 !important;
            border-radius: 0px !important;
            padding: 12px 2px;
            background: transparent;
            height: 50px !important;
        }

        .input-lg, .bgfade {
            border: none;
            border-left: 2px solid #e9e9e9 !important;
        }
    </style>
</div>
<script type="text/javascript">
    function show_ajax(){
    }
</script>
</div>
<script type="text/javascript">
    $("input:radio").click(function () {
        var showAll = true;
        $('tr').not('.first').hide();
        $('input[type=radio]').each(function () {
            if ($(this)[0].checked) {
                showAll = false;
                var status = $(this).attr('rel');
                var value = $(this).val();
                $('div[rel="' + value + '"]').parent('form').parent('td').parent('tr').show();
            }
        });
        if(showAll){
            $('tr').show();
        }
    });
</script>