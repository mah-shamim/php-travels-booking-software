<style> .form-control{ -webkit-appearance:none; overflow: hidden; } </style>
<?php if($search->form_type == "form") {?>

<form autocomplete="off" name="flightmanualSearch" action="<?php echo base_url(); ?>flights/search/" method="GET" role="search">
    <div class="section-tab section-tab-2 pb-3">
        <ul class="nav nav-tabs flight_types" id="myTab3" role="tablist">
            <?php if($search->show_oneway == '1'){ ?>
            <div class="custom-control custom-radio  custom-control-inline">
            <input type="radio" id="flightSearchRadio-1" name="triptype" class="custom-control-input oneway selection" value="oneway" <?php if($search->tripType == "oneway") { ?> checked <?php } ?>>
            <label class="custom-control-label" for="flightSearchRadio-1"><?php echo trans('0384');?></label>
            </div>
            <?php } if($search->show_return == '1'){ ?>
            <div class="custom-control custom-radio  custom-control-inline">
            <input type="radio" id="flightSearchRadio-2" name="triptype" class="custom-control-input return"  value="round" <?php if($search->tripType == "return") { ?> checked <?php } ?>>
            <label class="custom-control-label" for="flightSearchRadio-2"><?php echo trans('0385');?></label>
            </div>
            <?php } ?>
            <?php if($search->show_multi_city == '1'){ ?>
            <?php } ?>
            <!--<div class="custom-control custom-radio  custom-control-inline">
            <input type="radio" id="flightSearchRadio-3" name="triptype" class="custom-control-input selection" value="multi">
            <label class="custom-control-label" for="flightSearchRadio-3"><?=trans('0639')?></label>
            </div>-->
            <script>
            $(document).ready(function() {
            $(".selection").click(function() {
            var app = $(this).val();
            $(".desc").hide();
            $("#tab" + app).show();
            });});
            </script>
        </ul>
        <input type="hidden" value="<?=$search->tripType?>" id="checktype" />

    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
            <div class="contact-form-action desc" id="taboneway">
                <div class="row align-items-center">

                    <div class="col-lg-3 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0640')?> <?=lang('0273')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                <input class="form-control" type="text" name="" value="<?=$search->origin?>" id="location_from" type="search" autocomplete="off">
                                <input type="hidden" name="origin" value="<?=$search->origin?>" id="location_from_code">
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->

                    <div class="col-lg-3 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0640')?> <?=lang('0274')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                <input type="text" name="" value="<?=$search->destination?>" id="location_to" class="form-control" type="search" autocomplete="off">
                                <input type="hidden" name="destination" value="<?=$search->destination?>" id="location_to_code">
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->

                    <div class="onewayhide class12 col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0472'); ?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input id="FlightsDateStart" class="form-control flights_oneway" type="text" name="" placeholder="<?php echo trans('0472'); ?>" value="<?php echo $search->departure_date; ?>">
                            </div>
                        </div>
                    </div>

                    <?php  if($search->show_return == '1'){ ?>
                    <div class="hidediv col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0472'); ?> - <?php echo trans('0473'); ?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input id="FlightsDateEnd" class="form-control flights_return" type="text" name="" placeholder="<?php echo trans('0472'); ?>" value="<?php echo $search->departure_date; ?>" vlue="<?php echo $search->arrival; ?>">
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=trans('0607')?></label>
                            <div class="form-group">
                                <div class="dropdown dropdown-contain">
                                    <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        <span><?=trans('0528')?> <span class="guest_flights">0</span></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-wrap">
                                        <?php if($search->show_adult == '1'){ ?>
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                <label><?php echo trans('010');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" id="fadults" name="qtyInput" value="<?php echo $search->adults; ?>" class="qtyInput_flights">
                                                </div>
                                            </div>
                                        </div>
                                        <?php } if($search->show_children == '1'){?>
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                <label><?php echo trans('011');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" id="fchildren" name="qtyInput" value="<?php echo $search->children; ?>" class="qtyInput_flights">
                                                </div>
                                            </div>
                                        </div>
                                        <?php } if($search->show_infant == '1'){?>
                                        <div class="dropdown-item">
                                            <div class="qty-box d-flex align-items-center justify-content-between">
                                                <label><?php echo trans('0282');?></label>
                                                <div class="qtyBtn d-flex align-items-center">
                                                    <input type="text" id="finfant" name="qtyInput" readonly value="<?php echo $search->infant; ?>" class="qtyInput_flights">
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <button type="submit" class="theme-btn w-100 text-center margin-top-20px"><?php echo trans('012'); ?></button>
                    </div>
                </div>

                <div class="advanced-wrap">
                <a class="btn collapse-btn theme-btn-hover-gray font-size-15" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">
                <?=trans('0645');?> <i class="la la-angle-down ml-1"></i>
                </a>
                <div class="collapse pt-3" id="collapseThree">
                 <div class="row">

                <?php if($search->show_classtype == 1){ ?>
                    <div class="col-lg-4">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0557')?></label>
                            <div class="form-group">
                                <div class="select-contain w-auto">
                                    <select class="select-contain-select trip_class" name="cabinclass" required>
                                    <option value="first" <?php echo ($search->classType == "first") ? "" : "selected"; ?>><?php echo trans('0554');?></option>
                                    <option value="business" <?php echo ($search->classType == "business") ? "selected" : ""; ?>><?php echo trans('0553');?></option>
                                    <option value="economy" <?php echo ($search->classType == "economy") ? "selected" : ""; ?>><?php echo trans('0552');?></option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->
                    <?php } ?>

                <!--<div class="col-lg-4">
                <div class="input-box">
                <label class="label-text">Preferred airline</label>
                <div class="form-group">
                <div class="select-contain w-100">
                <select class="select-contain-select">
                <option selected="selected" value=""> No preference</option>
                <option value="WS">WestJet</option>
                <option value="WM">Windward Island Airways International</option>
                <option value="MF">Xiamen Airlines</option>
                <option value="SE">XL Airways</option>
                </select>
                </div>
                </div>
                </div>
                </div>-->
                </div>
                </div>
                </div>
                <!-- end advanced-wrap -->
                </div>

         <div class="multi-flight-wrap desc" id="tabmulti" role="tabpanel" aria-labelledby="multi-city-tab" style="display: none;">
            <div class="contact-form-action multi-flight-field d-flex align-items-center row">
                <form action="#" class="row flex-grow-1 align-items-center">
                    <div class="col-lg-4 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0640')?> <?=lang('0273')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                <input class="form-control location" type="text" id="" placeholder="City or airport">
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->
                    <div class="col-lg-4 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0640')?> <?=lang('0274')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                <input class="form-control location" type="text" placeholder="City or airport">
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->
                    <div class="col-lg-3">
                        <div class="input-box">
                            <label class="label-text"><?=trans('08');?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input class="date-range form-control date" type="text" name="" value="">
                            </div>
                        </div>
                    </div><!-- end col-lg-3 -->
                    <div class="multi-flight-delete-wrap pt-3 pl-3">
                    <button class="multi-flight-remove" type="button"><i class="la la-remove"></i></button>
                    </div>
                </form>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col-lg-2 pr-0">
                    <div class="form-group">
                        <button class="theme-btn add-flight-btn w-100" type="button"><i class="la la-plus mr-1"></i> Add flight</button>
                    </div>
                </div>

                <div class="col-lg-2 pr-0">
                    <div class="input-box">
                        <div class="form-group">
                            <div class="dropdown dropdown-contain">
                                <a class="dropdown-toggle dropdown-btn" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    <span>Passengers <span class="qtyTotal guestTotal_4">0</span></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-wrap">
                                    <div class="dropdown-item">
                                        <div class="qty-box d-flex align-items-center justify-content-between">
                                            <label>Adults</label>
                                            <div class="qtyBtn d-flex align-items-center">
                                                <input type="text" name="qtyInput" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="qty-box d-flex align-items-center justify-content-between">
                                            <label>Children</label>
                                            <div class="qtyBtn d-flex align-items-center">
                                                <input type="text" name="qtyInput" value="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-item">
                                        <div class="qty-box d-flex align-items-center justify-content-between">
                                            <label>Infants</label>
                                            <div class="qtyBtn d-flex align-items-center">
                                                <input type="text" name="qtyInput" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end dropdown -->
                        </div>
                    </div>
                </div><!-- end col-lg-3 -->

                <div class="col-lg-4 pr-0">
                    <div class="input-box">
                        <div class="form-group">
                            <div class="select-contain w-auto">
                                <select class="select-contain-select">
                                    <option value="1" selected>Economy</option>
                                    <option value="2">Business</option>
                                    <option value="3">First class</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- end col-lg-3 -->
                <div class="col-lg-3">
                    <a href="flight-search-result.html" class="theme-btn w-100 text-center mb-3">Search Now</a>
                </div>
            </div>
         </div>

     </div><!-- end tab-pane -->
    </div>
 </form>

    <?php } elseif ($search->form_type == "url") { echo $search->form_source;
    }elseif ($search->form_type == "iframe")
    { echo $search->form_source;  }
    ?>

    <script type="text/javascript">
    $( document ).ready(function() {
    var check = document.getElementById('checktype').value;
    if(check == 'return') {
        $(".hidediv").show();
        $(".onewayhide").hide();
        $(".class12").removeClass('col-12');
    }else{
    $(".hidediv").hide();
    $(".class12").addClass('col-12');
    }
    });

    //Radio Button disable end date
    $(".oneway").click(function() {
    $("#tarcoend").prop('disabled', true);
    $(".hidediv").hide();
    $(".onewayhide").show();
    $(".class12").addClass('col-12');
    });

    //Radio Button enable end date
    $(".return").click(function() {
    $("#tarcoend").removeAttr('disabled');
    $(".hidediv").show();
    $(".onewayhide").hide();
    $(".class12").removeClass('col-12');
    });
    </script>