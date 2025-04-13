<?php include_once 'Social_Login.php';
use Abraham\TwitterOAuth\TwitterOAuth;
?>
<div class="py-5 bg">
    <form id="login" action="<?=root?>login" method="post" class="mb-5">
        <div class="container">
            <div class="card card-style mt-5 col-md-5 mx-auto">
                <div class="content mb-0 p-4">
                    <h3><strong><?=T::login?></strong></h3>
                    <p></p>
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                        <label for="email"><?=T::email?> <?=T::address?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="password" type="password" class="form-control" id="password" placeholder="******">
                        <label for="password"><?=T::password?></label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="custom-checkbox mb-0 d-flex align-items-center gap-3">
                            <input class="form-check-input m-0" type="checkbox" id="rememberchb">
                            <label for="rememberchb"><?=T::rememberme?></label>
                        </div>
                        <div class="custom-checkbox mb-0">
                            <label style="cursor:pointer" for="" data-bs-toggle="modal" data-bs-target="#reset"><?=T::reset?>
                                <?=T::password?></label>
                        </div>
                    </div>
                    <div class="btn-box pt-0 pb-2">
                        <div class="login_button">
                            <button id="submitBTN" style="height:44px" type="submit" class="btn btn-dark w-100"><span
                                    class=""><?=T::login?></span></button>
                        </div>
                        <div class="loading_button" style="display:none">
                            <button style="height:44px"
                                class="loading_button gap-2 w-100 btn btn-dark btn-m rounded-sm font-700 text-uppercase btn-full"
                                type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                            <script>
                            $("#login").submit(function() {
                                $('.login_button').hide();
                                $('.loading_button').show();
                            })
                            </script>
                        </div>
                        <div class="mt-3 row">
                            <div class="col-md-12"><a
                                    class="d-flex align-items-center justify-content-center btn btn-outline-primary"
                                    style="height:44px" href="<?=root?>signup"><span
                                        class="ladda-label"><span></span><?=T::signup?></span></a></div>
                        </div>
                        <?php if(google_login == 1 || facebook_login == 1 || twitter_login == 1 ){?>
                        <!-- SOCIAL LOGIN BUTTONS -->
                        <div class="mt-3 row text-center">
                            <hr>

                            <div class="bg-light p-3 rounded-3 border">
                                <?php if(google_login == 1){?>
                                 <!-- GOOGLE BUTTON -->
                                <div class="col-md-12 text-center d-flex align-items-center justify-content-center">
                                <button class="btn " id="btnGoogleSignIn"> </button>
                                </div>
                                <?php } ?>
                                <?php if(facebook_login == 1){?>
                                <!-- Facebook BUTTON -->
                                <div id="fb-root" > 
                                    <!-- <div class="fb-login-button"  data-width="900" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="ture" data-use-continue-as="true" ></div> -->
                                    <div class="fb-login-button" data-max-rows="1" data-width="400" data-size="large" data-button-type="continue_with" data-use-continue-as="true" onlogin="checkLoginState();" scope="public_profile,email"></div>
                                </div> 
                                <?php } ?>
                                <?php if(twitter_login == 1){
                                     $connectTwitter1 = new TwitterOAuth(twitter_consumer_key, twitter_consumer_secret);
                                     $request_token = $connectTwitter1->oauth('oauth/request_token', array('oauth_callback' => twitter_redirect_url));
                                     $_SESSION['oauth_token'] = $request_token['oauth_token'];
                                     $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
                                     $connectTwitter2 = new TwitterOAuth(twitter_consumer_key, twitter_consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
                                     $verify_authentication = $connectTwitter2->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));
                                     $meta['verify_authentication'] = $verify_authentication;
                                    ?>    
                                <!-- TWITTER BUTTON -->
                                <div class="col-12">
                                    <a href="<?=htmlspecialchars($meta['verify_authentication'])?>" id="twitterButton" class="d-flex gap-3 btn mx-auto mt-2 px-2 py-2">
                                        <!-- SVG ICON -->
                                        <svg width="25px" height="25px" viewBox="126.444 2.281 589 589" xmlns="http://www.w3.org/2000/svg" fill="#1a73e8" stroke="#0000FF"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><circle cx="420.944" cy="296.781" r="294.5" fill="#ffffff"></circle><path d="M609.773 179.634c-13.891 6.164-28.811 10.331-44.498 12.204 16.01-9.587 28.275-24.779 34.066-42.86a154.78 154.78 0 0 1-49.209 18.801c-14.125-15.056-34.267-24.456-56.551-24.456-42.773 0-77.462 34.675-77.462 77.473 0 6.064.683 11.98 1.996 17.66-64.389-3.236-121.474-34.079-159.684-80.945-6.672 11.446-10.491 24.754-10.491 38.953 0 26.875 13.679 50.587 34.464 64.477a77.122 77.122 0 0 1-35.097-9.686v.979c0 37.54 26.701 68.842 62.145 75.961-6.511 1.784-13.344 2.716-20.413 2.716-4.998 0-9.847-.473-14.584-1.364 9.859 30.769 38.471 53.166 72.363 53.799-26.515 20.785-59.925 33.175-96.212 33.175-6.25 0-12.427-.373-18.491-1.104 34.291 21.988 75.006 34.824 118.759 34.824 142.496 0 220.428-118.052 220.428-220.428 0-3.361-.074-6.697-.236-10.021a157.855 157.855 0 0 0 38.707-40.158z" fill="#ffffff0000FF"></path></g></svg>
                                        <span class="mx-auto text-white" style="font-size: 16px;">Continue with Twitter</span>    
                                </a>
                                </div>

                                <?php } ?>

                                 
                                     <?php 
                                    // if(instagram_login == 1){
                                        ?>

                                        <!-- Insta_Email Modal -->
                                         <!-- <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="emailModalLabel">Enter Your Email</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form  method="POST">
                                                        <div class="modal-body">
                                                            <input type="email" class="form-control"  id="emailInput" placeholder="name@example.com">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" id="confirmEmailBtn">OK</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>  -->
                                        <!-- Instagram BUTTON -->
                                  <!-- <div class="col-12"> -->
                                    <!-- <a  id="instagramLoginButton" class="d-flex gap-3 btn mx-auto mt-2 px-2 py-2"> -->
                                        <!-- SVG ICON -->
                                      <!-- <svg width="25px" height="25px" viewBox="0 0 32.00 32.00" xmlns="http://www.w3.org/2000/svg" fill="#1a73e8" stroke="#1a73e8" stroke-width="2"> <path d="m17.0830929.03277248c8.1190907 0 14.7619831 6.64289236 14.7619831 14.76198302v2.3064326c0 8.1190906-6.6429288 14.761983-14.7619831 14.761983h-2.3064325c-8.11909069 0-14.76198306-6.6428924-14.76198306-14.761983v-2.3064326c0-8.11909066 6.64289237-14.76198302 14.76198306-14.76198302zm-.8630324 8.0002641-.2053832-.0002641c-1.7102378 0-3.4204757.05652851-3.4204757.05652851-2.4979736 0-4.52299562 2.02501761-4.52299562 4.52298561 0 0-.05191606 1.4685349-.05624239 3.0447858l-.00028625.2060969c0 1.7648596.05652864 3.590089.05652864 3.5900891 0 2.497968 2.02502202 4.5229856 4.52299562 4.5229856 0 0 1.5990132.0565285 3.2508899.0565285 1.7648634 0 3.6466255-.0565285 3.6466255-.0565285 2.4979736 0 4.4664317-1.9684539 4.4664317-4.4664219 0 0 .0565286-1.8046833.0565286-3.5335605l-.0010281-.4057303c-.0076601-1.5511586-.0555357-3.0148084-.0555357-3.0148084 0-2.4979681-1.9684582-4.46642191-4.4664317-4.46642191 0 0-1.6282521-.05209668-3.2716213-.05626441zm-.2053831 1.43969747c1.4024317 0 3.2005639.04637875 3.2005638.04637875 2.0483524 0 3.3130573 1.2647021 3.3130573 3.31305 0 0 .0463789 1.7674322.0463789 3.1541781 0 1.4176885-.0463789 3.2469355-.0463789 3.2469355 0 2.048348-1.2647049 3.31305-3.3130573 3.31305 0 0-1.5901757.0389711-2.9699093.0454662l-.3697206.0009126c-1.3545375 0-3.0049692-.0463788-3.0049692-.0463788-2.0483172 0-3.36958592-1.321301-3.36958592-3.3695785 0 0-.04637885-1.8359078-.04637885-3.2830941 0-1.3545344.04637885-3.061491.04637885-3.061491 0-2.0483479 1.32130402-3.31305 3.36958592-3.31305 0 0 1.7416035-.04637875 3.1440353-.04637875zm-.0000353 2.46195055c-2.2632951 0-4.0980441 1.8347448-4.0980441 4.098035s1.8347489 4.098035 4.0980441 4.098035 4.0980441-1.8347448 4.0980441-4.098035c0-2.2632901-1.8347489-4.098035-4.0980441-4.098035zm0 1.4313625c1.4727754 0 2.6666784 1.1939004 2.6666784 2.6666725s-1.193903 2.6666726-2.6666784 2.6666726c-1.4727401 0-2.6666784-1.1939005-2.6666784-2.6666726s1.1939031-2.6666725 2.6666784-2.6666725zm4.2941322-2.5685935c-.5468547 0-.9902027.4455321-.9902027.9950991 0 .5495671.443348.9950639.9902027.9950639.5468546 0 .9901674-.4454968.9901674-.9950639 0-.5496023-.4433128-.9950991-.9901674-.9950991z" fill="#ffffff" fill-rule="nonzero"></path> </svg> -->
                                        <!-- <span class="mx-auto text-white" style="font-size: 16px;">Continue with Instagram</span>     -->
                                <!-- </a> -->
                                <!-- </div> -->
                                 <?php 
                            // } 
                            ?> 
                            <!-- </div> -->
                        </div>
                         <!-- SOCIAL LOGIN BUTTONS -->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
</div>
<input type="hidden" name="form_token" value="<?=$_SESSION["form_token"]?>">
</form>
<div class="modal fade" id="reset" tabindex="1" aria-labelledby="modal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modal"><?=T::reset?> <?=T::password?></h5>
                <button type="button" class="btn-close waves-effect" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form method="POST" action="./" id="forget_pass">
                <div class="modal-body">
                    <div class="input-group">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="reset_mail" placeholder="name@example.com">
                            <label for="email"><?=T::email?> <?=T::address?></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button style="height:44px" type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal"><?=T::cancel?></button>
                    <button style="height:44px" type="submit" class="submit_buttons btn btn-primary btn-sm"><span><?=T::reset?> <?=T::email?></span></button>
                    <button style="height:44px;width:108px;display:none"
                                class="loading_buttons gap-2 btn btn-primary btn-m rounded-sm"
                                type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #twitterButton {
        background-color: rgb(26, 115, 232);
        width: 400px;
    }

    #twitterButton:hover {
        background-color: #1a73e8;
    }

    #instagramLoginButton {
        background-color: rgb(26, 115, 232);
        width: 400px;
    }

    #instagramLoginButton:hover {
        background-color: #1a73e8;
    }

</style>
<script>
$("#forget_pass").submit(function() {
    event.preventDefault();

    $('.submit_buttons').hide();
    $('.loading_buttons').show();

    var mail = $('#reset_mail').val();
    if (mail == ""){
        alert('Please add email address to reset password');
        $('.submit_buttons').show();
        $('.loading_buttons').hide();
    } else {

        var settings = {
        "url": "<?=root?>api/forget_password",
        "method": "POST",
        "timeout": 0,
        "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
        },
        "data": {
        "email": mail
        }
        };

        $.ajax(settings).done(function(response) {

        console.log(response);

        if (response.status == true){
            alert('Your password has been reset please check your mailbox')
            $('.submit_buttons').show();
            $('.loading_buttons').hide();
            $("#reset").modal('hide');
        } 

        if (response.status == false){
            alert('Invalid or no account found with this email')
            $('.submit_buttons').show();
            $('.loading_buttons').hide();
            $("#reset").modal('hide');
        } 

        if (response.message == "not_activated"){
            alert('Your account is not activated please contact us for activation')
            $('.submit_buttons').show();
            $('.loading_buttons').hide();
            $("#reset").modal('hide');
        } 

        });

        
    }
});

// $("#instagramLoginButton").click(function() {
//             $("#emailModal").modal("show");
//         });

//  $("#confirmEmailBtn").on("click", function() {
       
//         var instagram_consumer_key = "<?php //echo instagram_consumer_key; ?>";
//         // for local side work
//         // var instagram_redirect_url = "https://localhost/v9/Social_Login";
//         // for server side work
//         var instagram_redirect_url = "<?php //echo instagram_redirect_url; ?>";
//         // console.log(instagram_redirect_url);
//         var scope = "user_profile,user_media";
//         var instagramAuthUrl = `https://api.instagram.com/oauth/authorize/?client_id=${instagram_consumer_key}&redirect_uri=${instagram_redirect_url}&response_type=code&scope=${scope}`;

//         // Redirect to Instagram authentication
//             var insta_email = document.getElementById("emailInput").value;
//             if (insta_email) {
//                 // Store the email in session storage
//                 sessionStorage.setItem("insta_email", insta_email);
//                 // console.log('insta_email', insta_email);
//                 // Redirect to the next page after storing email in session storage
//                 window.location.href = instagramAuthUrl;
//                 // console.log( window.location.href = instagramAuthUrl);
//             } else {
//                 alert("Please enter a valid email address.");
//             }
//         });

</script>