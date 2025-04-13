<?php if(!empty($module->extras)){ ?>
<div class="form-box">
<div class="form-title-wrap">
<h3 class="title"><?php echo trans('0156');?></h3>
</div><!-- form-title-wrap -->
<div class="form-content">

<table style="margin-bottom:0px" class="table table-striped cart-list add_bottom_30 RTL">
<thead>
<tr class="text-left">
<th class="text-left"><?php echo trans('0376');?></th>
<th class="text-left"><?php echo trans('077');?></th>
<th class="text-left"><?php echo trans('070');?></th>
<th class="text-center"><?php echo trans('0399');?></th>
</tr>
</thead>
<tbody>
<?php foreach($module->extras as $extra){ ?>
<tr>
<td>
<div class="thumb_cart">
<img style="height:40px;width:40px" src="<?php echo $extra->thumbnail;?>" alt="<?php echo $extra->extraTitle;?>">
</div>
</td>
<td>
<span class="item_cart"><?php echo $extra->extraTitle;?></span>
</td>
<td>
<?php echo $room->currCode;?> <?php echo $room->currSymbol;?><?php echo $extra->extraPrice;?>
</td>
<td>
<label class="switch">
<input type="checkbox" id="<?php echo $extra->id;?>" name="extras[]" value="<?php echo $extra->id;?>" onclick="updateBookingData('<?php echo $extraChkUrl;?>')">
<span class="slider round"></span>
<!--<span>
<span><?php echo trans('0363');?></span>
<span><?php echo trans('0364');?></span>
</span>-->
<a></a>
</label>
<div class="clear"></div>
</td>
</tr>
<?php } ?>
</tbody>
</table>

</div><!-- end form-content -->

<style>
.table td{
    vertical-align:middle !important;
    border:none !important;
}
.table th{
    border:none !important;
}
.table .switch{
    left:30px;
}
.table tr{
    position:relative;
} 
@media(max-width:992px){
    .table .switch{
    left:0px;
}
}
.switch{position:relative;display:inline-block;width:50px;height:25px}
.switch input{opacity:0;width:0;height:0}
.slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background-color:#ccc;-webkit-transition:.4s;transition:.4s}
.slider:before{position:absolute;content:"";height:21px;width:21px;left:2px;bottom:2px;background-color:white;-webkit-transition:.4s;transition:.4s}
input:checked+.slider{background-color:#3e50b4}
input:focus+.slider{box-shadow:0 0 1px #3e50b4}
input:checked+.slider:before{-webkit-transform:translateX(26px);-ms-transform:translateX(26px);transform:translateX(26px)}
.slider.round{border-radius:34px}
.slider.round:before{border-radius:50%}
</style>


<script>
$(function () {
"use strict";
$(".numbers-row").append('<div class="inc button_inc">+</div><div class="dec button_inc">-</div>');
$(".button_inc").on("click", function () {
var $button = $(this);
var oldValue = $button.parent().find("input").val();
if ($button.text() == "+") {
var newVal = parseFloat(oldValue) + 1;
} else {
// Don't allow decrementing below zero
if (oldValue > 1) {
var newVal = parseFloat(oldValue) - 1;
} else {
newVal = 1;
}
}
$button.parent().find("input").val(newVal);
});
});
</script>
</div>
<?php } ?>