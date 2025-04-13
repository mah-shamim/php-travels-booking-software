<div class="panel panel-default">
  <div class="panel-heading"><?php echo $header_title; ?></div>

   <div class="panel-body">
     <?php echo $content; ?>
   </div>
 </div>


 <!-- translation Modal -->
 <?php foreach($extras as $ext){ ?>
<div class="modal fade" id="extra<?php echo $ext->extras_id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update <?php echo $ext->extras_title;?></h4>
      </div>
      <div class="modal-body form-horizontal">


<?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackExtrasTranslation($lang,$ext->extras_id); ?>
<div class="row form-group">
<label  class="col-md-3 control-label text-left"> Name in <img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
<div class="col-md-8">
<input type="text" name='<?php echo "translated[$lang][title]"; ?>' class="form-control" placeholder="Name" value="<?php echo @$trans[0]->trans_title;?>" >
</div>
</div>
<?php } } ?>

      </div>
      <div class="modal-footer">
      <input type="hidden" name="updateextra" value="1" />
      <input type="hidden" name="extrasid" value="<?php echo $ext->extras_id;?>" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>
<!----translation modal--->

 <!-- assign Modal -->
 <?php  foreach($extras as $ext){ $assigned = explode(",",$ext->extras_for);  ?>
<div class="modal fade" id="assign<?php echo $ext->extras_id;?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Assign <?php echo $ext->extras_title;?></h4>
      </div>
      <div class="modal-body form-horizontal">


<div class="row form-group">
 <label class="col-md-2 control-label text-left">Assign to</label>
<div class="col-md-12">
<select multiple class="chosen-multi-select" name="items[]">
<?php foreach($itemslist as $item){ ?>
<option value="<?php echo $item->id;?>" <?php  if(in_array($item->id,@$assigned)){ echo 'selected'; } ?>  >
<?php echo $item->title;?></option>
<?php } ?>
</select>
 </div>
</div>
      </div>
      <div class="modal-footer">
      <input type="hidden" name="updateassign" value="1" />
      <input type="hidden" name="otheritems" value="<?php echo @$otherItems; ?>" />
      <input type="hidden" name="extrasid" value="<?php echo $ext->extras_id;?>" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>
<!--assign modal-->