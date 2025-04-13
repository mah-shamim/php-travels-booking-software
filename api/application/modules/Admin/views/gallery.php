<script type="text/javascript">
$(function(){
  $(".deleteImg").click(function(){

                var imgid =  $(this).attr('id');
                var imgname =  $(this).attr('name');
                var itemid =  $("#itemid").val();

    $.alert.open('confirm', 'Are you sure you want to delete', function(answer) {
    if (answer == 'yes'){
  $.post("<?php echo $delimgUrl;?>", { imgid: imgid, itemid: itemid, imgname: imgname }, function(theResponse){
            $("#tr_"+imgid).fadeOut('slow');
           	});
            }
  });

  });

  // Approve - Reject image

  $(".btnimg").click(function(){

   var imgid = $(this).attr('id');
   var app_rej = '0';
   if($(this).hasClass('approve')){
      $(this).addClass('reject btn-warning');
      $(this).removeClass('approve btn-success');
      $(this).html('<i class="fa fa-times"></i>');
      app_rej = '0';

  }else if($(this).hasClass('reject')){
      $(this).removeClass('reject btn-warning');
      $(this).addClass('approve btn-success');
      $(this).html('<i class="fa fa-check"></i>');
      app_rej = '1';
  }

  $.post("<?php echo $appRejUrl; ?>", {imgid: imgid, apprej: app_rej }, function(theResponse){ });

  });

   // make thumbnail image

  $('.btnthumb').click(function(){
  var imgname = $(this).prop('id');
  var itemid = $("#itemid").val();
  var thumbid = $(this).prop("id")
  if($(this).hasClass('btn-primary')){

  }else{
      $('.btnthumb').removeClass('btn-primary');
      $('.btnthumb').addClass('btn-default');
      $('.btnthumb').html('No');
      $(this).removeClass('btn-default');
      $(this).addClass('btn-primary');
      $(this).html('Yes');
  }

  // $(this).toggleClass('isthumb').siblings().removeClass('isthumb');

     $.post("<?php echo $makeThumbUrl;?>", { imgname: imgname,itemid: itemid  }, function(theResponse){ 	});

        })

  // End make thumbnail image

/*$('#select_all').click(function () {

      $('.selectedId').prop('checked', this.checked);

  });*/

   // delete multiple images
    $('.delMultiple').click(function(){

      var imgids = new Array();

      $("input:checked").each(function() {
            var chks = {itemid: $("#itemid").val(), imgname: $(this).data('imgname'), imgid: $(this).val()};
            if(chks.imgname != ""){
                 imgids.push(chks);
            }

        });

      var count_checked = $("[name='img_ids[]']:checked").length;

         if(count_checked == 0) {
          $.alert.open('info', 'Please select an Image to delete.');
              return false;

         }

         $.alert.open('confirm', 'Are you sure you want to delete', function(answer) {

           if (answer == 'yes'){

      $.post("<?php echo $delMultipleImgsUrl; ?>", { imgids: imgids }, function(theResponse){
                       location.reload();
              });            }  });

                   });
     // end delete multiple images

//Drop zone functions
Dropzone.options.dropzone = {
    init: function () {
        // Set up any event handlers
        this.on('complete', function () {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                location.reload();
            }
        });
    }
};

})
</script>


 <div class="panel panel-default">
  <div class="panel-heading">Gallery Management</div>

<div class="panel-body">
<div class="collapse" id="UploadPhotos">
  <div class="well well-sm">
     <div class="modal-body">
                <div action="<?php echo $uploadUrl.$itemid;?>" id="dropzone" class="dropzone"> </div>
            </div>
  </div>
</div>

                    <!-- Button trigger modal -->

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="col-md-2">
                                 <a class="btn btn-success" data-toggle="collapse" href="#UploadPhotos" aria-expanded="false" aria-controls="UploadPhotos">
                                  <i class="fa fa-photo"></i> Add Photos
                                 </a>
                                 <div class="clearfix"></div>

                                </th>
                                <th class="col-md-2" style="padding-left:35px" ><input class="pointer all" data-imgname="" type="checkbox" data-toggle="tooltip" data-placement="top"  title="Select All" id="select_all" />  <span data-toggle="tooltip" data-placement="top" title="Delete Selected Images from Table only" class="btn btn-danger btn-xs col-md-9 pull-right delMultiple"><i class="fa fa-trash-o"></i> Delete</span></th>
                                <th class="col-md-2 text-center">Order</th>
                                <?php if(!empty($showactive)){ ?>
                                <th class="col-md-2 text-center">Active</th>
                                <?php } ?>
                                <th class="col-md-2 text-center">Thumbnail</th>
                                <th class="col-md-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           <input type="hidden" id="itemid" value="<?php echo $itemid;?>" />
                           <?php  if(!empty($images[0]->itemid)){  foreach($images as $img): ?>
                           <tr  id="tr_<?php echo $img->id;?>">

                                <td>

                               <a href="<?php echo $thumbsDir.$img->image;?>" rel=""> <img src="<?php echo $thumbsDir.$img->image;?>" href="<?php echo $fullImgDir.$img->image;?>" class="img-responsive colorbox"></a>

                                </td>
                                <td style="padding:35px"><input type="checkbox" data-imgname="<?php echo  $img->image;?>" name="img_ids[]" value="<?php echo  $img->id;?>" class="checkboxcls"  /></td>

                                <td style="padding:35px">
                                    <input class="form-control" type="number" id="order_<?php echo $img->id;?>" onblur="updateOrder($(this).val(),<?php echo $img->id;?>,<?php echo $img->imgorder;?>)" value="<?php echo $img->imgorder;?>" data-url="<?php echo $imgorderUrl;?>" >
                                </td>
                                <?php if(!empty($showactive)){ ?>
                                <td style="padding:35px">
                                  <?php if($img->approved == '1'): ?>
                                    <button class="btn btn-success btn-block btn-md btnimg approve" id="<?php echo $img->id;?>"><i class="fa fa-check"></i></button>
                                   <?php else: ?>
                                    <button class="btn btn-warning btn-block btn-md btnimg reject"  id="<?php echo $img->id;?>"><i class="fa fa-times"></i></button>
                                   <?php endif; ?>
                                </td>
                                <?php } ?>
                                <td style="padding:35px">
                                 <?php if($img->thumbnail == $img->image): ?>
                                    <button class="btn btn-primary btn-block btn-md btnthumb" id="<?php echo $img->image;?>"> Yes </button>
                                   <?php else: ?>
                                    <button class="btn btn-default btn-block btn-md btnthumb" id="<?php echo $img->image;?>"> No </button>
                                   <?php endif; ?>
                                </td>
                                <td style="padding:35px">
                                    <button class="btn btn-danger btn-block btn-md deleteImg" id="<?php echo $img->id;?>" name="<?php echo $img->image;?>" > Delete </button>
                                </td>
                            </tr>

                         <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php } ?>
                    </div>
                    </div>


              <link rel="stylesheet" href="<?php echo base_url(); ?>assets/include/colorbox/colorbox.css" />
              <script src="<?php echo base_url(); ?>assets/include/colorbox/jquery.colorbox.js"></script>

    <!-- ColorBox ================================================== -->
  <script>
    $(document).ready(function(){
    	$(".colorbox").colorbox({rel:'colorbox'});
    	$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
         });
  </script>
  <!-- ColorBox ================================================== -->

