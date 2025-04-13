<form autocomplete="off" name="search" id="amadeus_search" action="<?php echo base_url('amadeus/'); ?>">
    <div class="container">
        <div class="row">
            <div class="bgfade col-md-3 form-group go-right col-xs-6">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-41"></i>
                    <input type="text" name="origin" class="widget-select2" id="origin" required='required' value="<?php echo $amadeus_data['origin']; ?>">
                </div>
            </div>
            <div class="bgfade col-md-3 form-group go-right col-xs-6">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-41"></i>
                    <input type="text" name="destination" id="destination" class="widget-select2" required='required' value="<?php echo $amadeus_data['destination']; ?>">
                </div>
            </div>
            <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-53"></i>
                    <input type="text" placeholder="Departure Date" value="<?php echo $amadeus_data['departureDate']; ?>" id="departure_date" name="departure_date" class="form form-control input-lg departureTime" required>
                </div>
            </div>
            <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-53"></i>
                    <input type="text" placeholder="Return Date" name="return_date" <?php if ($amadeus_data['triptypename'] == 'oneway') { echo "disabled='disabled'"; } ?> value="<?php echo $amadeus_data['return_date']; ?>" id="return_date" value=""  class="form form-control input-lg departureTime">
                </div>
            </div>
            <div class="col-md-1 form-group go-right col-xs-12">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-70"></i>
                    <input type="text" name="totalManualPassenger" id="totalManualPassenger" value="<?php echo $amadeus_data['totalpassengers']; ?>" class="form form-control input-lg" data-toggle="modal" data-target="#manual_flightTravelers" required>
                </div>
            </div>
            <div class="bgfade col-md-1 col-xs-12 search-button">
                <div class="clearfix"></div>
                <button type="submit" class="btn-primary btn btn-lg btn-block pfb0">
                    <?php echo trans('012'); ?>
                </button>
            </div>
        </div>
        <div class="modal fade" id="manual_flightTravelers" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm wow flipInY" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="submit" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo trans('0446'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <section>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="form-input" class="col-sm-3 col-xs-3 control-label"
                                    style="color:#000"><?php echo trans('010'); ?></label>
                                    <div class="col-sm-5 col-xs-5">
                                        <select class="travellercount form-control" name="madult" id="madult">
                                            <option value="1" <?php echo ($amadeus_data['madult'] == 1) ? "selected" : ""; ?>>1</option>
                                            <option value="2" <?php echo ($amadeus_data['madult'] == 2) ? "selected" : ""; ?>>2</option>
                                            <option value="3" <?php echo ($amadeus_data['madult'] == 3) ? "selected" : ""; ?>>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <label class="help-block">(12+yrs)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="form-input" class="col-sm-3 col-xs-3 control-label"
                                    style="color:#000"><?php echo trans('011'); ?></label>
                                    <div class="col-sm-5 col-xs-5">
                                        <select class="travellercount form-control" name="mchildren" id="mchildren">
                                            <option value="0" <?php echo ($amadeus_data['mchildren'] == 0) ? "selected" : ""; ?>>0</option>
                                            <option value="1" <?php echo ($amadeus_data['mchildren'] == 1) ? "selected" : ""; ?>>1</option>
                                            <option value="2" <?php echo ($amadeus_data['mchildren'] == 2) ? "selected" : ""; ?>>2</option>
                                            <option value="3" <?php echo ($amadeus_data['mchildren'] == 3) ? "selected" : ""; ?>>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <label class="help-block" style="color:#000">(2+yrs)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="form-input" class="col-sm-3 col-xs-3 control-label"
                                    style="color:#000"><?php echo trans('0282'); ?></label>
                                    <div class="col-sm-5 col-xs-5">
                                        <select class="travellercount form-control" name="minfant" id="minfant" value="<?php echo $query->passenger['infant']; ?>">
                                            <option value="0" <?php echo ($amadeus_data['minfant'] == 0) ? "selected" : ""; ?>>0</option>
                                            <option value="1" <?php echo ($amadeus_data['minfant'] == 1) ? "selected" : ""; ?>>1</option>
                                            <option vaaddSelectlue="2" <?php echo ($amadeus_data['minfant'] == 2) ? "selected" : ""; ?>>2</option>
                                            <option value="3" <?php echo ($amadeus_data['infant'] == 3) ? "selected" : ""; ?>>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <label class="help-block">(About 2 Years)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="form-input" class="col-sm-3 col-xs-3 control-label"
                                    style="color:#000"><?php echo trans('0282'); ?></label>
                                    <div class="col-sm-5 col-xs-5">
                                        <select class="travellercount form-control" name="seniors" id="seniors">
                                            <option value="0" <?php echo ($amadeus_data['seniors'] == 0) ? "selected" : ""; ?>>0</option>
                                            <option value="1" <?php echo ($amadeus_data['seniors'] == 1) ? "selected" : ""; ?>>1</option>
                                            <option vaaddSelectlue="2" <?php echo ($amadeus_data['seniors'] == 2) ? "selected" : ""; ?>>2</option>
                                            <option value="3" <?php echo ($amadeus_data['seniors'] == 3) ? "selected" : ""; ?>>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <label class="help-block">(65+ yrs)</label>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-block btn-lg bb"
                        onclick="total_passengers()" data-dismiss="modal"
                        id="sumManualPassenger"><?php echo trans('0233'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 form-group go-right col-xs-12">
                <div class="row">
                    <div class="clearfix"></div>
                    <select class="form-control fs12 class " name="triptype" id="triptype" onchange="trip_type(this.value);">
                        <option value="oneway" <?php if ($amadeus_data['triptypename'] == 'oneway') { echo "selected='selected'"; } ?>> One Way</option>
                        <option value="round" <?php if ($amadeus_data['triptypename'] == 'round') { echo "selected='selected'"; } ?>> Round Trip</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 form-group go-right col-xs-12">
                <div class="row">
                    <div class="clearfix"></div>
                    <select class="form-control fs12 class" name="cabinclass" id="class_type">
                        <option value="economy" <?php if ($amadeus_data['class_type'] == 'ECONOMY') { echo "selected"; } ?>><?php echo trans('0552'); ?></option>
                        <option value="business" <?php if ($amadeus_data['class_type'] == 'BUSINESS') { echo "selected"; } ?>><?php echo trans('0553'); ?></option>
                        <option value="first" <?php if ($amadeus_data['class_type'] == 'FIRST') { echo "selected"; } ?>><?php echo trans('0554'); ?></option>
                        <option value="premium_economy" <?php if ($amadeus_data['class_type'] == 'PREMIUM_ECONOMY') { echo "selected"; } ?>>Premium Economy</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 form-group go-right col-xs-12">
                <div class="row">
                    <div class="clearfix"></div>
                    <select class="form-control fs12 class" name="nonStop" id="nonStop">
                        <option value="true" <?php if($amadeus_data['nonStop'] == 'true'){ echo "selected"; } ?>>Non Stop</option>
                        <option value="false" <?php if($amadeus_data['nonStop'] == 'false'){ echo "selected"; } ?>>Transit</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="currency" value="<?php echo $amadeus_data['currency']; ?>" id="currency">
        </div>
    </div>
</form>
<script type="text/javascript">
    $("#amadeus_search").submit(function(e){
        var origin_airlines = $("#origin").val();
        var destination_airlines = $("#destination").val();
        var departure_date_airlines = $("#departure_date").val();
        var return_date_airlines = $("#return_date").val();
        var totalManualPassenger_airlines = $("#totalManualPassenger").val();
        var madult_airlines = $("#madult").val();
        var mchildren_airlines = $("#mchildren").val();
        var minfant_airlines = $("#minfant").val();
        var seniors_airlines = $("#seniors").val();
        var triptype_airlines = $("#triptype").val();
        var class_type_airlines = $("#class_type").val();
        var nonStop_airlines = $("#nonStop").val();

        if (triptype_airlines == "round") {
            var return_date_airlines = $("#return_date").val();
            var new_url = "<?php echo site_url("airlines/index");  ?>/"+origin_airlines+"/"+destination_airlines+"/"+departure_date_airlines+"/"+totalManualPassenger_airlines+"/"+madult_airlines+"/"+mchildren_airlines+"/"+minfant_airlines+"/"+seniors_airlines+"/"+class_type_airlines+"/"+triptype_airlines+'/'+nonStop_airlines+"/"+return_date_airlines;
        } else {
            var new_url = "<?php echo site_url("airlines/index");  ?>/"+origin_airlines+"/"+destination_airlines+"/"+departure_date_airlines+"/"+totalManualPassenger_airlines+"/"+madult_airlines+"/"+mchildren_airlines+"/"+minfant_airlines+"/"+seniors_airlines+"/"+class_type_airlines+"/"+triptype_airlines+'/'+nonStop_airlines;
        }

        document.getElementById("overlay").style.display = "block";
        window.location.replace(new_url);
        e.preventDefault();
    });
</script>
<script type="text/javascript">
    function total_passengers() {
        var madult = parseInt(document.getElementById('madult').value);
        var mchildren = parseInt(document.getElementById('mchildren').value);
        var minfant = parseInt(document.getElementById('minfant').value);
        var seniors = parseInt(document.getElementById('seniors').value);
        var total_passenger = madult + mchildren + minfant+seniors;
        document.getElementById('totalManualPassenger').value = total_passenger;
    }
    function change_date_departure(departure){
        document.getElementById('departure_date').value = departure;
        $("#amadeus_search").submit();
    }

    function trip_type(trip_type_name) {
        if (trip_type_name == 'oneway') {
            document.getElementById('return_date').value= "";
            document.getElementById('return_date').removeAttribute("required");
            document.getElementById('return_date').setAttribute("disabled", "disabled");
        } else {
            document.getElementById('return_date').setAttribute("required", "required");
            document.getElementById('return_date').removeAttribute("disabled");
            document.getElementById('return_date').focus();
        }
    }
    $('.select2').select2({ width: '100%' });
</script>
<div id="overlay">
    <div id="text"><img src="<?php echo base_url(''); ?>uploads/images/flights/airlines/flight.gif" alt="Searching flight"><br>Please Wait ... </div>
</div>
<style type="text/css">
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #fff;
    z-index: 99999;
    cursor: pointer;
}

#text{
    position: absolute;
    top: 50%;
    left: 50%;
    font-size: 50px;
    color: black;
    text-align: center;
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
}
</style>