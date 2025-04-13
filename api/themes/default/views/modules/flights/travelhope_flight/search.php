<form autocomplete="off" id="thflights" action="<?php echo base_url('thflights/search'); ?>" method="GET" role="search">
    <div class="col-md-3 form-group go-right col-xs-12">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-41"></i>
            <input  style="width:100%;min-height:60px;border:0px" type="text" name="origin" value="<?=$thfSearchForm->from_code?>" class="widget-select2" id="origin" required='required'>
        </div>
    </div>
    <div class="col-md-3 form-group go-right col-xs-12">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-41"></i>
            <input  style="width:100%;min-height:60px;border:0px" type="text" name="destination" value="<?=$thfSearchForm->to_code?>" id="destination" class="widget-select2" required='required'>
        </div>
    </div>
    <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-53"></i>
            <input type="text" id="departure" placeholder="<?php echo trans('0472'); ?>" name="departure" value="<?php echo $thfSearchForm->date_from; ?>" class="form form-control input-lg thopeflight_checkin_date" required>
        </div>
    </div>
    <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-53"></i>
            <input type="text"  id="arrival" placeholder="<?php echo trans('0473'); ?>" name="arrival" value="<?php echo $thfSearchForm->return_from; ?>" class="form form-control input-lg thopeflight_checkout_date">
        </div>
    </div>
    <div class="col-md-1 form-group go-right col-xs-12">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-70"></i>
            <input type="text" min="1" max="5" name="totalManualPassenger" value="<?php echo $thfSearchForm->getTotalPassengers(); ?>" placeholder="0" class="form form-control input-lg" data-toggle="modal" data-target="#manual_flightTravelers" required>
        </div>
    </div>
    <div class="bgfade col-md-1 col-xs-12 search-button">
        <div class="clearfix"></div>
        <button type="submit"  class="btn-primary btn btn-lg btn-block pfb0">
        <?php echo trans('012'); ?>
        </button>
    </div>
    <div class="clearfix"></div>

    <!--/ .row -->
    <div class="modal fade" id="manual_flightTravelers" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm wow flipInY" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo trans('0446');?></h4>
                </div>
                <div class="modal-body">
                    <section>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="form-input" class="col-sm-3 col-xs-3 control-label"><?php echo trans('010');?></label>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="travellercount form-control" id="madult" name="madult" value="<?php echo $thfSearchForm->adults; ?>">
                                        <option value="1" <?php echo ($thfSearchForm->adults == 1) ? "selected" : ""; ?>>1</option>
                                        <option value="2" <?php echo ($thfSearchForm->adults == 2) ? "selected" : ""; ?>>2</option>
                                        <option value="3" <?php echo ($thfSearchForm->adults == 3) ? "selected" : ""; ?>>3</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <label class="help-block">(12+yrs)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="form-input" class="col-sm-3 col-xs-3 control-label"><?php echo trans('011');?></label>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="travellercount form-control" id="mchildren" name="mchildren" value="<?php echo $thfSearchForm->children; ?>">
                                        <option value="0" <?php echo ($thfSearchForm->children == 0) ? "selected" : ""; ?>>0</option>
                                        <option value="1" <?php echo ($thfSearchForm->children == 1) ? "selected" : ""; ?>>1</option>
                                        <option value="2" <?php echo ($thfSearchForm->children == 2) ? "selected" : ""; ?>>2</option>
                                        <option value="3" <?php echo ($thfSearchForm->children == 3) ? "selected" : ""; ?>>3</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <label class="help-block">(4+yrs)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="form-input" class="col-sm-3 col-xs-3 control-label"><?php echo trans('0282');?></label>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="travellercount form-control" id="minfant" name="minfant" value="<?php echo $thfSearchForm->infants; ?>">
                                        <option value="0" <?php echo ($thfSearchForm->infants == 0) ? "selected" : ""; ?>>0</option>
                                        <option value="1" <?php echo ($thfSearchForm->infants == 1) ? "selected" : ""; ?>>1</option>
                                        <option value="2" <?php echo ($thfSearchForm->infants == 2) ? "selected" : ""; ?>>2</option>
                                        <option value="3" <?php echo ($thfSearchForm->infants == 3) ? "selected" : ""; ?>>3</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <label class="help-block">(2+yrs)</label>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block btn-lg bb" data-dismiss="modal" id="sumManualPassenger"><?php echo trans('0233');?></button>
                </div>
            </div>
        </div>
    </div>
    <!--/ .modal -->
    <div class="clearfix"></div>
    <div class="trip-check">
        <div class="col-md-2 col-xs-6 w120">
            <div class="pure-checkbox">
                <input checked id="oneway" name="triptype" type="radio" class="checkbox triptype" value="oneway" data-type="oneway" <?php if($thfSearchForm->flight_type == "oneway") { ?> checked <?php } ?>>
                <label for="oneway" data-type="oneway">&nbsp;<?php echo trans('0384');?></label>
            </div>
        </div>
        <div class="col-md-2 col-xs-6 w120">
            <div class="pure-checkbox">
                <input id="round" name="triptype" type="radio" class="checkbox triptype" value="return" data-type="round" <?php if($thfSearchForm->flight_type == "return") { ?> checked <?php } ?>>
                <label for="round" data-type="round">&nbsp;<?php echo trans('0385');?> </label>
            </div>
        </div>
        <div class="go-text-right form-horizontal">
            <div class="col-md-2 form-group go-right col-xs-12">
                <div class="clearfix"></div>
                <div class="col-md-12" style="width:100%;height:40px"></div>
                <!--<select class="form-control fs12 class" name="cabinclass">
                    <option value="economy" <?php echo ($query->cabinclass == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                    <option value="business" <?php echo ($query->cabinclass == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                    <option value="first" <?php echo ($query->cabinclass == "first") ? "selected" : ""; ?>><?php echo trans('0554');?></option>
                </select>-->
            </div>
        </div>
      <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</form>
<script type="text/javascript">
    function objectifyForm(formArray) {
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++){
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    }
    $("#thflights").submit(function(e){
        e.preventDefault();
        var formData = objectifyForm($(this).serializeArray());
        var origin_airlines = $("#origin").val();
        var destination_airlines = $("#destination").val();
        var departure_date_airlines = $("#departure").val();
        var return_date_airlines = $("#arrival").val();
        var madult_airlines = $("#madult").val();
        var mchildren_airlines = $("#mchildren").val();
        var minfant_airlines = $("#minfant").val();
        var triptype_airlines = formData.triptype;
        var endpoint = $(this).attr('action')+'/';
        if (triptype_airlines == "return") {
            var new_url = endpoint+origin_airlines+"/"+destination_airlines+"/"+triptype_airlines+"/"+departure_date_airlines+'/'+return_date_airlines+"/"+madult_airlines+"/"+mchildren_airlines+"/"+minfant_airlines;
        } else {
            var new_url = endpoint+origin_airlines+"/"+destination_airlines+"/"+triptype_airlines+"/"+departure_date_airlines+"/"+madult_airlines+"/"+mchildren_airlines+"/"+minfant_airlines;
        }
        document.getElementById("overlay").style.display = "block";
        window.location.replace(new_url);
    });
</script>
<script type="text/javascript">
    function total_passengers() {
        var madult = parseInt(document.getElementById('madult').value);
        var mchildren = parseInt(document.getElementById('mchildren').value);
        var minfant = parseInt(document.getElementById('minfant').value);
        var total_passenger = madult + mchildren + minfant;
        $("#totalManualPassenger").val(total_passenger);
    }
    function change_date_departure(departure){
        document.getElementById('departure_date').value = departure;
        $("#sabre_search").submit();
    }


    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var thopeflight_checkin_date = $('.thopeflight_checkin_date').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(e){
        $(this).datepicker('hide');
        var newDate = new Date(e.date);
        if ($("#arrival").prop("disabled") == false) {
            thopeflight_checkout_date.setValue(newDate.setDate(newDate.getDate() + 1));
        }
        $('.thopeflight_checkout_date').focus();
    }).data('datepicker');
    var thopeflight_checkout_date = $('.thopeflight_checkout_date').datepicker({
        format: 'yyyy-mm-dd',
        onRender: function(date) {
            return date.valueOf() <= thopeflight_checkin_date.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(){
        $(this).datepicker('hide');
    }).data('datepicker');
</script>
<div id="overlay">
    <div id="text">
        <br>
        <img class="img-responsive" src="<?php echo base_url(''); ?>uploads/images/flights/airlines/flight.gif" alt="Searching flight"><br>
        <h4 class="cw"><?=lang('0427')?></h4>
        <br>
    </div>
</div>
<div class="clearfix"></div>