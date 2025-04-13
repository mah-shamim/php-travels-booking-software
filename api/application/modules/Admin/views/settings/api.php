<form action="" method="POST">
  <div class="panel panel-default">
    <div class="panel-heading"> API Management</div>
    <div class="panel-body">
      <div class="row form-group">
        <label class="col-md-2 control-label text-left">Payment Gateway</label>
        <div class="col-md-4">
          <select name="defaultgateway" class="form-control" name="" id="">
            <?php foreach ($all_payments as $apay) {
              if ($apay->payment_status == "1") { ?>
            <option value="<?php echo $apay->payment_id;?>" <?php if ($apay->payment_id == $settings[0]->default_gateway) {echo "selected";}?> ><?php echo $apay->payment_name;?></option>
            <?php } } ?>
          </select>
        </div>
      </div>
    </div>
    <input type="hidden" name="mobilesettings" value="1"/>
    <div class="panel-footer">
      <button class="btn btn-primary" type="submit">
      Submit
      </button>
    </div>
  </div>
</form>