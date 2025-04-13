<h3 class="margin-top-0"><?php echo $headingText;?></h3>

    <div class="output"></div>
<form action="" method="POST" class="hotel-form" enctype="multipart/form-data" onsubmit="return false;" >
    <div class="panel panel-default">

        <div class="panel-body">

            <br>
                <div class="tab-pane wow fadeIn animated in" id="TRANSLATE">

                    <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getBackSuppTranslation($lang,$suppid); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val; ?></div>
                        <div class="panel-body">
                            <div class="row form-group">
                                <label class="col-md-2 control-label text-left"><strong>Title</strong></label>
                                <div class="col-md-4">
                                    <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="Supplement Name" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-2 control-label text-left">Supplement Description</label>
                                <div class="col-md-10">
                              <textarea name='<?php echo "translated[$lang][desc]"; ?>' placeholder="Description..." class="form-control" id="" cols="30" rows="4"><?php echo @$trans[0]->trans_desc;?></textarea> 

                                </div>
                            </div>


                        </div>
                    </div>
                    <?php } } ?>

                </div>

        </div>
        <div class="panel-footer">

            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>