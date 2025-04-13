<script type="text/javascript">
  $(function(){


  // Delete Theme

  $(".deleteit").click(function(){

                var id =  $(this).attr('id');
                var themename =  $(this).attr('name');
                 var currenttheme = $("#currenttheme").val();



   $.alert.open('confirm', 'Are you sure you want to Remove', function(answer) {
    if (answer == 'yes')

  $.post("<?php echo base_url();?>admin/ajaxcalls/remove_theme", { themename: themename }, function(theResponse){

    $("#div_"+id).fadeOut('slow');
         if(themename == currenttheme ){
           location.reload();

         }

  	});


  });

  });

  // Select theme

  $(".btnimg").click(function(){

   var themename = $(this).attr('name');

   $(".btnimg").removeClass('current btn-success');
    $(".btnimg").addClass('selectit btn-warning');
  $(".btnimg").html('<i class="fa fa-plus"></i> Activate');

  if($(this).hasClass('selectit')){
   $(this).addClass('current btn-success');
  $(this).removeClass('selectit btn-warning');
  $(this).html('<i class="fa fa-check"></i> Current Theme');

  }
  $("#currenttheme").val(themename);


  $.post("<?php echo base_url();?>admin/ajaxcalls/select_theme", {themename: themename }, function(theResponse){

         $.notify("Changes Saved","success");

  	});


  });



  });


</script>
<div class="<?php echo body;?>">
  <div class="col-sm-12">
    <div class="alert alert-success" style="display:none;">
    </div>
    <!--upload theme-->
    <?php
      echo @$msg;
      ?>
    <!--
      <div class="panel white">
      <div class="panel-body">

       <div class="col-md-6">
       <h3>Upload Theme</h3>
       </div>

      <form class="form-horizontal" action="" method="POST" method="POST" enctype="multipart/form-data">

      <div class="col-md-4">
      <input type="file" class="btn btn-primary" id="hlogo" name="zip_file">
      <input type="hidden" name="uploadtheme" value="1"/>
      </div>

      <div class="col-md-2">
      <button class="btn btn-primary" type="submit">
      <i class="fa fa-upload"></i> Upload Theme</button>
      </div>

      <div class="clearfix"></div>
      </form>
      </div>
      </div>-->
    <!--upload theme-->
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="fa fa-file-image-o"></span> Themes</h3>
      </div>
      <div class="panel-body">
        <input type="hidden" id="currenttheme" value="<?php echo $currtheme;?>" />
        <?php
          $themes = directory_map('./themes/',2);
             $count = 0;
               foreach($themes as $theme => $v ){
              $count++;
              @$themeinfo = pt_get_file_data( "themes/$theme/style.css" );

            //  print_r($themeinfo);
          ?>
        <div class="row" id="div_<?php echo $count;?>">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="well well-sm">
              <div class="row">
                <div class="col-sm-6 col-md-3">
                  <?php
                    if(file_exists("themes/$theme/screenshot.png")){
                    ?>
                  <a class="colorbox" href="<?php echo base_url();?>themes/<?php echo $theme;?>/screenshot.png">
                  <img class="img-rounded img-responsive" src="<?php echo base_url();?>themes/<?php echo $theme;?>/screenshot.png"  >
                  </a>
                  <?php
                    }else{
                    ?>
                  <img class="img-rounded img-responsive" src="<?php echo PT_DEFAULT_IMAGE.'screenshot.png';?>"  >
                  <?php
                    }

                    ?>
                </div>
                <div class="col-sm-6 col-md-7">
                  <?php
                    if(!empty($themeinfo['Name'])){
                    ?>
                  <h1><strong><?php echo $themeinfo['Name'];?></strong></h1>
                  <p><strong>Theme Name</strong>  : <?php echo $themeinfo['Name'];?></p>
                  <p><strong>Description</strong> :<?php echo $themeinfo['Description'];?></p>
                  <p><strong>Author</strong> :<a href="<?php echo $themeinfo['AuthorURI'];?>" target="_blank"> <?php echo $themeinfo['Author'];?></a></p>
                  <p><strong>Version</strong> :  <?php echo $themeinfo['Version'];?></p>
                  <?php
                    }

                    ?>
                </div>
                <div class="col-md-6">
                  <?php
                    if($currtheme == $theme){
                    ?>
                  <span class="btn btn-success btn-sm btnimg current"  name="<?php echo $theme;?>"  ><i class="fa fa-check"></i> Current Theme</span>
                  <?php
                    }else{
                    ?>
                  <span class="btn btn-warning btn-sm btnimg selectit" name="<?php echo $theme;?>" ><i class="fa fa-plus"></i> Activate</span>
                  <?php
                    }

                    ?>
                  <?php
                    if($theme == 'default'){


                    }else{
                    ?>
                  <span  class="btn btn-danger btn-sm deleteit" id="<?php echo $count;?>" name="<?php echo $theme;?>"><i class="fa fa-times"></i> Delete Theme</span>
                  <?php
                    }
                    ?>
                </div>
                <!--<div class="col-md-1">
                  <a style="padding:10px" href="<?php echo base_url(); ?>themes/default/screenshot.png"><img src="<?php echo base_url(); ?>themes/default/screenshot.png" alt="" class="img-rounded img-responsive thumbnail colorbox" /></a>
                  </div>

                  <div class="col-md-1">
                  <a style="padding:10px" href="<?php echo base_url(); ?>themes/default/screenshot.png"><img src="<?php echo base_url(); ?>themes/default/screenshot.png" alt="" class="img-rounded img-responsive thumbnail colorbox" /></a>
                  </div>

                  <div class="col-md-1">
                  <a style="padding:10px" href="<?php echo base_url(); ?>themes/default/screenshot.png"><img src="<?php echo base_url(); ?>themes/default/screenshot.png" alt="" class="img-rounded img-responsive thumbnail colorbox" /></a>
                  </div>-->
              </div>
            </div>
          </div>
        </div>
        <?php
          }
          ?>
      </div>
    </div>
  </div>
</div>