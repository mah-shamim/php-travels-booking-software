<style>
  input, button, select {
  display: block;
  height: 34px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857143;
  color: #555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 2px;
  }
  textarea {
  min-height: 100px;
  width: 100%;
  }
  .but{font-size:10px !important;margin-right: 0px !important;}
</style>
<script>
  $(function(){
  // change order - MoveUp
  $('.moveup').click(function(){
  var order = $(this).data('order');
  // $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
  //   if (answer == 'yes')

  $.post("<?php echo base_url();?>admin/ajaxcalls/updateGatewayOrder", { order: order, action: 'up' }, function(theResponse){
  location.reload(); });  });
  //end move up

  // change order - MoveDown
  $('.movedown').click(function(){
  var order = $(this).data('order');
  $.post("<?php echo base_url();?>admin/ajaxcalls/updateGatewayOrder", { order: order, action: 'down' }, function(theResponse){
  location.reload(); }); });
  //end movedown
  })
</script>
<?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <span class="panel-title pull-left"> Payment Gateways Management</span>
    <div class="clearfix"></div>
  </div>
  <div class="panel-body">
    <?php if(!empty($all_payments['disabledGateways'])){ ?>
    <form class="row" action="" method="POST">
      <div class="col-md-6">
        <select name="gateway" class="form-control">
          <?php foreach($all_payments['disabledGateways'] as $disabledGateways){ ?>
          <option value="<?php echo $disabledGateways['name']; ?>"><?php echo $disabledGateways['displayName']; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-3">
        <input type="hidden" name="action" value="activate">
        <input type="submit" class="btn btn-success" value="Activate">
      </div>
    </form>
    <?php } ?>
    <div class="clearfix"></div>
    <hr>
    <div class="panel-group" id="accordion">
      <?php $count = 0; $maxcount = count($all_payments['activeGateways']); foreach($all_payments['activeGateways'] as $activeGateways){ $count++;  ?>
      <form action="" method="POST">
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color:#e4e4e4;text-decoration:none">
          <h4 class="panel-title">
            <a style="background:transparent;text-decoration:none;color:#000 !important;overflow:hidden" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $activeGateways['name']; ?>">
              <?php echo $count."."; ?> <?php echo $activeGateways['displayName']; ?>
              <?php if($count == 1 && $count == $maxcount){  }else{ ?>
              <div style="margin-top:-5px" class="pull-right">
            <a  class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deactive<?php echo $activeGateways['name']; ?>">Deactivate</a> -
            <?php if($count == 1){ ?>
            <span class="btn btn-warning btn-xs movedown" data-order="<?php echo $activeGateways['order']; ?>"><i class="fa fa-arrow-down but"></i></span>
            <?php }elseif($count == $maxcount){ ?>
            <span class="btn btn-primary btn-xs moveup" data-order="<?php echo $activeGateways['order']; ?>"><i class="fa fa-arrow-up but"></i></span>
            <?php  }else{ ?>
            <span class="btn btn-primary btn-xs moveup" data-order="<?php echo $activeGateways['order']; ?>"><i class="fa fa-arrow-up but"></i></span>&nbsp;&nbsp;<span class="btn btn-warning btn-xs movedown" data-gateway="<?php echo $activeGateways['name']; ?>"><i class="fa fa-arrow-down but"></i></span>
            <?php } } ?>
            </div>
            </a>
          </h4>
        </div>
          <div id="<?php echo $activeGateways['name']; ?>" class="panel-collapse collapse">
            <!--<?php if($count == 1){ echo ' in'; } ?>-->
            <div class="panel-body">
              <table class="table table-bordered form-horizontal">
                <tbody>
                  <tr>
                    <td style="width: 250px;" class="">Display Name</td>
                    <td><input type="text" class="form-control" name="field[name]" value="<?php echo $activeGateways['gatewayValues'][$activeGateways['name']]['name']; ?>"></td>
                  </tr>
                  <?php foreach ($activeGateways['configData'] as $key => $val):
                    if ($val['Type'] != "System") {
                    $val['Name'] = "field[" . $key . "]";

                    if (isset($activeGateways['gatewayValues'][$activeGateways['name']][$key])) {
                    $val['Value'] = $activeGateways['gatewayValues'][$activeGateways['name']][$key];
                    }

                    echo "<tr><td>" . $val['FriendlyName'] . "</td><td>" . moduleConfigFieldOutput($val) . "</td></tr>";
                    continue;
                    }

                    ?>
                  <?php  endforeach; ?>
                  <td ></td>
                  <td>
                    <input type="hidden" name="gateway" value="<?php echo $activeGateways['name']; ?>">
                    <input type="hidden" name="order" value="<?php echo $activeGateways['order']; ?>">
                    <input type="hidden" name="field[visible]" value="<?php echo $activeGateways['gatewayValues'][$activeGateways['name']]['visible'];?>">
                    <input type="hidden" name="field[type]" value="<?php echo $activeGateways['gatewayValues'][$activeGateways['name']]['type'];?>">
                    <input type="hidden" name="action" value="save">
                    <input type="submit" class="btn btn-primary" value="Save Changes">
              </td>
             </tbody>
            </table>
           </div>
          </div>
         </div>
        </form>
      <?php } ?>
    </div>
  </div>
</div>
<!-- Modal -->
<?php foreach($all_payments['activeGateways'] as $modalActiveGateways){ ?>
<div class="modal fade" id="deactive<?php echo $modalActiveGateways['name']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Deactive <?php echo $modalActiveGateways['displayName']; ?></h4>
        </div>
        <div class="modal-body">
          <p>To deactivate this gateway module, you must first choose an alternative for any products &amp; invoices currently assigned to it to be switched to.</p>
          <div class="row">
            <div class="col-md-6">
              <select id="" name="gateway" class='form-control'>
                <?php foreach($all_payments['activeGateways'] as $selectActiveGateways){ if($selectActiveGateways['name'] != $modalActiveGateways['name']){ ?>
                <option value="<?php echo $selectActiveGateways['name']; ?>"><?php echo $selectActiveGateways['displayName']; ?></option>
                <?php } } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="oldgateway" value="<?php echo $modalActiveGateways['name']; ?>">
          <input type="hidden" name="action" value="deactivate">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>