<script type="text/javascript">
  $(function(){

        slideout();
  $(".advsearch").on("click",function() {
  var invoiceno = $("#invoiceno").val();
  var invoicefdate = $("#invoicefromdate").val();
  var invoicetdate = $("#invoicetodate").val();
  var status = $("#status").val();
  var customername = $("#customername").val();
  var module = $("#module").val();

    var perpage = $("#perpage").val();

     $(".loadbg").css("display","block");

     var dataString = 'advsearch=1&module='+module+'&perpage='+perpage+'&customername='+customername+'&status='+status+'&invoicefromdate='+invoicefdate+'&invoicetodate='+invoicetdate+'&invoiceno='+invoiceno;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url().$adminsegment;?>/bookings/bookings_ajax/",
           data: dataString,
           cache: false,
           success: function(result){

               $(".loadbg").css("display","none");
                 $("#ajax-data").html(result);
                  $("#li_1").addClass("active");
           }
      });

  });

  $(".searchdata").keypress(function(e) {
    if(e.which == 13) {
    var sterm = $(this).val();
    var perpage = $("#perpage").val();
  if($.trim(sterm).length < 1){

  }else{
     $(".loadbg").css("display","block");

     var dataString = 'search=1&searchdata='+sterm+'&perpage='+perpage;

    $.ajax({
           type: "POST",
           url: "<?php echo base_url().$adminsegment;?>/bookings/bookings_ajax/",
           data: dataString,
           cache: false,
           success: function(result){

               $(".loadbg").css("display","none");
                 $("#ajax-data").html(result);
                  $("#li_1").addClass("active");
           }
      });
     }
   }
  });


        $('.del_selected').click(function(){
        var booklist = new Array();
        $("input:checked").each(function() {
             booklist.push($(this).val());
          });
        var count_checked = $("[name='booking_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select a Booking to Delete.');
          return false;}
  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
          if (answer == 'yes')
    $.post("<?php echo base_url();?>admin/bookings/del_multiple_bookings", { booklist: booklist }, function(resp){
    location.reload();
    });
          });});
        //change multiple status to paid
        $('.paid_selected').click(function(){
        var booklist = new Array();
        $("input:checked").each(function() {
             booklist.push($(this).val());
          });
        var count_checked = $("[name='booking_ids[]']:checked").length;
        if(count_checked == 0) {
  $.alert.open('info', 'Please select a Booking to Change Status to Paid.');
          return false;}
  $.alert.open('confirm', 'Are you sure you want to Change status to paid', function(answer) {
      if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/bookings/booking_status_paid", { booklist: booklist}, function(theResponse){
     location.reload();
     });});});
     // change multiple status to unpaid
      $('.unpaid_selected').click(function(){
     var booklist = new Array();
      $("input:checked").each(function() {
     booklist.push($(this).val());});
     var count_checked = $("[name='booking_ids[]']:checked").length;
     if(count_checked == 0){
  $.alert.open('info', 'Please select a Booking to Change Status to Unpaid.');
          return false;
           }
  $.alert.open('confirm', 'Are you sure you want to Change status to Unpaid', function(answer) {
     if (answer == 'yes')
     $.post("<?php echo base_url();?>admin/bookings/booking_status_unpaid", { booklist: booklist}, function(theResponse){
     location.reload();
     });


  });


    });
      // delete single booking
      $(".del_single").click(function(){
     var id = $(this).attr('id');
  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
      if (answer == 'yes')
       $.post("<?php echo base_url();?>admin/bookings/del_single_booking", { id: id }, function(theResponse){
       location.reload();
       });});});
      // change status of single booking
                $('.status').click(function(){
        var id = $(this).prop('id');
        var expiry = $(this).data('expiry');
        var currtime = $("#currenttime").val();
         if($(this).hasClass('btn-success')){
  $.alert.open('confirm', 'Are you sure you want to change status to Unpaid', function(answer) {
      if (answer == 'yes')
         $.post("<?php echo base_url();?>admin/bookings/single_booking_status_unpaid", { id: id}, function(theResponse){
         $("#"+id).removeClass('btn-success');
         $("#"+id).addClass('btn-warning');
         $("#"+id).html('Unpaid');
        if(currtime > expiry){
         location.reload();
        }

  	   });});}else if($(this).hasClass('btn-warning')){
  $.alert.open('confirm', 'Are you sure you want to change status to Paid', function(answer) {
      if (answer == 'yes')
        $.post("<?php echo base_url();?>admin/bookings/single_booking_status_paid", { id: id}, function(theResponse){

         $("#"+id).removeClass('btn-warning');
         $("#"+id).addClass('btn-success');
         $("#"+id).html('Paid');
          		});});}});
       // cancellation request
       $(".reqcancel").on('click',function(){
         var id = $(this).prop('id');
       $.alert.open('confirm', 'Click Yes to cancel Booking', function(answer) {
      if (answer == 'yes'){
     $.post("<?php echo base_url();?>admin/bookings/cancelrequest/approve", { id: id}, function(theResponse){
                  location.reload();
          		});
    }
    //else if(answer == "no"){
       // $.post("<?php echo base_url();?>admin/bookings/cancelrequest/reject", { id: id}, function(theResponse){
                //location.reload();
          		//});
      // }

                  });

       });
  // resend invoice email
  $(".resend").on('click',function(){
  var id = $(this).prop('id');
  var refno = $(this).data('refno');
  $.alert.open('confirm', 'Resend Invoice?', function(answer) {
  if (answer == 'yes'){
      $('#pt_reload_modal').modal('show');
  $.post("<?php echo base_url();?>admin/bookings/resendinvoice", { id: id, refno: refno}, function(theResponse){
    $('#pt_reload_modal').modal('hide');
  $.alert.open('info', 'Invoice Resent Successfully.');
  });
  }});

  });

       });



  function changePagination(pageId,liId){


   $(".loadbg").css("display","block");

   var perpage = $("#perpage").val();
    var last = $(".last").prop('id');
    var prev = pageId - 1;
    var next =  parseFloat(liId) + 1;
     var dataString = 'perpage='+ perpage;
     $.ajax({
           type: "POST",
           url: "<?php echo base_url().$adminsegment;?>/bookings/bookings_ajax/"+pageId,
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
           url: "<?php echo base_url().$adminsegment;?>/bookings/bookings_ajax/1",
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
<input type="hidden" id="currenttime" value="<?php echo time();?>" />
<?php if(empty($ajaxreq)){ ?>
<div class="<?php echo body;?>">
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-gavel"></i> Bookings Management</span>
      <?php if($this->uri->segment(1) != "supplier"){ ?>
      <div class="pull-right">
        <button class="btn btn-xs btn-success paid_selected"><i class="fa fa-check-square-o"></i> Paid</button>
        <button class="btn btn-xs btn-warning unpaid_selected"><i class="fa fa-minus-square"></i> Unpaid </button>
        <button class="btn btn-xs btn-danger del_selected"><i class="fa fa-times"></i> Delete</button>
      </div>
      <?php } ?>
      <div class="clearfix"></div>
    </div>
    <?php } ?>
    <div class="panel-body">
      <?php if(empty($ajaxreq)){ ?>
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
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
              <!--
                <form action="" method="POST">
                        <div class="form-group">

                          <select class="form-control type" name="module">
                         <option value="">All</option>
                          <?php
                  foreach($modules as $mod):
                    $istrue = $chklib->is_mod_available_enabled($mod);
                     $isintegration = $chklib->is_integration($mod);
                     $ispermitted = pt_permissions($mod,$userloggedin);

                   if($ispermitted && $istrue && !$isintegration){
                  ?>
                              <option value="<?php echo $mod;?>" <?php if(@$selmodule == $mod){ echo "selected"; } ?> ><?php echo ucfirst($mod);?></option>
                              <?php } endforeach; ?>

                          </select>

                        </div>

                         <input type="hidden" name="filtermod" value="1" />

                        <button class="btn btn-primary">Filter</button>
                        </form>
                -->
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="col-md-2 control-label">Module Name</label>
                  <div class="col-md-3">
                    <select class="form-control type" name="module" id="module">
                      <option value="">All</option>
                      <?php
                        foreach($modules as $mod):
                          $istrue = $chklib->is_mod_available_enabled($mod);
                           $isintegration = $chklib->is_integration($mod);
                           $ispermitted = pt_permissions($mod,$userloggedin);

                         if($ispermitted && $istrue && !$isintegration && !in_array($mod,$chklib->notinclude)){
                        ?>
                      <option value="<?php echo $mod;?>" <?php if(@$selmodule == $mod){ echo "selected"; } ?> ><?php echo ucfirst($mod);?></option>
                      <?php } endforeach; ?>
                    </select>
                  </div>
                  <label class="col-md-2 control-label">Invoice Number</label>
                  <div class="col-md-3">
                    <input class="form-control" type="text" placeholder="Invoice Number" id="invoiceno" name="" value="">
                  </div>
                </div>
                <div class="form-group">
                  <?php if($this->uri->segment(1) != "supplier"){ ?>
                  <label class="col-md-2 control-label">Customer's 1st Name</label>
                  <div class="col-md-3">
                    <input class="form-control" type="text" placeholder="Customer Name" id="customername" value="">
                  </div>
                  <?php } ?>
                  <label class="col-md-2 control-label">Invoice Status</label>
                  <div class="col-md-3">
                    <select name="" class="form-control" id="status">
                      <option value="paid">Paid</option>
                      <option value="unpaid">Unpaid</option>
                      <option value="cancelled">Cancelled</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label">Invoice From Date</label>
                  <div class="col-md-3">
                    <input class="dprfrom form-control" type="text" id="invoicefromdate" placeholder="Invoice From Date" name="" value="">
                  </div>
                  <label class="col-md-2 control-label">Invoice To Date</label>
                  <div class="col-md-3">
                    <input class="dprto form-control" type="text" id="invoicetodate" placeholder="Invoice To Date" name="" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-2 control-label"></label>
                  <div class="col-md-3">
                    <button class="btn btn-primary btn-block advsearch">Search</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <?php } ?>
      <div id="ajax-data">
        <div class="matrialprogress"  style="display:none"><div class="indeterminate"></div></div>
        <!-- PHPTRAVELS table starting -->
        <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered" >
          <thead>
            <tr>
              <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all"  /></th>
              <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Invoice Number">&nbsp;</i></th>
              <th><span class="fa fa-user" data-toggle="tooltip" data-placement="top" title="Costumer Name"></span> Customer Name </th>
              <th><span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Name of Section or Item"></span> Item </th>
              <th><span class="fa fa-dollar" data-toggle="tooltip" data-placement="top" title="Total Amount"></span> Total </th>
              <th><span class="fa fa-money" data-toggle="tooltip" data-placement="top" title="Amount to Deposit"></span> Dep </th>
              <th><i class="fa fa-calendar" data-toggle="tooltip" data-placement="top" title="Created On Date"></i> Date</th>
              <?php if($this->uri->segment(1) != "supplier"){ ?>
              <th class="text-center"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status of Invoice"></i> Status</th>
              <?php } ?>
              <th class="text-center" style="width:280px;"><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
            </tr>
          </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php
              if(!empty($bookings)){

                foreach($bookings['all'] as $book){

                ?>
            <tr>
              <td><input type="checkbox" name="booking_ids[]" value="<?php echo $book->booking_id;?>" class="selectedId"  /></td>
              <td><?php echo $book->booking_id;?></td>
              <td><?php echo $book->ai_first_name." ".$book->ai_last_name;?></td>
              <td><?php echo $book->booking_type;?></td>
              <td class="center"><?php echo $app_settings[0]->currency_sign.$book->booking_total;?></td>
              <td class="center"><?php echo $app_settings[0]->currency_sign.$book->booking_deposit;?></td>
              <td class="center"><?php echo pt_show_date_php($book->booking_date);?></td>
              <?php if($adminsegment != "supplier"){ ?>
              <td>
                <?php
                  if($book->booking_status == "paid"){
                  ?>
                <span style="margin-top:5px;" class="btn btn-block btn-xs status btn-success" data-expiry="<?php echo $book->booking_expiry;?>" id="<?php echo $book->booking_id;?>">Paid</span>
                <?php
                  }elseif($book->booking_status == "unpaid"){
                  ?>
                <span style="margin-top:5px;" class="btn btn-block btn-xs status btn-warning" data-expiry="<?php echo $book->booking_expiry;?>" id="<?php echo $book->booking_id;?>">Unpaid</span>
                <?php
                  }elseif($book->booking_status == "cancelled"){
                  ?>
                <span style="margin-top:5px;" class="btn btn-block btn-xs status btn-default" >Cancelled</span>
                <?php
                  }
                  ?>
              </td>
              <?php } ?>
              <td style="width:330px" align="center">
                <?php
                  if($book->booking_status != "cancelled"){
                  if($this->uri->segment(1) != "supplier"){ ?>
                <span class="btn btn-xs btn-default reqcancel" id="<?php echo $book->booking_id;?>" data-toggle="tooltip" data-placement="top" title="Cancel Booking" > Cancel</span>
                <?php } if(pt_permissions($book->booking_type.'bookings',@$userloggedin)){ ?>   <a href="<?php echo base_url().$adminsegment;?>/bookings/edit/<?php echo $book->booking_type;?>/<?php echo $book->booking_id;?>" ><span class="btn btn-xs btn-warning"><i class="fa fa fa-edit"></i> Edit</span> </a><?php } ?>
                <span class="btn btn-xs btn-success resend" title="Resend Invoice" data-toggle="tooltip" data-placement="top" data-refno="<?php echo $book->booking_ref_no;?>" id="<?php echo $book->booking_id;?>"><i class="fa fa-envelope"></i> Resend</span>
                <?php } ?>
                <?php if($adminsegment != "supplier"){ ?>   <span class="btn btn-xs btn-danger del_single" id="<?php echo $book->booking_id;?>"><i class="fa fa-times"></i> Delete</span> <?php } ?>
                <a title="Preview Invoice" data-toggle="tooltip" data-placement="top"href="<?php echo base_url();?>invoice?id=<?php echo $book->booking_id;?>&sessid=<?php echo $book->booking_ref_no;?>" target="_blank" ><span class="btn btn-xs btn-primary"><i class="fa fa-search-plus"></i> Invoice</span> </a>
              </td>
            </tr>
            <?php  } } ?>
          </tbody>
        </table>
        <?php include 'application/modules/admin/views/includes/table-foot.php'; ?>
      </div>
    </div>
    <!-- PHPTRAVELS table ending -->
  </div>
</div>