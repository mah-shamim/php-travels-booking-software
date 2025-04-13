<script type="text/javascript">
    $(function(){
        $(".submitfrm").submit(function(){
            for(instance in CKEDITOR.instances)
            {
                CKEDITOR.instances[instance].updateElement()
            }
        $(".output").html("");$('html, body').animate({scrollTop:$('body').offset().top},'slow');
            url="<?php echo base_url();?>admin/kiwi/KiwiBack/add_settings"
        $.post(url,$(".body_submit").serialize(),function(response){
                $(".output").html(response)
        })})})
</script>

<div class="output"></div>
<form class="submitfrm body_submit" method="POST"  onsubmit="return false;">
<div class="panel panel-default">
  <div class="panel-heading">Settings</div>
  <div class="panel-body">
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