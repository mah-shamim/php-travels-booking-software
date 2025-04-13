<script type="text/javascript">
    $(function(){
        $(".submitfrm").submit(function(){
            for(instance in CKEDITOR.instances)
            {
                CKEDITOR.instances[instance].updateElement()
            }
        $(".output").html("");$('html, body').animate({scrollTop:$('body').offset().top},'slow');
            url="<?php echo base_url();?>admin/flights/flightsback/add_settings"
        $.post(url,$(".body_submit").serialize(),function(response){
                $(".output").html(response)
        })})})
</script>

<div class="output"></div>
<form class="submitfrm body_submit" method="POST"  onsubmit="return false;">
<div class="panel panel-default">
  <div class="panel-heading">Settings</div>
  <div class="panel-body">


  <div class="tab-content form-horizontal">
        <input name="modulename" type="hidden" value="kiwi">
        <div class="row form-group">
        <label class="col-md-2 control-label text-left">B2C Markup</label>
        <div class="col-md-2">
        <input type="number" name="b2c_markup" class="form-control" placeholder="B2C Markup" value="">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <label class="col-md-1 control-label text-left">Deposit</label>
        <div class="col-md-2">
        <input type="number" name="desposit" class="form-control" placeholder="Desposit on Booking" value="">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">B2B Markup</label>
        <div class="col-md-2">
        <input type="number" name="b2b_markup" class="form-control" placeholder="B2B Markup" value="">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <label class="col-md-1 control-label text-left">Tax Vat</label>
        <div class="col-md-2">
        <input type="number" name="tax" class="form-control" placeholder="Tax Vat on Booking" value="">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">B2E Markup</label>
        <div class="col-md-2">
        <input type="number" name="b2e_markup" class="form-control" placeholder="B2E Markup" value="">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <label class="col-md-1 control-label text-left">Service Fee</label>
        <div class="col-md-2">
        <input type="number" name="servicefee" class="form-control" placeholder="Booking Service Fee" value="">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>       

      </div>


  <hr>
   <div class="row form-group">
    <label  class="col-md-2 control-label text-left">Testing Mode</label>
    <div class="col-md-4">
      <select  class="form-control" name="mode">
        <option  value="1" <?php if($check == "true"){ echo "selected";} ?> > On </option>
        <option  value="0" <?php if($check == "false"){ echo "selected";} ?> > Off </option>
      </select>
    </div>
  </div>
  </div>
    <div class="panel-footer">
    <button class="btn btn-primary">Submit</button>
  </div>
</div>
</form>