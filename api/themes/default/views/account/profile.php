<div class="dashboard-bread dashboard--bread">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="breadcrumb-content">
          <div class="section-heading">
            <h2 class="sec__titles font-size-30 cw"><?php echo trans('073');?></h2>
          </div>
          </div><!-- end breadcrumb-content -->
          </div><!-- end col-lg-6 -->
              </div><!-- end row -->
            </div>
          </div>
          <!-- end dashboard-bread -->
          <!-- CONTENT -->
          <div class="dashboard-main-content">
            <div class="clearfix"></div>
            <div class="container-fluid">
              <!-- CONTENT -->
              <div class="row">
                <!-- LEFT MENU -->
                <div class="col-lg-12">
                  <div class="form-box">
                    <div class="clearfix"></div>
                    
                    <div class="form-title-wrap">
                      <div class="d-flex align-items-center justify-content-between">
                        <div>
                          <h3 class="title"><?php echo trans('073');?> </h3>
                        </div>
                      </div>
                    </div>

                    <div class="form-content">
                      <form action="" id="profilefrm" method="POST" onsubmit="return false;">
                        <div class="row">
                          <div class="col-12 col-md-12 col-lg-12">
                            <div class="row">
                              <div class="col-12 col-sm-6 o2">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('090');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('090');?>" name="firstname" value="<?php echo $profile[0]->ai_first_name; ?>" readonly>
                                </div>
                              </div>
                              <div class="col-12 col-sm-6 o1">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('091');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('091');?>" name="lastname" value="<?php echo $profile[0]->ai_last_name; ?>" readonly>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-sm-12">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('094');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="email" class="form-control form-bg-light" placeholder="<?php echo trans('094');?>" name="email" value="<?php echo $profile[0]->accounts_email; ?>">
                                </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('095');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input class="form-control form-bg-light" type="password" placeholder="<?php echo trans('095');?>" name="password" value="">
                                </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('096');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input class="form-control form-bg-light" type="password" placeholder="<?php echo trans('096');?>" name="confirmpassword" value="">
                                </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('098');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('098');?>" name="address1" value="<?php echo $profile[0]->ai_address_1; ?>">
                                </div>
                              </div>
                              <div class="col-12 col-sm-12">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('099');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('099');?>" name="address2" value="<?php echo $profile[0]->ai_address_2; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-sm-6">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('0100');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('0100');?>" name="city" value="<?php echo $profile[0]->ai_city; ?>">
                                </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('0101');?>/
                                    <?php echo trans('0102');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('0101');?>/<?php echo trans('0102');?>" name="state" value="<?php echo $profile[0]->ai_state; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-sm-6">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('0103');?>/
                                    <?php echo trans('0104');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('0103');?>/<?php echo trans('0104');?>" name="zip" value="<?php echo $profile[0]->ai_postal_code; ?>">
                                </div>
                              </div>
                              <div class="col-12 col-sm-6">
                                <div class="form-group  mb-0 chosen-bg-light">
                                  <label>
                                    <?php echo trans('0105');?>
                                  </label>
                                  <div class="clear"></div>
                                  <select class="chosen-the-basic form-control form-bg-light" tabindex="2">
                                    <option>
                                      <?php echo trans('0484');?>
                                    </option>
                                    <?php
                                    foreach($allcountries as $country){
                                    ?>
                                    <option value="<?php echo $country->iso2;?>" <?php if($profile[0]->ai_country == $country->iso2){echo "selected";}?> >
                                      <?php echo $country->short_name;?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 col-sm-6 rtl-ml-auto">
                                <div class="form-group">
                                  <label>
                                    <?php echo trans('092');?>
                                  </label>
                                  <div class="clear"></div>
                                  <input type="text" class="form-control form-bg-light" placeholder="<?php echo trans('092');?>" name="phone" value="<?php echo $profile[0]->ai_mobile; ?>">
                                </div>
                              </div>
                            </div>
                            <hr class="mt-40 mb-40" />
                            <div class="mb-30"></div>
                            <div class="row gap-10 mt-15 justify-content-center justify-content-md-start">
                              <div class="btn-box rtl-ml-auto">
                                <input type="hidden" name="oldemail" value="<?php echo $profile[0]->accounts_email;?>" />
                                <button type="submit" class="btn btn-block btn-lg updateprofile btn-primary ml-3">
                                <?php echo trans('086');?>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    
                  </div>
                  <!-- END OF TAB 1 -->
                  <!-- End of Tab panes from left menu -->
                </div>
                <!-- END OF RIGHT CPNTENT -->
                <div class="clearfix"></div>
              </div>
              
              <!-- END CONTENT -->
            </div>
          </div>