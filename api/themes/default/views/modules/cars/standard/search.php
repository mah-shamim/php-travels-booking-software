<?php
if($search->form_type == "iframe"){
echo $search->form_source;
}else{
?>

<style> .form-control{ -webkit-appearance:none; overflow: hidden; } </style>

      <form autocomplete="off" action="<?php echo base_url() . $module; ?>/search" method="GET" role="search">
    <!--<div class="section-tab section-tab-2 pb-3">
        <ul class="nav nav-tabs flight_types" id="myTab3" role="tablist">
            <div class="custom-control custom-radio  custom-control-inline">
            <input type="radio" id="flightSearchRadio-2" name="triptype" class="custom-control-input oneway"  value="oneway" <?php if($search->tripType == "oneway") { ?> checked <?php } ?>>
            <label class="custom-control-label" for="flightSearchRadio-2"><?php echo trans('0384');?></label>
            </div>
            <div class="custom-control custom-radio  custom-control-inline">
            <input type="radio" id="flightSearchRadio-1" name="triptype" class="custom-control-input return"  value="round" <?php if($search->tripType == "return") { ?> checked <?php } ?>>
            <label class="custom-control-label" for="flightSearchRadio-1"><?php echo trans('0385');?></label>
            </div>
        </ul>
    </div>-->
    <div class="tab-content" id="myTabContent3">
        <div class="tab-pane fade show active" id="one-way" role="tabpanel" aria-labelledby="one-way-tab">
            <div class="contact-form-action">
                <div class="row align-items-center">





                    <div class="col-lg-3 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0210'); ?>  <?php echo trans('032'); ?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>

                                <select name="pickupLocation" class="chosen-the-basic form-control" id="carlocations" required>
                  <option value="">
                    <?php echo trans( '0210'); ?>
                    <?php echo trans( '032'); ?>
                  </option>
                  <?php foreach ($data['carspickuplocationsList'] as $locations) : ?>
                  <option value="<?php echo $locations->id; ?>" <?php makeSelected($data['selectedpickupLocation'], $locations->id); ?> >
                    <?php echo $locations->name; ?>
                  </option>
                  <?php endforeach; ?>
                </select>

                            </div>
                        </div>
                    </div>



                    <div class="col-lg-3 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0473'); ?> <?php echo trans('032'); ?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>

                                <select name="dropoffLocation" class="chosen-the-basic form-control" id="carlocations2" required>
                  <option value="">
                    <?php echo trans( '0211'); ?>
                    <?php echo trans( '032'); ?>
                  </option>
                  </option>
                  <?php foreach ($data['carspickuplocationsList'] as $locations) : ?>
                  <option value="<?php echo $locations->id; ?>" <?php makeSelected($data['selectedpickupLocation'], $locations->id); ?> >
                    <?php echo $locations->name; ?>
                  </option>
                  <?php endforeach; ?>
                </select>

                            </div>
                        </div>
                    </div>


                    <!--<div class="col-lg-6">
                        <div class="input-box">
                            <label class="label-text"><?=lang('0640')?> <?=lang('0274')?></label>
                            <div class="form-group">
                                <span class="la la-map-marker form-icon"></span>
                                <input type="text" name="" value="<?=$search->destination?>" id="location_to" class="form-control" type="search" autocomplete="off">
                                <input type="hidden" name="destination" value="<?=$search->destination?>" id="location_to_code">
                            </div>
                        </div>
                    </div>-->

                    <!--<div class="col-lg-3 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0472'); ?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input id="FlightsDateStart" class="date-range form-control date-multi-picker" type="text" name="daterange-single" placeholder="<?php echo trans('0472'); ?>" value="<?php echo $search->departure_date; ?>">
                            </div>
                        </div>
                    </div>-->

                    <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0472'); ?> <?php echo trans('0473'); ?> <?php echo trans('08'); ?></label>
                            <div class="form-group">
                                <span class="la la-calendar form-icon"></span>
                                <input id="HotelsDateEnd" class="form-control date-multi-picker" type="text" name="daterange" placeholder="<?php echo trans('0472'); ?>" value="<?php echo $search->departure_date; ?>" vlue="<?php echo $search->arrival; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 pr-0">
                        <div class="input-box">
                            <label class="label-text"><?php echo trans('0472'); ?> <?php echo trans('0473'); ?> <?php echo trans('0259'); ?></label>
                            <div class="form-group row">


                         <div class="col-6 pr-0 pl-0">
                                <span class="la la-clock form-icon"></span>


                                <select class="form-control" name="pickupTime">
                        <option value="<?php echo trans( '0259'); ?>"><?php echo trans( '0259'); ?></option>
                        <?php foreach ($data['carModTiming'] as $time) { ?>
                        <option value="<?php echo $time; ?>" <?php makeSelected($data['pickupTime'], $time); ?> >
                          <?php echo $time; ?>
                        </option>
                        <?php } ?>
                      </select>
                      </div>

                         <div class="col-6 pr-0 pl-0">
                                <span class="la la-clock form-icon"></span>

                      <select class="form-control" name="dropoffTime">

                        <option><?php echo trans( '0259'); ?></option>
                        <?php foreach ($data['carModTiming'] as $time) { ?>
                        <option value="<?php echo $time; ?>" <?php makeSelected($data['dropoffTime'], $time); ?> >
                          <?php echo $time; ?>
                        </option>
                        <?php } ?>
                      </select>


                            </div>
                            </div>
                        </div>
                    </div>



                <div class="col-lg-2">
                <input type="hidden" name="module_type"/>
                <input type="hidden" name="slug"/>
                <button type="submit"  class="theme-btn w-100 text-center margin-top-20px">
                <?php echo trans('012'); ?>
                </button>
                </div>
                </div>

                <!--<div class="advanced-wrap">
                <a class="btn collapse-btn theme-btn-hover-gray font-size-15" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">
                Advanced options <i class="la la-angle-down ml-1"></i>
                </a>
                <div class="collapse pt-3" id="collapseThree">
                <div class="row">
                <div class="col-lg-4">
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
                </div>
                </div>
                </div>
                </div>--><!-- end advanced-wrap -->
            </div>
        </div><!-- end tab-pane -->
    </div>

  <input type="hidden" placeholder="dd/mm/yyyy" autocomplete="false"  class="form form-control input-lg" id="dropdate" name="pickupDate" placeholder="<?php echo trans( '0210'); ?> <?php echo trans( '08'); ?>" value="<?php echo $themeData->checkin; ?>" required>
  <input type="hidden" placeholder="dd/mm/yyyy" class="form-control form-readonly-control" id="returndate" name="dropoffDate" placeholder="<?php echo trans( '0211'); ?> <?php echo trans( '08'); ?>" value="<?php echo $themeData->checkout; ?>" required>

 </form>

<?php } ?>
























