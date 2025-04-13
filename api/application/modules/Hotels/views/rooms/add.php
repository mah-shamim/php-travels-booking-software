<script type="text/javascript">
$(function(){$(".forever").hide();$(".fdate").hide();$("#image_default").change(function(){var preview_default=$('.default_preview_img');preview_default.fadeOut();var oFReader=new FileReader();oFReader.readAsDataURL(document.getElementById("image_default").files[0]);oFReader.onload=function(oFREvent){preview_default.attr('src',oFREvent.target.result).fadeIn()}});var options={beforeSend:function()
{},uploadProgress:function(event,position,total,percentComplete)
{},success:function()
{},complete:function(response)
{if($.trim(response.responseText)=="done"){$(".output").html('please Wait...');window.location.href="<?php echo base_url().$this->uri->segment(1).'/hotels/rooms/'; ?>"}},target:'.output'};$('.room-form').submit(function(){$(this).ajaxSubmit(options);$('html, body').animate({scrollTop:$('.panel-bg').offset().top},'slow');return!1})})
function featuredDate(option){if(option=='yes'){$('.fdate').fadeIn()}else{$('.fdate').fadeOut()}}
</script>
<div class="panel-body">
  <?php
    if(empty($hotels)){
       echo "<h1> Kinldy Add a Hotel to Add Room</h1>";
    }else{
    ?>
  <div class="output"> </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-tags"></i> Adding New Room</span>
      <div class="pull-right">
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <ul id="myTab" class="nav nav-tabs">
        <li class="active" id="generaltab"><a href="#General" data-toggle="tab"><i class="fa fa-exclamation-circle"></i> General</a></li>
        <li class=""><a href="#Features" data-toggle="tab"><i class="fa fa-tasks"></i> Features</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="General">
          <div class="spacer20px">
            <div class="col-lg-3">
              <div class="well">
                <form class="form-horizontal room-form" method="POST" action="" enctype="multipart/form-data" >
                  <div class="form-group">
                    <label class="col-md-4 control-label"> Quantity </label>
                    <div class="col-md-8">
                      <input class="form-control" Placeholder="Quantity" type="number" min=1 name="quantity" value="1" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label"> Room Minimum Stay </label>
                    <div class="col-md-8">
                      <input class="form-control" Placeholder="Minimum Stay" type="number" min=1 name="minstay" value="1" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">Status</label>
                    <div class="col-md-8">
                      <select  class="form-control" name="roomstatus">
                        <option  value="1" Selected>Enable</option>
                        <option  value="0" >Disable</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                      <select data-placeholder="Hotel Name" class="chosen-select" name="hotelid">
                        <option value="">Select Hotel</option>
                        <?php
                          if(empty($hotelid)){
                            $hotelid = "0";
                          }
                          foreach($hotels as $h){
                          ?>
                        <option value="<?php echo $h->hotel_id;?>" <?php if($h->hotel_id == $hotelid){echo "selected";} ?>> <?php echo $h->hotel_title;?> </option>
                        <?php
                          }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
                      <select data-placeholder="Room Type" class="chosen-select" name="roomtype">
                        <option>Room Type</option>
                        <?php
                          $rtypes = pt_get_hsettings_data("rtypes");
                                  foreach($rtypes as $rtype){
                           ?>
                        <option value="<?php echo $rtype->sett_id;?>"  ><?php echo $rtype->sett_name;?></option>
                        <?php
                          }

                          ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <label class="col-md-6 control-label"> Basic Price</label>
                    <div class="col-md-6">
                      <input class="form-control" Placeholder="Price" type="number" name="basicprice" />
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label class="col-md-4 control-label"> Discount</label>
                    <div class="col-md-6">
                    <input class="form-control" Placeholder="Price" type="number" name="discountprice" />
                    </div>
                    </div>-->
                  <input type="hidden" value="0" name="discountprice" />
              </div>
            </div>
            <div class="col-lg-9">
            <div class="panel panel-primary">
            <div class="panel-heading"><strong>Name</strong></div>
            <div style="margin-bottom: 0px;">
            <input class="form-control input-lg" type="text" placeholder="Type name here" name="roomname">
            </div>
            </div>
            <div class="panel panel-primary">
            <div class="panel-heading"><strong>Description</strong></div>
            <div  style="margin-bottom: 0px;">
            <textarea class="form-control" placeholder="Full description here..." rows="5" name="roomdesc"></textarea>
            </div>
            </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="Features">
        <div class="spacer20px">
        <div class="panel panel-primary">
        <div class="panel-heading">
        <h3 class="panel-title">Size</h3>
        </div>
        <div class="panel-body">
        <div class="form-horizontal">
        <div class="row">
        <label class="col-md-1 control-label">Adults</label>
        <div class="col-md-1">
        <input class="form-control" type="number" placeholder="Max Adults" name="adults"  value="">
        </div>
        <label class="col-md-1 control-label">Children</label>
        <div class="col-md-1">
        <input class="form-control" type="number" placeholder="Max Children" name="children"  value="">
        </div>
        <label class="col-md-1 control-label">Room Size</label>
        <div class="col-md-1">
        <input class="form-control" type="text" placeholder="Size" name="roomsize"  value="">
        </div>
        <label class="col-md-1 control-label">Bed Size</label>
        <div class="col-md-1">
        <input class="form-control" type="text" placeholder="Size" name="bedsize"  value="">
        </div>
        <label class="col-md-1 control-label">Bath Size</label>
        <div class="col-md-1">
        <input class="form-control" type="text" placeholder="Size" name="bathsize"  value="">
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="panel panel-primary">
        <div class="panel-heading">
        <h3 class="panel-title">Facilities</h3>
        </div>
        <div class="panel-body">
        <div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
        <div class="form-group">
        <label class="col-md-2 control-label">Amenities</label>
        <div class="col-md-10">
        <select multiple class="chosen-multi-select" name="roomamenities[]">
        <?php
          $ramenities = pt_get_hsettings_data("ramenities");
                  foreach($ramenities as $ramenity){
           ?>
        <option value="<?php echo $ramenity->sett_id;?>" <?php if($ramenity->sett_selected == "1"){echo "selected";} ?>  ><?php echo $ramenity->sett_name;?></option>
        <?php
          }

          ?>
        </select>
        </div>
        <div class="col-md-12"> &nbsp;</div>
        <label class="col-md-2 control-label">Additional Facilities</label>
        <div class="col-md-10">
        <div class="well well-sm">
        <textarea class="form-control" name="roomadditional" placeholder="Additional Features..." rows="3"></textarea>
        </div>
        </div>
        <label class="col-md-2 control-label">Room Specials</label>
        <div class="col-md-10">
        <div class="well well-sm">
        <textarea class="form-control" name="roomspecials" placeholder="Room Specials..." rows="3"></textarea>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="addroom" value="1" />
  <button class="btn btn-primary btn-lg pull-right"><i class="fa fa-save"></i> Submit</button>
  </form>
  <?php
    }
    ?>
</div>