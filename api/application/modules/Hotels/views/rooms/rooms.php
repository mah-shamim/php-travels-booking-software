<script>
  $(function(){

        slideout();

$(".advsearch").on("click",function() {

var roomtitle = $("#roomtitle").val();
var roomtype = $("#roomtype").val();
var status = $("#status").val();
var hotelid = $("#hotelid").val();

    var perpage = $("#perpage").val();

     $(".loadbg").css("display","block");

     var dataString = 'advsearch=1&perpage='+perpage+'&hotelid='+hotelid+'&roomtitle='+roomtitle+'&roomtype='+roomtype+'&status='+status;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>hotels/hotelsback/rooms_ajax/",
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

    if($.trim(response.responseText) == "done"){
       $(".output").html('please Wait...');

      parent.jQuery.fn.colorbox.close();
    }
    },
    target: '.output' };
    $('.my-form').submit(function() {
        $(this).ajaxSubmit(options);

        return false;
    });


    $('.del_selected').click(function(){
      var rooms = new Array();
      $("input:checked").each(function() {
           rooms.push($(this).val());
        });
      var count_checked = $("[name='room_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Room to Delete.');
        return false;
         }


    $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
        if (answer == 'yes')


  $.post("<?php echo base_url();?>admin/hotelajaxcalls/delete_multiple_rooms", { roomlist: rooms }, function(theResponse){

                    location.reload();


  	});


    });

    });


        $('.disable_selected').click(function(){
      var rooms = new Array();
      $("input:checked").each(function() {
           rooms.push($(this).val());
        });
      var count_checked = $("[name='room_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Room to Disable.');
        return false;
         }



                    $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
    if (answer == 'yes')
   $.post("<?php echo base_url();?>admin/hotelajaxcalls/disable_multiple_rooms", { roomlist: rooms }, function(theResponse){

                    location.reload();


  	});


  });


    });


            $('.enable_selected').click(function(){
      var rooms = new Array();
      $("input:checked").each(function() {
           rooms.push($(this).val());
        });
      var count_checked = $("[name='room_ids[]']:checked").length;
      if(count_checked == 0) {

         $.alert.open('info', 'Please select a Room to Enable.');
        return false;
         }

     $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
    if (answer == 'yes')
   $.post("<?php echo base_url();?>admin/hotelajaxcalls/enable_multiple_rooms", { roomlist: rooms }, function(theResponse){

                    location.reload();


  	});


  });


  });



    $(".del_single").click(function(){
   var id = $(this).attr('id');

  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')


     $.post("<?php echo base_url();?>admin/hotelajaxcalls/delete_single_room", { roomid: id }, function(theResponse){

                    location.reload();


  	});


  });

    });





        });


  function updateRoomtype(type,id){
        $('#pt_reload_modal').modal('show');


  $.post("<?php echo base_url();?>admin/hotelajaxcalls/update_roomtype", { type: type, id: id }, function(theResponse){


               $('#pt_reload_modal').modal('hide');

  	});
  }


  function updateOrder(order,id,olderval,maximumorder){

         if(order != olderval){

         if(order > maximumorder || order < 1){
            $.alert.open('info', 'Cannot assign order lesser than 1 or greater than '+maximumorder);
          $("#order_"+id).val(olderval);

            }else{
                $('#pt_reload_modal').modal('show');
             $.post("<?php echo base_url();?>admin/hotelajaxcalls/update_room_order", { order: order,id: id }, function(theResponse){


               $('#pt_reload_modal').modal('hide');

  	});

         }


         }


  }



function changePagination(pageId,liId){

   $(".loadbg").css("display","block");
     var perpage = $("#perpage").val();
    var last = $(".last").prop('id');
    var prev = pageId - 1;
    var next =  parseFloat(liId) + 1;
     var dataString = 'perpage='+ perpage;
     $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>hotels/hotelsback/rooms_ajax/"+pageId,
           data: dataString,
           cache: false,
           success: function(result){
              $(".loadbg").css("display","none");   
                 $("#ajax-data").html(result);
                if(liId != '1'){
                 $(".first").after("<li class='previous'><a href='javascript:void(0)' onclick=changePagination('"+prev+"','"+prev+"') >Previous</a></li>");
                 }


                  $(".litem").removeClass("active");
                $("#li_"+liId).css("display","block");
                $("#li_"+liId).addClass("active");

           }
      });
}

function changePerpage(perpage){

    $(".loadbg").css("display","block");

     var dataString = 'perpage='+ perpage;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>hotels/hotelsback/rooms_ajax/1",
           data: dataString,
           cache: false,
           success: function(result){
              $(".loadbg").css("display","none");
             $("#ajax-data").html(result);
             $("#li_1").addClass("active");
           }
      });
}





</script>

  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } echo LOAD_BG; ?>
         <?php if(empty($ajaxreq)){ ?>
                     
       <div class="panel-body">
       <div class="panel panel-primary table-bg">

        <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-tags"></i> Rooms Management</span>
      <div class="pull-right">
      <a href="<?php echo base_url().$this->uri->segment(1);?>/hotels/rooms/add/"> <?php echo PT_ADD; ?></a>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>





      <div class="panel-body">

      <?php if($adminsegment != "supplier"){ ?>
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
  <label class="col-md-2 control-label">Hotel Name</label>
  <div class="col-md-3">
     <select data-placeholder="Name" class="chosen-select" id="hotelid" name="hotelid">
                    <option value="">Any Hotel</option>
                    <?php
                      foreach($hotels as $hotel){
                      ?>
                    <option value="<?php echo $hotel->hotel_id;?>"><?php echo $hotel->hotel_title;?></option>
                    <?php
                      }
                      ?>
                  </select>
  </div>
  <label class="col-md-2 control-label">Room Title</label>
  <div class="col-md-3">
<input class="form-control" type="text" placeholder="Room Title" id="roomtitle" name="" value="">
</div>



</div>
 <div class="form-group">
 <label class="col-md-2 control-label">Room Type</label>
          <div class="col-md-4">
          <select data-placeholder="Room Type" class="chosen-select" id="roomtype" name="roomtype">
          <option value=""></option>
          <?php $rtypes = pt_get_hsettings_data("rtypes");
          foreach($rtypes as $rtype){  ?>
          <option value="<?php echo $rtype->sett_id;?>" <?php if($rdata[0]->room_type == $rtype->sett_id){echo "selected";}?>  ><?php echo $rtype->sett_name;?></option>
          <?php } ?>
          </select>
          </div>

<label class="col-md-2 control-label">Room Status</label>
          <div class="col-md-2">
          <select class="form-control" id="status">
          <option value="1">Enable</option>
          <option value="0">Disable</option>
           </select>
          </div>
 </div>

                                        <div class="form-group">
      								   <label class="col-md-2 control-label"></label>
      									 <div class="col-md-3">
                                           <input type="hidden" name="searchrooms" value="1" />
                                          <button type="button" class="btn btn-primary btn-block advsearch">Search</button>


      								 </div>


      								 </div>

      								 </div>


      </div>
    </div>
  </div>

  <hr>
       <?php } } ?>


        <div id="ajax-data">
       <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
         <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" >
            <thead>
              <tr role="row">
         <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
            <th><span class="fa fa-tags" data-toggle="tooltip" data-placement="top" title="Room Name or Number"></span> Room </th>
            <th><span class="fa fa-building-o" data-toggle="tooltip" data-placement="top" title="Room Of Hotel"></span> Hotel </th>
            <th><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Added On Date"></i> Date</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>

            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">

              <?php
                  if(!empty($allrooms['all'])){
                  $count = 0;
               //    $maxrooms = pt_rooms_count($hotel_id);

            foreach($allrooms['all'] as $room){
                  $count++;

                if($count % 2 == 0){
                  $evenodd = "even";
                }else{
                   $evenodd = "odd";
                }
              $count++
               ?>
            <tr class="<?php echo $evenodd;?>">
             <td><?php echo $room->room_id;?></td>
            <td><input type="checkbox" name="room_ids[]" value="<?php echo $room->room_id;?>" class="selectedId"  /></td>
            <td><a href="<?php echo base_url().$adminsegment; ?>/hotels/rooms/manage/<?php echo $room->room_id;?>"><?php echo $room->room_title;?></a></td>
            <td><a href="<?php echo base_url().$adminsegment;?>/hotels/manage/<?php echo $room->hotel_slug;?>"><?php echo $room->hotel_title;?></a></td>
            <td class="center"><?php echo pt_show_date_php($room->room_added_on);?></td>
            <td>
              <?php
                if($room->room_status == "1"){
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
              <a href="<?php echo base_url().$adminsegment; ?>/hotels/rooms/manage/<?php echo $room->room_id;?>#price"><button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Availability and Price"><i class="fa fa-calendar-o"></i> Price</button></a>
              <button data-toggle="modal" href="#media_<?php echo $room->room_id;?>" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Gallery</button>
              <a href="<?php echo base_url().$adminsegment; ?>/hotels/rooms/translate/<?php echo $room->room_id;?>"><span class="btn btn-xs btn-enable"><i class="fa fa-flag-checkered"></i> Translate</span></a>
              <a href="<?php echo base_url().$adminsegment; ?>/hotels/rooms/manage/<?php echo $room->room_id;?>"><?php echo PT_EDIT; ?></a> 
              <span class="del_single" id="<?php echo $room->room_id;?>"><?php echo PT_DEL; ?></span>

            </tr>
            <?php
            }  }
              ?>


           </tbody>
          </table>
              <?php include 'application/modules/admin/views/includes/table-foot.php'; ?>

        </div>


      </div>
    </div>



  <!---------- <div class="panel-body">
      <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
            <th><span class="fa fa-tags" data-toggle="tooltip" data-placement="top" title="Room Name or Number"></span> Room </th>
            <th><span class="fa fa-building-o" data-toggle="tooltip" data-placement="top" title="Room Of Hotel"></span> Hotel </th>
            <th><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Added On Date"></i> Date</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($allrooms)){
            $count = 0;
            $maxrooms = pt_rooms_count($hotel_id);
            foreach($allrooms as $room){
            $count++;
            ?>
          <tr>
            <td><?php echo $count;?></td>
            <td><input type="checkbox" name="room_ids[]" value="<?php echo $room->room_id;?>" class="selectedId"  /></td>
            <td><a href="<?php echo base_url().$this->uri->segment(1); ?>/hotels/rooms/manage/<?php echo $room->room_id;?>"><?php echo $room->room_title;?></a></td>
            <td><a href="<?php echo base_url().$this->uri->segment(1);?>/hotels/manage/<?php echo str_replace(" ","-",$room->hotel_title);?>"><?php echo $room->hotel_title;?></a></td>
            <td class="center"><?php echo pt_show_date_php($room->room_added_on);?></td>
            <td>
              <?php
                if($room->room_status == "1"){
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
              <a href="<?php echo base_url();?>admin/hotels/rooms/manage/<?php echo $room->room_id;?>#price"><button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Availability and Price"><i class="fa fa-calendar-o"></i> Price</button></a>
              <button data-toggle="modal" href="#media_<?php echo $room->room_id;?>" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Gallery</button>
              <a href="<?php echo base_url(); ?>admin/hotels/rooms/manage/<?php echo $room->room_id;?>"><span class="btn btn-xs btn-warning"><i class="fa fa-external-link"></i> edit</span></a>
              <span class="btn btn-xs btn-danger del_single" id="<?php echo $room->room_id;?>"><i class="fa fa-times"></i> delete</span>
          </tr>
          <?php
            }

            ?><?php
            }
            ?>
        </tbody>
      </table>
    </div>------>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-search"></i> Advanced Search </h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-45">
            <form role="form" method="POST" action="">
              <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8">
                  <select data-placeholder="Hotel Name" class="chosen-select" name="hotelid">
                    <option value="">Any Hotel</option>
                    <?php
                      foreach($hotels as $hotel){
                      ?>
                    <option value="<?php echo $hotel->hotel_id;?>"><?php echo $hotel->hotel_title;?></option>
                    <?php
                      }
                      ?>
                  </select>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <select data-placeholder="Status" class="chosen-select" name="status">
                    <option value=""></option>
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                  </select>
                </div>
              </div>
              <hr class="divider">
              <div class="row">
                <div class="form-group">
                  <label class="col-md-3 control-label">Room Added</label>
                  <div class="col-md-3">
                    <input class="form-control dprfrom" type="text" placeholder="From" name="ffrom" >
                  </div>
                  <div class="col-md-3">
                    <input class="form-control dprto" type="text" placeholder="To" name="fto"  >
                  </div>
                </div>
              </div>
              <hr class="divider">
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <select data-placeholder="Room Type" class="chosen-select" name="roomtype">
                    <?php
                      $rtypes = pt_get_hsettings_data("rtypes");
                              foreach($rtypes as $rtype){
                       ?>
                    <option value="<?php echo $rtype->sett_id;?>"  ><?php echo $rtype->sett_name;?></option>
                    <?php
                      }

                      ?>
                  </select>
                </div>
              </div>
              <hr class="divider">
              <hr class="colorgraph">
              <div class="row">
                <input type="hidden" name="searchrooms" value="1" />
                <button type="submit" class="btn btn-success btn-block btn-lg"><i class="fa fa-search"></i> Search</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!------- Jquery File upload included files------------>
<?php echo pt_jquery_upload_files();?>
<!------- Jquery File upload included files------------>
<!------Media Modal ---->
<?php
  if(!empty($allrooms['all'])){

  foreach($allrooms['all'] as $roomm){

    ?>
<div class="modal fade" id="media_<?php echo $roomm->room_id;?>" role="dialog" aria-labelledby="Media" aria-hidden="true">
  <div class="modal-dialogs">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-user"></span> Add Media for <?php echo $roomm->room_title;?></h4>
      </div>
      <div class="modal-body">
        <div class="container">
          <br>
          <!-- The file upload form used as target for the file upload widget -->
          <form class="fileupload" action="<?php echo base_url();?>hotels/hotelsback/do_upload_room" method="POST" enctype="multipart/form-data" data-upload-template-id="template-upload-<?php echo $roomm->room_id;?>"
            data-download-template-id="template-download-<?php echo $roomm->room_id;?>">
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
              <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Add files...</span>
                <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                <i class="glyphicon glyphicon-trash"></i>
                <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
              </div>
              <!-- The global progress state -->
              <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
              </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped">
              <tbody class="files"></tbody>
            </table>
            <input type="hidden" name="uploadit" value="1" />
            <input type="hidden" name="roomid" value="<?php echo $roomm->room_id;?>" />
          </form>
          <br>
        </div>
        <script id="template-upload-<?php echo $roomm->room_id;?>" type="text/x-tmpl">
          {% for (var i=0, file; file=o.files[i]; i++) { %}
              <tr class="template-upload fade" style="width:400px;">
                  <td>
                      <span class="preview"></span>
                  </td>
                  <td>
                      <p class="name">{%=file.name%}</p>
                      <strong class="error text-danger"></strong>
                  </td>
                  <td>
                      <p class="size">Processing...</p>
                      <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                  </td>
                  <td>
                      {% if (!i && !o.options.autoUpload) { %}
                          <button class="btn btn-primary start" disabled>
                              <i class="glyphicon glyphicon-upload"></i>
                              <span>Start</span>
                          </button>
                      {% } %}
                      {% if (!i) { %}
                          <button class="btn btn-warning cancel">
                              <i class="glyphicon glyphicon-ban-circle"></i>
                              <span>Cancel</span>
                          </button>
                      {% } %}
                  </td>
              </tr>
          {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download-<?php echo $roomm->room_id;?>" type="text/x-tmpl">
          {% for (var i=0, file; file=o.files[i]; i++) {

           %}
              <tr class="template-download fade">
                  <td>
                      <span class="preview">
                          {% if (file.thumbnailUrl) { %}
                              <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                          {% } %}
                      </span>
                  </td>
                  <td>
                      <p class="name">
                          {% if (file.url) { %}
                              <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                          {% } else { %}
                              <span>{%=file.name%}</span>
                          {% } %}
                      </p>
                      {% if (file.error) { %}
                    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                      {% } %}
                  </td>
                  <td>
                      <span class="size">{%=o.formatFileSize(file.size)%}</span>
                  </td>
                  <td>
                      {% if (file.deleteUrl) { %}
                          <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                              <i class="glyphicon glyphicon-trash"></i>
                              <span>Delete</span>
                          </button>
                          <input type="checkbox" name="delete" value="1" class="toggle">
                          <button class="btn btn-warning cancel">
                              <i class="glyphicon glyphicon-ban-circle"></i>
                              <span>Cancel</span>
                          </button>
                      {% } else { %}

                      {% } %}
                  </td>
              </tr>
          {% } %}
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
  }

  ?>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
  <div class="slides"></div>
  <h3 class="title"></h3>
  <a class="prev" style="font-size:38px;"><i class="fa fa-arrow-left"></i></a>
  <a class="next" style="font-size:38px;"><i class="fa fa-arrow-right"></i></a>
  <a class="close"><i class="fa fa-times"></i></a>
  <a class="play-pause"></a>
  <ol class="indicator"></ol>
</div>
<?php
  }
  ?>
<!------Media Modal ---->     </div></div>