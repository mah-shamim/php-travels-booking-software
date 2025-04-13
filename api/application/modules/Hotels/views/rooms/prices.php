<?php echo $errormsg;?>
<div class="panel panel-default">
  <div class="panel-heading">Rooms Prices</div>
  <div class="panel-body">
  <form action="" method="POST" >
    <div class="col-md-2">
      <div class="form-group">
        <label class="required">From Date</label>
        <input type="text" placeholder="From" name="fromdate" class="form-control input-sm dpd1" value="<?php echo set_value('fromdate'); ?>"/>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label class="required">To Date</label>
        <input type="text" placeholder="To" name="todate" class="form-control input-sm dpd2" value="<?php echo set_value('todate'); ?>"/>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="well well-sm">
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Adults</label>
          <select name="adult" class="form-control input input-sm" id="">
            <?php for($adults = 1; $adults <= $room[0]->room_adults; $adults++){ ?>
              <option value="<?php echo $adults; ?>" ><?php echo $adults; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Children </label>
          <select name="child" class="form-control input input-sm" id="">
            <?php for($child = 0; $child <= $room[0]->room_children; $child++){ ?>
              <option value="<?php echo $child; ?>" ><?php echo $child; ?></option>
              <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label class="required">Extra Bed </label>
          <input type="text" placeholder="" name="bedcharges" class="form-control input  input-sm" value="<?php echo $room[0]->extra_bed_charges;?>" <?php if($room[0]->extra_bed < 1){ echo "readonly"; } ?> />
        </div>
      </div>
      <div class="col-md-2" style="width:100px;">
        <label class="required">Mon</label>
      <div class="input-group" >

      <input type="number" step="any" name="mon" id="new_mon" class="form-control input  input-sm" placeholder="<?php echo $appSettings->currencysign;?>" style="width:60px;" ><span class="input-group-addon pointer"  onclick="copyPrices('new')"><i class="fa fa-angle-double-right"></i></span>

      </div>

      </div>

      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Tue</label>
          <input type="number" step="any" id="new_tue" name="tue" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input  input-sm"/>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Wed</label>
          <input type="number" step="any" id="new_wed" name="wed" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm"/>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Thu</label>
          <input type="number" step="any" id="new_thu" name="thu" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm"/>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Fri</label>
          <input type="number" step="any" id="new_fri" name="fri" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm"/>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Sat</label>
          <input type="number" step="any" id="new_sat" name="sat" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm"/>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label class="required">Sun</label>
          <input type="number" step="any" id="new_sun" name="sun" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm"/>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <div>&nbsp;</div>
          <input type="hidden" name="action" value="add" />
          <input type="hidden" name="roomid" value="<?php echo $roomid;?>" />
          <input type="hidden" name="dateformat" value="<?php echo $appSettings->dateFormat;?>" />
          <button class="btn btn-primary" type="submit">Add</button>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    </form>
    <div class="clearfix"></div>
    <hr>
    <form action="" method="POST">
    <table class="table table-striped form-horizontal">
      <thead>
        <tr>
          <th>Date From - To</th>
          <th>Adults</th>
          <th>Children</th>
          <th>Extra Beds</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
          <th>Sat</th>
          <th>Sun</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($prices as $p): ?>
        <tr id="tr_<?php echo $p->id;?>">
          <th><?php echo formatFullDate($p->date_from, $appSettings->dateFormat); ?> - <?php echo formatFullDate($p->date_to, $appSettings->dateFormat); ?></th>
          <td>
            <select name='<?php echo "pricesdata[$p->id][adults]"; ?>' class="form-control input input-sm" id="">
              <?php for($adults = 1; $adults <= $room[0]->room_adults; $adults++){ ?>
              <option value="<?php echo $adults; ?>" <?php if($adults == $p->adults){ echo "selected"; }?> ><?php echo $adults; ?></option>
              <?php } ?>
            </select>
          </td>
          <td>
            <select name='<?php echo "pricesdata[$p->id][child]"; ?>' class="form-control input input-sm" id="">
             <?php for($child = 0; $child <= $room[0]->room_children; $child++){ ?>
              <option value="<?php echo $child; ?>" <?php if($child == $p->children){ echo "selected"; }?> ><?php echo $child; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><input type="text" name='<?php echo "pricesdata[$p->id][extra_bed_charges]"; ?>' placeholder="" class="form-control input input-sm" value="<?php echo $p->extra_bed_charge;?>" <?php if($room[0]->extra_bed < 1){ echo "readonly"; } ?> /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td style="width:120px;"><div class="input-group" >
          <input type="number" step="any" name='<?php echo "pricesdata[$p->id][mon]"; ?>' id="<?php echo $p->id;?>_mon" class="form-control input input-sm" placeholder="<?php echo $appSettings->currencysign;?>" value="<?php echo $p->mon;?>" ><span class="input-group-addon pointer"  onclick="copyPrices('<?php echo $p->id;?>')"><i class="fa fa-angle-double-right"></i></span>
          </div>
          </td>
          <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][tue]"; ?>' id="<?php echo $p->id;?>_tue" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->tue;?>" /></td>
          <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][wed]"; ?>' id="<?php echo $p->id;?>_wed" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->wed;?>" /></td>
          <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][thu]"; ?>' id="<?php echo $p->id;?>_thu" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->thu;?>" /></td>
          <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][fri]"; ?>' id="<?php echo $p->id;?>_fri" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->fri;?>" /></td>
          <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][sat]"; ?>' id="<?php echo $p->id;?>_sat" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->sat;?>"/></td>
          <td><input type="number" step="any" name='<?php echo "pricesdata[$p->id][sun]"; ?>' id="<?php echo $p->id;?>_sun" placeholder="<?php echo $appSettings->currencysign;?>" class="form-control input input-sm" value="<?php echo $p->sun;?>" /></td>
          <td><span class="btn btn-sm btn-danger delete" id="<?php echo $p->id;?>"><i class="fa fa-trash-o fa-lg"></i>&nbsp;Delete</span></td>
        </tr>
       <?php endforeach; ?>


      </tbody>
    </table>

  </div>
  <div class="panel-footer">
    <input type="hidden" name="action" value="update" />
    <button class="btn btn-primary" type="submit"> Update </button>
  </div>
  </form>
</div>
<style>
  .input {
  width:60px;
  }
</style>
<script type="text/javascript">
$(function(){
  $(".delete").click(function(){
      var id =  $(this).attr('id');
      $.alert.open('confirm', 'Are you sure you want to delete', function(answer) {
         if (answer == 'yes'){
            $.post("<?php echo $delurl;?>", { id: id }, function(theResponse){
            $("#tr_"+id).fadeOut('slow');
         });
       }
        });
    });
  });

function copyPrices(id){
  var mainprice = $("#"+id+"_mon").val();
  $("#"+id+"_tue").val(mainprice);
  $("#"+id+"_wed").val(mainprice);
  $("#"+id+"_thu").val(mainprice);
  $("#"+id+"_fri").val(mainprice);
  $("#"+id+"_sat").val(mainprice);
  $("#"+id+"_sun").val(mainprice);
}

</script>