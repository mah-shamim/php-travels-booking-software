<form action="" class="form-horizontal" method="POST">
  <div class="panel panel-default">
    <div class="panel-heading"> Special Offers Settings</div>
    <div class="panel-body">
      <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
      <!--<div class="row form-group">
        <label class="col-md-2 control-label text-left">Icon Class</label>
        <div class="col-md-4">
          <input type="text" name="page_icon" class="form-control" value="<?php echo $settings[0]->front_icon;?>" >
        </div>
      </div>-->
      <div class="row form-group">
        <label class="col-md-2 control-label text-left">Target</label>
        <div class="col-md-4">
          <select  class="form-control" name="target">
            <option  value="_self" <?php if($settings[0]->linktarget == "_self"){ echo "selected";} ?>   >Self</option>
            <option  value="_blank"  <?php if($settings[0]->linktarget == "_blank"){ echo "selected";} ?>  >Blank</option>
          </select>
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-2 control-label text-left">Page Title</label>
        <div class="col-md-4">
          <input type="text" name="headertitle" class="form-control" placeholder="title" value="<?php echo $settings[0]->header_title;?>" />
        </div>
      </div>
      <div class="row form-group">
        <label class="col-md-2 control-label text-left">Listings Page</label>
        <div class="col-md-4">
          <input class="form-control" type="text" placeholder="" name="listings"  value="<?php echo $settings[0]->front_listings;?>">
        </div>
      </div>
      <!--<div class="row form-group">
        <label class="col-md-2 control-label text-left">Homepage</label>
        <div class="col-md-4">
          <input class="form-control" type="text" placeholder="" name="home"  value="<?php echo $settings[0]->front_homepage;?>">
        </div>
      </div>-->
    </div>
    <div class="panel-footer">
      <input type="hidden" name="updatesettings" value="1" />
      <input type="hidden" name="updatefor" value="offers" />
      <button class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>