<div class="container">
  <div class="row mt-5 mb-5">
    <div class="col col align-self-start"></div>
    <div class="modal-content col align-self-center">
      <div class="modal-header">
        <div>
          <h5 class="modal-title title"><?=T::signup?></h5>
          <p class="font-size-14"><?=T::pleaseenterallcredentialstosignup?></p>
        </div>
      </div>
      <div class="modal-body">
        <div class="contact-form-action">
         <div class="message">
         <div class="alert alert-danger d-none">
         <?=T::emailalreadyexist?>
         </div>
         </div>
          <form method="POST" action="<?=root?>signup">
           <input type="hidden" value="" name="address" />
            <div class="input-box">
              <label class="label-text"><?=T::firstname?></label>
              <div class="form-group">
                <span class="la la-user form-icon"></span>
                <input class="form-control" type="text" placeholder="<?=T::firstname?>" name="first_name" value="" required>
              </div>
            </div>
            <div class="input-box">
              <label class="label-text"><?=T::lastname?></label>
              <div class="form-group">
                <span class="la la-user form-icon"></span>
                <input class="form-control" type="text" placeholder="<?=T::lastname?>" name="last_name" value="" required>
              </div>
            </div>
            <div class="input-box">
              <label class="label-text"><?=T::phone?></label>
              <div class="form-group">
                <span class="la la-phone form-icon"></span>
                <input class="form-control" type="text" placeholder="<?=T::phone?>" name="phone" value="" required>
              </div>
            </div>
            <div class="input-box">
              <label class="label-text"><?=T::email?></label>
              <div class="form-group">
                <span class="la la-envelope form-icon"></span>
                <input class="form-control" type="text" placeholder="<?=T::email?>" name="email" value="" required>
              </div>
            </div>
            <div class="input-box">
              <label class="label-text"><?=T::password?></label>
              <div class="form-group">
                <span class="la la-lock form-icon"></span>
                <input class="form-control" type="password" placeholder="<?=T::password?>" name="password" value="" required>
              </div>
            </div>
            <div class="input-box">
                <label class="label-text"><?=T::account?> <?=T::type?></label>
                <div class="form-group">
                <span class="la la-user form-icon"></span>
                <div class="input-items">
                <select name="type" id="account_type" class="select_ form-control" required>
                <option value="customers" selected><?=T::customer?></option>
                <option value="supplier"><?=T::supplier?></option>
                <option value="agent"><?=T::agent?></option>
                </select>
            </div>
            </div>
           </div>
            <hr>
            <!--<div class="input-box">
              <label class="label-text">Confirm Password</label>
              <div class="form-group">
                <span class="la la-lock form-icon"></span>
                <input class="form-control" type="password" placeholder="confirm password" name="confirmpassword" value="" required>
              </div>
            </div>-->
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-default btn-lg btn-block effect" data-style="zoom-in"><?=T::signup?></button>
            </div>
          </form>
            <div class="btn-box pb-1 mt-2">
              <a href="<?=root.('login')?>" type="submit" class="btn btn-block btn-outline-primary effect ladda-sm" data-style="zoom-in"><?=T::login?></a>
            </div>
        </div>
      </div>
    </div>
    <div class="col align-self-end"></div>
  </div>
</div>
<script>
if (document.URL == '<?=root?>signup/failed'){
$(".alert-danger").removeClass("d-none"); }

/* fadeout alerts */
$(document).ready(function () { window.setTimeout(function() {
$(".alert").fadeTo(150, 0).slideUp(50, function(){ $(this).remove(); }); }, 3500); });

if (document.URL == '<?=root?>signup-agent'){ document.getElementById("account_type").value = "agent" };
if (document.URL == '<?=root?>signup-supplier'){ document.getElementById("account_type").value = "supplier" };
</script>