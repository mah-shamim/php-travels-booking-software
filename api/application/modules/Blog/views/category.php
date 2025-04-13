<script type="text/javascript">
$(function(){

$(".advsearch").on("click",function() {
var status = $("#status").val();
var cattitle = $("#cattitle").val();

    var perpage = $("#perpage").val();

     $(".loadbg").css("display","block");

     var dataString = 'advsearch=1&cattitle='+cattitle+'&perpage='+perpage+'&status='+status;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>blog/blogback/category_ajax/",
           data: dataString,
           cache: false,
           success: function(result){

               $(".loadbg").css("display","none");
                 $("#ajax-data").html(result);
                  $("#li_1").addClass("active");
           }
      });


});


  $("#li_1").addClass('active');

      //delete single car
    $(".del_single").click(function(){
   var id = $(this).attr('id');

  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')
    $.post("<?php echo base_url();?>blog/blogajaxcalls/delete_single_category", { catid: id }, function(theResponse){
    location.reload();
  	});

  });
  });
 // end delete single category
 // delete selected categories
  $('.del_selected').click(function(){
      var cats = new Array();
      $("input:checked").each(function(){ cats.push($(this).val()); });
      var count_checked = $("[name='cat_ids[]']:checked").length;
      if(count_checked == 0) { $.alert.open('info', 'Please select a category to Delete.'); return false; }
      $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
     if (answer == 'yes')
     $.post("<?php echo base_url();?>blog/blogajaxcalls/delete_multiple_categories", { catlist: cats }, function(theResponse){
     location.reload();
  	}); }); });
 // end delete selected categories

 // Disable selected categories
  $('.disable_selected').click(function(){
   var cats = new Array();
   $("input:checked").each(function() { cats.push($(this).val()); });
   var count_checked = $("[name='cat_ids[]']:checked").length;
   if(count_checked == 0) { $.alert.open('info', 'Please select a Category to Disable.'); return false; }
   $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
   if (answer == 'yes')
   $.post("<?php echo base_url();?>blog/blogajaxcalls/disable_multiple_categories", { catlist: cats }, function(theResponse){
   location.reload();
   }); }); });
  // end disable multiple category
  // Enable selected cars
  $('.enable_selected').click(function(){
   var cats = new Array();
   $("input:checked").each(function() { cats.push($(this).val()); });
   var count_checked = $("[name='cat_ids[]']:checked").length;
   if(count_checked == 0) { $.alert.open('info', 'Please select a category to Enable.'); return false; }
   $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
   if (answer == 'yes')
   $.post("<?php echo base_url();?>blog/blogajaxcalls/enable_multiple_categories", { catlist: cats }, function(theResponse){
   location.reload();
   }); }); });
   // end enable selected categories



}) // end document ready

// car updateorder function
 function updateOrder(order,id,olderval){
   var maximumorder = "<?php echo $max['nums'];?>";
   if(order != olderval){
   if(order > maximumorder || order < 1){
   $.alert.open('info', 'Cannot assign order lesser than 1 or greater than '+maximumorder);
   $("#order_"+id).val(olderval);
   }else{ $('#pt_reload_modal').modal('show');
           $.post("<?php echo base_url();?>cars/carajaxcalls/update_car_order", { order: order,id: id }, function(theResponse){
           $('#pt_reload_modal').modal('hide');	}); } } }
//end car updateorder function

// Start Change Pagination
function changePagination(pageId,liId){
   $(".loadbg").css("display","block");
   var perpage = $("#perpage").val();
   var last = $(".last").prop('id');
   var prev = pageId - 1;
   var next =  parseFloat(liId) + 1;
   var dataString = 'perpage='+ perpage;
   $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>blog/blogback/category_ajax/"+pageId,
           data: dataString,
           cache: false,
           success: function(result){

             $(".loadbg").css("display","none"); $("#ajax-data").html(result);
             if(liId != '1'){
             $(".first").after("<li class='previous'><a href='javascript:void(0)' onclick=changePagination('"+prev+"','"+prev+"') >Previous</a></li>");
             }
             $(".litem").removeClass("active"); $("#li_"+liId).css("display","block"); $("#li_"+liId).addClass("active");
             } }); }
// End Change Pagination

// Start change pagination by per page
function changePerpage(perpage){
    $(".loadbg").css("display","block"); var dataString = 'perpage='+ perpage;
    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>blog/blogback/category_ajax/1",
           data: dataString,
           cache: false,
           success: function(result){

             $(".loadbg").css("display","none");
             $("#ajax-data").html(result);
             $("#li_1").addClass("active");
           } }); }
// End change pagination by per page
</script>

  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } echo LOAD_BG;?>
    <?php if(empty($ajaxreq)){ ?>
<div class="<?php echo body;?>">
  <div class="panel panel-primary table-bg">
      <div class="panel-heading">
      <span class="panel-title pull-left"><i class="glyphicon glyphicon-th-large"></i> Blog Categories</span>
      <div class="pull-right">
        <a data-toggle="modal" data-target="#add"><?php echo PT_ADD; ?></a>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>


    <div class="panel-body">

     <div class="panel panel-default">
   <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#filter" aria-expanded="false" aria-controls="filter">
          Search/Filter
        </a>
      </h4>
    </div>
    <div id="filter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">

      <div class="form-horizontal">

      <div class="form-group">
      								   <label class="col-md-2 control-label">Status</label>
      									 <div class="col-md-3">

<select class="form-control type" name="" id="status">
               <option value="1">Enable</option>
               <option value="0">Disable</option>


                </select>
      									</div>

      								   <label class="col-md-2 control-label">Category Name</label>
      									 <div class="col-md-3">

      											<input class="form-control" type="text" placeholder="Category Name" id="cattitle" name="" value="">

      									</div>

                                        </div>



                                      <div class="form-group">
                                    <label class="col-md-2 control-label"></label>

      									 <div class="col-md-3">
                                     <button class="btn btn-primary btn-block advsearch">Search</button>

      									</div>

                                        <label class="col-md-2 control-label"></label>
      									 <div class="col-md-3">

      									</div>
      									</div>


      								 </div>


      </div>
    </div>
  </div>

  <hr>     <?php } ?>
         <div id="ajax-data">
        <div  class="dataTables_wrapper form-inline" role="grid">

          <div class="matrialprogress"  style="display:none"><div class="indeterminate"></div></div>
          <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered dataTable" >
            <thead>
              <tr role="row">
          <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all" /></th>
            <th><span class="fa fa-file-o" data-toggle="tooltip" data-placement="top" title="Page Name"></span> Category Name</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>

						     </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">

                         <?php

                  if(!empty($c_data)){
                  $count = 0;


            foreach($c_data['all'] as $cat){
                  $count++;

                if($count % 2 == 0){
                  $evenodd = "even";
                }else{
                   $evenodd = "odd";
                }

               ?>

              <tr class="<?php echo $evenodd;?>">
                <td><input type="checkbox" name="cat_ids[]" value="<?php echo $cat->cat_id;?>" class="selectedId"  /></td>
                <td><?php echo $cat->cat_name;?></td>
                 <td>
                <?php

                if($cat->cat_status == '1'){
                    echo PT_ENABLED;
                }else{
                echo PT_DISABLED;

                }

                ?>
                </td>
                <td align="center">
                <span class="del_single" id="<?php echo $cat->cat_id;?>">  <?php echo PT_DEL; ?> </span>
                <a data-toggle="modal" data-target="#edit<?php echo $cat->cat_id;?>" class="btn btn-xs btn-warning"><i class="fa fa-external-link"></i> edit</a>
              </tr>
             <?php }  } ?>


            </tbody>
          </table>

           <?php include 'application/modules/admin/views/includes/table-foot.php'; ?>

        </div>
      </div>
    </div>

  </div>

</div>


<!-- Modal add------->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
  <form action="" method="POST">
 <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body">
        <div class="form-group form-horizontal">
        <div class="row">
         <label class="col-md-3 control-label">Category Name</label>
      									 <div class="col-md-6">
      											<input class="form-control" type="text" placeholder="Category Name" name="name" value="" required>
      </div>
        </div>
          <div class="row">
                     <label class="col-md-3 control-label">Status</label>
<div class="col-md-6">
<select class="form-control type" name="status">
               <option value="Yes">Enable</option>
               <option value="No">Disable</option>


                </select>

</div>
          </div>

      	</div>

      									</div>
      </div>
      <div class="modal-footer">
      <input type="hidden" name="addcategory" value="1" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>

    </div>
      </form>
  </div>



<!-- Modal edit---->
        <?php

                  if(!empty($c_data)){
                  $count = 0;


            foreach($c_data['all'] as $cat){

               ?>
<div class="modal fade" id="edit<?php echo $cat->cat_id;?>" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
  <form action="" method="POST">
 <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Update Category</h4>
      </div>
      <div class="modal-body">
        <div class="form-group form-horizontal">
        <div class="row">
         <label class="col-md-3 control-label">Category Name</label>
      									 <div class="col-md-6">
      											<input class="form-control" type="text" placeholder="Category Name" name="name" value="<?php echo $cat->cat_name;?>" required>
      </div>
        </div>
          <div class="row">
                     <label class="col-md-3 control-label">Status</label>
<div class="col-md-6">
<select class="form-control type" name="status">
               <option value="Yes" <?php if($cat->cat_status == "Yes"){ echo "selected";} ?> >Enable</option>
               <option value="No" <?php if($cat->cat_status == "No"){ echo "selected";} ?> >Disable</option>


                </select>

</div>
          </div>

      	</div>

      									</div>
      </div>
      <div class="modal-footer">
      <input type="hidden" name="categoryid" value="<?php echo $cat->cat_id;?>" />
      <input type="hidden" name="updatecategory" value="1" />
      <input type="hidden" name="slug" value="<?php echo $cat->cat_slug;?>" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>

    </div>
      </form>
</div>
<?php } } ?>