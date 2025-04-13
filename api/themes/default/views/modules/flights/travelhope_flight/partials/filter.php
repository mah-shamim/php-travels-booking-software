<?php if( is_array($flights['data']) && count($flights['data']) > 0){ ?>
<form id="filter_form_kiwi" method="POST" onsubmit="return filter();">
    <div class="col-sm-12">
        <div class="row">
            <aside class="hidden-on-mobile filter-panel hotel" id="search-tablet">
                <!--<div class="viewmap">
                    <div>
                        <button class="btn btn-default btn-sm center-block">View on Map</button>
                    </div>
                </div>-->
                <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse1">
                   <?=lang('0587')?> <span class="collapsearrow"></span>
                </button>
                <div id="collapse1" class="collapse in panel-body">
                    <div class="filter_margin">
                        <?php if (!empty($flights['data'])) {
                            $stop_array = array();
                            foreach ($flights['data'] as $key => $value) {
                                $stops_return = 0;
                                $stops = 0;
                                foreach ($value['route'] as $route) {
                                    if ($route['return'] == 1) {
                                        $stops_return++;
                                    } else {
                                        $stops++;
                                    }
                                }
                                if (!in_array($stops_return, $stop_array)) {
                                    array_push($stop_array, $stops_return);
                                }
                                if (!in_array($stops, $stop_array)) {
                                    array_push($stop_array, $stops);
                                }
                            }
                            sort($stop_array);
                            foreach ($stop_array as $stops) {
                                if ($stops != 0) {
                                    if ($stops == 1) {
                                        $flight_type = 'Direct';
                                    } elseif ($stops == 2) {
                                        $flight_type = ($stops - 1) . ' Stop';
                                    } else {
                                        $flight_type = ($stops - 1) . ' Stops';
                                    }
                                    ?>
                                    <label class="control control--checkbox ellipsis fs14"> <?= $flight_type ?>
                                        <input type="checkbox" id="amenity" value="<?= ($stops) ?>" name="stop[]"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                <?php }
                            }
                        } ?>
                    </div>
                </div>
                <button type="button" class="collapsebtn go-text-right" data-toggle="collapse" data-target="#collapse2">
                    <?=lang('0138')?> <span class="collapsearrow"></span>
                </button>
                <?php
                $i = 1;
                $min_price = 0;
                $max_price = 0;
                if (!empty($flights['data'])) {
                    $i = 1;
                    $min_price = 0;
                    $max_price = 0;
                    foreach ($flights['data'] as $key => $value) {
                        if ($i == 1) {
                            $min_price = $value['flight_price'];
                            $max_price = $value['flight_price'];
                        } else {
                            if ($min_price > $value['flight_price']) {
                                $min_price = $value['flight_price'];
                            }
                            if ($max_price < $value['flight_price']) {
                                $max_price = $value['flight_price'];
                            }
                        }
                        $i++;
                    }
                }
                ?>
                <div id="collapse2" class="collapse in panel-body">
                    <input type="text" id="sl2" class="col-md-12 price_ranger tool_tip" value="" name="price"
                           data-slider-min="<?= "".$min_price ?>" data-slider-max="<?= "".$max_price ?>" data-slider-step="5"
                           data-slider-value="[<?= "".$min_price ?>,<?= "".$max_price ?>]"/>
                </div>

                <button type="button" class="collapsebtn last go-text-right" data-toggle="collapse"
                        data-target="#collapse4">
                    Airlines <span class="collapsearrow"></span>
                </button>
                <div id="collapse4" class="collapse in">
                    <div class="filter_margin"
                         style="max-height: 272px; overflow: hidden; overflow-y: scroll; margin-top: 10px; margin-bottom: 10px;">
                        <?php if (!empty($flights['data'])) {
                            $countries_array = array();
                            foreach ($flights['data'] as $key => $value) {
                                if (!in_array($value['airline'], $countries_array)) {
                                    array_push($countries_array, $value['airline']);
                                    ?>
                                    <label class="control control--checkbox ellipsis fs14"> <img
                                                src="<?= site_url('uploads/images/flights/airlines/' . $value['airline']) ?>.png"
                                                style="width:20px;height:20px;" alt=""/>
                                        <span style="letter-spacing: -1px !important;"><?= ucwords(get_airline_name($value['airline'])); ?></span>
                                        <input type="checkbox" id="amenity" name="flights[]"
                                               value="<?= $value['airline']; ?>"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                <?php }
                            }
                        } ?>
                    </div>
                </div>
                <input type="hidden" id="filter_price"/>
                <button style="border-radius:0px" type="submit" class="btn btn-primary btn-lg btn-block"
                        id="filter-btn"><?=lang('0191')?>
                </button>
            </aside>
        </div>
    </div>
</form>

<script>
    $(".price_ranger").slider({
        tooltip: 'always',
        formatter: function (value) {
            if (value[0] !== undefined && value[1] !== undefined) {
                $('#filter_price').val(value[0] + ',' + value[1]);
            }
            return value[0] + ' : ' + value[1];
        }
    })
</script>
<script type="text/javascript">
    function filter() {
        var passengers = parseInt($("#cvalue-flights").val()) + parseInt($("#ivalue-flights").val()) + parseInt($("#avalue-flights").val());
        var dep_date = $('.caleran-dep').val();
        var form = $('#filter_form_kiwi');
        var form_data = form.serialize();
        $.ajax({
            type: "POST",
            url: '<?php echo site_url('thflights/filter/'); ?>',
            data: form_data,
            beforeSend: function () {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#flight_records").html('<h3 class="mt0"><strong id="total-records"><i class="fa fa-circle-o-notch fa-spin"></i> Searching</strong> Flights</h3><p>' + (passengers) + ' Travellers , Date : ' + dep_date);
                $("#all_flights").html('<img src="<?php echo base_url(); ?>assets/img/loading.gif" style="max-height: 50px;display: block;margin-right: auto;margin-left: auto;margin-top: 40px;"><br><h4 style="text-align: center;">Loading Flights</h4><br><br>');
            },
            success: function (data) {
                $("#all_flights").html(data).show('slow');
                var available_flights = $('#available_flights').val();
                if (available_flights == 0) {
                    $("#flight_records").html('<h3 class="mt0"><strong id="total-records">No </strong> Flights Found</h3><p>' + (passengers) + ' Travellers , Date : ' + dep_date);
                } else {
                    $("#flight_records").html('<h3 class="mt0"><strong id="total-records">' + available_flights + ' </strong> Flights Found</h3><p>' + (passengers) + ' Travellers , Date : ' + dep_date);
                }
            }
        });
        return false;
    }
</script>
<?php } ?>