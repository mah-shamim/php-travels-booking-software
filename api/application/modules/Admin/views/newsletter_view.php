<div class="panel panel-default">
  <div class="panel-heading"><?php echo $header_title; ?></div>
   <div class="panel-body">
     <?php echo $content; ?>
   </div>

	<div class="panel-footer">
	<?php if(@$addpermission){ ?>
   <form action="<?php echo $add_link; ?>" method="post"><button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Send Newsletter</button></form>
    <?php } ?>
	</div>

 </div>