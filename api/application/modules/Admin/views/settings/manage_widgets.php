<div class="panel panel-default">
  <div class="panel-body">
    <form action="" method="POST">
      <label>Widget Name</label> <input type="text" class="form-control" name="title" value="<?php echo $details[0]->widget_name;?>" />
      <br>
      <label>Widget Status</label>  

                      <select data-placeholder="Select" name="status" class="form-control" tabindex="2">
                        <option value="Yes" <?php if($details[0]->widget_status == "Yes"){ echo "selected";} ?> >Enable</option>
                        <option value="No" <?php if($details[0]->widget_status == "No"){ echo "selected";} ?>>Disable</option>
                      </select>
    
      <br>
      <div class="panel panel-default">
        <div class="panel-heading"><strong>Widget Content</strong></div>
        <?php $this->ckeditor->editor('widgetbody', $details[0]->widget_content, $ckconfig,'widgetbody'); ?>
      </div>
      <input type="hidden" id="pageid" name="widgetid" value="<?php echo $widgetid;?>" />
      <input type="hidden" name="action" value="<?php echo $action; ?>" />
      <button type="submit" class="btn btn-primary" > <?php echo ucfirst($action);?> </button>
    </form>
  </div>
</div>