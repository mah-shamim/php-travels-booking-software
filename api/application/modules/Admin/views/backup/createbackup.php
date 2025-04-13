
<script type="text/javascript">

  $(function(){ 
    slideout();
var baseurl = $('base').attr('href');
  //create Backup
  $(".createbackup").click(function(){
    $.alert.open('confirm', 'Are you sure you want to Create Backup', function(answer) {
      if(answer == 'yes'){
       
        $.post("<?php echo base_url();?>admin/backup/get_backup", {}, function(theResponse){   window.location = baseurl+"admin/backup/redirectBackup"; }); } }); 
                            });

 })

</script>
<?php $flashmsg = $this->session->flashdata('flashmsgs'); if (!empty ($flashmsg)) {echo NOTIFY;}?>
<div class="panel panel-default">
  <form method="POST" action="">
  <div class="panel-heading">
    <h3 class="panel-title">Create Backup </h3>
  </div>
  <div class="panel-body">
    <?php $errmsg = $this->session->flashdata('errormsg');if (!empty ($errmsg)) { ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('errormsg');?></div>
    <?php  } ?>
    <p>
    <label>Total Tables: </label> <?php echo count($dbtables['all']); ?>&nbsp;
    <label>Total Rows: </label> <?php echo $dbtables['totalRows']; ?>
    <label>Total Size: </label> <?php echo $dbtables['totalSize']; ?>
    </p>
    
    <p>Please Select Tables you want backup for</p>

<table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-striped table-bordered">
      <thead>
        <tr>
          <th style="width:50px;"><input class="all" type="checkbox" value="" id="select_all"></th>
          <th ><span class="fa fa-laptop" data-toggle="tooltip" data-placement="top" title="Table Name"></span> Table Name</th>
          <th>Total Rows</th>
          <th>Size</th>
       
        </tr>
      </thead>
      <tbody>
    
       <?php foreach($dbtables['all'] as $t){ ?>
    <tr>
      <td>
        <input type="checkbox" class="form-control checkboxcls" name="dbtables[]" value="<?php echo $t->name; ?>" checked>
      </td>
      <td> <?php echo $t->name; ?> </td>
      <td> <?php echo $t->rows; ?> </td>
      <td> <?php echo $t->size; ?> </td>
    </tr>     
    <?php } ?>
    

      </tbody>
      <tfoot>
        <tr>
      <th></th>
      <th class="text-right">Total:</th>
      <th><?php echo $dbtables['totalRows']; ?></th>
      <th><?php echo $dbtables['totalSize']; ?></th>
    </tr> 
      </tfoot>
    </table>
    
       
      </div>
      <div class="panel-footer">
<input type="hidden" name="getbackup" value="1"/>
<button class="btn btn-primary">Get Backup</button>
</div>
</form>
    </div>