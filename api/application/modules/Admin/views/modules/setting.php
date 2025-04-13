  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>

  <form action="<?php echo base_url('admin/settings/modules/modules_save')?>" method="POST">
    <div class="panel panel-default">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-cog"></i> Settings Module Name</span>
      <div class="pull-right">
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
      <div class="panel-body">
      <div class="tab-content form-horizontal">
        <input name="modulename" type="hidden" value="<?=$modulename?>">
        <div class="row form-group">
        <label class="col-md-2 control-label text-left">B2C Markup</label>
        <div class="col-md-2">
        <input type="number" name="b2c_markup" class="form-control" placeholder="B2C Markup" value="<?php if(!empty($data[0]->b2c_markup)){ echo $data[0]->b2c_markup;} ?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <label class="col-md-1 control-label text-left">Deposit</label>
        <div class="col-md-2">
        <input type="number" name="desposit" class="form-control" placeholder="Desposit on Booking" value="<?php if(!empty($data[0]->desposit)){ echo $data[0]->desposit;} ?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">B2B Markup</label>
        <div class="col-md-2">
        <input type="number" name="b2b_markup" class="form-control" placeholder="B2B Markup" value="<?php if(!empty($data[0]->b2b_markup)){ echo $data[0]->b2b_markup;} ?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <label class="col-md-1 control-label text-left">Tax Vat</label>
        <div class="col-md-2">
        <input type="number" name="tax" class="form-control" placeholder="Tax Vat on Booking" value="<?php if(!empty($data[0]->tax)){ echo $data[0]->tax;} ?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">B2E Markup</label>
        <div class="col-md-2">
        <input type="number" name="b2e_markup" class="form-control" placeholder="B2E Markup" value="<?php if(!empty($data[0]->b2e_markup)){ echo $data[0]->b2e_markup;} ?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>

        <label class="col-md-1 control-label text-left">Service Fee</label>
        <div class="col-md-2">
        <input type="number" name="servicefee" class="form-control" placeholder="Booking Service Fee" value="<?php if(!empty($data[0]->servicefee)){ echo $data[0]->servicefee;} ?>">
        <small class="text-muted"> write numebr 1 - 100</small>
        </div>
        <label class="col-md-1 row control-label text-left">%</label>
        </div>
        <hr>
        <h4>API Credentials</h4>


        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 1</label>
        <div class="col-md-4">
        <input type="text" name="c1" class="form-control" placeholder="Credential 1" value="<?php if(!empty($data[0]->c1)){ echo $data[0]->c1;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 2</label>
        <div class="col-md-4">
        <input type="text" name="c2" class="form-control" placeholder="Credential 2" value="<?php if(!empty($data[0]->c2)){ echo $data[0]->c2;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 3</label>
        <div class="col-md-4">
        <input type="text" name="c3" class="form-control" placeholder="Credential 3" value="<?php if(!empty($data[0]->c3)){ echo $data[0]->c3;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 4</label>
        <div class="col-md-4">
        <input type="text" name="c4" class="form-control" placeholder="Credential 4" value="<?php if(!empty($data[0]->c4)){ echo $data[0]->c4;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 5</label>
        <div class="col-md-4">
        <input type="text" name="c5" class="form-control" placeholder="Credential 5" value="<?php if(!empty($data[0]->c5)){ echo $data[0]->c5;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 6</label>
        <div class="col-md-4">
        <input type="text" name="c6" class="form-control" placeholder="Credential 6" value="<?php if(!empty($data[0]->c6)){ echo $data[0]->c6;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 7</label>
        <div class="col-md-4">
        <input type="text" name="c7" class="form-control" placeholder="Credential 7" value="<?php if(!empty($data[0]->c7)){ echo $data[0]->c7;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 8</label>
        <div class="col-md-4">
        <input type="text" name="c8" class="form-control" placeholder="Credential 8" value="<?php if(!empty($data[0]->c8)){ echo $data[0]->c8;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 9</label>
        <div class="col-md-4">
        <input type="text" name="c9" class="form-control" placeholder="Credential 9" value="<?php if(!empty($data[0]->c9)){ echo $data[0]->c9;} ?>">
        </div>
        </div>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Credential 10</label>
        <div class="col-md-4">
        <input type="text" name="c10" class="form-control" placeholder="Credential 10" value="<?php if(!empty($data[0]->c10)){ echo $data[0]->c10;} ?>">
        </div>
        </div>

        <hr>

        <div class="row form-group">
        <label class="col-md-2 control-label text-left">Development Mode</label>
        <div class="col-md-4">
        <select class="form-control" name="mode">
        <option value="1" <?=($data[0]->developer_mode == '1') ? 'selected' : '' ?>> On </option>
        <option value="0" <?=($data[0]->developer_mode == '0') ? 'selected' : '' ?>> Off </option>
        </select>
        </div>
        </div>

      </div>
      </div>
    </div>
    <div class="panel-footer">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
    </div>
  </form>

<style>
.form-horizontal .control-label {
    padding-top: 14px;
}
</style>