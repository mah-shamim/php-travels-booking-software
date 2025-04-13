<div class="tab-inner menu-horizontal-content">
    <div class="form-search-main-01">
         <form autocomplete="off" id="trflight" action="<?php echo base_url('trflight/search'); ?>" method="GET" role="search">
            <div class="form-inner">
                <div class="mb-10">
                <div class="clearfix"></div>
                    <div class="custom-control custom-radio  custom-control-inline">
                        <input type="radio" id="oneway" name="triptype" class="custom-control-input" value="oneway" checked <?php if($search->tripType == "oneway") { ?> checked <?php } ?>>
                        <label class="custom-control-label" for="oneway"><?php echo trans('0384');?></label>
                    </div>
                    <div class="custom-control custom-radio  custom-control-inline">
                        <input type="radio" id="return" name="triptype" class="custom-control-input" value="round" <?php if($search->tripType == "return") { ?> checked <?php } ?>>
                        <label class="custom-control-label" for="return"><?php echo trans('0385');?></label>
                    </div>
                </div>
                <div class="row gap-10 mb-15">
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0273')?></label>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <select class="form-control select2" name="origin">
                                 <option value=""><?=lang('0158')?> <?=lang('0273')?></option>
                                 <option value="RUH" >King Khalid Int Airport Saudia</option>
                                 <option value="JED">Jeddah Int Airport Saudia</option>
                                 <option value="DMM">King Fahad Int Airport  Saudia</option>
                                 <option value="CAI" selected>Cairo Int Airport Egypt</option>
                                 <option value="ASM">ASmara Int Airport</option>
                                 <option value="NDJ">Djemena Int Airport</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label><?=lang('0274')?></label>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <select class="form-control select2" name="destination">
                                 <option value="" selected><?=lang('0158')?> <?=lang('0274')?></option>
                                 <option value="RUH">King Khalid Int Airport Saudia</option>
                                 <option value="JED">Jeddah Int Airport Saudia</option>
                                 <option value="DMM">King Fahad Int Airport  Saudia</option>
                                 <option value="CAI">Cairo Int Airport Egypt</option>
                                 <option value="ASM">ASmara Int Airport</option>
                                 <option value="NDJ">Djemena Int Airport</option>
                                 <option value="KRT" selected>Civil Airport khartoum Sudan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="col-inner">
                            <div id="airDatepickerRange-flight" class="row gap-10 mb-15">
                                <div class="class12 col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0472'); ?></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input type="text" id="tarcostart" placeholder="<?php echo trans('0472'); ?>" name="departure" value="<?php  echo $search->departure; ?>" class="form form-control input-lg" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidediv col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0473'); ?></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input type="text" id="tarcoend" disabled placeholder="<?php echo trans('0473'); ?>" name="arrival" value="<?php echo $search->arrival; ?>" class="form form-control input-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="col-inner">
                            <div class="row gap-5">
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('010');?> <small class="text-muted font10 line-1">(12-75)</small></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="hidden" name="totalManualPassenger" value="0" placeholder="0" class="form form-control input-lg">
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="madult" value="1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="mchildren" value="<?php echo $query->passenger['children']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('0282');?> <small class="text-muted font10 line-1">(0-2)</small></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="minfant" readonly value="<?php echo $query->passenger['infant']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                    <label class="d-none d-sm-block">&nbsp;</label>
                    <button type="submit"  class="btn-primary btn btn-block">
                    <?php echo trans('012'); ?>
                    </button>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function objectifyForm(formArray) {
        var returnArray = {};
        for (var i = 0; i < formArray.length; i++){
            returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
        return returnArray;
    }
    $("form[id=trflight]").submit(function(e){
        e.preventDefault();
        var form = $("form[id=trflight]");
        var formData = objectifyForm(form.serializeArray());
        var triptype_airlines = formData.triptype;
        var endpoint = form.attr('action')+'/';
        formData.departure = formData.departure.replace (/\//g, "-");
        if (triptype_airlines == "return") {
            var new_url = endpoint+formData.origin+"/"+formData.destination+"/"+formData.triptype+"/"+formData.departure+'/'+formData.arrival+"/"+formData.madult+"/"+formData.mchildren+"/"+formData.minfant;
        } else {
            var new_url = endpoint+formData.origin+"/"+formData.destination+"/"+formData.triptype+"/"+formData.departure+'/'+formData.madult+"/"+formData.mchildren+"/"+formData.minfant;
        }
        window.location.href = new_url;
    });
</script>
<script type="text/javascript">
    $( document ).ready(function() {
    $(".hidediv").hide();
    $(".class12").addClass('col-12');
    });
    //Radio Button disable end date
    $("#oneway").click(function() {
    $("#tarcoend").prop('disabled', true);
    $(".hidediv").hide();
    $(".class12").addClass('col-12');
    });
    //Radio Button enable end date
    $("#return").click(function() {
    $("#tarcoend").removeAttr('disabled');
    $(".hidediv").show();
    $(".class12").removeClass('col-12');
    });
</script>
<div id="overlay">
    <div id="text">
        <br>
        <img class="img-responsive" src="<?php echo base_url(''); ?>uploads/images/flights/airlines/flight.gif" alt="Searching flight"><br>
        <h4 class="cw"><?=lang('0427')?></h4>
        <br>
    </div>
</div>