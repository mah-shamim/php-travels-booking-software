<script>
  $(function(){

        slideout();

    $('.del_selected').click(function(){
      var pages = new Array();
      $("input:checked").each(function() {
           pages.push($(this).val());
        });
      var count_checked = $("[name='page_ids[]']:checked").length;
      if(count_checked == 0) {
      $.alert.open('info', 'Please select a page to Delete.');
        return false;
         }


  $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
    if (answer == 'yes')


  $.post("<?php echo base_url();?>admin/ajaxcalls/delete_multiple_pages", { pagelist: pages }, function(theResponse){

                    location.reload();


  	});


  });



    });

        // Disable multiple pages
        $('.disable_selected').click(function(){
      var pages = new Array();
      $("input:checked").each(function() {
           pages.push($(this).val());
        });
      var count_checked = $("[name='page_ids[]']:checked").length;
      if(count_checked == 0) {
         $.alert.open('info', 'Please select a page to Disable.');
        return false;
         }


           $.alert.open('confirm', 'Are you sure you want to Disable it', function(answer) {
    if (answer == 'yes')



  $.post("<?php echo base_url();?>admin/ajaxcalls/disable_multiple_pages", { pagelist: pages }, function(theResponse){

                    location.reload();


  	});


  });

  });


    // Enable multiple pages
          $('.enable_selected').click(function(){
      var pages = new Array();
      $("input:checked").each(function() {
           pages.push($(this).val());
        });
      var count_checked = $("[name='page_ids[]']:checked").length;
      if(count_checked == 0) {

        $.alert.open('info', 'Please select a page to Enable.');
       return false;
         }


         $.alert.open('confirm', 'Are you sure you want to Enable it', function(answer) {
    if (answer == 'yes')


  $.post("<?php echo base_url();?>admin/ajaxcalls/enable_multiple_pages", { pagelist: pages }, function(theResponse){

                    location.reload();


  	});


  });



    });


    // Delete single Page
    $(".del_single").click(function(){
   var id = $(this).attr('id');


       $.alert.open('confirm', 'Are you sure you want to delete', function(answer) {
    if (answer == 'yes')


  $.post("<?php echo base_url();?>admin/ajaxcalls/delete_single_page", { pageid: id }, function(theResponse){

                    location.reload();


  	});


  });



    });

  })


</script>
<div class="<?php echo body;?>">
  <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary table-bg">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-list-alt"></i> CMS Pages Management</span>
      <div class="pull-right">
        <a <a href="<?php echo base_url();?>admin/cms/pages/add"><?php echo PT_ADD; ?></a>
        <span class="del_selected">   <?php echo PT_DEL_SELECTED; ?></span>
        <span class="disable_selected">   <?php echo PT_DIS_SELECTED; ?></span>
        <span class="enable_selected">   <?php echo PT_ENA_SELECTED; ?></span>
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <table cellpadding="0" cellspacing="0" border="0" class="datatable table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th style="width:50px;"><input class="pointer" type="checkbox" data-toggle="tooltip" data-placement="top" title="Select All" id="select_all" /></th>
            <th><span class="fa fa-file-o" data-toggle="tooltip" data-placement="top" title="Page Name"></span> Page Name</th>
            <th><i class="fa fa-bars" data-toggle="tooltip" data-placement="top" title="In Header"></i> Header Menu</th>
            <th><i class="fa fa-columns" data-toggle="tooltip" data-placement="top" title="In Footer"></i> Footer Menu</th>
            <th><i class="fa fa-flag" data-toggle="tooltip" data-placement="top" title="Translate This Page"></i> Translate</th>
            <th><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Status">&nbsp;</i></th>
            <th><i class="fa fa-wrench" data-toggle="tooltip" data-placement="top" title="Action"></i> Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(!empty($all_pages))
            {
            foreach($all_pages as $page){
            ?>
          <tr class="">
            <td><input type="checkbox" name="page_ids[]" value="<?php echo $page->page_id;?>" class="selectedId" /></td>
            </td>
            <td><a href="<?php echo base_url();?>admin/cms/pages/edit/<?php echo $page->page_id;?>" ><?php echo $page->content_page_title;?></a>  </td>
            <td>
              <?php
                if($page->page_header_menu == '0'){
                ?>
              No
              <?php
                }elseif($page->page_header_menu == '1'){
                ?>
              Yes
              <?php
                }
                ?>
            </td>
            <td>
              <?php
                if($page->page_footer_col == '0'){
                ?>
              No
              <?php
                }elseif($page->page_footer_col > 0 && $page->page_footer_col < 6 ){
                echo "Col ".$page->page_footer_col;

                }elseif($page->page_footer_col == 6 ){
                echo "Horizontal ".$page->page_footer_col;

                }
                ?>
            </td>
            <td>
              <span class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-globe"></span> Select Language <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <?php
                    foreach($all_languages as $ldir => $lname){
                    ?>
                  <li><a href="<?php echo base_url();?>admin/cms/pages/translate/<?php echo $page->page_id;?>/<?php echo $ldir;?>"><img src="<?php echo PT_LANGUAGE_IMAGES.$ldir.'.png';?>" width="20" height="15" alt="" /> <?php echo $lname;?></a></li>
                  <?php
                    }

                    ?>
                </ul>
              </span>
            </td>
            <td>
              <?php
                if($page->page_status == 'No'){
                ?>
              <span class="times "><i class="fa fa-times"  data-toggle="tooltip" data-placement="top" title="Disabled"></i></span>
              <?php
                }elseif($page->page_status == 'Yes'){
                ?>
              <span class="check"><i class="fa fa-check"  data-toggle="tooltip" data-placement="top" title="Enabled"></i></span>
              <?php
                }
                ?>
            </td>
            <td align="center">
              <a href="<?php echo base_url();?>admin/cms/pages/edit/<?php echo $page->page_id;?>" class="btn btn-xs btn-warning"><i class="fa fa-external-link"></i> edit</a>
               <span class="btn btn-xs btn-danger del_single" id="<?php echo $page->page_id;?>"><i class="fa fa-times"></i> delete</span>
          </tr>
          <?php
            }
             }

             ?>
        </tbody>
      </table>
    </div>
  </div>
</div>