<div class="<?php echo body;?>">
   <?php if(isset($successmsg)){ echo NOTIFY; }
            $validationerrors = validation_errors();
             if(isset($errormsg) || !empty($validationerrors)){
             ?>
            <div class="alert alert-danger">
                  <i class="fa fa-times-circle"></i>
            <?php
            echo @$errormsg;
            echo $validationerrors; ?>
            </div>
            <?php
            }
            ?>
  <form class="form-horizontal" method="post" action="">
    <div class="panel panel-primary table-bg">
      <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-list-alt"></i>  Edit CMS Page in <strong><?php echo pt_language_name($langid);?></strong> Language</span>
        <div class="pull-right">
          <?php echo PT_BACK; ?>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-body">
        <div class="col-lg-3 col-md-3" style="background-color:#FCFCFC;padding:10px;border-radius:3px;border: #E0E0E0 1px solid;;">
          <fieldset>
            <div class="form-group">
              <label for="form-input" class="col-sm-2 control-label">Title</label>
              <div class="col-sm-10">
				  <input class="form-control" type="text" name="pagetitle" placeholder="Page title" value="<?php echo @$tpage_content[0]->content_page_title;?>">
              </div>
            </div>

            <div class="form-group">
              <label for="form-input" class="col-sm-3 control-label">Keywords</label>
              <div class="col-sm-9">
											<input class="form-control" type="text" name="keywords" value="<?php echo @$tpage_content[0]->content_meta_keywords; ?>" placeholder="Keywords">
              </div>
            </div>
            <div class="form-group">
              <label for="form-input" class="col-sm-3 control-label">Description</label>
              <div class="col-sm-9">
											<input class="form-control" type="text" name="pagedesc" value="<?php echo @$tpage_content[0]->content_meta_desc;?>" placeholder="Description">
              </div>
            </div>

          </fieldset>
        </div>
        <div class="col-lg-9 col-md-9">
             <?php $this->ckeditor->editor('pagebody', $tpage_content[0]->content_body, $ckconfig,'pagebody'); ?>


             <?php
            if(empty($tpage_content)){
           ?>

           <input type="hidden" name="add_trans" value="1" />
           <button style="margin-top:10px" class="btn btn-primary pull-right" ><i class="fa fa-plus-square"></i> Add Content</button>
               	</div>
           <?php

            }else{
            ?>
             <input type="hidden" name="contentid" value="<?php echo @$tpage_content[0]->content_id;?>" />
            <input type="hidden" name="update_trans" value="1" />
            <button style="margin-top:10px" class="btn btn-primary pull-right" ><i class="fa fa-plus-square"></i> Update Content </button>
            <?php
            }
            ?>

        </div>
      </div>
      </form>
    </div>

