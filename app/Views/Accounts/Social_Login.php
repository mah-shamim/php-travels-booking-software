<?php

use Abraham\TwitterOAuth\TwitterOAuth;


if (twitter_login == 1) {

    if (isset($_GET['oauth_verifier']) && isset($_GET['oauth_token']) && isset($_SESSION['oauth_token']) && $_GET['oauth_token'] == $_SESSION['oauth_token']) {
        $connectTwitter3 = new TwitterOAuth(twitter_consumer_key, twitter_consumer_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $access_token = $connectTwitter3->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier']));
        $_SESSION['access_twitter'] = $access_token;

        if (isset($_SESSION['access_twitter']) && $_SESSION['access_twitter']) {
            $oauthenticate = $_SESSION['access_twitter']['oauth_token'];
            $oauthenticate_secret = $_SESSION['access_twitter']['oauth_token_secret'];

            $verifier = new TwitterOAuth(twitter_consumer_key, twitter_consumer_secret, $oauthenticate, $oauthenticate_secret);

            $getUser = $verifier->get('account/verify_credentials', ['include_email' => 'true']);
            if (property_exists($getUser, 'error')) {
                $_SESSION = array();

                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(
                        session_name(),
                        '',
                        time() - 42000,
                        $params["path"],
                        $params["domain"],
                        $params["secure"],
                        $params["httponly"]
                    );
                }
                session_destroy();
                header('Location: errorpage.php');
                exit();
            } else {
                $getUser = $verifier->get('account/verify_credentials', ['include_email' => 'true']);
                $name = explode(' ', $getUser->name);
                $array = [
                    "first_name" => $name[0] ?? '',
                    "last_name" => $name[1] ?? '',
                    "phone" => 0,
                    "phone_country_code" => 0,
                    "email" => $getUser->email,
                    "password" => $getUser->id,
                    "status" => 1
                ];
?>
                <script>
                    $.ajax({
                        type: 'POST',
                        url: '<?= root ?>socialsignup',
                        cache: true,
                        dataType: 'html',
                        contentType: false,
                        encode: true,
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        data: {
                            "first_name": '<?php echo $name[0] ?? ''; ?>',
                            "last_name": '<?php echo $name[0] ?? ''; ?>',
                            "phone": 0,
                            "phone_country_code": 0,
                            "email": '<?php echo $getUser->email; ?>',
                            "password": '<?php echo $getUser->id; ?>',
                            "status": 1
                        },
                        success: function(data) {
                            let parser = JSON.parse(data);
                            if (parser.alert != '') {
                                sessionStorage.setItem('alert_msg', parser.alert);
                                window.location.replace(`<?= root ?>${parser.redirect}`);
                            } else {
                                window.location.replace(`<?= root ?>${parser.redirect}`);
                            }
                        },
                        error: function(xhr, text, error) {
                            console.log(text);
                        }
                    });
                </script>
    <?php
            }
        }
    }
}


// Facebook Code S

if (facebook_login == 1) {
    ?>
    <div id="fb-root"></div>
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0&appId=1065505746900715&autoLogAppEvents=1" ></script> -->

    <!-- Facebook javascript sdk -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0&appId=1065505746900715" nonce="r8FKqOid"></script>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                testAPI();
            }
        }

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        window.fbAsyncInit = function() {
            FB.init({
                appId: '<?= facebook_client_id ?>',
                cookie: true,
                xfbml: true,
                version: 'v17.0',
                size:'20px'
            });

            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        };

        function testAPI() {
            FB.api('/me?fields=id,name,email,first_name,last_name', function(response) {
                $.ajax({
                    type: 'POST',
                    url: '<?= root ?>socialsignup',
                    cache: true,
                    dataType: "html",
                    encode: true,
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    data: {
                        first_name: response.first_name,
                        last_name: response.last_name,
                        phone: 0,
                        phone_country_code: 0,
                        email: response.email,
                        password: response.id,
                        status: 1
                    },
                    success: function(data) {
                        let parser = JSON.parse(data);
                        if (parser.alert != '') {
                            sessionStorage.setItem("alert_msg", parser.alert);
                            window.location.replace(parser.redirect);
                        } else {
                            window.location.replace(parser.redirect);
                        }
                    }
                });
            });
        }
    </script>

<?php
}

// Google Javascript Code Start
if (google_login == 1) {
?>
    <!-- GOOGLE BUTTON -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        // GOOGLE LOGIN BUTTON SCRIPT
        function decodeJwtResponseFromGoogleAPI(token) {
            let base64Url = token.split('.')[1]
            let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            let jsonPayload =
                decodeURIComponent(atob(base64).split('').map(function(c) {
                    return '%' + ('00' +
                        c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));
            return JSON.parse(jsonPayload)
        }

        function onSignInGSI(response) {
            responsePayload = decodeJwtResponseFromGoogleAPI(response.credential);
            // console.log(responsePayload);
            $.ajax({
                type: 'POST',
                url: '<?= root ?>socialsignup',
                cache: true,
                dataType: "html",
                contentType: false,
                encode: true,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data: {
                    first_name: responsePayload.given_name,
                    last_name: responsePayload.family_name,
                    phone: 0,
                    phone_country_code: 0,
                    email: responsePayload.email,
                    password: responsePayload.sub,
                    status: 1
                },
                success: function(data) {
                    let parser = JSON.parse(data);
                    if (parser.alert != '') {
                        sessionStorage.setItem("alert_msg", parser.alert);
                        window.location.replace(parser.redirect);
                    } else {
                        window.location.replace(parser.redirect);
                    }
                }
            });
        }

        window.onGoogleLibraryLoad = function() {
            google.accounts.id.initialize({
                client_id: "<?= google_client_id ?>.apps.googleusercontent.com",
                context: 'signin',
                auto_select: true,
                // cancel_on_tap_outside: false,
                callback: onSignInGSI
            });
            google.accounts.id.renderButton(document.getElementById("btnGoogleSignIn"), {
                type: "standard",
                size: "large",
                text: "continue_with",
                logo_alignment: "left",
                width: 400,
                longtitle: true,
                theme: "filled_blue"
            });
        };
        // Google code End
    </script>
<?php
}


// Instagram Php Code Start
//if (instagram_login == 1) {
    
    // if (isset($_GET['code'])) {
    //     $instagramCode = $_GET['code'];
    //     $instagramAccessTokenUrl = 'https://api.instagram.com/oauth/access_token';
    //     $token_change = [
    //         'client_id' => instagram_consumer_key,
    //         'client_secret' => instagram_consumer_secret,
    //         'grant_type' => 'authorization_code',
    //         //  'redirect_uri' => 'https://localhost/v9/Social_Login',   // for local side work
    //          'redirect_uri' => instagram_redirect_url,// for server side work
    //         'code' => $instagramCode,
    //     ];
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $instagramAccessTokenUrl);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $token_change);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $instagramAccessTokenResponse = curl_exec($ch);
    //     curl_close($ch);

    //     $instagramUserData = json_decode($instagramAccessTokenResponse, true);

    //     $accessToken = $instagramUserData['access_token'];
    //     $instagramUserId = $instagramUserData['user_id'];

    //     // Construct the Instagram API URL to fetch user details
    //     $instagramApiUrl = "https://graph.instagram.com/v12.0/{$instagramUserId}?fields=id,username,account_type&access_token={$accessToken}";
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $instagramApiUrl);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $instagramUserDetailsResponse = curl_exec($ch);
    //     curl_close($ch);
    //     $instagramUserDetails = json_decode($instagramUserDetailsResponse, true);
    //     // var_dump($instagramUserDetails);die;
    //     if ($instagramUserDetails) {
    //    // Is function mein Instagram API se username extract kiya ja raha hai.
    //     // Extracted username ko regular expression ka istemal karke alag-alag components mein divide kiya gaya hai.  
    //         preg_match_all('/([a-zA-Z]+)([\._]?[a-zA-Z0-9]+)?/', $instagramUserDetails['username'], $matches);  
    //         $postData = [
    //             'first_name' =>str_replace(['.', '_'], '',$matches[1][0]),
    //             'last_name' => str_replace(['.', '_'], '',$matches[2][0]),
    //             'phone' => 0,
    //             'phone_country_code' => 0,
    //             'email' => 'insta_email',
    //             'password' => $instagramUserDetails['id'],
    //             'status' => 1
    //         ];

    //         echo "<script>
    //     var insta_email = sessionStorage.getItem('insta_email');
    //     var postData = " . json_encode($postData) . ";
    //     postData['email'] = insta_email; 

    //     $.ajax({
    //         type: 'POST',
    //         url: '" . root . "socialsignup',
    //         dataType: 'json',
    //         data: postData,
    //         success: function(parser) {
    //             if (parser.alert !== '') {
    //                 sessionStorage.setItem('alert_msg', parser.alert);
    //                 window.location.replace(parser.redirect);
    //             } else {
    //                 window.location.replace(parser.redirect);
    //             }
    //             console.log(parser);
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             console.error('Error:', errorThrown);
    //         }
    //     });
    // </script>";
    //   }
    //  }
//}
?>