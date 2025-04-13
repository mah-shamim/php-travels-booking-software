<?php
     $requestType = $travelportSearchFormData['requestType']; // Ajax or PHP
    $query = new StdClass();
    $query->triptype = 'oneway';
    $query->cabinclass = 'economy';
    $query->origin = $travelportSearchFormData['configuration']->default_origin;
    $query->destination = $travelportSearchFormData['configuration']->default_destination;
     $tomorrow = date("Y-m-d", time() + 86400);
    $query->departure = $tomorrow;
    $query->arrival = sprintf('%s-%s', date('Y-m') . ((date('d') + 1)) );
    $query->passenger = array(
        'total' => 1,
        'adult' => 1,
        'children' => 0,
        'infant' => 0
    );
    if (isset($_SESSION['searchQuery']) && ! empty($_SESSION['searchQuery'])) {
        $query = (Object) $_SESSION['searchQuery'];
    }
?>

<div class="tab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form autocomplete="off" name="flightmanualSearch" action="<?php echo base_url('flight/search'); ?>" method="GET" role="search">
            <div class="form-inner">
                <div class="mb-10">

                    <div class="custom-control custom-radio  custom-control-inline">
                        <input type="radio" id="flightSearchRadio-2" name="triptype" class="custom-control-input" value="oneway" <?php if($query->triptype == "oneway") { ?> checked <?php } ?>>
                        <label class="custom-control-label" for="flightSearchRadio-2"><?php echo trans('0384');?></label>
                    </div>
                    <div class="custom-control custom-radio  custom-control-inline">
                        <input type="radio" id="flightSearchRadio-1" name="triptype" class="custom-control-input" value="round" <?php if($query->triptype == "round") { ?> checked <?php } ?>>
                        <label class="custom-control-label" for="flightSearchRadio-1"><?php echo trans('0385');?></label>
                    </div>
                    <div class="custom-control custom-radio  custom-control-inline">
                     <select class="form-control input-sm" name="cabinclass">
                     <option value="economy" <?php echo ($query->cabinclass == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                     <option value="business" <?php echo ($query->cabinclass == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                     <option value="first" <?php echo ($query->cabinclass == "first") ? "selected" : ""; ?>><?php echo trans('0554');?></option>
                     </select>
                    </div>
                    <!--<div class="custom-control custom-radio  custom-control-inline">
                        <input type="radio" id="flightSearchRadio-3" name="flightSearchRadio" class="custom-control-input">
                        <label class="custom-control-label" for="flightSearchRadio-3">Multicities</label>
                    </div>-->
                </div>
                <div class="row gap-10 mb-15">
                    <div class="col-6">
                        <div class="form-group">
                            <label><?=lang('0273')?></label>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <input class="form-control" type="text" name="" value="" id="location_from" type="search" autocomplete="off">
                                <input type="hidden" name="origin" value="<?php echo $query->origin; ?>" id="location_from_code">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label><?=lang('0274')?></label>
                            <div class="form-icon-left typeahead__container">
                                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                <input type="text" name="" value="" id="location_to" class="form-control" type="search" autocomplete="off">
                                <input type="hidden" name="destination" value="<?php echo $query->destination; ?>" id="location_to_code">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-inner">
                            <div id="airDatepickerRange-flight" class="row gap-10 mb-15">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0472'); ?></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input placeholder="dd/mm/yyyy" id="dateStart-flight" autocomplete="false" class="form-control form-readonly-control" placeholder="<?php echo trans('0472'); ?>" name="departure" value="<?php echo $query->departure; ?>" class="form form-control input-lg" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0473'); ?></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input placeholder="dd/mm/yyyy" id="dateEnd-flight" autocomplete="false" placeholder="<?php echo trans('0473'); ?>" name="arrival" value="<?php echo $query->arrival; ?>" class="form form-control input-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-inner">
                            <div class="row gap-5">
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('010');?> <small class="text-muted font10 line-1">(12-75)</small></label>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="madult" value="<?php echo $query->passenger['adult']; ?>" />
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
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly value="<?php echo $query->passenger['infant']; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row align-items-center mt-20">
                    <button type="submit"  class="btn-primary btn btn-block" onclick='document.getElementById("overlay").style.display = "block"'>
                    <?php echo trans('012'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



































<!-- <style> .modal-backdrop { z-index: 0; } </style>

<form autocomplete="off" name="flightSearch" action="" method="GET" role="search">
        <div class="col-md-3 form-group go-right col-xs-12">
            <div class="row">
                <div class="clearfix"></div>
                <input type="text" name="origin" class="widget-select2" required >
            </div>
            </div>

            <div class="col-md-2 form-group go-right col-xs-12">
            <div class="row">
                <div class="clearfix"></div>
                <input type="text" name="destination" class="widget-select2" required value="">
            </div>
        </div>

        <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-53"></i>
            <input type="text" placeholder="<?php echo trans('0472'); ?>" name="departure" value="<?php echo $query->departure; ?>" class="form-control input-lg departureTime" required>
        </div>
        </div>


        <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-53"></i>
            <input type="text" placeholder="<?php echo trans('0473'); ?>" name="arrival" value="<?php echo $query->arrival; ?>" class="form-control input-lg arrivalTime">
        </div>
        </div>


        <div class="col-md-1 form-group go-right col-xs-12">
        <div class="row">
            <div class="clearfix"></div>
            <i class="iconspane-lg icon_set_1_icon-70"></i>
            <input type="text" name="ttotalPassenger" value="<?php echo $query->passenger['total']; ?>" placeholder="0" class="form-control input-lg" data-toggle="modal" data-target="#flightTravelers" required>
        </div>
        </div>

        <div class="bgfade col-md-2 col-xs-12 search-button">
            <div class="clearfix"></div>
            <button type="submit"  class="btn-danger btn btn-lg btn-block pfb0" >
            <i class="icon_set_1_icon-66"></i> <?php echo trans('012'); ?>
            </button>
        </div>



    <!--/ .row -->
    <!-- <div class="modal fade" id="flightTravelers" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm wow flipInY" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo trans('0533');?></h4>
                </div>
                <div class="modal-body">
                    <section>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="form-input" class="col-sm-3 col-xs-3 control-label"><?php echo trans('010');?></label>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="travellercount form-control" name="tadult">
                                        <option value="1" >1</option>
                                        <option value="2" <?php echo ($query->passenger['adult'] == 2) ? "selected" : ""; ?>>2</option>
                                        <option value="3" <?php echo ($query->passenger['adult'] == 3) ? "selected" : ""; ?>>3</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <label class="help-block">(12+yrs)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="form-input" class="col-sm-3 col-xs-3 control-label"><?php echo trans('011');?></label>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="travellercount form-control" name="tchildren" value="<?php echo $query->passenger['children']; ?>">
                                        <option value="0" <?php echo ($query->passenger['children'] == 0) ? "selected" : ""; ?>>0</option>
                                        <option value="1" <?php echo ($query->passenger['children'] == 1) ? "selected" : ""; ?>>1</option>
                                        <option value="2" <?php echo ($query->passenger['children'] == 2) ? "selected" : ""; ?>>2</option>
                                        <option value="3" <?php echo ($query->passenger['children'] == 3) ? "selected" : ""; ?>>3</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <label class="help-block">(4+yrs)</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="form-input" class="col-sm-3 col-xs-3 control-label"><?php echo trans('0282');?></label>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="travellercount form-control" name="tinfant" value="<?php echo $query->passenger['infant']; ?>">
                                        <option value="0" <?php echo ($query->passenger['infant'] == 0) ? "selected" : ""; ?>>0</option>
                                        <option value="1" <?php echo ($query->passenger['infant'] == 1) ? "selected" : ""; ?>>1</option>
                                        <option value="2" <?php echo ($query->passenger['infant'] == 2) ? "selected" : ""; ?>>2</option>
                                        <option value="3" <?php echo ($query->passenger['infant'] == 3) ? "selected" : ""; ?>>3</option>
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
                    <button type="button" class="btn btn-primary btn-block btn-lg bb" data-dismiss="modal" id="tsumPassenger"><?php echo trans('0233');?></button>
                </div>
            </div>
        </div>
    </div>
    <!--/ .modal -->

    <!-- <div class="clearfix"></div>

        <div class="trip-check">
        <div class="col-md-2 col-xs-6">
            <div class="pure-checkbox">
                <input id="oneway" name="triptype" type="radio" class="checkbox triptype" value="oneway" data-type="oneway" >
                <label for="oneway" data-type="oneway">&nbsp;<?php echo trans('0384');?></label>
            </div>
        </div>
        <div class="col-md-2 col-xs-6">
            <div class="pure-checkbox">
                <input id="round" name="triptype" type="radio" class="checkbox triptype" value="round" data-type="round" <?php if($query->triptype == "round") { ?> checked <?php } ?>>
                <label for="round" data-type="round">&nbsp;<?php echo trans('0385');?> </label>
            </div>
        </div>



     <div class="go-text-right form-horizontal">
            <div class="col-md-2 form-group go-right col-xs-12">
                <div class="clearfix"></div>
                <select class="form-control fs12 class" name="cabinclass">
                    <option value="economy" <?php echo ($query->cabinclass == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                    <option value="business" <?php echo ($query->cabinclass == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                    <option value="first" <?php echo ($query->cabinclass == "first") ? "selected" : ""; ?>><?php echo trans('0554');?></option>
                </select>
            </div>
        </div>
        </div>
</form> -->

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
