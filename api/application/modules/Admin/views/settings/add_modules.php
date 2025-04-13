<form method="post" action="<?= base_url(uri_string()) ?>">
    <div class="panel panel-default">

        <div class="panel-heading">Add New Module</div>
        <div class="panel-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Name</label>
                    <input type="text" class="form-control" value="<?= !empty($modules->name) ? $modules->name : ""; ?>"
                           name="name" id="inputEmail4" placeholder="name">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Label</label>
                    <input type="text" name="label" value="<?= !empty($modules->label) ? $modules->label : ""; ?>"
                           class="form-control" id="inputPassword4" placeholder="label">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Slug</label>
                    <input type="text" name="slug" value="<?= !empty($modules->slug) ? $modules->slug : ""; ?>"
                           class="form-control" id="inputEmail4" placeholder="slug">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Front Icon</label>
                    <input type="text" name="front_name"
                           value="<?= !empty($modules->frontend->icon) ? $modules->frontend->icon : ""; ?>"
                           class="form-control" id="inputPassword4" placeholder="Front Name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Front Label</label>
                    <input type="text" name="front_label"
                           value="<?= !empty($modules->frontend->label) ? $modules->frontend->label : ""; ?>"
                           class="form-control" id="inputPassword4" placeholder="Front Label">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Front Slug</label>
                    <input type="text" name="front_slug"
                           value="<?= !empty($modules->frontend->slug) ? $modules->frontend->slug : ""; ?>"
                           class="form-control" id="inputEmail4" placeholder="Front Slug">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Order Number</label>
                    <input type="number" name="order" value="<?= !empty($modules->order) ? $modules->order : ""; ?>"
                           class="form-control" id="inputEmail4" placeholder="Order Number">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inputEmail4">Menu Icon</label>
                <input type="text" name="menu_icon"
                       value="<?= !empty($modules->menus->icon) ? $modules->menus->icon : ""; ?>" class="form-control"
                       id="inputEmail4" placeholder="Menu Icon">
            </div>
            <div class="clearfix"></div>
            <div class="well well-sm">
                <div class="form-group col-md-12">
                    <h4><b>Admin Menu</b></h4>
                </div>

                <?php foreach ($modules->menus->admin as $item) { ?>
                    <div class="form-row remove_btn">
                        <div class="form-group col-md-5">
                            <label for="inputPassword4">Menu Label</label>
                            <input type="text" name="admin_menu_label[]"
                                   value="<?= !empty($item->label) ? $item->label : ""; ?>" class="form-control"
                                   id="inputPassword4" placeholder="Menu Label">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Menu url</label>
                            <input type="text" name="admin_menu_url[]"
                                   value="<?= !empty($item->link) ? $item->link : ""; ?>" class="form-control"
                                   id="inputEmail4" placeholder="Front Slug">
                        </div>
                        <div class="form-group col-md-1">
                            <label>&nbsp;</label>
                            <div class="clearfix"></div>
                            <button type="button" onclick="remove_btn(this)" class="btn btn-danger" id=""><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-row" id="append_div_admin"></div>
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary pull-left" id="add_admin_menu">Add Menu</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="well well-sm">
                <div class="form-group col-md-12">
                    <h4><b>Supplier Menu</b></h4>
                </div>
                <?php foreach ($modules->menus->supplier as $item) { ?>

                    <div class="form-row remove_btn_supplier" id="add_supplier">
                        <div class="form-group col-md-5">
                            <label for="inputPassword4">Menu Label</label>
                            <input type="text" name="supplier_menu_label[]"
                                   value="<?= !empty($item->label) ? $item->label : ""; ?>" class="form-control"
                                   id="inputPassword4" placeholder="Front Label">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Menu url</label>
                            <input type="text" name="supplier_menu_url[]"
                                   value="<?= !empty($item->link) ? $item->link : ""; ?>" class="form-control"
                                   id="inputEmail4" placeholder="Front Slug">
                        </div>
                        <div class="form-group col-md-1">
                            <label>&nbsp;</label>
                            <div class="clearfix"></div>
                            <button type="button" onclick="remove_btn_supplier(this)" class="btn btn-danger" id=""><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-row" id="append_div_supplier"></div>
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary" id="add_supplier_menu">Add supplier Menu</button>
                    <div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>


<script>

    function remove_btn(e) {
        $(e).closest(".remove_btn").remove();
    }

    function remove_btn_supplier(e) {
        $(e).closest(".remove_btn_supplier").remove();
    }

    $("#add_admin_menu").click(function (a) {
        $("#append_div_admin").append("" +
            "<div class=\"form-row remove_btn\" style=\"\" >\n" +
            "<div class=\"form-group col-md-5\">\n" +
            "<label for=\"inputPassword4\">Menu Label</label>\n" +
            "<input type=\"text\" name=\"admin_menu_label[]\"  value=\"\" class=\"form-control\" id=\"inputPassword4\" placeholder=\"Menu Label\">\n" +
            "</div>\n" +
            " <div class=\"form-group col-md-6\">\n" +
            "<label for=\"inputEmail4\">Menu url</label>\n" +
            "<input type=\"text\" name=\"admin_menu_url[]\" value=\"\" class=\"form-control\" id=\"inputEmail4\" placeholder=\"Front Slug\">\n" +
            "</div>\n" +
            "<div class=\"form-group col-md-1\">\n" +
            "<label>&nbsp;</label>\n" +
            "<div class=\"clearfix\"></div>\n" +
            "<button type=\"button\" onclick=\"remove_btn(this)\" class=\"btn btn-danger\" id=\"\"><i class=\"fa fa-times\"></i></button>\n" +
            "</div>\n" +
            "</div> "
        );

    });

    $("#add_supplier_menu").click(function (a) {
        $("#append_div_supplier").append(
            "<div class=\"form-row remove_btn\" style=\"\" >\n" +
            "<div class=\"form-group col-md-5\">\n" +
            "<label for=\"inputPassword4\">Menu Label</label>\n" +
            "<input type=\"text\" name=\"admin_menu_label[]\"  value=\"\" class=\"form-control\" id=\"inputPassword4\" placeholder=\"Menu Label\">\n" +
            "</div>\n" +
            " <div class=\"form-group col-md-6\">\n" +
            "<label for=\"inputEmail4\">Menu url</label>\n" +
            "<input type=\"text\" name=\"admin_menu_url[]\" value=\"\" class=\"form-control\" id=\"inputEmail4\" placeholder=\"Front Slug\">\n" +
            "</div>\n" +
            "<div class=\"form-group col-md-1\">\n" +
            "<label>&nbsp;</label>\n" +
            "<div class=\"clearfix\"></div>\n" +
            "<button type=\"button\" onclick=\"remove_btn(this)\" class=\"btn btn-danger\" id=\"\"><i class=\"fa fa-times\"></i></button>\n" +
            "</div>\n" +
            "</div> "
        );
    });

</script>