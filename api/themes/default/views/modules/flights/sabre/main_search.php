
<form autocomplete="off" name="search" id="sabre_search" action="<?php echo base_url('airway/search'); ?>">
    <div class="container">
        <div class="row">
            <div class="bgfade col-md-3 form-group go-right col-xs-6">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-41"></i>
                    <input type="text" name="origin" value="<?=$searchForm->origin?>" class="widget-select2" id="origin" required='required'>
                </div>
            </div>
            <div class="bgfade col-md-2 form-group go-right col-xs-6">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-41"></i>
                    <input type="text" name="destination" value="<?=$searchForm->destination?>" id="destination" class="widget-select2" required='required'>
                </div>
            </div>
            <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-53"></i>
                    <input type="text" placeholder="Departure Date" value="<?=$searchForm->departure?>" name="departure_date" class="form form-control input-lg departureTime" required>
                </div>
            </div>
            <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-53"></i>
                    <input type="text" name="arrival" value="<?=$searchForm->arrival?>" placeholder="Return Date" class="form form-control input-lg arrivalTime">
                </div>
            </div>
            <div class="col-md-1 form-group go-right col-xs-12">
                <div class="row">
                    <div class="clearfix"></div>
                    <i class="iconspane-lg icon_set_1_icon-70"></i>
                    <input type="text" name="totalManualPassenger" value="<?=$searchForm->passenger->total()?>" id="totalManualPassenger" class="form form-control input-lg" data-toggle="modal" data-target="#manual_flightTravelers" required>
                </div>
            </div>
            <div class="bgfade col-md-2 col-xs-12 search-button">
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
                                            <option value="1" selected>1</option>
                                            <option value="2" <?=($searchForm->passenger->adult == 2) ? "selected" : ""?>>2</option>
                                            <option value="3" <?=($searchForm->passenger->adult == 3) ? "selected" : ""?>>3</option>
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
                                            <option value="0" selected>0</option>
                                            <option value="1" <?=($searchForm->passenger->children == 1) ? "selected" : ""?>; ?>>1</option>
                                            <option value="2" <?=($searchForm->passenger->children == 2) ? "selected" : ""?>; ?>>2</option>
                                            <option value="3" <?=($searchForm->passenger->children == 3) ? "selected" : ""?>; ?>>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <label class="help-block" style="color:#000">(2+yrs)</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="form-input" class="col-sm-3 col-xs-3 control-label"
                                    style="color:#000"><?php echo trans('011'); ?></label>
                                    <div class="col-sm-5 col-xs-5">
                                        <select class="travellercount form-control" name="minfant" id="minfant">
                                            <option value="0" selected>0</option>
                                            <option value="1" <?=($searchForm->passenger->infant == 1) ? "selected" : ""?>; ?>>1</option>
                                            <option value="2" <?=($searchForm->passenger->infant == 2) ? "selected" : ""?>; ?>>2</option>
                                            <option value="3" <?=($searchForm->passenger->infant == 3) ? "selected" : ""?>; ?>>3</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-xs-4">
                                        <label class="help-block" style="color:#000">(2+yrs)</label>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-block btn-lg bb"
                        onclick="total_passengers()" data-dismiss="modal"
                        id="sumManualPassenger"><?php echo trans('0233'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="trip-check">
                <div class="col-md-2 col-xs-6">
                    <div class="pure-checkbox">
                        <input name="triptype" type="radio" id="oneway" <?=($searchForm->tripType=='oneWay')?'checked':''?> class="checkbox triptype" value="oneWay">
                        <label for="oneway">&nbsp;<?php echo trans('0384');?></label>
                    </div>
                </div>
                <div class="col-md-2 col-xs-6">
                    <div class="pure-checkbox">
                        <input name="triptype" type="radio" id="return" <?=($searchForm->tripType=='return')?'checked':''?> class="checkbox triptype" value="return">
                        <label for="return">&nbsp;<?php echo trans('0385');?> </label>
                    </div>
                </div>
                <div class="go-text-right form-horizontal">
                    <div class="col-md-2 form-group go-right col-xs-12">
                        <div class="clearfix"></div>
                        <select class="form-control fs12 class" name="cabinclass" id="class_type">
                            <option value="economy" <?=($searchForm->classOfService=='ECONOMY')?'selected':''?>><?php echo trans('0552');?></option>
                            <option value="business" <?=($searchForm->classOfService=='BUSINESS')?'selected':''?>><?php echo trans('0553');?></option>
                            <option value="first" <?=($searchForm->classOfService=='FIRST')?'selected':''?>><?php echo trans('0554');?></option>
                        </select>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</form>
<script type="text/javascript">
    function objectifyForm(formArray) {
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++){
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    }
    $("#sabre_search").submit(function(e){
        e.preventDefault();
        var formData = objectifyForm($(this).serializeArray());
        var origin_airlines = $("#origin").val();
        var destination_airlines = $("#destination").val();
        var departure_date_airlines = $("[name=departure_date]").val();
        var return_date_airlines = $("[name=arrival]").val();
        var totalManualPassenger_airlines = $("#totalManualPassenger").val();
        var madult_airlines = $("#madult").val();
        var mchildren_airlines = $("#mchildren").val();
        var minfant_airlines = $("#minfant").val();
        var triptype_airlines = formData.triptype;
        var class_type_airlines = $("#class_type").val();
        var endpoint = $(this).attr('action')+'/';
        if (triptype_airlines == "return") {
            var new_url = endpoint+origin_airlines+"/"+destination_airlines+"/"+class_type_airlines+"/"+triptype_airlines+"/"+departure_date_airlines+'/'+return_date_airlines+"/"+madult_airlines+"/"+mchildren_airlines+"/"+minfant_airlines;
        } else {
            var new_url = endpoint+origin_airlines+"/"+destination_airlines+"/"+class_type_airlines+"/"+triptype_airlines+"/"+departure_date_airlines+"/"+madult_airlines+"/"+mchildren_airlines+"/"+minfant_airlines;
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
</script>
<div id="overlay">
    <div id="text">
        <img src="<?php echo base_url(''); ?>uploads/images/flights/airlines/flight.gif" alt="Searching flight"><br>
        Please Wait ...     
    </div>
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