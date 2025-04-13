<style>
.tabs-left > .nav-tabs .active > a, .tabs-left > .nav-tabs .active > a:hover, .tabs-left > .nav-tabs .active > a:focus {
border-color: #FFF transparent #FFF #FFF;
}

.tabs-left > .nav-tabs > li > a {
margin-right: -1px;
-webkit-border-radius: 0px 0 0 0px;
-moz-border-radius: 0px 0 0 0px;
border-radius: 0px 0 0 0px;
}

</style>

<div class="<?php echo body;?>">
 <?php if($this->session->flashdata('flashmsgs')){ echo NOTIFY; } ?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <span class="panel-title pull-left"><i class="fa fa-list-alt"></i> Translate Post " <strong> <?php   echo $transtitle; ?></strong> "</span>
      <div class="pull-right">
        <?php echo PT_BACK; ?>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="tabbable tabs-left">
      <ul class="nav nav-tabs" style="height:850px;background-color:#F2F2F2;margin-top:5px;margin-bottom:0px">
        <?php if(!empty($language_list)){
          foreach($language_list as $ldir => $lname){ ?>
        <li class="<?php if($ldir == $lang){ echo "active"; } ?>"><a href="<?php echo base_url()."admin/blog/translate/".$slug."/".$ldir;?>"><img src="<?php echo PT_LANGUAGE_IMAGES.$ldir.".png";?>" style="width:30px;height:25px" alt="" /> <?php echo $lname; ?></a></li>
        <?php } } ?>
      </ul>
      <div class="tab-content">
      <form action="" method="POST">
        <div class="tab-pane fade active in" id="english">
          <div class="panel-body" style="margin-left:150px;padding-bottom:0px">
            <div class="panel panel-primary">
              <div class="panel-heading"><strong>Name</strong></div>
              <div style="margin-bottom: 0px;">
                <input class="form-control input-lg" type="text" placeholder="Type name here" name="title" value="<?php  echo $transtitle; ?>">
              </div>
            </div>
            <div class="panel panel-primary" >
              <div class="panel-heading"><strong>Description</strong></div>
              <?php $this->ckeditor->editor('desc', $transdesc, $ckconfig,'desc'); ?>
            </div>
           <?php if(!empty($blogdata)){ ?>
           <?php if($lang != DEFLANG){ ?>
            <input type="hidden" name="transid" value="<?php echo $transid; ?>" />
           <?php } ?>
            <input type="hidden" name="postid" value="<?php echo $postid; ?>" />
            <input type="hidden" name="update" value="1" />
            <button type="submit" class="btn btn-primary pull-right" ><i class="fa fa-plus-square"></i> Update</button>
          <?php  }else{ ?>
             <input type="hidden" name="langname" value="<?php echo $lang; ?>" />
            <input type="hidden" name="postid" value="<?php echo $postid; ?>" />
            <input type="hidden" name="add" value="1" />
            <button type="submit" class="btn btn-primary pull-right" ><i class="fa fa-plus-square"></i> Add</button>
          <?php  } ?>

           </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>