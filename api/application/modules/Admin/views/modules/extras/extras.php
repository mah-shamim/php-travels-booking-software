<script>
  $(function(){

        slideout();


    $('.del_selected').click(function(){
      var supplist = new Array();
      $("input:checked").each(function() {
           supplist.push($(this).val());
        });
      var count_checked = $("[name='extras_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Supplement to Delete.');
        return false;
         }


    $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
        if (answer == 'yes')


  $.post("<?php echo base_url();?>admin/ajaxcalls/delete_multiple_supps", { supplist: supplist }, function(theResponse){

                    location.reload();


  	});


    });

    });


        $('.disable_selected').click(function(){
      var supps = new Array();
      $("input:checked").each(function() {
           supps.push($(this).val());
        });
      var count_checked = $("[name='extras_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Supplement to Disable.');
        return false;
         }



                    $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
    if (answer == 'yes')
   $.post("<?php echo base_url();?>admin/ajaxcalls/disable_multiple_supps", { supplist: supps }, function(theResponse){

                    location.reload();


  	});


  });


    });


            $('.enable_selected').click(function(){
      var supplist = new Array();
      $("input:checked").each(function() {
           supplist.push($(this).val());
        });
      var count_checked = $("[name='extras_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Supplement to Enable.');
        return false;
         }

     $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
    if (answer == 'yes')
   $.post("<?php echo base_url();?>admin/ajaxcalls/enable_multiple_supps", { supplist: supplist }, function(theResponse){

                    location.reload();


  	});


  });


  });



    $(".del_single").click(function(){
   var id = $(this).attr('id');

  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')


     $.post("<?php echo base_url();?>admin/ajaxcalls/delete_single_supp", { suppid: id }, function(theResponse){

                    location.reload();


  	});


  });

    });





        });






</script>
<div class="<?php echo body;?>">
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-star-half-o"></i> Extras Management</span>
      <div class="pull-right">
        <a data-toggle="modal" href="<?php echo base_url().$this->uri->segment(1);?>/extras/add/"><?php echo PT_ADD; ?></a>
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
            <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
            <th><span class="fa fa-tags" data-toggle="tooltip" data-placement="top" title="Supplement Name or Number"></span> Name </th>
            <th><span class="fa fa-building-o" data-toggle="tooltip" data-placement="top" title="Supplement For"></span> For </th>
            <th><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Added On Date"></i> Date</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($allsupps)){
            $count = 0;

            foreach($allsupps as $sup){
            $count++;
            //$item = $suppModel->get_for_details($sup->extras_for);

            ?>
          <tr>
            <td><?php echo $count;?></td>
            <td><input type="checkbox" name="extras_ids[]" value="<?php echo $sup->extras_id;?>" class="selectedId"  /></td>
            <td><a href="<?php echo base_url().$this->uri->segment(1); ?>/extras/manage/<?php echo $sup->extras_id;?>"><?php echo $sup->extras_title;?></a></td>
            <td><?php echo $sup->extras_module;?></td>
            <td class="center"><?php echo pt_show_date_php($sup->extras_added_on);?></td>
            <td>
              <?php
                if($sup->extras_status == "1"){
                ?>
              <span class="check"><i class="fa fa-check"  data-toggle="tooltip" data-placement="top" title="Enabled"></i></span>
              <?php
                }else{
                ?>
              <span class="times"><i class="fa fa-times"  data-toggle="tooltip" data-placement="top" title="Disabled"></i></span>
              <?php
                }
                ?>
            </td>
            <td align="center">
              <a href="<?php echo base_url().$this->uri->segment(1); ?>/extras/manage/<?php echo $sup->extras_id;?>"><span class="btn btn-xs btn-warning"><i class="fa fa-external-link"></i> edit</span></a>
               <a href="<?php echo base_url().$adminsegment; ?>/extras/translate/<?php echo $sup->extras_id;?>"><span class="btn btn-xs btn-enable"><i class="fa fa-flag-checkered"></i> Translate</span></a>
              <span class="btn btn-xs btn-danger del_single" id="<?php echo $sup->extras_id;?>"><i class="fa fa-times"></i> delete</span>
          </tr>
          <?php
            }

            ?><?php
            }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>