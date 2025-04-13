<?php 

use Medoo\Medoo;

require_once '_config.php';
auth_check();
CSRF();

$title = T::profile; 
include "_header.php";

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
if (isset($_POST['status'])) { $STATUS = 1; } else { $STATUS = 0; };

    $params = array( 
    'first_name' => $_POST['first_name'], 
    'last_name' => $_POST['last_name'], 
    'email' => $_POST['email'], 
    'phone_country_code' => $_POST['phone_country_code'], 
    'phone' => $_POST['phone'], 
    'company_name' => $_POST['company_name'], 
    'country_code' => $_POST['country_code'], 
    'state' => $_POST['state'], 
    'city' => $_POST['city'], 
    'postal_code' => $_POST['postal_code'], 
    'address1' => $_POST['address1'], 
    'address2' => $_POST['address2'], 
    'user_type' => $_POST['user_type'], 
    'status' => $STATUS, 
    'note' => $_POST['note'], 
    'balance' => $_POST['balance'], 
    'currency_id' => $_POST['currency_id'], 
    );

    if (!empty($_POST['password'])) {$params['password'] = md5($_POST['password']);}
    
    $data = $db->update('users',$params, [ "user_id" => $_POST['user_id'] ]);

    if ($_POST['user_id'] == $USER_SESSION->backend_user_id ){ 
      ALERT_MSG('updated');
      REDIRECT("profile.php");

      // INSERT TO LOGS
      $user_id = $USER_SESSION->backend_user_id;    
      $log_type = "profile_updated";
      $datetime = date("Y-m-d h:i:sa");
      $desc = "user updated profile";
      logs($user_id,$log_type,$datetime,$desc.nl2br("\n").json_encode($_REQUEST));

    } else {
      ALERT_MSG('updated');
      REDIRECT("profile.php?user_id=".$_POST['user_id']);
    };

}

if (isset($_GET['user_id'])) {
    $params = array('user_id' => $_GET['user_id'] );
} else {
    $params = array('user_id' => $USER_SESSION->backend_user_id );
}

$profile = GET('users',$params)[0];

// GET CURRENCIES 
$params = array();
$currencies = GET('currencies',$params);

// GET COUNTRIES
$params = array();
$countries = GET('countries',$params);

// GET USER ROLES
$params = array();
$users_roles = GET('users_roles',$params);

?>

<div class="page_head">
<div class="panel-heading">
<div class="float-start">
<p class="m-0 page_title"><?=T::profile?></p>
</div>
<div class="float-end">
<a href="javascript:window.history.back();" data-toggle="tooltip" data-placement="top" title="Previous Page" class="loading_effect btn btn-warning"><?=T::back?></a>
</div>
</div>
</div>

<form action="./profile.php" method="post">
<div class="container mt-2">
<div class="py-2">
<div class="row gx-3">
<div class="col-lg-6">
  <div class="card card-raised mb-3">
    <div class="card-body p-4">
      <div class="card-title"><strong><?=T::user_profile?> </strong></div>
      <div class="card-subtitle mb-4"><?=T::Make_sure_all_information_has_been_added?></div>
      <div class="row mb-1">
        <div class="col">
          <div class="row form-group mb-3">
            <label class="col-md-2 control-label text-left pt-2"><?=T::status?></label>
            <div class="col-md-8">
              <div class="form-check form-switch">
                <label class="form-check-label" for=""></label>
                <input <?php if($profile->status == 1){ echo "checked"; }?> style="margin-top:10px;width: 40px; height: 20px;cursor:pointer" class="form-check-input" id="checkedbox" type="checkbox" name="status" value="true">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-floating mb-3">
        <select class="form-select type_name" name="user_type">
          <?php foreach($users_roles as $u) { ?>
          <option value="<?=$u->type_name?>"><?=$u->type_name?></option>
          <?php } ?>
        </select>
        <label for=""><?=T::user_role?></label>
      </div>
      <script>
        $(".type_name").val('<?=$profile->user_type?>')
      </script>
      <div class="rounded-2 p-3 bg-light mb-3">
        <div class="card-title"><strong><?=T::account_details?> </strong></div>
        <div class="card-subtitle mb-4"><?=T::financial_and_other_information?></div>
        <hr>
        <div class="row">

        <div class="col">
        <div class="form-floating mb-3">
            <input type="text" placeholder="" name="currency_id" value="<?=$profile->currency_id?>" class="form-control bg-white" readonly>
            <label for=""><?=T::currency?></label>
          </div>
        </div>
        
        <div class="col">
        <div class="form-floating mb-3">
        <?php $amount =  number_format((float)$profile->balance, 2, '.', ''); ?>
            <input type="text" placeholder="" name="balance" value="<?=$amount?>" class="form-control bg-white" readonly>
            <label for=""><?=T::balance?></label>
          </div>
        </div>

      <!-- <div class="col-md-3">
      <select class="form-select form-select-lg" name="currency_id" readonly>
      <option value=""><?=T::select?></option>
      <?php foreach($currencies as $c) { ?>
      <option value="<?=$c->name?>"><?=$c->name?></option>
      <?php } ?>
      </select>
      </select>
      <script>
      $("[name='currency_id']").val('<?=$profile->currency_id?>')
      </script>
      </div> -->

 
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <input type="text" placeholder="" name="first_name" value="<?=$profile->first_name?>" class="form-control">
            <label for=""><?=T::first_name?></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating mb-3">
            <input type="text" placeholder="" name="last_name" value="<?=$profile->last_name?>" class="form-control">
            <label for=""><?=T::last_name?></label>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-floating mb-3">
          <input type="password" placeholder="" name="password" value="" class="form-control">
          <label for=""><?=T::password?></label>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="email" value="<?=$profile->email?>" class="form-control">
          <label for=""><?=T::email?></label>
        </div>
      </div>
      <div class="rounded-2 p-3 bg-light">
        <div class="card-title"><strong><?=T::phone?></strong></div>
        <hr>
        <div class="row form-group mb-3">
          <div class="col">
            <select name="phone_country_code" class="selectpicker w-100" data-live-search="true">
              <option value=""><?=T::select?></option>
              <?php foreach($countries as $c) { ?>
              <option value="<?=$c->id?>" data-content="<img class='' src='./assets/img/flags/<?=strtolower($c->iso)?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?=$c->nicename?> <strong>+<?=$c->phonecode?></strong></span>"></option>
              <?php } ?>
            </select>
          </div>
          <div class="col">
            <div class="form-floating">
              <input type="text" placeholder="" name="phone" value="<?=$profile->phone?>" class="form-control">
              <label for=""><?=T::phone?></label>
            </div>
          </div>
        </div>
      </div>
      <script>
        $("[name='phone_country_code']").val('<?=$profile->phone_country_code?>')
      </script>
      <hr>
      <div class="">
        <div class="col-12">
          <div class="row form-group mb-3">
            <label class="col-md-2 control-label text-left pt-3"><?=T::country?></label>
            <div class="col-md-10">
              <select name="country_code" class="selectpicker w-100" data-live-search="true">
                <option value=""><?=T::select?></option>
                <?php foreach($countries as $c) { ?>
                <option value="<?=$c->id?>" data-content="<img class='' src='./assets/img/flags/<?=strtolower($c->iso)?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?=$c->nicename?></span>"></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="company_name" value="<?=$profile->company_name?>" class="form-control">
          <label for=""><?=T::company?></label>
        </div>
        <script>
          $("[name='country_code']").val('<?=$profile->country_code?>')
        </script>
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="state" value="<?=$profile->state?>" class="form-control">
          <label for=""><?=T::state?></label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="city" value="<?=$profile->city?>" class="form-control">
          <label for=""><?=T::city?></label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="postal_code" value="<?=$profile->postal_code?>" class="form-control">
          <label for=""><?=T::postal_code?></label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="address1" value="<?=$profile->address1?>" class="form-control">
          <label for=""><?=T::address1?></label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" placeholder="" name="address2" value="<?=$profile->address2?>" class="form-control">
          <label for=""><?=T::address2?></label>
        </div>
      </div>
      <hr>
      <div class="">
        <div class="form-floating">
          <textarea class="form-control" placeholder="Message" name="note" id="offmsg" style="height: 100px"><?=$profile->note?></textarea>
          <label for=""><?=T::account_note?></label>
        </div>
      </div>
      <div class="text-end mt-3">
        <input type="hidden" name="form_token" value="<?=$_SESSION["form_token"]?>">
        <button class="btn-block btn btn-primary" type="submit"> <?=T::update_profile?></button>
      </div>
    </div>
  </div>
</div>


<div class="col-lg-6">
   

   <div class="card">
      <div class="card-body p-4">
         <div class="card-title"><strong><?=T::markups?> </strong></div>
         
         <div class="border p-2 px-4 rounded-2">

         <?php 

        include('./xcrud/xcrud.php');
        $xcrud = Xcrud::get_instance();
        $xcrud->table('markups');
        $xcrud->order_by('id','desc');

        $xcrud->columns('user_markup,user_id,type');
        $xcrud->fields('user_markup,user_id,type');
        $xcrud->relation('module_id','modules','id','name');

        $xcrud->field_callback('user_markup','markup');
        $xcrud->column_pattern('user_markup','{value} %');

        // SPECIFY
        $xcrud->change_type('user_id','hidden');  
        $xcrud->where('user_id=', $profile->user_id);
        $xcrud->pass_default('user_id',$profile->user_id);

        // USER PERMISSIONS
        if (!isset($permission_delete)){ $xcrud->unset_remove(); }
        // if (!isset($permission_add)){ $xcrud->unset_add(); }
        if (!isset($permission_edit)){ $xcrud->unset_edit(); }
        if (!isset($permission_edit)){ 

        } else {
            $xcrud->column_callback('status', 'create_status_icon');
            $xcrud->field_callback('status','Enable_Disable');
        }

        $xcrud->unset_title();
        $xcrud->unset_view();
        $xcrud->unset_csv();

        // // REFRESH PAGE
        $xcrud->after_insert('refresh');
        $xcrud->after_update('refresh');

        echo $xcrud->render();

        ?>
         
      </div>
      </div>
   </div>

   <div class="card mt-3">
      <div class="card-body p-4">
         <div class="card-title"><strong><?=T::transactions?> </strong></div>
         <div class="border p-2 px-4 rounded-2">
            <?php 
            $xcrud = Xcrud::get_instance();
            $xcrud->table('transactions');
            $xcrud->order_by('id','desc');
            $xcrud->columns('trx_id,date,amount,currency');
            $xcrud->relation('currency','currencies','name','name','status=1');
            $xcrud->relation('payment_gateway','payment_gateways','name','name','status=1');
            $xcrud->validation_required('payment_gateway');
            $xcrud->validation_required('currency');
            $xcrud->validation_required('amount');

            // $xcrud->field_callback('user_markup','markup');
            // $xcrud->column_pattern('user_markup','{value} %');

            // SPECIFY
            // $xcrud->change_type('type','hidden');  
            $xcrud->change_type('user_id','hidden');  
            $xcrud->where('user_id=', $profile->user_id);
            $xcrud->pass_default('user_id',$profile->user_id);

            // USER PERMISSIONS
            $xcrud->unset_title();
            $xcrud->unset_csv();
            $xcrud->unset_edit();
            $xcrud->unset_remove();

            // // REFRESH PAGE
            $xcrud->after_insert('update_user_wallet');
            $xcrud->after_update('update_user_wallet');

            echo $xcrud->render();

            ?>
      </div>
      </div>
   </div>
</div>

<?php if (isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } else { $user_id = $USER_SESSION->backend_user_id; } ?>
<input type="hidden" name="user_id" value="<?=$user_id?>">
</form>

<style>
.xcrud-list-container{margin:0;padding:0}
.bootstrap-select>.dropdown-toggle { height: 58px !important; background: #fff }
.xcrud-list-container .form-check { display: none }
</style>

<?php include "_footer.php" ?>