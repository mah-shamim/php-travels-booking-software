<script>
  $(function(){

        slideout();
                 var options = {   beforeSend: function()
    {

    },
    uploadProgress: function(event, position, total, percentComplete)
    {

    },
    success: function()
    {

    },
    complete: function(response)
    {

    if(response.responseText == "done"){
       $(".output").html('please Wait...');
      location.reload();
    }
    },
    target: '.output' };
    $('.my-form').submit(function() {
        $(this).ajaxSubmit(options);

        return false;
    });


    $('.del_selected').click(function(){
      var socials = new Array();
      $("input:checked").each(function() {
           socials.push($(this).val());
        });
      var count_checked = $("[name='social_ids[]']:checked").length;
      if(count_checked == 0) {
         $.alert.open('info', 'Please select a Social Network to Delete.');
        return false;
         }


  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')


  $.post("<?php echo base_url();?>admin/ajaxcalls/delete_multiple_socials", { sociallist: socials }, function(theResponse){

                    location.reload();


  	});


  });

    });


        $('.disable_selected').click(function(){
      var socials = new Array();
      $("input:checked").each(function() {
           socials.push($(this).val());
        });
      var count_checked = $("[name='social_ids[]']:checked").length;
      if(count_checked == 0) {
          $.alert.open('info', 'Please select a Social Network to Disable.');
        return false;
         }

             $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
    if (answer == 'yes')


   $.post("<?php echo base_url();?>admin/ajaxcalls/disable_multiple_socials", { sociallist: socials }, function(theResponse){

                    location.reload();


  	});


  });

    });


            $('.enable_selected').click(function(){
      var socials = new Array();
      $("input:checked").each(function() {
           socials.push($(this).val());
        });
      var count_checked = $("[name='social_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Social Network to Enable.');
       return false;
         }


    $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
    if (answer == 'yes')


     $.post("<?php echo base_url();?>admin/ajaxcalls/enable_multiple_socials", { sociallist: socials }, function(theResponse){

                    location.reload();


  	});


  });


    });



    $(".del_single").click(function(){
   var id = $(this).attr('id');


           $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')


   $.post("<?php echo base_url();?>admin/ajaxcalls/delete_single_social", { socialid: id }, function(theResponse){

                    location.reload();


  	});


  });


    });


    $(".addsocial").click(function(){


    var conn_name = $("#conn_name").val();
    var conn_link = $("#conn_link").val();
    var image = $("#image").val();

    if(conn_name.length < 1){

    $(".alert-danger").html("Name field is required.").fadeIn('slow');
      return false;
    }else if(conn_link.length < 1){
        $(".alert-danger").html("Link Field is required.").fadeIn('slow');

       return false;
    }else if(image.length < 1){

      $(".alert-danger").html("Kindly Select an Image.").fadeIn('slow');

     return false;
    }else{

    return true;

    }
    });


        $(".updatesocial").click(function(){
           var abc = $(this).attr("name");


    var conn_name = $("#conn_name_"+abc).val();
    var conn_link = $("#conn_link_"+abc).val();


    if(conn_name.length < 1){

    $(".alert-danger").html("Name field is required.").fadeIn('slow');
      return false;
    }else if(conn_link.length < 1){
        $(".alert-danger").html("Link Field is required.").fadeIn('slow');

       return false;
    }else{

    return true;

    }
    });



  })



  function updateOrder(order,id,olderval){
   var maximumorder = <?php echo $get_socials['nums'];?>;
         if(order != olderval){

         if(order > maximumorder || order < 1){
            $.alert.open('info', 'Cannot assign order lesser than 1 or greater than '+maximumorder);
          $("#order_"+id).val(olderval);

            }else{
                $('#pt_reload_modal').modal('show');
    $.post("<?php echo base_url();?>admin/ajaxcalls/update_social_order", { order: order,id: id }, function(theResponse){


               $('#pt_reload_modal').modal('hide');

  	});

         }


         }


  }

</script>
<div class="<?php echo body;?>">
  <?php
    if(isset($successmsg)){ echo NOTIFY; }
    $validationerrors = validation_errors();
    if(isset($errormsg) || !empty($validationerrors)){
    ?>
  <div class="alert alert-danger">
    <i class="fa fa-times-circle"></i>
    <?php
      echo @$errormsg;
      echo $validationerrors; ?>
  </div>
  <?php
    }
    ?>
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-flickr"></i> Social Connections</span>
      <div class="pull-right">
        <a data-toggle="modal" href="#AddSocialLink"><?php echo PT_ADD; ?></a>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all" /></th>
            <th><span class="fa fa-picture-o" data-toggle="tooltip" data-placement="top" title="Image"></span> </th>
            <th><span class="fa fa-flickr" data-toggle="tooltip" data-placement="top" title="Name"></span> Name</th>
            <th><span class="fa fa-chain" data-toggle="tooltip" data-placement="top" title="Link"></span> Link</th>
            <th><span class="fa fa-tasks" data-toggle="tooltip" data-placement="top" title="Position"></span> Position</th>
            <th><i class="fa fa-tasks" data-toggle="tooltip" data-placement="top" title="Order By"></i> Order</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $count = 0;
            $max = $get_socials['nums'];
            foreach($get_socials['all'] as $social){
              $count++;
            ?>
          <tr>
            <td><?php echo $count;?></td>
            <td><input type="checkbox" name="social_ids[]" value="<?php echo $social->social_id;?>" class="selectedId" /></td>
            <td class="zoom_img"><img src="<?php echo PT_SOCIAL_IMAGES;?><?php echo $social->social_icon;?>" title="<?php echo $social->social_name;?>" />
            </td>
            <td><?php echo $social->social_name;?></td>
            <td><?php echo $social->social_link;?></td>
            <td><?php echo $social->social_position;?></td>
            <td>
              <input class="form-control" type="number" id="order_<?php echo $social->social_id;?>" value="<?php echo $social->social_order;?>" min="1" max="<?php echo $max;?>" onblur="updateOrder($(this).val(),<?php echo $social->social_id;?>,<?php echo $social->social_order;?>);" />
            </td>
            <td>
              <?php
                if($social->social_status == 'No'){
                ?>
              <a href=""><span class="times"><i class="fa fa-times"  data-toggle="tooltip" data-placement="top" title="Disable"></i></span></a>
              <?php
                }else{
                ?>
              <a href=""><span class="check"><i class="fa fa-check"  data-toggle="tooltip" data-placement="top" title="Enabled"></i></span></a>
              <?php
                }
                ?>
            </td>
            <td align="center">
              <form method="post" action="#">
                <input type="hidden" name="socialid" value="<?php echo $social->social_id;?>" />
                <button data-toggle="modal" href="#social_<?php echo $social->social_id;?>" class="btn btn-xs btn-warning"><i class="fa fa-external-link"></i> edit</button>
                <span class="btn btn-xs btn-danger del_single" id="<?php echo $social->social_id;?>"><i class="fa fa-times"></i> delete</span>
              </form>
            </td>
          </tr>
          <?php
            }
             ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="AddSocialLink" role="dialog" aria-labelledby="AddSocialLinkLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="fa fa-flickr"></span> Add Social Connection </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal my-form" action=""  method="POST" enctype="multipart/form-data" >
          <fieldset>
            <div class="output"> </div>
            <div class="alert alert-danger" style="display:none;">
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Position</label>
              <div class="col-md-4">
                <select data-placeholder="Select" name="position" class="form-control" id="position">
                  <option value="header">Header</option>
                  <option value="footer">Footer</option>
                  <option value="both">Both</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-4">
                <select data-placeholder="Enable" class="form-control" name="conn_status" id="connstatus">
                  <option value="1">Enable</option>
                  <option value="0">Disable</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Name</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Connection Name" name="conn_name" id="conn_name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Link</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Valid Link" name="link" id="conn_link">
              </div>
            </div>
            <hr class="soften">
            <div class="form-group">
              <label class="col-md-3 control-label">Picture</label>
              <div class="col-md-8">
                <input type="file" name="photo" class="btn btn-default" id="image" >
                <p class="help-block">
                  <img src="<?php echo base_url();?>images/upload/social/default.jpg" class="preview_img" class="img-rounded" width="80" height="80" alt="" />
                </p>
              </div>
            </div>
          </fieldset>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="addconn" value="1" />
                <button class="btn btn-primary addsocial" type="submit">
                <i class="fa fa-save"></i>
                Add Connection
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.modal-content -->
<!---Modal for edit social connection ---->
<?php
  foreach($get_socials['all'] as $social){

     ?>
<div class="modal fade" id="social_<?php echo $social->social_id;?>" role="dialog" aria-labelledby="City" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="fa fa-flickr"></span> Edit Social Connection </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal my-form" action=""  method="POST" enctype="multipart/form-data" >
          <fieldset>
            <div class="output"> </div>
            <div class="alert alert-danger" style="display:none;">
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Position</label>
              <div class="col-md-4">
                <select data-placeholder="Select" name="position" class="form-control" id="position">
                  <option value="header" <?php if($social->social_position == 'header'){echo "selected";}?> >Header</option>
                  <option value="footer" <?php if($social->social_position == 'footer'){echo "selected";}?>>Footer</option>
                  <option value="both" <?php if($social->social_position == 'both'){echo "selected";}?>>Both</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-4">
                <select data-placeholder="Enable" class="form-control" name="conn_status" id="connstatus">
                  <option value="Yes" <?php if($social->social_status == 'Yes'){echo "selected";}?> >Enable</option>
                  <option value="No" <?php if($social->social_status == 'No'){echo "selected";}?> >Disable</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Name</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Connection Name" name="conn_name" id="conn_name_<?php echo $social->social_id;?>" value="<?php echo $social->social_name;?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Link</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Valid Link" name="link" id="conn_link_<?php echo $social->social_id;?>" value="<?php echo $social->social_link;?>" >
              </div>
            </div>
            <hr class="soften">
            <div class="form-group">
              <label class="col-md-3 control-label">Picture</label>
              <div class="col-md-8">
                <input type="file" name="photo" class="btn btn-default" id="image" >
                <p class="help-block">
                  <img src="<?php echo PT_SOCIAL_IMAGES;?><?php echo $social->social_icon;?>" class="preview_img" class="img-rounded" width="80" height="80" alt="" />
                </p>
              </div>
            </div>
          </fieldset>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="updateconn" value="1" />
                <input type="hidden" name="oldphoto" value="<?php echo $social->social_icon;?>" />
                <input type="hidden" name="socialid" value="<?php echo $social->social_id;?>" />
                <button class="btn btn-primary updatesocial" name="<?php echo $social->social_id;?>" type="submit">
                <i class="fa fa-save"></i>
                Update Connection
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
  }

  ?>
<!--- End Modal for social connection---->