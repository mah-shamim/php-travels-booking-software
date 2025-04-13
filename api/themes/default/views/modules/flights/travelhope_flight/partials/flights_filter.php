<?php
date_default_timezone_set('UTC');
if (!empty($flights)) { ?>
    <input value="<?= count($flights); ?>" type="hidden" id="available_flights">
    <?php
    foreach ($flights as $key => $value) {

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
        <div class="bg-white flight-content list">
            <div class="row">
                <div class="col-md-8">
                    <div class="row mlr0">
                        <div class="col-md-4">
                            <div class="airline-detail">
                                <img class="img-responsive"
                                     src="<?= PT_FLIGHTS_AIRLINES . $value['airline'];  ?>.png" ?>" alt="">
                                <div class="flight-no">
                                    <div><strong>
                                            <?= ucwords(get_airline_name($value['airline'])); ?>
                                        </strong>
                                    </div>
                                    <span><?php echo $value['airline']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="flight-time">
                                <div class="flight-depart">
                                    <h4>
                                        <?php echo date("H:i", $value['departure_time']); ?>
                                    </h4>
                                    <span><?php echo $value['from_code']; ?></span>
                                </div>
                                <div class="trip-map">
                                    <h5><?php echo $value['flight_duration']; ?>
                                    </h5>
                                    <div class="img-line">
                                        <img src="<?php echo $theme_url; ?>assets/img/plane.png" alt=""
                                             class="img-responsive">
                                        <div class="liner"></div>
                                        <?php if ($stops > 1) { ?>
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
                                    <h4>
                                        <?php echo date("H:i", $value['arrival_time']); ?>
                                    </h4>
                                    <span><?php echo $value['to_code'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($value['routes'][1])) {
	                    if ( ! empty( $value['return_arrival'] ) ) {
		                    $return_datetime1 = new DateTime( date( "Y-m-d h:i:s a", $value['return_departure'] ) );
		                    $return_datetime2 = new DateTime( date( "Y-m-d h:i:s a", $value['return_arrival'] ) );
		                    $return_interval  = $return_datetime1->diff( $return_datetime2 );
		                    $return_duration  = $return_interval->format( '%h' ) . "h " . $return_interval->format( '%i' ) . "m";
	                    } else {
		                    $return_duration = "";
	                    }
                        ?>
                        <hr style="margin-top: 0px; margin-bottom: 0px; border: 0; border-top: 1px solid #d6d6d6;">
                        <div class="row mlr0">
                            <div class="col-md-4">
                                <div class="airline-detail">
                                    <img class="img-responsive"
                                         src="<?= site_url( 'uploads/images/flights/airlines/' . $value['return_departure_airline'] ) ?>.png"
                                         alt="">
                                    <div class="flight-no">
                                        <div>
                                            <strong><?= ucwords( get_airline_name( $value['return_departure_airline'] ) ); ?></strong>
                                        </div>
                                        <span><?php echo $value['return_departure_airline']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="flight-time">
                                    <div class="flight-arrival">
                                        <h4><?= date( 'H:i', $value['return_arrival'] ); ?></h4>
                                        <span><?= $value['routes'][1][1] ?></span>
                                    </div>
                                    <div class="trip-map">
                                        <h5><?= $return_duration; ?></h5>
                                        <div class="img-line">
                                            <img src="<?php echo $theme_url; ?>assets/img/plane_rewind.png" alt=""
                                                 class="img-responsive">
                                            <div class="liner"></div>
				                            <?php if ( $stops_return > 1 ) { ?>
                                                <div class="liner_dot"></div>
				                            <?php } ?>
                                        </div>
                                        <span><?php if ( ( $stops_return - 1 ) == 0 ) {
					                            echo "Direct";
				                            } else {
					                            echo ( $stops_return - 1 ) . " Stop";
				                            }; ?></span>
                                    </div>
                                    <div class="flight-depart">
                                        <h4><?= date( 'H:i', $value['return_departure'] ) ?></h4>
                                        <span><?= $value['routes'][1][0] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-2">
                    <div class="flight-details">
                        <a class="down" role="button" data-toggle="collapse" href="#flight_details<?= $key ?>"
                           aria-expanded="false" aria-controls="flight_details<?= $key ?>">Flight Details <i
                                    class="fa fa-chevron-down"></i></a>
                        <div class="baggage">
                        <span data-toggle="tooltip" data-placement="top" title="free cabin & checked baggage"
                              class="label label-default mylabel"> <i class="fa fa-check-circle myicon"></i>Baggage included</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-md-2 text-center s-flight">
                        <span><?php echo $value['currency']; ?></span>
                        <h2><?= $value['flight_price']; ?></h2>
                        <form action="<?= site_url('flights/booking'); ?>" method="post" id="form_<?= $key ?>">
                            <input type="hidden" name="booking_token" value="<?= $value['custom_payload']['booking_token'] ?>">
                            <input type="hidden" name="flight_id" value="<?= $value['flight_id'] ?>">
                            <input type="hidden" name="visitor_uniqid" value="<?= $value['custom_payload']['visitor_uniqid']; ?>">
                            <input type="hidden" name="flight_price" value="<?= $value['flight_price']; ?>">
                            <input type="hidden" name="currency" value="<?php echo $value['currency']; ?>">
                            <button style="margin-left:-10px" class="btn btn-primary btn-block click" type="submit">Book
                                Now <i class="fa fa-angle-right"></i></button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
            <div class="collapse border bgwhite" id="flight_details<?= $key ?>">
                <div class="detail-header">
                    <button class="btn btn-primary btn-fi">Flight itinerary</button>
                    <a href="#">Fare Summary and Rules</a>
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
                            <strong>Flight on <?php echo date("l d M Y", $routes['departure_time']); ?>
                                from <?php echo $routes['city_from'] ?> to <?php echo $routes['city_to'] ?></strong>
                        </div>
                        <div class="duration-stop">
                            <div class="duration-time">
                                <i class="fa fa-clock-o"></i>
                                <span>Total durantion: <?php echo $duration; ?></span>
                            </div>
                            <span class="none-stop">none stop</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="flight">
                                <div>
                                    <span class="d-margin">Flight</span><br>
                                    <img src="<?= site_url('uploads/images/flights/airlines/' . $routes['airline']) ?>.png"
                                         alt="<?= $routes['airline'] ?>">
                                </div>
                                <div class="aircraft">
                                    <div><?= ucwords(get_airline_name($routes['airline'])); ?></div>
                                    <div><?= $routes['airline'][0] ?><?php echo $routes['flight_no']; ?></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="Depart">
                                <span class="d-margin">Depart</span>
                                <div><?php echo date("l d M Y", $routes['departure_time']); ?></div>
                                <div><strong><?php echo date("H:i", $routes['departure_time']); ?></strong></div>
                                <div><?php echo $routes['cityFrom'] ?> - <?php echo $routes['from_code'] ?></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="Arrives">
                                <span class="d-margin">Arrives</span>
                                <div><?php echo date("l d M Y", $routes['arrival_time']); ?></div>
                                <div><strong><?php echo date("H:i", $routes['arrival_time']); ?></strong></div>
                                <div><?php echo $routes['city_to'] ?> - <?php echo $routes['to_code'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="Class">
                                <span class="d-margin">Class / Baggage</span>
                                <div>Economy(U)</div>
                                <div>Cabin:
                                    <?=   $value['baglimit']['hand_width'] ?>
                                    x <?= $value['baglimit']['hand_length'] ?>
                                    x <?= $value['baglimit']['hand_height'] ?>
                                    , <?= $value['baglimit']['hand_weight']; ?> KG, FREE
                                </div>
                                <div>
                                    Checked: <?php if (!empty($value['bags_price'][1]) && $value['bags_price'][1] == 0) {
                                        echo $value['baglimit']['hold_weight'] ?> KG, FREE <?php } ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="tab-footer">
                    <div class="row">
                        <div class="d-flex">
                            <div class="col-md-4 btn-chose">
                                <a href="#flight_details<?= $key ?>"></a>
                                <a class="btn btn-block btn-default" role="button" data-toggle="collapse"
                                   href="#flight_details<?= $key ?>" aria-expanded="false"
                                   aria-controls="flight_details<?= $key ?>">Chose another flight</a>
                            </div>
                            <div class="col-md-3 btn-select">
                                <button onclick="$('#form_<?= $key ?>').submit();"
                                        class="btn btn-danger btn-block btn-0"><strong>Select
                                        flight <?php echo $value['currency']; ?> <?= $value['flight_price']; ?><i
                                                class="fa fa-chevron-right"></i></strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        </div>
    <?php
} else { ?>
<style>body {
        background: white !important
    }</style>
<div style="margin-top:-25px;min-height: 350px; padding: 25px;">
    <img src="<?php echo $theme_url; ?>assets/img/not_found.gif" style="max-width:200px"
         class="img-responsive center-block" alt="not found"/>
    <h4 style="margin: 25px 0 10px !important;" class="form-group text-center"><strong>No Results found.</strong></h4>
    <p class="text-center">
        Sorry, We couldn't find any results for the dates you are searching for.
        <br>
        We suggest you modify your search and try again.
    </p>
    <input value="0" type="hidden" id="available_flights">
</div>
<div>
    <?php } ?>
</div>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</div>