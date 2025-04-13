<div class="output"><?php echo @$msg; ?></div>
<form action="" method="POST" autocomplete="off">
  <div class="panel panel-default">
  <div class="panel-heading"><?php echo $headingText;?> Location</div>
    <div class="panel-body">
      <div class="tab-content form-horizontal">
        <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="row form-group">
            <div class="col-md-3 control-label text-left">
            <label>Country</label>
              <select name="country" class="chosen-select" id="" required>
                <option value="">Select</option>
                <?php foreach($countries as $country){ ?>
                <option value="<?php echo $country->short_name.','.$country->iso2; ?>" <?php makeSelected(@$location->country, $country->short_name); ?> ><?php echo $country->short_name; ?></option>
                <?php } ?>
              </select>

            </div>

            <div class="col-md-3 control-label text-left">
            <label>Location / City</label>
              <input type="text" name="city" class="form-control Places" id="location" placeholder="Location" value="<?php echo @$location->city;?>" required autocomplete="off" />
            </div>

            <div class="col-md-2 control-label text-left">
            <label>Long</label>
              <input name="longitude" type="text" placeholder="Longitude" id="long" class="form-control" value="<?php echo @$location->longitude;?>" required />
            </div>

            <div class="col-md-2 control-label text-left">
            <label>Late</label>
              <input name="latitude" type="text" placeholder="Latitude" id="lat" class="form-control" value="<?php echo @$location->latitude;?>" required />
            </div>

            <div class="col-md-2 control-label text-left">
            <label>Status</label>

              <select name="status" class="form-control">
                <option value="Yes" <?php makeSelected(@$location->status,"Yes"); ?> > Enabled </option>
                <option value="No" <?php  makeSelected(@$location->status,"No"); ?> > Disabled </option>
              </select>

            </div>

          </div>

          <hr>
          <h4>Translation</h4>
          <hr>
          <div class="row form-group">
          <?php foreach($languages as $lang => $val){ if($lang != DEFLANG){ @$trans = $locationsModel->getLocationsTranslation($lang,$id);  ?>

          <label  class="col-md-2 control-label text-left"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
          <div class="col-md-4 form-group">
          <input type="text" name='<?php echo "translated[$lang][name]"; ?>' class="form-control" placeholder="Name" value="<?php echo @$trans[0]->loc_name;?>" >
          </div>

          <?php } } ?>
          </div>

        </div>
      </div>
    </div>
    <div class="panel-footer">
    <input type="hidden" name="submittype" value="<?php echo $submittype; ?>">
    <input type="hidden" name="locationid" value="<?php echo $id; ?>">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

<!-- google places -->
<script type='text/javascript' src="//maps.googleapis.com/maps/api/js?key=AIzaSyBq_Cu-poBhMXydOY9x31jTN2x73Sh0a4I&libraries=places"></script>
<script>//<![CDATA[
  $(window).load(function(){
   var autocomplete
  getPlace_dynamic();
  function getPlace_dynamic() {
  var input = document.getElementsByClassName('Places');
  var location = $("#location").val();
  for (i = 0; i < input.length; i++) {
  autocomplete = new google.maps.places.Autocomplete(input[i]);
  }
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();
       $('#lat').val(place.geometry.location.lat());
       $('#long').val(place.geometry.location.lng());
    });
  }
  });//]]>
</script>

<style>
.select2-container .select2-choice { height: 44px; line-height: 2.2; }
</style>