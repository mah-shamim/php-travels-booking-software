<style>
.btn-open { margin-top: -50px !important; margin-right: 15px !important; }
.btn-copy { margin-top: -50px !important; margin-right: 105px !important; }
 textarea { padding-right: 200px !important; }

</style>

<div class="panel panel-default">
 <div class="panel-heading"><?php echo $header_title; ?></div>
<div class="panel-body">
<!--Tours Supplier--->

<!--Hotel Supplier--->
<?php if (isModuleActive('hotels')  && $edithotels == 1 || $deletehotels == 1 || $addhotels == 1) {?>
  <h4><strong>Hotels</strong> Module Widget URL</h4>
  <script>
      function copy() {
          var textBox = document.getElementById("hotel");
          textBox.select();
          document.execCommand("copy");
      }
  </script>
  <textarea name="value" class="form-control input-lg d-none d-md-block" id="hotel" cols="10" rows="2" readonly><iframe src='<?php echo base_url(); ?>supplier/widget/hotels?supplier_id=<?=$userloggedin?>' frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:109%;width:100%;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe></textarea>
  <button onclick="copy()" class="btn btn-primary pull-right btn-copy d-none d-md-block">Copy <i class="fa fa-code"></i></button>
  <a href="<?php echo base_url(); ?>supplier/widget/hotels?supplier_id=<?=$userloggedin?>" target="_blank" class="btn btn-success pull-right btn-open d-none d-md-block">Open <i class="fa fa-code"></i></a>

<?php } ?>

<br>

<?php if (isModuleActive('tours') && $edittours == 1 || $deletetours == 1 || $addpermission == 1) {?>
<h4><strong>Tours</strong> Module Widget URL</h4>
<script>
function copyToClipboard() {
var textBox = document.getElementById("value");
textBox.select();
document.execCommand("copy");
}
</script>
<textarea name="value" class="form-control input-lg d-none d-md-block" id="value" cols="10" rows="2" readonly><iframe src='<?php echo base_url(); ?>supplier/widget/tours?supplier_id=<?=$userloggedin?>' frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:109%;width:100%;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe></textarea>
<button onclick="copyToClipboard()" class="btn btn-primary pull-right btn-copy d-none d-md-block">Copy <i class="fa fa-code"></i></button>
<a href="<?php echo base_url(); ?>supplier/widget/tours?supplier_id=<?=$userloggedin?>" target="_blank" class="btn btn-success pull-right btn-open d-none d-md-block">Open <i class="fa fa-code"></i></a>

<?php } ?>

<br>

<!-- Car Supplier -->
<?php if (isModuleActive('cars') && $editcars == 1 || $deletecars == 1 || $addcars == 1) {?>
  <h4><strong>Cars</strong> Module Widget URL</h4>
  <script>
      function copycar() {
          var textBox = document.getElementById("car");
          textBox.select();
          document.execCommand("copy");
      }
  </script>
  <textarea name="value" class="form-control input-lg d-none d-md-block" id="car" cols="10" rows="2" readonly><iframe src='<?php echo base_url(); ?>supplier/widget/cars?supplier_id=<?=$userloggedin?>' frameborder="0" style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:109%;width:100%;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe></textarea>
  <button onclick="copycar()" class="btn btn-primary pull-right btn-copy d-none d-md-block">Copy <i class="fa fa-code"></i></button>
  <a href="<?php echo base_url(); ?>supplier/widget/cars?supplier_id=<?=$userloggedin?>" target="_blank" class="btn btn-success pull-right btn-open d-none d-md-block">Open <i class="fa fa-code"></i></a>

<?php } ?>
 </div>
</div>