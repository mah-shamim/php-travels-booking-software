<!-- PHPtravels Reviews Starting -->
<script>
  $(function(){
  slideout();
  $('.del_selected').click(function(){
  var reviewlist = new Array();
  $("input:checked").each(function() {
  reviewlist.push($(this).val());
  });
  var count_checked = $("[name='review_ids[]']:checked").length;
  if(count_checked == 0) {
  $.alert.open('info', 'Please select a review to Delete.');
  return false;
  }
  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url().$this->uri->segment(1);?>/reviews/delete_multiple_reviews", { reviewlist: reviewlist }, function(theResponse){
  location.reload();
  }); }); });
  $('.disable_selected').click(function(){
  var reviewlist = new Array();
  $("input:checked").each(function() {
  reviewlist.push($(this).val());
  });
  var count_checked = $("[name='review_ids[]']:checked").length;
  if(count_checked == 0) {
  $.alert.open('info', 'Please select a review to Disable.');
  return false;
  }
  $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url().$this->uri->segment(1);?>/reviews/disable_review", { reviewlist: reviewlist }, function(theResponse){
  location.reload();
  }); }); });
  $('.enable_selected').click(function(){
  var reviewlist = new Array();
  $("input:checked").each(function() {
  reviewlist.push($(this).val());
  });
  var count_checked = $("[name='review_ids[]']:checked").length;
  if(count_checked == 0) {
  $.alert.open('info', 'Please select a review to Enable.');
  return false;
  }
  $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url().$this->uri->segment(1);?>/reviews/enable_review", { reviewlist: reviewlist }, function(theResponse){
  location.reload();
  }); }); });
  $(".del_single").click(function(){
  var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
  if (answer == 'yes')
  $.post("<?php echo base_url().$this->uri->segment(1);?>/reviews/delete_review", { reviewid: id }, function(theResponse){
  location.reload();
  }); }); }); });
</script>
<div class="container">
 
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary table-bg">

  <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-smile-o"></i> Reviews Management</span>
      <div class="pull-right">
        <a href="<?php echo base_url().$this->uri->segment(1);?>/reviews/add/"> <?php echo PT_ADD; ?></a>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="panel-body">
      <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th style="width:50px;"><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
            <th><span class="fa fa-tags" data-toggle="tooltip" data-placement="top" title="Name of The Person Who Wrote This Review "></span> Name </th>
            <th><span class="fa fa-building-o" data-toggle="tooltip" data-placement="top" title="Review For"></span> For </th>
            <th style="width:120px;"><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Added On Date"></i> Date</th>
            <th><i class="fa fa-sort-numeric-asc" data-toggle="tooltip" data-placement="top" title="Overall Reviews Rating"></i> Vote</th>
            <th style="width:50px;"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($allreviews)){ $count = 0; foreach($allreviews as $review){ $count++; ?>
          <tr>
            <td><?php echo $count;?></td>
            <td><input type="checkbox" name="review_ids[]" value="<?php echo $review->review_id;?>" class="selectedId"  /></td>
            <td><?php echo $review->review_name;?></td>
            <td><?php echo $review->review_module;?></td>
            <td class="center"><?php echo pt_show_date_php($review->review_date);?></td>
            <td class="center"><?php echo $review->review_overall;?></td>
            <td>
              <?php if($review->review_status == "1"){ ?>
              <span class="check"><i class="fa fa-check"  data-toggle="tooltip" data-placement="top" title="Enabled"></i></span>
              <?php }else{ ?>
              <span class="times"><i class="fa fa-times"  data-toggle="tooltip" data-placement="top" title="Disabled"></i></span>
              <?php } ?>
            </td>
            <td align="center">
              <a href="<?php echo base_url().$this->uri->segment(1); ?>/reviews/manage/<?php echo $review->review_id;?>"><span class="btn btn-xs btn-warning"><i class="fa fa-external-link"></i> edit</span></a>
              <span class="btn btn-xs btn-danger del_single" id="<?php echo $review->review_id;?>"><i class="fa fa-times"></i> delete</span>
          </tr>
          <?php } ?><?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- PHPtravels Reviews Ending -->