<form autocomplete="off" name="juniper_search" id="juniper_search" onsubmit="return validate_juniper_form();" action="<?php echo base_url('hotelsj/'); ?>" method="post">
<div class="container" >
    <div class="row" >
        <div class="bgfade col-md-3 form-group go-right col-xs-6" >
            <div class="row">
                <div class="clearfix" >
                </div>
                <i class="iconspane-lg icon_set_1_icon-41" ></i>  
                <input type="text" required="required" value="<?php echo $juniper_data['city'] ?>" name="juniper_city" class="juniper_city_search" id="juniper_city">
            </div>
        </div>
        <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput" >
            <div class="row" >
                <div class="clearfix" ></div>
                <i class="iconspane-lg icon_set_1_icon-53" ></i >
                <input type="text" placeholder="Checkin Date" value="<?php echo $juniper_data['checkin_date']; ?>" id="checkin_date" name="juniper_checkin_date" class="form form-control input-lg juniper_checkin_date" required >
            </div>
        </div>
        <div class="bgfade col-md-2 form-group go-right col-xs-6 focusDateInput" >
            <div class="row" >
                <div class="clearfix" ></div>
                <i class="iconspane-lg icon_set_1_icon-53" ></i >
                <input type = "text"placeholder = "Checkout Date" name="juniper_checkout_date" value="<?php echo $juniper_data['checkout_date']; ?>" id ="checkout_date" value=""class="form form-control input-lg juniper_checkout_date" required="required" >
            </div>
        </div>

        <div class="bgfade col-md-2 form-group go-right col-xs-6" >
            <div class="row" >
                <div class="clearfix" >
                </div>
                <i class="iconspane-lg icon_set_1_icon-41" ></i>  
                <select class="form form-control select2" name="type" required="required">
                    <option value="">Room Type</option>
                    <option value="SGL" <?php if($juniper_data['room_type'] == "SGL"){ echo "selected"; } ?>>Single Room</option>
                    <option value="TSU" <?php if($juniper_data['room_type'] == "TSU"){ echo "selected"; } ?>>Twin for Sole Use Room</option>
                    <option value="TWN" <?php if($juniper_data['room_type'] == "TWN"){ echo "selected"; } ?>>Twin Room</option>
                    <option value="DBL" <?php if($juniper_data['room_type'] == "DBL"){ echo "selected"; } ?>>Double Room</option>
                    <option value="TRP" <?php if($juniper_data['room_type'] == "TRP"){ echo "selected"; } ?>>Triple Room</option>
                </select>
            </div>
        </div>
        <div class="bgfade col-md-2 form-group go-right col-xs-6" >
            <div class="row" >
                <div class="clearfix" >
                </div>
                <i class="iconspane-lg icon_set_1_icon-41" ></i>  
                <select class="form form-control select2" name="required" required="required">
                    <option value="">Required Rooms</option>
                    <option value="1" <?php if($juniper_data['room_required'] == "1"){ echo "selected"; } ?>>1</option>
                    <option value="2" <?php if($juniper_data['room_required'] == "2"){ echo "selected"; } ?>>2</option>
                    <option value="3" <?php if($juniper_data['room_required'] == "3"){ echo "selected"; } ?>>3</option>
                </select>
            </div>
        </div>
        <div class="bgfade col-md-1 col-xs-12 search-button" >
            <div class="clearfix" ></div>
            <button type = "submit"class="btn-primary btn btn-lg btn-block pfb0" >  <?php echo trans('012'); ?>  </button >
        </div>
        <div class="bgfade col-md-3 form-group go-right col-xs-6" >
            <div class="row">
                <div class="clearfix" >
                </div>
                <i class="iconspane-lg icon_set_1_icon-41" ></i>
                <input type="text" required="required" value="<?php echo $juniper_data['nationality'] ?>" name="juniper_nationality" class="juniper_nationality" id="juniper_nationality">
            </div>
        </div>
    </div>
</div>
</form>
<div id="overlay">
<div id="text"><img src="<?php echo base_url(''); ?>uploads/images/flights/airlines/hotel_loading.gif" alt="Searching flight"><br>Please Wait ... </div>
</div>
<style type="text/css">
.form-control.select2{
padding: 0px !important;
}
#overlay {
position: fixed;
display: none;
width: 100%;
height: 100%;
top: 0;
left: 0;
right: 0;
bottom: 0;
background: #fff;
z-index: 99999;
cursor: pointer;
}

#text{
position: absolute;
top: 50%;
left: 50%;
font-size: 50px;
color: black;
text-align: center;
transform: translate(-50%,-50%);
-ms-transform: translate(-50%,-50%);
}
</style>
<script type="text/javascript">
function ajax(){
    document.getElementById('overlay').style.display = "block";
    return false;
}

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

var juniper_checkin_date = $('.juniper_checkin_date').datepicker({
 format: 'yyyy-mm-dd',
 onRender: function(date) {
   return date.valueOf() < now.valueOf() ? 'disabled' : '';
}
}).on('changeDate', function(e){
$(this).datepicker('hide');
var newDate = new Date(e.date);
juniper_checkout_date.setValue(newDate.setDate(newDate.getDate() + 1));
$('.juniper_checkout_date').focus();
}).data('datepicker');

var juniper_checkout_date = $('.juniper_checkout_date').datepicker({
 format: 'yyyy-mm-dd',
 onRender: function(date) {
   return date.valueOf() <= juniper_checkin_date.date.valueOf() ? 'disabled' : '';
}
}).on('changeDate', function(){
$(this).datepicker('hide');
}).data('datepicker'); 

</script>