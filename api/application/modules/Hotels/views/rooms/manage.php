<script type="text/javascript">
$(function(){

var room = $("#roomid").val();
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
url = "<?php echo base_url();?>admin/hotels/rooms/add" ;
}else{
url = "<?php echo base_url();?>admin/hotels/rooms/manage/"+room;
}
$.post(url,$(".room-form").serialize() , function(response){
if($.trim(response) != "done"){
$(".output").html(response);
}else{
window.location.href = "<?php echo base_url().$adminsegment.'/hotels/rooms/'?>";
}
});
});
});

$(function(){
var check = $("#price_type").val();
if(check == '0'){
$("#adultsprice").hide();
$("#childprice").hide();
$("#basicprice").show();
}else{
$("#adultsprice").show();
$("#childprice").show();
$("#basicprice").hide();
}
$("#price_type").change(function(){
var item = $(this).val();
if(item == '0'){
$("#adultsprice").hide();
$("#childprice").hide();
$("#basicprice").show();
}else{
$("#adultsprice").show();
$("#childprice").show();
$("#basicprice").hide();
}
});
});
</script>
<div class="panel panel-default">
<div class="panel-heading">
<?php echo $headingText;?>
</div>
</div>
<div class="output"></div>
<form class="form-horizontal room-form row" method="POST" action="" onsubmit="return false;" >
<div class="col-md-8">
  <div class="panel panel-default">
    <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="active"><a href="#GENERAL" data-toggle="tab">General</a></li>
      <li class=""><a href="#AMENITIES" data-toggle="tab">Amenities</a></li>
      <li class=""><a href="#TRANSLATE" data-toggle="tab">Translate</a></li>
    </ul>
    <div class="panel-body">
      <br>
      <div class="tab-content form-horizontal">
        <div class="tab-pane wow fadeIn animated active in" id="GENERAL">
          <div class="clearfix"></div>
          <div class="row form-group">
            <label class="col-md-12 control-label text-left">Room Description</label>
            <div class="col-md-12">
              <?php $this->ckeditor->editor('roomdesc', @$rdata[0]->room_desc, $ckconfig,'roomdesc'); ?>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="AMENITIES">
          <div class="row form-group">
            <div class="col-md-12">
              <div class="col-md-4">
                <label class="pointer"><input class="all" type="checkbox" name="" value="" id="select_all" > Select All</label>
              </div>
              <div class="clearfix"></div>
              <hr>
              <div class="clearfix"></div>
              <?php $roomamenity = explode(",",@$rdata[0]->room_amenities);
                $ramenities = pt_get_hsettings_data("ramenities");
                foreach($ramenities as $ramenity){ ?>
              <div class="col-md-6">
                <label class="pointer"><input class="checkboxcls" <?php if($submittype == "add"){ if( $ramenity->sett_selected == "1"){echo "checked";} }else{ if(in_array($ramenity->sett_id,$roomamenity)){ echo "checked"; } } ?> type="checkbox" name="roomamenities[]" value="<?php echo $ramenity->sett_id;?>"  > &nbsp; <?php echo $ramenity->sett_name;?></label>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">
          <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackRoomTranslation($lang,@$rdata[0]->room_id); ?>
          <div class="panel panel-default">
            <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
            <div class="panel-body">
              <!--<div class="row form-group">
                <label class="col-md-2 control-label text-left">Room Name</label>
                <div class="col-md-4">
                    <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="Room Name" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                </div>
                </div>-->
              <div class="row form-group">
                <label class="col-md-2 control-label text-left">Room Description</label>
                <div class="col-md-10">
                  <?php $this->ckeditor->editor("translated[$lang][desc]", @$trans[0]->trans_desc, $ckconfig,"translated[$lang][desc]"); ?>
                </div>
              </div>
            </div>
          </div>
          <?php } } ?>
        </div>
      </div>
    </div>
    <br>
  <input type="hidden" id="roomid" name="roomid" value="<?php echo @$rdata[0]->room_id;?>" />
  <input type="hidden" name="oldquantity" value="<?php echo @$rdata[0]->room_quantity;?>" />
  <input type="hidden" name="submittype" value="<?php echo $submittype;?>" />
  <button class="btn btn-primary btn-block btn-lg submitfrm" id="<?php echo $submittype; ?>">Submit</button>
  </div>
  </div>
  <div class="col-md-4 sticky">
   <div class="panel panel-default">
    <div class="panel-heading">Main Settings</div>
     <div class="panel-body">
     <div class="row form-group">
    <label class="col-md-3 control-label text-left">Status</label>
    <div class="col-md-9">
      <select class="form-control" name="roomstatus">
        <option value="Yes" <?php if(@$rdata[0]->room_status == 'Yes'){echo "selected";}?> >Enabled</option>
        <option value="No" <?php if(@$rdata[0]->room_status == 'No'){echo "selected";}?> >Disabled</option>
      </select>
    </div>
  </div>

  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Price Type</label>
    <div class="col-md-9" >
      <select id="price_type" name="price_type" class="form-control">
        <option value="0" <?php if(@$rdata[0]->price_type == '0'){echo "selected";}?> >By Fixed</option>
        <option value="1" <?php if(@$rdata[0]->price_type == '1'){echo "selected";}?> >By Travellers</option>
      </select>
    </div>
  </div>

  <div class="row form-group" id="basicprice">
<label class="col-md-3 control-label text-left">Price</label>
<div class="col-md-9">
  <strong>
  <input class="form-control input-lg"  Placeholder="Price" type="number" name="basicprice" value="<?php echo @$rdata[0]->room_basic_price;?>" />
  </strong>
</div>
</div>

<hr>
 <div class="row form-group" id="adultsprice">
     <label class="col-md-3 control-label text-left">Adults Price</label>
     <div class="col-md-9">
         <strong>
             <input class="form-control"  Placeholder="Adults Price" type="number" name="" value="<?php echo @$rdata[0]->room_adult_price;?>" />
         </strong>
     </div>
 </div>
 <div class="row form-group" id="childprice">
     <label class="col-md-3 control-label text-left">Child Price</label>
     <div class="col-md-9">
         <strong>
             <input class="form-control" Placeholder="Child Price"  type="number" name="childprice" value="<?php echo @$rdata[0]->room_child_price;?>" />
         </strong>
     </div>
 </div>

<hr>

  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Room Type</label>
    <div class="col-md-9">
      <select data-placeholder="Room Type" class="chosen-select" name="roomtype">
        <option value=""></option>
        <?php $rtypes = pt_get_hsettings_data("rtypes"); foreach($rtypes as $rtype){   ?>
        <option value="<?php echo $rtype->sett_id;?>" <?php if(@$rdata[0]->room_type == $rtype->sett_id){echo "selected";}?>  ><?php echo $rtype->sett_name;?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Hotel</label>
    <div class="col-md-9">
      <select data-placeholder="Hotel Name" class="chosen-select" name="hotelid" >
        <?php foreach($hotels as $h){ ?>
        <option value="<?php echo $h->hotel_id;?>" <?php if($h->hotel_id == @$rdata[0]->room_hotel){echo "selected";} ?>> <?php echo $h->hotel_title;?> </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Quantity</label>
    <div class="col-md-9">
      <input class="form-control" Placeholder="Quantity" type="number" name="quantity" value="<?php echo @$rdata[0]->room_quantity;?>" />
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Min Stay</label>
    <div class="col-md-9">
      <input class="form-control" Placeholder="Minimum Stay" type="number" min=1 name="minstay" value="<?php echo @$rdata[0]->room_min_stay;?>" />
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Max Adults</label>
    <div class="col-md-9">

      <select class="form-control adults" name="adults">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="3">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      </select>

      <script>
      $('.adults option[value=<?php echo @$rdata[0]->room_adults;?>]').attr('selected', 'selected');
      </script>

    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Max Child</label>
    <div class="col-md-9">

    <select class="form-control children" name="children">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="3">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      </select>

      <script>
      $('.children option[value=<?php echo @$rdata[0]->room_children;?>]').attr('selected', 'selected');
      </script>

    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">No. of Extra Beds</label>
    <div class="col-md-9">
      <input class="form-control" type="number" placeholder="Extra beds" name="extrabeds"  value="<?php echo @$rdata[0]->extra_bed;?>">
    </div>
  </div>
  <div class="row form-group">
    <label class="col-md-3 control-label text-left">Extra Bed Charges</label>
    <div class="col-md-9">
      <input class="form-control" type="number" placeholder="Beds charges" name="bedcharges"  value="<?php echo @$rdata[0]->extra_bed_charges;?>">
    </div>
  </div>
    </div>
   </div>
  </div>
</form>