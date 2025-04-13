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
<div class="<?php echo body;?>">
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-envelope"></i> Newsletter Management</span>
      <div class="pull-right">
        <button data-toggle="modal" href="#SendNewsletter" class="btn btn-xs btn-success"><i class="fa fa-envelope-o"></i> Send Newsletter</button>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
    <?php if($this->session->flashdata('flashmsgs')){ ?>
    <script type="text/javascript">
      $(function(){
         $.notify("Changes Saved","success");
      })
    </script>
    <?php } ?>
    <div class="panel-body">
      <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th><i class="fa fa-list-ol" data-toggle="tooltip" data-placement="top" title="Number">&nbsp;</i></th>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All"  id="select_all" /></th>
            <th><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="Email Address"></i> Email</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $count = 0;
            foreach($newslist as $news){
              $count++;
            ?>
          <tr>
            <td><?php echo $count;?></td>
            <td><input type="checkbox" name="news_ids[]" value="<?php echo $news->newsletter_id;?>" class="selectedId" /></td>
            <td class="center"><?php echo $news->newsletter_subscribers;?></td>
            <td class="center">
              <?php
                if($news->newsletter_status == '1'){
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
              <?php
                if($news->newsletter_status == '0'){
                ?>
              <button class="btn btn-xs btn-enable enable_single" id="<?php echo $news->newsletter_id;?>"><i class="fa fa-external-link"></i> enable</button>
              <?php
                }else{
                ?>
              <button class="btn btn-xs btn-info disable_single" id="<?php echo $news->newsletter_id;?>" ><i class="fa fa-minus-square"></i> disable</button>
              <?php
                }
                ?>
              <span class="btn btn-xs btn-danger del_single" id="<?php echo $news->newsletter_id;?>"><i class="fa fa-times"></i> Remove</span>
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
<div class="modal fade" id="SendNewsletter" tabindex="-1" role="dialog" aria-labelledby="SendNewsletterLabel" aria-hidden="true">
  <div class="modal-bg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container">
          <div class="panel panel-primary table-bg">
            <div class="panel-body">
              <form class="form-horizontal" action="" method="POST">
                <fieldset>
                  <div class="form-group">
                    <label class="col-md-2 control-label">Sent to</label>
                    <div class="col-md-3">
                      <select data-placeholder="Select" class="chosen-select" name="sendto">
                        <option value="everyone"> Everyone</option>
                        <option value="subscribers"> Subscribers</option>
                        <option value="customers"> Customers</option>
                        <option value="managers"> Managers</option>
                        <option value="supplier"> Suppliers</option>
                        <option value="staff"> Staff</option>
                      </select>
                    </div>
                    <label class="col-md-1 control-label">Subject</label>
                    <div class="col-md-3">
                      <input class="form-control" type="text" placeholder="Newsletter Subject" name="subject">
                    </div>

                     <button data-dismiss="modal" aria-hidden="true" class="btn btn-danger pull-right"> Close</button>
          <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-envelope"></i> Send</button>

                  </div>
                </fieldset>
            </div>
          </div>
          <div class="panel panel-primary">
          <textarea class="ckeditor" cols="80" id="editor"  rows="10" name="content">
          <div dir="ltr" style="text-indent: 0px; color: rgb(0, 0, 0); background: #ccc; font-family: Calibri, sans-serif; font-size: 16px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: start; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">
          <div style="text-indent: 0px !important;">
          <div dir="ltr" style="text-indent: 0px !important;">
          <div style="text-indent: 0px !important;">
          <div dir="ltr" style="text-indent: 0px !important;">
          <div style="text-indent: 0px !important;">
          <div dir="ltr" style="text-indent: 0px !important;">
          <div style="text-indent: 0px !important;">
          <table align="center" border="0" cellpadding="0" cellspacing="0" style="text-indent:0px !important; width:650px">
          <tbody>
          <tr>
          <td style="background-color:rgb(246, 246, 246)">
          <table border="0" cellpadding="0" cellspacing="0" style="text-indent:0px !important; width:100%">
          <tbody>
          <tr>
          <td><a href="#"><img class="style1" src="<?php echo $logo;?>" /></a></td>
          </tr>
          <tr>
          <td style="background-color:rgb(255, 255, 255)">
          <table border="0" cellpadding="0" cellspacing="0" style="text-indent:0px !important; width:100%">
          <tbody>
          <tr>
          <td style="background-color:rgb(254, 232, 221); height:30px"><strong><?php echo $sitetitle;?></strong> | <?php echo $hometitle;?></td>
          </tr>
          <tr>
          <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" style="text-indent:0px !important; width:95%">
          <tbody>
          <tr>
          <td>&nbsp;</td>
          </tr>
          <tr>
          <td>Dear Subscriber,<br />
          <br />
          &nbsp;newsletter content goes here<br />
          <br />
          ----------------------------------------------------------------------&nbsp;<br />
          Website : <?php echo base_url();?> <br />
          Email &nbsp; &nbsp; : &nbsp;<?php echo $admin_email;?><br />
          <?php if(!empty($mobile)){
            ?>
          Mobile &nbsp; : &nbsp; <?php echo $mobile;?>
          <?php
            }
            ?>
          </td>
          </tr>
          </tbody>
          </table>
          </td>
          </tr>
          <tr>
          <td style="background-color:rgb(246, 247, 251); height:100px">
          <table align="center" border="0" cellpadding="2" cellspacing="2" style="text-indent:0px !important; width:97%">
          <tbody>
          <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
          <tr>
          <td>Become a <?php echo $sitetitle;?> Fan:</td>
          <td rowspan="2">&nbsp;you are subscriber at :&nbsp;<span style="color:rgb(0, 0, 0); font-family:calibri,sans-serif; font-size:16px"></span><span style="color:rgb(0, 0, 0); font-family:calibri,sans-serif; font-size:16px"><?php echo base_url();?></span><br />
          &nbsp;</td>
          </tr>
          <tr>
          <td> <?php if(!empty($fblink)){?> <img alt="Facebook FanPage" src="<?php echo $fbicon;?>" width="25" height="25" /> &nbsp;<a href="<?php echo $fblink;?>" style="text-indent: 0px !important;" target="_blank">facebook</a> <?php } ?> &nbsp; &nbsp;&nbsp; <?php if(!empty($twitterlink)){?>  <img alt="Twitter FanPage" src="<?php echo $twittericon;?>" width="25" height="25" /> <a href="<?php echo $twitterlink;?>" style="text-indent: 0px !important;" target="_blank">&nbsp;Twitter&nbsp;</a><?php } ?></td>
          </tr>
          </tbody>
          </table>
          </td>
          </tr>
          </tbody>
          </table>
          </td>
          </tr>
          <tr>
          <td>&nbsp;</td>
          </tr>
          </tbody>
          </table>
          </td>
          </tr>
          <tr>
          <td>To ensure delivery of emails from <strong><?php echo base_url();?></strong>, please add <strong><?php echo $admin_email;?></strong>&nbsp; to your contact details&nbsp;</td>
          </tr>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </textarea>
          </div>
          <input type="hidden" name="sendnews" value="1" />

        </div>
      </div>
    </div>
  </div>
</div>
</form>
<style>
.cke_contents { height: 375px !important; }
</style>