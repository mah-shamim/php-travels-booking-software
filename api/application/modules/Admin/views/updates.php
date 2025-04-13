<div class="panel panel-default">
  <div class="panel-heading">Updates</div>
  <div class="panel-body">
 <?php if (!function_exists("gzcompress")) { ?>
 <div class="alert alert-danger">ZLib extension must be enabled, in order to get updates installed.</div>
 <?php } ?>
  <?php if(empty($updatesList)){ echo "<h4 class='text-center' style='margin-top:100px'>No new updates available</h4>"; }else{ if($allUpdated){ echo "No more Updates available"; }else{ ?>

  <!-- <div class="alert alert-danger"><strong>Note:</strong> To avoid any disturbance with your application in future, please install the older update before installing the new update. The oldest Update is shown on top. </div> -->
           
  <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th class="text-center">Build</th>
          <th class="text-center">App Version</th>
          <th>Description</th>
          <th class="text-center">Type</th>
          <th class="text-center">Date</th>
          <th style="width:235px" class="text-center">Action</th>

        </tr>
      </thead>
      <tbody>
       <?php $chkUpdate = array_diff($allUpdates,$updatesDone->updated); $checkingInstall = min($chkUpdate); foreach($updatesList as $update){ $updateVersionNum = str_replace("v","",$update->ptversion); if(!in_array($update->update,$updatesDone->updated) && $ptVersion <= $updateVersionNum){ ?> 
    <tr id="tr_<?php echo $update->update;?>">

      <td class="text-center"> <?php echo $update->update;?> </td>
      <td> <?php echo $update->ptversion;?></td>
      <td> <?php echo $update->shortdesc;?></td>
      <td class="text-center"> <?php echo $update->type;?></td>
      <td class="text-center"> <?php echo $update->date;?></td>
      <td class="block-center">
      <input type="hidden" name="" id="hasSql_<?php echo $update->update;?>" value="<?php echo $update->sql;?>">
      <?php if($checkingInstall == $update->update){ ?>
      <button id="<?php echo $update->update;?>" class="btn btn-success btn-xs getupdate" >Install</button>
      <?php }else{ ?>
      
      <!-- <button id="<?php echo $update->update;?>" class="btn btn-success btn-xs"  style="cursor: not-allowed !important;">Install</button> -->
      
      <?php } ?>

      <a href="<?php echo $updateurl.$update->update;?>/<?php echo $update->update;?>.zip" class="btn btn-primary btn-xs" >Download</a>
      <button data-toggle="modal" data-target="#details<?php echo $update->update; ?>" class="btn btn-warning btn-xs" >Details</button>
     
      <!-- <button id="<?php echo $update->update;?>" class="btn btn-danger btn-xs hideupdate" >Hide</button> -->
     
      </td>
    </tr>
    <?php } } ?>

      </tbody>
    </table>

         <div class="row">
     <div class="col-md-10">
    <div class="progress" style="display:none;">
  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
    <span class="sr-only"></span>
  </div>
</div>
</div>

<div class="col-md-2">
<h4 id="show" style="display:none; margin-top: -1px;" class="text-center btn-xs btn btn-success btn-block">Done</h4>
</div>
</div>
    <?php } } ?>



  </div>
</div>


<script>
var value = 0;

function barAnim(id){
    value += 5;
    $( ".progress-bar" ).css( "width", value + "%" ).attr( "aria-valuenow", value );
    if ( value == 25 || value == 55 || value == 85 ) {
        return setTimeout(function() {
    barAnim(id);
}, 1500)
    }
    if(value >= 100 ){
       $("#show").show();
      $("#tr_"+id).fadeOut("slow");
      setTimeout(resetProgress,1000);
    }
    return value >= 100 || setTimeout(function() {
    barAnim(id);
}, 50);
}

function resetProgress(){
  value = 0;

  $(".progress").hide();
 $( ".progress-bar" ).css( "width", 0 ).attr( "aria-valuenow", 0 ); 
 $("#show").hide();
 location.reload();
}


</script>

<!-- Charts -->
<script type="text/javascript">
  $(function () { 
    //apply update
    $(".getupdate").on("click",function(){
 var id = $(this).prop("id");
 var hasSql = $("#hasSql_"+id).val();
 
 var ucount = $("#updatescount").html();

 $.alert.open('confirm', 'Are you sure you want to get this update. It will update all the files that comes with this update with the files of your current application. Please make sure you have backed up your files already.', function(answer) {
   if(answer == 'yes'){
      $("#"+id).prop("disabled","true");
      $(".progress").show();
      
      $.post("<?php echo base_url();?>admin/updates/applyUpdate",{updatekey: id, hasSql: hasSql},function(resp){
        barAnim(id);
        updatedcount = ucount-1;
        if(updatedcount > -1){
          $("#updatescount").html(updatedcount);  
        }else{
         $("#updatescount").html('0');    
        }
        
       
      })

    }else{
      return false;
    }

  });
      
      
    })

    //hide update
    $(".hideupdate").on("click",function(){
      var id = $(this).prop("id");
      $.post("<?php echo base_url();?>admin/updates/hideUpdate",{updatekey: id},function(resp){
        $("#tr_"+id).fadeOut("slow");
      })
      
    })

     });


</script>

<!-- Modal -->
  <?php  foreach($updatesList as $update){ ?>
<div class="modal fade" id="details<?php echo $update->update;?>" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $update->update;?></h4>
      </div>
      <div class="modal-body">
       <?php  echo $update->longdesc;?>

       <div class="clearfix"></div>
       <hr>
       <?php $filescount = count($update->files); 
       if($filescount > 0){ ?>
       <table class="table table-striped table-bordered">
           <thead>
           <tr>
               <td><strong>Location</strong></td>
               <td><strong>Name</strong></td>
           </tr>
           </thead>
           <?php foreach($update->files as $file){ ?>
           <tr>
               <td><?php echo $file->location;?></td>
               <td><?php echo $file->name;?></td>
           </tr>
           <?php } ?>
       </table>

       <?php } ?>

      </div>
      <div class="panel-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>