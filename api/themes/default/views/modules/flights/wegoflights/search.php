<form action="<?php echo $url; ?>" id="wego-flights-searchform" target="_blank">
<div class="tab-inner menu-horizontal-content">
<div class="form-search-main-01">
<div class="form-inner">
    <div class="row mb-10">
        <div class="col-xs-2 col-md-3">
            <div class="custom-control custom-radio  custom-control-inline">
                <input type="radio" id="flightSearchRadio-2" name="triptype" class="custom-control-input" value="oneway" <?php if($query->triptype == "oneway") { ?> checked <?php } ?>>
                <label class="custom-control-label" for="flightSearchRadio-2"><?php echo trans('0384');?></label>
            </div>
            <div class="custom-control custom-radio  custom-control-inline" style="margin-top:-10px">
                <input type="radio" id="flightSearchRadio-1" name="triptype" class="custom-control-input" value="round" <?php if($query->triptype == "round") { ?> checked <?php } ?>>
                <label class="custom-control-label" for="flightSearchRadio-1"><?php echo trans('0385');?></label>
            </div>
        </div>
        <div class="col-xs-4 col-md-2">
            <div class="form-icon-left flightclass">
                <span class="icon-font text-muted"><i class="bx bx-time"></i></span>
                <select class="chosen-the-basic form-control form-control-sm" name="wg_cabin_class" required>
                    <option value="first" <?php echo ($query->cabinclass == "first") ? "" : "selected"; ?>><?php echo trans('0554');?></option>
                    <option value="business" <?php echo ($query->cabinclass == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                    <option value="economy" <?php echo ($query->cabinclass == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row gap-10 mb-15 align-items-end row-reverse">
        <div class="col-md-5 col-xs-12">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label><?=lang('0273')?></label>
                        <div class="clear"></div>
                        <div class="form-icon-left typeahead__container">
                            <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                            <input style="max-height: 2.2rem; font-size: 14px !important;" type="text" class="form-control wego-from ui-autocomplete-input form-readonly-control" name="wg_origin" value="" data-value="" placeholder="<?php echo trans('0119'); ?>" required="" autocorrect="off" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label><?=lang('0274')?></label>
                        <div class="clear"></div>
                        <div class="form-icon-left typeahead__container">
                            <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                            <input style="max-height: 2.2rem; font-size: 14px !important;" type="text" class="form-control input-lg RTL sterm searchInput wego-text wego-to ui-autocomplete-input" name="wg_destination" required="" autocorrect="off" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" placeholder="<?php echo trans('0120'); ?>">
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
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                <input id="FlightsDateStart" class="form-control form-readonly-control" placeholder="<?php echo trans('0472'); ?>" name="wg_outbound_date" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label><?php echo trans('0473'); ?></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                               <input id="FlightsDateEnd" autocomplete="false" class="form-control form-readonly-control" placeholder="<?php echo trans('0472'); ?>" name="wg_inbound_date" value="<?php echo $query->arrival; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-xs-12">
            <div class="col-inner">
                <div class="row gap-5">
                    <div class="col-6">
                        <div class="form-group form-spin-group">
                            <label for="room-amount"><?php echo trans('010');?> <small class="text-muted font10 line-1">(12-75)</small></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="wg_adult" value="<?php echo $query->passenger['adult']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group form-spin-group">
                            <label for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1">(2-12)</small></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="wg_children" value="<?php echo $query->passenger['children']; ?>"/>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-4">
                        <div class="form-group form-spin-group">
                            <label for="room-amount"><?php echo trans('0282');?> <small class="text-muted font10 line-1">(0-2)</small></label>
                            <div class="form-icon-left">
                                <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?php echo $query->passenger['infant']; ?>"/>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <button type="submit" class="btn-primary btn btn-block">
            <?php echo trans('012'); ?>
            </button>
        </div>
    </div>
</div>
</div>
</div>
<input type="hidden" class="wego-from-code" name="wg_from" value="" data-value="">
<input type="hidden" class="wego-def-from-code" name="wg-def-from-code" value="" data-value="">
<input type="hidden" class="wego-to-code" name="wg_to" value="">
<input type="hidden" class="wego-def-to-code" name="wg-def-to-code" value="">
<input type="hidden" class="wego-ts-code" name="ts_code" value="4c362">
<input type="hidden" class="wego-locale" name="wg-locale" value="en">
<input type="hidden" class="wego-def-from ui-autocomplete-input" name="wg-def-from" value="" autocorrect="off" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
<input type="hidden" class="wego-def-to ui-autocomplete-input" name="wego-def-to" value="" autocorrect="off" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
<input type="hidden" class="wego-sub-id" name="sub_id" value="">
<input type="hidden" class="wg_trip_type" name="wg_trip_type" value="true">
<input type="hidden" id="white-label" value="1">
</form>
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="//www.wan.travel/assets/app/datepicker.css">
<link rel="stylesheet" type="text/css" href="//www.wan.travel/assets/app/v2/searchbox.css">
<script charset="UTF-8" src="//www.wan.travel/assets/wan/v2/searchbox.js?body=1"></script>
