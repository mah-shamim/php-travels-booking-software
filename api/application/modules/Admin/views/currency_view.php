<?php
require_once  FCPATH.'/config/currency.php';
?>
<div class="panel panel-default">
<div class="panel-heading"><?php echo $header_title; ?></div>

<div class="panel-body form-horizontal">
<div class="row form-group">
<label class="col-md-2 control-label text-left">Currency API Keys</label>
<div class="col-md-4">
<input type="text" name="key" class="form-control" value="<?php echo $currency_key; ?>" readonly/>
</div>
</div>

<div class="row form-group">
<label class="col-md-2 control-label text-left">Cronjob URL</label>
<div class="col-md-4">
<input type="text" id="link" name="link" class="form-control" value="<?php echo base_url("admin/settings/cron");?>" readonly/>
</div>

<div class="col-md-4">
<button class="btn btn-primary" onclick="myFunction()" type="button"> Copy </button>
<a href="<?php echo base_url("admin/settings/cron");?>" class="btn btn-success">Refresh</a>

</div>
</div>
</div>

<hr>

<div class="panel-body">
<?php echo $content; ?>
</div>
</div>

<script>
function myFunction() {
var copyText = document.getElementById("link");
copyText.select();
document.execCommand("copy");
}
</script>