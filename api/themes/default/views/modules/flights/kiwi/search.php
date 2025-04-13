<style>
    .form-control{
        -webkit-appearance:none;
        overflow: hidden;
    }  
</style>

<?php
if($search->form_type == "form") { 

	//echo $search->route;
	//die;
?>
<div class="tab-inner menu-horizontal-content">
    <div class="form-search-main-01">
        <form autocomplete="off" name="flightmanualSearch" action="<?= $search->route; ?>" method="GET" role="search">
            <div class="form-inner">
                <div class="row  mb-10 row-reverse align-items-start row-return">
                    <div class="col-8">
                    <div class="row row-reverse" style="margin-top:4px">
                        <?php if($search->show_oneway == '1'){ ?>
                        <div class="custom-control custom-radio  custom-control-inline" style="margin-top: -5px;">
                            <input type="radio" id="flightSearchRadio-2" name="triptype" class="custom-control-input oneway"  value="oneway" <?php if($search->tripType == "oneway") { ?> checked <?php } ?>>
                            <label class="custom-control-label" for="flightSearchRadio-2"><?php echo trans('0384');?></label>
                        </div>
                        <?php } if($search->show_return == '1'){ ?>
                        <div class="custom-control custom-radio  custom-control-inline" style="margin-top: -5px;">
                            <input type="radio" id="flightSearchRadio-1" name="triptype" class="custom-control-input return"  value="round" <?php if($search->tripType == "round") { ?> checked <?php } ?>>
                            <label class="custom-control-label" for="flightSearchRadio-1"><?php echo trans('0385');?></label>

                        </div>
                        <?php } if($search->show_multi_city == '1'){ ?>
                        <div class="custom-control custom-radio  custom-control-inline">
                            <input type="radio" id="flightSearchRadio-3"  name="triptype"  class="custom-control-input">
                            <label class="custom-control-label" for="flightSearchRadio-3">Multicities</label>

                            </div>
                        <?php } ?>
                    </div>
                    </div>

                    <?php if($search->show_classtype == 1){ ?>
                    <div class="col-4">
                        <!-- <label><?=lang('0557')?></label>-->
                        <div class="form-icon-left flightclass">
                            <span class="icon-font"><i class="bx bx-time"></i></span>
                            <select class="chosen-the-basic form-control form-control-sm trip_class" name="cabinclass" required>
                                <option value="first" <?php echo ($search->classType == "first") ? "" : "selected"; ?>><?php echo trans('0554');?></option>
                                <option value="business" <?php echo ($search->classType == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                                <option value="economy" <?php echo ($search->classType == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="clear"></div>
                  <div class="row no-gutters mb-15 row-reverse">
                      <div class="col-md-5 col-xs-12">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label><?=lang('0273')?></label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left typeahead__container">
                                        <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                        <input class="form-control" type="text" name="" value="<?=$search->origin?>" id="location_from" type="search" autocomplete="off">
                                        <input type="hidden" name="origin" value="<?=$search->origin?>" id="location_from_code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label><?=lang('0274')?></label>
                                    <div class="clear"></div>
                                    <div class="form-icon-left typeahead__container">
                                        <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                                        <input type="text" name="" value="<?=$search->destination?>" id="location_to" class="form-control" type="search" autocomplete="off">
                                        <input type="hidden" name="destination" value="<?=$search->destination?>" id="location_to_code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="col-inner">
                            <div id="airDatepickerRange-flight" class="row no-gutters mb-15">
                                <div class="class12 col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0472'); ?></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input id="FlightsDateStart" class="form-control form-readonly-control" placeholder="<?php echo trans('0472'); ?>" name="departure_date" value="<?php echo $search->departure_date; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <?php  if($search->show_return == '1'){ ?>
                                <div class="hidediv col-6">
                                    <div class="form-group">
                                        <label><?php echo trans('0473'); ?></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                                            <input id="FlightsDateEnd" autocomplete="false" class="form-control form-readonly-control" placeholder="<?php echo trans('0473'); ?>" name="reture_date" value="<?php echo $search->reture_date; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="col-inner">
                            <div class="row no-gutters">
                                <?php if($search->show_adult == '1'){ ?>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('010');?> <small class="text-muted font10 line-1" hidden>(12-75)</small></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="fadults" value="<?php echo $search->adults; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <?php } if($search->show_children == '1'){?>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('011');?> <small class="text-muted font10 line-1" hidden>(2-12)</small></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" readonly name="fchildren" value="<?php echo $search->children; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <?php } if($search->show_infant == '1'){?>
                                <div class="col-4">
                                    <div class="form-group form-spin-group">
                                        <label for="room-amount"><?php echo trans('0282');?> <small class="text-muted font10 line-1" hidden>(0-2)</small></label>
                                        <div class="clear"></div>
                                        <div class="form-icon-left">
                                            <span class="icon-font text-muted"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control touch-spin-03 form-readonly-control" placeholder="0" name="finfant" readonly value="<?php echo $search->infant; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <button type="submit" class="btn-primary btn btn-block">
                        <?php echo trans('012'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } elseif ($search->form_type == "url") { echo $search->form_source;
    }elseif ($search->form_type == "iframe")
    {
        echo $search->form_source;
    }
    ?>

<script type="text/javascript">
    $( document ).ready(function() {
        $(".hidediv").hide();
        $(".class12").addClass('col-12');
    });
    //Radio Button disable end date
    $(".oneway").click(function() {
        $("#tarcoend").prop('disabled', true);
        $(".hidediv").hide();
        $(".class12").addClass('col-12');
    });
    //Radio Button enable end date
    $(".return").click(function() {
        $("#tarcoend").removeAttr('disabled');
        $(".hidediv").show();
        $(".class12").removeClass('col-12');
    });
   
</script>