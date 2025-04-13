<script type="text/javascript">
  $(function(){
         var moduletype = $("#moduletype").val();
         $("#pendingtype").change(function(){
           var id = $(this).val();
           if(id == "reviews"){
            $("#prooms").hide();
            }else{
               $("#prooms").show();
            }

         })
        slideout();


        //Accept multiple reviews
        $('.accept_selected_reviews').click(function(){
        var reviewlist = new Array();
        $("input:checked").each(function() {
             reviewlist.push($(this).val());
          });
        var count_checked = $("[name='reviews_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select a Review to Accept.');
          return false;}

  $.alert.open('confirm', 'Are you sure you want to Accept these Reviews', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/pending/accept_multiple_review", { reviewlist: reviewlist}, function(theResponse){
     location.reload();
     });});});
    //Reject multiple reviews
        $('.rej_selected_reviews').click(function(){
        var reviewlist = new Array();
        $("input:checked").each(function() {
             reviewlist.push($(this).val());
          });
        var count_checked = $("[name='reviews_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select a Review to Reject.');
          return false;}

  $.alert.open('confirm', 'Are you sure you want to Reject these Reviews', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/pending/reject_multiple_review", { reviewlist: reviewlist}, function(theResponse){
     location.reload();
     });});});
      // reject single review
       $(".reject_review_single").on('click',function(){
         var id = $(this).prop('id');

       $.alert.open('confirm', 'Are you sure you want to reject this Review', function(answer) {
      if (answer == 'yes'){

     $.post("<?php echo base_url();?>admin/pending/reject_single_review", { id: id}, function(theResponse){
                  $("#row_"+id).fadeOut("slow");
                  var pendings = $(".totalpendings").text();
                   var newpending = parseFloat(pendings) - 1;

             $(".totalpendings").html(newpending);
     	});
                  }

                  });

       });
       // accept single review
       $(".accept_review_single").on('click',function(){
         var id = $(this).prop('id');

       $.alert.open('confirm', 'Are you sure you want to accept this Review', function(answer) {
      if (answer == 'yes'){

     $.post("<?php echo base_url();?>admin/pending/accept_single_review", { id: id}, function(theResponse){
                  $("#row_"+id).fadeOut("slow");
                  var pendings = $(".totalpendings").text();
                  var newpending = parseFloat(pendings) - 1;
                       if(moduletype == 'hotels'){
                  var hrpendings = $(".totalhotelreviews").text();
                  var newhrpending = parseFloat(hrpendings) - 1;
                   $(".totalhotelreviews").html(newhrpending);
                  }else if(moduletype == 'tours'){
                  var trpendings = $(".totaltourreviews").text();
                  var newtrpending = parseFloat(trpendings) - 1;
                   $(".totaltourreviews").html(newtrpending);
                  }
                $(".totalpendings").html(newpending);
     	});}});});


        //Reject multiple Images
        $('.rej_selected_images').click(function(){

        var imglist = new Array();
        $("input:checked").each(function() {
             imglist.push($(this).val());
          });
        var count_checked = $("[name='images_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select Images to Reject.');
          return false;}

  $.alert.open('confirm', 'Are you sure you want to Reject these Images', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/pending/reject_multiple_images", { imglist: imglist, moduletype: moduletype}, function(theResponse){
     location.reload();
     });});});

             //Accept multiple Images
        $('.accept_selected_images').click(function(){
        var imglist = new Array();
        $("input:checked").each(function() {
             imglist.push($(this).val());
          });
        var count_checked = $("[name='images_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select Images to Approve.');
          return false;}

  $.alert.open('confirm', 'Are you sure you want to Approve these Images', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/pending/accept_multiple_images", { imglist: imglist, moduletype: moduletype}, function(theResponse){
     location.reload();
     });});});




       // accept single image
       $(".accept_image_single").on('click',function(){
         var id = $(this).prop('id');

       $.alert.open('confirm', 'Are you sure you want to accept this Image', function(answer) {
      if (answer == 'yes'){

     $.post("<?php echo base_url();?>admin/pending/accept_single_image", { id: id, moduletype: moduletype}, function(theResponse){
                  $("#row_"+id).fadeOut("slow");
                  var pendings = $(".totalpendings").text();
                  var newpending = parseFloat(pendings) - 1;
                  if(moduletype == 'hotels'){
                  var hpendings = $(".totalhotelimages").text();
                  var newhpending = parseFloat(hpendings) - 1;
                   $(".totalhotelimages").html(newhpending);
                  }else if(moduletype == 'rooms'){
                  var roompendings = $(".totalroomimages").text();
                  var newroompending = parseFloat(roompendings) - 1;
                   $(".totalroomimages").html(newroompending);
                  }else if(moduletype == 'tours'){
                  var tourpendings = $(".totaltourimages").text();
                  var newtourpending = parseFloat(tourpendings) - 1;
                   $(".totaltourimages").html(newtourpending);
                  }

                $(".totalpendings").html(newpending);

     	});
                  }});

       });
          // reject single image
       $(".reject_image_single").on('click',function(){
         var id = $(this).prop('id');
         var imgname = $(this).data('imagename');
         var imgtype = $(this).data('imagetype');

       $.alert.open('confirm', 'Are you sure you want to reject this Image', function(answer) {
      if (answer == 'yes'){
       $.post("<?php echo base_url();?>admin/pending/reject_single_image", { id: id, imgtype: imgtype, imgname: imgname, moduletype: moduletype}, function(theResponse){
                  $("#row_"+id).fadeOut("slow");
                  var pendings = $(".totalpendings").text();
                  var newpending = parseFloat(pendings) - 1;
                 if(moduletype == 'hotels'){
                  var hpendings = $(".totalhotelimages").text();
                  var newhpending = parseFloat(hpendings) - 1;
                   $(".totalhotelimages").html(newhpending);
                  }else if(moduletype == 'rooms'){
                  var roompendings = $(".totalroomimages").text();
                  var newroompending = parseFloat(roompendings) - 1;
                   $(".totalroomimages").html(newroompending);
                  }else if(moduletype == 'tours'){
                  var tourpendings = $(".totaltourimages").text();
                  var newtourpending = parseFloat(tourpendings) - 1;
                   $(".totaltourimages").html(newtourpending);
                  }
                $(".totalpendings").html(newpending);
     	});}});});


              
         // reject single Account
       $(".reject_accsingle").on('click',function(){
         var id = $(this).prop('id');

       $.alert.open('confirm', 'Are you sure you want to reject this account', function(answer) {
      if (answer == 'yes'){
       $.post("<?php echo base_url();?>admin/pending/reject_accountsingle", { id: id}, function(theResponse){
                  $("#row_"+id).fadeOut("slow");
                
     	});}});});

          // accept single Account
       $(".accept_accsingle").on('click',function(){
         var id = $(this).prop('id');

       $.alert.open('confirm', 'Are you sure you want to approve this account', function(answer) {
      if (answer == 'yes'){
       $.post("<?php echo base_url();?>admin/pending/accept_accountsingle", { id: id}, function(theResponse){
                  $("#row_"+id).fadeOut("slow");
              
     	});}});});

        //Reject multiple Accounts
        $('.rej_selected_accounts').click(function(){
        var acclist = new Array();
        $("input:checked").each(function() {
             acclist.push($(this).val());
          });
        var count_checked = $("[name='accounts_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select Account to Reject.');
          return false;}

  $.alert.open('confirm', 'Are you sure you want to Reject these Accounts', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/pending/reject_multiple_accounts", { acclist: acclist}, function(theResponse){
     location.reload();
     });});});

     //Accept multiple Accounts
        $('.accept_selected_accounts').click(function(){
        var acclist = new Array();
        $("input:checked").each(function() {
             acclist.push($(this).val());
          });
        var count_checked = $("[name='accounts_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select Account to Approve.');
          return false;}

  $.alert.open('confirm', 'Are you sure you want to Approve these Accounts', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/pending/accept_multiple_accounts", { acclist: acclist}, function(theResponse){
     location.reload();
     });});});
  //change review score
  $('.reviewscore').change(function(){
var sum = 0;
var avg = 0;
var id = $(this).attr("id");
$('.reviewscore_'+id+' :selected').each(function() {
sum += Number($(this).val());
});
avg = sum/5;
$("#avgall_"+id).html(avg);
$("#overall_"+id).val(avg);
});
//update review
$(".updatereview").click(function(){
        var id = $(this).prop('id');
        $.post("<?php echo base_url();?>admin/ajaxcalls/updatereview", $("#reviews-form").serialize(), function(theResponse){
        var response = $.parseJSON(theResponse);
        $(".resp_"+id).show();
        if(response.result){
          $(".resp_"+id).removeClass('alert-danger');
        }else{
          $(".resp_"+id).removeClass('alert-success');
        }
        $(".resp_"+id).addClass(response.divclass);
        $(".resp_"+id).html(response.msg);
    });
    })

       });

</script>
<div class="<?php echo body;?>">


  <input type="hidden" id="moduletype" value="<?php echo $module;?>" />
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-gavel"></i> Pending <?php echo ucfirst($type);?></span>
      <?php if(!empty($filter)){ ?>
      <div class="pull-right">
        <button class="btn btn-xs btn-success accept_selected_<?php echo $type;?>"><i class="fa fa-check-square-o"></i> Approve</button>
        <button class="btn btn-xs btn-danger rej_selected_<?php echo $type;?>"><i class="fa fa-times"></i> Delete</button>

      </div> <?php } ?>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
    <form action="" method="POST" style="padding:25px;">
    <label class="col-md-2 control-label">Select Pending Type</label>
    <div class="col-md-2">
    <select name="type" id="pendingtype" class="form-control">
            <option value="images" <?php if($type == "images"){ echo "selected"; } ?> >Images</option>
            <option value="reviews" <?php if($type == "reviews"){ echo "selected"; } ?> >Reviews</option>
            <option value="accounts" <?php if($type == "accounts"){ echo "selected"; } ?> >Accounts</option>
    </select>

    </div>

    <label class="col-md-3 control-label">Select Pending Sub Type</label>
    <div class="col-md-2">
    <select name="module" class="form-control">
     <?php if($chkinghotels){ ?>     <option value="hotels" <?php if($module == "hotels"){ echo "selected"; } ?> >Hotels</option>  <?php } ?>
    <?php if($chkinghotels){ ?>      <option value="rooms" id="prooms" <?php if($module == "rooms"){ echo "selected"; } ?> >Rooms</option>  <?php } ?>
   <?php if($chkingcars){ ?>       <option value="cars" <?php if($module == "cars"){ echo "selected"; } ?> >Cars</option>   <?php } ?>
   <?php if($chkingcruises){ ?>    <option value="cruises" <?php if($module == "cruises"){ echo "selected"; } ?> >Cruises</option> <?php } ?>
   <?php if($chkingtours){ ?>    <option value="tours" <?php if($module == "tours"){ echo "selected"; } ?> >Tours</option> <?php } ?>
   <option value="supplier" <?php if($module == "supplier"){ echo "selected"; } ?> >Supplier</option>
   <option value="customers" <?php if($module == "customers"){ echo "selected"; } ?> >Customers</option>

    </select>

    </div>
    <input type="hidden" name="filter" value="1" />
    <button type="submit" class="btn btn-primary">Show Pendings</button>

    </form>
    </div>
    <!-----------Pendings Summary Start-------------------->
     <?php if(empty($filter)){   if($chkinghotels){ ?>  <h3>Hotels</h3>
    Images: <?php echo $pendingitems['img_hotels']; ?>&nbsp;&nbsp;Room Images: <?php echo $pendingitems['img_rooms']; ?>&nbsp;&nbsp; Reviews: <?php echo $pendingitems['rev_hotels']; ?>
    <hr><?php } ?>
    <?php if($chkingtours){ ?><h3>Tours</h3>
    Images: <?php echo $pendingitems['img_tours']; ?>&nbsp;&nbsp; Reviews: <?php echo $pendingitems['rev_tours']; ?>
    <hr> <?php } ?>
    <?php if($chkingcars){ ?>  <h3>Cars</h3>
    Images: <?php echo $pendingitems['img_cars']; ?>&nbsp;&nbsp; Reviews: <?php echo $pendingitems['rev_cars']; ?>
    <hr> <?php } ?>
    <h3>Accounts</h3>
    Suppliers: <?php echo $pendingitems['suppliers']; ?>&nbsp;&nbsp; Customers: <?php echo $pendingitems['customers']; ?>
    <hr>
    <?php } ?>
    <!-----------Pendings Summary End-------------------->




      <?php
      if(!empty($filter)){
       if($type == 'reviews'){ ?>
      <!-- PHPTRAVELS reviews table starting -->
      <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
            <th><span class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Costumer Name"></span> Customer Name </th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($reviews as $review){
            $itemtitle = pt_get_module_item_info($review->review_module,$review->review_itemid);
          ?>
          <tr id="row_<?php echo $review->review_id;?>">
            <td><input type="checkbox" name="reviews_ids[]" value="<?php echo $review->review_id;?>" class="selectedId"  /></td>
            <td><?php echo $review->review_name;?> - <?php echo $itemtitle['title'];?></td>
            <td align="center">
              <span class="btn btn-xs btn-success accept_review_single" id="<?php echo $review->review_id;?>"><i class="fa fa-check"></i> Approve</span>
              <span class="btn btn-xs btn-danger reject_review_single" id="<?php echo $review->review_id;?>"><i class="fa fa-times"></i> Delete</span>
              <button class="btn btn-xs btn-primary" data-toggle="modal" href="#reviewMod<?php echo $review->review_id;?>"><i class="fa fa-search-plus"></i> Preview Review</button>
            </td>

          <!--PHPTravels Preview Review modal--->
          <div class="modal fade" id="reviewMod<?php echo $review->review_id;?>" tabindex="" role="dialog" aria-labelledby="ReviewModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><?php echo $review->review_name;?> - <?php echo $itemtitle['title'];?></h4>
                </div>
                <div class="modal-body">

                <p><i class="fa fa-external-link-square"></i> <b>Review URL</b> : <a href="<?php echo base_url().$itemtitle['slug'];?>" target="_blank"><?php echo base_url().$itemtitle['slug'];?></a></p>

                      <div class="">
                <div id="review_result" >

                  </div>

                  <div class="panel-body">
               <form class="form-horizontal" method="POST" id="reviews-form" action="" onsubmit="return false;">

                     <div class="alert resp_<?php echo $review->review_id;?>" style="display:none"></div>

              <div class="spacer20px">
                    <div class="col-md-4">
                    <div class="well well-sm">
                    <div class="well well-sm" style="background-color:#fff">

                    <h3 class="text-center"><strong class="text-primary"><?php echo trans('0389');?></strong>&nbsp;<span id="avgall_<?php echo $review->review_id;?>"><?php echo $review->review_overall;?></span> / 10</h3>
                     </div>
                     <hr>

                               <div class="form-group">
							   <label class="col-md-5 control-label"><?php echo trans('030');?></label>
                               <div class="col-md-5">
                               <select class="form-control reviewscore reviewscore_<?php echo $review->review_id;?>" id="<?php echo $review->review_id;?>" name="reviews_clean">
                               <?php for($i = 1; $i <= 10;$i++ ){ ?>
                               <option value="<?php echo $i;?>" <?php if($review->review_clean ==  $i){ echo "selected"; } ?> > <?php echo $i; ?> </option>
                               <?php } ?>
                               </select>
                               </div>
                               </div>

                               <div class="form-group">
							   <label class="col-md-5 control-label"><?php echo trans('031');?></label>
                               <div class="col-md-5">
                               <select class="form-control reviewscore reviewscore_<?php echo $review->review_id;?>" id="<?php echo $review->review_id;?>" name="reviews_comfort">
                               <?php for($i = 1; $i <= 10;$i++ ){ ?>
                               <option value="<?php echo $i;?>" <?php if($review->review_comfort ==  $i){ echo "selected"; } ?> > <?php echo $i; ?> </option>
                               <?php } ?>
                                 </select>
                               </div>
                               </div>

                               <div class="form-group">
							   <label class="col-md-5 control-label"><?php echo trans('032');?></label>
                               <div class="col-md-5">
                               <select class="form-control reviewscore reviewscore_<?php echo $review->review_id;?>" id="<?php echo $review->review_id;?>" name="reviews_location">
                                    <?php for($i = 1; $i <= 10;$i++ ){ ?>
                               <option value="<?php echo $i;?>" <?php if($review->review_location ==  $i){ echo "selected"; } ?> > <?php echo $i; ?> </option>
                               <?php } ?>
                                 </select>
                               </div>
                               </div>

                               <div class="form-group">
							   <label class="col-md-5 control-label"><?php echo trans('033');?></label>
                               <div class="col-md-5">
                               <select class="form-control reviewscore reviewscore_<?php echo $review->review_id;?>" id="<?php echo $review->review_id;?>" name="reviews_facilities">
                              <?php for($i = 1; $i <= 10;$i++ ){ ?>
                               <option value="<?php echo $i;?>" <?php if($review->review_facilities ==  $i){ echo "selected"; } ?> > <?php echo $i; ?> </option>
                               <?php } ?>
                                 </select>
                               </div>
                               </div>

                               <div class="form-group">
							   <label class="col-md-5 control-label"><?php echo trans('034');?></label>
                               <div class="col-md-5">
                               <select class="form-control reviewscore reviewscore_<?php echo $review->review_id;?>" id="<?php echo $review->review_id;?>" name="reviews_staff">
                               <?php for($i = 1; $i <= 10;$i++ ){ ?>
                               <option value="<?php echo $i;?>" <?php if($review->review_staff ==  $i){ echo "selected"; } ?> > <?php echo $i; ?> </option>
                               <?php } ?>
                                 </select>
                               </div>
                               </div>

                               <div class="clearfix"></div>
                              </div>
							  </div>

		<div class="col-md-8">
		<div class="col-md-6" style="padding-left: 0px;">

        <div class="panel panel-default">
           <div class="panel-heading"><strong>Name</strong></div>
           <input class="form-control" type="text" name="fullname" placeholder="Name" value="<?php echo $review->review_name;?>">
        </div>
        </div>

       <div class="col-md-6" style="padding-right: 0px;">

        <div class="panel panel-default">
           <div class="panel-heading"><strong>Email</strong></div>
                  <input class="form-control" type="text" name="email" placeholder="Email" value="<?php echo $review->review_email;?>">
        </div>

        </div>
           <div class="clearfix"></div>
                <div class="panel panel-default">
           <div class="panel-heading"><strong>Review</strong></div>
                <textarea class="form-control" name="reviews_comments" id="" cols="20" rows="7"><?php echo $review->review_comment;?></textarea>
        </div>
            </div>
            </div>
            <input type="hidden" name="overall" id="overall_<?php echo $review->review_id;?>" value="<?php echo $review->review_overall;?>" />
            <input type="hidden" name="reviewid" value="<?php echo $review->review_id;?>" />


                                </form>
            </div>

                      </div>

                </div>

              <div class="modal-footer">
                 <button type="button" class="btn btn-primary updatereview" id="<?php echo $review->review_id;?>" ><i class="fa fa-save"></i> Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              </div>
            </div>
          </div>
    <!--PHPTravels Preview Review modal--->
    <?php } ?>
            </tr>
            </tbody>
            </table>
    <!-- PHPTRAVELS reviews table ending -->
    <?php }elseif($type == 'images'){ ?>
    <!----Images pending Starting---->
    <!-- PHPTRAVELS Images table starting -->
    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
          <th><span class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Image Name"></span> Image Name </th>
          <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if($module == "hotels"){
          foreach($hotelimages as $img){
             ?>
        <tr id="row_<?php echo $img->himg_id;?>">
          <td><input type="checkbox" name="images_ids[]" value="<?php echo $img->himg_id;?>" class="selectedId"  /></td>
          <td> <a class="colorbox" href="<?php echo pt_image_paths_constants($img->himg_type,'hotels').$img->himg_image;?>"><?php echo $img->himg_image;?> </a> </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_image_single" id="<?php echo $img->himg_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_image_single" id="<?php echo $img->himg_id;?>" data-imagename="<?php echo $img->himg_image;?>" data-imagetype="<?php echo $img->himg_type;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } }elseif($module == "rooms"){
          foreach($roomimages as $img){ ?>
        <tr id="row_<?php echo $img->rimg_id;?>">
          <td><input type="checkbox" name="images_ids[]" value="<?php echo $img->rimg_id;?>" class="selectedId"  /></td>
          <td> <a class="colorbox" href="<?php echo pt_image_paths_constants($img->rimg_type,'rooms').$img->rimg_image;?>"><?php echo $img->rimg_image;?> </a> </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_image_single" id="<?php echo $img->rimg_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_image_single" id="<?php echo $img->rimg_id;?>" data-imagename="<?php echo $img->rimg_image;?>" data-imagetype="<?php echo $img->rimg_type;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } }elseif($module == "cruises"){
          foreach($cruiseimages as $img){ ?>
        <tr id="row_<?php echo $img->cimg_id;?>">
          <td><input type="checkbox" name="images_ids[]" value="<?php echo $img->cimg_id;?>" class="selectedId"  /></td>
          <td> <a class="colorbox" href="<?php echo pt_image_paths_constants($img->cimg_type,'cruises').$img->cimg_image;?>"><?php echo $img->cimg_image;?> </a> </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_image_single" id="<?php echo $img->cimg_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_image_single" id="<?php echo $img->cimg_id;?>" data-imagename="<?php echo $img->cimg_image;?>" data-imagetype="<?php echo $img->cimg_type;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } }elseif($module == "crooms"){
          foreach($croomimages as $img){ ?>
        <tr id="row_<?php echo $img->rimg_id;?>">
          <td><input type="checkbox" name="images_ids[]" value="<?php echo $img->rimg_id;?>" class="selectedId"  /></td>
          <td> <a class="colorbox" href="<?php echo pt_image_paths_constants($img->rimg_type,'crooms').$img->rimg_image;?>"><?php echo $img->rimg_image;?> </a> </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_image_single" id="<?php echo $img->rimg_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_image_single" id="<?php echo $img->rimg_id;?>" data-imagename="<?php echo $img->rimg_image;?>" data-imagetype="<?php echo $img->rimg_type;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } }elseif($module == "tours"){

          foreach($tourimages as $img){ ?>
        <tr id="row_<?php echo $img->timg_id;?>">
          <td><input type="checkbox" name="images_ids[]" value="<?php echo $img->timg_id;?>" class="selectedId"  /></td>
          <td> <a class="colorbox" href="<?php echo pt_image_paths_constants($img->timg_type,'tours').$img->timg_image;?>"><?php echo $img->timg_image;?> </a> </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_image_single" id="<?php echo $img->timg_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_image_single" id="<?php echo $img->timg_id;?>" data-imagename="<?php echo $img->timg_image;?>" data-imagetype="<?php echo $img->timg_type;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } }elseif($module == "cars"){

          foreach($carimages as $img){ ?>
        <tr id="row_<?php echo $img->cimg_id;?>">
          <td><input type="checkbox" name="images_ids[]" value="<?php echo $img->cimg_id;?>" class="selectedId"  /></td>
          <td> <a class="colorbox" href="<?php echo pt_image_paths_constants($img->cimg_type,'cars').$img->cimg_image;?>"><?php echo $img->cimg_image;?> </a> </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_image_single" id="<?php echo $img->cimg_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_image_single" id="<?php echo $img->cimg_id;?>" data-imagename="<?php echo $img->cimg_image;?>" data-imagetype="<?php echo $img->cimg_type;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } } ?>


      </tbody>
    </table>
    <!-- PHPTRAVELS images table ending -->
    <?php }elseif($type == 'accounts'){  ?>
    <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
          <th><span class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Full Name"></span> Full Name </th>
          <th><span class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Ema"></span> Email </th>
          <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if($module == "supplier"){
          foreach($suppliers as $supplier){
             ?>
        <tr id="row_<?php echo $supplier->accounts_id;?>">
          <td><input type="checkbox" name="accounts_ids[]" value="<?php echo $supplier->accounts_id;?>" class="selectedId"  /></td>
          <td> <?php echo $supplier->ai_first_name." ".$supplier->ai_last_name; ?>  </td>
          <td> <?php echo $supplier->accounts_email; ?>  </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_accsingle" id="<?php echo $supplier->accounts_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_accsingle" id="<?php echo $supplier->accounts_id;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } }elseif($module == "customers"){
          foreach($customers as $customer){
             ?>
       <tr id="row_<?php echo $customer->accounts_id;?>">
          <td><input type="checkbox" name="accounts_ids[]" value="<?php echo $customer->accounts_id;?>" class="selectedId"  /></td>
          <td> <?php echo $customer->ai_first_name." ".$customer->ai_last_name; ?>  </td>
          <td> <?php echo $customer->accounts_email; ?>  </td>
          <td align="center">
            <span class="btn btn-xs btn-success accept_accsingle" id="<?php echo $customer->accounts_id;?>"><i class="fa fa-check"></i> Approve</span>
            <span class="btn btn-xs btn-danger reject_accsingle" id="<?php echo $customer->accounts_id;?>" ><i class="fa fa-times"></i> Delete</span>
          </td>
        </tr>
        <?php } } ?>
      </tbody>
    </table>
    <!-- PHPTRAVELS accounts table ending -->
    <?php } } ?>
    <!----Acounts pending End---->
  </div>
</div>
