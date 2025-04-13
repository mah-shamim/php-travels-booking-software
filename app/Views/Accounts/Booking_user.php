<?php 

// CHECK IF USER EXIST IN THE SESSION
if(isset($_SESSION['phptravels_client']->user_id) == true) {

// CALL API GET DATA
$params = array(
    "api_key" => api_key,
    "user_id" => $_SESSION['phptravels_client']->user_id,
);
$meta['profile'] = POST(api_url.'profile', $params)->data[0];

}

// GET COUNTRIES FROM THE API
$meta['countries'] = (GET(api_url."countries")); 
    
// GET USERS DATA
(isset($meta['profile']->first_name))?$first_name=$meta['profile']->first_name:$first_name="";
(isset($meta['profile']->last_name))?$last_name=$meta['profile']->last_name:$last_name="";
(isset($meta['profile']->email))?$email=$meta['profile']->email:$email="";
(isset($meta['profile']->phone))?$phone=$meta['profile']->phone:$phone="";
(isset($meta['profile']->address1))?$address=$meta['profile']->address1:$address="";
(isset($_SESSION['hotels_nationality']))?$nationality=$_SESSION['hotels_nationality']:$nationality="";

?>

<div class="form-content ">
<div class="contact-form-action">
        <div class="row g-3">

            <div class="col-lg-6 mb-2">
                <div class="form-floating">
                <input type="text" name="user[first_name]" class="<?php if (!empty($first_name)){echo "disabled";} ?> form-control" placeholder="<?=T::first_name?>" value="<?=$first_name?><?php if (dev == 1){echo "Elon";}?>"/>
                <label for="">
                <?=T::first_name?>            
                </label>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-floating">
                <input type="text" name="user[last_name]" class="<?php if (!empty($last_name)){echo "disabled";} ?> form-control" placeholder="<?=T::last_name?>" value="<?=$last_name?><?php if (dev == 1){echo "Musk";}?>"/>
                <label for="">
                <?=T::last_name?>            
                </label>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-floating">
                <input type="text" name="user[email]" class="<?php if (!empty($email)){echo "disabled";} ?> form-control" placeholder="<?=T::email?>" value="<?=$email?><?php if (dev == 1){echo "elon@musk.com";}?>"/>
                <label for="">
                <?=T::email?>            
                </label>
                </div>
            </div>

            <div class="col-lg-6 mb-2">
                <div class="form-floating">
                <input type="text" name="user[phone]" class="<?php if (!empty($phone)){echo "disabled";} ?> form-control" placeholder="<?=T::phone?>" value="<?=$phone?><?php if (dev == 1){echo "+442080160508";}?>"/>
                <label for="">
                <?=T::phone?>            
                </label>
                </div>
            </div>

            <?php
            if(isset($_SESSION['phptravels_client']->user_id) == true) { 
            if(!empty($address)) {
            ?>
            <div class="col-lg-12 mb-2">
                <div class="form-floating">
                <input type="text" name="user[address]" class="<?php if (!empty($address)){echo "disabled";} ?> form-control" placeholder="<?=T::address?>" value="<?=$address?><?php if (dev == 1){echo "ST 6 Cavalry Ground Burdin DK";}?>"/>
                <label for="">
                <?=T::address?>            
                </label>
                </div>
            </div>
            <?php } } else { ?>

            <div class="col-lg-12 mb-2">
            <div class="form-floating">
            <input type="text" name="user[address]" class="form-control" placeholder="<?=T::address?>" value="<?php if (dev == 1){echo "ST 6 Cavalry Ground Burdin DK";}?>"/>
            <label for="">
            <?=T::address?>            
            </label>
            </div>
            </div>

            <?php } ?>

            <div class="col-md-6">
            <label class="mb-2"><strong><?=T::nationality?></strong></label>
                <div class="form-floating mb-3">

                    <?php 
                    if (isset($meta['nav_menu'])){
                        if ($meta['nav_menu'] == "flights"){
                            $status = "";
                        }

                        if ($meta['nav_menu'] == "hotels"){
                            if (isset($_SESSION['hotels_nationality'])){
                                $status = "disabled";
                            } else {
                                $status = "";
                            }
                        }

                        // if (isset($nationality)){echo "disabled";}
                    }
                    ?>

                    <select  name="user[nationality]" class="<?=$status?> nationality selectpicker w-100" data-live-search="true"
                        required>
                        <option value=""><?=T::select?> <?=T::nationality?></option>
                        <?php foreach($meta['countries'] as $c) { ?>
                        <option value="<?=$c->iso?>"
                            data-content="<img class='' src='<?=root?>assets/img/flags/<?=strtolower($c->iso)?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?=$c->nicename?> </span>">
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
            <label class="mb-2"><strong> <?=T::current?> <?=T::country?></strong></label>
                <div class="form-floating mb-3">
                    <select name="user[country_code]" class="country selectpicker w-100" data-live-search="true"
                        required>
                        <option value=""><?=T::select?> <?=T::country?></option>
                        <?php foreach($meta['countries'] as $c) { ?>
                            <option value="<?=$c->iso?>"
                            data-content="<img class='' src='<?=root?>assets/img/flags/<?=strtolower($c->iso)?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?=$c->nicename?> 
                            </span>">
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
</div><!-- end contact-form-action -->
</div><!-- end form-content -->

<script>
$('.nationality option[value=<?php if(isset($_SESSION['hotels_nationality'])){ echo $_SESSION['hotels_nationality']; } else { echo "US"; } ?>]').attr('selected','selected');
$('.country option[value=<?php if(isset($_SESSION['hotels_nationality'])){ echo $_SESSION['hotels_nationality']; } else { echo "US"; } ?>]').attr('selected','selected');
</script>

<?php if(isset($_SESSION['hotels_nationality'])){?>
<input type="hidden" class="nationality" name="nationality" value="<?=$_SESSION['hotels_nationality']?>">

<?php } ?>

<?php 
// CHECK USER SESSION
if (isset($_SESSION['phptravels_client']->user_id)) {
$user_id = $_SESSION['phptravels_client']->user_id;} else { $user_id="";}
?>

<input type="hidden" class="" name="user[user_id]" value="<?=$user_id?>">

<style>
    .disabled{pointer-events:none!important}
    .disabled{background:#e9eef2!important}
</style>