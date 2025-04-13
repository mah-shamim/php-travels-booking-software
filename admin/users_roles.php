<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    
// ADD DATA
if (isset($_POST['page'])){
    if (empty($_POST['role_id'])){
        
        if (isset($_POST['page'])) {
            $permissions = ($_POST['page']);
        } else {
            $permissions = "NULL";
        }

        $params = array( 
        "type_name" => $_POST['role_name'],
        "permissions" => json_encode($permissions),
        );

        $data = INSERT('users_roles',$params);
        ALERT_MSG('updated');
        REDIRECT('users_roles.php');

        // INSERT TO LOGS
        $user_id = $USER_SESSION->backend_user_id;    
        $log_type = "user_role";
        $datetime = date("Y-m-d h:i:sa");
        $desc = "added new user role";
        logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));

        exit;

    }
}

// UPDATE DATA
if (isset($_POST['role_id'])){
    if (!empty($_POST['role_id'])){

            if (isset($_POST['page'])) {
                $permissions = ($_POST['page']);
            } else {
                $permissions = NULL;
            }
            
            $params = array( 
            "type_name" => $_POST['role_name'],
            "permissions" => json_encode($permissions),
            );
        
            $id = $_POST['role_id'];
            UPDATE('users_roles',$params,$id);

            ALERT_MSG('updated');
            REDIRECT('users_roles.php');

            // INSERT TO LOGS
            $user_id = $USER_SESSION->backend_user_id;    
            $log_type = "update_user_role";
            $datetime = date("Y-m-d h:i:sa");
            $desc = "updated user role";
            logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));
            exit;
    }   
}

// UPDATE STATUS
if (isset($_POST['status'])){
    $params = array( "status" => $_POST['status'],);
    $id = $_POST['id'];
    $data = UPDATE('users',$params,$id);
    exit;
} 

}

$title = T::users;
include "_header.php";

?>

<div class="page_head">
    <div class="panel-heading">
        <div class="float-start">
            <p class="m-0 page_title"><?=T::users_roles?></p>
        </div>
        <div class="float-end">
            <?php if (isset($permission_add)){ ?>
            <?php if(!isset($_GET['role_id'])) { ?>
            <?php if(!isset($_GET['role_add'])) { ?>
            <a href="./users_roles.php?role_add=1"
                class="loading_effect btn btn-dark"><?=T::add?></a>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<div class="container mt-3">

<?php if(isset($_GET['role_id']) || isset($_GET['role_add'])){ ?>
<!-- ========================================================================================================= -->

<?php

// GET DATA
if(isset($_GET['role_id'])) { 
$params = array("id"=> $_GET['role_id']);
$data = GET('users_roles',$params)[0];
$pages_data = (json_decode($data->permissions));
}
?>

<div class=" py-2">
    <form action="./users_roles.php" method="POST">
        <input type="hidden" name="role_id" value="<?php if(isset($data->id)){echo $data->id;}?>">
        <div class="card">

            <div class="panel-body  p-5">
                <div class="tab-content form-horizontal">
                    <p><strong><?=T::role_name?></strong></p>
                    <div class="row form-group mb-4 mt-4">

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" placeholder="" name="role_name"
                                    value="<?php if(isset($data->type_name)){echo $data->type_name;}?>"
                                    class="form-control" required>
                                <label for=""><?=T::role_name?></label>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <table class="table table-striped table-hover table-bordered"
                        style="text-transform:capitalize">
                        <thead>
                            <tr>
                                <th><?=T::page?></th>
                                <th class="d-flex justify-content-between gap-5">
                                <?=T::permissions?>

                                    <div class="form-check">
                                        <input onClick="toggle(this)" type="checkbox" class="form-check-input"
                                            id="select_alls" name="" value="">
                                        <label for="select_alls"><?=T::select_all?></label>
                                    </div>

                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                                                        
                            foreach ($pages as $i => $page) { 
                                
                                // dd($page['page_access'])
                                ?>
                            <tr>
                                <td>
                                    <b><?=$i?></b>
                                </td>
                                <td>

                                    <div class="d-flex gap-3">

                                    <?php if(isset($page['page_access'])){ ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?=$i?>_page_access" name="page[<?=$i?>][page_access]" value="">
                                            <label for="<?=$i?>_page_access"><?=T::page_access?></label>
                                        </div>
                                    <?php } ?>

                                        -

                                        <?php if(isset($page['add'])){ ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?=$i?>_add"
                                                name="page[<?=$i?>][add]" value="">
                                            <label for="<?=$i?>_add"><?=T::add?></label>
                                        </div>
                                        <?php } ?>

                                        <?php if(isset($page['edit'])){ ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?=$i?>_edit"
                                                name="page[<?=$i?>][edit]" value="">
                                            <label for="<?=$i?>_edit"><?=T::edit?></label>
                                        </div>
                                        <?php } ?>

                                        <?php if(isset($page['view'])){ ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?=$i?>_view"
                                                name="page[<?=$i?>][view]" value="">
                                            <label for="<?=$i?>_view"><?=T::view?></label>
                                        </div>
                                        <?php } ?>

                                        <?php if(isset($page['delete'])){ ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="<?=$i?>_delete"
                                                name="page[<?=$i?>][delete]" value="">
                                            <label for="<?=$i?>_delete"><?=T::delete?></label>
                                        </div>
                                        <?php } ?>

                                    </div>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-muted">
                <div class="mx-4 my-3">
                    <button type="submit" class="btn btn-primary mdc-ripple-upgraded"> <?=T::submit?></button>
                </div>
            </div>

        </div>
    </form>

<script>
$('#select_alls').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox').not($(this));
    checkboxes.prop('checked', $(this).is(':checked'));
});
</script>

<?php 

foreach ($pages as $i  => $permission) {

    if (isset($pages_data )) {

        if (isset($pages_data->$i->page_access)){ echo ("<script>$('#".$i."_page_access').prop('checked', true);</script>"); }
        if (isset($pages_data->$i->add)){ echo ("<script>$('#".$i."_add').prop('checked', true);</script>"); }
        if (isset($pages_data->$i->edit)){ echo ("<script>$('#".$i."_edit').prop('checked', true);</script>"); }
        if (isset($pages_data->$i->view)){ echo ("<script>$('#".$i."_view').prop('checked', true);</script>"); }
        if (isset($pages_data->$i->delete)){ echo ("<script>$('#".$i."_delete').prop('checked', true);</script>"); }

    }
}

?>
                
<!-- ========================================================================================================= -->
<?php } else { ?>

<?php 
include('./xcrud/xcrud.php');
$xcrud = Xcrud::get_instance();
$xcrud->table('users_roles');
$xcrud->order_by('id','desc');
$xcrud->columns('type_name');

if (!isset($permission_delete)){ $xcrud->unset_remove(); }

if (!isset($permission_edit)){ 
} else {
    $xcrud->button('./users_roles.php?role_id={id}','User Role','<i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></i>');
}

$xcrud->unset_title();
$xcrud->unset_view();
$xcrud->unset_csv();
$xcrud->unset_edit();
$xcrud->unset_add();
$xcrud->column_width('status','5%');
echo $xcrud->render();

?>

<style>
.form-check { display: none }
</style>

<?php } ?>

<?php include "_footer.php" ?>