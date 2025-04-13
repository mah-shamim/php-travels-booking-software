<script type="text/javascript">
  $(function(){

   $(".sendtotest").on("click",function(){
   var template = $(this).prop('id');

    $(this).css("opacity",0.5);
    $.post("<?php echo base_url();?>admin/ajaxcalls/sendtotest", { template: template }, function(theResponse){
    setTimeout(function(){
       $("#"+template).css("opacity",1);
    },2000);


   })

   })

    /*$(".smstotest").on("click",function(){
   var template = $(this).data('smstemp');

    $.post("<?php echo base_url();?>admin/ajaxcalls/smstest", { template: template }, function(theResponse){
    $("#sms"+template).css("opacity",0.5);

    if($.trim(theResponse) == 'OK'){
      $.notify("Sent","success");
      $("#sms"+template).css("opacity",1);
    }else{
     $.notify(theResponse,"error");
      $("#sms"+template).css("opacity",1);

    }
   })

   })*/




    })
</script>
<div class="panel panel-default">
  <div class="panel-heading">
    <span class="panel-title pull-left"> Admin </span>
    <div class="clearfix"></div>
  </div>
  <div class="panel-body">
    <table class="table table-hover table-striped table-bordered" >
      <thead>
        <tr role="row">
          <th class="width25"><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
          <th>Template Name</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
        <?php
          $count = 0;
          foreach($templates as $temp){

          $foundAdmin = strpos($temp->temp_name, "admin");

          if ($foundAdmin !== false) { $count++;

          ?>
        <tr>
          <td><?php echo $count;?></td>
          <td><a href="<?php echo base_url();?>admin/templates/email/<?php echo $temp->temp_name;?>"><?php echo $temp->temp_title;?></a></td>
          <td align="center">
            <a href="<?php echo base_url();?>admin/templates/email/<?php echo $temp->temp_name;?>"><?php echo PT_EDIT; ?></a>
            <span id="<?php echo $temp->temp_name;?>" class="btn btn-xs btn-primary sendtotest"><i class="fa fa-envelope"></i> Email Test</span>
            <!-- <span id="sms<?php echo $temp->temp_name;?>" data-smstemp="<?php echo $temp->temp_name;?>" class="btn btn-xs btn-success smstotest"><i class="glyphicon glyphicon-phone"></i> SMS Test</span> -->
          </td>
        </tr>
        <?php } } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <span class="panel-title pull-left"> Supplier </span>
    <div class="clearfix"></div>
  </div>
  <div class="panel-body">
    <table class="table table-hover table-striped table-bordered" >
      <thead>
        <tr role="row">
          <th class="width25"><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
          <th>Template Name</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
        <?php
          $count = 0;
          foreach($templates as $temp){
          $foundSupplier = strpos($temp->temp_name, "supplier");
           $foundAdmin = strpos($temp->temp_name, "admin");

          if ($foundSupplier !== false) {
            if($foundAdmin == false){
            $count++;
            ?>
        <tr>
          <td><?php echo $count;?></td>
          <td><a href="<?php echo base_url();?>admin/templates/email/<?php echo $temp->temp_name;?>"><?php echo $temp->temp_title;?></a></td>
          <td align="center">
            <a href="<?php echo base_url();?>admin/templates/email/<?php echo $temp->temp_name;?>"><?php echo PT_EDIT; ?></a>
            <span id="<?php echo $temp->temp_name;?>" class="btn btn-xs btn-primary sendtotest"><i class="fa fa-envelope"></i> Email Test</span>
            <!-- <span id="sms<?php echo $temp->temp_name;?>" data-smstemp="<?php echo $temp->temp_name;?>" class="btn btn-xs btn-success smstotest"><i class="glyphicon glyphicon-phone"></i> SMS Test</span> -->
          </td>
        </tr>
        <?php } } } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <span class="panel-title pull-left"> Customer </span>
    <div class="clearfix"></div>
  </div>
  <div class="panel-body">
    <table class="table table-hover table-striped table-bordered" >
      <thead>
        <tr role="row">
          <th class="width25"><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
          <th>Template Name</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
        <?php
          $count = 0;
          foreach($templates as $temp){
            $foundCustomer = strpos($temp->temp_name, "customer");
            $foundAdmin = strpos($temp->temp_name, "admin");


          if ($foundCustomer !== false) {
             if($foundAdmin == false){
            $count++;
            ?>
        <tr>
          <td><?php echo $count;?></td>
          <td><a href="<?php echo base_url();?>admin/templates/email/<?php echo $temp->temp_name;?>"><?php echo $temp->temp_title;?></a></td>
          <td align="center">
            <a href="<?php echo base_url();?>admin/templates/email/<?php echo $temp->temp_name;?>"><?php echo PT_EDIT; ?></a>
            <span id="<?php echo $temp->temp_name;?>" class="btn btn-xs btn-primary sendtotest"><i class="fa fa-envelope"></i> Email Test</span>
            <!-- <span id="sms<?php echo $temp->temp_name;?>" data-smstemp="<?php echo $temp->temp_name;?>" class="btn btn-xs btn-success smstotest"><i class="glyphicon glyphicon-phone"></i> SMS Test</span> -->
          </td>
        </tr>
        <?php } } } ?>
      </tbody>
    </table>
  </div>
</div>