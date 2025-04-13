<?php
    $query = new StdClass();
    $query->triptype = 'oneway';
    $query->cabinclass = 'economy';
    $query->origin = "";
    $query->destination = "";
    $query->departure = "";
    $query->arrival = "";
    $query->passenger = array('total' => 1, 'adult' => 1, 'children' => 0, 'infant' => 0);
    ?>
<div class="tab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form autocomplete="off" name="flightmanualSearch" action="<?php echo base_url('flights'); ?>" method="GET" role="search">
            <div class="form-inner">
                <div class="row mb-10">
                    <div class="col-xs-2 col-md-3">
                        <div class="custom-control custom-radio  custom-control-inline">
                            <input type="radio" id="flightSearchRadio-2" name="triptype" class="custom-control-input" value="oneway" <?php if($query->triptype == "oneway") { ?> checked <?php } ?>>
                            <label class="custom-control-label" for="flightSearchRadio-2"><?php echo trans('0384');?></label>
                        <div class="clear"></div>
                        </div>
                        <div class="custom-control custom-radio  custom-control-inline" style="margin-top:-10px">
                            <input type="radio" id="flightSearchRadio-1" name="triptype" class="custom-control-input" value="round" <?php if($query->triptype == "round") { ?> checked <?php } ?>>
                            <label class="custom-control-label" for="flightSearchRadio-1"><?php echo trans('0385');?></label>
                        <div class="clear"></div>
                        </div>
                        <!--<div class="custom-control custom-radio  custom-control-inline">
                            <input type="radio" id="flightSearchRadio-3" name="flightSearchRadio" class="custom-control-input">
                            <label class="custom-control-label" for="flightSearchRadio-3">Multicities</label>
                            </div>-->
                    </div>
                    <div class="col-xs-4 col-md-2">
                        <!-- <label><?=lang('0557')?></label>-->
                        <div class="form-icon-left flightclass">
                            <span class="icon-font text-muted"><i class="bx bx-time"></i></span>
                            <select class="chosen-the-basic form-control form-control-sm" name="cabinclass" required>
                                <option value="first" <?php echo ($query->cabinclass == "first") ? "" : "selected"; ?>><?php echo trans('0554');?></option>
                                <option value="business" <?php echo ($query->cabinclass == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                                <option value="economy" <?php echo ($query->cabinclass == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                            </select>
                        </div>
                    </div>
                </div>
                  <div class="row gap-10 mb-15 align-items-end">
                      <div class="col-md-5 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label><?=lang('0273')?></label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left typeahead__container">
                                        <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                        <input class="form-control" type="text" name="" value="" id="location_from" type="search" autocomplete="off">
                                        <input type="hidden" name="origin" value="" id="location_from_code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label><?=lang('0274')?></label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left typeahead__container">
                                        <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                        <input type="text" name="" value="" id="location_to" class="form-control" type="search" autocomplete="off">
                                        <input type="hidden" name="destination" value="" id="location_to_code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="col-inner">
                            <div id="airDatepickerRange-flight" class="row gap-10 mb-15">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0472'); ?></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input id="FlightsDateStart" class="form-control form-readonly-control" placeholder="<?php echo trans('0472'); ?>" name="departure" value="<?php echo $query->departure; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0473'); ?></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input id="FlightsDateEnd" autocomplete="false" class="form-control form-readonly-control" placeholder="<?php echo trans('0472'); ?>" name="arrival" value="<?php echo $query->arrival; ?>" readonly>
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
                                       <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="madult" value="<?php echo $query->passenger['adult']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="mchildren" value="<?php echo $query->passenger['children']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('0282');?> <small class="text-muted font10 line-1">(0-2)</small></label>
                                       <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?php echo $query->passenger['infant']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <button type="submit" class="btn-primary btn btn-block">
                        <?php echo trans('012'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>