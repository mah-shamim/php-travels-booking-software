<script type="text/javascript">
  $(function(){
     var slug = $("#slug").val();
     $(".submitfrm").click(function(){
       var submitType = $(this).prop('id');
       for ( instance in CKEDITOR.instances )
        {
        CKEDITOR.instances[instance].updateElement();
        }
        $(".output").html("");
        $('html, body').animate({
        scrollTop: $('body').offset().top
        }, 'slow');
       if(submitType == "add"){
       url = "<?php echo base_url();?>admin/hotels/add" ;
       }else{
       url = "<?php echo base_url();?>admin/hotels/manage/"+slug;
       }
       $.post(url,$(".hotel-form").serialize() , function(response){
           if($.trim(response) != "done"){
               $(".output").html(response);
           }else{
               window.location.href = "<?php echo base_url().$adminsegment."/hotels/"?>";
           }
       });
     })
  })
</script>
<!--<h3 class="margin-top-0"><?php echo $headingText;?></h3>-->
<div class="output"></div>
<form action="" method="POST" class="hotel-form row" enctype="multipart/form-data" onsubmit="return false;" >



<div class="col-md-8">
<div class="backgrop">
  <div class="panel panel-default">
    <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="active"><a href="#GENERAL" data-toggle="tab">General</a></li>
      <li class=""><a href="#FACILITIES" data-toggle="tab">Facilities</a></li>
      <li class=""><a href="#META_INFO" data-toggle="tab">Meta Info</a></li>
      <li class=""><a href="#POLICY" data-toggle="tab">Policy</a></li>
      <li class=""><a href="#CONTACT" data-toggle="tab">Contact</a></li>
      <li class=""><a href="#TRANSLATE" data-toggle="tab">Translate</a></li>
    </ul>
    <div class="panel-body">
      <br>
      <div class="tab-content form-horizontal">
        <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="clearfix"></div>
          <div class="row form-group">
            <label class="col-md-12 control-label text-left">Hotel Name</label>
            <div class="col-md-12">
              <input name="hotelname" type="text" placeholder="Hotel Name" class="form-control" value="<?php echo @$hdata[0]->hotel_title;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-12 control-label text-left">Hotel Description</label>
            <div class="col-md-12">
              <?php $this->ckeditor->editor('hoteldesc', @$hdata[0]->hotel_desc, $ckconfig,'hoteldesc'); ?>
            </div>
          </div>
          
      <!-- Address and Map -->

        <div class="panel panel-default">
        <div class="panel-heading"><strong>Map Address</strong></div>
        <div class="panel-body" style="margin-bottom: 0px;">
        <div class="col-md-12 form-horizontal">
        <table class="table">
        <tr>
        <td>Address on Map</td>
        <td>
       <input type="text" class="form-control Places" id="mapaddress" name="hotelmapaddress" value="<?php echo $hdata[0]->hotel_map_city;?>">
        </td>
        </tr>
        <tr>
        <td></td>
        </tr>
        <tr>
        <td>Latitude</td>
        <td><input type="text" class="form-control" id="latitude" value="<?php echo $hdata[0]->hotel_latitude;?>"  name="latitude" /></td>
        </tr>
        <tr>
        <td>Longitude</td>
        <td><input type="text" class="form-control" id="longitude" value="<?php echo $hdata[0]->hotel_longitude;?>"  name="longitude" /></td>
        </tr>
        </table>

        </div>
        <div class="col-md-12">
        <div class="thumbnail">
        <div id="map-canvas" style="height: 200px; width:400"></div>
        </div>
        </div>
        <div class="clearfix"></div>
        </div>
        </div>
          <!-- Address and Map -->
       </div>
        <div class="tab-pane wow fadeIn animated in" id="FACILITIES">
          <div class="row form-group">
            <div class="col-md-12">
              <div class="col-md-4">
                <label class="pointer"><input class="all" type="checkbox" name="" value="" id="select_all" > Select All</label>
              </div>
              <div class="clearfix"></div>
              <hr>
              <div class="clearfix"></div>
              <?php $hamenity = explode(",",@$hdata[0]->hotel_amenities);
                foreach($hamts as $hamt){ ?>
              <div class="col-md-4">
                <label class="pointer"><input class="checkboxcls" <?php if($submittype == "add"){ if( $hamt->sett_selected == "1"){echo "checked";} }else{ if(in_array($hamt->sett_id,$hamenity)){ echo "checked"; } } ?> type="checkbox" name="hotelamenities[]" value="<?php echo $hamt->sett_id;?>"  > <?php echo $hamt->sett_name;?></label>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="META_INFO">
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Meta Title</label>
            <div class="col-md-10">
              <input name="hotelmetatitle" type="text" placeholder="Title" class="form-control" value="<?php echo @$hdata[0]->hotel_meta_title;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Meta Keywords</label>
            <div class="col-md-10">
              <textarea name="hotelkeywords" placeholder="Keywords" class="form-control" id="" cols="30" rows="2"><?php echo @$hdata[0]->hotel_meta_keywords;?></textarea>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Meta Description</label>
            <div class="col-md-10">
              <textarea name="hotelmetadesc" placeholder="Description" class="form-control" id="" cols="30" rows="4"><?php echo @$hdata[0]->hotel_meta_desc;?></textarea>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="POLICY">
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Check In</label>
            <div class="col-md-4">
              <input name="checkintime" type="text" placeholder="Check In" class="form-control timepicker" data-format="hh:mm A" value="<?php echo $checkin;?>" />
            </div>
            <label class="col-md-2 control-label text-left">Check Out</label>
            <div class="col-md-4">
              <input name="checkouttime" type="text" placeholder="Check Out" class="form-control timepicker" data-format="hh:mm A" value="<?php echo $checkout;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Payment Options</label>
            <div class="col-md-10">
              <select multiple class="chosen-multi-select" name="hotelpayments[]">
                <?php foreach($hpayments as $hpayment){ ?>
                <option value="<?php echo $hpayment->sett_id;?>" <?php if($submittype == "add"){ if( $hpayment->sett_selected == "1"){echo "selected";} }else{ if(in_array($hpayment->sett_id,$hotelpaytypes)){ echo "selected"; } } ?> >
                  <?php echo $hpayment->sett_name;?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Policy And Terms</label>
            <div class="col-md-10">
              <textarea name="hotelpolicy" placeholder="Policy..." class="form-control" id="" cols="30" rows="7"><?php echo @$hdata[0]->hotel_policy;?></textarea>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="CONTACT">
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Hotel's Email</label>
            <div class="col-md-10">
              <input name="hotelemail" type="text" placeholder="Email" class="form-control " value="<?php echo @$hdata[0]->hotel_email;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Hotel's Website</label>
            <div class="col-md-10">
              <input name="hotelwebsite" type="text" placeholder="Website" class="form-control " value="<?php echo @$hdata[0]->hotel_website;?>" />
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">Phone</label>
            <div class="col-md-10">
              <input name="hotelphone" type="text" placeholder="Phone" class="form-control" value="<?php echo @$hdata[0]->hotel_phone;?>" />
            </div>
          </div>
         <!--  <div class="row form-group">
           <label class="col-md-2 control-label text-left">Full Address</label>
           <div class="col-md-6">
             <input name="hoteladdress" type="text" placeholder="Address" class="form-control" value="<?php echo @$hdata[0]->hotel_address;?>" />
           </div>
         </div> -->
        </div>
        <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">
          <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackHotelTranslation($lang,$hotelid); ?>
          <div class="panel panel-default">
            <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
            <div class="panel-body">
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Hotel Name</label>
                <div class="col-md-10">
                  <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="Hotel Name" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Hotel Description</label>
                <div class="col-md-10">
                  <?php $this->ckeditor->editor("translated[$lang][desc]", @$trans[0]->trans_desc, $ckconfig,"translated[$lang][desc]"); ?>
                  <!--    <textarea name='<?php echo "translated[$lang][desc]"; ?>' placeholder="Description..." class="form-control" id="" cols="30" rows="4"><?php echo @$trans[0]->trans_desc;?></textarea>   -->
                </div>
              </div>
              <hr>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Meta Title</label>
                <div class="col-md-10">
                  <input name='<?php echo "translated[$lang][metatitle]"; ?>' type="text" placeholder="Title" class="form-control" value="<?php echo @$trans[0]->metatitle;?>" />
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Meta Keywords</label>
                <div class="col-md-10">
                  <textarea name='<?php echo "translated[$lang][keywords]"; ?>' placeholder="Keywords" class="form-control" id="" cols="30" rows="2"><?php echo @$trans[0]->metakeywords;?></textarea>
                </div>
              </div>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Meta Description</label>
                <div class="col-md-10">
                  <textarea name='<?php echo "translated[$lang][metadesc]"; ?>' placeholder="Description" class="form-control" id="" cols="30" rows="4"><?php echo @$trans[0]->metadesc;?></textarea>
                </div>
              </div>
              <hr>
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Policy And Terms</label>
                <div class="col-md-10">
                  <textarea name='<?php echo "translated[$lang][policy]"; ?>' placeholder="Policy..." class="form-control" id="" cols="15" rows="4"><?php echo @$trans[0]->trans_policy;?></textarea>
                </div>
              </div>
            </div>
          </div>
          <?php } } ?>
        </div>
      </div>

    </div>
    <div class="panel-footer">
      <input type="hidden" id="slug" value="<?php echo @$hdata[0]->hotel_slug;?>" />
      <input type="hidden" name="submittype" value="<?php echo $submittype;?>" />
      <input type="hidden" name="hotelid" value="<?php echo @$hotelid;?>" />
      <button class="btn btn-primary btn-lg btn-block submitfrm" id="<?php echo $submittype; ?>">Submit</button>
      </div>

  </div>
  </div>
  </div>

  <div class="col-md-4 sticky">
  <div class="backgrop">
      <div class="panel panel-default">
       <div class="panel-heading">Main Settings</div>
        <div class="panel-body form-horizontal">

        <div class="row form-group">
            <label class="col-md-3 control-label text-left">Status</label>
            <div class="col-md-9">
              <select data-placeholder="Select" class="form-control" name="hotelstatus">
                <option value="Yes" <?php if(@$hdata[0]->hotel_status == "Yes"){ echo "selected"; }?> >Enabled</option>
                <option value="No" <?php if(@$hdata[0]->hotel_status == "No"){ echo "selected"; }?> >Disabled</option>
              </select>
            </div>
          </div>

          <div class="row form-group">
           <?php if($isadmin){ ?>
            <label class="col-md-3 control-label text-left">Stars</label>
            <div class="col-md-9">
              <select data-placeholder="Select" class="form-control" name="hotelstars">
                <?php for($stars = 1; $stars <= 5;$stars++){ ?>
                <option value="<?php echo $stars;?>" <?php if(@$hdata[0]->hotel_stars == $stars){ echo 'selected'; } ?> > <?php echo $stars; ?></option>
                <?php } ?>
              </select>
            </div>
            <?php }else{ ?>
            <input type="hidden" name="hotelstars" value="<?php echo @$hdata[0]->hotel_stars;?>">
            <?php } ?>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Hotel Type</label>
            <div class="col-md-9">
              <select data-placeholder="Select" class="form-control" name="hoteltype">
                <?php foreach($htypes as $ht){ ?>
                <option value="<?php echo $ht->sett_id;?>" <?php if(@$hdata[0]->hotel_type == $ht->sett_id){ echo 'selected'; } ?>  ><?php echo $ht->sett_name;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row form-group">
           <?php if($isadmin){ ?>
            <label class="col-md-3 control-label text-left">Featured</label>
            <div class="col-md-3">
              <select data-placeholder="Select" class="form-control" name="isfeatured">
                <option value="yes" <?php if(@$hdata[0]->hotel_is_featured == "yes"){ echo 'selected'; } ?>>Yes</option>
                <option value="no" <?php if(@$hdata[0]->hotel_is_featured == "no"){ echo 'selected'; } ?>>No</option>
              </select>
            </div>
            <div class="col-md-6" style="padding-left:0px">
            <div class="">
            <div class="col-md-6">
            <div class="row">
              <input name="ffrom" type="text" placeholder="From" class="form-control dpd1" value="<?php echo @$featuredfrom; ?>" />
            </div>
            </div>
            <div class="col-md-6">
            <div class="row">
              <input name="fto" type="text" placeholder="To" class="form-control dpd2" value="<?php echo @$featuredto; ?>" />
            </div>
            </div>
            </div>
            </div>
               <?php  }else{ ?>
          <input type="hidden" name="isfeatured" value="<?php echo @$hdata[0]->hotel_is_featured; ?>">
          <input type="hidden" name="ffrom" value="<?php echo @$featuredfrom; ?>">
          <input type="hidden" name="fto" value="<?php echo @$featuredto; ?>">
          <?php } ?>

          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Location</label>
            <div class="col-md-9">
              <input type="text" id="searching" class="locationlist">
              <input type="hidden" name="hotelcity" id="locationid" required="" value="<?php echo @$hdata[0]->hotel_city; ?>">
            </div>

          </div>

          <?php if(isModuleActive('tripadvisor')){ ?>
          <div class="row form-group">
            <label class="col-md-2 control-label text-left">TripAdvisor</label>
            <div class="col-md-9">
              <input type="text" name="tripadvisor" class="form-control" placeholder="TripAdvisor ID" value="<?php echo @$hdata[0]->tripadvisor_id;?>" />
            </div>
          </div>
          <?php } ?>

<!--
          <div class="row form-group">
            <label class="col-md-3 control-label text-left">Related Hotels</label>
            <div class="col-md-9">
              <select multiple class="chosen-multi-select" name="relatedhotels[]">
                <?php //foreach($all_hotels as $hotel){ if($hdata[0]->hotel_id != $hotel->hotel_id){ ?>
                <option value="<?php //echo $hotel->hotel_id;?>" <?php // if(in_array($hotel->hotel_id,@$hrelated)){ echo 'selected'; } ?>  >
                  <?php // echo $hotel->hotel_title;?>
                </option>
                <?php //} } ?>
              </select>
            </div>
          </div> -->

       </div>
      </div>


        <div class="panel panel-default">
        <div class="panel-heading"><strong>markup</strong></div>
        <div class="panel-body form-horizontal">

      <div class="row form-group">
        <label class="col-md-4 control-label text-left">B2C Markup</label>
        <div class="col-md-7">
        <input type="number" name="b2c_markup" class="form-control" placeholder="B2C Markup" value="<?php echo @$hdata[0]->b2c_markup;?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <div class="row form-group">
        <label class="col-md-4 control-label text-left">B2B Markup</label>
        <div class="col-md-7">
        <input type="number" name="b2b_markup" class="form-control" placeholder="B2B Markup" value="<?php echo @$hdata[0]->b2b_markup;?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <div class="row form-group">
        <label class="col-md-4 control-label text-left">B2E Markup</label>
        <div class="col-md-7">
        <input type="number" name="b2e_markup" class="form-control" placeholder="B2E Markup" value="<?php echo @$hdata[0]->b2e_markup;?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <hr>

        <div class="row form-group">
        <label class="col-md-4 control-label text-left">Service Fee</label>
        <div class="col-md-7">
        <input type="number" name="service_fee" class="form-control" placeholder="Service Fee" value="<?php echo @$hdata[0]->service_fee;?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>
        <hr>

        <div class="row form-group">
            <label class="col-md-3 control-label text-left text-success">Deposit</label>
            <div class="col-md-5">
            <?php  if($isadmin){ ?>
              <select name="deposittype" class="form-control">
                <option value="percentage" <?php if(@$hoteldeposittype == "percentage"){ echo 'selected'; } ?>>Percentage</option>
                <option value="fixed" <?php if(@$hoteldeposittype == "fixed"){ echo 'selected'; } ?> >Fixed</option>
              </select>
            <?php }else{ ?>
            <input type="text" class="form-control" name="deposittype" value="<?php echo $hoteldeposittype; ?>" readonly="readonly">
            <?php } ?>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" id="" placeholder="Value" name="depositvalue" value="<?php echo @$hoteldepositval;?>" <?php if(!$isadmin){ echo "readonly"; } ?> >
            </div>
          </div>
          <div class="row form-group">
            <label class="col-md-3 control-label text-left text-danger">Vat Tax</label>
            <div class="col-md-5">
              <select name="taxtype" class="form-control">
                <option value="fixed" <?php if(@$hoteltaxtype == "fixed"){ echo 'selected'; } ?> >Fixed</option>
                <option value="percentage" <?php if(@$hoteltaxtype == "percentage"){ echo 'selected'; } ?> >Percentage</option>
              </select>
            </div>
            <div class="col-md-4">
              <input class="form-control" id="" Placeholder="Value" type="text" name="taxvalue" value="<?php echo @$hoteltaxval;?>" />
            </div>
          </div>



        </div>
        </div>

  </div>
  </div>

</form>

<!-- google places -->

    <script>

      function initAutocomplete() {

        var markers = [];

        var ex_latitude = $('#latitude').val();

        var ex_longitude = $('#longitude').val();

          if (ex_latitude != '' && ex_longitude != ''){

            var map = new google.maps.Map(document.getElementById('map-canvas'), {
          center: {lat: parseFloat(ex_latitude), lng: parseFloat(ex_longitude)},
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });


             var marker = new google.maps.Marker(

                {

                    map: map,

                    draggable:true,
                    icon: "<?php echo PT_DEFAULT_IMAGE . 'marker.png'; ?>",

                    animation: google.maps.Animation.DROP,

                    position: new google.maps.LatLng(ex_latitude, ex_longitude)

                });



            markers.push(marker);

            google.maps.event.addListener(marker, 'dragend', function()

            {

                var marker_positions = marker.getPosition();

                $('#latitude').val(marker_positions.lat());

                $('#longitude').val(marker_positions.lng());



            });


          }else{

            var map = new google.maps.Map(document.getElementById('map-canvas'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

          }



        // Create the search box and link it to the UI element.
        var input = document.getElementById('mapaddress');
        var searchBox = new google.maps.places.SearchBox(input);
       // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());

        });

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
          if (places.length == 0) {
            return;
          }


map.setZoom(16);

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);


          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            var marker = new google.maps.Marker({
              map: map,
              icon: "<?php echo PT_DEFAULT_IMAGE . 'marker.png'; ?>",
              title: place.name,
              position: place.geometry.location,
              draggable: true,
              animation: google.maps.Animation.DROP,
            });
            // Create a marker for each place.
            markers.push(marker);

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }

          google.maps.event.addListener(marker, 'dragend', function()

            {

                var marker_positions = marker.getPosition();

                $('#latitude').val(marker_positions.lat());

                $('#longitude').val(marker_positions.lng());



            });



      $('#latitude').val(place.geometry.location.lat());
      $('#longitude').val(place.geometry.location.lng());


          });



          map.fitBounds(bounds);
          map.setZoom(16);

        });




      }


    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $appSettings->mapApi; ?>&libraries=places&callback=initAutocomplete" async defer></script>
 <!-- Google Places -->


<script>
  $(document).ready(function() {
      if (window.location.hash != "") {
          $('a[href="' + window.location.hash + '"]').click()
      }

      $('.locationlist').select2(
        {
                placeholder: "<?php if(empty($locationName)){ echo "Enter Location"; }else{ echo @$locationName; } ?>",
                minimumInputLength: 3,
                width:'100%', maximumSelectionSize: 1,
                initSelection: function (element, callback) {
                        var data = {id: "1", text: "<?php echo @$locationName; ?>"};
                        callback(data);
                    },
                ajax: {
                    url: "<?php echo base_url(); ?>admin/ajaxcalls/locationsList",
                    dataType: 'json',
                    data: function (term, page) {
                        return {
                            query: term, // search term

                        };
                    },
                    results: function (data, page) {

                        return {results: data};
                    }
                }
            }
       );

       $('.locationlist').on("select2-selecting", function(e) {
         $("#locationid").val(e.val);
         console.log(e.val);
      });
  });
</script>