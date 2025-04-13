<style>
    .sidebars {
        position: absolute;
        max-width: 270px;
        float: left;
        margin-bottom: 15px
    }
    

    /*============================================================================================*/
    /* Flights */
    /*============================================================================================*/
    .list:nth-child(odd) {
        border: 2px solid transparent;
        background: #fff;
    }

    .list:nth-child(even) {
        border: 2px solid transparent;
        background: #f3f3f3 !important;
    }

    .list:hover {
        background: #e3e3e3 !important;
    }

    .list:hover {
        border: 2px solid #0031bc !important;
    }

    .flights_list h1,
    .flights_list h2,
    .flights_list h3,
    .flights_list h4,
    .flights_list h5,
    .flights_list h6,
    .flights_list p {
        margin: 0px !important
    }

    .flights_list .airline-detail img {
        max-width: 32px
    }

    .flights_list .img-line img {
        max-width: 16px
    }

    .flights_list .btn-danger {
        font-size: 10px;
        letter-spacing: 0px;
    }

    .flights_list .flight-time h4 {
        font-weight: bold;
        padding-top: 10px;
    }

    .flights_list .collapse {
        margin-bottom: 20px;
    }

    .bg-white {
        background: #fff
    }

    .airline-detail {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 5px 5px;
        align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center
    }

    .flight-time {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 10px 0;
        -webkit-box-pack: center;
        -ms-flex-pack: center
    }

    .flight-no {
        margin-left: 10px;
        align-self: center;
        -ms-flex-item-align: center;
        -ms-grid-row-align: center
    }

    .liner {
        position: absolute;
        top: 7.5px;
        width: 90%;
        border-bottom: 1px dotted #333
    }

    .liner_dot {
        width: 7px;
        height: 7px;
        background: #ff8d19;
        border: 1px solid #ff8d19;
        border-radius: 6px;
        top: 4px;
        position: absolute;
        margin: 0 45%;
    }

    .img-line {
        position: relative
    }

    .flight-depart {
        padding-left: 10px;
        -webkit-box-flex: 2;
        -ms-flex: 2;
        flex: 2
    }

    .trip-map {
        text-align: center;
        -webkit-box-flex: 6;
        -ms-flex: 6;
        flex: 6
    }

    .flight-arrival {
        padding-left: 10px;
        -webkit-box-flex: 2;
        -ms-flex: 2;
        flex: 2
    }

    .bt1 {
        border-top: 1px solid #f4f6f8
    }

    .mylabel {
        color: #333;
        border: 1px solid #333;
        border-radius: 10px;
        background-color: #fff
    }

    .myicon {
        padding-right: 5px;
        color: #1dac08 !important
    }

    .flight-details {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-top: 15px;
        flex-direction: column;
        align-items: center;
        -webkit-box-align: center;
        -webkit-box-direction: normal;
        -webkit-box-orient: vertical;
        -ms-flex-align: center;
        -ms-flex-direction: column
    }

    .baggage {
        margin-top: 10px
    }

    .s-flight {
        padding-top: 10px
    }

    .s-flight h2 {
        font-size: 20px;
        font-weight: 900;
    }

    .detail-header {
        padding: 5px;
        border-bottom: 1px solid #e5e5e5;
        background: #f2f2f2
    }

    .btn-fi {
        padding: 5px 20px;
        margin-right: 10px;
        border-radius: 0;
        display: static !important
    }

    .arrow-bg {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 15px;
        text-align: center;
        color: #fff;
        border-radius: 50%;
        background: #1dac08
    }

    .total-duration {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 10px;
        border-bottom: 1px solid #f4f6f8
    }

    .duration-time {
        padding: 4px 14px;
        color: #333;
        border-radius: 10px;
        background: #e7e7e7;
        font-size: 12px;
        line-height: 2px;
    }

    .duration-time i {
        color: #fff
    }

    .none-stop {
        padding: 9px 10px;
        margin-left: 15px;
        color: #fff;
        border-radius: 10px;
        background: #3e3e3e;
        font-size: 12px;
        line-height: 2px;
    }

    .duration-stop {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-left: auto
    }

    .flight {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: 10px;
        border-right: 1px solid #f4f6f8;
        align-items: center;
        -webkit-box-align: center;
        -ms-flex-align: center
    }

    .aircraft {
        margin-left: 20px;
        -webkit-transform: translateY(8px);
        -ms-transform: translateY(8px);
        transform: translateY(8px);
        align-self: flex-end;
        -ms-flex-item-align: end
    }

    .Depart {
        margin: 10px;
        border-right: 1px solid #f4f6f8
    }

    .d-margin {
        display: inline-block;
        margin-bottom: 20px
    }

    .Arrives {
        margin: 10px;
        border-right: 1px solid #f4f6f8
    }

    .Class {
        margin: 10px
    }

    .tab-footer {
        padding: 20px;
        border-top: 1px solid #f4f6f8
    }

    .tab-footer i {
        margin-left: 10px
    }

    .btn-0 {
        border-radius: 0
    }

    .d-flex {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex
    }

    .btn-select {
        margin-left: auto
    }

    .flight-content {
        margin: 0px 0 10px 0px;
    }

    .flights_list .list:hover img {
        opacity: 10;
        width: 100%;
        -webkit-transform: none;
        transform: none;
        background: transparent;
    }

    .flights_list .list .btn {
        display: inline-block;
    }

    .flights_list .list:hover .btn {
        position: inherit;
        min-width: 0
    }

    /*============================================================================================*/
    /* Flights */
    /*============================================================================================*/
</style>

<style>
    .summary {
        border-right: solid 2px rgb(0, 93, 247);
        color: #ffffff;
        background: #4285f4;
        padding: 14px;
        float: left;
        font-size: 14px;
    }

    .sideline {
        margin-top: 15px;
        margin-bottom: 15px;
        padding-left: 15px;
        display: table-cell;
        border-left: solid 1px #e7e7e7;
    }

    .localarea {
        margin-top: 15px;
        margin-bottom: 15px;
        padding-left: 15px;
    }

    .captext {
        display: block;
        font-size: 14px;
        font-weight: 400;
        color: #23527c;
        line-height: 1.2em;
        text-transform: capitalize;
    }

    .ellipsis {
        max-width: 250px;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .noResults {
        right: 30px;
        top: 26px;
        color: #008cff;
        font-size: 16px;
    }

    .table {
        margin-bottom: 5px;
    }

    .fa-arrow-right {
        font-size: 10px;
    }

    a.disabled {
        pointer-events: none;
        cursor: default;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #EEEEEE;
    }
</style>
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

<div class="search_head" style="margin-bottom:25px">
    <div class="container">
        <?php include $themeurl . 'views/modules/travelhope_flight/main_search.php'; ?>
    </div>
</div>


<div class="visible-xs">
    <div style="margin:-20px 5px 10px 5px">
        <div class="row">
            <div class="col-xs-6 pr5">
                <button type="button" class="btn btn-primary btn-block br4" data-toggle="modal" data-target="#FILTER"><i
                            class="fa fa-bars"></i> <?= lang('0222') ?> </button>
            </div>
            <div class="col-xs-6 pl5">
                <button type="button" class="btn btn-default btn-block br4" data-toggle="modal" data-target="#MODIFY"><i
                            class="fa fa-search"></i> <?= lang('0223') ?> </button>
            </div>
        </div>
    </div>
    <div class="modal left fade" id="FILTER" tabindex="1" role="dialog" aria-labelledby="FILTER">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <h4 class="modal-title" id="FILTER"><?= lang('0222') ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flights_list container">

    <div class="hidden-xs sidebars">
        <div class="col-sm-12 col-md-12">
            <?php include $themeurl . 'views/modules/travelhope_flight/partials/filter.php'; ?>
        </div>
    </div>
    <?php if ($flights['code'] == 200 && !empty($flights['data'])) {
        ?>
        <div class="col-md-9 pull-right fn p3" style="padding: 0 10px;min-height:800px" id="all_flights">

            <input value="<?= count($flights['data']); ?>" type="hidden" id="available_flights">
            <?php //dd($flights['data']); ?>
            <?php foreach ($flights['data'] as $key => $value) {
                $stops_return = 0;
                $stops = 0;
                foreach ($value['route'] as $route) {
                    if ($route['return'] == 1) {
                        $stops_return++;
                    } else {
                        $stops++;
                    }
                }
                ?>
                <div class="bg-white flight-content list wow fadeIn">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mlr0">
                                <div class="col-md-4 col-xs-3">
                                    <div class="airline-detail">
                                        <img class="img-responsive"
                                             src="<?= PT_FLIGHTS_AIRLINES . $value['airline']; ?>.png" alt="">
                                        <div class="flight-no">
                                            <div><strong><?= ucwords(get_airline_name($value['airline'])); ?></strong>
                                            </div>
                                            <span><?php echo $value['airline']; ?> <a class="down hidden-xs"
                                                                                      role="button"
                                                                                      data-toggle="collapse"
                                                                                      href="#flight_details<?= $key ?>"
                                                                                      aria-expanded="false"
                                                                                      aria-controls="flight_details<?= $key ?>">Details <i
                                                            class="fa fa-angle-right"></i></a></span>
                                            <div class="clearfix"></div>
                                            <!--<span data-toggle="tooltip" data-placement="top" title="free cabin & checked baggage" class="label label-default mylabel hidden-xs"> <i class="fa fa-check-circle myicon"></i> Baggage included </span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xs-9">
                                    <div class="flight-time">
                                        <div class="flight-depart">
                                            <h4><?php echo date("H:i", $value['departure_time']); ?></h4>
                                            <span><?php echo $value['from_code']; ?></span>
                                        </div>
                                        <div class="trip-map">
                                            <h5><?php echo $value['flight_duration']; ?></h5>
                                            <div class="img-line">
                                                <img src="<?php echo $theme_url; ?>assets/img/plane.png" alt=""
                                                     class="img-responsive">
                                                <div class="liner"></div>
                                                <?php if (($stops - 1) > 1) { ?>
                                                    <div class="liner_dot"></div>
                                                <?php } ?>
                                            </div>
                                            <span><?php if (($stops - 1) == 0) {
                                                    echo "Direct";
                                                } else {
                                                    echo ($stops - 1) . " Stop";
                                                }; ?></span>
                                        </div>
                                        <div class="flight-arrival">
                                            <h4><?php echo date("H:i", $value['arrival_time']); ?></h4>
                                            <span><?php echo $value['to_code'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($value['routes'][1])) {
                                if (!empty($value['return_arrival'])) {
                                    $return_datetime1 = new DateTime(date("Y-m-d h:i:s a", $value['return_departure']));
                                    $return_datetime2 = new DateTime(date("Y-m-d h:i:s a", $value['return_arrival']));
                                    $return_interval = $return_datetime1->diff($return_datetime2);
                                    $return_duration = $return_interval->format('%h') . "h " . $return_interval->format('%i') . "m";
                                } else {
                                    $return_duration = "";
                                }
                                ?>
                                <hr style="margin-top: 0px; margin-bottom: 0px; border: 0; border-top: 1px solid #d6d6d6;">
                                <div class="row mlr0">
                                    <div class="col-md-4 col-xs-3">
                                        <div class="airline-detail">
                                            <img class="img-responsive"
                                                 src="<?= site_url('uploads/images/flights/airlines/' . $value['return_departure_airline']) ?>.png"
                                                 alt="">
                                            <div class="flight-no">
                                                <div>
                                                    <strong><?= ucwords(get_airline_name($value['return_departure_airline'])); ?></strong>
                                                </div>
                                                <span><?php echo $value['return_departure_airline']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-xs-9">
                                        <div class="flight-time">
                                            <div class="flight-arrival">
                                                <h4><?= date('H:i', $value['return_arrival']); ?></h4>
                                                <span><?= $value['routes'][1][1] ?></span>
                                            </div>
                                            <div class="trip-map">
                                                <h5><?= $return_duration; ?></h5>
                                                <div class="img-line">
                                                    <img src="<?php echo $theme_url; ?>assets/img/plane_rewind.png"
                                                         alt="" class="img-responsive">
                                                    <div class="liner"></div>
                                                    <?php echo $stops_return;
                                                    if ($stops_return > 1) { ?>
                                                        <div class="liner_dot"></div>
                                                    <?php } ?>
                                                </div>
                                                <span><?php if (($stops_return - 1) == 0) {
                                                        echo "Direct";
                                                    } else {
                                                        echo ($stops_return - 1) . " Stop";
                                                    }; ?></span>
                                            </div>
                                            <div class="flight-depart">
                                                <h4><?= date('H:i', $value['return_departure']) ?></h4>
                                                <span><?= $value['routes'][1][0] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-2 text-center flight-time">
                            <div class="flight-arrival">
                                <h4 class="hidden-xs"><?= number_format($value['flight_price']); ?></h4>
                                <span class="hidden-xs"><?php echo $value['currency']; ?></span>
                            </div>
                        </div>

                        <div class="col-md-2 text-center s-flight flights_mob_price"
                             style="padding-right:25px;padding-top: 18px;">
                            <form action="<?= site_url('thflights/checkout'); ?>" method="post" id="form_<?= $key ?>">
                                <input type="hidden" name="booking_token"
                                       value="<?= $value['custom_payload']['booking_token'] ?>">
                                <input type="hidden" name="flight_id" value="<?= $value['flight_id'] ?>">
                                <input type="hidden" name="visitor_uniqid"
                                       value="<?= $value['custom_payload']['visitor_uniqid']; ?>">
                                <input type="hidden" name="flight_price" value="<?= $value['flight_price']; ?>">
                                <input type="hidden" name="payload" value='<?php echo json_encode($payload); ?>'>
                                <div class="progress-btn">
                                    <button data-style="expand-left"
                                            class="btn btn-primary btn-block ladda-button spin click" type="submit">
                                        <span class="ladda-label"><span
                                                    class="hidden-md hidden-lg"><?php echo $value['currency']; ?> <?= number_format($value['flight_price']); ?></span> <?= lang('0142') ?></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="collapse bgwhite" id="flight_details<?= $key ?>">
                        <div class="detail-header">
                            <button class="btn btn-primary btn-fi"><?= lang('0224') ?></button>
                            <!--<a href="#">Fare Summary and Rules</a>-->
                        </div>
                        <?php foreach ($value['route'] as $routes):
                            $datetime1 = new DateTime(date("Y-m-d h:i:s a", $routes['arrival_utc_time']));
                            $datetime2 = new DateTime(date("Y-m-d h:i:s a", $routes['departure_utc_time']));
                            $interval = $datetime1->diff($datetime2);
                            $duration = $interval->format('%h') . "h " . $interval->format('%i') . "m";
                            ?>
                            <div class="total-duration">
                                <div>
                                    <span class="arrow-bg"><i class="fa fa-arrow-right"></i></span>
                                    <strong><?= lang('0226') ?><?php echo date("l d M Y", $routes['departure_time']); ?> <?= lang('023') ?><?php echo $routes['city_from'] ?> <?= lang('024') ?><?php echo $routes['city_to'] ?></strong>
                                </div>
                                <div class="duration-stop">
                                    <div class="duration-time">
                                        <i class="fa fa-clock-o"></i>
                                        <span><?= lang('0225') ?> : <?php echo $duration; ?></span>
                                    </div>
                                    <span class="none-stop"><?= lang('0227') ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="flight">
                                        <div>
                                            <span class="d-margin"><?= lang('038') ?></span>
                                            <div class="clearfix"></div>
                                            <img src="<?= site_url('uploads/images/flights/airlines/' . $routes['airline']) ?>.png"
                                                 alt="<?= $routes['airline'] ?>">
                                        </div>
                                        <div class="aircraft">
                                            <div><?= ucwords(get_airline_name($routes['airline'])); ?></div>
                                            <div><?= $routes['airline'][0] ?><?php echo $routes['flight_no']; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="Depart">
                                        <span class="d-margin"><?= lang('0228') ?></span>
                                        <div><?php echo date("l d M Y", $routes['departure_time']); ?></div>
                                        <div><strong><?php echo date("H:i", $routes['departure_time']); ?></strong>
                                        </div>
                                        <div><?php echo $routes['city_from'] ?>
                                            - <?php echo $routes['from_code'] ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="Arrives">
                                        <span class="d-margin"><?= lang('0229') ?></span>
                                        <div><?php echo date("l d M Y", $routes['arrival_time']); ?></div>
                                        <div><strong><?php echo date("H:i", $routes['arrival_time']); ?></strong></div>
                                        <div><?php echo $routes['city_to'] ?> - <?php echo $routes['to_code'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="Class">
                                        <span class="d-margin"><?= lang('0230') ?></span>
                                        <div><?= lang('0231') ?></div>
                                        <div><?= lang('0232') ?>:
                                            <?= $value['baglimit']['hand_width'] ?>
                                            x <?= $value['baglimit']['hand_length'] ?>
                                            x <?= $value['baglimit']['hand_height'] ?>
                                            , <?= $value['baglimit']['hand_weight']; ?> <?= lang('0233') ?>
                                        </div>
                                        <div>
                                            <?= lang('0234') ?>
                                            : <?php if (!empty($value['bags_price'][1]) && $value['bags_price'][1] == 0) {
                                                echo $value['baglimit']['hold_weight'] ?> <?= lang('0233') ?><?php } ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="tab-footer">
                            <div class="row">
                                <div class="d-flex">
                                    <div class="col-md-4 btn-chose">
                                        <a href="#flight_details<?= $key ?>"></a>
                                        <a class="btn btn-block btn-default" role="button" data-toggle="collapse"
                                           href="#flight_details<?= $key ?>" aria-expanded="false"
                                           aria-controls="flight_details<?= $key ?>"><?= lang('0235') ?></a>
                                    </div>
                                    <div class="col-md-3 btn-select">
                                        <button onclick="$('#form_<?= $key ?>').submit();"
                                                class="btn btn-danger btn-block btn-0"><strong>Select
                                                flight <?php echo $value['currency']; ?> <?= $value['flight_price']; ?>
                                                <i class="fa fa-chevron-right"></i></strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
    <?php } else { ?>
    <div style="margin-top:-25px;min-height: 350px; padding: 25px;">
        <img src="<?php echo $theme_url; ?>assets/img/not_found.gif" style="max-width:200px"
             class="img-responsive center-block" alt="not found"/>
        <h4 style="margin: 25px 0 10px !important;" class="form-group text-center"><strong>Data Not Found</strong></h4>
        <p class="text-center"><?= $flights['status'] ?>: <?= $flights['data'] ?> </p>
        <input value="0" type="hidden" id="available_flights">
    </div>
    <div>
        <?php } ?>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </div>

</div>