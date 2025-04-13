<form action="" method="POST">
  <div class="panel panel-default">
    <div class="panel-heading">
      <span class="panel-title pull-left"> Blog Settings</span>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <div class="spacer20px">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Configuration </h3>
          </div>
          <div class="panel-body">
            <div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                <div class="form-group">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td>Main Icon</td>
                        <td style="width:380px">
                          <input type="text" name="page_icon" class="form-control" placeholder="Select icon" value="<?php echo $settings[0]->front_icon;?>" >
                        </td>
                        <td>Select icon to show on front-end</td>
                      </tr>
                      <tr>
                        <td>Menu Target</td>
                        <td>
                          <select  class="form-control" name="target">
                            <option  value="_self" <?php makeSelected('_self',$settings[0]->linktarget); ?> >Self</option>
                            <option  value="_blank" <?php makeSelected('_blank',$settings[0]->linktarget); ?> >Blank</option>
                          </select>
                        </td>
                        <td>Select page target option for front-end</td>
                      </tr>
                      <tr>
                        <td>Header title</td>
                        <td>
                          <input type="text" class="form-control" name="headertitle" value="<?php echo $settings[0]->header_title;?>" placeholder="title "/>
                        </td>
                        <td>Write your listing page header title here</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Display</h3>
          </div>
          <div class="panel-body">
            <div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <label class="col-md-3 control-label">Number of Posts on Home Page</label>
              <div class="col-md-2">
                <input class="form-control" type="text" placeholder="" name="home"  value="<?php echo $settings[0]->front_homepage;?>">
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Display order </label>
                <div class="col-md-3">
                  <select class="form-control" name="order">
                    <option value="ol" label="By Order Given" <?php if ($settings[0]->front_homepage_order == "ol") {echo "selected";}?>>By Order Given</option>
                    <option value="newf" label="By Latest First" <?php if ($settings[0]->front_homepage_order == "newf") {echo "selected";}?> >By Latest First</option>
                    <option value="oldf" label="By Oldest First" <?php if ($settings[0]->front_homepage_order == "oldf") {echo "selected";}?>>By Oldest First</option>
                    <option value="az" label="Ascending Order (A-Z)" <?php if ($settings[0]->front_homepage_order == "az") {echo "selected";}?>>Ascending Order (A-Z)</option>
                    <option value="za" label="Descending  Order (Z-A)" <?php if ($settings[0]->front_homepage_order == "za") {echo "selected";}?>>Descending  Order (Z-A)</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <label class="col-md-3 control-label">Show on Homepage </label>
                <div class="col-md-2">
                  <select class="form-control" name="showonhomepage">
                    <option value="Yes" <?php if ($settings[0]->front_homepage_hero == "Yes") {echo "selected";}?>>Yes</option>
                    <option value="No" <?php if ($settings[0]->front_homepage_hero == "No") {echo "selected";}?> >No</option>
                  </select>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-md-3 control-label">Number of Posts on Listing Page</label>
                <div class="col-md-2">
                  <input class="form-control" type="text" placeholder="" name="listings"  value="<?php echo $settings[0]->front_listings;?>">
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Display Order</label>
                  <div class="col-md-3">
                    <select class="form-control" name="listingsorder">
                      <option value="ol" label="By Order Given" <?php if ($settings[0]->front_listings_order == "ol") {echo "selected";}?>>By Order Given</option>
                      <option value="newf" label="By Latest First" <?php if ($settings[0]->front_listings_order == "newf") {echo "selected";}?> >By Latest First</option>
                      <option value="oldf" label="By Oldest First" <?php if ($settings[0]->front_listings_order == "oldf") {echo "selected";}?>>By Oldest First</option>
                      <option value="az" label="Ascending Order (A-Z)" <?php if ($settings[0]->front_listings_order == "az") {echo "selected";}?>>Ascending Order (A-Z)</option>
                      <option value="za" label="Descending  Order (Z-A)" <?php if ($settings[0]->front_listings_order == "za") {echo "selected";}?>>Descending  Order (Z-A)</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-md-3 control-label">Number of Posts Search Result</label>
                <div class="col-md-2">
                  <input class="form-control" type="text" placeholder="" name="searchresult"  value="<?php echo $settings[0]->front_search;?>">
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Display order Searched Posts</label>
                  <div class="col-md-3">
                    <select class="form-control" name="searchorder">
                      <option value="ol" label="By Order Given" <?php if ($settings[0]->front_search_order == "ol") {echo "selected";}?>>By Order Given</option>
                      <option value="newf" label="By Latest First" <?php if ($settings[0]->front_search_order == "newf") {echo "selected";}?>>By Latest First</option>
                      <option value="oldf" label="By Oldest First" <?php if ($settings[0]->front_search_order == "oldf") {echo "selected";}?>>By Oldest First</option>
                      <option value="az" label="Ascending Order (A-Z)" <?php if ($settings[0]->front_search_order == "az") {echo "selected";}?>>Ascending Order (A-Z)</option>
                      <option value="za" label="Descending  Order (Z-A)" <?php if ($settings[0]->front_search_order == "za") {echo "selected";}?>>Descending  Order (Z-A)</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-md-3 control-label">Number of Related Posts</label>
                <div class="col-md-2">
                  <input class="form-control" type="text" placeholder="" name="related"  value="<?php echo $settings[0]->front_related;?>">
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Related Posts</label>
                  <div class="col-md-3">
                    <select class="form-control" name="relatedstatus">
                      <option value="1" <?php if ($settings[0]->testing_mode == "1") {echo "selected";}?> >Enabled</option>
                      <option value="0" <?php if ($settings[0]->testing_mode == "0") {echo "selected";}?> >Disabled</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label class="col-md-3 control-label">Number of Popular Posts</label>
                <div class="col-md-2">
                  <input class="form-control" type="text" placeholder="" name="popular"  value="<?php echo $settings[0]->front_popular;?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   <div class="panel-footer">
  <input type="hidden" name="updatesettings" value="1" />
  <input type="hidden" name="updatefor" value="blog" />
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>  </div>
  </div>
</form>