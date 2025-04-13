 <div class="panel panel-default">
  <div class="panel-heading"><?php echo $header_title; ?></div>
  <form class="add_button" action="<?php echo $add_link; ?>" method="post"><button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add</button></form>
   <div class="panel-body">
     <?php echo $content; ?>
   </div>
 </div>

 <script>
     function change_button(){

     }
        $("#select_all").click(function () {
            if ($(this).prop("checked")) {
                $("[class=checkboxcls]").prop("checked", true);
            } else {
                $("[class=checkboxcls]").prop("checked", false);
            }
        });
        $("#deleteAll").click(function () {
            var checkboxes = $("[class=checkboxcls]:checked");
            var table_name = "<?=!empty($table_name) ? $table_name :   ""?>";
            var main_key = "<?=!empty($main_key) ? $main_key :   ""?>";
            var all_data = [];
            $.each(checkboxes, function (index, object, container) {
                all_data.push($(object).val())
            });
            if (all_data.length != 0) {
                var answer = confirm("Are you sure you want to delete?");
                if (answer) {
                    $.post("<?=base_url('admin/hotels/DeleteAll')?>", {primery_keys: all_data,table_name : table_name,main_key:main_key}, function (theResponse) {
                        location.reload();
                    });

                } else {
                    location.reload();
                    return false;
                }
            } else {
                alert("Please at least select one item.")
            }
        });

    </script>