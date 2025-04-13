<div class="panel panel-default">

  <div class="panel-heading">

    <span class="panel-title pull-left">Edit Template </span>

    <div class="pull-right">

      <?php echo PT_BACK; ?>

    </div>

    <div class="clearfix"></div>

  </div>

  <div class="panel-body">

    <form action="" method="POST">

      <label>Template Title</label> <input type="text" class="form-control" name="title" value="<?php echo $details[0]->temp_title;?>" />

      <br>

      <label>Subject</label>  <input type="text" class="form-control" name="subject" value="<?php echo $details[0]->temp_subject;?>" />

      <br><?php if(!empty($details[0]->temp_vars)){ ?>

      <label>Shortcode Variables</label>

      <div class="well well-sm" style="margin-bottom:0px">

        <span>

        <?php echo $details[0]->temp_vars;?>

        </span>

      </div>

      <?php } ?>

      <br>

      <br>

      <div class="panel panel-default">

        <div class="panel-heading"><strong>SMS</strong></div>

        <?php $this->ckeditor->editor('tempbody', $details[0]->temp_body, $ckconfig,'tempbody'); ?>

      </div>

      <input type="hidden" name="tempname" value="<?php echo $details[0]->temp_name;?>" />

      <input type="hidden" name="update" value="1" />

      <button type="submit" class="btn btn-primary" > Update </button>

    </form>

  </div>

</div>