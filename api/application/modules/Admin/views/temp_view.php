    <style>
    td span {width: 100%;font-weight: bold;}
    </style>

    <div class="panel panel-default">
     
    <div class="panel-heading"><?php echo $header_title; ?></div>
    <?php if(@$addpermission && !empty($add_link)){ ?>
    <form class="add_button" action="<?php echo $add_link; ?>" method="post"><button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add</button></form>
    <?php } ?>
    <div class="panel-body">
    <?php echo $content; ?>
    </div>
    </div>

    <script>
    function show_packages(id){
    var base_url = "<?=base_url()?>";
    $('#iframe').attr('src',base_url+'admin/tours/dates?id='+id);
    $('#packages').modal('show');
    }
    </script>
    <div id="packages" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="padding-left: 250px;width:100%; margin: 0px; height: 100vh;">
    <!-- Modal content-->
    <div class="modal-content" style="border-radius: 0px; border: 0px;">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><strong>Tour Packages</strong></h4>
    </div>
    <div class="modal-body" style="background:#f7f7f7">
    <iframe id="iframe" style="width:100%;height:80vh" src="" frameborder="0" scrolling="no"></iframe>
    </div>
    </div>
    <div class="panel-footer" style="position:fixed;bottom:0px;width:100%;background:#fff">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </div>
    </div>