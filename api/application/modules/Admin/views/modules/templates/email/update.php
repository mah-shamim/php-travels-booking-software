<form action="" method="POST">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title pull-left">Edit Template </span>
                <div class="pull-right">
                    <?php echo PT_BACK; ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <label>Template Title</label> <input type="text" class="form-control" name="title" value="<?php echo $details[0]->temp_title;?>" />
                <br>
                <label>Subject</label>  <input type="text" class="form-control" name="subject" value="<?php echo $details[0]->temp_subject;?>" />
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Email</strong></div>
                    <?php $this->ckeditor->editor('tempbody', $details[0]->temp_body, $ckconfig,'tempbody'); ?>
                </div>
                <input type="hidden" name="tempname" value="<?php echo $details[0]->temp_name;?>" />
                <input type="hidden" name="update" value="1" />
            </div>
            <div class="panel-footer">
                <button type="submit" class="btn btn-primary btn-block btn-lg"> Update </button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Text Veriables</div>
            <div class="panel-body">
                <?php if(!empty($details[0]->temp_vars)){ ?>
                <textarea name="" id="" cols="30" rows="10" class="form-control"><?php echo $details[0]->temp_vars;?></textarea>
                <?php } ?>
            </div>
        </div>
    </div>
</form>