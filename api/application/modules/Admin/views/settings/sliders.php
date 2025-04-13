<script type="text/javascript">
  $(function(){
           slideout();

      $('.minislider').hide();
      $('.minires').hide();

      $(".btn-warning").click(function(){
      var id= $(this).attr('name');
      var slidepos = $("#slide_position_"+id).val();
      if(slidepos == "mini"){
        $('.mainres').hide();
      $('.minislider').show();
      $('.minires').show();

   }else{
       $('.mainres').show();
      $('.minislider').hide();
      $('.minires').hide();
   }

      });

   $(".btn-new-slide").click(function(){

       $('.mainres').show();
      $('.minislider').hide();
      $('.minires').hide();

      });


    // Adding new Slide check
    $(".addnewslide").click(function(){

    var image = $("#image").val();

     if(image.length < 1){

      $(".alert-danger").html("Kindly Select an Image.").fadeIn('slow');

     return false;
    }else{

    return true;

    }
    });


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
      var slides = new Array();
      $("input:checked").each(function() {
           slides.push($(this).val());
        });
      var count_checked = $("[name='slide_ids[]']:checked").length;
      if(count_checked == 0) {
       $.alert.open('info', 'Please select a Slide to delete.');
        return false;
         }

    $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
        if (answer == 'yes')

    $.post("<?php echo base_url();?>admin/ajaxcalls/delete_multiple_slides", { slidelist: slides }, function(theResponse){

                    location.reload();


  	});


    });


    });


    // disable selected Slide
        $('.disable_selected').click(function(){
      var slides = new Array();
      $("input:checked").each(function() {
           slides.push($(this).val());
        });
      var count_checked = $("[name='slide_ids[]']:checked").length;
      if(count_checked == 0) {
       $.alert.open('info', 'Please select a Slide to Disable.');
        return false;
         }

   $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
       if (answer == 'yes')

   $.post("<?php echo base_url();?>admin/ajaxcalls/disable_multiple_slides", { slidelist: slides }, function(theResponse){

                    location.reload();


  	});


   });


    });

        // enable selected Slide
        $('.enable_selected').click(function(){
      var slides = new Array();
      $("input:checked").each(function() {
           slides.push($(this).val());
        });
      var count_checked = $("[name='slide_ids[]']:checked").length;
      if(count_checked == 0) {
        $.alert.open('info', 'Please select a Slide to Enable.');
        return false;
         }

    $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
        if (answer == 'yes')


        $.post("<?php echo base_url();?>admin/ajaxcalls/enable_multiple_slides", { slidelist: slides }, function(theResponse){

                    location.reload();


  	});


    });


    });

    //delete single Slide
    $(".del_single").click(function(){
   var id = $(this).attr('id');


  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')

  $.post("<?php echo base_url();?>admin/ajaxcalls/delete_single_slide", { slideid: id }, function(theResponse){

                    location.reload();


  	});


  });

    });

  });

  function showminioptions(option){
           if(option == 'mini'){

              $('.minislider').slideDown();
              $('.preview_img').attr("width","80");
                $('.mainres').hide();
                $('.minires').show();

           }else{

             $('.minislider').slideUp();
               $('.preview_img').attr("width","300");
                 $('.mainres').show();
                $('.minires').hide();

           }

  }


  function updateOrder(order,id,olderval){
   var maximumorder = <?php echo $all_slides['nums'];?>;
         if(order != olderval){

         if(order > maximumorder || order < 1){
            $.alert.open('info', 'Cannot assign order lesser than 1 or greater than '+maximumorder);
          $("#order_"+id).val(olderval);

            }else{
                $('#pt_reload_modal').modal('show');
      $.post("<?php echo base_url();?>admin/ajaxcalls/update_slide_order", { order: order,id: id }, function(theResponse){


               $('#pt_reload_modal').modal('hide');

  	});

         }


         }


  }


</script>
<div class="<?php echo body;?>">
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-picture-o"></i> Sliders Management</span>
      <div class="pull-right">
        <a data-toggle="modal" href="#AddSlide"><?php echo PT_ADD; ?></a>
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
            <th><span class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Titile"></span> Title</th>
            <th><span class="fa fa-tasks" data-toggle="tooltip" data-placement="top" title="Position"></span> Position</th>
            <th><i class="fa fa-tasks" data-toggle="tooltip" data-placement="top" title="Order By"></i> Order</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $counts = 0;
            $max = $all_slides['nums'];
            foreach($all_slides['all'] as  $als){

            $counts++;
            ?>
          <tr>
            <td><?php echo $counts;?></td>
            <td><input type="checkbox" name="slide_ids[]" value="<?php echo $als->slide_id;?>" class="selectedId" /></td>
            <td class="zoom_img"><img src="<?php echo PT_SLIDER_IMAGES_THUMBS.$als->slide_image;?>"  />
            </td>
            <td><?php echo $als->slide_title_text;?></td>
            <td><?php echo $als->slide_position;?> Slider</td>
            <td>
              <input class="form-control" type="number" id="order_<?php echo $als->slide_id;?>" value="<?php echo $als->slide_order;?>" min="1" max="<?php echo $max;?>" onblur="updateOrder($(this).val(),<?php echo $als->slide_id;?>,<?php echo $als->slide_order;?>);" />
            </td>
            <td>
              <?php if($als->slide_status == 'Yes'){
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
              <button data-toggle="modal" href="#editslide_<?php echo $als->slide_id;?>" class="btn btn-xs btn-warning" name="<?php echo $als->slide_id;?>"><i class="fa fa-external-link"></i> edit</button>
              <span class="btn btn-xs btn-danger del_single" id="<?php echo $als->slide_id;?>"><i class="fa fa-times"></i> delete</span>
              <a href="<?php echo base_url();?>admin/settings/sliders/translate/<?php echo $als->slide_id;?>"><span class="btn btn-xs btn-enable"><i class="fa fa-flag-checkered"></i> Translate</span></a>


          </tr>
          <?php
            }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="AddSlide" role="dialog" aria-labelledby="AddSlideLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-plus-sign"></span> Add Slide </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal my-form" action="" method="POST" enctype="multipart/form-data" >
          <fieldset>
            <div class="output">  </div>
            <div class="alert alert-danger" style="display:none;">
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-4">
                <select data-placeholder="Enable" class="form-control" name="slide_status">
                  <option value="1">Enable</option>
                  <option value="0">Disable</option>
                </select>
              </div>
            </div>
<!--            <div class="form-group">
              <label class="col-md-3 control-label">Position</label>
              <div class="col-md-4">
                <select data-placeholder="Select" class="form-control" name="slide_position" onchange="showminioptions(this.options[this.selectedIndex].value)">
                  <option value="main">Main Slider</option>
                  <option value="mini">Mini Slider</option>
                </select>
              </div>
            </div>-->
            <div class="form-group">
              <label class="col-md-3 control-label">Title</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Slide Title Text" name="slide_title">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label"> Description</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Slide Description Text" name="slide_desc">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Stars</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Optional Stars Slider" name="slide_optional">
              </div>
            </div>
            <div class="minislider">
              <div class="form-group">
                <label class="col-md-3 control-label"> Link</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Slide Link" name="slide_link">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Button Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Slide Button Text" name="slide_button">
                </div>
              </div>
            </div>
            <hr class="soften">
            <div class="form-group">
              <p class="mainres"><label class="col-md-8 control-label">Best Resolution 1024 x 500 </label> </p>
              <p class="minires"><label class="col-md-8 control-label">Best Resolution 400 x 400 </label> </p>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Picture</label>
              <div class="col-md-8">
                <input type="file" name="photo" class="btn btn-default" id="image" >
                <p class="help-block">
                  <img src="<?php echo PT_DEFAULT_IMAGE."slider.png";?>" class="img-rounded preview_img" width="300" height="100" alt="" />
                </p>
              </div>
            </div>
          </fieldset>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="addslide" value="1" />
                <button class="btn btn-primary addnewslide" type="submit">
                <i class="fa fa-save"></i>
                Add Slide
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
<!---Modal for Edit Slide---->
<?php
  foreach($all_slides['all'] as $allslides)
  {

  ?>
<div class="modal fade" id="editslide_<?php echo $allslides->slide_id;?>" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-plus-sign"></span> Update Slide </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal my-form" action="" method="POST" enctype="multipart/form-data" >
          <fieldset>
            <div class="output"> </div>
            <div class="alert alert-danger" style="display:none;">
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Status</label>
              <div class="col-md-4">
                <select data-placeholder="Enable" class="form-control" name="slide_status">
                  <option value="1" <?php if($allslides->slide_status == "Yes"){echo "selected";} ?>>Enable</option>
                  <option value="0" <?php if($allslides->slide_status == "No"){echo "selected";} ?>>Disable</option>
                </select>
              </div>
            </div>
         <!-- <div class="form-group">
              <label class="col-md-3 control-label">Position</label>
              <div class="col-md-4">
                <select data-placeholder="Select" class="form-control slideposition" id="slide_position_<?php echo $allslides->slide_id;?>" name="slide_position" onchange="showminioptions(this.options[this.selectedIndex].value)">
                  <option value="main" <?php if($allslides->slide_position == "main"){echo "selected";} ?>>Main Slider</option>
                  <option value="mini" <?php if($allslides->slide_position == "mini"){echo "selected";} ?>>Mini Slider</option>
                </select>
              </div>
            </div>-->
            <div class="form-group">
              <label class="col-md-3 control-label">Title</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Slide Title Text" name="slide_title" value="<?php echo $allslides->slide_title_text;?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label"> Description</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Slide Description Text" name="slide_desc" value="<?php echo $allslides->slide_desc_text;?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Stars</label>
              <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Optional Slider Stars" name="slide_optional" value="<?php echo $allslides->slide_optional_text;?>">
              </div>
            </div>
            <div class="minislider">
              <div class="form-group">
                <label class="col-md-3 control-label"> Link</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Slide Link" name="slide_link" value="<?php echo $allslides->slide_link;?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Button Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Slide Button Text" name="slide_button" value="<?php echo $allslides->slide_link_name;?>" >
                </div>
              </div>
            </div>
            <hr class="soften">
            <div class="form-group">
              <p class="mainres"><label class="col-md-8 control-label">Best Resolution 1024 x 500 </label> </p>
              <p class="minires"><label class="col-md-8 control-label">Best Resolution 400 x 400 </label> </p>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Picture</label>
              <div class="col-md-8">
                <input type="file" name="photo" class="btn btn-default" id="image" >
                <p class="help-block">
                  <?php if($allslides->slide_position == "mini"){
                    ?>
                  <img src="<?php echo PT_SLIDER_IMAGES_THUMBS.$allslides->slide_image;?>" class="img-rounded preview_img" width="80" height="80" alt="" />
                  <?php
                    }else{
                      ?>
                  <img src="<?php echo PT_SLIDER_IMAGES_THUMBS.$allslides->slide_image;?>" class="img-rounded preview_img" width="300" height="80" alt="" />
                  <?php
                    }
                    ?>
                </p>
              </div>
            </div>
          </fieldset>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" name="updateslide" value="1" />
                <input type="hidden" name="slideid" value="<?php echo $allslides->slide_id;?>" />
                <input type="hidden" name="oldphoto" value="<?php echo $allslides->slide_image;?>" />
                <button class="btn btn-primary" type="submit">
                <i class="fa fa-save"></i>
                Update Slide
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
<!--- End Modal for Edit Slide---->