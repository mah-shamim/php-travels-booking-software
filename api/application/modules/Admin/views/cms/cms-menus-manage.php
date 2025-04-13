<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.nestable.js"></script>
<script type="text/javascript">
    $(function () {
        $("#hextlink").hide();

        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                console.log(window.JSON.stringify(list.nestable('serialize')));
                var menuid = $("#menuid").val();
                $.post("<?php echo base_url();?>admin/ajaxcalls/updateitemsorder", {menuitems: window.JSON.stringify(list.nestable('serialize')), menuid: menuid}, function(theResponse){
                    new PNotify({
                        title: 'Done!',
                        type: 'info',
                        addclass: "stack-bar-top dan",
                        animate_speed: "fast",
                        width: "150px",
                        remove: true,
                        animation: 'fade'
                    });
                    console.log(theResponse);

                });


            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        $('#nestable').nestable(
            {
                maxDepth: 2,
                listNodeName: 'ul'
            }
        ).on('change', updateOutput);


        // Delete menu
        $(".delmenu").click(function(){

            var id = $(this).prop("id");

            $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
                if (answer == 'yes'){
                    $.post("<?php echo base_url();?>admin/ajaxcalls/delmenu", { id: id }, function(theResponse){
                        window.location.href=window.location.href;
                    });   }  }); });

        // Remove Item from menu
        $(".removemenu").click(function(){

            var pageid = $(this).prop("id");

            $.alert.open('confirm', 'Are you sure you want to Remove it', function(answer) {
                if (answer == 'yes'){
                    $("#listorder_"+pageid).remove();
                    $('#nestable').trigger('change');

                }  });

        });

        //delete single submenu item

        $(".del_sub_menu").click(function(){
            var id = $(this).attr('id');
            var type = $(this).data('submenu');

            $.alert.open('confirm', 'Are you sure you want to Delete it', function(answer) {
                if (answer == 'yes')


                    $.post("<?php echo base_url();?>admin/ajaxcalls/delete_submenu_item", { id: id, type: type }, function(theResponse){

                        location.reload();


                    });

            });

        });


    });

    function slideoutresponse(){
        setTimeout(function(){
            $("#response").slideUp("slow", function () {
            });

        }, 5000);}



</script>
<style type="text/css">
    .cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
    * html .cf { zoom: 1; }
    *:first-child+html .cf { zoom: 1; }
    h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }
    a { color: #2996cc; }
    a:hover { text-decoration: none; }
    p { line-height: 1.5em; }
    .small { color: #666; font-size: 0.875em; }
    .large { font-size: 1.25em; }
    /**
    * Nestable
    */
    .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
    .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
    .dd-list .dd-list { padding-left: 30px; }
    .dd-collapsed .dd-list { display: none; }
    .dd-item,
    .dd-empty,
    .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
    .dd-handle {
        display: block;
        height: 34px;
        margin: 10px 0;
        padding: 7px 11px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
        border: 1px solid #ccc;
        background: #F9F9F9;
        background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background: linear-gradient(top, #fafafa 0%, #eee 100%);
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        font-weight: 300;
    }
    .dd-handle:hover { color: #2ea8e5; background: #fff; cursor:pointer; }
    .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
    .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
    .dd-item > button[data-action="collapse"]:before { content: '-'; }
    .dd-placeholder,
    .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
    .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
        -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
        -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
        linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }
    .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
    .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
    }
    /**
    * Nestable Extras
    */
    .nestable-lists { display: block; clear: both; padding: 0px 0; width: 100%; border: 0; }
    #nestable-menu { padding: 0; margin: 20px 0; }
    #nestable-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }
    @media only screen and (min-width: 700px) {
        .dd { float: left; width:100%; }
        .dd + .dd { margin-left: 2%; }
    }
    .dd-hover > .dd-handle { background: #2ea8e5 !important; }
    /**
    * Nestable Draggable Handles
    */
    .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:         linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box; -moz-box-sizing: border-box;
    }
    .dd3-content:hover { color: #2ea8e5; background: #fff; }
    .dd-dragel > .dd3-item > .dd3-content { margin: 0; }
    .dd3-item > button { margin-left: 30px; }
    .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:         linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .dd3-handle:before { content: '='; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
    .dd3-handle:hover { background: #ddd; }
</style>
<div class="panel panel-default">
    <nav class="panel-heading navbar navbar-default" role="navigation" style="margin-bottom:0px">
        <div class="row">
            <?php if(!empty($menus)){ ?>
                <form class="navbar-form navbar-left" method="POST" action="" role="search">
                    <input type="text" class="form-control" readonly value="Menu Management"/>
                    <div class="form-group">
                        <select type="text" name="menu" class="form-control" id="dbase" placeholder="Search">
                            <?php foreach($menus as $m){ ?>
                                <option value="<?php echo $m->menu_id;?>" <?php if(!empty($menudetail)){ if($menudetail[0]->menu_id == $m->menu_id){ echo "selected"; } }elseif($m->coltype == "header"){ echo "selected"; } ?> ><?php echo $m->menu_title;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="selectmenu" value="1" />
                    <button type="submit" class="btn btn-primary">Select</button>
                    <input type="text" class="form-control" readonly value="Menu ID <?php echo $menudetail[0]->menu_id;?>"/>
                </form>
            <?php } ?>
            <div style="margin-right: 0px;" class="navbar-form navbar-right" method="POST" action="" role="search">
                <button data-toggle="modal" href="#menu"  class="btn btn-success pull-right"> Create Menu</button>
            </div>
            <div class="navbar-form navbar-left">
                <input type="hidden" name="selectmenu" value="1" />
                <button data-toggle="modal" href="#updatemenu<?php echo $menudetail[0]->menu_id;?>" class="btn btn-warning" >Update</button>
            </div>
            <!--</form> -->
            <?php if($menudetail[0]->coltype == "header"){ }else{ ?>
                <form class="navbar-form navbar-left">
                    <span class="btn btn-danger pull-right delmenu" id="<?php echo $menudetail[0]->menu_id;?>">Delete</span>
                </form>
            <?php } ?>
        </div>
    </nav>
    <div class="panel-body">
        <?php if(!empty($menus)){ ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Pages</div>
                        <form action="" method="POST" class="panel-body">
                            <ul>
                                <?php
                                $menu_items = json_decode($menudetail[0]->menu_items);

                                $nonmenu_items = get_non_menu_items();
                                foreach($nonmenu_items as $n){
                                    if(!in_array($n->page_id,$menuarray)){
                                        ?>
                                        <li style="list-style-type:none;"><label style="cursor:pointer"><input type="checkbox" name="pages[]" value="<?php echo $n->page_id;?>" /> &nbsp;&nbsp; <?php echo $n->content_page_title;?></label>  </li>
                                    <?php } } ?>
                            </ul>
                            <input type="hidden" name="addtomenu" value="1" />
                            <input type="hidden" name="menu" value="<?php echo $menudetail[0]->menu_id;?>" />
                            <input type="hidden" name="menutype" value="<?php echo $menudetail[0]->coltype;?>" />
                            <button type="submit" class="btn btn-primary btn-block">Add to Menu &nbsp;&nbsp; <i class="fa fa-angle-right"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="">
                        <div class="panel-group">
                            <input type="hidden" id="menuid" value="<?php echo $menudetail[0]->menu_id; ?>" />
                            <div class="cf nestable-lists">
                                <div class="dd" id="nestable">
                                    <ul class="dd-list">
                                        <?php
                                        foreach($menu_items as $m)
                                        {
                                            if(!empty($m->id)){
                                                $parentpage = get_page_details($m->id);
                                                if($menudetail[0]->coltype == "header")
                                                {
                                                    $icons = '';
                                                    $mtitle  = $parentpage[0]->content_page_title;
                                                    $menutitle = strtolower(str_replace(" ","",$mtitle));
                                                    // $icons = "<i class='".pt_get_icon($menutitle)."'></i> ";
                                                    // echo '<pre>'; print_r($menutitle);
                                                    if(!empty($parentpage[0]->page_icon))
                                                    {
                                                        $icons = "<i class='".$parentpage[0]->page_icon."'></i> ";
                                                    }
                                                    if($parentpage[0]->content_special == 1)
                                                    {
                                                        if($parentpage[0]->page_slug != "offers")
                                                        {
                                                            $checkmodule = $this->ptmodules->is_module_available($menutitle);
                                                            if(!$checkmodule)
                                                            {
                                                                $this->ptmodules->disable_from_db($menutitle);
                                                            }
                                                            $dpname = $this->ptmodules->show_display_name(ucfirst($menutitle));
                                                            $mtitle = $dpname['DisplayName'];
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $mtitle  = $parentpage[0]->content_page_title;
                                                    if(!empty($parentpage[0]->page_icon))
                                                    {
                                                        $icons = "<i class='".$parentpage[0]->page_icon."'></i> ";
                                                    }
                                                    else
                                                    {
                                                        $icons = "";
                                                    }
                                                }
                                                if(!empty($parentpage[0]->page_id)){
                                                    ?>
                                                <li id="listorder_<?php echo $parentpage[0]->page_id; ?>" class="dd-item" data-id="<?php echo $parentpage[0]->page_id; ?>">
                                                    <div class="dd-handle">  <?php echo $icons.$mtitle;?> </div>
                                                    <?php if($parentpage[0]->content_special != 1){ ?>
                                                        <span id="<?php echo $parentpage[0]->page_id; ?>" style="z-index:99999;margin-top:-44px;margin-right:-42px;" class="btn btn-danger removemenu pull-right"><i class="fa fa-times"></i></span>  <?php } ?>
                                                    <?php
                                                    if(!empty($m->children)){ ?>
                                                        <ul class="dd-list">
                                                            <?php
                                                            foreach($m->children as $child){
                                                                $childpage = get_page_details($child->id);
                                                                if($menudetail[0]->coltype == "header"){
                                                                    $icons = '';
                                                                    $mtitle  = $childpage[0]->content_page_title;
                                                                    $menutitle = strtolower(str_replace(" ","",$mtitle));
                                                                    $icons = "<i class='".pt_get_icon($menutitle)."'></i> ";
                                                                    if(!empty($childpage[0]->page_icon)){
                                                                        $icons = "<i class='".$childpage[0]->page_icon."'></i> ";
                                                                    }
                                                                    if($childpage[0]->content_special == 1){
                                                                        if($childpage[0]->page_slug != "offers"){
                                                                            $checkmodule = $this->ptmodules->is_module_available($menutitle);
                                                                            if(!$checkmodule){
                                                                                $this->ptmodules->disable_from_db($menutitle);
                                                                            }
                                                                            $dpname = $this->ptmodules->show_display_name(ucfirst($menutitle));
                                                                            $mtitle = $dpname['DisplayName'];
                                                                        } } }else{
                                                                    $mtitle  = $childpage[0]->content_page_title;
                                                                    if(!empty($childpage[0]->page_icon)){

                                                                        $icons = "<i class='".$childpage[0]->page_icon."'></i> ";
                                                                    }else{
                                                                        $icons = "";
                                                                    } } if(!empty($childpage[0]->page_id)){ ?>
                                                                    <li id="listorder_<?php echo $childpage[0]->page_id; ?>" class="dd-item" data-id="<?php echo $childpage[0]->page_id; ?>">
                                                                        <div class="dd-handle">  <?php echo $icons.$mtitle;?>
                                                                        </div>
                                                                        <?php if($childpage[0]->content_special != 1){ ?>
                                                                            <span id="<?php echo $childpage[0]->page_id; ?>" style="z-index:99999;margin-top:-31px;margin-right:-28px;" class="btn btn-danger btn-xs pull-right removemenu "><i class="fa fa-times"></i></span>  <?php } ?>
                                                                        <!--------grandchild----->
                                                                        <ul class="dd-list">
                                                                            <?php
                                                                            foreach($child->children as $childd){
                                                                                $childpage = get_page_details($childd->id);
                                                                                if($menudetail[0]->coltype == "header"){
                                                                                    $icons = '';
                                                                                    $mtitle  = $childpage[0]->content_page_title;
                                                                                    $menutitle = strtolower(str_replace(" ","",$mtitle));
                                                                                    $icons = "<i class='".pt_get_icon($menutitle)."'></i> ";
                                                                                    if(!empty($childpage[0]->page_icon)){
                                                                                        $icons = "<i class='".$childpage[0]->page_icon."'></i> ";
                                                                                    }
                                                                                    if($childpage[0]->content_special == 1){
                                                                                        if($childpage[0]->page_slug != "offers"){
                                                                                            $checkmodule = $this->ptmodules->is_module_available($menutitle);
                                                                                            if(!$checkmodule){
                                                                                                $this->ptmodules->disable_from_db($menutitle);
                                                                                            }
                                                                                            $dpname = $this->ptmodules->show_display_name(ucfirst($menutitle));
                                                                                            $mtitle = $dpname['DisplayName'];
                                                                                        } } }else{
                                                                                    $mtitle  = $childpage[0]->content_page_title;
                                                                                    if(!empty($childpage[0]->page_icon)){

                                                                                        $icons = "<i class='".$childpage[0]->page_icon."'></i> ";
                                                                                    }else{
                                                                                        $icons = "";
                                                                                    } } if(!empty($childpage[0]->page_id)){ ?>
                                                                                    <li id="listorder_<?php echo $childpage[0]->page_id; ?>" class="dd-item" data-id="<?php echo $childpage[0]->page_id; ?>">
                                                                                        <div class="dd-handle">  <?php echo $icons.$mtitle;?>
                                                                                        </div>
                                                                                        <?php if($childpage[0]->content_special != 1){ ?>
                                                                                            <span id="<?php echo $childpage[0]->page_id; ?>" style="z-index:99999;margin-top:-30px;margin-right:-28px;" class="btn btn-danger btn-xs pull-right removemenu"> <i class="fa fa-times"></i></span> <?php } ?>
                                                                                    </li>
                                                                                <?php } } ?>
                                                                        </ul>
                                                                        <!------end grandchild------>
                                                                    </li>
                                                                <?php } } ?>
                                                        </ul>
                                                        </li>
                                                    <?php } } } } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- PHPtravels Modal Starting-->
<div class="modal fade" id="menu" tabindex="-1" role="dialog" aria-labelledby="menu" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create Menu</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Menu Name</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Name" name="menutitle" value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Status</label>
                            <div class="col-md-8">
                                <select type="text" name="status" class="form-control" placeholder="Search">
                                    <option value="1" >Enabled</option>
                                    <option value="0" >Disabled</option>
                                </select>
                            </div>
                        </div>
                        <?php foreach($languages as $lang => $val){ if($lang != "en"){ ?>
                            <div class="form-group">
                                <label  class="col-md-4 control-label text-left"> Name in <img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
                                <div class="col-md-8">
                                    <input type="text" name='<?php echo "translated[$lang][title]"; ?>' class="form-control" placeholder="Name" value="" >
                                </div>
                            </div>
                        <?php } } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="addmenu" value="1" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- PHPtravels Modal Ending-->
<!-- PHPtravels Update menu translation Starting-->
<?php foreach($menus as $m){ ?>
    <div class="modal fade" id="updatemenu<?php echo $m->menu_id;?>" tabindex="-1" role="dialog" aria-labelledby="menu" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Create Menu</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Menu Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" placeholder="Name" name="menutitle" value="<?php echo $m->menu_title;?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-8">
                                    <select type="text" name="status" class="form-control" placeholder="Search">
                                        <option value="1" <?php if($m->status == "1"){ echo "selected"; } ?> >Enabled</option>
                                        <option value="0" <?php if($m->status == "0"){ echo "selected"; } ?> >Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <?php foreach($languages as $lang => $val){ if($lang != "en"){ @$trans = getMenusTranslation($lang,$m->menu_id); ?>
                                <div class="form-group">
                                    <label  class="col-md-4 control-label text-left"> Name in <img src="<?php echo PT_LANGUAGE_IMAGES.$lang.".png"?>" height="20" alt="" />&nbsp;<?php echo $val['name'];?></label>
                                    <div class="col-md-8">
                                        <input type="text" name='<?php echo "translated[$lang][title]"; ?>' class="form-control" placeholder="Name" value="<?php echo @$trans[0]->trans_title;?>" >
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="addmenu" value="1" />
                        <input type="hidden" name="menu" value="<?php echo $m->menu_id;?>" />
                        <input type="hidden" name="updatemenu" value="1" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<!-- PHPtravels Update menu translation Modal Ending-->
