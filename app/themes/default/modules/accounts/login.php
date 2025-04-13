<div class="container">
  <div class="row mt-5 mb-5">
    <div class="col col align-self-start"></div>
    <div class="modal-content col align-self-center">
      <div class="modal-header">
        <div>
          <h5 class="modal-title title"><?=T::login?></h5>
          <p class="font-size-14"><?=T::pleaseneteryouraccountcredentialsbelow?></p>
        </div>
      </div>
      <div class="modal-body">
        <div class="contact-form-action">
        <div class="message">
        <div class="alert alert-danger d-none failed">
         <i class="la la-info-circle"></i> <?=T::wrongcredentialstryagain?>
        </div>
        <div class="alert alert-success d-none signup">
         <i class="la la-info-circle"></i> <?=T::signupsuccessfullpleaselogin?>
        </div>
        </div>

        <div class="reset-fail alert alert-danger d-none">
         <i class="la la-info-circle"></i> <?=T::noemailexistusevalidemail?>
        </div>
        <div class="reset-success alert alert-success d-none">
         <i class="la la-info-circle"></i> <?=T::passwordresetcheckyourmailbox?>
        </div>

          <form method="POST" action="<?=root?>login">
            <div class="input-box">
              <label class="label-text"><?=T::email?></label>
              <div class="form-group">
                <span class="la la-user form-icon"></span>
                <input class="form-control" type="email" placeholder="<?=T::email?>" required="required" name="email" >
              </div>
            </div>
            <div class="input-box">
              <label class="label-text"><?=T::password?></label>
              <div class="form-group mb-2">
                <span class="la la-lock form-icon"></span>
                <input class="form-control" type="password" placeholder="<?=T::password?>" required="required" name="password" >
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class="custom-checkbox mb-0">
                  <input type="checkbox" id="rememberchb">
                  <label for="rememberchb"><?=T::rememberme?></label>
                </div>

                <div class="custom-checkbox mb-0">
                  <label for="rememberchb" data-bs-toggle="modal" data-bs-target="#reset"><?=T::resetpassword?></label>
                </div>
              </div>
            </div>
            <div class="btn-box pt-3 pb-4">
              <button type="submit" class="btn btn-default btn-lg btn-block effect" data-style="zoom-in"><?=T::login?></button>
              <div class="mt-3 row">
                <div class="col-md-12"><a class="btn btn-outline-primary btn-block form-group effect ladda-sm" data-style="zoom-in" href="<?=root.('signup')?>"><span></span><?=T::signup?></a></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col align-self-end"></div>
  </div>
</div>

<!-- reset password modal -->
<div class="modal fade" id="reset" tabindex="1" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal"><?=T::resetpassword?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="<?=root?>reset_password" id="">
      <div class="modal-body">
      <div class="input-group">
        <input type="text" placeholder="your@email.com" class="form-control" id="" name="email" required>
      </div>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=T::cancel?></button>-->
        <button type="submit" class="btn btn-primary ladda effect" data-style="zoom-in"><?=T::reset?></button>
      </div>
     </form>
    </div>
  </div>
</div>

<script>
if (document.URL == '<?=root?>login/reset/success'){ $(".reset-success").removeClass("d-none") };
if (document.URL == '<?=root?>login/reset/fail'){ $(".reset-fail").removeClass("d-none") };
if (document.URL == '<?=root?>login/failed'){ $(".failed").removeClass("d-none") };
if (document.URL == '<?=root?>login/signup'){ $(".signup").removeClass("d-none") };

/* fadeout alerts */
$(document).ready(function () { window.setTimeout(function() {
$(".alert").fadeTo(150, 0).slideUp(50, function(){ $(this).remove(); }); }, 3500) });
</script>