 <div class="panel-body">
     <form action="" method="POST">
       <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = $sliderlib->getBackTranslation($lang,$slideid); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" /> <?php echo $val['name']; ?></div>
                        <div class="panel-body">
                            <div class="row form-group">
                                <label class="col-md-2 control-label text-left">Title Text</label>
                                <div class="col-md-4">
                                    <input name='<?php echo "translated[$lang][title]"; ?>' type="text" placeholder="Title Text" class="form-control" value="<?php echo @$trans[0]->trans_title;?>" />
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-2 control-label text-left">Description Text</label>
                                <div class="col-md-10">
                                 <input name='<?php echo "translated[$lang][desc]"; ?>' type="text" placeholder="Description Text" class="form-control" value="<?php echo @$trans[0]->trans_desc;?>" />

                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-2 control-label text-left">Optional Text</label>
                                <div class="col-md-10">
                                 <input name='<?php echo "translated[$lang][optional]"; ?>' type="text" placeholder="Optional Text" class="form-control" value="<?php echo @$trans[0]->trans_optional;?>" />

                                </div>
                            </div>

                        </div>
                    </div>
                    <?php } } ?>
                     <div class="panel-footer">
           <input type="hidden" id="slideid" name="slideid" value="<?php echo $slideid;?>" />

            <input type="hidden" name="update" value="1" />
            <button class="btn btn-primary">Submit</button>
        </div>
                    </form>

</div>