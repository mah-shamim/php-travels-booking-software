<script>
  $(function(){

        slideout();
           // Remove selected subscriber
          $('.del_selected').click(function(){
      var subscribers = new Array();
      $("input:checked").each(function() {
           subscribers.push($(this).val());
        });
      var count_checked = $("[name='news_ids[]']:checked").length;
      if(count_checked == 0) {
        $.alert.open('info', 'Please select a Subscriber to delete.');
        return false;
         }


  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
     if (answer == 'yes')


         $.post("<?php echo base_url();?>admin/ajaxcalls/delete_multiple_subscribers", { newslist: subscribers }, function(theResponse){

                    location.reload();


  	});


  });

    });


    // disable selected Subscriber
        $('.disable_selected').click(function(){
      var subscribers = new Array();
      $("input:checked").each(function() {
           subscribers.push($(this).val());
        });
      var count_checked = $("[name='news_ids[]']:checked").length;
      if(count_checked == 0) {
       $.alert.open('info', 'Please select a Subscriber to Disable.');
        return false;
         }

    $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
        if (answer == 'yes')


           $.post("<?php echo base_url();?>admin/ajaxcalls/disable_multiple_subscribers", { newslist: subscribers }, function(theResponse){

                    location.reload();


  	});


    });


    });

        // enable selected subscriber
        $('.enable_selected').click(function(){
      var subscribers = new Array();
      $("input:checked").each(function() {
           subscribers.push($(this).val());
        });
      var count_checked = $("[name='news_ids[]']:checked").length;
      if(count_checked == 0) {
        $.alert.open('info', 'Please select a Subscriber to Enable.');
        return false;
         }

    $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
        if (answer == 'yes')


          $.post("<?php echo base_url();?>admin/ajaxcalls/enable_multiple_subscribers", { newslist: subscribers }, function(theResponse){

                    location.reload();


  	});


    });


    });

    // Enable single Subscriber

    $(".enable_single").click(function(){
   var id = $(this).attr('id');


   $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
       if (answer == 'yes')


            $.post("<?php echo base_url();?>admin/ajaxcalls/enable_single_subscriber", { newsid: id }, function(theResponse){

                    location.reload();


  	});


   });

    });

        // Disable single Subscriber

    $(".disable_single").click(function(){
   var id = $(this).attr('id');


  $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
     if (answer == 'yes')


          $.post("<?php echo base_url();?>admin/ajaxcalls/disable_single_subscriber", { newsid: id }, function(theResponse){

                    location.reload();


  	});


  });

    });

       //delete single subscriber
    $(".del_single").click(function(){
   var id = $(this).attr('id');


  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
     if (answer == 'yes')


   $.post("<?php echo base_url();?>admin/ajaxcalls/delete_single_subscriber", { newsid: id }, function(theResponse){

                    location.reload();


  	});


  });

    });


  })


</script>
  <form class="form-horizontal" action="" method="POST">
          <div class="panel panel-default">
          <div class="panel-heading">
              Send Newsletter
              </div>
            <div class="panel-body">

                <fieldset>
                  <div class="form-group">
                    <label class="col-md-1 control-label">Sent to</label>
                    <div class="col-md-3">
                      <select data-placeholder="Select" class="chosen-select" name="sendto">
                        <option value="everyone"> Everyone</option>
                        <option value="subscribers"> Subscribers</option>
                        <option value="admin"> Admin</option>
                        <option value="supplier"> Suppliers</option>
                        <option value="customers"> Customers</option>
                        <option value="guest"> Guests</option>
                     </select>
                    </div>
                    <label class="col-md-1 control-label">Subject</label>
                    <div class="col-md-5">
                      <input class="form-control" type="text" placeholder="Newsletter Subject" name="subject">
                    </div>

                    <div class="col-md-2">
          <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-envelope"></i> Send</button>
                    </div>



                  </div>
                </fieldset>
            </div>
          </div>


          <textarea class="ckeditor" cols="80" id="editor"  rows="10" name="content">  </textarea>

          <input type="hidden" name="sendnews" value="1" />

        </form>


<style>
.cke_contents { height: 375px !important; }
</style>