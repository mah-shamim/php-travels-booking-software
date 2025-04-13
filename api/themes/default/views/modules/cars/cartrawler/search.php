<div class="tab-inner menu-horizontal-content">
  <div class="form-search-main-01">
   <form action="<?php echo base_url(); ?>car/" method="GET" target="_self" autocomplete="off">
      <div class="form-inner">
        <div class="row gap-10 mb-20">
          <div class="col-lg-2 col-xs-12">
            <div class="form-group">
              <label><?php echo trans('0210'); ?>  <?php echo trans('032'); ?></label>
              <div class="form-icon-left">
                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                 <input  class='form-control form-readonly-control car-startlocation' name="startlocation" type='text' placeholder="<?php echo trans('0210'); ?>" />
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-xs-12">
            <div class="form-group">
              <label><?php echo trans('0211'); ?>  <?php echo trans('032'); ?></label>
              <div class="form-icon-left ">
                <span class="icon-font text-muted"><i class="bx bx-map"></i></span>
                <input class='form-control form-readonly-control car-endlocation' name="endlocation" type='text' placeholder="<?php echo trans('0211'); ?>" />
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-12">
            <div class="col-inner">
              <div id="airDatepickerRange-flight" class="row no-gutters mb-15">
                <div class="col-6">
                  <div class="form-group">
                    <label><?php echo trans('0472'); ?>  <?php echo trans('08'); ?></label>
                    <div class="form-icon-left">
                      <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                      <input placeholder="dd/mm/yyyy" autocomplete="false" class="form-control form-readonly-control checkinsearch CarTrawlerStart" placeholder="<?php echo trans('0472'); ?>" name="pickupdate" value="<?=$data['checkin']?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label><?php echo trans('0472'); ?>  <?php echo trans('0259'); ?></label>
                    <div class="form-icon-left">
                      <span class="icon-font text-muted"><i class="bx bx-time"></i></span>
                      <select class="chosen-the-basic form-control" name="timeDepart">
                        <option value="<?php echo trans( '0259'); ?>"><?php echo trans( '0259'); ?></option>
                        <?php foreach($data['timing'] as $time){ ?>
                        <option value="<?php echo $time; ?>" <?php makeSelected('10:00',$time); ?> ><?php echo $time; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-12">
            <div class="col-inner">
              <div id="airDatepickerRange-flight" class="row no-gutters mb-15">
                <div class="col-6">
                  <div class="form-group">
                    <label><?php echo trans('0473'); ?>  <?php echo trans('08'); ?></label>
                    <div class="form-icon-left">
                      <span class="icon-font text-muted"><i class="bx bx-calendar"></i></span>
                      <input placeholder="dd/mm/yyyy" autocomplete="false" class="form-control form-readonly-control checkinsearch CarTrawlerEnd" placeholder="<?php echo trans('0472'); ?>" name="dropoffdate" value="<?=$data['checkout']?>" required>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label><?php echo trans('0473'); ?>  <?php echo trans('0259'); ?></label>
                    <div class="form-icon-left">
                      <span class="icon-font text-muted"><i class="bx bx-time"></i></span>
                      <select class="chosen-the-basic form-control" name="timeReturn">
                        <option><?php echo trans( '0259'); ?></option>
                      <?php foreach($data['timing'] as $time){ ?>
                      <option value="<?php echo $time; ?>" <?php makeSelected('10:00',$time); ?> ><?php echo $time; ?></option>
                      <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-xs-12">
        <input type="hidden" id="pickuplocation" name="pickupLocationId" value="">
        <input type="hidden" id="returnlocation" name="returnLocationId" value="">
        <input type="hidden" name="clientId" value="<?php echo $data['cartrawlerid'];?>">
        <input type="hidden" name="residencyId" value="US">
          <button type="submit"  class="btn-primary btn btn-block">
          <?php echo trans('012'); ?>
          </button>
        </div>
        </div>
      </div>
    </form>
  </div>
</div>
