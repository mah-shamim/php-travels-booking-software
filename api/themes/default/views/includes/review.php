<!-- End row -->
  <div id="ADDREVIEW" class="panel-collapse collapse">
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo trans('083');?> <a href="#ADDREVIEW" data-toggle="collapse" data-parent="#accordion"><span class="badge badge-default pull-right">x</span></a></div>
      <div class="panel-body">
        <form class="form-horizontal row" method="POST" id="reviews-form-<?php echo $module->id;?>" action="" onsubmit="return false;">
          <div id="review_result<?php echo $module->id;?>" >
          </div>
          <div class="alert resp" style="display:none"></div>
          <?php $mdCol = 12; if($appModule == "hotels"){ $mdCol = 8; ?>
          <div class="col-md-4 go-right">
            <div class="well well-sm">
              <h3 class="text-center"><strong><?php echo trans('0389');?></strong>&nbsp;<span id="avgall_<?php echo $module->id; ?>"> 1</span> / 10</h3>
              <div class="row">
                <div class="col-md-6 form-horizontal">
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="control-label"><?php echo trans('030');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_clean">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="control-label"><?php echo trans('031');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_comfort">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="control-label"><?php echo trans('032');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_location">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="control-label"><?php echo trans('033');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_facilities">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                      <label class="control-label"><?php echo trans('034');?></label>
                      <select class="input-sm form-control reviewscore reviewscore_<?php echo $module->id; ?>" id="<?php echo $module->id; ?>" name="reviews_staff">
                        <option value="1"> 1 </option>
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
          <div class="col-md-<?php echo $mdCol;?>">
            <div class="row">
              <div class="col-md-6">
                <input class="form-control" type="text" name="fullname" placeholder="<?php echo trans('0390');?> <?php echo trans('0350');?>">
              </div>
              <div class="col-md-6">
                <input class="form-control" type="text" name="email" placeholder="<?php echo trans('0390');?> <?php echo trans('094');?>">
              </div>
            </div>
            <div class="form-group"></div>
            <textarea class="form-control" type="text" placeholder="<?php echo trans('0391');?>" name="reviews_comments" id="" cols="30" rows="10"></textarea>
            <div class="form-group"></div>
            <p class="text-danger"><strong><?php echo trans('0371');?></strong> : <?php echo trans('085');?></p>
            <input type="hidden" name="addreview" value="1" />
            <input type="hidden" name="overall" id="overall_<?php echo $module->id; ?>" value="1" />
            <input type="hidden" name="reviewmodule" value="<?php echo $appModule; ?>" />
            <input type="hidden" name="reviewfor" value="<?php echo $module->id; ?>" />
            <div class="form-group">
              <div class="col-md-12">
                <label class="control-label">&nbsp;</label>
                <button type="button" class="btn btn-primary btn-block btn-lg addreview" id="<?php echo $module->id; ?>" ><?php echo trans('086');?></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>