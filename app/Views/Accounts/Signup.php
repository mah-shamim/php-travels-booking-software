<?php include_once 'Social_Login.php';?>
<div class="py-5 bg">
    <form id="signup" action="<?=root?>signup" method="post" class="mb-5">
        <div class="container">
            <div class="card card-style mt-5 col-md-5 mx-auto">
                <div class="content mb-0 p-4">
                    <h3><strong><?=T::signup?></strong></h3>
                    <p class="mb-4"></p>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="firstname" placeholder=" " name="first_name"
                            required>
                        <label for="firstname"><?=T::first_name?></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="last_name" placeholder=" " name="last_name"
                            required>
                        <label for="last_name"><?=T::last_name?></label>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="phone_country_code" class="selectpicker w-100" data-live-search="true"
                                    required>
                                    <option value=""><?=T::select?> <?=T::country?></option>
                                    <?php foreach($meta['countries'] as $c) { ?>
                                    <option value="<?=$c->id?>"
                                        data-content="<img class='' src='./admin/assets/img/flags/<?=strtolower($c->iso)?>.svg' style='width: 20px; margin-right: 14px;color:#fff'><span class='text-dark'> <?=$c->nicename?> <strong>+<?=$c->phonecode?></strong></span>">
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="numbers" class="form-control" id="phone" placeholder=" " name="phone"
                                    required>
                                <label for="phone"><?=T::phone?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="user_email" placeholder=" " name="user_email" required>
                        <label for="email"><?=T::email?> <?=T::address?></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" placeholder=" " name="password"
                            required>
                        <label for="password"><?=T::password?></label>
                    </div>


                    <div class="g-recaptcha" data-sitekey="6LdX3JoUAAAAAFCG5tm0MFJaCF3LKxUN4pVusJIF" data-callback="correctCaptcha"></div>
                    <script src="https://www.google.com/recaptcha/api.js"></script>
                    <script>
                    var correctCaptcha = function(response) {  
                    $('#submitBTN').prop('disabled', false); };
                    </script>

                    <label class="form-check-label mt-2"><?=T::by_signup_i_agree_to_terms_and_policy?></label>

                    <hr>

                    <div class="btn-box pt-0 pb-2">
                        <div class="mt-3 row">
                            <div class="col-md-12">

                                <div class="signup_button">
                                    <button id="submitBTN" disabled style="height:44px" type="submit"
                                        class="btn-lg d-flex align-items-center justify-content-center btn btn-primary w-100"></span><?=T::signup?></span>
                                    </button>
                                </div>

                                <div class="loading_button" style="display:none">
                                    <button style="height:44px"
                                        class="loading_button gap-2 w-100 btn btn-primary btn-m rounded-sm font-700 text-uppercase btn-full"
                                        type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                                </div>

                                <script>
                                $('.agree').click(function() {
                                    if ($(this).is(':checked')) {
                                        document.getElementById('submitBTN').disabled = false;
                                    } else {
                                        document.getElementById('submitBTN').disabled = true;
                                    }
                                });

                                $("#signup").submit(function() {
                                    $('.signup_button').hide();
                                    $('.loading_button').show();
                                })
                                </script>

                            </div>
                        </div>
                                              
                        <!-- SOCIAL LOGIN BUTTONS -->
                        <!--<div class="mt-3 row text-center">
                           <hr>

                           <div class="bg-light p-3 rounded-3 border">

                               GOOGLE BUTTON -->
                                <!--<div class="col-md-12 text-center d-flex align-items-center justify-content-center">
                               <button class="btn border w-100 p-2 bg-white mt-2 btn-lg d-flex gap-3 justify-content-center bg-white" id="btnGoogleSignIn"> </button>
                               </div>-->

                               <!-- TWITTER BUTTON -->
                                    <!--<a href="<?php //echo ($meta['verify_authentication']);?>" style="height:44px" id="twitter" name="twitter" class="btn border w-100 p-2 bg-white mt-2 btn-lg d-flex gap-3 justify-content-center">-->
                                <!-- SVG ICON -->
                                <!--<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                               Twitter
                               </a>-->

                        <!-- </div>

                    </div>-->
                         <!-- SOCIAL LOGIN BUTTONS -->
                             
            </div>
        </div>
        <input type="hidden" name="form_token" value="<?=$_SESSION["form_token"]?>">
    </form>
</div>
</div>
</div>