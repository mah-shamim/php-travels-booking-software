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
    <?php echo searchForm($appModule, $searchForm); ?>
</div>
<br>
<br>
<div class="container">
<div class="row">
    <div class="clearfix"></div>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">Air Lines</div>
            <div class="panel-body">
                <?php
                    foreach ($AirLowFareSearchRsp->filters->airlines as $airline) { ?>
                <p style="padding:5px:border-bottom:1px solid #e2e2e2">
                    <label>
                    <input type="radio" name="flights" value="<?php echo $airline->code; ?>" data-filtertype="carrier"/>
                    <img src="<?php echo $airline->image?>" style="width: 100px" alt="img"/>
                    </label>
                </p>
                <?php } ?>
            </div>
            <div class="panel-heading">Stops</div>
            <div class="panel-body">
                <label>
                <input type="radio" name="stops" value="1" data-filtertype="stops"/><span class="radio-label">1 Stop</span><br/>
                </label><br/>
                <label>
                <input type="radio" name="stops" value="2" data-filtertype="stops"/><span class="radio-label">2 Stops</span><br/>
                </label><br/>
                <label>
                <input type="radio" name="stops" value="3" data-filtertype="stops"/><span class="radio-label">3 Stops</span><br/>
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-9" >
        <div class="flight-listing" >
            <ul class="nav nav-pills nav-justified" role="tablist"></ul>
        </div>
        <!-- <div class="panel panel-danger">
            <div class="panel-heading">
                    <i class='fa fa-ban'></i> Not Found
            </div>
            <div class="panel-body">
                    No Flight Found.
            </div>
            </div> -->
        <div class="row">
            <div class="search-result-card-w">
                <?php foreach ($AirLowFareSearchRsp->itineraries as $itinerarie): ?>
                <form action="<?php echo site_url("airway/checkout"); ?>" method="POST">
                    <div  class="search-result-card">
                        <div class="search-result-card__leg-w">
                            <?php if(! empty($itinerarie->outbound->segments) ): ?>
                            <?php foreach ($itinerarie->outbound->segments as $index => $segment): ?>
                            <div data-carrier="<?=$segment->airline->code.':'.$index?>" data-stops="<?=$itinerarie->outbound->totalStops.':'.$index?>" class="card-flight-leg">
                                <div class="card-airline">
                                    <img src="<?=$segment->airline->image?>" alt="<?=$segment->airline->code?>">
                                    <div class="card-airline__details">
                                        <div><?=$searchForm->classOfService?></div>
                                        <div><?=$segment->flightNumber?></div>
                                    </div>
                                </div>
                                <div class="card-flight-leg__details">
                                    <div class="card-flight-leg__detail">
                                        <div class="card-flight-leg__time"><?=$segment->departure->time?></div>
                                        <div class="card-flight-leg__city">
                                            <div class="reactooltip-w tooltip__origin" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;"><?=$segment->departure->airport->code?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="trip-line">
                                        <div class="trip-line__duration">
                                            <!--<?=$segment->departure->date?> At--> <?=$segment->departure->time?>
                                        </div>
                                        <div><img src="<?php echo $theme_url; ?>assets/img/plane.svg" class="" alt=""></div>
                                        <div class="trip-line__line"></div>
                                        <div class="trip-line__dots-w">
                                            <div class="trip-line__dot"></div>
                                        </div>
                                        <div class="trip-line__stops">
                                            <?=$itinerarie->outbound->totalStops?> Stop
                                            <div class="reactooltip-w tooltip__stops" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;">
                                                    <span>
                                                        <!--KWI-->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-flight-leg__detail">
                                        <div class="card-flight-leg__time">
                                            <!--<?=$segment->arrival->date?> At--> <?=$segment->arrival->time?>
                                        </div>
                                        <div class="card-flight-leg__city">
                                            <div class="reactooltip-w tooltip__destination" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;"><?=$segment->arrival->airport->code?></div>
                                            </div>
                                        </div>
                                        <div class="card-flight-leg__days">
                                            <div class="reactooltip-w tooltip__leg-flag" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;"><!--+1--></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <!--/. Outbound -->
                            <?php endif; ?>
                            <?php if(! empty($itinerarie->inbound->segments) ): ?>
                            <?php foreach ($itinerarie->inbound->segments as $segment): ?>
                            <div class="card-flight-leg">
                                <div class="card-airline">
                                    <img src="<?=$segment->airline->image?>" alt="<?=$segment->airline->code?>">
                                    <div class="card-airline__details">
                                        <div><?=$searchForm->classOfService?></div>
                                        <div><?=$segment->flightNumber?></div>
                                    </div>
                                </div>
                                <div class="card-flight-leg__details">
                                    <div class="card-flight-leg__detail">
                                        <div class="card-flight-leg__time"> <?=$segment->departure->time?></div>
                                        <div class="card-flight-leg__city">
                                            <div class="reactooltip-w tooltip__origin" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;"><?=$segment->departure->airport->code?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="trip-line">
                                        <div class="trip-line__duration"> 07h 50m </div>
                                        <div><img src="<?php echo $theme_url; ?>assets/img/plane.svg" class="" alt=""></div>
                                        <div class="trip-line__line"></div>
                                        <div class="trip-line__dots-w">
                                            <div class="trip-line__dot"></div>
                                        </div>
                                        <div class="trip-line__stops">
                                            <?=$itinerarie->inbound->totalStops?> Stop
                                            <div class="reactooltip-w tooltip__stops" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;">
                                                    <span>
                                                        <!--KWI-->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-flight-leg__detail">
                                        <div class="card-flight-leg__time"> <?=$segment->arrival->time?></div>
                                        <div class="card-flight-leg__city">
                                            <div class="reactooltip-w tooltip__destination" style="position: relative; display: inline-block;">
                                                <div class="reactooltip-w__child" style="width: auto;"><?=$segment->arrival->airport->code?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <!--<div class="search-result-card__details">
                            <div id="flight-details-0-0" class="search-result-card__flight-details">Flight details<i class="fa fa-chevron-down"></i></div>
                            <div class="search-result-card__baggage-info">
                                <div class="reactooltip-w tooltip__baggage" style="position: relative; display: inline-block;">
                                    <div class="reactooltip-w__child" style="width: auto;"><img src="<?php echo $theme_url; ?>assets/img/baggage.svg" alt="">Baggage included</div>
                                </div>
                            </div>
                        </div>-->
                        <div class="search-result-card__cta">
                            <div>
                                <div class="search-result-card__price-details">
                                    <div class="search-result-card__currency"><?= $itinerarie->priceDetail->totalFare->CurrencyCode ?></div>
                                    <div class="search-result-card__price"><?= ($itinerarie->priceDetail->totalFare->Amount+$itinerarie->priceDetail->customFare->administrationFee->amount) ?></div>
                                </div>
                                <div class="search-result-card__action">
                                    <input type="hidden" name="itinerarie" value='<?=json_encode($itinerarie)?>'/>
                                    <input type="hidden" name="searchForm" value='<?=serialize($searchForm)?>'/>
                                    <input type="submit" class="btn btn-cta  btn-success" value="Select flight"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<!--<span class="btn btn-primary btn-sm btn-round">
Total Passengers <?=$searchForm->passenger->total()?>
</span>
&nbsp;
<span class="btn btn-primary btn-sm btn-round">
Adults <?=$searchForm->passenger->adult?>
</span>
&nbsp;
<span class="btn btn-primary btn-sm btn-round">
Childrens <?=$searchForm->passenger->children?>
</span>
&nbsp;
<span class="btn btn-primary btn-sm btn-round">
Infants <?=$searchForm->passenger->infant?>
</span>-->

<style type="text/css">
.radio-label { margin-left: 10px; }
 body{font-weight:700;background:#fff}
.table td{transition:.2s ease-in-out;box-shadow:0 10px 20px rgba(0,0,0,0.19),0 6px 6px rgba(0,0,0,0.23)}
.table td:hover{transform:scale(1.05)}
.search_head{padding-top:35px;padding-bottom:35px}
.select2-container{height:50px}
.select2-selection__arrow{display:none}
.select2-selection--single{border:none!important;border-left:2px solid #e9e9e9!important;border-radius:0!important;padding:12px 2px;background:transparent;height:50px!important}
.input-lg,.bgfade{border:0}
button{color:inherit;font:inherit;margin:0}
button{overflow:visible}
button{text-transform:none}
button{-webkit-appearance:button;cursor:pointer}
button::-moz-focus-inner{border:0;padding:0}
@media print{img{page-break-inside:avoid}
*,:after,:before{background:0 0!important;color:#000!important;-webkit-box-shadow:none!important;box-shadow:none!important;text-shadow:none!important}
img{max-width:100%!important}
}.btn,.btn:active{background-image:none}
*,:after,:before{-webkit-box-sizing:border-box;box-sizing:border-box}
button{font-family:inherit;font-size:inherit;line-height:inherit}
.btn{text-align:center}
.btn{display:inline-block;margin-bottom:0;font-weight:400;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;border:1px solid transparent;white-space:nowrap;padding:6px 12px;font-size:14px;line-height:1.42857;border-radius:4px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
.btn:active:focus,.btn:focus{outline:-webkit-focus-ring-color auto 5px;outline-offset:-2px}
.btn:focus,.btn:hover{color:#333;text-decoration:none}
.btn:active{outline:0;-webkit-box-shadow:inset 0 3px 5px rgba(0,0,0,.125);box-shadow:inset 0 3px 5px rgba(0,0,0,.125)}
.bi .btn{background-image:none}
.bi img{border:0;vertical-align:middle}
.bi button{color:inherit;font:inherit;margin:0}
.bi button{overflow:visible}
.bi button{text-transform:none}
.bi button{-webkit-appearance:button;cursor:pointer}
.bi button::-moz-focus-inner{border:0;padding:0}
.bi *,.bi :after,.bi :before{box-sizing:border-box}
.bi button{font-family:inherit;font-size:inherit;line-height:inherit}
.bi .btn{white-space:nowrap}
.bi .btn{display:inline-block;margin-bottom:0;font-weight:400;text-align:center;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;border:1px solid transparent;padding:12px 15px;font-size:12px;line-height:1.428571;border-radius:2px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
.bi .btn:active:focus,.bi .btn:focus{outline:-webkit-focus-ring-color auto 5px;outline-offset:-2px}
.bi .btn:focus,.bi .btn:hover{color:#123867;text-decoration:none}
.bi .btn:active{outline:0;background-image:none;box-shadow:inset 0 3px 5px rgba(0,0,0,.125)}
.bi .btn-cta{color:#fff;border-color:#f6c857;background:#e7412a;font-weight:600}
.bi .btn-cta:focus{color:#fff;background-color:#c82c16;border-color:#c38e0a}
.bi .btn-cta:active,.bi .btn-cta:hover{color:#fff;background-color:#c82c16;border-color:#f3b51d}
.bi .btn-cta:active:focus,.bi .btn-cta:active:hover{color:#fff;background-color:#a72513;border-color:#c38e0a}
.bi .btn-cta:active{background-image:none}
.bi .btn-cta:active,.bi .btn-cta:hover{background:#e7412a}
.bi .btn-cta:after{content:' ';position:absolute;top:0;bottom:0;left:0;right:0;opacity:0;border-radius:2px}
.bi .btn,.bi .btn:active{transition:transform .3s!important;transition:transform .3s,-webkit-transform .3s!important}
.bi .btn{position:relative;-webkit-transform:scale(1);-ms-transform:scale(1);transform:scale(1)}
.bi .btn:active{-webkit-transform:scale(.96);-ms-transform:scale(.96);transform:scale(.96)}
.bi .ab .btn-cta{background:#f6c957;border-radius:2px}
@media print{.bi *,.bi:after,.bi:before{background:0 0!important;color:#000!important;box-shadow:none!important;text-shadow:none!important}
.bi img{page-break-inside:avoid}
.bi img{max-width:100%!important}
}.bi .btn-cta:hover{background:#3a3a3a!important;-webkit-box-shadow:none!important;box-shadow:none!important;cursor:pointer!important}
.search-result-card{display:-webkit-box;display:-ms-flexbox;display:flex;min-height:101px;justify-items:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;border-radius:2px;background-color:#fff;border:1.3px solid #ccc;position:relative;margin-bottom:10px}
.search-result-card__cta,.search-result-card__details{align-self:stretch;display:-webkit-box;display:-ms-flexbox}
.search-result-card__leg-w{-webkit-box-flex:7.5;-ms-flex:7.5;flex:7.5}
.search-result-card__leg-w .card-flight-leg:not(:first-child){border-top:1px solid #dfdfdf}
.search-result-card__details{-webkit-box-flex:1.5;-ms-flex:1.5;flex:1.5;margin-right:10px;display:flex;position:relative;-ms-flex-item-align:stretch;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end}
.search-result-card__flight-details{cursor:pointer;font-size:12px;font-weight:600;letter-spacing:.2px;color:#3665ac;padding-left:10px}
.search-result-card__flight-details i{margin-left:5px}
.search-result-card__cta{-ms-flex-item-align:stretch;-webkit-box-flex:1.4;-ms-flex:1.4;flex:1.4;padding:10px;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;border-left:dashed 1px #ccc}
.search-result-card__cta div{text-align:right}
.search-result-card__price-details{width:100%;text-align:right}
.search-result-card__price{font-size:25px;font-weight:700;color:#3a3a3a}
.search-result-card__currency{text-align:right;font-size:12px;font-weight:500;color:#3a3a3a;margin-bottom:-7px;padding-right:1px}
.search-result-card__action{margin-right:-2px}
.search-result-card__action button.btn{font-size:14px;padding:8px;font-weight:600}
.search-result-card__action button.btn i{margin-left:9px}
.search-result-card__baggage-info{position:absolute;bottom:10px;right:0;font-size:10px;color:#3a3a3a;border-radius:9.5px;background-color:#fff;border:.6px solid #ccc;line-height:1.8;padding:0 5px}
.search-result-card__baggage-info img{width:11px;margin-right:2px;margin-bottom:1px}
@media(max-width:1200px){.search-result-card__leg-w{-webkit-box-flex:6.5;-ms-flex:6.5;flex:6.5}
.search-result-card__details{-webkit-box-flex:1.7;-ms-flex:1.7;flex:1.7}
}.card-flight-leg{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;padding:10px 54px 10px 15px}
.card-flight-leg .card-airline{-webkit-box-flex:2;-ms-flex:2;flex:2}
.card-flight-leg__details{-webkit-box-flex:4.2;-ms-flex:4.2;flex:4.2;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}
.card-airline,.trip-line__dots-w{display:-webkit-box;display:-ms-flexbox}
.card-flight-leg__details .trip-line{-webkit-box-flex:6;-ms-flex:6;flex:6;margin-left:30px;margin-right:30px}
.card-flight-leg__detail{-webkit-box-flex:2;-ms-flex:2;flex:2;position:relative}
.card-flight-leg__detail:last-child{text-align:right}
.card-flight-leg__time{font-size:18px;font-weight:700;letter-spacing:.2px;color:#3a3a3a;margin-bottom:5px}
.card-flight-leg__city{font-size:14px;font-weight:300;color:#3a3a3a}
.card-flight-leg__days{position:absolute;right:-18px;top:-6px;font-size:14px;font-weight:600;color:#3a3a3a}
@media(max-width:1200px){.card-flight-leg{padding-left:8px;padding-right:15px}
.card-flight-leg .card-airline{margin-right:0}
.card-flight-leg .trip-line{margin-left:20px;margin-right:20px}
}.card-airline{display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-right:20px}
.card-airline img{width:40px;height:auto;margin-right:10px}
.card-airline__details{font-size:12px;font-weight:400;font-style:normal;font-stretch:normal;line-height:1.5;letter-spacing:normal;color:#3a3a3a;width:114px}
.trip-line{position:relative}
.trip-line div>img{z-index:1;position:relative;margin-bottom:2px}
.trip-line__dots-w,.trip-line__line{position:absolute;left:0;width:100%}
.trip-line__line{border-top:1px dashed #dfdfdf;top:50%}
.trip-line__dots-w{display:flex;top:47%;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;padding-left:16px}
.trip-line__dot{width:6px;height:6px;background:#ff8d19;border:1px solid #ff8d19;border-radius:6px}
.trip-line__duration{text-align:center;padding-left:16px;font-size:14px;font-weight:600;color:#333}
.trip-line__stops{text-align:center;padding-left:16px;font-size:12px;color:#ff8d19}
.search-result-card-w{margin:0 8px 10px;border-radius:2px}
*{-webkit-box-shadow:none!important;box-shadow:none!important}
.bi .btn-cta{-webkit-transition:all .3s ease-in-out!important;transition:all .3s ease-in-out!important;background:#e7412a!important;-webkit-box-shadow:0 0 0 0 #333,inset 0 -2px 0 0 rgba(0,0,0,.25)!important;box-shadow:0 0 0 0 #333,inset 0 -2px 0 0 rgba(0,0,0,.25)!important;border:none!important;color:#fff!important}
.bi .btn-cta i{color:#fff!important}
.bi .btn-cta:hover{color:#fff!important;background-color:#f25033!important;-webkit-box-shadow:0 2px 6px 0 rgba(0,0,0,.13),inset 0 -2px 2px 0 rgba(0,0,0,.25)!important;box-shadow:0 2px 6px 0 rgba(0,0,0,.13),inset 0 -2px 2px 0 rgba(0,0,0,.25)!important}
.bi .btn-cta:active{background:#e7412a;-webkit-box-shadow:inset 0 1px 2px 0 rgba(0,0,0,.35);box-shadow:inset 0 1px 2px 0 rgba(0,0,0,.35)}
.bi .btn{-webkit-transition:all .3s ease-in-out!important;transition:all .3s ease-in-out!important}
.bi .btn:disabled{background:#bfbfbf!important;-webkit-box-shadow:none!important;box-shadow:none!important;border:1px solid #d9d9d9!important}
.bi .btn:after{background:0 0!important}
body *{-webkit-user-drag:auto!important;-moz-user-drag:auto!important;-ms-user-drag:auto!important;user-drag:auto!important;-webkit-touch-action:auto!important;-moz-touch-action:auto!important;-ms-touch-action:auto!important;touch-action:auto!important}
:active,:focus{-moz-outline-style:none!important;outline:0!important}
:focus{outline:0!important}
button{-ms-touch-action:none;touch-action:none}
    </style>
</div>

<script type="text/javascript">
    $("input:radio").click(function () {
        var showAll = true;
        $('form').hide();
        $('input[type=radio]').each(function () {
            if ($(this)[0].checked) {
                showAll = false;
                var value = $(this).val();
                if ($(this).data('filtertype') === 'carrier') {
                    console.log('div[data-carrier="' + value + ':0"]');
                    $('div[data-carrier="' + value + ':0"]').parent().parent().parent().show();
                } else if ($(this).data('filtertype') === 'stops') {
                    console.log('div[data-stops="' + value + ':0"]');
                    $('div[data-stops="' + value + ':0"]').parent().parent().parent().show();
                }
            }
        });
        if(showAll) { 
            $('form').show(); 
        }
    });
</script>