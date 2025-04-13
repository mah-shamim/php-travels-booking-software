<?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
<form action="" method="POST">
<div class="panel panel-default">
<div class="panel-heading">
<span class="panel-title pull-left">Travelpayouts Hotels Settings</span>
<div class="clearfix"></div>
</div>
<div class="panel-body">
<div class="spacer20px">
<div class="panel-body">
<div class="form-horizontal  col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="form-group">
<div class="form-group">
<table class="table table-striped">
<tbody>
<tr>
<td>Show Header/Footer</td>
<td>
<select  class="form-control" name="showHeaderFooter">
<option  value="yes" <?php if($settings->showHeaderFooter == "yes"){ echo "selected";} ?>   >Enable</option>
<option  value="no"  <?php if($settings->showHeaderFooter == "no"){ echo "selected";} ?>  >Disable</option>
</select>
</td>
<td>Enable/Disable to load header/footer </td>
</tr>
<tr>
<td>Whitelable URL</td>
<td>
<input type="text" class="form-control" name="WidgetURL" placeholder="Whitelable URL" value="<?php echo $settings->WidgetURL;?>" />
</td>
<td>Example : //hotels.<strong>domain</strong>.com/hotels?marker=<strong>264084</strong>&</td>
</tr>
<tr>
<td>Search Widget URL Mobile</td>
<td>
<input type="text" class="form-control" name="WidgetURLMobile" placeholder="Widget URL Mobile" value="<?php echo $settings->WidgetURLMobile;?>" />
</td>
<td>Input your Search Widget URL for Mobile Device </td>
</tr>
<!--<tr>
<td>Iframe URL</td>
<td>
<input type="text" class="form-control" name="iframeID" placeholder="Iframe ID" value="<?php echo $settings->iframeID;?>" />
</td>
<td>Input your Travelpayouts Iframe URL</td>
</tr>-->
<tr>
<td>Header title</td>
<td>
<input type="text" name="headerTitle" class="form-control" placeholder="title" value="<?php echo $settings->headerTitle;?>" />
</td>
<td>Write your listing page header title here</td>
</tr>
<tr>
<td>Enable/Disable</td>
<td>
<select  class="form-control" name="status">
<option  value="1" <?php if($settings->status == "1"){ echo "selected";} ?>   >Enable</option>
<option  value="0"  <?php if($settings->status == "0"){ echo "selected";} ?>  >Disable</option>
</select>
</td>
<td>Write your listing page header title here</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="panel-footer">
<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
</div>
</div>
</form>
