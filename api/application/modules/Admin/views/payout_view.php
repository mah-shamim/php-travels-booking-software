<style>
.btn { margin-right:10px }
#select_all,.checkboxcls,#deleteAll {display:none}

</style>
<div class="panel panel-default">
  <div class="panel-heading"><?php echo $header_title; ?></div>
   <div class="panel-body">

    <div class="btn-group pull-left" style="position: relative; z-index: 1; padding: 15px;">
    <a href="<?php echo base_url(); ?>admin/payouts/unpaid/<?php $link = $_SERVER['PHP_SELF']; $link_array = explode('/',$link); echo $page = end($link_array); ?>" class="btn btn-warning"><i class="fa fa-money"></i> &nbsp; Unpaid </a>
    <a href="<?php echo base_url(); ?>admin/payouts/paid/<?php $link = $_SERVER['PHP_SELF']; $link_array = explode('/',$link); echo $page = end($link_array); ?>" class="btn btn-success"><i class="fa fa-money"></i> &nbsp; Paid </a>
    </div>

    <?php echo $content; ?>
   </div>
 </div>