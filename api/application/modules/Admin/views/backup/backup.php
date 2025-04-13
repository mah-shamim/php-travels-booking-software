<script type="text/javascript">
    $(function(){ slideout();
    var baseurl = $('base').attr('href');
    //create Backup
    $(".createbackup").click(function(){
        $.alert.open('confirm', 'Are you sure you want to Create Backup', function(answer) {
            if(answer == 'yes'){

                $.post("<?php echo base_url();?>admin/backup/get_backup", {}, function(theResponse){   window.location = baseurl+"admin/backup/redirectBackup"; }); } }); });

    //delete database backup
    $(".del_backup").click(function(){
        var id = $(this).attr('id');
        $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) { if (answer == 'yes')
            $.post("<?php echo base_url();?>admin/backup/remove_backup", { bkid: id }, function(theResponse){ window.location = baseurl+"admin/backup/redirectBackup";	}); }); });

    //restore backup
    $(".restorebackup").click(function(){
        var sqlfile = $('#dbase').val();
        $.alert.open('confirm', 'Are you sure you want to Restore Backup', function(answer) { if (answer == 'yes')
            $('#pt_reload_modal').modal('show');
            $.post("<?php echo base_url();?>admin/backup/restore_backup", { sqlfile: sqlfile }, function(theResponse){  $('#pt_reload_modal').modal('hide');   window.location = baseurl+"admin/backup/redirectBackup";	}); }); });

    //reset database
    $(".resetdata").click(function(){
        var code = $('#code').val();
        $("#resetresult").removeClass();
        $("#resetresult").addClass("btn btn-warning").html("Please Wait...");
        $.post("<?php echo base_url();?>admin/backup/reset_database", { code: code }, function(theResponse){

    if($.trim(theResponse) == "1"){
    $("#resetresult").removeClass();
    $("#resetresult").addClass("btn btn-success").html("Reseted Successfully, Redirecting Please Wait...");
    window.location = baseurl+"admin/backup/redirectBackup";
    }else{ $("#resetresult").addClass("btn btn-danger").html("Incorrect Answer"); }

    });
    });  })

</script>
<?php $flashmsg = $this->session->flashdata('flashmsgs'); if (!empty ($flashmsg)) {echo NOTIFY;}?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Backup Database </h3>
    </div>
    <div class="panel-body">
        <?php $errmsg = $this->session->flashdata('errormsg');if (!empty ($errmsg)) {?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('errormsg');?></div>
        <?php
            } ?>
        <p><i class="fa fa-info-circle"></i> Make sure your database is backed up frequently. Click on Create backup to manually backup your database.
            The backups are stored in the <b>[ /backups/ ]</b> folder located on root of your script files, the SQL database file can be downloaded from the below.
        </p>
        <nav class="navbar navbar-default" style="height: 54px;">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="javascript:void(0)" style="color:#000 !important;padding: 16px;">Viewing Most Recent Backups</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="navbar-form navbar-right" style="padding: 4px;">
                        <a href="<?php echo base_url();?>admin/backup/create" class="btn btn-success pull-right"> Create Backup</a>
                        <button data-toggle="modal" href="#resetdatabase" class="btn btn-danger pull-right"> Reset Database</button>
                    </div>
                    <form class="navbar-form navbar-right" style="padding: 4px;" method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" class="btn btn-default" name="datasqlfile" required />
                        </div>
                        <input type="hidden" name="upload" value="1" />
                        <button type="submit" class="btn btn-default">Upload</button>
                    </form>
                </div>
            </div>
        </nav>
        <table class="table table-striped table-responsive table-bordered">
            <thead style="font-weight:bold;text-transform:uppercase;letter-spacing:1px;">
                <tr>
                    <td style="padding:14px;">Date</td>
                    <td style="padding:14px;">Download</td>
                    <td style="padding:14px;">Delete</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $bkups = directory_map('./backups/', 1);
                    arsort($bkups);
                    if (!empty ($bkups)) {
                        foreach ($bkups as $bk) {
                            $info = get_file_info('./backups/' . $bk);
                            ?>
                <tr>
                    <td style="padding:14px"><?php echo date("F j, Y H:i:s", $info['date']);?></td>
                    <td>
                        <button type="button" class="btn btn-default btn-block">
                        <strong><i class="fa fa-download"></i> <a style="color:#000" href="<?php echo base_url();?>admin/backup/download/?backup=<?php echo $bk;?>">Download</a></strong>
                        </button>
                    </td>
                    <td><button class="btn btn-danger del_backup" id="<?php echo $bk;?>"><i class="fa fa-times"></i> <span style="color:#fff">Delete</span></button></td>
                </tr>
                <?php }}else {?>
                <div class="alert alert-danger">
                    <p>No Backups Created Yet</p>
                </div>
                <?php }?>
                <div class="clearfix"></div>
            </tbody>
        </table>
        <?php if (!empty ($bkups)) {?>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">Restore Database</a>
                </div>
                <div class="collapse navbar-collapse" style="padding:4px">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <select type="text" class="form-control" id="dbase" placeholder="Search">
                            <?php
                                foreach ($bkups as $bk) {
                                    $bkname = explode(".sql", $bk);
                                    echo "<option value='" . $bk . "'>" . $bkname[0] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <span class="btn btn-primary restorebackup">Restore Backup</span>
                    </form>
                </div>
            </div>
        </nav>
        <?php }?>
    </div>
</div>
<div class="modal fade" id="resetdatabase" tabindex="-1" role="dialog" aria-labelledby="resetdatabase" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Are you sure!</h4>
            </div>
            <div class="modal-body">
                By Reset Database you will lose your all websites material including text, images, videos, and all your business content please make double sure before you proceed.
                <hr>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 control-label">2 + 9 = </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input class="form-control" id="code" type="text" placeholder="Result" name="code" value="">
                            </div>
                            <div class="input-group">
                                <br><span id="resetresult"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary resetdata">Go Ahead</button>
            </div>
        </div>
    </div>
</div>