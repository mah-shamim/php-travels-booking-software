<script>
  $(function(){
  slideout();
  // disable selected Module
  $('.disable_selected').click(function(){
  var modules = new Array();
  $("input:checked").each(function() {
  modules.push($(this).val());
  });
  var count_checked = $("[name='module_ids[]']:checked").length;
  if(count_checked == 0) {
  $.alert.open('info', 'Please select a Module to Disable.');
  return false;
  }
  $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url();?>admin/ajaxcalls/disable_multiple_modules", { modulelist: modules }, function(theResponse){
  location.reload();
  });});});
  // enable selected Module
  $('.enable_selected').click(function(){
  var modules = new Array();
  $("input:checked").each(function() {
  modules.push($(this).val());
  });
  var count_checked = $("[name='module_ids[]']:checked").length;
  if(count_checked == 0) {
  $.alert.open('info', 'Please select a Module to Enable.');
  return false;
  }
  $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url();?>admin/ajaxcalls/enable_multiple_modules", { modulelist: modules }, function(theResponse){
  location.reload();
  });});});
  // Enable single Module
  $(".enable_single").click(function(){
  var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url();?>admin/ajaxcalls/enable_single_module", { moduleid: id }, function(theResponse){
  location.reload();
  });});});
  // Disable single Module
  $(".disable_single").click(function(){
  var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url();?>admin/ajaxcalls/disable_single_module", { moduleid: id }, function(theResponse){
  location.reload();
  });});});
  // Enable Main Module
  $(".enable_main").click(function(){
  var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url();?>admin/ajaxcalls/enable_main_module", { modulename: id }, function(theResponse){
  location.reload();
  });});});
  // Disable Main Module
  $(".disable_main").click(function(){
  var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url();?>admin/ajaxcalls/disable_main_module", { modulename: id }, function(theResponse){
  location.reload();
  });});}); })
</script>

  <?php if ($this->session->flashdata('flashmsgs')) {echo NOTIFY;}?>
  <div class="panel panel-default table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"> Integrated Modules</span>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th style="width:55px;"><span class="fa fa-picture-o" data-toggle="tooltip" data-placement="top" title="Image"></span> </th>
            <th><span class="fa fa-laptop" data-toggle="tooltip" data-placement="top" title="Module Name"></span> Module Name</th>
            <th style="width:100px;"><span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Version"></span> Version</th>
            <th style="width:50px;"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach ($modules as $modlist) {
        		$isenabled = $this->ptmodules->is_main_module_enabled(strtolower($modlist['Name']));
        		?>
             <tr>
            <td class="zoom_img"><?php echo $modlist['Icon'];?>  </td>
            <td><?php echo $modlist['DisplayName'];?></td>
            <td><?php echo $modlist['Version'];?></td>
            <td>
           <?php if ($isenabled) {?><span class="check"><i class="fa fa-check"  data-toggle="tooltip" data-placement="top" title="Enabled"></i></span> <?php }else {?>
              <span class="times"><i class="fa fa-times"  data-toggle="tooltip" data-placement="top" title="Disabled"></i></span> <?php }?>
            </td>

            <td align="center">
              <?php if (!$isenabled) {?> <button class="btn btn-xs btn-enable enable_main" id="<?php echo strtolower($modlist['Name']);?>"><i class="fa fa-external-link"></i> enable</button>
              <?php }else {?><button class="btn btn-xs btn-info disable_main" id="<?php echo strtolower($modlist['Name']);?>" ><i class="fa fa-minus-square"></i> disable</button>
              <?php }?>
           <a href="<?php echo base_url();?>admin/<?php echo strtolower($modlist['Name']);?>/settings/"> <button class="btn btn-xs btn-warning"><i class="fa fa-table"></i> settings</button> </a>
          <?php if (strtolower($modlist['Name']) == "ean" && $isenabled) {?>
           <a href="<?php echo base_url();?>admin/<?php echo strtolower($modlist['Name']);?>/bookings/"> <button class="btn btn-xs btn-success"><i class="fa fa-gavel"></i> Bookings</button> </a>
          <?php }?>
          </tr>
       <?php }?>

        </tbody>
      </table>
    </div>
  </div>
